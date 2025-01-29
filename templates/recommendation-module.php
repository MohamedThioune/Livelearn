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
    $topics = array();
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

    //Get id experts viewed from db : postAuthorSearch
    $sql_request = $wpdb->prepare("SELECT data_id FROM $table_tracker_views  WHERE user_id = $user AND data_type = 'expert'");
    $all_expert_viewed = $wpdb->get_results($sql_request);
    if (!empty($user_post_view) || !empty($postAuthorSearch))
        $postAuthorSearch = (empty($all_expert_viewed)) ? $postAuthorSearch : array_merge(array_column($all_expert_viewed, 'data_id'), $postAuthorSearch);  
    //Get experts followed
    if(!empty($postAuthorSearch))
        $postAuthorSearch = is_array($postAuthorSearch) ? array_merge($postAuthorSearch, $experts) : $postAuthorSearch;
    else
        $postAuthorSearch = $experts;

    // Get id categories viewed from db : categorySearch
    $sql_request = $wpdb->prepare("SELECT data_id FROM $table_tracker_views  WHERE user_id = $user AND data_type = 'topic' ");
    $category_user_views = $wpdb->get_results($sql_request);
    $categorySearch = array_column($category_user_views,'data_id');
    //Get categories followed
    if(!empty($categorySearch))
        $categorySearch = is_array($categorySearch) ? array_merge($categorySearch, $topics) : $categorySearch;
    else
        $categorySearch = $topics;

    //Preferential languages
    $preferential_language = get_field('language_preferences', 'user_' . $user)  ?: 'en';

    /** Global posts **/
    $tax_query = array(
        array(
        "taxonomy" => "course_category",
        "field"    => "term_id",
        "terms"    => $categorySearch
        )
    );
    $main_blogs = array();
    $query_blogs = new WP_Query( $args );
    //Filter with category(Followed + viewed) & preferential langage & author(Followed + viewed) 
    $args = array(
        'post_type' => array('post', 'course'),
        'post_status' => 'publish',
        'tax_query' => $tax_query,
        'meta_key' => 'language',
        'meta_value' => $preferential_language,
        // 'nopaging' => true,
        'orderby' => 'rand',
        'author__in'=> $postAuthorSearch,
        'posts_per_page' => $limit,
        'paged' => 1
    );
    $query_blogs_author = new WP_Query( $args );
    $main_blogs = isset($query_blogs_author->posts) ? $query_blogs_author->posts : []; 

    if(count($main_blogs) < $limit): 
    	//Filter only with category(Followed + viewed) & preferential langage
    	$args = array(
        	'post_type' => array('post', 'course'),
            'post_status' => 'publish',
        	'tax_query' => $tax_query,
        	'meta_key' => 'language',
        	'meta_value' => $preferential_language,
        	// 'nopaging' => true,
            'orderby' => 'rand',
            'posts_per_page' => $limit,
            'paged' => 1
    	);
    	$query_blogs = new WP_Query( $args );
	    $main_blogs = isset($query_blogs->posts) ? $query_blogs->posts : [];
    endif;
    // shuffle($main_blogs);

    //Use case specially for new users with no input(category, experts)
    if(count($main_blogs) < $limit): 
    	//Filter only with preferential langage
    	$args = array(
        	'post_type' => array('post', 'course'),
            'post_status' => 'publish',
        	'meta_key' => 'language',
        	'meta_value' => $preferential_language,
        	// 'nopaging' => true,
            'orderby' => 'rand',
            'posts_per_page' => $limit,
            'paged' => 1
    	);
    	$query_blogs = new WP_Query( $args );
	    $main_blogs = isset($query_blogs->posts) ? $query_blogs->posts : [];
    endif;
  
    //Recommended final
    $recommended_courses = array();
    $random_id = array();
    foreach ($main_blogs as $key => $course):
        $points = 0;
        //Course Type
        $courseType = get_field('course_type', $course->ID);
        $course->courseType = get_field('course_type', $course->ID);

        //Short descritption
        $short_description = get_field('short_description', $course->ID) ?: 'No description available';
        $course->short_description = substr($short_description, 0, 100) . '...';

        //Prijs course
        $prijs = get_field('price', $course->ID) ?: 0;
        $prijs = intval($prijs);
        $course->price = $prijs ? : "Gratis";
        
        //Image course
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

        //Author course
        $author = get_userdata($course->post_author);
        if ($author) :
            $author->data->image = get_field('profile_img', 'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/user.png';
            $course->author = $author->data;
        endif;

        if(!in_array($course->ID, $random_id)) :
            if($courseType) {
                $count[$courseType]++;
                $course->courseType = $courseType;
            }
            array_push($random_id, $course->ID);
            array_push($recommended_courses, $course);

            if(!in_array($course->post_author, $teachers))
                array_push($teachers, $course->post_author);
        endif;

        /** DATE */
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
            if($count_recommended_course >= $limit)
                break;
        endif;
    endforeach;
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
    // shuffle($recommended_courses);
    // $recommended_courses = array_slice($recommended_courses, 0, $limit, true);

    $infos['recommended'] = $recommended_courses;
    $infos['teachers'] = $teachers;
    $infos['upcoming'] = $upcoming;

    return $infos;
}
