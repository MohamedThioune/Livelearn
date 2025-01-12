<?php /** Template Name: starter sample */ ?>

<?php 
extract($_POST); 
require('module-subscribe.php'); 
?>

<?php

$is_trial = (!empty($is_trial)) ? true : false;
$information = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'factuur_address' => $factuur_address,
    'email' => $email,
    'phone' => $phone,
    'is_trial' => $is_trial,    
];
 
// Start a subscription
$subscription = woocommmerce_subscribe_api($information, true);
// var_dump($subscription);
?>