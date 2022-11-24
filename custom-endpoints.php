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
  public   $course_type;
  public   $data_locaties_xml;
  public   $youtubeVideos;
  public $author;

  function __construct($course) {
     $this->id = $course->ID;
     $this->date = $course->post_date;
     $this->title = $course->post_title;
     $this->pathImage = $course->pathImage;
     $this->shortDescription = $course->shortDescription;
     $this->longDescription = $course->longDescription;
     $this->price = $course->price;
     $this->tags = $course->tags;
     $this->course_type = $course->course_type;
     $this->data_locaties_xml = $course->data_locaties_xml;
     $this->youtubeVideos = $course->youtubeVideos;
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
    $outcome_courses = array();
    $tags = array();
    $author = array();
    $args = array(
        'post_type' => array('course'), 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC'
    );
    $courses = get_posts($args);
    if (!$courses)
      return ['error' => "There is no courses in the database! ","codeStatus" => 400];
      
    if (!isset ($data['page']) ) 
      $page = 1;  
    else   
      $page = $data['page'];

  $results_per_page = 100;  
  $start = ($page-1) * $results_per_page;
  $end = ($page) * $results_per_page;
  if(!empty($courses))
    $number_of_post = count($courses);

  $number_of_page = ceil($number_of_post / $results_per_page);

  if($number_of_page < $data['page'])
    return ['error' => "Page doesn't exist ! ","codeStatus" => 400];  

  for($i=$start; $i < $end ;  $i++) {
      $courses[$i]->author = array();
      $experts = get_field('experts',$courses[$i]->ID);
      if(!empty($experts))
        foreach (get_field('experts',$courses[$i]->ID) as $key => $value) {
          $author = get_user_by('ID',$value);
          array_push($courses[$i]->author, new Author ($author, wp_get_attachment_url(get_field('profile_img',$author->ID))));
          }
      $courses[$i]->long_description = get_field('long_description',$courses[$i]->ID);
      $courses[$i]->short_description = get_field('short_description',$courses[$i]->ID);
      $courses[$i]->course_type = get_field('course_type',$courses[$i]->ID);
      $courses[$i]->url_image_xml = get_field('url_image_xml',$courses[$i]->ID);
      $courses[$i]->price = get_field('price',$courses[$i]->ID);
      $courses[$i]->youtube_videos = get_field('youtube_videos',$courses[$i]->ID);
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
        $author = new Author($author_post, wp_get_attachment_url($author_post->profile_img));
        array_push($authors,$author);
      }
    return ['authors' => $authors,"codeStatus" => 200];;
}


  function related_topics_subtopics ($data){
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

    if($request['meta_value'] == null || $request['meta_key'] == null){
        $informations['error'] = 'Please fill the values of the metadata !';
        return $informations; 
    }

    $subtopics = $request['meta_value'];

    foreach ($subtopics as $key => $subtopic) {
      $category = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'include' => (int)$subtopic,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
      ) );

      if(!isset($category[0]) && !get_user_by('ID', $subtopic)){
          $informations['error'] = 'Please fill correctly the value of the metadata !';
          return $informations;
      }
      $meta_data = get_user_meta($user_id, $request['meta_key']);
      if(!in_array($subtopic, $meta_data))
      {
          add_user_meta($user_id, $request['meta_key'], $subtopic);
          $informations['success'] = 'Subscribed successfully !';
      }else{
          delete_user_meta($user_id, $request['meta_key'], $subtopic);
          $informations['success'] = 'Unsubscribed successfully !';
      }
  }
  return $informations; 
}
