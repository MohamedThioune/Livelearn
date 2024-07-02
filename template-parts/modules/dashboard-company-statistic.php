<?php

/* Information user */
$current_user = wp_get_current_user();
$full_name_user = ($current_user->first_name) ? $current_user->first_name . ' ' . $current_user->last_name : $current_user->display_name;
$image = get_field('profile_img',  'user_' . $current_user->ID);
global $wpdb;
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/placehoder_user.png';

$company = get_field('company',  'user_' . $current_user->ID);
if(!empty($company))
    $company_name = $company[0]->post_title;

$company_connected = $company[0]->post_title;

$date_format = date_create($current_user->user_registered);
$year_date_registered = date_format($date_format, "Y");

$users = get_users();
$numbers = array(); 
$members = array();
$numbers_count = array();

$topic_views = array();
$topic_followed = array();

$assessment_validated = array();
$count_mandatories_video = 0;
$numbers = get_field('managed' ,'user_' . $current_user->ID);
$numbers = array_map('intval', $numbers);
foreach ($users as $user ) {
    if($user->ID  == $current_user->ID)
        continue;

    $company = get_field('company',  'user_' . $user->ID);

    if(!empty($company))
        if($company[0]->post_title == $company_connected)
        {
            $topic_by_user = array();
            $course_by_user = array();

            // Object member
            array_push($members,$user);
            
            //Followed topic
        
            //Stats engagement

        }
}
$count_members = count($members);

/* Mandatories */
$args = array(
    'post_type' => 'mandatory', 
    'post_status' => 'publish',
    'author__in' => $current_user->ID,
    'posts_per_page'         => -1,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false
);
$mandatories = get_posts($args);
$count_mandatories_video = (!empty($mandatories)) ? count($mandatories) : 0;
/*
* * Courses dedicated of these user "Boughts + Mandatories"
*/
$enrolled = array();
$enrolled_courses = array();
$enrolled_all_courses = array();
$expenses = 0;

$progress_courses = array(
    'not_started' => 0,
    'in_progress' => 0,
    'done' => 0,
);
$course_finished = array();

//Orders - enrolled courses 
$budget_spent = 0;  
$args = array(
    'customer_id' => $current_user->ID,
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);
foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $progressions = array();

        //Get woo orders from user
        $course_id = intval($item->get_product_id()) - 1;
        $course = get_post($course_id);

        $prijs = get_field('price', $course_id);
        $budget_spent += $prijs; 
        // array_push($enrolled_all_courses, $course_id);
        if(!in_array($course_id, $enrolled)){
            array_push($enrolled, $course_id);
            array_push($enrolled_courses, $course);
            //Get progresssion this course 
            $args = array(
                'post_type' => 'progression', 
                'title' => $course->post_name,
                'post_status' => 'publish',
                'author' => $current_user->ID,
                'posts_per_page'         => 1,
                'no_found_rows'          => true,
                'ignore_sticky_posts'    => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false
            );
            $progressions = get_posts($args);
            $status = "new";
            if(!empty($progressions)){
                $status = "in_progress";
                $progression_id = $progressions[0]->ID;
                //Finish read
                $is_finish = get_field('state_actual', $progression_id);
                if($is_finish)
                    $status = "done";
            }

            switch ($status) {

                case 'new':
                    $progress_courses['not_started'] += 1;
                    break;

                case 'in_progress':
                    $progress_courses['in_progress'] += 1;
                    break;

                case 'done':
                    $progress_courses['done'] += 1;
                    //course finished 
                    array_push($course_finished, $course->ID);
                    break;                           
            }
                
        }
    }
}
$budget_spent = '€ ' . number_format($budget_spent, 2, '.', ',');

$count_enrolled_courses = (!empty($enrolled_courses)) ? count($enrolled_courses) : 0;

$course_not_started = $progress_courses['not_started'];
$course_in_progress = $progress_courses['in_progress'];
$course_done =  $progress_courses['done'];

$progress_courses['not_started'] = $count_enrolled_courses - ($progress_courses['in_progress'] + $progress_courses['done']);
if($count_enrolled_courses > 0){
    $progress_courses['not_started'] = intval(($progress_courses['not_started'] / $count_enrolled_courses) * 100);
    $progress_courses['in_progress'] = intval(($progress_courses['in_progress'] / $count_enrolled_courses) * 100);
    $progress_courses['done'] = intval(($progress_courses['done'] / $count_enrolled_courses) * 100);
}
else
    $progress_courses['not_started'] = 100;
