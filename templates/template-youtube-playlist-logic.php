<?php /** Template Name: youtube playlist */?>
<?php

global $wpdb;

$table = $wpdb->prefix . 'databank';

$user_connected = wp_get_current_user();

?>
<?php
$api_key = "AIzaSyB0J1q8-LdT0994UBb6Q35Ff5ObY-Kqi_0";
$maxResults = 45;

$users = get_users();

$author_id = wp_get_current_user();// id user connected
$args = array(
    'post_type' => 'company',
    'posts_per_page' => -1,
);
$companies = get_posts($args);

//youtube-playlist from excel
$user_id = (isset($user_connected->ID)) ? $user_connected->ID : 0;
$author_id = $author_id->ID;
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
extract($_POST);
if ($playlist_youtube) {
    $fileName = get_stylesheet_directory_uri() . "/files/Big-Youtube-list-Correct-test.csv";
    //$fileName = get_stylesheet_directory_uri() . "/files/Big-Youtube-list-Correct.csv";
    $file = fopen($fileName, 'r');
    if ($file) {
        $playlists_id = array();
        $urlPlaylist = [];
        $onderwp = '';
        $keywords = array();
        while ($line = fgetcsv($file)) {
            $subtopics = "";
            $row = explode(';',$line[0]);
            if (strtoupper(substr($row[2],0,2)) === 'PL')
                $playlists_id[][$row[4]] = $row[2];

            $subtopics = $row[6];
            array_push($keywords,$subtopics);
        }

        fclose($file);
        array_shift($keywords);
    } else {
        echo "<span class='text-center alert alert-danger'>not possible to read the file</span>";
    }
    array_shift($playlists_id);

    $i = 1;
    if ($playlists_id || !empty($playlists_id)) {
        foreach ($playlists_id as $key => $playlist_id) {
            $id_playlist = array_values($playlist_id);
            $url_playlist = "https://youtube.googleapis.com/youtube/v3/playlists?order=date&part=snippet&id=" . $id_playlist[0] . "&key=" . $api_key;
            $playlists = json_decode(file_get_contents($url_playlist), true);
            $author = array_keys($playlist_id);


            // Accord the author a company
            if (!is_wp_error($author_id)) {
                update_field('company', $company, 'user_' . $author_id);
            }

            foreach ($playlists['items'] as $playlist) {
                //tags
                $tags = array();
                $onderwerpen = "";
                $categories = array();
                $cats = get_categories(
                    array(
                        'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                        'orderby' => 'name',
                        'exclude' => 'Uncategorized',
                        'parent' => 0,
                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                    )
                );

                foreach ($cats as $item) {
                    $cat_id = $item->cat_ID;
                    array_push($categories, $cat_id);
                }

                $bangerichts = get_categories(
                    array(
                        'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                        'parent' => $categories[1],
                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                    )
                );

                $functies = get_categories(
                    array(
                        'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                        'parent' => $categories[0],
                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                    )
                );

                $skills = get_categories(
                    array(
                        'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                        'parent' => $categories[3],
                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                    )
                );

                $interesses = get_categories(
                    array(
                        'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                        'parent' => $categories[2],
                        'hide_empty' => 0, // change to 1 to hide categores not having a single post
                    )
                );

                $categorys = array();
                foreach ($categories as $categ) {
                    //Topics
                    $topics = get_categories(
                        array(
                            'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                            'parent' => $categ,
                            'hide_empty' => 0, // change to 1 to hide categores not having a single post
                        )
                    );

                    foreach ($topics as $value) {
                        $tag = get_categories(
                            array(
                                'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                                'parent' => $value->cat_ID,
                                'hide_empty' => 0,
                            )
                        );
                        $categorys = array_merge($categorys, $tag);
                    }
                }
                $words_not_goods = [];
                foreach ($categorys as $cat) {
                    // var_dump($cat->cat_name);
                    if (str_contains($cat->cat_name, ' ')) {
                        $words_not_goods[] = $cat->cat_name;
                    }
                }

                foreach ($keywords as $searchword) {
                    $searchword = trim(strtolower(strval($searchword)));
                    foreach ($categorys as $category) {
                        $cat_slug = $category->slug;
                        $cat_name = $category->cat_name;
                        if (strpos(strtolower($keywords[$key]), strtolower($cat_slug)) !== false || trim(strtolower($keywords[$key])) == trim(strtolower($cat_name))) {
                            if (!in_array($category->cat_ID, $tags)) {
                                array_push($tags, $category->cat_ID);
                            }
                        }
                    }
                }

                if (empty($tags)) {
                    foreach ($categorys as $value) {
                        if (!in_array($value->cat_ID, $tags)) {
                            array_push($tags, $value->cat_ID);
                        } else {
                            continue;
                        }
                    }
                }

                if (sizeof($tags) < 20) {
                    $onderwerpen = join(',', $tags);
                } else {
                    $onderwerpen = "";
                }

                //define type
                $type = 'Video';

                //Get the url media image to display on front
                $image = (isset($playlist['snippet']['thumbnails']['maxres'])) ? $playlist['snippet']['thumbnails']['maxres']['url'] : $playlist['snippet']['thumbnails']['standard']['url'];
                $sql_image = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE image_xml = %s AND type = %s", array($images, $type));
                $result_image = $wpdb->get_results($sql_image);

                $sql_title = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank where titel=%s and type=%s", array($playlist['snippet']['title'], $type));
                $result_title = $wpdb->get_results($sql_title);

                //if (!isset($result_title[0]) && !isset($result_image[0])) {
                    $url_playlist = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=" . $playlist['id'] . "&maxResults=" . $maxResults . "&key=" . $api_key;

                    $detail_playlist = json_decode(file_get_contents($url_playlist, true));
                    $youtube_videos = '';

                    foreach ($detail_playlist->items as $key => $video) {
                        $youtube_video = '';
                        $youtube_video .= $video->snippet->resourceId->videoId;
                        $youtube_video .= '~' . $video->snippet->title;
                        $youtube_video .= '~' . $video->snippet->thumbnails->high->url;

                        $youtube_videos .= ';' . $youtube_video;
                    }

                    $status = 'extern';
                    $description = $playlist['snippet']['description'] ? : $playlist['snippet']['title'];

                    //Data to create the course
                    $data = array(
                        'titel' => $playlist['snippet']['title'],
                        'type' => $type,
                        'videos' => $youtube_videos,
                        'short_description' => $description,
                        'long_description' => $description,
                        'duration' => null,
                        'prijs' => 0,
                        'prijs_vat' => 0,
                        'image_xml' => $image,
                        'onderwerpen' => $onderwerpen,
                        'date_multiple' => null,
                        'course_id' => null,
                        'author_id' => $author_id,
                        'company_id' => $company_id,
                        'status' => $status,
                        'org'=>$playlist['id'],
                    );
                    $wpdb->insert($table, $data);
                    $post_id = $wpdb->insert_id;

                    echo "<span class='textOpleidRight'> Course_ID : " . $playlist['id'] . " - Insertion done successfully <br><br></span>";
                //}
            }
            $i++;
        }

    } else {
        echo '<h3>No news playlists found</h3>';
    }

    //Empty youtube channels after parse

    update_field('youtube_playlists', null, 'user_' . $author_id);
}

