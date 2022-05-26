<?php /** Template Name: Fetch company people */ ?>

<?php

extract($_POST);
$users = get_users();
$user_id = get_current_user_id();

$company_connected = get_field('company',  'user_' . $user_id);
$users_company = array();

$ismanaged = get_field('managed',  'user_' . $user_id); 


foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user) && $user->ID != $user_id)
        if($company_user[0]->post_title == $company_connected[0]->post_title) 
            array_push($users_company, $user);
}

$row_company_people = " ";

if(isset($search_user_company)){
    foreach($users_company as $user){
        $filter = $user->first_name . ' ' . $user->last_name . ' ' . $user->display_name;
        $managed = in_array($user->ID, $ismanaged) ? 'You' : '';
        $image_user = get_field('profile_img',  'user_' . $user->ID); 
        if(!$image_user)  
            $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png"; 
        
        $display_name = ($user->first_name) ? $user->first_name : $user->display_name;

        if( stristr($filter, $search_user_company) || $search_user_company == '')
            $row_company_people .= '
            <tr id="' . $user->ID . '" >
                <td class="textTh thModife">
                    <div class="ImgUser">
                    <a href="/dashboard/company/profile/?id=' . $user->ID . '&manager='. $user_id . '" > <img src="' . $image_user . '" alt=""> </a>
                    </div>
                </td>
                <td class="textTh"> <a href="/dashboard/company/profile/?id=' . $user->ID . '&manager='. $user_id . '" style="text-decoration:none;">' . $display_name . '</a> </td>
                <td class="textTh">' . $user->user_email . '</td>
                <td class="textTh">' . get_field('telnr', 'user_'.$user->ID) . '</td>
                <td class="textTh elementOnder">' . get_field('role', 'user_'.$user->ID) . '</td>
                <td class="textTh">' . get_field('department', 'user_'.$user->ID) . '</td>
                <td class="textTh">' . $managed . '</td>
                <td class="titleTextListe remove">
                    <img class="removeImg" src="' . get_stylesheet_directory_uri(). '/img/dashRemove.png" alt="">
                </td>
            </tr>
            ';
    }

    echo $row_company_people;
}
