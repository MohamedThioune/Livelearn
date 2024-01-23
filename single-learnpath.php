<?php /** Template Name: new leerpad course */ ?>

<?php 
wp_head();
get_header(); 

// $page = dirname(__FILE__) . '/templates/check_visibility.php';
// require($page); 

view($post,$user_visibility)
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />

<?php
global $post;
global $wp;
global $wpdb;

if(!visibility($post, $visibility_company))
    header('location: /'); 

$url = home_url( $wp->request );

$category_default = get_field('categories', $post->ID);
$category_xml = get_field('category_xml', $post->ID);

$course_type = get_field('course_type', $post->ID);

//Image - article
$image = get_field('preview', $post->ID)['url'];
if(!$image){
    $image = get_the_post_thumbnail_url($post->ID);
    if(!$image)
        $image = get_field('url_image_xml', $post->ID);
            if(!$image)
                $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
}

// Experts
$user_choose = $post->post_author;
$expert = get_field('experts', $post->ID);
$author = array($user_choose);
if(isset($expert[0]))
    $experts = array_merge($expert, $author);
else
    $experts = $author;

//Author
$author = get_user_by('id', $post->post_author);
$author_name = ($author->last_name) ? $author->first_name . ' ' . $author->last_name : $author->display_name; 
$author_picture = get_field('profile_img', 'user_' . $post->post_author) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

$biographical = get_field('biographical_info',  'user_' . $post->post_author);

$functie = get_field('role',  'user_' . $post->post_author);

if($tag = ''){
    $tagS = intval(explode(',', get_field('categories',  $post->ID)[0]['value'])[0]);
    $tagI = intval(get_field('category_xml',  $post->ID)[0]['value']);
    if($tagS != 0)
        $tag = (String)get_the_category_by_ID($tagS);
    else if($tagI != 0)
        $tag = (String)get_the_category_by_ID($tagI);                                    
}

$user_id = get_current_user_id();
$short_description = get_field('short_description',  $post->ID)  ?: 'No short description found for this learnpath';
$long_description = get_field('long_description',  $post->ID) ?: 'No long description found for this learnpath';
$price_noformat = get_field('price', $post->ID) ?: 'Gratis';
if($price_noformat != "Gratis")
    $price = '€' . number_format($price_noformat, 2, '.', ',');
else
    $price = 'Gratis';

//Similar course
$recent_leerpads = array();
$args = array(
    'post_type' => 'learnpath',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$posts = get_posts($args);
foreach ($posts as $key => $course) {
    if($course->ID == $post->ID)
        continue;
    $type_course = get_field('course_type', $course->ID);
    if($type_course == $course_type)
        array_push($recent_leerpads, $course);
        
    if(count($recent_leerpads) == 5)
        break;
} 

//Reviews
$reviews = get_field('reviews', $post->ID);
$number_comments = !empty($reviews) ? count($reviews) : '0';
// $count_reviews_all = 0;
$star_review = [ 0, 0, 0, 0, 0];
$average_star = 0;
$average_star_nor = 0;
$my_review_bool = false;
$counting_rate = 0;
foreach ($reviews as $review):
    if($review['user']->ID == $user_id)
        $my_review_bool = true;

    //Star by number
    switch ($review['rating']) {
        case 1:
            $star_review[1] += 1;
            break;
        case 2:
            $star_review[2] += 1;
            break;
        case 3:
            $star_review[3] += 1;
            break;
        case 4:
            $star_review[4] += 1;
            break;
        case 5:
            $star_review[5] += 1;
            break;
    }

    if($review['rating']){
        $average_star += intval($review['rating']); 
        $counting_rate += 1;
    }
endforeach;
if ($counting_rate > 0 )
    $average_star_nor = $average_star / $counting_rate;
$average_star_format = number_format($average_star_nor, 1, '.', ',');
$average_star = intval($average_star_nor);
//Review pourcentage
if(!empty($counting_rate)):
    $star_review[1] = ($star_review[1] / $counting_rate) * 100;
    $star_review[2] = ($star_review[2] / $counting_rate) * 100;
    $star_review[3] = ($star_review[3] / $counting_rate) * 100;
    $star_review[4] = ($star_review[4] / $counting_rate) * 100;
    $star_review[5] = ($star_review[5] / $counting_rate) * 100;
endif;

//Leerpad content -course
$off_line = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
$leerpad_content = get_field('road_path', $post->ID);
$videos = array();
$podcasts = array();
$artikel = array();
$offline = array();

foreach($leerpad_content as $course){
    $course_type = get_field('course_type', $course->ID);
    if(in_array($course_type, $off_line))
        array_push($offline, $course);
    else if($course_type == 'Video')
        array_push($videos, $course);
    else if($course_type == 'Podcast')
        array_push($podcasts, $course);
    else if($course_type == 'Artikel')
        array_push($artikel, $course);
}

/*  Informations reservation  */
//Orders - enrolled courses 
$args = array(
    'customer_id' => $user_id,
    'post_status' => array('wc-processing', 'wc-completed'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);
$enrolled_user = array();
foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        $course = get_post($course_id);
        if(!empty($course))
            array_push($enrolled_user, $course->ID);
    }
}

