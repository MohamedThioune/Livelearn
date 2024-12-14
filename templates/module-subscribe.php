<?php

function woocommmerce_subscribe($information, $active){
    // $global_product_id = 9873;
    // $global_price = 5;

    /** Woocommerce API client for php **/
    $woocommerce = new Client(
    'https://www.livelearn.nl/',
    'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
    'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    [
        'version' => 'wc/v3',
    ]
    );

    /** Requirement information */
    $user_id = get_current_user_id();
    $company_title = get_field('company',  'user_' . $user_id)[0]->post_title;
    $users = get_users();
    $members = array();
    foreach($users as $user){
        $company_value = get_field('company',  'user_' . $user->ID);
        if(!empty($company_value)){
            $company_value_title = $company_value[0]->post_title;
            if($company_value_title == $company_title)
                array_push($members, $user);
        }
    }
    $team = count($members);

    if($is_trial){
        $date_now = date('Y-m-d H:i:s');
        $date_now_timestamp = strtotime($date_now);
        $trial_end_date = date("Y-m-d H:i:s", strtotime("+ 14 days" , $date_now_timestamp));
        $next_payment_date = date("Y-m-d H:i:s", strtotime("+1 month" , strtotime($trial_end_date)));
    }else{
        $date_now = date('Y-m-d H:i:s');
        $trial_end_date = $date_now;
        $date_now_timestamp = strtotime($date_now);
        $next_payment_date = date("Y-m-d H:i:s", strtotime("+1 month" , $date_now_timestamp));
    }

    if($active)
       $active = 'active';
    else
        $active = 'on-hold'; 

    /*
    ** Create subscription
    */ 
    $data = [
        'customer_id'       => $user_id,
        'status'            => $active,
        'billing_period'    => 'month',
        'billing_interval'  =>  1,
        'start_date'        => $date_now,
        'trial_end_date'    => $trial_end_date,
        'next_payment_date' => $next_payment_date,
        'payment_method'    => 'mollie',
        'prices_include_tax'=> true,
        'billing' => [
            'first_name' => $information['first_name'],
            'last_name'  => $information['last_name'],
            'company'    => $company_title,
            'address_1'  => $information['factuur_address'],
            'address_2'  => '',
            'city'     => '', 
            'state'    => 'DR-NL',
            'postcode' => '1011',
            'country'  => 'NL',
            'email'    => $information['email'],
            'phone'    => $information['phone'],
        ],
        'shipping' => [],
        'line_items' => [
            [
                'product_id' => $global_product_id,
                'quantity'   => $team,
            ],
        ],
        'shipping_lines' => [],
        'meta_data' => [],
    ];
    $subscription = $woocommerce->post('subscriptions', $data);
    if(isset($subscription)) 
        if ($subscription)
            return $subscription;

    echo "<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Something went wrong, please try later !</a></center>";
    http_response_code(500);
    return 0;
}

// function mollie_card_subscribe($information, $active){
//     $base_url = get_site_url();
//     $global_mollie_key = "test_SFMrurF62JkBVuzK9gxa3b72eJQhxu";
//     $global_price = 5;
//     $mollie = new \Mollie\Api\MollieApiClient();
//     $mollie->setApiKey($global_mollie_key);
//     $user_id = get_current_user_id();
//     $customer_id = get_field('mollie_customer_id', 'user_' . $user_id);

//     if(!$customer_id){
//         $customer = $mollie->customers->create([
//             'name' => $information['first_name'] . ' ' . $information['last_name'],
//             'email' => $information['email'],
//             'metadata' => [
//                 'user_id' => $user_id,
//             ]
//         ]);
//         update_field('mollie_customer_id', $customer->id, 'user_' . $user_id);
//         $customer_id = $customer->id;
//     }

//     if(!$customer_id){
//         echo "<center><br><a class='btn btn-default' style='background : #E10F51; color : white' href='#'>Something went wrong, please try again later !</a></center>";
//         http_response_code(500);
//         return 0;
//     }

//     /** Requirement information */
//     $company_title = get_field('company',  'user_' . $user_id)[0]->post_title;

//     //Create your payments
//     $data_payment = [
//         'method' => 'creditcard',
//         'amount' => [
//             'currency' => 'EUR',
//             'value' => '0.01',
//         ],
//         'description' => 'First payment - ' . $information['first_name'],
//         'sequenceType' => 'first',
//         'redirectUrl' => $base_url . '/cards-payment',
//         'webhookUrl' => 'https://webshop.example.org/payments/webhook/',
//         'metadata' => [
//             'company' => $company_title,
//         ]
//     ];
//     // 'woo_subscription_id' => $subscription->id,
//     $payment = $mollie->customers->get($customer_id)->createPayment($data_payment);
//     // var_dump($payment);
//     // return $payment;
    
