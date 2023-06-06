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

    function view($course, $user_visibility){
        save_view($course->ID);
        /*
            $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
            if(!$user_id)
                return false;

            $args = array(
                'post_type' => 'view',
                'post_status' => 'publish',
                'author' => $user_id,
            );

            $views_stat_user = get_posts($args);

            if(!empty($views_stat_user))
                $stat_id = $views_stat_user[0]->ID;
            else{
                $data = array(
                    'post_type' => 'view',
                    'post_author' => $user_id,
                    'post_status' => 'publish',
                    'post_title' => $user_visibility->display_name . ' - View',
                    );

                $stat_id = wp_insert_post($data);
            }
            // je pense que l'appel peux se faire ici
            $view = get_field('views', $stat_id);

            $one_view = array();
            $one_view['course'] = $course;
            $one_view['date'] = date('d/m/Y H:i:s');

            if(!empty($view))
                array_push($view, $one_view);
            else
                $view = array($one_view);

            update_field('views', $view, $stat_id);
    */
    }
    //first test in view topic
    function view_topic($topic_id, $user_visibility){
        /*        $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
                if(!$user_id)
                    return false;

                $args = array(
                    'post_type' => 'view',
                    'post_status' => 'publish',
                    'author' => $user_id,
                );

                $views_stat_user = get_posts($args);

                if(!empty($views_stat_user))
                    $stat_id = $views_stat_user[0]->ID;
                else{
                    $data = array(
                        'post_type' => 'view',
                        'post_author' => $user_id,
                        'post_status' => 'publish',
                        'post_title' => $user_visibility->display_name . ' - View',
                    );

                    $stat_id = wp_insert_post($data);
                }
        */
        var_dump(save_view($topic_id,'topic'));
        //$stat_id = save_view($topic_id,'topic');
        /*;
        $view = get_field('views_topic', $stat_id);
        
        $one_view = array();
        $one_view['view_id'] = $topic_id;
        $one_view['view_name'] = (String)get_the_category_by_ID($topic_id);
        $one_view['view_date'] = date('d/m/Y H:i:s');

        if(!empty($view))
            array_push($view, $one_view);
        else 
            $view = array($one_view); 
        
        update_field('views_topic', $view, $stat_id);
*/
    }
    function view_user($expert_id, $user_visibility){
        save_view($expert_id,'expert');
        /* $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
         if(!$user_id)
             return false;

         $args = array(
             'post_type' => 'view',
             'post_status' => 'publish',
             'author' => $user_id,
         );

         $views_stat_user = get_posts($args);

         if(!empty($views_stat_user))
             $stat_id = $views_stat_user[0]->ID;
         else{
             $data = array(
                 'post_type' => 'view',
                 'post_author' => $user_id,
                 'post_status' => 'publish',
                 'post_title' => $user_visibility->display_name . ' - View',
                 );

             $stat_id = wp_insert_post($data);
         }

         $view = get_field('views_user', $stat_id);

         $one_view = array();
         $one_view['view_id'] = $expert_id;
         $one_view['view_name'] = get_userdata($expert_id)->display_name;
         $one_view['view_date'] = date('d/m/Y H:i:s');

         if(!empty($view))
             array_push($view, $one_view);
         else
             $view = array($one_view);

         update_field('views_user', $view, $stat_id);
 */
    }


    function save_view($corse_id,$type='course') {
        $user_visibility = wp_get_current_user();
        global $wpdb;
        $table_tracker_views = $wpdb->prefix . 'tracker_views';
        $user_id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
        if(!$user_id)
            return;
        $occurence = 1;
        //testing wheither data_id exist ?
        $sql = $wpdb->prepare( "SELECT occurence FROM $table_tracker_views  WHERE data_id = $corse_id");
        $occurence_id = $wpdb->get_results( $sql)[0]->occurence;
        if ($occurence_id) {
            $occurence = intval($occurence_id) + 1;
            $data=[
                'occurence' => $occurence
            ];
            $where=[
                'data_id'=>$corse_id,
            ];
            return $wpdb->update($table_tracker_views,$data,$where);
        }
        $data = [
            'data_type'=>$type,
            'data_id'=>$corse_id,
            'data_name'=>$type, //to change with @Mouhamed
            'user_id'=>$user_id,
            'platform'=>'web',
            'occurence'=>$occurence
        ];
        $wpdb->insert($table_tracker_views, $data);
        return $wpdb->insert_id;
    }






