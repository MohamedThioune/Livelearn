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

function cleanVideoCourse(){
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

    $correct_videos = array();
    foreach ($videos as  $course) {
        $youtube_playlists = get_field('youtube_videos', $course->ID);
        if (!$youtube_playlists)
            continue;
        foreach ($youtube_playlists as $youtube_playlist) {
            if ($youtube_playlist['id'] && $youtube_playlist['title'] && $youtube_playlist['thumbnail_url'])
                $correct_videos [] = $youtube_playlist;
        }
        update_field('youtube_videos', null, $course->ID);
        update_field('youtube_videos', $correct_videos, $course->ID);
        echo "<h1 class='textOpleidRight'>the course  $course->ID is updating...</h1>";
    }
}