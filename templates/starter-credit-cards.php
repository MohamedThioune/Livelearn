<?php /** Template Name: starter credit card */ ?>

<?php extract($_POST); ?>
<?php require('module-subscribe.php'); ?>

<?php
$is_trial = (!empty($is_trial)) ? true : false;
$information = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'factuur_address' => $factuur_address,
    'email' => $email,
    'phone' => $phone,
    'is_trial' => $is_trial
];

//Start the credit card subscription
// $mollie_subscription = mollie_card_subscribe($information, true);

// echo($mollie_subscription);

?> 
