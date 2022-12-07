<?php
$GLOBALS['user_id'] = get_current_user_id();
class Expert
{
 public  $id;
 public   $name;
 public  $profilImg;

 function __construct($expert,$profilImg) {
    $this->id=(int)$expert->ID;
    $this->name=$expert->display_name;
    $this->profilImg =$profilImg;
  }

}

class Course
{
  public   $id;
  public   $date;
  public   $title;
  public   $pathImage;
  public   $shortDescription;
  public   $longDescription;
  public      $price;
  public   $tags;
  public   $courseType;
  public   $data_locaties_xml;
  public   $youtubeVideos;
  public $experts;
  public $visibility;
  public $podcasts;

  public $author;

  public $connectedProduct;

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
     $this->visibility = $course->visibility;
     $this->podcasts = $course->podcasts;
     $this->connectedProduct = $course->connectedProduct;
     $this->author = $course->author;
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
    $course_type = $_GET['course_type'];
    $outcome_courses = array();
    $tags = array();
    $experts = array();
    $args = array(
        'post_type' => array('course'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
         'meta_key'         => 'course_type',
         'meta_value'       => $course_type,
    );
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
  
  for($i=$start; $i < $end ;  $i++) {
   // return get_user_by('ID',9);  
      $courses[$i]->experts = array();
      $experts = get_field('experts',$courses[$i]->ID);
      if(!empty($experts))
        foreach ($experts as $key => $expert) {
          $expert = get_user_by( 'ID', $expert );
          $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          array_push($courses[$i]->experts, new Expert ($expert,$experts_img));
          }
      $author = get_user_by( 'ID', $courses[$i] -> post_author  );
      $author_img = get_field('profile_img','user_'.$author ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      $courses[$i]-> author = new Expert ($author , $author_img);
      $courses[$i]->longDescription = get_field('long_description',$courses[$i]->ID);
      $courses[$i]->shortDescription = get_field('short_description',$courses[$i]->ID);
      $courses[$i]->courseType = get_field('course_type',$courses[$i]->ID);
      $courses[$i]->pathImage = get_field('url_image_xml',$courses[$i]->ID);
      $courses[$i]->price = get_field('price',$courses[$i]->ID);
      $courses[$i]->youtubeVideos = get_field('youtube_videos',$courses[$i]->ID) ? get_field('youtube_videos',$courses[$i]->ID) : []  ;
      $courses[$i]->podcasts = get_field('podcasts',$courses[$i]->ID) ? get_field('podcasts',$courses[$i]->ID) : [];
      $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID);
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


  function related_topics_subtopics ($data)
  {
    $id_topics = $data['id'];
    $subtopics = get_categories( array(
      'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
      'parent' => (int)$id_topics,
      'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ));
    if (!$subtopics)
      return ['error' => 'Either the given id does not match any topic, or the topic is not linked to any subtopic'];
   return ['subtopics' => $subtopics,"codeStatus" => 200];;
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
  $expert_id = $data['id'] ?? null;
  if (!isset($expert_id))
    return ['error' => "You have to fill the id of the expert" ];
  $expert = get_user_by('ID', $expert_id );
  $courses = get_posts(array(
        'post_type' => array('course'), 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        // 'meta_key'         => 'course_type',
        // 'meta_value'       => $course_type,
  ));
  $expert_courses = array();
    foreach ($courses as $key => $course) {
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

function get_total_followers ($data) {
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
  // $saved_course = get_user_meta('saved',9);
  // return get_posts(
  //     $args = array(
  //       'post_type' => 'course',
  //       'post__in' => [2070],
  //   ));
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
            'post_type' => array('course'), 
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'include' => $course_saved
        ));
    $outcome_courses = array();

        foreach ($courses as $key => $course) {
          $course->experts = array();
          $experts = get_field('experts',$course->ID);
          if(!empty($experts))
            foreach ($experts as $key => $expert) {
              $expert = get_user_by( 'ID', $expert );
              $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($course->experts, new Expert ($expert,$experts_img));
              }
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
              
          $new_course = new Course($course);
          array_push($outcome_courses, $new_course);
        }
        return ['saved_courses' => $outcome_courses,"codeStatus" => 200];
  }
  return [];
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
            foreach ($experts as $key => $expert) {
              $expert = get_user_by( 'ID', $expert );
              $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($course->experts, new Expert ($expert,$experts_img));
              }
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
              
          return new Course($course);
    }
    return ['error' => 'This course doesn\'t exist in this database'];
     
  }
  return ['error' => 'You have to fill the id of the course'];
}

function get_liked_courses()
{
  $user_id = $GLOBALS['user_id'];
  return $user_id;
}