<?php /** Template Name: Fetch company people */ ?>

<?php

$users = get_users();
$user_id = get_current_user_id();

$company_connected = get_field('company',  'user_' . $user_id);
$users_company = array();

$ismanaged = get_field('managed',  'user_' . $user_connected); 


foreach($users as $user) {
    $company_user = get_field('company',  'user_' . $user->ID);
    if(!empty($company_connected) && !empty($company_user) && $user->ID != $user_id)
        if($company_user[0]->post_title == $company_connected[0]->post_title) 
            array_push($users_company, $user->ID);
}

$row_company_people = " ";

if(isset($_POST['search_user_company'])){
    foreach($users as $user){
        $filter = $user->data->first_name . ' ' . $user->data->last_name;
        $managed = in_array($user->ID, $ismanaged) ? 'You' : '';

        if(stristr($filter, $_POST['search_user_company']) || $_POST['search_path'] == '')
            $row_company_people .= '
            <tr id="' . $user->ID . '" >
                <td class="textTh thModife">
                    <div class="ImgUser">
                    <a href="/dashboard/company/profile/?id=' . $user->ID . '&manager='. $user_id . '" > <img src="' . $image_user . '" alt=""> </a>
                    </div>
                </td>
                <td class="textTh"> <a href="/dashboard/company/profile/?id=' . $user->ID . '&manager='. $user_id . '" style="text-decoration:none;">' . $user->display_name . '</a> </td>
                <td class="textTh">' . $user->user_email . '</td>
                <td class="textTh">' . get_field('telnr', 'user_'.$user->ID) . '</td>
                <td class="textTh elementOnder">' . get_field('role', 'user_'.$user->ID) . '</td>
                <td class="textTh">' . get_field('department', 'user_'.$user->ID) . '</td>
                <td class="textTh">' . $managed . '</td>
                <td class="titleTextListe remove">
                    <span class="btnNewCourse">Delete</span>
                </td>
            </tr>
            ';
    }

    echo $row_company_people;
}
