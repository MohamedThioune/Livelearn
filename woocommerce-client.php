<?php /** Template Name: Client Wordpress */ ?>


<?php wp_head(); ?>
<?php get_header(); ?>

<?php
require_once __DIR__ . '/vendor/automattic/woocommerce/src/WooCommerce/Client.php';

use Client;

$woocommerce = new Client(
    'http://livelearn.nl',
    'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
    'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    [
      'version' => 'wc/v3',
    ]
  );

$woocommerce = new Client($url, $consumer_key, $consumer_secret, $options);
print_r($woocommerce->get('orders'));
?>



