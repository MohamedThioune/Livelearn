
<?php


// Categories - all 
$categories = array();

$cats = get_categories(
    array(
        'taxonomy'   => 'course_category',  //Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude'    => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    )
);
foreach($cats as $category){
    $cat_id = strval($category->cat_ID);
    $category = intval($cat_id);
    array_push($categories, $category);
}
$subtopics = array();
foreach($categories as $categ){
    //Topics
    $topicss = get_categories(
        array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        )
    );

    foreach ($topicss as  $value) {
        $subtopic = get_categories(
            array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $value->cat_ID,
                'hide_empty' => 0,
                //  change to 1 to hide categores not having a single post
            )
        );
        $subtopics = array_merge($subtopics, $subtopic);
    }
}

$user = get_users(array('include'=> $id_user))[0]->data;

//Skills
$topics_external = get_user_meta($user->ID, 'topic');
$topics_internal = get_user_meta($user->ID, 'topic_affiliate');
$internal_growth_subtopics = get_user_meta($user->ID,'topic_affiliate');

$topics = array();
if(!empty($topics_external))
    $topics = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics, $value);

//Note
$skills_note = get_field('skills', 'user_' . $user->ID);
$count_skills_note  = (empty($skills_note)) ? 0 : count($skills_note);
 
//Is a manager + company + phone + bio
$manageds = get_field('managed',  'user_' . $user->ID);
$is_a_manager = (!empty($manageds)) ? 'Manager' : 'Employee';
$display_company = (!empty($company)) ? $company->post_title : 'No company';
$phone = (!empty($phone)) ? $phone : '(xx) xxx xxx xx';
$biographical_info = (!empty($biographical_info)) ? $biographical_info : "This paragraph is dedicated to expressing skills what I have been able to acquire during professional experience.<br>
Outside of let'say all the information that could be deemed relevant to a allow me to be known through my cursus.";

// Feedbacks
$args = array(
    'post_type' => 'feedback', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);
$todos = get_posts($args);
$feedbacks = array();
$persoonlijk_ontwikkelplan = array();
$beoordeling_gesprek = array();
$compliments = array();
$gedeelde_cursus = array();
$verplichte_cursus = array();
if(!empty($todos))
    foreach($todos as $key=>$todo):

        $type = get_field('type_feedback', $todo->ID);
        $todo->manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

        $todo->manager_image = get_field('profile_img',  'user_' . $todo->manager->ID);
        if(!$image)
            $image = get_stylesheet_directory_uri() . '/img/Group216.png';

        switch ($type) {
            case 'Feedback':
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($feedbacks, $todo);
                break;
            case 'Compliment':
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($compliments, $todo);
                break;
            case 'Persoonlijk ontwikkelplan':
                $todo->beschrijving_feedback = get_field('opmerkingen', $todo->ID);
                array_push($persoonlijk_ontwikkelplan, $todo);
                break;
            case 'Beoordeling Gesprek':
                $todo->beschrijving_feedback = get_field('algemene_beoordeling', $todo->ID);
                array_push($beoordeling_gesprek, $todo);
                break;
            case 'Gedeelde cursus':
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($gedeelde_cursus, $todo);
                break;
            case 'Verplichte cursus':
                $todo->beschrijving_feedback = get_field('beschrijving_feedback', $todo->ID);
                array_push($verplichte_cursus, $todo);
                break;
        }
    endforeach;

// Badges    
$args = array(
    'post_type' => 'badge', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);
    $achievements = get_posts($args);
    $badges = array();
    $certificats = array();
    $prestaties = array();
    $diplomas = array();
    if(!empty($achievements))
    foreach($achievements as $key=>$achievement):

        $type = get_field('type_badge', $achievement->ID);
        $achievement->manager = get_user_by('ID', get_field('manager_badge', $achievement->ID));

        $achievement->manager_image = get_field('profile_img',  'user_' . $achievement->manager->ID);
        if(!$image)
            $image = get_stylesheet_directory_uri() . '/img/Group216.png';

        switch ($type) {
            case 'Genuine':
                $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                array_push($badges, $achievement);
                break;
            case 'Certificaat':
                $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                array_push($certificats, $achievement);
                break;

            case 'Prestatie':
                $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                array_push($prestaties, $achievement);
                break;
            case 'Diploma':
                $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                array_push($diplomas, $achievement);
                break;
            default:
                $achievement->beschrijving_feedback = get_field('trigger_badge', $achievement->ID);
                array_push($badges, $achievement);
                break;
        }


    endforeach;

//Todos post
$args = array(
    'post_type' => 'todo', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);
$post_todos = get_posts($args);

//Graph stat web-mobile
$first_day_year = date('Y') . '-' . '01-01 ' . '00:00:00';
$last_day_year = date('Y') . '-' . '12-31 ' . '00:00:00';

