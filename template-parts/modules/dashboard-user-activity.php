<html lang="en">
<?php

// require_once dirname(__FILE__ , 3) . '/templates/checkout.php';

//Stripe return callback
if(isset($_GET['session_id'])):
    $status_stripe = stripe_status($_GET['session_id']);
    if(isset($status_stripe['error']))
        $message = "<p>Something wrong through the processs payment, please try again later !</p>";
    
    if(isset($status_stripe['status']))
        if($status_stripe['status'] == 'complete')
            $message = '<section id="success" class="hidden" style="background-color:white; color:green; border-radius: 2px">
                            <p>
                            We appreciate your interest in our courses ! A confirmation email will be sent to <span id="customer-email">' . $status_stripe['customer_email'] . '</span>.<br>
                            If you have any questions, please email <a href="mailto:info@livelearn.nl" style="text-decoration:underline">info@livelearn.nl</a>.
                            </p>
                        </section><br><br>';
endif;

if(!isset($message))
    $message = (isset($_GET['message'])) ? $_GET['message'] : null;
/*
* * Information user
*/
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
* * End
*/

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
* * Courses dedicated of these user "Boughts + Mandatories"
*/
$enrolled = array();
$enrolled_courses = array();
// $kennis_video = get_field('kennis_video', 'user_' . $user->ID);
$mandatory_video = get_field('mandatory_video', 'user_' . $user->ID);
$expenses = 0; 
$enrolled_stripe = array();
//Orders - enrolled courses  
$args = array(
    'customer_id' => $user->ID,
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        //Get woo orders from user
        $course_id = intval($item->get_product_id()) - 1;
        $prijs = get_field('price', $course_id);
        $expenses += $prijs; 
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}

if(!empty($enrolled))
{
    $args = array(
        'post_type' => 'course', 
        'posts_per_page' => -1,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'include' => $enrolled,  
    );
    $enrolled_courses = get_posts($args);

    //Make sure videos shared not null before to merge with enrolled
    // if(!empty($kennis_video))
    //     if(isset($kennis_video[0]))
    //         if($kennis_video[0])
    //             $enrolled_courses = array_merge($kennis_video, $enrolled_courses);

    if(!empty($enrolled_courses))
        $your_count_courses = count($enrolled_courses);
}

$typo_course = array('Artikel' => 0, 'Opleidingen' => 0, 'Podcast' => 0, 'Video' => 0);
/*
* * End
*/

//Enrolled with Stripe
$enrolled_stripe = array();
$enrolled_stripe = list_orders($user->ID)['posts'];
if(!empty($enrolled_stripe)):
    try {
        $enrolled_courses = array_merge($enrolled_stripe, $enrolled_courses);
        $your_count_courses = (!empty($enrolled_courses)) ? $your_count_courses + count($enrolled_stripe) : $your_count_courses;
    } catch (Error $e) {
        echo "";
    }
endif;

/** Mandatories **/
$args = array(
    'post_type' => 'mandatory', 
    'post_status' => 'publish',
    'author' => $user->ID,
    'posts_per_page'         => -1,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false
);
$mandatories = get_posts($args);

//Skills
$topics_external = get_user_meta($user->ID, 'topic');
$topics_internal = get_user_meta($user->ID, 'topic_affiliate');

$topics = array();
if(!empty($topics_external))
    $topics = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics, $value);
//Note
$skills_note = get_field('skills', 'user_' . $user->ID);

//Saved
$saved = get_user_meta($user->ID, 'course');

//Communities 
$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$communities = get_posts($args); 

//Stats by user profile
$users = get_users();
$profil_views = 0;   
$profil_views_by = 0;

//Profile view
$profil_views = 0;   
$args = array(
    'post_type' => 'view', 
    'post_status' => 'publish',
    'author' => $user->ID,
);
$stat_user = get_posts($args);
$stat_id = 0;
if(!empty($stat_user))
    $stat_id = $stat_user[0]->ID;

$view_user = get_field('views_user', $stat_id);
if(!empty($view_user)){
    $id_users = array_column($view_user, 'view_id');
    $id_users_count = array_count_values($id_users);
    $profil_views = count($id_users_count);
}

