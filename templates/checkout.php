<?php /** Template Name: Checkout Module */ ?>

<?php

require_once 'new-module-subscribe.php';
require_once 'orders-stripe.php';

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

function session_stripe($price_id, $mode, $post_id = null, $user_id = null, $offline = null, $ui_mode = null){
    $YOUR_DOMAIN = (!$user_id || $user_id == 'null') ?  get_site_url() . '/inloggen' : get_site_url() . '/dashboard/user/activity';
    $PRICE_ID = ($price_id) ?: null;
    $offline = ($offline) ?: null;
    $ui_mode = ($ui_mode) ? 'hosted': 'embedded';
    $key_return = ($ui_mode == 'hosted') ? 'success_url': 'return_url';

    //Get post information
    $sample = array(
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
        $sample['ID'] = $post_data->ID;
        $sample['name'] = $post_data->post_title;
        $sample['description'] = get_field('short_description', $post_data->ID) ?: $standard_text;
        $sample['prijs'] = get_field('price', $post_data->ID) ?: 0; 
        $sample['permalink'] = get_permalink($post_data->ID); 
        $thumbnail = "";
        if(!$thumbnail):
            $thumbnail = get_field('url_image_xml', $post_data->ID);
            if(!$thumbnail)
                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
        endif;
        $sample['image'] = $thumbnail;
    endif;
    $post = (Object)$sample;

    //Except course type [Artikel]

    //Get User information
    $user = get_user_by('ID', $user_id);

    if($mode == 'setup')
        $data = [
            'ui_mode' => $ui_mode,
            'currency' => 'eur',
            'mode' => $mode,
            // 'return_url' => $YOUR_DOMAIN,
            $key_return => $YOUR_DOMAIN . '/?session_id={CHECKOUT_SESSION_ID}',
        ];
    else
        $data = [
            'ui_mode' => $ui_mode,
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price' => $price_id,
                'quantity' => 1,
            ]],
            'mode' => $mode,
            $key_return => $YOUR_DOMAIN . '/?session_id={CHECKOUT_SESSION_ID}',
            'automatic_tax' => [
                'enabled' => "true",
            ],
            'customer_creation' => 'if_required',
            'metadata' => [
                'userID'  => $user->ID,
                'postID'  => $post->ID,
                'offline' => $offline
            ],
            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'FR', 'NL', 'SN']
            ],
            'custom_fields' => [
                [
                    'key' => 'company_name',
                    'label' => [
                        'type' => 'custom',
                        'custom' => 'Company',
                    ],
                    'optional' => 'true',
                    'type' => 'text',
                ],
                [
                    'key' => 'phone_number',
                    'label' => [
                      'type' => 'custom',
                      'custom' => 'Phone',
                    ],
                    'type' => 'numeric',
                ],
                [
                    'key' => 'additional_information',
                    'label' => [
                      'type' => 'custom',
                      'custom' => 'Additional information',
                    ],
                    'optional' => 'true',
                    'type' => 'text',
                ],
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
    // var_dump($information);

    //case : error primary
    if(isset($information['error']))
        return $information['error'];

    //case : error internal
    if(isset($information['data']->error))
        return $information['data'];

    //case : success - hosted 
    if($ui_mode == 'hosted')
        if($information['data'])
        if($information['data']->url):
            $url = $information['data']->url;
            return array('message' => 'Session successfully created !', 'url' => $url);
        endif;

    $client_secret = null;    
    //case : success - embedded
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
    $information = makecall($endpoint, 'GET', null);

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

    $register_message = '';
    if(!isset($session->metadata['userID']) || $session->metadata['userID'] == "null"):
        //Check if email match record on our database 
        $args = array(
            'search'  => $session->customer_details['email'],
            'search_columns' => array( 'user_login', 'user_email' ),
        );
        $users_search = get_users($args);
        $userSearch = isset($users_search[0]) ? $users_search[0] : null;
        $userID = isset($userSearch->ID) ? $userSearch->ID : null;

        //Use existing email
        if($userID) :
            $session->metadata['userID'] = $userID;
            $register_message = "We find on our records a email already corresponding to email : " . $session->customer_details['email'] . "<br>We have therefore taken the liberty of assigning this command to this user.";
        else : 
        //Register this user
            $password = 'L1vele@rn2024';
            $userdata = array(
                'user_pass' => $password,
                'user_login' => $session->customer_details['email'],
                'user_email' => $session->customer_details['email'],
                'user_url' => 'http://livelearn.nl/',
                'display_name' => $session->customer_details['name'],
                'first_name' => $session->customer_details['name'],
                'last_name' => "",
                'role' => 'subscriber'
            );
            $userID = wp_insert_user($userdata);
            if (is_wp_error($userID)):
                $register_message = $userID->get_error_message();
            else:
                $session->metadata['userID'] = $userID;
                $register_message = "Your account has been registered successfully with : <br> email : " . $session->customer_details['email'] . " temporary password : " . $password;
            endif;
        endif;
    endif;

    //case : session status
    try {
        $success = "complete";
        $somethin_wrong = "<small>The payment was applied but communication with Stripe was suddenly interrupted.<br>
        Please contact us at <a href='mailto:contact@livelearn.nl'>contact@livelearn.nl</a></small>";
        $data_order = array(
            'session_id' => $session->id, 
            'course_id' => $session->metadata['postID'], 
            'status' => $success, 
            'prijs' => 'true',
            'auth_id' => $session->metadata['userID'],  
            'owner_id' => $session->metadata['userID'], 
            'metadata' =>  $session->metadata['offline'], 
        );

        //create a order information
        $order_stripe = create_order($data_order);

        if(!$order_stripe)
            echo $somethin_wrong;

        $return_session = ['status' => $session->status, 'customer_email' => $session->customer_details['email'], 'register_message' => $register_message];
        return $return_session;
    } catch (Error $e) {
        $return_session = ['error' => $e->getMessage()];
        return $return_session;
    }
}

