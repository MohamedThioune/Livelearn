<?php /** Template Name: cards payment */ ?>£

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
$customer_id = "cst_SvDbwwQ4rK";
$amount_pay = 5 * $team;
$amount_pay = number_format($amount_pay, 2, '.', ',');
$endpoint_pay = "https://api.mollie.com/v2/customers/" . $customer_id . "/subscriptions";
$api_key = "Bearer test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3";

$data_payment = [
    'amount' => [
        'currency' => 'EUR',
        'value' => $amount_pay,
    ],
    'description' => 'Quaterly payment °' . mt_rand(1000000000, 9999999999),
    'webhookUrl' => 'https://webshop.example.org/payments/webhook/',
    'interval' => '1 month',
    'mandateId' => "mdt_fmK5yJqzG7",
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

if(isset($data_response_pay['id']))
    header("Location: /dashboard/company/profile-company/?message=Transaction applied successfully !" );    
else
    var_dump( $response_pay );       
// close curl
curl_close( $chpay );