//Profile view by 
$redundance_profile = array(); 
foreach ($users as $element) {
    //Views  
    $args = array(
        'post_type' => 'view', 
        'post_status' => 'publish',
        'author' => $element->ID,
    );
    $views_stat_user = get_posts($args);
    $stat_id = 0;
    if(!empty($views_stat_user))
        $stat_id = $views_stat_user[0]->ID;
    $view_user = get_field('views_user', $stat_id);

    if(!empty($view_user))
        foreach($view_user as $value)
            if($value['view_id'])
                if($value['view_id'] == $user->ID && !in_array($user->ID, $redundance_profile)){
                    $profil_views_by += 1;
                    array_push($redundance_profile, $element->ID);
                }
}
//Placeholder content
$no_content = "<div class='emty-block-activity'>
                            <a class='d-block' href='#/'>
                                <div class='element-upcoming-block'>
                                    <img src='" . get_stylesheet_directory_uri() . "/img/empty-badge.png'>
                                    <p></p>
                                </div>
                            </a>
                        </div>";
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
               <img src="<?php echo get_stylesheet_directory_uri();?>/img/adv-course.png" alt="">
            </div>
        </div>
        <div class="advert-second d-block bg-bleu-luzien">
            <div class="d-flex">
                <div class="icone-course">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_folder-file.png" alt="">
                </div>
                <div class="d-block">
                    <p class="number-course">Your course</p>
                    <p class="description"><?= $your_count_courses ?></p>
                </div>
            </div>
            <p class="description-course">A courses to help you learn and acquire new skills at your own pace, on your own time</p>
        </div>
    </div>

    <div id="tab-url1">
        <?php
            echo ($message) ?: '';
        ?>
        <ul class="nav">
            <li class="nav-one"><a href="#All" class="current">All</a></li>
            <li class="nav-two"><a href="#Course">Courses</a></li>
            <li class="nav-three"><a href="#Notifications">Notifications</a></li>
            <li class="nav-four "><a href="#Data-and-analytics">Data and analytics</a></li>
            <li class="nav-five "><a href="#Certificates">Your certificates</a></li>
            <!-- <li class="nav-six "><a href="#Assessments">Assessments</a></li> -->
            <li class="nav-seven "><a href="#Communities">Communities</a></li>
            <li class="nav-eight last"><a href="#skills">Your skills</a></li>
        </ul>

        <div class="list-wrap">

            <ul id="All">
                <div class="">
                    <div class="blockItemCourse">
                        <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                            <p class="title">Courses</p>
                            <a href="?tab=Course" class="d-flex align-items-center">
                                <?php
                                if(!empty($courses))
                                    echo '<p class="seeAllText">See All</p>';
                                ?>
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                            </a>
                        </div>
                        <?php
                        if(!empty($courses)):
                        ?>    
                            <div class="card-course-activity">
                                <table class="table table-responsive">
                                    <thead>
                                    <tr>
                                        <th scope="col courseTitle">Course Title</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Instructor</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $offline = ['Opleidingen', 'Training', 'Workshop', 'Masterclass', 'Event'];
                                    foreach($enrolled_courses as $key => $course) :
                                        $bool = true;
                                        $bool = visibility($course, $visibility_company);
                                        if(!$bool)
                                            continue;

                                        //Course Type
                                        $course_type = get_field('course_type', $course->ID);
                                        
                                        //Checkout URL
                                        if(in_array($course_type, $offline))
                                            $href_checkout = "/dashboard/user/checkout-offline/?post=" . $course->post_name;
                                        else if($course_type == 'Video')
                                            $href_checkout = "/dashboard/user/checkout-video/?post=" . $course->post_name;
                                        else if($course_type == 'Podcast')
                                            $href_checkout = "/dashboard/user/checkout-podcast/?post=" . $course->post_name;
                                        else
                                            $href_checkout = "#";

                                        // Analytics
                                        switch ($course_type) {
                                            case 'Artikel':
                                                $typo_course['Artikel']++;
                                                break;
                                            case 'Opleidingen':
                                                $typo_course['Opleidingen']++;
                                                break;
                                            case 'Podcast':
                                                $typo_course['Podcast']++;
                                                break;
                                            case 'Video':
                                                $typo_course['Video']++;
                                                break;
                                        }

                                        if($key >= 4)
                                            continue;

                                        //Legend image
                                        $image_course = get_field('preview', $course->ID)['url'];
                                        if(!$image_course){
                                            $image_course = get_the_post_thumbnail_url($course->ID);
                                            if(!$image_course)
                                                $image_course = get_field('url_image_xml', $course->ID);
                                            if(!$image_course)
                                                $image_course = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                        }

                                        //Author
                                        $author = get_user_by('ID', $course->post_author);
                                        $author_name = $author->first_name ?: $author->display_name;
                                        $author_image = get_field('profile_img',  'user_' . $author->ID);
                                        $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                                        //Clock duration
                                        $duration_day = get_field('duration_day', $post->ID) ? get_field('duration_day', $post->ID) . 'days' : 'Unlimited';

                                        ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="blockImgCourse">
                                                        <img src="<?= $image_course ?>" class="" alt="">
                                                    </div>
                                                    <a href="<?= $href_checkout; ?>" class="name-element"><?= $course->post_title; ?></a>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="name-element"><?= $duration_day ?></p>
                                            </td>
                                            <td>
                                                <p class="name-element"><?= $course_type ?></p>
                                            </td>
                                            <td class=" r-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="blockImgUser">
                                                        <img src="<?= $author_image ?>" class="" alt="">
                                                    </div>
                                                    <p class="name-element"><?= $author_name ?></p>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php
                        else: 
                            echo $no_content;
                        endif;
                        ?>
                        <!-- <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                            <p class="title">Mandatories</p>
                            <a href="?tab=Course" class="d-flex align-items-center">
                                <?php
                                if(!empty($mandatories))
                                    echo '<p class="seeAllText">See All</p>';
                                ?>
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                            </a>
                        </div> -->
                        <?php
                        if(!empty($mandatories)):
                        if($_GET['message']) echo "<span class='alert alert-info'>" . $_GET['message'] . "</span>" ?><br><br><br>
                        <div class="card-course-activity">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Mandatories</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $offline = ['Opleidingen', 'Training', 'Workshop', 'Masterclass', 'Event'];
                                $i = 0;
                                foreach($mandatories as $key => $value) :
                                    $course = get_page_by_path($value->post_title, OBJECT, 'course');
                                    if(!$course)
                                        continue;

                                    $bool = true;
                                    $bool = visibility($course, $visibility_company);
                                    if(!$bool)
                                        continue;

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);

                                    //Checkout URL
                                    if(in_array($course_type, $offline))
                                        $href_checkout = "/dashboard/user/checkout-offline/?post=" . $course->post_name . "&man=";
                                    else if($course_type == 'Video')
                                        $href_checkout = "/dashboard/user/checkout-video/?post=" . $course->post_name . "&man=";
                                    else if($course_type == 'Podcast')
                                        $href_checkout = "/dashboard/user/checkout-podcast/?post=" . $course->post_name . "&man=";
                                    else
                                        $href_checkout = "#";

                                    // Analytics
                                    switch ($course_type) {
                                        case 'Artikel':
                                            $typo_course['Artikel']++;
                                            break;
                                        case 'Opleidingen':
                                            $typo_course['Opleidingen']++;
                                            break;
                                        case 'Podcast':
                                            $typo_course['Podcast']++;
                                            break;
                                        case 'Video':
                                            $typo_course['Video']++;
                                            break;
                                    }

                                    //Legend image
                                    $image_course = get_field('preview', $course->ID)['url'];
                                    if(!$image_course){
                                        $image_course = get_the_post_thumbnail_url($course->ID);
                                        if(!$image_course)
                                            $image_course = get_field('url_image_xml', $course->ID);
                                        if(!$image_course)
                                            $image_course = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Author
                                    $author = get_user_by('ID', $course->post_author);
                                    $author_name = $author->first_name ?: $author->display_name;
                                    $author_image = get_field('profile_img',  'user_' . $author->ID);
                                    $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                                    //Clock duration
                                    $duration_day = get_field('duration_day', $post->ID) ? get_field('duration_day', $post->ID) . 'days' : 'Unlimited';

                                    //Get read by user
                                    $args = array(
                                        'post_type' => 'progression',
                                        'title' => $course->post_name,
                                        'post_status' => 'publish',
                                        'author' => $user->ID,
                                        'posts_per_page'         => 1,
                                        'no_found_rows'          => true,
                                        'ignore_sticky_posts'    => true,
                                        'update_post_term_cache' => false,
                                        'update_post_meta_cache' => false
                                    );
                                    $progressions = get_posts($args);
                                    $is_finish = 0;
                                    if(!empty($progressions)){
                                        $progression_id = $progressions[0]->ID;
                                        //Finish read
                                        $is_finish = get_field('state_actual', $progression_id);
                                    }
                                    $style_mandatory = "";
                                    if($is_finish)
                                        $style_mandatory = '✅';

                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image_course ?>" class="" alt="">
                                                </div>
                                                <a href="<?= $href_checkout; ?>" class="name-element"><?= $course->post_title; ?>&nbsp;&nbsp;<?= $style_mandatory ?></a>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="name-element"><?= $duration_day ?></p>
                                        </td>
                                        <td class=" r-1">
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgUser">
                                                    <img src="<?= $author_image ?>" class="" alt="">
                                                </div>
                                                <p class="name-element"><?= $author_name ?></p>
                                            </div>

                                        </td>
                                    </tr>
                                <?php
                                $i += 1; 
                                if($i >= 4)
                                    break;
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        else: 
                            echo $no_content;
                        endif;
                        ?>
                    </div>
                    <div class="blockItemCourse notificationCourseCard">
                        <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                            <p class="title">Notifications</p>
                            <a href="?tab=Notifications" class="d-flex align-items-center">
                                <?php 
                                    if(!empty($notifications)) :
                                ?>
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                <?php
                                endif;
                                ?>
                            </a>
                        </div>
                        <div class="contentActivity">
                            <div class="cardFavoriteCourses text-left cardAlert">
                                <div class="d-flex aligncenter justify-content-between">
                                    <h2>My Alerts</h2>
                                    <!-- <input type="search" placeholder="search" class="inputSearchCourse" id="search_activity_notification"> -->
                                    <input id="search_activity_notification" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Search" aria-label="Search" >
                                </div>
                                <?php
                                if(!empty($todos)):
                                ?>
                                    <div class="contentCardListeCourse">
                                        <table class="table table-responsive table-responsive tableNotification">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Type</th>
                                                <th scope="col-4">Alert </th>
                                                <th scope="col">By</th>
                                                <!-- <th scope="col">Optie</th> -->
                                            </tr>
                                            </thead>
                                            <tbody id="autocomplete_activity_notification">
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
                                                if($key >= 4)
                                                    continue;

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
                                                    <td class="content-title-notification"><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>"> <strong><?=$todo->post_title;?></strong> </a></td>
                                                    <td><?=$type?></td>
                                                    <td class="descriptionNotification"><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>"><?=$beschrijving_feedback?> </a></td>
                                                    <td><?= $manager_display; ?></td>
                                                    <!--
                                                    <td class="textTh">
                                                        <div class="dropdown text-white">
                                                            <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                                                <img  style="width:20px"
                                                                    src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                            </p>
                                                            <ul class="dropdown-menu">
                                                                <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>">Bekijk</a></li>
                                                                <li class="my-1" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="<?= $course->ID; ?>" value="Verwijderen"/></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    -->
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            </tbody>
                                        </table>
                                    </div>
                                <?php
                                else: 
                                    echo $no_content;
                                endif;
                                ?>
                            </div>

                        </div>
                    </div>
                    <div class="data-analitycs-block">
                        <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                            <p class="title">Data and analytics</p>
                            <a href="?tab=Data-and-analytics" class="d-flex align-items-center">
                                <p class="seeAllText">See All</p>
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                            </a>
                        </div>
                        <div class="content-data-analytics d-flex flex-wrap align-items-center justify-content-between">
                            <div class="analytics-block">
                                <div class="first-content-analitycs text-left">
                                    <p class="title-block">Analytics</p>
                                    <p class="spent-text"> <b><?= $expenses ?>€</b> spent since the beginning of the adventure</p>
                                    <div class="detail-analytic">
                                        <div class="sub-detail">
                                            <p class="number-sub-detail"><?= $profil_views ?></p>
                                            <p class="text-sub-detail">Profil view</p>
                                        </div>
                                        <div class="sub-detail">
                                            <p class="number-sub-detail">0</p>
                                            <p class="text-sub-detail">Course Done</p>
                                        </div>
                                        <div class="sub-detail">
                                            <p class="number-sub-detail"><?= $profil_views_by ?></p>
                                            <p class="text-sub-detail">My Profil view by </p>
                                        </div>
                                        <!-- <div class="sub-detail">
                                            <p class="number-sub-detail">29</p>
                                            <p class="text-sub-detail">Spent / Day</p>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="second-content-analitycs">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/analytics-detail.png" class="" alt="">
                                </div>
                            </div>
                            <div class="other-analytics">
                                <div class="d-flex justify-content-center">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail"><?= $typo_course['Artikel']; ?></p>
                                        <p class="text-other-detail">Articles</p>
                                    </div>
                                    <hr class="hrFirst">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail"><?= $typo_course['Opleidingen']; ?></p>
                                        <p class="text-other-detail">Opleidingen</p>
                                    </div>
                                </div>
                                <hr class="hrSecond">
                                <div class="d-flex justify-content-center">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail"><?= $typo_course['Podcast']; ?></p>
                                        <p class="text-other-detail">Podcast</p>
                                    </div>
                                    <hr class="hrFirst">
                                    <div class="detail-other-analytics">
                                        <p class="number-other-detail"><?= $typo_course['Video']; ?></p>
                                        <p class="text-other-detail">Videos</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="blockYourCertificates block-activity-">
                        <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                            <p class="title">Your certificates</p>
                            <!--
                                <a href="/?tab=Certificates" class="d-flex align-items-center">
                                    <p class="seeAllText">See All</p>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                                </a>
                                -->
                        </div>
                        <div class="card-all-certificat card-activity-">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Certificat No.</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Upload Date</th>
                                    <!-- <th>Certificate</th> -->
                                    <!-- <th>Controls</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $strotime_date = strtotime($user->user_registered);
                                $date_registered = date("d M Y", $strotime_date);
                                ?>

                                <tr>
                                    <td>
                                        <p class="text-center numberCertificat">0</p>
                                    </td>
                                    <td>
                                        <p class="name-element">Join the family !</p>
                                    </td>
                                    <td class="">
                                        <p class="name-element"><?= $date_registered ?></p>
                                    </td>
                                    <!--
                                            <td>
                                                <a href="#">View</a>
                                            </td>
                                            <td>
                                                <button class="btn btn-trash">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                                </button>
                                            </td>
                                        -->
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--
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
                        -->
                    <div class="skills-activity-block">
                        <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                            <p class="title">Skills</p>
                            <a href="?tab=skills" class="d-flex align-items-center">
                                <p class="seeAllText">See All</p>
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/seeAllIcon.png" class="" alt="">
                            </a>
                        </div>
                        <div class="content-card-skills">
                            <?php
                            foreach($topics as $key=>$value){
                                if(!$value || is_wp_error(!$value))
                                    continue;

                                $i = 0;
                                $topic = get_the_category_by_ID($value);
                                $note = 0;
                                if(!$topic && $key < 4)
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
                                        <!--<button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills<?php /*= $key */?>">Edit <i class="fa fa-edit"></i></a>
                                                      <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a>
                                            </div>-->
                                        <a href="/dashboard/user/settings/"><i class="fa fa-gear"></i></a>
                                    </div>
                                </div>

                                <?php
                                $i++;
                            }
                            ?>

                        </div>

                    </div>
                    <div class="content-card-communities-activity">
                        <div class="d-flex align-items-center justify-content-between head-blockItemCourse">
                            <p class="title">Communities</p>
                        </div>
                        <div class="content-card-communities-activity d-flex flex-wrap">
                            <?php
                            $i = 0;
                            foreach($communities as $key => $value):
                                if(!$value)
                                    continue;

                                $company = get_field('company_author', $value->ID);
                                $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                                $community_image = get_field('image_community', $value->ID) ?: $company_image;

                                //Courses through custom field
                                $courses = get_field('course_community', $value->ID);
                                $max_course = 0;
                                if(!empty($courses))
                                    $max_course = count($courses);

                                //Followers
                                $max_follower = 0;
                                $followers = get_field('follower_community', $value->ID);
                                if(!empty($followers))
                                    $max_follower = count($followers);
                                $bool = false;
                                foreach ($followers as $key => $val)
                                    if($val->ID == $user_id){
                                        $bool = true;
                                        break;
                                    }

                                $access_community = "";
                                if(!$bool)
                                    continue;
                                else
                                    $access_community = '/dashboard/user/community-detail/?mu=' . $value->ID ;

                                if($i == 6)
                                    break;
                                $i++;

                                ?>
                                <a href="<?= $access_community?>"  class="card-communities-activity">
                                    <div class="block-img">
                                        <img src="<?= $community_image ?>" class="" alt="">
                                    </div>
                                    <div>
                                        <p class="name-community"><?= $value->post_title ?>, Netherlands</p>
                                        <p class="number-members"><?= $max_follower ?> Members</p>
                                    </div>
                                </a>
                            <?php
                            endforeach;
                            if(!$i)
                                echo $no_content;
                            ?>
                        </div>
                    </div>
                </div>
            </ul>

            <ul id="Course" class="hide">
                <div class="tab-course">
                    <div class="blockItemCourse">
                        <?php
                        if(!empty($enrolled_courses)):
                        ?>
                        <div class="card-course-activity">
                            <div class="head-card d-flex justify-content-between align-items-center">
                                <input id="search_activity_course" class="form-control InputDropdown1 mr-sm-2 inputSearch2" type="search" placeholder="Zoek" aria-label="Zoek" >
                            </div>
                            <table class="table table-responsive text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Course Title</th>
                                    <th scope="col courseTitle">Type</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Instructor</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Favorite</th>
                                    <!-- <th scope="col">Action</th> -->
                                </tr>
                                </thead>
                                <tbody id="autocomplete_activity_course" class="text-left">
                                <?php
                                foreach($enrolled_courses as $key => $course) :
                                    $bool = true;
                                    $bool = visibility($course, $visibility_company);
                                    if(!$bool)
                                        continue;

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);

                                    //Checkout URL
                                    if(in_array($course_type, $offline))
                                        $href_checkout = "/dashboard/user/checkout-offline/?post=" . $course->post_name;
                                    else if($course_type == 'Video')
                                        $href_checkout = "/dashboard/user/checkout-video/?post=" . $course->post_name;
                                    else if($course_type == 'Podcast')
                                        $href_checkout = "/dashboard/user/checkout-podcast/?post=" . $course->post_name;
                                    else
                                        $href_checkout = "#";

                                    //Legend image
                                    $image_course = get_field('preview', $course->ID)['url'];
                                    if(!$image_course){
                                        $image_course = get_the_post_thumbnail_url($course->ID);
                                        if(!$image_course)
                                            $image_course = get_field('url_image_xml', $course->ID);
                                        if(!$image_course)
                                            $image_course = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Author
                                    $author = get_user_by('ID', $course->post_author);
                                    $author_name = $author->first_name ?: $author->display_name;

                                    //Clock duration
                                    $duration_day = get_field('duration_day', $post->ID) ? get_field('duration_day', $post->ID) . 'days' : 'Unlimited';

                                    //Button like
                                    $button_render = (in_array($course->ID, $saved)) ? '<i class="fa fa-heart mr-4"></i>' : '<i class="fa fa-heart-o mr-4"></i>';

                                    //Color
                                    // $color_done = "green";
                                    // $color_progress = "#ff9b00";
                                    // $color_new = "#043356";

                                    /* * State actual details * */
                                    //Color
                                    $text_status = "New";
                                    $status_color = "#043356";
                                    //Get read by user 
                                    $args = array(
                                        'post_type' => 'progression', 
                                        'title' => $course->post_name,
                                        'post_status' => 'publish',
                                        'author' => $user->ID,
                                        'posts_per_page'         => 1,
                                        'no_found_rows'          => true,
                                        'ignore_sticky_posts'    => true,
                                        'update_post_term_cache' => false,
                                        'update_post_meta_cache' => false
                                    );
                                    $progressions = get_posts($args);
                                    if(!empty($progressions)){
                                        $status_color = "#ff9b00";
                                        $text_status = "In progress";
                                        $progression_id = $progressions[0]->ID;
                                        //Finish read
                                        $is_finish = get_field('state_actual', $progression_id);
                                        if($is_finish){
                                            $status_color = "green";
                                            $text_status = "Done";
                                        }
                                    }

                                    ?>
                                    <tr>
                                        <td >
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image_course ?>" class="" alt="">
                                                </div>
                                                <a href="<?= $href_checkout; ?>" class="name-element"><?= $course->post_title ?></>
                                            </div>
                                        </td>
                                        <td> <p class="name-element"><?= $course_type ?></p> </td>
                                        <td>
                                            <p class="name-element"><?= $duration_day; ?></p>
                                        </td>
                                        <td class="">
                                            <p class="name-element"><?= $author_name ?></p>
                                        </td>
                                        <td>
                                            <p class="text-left" style="color: <?= $status_color ?>" > <?= $text_status ?> </p>
                                        </td>
                                        <td>
                                            <?= $button_render; ?>
                                        </td>
                                        <!--
                                        <td>
                                            <i class="fa fa-trash mr-4" style="color: red;"></i>
                                        </td>
                                        -->
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        else: 
                            echo $no_content;
                        endif;
                        ?>
                    </div>
                </div>
            </ul>

            <ul id="Notifications" class="hide">
                <div class="text-left tab-notification">
                    <div class="contentActivity">
                        <div class="cardFavoriteCourses text-left cardAlert">
                            <div class="d-flex aligncenter justify-content-between">
                                <h2>My Alerts</h2>
                                <input type="search" placeholder="search" class="inputSearchCourse">
                            </div>
                            <?php
                            if(!empty($todos)):
                            ?>
                            <div class="contentCardListeCourse">
                                <table class="table table-responsive table-responsive tableNotification">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Type</th>
                                        <th scope="col-4">Alert </th>
                                        <th scope="col">By</th>
                                        <!-- <th scope="col">Optie</th> -->
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
                                            <td class="content-title-notification"><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>"> <strong><?=$todo->post_title;?></strong> </a></td>
                                            <td><?=$type?></td>
                                            <td class="descriptionNotification"><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>"><?=$beschrijving_feedback?> </a></td>
                                            <td><?= $manager_display; ?></td>
                                            <!--
                                                <td class="textTh">
                                                    <div class="dropdown text-white">
                                                        <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                                            <img  style="width:20px"
                                                                  src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                        </p>
                                                        <ul class="dropdown-menu">
                                                            <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>">Bekijk</a></li>
                                                            <li class="my-1" id="live"><i class="fa fa-trash px-2"></i><input type="button" id="<?= $course->ID; ?>" value="Verwijderen"/></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                -->
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                            <?php
                            else: 
                                echo $no_content;
                            endif;
                            ?>
                        </div>

                    </div>

                </div>
            </ul>

            <ul id="Data-and-analytics" class="hide">
                <div  class="tab-analytics">
                    <div class="content-data-analytics d-flex flex-wrap align-items-center justify-content-between">
                        <div class="analytics-block">
                            <div class="first-content-analitycs text-left">
                                <p class="title-block">Analytics</p>
                                <p class="spent-text"> <b><?= $expenses ?>€</b> spent since the beginning of the adventure</p>
                                <div class="detail-analytic">
                                    <div class="sub-detail">
                                        <p class="number-sub-detail"><?= $profil_views ?></p>
                                        <p class="text-sub-detail">Profil view</p>
                                    </div>
                                    <div class="sub-detail">
                                        <p class="number-sub-detail">0</p>
                                        <p class="text-sub-detail">Course Done</p>
                                    </div>
                                    <div class="sub-detail">
                                        <p class="number-sub-detail"><?= $profil_views_by ?></p>
                                        <p class="text-sub-detail">My Profil view by </p>
                                    </div>
                                    <!-- <div class="sub-detail">
                                        <p class="number-sub-detail">29</p>
                                        <p class="text-sub-detail">Spent / Day</p>
                                    </div> -->
                                </div>
                            </div>
                            <div class="second-content-analitycs">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/analytics-detail.png" class="" alt="">
                            </div> 
                        </div>
                        <div class="other-analytics">
                            <div class="d-flex justify-content-center">
                                <div class="detail-other-analytics">
                                    <p class="number-other-detail"><?= $typo_course['Artikel']; ?></p>
                                    <p class="text-other-detail">Articles</p>
                                </div>
                                <hr class="hrFirst">
                                <div class="detail-other-analytics">
                                    <p class="number-other-detail"><?= $typo_course['Opleidingen']; ?></p>
                                    <p class="text-other-detail">Opleindingen</p>
                                </div>
                            </div>
                            <hr class="hrSecond">
                            <div class="d-flex justify-content-center">
                                <div class="detail-other-analytics">
                                    <p class="number-other-detail"><?= $typo_course['Podcast']; ?></p>
                                    <p class="text-other-detail">Podcast</p>
                                </div>
                                <hr class="hrFirst">
                                <div class="detail-other-analytics">
                                    <p class="number-other-detail"><?= $typo_course['Video']; ?></p>
                                    <p class="text-other-detail">Videos</p>
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
            </ul>

            <ul id="Certificates" class="hide">
                <div  class="tab-certificate">
                    <div class="card-all-certificat">
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col courseTitle">Certificat No.</th>
                                <th scope="col">Title</th>
                                <th scope="col">Upload Date</th>
                                <!--
                                <th>Certificate</th>
                                <th>Controls</th>
                                -->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $strotime_date = strtotime($user->user_registered);
                            $date_registered = date("d M Y", $strotime_date);
                            ?>

                            <tr>
                                <td>
                                    <p class="text-center numberCertificat">0</p>
                                </td>
                                <td>
                                    <p class="name-element">Join the family !</p>
                                </td>
                                <td class="">
                                    <p class="name-element"><?= $date_registered ?></p>
                                </td>
                                <!--
                                    <td>
                                        <a href="">View</a>
                                    </td>
                                    <td>
                                        <button class="btn btn-trash">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/clarity_trash-line.png" class="" alt="">
                                        </button>
                                    </td>
                                    -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </ul>

            <ul id="Assessments" class="hide">
                <!-- <div class="tab-assessment">
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
                    </div> -->
            </ul>

            <ul id="Communities" class="hide">
                <div class="tab-communities">
                    <div class="content-card-communities-activity d-flex flex-wrap">
                        <?php

                        $i = 0;
                        foreach($communities as $key => $value):
                            if(!$value)
                                continue;

                            $company = get_field('company_author', $value->ID);
                            $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                            $community_image = get_field('image_community', $value->ID) ?: $company_image;

                            //Courses through custom field
                            $courses = get_field('course_community', $value->ID);
                            $max_course = 0;
                            if(!empty($courses))
                                $max_course = count($courses);

                            //Followers
                            $max_follower = 0;
                            $followers = get_field('follower_community', $value->ID);
                            if(!empty($followers))
                                $max_follower = count($followers);
                            $bool = false;
                            foreach ($followers as $key => $val)
                                if($val->ID == $user_id){
                                    $bool = true;
                                    break;
                                }

                            $access_community = "";
                            if(!$bool)
                                continue;
                            else
                                $access_community = '/dashboard/user/community-detail/?mu=' . $value->ID ;

                            $i+=1;

                            ?>
                            <a href="<?= $access_community?>" class="card-communities-activity">
                                <div class="block-img">
                                    <img src="<?= $community_image ?>" class="" alt="">
                                </div>
                                <div>
                                    <p class="name-community"><?= $value->post_title ?>, Netherlands</p>
                                    <p class="number-members"><?= $max_follower ?> Members</p>
                                </div>
                            </a>
                        <?php
                        endforeach;

                        if(!$i)
                            echo $no_content;
                        ?>
                    </div>
                </div>
            </ul>

            <ul id="skills" class="hide">
                <div class="tab-skills">
                    <div class="group-input-settings">
                        <div class="skills-activity-block">
                            <?php
                            if(!empty($topics)):
                            ?>
                            <div class="content-card-skills">
                                <?php
                                foreach($topics as $key=>$value){
                                    if(!$value || is_wp_error(!$value))
                                        continue;

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
                                            <!--<button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills<?php /*= $key */?>">Edit <i class="fa fa-edit"></i></a>
                                                      <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a>
                                            </div>-->
                                            <a href="/dashboard/user/settings/"><i class="fa fa-gear"></i></a>
                                        </div>
                                    </div>

                                    <?php
                                    $i++;
                                }
                                ?>
                            </div>
                            <?php
                            else: 
                                echo $no_content;
                            endif;
                            ?>
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
            </ul>

        </div> <!-- END List Wrap -->

    </div>

</div>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/organictabs.jquery.js"></script>
<script>
    $(function() {

        // Calling the plugin
        $("#tab-url1").organicTabs();

    });
</script>

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

<!--  script For edit skills-->
<!--
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
-->

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

<script>
    $('#search_activity_notification').keyup(function(){
        var txt = $(this).val();
        $.ajax({
            url:"/fetch-activity-notification",
            method:"post",
            data:{
                search_activity_notification : txt,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete_activity_notification').html(data);
            }
        });

    });
</script>

<script>
     $('#search_activity_course').keyup(function(){
        var txt = $(this).val();

        $.ajax({
            url:"/fetch-activity-course",
            method:"post",
            data:{
                search_activity_course : txt,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete_activity_course').html(data);
            }
        });

    });
</script>

</body>
</html>
