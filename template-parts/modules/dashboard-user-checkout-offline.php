<html lang="en">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<?php

$post = 0;

if(isset($_GET['post']))
    if($_GET['post'])
        $post = get_page_by_path($_GET['post'], OBJECT, 'course');

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

// $user_picture = get_field('profile_img', 'user_' . $post->post_author) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

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

// Long description
$long_description = get_field('long_description', $post->ID);

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
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

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

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        if($course_id == $post->ID)
            $datenr = $item->get_meta_data('Option')[0]->value;
        //Get woo orders from user
        $prijs = get_field('price', $course_id);
        $expenses += $prijs; 
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}
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
if($datenr){
    $datenrs = explode(",", $datenr);
    $dayenr = explode(" ", $datenrs[0])[0]; 
    $monthenr = explode(" ", $datenrs[0])[1]; 
    if($datenrs[2])
        $locationenr = $datenrs[2];
}

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
               <button type="button" class="btn btnFavorite">
                   <i class="fa fa-heart-o"></i>
                    <!-- <i class="fa fa-heart"></i>-->
                   Favorite
               </button>
               <button class="btn btn-share">
                   <i class="fa fa-share-alt"></i>
                   Share
               </button>
           </div>
           <div class="card-info-checkout">
                <?= $long_description; ?>
           </div>
       </div>
        <div class="second-contain">
            <div class="detail-checkout-of">
                <div class="head-element">
                    <p>Event Details</p>
                </div>
                <div class="content">
                    <div id="countdown-timer">
                        <div class="element-contdown">
                            <strong id="days" class="bold-number">118 </strong> <span class="slim-countdown-text">D<span class="hide-words">ays</span><span class="timer"></span></span>
                        </div>
                        <div class="element-contdown">
                            <strong id="hours" class="bold-number"> 14 </strong> <span class="slim-countdown-text">H<span class="hide-words">ours</span><span class="timer"></span></span>
                        </div>
                        <div class="element-contdown">
                            <strong id="mins" class="bold-number"> 36 </strong> <span class="slim-countdown-text">M<span class="hide-words">inutes</span><span class="timer"></span></span>
                        </div>
                        <div class="element-contdown">
                            <strong id="seconds" class="bold-number"> 24 </strong> <span class="slim-countdown-text">S<span class="hide-words">econds</span></span><span class="timer"></span></span>
                        </div>
                    </div>
                    <div class="block-element-detail">
                        <div class="sub-detail-circle">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div>
                            <p class="sub-text-1">Organised by :</p>
                            <p class="sub-text-2"><?= $author_name . ' ' . $author_last_name ?></p>
                            <a href="" class="sub-text-3">View Profile</a>
                        </div>
                    </div>
                    <div class="block-element-detail">
                        <div class="sub-detail-circle">
                            <i class="fas fa-calendar-minus"></i>
                        </div>
                        <div>
                            <p class="sub-text-1">Date and Time</p>
                            <p class="sub-text-2"><?= $datenr ?></p>
                            <a href="#" class="sub-text-3"> <i class="fa fa-calendar"></i> Add to Calendar</a>
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
                            <p class="sub-text-1">AUD</p>
                            <p class="sub-text-2">$<?= $prijs ?></p>
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
            <?php endif; ?>
            <div class="detail-checkout-of">
                <div class="head-element">
                    <p>Others Course</p>
                </div>

                <?php
                $i = 0;
                foreach($enrolled_courses as $course):
                if($course->ID == $post->ID)
                    continue;
                $i++;
                if($i == 4)
                    break;
                ?>
                <div class="element-other-course">
                    <p class="name-other-cours"><?= $course->post_title ?></p>
                    <!-- <div class="d-flex flex-wrap">
                        <p class="tag-category">ux ui design</p>
                        <p class="tag-category">Figma</p>
                    </div> -->
                </div>
                <?php endforeach; ?>
                
                <a href="" class="btn btn-discover-more">Discover more</a>
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