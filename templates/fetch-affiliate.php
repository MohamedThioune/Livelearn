<?php /** Template Name: Fetch affiliate */ ?>

<?php
extract($_POST);

$medewerkers = intval($medewerkers);
$euros = 0;
switch ($medewerkers) {
    case in_array($medewerkers, range(1,50)):
        $euros = 2.50;
        break;
    
    case in_array($medewerkers, range(51,100)):
        $euros = 3.50;
        break;

    case in_array($medewerkers, range(101,250)):
        $euros = 5;
        break;
    
    case $medewerkers > 250:
        $euros = 7.50;
        break;
    }

$pricing = 125 + 175 + 500 + (110 * $euros);
$monthly = $medewerkers * 0.495;
$semester = $monthly * 6;

$fee = $pricing + $monthly + $semester;
$output = '€' . number_format($fee, 2, '.', ',');

echo '<p class="title output">' . $output .'</p>';

