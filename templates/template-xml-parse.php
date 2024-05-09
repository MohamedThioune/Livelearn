


  <?php
  /** Template Name: xml parse */  
  require_once 'add-author.php';
  require_once 'detect-language.php';
  global $wpdb;
   $table = $wpdb->prefix . 'databank';
$data_insert=0;
   extract($_POST);
//    function RandomString(){
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $randstring = '';
//     for ($i = 0; $i < 10; $i++) {
//         $rand = $characters[rand(0, strlen($characters))];
//         $randstring .= $rand;  
//     }
//     return $randstring;
//   }

//   $table = $wpdb->prefix . 'databank';
  
//   //Get all users
//   $users = get_users(); 

  

//   //Start inserting course 
//   echo "<h1 class='titleGroupText' style='font-weight:bold'>SCRIPT XML PARSING</h1>";
  
//   if (isset($selectedxmlValues)) {
    
//     foreach ($selectedxmlValues as $option) {
//         $website = $option['value']; 
        
//         $author_id = NULL;
//     //Get the URL content
//     $file = get_stylesheet_directory_uri() . "/" . $website ;
//     $xml = simplexml_load_file($file);
//     $data_xml = $xml->program;
//     // var_dump($xml->program);


//     echo "<h3>".$data_xml[0]->programClassification->orgUnitId." running <i class='fas fa-spinner fa-pulse'></i></h3><br><br>";

//     //Retrieve courses
//     // $i = 0;
//     foreach($data_xml as $key => $datum){
//       // $i++;
//       // if($i == 2)
//       //   break;

//       $status = 'extern';
//       $course_type = "Opleidingen";
//       $image = "";

//       /*
//       Get the url media image
//       */
//       foreach($datum->programDescriptions->media as $media)
//         if($media->type == "image"){
//           $image = $media->url;
//           break;
//         }

//       //Redundance check "Image & Title"
//       $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
//       $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum->programDescriptions->programName));

//       if($image != "")
//         $check_image = $wpdb->get_results($sql_image); 
//       else
//         $check_image = 1;


//       $check_title = $wpdb->get_results($sql_title);
      
//       $post = array(
//         'short_description' => $datum->programDescriptions->programSummaryText,
//         'long_description' => null,
//         'agenda' => $datum->programDescriptions->programDescriptionText,
//         'url_image' => $image,
//         'prijs' => $datum->programSchedule->genericProgramRun->cost->amount,
//         'prijsvat' => $datum->programSchedule->genericProgramRun->cost->amountVAT,
//         'degree' => $datum->programClassification->degree,
//         'teacher_id' => $datum->programCurriculum->teacher->id,
//         'org' => $datum->programClassification->orgUnitId,
//         'duration_day' => $datum->programClassification->programDuration,
//       );
    
//       $attachment_xml = array();
//       $data_locaties_xml = array();

//       /*
//       ** -- Main fields --
//       */ 

//       $company = null;
//       $users = get_users();

  

//       //Fill the company if do not exist "next-version"
//         $informations = addAuthor($users, $post['org']);
//          $author_id = $informations['author'];
//         $company_id = $informations['company'];
//          echo "<span class='textOpleidRight'> Course_ID: " . $author_id. " - Insertion done successfully <br><br></span>";
      
//       $title = explode(' ', strval($datum->programDescriptions->programName));
//       $description = explode(' ', strval($datum->programDescriptions->programSummaryText));
//       $description_html = explode(' ', strval($datum->programDescriptions->programSummaryHtml));    
//       $keywords = array_merge($title, $description, $description_html);

//       if(!empty($keywords)){
//         // Value : course type
//         if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords))
//           $course_type = "Masterclass";
//         else if(in_array('(training)', $keywords) || in_array('training', $keywords) || in_array('Training', $keywords))
//           $course_type = "Training";
//         else if(in_array('live', $keywords) && in_array('seminar', $keywords))
//           $course_type = "Webinar";
//         else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) )
//           $course_type = "E-learning";
//         else
//           $course_type = "Opleidingen";
//       }
      
//       // Value : description    
//       if($datum->programDescriptions->programDescriptionHtml)
//         $descriptionHtml = $datum->programDescriptions->programDescriptionHtml;
//       else
//         $descriptionHtml = $datum->programDescriptions->programDescriptionText;

