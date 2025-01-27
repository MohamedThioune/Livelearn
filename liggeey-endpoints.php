<?php

/* * Liggeey * */
require_once __DIR__ . '/templates/orders-stripe.php';

// Function

//Detail artikel
function artikel($id){

  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);
  //Post is null
  if(empty($post))
    return null;
  $course_type = get_field('course_type', $post->ID);
  $base_url = "https://livelearn.nl"; 

  $sample['ID'] = $post->ID;
  $sample['authorID'] = $post->post_author;
  $sample['title'] = $post->post_title;
  $sample['link'] = $base_url . '/course/details-' . strtolower($course_type) . '/' . $post->post_name;
  $sample['slug'] = $post->post_name;
  $sample['type'] = $course_type;
  //Image information
  $thumbnail = get_field('preview', $post->ID) ? get_field('preview', $post->ID)['url'] : null;
  if(!$thumbnail):
      $thumbnail = get_the_post_thumbnail_url($post->ID);
      if(!$thumbnail)
          $thumbnail = get_field('url_image_xml', $post->ID);
              if(!$thumbnail)
                  $thumbnail = get_stylesheet_directory_uri() . '/img' . '/artikel.jpg';
  endif;
  $sample['image'] = $thumbnail;

  $sample['price'] = 0;
  $price_noformat = get_field('price', $post->ID) ?: 0;
  if($price_noformat) 
    $sample['price'] = is_int($price_noformat) ? number_format($price_noformat, 2, '.', ',') : $price_noformat;

  $sample['language'] = get_field('language', $post->ID);
  //Certificate
  $sample['certificate'] = "No";
  $author = get_user_by('ID', $post->post_author);
  $sample['author_name'] = ($author) ? $author->first_name . ' ' . $author->last_name : 'xxxx xxxx';
  $sample['author_image'] = get_field('profile_img',  'user_' . $post->post_author) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  $post_date = new DateTimeImmutable($post->post_date);
  $sample['post_date'] = $post_date->format('M d, Y');
  $reviews = get_field('reviews', $post->ID);
  $sample['number_comments'] = (!empty($reviews)) ? count($reviews) : 0;
  $sample['short_description'] = get_field('short_description', $post->ID) ?: 'Empty till far ...';
  $sample['content'] = get_field('article_itself', $post->ID) ? : get_field('long_description', $post->ID);

  //Categories 
  $sample['categories'] = get_the_terms( $post->ID, 'course_category' );
  
  //Reviews | Comments
  $comments = array(); 
  $main_reviews = get_field('reviews', $post->ID);
  if(!empty($main_reviews))
  foreach($main_reviews as $review):
    $user = $review['user'];
    $author_name = ($user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name;
    $image_author = get_field('profile_img',  'user_' . $user->ID) ? : get_field('profile_img_api',  'user_' . $user->ID);
    $image_author = $image_author ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
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

function postAdditionnal($post, $userID, $edit = null){
  //check sample artikel
  if(empty($post))
    return null;
  if(!isset($post->ID))
    return null;

  //Partial information
  $coursetype = get_field('course_type', $post->ID);

  /** Get further informations */
  //Podcast 
  // $main_podcasts_genuine = get_field('podcasts', $post->ID);
  // $main_podcasts_index = get_field('podcasts_index', $post->ID);

  //Video
  // $main_videos_genuine = get_field('data_virtual', $post->ID);
  // $main_videos_youtube = get_field('youtube_videos', $post->ID);

  //Offline
  $main_date_genuine = get_field('data_locaties', $post->ID);
  $main_date_xml = get_field('data_locaties_xml', $post->ID);
  $main_date_event = get_field('dates', $post->ID);

  //Optional information
  if($edit):
  $post->how_it_works = get_field('how_it_works', $post->ID); 
  $post->visibility = get_field('visibility', $post->ID); 
  $post->long_description = get_field('long_description', $post->ID); 
  $post->for_who = get_field('for_who', $post->ID); 
  $post->agenda = get_field('agenda', $post->ID); 
  $post->results = get_field('results', $post->ID); 
  $post->incompany_mogelijk = get_field('incompany_mogelijk', $post->ID); 
  $post->accredited = get_field('geacrediteerd', $post->ID); 
  $post->btw_klasse = get_field('btw_klasse', $post->ID); 
  $post->link_to_call = get_field('link_to', $post->ID); 
  $post->online_location = get_field('online_location', $post->ID); 
  endif;

  switch ($coursetype) {
    // case 'Podcast':
    //   $post->podcasts = $main_podcasts_genuine;
    //   $post->podcasts_index = $main_podcasts_index;
    //   break;
    
    // case 'Video':
    //   $post->videos = $main_videos_genuine;
    //   $post->videos_youtube = $main_videos_youtube;
    //   break;

    case 'Opleidingen' || 'Training' || 'Workshop' || 'Masterclass' || 'Event':
      $post->dates = $main_date_genuine;
      $post->dates_xml = $main_date_xml;
      $post->dates_event = $main_date_event;
      break;

    // case 'Leerpad':
    //   $post->playlist = $main_playlist;
    //   break;
  }

  //Reviews
  $reviews = get_field('reviews', $post->ID);
  $count_reviews = (!empty($reviews)) ? count($reviews) : 0;  
  $star_review = [ 0, 0, 0, 0, 0];
  $average_star = 0;
  $average_star_nor = 0;
  $my_review_bool = false;
  $counting_rate = 0;
  //Instructor
  $instructor = array();
  $author = get_user_by('ID', $post->authorID);
  $post->instructor = array();
  $post->instructor = (object)$post->instructor;

  if($author):
    $post->instructor->name = ($author->last_name) ? $author->first_name . ' ' . $author->last_name : $author->display_name;

    $author_image = get_field('profile_img',  'user_' . $post->authorID);
    $post->instructor->image = $author_image ? $author_image : get_stylesheet_directory_uri() . '/img/placeholder_user.png';

    $post->instructor->bio =  get_field('biographical_info',  'user_' . $post->authorID);
    $post->instructor->role =  get_field('role',  'user_' . $post->authorID);

    $post_date = new DateTimeImmutable($post->post_date);
    $post->instructor->date = $post_date->format('d/m/Y');  

    //Courses author
    $args = array(
      'post_type' => array('course','post'),
      'post_status' => 'publish',
      'orderby' => 'date',
      'author' => $post->authorID,
      'order' => 'DESC',
      'posts_per_page' => -1
    );
    $author_courses = get_posts($args);
    $post->instructor->courses = (!empty($author_courses)) ? count($author_courses) : 0;

    //Star rating & reviews
    $post->instructor->star_review[] = array();
    $post->instructor->average_star = 0;
    if ($reviews):
      foreach ($reviews as $review):
        if($review['user']->ID == $userID)
            $my_review_bool = true;

        switch ($review['rating']) {
          case 1:
            $star_review[1] += 1;
            break;
          case 2:
            $star_review[2] += 1;
            break;
          case 3:
            $star_review[3] += 1;
            break;
          case 4:
            $star_review[4] += 1;
            break;
          case 5:
            $star_review[5] += 1;
            break;
        }

        if($review['rating']):
          $average_star += intval($review['rating']);
          $counting_rate += 1;
        endif;
      endforeach;
    endif;
    $post->instructor->star_review = $star_review; 
    $post->instructor->average_star = '5.0'; //Default value is 5.0
    $post->instructor->total_reviews = $count_reviews;
  endif;

  //Enrollment | WooCommerce
  $datenr = 0; 
  $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
  $enrolled = array();
  $statut_bool = 0;
  $enrolled_courses = array();
  // $enrolled_member = 0;
  $enrolled_all = 0;

  //Enrollment | Stripe - by author
  $ordersByAuthor = array();
  $ordersByAuthor = ordersByAuthor($post->ID, 1);
  //get students data for this course 
  $course_enrolled = (isset($ordersByAuthor['studentIDs'][0])) ? $ordersByAuthor['studentIDs'] : array();
  $count_stripe_course_student = (isset($course_enrolled[0])) ? count(array_count_values($course_enrolled)) : 0;
  $statut_bool = (in_array($userID, $course_enrolled)) ? true : $statut_bool;   //check access to user connected
  //get students data for all these author courses
  $course_enrolled_all = (isset($ordersByAuthor['posts'][0])) ? array_column($ordersByAuthor['posts'], 'ownerID') : array();
  $count_stripe_student = (isset($course_enrolled_all[0])) ? count(array_count_values($course_enrolled_all)) : 0;
  $post->average_star = $average_star;
  $post->enrolled_students = $count_stripe_course_student;
  if($author)
    $post->instructor->enrolled_students = $count_stripe_student;
  $post->access = ($statut_bool) ? "All access" : 'Not granted'; 

  //Experts
  $expertS = get_field('experts', $post->ID);
  $author = array($post->authorID);
  $main_experts = (isset($expertS[0])) ? array_merge($expertS, $author) : $author;
  foreach ($main_experts as $value):
    $expert = get_user_by('ID', $value);
    $sample['ID'] = $expert->ID; 
    $sample['name'] = ($expert->last_name) ? $expert->first_name . ' ' . $expert->last_name : $expert->display_name;
    $sample['image'] = get_field('profile_img',  'user_' . $expert->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

    $company = get_field('company',  'user_' . $expert->ID);
    $sample['bio'] =  get_field('biographical_info',  'user_' . $post->authorID);
    $sample['role'] =  get_field('role',  'user_' . $post->authorID);
    $sample['company'] = ($company) ? $company[0]->post_title : '';

    $experts[] = (object)$sample;
  endforeach;
  $post->experts = $experts;

  //Leerpad 

  $playlists = []; 
  $main_playlists = get_field('road_path', $post->ID);
  if($main_playlists)
  foreach($main_playlists as $course)
    $playlists[] = artikel($course->ID);
  $post->courses = $playlists;
  return $post;
}

function challengeAdditionnal($challenge){
  global $wpdb;
  $table = $wpdb->prefix . 'start_challenge';

  //check sample challenge
  if(empty($challenge))
   return null;
  if(!isset($challenge->ID))
    return null;

  $sql = $wpdb->prepare(
    "SELECT * FROM $table WHERE challenge_id = %s",
    $challenge->ID
  );
  $data = $wpdb->get_results($sql);

  return $data;
}

function challengeSteps($challenge, $userID){
  global $wpdb;
  $table = $wpdb->prefix . 'tracker_views';

  //check sample challenge
  if(empty($challenge) || !$userID)
   return null;
  if(!isset($challenge->ID))
    return null;

  $challenge->steps = array();
  //Step 1 - Download & Login 
  $sql = $wpdb->prepare(
    "SELECT * FROM $table WHERE platform = %s AND user_id = %s",
    "mobile", $userID
  );
  $data = $wpdb->get_results($sql);
  $already_login_mobile = get_field('is_first_login_mobile', 'user_' . $userID);
  if(!empty($data) || $already_login_mobile)
    $challenge->steps[] = 1;

  //Step 2 - Assessment
  //Functionnality not yet implemented

  return $challenge;
}
 
//Detail company
function company($id, $no_job = null){
  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  // return $param_post_id;

  //assigner les champs
  $sample['ID'] = $post->ID;
  $sample['title'] = $post->post_title;
  $sample['slug'] = $post->post_name;
  $sample['address'] = get_field('company_address', $post->ID) ?: 'xxxxx';
  $sample['place'] = get_field('company_place', $post->ID) ?: 'xxxx xxx';
  $sample['country'] = get_field('company_country', $post->ID) ?: 'xxxx';
  $sample['biography'] = get_field('company_bio', $post->ID) ?: '';

  $sample['website'] =  get_field('company_website', $post->ID) ?: 'www.livelearn.nl';
  $sample['size'] =  get_field('company_size', $post->ID) ?: 'xx';

  $sample['email'] = get_field('company_email', $post->ID) ?: 'xxxxx@xxx.nl';

  $sample['sector'] = get_field('company_sector', $post->ID) ?: 'xxxxx';
  $sample['logo'] = get_field('company_logo', $post->ID)? : get_stylesheet_directory_uri() . '/img/liggeey-logo-bis.png';

  if(!$no_job):
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
    $main_jobs = get_posts($args);
    $sample['count_open_jobs'] = empty($main_jobs) ? 0 : count($main_jobs);
    $jobs = array();
    foreach ($main_jobs as $job)
      $jobs[] = job($job->ID);
    $sample['open_jobs'] = $jobs;
  endif;

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
  $roles = array();
  $main_roles = $user->roles;
  foreach($main_roles as $role)
    $roles[] = $role;
  $sample['roles'] = $roles;

  $sample['email'] = $user->user_email;
  $sample['mobile_phone'] = $user->mobile_phone;
  $sample['city'] = $user->city;
  $sample['adress'] = $user->adress;
  $sample['image'] = get_field('profile_img',  'user_' . $user->ID) ?:  get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  $sample['work_as'] = get_field('role',  'user_' . $user->ID) ?: "Free agent";
  $sample['cv'] = get_field('cv',  'user_' . $user->ID);
  $sample['country'] = get_field('country',  'user_' . $user->ID) ? : 'N/A';

  //company
  $company = get_field('company',  'user_' . $user->ID) ? get_field('company',  'user_' . $user->ID)[0] : array();
  $main_company = array();
  $main_company['ID'] = !empty($company) ? $company->ID : 0;
  $main_company['title'] = !empty($company) ? $company->post_title : 'xxxx';
  $main_company['logo'] = !empty($company) ? get_field('company_logo',  $company->ID) : $placeholder;
  $main_company['logo'] = ($main_company['logo']) ?: $placeholder;
  $main_company['sector'] = !empty($company) ? get_field('company_sector',  $company->ID) : 'xxxx';
  $main_company['size'] = !empty($company) ? get_field('company_size',  $company->ID) : 'xxxx';
  $main_company['email'] = !empty($company) ? get_field('company_email',  $company->ID) : 'xxxx';
  $main_company['place'] = !empty($company) ? get_field('company_place',  $company->ID) : 'xxxx';
  $main_company['country'] = !empty($company) ? get_field('company_country',  $company->ID) : 'xxxx';
  $main_company['website'] = !empty($company) ? get_field('company_website',  $company->ID) : 'xxxx';
  $sample['company'] = (Object)$main_company;

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
  $sample['date_born'] = $date_born;
  $sample['gender'] = get_field('gender',  'user_' . $user->ID) ? : 'N/A!';
  $sample['language'] = get_field('language',  'user_' . $user->ID) ? : array();
  $sample['education_level'] = get_field('education_level',  'user_' . $user->ID) ? : array();
  $sample['social_network']['facebook'] = get_field('facebook',  'user_' . $user->ID) ? : 'https://www.facebook.com/';
  $sample['social_network']['twitter'] = get_field('twitter',  'user_' . $user->ID) ? : 'https://x.com/';
  $sample['social_network']['instagram'] = get_field('instagram',  'user_' . $user->ID) ? : 'https://www.instagram.com/';
  $sample['social_network']['linkedin'] = get_field('linkedin',  'user_' . $user->ID) ? : 'https://www.linkedin.com/';
  $sample['social_network']['github'] = get_field('github',  'user_' . $user->ID) ? : 'https://github.com/';
  $sample['social_network']['discord'] = get_field('discord',  'user_' . $user->ID) ? : 'https://discord.com/';
  $sample['social_network']['stackoverflow'] = get_field('stackoverflow',  'user_' . $user->ID) ? : 'https://stackoverflow.com/';

  $sample['biographical_info'] = get_field('biographical_info',  'user_' . $user->ID) ? :
  "This paragraph is dedicated to expressing skills what I have been able to acquire during professional experience.<br>
  Outside of let'say all the information that could be deemed relevant to a allow me to be known through my cursus.";

  //skills
  $topics = array();
  $topics = get_user_meta($user->ID, 'topic');
  $skills_note = get_field('skills', 'user_' . $user->ID);
  $skills_origin = array();
  $sample['skills'] = array();
  if(!empty($topics)):
    $args = array(
      'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
      'include'  => $topics,
      'hide_empty' => 0, // change to 1 to hide categores not having a single post
      // 'post_per_page' => $limit
    );
    $main_skills = get_categories($args);

    foreach ($main_skills as $main):
      $skill_sample = [];
      $note = 0;
      if (!empty($skills_note)) 
        foreach ($skills_note as $skill) 
          if($skill['id'] == $main->term_id){
            $note = $skill['note'];
            break;
          }

      $skill_sample['term_id'] = $main->term_id;
      $skill_sample['name'] = $main->name;
      $skill_sample['slug'] = $main->slug;
      $skill_sample['term_taxonomy_id'] = $main->term_taxonomy_id;
      $skill_sample['description'] = $main->description;
      $skill_sample['term_taxonomy_id'] = $main->term_taxonomy_id;
      $skill_sample['parent'] = $main->parent;
      $skill_sample['cat_ID'] = $main->cat_ID;
      $skill_sample['cat_name'] = $main->cat_name;
      $skill_sample['category_nicename'] = $main->category_nicename;
      $skill_sample['category_parent'] = $main->category_parent;
      $skill_sample['note'] = $note;

      //add sample
      $skills_origin[] = (Object)$skill_sample;
    endforeach;

    //add skill complete information
    $sample['skills'] = $skills_origin;
  endif;

  //skills | internal
  $topics_internal = array();
  $topics_internal = get_user_meta($user->ID, 'topic_affiliate');
  $skills_note = get_field('skills', 'user_' . $user->ID);
  $skills_origin = array();
  $main_skills = array();
  $sample['internal_skills'] = array();
  if(!empty($topics_internal)):
    $args = array(
      'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
      'include'  => $topics_internal,
      'hide_empty' => 0, // change to 1 to hide categores not having a single post
      // 'post_per_page' => $limit
    );
    $main_skills = get_categories($args);

    foreach ($main_skills as $main):
      $skill_sample = [];
      $note = 0;
      if (!empty($skills_note)) 
        foreach ($skills_note as $skill) 
          if($skill['id'] == $main->term_id){
            $note = $skill['note'];
            break;
          }

      $skill_sample['term_id'] = $main->term_id;
      $skill_sample['name'] = $main->name;
      $skill_sample['slug'] = $main->slug;
      $skill_sample['term_taxonomy_id'] = $main->term_taxonomy_id;
      $skill_sample['description'] = $main->description;
      $skill_sample['term_taxonomy_id'] = $main->term_taxonomy_id;
      $skill_sample['parent'] = $main->parent;
      $skill_sample['cat_ID'] = $main->cat_ID;
      $skill_sample['cat_name'] = $main->cat_name;
      $skill_sample['category_nicename'] = $main->category_nicename;
      $skill_sample['category_parent'] = $main->category_parent;
      $skill_sample['note'] = $note;

      //add sample
      $skills_origin[] = (Object)$skill_sample;
    endforeach;

    //add skill complete information
    $sample['internal_skills'] = $skills_origin;
  endif;

  //experts
  $experts = array();
  $experts = get_user_meta($user->ID, 'expert');
  $experts_origin = array();
  $read_one = array();
  $sample['experts'] = array();
  if(!empty($experts)):
    foreach($experts as $value):
      $expert_sample = [];
      if(!$value || in_array($value, $read_one))
        continue;

      array_push($read_one, $value);
      $user_expert = get_user_by('ID', $value);
      $expert_sample['ID'] = $user_expert->ID; 

      if($user_expert->ID != $user->ID)
        $expert_sample['name'] = ($user_expert->first_name) ? : $user_expert->display_name;
      else
        $expert_sample['name'] = "Ikzelf";

      if(!$expert_sample['name'])
        continue;

      $image_user = get_field('profile_img',  'user_' . $user_expert->ID);
      $expert_sample['image']= $image_user ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      
      //add sample
      $experts_origin[] = (Object)$expert_sample;
    endforeach;

    //add skill complete information
    $sample['experts'] = $experts_origin;
  endif;

  //Education Information
  $main_education = get_field('education',  'user_' . $user->ID);
  $educations = array();
  $sample['educations'] = array();
  foreach($main_education as $value):

    $education = array();
    if(!$value)
      continue;

    $explosion = explode(";", $value);
    // var_dump($explosion);

    $year = "";
    if(isset($explosion[2]))
      $year = explode("-", $explosion[2])[0];

    if(isset($explosion[3]))
      if(intval($explosion[2]) != intval($explosion[3]))
        $year = $year . "-" .  explode("-", $explosion[3])[0];

    $education['diploma'] = $explosion[1];
    $education['startDate'] = $explosion[2];
    $education['endDate'] = $explosion[3];
    $education['year'] = $year;
    $education['school'] = $explosion[0];
    $education['description'] = $explosion[4];
    $educations[] = $education;

  endforeach;
  $sample['educations'] = $educations;

  //Work & Experience Information
  $main_experience = get_field('work',  'user_' . $user->ID);
  $experiences = array();
  $sample['experiences'] = array();
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
    $experience['startDate'] = $explosion[2];
    $experience['endDate'] = $explosion[3];
    $experience['year'] = $year;
    $experience['job'] = $explosion[0];
    $experience['description'] = $explosion[4];
    $experiences[] = $experience;
  endforeach;
  $sample['experiences'] = $experiences;

  $sample = (Object)$sample;
  return $sample;
}

//Detail job
function job($id, $userApplyId = null){
  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';
  $sample['ID'] = $post->ID;
  $sample['title'] = $post->post_title;
  $sample['slug'] = $post->post_name;
  $sample['posted_at'] = $post->post_date;
  $sample['expired_at'] = get_field('job_expiration_date', $post->ID);
  $sample['description'] = get_field('job_description', $post->ID) ?: 'Empty till far ...';
  $sample['responsibilities'] = get_field('job_responsibilities', $post->ID) ?: 'Empty till far ...';
  $sample['skills_experiences'] = get_field('job_skills_experiences', $post->ID) ?: 'Nothin filled in so far ...';
  $sample['level_of_experience'] = get_field('job_level_of_experience', $post->ID) ?: 0;
  $sample['langues'] = get_field('job_langues', $post->ID) ?: "";

  $company = get_field('job_company', $post->ID);
  $main_company = array();
  $main_company['ID'] = !empty($company) ? $company->ID : 0;
  $main_company['title'] = !empty($company) ? $company->post_title : 'xxxx';
  $main_company['logo'] = !empty($company) ? get_field('company_logo',  $company->ID) : $placeholder;
  $main_company['logo'] = ($main_company['logo']) ?: $placeholder;
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
  // $sample['favorited'] = [];

  $sample['skills_passport'] = get_field('job_topics', $post->ID) ?: false;
  $sample['assessments'] = get_field('job_assessments', $post->ID) ?: false;
  $sample['motivational'] = get_field('job_motivation', $post->ID) ?: false;

  $sample = (Object)$sample;

  // Retrieve the applied 
  // $entity = null;
  $applied = array();
  $additionnals = get_field('job_additionnal', $post->ID);
  foreach ($sample->applied as $entity):
    $tmpUser = candidate($entity->ID);
    $tmpUser->motivation = '';
    if(!empty($additionnals)):
      $additional = array_filter($additionnals, function ($value) use ($entity)  {
	    if($value['userid']->ID == $entity->ID)
          return $value;
      });
      $tmpUser->motivation = $additional[0]['motivation'];
    endif;
    $applied[] = $tmpUser;
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

//Detail challenge
function challenge($id, $userApplyId = null){
  $param_post_id = $id ?? 0;
  $sample = array();
  $post = get_post($param_post_id);

  $sample['ID'] = $post->ID;
  $sample['post_title'] = $post->post_title;
  $sample['post_slug'] = $post->post_name;
  $sample['profile'] = get_field('profile_challenge', $post->ID)?: '';
  $sample['content'] = $post->post_content ?: get_field('description_challenge', $post->ID);
  $sample['skills'] = get_the_terms( $post->ID, 'course_category' );
  $sample['prize'] = get_field('prize_challenge', $post->ID)?: '';
  $sample['banner'] = get_field('banner_challenge', $post->ID)?: '';
  $sample['deadline'] = get_field('deadline_challenge', $post->ID)?: '';

  $company = get_field('company_challenge', $post->ID);
  $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';
  $main_company = array();
  if($company):
  $main_company['ID'] = !empty($company) ? $company->ID : 0;
  $main_company['title'] = !empty($company) ? $company->post_title : '';
  $main_company['logo'] = !empty($company) ? get_field('company_logo',  $company->ID) : $placeholder;
  $main_company['logo'] = ($main_company['logo']) ?: $placeholder;
  $main_company['sector'] = !empty($company) ? get_field('company_sector',  $company->ID) : '';
  $main_company['size'] = !empty($company) ? get_field('company_size',  $company->ID) : '';
  $main_company['email'] = !empty($company) ? get_field('company_email',  $company->ID) : '';
  $main_company['place'] = !empty($company) ? get_field('company_place',  $company->ID) : '';
  $main_company['country'] = !empty($company) ? get_field('company_country',  $company->ID) : '';
  $main_company['website'] = !empty($company) ? get_field('company_website',  $company->ID) : '';
  endif;
  $sample['company'] = (Object)$main_company;

  $sample = (Object)$sample;

  return $sample;
}

function validated($required_parameters, $request){
  $errors = ['errors' => '', 'error_data' => ''];

  //Check required parameters register
  foreach ($required_parameters as $required):
    if (!isset($request[$required])):
      $errors['errors'] = $required . " field is missing !";
      $errors['error_data'] = $required;
      return $errors;
    elseif ($request[$required] == null || empty($request[$required]) ):
      $errors['errors'] = $required . " field is missing value !";
      $errors['error_data'] = $required;
      return $errors;
    endif;
  endforeach;

  return 0;
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
  $categoriesDefined = array(655, 321, 400, 459, 648, 326, 649, 456, 322, 376, 650, 457, 651, 652, 653);
  // $slugdefined = 'business-applications';
  // // $slugdefined = 'digital';
  // $digital_category = get_categories(array('taxonomy' => 'course_category', 'slug' => $slugdefined, 'hide_empty' => 0) )[0];
  // if(is_wp_error($digital_category)):
  //     echo $no_content;
  //     return $infos;
  // endif;

  $sample_categories = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'include' => $categoriesDefined,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );

  foreach ($sample_categories as $key => $category){
    if(!$category)
      continue;
    $sample = array();
    $sample['cat_ID'] = $category->term_id;
    $sample['cat_name'] = $category->name;
    $sample['cat_slug'] = $category->slug;
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

    //Hidden post && language
    $language = get_field('language', $post->ID);
    $hidden = get_field('visibility', $post->ID);
    if($hidden || $language != "en")
      continue;
    //Generic informations
    $sample['ID'] = $post->ID;
    $sample['permalink'] = get_permalink($post->ID);
    $sample['post_title'] = $post->post_title;
    $sample['post_slug'] = $post->post_name;
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

    $sample = (Object)$sample;
    array_push($artikels, $sample);

    $i += 1;
    if($i >= $limit_post)
      break;

  endforeach;
  $infos['artikels'] = $artikels;

  // $users = get_users( array ( 'meta_key' => 'is_liggeey', 'meta_value' => 'candidate', 'order' => 'DESC' ) );
  $featuredIds = [30, 3, 479, 1889, 4272, 4459, 4270, 4226];
  $users = get_users(
    array(
      'include' => $featuredIds,
      'order' => 'DESC' 
    )
  );
  //Featured candidates [Block]
  $i = 0;
  foreach ($users as $key => $value) {
    // die();
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

function allCandidates(){
  $users_query = get_users( array ( 'meta_key' => 'is_liggeey', 'meta_value' => 'candidate', 'orderby' => 'ID' ,'order' => 'DESC' ) );
  $candidates = array();

  //All candidates 
  foreach ($users_query as $key => $value) {
    $sample = array();

    $sample = candidate($value->ID);
    array_push($candidates, $sample);
  }
  $infos['candidates'] = $candidates;

  //Response
  $response = new WP_REST_Response($infos);
  $response->set_status(200);
  return $response;
}

//[POST]Register the company chief
function register_company(WP_REST_Request $request){
  $required_parameters = ['first_name', 'last_name', 'email', 'bedrijf', 'phone', 'password', 'password_confirmation'];
  //country ?

  //Check required parameters register
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Get value fields
  $first_name = $request['first_name'] ?? false;
  $last_name = $request['last_name'] ?? false;
  $email = $request['email'] ?? false;
  $bedrijf = $request['bedrijf'] ?? false;
  $phone = $request['phone'] ?? false;
  $country = $request['country'] ?? false;
  $password = $request['password'] ?? false;
  $password_confirmation = $request['password_confirmation'] ?? false;

  $errors = array();
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
      'user_url' => 'https://livelearn.nl/login/',
      'user_login' => $email,
      'user_email' => $email,
      'user_pass' => $password,
      'role' => 'hr'
  );
  $user_id = wp_insert_user(wp_slash($userdata));

  $errors = [];
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
  $errors = [];
  $param_user_id = $request['id'] ? $request['id'] : get_current_user_id();
  $required_parameters = ['id'];
  $userID = isset($request['userID']) ? $request['userID'] : 0;

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  //Get input
  $errors = array();
  $user_apply_id = $param_user_id;
  $user_apply = get_user_by('ID', $user_apply_id);
  if(!$user_apply):
    $errors['errors'] = 'User not found';
    $errors['error_data'] = 'User';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  $sample = candidate($param_user_id);

  //Favorited or not
  $favorited = false;
  if($userID):
    $saves = get_field('save_liggeey', 'user_' . $userID);
    foreach($saves as $save)
      if($save['type'] == 'candidate' && $save['id'] == $param_user_id)
        $favorited = true;
  endif;
  $sample->favorited = $favorited;
  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;
}

//[POST]Is Managed ?
function IsManagedOrNot(WP_REST_Request $request){
  //Information 
  $userID = $request['userID'] ?? 0;
  $checkID = $request['checkID'] ?? 0;
  $required_parameters = ['checkID', 'userID'];

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  
  $infos = [
    'message' => 'This check user ID do not manage the following user ID !',
    'status' => false
  ];
  $ismanaged = get_field('managed', 'user_' . $checkID);
  if(in_array($userID, $ismanaged)):
    $infos['message'] = 'This check user ID do manage the following user ID !';
    $infos['status'] = true;
  endif;
 
  $response = new WP_REST_Response($infos);
  $response->set_status(200);
  return $response;

}

//[POST]Detail artikel
function artikelDetail(WP_REST_Request $request){
  $param_post_id = $request['slug'] ?? 0;
  $userApplyID = 0; 
  $edit = 0;
  //Get optional params
  if(isset($request['userID']))
  $userApplyID = $request['userID'] ?? 0;
  if(isset($request['edit']))
  $edit = $request['edit'] ?? 0;
  $required_parameters = ['slug'];

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  $post = get_page_by_path($param_post_id, OBJECT, 'course') ?: get_page_by_path($param_post_id, OBJECT, 'post');
  if(!$post)
    $post = get_page_by_path($param_post_id, OBJECT, 'learnpath');
  $sample = artikel($post->ID);

  if(!empty($sample)):
    //Get further information
    $sample = postAdditionnal($sample, $userApplyID, $edit);
  endif;

  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;
}

//[POST]Detail Post
function postDetail(WP_REST_Request $request){
  $param_post_id = $request['slug'] ?? 0;
  $required_parameters = ['slug'];

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  $post = get_page_by_path($param_post_id, OBJECT, 'course') ?: get_page_by_path($param_post_id, OBJECT, 'post');
  var_dump($post);
  if(!$post)
    $post = get_page_by_path($param_post_id, OBJECT, 'learnpath');
  $sample = artikel($post->ID);

  if(!empty($sample)):
    //Get further information
    $sample = postAdditionnal($sample);
  endif;

  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);

  return $response;
}

//[POST]Detail company
function companyDetail(WP_REST_Request $request){
  $param_post_id = $request['slug'] ?? 0;
  $no_job = isset($request['no_job']) ? $request['no_job'] : 0;
  $required_parameters = ['slug'];
  
  $company = get_page_by_path($param_post_id, OBJECT, 'company');
  if (!$company) {
    $errors['errors'] = 'No company found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  }

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  $sample = company($company->ID, $no_job);

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
    $sample['post_slug'] = $post->post_name;
    $sample['address'] = get_field('company_address', $post->ID)?: 'xxxx';
    $sample['sector'] = get_field('company_sector', $post->ID)?: 'xxxx';
    //Just check more by testing but otherwis that a "Good Job !"
    // $sample['company_logo'] = get_field('company_logo',  $post->company_logo) ?: get_stylesheet_directory_uri() . '/img/liggeey-logo-bis.png';
    $sample['company_logo'] = get_field('company_logo',  $post->ID) ?: get_stylesheet_directory_uri() . '/img/company.png';

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

//[GET]All companies
function allCompaniesAdvanced(){

  $company_experts = ['' => ''];
  // Users should
  $users = get_users();
  foreach ($users as $user):
    $company_partial = get_field('company',  'user_' . $user->ID);
    if(!empty($company_partial)):
        $company_partie = $company_partial[0]->post_title;
        $company_experts[$company_partie] .= $user->ID . ',';
    endif;
  endforeach;

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
    $sample['post_slug'] = $post->post_name;
    $sample['address'] = get_field('company_address', $post->ID)?: 'xxxx';
    $sample['sector'] = get_field('company_sector', $post->ID)?: 'xxxx';
    $sample['company_logo'] = get_field('company_logo',  $post->ID) ?: get_stylesheet_directory_uri() . '/img/company.png';

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

    //Experts
    $str_experts = isset($company_experts[$post->post_title]) ? $company_experts[$post->post_title] : '';
    $experts = explode(',', $str_experts);
    $sample['experts'] = (isset($experts[0])) ? count($experts) : 0;

    //Date
    $date = $post->post_date;
    $days = explode(' ', $date)[0];
    $year = explode('-', $days)[0];
    $sample['year'] = $year;

    //Courses
    $count_courses = 0;
    if(isset($experts[0])):
        $args = array(
            'post_type' => array('post','course'),
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order'   => 'DESC',
            'author__in' => $experts,
        );
        $courses = get_posts($args);
        $count_courses = (isset($courses[0])) ? count($courses) : 0;
        $sample['courses'] = $count_courses;
    endif;
    
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

    $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';
    $sample = array('ID' => '0', 'title' => 'xxxx', 'slug' => 'xxxx', 'posted_at' => '', 'image' => $placeholder, 'company' => 'xxxx', 'place' => 'xxxx', 'country' => 'xxxx');
    // Affichez ici le contenu de chaque élément
    $sample['ID'] = $post->ID;
    $sample['title'] = $post->post_title;
    $sample['slug'] = $post->post_name;
    $sample['description'] = get_field('job_description', $post->ID) ?: 'Empty till far ...';
    $sample['posted_at'] = $post->post_date;
    $company = get_field('job_company', $post->ID);

    $sample['company'] = !empty($company) ? $company->post_title : 'xxxx';
    $sample['image'] = !empty($company) ? get_field('company_logo',  $company->ID) : $sample['image'];
    $sample['image'] = ($sample['image']) ?: $placeholder;
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
  $param_post_id = $request['slug'] ?? 0;
  $required_parameters = ['slug'];

  $userID = isset($request['userID']) ? $request['userID'] : 0;
  
  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  $job = get_page_by_path($param_post_id, OBJECT, 'job');
  // $job = get_post($param_post_id);
  $errors = [];
  if (!$job) {
    $errors['errors'] = 'No job found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  }

  $sample = job($job->ID);

  //Favorited course or not
  $favorited = false;
  if($userID):
    $saves = get_field('save_liggeey', 'user_' . $userID);
    foreach($saves as $save)
      if($save['type'] == 'job' && $save['id'] == $job->ID)
        $favorited = true;
  endif;

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

  $sample->favorited = $favorited;
  //Response
  $response = new WP_REST_Response($sample);
  $response->set_status(200);
  return $response;
}

//[POST]Detail category
function categoryDetail(WP_REST_Request $request){
  //Get ID Category
  $sample = array();
  $param_category_id = $request['slug'] ?? 0;
  $required_parameters = ['slug'];
  
  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  //Name + Slug 
  $categories = get_categories( array(
    'taxonomy' => 'course_category',
    'slug' => $param_category_id,
    'hide_empty' => 0
    ) 
  );
  $param_category = (isset($categories[0])) ? $categories[0] : 0;

  $errors = [];
  if(!$param_category):
    $errors['errors'] = 'No category found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;
  
  $sample['name'] = $param_category->name ;
  $sample['slug'] = $param_category->slug ;
  $term_id = $param_category->term_id;

  //tax query
  $tax_query = array(
    array(
      "taxonomy" => "course_category",
      "field"    => 'term_id',
      "terms"    => [$term_id]
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
  $company_in = array();

  foreach($sample['jobs'] as $job):
    if(!$job->company->ID) 
      continue;
    if(!in_array($job->company->ID, $company_in)):
      $company_in[] = $job->company->ID;
      $companies[] = company($job->company->ID);
    endif;
  endforeach;
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
    $sample['author_image'] = get_field('profile_img',  'user_' . $post->post_author) ? : get_field('profile_img_api',  'user_' . $post->post_author);
    $sample['author_image'] = $sample['author_image'] ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';  
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

//[POST]Candidate Apply for a job
function jobUser(WP_REST_Request $request){
  $required_parameters = ['userApplyId', 'jobAppliedId'];

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;    

  //Get inputs
  $user_apply_id = $request['userApplyId'];
  $job_applied_id = $request['jobAppliedId'];
  $motivation = $request['motivation'] ?: null;

  $user_apply = get_user_by('ID', $user_apply_id);
  $job_apply = get_post($job_applied_id);
  
  $errors = [];
  if(!$user_apply || !$job_apply):
    $errors['errors'] = 'Informations filled up wrongly !';
    $errors['error_data'] = 'candidate, job';
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Get the appliants user
  $user_appliants = get_field('job_appliants', $job_applied_id);
  $user_appliants = ($user_appliants) ?: array();

  //Checking ...
  $errors = [];
  $key = array_search($user_apply, $user_appliants);
  if($key !== false):
    $errors['errors'] = 'You can submit only one application';
    $errors['error_data'] = 'candidate';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Add the applying user
  array_push($user_appliants, $user_apply);

  //Update the 'job_appliants'
  update_field('job_appliants', $user_appliants, $job_applied_id);

  //Add additional information
  $additional = array();
  if($motivation):
    $user_additionnal = get_field('job_additionnal', $job_applied_id);
    $user_additionnal = ($user_additionnal) ?: array();

    // Create a additional entry for a job
    $additional['userid'] = $user_apply;
    $additional['motivation'] = $motivation;

    // Update the favorites array
    array_push($user_additionnal, $additional);

    // Update the save liggeey entries
    update_field('job_additionnal', $user_additionnal, $job_applied_id);
  endif;

  //Informations returned "candidate" + "job"
  $infos['candidate'] = $user_apply;
  $infos['chief'] = get_user_by('ID', $job_apply->post_author);
  $infos['job'] = job($job_applied_id);
  $infos['job'] = ['motivation' => $motivation];

  $response = new WP_REST_Response($infos);
  $response->set_status(200);

  return $response;
}

//[POST]Make favorite
function liggeeySave(WP_REST_Request $request){

  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['userApplyId', 'typeApplyId', 'ID'];

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  //Get inputs
  $user_apply_id = $request['userApplyId'];
  $type_applied_id = $request['typeApplyId'];
  $id = $request['ID'];

  $allowedValues = ['job', 'company', 'candidate'];

  //Check if typeApplyId ['job', 'company', 'candidate']
  $errors = [];
  if(!in_array($type_applied_id, $allowedValues)):
    $errors['errors'] = "Please respect this type listed : job, company, candidate";
    $errors = (object)$errors;
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
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

    $image_author = get_field('profile_img',  'user_' . $user->ID) ? : get_field('profile_img_api',  'user_' . $user->ID);
    $image_author = $image_author ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
  
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
  $required_parameters = ['id', 'post_id', 'feedback'];

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

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
  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  $application = array();
  $favorite = array();

  //Get input
  $errors = [];
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id);
  if(!$user_apply):
    $errors['errors'] = 'User not found';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Job company
  $args = array(
    'post_type' => 'job',  
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author' => $user_apply_id,
    'order' => 'DESC' ,
  );
  $jobs = get_posts($args);
  $sample['open_jobs'] = $jobs;
  $sample['count_open_jobs'] = !empty($jobs) ? count($jobs) : 0;
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

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  //Get input
  $errors = [];
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
    'author' => $user_apply->ID,
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
  $required_parameters = ['userApplyId'];
  $applications = array();

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;  

  //Get input
  $errors = [];
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id);
  if(!$user_apply):
    $errors['errors'] = 'User not found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Job company
  $args = array(
    'post_type' => 'job',  
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author' => $user_apply_id,
    'order' => 'DESC' ,
  );
  $jobs = get_posts($args);
  $sample['open_jobs'] = $jobs;
  $sample['count_open_jobs'] = !empty($jobs) ? count($jobs) : 0;
  $application = array();
  $mat_ids = [];
  //Application company
  foreach($sample['open_jobs'] as $post):
    $application = get_field('job_appliants', $post->ID);
    foreach($application as $key => $user):
      if(in_array($user->ID, $mat_ids))
        continue;

      $tmp = candidate($user->ID);
      $tmp->job = $post;
      $applications[] = $tmp;
      $mat_ids[] = $user->ID;
    endforeach;
  endforeach;

  $response = new WP_REST_Response($applications);
  $response->set_status(200);
  return $response;

}

//[POST]Dashboard User | Favorites
function FavoritesUser(WP_REST_Request $request){
  $required_parameters = ['userApplyId'];
  $favorite = array();

  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Get input
  $errors = [];
  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id);
  if(!$user_apply):
    $errors['errors'] = 'User not found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Favorite company
  $matIDs = [];
  $main_favorites = get_field('save_liggeey', 'user_' . $user_apply_id);
  foreach($main_favorites as $favo):
    if(!$favo)
      continue;
    if($favo['type'] != 'candidate')
      continue;

    $user_id = $favo['id'];
    $user = get_user_by('ID', $user_id);
    if(!$user || in_array($user->ID, $matIDs))
      continue;

    $errors = array();
    if(!$user_apply):
      $errors['errors'] = 'User not found !';
      $response = new WP_REST_Response($errors);
      $response->set_status(401);
      return $response;
    endif;

    $matIDs[] = $user->ID;
    $favorite[] = candidate($user->ID);
  endforeach;

  $response = new WP_REST_Response($favorite);
  $response->set_status(200);
  return $response;
}

//[POST]Dashboard User | Post Job
function postJobUser(WP_REST_Request $request){
  $required_parameters = ['userApplyId', 'title', 'job_description', 'job_responsibilities', 'job_skills_experiences', 'job_langues', 'skills'];

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;    

  // Get input
  $title = $request['title'];
  $job_description = $request['job_description'];
  $job_responsibilities = $request['job_responsibilities'];
  $job_contract = ($request['job_contract']) ?: 'Full Time';
  $job_level_experience = ($request['job_level_of_experience']) ?: '';
  $job_language = ($request['job_langues']) ?: 'English';
  $job_application_deadline = ($request['job_expiration_date']);
  $skillsOrigin = ($request['skills']) ?: null;
  $topicSkills = ($request['skill_passport']) ?: array();
  $assessment = ($request['assessment']) ?: array();
  $motivation = ($request['motivation']) ?: null;

  $user_apply_id = $request['userApplyId'];
  $user_apply = get_user_by('ID', $user_apply_id);

  //Job skill & experiences 
  $job_skills_experiences = array();
  $skill_experiences = ($request['job_skills_experiences']) ?: array();
  foreach ($skill_experiences as $value) {
    $skill_exp = array();
    $skill_exp['row'] = $value;
    array_push($job_skills_experiences, $skill_exp);
  }

  // Find the user company
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

  // Check if there are no errors
  $errors = [];
  if(is_wp_error($job_id)):
    $errors['errors'] = $job_id;
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  // Add skills or terms 
  if($skillsOrigin):
    $skillsOrigin = array_map(function($skill) {
      return intval($skill);
    }, $skillsOrigin);

    wp_set_post_terms($job_id, $skillsOrigin, 'course_category');
  endif;


  //Add skills passport topics
  // $args = array(
  //   'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
  //   'include'  => $topicSkills,
  //   'hide_empty' => 0, // change to 1 to hide categores not having a single post
  //   // 'post_per_page' => $limit
  // );
  // $skillsPassport = get_categories($args);

  //Add assessments
  $args = array(
    'post_type' => 'assessment',  
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC' ,
  );
  $assessments = get_posts($args);

  // Add custom fields 
  update_field('job_company', $company, $job_id);
  update_field('job_description', $job_description, $job_id);
  update_field('job_responsibilities', $job_responsibilities, $job_id);
  update_field('job_skills_experiences', $job_skills_experiences, $job_id);
  update_field('job_contract', $job_contract, $job_id);
  update_field('job_level_of_experience', $job_level_experience, $job_id);
  update_field('job_langues', $job_language, $job_id);
  update_field('job_expiration_date', $job_application_deadline, $job_id);
  // update_field('job_topics', $skillsPassport, $job_id);
  update_field('job_assessments', $assessments, $job_id);
  update_field('job_motivation', $motivation, $job_id);

  // Return the job
  $job = job($job_id);
  $response = new WP_REST_Response($job);
  $response->set_status(200);

  return $response;
}

//[POST]Dashboard User | Edit Job
function editJobUser(WP_REST_Request $request) {
  $required_parameters = ['jobID'];
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $job_id = isset($request['jobID']) ? $request['jobID'] : 0;
  $skillsOrigin = ($request['skills']) ?: null;

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  //Data Job
  $job = get_post($job_id);

  $errors = [];
  if (!$job) {
      $errors['errors'] = 'No job found !';
      $response = new WP_REST_Response($errors);
      $response->set_status(401);
      return $response;
  }

  // Add skills or terms 
  if($skillsOrigin):
    $skillsOrigin = array_map(function($skill) {
      return intval($skill);
    }, $skillsOrigin);

    wp_set_post_terms($job_id, $skillsOrigin, 'course_category');
  endif;

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

  $required_parameters = ['jobID'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  //Data Job
  $job = get_post($job_id);
  $jobTo = job($job_id);
  $candidate = get_user_by('ID', $user_id);

  $errors = [];
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
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

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
  $errors = [];
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

  //Favorites 
  $favorites = array();
  $saves = get_field('save_liggeey', 'user_' . $user_apply->ID);
  foreach($saves as $save)
    if($save['type'] == 'candidate')
      $favorites[] = get_user_by('ID', $save['id']);
  $companyInfos->favorites = $favorites;

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

  $errors = [];
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
  $required_parameters = ['userApplyId', 'userDeleteId'];

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

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

//[POST]Apply Candidate | Delete favorite job
function trashFavouriteJob(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $required_parameters = ['userApplyId', 'userJobId'];

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  //Get inputs
  $user_apply_id = isset($request['userApplyId']) ? $request['userApplyId'] : 0;
  $user_job_id = isset($request['userJobId']) ? $request['userJobId'] : 0;

  // Récupérer les favoris de l'utilisateur
  $user_favorites = get_field('save_liggeey', 'user_' . $user_apply_id);
  $user_favourites = array();
  $user_shorlisted_jobs = [];

  // Vérifier si l'utilisateur a des emplois favoris
  if ($user_favorites) 
    foreach ($user_favorites as $favorite):
      if ($favorite['type'] == 'job') :
        // Récupérer les détails de l'emploi
        if($favorite['id'] == $user_job_id)
          continue;
      endif;

      $user_shorlisted_jobs['type'] = $favorite['type'];
      $user_shorlisted_jobs['id'] = $favorite['id'];
      array_push($user_favourites, $user_shorlisted_jobs);
    endforeach;
  
  update_field('save_liggeey', $user_favourites, 'user_' . $user_apply_id);

  //Remove the user in list appliants
  // $appliants = get_field('job_appliants', $job_applied_id);
  // $appliants = ($appliants) ?: array();
  // $key = array_search($user_apply, $appliants);
  // if($key !== false)
  //   unset($appliants[$key]);
  // update_field('job_appliants', $appliants, $job_applied_id);

  $success = "User favorites changed with success !";
  $response = new WP_REST_Response($success);
  $response->set_status(200);

  return $response;
}

//[POST]Apply User | Approve or Reject candidate
function jobUserApproval(WP_REST_Request $request){
  $errors = ['errors' => '', 'error_data' => ''];
  $infos = [];
  $required_parameters = ['userApproveId', 'jobAppliedId', 'status'];

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  // Get inputs
  $user_apply_id = isset($request['userApproveId']) ? $request['userApproveId'] : 0;
  $job_applied_id = isset($request['jobAppliedId']) ? $request['jobAppliedId'] : 0;
  $status = isset($request['status']) ? $request['status'] : '';

  $user_apply = get_user_by('ID', $user_apply_id);
  $job_apply = get_post($job_applied_id);

  $errors = [];
  if(!$user_apply || !$job_apply):
    $errors['errors'] = 'Informations filled up wrongly !';
    $errors['error_data'] = 'candidate, job';
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  // Remove the user in list appliants
  $errors = [];
  $appliants = get_field('job_appliants', $job_applied_id);
  $appliants = ($appliants) ?: array();
  $key = array_search($user_apply, $appliants);
  if($key !== false):
    unset($appliants[$key]);
  else:
    $errors['errors'] = 'You don\'t need to perform any further actions on this user !';
    $errors['error_data'] = 'candidate, job';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  update_field('job_appliants', $appliants, $job_applied_id);

  if(!$status || $status == "" || $status == " "):
    $response = new WP_REST_Response("No status found !");
    $response->set_status(200);
  endif;

  if($status == 'approve'):
    // Get the approved appliants user
    $user_appliants = get_field('job_appliants_approved', $job_applied_id);
    $user_appliants = ($user_appliants) ?: array();
    //Add the applying user
    array_push($user_appliants, $user_apply);
    update_field('job_appliants_approved', $user_appliants, $job_applied_id);
  elseif($status == "reject"):
    // Get the rejected appliants user
    $user_appliants = get_field('job_appliants_rejected', $job_applied_id);
    $user_appliants = ($user_appliants) ?: array();
    // Add the applying user
    array_push($user_appliants, $user_apply);
    update_field('job_appliants_rejected', $user_appliants, $job_applied_id);
  endif;

  //Informations returned "candidate" + "job"
  $infos['status'] = $status;
  $infos['candidate'] = $user_apply;
  $infos['chief'] = get_user_by('ID', $job_apply->post_author);
  $infos['job'] = job($job_applied_id);

  $response = new WP_REST_Response($infos);
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

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  //Get input
  $errors = [];
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
    'order' => 'DESC' ,
  );
  $job_posts = get_posts($args);
  $suggestion_jobs = array();
  $count_applied = 0;

  foreach ($job_posts as $post) :

    if(count($suggestion_jobs) < $limit_job)
      $suggestion_jobs[] = job($post->ID);

    $user_applied_jobs = get_field('job_appliants', $post->ID);
    foreach($user_applied_jobs as $userapply)
      if($userapply->ID == $userApplyId)
        $count_applied += 1;
        // $applied_jobs[] = job($post->ID);

  endforeach;
  $sample['count_applieds'] = $count_applied;
 
  //Job alerts 
  $sample['count_jobs'] = 0;
  /** Instrtuctions should be there */

  //Favorite company
  $main_favorites = get_field('save_liggeey', 'user_' . $userApplyId);
  $favorite = 0;

  foreach($main_favorites as $favo):
    if(!$favo)
      continue;
    if($favo['type'] != 'company' && $favo['type'] != 'job')
      continue;
    $favorite += 1;
  endforeach;
  $sample['count_favorites'] = $favorite;

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
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  //Get input
  $errors = [];
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
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 
  
  //Data User
  $candidate_data = candidate($user_id);

  $errors = [];
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
  $required_parameters = ['userApplyId'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

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
  $required_parameters = ['userApplyId'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  // Récupérer l'ID de l'utilisateur à partir de la requête ou de l'utilisateur connecté
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

  // Récupérer les emplois favoris de l'utilisateur
  $user_favorites = get_field('save_liggeey', 'user_' . $user_id);
  $user_shorlisted_jobs = [];
  $user_in = [];

  // Vérifier si l'utilisateur a des emplois favoris
  if ($user_favorites)
    foreach ($user_favorites as $favorite)
      if ($favorite['type'] == 'job') :
        // Récupérer les détails de l'emploi
        if($favorite['id'])
          if(!in_array($favorite['id'], $user_in)):
            array_push($user_in, $favorite['id']);
            $user_shorlisted_jobs[] = job($favorite['id']);
          endif;
      endif;

  $response = new WP_REST_Response($user_shorlisted_jobs);
  $response->set_status(200);
  return $response;
}

//[POST]Dashboard Candidate | Skills passport
function candidateSkillsPassport(WP_REST_Request $request) {
  $required_parameters = ['userApplyId'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];
  $validated = validated($required_parameters, $request);

  $errors = [];
  $user_apply = get_user_by('ID', $user_id);
    if (!$user_apply) {
        $errors['errors'] = 'User not found';
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    } else {
        $user_id = $user_apply->ID;
    }


  //Enrolled with Stripe
  $enrolled_courses = list_orders($user_apply->ID)['posts'];
  //Progression
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

  //Favorite course
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

    $price = get_field('price', $course->ID) ?: 'Gratis';
    // if ($price != "0") {
    //     $formatted_price = '$' . number_format($price, 2, '.', ',');
    // } else {
    //     $formatted_price = 'Gratis';
    // }
    $author = get_user_by('ID', $course->post_author);
    $author_name = $author->display_name ?: $author->first_name;

      //data additional
    $course_combined_info = array_merge($course_info, array(
        'thumbnail_url' => $thumbnail,
        'price' => $price,
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
        foreach($achievements as $key => $achievement):

            $type = get_field('type_badge', $achievement->ID);

            $achievement->manager = get_user_by('ID', get_field('manager_badge', $achievement->ID));
            $achievement->manager_image = get_field('profile_img',  'user_' . $achievement->post_author) ?: get_field('profile_img_api',  'user_' . $achievement->post_author);
            $achievement->manager_image = $achievement->manager_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            if(!$image)
                $image = get_stylesheet_directory_uri() . '/img/Group216.png';
            $achievement_info = array();

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
        'prestatie' => $prestaties,
        'diploma' => $diplomas,
        'courses_info' => $courses_combined,
        // 'other_data'=>detailsPeople()->data

    );

    // Response
    $response = new WP_REST_Response($data);
    $response->set_status(200);
    return $response;
}

//[POST]Dashboard Candidate | Skills passport
function candidateSkillsPassportAdvanced(WP_REST_Request $request) {
  $required_parameters = ['userApplyId'];
  //Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

  $required_parameters = ['userApplyId'];
  $errors = ['errors' => '', 'error_data' => ''];
  $validated = validated($required_parameters, $request);

  $errors = [];
  $user_apply = get_user_by('ID', $user_id);
  if (!$user_apply) {
    $errors['errors'] = 'User not found';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  } 
  else 
    $user_id = $user_apply->ID;

  //Informations user 
  $user = candidate($user_id);

  $enrolled = array();
  $enrolled_courses = array();
  
  //Enrolled with Stripe
  $enrolled = list_orders($user_id, 1)['ids'];  
  if(!empty($enrolled)):
    $args = array(
        'post_type' => 'course',
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => $enrolled,
    );
    $enrolled_courses = get_posts($args);
  endif;
  $state = array('new' => 0, 'progress' => 0, 'done' => 0);
  foreach($enrolled_courses as $key => $course):
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

  //Todo's
  $todos_feedback = array();
  $todos_onderwerpen = array();
  $todos_plannen = array();
  $todos_cursus = array();
  // $count_mandatories = 0;
  /* Mandatories */
  $args = array(
    'post_type' => 'mandatory', 
    'post_status' => 'publish',
    'author' => $user->ID,
    'posts_per_page'         => -1,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false
  );
  $mandatories = get_posts($args);
  $count_mandatory_done = 0;
  foreach($mandatories as $mandatory):
    $pourcentage = 0;
    //Get read by user 
    $progressions = array();
    $args = array(
      'post_type' => 'progression',
      'title' => $mandatory->post_title,
      'post_status' => 'publish',
      'author' => $user_id,
      'posts_per_page'         => 1,
      'no_found_rows'          => true,
      'ignore_sticky_posts'    => true,
      'update_post_term_cache' => false,
      'update_post_meta_cache' => false
    );
    $progressions = get_posts($args);
    if(!empty($progressions)):
      $progression_id = $progressions[0]->ID;
      //Finish read
      $is_finish = get_field('state_actual', $progression_id);
      if($is_finish){
        $count_mandatory_done += 1;
        $pourcentage = 100;
      }

      $post = get_page_by_path($mandatory->post_title, OBJECT, 'course');
      $type_post = ($post) ? get_field('course_type', $post->ID) : 'NaN';
      // var_dump($type_post);
      
      if($type_post == 'Video'){
          $courses = get_field('data_virtual', $post->ID);
          $youtube_videos = get_field('youtube_videos', $post->ID);
          if(!empty($courses))
              $count_lesson = count($courses);
          else if(!empty($youtube_videos))
              $count_lesson = count($youtube_videos);
      }
      else if($type_post == 'Podcast'){
          $podcasts = get_field('podcasts', $post->ID);
          $podcast_index = get_field('podcasts_index', $post->ID);
          if(!empty($podcasts))
              $count_lesson = count($podcasts);
          else if(!empty($podcast_index))
              $count_lesson = count($podcast_index);
      }
      else{
          $count_lesson = 0;
      }

      //Pourcentage
      $lesson_reads = get_field('lesson_actual_read', $progression_id);
      $count_lesson_reads = ($lesson_reads) ? count($lesson_reads) : 0;
      if($count_lesson)
        $pourcentage = ($count_lesson) ? ($count_lesson_reads / $count_lesson) * 100 : 0;                
    endif;
    $mandatory->pourcentage = intval($pourcentage);

    $type = get_field('type_feedback', $mandatory->ID);
    $manager = get_user_by('ID', get_field('manager_feedback', $mandatory->ID));
    $manager_image = (isset($manager->ID)) ? get_field('profile_img',  'user_' . $manager->ID) : get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
    $mandatory->manager = $manager;
    $mandatory->manager_image = $manager_image;
    $due_date = get_field('welke_datum_feedback', $mandatory->ID);
    $mandatory->due_date = ($due_date) ? date("d-m-Y", strtotime($due_date[1])) : '🗓️';

    $image = get_stylesheet_directory_uri() . '/img/Group216.png';

    switch ($type) {
      case 'Feedback':
        $mandatory->beschrijving_feedback = get_field('beschrijving_feedback', $mandatory->ID);
        array_push($todos_feedback, $mandatory);
        break;
      case 'Persoonlijk ontwikkelplan':
        $mandatory->beschrijving_feedback = get_field('opmerkingen', $mandatory->ID);
        array_push($todos_plannen, $mandatory);
        break;
      case 'Onderwerpen':
        $mandatory->beschrijving_feedback = get_field('beschrijving_feedback', $mandatory->ID);
        array_push($todos_onderwerpen, $mandatory);
        break;
      case 'Verplichte cursus':
        $mandatory->beschrijving_feedback = get_field('beschrijving_feedback', $mandatory->ID);
        array_push($todos_cursus, $mandatory);
        break;
    }
  endforeach;
  //End

  //Badges
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
  $prestaties = array();
  $diplomas = array();
  $image = '';
  if(!empty($achievements))
    foreach($achievements as $key => $achievement):
      $type = get_field('type_badge', $achievement->ID);

      $manager = get_user_by('ID', get_field('manager_badge', $achievement->ID));
      $manager_image = (isset($manager->ID)) ? get_field('profile_img',  'user_' . $manager->ID) : get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
      $achievement->manager = $manager;
      $achievement->manager_image = $manager_image;

      if(!$image)
          $image = get_stylesheet_directory_uri() . '/img/Group216.png';
      $achievement_info = array();
      $achievement->badge_image = get_stylesheet_directory_uri() . '/img/badge-assessment.png';

      switch ($type) {
        case 'Genuine':
          $achievement_info = array(
            'ID' => $achievement->ID,
            'title' => $achievement->post_title,
            'trigger_badge' => get_field('trigger_badge', $achievement->ID),
            'level_badge' => get_field('level_badge', $achievement->ID) ?: '<b>Company</b>',
            'manager' => $achievement->manager,
            'manager_image' => $achievement->manager_image,
            'badge_image' => get_field('image_badge', $achievement->ID) ?: get_stylesheet_directory_uri() . '/img/badge-basic.png',
          );
          $badges[] = $achievement_info;
          break;
        case 'Certificaat':
          $achievement_info = array(
            'ID' => $achievement->ID,
            'title' => $achievement->post_title,
            'certificaatnummer' => get_field('certificaatnummer_badge', $achievement->ID) ?: 'None',
            'uitgegeven_door_badge' => get_field('uitgegeven_door_badge', $achievement->ID) ?: 'None',
            'url' => get_field('url_aanbieder_badge', $achievement->ID) ?: 'None',
            'manager' => $achievement->manager,
            'manager_image' => $achievement->manager_image,
            'badge_image' => get_stylesheet_directory_uri() . '/img/badge-assessment.png'
          );
          $certificats[] = $achievement_info;
          break;

        case 'Prestatie':
          $achievement_info = array(
            'ID' => $achievement->ID,
            'title' => $achievement->post_title,
            'uren' => get_field('uren_badge', $achievement->ID) ?: 'None',
            'punten' => get_field('punten_badge', $achievement->ID) ?: 'None',
            'competencies' => get_field('competencies_badge', $achievement->ID) ?: 'None',
            'opmerkingen' => get_field('opmerkingen_badge', $achievement->ID) ?: 'None',
            'manager' => $achievement->manager,
            'manager_image' => $achievement->manager_image,
            'badge_image' => get_stylesheet_directory_uri() . '/img/badge-assessment.png'
          );
          $prestaties[] = $achievement_info;
          break;
        case 'Diploma':
          $achievement_info = array(
            'ID' => $achievement->ID,
            'title' => $achievement->post_title,
            'certificaatnummer' => get_field('certificaatnummer_badge', $achievement->ID) ?: 'None',
            'uitgegeven_door_badge' => get_field('uitgegeven_door_badge', $achievement->ID) ?: 'None',
            'url' => get_field('url_aanbieder_badge', $achievement->ID) ?: 'None',
            'manager' => $achievement->manager,
            'manager_image' => $achievement->manager_image,
            'badge_image' => get_stylesheet_directory_uri() . '/img/badge-assessment.png'
          );
          $diplomas[] = $achievement_info;
          break;
        default:
          $achievement_info = array(
            'ID' => $achievement->ID,
            'title' => $achievement->post_title,
            'trigger_badge' => get_field('trigger_badge', $achievement->ID),
            'level_badge' => get_field('level_badge', $achievement->ID) ?: '<b>Company</b>',
            'manager' => $achievement->manager,
            'manager_image' => $achievement->manager_image,
            'badge_image' => get_field('image_badge', $achievement->ID) ?: get_stylesheet_directory_uri() . '/img/badge-basic.png',
          );
          $badges[] = $achievement_info;
          break;
      }
    endforeach;
  //End
    
  //Feedbacks
  $args = array(
    'post_type' => 'feedback', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
  );
  $todos = get_posts($args);

  $feedbacks = array();
  $persoonlijk_ontwikkelplan = array();
  $beoordeling_gesprek = array();
  $compliments = array();
  $gedeelde_cursus = array();
  $verplichte_cursus = array();
  if(!empty($todos))
    foreach($todos as $key=>$todo):
        $rating = null;

        $type = get_field('type_feedback', $todo->ID);
        $todo->manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

        $todo->manager_image = get_field('profile_img',  'user_' . $todo->manager->ID);
        if(!$image)
            $image = get_stylesheet_directory_uri() . '/img/Group216.png';
        $rating = get_field('rating_feedback', $todo->ID);
        $todo->rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';

        switch ($type) {
            case 'Feedback':
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($feedbacks, $todo);
                break;
            case 'Compliment':
                $due_date = get_field('welke_datum_feedback', $todo->ID)[1];
                $todo->due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($compliments, $todo);
                break;
            case 'Persoonlijk ontwikkelplan':
                $todo->beschrijving_feedback = get_field('opmerkingen', $todo->ID);
                array_push($persoonlijk_ontwikkelplan, $todo);
                break;
            case 'Beoordeling Gesprek':
                $due_date = get_field('welke_datum_feedback', $todo->ID)[1];
                $todo->due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';
                $todo->beschrijving_feedback = get_field('algemene_beoordeling', $todo->ID);
                array_push($beoordeling_gesprek, $todo);
                break;
            case 'Gedeelde cursus':
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($gedeelde_cursus, $todo);
                break;
            case 'Verplichte cursus':
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($verplichte_cursus, $todo);
                break;
        }
    endforeach;
  //End

  //Statistique
  // $statistique = detailsPeopleSkillsPassport(array('userID' => $user_id));

  // Informations 
  $data = array(
    'user' => $user,
    'state' => $state,
    // 'statistique' => $statistique,
    'todos' => [
      'feedback' => $todos_feedback,
      'onderwerpen' => $todos_onderwerpen,
      'plannen' => $todos_plannen,
      'cursus' => $todos_cursus,
    ],
    'achievements' => [
      'badges' => $badges,
      'certificats' => $certificats,
      'prestaties' => $prestaties,
      'diplomas' => $diplomas,
    ],
    'feedbacks' => [
      'feedback' => $feedbacks,
      'ontwikkelplan' => $persoonlijk_ontwikkelplan,
      'beoordeling' => $beoordeling_gesprek,
      'compliment' => $compliments,
      'gedeelde' => $gedeelde_cursus,
      'verplichte' => $verplichte_cursus
    ],

  );

  // Response
  $response = new WP_REST_Response($data);
  $response->set_status(200);
  return $response;
}

//[Add]Dashboard My_Resume
function candidateMyResumeAdd(WP_REST_Request $request) {
  $required_parameters = ['userApplyId'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

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
  $required_parameters = ['userApplyId'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

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
  $required_parameters = ['userApplyId'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

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

//[Post]Add skill
function add_topics_to_user(WP_REST_Request $request) {
  $required_parameters = ['userApplyId', 'topics'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  // ID user + Get user topics
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $topics_external = get_user_meta($user_id, 'topic');
  $topics_internal = get_user_meta($user_id, 'topic_affiliate');
  $topics = array_merge($topics_external, $topics_internal);
  
  // Adding topics ...
  $request_topics = ($request['topics']) ? explode(',', $request['topics']) : array();
  $bool_added = false;
  foreach($request_topics as $topic_id):
    // ID topic inferior to 0
    if ($topic_id <= 0) {
      $response = array(
          'success' => false,
          'message' => 'Invalid topic ID.'
      );
      return new WP_REST_Response($response, 400);
    }

    // if topic already exists for user
    if (in_array($topic_id, $topics))
      continue;

    // Add topics for user
    $added = add_user_meta($user_id, 'topic', $topic_id);

    // Return response
    if ($added) 
      $bool_added = true;
   
  endforeach;

  // Response
  $message = (!$bool_added) ? "Topic add : no news added !" :  "Topic add : action done ✅";
  $response = array(
    'success' => true,
    'message' => $message
  );
  return new WP_REST_Response($response, 200); // Code de réponse HTTP 200 pour une réussite
}

function add_topics_internal_to_user(WP_REST_Request $request){
  $required_parameters = ['userManagerId', 'userEmployeeId', 'topics'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  $added = false;
  $user_id = $request['userEmployeeId'];
  $manager = isset($request['userManagerId']) ? $request['userManagerId'] : get_current_user_id();
  $topics = $request['topics'];
  $bunch = get_user_meta($user_id,'topic_affiliate');
  foreach($topics as $topic):
    if(!in_array($topic, $bunch)):
      add_user_meta($user_id, 'topic_affiliate', $topic);
      $added = true;
    endif;
  endforeach;   
  
  // Response
  $message = (!$added) ? "Topic add : no news added !" :  "Topic add : action done ✅";
  $response = array(
    'success' => true,
    'message' => $message
  );
  return new WP_REST_Response($response, 200); // Code de réponse HTTP 200 pour une réussite
}

//Made By Fadel
function sendNotificationBetweenLiggeyActors(WP_REST_Request $request){
  $code_status = 400;

  /** Checking parameters **/

  $userIDs = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $userS = (is_array($userIDs)) ? $userIDs : [$userIDs];
  if (!$userS)
  {
    $response = new WP_REST_Response('You\'ve to be logged in !');
    $response->set_status($code_status);
    return $response;
  }

  $title = $request['title'] != null && !empty($request['title']) ? $request['title'] : false;
  if (!$title)
  {
    $response = new WP_REST_Response('The title is required !');
    $response->set_status($code_status);
    return $response;
  }
  // $title = (isset($request['is_livelearn'])) ? $title . ' section is missing !' : $title;

  $content = $request['content'] != null && !empty($request['content']) ? $request['content'] : false;
  if (!($content))
  {
    $response = new WP_REST_Response('The content is required !');
    $response->set_status($code_status);
    return $response;
  }

  $trigger = $request['trigger'] != null && !empty($request['trigger']) ? $request['trigger'] : false;
  if (!($trigger))
  {
    $response = new WP_REST_Response('The trigger is required !');
    $response->set_status($code_status);
    return $response;
  }

  $author_trigger_id = $request['author_trigger'] != null && !empty($request['author_trigger']) ? $request['author_trigger'] : false;
  $author_trigger = get_user_by('ID', $author_trigger_id);
  /** End checking **/

  $mail_sent = false;
  foreach($userS as $id):
    $user = get_user_by('ID', $id);
    //Create notification
    $notification_data = 
    array(
      'post_title' => $title,
      'post_author' => $user->ID,
      'post_type' => 'notification',
      'post_status' => 'publish'
    );
    $notification_id = wp_insert_post($notification_data);
    if (is_int($notification_id))
    {
      update_field('content', $content, $notification_id);
      update_field('trigger', $trigger, $notification_id);
      if($author_trigger)
        update_field('author_trigger_id', $author_trigger->ID, $notification_id);
      
      //Sending email notification
      //title + trigger + content parsing
      $first_name = $user->first_name ?: $user->display_name;
      $emails = [$user->user_email, 'info@livelearn.nl'];
      // $emails = [$user->user_email];

      //Showin information 
      $company = get_field('company',  'user_' . $user->ID);
      $postTitle = $company[0]->post_title;
      // $title = (!isset($request['is_livelearn'])) ? $trigger . ' needs your attention !' : $title;
      $trigger = (!isset($request['is_livelearn'])) ? $title : $trigger;

      $path_mail = (!isset($request['is_livelearn'])) ? '/templates/mail-liggeey.php' : '/templates/mail-livelearn.php';
      // $path_mail = '/templates/mail-liggeey.php';
      require(__DIR__ . $path_mail);
      $subject = $title;
      // Have to put here the liggey admin email and define the base template

      $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );
      if (wp_mail($emails, $subject, $mail_invitation_body, $headers, array( '' )))
        $mail_sent = true;
    }
  endforeach;

  if($mail_sent):
    $response = new WP_REST_Response('The email was sent successfully');
    $code_status = 201;
    $response->set_status($code_status);
    return $response;
  endif;

  $response = new WP_REST_Response('An error occurred while sending the email !');
  $response->set_status($code_status);
  return $response;
}

function notifications(WP_REST_Request $request){
  //Information
  $required_parameters = ['userApplyId'];
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();
  $user_apply = get_user_by( 'ID', $user_id );

  //List notification
  $notifications = array(); 
  $args = array(
    'post_type' => 'notification',  
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author' => $user_apply->ID,
    'order' => 'DESC' ,
  );
  $main_notifications = get_posts($args);

  // Récupérer l'ID de l'utilisateur 
  $user_id = isset($request['userApplyId']) ? $request['userApplyId'] : get_current_user_id();

  foreach ($main_notifications as $key => $post) :
    # code...
    $sample = array();
    $sample['ID'] = $post->ID;
    $sample['title'] = $post->post_title;
    $post_date = new DateTimeImmutable($post->post_date);
    $sample['post_date'] = $post_date->format('M d, Y');
    $sample['content'] = get_field('content', $post->ID) ?: 'Nan';
    $sample['trigger'] = get_field('trigger', $post->ID) ?: 'Nan';
    $author_trigger_id = get_field('author_trigger_id', $post->ID);

    //Author trigger [Not in mandatory]
    if($author_trigger_id):
      $author = get_user_by('ID', $author_trigger_id);
      if($author):
        $sample['author_trigger']['name'] = ($author) ? $author->first_name . ' ' . $author->last_name : 'xxxx xxxx';
        $sample['author_trigger']['photo'] = get_field('profile_img',  'user_' . $author->ID) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      endif;
    endif;

    array_push($notifications, $sample);

  endforeach;

  $response = new WP_REST_Response($notifications);
  $code_status = 201;
  $response->set_status($code_status);
  return $response;
}

function editSkills(WP_REST_Request $request){
  $required_parameters = ['ID', 'skill', 'note'];
  //Check required parameters
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif; 

  $user_id = $request['ID'];
  $skills = get_field('skills', 'user_' . $user_id);
  $skill = array();
  $skill['id'] = $request['skill'];
  $skill['note'] = $request['note'];
  $bool = false;
  $bunch = array();

  if(empty($skills))
    $skills = array();
  foreach($skills as $item):
    if($item['id'] == $skill['id']){
      $item['note'] = $skill['note'];
      $bool = true;
    }
    array_push($bunch, $item);
  endforeach;

  if(!$bool)
    array_push($skills, $skill);
  else
    $skills = $bunch;

  //update skills
  update_field('skills', $skills, 'user_' . $user_id);

  $skill_sample['term_id'] = $skill['id'];
  $skill_sample['name'] = get_the_category_by_ID($skill['id']);
  $skill_sample['note'] = $skill['note'];

  $response = new WP_REST_Response($skill_sample);
  $code_status = 201;
  $response->set_status($code_status);
  return $response;
}

function statut_course($post_name, $ID){
  //Color
  $text_status = "New";
  $color_status = "#043356";
  $information = array('text' => $text_status, 'color' => $color_status);

  //Get read by user 
  $args = array(
    'post_type' => 'progression', 
    'title' => $post_name,
    'post_status' => 'publish',
    'author' => $ID,
    'posts_per_page'         => 1,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false
  );
  $progressions = get_posts($args);

  //Print progress
  if(!empty($progressions)){
    $color_status = "#ff9b00";
    $text_status = "In progress";
    $progression_id = $progressions[0]->ID;
    //Finish read
    $is_finish = get_field('state_actual', $progression_id);
    if($is_finish){
        $color_status = "green";
        $text_status = "Done";
    }
  }
  $information['text'] = $text_status;
  $information['color'] = $color_status;

  return $information;
}
/* * End Liggeey * */

//Activity 
function activity($ID){
  /* * Information * */
  $information = array( 
    'user' => null, 
    'courses' => null, 
    'notifications' => null, 
    'analytics' => 'not available !', 
    'certificates' => null, 
    'communities' => null,
    'skills' => null
  );

  //User information
  $user = ($ID) ? get_user_by('ID', $ID) : null;
  if(!$user)
    return 0;
  $information['user'] = $user;
  //End ...

  //Enrolled sample - course
  $courses = array();
  $mandatory_video = get_field('mandatory_video', 'user_' . $user->ID);
  
  //Enrolled with Stripe
  $enrolled_stripe = array();
  $enrolled_stripe = list_orders($user->ID, 1)['posts'];
  if(!empty($enrolled_stripe)):
    foreach ($enrolled_stripe as $post)
      try {
        if($post):
          $course = artikel($post->ID);
          //Get statut
          $course->statut = ($course->slug) ? statut_course($course->slug, $user->ID)['text'] : ""; 
          if($course->title && $course->title != "")
            array_push($courses, $course);
        endif;
      } catch (Error $e) {
        // Went wrong !
        $error = true;
      }
  endif;
  $courses = (!empty($courses)) ? array_reverse($courses) : $courses; //will be commented later
  $information['courses'] = $courses;

  //Notifications
  $notifications = array();
  $args = array(
      'post_type' => 'feedback',
      'author' => $user->ID,
      'orderby' => 'post_date',
      'order' => 'DESC',
      'posts_per_page' => -1,
  );
  $todos = get_posts($args);
  $sample = array();
  foreach($todos as $todo):
    $sample = array();
    $sample['type'] = get_field('type_feedback', $todo->ID);
    $manager_id = get_field('manager_feedback', $todo->ID);
    if($manager_id){
      $manager = get_user_by('ID', $manager_id);
      $image = ($manager) ? get_field('profile_img',  'user_' . $manager->ID) : '';
      $manager_display = ($manager) ? $manager->display_name : '';
    }else{
      $manager_display = 'A manager';
      $image = 0;
    }
    if(!$image)
        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
    $sample['manager'] = $manager_display;
    $sample['manager_image'] = $image;
    if($sample['type'] == "Feedback" || $sample['type'] == "Compliment" || $sample['type'] == "Gedeelde cursus")
      $sample['description'] = get_field('beschrijving_feedback', $todo->ID);
    else if($sample['type'] == "Persoonlijk ontwikkelplan")
      $sample['description'] = get_field('opmerkingen', $todo->ID);
    else if($sample['type'] == "Beoordeling Gesprek")
      $sample['description'] = get_field('algemene_beoordeling', $todo->ID);

    array_push($notifications, (Object)$sample);
  endforeach;
  $information['notifications'] = $notifications;
  //End ...

  //Certificaties
  $type_badge = 'Certificaat';
  $args = array(
    'post_type' => 'badge', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
  );
  $achievements = get_posts($args);
  $certificats = array();
  if(!empty($achievements))
    foreach($achievements as $key => $achievement):
      $sample = array();
      $type = get_field('type_badge', $achievement->ID);
      if($type != $type_badge)
        continue;

      $sample['title'] = $achievement->post_title;
      $sample['description'] = get_field('trigger_badge', $achievement->ID);
      $sample['image'] = get_stylesheet_directory_uri() . '/img/Group216.png';
      $manager = get_user_by('ID', get_field('manager_badge', $achievement->ID));
      $manager_image = get_field('profile_img',  'user_' . $achievement->post_author) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
      $sample['manager'] = $manager;
      $sample['manager_image'] = $manager_image;

      array_push($certificats, (Object)$sample);
    endforeach;
  $information['certificates'] = $certificats;
  //End ...
    
  //Communities 
  $communities = array();
  $args = array(
      'post_type' => 'community',
      'post_status' => 'publish',
      'order' => 'DESC',
      'posts_per_page' => -1
  );
  $main_communities = get_posts($args); 
  foreach ($main_communities as $value):
    $sample = array();
    if(!$value)
      continue;

    $company = get_field('company_author', $value->ID);
    $sample['company'] = $company->post_title;
    $sample['company_image'] = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
    $sample['title'] = $value->post_title;
    $sample['image']= get_field('image_community', $value->ID) ?: $sample['company_image'];

    //Courses through custom field
    $courses = get_field('course_community', $value->ID);
    $max_course = 0;
    if(!empty($courses))
      $max_course = count($courses);
    $sample['courses'] = $max_course;

    //Followers
    $max_follower = 0;
    $followers = 0;
    $followers = get_field('follower_community', $value->ID);
    if(!empty($followers))
      $max_follower = count($followers);
    $sample['followers'] = $max_follower;

    $bool = false;
    if(!empty($followers))
    foreach ($followers as $key => $val)
      if($val->ID == $user->ID){
        $bool = true;
        break;
      }

    //add
    array_push($communities, (Object)$sample);
  endforeach;
  $information['communities'] = $communities;
  //End ...

  //Topic information
  $topics_external = get_user_meta($user->ID, 'topic');
  $topics_internal = get_user_meta($user->ID, 'topic_affiliate');
  $notes = get_field('skills', 'user_' . $user->ID);
  $sample_topics = array();

  if(!empty($topics_external))
    $sample_topics = $topics_external;
  if(!empty($topics_internal))
    foreach($topics_internal as $value)
      array_push($sample_topics, $value);

  foreach($sample_topics as $value):
    $sample = array();
    if(!$value || is_wp_error(!$value))
      continue;
    $sample['ID'] = $value;
    $sample['name']= get_the_category_by_ID($value);
    $note = 0;
    if(!empty($skills_note))
      foreach($skills_note as $skill)
        if($skill['id'] == $value){
          $note = $skill['note'];
          break;
        }
    $sample['note'] = $note;
    $sample['name'] = (String)$sample['name'];
    array_push($sample_topics, (Object)$sample);
  endforeach;
  $information['skills'] = $sample_topics;
  //End ...

  return $information;
  
}

//Activity User
function activityUser($data){
  //Information 
  $ID = $data['ID'] ?: null;
  $information = activity($ID);

  $response = new WP_REST_Response($information);
  $code_status = 200;
  $response->set_status($code_status);
  return $response;
}

//Create session stripe | API
function checkoutAPI(WP_REST_Request $request){
  $required_parameters = ['postID', 'userID'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //GET POST request
  $postID = $request['postID'] ?: null;
  $userID = $request['userID'] ?: null;
  $metadata = $request['metadata'] ?: null;
  $price_id = null;

  //Check course exist
  $post = get_post($postID);
  $errors = [];
  if (!$post) {
    $errors['errors'] = 'No post found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  }

  /** Create or first price ID */
    $course_type = get_field('course_type', $post->ID);
    // create product
    $short_description = get_field('short_description', $post->ID) ?: 'Your adventure begins with Livelearn !';
    $prijs = get_field('price', $post->ID) ?: 0;
    $permalink = get_permalink($postID);
    $thumbnail = "";
    if(!$thumbnail):
        $thumbnail = get_field('url_image_xml', $post->ID);
        if(!$thumbnail)
            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
    endif;

    if($prijs):
      // create price
      $currency = 'eur';
      $data_price = [
          'currency' => $currency,
          'amount' => $prijs,
          'product_name' => $post->post_title,
          'product_description' => $short_description,
          'statement_descriptor' => 'LIVELEARN PAY !',
          'product_image' => $thumbnail,
          'product_url' => $permalink,
          'ID' => $post->ID,
      ];
      $price_id = (search_price($data_price['ID'])) ?: create_price($data_price);

      $mode = ($prijs) ? 'payment' : 'setup';
    endif;
  /** End */

  //create session 
  $session_stripe = session_stripe($price_id, 'payment', $postID, $userID, $metadata, 'hosted');
  $response = new WP_REST_Response($session_stripe);
  $response->set_status(201);
  return $response;
}

function checkoutFreeAPI(WP_REST_Request $request){
  $required_parameters = ['postID', 'userID', 'name', 'email'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Check course exist
  $postID = $request['postID'] ?: null;
  $post = get_post($postID);
  $errors = [];
  if (!$post) {
    $errors['errors'] = 'No post found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  }

  $success = 'complete';
  //GET POST request
  $userID = $request['userID'] ?: null;
  $data_order = array(
    'course_id' => $request['postID'], 
    'status' => $success, 
    'prijs' => 'false',
    'auth_id' => $userID,  
    'owner_id' => $userID, 
    'additional_name' => $request['name'],
    'additional_email' => $request['email'],
    'additional_company' => $request['company'],
    'additional_phone' => $request['phone'],
    'additional_adress' => $request['address'],
    'additional_information' => $request['additional_information'],
  );

  //create a order information
  $order_stripe = create_order($data_order);
  $success = ($order_stripe) ? "Information filled up successfully !" : "Something went wrong !";

  $information = array('message' => $success);

  // Return the response 
  $response = new WP_REST_Response($information);
  $response->set_status(200);
  return $response;
  
}

//Orders dedicated to this user (courses) 
function get_post_orders(WP_REST_Request $request){
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
  $enrolled = array();
  // $expenses = 0; 
  $enrolled = list_orders($user->ID)['posts'];

  // Return the response 
  $response = new WP_REST_Response($enrolled);
  $response->set_status(200);
  return $response;  

}

//List customers by course + author
function get_customers_by_course(WP_REST_Request $request){
  $required_parameters = ['courseID'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;
  $infos = array();

  //Check post exists
  $courseID = $request['courseID'] ?: null;
  $post = get_post($courseID);
  $errors = [];
  if (!$post):
    $errors['errors'] = 'No post found !';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;
  $infos['post']['title'] = $post->post_title;
  $infos['post']['prijs'] = get_field('price', $post->ID);
  $infos = (Object)$infos;

  //Get students data for this course 
  $ordersByAuthor = array();
  $ordersByAuthor = ordersByAuthor($post->ID, 1);
  $infos->registrations = (isset($ordersByAuthor['students'][0])) ? $ordersByAuthor['students'] : array();

  // Return the response 
  $response = new WP_REST_Response($infos);
  $response->set_status(200);
  return $response;  

}

function getAsseessmentsViaCategory($data) {
  global $wpdb;

  // Récupérer le paramètre 'category_id' depuis la requête
  $categoryID = $data['categoryID'];

  // Construire la clause WHERE en fonction de la présence de category_id
  $where_clause = '';
  if (!empty($categoryID)) 
    $where_clause = $wpdb->prepare("WHERE a.category_id = %d", $categoryID);

  // Requête pour obtenir les assessments filtrés par category_id si fourni
  $assessments = $wpdb->get_results(
    "SELECT a.id, a.title, a.author_id, a.category_id, a.description, a.level, a.duration, a.is_public, a.is_enabled, COUNT(q.id) as question_count
    FROM {$wpdb->prefix}assessments a
    LEFT JOIN {$wpdb->prefix}question q ON q.assessment_id = a.id
    $where_clause
    GROUP BY a.id"
  );

  // Vérifie s'il y a des assessments
  if (empty($assessments))
    return []; 

  // Parcourir les assessments et ajouter un champ "status" et "score" pour chaque évaluation
  foreach ($assessments as $assessment) {

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
      "name" => get_the_category_by_ID($categoryID),
      "image" => get_field('image', 'category_' . (int)$assessment->category_id) ?? ""
    ];
  }

  // Retourner les assessments avec le nombre de questions et le statut
  return $assessments;
}

//Posts for DeZZP via category
function artikelDezzp($data){

  // $CONST_FREELANCING = 'freelancing';
  $CONST_FREELANCING = 647;

  // $freelancing_category = get_categories( array(
  //   'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
  //   'orderby'    => 'name',
  //   'tag' => $CONST_FREELANCING,
  //   'hide_empty' => 0, // change to 1 to hide categores not having a single post
  // ) );

  /** Global posts **/
  $tax_query = array(
    array(
      "taxonomy" => "course_category",
      "field"    => "term_id",
      "terms"    => $CONST_FREELANCING
    )
  );
  $main_blogs = array();
  $args = array(
    'post_type' => array('post', 'course'),
    'tax_query' => $tax_query
  );
  $query_blogs = new WP_Query( $args );
  $main_blogs = isset($query_blogs->posts) ? $query_blogs->posts : [];
  $blogs = array();

  //Read the blogs via category
  foreach ($main_blogs as $blog):
    //Add the post
    $sample = artikel($blog->ID);
    $blogs[] = $sample;
  endforeach;

  //Return the response 
  $response = new WP_REST_Response(['success' => true, 'posts' => $blogs]);
  $response->set_status(200);
  return $response;  

}

//Skills | sub - skills
function skillsAll(){
  /*
  ** Categories - all  *
  */

  $categories = array();

  $cats = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'exclude' => 'Uncategorized',
    'parent'     => 0,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ));

  foreach($cats as $category){
    $cat_id = strval($category->cat_ID);
    $category = intval($cat_id);
    array_push($categories, $category);
  }

  // //Categories
  // $bangerichts = get_categories( array(
  //   'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
  //   'parent'  => $categories[1],
  //   'hide_empty' => 0, // change to 1 to hide categores not having a single post
  // ) );

  // $functies = get_categories( array(
  //   'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
  //   'parent'  => $categories[0],
  //   'hide_empty' => 0, // change to 1 to hide categores not having a single post
  // ) );

  // $skills = get_categories( array(
  //   'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
  //   'parent'  => $categories[3],
  //   'hide_empty' => 0, // change to 1 to hide categores not having a single post
  // ) );

  // $interesses = get_categories( array(
  //   'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
  //   'parent'  => $categories[2],
  //   'hide_empty' => 0, // change to 1 to hide categores not having a single post
  // ) );

  $subtopics = array();
  $topics = array();
  foreach($categories as $categ):
    //Topics
    $topicss = get_categories(
      array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categ,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
      )
    );
    $topics = array_merge($topics, $topicss);

    foreach ($topicss as $value):
      $subtopic = get_categories(
        array(
            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $value->cat_ID,
            'hide_empty' => 0,
            //  change to 1 to hide categores not having a single post
        )
      );
      $subtopics = array_merge($subtopics, $subtopic);
    endforeach;
  endforeach;

  //Return the response 
  $response = new WP_REST_Response(['success' => true, 'topics' => $subtopics]);
  $response->set_status(200);
  return $response;  

}

function addCommunity(WP_REST_Request $request){
  $required_parameters = ['userID', 'title', 'short_description', 'intern'];
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

  $communityID = wp_insert_post(
    array(
        'post_title' => $request['title'],
        'post_type' => 'community',
        // 'post_content' => $request['short_description'],
        'post_status' => 'publish',
        'post_author' => $user->ID
    )
  );

  //Check error at insertion
  if(is_wp_error($communityID)):
    $error = new WP_Error($communityID);
    return new WP_REST_Response(
        array(
        'message' => $error->get_error_message($communityID),
        'status' => 401
    ), 401);
  endif;
  $infos['community'] = ($communityID) ? get_post($communityID) : null;
  $infos['message'] = ($communityID) ? "Community add successfully !" : "";

  //Add informations 
  update_field('short_description', $request['short_description'], $communityID);
  update_field('visibility_community', $request['intern'], $communityID); //public or private
  update_field('password_community', $request['private_code'], $communityID); //fill up this field if necessary

  // Return the response 
  $response = new WP_REST_Response($infos);
  $response->set_status(200);
  return $response;  

}

function editCommunity(WP_REST_Request $request){
  $required_parameters = ['userID', 'communityID'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Check user exists
  $userID = $request['userID'] ?: null;
  $communityID = $request['communityID'] ?: null;
  $user = get_user_by('ID', $userID);
  $community = get_post($communityID);
  $errors = [];
  if (!$user || !$community):
    $errors['errors'] = 'Please fill up informations correctly : user || community';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Add informations 
  if($request['short_description'])
    update_field('short_description', $request['short_description'], $community->ID);
  if($request['private_code'])
    update_field('password_community', $request['private_code'], $community->ID); //fill up this field if necessary
  
  update_field('visibility_community', $request['intern'], $community->ID); //public or private

  // Return the response 
  $response = new WP_REST_Response("Community updated successfully !");
  $response->set_status(200);
  return $response;  
}

function deleteCourseCommunity(WP_REST_Request $request){
  $required_parameters = ['communityID', 'courseID'];
  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Check user exists
  $userID = $request['userID'] ?: null;
  $communityID = $request['communityID'] ?: null;
  $courseID = $request['courseID'] ?: null;
  $user = get_user_by('ID', $userID);
  $community = get_post($communityID);
  $errors = [];
  if (!$user || !$community || !$courseID):
    $errors['errors'] = 'Please fill up informations correctly : user || community || course';
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
  endif;

  //Delete the courses to the community
  $courses = [];
  $find = false;
  $former_courses = get_field('course_community', $community->ID);
  foreach ($former_courses as $key => $course):
    if($course)
    if($course->ID == $courseID):
      $find = true;
      continue;
    endif;

    $courses[] = $course;
  endforeach;
  update_field ('course_community', $courses, $community->ID);

  $message = ($find) ? "Course removed successfully from the community !" : "Nothing happened there !";
  // Return the response 
  $response = new WP_REST_Response($message);
  $response->set_status(200);
  return $response;  
}

//Home Page angular 
function HomepageAngular(){

  $infos = array();

  //Topics 
  $topics = array();
  $categories = array();
  $cats = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'exclude' => 'Uncategorized',
    'parent'     => 0,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );

  foreach($cats as $category):
    $cat_id = strval($category->cat_ID);
    $category = intval($cat_id);
    array_push($categories, $category);
  endforeach;

  //Categories
  $topics['training'] = get_categories( array(
    'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent' => $categories[2],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );

  $topics['grow'] = get_categories( array(
    'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent' => $categories[1],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );

  $topics['relevant_skills'] = get_categories( array(
    'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent' => $categories[0],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );

  $topics['interests'] = get_categories( array(
    'taxonomy'  => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent' => $categories[3],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
  ) );
  $infos['topics'] = $topics;

  //What not to miss 
  $courses = array();
  $posts = get_posts(array(
    'post_type' => array('course', 'post'), 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
  ));

  $article = 0;
  $video = 0;
  $podcast = 0;

  foreach ($posts as $post):
    if(!$post)
      continue;

    $courses['all'][] = artikel($post->ID);
    $coursetype = get_field('course_type', $post->ID);
    switch ($coursetype) {
      case 'Artikel':
        $courses['Artikel'][] = artikel($post->ID);
        $article++;
        break;

      case 'Video':
        $courses['Video'][] = artikel($post->ID);
        $video++;
        break;

      case 'Podcast':
        $courses['Podcast'][] = artikel($post->ID);
        $podcast++;
        break;
    }

    if($article >= 6 && $video >= 6 && $podcast >=6)
      break;

    $infos['what_not_miss'] = $courses;

  endforeach;

  // Return the response 
  $response = new WP_REST_Response($infos);
  $response->set_status(200);
  return $response;  
}

//Posts for DeZZP via category
function artikelByCategory($data){

  $CONST_FREELANCING = $data['category'];
  $args = array(
    'post_type' => array('post','course'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
  );
  $main_blogs = get_posts($args);
  $blogs = array();

  //Read the blogs via category
  foreach ($main_blogs as $key => $blog):
    //Get topics | genuine, xml
    $postags = get_the_tags($blog->ID);
    $default_category = get_field('categories', $blog->ID);
    $xml_category = get_field('category_xml', $blog->ID);
    $find = false;

    //Topic match "freelancing" ?
    $main_default = array();
    if(!empty($default_category)):
      $main_default = array_column($default_category, 'value');
      if(in_array($CONST_FREELANCING, $main_default))
        $find = true;
    endif;

    $main_xml = array();
    if(!$find)
    if(!empty($xml_category)):
      $main_xml = array_column($xml_category, 'value');
      if(in_array($CONST_FREELANCING, $main_xml))
        $find = true;
    endif;

    if(!$find)
    if($postags)
    foreach($postags as $tag)
      if($tag->ID == $CONST_FREELANCING):
        $find = true;
        break;
      endif;

    if(!$find)
      continue;

    //Add the post
    $sample = artikel($blog->ID);
    $blogs[] = $sample;
  endforeach;

  //Read the assessments via category 
  $assessments = getAsseessmentsViaCategory(['categoryID' => $CONST_FREELANCING]);

  //Return the response 
  $response = new WP_REST_Response(['success' => true, 'posts' => $blogs, 'assessments' => $assessments]);
  $response->set_status(200);
  return $response;  
}

/** Challenge */

//List challenges
function challenges(){
  $args = array(
      'post_type' => 'challenge',
      'post_status' => 'publish',
      'posts_per_page' => -1,
  );
  $challenge_posts = get_posts($args);
  $challenges = array();

  // Boucle pour afficher les résultats
  foreach ($challenge_posts as $post):
    $sample = array();
    // Recuperer le contenu de chaque élément
    $challenges[] = challenge($post->ID);
  endforeach;

  $response = new WP_REST_Response($challenges);
  $response->set_status(200);
  return $response;

}

function challengeDetail(WP_REST_Request $request){
  $param_post_id = $request['slug'] ?? 0;
  $required_parameters = ['slug'];

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  $userID = isset($request['userID']) ? $request['userID'] : null;
  $records = isset($request['records']) ? $request['records'] : null;
  $post = get_page_by_path($param_post_id, OBJECT, 'challenge');
  $sample = challenge($post->ID);
  if($userID)
  //Get steps information about this user
  $sample = challengeSteps($sample, $userID);

  //Get information about participants
  $participants = array();
  if(!empty($sample)):
    $data = challengeAdditionnal($sample);
    foreach($data as $datum):
      if($datum->user_id)
        $participants[] = get_user_by('ID', $datum->user_id);
      if($datum->user_id == $userID)
        $sample->steps[] = 3;
    endforeach;
    $sample->records = $data;
    $sample->participants = $participants;
    $sample->total_participants = (isset($participants[0])) ? count($participants) : 0;
  endif;

  $response = new WP_REST_Response($sample);
  $response->set_status(200);
  return $response;
}

function startChallenge(WP_REST_Request $request){
  global $wpdb;

  $required_parameters = ['challenge_id', 'user_id', 'titel', 'short_description', 'motivation', 'long_description', 'imageURLs', 'pdfURL'];

  // Check required parameters 
  $errors = validated($required_parameters, $request);
  if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  $table_start_challenge = $wpdb->prefix . 'start_challenge';

  //Check history participation
  $sql = $wpdb->prepare(
    "SELECT * FROM $table WHERE challenge_id = %s AND user_id = %s",
    $request['challenge_id'], $request['user_id']
  );
  $dataParticipation = $wpdb->get_results($sql);

  $errors = [];
  if($dataParticipation):
    //Check if there are no errors
    $errors['errors'] = 'You already participated to this challenge !';
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  $data = [
    'challenge_id' => $request['challenge_id'],
    'user_id' => $request['user_id'],
    'titel' => $request['titel'],
    'short_description' => $request['short_description'],
    'motivation' => $request['motivation'],
    'long_description' => $request['long_description'],
    'imageURLs' => $request['imageURLs'],
    'pdfURL' => $request['pdfURL']
  ];
  $wpdb->insert($table_start_challenge, $data);
  $start_id = $wpdb->insert_id; 
  
  $errors = [];
  if(!$start_id):
    //Check if there are no errors
    $errors['errors'] = 'Something wrong on insertion !';
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  $data['ID'] = $start_id;
  $response = new WP_REST_Response($data);
  $response->set_status(201);
  return $response;
}
/** Challenge */

