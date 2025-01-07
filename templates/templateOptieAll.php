 <?php /** Template Name: Optie All*/?>
 <?php
global $wpdb;
extract($_POST);
// var_dump($class, $ids, $optie);
$table = $wpdb->prefix . 'databank';
$user_connected = wp_get_current_user();
if (isset($ids)) {
    foreach ($ids as $key => $obj) {
        $sql = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}databank WHERE id = %d", $obj);
        $course = $wpdb->get_results($sql)[0];
        $where = ['id' => $obj];
        $origin_id = $course->org;
        $feedid = $course->course_id;
        if ($optie == "✔") {
            if($course->image_xml==null)
            {
                if($course->type)
                    $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->type) . '.jpg';
                else
                    $image = get_stylesheet_directory_uri() . '/img' . '/opleidingen.jpg';
                $course->image_xml=$image;
                $wpdb->update($table,$course->image_xml,$where);
            }

            if (strval($course->type) == "Podcast" || strval($course->type) == "Video"){
                if(!$course->company_id) {
                    foreach ($users as $user) {
                        $company_user = get_field('company', 'user_' . $user->ID);
                        if ($course->author_id) {
                            if ($course->author_id == $user->ID) {
                                $company = $company_user[0];
                                $course->company_id = $company_user[0]->ID;
                            }
                        }
                    }
                }elseif (!$course->short_description){
                    $course->short_description = "no short description !";
                }
            }

            if (strval($course->type) == "Podcast" || strval($course->type) == "Video"){
                if(!$course->company_id) {
                    foreach ($users as $user) {
                        $company_user = get_field('company', 'user_' . $user->ID);
                        if ($course->author_id) {
                            if ($course->author_id == $user->ID) {
                                $company = $company_user[0];
                                $course->company_id = $company_user[0]->ID;
                            }
                        }
                    }
                }elseif (!$course->short_description){
                    $course->short_description = "no short description !";
                }
            }

            if (strval($course->type) == "Podcast" || strval($course->type) == "Video"){
                if(!$course->company_id) {
                    foreach ($users as $user) {
                        $company_user = get_field('company', 'user_' . $user->ID);
                        if ($course->author_id) {
                            if ($course->author_id == $user->ID) {
                                $company = $company_user[0];
                                $course->company_id = $company_user[0]->ID;
                            }
                        }
                    }
                }elseif (!$course->short_description){
                    $course->short_description = "no short description !";
                }
            }

            if ( $course->author_id == '0' || $course->author_id == null )
                    $course->author_id = $user_connected->ID;

            if (!$course->short_description || !$course->image_xml || !$course->titel || !$course->author_id || !$course->company_id) {
                echo '<pre>value null</pre>';
                // var_dump($course);
                http_response_code(500);
                return 0;
            }

            //Insert some other course type
            $type = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'E-learning', 'Lezing', 'Event', 'Webinar', 'Podcast'];
            $typos = ['Opleidingen' => 'course', 'Workshop' => 'workshop', 'Training' => 'training', 'Masterclass' => 'masterclass', 'E-learning' => 'elearning', 'reading' => 'Lezing', 'event' => 'Event', 'Video' => 'video', 'Webinar' => 'webinar', 'podcast' => 'Podcast'];

            //Insert Artikel
            if (strval($course->type) == "Artikel") {
                //Creation post
                $args = array(
                    'post_type' => 'post',
                    'post_author' => $course->author_id,
                    'post_status' => 'publish',
                    'post_title' => $course->titel,
                );
                $id_post = wp_insert_post($args, true);
                //Custom

                if ($course->image_xml) {
                    $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course->type) . '.jpg';
                    update_field('image_xml', $image, $id_post);
                }
                update_field('course_type', 'article', $id_post);
                update_field('article_itself', nl2br($course->long_description), $id_post);
            }
            //Insert YouTube
            else if (strval($course->type) == "Video") {
                //Creation course
                $args = array(
                    'post_type' => 'course',
                    'post_author' => $course->author_id, 
                    'post_status' => 'publish',
                    'post_title' => $course->titel,
                );
                $id_post = wp_insert_post($args, true);

                //Custom
                $videos = explode(';', $course->videos);

                $youtube_video = array();
                $youtube_videos = array();
                foreach ($videos as $item) {
                    $video = explode('~', $item);

                    if (!isset($video[1])) {
                        continue;
                    }

                    $youtube_video['id'] = $video[0];
                    $youtube_video['title'] = $video[1];
                    $youtube_video['thumbnail_url'] = $video[2];

                    array_push($youtube_videos, $youtube_video);
                }

                update_field('origin_id', $origin_id, $id_post);
                update_field('course_type', 'video', $id_post);
                update_field('youtube_videos', $youtube_videos, $id_post);
            } else if (strval($course->type) == 'Podcast') {
                //Creation course
                $args = array(
                    'post_type' => 'course',
                    'post_author' => $course->author_id,
                    'post_status' => 'publish',
                    'post_title' => $course->titel,
                );

                $id_post = wp_insert_post($args, true);
                $podcasts = explode('|', $course->podcasts);
                $podcasts = array_reverse($podcasts);
                $podcasts_playlists = [];
                foreach ($podcasts as $item) {
                    if (!$item) {
                        continue;
                    }

                    $podcasts_playlist = [];
                    $podcast = explode('~', $item);
                    $podcasts_playlist['podcast_url'] = $podcast[0];
                    $podcasts_playlist['podcast_title'] = $podcast[1] ?: $course->titel;
                    $podcasts_playlist['podcast_description'] = $podcast[2] ?: $course->short_description;
                    $podcasts_playlist['podcast_date'] = $podcast[3] ?: date('Y-m-d H:i:s');
                    $podcasts_playlist['podcast_image'] = $podcast[4] ?: $course->image_xml;

                    $podcasts_playlists[] = $podcasts_playlist;
                }

                update_field('origin_id', $feedid, $id_post);
                update_field('course_type', 'podcast', $id_post);
                update_field('podcasts_index', $podcasts_playlists, $id_post);
            }
            //Insert Others
            else if (in_array(strval($course->type), $type)) {
                //Creation course
                $args = array(
                    'post_type' => 'course',
                    'post_author' => $course->author_id,
                    'post_status' => 'publish',
                    'post_title' => $course->titel,
                );
                $id_post = wp_insert_post($args, true);
                //Custom
                $coursetype = "";
                foreach ($typos as $key => $typo) {
                    if ($course->type == $key) {
                        $coursetype == $typo; 
                    }
                }
                update_field('course_type', $typos[$course->type], $id_post);
            }
            if (is_wp_error($id_post)) {
                $error = new WP_Error($id_post);
                echo $error->get_error_message($id_post);
            } else {
                // echo "post-id : " . $id_post;
                echo "<span class='alert alert-success'>validation successfuly ✔️</span>";
            }
            $onderwerpen = explode(',', $course->onderwerpen);
            /*
             ** UPDATE COMMON FIELDS
             */

            //Experts
            $contributors = explode(',', $course->contributors);
            if (isset($contributors[0])) {
                if ($contributors[0] && $contributors[0] != "" && $contributors[0] != " ") {
                    update_field('experts', $contributors, $id_post);
                }
            }

            //Categories
            if (isset($onderwerpen[0])) {
                if ($onderwerpen[0] && $onderwerpen[0] != "" && $onderwerpen[0] != " ") {
                    update_field('categories', $onderwerpen, $id_post);
                }
            }

            update_field('short_description', nl2br($course->short_description), $id_post);
            update_field('long_description', nl2br($course->long_description), $id_post);
            update_field('url_image_xml', $course->image_xml, $id_post);

            if ($course->company_id != 0 && $course->author_id != 0) {
                $company = get_post($course->company_id);
                update_field('company', $company, 'user_' . $course->author_id);
            }

            //Date
            $data_locaties = explode('~', strval($course->date_multiple));
            if ($data_locaties) {
                if (isset($data_locaties[0])) {
                    if ($data_locaties[0] && $data_locaties[0] != "" && $data_locaties[0] != " ") {
                        update_field('data_locaties_xml', $data_locaties, $id_post);
                    }
                }
            }

            /*
             ** END
             */

            //Prijs
            $course->prijs = ($course->prijs) ? intval($course->prijs) : 0;
            $prijs = ($course->prijs > 0) ? $course->prijs : 0;
            update_field('price', $prijs, $id_post);

            /*
            ** END
            */

            // $data = [ 'course_id' => $id_post]; // NULL value.
            // $wpdb->update( $table, $data, $where );
        } else if ($optie == "❌") {
            if ($operation == 'missing') {
                null;
            } else if ($operation == 'present') {
                wp_trash_post($course->course_id);
            }

        }
        $data = ['state' => 1, 'optie' => $optie]; // NULL value.
        $updated = $wpdb->update($table, $data, $where);

        if ($updated === false) {
            echo 'error';
        } else {
            echo 'succeed';
        }


    }
}
// header('location: /databank');
?>

