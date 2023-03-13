<?php /** Template Name: Fetch company people */ ?>

<?php

extract($_POST);
$users = get_users();
$data_user = wp_get_current_user();
$user_connected = $data_user->data->ID;
$company = get_field('company',  'user_' . $user_connected);

//Departments 
$departments = get_field('departments', $company[0]->ID);

if(!empty($company))
    $company_connected = $company[0]->post_title;

$grant = get_field('manager',  'user_' . $user_connected);
$ismanaged = get_field('managed',  'user_' . $user_connected); 

$members = array();
foreach($users as $user)
    if($user_connected != $user->ID ){
        $company = get_field('company',  'user_' . $user->ID);
        if(!empty($company)){
            $company = $company[0]->post_title;
            if($company == $company_connected)
                array_push($members, $user);
        }
    }

$count = count($members);


$row_company_people = " ";

if(isset($search_user_company)){
    foreach($members as $key => $user){
        $filter = $user->first_name . ' ' . $user->last_name . ' ' . $user->display_name;
        $managed = in_array($user->ID, $ismanaged) ? 'You' : '';
        $image_user = get_field('profile_img',  'user_' . $user->ID); 
        if(!$image_user)  
            $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png";

        $you = NULL;
        if(!in_array('administrator', $user->roles))
            $you = (in_array($user->ID, $ismanaged) || in_array('administrator', $data_user->roles) || in_array('hr', $data_user->roles) ) ?  'You' : NULL;

        $display_name = (isset($user->first_name)) ? $user->first_name : $user->display_name;

        $manager = get_field('ismanaged', 'user_' . $user->ID);
        $manager_image = get_field('profile_img',  'user_' . $manager); 

        $manager_image_pattern = "";
        if($manager_image)
            $manager_image_pattern = '<div class="ImgUser">
                                        <img src="' . $manager_image . '" alt="">
                                    </div>';
        
        $edit_pattern = "";
        if($you)
            $edit_pattern = '<li class="my-1"> <i class="fa fa-pencil px-2"></i> <a data-toggle="modal" data-target="#modalEdit' . $key . '" href="#">Edit</a> </li>';
        
        $delete_pattern = ""; 
        if(in_array('administrator', $data_user->roles))
            if(!in_array('administrator', $user->roles) && !in_array('hr', $user->roles))
                $delete_pattern = '<li class="my-1">
                                        <div class="remove">
                                            <img class="removeImg" src="' . get_stylesheet_directory_uri() . '/img/deleteIcone.png" alt="">
                                            <span>Verwijderen</span>
                                        </div>
                                    </li>';
                            
        if( stristr($filter, $search_user_company) || $search_user_company == '')
            $row_company_people .= '
            <tr id="' . $user->ID .'" >
                <td scope="row">' . $key . '</td>
                <td class="textTh thModife">
                    <div class="ImgUser">
                    <a href="' . $link . '" > <img src="' . $image_user  . '" alt=""> </a>
                    </div>
                </td>
                <td class="textTh"> <a href="' . $link . '" style="text-decoration:none;">' . $display_name . '</a> </td>
                <td class="textTh">' . $user->user_email . '</td>
                <td class="textTh">' . get_field('telnr', 'user_'.$user->ID) . '</td>
                <td class="textTh elementOnder">' . get_field('role', 'user_'.$user->ID) . '</td>
                <td class="textTh">' . get_field('department', 'user_'.$user->ID) . '</td>
                <td class="textTh thModife">
                ' . $manager_image_pattern . '
                </td>
                <td class="textTh">
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img  style="width:20px"
                                src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link; ?>" target="_blank">Bekijk</a></li>
                            ' . $edit_pattern . '
                            ' . $delete_pattern . '
                        </ul>
                    </div>
                </td>
            </tr>
            ';
    }
    echo $row_company_people;
}