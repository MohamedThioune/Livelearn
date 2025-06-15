<?

//[POST]Register the company member
function register_member_company(WP_REST_Request $request){
  $required_parameters = ['first_name', 'last_name', 'email', 'bedrijf', 'password', 'password_confirmation'];

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

  //Search the company
  $company = get_page_by_path( sanitize_title($bedrijf), OBJECT, 'company');
  $errors = [];
  if(!$company):
    $errors['errors'] = 'The company does not found !';
    $errors = (Object)$errors;
    $response = new WP_REST_Response($errors);
    $response->set_status(400);
    return $response;
  endif;

  //Affect the company to the user
  update_field('company', $company, 'user_' . $user_id);

  //Get user created information and set role student 
  $user = get_user_by('ID', $user_id);
  $user->add_role('student');

  // Sending email notification
  $first_name = $user->first_name ?: $user->display_name;
  $email = $user->user_email;
  $path_mail = '/templates/mail-notification-invitation.php';
  require(__DIR__ . $path_mail);
  $subject = 'Je hebt een nieuwe volger !';
  $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );
  wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' ));

  //Send response
  $response = new WP_REST_Response([
        'success' => true,
        'message' => 'Member company registered successfully.',
        'user' => $user,
  ]);
  $response->set_status(200);
  return $response;
}

//[POST]Login the company member
function login_member_company(WP_REST_Request $request) {
    $required_parameters = ['username', 'password', 'bedrijf'];

    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;

    $creds = array(
        'user_login'    => $request['username'],
        'user_password' => $request['password'],
        'remember'      => true
    );
    $user = wp_signon($creds, false);
    if (is_wp_error($user)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Invalid username or password'
        ], 401);
    }

    //Search the company
    $company = get_page_by_path( sanitize_title($bedrijf), OBJECT, 'company');
    $errors = [];
    if(!$company):
        $errors['errors'] = 'The company does not found !';
        $errors = (Object)$errors;
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;
    //Affect the company to the user
    update_field('company', $company, 'user_' . $user->ID);

    // Add role student if not exists
    if ( ! in_array('student', $user->roles) ) 
        $user->add_role('student');

    // Generate a token if you're using JWT (optional)
    return new WP_REST_Response([
        'success' => true,
        'message' => 'Login successful.',
        'user' => $user,
    ]);
}

//[POST]Show a achievement of the company member
function show_achievement(WP_REST_Request $request) {
    $required_parameters = ['achievement'];

    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;
    $achievement_id = $request['achievement'] ?? false;

    $achievement = get_post($achievement_id);
    // $achievement = get_page_by_path( sanitize_title($achievement_id), OBJECT, 'badge');

    if (!$achievement) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Achievement not found.'
        ], 400);
    }

    //Get details of the achievement
    $type = get_field('type_badge', $achievement->ID);
    $achievement->manager = get_user_by('ID', get_field('manager_badge', $achievement->ID));
    $achievement->manager_image = get_field('profile_img',  'user_' . $achievement->manager->ID);
    if(!$image)
        $image = get_stylesheet_directory_uri() . '/img/Group216.png';

    switch ($type) {
        case 'Genuine':
            $achievement->image = get_field('image_badge', $badge->ID) ?: get_stylesheet_directory_uri() . '/img/badge-basic.png';
            $achievement->trigger = get_field('trigger_badge', $badge->ID);
            $achievement->level = get_field('level_badge', $badge->ID) ?: '<b>Company</b>';
            $achievement->description = get_field('trigger_badge', $achievement->ID);
            break;
        case 'Certificaat':
            $achievement->image = get_field('image_badge', $badge->ID) ?: get_stylesheet_directory_uri() . '/img/badge-assessment.png';
            $achievement->certificat_nummer = get_field('certificaatnummer_badge', $badge->ID) ?: 'None';
            $achievement->url = get_field('url_aanbieder_badge', $badge->ID) ?: 'None';
            $achievement->postedBy = get_field('uitgegeven_door_badge', $badge->ID) ?: 'None';
            $achievement->description = get_field('trigger_badge', $achievement->ID);
            break;

        case 'Prestatie':
            $achievement->description = get_field('trigger_badge', $achievement->ID);
            break;
        case 'Diploma':
            $achievement->description = get_field('trigger_badge', $achievement->ID);
            break;
        default:
            $achievement->description = get_field('trigger_badge', $achievement->ID);
            break;
    }

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Achievement retrieved successfully.',
        'achievement' => $achievement
    ]);
}

//
?>