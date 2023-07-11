<?php /** Template Name: audio api */ ?>
<?php // /audio-api ?>
<?php
global $wpdb;

$table = $wpdb->prefix . 'databank';

//good keys from daniel account
//$apiKey = 'UQ9BK94AUNCCNCVVFRTZ';
//$apiSecret = 'teMYqdrBgamSWpVnd7q4WABSBBZz3j$^uVSWwHuH';

//key from my own account
$apiKey = 'XV4FMX6HDE3SECBVMEF3';
$apiSecret = '7Vr5rRxJyZ6^$TnhftLddbJKB6yNmXyYRcBx7T^Z';
$time = time();
$hash = sha1($apiKey.$apiSecret.$time);
$headers = [
    "User-Agent: LivelearPodcast",
    "X-Auth-Key: $apiKey",
    "X-Auth-Date: $time",
    "Authorization: $hash"
];

extract($_POST);
//var_dump($_POST);
$staticImg = get_stylesheet_directory_uri() . '/img/Image-79.png';
if ($audio_search){

    $url = 'https://api.podcastindex.org/api/1.0/search/byperson?q=' .$audio_search;
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
        $description = substr($description, 0, 30);
        $image = $item['image'];
        $audio = $item['enclosureUrl'];
        //$audio = $item['guid'];
        echo "
            <div class='card mb-3'>
                  <div class='row g-0'>
                    <div class='col-md-4'>
                      <img src='".$image."' class='img-fluid rounded-start' alt='".$title."'>
                    </div>
                    
                    <div class='col-md-8'>
                      <div class='card-body'>
                        <h5 class='card-title'>$title</h5>
                        <p class='card-text'>$description</p>
                        <audio controls>
                            <source src= '".$audio."' type='audio/mpeg'>
                        </audio>
                        </div>
                    </div>
                    
                  </div>
            </div>
            ";
    }
  } elseif ($audio_search_playlist)
{
    $url = 'https://api.podcastindex.org/api/1.0/search/byterm?q=' .$audio_search_playlist;
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to disable secure of open ssl
        $response = curl_exec ($ch);
    curl_close ($ch);
    $data = (json_decode($response,TRUE));
    if ($data['status'] === "true") {
        extract($data);
        // $feeds = $data['feeds'];
        $count = 0;
        $result = [];
        foreach($feeds as $key => $feed){
            $id = $feed['id'];
            $title = $feed['title'];
            $url = $feed['url'];
            $image = $feed['image'];
            $originalUrl = $feed['originalUrl'];
            $link = $feed['link'];
            $description = $feed['description'];
            $author = $feed['author'];
            $ownerName = $feed['ownerName'];
            $artwork = $feed['artwork'];
            $lastCrawlTime = $feed['lastCrawlTime'];
            $lastParseTime = $feed['lastParseTime'];
            $lastGoodHttpStatusTime = $feed['lastGoodHttpStatusTime'];
            $lastHttpStatus = $feed['lastHttpStatus'];
            $contentType = $feed['contentType'];
            $itunesId = $feed['itunesId'];
            $generator = $feed['generator'];
            $language = $feed['language'];
            $type = $feed['type'];
            $dead = $feed['dead'];
            $categories = $feed['categories'];
            echo "
            <div class='card mb-3'>
                  <div class='row g-0'>
                    <div class='col-md-4'>
                      <img src='".$image."' class='img-fluid rounded-start' alt='".$title."'>
                    </div>
                    
                    <div class='col-md-8'>
                      <div class='card-body'>
                        <h5 class='card-title'>$title</h5>
                        <p class='card-text'>$description</p>
                        ";
                            foreach ($categories as $category)
                                echo "<button class = 'btn btn-info m-1' disabled >$category</button>";
                         echo"
                        <br>
                          <button class='mt-4 play btn btn-outline-success' data-categories='". json_encode($categories) ."' data-language='".$language."' data-author ='".$author."' data-title='".$title."' data-image='".$image."' data-description='".$description."' data-url='".$url."' data-id='".$id."' onclick='savePodcastPlaylistInPlatform(event)'>
                            SAVE
                        </button>
                            <div class='d-none'>
                                <div class='spinner-grow m-1' style='width: 0.5rem; height: 0.6rem;' role='alert'>
                                    <span class='sr-only'>Loading...</span>
                                </div>
                                <div class='spinner-grow m-1' style='width: 0.4rem; height: 0.6rem;' role='alert'>
                                    <span class='sr-only'>Loading...</span>
                                </div>
                                <div class='spinner-grow m-1' style='width: 0.3rem; height: 0.6rem;' role='alert'>
                                    <span class='sr-only'>Loading...</span>
                                </div>
                            </div>
                      </div>
                    </div>
                  </div>
                  <div class='row'>
                        <div class='col-9'>
                              <a class='' href = '".$url."' target='_blank'>link api</a><br>
                              <a class='' href = '".$link."' target='_blank'>web site company</a><br>
                        </div>
                        <div class='col-3'>
                            <img src='".$staticImg."' width='20px' height='20px'>
                            <span class='h6'>$author</span>
                        </div>
                  </div>
            </div>
        ";
        }
    }
}elseif ($playlist_audio){
    $user_connected = wp_get_current_user();
    $user_id = (isset($user_connected->ID)) ? $user_connected->ID : 0;
    $message = "";
    extract($playlist_audio);
    //var_dump($categories);
    $cat = json_decode($categories[0],true);

    $sql = $wpdb->prepare( "SELECT course_id FROM $table  WHERE course_id = $id");
    $isCourseInPlateform = $wpdb->get_results( $sql)[0]->course_id;
    if ($isCourseInPlateform) {
        $message = "$title is already saved in platform ❌❌❌";
    }else{
        $xml = simplexml_load_file($url);
        $podcasts="";
        //var_dump($xml->channel[0]);
        foreach($xml->channel[0] as $key => $pod) {
            if($pod->enclosure->attributes()->url) {
                //$description_podcast = (string)$pod->description;
                $title_podcast = (string)$pod->title;
                $mp3 = $pod->enclosure->attributes()->url;
                $podcasts .= "$mp3~$title_podcast|";
            }
        }
        //var_dump($podcasts);die();
        //echo "<br>nember caracters : ".strlen($podcasts);
        //echo "<br>nember caracters : ".strlen(strip_tags($podcasts));

        //wich table will I do the request to show the list of podcast ?
        $data = array(
            'titel' => $title,
            'type' => 'Podcast',
            'podcasts' => substr($podcasts,0,-1), //remove the last char | before saving
            //'podcasts' => strip_tags($podcasts),
            'short_description' => $description,
            'long_description' => $description,
            'duration' => null,
            'prijs' => 0,
            'prijs_vat' => 0,
            'image_xml' => $image,
            'onderwerpen' => null, //tableau $categories
            'date_multiple' => null,
            'course_id' => $id,
            'author_id' => $user_id,
            'status' => 'extern'
        );
        $wpdb->insert($table, $data);
        $post_id = $wpdb->insert_id;
        if ($post_id) {
            $message = "$title saved in platform success ✅✅✅";
        }
    }
    echo $message;
}
