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
$i = 0;
if(!empty($numbers_count))
    foreach ($numbers_count as $element) {
        $i++;
        if($i >= 13)
            break;
        $value = get_user_by('ID', $element['id']);        
        $value->image_author = get_field('profile_img',  'user_' . $value->ID);
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
        ) );
    }

    $args = array(
        'post_type' => array('post', 'course'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
    );

    $global_blogs = get_posts($args);

    $blogs = array();
    $blogs_id = array();
    $others = array();
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
    foreach($most_active_members as $user) {
        if(!in_array($user->ID, $teachers))
            continue;
        
        $bool = true;
        $image_user = get_field('profile_img',  'user_' . $user->ID);
        $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

        $company = get_field('company',  'user_' . $user->ID);
        $company_title = $company[0]->post_title;
        $company_logo = get_field('company_logo', $company[0]->ID);

        $display_name = "";
        if(isset($user->first_name) && isset($user->last_name)) 
            $display_name = $user->first_name . ' ' . $user->last_name; 
        else 
            $display_name =  $user->display_name;

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
                                <p>' . number_format(rand(0,100000), 2, '.', ',') . '</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . number_format(rand(0,100), 2, '.', ','). '%</p>
                </div>
            </a>';
    }

    $data['content'] = $block;
    $data['name'] = ($topic_search != 0) ? (String)get_the_category_by_ID($topic_search) : '';

    if(empty($most_active_members) || !$bool) 
        $data['content'] = '<center><p class="verkop"> Geen deskundigen beschikbaar </p></center>';

    echo $data['content'];
}
