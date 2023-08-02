<?php

/* Information user */
$current_user = wp_get_current_user();
$full_name_user = ($current_user->first_name) ? $current_user->first_name . ' ' . $current_user->last_name : $current_user->display_name;
$image = get_field('profile_img',  'user_' . $current_user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/placehoder_user.png';
$company = get_field('company',  'user_' . $current_user->ID);

if(!empty($company))
    $company_name = $company[0]->post_title;

$company_connected = $company[0]->post_title;

$users = get_users();
$members = array();
$numbers = array();
$numbers_count = array();

$topic_views = array();
$topic_followed = array();

$stats_by_user = array();

$assessment_validated = array();
foreach ($users as $user ) {
    $company = get_field('company',  'user_' . $user->ID);

    if(!empty($company))
        if($company[0]->post_title == $company_connected)
        {
            $topic_by_user = array();
            $course_by_user = array();

            // Object & ID member
            array_push($numbers,$user->ID);
            array_push($members,$user);

            // Assessment
            $validated = get_user_meta('assessment_validated', 'user_' . $user->ID);
            foreach($validated as $assessment)
                if(!in_array($assessment, $assessment_validated))
                    array_push($assessment, $assessment_validated);
            
            //Followed topic
          
            //Stats engagement

        }
}

$count_members = count($members);
$date_format = date_create($current_user->user_registered);
$year_date_registered = date_format($date_format, "Y");

/* Members course */
$args = array(
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'author__in' => $numbers, 
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$member_courses = get_posts($args);
$member_courses_id = array_column($member_courses, 'ID');
$count_member_courses = count($member_courses);

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
$args = array(
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
        $course = get_post($course_id);

        // $prijs = get_field('price', $course_id);
        // $expenses += $prijs; 
        if(in_array($course_id, $member_courses_id)){
            array_push($enrolled_all_courses, $course_id);
            if(!in_array($course_id, $enrolled)){
                array_push($enrolled, $course_id);
                array_push($enrolled_courses, $course);
                $progressions = array();
                //Get progresssion this course 
                $args = array(
                    'post_type' => 'progression', 
                    'title' => $course->post_name,
                    'post_status' => 'publish',
                    'posts_per_page'         => -1,
                    'no_found_rows'          => true,
                    'ignore_sticky_posts'    => true,
                    'update_post_term_cache' => false,
                    'update_post_meta_cache' => false
                );
                $progressions = get_posts($args);
                if(!empty($progressions))
                    foreach ($progressions as $progression) {
                        $status = "in_progress";
                        $progression_id = $progression->ID;
                        //Finish read
                        $is_finish = get_field('state_actual', $progression_id);
                        if($is_finish)
                            $status = "done";
                        
                        switch ($status) {

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
    }
}
$count_enrolled_courses = (!empty($enrolled_courses)) ? count($enrolled_courses) : 0;
$progress_courses['not_started'] = $count_enrolled_courses - ($progress_courses['in_progress'] + $progress_courses['done']);
if($count_enrolled_courses > 0){
    $progress_courses['not_started'] = intval(($progress_courses['not_started'] / $count_enrolled_courses) * 100);
    $progress_courses['in_progress'] = intval(($progress_courses['in_progress'] / $count_enrolled_courses) * 100);
    $progress_courses['done'] = intval(($progress_courses['done'] / $count_enrolled_courses) * 100);
}
else
    $progress_courses['not_started'] = 100;

// Most popular
$most_popular = array_count_values($enrolled_all_courses);
arsort($most_popular);

/* Assessment */
$args = array(
    'post_type' => 'assessment',
    'post_status' => 'publish',
    'author__in' => $numbers, 
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$assessments = get_posts($args);
$count_assessments = count($assessments);
$assessment_validated = (!empty($assessment_validated)) ? count($assessment_validated) : 0;
$assessment_not_started = 100;
$assessment_completed = 0;
if($count_assessments > 0){
    $assessment_not_started = intval(($count_assessments - $assessment_validated) / $count_assessments) * 100;
    $assessment_completed = intval($assessment_validated / $count_assessments) * 100;
}

//Topic views 
$table_tracker_views = $wpdb->prefix . 'tracker_views';
$sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id IN (" . implode(',', $numbers) . ") AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
$topic_views = $wpdb->get_results($sql);

//Topic finished research through the course completed
$read_category = array();
foreach($course_finished as $course){
    //Topics preferences 
    $category_default = array();
    $category_xml = array();
    $category_default = get_field('categories', $course->ID);
    $category_xml = get_field('category_xml', $course->ID);
    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                array_push($read_category, $item['value']);
    else if(!empty($category_xml))
        foreach($category_xml as $item)
            if($item)
                array_push($read_category, $item['value']);
}

$read_category = array_count_values($read_category);
var_dump($read_category);

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
                <li class="nav-one"><a href="" class="current">Company</a></li>
                <li class="nav-two"><a href="">Team</a></li>
                <li class="nav-three"><a href="">Individual</a></li>
            </ul>
        </div>
    </div>

    <div class="body-content-view-statistic">
        <div id="Company" class="">
            <div class="group-card-head d-flex flex-wrap justify-content-between">
                <div class="card-element-company d-flex align-items-center bg-bleu-c">
                    <div class="content-fa">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/faUser.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Total Members</p>
                        <p class="number-members"><?= $count_members ?></p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center bg-yellow-c">
                    <!-- 
                    <select class="form-select" aria-label="Default select example">
                        <option value="Month">Par Month</option>
                        <option value="year">Per year</option>
                        <option value="week">Per week</option>
                    </select> -->
                    <div class="content-fa">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/faUser.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">New Members</p>
                        <p class="number-members">0</p>
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center bg-purple-c">
                    <div class="content-fa">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/faCourse.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Total Course</p>
                        <p class="number-members"><?= $count_member_courses ?></p>
                    </div>
                </div>
            </div>
            <!-- 
            <div>
                <select class="form-select select-statistic" aria-label="Default select example">
                    <option value="General">General</option>
                    <option value="year">First Team</option>
                    <option value="week">Second Team</option>
                </select>
            </div> -->
            <br><br>
            <div class="card-statistic">
                <h2>Course categories (topics) finished according to the users in the company</h2>
                <div class="statistic-bar">
                    <div class="progress-bar horizontal">
                        <?php
                        if($count_members)
                        foreach ($read_category as $value => $occurence) :
                        # code...
                        $name_topic = (String)get_the_category_by_ID($value);
                        $pourcentage = ($count_members > $occurence) ? intval(($occurence/$count_members) * 100) : 100;
                        ?>
                        <div class="progress-element">
                            <label class="skillName"><?= $name_topic ?>:</label>
                            <div class="progress-track">
                                <div class="progress-fill">
                                    <span><?= $pourcentage ?>%</span>
                                </div>
                            </div>
                            <p class="text-percentage"><?= $pourcentage ?>%</p>
                        </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
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
            <div class="subTopics-usage-block d-flex flex-wrap justify-content-between">
                <div class="subTopics-card">
                    <p class="title">Most Subtopics view by your company</p>
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
                    <div class="element-SubTopics d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="imgTopics">
                                <img src="<?= $image_topic ?>" alt="">
                            </div>
                            <p class="text-subTopics"><?= $name_topic ?></p>
                        </div>
                        <p class="number"><?= $occurence ?></p>
                    </div>
                    <?php
                    endforeach
                    ?>
                </div>
                <div class="usage-block-card-team">
                    <h2>Usage desktop vs Mobile app</h2>
                    <div>
                        <canvas id="ChartDesktopMobile"></canvas>
                    </div>
                </div>
            </div>
            <div class="card-course">
                <h2>Popular Course</h2>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col courseTitle">Course Title</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Type</th>
                        <th scope="col">Instructor</th>
                        <th scope="col">Done</th>
                        <th scope="col">Not Started</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a href="/" class="name-element">UX - UI Design certificat</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">Motion design </a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">videeo annimate After Effect</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">Een nieuwe video door Daniel</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="/" class="name-element">Oefening</a>
                        </td>
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td>
                        <td>
                            <p class="name-element">IT / Data</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                        <td>
                            <p class="name-element">12</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
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
                data: [90,	10], // Specify the data values array

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
                label: 'apples',
                data: [60, 50, 40, 70, 120, 150, 140, 100, 80, 50, 22, 0],
                backgroundColor: "#247ADC"
            }, {
                label: 'oranges',
                data: [0,57, 129, 42, 183, 91, 175, 68, 106, 15, 199, 0,],
                backgroundColor: "#5AA1F2"
            }]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
        }
    });
</script>