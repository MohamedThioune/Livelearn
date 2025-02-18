<?php

$GLOBALS['user_id'] = get_current_user_id() ;
require_once ABSPATH.'wp-admin'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'user.php';
$GLOBALS['user_id'] = get_current_user_id();

/** **************** Class **************** */
 
class Expert
{
  public $id;
  public $name;
  public $profilImg;
  public $company;
  public $role;
  public $is_followed;

  function __construct($expert,$profilImg) {
    
    $this->id=(int)$expert->ID;
    $this->name=$expert->display_name;
    $this->profilImg =$profilImg;
    $this->is_followed =$expert->is_followed ?? false;
    $this->company = get_field('company', 'user_' . (int)$expert->ID)[0] ?? null;
    $this->role = get_field('role', 'user_' . (int)$expert->ID) ?? '';
  }

}

class Course
{
  public $id;
  public $date;
  public $title;
  public $slug;
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
  public $language;

  function __construct($course) {
    $this->id = $course->ID;
    $this->date = $course->post_date;
    $this->title = $course->post_title;
    $this->slug = $course->post_name;
    $this->pathImage = $course->pathImage;
    $this->shortDescription = $course->shortDescription;
    $this->longDescription = $course->longDescription;
    $this->price = $course->price ?? 0;
    $this->language = $course->language ?? "";
    $this->tags = $course->tags;
    $this->courseType = $course->courseType;
    $this->data_locaties_xml = $course->data_locaties_xml;
    $this->youtubeVideos = $course->youtubeVideos ?? [];
    $this->experts = $course->experts;
    $this->visibility = $course->visibility ?? null;
    $this->links = $course->guid;
    $this->podcasts = $course->podcasts ?? [];
    $this->connectedProduct = $course->connectedProduct;
    $this->author = $course->author;
    $this->articleItself = get_field('article_itself', $course->ID) ?? '';
    $this->likes = is_array(get_field('favorited', $course->ID)) ? count(get_field('favorited', $course->ID)) : 0 ;
    $this->data_locaties = is_array(get_field('data_locaties', $course->ID)) ? (get_field('data_locaties', $course->ID)) : [] ;
    $this->for_who = get_field('for_who', $course->ID) ? (get_field('for_who', $course->ID)) : "" ;
  }
  
}

class CourseOptimized
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
  //public $podcasts;
  //public $likes;
  public $author;
  public $articleItself;
  public $connectedProduct;
  public $for_who;
  public $data_locaties;
  public $links;
  public $language;

  function __construct($course, bool $isVideoDisplayed = false) {
    $this->id = $course->ID;
    $this->date = $course->post_date;
    $this->title = $course->post_title;
    $this->pathImage = $course->pathImage;
    $this->shortDescription = $course->shortDescription;
    $this->longDescription = $course->longDescription;
    $this->price = $course->price ?? 0;
    $this->language = $course->language ?? "";
    $this->tags = $course->tags;
    $this->courseType = $course->courseType;
    $this->data_locaties_xml = $course->data_locaties_xml;
    $this->youtubeVideos = $isVideoDisplayed ? ($course->youtubeVideos ?? []) : [];
    $this->experts = $course->experts;
    $this->visibility = $course->visibility ?? null;
    $this->links = $course->guid;
    //$this->podcasts = $course->podcasts ?? [];
    $this->connectedProduct = $course->connectedProduct;
    $this->author = $course->author;
    $this->articleItself = $course->articleItself;
    //$this->likes = is_array(get_field('favorited', $course->ID)) ? count(get_field('favorited', $course->ID)) : 0 ;
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


// function sendFirebasePushNotification(WP_REST_Request $request) {
//   $title = $request['title'] ?? "";
//   $body = $request['body'] ?? "";
//   $current_user_id = $GLOBALS['user_id'];
//   $data = $request['data'] ?? [];
//   return sendNotificationToUser($current_user_id,$title,$body,$data);
// }

// function sendNotificationToUser($userId, $title, $body, $data = []) {
//   // Vérifier que l'utilisateur est connecté
//   if (!$userId) {
//       return new WP_Error('user_not_logged_in', 'You have to provide the user id!', ['status' => 401]);
//   }

//   // Récupérer le token de l'utilisateur
//   $token = get_field('smartphone_token', 'user_' . $userId);
//   if (!$token) {
//       return new WP_Error('token_not_found', 'FCM Token not found!', ['status' => 404]);
//   }

//   // Clé serveur Firebase
//   $serverKey = "Bearer AAAAurXExgE:APA91bEVVmb3m7BcwiW6drSOJGS6pVASAReDwrsJueA0_0CulTu3i23azmOTP2TcEhUf-5H7yPzC9Wp9YSHhU3BGZbNszpzXOXWIH1M6bbjWyloBrGxmpIxHIQO6O3ep7orcIsIPV05p";

//   // Préparer les données de la notification
//   $notificationData = [
//       'to' => $token,
//       'notification' => [
//           'title' => $title,
//           'body' => $body,
//       ],
//   ];

//   // Ajout données supplémentaires facultatives 
//   if (!empty($data)) {
//       $notificationData['data'] = $data; // Doit être un tableau associatif
//   }

//   $dataString = json_encode($notificationData);

  
//   $headers = [
//       'Authorization: ' . $serverKey,
//       'Content-Type: application/json',
//   ];

//   // URL de l'API FCM
//   $url = 'https://fcm.googleapis.com/fcm/send';

//   // Initialiser CURL
//   $ch = curl_init();
//   curl_setopt($ch, CURLOPT_URL, $url);
//   curl_setopt($ch, CURLOPT_POST, true);
//   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

//   // Exécuter la requête
//   $response = curl_exec($ch);

//   // Vérification des erreurs CURL
//   if ($response === false) {
//       $error_msg = curl_error($ch);
//       curl_close($ch);
//       return new WP_Error('curl_error', 'Error CURL : ' . $error_msg, ['status' => 500]);
//   }

//   // Vérification du code de réponse HTTP
//   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//   curl_close($ch);

//   if ($httpCode >= 200 && $httpCode < 300) {
//       // Succès
//       return json_decode($response, true);
//   } else {
//       // Erreur de l'API Firebase
//       return new WP_Error(
//           'firebase_error',
//           'Erreur lors de l\'envoi de la notification. Code HTTP : ' . $httpCode,
//           [
//               'status' => $httpCode,
//               'response' => json_decode($response, true)
//           ]
//       );
//   }
// }


function sendPushNotificationFirebase(WP_REST_Request $request) {
  // Chemin vers le fichier JSON de la clé de service Firebase
  $serviceAccountFile = __DIR__ . '/livelearn-359911-firebase-adminsdk-bvksx-79bfac62fc.json';
  
  // Titre, corps et données de la notification depuis la requête
  $title = $request['title'] ?? 'Test';
  $body = $request['body'] ?? 'Test';
  $data = $request['data'] ?? [];
  
  // Récupérer l'ID de l'utilisateur actuel
  $current_user_id = get_current_user_id();
  if (!$current_user_id) {
      return new WP_Error('user_not_logged_in', 'Utilisateur non connecté.', ['status' => 401]);
  }

  // Récupérer le token de l'utilisateur
  $deviceToken = get_field('smartphone_token', 'user_' . $current_user_id);
  if (!$deviceToken) {
      return new WP_Error('token_not_found', 'Token non trouvé pour l\'utilisateur.', ['status' => 404]);
  }

  // Charger le fichier JSON de la clé de service
  if (!file_exists($serviceAccountFile)) {
      return new WP_Error('service_account_missing', 'Fichier de clé de service introuvable.', ['status' => 500]);
  }

  $jwt = json_decode(file_get_contents($serviceAccountFile), true);
  $clientEmail = $jwt['client_email'];
  $privateKey = $jwt['private_key'];

  // Génération du JWT pour l'authentification
  $nowSeconds = time();
  $token = [
      "iss" => $clientEmail,
      "sub" => $clientEmail,
      "aud" => "https://oauth2.googleapis.com/token",
      "iat" => $nowSeconds,
      "exp" => $nowSeconds + 3600,
      "scope" => "https://www.googleapis.com/auth/firebase.messaging"
  ];

  $header = base64_encode(json_encode(["alg" => "RS256", "typ" => "JWT"]));
  $payload = base64_encode(json_encode($token));
  $headerPayload = "$header.$payload";
  openssl_sign($headerPayload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
  $jwtToken = "$headerPayload." . base64_encode($signature);

  // Obtenir un jeton d'accès OAuth 2
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
      "grant_type" => "urn:ietf:params:oauth:grant-type:jwt-bearer",
      "assertion" => $jwtToken,
  ]));

  $response = curl_exec($ch);
  if (curl_errno($ch)) {
      return new WP_Error('curl_error', curl_error($ch), ['status' => 500]);
  }
  curl_close($ch);

  $responseArray = json_decode($response, true);
  if (isset($responseArray['error'])) {
      return new WP_Error('auth_error', $responseArray['error']['message'], ['status' => 401]);
  }

  $accessToken = $responseArray['access_token'] ?? null;
  if (!$accessToken) {
      return new WP_Error('access_token_error', 'Jeton d\'accès introuvable.', ['status' => 401]);
  }

  // Préparer la requête à l'API FCM
  $url = "https://fcm.googleapis.com/v1/projects/livelearn-359911/messages:send";
  $payload = [
      "message" => [
          "token" => $deviceToken,
          "notification" => [
              "title" => $title,
              "body" => $body,
          ],
          "data" => $data ?? ['test'=>'test'],
      ],
  ];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Authorization: Bearer $accessToken",
      "Content-Type: application/json",
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

  $result = curl_exec($ch);
  if (curl_errno($ch)) {
      return new WP_Error('curl_error', curl_error($ch), ['status' => 500]);
  }
  curl_close($ch);

  $resultArray = json_decode($result, true);
  if (isset($resultArray['error'])) {
      return new WP_Error('fcm_error', $resultArray['error']['message'], ['status' => 500]);
  }

  return rest_ensure_response(['success' => true, 'response' => $resultArray]);
}

/** **************** Api Custom Endpoints **************** */

/**
 * Expert Endpoints
 */
