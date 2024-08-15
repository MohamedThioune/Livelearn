<?php /** Template Name: dashboard core */ ?>
<?php

//$page = 'check_visibility.php';
//require($page); 
require('module-subscribe.php'); 

$mail_notification_invitation = '/mail-notification-invitation.php';
require(__DIR__ . $mail_notification_invitation); 

global $wpdb;
global $wp;

if(is_user_logged_in()){
    acf_form_head();
} 

$table = $wpdb->prefix . 'databank';

// Forgot page request 
$is_forgot_page = false;
$url_base = $wp->request;
$option_menu = explode('/', $url_base);
if(isset($option_menu[2]))
        if($option_menu[2] == 'forgot-password' || $option_menu[2] == 'lost-password')
            $is_forgot_page = true;
// var_dump($option_menu);
// die();

$user_connected = get_current_user_id();
$user_data = wp_get_current_user();

// if(!$user_connected && !$is_forgot_page)
if(!$user_connected)
    header('Location: /');

$message = ""; 
extract($_POST);

function RandomString(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 10; $i++) {
        $rand = $characters[rand(0, strlen($characters))];
        $randstring .= $rand;  
    }
    return $randstring;
}

function makeApiCall($endpoint, $type) {
    // credentials
    $params = array(
        // login url params required to direct user to facebook and promt them with a login dialog
        'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
        'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    );

    // initialize curl
    $ch = curl_init();

    $output_type = ( $type == 'GET' ) ? false : true; 

    // create endpoint with params
    $apiEndpoint = $endpoint . '?' . http_build_query( $params );
    
    // set other curl options
    curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
    curl_setopt($ch, CURLOPT_POST, $output_type);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    // get response
    $response = curl_exec( $ch );
    if ($response === false) {
        $response = curl_error($ch);
        $error = true;
        echo stripslashes($response);
        return false;
    }

    // close curl
    curl_close( $ch );

    // return data
    return json_decode( $response, true );
}

//Subscribe to 10 experts: "Thank you so much for supporting our content creator !" 
//Subscribe to 10 topics: "Looks like you're a category enthusiast !"
function topic_expert_badges(){
    $user_visibility = wp_get_current_user();
    $user_id = $user_visibility->ID;
    $count = ['Expert' => 0 , 'Ondewerpen' => 0];
    $libelle_badges = [
        'Thank you ' . $user_visibility->display_name . ' so much for supporting our content creator !',
        $user_visibility->display_name . ' Looks like you\'re enjoying to explore our various topics !',
    ];
    $trigger_badges = [
        'Subscribe to 10 experts !',
        'Subscribe to 10 categories !',
    ];
    $array_badges = array();
    $topics_followed = get_user_meta($user_id, 'topic');
    $experts_followed = get_user_meta($user_id, 'expert');
    $count['Ondewerpen'] = (!empty($topics_followed)) ? count($topics_followed) : 0;
    $count['Expert'] = (!empty($experts_followed)) ? count($experts_followed) : 0;

    $image_badge = get_stylesheet_directory_uri() . '/img/badge-assessment-sucess.png';
    $trigger_badge = null;
    if($count['Expert'] >= 10){
        $level = 'advance';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[0];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[0];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }
    if($count['Ondewerpen'] >= 10){
        $level = 'advance';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[1];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[1];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }

    foreach($array_badges as $badge)
        if($badge){
            //Occurrence check
            $args = array(
                'post_type' => 'badge', 
                'title' => $badge->libelle,
                'post_status' => 'publish',
                'author' => $user_id,
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );
            $badges = get_posts($args);

            if(empty($badges)){
                $post_data = array(
                    'post_title' => $badge->libelle,
                    'post_author' => $user_id,
                    'post_type' => 'badge',
                    'post_status' => 'publish'
                );
                $badge_id = wp_insert_post($post_data);

                //Push notifications
                $title = $badge->libelle;
                $body = $badge->trigger;
                sendPushNotification($title, $body);
            }

            if(isset($badge_id))
                if($badge_id){
                    update_field('image_badge', $badge->image, $badge_id);
                    update_field('trigger_badge', $badge->trigger, $badge_id);
                    update_field('level_badge', $badge->level, $badge_id);
                }
        } 
}

// Purchase your first course: "Congratulations on your first course purchase !"  ????
function purchase_badges(){
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $count_enrolled = 0;

    //Orders - enrolled courses  
    $args = array(
        'customer_id' => $user_id,
        'post_status' => array('wc-processing', 'wc-completed'),
        'orderby' => 'date',
        'order' => 'DESC',
        'limit' => -1,
    );
    //$bunch_orders = wc_get_orders($args);
    $bunch_orders = array();

    foreach($bunch_orders as $order){
        foreach ($order->get_items() as $item_id => $item ) {
            //Get woo orders from user
            if($item->get_product_id()){
                $id_course = intval($item->get_product_id()) - 1;
                $count_enrolled += 1;  
                break;
            }
        }
        if($count_enrolled)
            break;
    }

    //Badges
    $libelle_badges = [
        'Congratulations ' . $user_visibility->display_name . ' on your first course purchase !',
    ];
    $trigger_badges = [
        'Purchase your first course',
    ];
    $array_badges = array();

    $image_badge = get_stylesheet_directory_uri() . '/img/badge-assessment-sucess.png';
    $trigger_badge = null;
    if($count_enrolled >= 1){
        $level = 'pro';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[0];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[0];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }

    foreach($array_badges as $badge)
        if($badge){
            //Occurrence check
            $args = array(
                'post_type' => 'badge', 
                'title' => $badge->libelle,
                'post_status' => 'publish',
                'author' => $user_id,
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );
            $badges = get_posts($args);

            if(empty($badges)){
                $post_data = array(
                    'post_title' => $badge->libelle,
                    'post_author' => $user_id,
                    'post_type' => 'badge',
                    'post_status' => 'publish'
                );
                $badge_id = wp_insert_post($post_data);

                //Push notifications
                $title = $badge->libelle;
                $body = $badge->trigger;
                sendPushNotification($title, $body);
            }

            if(isset($badge_id))
                if($badge_id){
                    update_field('image_badge', $badge->image, $badge_id);
                    update_field('trigger_badge', $badge->trigger, $badge_id);
                    update_field('level_badge', $badge->level, $badge_id);
                }
        } 

}
purchase_badges();

//You joined 3 communities : "Communities for the best" 
function community_badges(){
    $user_visibility = wp_get_current_user();
    $user_id = $user_visibility->ID;
    $count_communities = 0;
    $libelle_badges = [
        'Communities for the best !',
    ];
    $trigger_badges = [
        'You joined 3 communities',
    ];
    $array_badges = array();

    $args = array(
        'post_type' => 'community',
        'post_status' => 'publish',
        'order' => 'DESC',
        'posts_per_page' => -1
    );
    
    $communities = get_posts($args);
    foreach($communities as $key => $value){

        if(!$value)
            continue;

        //Followers
        $max_follower = 0;
        $followers = get_field('follower_community', $value->ID);
        if(!empty($followers))
            $max_follower = count($followers);
        $bool = false;
        foreach ($followers as $key => $item)
            if($item->ID == $user_id){
                $bool = true;
                $count_communities +=1;
            }
    }

    $image_badge = get_stylesheet_directory_uri() . '/img/badge-assessment-sucess.png';
    $trigger_badge = null;
    if($count_communities >= 3){
        $level = 'advance';
        $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
        $array_badge = array();
        $array_badge['level'] = $level;
        $array_badge['libelle'] = $libelle_badges[0];
        $array_badge['image'] = $image_badge;
        $array_badge['trigger'] = $trigger_badges[0];
        $object_badge = (Object)$array_badge;
        array_push($array_badges, $object_badge);
    }

    foreach($array_badges as $badge)
        if($badge){
            //Occurrence check
            $args = array(
                'post_type' => 'badge', 
                'title' => $badge->libelle,
                'post_status' => 'publish',
                'author' => $user_id,
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );
            $badges = get_posts($args);

            if(empty($badges)){
                $post_data = array(
                    'post_title' => $badge->libelle,
                    'post_author' => $user_id,
                    'post_type' => 'badge',
                    'post_status' => 'publish'
                );
                $badge_id = wp_insert_post($post_data);

                //Push notifications
                $title = $badge->libelle;
                $body = $badge->trigger;
                sendPushNotification($title, $body);
            }

            if(isset($badge_id))
                if($badge_id){
                    update_field('image_badge', $badge->image, $badge_id);
                    update_field('trigger_badge', $badge->trigger, $badge_id);
                    update_field('level_badge', $badge->level, $badge_id);
                }
        } 
}

if(isset($_POST['expert_add']) || isset($_POST['expert_add_artikel'])){
    $bunch = get_field('experts', $_GET['id']);
    if(!empty($bunch)){
        $experts = $_POST['experts'];
        foreach($experts as $expert)
            if(!in_array($expert, $bunch))
                array_push($bunch, $expert);
    }
    else
        $bunch = $_POST['experts'];
    
    update_field('experts', $bunch, $_GET['id']);
    if(isset($_POST['expert_add']))
        $path = "/dashboard/teacher/course-overview/?message=Cursus succesvol bijgewerkt ✔️";
    else
        $path = "/blogs/?message=Artikel succesvol bijgewerkt ✔️";

    header('Location:' . $path);
}

else if(isset($_POST['topic_add'])){

    $categories = array();
    $banger = "";
    $functie = "";
    $skill = "";
    $interes = "";

    $hashtag_banger = $_POST['hashtag_banger'];
    $hashtag_funct = $_POST['hashtag_funct'];
    $hashtag_skill = $_POST['hashtag_skill'];
    $hashtag_interes = $_POST['hashtag_interes'];


    foreach($hashtag_banger as $key => $hashtag){
        $banger .= $hashtag;
        if(isset($hashtag_banger[$key+1]))
            $banger .= ',';
    }

    foreach($hashtag_funct as $key => $hashtag){
        $functie .= $hashtag;
        if(isset($hashtag_funct[$key+1]))
            $functie .= ',';
    }
    
    foreach($hashtag_skill as $key => $hashtag){
        $skill .= $hashtag;
        if(isset($hashtag_skill[$key+1]))
            $skill .= ',';
    }

    foreach($hashtag_interes as $key => $hashtag){
        $interes .= $hashtag;
        if(isset($hashtag_interes[$key+1]))
            $interes .= ',';
    }

    if($banger != "")
        array_push($categories, $banger);
    if($functie != "")
        array_push($categories, $functie);
    if($skill != "")
        array_push($categories, $skill);
    if($interes != "")
        array_push($categories, $interes);

    update_field('categories', $categories, $_GET['id']);
}
 
else if(isset($_POST['add_todo'])){

    $id_user = $_POST['id_user'];
    $label = $_POST['label'];
    $description = $_POST['description'];
    $bunch = array();
    $fields = " ";
    $state = 0;
    $bunch = get_field('todos',  'user_' . $id_user);
    $fields = $label . ';' . $description . ';' . get_current_user_id() . ';' . $state;
    array_push($bunch, $fields);  
    if(!empty($bunch))
        update_field('todos', $bunch, 'user_'. $id_user);
    else
        update_field('todos', $fields, 'user_'.$id_user);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

else if(isset($_POST['edit_education'])){
    $bunch = array();
    $fields = " ";
    foreach($educations as $key => $value){
        if($key == $id)
            continue;
        else
            array_push($bunch,$value);
    }
    update_field('education', $bunch, 'user_'. $user->ID);
    $educations = get_field('education',  'user_' . $user->ID);
}

/*
* * Push saved  
*/

else if(isset($interest_save)){
    if($meta_value != null){
        $meta_data = get_user_meta($user_id, $meta_key);
        if(!in_array($meta_value,$meta_data)){
            if($meta_key == 'expert'){
                $user_expert = get_user_by('id', $user_id);
                $first_name = $user_expert->first_name ?: $user_expert->display_name;
                $email = $user_expert->user_email;
                $mail_page = 'mail-new-follower.php';
                require($mail_page); 
                
                $subject = 'Je hebt een nieuwe volger !';
                $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                wp_mail($email, $subject, $mail_new_followed_body, $headers, array( '' )) ;
            }
            add_user_meta($user_id, $meta_key, $meta_value);
            $message = "Succesvol opgeslagen cursus";
        }else{
            $message = "Al opgeslagen";
        }
        header("location:/dashboard/user/activity/?message=".$message);
    }
}

/**
 * Start Feedback Handling
*/

// Feedback & compliment saving 
else if(isset($_POST['add_todo_feedback']) || isset($_POST['add_todo_compliment']) ){
    $id_user = $_POST['id_user'];
    $manager = $_POST['manager'];
    $type = $_POST['type'];
    $title_feedback = $_POST['title_feedback'];

    $onderwerp_feedback='';
    if (isset ($_POST['onderwerp_feedback']) && !empty($_POST['onderwerp_feedback']))
        foreach ($_POST['onderwerp_feedback'] as  $value) 
            $onderwerp_feedback .= $value.';';        
        
    $beschrijving_feedback = $_POST['beschrijving_feedback'];
    $competencies_feedback = $_POST['competencies_feedback'];
    $rating_feedback = (isset($_POST['rating_feedback'])) ? $_POST['rating_feedback'] : 0;
    $opmerkingen = $_POST['opmerkingen'];
    $anoniem_feedback = (isset($_POST['anoniem_feedback'])) ? $_POST['anoniem_feedback'] : null;

    //Data to create the feedback
    $post_data = array(
        'post_title' => $title_feedback,
        'post_author' => $id_user,
        'post_type' => 'feedback',
        'post_status' => 'publish'
      );

    //Create the feedback
    $post_id = wp_insert_post($post_data);

    //Add further informations for feedback
    update_field('onderwerp_feedback', $onderwerp_feedback, $post_id);
    update_field('manager_feedback', $manager, $post_id);
    update_field('type_feedback', $type, $post_id);
    update_field('beschrijving_feedback', $beschrijving_feedback, $post_id);
    update_field('competencies_feedback', $competencies_feedback, $post_id);
    update_field('rating_feedback', $rating_feedback, $post_id);
    update_field('opmerkingen', $opmerkingen, $post_id);
    update_field('anoniem_feedback', $anoniem_feedback, $post_id);

    //Push notifications
    $title = $title_feedback;
    $body = $beschrijving_feedback;
    sendPushNotification($title, $body);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

// Beoordelingsgesprek saving
else if(isset($_POST['add_todo_beoordelingsgesprek'])){
    $id_user = $_POST['id_user'];
    $title_beoordelingsgesprek = $_POST['title_beoordelingsgesprek'];
    $type = $_POST['type'];
    $manager = $_POST['manager'];

    $algemene_beoordeling = $_POST['algemene_beoordeling'];
    $competencies_feedback = $_POST['competencies_feedback'];
    $welke_datum_feedback = $_POST['welke_datum_feedback'];
    $opmerkingen = $_POST['opmerkingen'];
    $beschrijving_feedback = (isset($_POST['beschrijving_feedback'])) ? $_POST['beschrijving_feedback'] : null;
    $anoniem_feedback = (isset($_POST['anoniem_feedback'])) ? $_POST['anoniem_feedback'] : null;

    $rates_comments='';
    $topic_affiliate = get_user_meta($id_user,'topic_affiliate');
    if (isset ($topic_affiliate) &&  !empty($topic_affiliate))
    {
        foreach ($topic_affiliate as $value) {
            $rate_topic = $_POST[lcfirst((String)get_the_category_by_ID($value)).'_rate'];
            $comment_topic = $_POST[lcfirst((String)get_the_category_by_ID($value)).'_toelichting'];
            $rates_comments = $rates_comments.$value.';'.$rate_topic.';'.$comment_topic.';';
        }
        $rates_comments=substr_replace($rates_comments ,"",-1);
    }
    $bunch = array();
    $state = 0;

    //Data to create the Beoordelingsgesprek feedback
    $post_data = array(
        'post_title' => $title_beoordelingsgesprek,
        'post_author' => $id_user,
        'post_type' => 'feedback',
        'post_status' => 'publish'
    );

    $post_id = wp_insert_post($post_data);
    //Add further informations for Beoordelingsgesprek
    update_field('rate_comments', $rates_comments, $post_id);
    update_field('manager_feedback', $manager, $post_id);
    update_field('type_feedback', $type, $post_id);
    update_field('algemene_beoordeling', $algemene_beoordeling, $post_id);
    update_field('welke_datum_feedback', $welke_datum_feedback, $post_id);
    update_field('opmerkingen', $opmerkingen, $post_id);
    update_field('anoniem_feedback', $anoniem_feedback, $post_id);
    update_field('beschrijving_feedback', $anoniem_feedback, $post_id);

    //Push notifications
    $title = $title_beoordelingsgesprek;
    $body = $opmerkingen;
    sendPushNotification($title, $body);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

//Persoonlijk ontwikkelplan saving
else if(isset($_POST['add_todo_persoonlijk']))
{
    $id_user = $_POST['id_user'];
    $title_feedback = $_POST['title_persoonlijk'];
    $type = $_POST['type'];
    $manager = $_POST['manager'];

    $onderwerp_feedback = '';
    if (isset ($_POST['onderwerp_pop']) &&  !empty($_POST['onderwerp_pop']))
        foreach ($_POST['onderwerp_pop'] as $value) {
            $onderwerp_feedback .= $value.';';        
        }

    $wat_bereiken = $_POST['wat_bereiken'];  
    $hoe_bereiken = $_POST['hoe_bereiken'];
    $hulp_text = $_POST['hulp_text'];
    $opmerkingen = $_POST['opmerkingen'];
    $competencies_feedback = $_POST['competencies_feedback'];
    $rating_feedback = (isset($_POST['rating_feedback'])) ? $_POST['rating_feedback'] : 0;
    $anoniem_feedback = (isset($_POST['anoniem_feedback'])) ? $_POST['anoniem_feedback'] : null;

    if (isset($_POST['hulp_radio_JA']) && !empty ($_POST['hulp_radio_JA']))
        $hulp_radio = $_POST['hulp_radio_JA'];
            
    //Data to create the feedback
    $post_data = array(
        'post_title' => $title_feedback,
        'post_author' => $id_user,
        'post_type' => 'feedback',
        'post_status' => 'publish'
      );

    //Create the feedback
    $post_id = wp_insert_post($post_data);

    //Add further informations for feedback
    update_field('onderwerp_feedback', $onderwerp_feedback, $post_id);
    update_field('je_bereiken', $wat_bereiken, $post_id);
    update_field('je_dit_bereike', $hoe_bereiken, $post_id);
    update_field('hulp_nodig', $hulp_radio_JA, $post_id);
    update_field('manager_feedback', $manager, $post_id);
    update_field('type_feedback', $type, $post_id);
    update_field('competencies_feedback', $competencies_feedback, $post_id);
    update_field('rating_feedback', $rating_feedback, $post_id);
    update_field('opmerkingen', $opmerkingen, $post_id);
    update_field('anoniem_feedback', $anoniem_feedback, $post_id);

    //Push notifications
    $title = $title_feedback;
    $body = $opmerkingen;
    sendPushNotification($title, $body);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

// Mandatory
else if(isset($_POST['add_todo_sample'])){

    //Fields constant
    $id_user = $_POST['id_user'];
    $title_todo = $_POST['title_todo'];
    $type = $_POST['type'];
    $manager = $_POST['manager'];

    //Fields variable ...
    $interne_cursus = (isset($_POST['interne_cursus'])) ? intval($_POST['interne_cursus']) : null;
    $externe_cursus = (isset($_POST['externe_cursus'])) ? intval($_POST['externe_cursus']) : null;
    $opmerkingen = (isset($_POST['opmerkingen'])) ? $_POST['opmerkingen'] : null;
    $collegas_feedback = (isset($_POST['collegas_feedback'])) ? $_POST['collegas_feedback'] : null;
    $welke_datum_feedback = (isset($_POST['welke_datum_feedback'])) ? $_POST['welke_datum_feedback'] : null;
    $beschrijving_feedback = (isset($_POST['beschrijving_feedback'])) ? $_POST['beschrijving_feedback'] : null;
    $competencies_feedback = (isset($_POST['competencies_feedback'])) ? $_POST['competencies_feedback'] : null;
    $onderwerpen_todo = (isset($_POST['onderwerpen_todo'])) ? $_POST['onderwerpen_todo'] : null;
    
    if($interne_cursus)
        $post_cursus = (get_post($interne_cursus)) ?: 0;
    else 
        $post_cursus = (get_post($externe_cursus)) ?: 0;
    $post_name = ($type == 'Verplichte cursus' && (!empty($post_cursus))) ? $post_cursus->post_name : $title_todo;

    //Data to create the feedback
    $post_data = array(
        'post_title' => $post_name,
        'post_author' => $id_user,
        'post_type' => 'mandatory',
        'post_status' => 'publish'
      );

    //Create the feedback
    $post_id = wp_insert_post($post_data);

    //Add further informations for feedback
    update_field('title_todo', $title_todo, $post_id);
    update_field('type_feedback', $type, $post_id);
    update_field('manager_feedback', $manager, $post_id);
    update_field('message_must', $beschrijving_feedback, $post_id);
    update_field('competencies_feedback', $competencies_feedback, $post_id);
    update_field('opmerkingen', $opmerkingen, $post_id);
    update_field('collegas_feedback', $collegas_feedback, $post_id);
    update_field('welke_datum_feedback', $welke_datum_feedback, $post_id);
    update_field('onderwerpen_todo', $onderwerpen_todo, $post_id);

    //Push notifications
    $title = $title_todo;
    $body = $opmerkingen;
    sendPushNotification($title, $body);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}
else if (isset($_POST['add_internal_growth'])){
    $id_user = $_POST['id_user'];
    $manager = get_current_user_id();
    $selected_subtopics = $_POST['selected_subtopics'];
    $bunch = get_user_meta($id_user,'topic_affiliate');
    foreach($selected_subtopics as $subtopic){
       if(!in_array($subtopic,$bunch))
           add_user_meta($id_user,'topic_affiliate',$subtopic);
    }      
    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=U hebt vaardigheden toegewezen aan uw werknemer ✅"; 
    header("Location: ". $message);
}

    
/**
 * End Feedback Handling
*/


/*
* * Push interests  
*/

else if(isset($interest_push)){
    if($meta_value != null){
        $meta_data = get_user_meta($user_id, $meta_key);
        if(!in_array($meta_value,$meta_data)){
            //Email send expert
            if($meta_key == 'expert'){
                $user_expert = get_user_by('id', $user_id);
                $first_name = $user_expert->first_name ?: $user_expert->display_name;
                $email = $user_expert->user_email;
                $mail_page = 'mail-new-follower.php';
                require($mail_page); 
                
                $subject = 'Je hebt een nieuwe volger !';
                $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                wp_mail($email, $subject, $mail_new_followed_body, $headers, array( '' )) ;
            }
            add_user_meta($user_id, $meta_key, $meta_value);

            // Badges
            topic_expert_badges();
            
            //Redirect to 
            $message = "Succesvol followed";
            if(isset($artikel))
                $path = "location: " . get_permalink($artikel) . "/?message=" . $message;
            else if(isset($category))
                $path = "location: /category-overview/?category=" . $meta_value  . "&message=" . $message;
            else if(isset($expert))
                $path = "location: /user-overview/?id=" . $meta_value  . "&message=" . $message;
            else
                $path = "location: /dashboard/user/?message=" . $message;

            header($path);
        }else{
            //Redirect to 
            $message = "Reeds aanwezig in jouw favorieten";
            if(isset($artikel))
                $path = "location: " . get_permalink($artikel) . "/?message=" . $message;
            else if(isset($category))
                $path = "location: /category-overview/?category=" . $meta_value  . "&message=" . $message;
            else if(isset($expert))
                $path = "location: /user-overview/?id=" . $meta_value  . "&message=" . $message;
            else
                $path = "location: /dashboard/user/?message=" . $message;
            
            header($path);
        }
    }
}

/*
* *
*/


/*
* * Delete interests  
*/

else if(isset($delete)){
    if($meta_value != null){
        if(delete_user_meta($user_id, $meta_key, $meta_value)){
            $message = "Succesvol unfollowed";
            $user_connected = get_current_user_id();

            if(isset($artikel))
                $path = "location: " . get_permalink($artikel) . "/?message=" . $message;
            else if(isset($category))
                $path = "location: /category-overview/?category=" . $meta_value  . "&message=" . $message;
            else if(isset($expert))
                $path = "location: /user-overview/?id=" . $meta_value  . "&message=" . $message;
            elseif($meta_key == "topic" || $meta_key == "topic_affiliate")
                $path = "location: /dashboard/user/?message=" . $message;
            else
                $path = "/dashboard/company/profile/?id=" . $user_id . '&manager='. $user_connected . "?message=" . $message; 

            header($path);
            }
    }
}

/*
* * Delete Favorite  
*/

else if(isset($delete_favorite)){
    $user_id = get_current_user_id();
    if($meta_value != null){
        if(delete_user_meta($user_id, "course", $meta_value))
            $message = "Met succes verwijderd";
        
        header("location:/dashboard/user/activity/?message=".$message);
    }
}

/*
* * Delete Feedbacks   
*/ 

else if(isset($delete_todos)){
    $message = "Met succes verwijderd";
    $user_connected = get_current_user_id();
    wp_delete_post($_POST['id']);

    $content = "/dashboard/company/profile/?id=" . $user_id . '&manager='. $user_connected . "?message=" . $message; 
    header("location:".$content);
}
 
/*
* * Road path   
*/ 

else if(isset($road_path_created)){

    $user_id = get_current_user_id();

    $courses = array();
    
    foreach($road_path as $id)
        array_push($courses, get_post($id));    

    //Data to create the feedback
    $post_data = array(
        'post_title' => $title_road_path,
        'post_author' => $user_id,
        'post_type' => 'learnpath',
        'post_status' => 'publish'
      );

    //Create the feedback
    $post_id = wp_insert_post($post_data);

    /*
    * Add further informations for feedback
    */
    update_field('road_path', $courses, $post_id);

    foreach($topics as $topic){
        if(is_wp_error(!$topic))
            continue;
        if($topic != '')
            update_field('topic_road_path', $topic, $post_id);
    }

    $message = "/dashboard/teacher/road-path/?id=". $post_id . "&message=Road path created successfully"; 
    header("Location: ". $message);
    
}

else if(isset($road_path_edited)){
    $courses = array();
    
    foreach($road_path as $road)
        array_push($courses, get_post($road));

    if(!empty($courses)){
        delete_field('road_path',$id);
        update_field('road_path', $courses, $id);
    }

    $message = "/dashboard/teacher/road-path/?id=". $id . "&message=Road path updated successfully"; 
    header("Location: ". $message);
} 

else if(isset($road_course_add)){
    $courses = array();
    
    foreach($road_path as $id)
        array_push($courses, get_post($id));    

    //Data to create the feedback
    $post_data = array(
        'post_title' => $title_road_path,
        'post_author' => $user_id,
        'post_type' => 'learnpath',
        'post_status' => 'publish'
      );

    $leerpaden = get_field('road_path', $leerpad_id);

    foreach($road_path as $road)
        array_push($courses, get_post($road));

    if(!empty($courses)){
        $road_path = array_merge($leerpaden, $courses);
        update_field('road_path', $road_path, $leerpad_id);
    }

    $message = "/dashboard/teacher/road-path/?id=". $leerpad_id . "&message=Road path updated successfully"; 
    header("Location: ". $message);
} 

else if(isset($review_post) || isset($review_expert)){        
    $reviews = (isset($review_post)) ? get_field('reviews', $course_id) : get_field('user_reviews', 'user_' . $expert_id);
    $review = array();
    $review['user'] = wp_get_current_user();
    $review['rating'] = $rating;
    $review['feedback'] = $feedback_content;
    if($review['user']){ 
        if(!$reviews)
            $reviews = array();

        array_push($reviews,$review);

        if(isset($review_post))
            update_field('reviews', $reviews, $course_id);
        elseif(isset($review_expert))
            update_field('user_reviews', $reviews, 'user_' . $expert_id);

        if($post_type == 'community')
            $message = "/dashboard/user/communities/?mu=" . $course_id . "&message=Question saved successfully !";
        elseif(isset($review_expert))
            $message = '/user-overview/?id=' . $expert_id . '&message=Your review added successfully !'; 
        else 
            $message = get_permalink($course_id) . '/?message=Your review added successfully'; 
    }
    else
        if($post_type == 'community')
            $message = "/dashboard/user/communities/?mu=" . $course_id . "&message=Question saved successfully !";
        elseif(isset($review_expert))
            $message = '/user-overview/?id=' . $expert_id . '&message=Your review added successfully !'; 
        else 
            $message = get_permalink($course_id) . '/?message=User not find ...';        

    header("Location: ". $message);
}

else if(isset($change_password)){
    $user = wp_get_current_user();

    if(!user_pass_ok($user->email, $old_password )) 
        $message = "/dashboard/user/settings/?message_password=The password entered does not match your password";  
    else if($password != $password_confirmation)
        $message = "/dashboard/user/settings/?message_password=The two passwords are not identical";
    else 
        if(reset_password($user, $password ))
            $message = "/dashboard/user/settings/?message_password=Password updated successfully"; 
        else
            $message = "/dashboard/user/settings/?message_password=Something is wrong !"; 

    header("Location: ". $message);
}

else if(isset($referee_employee)){    
    $allocution = get_field('allocation', $course_id);
    if(!$allocution)
        $allocution = array();

    $user_id = get_current_user_id();

    $posts = get_post($course_id);
    //Get categories
    $posttags = get_the_tags();
    if(!$posttags){
        $category_default = get_field('categories', $course_id);
        $category_xml = get_field('category_xml', $course_id);
    }
    $read_category = array();
    $onderwerp_feedback = "";
    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if(!in_array($item['value'],$read_category)){
                    array_push($read_category,$item['value']);
                    $onderwerp_feedback .= $item['value'] . ';';
                }
                
    else if(!empty($category_xml))
        foreach($category_xml as $item)
            if($item)
                if(!in_array($item['value'],$read_category)){
                    array_push($read_category,$item['value']);
                    $onderwerp_feedback .= $item['value'] . ';';
                }
    //Create feedback
    $manager = get_user_by('id', get_current_user_id());
    $title_feedback = $manager->display_name . ' share you a course.';
    $type = 'Gedeelde cursus';

    $beschrijving_feedback = '<p>' . $manager->display_name . ' heeft de cursus met u gedeeld : <br>
    <a href="' . get_permalink($course_id) . '">' . $posts->post_title . '</a><br><br>
    Veel plezier bij het lezen !';

    if(!empty($selected_members))
        foreach($selected_members as $expert){
            if(!empty($allocution))
                if(in_array($expert, $allocution))
                    continue;

            /*
            ** Mail expert concerned by the sharing
            */

            $course_type = get_field('course_type', $posts->ID);
            //image post
            $thumbnail = get_field('preview', $posts->ID)['url'];
            if(!$thumbnail){
                $thumbnail = get_the_post_thumbnail_url($posts->ID);
                if(!$thumbnail)
                    $thumbnail = get_field('url_image_xml', $posts->ID);
                if(!$thumbnail)
                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
            }
            //short_description post
            $short_description = get_field('short_description', $posts->ID);

            $expert_shared = get_user_by('id', $expert);
            $first_name = $expert_shared->first_name ?: $expert_shared->display_name;
            $email = $expert_shared->user_email;
            $share_a_course = 'mail-share-a-course.php';
            require($share_a_course); 
            
            $subject = 'Iemand heeft een cursus met je gedeeld !';
            $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
            wp_mail($email, $subject, $mail_shared_course_body, $headers, array( '' )) ;

            array_push($allocution, $expert);
            $posts = get_field('kennis_video', 'user_' . $expert);
        
            //Data to create the feedback
            $post_data = array(
                'post_title' => $title_feedback,
                'post_author' => $expert,
                'post_type' => 'feedback',
                'post_status' => 'publish'
            );
            
            //Create
            $post_id = wp_insert_post($post_data);

            //Add further informations for feedback
            update_field('onderwerp_feedback', $onderwerp_feedback, $post_id);
            update_field('manager_feedback', $manager->ID, $post_id);
            update_field('type_feedback', $type, $post_id);
            update_field('beschrijving_feedback', nl2br($beschrijving_feedback), $post_id);

            if(!empty($posts))
                array_push($posts, get_post($course_id));

            update_field('kennis_video', $posts, 'user_' . $expert);
        }

    //Adding new subtopics on course
    update_field('allocation', $allocution, $course_id);

    if($path == "dashboard")
        $message = '/dashboard/company/learning-modules/?message=Allocution successfully'; 
    else if($path == "course")
        $message = get_permalink($course_id) . '/?message=Allocution successfully'; 

    header("Location: ". $message);
}

else if(isset($databank)){
    $onderwerpen = "";
    $message = "";

    if(!empty($tags))
        foreach($tags as $tag)
            $onderwerpen .= $tag .',';

    //GET COURSE ID 
    $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $id);
    $course = $wpdb->get_results( $sql )[0];
    
    //Date
    if($complete == 'all'){
        $number_items = count($start_date);
        $data_locaties = array();
        $row = "";
        
        for($i = 0; $i <= $number_items; $i++){
            if(!$start_date[$i])
                continue;

            $row = "";
            $row_start_date = date("d/m/Y H:i:s", strtotime($start_date[$i]));
            $row .= $row_start_date .'-'. $row_start_date .'-'. $location[$i] .'-'. $adress[$i] .';'; 

            $middles = explode(',', $between_date[$i]);
            foreach($middles as $middle){
                $middle = str_replace('/', '.', $middle);
                $row_middle = date("d/m/Y H:i:s", strtotime($middle));
                $row .= $row_middle .'-'. $row_middle .'-'. $location[$i] .'-'. $adress[$i] .';';
            }

            $row_end_date = date("d/m/Y H:i:s", strtotime($end_date[$i]));
            $row .= $row_end_date .'-'. $row_end_date .'-'. $location[$i] .'-'. $adress[$i];
        
            array_push($data_locaties, $row);
        }

        $data_locaties_xml = join('~', $data_locaties);
    }
    $contributors = "";
    if(!empty($experts))
        $contributors = join(',', $experts);
    
    if($complete == "all") 
        $data = [ 'titel' => $titel, 'type' => $type, 'short_description' => $short_description, 'long_description' => $long_description, 'for_who' => $for_who, 'agenda' => $agenda, 'results' => $results, 'prijs' => $prijs, 'prijs_vat' => $prijs_vat, 'onderwerpen' => $onderwerpen, 'date_multiple' => $data_locaties_xml, 'level' => $level, 'language' => $language, 'author_id' => $author_id, 'company_id' => $company_id, 'contributors' => $contributors ]; // NULL value.
    else if($complete == "quick")
        $data = [ 'titel' => $titel, 'type' => $type, 'short_description' => $short_description, 'prijs' => $prijs, 'onderwerpen' => $onderwerpen, 'author_id' => $author_id, 'company_id' => $company_id , 'contributors' => $contributors ]; // NULL value.
    else if($complete == "expert"){

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
            'role' => 'author'
        );

        $user_id = wp_insert_user(wp_slash($userdata));

        if(is_wp_error($user_id)){
            $danger = $user_id->get_error_message();
            header("Location: ". $danger);
        }
        else{ 
            $became_a_expert = 'mail-became-a-expert.php';
            require($became_a_expert); 

            //Mail - sign up
            $subject = 'Je LiveLearn inschrijving is binnen! ✨';
            $body = "
            Bedankt voor je inschrijving<br>
            <h1>Hello " . $first_name  . "</h1>,<br> 
            Je hebt je succesvol geregistreerd. Welcome onboard! Je LOGIN-ID is <b style='color:blue'>" . $login . "</b>  en je wachtwoord <b>".$password."</b><br>
            U hebt een cursus toegewezen gekregen en zult die zien zodra de beheerders ze hebben aanvaard.<br>
            Log in om toegang te krijgen.<br><br>
            <h4>Inloggen:</h4><br>
            <h6><a href='https://livelearn.nl/inloggen/'> Connexion </a></h6>
            ";
            $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
            wp_mail($email, $subject, $body, $headers, array( '' )) ; 

            //Mail - became a expert
            $subject = 'Je hebt de rol expert !';
            wp_mail($email, $subject, $mail_became_expert_body, $headers, array( '' )) ; 
        }

        $data = [ 'author_id' => $user_id ]; // NULL value.
    }
    else if($complete  == "company"){
        $args = array(
            'post_type'   => 'company',
            'post_author' => 3,
            'post_status' => 'publish',
            'post_title'  => $company_title
        );
        
        $id_company = wp_insert_post($args);
        $companie = get_post($id_company);
        update_field('company_address', $company_adress, $id_company);
        update_field('company_place', $company_place, $id_company);
        update_field('company_country', $company_country, $id_company);

        update_field('company', $companie, 'user_'. $course->author_id);

        /*
        Send email to user affected to these new company
        */

        $data = [ 'company_id' => $id_company ]; // NULL value.
    }

    $where = [ 'id' => $id ]; // NULL value in WHERE clause.

    $updated = $wpdb->update( $table, $data, $where );
 
    if($updated === false)
        if($complete == "all") 
            $message = "/edit-databank?id=" . $id . "&message=" . $wpdb->last_error;
        else
            $message = "/databank/?message=" . $wpdb->last_error;
    else 
        if($complete == "all") 
            $message = "/edit-databank?id=" . $id . "&message=Updated successfully !"; 
        else
            $message = "/databank/?message=Updated successfully !"; 

    header("Location: ". $message);
}

else if(isset($date_add)){

    $number_items = count($start_date);
    $data_locaties = array();
    $row = "";

    for($i = 0; $i < $number_items; $i++){
        if(!$start_date[$i])
            continue;

        $row = "";
        $row_start_date = date("d/m/Y H:i:s", strtotime($start_date[$i]));
        $row .= $row_start_date .'-'. $row_start_date .'-'. $location[$i] .'-'. $adress[$i] .';'; 

        $middles = explode(',', $between_date[$i]);
        foreach($middles as $middle){
            $middle = str_replace('/', '.', $middle);
            $row_middle = date("d/m/Y H:i:s", strtotime($middle));
            $row .= $row_middle .'-'. $row_middle .'-'. $location[$i] .'-'. $adress[$i] .';';
        }

        $row_end_date = date("d/m/Y H:i:s", strtotime($end_date[$i]));
        $row .= $row_end_date .'-'. $row_end_date .'-'. $location[$i] .'-'. $adress[$i];
      
        array_push($data_locaties, $row);
    }

    update_field('data_locaties_xml', $data_locaties, $id);

    $path = '/dashboard/teacher/course-selection/?func=add-course&id=' .$id. '&step=4';

    header('Location: ' .$path);
}

else if(isset($define_budget)){
    update_field('leerbudget', $leerbudget, $company_id);
    update_field('zelfstand_max', $zelfstand_max, $company_id);

    $message = '/dashboard/company/leerbudgetten/?message=Budget updated sucessfully'; 

    header("Location: ". $message);
}

else if(isset($note_skill_edit)){
    $user_id = get_current_user_id();
    $skills = get_field('skills', 'user_' . $user_id);
    $skill = array();
    $skill['id'] = $id;
    $skill['note'] = $note;
    $bool = false;
    $bunch = array();

    if(empty($skills))
        $skills = array();
    else
        foreach($skills as $item){
            if($item['id'] == $id){
                $item['note'] = $note;
                $bool = true;
            }
            array_push($bunch, $item);
        }

    if(!$bool)
        array_push($skills, $skill);
    else
        $skills = $bunch;

    update_field('skills', $skills, 'user_' . $user_id);
    $message = '/dashboard/user/settings/?message=Note updated sucessfully'; 

    header("Location: ". $message);
}

else if (isset($note_skill_new)){
    $user_id = get_current_user_id();

    //Get Topics 
    $topics_external = get_user_meta($user_id, 'topic');
    $topics_internal = get_user_meta($user_id, 'topic_affiliate');
    $topics = array();
    if(!empty($topics_external))
        $topics = $topics_external;
    if(!empty($topics_internal))
        foreach($topics_internal as $value){
            if(!$value || is_wp_error(!$value))
                continue;
            array_push($topics, $value);
        }

    //Add topic
    if(!in_array($id, $topics))
        add_user_meta($user_id,'topic',$id);
    
    //Add note
    $skills = get_field('skills', 'user_' . $user_id);
    $skill = array();
    $skill['id'] = $id;
    $skill['note'] = $note;
    $bool = false;
    $bunch = array();

    if(empty($skills))
        $skills = array();
    else
        foreach($skills as $item){
            if($item['id'] == $id){
                $item['note'] = $note;
                $bool = true;
            }
            array_push($bunch, $item);
        }

    if(!$bool)
        array_push($skills, $skill);
    else
        $skills = $bunch;

    update_field('skills', $skills, 'user_' . $user_id);
    $message = '/dashboard/user/settings/?message=Note updated sucessfully'; 
    
    header("Location: ". $message);
}

else if(isset($departement_add)){
    $user_id = get_current_user_id();
    $company = get_field('company',  'user_' . $user_id);
    $departments = get_field('departments', $company[0]->ID);

    $department = array();
    $department['name'] = $name_department;

    if(!$departments)
        $departments = array();

    array_push($departments, $department);

    update_field('departments', $departments, $company[0]->ID);
    $message = '/dashboard/company/afdelingen/?message=Department added successfully !'; 
    header("Location: ". $message);
}

else if(isset($departement_delete)){
    $user_id = get_current_user_id();
    $company = get_field('company',  'user_' . $user_id);
    $departments = get_field('departments', $company[0]->ID);
    $bunch = array();
    foreach($departments as $key => $value)
        if($key == $id)
            continue;
        else
            array_push($bunch,$value);
    
    update_field('departments', $bunch, $company[0]->ID);
    $message = '/dashboard/company/afdelingen/?message=Department deleted successfully !'; 
    header("Location: ". $message);
}

else if(isset($details_user_departement)){
    update_field('role', $role_user, 'user_'.$id_user);
    update_field('department', $department, 'user_'.$id_user);
    $message = '/dashboard/company/afdelingen/?message=Informations updated successfully !'; 
    header("Location: ". $message);
}

else if(isset($follow_community)){
    //Private community
    if(isset($password)){
        $password_community = get_field('password_community', $community_id);
        if($password != $password_community){
            $path = "/dashboard/user/communities/?message=This community is private, please check the correct password !";
            header("Location: ". $path);
            return 0;
        }
    }

    //Intern community
    $user_id = get_current_user_id();
    $company = get_field('company_author', $community_id);
    $company_user = get_field('company',  'user_' . $user_id);
    $company_title_user = (!empty($company_user)) ? $company_user[0]->post_title : '';
    $visibility_community = get_field('visibility_community', $community_id); 
    if($visibility_community){
        if($company->post_title != $company_title_user){
            $path = "/dashboard/user/communities/?message=This community is intern !";
            header("Location: ". $path);
            return 0;  
        }  
    }
    
    $user = wp_get_current_user();
    $followers = get_field('follower_community', $community_id);
    if(!$followers)
        $followers = array();
    array_push($followers, $user);

    update_field('follower_community', $followers, $community_id);

    //Badges
    community_badges();

    $path = "/dashboard/user/community-detail/?mu=" . $community_id . "&message=Successfully subscribed to this community !";
    header("Location: ". $path);
}

else if(isset($unfollow_community)){
    $user_id = get_current_user_id();
    $followers = array();
    $past_followers = get_field('follower_community', $community_id);

    if(empty($past_followers))
        $past_followers = array();
    else
        foreach($past_followers as $follower){
            if($follower->ID == $user_id)
                continue;
            
            array_push($followers, $follower);
        }
    
    update_field('follower_community', $followers, $community_id);

    $path = "/dashboard/user/communities/?message=Successfully unsubscribed !";
    header("Location: ". $path);
}

else if(isset($interest_multiple_push)){
    foreach($data as $meta_value)        
        if($meta_value){
            if($meta_key == 'topic'){
                $meta_data_extern = get_user_meta($user_id, $meta_key);
                $meta_data_intern = get_user_meta($user_id, 'topic_affiliate');
                if(!in_array($meta_value, $meta_data_extern) && !in_array($meta_value, $meta_data_intern) )
                    add_user_meta($user_id, $meta_key, $meta_value);
                else
                    if(in_array($meta_value, $meta_data_extern))
                        delete_user_meta($user_id, $meta_key, $meta_value);
                    else
                        delete_user_meta($user_id, "topic_affiliate", $meta_value);
            }
            else{
                $meta_data = get_user_meta($user_id, $meta_key);
                if(!in_array($meta_value, $meta_data)){
                    if($meta_key == 'expert'){
                        $user_expert = get_user_by('id', $user_id);
                        $first_name = $user_expert->first_name ?: $user_expert->display_name;
                        $email = $user_expert->user_email;
                        $mail_page = 'mail-new-follower.php';
                        require($mail_page); 
                        
                        $subject = 'Je hebt een nieuwe volger !';
                        $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                        wp_mail($email, $subject, $mail_new_followed_body, $headers, array( '' )) ;
                    }
                    add_user_meta($user_id, $meta_key, $meta_value);
                }else
                    delete_user_meta($user_id, $meta_key, $meta_value);  
            }                  
        }
        
    $message = "News interests applied !";
    header("location: ../../dashboard/user/?message=" . $message);
}

else if(isset($question_community)){
    $question = array();

    //New question
    $user_question = wp_get_current_user();
    $question_community = get_field('question_community', $community_id);
    $question['user_question'] = $user_question;
    $question['text_question'] = $text_question;

    if(!$question_community)
        $question_community = array();

    array_push($question_community, $question);
    
    update_field('question_community', $question_community, $community_id);

    $path = "/dashboard/user/community-detail/?mu=" . $community_id . "&message=Question saved successfully !";
    header("Location: ". $path);
}

else if(isset($reply_question_community)){
    $question = array();
    $question_community = get_field('question_community', $community_id);
    if(!empty($question_community))
        $question_community = array_reverse($question_community);
    
    foreach($question_community as $key => $item){
        if($key == $id){
            $reply = array();
            $user_reply = wp_get_current_user();
            $reply['user_reply'] = $user_reply;
            $reply['text_reply'] = $_POST['txtreply'];
            if(empty($item['reply_question']))
                $item['reply_question'] = array();
            
            array_push($item['reply_question'], $reply);
        }

        array_push($question, $item);
    }
    $question = array_reverse($question);
    update_field('question_community', $question, $community_id);
    $path = "/dashboard/user/community-detail/?mu=" . $community_id . "&message=Reply question applied successfully !";
    header("Location: ". $path);
}

else if(isset($mandatory_course)){    
    $posts = get_post($course_must);
    $link = get_permalink($course_must);

    /** Create feedback **/
    $manager = get_user_by('id', get_current_user_id());
    $type = 'Verplichte cursus';
    $beschrijving_feedback = '<p>' . $manager->display_name . ' heeft de cursus met u gedeeld : <br>
    <a href="/dashboard/user/activity">' . $posts->post_title . '</a><br><br>
    Veel plezier bij het lezen !';
    //Data to create the feedback
    $post_data = array(
        'post_title' => $name_mandatory,
        'post_author' => $user_must,
        'post_type' => 'feedback',
        'post_status' => 'publish'
    );
    //Create
    $post_id = wp_insert_post($post_data);
    //Add further informations for feedback
    update_field('type_feedback', $type, $post_id);
    update_field('manager_feedback', $manager->ID, $post_id);
    update_field('beschrijving_feedback', nl2br($beschrijving_feedback), $post_id);

    /** Create mandatory **/
    $post_data = array(
        'post_title' => $posts->post_name,
        'post_author' => $user_must,
        'post_type' => 'mandatory',
        'post_status' => 'publish'
    );
    //Create
    $post_id = wp_insert_post($post_data);
    //Add further informations for mandator
    update_field('done_must', $done_must, $post_id);
    update_field('valid_must', $valid_must, $post_id);
    update_field('point_must', $point_must, $post_id);
    update_field('message_must', nl2br($message_must), $post_id);
    update_field('manager_must', $manager, $post_id);

    /** Mail expert concerned by the sharing **/
    $course_type = get_field('course_type', $posts->ID);
    //image post
    $thumbnail = get_field('preview', $posts->ID)['url'];
    if(!$thumbnail){
        $thumbnail = get_the_post_thumbnail_url($posts->ID);
        if(!$thumbnail)
            $thumbnail = get_field('url_image_xml', $posts->ID);
        if(!$thumbnail)
            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
    }
    //short_description post
    $short_description = get_field('short_description', $posts->ID);
    $expert_shared = get_user_by('id', $user_must);
    $first_name = $expert_shared->first_name ?: $expert_shared->display_name;
    $email = $expert_shared->user_email;
    $mandatory_a_course = 'mail-mandatory-a-course.php';
    require($mandatory_a_course);
    $subject = 'Een van je managers heeft een verplichte cursus met je gedeeld!';
    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
    wp_mail($email, $subject, $mail_mandatored_course_body, $headers, array( '' )) ;

    $message = "/dashboard/company/profile/?id=" . $user_must . "&manager=" . $manager->ID . "&message=Successfully put on mandatory !"; 

    header("Location: ". $message);
}

else if(isset($valid_offline)){
    $user = wp_get_current_user();

    //Get read by user 
    //Get posts searching by title
    $args = array(
        'post_type' => 'progression', 
        'title' => $course_read,
        'post_status' => 'publish',
        'author' => $user->ID,
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    );
    $progressions = get_posts($args);

    if(empty($progressions)){
        //Create progression
        $post_data = array(
            'post_title' => $course_read,
            'post_author' => $user->ID,
            'post_type' => 'progression',
            'post_status' => 'publish'
        );
        $progression_id = wp_insert_post($post_data);
    }
    else
        $progression_id = $progressions[0]->ID;
        
    $post = 0;
    $post = get_page_by_path($course_read, OBJECT, 'course');

    //Finish 
    update_field('state_actual', 1, $progression_id);
    //Get read by user 
    $args = array(
        'post_type' => 'mandatory', 
        'title' => $post->post_name,
        'post_status' => 'publish',
        'author' => $user->ID,
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
    $mandatories = get_posts($args);
    $is_finish = 0;
    if(!empty($mandatories)){
        $manager_must = get_field('manager_must', $mandatories[0]->ID);
        $first_name = (isset($manager_must->first_name)) ? $manager_must->first_name : $manager_must->display_name;
        $employee_name = (isset($user->first_name)) ? $user->first_name : $user->display_name;
        $email = $manager_must->user_email;

        /** Mail to manager */
        $course_type = get_field('course_type', $post->ID);
        //image post
        $thumbnail = get_field('preview', $post->ID)['url'];
        if(!$thumbnail){
            $thumbnail = get_the_post_thumbnail_url($post->ID);
            if(!$thumbnail)
                $thumbnail = get_field('url_image_xml', $post->ID);
            if(!$thumbnail)
                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
        }
        //short_description post
        $short_description = get_field('short_description', $post->ID);
        $mandatory_a_course = 'mail-mandatory-valid-course.php';
        require($mandatory_a_course);
        $subject = 'Mandatory course followed successfully by your employee !';
        $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
        wp_mail($email, $subject, $mail_mandatory_validated_course_body, $headers, array( '' )) ;
    }

    if($post)
        $follow_reads = "/dashboard/user/checkout-offline?post=" . $post->post_name;
    else
        $follow_reads = "/dashboard/user/activity";

    header("Location: " . $follow_reads);
}

else if(isset($read_action_lesson)){
    $user = wp_get_current_user();

    //Get read by user 
    //Get posts searching by title
    $args = array(
        'post_type' => 'progression', 
        'title' => $course_read,
        'post_status' => 'publish',
        'author' => $user->ID,
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    );
    $progressions = get_posts($args);

    if(empty($progressions)){
        //Create progression
        $post_data = array(
            'post_title' => $course_read,
            'post_author' => $user->ID,
            'post_type' => 'progression',
            'post_status' => 'publish'
        );
        $progression_id = wp_insert_post($post_data);
    }
    else
        $progression_id = $progressions[0]->ID;
    
    //Lesson read
    $lesson_reads = get_field('lesson_actual_read', $progression_id);
    $lesson_read = array();
    $lesson_read['key_lesson'] = $lesson_key;

    $bool = true;

    if(!empty($lesson_reads))
        foreach ($lesson_reads as $key => $item) 
            if($item['key_lesson'] == $lesson_key){
                $bool = false;
                break;
            }

    if(!$lesson_reads)
        $lesson_reads = array();
        
    if($bool){
        array_push($lesson_reads, $lesson_read);
        update_field('lesson_actual_read', $lesson_reads, $progression_id);
    }

    $next_lesson = false;
    $post = 0;
    if($course_read){
        $post = get_page_by_path($course_read, OBJECT, 'course');
        //Content count
        $courses = get_field('data_virtual', $post->ID);
        $youtube_videos = get_field('youtube_videos', $post->ID);
        $podcasts = get_field('podcasts', $post->ID);
        $count_item = 0;
        if(!empty($courses)){
            $content = $courses;
            $count_item = count($courses);
        }else if(!empty($youtube_videos)){
            $content = $youtube_videos;
            $count_item = count($youtube_videos);
        }
        else if(!empty($podcasts)){
            $content = $podcasts;
            $count_item = count($podcasts);
        }

        //lesson reads count
        $lesson_reads = get_field('lesson_actual_read', $progression_id);
        $count_lesson_reads = ($lesson_reads) ? count($lesson_reads) : 0;

        if($count_lesson_reads == $count_item){
            update_field('state_actual', 1 , $progression_id);
            //Get read by user 
            $args = array(
                'post_type' => 'mandatory', 
                'title' => $post->post_name,
                'post_status' => 'publish',
                'author' => $user->ID,
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );
            $mandatories = get_posts($args);
            $is_finish = 0;
            if(!empty($mandatories)){
                $manager_must = get_field('manager_must', $mandatories[0]->ID);
                $first_name = (isset($manager_must->first_name)) ? $manager_must->first_name : $manager_must->display_name;
                $employee_name = (isset($user->first_name)) ? $user->first_name : $user->display_name;
                $email = $manager_must->user_email;

                /** Mail to manager */
                $course_type = get_field('course_type', $post->ID);
                //image post
                $thumbnail = get_field('preview', $post->ID)['url'];
                if(!$thumbnail){
                    $thumbnail = get_the_post_thumbnail_url($post->ID);
                    if(!$thumbnail)
                        $thumbnail = get_field('url_image_xml', $post->ID);
                    if(!$thumbnail)
                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                }
                //short_description post
                $short_description = get_field('short_description', $post->ID);
                $mandatory_a_course = 'mail-mandatory-valid-course.php';
                require($mandatory_a_course);
                $subject = 'Mandatory course followed successfully by your employee !';
                $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );  
                wp_mail($email, $subject, $mail_mandatory_validated_course_body, $headers, array( '' )) ;
            }
        }

    }

    //if exists return next lesson
    //else return checkout video or end chapter
    if($post)
        if(isset($content[$lesson_key + 1])){
            $key = $lesson_key + 1;
            if(isset($podcast_read))
                $follow_reads = "/dashboard/user/start-podcast?post=" . $post->post_name . "&lesson=" . $key;
            else
                $follow_reads = "/dashboard/user/start-course?post=" . $post->post_name . "&lesson=" . $key;
        }
        else
            if(isset($podcast_read))
                $follow_reads = "/dashboard/user/checkout-podcast?post=" . $post->post_name;
            else
                $follow_reads = "/dashboard/user/checkout-video?post=" . $post->post_name;
    else
        $follow_reads = "/dashboard/user/activity";

    header("Location: " . $follow_reads);
}

else if(isset($reaction_post)){
    $reactions = array();
    $bunch_reactions = get_field('reaction', $id); 
    $current_user = wp_get_current_user();
    $my_review_bool = false;
    foreach ($bunch_reactions as $reaction):
        if($reaction['user_reaction']->ID == $current_user->id){
            if($reaction['type_reaction'] == $reaction_post)
                $my_review_bool = true;
            continue;
        }

        array_push($reactions, $reaction);
    endforeach;
   
    $reaction = array();
    $reaction['user_reaction'] = $current_user;
    $reaction['type_reaction'] = $reaction_post;
    if($reaction['user_reaction']){
        if(!$my_review_bool) 
            array_push($reactions, $reaction);
        update_field('reaction', $reactions, $id);
    }
    $path = get_permalink($id) . "/?message=Reaction successfully saved !";
    header("Location: " . $path);
}

?>
<?php wp_head(); ?>

<?php get_header();?>

<?php

global $post;

$parents = get_post_ancestors( $post->ID );

$dashboard = !empty($parents[1]) ? get_post_field( 'post_name', $parents[0] ) : $post->post_name;

$dashboard_page = $dashboard != $post->post_name ? $post->post_name : 'home';
$dashboard_func = isset($_GET['func']) ? '-'.$_GET['func'] : '';
$dashboard_func_page = isset($_GET['step']) ? '-'.$_GET['step'] : '';


$args = array(
    'post_type' => 'course', 
    'post_status' => 'publish',
    'posts_per_page' => '50',
);

$courses = get_posts($args);

$categories = array();

$cats = get_categories( array(
    'taxonomy'   => 'category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
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

?>


<?php
if($dashboard == 'company' && $dashboard_page == 'profile'){
    include_once(get_stylesheet_directory().'/template-parts/modules/dashboard-'.$dashboard.'-'.$dashboard_page.$dashboard_func.$dashboard_func_page.'.php');
}
else{
?>

<div class="theme-content" >
    <div class="theme-side-menu">
        <?php include_once(get_stylesheet_directory().'/template-parts/modules/dashboard-menu-'.$dashboard.'.php');?>
    </div>
    <div class="theme-learning">
        <?php include_once(get_stylesheet_directory().'/template-parts/modules/dashboard-'.$dashboard.'-'.$dashboard_page.$dashboard_func.$dashboard_func_page.'.php');?>
    </div>
</div>
<?php
    }
?>

<?php get_footer();?>
<?php wp_footer(); ?>

