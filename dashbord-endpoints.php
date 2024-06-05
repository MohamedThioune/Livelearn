<?php
function expertsToFollow()
{
    $experts = get_users(array('role__in' => array('expert', 'administrator')));
    $all_experts = array();
    foreach ($experts as $expert) {
        $expert_data = array();
        $roles = $expert->roles;
        $expert_data['id'] = $expert->ID;
        $expert_data['email'] = $expert->user_email;
        $expert_data['name'] = $expert->display_name;
        $expert_data['image'] = get_field('profile_img',  'user_' . $expert->ID) ?: get_field('profile_img_api',  'user_' . $expert->ID);
        // $expert_data['image'] = get_avatar_url($expert->ID);
        $all_experts[] = $expert_data;
    }

    $response = new WP_REST_Response($all_experts);
    $response->set_status(200);
    return $response;
}
/**
 * @return WP_REST_Response
 * @description : Upcoming Schedule for the user
 * @url : localhost:8888/livelearn/wp-json/custom/v1/upcoming/schedule?id=5
 */
function upcoming_schedule_for_the_user()
{
    $user_id = 0;
    if (isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
    }
    $args = array(
        'post_type' => array('course', 'post'),
        'posts_per_page' => -1,
        'order' => 'DESC'
    );
    $schedules = get_posts($args);
    $all_schedules = array();
    foreach ($schedules as $schedule) {
        global $wpdb;
        $data_locaties_xml = get_field('data_locaties_xml', $schedule->ID);
        if (!$data_locaties_xml)
            continue;
        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        $sql = $wpdb->prepare( "SELECT user_id FROM $table_tracker_views WHERE data_id =$schedule->ID");
        $user_follow_this_course = $wpdb->get_results( $sql );
        if(!$user_follow_this_course)
            continue;
        if(intval($user_follow_this_course[0]->user_id)!=$user_id)
            continue;

        $image = get_field('preview', $schedule->ID)['url'];
        if(!$image){
            $image = get_the_post_thumbnail_url($schedule->ID);
            if(!$image)
                $image = get_field('url_image_xml', $schedule->ID);
            if(!$image)
                $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($schedule->courseType) . '.jpg';
        }
        $schedule_data = array();
        $schedule_data['id'] = $schedule->ID;
        $schedule_data['title'] = $schedule->post_title;
        $schedule_data['links'] = $schedule->guid;
        $schedule_data['course_type'] = get_field('course_type', $schedule->ID);
        //$schedule_data['data_locaties'] = get_field('data_locaties', $schedule->ID);
        $schedule_data['pathImage'] = $image;
        $schedule_data['for_who'] = get_field('for_who', $schedule->ID) ? (get_field('for_who', $schedule->ID)) : "" ;
        $schedule_data['price'] = get_field('price',$schedule->ID) ?? "Gratis";
        $schedule_data['data_locaties_xml'] = $data_locaties_xml;
        $all_schedules[] = $schedule_data;

    }
    if (empty($all_schedules)) {
        $response = new WP_REST_Response(array());
        $response->set_status(204);
        return $response;
    }

    $response = new WP_REST_Response($all_schedules);
    $response->set_status(200);
    return $response;
}
function saveTeacher(WP_REST_Request $request){
    $required_parameters = ['company','quantity','email','password'];
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    $userdata = array(
        'user_pass' => $request['password'],
        'user_login' => $request['email'],
        'user_email' => $request['email'],
        'user_url' => $request['website'] ? : 'http://livelearn.nl/',
        'display_name' => $request['company'],
        'first_name' => $request['company'],
        'last_name' => $request['company'],
        'role' => 'Hr',
    );
    $user_id = wp_insert_user($userdata);
    if (is_wp_error($user_id)) {
        $response = new WP_REST_Response(is_wp_error($user_id));
        $response->set_status(401);
        return $response;
    }
    if ($request['phone'])
        update_field('telnr', $request['phone'], 'user_' . $user_id);

    if($request['about'])
        update_field('biographical_info',$request['about'],'user_' . $user_id);

    $company_id = wp_insert_post(
        array(
            'post_title' => $request['company'],
            'post_type' => 'company',
            'post_status' => 'publish',
            //'post_status' => 'pending',
        ));
    $company = get_post($company_id);
    update_field('company', $company, 'user_' . $user_id);

    $response = new WP_REST_Response(array(
        'message'=>'user saved succssed',
        'quantity'=>intval($request['quantity']),
        'id_user'=>$user_id
    ));
    $response->set_status(201);
    return $response;
}
