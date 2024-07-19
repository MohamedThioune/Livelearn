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
    $exceptCourses = ['Artikel','Podcast','Video'];
    foreach ($schedules as $schedule) {
        global $wpdb;
        $data_locaties_xml = get_field('data_locaties_xml', $schedule->ID);
        if (!$data_locaties_xml)
            continue;
        $courseTime = array();
        $coursType = get_field('courseType', $schedule->ID);
        if (in_array($coursType, $exceptCourses))
            continue;

        foreach ($data_locaties_xml as $dataxml) {
            if ($dataxml) {
                $datetime = explode(' ', $dataxml['value']);

                $date = explode(' ', $datetime[0])[0];
                $time = explode('-', $datetime[1])[0];
                $courseTime[] = array('date'=>$date,'time'=>$time);

                $date = date('Y-m-d', strtotime($date));
                $current_date = date('Y-m-d');

                if ($date < $current_date)
                    continue;
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
        $schedule_data['course_type'] = $coursType;
        $schedule_data['data_locaties'] = get_field('data_locaties', $schedule->ID);
        $schedule_data['pathImage'] = $image;
        $schedule_data['for_who'] = get_field('for_who', $schedule->ID) ? (get_field('for_who', $schedule->ID)) : "" ;
        $schedule_data['price'] = get_field('price',$schedule->ID)!="0" ? get_field('price',$schedule->ID) : "Gratis";
        $schedule_data['data_locaties_xml'] = $data_locaties_xml;
        $schedule_data['courseTime'] = $courseTime;
        $schedule_data['author'] = get_user_by('ID', $schedule->post_author);
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

function get_notifications($data)
{
    $id_user_connected = intval($data['ID']);
    if (!$id_user_connected)
        return new WP_REST_Response(array('message' => 'User id is required in the request'), 401);

    $managed_id = get_field('ismanaged', 'user_' . $id_user_connected);
    $manager_profile = get_field('profile_img','user_'.$managed_id) ? : get_stylesheet_directory_uri() . '/img' . '/Group216.png' ;
    $args = array(
        'post_type' => array('feedback', 'mandatory', 'badge'),
        'author' => $id_user_connected, // id user connected
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );
    $notifications = get_posts($args);
    //Feedbacks
    $args = array(
        'post_type' => 'feedback',
        //'author' => $id_user_connected,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );
    $notification_feedbacks = get_posts($args);

    //Mandatories
        $args = array(
            'post_type' => 'mandatory',
            //'author' => $id_user_connected,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'posts_per_page' => -1,
        );
        $notification_mandatories = get_posts($args);

    //Badges
        $args = array(
        'post_type' => 'badge',
        //'author' => $id_user_connected,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'posts_per_page' => -1,
    );
    $notification_badges = get_posts($args);
    foreach($notification_feedbacks as $notification):
        $notification_id_manager = (get_field('manager_feedback', $notification->ID)) ?: get_field('manager_badge', $notification->ID);
        $notification_id_manager = ($notification_id_manager) ?: get_field('manager_must', $notification->ID);
        $manager = get_user_by('ID', $notification_id_manager);
        $notification->manager_company = get_field('company', 'user_' . $manager->ID)[0]->post_title ? : 'Livelearn';
        $notification->manager_image = get_field('profile_img',  'user_' . $manager->ID) ?: get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
        $notification->manager_name = ($manager->display_name) ?: 'Livelearn';
        $notification->date = date("d M Y", strtotime($notification->post_date)).' at '.date("h:i", strtotime($notification->post_date));

        $notification->notification_read = get_field('read_feedback', $notification->ID)[0];
        endforeach;
    foreach($notification_mandatories as $notification):
        $notification_id_manager = (get_field('manager_feedback', $notification->ID)) ?: get_field('manager_badge', $notification->ID);
        $notification_id_manager = ($notification_id_manager) ?: get_field('manager_must', $notification->ID);
        $manager = get_user_by('ID', $notification_id_manager);
        $notification->manager_company = get_field('company', 'user_' . $manager->ID)[0]->post_title ? : 'Livelearn';
        $notification->manager_image = get_field('profile_img',  'user_' . $manager->ID) ?: get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
        $notification->manager_name = ($manager->display_name) ?: 'Livelearn';
        $notification->date = date("d M Y", strtotime($notification->post_date)).' at '.date("h:i", strtotime($notification->post_date));

        $notification->notification_read = get_field('read_feedback', $notification->ID)[0];
        endforeach;
    foreach($notification_badges as $notification):
        $notification_id_manager = (get_field('manager_feedback', $notification->ID)) ?: get_field('manager_badge', $notification->ID);
        $notification_id_manager = ($notification_id_manager) ?: get_field('manager_must', $notification->ID);
        $manager = get_user_by('ID', $notification_id_manager);
        $notification->manager_company = get_field('company', 'user_' . $manager->ID)[0]->post_title ? : 'Livelearn';
        $notification->manager_image = get_field('profile_img',  'user_' . $manager->ID) ?: get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
        $notification->manager_name = ($manager->display_name) ?: 'Livelearn';
        $notification->date = date("d M Y", strtotime($notification->post_date)).' at '.date("h:i", strtotime($notification->post_date));

        $notification->notification_read = get_field('read_feedback', $notification->ID)[0];
        endforeach;

    return new WP_REST_Response(
        array(
            'achievement'=>$notification_badges,
            'feedback'=>$notification_feedbacks,
            'todo'=>$notification_mandatories,

        ), 200);
}

function companyPeople($data){
    $users = get_users();
    $members = array();
    $user_connected = intval($data['ID']);
    if (!$user_connected)
        return new WP_REST_Response(array('message' => 'User id is required in the request'), 401);

    $company = get_field('company',  'user_' . $user_connected);

    if(!empty($company))
        $company_connected = $company[0]->ID;

    $step = 1000;
    $key = 3;
    $star_index = ($key - 1) * $step;

    //for ($i = $star_index; $i < $star_index + $step && $i < count($users) ; $i++) {
    foreach($users as $user){
        //$user = $users[$i];

        if($user_connected != $user->ID ){
            $company = get_field('company',  'user_' . $user->ID);
            $user->imagePersone = get_field('profile_img',  'user_' . $user->ID) ? : get_field('profile_img_api',  'user_' . $user->ID);
            $user->department = get_field('departments', $company[0]->ID);
            $user->phone = get_field('telnr',  'user_' . $user->ID);
            //people you manages
            $people_managed_by_me = array();
            //$people_you_manage = ['3','5','6','7'];
            $people_you_manage = get_field('managed',$user->ID);
            if($people_you_manage)
                foreach ($people_you_manage as $persone_id){
                    $persone = get_user_by('ID', $persone_id);
                    if(!$persone)
                        continue;
                    $company = get_field('company',  'user_' . $persone_id);
                    $persone->data->company = $company;
                    $persone->data->imagePersone = get_field('profile_img',  'user_' . $persone_id) ? : get_field('profile_img_api',  'user_' . $persone_id);
                    $persone->data->department = get_field('departments', $company[0]->ID);
                    $persone->data->phone = get_field('telnr',  'user_' . $persone->ID);

                    $people_managed_by_me[] = $persone->data;
                }
            $user->people_you_manage = $people_managed_by_me;
            $user->company = $company[0];

            if(!empty($company)){
                $company = $company[0]->ID;
                if($company == $company_connected)  // compare ID
                    array_push($members, $user);
            }
        }
    }

    $response = new WP_REST_Response(
        array(
            'people'=>$members,
            'count'=>count($members),
        ));
    $response->set_status(200);
    return $response;
}
function learn_modules($data){
    $users_companie = array();
    //$user_connected =get_user_by('ID', $data['ID']); //$user_in
    $users = get_users();
    foreach($users as $user) {
        $company_user = get_field('company',  'user_' . $user->ID);
        if(!empty($company_connected) && !empty($company_user))
            if($company_user[0]->post_title == $company_connected[0]->post_title)
                array_push($users_companie,$user->ID);
    }
    //$company_connected = get_field('company',  'user_' . $user_connected);
    $args = array(
        'post_type' => array('course','post','leerpad','assessment'),
        'posts_per_page' => 1000,
        'author__in' => $users_companie,
        'ORDER BY' => 'post_date',
    );

    //bought courses
    $order_args = array(
        'customer_id' => get_current_user_id(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'post_status' => array('wc-processing'),
    );
    $bunch_orders = wc_get_orders($order_args);
    $enrolled_user = array();
    foreach($bunch_orders as $order){
        foreach ($order->get_items() as $item_id => $item ) {
            $course_id = intval($item->get_product_id()) - 1;
            $course = get_post($course_id);
            if(!empty($course))
                array_push($enrolled_user, $course->ID);
        }
    }

    $courses = get_posts($args);
    $all_subtopics = array();
    $subtopics = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => (int)'expert',
        'hide_empty' => false, // change to 1 to hide categores not having a single post
    )) ?? false;
    if ($subtopics != false)
        $all_subtopics = array_merge($all_subtopics,$subtopics);

    foreach ($courses as $course){
        $all_subtopics = array();
            $subtopics = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => (int)'expert',
                'hide_empty' => false, // change to 1 to hide categores not having a single post
            )) ?? false;
            if ($subtopics != false)
                $all_subtopics = array_merge($all_subtopics,$subtopics);

        $price = get_field('price',$course->ID);
        $course->price = $price ? : 'Gratis';
        $course->startDate = date('d/m/Y',strtotime($course->post_date));
        $course->courseType = get_field('course_type',$course->ID);
        $course->subects = $all_subtopics[0]->name;
        $course->sales = in_array($course->ID, $enrolled_user); //true or false

    }
    $response = new WP_REST_Response($courses);
    $response->set_status(200);
    return $response;
}
function learnning_database(){
$args = array(
        'post_type' => array('course','post','leerpad','assessment'),
        'posts_per_page' => 1000,
        'ORDER BY' => 'post_date',
    );
    $order_args = array(
        'customer_id' => get_current_user_id(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'post_status' => array('wc-processing'),
    );
    $bunch_orders = wc_get_orders($order_args);
    $enrolled_user = array();
    foreach($bunch_orders as $order){
        foreach ($order->get_items() as $item_id => $item ) {
            $course_id = intval($item->get_product_id()) - 1;
            $course = get_post($course_id);
            if(!empty($course))
                array_push($enrolled_user, $course->ID);
        }
    }
    $courses = get_posts($args);
    foreach ($courses as $course){
        $all_subtopics = array();
        $subtopics = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => (int)'expert',
            'hide_empty' => false, // change to 1 to hide categores not having a single post
        )) ?? false;
        if ($subtopics != false)
            $all_subtopics = array_merge($all_subtopics,$subtopics);

        $price = get_field('price',$course->ID);
        $course->price = $price ? : 'Gratis';
        $course->startDate = date('d/m/Y',strtotime($course->post_date));
        $course->courseType = get_field('course_type',$course->ID);
        $course->subects = $all_subtopics[2]->name;
        $course->sales = in_array($course->ID, $enrolled_user); //true or false
    }
    $response = new WP_REST_Response($courses);
    $response->set_status(200);
    return $response;
}

