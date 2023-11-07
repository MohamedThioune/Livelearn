<?php /** Template Name: Product Search */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<?php
$page = 'check_visibility.php';
require($page);

//Modules 
require_once('postal.php'); 
require_once('search-module.php'); 

?>