//       /*
//       * * -- Other fields --
//       */

//         /*
//         Tags *
//         */ 
//           $tags = array();
//           $onderwerpen = "";
//           $categories = array(); 
//           $cats = get_categories( array(
//             'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//             'orderby'    => 'name',
//             'exclude' => 'Uncategorized',
//             'parent'     => 0,
//             'hide_empty' => 0, // change to 1 to hide categores not having a single post
//             ) );

//           foreach($cats as $item){
//             $cat_id = strval($item->cat_ID);
//             $item = intval($cat_id);
//             array_push($categories, $item);
//           };

//           $bangerichts = get_categories( array(
//               'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//               'parent'  => $categories[1],
//               'hide_empty' => 0, // change to 1 to hide categores not having a single post
//           ) );

//           $functies = get_categories( array(
//               'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//               'parent'  => $categories[0],
//               'hide_empty' => 0, // change to 1 to hide categores not having a single post
//           ) );

//           $skills = get_categories( array(
//               'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//               'parent'  => $categories[3],
//               'hide_empty' => 0, // change to 1 to hide categores not having a single post
//           ) );

//           $interesses = get_categories( array(
//               'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//               'parent'  => $categories[2],
//               'hide_empty' => 0, // change to 1 to hide categores not having a single post
//           ) );

//           $categorys = array(); 
//           foreach($categories as $categ){
//               //Topics
//               $topics = get_categories(
//                   array(
//                   'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//                   'parent'  => $categ,
//                   'hide_empty' => 0, // change to 1 to hide categores not having a single post
//                   ) 
//               );

//               foreach ($topics as $value) {
//                   $tag = get_categories( 
//                       array(
//                       'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//                       'parent'  => $value->cat_ID,
//                       'hide_empty' => 0,
//                       ) 
//                   );
//                   $categorys = array_merge($categorys, $tag);      
//               }
//           }

//           foreach($datum->programDescriptions->searchword as $searchword){
//             $searchword = strtolower(strval($searchword));
//             foreach($categorys as $category){
//               $cat_slug = strval($category->slug);
//               $cat_name = strval($category->cat_name);             
//               if(strpos($searchword, $cat_slug) !== false)
//                 if(!in_array($category->cat_ID, $tags))
//                     array_push($tags, $category->cat_ID);
//             }
//           }

//           if(empty($tags)){
//             $occurrence = array_count_values(array_map('strtolower', $keywords));
//             arsort($occurrence);
//             foreach($categorys as $value)
//               if($occurrence[strtolower($value->cat_name)] >= 1)
//                 if(!in_array($value->cat_ID, $tags))
//                   array_push($tags, $value->cat_ID);
//           }

//           //Final value : categorie
//           $onderwerpen = join(',' , $tags);
//         /*
//         End *
//         */ 

//         /*
//         Get the url media image & attachment to display on front
//         */
//         $attachment = array();
//         foreach($datum->programDescriptions->media as $media){
//           if($media->type == "image")
//             $image = $media->url;
//           else
//             array_push($attachment, $media->url);
//         } 
//         $attachment_xml = join(',', $attachment);
//         /*
//         ** END
//         */
      
//         $data_locaties_xml = array();
//         $data_locaties = null;
//         /*
//         Modify the dates
//         */ 
//         if(!empty($datum->programSchedule->programRun)){
//           foreach($datum->programSchedule->programRun as $program){
//             $info = array();
//             $infos = "";
//             $row = "";
//             foreach($program->courseDay as $key => $courseDay){
//               $dates = explode('-',strval($courseDay->date));
//               //format date 
//               $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
              
//               $info['start_date'] = $date . " ". strval($courseDay->startTime);
//               $info['end_date'] = $date . " ". strval($courseDay->endTime);
//               $info['location'] = strval($courseDay->location->city);
//               $info['adress'] = strval($courseDay->location->address);
          
//               $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;

//               $infos .= $row ; 

//               $infos .= ';' ; 
                
//             }

//             if(substr($infos, -1) == ';')
//               $infos = rtrim($infos, ';');
            
//             if(!empty($infos))
//               array_push($data_locaties_xml, $infos); 
//             else {
//               continue;
//             } 
//           }

//           $data_locaties = join('~', $data_locaties_xml);
//         }

