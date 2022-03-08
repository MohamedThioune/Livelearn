<?php 
    /** Template Name: Trash Course */ 
    $post = get_post($_GET['id']);
    if($post){
        return wp_trash_post($post->ID);

        /* $path = $_GET['path'] . '&message=Succesvolle verwijdering'; */
    }

        /* header('Location:' . $path); */
?>