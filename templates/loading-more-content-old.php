<?php /** Template Name: Loading more content */ ?>
//loading-more-content
<?php
$like = get_stylesheet_directory_uri()."/img/love.png";
$dislike = get_stylesheet_directory_uri()."/img/heart-like.png";

//$page = 'check_visibility.php';
//require($page); 
extract($_POST);

//The user
$user = get_current_user_id();

$courses = array();
$course_id = array();
$random_id = array();
$count = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'Event' => 0, 'E_learning' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0);

$categories = array();

$void_content ='<center>
                <h2>No content found !</h2> 
                <img src="' . get_stylesheet_directory_uri() . '/img' . '/void-content.gif" alt="content image requirements">
                </center>';

// Saved courses
$saved = get_user_meta($user, 'course');

$teachers = array();

/*
* Get interests courses
*/

//Topics
$topics_external = get_user_meta($user, 'topic');
$topics_internal = get_user_meta($user, 'topic_affiliate');
$topics = array();
if(!empty($topics_external))
    $topics = $topics_external;
if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics, $value);

//Experts
$experts = get_user_meta($user, 'expert');

$args = array(
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => 200
);
$global_courses = get_posts($args);

foreach ($global_courses as $key => $course) {
    //Control visibility
    $bool = true;
    $bool = visibility($course, $visibility_company);
    if(!$bool)
        continue;

    // Date and Location
    $data = array();

    $datas = get_field('data_locaties', $course->ID);

    if($datas)
        $data = $datas[0]['data'][0]['start_date'];
    else{
        $datum = get_field('data_locaties_xml', $course->ID);

        if($datum)
            if(isset($datum[0]['value']))
                $element = $datum[0]['value'];
        if(!isset($element))
            continue;
        $datas = explode('-', $element);
        $data = $datas[0];
    }

    //Course Type
    $course_type = get_field('course_type', $course->ID);

    if(empty($data))
        null;
    else if(!empty($data) && $course_type != "Video" && $course_type != "Artikel")
        if($data){
            $date_now = strtotime(date('Y-m-d'));
            $data = strtotime(str_replace('/', '.', $data));
            if($data < $date_now)
                continue;
        }

    //Preferences categories
    $category_default = get_field('categories', $course->ID);
    $category_xml = get_field('category_xml', $course->ID);
    $read_category = array();
    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if(!in_array($item['value'],$read_category))
                    array_push($read_category,$item['value']);

    else if(!empty($category_xml))
        foreach($category_xml as $item)
            if($item)
                if(!in_array($item['value'],$read_category))
                    array_push($read_category,$item['value']);

    foreach($topics as $topic_value){
        if($read_category)
            if(in_array($topic_value, $read_category) ){
                if(!in_array($course->ID, $course_id)){
                    array_push($course_id, $course->ID);
                    array_push($courses, $course);
                    break;
                }
        }
    }

    //Preference author
    if($experts)
        if(in_array($course->post_author, $experts)){
            if(!in_array($course->ID, $course_id)){
                array_push($course_id, $course->ID);
                array_push($courses, $course);
            }
        }

    //Preference expert
    $experties = get_field('experts', $course->ID);
    if($experties && $experts)
        foreach($experties as $topic_expert){
            if(in_array($topic_expert, $experts)){
                if(!in_array($course->ID, $course_id)){
                    array_push($course_id, $course->ID);
                    array_push($courses, $course);

                    break;
                }
            }
        }
}

//Views
$user_post_view = get_posts(
    array(
        'post_type' => 'view',
        'post_status' => 'publish',
        'author' => $user,
        'order' => 'DESC'
    )
)[0];
$is_view = false;

if (!empty($user_post_view))
{
    $courses_id = array();
    $is_view = true;

    $all_user_views = (get_field('views', $user_post_view->ID));
    $max_points = 10;
    $recommended_courses = array();
    $count_recommended_course = 0;

    foreach($all_user_views as $key => $view) {
        if(!$view['course'])
            continue;

        foreach ($courses as $key => $course) {
            $points = 0;

            //Read category viewed
            $read_category_view = array();
            $category_default = get_field('categories', $view['course']->ID);
            $category_xml = get_field('category_xml', $view['course']->ID);
            if(!empty($category_default))
                foreach($category_default as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_view))
                            array_push($read_category_view, $item['value']);

            else if(!empty($category_xml))
                foreach($category_xml as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_view))
                            array_push($read_category_view, $item['value']);


            //Read category course
            $read_category_course = array();
            $category_default = get_field('categories', $view['course']->ID);
            $category_xml = get_field('category_xml', $view['course']->ID);
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

            //Price view
            $view_prijs = get_field('price', $view['course']->ID);

            foreach($read_category_view as $value){
                if($points == 6)
                    break;
                if(in_array($value, $read_category_course))
                    $points += 3;
            }
            if ($view['course']->post_author == $course->post_author)
                $points += 3;
            if ($view_prijs <= $course->price)
                $points += 1;

            $percent = abs(($points/$max_points) * 100);
            if ($percent >= 50)
                if(!in_array($course->ID, $random_id)){
                    if(get_field('course_type', $course->ID))
                        $count[get_field('course_type', $course->ID)]++;
                    array_push($random_id, $course->ID);
                    array_push($recommended_courses, $course);

                    if(!in_array($course->post_author, $teachers))
                        array_push($teachers, $course->post_author);
                }
            $count_recommended_course = count($recommended_courses);
        }
    }
}