//Call stripe secret
$_GET['priceID'] = "price_1Pkr41EuOtOzwPYX855Zgcbr";
$_GET['mode'] = 'payment';
$postID = 10799;
$userID = 3;
$metadata = null;
// $postID = isset($_GET['postID']) ? $_GET['postID'] : null;
// $userID = isset($_GET['userID']) ? $_GET['userID'] : null;
// $metadata = isset($_GET['metadata']) ? $_GET['metadata'] : null;

//Checkout session stripe
if(isset($_GET['priceID']) && $_GET['mode']):
    $session_stripe_secret = session_stripe($_GET['priceID'], $_GET['mode'], $postID, $userID, $metadata);
    echo($session_stripe_secret);
endif; 

//Create order 
if(isset($_POST['order_free'])):
    $success = 'complete';
    $data_order = array(
        'course_id' => $_POST['postID'], 
        'status' => $success, 
        'prijs' => 'false',
        'auth_id' => $_POST['authID'],  
        'owner_id' => $_POST['authID'], 
        'additional_name' => $_POST['additional_name'],
        'additional_email' => $_POST['additional_email'],
        'additional_company' => $_POST['additional_company'],
        'additional_phone' => $_POST['additional_phone'],
        'additional_adress' => $_POST['additional_adress'],
        'additional_information' => $_POST['additional_information'],
    );

    //Check existing user information "MAKE IT AS A FUNCTION !"
    $register_message = 0;
    if($_POST['authID'] == "null"):
        //Check if email match record on our database 
        $args = array(
            'search'  => $_POST['additional_email'],
            'search_columns' => array( 'user_login', 'user_email' ),
        );
        $users_search = get_users($args);
        $userSearch = isset($users_search[0]) ? $users_search[0] : null;
        $userID = isset($userSearch->ID) ? $userSearch->ID : null;

        //Use existing email
        if($userID) :
            $data_order['auth_id'] = $userID;
            $data_order['owner_id'] = $userID;
            $register_message = "We find on our records a email already corresponding to email : " . $_POST['additional_email'] . "<br>We have therefore taken the liberty of assigning this command to this user.";
        else : 
        //Register this user
            $password = 'L1vele@rn2024';
            $userdata = array(
                'user_pass' => $password,
                'user_login' => $_POST['additional_email'],
                'user_email' => $_POST['additional_email'],
                'user_url' => 'http://livelearn.nl/',
                'display_name' => $_POST['additional_name'],
                'first_name' => $_POST['additional_name'],
                'last_name' => "",
                'role' => 'subscriber'
            );
            $userID = wp_insert_user($userdata);
            if (is_wp_error($userID)):
                $register_message = $userID->get_error_message();
            else:
                $data_order['auth_id'] = $userID;
                $data_order['owner_id'] = $userID;    
                $register_message = "Your account has been registered successfully with : <br> email : " . $_POST['additional_email'] . " temporary password : " . $password;
            endif;
        endif;
    endif;

    //create a order information
    $order_stripe = create_order($data_order);
    $success = ($order_stripe) ? "Information filled up successfully !" : "Something went wrong !";
    $final_message  = ($register_message) ? '/inloggen/?message=' . $register_message : '/dashboard/user/activity/?message=' . $success;

    header('Location: ' . $final_message);
endif;