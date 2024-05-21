<?php

function makecall($url, $type, $data = null) {
    // credentials
    $api_key = "Bearer sk_test_51JyijWEuOtOzwPYXl8Z57qbOuYURVnzEMvVFgUT0Wo7lmAWx2Qr9qQMASvyEkYpDVf1FRL25yWa0amHVSBl2KYC400iZFj6eek";
    // $params = array( // 
    //     'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
    //     'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    // );

    // create endpoint with params
    $endpoint = $url;
    // $endpoint = $url . '?' . http_build_query( $params );

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
    // var_dump($header);

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
    $information = ['data' => (Object)$datum];

    // return data
    return $information;

}

// function checkin($data){

// }

function create_customer_stripe($data){
    $endpoint = "https://api.stripe.com/v1/customers";
    $information = makecall($endpoint, 'POST', $data);

    return $information;
}

function create_subscription_stripe($data){
    $endpoint = "https://api.stripe.com/v1/subscriptions";
    $information = makecall($endpoint, 'POST', $data);
    return $information;
}

function stripe(WP_REST_Request $request){
    $product_id = "prod_Q8xu6g6y5DTgUU";
    $price_id = "price_1PIh1OEuOtOzwPYXa9f7omP8";

    $required_parameters = ['name', 'email'];
  
    //Check required parameters register
    $errors = validated($required_parameters, $request);
    if($errors):
      $response = new WP_REST_Response($errors);
      $response->set_status(401);
      return $response;
    endif;
  
    //Data information | customer 
    $data_customer = [
        'name' => $request['name'],
        'email' => $request['email'],
        // 'metadata' => [
        //     'wordpress_id' => 0,
        // ]
    ];

    //Create a new customer if needed
    $information = create_customer_stripe($data_customer);
    if(isset($information['error'])):
        $response = new WP_REST_Response($information);
        $response->set_status(401);
        return $response;
    endif;
    //Register on database && Customer information
    /** Instructions on here */
    $data = $information['data'];
    $customer_id = $data->id;

    //Data information | customer 
    $data_customer = [
        'customer' => $customer_id,
        'items' => [[
            'price' => $price_id
        ]]
    ];

    //Create a new subscription with that customer information
    $information = create_subscription_stripe($data_customer);
    if(isset($information['error'])):
        $response = new WP_REST_Response($information);
        $response->set_status(401);
        return $response;
    endif;

    // Response
    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;
}