//         var_dump($data_locaties);
        
//       /*  
//       * * END
//       */

//       /*
//       * * Data to create the course
//       */
//       $post = array(
//         'titel' => strval($datum->programDescriptions->programName),
//         'type' => $course_type,
//         'videos' => null,
//         'short_description' => strval($datum->programDescriptions->programSummaryText),
//         'long_description' => $descriptionHtml,
//         'duration' => strval($datum->programClassification->programDuration),
//         'agenda' => strval($datum->programDescriptions->programDescriptionText),
//         'image_xml' => strval($image),
//         'attachment_xml' => $attachment_xml,
//         'prijs' => intval($datum->programSchedule->genericProgramRun->cost->amount),
//         'prijs_vat' => intval($datum->programSchedule->genericProgramRun->cost->amountVAT),
//         'level' => strval($datum->programClassification->degree),
//         'teacher_id' => $datum->programCurriculum->teacher->id,
//         'org' => strval($datum->programClassification->orgUnitId),
//         'onderwerpen' => $onderwerpen, 
//         'date_multiple' => $data_locaties, 
//         'course_id' => strval($datum->programClassification->programId),
//         'author_id' => $author_id,
//         'company_id' => $company_id,
//         'status' => $status
//       );
//       $where = [ 'titel' => strval($datum->programDescriptions->programName) ];
//       $updated = $wpdb->update( $table, $post, $where );

//       if( !isset($check_image[0]) && !isset($check_title[0]) ){ 

//         $wpdb->insert($table, $post);
//         $post_id = $wpdb->insert_id;
//         // $post_id = 1;

//         echo $wpdb->last_error;

//         echo "<span class='textOpleidRight'> Course_ID: " . $datum->programClassification->programId . " - Insertion done successfully <br><br></span>";

//       }
//       else{
//         $course = array(1);

//         if(empty($course)){
//           echo "****** Course # " . strval($datum->programDescriptions->programName) . " not detected anymore<br><br>";
//         }
//         else{
        
//           $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", $post['titel']);

//           $course = $wpdb->get_results( $sql )[0];
      
//           $change  = false;
//           $message = 'field on change detected and applied<br><br>';
  
//           if($post['type'] != $course->type){
//             $data = [ 'type' => $post['type']]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );

//             echo '****** Type of course - ' . $message;
//             $change = true;
//           }

//           if($post['author_id'] != $course->author_id){
//             $data = [ 'author_id' => $author_id]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );

//             echo '****** Author - ' . $message;
//             $change = true;
//           }

//           if($post['company_id'] != $course->company_id){
//             $data = [ 'company_id' => $company_id]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );

//             echo '****** Company - ' . $message;
//             $change = true;
//           }
        
//           if(!$change)
//             echo '*** ~ *** No change found for this course ! *** ~ ***<br><br>';
//           else
//             echo '<br><br>'; 

//         }
//       }
//     }

//     echo "<h2 class='titleGroupText'> End .</h2>";
//   }
// }
// die();



//   function RandomString(){
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $randstring = '';
//     for ($i = 0; $i < 10; $i++) {
//         $rand = $characters[rand(0, strlen($characters))];
//         $randstring .= $rand;  
//     }
//     return $randstring;
//   }



//   function addOneCourse($data_json){
//      $data_insert=0;
//     global $wpdb;
//      $table = $wpdb->prefix . 'databank';
//     $url = 'https://api.edudex.nl/data/v1/programs/bulk';

// // En-têtes de la requête

// $headers = array(
//     'accept: application/json',
//     'Authorization: Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
//     'Content-Type: application/json'
// );

// // Initialisation de la session cURL
//    $curl = curl_init($url);

//     // Configuration des options cURL
//     curl_setopt_array($curl, array(
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_POST => true,
//         CURLOPT_POSTFIELDS => $data_json,
//         CURLOPT_HTTPHEADER => $headers,
//         CURLOPT_SSL_VERIFYHOST => 0,
//         CURLOPT_SSL_VERIFYPEER => false
//     ));

//     // Exécuter la requête cURL
//     $response = curl_exec($curl);
    

//     // Vérification des erreurs
//     if ($response === false) {
//         $error = curl_error($curl);
//         echo "Erreur cURL : " . $error;
//     }

