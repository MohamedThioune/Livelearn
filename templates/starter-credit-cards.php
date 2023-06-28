<?php /** Template Name: starter credit card */ ?>

<?php extract($_POST); ?>
<?php require('module-subscribe.php'); ?>

<?php
$information = [
    'first_name' => $first_name,
    'last_name' => $last_name,
    'factuur_address' => $factuur_address,
    'email' => $email,
    'phone' => $phone,
];

//Start the credit card subscription
$mollie_subscription = mollie_card_subscribe($information, true);
//var_dump($mollie_subscription);
echo($mollie_subscription);

?>
