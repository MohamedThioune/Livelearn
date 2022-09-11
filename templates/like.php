<?php /** Template Name: Like */ ?>

<?php
/*
* * favoured course
*/
$bunch  = array($_POST['user_id']);
$favorite = get_field('favorited', $_POST['id']);
if($_POST['user_id'] != 0 )
    if(!isset($_POST['meta_key'])){
        if(!empty($favorite)){
            if(in_array($_POST['user_id'], $favorite)){
                if (($key = array_search($_POST['user_id'], $favorite)) !== false) {
                    unset($favorite[$key]);
                }
            }else
                array_push($favorite, $_POST['user_id']);
            update_field('favorited', $favorite, $_POST['id']);
        }else
            update_field('favorited', $bunch, $_POST['id']);
    }
    else{
        $meta_data = get_user_meta($_POST['user_id'], $_POST['meta_key']);
        if(!in_array($_POST['id'],$meta_data)){
            add_user_meta($_POST['user_id'], $_POST['meta_key'], $_POST['id']);
            return true;
        }else
            if(($key = array_search($_POST['user_id'], $meta_data)) !== false)
                unset($meta_data[$key]);   
    }

$favorite = get_field('favorited', $_POST['id']);
echo count($favorite);





