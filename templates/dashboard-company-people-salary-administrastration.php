<?php /** Template Name: salary admin system */ ?>
<?php // /livelearn/salaryadmin ?>

<?php
// var_dump($_POST);
$users = get_users();
$data_user = wp_get_current_user();
$user_connected = $data_user->data->ID;
extract($_POST);
if (isset($id)) {
    $user_concerned = get_user_by('ID', $id);
    $managers = array();
        $my_managers = array();
        foreach ($users as $key => $user) {
            $users_manageds = get_field('managed' ,'user_' . $user->ID);
            if(!empty($users_manageds)) {
                if (in_array($user_concerned->ID, $users_manageds)) { // $uer by $user_concerned
                    // array_push($my_managers, $user);
                    $name = $user->first_name !="" ? $user->first_name : $user->display_name;
                    $link = "/dashboard/company/profile/?id=" . $user->ID . '&manager='. $user_connected;
                    $img_manager = get_field('profile_img',  'user_' . $user->ID) ? get_field('profile_img',  'user_' . $user->ID) : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                    echo '<tr>
                                <td>' . $name . '</td>
                                <td>
                                    <img class="" src="' . $img_manager . '" alt="">
                                </td>
                                <td><a href="' . $link . '">See</a></td>
                            </tr>';
                }
                }
        }
 }
