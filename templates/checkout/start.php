<?php /** Template Name: checkout start */ ?>

<?php
require_once __DIR__ . '/../new-module-subscribe.php';

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
    $permalink = get_permalink($postID); 
    $thumbnail = "";
    if(!$thumbnail):
        $thumbnail = get_the_post_thumbnail_url($postID);
        if(!$thumbnail)
            $thumbnail = get_field('url_image_xml', $postID);
        if(!$thumbnail)
            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
    endif;
    $data_product = [
        'name' => $post->post_title,
        'description' => $short_description,
        'images' => [ $thumbnail ],
        'url' => $permalink,
        'metadata' => [
            'courseID' => $post->ID,
        ]
    ];
    $productID = create_product($data_product);

    // create price 
    $data_price = [
        'currency' => $data['currency'],
        'unit_amount' => $amount,
        'product_data' => [
            'ID' => $data['ID'],
        ],    
        'metadata' => [
            'courseID' => $post->ID,
        ]

    ];
    $priceID = create_price($data_price);

    // CRYPT
    $key_password = "C@##me1995.";
    $encryptedPriceID = openssl_encrypt($priceID, "AES-128-ECB", $key_password);

    $URL = "/checkout-stripe?priceID=" . $encryptedPriceID;  
    header('Location: '. $URL);
endif;