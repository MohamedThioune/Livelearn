<?php
/** Template Name: Youtube Video V3 Playlist */ 

global $wpdb;

$table = $wpdb->prefix . 'databank';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/style.css">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

  <script src="https://kit.fontawesome.com/2def424b14.js" crossorigin="anonymous"></script>
  <title>Video Course - Playlist</title>
</head>

<body>
  <h1>Youtube data API V3 - Playlist </h1>
  <?php
  /** Template Name: Youtube Video V3 Playlist */ 
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

  $playlists_id = get_field('youtube_playlists', 'user_'. $author_id);

  if($playlists_id || !empty($playlists_id))
    foreach($playlists_id as $playlist_id){
      $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?order=date&part=snippet&id=" . $playlist_id . "&key=" . $api_key; 
    
      $playlists = json_decode(file_get_contents($url_playlist),true);
      foreach($playlists['items'] as $key => $playlist){
        //Check the existing value with metadata
        $meta_key = "course";
        $meta_value = strval($playlist['id']);
        $meta_data = get_user_meta(1, $meta_key);

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
          $data = array(
            'titel' => $playlist['snippet']['title'],
            'type' => 'Video',
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
          $wpdb->insert($table,$data);
          $post_id = $wpdb->insert_id;

          $meta = $meta_value . '~' . $post_id;          

          if(add_user_meta(1, $meta_key, $meta))
            echo '✔️';

          echo "<span class='textOpleidRight'> Course_ID : " . $playlist['id'] . " - Insertion done successfully <br><br></span>";
        }
        else{
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
?>

</body>
</html> 
