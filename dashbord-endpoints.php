<?php
function expertsToFollow()
{
    $experts = get_users();
    var_dump($experts);
    /**
    $all_experts = array();
    foreach ($experts as $expert) {
        $expert_data = array();
        $roles = $expert->roles;
        $expert_data['id'] = $expert->ID;
        $expert_data['name'] = $expert->display_name;
        $expert_data['email'] = $expert->user_email;
        $expert_data['name'] = $expert->display_name;
        $expert_data['avatar'] = get_avatar_url($expert->ID);
        $all_experts[] = $expert_data;
    }

    $response = new WP_REST_Response($all_experts);
    $response->set_status(200);
    return $response;
     */
}

/**
function get_total_followed_experts()
{
    $current_user = $GLOBALS['user_id'];
    $count = 0;
    //$experts_followed = get_user_meta($current_user, 'expert') != false ? get_user_meta($current_user, 'expert') : [];
    if (!empty($experts_followed)) {
        $experts = new stdClass;
        $experts -> experts = [];
        foreach ($experts_followed as $key => $expert_followed)
        {
            $expert_img = get_field('profile_img','user_'.$expert_followed) ? get_field('profile_img','user_'.$expert_followed) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
            array_push ($experts -> experts, new Expert(get_user_by( 'ID', $expert_followed ), $expert_img));
        }
        return $experts;
    }
    return [];
}
*/
