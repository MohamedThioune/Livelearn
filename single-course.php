<?php
get_header();

global $post;
global $wp;

$url = home_url( $wp->request );

$page = dirname(__FILE__) . '/templates/check_visibility.php';
 
require($page); 

//view($post,$user_visibility);

$course_type = get_field('course_type', $post->ID);

$offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
$online = ['E-learning', 'Video', 'Webinar','Podcast'];

//Redirection - visibility 
if(!visibility($post, $visibility_company))
    header('location: /');

//Redirection - type
if(!in_array($course_type, $offline) && !in_array($course_type, $online) && $course_type != 'Artikel' && $course_type != 'Podcast' && $course_type != 'Leerpad')
    header('location: /');

//Online
$courses = get_field('data_virtual', $post->ID);
$youtube_videos = get_field('youtube_videos', $post->ID);

$podcasts = get_field('podcasts', $post->ID);
$podcast_index = get_field('podcasts_index', $post->ID);
$product = wc_get_product( get_field('connected_product', $post->ID) );
$long_description = get_field('long_description', $post->ID);
$short_description = get_field('short_description', $post->ID);
$for_who = get_field('for_who', $post->ID) ?: "No content !";
$language = get_field('language', $post->ID);

$count_videos = 0;
if(!empty($courses))
    $count_videos = count($courses);
else if(!empty($youtube_videos))
    $count_videos = count($youtube_videos);

$count_audios = 0;
if(!empty($podcasts))
    $count_audios = count($podcasts);
else if(!empty($podcast_index))
    $count_audios = count($podcast_index);

$dagdeel = array();
$data = get_field('data_locaties', $post->ID);
if(!$data){
    $data = get_field('data_locaties_xml', $post->ID);
    $xml_parse = true;
}

if(!isset($xml_parse)){
    if(!empty($data))
        foreach($data as $datum) 
            if(!empty($datum['data']))
                for($i = 0; $i < count($datum['data']); $i++)
                    array_push($dagdeel, $datum['data'][$i]['start_date']);
}else{
    if($data[0])
        foreach($data as $datum){
            $infos = explode(';', $datum['value']);
            if(!empty($infos))
                foreach($infos as $value) {
                    $info = explode('-', $value);
                    $date = $info[0];
                    array_push($dagdeel, $date);
                }
        }
    else{
        $data = get_field('dates', $post->ID);
        $dagdeel = array($data);
    }
}

$dagdeel = array_count_values($dagdeel);
$dagdeel = count($dagdeel);

/*
*  Date and Location
*/
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

$price = get_field('price', $post->ID) ?: 'Gratis';
$prijsvat = get_field('prijsvat', $post->ID);
$btw = get_field('btw-klasse', $post->ID); 
if(!$prijsvat) 
    $prijsvat = (get_field('price', $post->ID) * $btw/100) - $prijs;

$agenda = get_field('agenda', $post->ID);
$who = get_field('for_who', $post->ID);
$results = get_field('results', $post->ID);

$category = " ";
$category_id = 0;
$id_category = 0;
if($$tag == ' '){
    $category_id = intval(explode(',', get_field('categories',  $post->ID)[0]['value'])[0]);
    $category_xml = intval(get_field('category_xml', $post->ID)[0]['value']);
    if($category_xml)
        if($category_xml != 0){
            $id_category = $category_xml;
            $category = (String)get_the_category_by_ID($category_xml);
        }
    if($category_id)
        if($category_id != 0){
            $id_category = $category_id;
            $category = (String)get_the_category_by_ID($category_id);
        }
}

$user_id = get_current_user_id();

/*
* User informations
*/
$email_user = get_user_by('ID', $post->post_author)->user_email;
$phone_user = get_field('telnr', 'user_' . $post->post_author);

/*
* Companies user
*/
$company_connected = get_field('company',  'user_' . $user_id);
$users_company = array();
$allocution = get_field('allocation', $post->ID);
$users = get_users();
$users_choose = array();
$user_choose = $post->post_author;

foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user))
        if($company_user[0]->post_title == $company_connected[0]->post_title) 
            array_push($users_company, $user->ID);
    if($company_user[0]->post_title == 'beeckestijn') 
        array_push($users_choose, $user->ID);
}

