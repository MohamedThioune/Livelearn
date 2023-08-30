<?php
    $user_visibility = wp_get_current_user();
    $company_visibility = get_field('company',  'user_' . $user_visibility->ID);


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


    function save_view($corse_id, $type='course') {
        $user_visibility = wp_get_current_user();
        global $wpdb;
        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
        $data_name = "";
        if(!$user_id)
            return;
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
        $sql = $wpdb->prepare( "SELECT occurence,id FROM $table_tracker_views WHERE data_id = $corse_id");
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

        /** Badges **/
        $sql = $wpdb->prepare( "SELECT data_id FROM $table_tracker_views WHERE user_id = $user_id");
        $occurences = $wpdb->get_results( $sql );
        $count = array('Opleidingen' => 0, 'Workshop' => 0, 'E-learning' => 0, 'Event' => 0, 'E_learning' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0 , 'Podcast' => 0);
        $libelle_badges = [
            'Congratulations ' . $user_visibility->display_name . ', you\'ve just read your first article !',
            'Well done ' . $user_visibility->display_name . ' you become expert in article',
            'Good job ' . $user_visibility->display_name . ', video expert apprentice !',
            'Well done ' . $user_visibility->display_name . ' you become expert in video',
            $user_visibility->display_name . ', you\'re really a podcast enthusiast !' 
        ];
        $trigger_badges = [
            'Read my first article !',
            'Read 50 articles !',
            'Read 10 videos !',
            'Read 50 videos !' ,
            'Read 30 podcasts !' 
        ];

        foreach ($occurences as $occurence) {
            $course_type = get_field('course_type', $occurence->data_id);
            $count[$course_type]++;
        }

        $image_badge = get_stylesheet_directory_uri() . '/img/badge-assessment-sucess.png';
        $trigger_badge = null;
        if($count['Artikel'] == 1){
            $libelle_badge = $libelle_badges[0];
            $trigger_badge = $trigger_badges[0];
        }else if($count['Artikel'] == 50){
            $libelle_badge = $libelle_badges[1];
            $trigger_badge = $trigger_badges[1];
        }else if($count['Video'] == 10){
            $libelle_badge = $libelle_badges[2];
            $trigger_badge = $trigger_badges[2];
        }else if($count['Video'] == 50){
            $libelle_badge = $libelle_badges[3];
            $trigger_badge = $trigger_badges[3];
        }else if($count['Video'] == 50){
            $libelle_badge = $libelle_badges[4];
            $trigger_badge = $trigger_badges[4];
        }

        if($trigger_badge){
            //Occurrence check
            $args = array(
                'post_type' => 'badge', 
                'title' => $libelle_badge,
                'post_status' => 'publish',
                'author' => $user_id,
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );
            $badges = get_posts($args);

            if(!empty($badges)){
                $post_data = array(
                    'post_title' => $libelle_badge,
                    'post_author' => $user_id,
                    'post_type' => 'badge',
                    'post_status' => 'publish'
                );
                $badge_id = wp_insert_post($post_data);
            }

            if(isset($badge_id))
                if($badge_id){
                    update_field('image_badge', $image_badge, $badge_id);
                    update_field('trigger_badge', $trigger_badge, $badge_id);
                }
        } 
            
        return $wpdb->insert_id;
    }
