<?php

function makecall($url, $type, $data = null, $params = null) {
    // credentials personal + live
    $api_key = "Bearer sk_test_51JyijWEuOtOzwPYXl8Z57qbOuYURVnzEMvVFgUT0Wo7lmAWx2Qr9qQMASvyEkYpDVf1FRL25yWa0amHVSBl2KYC400iZFj6eek";
    // $api_key = "Bearer sk_test_51MtSplHe23toRzexBAOzPcAljGx9f0mWTl687iaxjJAlneTiUFTi4NCjffnL48dvXkFOnb1HPPrthXmN9w51J8tz00YD43xgJ8";

    // create endpoint with params
    $endpoint = (!$params) ? $url :  $url . '?' . http_build_query( $params );

    // initialize curl
    $ch = curl_init();

    $output_type = ( $type == 'GET' ) ? false : true; 
    
    // set other curl options
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: ' . $api_key]);
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, $output_type);
    if($output_type)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    // get response, error handling
    $response = curl_exec( $ch );
    $err = curl_errno( $ch );
    $errmsg = curl_error( $ch );
    // $header = curl_getinfo( $ch );

    // error handling
    if ($response === false || $err):
        $errmsg = curl_error( $ch ) ?: 'Something went wrong, please try again !';
        $information = ['error' => $err, 'errormsg' => $errmsg];
        return $information;
    endif;

    // close curl
    curl_close( $ch );

    $datum = json_decode( $response, true );
    $information = ['data' => (Object)$datum];

    // return data
    return $information;

}

function create_payment_link($data){
    $endpoint = "https://api.stripe.com/v1/payment_links";
    $information = makecall($endpoint, 'POST', $data);
    return $information;
}

function search($data) {
    $endpoint = "https://api.stripe.com/v1/subscriptions/search";
    $query = "status:'active' AND metadata['UserID']:'" . $data['userID'] . "'";
    $params = array( 
        'query' => $query
    );

    $information = makecall($endpoint, 'GET', null, $params);

    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;
}

function update(WP_REST_Request $request) {
    //Check required parameters register
    $required_parameters = ['subscription', 'quantity', 'ID'];
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    $data = [
        'quantity' => $request['quantity'],
        'metadata' => [
            'UserID' => $request['ID']
        ]   
    ];

    $endpoint = "https://api.stripe.com/v1/subscription_items/" . $request['subscription'];
    $information = makecall($endpoint, 'POST', $data);

    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;
}

function stripe(WP_REST_Request $request){
    //Check required parameters register
    $required_parameters = ['quantity', 'ID', 'callback'];
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    //Constant "If required we might change it here"
    $price_id = "price_1PKkQzEuOtOzwPYXtHofHkZ3";
  
    //Data information | payment 
    $data_payment = [
        'line_items' => [[
            'price' => $price_id,
            'quantity' => $request['quantity']
        ]],
        'after_completion' => [
            'type' => 'redirect',
            'redirect' => [
                'url' => $request['callback'],
            ]
        ],
        'automatic_tax' => [
            'enabled' => "true",
        ],
        'subscription_data' => [
            'metadata' => [
                'UserID' => $request['ID']
            ]
        ]
    ];

    //Control if this user is a manager or not 
    /** Instructions there */

    //Create a new payment link
    $information = create_payment_link($data_payment);

    // Response
    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;
}

// function create_product($data){
//     //Create product
//     $data_product = [
//         'name' => $data['name'],
//         'description' => $data['description'],
//         'images' => [ $data['image'] ],
//         'url' => $data['url'],
//         'metadata' => [
//             'courseID' => $data['ID'],
//         ]
//     ];
//     $endpoint = "https://api.stripe.com/v1/products";
//     $information = makecall($endpoint, 'POST', $data_product);

//     //case : error primary
//     if(isset($information['error']))
//         return 0;
//         // return $information['error'];

//     //case : error internal
//     if(isset($information['data']->error))
//         return 0;
//         // return $information['data'];

//     $product_id = null;    
//     //case : success
//     if($information['data'])
//     if($information['data']->client_secret)
//         $product_id = $information['data']->id;

//     //Get product ID if after creation
//     /** Instructions here ! */

//     return $product_id;
// }

function create_price($data){
    $amount =  ($amount) ? $data['amount'] . "00" : 0;
    //Create price
    $data_price = [
        'currency' => $data['currency'],
        'unit_amount' => $amount,
        'product_data' => [
            'name' => $data['product_name'],
            'statement_descriptor' => 'LIVELEARN PAY !',
            'metadata' => [
                'courseID' => $data['ID'],
            ]
        ],
        'tax_behavior' => 'exclusive'
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

    $price_id = null;    
    //case : success
    if($information['data'])
    if($information['data']->id)
        $price_id = $information['data']->id;

    //Get product ID if after creation
    /** Instructions here ! */

    return $price_id;
}

// function create_subscription_stripe($data){
//     $endpoint = "https://api.stripe.com/v1/subscriptions";
//     $information = makecall($endpoint, 'POST', $data);
//     return $information;
// }

// function create_token_stripe($data){
//     $endpoint = "https://api.stripe.com/v1/tokens";
//     $information = makecall($endpoint, 'POST', $data);  
//     return $information;
// }

// function create_card($data){
//     $endpoint = "https://api.stripe.com/v1/customers/" . $data['customer_id'] . "/sources" ;
//     $information = makecall($endpoint, 'POST', $data); 
//     return $information;
// }
