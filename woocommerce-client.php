<?php /** Template Name: Client Wordpress */ ?>


<?php wp_head(); ?>
<?php get_header(); ?>

<?php

require_once __DIR__ . '/vendor/automattic/woocommerce/src/WooCommerce/Client.php';

$woocommerce = new Client;

print_r($woocommerce->get('orders'));
?>



