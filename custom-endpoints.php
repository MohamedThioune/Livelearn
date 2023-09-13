<?php


$GLOBALS['user_id'] = get_current_user_id();

/** **************** Class **************** */

class Expert
{
 public $id;
 public $name;
 public $profilImg;
 public $company;
 public $role;

 function __construct($expert,$profilImg) {
    $this->id=(int)$expert->ID;
    $this->name=$expert->display_name;
    $this->profilImg =$profilImg;
    $this->company = get_field('company', 'user_' . (int)$expert->ID)[0] ?? null;
    $this->role = get_field('role', 'user_' . (int)$expert->ID) ?? '';
  }

}

class Course
{
  public $id;
  public $date;
  public $title;
  public $pathImage;
  public $shortDescription;
  public $longDescription;
  public $price;
  public $tags;
  public $courseType;
  public $data_locaties_xml;
  public $youtubeVideos;
  public $experts;
  public $visibility;
  public $podcasts;
  public $likes;
  public $author;
  public $articleItself;
  public $connectedProduct;
  public $for_who;
  public $data_locaties;
  public $links;

  function __construct($course) {
     $this->id = $course->ID;
     $this->date = $course->post_date;
     $this->title = $course->post_title;
     $this->pathImage = $course->pathImage;
     $this->shortDescription = $course->shortDescription;
     $this->longDescription = $course->longDescription;
     $this->price = $course->price;
     $this->tags = $course->tags;
     $this->courseType = $course->courseType;
     $this->data_locaties_xml = $course->data_locaties_xml;
     $this->youtubeVideos = $course->youtubeVideos;
     $this->experts = $course->experts;
     $this->visibility = $course->visibility ?? null;
     $this->links = $course->guid;
     $this->podcasts = $course->podcasts;
     $this->connectedProduct = $course->connectedProduct;
     $this->author = $course->author;
     $this->articleItself = get_field('article_itself', $course->ID) ?? '';
     $this->likes = is_array(get_field('favorited', $course->ID)) ? count(get_field('favorited', $course->ID)) : 0 ;
     $this->data_locaties = is_array(get_field('data_locaties', $course->ID)) ? (get_field('data_locaties', $course->ID)) : [] ;
     $this->for_who = get_field('for_who', $course->ID) ? (get_field('for_who', $course->ID)) : "" ;
    }
}

class Tags
{
 public  $id;
 public  $name;

 function __construct($id,$name) {
    $this->id = $id;
    $this->name = $name;
  }
}

class Badge
{
  public $id;
  public $image_badge;
  public $trigger_badge;
  public $state_read_badge;
 

 function __construct($badge)
  {
      $this->id = $badge->ID;
      $this->image_badge = $badge->image_badge;
      $this->trigger_badge = $badge->trigger_badge;
      $this->state_read_badge = $badge->state_read_badge;
      
  }
}

//Push notifications
function sendPushNotificationN($title, $body) {
  $current_user = wp_get_current_user();
  $token = get_field('smartphone_token',  'user_' . $current_user->ID);
  if(!$token)
      return 0;

  $serverKey = "Bearer AAAAurXExgE:APA91bEVVmb3m7BcwiW6drSOJGS6pVASAReDwrsJueA0_0CulTu3i23azmOTP2TcEhUf-5H7yPzC9Wp9YSHhU3BGZbNszpzXOXWIH1M6bbjWyloBrGxmpIxHIQO6O3ep7orcIsIPV05p";
  $data = [
      'to' => $token,
      'notification' => [
          'title' => $title,
          'body' => $body,
      ],
  ];

  $dataString = json_encode($data);

  $headers = [
      'Authorization: ' . $serverKey,
      'Content-Type: application/json',
  ];

  $url = 'https://fcm.googleapis.com/fcm/send';

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
  $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time

  var_dump($httpCode);

  $response = curl_exec($ch);

  curl_close($ch);

  return $response;
}

/** **************** Api Custom Endpoints **************** */

/**
 * Expert Endpoints
 */
function allAuthors()
{
  $authors_post = get_users(
    array(
      'role__in' => ['author'],
      'posts_per_page' => -1,
      )
    );
    if (!$authors_post)
      return ['error' => 'There is no authors in the database',"codeStatus" => 400];
  
    $authors = array();
    if(!empty($authors_post))
      foreach ($authors_post as $key => $experts_post) {
        $experts_img = get_field('profile_img','user_'.$experts_post->ID) ? get_field('profile_img','user_'.$experts_post->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $experts = new Expert($experts_post, $experts_img);
        array_push($authors,$experts);
      }
    return ['authors' => $authors,"codeStatus" => 200];;
}

function get_expert_courses ($data) 
{
  $current_user_id = $GLOBALS['user_id'];
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
  $expert_id = $data['id'] ?? null;
  if (!isset($expert_id))
    return ['error' => "You have to fill the id of the expert" ];
  $expert = get_user_by('ID', $expert_id );
  $courses = get_posts(array(
        'post_type' => array('course', 'post'), 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        // 'meta_key'         => 'course_type',
        // 'meta_value'       => $course_type,
  ));
  $expert_courses = array();
    foreach ($courses as $key => $course) {
      $course->visibility = get_field('visibility',$course->ID) ?? [];
      $author = get_user_by( 'ID', $course -> post_author  );
      $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
      if ($course->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
      $course_experts = get_field('experts',$course->ID) ?? [];
      if (in_array($expert_id,$course_experts) || $expert_id == $course->post_author){
        $author = get_user_by( 'ID', $course -> post_author  );
        $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $course-> author = new Expert ($author , $author_img);
        $course->longDescription = get_field('long_description',$course->ID);
        $course->shortDescription = get_field('short_description',$course->ID);
        $course->courseType = get_field('course_type',$course->ID);
        //Image - article
        $image = get_field('preview', $course->ID)['url'];
        if(!$image){
            $image = get_the_post_thumbnail_url($course->ID);
            if(!$image)
                $image = get_field('url_image_xml', $course->ID);
                    if(!$image)
                        $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
        }
        $course->pathImage = $image;
        $course->price = get_field('price',$course->ID);
        $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
        if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
        $course->podcasts = $course->podcasts ?? [];
        $course->visibility = get_field('visibility',$course->ID);
        $course->connectedProduct = get_field('connected_product',$course->ID);
        $tags = get_field('categories',$course->ID) ?? [];
        $course->tags= array();
        if($tags)
          if (!empty($tags))
            foreach ($tags as $key => $category) 
              if(isset($category['value'])){
                $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                array_push($course->tags,$tag);
              }

              /**
               * Handle Image exception
               */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);
        array_push($expert_courses,new Course($course));
      }
    }
    return $expert_courses;
}

function get_total_followers ($data) 
{
  $expert = $data['id'] != null  ?  get_user_by('ID', $data['id']) : false;
  if (!$expert)
    return ['error' => 'You have to fill the id of the expert'];
  $users = get_users();
  $count = 0;
  foreach ($users as $key => $user) {
    $expert_followed_by_the_user = get_user_meta($user->ID, 'expert');
      if (in_array($expert -> ID,$expert_followed_by_the_user))
        $count++;
  }
  return ['followers_count' => $count]; 
}

/**
 * Topics Endpoints
 */
function related_topics_subtopics(WP_REST_Request $request)
{
  $id_topics = $request['meta_value'] ?? [];
  if ($id_topics != []) 
  {
    $all_subtopics = array();
    foreach ($id_topics as $key => $id_topic) {
      $subtopics = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => (int)$id_topic,
        'hide_empty' => false, // change to 1 to hide categores not having a single post
    )) ?? false;
      if ($subtopics != false)
        $all_subtopics = array_merge($all_subtopics,$subtopics);
    }
    return ['subtopics' => $all_subtopics, "codeStatus" => 200];
  }
  return (['error' => 'You have to fill the values of the metadata !']);

}

