<?php
global $wpdb;
/* Information user */
$current_user = wp_get_current_user();
$full_name_user = ($current_user->first_name) ? $current_user->first_name . ' ' . $current_user->last_name : $current_user->display_name;
$image = get_field('profile_img',  'user_' . $current_user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/placehoder_user.png';

$company = get_field('company',  'user_' . $current_user->ID);
if(!empty($company))
    $company_name = $company[0]->post_title;
else
    header('Location: /dashboard/company/statistic');
$company_connected = $company[0]->post_title;

$date_format = date_create($current_user->user_registered);
$year_date_registered = date_format($date_format, "Y");

$users = get_users();
$members = array();
$numbers = array();
$numbers_count = array();
$topic_views = array();
$topic_followed = array();
function get_number_for_month($month, $plateform='web'){
    global $wpdb;
    $number_of_month = 0;
    $year = intval(date('Y'));
    $actual_month = intval(date('m'));
switch ($month){
    case 'Jan' :
        $number_of_month = 1;
        break;
    case 'Feb' :
        $number_of_month = 2;
        break;
    case 'March' :
        $number_of_month = 3;
        break;
    case 'Apr' :
        $number_of_month = 4;
        break;
    case 'May' :
        $number_of_month = 5;
        break;
    case 'Jun' :
        $number_of_month = 6;
        break;
    case 'Jul' :
        $number_of_month = 7;
        break;
    case 'Aug' :
        $number_of_month = 8;
        break;
    case 'Sep' :
        $number_of_month = 9;
        break;
    case 'Oct' :
        $number_of_month = 10;
        break;
    case 'Nov' :
        $number_of_month = 11;
        break;
    case 'Dec' :
        $number_of_month = 12;
        break;
}
    if ($number_of_month>$actual_month)
        $year = $year-1;

    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $sql = $wpdb->prepare("SELECT COUNT(*) FROM $table_tracker_views WHERE MONTH(updated_at) = $number_of_month AND YEAR(updated_at) = $year AND platform = '".$plateform."'");
    $number_statistics = $wpdb->get_results($sql)[0]->{'COUNT(*)'};
    return intval($number_statistics);
}
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
            if($user->user_registered)

            // Assessment
            $validated = get_user_meta($user->ID, 'assessment_validated');
            foreach($validated as $assessment)
                if(!in_array($assessment, $assessment_validated))
                    array_push($assessment_validated, $assessment);
            
            //Followed topic
          
            //Stats engagement

        }
}
//get new members

$new_members_count = 0;
$count_members = count($members);
foreach ($members as $user) {
    $is_login = false;

    $date = new DateTime();
    $date_this_month = date('Y-m-d');
    $date_last_month = $date->sub(new DateInterval('P1M'))->format('Y-m-d');
    $table_tracker_views = $wpdb->prefix . 'tracker_views';
    $sql = $wpdb->prepare("SELECT * FROM $table_tracker_views WHERE user_id = ".$user->ID." AND updated_at BETWEEN '".$date_last_month."' AND '".$date_this_month."'");
    $if_user_actif = count($wpdb->get_results($sql));

    if ((new DateTime($user->user_registered))->format('Y-m-d') <= $date_last_month)
        $new_members_count++;

    if ($if_user_actif)
        $is_login = true;

    //$status = ($is_login) ? 'actif' : 'actif inactif';
    //$status_text = ($is_login) ? 'Active' : 'Inactive';
    if ($is_login) {
        //$status_text = 'Active';
        $members_active++;
        //$status = 'actif';
    }
    else {
        //$status_text = 'Inactive';
        $members_inactive++;
        //$status = 'actif inactif';
    }
}
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
$most_popular = array_keys($most_popular);
$args = array(
    'post_type' => 'course', 
    'posts_per_page' => -1,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'include' => $most_popular,  
);
$most_popular_course = get_posts($args);

/* Assessment */
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
$sql = $wpdb->prepare("SELECT data_id, SUM(occurence) as occurence FROM $table_tracker_views WHERE user_id IN (" . implode(',', $numbers) . ") AND data_type = 'topic' GROUP BY data_id ORDER BY occurence DESC");
$topic_views = $wpdb->get_results($sql);
// begin put the number for mont


//Topic finished research through the course completed
$read_category = array();
foreach($course_finished as $course){
    //Topics preferences 
    $category_default = array();
    $category_xml = array();
    $category_default = get_field('categories', $course);
    $category_xml = get_field('category_xml', $course);
    if(!empty($category_default))
        foreach($category_default as $item)
            if($item){
                $values = explode(',', $item['value']);
                $read_category = (!empty($values)) ? array_merge($read_category, $values) : $read_category;  
            }
    else if(!empty($category_xml))
        foreach($category_xml as $item)
            if($item)
                array_push($read_category, $item['value']);
}
$read_category = array_count_values($read_category);