//     // Fermer la session cURL
//     curl_close($curl);   
//      $data = json_decode($response, true);
//      echo "<h3>".$data['programs'][0]['data']['programClassification']['orgUnitId']." running <i class='fas fa-spinner fa-pulse'></i></h3><br><br>";
     

//      foreach($data['programs'] as $key => $data_xml){
         
            
//         $datum=$data_xml['data'];     
//         // var_dump($datum['programDescriptions']['programName']['nl']);
//          $status = 'extern';
//          $course_type = "Opleidingen";
//          $image = "";
       
//       foreach($datum['programDescriptions']['media'] as $media)
       
      
//         if($media['type'] == "image"){
//           $image = $media['url'];
//           break;
//         }
//         //       //Redundance check "Image & Title"
       
//       $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
//       $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum['programDescriptions']['programName']['nl']));

//       if($image != "")
//         $check_image = $wpdb->get_results($sql_image); 
     


//       $check_title = $wpdb->get_results($sql_title);
//         $post = array(
//         'short_description' => $datum['programDescriptions']['programSummaryText']['nl'],
//         'long_description' => null,
//         'agenda' => $datum['programDescriptions']['programDescriptionText']['nl'],
//         'url_image' => $image,
//         'prijs' => $datum['programSchedule']['genericProgramRun']['cost->amount'],
//         'prijsvat' => $datum['programSchedule']['genericProgramRun']['cost']['amountVAT'],
//         'degree' => $datum['programClassification']['degree'],
//         'teacher_id' => $datum['programCurriculum']['teacher']['id'],
//         'org' => $datum['programClassification']['orgUnitId'],
//         'duration_day' => $datum['programClassification']['programDuration'],
//       );
//        $attachment_xml = array();
//       $data_locaties_xml = array();

//       /*
//       ** -- Main fields --
//       */ 

//       $company = null;
//       $users = get_users();
     
     
      
      
//     // Fill the company if do not exist "next-version"
//        $informations = addAuthor($users, $post['org']);
//          $author_id = $informations['author'];
//         $company_id = $informations['company'] ;
       

       
         
//       $title = explode(' ', strval($datum['programDescriptions']['programName']['nl']));
//       $description = explode(' ', strval($datum['programDescriptions']['programSummaryText']['nl']));
//       $description_html = explode(' ', strval($datum['programDescriptions']['programSummaryHtml']['nl']));    
//      $keywords = array_merge($title, $description, $description_html);
//        if(!empty($keywords)){
       
//         // Value : course type
//         if(in_array('masterclass:', $keywords) || in_array('Masterclass', $keywords) || in_array('masterclass', $keywords))
//           $course_type = "Masterclass";
//         else if(in_array('(training)', $keywords) || in_array('training', $keywords) || in_array('Training', $keywords))
//           $course_type = "Training";
//         else if(in_array('live', $keywords) && in_array('seminar', $keywords))
//           $course_type = "Webinar";
//         else if(in_array('Live', $keywords) || in_array('Online', $keywords) || in_array('E-learning', $keywords) )
//           $course_type = "E-learning";
//         else
//           $course_type = "Opleidingen";
//       }
//        if($datum['programDescriptions']['programDescriptionHtml'])
//         $descriptionHtml = $datum['programDescriptions']['programDescriptionHtml']['nl'];
//       else
//         $descriptionHtml = $datum['programDescriptions']['programDescriptionText']['nl'];
      
//         $tags = array();
//           $onderwerpen = "";
//           $categories = array(); 
//           $cats = get_categories( array(
//             'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//             'orderby'    => 'name',
//             'exclude' => 'Uncategorized',
//             'parent'     => 0,
//             'hide_empty' => 0, // change to 1 to hide categores not having a single post
//             ) );

//           foreach($cats as $item){
//             $cat_id = strval($item->cat_ID);
//             $item = intval($cat_id);
//             array_push($categories, $item);
//           };

//           $bangerichts = get_categories( array(
//               'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//               'parent'  => $categories[1],
//               'hide_empty' => 0, // change to 1 to hide categores not having a single post
//           ) );


//           $categorys = array(); 
//           foreach($categories as $categ){
//               //Topics
//               $topics = get_categories(
//                   array(
//                   'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//                   'parent'  => $categ,
//                   'hide_empty' => 0, // change to 1 to hide categores not having a single post
//                   ) 
//               );

