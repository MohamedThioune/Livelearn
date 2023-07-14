<?php /** Template Name: starter sample */ ?>

<?php 
extract($_POST); 
require('module-subscribe.php'); 
?>

<?php
$information = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'factuur_address' => $factuur_address,
    'email' => $email,
    'phone' => $phone,
];

// Start a subscription
$subscription = woocommmerce_subscribe($information, true);
?>