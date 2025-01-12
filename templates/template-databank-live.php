
<?php /** Template Name: databank live */ ?>
<?php
require_once 'add-author.php';
global $wpdb;

/*
 * * Pagination
 */
$posts_per_page = 50; // Number of posts to show on each page.
$current_page = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 1;


$courses = array();

// Check if the form is submitted
if (isset($_POST['filter_databank'])) {
    // Sanitize and validate form values
    $leervom = isset($_POST['leervom']) ? array_map('sanitize_text_field', $_POST['leervom']) : array();
    $min = isset($_POST['min']) ? intval($_POST['min']) : null;
    $max = isset($_POST['max']) ? intval($_POST['max']) : null;
    $gratis = isset($_POST['gratis']) ? 1 : 0;
    $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : null;
    $language = $_POST['language'] ? : '';

    // Define the base arguments for WP_Query
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'numberposts' => 2000,
        'meta_query' => array()
    );

    // Filter by course type
    if (!empty($leervom)) {
        $courseType = strtolower($leervom[0]);
        switch ($courseType) {
            case 'all':
                $type='all';
                break;
            case 'artikel':
                $type='article';
                break;
            case 'podcast':
                $type='podcast';
                break;
            case 'video':
                $type='video';
                break;
            case 'opleidingen':
                $type='course';
                break;
            case 'training':
                $type='training';
                break;
            case 'workshop':
                $type='workshop';
                break;
            case 'assessment':
                $type='assessment';
                break;
            case 'cursus':
                $type='cursus';
                break;
            case 'webinar':
                $type='webinar';
                break;
            case 'event':
                $type='event';
                break;
            case 'lezing':
                $type='reading';
                break;
            case 'class':
                $type='class';
                break;
            case 'leerpad':
                $type='leerpad';
                break;
            case 'e-learning':
                $type='elearning';
                break;
            case 'masterclass':
                $type='masterclass';
                break;
            default:
                break;
        }
        //$type = ($courseType == 'all') ? 'all' : $courseType;

        if ($type != "all") {
            $args = array(
                'posts_per_page' => -1,
                'post_type' => array('course', 'post'),
                'post_status' => 'publish',
                'ordevalue'       => $type,
                'order' => 'DESC' ,
                'meta_key'         => 'course_type',
                'meta_value' => $type
            );
        }
    }

    // Filter by price
    if ($gratis) {
        $args['meta_query'][] = array(
            'key' => 'price',
            'value' => 0,
            'compare' => '='
        );
    } elseif ($min !== null && $max !== null) {
        $args['meta_query'][] = array(
            'key' => 'price',
            'value' => array($min, $max),
            'type' => 'numeric',
            'compare' => 'BETWEEN'
        );
    } elseif ($min !== null) {
        $args['meta_query'][] = array(
            'key' => 'price',
            'value' => $min,
            'type' => 'numeric',
            'compare' => '>='
        );
    } elseif ($max !== null) {
        $args['meta_query'][] = array(
            'key' => 'price',
            'value' => $max,
            'type' => 'numeric',
            'compare' => '<='
        );
    }

    // Filter by status
    if ($status) {
        $args['meta_query'][] = array(
            'key' => 'status',
            'value' => $status,
            'compare' => '='
        );
    }
    if ($language){
        $args['meta_query'][] = array(
            'key' => 'language',
            'value' => $language,
            'compare' => 'LIKE'
        );
    }
    // Fetch filtered courses
    $courses = get_posts($args);

    // Calculate pagination values
    $total_posts = count($courses);
    $total_pages = ceil($total_posts / $posts_per_page);
    $args['posts_per_page'] = $posts_per_page;
    $args['paged'] = $current_page;
    $courses = get_posts($args);
} else {
    // Default behavior: Fetch all published courses if no filter is applied
    $args = array(
        'post_type' => array('course', 'post'),
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $current_page,
        'order' => 'DESC'
    );
    $courses = get_posts($args);
    $total_posts = wp_count_posts('course')->publish + wp_count_posts('post')->publish;
    $total_pages = ceil($total_posts / $posts_per_page);
}
function countTypeCourse($course_type){
    $args = array(
        'post_type' => array('course','post'),
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'ordevalue'       => $course_type,
        'order' => 'DESC' ,
        'meta_key'         => 'course_type',
        'meta_value' => $course_type
    );
    return count(get_posts($args));
}
$args = array(
    'post_type' => array('course', 'post'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC'
);
$courses_on_current_page = get_posts($args);
$count = count($courses_on_current_page);
$countVideos = countTypeCourse('video');
$countArtikles = countTypeCourse('article');
$countPodcasts=countTypeCourse('podcast');
$countOpleidingens=countTypeCourse('course');



// // Retrieve courses using get_posts()


// get compagnies:
$args = array(
    'post_type' => 'company',
    'post_status' => 'publish',
    'posts_per_page' => -1 // Get all posts
);

$companies = get_posts($args);
//get users Authors


$author_users = get_users(array('role_in' => ['author','administrator']));

$user = wp_get_current_user();

?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<style>
    .pagination {
        list-style-type: none;
        padding: 10px 0;
        display: inline-flex;
        justify-content: space-between;
        box-sizing: border-box;
    }
    .pagination li {
        box-sizing: border-box;
        padding-right: 10px;
    }
    .pagination li a {
        box-sizing: border-box;
        background-color: #e2e6e6;
        padding: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        color: #616872;
        border-radius: 4px;
    }
    .pagination li a:hover {
        background-color: #d4dada;
    }
    .pagination .next a, .pagination .prev a {
        text-transform: uppercase;
        font-size: 12px;
    }
    .pagination .currentpage a {
        background-color: #518acb;
        color: #fff;
    }
    .pagination .currentpage a:hover {
        background-color: #518acb;
    }
    .subcatchossen.selected {
        background-color: #033356; /* Couleur de sélection */
        color: white; /* Texte en blanc */
        border: 1px solid #033356; /* Bordure assortie */
        transition: all 0.3s ease;
    }
</style>
<style>
    .categories-wrapper {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .category-block {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .category-title {
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        margin: 0;
    }

    .subcategories {
        margin-top: 10px;
        padding-left: 15px;
    }

    .hidden {
        display: none;
    }

    .subcategory {
        padding: 5px 0;
    }

    .no-subcategories {
        font-style: italic;
        color: #777;
    }
</style>
<style>
    input[type="checkbox"] {
        display: none;
    }

    label.btn {
        border: 1px solid #033356;
        border-radius: 21px !important;
        font-size: 15px;
        color: #033356;
        background-color: #fff;
        transition: all 0.3s ease;
        margin-bottom: 15px;
        width: fit-content;
    }

    input[type="checkbox"]:checked + label.btn {
        background-color: #033356;
        color: #fff;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .hiddenCB {
        display: none;
    }

    .btn-skip {
        background: none !important;
        color: #47a99e !important;
        font-size: 16px;
        padding: 8px 20px !important;
    }

    .btn-next {
        background: #043356 !important;
        color: white !important;
        padding: 8px 20px !important;
    }

    .subtopics {
        margin-left: 20px;
    }
</style>

<div class="new-content-databank">
    <div class="container-fluid">
        <div class="head d-flex justify-content-between align-items-center">
            <p class="title-page">Databank LIVE</p>
            <div class="d-flex">
                <button class="btn btn-add-element" data-toggle="modal" data-target="#ModalCompany" type="button">Add a company</button>
                <button class="btn btn-add-element" data-toggle="modal" data-target="#ModalTeacher" type="button">Add a teacher</button>
            </div>
        </div>
        <div class="content-tab">
            <div class="d-flex justify-content-between content-head-tab">
                <div class="content-button-tabs">

                    <form action="" method="post">
                        <input type="hidden" name="leervom[]" id="leervom" value="All">
                        <button name="filter_databank" class="b-nav-tab buttonInsideModal btn <?php if(isset($leervom)) echo '' ?> ">
                            View all<span class="number-content"><?php echo $count;?></span>
                        </button>
                    </form>

                    <form action="" method="post">
                        <input type="hidden" name="leervom[]" id="leervom" value="Opleidingen">
                        <button name="filter_databank" class="b-nav-tab buttonInsideModal btn <?php if(isset($leervom) && in_array('Opleidingen', $leervom)) echo 'active'?> ">
                            Opleidingen <span class="number-content"><?php echo $countOpleidingens;?></span>
                        </button>
                    </form>

                    <form action="" method="post">
                        <input type="hidden" name="leervom[]" id="leervom" value="Artikel">
                        <button name="filter_databank" class="b-nav-tab buttonInsideModal btn <?php if(isset($leervom) && in_array('Artikel', $leervom)) echo 'active'?>">
                            Article <span class="number-content"><?php echo $countArtikles;?></span>
                        </button>
                    </form>

                    <form action="" method="post">
                        <input type="hidden" name="leervom[]" id="leervom" value="Podcast">
                        <button name="filter_databank" class="b-nav-tab buttonInsideModal btn <?php if(isset($leervom) && in_array('Podcast', $leervom)) echo 'active'?>" >
                            Podcast <span class="number-content"><?php echo $countPodcasts;?></span>
                        </button>
                    </form>

                    <form action="" method="post">
                        <input type="hidden" name="leervom[]" id="leervom" value="Video">
                        <button name="filter_databank" class="b-nav-tab buttonInsideModal btn <?php if(isset($leervom) && in_array('Video', $leervom)) echo 'active' ?>">
                            Videos <span class="number-content"><?php echo $countVideos;?></span>
                        </button>
                    </form>
                </div>
                <div class="d-flex align-items-center">
                    <input id="search_txt_course" type="search" class="search-databank" placeholder="Search course">
                    <div id="loader" class="spinner-border spinner-border-sm text-primary d-none" role="status"></div>
                </div>
            </div>
            <div class="headFilterCourse">
                <div class="mob filterBlock m-2 mr-4">
                    <p class="fliterElementText">Filter</p>
                    <button class="btn btnIcone8" id="show"><img
                                src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/filter.png" alt=""></button>
                </div>
                <div class="formFilterDatabank">
                    <form action="" method="POST">
                        <p class="textFilter">Filter :</p>
                        <button class="btn hideBarFilterBlock"><i class="fa fa-close"></i></button>
                        <select name="leervom[]">
                            <option value="All">All</option>
                            <option value="Opleidingen"
                                <?php if(isset($leervom) && in_array('Opleidingen', $leervom)) echo "selected"; ?>>
                                Opleidingen</option>
                            <option value="Training"
                                <?php if(isset($leervom) && in_array('Training', $leervom)) echo "selected"; ?>>Training
                            </option>
                            <option value="Workshop"
                                <?php if(isset($leervom) && in_array('Workshop', $leervom)) echo "selected"; ?>>Workshop
                            </option>
                            <option value="E-learning"
                                <?php if(isset($leervom) && in_array('E-learning', $leervom)) echo "selected"; ?>>
                                E-learning</option>
                            <option value="Masterclass"
                                <?php if(isset($leervom) && in_array('Masterclass', $leervom)) echo "selected"; ?>>
                                Masterclass</option>
                            <option value="Video"
                                <?php if(isset($leervom) && in_array('Video', $leervom)) echo "selected"; ?>>Video
                            </option>
                            <option value="Assessment"
                                <?php if(isset($leervom) && in_array('Assessment', $leervom)) echo "selected"; ?>>
                                Assessment</option>
                            <option value="Lezing"
                                <?php if(isset($leervom) && in_array('Lezing', $leervom)) echo "selected"; ?>>Lezing
                            </option>
                            <option value="Event"
                                <?php if(isset($leervom) && in_array('Event', $leervom)) echo "selected"; ?>>Event
                            </option>
                            <option value="Leerpad"
                                <?php if(isset($leervom) && in_array('Leerpad', $leervom)) echo "selected"; ?>>Leerpad
                            </option>
                            <option value="Artikel"
                                <?php if(isset($leervom) && in_array('Artikel', $leervom)) echo "selected"; ?>>Artikel
                            </option>
                            <option value="Podcast"
                                <?php if(isset($leervom) && in_array('Podcast', $leervom)) echo "selected"; ?>>Podcast
                            </option>
                            <option value="Cursus"
                                <?php if(isset($leervom) && in_array('Cursus', $leervom)) echo "selected"; ?>>Cursus
                            </option>
                            <option value="Class"
                                <?php if(isset($leervom) && in_array('Class', $leervom)) echo "selected"; ?>>Class
                            </option>
                            <option value="Webinar"
                                <?php if(isset($leervom) && in_array('Webinar', $leervom)) echo "selected"; ?>>Webinar
                            </option>
                        </select>
                        <select name="language">
                            <option></option>
                            <option value="en" <?php if (isset($language) && $language=="en") echo "selected"; ?> >
                                English
                            </option>
                            <option value="de" <?php if (isset($language) && $language=="de") echo "selected"; ?> >
                                Deutsch
                            </option>
                            <option value="nl" <?php if (isset($language) && $language=="nl") echo "selected"; ?> >
                                Nederlands
                            </option>
                            <option value="fr" <?php if (isset($language) && $language=="fr") echo "selected"; ?> >
                                French
                            </option>
                            <option value="it" <?php if (isset($language) && $language=="it") echo "selected"; ?> >
                                Italian
                            </option>
                            <option value="Ib" <?php if (isset($language) && $language == "Ib") echo "selected"; ?> >
                                Luxembourgish
                            </option>
                            <option value="sk" <?php if (isset($language) && $language == "sk") echo "selected"; ?> >
                                Slovak
                            </option>
                        </select>
                        <div class="priceInput">
                            <div class="priceFilter">
                                <input type="number" name="min" value="<?php if(isset($min)) echo $min ?>"
                                       placeholder="min Prijs">
                                <input type="number" name="max" value="<?php if(isset($max)) echo $max ?>"
                                       placeholder="tot Prijs">

                            </div>
                            <div class="input-group">
                                <label for="">Gratis</label>
                                <input name="gratis" type="checkbox" >
                            </div>

                        </div>
                        <select name="status">
                            <option value="" disabled selected>Status</option>
                            <option value="Live">Live</option>
                            <option value="Not Live">Not Live</option>
                        </select>

                        <button class="btn btnApplyFilter" name="filter_databank" type="submit">Apply</button>
                    </form>

                </div>

            </div>

            <div id="all" class="b-tab active contentBlockSetting">
                <div class="contentCardListeCourse">
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Titel</th>
                            <th scope="col">Type</th>
                            <th scope="col">Lang</th>
                            <th scope="col">Price</th>
                            <th scope="col">Sub-topics</th>
                            <th scope="col">Startdate</th>
                            <th scope="col">Teachers</th>
                            <th scope="col">Company</th>
                            <th scope="col">Status</th>
                            <th scope="col">Views</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody id="autocomplete_company_databank">
                        <?php
                        if (!empty($courses)) {
                            foreach ($courses as $course) {
                                $thumbnail = "";
                                $course_type = get_field('course_type', $course->ID);
                                $lang = get_field('language', $course->ID);
                                $language_display = '';
                                if ($lang){
                                    if (is_array($lang))
                                        $language_display = $lang[0];
                                    else
                                        $language_display = $lang;
                                    // take juste 2 first letter
                                    $lang_first_character = strtolower(substr($language_display,0,2));

                                    switch ($lang_first_character){
                                        case 'en':
                                            $language_display='English';
                                            break;
                                        case 'fr':
                                            $language_display='French';
                                            break;
                                        case 'de':
                                            $language_display='Dutch';
                                            break;
                                        case 'nl':
                                            $language_display='Nederlands';
                                            break;
                                        case 'it':
                                            $language_display='Italian';
                                            break;
                                        case 'Ib':
                                            $language_display='Luxembourgish';
                                            break;
                                        case 'sk':
                                            $language_display='Slovak';
                                            break;
                                    }
                                }

                                if(!$thumbnail){
                                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_field('url_image_xml', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                }

                                $image_author = get_field('profile_img', 'user_' . $course->post_author);
                                $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';

                                //Company
                                $company = get_field('company', 'user_' . $course->post_author);

                                $company_logo = get_stylesheet_directory_uri() . '/img/placeholder.png';
                                if (!empty($company)) {
                                    $company_logo = (get_field('company_logo', $company[0]->ID)) ? get_field('company_logo', $company[0]->ID) : get_stylesheet_directory_uri() . '/img/placeholder.png';
                                }

                                /*
                                 * Price
                                 */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price = number_format((float)$p, 2, '.', ',');
                                else
                                    $price = 'Gratis';

                                $day = "<p class='text-no-date'>no date given</p>";
                                $month = ' ';
                                $location = ' ';

                                $data = get_field('data_locaties', $course->ID);
                                if($data){
                                    $date = $data[0]['data'][0]['start_date'];
                                    $day = explode(' ', $date)[0];
                                }
                                else{
                                    $dates = get_field('dates', $course->ID);
                                    if($dates){
                                        $post_date = explode(' ', $dates[0]['date'])[0];
                                        $date_immu = new DateTimeImmutable($post_date);
                                        $day = $date_immu->format('d/m/Y');
                                    }
                                    else{
                                        $data = get_field('data_locaties_xml', $course->ID);
                                        if(isset($data[0]['value'])){
                                            $data = explode('-', $data[0]['value']);
                                            $date = $data[0];
                                            $day = explode(' ', $date)[0];
                                        }
                                    }
                                }
                                // //Categories

                                //Categories
                                $category = " ";
                                $id_category = 0;
                                $category_id = 0;
                                $categories = get_field('categories',  $course->ID);
                                if ($categories)
                                    if (isset($categories[0]['value'])) {
                                        $category_id = intval($categories[0]['value']);
                                    }
                                $categories_xml = get_field('category_xml', $course->ID);
                                if ($categories_xml)
                                    $category_xml = intval($categories_xml[0]['value']);
                                if(isset($category_xml))
                                    if($category_xml != 0)
                                        $category = (String)get_the_category_by_ID($category_xml);

                                if($category_id)
                                    if($category_id != 0)
                                        $category = (String)get_the_category_by_ID($category_id);

                                $artikel_single = "Artikel";
                                $white_type_array =  ['Lezing', 'Event'];
                                $course_type_array = ['Opleidingen', 'Workshop', 'Training', 'Masterclass', 'Cursus'];
                                $video_single = "Video";
                                $leerpad_single  = 'Leerpad';
                                $podcast_single = 'Podcast';
                                $path_edit  = "";
                                if($course_type == $artikel_single)
                                    $path_edit = "/dashboard/teacher/course-selection/?func=add-article&id=" . $course->ID ."&edit";
                                else if($course_type == $video_single)
                                    $path_edit = "/dashboard/teacher/course-selection/?func=add-video&id=" . $course->ID ."&edit";
                                else if(in_array($course_type,$white_type_array))
                                    $path_edit = "/dashboard/teacher/course-selection/?func=add-add-white&id=" . $course->ID ."&edit";
                                else if(in_array($course_type,$course_type_array))
                                    $path_edit = "/dashboard/teacher/course-selection/?func=add-course&id=" . $course->ID ."&edit";
                                else if($course_type == $leerpad_single)
                                    $path_edit = "/dashboard/teacher/course-selection/?func=add-road&id=" . $course->ID ."&edit";
                                else if($course_type == 'Assessment')
                                    $path_edit = "/dashboard/teacher/course-selection/?func=add-assessment&id=" . $course->ID ."&edit";
                                else if($course_type == 'Podcast')
                                    $path_edit = "/dashboard/teacher/course-selection/?func=add-podcast&id=" . $course->ID ."&edit";


                                $link = get_permalink($course->ID);
                                ?>
                                <tr class="pagination-element-block" id="<?= $course->ID ?>">
                                    <td>
                                        <div class="for-img">
                                            <img src="<?=$thumbnail;?>" alt="" srcset="">
                                        </div>
                                    </td>
                                    <td class="textTh text-left first-td-databank"><a style="color:#212529;font-weight:bold"
                                                                                      href="<?php echo get_permalink($course->ID) ?>"><?php echo $course->post_title; ?></a></td>
                                    <td class="textTh"><?= get_field('course_type', $course->ID);?></td>
                                    <td>
                                        <?= $language_display ?>
                                    </td>
                                    <td id="<?= $course->ID ?>" class="textTh">
                                        <?php echo empty(get_field('price', $course->ID)) ? 'Gratis':  get_field('price', $course->ID); ?>
                                    </td>

                                    <td id=" <?php echo $course->ID; ?>" class="textTh td_subtopics btn">
                                        <?php
                                        $course_subtopics = get_field('categories', $course->ID);
                                        if($course_subtopics != null){
                                            ?>
                                            <div id= "<?php echo $course->ID; ?>" class="d-flex content-subtopics bg-element" >
                                                <?= $category ?>
                                                <?php
                                                $field='';
                                                $read_topis = array();
                                                if($course_subtopics != null){
                                                    if (is_array($course_subtopics) || is_object($course_subtopics)){
                                                        foreach ($course_subtopics as $key => $course_subtopic) {
                                                            if(!$course_subtopic)
                                                                continue;
                                                            if(!is_int($course_subtopic['value']))
                                                                continue;

                                                            $topic_category = get_the_category_by_ID($course_subtopic['value']);
                                                            if(is_wp_error($topic_category))
                                                                continue;

                                                            if ($course_subtopic != "" && $course_subtopic != "Array" && !in_array(intval($course_subtopic['value']), $read_topis)){
                                                                $field .= (String)$topic_category . ',';
                                                                array_push($read_topis, intval($course_subtopic['value']));
                                                            }
                                                        }
                                                        $field = substr($field,0,-1);
                                                        echo $field;
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php } else { ?>
                                            <button class="td_subtopics btn btn-success" id="<?= $course->ID ?>">
                                                add subtopics
                                            </button>
                                        <?php } ?>
                                    </td>
                                    <td class="textTh">
                                        <div class="bg-element">
                                            <p> <?php
                                                $date = new DateTime($course->post_date);
                                                $formattedDate = $date->format('d/m/Y');
                                                echo  $day ;
                                                ?></p>
                                        </div>
                                    </td>
                                    <td  class="textTh block-pointer td_authors">
                                        <div id="id_authors" class="d-flex content-teacher one_author" data-toggle="modal" data-target="#showTeacher" onclick="loadAuthor(<?=$course->ID?>)"
                                             type="button" data-value="<?php echo $course->ID; ?>" >
                                            <?php if ($course->post_author) { ?>
                                                <img src="<?php echo $image_author?>" alt="image course" width="25" height="25">;
                                                <?php
                                            } else { ?>
                                                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="" srcset="">;
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="textTh block-pointer td_compagnies">
                                        <div class="d-flex content-company"  data-toggle="modal" data-target="#showCompany" data-value="<?php echo $course->ID ?>"
                                             type="button">
                                            <?php if (!empty($company)) {
                                                ?>
                                                <img src="<?php echo $company_logo?>" alt="image course" width="25" height="25">;
                                                <?php
                                            } else {
                                                ?>

                                                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/course-img.png" alt="image course" >;
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </td>
                                    <td class="textTh">

                                        <div class="bg-element">
                                            <p>Live</p>
                                        </div>

                                    </td>
                                    <td class="textTh">
                                        <div class="bg-element">
                                            <p>503</p>
                                        </div>
                                    </td>
                                    <td class="textTh">
                                        <div class="dropdown text-white">
                                            <p class="dropdown-toggle mb-0" type="" data-toggle="dropdown">
                                                <img style="width:20px"
                                                     src="https://cdn-icons-png.flaticon.com/128/61/61140.png" alt=""
                                                     srcset="">
                                            </p>


                                            <ul class="dropdown-menu">
                                                <li class="my-1"><i class="fa fa-ellipsis-vertical"></i>
                                                    <i class="fa fa-eye px-2"></i>
                                                    <a href="<?php echo $link; ?>" target="_blank">
                                                        Bekijk
                                                    </a>
                                                </li>

                                                <li class='my-2'><i class='fa fa-gear px-2'></i><a href='<?= $path_edit ?>' target='_blank'>Pas aan</a></li>

                                                <li class='my-1 remove_opleidingen' ><i class='fa fa-trash px-2'></i><input onclick="removeCourse(this)" id="<?= $course->ID ?>" type='button' value='Verwijderen'/></li>

                                            </ul>

                                        </div>
                                    </td>
                                </tr>



                                <?php
                                //  die();
                            }
                        } else {
                            echo ("There is nothing to see here");
                        }
                        ?>
                        </tbody>
                    </table>

                    <center>
                        <?php if ($total_pages > 1): ?>
                            <ul class="pagination">
                                <?php if ($current_page > 1): ?>
                                    <li class="prev"><a href="?id=<?php echo $current_page - 1; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard">Prev</a></li>
                                <?php endif; ?>

                                <?php if ($current_page > 3): ?>
                                    <li class="start"><a href="?id=1" style="color: #DB372C; font-weight: bold" class="textLiDashboard">1</a></li>
                                    <li class="dots">...</li>
                                <?php endif; ?>

                                <?php if ($current_page - 2 > 0): ?>
                                    <li class="page"><a href="?id=<?php echo $current_page - 2; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard"><?php echo $current_page - 2; ?>&nbsp;&nbsp;&nbsp;</a></li>
                                <?php endif; ?>
                                <?php if ($current_page - 1 > 0): ?>
                                    <li class="page"><a href="?id=<?php echo $current_page - 1; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard"><?php echo $current_page - 1; ?>&nbsp;&nbsp;&nbsp;</a></li>
                                <?php endif; ?>

                                <li class="currentpage"><a href="?id=<?php echo $current_page; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard"><?php echo $current_page; ?>&nbsp;&nbsp;&nbsp;</a></li>

                                <?php if ($current_page + 1 <= $total_pages): ?>
                                    <li class="page"><a href="?id=<?php echo $current_page + 1; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard"><?php echo $current_page + 1; ?>&nbsp;&nbsp;&nbsp;</a></li>
                                <?php endif; ?>
                                <?php if ($current_page + 2 <= $total_pages): ?>
                                    <li class="page"><a href="?id=<?php echo $current_page + 2; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard"><?php echo $current_page + 2; ?>&nbsp;&nbsp;&nbsp;</a></li>
                                <?php endif; ?>

                                <?php if ($current_page < $total_pages - 2): ?>
                                    <li class="dots">...</li>
                                    <li class="end"><a href="?id=<?php echo $total_pages; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard"><?php echo $total_pages; ?>&nbsp;&nbsp;&nbsp;</a></li>
                                <?php endif; ?>

                                <?php if ($current_page < $total_pages): ?>
                                    <li class="next"><a href="?id=<?php echo $current_page + 1; ?>" style="color: #DB372C; font-weight: bold" class="textLiDashboard">Next</a></li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                    </center>



                </div>
            </div>

            <div id="Opleidingen" class="b-tab contentBlockSetting">
                b
            </div>

            <div id="Article" class="b-tab contentBlockSetting">
                d
            </div>

            <div id="Podcast" class="b-tab contentBlockSetting">
                e
            </div>

            <div id="Videos" class="b-tab contentBlockSetting">
                f
            </div>
        </div>
    </div>
    <!-- Modal add company -->
    <div class="modal fade" id="ModalCompany" tabindex="-1" role="dialog" aria-labelledby="ModalCompanyLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Create a company</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="text-center" id="content-back-topics"></div>
                <div class="modal-body">
                    <form id="companyForm" >
                        <div class="form-group">
                            <label for="First-name">Click to choose your logo</label>
                            <div class="image-container" id="imageContainerCompany" onclick="document.getElementById('fileInputCompany').click()">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/placeholder_user.png" alt="Placeholder" id="uploadedImageCompany">
                            </div>
                            <input type="file" id="fileInputCompany" name="company_logo" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label for="Company-name">Company Name</label>
                            <input type="text" class="form-control" id="Company-name" name="company_name" placeholder="Enter your Company Name" required>
                        </div>
                        <div class="form-group">
                            <label for="Country">Company Country</label>
                            <input type="text" class="form-control" id="Country" name="company_country" placeholder="Enter your Company Country" required>
                        </div>
                        <div class="form-group">
                            <label for="City">Company City</label>
                            <input type="text" class="form-control" id="City" name="company_city" placeholder="Enter your Company City" required>
                        </div>
                        <div class="form-group">
                            <label for="Address">Company Address</label>
                            <input type="text" class="form-control" id="Address" name="company_address" placeholder="Enter your Company Address" required>
                        </div>
                        <div class="form-group">
                            <label for="Industry">Industry</label>
                            <input type="text" class="form-control" id="Industry" name="company_industry" placeholder="Enter your Industry" required>
                        </div>
                        <div class="form-group">
                            <label for="People">Amount of people</label>
                            <input type="number" class="form-control" id="People" name="company_size" placeholder="Enter the number of people">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitCompanyForm()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add teacher -->
    <div class="modal fade" id="ModalTeacher" tabindex="-1" role="dialog" aria-labelledby="ModalTeacherLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add a Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="text-center" id="content-back-topicsauthor"></div>
                <div class="modal-body">
                    <form id="userForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="Profile-photo">Profile photo</label>
                            <div class="image-container" id="imageContainer" onclick="document.getElementById('fileInput').click()">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/placeholder_user.png" alt="Placeholder" id="uploadedImage">
                            </div>
                            <input type="file" id="fileInput" name="profile_photo" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label for="First-name">First name</label>
                            <input type="text" class="form-control" id="First-name" name="first_name" placeholder="Enter her First name" required>
                        </div>
                        <div class="form-group">
                            <label for="Last-name">Last name</label>
                            <input type="text" class="form-control" id="Last-name" name="last_name" placeholder="Enter her Last name" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="email" placeholder="Enter her Email" required>
                        </div>
                        <div class="form-group">
                            <label for="Phonenumber">Phone number</label>
                            <input type="text" class="form-control" id="Phonenumber" name="phone_number" placeholder="Enter her Phone number" required>
                        </div>
                        <div class="form-group">
                            <label class="label-sub-topics">Select Company</label>
                            <select name="companyId" id="selected_company"  class="multipleSelect2" >
                                <?php
                                foreach($companies as $value) {
                                    echo "<option value='" . $value->ID . "'>" . $value->post_name . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUserForm()">Save</button>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal add teacher -->
    <div class="modal fade" id="ModalTeacher" tabindex="-1" role="dialog" aria-labelledby="ModalTeacherLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sub-topics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="First-name">Profile photo</label>
                            <div class="image-container" id="imageContainer" onclick="openImageUploader()">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/placeholder_user.png"
                                     alt="Placeholder" id="uploadedImage"">
                            </div>
                            <input type=" file" id="fileInput" name="profile_photo" accept="image/*" style="display: none;">
                        </div>
                        <div class="form-group">
                            <label for="First-name">First name</label>
                            <input type="text" class="form-control" id="First-name*"
                                   placeholder="Enter her First name" required>
                        </div>
                        <div class="form-group">
                            <label for="Country">Last name</label>
                            <input type="text" class="form-control" id="Last-name" placeholder="Enter her Last name"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="Email" name="City"
                                   placeholder="Enter her Email" required>
                        </div>
                        <div class="form-group">
                            <label for="Phonenumber">Phone number</label>
                            <input type="text" class="form-control" id="Phonenumber"
                                   placeholder="Enter her Phone number" required>
                        </div>
                        <div class="form-group">
                            <label for="Industry">Role</label>
                            <select name="" id="">
                                <option value="">User</option>
                                <option value="">Teacher</option>
                                <option value="">Admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal show teacher -->
    <div class="modal fade" id="showTeacher" tabindex="-1" role="dialog" aria-labelledby="showTeacherLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="text-center" id="seclect-author"></div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center head-for-body">
                        <p class="btn-sub-title-topics" id="removeTeacher" type="button">Remove</p>
                        <p class="text-or">Or</p>
                        <button class="btn btn-add-sub-topics" id="addTeacher" type="button">Add teacher</button>
                    </div>
                    <div class="block-to-show-teacher">

                    </div>

                    <div class="block-to-add-teacher">
                        <form action="">
                            <div class="form-group mb-4">
                                <div class="companyAutho" id="companyAuthor"></div>
                                <label class="label-sub-topics">Select Author(s) </label>
                                <div class="formModifeChoose">
                                    <select name="userId" id="selected_user" class="multipleSelect2" multiple="true">
                                        <?php

                                        foreach($author_users as $value)
                                            echo "<option    value='" . $value->ID . "'>" . $value->display_name . "</option>";

                                        ?>




                                    </select>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="save_author" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-dialog" role="document" style="height: 75vh; overflow-y: auto;">
            <style>
                .scroller:{
                    max-height: 80vh;
                    overflow-y: auto;
                }
            </style>
            <div class="modal-content scroller">
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#autocomplete').on('change', function() {
            if ($(this).val()) {
                $(".block-sub-topics").show();
            } else {
                $(".block-sub-topics").hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const itemsPerPage = 20;
        const $rows = $('.pagination-element-block');
        const pageCount = Math.ceil($rows.length / itemsPerPage);
        let currentPage = 1;

        function showPage(page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            $rows.each(function(index, row) {
                if (index >= startIndex && index < endIndex) {
                    $(row).css('display', 'table-row');
                } else {
                    $(row).css('display', 'none');
                }
            });
        }

        function createPaginationButtons() {
            const $paginationContainer = $('.pagination-container');

            if (pageCount <= 1) {
                $paginationContainer.css('display', 'none');
                return;
            }

            const $prevButton = $('<button>&lt;</button>').on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                    updatePaginationButtons();
                }
            });

            const $nextButton = $('<button>&gt;</button>').on('click', function() {
                if (currentPage < pageCount) {
                    currentPage++;
                    showPage(currentPage);
                    updatePaginationButtons();
                }
            });

            $paginationContainer.append($prevButton);

            for (let i = 1; i <= pageCount; i++) {
                const $button = $('<button></button>').text(i);
                $button.on('click', function() {
                    currentPage = i;
                    showPage(currentPage);
                    updatePaginationButtons();
                });

                if (i === 1 || i === pageCount || (i >= currentPage - 2 && i <= currentPage + 2)) {
                    $paginationContainer.append($button);
                } else if (i === currentPage - 3 || i === currentPage + 3) {
                    $paginationContainer.append($('<span>...</span>'));
                }
            }

            $paginationContainer.append($nextButton);
        }

        function updatePaginationButtons() {
            $('.pagination-container button').removeClass('active');
            $('.pagination-container button').filter(function() {
                return parseInt($(this).text()) === currentPage;
            }).addClass('active');
        }

        showPage(currentPage);
        createPaginationButtons();
    });
</script>

<script>
    const selectButtons = document.querySelectorAll('.select-button');
    selectButtons.forEach(button => {
        button.addEventListener('click', () => {
            button.classList.toggle('active');
        });
    });
</script>
<script>
    $(".btn-add-sub-topics").click(function() {
        $(".content-sub-topics").hide();
        $(".content-add-sub-topics").show();
    });
    $(".btn-sub-title-topics").click(function() {
        $(".content-sub-topics").show();
        $(".content-add-sub-topics").hide();
    });
    $("#addTeacher").click(function() {
        $(".block-to-add-teacher").show();
        $(".block-to-show-teacher").hide();
    });
    $("#removeTeacher").click(function() {
        $(".block-to-add-teacher").hide();
        $(".block-to-show-teacher").show();
    });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // $(document).ready(function() {
    //     $('.topic-item').on('click', function() {
    //         var topic = $(this).data('topic');
    //         console.log(topic);
    //         var topics = $(this).data('topic');
    //         var topicHtml = '';
    //         topics.forEach(function(topic) {
    //             topicHtml += '<div class="btn-sub-topics">' +
    //                 '<p>' + topic + '</p>' +
    //                 '<button class="btn"><i class="fa fa-remove"></i></button>' +
    //                 '</div>';
    //         });

    //         $('.content-sub-topics').html(topicHtml);
    //     });
    // });
</script>
<script>
    function submitUserForm() {
        // var formData = new FormData(document.getElementById('userForm'));
        var form = document.getElementById('userForm');
        var companyId = $('#selected_company').val()
        document.getElementById('content-back-topicsauthor').innerHTML ="<span>Wait for saving datas <i class='fas fa-spinner fa-pulse'></i></span>";
        // Create a FormData object to send the file
        var formData = new FormData(form);
        formData.append('action', 'add_users');
        formData.append('companyId', companyId);
        $.ajax({
            url: "/save-author-and-compagny",
            method:"post",
            data: formData,
            processData: false,
            contentType: false,

            // dataType:"text",
            success: function(response) {
                console.log(response)
                // alert('User created successfully!');
                document.getElementById('content-back-topicsauthor').innerHTML = response;
                // Optionally, you can refresh the page or update the UI accordingly
                //  $('#ModalTeacher').modal('hide');
            },
            error: function(response) {
                alert('Failed to create user!');
                document.getElementById('content-back-topicsauthor').innerHTML = response;
                //  $('#ModalTeacher').modal('hide');
            },
            complete:function(response){
                location.reload();
            }
        });
    }
</script>
<script>
    function submitCompanyForm() {
        document.getElementById('content-back-topics').innerHTML ="<span>Wait for saving datas <i class='fas fa-spinner fa-pulse'></i></span>"
        var form = document.getElementById('companyForm');
        var formData = new FormData();
        for (var i = 0; i < form.elements.length; i++) {
            var element = form.elements[i];
            if (element.name) {
                formData.append(element.name, element.value);
            }
        }
        const fileInput = document.getElementById('fileInputCompany');
        if (fileInput.files.length > 0) {
            formData.append('company_logo', fileInput.files[0]);
        }
        formData.append('action', 'add_compagnies');
        $.ajax({
            url: "/save-author-and-compagny",
            method: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                document.getElementById('content-back-topics').innerHTML = response;
                // $('#ModalCompany').modal('hide');
                // Optionally, you can refresh the page or update the UI accordingly
            },
            error: function(response) {
                alert('Failed to create company!');
                document.getElementById('content-back-topics').innerHTML = response;
                // $('#ModalCompany').modal('hide');
            },
            complete:function(response){
                location.reload();
            }
        });
    }
</script>

<!-- script-modal -->
<script>

    $('.td_subtopics').click((e)=>{
        id_course = e.target.id;
        console.log('id course to add subtopics',id_course)
        $.ajax({
            url:"/fetch-topic-subtopics-databank-live",
            method:"post",
            data:
                {
                    id_course:id_course,
                    action:'get_course_subtopics'
                },
            dataType:"text",
            beforeSend:function (){
                var modal = document.getElementById("myModal");
                $('.modal-content').html('<span>waiting for ...</span>')
                modal.style.display = "block";
            },
            success: function(data) {
                var modal = document.getElementById("myModal");
                $('.modal-content').html(data);
                var span = document.getElementsByClassName("close")[0];

                const categoryTitles = document.querySelectorAll(".category-title");
                const subcatchossen = document.querySelectorAll('.subcatchossen');

                categoryTitles.forEach(title => {
                    title.addEventListener("click", function () {
                        const targetId = this.getAttribute("data-toggle");
                        console.log(targetId);
                        const subcategories = document.getElementById(targetId);
                        if (subcategories) {
                            subcategories.classList.toggle("hidden");
                        }
                    });
                });
                subcatchossen.forEach((sub) => {
                    sub.addEventListener('click', (e) => {
                        const subtopicsChoosed = e.target;
                        // const subId = subtopicsChoosed.id;
                        subtopicsChoosed.classList.toggle('selected');
                    });
                });
                modal.style.display = "block";
                span.onclick = function() {
                    modal.style.display = "none";
                };
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                };
            },
            complete:function () {
                $(this).off('click');
            }
        });
    });
    $('#save_author').click((e)=>{
            document.getElementById('companyAuthor').innerHTML="<span>Wait for saving datas <i class='fas fa-spinner fa-pulse'></i></span>";
            const id_course_id_course = $('div[id^="id_course_"]')[0].id;
            const id_course = id_course_id_course.replace('id_course_','');
            //console.log(id_course);return;
            var author = $('#selected_user').val()
            $.ajax({
                url:"/save-author-and-compagny",
                method:"post",
                data: {
                    connect_authortoCourse:author,
                    id_course:id_course,
                    action:'connect_authortoCourse'
                },
                dataType:"text",
                success: function(data){
                    //console.log(data);
                    document.getElementById('companyAuthor').innerHTML = data;

                },
                error:function(data){
                    document.getElementById('companyAuthor').innerHTML = data;
                },
                complete:function(response){
                    location.reload();
                }
            })
        }
    );
    function loadAuthor(id_course){
        console.log('id course clicked',id_course);
        $.ajax({
            url:"/fetch-subtopics-course-databanklive",
            method:"post",
            data:
                {
                    id_course:id_course,
                    action:'get_course_authors'
                },
            beforeSend:function (){
                $('.block-to-show-teacher').html("<span>Wait for getting datas <i class='fas fa-spinner fa-pulse'></i></span>")
            },
            error:function (error) {
                console.log(error)
            },
            success:function (data){
                $('.block-to-show-teacher').html(data)
                //console.log(success)
            },
            complete:function (){
            }
        })
        // part number two
    }
</script>

<script>
    function openImageUploader() {
        document.getElementById('fileInput').click();
    }

    document.getElementById('fileInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                const imageContainer = document.getElementById('imageContainer');
                const uploadedImage = document.getElementById('uploadedImage');

                imageContainer.style.backgroundImage = `url('${reader.result}')`;
                uploadedImage.src = reader.result;
                uploadedImage.style.display = 'block';
                imageContainer.querySelector('span').style.display = 'none';
            });

            reader.readAsDataURL(file);
        }

    });

