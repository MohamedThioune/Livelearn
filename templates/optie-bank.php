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
        $args = array(
            'post_type'   => 'post',
            'post_author' => $course->author_id,
            'post_status' => 'publish',
            'post_title'  => $course->titel
        );
        
        $id_post = wp_insert_post($args);

        //Insert some other course type
        $type = ['Opleidingen', 'Training', 'Masterclass', 'E-learning', 'Webinar'];
        $typos = ['Opleidingen' => 'course', 'Training' => 'training', 'Workshop' => 'workshop', 'Masterclass' => 'masterclass', 'E-learning' => 'elearning', 'Video' => 'video', 'Webinar' => 'webinar' ];

        //Insert Artikel
        if (strval($course->type) == "Artikel"){
            update_field('course_type', 'article', $id_post);
            update_field('article_itself', nl2br($course->long_description), $id_post);
        }

        //Insert YouTube
        else if (strval($course->type) == "Video"){
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
        }

        
        else if(in_array(strval($course->type), $type)){
            $coursetype = "";
            foreach($typos as $key => $typo)
                if($course->type == $key)
                    $coursetype == $typo;
            
            update_field('course_type', $typos[$course->type] , $id_post);
        }

        $onderwerpen = explode(',', $course->onderwerpen);

        /*
        ** UPDATE COMMON FIELDS
        */

        update_field('short_description', nl2br($course->short_description), $id_post);
        update_field('long_description', nl2br($course->long_description), $id_post);
        update_field('url_image_xml', $course->image_xml, $id_post);
        update_field('categories', $onderwerpen, $id_post);

        if( $course->company_id != 0 && $course->author_id != 0 ){
            $company = get_post($course->company_id);
            update_field('company', $company, 'user_' . $course->author_id);
        }

        //Date
        $data_locaties = explode('~', strval($course->date_multiple));
        if($data_locaties)
            update_field('data_locaties_xml', $data_locaties, $id_post);

        /*
        ** END
        */
        
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