arsort($count);
$count_trend = array_slice($count, 5, 4, true);
$count = array_slice($count, 0, 4, true);

$count_trend_keys = array_keys($count_trend);

$keys = array_keys($count);
shuffle($keys);
$count = array_merge(array_flip($keys), $count);

$bool = false;

if (empty($recommended_courses)){
    $courses_id = array();
    $recommended_courses = $courses;
    $bool = true;
}

//Activitien
shuffle($recommended_courses);
/*
* *
*/

$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
$row_all_recommendation = "";

$find = false;
if(!empty($recommended_courses))
foreach($recommended_courses as $course){
    //Date and Location
    $location = 'Online';
                        
    $data = get_field('data_locaties', $course->ID);
    if($data){
        $date = $data[0]['data'][0]['start_date'];
        $location = $data[0]['data'][0]['location'];
    }
    else{
        $dates = get_field('dates', $course->ID);
        if($dates)
            $day = explode(' ', $dates[0]['date'])[0];
        else{
            $data = get_field('data_locaties_xml', $course->ID);
            if(isset($data[0]['value'])){
                $data = explode('-', $data[0]['value']);
                $date = $data[0];
                $day = explode(' ', $date)[0];
                $location = $data[2];
            }
        }
    }
    
    //Course Type
    $course_type = get_field('course_type', $course->ID);

    if(isset($content_type))
        if($content_type != $course_type)
            continue;

    $find = true;
    /*
    * Categories
    */
    $category = ' ';
    $category_id = 0;
    $category_str = 0;
    if($category == ' '){
        $one_category = get_field('categories',  $course->ID);
        if(isset($one_category[0]['value']))
            $category_str = intval(explode(',', $one_category[0]['value'])[0]);
        else{
            $one_category = get_field('category_xml',  $course->ID);
            if(isset($one_category[0]['value']))
                $category_id = intval($one_category[0]['value']);
        }

        if($category_str != 0)
            $category = (String)get_the_category_by_ID($category_str);
        else if($category_id != 0)
            $category = (String)get_the_category_by_ID($category_id);
    }

    //Price
    $p = " ";
    $p = get_field('price', $course->ID);
    if($p != "0")
        $price = '$' . number_format($p, 2, '.', ',');
    else
        $price = 'Gratis';

    //Legend image
    $thumbnail = get_field('preview', $course->ID)['url'];
    if(!$thumbnail){
        $thumbnail = get_the_post_thumbnail_url($course->ID);
        if(!$thumbnail)
            $thumbnail = get_field('url_image_xml', $course->ID);
        if(!$thumbnail)
            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
    }

    //Author
    $author = get_user_by('ID', $course->post_author);      
    $author_name = $author->display_name ?: $author->first_name;

    //Clock duration
    $duration_day = get_field('duration_day', $post->ID) ? : '-';

    //Other case : youtube
    $youtube_videos = get_field('youtube_videos', $course->ID);

    $author_image = get_field('profile_img',  'user_' . $author_object->ID);
    $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

    $find = true;

    $video_content = "";
    if($youtube_videos && $course_type == 'Video')
        $video_content = '<iframe width="355" height="170" class="lazy img-fluid" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    else
        $video_content = '<img src="' . $thumbnail .'" alt="">';
    $save_content = "";
    if (in_array($course->ID, $saved))
        $save_content = '<img class="btn_favourite" id="' . $user . '_' . $course->ID . '_course" src="' . $dislike . '" alt="">';
    else
        $save_content = '<img class="btn_favourite" id="' . $user . '_' . $course->ID . '_course" src="' . $like . '" alt="">';                
    
    $row_all_recommendation .= '
        <a href="' . get_permalink($course->ID) . '" class="new-card-course">
            <div class="head">
                ' . $video_content. '
            </div>
            <div class="details-card-course">
                <div class="title-favorite d-flex justify-content-between align-items-center">
                    <p class="title-course">' . $course->post_title . '</p>
                    <button>
                        ' . $save_content . '
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                    <div class="blockOpein d-flex align-items-center">
                        <i class="fas fa-graduation-cap"></i>
                        <p class="lieuAm">' . get_field('course_type', $course->ID) . '</p>
                    </div>
                    <div class="blockOpein">
                        <i class="fas fa-map-marker-alt"></i>
                        <p class="lieuAm">' . $location . '</p>
                    </div>
                </div>
                <div class="autor-price-block d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="blockImgUser">
                            <img src="' . $author_image . '" class="" alt="">
                        </div>
                        <p class="autor">' . $author_name . '</p>
                    </div>
                    <p class="price">' . $price . '</p>
                </div>
            </div>
        </a>
    ';
}
else
    if(!$find)
        $row_all_recommendation .= $void_content;

echo $row_all_recommendation;
   