$post_id = $post->ID;
?>

<body>
<div class="content-new-Courses video-content-course content-course-podcast">
    <div class="container-fluid">
        <?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span>"?>
        <br><br>
        <div class="content-head-podcast">
           <div class="block-img">
                <img src="<?= $image; ?>" alt="">
           </div>
            <div class="block-detail-podcast">
                <h1><?= $post->post_title; ?></h1>
                <p class="description"><?= $short_description ?></p>
                <div class="d-flex flex-wrap">
                    <div class="d-flex">
                        <a href="/user-overview?id=<?= $post->post_author ?>" class="block-img-created-assessment">
                            <img src="<?= $author_picture ?>" alt="">
                        </a>
                        <div class="block-sub-detail">
                            <p class="category-text-title">Created by</p>
                            <a href="/user-overview?id=<<?= $post->post_author ?>" class="category-text"><?= $author_name ?></a>
                        </div>
                    </div>
                    <div class="block-sub-detail">
                        <p class="category-text-title">Categories</p>
                        <p class="category-text">Leerpad</p>
                    </div>
                    <div class="block-sub-detail">
                        <p class="category-text-title">Review</p>
                        <div class="d-flex align-items-center">
                            <div class="d-flex">
                                <?php
                                foreach(range(1,5) as $number):
                                    if($average_star >= $number ):
                                        echo '<i class="fa fa-star checked"></i>';
                                        continue;
                                    endif;
                                    echo '<i class="fa-regular fa-star"></i>';
                                endforeach;
                                ?>
                            </div>
                            <p class="category-text"><?= $average_star ?> (<?= $number_comments ?> reviews)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div id="tab-url1">
                        <ul class="nav">
                            <li class="nav-one"><a href="#Overview" >Overview</a></li>
                            <li class="nav-two"><a href="#Course" class="current">Course Content</a></li>
                            <li class="nav-four "><a href="#Reviews">Reviews</a></li>
                        </ul>
                        <div class="list-wrap">
                            <ul id="Overview" class="hide">
                                <div class="d-block">
                                    <div class="section-tabs section-tabs-learn" >
                                        <div class="block-description">
                                            <h2>Description</h2>
                                            <p class="text-tabs">
                                                <?= $long_description ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php
                                    if(!empty($posttags) || !empty($category_default) || !empty($category_default)):
                                    ?>
                                    <div class="section-tabs" >
                                        <h2>What You'll Learn</h2>
                                        <ul class="d-flex flex-wrap list what-you-learn">
                                            <?php
                                            if ($posttags)
                                                foreach($posttags as $tag)
                                                    echo  '<li>
                                                                <img src="' . get_stylesheet_directory_uri() . '/img/fa-check.svg" alt="">
                                                                <a href="/category-overview?category=' . $tag->ID . '" class="text-tabs">' . $tag->name . '</a>
                                                            </li>';  
                                            else{
                                                $read_category = array();
                                                if(!empty($category_default))
                                                    foreach($category_default as $item)
                                                        if($item)
                                                            if(!in_array($item,$read_category)){
                                                                array_push($read_category,$item);
                                                                echo  '<li>
                                                                            <img src="' . get_stylesheet_directory_uri() . '/img/fa-check.svg" alt="">
                                                                            <a href="/category-overview?category=' . $item['value'] . '" class="text-tabs">' . (String)get_the_category_by_ID($item['value']) . '</a>
                                                                        </li>';  
                                                            }

                                                else if(!empty($category_xml))
                                                    foreach($category_xml as $item)
                                                        if($item)
                                                            if(!in_array($item,$read_category)){
                                                                array_push($read_category,$item);
                                                                echo  '<li>
                                                                            <img src="' . get_stylesheet_directory_uri() . '/img/fa-check.svg" alt="">
                                                                            <a href="/category-overview?category=' . $item['value'] . '" class="text-tabs">' . (String)get_the_category_by_ID($item['value']) . '</a>
                                                                        </li>';                                      
                                                            }
                                            }
                                            ?>
                                        </ul>
                                    </div> 
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </ul>

                            <ul id="Course">
                                <div class="list-content-podcast">
                                    <div class="main-accordion">
                                        <ul class="list">
                                            <?php
                                            if(!empty($videos)):
                                            ?>
                                            <li>
                                                <button class="list-heading"><h2>Video</h2></button>
                                                <?php
                                                foreach($videos as $index => $post):
                                                    $genuine_videos = get_field('data_virtual', $post->ID);
                                                    $youtube_videos = get_field('youtube_videos', $post->ID);
                                                    $price = get_field('price', $post->ID) ?: 'Gratis';

                                                    if(!empty($genuine_videos) || !empty($youtube_videos)):
                                                        $statut_bool = 0;
                                                        if(in_array($post->ID, $enrolled_user))
                                                            $statut_bool = 1;

                                                        $bool_link = 0;
                                                        if(($price == 'Gratis'))
                                                            $bool_link = 1;
                                                        else
                                                            if($statut_bool)
                                                                $bool_link = 1;                                            
                                                        ?>
                                                        <div class="list-text">
                                                            <h3 class="name-course"><?= $post->post_title ?></h3>
                                                            <div class="content-playlist-course">
                                                                <div class="playlist-course-block">
                                                                <?php
                                                                if(!empty($genuine_videos) && !empty($youtube_videos) )
                                                                    echo '<div class="element-playlist-course">
                                                                            <div class="d-flex align-items-center group-element">
                                                                                <p class="lecture-text"> 0 <span>lesson founds</span></p>
                                                                                <p class="text-playlist-element">No lesson soon available</p>
                                                                            </div>
                                                                        </div>';
                                                                else if(!empty($genuine_videos))
                                                                    foreach($genuine_videos as $key => $video){
                                                                        $style = "";
                                                                        if(isset($lesson))
                                                                            if($lesson == $key)
                                                                                $style = "color:#F79403";
                        
                                                                        $link = '#';
                                                                        $status_icon = get_stylesheet_directory_uri() . "/img/blocked.svg";
                                                                        $read_status_icon = '<img class="playlistImg" src="' . get_stylesheet_directory_uri() . '/img/Instellingen.png" alt="">';
                                                                        if($bool_link || $key == 0){
                                                                            $link = get_permalink($post->ID) . '?topic=0&lesson=' . $key;
                                                                            $status_icon = get_stylesheet_directory_uri() . "/img/view-course.svg";
                                                                            $read_status_icon = '<img class="playlistImg" src="' . get_stylesheet_directory_uri() . '/img/light_play.svg" alt="">';
                                                                        }
                        
                                                                        $lecture_index = $key + 1;
                                                                        echo 
                                                                            '<div class="element-playlist-course">
                                                                                <div class="d-flex align-items-center group-element">'
                                                                                    .  $read_status_icon . '
                                                                                    <p class="lecture-text"> Lecture <span>' . $lecture_index . ' </span></p>
                                                                                    <a href="' . $link . '" target="_blank" class class="text-playlist-element ' . $style . '">' . $video['course_lesson_title'] . '</a>
                                                                                </div>
                                                                                <img class="status-icon" src="' . $status_icon . '" alt="">
                                                                            </div>';

                                                                        if($lecture_index == 6)
                                                                            break;
                                                                    }
                                                                else if(!empty($youtube_videos))
                                                                    foreach($youtube_videos as $key => $video){
                                                                        $style = "";
                                                                        if(isset($lesson))
                                                                            if($lesson == $key)
                                                                                $style = "color:#F79403";

                                                                        $link = get_permalink($post->ID) . '?topic=0&lesson=' . $key;
                                                                        $status_icon = get_stylesheet_directory_uri() . "/img/view-course.svg";

                                                                        $lecture_index = $key + 1;
                                                                        echo 
                                                                            '<div class="element-playlist-course">
                                                                                <div class="d-flex align-items-center group-element">
                                                                                    <img class="playlistImg" src="' . get_stylesheet_directory_uri() . '/img/light_play.svg" alt="">
                                                                                    <p class="lecture-text"> Lecture <span>' . $lecture_index . ' </span></p>
                                                                                    <a href="' . $link . '" target="_blank" class="text-playlist-element ' . $style . '">' . $video['title'] . '</a>
                                                                                </div>
                                                                                <img class="status-icon" src="' . get_stylesheet_directory_uri() . '/img/view-course.svg" alt="">
                                                                            </div>';
                                                                        
                                                                        if($lecture_index == 6)
                                                                            break;
                                                                    }    
                                                                ?>
                                                                <a href="<?= get_permalink($post->ID) ?>" class="btn btn-load-more">
                                                                    Show More
                                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/load-more.svg" alt="">
                                                                </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    endif;
                                                    if($index == 3)
                                                        break;      
                                                endforeach;
                                                ?>
                                            </li>
                                            <?php
                                            endif;
                                            if(!empty($podcasts)):
                                            ?>
                                            <li>
                                                <button class="list-heading"><h2>Podcast</h2></button>
                                                <?php
                                                foreach($podcasts as $index => $post):
                                                    $genuine_podcasts = get_field('podcasts', $post->ID);
                                                    $index_podcasts = get_field('podcast_index', $post->ID);
                                                    $price = get_field('price', $post->ID) ?: 'Gratis';

                                                    if(!empty($genuine_podcasts) || !empty($index_podcasts)):
                                                        $statut_bool = 0;
                                                        if(in_array($post->ID, $enrolled_user))
                                                            $statut_bool = 1;

                                                        $bool_link = 0;
                                                        if(($price == 'Gratis'))
                                                            $bool_link = 1;
                                                        else
                                                            if($statut_bool)
                                                                $bool_link = 1;  

                                                        $lecture_index = 0;            
                                                        ?>
                                                        <div class="list-text">
                                                            <h3 class="name-course"><?= $post->post_title ?></h3>
                                                            <div class="list-content-podcast">
                                                            <?php 

                                                                if(!empty($genuine_podcasts)):
                                                                    foreach($genuine_podcasts as $key => $podcast) {
                                                                        $style = "";
                                                                        if(isset($lesson))
                                                                            if($lesson == $key)
                                                                                $style = "color:#F79403";

                                                                        $link = '#';
                                                                        $reading = "#";
                                                                        $status_icon = get_stylesheet_directory_uri() . "/img/blocked.svg";
                                                                        $read_status_icon = '';
                                                                        if($bool_link || $key == 0){
                                                                            $reading = $podcast['course_podcast_data'];
                                                                            $status_icon = get_stylesheet_directory_uri() . "/img/view-course.svg";
                                                                            $read_status_icon = '<div class="cp-audioquote__player--playBtn"></div>';
                                                                        }

                                                                        $lecture_index = $key + 1;
                                                                        ?>
                                                                        <div class="elemnt-list-podcast">
                                                                            <p class="number-list"><?= $lecture_index ?></p>
                                                                            <div class="detail-block-podcast">
                                                                                <p class="title-podcast"><?= $podcast['course_podcast_title'] ?></p>
                                                                                <div class="audio">
                                                                                    <div class="cp-audioquote">
                                                                                        <div class="cp-audioquote__player">
                                                                                            <!-- src -->
                                                                                            <audio class="cp-audioquote__player__src" src="<?= $reading ?>">
                                                                                                <p><?= $podcast['course_podcast_intro'] ?></p>
                                                                                            </audio>
                                                                                            <?= $read_status_icon ?>
                                                                                            <div class="cp-audioquote__player--display">
                                                                                                <div class="cp-audioquote__player--progress">
                                                                                                    <span class="cp-audioquote__player--track"></span>
                                                                                                    <span class="cp-audioquote__player--playhead"></span>
                                                                                                </div>
                                                                                                <p class="cp-audioquote__player--timestamp playhead">0:00</p><p class="cp-audioquote__player--timestamp duration">0:00</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <img class="status-icon" src="<?= $status_icon ?>" alt="">
                                                                        </div>
                                                                    <?php 
                                                                    }
                                                                elseif(!empty($index_podcasts)):
                                                                    foreach($index_podcasts as $key => $podcast) {
                                                                        $style = "";
                                                                        if(isset($lesson))
                                                                            if($lesson == $key)
                                                                                $style = "color:#F79403";
                                    
                                                                        $link = '#';
                                                                        $reading = "#";
                                                                        $status_icon = get_stylesheet_directory_uri() . "/img/blocked.svg";
                                                                        if($bool_link || $key == 0){
                                                                            $reading = $podcast['podcast_url'];
                                                                            $status_icon = get_stylesheet_directory_uri() . "/img/view-course.svg";
                                                                        }
                                    
                                                                        $lecture_index = $key + 1;
                                                                        ?>
                                                                        <div class="elemnt-list-podcast">
                                                                            <p class="number-list"><?= $lecture_index ?></p>
                                                                            <div class="detail-block-podcast">
                                                                                <p class="title-podcast"><?= $podcast['podcast_title'] ?></p>
                                                                                <div class="audio">
                                                                                    <div class="cp-audioquote">
                                                                                        <div class="cp-audioquote__player">
                                                                                            <!-- src -->
                                                                                            <audio class="cp-audioquote__player__src" src="<?= $reading ?>">
                                                                                                <p><?= $podcast['podcast_description'] ?></p>
                                                                                            </audio>
                                                                                            <div class="cp-audioquote__player--playBtn"></div>
                                                                                            <div class="cp-audioquote__player--display">
                                                                                                <div class="cp-audioquote__player--progress">
                                                                                                    <span class="cp-audioquote__player--track"></span>
                                                                                                    <span class="cp-audioquote__player--playhead"></span>
                                                                                                </div>
                                                                                                <p class="cp-audioquote__player--timestamp playhead">0:00</p><p class="cp-audioquote__player--timestamp duration">0:00</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <img class="status-icon" src="<?= $status_icon ?>" alt="">
                                                                        </div>
                                                                    <?php 
                                                                    }
                                                                endif;
                                                                ?>
                                                                <a href="<?= get_permalink($post->ID) ?>" class="btn btn-load-more">
                                                                    Show More
                                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/load-more.svg" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    endif;
                                                    if($index == 3)
                                                        break;     
                                                endforeach;
                                                ?>
                                            </li>
                                            <?php
                                            endif;
                                            if(!empty($offline)):
                                            ?>
                                            <li>
                                                <button class="list-heading"><h2>Opleinding</h2></button>
                                                <?php
                                                foreach($offline as $index => $post):
                                                $description = get_field('short_description', $post->ID) ?: 'No description found for this course';
                                                $description = (!$description) ? get_field('long_description', $post->ID) : 'No description found for this course';
                                                ?>
                                                <div class="list-text">
                                                    <h3 class="name-course"><?= $post->post_title ?></h3>
                                                    <div class="block-description">
                                                        <p class="text-tabs"><?= $description ?></p>
                                                        <a href="<?= get_permalink($post->ID) ?>" class="btn btn-load-more">
                                                            Show More
                                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/load-more.svg" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                                if($index == 3)
                                                    break;     
                                                endforeach;
                                            ?>
                                            </li>
                                            <?php
                                            endif;
                                            if(!empty($artikel)):
                                            ?>
                                            <li>
                                                <button class="list-heading"><h2>Artikel</h2></button>
                                                <?php
                                                foreach($artikel as $index => $post):
                                                $content_artikel = get_field('article_itself',  $post->ID) ?: 'No content found for this artikel';
                                                ?>
                                                <div class="list-text">
                                                    <h3 class="name-course"><?= $post->post_title ?></h3>
                                                    <div class="block-description">
                                                        <p class="text-tabs">
                                                            <?= $content_artikel ?>
                                                        </p>
                                                        <a href="<?= get_permalink($post->ID) ?>" class="btn btn-load-more">
                                                            Show More
                                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/load-more.svg" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                                if($index == 3)
                                                    break;     
                                                endforeach;
                                            endif;
                                            ?>
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </ul>

                            <ul id="Reviews" class="hide">
                                <div class="section-tabs" >
                                    <div class="d-flex justify-content-between flex-wrap block-review-course">
                                        <div class="block-note-review">
                                            <p class="note-text"><?= $average_star_format ?></p>
                                            <div class="rating-bying-course">
                                                <div class="rating-element2">
                                                    <div class="rating">
                                                        <?php 
                                                        foreach(range(5, 1) as $number):
                                                            if($average_star == $number ):
                                                                echo '<input type="radio" id="star' . $number . '-note" class="stars" checked name="rating-note" value="' . $number . '" />
                                                                      <label class="star" for="star' . $number . '-note" class="stars" title="" aria-hidden="true"></label>';                      
                                                                continue;
                                                            endif;

                                                            echo '<input type="radio" id="star' . $number . '-note" class="stars" name="rating-note" value="' . $number . '" />
                                                                  <label class="star" for="star' . $number . '-note" title="" aria-hidden="true"></label>';                      

                                                        endforeach;
                                                        ?>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                            </div>
                                            <p class="note-description">Course Rating</p>
                                        </div>
                                        <div class="barNote">
                                            <div class="skillbars">
                                                <div class="progress" data-fill="<?= $star_review[5] ?>" >
                                                </div>
                                                <div class="bg-gris-Skills"></div>
                                            </div>
                                            <div class="skillbars">
                                                <div class="progress" data-fill="<?= $star_review[4] ?>" >
                                                </div>
                                                <div class="bg-gris-Skills"></div>
                                            </div>
                                            <div class="skillbars">
                                                <div class="progress" data-fill="<?= $star_review[3] ?>" >
                                                </div>
                                                <div class="bg-gris-Skills"></div>
                                            </div>
                                            <div class="skillbars">
                                                <div class="progress" data-fill="<?= $star_review[2] ?>" >
                                                </div>
                                                <div class="bg-gris-Skills"></div>
                                            </div>
                                            <div class="skillbars">
                                                <div class="progress" data-fill="<?= $star_review[1] ?>" >
                                                </div>
                                                <div class="bg-gris-Skills"></div>
                                            </div>
                                        </div>
                                        <div class="block-rating-note">
                                            <div class="element-block-rating">
                                                <div class="rating-element2">
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
                                                <p class="note-global-rating"><?= $star_review[5] ?> %</p>
                                            </div>
                                            <div class="element-block-rating">
                                                <div class="rating-element2">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Very-good" class="stars disabled" disabled name="rating-Very-good" value="5" />
                                                        <label class="star" for="star5-Very-good" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Very-good" class="stars" checked name="rating-Very-good" value="4" />
                                                        <label class="star" for="star4-Very-good" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Very-good" class="stars" name="rating-Very-good" value="3" />
                                                        <label class="star" for="star3-Very-good" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Very-good" class="stars" name="rating-Very-good" value="2" />
                                                        <label class="star" for="star2-Very-good" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Very-good" name="rating-Very-good" value="1" />
                                                        <label class="star" for="star1-Very-good" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                                <p class="note-global-rating"><?= $star_review[4] ?> %</p>
                                            </div>
                                            <div class="element-block-rating">
                                                <div class="rating-element2">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-Good" class="stars" name="rating-Good" value="5" />
                                                        <label class="star" for="star5-Good" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-Good" class="stars disabled" disabled  name="rating-Good" value="4" />
                                                        <label class="star" for="star4-Good" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-Good" class="stars" checked name="rating-Good" value="3" />
                                                        <label class="star" for="star3-Good" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-Good" class="stars" name="rating-Good" value="2" />
                                                        <label class="star" for="star2-Good" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-Good" name="rating-Good" value="1" />
                                                        <label class="star" for="star1-Good" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                                <p class="note-global-rating"><?= $star_review[3] ?> %</p>
                                            </div>
                                            <div class="element-block-rating">
                                                <div class="rating-element2">
                                                    <div class="rating">
                                                        <input type="radio" id="star5-stars" class="stars" name="rating-stars" value="5" />
                                                        <label class="star" for="star5-stars" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="star4-stars" class="stars"  name="rating-stars" value="4" />
                                                        <label class="star" for="star4-stars" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="star3-stars" class="stars disabled" disabled name="rating-stars" value="3" />
                                                        <label class="star" for="star3-stars" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="star2-stars" class="stars-stars" checked name="rating" value="2" />
                                                        <label class="star" for="star2-stars" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="star1-stars" name="rating-stars" value="1" />
                                                        <label class="star" for="star1-stars" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                                <p class="note-global-rating"><?= $star_review[2] ?> %</p>
                                            </div>
                                            <div class="element-block-rating">
                                                <div class="rating-element2">
                                                    <div class="rating">
                                                        <input type="radio" id="5bad" class="stars" name="rating-bad" value="5" />
                                                        <label class="star" for="5bad" title="Awesome" aria-hidden="true"></label>
                                                        <input type="radio" id="4bad" class="stars"  name="rating-bad" value="4" />
                                                        <label class="star" for="4bad" title="Great" aria-hidden="true"></label>
                                                        <input type="radio" id="3bad" class="stars" name="rating-bad" value="3" />
                                                        <label class="star" for="3bad" title="Very good" aria-hidden="true"></label>
                                                        <input type="radio" id="2bad" class="stars disabled" disabled name="rating-bad" value="2" />
                                                        <label class="star" for="2bad" title="Good" aria-hidden="true"></label>
                                                        <input type="radio" id="1bad" name="rating-bad" checked value="1" />
                                                        <label class="star" for="1bad" class="stars" title="Bad" aria-hidden="true"></label>
                                                    </div>
                                                    <span class="rating-counter"></span>
                                                </div>
                                                <p class="note-global-rating"><?= $star_review[1] ?> %</p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if(!empty($reviews))
                                        foreach($reviews as $review):
                                            $user = $review['user'];
                                            $author_name = ($user->last_name) ? $user->first_name . ' ' . $user->last_name : $user->display_name; 
                                            $image_author = get_field('profile_img',  'user_' . $user->ID);
                                            $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
                                            $company = get_field('company',  'user_' . $user->ID);
                                            $title = $company[0]->post_title;
                                            $rating = $review['rating'];
                                            echo '
                                            <div class="user-comment-block">
                                                <div class="d-flex">
                                                    <div class="img-block">
                                                        <img src="' . $image_author . '" alt="">
                                                    </div>
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <p class="name-autors-comment">' . $author_name . '</p> ' . //<p class="timing-comment">3 days ago </p>
                                                        '</div>
                                                        <p class="title-comment">' . $title . '</p>
                                                    </div>
                                                </div>
                                                <p class="text-tabs">' . $review['feedback'] . '</p>
                                            </div>';
                                        endforeach;

                                        if(!$my_review_bool && $user_id):
                                        ?>
                                        <div class="comment-block">
                                            <h2>Write a Review</h2>
                                            <form action="/dashboard/user" method="POST" id="review_vid"> 
                                                <input type="hidden" name="course_id" value="<?= $post_id; ?>" >
                                            </form>
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5-review" class="stars" name="rating" value="5" form="review_vid"/>
                                                    <label class="star" for="star5-review" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-review" class="stars" name="rating" value="4" form="review_vid"/>
                                                    <label class="star" for="star4-review" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-review" class="stars" name="rating" value="3" form="review_vid"/>
                                                    <label class="star" for="star3-review" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-review" class="stars" name="rating" value="2" form="review_vid"/>
                                                    <label class="star" for="star2-review" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-review" name="rating" value="1" form="review_vid"/>
                                                    <label class="star" for="star1-review" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                            <textarea name="feedback_content" id="feedback" rows="10" form="review_vid" required></textarea>
                                            <div class="position-relative">
                                                <?php if ($user_id==0) : ?>
                                                    <button type="button" class='btn btn-send' data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal'>Send</button>
                                                <?php else : ?>
                                                    <button type="submit" class='btn btn-send' id='btn_review' name='review_post' form="review_vid">Send</button>
                                                <?php endif; ?>
                                            </div>
                                            </form>
                                        </div>
                                        <?php
                                        endif;
                                        ?>
                                </div>
                            </ul>

                        </div> <!-- END List Wrap -->

                    </div>
                    <div>
                        <h2>Expert</h2>
                        <div class="owl-carousel owl-theme owl-carousel-card-course">
                            <?php
                            foreach($experts as $value):
                                if(!$value) 
                                    continue;

                                $expert = get_user_by('id', $value);
                                $expert_name = ($expert->last_name) ? $expert->first_name . ' ' . $expert->last_name : $expert->display_name; 
                                $image = get_field('profile_img',  'user_' . $expert->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                                $company = get_field('company',  'user_' . $expert->ID);
                                $title = $company[0]->post_title;
                                ?>
                                <a href="/user-overview?id=<?= $post->post_author ?>" class="card-expert">
                                    <div class="head">
                                        <img src="<?= $image ?>" alt="">
                                    </div>
                                    <p class="name-expert"><?= $expert_name ?></p>
                                    <p class="poste-expert"><?= $title ?></p>
                                </a>    
                                
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-block-detail-course">
                        <div class="card-detail-course">
                            <p class="title-course">Course Includes</p>
                            <ul>
                                <li>
                                    <p class="name-element-detail">Price:</p>
                                    <p class="detail priceCourse"><?= $price ?></p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Instructor:</p>
                                    <p class="detail"><?= $author_name ?></p>
                                </li>
                                <!-- 
                                <li>
                                    <p class="name-element-detail">Duration::</p>
                                    <p class="detail">3 weeks</p>
                                </li> 
                                <li>
                                    <p class="name-element-detail">Lessons:</p>
                                    <p class="detail">18</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Enrolled</p>
                                    <p class="detail">0</p>
                                </li>
                                -->
                                <?php
                                if($language)
                                echo '<li>
                                        <p class="name-element-detail">Language:</p>
                                        <p class="detail">' . $language .'</p>
                                      </li>';
                                ?>
                                <li>
                                    <p class="name-element-detail">Certificate:</p>
                                    <p class="detail">No</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Access:</p>
                                    <p class="detail">Fulltime</p>
                                </li>
                                <!-- 
                                <div class="d-block">
                                    <a href="" class="btn btn-stratNow">Start Now</a>
                                    <a href="" class="btn btn-buy-now">Buy Now</a>
                                </div> 
                                -->
                                <div class="sharing-element">
                                    <?php
                                    $subject = $post->post_title;
                                    $permalink = get_permalink($post->ID);

                                    $linkedin_share = "https://www.linkedin.com/sharing/share-offsite/?url=" . $permalink;
                                    $mail_share = 'mailto:?subject=' . $subject . '&body=' . $permalink;
                                    ?>
                                    <p>Share On:</p>
                                    <div class="d-flex flex-wrap">
                                        <a target="_blank" href="<?= $linkedin_share ?>">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        <a target="_blank" href="<?= $mail_share ?>">
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if(!empty($recent_leerpads)):
            ?>
            <div class="similar-course-block">
                <h2>Similar Course</h2>
                <div class="owl-carousel similarCourseCarousel owl-theme owl-carousel-card-course">
                    <?php
                    foreach($recent_leerpads as $course):
                        //Location
                        $location = 'Online';

                        //Price
                        $price_noformat = " ";
                        $price_noformat = get_field('price', $course->ID);
                        if($price_noformat != "0")
                            $price = '€' . number_format($price_noformat, 2, '.', ',');
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
                        $author_image = get_field('profile_img',  'user_' . $course->post_author);
                        $author_image = $author_image ? $author_image : get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                        //Course Type
                        $course_type = get_field('course_type', $course->ID);
                        
                        echo 
                        '<a href="' . get_permalink($course->ID) . '" class="new-card-course">
                            <div class="head">
                                <img src="' . $thumbnail . '" alt="">
                            </div>
                            <div class="title-favorite d-flex justify-content-between align-items-center">
                                <p class="title-course">' . $course->post_title . '</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                <div class="blockOpein d-flex align-items-center">
                                    <i class="fas fa-graduation-cap"></i>
                                    <p class="lieuAm">' . $course_type . '</p>
                                </div>
                                <div class="blockOpein">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p class="lieuAm">'. $location .'</p>
                                </div>
                            </div>
                            <div class="autor-price-block d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="blockImgUser">
                                        <img src="'. $author_image .'" alt="">
                                    </div>
                                    <p class="autor">'. $author_name .'</p>
                                </div>
                                <p class="price">'. $price .'</p>
                            </div>
                        </a>';
                    endforeach;
                    ?>
                </div>
            </div>
            <?php
            endif;
            ?>
        </div>


    </div>
</div>


<script>
    var sections = $('.section-tabs')
        , nav = $('.content-tabs-scroll')
        , nav_height = nav.outerHeight();

    $(window).on('scroll', function () {
        var cur_pos = $(this).scrollTop();

        sections.each(function() {
            var top = $(this).offset().top - nav_height,
                bottom = top + $(this).outerHeight();

            if (cur_pos >= top && cur_pos <= bottom) {
                nav.find('a').removeClass('active');
                sections.removeClass('active');

                $(this).addClass('active');
                nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
            }
        });
    });
    nav.find('a').on('click', function () {
        var $el = $(this)
            , id = $el.attr('href');

        $('html, body').animate({
            scrollTop: $(id).offset().top - nav_height
        }, 500);

        return false;
    });
</script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/organictabs.jquery.js"></script>
<script>
    $(function() {

        // Calling the plugin
        $("#tab-url1").organicTabs();

    });
</script>

<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.lazyload.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>

<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:13,
        items:3.5,
        lazyLoad:true,
        dots:false,
        responsiveClass:true,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1.7,
                nav:true
            },
            600:{
                items:2.2,
                nav:false
            },
            1000:{
                items:3.5,
                nav:true,
                loop:false
            }
        }
    })
