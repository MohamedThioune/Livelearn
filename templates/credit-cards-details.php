<?php /** Template Name: cards credit details payment */ ?>

<?php extract($_POST); ?>

<?php
// Api key mollie
$api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";

//Current company
$company_title = get_field('company',  'user_' . $user_id)[0]->post_title;

//Team members
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
 
//create endpoint for product 
$endpoint_product = 'https://livelearn.nl/wp-json/wc/v3/products';
$params = array( 
    'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
    'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
);
//endpoint with params
$api_endpoint = $endpoint_product . '?' . http_build_query( $params );
$data = [
    'name' => $company_title . "~subscription",
    'type' => 'simple',
    'regular_price' => '5.00',
    'description' => 'No short description',
    'short_description' => 'No long description',
    'virtual' => true,
    'categories' => [],
    'images' => []
];
// initialize curl
$chp = curl_init();
// set other curl options product
curl_setopt($chp, CURLOPT_URL, $api_endpoint);
curl_setopt($chp, CURLOPT_POST, true);
curl_setopt($chp, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($chp, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chp, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($chp, CURLOPT_RETURNTRANSFER, true );
$httpCode = curl_getinfo($chp , CURLINFO_HTTP_CODE); // this results 0 every time

// get responses
$response_product = curl_exec($chp);
if($response_product === false) {
    $response_product = curl_error($chp);
    $error = true;
    $message = "Something went wrong !";
}
else{
    // close curl
    curl_close( $chp );

    // get product_id
    $data_response_product = json_decode( $response_product, true );
    $product_id = $data_response_product['id'];

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

    /*
    ** Create subscription
    */ 
    $endpoint = 'https://livelearn.nl/wp-json/wc/v3/subscriptions';
    $params = array( // login url params required to direct user to facebook and promt them with a login dialog
        'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
        'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    );
    //create endpoint with params
    $api_endpoint = $endpoint . '?' . http_build_query( $params );
    $data = [
        'customer_id'       => $user_id,
        'status'            => 'on-hold',
        'billing_period'    => 'month',
        'billing_interval'  =>  1,
        'start_date'        => $date_now,
        'trial_end_date'    => $trial_end_date,
        'next_payment_date' => $next_payment_date,
        'payment_method'    => 'mollie',
        'billing' => [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'company'    => $company_title,
            'address_1'  => $factuur_address,
            'address_2'  => '',
            'city'     => '', //place
            'state'    => 'DR-NL',
            'postcode' => '1011',
            'country'  => 'NL',
            'email'    => $email,
            'phone'    => $phone,
        ],
        'shipping' => [],
        'line_items' => [
            [
                'product_id' => $product_id,
                'quantity'   => $team
            ],
        ],
        'shipping_lines' => [],
        'meta_data' => [],
    ];
    // initialize curl
    $ch = curl_init();
    // set other curl options product
    curl_setopt($ch, CURLOPT_URL, $api_endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // get responses
    $response = curl_exec($ch);
    $data_response = json_decode( $response, true );
    // var_dump($response);

    // close curl
    curl_close( $ch );
    if (!isset($data_response['id'])) {
        echo "<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Something went wrong, please try later !</a></center>";
        http_response_code(500);
    }
    else
    {
        $woo_subscription_id = $data_response['id'];
        //Create the customer 
        $endpoint_pay = "https://api.mollie.com/v2/customers";
        $api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";
        $data_customer = [
            'name' => $first_name . ' ' . $last_name,
            'email' => $email,
            'metadata' => [
                'user_id' => $user_id,
            ]
        ];
        // initialize curl
        $ch = curl_init();
        // set other curl options customer
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: ' . $api_key]);
        curl_setopt($ch, CURLOPT_URL, $endpoint_pay);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data_customer));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE);
        $response = curl_exec($ch);
        $data_response = json_decode( $response, true );

        // close curl
        curl_close( $ch );
        if (!isset($data_response['id'])) {
            echo "<center><br><a class='btn btn-default' style='background : #E10F51; color : white' href='#'>Something went wrong, please try again later !</a></center>";
            http_response_code(401);
        }
        else{
            //Get customer id & save
            $customer_id = $data_response['id'];
            update_field('cst_id', $customer_id, 'user_' . $user_id);

            // Create your payments
            $endpoint_pay = "https://api.mollie.com/v2/customers/" . $customer_id . "/payments";
            $api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";
            $base_url = "http://localhost:8888/local";
            $data_payment = [
                'method' => 'creditcard',
                'amount' => [
                    'currency' => 'EUR',
                    'value' => "0.01",
                ],
                'description' => 'First payment - ' . $first_name,
                'sequenceType' => 'first',
                'redirectUrl' => $base_url . '/cards-payment',
                'webhookUrl' => 'https://webshop.example.org/payments/webhook/',
                'metadata' => [
                    'customer_id' => $customer_id,
                    'woo_subscription_id' => $customer_id,
                ]
            ];
            // initialize curl
            $chpay = curl_init();
            // set other curl options customer
            curl_setopt($chpay, CURLOPT_HTTPHEADER, ['Authorization: ' . $api_key]);
            curl_setopt($chpay, CURLOPT_URL, $endpoint_pay);
            curl_setopt($chpay, CURLOPT_POST, true);
            curl_setopt($chpay, CURLOPT_POSTFIELDS, http_build_query($data_payment));
            curl_setopt($chpay, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chpay, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($chpay, CURLOPT_RETURNTRANSFER, true );
            $httpCode = curl_getinfo($chpay , CURLINFO_HTTP_CODE);
            $response_pay = curl_exec($chpay);
            $data_response_pay = json_decode( $response_pay, true );
            // close curl
            curl_close( $chpay ); 
            
            if (!isset($data_response_pay['_links']['checkout']['href'])) {
                echo "<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Error occurred on transaction !</a></center>";
                http_response_code(401);
            }
            else{
                //Update mandate id straightly
                echo $data_response_pay['_links']['checkout']['href'];
            }
        }
    }
}

?>
