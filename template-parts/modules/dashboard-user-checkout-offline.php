<html lang="en">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<?php
// require_once dirname(__FILE__ , 3) . '/templates/checkout.php';

$post = 0;

$user = wp_get_current_user();

if(isset($_GET['post']))
    if($_GET['post'])
        $post = get_page_by_path($_GET['post'], OBJECT, 'course');

$mandatory= false;
if(isset($_GET['man']))
    $mandatory = true;

if($post):

/* * Informations course * */

// Coursetype
$course_type = get_field('course_type', $post->ID);

// Image
$image = get_field('preview', $post->ID)['url'];
if(!$image):
    $image = get_the_post_thumbnail_url($post->ID);
    if(!$image)
        $image = get_field('url_image_xml', $post->ID);
    if(!$image)
        $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
endif;
// Author
$author = get_user_by('ID', $post->post_author);
$author_name = $author->first_name ?: $author->display_name;
$author_last_name = $author->last_name ?: '';

// Categories
$categories = array();
$posttags = get_the_tags();
if(!$posttags){
    $category_default = get_field('categories', $post->ID);
    $category_xml = get_field('category_xml', $post->ID);
    if(!empty($category_default))
        $categories = $category_default;
    else if(!empty($category_xml))
        $categories = $category_xml;
}

// Long/Short description
$long_description = get_field('long_description', $post->ID);
$short_description = get_field('short_description', $post->ID);

//Prijs
$price = " ";
$price = get_field('price', $course->ID);
if($price != "0")
    $prijs = number_format($p, 2, '.', ',');
else
    $prijs = 'Gratis';

/* * Informations reservation * */
//Orders - enrolled courses 
$datenr = 0; 
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'Mei', '06' => 'Juni', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

$enrolled = array();
$enrolled_courses = array();
$args = array(
    'customer_id' => $user->ID,
    'post_status' => array_keys(wc_get_order_statuses()),
    'post_status' => array('wc-processing'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);
$bool = false;
foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        if($course_id == $post->ID){
            $datenr = $item->get_meta_data('Option')[0]->value;
            $bool = true;
        }
        //Get woo orders from user 
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}

//Enrolled with Stripe
$enrolled_stripe = list_orders($user->ID)['ids'];
if(!empty($enrolled_stripe))
if(in_array($post->ID, $enrolled_stripe))
    $bool = 1;

if(!$bool)
    header('Location: /dashboard/user/activity?message=You need to register at this course first !' );

if(!empty($enrolled))
{
    $args = array(
        'post_type' => 'course', 
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => $enrolled,  
    );
    $enrolled_courses = get_posts($args);
}
$locationenr = "Online";
$yearenr = date("Y");

//Check with stripe | metadata
if(!$datenr):
    global $wpdb;
    $table = $wpdb->prefix . 'stripe_order';

    $sql_orders_stripe = $wpdb->prepare("SELECT course_id FROM $table WHERE owner_id = $user->ID AND course_id = $post->ID");
    $orders_stripe = $wpdb->get_results($sql_orders_stripe);
    if(isset($orders_stripe[0])):
        $orderStripe = $orders_stripe[0];
        if($orderStripe->course_id):
            $postStripe = get_post($orderStripe->course_id);
            if($postStripe)
                $datenr = $orderStripe->metadata;
        endif;
    endif;
endif;


if($datenr){
    $datenrs = explode(",", $datenr);
    $dayenr = explode(" ", $datenrs[0])[0]; 
    $monthenr = explode(" ", $datenrs[0])[1]; 
    if(isset($datenrs[2]))
        if($datenrs[2])
            $locationenr = $datenrs[2];
    if(isset($datenrs[3]))
        if($datenrs[3])
            $yearenr = $datenrs[3];
}


// Saved courses
$favorite = '<button type="button" id="' . $user->ID ."_". $post->ID . '_course" class="btn btnFavorite btn_favourite">
                <i class="fa fa-heart"></i>
                Favorite
            </button>';
$unfavorite = '<button type="button" id="' . $user->ID ."_". $post->ID . '_course" class="btn btnFavorite ">
                    <i class="fa fa-heart-o"></i>
                    Favorite
               </button>';

