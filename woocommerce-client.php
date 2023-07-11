<?php /** Template Name: Client Wordpress */ ?>


<?php wp_head(); ?>
<?php get_header(); ?>

<?php

require __DIR__ . '/vendor/autoload.php';
use Goutte\WooCommerce\Client;
use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'http://livelearn.nl',
    'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
    'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    [
      'wp_api' => true,
      'version' => 'wc/v3',
    ]
  );

print_r($woocommerce->get('orders'));
?>



