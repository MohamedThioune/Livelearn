<?php
function youtubeEndpoint()
{
    $api_key = "AIzaSyB0J1q8-LdT0994UBb6Q35Ff5ObY-Kqi_0";
    $maxResults = 45;
    global $wpdb;
    $table = $wpdb->prefix . 'databank';

    $users = get_users();
    $author_id = 0;

    $fileName = get_stylesheet_directory_uri() . "/files/Big-Youtube-list-Correct.csv";
    $file = fopen($fileName, 'r');
    if ($file) {
        $playlists_id = array();
        $keywords= array();
        while ($line = fgetcsv($file)) {
            // $line[line][row]
            $list_url = explode(';',$line[0])[2];
            if (explode(';',$line[0])[4] && explode(';',$line[0])[4]!='Expert name')
                $expert = explode(';',$line[0])[4];

            if (strtoupper(substr($list_url,0,2)) =='PL' ) // take only playlist, not single video
                $playlists_id[][$expert] = $list_url;

            $subtopics = explode(';',$line[0])[6];
            array_push($keywords,$subtopics);
        }
        fclose($file);
        array_shift($keywords); //remove the tittle of row
    }else {
        echo "<span class='text-center alert alert-danger'>not possible to read the file</span>";
    }
    //array_shift($playlists_id);
    if($playlists_id || !empty($playlists_id)){
        foreach($playlists_id as $key=>$playlist_id){
            $id_playlist = array_values($playlist_id);
            $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?order=date&part=snippet&id=" . $id_playlist[0] . "&key=" . $api_key;
            $playlists = json_decode(file_get_contents($url_playlist),true);
            $author = array_keys($playlist_id);
            // to do request in database to see if this playlist is or not in the plateform

            $author_id = 0;
            foreach($users as $user) {
                $company_user = get_field('company',  'user_' . $user->ID);
                if(isset($company_user[0]->post_title))
                    if (strtolower($user->display_name) == strtolower($author[0])) {
                        $author_id = $user->ID;
                        $company = $company_user[0];
                        $company_id = $company_user[0]->ID;
                    }
            }

            // Accord the author a company
            if(!is_wp_error($author_id))
                update_field('company', $company, 'user_' . $author_id);

            foreach($playlists['items'] as $playlist){

                //tags
                $tags = array();
                $categories = array();
                $cats = get_categories(
                    array(
                        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                        'orderby'    => 'name',
                        'exclude' => 'Uncategorized',
                        'parent'     => 0,
                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                    )
                );

                foreach($cats as $item){
                    $cat_id = $item->cat_ID;
                    array_push($categories, $cat_id);
                }

                $categorys = array();
                foreach($categories as $categ){
                    //Topics
                    $topics = get_categories(
                        array(
                            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                            'parent'  => $categ,
                            'hide_empty' => 0, // change to 1 to hide categores not having a single post
                        )
                    );
                    // var_dump($topics);
                    foreach ($topics as $value) {
                        $tag = get_categories(
                            array(
                                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                                'parent'  => $value->cat_ID,
                                'hide_empty' => 0,
                            )
                        );
                        $categorys = array_merge($categorys, $tag);
                    }
                }
                $words_not_goods=[];
                foreach($categorys as $cat){
                    // var_dump($cat->cat_name);
                    if(str_contains($cat->cat_name,' ')){
                        $words_not_goods[]=$cat->cat_name;
                    }
                }

                foreach($keywords as $searchword){
                    $searchword = trim(strtolower(strval($searchword)));
                    foreach($categorys as $category){
                        $cat_slug = $category->slug;
                        $cat_name = $category->cat_name;
                        if(strpos(strtolower($keywords[$key]), strtolower($cat_slug)) !== false || trim(strtolower($keywords[$key])) == trim(strtolower($cat_name)))
                            if(!in_array($category->cat_ID, $tags))
                                array_push($tags, $category->cat_ID);
                    }
                }

                if(empty($tags)){
                    foreach($categorys as $value)
                        if(!in_array($value->cat_ID, $tags))
                            array_push($tags, $value->cat_ID);
                        else {
                            continue;
                        }
                }

                if(sizeof($tags)<20)
                    $onderwerpen = join(',',$tags);
                else
                    $onderwerpen = "";
                // var_dump($onderwerpen);

                //define type
                $type = 'Video';

                //Get the url media image to display on front
                $image = ( isset($playlist['snippet']['thumbnails']['maxres']) ) ? $playlist['snippet']['thumbnails']['maxres']['url'] : $playlist['snippet']['thumbnails']['standard']['url'];
                $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($type));
                $result_image = $wpdb->get_results($sql_image);
                $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s",array($playlist['snippet']['title'],$type));
                $result_title = $wpdb->get_results($sql_title);

                if(!isset($result_title[0]) && !isset($result_image[0])){
                    $url_playlist = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $playlist['id'] . "&maxResults=" . $maxResults . "&key=" . $api_key;

                    $detail_playlist = json_decode(file_get_contents($url_playlist, true));
                    $youtube_videos = '';
                    foreach($detail_playlist->items as $video){
                        $youtube_video = '';
                        $youtube_video .=  $video->snippet->resourceId->videoId;
                        $youtube_video .= '~' . $video->snippet->title;
                        $youtube_video .= '~' . $video->snippet->thumbnails->high->url;

                        $youtube_videos .= ';' . $youtube_video;
                    }

                    $status = 'extern';

                    //Data to create the course
                    $data = array(
                        'titel' => $playlist['snippet']['title'],
                        'type' => $type,
                        'videos' => $youtube_videos,
                        'short_description' => $playlist['snippet']['description'],
                        'long_description' => $playlist['snippet']['description'],
                        'duration' => null,
                        'prijs' => 0,
                        'prijs_vat' => 0,
                        'image_xml' => $image,
                        'onderwerpen' => $onderwerpen,
                        'date_multiple' => null,
                        'course_id' => null,
                        'author_id' => $author_id,
                        'company_id' =>  $company_id,
                        'status' => $status
                    );
                    $wpdb->insert($table,$data);
                    $post_id = $wpdb->insert_id;

                    echo "<span class='textOpleidRight'> Course_ID : " . $post_id . " - Insertion done successfully <br><br></span>";
                } else {
                    // update the list in plateform if necessaire
                }
            }
        }

    }else
        echo '<h3>No news playlists found</h3>';
    //Empty youtube channels after parse
    update_field('youtube_playlists', null , 'user_'. $author_id);
}