//     if (!isset($payment->_links->checkout->href)) {
//         echo $base_url . "/?message='Error occurred on transaction !'";
//         http_response_code(500);
//         return 0;
//     }
//     else
//         return $payment->_links->checkout->href;

// }

function makeApiCallMollie($endpoint, $params, $type) {
    // credentials
    $api_key = "Bearer live_cntSF2RxdDCUK7wudptq2sVqRWHE3c";

    // initialize curl
    $ch = curl_init();

    $output_type = ( $type == 'GET' ) ? false : true; 
    
    // set other curl options
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: ' . $api_key]);
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    // get response
    $response = curl_exec( $ch );
    if ($response === false) {
        $response = curl_error($ch);
        $error = true;
        echo stripslashes($response);
        return false;
    }

    // close curl
    curl_close( $ch );

    // return data
    return json_decode( $response, true );
}

function makeApiCallWoocommerce($url, $type, $data = null) {
    // credentials
    $params = array( // 
        'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
        'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    );
    //create endpoint with params
    $endpoint = $url . '?' . http_build_query( $params );

    // initialize curl
    $ch = curl_init();

    $output_type = ( $type == 'GET' ) ? false : true; 
    
    // set other curl options
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, $output_type);
    if($output_type)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    // get response
    $response = curl_exec( $ch );
    // var_dump($response);

    if ($response === false) {
        $response = curl_error($ch);
        $error = true;
        // return stripslashes($response);
        return false;
    }

    // close curl
    curl_close( $ch );

    $datum = json_decode( $response, true );

    // return data
    return $datum;


}

function woocommmerce_subscribe_api($information, $active){
    $global_product_id = 9873;
    $global_price = 5;

    /** Requirement information */
    $user_id = get_current_user_id();
    $company_title = get_field('company',  'user_' . $user_id)[0]->post_title;
    $users = get_users();
    $members = array();
    foreach($users as $user){
        $company_value = get_field('company',  'user_' . $user->ID);
        if(!empty($company_value)){
            $company_value_title = $company_value[0]->post_title;
            if($company_value_title == $company_title)
                array_push($members, $user);
        }
    }
    $team = count($members);

    if($information['is_trial']){
        $date_now = date('Y-m-d H:i:s');
        $date_now_timestamp = strtotime($date_now);
        $trial_end_date = date("Y-m-d H:i:s", strtotime("+ 14 days" , $date_now_timestamp));
        $next_payment_date = date("Y-m-d H:i:s", strtotime("+1 month" , strtotime($trial_end_date)));
    }else{
        $date_now = date('Y-m-d H:i:s');
        $trial_end_date = $date_now;
        $date_now_timestamp = strtotime($date_now);
        $next_payment_date = date("Y-m-d H:i:s", strtotime("+1 month" , $date_now_timestamp));
    }

    if($active)
       $active = 'active';
    else
        $active = 'on-hold'; 

    /*
    ** Create subscription
    */ 
    $data = [
        'customer_id'       => $user_id,
        'status'            => $active,
        'billing_period'    => 'month',
        'billing_interval'  =>  1,
        'start_date'        => $date_now,
        // 'trial_end_date'    => $trial_end_date,
        'next_payment_date' => $next_payment_date,
        'payment_method'    => 'mollie',
        'prices_include_tax'=> true,
        'billing' => [
            'first_name' => $information['first_name'],
            'last_name'  => $information['last_name'],
            'company'    => $company_title,
            'address_1'  => $information['factuur_address'],
            'address_2'  => '',
            'city'     => '', 
            'state'    => 'DR-NL',
            'postcode' => '1011',
            'country'  => 'NL',
            'email'    => $information['email'],
            'phone'    => $information['phone'],
        ],
        'shipping' => [],
        'line_items' => [
            [
                'product_id' => $global_product_id,
                'quantity'   => $team,
            ],
        ],
        'shipping_lines' => [],
        'meta_data' => [],
    ];

    // $subscription = $woocommerce->post('subscriptions', $data);
    $endpoint = "https://livelearn.nl/wp-json/wc/v3/subscriptions/";
    $subscription = makeApiCallWoocommerce($endpoint, 'POST', $data);
    $subscription = (Object)$subscription;

    if($subscription)
        return $subscription;

    echo "<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Something went wrong, please try later !</a></center>";
    http_response_code(500);
    return 0;
}