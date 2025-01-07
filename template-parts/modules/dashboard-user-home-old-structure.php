<?php
$like_src = get_stylesheet_directory_uri()."/img/love.png";
$dislike_src = get_stylesheet_directory_uri()."/img/heart-like.png";

extract($_POST);

$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1
);

$communities = get_posts($args);

//The user
$user = get_current_user_id();

$courses = array();
$course_id = array();
$random_id = array();
$count = array('Opleidingen' => 0, 'Workshop' => 0, 'E-learning' => 0, 'Event' => 0, 'E_learning' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0);

$categories = array();

//Categories
$cats = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'exclude' => 'Uncategorized',
    'parent'     => 0,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

foreach($cats as $category){
    $cat_id = strval($category->cat_ID);
    $category = intval($cat_id);
    array_push($categories, $category);
}

//Categories
$bangerichts = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[1],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$functies = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[0],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$skills = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[3],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

$interesses = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'parent'  => $categories[2],
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

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

/**
 **  Modal first login - tags
**/
foreach($bangerichts as $key1=>$tag){

    //Topics
    $cats_bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag->cat_ID,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));
    if (count($cats_bangerichts)!=0)
    {
        $row_bangrichts.='<div hidden=true class="cb_topics_bangricht_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_bangerichts as $key => $value)
        {
            $row_bangrichts .= '
            <input type="checkbox" name="choice_bangrichts_'.$value->cat_ID.'" value= '.$value->cat_ID .' id=subtopics_bangricht_'.$value->cat_ID.' /><label class="labelChoose" for=subtopics_bangricht_'.$value->cat_ID.'>'. $value->cat_name .'</label>';
        }
        $row_bangrichts.= '</div>';
    }

}
foreach($functies as $key1 =>$tag)
{

    //Topics
    $cats_functies = get_categories(
        array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag->cat_ID,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));
    if (count($cats_functies)!=0)
    {
        $row_functies.='<div hidden=true class="cb_topics_funct_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_functies as $key => $value)
        {
        $row_functies .= '
        <input type="checkbox" name="choice_functies_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_funct_'.($value->cat_ID).'" /><label class="labelChoose" for="cb_funct_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
        }
        $row_functies.= '</div>';
    }
}
foreach($skills as $key1=>$tag){
    //Topics
    $cats_skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent' => $tag->cat_ID,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ));
    if (count($cats_skills)!=0)
    {
        $row_skills.='<div hidden=true class="cb_topics_skills_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_skills as $key => $value)
        {
                $row_skills .= '
                <input type="checkbox" name="choice_skills'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_skills_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_skills_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
        }
        $row_skills.= '</div>';
    }

}
foreach($interesses as $key1=>$tag){
    //Topics
        $cats_interesses = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_interesses)!=0)
    {
        $row_interesses.='<div hidden=true class="cb_topics_personal_'.($key1+1).'" '.($key1+1).'">';
        foreach($cats_interesses as $key => $value)
        {
        $row_interesses .= '
        <input type="checkbox" name="choice_interesses_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_interesses_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_interesses_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
        }
        $row_interesses.= '</div>';
    }

}
if (isset($_POST["subtopics_first_login"])){
    unset($_POST["subtopics_first_login"]);
    $subtopics_already_selected = get_user_meta(get_current_user_id(),'topic');
    foreach ($_POST as $key => $subtopics) {
        if (isset($_POST[$key]))
        {
            if (!(in_array($_POST[$key], $subtopics_already_selected)))
            {
                add_user_meta(get_current_user_id(),'topic',$_POST[$key]);
            }

        }
    }
    update_field('is_first_login', true, 'user_'.get_current_user_id());
    $message = "/dashboard/user/?message=Uw favoriete onderwerpen zijn succesvol opgeslagen !"; 
    header("Location: ". $message);
}

/*
* * Courses dedicated of these user "Boughts + Mandatories"
*/

$enrolled = array();
$enrolled_courses = array();

//Orders - enrolled courses  
$args = array(
    'customer_id' => $user,
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        //Get woo orders from user
        $id_course = intval($item->get_product_id()) - 1;
        $prijs = get_field('price', $course_id);
        $expenses += $prijs; 
        if(!in_array($id_course, $enrolled))
            array_push($enrolled, $id_course);
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

    if(!empty($enrolled_courses))
        $your_count_courses = count($enrolled_courses);
}

$state = array('new' => 0, 'progress' => 0, 'done' => 0);

foreach($enrolled_courses as $key => $course) :

    /* * State actual details * */
    $status = "new";
    //Get read by user 
    $args = array(
        'post_type' => 'progression', 
        'title' => $course->post_name,
        'post_status' => 'publish',
        'author' => $user,
        'posts_per_page'         => 1,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false
    );
    $progressions = get_posts($args);
    if(!empty($progressions)){
        $status = "progress";
        $progression_id = $progressions[0]->ID;
        //Finish read
        $is_finish = get_field('state_actual', $progression_id);
        if($is_finish)
            $status = "done";
    }

    // Analytics
    switch ($status) {
        case 'new':
            $state['new']++;
            break;
        case 'progress':
            $state['progress']++;
            break;
        case 'done':
            $state['done']++;
            break;
    }

endforeach;


