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
    $sample['ID'] = $post->ID;
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
    if(!$is_liggeey || !$value->first_name) // No more condition "is Liggeey"
      continue;
    // if(!$value->first_name)
    //   continue;

    $sample['ID'] = $value->ID;
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
function candidateDetail(WP_REST_Request $request){

  $param_user_id = $request['id'] ? $request['id'] : get_current_user_id();

  $sample = array();
  $user = get_user_by('ID', $param_user_id);

  $sample['ID'] = $user->ID;
  $sample['first_name'] = $user->first_name;
  $sample['last_name'] = $user->last_name;
  $sample['image'] = get_field('profile_img',  'user_' . $user->ID) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  $sample['last_name'] = $user->last_name;
  $sample['country'] = get_field('country',  'user_' . $user->ID) ? : 'N/A';

  $member_since = new DateTimeImmutable($user->user_registered_at);
  $sample['member_since'] = $member_since->format('M d, Y');
  
  $sample['experience'] = get_field('experience',  'user_' . $user->ID) ? : 'N/A';

  $date_born = get_field('date_born',  'user_' . $user->ID);
  if(!$date_born)
      $age = "No birth";
  else{
      //explode the date to get month, day and year
      $birthDate = explode("/", $date_born);
      //get age from date or birthdate
      $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")
          ? ((date("Y") - $birthDate[2]) - 1)
          : (date("Y") - $birthDate[2]));
      $age .= ' Years';
  } 
  $sample['age'] = $age;

  $sample['gender'] = get_field('gender',  'user_' . $user->ID) ? : 'N/A!';
  $sample['language'] = get_field('language',  'user_' . $user->ID) ? : array(); 
  $sample['education_level'] = get_field('education_level',  'user_' . $user->ID) ? : array(); 
  $sample['social_network']['facebook'] = get_field('facebook',  'user_' . $user->ID) ? : '';
  $sample['social_network']['twitter'] = get_field('twitter',  'user_' . $user->ID) ? : '';
  $sample['social_network']['instagram'] = get_field('instagram',  'user_' . $user->ID) ? : ''; 
  $sample['social_network']['linkedin'] = get_field('linkedin',  'user_' . $user->ID) ? : '';
  $sample['biographical_info'] = get_field('biographical_info',  'user_' . $user->ID) ? : 
  "This paragraph is dedicated to expressing skills what I have been able to acquire during professional experience.<br> 
  Outside of let'say all the information that could be deemed relevant to a allow me to be known through my cursus.";

  //Education Information
  $main_education = get_field('education',  'user_' . $user->ID);
  $educations = array();
  foreach($main_education as $value):

    $education = array();
    if(!$value)
      continue;

    $explosion = explode(";", $value);

    $year = ""; 
    if(isset($explosion[2]))
        $year = explode("-", $explosion[2])[0];

    if(isset($explosion[3]))
        if(intval($explosion[2]) != intval($explosion[3]))
            $year = $year . "-" .  explode("-", $explosion[3])[0];

    $education['diploma'] = $explosion[1];
    $education['year'] = $year;
    $education['school'] = $explosion[0];
    $education['description'] = $explosion[4];
    $educations[] = $education;

  endforeach; 
  $sample['educations'] = $educations;
  
  //Work & Experience Information
  $main_experience = get_field('work',  'user_' . $user->ID);
  $experiences = array();
  foreach($main_experience as $value):

    $experience = array();
    if(!$value)
      continue;

    $explosion = explode(";", $value);

    $year = ""; 
    if(isset($explosion[2]))
        $year = explode("-", $explosion[2])[0];

    if(isset($explosion[3]))
        if(intval($explosion[2]) != intval($explosion[3]))
            $year = $year . "-" .  explode("-", $explosion[3])[0];

    $experience['company'] = $explosion[1];
    $experience['year'] = $year;
    $experience['job'] = $explosion[0];
    $experience['description'] = $explosion[4];
    $experiences[] = $experience;

  endforeach; 
  $sample['experiences'] = $experiences;

  $sample = (Object)$sample;

  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;

}

//Detail artikel
function artikelDetail(WP_REST_Request $request){

  $param_post_id = $request['id'] ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  $sample['ID'] = $post->ID;
  $sample['title'] = $post->post_title;
  $sample['author_name'] = $user->first_name . ' ' . $user->last_name;
  $sample['author_image'] = get_field('profile_img',  'user_' . $post->post_author) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  $post_date = new DateTimeImmutable($post->post_date);
  $sample['post_date'] = $post_date->format('M d, Y');
  $reviews = get_field('reviews', $post->ID);
  $sample['number_comments'] = (!empty($reviews)) ? count($reviews) : 0;
  $sample['content'] = get_field('article_itself', $post->ID) ? : get_field('long_description', $post->ID);
  
  //Reviews | Comments
  $comments = array();
  $main_reviews = get_field('reviews', $post->ID);
  foreach($main_reviews as $review):
    $user = $review['user'];
    $author_name = ($user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name; 
    $image_author = get_field('profile_img',  'user_' . $user->ID);
    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
    $company = get_field('company',  'user_' . $user->ID);
    $title = $company[0]->post_title;

    $comment = array();
    $comment['comment_author_name'] = $author_name ;
    $comment['comment_author_image'] = $image_author;
    $comment['rating'] = $review['rating'];

    $comments[] = $comment;
  endforeach;
  $sample['comments'] = $comments;

  $sample = (Object)$sample;

  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;  
}
  



/* * End Liggeey * */