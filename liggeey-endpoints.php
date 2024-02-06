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

  $sample['applied'] = get_field('job_appliants', $post->ID) ?: 0;

  $sample = (Object)$sample;
  return $sample;  
}

//Detail company
function company($id){
  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  // return $param_post_id;

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
  
  $sample = (Object)$sample;

  return $sample; 
}

function candidate($id){
  $param_user_id = $id ?: get_current_user_id();
  $sample = array();
  $user = get_user_by('ID', $param_user_id);

  $sample['ID'] = $user->ID;
  $sample['first_name'] = $user->first_name;
  $sample['last_name'] = $user->last_name;
  $sample['image'] = get_field('profile_img',  'user_' . $user->ID) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  $sample['work_as'] = get_field('role',  'user_' . $user->ID) ?: "Free agent";
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

//[POST]Detail candidate
function candidateDetail(WP_REST_Request $request){

  $param_user_id = $request['id'] ? $request['id'] : get_current_user_id();
  $sample = candidate($param_user_id);
 
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
  $sample = company($param_post_id);

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

//[GET]All artikels 
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

//[POST]Apply for a job 
function jobUser(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['userApplyId', 'jobAppliedId'];

  //Check required parameters apply
  $validated = validated($required_parameters, $request);

  //Get inputs
  $user_apply_id = $request['userApplyId'];
  $job_applied_id = $request['jobAppliedId'];

  $user_apply = get_user_by('ID', $user_apply_id);

  //Get the appliants user
  $user_appliants = get_field('job_appliants', $job_applied_id);
  $user_appliants = ($user_appliants) ?: array();

  //Add the applying user
  array_push($user_appliants, $user_apply);

  //Update the 'job_appliants'
  update_field('job_appliants', $user_appliants, $job_applied_id);

  $success = "Job appliant with success !";
  $response = new WP_REST_Response($success);
  $response->set_status(200);

  return $response;
}

//[POST]Make favorite
function liggeeySave(WP_REST_Request $request){

  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['userApplyId', 'typeApplyId', 'ID'];
  $permission_type = ['job', 'company', 'candidate'];

  //Get inputs
  $user_apply_id = $request['userApplyId'];
  $type_applied_id = $request['typeApplyId'];
  $id = $request['ID'];

  //Check required parameters apply
  $validated = validated($required_parameters, $request);    

  $allowedValues = ['job', 'company', 'candidate'];

  if (!in_array($typeApplyId, $allowedValues)) {
      $errors['errors'] = "Please respect this type listed: job, company, candidate!";
      $errors = (object)$errors;
      $response = new WP_REST_Response($errors);
      $response->set_status(400);
  }

  //Check if typeApplyId ['job', 'company', 'candidate']
  if(!in_array($type_applied_id, $permission_type)): 
    $errors['errors'] = "Please respect this type listed : job, company, candidate";
    return $errors;
  endif;

  // Initialize arrays
  $user_favorites = array();
  $favorites = array();
  // $favorite_add = array();

  // Get existing user favorites
  $user_favorites = get_field('save_liggeey', 'user_' . $user_apply_id);
  $user_favorites = ($user_favorites) ?: array(); 

  // Create a favorite entry for a job
  $favorite['type'] = $type_applied_id;
  $favorite['id'] = $id;
  // $favorites = array($favorite);
  
  // Update the favorites array
  array_push($user_favorites, $favorite);

  // Update the save liggeey entries
  update_field('save_liggeey', $user_favorites, 'user_' . $user_apply_id);

  $success = "Favoris saved with success !";
  $response = new WP_REST_Response($success);
  $response->set_status(200);

  return $response;
}

//[POST]Dashboard User | Home
function HomeUser(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $sample = array();

  $required_parameters = ['userApplyId'];
  $application = array();
  $favorite = array();

  //Check required parameters apply
  $validated = validated($required_parameters, $request);  

  //Get input
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id); 
  if(!$user_apply):
    $errors['errors'] = 'User not found';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;  
  endif;

  //Job company 
  $post = get_field('company', 'user_' . $user_apply_id);
  $post_id = $post->ID;
  $company = company($post[0]->ID);
  $sample['open_jobs'] = $company->open_jobs;
  $sample['count_open_jobs'] = $company->count_open_jobs;
  foreach($sample['open_jobs'] as $post):
    $job_appliants = get_field('job_appliants', $post->ID);
    $application = (!empty($job_appliants)) ? array_merge($application, $job_appliants) : $application;    
  endforeach;

  //Application company
  $sample['application'] = $application;
  $sample['count_application'] = (!empty($application)) ? count($application) : 0;
  $sample['application'] = array();
  foreach($application as $key => $user):
    if($key >= 6)
      break;
    $sample['application'][] = candidate($user->ID);
  endforeach;

  //Favorite company 
  $main_favorites = get_field('save_liggeey', 'user_' . $user_apply_id);

  foreach($main_favorites as $favo):
    if(!$favo)
      continue;
    if($favo['type'] != 'candidate')
      continue;
    $user_id = $favo['id'];
    $user = get_user_by('ID', $user_id); 
    if(!$user)
      continue;

    $favorite[] = candidate($user->ID);
  endforeach;
  // $sample['favorite'] = $favorite;
  $sample['count_favorite'] = ($favorite) ? count($favorite) : 0;


  $sample = (Object)$sample;
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;

}

//[POST]Dashboard User | Jobs
function JobsUser(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];

  $required_parameters = ['userApplyId'];
  $open_jobs = array();

  //Check required parameters apply
  $validated = validated($required_parameters, $request);  

  //Get input
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id); 
  if(!$user_apply):
    $errors['errors'] = 'User not found';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;  
  endif;

  //Job company 
  $post = get_field('company', 'user_' . $user_apply_id);
  $post_id = $post->ID;
  $company = company($post[0]->ID);
  $jobs = $company->open_jobs;
  // $sample['count_open_jobs'] = $company->count_open_jobs;
  foreach($jobs as $post)
    $open_jobs[] = job($post->ID);

  $response = new WP_REST_Response($open_jobs);
  $response->set_status(200);

  return $response;

}