</script>
<script>
    document.getElementById('fileInputCompany').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                const imageContainer = document.getElementById('imageContainerCompany');
                const uploadedImage = document.getElementById('uploadedImageCompany');
                imageContainer.style.backgroundImage = `url('${reader.result}')`;
                uploadedImage.src = reader.result;
                uploadedImage.style.display = 'block';
                imageContainer.querySelector('span').style.display = 'none';
            });
            reader.readAsDataURL(file);
        }
    });
</script>
<script>
    $('#search_txt_course').keyup(function(){
        var txt = $(this).val();
        console.log(txt);
        $.ajax({
            url:"/fetch-databank-live-course/",
            method:"post",
            data:{
                search_txt_course : txt,
            },
            dataType:"text",
            success: function(data){
                $('#autocomplete_company_databank').html(data);
            }
        });
    });
</script>
<script>
    function removeCourse(e){
        var id = e.id
        console.log(id)
        //var loader = document.getElementById('loader')
        if(confirm('Are you sure you want to delete this course ?')){
            $.ajax({
                url:"/live-fetch-databank-2/",
                method:"post",
                data: {
                    id_course_to_delete : id
                },
                dataType:"text",
                beforeSend:function (){
                    console.log('before send')
                    $('#loader').removeClass('d-none');
                },
                error:function (e,status){
                    console.log('error',e.responseText)
                    console.log('status :',status)
                },
                success:function (succes){
                    //console.log('susscess',succes)
                    alert(succes)
                    location.reload();
                },
                complete:function (){
                    console.log('complete')
                }
            })
        }
    }
</script>
<?php get_footer(); ?>
<?php wp_footer(); ?>