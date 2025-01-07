<?php
require_once ABSPATH.'wp-admin'.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'user.php';
$GLOBALS['user_id'] = get_current_user_id();
require_once __DIR__ .DIRECTORY_SEPARATOR. 'templates'.DIRECTORY_SEPARATOR.'detect-language.php';

//First step : Fill up company id by the author
function fillUpCompany(){
    global $wpdb;

    // Remplir la colonne "company_id" par "author_id" si "company_id" nul
    //$sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE 1");
    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = 0");
    $courses = $wpdb->get_results($sql);
    // Make pagination
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

        if(!$course->company_id) {
            $author_id = $course->author_id;
            $id_course = $course->id;
            $author_company = get_field('company', 'user_' . $author_id);
            $company_id_for_this_author = $author_company[0]->ID;
            //update field company_id

            $sql = $wpdb->prepare("UPDATE {$wpdb->prefix}databank SET company_id = $company_id_for_this_author WHERE id = $id_course");
            $course_updated = $wpdb->get_results($sql); //
            echo "<h4>course $id_course id updated, company id is adding</h4>";
        }
    }
}

//Second step : Delete the extra-author useless
function refreshAuthor(){
    $authors = get_users (array(
        'role__in' => ['author']
    ));

    // Script to delete authors without course
    foreach($authors as $author) :
        // Trying to see if this user have one or more posts ?
        $posts = get_posts (
            array(
                'post_type' => ['post','course'],
                'author' => $author->ID
            )
        );
        //if not post for this author : this user is to deleate
        if (!$posts) {
            wp_delete_user($author->ID);
            echo "<h4>user $author->ID is deleted success...</h4>";
        }
    endforeach;
}

//Third step : Delete the extra-author useless [reviewed ]
/**
 * @return void
 */
function fillUpAuthor(){
    global $wpdb;

    //Remplir la colonne "author_id" par "company_id"
    $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE state = 0");
    $courses = $wpdb->get_results($sql);

    // Make pagination
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
    define("STEP", 50);
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
        if(update_field('language', detectLanguage($course->post_title), $course->ID))
            echo '<h3>language added for :'.$course->post_title.' : '.$course->ID.'</h3>';
    }
}

/**
 * @return void
 * @url https://localhost:8888/livelearn/wp-json/custom/v1/delete-old-course-databank?key=1
 */
function delete_odl_courses_databank(){
    global $wpdb;
    $today = new DateTime();
    $table_databank = $wpdb->prefix . 'databank';
    $lastMonthTeamstample = $today->sub(new DateInterval('P1M'));
    $one_month_before = $lastMonthTeamstample->format('Y-m-d');
    $sql = $wpdb->prepare("DELETE FROM $table_databank WHERE created_at <'$one_month_before'");
    //$sql = $wpdb->prepare("SELECT * FROM $table_databank WHERE created_at <'$one_month_before'");
    $courses = $wpdb->get_results($sql);
    if ($courses){
        echo "<h1 class='textOpleidRight text-center alert alert-danger'>Old courses deleted ! ! !</h1>";
        return;
    }
}
function migration_episodes_video()
{
    $type = $_GET['type'] ?? 'Video';
    $page = $_GET['page'] ?? 1;

    $args = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'ordevalue'       => $type,
        'order' => 'DESC' ,
        'meta_key' => 'course_type',
        'meta_value' => $type,
        'posts_per_page' => 20,
        'paged' => $page,
    );
    $courses = get_posts($args);
    if($type == 'Video') {
        $fileName = get_stylesheet_directory() . "/db/video.json";
        $episodes = [];
        foreach ($courses as $course) {
            $course_type = get_field('course_type', $course->ID);
            if ($course_type != 'Video')
                continue;
            $videos = get_field('youtube_videos', $course->ID);
            foreach ($videos as $video) {
                $episodes[] = array(
                    'post_id' => $course->ID, // so not need to make post type
                    'episode_id'=>$video['id'],
                    'episode_title'=>$video['title'],
                    'episode_image'=>$video['thumbnail_url']
                );
            }
        }
        if($fileName){
            $message = "";
            $old_episodes_json = file_get_contents($fileName);
            $old_episodes_array = json_decode($old_episodes_json,true);
            if ($old_episodes_array)
                $episodes = array_merge($old_episodes_array,$episodes);

            $newJsonContent = json_encode( $episodes,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
             $insert = file_put_contents($fileName,$newJsonContent);
            if ($insert) {
                $message = "content added successfully";
            } else {
                $message = "error content not added !";
            }
        }
    }
    $arg_paginated = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'ordevalue'       => $type,
        'order' => 'DESC' ,
        'meta_key' => 'course_type',
        'meta_value' => $type,
        'posts_per_page' => -1,
    );
    $count_all_course = count(get_posts($arg_paginated));
    $total_pages = ceil($count_all_course / 20);
    //numbers of pages
    $numbers_of_pages = range(1, $total_pages);
    return new WP_REST_Response( array(
        'all_videos_course' => $count_all_course,
        'pages' =>$numbers_of_pages,
        'message' =>$message
        ),201);

}