</script>


<script>
    $('.similarCourseCarousel').owlCarousel({
        loop:true,
        margin:13,
        items:3.5,
        dots:false,
        lazyLoad:true,
        responsiveClass:true,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1.1,
                nav:true
            },
            600:{
                items:1.1,
                nav:false
            },
            1000:{
                items:3.5,
                nav:true,
                loop:false
            }
        }
    })
</script>


<script>
    class ProgressBar{
        constructor(progressBar, fill, skillName){
            this.progressBar = progressBar;
            this.skillName = skillName
            this.fill = fill;
            this.speed = 15; //Speed of the fill, increasing it will slow down
            this.actual = 0;
            this.filling();
        }
        filling(){
            if( this.actual < this.fill){
                this.progressBar.style.width = String(this.actual++)+"%";
                this.progressBar.innerHTML = this.skillName+String(this.actual)+"%";
                setTimeout(() => this.filling(), this.speed);
            }
            else{
                return;
            }
            return;
        }
    }

    let options = {
        threshold: 0 // value from 0 to 1.0, stablishes the porcentage of the bar that need to be displayed before launching the animation
    }

    var progressBars = document.querySelectorAll('.progress');
    let observer = new IntersectionObserver((progressBars) => {
        progressBars.forEach( progressBar => {
            if(progressBar.isIntersecting ){
                let fill = progressBar.target.getAttribute('data-fill');
                let skillName = progressBar.target.innerHTML;
                new ProgressBar(progressBar.target, fill, skillName);
                observer.unobserve(progressBar.target);
            }
        });

    }, options);

    progressBars.forEach( progressBar => observer.observe(progressBar));

