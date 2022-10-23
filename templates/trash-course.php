<?php 
    /** Template Name: Trash Course */ 

    if(isset($_POST['road_path'])){
        $user_id = get_current_user_id();
        $road_path_final = array();
        $road_paths = get_field('road_path', 'user_'. $user_id);
        if($_POST['road_path']){
            foreach($road_paths as $course){
                if($course->ID != $_POST['road_path'])
                    array_push($road_path_final, $course);
            }
        }
        return update_field('road_path', $road_path_final, 'user_'. $user_id);
    }
    else{
        $post = get_post($_GET['id']);
        if($post)
            return wp_trash_post($post->ID);
    }
?>