<?php /** Template Name: cards payment */ ?>£

<?php wp_head(); ?>
<?php get_header(); ?>

<?php
// Mollie API client for php //
// $global_mollie_key = "test_SFMrurF62JkBVuzK9gxa3b72eJQhxu";
// $global_price = 5;
// $mollie = new \Mollie\Api\MollieApiClient();
// $mollie->setApiKey($global_mollie_key);

//Team members
$user_id = get_current_user_id();
$bedrjifsnaam = get_field('company',  'user_' . $user_id);
$users = get_users();
$team = 0;
foreach($users as $user){
    $company_value = get_field('company',  'user_' . $user->ID);
    if(!empty($company_value)){
        $company_value_title = $company_value[0]->post_title;
        if($company_value_title == $bedrjifsnaam[0]->post_title)
            $team += 1;
    }
}

$customer_id = get_field('mollie_customer_id', 'user_' . $user_id);
if(!$customer_id)
    header("Location: /dashboard/company/profile-company/?message=Error occured on process, please try again later !" );    

$amount_pay = $global_price * $team;
$amount_pay_vat = $amount_pay + ($amount_pay * 20/100); 
$amount_pay_vat = strval(number_format($amount_pay_vat, 2, '.', ','));

$data_payment = [
    'amount' => [
        'currency' => 'EUR',
        'value' => $amount_pay_vat,
    ],
    'description' => 'Monthly payment °' . mt_rand(1000000000, 9999999999),
    'webhookUrl' => 'https://webshop.example.org/payments/webhook/',
    'interval' => '1 day',
    'metadata' => [
        'user_id' => $user_id,
        'company' => $bedrjifsnaam[0]->post_title,
        'quantity' => $team
    ]
];
$subscription = $mollie->customers->get($customer_id)->createSubscription($data_payment);
if(!empty($subscription))
    if($subscription->status == "active")
        header("Location: /dashboard/company/confirmation/?message=Subscription create succesfully !" );
    else
        header("Location: /dashboard/company/profile-company/?message=Something went wrong !" );     
else 
    header("Location: /dashboard/company/profile-company/?message=Error occured on transaction !" );    

?>

<?php get_footer(); ?>
<?php wp_footer(); ?>