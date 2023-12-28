<?php

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';

$company = get_field('company',  'user_' . $user->ID);
$function = get_field('role',  'user_' . $user->ID);

$biographical_info = get_field('biographical_info',  'user_' . $user->ID);

if(!empty($company))
    $company_name = $company[0]->post_title;

/*
* * Get interests topics and experts
*/

$topics = get_user_meta($user->ID, 'topic');
$experts = get_user_meta($user->ID, 'expert');

/*
* * End
*/

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

?>

<div class="contentActivity">
    <h1 class="activityTitle">Resume Notifications</h1>
    <div class="cardFavoriteCourses cardAlert">
        <div class="d-flex aligncenter justify-content-between">
            <h2>My Alerts</h2>
            <input type="search" placeholder="search" class="inputSearchCourse">
        </div>
        <div class="contentCardListeCourse">
            <table class="table table-responsive tableNotification">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Type</th>
                    <th scope="col-4">Alert </th>
                    <th scope="col">By</th>
                    <th scope="col">Optie</th>
                </tr>
                </thead>
                <tbody>
                <?php

                foreach($todos as $key => $todo) {

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

                    ?>
                    <tr>
                        <td scope="row"><?= $key; ?></td>
                        <td><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>"> <strong><?=$todo->post_title;?></strong> </a></td>
                        <td><?=$type?></td>
                        <td class="descriptionNotification"><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>"><?=$beschrijving_feedback?> </a></td>
                        <td><?= $manager_display; ?></td>
                        <td class="textTh">
                            <div class="dropdown text-white">
                                <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                    <img  style="width:20px"
                                          src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                </p>
                                <ul class="dropdown-menu">
                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>">Bekijk</a></li>
                                    <!-- <li class="my-1" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="<?= $course->ID; ?>" value="Verwijderen"/></li> -->
                                </ul>
                            </div>
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
