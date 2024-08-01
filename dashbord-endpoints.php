<?php
global $wpdb;
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
        $image = get_field('profile_img',  'user_' . $expert->ID) ? : get_stylesheet_directory_uri() . '/img/user.png';

        $expert_data['id'] = $expert->ID;
        $expert_data['email'] = $expert->user_email;
        $expert_data['name'] = $expert->display_name;
        $expert_data['image'] = $image;
        $expert_data['imageExpert'] = get_avatar_url($expert->ID);
        $expert_data['role'] = $roles[0];

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
        $notification->post_type = 'todo';

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
    global $wpdb;
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

    foreach($users as $user){
        if($user_connected != $user->ID ){
            $company = get_field('company',  'user_' . $user->ID);
            $user->imagePersone = get_field('profile_img',  'user_' . $user->ID) ? : get_field('profile_img_api',  'user_' . $user->ID);
            $user->department = get_field('departments', $company[0]->ID);
            $user->phone = get_field('telnr',  'user_' . $user->ID);
            //people you manages
            $people_managed_by_me = array();
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
    foreach ($members as $user){
        $is_login = false;
        $date = new DateTime();
        $date_this_month = date('Y-m-d');
        $date_last_month = $date->sub(new DateInterval('P1M'))->format('Y-m-d');
        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        $sql = $wpdb->prepare("SELECT * FROM $table_tracker_views WHERE user_id = ".$user->ID." AND updated_at BETWEEN '".$date_last_month."' AND '".$date_this_month."'");
        $if_user_actif = count($wpdb->get_results($sql));

        if ((new DateTime($user->user_registered))->format('Y-m-d') <= $date_last_month)
            $new_members_count++;

        if ($if_user_actif)
            $is_login = true;
        $members_active = $is_login ? $members_active + 1 : $members_active;

        $is_login ? $members_active ++ : $members_inactive++;
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

    $notification_type = get_post_type($notification->ID);
    $notification_type = ($notification_type == 'mandatory') ? 'todo' : $notification_type;
    $notification->date = date("d M Y", strtotime($notification->post_date)).' at '.date("h:i", strtotime($notification->post_date));
    $notification->notification_read = get_field('read_feedback', $notification->ID)[0];
    $notification->notification_type = $notification_type;
    $notification->post_type = $notification_type;
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

function get_number_for_month($month, $plateform='web'){
    global $wpdb;
    $number_of_month = 0;
    $year = intval(date('Y'));
    $actual_month = intval(date('m'));
    switch ($month){
        case 'Jan' :
            $number_of_month = 1;
            break;
        case 'Feb' :
            $number_of_month = 2;
            break;
        case 'March' :
            $number_of_month = 3;
            break;
        case 'Apr' :
            $number_of_month = 4;
            break;
        case 'May' :
            $number_of_month = 5;
            break;
        case 'Jun' :
            $number_of_month = 6;
            break;
        case 'Jul' :
            $number_of_month = 7;
            break;
        case 'Aug' :
            $number_of_month = 8;
            break;
        case 'Sep' :
            $number_of_month = 9;
            break;
        case 'Oct' :
            $number_of_month = 10;
            break;
        case 'Nov' :
            $number_of_month = 11;
            break;
        case 'Dec' :
            $number_of_month = 12;
            break;
    }
    if ($number_of_month>$actual_month)
        $year = $year-1;

    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $sql = $wpdb->prepare("SELECT COUNT(*) FROM $table_tracker_views WHERE MONTH(updated_at) = $number_of_month AND YEAR(updated_at) = $year AND platform = '".$plateform."'");
    $number_statistics = $wpdb->get_results($sql)[0]->{'COUNT(*)'};
    return intval($number_statistics);
}

function company_statistic($data)
{
    global $wpdb;
    $current_user = intval($data['ID']);
    $company = get_field('company',  'user_' . $current_user);
    $user_connected = get_user_by('ID', $current_user)->data;
    $user_connected->member_sice = date('Y',strtotime($user_connected->user_registered));
    $user_connected->user_company = $company[0];
    $company_connected = $company[0]->ID;
    $users = get_users();
    $assessment_validated = array();
    $enrolled_courses = array();
    $desktop_vs_mobile = array(
        'desktop'=>array(),
        'mobile'=>array()
    );
    $members_active = 5;
    $members_inactive = 5;
    $most_topics_view = array();
    $budget_spent = 0;
    $count_mandatories_video = 0;
    foreach ($users as $user ) {
        $company = get_field('company',  'user_' . $user->ID);

        if(!empty($company))
            if($company[0]->ID == $company_connected) {
                $numbers[] = $user->ID;
                $members[] = $user;
                if($user->user_registered)

                    // Assessment
                    $validated = get_user_meta($user->ID, 'assessment_validated');
                foreach($validated as $assessment)
                    if(!in_array($assessment, $assessment_validated))
                        array_push($assessment_validated, $assessment);
            }
    }
    //Topic views
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id IN (" . implode(',', $numbers) . ") AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
    $topic_views = $wpdb->get_results($sql);

    foreach ($topic_views as $topic){
        $subtopic = array();
        $subtopic['name'] = (String)get_the_category_by_ID($topic->data_id);
        $subtopic['occurence'] = $topic->occurence;
        $image_topic = get_field('image', 'category_'. $topic->data_id);
        $subtopic['image'] = $image_topic ?  : get_stylesheet_directory_uri() . '/img/placeholder.png';
        $most_topics_view[] = $subtopic;
    }

    /* Assessment */
    $args = array(
        'post_type' => 'assessment',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $assessments = get_posts($args);
    $count_assessments = count($assessments);
    $assessment_validated = (!empty($assessment_validated)) ? count($assessment_validated) : 0;
    $assessment_not_started = 0;
    $assessment_completed = 0;
    if($count_assessments > 0){
        $not_started_assessment = abs($count_assessments - $assessment_validated);
        $assessment_not_started = intval(($not_started_assessment / $count_assessments) * 100);
        $assessment_completed = intval(($assessment_validated / $count_assessments) * 100);
    }
    /* assessment doing by this user */
    $args = array(
        'post_type' => 'assessment',
        'post_status' => 'publish',
        'author' => $user_connected->ID,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $assessments_created = get_posts($args);
    $count_assessments_created = (!empty($assessments_created)) ? count($assessments_created) : 0;

    /* Mandatories */
    $args = array(
        'post_type' => 'mandatory',
        'post_status' => 'publish',
        'author__in' => $user_connected->ID,
        'posts_per_page'         => -1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
    $mandatories = get_posts($args);
    $count_mandatories_video = (!empty($mandatories)) ? count($mandatories) : 0;

    /* Members course */
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'author__in' => $numbers,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $member_courses = get_posts($args);
    $member_courses_id = array_column($member_courses, 'ID');
    $progress_courses = array(
        'not_started' => 0,
        'in_progress' => 0,
        'done' => 0,
    );
    $enrolled_all_courses = array();
    $args = array(
        'post_status' => array('wc-processing', 'wc-completed'),
        'orderby' => 'date',
        'order' => 'DESC',
        'limit' => -1,
    );
    //$bunch_orders = wc_get_orders($args);
    $bunch_orders = array();
    foreach($bunch_orders as $order){
        foreach ($order->get_items() as $item_id => $item ) {
            //Get woo orders from user
            $course_id = intval($item->get_product_id()) - 1;
            $course = get_post($course_id);

            $prijs = get_field('price', $course_id);
            $budget_spent += $prijs;
            if(in_array($course_id, $member_courses_id)){
                array_push($enrolled_all_courses, $course_id);
                if(!in_array($course_id, $enrolled)){
                    array_push($enrolled, $course_id);
                    array_push($enrolled_courses, $course);
                    //Get progresssion this course
                    $args = array(
                        'post_type' => 'progression',
                        'title' => $course->post_name,
                        'post_status' => 'publish',
                        'posts_per_page'         => -1,
                        'no_found_rows'          => true,
                        'ignore_sticky_posts'    => true,
                        'update_post_term_cache' => false,
                        'update_post_meta_cache' => false
                    );
                    $progressions = get_posts($args);
                    if(!empty($progressions))
                        foreach ($progressions as $progression) {
                            $status = "in_progress";
                            $progression_id = $progression->ID;
                            //Finish read
                            $is_finish = get_field('state_actual', $progression_id);
                            if($is_finish)
                                $status = "done";

                            switch ($status) {

                                case 'in_progress':
                                    $progress_courses['in_progress'] += 1;
                                    break;

                                case 'done':
                                    $progress_courses['done'] += 1;
                                    //course finished
                                    array_push($course_finished, $course->ID);
                                    break;
                            }
                        }
                }
            }
        }
    }
    $count_enrolled_courses = (!empty($enrolled_courses)) ? count($enrolled_courses) : 0;
    $progress_courses['not_started'] = abs($count_enrolled_courses - ($progress_courses['in_progress'] + $progress_courses['done']));
    if($count_enrolled_courses > 0){
        $progress_courses['not_started'] = intval(($progress_courses['not_started'] / $count_enrolled_courses) * 100);
        $progress_courses['in_progress'] = intval(($progress_courses['in_progress'] / $count_enrolled_courses) * 100);
        $progress_courses['done'] = intval(($progress_courses['done'] / $count_enrolled_courses) * 100);
    }
    else
        $progress_courses['not_started'] = 100;

    // Most popular
    $most_popular = array_count_values($enrolled_all_courses);
    arsort($most_popular);
    $args = array(
        'post_type' => 'course',
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => $most_popular,
    );
    $most_popular_course = get_posts($args);
    $desktop_vs_mobile = array(
        'desktop' => array(
            'Jan'=>get_number_for_month('Jan'),
            'Feb'=>get_number_for_month('Feb'),
            'March'=>get_number_for_month('March'),
            'Apr'=>get_number_for_month('Apr'),
            'May'=>get_number_for_month('May'),
            'Jun'=>get_number_for_month('Jun'),
            'Jul'=>get_number_for_month('Jul'),
            'Aug'=>get_number_for_month('Aug'),
            'Sep'=>get_number_for_month('Sep'),
            'Oct'=>get_number_for_month('Oct'),
            'Nov'=>get_number_for_month('Nov'),
            'Dec'=>get_number_for_month('Dec'),
        ),

        'mobile' => array(
            'Jan'=>get_number_for_month('Jan','mobile'),
            'Feb'=>get_number_for_month('Feb','mobile'),
            'March'=>get_number_for_month('March','mobile'),
            'Apr'=>get_number_for_month('Apr','mobile'),
            'May'=>get_number_for_month('May','mobile'),
            'Jun'=>get_number_for_month('Jun','mobile'),
            'Jul'=>get_number_for_month('Jul','mobile'),
            'Aug'=>get_number_for_month('Aug','mobile'),
            'Sep'=>get_number_for_month('Sep','mobile'),
            'Oct'=>get_number_for_month('Oct','mobile'),
            'Nov'=>get_number_for_month('Nov','mobile'),
            'Dec'=>get_number_for_month('Dec','mobile'),
        ),
    );

    $response = new WP_REST_Response(
        array(
            'user_profile'=>$user_connected,
            'indivudual'=>array(
                'team_first_card'=>array(
                    'budget_spent'=>$budget_spent,
                    'course_in_progress'=>$progress_courses['not_started'],
                    'your_courses'=>$count_enrolled_courses,
                    'course_done'=>$progress_courses['done'],
                    'assessment_created'=>$count_assessments_created,
                    'mandatories_received'=>$count_mandatories_video,
                ),
                'most_topics_view'=>$most_topics_view,
                'progress_courses'=>array(
                    'user_engagement'=>array(
                        'active'=>$members_active,
                        'inactive'=>$members_inactive
                    ),
                    'user_progress_the_courses'=>$progress_courses,
                    'assesment'=>array(
                        'not_started'=>$assessment_not_started,
                        'completed'=>$assessment_completed,
                    ),
                ),
                'other_members'=>$members
            ),
            'company' => array(
                //'total_members'=>$members,
                //'assessment_validated'=>$assessment_validated,
                //'enrolled_courses'=>$enrolled_courses,
                    'progress_courses'=>array(
                        'user_engagement'=>array(
                            'active'=>$members_active,
                            'inactive'=>$members_inactive
                        ),
                        'user_progress_the_courses'=>$progress_courses,
                        'assesment'=>array(
                            'not_started'=>$assessment_not_started,
                            'completed'=>$assessment_completed,
                            ),
                    ),
                'desktop_vs_mobile'=>$desktop_vs_mobile,
                'popular_course'=>$most_popular_course,
                'most_topics_view'=>$most_topics_view,
            ),
            'team'=>array(
                'team_first_card'=>array(
                    'total_members'=>count($members),
                    'all_courses'=>$count_enrolled_courses,
                    'assessment'=>$assessment_validated,
                    'courses_done'=>$progress_courses['done'],
                    'mandatories'=>$count_mandatories_video,
                    'member_actif'=>5
                ),
                'user_progress_the_courses'=>$progress_courses,
                'desktop_vs_mobile'=>$desktop_vs_mobile,
                'team_managed'=>$members
            )
        ), 200);
    return $response;
}
function get_emploees($data)
{
    $users = get_users();
    $user_connected = intval($data['id']);
    $company = get_field('company',  'user_' . $user_connected);
    if(!empty($company))
        $company_connected_id = $company[0]->ID;

    $members = array();
    foreach($users as $user)
        if($user_connected != $user->ID ){
            $company = get_field('company',  'user_' . $user->ID);
            if(!empty($company)){
                $image = get_field('profile_img',  'user_' . $user->ID) ? : get_stylesheet_directory_uri() . '/img/user.png';
                $departement = get_field('departments', $company[0]->ID);
                $company_id = $company[0]->ID;
                if($company_id == $company_connected_id) {
                    $user->data->role = $user->roles[0];
                    $user->data->image = $image;
                    $user->data->departement = $departement[0]['name'];

                    array_push($members, $user->data);
                }
            }
        }
    $response = new WP_REST_Response(
        array(
            'count'=>count($members),
            'employees'=>$members,
        ));
    $response->set_status(200);
    return $response;
}

function add_departement($data)
{
    $user_connected = intval($data['id']);
    $company = get_field('company',  'user_' . $user_connected);
    $department['name'] = $data['name'];
    $departments = get_field('departments', $company[0]->ID) ? : array();
    $departments[] = $department;
    $isInsert = update_field('departments', $departments, $company[0]->ID);
    if (!$isInsert)
        return new WP_REST_Response(array('message' => 'Error while adding department'), 401);

    $response = new WP_REST_Response(
    array(
        'message'=>'Department added successfully to the company !',
        'departments'=>$departments,
    ));
    $response->set_status(200);
    return $response;
}
function get_departements($data)
{
    $user_connected = intval($data['id']);
    $company = get_field('company',  'user_' . $user_connected);

    $departments = get_field('departments', $company[0]->ID)? : array();
    $response = new WP_REST_Response(
        array(
            'departments'=>$departments,
        ));
    $response->set_status(200);
    return $response;
}

function remove_departement($data)
{
    $user_connected = intval($data['id']);
    $company = get_field('company',  'user_' . $user_connected);
    $department['name'] = $data['name']; // departement to remove
    $departments = get_field('departments', $company[0]->ID) ? : array();
    $key = array_search($department, $departments);
    if($key !== false)
        unset($departments[$key]);

    $isInsert = update_field('departments', $departments, $company[0]->ID);
    if (!$isInsert)
        return new WP_REST_Response(array('message' => 'Error while removing department'), 401);

    $response = new WP_REST_Response(
        array(
            'message'=>'Department removed successfully from the company !',
            'departments'=>$departments,
        ));
    $response->set_status(200);
    return $response;
}
function Selecteer_experts($data)
{
    $users = get_users();
    $user_connected = intval($data['id']);
    $company = get_field('company',  'user_' . $user_connected);
    $company_connected_id = $company[0]->ID;
    $members = array();
    foreach($users as $user){
        $member = array();
        if(!in_array('manager', $user->roles) && !in_array('author', $user->roles) )
            continue;

        $company = get_field('company',  'user_' . $user->ID);

        if(!empty($company) && $user_connected != $user->ID ){
            $company_id = $company[0]->ID;

            if($company_id == $company_connected_id) {
                $image = get_field('profile_img',  'user_' . $user->ID) ? : get_stylesheet_directory_uri() . '/img/user.png';
                $name = ($user->first_name) ?  $user->first_name . ' ' . $user->last_name : $user->user_email ;

                $is_manager = (in_array('manager', $user->roles)) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';
                $is_author = (in_array('author', $user->roles)) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-close"></i>';

                $departement = get_field('departments', $company[0]->ID);
                $member['ID'] = $user->ID;
                $member['role'] = $user->roles[0];
                $member['name'] = $name;
                $member['image'] = $image;
                $member['manager'] = $is_manager;
                $member['teacher'] = $is_author;
                $member['departement'] = $departement[0]['name'];

                array_push($members, $member);
            }
       }
    }
    $response = new WP_REST_Response(
        array(
            'Selecteer_je_experts'=>$members
        ));
    $response->set_status(200);
    return $response;
}

/**
 * @param $data
 * @return WP_REST_Response
 */
function people_managed($data)
{
    $users = get_users();
    $user_connected = intval($data['id']);
    $company = get_field('company',  'user_' . $user_connected);
    $company_connected_id = $company[0]->ID;
    $people_to_manage = array();
    $people_managed =  array();
    $id_people_managed = get_field('managed', 'user_'.$user_connected);

    if (!empty($id_people_managed))
        foreach ($id_people_managed as $id_person) {
            if ($id_person == $user_connected)
                continue;
            $image = get_field('profile_img',  'user_' . $id_person) ? : get_stylesheet_directory_uri() . '/img/user.png';
            $person = get_user_by('ID', $id_person);
            if (!$person->data)
                continue;
            $person = $person->data;
            $person->image = $image;
            unset($person->user_pass);
            $people_managed[] = $person;
        }

    foreach($users as $user){
        $person_to_manage = array();
        //$person_managed = array();
        if(in_array('administrator', $user->roles) || in_array('hr', $user->roles) || in_array('manager', $user->roles))
            continue;
        if(!empty($id_people_managed))
            if(in_array($user->ID, $id_people_managed))
                continue;

        $company = get_field('company',  'user_' . $user->ID);
        if (!empty($company) && $user_connected != $user->ID ) {
            if ($company[0]->ID == $company_connected_id) {
                $image = get_field('profile_img',  'user_' . $user->ID) ? : get_stylesheet_directory_uri() . '/img/user.png';
                $name = ($user->first_name) ?  $user->first_name . ' ' . $user->last_name : $user->user_email ;

                $person_to_manage['ID'] = $user->ID;
                $person_to_manage['name'] = $name;
                $person_to_manage['email'] = $user->user_email;

                array_push($people_to_manage, $person_to_manage);
                //if(!empty($person_managed))
                  //  array_push($people_managed, $person_to_manage);
            }
        }
    }

    $response = new WP_REST_Response(
        array(
            'Select_the_people_you_want_to_manage'=>$people_to_manage,
            'people_you_manage'=>$people_managed
        ));
    $response->set_status(200);
    return $response;
}

/**
 * @param WP_REST_Request $data
 * @return WP_REST_Response 'people_id' this field must an array of ID people to manage
 */
function add_people_to_manage(WP_REST_Request $data)
{
    $required_parameters = ['people_id'];
    $errors = validated($required_parameters, $data);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    $user_connected = intval($data['id']);

    $people_id = $data['people_id'];
    foreach ($people_id as $id_person)
        update_field('ismanaged', $user_connected, 'user_' . $id_person);

    $people_managed = get_field('managed', 'user_'.$user_connected) ? : array();
    $people_managed = array_merge($people_managed,$people_id);
    $isInsert = update_field('managed', $people_managed, 'user_'.$user_connected);
    if (!$isInsert)
        return new WP_REST_Response(array('message' => 'Error while adding people to manage'), 401);

    $response = new WP_REST_Response(
        array(
            'message'=>'People added successfully to manage !',
            'people_managed'=>$people_managed,
        ));
    $response->set_status(200);
    return $response;
}
