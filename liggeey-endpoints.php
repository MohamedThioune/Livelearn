<?php

/* * Liggeey * */

//Home page [GET]
function homepage(){
  $categories = [];
  $artikels = [];
  $candidates = [];
  $infos = array('categories' => $categories, 'artikels' => $artikels, 'candidates' => $candidates);

  $errors = ['errors' => '', 'error_data' => ''];
  $limit_post = 3;
  $limit_candidate = 20;

  //Error message 
  // if(1):
  //   $errors['errors'] = "";
  //   $errors = (Object)$errors;
  //   $response = new WP_REST_Response($errors); 
  //   $response->set_status(400);
  //   return $response;
  // endif;

  //Category [Block]
  $categories = array();
  $sample_categories = array(
                'Digital Marketing', 'Digital Project Manager', 'Community Manager', 'Social Media Manager', 
                'Webdesigner', '3D Illustrator', 'UX Designer',
                'Data Analyst', 'Salesforce', 'Google', 'Web Project Manager', 'COMMCARE', 'DHIS2', 'DRUPAL', 
                'Wordpress', 'Webflow', 'Odoo', 'Prestashop'); 
  foreach ($sample_categories as $key => $category){
    $sample = array();
    $sample['cat_ID'] = $key;
    $sample['cat_name'] = $category;
    $sample = (Object)$sample;

    array_push($categories, $sample);
  }
  $infos['categories'] = $categories;

  //Article [Block]
  $args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1,
  );
  $posts = get_posts($args);

  $i = 0;
  foreach($posts as $post):
    $sample = array();

    //Hidden post
    $hidden = get_field('visibility', $post->ID);
    if($hidden)
      continue;

    //Generic informations
    $sample['permalink'] = get_permalink($post->ID);
    $sample['post_title'] = $post->post_title;
    $sample['short_description'] = get_field('short_description', $post->ID) ?: 'Empty till far ...';
    $sample['long_description'] = get_field('long_description', $post->ID) ?: 'Empty till far ...';
  
    $course_type = get_field('course_type', $post->ID);
    //Image information
    $thumbnail = get_field('preview', $post->ID)['url'];
    if(!$thumbnail){
        $thumbnail = get_the_post_thumbnail_url($post->ID);
        if(!$thumbnail)
            $thumbnail = get_field('url_image_xml', $post->ID);
                if(!$thumbnail)
                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
    }
    $sample['image'] = $thumbnail;

    //Author information
    // $author = get_user_by('ID', $post->post_author);
    // $name_author = ($author) ? $author->display_name : 'None';
    // $user_id = get_current_user_id();
    // if($author->ID != $user_id)
    //     $name = ($author->last_name) ? $author->first_name : $author->display_name;
    // else
    //     $name = "Ikzelf";

    // $image_author = get_field('profile_img',  'user_' . $post->post_author);
    // if(!$image_author)
    //     $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";

    $sample = (Object)$sample;
    array_push($artikels, $sample);

    $i += 1;
    if($i >= $limit_post)
      break;

  endforeach;
  $infos['artikels'] = $artikels;

  $users = get_users();
  //Featured candidates [Block]
  $i = 0;
  foreach ($users as $key => $value) {
    $sample = array();

    //Is Liggeey User
    $is_liggeey = get_field('is_liggeey', 'user_' . $value->ID);
    // if(!$is_liggeey || !$value->first_name) // No more condition "is Liggeey"
    //   continue;
    if(!$value->first_name)
      continue;
    
    $sample['permalink'] = get_site_url() . '/user-overview/?id=' . $value->ID; 
    $sample['first_name'] = $value->first_name;
    $sample['last_name'] = $value->last_name;
    $sample['display_name'] = $value->display_name;

    $sample['image'] = get_field('profile_img',  'user_' . $value->ID) ?: get_stylesheet_directory_uri() ."/img/placeholder_user.png";
    $sample['work_as'] = get_field('role',  'user_' . $value->ID) ?: "Free agent";
    $sample['country'] = get_field('country',  'user_' . $value->ID) ?: "International";
    $sample = (Object)$sample;

    array_push($candidates, $sample);

    $i += 1; 
    if($i >= $limit_candidate)
      break;

  }
  $infos['candidates'] = $candidates;

  //Response
  $response = new WP_REST_Response($infos);
  $response->set_status(200);
  return $response;

}

