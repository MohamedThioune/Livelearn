<?php
function expertsToFollow()
{
    $experts = get_users(
        array(
                'role__in' => array('expert','author','teacher',
                'posts_per_page' => -1,
                )
        ));
    $all_experts = array();
    foreach ($experts as $expert) {
        $expert_data = array();
        $roles = $expert->roles;
        $expert_data['id'] = $expert->ID;
        $expert_data['email'] = $expert->user_email;
        $expert_data['name'] = $expert->display_name;
        $expert_data['image'] = get_field('profile_img',  'user_' . $expert->ID) ?: get_field('profile_img_api',  'user_' . $expert->ID);
        $expert_data['imageExpert'] = get_avatar_url($expert->ID);
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
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'meta_key'   => 'data_locaties_xml',
    );
    $schedules = get_posts($args);
    $all_schedules = array();

    foreach ($schedules as $schedule) {
        global $wpdb;
        $data_locaties_xml = get_field('data_locaties_xml', $schedule->ID);
        if (!$data_locaties_xml)
            continue;
        $courseTime = array();
        foreach ($data_locaties_xml as $dataxml) {
            if ($dataxml) {
                $datetime = explode(' ', $dataxml['value']);
                $date = explode(' ', $datetime[0])[0];
                $time = explode('-', $datetime[1])[0];
                $courseTime['date'][] = $date;
                $courseTime['time'][] = $time;
            }
        }
        if (!$courseTime)
            continue;

        /** if 500 error comment this part of code with database*/

        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        //$sql = $wpdb->prepare( "SELECT user_id FROM $table_tracker_views WHERE data_id =$schedule->ID");
        //$user_follow_this_course = $wpdb->get_results( $sql );
        //if(!$user_follow_this_course)
       //     continue;
        //if(intval($user_follow_this_course[0]->user_id)!=$user_id)
        //    continue;

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
        $schedule_data['data_locaties'] = get_field('data_locaties', $schedule->ID);
        $schedule_data['pathImage'] = $image;
        $schedule_data['for_who'] = get_field('for_who', $schedule->ID) ? (get_field('for_who', $schedule->ID)) : "" ;
        $schedule_data['price'] = get_field('price',$schedule->ID)!="0" ? : "Gratis";
        $schedule_data['data_locaties_xml'] = $data_locaties_xml;
        $schedule_data['courseTime'] = $courseTime;
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

/**
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 * @url : localhost:8888/livelearn/wp-json/custom/v1/teacher/save?id=3
 */
function saveManager(WP_REST_Request $request){
    $user_id = 0;
    if (isset($_GET['id'])) {
        $user_id = intval($_GET['id']);
    } else {
        $response = new WP_REST_Response(array(
            'message' => 'User id is required in the request'
        ));
        $response->set_status(401);
        return $response;
    }
    $required_parameters = ['company','quantity','email','industry',];
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    //update role of  user
    $user = get_userdata($user_id);
    $new_role = 'hr';
    if (!in_array($new_role, $user->roles)) {
        $user->add_role($new_role);
    }
    // creating new company
    $company_id = wp_insert_post(
        array(
            'post_title' => $request['company'],
            'post_type' => 'company',
            'post_status' => 'publish',
            'post_author'=>$user_id
            //'post_status' => 'pending',
        ));
    $company = get_post($company_id);
    update_field('company', $company, 'user_' . $user_id);

    update_field('company_sector',$request['industry'], $company_id);
    update_field('company_address',$request['address'], $company_id);
    update_field('company_place',$request['place'], $company_id);
    update_field('company_country',$request['country'], $company_id);
    update_field('company_bio',$request['about'], $company_id);
    update_field('company_website',$request['website'], $company_id);
    update_field('company_size',$request['quantity'], $company_id);
    update_field('company_email',$request['email'], $company_id);
    update_field('company_phone',$request['phone'], $company_id);
    $response = new WP_REST_Response(
        array(
        'message'=>'company created',
        'quantity'=>intval($request['quantity']),
        'id_user'=>$user_id,
        'company'=>$company
    )
    );
    $response->set_status(201);
    return $response;
}

function get_notifications()
{
    $id_user_connected = 5;
    $args = array(
        'post_type' => array('feedback', 'mandatory', 'badge'),
        'author' => $id_user_connected, // id user connected
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );
    $notifications = get_posts($args);
    $todos = array();
    $read_feedbacks = array();
    $read_todos = array();
    $read_badges = array();
    if(!empty($notifications))
        foreach($notifications as $todo){

            $read = get_field('read_feedback', $todo->ID);
            if($read)
                continue;

            array_push($todos,$todo);

            //Readed by post_type check
            switch ($todo->post_type) {
                case 'feedback':
                    array_push($read_feedbacks, $todo);
                    break;
                case 'mandatory':
                    array_push($read_todos, $todo);
                    break;
                case 'badge':
                    array_push($read_badges, $todo);
                    break;
            }
        }
    $response = new WP_REST_Response(
        array(
        'alertNotification'=>count($notifications),
        'countViewAll'=>$notifications,
        'alertToDo'=>count($read_todos),
        'toDo'=>$read_todos,
        'alertBadge'=>count($read_badges),
        'badge'=>$read_badges,
        'alertFeedback'=>count($read_feedbacks),
        'feedback'=>$read_feedbacks,
    ));
    $response->set_status(200);
    return $response;
}