$is_first_login = (get_field('is_first_login','user_' . get_current_user_id()));
if (!$is_first_login && get_current_user_id() !=0 )
{
?>
<!-- Modal First Connection -->
<div class="contentModalFirst"²>
    <div class="modal" id="myFirstModal" tabindex="-1" role="dialog" aria-labelledby="myFirstModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modalHeader">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Welcome to livelearn</h5>
                    <p class="pickText">Pick your favorite topics to set up your feeds</p>
                </div>
                <div class="modal-body">
                  <form method="post" name="first_login_form">
                    <div class="blockBaangerichte">
                        <h1 class="titleSubTopic">Baangerichte</h1>
                        <div class="hiddenCB">
                            <div>
                                <?php
                                foreach($bangerichts as $key => $value)
                                    echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                                
                                ?>
                            </div>
                        </div>
                        <div class="subtopicBaangerichte">

                            <div class="hiddenCB">
                                <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                <?php
                                echo $row_bangrichts;
                                ?>
                            </div>
                            <button type="button" class="btn btnNext" id="nextblockBaangerichte">Next</button>
                        </div>
                        <button type="button" class="btn btnSkipTopics" id="btnSkipTopics1">Skip</button>
                    </div>

                    <div class="blockfunctiegericht">
                        <h1 class="titleSubTopic">functiegericht</h1>
                        <div class="hiddenCB">
                            <div>
                                <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnFunctiegericht" for="cb1">Choice A</label> -->
                                <?php
                                foreach($functies as $key => $value)
                                    echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_funct'.($key+1).'" /><label class="labelChoose btnFunctiegericht subtopics_funct_'.($key+1).' '.($key+1).'"  for="cb_topics_funct'.($key+1).'">'. $value->cat_name .'</label>';
                                ?>
                            </div>
                        </div>
                        <div class="subtopicFunctiegericht">
                            <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                            <div class="hiddenCB">
                                <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                <?php
                                    echo $row_functies;
                                ?>
                            </div>
                            <button type="button" class="btn btnNext" id="nextFunctiegericht">Next</button>
                        </div>
                        <button type="button" class="btn btnSkipTopics" id="btnSkipTopics2">Skip</button>
                    </div>

                    <div class="blockSkills">
                        <h1 class="titleSubTopic">Skills</h1>
                        <div class="hiddenCB">
                            <div>
                                <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnSkills" for="cb1">Choice A</label> -->

                                <?php
                                foreach($skills as $key => $value)
                                    echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_skills'.($key+1).'" /><label class="labelChoose btnSkills subtopics_skills_'.($key+1).' '.($key+1).'" for=cb_skills'.($key+1).'>'. $value->cat_name .'</label>';
                                ?>

                            </div>
                        </div>
                        <div class="subtopicSkills">
                            <div class="hiddenCB">
                                <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                <?php
                                    echo $row_skills;
                                ?>
                            </div>
                            <button type="button" class="btn btnNext" id="nextSkills">Next</button>
                        </div>
                        <button type="button" class="btn btnSkipTopics" id="btnSkipTopics3">Skip</button>
                    </div>

                    <div class="blockPersonal">
                        <h1 class="titleSubTopic">Personal interest </h1>
                        <div class="hiddenCB">
                            <div>
                                <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnPersonal" for="cb1">Choice A</label> -->

                                <?php
                                foreach($interesses as $key => $value)
                                    echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_personal'.($key+1).'" /><label class="labelChoose btnPersonal subtopics_personal_'.($key+1).' '.($key+1).'" for="cb_topics_personal'.($key+1).'">'. $value->cat_name .'</label>';
                                ?>

                            </div>
                        </div>
                        <div class="subtopicPersonal">
                            <div class="hiddenCB">
                                <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                <?php
                                    echo $row_interesses;
                                ?>
                            </div>
                            <!-- <button name="subtopics_first_login" class="btn btnNext" id="nextPersonal">Save</button> -->
                        </div>
                        <button name="subtopics_first_login" class="btn btnNext" id="nextPersonal">Save</button>
                        <!-- <button type="button" class="btn btnSkipTopics" id="btnSkipTopics4">Skip</button> -->
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
/**
 * End modal first login - tags
**/
?>

<?php

$void_content ='<center>
                <h2>No content found !</h2> 
                <img src="' . get_stylesheet_directory_uri() . '/img' . '/void-content.gif" alt="content image requirements">
                </center>';

// Saved courses
$saved = get_user_meta($user, 'course');

/*
* Get interests courses
*/

//Topics
$topics_external = get_user_meta($user, 'topic');
$topics_internal = get_user_meta($user, 'topic_affiliate');
$topics = array();
if(!empty($topics_external))
    $topics = $topics_external;
if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics, $value);

//SQL Request : "select * from tracker_views where user_id = %user_id"
//$user_informations
//Views
$user_post_view = get_posts( 
    array(
        'post_type' => 'view',
        'post_status' => 'publish',
        'author' => $user,
        'order' => 'DESC',
        'posts_per_page' => -1
    )
)[0];


//Experts
$postAuthorSearch = array();
$experts = array();
$experts = get_user_meta($user, 'expert');
$postAuthorSearch = $experts;
$teachers = array();

//SQL Request:
// * Get authors from course already viewed
//Get experts already viewed "select * from tracker_views where and data_type = 'expert' and user_id = %user_id ad" : Equivalent $view_my_experts
//Views expert
if (!empty($user_post_view))
{
    $view_my_experts = (get_field('views_user', $user_post_view->ID));
    $id_view_experts = ($view_my_experts) ? array_column($view_my_experts, 'view_id') : array();
    $id_view_experts = (!empty($id_view_experts)) ? array_unique($id_view_experts) : array();
    $postAuthorSearch = (!empty($id_view_experts) && !empty($experts)) ? array_merge($experts, $id_view_experts) : $experts;
}

