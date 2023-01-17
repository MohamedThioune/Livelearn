
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/style.css">
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css">

  <script src="https://kit.fontawesome.com/2def424b14.js" crossorigin="anonymous"></script>
  <title>Parse MKB</title>
</head>

<?php

  /** Template Name: mkb parse */ 

  // Create a stream
  $opts = [
    "http" => [
        "method" => "GET",
        "header" => "Accept-language: en\r\n" .
        "Cookie: foo=bar\r\n" .
        "Authorization: Bearer WnSdopoAQ4mapyADAU6j\r\n"

    ]
  ];

  // DOCS: https://www.php.net/manual/en/function.stream-context-create.php
  $context = stream_context_create($opts);
  // Open the file using the HTTP headers set above
  // DOCS: https://www.php.net/manual/en/function.file-get-contents.php
  $file = file_get_contents('https://www.mkbservicedesk.nl/api/1/articles?limit=4&skip=16', false, $context);
  $data = json_decode($file)->items;

  $users = get_users();
  //Get the user from MKB 
  $company = null;
  $company_id = null;
  foreach($users as $user) {
    $teacher_id = get_field('teacher_id',  'user_' . $user->ID);
    $company_user = get_field('company',  'user_' . $user->ID);
    
    if($company_user[0]->post_title == "MKB Servicedesk" ){
      $author_id = $user->ID;
      $company = $company_user[0];
      $company_id = $company_user[0]->ID;  
      break;
    }
  }

  //Fetch the tags
  $tags = array();
  $categories = array(); 
  $categorys = array(); 

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

  foreach($categories as $categ){
      //Topics
      $topics = get_categories(
          array(
          'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
          'parent'  => $categ,
          'hide_empty' => 0, // change to 1 to hide categores not having a single post
          ) 
      );

      foreach($topics as $value) {
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

  //Iteration artikel
  foreach($data as $key => $datum){
    $datum = $datum->fields;
    //Insert Artikel
    $args = array(
        'post_type'   => 'post',
        'post_author' => $author_id,
        'post_status' => 'publish',
        'post_title'  => $datum->title
    );

    $id_post = wp_insert_post($args);

    //Custom
    update_field('course_type', 'article', $id_post);
    update_field('article_itself', nl2br($datum->bodyHtml), $id_post);
    
    /*
    Tags *
    */ 
      $title = explode(' ', $datum->title);
      $description = explode(' ', $datum->bodyHtml);
      $searchword = array($datum->categories[0]->name);
      var_dump($datum->categories[0]->name);
    
      $keywords = array_merge($title, $description, $searchword);

      //Matching keywords for tags
      foreach($keywords as $searchword){
        $searchword = strtolower(strval($searchword));
        foreach($categorys as $category){
          $cat_slug = strval($category->slug);
          $cat_name = explode(strval($category->cat_name));             
          if(strpos($searchword, $cat_slug) !== false || in_array($searchword, $cat_name))
            if(!in_array($category->cat_ID, $tags))
                array_push($tags, $category->cat_ID);
        }
      }

      //Sorting tags by convenience
      if(empty($tags)){
        $occurrence = array_count_values(array_map('strtolower', $keywords));
        arsort($occurrence);
        foreach($categorys as $value)
          if($occurrence[strtolower($value->cat_name)] >= 1)
            if(!in_array($value->cat_ID, $tags))
              array_push($tags, $value->cat_ID);
      }
    /*
    End *
    */ 

    /*
    ** UPDATE COMMON FIELDS
    */
    if($datum->imageUrl)
      $image_url =  "http:" . strval($datum->imageUrl);

    update_field('long_description', nl2br($datum->bodyHtml), $id_post);
    update_field('url_image_xml', $image_url, $id_post);
    update_field('categories', $tags, $id_post);
    update_field('canonical_url', "", $id_post);


    echo "<br>";

    /*
    ** END
    */

  }