//               foreach ($topics as $value) {
//                   $tag = get_categories( 
//                       array(
//                       'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
//                       'parent'  => $value->cat_ID,
//                       'hide_empty' => 0,
//                       ) 
//                   );
//                   $categorys = array_merge($categorys, $tag);      
//               }
//           }
//           foreach($datum['programDescriptions']['searchword']['nl'] as $searchword){
//             $searchword = strtolower(strval($searchword));
          
          
//             foreach($categorys as $category){
//               $cat_slug = strval($category->slug);
//               $cat_name = strval($category->cat_name);             
//               if(strpos($searchword, $cat_slug) !== false)
//                 if(!in_array($category->cat_ID, $tags))
//                     array_push($tags, $category->cat_ID);
//             }
//           }

//           if(empty($tags)){
//             $occurrence = array_count_values(array_map('strtolower', $keywords));
//             arsort($occurrence);
//             foreach($categorys as $value)
//               if($occurrence[strtolower($value->cat_name)] >= 1)
//                 if(!in_array($value->cat_ID, $tags))
//                   array_push($tags, $value->cat_ID);
//           }

//           //Final value : categorie
//           $onderwerpen = join(',' , $tags);
//         $attachment = array();
//         foreach($datum['programDescriptions']['media'] as $media){
//           if($media['type'] == "image")
//             $image = $media['url'];
//           else
//             array_push($attachment, $media['url']);
//         } 
//         $attachment_xml = join(',', $attachment);
//         $data_locaties_xml = array();
//         $data_locaties = null;
      
//            if(!empty($datum['programSchedule']['programRun'])){
         
//           foreach($datum['programSchedule']['programRun'] as $program){
            
             
//             $info = array();
//             $infos = "";
//             $row = "";
       
//             foreach($program['courseDay'] as $key => $courseDay){

//               $dates = explode('-',strval($courseDay['date']));
             
//               //format date 
//               $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
              
//               $info['start_date'] = $date . " ". strval($courseDay['startTime']);
//               $info['end_date'] = $date . " ". strval($courseDay['endTime']);
//               $info['location'] = strval($courseDay['location']['city']);
//               $info['adress'] = strval($courseDay['location']['address']);
          
//               $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;
               

//               $infos .= $row ; 

//               $infos .= ';' ; 
                
//             }
            

//             if(substr($infos, -1) == ';')
//               $infos = rtrim($infos, ';');
            
//             if(!empty($infos))
//               array_push($data_locaties_xml, $infos); 
//             else {
//               continue;
//             } 
//          }

//           $data_locaties = join('~', $data_locaties_xml);
//         }
//     //     $data = [
//     //     'q' => $datum['programDescriptions']['programName']['nl'],
//     // ];

//     // $dataString = http_build_query($data);

//     // $headers = [
//     //     'content-type: application/x-www-form-urlencoded',
//     //     'Accept-Encoding: application/gzip',
//     //     'X-RapidAPI-Key: YOUR_API_KEY', // Replace 'YOUR_API_KEY' with your actual API key
//     //     'X-RapidAPI-Host: google-translate1.p.rapidapi.com'
//     // ];

//     // $url = 'https://google-translate1.p.rapidapi.com/language/translate/v2/detect';

//     // $ch = curl_init();
//     // curl_setopt($ch, CURLOPT_URL, $url);
//     // curl_setopt($ch, CURLOPT_POST, true);
//     // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//     // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//     // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

//     // $response = curl_exec($ch);
//     // $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

//     // if ($response === false) {
//     //     $language = 'Erreur cURL : ' . curl_error($ch);
//     // } else {
//     //     $data = json_decode($response, true);
//     //     $language = $data["data"]["detections"][0][0]["language"];
//     // }
//        $language='nl';
//         $post = array(
//         'titel' => strval($datum['programDescriptions']['programName']['nl']),
//         'type' => $course_type,
//         'videos' => null,
//         'short_description' => strval($datum['programDescriptions']['programSummaryText']['nl']),
//         'long_description' => $descriptionHtml,
//         'duration' => strval($datum['programClassification']['programDuration']),
//         'agenda' => strval($datum['programDescriptions']['programDescriptionText']['nl']),
//         'image_xml' => strval($image),
//         'attachment_xml' => $attachment_xml,
//         'prijs' => intval($datum['programSchedule']['genericProgramRun']['cost']['amount']),
//         'prijs_vat' => intval($datum['programSchedule']['genericProgramRun']['cost']['amountVAT']),
//         'level' => strval($datum['programClassification']['degree']),
//         'teacher_id' => $datum['programCurriculum']['teacher']['id'],
//         'org' => strval($datum['programClassification']['orgUnitId']),
//         'onderwerpen' => $onderwerpen, 
//         'date_multiple' => $data_locaties, 
//         'course_id' => strval($datum['programClassification']['programId']),
//         'author_id' => $author_id,
//         'company_id' => $company_id,
//         'status' => $status,
//        'language'=>$language
      