function migration_episodes_podcast(){
    $type = $_GET['type'] ?? 'Podcast';
    $page = $_GET['page'] ?? 1;

    $args = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'ordevalue'       => $type,
        'order' => 'DESC' ,
        'meta_key' => 'course_type',
        'meta_value' => $type,
        'posts_per_page' => 20,
        'paged' => $page,
    );
    $courses = get_posts($args);
        $fileName = get_stylesheet_directory() . "/db/podcast.json";
        $episodes = [];
        foreach ($courses as $course) {
            $course_type = get_field('course_type', $course->ID);
            if ($course_type != 'Podcast')
                continue;

            $podcasts = get_field('podcasts_index', $course->ID);
            if (!$podcasts)
                continue;

            foreach ($podcasts as $podcast) {

                $episodes[] = array(
                    'post_id' => $course->ID, // so not need to make post type
                    'episode_id'=> $podcast['podcast_url'],
                    'episode_image'=> $podcast['podcast_image'],
                    'episode_title'=> $podcast['podcast_title'],
                    'episode_description'=>$podcast['podcast_description'],
                    'episode_date' => $podcast['podcast_date'] ? : date('Y-m-d H:i:s'),
                );

            }
        }

        if($fileName){
            $message = "";
            $old_episodes_json = file_get_contents($fileName);
            $old_episodes_array = json_decode($old_episodes_json,true);
            if ($old_episodes_array)
                $episodes = array_merge($old_episodes_array,$episodes);

            $newJsonContent = json_encode( $episodes,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
             $insert = file_put_contents($fileName,$newJsonContent);
            if ($insert) {
                $message = "content added successfully";
            } else {
                $message = "error content not added !";
            }
        }
    $arg_paginated = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'ordevalue'       => $type,
        'order' => 'DESC' ,
        'meta_key' => 'course_type',
        'meta_value' => $type,
        'posts_per_page' => -1,
    );
    $count_all_course = count(get_posts($arg_paginated));
    $total_pages = ceil($count_all_course / 20);
    //numbers of pages
    $numbers_of_pages = range(1, $total_pages);
    return new WP_REST_Response( array(
        'message' =>$message,
        'all_podcast_course' =>$count_all_course,
        'pages' => $numbers_of_pages,
        //'episodes' =>$episodes
    ),201);
}

/**
 * @description this function take id-course and
 * @param $id_course
 * @return bool
 */
