<?php /** Template Name: Fetch expert */ ?>

<?php
extract($_POST);
/**
 * Bunch of users 
 */

$users = get_users();

$output = "";

$row_opleiders = "";

$rx = 0;

if(strlen($_POST['search_expert']) >= 3){
    foreach($users as $user){
        $filter = $user->data->display_name . '' . $user->data->first_name . '' . $user->data->last_name ;
        if(stristr($filter, $_POST['search_expert'])){
            $row_opleiders .= "<option value='" . $user->ID ."'>" . $user->display_name . "</option>";
        }
    }


if($row_opleiders != ""){
    $output .= "<p class='theme-mastersearch-divider' style='color:black'>Find Expert :</p>" . $row_opleiders;
    echo $output;
}
else 
    echo "<center> <i class='hasNoResults'>No matching results</i> </center>";
}
