<?php /** Template Name: Homew */ ?>

<?php get_header(); ?>
<?php

$page = 'check_visibility.php';
require($page);
global $wpdb;

$user_connected_id = get_current_user_id();
$user_connected_head = wp_get_current_user();

// View table name

$table_tracker_views = $wpdb->prefix . 'tracker_views';
// Get id of courses viewed from db
$sql_request = $wpdb->prepare("SELECT data_id FROM $table_tracker_views  WHERE user_id = $user_connected_id ");
$all_user_views = $wpdb->get_results($sql_request);
$id_courses_viewed = array_column($all_user_views,'data_id'); //all cours viewing by this user.
$expert_from_database = array();
/**
 * get experts doing the course by database
 */
$pricing = 0;
$purchantage_on_top = 0;
$purchantage_on_bottop = 0;
foreach ($id_courses_viewed as $id_course) {
    $course = get_post($id_course);
    $expert_id = $course->post_author;
    //if ($expert_id)
    $expert_from_database[] = $expert_id;
}
$expert_from_database = array_unique($expert_from_database);
// if($user_connected_id))
//     header('Location: /dashboard/user/');

if(!isset($visibility_company))
    $visibility_company = "";
/*
* Check statistic by user *
*/

$users = get_users();
$numbers = array();
$members = array();
$numbers_count = array();
$topic_views = array();
$topic_followed = array();
$stats_by_user = array();

foreach ($users as $user) {
    $topic_by_user = array();
    $course_by_user = array();

    //Object & ID member
    array_push($numbers, $user->ID);
    array_push($members, $user);

    //Views topic
    $args = array(
        'post_type' => 'view',
        'post_status' => 'publish',
        'author' => $user->ID,
    );
    $views_stat_user = get_posts($args);
    $stat_id = 0;
    if(!empty($views_stat_user))
        $stat_id = $views_stat_user[0]->ID;
    $view_topic = get_field('views_topic', $stat_id);
    if($view_topic)
        array_push($topic_views, $view_topic);

    $view_user = get_field('views_user', $stat_id);
    $number_count['id'] = $user->ID;
    $number_count['digit'] = 0;
    if(!empty($view_user))
        $number_count['digit'] = count($view_user);
    if($number_count)
        array_push($numbers_count, $number_count);

    $view_course = get_field('views', $stat_id);

    //Followed topic
    $topics_internal = get_user_meta($user->ID, 'topic_affiliate');
    $topics_external = get_user_meta($user->ID, 'topic');
    $topic_followed  = array_merge($topics_internal, $topics_external, $topic_followed);

    //Stats engagement
    $stat_by_user['user'] = $view_user;
    $stat_by_user['topic'] = $view_topic;
    $stat_by_user['course'] = $view_course;
    array_push($stats_by_user, $stat_by_user);
}

$topic_views_sorting = $topic_views[5];
if(!$topic_views_sorting)
    $topic_views_sorting = array();
$topic_views_id = array_column($topic_views_sorting, 'view_id');
$keys = array_column($numbers_count, 'digit');
array_multisort($keys, SORT_DESC, $numbers_count);

$most_active_members = array();
$i = 0;
if(!empty($numbers_count))
    foreach ($numbers_count as $element) {
        $i++;
        $value = get_user_by('ID', $element['id']);
        $value->image_author = get_field('profile_img',  'user_' . $value->ID);
        $value->image_author = $value->image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
        array_push($most_active_members, $value);
    }

//Alles coursetype

$type_course = array(
    "Alles",
    "Opleidingen",
    "Training",
    "Workshop",
    "Masterclass",
    "E-learning",
    "Video",
    "Artikel",
    "Assessment",
    "Cursus",
    "Lezing",
    "Event",
    "Webinar",
    "Leerpad",
    "Podcast"
);


