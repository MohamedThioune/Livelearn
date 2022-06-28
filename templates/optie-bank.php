<?php /** Template Name: Optie bank */ ?>

<?php

global $wpdb;

$table = $wpdb->prefix . 'databank'; 

extract($_POST);

$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);
$course = $wpdb->get_results( $sql )[0];

$where = [ 'id' => $id ]; // NULL value in WHERE clause.

if($optie == "accept"){
    if($class == 'missing')
    {
        //Insert Artikel
        if (strval($course->type) == "Artikel")
        {
            $args = array(
                'post_type'   => 'post',
                'post_author' => get_current_user_id(),
                'post_status' => 'publish',
                'post_title'  => $course->titel
            );
            
            $id_post = wp_insert_post($args);
            update_field('course_type', 'article', $id_post);
            update_field('short_description', nl12br($course->short_description), $id_post);
            update_field('article_itself', nl12br($course->long_description), $id_post);
            update_field('url_image_xml', $course->image_xml, $id_post);
            update_field('date_multiple', $course->date_multiple, $id_post);
            update_field('onderwerpen', $course->onderwerpen, $id_post);
            update_field('course_id', $course->course_id, $id_post);
            update_field('author_id', $course->author_id, $id_post);
            update_field('status', $course->status, $id_post);
            update_field('optie', $course->optie, $id_post);
            update_field('type', $course->type, $id_post);
        }

        //Insert YouTube
        if (strval($course->type) == "Video" || strval($course->type) == "video" ){
            echo "hello";
            $args = array(
                'post_type' => 'course',
                'post_author' => $course->author_id,
                'post_status' => 'publish',
                'post_title' => $course->titel
            );

            $id_post = wp_insert_post($args);
            $videos = explode(';', $course->videos);
            
            $youtube_video = array();
            $youtube_videos = array();
            foreach($videos as $item){
                $video = explode('~', $item);
                
                if(!isset($video[1]))
                    continue;

                $youtube_video['id'] = $video[0];
                $youtube_video['title'] = $video[1];
                $youtube_video['thumbnail_url'] = $video[2];

                array_push($youtube_videos, $youtube_video);
            }

            update_field('course_type', 'video', $id_post);
            update_field('youtube_videos', $youtube_videos, $id_post);
            update_field('short_description', $course->short_description, $id_post);
            update_field('long_description', $course->long_description, $id_post);
            update_field('url_image_xml', $course->image_xml, $id_post);
        }

        $data = [ 'course_id' => $id_post]; // NULL value.
        $wpdb->update( $table, $data, $where );
    }
}     
else if($optie == "decline"){
    if ($class == 'missing')
        null;
    else if ($class == 'present' )
        wp_trash_post($course->course_id);
}
$data = [ 'state' => 1, 'optie' =>  $optie ]; // NULL value.

$updated = $wpdb->update( $table, $data, $where );
echo $wpdb->last_error;

if($updated === false)
    return false; 
else 
    return true;

?>