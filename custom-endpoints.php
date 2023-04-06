<?php


$GLOBALS['user_id'] = get_current_user_id();
class Expert
{
 public  $id;
 public   $name;
 public  $profilImg;
 public $company;

  public $role;

 function __construct($expert,$profilImg) {
    $this->id=(int)$expert->ID;
    $this->name=$expert->display_name;
    $this->profilImg =$profilImg;
    $this->company = get_field('company', 'user_' . (int)$expert->ID)[0] ?? null;
    $this->role = get_field('role', 'user_' . (int)$expert->ID) ?? '';
    // if(!empty($company) ){
    //     $company = $company[0];
    //     $company_connected = $company->post_title;
    // } 
    
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
    //  $this->visibility = get_field('company',  'user_' . $course->post_author)[0] != null ?
    //  visibility($course, get_field('company',  'user_' . $course->post_author)[0]) : false;
     $this->podcasts = $course->podcasts;
     $this->connectedProduct = $course->connectedProduct;
     $this->author = $course->author;
     $this->articleItself = get_field('article_itself', $course->ID) ?? '';
     $this->likes = is_array(get_field('favorited', $course->ID)) ? count(get_field('favorited', $course->ID)) : 0 ; //?? [];
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


/** **************** Api Custom Endpoints **************** */

function allCourses ($data)
{
    
    $current_user_id = $GLOBALS['user_id'];
    $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
    $course_type = $_GET['course_type'];
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
      return ['error' => "There is no courses related to this course type in the database! ","codeStatus" => 400];
      
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
    return ['error' => "Page doesn't exist ! ","codeStatus" => 400];  
  
  for($i=$start; $i < $end ;  $i++) 
  {
      //$courses[$i]->links = $courses[$i]-> guid ?? null;
      $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
      $author = get_user_by( 'ID', $courses[$i] -> post_author  );
      $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
      if ($courses[$i]->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
          $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          $courses[$i]->pathImage = get_field('url_image_xml',$courses[$i]->ID);
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
              
          $new_course = new Course($courses[$i]);
          array_push($outcome_courses, $new_course);
    }
   return ['courses' => $outcome_courses, "codeStatus" => 200];
  }

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
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
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

function get_expert_courses ($data) {
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
        $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $course-> author = new Expert ($author , $author_img);
        $course->longDescription = get_field('long_description',$course->ID);
        $course->shortDescription = get_field('short_description',$course->ID);
        $course->courseType = get_field('course_type',$course->ID);
        $course->pathImage = get_field('url_image_xml',$course->ID);
        $course->price = get_field('price',$course->ID);
        $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
        $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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
          $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
          $course->pathImage = get_field('url_image_xml',$course->ID);
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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

function get_course_by_id($data){
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
          $author = get_user_by( 'ID', $course -> post_author  );
          $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
          $course->pathImage = get_field('url_image_xml',$course->ID);
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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
          $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
          $course->pathImage = get_field('url_image_xml',$course->ID);
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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
        array_push($liked_courses, new Course($course));
      }
  }
  return $liked_courses;
}


function recommended_course()
{
  //The user
  $user = $GLOBALS['user_id'];
  
  $company_visibility = get_field('company',  'user_' . $user);

  if(!empty($company_visibility))
      $visibility_company = $company_visibility[0]->post_title;
  
  $i = 0;

  $courses = array();
  $course_id = array();
  $random_id = array(); 
  $categories = array();

  //Categories
  $cats = get_categories( array(
      'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
      'orderby'    => 'name',
      'exclude' => 'Uncategorized',
      'parent'     => 0,
      'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );

  foreach($cats as $category){
      $cat_id = strval($category->cat_ID);
      $category = intval($cat_id);
      array_push($categories, $category);
  }

  /*
  ** Categories
  */
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
  $subtopics = array(); 
  foreach($categories as $categ){
      //Topics
      $topicss = get_categories(
          array(
          'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
          'parent'  => $categ,
          'hide_empty' => 0, // change to 1 to hide categores not having a single post
          ) 
      );

      foreach ($topicss as  $value) {
          $subtopic = get_categories( 
              array(
              'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
              'parent'  => $value->cat_ID,
              'hide_empty' => 0,
              //  change to 1 to hide categores not having a single post
              ) 
          );
          $subtopics = array_merge($subtopics, $subtopic);      
      }
  }

  // Get interests courses
  $topics_external = get_user_meta($user, 'topic');
  $topics_internal = get_user_meta($user, 'topic_affiliate');

  $topics = array();
  if(!empty($topics_external))
      $topics = $topics_external;

  if(!empty($topics_internal))
      foreach($topics_internal as $value)
          array_push($topics, $value);
  
  $experts = get_user_meta($user, 'expert');
  $args = array(
      'post_type' => array('course', 'post'), 
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC'
  );
  $global_courses = get_posts($args);
  
  foreach ($global_courses as $key => $course) {    

      /*
      *  Date and Location
      */
      $data = array();
      $day = '-';
      $month = '';
      $location = 'Virtual';

      $datas = get_field('data_locaties', $course->ID);

      if($datas){
          $data = $datas[0]['data'][0]['start_date'];
          if($data != ""){
              $day = explode('/', explode(' ', $data)[0])[0];
              $mon = explode('/', explode(' ', $data)[0])[1];
              $month = $calendar[$mon];
          }   
      }else{
          $datum = get_field('data_locaties_xml', $course->ID);

          if($datum)
              if(isset($datum[0]['value']))
                  $element = $datum[0]['value'];

          if(!isset($element))
              continue;

          $datas = explode('-', $element);

          $data = $datas[0];
          $day = explode('/', explode(' ', $data)[0])[0];
          $month = explode('/', explode(' ', $data)[0])[1];
          $month = $calendar[$month];
          $location = $datas[2];
      }

      //Course Type
      $course_type = get_field('course_type', $course->ID);

      if(empty($data))
          null;
      else if(!empty($data) && $course_type != "Video" && $course_type != "Artikel")
          if($data){
              $date_now = strtotime(date('Y-m-d'));
              $data = strtotime(str_replace('/', '.', $data));
              if($data < $date_now)
                  continue;
          }
      /*
      * End
      */

      /*
      * Thumbnails
      */
      $course->image = get_field('preview', $course->ID)['url'];
      if(!$course->image){
          $course->image = get_the_post_thumbnail_url($course->ID);
          if(!$course->image)
              $course->image = get_field('url_image_xml', $course->ID);
                  if(!$course->image)
                      $course->image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
      }
      
      //Image author
      $course->author_image = get_field('profile_img', 'user_' . $course->post_author);
      $course->author_image = $course->author_image ?: get_stylesheet_directory_uri() . '/img/user.png';

      //Preferences categories
      $category_default = get_field('categories', $course->ID);
      $category_xml = get_field('category_xml', $course->ID);
      $read_category = array();
      if(!empty($category_default))
          foreach($category_default as $item)
              if($item)
                  if(!in_array($item['value'],$read_category))
                      array_push($read_category,$item['value']);

      else if(!empty($category_xml))
          foreach($category_xml as $item)
              if($item)
                  if(!in_array($item['value'],$read_category))
                      array_push($read_category,$item['value']);

      foreach($topics as $topic_value) {
          if($read_category)
              if(in_array($topic_value, $read_category) ){
                  if(!in_array($course->ID, $course_id)){
                      array_push($course_id, $course->ID);
                      array_push($courses, $course);  
                      break;
                  }
          }
      }

      //Preference author
      if($experts)
          if(in_array($course->post_author, $experts))
              if(!in_array($course->ID, $course_id)){
                  array_push($course_id, $course->ID);
                  array_push($courses, $course);
              }
      

      //Preference expert
      $experties = get_field('experts', $course->ID);
      if($experties && $experts)
          foreach($experties as $topic_expert){
              if(in_array($topic_expert, $experts)){
                  if(!in_array($course->ID, $course_id)){
                      array_push($course_id, $course->ID);
                      array_push($courses, $course);
                      break;
                  }
              }
          }
  }

  $courses = array_slice($courses, 0, 150);

  //Views
  $user_post_view = get_posts(
      array(
          'post_type' => 'view',
          'post_status' => 'publish',
          'author' => $user,
          'order' => 'DESC'
      )
  )[0];   
  $is_view = false;

  if (!empty($user_post_view))
  {
      $courses_id = array();
      $is_view = true;
  
      $all_user_views = (get_field('views', $user_post_view->ID));
      $max_points = 10;
      $recommended_courses = array();

      foreach($all_user_views as $key => $view) {
          if(!$view['course'])
              continue;

          foreach ($courses as $key => $course) {
              $points = 0;
              $course->image = "";
              $course->author_image = "";

              /*
              * Thumbnails
              */
              $course->image = get_field('preview', $course->ID)['url'];
              if(!$course->image){
                  $course->image = get_the_post_thumbnail_url($course->ID);
                  if(!$course->image)
                      $course->image = get_field('url_image_xml', $course->ID);
                          if(!$course->image)
                              $course->image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
              }
              
              //Image author
              $course->author_image = get_field('profile_img', 'user_' . $course->post_author);
              $course->author_image = $course->author_image ?: get_stylesheet_directory_uri() . '/img/user.png';

              //Read category viewed
              $read_category_view = array();
              $category_default = get_field('categories', $view['course']->ID);
              $category_xml = get_field('category_xml', $view['course']->ID);        
              if(!empty($category_default))
                  foreach($category_default as $item)
                      if($item)
                          if(!in_array($item['value'],$read_category_view))
                              array_push($read_category_view, $item['value']);
                          
              else if(!empty($category_xml))
                  foreach($category_xml as $item)
                      if($item)
                          if(!in_array($item['value'],$read_category_view))
                              array_push($read_category_view, $item['value']);
                          
              
              //Read category course
              $read_category_course = array();
              $category_default = get_field('categories', $view['course']->ID);
              $category_xml = get_field('category_xml', $view['course']->ID);        
              if(!empty($category_default))
                  foreach($category_default as $item)
                      if($item)
                          if(!in_array($item['value'],$read_category_course))
                              array_push($read_category_course, $item['value']);
                          
              else if(!empty($category_xml))
                  foreach($category_xml as $item)
                      if($item)
                          if(!in_array($item['value'],$read_category_course))
                              array_push($read_category_course, $item['value']);
              
              //Price view
              $view_prijs = get_field('price', $view['course']->ID);

              foreach($read_category_view as $value){
                  if($points == 6)
                      break;
                  if(in_array($value, $read_category_course))
                      $points += 3;
              }
              if ($view['course']->post_author == $course->post_author) 
                  $points += 3;
              if ($view_prijs <= $course->price)
                  $points += 1;
              
              $percent = abs(($points/$max_points) * 100);
              if ($percent >= 50)
                  if(!in_array($course->ID, $random_id)){
                      array_push($random_id, $course->ID);
                      array_push($recommended_courses, $course);
                  }
          }
      }
  }

  $recommended_courses = array_slice($recommended_courses, 0, 20); 

  if (empty($recommended_courses))
      $recommended_courses = $courses;

  shuffle($recommended_courses);
  if (!empty($recommended_courses)) {
    $current_user_id = $GLOBALS['user_id'];
    $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
    $outcomes_recommended_courses = $recommended_courses;
    foreach ($recommended_courses as $key => $course) {
      $course->visibility = get_field('visibility', $course->ID) ?? [];
      $author = get_user_by('ID', $course->post_author);
      $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
      if ($course->visibility != [])
        if ($author_company != $current_user_company)
          continue;
      $author_img = get_field('profile_img', 'user_' . $author->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      $course->experts = array();
      $experts = get_field('experts', $course->ID);
      if (!empty($experts))
        foreach ($experts as $key => $expert) {
          $expert = get_user_by('ID', $expert);
          $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          array_push($course->experts, new Expert($expert, $experts_img));
        }
      $course->author = new Expert($author, $author_img);
      $course->longDescription = get_field('long_description', $course->ID);
      $course->shortDescription = get_field('short_description', $course->ID);
      $course->courseType = get_field('course_type', $course->ID);
      $course->pathImage = get_field('url_image_xml', $course->ID);
      $course->price = get_field('price', $course->ID) ?? 0;
      $course->youtubeVideos = get_field('youtube_videos', $course->ID) ? get_field('youtube_videos', $course->ID) : [];
      $course->podcasts = get_field('podcasts', $course->ID) ? get_field('podcasts', $course->ID) : [];

      $course->connectedProduct = get_field('connected_product', $course->ID);
      $tags = get_field('categories', $course->ID) ?? [];
      $course->tags = array();
      if ($tags)
        if (!empty($tags))
          foreach ($tags as $key => $category)
            if (isset($category['value'])) {
              $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
              array_push($course->tags, $tag);
            }

      $new_course = new Course($course);
      array_push($outcomes_recommended_courses, $new_course);
    }
    return $outcomes_recommended_courses;
  }
  else 
      return ["error" => "Nothing to show, don't ask me why 😅 !"];
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
  foreach ($global_courses as $course) {
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
          $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
          $course->pathImage = get_field('url_image_xml',$course->ID);
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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
          $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $course-> author = new Expert ($author , $author_img);
          $course->longDescription = get_field('long_description',$course->ID);
          $course->shortDescription = get_field('short_description',$course->ID);
          $course->courseType = get_field('course_type',$course->ID);
          $course->pathImage = get_field('url_image_xml',$course->ID);
          $course->price = get_field('price',$course->ID) ?? 0;
          $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
          $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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
  }
  return $courses_related_subtopic;
}

function filter_course(WP_REST_Request $request)
{
  $current_user_id = $GLOBALS['user_id'];
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
  $tags_parameter = $request['tags'] ?? [];
  $authors = $request['authors'] ?? [];
  $companies = $request['companies'] ?? [];
  $date = $request['date'] ?? null;
  $min_price = $request['min_price'] ?? 0;
  $max_price = $request['max_price'] ?? 0;
  $courses = get_posts(
    array(
      'post_type' => array('course', 'post'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
    )
  );
  $global_courses = array();
  foreach ($courses as $key => $course) {
    $course->visibility = get_field('visibility', $course->ID) ?? [];
    $author = get_user_by('ID', $course->post_author);
    $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
    if ($course->visibility != [])
      if ($author_company != $current_user_company)
        continue;
    $course->experts = array();
    $experts = get_field('experts', $course->ID);
    if (!empty($experts))
      foreach ($experts as $key => $expert) {
        $expert = get_user_by('ID', $expert);
        $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        array_push($course->experts, new Expert($expert, $experts_img));
      }
    $author = get_user_by('ID', $course->post_author);
    $author_img = get_field('profile_img', 'user_' . $author->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $course->author = new Expert($author, $author_img);
    $course->longDescription = get_field('long_description', $course->ID);
    $course->shortDescription = get_field('short_description', $course->ID);
    $course->courseType = get_field('course_type', $course->ID);
    $course->pathImage = get_field('url_image_xml', $course->ID);
    $course->price = get_field('price', $course->ID) ?? 0;
    $course->youtubeVideos = get_field('youtube_videos', $course->ID) ? get_field('youtube_videos', $course->ID) : [];
    $course->podcasts = get_field('podcasts', $course->ID) ? get_field('podcasts', $course->ID) : [];
    $course->visibility = get_field('visibility', $course->ID);
    $course->connectedProduct = get_field('connected_product', $course->ID);
    $tags = get_field('categories', $course->ID) ?? [];
    $course->tags = array();
    if ($tags)
      if (!empty($tags))
        foreach ($tags as $key => $category)
          if (isset($category['value'])) {
            $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
            array_push($course->tags, $tag);
          }

    $new_course = new Course($course);
    array_push($global_courses, $new_course);
  }
  $filtered_courses = array();
  foreach ($global_courses as $key => $course) {
    
    /** Filter by tags */
    if ($course->tags != [] && $tags_parameter != [])
    { 
      foreach ($course->tags as $key => $tag) {
        if (in_array($tag->id, $tags_parameter))
          if (!in_array($course, $filtered_courses)) {
            array_push($filtered_courses, $course);
          }
      }
      
    }
    /** Filter by author */
    if ($authors != [])
      foreach ($authors as $key => $autor) {
        if ($autor == $course->author->id)
          if (!in_array($course, $filtered_courses)) {
            array_push($filtered_courses, $course);
          }
      }
    if ($authors != [])
      /** Filter by experts */
      foreach ($authors as $key => $autor) {
        foreach ($course->experts as $key => $expert) {
          if ($autor == $expert->id)
            if (!in_array($course, $filtered_courses)) {
              array_push($filtered_courses, $course);
            }
        }

      }

    /** Filter by minimum price */
    if ($min_price != 0)
      if ($course->price >= $min_price)
        if (!in_array($course, $filtered_courses)) {
          array_push($filtered_courses, $course);
        }
    /** Filter by maximum price */
    if ($max_price != 0)
      if ($max_price >= $course->price)
        if (!in_array($course, $filtered_courses)) {
          array_push($filtered_courses, $course);

        }


    //     /** Filter by company */
    if ($companies != [])
      if (in_array($course->author->company->ID, $companies))
        if (!in_array($course, $filtered_courses)) {
          array_push($filtered_courses, $course);
        }
    }
    return $filtered_courses;
  }


  function custom_filter_course(WP_REST_Request $request)
  {
    $current_user_id = $GLOBALS['user_id'];
    $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
    $tags_parameter = $request['tags'] ?? [];
    $authors = $request['authors'] ?? [];
    $companies = $request['companies'] ?? [];
    $date = $request['date'] ?? null;
    $min_price = $request['min_price'] ?? 0;
    $max_price = $request['max_price'] ?? 0;
    $courses = $request['courses'];
    $filtered_courses = array();
    foreach ($courses as $key => $course) 
    {
      $course = (object)$course;
      
      /** Filter by tags */
      if ($course->tags != [] && $tags_parameter != [])
      { 
        
        foreach ($course->tags as $key => $tag) {
          $tag = (object)$tag;
          if (in_array($tag->id, $tags_parameter))
            if (!in_array($course, $filtered_courses)) {
              array_push($filtered_courses, $course);
            
            }
        }
        
      }
      /** Filter by author */
      if ($authors != [])
        foreach ($authors as $key => $autor) {
          if ($autor == ((object)($course->author))->id)
            if (!in_array($course, $filtered_courses)) {
              array_push($filtered_courses, $course);
            }
        }
      if ($authors != [])
        /** Filter by experts */
        foreach ($authors as $key => $autor) {
          foreach ($course->experts as $key => $expert) {
            if ($autor == ((object) $expert)->id)
              if (!in_array($course, $filtered_courses)) {
                array_push($filtered_courses, $course);
              }
          }

        }

      /** Filter by minimum price */
        
        if ($course->price >= $min_price)
          if (!in_array($course, $filtered_courses)) {
            array_push($filtered_courses, $course);
          }
      /** Filter by maximum price */
      if ($max_price != 0)
        if ($max_price >= $course->price)
          if (!in_array($course, $filtered_courses)) {
            array_push($filtered_courses, $course);
          }


      //     /** Filter by company */
      if ($companies != [])
      {
        $course_company = $course->author["company"]["ID"];
        if (in_array($course_company, $companies))
          if (!in_array($course, $filtered_courses)) {
            array_push($filtered_courses, $course);
          }
      }
    }
      return $filtered_courses;
  }
  

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
        if( $value->post_name == $company->post_name ){
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



  function getAssessments()
  {
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
      $questions=get_field('question',$assessment->ID);  
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
      }
        return ['score' => $score];
    }
  }
}