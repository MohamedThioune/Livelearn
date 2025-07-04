<?php

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
      'role' => 'student'
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
  $company = get_page_by_path(sanitize_title($bedrijf), OBJECT, 'company');
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
  $user = candidate($user_id);

  // Sending email notification
  // $first_name = $user->first_name ?: $user->display_name;
  // $email = $user->user_email;
  // $path_mail = '/templates/mail-notification-invitation.php';
  // require(__DIR__ . $path_mail);
  // $subject = 'Je hebt een nieuwe volger !';
  // $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );
  // wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' ));

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
    if ( !in_array('student', $user->roles) ) 
        $user->add_role('student');

    // Get user created information
    $user = candidate($user->ID);

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

//[POST]Add a project 
// function add_project(WP_REST_Request $request){
//     $required_parameters = ['title', 'description', 'technologies', 'bedrijf'];

//     //Check required parameters register
//     $errors = validated($required_parameters, $request);
//     if($errors):
//         $response = new WP_REST_Response($errors);
//         $response->set_status(400);
//         return $response;
//     endif;

//     //Get value fields
//     $title = $request['title'];
//     $description = $request['description'];
//     $image = $request['image'];
//     $technologies = $request['technologies'];
//     $company_id = $request['bedrijf'];

//     //Get company
//     $company = get_page_by_path( sanitize_title($company_id), OBJECT, 'company');
//     if(!$company)
//         return new WP_REST_Response([
//             'success' => false,
//             'message' => 'Company not found for project.'
//         ], 401);

//     //Create post object
//     $post_data = array(
//         'post_title'   => $title,
//         'post_content' => $description,
//         'post_status'  => 'publish',
//         'post_type'    => 'project',
//     );

//     //Insert the post into the database
//     $post_id = wp_insert_post($post_data);

//     //Check for errors
//     if (is_wp_error($post_id)) 
//         return new WP_REST_Response([
//             'success' => false,
//             'message' => 'Failed to create project.'
//         ], 500);

//     //Set post meta
//     update_post_meta($post_id, 'description_project', $description);
//     update_post_meta($post_id, 'image_project', $image);
//     update_post_meta($post_id, 'technologies_project', $technologies);
//     update_post_meta($post_id, 'project_company', $company);

//     $request['ID'] = $post_id;

//     $sampleProject = get_post($post_id);
//     $project = (Object)[
//         'ID' => $sampleProject->ID,
//         'title' => $sampleProject->post_title,
//         'content' => $sampleProject->post_content,
//         'image' => get_post_meta($sampleProject->ID, 'image_project', true),
//         'technologies' => get_post_meta($sampleProject->ID, 'technologies_project', true),
//         'company' => get_post_meta($sampleProject->ID, 'project_company', true),
//     ];

//     return new WP_REST_Response([
//         'success' => true,
//         'message' => 'Project created successfully.',
//         'project' => $project
//     ]);
// }

//[POST]View a project
// function view_project(WP_REST_Request $request) {
//     $project_id = $request['project_id'] ?? false;

//     if (!$project_id) {
//         return new WP_REST_Response([
//             'success' => false,
//             'message' => 'Project ID is required.'
//         ], 400);
//     }

//     $sampleProject = get_post($project_id);

//     if (!$sampleProject || $sampleProject->post_type !== 'project') {
//         return new WP_REST_Response([
//             'success' => false,
//             'message' => 'Project not found.'
//         ], 404);
//     }

//     $project = (Object)[
//         'ID' => $sampleProject->ID,
//         'title' => $sampleProject->post_title,
//         'content' => $sampleProject->post_content,
//         'image' => get_post_meta($sampleProject->ID, 'image_project', true),
//         'technologies' => get_post_meta($sampleProject->ID, 'technologies_project', true),
//         'project_company' => get_post_meta($sampleProject->ID, 'company', true),
//     ];

//     return new WP_REST_Response([
//         'success' => true,
//         'message' => 'Project retrieved successfully.',
//         'project' => $project
//     ]);
// }

//[POST]List projects for a company
// function list_projects(WP_REST_Request $request) {
//     $required_parameters = ['bedrijf'];

//     //Check required parameters register
//     $errors = validated($required_parameters, $request);
//     if($errors):
//         $response = new WP_REST_Response($errors);
//         $response->set_status(400);
//         return $response;
//     endif;
//     $company_id = $request['bedrijf'];

//     //Get company
//     $company = get_page_by_path( sanitize_title($company_id), OBJECT, 'company');