?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/mobapiCity.js" />
<script src="<?php echo get_stylesheet_directory_uri();?>/city.js"></script>
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
<style>
    body{
        background: #F5FAFD;
    }
    .headerdashboard,.navModife {
        background: #deeef3;
        color: #ffffff !important;
        border-bottom: 0px solid #000000;
        background: linear-gradient(165deg, hsla(195, 48%, 92%, 1) 49%, hsla(200, 18%, 97%, 1) 100%);
        box-shadow: none;
    }
    .nav-link {
        color: #043356 !important;
    }
    .nav-link .containerModife{
        border: none;
    }
    .worden {
        color: white !important;
    }
    .navbar-collapse .inputSearch{
        background: #C3DCE5;
    }
    .logoModife img:first-child {
        display: none;
    }
    .imgLogoBleu {
        display: block;
    }
    .imgArrowDropDown {
        width: 15px;
        display: none;
    }
    .fa-angle-down-bleu{
        font-size: 20px;
        position: relative;
        top: 3px;
        left: 2px;
    }
    .additionBlock{
        width: 40px;
        height: 38px;
        background: #043356;
        border-radius: 9px;
        color: white !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .navModife4 .additionImg{
        display: none;
    }
    .additionBlock i{
        display: block;
    }
    .bntNotification img{
        display: none;
    }
    .bntNotification i{
        display: block;
        font-size: 28px;
    }
    .scrolled{
        background: #023356 !important;
    }
    .scrolled .logoModife img:first-child {
        display: block;
    }
    .scrolled .imgLogoBleu{
        display: none;
    }
    .scrolled .nav-link {
        color: #ffffff !important;
        display: flex;
    }
    .scrolled .imgArrowDropDown {
        display: block;
    }
    .scrolled .fa-angle-down-bleu {
       display: none;
    }
    .scrolled .inputSearch {
        background: #FFFFFF !important;
    }
    .scrolled .navModife4 .additionImg {
        display: block;
    }
    .scrolled .additionBlock{
        display: none;
    }
    .scrolled .bntNotification img {
        display: block;
    }
    .scrolled .bntNotification i {
        display: none;
    }
    .boxOne3 {
        height: 510px;
    }
    .alJoum {
        margin-bottom: 20px;
    }
    .contentSix {
        margin-bottom: 68px;
    }
    .titleGroupText {
        font-weight: 500;
    }
    .nav-item .dropdown-toggle::after {
        margin-left: 8px;
        margin-top: 10px;
    }
    #modalVideo .modal-dialog {
        width: 50% !important;
    }
    @media (min-width: 300px) and (max-width: 767px){
        .titleSubscription {
            margin-top: 30px;
        }
        .contentFormSubscription {
            margin: 0 auto 50px;
        }
        .logo-parteners-left,.logo-parteners-right {
            display: none;
        }
        .content-home2 .wordDeBestText2 {
            font-size: 25px;
            line-height: 32px;
            padding: 0 15px;
        }
        .content-home2 .voorBlock {
            padding-top: 50px;
        }
        .content-home2 .altijdText2 {
            width: 95%;
            margin: 15px auto 30px;
            font-size: 15px;
        }
        .content-home2 .voorBlock form {
            width: 90%;
            margin: 0 auto;
        }
        .groupeBtn-Jouw-inloggen hr {
            width: 165px;
        }
        .groupBtnConnecte{
            flex-wrap: wrap;
        }
        .groupeBtn-Jouw-inloggen .btn-signup {
            width: 90%;
            display: flex;
            justify-content: center;
            margin: 0 auto 15px;
        }
        .btn-signup-email {
            display: flex;
            width: 90%;
            margin: 0 auto;
            justify-content: center;
        }
        .onze-expert-block {
            border: none;
            padding: 10px 15px;
        }
        .headCollections .dropdown{
            text-align: center;
        }
        .onze-expert-block .btn-collection {
            font-size: 19px;
            width: 70%;
            white-space: unset;
            margin: 0 auto;
        }
        .numberList {
            font-size: 17px;
            margin-right: 8px;
            margin-bottom: 0;
        }
        .nameListeCollection {
            margin-left: 2px;
        }
        .circleImgCollection {
            width: 45px;
            height: 44px;
            margin-right: 5px !important;
        }
        .zelf-block {
            margin: 15px auto 25px !important;
        }
        .talent-binnen-block {
            margin: 40px 0 70px;
            flex-direction: column-reverse;
        }
        .first-block-binnen {
            width: 100%;
            padding-left: 17px;
            padding-right: 17px;
        }
        .second-block-binnen {
            width: 90%;
            padding: 0px 50px;
            border-radius: 20px;
            margin: 15px 15px 40px;
        }
        #modalVideo .modal-dialog {
            width: 96% !important;
        }
        #modalVideo .modal-dialog video{
            width: 100% !important;
            height: 100% !important;
        }
        .block-logo-parteners2 .logo-element {
            width: 26.5%;
            margin: 0 10px 15px;
            height: 70px;
        }
        .block-logo-parteners2 {
            margin-bottom: 40px;
            padding: 0 10px;
        }
        .titleblockOnze {
            font-size: 26px;
            font-weight: 500;
            width: 100%;
            margin: 0 auto;
            line-height: 35px;
        }
        .zelf-block {
            margin-bottom: 24px;
        }
        .doawnloadBlockHome h3 {
            font-size: 20px;
            width: 100%;
            color: #023356;
            line-height: 27px;
        }
        .doanloadIllustration {
            top: unset;
            right: 0px;
            width: 82px;
            bottom: 0;
        }
        .content-home2 .boxOne3 {
            height: fit-content;
            padding-bottom: 30px;
        }
        .alJoum {
            margin-left: 0px;
            margin-right: 0px;
            padding: 25px 0px 20px;
        }
        .block9 .container-fluid {
            padding-right: 20px !important;
            padding-left: 20px !important;
        }
        .contentSix {
            padding: 0 0px;
        }
        .productBlock3 {
            padding: 0 0 0 0px !important;
        }




    }

    @media not all and (min-resolution:.001dpcm) {
        @supports (-webkit-appearance: none) and (stroke-color: transparent) {
            .content-home2 form .selectSearchHome {
                left: 0px;
                top: 1px !important;
                padding: 12px 5px 13px 10px !important;
                box-shadow: none;
                min-width: 115px;
                border-radius: 0;
                border-top-left-radius: 15px;
                border-bottom-left-radius: 15px;
                height: 95% !important;
                background: white !important;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background: url("data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0Ljk1IDEwIj48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6I2ZmZjt9LmNscy0ye2ZpbGw6IzQ0NDt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPmFycm93czwvdGl0bGU+PHJlY3QgY2xhc3M9ImNscy0xIiB3aWR0aD0iNC45NSIgaGVpZ2h0PSIxMCIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMiIgcG9pbnRzPSIxLjQxIDQuNjcgMi40OCAzLjE4IDMuNTQgNC42NyAxLjQxIDQuNjciLz48cG9seWdvbiBjbGFzcz0iY2xzLTIiIHBvaW50cz0iMy41NCA1LjMzIDIuNDggNi44MiAxLjQxIDUuMzMgMy41NCA1LjMzIi8+PC9zdmc+") no-repeat 95% 50% !important;
            }
            .content-home2 form .selectSearchHome {
                height: 95% !important;
            }
            .content-home2 form:before {
                left: 114px;
                top: 6px;
                z-index: 99;
            }
            iframe video{
                width: 100% !important;
                height: 100% !important;
            }

            @media all and (min-width: 300px) and (max-width: 767px){
            }
        }
    }


</style>
<?php
$topic = (isset($_GET['topic'])) ? $_GET['topic'] : 0;

function RandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $rand = $characters[rand(0, strlen($characters))];
        $randstring .= $rand;
    }
    return $randstring;
}

if (isset($_POST))
{

extract($_POST);
if(isset($email)){

        if($email != null)
        {
             $args = array(
                 'post_type' => 'company',
                 'post_status' => 'publish',
                 'posts_per_page' => -1,
                 'order' => 'DESC',
             );

             $companies = get_posts($args);

             foreach($companies as $company){
                 if($company->post_title == $company){
                     $companie = $company;
                     break;
                 }
             }

            if($first_name == null)
                $first_name = "ANONYM";

            if($last_name == null)
                $last_name = "ANONYM";

                $login = RandomString();
                $password = RandomString();


            $userdata = array(
                'user_pass' => $password,
                'user_login' => $login,
                'user_email' => $email,
                'user_url' => 'https://livelearn.nl/inloggen/',
                'display_name' => $first_name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => 'subscriber'
            );

            $user_id = wp_insert_user(wp_slash($userdata));
             if(is_wp_error($user_id)){
                 $danger = $user_id->get_error_message();
                 ?>
                  <script>
                     window.location.replace("/?message=".$danger);
                  </script>
                  <?php
                  echo ("<span class='alert alert-info'>" .  $danger . "</span>");
              }else
                  {
                      $subject = 'Je LiveLearn inschrijving is binnen! ✨';
                      $body = "
                      Bedankt voor je inschrijving<br>
                      <h1>Hello " . $first_name  . "</h1>,<br> 
                      Je hebt je succesvol geregistreerd. Welcome onboard! Je LOGIN-ID is <b style='color:blue'>" . $login . "</b>  en je wachtwoord <b>".$password."</b><br><br>
                      <h4>Inloggen:</h4><br>
                      <h6><a href='https:livelearn.nl/inloggen/'> Log in </a></h6>
                      ";

                      $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );
                      wp_mail($email, $subject, $body, $headers, array( '' )) ;

                      update_field('telnr', $telefoonnummer, 'user_' . $user_id);
                      update_field('degree_user', $choiceDegrees, 'user_'.$user_id);
                      update_field('company', $companie, 'user_'.$user_id);
                      update_field('work', $work, 'user_'.$user_id);
                      update_field('course_type_user', $choiceCourseType, 'user_'.$user_id);
                      update_field('generatie', $choiceGeneratie, 'user_'.$user_id);
                      update_field('country', $prive, 'user_'.$user_id);
                      $subtopics_already_selected = get_user_meta(get_current_user_id(),'topic');
                    foreach ($bangerichtsChoice as $key => $topic) {
                        if (!empty($topic))
                        {
                            if (!(in_array($topic, $subtopics_already_selected)))
                            {
                                add_user_meta(get_current_user_id(),'topic',$topic);
                            }

                        }
                    }

                      header('Location: /inloggen/?message=Je bent succesvol geregistreerd. Je ontvangt een e-mail met je login-gegevens.');
                  ?>

             <?php

             }
         }
     }
     }

/**
 * Skills Passport
*/

