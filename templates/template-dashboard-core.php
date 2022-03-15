<?php /** Template Name: dashboard core */ ?>
<?php
if(is_user_logged_in()){
    acf_form_head();
} 

$user = get_current_user_id();
$message = ""; 

extract($_POST); 

 // delete_user_meta(33,'topic_affiliate'); // Delete topics affiliate by manager
 //   delete_user_meta(33,'todos'); //   Delete todos affiliate by manager
if(isset($_POST['expert_add'])){
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

    $path = "/dashboard/teacher/course-overview/?message=Cursus succesvol bijgewerkt ✔️";
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
// Feedback saving
else if(isset($_POST['add_todo_feedback'])){
    $id_user = $_POST['id_user'];
    $title_feedback = $_POST['title_feedback'];
    $type = $_POST['type'];
    $onderwerp_feedback='';
    if (isset ($_POST['onderwerp_feedback']) &&  !empty($_POST['onderwerp_feedback']))
        foreach ($_POST['onderwerp_feedback']as  $value) {
            $onderwerp_feedback.=$value.';';        
        }
    $beschrijving_feedback = $_POST['beschrijving_feedback'];
    $bunch = array();
    $fields = " ";
    $state = 0;
    $bunch = get_field('todos',  'user_' . $id_user);
    $fields = $title_feedback . ';' . $beschrijving_feedback . ';' .get_current_user_id() . ';'. $type .';'. $onderwerp_feedback .';'. $state;
    array_push($bunch, $fields);  
    if(!empty($bunch))
        update_field('todos', $bunch, 'user_'. $id_user);
    else
        update_field('todos', $fields, 'user_'.$id_user);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

// Complimentsaving
else if(isset($_POST['add_todo_compliment'])){

    $id_user = $_POST['id_user'];
    $title_compliment = $_POST['title_compliment'];
    $type = $_POST['type'];
    $onderwerp_compliment = '';
    if (isset ($_POST['onderwerp_compliment']) &&  !empty($_POST['onderwerp_compliment']))
        foreach ($_POST['onderwerp_compliment'] as $value) {
            $onderwerp_compliment.=$value.';';        
        }
    $beschrijving_compliment = $_POST['beschrijving_compliment'];
    $bunch = array();
    $fields = " ";
    $state = 0;
    $bunch = get_field('todos',  'user_' . $id_user);
    $fields = $title_compliment . ';' . $beschrijving_compliment . ';'.get_current_user_id(). ';' . $type . ';' . $onderwerp_compliment . ';' . $state;
    array_push($bunch, $fields);  
    if(!empty($bunch))
        update_field('todos', $bunch, 'user_'. $id_user);
    else
        update_field('todos', $fields, 'user_'.$id_user);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

// Beoordelingsgesprek saving
else if(isset($_POST['add_todo_beoordelingsgesprek'])){
    $id_user = $_POST['id_user'];
    $title_beoordelingsgesprek = $_POST['title_beoordelingsgesprek'];
    $type = $_POST['type'];
    $algemene_beoordeling = $_POST['algemene_beoordeling'];
    $sales_toelichting = $_POST['sales_toelichting'];
    $sales_rate_2 = $_POST['sales_rate_2'];
    $sales_rate = $_POST['sales_rate'];
    $feedback_geven_rate = $_POST['feedback_geven_rate'];
    $topic_affiliate = get_user_meta($id_user,'topic_affiliate');
    $onderwerp_beoordelingsgesprek='';
    if (isset ($topic_affiliate) &&  !empty($topic_affiliate))
        foreach ($topic_affiliate as $value) {
            $onderwerp_beoordelingsgesprek.=$value.';';        
        }
    $bunch = array();
    $fields = " ";
    $state = 0;
    $bunch = get_field('todos',  'user_' . $id_user);
    $fields = $title_beoordelingsgesprek . ';' .$algemene_beoordeling . ';' .get_current_user_id() . ';'. $type .';'. $feedback_geven_rate . ';'. $sales_rate_2. ';'.$sales_toelichting. ';' .$sales_rate. ';' .$algemene_beoordeling. ';'.$onderwerp_beoordelingsgesprek. ';'.$state;
    array_push($bunch, $fields);  
    if(!empty($bunch))
        update_field('todos', $bunch, 'user_'. $id_user);
    else
        update_field('todos', $fields, 'user_'.$id_user);

    $message = "/dashboard/company/profile/?id=". $id_user. "&manager=" . get_current_user_id() . "&message=Uw actie is met succes beïnvloed"; 
    header("Location: ". $message);
}

//Persoonlijk ontwikkelplan saving
else if(isset($_POST['add_todo_persoonlijk'])){
    $id_user = $_POST['id_user'];
    $title_persoonlijk = $_POST['title_persoonlijk'];
    $onderwerp_pop = '';
    if (isset ($_POST['onderwerp_pop']) &&  !empty($_POST['onderwerp_pop']))
        foreach ($_POST['onderwerp_pop'] as $value) {
            $onderwerp_pop.=$value.';';        
        }
    $wat_bereiken = $_POST['wat_bereiken'];
    $hoe_bereiken = $_POST['hoe_bereiken'];
    $hulp_text = $_POST['hulp_text'];
    $opmerkingen = $_POST['opmerkingen'];
    if (isset($_POST['hulp_radio_JA']) && !empty ($_POST['hulp_radio_JA']))
        $hulp_radio=$_POST['hulp_radio_JA'];
    else
        if (isset($_POST['hulp_radio_NEE']) && !empty ($_POST['hulp_radio_NEE']))
            $hulp_radio=$_POST['hulp_radio_NEE'];
            
    $bunch = array();
    $fields = " ";
    $state = 0;
    $bunch = get_field('todos',  'user_' . $id_user);
    $fields = $title_persoonlijk . ';'. $opmerkingen .';' .get_current_user_id() .';'. $type. ';'.$onderwerp_pop . ';' . $wat_bereiken . ';'  . $hoe_bereiken . ';' . $hulp_text . ';' . $hulp_radio . ';'  . $state;
    array_push($bunch, $fields);  
    if(!empty($bunch))
        update_field('todos', $bunch, 'user_'. $id_user);
    else
        update_field('todos', $fields, 'user_'.$id_user);

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
* *
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
            if($meta_key == "topic")
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
    $todos = get_field('todos',  'user_' . $user_id);
    $bunch = array();
    foreach($todos as $key => $value){
        if($key == $id)
            continue;
        else
            array_push($bunch,$value);
    }
    update_field('todos', $bunch, 'user_'. $user->ID);

    $content = "/dashboard/company/profile/?id=" . $user_id . '&manager='. $user_connected . "?message=" . $message; 
    $todos = get_field('todos',  'user_' . $user_id);

    header("location:".$content);

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