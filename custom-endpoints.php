<?php

class Author
{
 public  $id;
 public   $name;
 public  $profilImg;

 function __construct($author,$profilImg) {
    $this->id=(int)$author->ID;
    $this->name=$author->display_name;
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
  public $author;
  public $visibility;
  public $podcasts;

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
     $this->author = $course->author;
     $this->visibility = $course->visibility;
     $this->podcasts = $course->podcasts;
     $this->connectedProduct = $course->connectedProduct;
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
    $author = array();
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
      $courses[$i]->author = array();
      $experts = get_field('experts',$courses[$i]->ID);
      if(!empty($experts))
        foreach ($experts as $key => $expert) {
          $expert = get_user_by( 'ID', $expert );
           return $expert;
          $author_img = wp_get_attachment_url(get_field('profile_img',(int)$expert)); //? wp_get_attachment_url(get_field('profile_img',$author->ID)) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          array_push($courses[$i]->author, new Author ($author,$author_img));
          }
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
      foreach ($authors_post as $key => $author_post) {
        $author_img = wp_get_attachment_url(get_field('profile_img',$author_post->ID)) ? wp_get_attachment_url(get_field('profile_img',$author_post->ID)) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $author = new Author($author_post, $author_img);
        array_push($authors,$author);
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
    $user_id = get_current_user_id();
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
