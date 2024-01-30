<?php

/* * Liggeey * */

// Function

//Detail artikel
function artikel($id){

  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);
  $course_type = get_field('course_type', $post->ID);

  $sample['ID'] = $post->ID;
  $sample['title'] = $post->post_title;
  //Image information
  $thumbnail = get_field('preview', $post->ID)['url'];
  if(!$thumbnail){
      $thumbnail = get_the_post_thumbnail_url($post->ID);
      if(!$thumbnail)
          $thumbnail = get_field('url_image_xml', $post->ID);
              if(!$thumbnail)
                  $thumbnail = get_stylesheet_directory_uri() . '/img' . '/artikel.jpg';
  }
  $sample['image'] = $thumbnail;
  $author = get_user_by('ID', $post->post_author);
  $sample['author_name'] = ($author) ? $author->first_name . ' ' . $author->last_name : 'xxxx xxxx';
  $sample['author_image'] = get_field('profile_img',  'user_' . $post->post_author) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  $post_date = new DateTimeImmutable($post->post_date);
  $sample['post_date'] = $post_date->format('M d, Y');
  $reviews = get_field('reviews', $post->ID);
  $sample['number_comments'] = (!empty($reviews)) ? count($reviews) : 0;
  $sample['short_description'] = get_field('short_description', $post->ID) ?: 'Empty till far ...';
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

  return $sample;  
}

//Detail job 
function job($id){

  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  $sample['ID'] = $post->ID;
  $sample['title'] = $post->post_title;
  $sample['posted_at'] = $post->post_date;
  $sample['expired_at'] = get_field('job_expiration_date', $post->ID);
  $sample['description'] = get_field('job_description', $post->ID);
  $sample['responsibilities'] = get_field('job_responsibilities', $post->ID);
  $sample['skills_experiences'] = get_field('job_skills_experiences', $post->ID);

  $company = get_field('job_company', $post->ID);
  $main_company = array();
  $main_company['title'] = !empty($company) ? $company->post_title : 'xxxx';
  $main_company['logo'] = !empty($company) ? get_field('company_logo',  $company->ID) : $placeholder;
  $main_company['sector'] = !empty($company) ? get_field('company_sector',  $company->ID) : 'xxxx';
  $main_company['size'] = !empty($company) ? get_field('company_size',  $company->ID) : 'xxxx';
  $main_company['email'] = !empty($company) ? get_field('company_email',  $company->ID) : 'xxxx';
  $main_company['place'] = !empty($company) ? get_field('company_place',  $company->ID) : 'xxxx';
  $main_company['country'] = !empty($company) ? get_field('company_country',  $company->ID) : 'xxxx';
  $main_company['website'] = !empty($company) ? get_field('company_website',  $company->ID) : 'xxxx';
  $sample['company'] = (Object)$main_company;

  $sample['skills'] = get_the_terms( $post->ID, 'course_category' );

  $sample = (Object)$sample;
  return $sample;  
}

//Detail company
function company($id){
  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  //var_dump($post);
  //assigner les champs
  $sample['ID'] = $post->ID;
  $sample['title'] = $post->post_title;
  $sample['address'] = get_field('company_address', $post->ID) ?: 'xxxxx';
  $sample['place'] = get_field('company_place', $post->ID) ?: 'xxxx xxx';
  $sample['country'] = get_field('company_country', $post->ID) ?: 'xxxx';
  $sample['biography'] = get_field('company_bio', $post->ID) ?: '';

  $sample['website'] =  get_field('company_website', $post->ID) ?: 'www.livelearn.nl';
  $sample['size'] =  get_field('company_size', $post->ID) ?: 'xx';

  $sample['email'] = get_field('company_email', $post->ID) ?: 'xxxxx@xxx.nl';

  $sample['sector'] = get_field('company_sector', $post->ID) ?: 'xxxxx';
  $sample['logo'] = get_field('company_logo', $post->ID)? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  
  $sample = (Object)$sample;

  return $sample; 
}

function validated($required_parameters, $request){
  $errors = ['errors' => '', 'error_data' => ''];

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

  return 1;
}
//end function