//     if (!$company) {
//         return new WP_REST_Response([
//             'success' => false,
//             'message' => 'Company not found.'
//         ], 404);
//     }

//     $args = array(
//         'post_type' => 'project',
//         'post_status' => 'publish',
//         'posts_per_page' => -1,
//         'orderby' => $company->ID,
//         'order' => 'DESC',
//         'meta_key' => 'project_company',
//         'meta_value' => $company->ID
//     ); 

//     $projects = get_posts($args);

//     if (empty($projects)) {
//         return new WP_REST_Response([
//             'success' => true,
//             'message' => 'No projects found for this company.',
//             'projects' => []
//         ], 200);
//     }

//     $project_list = [];
//     foreach ($projects as $project) {
//         $company = NULL;
//         $company_id = get_post_meta($project->ID, 'project_company', true) ?: false;
//         $company = company($company_id, 1) ?: false;
//         $project_list[] = ( Object)[
//             'ID' => $project->ID,
//             'title' => $project->post_title,
//             'content' => $project->post_content,
//             'image' => get_post_meta($project->ID, 'image_project', true),
//             'technologies' => get_post_meta($project->ID, 'technologies_project', true),
//             'company' => $company,
//         ];
//     }

//     return new WP_REST_Response([
//         'success' => true,
//         'message' => 'Projects retrieved successfully.',
//         'projects' => $project_list
//     ]);
// }

//[POST]Update academy infos for a company
function update_academy_infos(WP_REST_Request $request) {
    $required_parameters = ['bedrijf'];
    $academy_fields = ['logo_academy', 'title_academy', 'main_color_academy', 'description_academy', 'call_to_action_academy', 'features_academy', 'popular_categories_academy', 'popular_courses_academy','courses_academy', 'service_academy', 'services_academy'];
    $academy = array();
    $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';

    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;

    //Get company
    $company = get_page_by_path( sanitize_title($request['bedrijf']), OBJECT, 'company');
    $popular_courses = NULL;
    $courses = NULL;
    $services = NULL;
    if (!$company) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Company not found.'
        ], 404);
    }

    // Parameters REST request
    $updated_data = $request->get_params();

    //Case courses
    if (isset($updated_data['courses_id'])) {
        // Former courses 
        $former_courses = get_field('courses_academy', $company->ID) ?: [];
        // Sanitize and validate course IDs
        $course_ids = is_array($updated_data['courses_id']) ? array_filter(array_map('intval', (array) $updated_data['courses_id'])) : NULL;
        if (!empty($course_ids)) 
            $courses = get_posts([
                'post_type' => array('course', 'post', 'leerpad'),
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'include' => $course_ids
            ]);

        $updated_data['courses_academy'] = array_merge($former_courses, $courses);
    }

    // Update Fields
    foreach ($updated_data as $field_name => $field_value):
        if($field_value)
        if($field_value != '' && $field_value != ' ')
            update_field($field_name, $field_value, $company->ID);
    endforeach;

    //Academy view 
    $popular_courses = [];
    $courses = [];
    foreach($academy_fields as $field_name):
        // If the field is popular_courses_academy, we need to process it differently
        if($field_name == 'popular_courses_academy'):
            $populars = get_field($field_name, $company->ID);
            foreach($populars as $key => $popular):
                $popular_course['course_popular'] = artikel($popular['course_popular']->ID)?: false;
                $popular_course['category_popular'] = $popular['category_popular'] ?: false;
                array_push($popular_courses, $popular_course);
            endforeach;
            $academy[$field_name] = $popular_courses;

        //If the field is courses_academy, we need to process it differently also
        elseif($field_name == 'courses_academy'):
            $sample_courses = get_field($field_name, $company->ID);
            foreach($sample_courses as $key => $course)
                $courses[] = artikel($course->ID) ?: false;
            $academy[$field_name] = $courses;

        //For other fields, we can just get the value
        else:
            $academy[$field_name] = get_field($field_name, $company->ID);
        endif;
    endforeach;

    // Prepare response data
    $company_infos = [
        'ID' => $company->ID,
        'name' => $company->post_title,
        'logo' => get_field('company_logo', $company->ID) ?: $placeholder,
        'country' => get_field('company_country', $company->ID),
        'academy' => (Object)$academy
    ];

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Company information updated successfully.',
        'company' => $company_infos
    ]);
}