$raw_saved = get_user_meta($user->ID, 'course');
$favorite_status = $unfavorite;
if(in_array($post->ID, $raw_saved))
    $favorite_status = $favorite;

/* * State actual details * */
//Get read by user 
$args = array(
    'post_type' => 'progression', 
    'title' => $post->post_name,
    'post_status' => 'publish',
    'author' => $user->ID,
    'posts_per_page'         => 1,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false
);
$progressions = get_posts($args);
if(empty($progressions)){
    //Create progression
    $post_data = array(
        'post_title' => $post->post_name,
        'post_author' => $user->ID,
        'post_type' => 'progression',
        'post_status' => 'publish'
    );
    $progression_id = wp_insert_post($post_data);
}
else
    $progression_id = $progressions[0]->ID;
//Finish read
$is_finish = get_field('state_actual', $progression_id);

//Button agreement event
$bool_participate = false;
$month_calendar = array_search($monthenr, $calendar);
$date_event = $dayenr . "." . $month_calendar . "." . $yearenr;
$date_now = strtotime(date('Y-m-d'));
$this_date = strtotime($date_event);

if($this_date <= $date_now && !$is_finish)
    $bool_participate = true;

?>

<body>
<div class="content-checkout-of">
    <div class="head-checkout-of d-flex">
        <div class="date-block">
            <div class="moth">
                <p><?= $monthenr ?></p>
            </div>
            <p class="date-time"><?= $dayenr ?></p>
        </div>
        <div>
            <p class="title-course-chechout-of"><?= $post->post_title ?></p>
            <div class="d-flex flex-wrap">
                <div class="map-block d-flex">
                    <i class="fa fa-video-camera"></i>
                    <p>Offline Event</p>
                </div>
                <ul class="d-flex">
                    <li>Starts on <?= $datenr; ?></li>
                    <li>1h</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="d-flex contain-checkout-of">
       <div class="first-contain">
           <div class="blockImgCheckoutOf">
               <img src="<?= $image; ?>" alt="">
           </div>
           <div class="d-flex justify-content-center groupBtn-checkout-of">
               <?=
               $favorite_status
               ?>
               <!-- 
                <button class="btn btn-share">
                   <i class="fa fa-share-alt"></i>
                   Share
               </button> 
                -->
           </div>
           <div class="card-info-checkout">
                <?= $long_description; ?>
           </div>

            <?php
            if($bool_participate):
            ?>
            <div class="card-info-checkout">
                <form action="" method="POST">
                    <input type="hidden" name="course_read" value="<?= $post->post_name ?>">
                    <button class="btn btn-next ml-auto btn btn-primary" name="valid_offline" type="submit">
                        I already participate to this event &nbsp;
                        <i class="fa fa-angle-right"></i>
                    </button>
                </form>
            </div>
            <?php
            endif;
            ?>

       </div>
        <div class="second-contain">
            <div class="detail-checkout-of">
                <div class="head-element">
                    <p>Event Details</p>
                </div>
                <?php
                    $countdown_day = 0;
                    $countdown_hour = 0;
                    $countdown_minute = 0;
                    $countdown_second = 0;

                    $draw_time = $dayenr .'/'. $month_calendar . '/' . $yearenr;
                    $date = DateTime::createFromFormat("d/m/Y", $draw_time);
                    $currentDateTime = new DateTime('now');

                    if($date){
                        $countdown_day = $date->diff($currentDateTime)->format("%a");
                        $countdown_hour = $date->diff($currentDateTime)->format("%H");
                        $countdown_minute = $date->diff($currentDateTime)->format("%i");
                        $countdown_second = $date->diff($currentDateTime)->format("%s");
                        echo $date->diff($currentDateTime)->format("%a days and %H hours and %i minutes and %s seconds");
                    }
                ?>
                <div class="content">
                    <!-- <div id="countdown-timer">
                        <div class="element-contdown">
                            <strong id="days" class="bold-number"><?= $countdown_day ?> </strong> <span class="slim-countdown-text">D<span class="hide-words">ays</span><span class="timer"></span></span>
                        </div>
                        <div class="element-contdown">
                            <strong id="hours" class="bold-number"> <?= $countdown_hour ?>  </strong> <span class="slim-countdown-text">H<span class="hide-words">ours</span><span class="timer"></span></span>
                        </div>
                        <div class="element-contdown">
                            <strong id="mins" class="bold-number"> <?= $countdown_minute ?>  </strong> <span class="slim-countdown-text">M<span class="hide-words">inutes</span><span class="timer"></span></span>
                        </div>
                        <div class="element-contdown">
                            <strong id="seconds" class="bold-number"> <?= $countdown_second ?>  </strong> <span class="slim-countdown-text">S<span class="hide-words">econds</span></span><span class="timer"></span></span>
                        </div>
                    </div> -->
                    <div class="block-element-detail">
                        <div class="sub-detail-circle">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <p class="sub-text-1">Organised by :</p>
                            <p class="sub-text-2"><?= $author_name . ' ' . $author_last_name ?></p>
                            <a href="/user-overview?id=<?php echo $author->ID; ?>" class="sub-text-3">View Profile</a>
                        </div>
                    </div>
                    <div class="block-element-detail">
                        <div class="sub-detail-circle">
                            <i class="fas fa-calendar-minus"></i>
                        </div>
                        <div>
                            <p class="sub-text-1">Date and Time</p>
                            <p class="sub-text-2"><?= $datenr ?></p>
                            <?php
                                $text_calendar = "Livelearn - " . $post->post_title;
                                $hourenr = explode(':', $datenrs[1]);
                                $startenr = $yearenr .''. $month_calendar .''. $dayenr;
                                $starthourenr = $hourenr[0] . $hourenr[1] . "00";
                                $finishourenr = ($hourenr[0] == 24) ? "01" . '' . $hourenr[1] . "00" : "0" . (intval($hourenr[0]) + 1) . '' . $hourenr[1] . "00";
                                $date_calendar = $startenr . 'T'. $starthourenr . '/' . $startenr . 'T' . $finishourenr;

                                $informations_calendar = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=" . $text_calendar . "&details=" . $short_description . "&dates=" . $date_calendar . "&location=" . $locationenr;

                            ?>
                            <a href="<?= $informations_calendar ?>" class="sub-text-3"> <i class="fa fa-calendar"></i> Add to Calendar</a>
                        </div>
                    </div>
                    <div class="block-element-detail">
                        <div class="sub-detail-circle">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p class="sub-text-1">Location</p>
                            <p class="sub-text-2"><?php if(isset($locationenr)) echo $locationenr; ?></p>
                        </div>
                    </div>
                    <div class="block-element-detail">
                        <div class="sub-detail-circle">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <div>
                            <p class="sub-text-1">EURO</p>
                            <p class="sub-text-2"><?= $prijs ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if(!empty($categories)):
            ?>
            <div class="detail-checkout-of">
                <div class="head-element">
                    <p>Topics</p>
                </div>
                <div class="group-topic-course d-flex flex-wrap">
                    <?php
                    $read_category = array();
                    foreach($categories as $item)
                        if($item)
                        if(!in_array($item['value'],$read_category)){
                            array_push($read_category,$item['value']);
                            echo"<p>" . (String)get_the_category_by_ID($item['value']) . "</p>";
                        }
                    ?> 
                </div>
            </div>
            <?php endif;
            if($mandatory): 
            //Mandatory 
            $args = array(
                'post_type' => 'mandatory', 
                'title' => $post->post_name,
                'post_status' => 'publish',
                'author' => $user->ID,
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );
            $mandatorie = get_posts($args); 
            if(!empty($mandatorie)):
            //Further informations for mandator
            $done_must = get_field('done_must', $mandatorie[0]->ID);
            $valid_must = get_field('valid_must', $mandatorie[0]->ID);
            $point_must = get_field('point_must', $mandatorie[0]->ID);
            $manager_must = get_field('manager_must', $mandatorie[0]->ID);
            $manager_name_must = (isset($manager_must->first_name)) ? $manager_must->first_name : $manager_must->display_name;
            ?>
            <div class="card-strat-block card-Course card-feature">
                <p class="title-card-strat-block">Mandatory</p>
                <div class="element-card-features">
                    <p class="title-element">Manager</p>
                    <p class="text-number"><?= $manager_name_must; ?></p>
                </div>
                <div class="element-card-features">
                    <p class="title-element">Points</p>
                    <p class="text-number"><?= $point_must ?></p>
                </div>
                <div class="element-card-features">
                    <p class="title-element">Valid (days)</p>
                    <p class="text-number"><?= $valid_must ?></p>
                </div>
                <div class="element-card-features">
                    <p class="title-element">Must be done by</p>
                    <p class="text-number"><?= $done_must ?></p>
                </div>
            </div>
            <?php
            endif;
            endif;
            ?>
            <div class="detail-checkout-of">
                <div class="head-element">
                    <p>Others Course</p>
                </div>
                
                <?php
                $x = 0;
                $offline = ['Opleidingen', 'Training', 'Workshop', 'Masterclass', 'Event'];
                foreach($enrolled_courses as $course):
                if($course->ID == $post->ID)
                    continue;

                if($x == 4)
                    break;
                $x++;


                //Course Type
                $course_type = get_field('course_type', $course->ID);
                
                //Checkout URL
                if(in_array($course_type, $offline))
                    $href_checkout = "/dashboard/user/checkout-offline/?post=" . $course->post_name;
                else if($course_type == 'Video')
                    $href_checkout = "/dashboard/user/checkout-video/?post=" . $course->post_name;
                else if($course_type == 'Podcast')
                    $href_checkout = "/dashboard/user/checkout-podcast/?post=" . $course->post_name;
                else
                    $href_checkout = "#";


                // Categories
                $categories = array();
                $posttags = get_the_tags();
                if(!$posttags){
                    $category_default = get_field('categories', $course->ID);
                    $category_xml = get_field('category_xml', $course->ID);
                    if(!empty($category_default))
                        $categories = $category_default;
                    else if(!empty($category_xml))
                        $categories = $category_xml;
                }

                ?>
                <div href="<?= $href_checkout; ?>" class="element-other-course">
                    <a href="<?= $href_checkout; ?>" class="name-other-cours"><?= $course->post_title ?></a>
                    <div class="d-flex flex-wrap">
                        <?php
                        $read_category = array();
                        $i = 0;
                        foreach($categories as $item){
                            if($i == 3)
                                break;
                            if($item)
                                if(!in_array($item['value'],$read_category)){
                                    $i++;
                                    array_push($read_category,$item['value']);
                                    echo"<a href='/category-overview?category=" . $item['value'] . "' class='tag-category'>" . (String)get_the_category_by_ID($item['value']) . "</a>";
                                }
                        }
                        ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <a href="/dashboard/user/activity" class="btn btn-discover-more">Discover more</a>
            </div>
        </div>
    </div>