function allAuthors()
{
  $authors_post = get_users(
    array(
      'role__in' => ['author','admin'],
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

function allAuthorsOptimized()
{
  $authors_post = get_users(
    array(
      'role__in' => ['author','admin'],
      'posts_per_page' => -1,
      )
    );
    if (!$authors_post)
      return ['error' => 'There is no authors in the database',"codeStatus" => 400];
  
    $authors = array();
    $current_user = $GLOBALS['user_id'];
    $experts_followed = get_user_meta($current_user, 'expert') != false ? get_user_meta($current_user, 'expert') : [];
    if(!empty($authors_post))
      foreach ($authors_post as $key => $experts_post) {
        
        $experts_post->is_followed = in_array($experts_post->ID,$experts_followed);
        $experts_img = get_field('profile_img','user_'.$experts_post->ID) ? get_field('profile_img','user_'.$experts_post->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $experts = new Expert($experts_post, $experts_img);
        array_push($authors,$experts);
      }
    return ['authors' => $authors, "codeStatus" => 200];
}

function get_expert_courses ($data) 
{
  $current_user_id = $GLOBALS['user_id'];
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
  $expert_id = $data['id'] ?? null;
  if (!isset($expert_id))
    return ['error' => "You have to fill the id of the expert" ];
  $expert = get_user_by('ID', $expert_id );
  $courses = get_posts(
    array(
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
        $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

function getExpertCourseOptimized  ($data) 
{
  $current_user_id = $GLOBALS['user_id'];
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
  $expert_id = $data['id'] ?? null;
  if (!isset($expert_id))
    return ['error' => "You have to fill the id of the expert" ];
  $expert = get_user_by('ID', $expert_id );
  $courses = get_posts(
    array(
        'post_type' => array('course', 'post'), 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'author'        => $expert->ID
  ));
  $expert_courses = array();
    foreach ($courses as $key => $course) {
      $course->visibility = get_field('visibility',$course->ID) ?? [];
      $author = get_user_by( 'ID', $course -> post_author  );
      $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
      if ($course->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
        $author = get_user_by( 'ID', $course -> post_author  );
        $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

              // /**
              //  * Handle Image exception
              //  */
              // $handle = curl_init($course->pathImage);
              // curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

              // /* Get the HTML or whatever is linked in $url. */
              // $response = curl_exec($handle);

              // /* Check for 404 (file not found). */
              // $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
              // if($httpCode != 200) {
              //     /* Handle 404 here. */
              //     $course->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
              //   }
              // curl_close($handle);
        array_push($expert_courses,new Course($course));
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

function detailCategory($categoryID, $userID = null){

  //Category ID 
  if(!$categoryID)
    return false;

  //Topic is followed by the user
  $is_followed = false;
  $topics = [];
  $topics_external = [];
  $topics_internal = [];
  if($userID):
    $topics_external = get_user_meta($userID, 'topic');
    $topics_internal = get_user_meta($userID, 'topic_affiliate');
    $topics = array_merge($topics_external, $topics_internal);
  endif;
  $is_followed = (in_array($categoryID, $topics)) ? true : false;

  //Initialization
  $sample = array();

  //Name + Slug 
  $categories = get_categories( array(
    'taxonomy' => 'course_category',
    'orderby'    => 'name',
    'include' => $categoryID,
    'hide_empty' => 0
    ) 
  );
  $param_category = (isset($categories[0])) ? $categories[0] : 0;

  if(!$param_category)
    return 0;
  
  $sample['ID'] = $categoryID ;
  $sample['name'] = $param_category->name ;
  $sample['slug'] = $param_category->slug ;
  $sample['image'] = get_field('image', 'category_'. $categoryID) ?: get_stylesheet_directory_uri() . '/img/iconOnderverpen.png' ;
  $sample['parent'] = $param_category->category_parent;
  $sample['is_followed'] = $is_followed;

  return (Object)$sample;  
}

function related_topics_subtopics(WP_REST_Request $request)
{
  $id_topics = $request['meta_value'] ?? [];

  //Get category information
  $category = detailCategory($id_topics[0]);

  //Get sub topics
  if ($id_topics != []) 
  {
    $all_subtopics = array();
    foreach ($id_topics as $key => $id_topic) {
      $subtopics = get_categories( array(
        'taxonomy'   => 'course_category',
        'parent' => (int)$id_topic,
        'hide_empty' => false,
      )) ?? false;

      if ($subtopics != false)
        $all_subtopics = array_merge($all_subtopics,$subtopics);
    }
    return ['category' => $category, 'subtopics' => $all_subtopics, "codeStatus" => 200];
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
 * Current User endp oints
 */
function get_total_followed_experts()
{
  $current_user = $GLOBALS['user_id'];
  $count = 0;
  $experts_followed = get_user_meta($current_user, 'expert') != false ? get_user_meta($current_user, 'expert') : [];
  if (!empty($experts_followed)) {
    $experts = new stdClass;
    $experts -> experts = [];
    foreach ($experts_followed as $key => $expert_followed) 
    {
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
  $results_per_page = 15;
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

function allCoursesOptimized($data)
{
  $current_user_id = $GLOBALS['user_id'];
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
  $course_type = ucfirst(strtolower($_GET['course_type']));
  $outcome_courses = array();
  $tags = array();
  $experts = array();
  $args = array(
    'post_type' => array('course'),
    'post_status' => 'publish',
    'posts_per_page' => 15,
    'ordevalue'       => $course_type,
    'order' => 'DESC' ,
    'meta_key'         => 'course_type',
    'paged' => $data['page'] ?? 1,
    'meta_value' => $course_type);
    
  $courses = get_posts($args);
  if (!$courses)
    return ["courses" => [],'message' => "There is no courses related to this course type in the database! ","codeStatus" => 400];

for($i=0; $i < count($courses) ;  $i++) 
{
    $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
    $author = get_user_by( 'ID', $courses[$i] -> post_author  );
    $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
    if ($courses[$i]->visibility != []) 
      if ($author_company != $current_user_company)
        continue;
        $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
        $new_course = new Course($courses[$i]);
        array_push($outcome_courses, $new_course);
  }
 return ['courses' => $outcome_courses, "codeStatus" => 200];
}

  
function allCoursesOptimizedWithFilter($data)
{
    $current_user_id = $GLOBALS['user_id'];
    if (!$current_user_id) 
      {
          $response = new WP_REST_Response("You have to login with valid credentials!");
          $response->set_status(400);
          return $response;
      }
    $course_type = ucfirst(strtolower($data['course_type'] ?? ''));
    $outcome_courses = array();
    $tags = array();
    $experts = array();
    $languages =  get_field('language_preferences','user_' . (int) $current_user_id) ?? [];
    // $languages = $data['languages'] ?? '';

    // if (!is_array($languages)) {
    //     $languages = explode(',', $languages); // Convert to array if it's a string
    // }

    $args = array(
        'post_type' => array('course'),
        'post_status' => 'publish',
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => 
        count($languages) != 0 
        ? 
          array(
              'relation' => 'AND',
              array(
                  'key' => 'language',
                  'value' => $languages,
                  'compare' => 'IN'
              ),
              array(
                  'key' => 'course_type',
                  'value' => $course_type,
                  'compare' => 'LIKE'
              )
          ) 
          : 
          array(
            array(
              'key' => 'course_type',
              'value' => $course_type,
              'compare' => 'LIKE'
            )
            ),
        'paged' => $data['page'] ?? 1,
    );

    $courses = get_posts($args);
    if (!$courses) {
        return ["courses" => [], 'message' => "There is no courses related to this course type in the database!", "codeStatus" => 400];
    }

    for ($i = 0; $i < count($courses); $i++) {
        $courses[$i]->visibility = get_field('visibility', $courses[$i]->ID) ?? [];
        $author = get_user_by('ID', $courses[$i]->post_author);
        $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
        if ($courses[$i]->visibility != []) {
            if ($author_company != $current_user_company) continue;
        }
        $author_img = get_field('profile_img', 'user_' . $author->ID) ? get_field('profile_img', 'user_' . $author->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $courses[$i]->experts = array();
        $experts = get_field('experts', $courses[$i]->ID);
        if (!empty($experts)) {
            foreach ($experts as $key => $expert) {
                $expert = get_user_by('ID', $expert);
                $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                array_push($courses[$i]->experts, new Expert($expert, $experts_img));
            }
        }

        $courses[$i]->author = new Expert($author, $author_img);
        $courses[$i]->longDescription = get_field('long_description', $courses[$i]->ID);
        $courses[$i]->shortDescription = get_field('short_description', $courses[$i]->ID);
        $courses[$i]->courseType = get_field('course_type', $courses[$i]->ID);

        $image = get_field('preview', $courses[$i]->ID)['url'];
        if (!$image) {
            $image = get_the_post_thumbnail_url($courses[$i]->ID);
            if (!$image) $image = get_field('url_image_xml', $courses[$i]->ID);
            if (!$image) $image = get_stylesheet_directory_uri() . '/img/' . strtolower($courses[$i]->courseType) . '.jpg';
        }
        $courses[$i]->pathImage = $image;
        $courses[$i]->price = get_field('price', $courses[$i]->ID) ?? 0;
        $courses[$i]->language = get_field('language', $courses[$i]->ID) ?? "";
        $courses[$i]->youtubeVideos = get_field('youtube_videos', $courses[$i]->ID) ? get_field('youtube_videos', $courses[$i]->ID) : [];
        if (strtolower($courses[$i]->courseType) == 'podcast') {
            $podcasts = get_field('podcasts', $courses[$i]->ID) ? get_field('podcasts', $courses[$i]->ID) : [];
            if (!empty($podcasts)) {
                $courses[$i]->podcasts = $podcasts;
            } else {
                $podcasts = get_field('podcasts_index', $courses[$i]->ID) ? get_field('podcasts_index', $courses[$i]->ID) : [];
                if (!empty($podcasts)) {
                    $courses[$i]->podcasts = array();
                    foreach ($podcasts as $key => $podcast) {
                        $item = array(
                            "course_podcast_title" => $podcast['podcast_title'],
                            "course_podcast_intro" => $podcast['podcast_description'],
                            "course_podcast_url" => $podcast['podcast_url'],
                            "course_podcast_image" => $podcast['podcast_image'],
                        );
                        array_push($courses[$i]->podcasts, ($item));
                    }
                }
            }
        }
        $courses[$i]->podcasts = $courses[$i]->podcasts ?? [];
        $courses[$i]->connectedProduct = get_field('connected_product', $courses[$i]->ID);
        $tags = get_field('categories', $courses[$i]->ID) ?? [];
        $courses[$i]->tags = array();
        if ($tags) {
            if (!empty($tags)) {
                foreach ($tags as $key => $category) {
                    if (isset($category['value'])) {
                        $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
                        array_push($courses[$i]->tags, $tag);
                    }
                }
            }
        }
        $new_course = new Course($courses[$i]);
        array_push($outcome_courses, $new_course);
    }
    return ['courses' => $outcome_courses, "codeStatus" => 200];
}

function allCoursesOptimizedWithJustPreviewAndFilter($data)
{
    $current_user_id = $GLOBALS['user_id'];
    if (!$current_user_id) 
      {
          $response = new WP_REST_Response("You have to login with valid credentials!");
          $response->set_status(400);
          return $response;
      }
    $course_type = ucfirst(strtolower($data['course_type'] ?? ''));
    $outcome_courses = array();
    $tags = array();
    $experts = array();
    $languages =  get_field('language_preferences','user_' . (int) $current_user_id) ?? [];
    // $languages = $data['languages'] ?? '';

    // if (!is_array($languages)) {
    //     $languages = explode(',', $languages); // Convert to array if it's a string
    // }

    $args = array(
        'post_type' => array('course'),
        'post_status' => 'publish',
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => 
        count($languages) != 0 
        ? 
          array(
              'relation' => 'AND',
              array(
                  'key' => 'language',
                  'value' => $languages,
                  'compare' => 'IN'
              ),
              array(
                  'key' => 'course_type',
                  'value' => $course_type,
                  'compare' => 'LIKE'
              )
          ) 
          : 
          array(
            array(
              'key' => 'course_type',
              'value' => $course_type,
              'compare' => 'LIKE'
            )
            ),
        'paged' => $data['page'] ?? 1,
    );

    $courses = get_posts($args);
    if (!$courses) {
        return ["courses" => [], 'message' => "There is no courses related to this course type in the database!", "codeStatus" => 400];
    }

    for ($i = 0; $i < count($courses); $i++) {
        $courses[$i]->visibility = get_field('visibility', $courses[$i]->ID) ?? [];
        $author = get_user_by('ID', $courses[$i]->post_author);
        $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
        if ($courses[$i]->visibility != []) {
            if ($author_company != $current_user_company) continue;
        }
        $author_img = get_field('profile_img', 'user_' . $author->ID) ? get_field('profile_img', 'user_' . $author->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $courses[$i]->experts = array();
        $experts = get_field('experts', $courses[$i]->ID);
        if (!empty($experts)) {
            foreach ($experts as $key => $expert) {
                $expert = get_user_by('ID', $expert);
                $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                array_push($courses[$i]->experts, new Expert($expert, $experts_img));
            }
        }

        $courses[$i]->author = new Expert($author, $author_img);
        $courses[$i]->longDescription = get_field('long_description', $courses[$i]->ID);
        $courses[$i]->shortDescription = get_field('short_description', $courses[$i]->ID);
        $courses[$i]->articleItself = get_field('article_itself', $courses[$i]->ID) ?? '';
        $courses[$i]->data_locaties = is_array(get_field('data_locaties', $courses[$i]->ID)) ? (get_field('data_locaties', $courses[$i]->ID)) : [] ;
        $courses[$i]->courseType = get_field('course_type', $courses[$i]->ID);
        $image = get_field('preview', $courses[$i]->ID)['url'];
        if (!$image) {
            $image = get_the_post_thumbnail_url($courses[$i]->ID);
            if (!$image) $image = get_field('url_image_xml', $courses[$i]->ID);
            if (!$image) $image = get_stylesheet_directory_uri() . '/img/' . strtolower($courses[$i]->courseType) . '.jpg';
        }
        $courses[$i]->pathImage = $image;
        $courses[$i]->price = get_field('price', $courses[$i]->ID) ?? 0;
        $courses[$i]->language = get_field('language', $courses[$i]->ID) ?? "";
        
        //$courses[$i]->youtubeVideos = get_field('youtube_videos', $courses[$i]->ID) ? get_field('youtube_videos', $courses[$i]->ID) : [];
        // if (strtolower($courses[$i]->courseType) == 'podcast') {
        //     $podcasts = get_field('podcasts', $courses[$i]->ID) ? get_field('podcasts', $courses[$i]->ID) : [];
        //     if (!empty($podcasts)) {
        //         $courses[$i]->podcasts = $podcasts;
        //     } else {
        //         $podcasts = get_field('podcasts_index', $courses[$i]->ID) ? get_field('podcasts_index', $courses[$i]->ID) : [];
        //         if (!empty($podcasts)) {
        //             $courses[$i]->podcasts = array();
        //             foreach ($podcasts as $key => $podcast) {
        //                 $item = array(
        //                     "course_podcast_title" => $podcast['podcast_title'],
        //                     "course_podcast_intro" => $podcast['podcast_description'],
        //                     "course_podcast_url" => $podcast['podcast_url'],
        //                     "course_podcast_image" => $podcast['podcast_image'],
        //                 );
        //                 array_push($courses[$i]->podcasts, ($item));
        //             }
        //         }
        //     }
        // }
        // $courses[$i]->podcasts = $courses[$i]->podcasts ?? [];
        $courses[$i]->connectedProduct = get_field('connected_product', $courses[$i]->ID);
        $tags = get_field('categories', $courses[$i]->ID) ?? [];
        $courses[$i]->tags = array();
        if ($tags) {
            if (!empty($tags)) {
                foreach ($tags as $key => $category) {
                    if (isset($category['value'])) {
                        $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
                        array_push($courses[$i]->tags, $tag);
                    }
                }
            }
        }
        $new_course = new CourseOptimized($courses[$i]);
        array_push($outcome_courses, $new_course);
    }
    return ['courses' => $outcome_courses, "codeStatus" => 200];
}


function filterArticlesByUserLanguagePreferences($data)
{
    $current_user_id = $GLOBALS['user_id'];
    if (!$current_user_id) 
      {
          $response = new WP_REST_Response("You have to login with valid credentials!");
          $response->set_status(400);
          return $response;
      }
    $course_type = ucfirst(strtolower($data['course_type'] ?? ''));
    $outcome_courses = array();
    $tags = array();
    $experts = array();
    $languages = get_field('language_preferences','user_' . (int) $current_user_id) ?? [];
    // $languages = $data['languages'] ?? '';

    // if (!is_array($languages)) {
    //     $languages = explode(',', $languages); // Convert to array if it's a string
    // }

    $args = array(
        'post_type' => array('post'),
        'post_status' => 'publish',
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => count($languages) != 0 
        ? 
        array
        (
            array
            (
            'key' => 'language',
            'value' => $languages,
            'compare' => 'IN'
            )
        )
            : 
            array(),
        
        'paged' => $data['page'] ?? 1,
    );

    $courses = get_posts($args);
    if (!$courses) {
        return ["courses" => [], 'message' => "There is no courses related to this course type in the database!", "codeStatus" => 400];
    }

    for ($i = 0; $i < count($courses); $i++) {
        $courses[$i]->visibility = get_field('visibility', $courses[$i]->ID) ?? [];
        $author = get_user_by('ID', $courses[$i]->post_author);
        $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
        if ($courses[$i]->visibility != []) {
            if ($author_company != $current_user_company) continue;
        }
        $author_img = get_field('profile_img', 'user_' . $author->ID) ? get_field('profile_img', 'user_' . $author->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $courses[$i]->experts = array();
        $experts = get_field('experts', $courses[$i]->ID);
        if (!empty($experts)) {
            foreach ($experts as $key => $expert) {
              if ($expert->ID == 0)
                continue;
                $expert = get_user_by('ID', $expert);
                $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                array_push($courses[$i]->experts, new Expert($expert, $experts_img));
            }
        }

        $courses[$i]->author = new Expert($author, $author_img);
        $courses[$i]->longDescription = get_field('long_description', $courses[$i]->ID);
        $courses[$i]->shortDescription = get_field('short_description', $courses[$i]->ID);
        $courses[$i]->courseType = get_field('course_type', $courses[$i]->ID);

        $image = get_field('preview', $courses[$i]->ID)['url'];
        if (!$image) {
            $image = get_the_post_thumbnail_url($courses[$i]->ID);
            if (!$image) $image = get_field('url_image_xml', $courses[$i]->ID);
            if (!$image) $image = get_stylesheet_directory_uri() . '/img/' . strtolower($courses[$i]->courseType) . '.jpg';
        }
        $courses[$i]->pathImage = $image;
        $courses[$i]->price = get_field('price', $courses[$i]->ID) ?? 0;
        $courses[$i]->language = get_field('language', $courses[$i]->ID) ?? "";
        $courses[$i]->youtubeVideos = get_field('youtube_videos', $courses[$i]->ID) ? get_field('youtube_videos', $courses[$i]->ID) : [];
        if (strtolower($courses[$i]->courseType) == 'podcast') {
            $podcasts = get_field('podcasts', $courses[$i]->ID) ? get_field('podcasts', $courses[$i]->ID) : [];
            if (!empty($podcasts)) {
                $courses[$i]->podcasts = $podcasts;
            } else {
                $podcasts = get_field('podcasts_index', $courses[$i]->ID) ? get_field('podcasts_index', $courses[$i]->ID) : [];
                if (!empty($podcasts)) {
                    $courses[$i]->podcasts = array();
                    foreach ($podcasts as $key => $podcast) {
                        $item = array(
                            "course_podcast_title" => $podcast['podcast_title'],
                            "course_podcast_intro" => $podcast['podcast_description'],
                            "course_podcast_url" => $podcast['podcast_url'],
                            "course_podcast_image" => $podcast['podcast_image'],
                        );
                        array_push($courses[$i]->podcasts, ($item));
                    }
                }
            }
        }
        $courses[$i]->podcasts = $courses[$i]->podcasts ?? [];
        $courses[$i]->connectedProduct = get_field('connected_product', $courses[$i]->ID);
        $tags = get_field('categories', $courses[$i]->ID) ?? [];
        $courses[$i]->tags = array();
        if ($tags) {
            if (!empty($tags)) {
                foreach ($tags as $key => $category) {
                    if (isset($category['value'])) {
                        $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
                        array_push($courses[$i]->tags, $tag);
                    }
                }
            }
        }
        $new_course = new Course($courses[$i]);
        array_push($outcome_courses, $new_course);
    }
    return ['courses' => $outcome_courses, "codeStatus" => 200];
}

function filterArticlesByUserLanguagePreferencesWithLikes($data)
{
    global $wpdb;

    $current_user_id = $GLOBALS['user_id'];
    if (!$current_user_id) {
        $response = new WP_REST_Response("You have to login with valid credentials!");
        $response->set_status(400);
        return $response;
    }

    $languages = get_field('language_preferences', 'user_' . (int) $current_user_id) ?? [];
    $args = array(
        'post_type' => array('post'),
        'post_status' => 'publish',
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => count($languages) != 0 
            ? array(
                array(
                    'key' => 'language',
                    'value' => $languages,
                    'compare' => 'IN'
                )
            )
            : array(),
        'paged' => $data['page'] ?? 1,
    );

    $courses = get_posts($args);
    if (!$courses) {
        return ["courses" => [], 'message' => "There are no courses related to your preferences!", "codeStatus" => 400];
    }

    $outcome_courses = [];
    foreach ($courses as $course) {
        // Récupérer les statistiques de feedback pour chaque cours
        $stats = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT 
                    SUM(CASE WHEN feedback_value = 'like' THEN 1 ELSE 0 END) as `like`,
                    SUM(CASE WHEN feedback_value = 'educational' THEN 1 ELSE 0 END) as `educational`,
                    SUM(CASE WHEN feedback_value = 'issues' THEN 1 ELSE 0 END) as `issues`,
                    SUM(CASE WHEN feedback_value = 'fake_news' THEN 1 ELSE 0 END) as `fake_news`,
                    SUM(CASE WHEN feedback_value = 'sales' THEN 1 ELSE 0 END) as `sales`
                 FROM {$wpdb->prefix}likes
                 WHERE course_id = %d",
                $course->ID
            )
        );

        // Structure des statistiques de likes
        $likes = [
            'like' => (int) ($stats->like ?? 0),
            'educational' => (int) ($stats->educational ?? 0),
            'issues' => (int) ($stats->issues ?? 0),
            'fake_news' => (int) ($stats->fake_news ?? 0),
            'sales' => (int) ($stats->sales ?? 0),
        ];
        
        $image = get_field('preview', $course->ID)['url'];
          if(!$image){
              $image = get_the_post_thumbnail_url($course->ID);
              if(!$image)
                  $image = get_field('url_image_xml', $course->ID);
                      if(!$image)
                          $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
          }

        // Ajouter les informations du cours au tableau de résultats
        $outcome_courses[] = [
            "ID" => $course->ID,
            "post_title" => $course->post_title,
            "shortDescription" => get_field('short_description', $course->ID) ?? "",
            "longDescription" => get_field('long_description', $course->ID) ?? "",
            "pathImage" => $image,
            "data_locaties_xml" => [],
            "data_locaties" => [],
            "article_itself" => get_field('article_itself', $course->ID) ?? '',
            "language" => get_field('language', $course->ID) ?? "",
            "likes" => $likes, // Intégration des likes
            "visibility" => get_field('visibility', $course->ID) ?? [],
            "author" => [
                "name" => get_user_by('ID', $course->post_author)->display_name,
                "profile_img" => get_field('profile_img', 'user_' . $course->post_author) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png'
            ],
            "tags" => array_map(function ($tag) {
                return [
                    "id" => $tag['value'],
                    "name" => get_the_category_by_ID($tag['value'])
                ];
            }, get_field('categories', $course->ID) ?? []),
            "courseType" => get_field('course_type', $course->ID)
        ];
    }

    return ['courses' => $outcome_courses, "codeStatus" => 200];
}

function searchCoursesViaKeyWords($data)
{
  $keywords = $data['keywords'] != null && !empty($data['keywords']) ? $data['keywords'] : false;
  if (!$keywords)
  {
    $response = new WP_REST_Response('The keywords is required !');
    $response->set_status($code_status);
    return $response;
  }
 
  $args = array(
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC' ,
    's' => $keywords);
    $courses =  get_posts($args);
    $outcome_courses = array();
    for($i=0; $i < count($courses) ;  $i++)
    {
      $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
      $author = get_user_by( 'ID', $courses[$i] -> post_author  );
      $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
      if ($courses[$i]->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          $new_course = new Course($courses[$i]);
          array_push($outcome_courses, $new_course);
    }
   return ['courses' => $outcome_courses, "codeStatus" => 200];
  


}


function getOfflineCourse ($data)
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
      'meta_value' => ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus']);
      
    $courses = get_posts($args);
    if (!$courses)
      return ["courses" => [],'message' => "There is no courses related to this course type in the database! ","codeStatus" => 400];
      
    if (!isset ($data['page'])) 
      $page = 1;  
    else   
      $page = $data['page'];
    if(!empty($courses))
      $number_of_post = count($courses);
  $results_per_page = 15;
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

function allOfflineCoursesOptimized ($data)
{
    $current_user_id = $GLOBALS['user_id'];
    $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];
    $outcome_courses = array();
    $tags = array();
    $experts = array();
    $languages =  get_field('language_preferences','user_' . (int) $current_user_id) ?? [];
    $course_types = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
    // $languages = $data['languages'] ?? '';

    // if (!is_array($languages)) {
    //     $languages = explode(',', $languages); // Convert to array if it's a string
    // }

    $args = array(
        'post_type' => array('course'),
        'post_status' => 'publish',
        'posts_per_page' => 20,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => 
        count($languages) != 0 
        ? 
          array(
              'relation' => 'AND',
              array(
                  'key' => 'language',
                  'value' => $languages,
                  'compare' => 'IN'
              ),
              array(
                  'key' => 'course_type',
                  'value' => $course_types,
                  'compare' => 'IN'
              )
          ) 
          : 
          array(
            array(
              'key' => 'course_type',
              'value' => $course_types,
              'compare' => 'IN'
            )
            ),
        'paged' => $data['page'] ?? 1,
    );

    // $args = array(
    //   'post_type' => array('course'),
    //   'post_status' => 'publish',
    //   'posts_per_page' => 20,
    //   'ordevalue'       => $course_type,
    //   'order' => 'DESC' ,
    //   'meta_key'         => 'course_type',
    //   'paged' => $data['page'] ?? 1,
    //   'meta_value' => );
      
    $courses = get_posts($args);
    if (!$courses)
      return ["courses" => [],'message' => "There is no courses related to this course type in the database! ","codeStatus" => 400];
  
  for($i=0; $i < count($courses) ;  $i++) 
  {
      $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
      $author = get_user_by( 'ID', $courses[$i] -> post_author  );
      $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
      if ($courses[$i]->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
              $course->courseType = get_field('course_type',$course->ID);
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

function allArticlesOptimized ($data)
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
      'posts_per_page' => 20,
      //'order' => 'DESC' ,
      'paged' => $data['page'] ?? 1
    );
    $results = new WP_Query($args);
    //return $results->posts;
    // $courses = array();
    $i = 0;
    $courses = $results->posts;
    if ($results->have_posts()) :  while ($results->have_posts()) : $results->the_post();
         $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
         $author = get_user_by( 'ID', $courses[$i] -> post_author  );
         $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
          if ($courses[$i]->visibility != []) 
            if ($author_company != $current_user_company)
              continue;
              $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              $courses[$i]->experts = array();
              $experts = get_field('experts',$courses[$i]->ID);
              if(!empty($experts))
                foreach ($experts as $key => $expert) {
                  $expert = get_user_by( 'ID', $expert );
                  $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                  array_push($courses[$i]->experts, new Expert ($expert,$experts_img));
                  }
              //return $courses;    
             $courses[$i]-> author = new Expert ($author , $author_img);
             $courses[$i]->longDescription = get_field('long_description',$courses[$i]->ID);
             $courses[$i]->shortDescription = get_field('short_description',$courses[$i]->ID);
             $courses[$i]->courseType = get_field('course_type',$courses[$i]->ID);
            // Image - article
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
             $courses[$i]->youtubeVideos =  []  ;
             $courses[$i]->podcasts = [];
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
                //  $handle = curl_init($courses[$i]->pathImage);
                //  curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
  
                 /* Get the HTML or whatever is linked in $url. */
                 //$response = curl_exec($handle);
  
                 /* Check for 200 (file ok). */
                //  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                //  if($httpCode != 200) {
                //      /* Handle 404 here. */
                //      $courses[$i]->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($courses[$i]->courseType) . '.jpg';
                //    }
                //  curl_close($handle);
                
             $new_course = new Course($courses[$i]);
             array_push($outcome_courses, $new_course);
            $i++;
  endwhile;
endif;
//shuffle($outcome_courses);
return ['courses' => $outcome_courses, "codeStatus" => 200];
    //   if (!$courses)
  //     return ["courses" => [],'message' => "There is no courses related to this course type in the database! ","codeStatus" => 400];
      
  //   if (!isset ($data['page'])) 
  //     $page = 1;  
  //   else   
  //     $page = $data['page'];
  //   if(!empty($courses))
  //     $number_of_post = count($courses);
  // $results_per_page = 20;
  // $start = ($page-1) * $results_per_page ;
  // $end = ( ($page) * $results_per_page ) > $number_of_post ? $number_of_post : ($page) * $results_per_page   ;

  // $number_of_page = ceil($number_of_post / $results_per_page);

  // if($number_of_page < $data['page'])
  //   return ["courses" => [],'message' => "Page doesn't exist ! ","codeStatus" => 400];  
  
  // foreach(
  //   $courses as $i => $course
  //  // $i=$start; $i < $end ;  $i++
  //   ) 
  // {
  //     
  //   shuffle($outcome_courses);
  //  return ['courses' => $outcome_courses, "codeStatus" => 200];
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          $courses[$i]->youtubeVideos =  []  ;
          $courses[$i]->podcasts = [];
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
    shuffle($outcome_courses);
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

function getTopicCoursesROptimized($data)
{
  $topic_id = $data['id']; 
  $infos = [];
  $main_experts = [];
  $expertsID = [];
  $userID = isset($data['userID']) ? $data['userID'] : null;

  //Get category information
  $category = detailCategory($topic_id, $userID);
  $infos['category'] = $category;

  //Get other topics
  $subtopics = get_categories( array(
    'taxonomy'   => 'course_category',
    'parent' => (int)$category->parent,
    'exclude' => $topic_id,
    'hide_empty' => false,
  )) ?? false;
  $infos['other_topics'] = $subtopics;

  /** Global posts **/
  $tax_query = array(
  array(
    "taxonomy" => "course_category",
    "field"    => "term_id",
    "terms"    => $topic_id
    )
  );
  $courses = array();
  // $query_blogs = new WP_Query( $args );
  //Filter with category
  $args = array(
      'post_type' => array('post', 'course'),
      'post_status' => 'publish',
      'tax_query' => $tax_query,
      'nopaging' => true,
  );
  $query_blogs_category = new WP_Query( $args );
  $courses = isset($query_blogs_category->posts) ? $query_blogs_category->posts : [];

  $outcome_courses = array();
  for($i = 0; $i < count($courses); $i++) 
  {
    $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
    $author = get_user_by('ID', $courses[$i] -> post_author);
    $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
    if ($courses[$i]->visibility != []) 
      if ($author_company != $current_user_company)
        continue;

        //Experts post 
        $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $courses[$i]->experts = array(); 
        $experts = get_field('experts',$courses[$i]->ID);
        if(!empty($experts))
          foreach ($experts as $key => $expert) :
            $expert = get_user_by( 'ID', $expert );
            $experts_img = get_field('profile_img','user_'. $expert->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            array_push($courses[$i]->experts, new Expert ($expert,$experts_img));
            if(!in_array($expert->ID, $expertsID)):
              $main_experts[] = new Expert ($expert,$experts_img);
              $expertsID[] = $expert->ID;
            endif;
          endforeach;      
        $courses[$i]->author = new Expert ($author, $author_img);
        if(!in_array($author->ID, $expertsID)):
          $main_experts[] = new Expert ($author, $author_img); 
          $expertsID[] = $author->ID;
        endif;

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
                    "course_podcast_title" => $podcast['podcast_title'], 
                    "course_podcast_intro" =>$podcast['podcast_description'],
                    "course_podcast_url" => $podcast['podcast_url'],
                    "course_podcast_image" => $podcast['podcast_image'],
                  );
                  array_push ($courses[$i]->podcasts,($item));
                }
              }
          }
        }
        $courses[$i]->podcasts = $courses[$i]->podcasts ?? [];
        $courses[$i]->tags = get_the_terms( $courses[$i]->ID, 'course_category' );
        // $tags = get_field('categories',$courses[$i]->ID) ?? [];
        // if($tags)
        //   if (!empty($tags))
        //     foreach ($tags as $key => $category) 
        //       if(isset($category['value'])){
        //         $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
        //         array_push($courses[$i]->tags,$tag);
        //       }
        $new_course = new Course($courses[$i]);
        array_push($outcome_courses, $new_course);
  }
  $infos['courses'] = $outcome_courses;
  $infos['experts'] = $main_experts;

  $response = new WP_REST_Response($infos);
  $response->set_status(200);
  return($response);

}

function getTopicCoursesOptimized($data)
{
   $topic_id = $data['id'];
   $courses = get_posts(
    array(
      'post_type' => array('course', 'post'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
      'meta_query'     => array(
        'relation' => 'OR',
        array
        (
          'key'     => 'categories',
          'value'   => $topic_id, 
          'compare' => 'LIKE'
        ),
        array
        (
          'key'     => 'category_xml',
          'value'   => $topic_id, 
          'compare' => 'LIKE'
        )
    )
    )
  );
  $outcome_courses = array();
  
  for($i=0; $i <count($courses) ;$i++) 
  {
    $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
    $author = get_user_by( 'ID', $courses[$i] -> post_author  );
    $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
    if ($courses[$i]->visibility != []) 
      if ($author_company != $current_user_company)
        continue;
        $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
        $new_course = new Course($courses[$i]);
        array_push($outcome_courses, $new_course);
  }

 return $outcome_courses;
}


/**
  * Reservation Endpoints
  */
  function reserve_course(WP_REST_Request $request)
  {
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

  function get_user_signups()
  {
    if (!isset($GLOBALS['user_id']) || empty($GLOBALS['user_id']))
      return ['error' => "You have to fill in the id of current user !"];

    $user_id = $GLOBALS['user_id'];
    global $wpdb;
    $table_reserveren = $wpdb->prefix . 'reserveren';
    $sql = $wpdb->prepare( "SELECT * FROM $table_reserveren WHERE user_id = $user_id");
    $occurences = $wpdb->get_results( $sql );
    
    if (!empty($occurences))
    {
      $reservations = array();
      foreach ($occurences as $key => $occurence) {
        array_push($reservations, (object)$occurence);
      }
      $response = new WP_REST_Response($reservations);
      $response->set_status(200);
      return($response);
    }

    $response = new WP_REST_Response([]);
    $response->set_status(200);
    return($response);
    
  }
  
/**
  * Assessment Endpoints
  */
  function getAssessments($data)
  {
    // Retrieve the user ID from the global variable and validate it
    $user_id = false;
    $user_id = isset($data['userID']) ? $data['userID'] : $GLOBALS['user_id'];

    // Check if the user ID is provided
    if (!$user_id) 
    {
      $response = new WP_REST_Response("You have to login with valid credentials!");
      $response->set_status(400);
      return $response;
    }
    
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
 
function getCommunitiesPersonal($data) {
  //Personal ID
  $user_id = $data['id'] ?? null;
  if ($user_id == 0)
    return ["error" => "You have to fill the correct user id !"];

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
      if ($author_community ->ID != $author_company->ID)
        continue;
    
    $community-> author_company = array();
    if(is_object($author_community))
      array_push($community->author_company,$author_community);
    $community->image_community = get_field('image_community',$community->ID) ? get_field('image_community',$community->ID) : null;
    $community->range = get_field('range',$community->ID) ? get_field('range',$community->ID) : null;
    $community->is_connected_user_member = false;
    $follower_community = get_field('follower_community', $community->ID) ? get_field('follower_community', $community->ID) : [];
    $community->count_members =  count($follower_community) ?? 0;

    //Followers community
    $community->is_connected_user_member = false;
    $community->followers = array();
    if (!empty($follower_community))
      foreach ($follower_community as $key => $follower):
        if ($follower -> data -> ID == $user_id)
          $community->is_connected_user_member = true;

        $follower -> data -> profile_image =  get_field('profile_img','user_' . (int)$follower -> data ->ID) != false ? get_field('profile_img','user_' . (int)$follower -> data ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        array_push($community->followers, $follower -> data);  
      endforeach;
    
    $posts = get_field('course_community', $community->ID);
    $community->count_posts = $posts ? count($posts) : 0;

    //Posts community 
    $community->posts = array();
    foreach ($posts as $key => $value)
      $community->posts[] = artikel($value->ID);    

    array_push($retrieved_communities, $community);
  }
  
  return $retrieved_communities;

}

function getCommunitiesAuthor($data) {
  //Personal ID
  $user_id = $data['id'] ?? null;
  if ($user_id == 0)
    return ["error" => "You have to fill the correct user id !"];

  //All communities
  $args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'author' => $user_id,
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
      if ($author_community ->ID != $author_company->ID)
        continue;
    
    $community-> author_company = array();
    if(is_object($author_community))
      array_push($community->author_company,$author_community);
    $community->image_community = get_field('image_community',$community->ID) ? get_field('image_community',$community->ID) : null;
    $community->range = get_field('range',$community->ID) ? get_field('range',$community->ID) : null;
    $community->is_connected_user_member = false;
    $follower_community = get_field('follower_community', $community->ID) ? get_field('follower_community', $community->ID) : [];
    $community->count_members =  count($follower_community) ?? 0;

    //Followers community
    $community->is_connected_user_member = false;
    $community->followers = array();
    if (!empty($follower_community))
      foreach ($follower_community as $key => $follower):
        if ($follower -> data -> ID == $user_id)
          $community->is_connected_user_member = true;

        $follower -> data -> profile_image =  get_field('profile_img','user_' . (int)$follower -> data ->ID) != false ? get_field('profile_img','user_' . (int)$follower -> data ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        array_push($community->followers, $follower -> data);  
      endforeach;
    
    $posts = get_field('course_community', $community->ID);
    $community->count_posts = $posts ? count($posts) : 0;

    //Posts community 
    $community->posts = array();
    foreach ($posts as $key => $value)
      $community->posts[] = artikel($value->ID);    

    array_push($retrieved_communities, $community);
  }
  
  return $retrieved_communities;
}

function getCommunityBy($data)
{
  $user_id = $GLOBALS['user_id'];
  //All communities
  $slug = $data['slug'] ?? null;
  if ($slug == null)
    return ["error" => "You have to fill correctly the slug of the community !"];

  $community = get_page_by_path($slug, OBJECT, 'community') ?? null;
  if ($community == null)
    return ["error" => "This community does not exist !"];

  $community-> author_company = array();
  //Check if the community is private or public
  $community->visibility_community = get_field('visibility_company',$community->ID) ?? false;
  $community->password_community = get_field('password_community',$community->ID);
  $author_community = get_field('company_author',$community->ID) ?? false;
  $author_company = get_field('company', 'user_' . (int) $user_id)[0] ?? false;
  
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
        if( $question['user_question']->data)
        $question['user_question']->data->profile_image = get_field('profile_img','user_'.(int)$question['user_question']->data->ID) != false ? get_field('profile_img','user_'.(int)$question['user_question']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      if (isset($question['reply_question']) && !empty($question['reply_question'])) 
        foreach ($question['reply_question'] as $key => $reply) {
          if( $reply['user_reply']->data)
          $reply['user_reply']->data->profile_image = get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) != false ? get_field('profile_img','user_'.(int)$reply['user_reply']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';  
        } 
    $question['user_question']->data->profile_image = get_field('profile_img','user_'.(int)$question['user_question']->data->ID) != false ? get_field('profile_img','user_'.(int)$question['user_question']->data->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png'; ;
    if (!$question['reply_question'])
        $community->questions[$key]['reply_question'] = [];
    }
  }
  $courses_community = get_field('course_community',$community->ID) ?? [];
  if (!empty($courses_community))

      foreach ($courses_community as $key => $course)
      {
            $author = get_user_by( 'ID', $course -> post_author);
            $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

function getCommunityByID($data)
{
  $user_id = $GLOBALS['user_id'];
  //All communities
  $id = $data['id'] ?? null;
  if ($id == null)
    return ["error" => "You have to fill correctly the slug of the community !"];

  $community = get_post($id) ?? null;
  if ($community == null)
    return ["error" => "This community does not exist !"];

  $community-> author_company = array();
  //Check if the community is private or public
  $community->visibility_community = get_field('visibility_company',$community->ID) ?? false;
  $community->password_community = get_field('password_community',$community->ID);
  $author_community = get_field('company_author',$community->ID) ?? false;
  $author_company = get_field('company', 'user_' . (int) $user_id)[0] ?? false;
  
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
            $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

function addCourseCommunity(WP_REST_Request $request){
  $required_parameters = ['communityID', 'courses'];

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;
  
  //is array & is a community 
  $errors = [];
  $ids = $request['courses'];
  $community = get_post($request['communityID']);
  if(!is_array($ids) || !$community):
    $errors['errors'] = "Please fill the fields correctly !";
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;
  
  $args = array(
    'post_type' => array('post', 'course'),
    'post_status' => 'publish',
    'include' => $ids,
    'posts_per_page' => -1 
  );
  $main_courses = get_posts($args);  

  $former_courses = get_field('course_community', $community->ID);
  $courses = (!empty($former_courses)) ? array_merge($former_courses, $main_courses) : $main_courses;

  //Add the courses to the community
  update_field ('course_community', $courses, $community->ID);

  //Send response
  $message = "Succesfully added courses to the community !"; 
  $response = new WP_REST_Response($message);
  $response->set_status(200);
  return $response;
}

function getCommunitiesOptimized($data)
{
  // Retrieve the user ID from the global variable and validate it
  $user_id = false;
  $user_id = isset($data['userID']) ? $data['userID'] : $GLOBALS['user_id'];

  // Check if the user ID is provided
  if (!$user_id) 
  {
    $response = new WP_REST_Response("You have to login with valid credentials!");
    $response->set_status(400);
    return $response;
  }

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
        
    $community-> author_company = array();
    if(is_object($author_community))
      array_push($community->author_company,$author_community);
    $community->image_community = get_field('image_community',$community->ID) ? get_field('image_community',$community->ID) : null;
    $community->range = get_field('range',$community->ID) ? get_field('range',$community->ID) : null;
    $community->is_connected_user_member = false;
    $follower_community = get_field('follower_community',$community->ID) ? get_field('follower_community',$community->ID) : [];
    $community->count_members = count($follower_community) ?? 0;
    if (!empty($follower_community))
      foreach ($follower_community as $key => $follower) 
        if ($follower -> data -> ID == $user_id)
        {
          $community->is_connected_user_member = true;
          break;
        }
    
    $community->count_posts = get_field('course_community', $community->ID) ? count(get_field('course_community', $community->ID)) : 0;

    array_push($retrieved_communities, $community);
  }
  
  return $retrieved_communities;
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
        'Watch 10 videos !',
        'Read 50 videos !' ,
        'Listen 7 podcasts !' ,
        'View the same topic more than 10 times'
];

    $array_badges = array();

    foreach ($occurences as $value) {
        $course_type = get_field('course_type', $value->data_id);
        $count[$course_type]++;
    }

    $trigger_badge = null;
    if($count['Artikel'] >= 1 && $count['Artikel'] < 50){
        $level = 'basic';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[0];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[0];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Artikel'] >= 50){
        $level = 'advance';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[1];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[1];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Video'] >= 10 && $count['Video'] < 50){
        $level = 'pro';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[2];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[2];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Video'] >= 50){
        $level = 'expert';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[3];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[3];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Podcast'] >= 7){
        $level = 'pro';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[4];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[4];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($best_topic_views >= 10){
        $level = 'advance';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
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
              update_field('level_badge', $badge->level, $badge_id);
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

  function update_user_smartphone_token(WP_REST_Request $request){
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

  /**
   * User's Progression 
  */

  function get_user_course_progression($request)
  {
    $course_title = $request['course_title'] ?? false;
    if ($course_title == false)
    {
      $response = new WP_REST_Response('You have to fill in the course title');
      $response->set_status(400);
      return $response;
    }
    
    $user_id = $request['user_id'] ?? 0;
    $user = get_user_by( 'ID', $user_id );
      if ($user == false)
      {
        $response = new WP_REST_Response('This user doesn\'t exist');
        $response->set_status(400);
        return $response;
      }
      
      //Get read by user 
      //Get posts searching by title
      $args = array(
      'post_type' => 'progression', 
      'title' => $course_title,
      'post_status' => 'publish',
      'author' => $user->ID,
      'posts_per_page'         => 1,
      'no_found_rows'          => true,
      'ignore_sticky_posts'    => true,
      'update_post_term_cache' => false,
      'update_post_meta_cache' => false,
    );
    $progressions = get_posts($args) ?? [];
    
    if(empty($progressions))
    {
      //Create progression
      $post_data = array(
          'post_title' => $course_title,
          'post_author' => $user->ID,
          'post_type' => 'progression',
          'post_status' => 'publish'
      );
      $progression_id = wp_insert_post($post_data);
    }
    else
      $progression_id = $progressions[0]->ID;
  //Lesson read
  $lesson_reads = get_field('lesson_actual_read', $progression_id) == null || get_field('lesson_actual_read', $progression_id) == false ? [] : get_field('lesson_actual_read', $progression_id);
  $response = new WP_REST_Response($lesson_reads);
  $response->set_status(200);
  $progressions = get_posts($args);

  return $lesson_reads;    
  }


  function updateUserProgressionWithLastPosition($request)
  {
    $course_title = $request['course_title'] ?? false;
    if ($course_title == false) {
        $response = new WP_REST_Response('You have to fill in the course title');
        $response->set_status(400);
        return $response;
    }

    $user_id = $request['user_id'] ?? 0;
    $user = get_user_by('ID', $user_id);

    if ($user == false) {
        $response = new WP_REST_Response('This user doesn\'t exist');
        $response->set_status(400);
        return $response;
    }

    $lesson_keys = $request['lesson_keys'] ?? [];
    if (empty($lesson_keys)) {
        $response = new WP_REST_Response('You have to fill in the user progression');
        $response->set_status(400);
        return $response;
    }

    $args = array(
        'post_type' => 'progression',
        'title' => $course_title,
        'post_status' => 'publish',
        'author' => $user->ID,
        'posts_per_page' => 1,
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    );

    $progression = get_posts($args)[0];
    $lesson_reads = get_field('lesson_actual_read', $progression->ID) ?? [];
    $updated_lesson_reads = [];

    // Ajouter ou mettre à jour les leçons basées sur les nouvelles données
    foreach ($lesson_keys as $new_lesson) 
    {
        $new_key_lesson = $new_lesson['key_lesson'];
        $new_key_lesson_base = explode('-', $new_key_lesson)[0];
        $updated = false;

        foreach ($lesson_reads as $index => $lesson) {
            $existing_key_lesson = $lesson['key_lesson'];
            $existing_key_lesson_base = explode('-', $existing_key_lesson)[0];

            if ($existing_key_lesson_base == $new_key_lesson_base) {
                $lesson_reads[$index] = $new_lesson; // Mettre à jour la leçon existante
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            $lesson_reads[] = $new_lesson; // Ajouter une nouvelle leçon
        }
    }

    update_field('lesson_actual_read', $lesson_reads, $progression->ID);

    $response = new WP_REST_Response([
        'lesson_keys' => $lesson_reads,
    ]);
    $response->set_status(200);
    return $response;
  
  }
  
  function getUserProgressionWithLastPosition($request)
  {
    $course_title = $request['course_title'] ?? false;
    if ($course_title == false) {
        $response = new WP_REST_Response('You have to fill in the course title');
        $response->set_status(400);
        return $response;
    }

    $user_id = $request['user_id'] ?? 0;
    $user = get_user_by('ID', $user_id);
    if ($user == false) {
        $response = new WP_REST_Response('This user doesn\'t exist');
        $response->set_status(400);
        return $response;
    }

    $args = array(
        'post_type' => 'progression',
        'title' => $course_title,
        'post_status' => 'publish',
        'author' => $user->ID,
        'posts_per_page' => 1,
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    );
    $progressions = get_posts($args) ?? [];

    if (empty($progressions)) {
        $post_data = array(
            'post_title' => $course_title,
            'post_author' => $user->ID,
            'post_type' => 'progression',
            'post_status' => 'publish'
        );
        $progression_id = wp_insert_post($post_data);
    } else {
        $progression_id = $progressions[0]->ID;
    }

    $lesson_reads = get_field('lesson_actual_read', $progression_id) ?: [];
    foreach ($lesson_reads as &$lesson_read) {
        if (empty($lesson_read['last_position'])) {
            $lesson_read['last_position'] = '00:00';
        }
    }

    $response_data = [
        'lesson_keys' => $lesson_reads,
    ];

    $response = new WP_REST_Response($response_data);
    $response->set_status(200);
    return $response;
  }


function get_all_user_progress( $request ) {
  global $wpdb;
  $user_id = isset($request['user_id']) ? $request['user_id'] : $GLOBALS['user_id'];
  $user_id = ($user_id) ?? 0;
  if ($user_id == 0){
    $response = new WP_REST_Response("You have to login with good credentials !"); 
    $response->set_status(400);
    return $response;
  }

  $course_id =  $request['course_id'] ?? null;
  if ($course_id == null){
    $response = new WP_REST_Response("You have to provide the course id !"); 
    $response->set_status(400);
    return $response;
  }

  $table_name = $wpdb->prefix . 'user_progression';
  $results = $wpdb->get_results(
    $wpdb->prepare(
      "SELECT episode_index, progress_seconds, episode_duration FROM $table_name WHERE user_id = %d AND course_id = %d",
      $user_id, $course_id
    )
  );

  if ( empty( $results ) ) 
    return new WP_REST_Response( 'no_progress_found', 'No progress found for this user and course.', array( 'status' => 200 ) );

  $response = array();

  foreach ( $results as $row ):
    $progress_percentage = 0;
    if ( $row->episode_duration > 0 ) {
      $progress_percentage = ($row->progress_seconds / $row->episode_duration) * 100;
    }

    $response[] = array(
      'episode_index' => $row->episode_index,
      'progress_seconds' => $row->progress_seconds,
      'episode_duration' => $row->episode_duration,
      'progress_percentage' => ceil($progress_percentage)
    );
  endforeach;

  return rest_ensure_response( $response );
}


  // function update_user_progress(WP_REST_Request $request) 
  // {

  //   global $wpdb;

  //   $user_id = $GLOBALS['user_id'] ?? 0;
  //   if ($user_id == 0)
  //   {
  //     $response = new WP_REST_Response("You have to login with good credentials !"); 
  //     $response->set_status(400);
  //     return $response;
  //   }

  //   $course_id = $request['course_id'] ?? null;

  //   if ($course_id == null)
  //   {
  //     $response = new WP_REST_Response("You have to provide the course id !"); 
  //     $response->set_status(400);
  //     return $response;
  //   }
  //   $episode_index = $request['episode_index'] ?? null;

  //   if ($episode_index == null)
  //   {
  //     $response = new WP_REST_Response("You have to provide the episode index !"); 
  //     $response->set_status(400);
  //     return $response;
  //   }

  //   $new_progress_seconds = $request['progress_seconds'] ?? null;

  //     if ($new_progress_seconds == null)
  //         {
  //           $response = new WP_REST_Response("You have to provide you progression duration !"); 
  //           $response->set_status(400);
  //           return $response;
  //         }

    
  //   $episode_duration = $request['episode_duration'] ?? null;

  //   if ($episode_duration == null)
  //   {
  //     $response = new WP_REST_Response("You have to provide the duration of the course !"); 
  //     $response->set_status(400);
  //     return $response;
  //   }

  //   $table_name = $wpdb->prefix . 'user_progression';

  //   // Récupérer l'enregistrement actuel pour cet utilisateur, cours et épisode
  //   $current_progress = $wpdb->get_row(
  //       $wpdb->prepare(
  //           "SELECT progress_seconds, episode_duration FROM $table_name WHERE user_id = %d AND course_id = %d AND episode_index = %d",
  //           $user_id, $course_id, $episode_index
  //       )
  //   );

  //   // Si l'enregistrement n'existe pas, on le crée
  //   if ( !$current_progress ) {
  //       // Vérification que la nouvelle progression ne dépasse pas la durée de l'épisode
  //       if ( $new_progress_seconds > $episode_duration ) {
  //           return new WP_Error( 'invalid_progress', 'New progress exceeds the episode duration.', array( 'status' => 400 ) );
  //       }

  //       // Création de l'enregistrement
  //       $inserted = $wpdb->insert(
  //           $table_name,
  //           array(
  //               'user_id' => $user_id,
  //               'course_id' => $course_id,
  //               'episode_index' => $episode_index,
  //               'progress_seconds' => $new_progress_seconds,
  //               'episode_duration' => $episode_duration
  //           ),
  //           array( '%d', '%d', '%d', '%d', '%d' )
  //       );

  //       if ( $inserted === false ) {
  //           return new WP_Error( 'insert_failed', 'Failed to insert progress.', array( 'status' => 500 ) );
  //       }

  //       $progress_percentage = ($new_progress_seconds / $episode_duration) * 100;

  //       $response = array(
  //           'success' => true,
  //           'progress_seconds' => $new_progress_seconds,
  //           'episode_duration' => $episode_duration,
  //           'progress_percentage' => round($progress_percentage, 2)
  //       );

  //       return rest_ensure_response( $response );
  //   }

  //   // Vérification des conditions pour la mise à jour
  //   if ( $new_progress_seconds < $current_progress->progress_seconds ) {
  //       return new WP_Error( 'invalid_progress', 'New progress is less than the current progress.', array( 'status' => 400 ) );
  //   }

  //   if ( $new_progress_seconds > $current_progress->episode_duration ) {
  //       return new WP_Error( 'invalid_progress', 'New progress exceeds the episode duration.', array( 'status' => 400 ) );
  //   }

  //   // Mise à jour de la progression
  //   $updated = $wpdb->update(
  //       $table_name,
  //       array(
  //           'progress_seconds' => $new_progress_seconds,
  //       ),
  //       array(
  //           'user_id' => $user_id,
  //           'course_id' => $course_id,
  //           'episode_index' => $episode_index
  //       ),
  //       array( '%d' ),
  //       array( '%d', '%d', '%d' )
  //   );

  //   if ( $updated === false ) {
  //       return new WP_Error( 'update_failed', 'Failed to update progress.', array( 'status' => 500 ) );
  //   }

  //   // Calcul du pourcentage de progression après mise à jour
  //   $progress_percentage = ($new_progress_seconds / $current_progress->episode_duration) * 100;

  //   $response = array(
  //       'success' => true,
  //       'progress_seconds' => $new_progress_seconds,
  //       'episode_duration' => $current_progress->episode_duration,
  //       'progress_percentage' => round($progress_percentage, 2)
  //   );

  //   return rest_ensure_response( $response );
  // }


function update_user_progress( WP_REST_Request $request ) 
{
  global $wpdb;

  $user_id = isset($request['user_id']) ? $request['user_id'] : $GLOBALS['user_id'];
  $user_id = ($user_id) ?? 0;
  if ($user_id == 0)
  {
    $response = new WP_REST_Response("You have to login with good credentials!"); 
    $response->set_status(400);
    return $response;
  }

  $course_id = $request['course_id'] ?? null;
  if ($course_id == null)
  {
    $response = new WP_REST_Response("You have to provide the course id!"); 
    $response->set_status(400);
    return $response;
  }

  $episode_index = $request['episode_index'] ?? null;
  if ($episode_index == null)
  {
    $response = new WP_REST_Response("You have to provide the episode index!"); 
    $response->set_status(400);
    return $response;
  }

  $new_progress_seconds = $request['progress_seconds'] ?? null;
  if ($new_progress_seconds == null)
  {
    $response = new WP_REST_Response("You have to provide your progression duration!"); 
    $response->set_status(400);
    return $response;
  }

  $episode_duration = $request['episode_duration'] ?? null;
  if ($episode_duration == null)
  {
    $response = new WP_REST_Response("You have to provide the duration of the episode!"); 
    $response->set_status(400);
    return $response;
  }

  $table_name = $wpdb->prefix . 'user_progression';

  // Récupérer l'enregistrement actuel pour cet utilisateur, cours et épisode
  $current_progress = $wpdb->get_row(
    $wpdb->prepare(
      "SELECT progress_seconds, episode_duration FROM $table_name WHERE user_id = %d AND course_id = %d AND episode_index = %d",
      $user_id, $course_id, $episode_index
    )
  );

  if (!$current_progress) {
    // Si aucun enregistrement n'existe, on insère un nouvel enregistrement
    if ($new_progress_seconds > $episode_duration) {
      return new WP_Error('invalid_progress', 'New progress exceeds the episode duration.', array('status' => 400));
    }

    $time_spent = $new_progress_seconds;

    $inserted = $wpdb->insert(
      $table_name,
      array(
          'user_id' => $user_id,
          'course_id' => $course_id,
          'episode_index' => $episode_index,
          'progress_seconds' => $new_progress_seconds,
          'episode_duration' => $episode_duration
      ),
      array('%d', '%d', '%d', '%d', '%d')
    );

    if ($inserted === false) {
      return new WP_Error('insert_failed', 'Failed to insert progress.', array('status' => 500));
    }
  } 
  else {
    // Si un enregistrement existe, on le met à jour
    if ($new_progress_seconds < $current_progress->progress_seconds) {
        return new WP_Error('invalid_progress', 'New progress is less than the current progress.', array('status' => 400));
    }

    if ($new_progress_seconds > $current_progress->episode_duration) {
        return new WP_Error('invalid_progress', 'New progress exceeds the episode duration.', array('status' => 400));
    }

    $time_spent = $new_progress_seconds - $current_progress->progress_seconds;

    $updated = $wpdb->update(
        $table_name,
        array('progress_seconds' => $new_progress_seconds),
        array('user_id' => $user_id, 'course_id' => $course_id, 'episode_index' => $episode_index),
        array('%d'),
        array('%d', '%d', '%d')
    );

    if ($updated === false) {
      return new WP_Error('update_failed', 'Failed to update progress.', array('status' => 500));
    }
  }

  // Récupérer le cours
  $course = get_post($course_id);
  if ($course != null) 
  {
    $tags = get_field('categories', $course->ID) ?? [];
    
    if (count($tags) > 0) {

      foreach ($tags as $key => $category) 
      if(isset($category['value']))
      {
        $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
        $post_data = json_encode([
          'user_id' => $user_id,
          'category_id' =>  $tag->id,
          'category_name' => $tag->name,
          'time_spent' => $time_spent,
          'course_type' => strtolower(get_field('course_type', $course->ID))
        ]);
        send_post_request('https://www.livelearn.nl/wp-json/custom/v2/user/statistics/subtopic/update', $post_data);
      }    
    }

    // Envoi de la requête PUT
    $put_data = json_encode([
        'user_id' => $user_id,
        'course_type' => strtolower(get_field('course_type', $course->ID)),
        'time_spent' => $time_spent
    ]);
    send_put_request('https://www.livelearn.nl/wp-json/custom/v2/user/statistics', $put_data);
  }

  $progress_percentage = ($new_progress_seconds / $episode_duration) * 100;

  $response = array(
    'success' => true,
    'progress_seconds' => $new_progress_seconds,
    'episode_duration' => $episode_duration,
    'progress_percentage' => round($progress_percentage, 2)
  );

  return rest_ensure_response($response);
}

// Fonction pour envoyer une requête POST
 function send_post_request($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);
    // var_dump($response);
    return $response;
}

// Fonction pour envoyer une requête PUT
 function send_put_request($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $response = curl_exec($ch);
    curl_close($ch);
    // var_dump($response);
    return $response;
}

  /* User progression */  
  function matchin_topics()
  {
    global $wpdb;

    $main_categories = array();
    $data_historiq = array();

    $categories_get = get_categories( 
      array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
      ) 
    );

    foreach($categories_get as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($main_categories, $category);
    }

    $main_topics = array();
    foreach($main_categories as $category_id){

        //Topics
        $topics_get = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $category_id,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            )
        );

        if($category_id)
          $main_topics = array_merge($main_topics, $topics_get);
    }

    $args = array(
      'post_type' => array('post', 'course'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
    );
    $global_posts = get_posts($args);

    //Iteration of all topics to get their courses 
    foreach($main_topics as $topic):

      //Initialize arrays
      $child_topics_id = array();

      //Get child topics category
      if($topic)
        $child_topics = get_categories(
          array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'orderby'    => 'name',
            'parent'     => $topic->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
          ) 
        );
      
      if(isset($child_topics))
          foreach($child_topics as $category)
              array_push($child_topics_id, $category->cat_ID);
            
      foreach($global_posts as $blog):
        /*
        * Categories
        */
        $category_default = get_field('categories', $blog->ID);
        $categories_xml = get_field('category_xml', $blog->ID);
        $merge_categories_id = array();
    
        /*
        * Merge categories from customize and xml
        */
        if(!empty($category_default))
          foreach($category_default as $item)
            if($item)
              if($item['value'])
                  if(!in_array($item['value'], $merge_categories_id))
                    array_push($merge_categories_id, $item['value']);
    
        else if(!empty($category_xml))
          foreach($category_xml as $item)
            if($item)
              if($item['value'])
                if(!in_array($item['value'], $merge_categories_id))
                    array_push($merge_categories_id, $item['value']);
    
        $born = false;
        foreach($child_topics_id as $categoriee){
          if($merge_categories_id)
            if(in_array($categoriee, $merge_categories_id)){
                $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}matchin_topics WHERE topic_id = %d AND post_id = %d", array($topic->cat_ID, $blog->ID));
                $iteration = $wpdb->get_results( $sql )[0];
            
                if($iteration)
                  if($iteration != 0)
                    break;
                
                // Insert matching course to each course record 
                $table_matching = $wpdb->prefix . 'matchin_topics';
                $data = ['topic_id' => $topic->cat_ID, 'post_id' => $blog->ID];
                $wpdb->insert($table_matching, $data);
                // $born = true;

                array_push($data_historiq, $data);
                
                break;
            }
        }

      endforeach;

    endforeach;


    $response = new WP_REST_Response($data_historiq);
    $response->set_status(200);
    return $response;

  }
  
  function matchin_child_topics()
  {
    global $wpdb;
    $data_historiq = array();

    //Global posts 
    $args = array(
      'post_type' => array('post', 'course'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
    );
    $global_posts = get_posts($args);

    //Iteration courses to get corresponding topics                  
    foreach($global_posts as $blog):

      // Categories //
      $category_default = get_field('categories', $blog->ID);
      $categories_xml = get_field('category_xml', $blog->ID);
      $merge_categories_id = array();
  
      // Merge categories from customize and xml //
      if(!empty($category_default))
        foreach($category_default as $item)
          if($item)
            if($item['value'])
                if(!in_array($item['value'], $merge_categories_id))
                  array_push($merge_categories_id, $item['value']);
      else if(!empty($category_xml))
        foreach($category_xml as $item)
          if($item)
            if($item['value'])
              if(!in_array($item['value'], $merge_categories_id))
                  array_push($merge_categories_id, $item['value']);
              
      // Fit the category to course of
      $born = false;
      if(!empty($merge_categories_id))
        foreach($merge_categories_id as $value):
          $explode_categoriee = explode(',', $value);
          foreach($explode_categoriee as $categoriee){
            $categoriee = intval($categoriee);

            if(!$categoriee)
              continue;
            if(!is_int($categoriee))
              continue;

            $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}matchin_topics WHERE topic_id = %d AND post_id = %d", array($categoriee, $blog->ID));
            $iteration = $wpdb->get_results( $sql )[0];
        
            if($iteration)
              if($iteration != 0)
                break;
            
            // Insert matching course to each course record 
            $table_matching = $wpdb->prefix . 'matchin_topics';
            $data = ['topic_id' => $categoriee, 'post_id' => $blog->ID];
            $wpdb->insert($table_matching, $data);

            array_push($data_historiq, $data);
          }
        endforeach;

    endforeach;    

    $response = new WP_REST_Response($data_historiq);
    $response->set_status(200);
    return $response;

  }

  function get_related_course_by_category($data)
  {
    $category_id = $data['category_id'] ?? false;
    if (!$category_id)
    {
      $response = new WP_REST_Response("You have to fill the id of the topic !"); 
      $response->set_status(400);
      return $response;
    }
    global $wpdb;
    $sql = $wpdb->prepare("SELECT post_id FROM {$wpdb->prefix}matchin_topics WHERE topic_id = %d", array($category_id));
    $result = $wpdb->get_results( $sql );
    if (empty($result))
    {
      $response = new WP_REST_Response([]);
      $response->set_status(200);
      return $response;
    }
    $postIds= array();
    $outcome_courses = array();
    foreach ($result as $item) 
    {
      array_push($postIds,$item->post_id);
    }
    $args = array(
    'post_type' => array('course', 'post'), 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
    'post__in' => $postIds
    );
    $courses = get_posts($args);
    foreach ($courses as $i => $value) {
      $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
      $author = get_user_by( 'ID', $courses[$i] -> post_author  );
      $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
      if ($courses[$i]->visibility != []) 
        if ($author_company != $current_user_company)
          continue;
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
    return $outcome_courses;
    
  }

  function get_related_articles_by_category($data)
  {
    $category_id = $data['category_id'] ?? false;
    if (!$category_id)
    {
      $response = new WP_REST_Response("You have to fill the id of the topic !"); 
      $response->set_status(400);
      return $response;
    }
    global $wpdb;
    $sql = $wpdb->prepare("SELECT post_id FROM {$wpdb->prefix}matchin_topics WHERE topic_id = %d", array($category_id));
    $result = $wpdb->get_results( $sql );
    if (empty($result))
    {
      $response = new WP_REST_Response([]);
      $response->set_status(200);
      return $response;
    }
    $postIds= array();
    $outcome_courses = array();
    foreach ($result as $item) 
    {
      array_push($postIds,$item->post_id);
    }
    return $outcome_courses;
    $args = array(
    'post_type' => array('post'), 
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'order' => 'DESC',
    'post__in' => shuffle($postIds)
    );
    $results = new WP_Query($args);
    //return $results->posts;
    // $courses = array();
    $i = 0;
    $courses = $results->posts;
    if ($results->have_posts()) :  while ($results->have_posts()) : $results->the_post();
         $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
         $author = get_user_by( 'ID', $courses[$i] -> post_author  );
         $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
          if ($courses[$i]->visibility != [])
            if ($author_company != $current_user_company)
              continue;
              $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              $courses[$i]->experts = array();
              $experts = get_field('experts',$courses[$i]->ID);
              if(!empty($experts))
                foreach ($experts as $key => $expert) {
                  $expert = get_user_by( 'ID', $expert );
                  $experts_img = get_field('profile_img','user_'.$expert ->ID) ? get_field('profile_img','user_'.$expert ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                  array_push($courses[$i]->experts, new Expert ($expert,$experts_img));
                  }
              //return $courses;    
             $courses[$i]-> author = new Expert ($author , $author_img);
             $courses[$i]->longDescription = get_field('long_description',$courses[$i]->ID);
             $courses[$i]->shortDescription = get_field('short_description',$courses[$i]->ID);
             $courses[$i]->courseType = get_field('course_type',$courses[$i]->ID);
            // Image - article
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
             $courses[$i]->youtubeVideos =  []  ;
             $courses[$i]->podcasts = [];
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
                //  $handle = curl_init($courses[$i]->pathImage);
                //  curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
  
                 /* Get the HTML or whatever is linked in $url. */
                 //$response = curl_exec($handle);
  
                 /* Check for 200 (file ok). */
                //  $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                //  if($httpCode != 200) {
                //      /* Handle 404 here. */
                //      $courses[$i]->pathImage = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($courses[$i]->courseType) . '.jpg';
                //    }
                //  curl_close($handle);
                
             $new_course = new Course($courses[$i]);
             array_push($outcome_courses, $new_course);
              $i++;
  endwhile;
endif;
    return $outcome_courses;
  }

  function course_recommendation_by_follow($data)
  {
  // return $data['course_type'];
   $user_id = $GLOBALS['user_id'];
   $user_topics = get_user_topics($user_id);
   if(!empty($user_topics))
   {
     $Idtopics =array();
     foreach ($user_topics as $key => $topic) 
     {
      array_push($Idtopics, $topic->term_id);
     }
      $Idtopics_string = "'" . implode(",",$Idtopics) ."'";
      global $wpdb;
      $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}matchin_topics WHERE topic_id IN ($Idtopics_string)");
      $result = $wpdb->get_results( $sql );
      $postIds= array();
      $outcome_courses = array();
      foreach ($result as $item) 
      {
        array_push($postIds,$item->post_id);
      }
      $args = array(
        'post_type' => array('course', 'post'), 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'post__in' => $postIds,
        'meta_key' => 'course_type',
        'meta_value' => $data['course_type'] ?? ''
        );
        $courses = get_posts($args);
        foreach ($courses as $i => $value) {
          $courses[$i]->visibility = get_field('visibility',$courses[$i]->ID) ?? [];
          $author = get_user_by( 'ID', $courses[$i] -> post_author  );
          $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
          if ($courses[$i]->visibility != []) 
            if ($author_company != $current_user_company)
              continue;
              $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
        shuffle($outcome_courses);
        return $outcome_courses ;
   }
   else
   {
    return [];
   }
  }

  /**
   * Internal Courses
   */

  //  function optimizeFetchInternalCourses ()
  //  {
  //       global $wpdb;

  //       $current_user_id = $GLOBALS['user_id'] ?? 0;
  //       if ($current_user_id == 0)
  //       {
  //         $response = new WP_REST_Response("You have to login with good credentials !"); 
  //         $response->set_status(400);
  //         return $response;
  //       }

  //       // Préparer la réponse
  //       $response = array(
  //         'all' => array(),
  //         'department' => array(),
  //         'individual' => array(),
  //     );

  //       $current_user = get_user_by('id', (int) $current_user_id);
  //       $current_user_company = is_array( get_field('company', 'user_' . (int) $current_user_id) ) ? get_field('company', 'user_' . (int) $current_user_id)[0] : get_field('company', 'user_' . (int) $current_user_id);
  //       if ($current_user_company == null || $current_user_company ==false)
  //         return rest_ensure_response($response);

  //       $users = get_users();
  //       $teamates = array();
  //       // foreach ($users as $key => $user)
  //       // {
  //       //   $user_company =  is_array( get_field('company', 'user_' . (int) $current_user_id) ) ? get_field('company', 'user_' . (int) $current_user_id)[0] : get_field('company', 'user_' . (int) $current_user_id);;
  //       //   if ($current_user_company != null && $current_user_company !=false)
  //       //     if ($user_company->ID == $current_user_company->ID)
  //       //       array_push($teamates,$user->ID);
  //       // }
  //       // array_push($teamates,$current_user_id);
  //       // $query =
  //       //   array(
  //       //     'post_type' => array('post','course'),
  //       //     'post_status' => 'publish',
  //       //     'posts_per_page' => -1,
  //       //     'order' => 'DESC',
  //       //     'author__in' => $teamates
  //       //   );
  //       // $courses = get_posts($query);
        
  //       // foreach ($courses as $key => $course) {
  //       //   $course->visibility = get_field('visibility',$course->ID) ?? [];
  //       //   if ($course->visibility != [])
  //       //   {
  //       //       $course->visibility = get_field('visibility',$course->ID) ?? [];
  //       //       $author = get_user_by( 'ID', $course -> post_author  );
  //       //       $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
  //       //       if ($course->visibility != []) 
  //       //         if ($author_company != $current_user_company)
  //       //           continue;
  //       //         $author = get_user_by( 'ID', $course -> post_author  );
  //       //         $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  //       //         $course-> author = new Expert ($author , $author_img);
  //       //         $course->longDescription = get_field('long_description',$course->ID);
  //       //         $course->shortDescription = get_field('short_description',$course->ID);
  //       //         $course->courseType = get_field('course_type',$course->ID);
  //       //         //Image - article
  //       //         $image = get_field('preview', $course->ID)['url'];
  //       //         if(!$image){
  //       //             $image = get_the_post_thumbnail_url($course->ID);
  //       //             if(!$image)
  //       //                 $image = get_field('url_image_xml', $course->ID);
  //       //                     if(!$image)
  //       //                         $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
  //       //         }
  //       //         $course->pathImage = $image;
  //       //         $course->price = get_field('price',$course->ID);
  //       //         $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
  //       //         if (strtolower($course->courseType) == 'podcast')
  //       //           {
  //       //             $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
  //       //             if (!empty($podcasts))
  //       //                 $course->podcasts = $podcasts;
  //       //               else {
  //       //                 $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
  //       //                 if (!empty($podcasts))
  //       //                 {
  //       //                   $course->podcasts = array();
  //       //                   foreach ($podcasts as $key => $podcast) 
  //       //                   { 
  //       //                     $item= array(
  //       //                       "course_podcast_title"=>$podcast['podcast_title'], 
  //       //                       "course_podcast_intro"=>$podcast['podcast_description'],
  //       //                       "course_podcast_url" => $podcast['podcast_url'],
  //       //                       "course_podcast_image" => $podcast['podcast_image'],
  //       //                     );
  //       //                     array_push ($course->podcasts,($item));
  //       //                   }
  //       //                 }
  //       //             }
  //       //           }
  //       //         $course->podcasts = $course->podcasts != [] && gettype($course->podcasts) != "string" && $course->podcasts != null ? $course->podcasts : [] ;
  //       //         $course->visibility = get_field('visibility',$course->ID);
  //       //         $course->connectedProduct = get_field('connected_product',$course->ID);
  //       //         $tags = get_field('categories',$course->ID) ?? [];
  //       //         $course->tags= array();
  //       //         if($tags)
  //       //           if (!empty($tags))
  //       //             foreach ($tags as $key => $category) 
  //       //               if(isset($category['value'])){
  //       //                 $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
  //       //                 array_push($course->tags,$tag);
  //       //               }
                    
  //       //         array_push($response["all"]  ,new Course($course));
                
  //       //   }
        
  //       // }
        
        
  //         // Get params
  //         $company_id = $current_user_company->ID;
  //         $departement_value = get_field('department', 'user_' . (int) $current_user_id);
  //         $individual_value = $current_user->ID;
          
  //         $query_all = $wpdb->prepare(
  //             "SELECT * FROM wpe7_internal_courses WHERE company_id = %d AND type = 'all'",
  //             $company_id
  //         );

  //         $query_departement = $wpdb->prepare(
  //             "SELECT * FROM wpe7_internal_courses WHERE type = 'department' AND company_id = %d AND data_value = %s ",
  //             $company_id,$departement_value
  //         );

  //         $query_individual = $wpdb->prepare(
  //             "SELECT * FROM wpe7_internal_courses WHERE type = 'individual' AND company_id = %d  AND data_value = %s" ,
  //             $company_id,$individual_value
  //         );

  //         // Exécuter les requêtes
  //         $results_all = $wpdb->get_results($query_all);
  //         $results_departement = $wpdb->get_results($query_departement);
  //         $results_individual = $wpdb->get_results($query_individual);


          
          

  //         $results_all_ids = array();

  //         foreach ($results_all as $row) {
  //           array_push($results_all_ids,$row->course_id);
  //         }

  //         $courses = get_posts(
  //           array
  //           (
  //             'post_type' => array('course', 'post'),
  //             'post__in' => $results_all_ids
  //           )
  //         );
        
        
          
  //       // Get internal courses with "all" from db
  //       foreach ($courses as $key => $course) 
  //       {
  //             $course->visibility = get_field('visibility',$course->ID) ?? [];
  //             $course->visibility = get_field('visibility',$course->ID) ?? [];
  //             $author = get_user_by( 'ID', $course -> post_author  );
  //             $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
  //             if ($course->visibility != []) 
  //               if ($author_company != $current_user_company)
  //                 continue;
  //               $author = get_user_by( 'ID', $course -> post_author  );
  //               $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  //               $course-> author = new Expert ($author , $author_img);
  //               $course->longDescription = get_field('long_description',$course->ID);
  //               $course->shortDescription = get_field('short_description',$course->ID);
  //               $course->courseType = get_field('course_type',$course->ID);
  //               //Image - article
  //               $image = get_field('preview', $course->ID)['url'];
  //               if(!$image){
  //                   $image = get_the_post_thumbnail_url($course->ID);
  //                   if(!$image)
  //                       $image = get_field('url_image_xml', $course->ID);
  //                           if(!$image)
  //                               $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
  //               }
  //               $course->pathImage = $image;
  //               $course->price = get_field('price',$course->ID);
  //               $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
  //               if (strtolower($course->courseType) == 'podcast')
  //                 {
  //                   $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
  //                   if (!empty($podcasts))
  //                       $course->podcasts = $podcasts;
  //                     else {
  //                       $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
  //                       if (!empty($podcasts))
  //                       {
  //                         $course->podcasts = array();
  //                         foreach ($podcasts as $key => $podcast) 
  //                         { 
  //                           $item= array(
  //                             "course_podcast_title"=>$podcast['podcast_title'], 
  //                             "course_podcast_intro"=>$podcast['podcast_description'],
  //                             "course_podcast_url" => $podcast['podcast_url'],
  //                             "course_podcast_image" => $podcast['podcast_image'],
  //                           );
  //                           array_push ($course->podcasts,($item));
  //                         }
  //                       }
  //                   }
  //                 }
  //               $course->podcasts = $course->podcasts ?? [];
  //               $course->visibility = get_field('visibility',$course->ID);
  //               $course->connectedProduct = get_field('connected_product',$course->ID);
  //               $tags = get_field('categories',$course->ID) ?? [];
  //               $course->tags= array();
  //               if($tags)
  //                 if (!empty($tags))
  //                   foreach ($tags as $key => $category) 
  //                     if(isset($category['value'])){
  //                       $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
  //                       array_push($course->tags,$tag);
  //                     }
  //               array_push($response["all"] ,new Course($course));
          
  //       }

  //       if (count($response['all']) > 0)
  //         $response['all'] = array_reverse($response['all']);

  //       $results_departement_ids = array();

  //         foreach ($results_departement as $row) {
  //           array_push($results_departement_ids,$row->course_id);
  //         }

  //         $courses = get_posts(
  //           array
  //           (
  //             'post_type' => array('course', 'post'),
  //             'post__in' => $results_departement_ids
  //           )
  //         );
  //       // Get internal courses with "departemnt" type from db
  //       foreach ($courses as $key => $course) 
  //       {
  //           $course->visibility = get_field('visibility',$course->ID) ?? [];
  //             $course->visibility = get_field('visibility',$course->ID) ?? [];
  //             $author = get_user_by( 'ID', $course -> post_author  );
  //             $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
  //             if ($course->visibility != []) 
  //               if ($author_company != $current_user_company)
  //                 continue;
  //               $author = get_user_by( 'ID', $course -> post_author  );
  //               $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  //               $course-> author = new Expert ($author , $author_img);
  //               $course->longDescription = get_field('long_description',$course->ID);
  //               $course->shortDescription = get_field('short_description',$course->ID);
  //               $course->courseType = get_field('course_type',$course->ID);
  //               //Image - article
  //               $image = get_field('preview', $course->ID)['url'];
  //               if(!$image){
  //                   $image = get_the_post_thumbnail_url($course->ID);
  //                   if(!$image)
  //                       $image = get_field('url_image_xml', $course->ID);
  //                           if(!$image)
  //                               $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
  //               }
  //               $course->pathImage = $image;
  //               $course->price = get_field('price',$course->ID);
  //               $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
  //               if (strtolower($course->courseType) == 'podcast')
  //                 {
  //                   $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
  //                   if (!empty($podcasts))
  //                       $course->podcasts = $podcasts;
  //                     else {
  //                       $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
  //                       if (!empty($podcasts))
  //                       {
  //                         $course->podcasts = array();
  //                         foreach ($podcasts as $key => $podcast) 
  //                         { 
  //                           $item= array(
  //                             "course_podcast_title"=>$podcast['podcast_title'], 
  //                             "course_podcast_intro"=>$podcast['podcast_description'],
  //                             "course_podcast_url" => $podcast['podcast_url'],
  //                             "course_podcast_image" => $podcast['podcast_image'],
  //                           );
  //                           array_push ($course->podcasts,($item));
  //                         }
  //                       }
  //                   }
  //                 }
  //               $course->podcasts = $course->podcasts ?? [];
  //               $course->visibility = get_field('visibility',$course->ID);
  //               $course->connectedProduct = get_field('connected_product',$course->ID);
  //               $tags = get_field('categories',$course->ID) ?? [];
  //               $course->tags= array();
  //               if($tags)
  //                 if (!empty($tags))
  //                   foreach ($tags as $key => $category) 
  //                     if(isset($category['value'])){
  //                       $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
  //                       array_push($course->tags,$tag);
  //                     }
  //               array_push($response["department"] ,new Course($course));
          
  //       }

  //       if (count($response['department']) > 0)
  //         $response['department'] = array_reverse($response['department']);
          
  //       $results_individual_ids = array();

  //         foreach ($results_individual as $row) {
  //           array_push($results_individual_ids,$row->course_id);
  //         }

  //         $courses = get_posts(
  //           array
  //           (
  //             'post_type' => array('course', 'post'),
  //             'post__in' => $results_individual_ids
  //           )
  //         );
  //       // Get internal courses with "individual" type from db
  //       foreach ($courses as $key => $course) 
  //       {
  //             $course->visibility = get_field('visibility',$course->ID) ?? [];
  //             $course->visibility = get_field('visibility',$course->ID) ?? [];
  //             $author = get_user_by( 'ID', $course -> post_author  );
  //             $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
  //             if ($course->visibility != []) 
  //               if ($author_company != $current_user_company)
  //                 continue;
  //               $author = get_user_by( 'ID', $course -> post_author  );
  //               $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  //               $course-> author = new Expert ($author , $author_img);
  //               $course->longDescription = get_field('long_description',$course->ID);
  //               $course->shortDescription = get_field('short_description',$course->ID);
  //               $course->courseType = get_field('course_type',$course->ID);
  //               //Image - article
  //               $image = get_field('preview', $course->ID)['url'];
  //               if(!$image){
  //                   $image = get_the_post_thumbnail_url($course->ID);
  //                   if(!$image)
  //                       $image = get_field('url_image_xml', $course->ID);
  //                           if(!$image)
  //                               $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
  //               }
  //               $course->pathImage = $image;
  //               $course->price = get_field('price',$course->ID);
  //               $course->youtubeVideos = get_field('youtube_videos',$course->ID) ? get_field('youtube_videos',$course->ID) : []  ;
  //               if (strtolower($course->courseType) == 'podcast')
  //                 {
  //                   $podcasts = get_field('podcasts',$course->ID) ? get_field('podcasts',$course->ID) : [];
  //                   if (!empty($podcasts))
  //                       $course->podcasts = $podcasts;
  //                     else {
  //                       $podcasts = get_field('podcasts_index',$course->ID) ? get_field('podcasts_index',$course->ID) : [];
  //                       if (!empty($podcasts))
  //                       {
  //                         $course->podcasts = array();
  //                         foreach ($podcasts as $key => $podcast) 
  //                         { 
  //                           $item= array(
  //                             "course_podcast_title"=>$podcast['podcast_title'], 
  //                             "course_podcast_intro"=>$podcast['podcast_description'],
  //                             "course_podcast_url" => $podcast['podcast_url'],
  //                             "course_podcast_image" => $podcast['podcast_image'],
  //                           );
  //                           array_push ($course->podcasts,($item));
  //                         }
  //                       }
  //                   }
  //                 }
  //               $course->podcasts = $course->podcasts ?? [];
  //               $course->visibility = get_field('visibility',$course->ID);
  //               $course->connectedProduct = get_field('connected_product',$course->ID);
  //               $tags = get_field('categories',$course->ID) ?? [];
  //               $course->tags= array();
  //               if($tags)
  //                 if (!empty($tags))
  //                   foreach ($tags as $key => $category) 
  //                     if(isset($category['value'])){
  //                       $tag = new Tags($category['value'],get_the_category_by_ID($category['value']));
  //                       array_push($course->tags,$tag);
  //                     }
  //               array_push($response["individual"] ,new Course($course));
          
  //       }

  //       if (count($response['individual']) > 0)
  //         $response['individual'] = array_reverse($response['individual']);

  //       return rest_ensure_response($response);
  // }

  function optimizeFetchInternalCourses($data) {
    global $wpdb;
    // Retrieve the user ID from the global variable and validate it
    $current_user_id = false;
    $current_user_id = isset($data['userID']) ? $data['userID'] : $GLOBALS['user_id'];
    
    if ($current_user_id == 0) 
      return new WP_REST_Response("You have to login with good credentials !", 400);

    $response = [
      'all' => [],
      'department' => [],
      'individual' => [],
    ];

    $current_user = get_user_by('id', (int) $current_user_id);
    $current_user_company = get_field('company', 'user_' . (int) $current_user_id);
    $current_user_company = is_array($current_user_company) ? $current_user_company[0] : $current_user_company;

    if (!$current_user_company) {
        return rest_ensure_response($response);
    }

    $company_id = $current_user_company->ID;
    $departement_value = get_field('department', 'user_' . (int) $current_user_id);
    $individual_value = $current_user->ID;

    // Requête pour les cours de type "all"
    $query_all = "SELECT * FROM wpe7_internal_courses WHERE company_id = %d AND type = 'all'";
    $prepared_query_all = $wpdb->prepare($query_all, [$company_id]);
    $results_all = $wpdb->get_results($prepared_query_all);

    // Requête pour les cours de type "department"
    $query_department = "SELECT * FROM wpe7_internal_courses WHERE company_id = %d AND type = 'department' AND data_value = %s";
    $prepared_query_department = $wpdb->prepare($query_department, [$company_id, $departement_value]);
    $results_department = $wpdb->get_results($prepared_query_department);

    // Requête pour les cours de type "individual"
    $query_individual = "SELECT * FROM wpe7_internal_courses WHERE company_id = %d AND type = 'individual' AND data_value = %s";
    $prepared_query_individual = $wpdb->prepare($query_individual, [$company_id, $individual_value]);
    $results_individual = $wpdb->get_results($prepared_query_individual);

    // Traitement des résultats pour "all"
    if (!empty($results_all)) {
        $results_all_ids = array_map(function($row) {
            return $row->course_id;
        }, $results_all);

        $courses = get_posts([
            'post_type'      => ['course', 'post'],
            'post__in'       => $results_all_ids,
            'posts_per_page' => -1,
        ]);

        foreach ($courses as $course) {
            $author = get_user_by('ID', $course->post_author);
            $author_company = get_field('company', 'user_' . (int) $author->ID);
            $author_company = is_array($author_company) ? $author_company[0] : $author_company;
            // if ($author_company->ID !== $company_id) {
            //     continue;
            // }
            $author_img = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            // Formatage du cours
            $course->author = new Expert($author, $author_img);
            $course->longDescription = get_field('long_description', $course->ID);
            $course->shortDescription = get_field('short_description', $course->ID);
            $course->courseType = get_field('course_type', $course->ID);
            $course->visibility = get_field('visibility', $course->ID);
            $course->connectedProduct = get_field('connected_product', $course->ID);

            $image = (get_field('preview', $course->ID)['url'] ?? null) 
                ?: get_the_post_thumbnail_url($course->ID) 
                ?: get_field('url_image_xml', $course->ID);
            $course->pathImage = $image ?: get_stylesheet_directory_uri() . '/img/' . strtolower($course->courseType) . '.jpg';

            $course->youtubeVideos = get_field('youtube_videos', $course->ID) ?: [];
            $course->podcasts = get_field('podcasts', $course->ID) ?: [];
            if (strtolower($course->courseType) === 'podcast' && empty($course->podcasts)) {
                $podcasts = get_field('podcasts_index', $course->ID) ?: [];
                foreach ($podcasts as $podcast) {
                    $course->podcasts[] = [
                        "course_podcast_title" => $podcast['podcast_title'],
                        "course_podcast_intro" => $podcast['podcast_description'],
                        "course_podcast_url"   => $podcast['podcast_url'],
                        "course_podcast_image" => $podcast['podcast_image'],
                    ];
                }
            }
            $tags = get_field('categories', $course->ID) ?: [];
            $course->tags = [];
            foreach ($tags as $category) {
                if (isset($category['value'])) {
                    $course->tags[] = new Tags($category['value'], get_the_category_by_ID($category['value']));
                }
            }
            $response['all'][] = new Course($course);
        }
    }

    // Traitement des résultats pour "department"
    if (!empty($results_department)) {
        $results_department_ids = array_map(function($row) {
            return $row->course_id;
        }, $results_department);

        $courses = get_posts([
            'post_type'      => ['course', 'post'],
            'post__in'       => $results_department_ids,
            'posts_per_page' => -1,
        ]);

        foreach ($courses as $course) {
            $author = get_user_by('ID', $course->post_author);
            $author_company = get_field('company', 'user_' . (int) $author->ID);
            $author_company = is_array($author_company) ? $author_company[0] : $author_company;
            // if ($author_company->ID !== $company_id) {
            //     continue;
            // }
            $author_img = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            $course->author = new Expert($author, $author_img);
            $course->longDescription = get_field('long_description', $course->ID);
            $course->shortDescription = get_field('short_description', $course->ID);
            $course->courseType = get_field('course_type', $course->ID);
            $course->visibility = get_field('visibility', $course->ID);
            $course->connectedProduct = get_field('connected_product', $course->ID);

            $image = (get_field('preview', $course->ID)['url'] ?? null)
                ?: get_the_post_thumbnail_url($course->ID)
                ?: get_field('url_image_xml', $course->ID);
            $course->pathImage = $image ?: get_stylesheet_directory_uri() . '/img/' . strtolower($course->courseType) . '.jpg';

            $course->youtubeVideos = get_field('youtube_videos', $course->ID) ?: [];
            $course->podcasts = get_field('podcasts', $course->ID) ?: [];
            if (strtolower($course->courseType) === 'podcast' && empty($course->podcasts)) {
                $podcasts = get_field('podcasts_index', $course->ID) ?: [];
                foreach ($podcasts as $podcast) {
                    $course->podcasts[] = [
                        "course_podcast_title" => $podcast['podcast_title'],
                        "course_podcast_intro" => $podcast['podcast_description'],
                        "course_podcast_url"   => $podcast['podcast_url'],
                        "course_podcast_image" => $podcast['podcast_image'],
                    ];
                }
            }
            $tags = get_field('categories', $course->ID) ?: [];
            $course->tags = [];
            foreach ($tags as $category) {
                if (isset($category['value'])) {
                    $course->tags[] = new Tags($category['value'], get_the_category_by_ID($category['value']));
                }
            }
            $response['department'][] = new Course($course);
        }
    }

    // Traitement des résultats pour "individual"
    if (!empty($results_individual)) {
        $results_individual_ids = array_map(function($row) {
            return $row->course_id;
        }, $results_individual);

        $courses = get_posts([
            'post_type'      => ['course', 'post'],
            'post__in'       => $results_individual_ids,
            'posts_per_page' => -1,
        ]);

        foreach ($courses as $course) {
            $author = get_user_by('ID', $course->post_author);
            $author_company = get_field('company', 'user_' . (int) $author->ID);
            $author_company = is_array($author_company) ? $author_company[0] : $author_company;
            // if ($author_company->ID !== $company_id) {
            //     continue;
            // }
            $author_img = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            $course->author = new Expert($author, $author_img);
            $course->longDescription = get_field('long_description', $course->ID);
            $course->shortDescription = get_field('short_description', $course->ID);
            $course->courseType = get_field('course_type', $course->ID);
            $course->visibility = get_field('visibility', $course->ID);
            $course->connectedProduct = get_field('connected_product', $course->ID);

            $image = (get_field('preview', $course->ID)['url'] ?? null)
                ?: get_the_post_thumbnail_url($course->ID)
                ?: get_field('url_image_xml', $course->ID);
            $course->pathImage = $image ?: get_stylesheet_directory_uri() . '/img/' . strtolower($course->courseType) . '.jpg';

            $course->youtubeVideos = get_field('youtube_videos', $course->ID) ?: [];
            $course->podcasts = get_field('podcasts', $course->ID) ?: [];
            if (strtolower($course->courseType) === 'podcast' && empty($course->podcasts)) {
                $podcasts = get_field('podcasts_index', $course->ID) ?: [];
                foreach ($podcasts as $podcast) {
                    $course->podcasts[] = [
                        "course_podcast_title" => $podcast['podcast_title'],
                        "course_podcast_intro" => $podcast['podcast_description'],
                        "course_podcast_url"   => $podcast['podcast_url'],
                        "course_podcast_image" => $podcast['podcast_image'],
                    ];
                }
            }
            $tags = get_field('categories', $course->ID) ?: [];
            $course->tags = [];
            foreach ($tags as $category) {
                if (isset($category['value'])) {
                    $course->tags[] = new Tags($category['value'], get_the_category_by_ID($category['value']));
                }
            }
            $response['individual'][] = new Course($course);
        }
    }

    return rest_ensure_response($response);
}


/**
  * Internal Courses
*/ 
function getUserInternalCourses($data) {
  
  global $wpdb;
  // Retrieve the user ID from the global variable and validate it
  $current_user_id = false;
  $current_user_id = isset($data['userID']) ? $data['userID'] : $GLOBALS['user_id'];

  // Check if the user ID is provided
  if (!$current_user_id) 
  {
    $response = new WP_REST_Response("You have to login with valid credentials!");
    $response->set_status(400);
    return $response;
  }

  // Préparer la réponse
  $response = array(
    'all' => array(),
    'team' => array(),
    'mandatored' => array(),
  );

  $current_user = get_user_by('id', (int) $current_user_id);
  $current_user_company = get_field('company', 'user_' . (int) $current_user_id)[0];

  $users = get_users();
  $teamates = array();
  foreach ($users as $key => $user)
  {
    $user_company =  get_field('company', 'user_' . (int) $user->ID)[0];
    if ($user_company->ID == $current_user_company->ID)
      array_push($teamates,$user->ID);
  }
  array_push($teamates,$current_user_id);
  $query =
    array(
      'post_type' => array('post','course'),
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'order' => 'DESC',
      'author__in' => $teamates
    );
  $courses = get_posts($query);
  
  foreach ($courses as $key => $course) {
    $course->visibility = get_field('visibility',$course->ID) ?? [];
    if ($course->visibility != [])
    {
        $course->visibility = get_field('visibility',$course->ID) ?? [];
        $author = get_user_by( 'ID', $course -> post_author  );
        $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
        if ($course->visibility != []) 
          if ($author_company != $current_user_company)
            continue;
          $author = get_user_by( 'ID', $course -> post_author  );
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
               
          array_push($response["all"]  ,new Course($course));      
    }
  }
  
  // Get params
  $company_id = $current_user_company->ID;
  $departement_value = get_field('department', 'user_' . (int) $current_user_id);
  $individual_value = $current_user->ID;
  
  $query_all = $wpdb->prepare(
      "SELECT * FROM wpe7_internal_courses WHERE company_id = %d AND type = 'all'",
      $company_id
  );

  $query_departement = $wpdb->prepare(
      "SELECT * FROM wpe7_internal_courses WHERE type = 'department' AND data_value = %s",
      $departement_value
  );

  $query_individual = $wpdb->prepare(
      "SELECT * FROM wpe7_internal_courses WHERE type = 'individual' AND data_value = %s",
      $individual_value
  );

  // Exécuter les requêtes
  $results_all = $wpdb->get_results($query_all);
  $results_departement = $wpdb->get_results($query_departement);
  $results_individual = $wpdb->get_results($query_individual);

  $results_all_ids = array();

  foreach ($results_all as $row) 
    array_push($results_all_ids,$row->course_id);

  $courses = get_posts(
    array
    (
      'post_type' => array('course', 'post'),
      'post__in' => $results_all_ids
    )
  );
    
  // Get internal courses with "all" from db
  foreach ($courses as $key => $course) 
  {    
    $course->visibility = get_field('visibility',$course->ID) ?? [];
    $author = get_user_by( 'ID', $course -> post_author  );
    $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
    if ($course->visibility != []) 
      if ($author_company != $current_user_company)
        continue;
      $author = get_user_by( 'ID', $course -> post_author  );
      $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
      array_push($response["all"] ,new Course($course));
  }
  

  if (count($response['all']) > 0)
    $response['all'] = array_reverse($response['all']);

  $results_departement_ids = array();

  foreach ($results_departement as $row) 
    array_push($results_departement_ids, $row->course_id);

  $courses = get_posts(
    array
    (
      'post_type' => array('course', 'post'),
      'post__in' => $results_departement_ids
    )
  );
  // Get internal courses with "departemnt" type from db
  foreach ($courses as $key => $course) {

    $course->visibility = get_field('visibility',$course->ID) ?? [];
    $author = get_user_by( 'ID', $course -> post_author  );
    $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
    if ($course->visibility != []) 
      if ($author_company != $current_user_company)
        continue;

    $author = get_user_by( 'ID', $course -> post_author  );
    $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          
    array_push($response["team"] ,new Course($course));
  }

  if (count($response['team']) > 0)
    $response['team'] = array_reverse($response['team']);
    
  $results_individual_ids = array();

    foreach ($results_individual as $row) {
      array_push($results_individual_ids,$row->course_id);
    }

    $courses = get_posts(
      array
      (
        'post_type' => array('course', 'post'),
        'post__in' => $results_individual_ids
      )
    );
  // Get internal courses with "individual" type from db
  foreach ($courses as $key => $course) 
  {
        $course->visibility = get_field('visibility',$course->ID) ?? [];
        $course->visibility = get_field('visibility',$course->ID) ?? [];
        $author = get_user_by( 'ID', $course -> post_author  );
        $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
        if ($course->visibility != []) 
          if ($author_company != $current_user_company)
            continue;
          $author = get_user_by( 'ID', $course -> post_author  );
          $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
          array_push($response["mandatored"] ,new Course($course));
    
  }

  if (count($response['mandatored']) > 0)
    $response['mandatored'] = array_reverse($response['mandatored']);

  return rest_ensure_response($response);
}

  /** 
   * Statistics Endpoints
  */
       function get_user_views($user_id)
       {
          global $wpdb;
          $table_tracker_views = $wpdb->prefix . 'tracker_views';
          $user_id = $request['user_id'] ?? false;
          $sql = $wpdb->prepare( "SELECT data_id FROM $table_tracker_views WHERE user_id = $user_id");
          $results = $wpdb->get_results( $sql );
          $datas_id = array();
          if (empty($results))
          {
            return [];
          }
          foreach ($results as $key => $value) {
            array_push( $datas_id, $value->data_id);
          }
          $courses = get_posts(
            array
            (
              'post_type' => array('course', 'post'),
              'post__in' => $datas_id
            )
          );
          return $courses;
       }

       function getUserCourseStastics ($data)
       {
          
          $user_id = $GLOBALS['user_id'];
          $courses = get_user_views($user_id);
          $courses;
       }

      function getUserStatistics($user_id)
      {
          global $wpdb;
          $user_statistics_table = $wpdb->prefix . 'user_statistics';
          $select_query = "SELECT * FROM $user_statistics_table WHERE user_id = $user_id";
          $insert_query = "INSERT INTO $user_statistics_table (`id`, `podcast`, `artikel`, `video`, `online`, `location`, `user_id`) VALUES (NULL, '0', '0', '0', '0', '0', $user_id)";
          $sql = $wpdb->prepare( $select_query );
          $results = $wpdb->get_results($sql)[0];
          if (empty($results))
          { 
            $sql = $wpdb->prepare($insert_query);
            $wpdb->query($sql);
            $sql = $wpdb->prepare( $select_query );
            $results = $wpdb->get_results($sql)[0];
          }
          return $results;
      }

      function formatSecondes($secondes) {
        $heures = floor($secondes / 3600);
        $minutes = floor(($secondes % 3600) / 60);
        $secondes = $secondes % 60;
        return sprintf("%dh %dmn %ds", $heures, $minutes, $secondes);
    }

      function getStatisticsOfCourseType (WP_REST_Request $request)
      {
        $user_id = $request['user_id'];
        if (!$user_id)
        {
          $response = new WP_REST_Response("You have to fill the id of the current user !"); 
          $response->set_status(400);
          return $response;
        }
        $user = get_user_by( 'ID', $user_id ) ?? false;
        if (!$user)
        {
          $response = new WP_REST_Response("This user id filled doesn't exist !");
          $response->set_status(400);
          return $response;
        }
        $courses = get_user_views($user_id);
        return $courses; 
      }
      
      function timeSpentOnAllCourseType($data)
      {
        $user_id = $data['user_id'] ?? false;
        if (!$user_id)
        {
          $response = new WP_REST_Response("You have to fill the id of the current user !"); 
          $response->set_status(400);
          return $response;
        }
        $user = get_user_by( 'ID', $user_id ) ?? false;
        if (!$user)
        {
          $response = new WP_REST_Response("This user id filled doesn't exist !");
          $response->set_status(400);
          return $response;
        } 
          $results = getUserStatistics($user_id);
          foreach ($results as $key => $result) {
            if ($key == 'id' || $key == 'user_id')
              continue;
             $results->$key = formatSecondes($results->$key);
          }
          return $results;
      }

      function updateTimeSpentOnCourseType(WP_REST_Request $request)
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
          $response = new WP_REST_Response("This user id filled doesn't exist !");
          $response->set_status(400);
          return $response;
        }
        $courseType = $request['course_type'] ?? false;
        if (!$courseType)
        {
          $response = new WP_REST_Response("You have to fill the course type !"); 
          $response->set_status(400);
          return $response;
        }
        $newTimeValue = (int)$request['time_spent'] ?? false;
        if (!$newTimeValue)
        {
          $response = new WP_REST_Response("You have to fill the time spent for the episode !"); 
          $response->set_status(400);
          return $response;
        }
        global $wpdb;
        $user_statistics_table = $wpdb->prefix . 'user_statistics';
        $sql = $wpdb->prepare("SELECT $courseType FROM $user_statistics_table WHERE user_id = $user_id");
        $timeSpentinSecond = ((int)getUserStatistics($user_id)->$courseType + $newTimeValue);
        $sql = $wpdb->prepare("UPDATE $user_statistics_table SET $courseType = ($timeSpentinSecond)  WHERE user_id = $user_id");
        (int)$wpdb->get_results($sql)[0];
        return $timeSpentinSecond;
      }

      // function getUserSubtopicsStatistics($data)
      // {
      //   $user_id = $GLOBALS['user_id'] ?? false;
        
      //   if (!$user_id)
      //   {
      //     $response = new WP_REST_Response("You have to login with good credentials !"); 
      //     $response->set_status(400);
      //     return $response;
      //   }
      //   $user = get_user_by( 'ID', $user_id ) ?? false;
      //   if (!$user)
      //   {
      //     $response = new WP_REST_Response("This user id filled doesn't exist !");
      //     $response->set_status(400);
      //     return $response;
      //   }
      //   global $wpdb;
      //   $table = $wpdb->prefix . 'user_subtopics_statistics';
      //   $sql = $wpdb->prepare("SELECT * FROM $table WHERE user_id = $user_id");
      //   $stats= $wpdb->get_results($sql);
      //   foreach ($stats as $stat)
      //   {
      //     $stat->time_spent = formatSecondes($stat->time_spent);  
      //   }
        
      //   return $stats;
      // }

      function getUserSubtopicsStatistics($data)
      {

        // Retrieve the user ID from the global variable and validate it
        $user_id = false;
        $user_id = isset($data['userID']) ? $data['userID'] : $GLOBALS['user_id'];

        // Check if the user ID is provided
        if (!$user_id) 
        {
          $response = new WP_REST_Response("You have to login with valid credentials!");
          $response->set_status(400);
          return $response;
        }

        // Validate the user ID
        $user_id = intval($user_id);

        // Check if the user exists
        $user = get_user_by('ID', $user_id);
        if (!$user)
        {
            $response = new WP_REST_Response("This user ID does not exist!");
            $response->set_status(400);
            return $response;
        }

        // Retrieve user subtopics statistics from the database
        global $wpdb;
        $table = $wpdb->prefix . 'user_subtopics_statistics';
        $sql = $wpdb->prepare("SELECT * FROM $table WHERE user_id = %d", $user_id);
        $stats = $wpdb->get_results($sql);

        // Define the allowed course types
        $allowed_course_types = ['masterclass', 'podcast', 'video', 'workshop', 'artikel', 'opleidingen'];

        // Sort statistics by time_spent in descending order
      usort($stats, function ($a, $b) {
        return $b->time_spent - $a->time_spent;
      });

        // Format the time spent for each statistic
        foreach ($stats as $stat)
        {
          // Format the total time spent
          $stat->time_spent = formatSecondes($stat->time_spent);

          // Format the time spent for each course type
          foreach ($allowed_course_types as $course_type)
          {
              if (isset($stat->$course_type)) {
                  $stat->$course_type = formatSecondes($stat->$course_type);
              }
          }
        }

        

        return $stats;
      } 

      // function updateUserSubtopicsStatistics(WP_REST_Request $request) 
      // {
      //   // Retrieve the user ID, 
      //   $user_id = $request['user_id'] ?? false;
    
      //   // Check if the user ID is provided
      //   if (!$user_id) {
      //       $response = new WP_REST_Response("You have to fill the id of the current user!");
      //       $response->set_status(400);
      //       return $response;
      //   }
    
      //   // Check if the user exists
      //   $user = get_user_by('ID', $user_id);
      //   if (!$user) {
      //       $response = new WP_REST_Response("This user id filled doesn't exist!");
      //       $response->set_status(400);
      //       return $response;
      //   }
    
      //   // Retrieve the category ID, 
      //   $category_id = $request['category_id'] ?? false;
      //   if (!$category_id) {
      //       $response = new WP_REST_Response("You have to fill the category id!");
      //       $response->set_status(400);
      //       return $response;
      //   }
        
      //   // Retrieve the category name, 
      //   $category_name = $request['category_name'] ?? false;
      //   if (!$category_id) {
      //       $response = new WP_REST_Response("You have to fill the category name!");
      //       $response->set_status(400);
      //       return $response;
      //   }
    
      //   // Retrieve the time spent, 
      //   $time_spent = $request['time_spent'] ?? false;
      //   if (!$time_spent) {
      //       $response = new WP_REST_Response("You have to fill the time spent on the category!");
      //       $response->set_status(400);
      //       return $response;
      //   }
    
      //   global $wpdb;
    
      //   $table = $wpdb->prefix . 'user_subtopics_statistics';
    
      //   // Prepare and execute the SQL statement to check for existing records
      //   $sql = $wpdb->prepare("SELECT time_spent FROM $table WHERE user_id = %d AND category_id = %d", $user_id, $category_id);
      //   $existing_record = $wpdb->get_row($sql);
    
      //   if (is_null($existing_record)) {
      //       // No existing record, insert a new one
      //       $data = [
      //           'category_id' => $category_id,
      //           'category_name' => $category_name,
      //           'user_id' => $user_id,
      //           'time_spent' => $time_spent
      //       ];
      //       $wpdb->insert($table, $data);
      //   } else {
      //       // Existing record found, add the new time_spent to the existing one
      //       $new_time_spent = (int)$existing_record->time_spent + (int)$time_spent;
      //       $sql = $wpdb->prepare("UPDATE $table SET time_spent = %d WHERE user_id = %d AND category_id = %d", $new_time_spent, $user_id, $category_id);
      //       $wpdb->query($sql);
      //   }
      //   $response = new WP_REST_Response("User subtopic statistics updated successfully!");
      //   $response->set_status(200);
      //   return $response;
      // }

      function updateUserSubtopicsStatistics(WP_REST_Request $request) 
      {   
        // Retrieve the user ID
        $user_id = $request['user_id'] ?? false;

        // Check if the user ID is provided
        if (!$user_id) 
        {
            $response = new WP_REST_Response("You have to fill the ID of the current user!");
            $response->set_status(400);
            return $response;
        }

        // Check if the user exists
        $user = get_user_by('ID', $user_id);
        if (!$user) {
            $response = new WP_REST_Response("This user ID doesn't exist!");
            $response->set_status(400);
            return $response;
        }

        // Retrieve the category ID
        $category_id = $request['category_id'] ?? false;
        if (!$category_id) {
            $response = new WP_REST_Response("You have to fill the category ID!");
            $response->set_status(400);
            return $response;
        }
        
        // Retrieve the category name
        $category_name = $request['category_name'] ?? false;
        if (!$category_name) {
            $response = new WP_REST_Response("You have to fill the category name!");
            $response->set_status(400);
            return $response;
        }

        // Retrieve the time spent
        $time_spent = $request['time_spent'] ?? false;
        if (!$time_spent) {
            $response = new WP_REST_Response("You have to fill the time spent on the category!");
            $response->set_status(400);
            return $response;
        }

        // Retrieve the course type
        $course_type = $request['course_type'] ?? false;
        if (!$course_type) {
            $response = new WP_REST_Response("You have to fill the course type!");
            $response->set_status(400);
            return $response;
        }

        // Define allowed course types
        $allowed_course_types = ['masterclass', 'podcast', 'video', 'workshop', 'artikel', 'opleidingen'];
        if (!in_array($course_type, $allowed_course_types)) {
            $response = new WP_REST_Response("Invalid course type provided!");
            $response->set_status(400);
            return $response;
        }

        global $wpdb;

        $table = $wpdb->prefix . 'user_subtopics_statistics';

        // Sanitize and validate inputs
        $user_id = intval($user_id);
        $category_id = intval($category_id);
        $category_name = sanitize_text_field($category_name);
        $time_spent = intval($time_spent);

        // Prepare and execute the SQL statement to check for existing records
        $sql = $wpdb->prepare("SELECT time_spent, $course_type FROM $table WHERE user_id = %d AND category_id = %d", $user_id, $category_id);
        $existing_record = $wpdb->get_row($sql);

        if (is_null($existing_record)) {
            // No existing record, insert a new one
            $data = [
                'category_id' => $category_id,
                'category_name' => $category_name,
                'user_id' => $user_id,
                'time_spent' => $time_spent,
                'masterclass' => $course_type == 'masterclass' ? $time_spent : "0",
                'podcast' => $course_type == 'podcast' ? $time_spent : "0",
                'video' => $course_type == 'video' ? $time_spent : "0",
                'workshop' => $course_type == 'workshop' ? $time_spent : "0",
                'artikel' => $course_type == 'artikel' ? $time_spent : "0",
                'opleidingen' => $course_type == 'opleidingen' ? $time_spent : "0",
            ];
            $wpdb->insert($table, $data);
        } else 
        {
            // Existing record found, add the new time_spent to the existing one
            $new_time_spent = (int)$existing_record->time_spent + $time_spent;
            $new_course_time_spent = (int)$existing_record->$course_type + $time_spent;
            $sql = $wpdb->prepare("UPDATE $table SET time_spent = %d, $course_type = %d WHERE user_id = %d AND category_id = %d", $new_time_spent, $new_course_time_spent, $user_id, $category_id);
            $wpdb->query($sql);
        }
        $response = new WP_REST_Response("User subtopic statistics updated successfully!");
        $response->set_status(200);
        return $response;
      }

      function getProgressionStatistics ()
      {
        $user = $GLOBALS['user_id'] = get_current_user_id();
        /*
          * * Courses dedicated of these user "Boughts + Mandatories"
        */

          $enrolled = array();
          $enrolled_courses = array();
          $enrolled_courses = list_orders($user)['posts'];
          $your_count_courses = (!empty($enrolled_courses)) ? count($enrolled_courses) : 0;

          $state = array('todo' => 0, 'progress' => 0, 'done' => 0, 'total' => 0);
          foreach($enrolled_courses as $key => $course) :
              /* * State actual details * */
              $status = "todo";
              //Get read by user 
              $args = array(
                  'post_type' => 'progression', 
                  'title' => $course->post_name,
                  'post_status' => 'publish',
                  'author' => $user,
                  'posts_per_page'         => 1,
                  'no_found_rows'          => true,
                  'ignore_sticky_posts'    => true,
                  'update_post_term_cache' => false,
                  'update_post_meta_cache' => false
              );
              $progressions = get_posts($args);
              if(!empty($progressions)){
                  $status = "progress";
                  $progression_id = $progressions[0]->ID;
                  //Finish read
                  $is_finish = get_field('state_actual', $progression_id);
                  if($is_finish)
                      $status = "done";
              }

              // Analytics
              switch ($status) {
                  case 'todo':
                      $state['todo']++;
                      break;
                  case 'progress':
                      $state['progress']++;
                      break;
                  case 'done':
                      $state['done']++;
                      break;
              }

          endforeach;
          $state['total'] = $state['todo'] + $state['progress'] + $state['done'];
          return $state;
      }

      /** 
       * Assessment Statistics
      */

          function getUserAttempts()
          {
            $user_id = $GLOBALS['user_id'] = get_current_user_id();
            $user = get_user_by( 'ID', $user_id);
            $user_attempts = get_posts(
              array(
                  'post_type' => array('response_assessment'), 
                  'post_status' => 'publish',
                  'posts_per_page' => -1,
                  'order' => 'DESC',
                  'post_author' => $user_id
            ));
            $assessment_validated = get_user_meta($user->ID,'assessment_validated');
            $formated_assessments_validated = array();
            
            
            foreach ($assessment_validated as $key => $value) {
              if ($value != "")
                array_push ($formated_assessments_validated,$value);

            }
            $failed_assessments = count($user_attempts) - count($formated_assessments_validated);
            $user_assessments_statistics = array (
              
              "attempts" => count($user_attempts),
              "failed" => $failed_assessments,
              "success" => count($formated_assessments_validated)
            );
              return ($user_assessments_statistics);
          }

      /** 
       * Assessment Statistics
      */


  /** 
   * Statistics Endpoints
  */
  
  function get_user_topics($user_id)
  {
    $infos = array();

    //Get Topics
    $topics_external = get_user_meta($user_id, 'topic');
    $topics_internal = get_user_meta($user_id, 'topic_affiliate');
    $topics = array();
    if(!empty($topics_external))
        $topics = $topics_external;

    if(!empty($topics_internal))
        foreach($topics_internal as $item)
            array_push($topics, $item);
          
    if(!empty($topics)){
        $args = array( 
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'include'  => $topics,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            'include' => $topics
        );
        $infos['following_topics'] = get_categories($args);
    }
    return $infos['following_topics'];
  }

  //* Max Bird | Mailing recommendation *//
  function recommendedWeekly()
  {
    //Get all users 
    $args = array(
            // 'role__in' => ['administrator', 'hr', 'manager', 'subscriber'],
            'role__in' => ['administrator'],
            'order' => 'DESC',
            'number' => 200
            // 'search'  => 'mokhouthioune96@gmail.com',
            // 'search_columns' => array( 'user_login', 'user_email' ),
            // 'posts_per_page' => -1
          );
    $users = get_users($args);

    // var_dump(count($users), $users);
    // die();

    foreach($users as $user):

      //Recommendation courses
      $infos = recommendation($user->ID, null, 75);
      $recommended_courses = $infos['recommended'];
      shuffle($recommended_courses);
      $numTypos = ['article' => 0, 'podcast' => 0, 'video' => 0, 'others' => 0];
      $content['article'] = '<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                              <tbody>
                                <tr>
                                  <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                      class="row-content stack" role="presentation"
                                      style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 600px; margin: 0 auto;"
                                      width="600">
                                      <tbody>
                                        <tr>
                                          <td class="column column-1"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                            width="100%">
                                            <table border="0" cellpadding="10" cellspacing="0"
                                              class="divider_block block-1" role="presentation"
                                              style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                              width="100%">
                                              <tr>
                                                <td class="pad">
                                                  <div align="center" class="alignment">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                      role="presentation"
                                                      style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                      width="100%">
                                                      <tr>
                                                        <td class="divider_inner"
                                                          style="font-size: 1px; line-height: 1px; border-top: 1px solid #dddddd;">
                                                          <span> </span>
                                                        </td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                </td>
                                              </tr>
                                            </table>
                                            <table border="0" cellpadding="0" cellspacing="0"
                                              class="heading_block block-2" role="presentation"
                                              style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                              width="100%">
                                              <tr>
                                                <td class="pad"
                                                  style="padding-left:25px;padding-right:25px;padding-top:5px;text-align:center;width:100%;">
                                                  <h1
                                                    style="margin: 0; color: #00a89d; direction: ltr; font-family: \'Montserrat\', \'Trebuchet MS\', \'Lucida Grande\', \'Lucida Sans Unicode\',\'Lucida Sans\', Tahoma, sans-serif; font-size: 25px; font-weight: 400; letter-spacing: normal; line-height: 150%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 37.5px;">
                                                    <strong><span class="tinyMce-placeholder">Your
                                                        <u>articles</u> this week!</span></strong>
                                                  </h1>
                                                </td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>';
      $content['podcast'] = '<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                                <tbody>
                                  <tr>
                                    <td>
                                      <table align="center" border="0" cellpadding="0" cellspacing="0"
                                        class="row-content stack" role="presentation"
                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 600px; margin: 0 auto;"
                                        width="600">
                                        <tbody>
                                          <tr>
                                            <td class="column column-1"
                                              style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                              width="100%">
                                              <table border="0" cellpadding="10" cellspacing="0"
                                                class="divider_block block-1" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                width="100%">
                                                <tr>
                                                  <td class="pad">
                                                    <div align="center" class="alignment">
                                                      <table border="0" cellpadding="0" cellspacing="0"
                                                        role="presentation"
                                                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                        width="100%">
                                                        <tr>
                                                          <td class="divider_inner"
                                                            style="font-size: 1px; line-height: 1px; border-top: 1px solid #dddddd;">
                                                            <span> </span>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </div>
                                                  </td>
                                                </tr>
                                              </table>
                                              <table border="0" cellpadding="0" cellspacing="0"
                                                class="heading_block block-2" role="presentation"
                                                style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                width="100%">
                                                <tr>
                                                  <td class="pad"
                                                    style="padding-left:25px;padding-right:25px;padding-top:5px;text-align:center;width:100%;">
                                                    <h1
                                                      style="margin: 0; color: #00a89d; direction: ltr; font-family: \'Montserrat\', \'Trebuchet MS\', \'Lucida Grande\', \'Lucida Sans Unicode\',\'Lucida Sans\', Tahoma, sans-serif; font-size: 25px; font-weight: 400; letter-spacing: normal; line-height: 150%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 37.5px;">
                                                      <strong><span class="tinyMce-placeholder">Your
                                                          <u>podcasts</u> this week!</span></strong>
                                                    </h1>
                                                  </td>
                                                </tr>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>';
      $content['video'] = '<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                              <tbody>
                                <tr>
                                  <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                      class="row-content stack" role="presentation"
                                      style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 600px; margin: 0 auto;"
                                      width="600">
                                      <tbody>
                                        <tr>
                                          <td class="column column-1"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                            width="100%">
                                            <table border="0" cellpadding="10" cellspacing="0"
                                              class="divider_block block-1" role="presentation"
                                              style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                              width="100%">
                                              <tr>
                                                <td class="pad">
                                                  <div align="center" class="alignment">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                      role="presentation"
                                                      style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                      width="100%">
                                                      <tr>
                                                        <td class="divider_inner"
                                                          style="font-size: 1px; line-height: 1px; border-top: 1px solid #dddddd;">
                                                          <span> </span>
                                                        </td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                </td>
                                              </tr>
                                            </table>
                                            <table border="0" cellpadding="0" cellspacing="0"
                                              class="heading_block block-2" role="presentation"
                                              style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                              width="100%">
                                              <tr>
                                                <td class="pad"
                                                  style="padding-left:25px;padding-right:25px;padding-top:5px;text-align:center;width:100%;">
                                                  <h1
                                                    style="margin: 0; color: #00a89d; direction: ltr; font-family: \'Montserrat\', \'Trebuchet MS\', \'Lucida Grande\', \'Lucida Sans Unicode\',\'Lucida Sans\', Tahoma, sans-serif; font-size: 25px; font-weight: 400; letter-spacing: normal; line-height: 150%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 37.5px;">
                                                    <strong><span class="tinyMce-placeholder">Your
                                                        <u>videos</u> this week!</span></strong>
                                                  </h1>
                                                </td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                           </table>';
      $content['others'] = '<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
                              <tbody>
                                <tr>
                                  <td>
                                    <table align="center" border="0" cellpadding="0" cellspacing="0"
                                      class="row-content stack" role="presentation"
                                      style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 600px; margin: 0 auto;"
                                      width="600">
                                      <tbody>
                                        <tr>
                                          <td class="column column-1"
                                            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 15px; padding-top: 15px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                                            width="100%">
                                            <table border="0" cellpadding="10" cellspacing="0"
                                              class="divider_block block-1" role="presentation"
                                              style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                              width="100%">
                                              <tr>
                                                <td class="pad">
                                                  <div align="center" class="alignment">
                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                      role="presentation"
                                                      style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                                      width="100%">
                                                      <tr>
                                                        <td class="divider_inner"
                                                          style="font-size: 1px; line-height: 1px; border-top: 1px solid #dddddd;">
                                                          <span> </span>
                                                        </td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                </td>
                                              </tr>
                                            </table>
                                            <table border="0" cellpadding="0" cellspacing="0"
                                              class="heading_block block-2" role="presentation"
                                              style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                                              width="100%">
                                              <tr>
                                                <td class="pad"
                                                  style="padding-left:25px;padding-right:25px;padding-top:5px;text-align:center;width:100%;">
                                                  <h1
                                                    style="margin: 0; color: #00a89d; direction: ltr; font-family: \'Montserrat\', \'Trebuchet MS\', \'Lucida Grande\', \'Lucida Sans Unicode\',\'Lucida Sans\', Tahoma, sans-serif; font-size: 25px; font-weight: 400; letter-spacing: normal; line-height: 150%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 37.5px;">
                                                    <strong><span class="tinyMce-placeholder">Your
                                                        <u>courses</u> this week!</span></strong>
                                                  </h1>
                                                </td>
                                              </tr>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-19" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
          <tbody>
            <tr>
              <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0"
                  class="row-content stack" role="presentation"
                  style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e0eff4; color: #000000; border-bottom: 1px solid #FFFFFF; border-left: 1px solid #FFFFFF; border-radius: 0; border-right: 1px solid #FFFFFF; border-top: 1px solid #FFFFFF; width: 600px; margin: 0 auto;"
                  width="600">
                  <tbody>
                    <tr>';

      $final_content = "";

      //Mailing
      $first_name = $user->first_name ?: $user->display_name;
      $email = $user->user_email;
      $subject = 'Hello '. $first_name .', your weekly learnings !';
      $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  

      $content_course = null;
      $i = 0;
      foreach($recommended_courses as $post):

        $text = "";
        $course_type = $post->courseType;

        //Information course
        $thumbnail = $post->image;
        $title = $post->post_title;
        $short_description = $post->short_description;
        //$short_description = (strlen($short_description) > 50) ? $short_description . '...' : $short_description;

        //Get genuine link
        $base_url = "https://www.livelearn.nl"; 
        $link = $base_url . '/course/details-' . strtolower($course_type) . '/' . $post->post_name;
        //End information

        $row_first = $i + 5;
        $row_second = $i + 6;
        $text = '
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
          <tbody>
            <tr>
              <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0"
                  class="row-content stack" role="presentation"
                  style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff; color: #000000; width: 600px; margin: 0 auto;"
                  width="600">
                  <tbody>
                    <tr>
                      <td class="column column-1"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; border-bottom: 5px solid #FFFFFF; border-left: 5px solid #FFFFFF; border-right: 5px solid #FFFFFF; border-top: 5px solid #FFFFFF; padding-left: 10px; padding-right: 10px; vertical-align: top;"
                        width="50%">
                        <table border="0" cellpadding="0" cellspacing="0"
                          class="image_block block-1" role="presentation"
                          style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                          width="100%">
                          <tr>
                            <td class="pad"
                              style="width:100%;padding-right:0px;padding-left:0px;">
                              <div align="center" class="alignment"
                                style="line-height:10px">
                                <div class="fullWidth" style="max-width: 270px;">
                                  <img alt="' . $title . '"
                                    src="' . $thumbnail . '"
                                    style="display: block; height: auto; border: 0; width: 100%;"
                                    title="' . $title . '" width="270" />
                                </div>
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td class="column column-2"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; border-bottom: 5px solid #FFFFFF; border-left: 5px solid #FFFFFF; border-right: 5px solid #FFFFFF; border-top: 5px solid #FFFFFF; padding-left: 10px; padding-right: 10px; vertical-align: top;"
                        width="50%">
                        <table border="0" cellpadding="0" cellspacing="0"
                          class="heading_block block-1" role="presentation"
                          style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                          width="100%">
                          <tr>
                            <td class="pad"
                              style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:30px;text-align:center;width:100%;">
                              <h1
                                style="margin: 0; color: #023356; direction: ltr; font-family: \'Montserrat\', \'Trebuchet MS\', \'Lucida Grande\', \'Lucida Sans Unicode\', \'Lucida Sans\', Tahoma, sans-serif; font-size: 20px; font-weight: 400; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 24px;">
                                <strong>' . $title . '</strong>
                              </h1>
                            </td>
                          </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0"
                          class="paragraph_block block-2" role="presentation"
                          style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
                          width="100%">
                          <tr>
                            <td class="pad"
                              style="padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:5px;">
                              <div
                                style="color:#023356;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left;mso-line-height-alt:21px;">
                                <p style="margin: 0; word-break: break-word;">
                                  <span>' . $short_description . '</span>
                                </p>
                              </div>
                            </td>
                          </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0"
                          class="button_block block-3" role="presentation"
                          style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
                          width="100%">
                          <tr>
                            <td class="pad" style="padding-bottom:15px;padding-left:10px;padding-right:10px;padding-top:15px;text-align:left;">
                              <div align="left" class="alignment"><!--[if mso]>
                                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="example.com" style="height:44px;width:163px;v-text-anchor:middle;" arcsize="137%" stroke="false" fillcolor="#00a89d">
                                <w:anchorlock/>
                                <v:textbox inset="0px,0px,0px,0px">
                                <center style="color:#ffffff; font-family:Tahoma, Verdana, sans-serif; font-size:15px">
                                <![endif]-->
                                <a href="' . $link . '" style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#00a89d;border-radius:60px;width:auto;border-top:0px solid #8a3b8f;font-weight:400;border-right:0px solid #8a3b8f;border-bottom:0px solid #8a3b8f;border-left:0px solid #8a3b8f;padding-top:7px;padding-bottom:7px;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;font-size:15px;text-align:center;mso-border-alt:none;word-break:keep-all;" target="_blank">
                                  <span style="padding-left:40px;padding-right:40px;font-size:15px;display:inline-block;letter-spacing:normal;">
                                    <span style="word-break:break-word;">
                                      <span data-mce-style=""
                                        style="line-height: 30px;"><strong>
                                          Read more !</strong>
                                      </span>
                                    </span>
                                  </span>
                                </a>
                                <!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
                              </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
        <table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6"
          role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
          <tbody>
            <tr>
              <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0"
                  class="row-content stack" role="presentation"
                  style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 600px; margin: 0 auto;"
                  width="600">
                  <tbody>
                    <tr>
                      <td class="column column-1"
                        style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;"
                        width="100%">
                        <div class="spacer_block block-1"
                          style="height:15px;line-height:15px;font-size:1px;"> </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>';

        $text_others = '
        <td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; border-bottom: 5px solid #FFFFFF; border-left: 5px solid #FFFFFF; border-right: 5px solid #FFFFFF; border-top: 5px solid #FFFFFF; padding-bottom: 30px; padding-left: 15px; padding-right: 15px; padding-top: 35px; vertical-align: top;" width="50%">
          <table border="0" cellpadding="0" cellspacing="0"
            class="heading_block block-1" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
            width="100%">
            <tr>
              <td class="pad"
                style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:5px;text-align:center;width:100%;">
                <h1
                  style="margin: 0; color: #39374e; direction: ltr; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; font-size: 15px; font-weight: 700; letter-spacing: 1px; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0; mso-line-height-alt: 18px;">
                  <strong>' . $title . '</strong>
                </h1>
              </td>
            </tr>
          </table>
          <table border="0" cellpadding="0" cellspacing="0"
            class="paragraph_block block-2" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;"
            width="100%">
            <tr>
              <td class="pad"
                style="padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:5px;">
                <div
                  style="color:#39374e;font-family:\'Open Sans\',\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:15px;line-height:150%;text-align:center;mso-line-height-alt:22.5px;">
                  <p style="margin: 0; word-break: break-word;">
                    <span>'. $short_description .'</span>
                  </p>
                </div>
              </td>
            </tr>
          </table>
          <table border="0" cellpadding="10" cellspacing="0"
            class="button_block block-3" role="presentation"
            style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;"
            width="100%">
            <tr>
              <td class="pad">
                <div align="center" class="alignment"><!--[if mso]>
                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'. $link .'" style="height:54px;width:164px;v-text-anchor:middle;" arcsize="125%" strokeweight="1.5pt" strokecolor="#00A89D" fill="false">
                <w:anchorlock/>
                <v:textbox inset="0px,0px,0px,0px">
                <center style="color:#00a89d; font-family:Tahoma, Verdana, sans-serif; font-size:15px">
                <![endif]-->
                <a href="' . $link . '" style="text-decoration:none;display:inline-block;color:#00a89d;background-color:transparent;border-radius:60px;width:auto;border-top:2px solid #00A89D;font-weight:400;border-right:2px solid #00A89D;border-bottom:2px solid #00A89D;border-left:2px solid #00A89D;padding-top:7px;padding-bottom:7px;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;font-size:15px;text-align:center;mso-border-alt:none;word-break:keep-all;"
                    target="_blank"><span
                      style="padding-left:40px;padding-right:40px;font-size:15px;display:inline-block;letter-spacing:normal;"><span
                        style="word-break:break-word;"><span
                          data-mce-style=""
                          style="line-height: 30px;"><strong>See
                            Course</strong></span></span></span></a><!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
                  </div>
                </td>
            </tr>
          </table>
        </td>
        ';

        //Switch case for 
        switch ($course_type) {
          case 'Artikel':
            if($numTypos['article'] >= 2)
              break;
            $content['article'] .= $text;
            $numTypos['article'] += 1;
            $i++;
            break;

          case 'Podcast':
            if($numTypos['podcast'] >= 2)
              break;
            $content['podcast'] .= $text;
            $numTypos['podcast'] += 1;
            $i++;
            break;
          
          case 'Video':
            if($numTypos['video'] >= 2)
              break;
            $content['video'] .= $text;
            $numTypos['video'] += 1;
            $i++;
            break;
          
          default:
            if($numTypos['others'] >= 2)
              break;
            // var_dump("others",$text);
            $content['others'] .= $text_others;
            $numTypos['others'] += 1;
            $i++;
            break;
        }

      endforeach;

      //content others
      $content['others'] .= '
        </tr>
        </tbody>
        </table>
        </td>
      </tr>
      </tbody>
      </table>';

      //Combine content
      if($numTypos['article'])
        $final_content = $content['article'];
      if($numTypos['podcast'])
        $final_content .= $content['podcast'];
      if($numTypos['video'])
        $final_content .= $content['video'];
      if($numTypos['others'])
        $final_content .= $content['others'];

      //Require  
      require __DIR__ . "/templates/mail-weekly-livelearn.php";
      wp_mail($email, $subject, $mail_weekly_course_body, $headers, array( '' )) ;

    endforeach;
    //End Iterate recommendation 

    $statusResponse = "OK | Recommended Weekly";
    $response = new WP_REST_Response($statusResponse);
    $response->set_status(200);
    return $response;
  }


//Orders dedicated to this user (courses) 
function get_user_orders(WP_REST_Request $request){
  $required_parameters = ['userID'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Check user exists
  $userID = $request['userID'] ?: null;
  $user = get_user_by('ID', $userID);
  $errors = [];
  if (!$user):
    $errors['errors'] = 'No user matchin !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Enrolled with Stripe
  $enrolled_courses = array();
  $enrolled_courses = list_orders($user->ID)['posts']; 
  
    $outcome_courses = array();
  
    for ($i = 0; $i < count($enrolled_courses); $i++) {
      $enrolled_courses[$i]->visibility = get_field('visibility', $enrolled_courses[$i]->ID) ?? [];
      $author = get_user_by('ID', $enrolled_courses[$i]->post_author);
      $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
      if ($enrolled_courses[$i]->visibility != []) {
          if ($author_company != $current_user_company) continue;
      }
      $author_img = get_field('profile_img', 'user_' . $author->ID) ? get_field('profile_img', 'user_' . $author->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      $enrolled_courses[$i]->experts = array();
      $experts = get_field('experts', $enrolled_courses[$i]->ID);
      if (!empty($experts)) {
          foreach ($experts as $key => $expert) {
              $expert = get_user_by('ID', $expert);
              $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($enrolled_courses[$i]->experts, new Expert($expert, $experts_img));
          }
      }

      $enrolled_courses[$i]->author = new Expert($author, $author_img);
      $enrolled_courses[$i]->longDescription = get_field('long_description', $enrolled_courses[$i]->ID);
      $enrolled_courses[$i]->shortDescription = get_field('short_description', $enrolled_courses[$i]->ID);
      $enrolled_courses[$i]->courseType = get_field('course_type', $enrolled_courses[$i]->ID);

      $image = get_field('preview', $enrolled_courses[$i]->ID)['url'];
      if (!$image) {
          $image = get_the_post_thumbnail_url($enrolled_courses[$i]->ID);
          if (!$image) $image = get_field('url_image_xml', $enrolled_courses[$i]->ID);
          if (!$image) $image = get_stylesheet_directory_uri() . '/img/' . strtolower($enrolled_courses[$i]->courseType) . '.jpg';
      }
      $enrolled_courses[$i]->pathImage = $image;
      $enrolled_courses[$i]->price = get_field('price', $enrolled_courses[$i]->ID) ?? 0;
      $enrolled_courses[$i]->language = get_field('language', $enrolled_courses[$i]->ID) ?? "";
      $enrolled_courses[$i]->youtubeVideos = get_field('youtube_videos', $enrolled_courses[$i]->ID) ? get_field('youtube_videos', $enrolled_courses[$i]->ID) : [];
      if (strtolower($enrolled_courses[$i]->courseType) == 'podcast') {
          $podcasts = get_field('podcasts', $enrolled_courses[$i]->ID) ? get_field('podcasts', $enrolled_courses[$i]->ID) : [];
          if (!empty($podcasts)) {
              $enrolled_courses[$i]->podcasts = $podcasts;
          } else {
              $podcasts = get_field('podcasts_index', $enrolled_courses[$i]->ID) ? get_field('podcasts_index', $enrolled_courses[$i]->ID) : [];
              if (!empty($podcasts)) {
                  $enrolled_courses[$i]->podcasts = array();
                  foreach ($podcasts as $key => $podcast) {
                      $item = array(
                          "course_podcast_title" => $podcast['podcast_title'],
                          "course_podcast_intro" => $podcast['podcast_description'],
                          "course_podcast_url" => $podcast['podcast_url'],
                          "course_podcast_image" => $podcast['podcast_image'],
                      );
                      array_push($enrolled_courses[$i]->podcasts, ($item));
                  }
              }
          }
      }
      $enrolled_courses[$i]->podcasts = $enrolled_courses[$i]->podcasts ?? [];
      $enrolled_courses[$i]->connectedProduct = get_field('connected_product', $enrolled_courses[$i]->ID);
      $tags = get_field('categories', $enrolled_courses[$i]->ID) ?? [];
      $enrolled_courses[$i]->tags = array();
      if ($tags) {
          if (!empty($tags)) {
              foreach ($tags as $key => $category) {
                  if (isset($category['value'])) {
                      $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
                      array_push($enrolled_courses[$i]->tags, $tag);
                  }
              }
          }
      }
      $new_course = new Course($enrolled_courses[$i]);
      array_push($outcome_courses, $new_course);
  }

  // Return the response 
  $response = new WP_REST_Response($outcome_courses);
  $response->set_status(200);
  return $response;  

}

// Assessments v3

// Endpoint pour ajouter un assessment avec ses questions
function add_assessment_with_questions(WP_REST_Request $request) {
  global $wpdb;
  
  $data = $request->get_json_params();
  
  // Vérifier que les champs requis sont présents
  if (empty($data['title']) || empty($data['questions']) || empty($data['author_id']) || empty($data['level'])) {
      return new WP_Error('missing_data', 'Title, questions, author_id, and level are required', array('status' => 400));
  }
  
  // Génére un slug unique
  $slug = sanitize_title($data['title']);
  
  
  // Commencer une transaction pour assurer l'intégrité des données
  $wpdb->query('START TRANSACTION');
  
  try {
      // Insertion de l'assessment
      $wpdb->insert(
          $wpdb->prefix . 'assessments',
          array(
              'title' => sanitize_text_field($data['title']),
              'slug' => $slug,
              'description' => sanitize_textarea_field($data['description']),
              'duration' => (int) $data['duration'],
              'category_id' => (int) $data['category_id'],
              'is_public' => isset($data['is_public']) ? (int) $data['is_public'] : 0,
              'is_enabled' => isset($data['is_enabled']) ? (int) $data['is_enabled'] : 0,
              'author_id' => (int) $data['author_id'], 
              'level' => sanitize_text_field($data['level']),
              'createdAt' => current_time('mysql', true),
              'updatedAt' => current_time('mysql', true),
          ),
          array('%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%s', '%s', '%s')
      );

      // Vérification des erreurs SQL
      if ($wpdb->last_error) {
          throw new Exception('Failed to insert assessment: ' . $wpdb->last_error);
      }
      
      $assessment_id = $wpdb->insert_id;
      
      // Insérer les questions associées
      foreach ($data['questions'] as $question_data) {
          $wpdb->insert(
              $wpdb->prefix . 'question',
              array(
                  'wording' => sanitize_textarea_field($question_data['wording']),
                  'assessment_id' => $assessment_id,
                  'createdAt' => current_time('mysql', true),
              ),
              array('%s', '%d', '%s')
          );
          
          if ($wpdb->last_error) {
              throw new Exception('Failed to insert question: ' . $wpdb->last_error);
          }

          $question_id = $wpdb->insert_id;
          
          // Insérer les réponses associées à chaque question
          foreach ($question_data['answers'] as $answer_data) {
              $wpdb->insert(
                  $wpdb->prefix . 'answer',
                  array(
                      'wording' => sanitize_text_field($answer_data['wording']),
                      'is_correct' => isset($answer_data['is_correct']) ? (int) $answer_data['is_correct'] : 0,
                      'question_id' => $question_id,
                      'createdAt' => current_time('mysql', true),
                  ),
                  array('%s', '%d', '%d', '%s')
              );

              if ($wpdb->last_error) {
                  throw new Exception('Failed to insert answer: ' . $wpdb->last_error);
              }
          }
      }
      
      // Valider la transaction
      $wpdb->query('COMMIT');
      
      // Retourner une réponse de succès
      return rest_ensure_response(array('message' => 'Assessment added successfully'));
      
  } catch (Exception $e) {
      // En cas d'erreur, annuler la transaction
      $wpdb->query('ROLLBACK');
      return new WP_Error('db_error', $e->getMessage(), array('status' => 500));
  }
}

function update_assessment_with_questions(WP_REST_Request $request) {
  global $wpdb;

  $data = $request->get_json_params();

  // Vérifier que l'ID de l'assessment est présent
  if (empty($data['assessment_id'])) {
      return new WP_Error('missing_data', 'Assessment ID is required', array('status' => 400));
  }

  $assessment_id = (int) $data['assessment_id'];

  // Commencer une transaction pour assurer l'intégrité des données
  $wpdb->query('START TRANSACTION');

  try {
      // Mise à jour de l'assessment
      $wpdb->update(
          $wpdb->prefix . 'assessments',
          array(
              'title' => sanitize_text_field($data['title']),
              'description' => sanitize_textarea_field($data['description']),
              'duration' => isset($data['duration']) ? (int) $data['duration'] : null,
              'category_id' => isset($data['category_id']) ? (int) $data['category_id'] : null,
              'is_public' => isset($data['is_public']) ? (int) $data['is_public'] : 0,
              'is_enabled' => isset($data['is_enabled']) ? (int) $data['is_enabled'] : 0,
              'level' => sanitize_text_field($data['level']),
              'updatedAt' => current_time('mysql', true),
          ),
          array('id' => $assessment_id),
          array('%s', '%s', '%d', '%d', '%d', '%d', '%s', '%s'),
          array('%d')
      );

      if ($wpdb->last_error) {
          throw new Exception('Failed to update assessment: ' . $wpdb->last_error);
      }

      // Récupérer les questions existantes pour cet assessment
      $existing_questions = $wpdb->get_results(
          $wpdb->prepare("SELECT id FROM {$wpdb->prefix}question WHERE assessment_id = %d", $assessment_id),
          ARRAY_A
      );
      $existing_question_ids = array_column($existing_questions, 'id');

      $updated_question_ids = [];

      foreach ($data['questions'] as $question_data) {
          if (isset($question_data['question_id'])) {
              // Mettre à jour une question existante
              $question_id = (int) $question_data['question_id'];
              $wpdb->update(
                  $wpdb->prefix . 'question',
                  array(
                      'wording' => sanitize_textarea_field($question_data['wording']),
                      'updatedAt' => current_time('mysql', true),
                  ),
                  array('id' => $question_id, 'assessment_id' => $assessment_id),
                  array('%s', '%s'),
                  array('%d', '%d')
              );

              if ($wpdb->last_error) {
                  throw new Exception('Failed to update question: ' . $wpdb->last_error);
              }

              $updated_question_ids[] = $question_id;
          } else {
              // Ajouter une nouvelle question
              $wpdb->insert(
                  $wpdb->prefix . 'question',
                  array(
                      'wording' => sanitize_textarea_field($question_data['wording']),
                      'assessment_id' => $assessment_id,
                      'createdAt' => current_time('mysql', true),
                  ),
                  array('%s', '%d', '%s')
              );

              if ($wpdb->last_error) {
                  throw new Exception('Failed to add new question: ' . $wpdb->last_error);
              }

              $updated_question_ids[] = $wpdb->insert_id;
          }

          $question_id = $wpdb->insert_id ?? $question_id;

          // Gérer les réponses associées
          if (!empty($question_data['answers'])) {
              // Supprimer les réponses existantes pour la question
              $wpdb->delete(
                  $wpdb->prefix . 'answer',
                  array('question_id' => $question_id),
                  array('%d')
              );

              foreach ($question_data['answers'] as $answer_data) {
                  $wpdb->insert(
                      $wpdb->prefix . 'answer',
                      array(
                          'wording' => sanitize_text_field($answer_data['wording']),
                          'is_correct' => isset($answer_data['is_correct']) ? (int) $answer_data['is_correct'] : 0,
                          'question_id' => $question_id,
                          'createdAt' => current_time('mysql', true),
                      ),
                      array('%s', '%d', '%d', '%s')
                  );

                  if ($wpdb->last_error) {
                      throw new Exception('Failed to add/update answer: ' . $wpdb->last_error);
                  }
              }
          }
      }

      // Supprimer les questions qui ne sont plus associées
      $questions_to_delete = array_diff($existing_question_ids, $updated_question_ids);

      if (!empty($questions_to_delete)) {
          $placeholders = implode(',', array_fill(0, count($questions_to_delete), '%d'));
          $wpdb->query(
              $wpdb->prepare(
                  "DELETE FROM {$wpdb->prefix}question WHERE id IN ($placeholders)",
                  $questions_to_delete
              )
          );
      }

      // Valider la transaction
      $wpdb->query('COMMIT');

      return rest_ensure_response(array('message' => 'Assessment updated successfully'));

  } catch (Exception $e) {
      // Annuler la transaction en cas d'erreur
      $wpdb->query('ROLLBACK');
      return new WP_Error('db_error', $e->getMessage(), array('status' => 500));
  }
}

function delete_assessment(WP_REST_Request $request) {
  global $wpdb;

  $assessment_id = (int) $request['assessment_id'];

  // Vérifier si l'assessment est archivé avant de supprimer
  $assessment = $wpdb->get_row(
      $wpdb->prepare("SELECT is_enabled FROM {$wpdb->prefix}assessments WHERE id = %d", $assessment_id),
      ARRAY_A
  );

  if (!$assessment) {
      return new WP_Error('not_found', 'Assessment not found', array('status' => 404));
  }

  if ((int) $assessment['is_enabled'] !== 0) {
      return new WP_Error('not_allowed', 'Assessment must be disabled before deletion', array('status' => 400));
  }

  // Supprimer les questions associées
  $wpdb->delete(
      $wpdb->prefix . 'question',
      array('assessment_id' => $assessment_id),
      array('%d')
  );

  // Supprimer l'assessment
  $wpdb->delete(
      $wpdb->prefix . 'assessments',
      array('id' => $assessment_id),
      array('%d')
  );

  if ($wpdb->last_error) {
      return new WP_Error('db_error', 'Failed to delete assessment', array('status' => 500));
  }

  return rest_ensure_response(array('message' => 'Assessment deleted successfully'));
}



function list_archived_assessments() 
{
  global $wpdb;

    // Récupération des évaluations activées
    $assessments = $wpdb->get_results(
        "SELECT a.id, a.title, a.slug, a.author_id, a.category_id, a.description, a.level, a.duration, a.is_public, a.is_enabled, COUNT(q.id) as question_count
        FROM {$wpdb->prefix}assessments a
        LEFT JOIN {$wpdb->prefix}question q ON q.assessment_id = a.id
        WHERE a.is_enabled = 0
        GROUP BY a.id"
    );

    // Vérifie s'il y a des assessments
    if (empty($assessments)) {
        return rest_ensure_response(array('message' => 'No assessments found.'));
    }

    // Récupération de l'ID de l'utilisateur pour ajouter les champs status et score
    $user_id = $GLOBALS['user_id'];

    foreach ($assessments as $assessment) {
        // Rechercher si l'utilisateur a un résultat pour cet assessment
        $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT score, is_success FROM {$wpdb->prefix}result WHERE user_id = %d AND assessment_id = %d",
                $user_id,
                $assessment->id
            )
        );

        if ($result) {
            if ($result->is_success) {
                $assessment->status = 'validated'; // L'utilisateur a validé l'évaluation
            } else {
                $assessment->status = 'failed'; // L'utilisateur a échoué l'évaluation
            }
            $assessment->score = $result->score; // Inclure le score
        } else {
            $assessment->status = 'not_attempted'; // L'utilisateur n'a jamais tenté l'évaluation
            $assessment->score = null; // Pas de score car jamais tenté
        }

        // Récupérer les informations de l'auteur
        $author = get_user_by('ID', $assessment->author_id);
        if ($author) {
            $author_img = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            $assessment->author = new Expert($author, $author_img);
        } else {
            $assessment->author = null;
        }

        // Récupérer les informations de la catégorie
        $assessment->category = [
            "name" => get_the_category_by_ID((int)$assessment->category_id),
            "image" => get_field('image', 'category_' . (int)$assessment->category_id) ?? ""
        ];
    }

    // Retourner les assessments avec les données enrichies
    return rest_ensure_response($assessments);
}



// Endpoint pour rajouter un slug à tous les assessments
function add_slug_to_all_assessments()
{

  global $wpdb;

  // Récupérer tous les assessments existants
  $assessments = $wpdb->get_results("SELECT id, title FROM {$wpdb->prefix}assessments");

  // Parcourir chaque assessment et générer un slug unique
  foreach ($assessments as $assessment) {
      $slug = sanitize_title($assessment->title);

      // Mettre à jour le slug dans la base de données
      $wpdb->update(
          "{$wpdb->prefix}assessments",
          array('slug' => $slug),
          array('id' => $assessment->id),
          array('%s'),
          array('%d')
      );

  }


}


// Fonction pour traiter une tentative d'assessment dans la base de données
function process_assessment_attempt($assessment_id, $user_id, $answers_payload) {
  global $wpdb;

  $user_answers = [];
  foreach ($answers_payload as $answer) {
      $user_answers[$answer['question_id']] = $answer['selected_answers'];
  }

  // Vérifier s'il existe déjà un résultat pour cet utilisateur et cette évaluation
  $existing_result = $wpdb->get_row(
      $wpdb->prepare(
          "SELECT * FROM {$wpdb->prefix}result WHERE user_id = %d AND assessment_id = %d",
          $user_id,
          $assessment_id
      )
  );

  $score = calculate_assessment_score($assessment_id, $user_answers);
  $is_success = determine_assessment_success($assessment_id, $user_answers);

  if ($existing_result) {
      // Si un résultat existe déjà, on le met à jour
      $result_id = $existing_result->id;

      // Mettre à jour le score, le statut de succès, et le nombre de tentatives dans le résultat existant
      $wpdb->update(
          $wpdb->prefix . 'result',
          array(
              'score' => $score,
              'is_success' => $is_success,
              'attempt_count' => $existing_result->attempt_count + 1,
              'completed_at' => current_time('mysql', true),
          ),
          array('id' => $result_id),
          array('%f', '%d', '%d', '%s'),
          array('%d')
      );

      return $result_id;
  }

  // Commence une transaction pour assurer la cohérence des données
  $wpdb->query('START TRANSACTION');

  try {
      // Insérer un nouveau résultat pour cette tentative
      $wpdb->insert(
          $wpdb->prefix . 'result',
          array(
              'user_id' => $user_id,
              'assessment_id' => $assessment_id,
              'score' => $score,
              'is_success' => $is_success,
              'attempt_count' => 1,
              'completed_at' => current_time('mysql', true),
          ),
          array('%d', '%d', '%f', '%d', '%s')
      );

      // Valider la transaction
      $wpdb->query('COMMIT');

      return $wpdb->insert_id;
  } catch (Exception $e) {
      // En cas d'erreur, annuler la transaction
      $wpdb->query('ROLLBACK');
      return false;
  }
}

function determine_assessment_success($assessment_id, $user_answers) {
  global $wpdb;

  // Obtenir toutes les questions de l'évaluation
  $questions = $wpdb->get_results(
      $wpdb->prepare(
          "SELECT id FROM {$wpdb->prefix}question WHERE assessment_id = %d",
          $assessment_id
      )
  );

  $correct_count = 0; // Compteur pour les réponses correctes
  $total_questions = count($questions); // Nombre total de questions

  // Parcourir chaque question et vérifier les réponses fournies par l'utilisateur
  foreach ($questions as $question) {
      // Obtenir les réponses correctes pour la question
      $correct_answers = $wpdb->get_col(
          $wpdb->prepare(
              "SELECT id FROM {$wpdb->prefix}answer WHERE question_id = %d AND is_correct = 1",
              $question->id
          )
      );

      // Vérifier si l'utilisateur a répondu à cette question
      if (!empty($user_answers[$question->id])) {
          // Compter le nombre de bonnes réponses données par l'utilisateur
          $correct_user_answers = array_intersect($user_answers[$question->id], $correct_answers);

          // Si toutes les bonnes réponses sont présentes dans les réponses utilisateur
          if (count($correct_user_answers) === count($correct_answers)) {
              $correct_count++;
          }
      }
  }

  // Calculer le score en pourcentage
  $score = ($total_questions > 0) ? ($correct_count / $total_questions) * 100 : 0;

  // Retourner true si le score est supérieur ou égal à 50%, sinon false
  return $score >= 50;
}

function calculate_assessment_score($assessment_id, $user_answers) {
  global $wpdb;
  
  $total_questions = 0;
  $correct_answers = 0;

  // Récupérer toutes les questions de l'évaluation
  $questions = $wpdb->get_results(
      $wpdb->prepare(
          "SELECT id FROM {$wpdb->prefix}question WHERE assessment_id = %d",
          $assessment_id
      )
  );

  // Parcourir les questions et comparer les réponses utilisateur
  foreach ($questions as $question) {
      $total_questions++;

      // Récupérer les réponses correctes pour cette question
      $correct_answers_db = $wpdb->get_col(
          $wpdb->prepare(
              "SELECT id FROM {$wpdb->prefix}answer WHERE question_id = %d AND is_correct = 1",
              $question->id
          )
      );

      // Vérification des réponses utilisateur pour cette question
      $user_answer_for_question = isset($user_answers[$question->id]) ? $user_answers[$question->id] : [];

      // Comparer les réponses utilisateur avec les bonnes réponses
      if (is_array($correct_answers_db) && is_array($user_answer_for_question)) {
          // Si toutes les bonnes réponses sont trouvées dans les réponses utilisateur
          $matched_answers = array_intersect($correct_answers_db, $user_answer_for_question);
          if (count($matched_answers) == count($correct_answers_db)) {
              $correct_answers++;
          }
      }
  }

  // Calculer le score comme un pourcentage
  if ($total_questions > 0) {
      return ($correct_answers / $total_questions) * 100;
  }

  return 0;
}

// Fonction pour tenter un assessment (soumission des réponses)
function attempt_assessment(WP_REST_Request $request) {

  global $wpdb;

  $assessment_id = $request->get_param('assessment_id');
  $user_id = $request->get_param('user_id'); // Récupère l'ID de l'utilisateur depuis le payload
  $answers = $request->get_json_params()['answers'];
  
  if (empty($answers)) {
      return new WP_Error('empty_answers', 'No answers provided', array('status' => 400));
  }

  // Logique pour enregistrer les réponses dans la base de données
  $result_id = process_assessment_attempt($assessment_id, $user_id, $answers);

  if ($result_id === false) {
      return new WP_Error('assessment_attempt_failed', 'Failed to process assessment attempt', array('status' => 500));
  }

  // Calculer le score et déterminer si l'utilisateur a réussi ou échoué
  $user_answers = [];
  foreach ($answers as $answer) {
      $user_answers[$answer['question_id']] = $answer['selected_answers'];
  }

  $score = calculate_assessment_score($assessment_id, $user_answers);
  $is_success = determine_assessment_success($assessment_id, $user_answers);
  
  // Ajouter des détails sur les réponses (correctes ou incorrectes)
  $formatted_answers = [];
  foreach ($answers as $answer) {
      $correct_answers = $wpdb->get_col(
          $wpdb->prepare(
              "SELECT id FROM {$wpdb->prefix}answer WHERE question_id = %d AND is_correct = 1",
              $answer['question_id']
          )
      );

      $correct_user_answers = array_intersect($answer['selected_answers'], $correct_answers);

      $formatted_answers[] = array(
          'question_id' => $answer['question_id'],
          'selected_answers' => $answer['selected_answers'],
          'correct' => count($correct_user_answers) === count($correct_answers)
      );
  }

  // Formater la réponse JSON
  $response = array(
      'message' => 'Assessment attempt processed successfully',
      'result_id' => $result_id, // ID du résultat enregistré dans la base de données
      'user_id' => $user_id,  // ID de l'utilisateur
      'assessment_id' => $assessment_id,  // ID de l'assessment
      'score' => $score,  // Score en pourcentage
      'is_success' => $is_success,  // Statut de réussite ou échec
      'completed_at' => current_time('mysql', true),  // Date et heure de la soumission
      'answers' => $formatted_answers,  // Détails des réponses soumises
  );

  return rest_ensure_response($response);
}

// Fonction pour récupérer une évaluation par son ID depuis la base de données
function get_wp_assessment_by_id($assessment_id) {
  global $wpdb;
  
  $query = "SELECT * FROM {$wpdb->prefix}assessments WHERE id = %d";
  $prepared_query = $wpdb->prepare($query, $assessment_id);
  
  return $wpdb->get_row($prepared_query);
}

// Fonction pour récupérer les questions pour une évaluation spécifique depuis la base de données
function get_wp_questions_by_assessment_id($assessment_id) {
  global $wpdb;
  
  $query = "SELECT * FROM {$wpdb->prefix}question WHERE assessment_id = %d";
  $prepared_query = $wpdb->prepare($query, $assessment_id);
  
  return $wpdb->get_results($prepared_query);
}
// Fonction pour récupérer une évaluation par son ID
function get_assessment(WP_REST_Request $request) {
  $assessment_id = $request->get_param('id');
  
  //  logique pour récupérer l'évaluation depuis la base de données
  $assessment = get_wp_assessment_by_id($assessment_id); // Fonction personnalisée
  
  if (!$assessment) {
      return new WP_Error('assessment_not_found', 'Assessment not found', array('status' => 404));
  }
  
  // Formater la réponse JSON
  $response = array(
      'id' => $assessment->id,
      'title' => $assessment->title,
      'slug' => $assessment->slug,
      'description' => $assessment->description,
      'duration' => $assessment->duration,
      'createdAt' => $assessment->createdAt,
      'updatedAt' => $assessment->updatedAt,
      'category_id' => $assessment->id_category,
      'is_public' => (bool) $assessment->is_public,
      'is_enabled' => (bool) $assessment->is_enabled,
  );
  
  return rest_ensure_response($response);
}

// Fonction pour récupérer les questions pour une évaluation spécifique
function get_questions_for_assessment(WP_REST_Request $request) {
  $assessment_id = $request->get_param('id');
  
  // Votre logique pour récupérer les questions depuis la base de données
  $questions = get_wp_questions_by_assessment_id($assessment_id); // Fonction personnalisée
  
  $formatted_questions = array();
  foreach ($questions as $question) {
      $formatted_questions[] = array(
          'id' => $question->id,
          'wording' => $question->wording,
          'createdAt' => $question->createdAt,
      );
  }
  
  return rest_ensure_response($formatted_questions);
}

function get_assessment_questions(WP_REST_Request $request) {
  global $wpdb;

  // Récupère l'ID de l'évaluation à partir de la requête
  $assessment_id = $request->get_param('assessment_id');

  if (empty($assessment_id)) {
      return new WP_Error('missing_assessment_id', 'Assessment ID is required', array('status' => 400));
  }

  // Vérifie si l'évaluation existe et est activée
  $assessment = $wpdb->get_row(
      $wpdb->prepare(
          "SELECT * FROM {$wpdb->prefix}assessments WHERE id = %d AND is_enabled = 1",
          $assessment_id
      )
  );

  if (!$assessment) {
      return new WP_Error('assessment_not_found', 'Assessment not found or not enabled', array('status' => 404));
  }

  // Récupère toutes les questions de l'évaluation
  $questions = $wpdb->get_results(
      $wpdb->prepare(
          "SELECT * FROM {$wpdb->prefix}question WHERE assessment_id = %d",
          $assessment_id
      )
  );

  if (empty($questions)) {
      return new WP_Error('no_questions_found', 'No questions found for this assessment', array('status' => 404));
  }

  // Préparer le tableau de retour pour les questions et leurs réponses
  $assessment_data = array(
      'assessment_id' => $assessment->id,
      'title' => $assessment->title,
      'description' => $assessment->description,
      'duration' => $assessment->duration,
      'questions' => array()
  );

  // Boucle pour chaque question et récupère les réponses associées
  foreach ($questions as $question) {
      $answers = $wpdb->get_results(
          $wpdb->prepare(
              "SELECT id, wording, is_correct FROM {$wpdb->prefix}answer WHERE question_id = %d",
              $question->id
          ),
          ARRAY_A // Format tableau associatif pour inclure les clés
      );

      // Ajoute chaque question avec ses réponses à la structure de retour
      $assessment_data['questions'][] = array(
          'question_id' => $question->id,
          'wording' => $question->wording,
          'answers' => $answers
      );
  }

  // Retourne les données de l'évaluation, des questions et des réponses
  return rest_ensure_response($assessment_data);
}


function get_assessment_statistics(WP_REST_Request $request) {
  global $wpdb;

  // Récupérer l'ID de l'utilisateur à partir des paramètres de la requête
  $user_id = $request->get_param('user_id');

  if (empty($user_id)) {
      return new WP_Error('missing_user_id', 'User ID is required', array('status' => 400));
  }

  // Récupérer le nombre total d'assessments tentés par l'utilisateur
  $total_attempts = $wpdb->get_var(
      $wpdb->prepare(
          "SELECT COUNT(*) FROM {$wpdb->prefix}result WHERE user_id = %d",
          $user_id
      )
  );

  // Récupérer le nombre d'assessments réussis (score >= 50)
  $successful_attempts = $wpdb->get_var(
      $wpdb->prepare(
          "SELECT COUNT(*) FROM {$wpdb->prefix}result WHERE user_id = %d AND score >= 50",
          $user_id
      )
  );

  // Récupérer le nombre d'assessments échoués (score < 50)
  $failed_attempts = $wpdb->get_var(
      $wpdb->prepare(
          "SELECT COUNT(*) FROM {$wpdb->prefix}result WHERE user_id = %d AND score < 50",
          $user_id
      )
  );

  // Retourner les statistiques sous forme de réponse JSON
  return rest_ensure_response(array(
      'user_id' => $user_id,
      'total_attempts' => (int) $total_attempts,
      'successful_attempts' => (int) $successful_attempts,
      'failed_attempts' => (int) $failed_attempts
  ));
}

function get_successful_assessments(WP_REST_Request $request) {
  global $wpdb;

  // Récupérer l'ID de l'utilisateur à partir des paramètres de la requête
  $user_id = $request->get_param('user_id');

  if (empty($user_id)) {
      return new WP_Error('missing_user_id', 'User ID is required', array('status' => 400));
  }

  // Requête pour obtenir les assessments réussis par l'utilisateur (score >= 50)
  $successful_assessments = $wpdb->get_results(
      $wpdb->prepare(
          "SELECT a.id, a.title, r.score, r.completed_at, COUNT(q.id) as question_count
          FROM {$wpdb->prefix}result r
          INNER JOIN {$wpdb->prefix}assessments a ON r.assessment_id = a.id
          LEFT JOIN {$wpdb->prefix}question q ON q.assessment_id = a.id
          WHERE r.user_id = %d AND r.score >= 50
          GROUP BY a.id, r.score, r.completed_at",
          $user_id
      )
  );

  // Vérifie s'il y a des assessments réussis
  if (empty($successful_assessments)) {
      return rest_ensure_response(array('message' => 'No successful assessments found for this user.'));
  }

  // Retourner les assessments réussis sous forme de réponse JSON
  return rest_ensure_response($successful_assessments);
}

function get_all_assessments_with_question_count(WP_REST_Request $request) {
  global $wpdb;

  // Récupère l'ID de l'utilisateur à partir de la requête
  $user_id = $GLOBALS['user_id'];

  if ($user_id == 0) {
      $response = new WP_REST_Response("You have to login with valid credentials!");
      $response->set_status(400);
      return $response;
  }

  // Récupérer le paramètre 'category_id' depuis la requête
  $category_id = $request['category_id'];

  // Construire la clause WHERE en fonction de la présence de category_id et de is_enabled
  $where_clause = "WHERE a.is_enabled = 1";
  if (!empty($category_id)) {
      $where_clause .= $wpdb->prepare(" AND a.category_id = %d", $category_id);
  }

  // Requête pour obtenir les assessments activés, filtrés par category_id si fourni
  $assessments = $wpdb->get_results(
      "SELECT a.id, a.title, a.slug, a.author_id, a.category_id, a.description, a.level, a.duration, a.is_public, a.is_enabled, COUNT(q.id) as question_count
      FROM {$wpdb->prefix}assessments a
      LEFT JOIN {$wpdb->prefix}question q ON q.assessment_id = a.id
      $where_clause
      GROUP BY a.id DESC"
  );

  // Si aucun assessment n'est trouvé pour la catégorie donnée, récupérer tous les assessments activés sans filtre de catégorie
  if (empty($assessments)) {
      $assessments = $wpdb->get_results(
          "SELECT a.id, a.title, a.author_id, a.category_id, a.description, a.level, a.duration, a.is_public, a.is_enabled, COUNT(q.id) as question_count
          FROM {$wpdb->prefix}assessments a
          LEFT JOIN {$wpdb->prefix}question q ON q.assessment_id = a.id
          WHERE a.is_enabled = 1
          GROUP BY a.id"
      );
  }

  // Vérifie s'il y a des assessments
  if (empty($assessments)) {
      return rest_ensure_response(array('message' => 'No assessments found.'));
  }

  // Parcourir les assessments et ajouter un champ "status" et "score" pour chaque évaluation
  foreach ($assessments as $assessment) {
      // Rechercher si l'utilisateur a un résultat pour cet assessment
      $result = $wpdb->get_row(
          $wpdb->prepare(
              "SELECT score, is_success FROM {$wpdb->prefix}result WHERE user_id = %d AND assessment_id = %d",
              $user_id,
              $assessment->id
          )
      );

      if ($result) {
          if ($result->is_success) {
              $assessment->status = 'validated'; // L'utilisateur a validé l'évaluation
          } else {
              $assessment->status = 'failed'; // L'utilisateur a échoué l'évaluation
          }
          $assessment->score = $result->score; // Inclure le score
      } else {
          $assessment->status = 'not_attempted'; // L'utilisateur n'a jamais tenté l'évaluation
          $assessment->score = null; // Pas de score car jamais tenté
      }

      // Récupérer les informations de l'auteur
      $author = get_user_by('ID', $assessment->author_id);
      if ($author) {
          $author_img = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
          $assessment->author = new Expert($author, $author_img);
      } else {
          $assessment->author = null;
      }

      // Récupérer les informations de la catégorie
      $assessment->category = [
          "name" => get_the_category_by_ID((int)$assessment->category_id),
          "image" => get_field('image', 'category_' . (int)$assessment->category_id) ?? ""
      ];
  }

  // Retourner les assessments avec le nombre de questions et le statut
  return rest_ensure_response($assessments);
}

function get_assessment_details(WP_REST_Request $request) {
  global $wpdb;

  // Récupérer l'ID de l'assessment depuis l'URL
  $assessment_slug = $request['assessment_slug'];

  // Vérifier si l'ID est null ou vide
  if (empty($assessment_slug)) {
      return new WP_REST_Response(array('message' => 'Assessment slug is required'), 400);
  }

  // Obtenir les détails de l'assessment et le nombre de questions associées
  $assessment = $wpdb->get_row(
      $wpdb->prepare(
          "SELECT a.id, a.title, a.slug, a.author_id, a.category_id, a.description, a.level, a.duration, a.is_public, a.is_enabled,
                  COUNT(q.id) as question_count
          FROM {$wpdb->prefix}assessments a
          LEFT JOIN {$wpdb->prefix}question q ON q.assessment_id = a.id
          WHERE a.slug = %s
          GROUP BY a.slug",
          $assessment_slug
      )
  );

  if (!$assessment) {
      return new WP_REST_Response(array('message' => 'Assessment not found'), 404);
  }

  // Récupérer les informations de l'auteur
  $author = get_user_by('ID', $assessment->author_id);
  if ($author) {
      $author_img = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      $assessment->author = [
          "name" => $author->display_name,
          "profile_image" => $author_img
      ];
  } else {
      $assessment->author = null;
  }

  // Récupérer les informations de la catégorie
  $assessment->category = [
      "name" => get_the_category_by_ID((int)$assessment->category_id),
      "image" => get_field('image', 'category_' . (int)$assessment->category_id) ?? ""
  ];

  return rest_ensure_response($assessment);
}

function archive_assessment(WP_REST_Request $request) {
  global $wpdb;

  // Récupérer l'ID de l'assessment
  $assessment_id = $request['assessment_id'];
  
  if (empty($assessment_id) || !is_numeric($assessment_id)) {
      return rest_ensure_response(['message' => 'Invalid assessment ID.'], 400);
  }

  // Récupérer la valeur actuelle de 'is_enabled'
  $current_status = $wpdb->get_var(
      $wpdb->prepare(
          "SELECT is_enabled FROM {$wpdb->prefix}assessments WHERE id = %d",
          $assessment_id
      )
  );

  // Vérifier si l'assessment existe
  if ($current_status === null) {
      return rest_ensure_response(['message' => 'Assessment not found.'], 404);
  }

  // Modifie is_enabled par le contraire de sa valeur
  $new_status = ($current_status == 1) ? 0 : 1;

  // Mettre à jour la valeur de 'is_enabled' dans la base de données
  $updated = $wpdb->update(
      "{$wpdb->prefix}assessments",
      ['is_enabled' => $new_status], // Colonnes à mettre à jour
      ['id' => $assessment_id],      // Condition WHERE
      ['%d'],                        // Format des colonnes
      ['%d']                         // Format de la condition
  );

  // Vérifier si l'update a réussi
  if ($updated === false) {
      return rest_ensure_response(['message' => 'Failed to toggle is_enabled status.'], 500);
  }

  // Retourner la nouvelle valeur
  return rest_ensure_response([
      'message' => 'is_enabled status updated successfully.',
      'assessment_id' => $assessment_id,
      'new_is_enabled' => $new_status
  ]);
}




/**
 * Likes endpoints 
 */


 function create_or_update_like(WP_REST_Request $request) {
  global $wpdb;

  $course_id = $request['course_id'];
  $user_id = $request['user_id'];
  $feedback_type = $request['feedback_type'];

  // Vérification des paramètres requis
  if (empty($course_id) || empty($feedback_type)) {
      return new WP_REST_Response("Course ID and feedback type are required", 400);
  }

  if ($user_id == 0 || null) {
      return new WP_REST_Response("You have to login with valid credentials!", 400);
  }

  $feedback_keywords =  array(
    'like' ,    
    'educational',
    'issues' ,
    'fake_news',
    'sales' 
  );

  if (!in_array($feedback_type,$feedback_keywords)) {
    return new WP_REST_Response("This feedback type doesnt exist!", 400);
}


  // Vérifier si l'utilisateur a déjà donné un feedback pour ce cours
  $existing_like = $wpdb->get_row(
      $wpdb->prepare(
          "SELECT id, feedback_value FROM {$wpdb->prefix}likes
           WHERE course_id = %d AND user_id = %d",
          $course_id,
          $user_id
      )
  );

  if ($existing_like) {
      // Si l'utilisateur soumet le même feedback, on considère que c'est une suppression
      if ($existing_like->feedback_value === $feedback_type) {
          $wpdb->delete("{$wpdb->prefix}likes", ['id' => $existing_like->id]);
          $message = "Feedback removed successfully.";
      } else {
          // Sinon, on met à jour avec le nouveau type de feedback
          $wpdb->update(
              "{$wpdb->prefix}likes",
              ['feedback_value' => $feedback_type],
              ['id' => $existing_like->id]
          );
          $message = "Feedback updated successfully.";
      }
  } else {
      // Création d'un nouveau feedback
      $wpdb->insert(
          "{$wpdb->prefix}likes",
          [
              'user_id' => $user_id,
              'course_id' => $course_id,
              'feedback_value' => $feedback_type,
          ]
      );
      $message = "Feedback created successfully.";
  }

  // Récupérer les statistiques pour ce cours
  $stats = $wpdb->get_row(
      $wpdb->prepare(
          "SELECT 
              SUM(CASE WHEN feedback_value = 'like' THEN 1 ELSE 0 END) as `like`,
              SUM(CASE WHEN feedback_value = 'educational' THEN 1 ELSE 0 END) as `educational`,
              SUM(CASE WHEN feedback_value = 'issues' THEN 1 ELSE 0 END) as `issues`,
              SUM(CASE WHEN feedback_value = 'fake_news' THEN 1 ELSE 0 END) as `fake_news`,
              SUM(CASE WHEN feedback_value = 'sales' THEN 1 ELSE 0 END) as `sales`
           FROM {$wpdb->prefix}likes
           WHERE course_id = %d",
          $course_id
      )
  );

  // Vérifier quel feedback l'utilisateur a donné
  $user_feedback = ($existing_like && $existing_like->feedback_value === $feedback_type) ? null : $feedback_type;

  // Préparer les données de réponse
  $data = [
      'user_feedback' => $user_feedback,
      'like' => (int) $stats->like,
      'educational' => (int) $stats->educational,
      'issues' => (int) $stats->issues,
      'fake_news' => (int) $stats->fake_news,
      'sales' => (int) $stats->sales,
  ];

  // Retourner le message et les données
  return rest_ensure_response(['message' => $message, 'data' => $data]);
}


function get_user_course_feedback(WP_REST_Request $request) {
  global $wpdb;

  $course_id = $request['course_id'];
  $user_id = $GLOBALS['user_id'] ?? 0;

  // Vérification des paramètres requis
  if (empty($course_id)) {
      return new WP_REST_Response("Course ID is required", 400);
  }

  if ($user_id == 0) {
      return new WP_REST_Response("You have to login with valid credentials!", 400);
  }

  // Récupérer le feedback de l'utilisateur pour ce cours, s'il existe
  $user_feedback = $wpdb->get_var(
      $wpdb->prepare(
          "SELECT feedback_value FROM {$wpdb->prefix}likes
           WHERE course_id = %d AND user_id = %d",
          $course_id,
          $user_id
      )
  );

  // Récupérer les statistiques de feedback pour ce cours
  $stats = $wpdb->get_row(
      $wpdb->prepare(
          "SELECT 
              SUM(CASE WHEN feedback_value = 'like' THEN 1 ELSE 0 END) as `like`,
              SUM(CASE WHEN feedback_value = 'educational' THEN 1 ELSE 0 END) as `educational`,
              SUM(CASE WHEN feedback_value = 'issues' THEN 1 ELSE 0 END) as `issues`,
              SUM(CASE WHEN feedback_value = 'fake_news' THEN 1 ELSE 0 END) as `fake_news`,
              SUM(CASE WHEN feedback_value = 'sales' THEN 1 ELSE 0 END) as `sales`
           FROM {$wpdb->prefix}likes
           WHERE course_id = %d",
          $course_id
      )
  );

  
  $data = [
      'user_feedback' => $user_feedback ?? null, // null si l'utilisateur n'a pas encore donné de feedback
      'like' => (int) $stats->like,
      'educational' => (int) $stats->educational,
      'issues' => (int) $stats->issues,
      'fake_news' => (int) $stats->fake_news,
      'sales' => (int) $stats->sales,
  ];

  // Retourner les données
  return rest_ensure_response(['message' => "Course feedback retrieved successfully", 'data' => $data]);
}

function get_course_feedback(WP_REST_Request $request) {
  global $wpdb;

  $course_id = $request['course_id'];

  // Vérification des paramètres requis
  if (empty($course_id)) {
      return new WP_REST_Response("Course ID is required", 400);
  }


  // Récupérer les statistiques de feedback pour ce cours
  $stats = $wpdb->get_row(
      $wpdb->prepare(
          "SELECT 
              SUM(CASE WHEN feedback_value = 'like' THEN 1 ELSE 0 END) as `like`,
              SUM(CASE WHEN feedback_value = 'educational' THEN 1 ELSE 0 END) as `educational`,
              SUM(CASE WHEN feedback_value = 'issues' THEN 1 ELSE 0 END) as `issues`,
              SUM(CASE WHEN feedback_value = 'fake_news' THEN 1 ELSE 0 END) as `fake_news`,
              SUM(CASE WHEN feedback_value = 'sales' THEN 1 ELSE 0 END) as `sales`
           FROM {$wpdb->prefix}likes
           WHERE course_id = %d",
          $course_id
      )
  );

  
  $data = [
      'like' => (int) $stats->like,
      'educational' => (int) $stats->educational,
      'issues' => (int) $stats->issues,
      'fake_news' => (int) $stats->fake_news,
      'sales' => (int) $stats->sales,
  ];

  // Retourner les données
  return rest_ensure_response(['message' => "Course feedback retrieved successfully", 'data' => $data]);
}


 /**
 * Likes endpoints 
 */

  

 /**
  * Last views endpoint
  */

  function addToFixedArray($array, $element, $maxSize = 6) {
    if (count($array) < $maxSize) {
        $array[] = $element; // Ajouter l'élément si le tableau n'est pas complet.
    } else {
        array_shift($array); // Supprimer le premier élément.
        $array[] = $element; // Ajouter le nouvel élément à la fin.
    }
    return $array;
}

function getCoursesFromIds($ids, $postType = 'course') {

    $args = [
        'post_type' => $postType,
        'post__in' => $ids,
        'orderby' => 'post__in',
        'posts_per_page' => -1
    ];
    return empty($ids) ? [] : get_posts($args);
}

function getCompleteCourses($ids, $postType = 'course', $maxSize = 6) {
    // Récupérer les cours correspondant aux IDs
    $courses = getCoursesFromIds($ids, $postType);

    // Si le nombre de cours est inférieur à $maxSize
    if (count($courses) < $maxSize) {
        $args = [
            'post_type' => $postType,
            'posts_per_page' => $maxSize - count($courses),
            'post__not_in' => $ids, // Exclure les IDs déjà présents
            'orderby' => 'rand',
            'meta_query' => [
                [
                    'key' => 'course_type',
                    'value' => ['podcast', 'video'],
                    'compare' => 'IN'
                ]
            ]
        ];
        $randomCourses = get_posts($args);

        // Ajouter les cours aléatoires pour compléter la liste
        $courses = array_merge($courses, $randomCourses);
    }

    return $courses;
}

  function getLastViewedPodcastOrVideoListfunction ()
  {
    $user_id = $GLOBALS['user_id'];
    $ids = get_user_meta($user_id, 'recent_views', true) ?: [];
    $courses = getCompleteCourses($ids);
    $refactored_courses = [];
    
    for ($i = 0; $i < count($courses); $i++) {
      $courses[$i]->visibility = get_field('visibility', $courses[$i]->ID) ?? [];
      $author = get_user_by('ID', $courses[$i]->post_author);
      $author_company = get_field('company', 'user_' . (int) $author->ID)[0];
      if ($courses[$i]->visibility != []) {
          if ($author_company != $current_user_company) continue;
      }
      $author_img = get_field('profile_img', 'user_' . $author->ID) ? get_field('profile_img', 'user_' . $author->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      $courses[$i]->experts = array();
      $experts = get_field('experts', $courses[$i]->ID);
      if (!empty($experts)) {
          foreach ($experts as $key => $expert) {
              $expert = get_user_by('ID', $expert);
              $experts_img = get_field('profile_img', 'user_' . $expert->ID) ? get_field('profile_img', 'user_' . $expert->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
              array_push($courses[$i]->experts, new Expert($expert, $experts_img));
          }
      }

      $courses[$i]->author = new Expert($author, $author_img);
      $courses[$i]->longDescription = get_field('long_description', $courses[$i]->ID);
      $courses[$i]->shortDescription = get_field('short_description', $courses[$i]->ID);
      $courses[$i]->courseType = get_field('course_type', $courses[$i]->ID);
      $courses[$i]->youtubeVideos = get_field('youtube_videos',$courses[$i]->ID) ? get_field('youtube_videos',$courses[$i]->ID) : []  ; ///
      $image = get_field('preview', $courses[$i]->ID)['url'];
      if (!$image) {
          $image = get_the_post_thumbnail_url($courses[$i]->ID);
          if (!$image) $image = get_field('url_image_xml', $courses[$i]->ID);
          if (!$image) $image = get_stylesheet_directory_uri() . '/img/' . strtolower($courses[$i]->courseType) . '.jpg';
      }
      $courses[$i]->pathImage = $image;
      $courses[$i]->price = get_field('price', $courses[$i]->ID) ?? 0;
      $courses[$i]->language = get_field('language', $courses[$i]->ID) ?? "";
      $courses[$i]->connectedProduct = get_field('connected_product', $courses[$i]->ID);
      $tags = get_field('categories', $courses[$i]->ID) ?? [];
      $courses[$i]->tags = array();
      if ($tags) {
          if (!empty($tags)) {
              foreach ($tags as $key => $category) {
                  if (isset($category['value'])) {
                      $tag = new Tags($category['value'], get_the_category_by_ID($category['value']));
                      array_push($courses[$i]->tags, $tag);
                  }
              }
          }
      }
      $new_course = new CourseOptimized($courses[$i],true);
      array_push($refactored_courses, $new_course);
  }
    return rest_ensure_response($refactored_courses);
  }

  function updateLastViewdPodcastorVideoListfunction ($request) 
  {
    $params = $request->get_json_params();
    $newId = isset($params['course_id']) ? intval($params['course_id']) : null;

    if (!$newId) {
        return new WP_Error('invalid_course_id', 'Invalid course ID provided', ['status' => 400]);
    }
    $user_id = $GLOBALS['user_id'];
    $ids = get_user_meta($user_id, 'recent_views', true) ?: [];
    $ids = addToFixedArray($ids, $newId);
    update_user_meta(get_current_user_id(), 'recent_views', $ids);
    return rest_ensure_response(['message' => 'Course updated successfully', 'updated_courses' => $ids]);
  }

  /**
  * Last views endpoint
  */


  /**
  * Highlighted courses endpoint
  */

    function get_highlighted_courses()
    {
      $featured = get_field('featured', 'user_' . 5);
      if (!empty($featured ))
      {
        $courses = array();
        foreach ($featured as $key => $course) 
        {
              $course->visibility = get_field('visibility',$course->ID) ?? [];
              $course->visibility = get_field('visibility',$course->ID) ?? [];
              $author = get_user_by( 'ID', $course -> post_author  );
              $author_company = get_field('company', 'user_' . (int) $author -> ID)[0];
              if ($course->visibility != []) 
                if ($author_company != $current_user_company)
                  continue;
                $author = get_user_by( 'ID', $course -> post_author  );
                $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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
                array_push($courses ,new Course($course)); 
        }
      }
      return rest_ensure_response($courses);
    }

  /**
  * Highlighted courses endpoint
  */


  
