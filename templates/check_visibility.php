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
        $id = (isset($user_visibility->ID)) ? $user_visibility->ID : 0;
        if(!$id)
            return false;

        $args = array(
            'post_type' => 'view', 
            'post_status' => 'publish',
            'post_author' => $id,
            );

        $views_stat_user = get_posts($args);

        if(!empty($views_stat_user)){
            $stat_id = $views_stat_user[0]->ID;
        }else{
            $data = array(
                'post_type' => 'view',
                'post_author' => $id,
                'post_status' => 'publish',
                'post_title' => $user_visibility->display_name . ' - View',
                );
            
            $stat_id = wp_insert_post($data);
        }

        $view = get_field('views', $stat_id);
        
        $one_view = array();
        $one_view['course'] = $course;
        $one_view['date'] = date('d/m/Y H:i:s');

        if(!empty($view))
            array_push($view, $one_view);
        else 
            $view = array($one_view); 

        var_dump($view);
        
        update_field('views', $view, $stat_id);

    }