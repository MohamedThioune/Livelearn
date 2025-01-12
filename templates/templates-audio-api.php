<?php /** Template Name: audio api */ ?>
<?php // /audio-api ?>
<?php
global $wpdb;

$table = $wpdb->prefix . 'databank';
$users = get_users();
$args = array(
    'post_type' => 'company',
    'posts_per_page' => -1,
);
// var_dump($selectedValues);
$companies = get_posts($args);

//good keys from daniel account
$apiKey = 'UQ9BK94AUNCCNCVVFRTZ';
$apiSecret = 'teMYqdrBgamSWpVnd7q4WABSBBZz3j$^uVSWwHuH';

//key from my own account khadim1.niass@ucad.edu.sn
//$apiKey = 'XV4FMX6HDE3SECBVMEF3';
//$apiSecret = '7Vr5rRxJyZ6^$TnhftLddbJKB6yNmXyYRcBx7T^Z';

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
    //$url = 'https://api.podcastindex.org/api/1.0/search/byperson?q=' .$audio_search;
    $url = 'https://api.podcastindex.org/api/1.0/search/bytitle?q=' .$audio_search;
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
        //var_dump($data);
        /*if (!$feeds){
            echo "<h3>$description for '$query'</h3>";
            return;
        }*/
        /**
         * start display resutl of search
         */

        foreach($feeds as $key => $feed){
            //extract($feed);
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
            $category_to_insert="";
            if ($categories){
                foreach ($categories as $cat){
                    $category_to_insert.=$cat.",";
                }
                $category_to_insert = substr($category_to_insert, 0, -1);
            }

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
                          <button class='mt-4 play btn btn-outline-success' data-categories='". $category_to_insert. "' data-language='".$language."' data-author ='".$author."' data-title='".$title."' data-image='".$image."' data-description='".$description."' data-url='".$url."' data-id='".$id."' onclick='savePodcastPlaylistInPlatform(event)'>
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
                  <h3 class='m-lg-3'>$language</h3>
            </div>
        ";
        }
        /**
         * end display resutl of search
         */
    }

}elseif ($playlist_audio){
    $user_connected = wp_get_current_user();// id user connected
    $user_id = (isset($user_connected->ID)) ? $user_connected->ID : 0;
    $company_id = 0;
        foreach ($users as $user) {
            $company_user = get_field('company', 'user_' . $user->ID);
            if ($user_connected) {
                if ($user_id == $user->ID ) {
                    $company = $company_user[0];
                    $company_id = $company_user[0]->ID;
                }
            }
        }

    $message = "";
    extract($playlist_audio);
    $cat = json_decode($categories[0],true);

    $sql = $wpdb->prepare( "SELECT course_id FROM $table  WHERE course_id = $id");
    $isCourseInPlateform = $wpdb->get_results( $sql)[0]->course_id;
    if ($isCourseInPlateform) {
        $message = "$title is already saved in platform ❌❌❌";
        echo $message;
        return;
    }else{
        $podcasts="";
        $content_podcasts = array();
        $xml = simplexml_load_file($url);
        if($xml) {
            $content_podcasts = $xml->channel[0];
        } else {
            $ch2 = curl_init();
            curl_setopt($ch2, CURLOPT_URL, $url);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            $content = curl_exec($ch2);
            curl_close($ch2);
            $content_podcasts = $content;
        }
        $i=0;
        foreach ($content_podcasts as $key => $pod)
            if ($pod->enclosure->attributes()->url) {
                $i++;
                $description_podcast = (string)$pod->description;
                $title_podcast = (string)$pod->title;
                $mp3 = $pod->enclosure->attributes()->url;
                $date =(string)$pod->pubDate;
                $image_audio = (string)$pod->children('itunes', true)->image->attributes()->href;

                $podcasts .= "$mp3~$title_podcast~$description_podcast~$date~$image_audio^";
                if ($i==100)
                    break;
            }

        $data = array(
            //'titel' => htmlentities($title,ENT_NOQUOTES),
            'titel' => $title,
            'type' => 'Podcast',
            'podcasts' => substr($podcasts,0,-1), //remove the last char | before saving
            'short_description' => $description,
            'long_description' => $description,
            'duration' => null,
            'prijs' => 0,
            'prijs_vat' => 0,
            'image_xml' => $image,
            //'onderwerpen' => $categories, //tableau $categories //tableau $categories
            'onderwerpen' => null, //tableau $categories //tableau $categories
            'date_multiple' => null,
            'course_id' => $id,
            'author_id' => $user_id,
            'status' => 'extern',
            'company_id' => $company_id,
            'language'=>$language,
        );
        $wpdb->insert($table, $data);
        $post_id = $wpdb->insert_id;
        if ($post_id)
            $message = "$title saved in platform success ✅✅✅";
        else
            $message = $wpdb->last_error;
    }
    echo $message;
}
