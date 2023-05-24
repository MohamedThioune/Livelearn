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
    $fileName = get_stylesheet_directory_uri() . "/files/Big-Youtube-list-Correct.csv";
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
    if($playlists_id)
        foreach($playlists_id as $playlist_id){
            $playlists = json_decode(file_get_contents($url_playlist),true);
            $author = array_keys($playlist_id)[0];
            $playlistId = array_values($playlist_id)[0];
            $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?order=date&part=snippet&id=" . $playlistId . "&key=" . $api_key;
            $author_id = 0;
            $type = '';
            foreach($users as $user){
                $company_user = get_field('company', 'user_' . $user->ID);
                if (isset($company_user[0]->post_title)) {
                    if (strtolower($user->display_name) == strtolower($author[0])) {
                        $author_id = $user->ID;
                        $company = $company_user[0];
                        $company_id = $company_user[0]->ID;
                        var_dump($author_id);
                    } else {
                        // insert this new user company in plateform.
                        //var_dump('a problem has occured');
                        //continue;
                    }
                }else {
                    //var_dump('ffffffffffffffffff');
                    continue;
                }
                if($playlists['items']) {
                    foreach ($playlists['items'] as $key => $playlist) {
                        //Check the existing value with metadata
                        $meta_key = "course";
                        $meta_value = strval($playlist['id']);
                        $meta_data = get_user_meta(1, $meta_key);
                        $meta_xmls = array();
                        foreach ($meta_data as $value) {
                            $meta_xml = explode('~', $value)[0];
                            array_push($meta_xmls, $meta_xml);
                        }

                        //Get the url media image to display on front
                        $image = (isset($playlist['snippet']['thumbnails']['maxres'])) ? $playlist['snippet']['thumbnails']['maxres']['url'] : $playlist['snippet']['thumbnails']['standard']['url'];

                        if (!in_array($meta_value, $meta_xmls)) {
                            $url_playlist = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $playlist['id'] . "&maxResults=" . $maxResults . "&key=" . $api_key;

                            $detail_playlist = json_decode(file_get_contents($url_playlist, true));
                            $youtube_videos = '';
                            foreach ($detail_playlist->items as $key => $video) {
                                $youtube_video = '';
                                $youtube_video .= $video->snippet->resourceId->videoId;
                                $youtube_video .= '~' . $video->snippet->title;
                                $youtube_video .= '~' . $video->snippet->thumbnails->high->url;

                                $youtube_videos .= ';' . $youtube_video;
                            }

                            $status = 'extern';

                            //Data to create the course
                            $type = substr($playlistId, 0, 2) == 'PL' ? 'Playlist' : 'Video';
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
                                'status' => $status
                            );
                            var_dump($data);
                            $wpdb->insert($table, $data);
                            $post_id = $wpdb->insert_id;

                            $meta = $meta_value . '~' . $post_id;

                            if (add_user_meta(1, $meta_key, $meta))
                                echo '✔️';

                            echo "<span class='textOpleidRight'> Course_ID : " . $playlist['id'] . " - Insertion done successfully <br><br></span>";
                        } else {
                            $meta_course = 0;
                            foreach ($meta_data as $value) {
                                $metax = explode('~', $value);
                                if ($metax[0] == $meta_value) {
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
                            if (empty($course)) {
                                delete_user_meta(1, $meta_key, $meta);
                                echo "****** Course # " . $meta_value . " not detected anymore<br><br>";
                            } else
                                echo "<span class='textOpleidRight'> Course_ID: " . $detail_data['id'] . " - Already here <br><br></span>";
                        }
                    }
                }
            }
        }
  else
    echo '<h3>No news playlists found</h3>';

  //Empty youtube channels after parse
  update_field('youtube_playlists', null , 'user_'. $author_id);    
}