$count_course_finished = count($course_finished);

/* Assessment */
$args = array(
    'post_type' => 'assessment',
    'post_status' => 'publish',
    'author' => $current_user->ID,
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$assessments_created = get_posts($args);
$count_assessments_created = (!empty($assessments_created)) ? count($assessments_created
) : 0;

$validated = get_user_meta($current_user->ID, 'assessment_validated');
foreach($validated as $assessment)
    if(!in_array($assessment, $assessment_validated))
        array_push($assessment_validated, $assessment);

$args = array(
    'post_type' => 'assessment',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$assessments = get_posts($args);
$count_assessments = count($assessments);
$assessment_validated = (!empty($assessment_validated)) ? count($assessment_validated) : 0;
$assessment_not_started = 100;
$assessment_completed = 0;
$members_active = rand(1,10);
$members_inactive = rand(1,10);
if($count_assessments > 0){
    $not_started_assessment = $count_assessments - $assessment_validated;
    $assessment_not_started = intval(($not_started_assessment / $count_assessments) * 100);
    $assessment_completed = intval(($assessment_validated / $count_assessments) * 100);
}

//Topic views 
$table_tracker_views = $wpdb->prefix . 'tracker_views';
$sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id = " . $current_user->ID . " AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
$topic_views = $wpdb->get_results($sql);

//Show link by scope 
$status_content_link = "";
if(isset($company_name))
    $status_content_link .= '<li class="nav-one"><a href="/dashboard/company/statistic-company">Company</a></li>';

$is_manager = get_field('manager', 'user_' . $current_user->ID);
if(in_array('administrator', $current_user->roles) || in_array('hr', $current_user->roles) || in_array('manager', $current_user->roles) || $is_manager )
    $status_content_link .= '<li class="nav-two"><a href="/dashboard/company/statistic-team"> Team </a></li>' ;
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>

<div class="content-new-statistic" id="tab-url1">
    <div class="d-flex justify-content-between flex-wrap">
        <div class="profil-view-statistic d-flex">
            <div class="img-user">
                <img src="<?= $image ?>" alt="">
            </div>
            <div>
                <p class="name-profil-view"><?= $full_name_user ?></p>
                <p class="date-register">Since <?= $year_date_registered ?></p>
            </div>
        </div>
        <div class="tab-element">
            <ul class="nav">
                <?php
                    echo $status_content_link ;
                ?>
                <li class="nav-three"><a href="/dashboard/company/statistic/" class="current">Individual</a></li>
            </ul>
        </div>
    </div>

    <div class="body-content-view-statistic">
        <div id="Team" class="individualContent">
            <div class="subTopics-usage-block d-flex flex-wrap justify-content-between">
                <div class="block-individual-element">
                    <div class="group-card-head d-flex flex-wrap justify-content-between">
                        <div class="card-element-company d-flex align-items-center ">
                            <div class="content-fa bg-2yellow-c">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-money.png" alt="">
                            </div>
                            <div>
                                <p class="total-member">Budget spent</p>
                                <p class="number-members"><?= $budget_spent ?></p>
                            </div>
                        </div>
                        <div class="card-element-company d-flex align-items-center ">
                            <div class="content-fa bg-yellow-c">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-actif.png" alt="">
                            </div>
                            <div>
                                <p class="total-member">Course in progress</p>
                                <p class="number-members"><?= $course_in_progress ?></p>
                            </div>
                        </div>
                        <div class="card-element-company d-flex align-items-center ">
                            <div class="content-fa bg-purple-c">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-allCourse.png" alt="">
                            </div>
                            <div>
                                <p class="total-member">Your Courses </p>
                                <p class="number-members"><?= $count_enrolled_courses ?></p>
                            </div>
                        </div>
                        <div class="card-element-company d-flex align-items-center ">
                            <div class="content-fa bg-green-c">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-courseDone.png" alt="">
                            </div>
                            <div>
                                <p class="total-member">Course Done</p>
                                <p class="number-members"><?= $course_done?></p>
                            </div>
                        </div>
                        <div class="card-element-company d-flex align-items-center ">
                            <div class="content-fa bg-bleuLight-c">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-assessment.png" alt="">
                            </div>
                            <div>
                                <p class="total-member">Assessment (created)</p>
                                <p class="number-members"><?= $count_assessments_created ?></p>
                            </div>
                        </div>
                        <div class="card-element-company d-flex align-items-center ">
                            <div class="content-fa bg-dark-c">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-team-mandatory.png" alt="">
                            </div>
                            <div>
                                <p class="total-member">Mandatories (received)</p>
                                <p class="number-members"><?= $count_mandatories_video ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if(!empty($topic_views)):
                ?>
                    <div class="subTopics-card">
                        <p class="title">Most Topics view by yourself</p>
                        <p class="number-subTopcis"><?= $count_topic_views ?></p>
                        <p class="sub-title-topics">SubTopics</p>
                        <?php
                        foreach($topic_views as $topic):
                        $value = $topic->data_id;
                        $occurence = $topic->occurence;
                        $name_topic = (String)get_the_category_by_ID($value);
                        $image_topic = get_field('image', 'category_'. $value);
                        $image_topic = $image_topic ? $image_topic : get_stylesheet_directory_uri() . '/img/placeholder.png';
                        ?>
                        <a href="/category-overview?category=<?= $value ?>" class="element-SubTopics d-flex justify-content-between">
                            <div class="d-flex">
                                <div class="imgTopics">
                                    <img src="<?= $image_topic ?>" alt="">
                                </div>
                                <p class="text-subTopics"><?= $name_topic ?></p>
                            </div>
                            <p class="number"><?= $occurence ?></p>
                        </a>
                        <?php
                        endforeach
                        ?>
                    </div>
                <?php
                endif;
                ?>
            </div>

            <div class="block-circular-bar">
                <div class="card-circular-bar">
                    <div class="head d-flex justify-content-between align-items-center">
                        <h2>User Engagement:</h2>
                        <!-- 
                        <select class="form-select" aria-label="Default select example">
                            <option value="Month">Januari</option>
                            <option value="year">Februari</option>
                            <option value="week">Maart</option>
                        </select> -->
                    </div>
                    <div>
                         <canvas id="ChartEngagement"></canvas>
                        <!-- <span>No data enough !</span> -->
                    </div>
                </div>
                <div class="card-circular-bar">
                    <div class="head d-flex justify-content-between align-items-center">
                    <h2 >User progress in the courses <span>(<?= $count_enrolled_courses ?>) :</span></h2>
                    </div>
                    <div>
                        <canvas id="ChartCourse"></canvas>
                    </div>
                </div>
                <div class="card-circular-bar">
                    <div class="head d-flex justify-content-between align-items-center">
                    <h2 class="title-card-statistic">Assessment <span>(<?= $count_assessments ?>)</span> :</h2>
                    </div>
                    <div>
                        <canvas id="ChartAssessment"></canvas>
                    </div>
                </div>
            </div>
            <!-- <div class="usage-block-card">
                <canvas id="chartsGroup"></canvas>
            </div> -->
            <?php
            if(!empty($members)):
            ?>
            <div class="card-course card-user-team">
                <h2>Others Members</h2>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col courseTitle w-40">Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Status</th>
                        <!-- <th scope="col">Persoonsgebonden Budget</th> -->
                        <!-- <th scope="col">Actions</th> -->
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($members as $key => $user):
                        $image_user = get_field('profile_img',  'user_' . $user->ID);
                        if(!$image_user)
                            $image_user = get_stylesheet_directory_uri(). "/img/placeholder_user.png";

                        $full_name_user = ($user->first_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name;
                        
                        $department = get_field('department', 'user_' . $user->ID);

                        //$is_login = get_field('is_first_login', 'user_' . $user->ID);
                        $is_login = false;

                        $date = new DateTime();
                        $date_this_month = $date->format('Y-m-d');
                        $date_last_month = $date->sub(new DateInterval('P2M'))->format('Y-m-d');
                        $table_tracker_views = $wpdb->prefix . 'tracker_views';
                        $sql = $wpdb->prepare("SELECT * FROM $table_tracker_views WHERE user_id = ".$user->ID." AND updated_at BETWEEN '".$date_last_month."' AND '".$date_this_month."'");
                        $if_user_actif = count($wpdb->get_results($sql));

                        if ($if_user_actif)
                            $is_login = true;

                        //$status = ($is_login) ? 'actif' : 'actif inactif';
                        //$status_text = ($is_login) ? 'Active' : 'Inactive';
                        if ($is_login) {
                            $status_text = 'Active';
                            $members_active++;
                            $status = 'actif';
                        }
                        else {
                            $status_text = 'Inactive';
                            $members_inactive++;
                            $status = 'actif inactif';
                        }

                        $link = "/dashboard/company/profile/?id=" . $user->ID . '&manager='. $current_user->ID;
                        
                        $amount_budget_format = get_field('amount_budget', 'user_' . $user->ID) ? : 0;
                        $amount_budget = number_format($amount_budget_format, 2, '.', ',');

                        ?>
                        <tr>
                            <td class="d-flex align-items-center"> 
                                <div class="userImg">
                                    <a href="<?= $link ?>"> <img src="<?= $image_user ?>" alt=""> </a>
                                </div>
                                <a href="<?= $link ?>" class="name-element"><?= $full_name_user ?></a>
                            </td>
                            <td>
                                <p class="name-element"><?= $department ?></p>
                            </td>
                            <td class="<?= $status ?>">
                                <span></span>
                                <p class="name-element"><?= $status_text ?></p>
                            </td>
                            <!--
                            <td>
                                <p class="name-element">€<?= $amount_budget ?></p>
                            </td> 
                            -->
                            <!-- <td class="textTh">
                                <div class="dropdown text-white">
                                    <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                        <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                    </p>
                                    <ul class="dropdown-menu">
                                        <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="<?= $link ?>">View</a></li>
                                        <li class="my-2"><i class="fa fa-gear px-2"></i><a href="" target="_blank">Edit</a></li>
                                        <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2 "></i>Remove</li>
                                    </ul>
                                </div>
                            </td> -->
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
            endif;
            ?>
        </div>
    </div>

</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js'></script>


<script>
    $('.horizontal .progress-fill span').each(function(){
        var percent = $(this).html();
        $(this).parent().css('width', percent);
    });

</script>

<script>
    var ctx = document.getElementById("ChartEngagement").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Active",	"Inactive"],
            datasets: [{
                //data: [50,	50], // Specify the data values array
                data: [<?=$members_active?>,<?=$members_inactive?>], // Specify the data values array

                borderColor: ['#47A99E', '#FF0000'], // Add custom color border
                backgroundColor: ['#47A99E', '#FF0000'], // Add custom color background (Points and Fill)
            }]},
        options: {
            maintainAspectRatio: false,
            legend: {
                position: 'bottom' // Positionnement de la légende en bas
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById("ChartCourse").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Courses completed",	"Courses in progress",	"Courses not started"],
            datasets: [{
                data: [<?= $progress_courses['done'] ?>, <?= $progress_courses['in_progress'] ?>, <?= $progress_courses['not_started'] ?>], // Specify the data values array

                borderColor: ['#47A99E', '#94A3B8', '#515365'], // Add custom color border
                backgroundColor: ['#47A99E', '#94A3B8', '#515365'], // Add custom color background (Points and Fill)
            }]},
        options: {
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
            legend: {
                position: 'bottom' // Positionnement de la légende en bas
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById("ChartAssessment").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["Asess... completed",	"Asessment not started"],
            datasets: [{
                data: [<?= $assessment_completed ?>, <?= $assessment_not_started ?>], // Specify the data values array
                borderColor: ['#47A99E', '#515365'], // Add custom color border
                backgroundColor: ['#47A99E', '#515365'], // Add custom color background (Points and Fill)

            }]},
        options: {
            maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height
            legend: {
                position: 'bottom',
            }
        }
    });
</script>

<!--pour desktop mobile-->
<script>
    var ctx = document.getElementById('ChartDesktopMobile').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mrt', 'April', 'Mei', 'Juni', 'Juli', 'Agtus', 'Sept', 'Okt', 'Nov', 'Dec'],
            datasets: [{
                label: 'Desktop',
                data: [60, 50, 40, 70, 120, 150, 140, 100, 80, 50, 22, 0],
                backgroundColor: "#247ADC"
            }, {
                label: 'Mobile',
                data: [0,57, 129, 42, 183, 91, 175, 68, 106, 15, 199, 0,],
                backgroundColor: "#5AA1F2"
            }]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
        }
    });
</script>

<script>
    var barChartData = {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        datasets: [
            {
                label: "Desktop",
                backgroundColor: "pink",
                borderColor: "red",
                borderWidth: 1,
                data: [60, 50, 40, 70, 120, 150, 140, 100, 80, 50, 22, 40]
            },
            {
                label: "Mobile",
                backgroundColor: "lightblue",
                borderColor: "blue",
                borderWidth: 1,
                data: [50, 40, 70, 40, 110, 100, 150, 100, 80, 30, 22, 40]
            }
        ]
    };

    var chartOptions = {
        responsive: true,
        legend: {
            position: "top"
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }

    window.onload = function() {
        var ctx = document.getElementById("chartsGroup").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: "bar",
            data: barChartData,
            options: chartOptions
        });
    };
</script>
