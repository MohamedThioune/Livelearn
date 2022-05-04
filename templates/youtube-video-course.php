
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
  <title>Video Course</title>
</head>

<body>
  <h1>Youtube data API V3 integration </h1>
  <?php
  /** Template Name: Youtube Video V3 */ 
  $api_key = "AIzaSyDesrtvddE6l7tfbsPB3CTexWtqLwgNBK8";

  $youtube_channels_id = get_field('youtube_channels', 'user_'. 3);

  foreach($youtube_channels_id as $youtube_channel){
    $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?part=snippet&part=contentDetails&channelId=" . $youtube_channel . " &key=" . $api_key; 
  
    $playlists = json_decode(file_get_contents($url_playlist),true);

    var_dump($playlists);
    
    foreach($playlists as $key => $video){

        var_dump($video);

        $detail_video = json_decode(file_get_contents('' . $video['data']['id']),true);
        $detail_data = $detail_video[0]['data']['course'];
        $data = $detail_video[0]['data']; 

        /* CONTENT */

        //Check the existing value with metadata
        $meta_key = "course";
        $meta_value = strval('VIDEO_'. $detail_data['id']);
        $meta_data = get_user_meta(1, $meta_key);

        $meta_xmls = array();
        foreach($meta_data as $value){
            $meta_xml = explode('-',$value)[0];
            array_push($meta_xmls, $meta_xml);
        }

        //Get the url media image to display on front
        $image = $detail_data['featured_image'];

        $post = array(
        'short_description' =>  '',
        'long_description' => '',
        'url_image' =>  '',
        'prijs' => 0,
        'teacher_id' => '',
        );

        if(!in_array($meta_value, $meta_xmls)){  

            //Data to create the course
            $post_data = array(
            'post_title' => $detail_data['name'],
            'post_author' => 36,
            'post_type' => 'course',
            'post_status' => 'publish'
            );
    
            //Create the course
            $post_id = wp_insert_post($post_data);
            $meta = $meta_value . '-' . $post_id;
            echo $author_id;
            /*
            * * Create for product course
            */
            $data = array(
            'post_author' => 36,
            'post_content' => ' ',
            'post_status' => 'publish',
            'post_title' => $data['name'],
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
        
            if(add_user_meta(1, $meta_key, $meta))
            echo '✔️';
    
            
            //Update custom fields for the post
            update_field('price', 0, $post_id);
            update_field('url_image_xml', strval($post['url_image']), $post_id);
            update_field('short_description', strval($post['short_description']), $post_id);
            update_field('long_description', strval($post['long_description']), $post_id);
        
            /*  
            ** Course type
            */

            update_field('course_type', 'video', $post_id);
            
            /*    
            ** sub-topic
            */
            
            $tags = array();
    
            $cats = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'orderby'    => 'name',
                'exclude' => 'Uncategorized',
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) );
    
            foreach($detail_data['categories'] as $searchword){
            $searchword = strtolower(strval($searchword['name']));
            foreach($cats as $category){
                $cat_slug = strval($category->slug);
                $cat_name = explode(strval($category->cat_name));             
                if(strpos($searchword, $cat_slug) !== false || in_array($searchword, $cat_name))
                array_push($tags, $category->cat_ID);
            }
            }
    
            update_field('category_xml', $tags, $post_id);
    
            /*  
            ** 
            */
    
            //for who - results - niveau
            echo "<span class='textOpleidRight'> Course_ID: " . $detail_data['id'] . " - Insertion done successfully <br><br></span>";
            }
        else
            echo "<span class='textOpleidRight'> Course_ID: " . $detail_data['id'] . " - Already here <br><br></span>";

        if($key==50)
            break; 
    }
  }
    // $meta_course = 0;
    // foreach($meta_data as $value){
    //     $metax = explode('-',$value);
    //     if($metax[0] == $meta_value){
    //         $meta_course = $metax[1];
    //         break;
    //     } 
    // }

    // $args = array(
    // 'post_type' => 'course', 
    // 'post_status' => 'publish',
    // 'include' => $meta_course,  
    // );

    // $course = get_posts($args);
    // $meta = $meta_value . '-' . $meta_course;

    // if(empty($course)){
    //     delete_user_meta(1, $meta_key, $meta);
    //     echo "****** Course # " . $meta_value . " not detected anymore<br><br>";
    // }

    // //Empty youtube channels after parse
    // update_field('youtube_channels', null , 'user_'. 3)
?>

</body>
</html> 
