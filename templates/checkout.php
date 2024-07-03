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

function create_session($data){
    $endpoint = "https://api.stripe.com/v1/checkout/sessions";
    $information = makecall($endpoint, 'POST', $data);

    return $information;
}

function session_stripe($price_id, $mode, $post_id = null, $user_id = null){
    $YOUR_DOMAIN = get_site_url() . '/dashboard/user/activity/';
    $PRICE_ID = ($price_id) ?: null;

    //Get post information
    $post = array(
        'ID' => null, 
        'name' => null, 
        'description' => null,
        'prijs' => null,
        'permalink' => null,   
        'image' => null
    );
    $post_data = ($post_id) ? get_post($post_id) : array();
    $standard_text = 'Your adventure begins now with Livelearn !'; 
    if(!empty($post_data)):
        $course_type = get_field('course_type', $post_data->ID);
        $post['ID'] = $post_data->ID;
        $post['name'] = $post_data->post_title;
        $post['description'] = get_field('short_description', $post_data->ID) ?: $standard_text;
        $post['prijs'] = get_field('price', $post_data->ID) ?: 0; 
        $post['permalink'] = get_permalink($post_data->ID); 
        $thumbnail = "";
        if(!$thumbnail):
            $thumbnail = get_field('url_image_xml', $post_data->ID);
            if(!$thumbnail)
                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
        endif;
        $post['image'] = $thumbnail;
    endif;
    $post = (Object)$post_data;

    //Get User information
    $user = get_user_by('ID', $user_id);

    if($mode == 'setup')
        $data = [
            'ui_mode' => 'embedded',
            'currency' => 'eur',
            'mode' => $mode,
            // 'return_url' => $YOUR_DOMAIN,
            'return_url' => $YOUR_DOMAIN . '/?session_id={CHECKOUT_SESSION_ID}',
        ];
    else
        $data = [
            'ui_mode' => 'embedded',
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $price_id,
                'quantity' => 1,
            ]],
            'mode' => $mode,
            'return_url' => $YOUR_DOMAIN . '/?session_id={CHECKOUT_SESSION_ID}',
            'automatic_tax' => [
                'enabled' => "true",
            ],
            'customer_creation' => 'if_required',
            'metadata' => [
                'userID' => $user->ID,
                'postID' => $post->ID,
            ],
            'invoice_creation' => [
                'enabled' => "true",
                'invoice_data' => [
                    // 'custom_fields' => [
                    //     'name' => $user->display_name,
                    //     'email' => $user->user_email,
                    // ],
                    'description' => $post->name,
                    'metadata' => [
                        'userID' => $user->ID,
                        'postID' => $post->ID,
                    ],
                ],
            ],
        ];

    //Create session object
    $information = create_session($data);
    var_dump($information);
    return 0;

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

function retrieve_session($session_id){
    //case : session_id null
    if(!$session_id)
        return 0;

    $endpoint = "https://api.stripe.com/v1/checkout/sessions/" . $session_id;
    $information = makecall($endpoint, 'GET');

    return $information;
}

function stripe_status($data){
    //Call retrieve_session
    $session = null;
    $return_session = null;
    $information = retrieve_session($data);

    //case : error primary
    if(isset($information['error']))
        return 0;

    //case : error internal
    if(isset($information['data']->error))
        return 0;

    if($information['data'])
        $session = $information['data'];

    //case : session status
    try {
        $return_session = ['status' => $session->status, 'customer_email' => $session->customer_details['email']];
        return $return_session;
    } catch (Error $e) {
        $return_session = ['error' => $e->getMessage()];
        return $return_session;
    }
}

//Call stripe secret
$_GET['priceID'] = "price_1PYBukEuOtOzwPYXUiCztgKa";
$_GET['mode'] = 'payment';
$postID = 10799;
$userID = 3;
// $postID = isset($_GET['postID']) ? $_GET['postID'] : null;
// $userID = isset($_GET['userID']) ? $_GET['userID'] : null;

if(isset($_GET['priceID']) && $_GET['mode']):
    $session_stripe_secret = session_stripe($_GET['priceID'], $_GET['mode'], $postID, $userID);
    echo($session_stripe_secret);
endif;