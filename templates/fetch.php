<?php /** Template Name: Fetch ajax */ ?>

<?php
if (($_POST["course_searched"])) {
    extract($_POST);
    if (!empty($course_searched)) {
<<<<<<< HEAD
<<<<<<< HEAD
        //echo "<h5>$course_searched</h5>";
=======

>>>>>>> 7a768a6c7686d5ecceebc6ecb15e1fb71a3786f8
=======

>>>>>>> d0d00ee5f29de57742fd98a29ca7a3e44235eef5
        $args = array(
            'post_type' => array('course', 'post'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            's' => $course_searched,
            'orderby' => 'date',
            'order' => 'ASC',
        );
        $course_founded = get_posts($args);
        if ($course_founded)
            foreach ($course_founded as $key => $course){
                $course_type = get_field('course_type', $course->ID);
<<<<<<< HEAD
<<<<<<< HEAD
                /*
                $image = get_field('preview', $course->ID)['url'];
                if(!$image){
                    $image = get_the_post_thumbnail_url($course->ID);
                    if(!$image)
                        $image = get_field('url_image_xml', $course->ID);
                    if(!$image)
                        $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                }
                */
                $image = get_field('url_image_xml',$course->ID);
=======
=======
>>>>>>> d0d00ee5f29de57742fd98a29ca7a3e44235eef5

                $thumbnail = get_field('preview', $post->ID)['url'];
                if(!$thumbnail){
                    $thumbnail = get_the_post_thumbnail_url($post->ID);
                    if(!$thumbnail)
                        $thumbnail = get_field('url_image_xml', $post->ID);
                    if(!$thumbnail)
                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                }
<<<<<<< HEAD
>>>>>>> 7a768a6c7686d5ecceebc6ecb15e1fb71a3786f8
=======
>>>>>>> d0d00ee5f29de57742fd98a29ca7a3e44235eef5
                echo '<li>
                        <a class="card-suggestion-for-search d-flex justify-content-between align-items-center" target="_blank" href="'.get_permalink($course->ID).'">
                            <div class="d-flex">
                                <div class="blockImg">
<<<<<<< HEAD
<<<<<<< HEAD
                                    <img src="'.$image.'" alt="'.$image.'">
=======
                                    <img src="'.$thumbnail.'" alt="'.$thumbnail.'">
>>>>>>> 7a768a6c7686d5ecceebc6ecb15e1fb71a3786f8
=======
                                    <img src="'.$thumbnail.'" alt="'.$thumbnail.'">
>>>>>>> d0d00ee5f29de57742fd98a29ca7a3e44235eef5
                                </div>
                                <div>
                                    <p class="subtitleSousElementHeader">'.$course->post_title.'</p>
                                    <p class="subbategory">'.$course_type.'</p>
                                </div>
                            </div>
                            <p class="price mb-0">Free</p>
                        </a>
                    </li>';
            }
        return;
    }
<<<<<<< HEAD
<<<<<<< HEAD
}
=======
}
>>>>>>> 7a768a6c7686d5ecceebc6ecb15e1fb71a3786f8
=======
}
>>>>>>> d0d00ee5f29de57742fd98a29ca7a3e44235eef5
