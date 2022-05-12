<?php

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';

$company = get_field('company',  'user_' . $user->ID);
$function = get_field('role',  'user_' . $user->ID);

$biographical_info = get_field('biographical_info',  'user_' . $user->ID);

if(!empty($company))
    $company = $company[0]->post_title;

/*
* * Get interests topics and experts
*/

$topics = get_user_meta($user->ID, 'topic');
$experts = get_user_meta($user->ID, 'expert');

/*
* * End
*/

/*
* * Get todos
*/
$todos = get_field('todos',  'user_' . $user->ID);
/*
* * End
*/

?>

<div class="contentActivity">
    <h1 class="activityTitle">Resume Notifications</h1>
    <div class="cardFavoriteCourses cardAlert">
        <div class="d-flex aligncenter justify-content-between">
            <h2>My Alerts</h2>
            <input type="search" placeholder="search" class="inputSearchCourse">
        </div>
       <div class="tableAlert">
           <table class="table table-responsive">
               <thead class="thead-light">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col-4">Alert Query</th>
                    <th scope="col">By</th>
                    <th scope="col">Times</th>
                    <th scope="col">Actions</th>
                </tr>
               </thead>
               <tbody>
               <?php 
                
                foreach($todos as $key=>$todo) {
                    if($key == 6)
                        break;

                    $value = explode(";", $todo);
                    $manager = get_users(array('include'=> $value[2]))[0]->data;
                    $image = get_field('profile_img',  'user_' . $manager->ID);
                    if(!$image)
                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                ?>
               <tr>
                   <th scope="row">Feedback</th>
                   <td class="descriptionNotification"><?php echo $value[1]; ?></td>
                   <td><?php if(isset($manager->first_name) && isset($manager->first_name)) echo $manager->first_name .' '. $manager->first_name; else echo $manager->display_name; ?></td>
                   <td>Weekly</td>
                   <td>
                       <button class="btn bntDelete">
                           <img src="<?php echo get_stylesheet_directory_uri();?>/img/delete.png">
                       </button>
                   </td>
               </tr>
               <?php
                    }
                ?>
               
               </tbody>
           </table>
       </div>
    </div>

</div>