<?php /** Template Name: Fetch pricing */ ?>

<?php
extract($_POST);

$global_price = 4.95;
$pricing = $medewerkers * $global_price;
$pricing = '€' . number_format($pricing, 2, '.', ',');

echo '<p class="title output">' . $pricing .'</p>';
