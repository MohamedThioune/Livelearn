<?php /** Template Name: Fetch activity course */ ?>

<?php

extract($_POST);

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

$row_activity_course = " ";
$page = 'check_visibility.php';
require($page);

//Saved
$saved = get_user_meta($user->ID, 'course');

/*
* * Courses dedicated of these user "Boughts + Mandatories"
*/

$enrolled = array();
$enrolled_courses = array();
$kennis_video = get_field('kennis_video', 'user_' . $user->ID);
$mandatory_video = get_field('mandatory_video', 'user_' . $user->ID);
$expenses = 0;

//Orders - enrolled courses  
$args = array(
    'customer_id' => $user->ID,
    'post_status' => array('wc-processing'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        //Get woo orders from user
        $course_id = intval($item->get_product_id()) - 1;
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

    //Make sure videos shared not null before to merge with enrolled
    if(!empty($kennis_video))
        if(isset($kennis_video[0]))
            if($kennis_video[0])
                $enrolled_courses = array_merge($kennis_video, $enrolled_courses);

    //Make sure videos put on mandatory is not null before to merge with enrolled
    if(!empty($mandatory_video))
        if(isset($mandatory_video[0]))
            if($mandatory_video[0])
                $enrolled_courses = array_merge($mandatory_video, $enrolled_courses);
    
}


if(isset($search_activity_course)){
    foreach($enrolled_courses as $course){
        $filter = $course->post_title;
        $bool = true;
        $bool = visibility($course, $visibility_company);
        if(!$bool)
            continue;

        //Course Type
        $course_type = get_field('course_type', $course->ID);
        
        //Legend image
        $image_course = get_field('preview', $course->ID)['url'];
        if(!$image_course){
            $image_course = get_the_post_thumbnail_url($course->ID);
            if(!$image_course)
                $image_course = get_field('url_image_xml', $course->ID);
            if(!$image_course)
                $image_course = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
        }

        //Author
        $author = get_user_by('ID', $course->post_author);      
        $author_name = $author->first_name ?: $author->display_name;
        $author_image = get_field('profile_img',  'user_' . $author->ID);
        $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

        //Clock duration
        $duration_day = get_field('duration_day', $post->ID) ? get_field('duration_day', $post->ID) . 'days' : 'Unlimited';

        //Color
        $color_done = "green";
        $color_progress = "#ff9b00";
        $color_new = "#043356";

        //Button like    
        $button_render = (in_array($course->ID, $saved)) ? '<i class="fa fa-heart mr-4"></i>' : '<i class="fa fa-heart-o mr-4"></i>';

        if( stristr($filter, $search_activity_course) || $search_activity_course == '')
            $row_activity_course .= '
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="blockImgCourse">
                            <img src="' . $image_course . '" class="" alt="">
                        </div>
                        <p class="name-element">' . $course->post_title . '</p>
                    </div>
                </td>
                <td>
                    <p class="name-element">' . $duration_day  . '</p>
                </td>
                <td class="">
                    <p class="name-element">' . $author_name .'</p>
                </td>
                <td>
                    <p class="text-left" style="color: #043356;"> New </p>
                </td>
                <td>
                    ' . $button_render . '
                </td>
            </tr>';
    }

    echo $row_activity_course;
}