function save_podcast_in_json_file($id_course) : bool
{
    $postId = $id_course;
    $fileName = get_stylesheet_directory() . "/db/podcast.json";

    $apiKey = 'UQ9BK94AUNCCNCVVFRTZ';
    $apiSecret = 'teMYqdrBgamSWpVnd7q4WABSBBZz3j$^uVSWwHuH';
    $time = time();
    $hash = sha1($apiKey.$apiSecret.$time);
    $headers = [
        "User-Agent: LivelearPodcast",
        "X-Auth-Key: $apiKey",
        "X-Auth-Date: $time",
        "Authorization: $hash"
    ];
      $podcast_index = get_field('podcasts_index', $postId);
     if (!$podcast_index)
        return false;

    $feedid = get_field('origin_id',$postId);
    if (!$feedid)
        return false;

    // get courses in json file
    $episodes_json = file_get_contents($fileName)?:'';
    $episodes = json_decode($episodes_json,true)?:[];
    // filter by $postId
    $url_image_xml = get_field('url_image_xml',$postId);
        $filterEpisodes = $episodes ? array_filter($episodes,function ($episode) use ($postId){
            return $episode['post_id'] == $postId;
        }) : [];

    if ($filterEpisodes) {
        // $podcast_exist = array_values($filterEpisodes);
        $urlEpisodes = array_map(function ($episode){
           return  $episode['episode_id'];
        },$filterEpisodes);
        $urlEpisodes = array_values($urlEpisodes);

        $episodes = array_filter($episodes, function($episode) use ($urlEpisodes) {
            return !in_array($episode['episode_id'], $urlEpisodes);
        });
        // $count_episode_after = count($episodes);
    }

    $url = 'https://api.podcastindex.org/api/1.0/podcasts/byfeedid?id='.$feedid;

    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to disable secure of open ssl
        $response = curl_exec ($ch);
    curl_close ($ch);
    $data = (json_decode($response,TRUE));
    $url_to_get_audio = $data['feed']['url'];

    $xml = simplexml_load_file($url_to_get_audio);
    if($xml)
        foreach($xml->channel[0] as $pod) {
            if ($pod->enclosure->attributes())
            if($pod->enclosure->attributes()->url) {
                $description_podcast = (string)$pod->description;
                $title_podcast = (string)$pod->title;
                $mp3 = (string)$pod->enclosure->attributes()->url;
                $date =(string)$pod->pubDate;
                $image_audio = (string)$pod->children('itunes', true)->image->attributes()->href;

                    $podcast = $episodes ? array_filter($episodes,function ($episode) use ($mp3){
                        return $episode['episode_id'] == $mp3;
                    }) : [];

                if (!$podcast) {
                    $filterEpisodes[] = array(
                        'post_id' => intval($postId), // so not need to make post type
                        'episode_id' => $mp3,
                        'episode_image' => $image_audio ?: $url_image_xml,
                        'episode_title' => $title_podcast ?: '',
                        'episode_description' => $description_podcast ? substr($description_podcast, 0, 180) : '',
                        'episode_date' => $date ?: date('Y-m-d H:i:s'),
                    );
                }
            }
        }

    $filterEpisodes = array_values($filterEpisodes);
    $episodes = array_merge($filterEpisodes,$episodes);
    $newJsonContent = json_encode( $episodes,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
    return file_put_contents($fileName,$newJsonContent);

//    return new WP_REST_Response( array(
//        'message'=>$insert ? 'course updated.' : 'file not updated !!!',
//        'all_after_to_save' =>count($episodes),
//        'counter' => $counter,
//        'episode_exist' =>$podcast_exist,
//        'url' => $urlEpisodes,
//        'episides' =>$filterEpisodes,
//        'number_episode_before' =>$count_episode_before,
//        'number_episode_after' =>$count_episode_after,
//    ));
}
function update_podcast_on_podcastindex()
{
    $page = $_GET['page'] ?? 1;
    $type = 'Podcast';
    $args = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'ordevalue'       => $type,
        'order' => 'DESC' ,
        'meta_key' => 'course_type',
        'meta_value' => $type,
        'posts_per_page' => 20,
        'paged' => $page,
    );
    $courses = get_posts($args);
    $succes = 0;
    $fail = 0;
    $id_failed = [];
    foreach ($courses as $course) {

        if(save_podcast_in_json_file($course->ID))
            $succes = $succes + 1;
        else {
            $fail = $fail + 1;
            $id_failed[] = $course->ID;
        }
    }
    $arg_paginated = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'ordevalue'       => $type,
        'order' => 'DESC' ,
        'meta_key' => 'course_type',
        'meta_value' => $type,
        'posts_per_page' => -1,
    );
    $count_all_course = count(get_posts($arg_paginated));
    $total_pages = ceil($count_all_course / 20);
    //numbers of pages
    $numbers_of_pages = range(1, $total_pages);
    return new WP_REST_Response( array(
        'pages' => $numbers_of_pages,
        'courses_updated'=>array(
            'success'=>$succes,
            'failed'=>array(
                'score' =>$fail,
                'course_failed' => $id_failed
            )
        )
        //'courses' => $courses
    ));
}

