<?php /** Template Name: Fetch pricing */ ?>

<?php
extract($_POST);

$global_price = 5;
$pricing = $medewerkers * 5;
$pricing = '€' . number_format($pricing, 2, '.', ',');

echo '<p class="title output">' . $pricing .'</p>';
