<?php
global $wpdb;
require('templates/mail-notification-invitation.php');

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
    global $wpdb;
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    //$current_date = date('Y-m-d');
    $current_date = date('d/m/Y');
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'meta_key' => 'data_locaties_xml',
    );
    $schedules = get_posts($args);
    $all_schedules = array();
    $exceptCourses = ['Artikel','Podcast','Video', 'E-learning', 'Assessment', 'Cursus', 'Class'];
    foreach ($schedules as $schedule) {
        $coursType = get_field('course_type', $schedule->ID);
        if (in_array($coursType, $exceptCourses))
            continue;

        $data_locaties_xml = get_field('data_locaties_xml', $schedule->ID);
        if (!$data_locaties_xml)
            continue;
        $courseTime = array();
        foreach ($data_locaties_xml as $dataxml)
            if ($dataxml) {
                $datetime = explode(' ', $dataxml['value']);
                $date = $datetime[0];

                //$date = date('Y-m-d', strtotime($date));
                if ($date) {
                    if ($current_date >= $date)  // the best choice compare
                        continue;

                    $time = explode('-', $datetime[1])[0];
                    $courseTime[] = array('date' => $date, 'time' => $time);
                }
            }
        if (!$courseTime)
            continue;

        /** if 500 error comment this part of code with database */

        //$sql = $wpdb->prepare( "SELECT user_id FROM $table_tracker_views WHERE data_id =$schedule->ID");
        //$user_follow_this_course = $wpdb->get_results( $sql );
        //if(!$user_follow_this_course)
       //     continue;
        //if(intval($user_follow_this_course[0]->user_id)!=$user_id)
        //    continue;

        $image = get_field('preview', $schedule->ID) ? : '';
        if ($image)
            $image = $image['url'];

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
        $schedule_data['price'] = get_field('price',$schedule->ID) ? : "Gratis";
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
    else
        $company_connected = 0;

    foreach($users as $user){
        if ($user->ID == $user_connected)
            continue;

            $company = get_field('company',  'user_' . $user->ID);
            $image = get_field('profile_img',  'user_' . $user->ID) ? : get_field('profile_img_api',  'user_' . $user->ID);
            $user->imagePersone = $image ? : get_stylesheet_directory_uri() . '/img/user.png';
            $user->function = get_field('role',  'user_' . $user->ID)? : '';
            $user->department = get_field('department','user_'. $user->ID)?:'';
            $user->phone = get_field('telnr',  'user_' . $user->ID);
            /*
            //people you manages
            $people_managed_by_me = array();
            $people_you_manage = get_field('managed','user_'.$user->ID);
            if($people_you_manage)
                foreach ($people_you_manage as $persone_id){
                    $persone = get_user_by('ID', $persone_id);
                    if(!$persone)
                        continue;
                    $company = get_field('company',  'user_' . $persone_id);
                    $persone->data->company = $company;
                    $persone->data->imagePersone = get_field('profile_img',  'user_' . $persone_id) ? : get_field('profile_img_api',  'user_' . $persone_id);
                    $persone->data->department = get_field('department','user_'.$persone_id);
                    $persone->data->phone = get_field('telnr',  'user_' . $persone->ID);
                    $persone->data->function = get_field('role',  'user_' . $persone->ID);
                    unset($persone->data->user_pass);
                    $people_managed_by_me[] = $persone->data;
                }
            $user->people_you_manage = $people_managed_by_me;
            */
            if(!empty($company)){
                $user->company = $company[0];
                $company_id = $company[0]->ID;
                if($company_id == $company_connected)  // compare ID
                    array_push($members, $user);
            }
    }
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $new_members_count = 0 ;
    $members_active = 0;
    $members_inactive = 0;

    foreach ($members as $user){
        $is_login = false;
        $date = new DateTime();
        $date_this_month = date('Y-m-d');
        $date_last_month = $date->sub(new DateInterval('P1M'))->format('Y-m-d');
        $sql = $wpdb->prepare("SELECT * FROM $table_tracker_views WHERE user_id = ".$user->ID." AND updated_at BETWEEN '".$date_last_month."' AND '".$date_this_month."'");
        $if_user_actif = count($wpdb->get_results($sql));

        if ((new DateTime($user->user_registered))->format('Y-m-d') <= $date_last_month)
            $new_members_count++;

        if ($if_user_actif)
            $is_login = true;
        $members_active = $is_login ? $members_active + 1 : $members_active;
    }

    $response = new WP_REST_Response(
        array(
            'count'=>count($members),
            'people'=>$members,
        ));
    $response->set_status(200);
    return $response;
}