//       );
    
      
        
//      $where = [ 'titel' => strval($datum['programDescriptions']['programName']['nl']) ];
//        $updated = $wpdb->update( $table, $post, $where );
//        if( !isset($check_image[0]) && !isset($check_title[0]) ){ 
//            if($wpdb->insert($table, $post)) {
//             $data_insert=1;
//             $post_id = $wpdb->insert_id;
           
//             }

//         }
//          else{
        
//           $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", $post['titel']);
          
//           $course = $wpdb->get_results( $sql )[0];     
         
// //           $message = 'field on change detected and applied<br><br>';
  
//           if($post['type'] != $course->type){
      
//             $data = [ 'type' => $post['type']]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );
//             if($updated)
//              $change = true;

//           //  echo '****** Type of course - ' . $message;
           
//           }

//           if($post['author_id'] != $course->author_id){
//             $data = [ 'author_id' => $author_id]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );
             
//           }

//           if($post['company_id'] != $course->company_id){
//             $data = [ 'company_id' => $company_id]; // NULL value.
//             $where = [ 'id' => $course->id ];
//             $updated = $wpdb->update( $table, $data, $where );
            
//           }
        
          

//         }

        
//       }
//       return $data_insert;
    
    
//   }
  

  //Start inserting course 
  // function addCourseGeneral($catalogId){
     
  //      $data_insert=0;
     
     
  //        $headers = [
  //             'Authorization:Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
  //           ];
                    
  //        $url = "https://api.edudex.nl/data/v1/organizations/livelearn/dynamiccatalogs/". $catalogId . "/programs";

  //       $ch = curl_init();
  //       curl_setopt($ch, CURLOPT_URL, $url);
  //       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  //       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  //       $response = curl_exec($ch); 
      
  //       $programs = json_decode($response, true);
        

  //       if(isset($programs)){

  //         $data = array();
  //         $data['programs']= array();
  //         foreach ($programs  as $prog) {
  //          // addOneCourse($prog);
  //           $element=array(
  //          "orgUnitId" => $prog['supplierId'],
  //           "programId" => $prog['programId'],
  //          "clientId" => $prog['clientId']
  //           );
  //           array_push($data['programs'], $element);
            
          
  //         }
  //         $data_json = json_encode($data);
  //          $data_insert=addOneCourse($data_json);
  //       }
       
  //         return  $data_insert;
        
  //      }                
  


  



  
  if (isset($selectedxmlValues)) {
     
  
    
    $verif=0;
    $data_insert=0;
    foreach ($selectedxmlValues as $option) {
  
        $website = $option['value'];
       
        
        
        
           
        //  $data_insert=addCourseGeneral($website);
         
         $headers = [
              'Authorization:Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
            ];
                    
         $url = "https://api.edudex.nl/data/v1/organizations/livelearn/dynamiccatalogs/". $website . "/programs";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch); 
      
        $programs = json_decode($response, true);
        

        if(isset($programs)){
          

          $data = array();
          $data['programs']= array();
          foreach ($programs  as $prog) {
           // addOneCourse($prog);
            $element=array(
           "orgUnitId" => $prog['supplierId'],
            "programId" => $prog['programId'],
           "clientId" => $prog['clientId']
            );
            array_push($data['programs'], $element);
            
          
          }
          $data_json = json_encode($data);
        

           //$data_insert=addOneCourse($data_json);
              $url = 'https://api.edudex.nl/data/v1/programs/bulk';

// En-têtes de la requête

$headers = array(
    'accept: application/json',
    'Authorization: Bearer secret-token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJFZHUtRGV4IiwiaWF0IjoxNzEzNDMxMjExLCJuYmYiOjE3MTM0MzEyMTEsInN1YiI6ImVkdWRleC1hcGktdXNlciIsInNjb3BlIjoiZGF0YSIsIm5vbmNlIjoidjh2UjNmTkY4NHdWaTZOMDlfQWl5QSIsImV4cCI6MTkwMjc0MzEwMH0.RxttT9h1eA07fYIRFqDes3EJnLiDMVWaxcY0IVFIElI',
    'Content-Type: application/json'
);

// Initialisation de la session cURL
   $curl = curl_init($url);

    // Configuration des options cURL
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data_json,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false
    ));

    // Exécuter la requête cURL
    $response = curl_exec($curl);
    

    // Vérification des erreurs
    if ($response === false) {
        $error = curl_error($curl);
        echo "Erreur cURL : " . $error;
    }

    // Fermer la session cURL
    curl_close($curl);   
     $data = json_decode($response, true);
     echo "<h3>".$data['programs'][0]['data']['programClassification']['orgUnitId']." running <i class='fas fa-spinner fa-pulse'></i></h3><br><br>";
    
     if($data['programs']!=null){
     foreach($data['programs'] as $key => $data_xml){
         
      
          

        $datum=$data_xml['data'];    
        if($datum!=null) {
        // var_dump($datum['programDescriptions']['programName']['nl']);
         $status = 'extern';
         $course_type = "Opleidingen";
         $image = "";
        

        if($datum['programDescriptions']['media']!=null){
           foreach($datum['programDescriptions']['media'] as $media)
       
      
        if($media['type'] == "image"){
          $image = $media['url'];
          break;
        }

        }
       
       
     
        //       //Redundance check "Image & Title"
       
      $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s", strval($image));
      $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", strval($datum['programDescriptions']['programName']['nl']));
    
      if($image != "")
        $check_image = $wpdb->get_results($sql_image); 
     


      $check_title = $wpdb->get_results($sql_title);
        $post = array(
        'short_description' => $datum['programDescriptions']['programSummaryText']['nl'],
        'long_description' => null,
        'agenda' => $datum['programDescriptions']['programDescriptionText']['nl'],
        'url_image' => $image,
        'prijs' => $datum['programSchedule']['genericProgramRun'][0]['cost'][0]['amount'],
        'prijsvat' => $datum['programSchedule']['genericProgramRun'][0]['cost'][0]['amountVAT'],
        'degree' => $datum['programClassification']['degree'],
        'teacher_id' => $datum['programCurriculum']['teacher']['id'],
        'org' => $datum['programClassification']['orgUnitId'],
        'duration_day' => $datum['programClassification']['programDuration'],
      );
       $attachment_xml = array();
      $data_locaties_xml = array();

      /*
      ** -- Main fields --
      */ 

      $company = null;
      $users = get_users();
     
     
      
      
    // Fill the company if do not exist "next-version"
       $informations = addAuthor($users, $post['org']);
         $author_id = $informations['author'];
        $company_id = $informations['company'] ;
       

      
      $title = explode(' ', strval($datum['programDescriptions']['programName']['nl']));
      $description = explode(' ', strval($datum['programDescriptions']['programSummaryText']['nl']));
      $description_html = explode(' ', strval($datum['programDescriptions']['programSummaryHtml']['nl']));    
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
      //  var_dump($datum['programDescriptions']['programDescriptionHtml']['nl']);
      //  var_dump('____________________');
      //   var_dump($datum['programDescriptions']['programDescriptionText']['nl']);
      //  if($datum['programDescriptions']['programDescriptionHtml'])
      //   $descriptionHtml = $datum['programDescriptions']['programDescriptionHtml']['nl'];
      // else
        $descriptionHtml = $datum['programDescriptions']['programDescriptionText']['nl'];
      
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

          if($datum['programDescriptions']['searchword']['nl']!=null){
          foreach($datum['programDescriptions']['searchword']['nl'] as $searchword){
            $searchword = strtolower(strval($searchword));
          
          
            foreach($categorys as $category){
              $cat_slug = strval($category->slug);
              $cat_name = strval($category->cat_name);             
              if(strpos($searchword, $cat_slug) !== false)
                if(!in_array($category->cat_ID, $tags))
                    array_push($tags, $category->cat_ID);
            }
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
        $attachment = array();
        if($datum['programDescriptions']['media']!=null){
        foreach($datum['programDescriptions']['media'] as $media){
          if($media['type'] == "image")
            $image = $media['url'];
          else
            array_push($attachment, $media['url']);
        } 
        }
        
        $attachment_xml = join(',', $attachment);
        $data_locaties_xml = array();
        $data_locaties = null;
      
      if($datum['programSchedule']['programRun']!=null){
          foreach($datum['programSchedule']['programRun'] as $program){
            
             
            $info = array();
            $infos = "";
            $row = "";

             if($program['courseDay']!=null){
       
              foreach($program['courseDay'] as $key => $courseDay){

              $dates = explode('-',strval($courseDay['date']));
             
              //format date 
              $date = $dates[2] . "/" .  $dates[1] . "/" . $dates[0];
              
              $info['start_date'] = $date . " ". strval($courseDay['startTime']);
              $info['end_date'] = $date . " ". strval($courseDay['endTime']);
              $info['location'] = strval($courseDay['location']['city']);
              $info['adress'] = strval($courseDay['location']['address']);
          
              $row = $info['start_date']. '-' . $info['end_date'] . '-' . $info['location'] . '-' . $info['adress'] ;
               

              $infos .= $row ; 

              $infos .= ';' ; 
                
            }
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
          
       $language=$datum['programDescriptions']['programName']['nl']!=null?detectLanguage(strval($datum['programDescriptions']['programName']['nl'])):'';
        
      
        $post = array(
        'titel' => strval($datum['programDescriptions']['programName']['nl']),
        'type' => $course_type,
        'videos' => null,
        'short_description' => strval($datum['programDescriptions']['programSummaryText']['nl']),
        'long_description' => $descriptionHtml,
        'duration' => strval($datum['programClassification']['programDuration']),
        'agenda' => strval($datum['programDescriptions']['programDescriptionText']['nl']),
        'image_xml' => strval($image),
        'attachment_xml' => $attachment_xml,
        'prijs' => intval($program['cost'][0]['amount']),
        'prijs_vat' => intval($program['cost'][0]['amountVAT']),
        'level' => strval($datum['programClassification']['degree']),
        'teacher_id' => $datum['programCurriculum']['teacher']['id'],
        'org' => strval($datum['programClassification']['orgUnitId']),
        'onderwerpen' => $onderwerpen, 
        'date_multiple' => $data_locaties, 
        'course_id' => strval($datum['programClassification']['programId']),
        'author_id' => $author_id,
        'company_id' => $company_id,
        'status' => $status,
       'language'=>$language
      
      );
      
    
      
        
     $where = [ 'titel' => strval($datum['programDescriptions']['programName']['nl']) ];
       $updated = $wpdb->update( $table, $post, $where );
       if( !isset($check_image[0]) && !isset($check_title[0]) ){ 
           if($wpdb->insert($table, $post)) {
            $data_insert=1;
            $post_id = $wpdb->insert_id;
           
            }

        }
         else{
        
          $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE titel = %s", $post['titel']);
          
          $course = $wpdb->get_results( $sql )[0];     
         
//           $message = 'field on change detected and applied<br><br>';
  
          if($post['type'] != $course->type){
      
            $data = [ 'type' => $post['type']]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );
          

          //  echo '****** Type of course - ' . $message;
           
          }

          if($post['author_id'] != $course->author_id){
            $data = [ 'author_id' => $author_id]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );
             
          }

          if($post['company_id'] != $course->company_id){
            $data = [ 'company_id' => $company_id]; // NULL value.
            $where = [ 'id' => $course->id ];
            $updated = $wpdb->update( $table, $data, $where );
            
          }
            
          
        }
          
        }
        else{
  
              break;

        }
         
          
       }
        
      }
      }
      
        }


         if($data_insert==1){
          $verif=1;
         }
    }
    if($verif==1)
     echo "<span class='alert alert-success'> Course - Insertion done successfully</span> <br><br>";
    else 
      echo "<span class='alert alert-danger'>No New Data! ❌</span>";     
   
    
  }
  else{
           echo "<span class='alert alert-danger'>Please select the company key to be able to upload Courses ❌</span>";
  }
  
       
         
      
?>