// Register the company chief
function register_company(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['first_name', 'last_name', 'email', 'bedrijf', 'phone', 'password', 'password_confirmation'];
  //country ?

  //Check required parameters register
  foreach ($required_parameters as $required):

    if (!isset($request[$required])):
      $errors['errors'] = $required . " field is missing !";
      $errors = (Object)$errors;
      $response = new WP_REST_Response($errors); 
      $response->set_status(400);
      return $response;
    elseif ($request[$required] == false):
      $errors['errors'] = $required . " field is missing value !";
      $errors = (Object)$errors;
      $response = new WP_REST_Response($errors); 
      $response->set_status(400);
      return $response;
    endif;

  endforeach;

  //Get value fields
  $first_name = $request['first_name'] ?? false;
  $last_name = $request['last_name'] ?? false;
  $email = $request['email'] ?? false;
  $bedrijf = $request['bedrijf'] ?? false;
  $phone = $request['phone'] ?? false;
  $country = $request['country'] ?? false;
  $password = $request['password'] ?? false;
  $password_confirmation = $request['password_confirmation'] ?? false;

  //Password confirmation match ?
  if($password != $password_confirmation):
    $errors['errors'] = "the passwords did not match !";
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors); 
    $response->set_status(400);
    return $response;
  endif;

  //Create the user
  $userdata = array(
      'first_name' => $first_name,
      'last_name' => $last_name,
      'display_name' => $first_name . ' ' . $last_name,
      'user_url' => 'https://livelearn.nl/inloggen/',
      'user_login' => $email,
      'user_email' => $email,
      'user_pass' => $password,
      'role' => 'hr'
  );
  $user_id = wp_insert_user(wp_slash($userdata));  
  
  //Check if there are no errors
  if(is_wp_error($user_id)):
    $errors['errors'] = $user_id;
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors); 
    $response->set_status(400);
    return $response;
  endif; 

  
  //Create the company
  $args = array(
    'post_type'   => 'company',
    'post_author' => 3,
    'post_status' => 'pending',
    'post_title'  => $bedrijf
  );
  $company_id = wp_insert_post($args);
  $company = get_post($company_id);
  update_field('company_country', $country, $company_id);

  //Affect the company to the user 
  update_field('company', $company, 'user_' . $user_id);

  //Is from liggeey
  update_field('is_liggeey', true, 'user_' . $user_id);

  $company = array($company);

  //Get user created information
  $user = get_user_by('ID', $user_id);
  
  //Sending email notification
  // $first_name = $user->first_name ?: $user->display_name;
  // $email = $user->user_email;
  // $path_mail = '/templates/mail-notification-invitation.php';
  // require(__DIR__ . $path_mail); 
  // $subject = 'Je hebt een nieuwe volger !';
  // $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
  // wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' )) ;

  //Send response
  $response = new WP_REST_Response($user);
  $response->set_status(200);
  return $response;

}

//Detail candidate
function detail_candidate($data){
  $param_user_id = $data['id'];
  $user = get_user_by('ID', $param_user_id);
   if(empty($user))
     return 0;
  //Get further information about candidate
  $user->profile_img = get_field('profile_img', 'user_' . $user->ID);

  return $user;
}

//Detail artikel
function detail_artikel($data){
  $param_post_id = $data['id'];
  $post = get_post($param_post_id);
  
  //Get further information about artikel
  $content = get_field('content', $post->ID);

 $reviews = get_field('reviews', $post->ID);
 $author_id = $post->post_author;

  $title = $post->post_title;

  return $post;
}
  



/* * End Liggeey * */