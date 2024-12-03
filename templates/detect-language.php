<?php
set_time_limit(300); 
function detectLanguage($text)
 {

    
 $data = [
    'q' => $text,
];


$dataString = http_build_query($data);

$headers = [
    'content-type: application/x-www-form-urlencoded',
    'Accept-Encoding: application/gzip',
    'X-RapidAPI-Key: 07a7f2b29cmshbce4b715d1960c6p1d98cbjsn46412055a8ba',
    'X-RapidAPI-Host: google-translate1.p.rapidapi.com'
];

$url = 'https://google-translate1.p.rapidapi.com/language/translate/v2/detect';


 $curl = curl_init($url);

    // Configuration des options cURL
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $dataString,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false
    ));

    // Exécuter la requête cURL
    $response = curl_exec($curl);

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

// $response = curl_exec($ch);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($response === false) {
     $language= 'Erreur cURL : ' . curl_error($curl);
} else {
  $data = json_decode($response, true);
  $language=$data["data"]["detections"][0][0]["language"];
}

 
 
return $language;
    

}

 
  
  ?>
