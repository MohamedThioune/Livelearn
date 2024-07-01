<?php /** Template Name: Checkout Module */ ?>

<?php

require_once 'new-module-subscribe.php';

// function create_customer_stripe($data){
//     //Create customer
//     $data_customer = [
//         'name' => $data['name'],
//         'email' => $data['email'],
//         'metadata' => [
//             'UserID' => $data['ID'],
//         ],
//     ];
//     $endpoint = "https://api.stripe.com/v1/customers";
//     $information = makecall($endpoint, 'POST', $data_customer);

//     //Get customer ID if after creation
//     /** Instructions here ! */

//     return $information;
// }


function create_product($data){
    //Create product
    $data_product = [
        'name' => $data['name'],
        'description' => $data['description'],
        'images' => [ $data['image'] ],
        'url' => $data['url'],
        'metadata' => [
            'courseID' => $data['ID'],
        ]
    ];
    $endpoint = "https://api.stripe.com/v1/products";
    $information = makecall($endpoint, 'POST', $data_product);

    //case : error primary
    if(isset($information['error']))
        return 0;
        // return $information['error'];

    //case : error internal
    if(isset($information['data']->error))
        return 0;
        // return $information['data'];

    $product_id = null;    
    //case : success
    if($information['data'])
    if($information['data']->client_secret)
        $product_id = $information['data']->id;

    //Get product ID if after creation
    /** Instructions here ! */

    return $product_id;
}

function create_price($data){
    $amount = $data['amount'] . "00";
    //Create price
    $data_price = [
        'currency' => $data['currency'],
        'unit_amount' => $amount,
        'product_data' => [
            'ID' => $data['ID'],
        ],
    ];
    $endpoint = "https://api.stripe.com/v1/prices";
    $information = makecall($endpoint, 'POST', $data_price);

    //case : error primary
    if(isset($information['error']))
        return 0;
        // return $information['error'];

    //case : error internal
    if(isset($information['data']->error))
        return 0;
        // return $information['data'];

    $product_id = null;    
    //case : success
    if($information['data'])
    if($information['data']->client_secret)
        $product_id = $information['data']->id;

    //Get product ID if after creation
    /** Instructions here ! */

    return $price_id;
}

function create_session($data){
    $endpoint = "https://api.stripe.com/v1/checkout/sessions";
    $information = makecall($endpoint, 'POST', $data);

    return $information;
}

function session_stripe($price_id){
    $YOUR_DOMAIN = get_site_url();
    // $YOUR_ENDPOINT = get_site_url() . '/wp-json/custom/v1/checkout-stripe';
    $PRICE_ID = ($price_id) ?: null;
    $data = [
        'ui_mode' => 'embedded',
        'line_items' => [[
            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
            'price' =>  $PRICE_ID,
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        // 'return_url' => $YOUR_DOMAIN,
        'return_url' => $YOUR_DOMAIN . '/return.html?session_id={CHECKOUT_SESSION_ID}',
        'automatic_tax' => [
            'enabled' => "true",
        ],
    ];

    //Create session object
    $information = create_session($data);

    //case : error primary
    if(isset($information['error']))
        return $information['error'];

    //case : error internal
    if(isset($information['data']->error))
        return $information['data'];

    $client_secret = null;    
    //case : success
    if($information['data'])
    if($information['data']->client_secret)
        $client_secret = $information['data']->client_secret;

    return json_encode(array('clientSecret' => $client_secret));
    
}

//Call stripe secret
$session_stripe_secret = session_stripe($price_id);
echo $session_stripe_secret;