function follow_multiple_meta( WP_REST_Request $request)
{
    $user_id = $GLOBALS['user_id'];
    $informations = array();
    $metakey = "topic";
    if($request['meta_value'] == null){
        $informations['error'] = 'Please fill the values of the metadata !';
        return $informations; 
    }

    $subtopics = $request['meta_value'] ?? null;

    if (isset ($subtopics) && !empty ($subtopics))
      foreach ($subtopics as $key => $subtopic) {
        $category = get_categories( array(
          'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
          'orderby'    => 'name',
          'include' => (int)$subtopic,
          'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ) );

        if(!isset($category[0]) ){
            $informations['error'] = 'Please fill correctly the value of the metadata !';
            return $informations;
        }
        $meta_data = get_user_meta($user_id, $metakey);
        if(!in_array($subtopic, $meta_data))
        {
            add_user_meta($user_id, $metakey, $subtopic);
            $informations['success'] = 'Subscribed successfully !';
        }else{
            delete_user_meta($user_id, $metakey, $subtopic);
            $informations['success'] = 'Unsubscribed successfully !';
        }
      }
  return $informations; 
}

/**
 * Current User endpoints
 */
function get_total_followed_experts()
{
  $current_user = $GLOBALS['user_id'];
  $count = 0;
  $experts_followed = get_user_meta($current_user, 'expert') != false ? get_user_meta($current_user, 'expert') : [];
  if (!empty($experts_followed)) {
    $experts = new stdClass;
    $experts -> experts = [];
    foreach ($experts_followed as $key => $expert_followed) {
        $expert_img = get_field('profile_img','user_'.$expert_followed) ? get_field('profile_img','user_'.$expert_followed) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        array_push ($experts -> experts, new Expert(get_user_by( 'ID', $expert_followed ), $expert_img));
    }
    return $experts;
  }
  return [];
}

/**
 * Course Endpoints
 */


 function allCourses ($data)
{
    $current_user_id = $GLOBALS['user_id'];
    $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
    $course_type = ucfirst(strtolower($_GET['course_type']));
    $outcome_courses = array();
    $tags = array();
    $experts = array();
    $args = array(
      'post_type' => array('course', 'post'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'ordevalue'       => $course_type,
      'order' => 'DESC' ,
      'meta_key'         => 'course_type',
      'meta_value' => $course_type);
    $courses = get_posts($args);
    if (!$courses)
      return ["courses" => [],'message' => "There is no courses related to this course type in the database! ","codeStatus" => 400];
      
    if (!isset ($data['page'])) 
      $page = 1;  
    else   
      $page = $data['page'];
    if(!empty($courses))
      $number_of_post = count($courses);
  $results_per_page = 100;
  $start = ($page-1) * $results_per_page ;
  $end = ( ($page) * $results_per_page ) > $number_of_post ? $number_of_post : ($page) * $results_per_page   ;

  $number_of_page = ceil($number_of_post / $results_per_page);

  if($number_of_page < $data['page'])
    return ["courses" => [],'message' => "Page doesn't exist ! ","codeStatus" => 400];  
  
  for($i=$start; $i < $end ;  $i++) 
  {
      $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
      $author = get_user_by( 'ID', $courses[$i] -> post_author  );
      $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
      if ($courses[$i]->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $courses[$i]->experts = array();
          $experts = get_field('experts',$courses[$i]->ID);
          if(!empty($experts))
            foreach ($experts as $key => $expert) {
              $expert = get_user_by( 'ID', $expert );
              $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($courses[$i]->experts, new Expert ($expert,$experts_img));
              }
        
          $courses[$i]-> author = new Expert ($author , $author_img);
          $courses[$i]->longDescription = get_field('long_description',$courses[$i]->ID);
          $courses[$i]->shortDescription = get_field('short_description',$courses[$i]->ID);
          $courses[$i]->courseType = get_field('course_type',$courses[$i]->ID);
          //Image - article
          $image = get_field('preview', $courses[$i]->ID)['url'];
          if(!$image){
              $image = get_the_post_thumbnail_url($courses[$i]->ID);
              if(!$image)
                  $image = get_field('url_image_xml', $courses[$i]->ID);
                      if(!$image)
                          $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($courses[$i]->courseType) . '.jpg';
          }
          $courses[$i]->pathImage = $image;
          $courses[$i]->price = get_field('price',$courses[$i]->ID) ?? 0;
          $courses[$i]->youtubeVideos = get_field('youtube_videos',$courses[$i]->ID) ? get_field('youtube_videos',$courses[$i]->ID) : []  ;
          if (strtolower($courses[$i]->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$courses[$i]->ID) ? get_field('podcasts',$courses[$i]->ID) : [];
             if (!empty($podcasts))
                $courses[$i]->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$courses[$i]->ID) ? get_field('podcasts_index',$courses[$i]->ID) : [];
                if (!empty($podcasts))
                {
                  $courses[$i]->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($courses[$i]->podcasts,($item));
                  }
                }
            }
          }
          $courses[$i]->podcasts = $courses[$i]->podcasts ?? [];
          $courses[$i]->connectedProduct = get_field('connected_product',$courses[$i]->ID);
          $tags = get_field('categories',$courses[$i]->ID) ?? [];
          $courses[$i]->tags= array();
          if($tags)
            if (!empty($tags))
              foreach ($tags as $key => $category) 
                if(isset($category['value'])){
                  $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                  array_push($courses[$i]->tags,$tag);
                }

              /**
               * Handle Image exception
               */
              $handle = curl_init($courses[$i]->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 200 (file ok). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $courses[$i]->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($courses[$i]->courseType) . '.jpg';
                }
              curl_close($handle);
              
          $new_course = new Course($courses[$i]);
          array_push($outcome_courses, $new_course);
    }
   return ['courses' => $outcome_courses, "codeStatus" => 200];
}

function get_course_image($data)
{
  if (!isset($data['course_id']) || empty($data['course_id']))
    return ['error' => 'You have to fill the course id'];
  $course_id = $data['course_id'];
  $course = get_post($course_id) ?? false;
    if (!$course)
      return  ['error' => 'This course does not exist!'];
  //Image - article
              $image = get_field('preview', $course->ID)['url'];
              if(!$image)
              {
                  $image = get_the_post_thumbnail_url($course->ID);
                  if(!$image)
                      $image = get_field('url_image_xml', $course->ID);
                          if(!$image)
                          {
                              $course->courseType = get_field('course_type',$course->ID);
                              $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                          }
              /**
               * Handle Image exception
              */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);
              }
          return ['pathImage' => $image ] ;
            
}

