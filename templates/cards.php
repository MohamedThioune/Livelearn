<?php /** Template Name: cards payment */ ?>£

<?php wp_head(); ?>
<?php get_header(); ?>

<?php
//Current user
$user_id = get_current_user_id();
$bedrjifsnaam = get_field('company',  'user_' . $user_id);

//Team members
$users = get_users();
$members = array();
foreach($users as $user){
    $company_value = get_field('company',  'user_' . $user->ID);
    if(!empty($company_value)){
        $company_value_title = $company_value[0]->post_title;
        if($company_value_title == $bedrjifsnaam[0]->post_title)
            array_push($members, $user);
    }
}
$team = count($members);
?>

<?php
$customer_id = get_field('cst_id', 'user_' . $user_id);

$endpoint_pay = "https://api.mollie.com/v2/customers/" . $customer_id . "/mandates";
$api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";

// initialize curl
$chman = curl_init();

// set other curl options customer
curl_setopt($chman, CURLOPT_HTTPHEADER, ['Authorization: ' . $api_key]);
curl_setopt($chman, CURLOPT_URL, $endpoint_pay);
curl_setopt($chman, CURLOPT_POST, false);
curl_setopt($chman, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chman, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($chman, CURLOPT_RETURNTRANSFER, true );

$httpCode = curl_getinfo($chman , CURLINFO_HTTP_CODE);
$response_pay = curl_exec($chman);
$data_response_pay = json_decode( $response_pay, true );
$mandate_id = $data_response_pay['_embedded']['mandates'][0]['id'];
// close curl
curl_close( $chman );
?> 

<?php

$amount_pay = 5 * $team;
$amount_pay = number_format($amount_pay, 2, '.', ',');
$endpoint_pay = "https://api.mollie.com/v2/customers/" . $customer_id . "/subscriptions";
$api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";

$data_payment = [
    'amount' => [
        'currency' => 'EUR',
        'value' => $amount_pay,
    ],
    'description' => 'Monthly payment °' . mt_rand(1000000000, 9999999999),
    'webhookUrl' => 'https://webshop.example.org/payments/webhook/',
    'interval' => '1 month',
    'mandateId' => $mandate_id,
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
var_dump( $response_pay );

if(!isset($data_response_pay['status'])) 
    header("Location: /dashboard/company/profile-company/?message=Error occured on transaction !" );    
else if($data_response_pay['status'] != 'active')
    header("Location: /dashboard/company/profile-company/?message=Error occured on transaction !" );    
else
    header("Location: /dashboard/company/profile-company/?message=Transaction applied successfully !" );    
// close curl
curl_close( $chpay );
?>

<?php get_footer(); ?>
<?php wp_footer(); ?>