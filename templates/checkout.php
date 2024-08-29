<?php /** Template Name: Checkout Module */ ?>

<?php

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

//Call stripe secret
// $_GET['priceID'] = "price_1Pkr41EuOtOzwPYX855Zgcbr";
// $_GET['mode'] = 'payment';
// $postID = 10799;
// $userID = 3;
// $metadata = null;
$postID = isset($_GET['postID']) ? $_GET['postID'] : null;
$userID = isset($_GET['userID']) ? $_GET['userID'] : null;
$metadata = isset($_GET['metadata']) ? $_GET['metadata'] : null;

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