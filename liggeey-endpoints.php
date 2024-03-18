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
    $comment['feedback'] = $review['feedback'];

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
  $sample['description'] = get_field('job_description', $post->ID) ?: 'Empty till far ...';
  $sample['responsibilities'] = get_field('job_responsibilities', $post->ID) ?: 'Empty till far ...';
  $sample['skills_experiences'] = get_field('job_skills_experiences', $post->ID) ?: 'Nothin filled in ';

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

  $sample['applied'] = get_field('job_appliants', $post->ID) ?: [];
  $sample['approved'] = get_field('job_appliants_approved', $post->ID) ?: [];
  $sample['rejected'] = get_field('job_appliants_rejected', $post->ID) ?: [];

  $sample = (Object)$sample;

  // Retrieve the applied 
  $entity = null;
  $applied = array();
  foreach ($sample->applied as $entity) 
    $applied[] = candidate($entity->ID);
  $sample->applied = $applied;

  // Retrieve the approved 
  $entity = null;
  $approved = array();
  foreach ($sample->approve as $entity) 
    $approved[] = candidate($entity->ID);
  $sample->approved = $approved;

  // Retrieve the rejected 
  $entity = null;
  $rejected = array();
  foreach ($sample->reject as $entity) 
    $rejected[] = candidate($entity->ID);
  $sample->rejected = $rejected;

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

//Detail candidate
function candidate($id){
  $param_user_id = $id ?: get_current_user_id();
  $sample = array();
  $user = get_user_by('ID', $param_user_id);

  $sample['ID'] = $user->ID;
  $sample['first_name'] = $user->first_name;
  $sample['last_name'] = $user->last_name;
  $sample['email'] = $user->user_email;
  $sample['mobile_phone'] = $user->mobile_phone;
  $sample['city'] = $user->city;
  $sample['adress'] = $user->adress;
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

  $topics = array();
  $limit = 3;
  $topics = get_user_meta($user->ID, 'topic');
  $sample['skills'] = [];
  if(!empty($topics)):
    $args = array( 
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'include'  => $topics,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
        'include' => $topics,
        'post_per_page' => $limit
    );
    $sample['skills'] = get_categories($args);
  endif;

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
    $testin = isset($request[$required]) ? $request[$required] : 0;
    $testin = ($testin) ?: 0;
    $testin = ($testin != "") ? $testin : 0;
    if (!$testin):
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
  $infos = array('jobs' => $jobs, 'categories' => $categories, 'artikels' => $artikels, 'candidates' => $candidates);

  $errors = ['errors' => '', 'error_data' => ''];
  $limit_job = 6;
  $limit_post = 3;
  $limit_candidate = 20;

  //Job [Block]
  $args = array(
    'post_type' => array('job'),  
    'post_status' => 'publish',
    'posts_per_page' => $limit_job,
  );
  $job_posts = get_posts($args);
  $jobs = array();
  foreach ($job_posts as $post):
    if(!$post)
      continue;

    $sample = job($post->ID);
    array_push($jobs, $sample);
  endforeach;
  $infos['jobs'] = $jobs;

  //Category [Block]
  $categories = array();

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

    $sample = candidate($value->ID);
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
  $required_parameters = ['id'];
  $errors = ['errors' => '', 'error_data' => ''];
  //Check required parameters apply
  $validated = validated($required_parameters, $request);

  //Get input
  $user_apply_id = $param_user_id;
  $user_apply = get_user_by('ID', $user_apply_id);
  if(!$user_apply):
    $errors['errors'] = 'User not found';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

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

  //Jobs
  $jobs = [];
  foreach($sample->open_jobs as $post)
    $jobs[] = job($post->ID);
  $sample->open_jobs = $jobs;

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

    $sample['skills'] = get_the_terms( $post->ID, 'course_category' );

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

    // Retrieve the latest job posts
     $args = array(
        'post_type'      => 'job',
        'posts_per_page' => 3,
        'order'          => 'DESC',
    );
    $job_posts = get_posts($args);
    $jobs = array();
<<<<<<< HEAD

    foreach ($job_posts as $key => $job_post) 
      if($key < 3)
        $jobs[] = job($job_post->ID);

=======
    foreach ($job_posts as $key => $job_post) 
      if($key < 3)
        $jobs[] = job($job_post->ID);
>>>>>>> 912b03e1d50bc2883509baea2b7a7047c22f0411
    $sample->other_jobs = $jobs;

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

  $sample['name'] = $name;
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
  $main_artikels = searching_course_by_group($global_posts, 'category', $param_category_id)['courses'];
  $sample['articles'] = [];

  foreach ($main_artikels as $key => $artikel)
    $sample['articles'][] = artikel($artikel->ID);

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

  // Update the favorites array
  array_push($user_favorites, $favorite);

  // Update the save liggeey entries
  update_field('save_liggeey', $user_favorites, 'user_' . $user_apply_id);

  $success = "Favoris saved with success !";
  $response = new WP_REST_Response($success);
  $response->set_status(200);

  return $response;
}

