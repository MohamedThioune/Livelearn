<?php
function crontab_podcast( ) {
    global $wpdb;
    $args = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'ordevalue' => 'podcast',
        'order' => 'DESC' ,
        'meta_key'   => 'course_type',
        'meta_value' => "podcast"
    );
    //good keys from daniel account
    // $apiKey = 'UQ9BK94AUNCCNCVVFRTZ';
    // $apiSecret = 'teMYqdrBgamSWpVnd7q4WABSBBZz3j$^uVSWwHuH';

    //key from my own account khadim1.niass@ucad.edu.sn
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

    $podcasts = get_posts($args);
    $all_title_of_podcast_in_plateform = array();
    foreach ($podcasts as $key => $course) {
        # podcast index ?
        $podcast_index = get_field('podcasts_index', $course->ID);
        if (!$podcast_index)
            continue;
        foreach ($podcast_index as $key => $podcast) {
            $title = $podcast['podcast_title'];
            $all_title_of_podcast_in_plateform [] = $title;
        }
    }
    foreach ($podcasts as $course) {
        # podcast index ?
        $podcast_index = get_field('podcasts_index', $course->ID);
        if(!$podcast_index)
            continue;
        //Reach podcasts and add new lesson
        $sql = $wpdb->prepare("SELECT course_id FROM {$wpdb->prefix}databank WHERE {$wpdb->prefix}databank.titel ="."'$course->post_title'");
        $feedid = $wpdb->get_results($sql)[0]->course_id;
        if ($feedid==null)
            continue;

        $url = 'https://api.podcastindex.org/api/1.0/podcasts/byfeedid?id='.$feedid;
        //$url = "https://api.podcastindex.org/api/1.0/search/bytitle?q=$course->post_title";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to disable secure of open ssl
        $response = curl_exec ($ch);
        curl_close ($ch);
        $data = (json_decode($response,TRUE));

        $url_to_get_audio = $data['feed']['url'];
        //$url_to_get_audio = "https://feeds.buzzsprout.com/2145970.rss"; //fixer cette valeur pour débuguer
        $xml = simplexml_load_file($url_to_get_audio);

        $podcasts_playlists = [];
        foreach($xml->channel[0] as $key => $pod) {
            if($pod->enclosure->attributes()->url) {

                $description_podcast = (string)$pod->description;
                $title_podcast = (string)$pod->title;
                $mp3 = $pod->enclosure->attributes()->url;
                $date =(string)$pod->pubDate;
                $image_audio = (string)$pod->children('itunes', true)->image->attributes()->href;
                if (in_array($title_podcast,$all_title_of_podcast_in_plateform))
                    continue;

                $podcasts_playlist = [];

                $podcasts_playlist['podcast_url'] = $mp3;
                $podcasts_playlist['podcast_title'] = $title_podcast;
                $podcasts_playlist['podcast_description'] = $description_podcast;
                $podcasts_playlist['podcast_date'] = $date;
                $podcasts_playlist['podcast_image'] = $image_audio;

                $podcasts_playlists [] = $podcasts_playlist;
            }
        }
        if(!empty($podcasts_playlists))
            update_field('podcasts_index', $podcasts_playlists, $course->ID);
    }
}
