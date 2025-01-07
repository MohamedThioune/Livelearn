<?php
/**
 * @param $user : ID user to recommend the courses
 * @param $globe : number total of course to search for...
 * @param $limit : number of course to return
 * @return array[] : array to return : $infos
*/ 
function recommendation($user, $globe = null, $limit = null) {

    global $wpdb;
    $infos = array('teachers' => [], 'recommended' => [], 'upcoming' => []);
    $upcoming = array();
    $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
    $date_now = strtotime(date('Y-m-d'));

    //View table name
    $table_tracker_views = $wpdb->prefix . 'tracker_views';

    //Topics : followed
    $topics_external = get_user_meta($user, 'topic');
    $topics_internal = get_user_meta($user, 'topic_affiliate');
    $topics = array();
    if(!empty($topics_external))
        $topics = $topics_external;
    if(!empty($topics_internal))
        foreach($topics_internal as $value)
            array_push($topics, $value);

    //Experts : followed
    $postAuthorSearch = array();
    $experts = array();
    $experts = get_user_meta($user, 'expert');
    $postAuthorSearch = $experts;
    $teachers = array();

    $globe = ($globe) ?: -1;
    //Get all courses
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $globe
    );
    $global_courses = get_posts($args);

    shuffle($global_courses);

    //Get id experts viewed from db : postAuthorSearch
    $sql_request = $wpdb->prepare("SELECT data_id FROM $table_tracker_views  WHERE user_id = $user AND data_type = 'expert'");
    $all_expert_viewed = $wpdb->get_results($sql_request);
    if (!empty($user_post_view) || !empty($postAuthorSearch))
        $postAuthorSearch = (empty($all_expert_viewed)) ? $postAuthorSearch : array_merge(array_column($all_expert_viewed, 'data_id'), $postAuthorSearch);  

    // Get id categories viewed from db : categorySearch
    $sql_request = $wpdb->prepare("SELECT data_id FROM $table_tracker_views  WHERE user_id = $user AND data_type = 'topic' ");
    $category_user_views = $wpdb->get_results($sql_request);
    $categorySearch = array_column($category_user_views,'data_id');

    $recommended_courses = array();
    $random_id = array();
    $max_points = 10;
    foreach ($global_courses as $key => $course) {
        $points = 0;
        //Course Type
        $courseType = get_field('course_type', $course->ID);
        $course->courseType = get_field('course_type', $course->ID);

        //Read category course - get categories from course
        $read_category_course = array();
        $category_default = get_field('categories', $course->ID);
        $category_xml = get_field('category_xml', $course->ID);
        if(!empty($category_default))
            foreach($category_default as $item)
                if($item)
                    if(!in_array($item['value'],$read_category_course))
                        array_push($read_category_course, $item['value']);
        else if(!empty($category_xml))
            foreach($category_xml as $item)
                if($item)
                    if(!in_array($item['value'],$read_category_course))
                        array_push($read_category_course, $item['value']);

        //Prijs course
        $prijs = get_field('price', $course->ID) ?: 0;
        $prijs = intval($prijs);
        $course->price = $prijs ? : "Gratis";

        //Category pointer | followed 
        foreach($topics as $topic_value):
            if($points == 4)
                break;
            if(in_array($topic_value, $read_category_course) )
                $points += 2;
        endforeach;

        //Category pointer | viewed 
        foreach($categorySearch as $category_value):
            if($points == 4)
                break;
            if(in_array($category_value, $read_category_course))
                $points += 2;
        endforeach;
        //Author pointer  
        if(!empty($postAuthorSearch))
        if (in_array($course->post_author, $postAuthorSearch))
            $points += 2;
        
        $image = get_field('preview', $course->ID) ? : '';
        if ($image)
            $image = $image['url'];

        if(!$image){
            $image = get_the_post_thumbnail_url($course->ID);
            if(!$image)
                $image = get_field('url_image_xml', $course->ID);
                    if(!$image)
                        $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($courseType) . '.jpg';
        }
        $course->image = $image;

        $author = get_userdata($course->post_author);
        if ($author) :
            $author->data->image = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/user.png';
            $course->author = $author->data;
        endif;

        //Evaluate score pointer of this course
        $percent = abs(($points/$max_points) * 100);
        if ($percent >= 50)
            if(!in_array($course->ID, $random_id)){
                if($courseType) {
                    $count[$courseType]++;
                    $course->courseType = $courseType;
                }
                array_push($random_id, $course->ID);
                array_push($recommended_courses, $course);

                if(!in_array($course->post_author, $teachers))
                    array_push($teachers, $course->post_author);
            }
        // courses with date
        $data = array();
        //$day = "-";
        $month = 0;
        //$location = 'Online';
        $datas = get_field('data_locaties', $course->ID);
        if($datas){
            $data = $datas[0]['data'][0]['start_date'];
            if($data != ""){
                $day = explode('/', explode(' ', $data)[0])[0];
                $mon = explode('/', explode(' ', $data)[0])[1];
                $year = explode('/', explode(' ', $data)[0])[2];
                $month = $calendar[$mon];
            }
            $location = $datas[0]['data'][0]['location'];
        } 
        else {
            $datum = get_field('data_locaties_xml', $course->ID);
            if(isset($datum[0]['value'])){
                $datas = explode('-', $datum[0]['value']);
                $data = $datas[0];
                $day = explode('/', explode(' ', $data)[0])[0];
                $month = explode('/', explode(' ', $data)[0])[1];
                $month = $calendar[$month];
                $location = $datas[2];
            } else {
                $dates = get_field('dates', $course->ID);
                if($dates){
                    $data = $dates[0]['date'];
                    $days = explode(' ', $data)[0];
                    $day = explode('-', $days)[2];
                    $month = $calendar[explode('-', $data)[1]];
                    $year = explode('-', $days)[0];
                }
            }
        }

        if (!$month)
            continue;
        if (empty($data))
            null;
        elseif (!empty($data)){
            $data = strtotime(str_replace('/', '.', $data));
            if($data > $date_now) {
                $course->date = date('d/m/Y',$data);
                //$course->courseType = $courseType;
                $upcoming[] = $course;
            }
        }
        /** END DATE */
        if($limit):
            $count_recommended_course = count($recommended_courses);
            if($count_recommended_course == $limit)
                break;
        endif;
    }
    //Must be the end

    $count = ($count) ?: array();
    //Sorting 
    arsort($count);
    $count_trend = array_slice($count, 5, 4, true);
    $count = array_slice($count, 0, 4, true);

    $count_trend_keys = array_keys($count_trend);

    $keys = array_keys($count);
    shuffle($keys);
    $count = array_merge(array_flip($keys), $count);

    $bool = false;

    if (empty($recommended_courses))
        $recommended_courses = (!empty($recommended_courses)) ? $recommended_courses : $global_courses;

    //Activitien
    shuffle($recommended_courses);
    $recommended_courses = array_slice($recommended_courses, 0, $limit, true);

    $infos['recommended'] = $recommended_courses;
    $infos['teachers'] = $teachers;
    $infos['upcoming'] = $upcoming;

    return $infos;

}