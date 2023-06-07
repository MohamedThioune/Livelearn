<?php /** Template Name: audio api */ ?>
<?php // /audio-api ?>
<?php
extract($_POST);
if ($audio_search){
    $apiKey = 'UQ9BK94AUNCCNCVVFRTZ';
    $apiSecret = 'teMYqdrBgamSWpVnd7q4WABSBBZz3j$^uVSWwHuH';
    $apiUrl = 'https://api.podcastindex.org/api/1.0/search';
    $apiHeaderTime = time();

    $params = [
        'q' => $audio_search,
        'api_key' => $apiKey,
        'api_secret' => $apiSecret
    ];
    // request of search
    $url = $apiUrl . '?' . http_build_query($params);
    // make the request HTTP GET
    $response = file_get_contents($url);
    if ($response==false){
        $error = error_get_last();
        var_dump($error);
        die('Erreur lors de la requête API');
    }
    var_dump($url,$response);


    /*
    //Hash them to get the Authorization token
    $hash = sha1($apiKey.$apiSecret.$apiHeaderTime);

//Set the required headers
    $headers = [
        "User-Agent: SuperPodcastPlayer/1.3",
        "X-Auth-Key: $apiKey",
        "X-Auth-Date: $apiHeaderTime",
        "Authorization: $hash"
    ];
    //var_dump($headers);
    //Make the request to an API endpoint
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://api.podcastindex.org/api/1.0/search/byterm?q=$audio_search");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//Collect and show the results
    $response = curl_exec ($ch);
    if (!$response)
        var_dump(error_get_last());
    curl_close ($ch);
    */
}
