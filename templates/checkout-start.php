<?php /** Template Name: Checkout Start */ ?>

<?php
require_once 'new-module-subscribe.php';

// $mail_notification_invitation = '/mail-notification-invitation.php';
// require(__DIR__ . $mail_notification_invitation); 

global $wpdb;
global $wp;

extract($_POST);

//create product/price 
if(isset($productPrice)):
    // get course
    $post = get_post($postID);
    $course_type = get_field('course_type', $postID);

    // create product
    $short_description = get_field('short_description', $post->ID) ?: 'Your adventure begins with Livelearn !';
    $prijs = get_field('short_description', $post->ID) ?: 0; 
    $permalink = get_permalink($postID); 
    $thumbnail = "";
    if(!$thumbnail):
        $thumbnail = get_field('url_image_xml', $post->ID);
        if(!$thumbnail)
            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
    endif;
    // $data_product = [
    //     'name' => $post->post_title,
    //     'description' => $short_description,
    //     'images' => [ $thumbnail ],
    //     'url' => $permalink,

    //     'metadata' => [
    //         'courseID' => $post->ID,
    //     ]
    // ];
    // $productID = create_product($data_product);

    // create price 
    $currency = 'eur';
    $data_price = [
        'currency' => $currency,
        'amount' => $amount,
        'product_name' => $post->post_title,
        'product_description' => $short_description,
        'statement_descriptor' => 'LIVELEARN PAY !',
        'product_image' => $thumbnail,
        'product_url' => $permalink,
        'ID' => $post->ID,
    ];
    $priceID = create_price($data_price);

    // CRYPT
    $key_password = "C@##me1995.";
    $encryptedPriceID = openssl_encrypt($priceID, "AES-128-ECB", $key_password);

    $URL = "/checkout-stripe?priceID=" . $encryptedPriceID;  
    header('Location: '. $URL);
endif;