
<?php
require_once ABSPATH.'wp-admin'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'user.php';
$GLOBALS['user_id'] = get_current_user_id();
require_once __DIR__ .DIRECTORY_SEPARATOR. 'templates'.DIRECTORY_SEPARATOR.'detect-language.php';
require_once __DIR__ .DIRECTORY_SEPARATOR. 'templates'.DIRECTORY_SEPARATOR.'add-author.php';

//First step : Fill up company id by the author
function fillUpCompany(){
    global $wpdb;

    // Remplir la colonne "company_id" par "author_id" si "company_id" nul
    //$sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE 1");
    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = 0");
    $courses = $wpdb->get_results($sql);
    // Make pagination
    $count = count($courses);
    define("STEP", 6000);
    $number_iteration = intval(ceil($count / STEP));

    echo  "<h1 class='textOpleidRight text-center alert alert-success'>the number of iteration are [ 1 to => $number_iteration ]</h1>";
    $key = 1;
    if (isset($_GET['key'])) {
        if ( intval($_GET['key'])) {
            $key = intval($_GET['key']);
            if ($key > $number_iteration) {
                echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must not depass $number_iteration </h1>";
                return;
            }
        } else {
            echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must be a number </h1>";
            return;
        }
    }
    $star_index = ($key - 1) * STEP;
    for ($i = $star_index; ($i < $star_index + STEP && $i < $count) ; $i++) {
        $course = $courses[$i];
        echo $i . "<br>";
        if(!$course->company_id) {
            echo $course->titel; 
            $author_id = $course->author_id;
            $id_course = $course->id;
            $author_company = get_field('company', 'user_' . $author_id);
            //if no company
                //Delete the row 
            $company_id_for_this_author = $author_company[0]->ID;
            //update field company_id

            $sql = $wpdb->prepare("UPDATE {$wpdb->prefix}databank SET company_id = $company_id_for_this_author WHERE id = $id_course");
            $course_updated = $wpdb->get_results($sql); //
            echo "<h4>course $id_course id updated, company id is adding</h4><br>";
        }
    }
}

//Second step : Delete the extra-author useless
function refreshAuthor(){
    $authors = get_users (array(
        'role__in' => ['author']
    ));

    // Make pagination
    $count = count($authors);
    define("STEP", 500);
    $number_iteration = intval(ceil($count / STEP));

    $key = 1;
    if (isset($_GET['key'])) {
        if ( intval($_GET['key'])) {
            $key = intval($_GET['key']);
            echo  "<h1 class='textOpleidRight text-center alert alert-success'>the number of iteration are [ $key to => $number_iteration ]</h1>";
            if ($key > $number_iteration) {
                echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must not depass $number_iteration </h1>";
                return;
            }
        } else {
            echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must be a number </h1>";
            return;
        }
    }
    $star_index = ($key - 1) * STEP;
    // Script to delete authors without course
    for ($i = $star_index; ($i < $star_index + STEP && $i < $count) ; $i++) {
        $author = $authors[$i];
        // Trying to see if this user have one or more posts ?
        $posts = get_posts(
            array(
                'post_type' => ['post', 'course'],
                'author' => $author->ID
            )
        );
        //if not post for this author : this user is to deleate
        if (!$posts) {
            if (wp_delete_user($author->ID))
                echo "<h4>user $author->ID is deleted success...</h4>";
        }
    }
}

// Third step : Delete the extra-author useless [reviewed ]
/**
 * @return void
 * @url localhost:8888/livelearn/wp-json/custom/v1/fill-author/?key=1
 */
