<?php /** Template Name: dashboard core */ ?>
<?php

if(is_user_logged_in()){
    acf_form_head();
} 

$user = get_current_user_id();
$message = ""; 

extract($_POST);

$user_data = wp_get_current_user();

if(empty($user_data->roles))
    header('Location:/');

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
    $title_feedback = $_POST['title_feedback'];
    $type = $_POST['type'];
    $manager = get_user_by('id',$_POST['manager']);

    $onderwerp_feedback='';
    if (isset ($_POST['onderwerp_feedback']) &&  !empty($_POST['onderwerp_feedback']))
        foreach ($_POST['onderwerp_feedback']as  $value) {
            $onderwerp_feedback.=$value.';';        
        }
    $beschrijving_feedback = $_POST['beschrijving_feedback'];

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

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

// Beoordelingsgesprek saving
else if(isset($_POST['add_todo_beoordelingsgesprek'])){
    $id_user = $_POST['id_user'];
    $title_beoordelingsgesprek = $_POST['title_beoordelingsgesprek'];
    $type = $_POST['type'];
    $manager = get_user_by('id',$_POST['manager']);

    $algemene_beoordeling = $_POST['algemene_beoordeling'];
    $rates_comments='';
    $topic_affiliate = get_user_meta($id_user,'topic_affiliate');
    if (isset ($topic_affiliate) &&  !empty($topic_affiliate))
    {
        foreach ($topic_affiliate as $value) {
            $rate_topic=$_POST[lcfirst((String)get_the_category_by_ID($value)).'_rate'];
            $comment_topic=$_POST[lcfirst((String)get_the_category_by_ID($value)).'_toelichting'];
            $rates_comments=$rates_comments.$value.';'.$rate_topic.';'.$comment_topic.';';
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

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

//Persoonlijk ontwikkelplan saving
else if(isset($_POST['add_todo_persoonlijk']))
{
    $id_user = $_POST['id_user'];
    $title_feedback = $_POST['title_persoonlijk'];
    $type = $_POST['type'];
    $manager = get_user_by('id',$_POST['manager']);

    $onderwerp_feedback = '';
    if (isset ($_POST['onderwerp_pop']) &&  !empty($_POST['onderwerp_pop']))
        foreach ($_POST['onderwerp_pop'] as $value) {
            $onderwerp_feedback.=$value.';';        
        }
    $wat_bereiken = $_POST['wat_bereiken'];  
    $hoe_bereiken = $_POST['hoe_bereiken'];
    $hulp_text = $_POST['hulp_text'];
    $opmerkingen = $_POST['opmerkingen'];

    if (isset($_POST['hulp_radio_JA']) && !empty ($_POST['hulp_radio_JA']))
        $hulp_radio=$_POST['hulp_radio_JA'];
            
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
    update_field('opmerkingen', $opmerkingen, $post_id);

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
            add_user_meta($user_id, $meta_key, $meta_value);
            $message = "Succesvol toegevoegd";
        }else{
            $message = "Reeds aanwezig in jouw favorieten";
        }
        header("location:../../dashboard/user/?message=".$message);
        
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
            $message = "Met succes verwijderd";
            if($meta_key == "topic" || $meta_key == "topic_affiliate")
                header("location:/dashboard/user/?message=".$message);
            else{
                $user_connected = get_current_user_id();
                $content = "/dashboard/company/profile/?id=" . $user_id . '&manager='. $user_connected . "?message=" . $message; 
                header("location:".$content);
            }
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

    foreach($topics as $topic)
        if($topic != '')
            update_field('topic_road_path', $topic, $post_id);

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

else if(isset($review_post)){
    $reviews = get_field('reviews', $course_id);
    $review = array();
    $review['user'] = get_user_by('ID',$user_id);
    //$review['rating'] = $rating;
    $review['feedback'] = $feedback_content;
    if($review['user']){
        if(!$reviews)
            $reviews = array();

        array_push($reviews,$review);

        update_field('reviews',$reviews, $course_id);
        $message = get_permalink($course_id) . '/?message=Your review added successfully'; 
    }
    else 
        $message = get_permalink($course_id) . '/?message=User not find...';
    //var_dump($review['rate']);
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
    $allocution = array();
    
    if(!empty($selected_members))
        foreach($selected_members as $expert){
            if(!in_array($expert, $allocution)){
                array_push($allocution, $expert);
                $posts = get_field('kennis_video', 'user_' . $expert);
                if(!empty($posts))
                    array_push($posts, get_post($course_id));
                else 
                    $posts = get_post($course_id);
                update_field('kennis_video', $posts, 'user_' . $expert);
            }
        }

    //Adding new subtopics on course
    update_field('allocation', $allocution, $course_id);

    if($path="dashboard")
        $message = '/dashboard/company/learning-modules/?message=Allocution successfully'; 
    else if($path="course")
        $message = get_permalink($course_id) . '/?message=Allocution successfully'; 

    header("Location: ". $message);

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

<div class="theme-content">
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

