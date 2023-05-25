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
  $args = array(
      'post_type' => 'company', 
      'posts_per_page' => -1,
  );
  $companies = get_posts($args);


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
    // var_dump($playlists_id);
    if($playlists_id || !empty($playlists_id)){
        foreach($playlists_id as $playlist_id){
            $id_playlist = array_values($playlist_id);
            // var_dump($id_playlist[0]);
            $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?order=date&part=snippet&id=" . $id_playlist[0] . "&key=" . $api_key; 
            $playlists = json_decode(file_get_contents($url_playlist),true);
            $author = array_keys($playlist_id);
            // var_dump("for user ",$author[0]);
            $author_id = null;
            foreach($users as $user) {
                $company_user = get_field('company',  'user_' . $user->ID);
                if(isset($company_user[0]->post_title)) 
                    if(strtolower($user->display_name)== strtolower($author[0]) ){
                        $author_id = $user->ID;
                        $company = $company_user[0];
                        $company_id = $company_user[0]->ID;
                        // var_dump($author_id.'->'.$company_id);
                        // continue;
                    }
            }
            //Accord the author a company
            // if(!is_wp_error($author_id))
            //     update_field('company', $company, 'user_' . $author_id);
            
            foreach($playlists['items'] as $key => $playlist){
                
                //define type (Video or Playlist)
                $type = substr($id_playlist[0], 0, 2)=='PL' ? 'Playlist':'Video';

                //Get the url media image to display on front
                $image = ( isset($playlist['snippet']['thumbnails']['maxres']) ) ? $playlist['snippet']['thumbnails']['maxres']['url'] : $playlist['snippet']['thumbnails']['standard']['url'];
                $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images, $type));
                $result_image = $wpdb->get_results($sql_image);
                $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s",array($playlist['snippet']['title'],$type));
                $result_title = $wpdb->get_results($sql_title);
                if(!isset($result_title[0]) && !isset($result_image[0])){  
                    $url_playlist = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $playlist['id'] . "&maxResults=" . $maxResults . "&key=" . $api_key;        
                    
                    // var_dump('ici');
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
                        'author_id' => $author_id,
                        'company_id' =>  $company_id,
                        'status' => $status
                    );
                    // var_dump ($data);
                    $wpdb->insert($table,$data);
                    $post_id = $wpdb->insert_id;

                    echo "<span class='textOpleidRight'> Course_ID : " . $playlist['id'] . " - Insertion done successfully <br><br></span>";
                }else{
                    // var_dump('iciiiii');
                    continue;
                }
            
            }
        }
    }else
        echo '<h3>No news playlists found</h3>';

  //Empty youtube channels after parse
  update_field('youtube_playlists', null , 'user_'. $author_id);    
}