function fillUpAuthor(){
    global $wpdb;

    //Remplir la colonne "author_id" par "company_id"
    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = 0");
    $courses = $wpdb->get_results($sql);

    // Make pagination
    $count = count($courses);
    define("STEP", 700);
    $number_iteration = intval(ceil($count / STEP));

    echo  "<h1 class='textOpleidRight text-center alert alert-success'>the number of iteration are [ 1 to => $number_iteration ]</h1>";
    $key = 1;
    if (isset($_GET['key'])) {
        if ( intval($_GET['key'])) {
            $key = intval($_GET['key']);
            if ($key > $number_iteration) {
                echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must not depass $number_iteration </h1>";
                return;
            }
        } else {
            echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must be a number </h1>";
            return;
        }
    }
    $star_index = ($key - 1) * STEP;
    for ($i = $star_index; ($i < $star_index + STEP && $i < $count) ; $i++) {
        $course = $courses[$i];
        $company = get_post($course->company_id);
        $id_company = $company->ID;

        //Get all users having in
        $users = get_users(array(
            'role__in'=>'author'
        ));
        $find_company = false;
        foreach ($users as $user):
            //$user_company_id = (get_field('company', 'user_' . $user->ID)) ? get_field('company', 'user_' . $user->ID)[0]->ID : 0;
            $user_company_id = get_field('company', 'user_' . $user->ID)[0]->ID;
            if ($user_company_id)
                if($id_company == $user_company_id):
                    $find_company = true;
                    // update the field author_id directly via sql request
                    $sql = $wpdb->prepare("UPDATE {$wpdb->prefix}databank SET author_id = $user_company_id WHERE id = $course->id");
                    if($wpdb->get_results($sql)); // apply the update
                        echo "<h4>course $course->id id updated for author_id via company_id</h4>";
                    //break on success
                    break;
                endif;
        endforeach;

        // Find the company ?
        //create a new user and mapping the current company 'id_company'
        if(!$find_company){
            $key = $company->post_name;
            $keys = array();
            $rand = random_int(0, 100000);
            if(strpos($key,' ')){
                $keys = explode(' ',$key);
                $email = $rand . $keys[0] . "@" . 'livelearn' . ".nl";
                $first_name = $keys[0];
                $last_name = $keys[1];
            }else{
                $email = $rand . $key . "@" . 'livelearn' . ".nl";
                $first_name = $key;
                $last_name = $key;
            }
            $login = 'user' . $rand;
            $password = "pass" . $rand;

            $userdata = array(
                'user_pass' => $password,
                'user_login' => $login,
                'user_email' => $email,
                'user_url' => 'https://livelearn.nl/inloggen/',
                'display_name' => $first_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => 'author'
            );
            $id_author =  wp_insert_user(wp_slash($userdata));
            update_field('company',$company ,'user_' . $user->ID);

            $sql = $wpdb->prepare("UPDATE {$wpdb->prefix}databank SET author_id = $id_author WHERE id = $course->id");
            if($wpdb->get_results($sql)); //
            echo "<h4>course $course->id id updated for author_id via company_id with new author generated !</h4>";
            //break on success
        }
    }
}

/**
 * @return void
 * @url http://localhost:8888/livelearn/wp-json/custom/v1/update-language-courses/?key=1
 */
function updateLangaugeCourses()
{
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
    );
    $courses = get_posts($args);
    //pagination
    $count = count($courses);
    define("STEP", 100);
    $number_iteration = intval(ceil($count / STEP));

    echo  "<h1 class='textOpleidRight text-center alert alert-success'>the number of iteration are [ 1 to => $number_iteration ]</h1>";
    $key = 1;
    if (isset($_GET['key'])) {
        if ( intval($_GET['key'])) {
            $key = intval($_GET['key']);
            if ($key > $number_iteration) {
                echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must not depass $number_iteration </h1>";
                return;
            }
        } else {
            echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must be a number </h1>";
            return;
        }
    }
    $star_index = ($key - 1) * STEP;
    for ($i = $star_index; ($i < $star_index + STEP && $i < $count) ; $i++) {
        $course = $courses[$i];
        $language = detectLanguage($course->post_title);
        echo $i . '-' . $course->post_title .'|'. $course->ID .'|'. $language . "<br>";
    
        if(update_field('language', $language, $course->ID))
            echo '<h3>language added for :'.$course->post_title.' : '.$course->ID.'</h3>';
    }
}