//comment
function commentByID(WP_REST_Request $request ) {

  $param_user_id = $request['id'] ? $request['id'] : get_current_user_id();
  $user = get_user_by('ID', $param_user_id);

  $comments = array();
  // Retrieve ACF data associated with the post ID
  $main_reviews = get_field('reviews', $post_id);

  // Loop through each ACF review
  foreach ($main_reviews as $review) {
     $user = $review['user']; // Get the user associated with the review
     $author_name = ($user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name; // Retrieve the author's name

     $image_author = get_field('profile_img',  'user_' . $user->ID);
     $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

     $rating = $review['rating'];
     $feedback = $review['Feedback'];

     // Assemble the comment data into an array
     $comment = array(
         'comment_author_name' => $author_name,
         'comment_author_image' => $image_author,
         'rating' => $rating,
         'feedback' => $feedback

     );
     // Add the comment data to the comments array
     $comments[] = $comment;
  }
  // Return the array of comments
  return $comments;

}

//Add comment
function addComment(WP_REST_Request $request) {
  $param_user_id = $request['id'] ? $request['id'] : get_current_user_id();
  $user = get_user_by('ID', $param_user_id);
  if ($user) {
      // Récupérer les données du commentaire depuis la requête
      $review = $request->get_params();
      // tableau de données pour le commentaire
      $comment_data = array(
          'comment_post_ID' => $review['post_id'],
          'comment_author' => ($user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name,
          'comment_approved' => 1,
          'comment_content' => $review['feedback'],
      );
      // Insérer le commentaire
      $comment_id = wp_insert_comment($comment_data);
      // les champs feedback et rating
      update_field('rating', $review['rating'], $comment_id);
      update_field('Feedback', $review['feedback'], $comment_id);

      // Retourner les données du commentaire inséré
      $comment = get_comment($comment_id);
      $response = new WP_REST_Response($comment);
      $response->set_status(200);
      return $response;
  } else {
      // L'utilisateur n'est pas connecté, retourner une erreur
      return new WP_Error('user_not_logged_in');
  }
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
  $mat_ids = [];
  $sample['application'] = $application;
  $sample['count_application'] = (!empty($application)) ? count($application) : 0;
  $sample['application'] = array();
  foreach($application as $key => $user):
    if(in_array($user->ID, $mat_ids))
      continue;

    if($key >= 6)
      break;
    $sample['application'][] = candidate($user->ID);
    $mat_ids[] = $user->ID;
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

//[POST]Dashboard User | Post Job
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

<<<<<<< HEAD
//[POST]Dashboard User | Profil
=======
//comment
function commentByID(WP_REST_Request $request ) {

    $param_user_id = $request['id'] ? $request['id'] : get_current_user_id();
    $user = get_user_by('ID', $param_user_id);

    $comments = array();
    // Retrieve ACF data associated with the post ID
    $main_reviews = get_field('reviews', $post_id);

    // Loop through each ACF review
    foreach ($main_reviews as $review) {
       $user = $review['user']; // Get the user associated with the review
       $author_name = ($user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name; // Retrieve the author's name

       $image_author = get_field('profile_img',  'user_' . $user->ID);
       $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

       $rating = $review['rating'];
       $feedback = $review['Feedback'];

       // Assemble the comment data into an array
       $comment = array(
           'comment_author_name' => $author_name,
           'comment_author_image' => $image_author,
           'rating' => $rating,
           'feedback' => $feedback

       );
       // Add the comment data to the comments array
       $comments[] = $comment;
    }
    // Return the array of comments
    return $comments;

}
//addcomment
function addComment(WP_REST_Request $request) {
  $param_user_id = $request['id'] ? $request['id'] : get_current_user_id();
  $user = get_user_by('ID', $param_user_id);
  if ($user) {
      // Récupérer les données du commentaire depuis la requête
      $review = $request->get_params();
      // tableau de données pour le commentaire
      $comment_data = array(
          'comment_post_ID' => $review['post_id'],
          'comment_author' => ($user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name,
          'comment_approved' => 1,
          'comment_content' => $review['feedback'],
      );
      // Insérer le commentaire
      $comment_id = wp_insert_comment($comment_data);
      // les champs feedback et rating
      update_field('rating', $review['rating'], $comment_id);
      update_field('Feedback', $review['feedback'], $comment_id);

      // Retourner les données du commentaire inséré
      $comment = get_comment($comment_id);
      $response = new WP_REST_Response($comment);
      $response->set_status(200);
      return $response;
  } else {
      // L'utilisateur n'est pas connecté, retourner une erreur
      return new WP_Error('user_not_logged_in');
  }
}

//Dashboard manageJob
>>>>>>> 912b03e1d50bc2883509baea2b7a7047c22f0411
function companyProfil(WP_REST_Request $request){
  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];

  if ($company_data) {
    //var_dump($company_data);
    // Choose fields to display
    $dataCompany = array(
      'title' => $company_data->title,
      'email' => $company_data->email,
      'mobile_phone' => $company_data->mobile_phone,
      'website' => $company_data->website,
      'size' => $company_data->size,
      );
    }

  //Get input
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id);
  if(!$user_apply):
    $errors['errors'] = 'User not found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Get company
  $compagnie = get_field('company',  'user_' . $user_apply->ID);
  $companyInfos = company($compagnie[0]->ID);
  // Return response
  $response = new WP_REST_Response($companyInfos);
  $response->set_status(200);
  return $response;
}

//[POST]Dashboard User | Update | Profil ? Look carefully this function
<<<<<<< HEAD
 function updateCompanyProfil(WP_REST_Request $request) {

    $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

        // Retourner la liste des emplois auxquels le candidat a postulé
            $company_id = get_field('company', 'user_' . $user_id)[0];
           // var_dump($company_id);

        if (!$company_id) {
            $errors['errors'] = 'company not found';
            $response = new WP_REST_Response($errors);
            $response->set_status(401);
            return $response;
        }
            $company_data = company($company_id);

           // the parameters REST request
                $updated_data = $request->get_params();
              // Update Fields
                foreach ($updated_data as $field_name => $field_value) {
                    update_field($field_name, $field_value, $company_id);
                }
                   // Return response
                $updated_company_data = company($company_id);
                $response = new WP_REST_Response($updated_company_data);
                $response->set_status(200);
                return $response;


}

//[POST]Dashboard Candidate | Profil
function candidateProfil(WP_REST_Request $request) {

  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];
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

    $candidate_data = candidate($user_id);
    // Return response
    $response = new WP_REST_Response($candidate_data);
    $response->set_status(200);
    return $response;
}

//[POST]Dashboard Candidate | Update | Profil
function updateCandidateProfil(WP_REST_Request $request) {
=======
function updateCompanyProfil(WP_REST_Request $request) {
>>>>>>> 912b03e1d50bc2883509baea2b7a7047c22f0411
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

  //Get company id through the user id
  //$company = get_field('company', 'user_' . $user_id); 

  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];
<<<<<<< HEAD
  $validated = validated($required_parameters, $request);

  //Data User
  $candidate_data = candidate($user_id);

  if (!$candidate_data) {
      $errors['errors'] = 'User not found';
      $response = new WP_REST_Response($errors);
      $response->set_status(401);
      return $response;
=======

  $validated = validated($required_parameters, $request);

  // Data User
  $company_data = company($user_id); //?

  if (!$company_data) {
      $errors['errors'] = 'User not found';
      $response = new WP_REST_Response($errors);
      $response->set_status(401);
      return $response;
  }
  // Parameters REST request
  $updated_data = $request->get_params();

  // Update Fields
  foreach ($updated_data as $field_name => $field_value) {
    if($field_value)
    if($field_value != '' && $field_value != ' ')
      update_field($field_name, $field_value, $company->ID);
  }

  // Return response
  $updated_company_data = company($user_id);
  $response = new WP_REST_Response($updated_company_data);
  $response->set_status(200);
  return $response;
}

//[POST]Apply User | Approve or Reject candidate
function jobUserApprove(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['userApplyId', 'jobAppliedId', 'status'];

  //Check required parameters apply
  $validated = validated($required_parameters, $request);

  //Get inputs
  $user_apply_id = isset($request['userApplyId']) ? $request['userApplyId'] : 0;
  $job_applied_id = isset($request['jobAppliedId']) ? $request['jobAppliedId'] : 0;
  $status = isset($request['status']) ? $request['status'] : 0;

  $user_apply = get_user_by('ID', $user_apply_id);

  //Remove the user in list appliants
  $appliants = get_field('job_appliants', $job_applied_id);
  $appliants = ($appliants) ?: array();
  $key = array_search($user_apply, $appliants);
  if($key !== false)
    unset($appliants[$key]);
  update_field('job_appliants', $appliants, $job_applied_id);

  if(!$status || $status == "" || $status == " "):
    $response = new WP_REST_Response("No status found !");
    $response->set_status(200);
  endif;

  if($status == 'approve'):
    //Get the approved appliants user
    $user_appliants = get_field('job_appliants_approved', $job_applied_id);
    $user_appliants = ($user_appliants) ?: array();
    //Add the applying user
    array_push($user_appliants, $user_apply);
    update_field('job_appliants_approved', $user_appliants, $job_applied_id);
  elseif($status == "reject"):
    //Get the rejected appliants user
    $user_appliants = get_field('job_appliants_rejected', $job_applied_id);
    $user_appliants = ($user_appliants) ?: array();
    //Add the applying user
    array_push($user_appliants, $user_apply);
    update_field('job_appliants_rejected', $user_appliants, $job_applied_id);
  endif;

  $success = "User application changed with success !";
  $response = new WP_REST_Response($success);
  $response->set_status(200);

  return $response;
}

//[POST]Apply User | Delete favorite candidate
function trashFavouriteCandidate(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['userApplyId', 'userDeleteId'];

  //Check required parameters apply
  $validated = validated($required_parameters, $request);

  //Get inputs
  $user_apply_id = isset($request['userApplyId']) ? $request['userApplyId'] : 0;
  $user_trash_id = isset($request['userDeleteId']) ? $request['userDeleteId'] : 0;


  // Récupérer les favoris de l'utilisateur
  $user_favorites = get_field('save_liggeey', 'user_' . $user_apply_id);
  $user_favourites = array();
  $user_shorlisted_jobs = [];

  // Vérifier si l'utilisateur a des emplois favoris
  if ($user_favorites) 
    foreach ($user_favorites as $favorite):
      if ($favorite['type'] == 'candidate') :
        // Récupérer les détails de l'emploi
        if($favorite['id'] == $user_trash_id)
          continue;
      endif;

      $user_shorlisted_jobs['type'] = $favorite['type'];
      $user_shorlisted_jobs['id'] = $favorite['id'];
      array_push($user_favourites, $user_shorlisted_jobs);
    endforeach;
  
  update_field('save_liggeey', $user_favourites, 'user_' . $user_apply_id);

  //Remove the user in list appliants
  $appliants = get_field('job_appliants', $job_applied_id);
  $appliants = ($appliants) ?: array();
  $key = array_search($user_apply, $appliants);
  if($key !== false)
    unset($appliants[$key]);
  update_field('job_appliants', $appliants, $job_applied_id);

  $success = "User favorites changed with success !";
  $response = new WP_REST_Response($success);
  $response->set_status(200);

  return $response;
}

//[POST]Dashboard Candidate | Home
function HomeCandidate(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $sample = array();
  $limit_job = 6;

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

  //Jobs
  $args = array(
    'post_type' => array('job'),  
    'post_status' => 'publish',
    'posts_per_page' => $limit_job,
    'ordevalue' => $user_apply,
    'order' => 'DESC' ,
  );
  $job_posts = get_posts($args);
  $suggestion_jobs = array();
  $count_applied = 0;

  foreach ($job_posts as $post) :
    if(count($suggestion_jobs) < 6 )
      $suggestion_jobs[] = job($post->ID);
    $user_applied_jobs = get_field('job_appliants', $post->ID);
    foreach($user_applied_jobs as $userapply)
      if($userapply->ID == $userApplyId)
        $count_applied += 1;
        // $applied_jobs[] = job($post->ID);
  endforeach;
  $sample['count_applied_jobs'] = $count_applied;
 
  //Job alerts 
  $sample['count_job_alerts'] = 0;
  /** Instrtuctions should be there */

  //Favorite company
  $main_favorites = get_field('save_liggeey', 'user_' . $user_apply_id);

  foreach($main_favorites as $favo):
    if(!$favo)
      continue;
    if($favo['type'] != 'company' && $favo['type'] != 'job')
      continue;
    $user_id = $favo['id'];
    $user = get_user_by('ID', $user_id);
    if(!$user)
      continue;
    $favorite[] = candidate($user->ID);
  endforeach;
  // $sample['favorite'] = $favorite;
  $sample['count_favorite'] = ($favorite) ? count($favorite) : 0;

  $sample['suggestion_jobs'] = $suggestion_jobs;
  $sample = (Object)$sample;
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;
}

//[POST]Dashboard Candidate | Profil
function candidateProfil(WP_REST_Request $request) {

  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];
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

  $candidate_data = candidate($user_id);
  // Return response
  $response = new WP_REST_Response($candidate_data);
  $response->set_status(200);
  return $response;
}

//Update candidateProfil
function updateCandidateProfil(WP_REST_Request $request) {

  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];

  //Data User
  $candidate_data = candidate($user_id);
  $validated = validated($required_parameters, $request);
  // Data User
  $candidate_data = candidate($user_id);

  if (!$candidate_data) {
    $errors['errors'] = 'User not found';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
>>>>>>> 912b03e1d50bc2883509baea2b7a7047c22f0411
  }

  // Parameters REST request
  $updated_data = $request->get_params();
<<<<<<< HEAD

  // Update Fields
  foreach ($updated_data as $field_name => $field_value):
      if($field_value)
      if($field_value != '' && $field_value != ' ')
        update_field($field_name, $field_value, 'user_' . $user_id);
  endforeach;

=======

  // Update Fields
  foreach ($updated_data as $field_name => $field_value):
    if($field_value)
    if($field_value != '' && $field_value != ' ')
          update_field($field_name, $field_value, 'user_' . $user_id);
  endforeach;

>>>>>>> 912b03e1d50bc2883509baea2b7a7047c22f0411
  // Return response
  $updated_candidate_data = candidate($user_id);
  $response = new WP_REST_Response($updated_candidate_data);
  $response->set_status(200);
  return $response;
}

//[POST]Dashboard Candidate | Applied Jobs 
function candidateAppliedJobs(WP_REST_Request $request) {
  $args = array(
      'post_type' => 'job',
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );
  // Récupérer les offres d'emploi
  $job_posts = get_posts($args);

  // Récupérer l'ID de l'utilisateur à partir de la requête ou de l'utilisateur connecté
  $userApplyId = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  
  // Tableau pour stocker les emplois auxquels le candidat a postulé
  $applied_jobs = array();
  foreach ($job_posts as $post) :
    $user_applied_jobs = get_field('job_appliants', $post->ID);
    //@Penda U cannot put user where job is needed
    foreach($user_applied_jobs as $userapply)
      if($userapply->ID == $userApplyId)
        $applied_jobs[] = job($post->ID);
  endforeach;

  // Retourner la liste des emplois auxquels le candidat a postulé
  $response = new WP_REST_Response($applied_jobs);
  $response->set_status(200);
  return $response;
}

//[POST]Dashboard Candidate | Favorites
function candidateShorlistedJobs(WP_REST_Request $request) {
  // Récupérer l'ID de l'utilisateur à partir de la requête ou de l'utilisateur connecté
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

  // Récupérer les emplois favoris de l'utilisateur
  $user_favorites = get_field('save_liggeey', 'user_' . $user_id);
  $user_shorlisted_jobs = [];

  // Vérifier si l'utilisateur a des emplois favoris
  if ($user_favorites)
    foreach ($user_favorites as $favorite)
      if ($favorite['type'] == 'job') :
        // Récupérer les détails de l'emploi
        if($favorite['id'])
          $user_shorlisted_jobs[] = job($favorite['id']);
      endif;

  $response = new WP_REST_Response($user_shorlisted_jobs);
  $response->set_status(200);
  return $response;

}

//[POST]Dashboard Candidate | Skills passport
function candidateSkillsPassport(WP_REST_Request $request) {
    $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

    $required_parameters = ['userApplyId'];
    $errors = ['errors' => '', 'error_data' => ''];
    $validated = validated($required_parameters, $request);

    $user_apply = get_user_by('ID', $user_id);
      if (!$user_apply) {
          $errors['errors'] = 'User not found';
          $response = new WP_REST_Response($errors);
          $response->set_status(401);
          return $response;
      } else {
          $user_id = $user_apply->ID;
      }

    $enrolled = array();
    $enrolled_courses = array();

    //Orders - enrolled courses
    $args = array(
        'customer_id' => $user_id,
        'post_status' => array('wc-processing', 'wc-completed'),
        'orderby' => 'date',
        'order' => 'DESC',
        'limit' => -1,
    );
    $bunch_orders = wc_get_orders($args);

    foreach($bunch_orders as $order){
        foreach ($order->get_items() as $item_id => $item ) {
            //Get woo orders from user
            $id_course = intval($item->get_product_id()) - 1;
            if(!in_array($id_course, $enrolled))
                array_push($enrolled, $id_course);
        }
    }
    if(!empty($enrolled))
    {
        $args = array(
            'post_type' => 'course',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'include' => $enrolled,
        );
        $enrolled_courses = get_posts($args);
    }
    $state = array('new' => 0, 'progress' => 0, 'done' => 0);

    foreach($enrolled_courses as $key => $course) :

        /* * State actual details * */
        $status = "new";
        //Get read by user
        $args = array(
            'post_type' => 'progression',
            'title' => $course->post_name,
            'post_status' => 'publish',
            'author' => $user_id,
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
            case 'new':
                $state['new']++;
                break;
            case 'progress':
                $state['progress']++;
                break;
            case 'done':
                $state['done']++;
                break;
        }

    endforeach;
      //favorite course
             $course_saved = get_user_meta($user_id, 'course') ?? false ;
             $courses = get_posts(
                 array(
                     'post_type' => array('course', 'post'),
                     'post_status' => 'publish',
                     'posts_per_page' => -1,
                     'order' => 'DESC',
                     'include' => $course_saved
                 ));

      //Skills
     $topics_external = get_user_meta($user_id, 'topic');
     $topics_internal = get_user_meta($user_id, 'topic_affiliate');
     $topics = array();

     if (!empty($topics_external))
         $topics = $topics_external;

     if (!empty($topics_internal))
         foreach ($topics_internal as $value)
             array_push($topics, $value);

     $skills_note = get_field('skills', 'user_' . $user_id);

     $topics_with_notes = array();

     foreach ($topics as $value) {
         $topic = get_the_category_by_ID($value);
         $note = 0;

         if (!empty($skills_note)) {
             foreach ($skills_note as $skill) {
                 if ($skill['id'] == $value) {
                     $note = $skill['note'];
                     break;
                     }
             }
         }

         $topics_with_notes[] = array(
             'topic_name' => (string) $topic,
             'note' => $note
         );
     }

    // Badges
    $args = array(
        'post_type' => 'badge',
        'author' => $user_id,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );
    $achievements = get_posts($args);
    $badges = array();
    $certificates = array();
    $performances = array();
    $diplomas = array();
     $image = '';
     if(!empty($achievements))
       foreach($achievements as $key=>$achievement):

           $type = get_field('type_badge', $achievement->ID);
           $achievement->manager = get_user_by('ID', get_field('manager_badge', $achievement->ID));

           $achievement->manager_image = get_field('profile_img',  'user_' . $achievement->ID);
           if(!$image)
               $image = get_stylesheet_directory_uri() . '/img/Group216.png';

           switch ($type) {
               case 'Genuine':
                   $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                   array_push($badges, $achievement);
                   break;
               case 'Certificaat':
                   $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                   array_push($certificats, $achievement);
                   break;
               case 'Prestatie':
                   $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                   array_push($prestaties, $achievement);
                   break;
               case 'Diploma':
                   $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                   array_push($diplomas, $achievement);
                   break;
               default:
                   $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                   array_push($badges, $achievement);
                   break;
           }
       endforeach;

    // Data
    $data = array(
        'state' => $state,
        'topics' => $topics_with_notes,
        'badges' => $badges,
         'courses' => $courses
    );

    // Response
     $response = new WP_REST_Response($data);
    $response->set_status(200);
    return $response;
}

<<<<<<< HEAD

=======
>>>>>>> 912b03e1d50bc2883509baea2b7a7047c22f0411
/* * End Liggeey * */
