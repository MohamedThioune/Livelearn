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
    //print_r($courses);
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
      //$courses[$i]->links = $courses[$i]-> guid ?? null;
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
              
          $new_course = new Course($courses[$i]);
          array_push($outcome_courses, $new_course);
    }
   return ['courses' => $outcome_courses, "codeStatus" => 200];
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
        //print_r(count($courses));
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
          //$courses[$i]->links = $courses[$i]-> guid ?? null;
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
    $author_img = get_field('profile_img', 'user_' . $author->ID) !=false ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $course->author = new Expert($author, $author_img);
    $course->longDescription = get_field('long_description', $course->ID);
    $course->shortDescription = get_field('short_description', $course->ID);
    $course->courseType = get_field('course_type', $course->ID);
    //Image - article
    $image = get_field('preview', $course->ID)['url'];
    if(!$image){
        $image = get_the_post_thumbnail_url($course->ID);
        if(!$image)
            $image = get_field('url_image_xml', $course->ID);
                if(!$image)
                    $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
    }
    $courses->pathImage = $image;
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
  foreach ($communities as $key => $community) {
    $community-> author_company = get_field('company_author',$community->ID) ? get_field('company_author',$community->ID) : null;
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
            $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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
            array_push($community->courses,new Course($course));
          
      }

  }
  
  return $communities;

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
  
    $community-> author_company = get_field('company_author',$community->ID) ? get_field('company_author',$community->ID) : null;
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
            $course->podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
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
/** Views Endpoints */
  
  function update_view_course(WP_REST_Request $request)
  {

    $course_id = (isset($request['course_id'])) ? $request['course_id'] : 0;
      if(!$course_id)
         ["error" => 'You\'ve to fill in the course id!'];
    save_view($course_id,'course', true);
    
      // $user_id = (isset($request['user_id'])) ? $request['user_id'] : 0;
      // if(empty($user_id))
      //     ["error" => 'You\'ve to fill in the user id!' ];

      // $user = get_user_by('ID',$user_id) ?? null;
      // if(empty($user))
      //     ["error" => 'This user id does not exist!' ];
      
      // $course_id = (isset($request['course_id'])) ? $request['course_id'] : 0;
      // if(!$user_id)
      //   ["error" => 'You\'ve to fill in the course id!'];

      // $course = get_post($course_id) ?? null;
      // if(empty ($course))
      //   ["error" => 'This course id does not exist!'];

      // $args = array(
      //     'post_type' => 'view', 
      //     'post_status' => 'publish',
      //     'author' => $user_id,
      // );

      // $views_stat_user = get_posts($args);

      // if(!empty($views_stat_user))
      //     $stat_id = $views_stat_user[0]->ID;
      // else{
      //     $data = array(
      //         'post_type' => 'view',
      //         'post_author' => $user_id,
      //         'post_status' => 'publish',
      //         'post_title' => $user->display_name . ' - View',
      //         );
          
      //     $stat_id = wp_insert_post($data);
      // }

      // $view = get_field('views', $stat_id);
      
      // $one_view = array();
      // $one_view['course'] = $course;
      // $one_view['date'] = date('d/m/Y H:i:s');

      // if(!empty($view))
      //     array_push($view, $one_view);
      // else 
      //     $view = array($one_view); 
      
      // update_field('views', $view, $stat_id);



  }

  function update_view_topic(WP_REST_Request $request)
  {
    insert_view_user(1,'expert', true);
    // $topic_id = (isset($request['topic_id'])) ? $request['topic_id'] : null;
    //   if(empty($topic_id))
    //     return ["error" => 'You\'ve to fill in the topic id!' ];
  

      // $user_id = (isset($request['user_id'])) ? $request['user_id'] : 0;
      // if(empty($user_id))
      //   return ["error" => 'You\'ve to fill in the user id!' ];

      // $user = get_user_by('ID',$user_id) ?? null;
      // if(empty($user))
      //   ["error" => 'This user id does not exist' ];
      
      // $topic_id = (isset($request['topic_id'])) ? $request['topic_id'] : null;
      // if(empty($topic_id))
      //     return ["error" => 'You\'ve to fill in the topic id!' ];

      // $args = array(
      //     'post_type' => 'view', 
      //     'post_status' => 'publish',
      //     'author' => $user_id,
      // );

      // $views_stat_user = get_posts($args);

      // if(!empty($views_stat_user))
      //     $stat_id = $views_stat_user[0]->ID;
      // else
      // {
      //     $data = array(
      //         'post_type' => 'view',
      //         'post_author' => $user_id,
      //         'post_status' => 'publish',
      //         'post_title' => $user->display_name . ' - View',
      //         );
          
      //     $stat_id = wp_insert_post($data);
      // }

      // $view = get_field('views_topic', $stat_id);
      
      // $one_view = array();
      // $one_view['view_id'] = $topic_id;
      // $one_view['view_name'] = (String)get_the_category_by_ID($topic_id);
      // $one_view['view_date'] = date('d/m/Y H:i:s');

      // if(!empty($view))
      //     array_push($view, $one_view);
      // else 
      //     $view = array($one_view); 
      
      // update_field('views_topic', $view, $stat_id);

  }

  function insert_view_user($data_id, $type='course',?bool $isMobile) {
    return 'Bonjour';
    $user_visibility = wp_get_current_user();
    global $wpdb;
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
    if(!$user_id)
        return;
    $occurence = 1;

    //Add by MaxBird - get name entity
    if($type == 'course')
    {
        $course = get_post($data_id);
        $data_name = (!empty($course)) ? $course->post_name : null;
    }
    else if($type == 'expert')
    {
        $expert_infos = get_user_by('id', $data_id);
        $data_name = ($expert_infos->last_name) ? $expert_infos->first_name : $expert_infos->display_name;
    }
    else if($type == 'topic')
        $data_name = (String)get_the_category_by_ID($data_id);
        
    // if(!$data_name)
    //     return;

    //testing wheither data_id exist ?
    $sql = $wpdb->prepare( "SELECT occurence FROM $table_tracker_views  WHERE data_id = $data_id");
    $occurence_id = $wpdb->get_results( $sql)[0]->occurence;
    if ($occurence_id) {
        $occurence = intval($occurence_id) + 1;
        $data=[
            'occurence' => $occurence
        ];
        $where=[
            'data_id'=> $data_id,
        ];
        return $wpdb->update($table_tracker_views,$data,$where);
    }
    $data = [
        'data_type'=> $type,
        'data_id'=> $data_id,
        'data_name'=> $data_name, //to change with @Mouhamed
        'user_id'=> $user_id,
        'platform'=> $isMobile ? 'mobile' : 'web',
        'occurence'=> $occurence
    ];
    $wpdb->insert($table_tracker_views, $data);
    return $wpdb->insert_id;
}

  function update_view_experts(WP_REST_Request $request)
  {
    insert_view_user(1,'expert', true);
    $expert_id = (isset($request['expert_id'])) ? $request['expert_id'] : 0;
      if(!$expert_id)
          return ["error" => 'You\'ve to fill in the expert id!' ];
      
    // $user_id = (isset($request['user_id'])) ? $request['user_id'] : 0;
    // if(!$user_id)
    //   return ["error" => 'You\'ve to fill in the user id!' ];

    // $user = get_user_by('ID',$user_id) ?? null;
    // if(empty($user))
    //     return ["error" => 'This user id does not exist!' ];

    //   $expert_id = (isset($request['expert_id'])) ? $request['expert_id'] : 0;
    //   if(!$expert_id)
    //       return ["error" => 'You\'ve to fill in the expert id!' ];
      
    //   $args = array(
    //       'post_type' => 'view', 
    //       'post_status' => 'publish',
    //       'author' => $user_id,
    //   );

    //   $views_stat_user = get_posts($args);

    //   if(!empty($views_stat_user))
    //       $stat_id = $views_stat_user[0]->ID;
    //   else
    //   {
    //       $data = array(
    //           'post_type' => 'view',
    //           'post_author' => $user_id,
    //           'post_status' => 'publish',
    //           'post_title' => $user->display_name . ' - View',
    //           );
          
    //       $stat_id = wp_insert_post($data);
    //   }

    //   $view = get_field('views_user', $stat_id);
      
    //   $one_view = array();
    //   $one_view['view_id'] = $expert_id;
    //   $one_view['view_name'] = get_userdata($expert_id)->display_name;
    //   $one_view['view_date'] = date('d/m/Y H:i:s');

    //   if(!empty($view))
    //       array_push($view, $one_view);
    //   else 
    //       $view = array($one_view); 
      
    //   update_field('views_user', $view, $stat_id);

  }

  

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
        
    //testing wheither data_id exist ?
    $sql = $wpdb->prepare( "SELECT occurence FROM $table_tracker_views  WHERE data_id = $data_id");
    $occurence_id = $wpdb->get_results( $sql)[0]->occurence;
    if ($occurence_id) {
        $occurence = intval($occurence_id) + 1;
        $data=[
            'occurence' => $occurence
        ];
        $where=[
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
  
/** Views Endpoints */

/** Artikels Endpoints */

// function RandomString(){
//   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//   $randstring = '';
//   $rand='';
//   for ($i = 0; $i < 10; $i++) {
//       $rand = $characters[rand(0, strlen($characters))];
//       $randstring .= $rand;  
//   }
//   return $randstring;
// }

function strip_html_tags($text) {
  $allowed_tags = ['h2', 'br','strong','em','u','blockquote','ul','ol','li'];
  $text = preg_replace("/\n{1,}/", "\n", $text); 
  $text = str_replace("\n","<br>",$text);
  $text = str_replace("&lt;","<",$text);
  $text = str_replace("&gt;",">",$text);
  $text = str_replace("&#8216;","`",$text);
  $text = str_replace("&#8217;","`",$text); 
  $text = str_replace("&#8220;","\"",$text);
  $text = str_replace("&#8221;","\"",$text); 
  $text = str_replace("&#8230;","...",$text);
  $text = str_replace(['h1','h3','h4','h5','h6'],'h2',$text);
  $pattern = '/<(?!\/?(?:' . implode('|', $allowed_tags) . ')\b)[^>]*>/';
  return preg_replace($pattern, '', $text);
}

// require 'vendor/autoload.php';

//   use Google\Cloud\Scheduler\V1\HttpTarget;
//   use Google\Cloud\Scheduler\V1\CloudSchedulerClient;
//   use Google\Cloud\Scheduler\V1\Job;
//   use Google\Cloud\Scheduler\V1\Job\State;


function Artikel_From_Company(){
  global $wpdb;
  $company = null;
  $table = $wpdb->prefix.'databank';
  // $data = array();

  
  $list_company=[
    'WorkPlace Academy'=>'https://workplaceacademy.nl/',
    'Ynno'=>'https://www.ynno.com/',
    'DeZZP'=>'https://www.dezzp.nl/',
    'Aestate'=>'https://www.aestate.nl/',
    'Alba Concepts'=>'https://albaconcepts.nl/',
    'AM'=>'https://www.am.nl/',
    'Limoonworks'=>'https://limoonworks.nl/',
    // 'DWA'=>'https://www.dwa.nl/',
    'Van Spaendonck'=>'https://www.vanspaendonck.nl/',
    'PTG-advies'=>'https://ptg-advies.nl/',
    'Rever'=>'https://rever.nl/',
    'Reworc'=>'https://www.reworc.com/',
    'Sweco'=>'https://www.sweco.nl/',
    'Co-pilot'=>'https://www.copilot.nl/',
    'Agile Scrum Group'=>'https://agilescrumgroup.nl/',
    'Horizon'=>'https://horizontraining.nl/',
    'Kenneth Smit'=>'https://www.kennethsmit.com/',
    // 'Autoblog'=>'https://www.autoblog.nl/',
    'Crypto university'=>'https://www.cryptouniversity.nl/',
    'WineLife'=>'https://www.winelife.nl/',
    'Perswijn'=>'https://perswijn.nl/',
    'Koken met Kennis'=>'https://www.kokenmetkennis.nl/',
    'Minkowski'=>'https://minkowski.org/',
    'KIT publishers'=>'https://kitpublishers.nl/',
    'BeByBeta'=>'https://www.betastoelen.nl/',
    'Zooi'=>'https://zooi.nl/',
    'Growth Factory'=>'https://www.growthfactory.nl/',
    'Influid'=>'https://influid.nl/',
    'MediaTest'=>'https://mediatest.nl/',
    'MeMo2'=>'https://memo2.nl/',
    'Impact Investor'=>'https://impact-investor.com/',
    'Equalture'=>'https://www.equalture.com/',
    'Zorgmasters'=>'https://zorgmasters.nl/',
    'AdSysco'=>'https://adsysco.nl/',
    'Transport en Logistiek Nederland'=>'https://www.tln.nl/',
    'Financieel Fit'=>'https://www.financieelfit.nl/',
    'Business Insider'=>'https://www.businessinsider.nl/',
    'Frankwatching'=>'https://www.frankwatching.com/',
    'MarTech'=>'https://martech.org/',
    'Search Engine Journal'=>'https://www.searchenginejournal.com/',
    'Search Engine Land'=>'https://searchengineland.com/',
    'TechCrunch'=>'https://techcrunch.com/',
    'The Bruno Effect'=>'https://magazine.thebrunoeffect.com/',
    'Crypto Insiders'=>'https://www.crypto-insiders.nl/',
    'HappyHealth'=> 'https://happyhealthy.nl/',
    'Focus'=>'https://focusmagazine.nl/',
    'Chip Foto Magazine'=> 'https://www.chipfotomagazine.nl/',
    'Vogue'=> 'https://www.vogue.nl/',
    'TrendyStyle'=>'https://www.trendystyle.net/',
    'WWD'=> 'https://wwd.com/',
    'Purse Blog'=> 'https://www.purseblog.com/',
    'Coursera'=> 'https://blog.coursera.org/',
    'Udemy'=> 'https://blog.udemy.com/',
    'CheckPoint'=> 'https://blog.checkpoint.com/',
    'De laatste meter'=> 'https://www.delaatstemeter.nl/',
    'ManagementSite'=> 'https://www.managementpro.nl/',
    '1 Minute Manager'=> 'https://www.1minutemanager.nl/',
    'De Strafschop'=> 'https://www.strafschop.nl/',
    'JongeBazen'=> 'https://www.jongebazen.nl/',
    'Expeditie Duurzaam'=> 'https://www.expeditieduurzaam.nl/',
    'Pure Luxe'=>'https://pureluxe.nl/',
    'WatchTime'=>'https://www.watchtime.com/',
    'Monochrome'=>'https://monochrome-watches.com/',
    'Literair Nederland'=>'https://www.literairnederland.nl/',
    'Tzum'=>'https://www.tzum.info/',
    'Developer'=>'https://www.developer-tech.com/',
    'SD Times'=>'https://sdtimes.com/',
    'GoDaddy'=>'https://www.godaddy.com/garage/',
    'Bouw Wereld'=>'https://www.bouwwereld.nl/',
    'Vastgoed actueel'=>'https://vastgoedactueel.nl/',
    'The Real Deal'=>'https://therealdeal.com/',
    'HousingWire'=>'https://www.housingwire.com/',
    'AfterSales'=>'https://aftersalesmagazine.nl/',
    'CRS Consulting'=>'https://crsconsultants.nl/',
    'Commercial Construction & Renovation'=>'https://www.ccr-mag.com/',
    'Training Magazine'=>'https://www.trainingmag.com/',
    'MedCity News'=>'https://www.medcitynews.com/',
    'Cocktail Enthusiast'=>'https://www.cocktailenthusiast.com/',
    'Mr. Online'=>'https://www.mronline.nl/',
    'Cash'=>'https://www.cash.nl/',
    'Kookles thuis'=>'https://www.kooklesthuis.com/',
    'Mediabistro'=>'https://www.mediabistro.com/',
    'ProBlogger'=>'https://problogger.com/',
    'Media Shift'=>'https://www.mediashift.org/',
    'Warehouse Totaal'=>'https://www.warehousetotaal.nl/',
    'CS digital'=>'https://csdm.online/',
    'Analytics Insight'=>'https://www.analyticsinsight.net/',
    'Wissenraet'=>'https://www.vanspaendonck-wispa.nl/',
    '9to5Mac'=>'https://9to5mac.com/',
    'Invest International'=>'https://investinternational.nl/',
    'Racefiets Blog'=>'https://racefietsblog.nl/',
    'Darts actueel'=>'https://www.dartsactueel.nl/',
    'Hockey.nl'=>'https://hockey.nl/',
    'Hockeykrant'=>'https://hockeykrant.nl/',
    'Tata Nexarc'=>'https://blog.tatanexarc.com/',
    'Incodocs'=>'https://incodocs.com/blog/',
    'Recruitement Tech'=>'https://www.recruitmenttech.nl/',
    'Healthcare Weekly'=>'https://healthcareweekly.com/',
    'Wellness Mama'=>'https://wellnessmama.com/',
    'Logistics Business'=>'https://www.logisticsbusiness.com/',
    '20Cube'=>'https://www.20cube.com/',
    'Outside'=>'https://velo.outsideonline.com/',
    'Trainer Road'=>'https://www.trainerroad.com/blog/',
    'AllOver Media'=>'https://allovermedia.com/',
    'The Partially Examined Life'=>'https://partiallyexaminedlife.com/',
    'The Future Organization'=>'https://thefutureorganization.com/'
  ];
  
  $users = get_users();

  $data = array();

  $args = array(
      'post_type' => 'company', 
      'posts_per_page' => -1,
  );
  $companies = get_posts($args);
  foreach ($list_company as $key => $website) {
    $author_id=null;
      foreach($companies as $companie){       
        if(strtolower($companie->post_title) == strtolower($key)){
          $company = $companie;
        }else
          continue;

        foreach($users as $user) {
          $company_user = get_field('company',  'user_' . $user->ID);

          if(isset($company_user[0]->post_title)) 
            if(strtolower($company_user[0]->post_title) == strtolower($key) ){
              $author_id = $user->ID;
              $company = $company_user[0];
              $company_id = $company_user[0]->ID;
            }
        }
      }

      if(!$author_id)
      {
        $login = 'user'.random_int(0,100000);
        $password = "pass".random_int(0,100000);
        $email = "author_" . $key . "@" . 'livelearn' . ".nl";
        $first_name = explode(' ', $key)[0];
        $last_name = isset(explode(' ', $key)[1])?explode(' ', $key)[1]:'';

        $userdata = array(
          'user_pass' => $password,
          'user_login' => $login,
          'user_email' => $email,
          'user_url' => 'https://livelearn.nl/inloggen/',
          'display_name' => $first_name,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'role' => 'author' 
        );

        $author_id = wp_insert_user(wp_slash($userdata));       
      }

      //Accord the author a company
      if(!is_wp_error($author_id))
        update_field('company', $company, 'user_' . $author_id);

      $span  = $website . "wp-json/wp/v2/posts/";
      $artikels= json_decode(file_get_contents($span),true);
      foreach($artikels as $article){

         
            // $onderwerpen = trim($onderwerpen);
        
            if ($article!=null) {
              $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s",array($article['title']['rendered'],'Artikel'));
              $result_title = $wpdb->get_results($sql_title);
              if($article['featured_media']!=0){
                $span2 = $website."wp-json/wp/v2/media/".$article['featured_media'];          
                $images=json_decode(file_get_contents($span2),true);
                $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images['guid']['rendered'], 'Artikel'));
                $result_image = $wpdb->get_results($sql_image);
                if(!isset($result_image[0]) && !isset($result_title[0]))
                {
                  if (!isset($images['data']['status']) && $images['data']['status']!=404 && $images['data']['status']!=401) {
                    $status = 'extern';
                    $data = array(
                      'titel' => $article['title']['rendered'],
                      'type' => 'Artikel',
                      'videos' => NULL, 
                      'short_description' => $article['excerpt']['rendered'],
                      'long_description' => htmlspecialchars(strip_tags($article['content']['rendered'])),
                      'duration' => NULL, 
                      'prijs' => 0, 
                      'prijs_vat' => 0,
                      'image_xml' => $images['guid']['rendered'], 
                      'onderwerpen' => $onderwerpen, 
                      'date_multiple' =>  NULL, 
                      'course_id' => null,
                      'author_id' => $author_id,
                      'company_id' =>  $company_id,
                      'contributors' => null, 
                      'status' => $status
                    );
                  }else {
                    $status = 'extern';
                    $data = array(
                      'titel' => $article['title']['rendered'],
                      'type' => 'Artikel',
                      'videos' => NULL, 
                      'short_description' => $article['excerpt']['rendered'],
                      'long_description' => htmlspecialchars(strip_tags($article['content']['rendered'])),
                      'duration' => NULL, 
                      'prijs' => 0, 
                      'prijs_vat' => 0,
                      'image_xml' => null, 
                      'onderwerpen' => $onderwerpen, 
                      'date_multiple' =>  NULL, 
                      'course_id' => null,
                      'author_id' => $author_id,
                      'company_id' =>  $company_id,
                      'contributors' => null, 
                      'status' => $status
                    );
                  }
                }
              }else{
                if(!isset($result_title[0]) )
                {
                  $status = 'extern';
                  $data = array(
                    'titel' => $article['title']['rendered'],
                    'type' => 'Artikel',
                    'videos' => NULL, 
                    'short_description' => $article['excerpt']['rendered'],
                    'long_description' => htmlspecialchars(strip_tags($article['content']['rendered'])),
                    'duration' => NULL,
                    'prijs' => 0,
                    'prijs_vat' => 0,
                    'image_xml' => null,
                    'onderwerpen' => $onderwerpen,
                    'date_multiple' =>  NULL,
                    'course_id' => null,
                    'author_id' => $author_id,
                    'company_id' =>  $company_id,
                    'contributors' => null,
                    'status' => $status
                  );
                }
              }
              // echo "Selected option: $text (value=$value)<br>";
              try
              {
                $wpdb->insert($table,$data);
                // echo $key."  ".$wpdb->last_error."<br>";
                $id_post = $wpdb->insert_id;
                // var_dump($data);
              }catch(Exception $e) {
                echo $e->getMessage();
              }
            }
      }
  }
}
