<?php

function searching_course($search, $search_type, $global_posts){
    $courses = array();
    foreach($global_posts as $post)
        if(stristr($post->post_title, $search)):

            if($search_type == 'Alles'):
                array_push($courses, $post);
            else:
                $course_type = get_field('course_type', $post->ID);
                if($course_type == $search_type)
                    array_push($courses, $post);
            endif;
            
        endif;

    return $courses;
}


function searching_course_by_type($filter){
    $courses = array();

    if($filter):
        
        if($filter == 'Artikel'):
            $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish') );
            $blogs = $query->posts;
            return $blogs;
        endif;
        $args = array(
            'post_type' => array('course', 'post'),
            'post_status' => 'publish',
            'posts_per_page' => 500,
            'order' => 'DESC' ,
            'meta_key'  => 'course_type',
            'meta_value' => $filter
        );
        $courses = get_posts($args);

    endif;

    return $courses;
}


?>