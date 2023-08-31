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

$user = get_users(array('include'=> $id_user))[0]->data;

//CONNECTED USER INFORMATIONS
$user_connected = wp_get_current_user();

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';
    
$company = get_field('company',  'user_' . $user->ID);
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

if(!empty($company))
    $company_name = $company[0]->post_title;

//Skills 
$topics_external = get_user_meta($user->ID, 'topic');
$topics_internal = get_user_meta($user->ID, 'topic_affiliate');

$topics_user = array();
if(!empty($topics_external))
    $topics_user = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics_user, $value);

//Note
$skills_note = get_field('skills', 'user_' . $user->ID);

$experts = get_user_meta($user->ID, 'expert');

$user_role = get_users(array('include'=> $id_user))[0]->roles;

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