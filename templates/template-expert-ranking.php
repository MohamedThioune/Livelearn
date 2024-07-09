<?php /** Template Name: expert ranking */ ?>

<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<script src="https://js.stripe.com/v3/"></script>
<script src="checkout.js" defer></script>

<?php
global $wpdb;
$pricing = 0;
// View table name
$table_tracker_views = $wpdb->prefix . 'tracker_views';

// Get id of courses viewed from db
/*
    $sql_request = $wpdb->prepare("SELECT data_id FROM $table_tracker_views  WHERE user_id = $user_connected_id ");
    $all_user_views = $wpdb->get_results($sql_request);
    $id_courses_viewed = array_column($all_user_views,'data_id'); //all cours viewing by this user.
    $expert_from_database = array();
*/

$purchantage_on_top = 0;
$purchantage_on_bottop = 0;
$args = array(
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);

$bunch_orders = wc_get_orders($args);
$today = new DateTime();
$current_year = date('Y');
$start_of_current_year = $current_year . '-01-01';
$start_of_last_year = ($current_year - 1) . '-01-01';
$current_date = current_time('Y-m-d');

/*
* Check statistic by user *
*/
$users = get_users();
$user_connected_id = get_current_user_id();
$numbers = array();
$members = array();
$numbers_count = array();
$topic_views = array();
$topic_followed = array();
$stats_by_user = array();

foreach ($users as $user) {
    $topic_by_user = array();
    $course_by_user = array();

    //Object & ID member
    array_push($numbers, $user->ID);
    array_push($members, $user);

    //Views topic
    $args = array(
        'post_type' => 'view',
        'post_status' => 'publish',
        'author' => $user->ID,
    );
    $views_stat_user = get_posts($args);
    $stat_id = 0;
    if(!empty($views_stat_user))
        $stat_id = $views_stat_user[0]->ID;
    $view_topic = get_field('views_topic', $stat_id);
    if($view_topic)
        array_push($topic_views, $view_topic);

    $view_user = get_field('views_user', $stat_id);
    $number_count['id'] = $user->ID;
    $number_count['digit'] = 0;
    if(!empty($view_user))
        $number_count['digit'] = count($view_user);
    if($number_count)
        array_push($numbers_count, $number_count);

    $view_course = get_field('views', $stat_id);

    //Followed topic
    $topics_internal = get_user_meta($user->ID, 'topic_affiliate');
    $topics_external = get_user_meta($user->ID, 'topic');
    $topic_followed  = array_merge($topics_internal, $topics_external, $topic_followed);

    //Stats engagement
    $stat_by_user['user'] = $view_user;
    $stat_by_user['topic'] = $view_topic;
    $stat_by_user['course'] = $view_course;
    array_push($stats_by_user, $stat_by_user);
}
    $topic_views_sorting = $topic_views[5];
    if(!$topic_views_sorting)
        $topic_views_sorting = array();

    $topic_views_id = array_column($topic_views_sorting, 'view_id');
    $keys = array_column($numbers_count, 'digit');
    array_multisort($keys, SORT_DESC, $numbers_count);

    $most_active_members = array();
    if(!empty($numbers_count))
        foreach ($numbers_count as $element) {
            $value = get_user_by('ID', $element['id']);
            $value->image_author = get_field('profile_img',  'user_' . $value->ID);
            $value->image_author = $value->image_author ?: get_stylesheet_directory_uri() . '/img/iconeExpert.png';
            array_push($most_active_members, $value);
        }
    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }
$subtopics = array();
$topics = array();
foreach($categories as $categ){
    //Topics
    $topicss = get_categories(
        array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        )
    );
    $topics = array_merge($topics, $topicss);

    foreach ($topicss as  $value) {
        $subtopic = get_categories(
            array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $value->cat_ID,
                'hide_empty' => 0,
                //  change to 1 to hide categores not having a single post
            )
        );
        $subtopics = array_merge($subtopics, $subtopic);
    }
}


