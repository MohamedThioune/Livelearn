<?php

if(isset($_GET['manager'])){
    if(isset($_GET['id']))
        $id_user = $_GET['id'];
    
    if(isset($id_user))
        $managed = get_field('managed',  'user_' . get_current_user_id());
        if(in_array($id_user, $managed))
            $superior = get_users(array('include'=> $_GET['manager']))[0]->data;
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

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';
    
$company = get_field('company',  'user_' . $user->ID);
$function = get_field('role',  'user_' . $user->ID);
$experience = get_field('experience',  'user_' . $user->ID);
$country = get_field('country',  'user_' . $user->ID);
$date_born = explode ('/', get_field('age',  'user_' . $user->ID))[2];
$age = date('Y') - intval($date_born);
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
    $company = $company[0]->post_title;

/*
* * Get interests topics and experts
*/

$topics_internal = get_user_meta($user->ID,'topic_affiliate');
$topics_external = get_user_meta($user->ID,'topic');
$topics = array_merge($topics_internal, $topics_external); 

$experts = get_user_meta($user->ID, 'expert');
?>
<div class="theme-content">
    <div class="theme-side-menu">
        <?php 
            if(isset($superior)){
                include_once('dashboard-menu-company.php');
            }else{
                include_once('dashboard-menu-user.php');
            }
        ?>
    </div>
    <div class="theme-learning">
        <?php 
            if(isset($superior)){
                include_once('dashboard-company-profile-home.php');
            }else{
                include_once('dashboard-user-profile-home.php');
            }
        ?>
    </div>
</div>
