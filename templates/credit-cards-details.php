<?php /** Template Name: cards credit details payment */ ?>

<?php extract($_POST); ?>

<?php
$customer_id = "cst_SvDbwwQ4rK";
$endpoint_pay = "https://api.mollie.com/v2/payments";
$api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";
$base_url = "http://localhost:8888/local/";

$data_payment = [
    'method' => 'creditcard',
    'amount' => [
        'currency' => 'EUR',
        'value' => "0.01",
    ],
    'description' => 'First payment - ' . $first_name,
    'customerId' => $customer_id,
    'sequenceType' => 'first',
    'redirectUrl' => $base_url . '/cards-payment',
    'webhookUrl' => 'https://webshop.example.org/payments/webhook/',
    'metadata' => [
        'product_id' => $customer_id,
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

echo $data_response_pay['_links']['checkout']['href'];

// if(isset($data_response_pay['id']))
//     $pass_payment = true;      
// close curl
curl_close( $chpay );      
?>