?>
<?php get_header(); ?>
    <!-- <div class="onze-expert-block">
        <div class="container-fluid">
            <div class="headCollections">
                <div class="dropdown show">
                    <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownHuman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Onze top experts binnen <b id="complete-categorien">Alle categorieën</b>
                    </a>
                    <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownHuman">
                        <select class="form-select selectSearchHome" name="search_type" id="topic_search" multiple="true">
                            <?php
                            foreach($topics as $category)
                                echo '<option value="' . $category->cat_ID . '">' . $category->cat_name . '</option>';
                            ?>
                        </select>
                    </div>
                    <div id="loader" class="spinner-border spinner-border-sm text-primary d-none" role="status"></div>
                </div>
                period 
                <div class="dropdown show">
                    <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownHuman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Over de <b id="complete-period">All time</b>
                    </a>
                    <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownHuman">
                        <select class="form-select selectSearchHome" id="period" multiple>
                            <option value="all">All time</option>
                            <option value="lastweek">Last 7 days</option>
                            <option value="lastmonth">Last 1 month</option>
                            <option value="lastyear">Last 1 year</option>
                        </select>
                    </div>
                </div>
                period 
                <a href="/voor-opleiders/" class="zelf-block">
                    <p class="mr-2">Zelf ook een expert? </p>
                    <div class="all-expert">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/finger.png" alt="">
                    </div>
                </a>
            </div>
            <div class="row" id="autocomplete_categorieen">
                <?php
                $num = 1;
                if(!empty($most_active_members)){
                    //for($i = count($most_active_members); $i>0; $i--) {
                    foreach ($most_active_members as $index => $user) {
                        if ($num == 13)
                            break;

                        //get pricing from price of course
                        foreach ($bunch_orders as $order) {
                            foreach ($order->get_items() as $item) {
                                //Get woo orders from user
                                if (!$item)
                                    continue;

                                $id_course = intval($item->get_product_id()) - 1;
                                $course = get_post($id_course);
                                if (!$course)
                                    continue;

                                $prijs = get_field('price', $id_course);
                                $favorited = get_field('favorited', $id_course); // BD
                                $sql_request = $wpdb->prepare("SELECT occurence  FROM $table_tracker_views  WHERE  data_id = $course->ID");
                                $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                                $tracker_views = intval($number_of_this_is_looking) ?: 0;

                                //var_dump($prijs); //also null usualy
                                if ($course->ID) {
                                    if ($course->post_author == $user->ID) { // $user->ID = expert
                                        if ($prijs) {
                                            $pricing = $pricing + $prijs * 20;
                                        }
                                        if ($favorited)
                                            $pricing = $pricing + 40;
                                        if ($tracker_views)
                                            $pricing = $pricing + 15 + 1; // views and click
                                    }
                                    $pricing = $pricing + 100;
                                }
                            }
                        }
                        //get pricing from price of course

                        /* get price from post doing by user for free course */
                        $args = array(
                            'post_type' => array('course', 'post'),
                            'author' => $user->ID,
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'order' => 'DESC',
                            //'date'=>get_the_date('Y-m-d'),
                        );
                        $courses_doing_by_this_user = get_posts($args);
                        foreach ($courses_doing_by_this_user as $course) {
                            $course_type = get_field('course_type', $course->ID);
                            $prijs = get_field('price', $course->ID) ? intval(get_field('price', $course->ID)) : 0;
                            $sql_request = $wpdb->prepare("SELECT occurence  FROM $table_tracker_views  WHERE  data_id = $course->ID");
                            $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                            $tracker_views = intval($number_of_this_is_looking) ?: 0;

                            $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                            //$reaction = get_field('reaction', $course->ID);

                            //get pricing from type of course: course free
                            if ($course_type == 'Artikel') {
                                $pricing = $pricing + 50;
                                if ($tracker_views != 0) {
                                    $pricing = $pricing + $tracker_views * 1.25; //views+click
                                }
                                if ($favorited) {
                                    $pricing = $pricing + 5; // nombre de fois où le cours est liké
                                }
                            } else if ($course_type == 'Podcast') {
                                $pricing = $pricing + 100;
                                if ($favorited) {
                                    $pricing = $pricing + 10;
                                }
                            } else if ($course_type == 'Video') {
                                $pricing = $pricing + 75;
                                if ($tracker_views != 0) {
                                    $pricing = $pricing + $tracker_views * 3.5; //views+click+
                                }
                            } else {
                                $pricing = $pricing + 100;
                                if ($favorited) {
                                    $pricing = $pricing + 20;
                                }
                                if ($tracker_views != 0) {
                                    $pricing = $pricing + $tracker_views * 10;
                                }
                            }
                        }
                        /* get price from post doing by user for free course */

                        /**
                         * put points on object user
                         */
                        $user->pricing = $pricing;
                        /**
                         * Get purchantages (courses courent year)/(courses last year)
                         */

                        // args to get artikel of current year
                        $args_current_year = array(
                            'post_type' =>'post',// array('post', 'course'),
                            'post_status' => array('wc-processing', 'wc-completed'),
                            'orderby' => 'date',
                            'order' => 'DESC',
                            'limit' => -1,
                            'author' => $user->ID,
                            'date_query'=>array(
                                array(
                                    'after' => $start_of_current_year,
                                    'before' => $start_of_last_year,
                                    'inclusive' => true,
                                ),
                            ),
                        );
                        $courses_current_year = get_posts($args_current_year);
                        // args to get artikel of last year
                        $args_last_year = array(
                            'date_query' => array(
                                'after'     => $start_of_last_year,
                                'before'    => $current_year . '-01-01',
                                'inclusive' => true,
                            ),
                            'author' => $user->ID,
                            'post_type'      => 'post',
                            'posts_per_page' => -1, // Récupérer tous les articles de l'année passée
                        );
                        $courses_last_year = get_posts($args_last_year);
                        $purchantage_on_top = $purchantage_on_top + count($courses_last_year);
                        $purchantage_on_bottop = $purchantage_on_bottop + count($courses_current_year);
                        $purcent = $purchantage_on_bottop ? number_format(( $purchantage_on_top/$purchantage_on_bottop )*100  , 2, '.', ',') : $purchantage_on_top;

                        $image_user = get_field('profile_img',  'user_' . $user->ID);
                        // var_dump($image_user);
                        // die();
                        $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/iconeExpert.png';

                        $company = get_field('company',  'user_' . $user->ID);
                        $company_title = $company[0]->post_title;
                        $company_logo = get_field('company_logo', $company[0]->ID);

                        if(isset($user->first_name) || isset($user->last_name))
                            $display_name = $user->first_name . ' ' . $user->last_name;
                        else
                            $display_name = $user->display_name;

                        if(!$display_name || $display_name == " ")
                            $display_name = "Anonym";
                        ?>
                        <a href="/dashboard/user-overview/?id=<?php echo $user->ID; ?>" target="_blank" class="col-md-4">
                            <div class="boxCollections">
                                <p class="numberList"><?php echo $num++ ; ?></p>
                                <div class="circleImgCollection">
                                    <img src="<?php echo $image_user ?>" alt="">
                                </div>
                                <div class="secondBlockElementCollection">
                                    <p class="nameListeCollection"><?= $display_name ?></p>
                                    <div class="blockDetailCollection">
                                        <div class="iconeTextListCollection">
                                            <img src="<?= $company_logo ?>" alt="">
                                            <p><?= $company_title; ?></p>
                                        </div>
                                        <div class="iconeTextListCollection">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-brain.png" alt="">
                                            <p class="number-brain"><?=number_format($user->pricing, 2, '.', ',')?></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="pourcentageCollection"><?= $purcent ?>%</p>
                            </div>
                        </a>
                    <?php }
                }else
                    echo '<p class="verkop"> Geen deskundigen beschikbaar </p>';
                ?>
            </div>
        </div>
    </div> -->