function allArticles ($data)
{        
  $current_user_id = $GLOBALS['user_id'];
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
  $course_type = ucfirst(strtolower($_GET['course_type']));
  $outcome_courses = array();
  $tags = array();
  $experts = array();
  $args = array(
    'post_type' => array('post'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ordevalue'       => $course_type,
    'order' => 'DESC' ,
    'meta_key'         => 'course_type',
    'meta_value' => $course_type);
  $courses = get_posts($args);
  if (!$courses)
    return ["courses" => [],'message' => "There is no courses related to this course type in the database! ","codeStatus" => 400];
    
  if (!isset ($data['page']))
    $page = 1;
  else
    $page = $data['page'];
  if(!empty($courses))
    $number_of_post = count($courses);
  $results_per_page = 20;
  $start = ($page-1) * $results_per_page ;
  $end = ( ($page) * $results_per_page ) > $number_of_post ? $number_of_post : ($page) * $results_per_page   ;

  $number_of_page = ceil($number_of_post / $results_per_page);

  if($number_of_page < $data['page'])
    return ["courses" => [],'message' => "Page doesn't exist ! ","codeStatus" => 400];

  for($i=$start; $i < $end ;  $i++)
  {  
    $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
    $author = get_user_by( 'ID', $courses[$i] -> post_author  );
    $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
    if ($courses[$i]->visibility != [])
      if ($author_company != $current_user_company)
        continue;
    $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $courses[$i]->experts = array();
    $experts = get_field('experts',$courses[$i]->ID);
    if(!empty($experts))
      foreach ($experts as $key => $expert) {
        $expert = get_user_by( 'ID', $expert );
        $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        array_push($courses[$i]->experts, new Expert ($expert,$experts_img));
        }

    $courses[$i]-> author = new Expert ($author , $author_img);
    $courses[$i]->longDescription = get_field('long_description',$courses[$i]->ID);
    $courses[$i]->shortDescription = get_field('short_description',$courses[$i]->ID);
    $courses[$i]->courseType = get_field('course_type',$courses[$i]->ID);
    //Image - article
    $image = get_field('preview', $courses[$i]->ID)['url'];
    if(!$image){
        $image = get_the_post_thumbnail_url($courses[$i]->ID);
        if(!$image)
            $image = get_field('url_image_xml', $courses[$i]->ID);
                if(!$image)
                    $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($courses[$i]->courseType) . '.jpg';
    }
    


    
    $courses[$i]->pathImage = $image;
    $courses[$i]->price = get_field('price',$courses[$i]->ID) ?? 0;
    $courses[$i]->youtubeVideos = get_field('youtube_videos',$courses[$i]->ID) ? get_field('youtube_videos',$courses[$i]->ID) : []  ;
    $courses[$i]->podcasts = get_field('podcasts',$courses[$i]->ID) ? get_field('podcasts',$courses[$i]->ID) : [];
    $courses[$i]->connectedProduct = get_field('connected_product',$courses[$i]->ID);
    $tags = get_field('categories',$courses[$i]->ID) ?? [];
    $courses[$i]->tags= array();
    if($tags)
      if (!empty($tags))
        foreach ($tags as $key => $category)
          if(isset($category['value'])){
            $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
            array_push($courses[$i]->tags,$tag);
          }
    /**
     * Handle Image exception
     */
    $handle = curl_init($courses[$i]->pathImage);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the HTML or whatever is linked in $url. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($httpCode != 200) {
        /* Handle 404 here. */
        $courses[$i]->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($courses[$i]->courseType) . '.jpg';
      }
    curl_close($handle);

    $new_course = new Course($courses[$i]);
    array_push($outcome_courses, $new_course);
  }

  return ['courses' => $outcome_courses, "codeStatus" => 200];
}

function get_saved_course()
{
  $current_user = $GLOBALS['user_id'];
  $course_saved = get_user_meta($current_user, 'course') ?? false ;
  
  if (!empty($course_saved) || $course_saved)
  {
    $courses = get_posts(
        array(
            'post_type' => array('course', 'post'), 
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'include' => $course_saved
        ));
    $outcome_courses = array();
        foreach ($courses as $key => $course) {
          $course->experts = array();
          $experts = get_field('experts',$course->ID);
      if (!empty($experts))
        foreach ($experts as $key => $expert) 
        {
          $expert = get_user_by('ID', $expert);
          if (!empty ($expert) || $expert) {
            $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            array_push($course->experts, new Expert($expert, $experts_img));
          }
        }
          $author = get_user_by( 'ID', $course -> post_author  );
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
            //Image - article
          $image = get_field('preview', $course->ID)['url'];
          if(!$image)
          {
              $image = get_the_post_thumbnail_url($course->ID);
              if(!$image)
                  $image = get_field('url_image_xml', $course->ID);
                      if(!$image)
                          $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
          }
          $course->pathImage = $image;
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
          $course->podcasts = $course->podcasts ?? [];
          $course->visibility = get_field('visibility',$course->ID);
          $course->connectedProduct = get_field('connected_product',$course->ID);
          $tags = get_field('categories',$course->ID) ?? [];
          $course->tags= array();
          if($tags)
            if (!empty($tags))
              foreach ($tags as $key => $category) 
                if(isset($category['value'])){
                  $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                  array_push($course->tags,$tag);
                }
          
              /**
               * Handle Image exception
               */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);
          
          $new_course = new Course($course);
          array_push($outcome_courses, $new_course);
        }
        return ['saved_courses' => $outcome_courses,"codeStatus" => 200];
  }
  return [];
}

function save_course($data)
{
  $current_user = $GLOBALS['user_id'];
  $course_id = $data['id']!= null && !empty (get_post($data['id'])) ? $data['id'] : false ;
  if (!empty($course_id))
  {
    $meta_key = 'course'; 
    $course_saved = get_user_meta($current_user, $meta_key) ?? false;
    if (!in_array($course_id, $course_saved)) {

      add_user_meta($current_user, $meta_key, $course_id);
      $message = 'Course saved with success';
    }
    else
    {
      delete_user_meta($current_user, $meta_key, $course_id);
      $message = 'Course removed with success';
    }
    return ['success' => $message];
  }
  return ['error' => 'This id course doesn\'t exist' ];
}

function get_course_by_id($data)
{
  if (isset ($data['id']) && !empty ($data['id']))
  {
    $course_id = $data['id'];
    $course = get_post($course_id) ?? false;
    if ($course)
    {
          $course->experts = array();
          $experts = get_field('experts',$course->ID);
          if(!empty($experts))
            foreach ($experts as $key => $expert) 
            {
              $expert = get_user_by( 'ID', $expert );
              $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($course->experts, new Expert ($expert,$experts_img));
            }
          $author = get_user_by( 'ID', $course -> post_author);
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
            //Image - article
          $image = get_field('preview', $course->ID)['url'];
          if(!$image){
              $image = get_the_post_thumbnail_url($course->ID);
              if(!$image)
                  $image = get_field('url_image_xml', $course->ID);
                      if(!$image)
                          $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
          }
          $course->pathImage = $image;
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
          $course->podcasts = $course->podcasts ?? [];
          $course->visibility = get_field('visibility',$course->ID);
          $course->connectedProduct = get_field('connected_product',$course->ID);
          $tags = get_field('categories',$course->ID) ?? [];
          $course->tags= array();
          if($tags)
            if (!empty($tags))
              foreach ($tags as $key => $category) 
                if(isset($category['value'])){
                  $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                  array_push($course->tags,$tag);
                }
          
              /**
               * Handle Image exception
               */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);

          return new Course($course);
    }
    return ['error' => 'This course doesn\'t exist in this database'];
     
  }
  return ['error' => 'You have to fill the id of the course'];
}