if(!$post->post_author){
    $user_choose = $users_choose[array_rand($users_choose, 1)];

    $arg = array(
        'ID' => $post->ID,
        'post_author' => $user_choose,
    );
    wp_update_post($arg); 
}

$image_author = get_field('profile_img',  'user_' . $post->post_author);
if(!$image_author)
    $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";

/*
* Companies
*/
$company = get_field('company',  'user_' . $post->post_author);

/*
* Experts
*/
$expert = get_field('experts', $post->ID);
$author = array($user_choose);

if(isset($expert[0]))
    $experts = array_merge($expert, $author);
else
    $experts = $author;

/*
* Likes
*/
$favour = get_field('favorited', $post->ID);
if(empty($favour))
    $favoured = 0;
else 
    $favoured = count($favour);

/*
* Image
*/
$thumbnail = get_field('preview', $post->ID)['url'];
if(!$thumbnail){
    $thumbnail = get_the_post_thumbnail_url($post->ID);
    if(!$thumbnail)
        $thumbnail = get_field('url_image_xml', $post->ID);
            if(!$thumbnail)
                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
}

/*
* Others
*/ 
$duration_day = get_field('duration_day', $post->ID);
$attachments_xml = get_field('attachment_xml', $post->ID);

//Reviews
$reviews = get_field('reviews', $post->ID);
$count_reviews = (!empty($reviews)) ? count($reviews) : 0;
$star_review = [ 0, 0, 0, 0, 0];
$average_star = 0;
$average_star_nor = 0;
$my_review_bool = false;
foreach ($reviews as $review):
    if($review['user']->ID == $user_id)
        $my_review_bool = true;

    //Star by number
    switch ($review['rating']) {
        case 1:
            $star_review[1] += 1;
            break;
        case 2:
            $star_review[2] += 1;
            break;
        case 3:
            $star_review[3] += 1;
            break;
        case 4:
            $star_review[4] += 1;
            break;
        case 5:
            $star_review[5] += 1;
            break;
    }
    $average_star += $review['rating']; 
endforeach;
if ($count_reviews > 0 )
    $average_star_nor = $average_star / $count_reviews;
$average_star_format = number_format($average_star_nor, 1, '.', ',');
$average_star = intval($average_star_nor);


$link_to = get_field('link_to', $post->ID);
$share_txt = "Hello, i share this course with ya *" . $post->post_title . "* \n Link : " . get_permalink($post->ID) . "\nHope you'll like it.";


/* * Informations reservation * */
//Orders - enrolled courses 
$datenr = 0; 
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

$enrolled = array();
$enrolled_courses = array();
$statut_bool = 0;
$args = array(
    'customer_id' => $user_id,
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

$enrolled_member = 0;
foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        if($course_id == $post->ID){
            $statut_bool = 1;
            $enrolled_member += 1;
        }
        //Get woo orders from user
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}

$bool_link = 0;
if($price !== 'Gratis')
    if($statut_bool)
        $bool_link = 1;
else if(($price == 'Gratis'))
    $bool_link = 1;

//Similar course
$similar_course = array();
$args = array(
    'post_type' => array('course','post'),
    'post_status' => 'publish',
    'orderby' => 'date',
    'author' => $post->post_author,
    'order' => 'DESC',
    'posts_per_page' => -1
);
$author_courses = get_posts($args);
foreach ($author_courses as $key => $course) {
    if($course->ID == $post->ID)
        continue;
    $type_course = get_field('course_type', $course->ID);
    if($type_course == $course_type)
        array_push($similar_course, $course);
        
    if(count($similar_course) == 6)
        break;
} 

if(in_array($course_type, $offline))
    include_once('template-parts/modules/single-new-course-offline.php');
else if($course_type == 'Video')
    include_once('template-parts/modules/single-new-course-video.php');
else if($course_type == 'Podcast')
    include_once('template-parts/modules/single-course-podcast.php');
else if($course_type == 'Leerpad')
    include_once('template-parts/modules/single-new-course-offline.php');


?>  
 
<?php

get_footer();

?>