//[POST]Update popular courses for a company
function update_popular_courses(WP_REST_Request $request) {
    $academy = array();
    $academy_fields = ['logo_academy', 'title_academy', 'main_color_academy', 'description_academy', 'call_to_action_academy', 'features_academy', 'popular_categories_academy', 'popular_courses_academy','courses_academy', 'service_academy', 'services_academy'];
    $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';

    $required_parameters = ['bedrijf', 'populars'];
    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;

    //Get company
    $company = get_page_by_path( sanitize_title($request['bedrijf']), OBJECT, 'company');
    if (!$company) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Company not found.'
        ], 404);
    }

    // Parameters REST request
    $popular_courses = [];
    $popular_course = [];
    $former_popular_courses = get_field('popular_courses_academy', $company->ID) ?: [];
    $popular_categories = get_field('popular_categories_academy', $company->ID);
    if (is_array($request['populars'])) {
        foreach ($request['populars'] as $popular)
            if($popular['course_popular_id'] && in_array($popular['category_popular'], $popular_categories)):
                $popular_course['course_popular'] = get_post($popular['course_popular_id']) ?: false;
                $popular_course['category_popular'] = $popular['category_popular'] ?: false;
                array_push($popular_courses, $popular_course);
            endif;
        $popular_courses = (!empty($former_popular_courses)) ? array_merge($former_popular_courses, $popular_courses) : $popular_courses;
    }
    
    //Update popular courses
    update_field('popular_courses_academy', $popular_courses, $company->ID);

    // Academy
    $popular_courses = [];
    $courses = [];
    foreach($academy_fields as $field_name):
        // If the field is popular_courses_academy, we need to process it differently
        if($field_name == 'popular_courses_academy'):
            $populars = get_field($field_name, $company->ID);
            foreach($populars as $key => $popular):
                $popular_course['course_popular'] = artikel($popular['course_popular']->ID)?: false;
                $popular_course['category_popular'] = $popular['category_popular'] ?: false;
                array_push($popular_courses, $popular_course);
            endforeach;
            $academy[$field_name] = $popular_courses;

        //If the field is courses_academy, we need to process it differently also
        elseif($field_name == 'courses_academy'):
            $sample_courses = get_field($field_name, $company->ID);
            foreach($sample_courses as $key => $course)
                $courses[] = artikel($course->ID) ?: false;
            $academy[$field_name] = $courses;

        //For other fields, we can just get the value
        else:
            $academy[$field_name] = get_field($field_name, $company->ID);
        endif;
    endforeach;

    // Prepare response data
    $company_infos = [
        'ID' => $company->ID,
        'name' => $company->post_title,
        'logo' => get_field('company_logo', $company->ID) ?: $placeholder,
        'country' => get_field('company_country', $company->ID),
        'academy' => (Object)$academy
    ];

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Company information updated successfully.',
        'company' => $company_infos
    ]);
}

//[POST]Delete popular courses for a company
function delete_popular_regular_courses(WP_REST_Request $request) {
    $required_parameters = ['bedrijf'];
    $academy_fields = ['logo_academy', 'title_academy', 'main_color_academy', 'description_academy', 'call_to_action_academy', 'features_academy', 'popular_categories_academy', 'popular_courses_academy','courses_academy', 'service_academy', 'services_academy'];
    $academy = array();
    $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';

    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;

    //Get company
    $company = get_page_by_path( sanitize_title($request['bedrijf']), OBJECT, 'company');
    if (!$company) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Company not found.'
        ], 404);
    }

    //Delete courses
    $courses = [];
    $actual_courses = get_field('courses_academy', $company->ID) ?: [];
    $coursesID = (isset($request['courses_id'])) ? $request['courses_id'] : false;
    if(is_array($coursesID))
    if(!empty($coursesID)):
        foreach ($actual_courses as $value):
            if(in_array($value->ID, $coursesID))
                continue;
            $courses[] = $value;
        endforeach;
        update_field('courses_academy', $courses, $company->ID);
    endif;

    //Delete popular courses
    $populars = [];
    $actual_popular_courses = get_field('popular_courses_academy', $company->ID) ?: [];
    $popularCoursesID = (isset($request['popular_courses_id'])) ? $request['popular_courses_id'] : false;
    if(is_array($popularCoursesID))
    if(!empty($popularCoursesID)):
        foreach ($actual_popular_courses as $value):
            if(in_array($value['course_popular']->ID, $popularCoursesID))
                continue;
            array_push($populars, $value);
        endforeach;
        update_field('popular_courses_academy', $populars, $company->ID);
    endif;

    //Academy view
    $popular_courses = [];
    $courses = [];
    foreach($academy_fields as $field_name):
        // If the field is popular_courses_academy, we need to process it differently
        if($field_name == 'popular_courses_academy'):
            $populars = get_field($field_name, $company->ID);
            foreach($populars as $key => $popular):
                $popular_course['course_popular'] = artikel($popular['course_popular']->ID)?: false;
                $popular_course['category_popular'] = $popular['category_popular'] ?: false;
                array_push($popular_courses, $popular_course);
            endforeach;
            $academy[$field_name] = $popular_courses;

        //If the field is courses_academy, we need to process it differently also
        elseif($field_name == 'courses_academy'):
            $sample_courses = get_field($field_name, $company->ID);
            foreach($sample_courses as $key => $course)
                $courses[] = artikel($course->ID) ?: false;
            $academy[$field_name] = $courses;

        //For other fields, we can just get the value
        else:
            $academy[$field_name] = get_field($field_name, $company->ID);
        endif;
    endforeach;
    $company_infos = [
        'ID' => $company->ID,
        'name' => $company->post_title,
        'logo' => get_field('company_logo', $company->ID) ?: $placeholder,
        'country' => get_field('company_country', $company->ID),
        'academy' => (Object)$academy
    ];

    //Return information
    return new WP_REST_Response([
        'success' => true,
        'message' => 'Deleted successfully.',
        'company' => $company_infos
    ]);
}

