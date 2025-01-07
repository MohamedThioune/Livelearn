<?php /** Template Name: Category overview */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<?php
//$page = 'check_visibility.php';
//require($page);

// Modules
require_once('search-module.php'); 

$courses = array();
$order_type = array();
$expertise = array();

//Get ID Category
$category_input = ($_GET['category']) ?: 0;
$name = get_the_category_by_ID($category_input);
$no_content =  '
                <p class="dePaterneText theme-card-description"> 
                <span style="color:#033256"> This category not found ❗️</span> 
                </p>
                ';
if(!$name):
    echo $no_content;
    die();
endif;

//Get User ID
$user_id = get_current_user_id();

//Track view
view_topic($category_input);

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

// Category post 
$courses = searching_course_by_group($global_posts, 'category', $category_input)['courses'];
$order_type = searching_course_by_group($global_posts, 'category', $category_input)['order_type'];
$expertise = searching_course_by_group($global_posts, 'category', $category_input)['experts'];

//Category information
$genuine_category = get_categories(array('taxonomy' => 'course_category', 'orderby' => 'name', 'hide_empty' => 0, 'include' => (int)$category_input) )[0];
if(is_wp_error($name) || is_wp_error($genuine_category)):
    echo $no_content;
    die();
endif;

$image_category = get_field('image', 'category_'. $category_input);
$image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';

// var_dump($genuine_category);
// die();

$other_topics = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'exclude'    => 'Uncategorized',
    'parent'     => $genuine_category->parent,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

//Topics followed 
$topics_internal = get_user_meta($user_id,'topic_affiliate');
$topics_external = get_user_meta($user_id,'topic');

//Type course
$typo_course = array('Opleidingen', 'Workshop', 'Masterclass', 'E-learning', 'Event', 'Training', 'Video', 'Artikel', 'Podcast', 'Webinar', 'Lezing', 'Cursus');

if(isset($_GET['filter_typo'])):
    $courses = searching_course_by_type($courses, $_GET['filter_typo'])['courses'];
    $expertise = searching_course_by_type($courses, $_GET['filter_typo'])['experts'];
    $order_type = searching_course_by_type($courses, $_GET['filter_typo'])['order_type'];
endif;

?>

<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?= $image_category ?>" class="img-head-about" alt="">
                <h1 class="wordDeBestText2"><?= $name ?></h1>
                <form action="../dashboard/user/" method="POST">
                    <input type="hidden" name="category" value="1" id="">
                    <input type="hidden" name="meta_value" value="<?= $category_input ?>" id="">
                    <input type="hidden" name="user_id" value="<?= $user_id ?>" id="">
                    <?php
                    $follow = '
                    <button class="btn btn-follown" type="submit" name="interest_push">
                        <img src="' . get_stylesheet_directory_uri() . '/img/follow-icon.svg" class="img-follown" alt="">
                        Follow
                    </button>';
                    $unfollow = '
                    <button class="btn btn-follown" type="submit" name="delete">
                        <img src="' . get_stylesheet_directory_uri() . '/img/follow-icon.svg" class="img-follown" alt="">
                        UnFollow
                    </button>';
                    $intern = '
                    <a href="#" class="btn btn-follown" type="submit">
                        <img src="' . get_stylesheet_directory_uri() . '/img/follow-icon.svg" class="img-follown" alt="">
                        Internal
                    </a>';

                    if($user_id)
                        if (in_array($category_input, $topics_internal)):
                            echo '<input type="hidden" name="meta_key" value="topic_affiliate" id="">';
                            echo $intern;
                        elseif (in_array($category_input, $topics_external)):
                            echo '<input type="hidden" name="meta_key" value="topic" id="">';
                            echo $unfollow;
                        else:
                            echo '<input type="hidden" name="meta_key" value="topic" id="">';
                            echo $follow;
                        endif;
                    ?>
                </form>
            </div>
        </div>
    </section>
    <section class="content-product-search content-company-overview content-sub-topic">
        <div class="theme-content">
            <div class="theme-learning">
                <div class="">
                    
                    <div class="block-subTocis d-flex flex-wrap">
                        <?php
                            foreach ($typo_course as $typo) 
                                echo '<a href="?category='. $category_input .'&filter_typo='.$typo.'" class="btn btn-subTopics">' . $typo . '</a>';
                        ?>
                       
                    </div>
                    <div class="btn-group-layouts">
                        <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
                        <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
                    </div>
                    <!-- 
                    <form action="" class="d-flex align-items-center justify-content-between form-search-course-filter mb-0">
                        <div class="form-group position-relative mb-0">
                            <i class="fa fa-search"></i>
                            <input type="search" placeholder="Search" class="search-course">
                        </div>
                        <div class="custom-select-course position-relative">
                            <select class="form-select">
                                <option selected>Filter</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                            </select>
                            <span class="filter-icon">
                                <i class="fa fa-filter"></i>
                            </span>
                        </div>
                    </form> -->
                    <div class="block-filter-mobile">
                        <button class="content-filter d-flex ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/filter.png" alt="">
                            <span>show left bar</span>
                        </button>
                    </div>
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
                                            <div class="blockOpein d-flex align-items-center">
                                                <i class="fas fa-graduation-cap"></i>
                                                <p class="lieuAm"><?= $course_type ?></p>
                                            </div>
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
            </div>
            <div class="theme-side-menu d-block">
                <div class="block-filter">
                    <p class="text-filter-course">Infos</p>
                    <?php
                    if(!empty($other_topics)):
                    echo '
                    <div class="sub-section">
                        <p class="description-sub-section">Others Topics</p>
                    
                        <div class="d-flex flex-wrap">
                    ';

                    foreach($other_topics as $key => $otopic):
                        if($otopic->cat_ID == $category_input)
                            continue;
                        echo '<a href=/category-overview?category=' . $otopic->cat_ID . '  class="topic-element">' . $otopic->cat_name . '</a>';
                        if($key == 6)
                            break;
                    endforeach;

                    echo '
                        </div>
                    </div>';
                    endif;
                    if(!empty($expertise)):
                        echo '
                        <div class="sub-section">
                            <p class="description-sub-section">Expert</p>';
                            $i = 0;
                            foreach($expertise as $id):
                                $expertie = get_user_by('ID', $id);
                                $image_expertie = get_field('profile_img',  'user_' . $id);
                                $image_expertie = $image_expertie ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                
                                $user_id = get_current_user_id();
                                if($expertie->ID != $user_id)
                                    $name = ($expertie->last_name) ? $expertie->first_name : $expertie->display_name;
                                else
                                    $name = "Ikzelf";

                                if($expertie->first_name == "")
                                    continue;

                                if($i >= 4)
                                    break;
                                $i += 1;    

                                echo '
                                <a href="/user-overview/?id=' . $expertie->ID . '" class="profil-expert d-flex align-items-center">
                                    <div class="group-img">
                                        <img src="' . $image_expertie . '" alt="">
                                    </div>
                                    <p>'. $name .'</p>
                                </a>';
                            endforeach;
                        echo '
                        </div>';
                    endif;
                    ?>
                </div>
                <div class="card-pub-course">
                    <h2>We Help You Learn While
                        Staying Home</h2>
                    <a href="/about" class="btn btn-started-now">Get Started Now</a>
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/man-pub.png" alt="">
                </div>
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
