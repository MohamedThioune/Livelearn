<?php /** Template Name: Fetch ajax home2 */ ?>

<?php

extract($_POST);

//$page = 'check_visibility.php';
//require($page);

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
















































if(isset($topic_search)) {

    if ($topic_search != 0) {
        $categories_topic = get_categories(array(
            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'orderby' => 'name',
            'parent' => $topic_search,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
    }

    $args = array(
        'post_type' => 'post',// array('post', 'course'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
    );

    $global_blogs = get_posts($args);

    $teachers = array();
    $teachers_all = array();

    $categoriees = array();

    if (isset($categories_topic))
        foreach ($categories_topic as $category)
            array_push($categoriees, $category->cat_ID);

    foreach ($global_blogs as $blog) {
        /*
        * Categories
        */
        $category_id = 0;
        $experts = get_field('experts', $blog->ID);

        $category_default = get_field('categories', $blog->ID);
        $categories_xml = get_field('category_xml', $blog->ID);
        $categories = array();

        /*
        * Merge categories from customize and xml
        */
        if (!empty($category_default))
            foreach ($category_default as $item)
                if ($item)
                    if ($item['value'])
                        if (!in_array($item['value'], $categories))
                            array_push($categories, $item['value']);

                        else if (!empty($category_xml))
                            foreach ($category_xml as $item)
                                if ($item)
                                    if ($item['value'])
                                        if (!in_array($item['value'], $categories))
                                            array_push($categories, $item['value']);

        foreach ($categoriees as $categoriee) {
            if ($categories)
                if (in_array($categoriee, $categories)) {
                    /*
                    ** Push experts
                    */
                    if (!in_array($blog->post_author, $teachers))
                        array_push($teachers, $blog->post_author);

                    foreach ($experts as $expertie)
                        if (!in_array($expertie, $teachers))
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

    $today = new DateTime();
    $lastYearTeample = $today->sub(new DateInterval('P1Y'));
    $lastYear = $lastYearTeample->format('Y-m-d');

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
    $active_members = array();
    foreach ($most_active_members as $index => $user) {
        $pricing_last_year = 0;
        $pricing_since_today = 0;

        if ($num == 12)
            break;


        if (!in_array($user->ID, $teachers))
            continue;
        //get pricing from price of course
        foreach ($bunch_orders as $order) {
            foreach ($order->get_items() as $item) {
                //Get woo orders from user
                $id_course = intval($item->get_product_id()) - 1;
                $course = get_post($id_course);
                $prijs = intval(get_field('price', $id_course));
                $favorited = get_field('favorited', $id_course);
                $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                if (!$number_of_this_is_looking)
                    continue;

                $tracker_views = intval($number_of_this_is_looking) ?: 0;

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
        );
        $courses_doing_by_this_user = get_posts($args);
        foreach ($courses_doing_by_this_user as $course) {
            $course_type = get_field('course_type', $course->ID);
            $prijs = intval(get_field('price', $course->ID));
            $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
            $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
            if (!$number_of_this_is_looking)
                continue;

            $tracker_views = intval($number_of_this_is_looking) ?: 0;
            $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
            //$reaction = get_field('reaction', $course->ID);

            //get pricing from type of course: course free
            if ($course_type == 'Artikel') {
                $pricing = $pricing + 50;
                if ($tracker_views != 0)
                    $pricing = $pricing + $tracker_views * 1.25; //views+click

                if ($favorited) {
                    $pricing = $pricing + 5;
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

        // args to get artikel of current year
        $args_current_year = array(
            'post_type' => array('post', 'course'),
            'order' => 'DESC',
            'limit' => -1,
            'author' => $user->ID,
        );

        $courses_current_year = get_posts($args_current_year);
        // args to get artikel of last year
        $args_last_year = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'author' => $user->ID,
            'date_query' => array(
                'year' => $lastYear,
                'inclusive' => true,
            ),
        );
        $courses_last_year = get_posts($args_last_year);
        if (!empty($courses_current_year))
            foreach ($courses_current_year as $course) {
                $course_type = get_field('course_type', $course->ID);
                $prijs = intval(get_field('price', $course->ID));
                $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                $tracker_views = intval($number_of_this_is_looking) ?  : 0;

                $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                //$reaction = get_field('reaction', $course->ID);

                //get pricing from type of course: course free
                if ($course_type == 'Artikel') {
                    $pricing_since_today = $pricing_since_today + 50;
                    if ($tracker_views !=0) {
                        $pricing_since_today = $pricing_since_today + $tracker_views * 1.25; //views+click
                    }
                    if ($favorited){
                        $pricing_since_today = $pricing_since_today + 5;
                    }
                }
                else if ($course_type == 'Podcast') {
                    $pricing_since_today = $pricing_since_today + 100;
                    if ($favorited){
                        $pricing_since_today = $pricing_since_today + 10;
                    }
                }
                else if ($course_type == 'Video') {
                    $pricing_since_today = $pricing_since_today + 75;
                    if ($tracker_views !=0) {
                        $pricing_since_today = $pricing_since_today + $tracker_views * 3.5; //views+click+
                    }
                }else {
                    $pricing_since_today = $pricing_since_today + 100;
                    if ($favorited){
                        $pricing_since_today = $pricing_since_today + 20;
                    }
                    if ($tracker_views !=0) {
                        $pricing_since_today = $pricing_since_today + $tracker_views * 10;
                    }
                }
            }
        if (!empty($courses_last_year))
            foreach ($courses_last_year as $course) {
                $course_type = get_field('course_type', $course->ID);
                $prijs = intval(get_field('price', $course->ID));
                $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                $tracker_views = intval($number_of_this_is_looking) ?: 0;

                $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                //$reaction = get_field('reaction', $course->ID);

                //get pricing from type of course: course free
                if ($course_type == 'Artikel') {
                    $pricing_last_year = $pricing_last_year + 50;
                    if ($tracker_views != 0) {
                        $pricing_last_year = $pricing_last_year + $tracker_views * 1.25; //views+click
                    }
                    if ($favorited) {
                        $pricing_last_year = $pricing_last_year + 5;
                    }
                } else if ($course_type == 'Podcast') {
                    $pricing_last_year = $pricing_last_year + 100;
                    if ($favorited) {
                        $pricing_last_year = $pricing_last_year + 10;
                    }
                } else if ($course_type == 'Video') {
                    $pricing_last_year = $pricing_last_year + 75;
                    if ($tracker_views != 0) {
                        $pricing_last_year = $pricing_last_year + $tracker_views * 3.5; //views+click+
                    }
                } else {
                    $pricing_last_year = $pricing_last_year + 100;
                    if ($favorited) {
                        $pricing_last_year = $pricing_last_year + 20;
                    }
                    if ($tracker_views != 0) {
                        $pricing_last_year = $pricing_last_year + $tracker_views * 10;
                    }
                }
            }

        $purchantage_on_top = $purchantage_on_top + count($courses_last_year);
        $purchantage_on_bottop = $purchantage_on_bottop + count($courses_current_year);
        $bool = true;


        $image_user = get_field('profile_img', 'user_' . $user->ID);
        $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

        $company = get_field('company', 'user_' . $user->ID);
        $company_title = $company[0]->post_title;
        $company_logo = get_field('company_logo', $company[0]->ID);
        if (!$company_logo || !$company_title)
            continue;

        $display_name = "";
        if (isset($user->first_name) && isset($user->last_name))
            $display_name = $user->first_name . ' ' . $user->last_name;
        else
            $display_name = $user->display_name;

        $purcent = abs($pricing_since_today-$pricing_last_year);
        $purcent = $pricing_last_year ? ($purcent/$pricing_last_year) : $purcent;
        $purcent = $purcent >= 100 ? $purcent : $purcent * 100;

        $purcent = $purchantage_on_bottop ? number_format(($purchantage_on_top / $purchantage_on_bottop) * 100, 2, '.', ',') : $purchantage_on_top;

        if ($pricing_since_today > $pricing_last_year)
            $user->pricing = $pricing_since_today;
        else
            $user->pricing = $pricing_last_year;

        $user->display_name = $display_name;
        $user->purcent = $purcent;
        $user->image_user = $image_user;
        $user->company_title = $company_title;
        $user->company_logo = $company_logo;

        $active_members [] = $user;

        $block .= '
            <a href="user-overview?id=' . $user->ID . '" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$num . '</p>
                    <div class="circleImgCollection">
                        <img src="' . $user->image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">' . $user->display_name . '</p>
                    
                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $user->company_logo . '" alt="">
                                <p>' . $user->company_title . '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p>' . $user->pricing . '</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $user->pricing . '%</p>
                </div>
            </a>';
    }

    $data['content'] = $block;
    $data['name'] = ($topic_search != 0) ? (string)get_the_category_by_ID($topic_search) : '';

    if (empty($most_active_members) || !$bool)
        $data['content'] = '<center><p class="verkop"> Geen deskundigen beschikbaar </p></center>';

    echo $data['content'];

} elseif ($period){
    $today = new DateTime();
    $current_year = date('Y');
    $start_of_current_year = $current_year . '-01-01';
    $start_of_last_year = ($current_year - 1) . '-01-01';
    $current_date = current_time('Y-m-d');

    $categories_topic = get_categories( array (
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        //'parent'     => array(174,175,176,177,178,179),
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));
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
        $lastYearTeample = $today->sub(new DateInterval('P1Y'));
        $lastYear = $lastYearTeample->format('Y-m-d');

        $active_members = array();
        foreach ($most_active_members as $index => $user) {
            $pricing_last_year = 0;
            $pricing_since_today = 0;

            $args_since_today = array(
                'post_type' => array('post', 'course'),
                'order' => 'DESC',
                'limit' => -1,
                'author' => $user->ID,
            );
            $courses_since_today = get_posts($args_since_today);
            // args to get artikel of last year
            $args_last_year = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'author' => $user->ID,
                'date_query' => array(
                    'year' => $lastYear,
                    'inclusive' => true,
                ),
            );
            $courses_last_year = get_posts($args_last_year);

            //var_dump(count($courses_last_year));
            if (!empty($courses_last_year))
                foreach ($courses_last_year as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?: 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_last_year = $pricing_last_year + 50;
                        if ($tracker_views != 0) {
                            $pricing_last_year = $pricing_last_year + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited) {
                            $pricing_last_year = $pricing_last_year + 5;
                        }
                    } else if ($course_type == 'Podcast') {
                        $pricing_last_year = $pricing_last_year + 100;
                        if ($favorited) {
                            $pricing_last_year = $pricing_last_year + 10;
                        }
                    } else if ($course_type == 'Video') {
                        $pricing_last_year = $pricing_last_year + 75;
                        if ($tracker_views != 0) {
                            $pricing_last_year = $pricing_last_year + $tracker_views * 3.5; //views+click+
                        }
                    } else {
                        $pricing_last_year = $pricing_last_year + 100;
                        if ($favorited) {
                            $pricing_last_year = $pricing_last_year + 20;
                        }
                        if ($tracker_views != 0) {
                            $pricing_last_year = $pricing_last_year + $tracker_views * 10;
                        }
                    }
                }

            /* get price from post doing by user for free course */
            if (!empty($courses_since_today))
                foreach ($courses_since_today as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?  : 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_since_today = $pricing_since_today + 50;

                        if ($tracker_views !=0)
                            $pricing_since_today = $pricing_since_today + $tracker_views * 1.25; //views+click

                        if ($favorited)
                            $pricing_since_today = $pricing_since_today + 5;

                    }
                    else if ($course_type == 'Podcast') {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 10;
                        }
                    }
                    else if ($course_type == 'Video') {
                        $pricing_since_today = $pricing_since_today + 75;
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 3.5; //views+click+
                        }
                    }else {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 20;
                        }
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 10;
                        }
                    }
                }

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

            $purcent = abs($pricing_since_today-$pricing_last_year);
            $purcent = $pricing_last_year ? ($purcent/$pricing_last_year) : $purcent;
            $purcent = $purcent >= 100 ? $purcent : $purcent * 100;

            if (!$purcent)
                continue;

            $purcent = number_format($purcent, 2, '.', ',');

            if ($pricing_since_today > $pricing_last_year)
                $user->pricing = $pricing_since_today;
            else
                $user->pricing = $pricing_last_year;

            $user->display_name = $display_name;
            $user->purcent = $purcent;
            $user->image_user = $image_user;
            $user->company_title = $company_title;
            $user->company_logo = $company_logo;

            $active_members [] = $user;
        }
        $pricing_members = array_column($active_members, 'pricing');
        array_multisort($pricing_members, SORT_DESC, $active_members);

        foreach ($active_members as $index => $user){
            echo '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$index .'</p>
                    <div class="circleImgCollection">
                        <img src="' . $user->image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $user->display_name . '</p>

                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $user->company_logo . '" alt="">
                                <p>' . $user->company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p class="number-brain">'.number_format($user->pricing,2,".",",").'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $user->purcent . '%</p>
                </div>
            </a>';
            if ($index == 12)
                break;
        }
    }elseif ($period == 'lastmonth'){
        $pricing_last_month = 0;
        $pricing_since_today = 0;

        $lastMonthTeamstample = $today->sub(new DateInterval('P1M'));
        $lastMonth = $lastMonthTeamstample->format('Y-m-d');

        $active_members = array();
        foreach ($most_active_members as $index => $user) {
            //I want all course before this month
            $args_last_mont = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'author' => $user->ID,
                'date_query' => array(
                    'before' => $lastMonth,
                    'inclusive' => true,
                ),
            );
            $courses_last_month = get_posts($args_last_mont);

            $args_since_today = array(
                'post_type' => array('post', 'course'),
                'order' => 'DESC',
                'limit' => -1,
                'author' => $user->ID,
            );
            $courses_since_today = get_posts($args_since_today);

            if (!empty($courses_last_month))
                foreach ($courses_last_month as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?: 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_last_month = $pricing_last_month + 50;
                        if ($tracker_views != 0) {
                            $pricing_last_month = $pricing_last_month + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited) {
                            $pricing_last_month = $pricing_last_month + 5;
                        }
                    } else if ($course_type == 'Podcast') {
                        $pricing_last_month = $pricing_last_month + 100;
                        if ($favorited) {
                            $pricing_last_month = $pricing_last_month + 10;
                        }
                    } else if ($course_type == 'Video') {
                        $pricing_last_month = $pricing_last_month + 75;
                        if ($tracker_views != 0) {
                            $pricing_last_month = $pricing_last_month + $tracker_views * 3.5; //views+click+
                        }
                    } else {
                        $pricing_last_month = $pricing_last_month + 100;
                        if ($favorited) {
                            $pricing_last_month = $pricing_last_month + 20;
                        }
                        if ($tracker_views != 0) {
                            $pricing_last_month = $pricing_last_month + $tracker_views * 10;
                        }
                    }
                }

            if (!empty($courses_since_today))
                foreach ($courses_since_today as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?  : 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_since_today = $pricing_since_today + 50;
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 5;
                        }
                    }
                    else if ($course_type == 'Podcast') {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 10;
                        }
                    }
                    else if ($course_type == 'Video') {
                        $pricing_since_today = $pricing_since_today + 75;
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 3.5; //views+click+
                        }
                    }else {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 20;
                        }
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 10;
                        }
                    }
                }
            //var_dump("today $pricing_since_today <|> last month $pricing_last_month, for $user->ID");

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

            $purcent = abs($pricing_since_today-$pricing_last_month);
            $purcent = $pricing_last_month ? ($purcent/$pricing_last_month) : $purcent;
            $purcent = $purcent >= 100 ? $purcent : $purcent * 100;
            if (!$purcent)
                continue;

            if ($purcent>100) {
                //   $purcent = (string)$purcent;
                //  $purcent = substr($purcent, 0, 2);
            }

            $purcent = number_format($purcent, 2, '.', ',');

            if ($pricing_since_today > $pricing_last_month)
                $user->pricing = $pricing_since_today;
            else
                $user->pricing = $pricing_last_year;
            $user->display_name = $display_name;
            $user->purcent = $purcent;
            $user->image_user = $image_user;
            $user->company_title = $company_title;
            $user->company_logo = $company_logo;

            $active_members [] = $user;
        }
        $pricing_members = array_column($active_members, 'pricing');
        array_multisort($pricing_members, SORT_DESC, $active_members);
        foreach ($active_members as $index => $user){
            echo '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$index .'</p>
                    <div class="circleImgCollection">
                        <img src="' . $user->image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $user->display_name . '</p>

                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $user->company_logo . '" alt="">
                                <p>' . $user->company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p class="number-brain">'.number_format($user->pricing,2,".",",").'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $user->purcent . '%</p>
                </div>
            </a>';
            if ($index == 12)
                break;
        }

    }elseif($period == 'lastweek'){
        $pricing_last_week = 0;
        $pricing_since_today = 0;

        $lastWeekTeample = $today->sub(new DateInterval('P1W'));
        $lastWeek = $lastWeekTeample->format('Y-m-d');

        $active_members = array();
        foreach ($most_active_members as $index => $user) {
            //I want all course before this month
            $args_last_week = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'author' => $user->ID,
                'date_query' => array(
                    'before' => $lastWeek,
                    'inclusive' => true,
                ),
            );
            $courses_last_week = get_posts($args_last_week);

            $args_since_today = array(
                'post_type' => array('post', 'course'),
                'order' => 'DESC',
                'limit' => -1,
                'author' => $user->ID,
            );
            $courses_since_today = get_posts($args_since_today);

            if (!empty($courses_last_week))
                foreach ($courses_last_week as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?: 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_last_week = $pricing_last_week + 50;
                        if ($tracker_views != 0) {
                            $pricing_last_week = $pricing_last_week + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited) {
                            $pricing_last_week = $pricing_last_week + 5;
                        }
                    } else if ($course_type == 'Podcast') {
                        $pricing_last_week = $pricing_last_week + 100;
                        if ($favorited) {
                            $pricing_last_week = $pricing_last_week + 10;
                        }
                    } else if ($course_type == 'Video') {
                        $pricing_last_week = $pricing_last_week + 75;
                        if ($tracker_views != 0) {
                            $pricing_last_week = $pricing_last_week + $tracker_views * 3.5; //views+click+
                        }
                    } else {
                        $pricing_last_week = $pricing_last_week + 100;
                        if ($favorited) {
                            $pricing_last_week = $pricing_last_week + 20;
                        }
                        if ($tracker_views != 0) {
                            $pricing_last_week = $pricing_last_week + $tracker_views * 10;
                        }
                    }
                }

            if (!empty($courses_since_today))
                foreach ($courses_since_today as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?  : 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_since_today = $pricing_since_today + 50;
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 5;
                        }
                    }
                    else if ($course_type == 'Podcast') {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 10;
                        }
                    }
                    else if ($course_type == 'Video') {
                        $pricing_since_today = $pricing_since_today + 75;
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 3.5; //views+click+
                        }
                    }else {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 20;
                        }
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 10;
                        }
                    }
                }

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

            $purcent = abs($pricing_since_today-$pricing_last_week);
            $purcent = $pricing_last_week ? ($purcent/$pricing_last_week) : $purcent;
            $purcent = $purcent >= 100 ? $purcent : $purcent * 100;
            if (!$purcent)
                continue;

            if ($purcent>100) {
                //   $purcent = (string)$purcent;
                //  $purcent = substr($purcent, 0, 2);
            }

            $purcent = number_format($purcent, 2, '.', ',');

            if ($pricing_since_today > $pricing_last_week)
                $user->pricing = $pricing_since_today;
            else
                $user->pricing = $pricing_last_week;
            $user->display_name = $display_name;
            $user->purcent = $purcent;
            $user->image_user = $image_user;
            $user->company_title = $company_title;
            $user->company_logo = $company_logo;

            $active_members [] = $user;
        }
        $pricing_members = array_column($active_members, 'pricing');
        array_multisort($pricing_members, SORT_DESC, $active_members);
        foreach ($active_members as $index => $user){
            echo '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$index .'</p>
                    <div class="circleImgCollection">
                        <img src="' . $user->image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $user->display_name . '</p>

                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $user->company_logo . '" alt="">
                                <p>' . $user->company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p class="number-brain">'.number_format($user->pricing,2,".",",").'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $user->purcent . '%</p>
                </div>
            </a>';
            if ($index == 12)
                break;
        }

    } elseif($period == 'all'){
        $lastYearTeample = $today->sub(new DateInterval('P1Y'));
        $lastYear = $lastYearTeample->format('Y-m-d');

        $today2 = new DateTime();
        $lastTwoYearTamstemple = $today2->sub(new DateInterval('P2Y'));
        $lastTwoYear = $lastTwoYearTamstemple->format('Y-m-d');

        $active_members = array();
        foreach ($most_active_members as $index => $user) {
            $pricing_last_year = 0;
            $pricing_last_two_year = 0;
            $pricing_since_today = 0;

            $args_since_today = array(
                'post_type' => array('post', 'course'),
                'order' => 'DESC',
                'limit' => -1,
                'author' => $user->ID,
            );
            $courses_since_today = get_posts($args_since_today);
            // args to get artikel of last year
            $args_last_year = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'author' => $user->ID,
                'date_query' => array(
                    'year' => $lastYear,
                    'inclusive' => true,
                ),
            );
            $courses_last_year = get_posts($args_last_year);
            $args_last_two_year = array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'author' => $user->ID,
                'date_query' => array(
                    'year' => $lastTwoYear,
                    'inclusive' => true,
                ),
            );
            $courses_last_two_year = get_posts($args_last_two_year);
            if (!empty($courses_since_today))
                foreach ($courses_since_today as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?  : 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_since_today = $pricing_since_today + 50;
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 5;
                        }
                    }
                    else if ($course_type == 'Podcast') {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 10;
                        }
                    }
                    else if ($course_type == 'Video') {
                        $pricing_since_today = $pricing_since_today + 75;
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 3.5; //views+click+
                        }
                    }else {
                        $pricing_since_today = $pricing_since_today + 100;
                        if ($favorited){
                            $pricing_since_today = $pricing_since_today + 20;
                        }
                        if ($tracker_views !=0) {
                            $pricing_since_today = $pricing_since_today + $tracker_views * 10;
                        }
                    }
                }

            if (!empty($courses_last_year))
                foreach ($courses_last_year as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?: 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_last_year = $pricing_last_year + 50;
                        if ($tracker_views != 0) {
                            $pricing_last_year = $pricing_last_year + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited) {
                            $pricing_last_year = $pricing_last_year + 5;
                        }
                    } else if ($course_type == 'Podcast') {
                        $pricing_last_year = $pricing_last_year + 100;
                        if ($favorited) {
                            $pricing_last_year = $pricing_last_year + 10;
                        }
                    } else if ($course_type == 'Video') {
                        $pricing_last_year = $pricing_last_year + 75;
                        if ($tracker_views != 0) {
                            $pricing_last_year = $pricing_last_year + $tracker_views * 3.5; //views+click+
                        }
                    } else {
                        $pricing_last_year = $pricing_last_year + 100;
                        if ($favorited) {
                            $pricing_last_year = $pricing_last_year + 20;
                        }
                        if ($tracker_views != 0) {
                            $pricing_last_year = $pricing_last_year + $tracker_views * 10;
                        }
                    }
                }

            if (!empty($courses_last_two_year))
                foreach ($courses_last_two_year as $course) {
                    $course_type = get_field('course_type', $course->ID);
                    $prijs = intval(get_field('price', $course->ID));
                    $sql_request = $wpdb->prepare("SELECT occurence FROM $table_tracker_views  WHERE  data_id = $course->ID");
                    $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                    $tracker_views = intval($number_of_this_is_looking) ?: 0;

                    $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                    //$reaction = get_field('reaction', $course->ID);

                    //get pricing from type of course: course free
                    if ($course_type == 'Artikel') {
                        $pricing_last_two_year = $pricing_last_two_year + 50;
                        if ($tracker_views != 0) {
                            $pricing_last_two_year = $pricing_last_two_year + $tracker_views * 1.25; //views+click
                        }
                        if ($favorited) {
                            $pricing_last_two_year = $pricing_last_two_year + 5;
                        }
                    } else if ($course_type == 'Podcast') {
                        $pricing_last_two_year = $pricing_last_two_year + 100;
                        if ($favorited) {
                            $pricing_last_two_year = $pricing_last_two_year + 10;
                        }
                    } else if ($course_type == 'Video') {
                        $pricing_last_two_year = $pricing_last_two_year + 75;
                        if ($tracker_views != 0) {
                            $pricing_last_two_year = $pricing_last_two_year + $tracker_views * 3.5; //views+click+
                        }
                    } else {
                        $pricing_last_two_year = $pricing_last_two_year + 100;
                        if ($favorited) {
                            $pricing_last_two_year = $pricing_last_two_year + 20;
                        }
                        if ($tracker_views != 0) {
                            $pricing_last_two_year = $pricing_last_two_year + $tracker_views * 10;
                        }
                    }
                }

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

            /************************* $purcent_last_year */
            $purcent_last_year = abs($pricing_since_today-$pricing_last_year);
            $purcent_last_year = $pricing_last_year ? ($purcent_last_year/$pricing_last_year) : $purcent_last_year;
            /************************* $purcent_last_year */

            /************************* $purcent_two_last_year */
            $purcent_two_last_year = abs($pricing_last_year - $pricing_last_two_year);
            $purcent_two_last_year = $pricing_last_two_year ? ($purcent_two_last_year/$pricing_last_two_year) : $purcent_two_last_year;
            /************************* $purcent_last_year */
            $overage = abs((float) $purcent_last_year - (float) $purcent_two_last_year);
            if (!$overage)
                continue;
            $overage = $overage > 100 ? $overage : $overage * 100;
            $overage = number_format($overage, 2, '.', ',');

            //var_dump($overage);
            //var_dump("princ last year : $pricing_last_year, pricing last two year : $pricing_last_two_year for user : $user->ID");

            $user->pricing = $pricing_last_two_year > $pricing_last_year ? $pricing_last_two_year : $pricing_last_year;
            $user->pricing = $user->pricing ? : $overage;
            $user->display_name = $display_name;
            $user->purcent = $overage;
            $user->image_user = $image_user;
            $user->company_title = $company_title;
            $user->company_logo = $company_logo;

            $active_members [] = $user;
        }
        $pricing_members = array_column($active_members, 'purcent');
        array_multisort($pricing_members, SORT_DESC, $active_members);
        foreach ($active_members as $index => $user){
            echo '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$index .'</p>
                    <div class="circleImgCollection">
                        <img src="' . $user->image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $user->display_name . '</p>

                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $user->company_logo . '" alt="">
                                <p>' . $user->company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p class="number-brain">'.number_format($user->pricing,2,".",",").'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $user->purcent . '%</p>
                </div>
            </a>';
            if ($index == 12)
                break;
        }
    }
}