//[POST]Dashboard User | Applicants
function ApplicantsUser(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];

  $required_parameters = ['userApplyId'];
  $applications = array();
  $application = array();

  //Check required parameters apply
  $validated = validated($required_parameters, $request);  

  //Get input
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id); 
  if(!$user_apply):
    $errors['errors'] = 'User not found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;  
  endif;

  //Job company 
  $post = get_field('company', 'user_' . $user_apply_id);
  $post_id = $post->ID;
  $company = company($post[0]->ID);
  $sample['open_jobs'] = $company->open_jobs;
  $sample['count_open_jobs'] = $company->count_open_jobs;
  foreach($sample['open_jobs'] as $post):
    $job_appliants = get_field('job_appliants', $post->ID);
    $application = (!empty($job_appliants)) ? array_merge($application, $job_appliants) : $application;    
  endforeach;

  //Application company
  foreach($application as $key => $user):
    // if($key >= 6)
    //   break;
    $applications[] = candidate($user->ID);
  endforeach;

  $response = new WP_REST_Response($applications);
  $response->set_status(200);

  return $response;

}

//[POST]Dashboard User | Favorites
function FavoritesUser(WP_REST_Request $request){
  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];
  $favorite = array();

  //Check required parameters apply
  $validated = validated($required_parameters, $request);  

  //Get input
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id); 
  if(!$user_apply):
    $errors['errors'] = 'User not found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;  
  endif;

  //Favorite company 
  $main_favorites = get_field('save_liggeey', 'user_' . $user_apply_id);
  foreach($main_favorites as $favo):
    if(!$favo)
      continue;
    if($favo['type'] != 'candidate')
      continue;
    $user_id = $favo['id'];
    $user = get_user_by('ID', $user_id); 
    if(!$user)
      continue;

    $favorite[] = candidate($user->ID);
  endforeach;

  $response = new WP_REST_Response($favorite);
  $response->set_status(200);

  return $response;
}

//Recent job is not a endpoint but must be add to detail job endpoint
function recentJobs(WP_REST_Request $request){

  $args = array(
      'post_type' => 'job',
      'posts_per_page' => 3,
      'order' => 'DESC',
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

//Candidate a job
function postJobUser(WP_REST_Request $request){

  //Check required parameters apply
  $validated = validated($required_parameters, $request);  

  // Get input
  $title = $request['title'];
  $description = $request['description'];
  $job_contract = ($request['job_contract']) ?: 'Full Time';
  $job_level_experience = ($request['job_level_of_experience']) ?: '';
  $job_language = ($request['job_langues']) ?: 'English';
  $job_application_deadline = ($request['job_application_deadline']);
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id);

  //Find the user company
  $company = get_field('company',  'user_' . $user_apply_id);

  // Insert post
  $post_data = array(
    'post_title' => $title,
    'post_author' => $user_apply->ID,
    'post_type' => 'job',
    'post_status' => 'publish'
  );

  // Insert the job post
  $job_id = wp_insert_post($post_data);

  //Check if there are no errors
  if(is_wp_error($job_id)):
    $errors['errors'] = $job_id;
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors); 
    $response->set_status(400);
    return $response;
  endif; 

  // Add custom fields
  update_field('job_company', $company, $job_id);
  // update_field('job_skills_experiences', $job_skills_experiences, $job_id);
  update_field('description', $description, $job_id);
  update_field('job_contract', $job_contract, $job_id);
  update_field('job_level_of_experience', $job_level_experience, $job_id);
  update_field('job_langues', $job_language, $job_id);
  update_field('job_expiration_date', $job_application_deadline, $job_id);
  
  // Return the job
  $job = job($job_id);
  $response = new WP_REST_Response($job);
  $response->set_status(200);

  return $response;

}

/* * End Liggeey * */