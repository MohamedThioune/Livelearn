
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
  <h1>Youtube data API V3 integration </h1>
  <?php
  /** Template Name: Youtube Video V3 Playlist */ 
  $api_key = "AIzaSyDesrtvddE6l7tfbsPB3CTexWtqLwgNBK8";
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

  $youtube_videos = array();

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

      $post = array(
      'short_description' => $playlist['snippet']['description'],
      'long_description' => $playlist['snippet']['description'],
      'url_image' =>  $image,
      'prijs' => 0,
      );

      if(!in_array($meta_value, $meta_xmls)){  

          //Data to create the course
          $post_data = array(
          'post_title' => $playlist['snippet']['title'],
          'post_author' => $author_id,
          'post_type' => 'course',
          'post_status' => 'publish'
          );
  
          //Create the course
          $post_id = wp_insert_post($post_data);
          $meta = $meta_value . '~' . $post_id;
          

          if(add_user_meta(1, $meta_key, $meta))
          echo '✔️';

          /*
          * * Create for product course
          */
              $data = array(
              'post_author' => $author_id,
              'post_content' => ' ',
              'post_status' => 'publish',
              'post_title' => $playlist['snippet']['title'],
              'post_parent' => '',
              'post_type' => 'product'
              );
      
              $product_id = wp_insert_post($data);
      
              //update course data as well
              update_post_meta( $post_id, 'connected_product', $product_id);
              wp_set_object_terms( $product_id, 'simple', 'product_type');
              update_post_meta( $product_id, '_visibility', 'visible' );
              update_post_meta( $product_id, '_virtual', 'yes');
              update_post_meta( $product_id, '_regular_price', intval($post['prijs']));
              update_post_meta( $product_id, '_price', intval($post['prijs']));
              update_post_meta( $product_id, '_manage_stock', "no" );
          /*
          * * end
          */
      
       
  
          //Update custom fields for the post
          update_field('price', $post['prijs'], $post_id);
          update_field('url_image_xml', strval($post['url_image']), $post_id);
          update_field('short_description', strval($post['short_description']), $post_id);
          update_field('long_description', strval($post['long_description']), $post_id);
      
          /*  
          ** Course type *
          */

          update_field('course_type', 'video', $post_id);
          
          $url_playlist = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $playlist['id'] . "&maxResults=" . $maxResults . "&key=" . $api_key;        

          $detail_playlist = json_decode(file_get_contents($url_playlist, true));

          foreach($detail_playlist->items as $key => $video){
              $youtube_video = array();
              $youtube_video['id'] = $video->snippet->resourceId->videoId;
              $youtube_video['title'] = $video->snippet->title;
              $youtube_video['thumbnail_url'] = $video->snippet->thumbnails->high->url; 
              
              array_push($youtube_videos, $youtube_video);
          }

          update_field('youtube_videos', $youtube_videos, $post_id);
          
          /*  
          ** *
          */

          echo "<span class='textOpleidRight'> Course_ID: " . $playlist['id'] . " - Insertion done successfully <br><br></span>";
          break;
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
          $meta = $meta_value . '-' . $meta_course;
      
          if(empty($course)){
              delete_user_meta(1, $meta_key, $meta);
              echo "****** Course # " . $meta_value . " not detected anymore<br><br>";
          }
          else
              echo "<span class='textOpleidRight'> Course_ID: " . $detail_data['id'] . " - Already here <br><br></span>";
      
      }

      // if($key==50)
      //     break; 
    }
  }

    // Empty youtube channels after parse
    update_field('youtube_playlists', null , 'user_'. $author_id)
?>

</body>
</html> 
