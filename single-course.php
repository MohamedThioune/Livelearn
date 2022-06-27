<?php
get_header();

global $post;

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

$data = get_field('data_locaties', $post->ID);
if(!$data){
    $data = get_field('data_locaties_xml', $post->ID);
    $xml_parse = true;
}

if(!isset($xml_parse)){
    if(!empty($data)){
        foreach($data as $datum) {
            $date_end = '';
            $date_start = '';
            $agenda_start = '';
            $agenda_end = '';
            if(!empty($datum['data'])) {
                $date_start = $datum['data'][0]['start_date'];
                if($date_start)
                    if(count($datum['data']) >= 1){
                        $date_end = $datum['data'][count($datum['data'])-1]['start_date'];
                        $agenda_start = explode('/', explode(' ', $date_start)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_start)[0])[1]];
                        if($date_end)
                            $agenda_end = explode('/', explode(' ', $date_end)[0])[0] . ' ' . $calendar[explode('/', explode(' ', $date_end)[0])[1]];
                    }
            }

        }
    }
}
else if($data){
        $it = 0;
        foreach($data as $datum) {
            $infos = explode(';', $datum['value']);
            $number = count($infos)-1;
            $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];
            $date_start = explode(' ', $infos[0]);
            $date_end = explode(' ', $infos[$number]);
            $d_start = explode('/',$date_start[0]);
            $d_end = explode('/',$date_end[0]);
            $h_start = explode('-', $date[1])[0];
            $h_end = explode('-', $date_end[1])[0];
            $agenda_start = $d_start[0] . ' ' . $calendar[$d_start[1]];
            $agenda_end = $d_end[0] . ' ' . $calendar[$d_end[1]];
        }
    }


if (isset($xml_parse))
{
    $start = explode('/',$date_start[0]);
    $end = explode('/',$date_end[0]);
    $month_start = date('F', mktime(0, 0, 0, $start[1], 10));
    $month_end = date('F', mktime(0, 0, 0, $end[1], 10));
    $number_course_day = ((strtotime($end[0].' '.$month_end.' '.$end[2]) - strtotime($start[0].' '.$month_start.' '.$start[2]))/86400);

}
else
{
    $start = explode('/',$date_start);
    $end = explode('/',$date_end);
    $year_start = explode(' ',$start[2]);
    $year_end = explode(' ',$end[2]);
    //var_dump($date_start,$date_end);
    $month_start = date('F', mktime(0, 0, 0, $start[1], 10));
    $month_end = date('F', mktime(0, 0, 0, $end[1], 10));
    $number_course_day = ((strtotime($end[0].' '.$month_end.' '.$year_end[0]) - strtotime($start[0].' '.$month_start.' '.$year_start[0]))/86400);
}

if($number_course_day == 0)
    $number_course_day = 1;


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
$image = get_field('preview', $post->ID)['url'];
if(!$image){
    $image = get_field('url_image_xml', $post->ID);
    if(!$image)
        $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
}


/*
* Preview
*/ 
$thumbnail = get_the_post_thumbnail_url($post->ID);
if(!$thumbnail)
    $thumbnail = get_stylesheet_directory_uri() . '/img/placeholder.png';

/*
* Others
*/ 
$duration_day = get_field('duration_day', $post->ID);
$attachments_xml = get_field('attachment_xml', $post->ID);
$reviews = get_field('reviews', $post->ID);

$offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop'];
$other_offline = ['Opleidingen', 'Cursus'];
$online = ['E-learning', 'Video', 'Webinar'];

if(in_array($course_type, $offline))
    include_once('template-parts/modules/single-course-offline-default.php');
else if(in_array($course_type, $other_offline))
    include_once('template-parts/modules/single-course-offline.php');
else if(in_array($course_type, $online))
    include_once('template-parts/modules/single-course-online.php');


?> 

<?php

get_footer();

?>