function peopleYouManage($data)
{
    //manage error
    $required_parameters = ['idUser'];
    $errors = validated($required_parameters, $data);
    if ($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    $users = get_users();

    $user_connected = intval($data['id']);
    //$user_concerned = get_user_by('ID', $data['idUser']);
    $user_concerned = $data['idUser'];
    //var_dump($user_concerned);die;
    $people_managed_by = [];
    foreach ($users as $user) {
        $users_manageds = get_field('managed', 'user_' . $user->ID)?:[];

        //var_dump(array('user'=>$user->ID,'manager'=>$users_manageds));
        if ($users_manageds)
            if (in_array($user_concerned, $users_manageds)) {
                $user->data->image = get_field('profile_img', 'user_' . $user->ID) ? get_field('profile_img', 'user_' . $user->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                $user->data->link = "/dashboard/company/profile/?id=" . $user->ID . '&manager=' . $user_connected;
                $user->data->name = $user->first_name != "" ? $user->first_name : $user->display_name;
                unset($user->data->user_pass);
                unset($user->data->user_url);
                $people_managed_by [] = $user->data;
            }
    }
    $response = new WP_REST_Response(
        array(
            'managers' => $people_managed_by,
        ));
    $response->set_status(200);
    return $response;
}
function editPeopleCompany($data){
    $user_id = intval($data['ID']);
    $telephone = $data['phone'];
    $function = $data['function'];
    $department = $data['name_department'];
    //$company = get_field('company',  'user_' . $user_id);
    //$departments = array();
    /*
    if ($department) {
        $departments = get_field('departments', $company[0]->ID);
        $key = array_search($department, $departments);
        if($key !== false)
            unset($departments[$key]);

        array_push($departments, $department);
        update_field('departments', $departments ,'user_' . $user_id);
    }
    */
    if ($department) {
        //update_field('department', null, 'user_' . $user_id);
        update_field('department', $department, 'user_' . $user_id);
    }
    if ($telephone)
        update_field('telnr', $telephone ,'user_' . $user_id);
    if ($function)
        update_field('role', $function ,'user_' . $user_id);

    return new WP_REST_Response(
        array(
            'message'=>'User updated...',
            'id_user'=>$user_id,
            // 'departement'=>array_reverse($departments)
        ));
}

function removePeopleCompany($data)
{
    $user_id = intval($data['ID']);
    $isRemoved = update_field('company', null ,'user_' . $user_id);
    if ($isRemoved)
        return new WP_REST_Response(
            array(
                'message'=>'User removed from company...',
            ));
    return new WP_REST_Response(
        array(
            'message'=>'User not removed from company...',
            'id_user'=>$user_id,
        ));
}
function learn_modules($data){
    $users_companies = array();
    $user_connected = intval($data['ID']); //$user_in
    $company_connected = get_field('company',  'user_' . $user_connected);
    $users = get_users();
    foreach($users as $user) {
        $company_user = get_field('company',  'user_' . $user->ID);
        if(!empty($company_connected) && !empty($company_user))
            if($company_user[0]->ID == $company_connected[0]->ID)
                array_push($users_companies,$user->ID);
    }
    //$company_connected = get_field('company',  'user_' . $user_connected);
    $args = array(
        'post_type' => array('course','post','leerpad','assessment'),
        'posts_per_page' => -1,
        'author__in' => $users_companies,
        'ORDER BY' => 'post_date',
    );

    //bought courses
    $order_args = array(
        'customer_id' => get_current_user_id(),
        //'post_status' => array_keys(wc_get_order_statuses()),
        'post_status' => array('wc-processing'),
    );
    $bunch_orders = wc_get_orders($order_args);
    //$bunch_orders = array();
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
        'posts_per_page' => -1,
        'ORDER BY' => 'post_date',
    );
    $order_args = array(
        'customer_id' => get_current_user_id(),
        //'post_status' => array_keys(wc_get_order_statuses()),
        'post_status' => array('wc-processing'),
    );
    $bunch_orders = wc_get_orders($order_args);
    //$bunch_orders = array();
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

/**
 * @param $data
 * @return WP_REST_Response
 * @user_id id user connected getting via GET request
 */
function get_detail_notification($data){
    $id_notification = intval($data['id']);
    $notification = get_post($id_notification);
    if(!$notification)
        return new WP_REST_Response(array('message' => 'Notification not found, maybe id is not correct'), 404);

    $type = get_field('type_feedback', $id_notification) ?: $notification->post_type;

    if($type == "Feedback" || $type == "Compliment" || $type == "Gedeelde cursus")
        $beschrijving_feedback = get_field('beschrijving_feedback', $id_notification);
    else if($type == "Persoonlijk ontwikkelplan")
        $beschrijving_feedback = get_field('opmerkingen', $id_notification);
    else if($type == "Beoordeling Gesprek")
        $beschrijving_feedback = get_field('algemene_beoordeling', $id_notification);
    else
        $beschrijving_feedback = get_field('beschrijving_feedback', $id_notification) ?: 'Naan';

    $notification_type = get_post_type($notification->ID);
    $notification_type = ($notification_type == 'mandatory') ? 'todo' : $notification_type;

    $notification->date = date("d M Y", strtotime($notification->post_date)).' at '.date("h:i", strtotime($notification->post_date));
    $notification->notification_read = get_field('read_feedback', $notification->ID)[0];
    $notification->notification_type = $notification_type;
    $notification->post_type = $notification_type;
    $notification->notification_title = $notification->post_title;
    $notification->notification_content = get_field('content',$notification->ID)?:$notification->content;
    $notification->beschrijving_feedback = $beschrijving_feedback;


    $manager_id = get_field('manager_feedback', $notification->ID) ? : get_field('manager_badge', $notification->ID);
    $manager_id = $manager_id ? : get_field('manager_must', $notification->ID);
    $manager  =  get_user_by('ID', $manager_id);
    if ($manager){
        $manager = $manager->data;
    $manager->role = get_field('role',  'user_' . $manager_id) ? : '';

    $company_manager = get_field('company',  'user_' . $manager->ID);
    if ($company_manager)
        $manager->company  = $company_manager[0]->post_title;
    else
        $manager->company = 'Livelearn';

    $manager->image = get_field('profile_img',  'user_' . $manager_id) ? : get_stylesheet_directory_uri() . '/img/user.png';
        unset($manager->user_pass);
        $notification->notification_manager = $manager;
    }
    $notification->notification_author = get_user_by('ID', $notification->post_author)->data;
    unset($notification->notification_author->user_pass);
    $notification->notification_author->company = get_field('company', 'user_' . $notification->post_author)[0]->post_title ? : 'Livelearn';
    $notification->notification_author->image = get_field('profile_img',  'user_' . $notification->post_author) ?: get_stylesheet_directory_uri() . '/img/user.png';

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

/**
 * @return string
 */
function RandomStringBis(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $rand = $characters[rand(0, strlen($characters))];
        $randstring .= $rand;
    }
    return $randstring;
}
function sendEmail($id_user, $email, $name)
{
    $guest = get_user_by('ID', $id_user);
    $name_guest = (($guest->first_name) ?: $guest->display_name);
    $first_name = $name;
    $company = get_field('company',  'user_' . $id_user);
    $mail_invitation_body =
        '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <title>' . $first_name  . ', je account op LiveLearn is succesvol aangemaakt</firs-name></title><!--[if !mso]><!-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style type="text/css">
    #outlook a {
      padding: 0;
    }

    body {
      margin: 0;
      padding: 0;
      -webkit-text-size-adjust: 100%;
      -ms-text-size-adjust: 100%;
    }

    table,
    td {
      border-collapse: collapse;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
    }

    img {
      border: 0;
      height: auto;
      line-height: 100%;
      outline: none;
      text-decoration: none;
      -ms-interpolation-mode: bicubic;
    }

    p {
      display: block;
      margin: 13px 0;
    }
  </style>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
  <style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700);
  </style><!--<![endif]-->
  <style type="text/css">
    @media only screen and (min-width:480px) {
      .mj-column-per-100 {
        width: 100% !important;
        max-width: 100%;
      }
    }
  </style>
  <style media="screen and (min-width:480px)">
    .moz-text-html .mj-column-per-100 {
      width: 100% !important;
      max-width: 100%;
    }
  </style>
  <style type="text/css">
    [owa] .mj-column-per-100 {
      width: 100% !important;
      max-width: 100%;
    }
  </style>
  <style type="text/css">
    @media only screen and (max-width:480px) {
      table.mj-full-width-mobile {
        width: 100% !important;
      }

      td.mj-full-width-mobile {
        width: auto !important;
      }
    }
  </style>
</head>

<body style="word-spacing:normal;background-color:#e0eff4;">
  <div style="background-color:#e0eff4;">
    <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    <div style="margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
        <tbody>
          <tr>
            <td
              style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:20px;text-align:center;">
              <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:middle;width:600px;" ><![endif]-->
              <div class="mj-column-per-100 mj-outlook-group-fix"
                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:middle;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:middle;"
                  width="100%">
                  <tbody>
                    <tr>
                      <td align="left" vertical-align="middle"
                        style="font-size:0px;padding:10px 25px;padding-top:0;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;">
                        <div
                          style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;">
                          <p class="text-build-content"
                            style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"
                            data-testid="Y0h44Pmw76d">Uitnodiging voor een bedrijfs leeromgeving</p>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#FFFFFF" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
        <tbody>
          <tr>
            <td
              style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;">
              <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
              <div class="mj-column-per-100 mj-outlook-group-fix"
                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;"
                  width="100%">
                  <tbody>
                    <tr>
                      <td align="center" vertical-align="top"
                        style="background:#023356;font-size:0px;padding:0px 0px 0px 0px;padding-top:0;padding-right:0px;padding-bottom:0px;padding-left:0px;word-break:break-word;">
                        <p style="border-top:solid 10px #023356;font-size:1px;margin:0px auto;width:100%;"></p><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:solid 10px #023356;font-size:1px;margin:0px auto;width:600px;" role="presentation" width="600px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
        <tbody>
          <tr>
            <td
              style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:20px;text-align:center;">
              <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
              <div class="mj-column-per-100 mj-outlook-group-fix"
                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;"
                  width="100%">
                  <tbody>
                    <tr>
                      <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="border-collapse:collapse;border-spacing:0px;">
                          <tbody>
                            <tr>
                              <td style="width:50px;"><a href="http://app.livelearn.nl" target="_blank"><img alt=""
                                    height="auto" src="https://0gt5q.mjt.lu/tplimg/0gt5q/b/lurx1/l0xh.png"
                                    style="border:none;display:block;outline:none;text-decoration:none;height:auto;width:100%;font-size:13px;"
                                    width="50"></a></td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#FFFFFF" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
        <tbody>
          <tr>
            <td
              style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;">
              <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:middle;width:600px;" ><![endif]-->
              <div class="mj-column-per-100 mj-outlook-group-fix"
                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:middle;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:middle;"
                  width="100%">
                  <tbody>
                    <tr>
                      <td align="left" vertical-align="middle"
                        style="background:transparent;font-size:0px;padding:10px 25px;padding-top:20px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;">
                        <div
                          style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;">
                          <h1 class="text-build-content"
                            style="text-align:center;; margin-top: 10px; font-weight: normal;"
                            data-testid="RJMLrMvA0Rh"><span style="color:#000000;"><b>Uitnodiging</b></span></h1>
                          <p class="text-build-content" style="text-align: center; margin: 10px 0; margin-bottom: 10px;"
                            data-testid="RJMLrMvA0Rh">Je <span style="font-size:14px;">krijgt toegang tot alle content
                              vanuit '. $company[0]->post_title .'</span></p>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" vertical-align="middle"
                        style="background:transparent;font-size:0px;padding:10px 25px;padding-top:0px;padding-right:25px;padding-bottom:10px;padding-left:25px;word-break:break-word;">
                        <div
                          style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;">
                          <p class="text-build-content" data-testid="S_MPaSnC0uI"
                            style="margin: 10px 0; margin-top: 10px;"><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Hi <b>' . $first_name  . '
                              </b>,</span></p>
                          <p class="text-build-content" data-testid="S_MPaSnC0uI" style="margin: 10px 0;"><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Je bent
                              uitgenodigd om onderdeel te worden van ' . $company[0]->post_title . '. Vanaf nu kan je gebruik maken
                              van alle content die er beschikbaar gesteld wordt vanuit het
                              bedrijf.&nbsp;</span><br><br><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Uiteraard houd je
                              ook gewoon toegang tot alle content die vanuit LiveLearn of partners wordt
                              aangeboden.</span></p>
                          <p class="text-build-content" data-testid="S_MPaSnC0uI" style="margin: 10px 0;"><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;"><i><b>Jouw
                                gegevens</b></i></span><br><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Gebruikersnaam:
                              ' . $email . '</span><br><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Tijdelijk
                              wachtwoord: Livelearn2023</span></p>
                          <p class="text-build-content" data-testid="S_MPaSnC0uI" style="margin: 10px 0;"><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;"><i><b>Uitnodiging</b></i></span><br><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Door: ' . $name_guest . '
                              </span><br><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Bedrijf:&nbsp;' . $company[0]->post_title. '
                              </span><br><br><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Ben je niet
                              bekend met dit bedrijf of de persoon? Neem dan </span><a class="link-build-content"
                              style="color:inherit;; text-decoration: none;" href="mailto:contact@livelearn.nl"><span
                                style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;"><u>contact</u></span></a><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;"> met ons
                              op.</span><br>&nbsp;</p>
                          <p class="text-build-content" data-testid="S_MPaSnC0uI" style="margin: 10px 0;"><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Succes
                              namens,</span></p>
                          <p class="text-build-content" data-testid="S_MPaSnC0uI" style="margin: 10px 0;"><span
                              style="color:#787878;font-family:Arial;font-size:14px;line-height:22px;">Het LiveLearn
                              team</span></p>
                          <p class="text-build-content" data-testid="S_MPaSnC0uI"
                            style="margin: 10px 0; margin-bottom: 10px;">&nbsp;</p>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" vertical-align="middle"
                        style="background:transparent;font-size:0px;padding:10px 25px 20px 25px;padding-right:25px;padding-bottom:20px;padding-left:25px;word-break:break-word;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="border-collapse:separate;line-height:100%;">
                          <tbody>
                            <tr>
                              <td align="center" bgcolor="#023356" role="presentation"
                                style="border:none;border-radius:5px;cursor:auto;mso-padding-alt:10px 25px 10px 25px;background:#023356;"
                                valign="middle"><a href="https://livelearn.nl/inloggen/"
                                  style="display:inline-block;background:#023356;color:#ffffff;font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px 10px 25px;mso-padding-alt:0px;border-radius:5px;"
                                  target="_blank"><span
                                    style="background-color:transparent;color:#ffffff;font-family:Arial;font-size:14px;">Inloggen</span></a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#FFFFFF" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
        <tbody>
          <tr>
            <td
              style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;">
              <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
              <div class="mj-column-per-100 mj-outlook-group-fix"
                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;"
                  width="100%">
                  <tbody>
                    <tr>
                      <td align="center" vertical-align="top"
                        style="font-size:0px;padding:10px 25px;padding-top:10px;padding-right:25px;padding-bottom:10px;padding-left:25px;word-break:break-word;">
                        <p style="border-top:dotted 1px #c2c2c2;font-size:1px;margin:0px auto;width:100%;"></p><!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-top:dotted 1px #c2c2c2;font-size:1px;margin:0px auto;width:550px;" role="presentation" width="550px" ><tr><td style="height:0;line-height:0;"> &nbsp;
</td></tr></table><![endif]-->
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" bgcolor="#FFFFFF" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    <div style="background:#FFFFFF;background-color:#FFFFFF;margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#FFFFFF;background-color:#FFFFFF;width:100%;">
        <tbody>
          <tr>
            <td
              style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0px;padding-top:0px;text-align:center;">
              <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:top;width:600px;" ><![endif]-->
              <div class="mj-column-per-100 mj-outlook-group-fix"
                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:top;"
                  width="100%">
                  <tbody>
                    <tr>
                      <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
                        <!--[if mso | IE]><table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" ><tr><td><![endif]-->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="float:none;display:inline-table;">
                          <tbody>
                            <tr>
                              <td style="padding:4px;vertical-align:middle;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                  style="background:#3B5998;border-radius:3px;width:20px;">
                                  <tbody>
                                    <tr>
                                      <td style="font-size:0;height:20px;vertical-align:middle;width:20px;"><img
                                          height="20"
                                          src="https://www.mailjet.com/images/theme/v1/icons/ico-social/facebook.png"
                                          style="border-radius:3px;display:block;" width="20"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table><!--[if mso | IE]></td><td><![endif]-->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="float:none;display:inline-table;">
                          <tbody>
                            <tr>
                              <td style="padding:4px;vertical-align:middle;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                  style="background:#1DA1F2;border-radius:3px;width:20px;">
                                  <tbody>
                                    <tr>
                                      <td style="font-size:0;height:20px;vertical-align:middle;width:20px;"><img
                                          height="20"
                                          src="https://www.mailjet.com/images/theme/v1/icons/ico-social/twitter.png"
                                          style="border-radius:3px;display:block;" width="20"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table><!--[if mso | IE]></td><td><![endif]-->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="float:none;display:inline-table;">
                          <tbody>
                            <tr>
                              <td style="padding:4px;vertical-align:middle;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                  style="background:#DD4B39;border-radius:3px;width:20px;">
                                  <tbody>
                                    <tr>
                                      <td style="font-size:0;height:20px;vertical-align:middle;width:20px;"><img
                                          height="20"
                                          src="https://www.mailjet.com/images/theme/v1/icons/ico-social/google-plus.png"
                                          style="border-radius:3px;display:block;" width="20"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table><!--[if mso | IE]></td><td><![endif]-->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="float:none;display:inline-table;">
                          <tbody>
                            <tr>
                              <td style="padding:4px;vertical-align:middle;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                  style="background:#BD081C;border-radius:3px;width:20px;">
                                  <tbody>
                                    <tr>
                                      <td style="font-size:0;height:20px;vertical-align:middle;width:20px;"><img
                                          height="20"
                                          src="https://www.mailjet.com/images/theme/v1/icons/ico-social/pinterest.png"
                                          style="border-radius:3px;display:block;" width="20"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table><!--[if mso | IE]></td><td><![endif]-->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="float:none;display:inline-table;">
                          <tbody>
                            <tr>
                              <td style="padding:4px;vertical-align:middle;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                  style="background:#0077B5;border-radius:3px;width:20px;">
                                  <tbody>
                                    <tr>
                                      <td style="font-size:0;height:20px;vertical-align:middle;width:20px;"><img
                                          height="20"
                                          src="https://www.mailjet.com/images/theme/v1/icons/ico-social/linkedin.png"
                                          style="border-radius:3px;display:block;" width="20"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table><!--[if mso | IE]></td><td><![endif]-->
                        <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                          style="float:none;display:inline-table;">
                          <tbody>
                            <tr>
                              <td style="padding:4px;vertical-align:middle;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                  style="background:#405DE6;border-radius:3px;width:20px;">
                                  <tbody>
                                    <tr>
                                      <td style="font-size:0;height:20px;vertical-align:middle;width:20px;"><img
                                          height="20"
                                          src="https://www.mailjet.com/images/theme/v1/icons/ico-social/instagram.png"
                                          style="border-radius:3px;display:block;" width="20"></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table><!--[if mso | IE]></td></tr></table><![endif]-->
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--[if mso | IE]></td></tr></table><table align="center" border="0" cellpadding="0" cellspacing="0" class="" role="presentation" style="width:600px;" width="600" ><tr><td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;"><![endif]-->
    <div style="margin:0px auto;max-width:600px;">
      <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
        <tbody>
          <tr>
            <td
              style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:20px;padding-top:20px;text-align:center;">
              <!--[if mso | IE]><table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td class="" style="vertical-align:middle;width:600px;" ><![endif]-->
              <div class="mj-column-per-100 mj-outlook-group-fix"
                style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:middle;width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="vertical-align:middle;"
                  width="100%">
                  <tbody>
                    <tr>
                      <td align="left" vertical-align="middle"
                        style="font-size:0px;padding:10px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;">
                        <div
                          style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;">
                          <p class="text-build-content"
                            style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"
                            data-testid="p1wGkfjeZKT7"><span
                              style="color:#55575d;font-family:Arial;font-size:16px;line-height:22px;">This message was
                              sent to [[EMAIL_TO]] as part of our welcome series.</span><br><span
                              style="color:#55575d;font-family:Arial;font-size:16px;line-height:22px;">To stop receiving
                              messages from this series, </span><a class="link-build-content"
                              style="color:inherit;; text-decoration: none;" target="_blank"
                              href="[[WORKFLOW_EXIT_LINK_EN]]"><span
                                style="color:#55575d;font-family:Arial;font-size:16px;line-height:22px;">please
                                unsubscribe here</span></a><span
                              style="color:#55575d;font-family:Arial;font-size:16px;line-height:22px;">.</span></p>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td align="left" vertical-align="middle"
                        style="font-size:0px;padding:10px 25px;padding-top:0px;padding-right:25px;padding-bottom:0px;padding-left:25px;word-break:break-word;">
                        <div
                          style="font-family:Ubuntu, Helvetica, Arial, sans-serif;font-size:13px;line-height:1;text-align:left;color:#000000;">
                          <p style="text-align: center; margin: 10px 0; margin-top: 10px; margin-bottom: 10px;"><span
                              style="font-size:16px;text-align:center;color:#55575d;font-family:Arial;line-height:22px;">
                              NL</span></p>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div><!--[if mso | IE]></td></tr></table><![endif]-->
            </td>
          </tr>
        </tbody>
      </table>
    </div><!--[if mso | IE]></td></tr></table><![endif]-->
  </div>
</body>

</html>';
    $subject = 'Your LiveLearn registration has arrived! ✨';
    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );
    return wp_mail($email, $subject, $mail_invitation_body, $headers, array( '' )) ;
}