</div>
<?php
else:
    echo "<p> This content is no more available !</p>";
endif;
?>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(".btnFavorite").click((e)=>
    {
        
        btn_id = e.target.id;
        meta_key = btn_id.split("_")[2];
        id = btn_id.split("_")[1];
        user_id = btn_id.split("_")[0];

        alert(e.target);
        $.ajax({
            url:"/like",
            method:"post",
            data:{
                meta_key : meta_key,
                id : id,
                user_id : user_id,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                if(e.target.innerHTML == "<?php echo $favorite; ?>")
                {
                    e.target.html("<?php echo $unfavorite; ?>");
                }
                else
                {
                    e.target.html("<?php echo $favorite; ?>");
                }
            }
        });
    })
</script>

<script>
    const daysEl = document.getElementById('days');
    const hoursEl = document.getElementById('hours');
    const minsEL = document.getElementById('mins');
    const secondsEL = document.getElementById('seconds');

    const newYears = '20 June 2021';

    function countdown() {
        const newYearsDate = new Date(newYears);
        const currentDate = new Date();

        const totalSeconds = (newYearsDate - currentDate) /1000;
        const minutes = Math.floor(totalSeconds/ 60) % 60;
        const hours = Math.floor(totalSeconds /3600) % 24;
        const days = Math.floor(totalSeconds /3600/ 24);
        const seconds = Math.floor(totalSeconds) % 60;


        daysEl.innerText = days;
        hoursEl.innerText = hours;
        minsEL.innerText = minutes;
        secondsEL.innerText = seconds;


    }

    setInterval(countdown, 1000);
</script>
</body>