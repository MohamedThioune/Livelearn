<?php /** Template Name: active abonnement */ ?>

<?php
extract($_GET);


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
$data = [ 'status' => 'active' ];

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
if (!isset($data_response['id'])) 
    echo "<center><br><a class='btn btn-success' style='background : #E10F51; color : white' href='#'>Something went wrong, please try later !</a></center>";
else
    echo "<center><br><a class='btn btndoawnloadCv' href=''>Abonnementen succesvol gedaan !</a></center>";   


// close curl
curl_close( $ch );

?> <span></span>