function statistic_company($data)
{
    global $wpdb;
    $current_user = intval($data['ID']);
    $company = get_field('company',  'user_' . $current_user);
    $id_current_company = $company[0]->ID;
    $image =  get_field('company_logo',$id_current_company);
    if(!$image) {
        $image = get_the_post_thumbnail_url($id_current_company);

        if (!$image)
            $image = get_field('preview', $id_current_company)['url'];

        if (!$image)
            $image = get_field('url_image_xml', $id_current_company);

        if (!$image)
            $image = get_stylesheet_directory_uri() . '/img/placeholder.png';
    }

    $company[0]->company_image = $image;
    $user_connected = get_user_by('ID', $current_user)->data;
    $user_connected->member_sice = date('Y',strtotime($user_connected->user_registered));
    $user_connected->user_company = $company[0];
    unset($user_connected->user_pass);
    $not_started = $current_user % 10;
    $progress_courses = array(
        'not_started' => $not_started+100,
        'in_progress' => 40,
        'done' => 30,
    );
    $members_active = 5;
    $members_inactive = 5;


    if (!empty($company))
        $company_connected = $company[0]->ID;
    $users = get_users();
    $assessment_validated = array();
    $members = [];
    $new_members = [];
    $date = new DateTime();
    $date_this_month = date('Y-m-d');
    $date_last_month = $date->sub(new DateInterval('P1M'))->format('Y-m-d');
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $topic_in_company = array();
    foreach ($users as $user ) {
        $company = get_field('company',  'user_' . $user->ID);
        if($company)
            if($company[0]->ID == $company_connected) {
                $topic_for_this_user = get_user_meta($user->ID, 'topic');
                if (!empty($topic_for_this_user))
                    $topic_in_company[] = $topic_for_this_user;

                $numbers[] = $user->ID;
                $members[] = $user->data;
                if($user->user_registered < date('Y-m-d', strtotime('-1 month')))
                    $new_members[] = $user;
                    // Assessment
                    $validated = get_user_meta($user->ID, 'assessment_validated');
                foreach($validated as $assessment)
                    if(!in_array($assessment, $assessment_validated))
                        array_push($assessment_validated, $assessment);
            }
        $sql = $wpdb->prepare("SELECT * FROM $table_tracker_views WHERE user_id = ".$user->ID." AND updated_at BETWEEN '".$date_last_month."' AND '".$date_this_month."'");
        $if_user_actif = count($wpdb->get_results($sql));
        if ($if_user_actif) {
            $status = 'Active';
            $members_active = $members_active + 1;
        }
        else
            $members_inactive = $members_inactive + 1;
    }
    $args = array(
        'post_type' => array('course','post'),
        'post_status' => 'publish',
        'author'=>$current_user,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $total_courses = count(get_posts($args));
    /*****************************************************/
    //Topic views
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id IN (" . implode(',', $numbers) . ") AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
    $topic_views = $wpdb->get_results($sql);

    foreach ($topic_views as $topic){
        $subtopic = array();
        $subtopic['id'] = $topic->data_id;
        $subtopic['name'] = (String)get_the_category_by_ID($topic->data_id);
        $subtopic['occurence'] = intval($topic->occurence);
        $image_topic = get_field('image', 'category_'. $topic->data_id);
        $subtopic['image'] = $image_topic ?  : get_stylesheet_directory_uri() . '/img/placeholder.png';
        $most_topics_view[] = $subtopic;
    }
    usort($most_topics_view, function($a, $b) {
        return ($b['occurence']) <=> $a['occurence'];
    });
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

    $enrolled_all_courses = array();
    $args = array(
        'post_status' => array('wc-processing', 'wc-completed'),
        'orderby' => 'date',
        'order' => 'DESC',
        'limit' => -1,
    );
    $bunch_orders = wc_get_orders($args);
    $course_finished = array();
    $enrolled = array();
    $enrolled_courses = array();
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
        'author'=>$current_user
    );
    $most_popular_course = get_posts($args);
    $popular_course = array();
    foreach ($most_popular_course as $course){
        $course->in_progress = $progress_courses['in_progress'];
        $course->done = $progress_courses['done'];
        $course->not_started = $progress_courses['not_started'];
        $course->instructor = get_user_by('ID', $course->post_author)->data->display_name ? : get_user_by('ID', $course->post_author)->data->user_email;
        $course->price = get_field('price',$course->ID) ? : 'Gratis';
        $popular_course[] = $course;
    }
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
    /*****************************************************/
    /*                      /begin topic in  /                      */

    $is_topic_in_company = array();
    foreach ($topic_in_company as $id_topics)
        if (!empty($id_topics))
            foreach ($id_topics as $id_topic)
                $is_topic_in_company[] = $id_topic;

    $occurence = array_count_values($is_topic_in_company);
    $total_occurences = array_sum($occurence);

    $avairages_topics_company = array();
    foreach ($occurence as $key => $value){
        $avairages_topics_company[] = array(
            'name'=>get_the_category_by_ID($key),
            'occurence'=>$value,
            'percentage'=>round(($value / $total_occurences) * 100, 2),
        );
    }

    usort($avairages_topics_company, function($a, $b) {
        return $b['percentage'] <=> $a['percentage'];
    });
    /*                      / /                      */
    $respons = new WP_REST_Response(
        array(
        'user_connected'=>$user_connected,
        'course_categories_topics_finished'=>$avairages_topics_company,
            'firs_tab'=>array(
                'total_members'=>count($members),
                'new_members'=>count($new_members),
                'total_courses'=>$total_courses,
            ),
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
        'most_topics_view'=>$most_topics_view,
        'popular_course'=>$popular_course,
        ));
    $respons->set_status(200);
    return $respons;
}

