<?php /** Template Name: Fetch activity course */ ?>

<?php

extract($_POST);

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

$saved = get_user_meta($user->ID, 'course');

if(!empty($saved)){
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'include' => $saved,  
    );

    $courses_favorite = get_posts($args);
}
else
    return 0;

$row_company_course = " ";

if(isset($search_user_course)){
    foreach($courses_favorite as $course){
        $filter = $course->post_title;

        /*
        * Location
        */
        $location = 'Virtual';
        $data = get_field('data_locaties', $course->ID);
        if($data){
            if($data[0]['data'][0]['location'])
                $location = $data[0]['data'][0]['location'];
        }
        else{         
            $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
            if($data[2])
                $location = $data[2];
        }

        /*
        * Categories
        */
        
        $category = ' ';
                    
        $category_id = 0;
        $category_string = " ";

        $tree = get_the_terms($course->ID, 'course_category'); 
            if($tree)
                if(isset($tree[2]))
                    $category = $tree[2]->name;
        
        if($category == ' '){
            $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
            $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
            if($category_str != 0)
                $category = (String)get_the_category_by_ID($category_str);
            else if($category_id != 0)
                $category = (String)get_the_category_by_ID($category_id);                                    
        }

        /*
        * Price
        */
        $p = get_field('price', $course->ID);
        if($p != "0")
            $price =  number_format($p, 2, '.', ',');
        else
            $price = 'Gratis';

        /*
        * Thumbnails
        */
        $thumbnail = get_field('preview', $course->ID)['url'];
        if(!$thumbnail){
            $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
            if(!$thumbnail)
                $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
        }

        if( stristr($filter, $search_user_course) || $search_user_course == '')
            $row_company_course .= '
            <a href="' . get_permalink($course->ID) .'" class="coursElement">
                <div class="imgBlockCoursElement">
                    <img src="' . $thumbnail .'" alt="">
                </div>
                <div class="detailTwoCoursElement">
                    <div class="d-block">
                        <div class="subDetailTwoCoursElement">
                            <p class="nameCours">' .  $course->post_title .'</p>
                            <div class="d-flex">
                                <div class="d-flex mr-3">
                                    <img src="'.  get_stylesheet_directory_uri() .'/img/iconsMap.png" alt="">
                                    <p class="mapLocalisation">'.  $location .'</p>
                                </div>
                                <div class="d-flex">
                                    <img src="'.  get_stylesheet_directory_uri() . '/img/moneyElement.png" alt="">
                                    <p class="mapLocalisation">'.  $price . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="tagElementBlock">
                            <p>'.  $category . '</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <form action="" method="POST">
                            <input type="hidden" name="meta_value" value="' . $course->ID . '">
                            <button type="submit" name="delete_favorite" class="btn btnViewCours">
                                <img src="'.  get_stylesheet_directory_uri() . '/img/trashC.png" alt="">
                            </button>
                        </form>
                    </div>
                </div>
            </a>';
    }

    echo $row_company_course;
}

