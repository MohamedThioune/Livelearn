<html lang="en">
<?php

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

$full_name_user = ($user->first_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name;

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

/*
* * Courses dedicated of these user "Boughts" + "Mandatories"
*/


/*
* * End
*/

//Skills
$topics_external = get_user_meta($user->ID, 'topic');
$topics_internal = get_user_meta($user->ID, 'topic_affiliate');

$topics = array();
if(!empty($topics_external))
    $topics = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics, $value);
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<body>
<div class="content-activity2">
    <div class="advert-course-Block d-flex">
        <div class="advert-one d-flex">
            <div class="blockTextAdvert">
                <p class="name">Hello <span> <?= $full_name_user ?></span> !</p>
                <p class="description">Welcome to our e-learning platform's activity page! Here, you'll find a variety of engaging activities to help you, reinforce your learning .</p>
            </div>
            <div class="blockImgAdvert">
                <!-- <img src="<?php echo get_stylesheet_directory_uri();?>/img/adv-course.png" alt=""> -->
            </div>
        </div>
        <div class="advert-second d-block bg-bleu-luzien">
            <div class="d-flex">
                <div class="icone-course">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_folder-file.png" alt="">
                </div>
                <div class="d-block">
                    <p class="number-course">Your course</p>
                    <p class="description"><?= "0" ?></p>
                </div>
            </div>
            <p class="description-course">A courses to help you learn and acquire new skills at your own pace, on your own time</p>
        </div>
        </div>
    <div class="block-tab-activity">
        <div class="tabs-courses">
            <div class="tabs">
                <ul class="filters">
                    <li class="item active">All</li>
                    <li class="item">Course</li>
                    <li class="item">Notifications</li>
                    <li class="item">Data and analytics</li>
                    <li class="item">Your certificates</li>
                    <li class="item">Assessments</li>
                    <li class="item">Communities</li>
                    <li class="item">Your skills</li>
                </ul>

                <div class="tabs__list">
                    <div class="tab active">
                        <div class="blockItemCourse">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Courses</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="card-course-activity">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col courseTitle">Course Title</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Instructor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                                </div>
                                                <p class="name-element">UX - UI Design certificat</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class=" r-1">
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgUser">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                                </div>
                                                <p class="name-element">Darlene Robertson</p>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                                </div>
                                                <p class="name-element">Motion design </p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="r-1">
                                            <div class="d-flex align-items-center ">
                                                <div class="blockImgUser">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                                </div>
                                                <p class="name-element">Marvin McKinney</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                                </div>
                                                <p class="name-element">videeo annimate After Effect</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="r-1">
                                           <div class="d-flex align-items-center ">
                                               <div class="blockImgUser">
                                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                               </div>
                                               <p class="name-element">Kathryn Murphy</p>
                                           </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                                </div>
                                                <p class="name-element">Mecanic volvo electric</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class=" r-1">
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgUser">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                                </div>
                                                <p class="name-element">Cameron Williamson</p>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="blockItemCourse notificationCourseCard">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Notifications</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="card-notification">
                                <div class="notificationBlock">
                                    <div class="d-flex">
                                        <div class="blockImgCard">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                        </div>
                                        <div>
                                            <p class="name">Daniel</p>
                                            <p class="time">1 hours ago</p>
                                        </div>
                                    </div>
                                    <p class="descriptionNotification">It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                </div>
                                <div class="notificationBlock">
                                    <div class="d-flex">
                                        <div class="blockImgCard">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                        </div>
                                        <div>
                                            <p class="name">Daniel</p>
                                            <p class="time">1 hours ago</p>
                                        </div>
                                    </div>
                                    <p class="descriptionNotification">It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                </div>
                                <div class="notificationBlock">
                                    <div class="d-flex">
                                        <div class="blockImgCard">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" class="" alt="">
                                        </div>
                                        <div>
                                            <p class="name">Daniel</p>
                                            <p class="time">1 hours ago</p>
                                        </div>
                                    </div>
                                    <p class="descriptionNotification">It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                </div>
                            </div>
                        </div>
                        <div class="data-analitycs-block">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Data and analytics</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="content-data-analytics d-flex flex-wrap align-items-center justify-content-between">
                                <div class="analytics-block">
                                    <div class="first-content-analitycs text-left">
                                        <p class="title-block">Analytics</p>
                                        <p class="spent-text"> <b>22 K€</b> spent since the beginning of the adventure</p>
                                        <div class="detail-analytic">
                                            <div class="sub-detail">
                                                <p class="number-sub-detail">29</p>
                                                <p class="text-sub-detail">Profil view</p>
                                            </div>
                                            <div class="sub-detail">
                                                <p class="number-sub-detail">18</p>
                                                <p class="text-sub-detail">Course Done</p>
                                            </div>
                                            <div class="sub-detail">
                                                <p class="number-sub-detail">2</p>
                                                <p class="text-sub-detail">Profil view</p>
                                            </div>
                                            <div class="sub-detail">
                                                <p class="number-sub-detail">29</p>
                                                <p class="text-sub-detail">Spent / Day</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="second-content-analitycs">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/analytics-detail.png" class="" alt="">
                                    </div>
                                </div>
                                <div class="other-analytics">
                                    <div class="d-flex justify-content-center">
                                        <div class="detail-other-analytics">
                                            <p class="number-other-detail">22</p>
                                            <p class="text-other-detail">Articles</p>
                                        </div>
                                        <hr class="hrFirst">
                                        <div class="detail-other-analytics">
                                            <p class="number-other-detail">35</p>
                                            <p class="text-other-detail">E-learning Cours</p>
                                        </div>
                                    </div>
                                    <hr class="hrSecond">
                                    <div class="d-flex justify-content-center">
                                        <div class="detail-other-analytics">
                                            <p class="number-other-detail">5</p>
                                            <p class="text-other-detail">Podcast</p>
                                        </div>
                                        <hr class="hrFirst">
                                        <div class="detail-other-analytics">
                                            <p class="number-other-detail">15</p>
                                            <p class="text-other-detail">Videos Cours</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="blockYourCertificates block-activity-">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Your certificates</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="card-all-certificat card-activity-">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col courseTitle">Certificat No.</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Upload Date</th>
                                        <th>Certificate</th>
                                        <th>Controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <p class="text-center numberCertificat">1</p>
                                        </td>
                                        <td>
                                            <p class="name-element">WordPress Certificate</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">6 April 2019</p>
                                        </td>
                                        <td>
                                            <a href="">View</a>
                                        </td>
                                        <td>
                                            <button class="btn btn-trash">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-center numberCertificat">1</p>
                                        </td>
                                        <td>
                                            <p class="name-element">WordPress Certificate</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">6 April 2019</p>
                                        </td>
                                        <td>
                                            <a href="">View</a>
                                        </td>
                                        <td>
                                            <button class="btn btn-trash">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-center numberCertificat">1</p>
                                        </td>
                                        <td>
                                            <p class="name-element">WordPress Certificate</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">6 April 2019</p>
                                        </td>
                                        <td>
                                            <a href="">View</a>
                                        </td>
                                        <td>
                                            <button class="btn btn-trash">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="blockYourCertificates block-activity-">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Assessments</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="card-all-certificat card-activity-">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col courseTitle">Questionnaire</th>
                                        <th scope="col">Upload Date</th>
                                        <th>Score</th>
                                        <th>Manage</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <p class="text-center">WordPress Certificate</p>
                                        </td>
                                        <td>
                                            <p class="name-element">6 April 2019</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">18 %</p>
                                        </td>
                                        <td class="d-flex align-items-center justify-content-center">
                                            <a href="">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_eye-line.png" class="" alt="">
                                            </a>
                                            <button class="btn btn-trash">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-center">WordPress Certificate</p>
                                        </td>
                                        <td>
                                            <p class="name-element">6 April 2019</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">18 %</p>
                                        </td>
                                        <td class="d-flex align-items-center justify-content-center">
                                            <a href="">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_eye-line.png" class="" alt="">
                                            </a>
                                            <button class="btn btn-trash">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-center">WordPress Certificate</p>
                                        </td>
                                        <td>
                                            <p class="name-element">6 April 2019</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">18 %</p>
                                        </td>
                                        <td class="d-flex align-items-center justify-content-center">
                                            <a href="">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_eye-line.png" class="" alt="">
                                            </a>
                                            <button class="btn btn-trash">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                            </button>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="skills-activity-block">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Skills</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="content-card-skills">
                                <?php
                                foreach($topics as $key=>$value){
                                    $i = 0;
                                    $topic = get_the_category_by_ID($value);
                                    $note = 0;
                                    if(!$topic)
                                        continue;
                                    if(!empty($skills_note))
                                        foreach($skills_note as $skill)
                                            if($skill['id'] == $value){
                                                $note = $skill['note'];
                                                break;
                                            }
                                    $name_topic = (String)$topic;
                                    ?>
                                    <div class="card-skills">
                                        <div class="group position-relative">
                                            <span class="donut-chart has-big-cente"><?= $note ?></span>
                                        </div>
                                        <p class="name-course"><?= $name_topic ?></p>
                                        <div class="footer-card-skills">
                                            <button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills<?= $key ?>">Edit <i class="fa fa-edit"></i></a>
                                                <!-- <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a> -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Start modal edit skills-->
                                    <div class="modal modalEdu fade" id="exampleModalSkills<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Skills</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="group-input-settings">
                                                                    <label for="">Name</label>
                                                                    <input name="" type="text" placeholder="<?= $name_topic ?>" disabled>
                                                                    <input name="id" type="hidden" value="<?= $value ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 skillBar-col">
                                                                <div class="group-input-settings">
                                                                    <label for="">Kies uw vaardigheidsniveau in percentage</label>
                                                                    <div class="slider-wrapper">
                                                                        <div class="edit"></div>
                                                                    </div>
                                                                    <div class="rangeslider-wrap">
                                                                        <input name="note" type="range" min="0" max="100" step="10" labels="0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100" value="<?= $note ?>" onChange="rangeSlide(this.value)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btnSaveSetting" type="submit" name="note_skill_edit">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  End modal edit skills-->
                                    <?php
                                    $i++;
                                }
                                ?>

                            </div>

                        </div>
                        <div class="content-card-communities-activity">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Communities</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="content-card-communities-activity d-flex flex-wrap">
                                <div class="card-communities-activity">
                                    <div class="block-img">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                    </div>
                                    <div>
                                        <p class="name-community">Designer community, Dakar</p>
                                        <p class="number-members">112K Members</p>
                                    </div>
                                </div>
                                <div class="card-communities-activity">
                                    <div class="block-img">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                    </div>
                                    <div>
                                        <p class="name-community">Designer community, Dakar</p>
                                        <p class="number-members">112K Members</p>
                                    </div>
                                </div>
                                <div class="card-communities-activity">
                                    <div class="block-img">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                    </div>
                                    <div>
                                        <p class="name-community">Designer community, Dakar</p>
                                        <p class="number-members">112K Members</p>
                                    </div>
                                </div>
                                <div class="card-communities-activity">
                                    <div class="block-img">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                    </div>
                                    <div>
                                        <p class="name-community">Designer community, Dakar</p>
                                        <p class="number-members">112K Members</p>
                                    </div>
                                </div>
                                <div class="card-communities-activity">
                                    <div class="block-img">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                    </div>
                                    <div>
                                        <p class="name-community">Designer community, Dakar</p>
                                        <p class="number-members">112K Members</p>
                                    </div>
                                </div>
                                <div class="card-communities-activity">
                                    <div class="block-img">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                    </div>
                                    <div>
                                        <p class="name-community">Designer community, Dakar</p>
                                        <p class="number-members">112K Members</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab  tab-course">
                        <div class="blockItemCourse">
                            <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                                <p class="title">Courses</p>
                                <a href="" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                            </div>
                            <div class="card-course-activity">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <input id="" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek" aria-label="Zoek" >
                                    <div class="filterInputBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/filtering.svg" class="" alt="">
                                        <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                            <option selected>Filter</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <table class="table table-responsive text-left">
                                    <thead>
                                    <tr>
                                        <th scope="col courseTitle">Course Title</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Instructor</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Favorite</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="text-left">
                                      <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                                </div>
                                                <p class="name-element">UX - UI Design certificat</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">Darlene Robertson</p>
                                        </td>
                                        <td>
                                            <p class="text-left" style="color: #ff9b00;">In Progress</p>
                                        </td>
                                        <td>
                                            <i class="fa fa-heart mr-4"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-trash mr-4" style="color: red;"></i>
                                        </td>
                                    </tr>
                                      <tr>
                                        <td >
                                           <div class="d-flex align-items-center">
                                               <div class="blockImgCourse">
                                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                               </div>
                                               <p class="name-element">UX - UI Design certificat</p>
                                           </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">Marvin McKinney</p>
                                        </td>
                                        <td>
                                            <p class="text-left" style="color: green;">Done</p>
                                        </td>
                                        <td>
                                            <i class="fa fa-heart-o mr-4"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-trash mr-4" style="color: red;"></i>
                                        </td>
                                    </tr>
                                      <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                                </div>
                                                <p class="name-element">UX - UI Design certificat</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">Kathryn Murphy</p>
                                        </td>
                                        <td>
                                            <p class="text-left" style="color: #043356;">New</p>
                                        </td>
                                        <td>
                                            <i class="fa fa-heart mr-4"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-trash mr-4" style="color: red;"></i>
                                        </td>
                                    </tr>
                                      <tr>
                                        <td >
                                           <div class="d-flex align-items-center">
                                               <div class="blockImgCourse">
                                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                               </div>
                                               <p class="name-element">UX - UI Design certificat</p>
                                           </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">Cameron Williamson</p>
                                        </td>
                                        <td>
                                            <p class="text-left" style="color: #ff9b00;">In Progress</p>
                                        </td>
                                        <td>
                                            <i class="fa fa-heart-o mr-4"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-trash mr-4" style="color: red;"></i>
                                        </td>
                                    </tr>
                                      <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/innovation.jpg" class="" alt="">
                                                </div>
                                                <p class="name-element">UX - UI Design certificat</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element">12h 33m 10s</p>
                                        </td>
                                        <td class="">
                                            <p class="name-element">Kathryn Murphy</p>
                                        </td>
                                        <td>
                                            <p class="text-left" style="color: green;">In Progress</p>
                                        </td>
                                        <td>
                                            <i class="fa fa-heart mr-4"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-trash mr-4" style="color: red;"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab text-left tab-notification">
                        <div class="contentActivity">
                            <div class="cardFavoriteCourses text-left cardAlert">
                                <div class="d-flex aligncenter justify-content-between">
                                    <h2>My Alerts</h2>
                                    <input type="search" placeholder="search" class="inputSearchCourse">
                                </div>
                                <div class="contentCardListeCourse">
                                    <table class="table table-responsive table-responsive tableNotification">
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
                                                <td class="content-title-notification"><a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>"> <strong><?=$todo->post_title;?></strong> </a></td>
                                                <td><?=$type?></td>
                                                <td class="descriptionNotification"><a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>"><?=$beschrijving_feedback?> </a></td>
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

                    </div>
                    <div class="tab tab-analytics">
                        <div class="content-data-analytics d-flex flex-wrap align-items-center justify-content-between">
                            <div class="analytics-block">
                                <div class="first-content-analitycs text-left">
                                    <p class="title-block">Analytics</p>
                                    <p class="spent-text"> <b>22 K€</b> spent since the beginning of the adventure</p>
                                    <div class="detail-analytic">
                                        <div class="sub-detail">
                                            <p class="number-sub-detail">29</p>
                                            <p class="text-sub-detail">Profil view</p>
                                        </div>
                                        <div class="sub-detail">
                                            <p class="number-sub-detail">18</p>
                                            <p class="text-sub-detail">Course Done</p>
                                        </div>
                                        <div class="sub-detail">
                                            <p class="number-sub-detail">2</p>
                                            <p class="text-sub-detail">Profil view</p>
                                        </div>
                                        <div class="sub-detail">
                                            <p class="number-sub-detail">29</p>
                                            <p class="text-sub-detail">Spent / Day</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="second-content-analitycs">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/analytics-detail.png" class="" alt="">
                                </div>
                            </div>
                            <div class="other-analytics">
                                <div class="d-flex justify-content-center">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail">22</p>
                                        <p class="text-other-detail">Articles</p>
                                    </div>
                                    <hr class="hrFirst">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail">35</p>
                                        <p class="text-other-detail">E-learning Cours</p>
                                    </div>
                                </div>
                                <hr class="hrSecond">
                                <div class="d-flex justify-content-center">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail">5</p>
                                        <p class="text-other-detail">Podcast</p>
                                    </div>
                                    <hr class="hrFirst">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail">15</p>
                                        <p class="text-other-detail">Videos Cours</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="chart">
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="tab tab-certificate">
                        <div class="card-all-certificat">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Certificat No.</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Upload Date</th>
                                    <th>Certificate</th>
                                    <th>Controls</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <p class="text-center numberCertificat">1</p>
                                    </td>
                                    <td>
                                        <p class="name-element">WordPress Certificate</p>
                                    </td>
                                    <td class="">
                                        <p class="name-element">6 April 2019</p>
                                    </td>
                                    <td>
                                        <a href="">View</a>
                                    </td>
                                    <td>
                                        <button class="btn btn-trash">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-center numberCertificat">1</p>
                                    </td>
                                    <td>
                                        <p class="name-element">WordPress Certificate</p>
                                    </td>
                                    <td class="">
                                        <p class="name-element">6 April 2019</p>
                                    </td>
                                    <td>
                                        <a href="">View</a>
                                    </td>
                                    <td>
                                        <button class="btn btn-trash">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-center numberCertificat">1</p>
                                    </td>
                                    <td>
                                        <p class="name-element">WordPress Certificate</p>
                                    </td>
                                    <td class="">
                                        <p class="name-element">6 April 2019</p>
                                    </td>
                                    <td>
                                        <a href="">View</a>
                                    </td>
                                    <td>
                                        <button class="btn btn-trash">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab tab-assessment">
                        <div class="card-all-certificat">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Questionnaire</th>
                                    <th scope="col">Upload Date</th>
                                    <th>Score</th>
                                    <th>Manage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <p class="text-center">WordPress Certificate</p>
                                    </td>
                                    <td>
                                        <p class="name-element">6 April 2019</p>
                                    </td>
                                    <td class="">
                                        <p class="name-element">18 %</p>
                                    </td>
                                    <td class="d-flex align-items-center justify-content-center">
                                        <a href="">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_eye-line.png" class="" alt="">
                                        </a>
                                        <button class="btn btn-trash">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-center">WordPress Certificate</p>
                                    </td>
                                    <td>
                                        <p class="name-element">6 April 2019</p>
                                    </td>
                                    <td class="">
                                        <p class="name-element">18 %</p>
                                    </td>
                                    <td class="d-flex align-items-center justify-content-center">
                                        <a href="">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_eye-line.png" class="" alt="">
                                        </a>
                                        <button class="btn btn-trash">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="text-center">WordPress Certificate</p>
                                    </td>
                                    <td>
                                        <p class="name-element">6 April 2019</p>
                                    </td>
                                    <td class="">
                                        <p class="name-element">18 %</p>
                                    </td>
                                    <td class="d-flex align-items-center justify-content-center">
                                        <a href="">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_eye-line.png" class="" alt="">
                                        </a>
                                        <button class="btn btn-trash">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                        </button>
                                    </td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab tab-communities">
                        <div class="content-card-communities-activity d-flex flex-wrap">
                            <div class="card-communities-activity">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                </div>
                                <div>
                                    <p class="name-community">Designer community, Dakar</p>
                                    <p class="number-members">112K Members</p>
                                </div>
                            </div>
                            <div class="card-communities-activity">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                </div>
                                <div>
                                    <p class="name-community">Designer community, Dakar</p>
                                    <p class="number-members">112K Members</p>
                                </div>
                            </div>
                            <div class="card-communities-activity">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                </div>
                                <div>
                                    <p class="name-community">Designer community, Dakar</p>
                                    <p class="number-members">112K Members</p>
                                </div>
                            </div>
                            <div class="card-communities-activity">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                </div>
                                <div>
                                    <p class="name-community">Designer community, Dakar</p>
                                    <p class="number-members">112K Members</p>
                                </div>
                            </div>
                            <div class="card-communities-activity">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                </div>
                                <div>
                                    <p class="name-community">Designer community, Dakar</p>
                                    <p class="number-members">112K Members</p>
                                </div>
                            </div>
                            <div class="card-communities-activity">
                                <div class="block-img">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/group-friends-gathering-together.jpg" class="" alt="">
                                </div>
                                <div>
                                    <p class="name-community">Designer community, Dakar</p>
                                    <p class="number-members">112K Members</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab tab-skills">
                        <div class="group-input-settings">
                            <div class="skills-activity-block">
                                <div class="content-card-skills">
                                    <?php
                                    foreach($topics as $key=>$value){
                                        $i = 0;
                                        $topic = get_the_category_by_ID($value);
                                        $note = 0;
                                        if(!$topic)
                                            continue;
                                        if(!empty($skills_note))
                                            foreach($skills_note as $skill)
                                                if($skill['id'] == $value){
                                                    $note = $skill['note'];
                                                    break;
                                                }
                                        $name_topic = (String)$topic;
                                        ?>
                                        <div class="card-skills">
                                            <div class="group position-relative">
                                                <span class="donut-chart has-big-cente"><?= $note ?></span>
                                            </div>
                                            <p class="name-course"><?= $name_topic ?></p>
                                            <div class="footer-card-skills">
                                                <button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills<?= $key ?>">Edit <i class="fa fa-edit"></i></a>
                                                    <!-- <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a> -->
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Start modal edit skills-->
                                        <div class="modal modalEdu fade" id="exampleModalSkills<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Skills</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="POST">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="group-input-settings">
                                                                        <label for="">Name</label>
                                                                        <input name="" type="text" placeholder="<?= $name_topic ?>" disabled>
                                                                        <input name="id" type="hidden" value="<?= $value ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12 skillBar-col">
                                                                    <div class="group-input-settings">
                                                                        <label for="">Kies uw vaardigheidsniveau in percentage</label>
                                                                        <div class="slider-wrapper">
                                                                            <div class="edit"></div>
                                                                        </div>
                                                                        <div class="rangeslider-wrap">
                                                                            <input name="note" type="range" min="0" max="100" step="10" labels="0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100" value="<?= $note ?>" onChange="rangeSlide(this.value)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btnSaveSetting" type="submit" name="note_skill_edit">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  End modal edit skills-->
                                        <?php
                                        $i++;
                                    }
                                    ?>

                                </div>

                                <!-- Start add skills-->
                                <div class="modal text-left modalEdu fade" id="exampleModalAddSkills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Beoordeel jouw skills</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="" method="POST">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="group-input-settings">
                                                                <label for="">Name Skill</label>
                                                                <div class="form-group formModifeChoose">
                                                                    <select name="id" id="autocomplete" class="form-control multipleSelect2">
                                                                        <?php
                                                                        foreach($tags as $tag) {
                                                                            if(in_array($tag->cat_ID, $topics))
                                                                                continue;

                                                                            echo "<option value='" . $tag->cat_ID  ."'>" . $tag->cat_name . "</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 skillBar-col">
                                                            <div class="group-input-settings">
                                                                <label for="">Kies uw vaardigheidsniveau in percentage</label>
                                                                <div class="slider-wrapper">
                                                                    <div id="skilsPercentage"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="group-input-settings">
                                                                <!-- <label for="">Uw procentuele vaardigheden</label> -->
                                                                <input type="hidden" id="SkillBar" name="note" placeholder="">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btnSaveSetting" type="submit" name="note_skill_new" >Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--  End add edit skills-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
</div>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.querySelectorAll(".filters .item").forEach(function (tab, index) {
        tab.addEventListener("click", function () {
            const filters = document.querySelectorAll(".filters .item");
            const tabs = document.querySelectorAll(".tabs__list .tab");

            filters.forEach(function (tab) {
                tab.classList.remove("active");
            });
            this.classList.add("active");

            tabs.forEach(function (tabContent) {
                tabContent.classList.remove("active");
            });
            tabs[index].classList.add("active");
        });
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>

<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>


<script src="https://rawgit.com/andreruffert/rangeslider.js/develop/dist/rangeslider.min.js"></script>

<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>

<!--  script For edit skills-->
<script>
    const edit = document.querySelector(".edit")

    var labels = { 0: 'Beginner', 10: '10%', 20: '20%', 30: '30%', 40: '40%', 50: '50%', 60: '60%', 70: '70%', 80: '80%', 90: '90%', 100: 'Expert', };
    noUiSlider.create(edit, {
        start: 10,
        connect: [true, false],

        range: {
            'min': 0,
            '10%': 10,
            '20%': 20,
            '30%': 30,
            '40%': 40,
            '50%': 50,
            '60%': 60,
            '70%': 70,
            '80%': 80,
            '90%': 90,
            'max': 100
        },
        pips: {
            mode: 'steps',
            filter: function (value, type) {
                return type === 0 ? -1 : 1;
            },
            format: {
                to: function (value) {
                    return labels[value];
                }
            }

            slide: function( event, ui ) {
                $( ".edit").html(ui.values[ 0 ]);
            });

    var SkillBarInput2 = document.getElementById('SkillBarEdit');
    edit.noUiSlider.on('update', function (values, handle, unencoded) {
        var SkillBarValue2 = values[handle];
        SkillBarInput2.value = Math.round(SkillBarValue2);
    });

    SkillBarInput2.addEventListener('change', function () {
        edit.noUiSlider.set([null, this.value]);
    });
</script>

<script>
    $('input[type="range"]').rangeslider({

        polyfill: false,

        // Default CSS classes
        rangeClass: 'rangeslider',
        disabledClass: 'rangeslider--disabled',
        horizontalClass: 'rangeslider--horizontal',
        fillClass: 'rangeslider__fill',
        handleClass: 'rangeslider__handle',

        // Callback function
        onInit: function() {
            $rangeEl = this.$range;
            // add value label to handle
            var $handle = $rangeEl.find('.rangeslider__handle');
            var handleValue = '<div class="rangeslider__handle__value">' + this.value + '</div>';
            $handle.append(handleValue);

            // get range index labels
            var rangeLabels = this.$element.attr('labels');
            rangeLabels = rangeLabels.split(', ');

            // add labels
            $rangeEl.append('<div class="rangeslider__labels"></div>');
            $(rangeLabels).each(function(index, value) {
                $rangeEl.find('.rangeslider__labels').append('<span class="rangeslider__labels__label">' + value + '</span>');
            })
        },

        // Callback function
        onSlide: function(position, value) {
            var $handle = this.$range.find('.rangeslider__handle__value');
            $handle.text(this.value);
        },

        // Callback function
        onSlideEnd: function(position, value) {}


    });
    function rangeSlide(value) {
        document.getElementById('rangeValue').innerHTML = this.value + ' %';
    }

</script>

</body>
</html>
