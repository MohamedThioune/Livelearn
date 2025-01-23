<?php

function detectLanguage($text) {
  $curl = curl_init();

  $url = "https://whats-language.p.rapidapi.com/languagedetection/detecting?text=" . urlencode($text);

  curl_setopt_array($curl, [
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => [
          "x-rapidapi-host: whats-language.p.rapidapi.com",
          "x-rapidapi-key: 07a7f2b29cmshbce4b715d1960c6p1d98cbjsn46412055a8ba"
      ],
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => false
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
      return "Error: " . $err;
  } else {
      $responseArray = json_decode($response, true);
      return $responseArray['languages'][0];
  }
}

 
  
  ?>