<body>

<div class="contentProfil">
    <h1 class="titleSubscription">Checkout - sample</h1>
    <!-- <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span><br><br>"?></center> -->

    <div class="contentFormSubscription">

        <!-- <form action="" method="POST"> -->

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">First name</label>
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="first_name" value="<?= $current_user->first_name ?>" placeholder="First name" name="first_name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Last name</label>
                    <i class="fas fa-users" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="last_name" value="<?= $current_user->last_name ?>" placeholder="Last name" name="last_name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="bedrjifsnaam">Email</label>
                <i class="fas fa-building" aria-hidden="true"></i>
                <input type="email" class="form-control" id="" value="<?= $company_connected ?>" placeholder="Email" name="email" required>
            </div>
            <div class="form-group">
                <label for="city">Company name</label>
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                <input type="text" class="form-control" id="" value="" placeholder="Company name" name="name_company">
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="phone">Phone number</label>
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <input type="number" class="form-control" id="phone" value="<?= $telnr ?>" placeholder="Phone number" name="phone" required>
                </div>
            </div>
            <div class="form-group">
                <label for="factuur_address">Factuur Adress</label>
                <i class="fas fa-thumbtack"></i>
                <input type="text" class="form-control" id="factuur_address" value="" placeholder="Factuur Adress" name="factuur_address">
            </div>
            <div class="form-group">
                <label for="">Additional information</label>
                <i class="fas fa-thumbtack"></i>
                <textarea class="form-control" id="" value="" placeholder="Notes about your order ..." name="additional_info">
                </textarea>
            </div>

            <!-- <div class="form-group">
                <div class="checkSubs">
                    <div class="form-check">
                        <input class="form-check-input credit-card" type="radio" name="payement" id="method_payment" value="credit_card" >
                        <label class="form-check-label" for="creditcard">
                            Credit card 
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payement" id="method_payment" value="invoice" checked>
                        <label class="form-check-label" for="invoice">
                            Invoice
                        </label>
                    </div>
                </div>
            </div> -->

            <div class="modal-footer">
                <button type="button" id="starter" class="btn btn-sendSubscrip">Start</button>
                <div hidden="true" id="loader" class="spinner-border spinner-border-sm text-primary" role="status"></div>
            </div>
        <!-- </form> -->

    </div>