</script>

<!--for audio block-->
<script>
    $('.cp-audioquote').each(function(e){

        const $this = $(this);
        const $togglePlay = $this.find('.cp-audioquote__player--playBtn');
        const player = $this.find('audio').get(0);
        const progressBar = $this.find('.cp-audioquote__player--playhead');

        $togglePlay.on('click', function(){
            if(player.paused){
                player.play();
                $this.find('.cp-audioquote__player').addClass('is-playing');
            } else {
                player.pause();
                $this.find('.cp-audioquote__player').removeClass('is-playing');
            }
        });

        // when the audio finish, reset all
        player.addEventListener("ended", function() {
            $('.cp-audioquote__player').removeClass('is-playing');
            // reset to zero the progress
            progressBar.css('width', '0%');
            // time at zero
            player.currentTime = 0;
        }, true);

        // set total duration of the video
        player.addEventListener('canplaythrough', function(){
            // insert total duration into the page
            const totalLength = calculateTotalValue(player.duration);
            $this.find('.duration').html(totalLength);
        }, false);


        // calculate total length of the audio
        function calculateTotalValue(length) {
            const minutes = Math.floor(length / 60);
            const seconds_int = length - minutes * 60;
            if(seconds_int < 10){
                seconds_int = "0"+seconds_int;
            }
            const seconds_str = seconds_int.toString();
            const seconds = seconds_str.substr(0, 2);
            const time = minutes + ':' + seconds;
            return time;
        }

        // Update the progress bar
        function updateProgressBar() {
            // Work out how much of the media has played via the duration and currentTime parameters
            const percentage = Math.floor((100 / player.duration) * player.currentTime);
            // Update the progress bar's value
            progressBar.css('width', percentage+'%');
            // Update the progress bar's text
            const currentTime = calculateCurrentValue(player.currentTime);
            $this.find(".playhead").html(currentTime);
        }

        function calculateCurrentValue(currentTime) {
            let current_hour = parseInt(currentTime / 3600) % 24,
                current_minute = parseInt(currentTime / 60) % 60,
                current_seconds_long = currentTime % 60,
                current_seconds = current_seconds_long.toFixed(),
                current_time = (current_minute < 10 ? "" + current_minute : current_minute) + ":" + (current_seconds < 10 ? "0" + current_seconds : current_seconds);
            return current_time;
        }

        // Add a listener for the timeupdate event so we can update the progress bar
        player.addEventListener('timeupdate', updateProgressBar, false);


        $this.find('.cp-audioquote__player--track').on('click', function(e){
            if (player.src) {
                const percent = e.offsetX / this.offsetWidth;
                player.currentTime = percent * player.duration;
                // update progress bar
                progressBar.css('width', Math.floor(percent / 100)+'%');
            }
        });

    });
</script>

<script>
    /** code by webdevtrick ( https://webdevtrick.com ) **/
    $(function() {
        $('.list-heading').on('click', function(e) {
            e.preventDefault();
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).next()
                    .stop()
                    .slideUp(300);
            } else {
                $(this).addClass('active');
                $(this).next()
                    .stop()
                    .slideDown(300);
            }
        });
    });
</script>


<?php get_footer(); ?>
<?php wp_footer(); ?>

</body>