$sql_interaction_web = $wpdb->prepare("SELECT MONTH(created_at) as monthly, count(*) as interaction 
FROM $table_tracker_views 
WHERE user_id = '" . $user->ID . "' AND platform = 'web' 
AND created_at >= '" .$first_day_year. "' AND created_at <= '" .$last_day_year. "'
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
");
$data_interaction_web = $wpdb->get_results($sql_interaction_web);

$sql_interaction_mobile = $wpdb->prepare("SELECT MONTH(created_at) as monthly, count(*) as interaction 
FROM $table_tracker_views 
WHERE user_id = '" . $user->ID . "' AND platform = 'mobile' 
AND created_at >= '" .$first_day_year. "' AND created_at <= '" .$last_day_year. "'
GROUP BY MONTH(created_at)
ORDER BY MONTH(created_at)
");
$data_interaction_mobile = $wpdb->get_results($sql_interaction_mobile)[0];

$data_web = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$data_mobile = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
if(!empty($data_interaction_web))
    foreach ($data_interaction_web as $web)
        if($web->monthly)
            $data_web[$web->monthly] = $web->interaction;
if(!empty($data_interaction_mobile))
    foreach ($data_interaction_mobile as $mobile)
        $data_mobile[$mobile->monthly] = $mobile->interaction;

$canva_data_web = join(',', $data_web);
$canva_data_mobile = join(',', $data_mobile);

//Graph stat topic you-team
$data_you_read = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$data_other_read = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$topic_learner_id = (isset($_GET['topic_learner'])) ? $_GET['topic_learner'] : null;
if(isset($topics_internal[0]))
    if(!$topic_learner_id)
        $topic_learner_id = $topics_internal[0];

if($topic_learner_id):

//For each user get the monthly application
$factor = 0;
foreach($numbers as $number):
    $other_read = false;
    $sql_other = $wpdb->prepare("SELECT data_id as ID, MONTH(created_at) as monthly 
    FROM $table_tracker_views 
    WHERE user_id = '" . $number . "' AND data_type = 'course' 
    AND created_at >= '" .$first_day_year. "' AND created_at <= '" .$last_day_year. "'
    ORDER BY MONTH(created_at)
    ");
    $data_interaction_other = $wpdb->get_results($sql_other);
    foreach($data_interaction_other as $course):

        $category_default = get_field('categories', $course->ID);
        $category_xml = get_field('category_xml', $course->ID);

        if(!empty($category_default))
            foreach($category_default as $item)
                if($item)
                    if($item['value'] == $topic_learner_id):
                        $data_other_read[$course->monthly] += 1;
                        $other_read = true;
                        break;
                    endif;

        if(!empty($category_default))
            foreach($category_default as $item)
                if($item)
                    if($item['value'] == $topic_learner_id):
                        $data_other_read[$course->monthly] += 1;
                        $other_read = true;
                        break;
                    endif;     
    endforeach;
    if($other_read)
        $factor += 1;
endforeach;
if($factor)
    $data_member_read = array_map( function($val) use ($factor) { return intval($val / $factor); }, $data_other_read);
    
$sql_you = $wpdb->prepare("SELECT data_id as ID, MONTH(created_at) as monthly
FROM $table_tracker_views 
WHERE user_id = '" . $user->ID . "' AND data_type = 'course' 
AND created_at >= '" .$first_day_year. "' AND created_at <= '" .$last_day_year. "'
ORDER BY MONTH(created_at)
");
$data_interaction_you = $wpdb->get_results($sql_you);
foreach($data_interaction_you as $course):

    $category_default = get_field('categories', $course->ID);
    $category_xml = get_field('category_xml', $course->ID);

    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if($item['value'] == $topic_learner_id):
                    $data_you_read[$course->monthly] += 1;
                    break;
                endif;

    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if($item['value'] == $topic_learner_id):
                    $data_you_read[$course->monthly] += 1;
                    break;
                endif;
            
endforeach;

endif;

$canva_data_you_read = is_array($data_you_read) ? join(',', $data_you_read) : '';
$canva_data_member_read = is_array($data_member_read) ? join(',', $data_member_read) : '';
?>
<!-- Latest BS-Select compiled and minified CSS/JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="contentProilView">
    <div class="head-profil-company"></div>
    <div class="content-general-info d-flex">
        <div class="content-img-profil">
            <img src="<?php echo $image;?>" alt="">
        </div>
        <div class="other-general-info">
            <p class="name">
                <?php
                // var_dump($data_interaction_you); 
                echo $user->display_name; 
                ?></p>
            <p class="professionCandidat"><?= $is_a_manager ?></p>
            <p class="company">Company : <span> <?= $display_company ?></span></p>
        </div>
    </div>

    <div id="tab-url1">

        <ul class="nav">
            <li class="nav-one"><a href="#Over" class="current">Over</a></li>
            <li class="nav-two"><a href="#Skills">Skills</a></li>
            <li class="nav-three"><a href="#Verplichte-training">To Do's</a></li>
            <li class="nav-four "><a href="#Certificaten">Certificaten</a></li>
            <li class="nav-five "><a href="#Statistieken">Statistieken</a></li>
            <li class="nav-seven "><a href="#Interne-groei">Interne groei</a></li>
            <li class="nav-eight last"><a href="#Externe-groei">Externe groei</a></li>
            <li class="nav-eight nav-feedback"><a href="#Feedback">Feedback</a></li>
        </ul>

        <div class="list-wrap">

            <ul id="Over">
                <div class="element-over">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_about.svg" alt="">
                        <h2>ABOUT</h2>
                    </div>
                    <p class="text-about-profil">
                        <?= $biographical_info ?>
                    </p>
                    <div class="d-flex group-other-info flex-wrap">
                        <div class="d-flex element-content-other-info">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_baseline-phone.svg" alt="">
                            <p><?= $phone ?></p>
                        </div>
                        <div class="d-flex element-content-other-info">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_baseline-email.svg" alt="">
                            <p><?= $user->user_email ?></p>
                        </div>
                        <div class="d-flex element-content-other-info">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/bxs_map.svg" alt="">
                            <p><?= $country ?></p>
                        </div>
                    </div>
                </div>

                <?php
                if($experiences): 
                ?>
                <div class="element-over">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_outline-work.svg" alt="">
                        <h2>EXPERIENCE</h2>
                    </div>
                    <?php
                    foreach($experiences as $value):
                    $value = explode(";", $value);
                    if(isset($value[2]))
                        $year = explode("-", $value[2])[0];
                    if(isset($value[3]))
                        if(intval($value[2]) != intval($value[3]))
                            $year = $year . "-" .  explode("-", $value[3])[0];
                    ?>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company"><?= $value[1]; ?></p>
                            <p class="profession"><?= $value[0]; ?></p>
                        </div>
                        <?php 
                        if($year):
                        ?>
                            <p class="date"><?php echo $year; ?></p>
                        <?php 
                        endif;
                        ?>
                    </div>
                    <?php
                    endforeach;
                    ?>
                </div>
                <?php
                endif;
                ?>


                <?php
                if($educations): 
                ?>
                <div class="element-over element-over-education">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/zondicons_education.svg" alt="">
                        <h2>EDUCATION</h2>
                    </div>
                    <?php
                    foreach($educations as $value):
                        $value = explode(";", $value);
                        if(isset($value[2]))
                            $year = explode("-", $value[2])[0];
                        if(isset($value[3]))
                            if(intval($value[2]) != intval($value[3]))
                                $year = $year . "-" .  explode("-", $value[3])[0];
                    ?>
                    <div class="one-experience d-flex align-items-center">
                        <div class="">
                            <p class="name-company"><?= $value[0]; ?></p>
                            <p class="profession"><?= $value[1]; ?></p>
                        </div>
                        <?php if($year) { ?>
                            <p class="dateCourCandidat"><?= $year; ?></p>
                        <?php } ?>                    
                    </div>
                    <?php
                    endforeach;
                    ?>
                </div>
                <?php
                endif;
                ?>
                 
                <?php
                if($portfolios):
                ?>
                <div class="element-over">
                    <div class="sub-head-over d-flex align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_portfolio.svg" alt="">
                        <h2>PORTFOLIO</h2>
                    </div>
                    <?php
                      foreach($portfolios as $value):
                        $value = explode(";", $value);  
                    ?>
                    <div class="one-portfolio">
                        <p class="name-portfolio"><?= $value[0]; ?></p>
                        <p class="description-portfolio"><?= $value[1]; ?></p>
                        <!-- <p class="link-portfolio">Link : <span>www.alkham.com</span></p> -->
                    </div>
                    <?php
                    endforeach;
                    ?>
                </div>
                <?php
                endif;
                ?>
            </ul>

            <?php
            if(!empty($topics)):
            ?>
            <ul id="Skills" class="hide">
                <div class="content-card-skills content-card-skills-profil">
                                
                    <?php
                    $avoid_repetition = array();
                    foreach($topics as $key => $value):
                        $i = 0;
                        $topic = get_the_category_by_ID($value);
                        $note = 0;
                        if(!$topic || in_array($value,$avoid_repetition))
                            continue;

                        //Avoid repetition
                        array_push($avoid_repetition,$value);

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
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </ul>
            <?php
            else:
            echo 
            '<div id="Skills" class="hide">
                <div class="block-empty-content" style="background: white; padding : 20px 0px">
                    <img src="'. get_stylesheet_directory_uri() .'/img/empty-to-do-table.png" alt="Empty skills">
                    <a href="#Interne-groei" class="btn btn-creer-eeen">Vaardigheden toevoegen</a>
                </div>
            </div>';
            endif;
            ?>

            <ul id="Verplichte-training" class="hide">
                <div class="sub-to-do d-flex justify-content-between align-items-center">
                    <p class="text-to-do-for">To do's for <?= $user->display_name ?></p>
                    <button class="btn btn-add-to-do" type="button" data-toggle="modal" data-target="#to-do-Modal">Add to do</button>

                    <!-- Modal Add to do -->
                    <div class="modal fade new-modal-to-do" id="to-do-Modal" tabindex="-1" role="dialog" aria-labelledby="to-do-ModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MandatoryModalLabel">To do</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="content-block-bg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="element-Doe-een" data-target="Persoonlijk" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Doe een</p>
                                                        <p class="description">Een opleiding, cursus,
                                                            podcast, event o.i.d.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-Schrijf-een" data-target="Schrijf-een" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Schrijf een</p>
                                                        <p class="description">Een persoonlijk
                                                            ontwikkel plan</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-Leer-een-onderwerp" data-target="Leer-een-onderwerp" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Leer een onderwerp</p>
                                                        <p class="description">Zet de uren vast!</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-Geef-feedback" data-target="Geef-feedback" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">Geef feedback</p>
                                                        <p class="description">Aan je collega’s</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail-content-modal content-Persoonlijk">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Do a course</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form method="post" action="/dashboard/user" class="form-to-do">
                                            <input type="hidden" name="type" value="Verplichte cursus">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >

                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van to do</label>
                                                <input type="text" class="form-control" id="" name="title_todo" required>
                                            </div>

                                            <!-- 
                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer bestaande intern of extern kennisproduct óf creëer een nieuwe</label>
                                                <select class="form-select select-internal-external mb-0" aria-label="Default" id="input-intern-extern" >
                                                    <option value="internal">Internal course</option>
                                                    <option value="external">External course</option>
                                                </select>
                                            </div> 
                                            -->

                                            <div hidden=true class="form-group" id="internal_output" >
                                                <?php echo $internal_cursus ?>
                                            </div>
                                            <div chidden=true lass="form-group" id="external_output">
                                                <?php echo $external_cursus ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="dateDone">Te doen voor welke datum?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Geldig tot?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]">
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="beschrijving_feedback" id="" rows="5" required></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-submi-form-to-do" name="add_todo_sample">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-Schrijf-een">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Persoonlijk ontwikkelplan</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="/dashboard/user" class="form-to-do">
                                            <input type="hidden" name="type" value="Persoonlijk ontwikkelplan">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >

                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van ontwikkelplan</label>
                                                <input type="text" class="form-control" id="" name="title_todo" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Waarover een ontwikkelplan maken?</label>
                                                <textarea class="message-area" name="beschrijving_feedback" id="" rows="3" required></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="dateDone">Voor welke datum?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Geldig tot?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" name="competencies_feedback" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="opmerkingen" id="" rows="5" required></textarea>
                                            </div>

                                            <button type="submit" name="add_todo_sample" class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-Leer-een-onderwerp">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span> Leer een onderwerp</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="/dashboard/user" class="form-to-do">
                                            <input type="hidden" name="type" value="Onderwerpen">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >

                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van de to do</label>
                                                <input type="text" class="form-control" id="" name="title_todo" required>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Selecteer het onderwerp (sub-topic)</label>
                                                <select class="form-select select-internal-external mb-0" name="onderwerpen_todo" aria-label="Default" id="" required>
                                                    <option value="0" selected>Choose topic …</option>
                                                    <?php
                                                    foreach($internal_growth_subtopics as $value)
                                                        echo "<option value='".$value."'>".(String)get_the_category_by_ID($value)."</option>";
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group" id="">
                                                <label class="sub-label">Select hours to learn</label>
                                                <select class="form-select select-internal-external mb-0" name="hour_todo" aria-label="Default" id="" >
                                                    <option value="0" selected>Hours</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5+">5+</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="beschrijving_feedback" id="" rows="5" required></textarea>
                                            </div>

                                            <button type="submit" name="add_todo_sample" class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-Geef-feedback">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Geef Feedback</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="/dashboard/user" class="form-to-do" >
                                            <input type="hidden" name="type" value="Feedback">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >

                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van te geven feedback</label>
                                                <input type="text" class="form-control" id="" name="title_todo" required>
                                            </div>
                                            <div class="form-group formModifeChoose">
                                                <label class="sub-label">Selecteer de collega(s)</label>
                                                <select id="" name="collegas_feedback[]"  class="multipleSelect2" multiple="true">
                                                    <option value="">Pick team members …</option>
                                                    <?php
                                                    foreach($members as $member)
                                                        echo "<option value='" . $member->ID . "'>" . $member->display_name . "</option>";
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="dateDone">Voor welke datum?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Geldig tot?</label>
                                                <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" placeholder="" name="competencies_feedback" id="" rows="5"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" placeholder="" name="opmerkingen" id="" rows="5"></textarea>
                                            </div>

                                            <button type="submit" name="add_todo_sample" class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="body-content-to-do">

                    <div class="content-tab">
                        <div class="content-button-tabs">
                            <button  data-tab="All" class="b-nav-tab btn active">
                                All <span class="number-content"><?= $count_mandatories ?></span>
                            </button>
                            <?php
                            $count_todos_feedback = (!empty($todos_feedback)) ? count($todos_feedback) : 0;
                            ?>
                            <button  data-tab="Activiteiten" class="b-nav-tab btn">
                                Activiteiten <span class="number-content"><?= $count_todos_feedback ?></span>
                            </button>
                            <?php
                            $count_todos_plannen = (!empty($todos_plannen)) ? count($todos_plannen) : 0;
                            ?>
                            <button  data-tab="Plannen" class="b-nav-tab btn">
                                Plannen <span class="number-content"><?= $count_todos_plannen ?></span>
                            </button>
                            <?php
                            $count_todos_onderwerpen = (!empty($todos_onderwerpen)) ? count($todos_onderwerpen) : 0;
                            ?>
                            <button  data-tab="Onderwerpen" class="b-nav-tab btn">
                                Onderwerpen <span class="number-content"><?= $count_todos_onderwerpen?></span>
                            </button>
                            <?php
                            $count_todos_cursus = (!empty($todos_cursus)) ? count($todos_cursus) : 0;
                            ?>
                            <button  data-tab="Courses" class="b-nav-tab btn">
                                Courses <span class="number-content"><?= $count_todos_cursus ?></span>
                            </button>
                        </div>

                        <div id="All" class="b-tab active contentBlockSetting -">
                            <?php
                            if(!empty($mandatories)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($mandatories as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = (get_field('type_feedback', $todo->ID)) ?: 'Mandatory';
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));
                                    $due_date = get_field('welke_datum_feedback', $todo->ID);
                                    $due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';

                                    $title_todo = get_field('title_todo', $todo->ID);
                                    $title = ($title_todo) ?: $todo->post_title;

                                    //Pourcentage
                                    $pourcentage = 0;
                                    $count_lesson = 0;

                                    $args = array(
                                        'post_type' => 'progression', 
                                        'title' => $todo->post_title,
                                        'post_status' => 'publish',
                                        'author' => $user->ID,
                                        'posts_per_page'         => 1,
                                        'no_found_rows'          => true,
                                        'ignore_sticky_posts'    => true,
                                        'update_post_term_cache' => false,
                                        'update_post_meta_cache' => false
                                    );
                                    $progressions = get_posts($args);
                                    if(!empty($progressions)):
                                        $progression_id = $progressions[0]->ID;
                                        //Finish read
                                        $is_finish = get_field('state_actual', $progression_id);
                                        if($is_finish){
                                            $count_mandatory_done += 1;
                                            $pourcentage = 100;
                                        }
                            
                                        $post = get_page_by_path($todo->post_title, OBJECT, 'course');
                                        $type_post = ($post) ? get_field('course_type', $post->ID) : 'NaN';
                            
                                        if($type_post == 'Video'){
                                            $courses = get_field('data_virtual', $post->ID);
                                            $youtube_videos = get_field('youtube_videos', $post->ID);
                                            if(!empty($courses))
                                                $count_lesson = count($courses);
                                            else if(!empty($youtube_videos))
                                                $count_lesson = count($youtube_videos);
                                        }
                                        else if($type_post == 'Podcast'){
                                            $podcasts = get_field('podcasts', $post->ID);
                                            $podcast_index = get_field('podcasts_index', $post->ID);
                                            if(!empty($podcasts))
                                                $count_lesson = count($podcasts);
                                            else if(!empty($podcast_index))
                                                $count_lesson = count($podcast_index);
                                        }
                                        else
                                            $count_lesson = 0;
                                        
                            
                                        //Pourcentage
                                        $lesson_reads = get_field('lesson_actual_read', $progression_id);
                                        $count_lesson_reads = ($lesson_reads) ? count($lesson_reads) : 0;
                                        if($count_lesson)
                                            $pourcentage = ($count_lesson) ? ($count_lesson_reads / $count_lesson) * 100 : 0;
                                        $todo->pourcentage = intval($pourcentage);
                                            
                                    endif;

                                    //Onderwerpen : situation
                                    if($type == 'Onderwerpen'):
                                        $skill_todo = get_field('onderwerpen_todo', $todo->ID);
                                        $title = ($skill_todo) ? '['. (String)get_the_category_by_ID($skill_todo) .'] '. $title : $title;
                                        //Pourcentage
                                        $pourcentage_todo = 0;
                                        if(!empty($skills_note))
                                            foreach($skills_note as $skill)
                                                if($skill['id'] == $skill_todo){
                                                    $todo->pourcentage = $skill['note'];
                                                    break;
                                                }
                                    endif;

                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        <?= $todo->pourcentage ?> <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="<?= $todo->pourcentage ?>"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element"><?= $due_date ?></p>
                                        </td>
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#to-do-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Activiteiten" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($todos_feedback)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($todos_feedback as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = (get_field('type_feedback', $todo->ID)) ?: 'Mandatory';
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));
                                    $due_date = get_field('welke_datum_feedback', $todo->ID);
                                    $due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';

                                    $title_todo = get_field('title_todo', $todo->ID);
                                    $title = ($title_todo) ?: $todo->post_title;

                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td>
                                            <!-- 
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        <?= $todo->pourcentage ?> <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="<?= $todo->pourcentage ?>"></progress>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td>
                                            <a href="#" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element"><?= $due_date ?></p>
                                        </td>
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#to-do-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Plannen" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($todos_plannen)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($todos_plannen as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = (get_field('type_feedback', $todo->ID)) ?: 'Mandatory';
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));
                                    $due_date = get_field('welke_datum_feedback', $todo->ID);
                                    $due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';

                                    $title_todo = get_field('title_todo', $todo->ID);
                                    $title = ($title_todo) ?: $todo->post_title;

                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td>
                                            <!-- 
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        <?= $todo->pourcentage ?> <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="<?= $todo->pourcentage ?>"></progress>
                                                </div>
                                            </div> -->
                                        </td>
                                        <td>
                                            <a href="#" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element"><?= $due_date ?></p>
                                        </td>
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#to-do-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Onderwerpen" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($todos_onderwerpen)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($todos_onderwerpen as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = (get_field('type_feedback', $todo->ID)) ?: 'Mandatory';
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));
                                    $due_date = get_field('welke_datum_feedback', $todo->ID);
                                    $due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';

                                    $title_todo = get_field('title_todo', $todo->ID);
                                    $title = ($title_todo) ?: $todo->post_title;

                                    $skill_todo = get_field('onderwerpen_todo', $todo->ID);
                                    $title = ($skill_todo) ?'['. (String)get_the_category_by_ID($skill_todo) .'] '. $title : $title;
                                    //Pourcentage
                                    $pourcentage_todo = 0;
                                    if(!empty($skills_note))
                                        foreach($skills_note as $skill)
                                            if($skill['id'] == $skill_todo){
                                                $pourcentage_todo = $skill['note'];
                                                break;
                                            }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        <?= $pourcentage_todo ?> <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="<?= $pourcentage_todo ?>"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn view-detail">View details</a>
                                        </td>
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#to-do-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Courses" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($todos_cursus)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($todos_cursus as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = (get_field('type_feedback', $todo->ID)) ?: 'Mandatory';
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));
                                    $due_date = get_field('welke_datum_feedback', $todo->ID);
                                    $due_date = ($due_date) ? date("d/m/Y", strtotime($due_date[1])) : '🗓️';

                                    $title_todo = get_field('title_todo', $todo->ID);
                                    $title = ($title_todo) ?: $todo->post_title;

                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td>
                                            <div class="progress-bar-element-profil">
                                                <div class="task-progress">
                                                    <p class="text-center">
                                                        <?= $todo->pourcentage ?> <span>%</span>
                                                    </p>
                                                    <progress class="progress progress2" max="100" value="<?= $todo->pourcentage ?>"></progress>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element"><?= $due_date ?></p>
                                        </td>
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img  style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#to-do-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="empty" class="b-tab aa contentBlockSetting">
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">To do</th>
                                    <th scope="col">What</th>
                                    <th scope="col">Progress</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">

                                </tbody>
                            </table>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <a href="" class="btn btn-creer-eeen">Creëer een eerste to do</a>
                            </div>
                        </div>

                    </div>

                </div>
            </ul>

            <ul id="Certificaten" class="hide">
                <div class="sub-to-do d-flex justify-content-between align-items-center">
                    <p class="text-to-do-for">Achievements by <?= $user->display_name ?></p>
                    <button class="btn btn-add-to-do" type="button" data-toggle="modal" data-target="#Add-achievement-Modal">Add achievement</button>

                    <!-- Modal Add Add achievement -->

                    <div class="modal fade new-modal-to-do" id="Add-achievement-Modal" tabindex="-1" role="dialog" aria-labelledby="to-do-ModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MandatoryModalLabel">Add achievement</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="content-block-bg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="element-BADGE" data-target="BADGE" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">BADGE</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-CERTFICATE" data-target="CERTFICATE" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">CERTFICATE</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-PRESTATIE" data-target="PRESTATIE" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">PRESTATIE</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-DIPLOMA" data-target="DIPLOMA" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">DIPLOMA</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="detail-content-modal content-BADGE">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Badge</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        
                                        <!-- 
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="">Titel van de badge</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hoe is deze badge behaald?</label>
                                                <textarea class="message-area" name="" id="" rows="3"></textarea>
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="">Upload de batch</label>
                                                <div class="upload-batch-group">
                                                    <div x-data="imageData()" class="file-input d-flex items-center">
                                                        <div class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                                            <div x-show="!previewPhoto" class="preview-badge">
                                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/default-badge.jpg" alt="">
                                                            </div>
                                                            <div x-show="previewPhoto" class="preview-badge">
                                                                <img :src="previewPhoto"
                                                                     alt=""
                                                                     class="h-12 w-12 object-cover">
                                                            </div>
                                                        </div>

                                                        <div class="group-text-upload">
                                                            <div class="input-upload-btnGroup">
                                                                <input @change="updatePreview($refs)" x-ref="input"
                                                                       type="file"
                                                                       accept="image/*,capture=camera"
                                                                       name="photo" id="photo"
                                                                       class="custom">
                                                                <label for="photo">
                                                                    Sleep en zet neer of klik om een afbeelding te uploaden <span>PNG OF SVG to 5MB</span>
                                                                </label>
                                                            </div>
                                                            <div class="">
                                                                <span x-text="fileName || emptyText"></span>
                                                                <button x-show="fileName"
                                                                        @click="clearPreview($refs)"
                                                                        type="button"
                                                                        aria-label="Remove image"
                                                                        class="mx-1 mt-1">
                                                                    <svg viewBox="0 0 20 20" fill="currentColor" class="x-circle w-4 h-4"
                                                                         aria-hidden="true" focusable="false"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="Deze-badge" name="Deze-badge" value="Anoniem versturen?">
                                                <label class="sub-label-check" for="Anoniem-versturen?">Deze badge vervalt niet</label>
                                            </div>

                                            <div class="form-group">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <div class="w-48">
                                                        <label for="dateDone">Voor welke datum?</label>
                                                        <input type="date" class="form-control mr-3" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                    </div>
                                                    <div class="w-48">
                                                        <label for="dateDone">Voor welke datum?</label>
                                                        <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                        -->
                                        <?php
                                        acf_form(array(
                                            'post_id'  => 'new_post',
                                            'new_post' => array(
                                                'post_type'   => 'badge',
                                                'post_status' => 'publish',
                                                'post_author' => $user->ID
                                            ),
                                            'post_title'   => true,
                                            'post_excerpt' => false,
                                            'post_content' => false,
                                            'fields' => array('trigger_badge', 'genuine_image_badge', 'voor_welke_datum_badge', 'tot_welke_datum_badge', 'competencies_badge', 'opmerkingen_badge'),
                                            'submit_value'  => __('Stuur'),
                                            'return' => '?id=' . $user->ID . '&manager='. $superior->ID .'&post_id=%post_id%&typeBadge=Genuine'
                                        )); 
                                        ?>
                                    </div>
                                    <div class="detail-content-modal content-CERTFICATE">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Certificaat</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- 
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="">Titel van het certificaat</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Uitgegeven door?</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">URL aanbieder</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Certificaatnummer, indien van toepassing</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="" name="" value="">
                                                <label class="sub-label-check" for="">Dit certificaat vervalt niet</label>
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <div class="w-48">
                                                        <label for="dateDone">Voor welke datum?</label>
                                                        <input type="date" class="form-control mr-3" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                    </div>
                                                    <div class="w-48">
                                                        <label for="dateDone">Voor welke datum?</label>
                                                        <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form> 
                                        -->
                                        <?php
                                        acf_form(array(
                                            'post_id'  => 'new_post',
                                            'new_post' => array(
                                                'post_type'   => 'badge',
                                                'post_status' => 'publish',
                                                'post_author' => $user->ID
                                            ),
                                            'post_title'   => true,
                                            'post_excerpt' => false,
                                            'post_content' => false,
                                            'fields' => array('uitgegeven_door_badge', 'url_aanbieder_badge', 'certificaatnummer_badge', 'voor_welke_datum_badge', 'tot_welke_datum_badge', 'competencies_badge', 'opmerkingen_badge'),
                                            'submit_value'  => __('Stuur'),
                                            'return' => '?id=' . $user->ID . '&manager='. $superior->ID .'&post_id=%post_id%&typeBadge=Certificaat'
                                        )); 
                                        ?>
                                    </div>
                                    <div class="detail-content-modal content-PRESTATIE">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Prestatie</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- 
                                        <form method="post" class="form-to-do" action="/dashboard/user">
                                            <div class="form-group">
                                                <label for="">Titel van de prestatie</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Beschrijf de prestatie</label>
                                                <textarea class="message-area" name="" id="" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <div class="w-48">
                                                        <label for="dateDone">Uren</label>
                                                        <input placeholder="Getal" type="text" class="form-control" id="" name="" required>
                                                    </div>
                                                    <div class="w-48">
                                                        <label for="dateDone">Punten</label>
                                                        <input placeholder="Getal" type="text" class="form-control" id="" name="" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form> 
                                        -->
                                        <?php
                                        acf_form(array(
                                            'post_id'  => 'new_post',
                                            'new_post' => array(
                                                'post_type'   => 'badge',
                                                'post_status' => 'publish',
                                                'post_author' => $user->ID
                                            ),
                                            'post_title'   => true,
                                            'post_excerpt' => false,
                                            'post_content' => false,
                                            'fields' => array('trigger_badge', 'uren_badge', 'punten_badge', 'voor_welke_datum_badge', 'tot_welke_datum_badge', 'competencies_badge', 'opmerkingen_badge'),
                                            'submit_value'  => __('Stuur'),
                                            'return' => '?id=' . $user->ID . '&manager='. $superior->ID .'&post_id=%post_id%&typeBadge=Prestatie'
                                        )); 
                                        ?>
                                    </div>
                                    <div class="detail-content-modal content-DIPLOMA">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Geef Diploma</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <!-- 
                                        <form method="post" class="form-to-do" action="">
                                            <div class="form-group">
                                                <label for="">Diploma</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Titel van het diploma</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Uitgegeven door universiteit of hogeschool</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">URL aanbieder</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Land</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Niveau</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <div class="w-48">
                                                        <label for="dateDone">Startdatum</label>
                                                        <input type="date" class="form-control mr-3" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                    </div>
                                                    <div class="w-48">
                                                        <label for="dateDone">Einddatum</label>
                                                        <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ" form="mandatory-form" name="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Aantal punten</label>
                                                <input type="text" class="form-control" id="" name="" required>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="">Over welke competenties?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nog op- en of aanmerkingen?</label>
                                                <textarea class="message-area" name="" id="" rows="5"></textarea>
                                            </div>

                                            <button class="btn btn-submi-form-to-do">Stuur</button>

                                        </form> 
                                        -->
                                        <?php
                                        acf_form(array(
                                            'post_id'  => 'new_post',
                                            'new_post' => array(
                                                'post_type'   => 'badge',
                                                'post_status' => 'publish',
                                                'post_author' => $user->ID
                                            ),
                                            'post_title'   => true,
                                            'post_excerpt' => false,
                                            'post_content' => false,
                                            'fields' => array('uitgegeven_door_badge', 'land_badge', 'niveau_badge', 'url_aanbieder_badge', 'certificaatnummer_badge', 'voor_welke_datum_badge', 'tot_welke_datum_badge', 'punten_badge', 'competencies_badge', 'opmerkingen_badge'),
                                            'submit_value'  => __('Stuur'),
                                            'return' => '?id=' . $user->ID . '&manager='. $superior->ID .'&post_id=%post_id%&typeBadge=Diploma'
                                        )); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="body-content-to-do">

                    <div class="content-tab">
                        <div class="content-button-tabs">
                            <?php
                            $count_badges = (!empty($badges)) ? count($badges) : 0;
                            ?>
                            <button data-tab="Badges" class="b-nav-tab btn active">
                                Badges<span class="number-content"><?= $count_badges ?></span>
                            </button>
                            <?php
                            $count_certficats = (!empty($certificats)) ? count($certificats) : 0;
                            ?>
                            <button data-tab="Certificates" class="b-nav-tab btn">
                                Certificates <span class="number-content"><?= $count_certficats ?></span>
                            </button>
                            <?php
                            $count_prestaties = (!empty($prestaties)) ? count($prestaties) : 0;
                            ?>
                            <button data-tab="Prestaties" class="b-nav-tab btn">
                                Prestaties <span class="number-content"><?= $count_prestaties ?></span>
                            </button>
                            <?php
                            $count_diplomas = (!empty($diplomas)) ? count($diplomas) : 0;
                            ?>
                            <button data-tab="Diploma" class="b-nav-tab btn">
                                Diploma <span class="number-content"><?= $count_diplomas ?></span>
                            </button>
                        </div>

                        <div id="Badges" class="b-tab active contentBlockSetting">
                            <?php
                            if (!empty($badges)):
                            ?>
                            <div class="block-with-content-badge d-flex flex-wrap">
                                <?php
                                foreach ($badges as $key => $badge):
                                if($key == 3)
                                    break;
                                // Image + trigger
                                $image_badge = get_field('image_badge', $badge->ID) ?: get_stylesheet_directory_uri() . '/img/badge-basic.png';
                                $trigger_badge = get_field('trigger_badge', $badge->ID);
                                $level_badge = get_field('level_badge', $badge->ID) ?: '<b>Company</b>';
                                ?>
                                <div class="card-badge">
                                    <div class="img-card-badge">
                                        <img src="<?= $image_badge ?>" alt="">
                                    </div>
                                    <p class="title-badge">Badge <?= $level_badge ?></p>
                                    <p class="statut-text"><?= $badge->post_title ?></p>
                                    <div class="bar-badge"></div>
                                    <p class="statut-badge"><?= $trigger_badge ?></p>
                                </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                            <?php
                            else:
                            ?>
                                <div class="block-empty-content">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                    <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-achievement-Modal">Geef <span><?= $user->display_name ?></span> waardering</button>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Certificates" class="b-tab contentBlockSetting">
                            <?php
                            if (!empty($certificats)):
                            ?>
                            <div class="block-with-content-badge d-flex flex-wrap">
                                <?php
                                foreach ($certificats as $key => $badge):
                                if($key == 3)
                                    break;
                                // Image 
                                $image_badge = get_field('image_badge', $badge->ID) ?: get_stylesheet_directory_uri() . '/img/badge-assessment.png';
                                // $trigger_badge = get_field('trigger_badge', $badge->ID);
                                // $level_badge = get_field('level_badge', $badge->ID) ?: 'Company';
                                $certificaatnummer_badge = get_field('certificaatnummer_badge', $badge->ID) ?: 'None';
                                $url_aanbieder_badge = get_field('url_aanbieder_badge', $badge->ID) ?: 'None';
                                $uitgegeven_door_badge = get_field('uitgegeven_door_badge', $badge->ID) ?: 'None';
                                ?>
                                <div class="card-badge">
                                    <div class="img-card-badge">
                                        <img src="<?= $image_badge ?>" alt="">
                                    </div>
                                    <p class="title-badge">Certificat #<?= $certificaatnummer_badge ?></p>
                                    <p class="statut-text"><?= $badge->post_title ?></p>
                                    <p class="statut-text"><a href=" <?= $url_aanbieder_badge ?>" target="_blank"><b>URL AANBIEDER</b></a></p>
                                    <div class="bar-badge"></div>
                                    <p class="statut-badge"> <b>Uitgegeven door : </b><br> <?= $uitgegeven_door_badge ?></p>
                                </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                            <?php
                            else:
                            ?>
                                <div class="block-empty-content">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                    <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-achievement-Modal">Geef <span><?= $user->display_name ?></span> waardering</button>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Prestaties" class="b-tab contentBlockSetting">
                            <?php
                            if (!empty($prestaties)):
                            ?>
                            <div class="block-with-content-badge d-flex flex-wrap">
                                <?php
                                foreach ($prestaties as $key => $badge):
                                if($key == 3)
                                    break;
                                // Image 
                                $image_badge = get_field('image_badge', $badge->ID) ?: get_stylesheet_directory_uri() . '/img/badge-assessment.png';
                                // $trigger_badge = get_field('trigger_badge', $badge->ID);
                                // $level_badge = get_field('level_badge', $badge->ID) ?: 'Company';
                                $uren_badge = get_field('uren_badge', $badge->ID) ?: 'None';
                                $punten_badge = get_field('punten_badge', $badge->ID) ?: 'None';
                                $competencies_badge = get_field('competencies_badge', $badge->ID) ?: 'None';
                                $opmerkingen_badge = get_field('opmerkingen_badge', $badge->ID) ?: 'None';
                                ?>
                                <div class="card-badge">
                                    <div class="img-card-badge">
                                        <img src="<?= $image_badge ?>" alt="">
                                    </div>
                                    <p class="title-badge">Punten : <?= $punten_badge ?> | Uren : <?= $uren_badge ?></p>
                                    <p class="statut-text"><?= $badge->post_title ?></p>
                                    <p class="statut-text"><b> Competencies : </b><br> <?= $competencies_badge?></p>
                                    <div class="bar-badge"></div>
                                    <p class="statut-badge"> <b> Opmerkingen : </b> <?= $opmerkingen_badge ?></p>
                                </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                            <?php
                            else:
                            ?>
                                <div class="block-empty-content">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                    <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-achievement-Modal">Geef <span><?= $user->display_name ?></span> waardering</button>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Diploma" class="b-tab contentBlockSetting">
                        <?php
                            if (!empty($diplomas)):
                            ?>
                            <div class="block-with-content-badge d-flex flex-wrap">
                                <?php
                                foreach ($diplomas as $key => $badge):
                                if($key == 3)
                                    break;
                                // Image 
                                $image_badge = get_field('image_badge', $badge->ID) ?: get_stylesheet_directory_uri() . '/img/badge-assessment.png';

                                // $trigger_badge = get_field('trigger_badge', $badge->ID);
                                // $level_badge = get_field('level_badge', $badge->ID) ?: 'Company';
                                $certificaatnummer_badge = get_field('certificaatnummer_badge', $badge->ID) ?: 'None';
                                $url_aanbieder_badge = get_field('url_aanbieder_badge', $badge->ID) ?: 'None';
                                $uitgegeven_door_badge = get_field('uitgegeven_door_badge', $badge->ID) ?: 'None';
                                ?>
                                <div class="card-badge">
                                    <div class="img-card-badge">
                                        <img src="<?= $image_badge ?>" alt="">
                                    </div>
                                    <p class="title-badge">Diploma #<?= $certificaatnummer_badge ?></p>
                                    <p class="statut-text"><?= $badge->post_title ?></p>
                                    <p class="statut-text"><a href="<?= $url_aanbieder_badge ?>" target="_blank"><b>URL AANBIEDER</b></a></p>
                                    <div class="bar-badge"></div>
                                    <p class="statut-badge"> <b>Uitgegeven door : </b><br> <?= $uitgegeven_door_badge ?></p>
                                </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                            <?php
                            else:
                            ?>
                                <div class="block-empty-content">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-certifican.png" alt="">
                                    <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-achievement-Modal">Geef <span><?= $user->display_name ?></span> waardering</button>
                                </div>
                            <?php
                            endif;
                            ?>
                        </div>


                    </div>

                </div>
            </ul>

            <ul id="Statistieken" class="hide">
                <div class="group-statistieken">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Courses done</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $progress_courses['done'] ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Training Costs:</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $budget_spent ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Average Training Hours</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat">x hours <span>/ x hours</span> </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Courses in progress</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $progress_courses['in_progress'] ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Assessments done</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $assessment_validated ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Mandatory courses done</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $count_mandatory_done . "/" . $count_mandatories ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Self-Assessment of Skills:</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $count_skills_note ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">External Learning Opportunities:</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $external_learning_opportunities ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Average feedback given (Me / Team)</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"><?= $score_rate_feedback ?> <span>/ <?= $score_rate_feedback_company ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="theme-card-statistiken-1 mb-4 position-relative height-fit-content">
                        <div class="head-card d-flex justify-content-between align-items-center">
                            <p class="title">Key Skill Development Progress: (See all)</p>
                            
                            <?php
                            $read_learning = array();
                            foreach($topics_internal as $key => $learning):
                            if(!$learning && !in_array($learning, $read_learning))
                                continue;
                            $link_stat = '?id=' . $user->ID . '&manager='. $superior->ID .'&tab=Statistieken%&topic_learner=' . $learning;
                            ?>
                            <div class="select">
                                <a href="<?= $link_stat ?>">
                                <?php echo (String)get_the_category_by_ID($learning); ?>
                                <!-- 
                                <select>
                                    <option value="Year">OOH</option>
                                    <option value="Month">Month</option>
                                    <option value="Day">Day</option>
                                </select>
                                <div>
                                    <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                </div> -->
                                </a>
                            </div>
                            <?php
                            array_push($read_learning, $learning);
                            if($key == 2)
                                break;
                            endforeach;
                            ?>
                        </div>
                        <div class="w-100">
                            <canvas id="Key-Skill"></canvas>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Learning Delivery Methods:</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <?php
                                if($count_course_views):
                                ?>
                                <div class="d-block w-100 subTopics-usage-block">
                                    <?php
                                    foreach ($type_courses as $type => $occurence):
                                    $learning_delivery_methods = ($occurence/$count_course_views) * 100;
                                    ?>
                                    <a href="#" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics"><?= $type ?></p>
                                        </div>
                                        <p class="number"><?= intval($learning_delivery_methods) ?>%</p>
                                    </a>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <?php
                                else:
                                    echo '<div class="empty-topic-block">
                                            <img src="' . get_stylesheet_directory_uri() . '/img/empty-topic.png" alt="">
                                          </div>';
                                endif;
                                ?>

                            </div>
                        </div>
                        <div class="col-md-4">
                           <div>
                               <div class="theme-card-statistiken-1 height-fit-content mb-3">
                                   <div class="head-card d-flex justify-content-between align-items-center">
                                       <p class="title">Feedback received</p>
                                       <!-- <div class="select">
                                           <select>
                                               <option value="Year">Year</option>
                                               <option value="Month">Month</option>
                                               <option value="Day">Day</option>
                                           </select>
                                           <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                       </div> -->
                                   </div>
                                   <p class="text-stat"><?= $count_feedback_received ?></p>
                               </div>
                               <div class="theme-card-statistiken-1 height-fit-content">
                                   <div class="head-card d-flex justify-content-between align-items-center">
                                       <p class="title">Feedback given</p>
                                       <!-- <div class="select">
                                           <select>
                                               <option value="Year">Year</option>
                                               <option value="Month">Month</option>
                                               <option value="Day">Day</option>
                                           </select>
                                           <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                       </div> -->
                                   </div>
                                   <p class="text-stat"><?= $count_feedback_given ?></p>
                               </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Most Viewed Topics</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <p class="text-stat"></p>
                                <?php
                                if($topic_views):
                                    foreach($topic_views as $topic):
                                        $value = $topic->data_id;
                                        $occurence = $topic->occurence;
                                        $name_topic = (String)get_the_category_by_ID($value);
                                        $image_topic = get_field('image', 'category_'. $value);
                                        $image_topic = $image_topic ? $image_topic : get_stylesheet_directory_uri() . '/img/placeholder.png';
                                        ?>
                                        <a href="#" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                            </div>
                                            <p class="text-subTopics"><?= $type ?></p>
                                        </div>
                                        <p class="number"><?= intval($learning_delivery_methods) ?>%</p>
                                    </a>
                                    <?php
                                    endforeach;
                                else:
                                    echo '<div class="empty-topic-block">
                                             <img src="' . get_stylesheet_directory_uri() . '/img/empty-topic.png" alt="">
                                          </div>';
                                endif
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Followed topics</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <?php
                                if(!empty($followed_topics)):
                                ?>
                                <div class="d-block w-100 subTopics-usage-block">
                                    <?php
                                    $read_one = array();
                                    foreach($followed_topics as $value):
                                        if(!$value || in_array($value, $read_one))
                                            continue;

                                        array_push($read_one, $value);
                                        $topic = get_the_category_by_ID($value);
                                        $note = 0;
                                        if(!$topic)
                                            continue;
                                        if(!empty($skills_note))
                                            foreach($skills_note as $skill)
                                                if($skill['id'] == $value)
                                                    $note = $skill['note'];
                                        $name_topic = (String)$topic;
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
                                        <p class="number"><?= $note ?> / 100</p>
                                    </a>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <?php
                                else:
                                    echo '<div class="empty-topic-block">
                                             <img src="' . get_stylesheet_directory_uri() . '/img/empty-topic.png" alt="">
                                          </div>';
                                endif
                                ?>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Followed teachers</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                <?php
                                if(!empty($followed_teachers)):
                                ?>
                                <div class="d-block w-100 subTopics-usage-block">
                                    <?php
                                    $read_one = array();
                                    foreach($followed_teachers as $value):
                                        if(!$value || in_array($value, $read_one))
                                            continue;

                                        array_push($read_one, $value);
                                        $user = get_user_by('ID', $value);
                    
                                        $name_user = ($user->first_name) ? : $user->display_name;
                                        $image_user = get_field('profile_img',  'user_' . $value->ID);
                                        $image_user = $image_user ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';                
                                    ?>
                                    <a href="/user-overview?id=<?= $value ?>" class="element-SubTopics d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div class="imgTopics">
                                                <img src="<?= $image_user ?>" alt="">
                                            </div>
                                            <p class="text-subTopics"><?= $name_user ?></p>
                                        </div>
                                        <p class="number"></p>
                                    </a>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <?php
                                else:
                                    echo '<div class="empty-topic-block">
                                             <img src="' . get_stylesheet_directory_uri() . '/img/empty-topic.png" alt="">
                                          </div>';
                                endif
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="theme-card-statistiken-1">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                    <p class="title">Most Viewed Expert</p>
                                    <!-- <div class="select">
                                        <select>
                                            <option value="Year">Year</option>
                                            <option value="Month">Month</option>
                                            <option value="Day">Day</option>
                                        </select>
                                        <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                    </div> -->
                                </div>
                                
                                <div class="d-block w-100 subTopics-usage-block">
                                    <p class="text-stat"></p>
                                    <?php
                                    if($expert_views):
                                        foreach($expert_views as $key => $expert):
                                            $value = $expert->data_id;
                                            $occurence = $expert->occurence;
                                            if(!$value && in_array($value, $read_one))
                                                continue;

                                            $user = get_user_by_id('ID', $value);
                        
                                            $name_user = ($user->first_name) ? : $user->display_name;
                                            $image_user = get_field('profile_img',  'user_' . $value->ID);
                                            $image_user = $image_user ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                            ?>
                                            <a href="#" class="element-SubTopics d-flex justify-content-between">
                                            <div class="d-flex">
                                                <div class="imgTopics">
                                                    <img src="<?= $image_user ?>" alt="">
                                                </div>
                                                <p class="text-subTopics"><?= $name_user ?></p>
                                            </div>
                                            <p class="number"><?= $occurence ?></p>
                                        </a>
                                        <?php
                                        endforeach;
                                    else:
                                        echo '<div class="empty-topic-block">
                                                <img src="' . get_stylesheet_directory_uri() . '/img/empty-topic.png" alt="">
                                            </div>';
                                    endif
                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>
                   <div class="row">
                      <div class="col-md-12">
                          <div class="theme-card-statistiken-1 mb-4 position-relative height-fit-content">
                              <div class="head-card d-flex justify-content-between align-items-center">
                                  <p class="title">Usage desktop vs Mobile app</p>
                                  <!-- <div class="select">
                                      <select>
                                          <option value="Year">OOH</option>
                                          <option value="Month">Month</option>
                                          <option value="Day">Day</option>
                                      </select>
                                      <div>
                                          <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                      </div>
                                  </div> -->
                              </div>
                              <div class="w-100">
                                  <canvas id="Usage-desktop"></canvas>
                              </div>
                          </div>
                      </div>
                      <!-- 
                      <div class="col-md-4">
                          <div class="theme-card-statistiken-1">
                              <div class="head-card d-flex justify-content-between align-items-center">
                                  <p class="title">Followed topics</p>
                                  <div class="select">
                                      <select>
                                          <option value="Year">Year</option>
                                          <option value="Month">Month</option>
                                          <option value="Day">Day</option>
                                      </select>
                                      <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                  </div>
                              </div>
                              <div class="d-block w-100 subTopics-usage-block">
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>
                                  <div class="element-SubTopics d-flex justify-content-between">
                                      <div class="d-flex">
                                          <div class="imgTopics">
                                              <img src="<?php echo get_stylesheet_directory_uri();?>/img/skills2.png" alt="">
                                          </div>
                                          <p class="text-subTopics">ux/ui Designerf</p>
                                      </div>
                                      <a href="" class="number">Apply</a>
                                  </div>

                              </div>

                          </div>
                      </div> -->
                      <div class="col-md-12">
                          <div class="theme-card-statistiken-1 mb-4 position-relative height-fit-content">
                                <div class="head-card d-flex justify-content-between align-items-center">
                                  <p class="title">Latest badges</p>
                                  <!-- <div class="select">
                                      <select>
                                          <option value="See-all">See all</option>
                                      </select>
                                      <div>
                                          <img class="image-filter" src="<?php echo get_stylesheet_directory_uri();?>/img/Icon-filter-list.png" alt="">
                                      </div>
                                  </div> -->
                                </div>
                                <?php
                                if (!empty($badges)):
                                ?>
                                    <div class="block-with-content-badge d-flex flex-wrap">
                                        <?php
                                        foreach ($badges as $key => $badge):
                                        if($key == 3)
                                            break;
                                        // Image + trigger
                                        $image_badge = get_field('image_badge', $badge->ID);
                                        $trigger_badge = get_field('trigger_badge', $badge->ID);
                                        $level_badge = get_field('level_badge', $badge->ID);
                                        ?>
                                        <div class="card-badge">
                                            <div class="img-card-badge">
                                                <img src="<?= $image_badge ?>" alt="">
                                            </div>
                                            <p class="title-badge">Badge <?= $level_badge?></p>
                                            <p class="statut-text"><?= $badge->post_title ?></p>
                                            <div class="bar-badge"></div>
                                            <p class="statut-badge"><?= $trigger_badge ?></p>
                                        </div>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>
                                <?php
                                else:
                                    echo '
                                        <div class="block-empty-badge">
                                            <img src="' . get_stylesheet_directory_uri() . '/img/empty-badge.png" alt="">
                                        </div>';
                                endif;
                                ?>
                          </div>
                      </div>
                  </div>

                </div>
            </ul>

            <ul id="Interne-groei" class="hide">

                <div class="contentBlockSetting">
                    <div class="content">
                        <form action="" method="POST">

                            <div class="form-group formModifeChoose">

                                <select class="multipleSelect2" name="selected_subtopics[]" multiple="true" required>
                                    <?php

                                    foreach($subtopics as $value){
                                        echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="manager" value=<?php $manager->ID?> >
                                <input type="hidden" name="id_user" value=<?php $user->ID?> >
                                <button name="add_internal_growth" class="btn btnVoegTab " type="submit">Voeg toe</button>
                            </div>

                            <?php
                            if (!empty (get_user_meta($user->ID,'topic_affiliate')))
                            {
                            ?>


                                <div class="inputGroein">
                                    <?php
                                    foreach($internal_growth_subtopics as $value){
                                        echo "
                                            <form action='/dashboard/user/' method='POST'>
                                            <input type='hidden' name='meta_value' value='". $value . "' id=''>
                                            <input type='hidden' name='user_id' value='". $user->ID . "' id=''>
                                            <input type='hidden' name='meta_key' value='topic_affiliate' id=''>";
                                        echo "<p> <button type='submit' name='delete' style='border:none;background:#C7D8F5'><i style='font-size 0.5em; color:white'class='fa fa-trash'></i>&nbsp;".(String)get_the_category_by_ID($value)."</button></p>";
                                        echo "</form>";
                                        ?>


                                        <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            }else {
                                echo "<p>No topics yet</p>" ;
                            }
                            ?>
                        </form>
                    </div>
                </div>

            </ul>

            <ul id="Externe-groei" class="hide">
                <div id="Externe-groei" class="contentBlockSetting">
                    <div class="content">
                        <div class="inputGroein">

                            <?php
                             if (!empty (get_user_meta($user->ID,'topic')))
                                {
                                    $external_growth_subtopics = get_user_meta($user->ID,'topic');
                                    ?>

                            <div class="inputGroein">
                                <?php
                                   foreach($external_growth_subtopics as $value){
                                        echo "<p>".(String)get_the_category_by_ID($value)."</p>";
                                    }

                                    ?>
                            </div>

                            <?php
                             }else {
                                    echo "<p>No topics yet</p>" ;
                                }
                                ?>

                        </div>
                    </div>
                </div>
            </ul>

            <ul id="Feedback" class="hide">
                <div class="sub-to-do d-flex justify-content-between align-items-center">
                    <p class="text-to-do-for">Feedback for <?= $user->display_name ?></p>
                    <button class="btn btn-add-to-do" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Add Feedback</button>

                    <!-- Modal Add to do -->

                    <div class="modal fade new-modal-to-do" id="Add-Feedback-Modal" tabindex="-1" role="dialog" aria-labelledby="to-do-ModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="MandatoryModalLabel">Feedback</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="content-block-bg">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="element-FEEDBACK" data-target="FEEDBACK" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">FEEDBACK</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-ONTWIKKELPLAN" data-target="ONTWIKKELPLAN" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">ONTWIKKELPLAN</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-BEOORDELING" data-target="BEOORDELING" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">BEOORDELING</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="element-COMPLIMENT" data-target="COMPLIMENT" class="element-trigger block-one-add-element">
                                                    <div>
                                                        <p class="title">COMPLIMENT</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="detail-content-modal content-FEEDBACK">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Feedback</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="/dashboard/user">
                                            <input type="hidden" name="type" value="Feedback">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >

                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van feedback</label>
                                                <input type="text" class="form-control" id="" name="title_feedback" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Beschrijf de feedback</label>
                                                <textarea class="message-area" name="beschrijving_feedback" id="" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar de feedback over gaat</label>
                                                <textarea class="message-area" name="competencies_feedback" id="" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group position-relative">
                                                <label for="">Geef een rating </label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Geef" class="stars" name="rating_feedback" value="5" />
                                                        <label class="star" for="star5-Geef" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Geef" class="stars" name="rating_feedback" value="4" />
                                                        <label class="star" for="star4-Geef" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Geef" class="stars" name="rating_feedback" value="3" />
                                                        <label class="star" for="star3-Geef" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Geef" class="stars" name="rating_feedback" value="2" />
                                                        <label class="star" for="star2-Geef" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Geef" name="rating_feedback" value="1" />
                                                        <label class="star" for="star1-Geef" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hoe te verbeteren / overige opmerkingen?</label>
                                                <textarea class="message-area" name="opmerkingen" id="" rows="5" required></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="anoniem-versturen" name="anoniem_feedback" value="JA">
                                                <label class="sub-label-check" for="anoniem-versturen">Anoniem versturen ?</label>
                                            </div>

                                            <button type="submit" class="btn btn-submi-form-to-do" name="add_todo_feedback">Stuur feedback</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-ONTWIKKELPLAN">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Ontwikkelplan</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="/dashboard/user">
                                            <input type="hidden" name="type" value="Persoonlijk ontwikkelplan">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >

                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van ontwikkelplan</label>
                                                <input type="text" class="form-control" id="" name="title_persoonlijk" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar het ontwikkelen over gaat</label>
                                                <textarea class="message-area" id="" rows="3" name="competencies_feedback" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Wat wil je dat er bereikt wordt?</label>
                                                <textarea class="message-area" name="wat_bereiken" id="" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hoe denk je dat dit het best bereikt kan worden? </label>
                                                <textarea class="message-area" name="hoe_bereiken" id="" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group d-flex">
                                                <label for="">Denk je dat er hulp bij nodig is?</label>
                                                <div class="d-flex">
                                                    <div class="d-flex checkbokElement mr-3">
                                                        <input type="radio" id="JA" name="hulp_radio_JA" value="JA">
                                                        <label class="sub-label-check" for="Anoniem-versturen?">Ja</label>
                                                    </div>
                                                    <div class="d-flex checkbokElement ">
                                                        <input type="radio" id="NEE" name="hulp_radio_JA" value="NEE">
                                                        <label class="sub-label-check" for="Nee">Nee</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Huidige waardering (voor ontwikkelplan)</label>
                                                <div class="rating-element">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Geef" class="stars" name="rating_feedback" value="5" />
                                                        <label class="star" for="star5-Geef" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Geef" class="stars" name="rating_feedback" value="4" />
                                                        <label class="star" for="star4-Geef" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Geef" class="stars" name="rating_feedback" value="3" />
                                                        <label class="star" for="star3-Geef" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Geef" class="stars" name="rating_feedback" value="2" />
                                                        <label class="star" for="star2-Geef" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Geef" name="rating_feedback" value="1" />
                                                        <label class="star" for="star1-Geef" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="">Overrige opmerkingen?</label>
                                                <textarea class="message-area" name="opmerkingen" id="" rows="5" required></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="anoniem-versturen" name="anoniem_feedback" value="JA">
                                                <label class="sub-label-check" for="anoniem-versturen">Anoniem versturen ?</label>
                                            </div>

                                            <button name="add_todo_persoonlijk" type="submit" class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>
                                    </div>
                                    <div class="detail-content-modal content-BEOORDELING">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Beoordeling</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="/dashboard/user">
                                            <input type="hidden" name="type" value="Beoordeling Gesprek">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van beoordeling</label>
                                                <input type="text" class="form-control" id="" name="title_beoordelingsgesprek" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar de beoordeling over gaat</label>
                                                <textarea class="message-area" name="competencies_feedback" id="" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Algemene beoordeling bovenstaande competenties</label>
                                                <textarea class="message-area" name="algemene_beoordeling" id="" rows="3" required></textarea>
                                            </div>
                                            <?php
                                            if(!empty($internal_growth_subtopics))
                                                foreach($internal_growth_subtopics as $key =>  $value){
                                                    echo '<div class="form-group position-relative">';
                                                    echo '<label for="">Beoordeling competentie “'.lcfirst((String)get_the_category_by_ID($value)).'”</label>';
                                                    echo '<div class="rating-element">';
                                                    echo '<div class="rating" id="selected_stars_'.($key+1).'">
                                                            <input type="radio" id="star5_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="5" />
                                                            <label class="star mt-4" for="star5_'.$key.'" title="Awesome" aria-hidden="true"></label>
                                                            <input type="radio" id="star4_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="4" />
                                                            <label class="star mt-4" for="star4_'.$key.'" title="Great" aria-hidden="true"></label>
                                                            <input type="radio" id="star3_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="3" />
                                                            <label class="star mt-4" for="star3_'.$key.'" title="Very good" aria-hidden="true"></label>
                                                            <input type="radio" id="star2_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="2" />
                                                            <label class="star mt-4" for="star2_'.$key.'" title="Good" aria-hidden="true"></label>
                                                            <input type="radio" id="star1_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="1" />
                                                            <label class="star mt-4" for="star1_'.$key.'" title="Bad" aria-hidden="true"></label>
                                                          </div>';
                                                    echo '<span class="rating-counter"></span>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                            ?>
                                            <div class="form-group">
                                                <label for="dateDone">Voor welke datum?</label>
                                               <div class="d-flex">
                                                    <input type="date" class="form-control mr-3" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]">
                                                    <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ"  name="welke_datum_feedback[]">
                                               </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Overige opmerkingen?</label>
                                                <textarea class="message-area" name="opmerkingen" id="" rows="5" required></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="anoniem-versturen" name="anoniem_feedback" value="JA">
                                                <label class="sub-label-check" for="anoniem-versturen">Anoniem versturen ?</label>
                                            </div>

                                            <button name="add_todo_beoordelingsgesprek" type="submit" class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>

                                    </div>
                                    <div class="detail-content-modal content-COMPLIMENT">
                                        <div class="head-detail-form">
                                            <button class="btn btn-back-frist-element">
                                                <i class="fa fa-angle-left"></i>
                                                <span>Compliment</span>
                                            </button>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" class="form-to-do" action="/dashboard/user">
                                            <input type="hidden" name="type" value="Compliment">
                                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                            <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                            <div class="form-group">
                                                <label for="maneMandatory">Titel van Compliment</label>
                                                <input type="text" class="form-control" id="" name="title_beoordelingsgesprek" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Competenties waar het compliment over gaat</label>
                                                <textarea class="message-area" name="competencies_feedback" id="" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Waarom een compliment?</label>
                                                <textarea class="message-area" name="beschrijving_feedback" id="" rows="3" required></textarea>
                                            </div>
                                            <?php
                                            if(!empty($internal_growth_subtopics))
                                                foreach($internal_growth_subtopics as $key =>  $value){
                                                    echo '<div class="form-group position-relative">';
                                                    echo '<label for="">Beoordeling competentie “'.lcfirst((String)get_the_category_by_ID($value)).'”</label>';
                                                    echo '<div class="rating-element">';
                                                    echo '<div class="rating" id="selected_stars_'.($key+1).'">
                                                            <input type="radio" id="star5_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="5" />
                                                            <label class="star mt-4" for="star5_'.$key.'" title="Awesome" aria-hidden="true"></label>
                                                            <input type="radio" id="star4_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="4" />
                                                            <label class="star mt-4" for="star4_'.$key.'" title="Great" aria-hidden="true"></label>
                                                            <input type="radio" id="star3_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="3" />
                                                            <label class="star mt-4" for="star3_'.$key.'" title="Very good" aria-hidden="true"></label>
                                                            <input type="radio" id="star2_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="2" />
                                                            <label class="star mt-4" for="star2_'.$key.'" title="Good" aria-hidden="true"></label>
                                                            <input type="radio" id="star1_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="1" />
                                                            <label class="star mt-4" for="star1_'.$key.'" title="Bad" aria-hidden="true"></label>
                                                          </div>';
                                                    echo '<span class="rating-counter"></span>';
                                                    echo '</div>';
                                                    echo '</div>';
                                                }
                                            ?>
                                            <div class="form-group">
                                                <label for="dateDone">Compliment voor de periode van .. tot</label>
                                                <div class="d-flex">
                                                    <input type="date" class="form-control mr-3" id="" placeholder="DD / MM / JJJJ" name="welke_datum_feedback[]">
                                                    <input type="date" class="form-control" id="" placeholder="DD / MM / JJJJ"  name="welke_datum_feedback[]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Overige opmerkingen?</label>
                                                <textarea class="message-area" name="opmerkingen" id="" rows="5"></textarea>
                                            </div>
                                            <div class="form-group d-flex checkbokElement">
                                                <input type="checkbox" id="anoniem-versturen" name="anoniem_feedback" value="JA">
                                                <label class="sub-label-check" for="anoniem-versturen">Anoniem versturen ?</label>
                                            </div>

                                            <button name="add_todo_beoordelingsgesprek" type="submit" class="btn btn-submi-form-to-do">Stuur</button>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="body-content-to-do">
                    <div class="content-tab">
                        <div class="content-button-tabs">
                            <?php
                            $count_todos = (!empty($todos)) ? count($todos) : 0;
                            ?>
                            <button data-tab="AllFeddback" class="b-nav-tab btn active">
                                All <span class="number-content"><?= $count_todos ?></span>
                            </button>
                            <?php
                            $count_feedback = (!empty($feedbacks)) ? count($feedbacks) : 0;
                            ?>
                            <button data-tab="FeddbackSecond" class="b-nav-tab btn">
                                Feedback <span class="number-content"><?= $count_feedback ?></span>
                            </button>
                            <?php
                            $count_ontwikkelplan = (!empty($persoonlijk_ontwikkelplan)) ? count($persoonlijk_ontwikkelplan) : 0;
                            ?>
                            <button data-tab="Ontwikkelplan" class="b-nav-tab btn">
                                Ontwikkelplan <span class="number-content"><?= $count_ontwikkelplan ?></span>
                            </button>
                            <?php
                            $count_beoordeling = (!empty($beoordeling_gesprek)) ? count($beoordeling_gesprek) : 0;
                            ?>
                            <button data-tab="Beoordeling" class="b-nav-tab btn">
                                Beoordeling <span class="number-content"><?= $count_beoordeling ?></span>
                            </button>
                            <?php
                            $count_compliment = (!empty($compliments)) ? count($compliments) : 0;
                            ?>
                            <button data-tab="Compliment" class="b-nav-tab btn">
                                Compliment <span class="number-content"><?= $count_compliment ?></span>
                            </button>
                            <?php
                            $count_verplichte = (!empty($verplichte_cursus)) ? count($verplichte_cursus) : 0;
                            ?>
                            <!-- <button data-tab="Verplichte" class="b-nav-tab btn">
                                Verplichte <span class="number-content"><?= $count_verplichte ?></span>
                            </button> -->
                            <?php
                            $count_gedeelde = (!empty($gedeelde_cursus)) ? count($gedeelde_cursus) : 0;
                            ?>
                            <!-- <button data-tab="Gedeelde" class="b-nav-tab btn">
                            Gedeelde <span class="number-content"><?= $count_gedeelde?></span>
                            </button> -->
                            <!-- <button data-tab="empty-" class="b-nav-tab btn">
                                Empty <span class="number-content">0</span>
                            </button> -->
                        </div>

                        <div id="AllFeddback" class="b-tab active contentBlockSetting">
                            <?php
                            if(!empty($todos)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Details</th>
                                    <!-- <th scope="col">Due-date</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($todos as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = get_field('type_feedback', $todo->ID);
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));

                                    $rating = get_field('rating_feedback', $todo->ID);
                                    $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';

                                    $max_rate = 0;
                                    $stars = 0;
                                    if($type == 'Beoordeling Gesprek'){
                                        $rates_comment = explode(';', get_field('rate_comments', $todo->ID));
                                        $max_rate = count($rates_comment);
                                        $count_rate = 0;
                                        $stars = 0;
                                        for($i=0; $i<$max_rate; $i++){
                                            $stars = $stars + intval($rates_comment[$i+1]);
                                            $count_rate += 1;
                                            $i = $i + 2;
                                        }
                                        
                                        if($count_rate){
                                            $rating = intval($stars / $count_rate);
                                            $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $todo->post_title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td class="position-relative">
                                            <?php echo $rating ?>
                                        </td>
                                        <td>
                                            <a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>" class="btn view-detail">View details</a>
                                        </td>
                                        <!-- 
                                        <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td> 
                                        -->
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li> 
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="FeddbackSecond" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($feedbacks)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Details</th>
                                    <!-- <th scope="col">Due-date</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($feedbacks as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = get_field('type_feedback', $todo->ID);
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));

                                    $rating = get_field('rating_feedback', $todo->ID);
                                    $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $todo->post_title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td class="position-relative">
                                            <?php echo $rating ?>
                                            <!-- <div class="rating-element">
                                                <div class="rating">
                                                    <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                    <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                    <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                    <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                    <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                    <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div> -->
                                        </td>
                                        <td>
                                            <a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>" class="btn view-detail">View details</a>
                                        </td>
                                        <!-- <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td> -->
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li> 
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Ontwikkelplan" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($persoonlijk_ontwikkelplan)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Details</th>
                                    <!-- <th scope="col">Due-date</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($persoonlijk_ontwikkelplan as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = get_field('type_feedback', $todo->ID);
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));

                                    $rating = get_field('rating_feedback', $todo->ID);
                                    $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $todo->post_title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td class="position-relative">
                                            <?php echo $rating ?>
                                        </td>
                                        <td>
                                            <a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>" class="btn view-detail">View details</a>
                                        </td>
                                        <!-- <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td> -->
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Beoordeling" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($beoordeling_gesprek)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($beoordeling_gesprek as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = get_field('type_feedback', $todo->ID);
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));

                                    $rating = get_field('rating_feedback', $todo->ID);
                                    $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';

                                    $max_rate = 0;
                                    $stars = 0;
                                    if($type == 'Beoordeling Gesprek'){
                                        $rates_comment = explode(';', get_field('rate_comments', $todo->ID));
                                        $max_rate = count($rates_comment);
                                        $count_rate = 0;
                                        $stars = 0;
                                        for($i=0; $i<$max_rate; $i++){
                                            $stars = $stars + intval($rates_comment[$i+1]);
                                            $count_rate += 1;
                                            $i = $i + 2;
                                        }
                                        
                                        if($count_rate){
                                            $rating = intval($stars / $count_rate);
                                            $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';
                                        }
                                    }

                                    $due_date = get_field('welke_datum_feedback', $todo->ID)[1];
                                    $due_date = date("d/m/Y", strtotime($due_date));
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $todo->post_title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td class="position-relative">
                                            <?php echo $rating ?>
                                        </td>
                                        <td>
                                            <a href="/dashboard/user/detail-notification/?do=<?php echo $todo->ID; ?>" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element"><?= $due_date ?></p>
                                        </td>
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>   

                        <div id="Compliment" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($compliments)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Details</th>
                                    <th scope="col">Due-date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($compliments as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = get_field('type_feedback', $todo->ID);
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));

                                    $rating = get_field('rating_feedback', $todo->ID);
                                    $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️';

                                    $max_rate = 0;
                                    $stars = 0;
                                    if($type == 'Beoordeling Gesprek'){
                                        $rates_comment = explode(';', get_field('rate_comments', $todo->ID));
                                        $max_rate = count($rates_comment);
                                        $count_rate = 0;
                                        $stars = 0;
                                        for($i=0; $i<$max_rate; $i++){
                                            $stars = $stars + intval($rates_comment[$i+1]);
                                            $count_rate += 1;
                                            $i = $i + 2;
                                        }
                                        
                                        if($count_rate){
                                            $rating = intval($stars / $count_rate);
                                            $rating = ($rating) ? str_repeat("⭐ ", $rating) : '✖️'; 
                                        }
                                    }

                                    $due_date = get_field('welke_datum_feedback', $todo->ID)[1];
                                    $due_date = date("d/m/Y", strtotime($due_date));
                                    
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $todo->post_title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td class="position-relative">
                                           <?php echo $rating ?>
                                        </td>
                                        <td>
                                            <a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>" class="btn view-detail">View details</a>
                                        </td>
                                        <td>
                                            <p class="text-other-element"><?= $due_date ?></p>
                                        </td>
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>  

                        <div id="Verplichte" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($verplichte_cursus)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Details</th>
                                    <!-- <th scope="col">Due-date</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($verplichte_cursus as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = get_field('type_feedback', $todo->ID);
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $todo->post_title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td class="position-relative">
                                            <div class="rating-element">
                                                <div class="rating">
                                                    <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                    <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                    <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                    <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                    <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                    <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>" class="btn view-detail">View details</a>
                                        </td>
                                        <!-- <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td> -->
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="Gedeelde" class="b-tab contentBlockSetting">
                            <?php
                            if(!empty($gedeelde_cursus)):
                            ?>
                            <table class="table table-responsive table-to-do text-left">
                                <thead>
                                <tr>
                                    <th scope="col courseTitle">Feedback</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Details</th>
                                    <!-- <th scope="col">Due-date</th> -->
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody class="text-left">
                                    <?php
                                    foreach($gedeelde_cursus as $todo):
                                    // if($key == 8)
                                    //     break;

                                    $type = get_field('type_feedback', $todo->ID);
                                    $manager = get_user_by('ID', get_field('manager_feedback', $todo->ID));

                                    $image = get_field('profile_img',  'user_' . $manager->ID);
                                    if(!$image)
                                        $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                                    
                                    $display = $manager->first_name ? $manager->first_name : $manager->display_name;
                                    $display = ($superior->ID == $manager->ID) ? 'You' : $display; 

                                    $display = ($display) ?: 'Anonymous'; 

                                    $post_date = date("d M Y | h:i", strtotime($todo->post_date));
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgCourse">
                                                    <img src="<?= $image ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="text-date"><b><?= $display ?></b>  <?= $post_date ?> </p>
                                                    <p class="text-date mb-0"><?= $todo->post_title ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-other-element" id="mr-element"><?= $type ?></p>
                                        </td>
                                        <td class="position-relative">
                                            <div class="rating-element">
                                                <div class="rating">
                                                    <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                    <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                    <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                    <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                    <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                    <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="/dashboard/user/detail-notification/?todo=<?php echo $todo->ID; ?>" class="btn view-detail">View details</a>
                                        </td>
                                        <!-- <td>
                                            <p class="text-other-element">04/08/2024</p>
                                        </td> -->
                                        <td class="textTh">
                                            <!-- <div class="dropdown text-white">
                                                <p class="dropdown-toggle dropdownTable-to-do mb-0" type="" data-toggle="dropdown">
                                                    <img style="width:20px" src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt="" srcset="">
                                                </p>
                                                <ul class="dropdown-menu">
                                                    <li class="my-1"><i class="fa fa-ellipsis-vertical"></i><i class="fa fa-eye px-2"></i><a href="">Bekijk</a></li>
                                                    <li class="my-2"><i class="fa fa-gear px-2"></i><a href="">Pas aan</a></li>
                                                    <li class="my-1 remove_opleidingen" id="live"><i class="fa fa-trash px-2"></i><input type="button"  value="Verwijderen"/></li>
                                                </ul>
                                            </div> -->
                                        </td>
                                    </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                            <?php
                            else:
                            ?>
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <button class="btn btn-creer-eeen" type="button" data-toggle="modal" data-target="#Add-Feedback-Modal">Creëer een eerste to do</button>
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div id="empty-" class="b-tab contentBlockSetting">
                            <div class="block-empty-content">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/empty-to-do-table.png" alt="">
                                <a href="#" class="btn btn-creer-eeen">Creëer een eerste to do</a>
                            </div>
                        </div>
                    </div>
                </div>
            </ul>

        </div> <!-- END List Wrap -->

    </div>

    <div class="modal modalEdu fade show" id="exampleModalWork" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 93% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nieuw toevoegen </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="firstBlockVoeg">
                        <h2 class="voegToeText">Voeg toe</h2>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg1">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/feedback.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Feedback</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg2">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/personal-development.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Persoonlijk Ontwikkelplan</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg3">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/personal-development2.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Beoordeling Gesprek</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="boxVoeg" id="boxVoeg4">
                                    <div class="imgoxVoeg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/conversation.png" alt="">
                                    </div>
                                    <p class="titleBoxVoeg">Compliment</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="secondBlockVoeg">
                        <form action="/dashboard/company/profile" method="POST">
                            <h2 class="voegToeText">Voeg toe</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Title feedback</label>
                                    <input name="title_feedback" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Onderwerp feedback</label>
                                    <div class="form-group formModifeChoose">
                                        <select id="form-control-skills" name="onderwerp_feedback[]"  class="multipleSelect2" multiple="true" required>

                                            <?php
                                            //Subtopics
                                            foreach($subtopics as $value){
                                                echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Beschrijving</label>
                                    <textarea name="beschrijving_feedback" id="" rows="4" required></textarea>
                                </div>
                            </div>
                            <div>

                                <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                <input type="hidden" name="type" value="Feedback">
                            </div>
                            <div class="">
                                <button class="btn btnSaveSetting" name="add_todo_feedback" >Save</button>
                            </div>
                    </div>
                    </form>
                    <div class="treeBlockVoeg">
                        <form action="/dashboard/company/profile" method="POST">
                            <h2 class="voegToeText">Persoonlijk ontwikkelplan</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Title persoonlijk ontwikkelplan</label>
                                    <input name="title_persoonlijk" type="text" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Onderwerp PoP</label>
                                    <div class="form-group formModifeChoose">
                                        <select id="form-control-skills" class="multipleSelect2" name="onderwerp_pop[]" multiple="true" required>

                                            <?php
                                            //Subtopics
                                            foreach($subtopics as $value){
                                                echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Wat wil je bereiken ?</label>
                                    <textarea name="wat_bereiken" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Hoe ga je dit bereiken ?</label>
                                    <textarea name="hoe_bereiken" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Heb je hierbij hulp nodig ?</label>
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <input type="radio" id="JA" name="hulp_radio_JA" value="JA">
                                            <label for="JA">JA</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="NEE" name="hulp_radio_JA" value="NEE">
                                            <label for="NEE">NEE</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Opmerkingen ?</label>
                                    <textarea name="opmerkingen" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <button class="btn btnSaveSetting" name="add_todo_persoonlijk" >Save</button>
                                <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                <input type="hidden" name="type" value="Persoonlijk ontwikkelplan">
                            </div>
                        </form>
                    </div>
                    <form action="/dashboard/company/profile" method="POST">
                        <div class="fourBlockVoeg">
                            <div class="sousBlockFourBlockVoeg1">
                                <h2 class="voegToeText">Beoordelingsgesprek</h2>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Title Beoordelingsgesprek</label>
                                        <input name="title_beoordelingsgesprek" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Cijfers interne groei</label>


                                        <?php
                                        if (!empty (get_user_meta($user->ID,'topic_affiliate')))
                                        {
                                            $internal_growth_subtopics= get_user_meta($user->ID,'topic_affiliate');
                                            foreach($internal_growth_subtopics as $key =>  $value){

                                                echo '<div class="bloclCijfers" style="height: 52px">';
                                                echo '<p class="mb-0" style="width: 20%;">'.lcfirst((String)get_the_category_by_ID($value)).'</p>';
                                                echo '<div class="rating" id="selected_stars_'.($key+1).'">
                                                        <input type="radio" id="star5_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="5" />
                                                        <label class="star mt-4" for="star5_'.$key.'" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="4" />
                                                        <label class="star mt-4" for="star4_'.$key.'" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="3" />
                                                        <label class="star mt-4" for="star3_'.$key.'" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="2" />
                                                        <label class="star mt-4" for="star2_'.$key.'" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1_'.$key.'" name="'.lcfirst((String)get_the_category_by_ID($value)).'_rate" value="1" />
                                                        <label class="star mt-4" for="star1_'.$key.'" title="Bad" aria-hidden="true"></label>
                                                    </div>';

                                                echo '<div class="">
                                                            <div hidden class="group-input-settings" id="commentaire_hidden_'.($key+1).'">
                                                                <label for="">'.lcfirst((String)get_the_category_by_ID($value)).' toelichting</label>
                                                                <textarea name="'.lcfirst((String)get_the_category_by_ID($value)).'_toelichting" id="" rows="5" cols="85"></textarea>
                                                            </div>
                                                        </div>';
                                                echo '</div>';

                                            }
                                        }

                                        ?>

                                    </div>

                                </div>
                                <div class="">
                                    <input type="button" value="Volgende"  class="btn btnSaveSetting" id="volgende2">
                                </div>
                            </div>

                        </div>

                        <div class="sousBlockFourBlockVoeg3">
                            <h2 class="voegToeText">Beoordelingsgesprek</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Algemene beoordeling</label>
                                    <textarea name="algemene_beoordeling" id="" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <input type="hidden" name="manager" value=<?=$superior->ID?> >
                                <input type="hidden" name="id_user" value=<?=$user->ID?> >
                                <input type="hidden" name="type" value="Beoordeling Gesprek">
                                <input type="submit" name="add_todo_beoordelingsgesprek" value="Save"  class="btn btnSaveSetting" >
                            </div>
                        </div>
                </div>
                </form>
                <form action="/dashboard/company/profile" method="post">
                    <div class="fiveBlockVoeg">
                        <h2 class="voegToeText">Compliment</h2>
                        <div class="col-lg-12 col-md-12">
                            <div class="group-input-settings">
                                <label for="">Title compliment</label>
                                <input name="title_feedback" type="text" required>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="group-input-settings">
                                <label for="">Onderwerp compliment</label>
                                <div class="form-group formModifeChoose">
                                    <select id="form-control-skills" name="onderwerp_feedback[]" class="multipleSelect2" multiple="true" required>

                                        <?php
                                        //Subtopics
                                        foreach($subtopics as $value){
                                            echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="group-input-settings">
                                <label for="">Beschrijving compliment</label>
                                <textarea name="beschrijving_feedback" id="" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="">
                            <input type="hidden" name="manager" value=<?=$superior->ID?> >
                            <input type="hidden" name="id_user" value=<?=$user->ID?> >
                            <input type="hidden" name="type" value="Compliment">
                            <button class="btn btnSaveSetting" name="add_todo_compliment" >Save</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>
<script src="https://rawgit.com/andreruffert/rangeslider.js/develop/dist/rangeslider.min.js"></script>


<script>
    $("#internal_output").hide();
    $("#internal_output").hide();
    $("#input-intern-extern").change(function() {
        if(this.val()) == "internal" {
            $("#internal_output").show();
        } else {
            $("#external_output").show();
        }
    });
</script>

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

<script>
    $(document).ready(function() {
        $(".selectpicker").selectpicker();

    })
</script>

<script>
    'use strict';

    function Tabs() {
        var bindAll = function() {
            var menuElements = document.querySelectorAll('[data-tab]');
            for(var i = 0; i < menuElements.length ; i++) {
                menuElements[i].addEventListener('click', change, false);
            }
        };

        var clear = function() {
            var menuElements = document.querySelectorAll('[data-tab]');
            for(var i = 0; i < menuElements.length ; i++) {
                menuElements[i].classList.remove('active');
                var id = menuElements[i].getAttribute('data-tab');
                document.getElementById(id).classList.remove('active');
            }
        };

        var change = function(e) {
            clear();
            e.target.classList.add('active');
            var id = e.currentTarget.getAttribute('data-tab');
            document.getElementById(id).classList.add('active');
        };

        bindAll();

        //window.location.hash = target_panel_selector ;
        if(history.pushState) {
            history.pushState(null, null, target_panel_selector);
        } else {
            window.location.hash = target_panel_selector;
        }
        return false;
    }

    var connectTabs = new Tabs();

</script>

<script>
    $(document).ready(function() {
        $(".js-select2").select2();
        $(".js-select2-multi").select2();

        $(".large").select2({
            dropdownCssClass: "big-drop",
        });
    });
</script>

<script>

    // Afficher un champ de commentaire spécifique aprés avoir noté un topics sur le modal des feedbacks
    $(".rate.feedback").click(function() {
        var id = $(this).attr('id');
        console.log("#commentaire_hidden_"+id.substr(-1));
        $("#commentaire_hidden_"+id.substr(-1)).attr("hidden",function(n, v){
            return false;
        });
    });


    /**
     * Defines the bootstrap tabs handler.
     *
     * @param {string} element
     *  Element.
     */
    var tabsActions = function (element) {
        this.element = $(element);

        this.setup = function () {
            if (this.element.length <= 0) {
                return;
            }
            this.init();
            // Update after resize window.
            var resizeId = null;
            $(window).resize(function () {
                clearTimeout(resizeId);
                resizeId = setTimeout(() => {this.init()}, 50);
            }.bind(this));
        };

        this.init = function () {

            // Add class to overflow items.
            this.actionOverflowItems();
            var tabs_overflow = this.element.find('.overflow-tab');

            // Build overflow action tab element.
            if (tabs_overflow.length > 0) {
                if (!this.element.find('.overflow-tab-action').length) {
                    var tab_link = $('<a>')
                        .addClass('nav-link')
                        .attr('href', '#')
                        .attr('data-toggle', 'dropdown')
                        .text('...')
                        .on('click', function (e) {
                            e.preventDefault();
                            $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').toggle();
                        });

                    var overflow_tab_action = $('<li>')
                        .addClass('nav-item')
                        .addClass('overflow-tab-action')
                        .append(tab_link);

                    // Add hide to overflow tabs when click on any tab.
                    this.element.find('.nav-link').on('click', function (e) {
                        $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').hide();
                    });
                    this.element.append(overflow_tab_action);
                }

                this.openOverflowDropdown();
            }
            else {
                this.element.find('.overflow-tab-action').remove();
            }
        };

        this.openOverflowDropdown = function () {
            var overflow_sum_height = 0;
            var overflow_first_top = 41;

            this.element.find('.overflow-tab').hide();
            // Calc top position of overflow tabs.
            this.element.find('.overflow-tab').each(function () {
                var overflow_item_height = $(this).height() - 1;
                if (overflow_sum_height === 0) {
                    $(this).css('top', overflow_first_top + 'px');
                    overflow_sum_height += overflow_first_top + overflow_item_height;
                }
                else {
                    $(this).css('top', overflow_sum_height + 'px');
                    overflow_sum_height += overflow_item_height;
                }

            });
        };

        this.actionOverflowItems = function () {
            var tabs_limit = this.element.width() - 100;
            var count = 0;

            // Calc tans width and add class to any tab that is overflow.
            for (var i = 0; i < this.element.children().length; i += 1) {
                var item = $(this.element.children()[i]);
                if (item.hasClass('overflow-tab-action')) {
                    continue;
                }

                count += item.width();
                if (count > tabs_limit) {
                    item.addClass('overflow-tab');
                }
                else if (count < tabs_limit) {
                    item.removeClass('overflow-tab');
                    item.show();
                }
            }
        };
    };

    var tabsAction = new tabsActions('.layout--tabs .nav-tabs-wrapper .nav-tabs');
    tabsAction.setup();

</script>

<script>
    var course = document.getElementById('starter-select-course');
    course.addEventListener('change', function(e) {
        var type = $(this).val();

        $.ajax({
            url:"/select-course-type",
            method:"post",
            data:{
                search_type_course : type,
            },
            dataType:"text",
            success: function(data) {
                console.log(data);
                $('#autocomplete_select_course').html(data);
            }
        });
    });
</script>

<script>
    var data = {
        labels: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        datasets: [
            {
                label: 'You',
                backgroundColor: '#14A89D',
                borderColor: '#14A89D',
                borderWidth: 1,
                data: [<?php echo $canva_data_you_read?>] 
            },
            {
                label: 'Average learner from your team learning on this topic',
                backgroundColor: '#023356',
                borderColor: '#023356',
                borderWidth: 1,
                data: [<?php echo $canva_data_member_read ?>] 
            }
        ]
    };


    var ctx = document.getElementById('Key-Skill').getContext('2d');


    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<script>

    var data = {
        labels: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        datasets: [
            {
                label: 'Mobile',
                borderColor: '#14A89D',
                backgroundColor: '#14A89D',
                borderWidth: 2,
                data: [<?php echo $canva_data_mobile ?>]
            },
            {
                label: 'Desktop',
                borderColor: '#023356',
                backgroundColor: '#023356',
                borderWidth: 2,
                data: [<?php echo $canva_data_web ?>]
            }
        ]
    };


    var ctx = document.getElementById('Usage-desktop').getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.6.0/alpine.js"></script>
<script>
    function imageData(url) {
        const originalUrl = url || '';
        return {
            previewPhoto: originalUrl,
            fileName: null,
            emptyText: originalUrl ? 'No new file chosen' : 'No file chosen',
            updatePreview($refs) {
                var reader,
                    files = $refs.input.files;
                reader = new FileReader();
                reader.onload = (e) => {
                    this.previewPhoto = e.target.result;
                    this.fileName = files[0].name;
                };
                reader.readAsDataURL(files[0]);
            },
            clearPreview($refs) {
                $refs.input.value = null;
                this.previewPhoto = originalUrl;
                this.fileName = false;
            }
        };
    }
</script>
<script>
    $(document).ready(function () {
        function showandhideblockModal() {
            $('.content-block-bg').show();
            $(".modal-header").show();
            $('.detail-content-modal').hide();
        }

        $('.new-modal-to-do').on('hidden.bs.modal', function () {
            showandhideblockModal();
        });
    });
</script>