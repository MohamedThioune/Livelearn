<?php /** Template Name: CourseType Overview */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php
//$page = 'check_visibility.php';
//require($page);

// Modules
require_once('postal.php'); 
require_once('search-module.php'); 

//Let's kick it off
extract($_GET);

$courses = array();
$order_type = array();
$expertise = array();

//Get Course Type 
$typo_course = array('Opleidingen' => 'opleiding', 'Workshop' => 'opleiding', 'Masterclass' => 'opleiding', 'E-learning' => 'e-learning', 'Event' => 'opleiding', 'Training' => 'opleiding', 'Video' => 'video', 'Artikel' => 'artikel', 'Podcast' => 'podcast', 'Webinar' => 'opleiding', 'Lezing' => 'opleiding', 'Cursus' => 'opleiding');
$typo_course_index = array('Opleidingen', 'Workshop', 'Masterclass', 'E-learning', 'Event', 'Training', 'Video', 'Artikel', 'Podcast', 'Webinar', 'Lezing', 'Cursus');

$filter_input = ($_GET['filter']) ?: 0;
$belonging_type = in_array($filter_input, $typo_course_index) ? true : false;
$error_content = '<h1 class="wordDeBestText2">CourseType Not Found ❗️</h1>';
if(!$belonging_type):
    echo $error_content;
    die();
endif;

//Get User ID
$user_id = get_current_user_id();

//Global posts
$max_input = 1000;
$args = array(
    'post_type' => array('post','course'),
    'post_status' => 'publish',
    'orderby' => 'date',
    'order'   => 'DESC',
    'posts_per_page' => $max_input,
);
$global_posts = get_posts($args);

/* * Filter by type course * */
$courses = searching_course_by_type($global_posts, $filter_input)['courses'];
$expertise = searching_course_by_type($courses, $_GET['filter'])['experts'];

/* * Search by filter * */
if(isset($filter_args)):

    $no_filter = false;
    $prijs_input = intval($prijs_input);
    $locatie_input = intval($locatie_input);
    if (!isset($experties))
        $experties = array();

    // Define args for search
    $args = array();
    $args['min'] = ($prijs_input == 2) ? 1 : null;
    $args['gratis'] = ($prijs_input == 1) ? 1 : null;
    // $args['locate'] = ($locatie_input == 1) ? 1 : null;
    // $args['online'] = ($locatie_input == 2) ? 1 : null;
    $args['experties'] = (!empty($experties)) ? $experties : null;
  
    $courses = (empty($courses)) ? $global_posts : $courses;
    //Apply filter 
    $courses = searching_course_with_filter($courses, $args)['courses']; 
    $expertise = searching_course_with_filter($courses, $args)['experts'];

    // var_dump($courses);
    // die();

    /* * End search by * */
endif;

?>