function statistic_individual($data)
{
    global $wpdb;
    $current_user = intval($data['ID']);
    $company = get_field('company',  'user_' . $current_user);
    $user_connected = get_user_by('ID', $current_user)->data;
    $user_connected->member_sice = date('Y',strtotime($user_connected->user_registered));
    $user_connected->user_company = $company[0];
    unset($user_connected->user_pass);
    $progress_courses = array(
        'not_started' => $current_user%10,
        'in_progress' => 8,
        'done' => 4,
    );
    $members_active = 0;
    $members_inactive = 0;
    $budget_spent = 0;
    $numbers = array();
    $most_topics_view = array();

    if (!empty($company))
        $company_connected = $company[0]->ID;

    $users = get_users();
    $assessment_validated = array();
    $members = [];
    $date = new DateTime();
    $date_this_month = date('Y-m-d');
    $date_last_month = $date->sub(new DateInterval('P1M'))->format('Y-m-d');
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    foreach ($users as $user ) {
        $company = get_field('company',  'user_' . $user->ID);
        $status = 'Inactive';

        $sql = $wpdb->prepare("SELECT * FROM $table_tracker_views WHERE user_id = ".$user->ID." AND updated_at BETWEEN '".$date_last_month."' AND '".$date_this_month."'");
        $if_user_actif = count($wpdb->get_results($sql));
        if ($if_user_actif) {
            $status = 'Active';
            $members_active = $members_active + 1;
        }
        else
            $members_inactive = $members_inactive + 1;

        if(!empty($company))
            if($company[0]->ID == $company_connected) {
                $departments = get_field('departments', $company[0]->ID) ? : array();
                $numbers[] = $user->ID;
                $user->data->status = $status;
                if(empty($departments))
                    $user->data->departement = 'IT';
                else
                    $user->data->departement = $departments[0]['name'];
                $user->data->image = get_field('profile_img',  'user_' . $user->ID) ?: get_stylesheet_directory_uri() . '/img/user.png';
                unset($user->data->user_pass);
                if ($user->ID != $current_user)
                        $members[] = $user->data;
                // Assessment
                    $validated = get_user_meta($user->ID, 'assessment_validated');
                foreach($validated as $assessment)
                    if(!in_array($assessment, $assessment_validated))
                        array_push($assessment_validated, $assessment);
            }
    }

    /*****************************************************/
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
    $enrolled = array();
    $budget_spent = 0;
    $enrolled_courses = array();

    $bunch_orders = wc_get_orders($args);
    // $bunch_orders = array();
    $enrolled = array();
    $enrolled_courses = array();
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
        $progress_courses['not_started'] = $current_user % 10;
    /* assessment doing by this user */
    $args = array(
        'post_type' => 'assessment',
        'post_status' => 'publish',
        'author' => $current_user,
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
        'author__in' => $current_user,
        'posts_per_page'         => -1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
    $mandatories = get_posts($args);
    $count_mandatories_video = (!empty($mandatories)) ? count($mandatories) : 0;
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

    $assessment_not_started = 3;
    $assessment_completed = 2;
    if($count_assessments > 0){
        $not_started_assessment = abs($count_assessments - $assessment_validated);
        $assessment_not_started = intval(($not_started_assessment / $count_assessments) * 100);
        $assessment_completed = intval(($assessment_validated / $count_assessments) * 100);
    }

    //Topic views
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id IN (" . implode(',', $numbers) . ") AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
    $topic_views = $wpdb->get_results($sql);

    foreach ($topic_views as $topic){
        $subtopic = array();
        $subtopic['id'] = $topic->data_id;
        $subtopic['name'] = (String)get_the_category_by_ID($topic->data_id);
        $subtopic['occurence'] = $topic->occurence;
        $image_topic = get_field('image', 'category_'. $topic->data_id);
        $subtopic['image'] = $image_topic ?  : get_stylesheet_directory_uri() . '/img/placeholder.png';
        $most_topics_view[] = $subtopic;
    }
    $respons = new WP_REST_Response(
        array(
            'firs_tab'=>array(
                'budget_spent'=>$budget_spent,
                'course_in_progress'=>$progress_courses['not_started'],
                'your_courses'=>$count_enrolled_courses,
                'course_done'=>$progress_courses['done'],
                'assessment_created'=>$count_assessments_created,
                'mandatories_received'=>$count_mandatories_video,
            ),
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
            ),            'most_topics_view'=>$most_topics_view,
            'other_membre'=>$members
        ));
    $respons->set_status(200);
    return $respons;
}

