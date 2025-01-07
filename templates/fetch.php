<?php /** Template Name: Fetch ajax */ ?>

<?php
if (($_POST["course_searched"])) {
    extract($_POST);
    if (!empty($course_searched)) {

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

                $thumbnail = get_field('preview', $course->ID)['url'];
                if(!$thumbnail){
                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                    if(!$thumbnail)
                        $thumbnail = get_field('url_image_xml', $course->ID);
                    if(!$thumbnail)
                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                }
                echo '<li>
                        <a class="card-suggestion-for-search d-flex justify-content-between align-items-center" target="_blank" href="'.get_permalink($course->ID).'">
                            <div class="d-flex">
                                <div class="blockImg">
                                    <img src="'.$thumbnail.'" alt="'.$course->post_title.'">
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
}



