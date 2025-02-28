<?php /** Template Name: Optie bank */ ?>

<?php

require_once 'detect-language.php';
// require_once  get_stylesheet_directory().'/script-endpoints.php';

global $wpdb;
$table = $wpdb->prefix . 'databank';
$table_post_additionnal = $wpdb->prefix . 'post_additionnal';

extract($_POST);
$sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);
$course = $wpdb->get_results( $sql )[0];

$origin_id = $course->org;
$feedid = $course->course_id;
$users = get_users();
$user_connected = wp_get_current_user();

$where = [ 'id' => $id ]; 

// NULL value in WHERE clause.
if($optie == "✔"){
       
      
    
    
    if($course->image_xml==null)
    {   
   
        if($course->type)
            $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->type) . '.jpg';
        else
            $image = get_stylesheet_directory_uri() . '/img' . '/opleidingen.jpg';       
        $course->image_xml=$image;
        $wpdb->update($table,$course->image_xml,$where); 
    }

   

       
      
   

        

    
    if (!$course->short_description){
            $course->short_description = "no short description !";
    }
    if(!$course->titel){
        echo '<pre> Title value is null</pre>';
        http_response_code(500);
        return 0;
    }

    //Insert some other course type
    $type = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'E-learning', 'Lezing', 'Event', 'Webinar','Podcast'];
    $typos = ['Opleidingen' => 'course', 'Workshop' => 'workshop', 'Training' => 'training', 'Masterclass' => 'masterclass', 'E-learning' => 'elearning', 'reading' => 'Lezing', 'event' => 'Event', 'Video' => 'video', 'Webinar' => 'webinar','podcast'=>'Podcast'];

    //Insert Artikel
    if (strval($course->type) == "Artikel"){
        
      
        
        //Creation post
        $args = array(
            'post_type'   => 'post',
            'post_author' => $course->author_id,
            'post_status' => 'publish',
            'post_title'  => $course->titel
        );
        $id_post = wp_insert_post($args, true);
        //Custom

        // if($course->image_xml==null)
        // {
        //     $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->type) . '.jpg'; 
        //     update_field('image_xml', $image, $id_post);
        // }
        update_field('course_type', 'article', $id_post);
        update_field('article_itself', nl2br($course->long_description), $id_post); 
      
    }
    //Insert YouTube
    else if (strval($course->type) == "Video"){
        $fileName = get_stylesheet_directory() . "/db/video.json";
        //Creation course
        $args = array(
            'post_type'   => 'course',
            'post_author' => $course->author_id,
            'post_status' => 'publish',
            'post_title'  => $course->titel
        );
        $id_post = wp_insert_post($args, true);
        //Custom
        $videos = explode(';', $course->videos);
        $youtube_video = array();
        $youtube_videos = array();
        $youtube_videos_json = array();

        foreach($videos as $item){
            $video = explode('~', $item);
            
            if(!isset($video[1]))
                continue;

            $youtube_video['id'] = $video[0];
            $youtube_video['title'] = $video[1];
            $youtube_video['thumbnail_url'] = $video[2];
            array_push($youtube_videos, $youtube_video);


            $youtube_videos_json[] = array(
                'post_id' => $id_post, // so not need to make post type
                'episode_id'=>$video[0],
                'episode_title'=>$video[1],
                'episode_image'=>$video[2]
            );
            // $id_post_additional = $wpdb->insert($table_post_additionnal, $data);
        }

        if ($fileName){
            if (!empty($youtube_videos_json)){
                $old_episodes_json = file_get_contents($fileName);
                $old_episodes_array = json_decode($old_episodes_json,true)?:[];
                $youtube_videos_json = array_merge($old_episodes_array,$youtube_videos_json);
                foreach ($youtube_videos_json as &$item) {
                    array_walk_recursive($item, function (&$value) {
                        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    });
                }
                $newJsonContent = json_encode( $youtube_videos_json,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
                $insert = file_put_contents($fileName,$newJsonContent);
                if ($insert) {
                    echo "content added successfully";
                } else {
                    echo "error content not added !";
                }
            }
        }
        update_field('origin_id', $origin_id, $id_post);
        update_field('course_type', 'video', $id_post);
        update_field('youtube_videos', $youtube_videos, $id_post); // to comment if the proceses well done
    }
    else if (strval($course->type) == 'Podcast'){
        $fileName = get_stylesheet_directory() . "/db/podcast.json";
        //Creation course
        $args = array(
            'post_type'   => 'course',
            'post_author' => $course->author_id,
            'post_status' => 'publish',
            'post_title'  => $course->titel
        );
        $id_post = wp_insert_post($args, true);
        $podcasts = explode('^', $course->podcasts);
        $podcasts = array_reverse($podcasts);
        $podcasts_playlists = [];
        $episodes = [];
        foreach ($podcasts as $key => $item) {
            if (!$item)
                continue;
                if ($key==180)
                    break;

                $podcasts_playlist = [];
                $podcast = explode('~', $item);

                $podcasts_playlist['podcast_url'] = $podcast[0];
                $podcasts_playlist['podcast_title'] = $podcast[1] ? : $course->titel;
                $podcasts_playlist['podcast_description'] = $podcast[2] ? : $course->short_description;
                $podcasts_playlist['podcast_date'] = $podcast[3] ? : date('Y-m-d H:i:s');
                $podcasts_playlist['podcast_image'] = $podcast[4] ? : $course->image_xml;

                $podcasts_playlists [] = $podcasts_playlist;

            $episodes[] = array(
                'post_id' => $id_post, // so not need to make post type
                'episode_id'=> $podcast[0],
                'episode_image'=> $podcast[4],
                'episode_title'=> $podcast[1],
                'episode_description'=>$podcast[2],
                'episode_date' => $podcast[3] ? : date('Y-m-d H:i:s'),
            );
                // $id_post_additional = $wpdb->insert($table_post_additionnal, $data);
        }
        if ($fileName){
            if (!empty($episodes)){
                $old_episodes_json = file_get_contents($fileName)?:'';
                $old_episodes_array = $old_episodes_json ? json_decode($old_episodes_json,true) : [];
                if ($old_episodes_array)
                    $episodes = array_values(array_merge($old_episodes_array,$episodes));
                foreach ($episodes as &$item) {
                    array_walk_recursive($item, function (&$value) {
                        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    });
                }
                $newJsonContent = json_encode( $episodes,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
                $insert = file_put_contents($fileName,$newJsonContent);
                if ($insert) {
                    echo "content added successfully";
                } else {
                    echo "error content not added !";
                }
            }
        }

        update_field('origin_id', $feedid, $id_post);
        update_field('course_type', 'podcast', $id_post);
        update_field('podcasts_index', $podcasts_playlists, $id_post); // to comment if the proceses well done
        // save_podcast_in_json_file($id_post); //just to make sure
    }
    //Insert Others
    else if (in_array(strval($course->type), $type) ) {
        //Creation course
        $args = array(
            'post_type'   => 'course',
            'post_author' => $course->author_id,
            'post_status' => 'publish',
            'post_title'  => $course->titel
        );
        $id_post = wp_insert_post($args, true);
        //Custom
        $coursetype = "";
        foreach($typos as $key => $typo){
            if($course->type == $key) {
                $coursetype == $typo;
            }
        }
        update_field('course_type', $typos[$course->type] , $id_post);
    }
   
       
    if(is_wp_error($id_post)){
        $error = new WP_Error($id_post);
        echo $error->get_error_message($id_post);
    }
    else{
         $language = $course->language==null? detectLanguage($course->titel):$course->language;
        

        if(update_field('language', $language, $id_post))
          echo "<span class='alert alert-success'>validation successfuly ✔️</span>";
        else
           echo "<span class='alert alert-danger'>Error in language added ! ❌</span>";
        
        // echo "post-id : " . $id_post;
       
    }
    $onderwerpen = explode(',', $course->onderwerpen);
    /*
    ** UPDATE COMMON FIELDS
    */

    //Experts
    $contributors = explode(',', $course->contributors);
    if(isset($contributors[0]))
        if($contributors[0] && $contributors[0] != "" && $contributors[0] != " " )
            update_field('experts', $contributors, $id_post);
            
    //Categories
    if(isset($onderwerpen[0]))
        if($onderwerpen[0] && $onderwerpen[0] != "" && $onderwerpen[0] != " " ) {
            wp_set_post_terms($id_post, $onderwerpen, 'course_category');
            //update_field('categories', $onderwerpen, $id_post);
        }
    update_field('short_description', nl2br($course->short_description), $id_post);
    update_field('long_description', nl2br($course->long_description), $id_post);
    update_field('url_image_xml', $course->image_xml, $id_post);

    if( $course->company_id != 0 && $course->author_id != 0 ){
        $company = get_post($course->company_id);
        update_field('company', $company, 'user_' . $course->author_id);
    }

    //Date
    $data_locaties = explode('~', strval($course->date_multiple));
    if($data_locaties)
        if(isset($data_locaties[0]))
            if($data_locaties[0] && $data_locaties[0] != "" && $data_locaties[0] != " " )
                update_field('data_locaties_xml', $data_locaties, $id_post);
    /*
    ** END
    */

    //Prijs
    $course->prijs = ($course->prijs) ? intval($course->prijs) : 0;
    $prijs = ($course->prijs > 0) ? $course->prijs : 0;
    update_field('price', $prijs, $id_post); 

    /*
    ** END
    */
    
    // $data = [ 'course_id' => $id_post]; // NULL value.
    // $wpdb->update( $table, $data, $where );
}     
else if($optie == "❌"){
    if ($class == 'missing'){
        echo "<span class='alert alert-info'>not deleted because is missing</span>";
        null;
    }
    else if ($class == 'present' ){
        wp_trash_post($course->course_id);
        echo "<span class='alert alert-success'>deleted successfuly ✔️</span>";
    }
}

$data = [ 'state' => 1, 'optie' =>  $optie ]; // NULL value.
$updated = $wpdb->update( $table, $data, $where );
return $updated;
