<?php 
    /** Template Name: Trash User */ 
    $user = get_user_by('ID', $_POST['id']);

    if($user)
        return update_field('company', null, 'user_'. $user->ID);