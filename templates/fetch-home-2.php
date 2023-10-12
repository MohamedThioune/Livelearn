<?php /** Template Name: Fetch ajax home2 */ ?>

<?php

extract($_POST);

$page = 'check_visibility.php';
require($page);

/*
* Check statistic by user *
*/
$users = get_users();
$numbers = array();
$members = array();
$numbers_count = array();
$topic_views = array();
$topic_followed = array();
$stats_by_user = array();

// View table name
$current_user = get_current_user_id();
$table_tracker_views = $wpdb->prefix . 'tracker_views';
// Get id of courses viewed from db
$sql_request = $wpdb->prepare("SELECT data_id FROM $table_tracker_views  WHERE user_id = $current_user ");
$all_user_views = $wpdb->get_results($sql_request);
$id_courses_viewed = array_column($all_user_views,'data_id'); //all cours viewing by this user.
$expert_from_database = array();
/**
 * get experts doing the course by database
 */
foreach ($id_courses_viewed as $id_course) {
    $course = get_post($id_course);
    $expert_id = $course->post_author;
    //if ($expert_id)
        $expert_from_database[] = $expert_id;
}
$expert_from_database = array_unique($expert_from_database);

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
        $value->image_author = get_field('profile_img', 'user_' . $value->ID);
        $value->image_author = $value->image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

        array_push($most_active_members, $value);
    }
