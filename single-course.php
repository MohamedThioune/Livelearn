<?php
get_header();

global $post;

$cid = get_the_id();
$course_price = get_field('price', $cid);
$course_preview = get_field('preview', $cid);

//Image author of this post 
$image_author = get_field('profile_img',  'user_'.$post->post_author);

$courses = get_field('data_virtual', $cid);

$youtube_videos = get_field('youtube_videos', $cid);

$tree = get_the_category($cid);

if($tree){
    if(isset($tree[2]))
        $category = $tree[2]->cat_name;
    else 
        if(isset($tree[1]))
            $category = $tree[1]->cat_name;
}else 
    $category = ' ~ ';
/*
* Price 
*/
$p = get_field('price', $cid);
if($p != "0")
    $course_price =  number_format($p, 2, '.', ',');
else 
    $course_price = 'Gratis';

/*
* Preview
*/ 
$thumbnail = get_the_post_thumbnail_url($cid);
if(!$thumbnail)
    $thumbnail = get_stylesheet_directory_uri() . '/img/placeholder.png';


$course_type = get_field('course_type');

$offline = ['Masterclass', 'Opleidingen', 'Workshop', 'Cursus', 'Training'];
$online = ['E-learning', 'Video', 'Webinar'];

if(in_array($course_type, $online)){
    //get_template_part('template-parts/modules', )
    include_once('template-parts/modules/single-course-online.php');
}else if(in_array($course_type, $offline)){
    include_once('template-parts/modules/single-course-offline.php');
}

?> 

<?php

get_footer();

?>
