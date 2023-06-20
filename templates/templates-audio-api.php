<?php /** Template Name: audio api */ ?>
<?php // /audio-api ?>
<?php
extract($_POST);
if ($audio_search){

   //good keys from daniel account
    //$apiKey = 'UQ9BK94AUNCCNCVVFRTZ';
    //$apiSecret = 'teMYqdrBgamSWpVnd7q4WABSBBZz3j$^uVSWwHuH';

    //key from my own account
    $apiKey = 'XV4FMX6HDE3SECBVMEF3';
    $apiSecret = '7Vr5rRxJyZ6^$TnhftLddbJKB6yNmXyYRcBx7T^Z';

    // $url = 'https://api.podcastindex.org/api/1.0/search/byterm?q=' .$audio_search;
    $url = 'https://api.podcastindex.org/api/1.0/search/byperson?q=' .$audio_search;
    $time = time();
    $hash = sha1($apiKey.$apiSecret.$time);
    $headers = [
        "User-Agent: LivelearPodcast",
        "X-Auth-Key: $apiKey",
        "X-Auth-Date: $time",
        "Authorization: $hash"
    ];
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to disable secure of open ssl
        $response = curl_exec ($ch);
    curl_close ($ch);
    $data = (json_decode($response,TRUE));
    $items = $data['items'];
    foreach ($data['items'] as $item) {
        $title = $item['title'];
        $description = $item['description'];
        $image = $item['image'];
        $audio = $item['enclosureUrl'];
        //$audio = $item['guid'];
        echo "
                    <div class='col-md-6>
                       <div class='card'>
                       <img src='".$image."'  class='card-img-top' alt= '".$title."'>
                           <div class='card-body'>
                                  <h5 class='card-title'> $title </h5>
                                  <p class='card-text'> $description</p>
                                  <audio controls>
                                        <source src= '".$audio."' type='audio/mpeg'>
                                  </audio>
                           </div>
                       </div>
                    </div>
                    
               ";
    }
  }
