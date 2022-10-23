
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

  global $wpdb;

  $table = $wpdb->prefix . 'databank';
  
  //Get all users
  $users = get_users(); 
   
  //Get the URL content
  $file = get_stylesheet_directory_uri()."/aeres-tech-20221018.0223.xml";
  $xml = simplexml_load_file($file);
  $data_xml = $xml->program;

  //Start inserting course 
  echo "<h2 class='titleGroupText'>RESUME <i class='fas fa-spinner fa-pulse'></i> </h2>";

  $author_id = NULL;


  //Retrieve courses
  $i = 0;
  foreach($data_xml as $key => $datum){
    $i++;
    if($i == 2)
      break;

    $status = 'extern';
    $course_type = "";
    $image = "";

    //Get the url media image to display on front
    foreach($datum->programDescriptions->media as $media)
      if($media->type == "image"){
        $image = $media->url;
        break;
      }

    //Redundance check "Image & Title"
    $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
    $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum->programDescriptions->programName));

    $check_image = $wpdb->get_results($sql_image);
    $check_title = $wpdb->get_results($sql_title);
    
    $post = array(
      'short_description' => $datum->programDescriptions->programSummaryText,
      'long_description' => null,
      'agenda' => $datum->programDescriptions->programDescriptionText,
      'url_image' => $image,
      'prijs' => $datum->programSchedule->genericProgramRun->cost->amount,
      'prijsvat' => $datum->programSchedule->genericProgramRun->cost->amountVAT,
      'degree' => $datum->programClassification->degree,
      'teacher_id' => $datum->programCurriculum->teacher->id,
      'org' => $datum->programClassification->orgUnitId,
      'duration_day' => $datum->programClassification->programDuration,
    );
  
    $attachment_xml = array();
    $data_locaties_xml = array();

    /*
    ** Check the existing value with metadata
    $meta_key = "course";
    $meta_value = strval($datum->programClassification->programId);

    $meta_data = get_user_meta(1, $meta_key);

    $meta_xmls = array();
    foreach($meta_data as $value){
      $meta_xml = explode('~',$value)[0];
      array_push($meta_xmls, $meta_xml);
    }
    **
    */

    /*
    ** -- Main fields --
    */ 
    
    //Implemet author 
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

    if(!$author_id)
    {
      $args = array(
          'post_type' => 'company', 
          'posts_per_page' => -1,
      );

      $companies = get_posts($args);
      $company = NULL;
      foreach($companies as $value) 
        if(strtolower($value->post_title) == strval($post['org']) ){
          $company = $value;
          break;
        }

      $login = RandomString();
      $password = RandomString();
      $email = "author@expertise.nl";
      $first_name = explode(' ', strval($datum->programCurriculum->teacher->name))[0];
      $last_name = explode(' ', strval($datum->programCurriculum->teacher->name))[1];

      $userdata = array(
          'user_pass' => $password,
          'user_login' => $login,
          'user_email' => $email,
          'user_url' => 'https://livelearn.nl/inloggen/',
          'display_name' => strval($datum->programCurriculum->teacher->name),
          'first_name' => $first_name,
          'last_name' => $last_name,
          'role' => 'teacher'
      );

      $author_id = wp_insert_user(wp_slash($userdata));       
    }

    //Accord the author a company
    update_field('company', $company, 'user_' . $author_id);

    //Fill the company if do not exist -next version

    // Value : course type
    if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords))
      $course_type = "Masterclass";
    else if(in_array('(training)', $keywords) || in_array('training', $keywords))
      $course_type = "Training";
    else if(in_array('live', $keywords) && in_array('seminar', $keywords))
      $course_type = "Webinar";
    else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) )
      $course_type = "E-learning";
    else
      $course_type = "Opleidingen"; 
      
    /*
    Get the url media image & attachment to display on front
    */
    $attachment = array();
    foreach($datum->programDescriptions->media as $media){
      if($media->type == "image")
        $image = $media->url;
      else
        array_push($attachment, $media->url);
    } 

    $attachment_xml = join(',', $attachment);
    /*
    ** END
    */
    
      
    // Value : description    
    if($datum->programDescriptions->programDescriptionHtml)
      $descriptionHtml = $datum->programDescriptions->programDescriptionHtml;
    else
      $descriptionHtml = $datum->programDescriptions->programDescriptionText;

    /*
    * * -- Other fields --
    */

      /*
      Tags *
      */ 

        $title = explode(' ', strval($datum->programDescriptions->programName));
        $description = explode(' ', strval($datum->programDescriptions->programSummaryText));
        $description_html = explode(' ', strval($datum->programDescriptions->programSummaryHtml));    
        $keywords = array_merge($title, $description, $description_html);

        $tags = array();
        $onderwerpen = "";
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

        //Final value : categorie
        $onderwerpen = join(',' , $tags);

      /*
      End *
      */ 

      //Get the url media image to display on front
      foreach($datum->programDescriptions->media as $media)
        if($media->type == "image"){
          $image = $media->url;
          break;
        }
    
      $data_locaties_xml = array();
      $data_locaties = "";

      /*
       Modify the dates
      */ 
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
        
      }

      $data_locaties = join('~', $data_locaties_xml);
      
    /*  
    * * END
    */

    /*
    * * Data to create the course
    */
    $post = array(
      'titel' => strval($datum->programDescriptions->programName),
      'type' => $course_type,
      'videos' => null,
      'short_description' => strval($datum->programDescriptions->programSummaryText),
      'long_description' => $descriptionHtml,
      'duration' => strval($datum->programClassification->programDuration),
      'agenda' => strval($datum->programDescriptions->programDescriptionText),
      'image_xml' => strval($image),
      'attachment_xml' => $attachment_xml,
      'prijs' => intval($datum->programSchedule->genericProgramRun->cost->amount),
      'prijs_vat' => intval($datum->programSchedule->genericProgramRun->cost->amountVAT),
      'level' => strval($datum->programClassification->degree),
      'teacher_id' => $datum->programCurriculum->teacher->id,
      'org' => strval($datum->programClassification->orgUnitId),
      'onderwerpen' => $onderwerpen, 
      'date_multiple' => $data_locaties, 
      'course_id' => null,
      'author_id' => $author_id,
      'company_id' => $company_id,
      'status' => $status
    );

    var_dump($post)
    
    if( !isset($check_image[0]) && !isset($check_title[0]) ){ 

      // $wpdb->insert($table, $post);
      // $post_id = $wpdb->insert_id;

      // echo $wpdb->last_error;

      echo "<span class='textOpleidRight'> Course_ID: " . $datum->programClassification->programId . " - Insertion done successfully <br><br></span>";

    }
    else{
      $course = array(1);

      if(empty($course)){
        delete_user_meta(1, $meta_key, $meta);
        echo "****** Course # " . strval($datum->programDescriptions->programName) . " not detected anymore<br><br>";
      }
      else{
        foreach($meta_data as $value){
            $metax = explode('~',$value);
            if($metax[0] == $meta_value){
              $id = $metax[1];
              break;
          } 
        }
        $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);

        $course = $wpdb->get_results( $sql )[0];
    
        $change  = false;
        $message = 'field on change detected and applied<br><br>';

       /*
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
       */
 
        if($post['author_id'] != $course->author_id){
          $data = [ 'author_id' => $author_id]; // NULL value.
          $where = [ 'id' => $course->id ];
          $updated = $wpdb->update( $table, $data, $where );
          echo $wpdb->last_error;

          echo '****** Author - ' . $message;
          $change = true;
        }

        if($post['company_id'] != $course->company_id){
          $data = [ 'company_id' => $company_id]; // NULL value.
          $where = [ 'id' => $course->id ];
          $updated = $wpdb->update( $table, $data, $where );
          echo $wpdb->last_error;

          echo '****** Company - ' . $message;
          $change = true;
        }
      
        if(!$change)
          echo '*** ~ *** No change found for this course ! *** ~ ***<br><br>';
        else
          echo '<br><br>'; 

      }
    }
  }

  echo "<h2 class='titleGroupText'> End .</h2>";



  

?>

</body>
</html> 
