
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/style.css">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css">

  <script src="https://kit.fontawesome.com/2def424b14.js" crossorigin="anonymous"></script>
  <title>Parse Course</title>
</head>

<body>

  <?php
  /** Template Name: xml parse */ 
 
  //Get all users
  $users = get_users(); 
   
  //Get the URL content
  $file = get_stylesheet_directory_uri()."/beeckestijn-20220310.2055.xml";
  $xml = simplexml_load_file($file);
  $data_xml = $xml->program;

  //Start inserting course 
  echo "<h2 class='titleGroupText'>RESUME <i class='fas fa-spinner fa-pulse'></i> </h2>";

  $author_id = 0;

  //Retrieve courses
  foreach($data_xml as $datum){
    $attachment_xml = array();
    $data_locaties_xml = array();

    //Check the existing value with metadata
    $meta_key = "course";
    $meta_value = strval($datum->programClassification->programId);

    $meta_data = get_user_meta(1, $meta_key);

    $meta_xmls = array();
    foreach($meta_data as $value){
      $meta_xml = explode('-',$value)[0];
      array_push($meta_xmls, $meta_xml);
    }

    //Get the url media image to display on front
    $attachment = "";
    foreach($datum->programDescriptions->media as $media){
      if($media->type == "image")
        $image = $media->url;
      else
        array_push($attachment_xml, $media->url);
    }    
      
    if($datum->programDescriptions->programDescriptionHtml)
      $descriptionHtml = $datum->programDescriptions->programDescriptionHtml;
    else
      $descriptionHtml = $datum->programDescriptions->programDescriptionText;

    $post = array(
      'short_description' => $datum->programDescriptions->programSummaryText,
      'long_description' => $descriptionHtml,
      'agenda' => $datum->programDescriptions->programDescriptionText,
      'url_image' => $image,
      'prijs' => $datum->programSchedule->genericProgramRun->cost->amount,
      'prijsvat' => $datum->programSchedule->genericProgramRun->cost->amountVAT,
      'degree' => $datum->programClassification->degree,
      'teacher_id' => $datum->programCurriculum->teacher->id,
      'org' => $datum->programClassification->orgUnitId,
      'duration_day' => $datum->programClassification->programDuration,
    );

    $title = explode(' ', strval($datum->programDescriptions->programName));
    $description = explode(' ', strval($datum->programDescriptions->programSummaryText));
    $descriptionHtml = explode(' ', strval($datum->programDescriptions->programSummaryHtml));    
    $keywords = array_merge($title, $description, $descriptionHtml);

    /*
    * * Tags *
    */ 
    $tags = array();
    $categories = array(); 
    $cats = get_categories( array(
      'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
      'orderby'    => 'name',
      'exclude' => 'Uncategorized',
      'parent'     => 0,
      'hide_empty' => 0, // change to 1 to hide categores not having a single post
      ) );

    foreach($cats as $item){
      $cat_id = strval($item->cat_ID);
      $item = intval($cat_id);
      array_push($categories, $item);
    };

    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $categorys = array(); 
    foreach($categories as $categ){
        //Topics
        $topics = get_categories(
            array(
            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) 
        );

        foreach ($topics as $value) {
            $tag = get_categories( 
                 array(
                 'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                 'parent'  => $value->cat_ID,
                 'hide_empty' => 0,
                ) 
            );
            $categorys = array_merge($categorys, $tag);      
        }
    }
    
    foreach($datum->programDescriptions->searchword as $searchword){
      $searchword = strtolower(strval($searchword));
      foreach($categorys as $category){
        $cat_slug = strval($category->slug);
        $cat_name = explode(strval($category->cat_name));             
        if(strpos($searchword, $cat_slug) !== false || in_array($searchword, $cat_name))
          array_push($tags, $category->cat_ID);
      }
    }

    if(empty($tags)){
      $occurrence = array_count_values(array_map('strtolower', $keywords));
      arsort($occurrence);
      foreach($categorys as $value)
        if($occurrence[strtolower($value->cat_name)] >= 1)
          array_push($tags, $value->cat_ID);
    }

    /* 
    ** Get author of the course 
    */

    foreach($users as $user) {
      $teacher_id = get_field('teacher_id',  'user_' . $user->ID);
      $company_user = get_field('company',  'user_' . $user->ID);
      
      if(strtolower($company_user[0]->post_title) == strval($post['org']) ){
        $author_id = $user->ID;

        if(strpos($teacher_id, strval($post['teacher_id'])) !== false){
          $author_id = $user->ID;
          break;
        }   
      }
    }
    
    if(!in_array($meta_value, $meta_xmls)){  
      //Modify the dates 
      foreach($datum->programSchedule->programRun as $program){
        $info = array();
        $infos = "";
        $row = "";
        foreach($program->courseDay as $courseDay){
          $dates = explode('-',strval($courseDay->date));
          //format date 
          $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
          
          $info['start_date'] = $date . " ". strval($courseDay->startTime);
      
          $info['end_date'] = $date . " ". strval($courseDay->endTime);
      
          $info['location'] = strval($courseDay->location->city);
      
          $info['adress'] = strval($courseDay->location->address);
      
          $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;
          
          $infos =  $infos .';'.$row ; 

        }

        array_push($data_locaties_xml, $infos);
        
        update_field('data_locaties_xml', $data_locaties_xml, $meta_course);
      }

      //Data to create the course
      $post_data = array(
        'post_title' => $datum->programDescriptions->programName,
        'post_author' => $author_id,
        'post_type' => 'course',
        'post_status' => 'publish'
      );

      //Create the course
      $post_id = wp_insert_post($post_data);
      $meta = $meta_value . '-' . $post_id;

      /*
      * * Create for product course
      */
      $data = array(
        'post_author' => get_current_user_id(),
        'post_content' => ' ',
        'post_status' => 'publish',
        'post_title' => $datum->programDescriptions->programName,
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

      //Get the url media image to display on front
      foreach($datum->programDescriptions->media as $media)
        if($media->type == "image"){
          $image = $media->url;
          break;
        }
      
      //Update custom fields for the post
      update_field('agenda', strval($post['agenda']), $post_id);
      update_field('price', intval($post['prijs']), $post_id);
      update_field('prijsvat', intval($post['prijsvat']), $post_id);
      update_field('url_image_xml', strval($post['url_image']), $post_id);
      update_field('short_description', strval($post['short_description']), $post_id);
      update_field('long_description', strval($post['long_description']), $post_id);
      update_field('degree', strval($post['degree']), $post_id);
      update_field('duration_day', intval($post['duration_day']), $post_id);

      update_field('attachment_xml', $attachment_xml, $post_id);

      update_field('data_locaties_xml', $data_locaties_xml , $post_id);

      /*  
      ** Course type
      */
      
      if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords)){
        update_field('course_type', 'masterclass', $post_id);
      }else if(in_array('(training)', $keywords) || in_array('training', $keywords)){
        update_field('course_type', 'training', $post_id);
      }else if(in_array('live', $keywords) && in_array('seminar', $keywords)){
        update_field('course_type', 'webinar', $post_id);
      }else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) ){
        update_field('course_type', 'elearning', $post_id);
      }else{ 
        update_field('course_type', 'course', $post_id);
      }
      
      /*    
      ** Tags add
      */
        
      update_field('category_xml', $tags, $post_id);

      $arg = array(
          'ID' => $post_id,
          'post_author' => $author_id,
      );
      wp_update_post($arg); 
    
      $data_locaties_xml = array();
    
      //Modify the dates 
      foreach($datum->programSchedule->programRun as $program){
        $info = array();
        $infos = "";
        $row = "";
        foreach($program->courseDay as $key => $courseDay){
          $dates = explode('-',strval($courseDay->date));
          //format date 
          $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
          
          $info['start_date'] = $date . " ". strval($courseDay->startTime);
          $info['end_date'] = $date . " ". strval($courseDay->endTime);
          $info['location'] = strval($courseDay->location->city);
          $info['adress'] = strval($courseDay->location->address);
      
          $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;

          $infos .= $row ; 

          $infos .= ';' ; 
            
        }

        if(substr($infos, -1) == ';')
          $infos = rtrim($infos, ';');

        array_push($data_locaties_xml, $infos);
        
        update_field('data_locaties_xml', $data_locaties_xml, $post_id);

      }
      
      /*  
      ** 
      */

      //for who - results - niveau
      echo "<span class='textOpleidRight'> Course_ID: " . $datum->programClassification->programId . " - Insertion done successfully <br><br></span>";
    }
    else{
      $meta_course = 0;
      foreach($meta_data as $value){
          $metax = explode('-',$value);
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

      update_field('attachment_xml', $attachment_xml, $meta_course);

      if(empty($course)){
        delete_user_meta(1, $meta_key, $meta);
        echo "****** Course # " . $course[0]->post_title . " not detected anymore<br><br>";
      }
      else{
        $change  = false;
        $message = 'field on change detected and applied<br><br>';

        //Update custom fields for the post
        $prijs = get_field('price', $meta_course);
        $prijsvat = get_field('prijsvat', $meta_course);
        $url_image = get_field('url_image_xml', $meta_course);
        $short_description = get_field('short_description', $meta_course);
        $long_description = get_field('long_description', $meta_course);
        $agenda = get_field('agenda', $meta_course);
        $degree = get_field('degree', $meta_course);
        $duration_day = get_field('duration_day', $meta_course);

        /*  
        ** Course type
        */
        
        if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords))
          update_field('course_type', 'masterclass', $meta_course);
        else if(in_array('(training)', $keywords) || in_array('training', $keywords))
          update_field('course_type', 'training', $meta_course);
        else if(in_array('Live', $keywords) || in_array('Online', $keywords))
          update_field('course_type', 'elearning', $meta_course);
        else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) )
          update_field('course_type', 'webinar', $meta_course);
        else 
          update_field('course_type', 'course', $meta_course);

        echo "<span class='textLiDashboard'>Course_ID: " . strval($datum->programDescriptions->programName) . " - Already in your database <br><span class='werkText'>Searching for changes ...</span><br></span>";
      
        if($prijs != intval($post['prijs'])){
          update_field('price', intval($post['prijs']), $meta_course);
          echo '****** Prijs - ' . $message; 
          $change = true;
        }
        if($prijsvat != intval($post['prijsvat'])){
          update_field('prijsvat', intval($post['prijsvat']), $meta_course);
          echo '****** Prijs VAT ' . $message; 
          $change = true;
        }
        if($url_image != strval($post['url_image'])){
          update_field('url_image_xml', strval($post['url_image']), $meta_course);
          echo '****** Image : url - ' . $message;
          $change = true; 
        }
        if($short_description != strval($post['short_description'])){
          update_field('short_description', strval($post['short_description']), $meta_course); 
          echo '****** Excerpt - ' . $message;
          $change = true;
        }
        if($long_description != strval($post['long_description'])){
          update_field('long_description', strval($post['long_description']), $meta_course); 
          echo '****** Long description - ' . $message;
          $change = true;
        }
      
        if($agenda != intval($post['agenda'])){
        update_field('agenda', strval($post['agenda']), $meta_course); 
        echo '****** Agenda - ' . $message;
        $change = true;
        }

        if($degree != intval($post['degree'])){
          update_field('degree', strval($post['degree']), $meta_course); 
          echo '****** Degree - ' . $message;
          $change = true;
        }

        if($duration_day != intval($post['duration_day'])){
          update_field('duration_day', intval($post['duration_day']), $meta_course); 
          echo '****** Program Duration Day - ' . $message;
          $change = true;
        }

        
        if(!$change)
          echo '*** ~ *** No change found for this course ! *** ~ ***<br><br>';
      
        /*
        ** Available in next version
        if($data_locaties_xml == intval($post['prijs']))
        echo 'Data en locaties - ' . $message;
        */

        /*
        * * Tags update
        */
        

        update_field('category_xml', $tags, $meta_course);
        
        
        $data_locaties_xml = array();
       
        //Modify the dates 
        foreach($datum->programSchedule->programRun as $program){
            $info = array();
            $infos = "";
            $row = "";
            foreach($program->courseDay as $key => $courseDay){
              $dates = explode('-',strval($courseDay->date));
              //format date 
              $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
              
              $info['start_date'] = $date . " ". strval($courseDay->startTime);
              $info['end_date'] = $date . " ". strval($courseDay->endTime);
              $info['location'] = strval($courseDay->location->city);
              $info['adress'] = strval($courseDay->location->address);
          
              $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;

              $infos .= $row ; 

              $infos .= ';' ; 
                
            }

            if(substr($infos, -1) == ';')
              $infos = rtrim($infos, ';');

            array_push($data_locaties_xml, $infos);
            
            update_field('data_locaties_xml', $data_locaties_xml, $meta_course);

        }
        /*  
        ** 
        */ 
      }

    }
  }

  echo "<h2 class='titleGroupText'> End .</h2>";



  

?>

</body>
</html> 