//[POST]View academy infos for a company
function view_academy_infos(WP_REST_Request $request) {
    $required_parameters = ['bedrijf'];
    $academy_fields = ['logo_academy', 'title_academy', 'main_color_academy', 'description_academy', 'call_to_action_academy', 'features_academy', 'popular_categories_academy', 'popular_courses_academy','courses_academy', 'service_academy', 'services_academy'];
    $academy = array();
    $placeholder = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';

    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;

    //Get company
    $company = get_page_by_path( sanitize_title($request['bedrijf']), OBJECT, 'company');
    if (!$company) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Company not found.'
        ], 404);
    }

    //Academy
    $popular_courses = [];
    $courses = [];
    foreach($academy_fields as $field_name):
        // If the field is popular_courses_academy, we need to process it differently
        if($field_name == 'popular_courses_academy'):
            $populars = get_field($field_name, $company->ID);
            foreach($populars as $key => $popular):
                $popular_course['course_popular'] = artikel($popular['course_popular']->ID)?: false;
                $popular_course['category_popular'] = $popular['category_popular'] ?: false;
                array_push($popular_courses, $popular_course);
            endforeach;
            $academy[$field_name] = $popular_courses;

        //If the field is courses_academy, we need to process it differently also
        elseif($field_name == 'courses_academy'):
            $sample_courses = get_field($field_name, $company->ID);
            foreach($sample_courses as $key => $course)
                $courses[] = artikel($course->ID) ?: false;
            $academy[$field_name] = $courses;
            
        //For other fields, we can just get the value
        else:
            $academy[$field_name] = get_field($field_name, $company->ID);
        endif;
    endforeach;

    // Prepare response data
    $company_infos = [
        'ID' => $company->ID,
        'name' => $company->post_title,
        'logo' => get_field('company_logo', $company->ID) ?: $placeholder,
        'country' => get_field('company_country', $company->ID),
        'academy' => (Object)$academy
    ];

    return new WP_REST_Response([
        'success' => true,
        'message' => 'Company information retrieved successfully.',
        'academy_info' => $company_infos
    ]);
}      


function view_courses_company(WP_REST_Request $request){
    $employees = array();
    $courses = array();
    $required_parameters = ['bedrijf'];

    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(400);
        return $response;
    endif;

    //Get company
    $company = get_page_by_path( sanitize_title($request['bedrijf']), OBJECT, 'company');
    if (!$company) {
        return new WP_REST_Response([
            'success' => false,
            'message' => 'Company not found.'
        ], 404);
    }

    $users = get_users();
    foreach($users as $user) {
        $company_user = get_field('company',  'user_' . $user->ID);

        if(!empty($company_user))
            if($company_user[0]->ID == $company->ID)
                $employees[] = $user->ID;
    }

    $args = array(
        'post_type' => array('course','post', 'leerpad'),
        'post_status' => 'publish',
        'author__in' => $employees,
        'order' => 'DESC',
        'posts_per_page' => -1,
    );
    $sample_courses = get_posts($args);
    foreach ($sample_courses as $course):
        $courses[] = artikel($course->ID) ?: false;
    endforeach;

    return new WP_REST_Response( array(
        'count' => !empty($courses) ? count($courses) : 0,
        'courses' => $courses
    ), 200);
}
?>