//Show link by scope 
$status_content_link .= "";
if(isset($company_name))
    $status_content_link .= '<li class="nav-one"><a class="current" href="/dashboard/company/statistic-company">Company</a></li>';

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
                <li class="nav-three"><a href="/dashboard/company/statistic/" >Individual</a></li>
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
                        <p class="total-member">NEW MEMBERS</p>
                        <p class="number-members">0</p> <!-- $new_members_count -->
                    </div>
                </div>
                <div class="card-element-company d-flex align-items-center bg-purple-c">
                    <div class="content-fa">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/faCourse.png" alt="">
                    </div>
                    <div>
                        <p class="total-member">Total Course</p>
                        <p class="number-members"><?= $count_enrolled_courses ?></p>
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
            <?php
            if(!empty($read_category)):
            $i = 0;
            ?>
            <div class="card-statistic">
                <h2>Course categories (topics) finished according to the users in the company</h2>
                <div class="statistic-bar">
                    <div class="progress-bar horizontal">
                        <?php
                        if($count_members)
                            foreach ($read_category as $value => $occurence) :
                            $name_topic = (String)get_the_category_by_ID($value);
                            $pourcentage = ($count_members > $occurence) ? intval(($occurence/$count_members) * 100) : 100;
                            ?>
                            <div class="progress-element">
                                <label class="skillName"><?= $name_topic ?> :</label>
                                <div class="progress-track">
                                    <div class="progress-fill">
                                        <span><?= $pourcentage ?>%</span>
                                    </div>
                                </div>
                                <p class="text-percentage"><?= $pourcentage ?>%</p>
                            </div>
                            <?php
                            $i += 1;
                            if($i == 10)
                                break;
                            endforeach;
                        ?>
                    </div>
                </div>
            </div>
            <?php
            endif;
            ?>
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
            <?php
            if(!empty($topic_views)):
            ?>
            <div class="subTopics-usage-block d-flex flex-wrap justify-content-between">
                <div class="subTopics-card">
                    <p class="title">Most Topics view by your company</p>
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
                <div class="usage-block-card-team">
                    <h2>Usage desktop vs Mobile app</h2>
                    <div>
                        <canvas id="ChartDesktopMobile"></canvas>
                    </div>
                </div>
            </div>
            <?php
            endif;
            if(!empty($most_popular_course)):
            ?>
            <div class="card-course">
                <h2>Popular Course</h2>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col courseTitle">Course Title</th>
                        <!-- <th scope="col">Duration</th> -->
                        <th scope="col">Type</th>
                        <th scope="col">Instructor</th>
                        <th scope="col">Not Started</th>
                        <th scope="col">In Progress</th>
                        <th scope="col">Done</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($most_popular_course as $key => $course):
                    $type_course = get_field('course_type', $course->ID);

                    //Author
                    $author = get_user_by('ID', $course->post_author);
                    $author_name = $author->first_name ? $author->first_name . ' ' . $author->last_name: $author->display_name;

                    //Get progresssion this course 
                    $progressions = array();
                    $progress_popular_courses = array();
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
                    $status = 'not_started';
                    if(!empty($progressions))
                        foreach ($progressions as $progression) {
                            $status = "in_progress";
                            $progression_id = $progression->ID;
                            //Finish read
                            $is_finish = get_field('state_actual', $progression_id);
                            if($is_finish)
                                $status = "done";
                            
                            switch ($status) {

                                case 'not_started':
                                    $progress_popular_courses['not_started'] += 1;
                                    break;

                                case 'in_progress':
                                    $progress_popular_courses['in_progress'] += 1;
                                    break;

                                case 'done':
                                    $progress_popular_courses['done'] += 1;
                                    //course finished 
                                    array_push($course_finished, $course->ID);
                                    break;                           
                            }
                        }

                        if(!$progress_popular_courses['in_progress'] && !$progress_popular_courses['done'])
                            $progress_popular_courses['not_started'] = 1;

                    ?>
                    <tr>
                        <td>
                            <a href="/" class="name-element"><?= $course->post_title ?></a>
                        </td>
                        <!-- 
                        <td>
                            <p class="name-element">12h 33m 10s</p>
                        </td> -->
                        <td>
                            <p class="name-element"><?= $type_course ?></p>
                        </td>
                        <td>
                            <p class="name-element"><?= $author_name ?></p>
                        </td>
                        <td>
                            <p class="name-element"><?= $progress_popular_courses['not_started'] ?></p>
                        </td>
                        <td>
                            <p class="name-element"><?= $progress_popular_courses['in_progress'] ?></p>
                        </td>
                        <td>
                            <p class="name-element"><?= $progress_popular_courses['done'] ?></p>
                        </td>
                    </tr>
                    <?php
                    if($key == 12)
                        break;
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
                //data: [90,	10], // Specify the data values array
                data: [<?= $members_active ?>,<?= $members_inactive ?>], // Specify the data values array
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
                label: 'web',
                data: [
                        <?=get_number_for_month('Jan')?>,
                        <?=get_number_for_month('Feb')?>,
                        <?=get_number_for_month('March')?>,
                        <?=get_number_for_month('Apr')?>,
                        <?=get_number_for_month('May')?>,
                        <?=get_number_for_month('Jun')?>,
                        <?=get_number_for_month('Jul')?>,
                        <?=get_number_for_month('Aug')?>,
                        <?=get_number_for_month('Sep')?>,
                        <?=get_number_for_month('Oct')?>,
                        <?=get_number_for_month('Nov')?>,
                        <?=get_number_for_month('Dec')?>
                    ],
                backgroundColor: "#247ADC"
            }, {
                label: 'mobile',
                data: [
                        <?=get_number_for_month('Jan','mobile')?>,
                        <?=get_number_for_month('Feb','mobile')?>,
                        <?=get_number_for_month('March','mobile')?>,
                        <?=get_number_for_month('Apr','mobile')?>,
                        <?=get_number_for_month('May','mobile')?>,
                        <?=get_number_for_month('Jun','mobile')?>,
                        <?=get_number_for_month('Jul','mobile')?>,
                        <?=get_number_for_month('Aug','mobile')?>,
                        <?=get_number_for_month('Sep','mobile')?>,
                        <?=get_number_for_month('Oct','mobile')?>,
                        <?=get_number_for_month('Nov','mobile')?>,
                        <?=get_number_for_month('Dec','mobile')?>
                    ],
                backgroundColor: "#5AA1F2"
            }]
        },
        options: {
            responsive: true, // Instruct chart js to respond nicely.
        }
    });
</script>