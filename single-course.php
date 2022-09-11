<?php
get_header();

global $post;
global $wp;

$url = home_url( $wp->request );

$page = dirname(__FILE__) . '/templates/check_visibility.php';
 
require($page); 

view($post,$user_visibility);

if(!visibility($post, $visibility_company))
    header('location: /');

$courses = get_field('data_virtual', $post->ID);
$youtube_videos = get_field('youtube_videos', $post->ID);

$course_type = get_field('course_type', $post->ID);
$product = wc_get_product( get_field('connected_product', $post->ID) );
$long_description = get_field('long_description', $post->ID);
$for_who = get_field('for_who', $post->ID) ?: "No content !";

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
    if($data)
        foreach($data as $datum){
            $infos = explode(';', $datum['value']);
            if(!empty($infos))
                foreach($infos as $value) {
                    $info = explode('-', $value);
                    $date = $info[0];
                    array_push($dagdeel, $date);
                }
        }
    }

$dagdeel = array_count_values($dagdeel);
$dagdeel = count($dagdeel);


/*
*  Date and Location
*/
$calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

$data = get_field('data_locaties', $post->ID);
$price = get_field('price', $post->ID) ?: 'Gratis';
$prijsvat = get_field('prijsvat', $post->ID);
$btw = get_field('btw-klasse', $post->ID); 
if(!$prijsvat) 
    $prijsvat = (get_field('price', $post->ID) * $btw/100) - $prijs;

$agenda = get_field('agenda', $post->ID);
$who = get_field('for_who', $post->ID);
$results = get_field('results', $post->ID);
$category = " ";
$tree = get_the_terms($post->ID, 'course_category');
if($tree)
    if(isset($tree[2])){
        $category = $tree[2]->name;
        $id_category = $tree[2]->ID;
    }

$category_id = 0;

if($category == ' '){
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
$email_user = get_user_by('ID', $post->post_author)->email;
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

if($post->post_author == 0){
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

$experts = array_merge($expert, $author);

/*
* Likes
*/
$favoured = count(get_field('favorited', $post->ID));
if(!$favoured)
    $favoured = 0;

/*
* Image
*/
$thumbnail = get_field('preview', $post->ID)['url'];
if(!$thumbnail)
    $thumbnail = get_the_post_thumbnail_url($post->ID);
if(!$thumbnail){
    $thumbnail = get_field('url_image_xml', $post->ID);
    if(!$thumbnail)
        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
}

/*
* Others
*/ 
$duration_day = get_field('duration_day', $post->ID);
$attachments_xml = get_field('attachment_xml', $post->ID);
$reviews = get_field('reviews', $post->ID);

$my_review_bool = false;

foreach ($reviews as $review)
    if($review['user']->ID == $user_id){
        $my_review_bool = true;
        break;
    }

$offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
$online = ['E-learning', 'Video', 'Webinar'];

if(in_array($course_type, $offline))
    include_once('template-parts/modules/single-course-offline.php');
else if(in_array($course_type, $online))
    include_once('template-parts/modules/single-course-online.php');

?> 
 
<?php

get_footer();

?>