function statistic_team($data)
{
    global $wpdb;
    $users = get_users();
    $numbers = array();
    $members = array();
    $current_user = intval($data['ID']);
    $company_user = get_field('company',  'user_' . $current_user);
    $assessment_validated = array();
    $member_active = 0;
    $progress_courses = array(
        'not_started' => 7+($current_user%10),
        'in_progress' => 3,
        'done' => 10,
    );
    $members_active = 5;
    $members_inactive = 5;
    $date = new DateTime();
    $date_this_month = date('Y-m-d');
    $date_last_month = $date->sub(new DateInterval('P1M'))->format('Y-m-d');
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    /* Mandatories */
    $args = array(
        'post_type' => 'mandatory',
        'post_status' => 'publish',
        'author' => $current_user,
        'posts_per_page'         => -1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
    $mandatories = get_posts($args);
    $count_mandatories_video = (!empty($mandatories)) ? count($mandatories) : 0;
    /*****************************************************/
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
    if (!empty($company_user))
        $company_connected = $company_user[0]->ID;

    foreach ($users as $user ) {
        if ($user->ID == $current_user)
            continue;
        $company = get_field('company',  'user_' . $user->ID);

        if(!empty($company))
            if($company[0]->ID == $company_connected) {
                $prijs = get_field('price', $user->ID);
                $budget_spent = $prijs;
                $departments = get_field('departments', $company[0]->ID) ? : array();
                $numbers[] = $user->ID;
                $status = 'Inactive';

                $sql = $wpdb->prepare("SELECT * FROM $table_tracker_views WHERE user_id = ".$user->ID." AND updated_at BETWEEN '".$date_last_month."' AND '".$date_this_month."'");
                $if_user_actif = count($wpdb->get_results($sql));
                if ($if_user_actif) {
                    $status = 'Active';
                    $member_active++;
                }

                if(empty($departments))
                    $user->data->departement = 'IT';
                else
                    $user->data->departement = $departments[0]['name'];
                $user->data->status = $status;
                $user->data->personel_budget = $budget_spent ? : 0;

                $user->data->image = get_field('profile_img',  'user_' . $user->ID) ?: get_stylesheet_directory_uri() . '/img/user.png';
                unset($user->data->user_pass);
                $members[] = $user->data;
                $validated = get_user_meta($user->ID, 'assessment_validated');
                foreach($validated as $assessment)
                    if(!in_array($assessment, $assessment_validated))
                        array_push($assessment_validated, $assessment);
            }
    }
    //Topic views
    //$table_tracker_views = $wpdb->prefix . 'tracker_views';
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id IN (" . implode(',', $numbers) . ") AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
    $topic_views = $wpdb->get_results($sql);
    $enrolled = array();
    $budget_spent = 0;
    $enrolled_courses = array();

    $most_topics_view = [];
    foreach ($topic_views as $topic){
        $subtopic = array();
        $subtopic['id'] = $topic->data_id;
        $subtopic['name'] = (String)get_the_category_by_ID($topic->data_id);
        $subtopic['occurence'] = $topic->occurence;
        $image_topic = get_field('image', 'category_'. $topic->data_id);
        $subtopic['image'] = $image_topic ?  : get_stylesheet_directory_uri() . '/img/placeholder.png';
        $most_topics_view[] = $subtopic;
    }
    $bunch_orders = wc_get_orders($args);
    // $bunch_orders = array();
    $enrolled = array();
    $enrolled_courses = array();
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
    $args = array(
        'post_type' => array('course','post'),
        'post_status' => 'publish',
        'author'=>$current_user,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $total_courses = count(get_posts($args));
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
    $assessment_not_started = 3;
    $assessment_completed = 2;
    if($count_assessments > 0){
        $not_started_assessment = abs($count_assessments - $assessment_validated);
        $assessment_not_started = intval(($not_started_assessment / $count_assessments) * 100);
        $assessment_completed = intval(($assessment_validated / $count_assessments) * 100);
    }
    /* assessment doing by this user */
    $args = array(
        'post_type' => 'assessment',
        'post_status' => 'publish',
        'author' => $current_user,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $assessments_created = get_posts($args);
    $count_assessments_created = (!empty($assessments_created)) ? count($assessments_created) : 0;

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
            'team_first_card'=>array(
                'total_members'=>count($members),
                'all_courses'=>$total_courses,
                'assessment'=>($assessment_validated),
                'courses_done'=>$progress_courses['done'] ? : (6+$current_user%10),
                'mandatories'=>$count_mandatories_video ? : (8+$current_user%10),
                'member_actif'=> $member_active ? : (3+$current_user%10),
            ),
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
            'team_managed'=>$members,
            'most_topics_view'=>$most_topics_view,
        )
    );
    $response->set_status(200);
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
            'departments'=>array_reverse($departments),
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

function addOnePeople(WP_REST_Request $data)
{
    $required_parameters = ['email','first_name','last_name'];
    $errors = validated($required_parameters, $data);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    $email = $data['email'];
    $user_connected = intval($data['id']);
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];

        $login = RandomStringBis();
        $password = "Livelearn".date('Y');

        $userdata = array(
            'user_pass' => $password,
            'user_login' => $login,
            'user_email' => $email,
            'user_url' => 'https://app.livelearn.nl/login',
            'display_name' => $first_name,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => 'subscriber'
        );
        $user_id = wp_insert_user(wp_slash($userdata));
        if(is_wp_error($user_id))
            return new WP_REST_Response(
                array(
                    'message' => "An error occurred while creating the emails, please ensure that all emails do not already exist."
                ), 401);


        $guest = get_user_by('ID', $user_connected);
        $company = get_field('company',  'user_' . $guest->ID);
        //update_field('degree_user', $choiceDegrees, 'user_' . $user_id);
        update_field('company', $company[0], 'user_'.$user_id);

        //sendEmail($user_connected,$email,$first_name);
        $response = new WP_REST_Response(
                    array(
                        'message' => 'You have successfully created a new employee ✔️'
                    ));
        $response->set_status(200);
        return $response;
}
function addManyPeople(WP_REST_Request $data)
{
    $user_connected = intval($data['id']);
    $required_parameters = ['emails'];
    $errors = validated($required_parameters, $data);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    $emails = $data['emails'];

    if(!empty($emails))
        foreach($emails as $email){
            $login = RandomStringBis();
            $first_name = RandomStringBis();
            $last_name = RandomStringBis();

            $password = "Livelearn".date('Y');

            $userdata = array(
                'user_pass' => $password,
                'user_login' => $login,
                'user_email' => $email,
                'user_url' => 'https://app.livelearn.nl/login',
                'display_name' => $first_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => 'subscriber'
            );

            $user_id = wp_insert_user(wp_slash($userdata));
            if(is_wp_error($user_id)){
                $danger = "An error occurred while creating the emails, please ensure that all emails do not already exist.";
                return new WP_REST_Response(array(
                    'message' => $danger
                ), 401);
            }

            $company = get_field('company',  'user_' . $user_connected);
            //update_field('degree_user', $choiceDegrees, 'user_' . $user_id);
            update_field('company', $company[0], 'user_'.$user_id);

            // send email new user
            sendEmail($user_connected, $email, $first_name);
        }
    $response = new WP_REST_Response(
        array(
            'message' => 'You have successfully created new employees ✔️'
        ));
    $response->set_status(200);
    return $response;
}

function detailsPeopleSkillsPassport($data){
    global $wpdb;
    $id_user = $data['userID'] ?: null;      
    $user = get_users(array('include'=> $id_user))[0]->data;
    $progress_courses = array(
        'not_started' => 0,
        'in_progress' => 0,
        'done' => 0,
    );
    $company_connected = get_field('company',  'user_' . $id_user);
    $company_connected_id = $company_connected[0]->ID;
    $company_name = $company_connected[0]->post_title;

    $numbers = [];
    $assessment_validated = array();
    $enrolled_all_courses = array();
    $users = get_users();
    //Note
    $key_skills_note = array();
    $skills_note = get_field('skills', 'user_' . $id_user);
    foreach (array() as $skill) {
    //foreach ($skills_note as $skill) {
        $skills = [];
        $skills['name'] = (string)get_the_category_by_ID($skill['id']);
        $skills['note'] = $skill['note'];
        $key_skills_note[] = $skills;
    }
    $count_skills_note  = (empty($skills_note)) ? 0 : count($skills_note);
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    foreach ($users as $user ) {
        $company = get_field('company',  'user_' . $user->ID);

        if(!empty($company))
            if($company[0]->ID == $company_connected_id) {
                $numbers[] = $user->ID;
                // Assessment
                $validated = get_user_meta($user->ID, 'assessment_validated');
                foreach($validated as $assessment)
                    if(!in_array($assessment, $assessment_validated))
                        array_push($assessment_validated, $assessment);
            }
    }
    /* Mandatories */
    $args = array(
        'post_type' => array('mandatory','feedback'),
        'post_status' => 'publish',
        'author__in' => $numbers,
        'posts_per_page'         => -1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
    $mandatories = get_posts($args);
    //$count_mandatories_video = (!empty($mandatories)) ? count($mandatories) : 0;
    $count_mandatories = (!empty($mandatories)) ? count($mandatories) : 1;

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
    $count_mandatory_done = 1;
    $score_rate = 0;
    $score_rate_max = 0;
    $count_feedback_received = count($mandatories);

    foreach($mandatories as $todo):

        $type = (get_field('type_feedback', $todo->ID)) ?: 'Mandatory';
        $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));
        if (!$manager)
            continue;

        $image = get_field('profile_img',  'user_' . $manager->ID);
        if(!$image)
            $image = get_stylesheet_directory_uri() . '/img/Group216.png';

        $display = $manager->first_name ? : $manager->display_name;
        $display = ($user->ID == $manager->ID) ? 'You' : $display;

        $display = ($display) ?: 'Anonymous';

        $post_date = date("d M Y | h:i", strtotime($todo->post_date));
        $due_date = get_field('welke_datum_feedback', $todo->ID);
        $due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';

        $title_todo = get_field('title_todo', $todo->ID);
        $title = ($title_todo) ?: $todo->post_title;

        $rating = get_field('rating_feedback', $todo->ID);
        $max_rate = 0;
        $stars = 0;
        if($type == 'Beoordeling Gesprek'){
            $rates_comment = explode(';', get_field('rate_comments', $todo->ID));
            if($rates_comment){
                $max_rate = count($rates_comment);
                $count_rate = 0;
                $stars = 0;
                for($i=0; $i<$max_rate; $i++){
                    $stars = $stars + intval($rates_comment[$i+1]);
                    $count_rate += 1;
                    $i = $i + 2;
                }

                if($count_rate){
                    $rating = intval($stars / $count_rate);
                }
            }
        }

        if($rating){
            $score_rate += $rating;
            $score_rate_max++;
        }
    endforeach;
    //Feedback given by company
    $todos_company = get_posts($args);
    $score_rate_company = 0;
    $score_rate_max_company = 0;
    $score_rate_feedback_company = 1;
    $count_feedback_given = 0;
    foreach($mandatories as $todo){
        if ($todo->post_type != 'feedback')
            continue;
        $count_feedback_given +=1;
        $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));
        if ($manager)
            if(!in_array($manager->ID, $numbers))
                continue;

        $rating = get_field('rating_feedback', $todo->ID);

        $max_rate = 0;
        $stars = 0;
        if($type == 'Beoordeling Gesprek'){
            $rates_comment = explode(';', get_field('rate_comments', $todo->ID));
            if($rates_comment){
                $max_rate = count($rates_comment);
                $count_rate = 0;
                $stars = 0;
                for($i=0; $i<$max_rate; $i++){
                    $stars = $stars + intval($rates_comment[$i+1]);
                    $count_rate += 1;
                    $i = $i + 2;
                }

                if($count_rate){
                    $rating = intval($stars / $count_rate);
                }
            }
        }
        if($rating){
            $score_rate_company += intval($rating);
            $score_rate_max_company += 1;
        }
    }
    if($score_rate_max_company)
        $score_rate_feedback_company = $score_rate_company / $score_rate_max_company;

    $score_rate_feedback = 1;
    if($score_rate_max)
        $score_rate_feedback = $score_rate / $score_rate_max;

    //Orders - enrolled courses
    $budget_spent = 0;
    $args = array(
        'customer_id' => $id_user,
        'post_status' => array('wc-processing', 'wc-completed'),
        'orderby' => 'date',
        'order' => 'DESC',
        'limit' => -1,
    );
    $bunch_orders = wc_get_orders($args);
    //$bunch_orders = array();
    $enrolled = array();
    $enrolled_courses = array();
    foreach($bunch_orders as $order){
        foreach ($order->get_items() as $item_id => $item ) {
            $progressions = array();

            //Get woo orders from user
            $course_id = intval($item->get_product_id()) - 1;
            $course = get_post($course_id);

            $prijs = get_field('price', $course_id);
            $budget_spent += $prijs;
            // array_push($enrolled_all_courses, $course_id);
            if(!in_array($course_id, $enrolled)){
                array_push($enrolled, $course_id);
                array_push($enrolled_courses, $course);
                //Get progresssion this course
                $args = array(
                    'post_type' => 'progression',
                    'title' => $course->post_name,
                    'post_status' => 'publish',
                    'author' => $id_user,
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false
                );
                $progressions = get_posts($args);
                $status = "new";
                if(!empty($progressions)){
                    $status = "in_progress";
                    $progression_id = $progressions[0]->ID;
                    //Finish read
                    $is_finish = get_field('state_actual', $progression_id);
                    if($is_finish) {
                        $status = "done";
                        $count_mandatory_done += 1;
                        $pourcentage = 100;
                    }
                }

                switch ($status) {

                    case 'new':
                        $progress_courses['not_started'] += 1;
                        break;

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
    $count_enrolled_courses = (!empty($enrolled_courses)) ? count($enrolled_courses) : 0;
    $progress_courses['not_started'] = $count_enrolled_courses - ($progress_courses['in_progress'] + $progress_courses['done']);
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
    $most_popular = array_keys($most_popular);
    $args = array(
        'post_type' => 'course',
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => $most_popular,
    );
    $most_popular_course = get_posts($args);

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
    $assessment_not_started = 100;
    $assessment_completed = 0;
    if($count_assessments > 0){
        $not_started_assessment = $count_assessments - $assessment_validated;
        $assessment_not_started = intval(($not_started_assessment / $count_assessments) * 100);
        $assessment_completed = intval(($assessment_validated / $count_assessments) * 100);
    }

    //Course views
    $sql_course = $wpdb->prepare("SELECT data_id FROM $table_tracker_views WHERE user_id = " . $id_user . " AND data_type = 'course'");
    $course_views = $wpdb->get_results($sql_course);
    $count_course_views = (!empty($course_views)) ? count($course_views) : 0;


    $external_learning_opportunities = 0;
    foreach ($course_views as $value) {
        $course = get_post($value->data_id);
        if ($course) {
            $company_author_course = get_field('company', 'user_' . $course->post_author);
            $company_author_course = $company_author_course ? $company_author_course[0]->post_title : 'Livelearn';

            if ($company_name != $company_author_course)
                $external_learning_opportunities += 1;
        }
    }

//Graph stat web-mobile
    $first_day_year = date('Y') . '-' . '01-01 ' . '00:00:00';
    $last_day_year = date('Y') . '-' . '12-31 ' . '00:00:00';

    $sql_interaction_web = $wpdb->prepare("SELECT MONTH(created_at) as monthly, count(*) as interaction 
FROM $table_tracker_views 
WHERE user_id = '" . $id_user . "' AND platform = 'web' 
AND created_at >= '" .$first_day_year. "' AND created_at <= '" .$last_day_year. "'
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
");
    $data_interaction_web = $wpdb->get_results($sql_interaction_web);

    $sql_interaction_mobile = $wpdb->prepare("SELECT MONTH(created_at) as monthly, count(*) as interaction 
        FROM $table_tracker_views 
        WHERE user_id = '" . $id_user. "' AND platform = 'mobile' 
        AND created_at >= '" .$first_day_year. "' AND created_at <= '" .$last_day_year. "'
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $data_interaction_mobile = $wpdb->get_results($sql_interaction_mobile)[0];

    $data_web = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $data_mobile = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    if(!empty($data_interaction_web))
        foreach ($data_interaction_web as $web)
            if($web->monthly)
                $data_web[$web->monthly] = $web->interaction;
    if(!empty($data_interaction_mobile))
        foreach ($data_interaction_mobile as $mobile)
            $data_mobile[$mobile->monthly] = $mobile->interaction;

    $canva_data_web = join(',', $data_web);
    $canva_data_mobile = join(',', $data_mobile);

    $topics_internal = get_user_meta($id_user, 'topic_affiliate');
    $read_learning = array();
    if(!empty($topics_internal))
    foreach($topics_internal as $key => $learning):
        if(!$learning && !in_array($learning, $read_learning))
            continue;
        //$learning->link_stat = get_category_link($learning);
        array_push($read_learning, $learning);
    endforeach;
   
    $followed_topics = array();
    //Get Topics
    $topics_external = get_user_meta($id_user, 'topic');
    $topics_internal = get_user_meta($id_user, 'topic_affiliate');
    $topics = array();
    if(!empty($topics_external))
        $topics = $topics_external;

    if(!empty($topics_internal))
        foreach($topics_internal as $item)
            array_push($topics, $item);

    if(!empty($topics)){
        $args = array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'include'  => $topics,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        );
        $followed_topics = get_categories($args);
        //$image_topic = get_field('image', 'category_'. $topic->data_id);
        //$subtopic['image'] = $image_topic ?  : get_stylesheet_directory_uri() . '/img/placeholder.png';
    }
    /* // */

    $dataResponse = array(
        'statistic'=>array(
            'training_costs' => $budget_spent,
            'courses_progression'=> $progress_courses,
            'mandatory_courses_done'=> $count_mandatory_done . "/" . $count_mandatories,
            'assessments_done' => $assessment_validated,
            'self_assessment_of_skills'=> $count_skills_note,
            'external_learning_opportunities' => $external_learning_opportunities,
            'average_feedback_given_me_team'=> $score_rate_feedback ."/". $score_rate_feedback_company,
            'usage_desktop_vs_mobile_app' => 
            array(
                'web' => $canva_data_web,
                'mobile' => $canva_data_mobile
            ),
            // 'badge' =>$achievements,
            'most_popular_courses' => $most_popular_course,
            'most_viewed_topics' => $read_learning,
            'key_skill_development_progress' => $key_skills_note,
            'tab_after_skills_dev' => array(
                'learning_delivery_method' => $count_course_views,
                'count_feedback_received' => $count_feedback_received,
                'count_feedback_given' => $count_feedback_given,
                // 'latest_badges'=>$badges,
            ),
            'followed_topics' => $followed_topics
        ),
    );

    return new WP_REST_Response($dataResponse,200);
}


function newCoursesByTeacher(WP_REST_Request $data)
{
    $id = intval($data['id']);
    $course_type = $data['course_type'];
    $required_parameters = ['course_type'];
    $price = $data['price'];

    $errors = validated($required_parameters, $data);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    if (!get_user_by('ID', $id))
        return new WP_REST_Response(
            array(
                'message' => 'User not found',
            ),401 );
    $types = ['Assessment' => 'assessment', 'Article'=>'post', 'Video' => 'course','Podcast'=>'course'];
    $type = $types[$course_type];
    $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'post_title' => $data['title'],
            'post_author' => $id,
        );
    $id_post = wp_insert_post($args, true);
    if(is_wp_error($id_post)){
        $error = new WP_Error($id_post);
        return new WP_REST_Response(
            array(
            'message' => $error->get_error_message($id_post),
        ),401);
    }
    update_field('course_type', $course_type , $id_post);
    if ($price)
        update_field('price', $price , $id_post);

    $response = new WP_REST_Response(
    array(
        'new_course_added'=>get_post($id_post,true),
        'message'=> 'course saved success...',
    ));
    $response->set_status(201);
    return $response;
}
function updateCoursesByTeacher(WP_REST_Request $data)
{
    $id_course = $data['id_course'];

    //$type_course = get_field('course_type',$id_course);
    $course_type = ucfirst($data['course_type']);
    $isCourseUpdated = false;
    $article_content = $data['article_content'];
    $visibility = $data['visibility']; // checkbox : true or false ?
    $categories = $data['categories'];
    $course = get_post($id_course);
    $questions = $data['questions']; // for assessments
    $how_it_works = $data['how_it_works'];
    $languageAssessment = $data['language_assessment'];
    $difficultyAssessment = $data['difficulty_assessment'];
    $long_description = $data['long_description']; //Totale beschrijving,
    $short_description = $data['short_description'];
    $experts = $data['experts']; // Must be an array ["875","98489"]...
    $for_who = $data['for_who']; //for_who, Voor wie,
    $agenda = $data['agenda']; // Programma, agenda
    $results = $data['results']; // Resultaten, results
    $incompany_mogelijk = $data['incompany_mogelijk']; // In-company possible
    $geacrediteerd = $data['geacrediteerd']; // accredited, Geaccrediteerd
    $btwKlasse = $data['btw-klasse'];
    if (!$course)
        return new WP_REST_Response( array('message' => 'id not matched with any course...',), 401);

    if ($article_content) {
        update_field('article_itself', $article_content, $id_course);
        $isCourseUpdated = true;
    }
    if ($visibility) {
        update_field('visibility', $visibility, $id_course);
        $isCourseUpdated = true;
    }
    if ($categories){
        update_field('categories', $categories , $id_course);
        $isCourseUpdated = true;
    }
    if ($experts){
        $all_experts = get_filed('experts', $id_course) ? : [];
        $experts = array_merge($experts,$all_experts);
        $experts = array_unique($experts);
        update_field('experts', null, $id_course);
        update_field('experts', $experts, $id_course);
        $isCourseUpdated = true;
    }
    if ($questions){
        update_field('question', $questions, $id_course);
        $isCourseUpdated = true;
    }
    if ($how_it_works){
        update_field('how_it_works',$how_it_works,$id_course);
        $isCourseUpdated = true;
    }
    if ($languageAssessment){
        update_field('language_assessment', $languageAssessment, $id_course);
        $isCourseUpdated = true;
    }
    if ($difficultyAssessment){
        update_field('difficulty_assessment', $difficultyAssessment, $id_course);
        $isCourseUpdated = true;
    }
    if ($short_description){
        update_field('short_description', $short_description, $id_course);
        $isCourseUpdated = true;
    }
    if ($long_description){
        update_field('long_description', $long_description, $id_course);
        $isCourseUpdated = true;
    }
    if ($for_who){
        update_field('for_who', $for_who, $id_course);
        $isCourseUpdated = true;
    }
    if ($agenda){
        update_field('agenda', $agenda, $id_course);
        $isCourseUpdated = true;
    }
    if ($results){
        update_field('results', $results, $id_course);
        $isCourseUpdated = true;
    }

    if ($isCourseUpdated) {
        $response = new WP_REST_Response(
            array(
                'message' => 'course updated success...',
                'course' => get_post($id_course,true),
            ));
        $response->set_status(201);
        return $response;
    }
    return new WP_REST_Response( array('message' => 'course not updated...',), 401);
}

function deleteCourse($data)
{
    $id_course = $data['id'];
        $post = get_post($id_course);
        if($post)
            if (wp_trash_post($post->ID))
                return new WP_REST_Response(
                    array('message'=>"course $id_course deleted successfully ! ! !"),
                    200);

        return new WP_REST_Response(array('message' => "course not deleted ! ! !"),401);
}

function search_courses()
{
    $search = $_GET['search'];
    if (!$search)
        return new WP_REST_Response(
            array(
            'message' => 'key search must be signed in the url'
        ),401 );

    $args = array(
        'post_type' => array('course', 'post','assessment'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        's' => $search,
        'orderby' => 'date',
        'order' => 'ASC',
    );
    $courses_founded = get_posts($args);
    $courses_searched = array();
    foreach ($courses_founded as $course){
        $course->visibility = get_field('visibility',$course->ID) ?? [];
        $author = get_user_by( 'ID', $course -> post_author  );
        $author_img = get_field('profile_img','user_'.$author ->ID) != false ? get_field('profile_img','user_'.$author ->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        $course-> author = new Expert ($author , $author_img);
        $course->longDescription = get_field('long_description',$course->ID);
        $course->shortDescription = get_field('short_description',$course->ID);

        $course->courseType = get_field('course_type', $course->ID);
        $image = get_field('preview', $course->ID)['url'];
        if(!$image){
            $image = get_the_post_thumbnail_url($course->ID);
            if(!$image)
                $image = get_field('url_image_xml', $course->ID);
            if(!$image)
                $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->courseType) . '.jpg';
        }
        $course->pathImage = $image;

        $new_course = new Course($course);
        array_push($courses_searched, $new_course);
    }
    return new WP_REST_Response( array(
        'count_courses' => count($courses_searched),
        'courses' => $courses_searched,
    ), 200);
}

function coursesRecommendedUpcomming($data)
{
    $info = recommendation($data['id'], 2000, 150);
    return new WP_REST_Response($info, 200);
}

function subscription_organisation($data){
    $required_parameters = ['firstName','lastName','email','company','company_size'];
    $errors = validated($required_parameters, $data);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
        $userdata = array(
            'user_pass' => $data['password']?:'livelearn'.date('Y'),
            'user_login' => $data['email'],
            'user_email' => $data['email'],
            'user_url' => 'http://app.livelearn.nl/',
            'display_name' => $data['firstName'] . ' ' . $data['lastName'],
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'role' => 'Manager',
        );

        $user_id = wp_insert_user($userdata);
        if (is_wp_error($user_id)) {
            return new WP_REST_Response(
                array(
                    'message' => $user_id->get_error_message(),
                    'status' => 401
                ),401);
        }
        //update phone number
        if ($data['telephone'])
            update_field('telnr', $data['telephone'], 'user_' . $user_id);

        //create a new company for the new user
        $company_id = wp_insert_post(
            array(
                'post_title' => $data['company'],
                'post_type' => 'company',
                'post_status' => 'pending',
            ));
        if($data['company_size'])
            update_field('company_size',$data['company_size'], $company_id);
        $company = get_post($company_id);
        update_field('company', $company, 'user_' . $user_id);
        $user = get_user_by('ID', $user_id);
        if ($user) {
            $user = $user->data;
            $user->company = $company;
            unset($user->user_pass);
        }
        return new WP_REST_Response(
            array(
                'message' => 'User saved success and company already created.',
                'user' => $user,
            ),200);
}
function addAchievement($data)
{
    $required_parameters = ['title','type','level'];
    $errors = validated($required_parameters, $data);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    $id = $data['id'];
    $title = $data['title'];
    $type = $data['type']; // type_badge : Diploma,Prestatie,Certificaat,Genuine=Badge
    $level = $data['level']; //level_badge
    $trigger = $data['how_the_badge_achieved']; // how_the_badge_achieved, Describe the Performance, How was this badge achieved?
    $vervalt_badge = $data['vervalt_badge']; // vervalt_badge : true or false
    $for_what_day = $data['begin_date']; // voor_welke_datum_badge, begin date
    $and_what_date = $data['end_date']; // ot_welke_datum_badge, end date
    $about = $data['about_competencies']; // competencies_badge
    $comment = $data['comment']; // opmerkingen_badge
    //Certificate
    $issuedBy = $data['issued_by']; // uitgegeven_door_badge
    $providerUrl = $data['provider_url']; //url_aanbieder_badge
    $certificate_number_if_applicable = $data['certificate_number_if_capable']; // certificaatnummer_badge
    $hours = $data['hours']; // uren_badge, hours
    $points = $data['points']; // punten_badge, points

    $args = array(
        'post_type' => 'badge',
        'post_status' => 'publish',
        'post_title' => $title,
        'post_author' => $id,
    );
    $id_post = wp_insert_post($args, true);
    if(is_wp_error($id_post)){
        $error = new WP_Error($id_post);
        return new WP_REST_Response(
            array(
            'message' => $error->get_error_message($id_post),
             'status' => 401
        ), 401);
    }
    if ($type)
        update_field('type_badge', $type , $id_post);
    if ($level)
        update_field('level_badge', $level , $id_post);
    if ($issuedBy)
        update_field('uitgegeven_door_badge', $issuedBy , $id_post);
    if ($providerUrl)
        update_field('url_aanbieder_badge', $providerUrl , $id_post);
    if ($certificate_number_if_applicable)
        update_field('certificaatnummer_badge', $certificate_number_if_applicable , $id_post);
    if ($hours)
        update_field('uren_badge', $hours , $id_post);
    if ($points)
        update_field('punten_badge', $points , $id_post);

    update_field('trigger_badge', $trigger , $id_post);
    update_field('voor_welke_datum_badge', $for_what_day , $id_post);
    update_field('ot_welke_datum_badge', $and_what_date , $id_post);
    update_field('vervalt_badge', $vervalt_badge , $id_post);
    update_field('competencies_badge', $about , $id_post);
    update_field('opmerkingen_badge', $comment , $id_post);

    $badge = get_post($id_post,true);
    if ($badge) {
        $badge->comment = get_field('opmerkingen_badge', $badge->ID)?:'';
        $badge->level = get_field('level_badge', $badge->ID)?:'';
        $badge->type = get_field('type_badge', $badge->ID)?:'';
        $badge->trigger_badge = get_field('trigger_badge', $badge->ID)?:'';
        $badge->begin_date = get_field('voor_welke_datum_badge', $badge->ID)?:'';
        $badge->end_date = get_field('ot_welke_datum_badge', $badge->ID)?:'';
        $badge->vervalt_badge = get_field('vervalt_badge', $badge->ID)?:'';
        $badge->about_competencies = get_field('competencies_badge', $badge->ID)?:'';
        $badge->author = get_user_by('ID', $badge->post_author) ? get_user_by('ID', $badge->post_author)->data : null;
        unset($badge->author->user_pass);
        $badge->issued_by = get_field('uitgegeven_door_badge', $badge->ID)?:'';
        $badge->provider_url = get_field('url_aanbieder_badge', $badge->ID)?:'';
        $badge->certificate_number_if_capable = get_field('certificaatnummer_badge', $badge->ID)?:'';
        $badge->hours = get_field('uren_badge', $badge->ID)?:'';
        $badge->points = get_field('punten_badge', $badge->ID)?:'';
    }
    $response = new WP_REST_Response(
    array(
        'message'=> 'badge saved success...',
        'new_badge'=>$badge,
    ));
    $response->set_status(201);
    return $response;
}

function addFeedback($data)
{
    $required_parameters = ['title','type','rating'];
    $errors = validated($required_parameters, $data);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;
    $id = $data['id'];
    $title = $data['title'];
    $type = $data['type']; // Feedback = Feedback,Development Plan = Persoonlijk ontwikkelplan,Beoordeling Gesprek = Assessment,Compliment=Compliment
    //$manager = $data['manager']; // manager_feedback
    $rating = $data['rating']; // rating_feedback
    $rate_comments = $data['comments']; // rate_comments
    $description = $data['description']; //Describe the Feedback, beschrijving_feedback
    $competencies = $data['competencies']; // competencies_feedback, Competencies Related to Feedback,Competencies Related to Assessment
    $anoniem_feedback = $data['anonymously']; // anoniem_feedback, Anonymous feedback,Send Anonymously? : true or false

    //Development Plan
    $what_achieve = $data['what_achieve']; // je_bereiken, What Do You Want to Achieve?
    $how_achieved = $data['how_achieved']; // je_dit_bereike, How Do You Think This Can Best Be Achieved?
    $need_help = $data['need_help']; // hulp_nodig, Need Help? : true or false
    //Assessment
    $general_assessment_competencies = $data['general_assessment_competencies']; // algemene_beoordeling, General Assessment of Competencies
    $welke_datum_feedback = $data['welke_datum_feedback']; // welke_datum_feedback
    $comments_assessment = $data['comments_assessment']; // opmerkingen
    $user_role = get_users(array('include'=> $id))[0]->roles;
    $managed = get_field('managed',  'user_' . $id);
    if ($managed)
        if (in_array($id,$managed))
            $superior = get_users(array('include'=> $id))[0]->data;
    $manager = $superior ? $superior->ID : $id;

    $args = array(
        'post_type' => 'feedback',
        'post_status' => 'publish',
        'post_title' => $title,
        'post_author' => $id,
    );
    $id_post = wp_insert_post($args, true);
    if(is_wp_error($id_post)){
        $error = new WP_Error($id_post);
        return new WP_REST_Response(
            array(
            'message' => $error->get_error_message($id_post),
            'status' => 401
        ),401);
    }
    if ($manager)
        update_field('manager_feedback', $manager, $id_post);
    if ($type)
        update_field('type_feedback', $type , $id_post);
    if ($rating)
        update_field('rating_feedback', $rating , $id_post);
    if ($rate_comments)
        update_field('rate_comments', $rate_comments , $id_post);
    if ($description)
        update_field('beschrijving_feedback', $description , $id_post);
    if ($competencies)
        update_field('competencies_feedback', $competencies , $id_post);
    if ($anoniem_feedback)
        update_field('anoniem_feedback', $anoniem_feedback , $id_post);
    //Development Plan
    if ($what_achieve)
        update_field('je_bereiken', $what_achieve , $id_post);
    if ($how_achieved)
        update_field('je_dit_bereike', $how_achieved, $id_post);
    if ($need_help)
        update_field('hulp_nodig', $need_help , $id_post);
    if($general_assessment_competencies)
        update_field('algemene_beoordeling', $general_assessment_competencies , $id_post);
    if ($welke_datum_feedback)
        update_field('welke_datum_feedback', $welke_datum_feedback , $id_post);
    if($comments_assessment)
        update_field('opmerkingen', $comments_assessment , $id_post);
    // Send notification
    sendPushNotification($title,$description);

    $feedback = get_post($id_post,true);
    $custom_fields = get_post_custom($id_post);
    foreach ($custom_fields as $key => $value) {
        $feedback->$key = $value[0];
    }
    return new WP_REST_Response(
        array(
            'message' => 'feedback saved success...',
            'new_feedback' => $feedback,
        ),201);
}