if(isset($topic_search)){

    if($topic_search != 0){    
        $categories_topic = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'orderby'    => 'name',
            'parent'     => $topic_search,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
    }

    $args = array(
        'post_type' =>'post',// array('post', 'course'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
    );

    $global_blogs = get_posts($args);

    $teachers = array();
    $teachers_all = array();

    $categoriees = array(); 

    if(isset($categories_topic))
        foreach($categories_topic as $category)
            array_push($categoriees, $category->cat_ID);

    foreach($global_blogs as $blog)
    {
        /*
        * Categories
        */ 
        $category_id = 0;
        $experts = get_field('experts', $blog->ID);

        $category_default = get_field('categories',  $blog->ID);
        $categories_xml = get_field('category_xml',  $blog->ID);
        $categories = array();

        /*
        * Merge categories from customize and xml
        */
        if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if($item['value'])
                    if(!in_array($item['value'], $categories))
                        array_push($categories, $item['value']);
                
        else if(!empty($category_xml))
            foreach($category_xml as $item)
                if($item)
                    if($item['value'])
                        if(!in_array($item['value'], $categories))
                            array_push($categories, $item['value']);

        foreach($categoriees as $categoriee){
            if($categories)
                if(in_array($categoriee, $categories)){
                    /*
                    ** Push experts 
                    */ 
                    if(!in_array($blog->post_author, $teachers))
                        array_push($teachers, $blog->post_author);

                    foreach($experts as $expertie)
                        if(!in_array($expertie, $teachers))
                            array_push($teachers, $expertie);
                    /*
                    **
                    */ 
                    break;                
                }
        }
        /*
        * 
        */ 
    }
    $num = 0;
    $bool = false;
    $data = array();
    $block = '';
    $purchantage_on_top = 0;
    $purchantage_on_bottop = 0;
    $purchantage = array();
    $numberGray = array();
//    for ($i = 0; $i< count($most_active_members)*3; $i++){
//     $purchantage[] = rand(20,99);
//     $numberGray [] = rand(0,100000);
//    }
    $numberGray = array_unique($numberGray);
    //$purchantage = array_unique($purchantage);
    rsort($purchantage);
    rsort($numberGray);
    $pricing = 0;

    //get pricing from price of course
    //get point from a user
    $args = array(
        'post_status' => array('wc-processing', 'wc-completed'),
        'orderby' => 'date',
        'order' => 'DESC',
        'limit' => -1,
    );
    $bunch_orders = wc_get_orders($args);
    //$teachers = $expert_from_database;
    for($j=0; $j< count($most_active_members); $j++) {
        $user = $most_active_members[$j];
        if($num==12)
            break;
        if(!in_array($user->ID, $teachers))
            continue;
        //get pricing from price of course
        foreach ($bunch_orders as $order) {
            foreach ($order->get_items() as $item) {
                //Get woo orders from user
                $id_course = intval($item->get_product_id()) - 1;
                $course = get_post($id_course);
                $prijs = get_field('price', $id_course);
                $favorited = get_field('favorited',$id_course);
                $tracker_views = get_field('tracker_views', $course->ID);
                //var_dump($prijs); //also null usualy
                if ($course->ID) {
                    if ($course->post_author == $user->ID) { // $user->ID = expert
                        if ($prijs)
                            $pricing = $pricing + $prijs * 20;
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
            //var_dump('<->',$course->post_date);
            $course_type = get_field('course_type', $course->ID);
            $prijs = get_field('price', $course->ID);
            $tracker_views = get_field('tracker_views', $course->ID);
            $tracker_views = $tracker_views ?  : 0;
            $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
            //$reaction = get_field('reaction', $course->ID);

            //get pricing from type of course: course free
            if(!$prijs) {
                if ($course_type == 'Artikel') {
                    $pricing = $pricing + 50;
                    if ($tracker_views !=0) {
                        $pricing = $pricing + 1.25; //views+click
                    }
                    if ($favorited){
                        $pricing = $pricing + 5;
                    }
                }
                else if ($course_type == 'Podcast') {
                    $pricing = $pricing + 100;
                    if ($favorited){
                        $pricing = $pricing + 10;
                    }
                }
                else if ($course_type == 'Video') {
                    $pricing = $pricing + 75;
                    if ($tracker_views !=0) {
                        $pricing = $pricing + 3.5; //views+click+
                    }
                }elseif ($course_type == 'Opleidingen' || $course_type == 'Training' || $course_type == 'Webinar' || $course_type == 'Workshop'){
                    $pricing = $pricing + 100;
                    if ($favorited){
                        $pricing = $pricing + 20;
                    }
                    if ($tracker_views !=0) {
                        $pricing = $pricing + 10;
                    }
                }
            }
        }
        /* get price from post doing by user for free course */

        /**
         * put points on object user
         */
        $user->pricing = $pricing?:0;
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
        $bool = true;
        $image_user = get_field('profile_img',  'user_' . $user->ID);
        $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

        $company = get_field('company',  'user_' . $user->ID);
        $company_title = $company[0]->post_title;
        $company_logo = get_field('company_logo', $company[0]->ID);
        if (!$company_logo || !$company_title)
            continue;
        $display_name = "";
        if(isset($user->first_name) && isset($user->last_name))
            $display_name = $user->first_name . ' ' . $user->last_name;
        else
            $display_name =  $user->display_name;
        $purcent = $purchantage_on_bottop ? number_format(( $purchantage_on_top/$purchantage_on_bottop )*100  , 2, '.', ',') : $purchantage_on_top;
        $block .= '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$num . '</p>
                    <div class="circleImgCollection">
                        <img src="' . $image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $display_name . '</p>
                    
                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $company_logo . '" alt="">
                                <p>' . $company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p>'.$user->pricing.'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $purcent . '%</p>
                </div>
            </a>';
    }

    $data['content'] = $block;
    $data['name'] = ($topic_search != 0) ? (String)get_the_category_by_ID($topic_search) : '';

    if(empty($most_active_members) || !$bool) 
        $data['content'] = '<center><p class="verkop"> Geen deskundigen beschikbaar </p></center>';

    echo $data['content'];
}elseif ($period){
    $current_year = date('Y');
    $start_of_current_year = $current_year . '-01-01';
    $start_of_last_year = ($current_year - 1) . '-01-01';
    $current_date = current_time('Y-m-d');
    $categories_topic = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        //'parent'     => array(174,175,176,177,178,179),
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
        'date_query' => array(
            'before'=>'',
            'after'=>'',
            'inclusive'=>true,
        )
    ) );
    $global_blogs = get_posts($args);

    $categoriees = array();

    if(isset($categories_topic))
        foreach($categories_topic as $category)
            array_push($categoriees, $category->cat_ID);
    foreach($global_blogs as $blog){
        $category_id = 0;
        $experts = get_field('experts', $blog->ID);

        $category_default = get_field('categories',  $blog->ID);
        $categories_xml = get_field('category_xml',  $blog->ID);
        $categories = array();

        /*
        * Merge categories from customize and xml
        */
        if(!empty($category_default))
            foreach($category_default as $item)
                if($item)
                    if($item['value'])
                        if(!in_array($item['value'], $categories))
                            array_push($categories, $item['value']);

                        else if(!empty($category_xml))
                            foreach($category_xml as $item)
                                if($item)
                                    if($item['value'])
                                        if(!in_array($item['value'], $categories))
                                            array_push($categories, $item['value']);
        foreach($categoriees as $categoriee){
            if($categories)
                if(in_array($categoriee, $categories)){
                    /*
                    ** Push experts
                    */
                    if(!in_array($blog->post_author, $teachers))
                        array_push($teachers, $blog->post_author);

                    foreach($experts as $expertie)
                        if(!in_array($expertie, $teachers))
                            array_push($teachers, $expertie);
                    break;
                }
        }
    }
    if($period == 'lastyear'){
        foreach ($most_active_members as $user ) {
            if($num==9)
                break;
            $args_current_year = array(
                'post_type' => 'post',// array('post', 'course'),
                'post_status' => array('wc-processing', 'wc-completed'),
                'orderby' => 'date',
                //'order' => 'DESC',
                'limit' => -1,
                'author' => $user->ID,
                'date_query' => array(
                    array(
                        'after' => $start_of_current_year,
                        'before' => $start_of_last_year,
                        //'inclusive' => true,
                    ),
                ),
            );
            $courses_current_year = get_posts($args_current_year);
            // args to get artikel of last year
            $args_last_year = array(
                'post_type' => 'post',
                'posts_per_page' => -1, // Récupérer tous les articles de l'année passée
                'author' => $user->ID,
                'date_query' => array(
                    'after' => $start_of_last_year,
                    'before' => $current_year . '-01-01',
                    'inclusive' => true,
                ),
            );
            $courses_last_year = get_posts($args_last_year);
            if (!empty($courses_last_year))
                foreach ($courses_last_year as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = get_field('price', $course->ID);
                    $tracker_views = get_field('tracker_views', $course->ID);
                    $tracker_views = $tracker_views ? $tracker_views : 0;
                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if(!$prijs) {
                        if ($course_type == 'Artikel') {
                            $pricing = $pricing + 50;
                            if ($tracker_views !=0) {
                                $pricing = $pricing + 1.25; //views+click
                            }
                            if ($favorited){
                                $pricing = $pricing + 5;
                            }
                        }
                        else if ($course_type == 'Podcast') {
                            $pricing = $pricing + 100;
                            if ($favorited){
                                $pricing = $pricing + 10;
                            }
                        }
                        else if ($course_type == 'Video') {
                            $pricing = $pricing + 75;
                            if ($tracker_views !=0) {
                                $pricing = $pricing + 3.5; //views+click+
                            }
                        }elseif ($course_type == 'Opleidingen' || $course_type == 'Training' || $course_type == 'Webinar' || $course_type == 'Workshop'){
                            $pricing = $pricing + 100;
                            if ($favorited){
                                $pricing = $pricing + 20;
                            }
                            if ($tracker_views !=0) {
                                $pricing = $pricing + 10;
                            }
                        }
                    }
                }
                /* get price from post doing by user for free course */

            /**
             * put points on object user
             */
            $user->pricing = $pricing?:0;
            /**
             * Get purchantages (courses courent year)/(courses last year)
             */
            $purchantage_on_top = $purchantage_on_top + count($courses_last_year);
            $purchantage_on_bottop = $purchantage_on_bottop + count($courses_current_year);
            $bool = true;
            $image_user = get_field('profile_img',  'user_' . $user->ID);
            $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            $company = get_field('company',  'user_' . $user->ID);
            $company_title = $company[0]->post_title;
            $company_logo = get_field('company_logo', $company[0]->ID);
            if (!$company_logo || !$company_title)
                continue;
            $display_name = "";
            if(isset($user->first_name) && isset($user->last_name))
                $display_name = $user->first_name . ' ' . $user->last_name;
            else
                $display_name =  $user->display_name;

            $purcent = $purchantage_on_bottop ? number_format(( $purchantage_on_top/$purchantage_on_bottop )*100  , 2, '.', ',') : $purchantage_on_top;
            $block .= '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$num . '</p>
                    <div class="circleImgCollection">
                        <img src="' . $image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $display_name . '</p>
                    
                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $company_logo . '" alt="">
                                <p>' . $company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p>'.$user->pricing.'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $purcent . '%</p>
                </div>
            </a>';
        }
        $data['content'] = $block;
        $data['name'] = ($topic_search != 0) ? (String)get_the_category_by_ID($topic_search) : '';

        if(empty($most_active_members) || !$bool)
            $data['content'] = '<center><p class="verkop"> Geen deskundigen beschikbaar </p></center>';

        echo $data['content'];
    }elseif ($period == 'lastmonth'){
        $current_month = date('m'); // get the numb of current month
        $last_month = date('m', strtotime('-1 month'));

        $start_of_last_month = date('Y-m-d', strtotime('first day of last month', strtotime($current_date)));
        $end_of_last_month = date('Y-m-d', strtotime('last day of last month', strtotime($current_date)));

        // Calculez la date de début du mois en cours
        $start_of_month = date('Y-m-01', strtotime($current_date));
        $end_of_month = date('Y-m-t', strtotime($current_date));
        foreach ($most_active_members as $user ) {
            if($num==9)
                break;
            $args_current_month = array(
                'post_type' => 'post',// array('post', 'course'),
                'post_status' => array('wc-processing', 'wc-completed'),
                'author' => $user->ID,
                'date_query' => array(
                //'post_date' => array(
                    array(
                        //'year'  => date('Y'), // current year
                        //'month' => $current_month, // current mont
                        'after'     => $start_of_month,
                        'before'    => $end_of_month,
                        'inclusive' => true,
                    ),
                ),
            );
            $courses_current_month = get_posts($args_current_month);
            // args to get artikel of last year
            $args_last_month = array(
                'post_type' => 'post',
                'posts_per_page' => -1, // Récupérer tous les articles de l'année passée
                'author' => $user->ID,
                'date_query' => array(
                    'after' => $start_of_last_month,
                    'before' => $end_of_last_month,
                    'inclusive' => true,
                ),
            );
            $courses_last_month = get_posts($args_last_month);
            //var_dump($courses_last_month);
            foreach ($courses_current_month as $course) {
                $course_type = get_field('course_type', $course->ID);
                $prijs = get_field('price', $course->ID);
                $tracker_views = get_field('tracker_views', $course->ID);
                $tracker_views = $tracker_views ? $tracker_views : 0;
                $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                //$reaction = get_field('reaction', $course->ID);

                //get pricing from type of course: course free
                if(!$prijs) {
                    if ($course_type == 'Artikel') {
                        $pricing = $pricing + 50;
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 1.25; //views+click
                        }
                        if ($favorited){
                            $pricing = $pricing + 5;
                        }
                    }
                    else if ($course_type == 'Podcast') {
                        $pricing = $pricing + 100;
                        if ($favorited){
                            $pricing = $pricing + 10;
                        }
                    }
                    else if ($course_type == 'Video') {
                        $pricing = $pricing + 75;
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 3.5; //views+click+
                        }
                    }elseif ($course_type == 'Opleidingen' || $course_type == 'Training' || $course_type == 'Webinar' || $course_type == 'Workshop'){
                        $pricing = $pricing + 100;
                        if ($favorited){
                            $pricing = $pricing + 20;
                        }
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 10;
                        }
                    }
                }
            }
            /* get price from post doing by user for free course */

            /**
             * put points on object user
             */
            $user->pricing = $pricing?:0;
            /**
             * Get purchantages (courses courent year)/(courses last year)
             */
            $purchantage_on_top = $purchantage_on_top + count($courses_last_month);
            $purchantage_on_bottop = $purchantage_on_bottop + count($courses_current_month);
            $bool = true;
            $image_user = get_field('profile_img',  'user_' . $user->ID);
            $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            $company = get_field('company',  'user_' . $user->ID);
            $company_title = $company[0]->post_title;
            $company_logo = get_field('company_logo', $company[0]->ID);
            if (!$company_logo || !$company_title)
                continue;
            $display_name = "";
            if(isset($user->first_name) && isset($user->last_name))
                $display_name = $user->first_name . ' ' . $user->last_name;
            else
                $display_name =  $user->display_name;

            $purcent = $purchantage_on_bottop ? number_format(( $purchantage_on_top/$purchantage_on_bottop )*100  , 2, '.', ',') : $purchantage_on_top;
            $block .= '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$num . '</p>
                    <div class="circleImgCollection">
                        <img src="' . $image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $display_name . '</p>
                    
                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $company_logo . '" alt="">
                                <p>' . $company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p>'.$user->pricing.'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $purcent . '%</p>
                </div>
            </a>';
        }
        $data['content'] = $block;
        $data['name'] = ($topic_search != 0) ? (String)get_the_category_by_ID($topic_search) : '';

        if(empty($most_active_members) || !$bool)
            $data['content'] = '<center><p class="verkop"> Geen deskundigen beschikbaar </p></center>';

        echo $data['content'];
    }elseif($period == 'lastweek'){
        $start_of_week = date('Y-m-d', strtotime('last monday', strtotime($current_date)));
        $end_of_week = date('Y-m-d', strtotime('next sunday', strtotime($start_of_week)));

        $start_of_last_week = date('Y-m-d', strtotime('last monday', strtotime('-1 week', strtotime($current_date))));
        $end_of_last_week = date('Y-m-d', strtotime('next sunday', strtotime($start_of_last_week)));
        foreach ($most_active_members as $user ) {
            if($num==9)
                break;
            $args_current_week = array(
                'post_type' => 'post',// array('post', 'course'),
                'post_status' => array('wc-processing', 'wc-completed'),
                'orderby' => 'date',
                //'order' => 'DESC',
                'limit' => -1,
                'author' => $user->ID,
                'date_query' => array(
                    array(
                        'after' => $start_of_week,
                        'before' => $end_of_week,
                        'inclusive' => true,
                    ),
                ),
            );
            $courses_current_week = get_posts($args_current_week);
            // args to get artikel of last year
            $args_last_week = array(
                'post_type' => 'post',
                'posts_per_page' => -1, // Récupérer tous les articles de l'année passée
                'author' => $user->ID,
                'date_query' => array(
                    'after' => $start_of_last_week,
                    'before' => $end_of_last_week,
                    'inclusive' => true,
                ),
            );
            $courses_last_week = get_posts($args_last_week);
            foreach ($courses_last_week as $course) {
                $course_type = get_field('course_type', $course->ID);
                $prijs = get_field('price', $course->ID);
                $tracker_views = get_field('tracker_views', $course->ID);
                $tracker_views = $tracker_views ? $tracker_views : 0;
                $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                //$reaction = get_field('reaction', $course->ID);

                //get pricing from type of course: course free
                if(!$prijs) {
                    if ($course_type == 'Artikel') {
                        $pricing = $pricing + 50;
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 1.25; //views+click
                        }
                        if ($favorited){
                            $pricing = $pricing + 5;
                        }
                    }
                    else if ($course_type == 'Podcast') {
                        $pricing = $pricing + 100;
                        if ($favorited){
                            $pricing = $pricing + 10;
                        }
                    }
                    else if ($course_type == 'Video') {
                        $pricing = $pricing + 75;
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 3.5; //views+click+
                        }
                    }elseif ($course_type == 'Opleidingen' || $course_type == 'Training' || $course_type == 'Webinar' || $course_type == 'Workshop'){
                        $pricing = $pricing + 100;
                        if ($favorited){
                            $pricing = $pricing + 20;
                        }
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 10;
                        }
                    }
                }
            }
            /* get price from post doing by user for free course */

            /**
             * put points on object user
             */
            $user->pricing = $pricing?:0;
            /**
             * Get purchantages (courses courent year)/(courses last year)
             */
            $purchantage_on_top = $purchantage_on_top + count($courses_last_week);
            $purchantage_on_bottop = $purchantage_on_bottop + count($courses_current_week);
            $bool = true;
            $image_user = get_field('profile_img',  'user_' . $user->ID);
            $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            $company = get_field('company',  'user_' . $user->ID);
            $company_title = $company[0]->post_title;
            $company_logo = get_field('company_logo', $company[0]->ID);
            if (!$company_logo || !$company_title)
                continue;
            $display_name = "";
            if(isset($user->first_name) && isset($user->last_name))
                $display_name = $user->first_name . ' ' . $user->last_name;
            else
                $display_name =  $user->display_name;

            $purcent = $purchantage_on_bottop ? number_format(( $purchantage_on_top/$purchantage_on_bottop )*100  , 2, '.', ',') : $purchantage_on_top;
            $block .= '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$num . '</p>
                    <div class="circleImgCollection">
                        <img src="' . $image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $display_name . '</p>
                    
                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $company_logo . '" alt="">
                                <p>' . $company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p>'.$user->pricing.'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $purcent . '%</p>
                </div>
            </a>';
        }
        $data['content'] = $block;
        $data['name'] = ($topic_search != 0) ? (String)get_the_category_by_ID($topic_search) : '';

        if(empty($most_active_members) || !$bool)
            $data['content'] = '<center><p class="verkop"> Geen deskundigen beschikbaar </p></center>';

        echo $data['content'];
    }elseif($period == 'all'){
        foreach ($most_active_members as $user ) {
            if($num==9)
                break;
            $args_current_year = array(
                'post_type' => 'post',// array('post', 'course'),
                'post_status' => array('wc-processing', 'wc-completed'),
                'orderby' => 'date',
                //'order' => 'DESC',
                'limit' => -1,
                'author' => $user->ID,
                'date_query' => array(
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
                'post_type' => 'post',
                'posts_per_page' => -1, // Récupérer tous les articles de l'année passée
                'author' => $user->ID,
                'date_query' => array(
                    'after' => $start_of_last_year,
                    'before' => $current_year . '-01-01',
                    'inclusive' => true,
                ),
            );
            $courses_last_year = get_posts($args_last_year);
            foreach ($courses_last_year as $course) {
                $course_type = get_field('course_type', $course->ID);
                $prijs = get_field('price', $course->ID);
                $tracker_views = get_field('tracker_views', $course->ID);
                $tracker_views = $tracker_views ? $tracker_views : 0;
                $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                //$reaction = get_field('reaction', $course->ID);

                //get pricing from type of course: course free
                if(!$prijs) {
                    if ($course_type == 'Artikel') {
                        $pricing = $pricing + 50;
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 1.25; //views+click
                        }
                        if ($favorited){
                            $pricing = $pricing + 5;
                        }
                    }
                    else if ($course_type == 'Podcast') {
                        $pricing = $pricing + 100;
                        if ($favorited){
                            $pricing = $pricing + 10;
                        }
                    }
                    else if ($course_type == 'Video') {
                        $pricing = $pricing + 75;
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 3.5; //views+click+
                        }
                    }elseif ($course_type == 'Opleidingen' || $course_type == 'Training' || $course_type == 'Webinar' || $course_type == 'Workshop'){
                        $pricing = $pricing + 100;
                        if ($favorited){
                            $pricing = $pricing + 20;
                        }
                        if ($tracker_views !=0) {
                            $pricing = $pricing + 10;
                        }
                    }
                }
            }
            /* get price from post doing by user for free course */

            /**
             * put points on object user
             */
            $user->pricing = $pricing?:0;
            /**
             * Get purchantages (courses courent year)/(courses last year)
             */
            $purchantage_on_top = $purchantage_on_top + count($courses_last_year);
            $purchantage_on_bottop = $purchantage_on_bottop + count($courses_current_year);
            $bool = true;
            $image_user = get_field('profile_img',  'user_' . $user->ID);
            $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            $company = get_field('company',  'user_' . $user->ID);
            $company_title = $company[0]->post_title;
            $company_logo = get_field('company_logo', $company[0]->ID);
            if (!$company_logo || !$company_title)
                continue;
            $display_name = "";
            if(isset($user->first_name) && isset($user->last_name))
                $display_name = $user->first_name . ' ' . $user->last_name;
            else
                $display_name =  $user->display_name;

            $purcent = $purchantage_on_bottop ? number_format(( $purchantage_on_top/$purchantage_on_bottop )*100  , 2, '.', ',') : $purchantage_on_top;
            $block .= '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$num . '</p>
                    <div class="circleImgCollection">
                        <img src="' . $image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $display_name . '</p>
                    
                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $company_logo . '" alt="">
                                <p>' . $company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p>'.$user->pricing.'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $purcent . '%</p>
                </div>
            </a>';
        }

        $data['content'] = $block;
        $data['name'] = ($topic_search != 0) ? (String)get_the_category_by_ID($topic_search) : '';

        if(empty($most_active_members) || !$bool)
            $data['content'] = '<center><p class="verkop"> Geen deskundigen beschikbaar </p></center>';

        echo $data['content'];
    }
}