function get_liked_courses()
{
  $current_user = $GLOBALS['user_id'];
  $courses = get_posts(
    array(
      'post_type' => array('course', 'post'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
    )
  );
  $liked_courses = array();
  foreach ($courses as $key => $course) {
    $course_fans = get_field('favorited', $course->ID) ?? [];
    if (!empty($course_fans))
      if (in_array($current_user, $course_fans)) {
        $course->experts = array();
          $experts = get_field('experts',$course->ID);
          if(!empty($experts))
            foreach ($experts as $key => $expert) 
            {
              $expert = get_user_by( 'ID', $expert );
              $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($course->experts, new Expert ($expert,$experts_img));
            }
          $author = get_user_by( 'ID', $course -> post_author  );
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
            //Image - article
          $image = get_field('preview', $course->ID)['url'];
          if(!$image){
              $image = get_the_post_thumbnail_url($course->ID);
              if(!$image)
                  $image = get_field('url_image_xml', $course->ID);
                      if(!$image)
                          $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
          }
          $course->pathImage = $image;
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
          $course->podcasts = $course->podcasts ?? [];
          $course->visibility = get_field('visibility',$course->ID);
          $course->connectedProduct = get_field('connected_product',$course->ID);
          $tags = get_field('categories',$course->ID) ?? [];
          $course->tags= array();
          if($tags)
            if (!empty($tags))
              foreach ($tags as $key => $category) 
                if(isset($category['value'])){
                  $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                  array_push($course->tags,$tag);
                }

          
              /**
               * Handle Image exception
               */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);

        array_push($liked_courses, new Course($course));
      }
  }
  return $liked_courses;
}

function like_course ($data) {
  $current_user = $GLOBALS['user_id'];
  $course = $data['id'] != null  ?  get_post($data['id']) : false;
  if (!$course)
    return ['error' => 'You have to fill the id of the course'];
  $favorite = get_field('favorited', $course->ID) ?? [];
  //return $favorite;
  if (!in_array($current_user,$favorite))
  {
    array_push($favorite, $current_user);
    update_field('favorited',$favorite,$course->ID);
    return ['success' => 'Course liked with success'];
  }
  foreach ($favorite as $key => $user_id) {
    if ($user_id == $current_user){
      unset($favorite[$key]);
      break;
    }
  }
  update_field('favorited', $favorite , $course->ID);
  return ['success' => 'Course disliked with success']; 
}

