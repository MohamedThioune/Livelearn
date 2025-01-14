<?php

require_once 'stripe-secrets.php';

function makecall($url, $type, $data = null, $params = null) {
    global $stripeSecretKey;

    // credentials personal + live
    $api_key = "Bearer " . $stripeSecretKey ;
    // $api_key = "Bearer sk_test_51JyijWEuOtOzwPYXl8Z57qbOuYURVnzEMvVFgUT0Wo7lmAWx2Qr9qQMASvyEkYpDVf1FRL25yWa0amHVSBl2KYC400iZFj6eek";
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

function get_invoice_by_subscription($data){
    $endpoint = "https://api.stripe.com/v1/invoices";
    $customer = isset($data['customer']) ? $data['customer'] : null;
    $subscription = isset($data['subscription']) ? $data['subscription'] : null;
    //test customer,subscription 
    if(!$customer || !$subscription)
        return false;

    $params = array( 
        'customer' => $customer,
        'subscription' => $subscription
    );
    $datum = makecall($endpoint, 'GET', null, $params);
    $information = $datum['data'];
    return $information;
}

function search_invoices($data){
    $datum = search($data);
    $information = $datum->data['data']->data;

    $customer = 0;
    //get customer if not empty
    if($information[0]):
        $subscription = (isset($information[0]['id'])) ? $information[0]['id'] : $customer;
        $customer = (isset($information[0]['customer'])) ? $information[0]['customer'] : $customer;
    endif;
    
    //get invoices in success
    $query_invoice = ['customer' => $customer, 'subscription' => $subscription];
    $invoices = get_invoice_by_subscription($query_invoice);
    
    return $invoices;
}

function search($data) {
    $endpoint = "https://api.stripe.com/v1/subscriptions/search";
    $query = "status:'active' AND metadata['CompanyID']:'" . $data['companyID'] . "'";
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
    $required_parameters = ['subscription', 'licenses'];
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    //Licences
    $licenses_array = $request['licenses'];
    if(empty($licenses_array) || !is_array($licenses_array)):
        $errors['errors'] = 'Please provide in array user IDs which will benefit access !';
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    $quantity = count($request['licenses']);

    $licenses = implode(',', $licenses_array);

    $data = [
        'quantity' => $quantity,
        'metadata' => [
            'Licenses' => $licenses
        ]   
        // 'line_items' => [[
        //     'price' => $price_id,
        //     'quantity' => $quantity,
        //     'metadata' => [
        //         'Licenses' => $licenses
        //     ]
        // ]],
    ];

    $endpoint = "https://api.stripe.com/v1/subscriptions/" . $request['subscription'];
    $information = makecall($endpoint, 'POST', $data);

    $response = new WP_REST_Response($information);
    $response->set_status(200);
    return $response;
}

function stripe(WP_REST_Request $request){
    //Check required parameters register
    $required_parameters = ['quantity', 'ID', 'CompanyID', 'callback'];
    $errors = validated($required_parameters, $request);
    if($errors):
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    //Check error on User or Company 
    $company = get_post($request['CompanyID']);
    $user = get_user_by('ID', $request['ID']);
    $errors = [];
    if (!$company || !$user) :
        $errors['errors'] = 'No company or user found !';
        $response = new WP_REST_Response($errors);
        $response->set_status(401);
        return $response;
    endif;

    //Constant "If required we might change it here"
    $price_id = "price_1Qh8paHe23toRzexLtU5R7hE";

    //Starting licenses | owner of subscription
    $licenses = $request['ID'];
  
    //Data information | payment 
    $data_payment = [
        'line_items' => [[
            'price' => $price_id,
            'quantity' => $request['quantity'],
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
                'UserID' => $request['ID'],
                'CompanyID' => $request['CompanyID'],
                'Licenses' => $licenses
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

function search_price($postID) {
    $endpoint = "https://api.stripe.com/v1/prices/search";
    $query = "active:'true' AND metadata['postID']:'" . $postID . "'";
    $params = array( 
        'query' => $query
    );

    $data = makecall($endpoint, 'GET', null, $params);
    $information = $data['data']->data;

    $price_id = 0;    
    //case : success
    if($information[0])
        $price_id = (isset($information[0]['id'])) ? $information[0]['id'] : $price_id;
    return $price_id;
}

function create_price($data){
    $amount = ($data['amount']) ? $data['amount'] . "00" : 0;
    //Create price
    $data_price = [
        'currency' => $data['currency'],
        'unit_amount' => $amount,
        'product_data' => [
            'name' => $data['product_name'],
            'statement_descriptor' => 'LIVELEARN PAY !',
            'metadata' => [
                'postID' => $data['ID'],
            ]
        ],
        'metadata' => [
            'postID' => $data['ID'],
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
