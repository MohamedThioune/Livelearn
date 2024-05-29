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
        $errmsg = 'Something went wrong, please try again !';
        if($errmsg):
            $errmsg = curl_error( $ch );
            $information = ['error' => $err, 'errormsg' => $errmsg];
            return $information;
        endif;
    endif;

    // close curl
    curl_close( $ch );

    $datum = json_decode( $response, true );
    $information = (Object)['data' => $datum];

    // return data
    return $information;

}

// function create_customer_stripe($data){
//     $endpoint = "https://api.stripe.com/v1/customers";
//     $information = makecall($endpoint, 'POST', $data);

//     return $information;
// }
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
    $query = "status:'active' AND metadata['order_id']:'" . $data['id'] . "'";
    $params = array( 
        'query' => $query
    );

    $information = makecall($endpoint, 'GET', null, $params);

    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;
}

function stripe(WP_REST_Request $request){
    //Constant "If required we might change it here"
    $price_id = "price_1PKkQzEuOtOzwPYXtHofHkZ3";
    // $product_id = "prod_QB6e8E4wftx5Fs";

    //Check required parameters register
    $required_parameters = ['quantity', 'ID'];
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

    //Create a new payment link
    $information = create_payment_link($data_payment);

    // Response
    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;
}