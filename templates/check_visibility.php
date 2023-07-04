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
            
        // if(!$data_name)
        //     return;

        //testing wheither data_id exist ?
        $sql = $wpdb->prepare( "SELECT occurence,id FROM $table_tracker_views  WHERE data_id = $corse_id");
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
        return $wpdb->insert_id;
    }