<div class="content-community-overview bg-gray template-overview">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-' . $typo_course[$filter_input] . '.png'; ?>" class="img-head-about border-0" alt="">
                <h1 class="wordDeBestText2">All <?= $filter_input ?></h1>
                <form action="" class="d-flex formFilterTemplate" method="GET">
                    <input type='hidden' name='filter_args' value='1'>
                    <select class="form-select" name="filter" aria-label="Leervom" required>
                        <option value="<?= $filter_input ?>" selected><?= $filter_input ?></option>
                        <?php
                        foreach ($typo_course_index as $typo_course) 
                            echo "<option value='" . $typo_course . "'> " . $typo_course . "</option>";
                        ?>
                    </select>
                    <select class="form-select" name="prijs_input" aria-label="All Prijs">
                        <option selected>Prijs</option>
                        <option value="1">Free</option>
                        <option value="2">Paid</option>
                    </select>
                    <!-- 
                    <select class="form-select" name="locatie_input" aria-label="All Locatie">
                        <option selected>Locatie</option>
                        <option value="1">Offline</option>
                        <option value="2">Online</option>
                    </select> -->
                    <select class="form-select" name="experties[]" aria-label="All Expert">
                        <option selected>Expert</option>
                        <?php
                        foreach($expertise as $expert):
                            if(!$expert)
                                continue;

                            $teacher_data = get_user_by('id', $expert);

                            $user_id = get_current_user_id();
                            if($teacher_data->ID != $user_id)
                                $name = ($teacher_data->last_name) ? $teacher_data->first_name : $teacher_data->display_name;
                            else
                                $name = "Ikzelf";

                            if($teacher_data->first_name == "")
                                continue;
                            ?>
                            <option value="<?= $expert ?>"><?= $name ?></option>
                        <?php
                        endforeach;  
                        ?>
                    </select>
                    <button class="btn btn-filter"><i class="fa fa-filter"></i><span>Filter</span></button>
                </form>
            </div>
        </div>
    </section>
    <section class="content-product-search">
        <div class="container-fluid">
            <!-- 
            <form action="" class="d-flex align-items-center justify-content-between form-search-course-filter mt-3 mb-2">
                <div class="btn-group-layouts">
                    <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
                    <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
                </div>
                <div class="form-group position-relative mb-0">
                    <i class="fa fa-search"></i>
                    <input type="search" placeholder="Search" class="search-course">
                </div>
            </form> -->
            <?php
            if(!empty($courses))
            echo 
            '<div class="block-new-card-course grid" id="autocomplete_recommendation">';
                foreach($courses as $post):
                    if(!$post)
                        continue;

                    $hidden = true;
                    $hidden = visibility($post, $visibility_company);
                    if(!$hidden)
                        continue;

                    /* Displaying information */

                    $course_type = get_field('course_type', $post->ID);
                    
                    //Image information
                    $thumbnail = get_field('preview', $post->ID)['url'];
                    if(!$thumbnail){
                        $thumbnail = get_the_post_thumbnail_url($post->ID);
                        if(!$thumbnail)
                            $thumbnail = get_field('url_image_xml', $post->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                    }

                    //Author information
                    $author = get_user_by('ID', $post->post_author);
                    $name_author = ($author) ? $author->display_name : 'None';
                    $user_id = get_current_user_id();
                    if($author->ID != $user_id)
                        $name = ($author->last_name) ? $author->first_name : $author->display_name;
                    else
                        $name = "Ikzelf";
                
                    $image_author = get_field('profile_img',  'user_' . $post->post_author);
                    if(!$image_author)
                        $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";

                    //Date and Location
                    $offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
                    $data = null;
                    $count_data = 0;
                    $data_locaties = get_field('data_locaties', $post->ID);
                    $data_locaties_xml = get_field('data_locaties_xml', $post->ID);
                    $location = 'Online';
                    if(!empty($data_locaties)):
                        $count_data = count($data_locaties) - 1;
                        $data = $data_locaties[$count_data]['data'][0]['start_date'];
                        $location = $data_locaties[0]['data'][0]['location'];
                    elseif(!empty($data_locaties_xml)):
                        $count_data = count($data_locaties_xml) - 1;
                        if($data_locaties_xml):
                            if(isset($data_locaties_xml[intval($count_data)]['value']))
                                $element = $data_locaties_xml[intval($count_data)]['value'];
                            if(isset($data_locaties_xml[0]['value'])){
                                $data_first = explode('-', $datum[0]['value']);
                                $location = $data_first[2];
                            }
                        endif;

                        if(!isset($element))
                            continue;

                        $datas = explode('-', $element);
                        $data = $datas[0];
                    endif;

                    if( empty($data) || !in_array($course_type, $offline) )
                        null;
                    elseif( !empty($data) )
                        if($data){
                            $date_now = strtotime(date('Y-m-d'));
                            $data = strtotime(str_replace('/', '.', $data));
                            if($data < $date_now)
                                continue;
                        }
                    
                    //Price information
                    $price_noformat = get_field('price', $post->ID) ?: 'Gratis';
                    if($price_noformat != "Gratis")
                        $price = '€' . number_format($price_noformat, 2, '.', ',');
                    else
                        $price = 'Gratis';
                    
                    //Link 
                    $link = get_permalink($post->ID);

                    /* End Displaying */

                ?>
                    <a href="<?= $link ?>" class="new-card-course visible">
                        <div class="content-course-block">
                            <div class="head">
                                <img src="<?= $thumbnail ?>" alt="">
                            </div>
                            <div class="details-card-course">
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course"><?= $post->post_title ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                    <div class="blockOpein">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <p class="lieuAm"><?= $location ?></p>
                                    </div>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="blockImgUser">
                                            <img src="<?= $image_author ?>" alt="">
                                        </div>
                                        <p class="autor"><?= $name_author ?></p>
                                    </div>
                                    <p class="price"><?= $price ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
                endforeach;
                echo 
                '</div>';
                ?>
            <div class="pagination-container">
                <!-- Les boutons de pagination seront ajoutés ici -->
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!--script pagination-->

<script>
    const itemsPerPage = 9;
    const blockList = document.querySelector('.block-new-card-course');
    const blocks = blockList.querySelectorAll('.new-card-course');
    const paginationContainer = document.querySelector('.pagination-container');

    function displayPage(pageNumber) {
        const start = (pageNumber - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        blocks.forEach((block, index) => {
            if (index >= start && index < end) {
                block.style.display = 'block';
                block.classList.add('visible');
            } else {
                block.style.display = 'none';
                block.classList.remove('visible');
            }
        });

        const containerHeight = blockList.offsetHeight;

        setTimeout(() => {
            blockList.style.height = containerHeight + 'px';
        }, 10);
        setTimeout(() => {
            blockList.style.height = '';
        }, 300);
    }

    function createPaginationButtons() {
        const pageCount = Math.ceil(blocks.length / itemsPerPage);

        if (pageCount <= 1) {
            return;
        }

        let firstButtonAdded = false; // Keep track of whether the first button is added

        for (let i = 1; i <= pageCount; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.classList.add('pagination-button');
            button.addEventListener('click', () => {
                scrollToTop(); // Scroll to the top when a button is clicked
                displayPage(i);

                // Remove the .active class from all buttons
                const buttons = document.querySelectorAll('.pagination-button');
                buttons.forEach((btn) => {
                    btn.classList.remove('active');
                });

                // Add the .active class to the clicked button
                button.classList.add('active');
            });
            paginationContainer.appendChild(button);

            // Add the .active class to the first button
            if (!firstButtonAdded) {
                button.classList.add('active');
                firstButtonAdded = true;
            }
        }
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    displayPage(1);
    createPaginationButtons();


</script>

<script>
    $(".content-filter").click(function() {
        $(".theme-side-menu").show();
    });
    $(".btn-close-filter").click(function() {
        $(".theme-side-menu").hide();
    });
</script>


</body>
