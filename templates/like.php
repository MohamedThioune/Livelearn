<?php /** Template Name: Like */ ?>

<?php
/*
* * favoured course
*/
$bunch  = array($_POST['user_id']);
$favorite = get_field('favorited', $_POST['id']);
if($_POST['user_id'] != 0)
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

$favorited = get_field('favorited', $_POST['id']);

echo count($favorited);




