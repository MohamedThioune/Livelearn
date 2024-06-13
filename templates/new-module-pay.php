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
    // $header = curl_getinfo( $ch );

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

function create_token_stripe($data){
    $endpoint = "https://api.stripe.com/v1/tokens";
    $information = makecall($endpoint, 'POST', $data);
    
    return $information;
}

function create_card($data){
    $endpoint = "https://api.stripe.com/v1/customers/" . $data['customer_id'] . "/sources" ;
    $information = makecall($endpoint, 'POST', $data);
    
    return $information;
}

function create_customer_stripe($data){
    //Create customer
    // $data_customer = [
    //     'name' => $data['name'],
    //     'email' => $data['email'],
    //     'metadata' => [
    //         'UserID' => $data['ID'],
    //     ],
    // ];
    // $endpoint = "https://api.stripe.com/v1/customers";
    // $information = makecall($endpoint, 'POST', $data_customer);
    // if(isset($information['error']))
    //     return $information;
    // //Get customer ID if after creation
    // $data['customer_id'] = $information['data']->id;

    if(!isset($data['number']))
        return $data['customer_id'];
    $information = array();
    $data['customer_id']= "cus_QExVc7bUQpI5X0";
    //Create card token stripe
    $data_card_token = [
        'card' => [
            'number' => $data['number'],
            'exp_month' => $data['exp_month'],
            'exp_year' => $data['exp_year'],
            'cvc' => $data['cvc']
        ]
    ];
    $information = create_token_stripe($data_card_token);
    return $information;
    if(isset($information['error']))
        return $data['customer_id'];
    //Get token ID if after creation
    $data['source'] = $information['data']->id;

    if(!isset($data['source']))
        return $data['customer_id'];
    $information = array();
    //Create card 
    $data_card = [
        'source' => $data['source']
    ];
    $information = create_card($data_card);
    
    return $data['customer_id'];

    // return $information;
}

// function create_subscription_stripe($data){
//     $endpoint = "https://api.stripe.com/v1/subscriptions";
//     $information = makecall($endpoint, 'POST', $data);
//     return $information;
// }

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
    $required_parameters = ['name', 'email', 'number', 'exp_month', 'exp_year', 'cvc', 'ID'];
    $errors = validated($required_parameters, $request);
    if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
    endif;
    $data_customer = [
        'name' => $request['name'],
        'email' => $request['email'],
        'ID' => $request['ID'],
        'number' => $request['number'],
        'exp_month' => $request['exp_month'],
        'exp_year' => $request['exp_year'],
        'cvc' => $request['cvc']
    ];
    //Create customer
    $information = create_customer_stripe($data_customer);

    return $information;

    //Constant "If required we might change it here"
    $price_id = "price_1PKkQzEuOtOzwPYXtHofHkZ3";
    // $product_id = "prod_QB6e8E4wftx5Fs";
  
    //Data information | payment 
    $data_payment = [
        'line_items' => [[
            'price' => $price_id,
            'quantity' => $request['quantity']
        ]],
        'after_completion' => [
            'type' => 'redirect',
            'redirect' => [
                'url' => 'https://livelearn.nl/?message=sucessful-payment'  
            ]
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

function pay_stripe(WP_REST_Request $request){
    //Constant "If required we might change it here"
    $price_id = "price_1POIFyEuOtOzwPYX4JYFoOyM";

    //Check required parameters register
    $required_parameters = ['ID'];
    $errors = validated($required_parameters, $request);
    if($errors):
    $response = new WP_REST_Response($errors);
    $response->set_status(401);
    return $response;
    endif;

    //Data information | payment 
    $data_payment = [
        'line_items' => [[
            'price' => $price_id,
            'quantity' => 1
        ]],
        // 'after_completion' => [
        //     'type' => 'redirect',
        //     'redirect' => [
        //         'url' => 'https://livelearn.nl/?message=sucessful-payment'  
        //     ]
        // ],
        'subscription_data' => [
            'metadata' => [
                'UserID' => $request['ID']
            ]
        ]
    ];

    // Response
    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;

}