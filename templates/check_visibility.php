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


    function view($course){
        $id = ($user_visibility) ? $user_visibility->ID : 0;

        $args = array(
            'post_type' => 'view', 
            'post_status' => 'pending',
            'post_author' => $id,
            );

        $views_stat_user = get_posts($args);

        if(!empty($views_stat_user))
            $statID = $views_stat_user[0]->ID;
        else{
            $data = array(
                'post_type' => 'view',
                'post_author' => $id,
                'post_status' => 'pending',
                'post_title' => $user_visibility->display_name . ' - View',
                );
            
            $statID = wp_insert_post($data);
        }


        $views = get_field('view', $statID);
        $view = array();
        $view['view_course'] = $course;
        $view['view_date'] = now();

        if(!empty($views))
            array_push($views, $view);
        else 
            $views = $view; 

        update_field('view', $views, $statID);

    }