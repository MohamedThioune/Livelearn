<?php /** Template Name: Fetch activity course */ ?>

<?php

extract($_POST);

$user = get_user_by('ID', get_current_user_id());

$row_activity_course = " ";
//$page = 'check_visibility.php';
//require($page);

//Saved
$saved = get_user_meta($user->ID, 'course');

/*
* * Courses dedicated of these user "Boughts + Mandatories"
*/

$enrolled = array();
$enrolled_courses = array();

//Orders - enrolled courses  
$args = array(
    'customer_id' => $user->ID,
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        //Get woo orders from user
        $course_id = intval($item->get_product_id()) - 1;
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

$offline = ['Opleidingen', 'Training', 'Workshop', 'Masterclass', 'Event'];

if(isset($search_activity_course)){
    foreach($enrolled_courses as $course){
        $filter = $course->post_title;
        $bool = true;
        $bool = visibility($course, $visibility_company);
        if(!$bool)
            continue;

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

        /* * State actual details * */
        //Color
        $text_status = "New";
        $status_color = "#043356";
        //Get read by user 
        $args = array(
            'post_type' => 'progression', 
            'title' => $course->post_name,
            'post_status' => 'publish',
            'author' => $user->ID,
            'posts_per_page'         => 1,
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false
        );
        $progressions = get_posts($args);
        if(!empty($progressions)){
            $status_color = "#ff9b00";
            $text_status = "In progress";
            $progression_id = $progressions[0]->ID;
            //Finish read
            $is_finish = get_field('state_actual', $progression_id);
            if($is_finish){
                $status_color = "green";
                $text_status = "Done";

            }
        }

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
                    <p class="name-element">' . $author_name . '</p>
                </td>
                <td>
                    <p class="text-left" style="color:' . $status_color .'">' . $text_status .'</p>
                </td>
                <td>
                    ' . $button_render . '
                </td>
            </tr>';
    }

    echo $row_activity_course;
}

