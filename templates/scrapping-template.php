<?php /** Template Name: scrapping */ ?>

<?php
include_once 'simple_html_dom.php';
include_once 'usefull_functions.php';
global $wpdb;

$table = $wpdb->prefix . 'databank';

if (isset($_POST['action']) && $_POST['action'] == 'reload_data')
 {
    extract($_POST);
    $articles = scrapeFrom(A);
    foreach ($articles as $article){
      persistArticle($article);
    } 
}
?>