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
if(!empty($company))
    $company_name = $company[0]->post_title;

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
}

$score_rate_feedback = 0;
if($score_rate_max)
    $score_rate_feedback = $score_rate / $score_rate_max;

//Skills 
$topics_external = get_user_meta($user->ID, 'topic');
$topics_internal = get_user_meta($user->ID, 'topic_affiliate');
$count_topics_external = (!empty($topics_external)) ? count($topics_external) : 0;

$followed_topics = array();
if(!empty($topics_external))
    $followed_topics = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($followed_topics, $value);

//Note
$skills_note = get_field('skills', 'user_' . $user->ID);

$followed_teachers = get_user_meta($user->ID, 'expert');

$user_role = get_users(array('include'=> $id_user))[0]->roles;

$statikien_bool = false;
if(isset($_GET['manager']))
    if(!in_array('administrator', $user_role))
        if(isset($superior) || in_array('hr', $user_connected->roles) || in_array('administrator', $user_connected->roles) )
            $statikien_bool = true;

//Stastikien information
if($statikien_bool):
    //Company user 
    $numbers = array();
    $members = array();
    $users = get_users();
    foreach ($users as $value ) {
        if($user->ID == $value->ID)
            continue;

        $company_value = get_field('company',  'user_' . $value->ID);
        if(!empty($company_value))
            if($company_value[0]->post_title == $company_name):
                array_push($numbers, $value->ID);
                array_push($members, $value);
            endif;
    }

    //Feedback given by company
    $todos_company = get_posts($args);
    $score_rate_company = 0;
    $score_rate_max_company = 0;
    $score_rate_feedback_company = 0;
    foreach($todos_all as $todo){
        $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));
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
            $score_rate_company += $rating;
            $score_rate_max_company += 1;
        }
    }
    if($score_rate_max_company)
        $score_rate_feedback_company = $score_rate_company / $score_rate_max_company;
    $topic_views = array();

    $assessment_validated = array();

    $todos_feedback = array();
    $todos_onderwerpen = array();
    $todos_plannen = array();
    $todos_cursus = array();
    $count_mandatories = 0;
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
    $count_mandatories = (!empty($mandatories)) ? count($mandatories) : 0;
    $count_mandatory_done = 0;
    //course mandatory finished 
    foreach($mandatories as $mandatory){
        $pourcentage = 0;
        //Get read by user 
        $args = array(
            'post_type' => 'progression', 
            'title' => $mandatory->post_title,
            'post_status' => 'publish',
            'author' => $user->ID,
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
        $mandatory->manager = get_user_by('ID', get_field('manager_feedback', $mandatory->ID));
        $mandatory->manager_image = get_field('profile_img',  'user_' . $mandatory->manager->ID);
        if(!$image)
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
    }

    /*
    * * Purchased courses 
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
    $assessment_validated = (!empty($assessment_validated)) ? count($assessment_validated) : 0;
    // $count_assessments = count($assessments);
    // $assessment_not_started = 100;
    // $assessment_completed = 0;
    // if($count_assessments > 0){
    //     $not_started_assessment = $count_assessments - $assessment_validated;
    //     $assessment_not_started = intval(($not_started_assessment / $count_assessments) * 100);
    //     $assessment_completed = intval(($assessment_validated / $count_assessments) * 100);
    // }

    $table_tracker_views = $wpdb->prefix . 'tracker_views';

    //Topic views 
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id = " . $user->ID . " AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
    $topic_views = $wpdb->get_results($sql);

    //Expert views 
    $sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id = " . $user->ID . " AND data_type = 'expert' GROUP BY data_id ORDER BY occurence DESC");
    $expert_views = $wpdb->get_results($sql);

    //Course views 
    $sql_course = $wpdb->prepare("SELECT data_id FROM $table_tracker_views WHERE user_id = " . $user->ID . " AND data_type = 'course'");
    $course_views = $wpdb->get_results($sql_course);
    $count_course_views = (!empty($course_views)) ? count($course_views) : 0;

    //var_dump($course_views);
    $type_courses = array();
    $external_learning_opportunities = 0;
    foreach ($course_views as $key => $value) {
        $course = get_post($value->data_id);
        $company_author_course = get_field('company',  'user_' . $course->post_author)[0]->post_title;
        if($company_name != $company_author_course)
            $external_learning_opportunities += 1;

        if($course):
            $type = get_field('course_type', $course->ID);
            if($type)
                $type_courses[$type] += 1; 
        endif;
    } 

    arsort($type_courses);

    //Post courses
    $args = array(
        'post_type' => array('post', 'course'),
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    $posts = get_posts($args);
    $internal_cursus = '<label class="sub-label">Interne cursus :</label>
                         <select class="form-select select-internal-external mb-0" name="interne_cursus" aria-label="Default" id="">
                            <option value="0">Selecteer interne cursus</option>';

    $external_cursus = '<label class="sub-label">Externe cursus :</label>
                         <select class="form-select select-internal-external mb-0" name="externe_cursus" aria-label="Default" id="">
                            <option value="0">Selecteer externe cursus</option>';
    foreach($posts as $key => $post):
        if(in_array($post->post_author, $numbers))
            $internal_cursus .= '<option value="' . $post->ID . '" >' . $post->post_title . '</option>';
        else
            $external_cursus .= '<option value="' . $post->ID . '" >' . $post->post_title . '</option>';

        if($key == 100)
            break;
    endforeach;
    $internal_cursus .= '</select>';
    $external_cursus .= '</select>';
    
    //Badge updated 
    if(isset($_GET['post_id']) && isset($_GET['typeBadge']) && isset($_GET['manager']) ):
        $type_badge = get_field('type_badge', $_GET['post_id']);
        $manager_badge = get_field('manager_badge', $_GET['post_id']);
        if(!$manager_badge)
            if($_GET['post_id']){
                update_field('type_badge', $_GET['typeBadge'], $_GET['post_id']);
                update_field('manager_badge', $_GET['manager'], $_GET['post_id']);   
            }
    endif;

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