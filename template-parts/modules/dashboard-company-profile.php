<?php

if(isset($_GET['manager'])){
    if(isset($_GET['id']))
        $id_user = $_GET['id'];
    
    if(isset($id_user)){
        $managed = get_field('managed',  'user_' . get_current_user_id());
        if(!empty($managed))
            if(in_array($id_user, $managed))
                $superior = get_users(array('include'=> $_GET['manager']))[0]->data;
    }
}else{ 
    if(isset($_GET['id']))
        $id = intval($_GET['id']);
    if(isset($id))
        if(gettype($id) == 'integer')
            if($id > 0)
                $id_user = $id;
}

if(!isset($id_user))
    $id_user = get_current_user_id();

$user = get_user_by('ID', $id_user);

//CONNECTED USER INFORMATIONS
$user_connected = wp_get_current_user();

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';
    
$company = get_field('company',  'user_' . $user->ID);
$function = get_field('role',  'user_' . $user->ID);
$experience = get_field('experience',  'user_' . $user->ID);
$country = get_field('country',  'user_' . $user->ID);

$date_born = get_field('date_born',  'user_' . $user->ID);
if(!$date_born)
    $date_birth =  "No birth";
else{
    //explode the date to get month, day and year
    $birthDate = explode("/", $date_born);
    //get age from date or birthdate
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")
        ? ((date("Y") - $birthDate[2]) - 1)
        : (date("Y") - $birthDate[2]));

    $age .= ' Years';
} 

$gender = get_field('gender',  'user_' . $user->ID);
$education_level = get_field('education_level',  'user_' . $user->ID);
$languages = get_field('language',  'user_' . $user->ID);
$biographical_info = get_field('biographical_info',  'user_' . $user->ID);
$phone = get_field('telnr',  'user_' . $user->ID);

$stackoverflow = get_field('stackoverflow',  'user_' . $user->ID);
$github = get_field('github',  'user_' . $user->ID);
$facebook = get_field('facebook',  'user_' . $user->ID);
$twitter = get_field('twitter',  'user_' . $user->ID);
$linkedin = get_field('linkedin',  'user_' . $user->ID);
$instagram = get_field('instagram',  'user_' . $user->ID);
$discord = get_field('discord',  'user_' . $user->ID);
$tik_tok = get_field('tik_tok',  'user_' . $user->ID);

$experiences = get_field('work',  'user_' . $user->ID);
$educations = get_field('education',  'user_' . $user->ID);
$portfolios = get_field('portfolio',  'user_' . $user->ID);
$awards = get_field('awards',  'user_' . $user->ID);

/*
* * Feedbacks
*/
$args = array(
    'post_type' => 'feedback', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);
$todos = get_posts($args);

$args = array(
    'post_type' => 'feedback', 
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);
$todos_all = get_posts($args);

$score_rate = 0;
$score_rate_max = 0;
$count_feedback_given = 0; 
$count_feedback_received = count($todos); 
foreach($todos_all as $todo){
    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

    if($manager->ID != $user->ID)
        continue;

    $count_feedback_given += 1;

    $rating = get_field('rating_feedback', $todo->ID);
    // $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';

    $max_rate = 0;
    $stars = 0;
    if($type == 'Beoordeling Gesprek'){
        $rates_comment = explode(';', get_field('rate_comments', $todo->ID));
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
            // $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';
        }
    }

    if($rating){
        $score_rate += $rating;
        $score_rate_max++;
    }
}

$score_rate_feedback = 0;
if($score_rate_max)
    $score_rate_feedback = $score_rate / $score_rate_max;

if(!empty($company))
    $company_name = $company[0]->post_title;

//Skills 
$topics_external = get_user_meta($user->ID, 'topic');
$topics_internal = get_user_meta($user->ID, 'topic_affiliate');
$count_topics_external = (!empty($topics_external)) ? count($topics_external) : 0;

$topics_user = array();
if(!empty($topics_external))
    $topics_user = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics_user, $value);

//Note
$skills_note = get_field('skills', 'user_' . $user->ID);

$experts = get_user_meta($user->ID, 'expert');

$user_role = get_users(array('include'=> $id_user))[0]->roles;

$statikien_bool = false;
if(isset($_GET['manager']))
    if(!in_array('administrator', $user_role))
        if(isset($superior) || in_array('hr', $user_connected->roles) || in_array('administrator', $user_connected->roles) )
            $statikien_bool = true;