function get_courses_of_subtopics($data)
{
  $current_user_id = $GLOBALS['user_id'];
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
  $subtopic = get_the_category_by_ID($data['id']) ?? false;
  if (!$subtopic)
    return ['error' => 'This subtopic doesn\'t exist'];
  $global_courses = get_posts(
    array(
      'post_type' => array('course', 'post'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
    )
  );
  $courses_related_subtopic = array();
  foreach ($global_courses as $course) 
  {
    $course->visibility = get_field('visibility',$course->ID) ?? [];
    $author = get_user_by( 'ID', $course -> post_author  );
    $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
    if ($course->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
    $category_default = get_field('categories', $course->ID);
    $category_xml = get_field('category_xml', $course->ID);
    if (!empty($category_default))
      foreach ($category_default as $item) 
      {
        if ($item)
          if ($item['value'] == $data['id']) 
          {
            $course->experts = array();
          $experts = get_field('experts',$course->ID);
          if(!empty($experts))
            foreach ($experts as $key => $expert) 
            {
              $expert = get_user_by( 'ID', $expert );
              $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($course->experts, new Expert ($expert,$experts_img));
            }
          $author = get_user_by( 'ID', $course -> post_author  );
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
            //Image - article
          $image = get_field('preview', $course->ID)['url'];
          if(!$image)
          {
              $image = get_the_post_thumbnail_url($course->ID);
              if(!$image)
                  $image = get_field('url_image_xml', $course->ID);
                      if(!$image)
                          $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
          }
          $course->pathImage = $image;
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
          $course->podcasts = $course->podcasts ?? [];
          $course->visibility = get_field('visibility',$course->ID);
          $course->connectedProduct = get_field('connected_product',$course->ID);
          $tags = get_field('categories',$course->ID) ?? [];
          $course->tags= array();
          if($tags)
            if (!empty($tags))
              foreach ($tags as $key => $category) 
                if(isset($category['value'])){
                  $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                  array_push($course->tags,$tag);
                }
            array_push($courses_related_subtopic, new Course ($course));
            break;
          }
      } else if (!empty($category_xml))
      foreach ($category_xml as $item)
        if ($item)
          if ($item['value'] == $data['id']) {
            $course->experts = array();
          $experts = get_field('experts',$course->ID);
          if(!empty($experts))
            foreach ($experts as $key => $expert) 
            {
              $expert = get_user_by( 'ID', $expert );
              $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($course->experts, new Expert ($expert,$experts_img));
            }
          $author = get_user_by( 'ID', $course -> post_author  );
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
            //Image - article
          $image = get_field('preview', $course->ID)['url'];
          if(!$image){
              $image = get_the_post_thumbnail_url($course->ID);
              if(!$image)
                  $image = get_field('url_image_xml', $course->ID);
                      if(!$image)
                          $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
          }
          $course->pathImage = $image;
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
          $course->podcasts = $course->podcasts ?? [];
          $course->visibility = get_field('visibility',$course->ID);
          $course->connectedProduct = get_field('connected_product',$course->ID);
          $tags = get_field('categories',$course->ID) ?? [];
          $course->tags= array();
          if($tags)
            if (!empty($tags))
              foreach ($tags as $key => $category) 
                if(isset($category['value'])){
                  $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                  array_push($course->tags,$tag);
                }
            
              /**
               * Handle Image exception
               */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);

            array_push($courses_related_subtopic, new Course ($course));
            break;
          }
  }
  return $courses_related_subtopic;
}


/**
 * Reservation Endpoints
 */

  function reserve_course(WP_REST_Request $request)
  {
    /** 
     * {
     *    "user_id":3,
     *    "date_reservation":"2023-07-31",
     *    "product_id" $course_id,
     * }
    */

    if (!isset($request['user_id']) || empty($request['user_id']))
      return ['error' => "You have to fill in the id of current user !"];
    $user_id = $request['user_id'];
    
    if (!isset($request['date_reservation']) || empty($request['date_reservation']))
      return ['error' => "You have to fill in the reservation date !"];
    $date_reservation = $request['date_reservation'];
    
    if (!isset($request['product_id']) || empty($request['product_id']))
      return ['error' => "You have to fill in the id of the product !"];
    $product_id = $request['product_id'];

    global $wpdb;
    $table_reserveren = $wpdb->prefix . 'reserveren';
    $data = [
        'product_id'=> $product_id,
        'user_id'=> $user_id,
        'date_reserveren'=> $date_reservation
    ];
    $wpdb->insert($table_reserveren, $data);
    return $wpdb->insert_id;
  }
  
  /**
   * Assessment Endpoints
   */

  function getAssessments()
{
    $user_id = $GLOBALS['user_id'];
    $assessments_validated = get_user_meta( $user_id, 'assessment_validated') ?? false;
    $args = array(
      'post_type' => 'assessment',
      'post_status' => 'publish',
      'posts_per_page' => -1
    );
  $assessments = get_posts($args) ?? [];
     if (empty ($assessments))
        return [];
     foreach ($assessments as $key => $assessment) 
    {
        $assessment -> is_connected_user_succed = (in_array($assessment, $assessments_validated)) ? true : false ;
         
      $questions= get_field('question',$assessment->ID);  
      if (!empty($questions))
      {
        $assessment -> time = 0;
        foreach ($questions as $key => $question) {
          $assessment -> time += (int) $question['timer'];
        }
      }
      
      $assessment -> questions = $questions;
      $assessment -> description = get_field('description_assessment',$assessment->ID);
      $assessment -> author = get_user_by( 'ID', $assessment -> post_author  );
      $author_profilImg = get_field('profile_img','user_'.$assessment -> post_author) ? get_field('profile_img','user_'.$assessment -> post_author) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      $assessment -> author = new Expert($assessment -> author,$author_profilImg);
      $image = get_field('image_assessement', $assessment->ID)['url'];
      if(!$image)
      {
          $image = get_the_post_thumbnail_url($assessment->ID) ?? false;
          if(!$image)
              $image = get_field('url_image_xml', $assessment->ID);
                  if(!$image)
                      $image = get_stylesheet_directory_uri().'/img/assessment-1.png'; 
      }
      $assessment ->image = $image;
      $assessment ->level = get_field('difficulty_assessment', $assessment->ID);
  }
  return $assessments;
}

function answerAssessment (WP_REST_Request $request)
  {
    if (isset ($request) && !empty($request))
    {
      $user_id = $request['user_id'];
      $questions = get_field('question',$request['assessment_id']);
      $assessment = get_post ($request['assessment_id']);
      $user_responses = $request['user_responses'];
      $score = 0;
      $responses=array();
      $args=array(
        'post_type' => 'response_assessment',
        'post_author' => $user_id,
        'post_status' => 'publish',
        'post_title' => $assessment->post_title .' '.get_user_by('ID',$assessment->post_author)->name,
    );
    $id_new_response=wp_insert_post($args);
      if (isset ($questions) && !empty($questions))
      {
        foreach ($questions as $key => $question) {
          
         if($question["correct_response"] == $user_responses[$key])
          {
            $score++; 
            array_push($responses, ["status"=>1,"sent_responses"=>$user_responses[$key],"response_id"=>$key]);
          }
          else
            array_push($responses, ["status"=>0,"sent_responses"=>$user_responses[$key],"response_id"=>$key]); 
        
            update_field('responses_user', $responses, $id_new_response);
            update_field('assessment_id',$request['assessment_id'],$id_new_response);
            update_field('score',$score,$id_new_response);
            $percentage = ($score / count ($questions) ) * 100;
            if ($percentage >= 60)
              add_user_meta( $user_id, 'assessment_validated',$assessment);

        }
        return ['score' => $score];
      }
    }
  }

function getAssessmentValidateScore($data)
{
    $user_id = $GLOBALS['user_id'];
    $idAssessment =  $data['id'] ?? 0;
    $assessment = get_post($idAssessment) ?? false;
    if (!$assessment)
      return ["error" => "This assessment does not exist !"];
    
    $args = array(
      'post_type' => array('response_assessment'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
      'post_author' => '$user_id' 
      );

    $responses = get_posts($args) ?? [];
    if (!empty($responses))
      foreach ($responses as $key => $response) {
        $assessment_related = get_field('assessment_id',$response ->ID) ?? 0;
        if ($assessment_related == $idAssessment)
        {
          $response -> score = get_field('score',$response ->ID);
          $assessment_questions = get_field('question',$assessment->ID) ?? [];
          $count_questions = count($assessment_questions);
          $response -> count_question = $count_questions;
          return $response;
        }
      }
}

/**
 * Communities Endpoints
 */

 function community_share($data)
 {
   $bool = false;
   $communities = array();
   $community_courses = array();
   $company = array();
   $infos = array();
   $infos['success'] = false;
   $infos['message'] = "Please fill the company !";
       
   if(!$data['community'])
    return $infos;

   $args = array(
       'post_type' => 'company',
       'post_status' => 'publish',
       'posts_per_page' => -1
     );
   $companies = get_posts($args);

   foreach($companies as $value)
     if( $value->post_name == $data['community'] )
       $company = $value;
   
   if(!isset($company)){
     $infos['message'] = "No company found !";
     return $infos;
   }

   $args = array(
       'post_type' => 'community',
       'post_status' => 'any',
       'posts_per_page' => -1);
   $mus = get_posts($args);

   foreach($mus as $community){
     
     $company_community = get_field('company_author', $community->ID);
     foreach($company_community as $value)
       if( $value->post_name == $company->post_name )
       {
         $bool = true;
         break;
       }
     
     if(!$bool)
         continue;

     $mu = array();
     $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
     $community->image = get_field('image_community', $community->ID) ?: $company_image;
     
     // courses comin through custom field 
     $courses = get_field('course_community', $community->ID);
     foreach($courses as $course){
       $course_type = get_field('course_type', $course->ID);

       //Legend image
       $thumbnail = get_field('preview', $course->ID)['url'];
       if(!$thumbnail){
           $thumbnail = get_the_post_thumbnail_url($course->ID);
           if(!$thumbnail)
               $thumbnail = get_field('url_image_xml', $course->ID);
           if(!$thumbnail)
               $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
       }

       //Short description
       $short_description = get_field('short_description', $course->ID);

       $demand_course = (object)[
         'title' => $course->post_title,
         'picture_course' => $thumbnail,
         'short_description' => $short_description,
         'guid' => $course->guid,
         'created_at' => $course->post_date
       ];

       array_push($community_courses, $demand_course);
     }
     $community->courses = $community_courses;

     $demand_community = (object)[
       'title' => $community->post_title,
       'description' => $community->post_excerpt,
       'picture' => $community->image,
       'created_at' => $community->post_date,
       'courses' => $community->courses
       
     ];
     array_push($communities, $demand_community);

   }

   if(!$bool){
     $infos['message'] = "No community found !";
     return $infos;
   } 

   $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';

   $demand_company = (object)[
     'title' => $company->post_title,
     'picture' => $company_image,
     'created_at' => $company->post_date
   ];

   $infos['success'] = true;
   $infos['communities'] = $communities;
   $infos['company '] = $demand_company;
   $infos['message'] = "List of communities according to companies";

   return [$infos];
 }

function getCommunities()
{
  $user_id = $GLOBALS['user_id'];
  //All communities
  $args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'posts_per_page' => -1 
  );
  $communities = get_posts($args);
  $retrieved_communities = array();
  foreach ($communities as $key => $community) 
  {
    //Check if the community is private or public
    $community->visibility_community = get_field('visibility_company',$community->ID) ?? false;
    $community->password_community = get_field('password_community',$community->ID);
    $author_community = get_field('company_author',$community->ID) ?? false;
    $author_company = get_field('company', 'user_' . (int) $user_id)[0] ?? false;
    if ($community->visibility_community !=false)
    {
      
      if ($author_community ->ID != $author_company->ID)
        continue;
    }
    
    if ($community->password_community != null && $community->password_community != '')
      continue;
    
    $community-> author_company = array();
    if(is_object($author_community))
      array_push($community->author_company,$author_community);

    $community->image_community = get_field('image_community',$community->ID) ? get_field('image_community',$community->ID) : null;
    $community->range = get_field('range',$community->ID) ? get_field('range',$community->ID) : null;
    $follower_community = get_field('follower_community',$community->ID) ? get_field('follower_community',$community->ID) : [];
    $community->followers = array();
    $community->courses = array();
    $community->questions = array();
    $community->is_connected_user_member = false;
    if (!empty($follower_community))
      foreach ($follower_community as $key => $follower) {
        if ($follower -> data -> ID == $user_id)
          $community->is_connected_user_member = true;
        $follower -> data ->profile_image =  get_field('profile_img','user_'.(int)$follower -> data ->ID) != false ? get_field('profile_img','user_'.(int)$follower -> data ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $follower -> data ->role = get_field('role', 'user_' . (int)$follower -> data ->ID) ? get_field('role', 'user_' . (int)$follower -> data ->ID) : '';
        array_push($community->followers, $follower -> data);
      }

    $community -> questions = get_field('question_community',$community->ID) ? get_field('question_community',$community->ID) : [];
    if ($community -> questions != [])
    {
      
      foreach ($community -> questions as $key => $question) {
        if (isset($question['user_question']->data) && !empty($question['user_question']->data)) 
          $question['user_question']->data->profile_image = get_field('profile_img','user_'.(int)$question['user_question']->data->ID) != false ? get_field('profile_img','user_'.(int)$question['user_question']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        if (isset($question['reply_question']) && !empty($question['reply_question'])) 
            foreach ($question['reply_question'] as $key => $reply) {
              $reply['user_reply']->data->profile_image = get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) != false ? get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';  
            } 
            
          $question['user_question']->data->profile_image = get_field('profile_img','user_'.(int)$question['user_question']->data->ID) != false ? get_field('profile_img','user_'.(int)$question['user_question']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png'; ;
          if (!$question['reply_question'])
             $community -> questions[$key]['reply_question'] = [];
      }
    }
    $courses_community = get_field('course_community',$community->ID) ?? [];
    if (!empty($courses_community))

      foreach ($courses_community as $key => $course)
      {
            $author = get_user_by( 'ID', $course -> post_author);
            $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            $course-> author = new Expert ($author , $author_img);
            $course->longDescription = get_field('long_description',$course->ID);
            $course->shortDescription = get_field('short_description',$course->ID);
            $course->courseType = get_field('course_type',$course->ID);
                //Image - article
            $image = get_field('preview', $course->ID)['url'];
            if(!$image){
                $image = get_the_post_thumbnail_url($course->ID);
                if(!$image)
                    $image = get_field('url_image_xml', $course->ID);
                        if(!$image)
                            $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
            }
            $course->pathImage = $image;
            $course->price = get_field('price',$course->ID) ?? 0;
            $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
            if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item= array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
            $course->podcasts = $course->podcasts ?? [];
            $course->visibility = get_field('visibility',$course->ID);
            $course->connectedProduct = get_field('connected_product',$course->ID);
            $tags = get_field('categories',$course->ID) ? get_field('categories',$course->ID) : [];
            $course->tags= array();
            if($tags)
              if (!empty($tags))
                foreach ($tags as $key => $category) 
                  if(isset($category['value'])){
                    $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                    array_push($course->tags,$tag);
                  }

              /**
               * Handle Image exception
               */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);
            array_push($community->courses,new Course($course));
          
      }
      array_push($retrieved_communities,$community);
  }
  
  return $retrieved_communities;

}

function getCommunityById($data)
{
  $user_id = $GLOBALS['user_id'];
  //All communities
  $id_community = $data['id'] ?? null;
  if ($id_community == null)
    return ["error" => "You have to fill the id of the community !"];
  $community = get_post($id_community) ?? null;
  if ($community == null)
    return ["error" => "This community does not exist !"];
    $community = get_post($id_community) ?? null;

    $community-> author_company = array();
    //Check if the community is private or public
    $community->visibility_community = get_field('visibility_company',$community->ID) ?? false;
    $community->password_community = get_field('password_community',$community->ID);
    $author_community = get_field('company_author',$community->ID) ?? false;
    $author_company = get_field('company', 'user_' . (int) $user_id)[0] ?? false;
    if ($community->visibility_community !=false)
    {
      if ($author_community ->ID != $author_company->ID)
      return ['message'=> 'You don\'t have access to this community'];
    }
    
    if ($community->password_community != null && $community->password_community != '')
    return ['message'=> 'You don\'t have access to this community because it\'s private'];
    
    $community-> author_company = array();
    if(is_object($author_community))
      array_push($community->author_company,$author_community);

    
    $community->image_community = get_field('image_community',$community->ID) ? get_field('image_community',$community->ID) : null;
    $community->range = get_field('range',$community->ID) ? get_field('range',$community->ID) : null;
    $follower_community = get_field('follower_community',$community->ID) ? get_field('follower_community',$community->ID) : [];
    $community->followers = array();
    $community->courses = array();
    $community->questions = array();
    $community->is_connected_user_member = false;
    if (!empty($follower_community))
      foreach ($follower_community as $key => $follower) {
        if ($follower -> data -> ID == $user_id)
          $community->is_connected_user_member = true;
        $follower -> data ->profile_image =  get_field('profile_img','user_'.(int)$follower -> data ->ID) != false ? get_field('profile_img','user_'.(int)$follower -> data ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $follower -> data ->role = get_field('role', 'user_' . (int)$follower -> data ->ID) ? get_field('role', 'user_' . (int)$follower -> data ->ID) : '';
        array_push($community->followers, $follower -> data);
      }

    $community -> questions = get_field('question_community',$community->ID) ? get_field('question_community',$community->ID) : [];
    if ($community -> questions != [])
    {
      
      foreach ($community -> questions as $key => $question) {
        if (isset($question['user_question']->data) && !empty($question['user_question']->data)) 
          $question['user_question']->data->profile_image = get_field('profile_img','user_'.(int)$question['user_question']->data->ID) != false ? get_field('profile_img','user_'.(int)$question['user_question']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        if (isset($question['reply_question']) && !empty($question['reply_question'])) 
            foreach ($question['reply_question'] as $key => $reply) {
              $reply['user_reply']->data->profile_image = get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) != false ? get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';  
            } 
            
          $question['user_question']->data->profile_image = get_field('profile_img','user_'.(int)$question['user_question']->data->ID) != false ? get_field('profile_img','user_'.(int)$question['user_question']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png'; ;
          if (!$question['reply_question'])
             $community -> questions[$key]['reply_question'] = [];
      }
    }
    $courses_community = get_field('course_community',$community->ID) ?? [];
    if (!empty($courses_community))

      foreach ($courses_community as $key => $course)
      {
            $author = get_user_by( 'ID', $course -> post_author);
            $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            $course-> author = new Expert ($author , $author_img);
            $course->longDescription = get_field('long_description',$course->ID);
            $course->shortDescription = get_field('short_description',$course->ID);
            $course->courseType = get_field('course_type',$course->ID);
                //Image - article
            $image = get_field('preview', $course->ID)['url'];
            if(!$image){
                $image = get_the_post_thumbnail_url($course->ID);
                if(!$image)
                    $image = get_field('url_image_xml', $course->ID);
                        if(!$image)
                            $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
            }
            $course->pathImage = $image;
            $course->price = get_field('price',$course->ID) ?? 0;
            $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
            if (strtolower($course->courseType) == 'podcast')
          {
             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
             if (!empty($podcasts))
                $course->podcasts = $podcasts;
              else {
                $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
                if (!empty($podcasts))
                {
                  $course->podcasts = array();
                  foreach ($podcasts as $key => $podcast) 
                  { 
                    $item = array(
                      "course_podcast_title"=>$podcast['podcast_title'], 
                      "course_podcast_intro"=>$podcast['podcast_description'],
                      "course_podcast_url" => $podcast['podcast_url'],
                      "course_podcast_image" => $podcast['podcast_image'],
                    );
                    array_push ($course->podcasts,($item));
                  }
                }
            }
          }
            $course->podcasts = $course->podcasts ?? [];
            $course->visibility = get_field('visibility',$course->ID);
            $course->connectedProduct = get_field('connected_product',$course->ID);
            $tags = get_field('categories',$course->ID) ? get_field('categories',$course->ID) : [];
            $course->tags= array();
            if($tags)
              if (!empty($tags))
                foreach ($tags as $key => $category) 
                  if(isset($category['value'])){
                    $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
                    array_push($course->tags,$tag);
                  }

              /**
               * Handle Image exception
               */
              $handle = curl_init($course->pathImage);
              curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              /* Get the HTML or whatever is linked in $url. */
              $response = curl_exec($handle);

              /* Check for 404 (file not found). */
              $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              if($httpCode != 200) {
                  /* Handle 404 here. */
                  $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
                }
              curl_close($handle);

            array_push($community->courses,new Course($course));
          
      }

  return $community;

}

function joinCommunity( WP_REST_Request $request )
{
  $user_id = $request['user_id'] ?? 0;
  $community_id = $request['community_id'] ?? 0;

  if ($user_id == 0)
    return ["error" => "You have to fill the correct user id !"];

  if ($community_id == 0)
    return ["error" => "You have to fill the correct community id !"];

  $community = get_post($community_id);
  $user = get_user_by('ID',$user_id); 
  if (!$user_id)
    return ["error" => "This user does not exist !"];

  if (!$community)
    return ["error" => "This community does not exist !"];

  $community_followers = get_field('follower_community',$community->ID) ? get_field('follower_community',$community->ID) : [] ;
  
  foreach($community_followers as $key => $follower)
  {
    if ($follower -> data == $user -> data)
    {
      unset ($community_followers[$key]);
      if (update_field('follower_community',$community_followers,$community->ID))
        return ['success ' => 'Successfully unsubscribed in this community !'];
    }
  }
  
  array_push($community_followers,$user);
  
  if (update_field('follower_community',$community_followers,$community->ID))
    return ['success' => 'Successfully subscribed in this community !'];
  
  return ['error' => 'Subscription to this community failed!'];

}

function askQuestion(WP_REST_Request $request)
{
  $user_id = $request['user_id'] ?? 0;
  $community_id = $request['community_id'] ?? 0;
  $text_question = $request['text_question'] ?? "";
  
  if ($user_id == 0)
    return ["error" => "You have to fill the correct user id !"];

  if ($community_id == 0)
    return ["error" => "You have to fill the correct community id !"];
  
  if ($text_question == "")
  return ["error" => "You have to fill the wording of the question !"];

  $community = get_post($community_id);
  $user = get_user_by('ID',$user_id); 
  if (!$user_id)
    return ["error" => "This user does not exist !"];

  if (!$community)
    return ["error" => "This community does not exist !"];
  
  $question = array();

    //New question
    $question_community = get_field('question_community', $community_id) ? get_field('question_community', $community_id) : [] ;
    $question['user_question'] = $user;
    $question['user_question']->data->profile_image = get_field('profile_img','user_'.(int)$question['user_question']->data->ID) != false ? get_field('profile_img','user_'.(int)$question['user_question']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $question['text_question'] = $text_question;
    array_push($question_community, $question);

    if (update_field('question_community', $question_community, $community_id))
      return $question_community;

    return ['error' => 'Question not saved successfully !'];
    
}

function replyQuestion(WP_REST_Request $request)
{
  $user_id = $request['user_id'] ?? 0;
  $community_id = $request['community_id'] ?? 0;
  $text_reply = $request['text_reply'] ?? "";
  $index_question = is_int($request['index_question']) ? $request['index_question'] : null;
  if ($user_id == 0)
    return ["error" => "You have to fill the correct user id !"];

  if ($community_id == 0)
    return ["error" => "You have to fill the correct community id !"];
  
  if ($text_reply == "")
  return ["error" => "You have to fill the wording of your reply !"];

  
  $community = get_post($community_id);
  $user = get_user_by('ID',$user_id);

  if (!$user_id)
    return ["error" => "This user does not exist !"];

  if (!$community)
    return ["error" => "This community does not exist !"];

    $question_community = get_field('question_community', $community_id) ? get_field('question_community', $community_id) : [] ;
  
    if (!empty($question_community))
      if(is_int($index_question))
        {
          if (isset($question_community[$index_question]) && !empty($question_community[$index_question])){
            $reply = array();
            $user_reply = $user;
            $reply['user_reply'] = $user_reply;
            $reply['user_reply']->data->profile_image = get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) != false ? get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            $reply['text_reply'] = $text_reply;
            if(empty($question_community[$index_question]['reply_question']))
                $question_community[$index_question]['reply_question'] = array();

            array_push($question_community[$index_question]['reply_question'], $reply);
            update_field('question_community', $question_community, $community_id);
            return $question_community;
          }
          return ['error' => "This index of question doesn't exist !"];
        }
}

/** Views Endpoints */
function save_user_views(WP_REST_Request $request)
{
    $data_id = (isset($request['data_id'])) ? $request['data_id'] : 0;
    if(!$data_id)
      return ["error" => 'You\'ve to fill in the id of the data !' ];
    
    $user_id = (isset($request['user_id'])) ? $request['user_id'] : 0;
    if (!$user_id)
      return ["error" => 'You\'ve to fill in the user id!' ];

    $data_type = (isset($request['data_type'])) ? $request['data_type'] : 0;
    if (!$data_type)
      return ["error" => 'You\'ve to fill in the type of the data!' ];
    $user_visibility = get_user_by( 'ID', $user_id);
    global $wpdb;
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $occurence = 1;

    //Add by MaxBird - get name entity
    if($data_type == 'course')
    {
        $course = get_post($data_id);
        $data_name = (!empty($course)) ? $course->post_name : null;
    }
    else if($data_type == 'expert')
    {
        $expert_infos = get_user_by('id', $data_id);
        $data_name = ($expert_infos->last_name) ? $expert_infos->first_name : $expert_infos->display_name;
    }
    else if($data_type == 'topic')
        $data_name = (String)get_the_category_by_ID($data_id);

    /** Badges **/
    $sql = $wpdb->prepare( "SELECT data_id FROM $table_tracker_views WHERE user_id = $user_id");
    $occurences = $wpdb->get_results( $sql );
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id = " . $user_id . " AND data_type = 'topic' AND occurence >= 10 GROUP BY data_id ORDER BY occurence DESC");
    $topic_views = $wpdb->get_results($sql);
    $best_topic_views = intval($topic_views[0]->occurence);

    $count = array('Opleidingen' => 0, 'Workshop' => 0, 'E-learning' => 0, 'Event' => 0, 'E_learning' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0, 'Podcast' => 0);
    $libelle_badges = [
        'Congratulations ' . $user_visibility->display_name . ', you\'ve just read your first article !',
        'Well done ' . $user_visibility->display_name . ' you become expert in article',
        'Good job ' . $user_visibility->display_name . ', video expert apprentice !',
        'Well done ' . $user_visibility->display_name . ' you become expert in video',
        $user_visibility->display_name . ', you\'re really a podcast enthusiast !',
        $user_visibility->display_name . ', you\'re really determined to learn !'
    ];
    $trigger_badges = [
        'Read my first article !',
        'Read 50 articles !',
        'Read 10 videos !',
        'Read 50 videos !' ,
        'Read 7 podcasts !' ,
        'View the same topic more than 10 times'
];
    $array_badges = array();

    foreach ($occurences as $value) {
        $course_type = get_field('course_type', $value->data_id);
        $count[$course_type]++;
    }

    $image_badge = get_stylesheet_directory_uri() . '/img/badge-assessment-sucess.png';
    $trigger_badge = null;
    if($count['Artikel'] >= 1 && $count['Artikel'] < 50){
        $array_badge = array();
        $array_badge['libelle'] = $libelle_badges[0];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[0];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Artikel'] >= 50){
        $array_badge = array();
        $array_badge['libelle'] = $libelle_badges[1];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[1];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Video'] >= 10 && $count['Video'] < 50){
        $array_badge = array();
        $array_badge['libelle'] = $libelle_badges[2];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[2];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Video'] >= 50){
        $array_badge = array();
        $array_badge['libelle'] = $libelle_badges[3];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[3];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Podcast'] >= 7){
        $array_badge = array();
        $array_badge['libelle'] = $libelle_badges[4];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[4];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($best_topic_views >= 10){
      $array_badge = array();
      $array_badge['libelle'] = $libelle_badges[5];
      $array_badge['image'] = $image_badge;
      $array_badge['trigger'] = $trigger_badges[5];
      $object_badge = (Object)$array_badge;
      array_push($array_badges, $object_badge);
    }

    foreach($array_badges as $badge)
      if($badge){
        //Occurrence check
        $args = array(
            'post_type' => 'badge', 
            'title' => $badge->libelle,
            'post_status' => 'publish',
            'author' => $user_id,
            'posts_per_page'         => 1,
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false
        );
        $badges = get_posts($args);

        if(empty($badges)){
            $post_data = array(
                'post_title' => $badge->libelle,
                'post_author' => $user_id,
                'post_type' => 'badge',
                'post_status' => 'publish'
            );
            $badge_id = wp_insert_post($post_data);

            //Push notifications
            $title = $badge->libelle;
            $body = $badge->trigger;
            sendPushNotificationN($title, $body);
        }

        if(isset($badge_id))
            if($badge_id){
                update_field('image_badge', $badge->image, $badge_id);
                update_field('trigger_badge', $badge->trigger, $badge_id);
            }
      } 

    /** end Badges */


    //testing wheither data_id exist ?
    $sql = $wpdb->prepare( "SELECT occurence FROM $table_tracker_views WHERE data_id = $data_id AND user_id = $user_id");
    $occurence_id = $wpdb->get_results( $sql)[0]->occurence;
    if ($occurence_id) {
      $occurence = intval($occurence_id) + 1;
      $data = [
          'occurence' => $occurence
      ];
      $where = [
          'data_id'=> $data_id,
      ];
      return $wpdb->update($table_tracker_views,$data,$where);
    }

    $data = [
        'data_type'=> $data_type,
        'data_id'=> $data_id,
        'data_name'=> $data_name, //to change with @Mouhamed
        'user_id'=> $user_id,
        'platform'=> 'mobile',
        'occurence'=> $occurence
    ];
    $wpdb->insert($table_tracker_views, $data);
    return $wpdb->insert_id;
}

/* Badge Endpoints */

 function get_user_badges()
 {
    $user_id = $GLOBALS['user_id'];
    $query = 
      array(
        'post_type' => array('badge'), 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'author__in' => [$user_id]
    );
    $badges = get_posts($query);
    $retrieved_badges = array();
    foreach ($badges as $key => $badge) 
    {
      $badge -> state_read_badge = get_field('state_read_badge',$badge->ID) == 0 || get_field('state_read_badge',$badge->ID) == null ? false : true;  
      $badge -> image_badge = get_field('image_badge',$badge->ID) ?? '';  
      $badge -> trigger_badge = get_field('trigger_badge',$badge->ID) ?? ''; 
      array_push($retrieved_badges, new Badge($badge)); 
    }
    $response = new WP_REST_Response($retrieved_badges);
    $response->set_status(200);
    return $response;
 }

 /**
  * Firebase Push Notifications Endpoints
  */

  function update_user_smartphone_token(WP_REST_Request $request)
  {
    $user_id = $request['user_id'] ?? false;
    if (!$user_id)
    {
      $response = new WP_REST_Response("You have to fill the id of the current user !"); 
      $response->set_status(400);
      return $response;
    }
    $user = get_user_by( 'ID', $user_id ) ?? false;
    if (!$user)
    {
      $response = new WP_REST_Response("This id filled doesn't exist !");
      $response->set_status(400);
      return $response;
    }
    $smartphone_token = $request['smartphone_token'] ?? false;

    if (!$smartphone_token){
      $response = new WP_REST_Response("You have to fill the token of your current smartphone !");
      $response->set_status(400);
      return $response;
    }
    update_field('smartphone_token',$smartphone_token,'user_'.$user->ID);
      // Create the response object and Add a custom status code
    $response = new WP_REST_Response($smartphone_token);
    $response->set_status(200);
    return $response;
  }
