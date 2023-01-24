<?php /** Template Name: starter abonnement */ ?>

<?php
extract($_POST);

//Current user
$user_id = get_current_user_id();

//Team members
$users = get_users();
$members = array();
foreach($users as $user){
    $company_value = get_field('company',  'user_' . $user->ID);
    if(!empty($company_value)){
        $company_value_title = $company_value[0]->post_title;
        if($company_value_title == $bedrjifsnaam)
            array_push($members, $user);
    }
}
$team = count($members);

//endpoint for product 
$endpoint_product = 'https://livelearn.nl/wp-json/wc/v3/products';
$params = array( 
    'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
    'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
);
//create endpoint with params
$api_endpoint = $endpoint_product . '?' . http_build_query( $params );
$data = [
    'name' => $bedrjifsnaam ."~subscription",
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
        'status'            => 'active',
        'billing_period'    => 'month',
        'billing_interval'  =>  1,
        'start_date'        => $date_now,
        'trial_end_date'    => $trial_end_date,
        'next_payment_date' => $next_payment_date,
        'payment_method'    => '',
        
        'billing' => [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'company'    => $bedrjifsnaam,
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
    $pass_payment = false;
    /*
    ** Pass payment
    */
    if($method_payment == 'credit_card')
    {
        $amount_pay = 5 * $team;
        $amount_pay = number_format($amount_pay, 2, '.', ',');
        $endpoint_pay = "https://api.mollie.com/v2/payments";
        $api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";
        $data_payment = [
            'method' => 'creditcard',
            'amount' => [
                'currency' => 'EUR',
                'value' => $amount_pay,
            ],
            'description' => 'Product #' . $product_id,
            'redirectUrl' => 'https://webshop.example.org/order/12345/',
            'webhookUrl' => 'https://webshop.example.org/payments/webhook/',
            'cardToken' => $card_token,
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
        $response_pay = curl_exec($chpay);
        // var_dump( $response_pay );
        if(isset($data_response_pay['id']))
            $pass_payment = true;      
        // close curl
        curl_close( $chpay );      
    }
    else
        $pass_payment = true;
    /*
    ** 
    */

    if(!$pass_payment)
        $data['status'] = 'on-hold';
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // get responses
    $response = curl_exec($ch);
    $data_response = json_decode( $response, true );
    if (!isset($data_response['id'])) {
        //$response = curl_error($ch);
        //$error = true;
        //$message = "Something went wrong !";
        //echo stripslashes($response);
        echo "<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Something went wrong, please try later !</a></center>";
    }
    else{
        //$message = "Subscription applied succesfully !";
        //$abonnement_id = $data_response['id']; 
        echo "<center><br><a class='btn btndoawnloadCv' href='#'>Zie het overzicht van mijn abonnementen </a></center>";   
    }
}

// close curl
curl_close( $ch );

?>