$degrees=[
    'n.v.t'=> 'NVT',
    'mbo1' => 'MBO1',
    'mbo2' => 'MBO2',
    'mbo3' => 'MBO3',
    'mbo4' => 'MBO4',
    'hbo' => 'HBO',
    'university' => 'Universiteit',
];

  foreach ($degrees as $key => $value) {
    $input_degrees= '<input type="radio" name="choiceDegrees" value='.$key.' id="level'.$key.'"><label for="level'.$key.'">'.$value.'</label>';
  }

  $generaties=[
    'Generatie BabyBoom (1940-1960)' => 'BabyBoom',
    'Generatie X (1961-1980)' => 'X',
    'Millenials (1981-1995)' => 'Millennials',
    'Generatie Z (1996-nu)' => 'Z',
];
    foreach ($generaties as $key => $value) {
        $input_generaties= '<input type="radio" name="choiceGeneratie" value='.$value.' id="generatie'.$key.'"><label for="generatie'.$key.'">'.$key.'</label>';
    }

    $course_type = ['Opleidingen','E-learnings','Lezingen','Trainingen','Videos','Events','Workshop','Artikelen','Webinars','Masterclasses','Assessments','Podcasts'];
    foreach ($course_type as $key => $value) {
        $input_course_type = '
        <div class="blockInputCheck">
             <input type="checkbox" name="choiceCourseType[]" value='.$value.' id="courseType'.$key.'"/><label class="labelChoose btnBaangerichte" for="courseType'.$key.'">'.$value.'</label>
        </div>';

    }
/**
 * Skills Passport
*/
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        );

    $courses = get_posts($args);

    /*
    ** Categories - all  *
    */

    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    //Categories
    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );
?>