//[GET]Home page
function homepage(){
  $categories = [];
  $artikels = [];
  $candidates = [];
  $infos = array('categories' => $categories, 'artikels' => $artikels, 'candidates' => $candidates);

  $errors = ['errors' => '', 'error_data' => ''];
  $limit_post = 3;
  $limit_candidate = 20;

  //Category [Block]
  $categories = array();
  // $sample_categories = array(
  //   'Digital Marketing', 'Digital Project Manager', 'Community Manager', 'Social Media Manager', 
  //   'Webdesigner', '3D Illustrator', 'UX Designer',
  //   'Data Analyst', 'Salesforce', 'Google', 'Web Project Manager', 'COMMCARE', 'DHIS2', 'DRUPAL', 
  //   'Wordpress', 'Webflow', 'Odoo', 'Prestashop'); 

  //Category information
  $no_content = "Some information missing !";
  $digital_category = get_categories(array('taxonomy' => 'course_category', 'slug' => 'digital', 'hide_empty' => 0) )[0];
  if(is_wp_error($digital_category)):
      echo $no_content;
      return $infos;
  endif;

  $sample_categories = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'parent'     => $digital_category->cat_ID,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );  
  
  foreach ($sample_categories as $key => $category){
    if(!$category)
      continue;
    $sample = array();
    $sample['cat_ID'] = $category->cat_ID;
    $sample['cat_name'] = $category->cat_name;
    $image_category = get_field('image', 'category_'. $category->cat_ID);
    $sample['cat_image'] = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';

    /** Global jobs **/
    $tax_query = array(
      array(
        "taxonomy" => "course_category",
        "field"    => "term_id",
        "terms"    => [$category->cat_ID]
      )
    );
    $jobs = array();
    $args = array(
      'post_type' => 'job',
      'tax_query' => $tax_query
    );
    $query_jobs = new WP_Query( $args );
    $open_position = isset($query_jobs->posts) ? count($query_jobs->posts) : 0;

    $sample['open_position'] = $open_position;

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

//[POST]Register the company chief
function register_company(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['first_name', 'last_name', 'email', 'bedrijf', 'phone', 'password', 'password_confirmation'];
  //country ?

  //Check required parameters register
  $validated = validated($required_parameters, $request);

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
  update_field('company_is_liggeey', 1, $company->ID);
  update_field('company_country', $country, $company->ID);

  //Affect the company to the user 
  update_field('company', $company, 'user_' . $user_id);

  //Is from liggeey :company
  update_field('is_liggeey', 'chief', 'user_' . $user_id);

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

//[POST]Login 
// function login(WP_REST_Request $request){
//   $errors = ['errors' => '', 'error_data' => ''];
//   $required_parameters = ['user_name', 'password'];
//   //country ?

//   //Check required parameters register
//   $validated = validated($required_parameters, $request);

//   //Get value fields
//   $user_login = $request['user_name'] ?? false;
//   $user_password = $request['password'] ?? false;

//   $credentials = array(
//     'user_login'    => $user_login,
//     'user_password' => $user_password,
//     'remember'      => true,
//   );

//   $user = wp_signon($credentials);

//   if(is_wp_error($user)):
//     $response = new WP_REST_Response($user); 
//     $response->set_status(401);
//     return $response;
//   endif;
// }

//[POST]Detail candidate
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
  $sample['social_network']['facebook'] = get_field('facebook',  'user_' . $user->ID) ? : '#';
  $sample['social_network']['twitter'] = get_field('twitter',  'user_' . $user->ID) ? : '#';
  $sample['social_network']['instagram'] = get_field('instagram',  'user_' . $user->ID) ? : '#'; 
  $sample['social_network']['linkedin'] = get_field('linkedin',  'user_' . $user->ID) ? : '#';

  //Get Topics
  // $topics_external = get_user_meta($user_id, 'topic');
  // $topics_internal = get_user_meta($user_id, 'topic_affiliate');
  // $topics = array();
  // if(!empty($topics_external))
  //   $topics = !empty($topics_external) $topics_external;

  // if(!empty($topics_internal))
  //   foreach($topics_internal as $item)
  //       array_push($topics, $item);

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

//[POST]Detail artikel
function artikelDetail(WP_REST_Request $request){
  $param_post_id = $request['id'] ?? 0;
  $sample = artikel($param_post_id);

  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;  
}

//[POST]Detail company 
function companyDetail(WP_REST_Request $request){
  $param_post_id = $request['id'] ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  //assigner les champs
  $sample['ID'] = $post->ID;
  $sample['title'] = $post->post_title;
  $sample['address'] = get_field('company_address', $post->ID) ?: 'xxxxx';
  $sample['place'] = get_field('company_place', $post->ID) ?: 'xxxx xxx';
  $sample['country'] = get_field('company_country', $post->ID) ?: 'xxxx';
  $sample['biography'] = get_field('company_bio', $post->ID) ?: '';

  $sample['website'] =  get_field('company_website', $post->ID) ?: 'www.livelearn.nl';
  $sample['size'] =  get_field('company_size', $post->ID) ?: 'xx';

  $sample['email'] = get_field('company_email', $post->ID) ?: 'xxxxx@xxx.nl';

  $sample['sector'] = get_field('company_sector', $post->ID) ?: 'xxxxx';
  $sample['logo'] = get_field('company_logo', $post->ID)? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  //Open position
  $args = array(
    'post_type' => 'job',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'ordevalue' => $post->ID,
    'order' => 'DESC' ,
    'meta_key' => 'job_company',
    'meta_value' => $post->ID
  );
  $jobs = get_posts($args);
  $sample['count_open_jobs'] = empty($jobs) ? 0 : count($jobs);
  $sample['open_jobs'] = empty($jobs) ? array() : $jobs;
  
  $response = new WP_REST_Response($sample);
  $response->set_status(200);
  
  return $response; 
}

//[GET]All companies 
function allCompanies(){
   
  $args = array(
      'post_type' => 'company',  
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );
  $company_posts = get_posts($args);
  $companies = array();

  // Boucle pour afficher les résultats
  foreach ($company_posts as $post):

    $sample = array();
    // Affichez ici le contenu de chaque élément
    $sample['ID'] = $post->ID;
    $sample['post_title'] = $post->post_title;
    $sample['address'] = get_field('company_address', $post->ID)?: 'xxxx';
    $sample['sector'] = get_field('company_sector', $post->ID)?: 'xxxx';
    //Just check more by testing but otherwis that a "Good Job !"
    // $sample['company_logo'] = get_field('company_logo',  $post->company_logo) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $sample['company_logo'] = get_field('company_logo',  $post->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

    //Open position
    $args = array(
      'post_type' => 'job',
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'ordevalue' => $post->ID,
      'order' => 'DESC' ,
      'meta_key' => 'job_company',
      'meta_value' => $post->ID
    );
    $jobs = get_posts($args);
    $sample['open_jobs']  = empty($jobs) ? 0 : count($jobs);

    $sample = (Object)$sample;
    array_push($companies, $sample);

  endforeach;

  $response = new WP_REST_Response($companies);
  $response->set_status(200);
  return $response;
  
}

//[GET]All jobs 
function allJobs(){
   
  $args = array(
      'post_type' => array('job'),  
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );
  $job_posts = get_posts($args);
  $jobs = array();

  // Boucle pour afficher les résultats
  foreach ($job_posts as $post):
    if(!$post)
      continue;

    $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $sample = array('ID' => '0', 'title' => 'xxxx', 'posted_at' => '', 'image' => $placeholder, 'company' => 'xxxx', 'place' => 'xxxx', 'country' => 'xxxx');
    // Affichez ici le contenu de chaque élément
    $sample['ID'] = $post->ID;
    $sample['title'] = $post->post_title;
    $sample['posted_at'] = $post->post_date;
    $company = get_field('job_company', $post->ID);

    $sample['company'] = !empty($company) ? $company->post_title : 'xxxx';
    $sample['image'] = !empty($company) ? get_field('company_logo',  $company->ID) : $sample['image'];
    $sample['place'] = !empty($company) ? get_field('company_place',  $company->ID) : $sample['place'];
    $sample['country'] = !empty($company) ? get_field('company_country',  $company->ID) : $sample['country'];

    $sample = (Object)$sample;
    array_push($jobs, $sample);

  endforeach;

  $response = new WP_REST_Response($jobs);
  $response->set_status(200);
  return $response;
  
}

//[POST]Detail job
function jobDetail(WP_REST_Request $request){

  $param_post_id = $request['id'] ?? 0;
  
  $sample = job($param_post_id);

  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;  
}

//[POST]Detail category 
function categoryDetail(WP_REST_Request $request){
  //Get ID Category
  $sample = array();
  $param_category_id = $request['id'] ?? 0;
  $name = get_the_category_by_ID($param_category_id);
  if(!$name)
      return $sample;

  //tax query
  $tax_query = array(
    array(
      "taxonomy" => "course_category",
      "field"    => "term_id",
      "terms"    => [$param_category_id]
    )
  );

  /** Global jobs **/
  $jobs = array();
  $args = array(
    'post_type' => 'job',
    'tax_query' => $tax_query
  );
  $query_jobs = new WP_Query( $args );
  $global_jobs = isset($query_jobs->posts) ? $query_jobs->posts : array();
  foreach ($global_jobs as $job)
    $jobs[] = job($job->ID);
  $sample['jobs'] = $jobs;

  /** Global companies **/
  $companies = array();
  $args = array(
    'post_type' => 'company',
    'tax_query' => $tax_query
  );
  $query_companies = new WP_Query( $args );
  $global_companies = isset($query_companies->posts) ? $query_companies->posts : array();
  foreach ($global_companies as $company)
    $companies[] = company($company->ID);
  $sample['companies'] = $companies;
  
  /** Global posts **/
  $args = array(
      'post_type' => array('post'),
      'post_status' => 'publish',
      'orderby' => 'date',
      'order'   => 'DESC',
      'posts_per_page' => -1,
  );
  $global_posts = get_posts($args);
  // Category post 
  $sample['articles'] = searching_course_by_group($global_posts, 'category', $param_category_id)['courses'];

  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;
}

function allArtikels(WP_REST_Request $request){
  $args = array(
      'post_type' => 'post',
      'post_status' => 'publish',
      'orderby' => 'date',
      'order'   => 'DESC',
      'posts_per_page' => -1,
  );
  $global_posts = get_posts($args);
  $artikels = array();

  foreach ($global_posts as $post):
    $sample = array();

    // Affichez ici le contenu de chaque élément
    $sample['ID'] = $post->ID;
    $sample['post_title'] = $post->post_title;
    $sample['permalink'] = get_permalink($post->ID);
    $author = get_user_by('ID', $post->post_author);
    $sample['author_name'] = ($author) ? $author->first_name . ' ' . $author->last_name : 'xxxx xxxx';
    $sample['author_image'] = get_field('profile_img',  'user_' . $post->post_author) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
    $post_date = new DateTimeImmutable($post->post_date);
    $sample['post_date'] = $post_date->format('M d, Y');
    $reviews = get_field('reviews', $post->ID);
    $sample['number_comments'] = (!empty($reviews)) ? count($reviews) : 0;
    $sample['short_description'] = get_field('short_description', $post->ID) ?: 'Empty till far ...';
    $sample['content'] = get_field('article_itself', $post->ID) ? : get_field('long_description', $post->ID);
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

    $sample = (Object)$sample;
    array_push($artikels, $sample);

  endforeach;

  $response = new WP_REST_Response($artikels);
  $response->set_status(200);

  return $response;

}
function jobUser(WP_REST_Request $request){

    $errors = ['errors' => '', 'error_data' => ''];

    //Get inputs
    $user_apply_id = isset($request['user_apply_id']) ? $request['user_apply_id'] : null;
    $job_applied_id = isset($request['job_applied_id']) ? $request['job_applied_id'] : null;

    $user_apply = get_user_by('ID', $user_apply_id);

    //error missing
    if(!$user_apply_id || !$job_applied_id || empty($user_apply)):
      $errors['errors'] = "Please fill up all the fields correctly !";
      $errors = (Object)$errors;
      $response = new WP_REST_Response($errors);
      $response->set_status(400);
    endif;

    //Get the appliants user
    $user_appliants = get_field('job_appliants', $job_applied_id);
    $user_appliants = array();

    //Add the applying user
    array_push($user_appliants, $user_apply);
    //Update the 'job_appliants'
    update_field('job_appliants', $user_appliants, $job_applied_id);

    $status = "Job appliant with success !";
    $response = new WP_REST_Response($status);
    $response->set_status(200);

    return $response;

}

 function liggeeySave(WP_REST_Request $request){

   $errors = ['errors' => '', 'error_data' => ''];

       // Get inputs
       $user_favorite_id = isset($request['user_favorite_id']) ? $request['user_favorite_id'] : null;
       $job_favorite_id = isset($request['job_favorite_id']) ? $request['job_favorite_id'] : null;
       $company_favorite_id = isset($request['company_favorite_id']) ? $request['company_favorite_id'] : null;
       $candidate_favorite_id = isset($request['candidate_favorite_id']) ? $request['candidate_favorite_id'] : null;
      //error missing
         if(!$user_favorite_id ):
              $errors['errors'] = "Please fill up all the fields correctly !";
              $errors = (Object)$errors;
              $response = new WP_REST_Response($errors);
              $response->set_status(400);
            endif;

    //Get the favorites user
    $user_favorites = array();
    $favorites = array();
    $favorite_add = array();
    $user_favorites = get_field('save_liggeey', 'user_' . $user_favorite_id);

    $favorite['type'] = 'job';
    $favorite['id'] = $job_favorite_id;

    $favorites = array($favorite);

    //Update the 'job_appliants'
    update_field('job_appliants', $favorites, 'user_' . $user_favorite_id);

    $status = "Job save with success !";
    $response = new WP_REST_Response($status);
    $response->set_status(200);

    return $response;
}

     function userJobs(WP_REST_Request $request){

}


/* * End Liggeey * */