<?php

/* * Liggeey * */

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

  $user = get_user_by('ID', $user_id);

  //Information about the user
  $response = new WP_REST_Response($user);
  $response->set_status(200);
  return $response;

}

/* * End Liggeey * */