</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>

    function show1(){
        document.getElementById('payementCard').style.display ='none';
    }
    function show2(){
        document.getElementById('payementCard').style.display = 'block';
    }

    $(document).ready(function(){
        $("#is_trial").change(function() {
            if(this.checked) {
                $("#starter").text("Start Trial");
            } else {
                $("#starter").text("Start")
            }
        });
    });

</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#topic_search').change(function(){
            var topic_search = $("#topic_search option:selected").val();
            var complete_categorieen = $("#topic_search option:selected").text();
            $('#complete-categorien').html(complete_categorieen);

            $.ajax({
                url:"/fetch-ajax-home2",
                method:"post",
                data:{
                    topic_search: topic_search,
                },
                dataType: "text",
                beforeSend:function (elt) {
                    $('#loader').removeClass('d-none');
                    console.log('before sending...',topic_search)
                },
                success: function(data){
                    console.log('elt : ',data);
                    $('#autocomplete_categorieen').html(data);
                },
                error: function (err) {
                    console.log('error : ',err);
                },
                complete:function (complete) {
                    $('#loader').addClass('d-none');
                }
            });
        });
    </script>

    <script>
        $('#period').change(function(){
            var selectedOptions = $(this).find("option:selected")[0];
            var period = selectedOptions.value;
            var complete_period = selectedOptions.text;
            $('#complete-period').html(complete_period);
            $.ajax({
                url:"/fetch-ajax-home2",
                method:"post",
                data:{
                    period: period,
                },
                dataType: "text",
                beforeSend:function (elt) {
                    $('#loader').removeClass('d-none');
                    console.log('before sending...',period)
                },
                success: function(data){
                    console.log('elt');
                    $('#autocomplete_categorieen').html(data);
                },
                error: function (error) {
                    console.log('error : ',error);
                },
                complete:function (complete) {
                    $('#loader').addClass('d-none');
                    console.log(complete)
                }
            });
        });
    </script>

<?php get_footer(); ?>