function get_detail_notification($data){
    $id_notification = intval($data['id']);
    $notification = get_post($id_notification);
    if(!$notification)
        return new WP_REST_Response(array('message' => 'Notification not found'), 404);

    $notification->date = date("d M Y", strtotime($notification->post_date)).' at '.date("h:i", strtotime($notification->post_date));
    $notification->notification_read = get_field('read_feedback', $notification->ID)[0];
    $notification->notification_type = get_post_type($notification->ID);
    $notification->notification_title = $notification->post_title;
    $notification->notification_content = get_field('content',$notification->ID);
    $notification->notification_manager = get_field('manager_feedback', $notification->ID) ? : get_field('manager_badge', $notification->ID);
    $notification->notification_manager = $notification->notification_manager ? : get_field('manager_must', $notification->ID);
    $notification->notification_manager = get_user_by('ID', $notification->notification_manager)->data;
    $notification->notification_manager->company = get_field('company', 'user_' . $notification->notification_manager->ID)[0]->post_title ? : 'Livelearn';
    $notification->notification_manager->image = get_field('profile_img',  'user_' . $notification->notification_manager->ID) ?: get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
    $notification->notification_manager->name = ($notification->notification_manager->display_name) ?: 'Livelearn';
    $notification->notification_author = get_user_by('ID', $notification->post_author)->data;
    $notification->notification_author->company = get_field('company', 'user_' . $notification->post_author)[0]->post_title ? : 'Livelearn';
    $notification->notification_author->image = get_field('profile_img',  'user_' . $notification->post_author) ?: get_stylesheet_directory_uri() . '/img/logo_livelearn.png';


    $response = new WP_REST_Response($notification);
    $response->set_status(200);
    return $response;
}
