<?php


function updateYoutube(){
    $api_key = "AIzaSyB0J1q8-LdT0994UBb6Q35Ff5ObY-Kqi_0";
    $maxResults = 45;

    $args = array(
        'post_type' => array('course','post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'ordevalue' => 'video',
        'order' => 'DESC' ,
        'meta_key'   => 'course_type',
        'meta_value' => "video"
    );
    $videos  = get_posts($args);
    foreach ($videos as  $course){
        $youtube_playlists = get_field('youtube_videos',$course->ID);
        if (!$youtube_playlists)
            continue;

        $id_playlist = get_field('origin_id',$course->ID);

        if (!$id_playlist)
            continue;

        $ids_video = array();
        $correct_videos = array();
        foreach($youtube_playlists as $youtube_playlist) {
            $ids_video [] = $youtube_playlist['id'];
            if ($youtube_playlist['id'])
                $correct_videos [] = $youtube_playlist;

        }
        $url_playlist = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $id_playlist . "&maxResults=" . $maxResults . "&key=" . $api_key;
        $detail_playlist = json_decode(file_get_contents($url_playlist, true));

        $new_episods = array();
        foreach ($detail_playlist->items as $video){
            $episodes_to_adds = [];
            if (in_array($video->snippet->resourceId->videoId,$ids_video))
                continue;

            $episodes_to_adds['id'] = $video->snippet->resourceId->videoId;
            $episodes_to_adds['title'] = $video->snippet->title;
            $episodes_to_adds['thumbnail_url'] = $video->snippet->thumbnails->high->url;

            $new_episods [] = $episodes_to_adds;
        }

        if (!$new_episods)
            continue;

        $all_videos = array_merge($correct_videos , $new_episods);
        $number_of_episodes = count($new_episods);
        update_field('youtube_videos',null,$course->ID);
        update_field('youtube_videos',$all_videos,$course->ID);
        echo "<h1 class='textOpleidRight'> $number_of_episodes episodes are added in the course : $course->ID  </h1>";
    }
}

/**
 * @return void
 * @link https://livelearn.nl/wp-json/custom/v1/clean-video/?key=73
 */
function cleanVideoCourse(){
    // $args = array(
    //     'post_type' => array('course'),
    //     'post_status' => 'publish',
    //     'posts_per_page' => -1,
    //     'ordevalue' => 'video',
    //     'order' => 'DESC' ,
    //     'meta_key' => 'course_type',
    //     'meta_value' => "video"
    // );
    // $videos  = get_posts($args);
    $args = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC'
    );

    $global_posts = get_posts($args);
    $videos = searching_course_by_type($global_posts, 'Video')['courses'];

    $count = count($videos);
    $step = 30;

    // var_dump($count);

    $number_iteration = intval(ceil($count / $step));
    //$number_iteration = $count%$step == 0 ? $number_iteration : $number_iteration + 1;
    echo  "<h1 class='textOpleidRight text-center alert alert-success'>the number of iteration are [ 1 to => $number_iteration ]</h1>";
    $key = 1;
    if (isset($_GET['key'])) {
        if ( intval($_GET['key'])) {
            $key = intval($_GET['key']);
            if ($key > $number_iteration) {
                echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must not depass $number_iteration </h1>";
                return;
            }
        }else{
            echo "<h1 class='textOpleidRight text-center alert alert-danger'>the key is not valid, key must be a number </h1>";
            return;
        }
    }

    $star_index = ($key - 1) * $step;

    for ($i = $star_index; $i < $star_index + $step && $i < $count ; $i++) {
        $course = $videos[$i];
        $correct_videos = array();
        $youtube_playlists = get_field('youtube_videos', $course->ID);
        if (!$youtube_playlists)
            continue;

        foreach ($youtube_playlists as $youtube_playlist)
            if ($youtube_playlist['id'] && $youtube_playlist['title'] && $youtube_playlist['thumbnail_url'])
                $correct_videos [] = $youtube_playlist;

        update_field('youtube_videos', null, $course->ID);
        update_field('youtube_videos', $correct_videos, $course->ID);
        echo "<h3 class='textOpleidRight'>the course  $course->ID is updating...</h3>";
    }
}
