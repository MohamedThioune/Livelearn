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
    $comment['Feedback'] = $review['Feedback'];

    $comments[] = $comment;
  endforeach;
  $sample['comments'] = $comments;

  $sample = (Object)$sample;

  return $sample;
}

//Detail job
function job($id, $userApplyId = null){
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
  $sample['skills_experiences'] = get_field('job_skills_experiences', $post->ID) ?: 'Nothin filled in so far ...';
  $sample['level_of_experience'] = get_field('job_level_of_experience', $post->ID) ?: 0;
  $sample['langues'] = get_field('job_langues', $post->ID) ?: "";

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
  $status = "No data available";
  foreach ($sample->applied as $entity):
    $applied[] = candidate($entity->ID);
    if($userApplyId)
    if($userApplyId == $entity->ID)
      $status = "Processing";
  endforeach;
  $sample->applied = $applied;

  // Retrieve the approved 
  $entity = null;
  $approved = array();
  foreach ($sample->approved as $entity): 
    $approved[] = candidate($entity->ID);
    if($userApplyId)
    if($userApplyId == $entity->ID)
      $status = "Approved";
  endforeach;
  $sample->approved = $approved;

  // Retrieve the rejected 
  $entity = null;
  $rejected = array();
  foreach ($sample->rejected as $entity): 
    $rejected[] = candidate($entity->ID);
    if($userApplyId)
    if($userApplyId == $entity->ID)
      $status = "Rejected";
  endforeach;
  $sample->rejected = $rejected;

  $sample->status = $status;

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
    $open_position = isset($query_jobs->posts) ? count($query_jobs->posts) : [];

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

  // Sending email notification
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
    $sample['description'] = get_field('job_description', $post->ID) ?: 'Empty till far ...';
    $sample['posted_at'] = $post->post_date;
    $company = get_field('job_company', $post->ID);

    $sample['company'] = !empty($company) ? $company->post_title : 'xxxx';
    $sample['image'] = !empty($company) ? get_field('company_logo',  $company->ID) : $sample['image'];
    $sample['place'] = !empty($company) ? get_field('company_place',  $company->ID) : $sample['place'];
    $sample['country'] = !empty($company) ? get_field('company_country',  $company->ID) : $sample['country'];

    $sample['skills'] = get_the_terms( $post->ID, 'course_category' );

    $sample['applied'] = get_field('job_appliants', $post->ID) ?: [];
    $sample['approved'] = get_field('job_appliants_approved', $post->ID) ?: [];
    $sample['rejected'] = get_field('job_appliants_rejected', $post->ID) ?: [];
  
    $sample = (Object)$sample;
  
    // Retrieve the applied 
    $entity = null;
    $applied = array();
    $status = "No data available";
    foreach ($sample->applied as $entity):
      $applied[] = candidate($entity->ID);
      if($userApplyId)
      if($userApplyId == $entity->ID)
        $status = "Processing";
    endforeach;
    $sample->applied = $applied;
  
    // Retrieve the approved 
    $entity = null;
    $approved = array();
    foreach ($sample->approved as $entity): 
      $approved[] = candidate($entity->ID);
      if($userApplyId)
      if($userApplyId == $entity->ID)
        $status = "Approved";
    endforeach;
    $sample->approved = $approved;
  
    // Retrieve the rejected 
    $entity = null;
    $rejected = array();
    foreach ($sample->rejected as $entity): 
      $rejected[] = candidate($entity->ID);
      if($userApplyId)
      if($userApplyId == $entity->ID)
        $status = "Rejected";
    endforeach;
    $sample->rejected = $rejected;
  
    $sample->status = $status;

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

  foreach ($job_posts as $key => $job_post)
    if($key < 3)
      $jobs[] = job($job_post->ID);

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
      $errors['errors'] = "Please respect this type listed: job, company, candidate !";
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
  $sample['application'] = array();
  foreach($application as $key => $user):
    if(in_array($user->ID, $mat_ids))
      continue;

    if($key >= 6)
      break;
    $sample['application'][] = candidate($user->ID);
    $mat_ids[] = $user->ID;
  endforeach;
  $sample['count_application'] = (!empty($mat_ids)) ? count($mat_ids) : 0;

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

  //Jobs company
  $args = array(
    'post_type' => 'job',  
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC' ,
  );
  $jobs = get_posts($args);
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
  $mat_ids = [];
  foreach($application as $key => $user):
    if(in_array($user->ID, $mat_ids))
      continue;

    if($key >= 6)
      break;
    $applications[] = candidate($user->ID);
    $mat_ids[] = $user->ID;
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
  $skills = ($request['skills']) ?: null;
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
  if($skills)
    wp_set_post_terms($job_id, $skills, 'course_category');

  update_field('job_company', $company, $job_id);
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

//[POST]Dashboard User | Edit Job
function editJobUser(WP_REST_Request $request) {
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $job_id = isset($request['jobID']) ? $request['jobID'] : 0;
  $skills = ($request['skills']) ?: null;

  $required_parameters = ['jobId'];
  $errors = ['errors' => '', 'error_data' => ''];
  $validated = validated($required_parameters, $request);

  //Data Job
  $job = get_post($job_id);
  $candidate = get_user_by('ID', $user_id);

  if (!$job || !$candidate) {
      $errors['errors'] = 'Something went wrong !';
      $response = new WP_REST_Response($errors);
      $response->set_status(401);
      return $response;
  }

  if($skills)
    wp_set_post_terms($job_id, $terms, 'course_category');

  // Parameters REST request
  $updated_data = $request->get_params();

  // Update Fields
  foreach ($updated_data as $field_name => $field_value) {
    if($field_value)
    if($field_value != '' && $field_value != ' ')
      update_field($field_name, $field_value, $job->ID);
  }

  // Return response
  $updated_company_data = job($job_id);
  $response = new WP_REST_Response($updated_company_data);
  $response->set_status(200);
  return $response;
}

//[POST]Dashboard User | Delete Job
function deleteJobUser(WP_REST_Request $request) {
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $job_id = isset($request['jobID']) ? $request['jobID'] : 0;

  $required_parameters = ['jobId'];
  $errors = ['errors' => '', 'error_data' => ''];
  $validated = validated($required_parameters, $request);

  //Data Job
  $job = get_post($job_id);
  $jobTo = job($job_id);
  $candidate = get_user_by('ID', $user_id);

  if (!$job || !$candidate) {
    $errors['errors'] = 'Something went wrong !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  }

  // Delete job
  wp_delete_post($jobTo->ID);

  // Return response
  $response = new WP_REST_Response($jobTo);
  $response->set_status(200);
  return $response;
}

//[POST]Dashboard User | Profil
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

//[POST]Dashboard User | Update
function updateCompanyProfil(WP_REST_Request $request) {

  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $company_id = get_field('company', 'user_' . $user_id)[0];
  // var_dump($company_id);

  if (!$company_id) {
    $errors['errors'] = 'company not found';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  }

  // Parameters REST request
  $updated_data = $request->get_params();
  // Update Fields
  foreach ($updated_data as $field_name => $field_value)
    if($field_value)
    if($field_value != '' && $field_value != ' ')
      update_field($field_name, $field_value, $company_id);
  
  $updated_company_data = company($company_id);
  $response = new WP_REST_Response($updated_company_data);
  $response->set_status(200);
  return $response;
}

//[POST]Apply Candidate | Delete favorite candidate
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

//[POST]Apply User | Approve or Reject candidate
function jobUserApprove(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['userApproveId', 'jobAppliedId', 'status'];

  //Check required parameters apply
  $validated = validated($required_parameters, $request);

  //Get inputs
  $user_apply_id = isset($request['userApproveId']) ? $request['userApproveId'] : 0;
  $job_applied_id = isset($request['jobAppliedId']) ? $request['jobAppliedId'] : 0;
  $status = isset($request['status']) ? $request['status'] : 0;

  $user_apply = get_user_by('ID', $user_apply_id);

  //Remove the user in list appliants
  $appliants = get_field('job_appliants', $job_applied_id);
  $appliants = ($appliants) ?: array();
  $key = array_search($user_apply, $appliants);
  if($key !== false):
    unset($appliants[$key]);
  else:
    $error = "You don't need to perform any further actions on this user !";
    $response = new WP_REST_Response($error);
    $response->set_status(401);
    return $response;
  endif;

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
    $userApplyId = $request['userApplyId'];
    $user_apply = get_user_by('ID', $userApplyId);
    if(!$user_apply):
        $errors['errors'] = 'User not found';
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    //Jobs
    $args = array(
        'post_type' => 'job',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
    );
    $job_posts = get_posts($args);
    $suggestion_jobs = array();
    $count_applied = 0;

    // Verification array $job_posts
    if (is_array($job_posts)) {
        foreach ($job_posts as $post) {
            if (count($suggestion_jobs) < $limit_job) {
                $suggestion_jobs[] = job($post->ID);
            }

            $user_applied_jobs = get_field('job_appliants', $post->ID);

            // Verification array
            if (is_array($user_applied_jobs)) {
                foreach ($user_applied_jobs as $userapply) {
                    if ($userapply->ID == $userApplyId) {
                        $count_applied += 1;
                    }
                }
            }
        }
    } else {
        $count_applied = 0;
    }
    $sample['count_applieds'] = $count_applied;
    //Job alerts
    $sample['count_jobs'] = 0;
    /** Instrtuctions should be there */

   //Favorite company
   $main_favorites = get_field('save_liggeey', 'user_' . $userApplyId);
   // Associative array to store unique elements
   $unique_favorites = array();
   // Verification
   if (is_array($main_favorites)) {
       foreach($main_favorites as $favo):
           if(!$favo)
               continue;
           if($favo['type'] != 'company' && $favo['type'] != 'job')
               continue;
           $unique_favorites[$favo['id']] = $favo;
       endforeach;
   }

   $count_unique_favorites = count($unique_favorites);
   $sample['count_favorites'] = $count_unique_favorites;

    $sample['suggestions'] = $suggestion_jobs;
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

//[POST]Dashboard Candidate | Update | Profil
function updateCandidateProfil(WP_REST_Request $request) {
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];
  $validated = validated($required_parameters, $request);

  //Data User
  $candidate_data = candidate($user_id);

  if (!$candidate_data) {
      $errors['errors'] = 'User not found';
      $response = new WP_REST_Response($errors);
      $response->set_status(401);
      return $response;
  }

  // Parameters REST request
  $updated_data = $request->get_params();

  // Update Fields
  foreach ($updated_data as $field_name => $field_value):
      if($field_value)
      if($field_value != '' && $field_value != ' ')
        update_field($field_name, $field_value, 'user_' . $user_id);
  endforeach;

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
  $mat_ids = array();
  foreach ($job_posts as $post) :
    $user_meddled = array();
    $user_applied_jobs = get_field('job_appliants', $post->ID) ?: array();
    $user_accepted_jobs = get_field('job_appliants_approved', $post->ID) ?: array();
    $user_rejected_jobs = get_field('job_appliants_rejected', $post->ID) ?: array();
    $user_meddled = array_merge($user_accepted_jobs, $user_applied_jobs, $user_rejected_jobs);

    foreach($user_meddled as $userapply)
      if($userapply->ID == $userApplyId)
        if(!in_array($post->ID, $mat_ids)):
          $applied_jobs[] = job($post->ID, $userApplyId);
          $mat_ids[] = $post->ID;
        endif;

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

  foreach($bunch_orders as $order)
    foreach ($order->get_items() as $item_id => $item ) {
      //Get woo orders from user
      $id_course = intval($item->get_product_id()) - 1;
      if(!in_array($id_course, $enrolled))
          array_push($enrolled, $id_course);
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
  $courses_saved = get_user_meta($user_id, 'course') ?? false;
  $courses = get_posts(
      array(
          'post_type' => array('course', 'post'),
          'post_status' => 'publish',
          'posts_per_page' => -1,
          'order' => 'DESC',
          'include' => $courses_saved
      )
  );

  $courses_combined = array();

  foreach ($courses as $course) {
    //data courses
    $course_info = array(
        'post_id' => $course->ID,
        'post_title' => $course->post_title,

    );
    $thumbnail = "";
    $course_type = get_field('course_type', $course->ID);
    if(!$thumbnail){
        $thumbnail = get_the_post_thumbnail_url($course->ID);
        if(!$thumbnail)
            $thumbnail = get_field('url_image_xml', $course->ID);
                if(!$thumbnail)
                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';

    }

    $price = get_field('price', $course->ID);
    if ($price != "0") {
        $formatted_price = '$' . number_format($price, 2, '.', ',');
    } else {
        $formatted_price = 'Gratis';
    }
    $author = get_user_by('ID', $course->post_author);
    $author_name = $author->display_name ?: $author->first_name;

      //data additional
    $course_combined_info = array_merge($course_info, array(
        'thumbnail_url' => $thumbnail,
        'price' => $formatted_price,
        'author_name' => $author_name,
    ));

    // table
      $courses_combined[] = $course_combined_info;
  }

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
  $count_skills_note = (empty($skills_note)) ? 0 : count($skills_note);

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
      $certificats = array();
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
                        $achievement_info = array(
                            'title' => $achievement->post_title,
                            'description' => $achievement->post_content,
                            'manager' => $achievement->manager,
                            'manager_image' => $achievement->manager_image,
                            'trigger' => get_field('trigger_badge', $achievement->ID),
                        );
                        $certificats[] = $achievement_info;

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
         'certificats' => $certificats,
         'courses_info' => $courses_combined,

    );

    // Response
     $response = new WP_REST_Response($data);
    $response->set_status(200);
    return $response;
}

//[Add]Dashboard My_Resume
function candidateMyResumeAdd(WP_REST_Request $request) {

  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  // Array response data
  $response_data = array();

    // Add new Education
  if(isset($request['school'], $request['degree'], $request['start_date'], $request['end_date'], $request['commentary'])) {
    // New education entry
    $new_education = $request['school'] . ';' . $request['degree'] . ';' . $request['start_date'] . ';' . $request['end_date'] . ';' . $request['commentary'];
    $educations = get_field('education', 'user_' . $user_id);
    // New data
    $educations[] = $new_education;
    // Update field
    update_field('education', $educations, 'user_' . $user_id);

    // Add the new education to the response data
    $response_data['new_education'] = $new_education;
  }

  // Add new Award
  if(isset($request['title'], $request['description'], $request['date'])) {
    // New award entry
    $new_award = $request['title'] . ';' . $request['description'] . ';' . $request['date'];
    $awards = get_field('awards', 'user_' . $user_id);
    //New data
    $awards[] = $new_award;
    // Update field
    update_field('awards', $awards, 'user_' . $user_id);
    // Add the new award to the response data
    $response_data['new_award'] = $new_award;
  }

  // Add new Work
  if(isset($request['job_title'], $request['company'], $request['work_start_date'], $request['work_end_date'], $request['work_description'])) {
    // New work entry
    $new_work = $request['job_title'] . ';' . $request['company'] . ';' . $request['work_start_date'] . ';' . $request['work_end_date'] . ';' . $request['work_description'];
    $works = get_field('work', 'user_' . $user_id);
    //New data
    $works[] = $new_work;
    // Update field
    update_field('work', $works, 'user_' . $user_id);
    // Add the new work to the response data
    $response_data['new_work'] = $new_work;
  }
  
  //var_dump($response_data);
  // Return the response data
  $response = new WP_REST_Response($response_data);
  $response->set_status(200);
  return $response;

}

//[Edit]Dashboard My_Resume
function candidateMyResumeEdit(WP_REST_Request $request) {
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  // Array response data
  $response_data = array();

  // Update Work
  if(isset($request['work_index'], $request['job_title'], $request['company'], $request['work_start_date'], $request['work_end_date'], $request['work_description'])) {
      // Work entry index
      $updated_work_index = $request['work_index'];
      // updated work entry
      $updated_work = $request['job_title'] . ';' . $request['company'] . ';' . $request['work_start_date'] . ';' . $request['work_end_date'] . ';' . $request['work_description'];
      $works = get_field('work', 'user_' . $user_id);
      if(isset($works[$updated_work_index])) {
          $works[$updated_work_index] = $updated_work;
          update_field('work', $works, 'user_' . $user_id);
          $response_data['updated_work'] = $updated_work;
      } else {
          $response_data['error'] = 'Work entry with specified index does not exist.';
      }
  }

  // Update Education
  if(isset($request['education_index'], $request['school'], $request['degree'], $request['start_date'], $request['end_date'], $request['commentary'])) {
      // Education entry index
      $updated_education_index = $request['education_index'];
      // Updated education entry
      $updated_education = $request['school'] . ';' . $request['degree'] . ';' . $request['start_date'] . ';' . $request['end_date'] . ';' . $request['commentary'];
      $educations = get_field('education', 'user_' . $user_id);
      if(isset($educations[$updated_education_index])) {
          $educations[$updated_education_index] = $updated_education;
          update_field('education', $educations, 'user_' . $user_id);
          $response_data['updated_education'] = $updated_education;
      } else {
          $response_data['error'] = 'Education entry with specified index does not exist.';
      }
  }

  // Update Award
  if(isset($request['award_index'], $request['title'], $request['description'], $request['date'])) {
      // Award entry index
      $updated_award_index = $request['award_index'];
      // Updated award entry
      $updated_award = $request['title'] . ';' . $request['description'] . ';' . $request['date'];
      $awards = get_field('awards', 'user_' . $user_id);
      if(isset($awards[$updated_award_index])) {
          $awards[$updated_award_index] = $updated_award;
          update_field('awards', $awards, 'user_' . $user_id);
          $response_data['updated_award'] = $updated_award;
      } else {
          $response_data['error'] = 'Award entry with specified index does not exist.';
      }
  }

  // Return the response data
  $response = new WP_REST_Response($response_data);
  $response->set_status(200);
  return $response;
}

//[Delete]Dashboard My_Resume
function candidateMyResumeDelete(WP_REST_Request $request) {
  // Récupérer l'ID de l'utilisateur
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  //var_dump($user_id);
  // Array response data
  $response_data = array();

  // Delete Education
  if(isset($request['delete_education'])) {
    $education_index = $request['delete_education'];

    //var_dump($education_index);
    $educations = get_field('education', 'user_' . $user_id);

    if(isset($educations[$education_index])) {
        unset($educations[$education_index]);
        update_field('education', $educations, 'user_' . $user_id);
        $response_data['message'] = 'Education deleted successfully';
    } else {
        $response_data['error'] = 'Education entry with specified index does not exist.';
    }
  }

  // Delete Award
  if(isset($request['delete_award'])) {
    $award_index = $request['delete_award'];

    $awards = get_field('awards', 'user_' . $user_id);
    if(isset($awards[$award_index])) {
        unset($awards[$award_index]);
        update_field('awards', $awards, 'user_' . $user_id);
        $response_data['message'] = 'Award deleted successfully';
    } else {
        $response_data['error'] = 'Award entry with specified index does not exist.';
    }
  }

  // Delete Work
  if(isset($request['delete_work'])) {
    $work_index = $request['delete_work'];

    $works = get_field('work', 'user_' . $user_id);
    if(isset($works[$work_index])) {
        unset($works[$work_index]);
        update_field('work', $works, 'user_' . $user_id);
        $response_data['message'] = 'Work experience deleted successfully';
    } else {
        $response_data['error'] = 'Work entry with specified index does not exist.';
    }
  }

  // Return the response data
  $response = new WP_REST_Response($response_data);
  $response->set_status(200);
  return $response;

}

//Made By Fadel
function sendNotificationBetweenLiggeyActors(WP_REST_Request $request)
{
  $code_status = 400;
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  if (!($user_id))
  {
    $response = new WP_REST_Response('You\'ve to be logged in !');
    $response->set_status($code_status);
    return $response;
  }
  
  $user = get_user_by( 'ID', $user_id );

  $title = $request['title'] != null && !empty($request['title']) ? $request['title'] : false;
  if (!$title)
  {
    $response = new WP_REST_Response('The title is required !');
    $response->set_status($code_status);
    return $response;
  }
  $content = $request['content'] != null && !empty($request['content']) ? $request['content'] : false;
  if (!($content))
  {
    $response = new WP_REST_Response('The content is required !');
    $response->set_status($code_status);
    return $response;
  }
  $receiver_id = $request['receiver_id'] != null && !empty($request['receiver_id']) ? $request['receiver_id'] : false;
  if (!($receiver_id))
  {
    $response = new WP_REST_Response('The id of the receiver is required !');
    $response->set_status($code_status);
    return $response;
  }
  if (! get_user_by( 'ID', $receiver_id ))
  {
    $response = new WP_REST_Response('The receiver doesn\'t exist on our database !');
    $response->set_status($code_status);
    return $response;
  }
  $receiver = get_user_by( 'ID', $receiver_id );
  $trigger = $request['trigger'] != null && !empty($request['trigger']) ? $request['trigger'] : false;
  if (!($trigger))
  {
    $response = new WP_REST_Response('The trigger is required !');
    $response->set_status($code_status);
    return $response;
  }
  
  
  //Create notification
  $notification_data = 
  array(
    'post_title' => $title,
    'post_author' => $receiver->ID,
    'post_type' => 'notification',
    'post_status' => 'publish'
  );
  $notification_id = wp_insert_post($notification_data);
  if (is_int($notification_id))
  {
    update_field('content', $content, $notification_id);
    update_field('trigger', $trigger, $notification_id);
    update_field('author_trigger_id', $user->ID, $notification_id);
    
    //Sending email notification
    $first_name = $receiver->first_name ?: $receiver->display_name;
    $email = $receiver->user_email;
    $path_mail = '/templates/mail-notification-invitation.php';
    require(__DIR__ . $path_mail);
    $subject = $title;
    // Have to put here the liggey admin email and define the base template
    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );
    if (wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' )))
    {
      $response = new WP_REST_Response('The email was sent successfully');
      $code_status = 201;
      $response->set_status($code_status);
      return $response;
    }
  }
  $response = new WP_REST_Response('An error occurred while sending the email !');
  $response->set_status($code_status);
  return $response;
}

//[Post]Add skill
function add_topic_to_user(WP_REST_Request $request) {

    $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
    // ID topic
    $topic_id = isset($request['topic_id']) ? intval($request['topic_id']) : 0;

    // ID validated
    if ($topic_id <= 0) {
        $response = array(
            'success' => false,
            'message' => 'Invalid topic ID.'
        );
        return new WP_REST_Response($response, 400);
    }

    $topics_external = get_user_meta($user_id, 'topic');
    $topics_internal = get_user_meta($user_id, 'topic_affiliate');

    // topics external and et topics_internal
    $topics = array_merge($topics_external, $topics_internal);

    // if topic already exists for user
    if (in_array($topic_id, $topics)) {
        $response = array(
            'success' => false,
            'message' => 'Topic already exists for the user.'
        );
        return new WP_REST_Response($response, 400);
    }

    // Add topics for user
    $added = add_user_meta($user_id, 'topic', $topic_id);

    // Return response
    if ($added) {
        $response = array(
            'success' => true,
            'message' => 'Topic added successfully.'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Failed to add topic.'
        );
    }

    // Response
    return new WP_REST_Response($response, 200); // Code de réponse HTTP 200 pour une réussite
}


/* * End Liggeey * */