function get_video_episode()
{
    $id_course = $_GET['id_course'] ?? null;
    $page = $_GET['page'] ?? 1;
    if (!$id_course)
        return  new WP_REST_Response(['error'=>'you must put the id of course']);
    if(!get_post($id_course))
        return  new WP_REST_Response(['error'=>'id not correcte make sure the exist'],409);

    define("EPISODE_PER_PAGE", 10);
    $fileName = get_stylesheet_directory() . "/db/video.json";
    $episodes_json = file_get_contents($fileName);
        if($episodes_json)
            $episodes = json_decode($episodes_json,true);
        if ($episodes)
            $episodes = array_filter($episodes,function ($episode) use ($id_course){
                return $episode['post_id'] == $id_course;
            });
        //
    $offset = ($page -1 ) * EPISODE_PER_PAGE;
    $total_episodes = count($episodes);
    $episodes = array_slice($episodes,$offset,EPISODE_PER_PAGE);
    $total_pages = ceil($total_episodes / EPISODE_PER_PAGE);
    $pages = range(1, $total_pages);
        $episode_formated = [];
        if ($episodes)
            foreach ($episodes as $episode) {
                $episode_formated[] = [
                    'id' => $episode['episode_id'],
                    'title' => $episode['episode_title'],
                    'thumbnail_url' => $episode['episode_image']
                ];
            }
    $response = [
        'total_episodes' =>$total_episodes,
        'pages' =>$pages,
        'episodes'=>$episode_formated,
    ];
    $response = new WP_REST_Response([$response]);
    $response->set_status(200);
    return($response);
}

function get_podcast_episode()
{
    $id_course = $_GET['id_course'] ?? null;
    $page = $_GET['page'] ?? 1;
    if (!$id_course)
        return  new WP_REST_Response(['error'=>'you must put the id of course']);
    if(!get_post($id_course))
        return  new WP_REST_Response(['error'=>'id not correcte make sure the exist'],409);

    define("EPISODE_PER_PAGE", 10);
    $fileName = get_stylesheet_directory() . "/db/podcast.json";
    $episodes_json = file_get_contents($fileName);
    if($episodes_json)
        $episodes = json_decode($episodes_json,true) ? : [];
        if ($episodes)
            $episodes = array_filter($episodes,function ($episode) use ($id_course){
                return $episode['post_id'] == $id_course;
            }); // recup just 20 premiers episodes

    $offset = ($page -1 ) * EPISODE_PER_PAGE;
    $total_episodes = count($episodes);
    $episodes = array_slice($episodes,$offset,EPISODE_PER_PAGE);
    $total_pages = ceil($total_episodes / EPISODE_PER_PAGE);
    $pages = range(1, $total_pages);

    $episode_formated = [];
   if (!empty($episodes)) {
       foreach ($episodes as $episode) {
           $episode_formated [] = [
               'podcast_url' => $episode['episode_id'],
               'podcast_image' => $episode['episode_image'],
               'podcast_title' => $episode['episode_title'],
               'podcast_description' => $episode['episode_description'],
               'podcast_date' => $episode['episode_date']
           ];
       }
   }
    $response = [
        'total_episodes' =>$total_episodes,
        'pages' =>$pages,
        'episodes'=>$episode_formated,
    ];
    $response = new WP_REST_Response([$response]);
    $response->set_status(200);
    return($response);
}