$args = array(
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'author__in' => $postAuthorSearch, 
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => 200
);
$global_courses = get_posts($args);
shuffle($global_courses);
foreach ($global_courses as $key => $course) {
    //Control visibility
    $bool = true;
    $bool = visibility($course, $visibility_company);
    if(!$bool)
        continue;

    // Date and Location
    $data = array();

    $datas = get_field('data_locaties', $course->ID);

    if($datas)
        $data = $datas[0]['data'][0]['start_date'];
    else{
        $datum = get_field('data_locaties_xml', $course->ID);

        if($datum)
            if(isset($datum[0]['value']))
                $element = $datum[0]['value'];
        if(!isset($element))
            continue;
        $datas = explode('-', $element);
        $data = $datas[0];
    }

    //Course Type
    $course_type = get_field('course_type', $course->ID);

    if(empty($data))
        null;
    else if(!empty($data) && $course_type != "Video" && $course_type != "Artikel")
        if($data){
            $date_now = strtotime(date('Y-m-d'));
            $data = strtotime(str_replace('/', '.', $data));
            if($data < $date_now)
                continue;
        }

    //Preferences categories
    $category_default = get_field('categories', $course->ID);
    $category_xml = get_field('category_xml', $course->ID);
    $read_category = array();
    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if(!in_array($item['value'],$read_category))
                    array_push($read_category,$item['value']);

    else if(!empty($category_xml))
        foreach($category_xml as $item)
            if($item)
                if(!in_array($item['value'],$read_category))
                    array_push($read_category,$item['value']);

    foreach($topics as $topic_value){
        if($read_category)
            if(in_array($topic_value, $read_category) ){
                if(!in_array($course->ID, $course_id)){
                    array_push($course_id, $course->ID);
                    array_push($courses, $course);
                    break;
                }
        }
    }

    //Preference author
    if($experts)
        if(in_array($course->post_author, $experts)){
            if(!in_array($course->ID, $course_id)){
                array_push($course_id, $course->ID);
                array_push($courses, $course);
            }
        }

    //Preference expert
    $experties = get_field('experts', $course->ID);
    if($experties && $experts)
        foreach($experties as $topic_expert){
            if(in_array($topic_expert, $experts)){
                if(!in_array($course->ID, $course_id)){
                    array_push($course_id, $course->ID);
                    array_push($courses, $course);
                    break;
                }
            }
        }
}

// $user_informations
// Views credential
$is_view = false;
if (!empty($user_post_view))
{
    $courses_id = array();
    $is_view = true;

    //SQL Request:
    //Get courses already viewed "select * from tracker_views where and data_type = 'course' and user_id = %user_id "
    //Equivalent 'all_user-views'
    $all_user_views = (get_field('views', $user_post_view->ID));

    $max_points = 10;
    $recommended_courses = array();
    $count_recommended_course = 0;

    foreach($all_user_views as $key => $view) {
        //Get course viewed 
        //$view['course'] = get_post($view->data_id); 
        if(!$view['course'])
            continue;

        foreach ($courses as $key => $course) {
            $points = 0;

            //Read category viewed - get categories from course view
            $read_category_view = array();
            $category_default = get_field('categories', $view['course']->ID);
            $category_xml = get_field('category_xml', $view['course']->ID);
            if(!empty($category_default))
                foreach($category_default as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_view))
                            array_push($read_category_view, $item['value']);

            else if(!empty($category_xml))
                foreach($category_xml as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_view))
                            array_push($read_category_view, $item['value']);


            //Read category course - get categories from course
            $read_category_course = array();
            $category_default = get_field('categories', $course->ID);
            $category_xml = get_field('category_xml', $course->ID);
            if(!empty($category_default))
                foreach($category_default as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_course))
                            array_push($read_category_course, $item['value']);

            else if(!empty($category_xml))
                foreach($category_xml as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_course))
                            array_push($read_category_course, $item['value']);

            //Price view
            $view_prijs = get_field('price', $view['course']->ID);

            foreach($read_category_view as $value){
                if($points == 6)
                    break;
                if(in_array($value, $read_category_course))
                    $points += 3;
            }
            if ($view['course']->post_author == $course->post_author)
                $points += 3;
            if ($view_prijs <= $course->price)
                $points += 1;

            $percent = abs(($points/$max_points) * 100);
            if ($percent >= 50)
                if(!in_array($course->ID, $random_id)){
                    if(get_field('course_type', $course->ID))
                        $count[get_field('course_type', $course->ID)]++;
                    array_push($random_id, $course->ID);
                    array_push($recommended_courses, $course);

                    if(!in_array($course->post_author, $teachers))
                        array_push($teachers, $course->post_author);
                }
            $count_recommended_course = count($recommended_courses);
            if($count_recommended_course == 8)
                break;
        }
    }
}

//Must be the end

arsort($count);
$count_trend = array_slice($count, 5, 4, true);
$count = array_slice($count, 0, 4, true);

$count_trend_keys = array_keys($count_trend);

$keys = array_keys($count);
shuffle($keys);
$count = array_merge(array_flip($keys), $count);

$bool = false;

if (empty($recommended_courses)){
    $courses_id = array();
    $recommended_courses = $courses;
    $bool = true;
}
//Activitien
shuffle($recommended_courses);

/*
* *
*/

if(isset($_GET['message']))
    if($_GET['message'])
        echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>";

?>