function updateYoutube(){
    $api_key = "AIzaSyB0J1q8-LdT0994UBb6Q35Ff5ObY-Kqi_0";
    $maxResults = 45;
    global $wpdb;
    $posts_table = $wpdb->prefix . 'posts';
//    $args = array(
//        'post_type' => 'course',
//        'post_status' => 'publish',
//        'posts_per_page' => -1,
//        'ordevalue' => 'podcast',
//        'order' => 'DESC' ,
//        'meta_key'   => 'course_type',
//        'meta_value' => "video"
//    );
//    $videos  = get_posts($args);
//    foreach ($videos as $course){
//        $youtube_playlists = get_field('youtube_videos',$course->ID);
//        var_dump($youtube_playlists);
//    }

    //$fileName = get_stylesheet_directory_uri()."/files/Big-Youtube-list-Correct-test.csv";
    $fileName = get_stylesheet_directory_uri()."/files/Big-Youtube-list-Correct.csv";
    $file = fopen($fileName, 'r');
    if ($file) {
        while ($line = fgetcsv($file)) { //run the row by row
            $list_url = explode(';',$line[0])[2];
            if (strtoupper(substr($list_url,0,2)) === 'PL') { // take only playlist, not single video
                $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?order=date&part=snippet&id=" . $list_url . "&key=" . $api_key;
                $playlists = json_decode(file_get_contents($url_playlist),true);
                // var_dump($playlists['items'][0]['snippet']['thumbnails']['maxres']['url']);
                foreach($playlists['items'] as $playlist){
                    $youtube_video = array();
                    $title_playlist = $playlist['snippet']['title'];
                    $sql_title = $wpdb->prepare("SELECT * FROM $posts_table WHERE post_title=%s ",array($title_playlist));
                    //print_r($sql_title);
                    $course_video_via_tittle = $wpdb->get_results($sql_title);
                    if (!$course_video_via_tittle)
                        continue;

                    if ($course_video_via_tittle){
                        $id_course = $course_video_via_tittle[0]->ID;
                        $youtube_videos = get_field('youtube_videos',$id_course);
                        foreach ($youtube_videos as $youtube_video_course)
                            if ($youtube_video_course['id'] == $playlist['snippet']['resourceId']['videoId'])
                                break;

                        //Train the data to insert in the database with api youtube
                        $youtube_video['id'] = $playlist['snippet']['resourceId']['videoId'];
                        $youtube_video['title'] = $playlist['snippet']['title'];
                        $youtube_video['thumbnail_url'] = $playlist['snippet']['thumbnails']['high']['url'];
                        //var_dump($youtube_videos);
                        //parcourir le tableau $youtube_videos et voir si $youtube_video['id'] y exixte ?

                        $youtube_videos [] = $youtube_video;
                        update_field('youtube_videos',$youtube_videos,$id_course);
                    }
                }
            }
        } //run the row by row
        fclose($file);
    }

}