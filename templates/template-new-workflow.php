<?php
/** Template Name: workflow subscription */
ini_set('memory_limit', '512M'); // Augmente la limite de mémoire à 512 MB

if ($_POST){
    $userdata = array(
        'user_pass' => $_POST['password'],
        'user_login' => $_POST['username'],
        'user_email' => $_POST['email'],
        'user_url' => 'http://livelearn.nl/',
        'display_name' => $_POST['firstName'] . ' ' . $_POST['lastName'],
        'first_name' => $_POST['firstName'],
        'last_name' => $_POST['lastName'],
        'role' => 'Manager',
    );
    $user_id = wp_insert_user($userdata);
    if (is_wp_error($user_id)) {
        echo "<div class='alert alert-danger text-center'>" .$user_id->get_error_message()." </div>";
        return 0;
    } else {
        //update phone number
        if ($_POST['phone'])
            update_field('telnr', $_POST['phone'], 'user_' . $user_id);

        //create a new company for the new user
        $company_id = wp_insert_post(
            array(
                'post_title' => $_POST['company'],
                'post_type' => 'company',
                'post_status' => 'pending',
            ));
        $company = get_post($company_id);
        update_field('company', $company, 'user_' . $user_id);
        echo "<div class='alert alert-success text-center'>user saved success and company $company->post_title already created.</div>";
    }
}