<div class="content-new-user d-flex">
    <section class="first-section-dashboard">
        <div class="head-block d-flex justify-content-between mb-50">
            <a href="activity/?tab=Course" class="category-block-course d-flex justify-content-between bg-green">
                <div>
                    <div class="icone-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/symbols_check-box.png" alt="">
                    </div>
                    <p class="number-course"><?= $state['done'] ?></p>
                    <p class="description">Completed course</p>
                </div>
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/symbols_check-box-1.png" class="img-bg-categories-course" alt="">
            </a>
            <a href="activity/?tab=Course"  class="category-block-course d-flex justify-content-between bg-yellow">
                <div>
                    <div class="icone-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_alarm-light.png" alt="">
                    </div>
                    <p class="number-course"><?= $state['progress'] ?></p>
                    <p class="description">In progress course</p>
                </div>
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_alarm-light-1.png" class="img-bg-categories-course" alt="">
            </a>
            <a href="activity/?tab=Course"  class="category-block-course d-flex justify-content-between bg-bleu-luzien">
                <div>
                    <div class="icone-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_folder-file.png" alt="">
                    </div>
                    <p class="number-course"><?= $state['new'] ?></p>
                    <p class="description">Upcoming course</p>
                </div>
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_alarm-light-1.png" class="img-bg-categories-course" alt="">
            </a>
        </div>
        <!-- 
        <div class="search-filter d-flex justify-content-between align-items-center ">
            <input type="search" class="form-control" placeholder="search">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/uicons_filtering.png" alt="">
                    </label>
                </div>
                <select class="custom-select" id="inputGroupSelect01">
                    <option selected>Filter</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div> 
        -->
        <div class="btn-group-layouts">
            <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
            <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
        </div>

        <div id="tab-url1">
            <ul class="nav">
                <li class="nav-one"><a href="#All" class="current">All</a></li>
                <li class="nav-two"><a href="#Artikel" class="load_content_type">Artikel</a></li>
                <li class="nav-three"><a href="#E-learning" class="load_content_type">E-learning</a></li>
                <li class="nav-four "><a href="#Opleidingen" class="load_content_type">Opleidingen</a></li>
                <li class="nav-five "><a href="#Video" class="load_content_type">Video</a></li>
                <li class="nav-seven "><a href="#Trends">Trends</a></li>
            </ul>

            <div class="list-wrap">
                <ul id="All">
                    <div class="block-new-card-course grid" id="autocomplete_recommendation">
                        <?php
                        $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

                        if(!empty($recommended_courses))
                            foreach($recommended_courses as $course){
                                //Date and Location
                                $location = 'Online';
                            
                                $data = get_field('data_locaties', $course->ID);
                                if($data){
                                    $date = $data[0]['data'][0]['start_date'];
                                    $location = $data[0]['data'][0]['location'];
                                }
                                else{
                                    $dates = get_field('dates', $course->ID);
                                    if($dates)
                                        $day = explode(' ', $dates[0]['date'])[0];
                                    else{
                                        $data = get_field('data_locaties_xml', $course->ID);
                                        if(isset($data[0]['value'])){
                                            $data = explode('-', $data[0]['value']);
                                            $date = $data[0];
                                            $day = explode(' ', $date)[0];
                                            $location = $data[2];
                                        }
                                    }
                                }

                                //Course Type
                                $course_type = get_field('course_type', $course->ID);

                                /*
                                * Categories
                                */
                                $category = ' ';
                                $category_id = 0;
                                $category_str = 0;
                                if($category == ' '){
                                    $one_category = get_field('categories',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                    else{
                                        $one_category = get_field('category_xml',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_id = intval($one_category[0]['value']);
                                    }

                                    if($category_str != 0)
                                        $category = (String)get_the_category_by_ID($category_str);
                                    else if($category_id != 0)
                                        $category = (String)get_the_category_by_ID($category_id);
                                }

                                //Price
                                $p = " ";
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price = '$' . number_format($p, 2, '.', ',');
                                else
                                    $price = 'Gratis';

                                //Legend image
                                $thumbnail = get_field('preview', $course->ID)['url'];
                                if(!$thumbnail){
                                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_field('url_image_xml', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                }

                                //Author
                                $author = get_user_by('ID', $course->post_author);
                                $author_name = $author->display_name ?: $author->first_name;

                                //Clock duration
                                $duration_day = get_field('duration_day', $post->ID) ? : '-';

                                //Other case : youtube
                                $youtube_videos = get_field('youtube_videos', $course->ID);

                                $author_image = get_field('profile_img',  'user_' . $author_object->ID);
                                $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';


                                $find = true;
                                ?>
                                <a href="<?= get_permalink($course->ID); ?>" class="new-card-course">
                                    <div class="head">
                                        <?php
                                        if($youtube_videos && $course_type == 'Video')
                                            echo '<iframe width="355" height="170" class="lazy img-fluid" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                        else
                                            echo '<img src="' . $thumbnail .'" alt="">';
                                        ?>
                                    </div>
                                    <div class="details-card-course">
                                        <div class="title-favorite d-flex justify-content-between align-items-center">
                                            <p class="title-course"><?= $course->post_title ?></p>
                                            <button>
                                                <?php
                                                if (in_array($course->ID, $saved))
                                                {
                                                    ?>
                                                    <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <img class="btn_favourite d-none" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                                    <?php
                                                }
                                                ?>
                                            </button>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                            <div class="blockOpein d-flex align-items-center">
                                                <i class="fas fa-graduation-cap"></i>
                                                <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                            </div>
                                            <div class="blockOpein">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <p class="lieuAm"><?= $location ?></p>
                                            </div>
                                        </div>
                                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgUser">
                                                    <img src="<?= $author_image ?>" class="" alt="">
                                                </div>
                                                <p class="autor"><?= $author_name ?></p>
                                            </div>
                                            <p class="price"><?= $price ?></p>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                            else
                                echo $void_content;
                            ?>
                            <center>
                                <button class="btn btnNext loading_more">Load all</button><br>
                                <div hidden="true" id="loader_recommendation" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            </center>
                        </div>
                </ul>

                <ul id="Artikel" class="hide">
                    <div class="block-new-card-course" id="autocomplete_recommendation_Artikel">
                        <?php
                        $find = false;

                        if(isset($count['Artikel']))
                            if($count['Artikel'] >= 0)
                                foreach($recommended_courses as $course){
                                    //Date and Location
                                    $location = 'Online';
                                
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $dates = get_field('dates', $course->ID);
                                        if($dates)
                                            $day = explode(' ', $dates[0]['date'])[0];
                                        else{
                                            $data = get_field('data_locaties_xml', $course->ID);
                                            if(isset($data[0]['value'])){
                                                $data = explode('-', $data[0]['value']);
                                                $date = $data[0];
                                                $day = explode(' ', $date)[0];
                                                $location = $data[2];
                                            }
                                        }
                                    }

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);
                                    if($course_type != 'Artikel')
                                        continue;

                                    /*
                                    * Categories
                                    */
                                    $category = ' ';
                                    $category_id = 0;
                                    $category_str = 0;
                                    if($category == ' '){
                                        $one_category = get_field('categories',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                        else{
                                            $one_category = get_field('category_xml',  $course->ID);
                                            if(isset($one_category[0]['value']))
                                                $category_id = intval($one_category[0]['value']);
                                        }

                                        if($category_str != 0)
                                            $category = (String)get_the_category_by_ID($category_str);
                                        else if($category_id != 0)
                                            $category = (String)get_the_category_by_ID($category_id);
                                    }

                                    //Price
                                    $p = " ";
                                    $p = get_field('price', $course->ID);
                                    if($p != "0")
                                        $price = '$' . number_format($p, 2, '.', ',');
                                    else
                                        $price = 'Gratis';

                                    //Legend image
                                    $thumbnail = get_field('preview', $course->ID)['url'];
                                    if(!$thumbnail){
                                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Author
                                    $author = get_user_by('ID', $course->post_author);
                                    $author_name = $author->display_name ?: $author->first_name;

                                    //Clock duration
                                    $duration_day = get_field('duration_day', $post->ID) ? : '-';

                                    //Other case : youtube
                                    $youtube_videos = get_field('youtube_videos', $course->ID);

                                    $find = true;
                                    ?>
                                    <a href="<?= get_permalink($course->ID); ?>" class="new-card-course">
                                        <div class="head">
                                            <?php
                                            if($youtube_videos && $course_type == 'Video')
                                                echo '<iframe width="355" height="170" class="lazy img-fluid" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            else
                                                echo '<img src="' . $thumbnail .'" alt="">';
                                            ?>
                                        </div>
                                        <div class="details-card-course">
                                            <div class="title-favorite d-flex justify-content-between align-items-center">
                                                <p class="title-course"><?= $course->post_title ?></p>
                                                <button>
                                                    <?php
                                                    if (in_array($course->ID, $saved))
                                                    {
                                                        ?>
                                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <img class="btn_favourite d-none" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                                        <?php
                                                    }
                                                    ?>
                                                </button>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                                <div class="blockOpein d-flex align-items-center">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                </div>
                                                <div class="blockOpein">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <p class="lieuAm"><?php echo $location?></p>
                                                </div>
                                            </div>
                                            <div class="autor-price-block d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="blockImgUser">
                                                        <img src="<?= $author_image ?>" class="" alt="">
                                                    </div>
                                                    <p class="autor"><?= $author_name ?></p>
                                                </div>
                                                <p class="price"><?= $price ?></p>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }

                        if(!$find)
                            echo $void_content;
                        ?>
                        <center>
                        <div hidden="true" id="loader_recommendation_Artikel" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        </center>
                    </div>
                </ul>

                <ul id="E-learning" class="hide" id="autocomplete_recommendation_E-learning">
                    <div class="block-new-card-course">
                        <?php
                        $find = false;

                        if(isset($count['E-learning']))
                            if($count['E-learning'] > 0)
                                foreach($recommended_courses as $course){
                                    //Date and Location
                                    $location = 'Online';
                                
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $dates = get_field('dates', $course->ID);
                                        if($dates)
                                            $day = explode(' ', $dates[0]['date'])[0];
                                        else{
                                            $data = get_field('data_locaties_xml', $course->ID);
                                            if(isset($data[0]['value'])){
                                                $data = explode('-', $data[0]['value']);
                                                $date = $data[0];
                                                $day = explode(' ', $date)[0];
                                                $location = $data[2];
                                            }
                                        }
                                    }

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);
                                    if($course_type != 'E-learning')
                                        continue;

                                    /*
                                    * Categories
                                    */
                                    $category = ' ';
                                    $category_id = 0;
                                    $category_str = 0;
                                    if($category == ' '){
                                        $one_category = get_field('categories',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                        else{
                                            $one_category = get_field('category_xml',  $course->ID);
                                            if(isset($one_category[0]['value']))
                                                $category_id = intval($one_category[0]['value']);
                                        }

                                        if($category_str != 0)
                                            $category = (String)get_the_category_by_ID($category_str);
                                        else if($category_id != 0)
                                            $category = (String)get_the_category_by_ID($category_id);
                                    }

                                    //Price
                                    $p = " ";
                                    $p = get_field('price', $course->ID);
                                    if($p != "0")
                                        $price = '$' . number_format($p, 2, '.', ',');
                                    else
                                        $price = 'Gratis';

                                    //Legend image
                                    $thumbnail = get_field('preview', $course->ID)['url'];
                                    if(!$thumbnail){
                                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Author
                                    $author = get_user_by('ID', $course->post_author);
                                    $author_name = $author->display_name ?: $author->first_name;

                                    //Clock duration
                                    $duration_day = get_field('duration_day', $post->ID) ? : '-';

                                    //Other case : youtube
                                    $youtube_videos = get_field('youtube_videos', $course->ID);

                                    $find = true;
                                    ?>
                                    <a href="<?= get_permalink($course->ID); ?>" class="new-card-course">
                                        <div class="head">
                                            <?php
                                            if($youtube_videos && $course_type == 'Video')
                                                echo '<iframe width="355" height="170" class="lazy img-fluid" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            else
                                                echo '<img src="' . $thumbnail .'" alt="">';
                                            ?>
                                        </div>
                                        <div class="details-card-course">
                                            <div class="title-favorite d-flex justify-content-between align-items-center">
                                                <p class="title-course"><?= $course->post_title ?></p>
                                                <button>
                                                    <?php
                                                    if (in_array($course->ID, $saved))
                                                    {
                                                        ?>
                                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <img class="btn_favourite d-none" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                                        <?php
                                                    }
                                                    ?>
                                                </button>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                                <div class="blockOpein d-flex align-items-center">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                </div>
                                                <div class="blockOpein">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <p class="lieuAm"><?php echo $location?></p>
                                                </div>
                                            </div>
                                            <div class="autor-price-block d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="blockImgUser">
                                                        <img src="<?= $author_image ?>" class="" alt="">
                                                    </div>
                                                    <p class="autor"><?= $author_name ?></p>
                                                </div>
                                                <p class="price"><?= $price ?></p>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }

                        if(!$find)
                            echo $void_content;
                        ?>
                        <center>
                        <div hidden="true" id="loader_recommendation_E-learning" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        </center>
                    </div>
                </ul>

                <ul id="Opleidingen" class="hide"  id="autocomplete_recommendation_Opleidingen" >
                    <div class="block-new-card-course">
                        <?php
                        $find = false;

                        if(isset($count['Opleidingen']))
                            if($count['Opleidingen'] > 0)
                                foreach($recommended_courses as $course){
                                    //Date and Location
                                    $location = 'Online';
                                
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $dates = get_field('dates', $course->ID);
                                        if($dates)
                                            $day = explode(' ', $dates[0]['date'])[0];
                                        else{
                                            $data = get_field('data_locaties_xml', $course->ID);
                                            if(isset($data[0]['value'])){
                                                $data = explode('-', $data[0]['value']);
                                                $date = $data[0];
                                                $day = explode(' ', $date)[0];
                                                $location = $data[2];
                                            }
                                        }
                                    }

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);
                                    if($course_type != 'Opleidingen')
                                        continue;

                                    /*
                                    * Categories
                                    */
                                    $category = ' ';
                                    $category_id = 0;
                                    $category_str = 0;
                                    if($category == ' '){
                                        $one_category = get_field('categories',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                        else{
                                            $one_category = get_field('category_xml',  $course->ID);
                                            if(isset($one_category[0]['value']))
                                                $category_id = intval($one_category[0]['value']);
                                        }

                                        if($category_str != 0)
                                            $category = (String)get_the_category_by_ID($category_str);
                                        else if($category_id != 0)
                                            $category = (String)get_the_category_by_ID($category_id);
                                    }

                                    //Price
                                    $p = " ";
                                    $p = get_field('price', $course->ID);
                                    if($p != "0")
                                        $price = '$' . number_format($p, 2, '.', ',');
                                    else
                                        $price = 'Gratis';

                                    //Legend image
                                    $thumbnail = get_field('preview', $course->ID)['url'];
                                    if(!$thumbnail){
                                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Author
                                    $author = get_user_by('ID', $course->post_author);
                                    $author_name = $author->display_name ?: $author->first_name;

                                    //Clock duration
                                    $duration_day = get_field('duration_day', $post->ID) ? : '-';

                                    //Other case : youtube
                                    $youtube_videos = get_field('youtube_videos', $course->ID);

                                    $find = true;
                                    ?>
                                    <a href="<?= get_permalink($course->ID); ?>" class="new-card-course">
                                        <div class="head">
                                            <?php
                                            if($youtube_videos && $course_type == 'Video')
                                                echo '<iframe width="355" height="170" class="lazy img-fluid" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            else
                                                echo '<img src="' . $thumbnail .'" alt="">';
                                            ?>
                                        </div>
                                        <div class="details-card-course">
                                            <div class="title-favorite d-flex justify-content-between align-items-center">
                                                <p class="title-course"><?= $course->post_title ?></p>
                                                <button>
                                                    <?php
                                                    if (in_array($course->ID, $saved))
                                                    {
                                                        ?>
                                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <img class="btn_favourite d-none" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                                        <?php
                                                    }
                                                    ?>
                                                </button>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                                <div class="blockOpein d-flex align-items-center">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                </div>
                                                <div class="blockOpein">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <p class="lieuAm"><?php echo $location?></p>
                                                </div>
                                            </div>
                                            <div class="autor-price-block d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="blockImgUser">
                                                        <img src="<?= $author_image ?>" class="" alt="">
                                                    </div>
                                                    <p class="autor"><?= $author_name ?></p>
                                                </div>
                                                <p class="price"><?= $price ?></p>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }

                        if(!$find)
                            echo $void_content;
                        ?>
                        <center>
                        <div hidden="true" id="loader_recommendation_Opleidingen" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        </center>
                    </div>
                </ul>

                <ul id="Video" class="hide" id="autocomplete_recommendation_Video">
                    <div class="block-new-card-course">
                        <?php
                        $find = false;

                        if(isset($count['Video']))
                            if($count['Video'] > 0)
                                foreach($recommended_courses as $course){
                                    //Date and Location
                                    $location = 'Online';
                                
                                    $data = get_field('data_locaties', $course->ID);
                                    if($data){
                                        $date = $data[0]['data'][0]['start_date'];
                                        $location = $data[0]['data'][0]['location'];
                                    }
                                    else{
                                        $dates = get_field('dates', $course->ID);
                                        if($dates)
                                            $day = explode(' ', $dates[0]['date'])[0];
                                        else{
                                            $data = get_field('data_locaties_xml', $course->ID);
                                            if(isset($data[0]['value'])){
                                                $data = explode('-', $data[0]['value']);
                                                $date = $data[0];
                                                $day = explode(' ', $date)[0];
                                                $location = $data[2];
                                            }
                                        }
                                    }

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);
                                    if($course_type != 'Video')
                                        continue;

                                    /*
                                    * Categories
                                    */
                                    $category = ' ';
                                    $category_id = 0;
                                    $category_str = 0;
                                    if($category == ' '){
                                        $one_category = get_field('categories',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                        else{
                                            $one_category = get_field('category_xml',  $course->ID);
                                            if(isset($one_category[0]['value']))
                                                $category_id = intval($one_category[0]['value']);
                                        }

                                        if($category_str != 0)
                                            $category = (String)get_the_category_by_ID($category_str);
                                        else if($category_id != 0)
                                            $category = (String)get_the_category_by_ID($category_id);
                                    }

                                    //Price
                                    $p = " ";
                                    $p = get_field('price', $course->ID);
                                    if($p != "0")
                                        $price = '$' . number_format($p, 2, '.', ',');
                                    else
                                        $price = 'Gratis';

                                    //Legend image
                                    $thumbnail = get_field('preview', $course->ID)['url'];
                                    if(!$thumbnail){
                                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Author
                                    $author = get_user_by('ID', $course->post_author);
                                    $author_name = $author->display_name ?: $author->first_name;

                                    //Clock duration
                                    $duration_day = get_field('duration_day', $post->ID) ? : '-';

                                    //Other case : youtube
                                    $youtube_videos = get_field('youtube_videos', $course->ID);

                                    $find = true;
                                    ?>
                                    <a href="<?= get_permalink($course->ID); ?>" class="new-card-course">
                                        <div class="head">
                                            <?php
                                            if($youtube_videos && $course_type == 'Video')
                                                echo '<iframe width="355" height="170" class="lazy img-fluid" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            else
                                                echo '<img src="' . $thumbnail .'" alt="">';
                                            ?>
                                        </div>
                                        <div class="details-card-course">
                                            <div class="title-favorite d-flex justify-content-between align-items-center">
                                                <p class="title-course"><?= $course->post_title ?></p>
                                                <button>
                                                    <?php
                                                    if (in_array($course->ID, $saved))
                                                    {
                                                        ?>
                                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">
                                                        <?php
                                                    }
                                                    else{
                                                        ?>
                                                        <img class="btn_favourite d-none" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                                        <?php
                                                    }
                                                    ?>
                                                </button>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                                <div class="blockOpein d-flex align-items-center">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                </div>
                                                <div class="blockOpein">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <p class="lieuAm"><?php echo $location?></p>
                                                </div>
                                            </div>
                                            <div class="autor-price-block d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <div class="blockImgUser">
                                                        <img src="<?= $author_image ?>" class="" alt="">
                                                    </div>
                                                    <p class="autor"><?= $author_name ?></p>
                                                </div>
                                                <p class="price"><?= $price ?></p>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }

                        if(!$find)
                            echo $void_content;
                        ?>
                        <center>
                        <div hidden="true" id="loader_recommendation_Video" class="spinner-border spinner-border-sm text-primary" role="status"></div>
                        </center>
                    </div>
                </ul>

                <ul id="Trends" class="hide">
                    <div class="block-new-card-course">
                        <?php
                        if(!empty($courses))
                            foreach($courses as $course){
                                //Date and Location
                                $location = 'Online';
                        
                                $data = get_field('data_locaties', $course->ID);
                                if($data){
                                    $date = $data[0]['data'][0]['start_date'];
                                    $location = $data[0]['data'][0]['location'];
                                }
                                else{
                                    $dates = get_field('dates', $course->ID);
                                    if($dates)
                                        $day = explode(' ', $dates[0]['date'])[0];
                                    else{
                                        $data = get_field('data_locaties_xml', $course->ID);
                                        if(isset($data[0]['value'])){
                                            $data = explode('-', $data[0]['value']);
                                            $date = $data[0];
                                            $day = explode(' ', $date)[0];
                                            $location = $data[2];
                                        }
                                    }
                                }

                                //Course Type
                                $course_type = get_field('course_type', $course->ID);

                                /*
                                * Categories
                                */
                                $category = ' ';
                                $category_id = 0;
                                $category_str = 0;
                                if($category == ' '){
                                    $one_category = get_field('categories',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                    else{
                                        $one_category = get_field('category_xml',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_id = intval($one_category[0]['value']);
                                    }

                                    if($category_str != 0)
                                        $category = (String)get_the_category_by_ID($category_str);
                                    else if($category_id != 0)
                                        $category = (String)get_the_category_by_ID($category_id);
                                }

                                //Price
                                $p = " ";
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price = '$' . number_format($p, 2, '.', ',');
                                else
                                    $price = 'Gratis';

                                //Legend image
                                $thumbnail = get_field('preview', $course->ID)['url'];
                                if(!$thumbnail){
                                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_field('url_image_xml', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                }

                                //Author
                                $author = get_user_by('ID', $course->post_author);
                                $author_name = $author->display_name ?: $author->first_name;

                                //Clock duration
                                $duration_day = get_field('duration_day', $post->ID) ? : '-';

                                //Other case : youtube
                                $youtube_videos = get_field('youtube_videos', $course->ID);

                                $find = true;
                                ?>
                                <a href="<?= get_permalink($course->ID); ?>" class="new-card-course">
                                    <div class="head">
                                        <?php
                                        if($youtube_videos && $course_type == 'Video')
                                            echo '<iframe width="355" height="170" class="lazy img-fluid" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                        else
                                            echo '<img src="' . $thumbnail .'" alt="">';
                                        ?>
                                    </div>
                                    <div class="details-card-course">
                                        <div class="title-favorite d-flex justify-content-between align-items-center">
                                            <p class="title-course"><?= $course->post_title ?></p>
                                            <button>
                                                <?php
                                                if (in_array($course->ID, $saved))
                                                {
                                                    ?>
                                                    <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <img class="btn_favourite d-none" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                                    <?php
                                                }
                                                ?>
                                            </button>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                            <div class="blockOpein d-flex align-items-center">
                                                <i class="fas fa-graduation-cap"></i>
                                                <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                            </div>
                                            <div class="blockOpein">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <p class="lieuAm"><?php echo $location?></p>
                                            </div>
                                        </div>
                                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgUser">
                                                    <img src="<?= $author_image ?>" class="" alt="">
                                                </div>
                                                <p class="autor"><?= $author_name ?></p>
                                            </div>
                                            <p class="price"><?= $price ?></p>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                        else
                            echo $void_content;
                        ?>
                    </div>
                </ul>
                
            </div>
        </div>
    </section>
    <section class="second-section-dashboard">
        <div class="Upcoming-block">
            <h2>Upcoming Schedule</h2>
            <?php

            $i = 0;
            foreach($global_courses as $course){
            $bool = true;
            $bool = visibility($course, $visibility_company);
            if(!$bool)
                continue;

            /*
            *  Date and Location
            */ 
            $data = array();
            $day = "-";
            $month = 0;
            $location = 'Online';

            $datas = get_field('data_locaties', $course->ID);
            if($datas){
                $data = $datas[0]['data'][0]['start_date'];
                if($data != ""){
                    $day = explode('/', explode(' ', $data)[0])[0];
                    $mon = explode('/', explode(' ', $data)[0])[1];
                    $year = explode('/', explode(' ', $data)[0])[2];
                    $month = $calendar[$mon];
                }

                $location = $datas[0]['data'][0]['location'];
            }else{
                $datum = get_field('data_locaties_xml', $course->ID);
                if(isset($datum[0]['value'])){
                    $datas = explode('-', $datum[0]['value']);
                    $data = $datas[0];
                    $day = explode('/', explode(' ', $data)[0])[0];
                    $month = explode('/', explode(' ', $data)[0])[1];
                    $month = $calendar[$month];
                    $location = $datas[2];
                }
                else{
                    $dates = get_field('dates', $course->ID);
                    if($dates){
                        $data = $dates[0]['date'];
                        $days = explode(' ', $data)[0];
                        $day = explode('-', $days)[2];
                        $month = $calendar[explode('-', $data)[1]];
                        $year = explode('-', $days)[0];
                        // $time = explode(' ', $date)[1];
                        // $hours = explode(':', $time)[0] . 'h' . explode(':', $time)[1];
                    }
                }

            }

            if(!$month)
                continue;

            if(empty($data))
                null;
            else if(!empty($data)){
                $date_now = strtotime(date('Y-m-d'));
                $data = strtotime(str_replace('/', '.', $data));
                if($data < $date_now)
                    continue;
            }
            
            //Price
            $p = get_field('price', $course->ID);
            if($p != "0")
                $price =  number_format($p, 2, '.', ',');
            else
                $price = 'Free';

            //Author
            $author_object = get_user_by('ID', $course->post_author);      
            $author_name = $author_object->display_name ?: $author_object->first_name;
            $author_image = get_field('profile_img',  'user_' . $author_object->ID);
            $author_image = $author_image ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

            //Legend image
            $thumbnail = get_field('preview', $course->ID)['url'];
            if(!$thumbnail){
                $thumbnail = get_the_post_thumbnail_url($course->ID);
                if(!$thumbnail)
                    $thumbnail = get_field('url_image_xml', $course->ID);
                if(!$thumbnail)
                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
            }
                        
            ?>
            <div class="card-Upcoming">
                <a  href="<?php echo get_permalink($course->ID); ?>" class="title"><?= $course->post_title; ?></p>
                <div class="d-flex align-items-center justify-content-between">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                    <p class="date"><?php echo($month . ' ' . $day . ', ' . $year) ?></p>
                    <hr>
                    <p class="time"> <?= $location ?></p>
                </div>
                <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                    <div class="d-flex align-items-center">
                        <img class="imgAutor" src="<?= $author_image; ?>" alt="">
                        <p class="nameAutor"><?= $author_name; ?></p>
                    </div>
                    <p class="price"><?= $price ?></p>
                </div>
            </div>
            <?php
                if($i == 3)
                    break;
                $i++;
            }

            if(!$i)
                echo "<p class='dePaterneText theme-card-description'> <span style='color:#033256'> Stay connected, Something big is coming 😊 </span> </p>";
            ?>
            <!-- <a href="/" class="btn btn-more-events">More Events</a> -->
        </div>
        <div class="user-community-block">
            <?php
            $i = 0;
            if(!empty($communities))
                echo '<h2>Communities</h2>';

            foreach($communities as $key => $value){

                if(!$value)
                    continue;

                if($i == 3)
                    break;
                $i++;

                $company = get_field('company_author', $value->ID)[0];
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
                foreach ($followers as $key => $item)
                    if($item->ID == $user){
                        $bool = true;
                        break;
                    }
                
                if($bool)
                    $access_community = '<p  class="title">' . $value->post_title . ', Netherlands</p>';
                else
                    continue;
            ?>
            <a href="/dashboard/user/community-detail/?mu=<?= $value->ID ?>" class="card-Community d-flex align-items-center">
                <div class="imgCommunity">
                    <img class="calendarImg" src="<?= $community_image ?>" alt="">
                </div>
                <div>
                    <?= $access_community ?>
                    <p class="number-members"><?= $max_follower ?> Members</p>
                </div>
            </a>
            <?php
            }

            if(!empty($communities))
                echo '<a href="/dashboard/user/communities" class="btn btn-more-events">More</a>';
            ?>
        </div>
        <div class="user-expert-block">
            <?php
            if(!empty($teachers))
                echo '<h2>Expert</h2>';

            foreach ($teachers as $key => $id){
                if(!$id)
                    continue;

                if($key == 5)
                    break;

                $user = get_user_by('id', $id);
                $name = $user->first_name ?: $user->display_name;
                $company = get_field('company',  'user_' . $user->ID);
                $image_author = get_field('profile_img',  'user_' . $user->ID);
                $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';                                
            ?>
            <a href="/user-overview?id=<?php echo $user->ID; ?>" class="card-user-expert d-flex">
                <div class="imgAutor">
                    <img class="calendarImg" src="<?= $image_author ?>" alt="">
                </div>
                <div>
                    <p class="name-autor"><?= $name ?></p>
                    <div class="d-flex align-items-center">
                        <img class="iconeCompany" src="<?php echo get_stylesheet_directory_uri();?>/img/ic_round-work.png" alt="">
                        <p class="nameCompany"><?= $company[0]->post_title; ?> </p>
                    </div>
                </div>
            </a>
            <?php
            }
            if(!empty($teachers))
                echo '<a href="/opleiders" class="btn btn-more-events">See All</a>';
            ?>
        </div>
    </section>
</div>



<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
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
$(".loading_more").click((e)=>
    {
        $.ajax({
            url: '/loading-more-recommendation',
            type: 'POST',
            data: {
            },
            beforeSend:function(){
                $('#loader_recommendation').attr('hidden',false)
            },
            error: function(){
                console.log('Something went wrong!');
            },
            success: function(data){
                $('#loader_recommendation').attr('hidden',true)
                $('#autocomplete_recommendation').html(data);
                console.log(data);
            }
        });
    })
</script>

<script>
$(".load_content_type").click((e)=>
    {
        var content_type = e.currentTarget.innerText;
        var autocomplete_register = "#autocomplete_recommendation_" + content_type;
        var loader_register = "#loader_recommendation_" + content_type;

        $.ajax({
            url: '/loading-more-recommendation',
            type: 'POST',
            data: {
                'content_type' : content_type
            },
            beforeSend:function(){
                $(loader_register).attr('hidden',false)
            },
            error: function(){
                console.log('Something went wrong!');
            },
            success: function(data){
                $(autocomplete_register).html(data);
                $(loader_register).hide();
                console.log(data);
            }
        });

    })
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>

<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autorefresh.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>


<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:30,
        nav:false,
        lazyLoad:true,
        dots: false,
        responsive:{
            0:{
                items:1.3
            },
            600:{
                items:1.3
            },
            1000:{
                items:3
            }
        }
    })
</script>