<?php


    $subtopics = array();
    $topics = array();
    foreach($categories as $categ){
        //Topics
        $topicss = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            )
        );
        $topics = array_merge($topics, $topicss);

        foreach ($topicss as  $value) {
            $subtopic = get_categories(
                 array(
                 'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                 'parent'  => $value->cat_ID,
                 'hide_empty' => 0,
                  //  change to 1 to hide categores not having a single post
                )
            );
            $subtopics = array_merge($subtopics, $subtopic);
        }
    }

    foreach($bangerichts as $key1=>$tag){

        //Topics
        $cats_bangerichts = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_bangerichts)!=0)
        {
            $row_bangrichts='<div hidden=true class="cb_topics_bangricht_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_bangerichts as $key => $value)
            {
                $row_bangrichts = '
                <input type="checkbox" name="choice_bangrichts_'.$value->cat_ID.'" value= '.$value->cat_ID .' id=subtopics_bangricht_'.$value->cat_ID.' /><label class="labelChoose" for=subtopics_bangricht_'.$value->cat_ID.'>'. $value->cat_name .'</label>';
            }
            $row_bangrichts= '</div>';
        }

    }

    foreach($functies as $key1 =>$tag)
    {

        //Topics
        $cats_functies = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_functies)!=0)
        {
            $row_functies.='<div hidden=true class="cb_topics_funct_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_functies as $key => $value)
            {
            $row_functies .= '
            <input type="checkbox" name="choice_functies_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_funct_'.($value->cat_ID).'" /><label class="labelChoose" for="cb_funct_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_functies.= '</div>';
        }
    }

    foreach($skills as $key1=>$tag){
        //Topics
        $cats_skills = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_skills)!=0)
        {
            $row_skills.='<div hidden=true class="cb_topics_skills_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_skills as $key => $value)
            {
                    $row_skills .= '
                    <input type="checkbox" name="choice_skills'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_skills_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_skills_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_skills.= '</div>';
        }

    }

    foreach($interesses as $key1=>$tag){
        //Topics
            $cats_interesses = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $tag->cat_ID,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));
            if (count($cats_interesses)!=0)
        {
            $row_interesses.='<div hidden=true class="cb_topics_personal_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_interesses as $key => $value)
            {
            $row_interesses .= '
            <input type="checkbox" name="choice_interesses_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_interesses_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_interesses_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_interesses.= '</div>';
        }

    }

    if (isset($_POST["subtopics_first_login"])){
        unset($_POST["subtopics_first_login"]);
        $subtopics_already_selected = get_user_meta(get_current_user_id(),'topic');
        foreach ($_POST as $key => $subtopics) {
            if (isset($_POST[$key]))
            {
                if (!(in_array($_POST[$key], $subtopics_already_selected)))
                {
                    add_user_meta(get_current_user_id(),'topic',$_POST[$key]);
                }

            }
        }
        update_field('is_first_login', true, 'user_'.get_current_user_id());
    }

    $is_first_login = (get_field('is_first_login','user_' . get_current_user_id()));
    if (!$is_first_login && get_current_user_id() !=0 )
    {

    ?>
    <!-- Modal First Connection -->
    <div class="contentModalFirst"²>
        <div class="modal" id="myFirstModal" tabindex="-1" role="dialog" aria-labelledby="myFirstModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modalHeader">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Welcome to livelearn</h5>
                        <p class="pickText">Pick your favorite topics to set up your feeds</p>
                    </div>
                    <div class="modal-body">
                      <form method="post" name="first_login_form">
                        <div class="blockBaangerichte">
                            <h1 class="titleSubTopic">Baangerichte</h1>
                            <div class="hiddenCB">
                                <div>
                                    <?php
                                    foreach($bangerichts as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                                    }
                                    ?>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnBaangerichte" for="cb1">Choice A</label> -->

                                </div>
                            </div>
                            <div class="subtopicBaangerichte">

                                <div class="hiddenCB">
                                    <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                    echo $row_bangrichts;
                                    ?>
                                </div>
                                <button type="button" class="btn btnNext" id="nextblockBaangerichte">Next</button>
                            </div>
                            <button type="button" class="btn btnSkipTopics" id="btnSkipTopics1">Skip</button>
                        </div>

                        <div class="blockfunctiegericht">
                            <h1 class="titleSubTopic">functiegericht</h1>
                            <div class="hiddenCB">
                                <div>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnFunctiegericht" for="cb1">Choice A</label> -->
                                    <?php
                                    foreach($functies as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_funct'.($key+1).'" /><label class="labelChoose btnFunctiegericht subtopics_funct_'.($key+1).' '.($key+1).'"  for="cb_topics_funct'.($key+1).'">'. $value->cat_name .'</label>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="subtopicFunctiegericht">
                                <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                <div class="hiddenCB">
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                        echo $row_functies;
                                    ?>
                                </div>
                                <button type="button" class="btn btnNext" id="nextFunctiegericht">Next</button>
                            </div>
                            <button type="button" class="btn btnSkipTopics" id="btnSkipTopics2">Skip</button>
                        </div>

                        <div class="blockSkills">
                            <h1 class="titleSubTopic">Skills</h1>
                            <div class="hiddenCB">
                                <div>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnSkills" for="cb1">Choice A</label> -->

                                    <?php
                                    foreach($skills as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_skills'.($key+1).'" /><label class="labelChoose btnSkills subtopics_skills_'.($key+1).' '.($key+1).'" for=cb_skills'.($key+1).'>'. $value->cat_name .'</label>';
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="subtopicSkills">
                                <div class="hiddenCB">
                                    <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                        echo $row_skills;
                                    ?>
                                </div>
                                <button type="button" class="btn btnNext" id="nextSkills">Next</button>
                            </div>
                        </div>

                        <div class="blockPersonal">
                            <h1 class="titleSubTopic">Personal interest </h1>
                            <div class="hiddenCB">
                                <div>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnPersonal" for="cb1">Choice A</label> -->

                                    <?php
                                    foreach($interesses as $key => $value)
                                    {
                                        //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_personal'.($key+1).'" /><label class="labelChoose btnPersonal subtopics_personal_'.($key+1).' '.($key+1).'" for="cb_topics_personal'.($key+1).'">'. $value->cat_name .'</label>';
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="subtopicPersonal">
                                <div class="hiddenCB">
                                    <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                    <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                    <?php
                                        echo $row_interesses;
                                    ?>
                                </div>
                                <button name="subtopics_first_login" class="btn btnNext" id="nextPersonal">Save</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    }


// for onze exoert block
$global_blogs = get_posts($args);

$blogs = array();
$blogs_id = array();
$others = array();
$teachers = array();
$teachers_all = array();

$categoriees = array();

if(isset($categories_topic))
    foreach($categories_topic as $category)
        array_push($categoriees, $category->cat_ID);

foreach($global_blogs as $blog)
{
    /*
    * Categories
    */

    $category_id = 0;
    $experts = get_field('experts', $blog->ID);

    $category_default = get_field('categories',  $blog->ID);
    $categories_xml = get_field('category_xml',  $blog->ID);
    $categories = array();

    /*
    * Merge categories from customize and xml
    */
    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if($item['value'])
                    if(!in_array($item['value'], $categories))
                        array_push($categories,$item['value']);

                    else if(!empty($category_xml))
                        foreach($category_xml as $item)
                            if($item)
                                if($item['value'])
                                    if(!in_array($item['value'], $categories))
                                        array_push($categories,$item['value']);

    $born = false;
    foreach($categoriees as $categoriee){
        if($categories)
            if(in_array($categoriee, $categories)){
                array_push($blogs, $blog);
                array_push($blogs_id, $blog->ID);

                $born = true;
                /*
                 ** Push experts
                */
                if(!in_array($blog->post_author, $teachers))
                    array_push($teachers, $blog->post_author);

                foreach($experts as $expertie)
                    if(!in_array($expertie, $teachers))
                        array_push($teachers, $expertie);
                /*
                 **
                */
                break;
            }
    }
    if(!$born){
        array_push($others, $blog);
        if(!in_array($blog->post_author, $teachers_all))
            array_push($teachers_all, $blog->post_author);

    }
    /*
     **
    */
}

//The user
$user_id = get_current_user_id();

//Saved courses
$saved = get_user_meta($user_id, 'course');


?>

<div class="contentOne content-home2">

    <div class="boxOne3">
        <div class="container-fluid position-relative">
            <div class="voorBlock">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/second-group-parteners-logo.png" class="logo-parteners-left " alt="">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/first-group-parteners-logo.png" class="logo-parteners-right" alt="">

                <h1 class="wordDeBestText2">Hét leer- en upskilling platform van- én voor de toekomst</h1>
                <p class="altijdText2">Onhandig als medewerkers niet optimaal functioneren. LiveLearn zorgt dat jouw workforce altijd op de hoogte is van de laatste kennis en vaardigheden.</p>
                <form action="/product-search" class="position-relative newFormSarchBar" method="POST">
                    <select class="form-select selectSearchHome" aria-label="search home page" name="search_type" id="course_type">
                        <?php
                        foreach($type_course as $type)
                            echo '<option value="' . $type . '">' . $type . '</option>';
                        ?>
                    </select>
                    <div class="group-input-dropdown">
                        <input id="search" type="search" class="jAuto searchInputHome form-control"
                               placeholder="Zoek op naam, experts of onderwerpen " name="search" autocomplete="off">
                        <button class="btn btn-Zoek elementWeb"><span>Zoek</span></button>
                    </div>

                    <div class="dropdown-menuSearch" id="list">
                        <div class="list-autocomplete" id="autocomplete">
                            <center> <i class='hasNoResults'>No matching results ... </i> </center>
                        </div>
                    </div>
                </form>
                <div class="groupeBtn-Jouw-inloggen group-hr-play" type="button" data-toggle="modal" data-target="#modalVideo">
                    <hr>
                    <button class="btn btnPlayVideoHome">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/playVideo.png" class="logo-playVideo"  alt="">
                    </button>

                    <!-- Modal for video -->
                    <div class="modal fade" id="modalVideo" tabindex="-1" role="dialog" aria-labelledby="modalVideoLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalVideoLabel">Welcome</h5>
                                    <button type="button" id="closeModalVideo" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <video width="560" height="315" id="videoFrame" controls>
                                        <source src="<?php echo get_stylesheet_directory_uri();?>/video/livelearn-home.mp4" title="livelearn video presentation"  allow="playsinline;" type="video/mp4" /><!-- Safari / iOS video    -->
                                        <source src="<?php echo get_stylesheet_directory_uri();?>/video/livelearn-home.mp4" title="livelearn video presentation"  allow="playsinline;" type="video/ogg" /><!-- Firefox / Opera / Chrome10 -->
                                    </video>
                                </div>
                                <div class="modal-footer">
<!--                                    <a href="/registreren/" class="btn btn-registreren">Register for free</a>-->
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative">
                        <p class="bekijk-text">Bekijk wat we doen</p>
                        <hr>
                    </div>

                </div>
                <?php if(!$user_id) { ?>
                    <div class="groupeBtn-Jouw-inloggen groupBtnConnecte">
                        <a href="http://livelearn.nl/wp-login.php?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="btn btn-signup">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/googleImg.png" alt="" />
                            Gratis inloggen met Google
                        </a>
                        <!-- <button class="btn btn-signup">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/linkedin-icon.png" class="" alt="">
                        sign up with Linkedin
                    </button> -->
                        <a href="/inloggen/" class="btn btn-signup-email">
                            <span style="color:white">Gratis inloggen via mail</span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Modal Skills passport -->
    <div class="modal fade" id="SkillsModal" tabindex="-1" role="dialog" aria-labelledby="SkillsModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Jouw skills paspoort in 6 stappen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="skills_passport_add" method="post">
                        <div class="blockStepSkillsPaspoort">
                            <div class="setp" >
                                <div class="circleIndicator colorStep" id="Niveau">
                                    <i class="fa fa-level-up" aria-hidden="true"></i>
                                </div>
                                <p class="textOpleidRight">Level</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Vakgebied">
                                    <i class="fa fa-file"></i>
                                </div>
                                <p class="textOpleidRight">Vakgebied (en) </p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Locatie">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <p class="textOpleidRight">Locatie</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Leervorm">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>
                                <p class="textOpleidRight">Leervorm</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Generatie">
                                    <i class="fa fa-calendar-check"></i>
                                </div>
                                <p class="textOpleidRight">Generatie</p>
                            </div>
                            <div class="setp" >
                                <div class="circleIndicator" id="Finish">
                                    <i class="fa fa-flag-checkered"></i>
                                </div>
                                <p class="textOpleidRight">Finish</p>
                            </div>
                        </div>

                        <div class="step1SkillsPasspoort">
                            <p class="titleBlockStepSkills">Wat is jouw hoogst afgeronde opleiding ?</p>
                            <div class="blockInputRadio">
                                <?= $input_degrees; ?>
                            </div>
                            <div class="text-center w-100 groupBtnStepSkillsP">
                                <button type="button" class="btn btnSkip" id="btnSkip">Skip</button>
                                <button type="button" class="btn btn-volgende" id="btnStep1SkillsPasspoort">Volgende</button>
                            </div>
                        </div>

                        <div class="step2SkillsPasspoort stepSkillpasspoort">
                            <p class="titleBlockStepSkills">In welk vakgebied ben je werkzaam of ben je geïnteresseerd ?
                                <br><span>(Meerdere mogelijk)</span></p>
                            <div class="hiddenCB">
                                <div>
                                    <?php
                                    foreach($bangerichts as $bangericht){
                                        $image_category = get_field('image', 'category_'. $bangericht->cat_ID);
                                        $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/Image-79.png';
                                        ?>
                                        <div class="blockInputCheck">
                                            <input type="checkbox" name="bangerichtsChoice[]" value=<?php echo $bangericht->cat_ID ?> id="<?php echo $bangericht->cat_ID ?>" /><label class="labelChoose btnBaangerichte" for="<?php echo $bangericht->cat_ID ?>"><?php echo $bangericht->cat_name ?></label>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="text-center w-100 groupBtnStepSkillsP">
                                <button type="button" class="btn btnTerug" id="btnTerug1SkillsPasspoort">Terug</button>
                                <button type="button" class="btn btn-volgende" id="btnStep2SkillsPasspoort">Volgende stap</button>
                            </div>
                        </div>

                        <div class="step3SkillsPasspoort stepSkillpasspoort">
                            <p class="titleBlockStepSkills">Geef de locatie(s) aan waar jij woont of werkt</p>
                            <div class="input-group-locaties">
                                <div class="inputGroupLocaties">
                                    <p class="priveBlockTitle">Privé:</p>
                                    <!-- country -->
                                    <div class='row align-items-center'>
                                        <div class='col-md-3 col-xs-3'>
                                            <p><b>Country</b></p>
                                        </div>
                                        <div class='col-md-9 col-xs-9'>
                                            <select id="country" class='form-control' required><option value="">-- Country --</option></select>
                                        </div>
                                    </div>
                                    <!-- end country row -->

                                    <!-- region -->
                                    <div class='row align-items-center'>
                                        <div class='col-md-3 col-xs-3'>
                                            <p><b>Region</b></p>
                                        </div>
                                        <div class='col-md-9 col-xs-9'>
                                            <select id="region" class='form-control' required><option value="">-- Region --</option></select>
                                        </div>
                                    </div>
                                    <!-- end region row -->
                                </div>

                                <div class="inputGroupLocaties">
                                    <p class="priveBlockTitle">Werk:</p>
                                    <!-- country -->
                                    <div class='row align-items-center'>
                                        <div class='col-md-3 col-xs-3'>
                                            <p><b>Country</b></p>
                                        </div>
                                        <div class='col-md-9 col-xs-9'>
                                            <select id="countryBiss" class='form-control' required><option value="">-- Country --</option></select>
                                        </div>
                                    </div>
                                    <!-- end country row -->

                                    <!-- region -->
                                    <div class='row align-items-center'>
                                        <div class='col-md-3 col-xs-3'>
                                            <p><b>Region</b></p>
                                        </div>
                                        <div class='col-md-9 col-xs-9'>
                                            <select id="regionBiss" class='form-control' required><option value="">-- Region --</option></select>
                                        </div>
                                    </div>
                                    <!-- end region row -->
                                </div>
                            </div>
                            <div class="text-center w-100 groupBtnStepSkillsP">
                                <button type="button" class="btn btnTerug" id="btnTerug2SkillsPasspoort">Terug</button>
                                <button type="button" class="btn btn-volgende" id="btnStep3SkillsPasspoort">Volgende stap</button>
                            </div>
                        </div>

                        <div class="step4SkillsPasspoort stepSkillpasspoort">
                            <p class="titleBlockStepSkills">Hoe leer jij het liefst ?</p>
                            <div class="hiddenCB">
                                <div>
                                    <?= $input_course_type; ?>
                                </div>

                            </div>

                            <div class="text-center w-100 groupBtnStepSkillsP">
                                <button type="button" class="btn btnTerug" id="btnTerug3SkillsPasspoort">Terug</button>
                                <button type="button" class="btn btn-volgende" id="btnStep4SkillsPasspoort">Volgende stap</button>
                            </div>
                        </div>

                        <div class="step5SkillsPasspoort stepSkillpasspoort">
                            <p class="titleBlockStepSkills">Tot welke generatie behoor je ?</p>
                            <div class="blockInputRadio" id="groupBtnChoice2">
                                <?=  $input_generaties; ?>
                            </div>
                            <div class="text-center w-100 groupBtnStepSkillsP">
                                <button type="button" class="btn btnTerug" id="btnTerug4SkillsPasspoort">Terug</button>
                                <button type="button" class="btn btn-volgende" id="btnStep5SkillsPasspoort">Volgende stap</button>
                            </div>
                        </div>

                        <div class="step6SkillsPasspoort stepSkillpasspoort">
                            <p class="titleBlockStepSkills">Vul je gegevens in en je hebt direct toegang tot je skills paspoort </p>
                            <div class="hiddenCB">
                                <div class="input-group-register">
                                    <div class="form-group-skills">
                                        <label for="">Voornaam</label>
                                        <input name="first_name"  type="text" placeholder="Voorman">
                                    </div>
                                    <div class="form-group-skills">
                                        <label for="">Achternaam</label>
                                        <input name="last_name" type="text" placeholder="Achternaam">
                                    </div>
                                    <div class="form-group-skills">
                                        <label for="">Bedrijf</label>
                                        <input name="companie" type="text" placeholder="Bedrijf">
                                    </div>
                                    <!-- <div class="form-group-skills">
                                        <label for="">Wachtwoord</label>
                                        <input type="text" placeholder="Wachtwoord">
                                    </div> -->
                                    <div class="form-group-skills">
                                        <label for="">Email</label>
                                        <input name="email" type="text" placeholder="Email">
                                    </div>
                                    <div class="form-group-skills">
                                        <label for="">Telefoonnummer</label>
                                        <input name="telefoonnummer" type="text" placeholder="Telefoonnummer">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center w-100 groupBtnStepSkillsP">
                                <button type="button" class="btn btnTerug" id="btnTerug5SkillsPasspoort">Terug</button>
                                <button type="submit" class="btn btn-volgende">Maak je skills paspoort</button>
                            </div>
                        </div>

                </div>

            </div>
            </form>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="img-block-illustration">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/illustration-livelearn.png"  alt="">
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="theme-card-gradient">
                <p class="title-card">Voor jou!</p>
                <p class="description-card">Een altijd gratis leeromgeving om je oneindig door te laten groeien; word de expert in de markt.</p>
                <div class="w-100">
                    <a href="/voor-jou">Sign-up!</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="theme-card-gradient">
                <p class="title-card">Voor opleiders / experts</p>
                <p class="description-card">Ben jij een expert, opleider of coach? Unlock je teacher omgeving en deel / verkoop direct je kennis.</p>
                <div class="w-100">
                    <a href="/voor-opleiders/">Sign-up!</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="theme-card-gradient">
                <p class="title-card">Voor werkgevers</p>
                <p class="description-card">Je bedrijf oneindig laten groeien, door je personeel te laten excelleren? LiveLearn is dé upskilling partner. </p>
                <div class="w-100">
                    <a href="/voor-organisaties/">Sign-up!</a>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="onze-expert-block">
    <div class="container-fluid">
        <div class="headCollections">
            <div class="dropdown show">
                <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownHuman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Onze top experts binnen <b id="complete-categorien">Alle categorieën</b>
                </a>
                <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownHuman">
                    <select class="form-select selectSearchHome" name="search_type" id="topic_search" multiple="true">
                        <?php
                        foreach($topics as $category)
                            echo '<option value="' . $category->cat_ID . '">' . $category->cat_name . '</option>';
                        ?>
                    </select>
                </div>
                <div id="loader" class="spinner-border spinner-border-sm text-primary d-none" role="status"></div>
            </div>
            <!-- period -->
            <div class="dropdown show">
                <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownHuman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Over de <b id="complete-period">All time</b>
                </a>
                <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownHuman">
                    <select class="form-select selectSearchHome" id="period" multiple>
                        <option value="all">All time</option>
                        <option value="lastweek">Last 7 days</option>
                        <option value="lastmonth">Last 1 month</option>
                        <option value="lastyear">Last 1 year</option>
                    </select>
                </div>
            </div>
            <!-- period -->
            <a href="/voor-opleiders/" class="zelf-block">
                <p class="mr-2">Zelf ook een expert? </p>
                <div class="all-expert">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/finger.png" alt="">
                </div>
            </a>
        </div>
        <div class="row" id="autocomplete_categorieen">
            <?php
            $today = new DateTime();
            $lastYearTeample = $today->sub(new DateInterval('P1Y'));
            $lastYear = $lastYearTeample->format('Y-m-d');

            $active_members = array();
            foreach ($most_active_members as $index => $user) {
                $pricing_last_year = 0;
                $pricing_since_today = 0;

                $args_since_today = array(
                    'post_type' => array('post', 'course'),
                    'order' => 'DESC',
                    'limit' => -1,
                    'author' => $user->ID,
                );
                $courses_since_today = get_posts($args_since_today);
                // args to get artikel of last year
                $args_last_year = array(
                    'post_type' => 'post',
                    'posts_per_page' => -1,
                    'author' => $user->ID,
                    'date_query' => array(
                        'year' => $lastYear,
                        'inclusive' => true,
                    ),
                );
                $courses_last_year = get_posts($args_last_year);

                //var_dump(count($courses_last_year));
                if (!empty($courses_last_year))
                    foreach ($courses_last_year as $course) {
                        $course_type = get_field('course_type', $course->ID);
                        $prijs = get_field('price', $course->ID);
                        $sql_request = $wpdb->prepare("SELECT occurence  FROM $table_tracker_views  WHERE  data_id = $course->ID");
                        $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                        $tracker_views = intval($number_of_this_is_looking) ?: 0;

                        $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                        //$reaction = get_field('reaction', $course->ID);

                        //get pricing from type of course: course free
                        if ($course_type == 'Artikel') {
                            $pricing_last_year = $pricing_last_year + 50;
                            if ($tracker_views != 0) {
                                $pricing_last_year = $pricing_last_year + $tracker_views * 1.25; //views+click
                            }
                            if ($favorited) {
                                $pricing_last_year = $pricing_last_year + 5;
                            }
                        } else if ($course_type == 'Podcast') {
                            $pricing_last_year = $pricing_last_year + 100;
                            if ($favorited) {
                                $pricing_last_year = $pricing_last_year + 10;
                            }
                        } else if ($course_type == 'Video') {
                            $pricing_last_year = $pricing_last_year + 75;
                            if ($tracker_views != 0) {
                                $pricing_last_year = $pricing_last_year + $tracker_views * 3.5; //views+click+
                            }
                        } else {
                            $pricing_last_year = $pricing_last_year + 100;
                            if ($favorited) {
                                $pricing_last_year = $pricing_last_year + 20;
                            }
                            if ($tracker_views != 0) {
                                $pricing_last_year = $pricing_last_year + $tracker_views * 10;
                            }
                        }
                    }

                /* get price from post doing by user for free course */
                if (!empty($courses_since_today))
                    foreach ($courses_since_today as $course) {
                        $course_type = get_field('course_type', $course->ID);
                        $prijs = get_field('price', $course->ID);
                        $sql_request = $wpdb->prepare("SELECT occurence  FROM $table_tracker_views  WHERE  data_id = $course->ID");
                        $number_of_this_is_looking = $wpdb->get_results($sql_request)[0]->occurence;
                        $tracker_views = intval($number_of_this_is_looking) ?  : 0;

                        $favorited = get_field('favorited', $course->ID); // this means that if this course doing by this user is liked by a user
                        //$reaction = get_field('reaction', $course->ID);

                        //get pricing from type of course: course free
                        if ($course_type == 'Artikel') {
                            $pricing_since_today = $pricing_since_today + 50;
                            if ($tracker_views !=0) {
                                $pricing_since_today = $pricing_since_today + $tracker_views * 1.25; //views+click
                            }
                            if ($favorited){
                                $pricing_since_today = $pricing_since_today + 5;
                            }
                        }
                        else if ($course_type == 'Podcast') {
                            $pricing_since_today = $pricing_since_today + 100;
                            if ($favorited){
                                $pricing_since_today = $pricing_since_today + 10;
                            }
                        }
                        else if ($course_type == 'Video') {
                            $pricing_since_today = $pricing_since_today + 75;
                            if ($tracker_views !=0) {
                                $pricing_since_today = $pricing_since_today + $tracker_views * 3.5; //views+click+
                            }
                        }else {
                            $pricing_since_today = $pricing_since_today + 100;
                            if ($favorited){
                                $pricing_since_today = $pricing_since_today + 20;
                            }
                            if ($tracker_views !=0) {
                                $pricing_since_today = $pricing_since_today + $tracker_views * 10;
                            }
                        }
                    }

                $image_user = get_field('profile_img',  'user_' . $user->ID);
                $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                $company = get_field('company',  'user_' . $user->ID);
                $company_title = $company[0]->post_title;
                $company_logo = get_field('company_logo', $company[0]->ID);
                if (!$company_logo || !$company_title)
                    continue;

                $display_name = "";
                if(isset($user->first_name) && isset($user->last_name))
                    $display_name = $user->first_name . ' ' . $user->last_name;
                else
                    $display_name =  $user->display_name;

                $purcent = abs($pricing_since_today-$pricing_last_year);
                $purcent = $pricing_last_year ? ($purcent/$pricing_last_year) : $purcent;
                $purcent = $purcent >= 100 ? $purcent : $purcent * 100;

                if (!$purcent)
                    continue;
                if ($purcent>100) {
                    //  $purcent = (string)$purcent;
                    //  $purcent = substr($purcent, 0, 2);
                }
                $purcent = number_format($purcent, 2, '.', ',');

                if ($pricing_since_today > $pricing_last_year)
                    $user->pricing = $pricing_since_today;
                else
                    $user->pricing = $pricing_last_year;
                $user->display_name = $display_name;
                $user->purcent = $purcent;
                $user->image_user = $image_user;
                $user->company_title = $company_title;
                $user->company_logo = $company_logo;

                $active_members [] = $user;
            }

            $pricing_members = array_column($active_members, 'pricing');
            array_multisort($pricing_members, SORT_DESC, $active_members);

            foreach ($active_members as $index => $user){
                echo '
            <a href="user-overview?id=' . $user->ID .'" class="col-md-4">
                <div class="boxCollections">
                    <p class="numberList">' . ++$index .'</p>
                    <div class="circleImgCollection">
                        <img src="' . $user->image_user . '" alt="">
                    </div>
                    <div class="secondBlockElementCollection">
                        <p class="nameListeCollection">'. $user->display_name . '</p>

                        <div class="blockDetailCollection">
                            <div class="iconeTextListCollection">
                                <img src="' . $user->company_logo . '" alt="">
                                <p>' . $user->company_title. '</p>
                            </div>
                            <div class="iconeTextListCollection">
                                <img src="' . get_stylesheet_directory_uri() . '/img/awesome-brain.png" alt="">
                               <p class="number-brain">'.number_format($user->pricing,2,".",",").'</p>
                            </div>
                        </div>

                    </div>
                    <p class="pourcentageCollection">' . $user->purcent . '%</p>
                </div>
            </a>';
                if ($index == 12)
                    break;
            }
            ?>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="talent-binnen-block">
        <div class="first-block-binnen">
            <h3>Als bedrijf beheer je in <span>1 minuut</span> al je <span>talent</span> binnen de organisatie </h3>
            <p class="description ">In ons speciaal ontwikkelde learning management systeem houd je als manager precies bij hoe jouw talent zich ontwikkelt. Daarnaast deel je eenvoudig content, trainingen en andere kennisproducten met hen. </p>
            <div class="jij-element">
                <div class="d-flex">
                    <p class="jij-text">JIJ</p>
                    <img class="imgArrowRight" src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-long-arrow-alt-right.png" alt="">
                </div>
                <p class="text-description-jij">Een manager dashboard</p>
            </div>
            <div class="jij-element">
                <div class="d-flex">
                    <p class="jij-text">JE TEAM</p>
                    <img class="imgArrowRight" src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-long-arrow-alt-right.png" alt="">
                </div>
                <p class="text-description-jij">Een mobiele app</p>
            </div>
            <div class="d-flex align-items-center mt-4">
                <a href="/voor-organisaties/" class="btn btnStratAlVoor">Start al voor €4,95</a>
                <p class="GespecialiseerdText">Gespecialiseerd in het MKB</p>
            </div>
        </div>
        <div class="second-block-binnen">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/imgStartVoor.png" alt="">
        </div>
    </div>
    <div class="block-logo-parteners2">
        <div class="logo-element">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/vanSpaendockLogo.png" alt="">
        </div>
        <div class="logo-element">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/orangeLogo.png" alt="">
        </div>
        <div class="logo-element">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/manpowerLogo.png" alt="">
        </div>
        <div class="logo-element">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/openclassroomLogo.png" alt="">
        </div>
        <div class="logo-element">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/zelfstanLogo.png" alt="">
        </div>
        <div class="logo-element">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/uwvLogo.png" alt="">
        </div>
        <div class="logo-element">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Deloitte.png" alt="">
        </div>
    </div>
</div>
<div class="block9">
    <div class="block9">
        <div class="container-fluid">
            <p class="titleblockOnze">De onderwerpen waarin wij jou kunnen helpen</p>
            <a href="/Onderwerpen" class="zelf-block">
                <p>Bekijk alle onderwerp</p>
                <div  class="all-expert">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/finger.png" alt="">
                </div>
            </a>
            <div class="blockGroupText">
                <p class="titleGroupText">Opleiden richting een baan </p>

                <div class="sousBlockGroupText">
                    <?php
                    foreach($bangerichts as $bangericht){
                        ?>
                        <a href="sub-topic?subtopic=<?php echo $bangericht->cat_ID ?>" class="TextZorg"><?php echo $bangericht->cat_name ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="blockGroupText">
                <p class="titleGroupText">Groeien binnen je functie </p>

                <div class="sousBlockGroupText">
                    <?php
                    foreach($functies as $functie){
                        ?>
                        <a href="sub-topic?subtopic=<?php echo $functie->cat_ID ?>" class="TextZorg"><?php echo $functie->cat_name ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="blockGroupText">
                <p class="titleGroupText">Relevante skills ontwikkelen:</p>

                <div class="sousBlockGroupText">
                    <?php
                    foreach($skills as $skill){
                        ?>
                        <a href="sub-topic?subtopic=<?php echo $skill->cat_ID ?>" class="TextZorg"><?php echo $skill->cat_name ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="blockGroupText">
                <p class="titleGroupText">Persoonlijke interesses & vrije tijd</p>

                <div class="sousBlockGroupText">
                    <?php
                    foreach($interesses as $interesse){
                        ?>
                        <a href="sub-topic?subtopic=<?php echo $interesse->cat_ID ?>" class="TextZorg"><?php echo $interesse->cat_name ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="block-contact-calendy text-center">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="img-Direct-een">
                    <img id="firstImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Direct-een.png" alt="">
                </div>
                <div class="img-Direct-een">
                    <img id="secondImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der-Kolk.png" alt="">
                </div>
            </div>
            <h3 class="title-Direct-een"><strong>Direct een afspraak inplannen?</strong><br> Hulp nodig of heb je vragen over LiveLearn? Wij zijn er om je te helpen.</h3>
            <button class="btn btn-kies" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;">Kies een datum</button>
        </div>
    </div>
    <div class="blockCardBleu3">
        <div class="container-fluid">
            <div class="contentSix">
                <a href="/opleiders/" class="cardBoxSix">
                    <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/alle-opleiders.png" alt="">
                    <p class="textAlloOP">Alle opleiders</p>
                    <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
                </a>
                <a href="/Onderwerpen/" class="cardBoxSix">
                    <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/all-onderwerpen.png" alt="">
                    <p class="textAlloOP">Alle onderwerpen</p>
                    <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
                </a>
                <a href="/product-search/" class="cardBoxSix">
                    <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/all-opleidegen.png" alt="">
                    <p class="textAlloOP">Alle opleidingen</p>
                    <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
                </a>
                <a href="/skills-passport/" class="cardBoxSix">
                    <img class="imgCategoryCard" src="<?php echo get_stylesheet_directory_uri();?>/img/skills-passport.png" alt="">
                    <p class="textAlloOP">Skills paspoort</p>
                    <img class="imgPolygone" src="<?php echo get_stylesheet_directory_uri();?>/img/Polygone.png" alt="">
                </a>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="productBlock3">
            <p class="TitleWat">Wat je niet mag missen</p>

            <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">

                <?php
                $author_id = 0;
                foreach($users as $user){
                    $name_user = strtolower($user->data->display_name);
                    if($name_user == "Livelean" || $name_user == "livelean"){
                        $author_id = intval($user->data->ID);
                        $name_user = $user->display_name;
                        $featured = get_field('featured', 'user_' . $author_id);
                        if($featured)
                            break;
                    }
                }

                if(!empty($featured))
                    $courses = $featured;

                $i = 0;

                foreach($courses as $course){
                    $bool = true;
                    $bool = visibility($course, $visibility_company);
                    if(!$bool)
                        continue;

                    //Course type
                    $course_type = get_field('course_type', $course->ID);

                    /*
                    * Categories
                    */
                    $category = '';
                    $category_id = 0;
                    $category_str = 0;
                    if($category == ''){
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

                    /*
                    *  Date and Location
                    */
                    $day = "-";
                    $month = 'Virtual';
                    $location = "Not defined";

                    $data = get_field('data_locaties', $course->ID);
                    if($data){
                        $date = $data[0]['data'][0]['start_date'];
                        $day = explode(' ', $date)[0];
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
                            }
                        }
                    }

                    /*
                    * Price
                    */
                    $p = get_field('price', $course->ID);
                    if($p != "0")
                        $price =  number_format($p, 2, '.', ',');
                    else
                        $price = 'Gratis';

                    /*
                    * Image
                    */
                    $thumbnail = get_field('preview', $course->ID)['url'];
                    if(!$thumbnail){
                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_field('url_image_xml', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                    }

                    //Company
                    $company = get_field('company',  'user_' . $course->post_author);

                    //Short description
                    $short_description = get_field('short_description', $course->ID);
                    //Author
                    $author = get_user_by('ID', $course->post_author);
                    $author_name = $author->display_name ?: $author->first_name;
                    $author_image = get_field('profile_img',  'user_' . $author_object->ID);
                    $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                    //Clock duration
                    $duration_day = get_field('duration_day', $post->ID) ? : '-';

                    $find = true;
                    ?>

                    <a href="<?= get_permalink($course->ID); ?>" class="new-card-course">
                        <div class="head">
                            <?php
                            echo '<img src="' . $thumbnail .'" alt="">';
                            ?>
                        </div>
                        <div class="title-favorite d-flex justify-content-between align-items-center">
                            <p class="title-course"><?= $course->post_title ?></p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                            <div class="blockOpein d-flex align-items-center">
                                <i class="fas fa-graduation-cap"></i>
                                <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                            </div>
                            <div class="blockOpein">
                                <i class="fas fa-map-marker-alt"></i>
                                <p class="lieuAm"><?php echo $location?></p>
                            </div>
                        </div>
                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="blockImgUser">
                                    <img src="<?= $author_image ?>" class="" alt="">
                                </div>
                                <p class="autor"><?= $author_name ?></p>
                            </div>
                            <p class="price"><?= $price ?></p>
                        </div>

                    </a>

                    <?php
                    $i++;
                    if($i == 5)
                        break;
                }?>

            </div>

        </div>
    </div>

    <div class="container-fluid">
        <div class="doawnloadBlockHome">
            <h3>Je bent nu ver genoeg naar beneden gescrold,
                je kan de app hier gratis downloaden:</h3>
            <div class="d-flex justify-content-center">
                <a href="https://apps.apple.com/nl/app/livelearn/id1666976386" class="btn btnStore">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/btn-app-store.png" alt="">
                </a>
                <a href="https://play.google.com/store/apps/details?id=com.livelearn.livelearn_mobile_app" class="btn btnPlayGoogle">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/btn-google-play.png" alt="">
                </a>
            </div>
            <img class="doanloadIllustration" src="<?php echo get_stylesheet_directory_uri();?>/img/happyDoawnload.png" alt="">
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <?php get_footer(); ?>
    <?php wp_footer(); ?>

    <script src="<?php echo get_stylesheet_directory_uri();?>/mobapiCity.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/js/jquery.bsSelectDrop.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.lazyload.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:13,
            items:3.4,
            lazyLoad:true,
            responsiveClass:true,
            autoplayHoverPause:true,
            nav:false,
            merge:true,
            URLhashListener:true,
            responsive:{
                0:{
                    items:1.1,
                    nav:true
                },
                600:{
                    items:2.2,
                    nav:false
                },
                1000:{
                    items:3.4,
                    nav:true,
                    loop:false
                }
            }
        })
    </script>

    <script>
        (function($){
            let classes = ['outline-custom'];
            let selects = $('.selectSearchHome');
            selects.each(function(i, e){
                let randomClass  = classes[Math.floor(Math.random() * classes.length)];
                $(this).bsSelectDrop({
                    autocomplete: 'one',
                    btnClass: 'btn btn-'+classes[i],
                    btnWidth: 'auto',
                    darkMenu: false,
                    showSelectionAsList: false,
                    showActionMenu: true,

                });
            })
        }(jQuery));
    </script>
    <script>
        $(document).ready(function() {
            const video = $('#videoFrame')[0];
            const modal = $('.modal');
            const closeBtn = $('.close');

            // Pause video when modal is closed
            modal.on('hide.bs.modal', function() {
                video.pause();
            });

            // Pause video and close modal when close button is clicked
            closeBtn.on('click', function() {
                video.pause();
                modal.modal('hide');
            });
        });

    </script>
    <script>
        $(function() {
            var header = $(".navbar");
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 61) {
                    header.addClass("scrolled");
                } else {
                    header.removeClass("scrolled");
                }
            });

        });
    </script>

    <script src="<?php echo get_stylesheet_directory_uri();?>/city.js"></script>

    <script>

        $('.bangricht').click(()=>{
            alert('bangricht');
        });

        $('#search').keyup(function(){
            var txt = $(this).val();
            var typo = $("#course_type option:selected").val();
            event.stopPropagation();

            $("#list").fadeIn("fast");

            $(document).click( function(){

                $('#list').hide();

            });

            if(txt){
                $.ajax({

                    url:"/fetch-ajax",
                    method:"post",
                    data:{
                        search:txt,
                        typo: typo,
                    },
                    dataType:"text",
                    success: function(data){
                        console.log(data);
                        $('#autocomplete').html(data);
                    }
                });
            }
            else
                $('#autocomplete').html("<center> <small>Typing ... </small> <center>");
        });
    </script>

    <script>
        $('.bntNotification').click((e)=>{
            $.ajax({
                url:"/read-notification",
                method:"get",
                data:
                    {
                    },
                dataType:"text",
                success: function(data){
                    // Get the modal
                    console.log(data);
                    var modal = document.getElementById("ModalNotification");
                    // $('.display-fields-clean').html(data)
                    // Get the button that opens the modal


                    // Get the <span> element that closes the modal
                    //var span = document.getElementsByClassName("close")[0];

                    // When the user clicks on the button, open the modal

                    modal.style.display = "block";

                    // When the user clicks on <span> (x), close the modal
                    // span.onclick = function() {
                    //     modal.style.display = "none";
                    // }

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }

                }
            });
        });
    </script>

    <script>
        $('#topic_search').change(function(){
            var topic_search = $("#topic_search option:selected").val();

            var complete_categorieen = $("#topic_search option:selected").text();
            $('#complete-categorien').html(complete_categorieen);

            $.ajax({
                url:"/fetch-ajax-home2",
                method:"post",
                data:{
                    topic_search: topic_search,
                },
                dataType: "text",
                beforeSend:function (elt) {
                    $('#loader').removeClass('d-none');
                    console.log('before sending...',topic_search)
                },
                success: function(data){
                    console.log('elt : ',data);
                    $('#autocomplete_categorieen').html(data);
                },
                error: function (err) {
                    console.log('error : ',err);
                },
                complete:function (complete) {
                    $('#loader').addClass('d-none');
                }
            });
        });
    </script>

    <script>
        $('#period').change(function(){
            var selectedOptions = $(this).find("option:selected")[0];
            var period = selectedOptions.value;
            var complete_period = selectedOptions.text;
            $('#complete-period').html(complete_period);
            $.ajax({
                url:"/fetch-ajax-home2",

                method:"post",
                data:{
                    period: period,
                },
                dataType: "text",
                beforeSend:function (elt) {
                    $('#loader').removeClass('d-none');
                    console.log('before sending...',period)
                },
                success: function(data){
                    console.log('elt');
                    $('#autocomplete_categorieen').html(data);
                },
                error: function (error) {
                    console.log('error : ',error);
                },
                complete:function (complete) {
                    $('#loader').addClass('d-none');
                    console.log(complete)
                }
            });
        });
    </script>