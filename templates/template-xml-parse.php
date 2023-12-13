
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

  extract($_POST);

  function RandomString(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $rand = $characters[rand(0, strlen($characters))];
        $randstring .= $rand;  
    }
    return $randstring;
  }

  $table = $wpdb->prefix . 'databank';
  
  //Get all users
  $users = get_users(); 

  

  //Start inserting course 
  echo "<h1 class='titleGroupText' style='font-weight:bold'>SCRIPT XML PARSING</h1>";
  
  if (isset($selectedxmlValues)) {
    
    foreach ($selectedxmlValues as $option) {
        $website = $option['value']; 
        
        $author_id = NULL;
    //Get the URL content
    $file = get_stylesheet_directory_uri() . "/" . $website ;
    $xml = simplexml_load_file($file);
    $data_xml = $xml->program;
    // var_dump($xml->program);


    echo "<h3>".$data_xml[0]->programClassification->orgUnitId." running <i class='fas fa-spinner fa-pulse'></i></h3><br><br>";

    //Retrieve courses
    // $i = 0;
    foreach($data_xml as $key => $datum){
      // $i++;
      // if($i == 2)
      //   break;

      $status = 'extern';
      $course_type = "Opleidingen";
      $image = "";

      /*
      Get the url media image
      */
      foreach($datum->programDescriptions->media as $media)
        if($media->type == "image"){
          $image = $media->url;
          break;
        }

      //Redundance check "Image & Title"
      $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
      $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum->programDescriptions->programName));

      if($image != "")
        $check_image = $wpdb->get_results($sql_image); 
      else
        $check_image = 1;

        $image=null;

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
      ** -- Main fields --
      */ 

      $company = null;
      $users = get_users();

      //Implement author of this course
      foreach($users as $user) {
        $company_user = get_field('company',  'user_' . $user->ID);
        
        if(trim(strtolower($company_user[0]->post_title)) == trim(strtolower(strval($post['org']))) ){
          $author_id = $user->ID;
          $company = $company_user[0];
          $company_id = $company_user[0]->ID;  
        }
      }
  
      if(!$author_id)
      {
        $args = array(
            'post_type' => 'company', 
            'posts_per_page' => -1,
        );

        $companies = get_posts($args);
        foreach($companies as $value) 
          if(trim(strtolower($value->post_title)) == trim(strval($post['org']))  ){
            $company = $value;
            $company_id = $value->ID;
            break;
          }

        $login = RandomString();
        $password = RandomString();
        $random = RandomString();
        $email = "author_" . strval($datum->programClassification->orgUnitId) . $random . "@expertise.nl";
        $first_name = (explode(' ', strval($datum->programCurriculum->teacher->name))[0]) ?? RandomString();;
        $last_name = (explode(' ', strval($datum->programCurriculum->teacher->name))[1]) ?? RandomString();
        $display_name = ($first_name ) ?? RandomString();

        $userdata = array(
            'user_pass' => $password,
            'user_login' => $login,
            'user_email' => $email,
            'user_url' => 'https://livelearn.nl/inloggen/',
            'display_name' => $display_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => 'author'
        );

        $author_id = wp_insert_user(wp_slash($userdata));       
      }

      //Accord the author a company
      if(!is_wp_error($author_id))
        update_field('company', $company, 'user_' . $author_id);

      //Fill the company if do not exist "next-version"
    
      $title = explode(' ', strval($datum->programDescriptions->programName));
      $description = explode(' ', strval($datum->programDescriptions->programSummaryText));
      $description_html = explode(' ', strval($datum->programDescriptions->programSummaryHtml));    
      $keywords = array_merge($title, $description, $description_html);

      if(!empty($keywords)){
        // Value : course type
        if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords))
          $course_type = "Masterclass";
        else if(in_array('(training)', $keywords) || in_array('training', $keywords) || in_array('Training', $keywords))
          $course_type = "Training";
        else if(in_array('live', $keywords) && in_array('seminar', $keywords))
          $course_type = "Webinar";
        else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) )
          $course_type = "E-learning";
        else
          $course_type = "Opleidingen";
      }
      
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
              $cat_name = strval($category->cat_name);             
              if(strpos($searchword, $cat_slug) !== false)
                if(!in_array($category->cat_ID, $tags))
                    array_push($tags, $category->cat_ID);
            }
          }

          if(empty($tags)){
            $occurrence = array_count_values(array_map('strtolower', $keywords));
            arsort($occurrence);
            foreach($categorys as $value)
              if($occurrence[strtolower($value->cat_name)] >= 1)
                if(!in_array($value->cat_ID, $tags))
                  array_push($tags, $value->cat_ID);
          }

          //Final value : categorie
          $onderwerpen = join(',' , $tags);
        /*
        End *
        */ 

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
      
        $data_locaties_xml = array();
        $data_locaties = null;
        /*
        Modify the dates
        */ 
        if(!empty($datum->programSchedule->programRun)){
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
            
            if(!empty($infos))
              array_push($data_locaties_xml, $infos); 
            else {
              continue;
            } 
          }

          $data_locaties = join('~', $data_locaties_xml);
        }

        var_dump($data_locaties);
        
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
        'course_id' => strval($datum->programClassification->programId),
        'author_id' => $author_id,
        'company_id' => $company_id,
        'status' => $status
      );
      $where = [ 'titel' => strval($datum->programDescriptions->programName) ];
      $updated = $wpdb->update( $table, $post, $where );

      if( !isset($check_image[0]) && !isset($check_title[0]) ){ 

        $wpdb->insert($table, $post);
        $post_id = $wpdb->insert_id;
        // $post_id = 1;

        echo $wpdb->last_error;

        echo "<span class='textOpleidRight'> Course_ID: " . $datum->programClassification->programId . " - Insertion done successfully <br><br></span>";

      }
      else{
        $course = array(1);

        if(empty($course)){
          echo "****** Course # " . strval($datum->programDescriptions->programName) . " not detected anymore<br><br>";
        }
        else{
        
          $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", $post['titel']);

          $course = $wpdb->get_results( $sql )[0];
      
          $change  = false;
          $message = 'field on change detected and applied<br><br>';
  
          if($post['type'] != $course->type){
            $data = [ 'type' => $post['type']]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );

            echo '****** Type of course - ' . $message;
            $change = true;
          }

          if($post['author_id'] != $course->author_id){
            $data = [ 'author_id' => $author_id]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );

            echo '****** Author - ' . $message;
            $change = true;
          }

          if($post['company_id'] != $course->company_id){
            $data = [ 'company_id' => $company_id]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );

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
  }
}
?>

</body>
</html> 
