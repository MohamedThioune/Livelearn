<?php 
    /** Template Name: Trash User */ 
    $user = get_user_by('ID', $_POST['id']);

    if($user){
        $user->remove_role('author');
        $user->remove_role('manager');

        $user->add_role('subscriber');
        return update_field('company', null, 'user_'. $user->ID);
    }