//Stastikien information
if($statikien_bool):
    // $users = get_users();
    // $numbers = array(); 
    // $members = array();
    // $numbers_count = array();
    // $numbers = get_field('managed' ,'user_' . $user->ID);
    // $numbers = array_map('intval', $numbers);
    // foreach ($users as $user ) {
    //     if($user->ID  == $user->ID)
    //         continue;

    //     $company = get_field('company',  'user_' . $user->ID);

    //     if(!empty($company))
    //         if($company[0]->post_title == $company_connected)
    //         {
    //             $topic_by_user = array();
    //             $course_by_user = array();

    //             // Object member
    //             array_push($members,$user);
                
    //             //Followed topic
            
    //             //Stats engagement

    //         }
    // }
    // $count_members = count($members);

    $topic_views = array();

    $assessment_validated = array();
    $count_mandatories = 0;
    /* Mandatories */
    $args = array(
        'post_type' => 'mandatory', 
        'post_status' => 'publish',
        'author__in' => $user->ID,
        'posts_per_page'         => -1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
    $mandatories = get_posts($args);
    $count_mandatories = (!empty($mandatories)) ? count($mandatories) : 0;

    /*
    * * Courses dedicated of these user "Boughts + Mandatories"
    */
    $enrolled = array();
    $enrolled_courses = array();
    $enrolled_all_courses = array();
    $expenses = 0;

    $progress_courses = array(
        'not_started' => 0,
        'in_progress' => 0,
        'done' => 0,
    );
    $course_finished = array();

    //Orders - enrolled courses 
    $budget_spent = 0;  
    $args = array(
        'customer_id' => $user->ID,
        'post_status' => array('wc-processing', 'wc-completed'),
        'orderby' => 'date',
        'order' => 'DESC',
        'limit' => -1,
    );
    $bunch_orders = wc_get_orders($args);
    foreach($bunch_orders as $order){
        foreach ($order->get_items() as $item_id => $item ) {
            $progressions = array();

            //Get woo orders from user
            $course_id = intval($item->get_product_id()) - 1;
            $course = get_post($course_id);

            $prijs = get_field('price', $course_id);
            $budget_spent += $prijs; 
            if(!in_array($course_id, $enrolled)){
                array_push($enrolled, $course_id);
                array_push($enrolled_courses, $course);
                //Get progresssion this course 
                $args = array(
                    'post_type' => 'progression', 
                    'title' => $course->post_name,
                    'post_status' => 'publish',
                    'author' => $user->ID,
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
                    if($is_finish)
                        $status = "done";
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
    $budget_spent = '€ ' . number_format($budget_spent, 2, '.', ',');

    $count_enrolled_courses = (!empty($enrolled_courses)) ? count($enrolled_courses) : 0;

    $course_not_started = $progress_courses['not_started'];
    $course_in_progress = $progress_courses['in_progress'];
    $course_done =  $progress_courses['done'];

    $progress_courses['not_started'] = $count_enrolled_courses - ($progress_courses['in_progress'] + $progress_courses['done']);
    // if($count_enrolled_courses > 0){
    //     $progress_courses['not_started'] = intval(($progress_courses['not_started'] / $count_enrolled_courses) * 100);
    //     $progress_courses['in_progress'] = intval(($progress_courses['in_progress'] / $count_enrolled_courses) * 100);
    //     $progress_courses['done'] = intval(($progress_courses['done'] / $count_enrolled_courses) * 100);
    // }
    // else
    //     $progress_courses['not_started'] = 100;
    $count_course_finished = count($course_finished);

    /* Assessment */
    $args = array(
        'post_type' => 'assessment',
        'post_status' => 'publish',
        'author' => $user->ID,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $assessments_created = get_posts($args);
    $count_assessments_created = (!empty($assessments_created)) ? count($assessments_created) : 0;

    $validated = get_user_meta($user->ID, 'assessment_validated');
    foreach($validated as $assessment)
        if(!in_array($assessment, $assessment_validated))
            array_push($assessment_validated, $assessment);

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

    //Topic views 
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id = " . $user->ID . " AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
    $topic_views = $wpdb->get_results($sql);

endif;
?>
<div class="theme-content">
    <div class="theme-side-menu">
        <?php 
            if(isset($_GET['manager']))
                if(isset($superior) || in_array('hr', $user_connected->roles) || in_array('administrator', $user_connected->roles) )
                    include_once('dashboard-menu-company.php');
                else
                    include_once('dashboard-menu-user.php');  
            else
                include_once('dashboard-menu-user.php');
                
        ?>
    </div>
    <div class="theme-learning">
        <?php 
            if(isset($_GET['manager']))
                if(in_array('administrator', $user_role))
                    include_once('dashboard-user-profile-home.php');
                else if(isset($superior) || in_array('hr', $user_connected->roles) || in_array('administrator', $user_connected->roles) ){
                    if(!isset($superior))
                        $superior = get_users(array('include'=> get_current_user_id()))[0]->data;
                    include_once('dashboard-company-profile-home.php');
                }
                else
                    include_once('dashboard-user-profile-home.php');
            else
                include_once('dashboard-user-profile-home.php');
                
        ?>
    </div>
</div>