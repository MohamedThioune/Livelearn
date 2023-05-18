<?php /** Template Name: youtube playlist */ ?>
<?php

global $wpdb;

$table = $wpdb->prefix . 'databank';

$user_connected = wp_get_current_user();

?>
<?php
  $api_key = "AIzaSyB0J1q8-LdT0994UBb6Q35Ff5ObY-Kqi_0";
  $maxResults = 45;

  $users = get_users();

  $author_id = 0;

  foreach($users as $user){
      $name_user = strtolower($user->data->display_name);

      if($name_user == "youtube"){
        $author_id = intval($user->data->ID);
        $name_user = $user->display_name;
        break;
      }
  }
//youtube-playlist from excel

extract($_POST);
if ($playlist_youtube){
    $fileName = get_stylesheet_directory_uri() . "/files/Big-Youtube-list-Correct-test.csv";
    $file = fopen($fileName, 'r');
    if ($file) {
        $playlists_id = array();
        $urlPlaylist = [];

        while ($line = fgetcsv($file)) {
            $row = explode(';',$line[0]);
            $playlists_id[][$row[4]] = $row[2];
        }
        fclose($file);
    }else {
        echo "<span class='text-center alert alert-danger'>not possible to read the file</span>";
    }
    array_shift($playlists_id); //remove the tittle of the colone

    if($playlists_id || !empty($playlists_id))
    foreach($playlists_id as $playlist_id){
        $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?order=date&part=snippet&id=" . $playlist_id . "&key=" . $api_key; 
        $playlists = json_decode(file_get_contents($url_playlist),true);
        foreach($playlists['items'] as $key => $playlist){
            // var_dump($playlist);
            // die();
            //Check the existing value with metadata
            $meta_key = "course";
            $meta_value = strval($playlist['id']);
            $meta_data = get_user_meta(1, $meta_key);
            // echo $playlist;
            $meta_xmls = array();
            foreach($meta_data as $value){
                $meta_xml = explode('~', $value)[0];
                array_push($meta_xmls, $meta_xml);
            }

        //Get the url media image to display on front
        $image = ( isset($playlist['snippet']['thumbnails']['maxres']) ) ? $playlist['snippet']['thumbnails']['maxres']['url'] : $playlist['snippet']['thumbnails']['standard']['url'];

        if(!in_array($meta_value, $meta_xmls)){  
            $url_playlist = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $playlist['id'] . "&maxResults=" . $maxResults . "&key=" . $api_key;        
                
            $detail_playlist = json_decode(file_get_contents($url_playlist, true));
            $youtube_videos = '';
            foreach($detail_playlist->items as $key => $video){
                $youtube_video = '';
                $youtube_video .=  $video->snippet->resourceId->videoId;
                $youtube_video .= '~' . $video->snippet->title;
                $youtube_video .= '~' . $video->snippet->thumbnails->high->url; 
                
                $youtube_videos .= ';' . $youtube_video;
            }

            $status = 'extern';

            //Data to create the course
            $type = substr($playlist_id, 0, 2)=='PL' ? 'Playlist':'Video';
            $data = array(
                'titel' => $playlist['snippet']['title'],
                'type' => $type,
                'videos' => $youtube_videos, 
                'short_description' => $playlist['snippet']['description'],
                'long_description' => $playlist['snippet']['description'],
                'duration' => null, 
                'prijs' => 0, 
                'prijs_vat' => 0,
                'image_xml' => $image, 
                'onderwerpen' => null, 
                'date_multiple' => null, 
                'course_id' => null,
                'author_id' => 0,
                'status' => $status
            );
            echo $data;
            $wpdb->insert($table,$data);
            $post_id = $wpdb->insert_id;

            $meta = $meta_value . '~' . $post_id;          

            if(add_user_meta(1, $meta_key, $meta))
                echo '✔️';

            echo "<span class='textOpleidRight'> Course_ID : " . $playlist['id'] . " - Insertion done successfully <br><br></span>";
        }else{
            $meta_course = 0;
            foreach($meta_data as $value){
                $metax = explode('~',$value);
                if($metax[0] == $meta_value){
                    $meta_course = $metax[1];
                    break;
                } 
          }
      
          $args = array(
          'post_type' => 'course', 
          'post_status' => 'publish',
          'include' => $meta_course,  
          );
      
          $course = get_posts($args);
          $meta = $meta_value . '~' . $meta_course;
        //   var_dump($meta);
          if(empty($course)){
              delete_user_meta(1, $meta_key, $meta);
              echo "****** Course # " . $meta_value . " not detected anymore<br><br>";
          }
          else
              echo "<span class='textOpleidRight'> Course_ID: " . $detail_data['id'] . " - Already here <br><br></span>";
        }
      }
    }
  else
    echo '<h3>No news playlists found</h3>';

  //Empty youtube channels after parse
  update_field('youtube_playlists', null , 'user_'. $author_id);    
}