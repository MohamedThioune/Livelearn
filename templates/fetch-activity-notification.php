<?php /** Template Name: Fetch activity notification */ ?>

<?php

extract($_POST);

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

/*
* * Feedbacks of these user
*/
$args = array(
    'post_type' => 'feedback',
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);
$todos = get_posts($args);
/*
* * End
*/

if(isset($search_activity_notification)){
    foreach($todos as $key => $todo) {
        $filter = $todo->post_title; 
        
        $type = get_field('type_feedback', $todo->ID);
        $manager_id = get_field('manager_feedback', $todo->ID);
        if($manager_id){
            $manager = get_user_by('ID', $manager_id);
            $image = get_field('profile_img',  'user_' . $manager->ID);
            $manager_display = $manager->display_name;
        }else{
            $manager_display = 'A manager';
            $image = 0;
        }

        if(!$image)
            $image = get_stylesheet_directory_uri() . '/img/Group216.png';

        if($type == "Feedback" || $type == "Compliment" || $type == "Gedeelde cursus")
            $beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
        else if($type == "Persoonlijk ontwikkelplan")
            $beschrijving_feedback = get_field('opmerkingen', $todo->ID);
        else if($type == "Beoordeling Gesprek")
            $beschrijving_feedback = get_field('algemene_beoordeling', $todo->ID);

        if(stristr($filter, $search_activity_notification) || $search_activity_notification == '')
            $row_activity_notification .= '
            <tr>
                <td scope="row">' . $key . ' </td>
                <td><a href="/dashboard/user/detail-notification/?todo=' . $todo->ID . '"> <strong>' . $todo->post_title . '</strong> </a></td>
                <td>' . $type. '</td>
                <td class="descriptionNotification"><a href="/dashboard/user/detail-notification/?todo=' . $todo->ID . '">'  . $beschrijving_feedback. '  </a></td>
                <td>' . $manager_display . ' </td>
                <td class="textTh">
                    <div class="dropdown text-white">
                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                            <img  style="width:20px"
                                    src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                        </p>
                        <ul class="dropdown-menu">
                            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="/dashboard/user/detail-notification/?todo=' . $todo->ID . ' ">Bekijk</a></li>
                        </ul>
                    </div>
                </td>
            </tr>';
    }

    echo $row_activity_notification;
}

