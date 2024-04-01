<?php

function detectLanguage($text)
 {

    
 $data = [
    'q' => $text,
];


$dataString = http_build_query($data);

$headers = [
    'content-type: application/x-www-form-urlencoded',
    'Accept-Encoding: application/gzip',
    'X-RapidAPI-Key: 9def8024e2mshe1eaef1df9acceap161c95jsne1ba92e2482d',
    'X-RapidAPI-Host: google-translate1.p.rapidapi.com'
];

$url = 'https://google-translate1.p.rapidapi.com/language/translate/v2/detect';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false) {
     $language= 'Erreur cURL : ' . curl_error($ch);
} else {
  $data = json_decode($response, true);
  $language=$data["data"]["detections"][0][0]["language"];
}



  return $language;
  

   

 }

 
  
  ?>
