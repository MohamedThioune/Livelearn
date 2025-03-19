<?php
    $visibility_company = null;
    $user_visibility = get_current_user();
    $company_visibility = get_field('company',  'user_' . $user_visibility);

    if(!empty($company_visibility))
        $visibility_company = $company_visibility[0]->post_title;

    function visibility($course, $visibility_company){
        $bool = true;

        $invisibility = get_field('visibility', $course->ID);

        $company = get_field('company',  'user_' . $course->post_author);
        if(!empty($company))
            $company_title = $company[0]->post_title;

        if($invisibility && $visibility_company != $company_title )
            $bool = false;

        return $bool;
    }

    //Push notifications
    function sendPushNotification($title, $body) {
        $current_user = wp_get_current_user();
        $token = get_field('smartphone_token',  'user_' . $current_user->ID);
        if(!$token)
            return 0;

        $serverKey = "Bearer AAAAurXExgE:APA91bEVVmb3m7BcwiW6drSOJGS6pVASAReDwrsJueA0_0CulTu3i23azmOTP2TcEhUf-5H7yPzC9Wp9YSHhU3BGZbNszpzXOXWIH1M6bbjWyloBrGxmpIxHIQO6O3ep7orcIsIPV05p";
        $data = [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: ' . $serverKey,
            'Content-Type: application/json',
        ];

        $url = 'https://fcm.googleapis.com/fcm/send';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    //function view($course, $user_visibility){
    function view($course){
        save_view($course->ID);
    }

    //first test in view topic
    //function view_topic($topic_id, $user_visibility){
    function view_topic($topic_id){
        save_view($topic_id,'topic');
    }
    //function view_user($expert_id, $user_visibility){
    function view_user($expert_id){
        save_view($expert_id,'expert');
    }

    function save_view($corse_id, $type = 'course') {
        $user_visibility = wp_get_current_user();
        global $wpdb;
        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
        $data_name = "";
        //save_tracking();
        check_tracking();

        if(!$user_id)
            return 0;
        $occurence = 1;
        //Add by MaxBird - get name entity
        if($type == 'course')
        {
            $course = get_post($corse_id);
            $data_name = (!empty($course)) ? $course->post_name : null;
        }
        else if($type == 'expert')
        {
            $expert_infos = get_user_by('id', $corse_id);
            $data_name = ($expert_infos->last_name) ? $expert_infos->first_name : $expert_infos->display_name;
        }
        else if($type == 'topic')
            $data_name = (String)get_the_category_by_ID($corse_id);
            
        //testing wheither data_id exist ?
        $sql = $wpdb->prepare( "SELECT occurence,id FROM $table_tracker_views WHERE data_id = $corse_id AND user_id = $user_id AND data_type = '$type'");
        $occurence_id = $wpdb->get_results( $sql)[0]->occurence;
        $id_tracker_founded = $wpdb->get_results( $sql)[0]->id;
        if($type == 'course'){
            $course = get_post($corse_id);
            $data_name = (!empty($course)) ? $course->post_name : null;
        }elseif($type == 'expert'){
            $expert_infos = get_user_by('id', $corse_id);
            $data_name = ($expert_infos->last_name) ? $expert_infos->first_name : $expert_infos->display_name;
        }else if($type == 'topic')
            $data_name = (String)get_the_category_by_ID($corse_id);

        /** Badges **/
        $sql = $wpdb->prepare( "SELECT data_id FROM $table_tracker_views WHERE user_id = $user_id");
        $occurences = $wpdb->get_results( $sql );
        $sql_topic = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id = " . $user_id . " AND data_type = 'topic' AND occurence >= 10 GROUP BY data_id ORDER BY occurence DESC");
        $topic_views = $wpdb->get_results($sql_topic);
        $best_topic_views = intval($topic_views[0]->occurence);

        $count = array('Opleidingen' => 0, 'Workshop' => 0, 'E-learning' => 0, 'Event' => 0, 'E_learning' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0, 'Podcast' => 0);
        $libelle_badges = [
            'Congratulations ' . $user_visibility->display_name . ', you\'ve just read your first article !',
            'Well done ' . $user_visibility->display_name . ' you become expert in article',
            'Good job ' . $user_visibility->display_name . ', video expert apprentice !',
            'Well done ' . $user_visibility->display_name . ' you become expert in video',
            $user_visibility->display_name . ', you\'re really a podcast enthusiast !',
            $user_visibility->display_name . ', you\'re really determined to learn !'
        ];
        $trigger_badges = [
            'Read my first article !',
            'Read 50 articles !',
            'Watch 10 videos !',
            'Watch 50 videos !' ,
            'Listen 7 podcasts !' ,
            'View the same topic more than 10 times'    
        ];

        $array_badges = array();

        foreach ($occurences as $value) {
            $course_type = get_field('course_type', $value->data_id);
            $count[$course_type]++;
        }

        $trigger_badge = null;
        if($count['Artikel'] >= 1 && $count['Artikel'] < 50){
            $level = 'basic';
            $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
            $array_badge = array();
            $array_badge['level'] = $level;
            $array_badge['libelle'] = $libelle_badges[0];
            $array_badge['image'] = $image_badge;
            $array_badge['trigger'] = $trigger_badges[0];
            $object_badge = (Object)$array_badge;
            array_push($array_badges, $object_badge);
        }
        if($count['Artikel'] >= 50){
            $level = 'advance';
            $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
            $array_badge = array();
            $array_badge['level'] = $level;
            $array_badge['libelle'] = $libelle_badges[1];
            $array_badge['image'] = $image_badge;
            $array_badge['trigger'] = $trigger_badges[1];
            $object_badge = (Object)$array_badge;
            array_push($array_badges, $object_badge);
        }
        if($count['Video'] >= 10 && $count['Video'] < 50){
            $level = 'pro';
            $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
            $array_badge = array();
            $array_badge['level'] = $level;
            $array_badge['libelle'] = $libelle_badges[2];
            $array_badge['image'] = $image_badge;
            $array_badge['trigger'] = $trigger_badges[2];
            $object_badge = (Object)$array_badge;
            array_push($array_badges, $object_badge);
        }
        if($count['Video'] >= 50){
            $level = 'expert';
            $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
            $array_badge = array();
            $array_badge['level'] = $level;
            $array_badge['libelle'] = $libelle_badges[3];
            $array_badge['image'] = $image_badge;
            $array_badge['trigger'] = $trigger_badges[3];
            $object_badge = (Object)$array_badge;
            array_push($array_badges, $object_badge);
        }
        if($count['Podcast'] >= 7){
            $level = 'pro';
            $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
            $array_badge = array();
            $array_badge['level'] = $level;
            $array_badge['libelle'] = $libelle_badges[4];
            $array_badge['image'] = $image_badge;
            $array_badge['trigger'] = $trigger_badges[4];
            $object_badge = (Object)$array_badge;
            array_push($array_badges, $object_badge);
        }
        if($best_topic_views >= 10){
            $level = 'advance';
            $image_badge = get_stylesheet_directory_uri() . '/img' . '/badge-' . $level . '.png';
            $array_badge = array();
            $array_badge['level'] = $level;
            $array_badge['libelle'] = $libelle_badges[5];
            $array_badge['image'] = $image_badge;
            $array_badge['trigger'] = $trigger_badges[5];
            $object_badge = (Object)$array_badge;
            array_push($array_badges, $object_badge);
        }

        foreach($array_badges as $badge):
            if($badge){
                //Occurrence check
                $args = array(
                    'post_type' => 'badge', 
                    'title' => $badge->libelle,
                    'post_status' => 'publish',
                    'author' => $user_id,
                    'posts_per_page'         => 1,
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false
                );
                $badges = get_posts($args);

                if(empty($badges)){
                    $post_data = array(
                        'post_title' => $badge->libelle,
                        'post_author' => $user_id,
                        'post_type' => 'badge',
                        'post_status' => 'publish'
                    );
                    $badge_id = wp_insert_post($post_data);

                    //Push notifications
                    $title = $badge->libelle;
                    $body = $badge->trigger;
                    sendPushNotification($title, $body);
                }

                if(isset($badge_id))
                    if($badge_id){
                        update_field('image_badge', $badge->image, $badge_id);
                        update_field('trigger_badge', $badge->trigger, $badge_id);
                        update_field('level_badge', $badge->level, $badge_id);
                    }
            }
        endforeach;

        if ($occurence_id) {
            $occurence = intval($occurence_id) + 1;
            $data_modified=[
                'occurence' => $occurence,
                'updated_at'=> date("Y-m-d H:i:s")
            ];
            $where=[
                //'data_id'=>$corse_id,
                'id' => $id_tracker_founded
            ];
            return $wpdb->update($table_tracker_views,$data_modified,$where);
        }

        $data = [
            'data_type' => $type,
            'data_id' => $corse_id,
            'data_name' => $data_name,
            'user_id' => $user_id,
            'platform' => 'web',
            'occurence' => $occurence
        ];
        $wpdb->insert($table_tracker_views, $data);
            
        return $wpdb->insert_id;
    }

    function save_tracking(){
        global $post;
        global $wpdb;
        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        $current_ip_adesss= $_SERVER['REMOTE_ADDR'];
        $user_id = get_current_user_id() ? : 0;
        $occurence = 1;
        $course_type = get_field('course_type', $post->ID);

        if ($user_id)
            return;

        if ($course_type !== 'Artikel' )
            return;

        $sql = $wpdb->prepare( "SELECT occurence,id FROM $table_tracker_views WHERE data_id = $post->ID AND data_type = 'ipadress' AND data_name = '$current_ip_adesss'");
        $occurence_id = $wpdb->get_results( $sql)[0]->occurence;
        $id_tracker_founded = $wpdb->get_results( $sql)[0]->id;

        if ($id_tracker_founded) {
            $occurence = intval($occurence_id) + 1;
            $data_modified=[
                'occurence' => $occurence,
                'updated_at'=> date("Y-m-d H:i:s")
            ];
            $where=[
                'id' => $id_tracker_founded
            ];
            return $wpdb->update($table_tracker_views,$data_modified,$where);
        }

        $data = [
            'data_type' => 'ipadress',
            'data_id' => $post->ID,
            'data_name' => $current_ip_adesss,
            'user_id' => $user_id,
            'platform' => 'web',
            'occurence' => $occurence
        ];

        return $wpdb->insert($table_tracker_views, $data);
    }
    
    function check_tracking(){
        global $post;
        global $wpdb;
        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        $current_ip_adesss= $_SERVER['REMOTE_ADDR'];
        $user_id = get_current_user_id() ? : 0;
        $course_type = get_field('course_type', $post->ID);

        if ($user_id)
            return;

        if ($course_type !== 'Artikel')
            return;

            // if the scrip arrive here that's there's no user connected, so need to check if the user has already read the article more than 3 times
            $sql = $wpdb->prepare("SELECT occurence,id FROM $table_tracker_views WHERE data_id = $post->ID AND data_name = '$current_ip_adesss'" );
            $occurence_id = $wpdb->get_results($sql)[0]->occurence;
            $id_tracker_founded = $wpdb->get_results($sql)[0]->id;
            if ($id_tracker_founded)
                if ( intval($occurence_id) > 3 ) {
                    $params = array(
                        'message' => 'You have already read this article more 3 times connected to continue reading',
                        'redirect' => get_permalink($post->ID)
                    );
                    header('Location: /inloggen/?' . http_build_query($params));
                }
    }
