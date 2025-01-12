<?php /** Template Name: Expert overview */ ?>

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

//Get ID Expert
$expert_input_id = ($_GET['id']) ?: 0;
$expert_input = get_user_by('ID', $expert_input_id);

$no_content =  '
                <p class="dePaterneText theme-card-description"> 
                <span style="color:#033256"> This expert not found ❗️</span> 
                </p>
                ';
if(!$expert_input):
    echo $no_content;
    die();
endif;

//Track view
view_user($expert_input->ID);

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

// Category post 
$courses = searching_course_by_group($global_posts, 'expert', $expert_input_id)['courses'];
// $order_type = searching_course_by_group($global_posts, 'expert', $expert_input_id)['order_type'];
$expertise = searching_course_by_group($global_posts, 'expert', $expert_input_id)['experts'];

//Experts followed
$experts_followed = get_user_meta($user_id, 'expert');

//Topics
$topics = get_user_meta($expert_input_id, 'topic');
$skills_note = get_field('skills', 'user_' . $expert_input_id);

// Expert information //
// $genuine_category = get_categories(array('taxonomy' => 'course_category', 'orderby' => 'name', 'hide_empty' => 0, 'include' => (int)$category_input) )[0];
// if(is_wp_error($name) || is_wp_error($genuine_category))
//     header('Location: /');
$name = ($expertie->last_name) ? $expert_input->first_name : $expert_input->display_name;
$image_expert = get_field('profile_img',  'user_' . $expert_input->ID);
$image_expert = $image_expert ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
$company_expert = get_field('company',  'user_' . $expert_input->ID);
// $company_id = isset($company[0]->ID) ? $company[0]->ID : [0];
$company_name = isset($company_expert[0]->post_title) ? $company_expert[0]->post_title : 'None';

//Portfolio
$experiences = get_field('work',  'user_' . $expert_input_id);
$default_content_bio = "This paragraph is dedicated to expressing skills what I have been able to acquire during professional experience.<br> 
                        Outside of let'say all the information that could be deemed relevant to a allow me to be known through my cursus.";
$biographical_info = get_field('biographical_info', 'user_' . $expert_input_id) ?: $default_content_bio;
$country = get_field('country',  'user_' . $expert_input_id) ?: 'Netherlands';
$phone = get_field('telnr',  'user_' . $expert_input_id) ?: '(xxx) xxxx xx';
$email = $expert_input->user_email;

//Reviews
$reviews = get_field('user_reviews', 'user_' . $expert_input_id);
$count_reviews = (!empty($reviews)) ? count($reviews) : 0;
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

    if($review['rating']):
        $average_star += intval($review['rating']); 
        $counting_rate += 1;
    endif;

endforeach;
$average_star_nor = ($counting_rate > 0 ) ? $average_star / $counting_rate : 0;
$average_star_nor_format = intval($average_star_nor);

// var_dump($reviews);
// die();

$count_courses = (!empty($courses)) ? count($courses) : 0;

?>


<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">

        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?= $image_expert ?>" class="img-head-about" alt="">
                <h1 class="wordDeBestText2"><?= $name ?></h1>
                <h2 class="name-company"><?= $company_name ?></h2>
                <form action="../dashboard/user/" method="POST">
                    <input type='hidden' name='filter_args' value='1'>
                    <input type="hidden" name="expert" value="1" id="">
                    <input type="hidden" name="meta_value" value="<?= $expert_input_id ?>" id="">
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

                    if($user_id)
                        if (in_array($expert_input_id, $experts_followed)):
                            echo '<input type="hidden" name="meta_key" value="expert" id="">';
                            echo $unfollow;
                        else:
                            echo '<input type="hidden" name="meta_key" value="expert" id="">';
                            echo $follow;
                        endif;
                    ?>
                </form>
             </div>
    </section>
    <section class="content-product-search content-company-overview">
        <div class="theme-content">
            <div class="theme-learning">
                <div class="">
                    <div id="tab-url1" class="group-tab-element">
                        <ul class="nav">
                            <li class="nav-one"><a href="#Overview" class="current">Overview</a></li>
                            <li class="nav-two"><a href="#Courses" class="load_content_type">Courses</a></li>
                            <li class="nav-three"><a href="#Skills" class="load_content_type">Skills</a></li>
                            <li class="nav-four "><a href="#Reviews" class="load_content_type">Reviews</a></li>
                        </ul>

                        <div class="list-wrap">
                            <ul id="Overview">
                                <div class="card-overview-profil">
                                    <p class="title-overview-profil">About</p>
                                    <p class="description-overview-profil"><?= $biographical_info ?></p>
                                    <div class="d-flex group-other-info flex-wrap">
                                        <div class="d-flex element-content-other-info">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_baseline-phone.svg" alt="">
                                            <p><?= $phone ?></p>
                                        </div>
                                        <div class="d-flex element-content-other-info">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_baseline-email.svg" alt="">
                                            <p><?= $email ?></p>
                                        </div>
                                        <div class="d-flex element-content-other-info">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/bxs_map.svg" alt="">
                                            <p><?= $country ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if(!empty($experiences)):
                                ?>
                                <div class="card-overview-profil card-overview-experience">
                                    <p class="title-overview-profil">Experience</p>
                                    <?php
                                    foreach($experiences as $expo):
                                        $value = explode(";", $expo);
                                        $year_start = explode("-", $value[2])[0];
                                        $year_end = explode("-", $value[3])[0];
                                        if($year_start && !$year_end)
                                            $year = $year_start;
                                        else if($year_end && !$year_start)
                                            $year = $year_end;
                                        else if($year_end != $year_start)
                                            $year = $year_start .'-'. $year_end;
                                        ?>
                                        <div class="d-flex mb-4">
                                            <img class="icon-work-experience" src="<?php echo get_stylesheet_directory_uri(); ?>/img/experience-icon.svg" alt="">
                                            <div class="block-infos-experience">
                                                <p class="name-profession"><?= $value[0]; ?></p>
                                                <p class="name-company"><?= $value[1]; ?> - <span>(<?= $year ?>)</span></p>
                                                <p class="description"><?php echo $value[4]?: '' ?></p>
                                            </div>
                                        </div>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <?php
                                endif;
                                ?>
                            </ul>

                            <ul id="Courses" class="hide">
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
                                </form> 
                                <div class="block-filter-mobile">
                                    <button class="content-filter d-flex ">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/filter.png" alt="">
                                        <span>show left bar</span>
                                    </button>
                                </div>
                                -->
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
                            </ul>

                            <?php
                            if(!empty($topics)):
                            ?>
                            <ul id="Skills" class="hide">
                                <div class="content-card-skills content-card-skills-profil">
                                    <?php
                                    foreach($topics as $value):
                                        $topic = get_the_category_by_ID($value);
                                        $note = 0;
                                        if(!$topic)
                                            continue;
                                        if(!empty($skills_note))
                                            foreach($skills_note as $skill)
                                                if($skill['id'] == $value)
                                                    $note = $skill['note'];
                                        $name_topic = (String)$topic;
                                        echo '
                                            <div class="card-skills">
                                                <div class="group position-relative">
                                                    <span class="donut-chart has-big-cente">'. $note .'</span>
                                                </div>
                                                <p class="name-course">'. $name_topic .'</p>
                                            </div>';
                                    endforeach;
                                    ?>
                                </div>
                            </ul>
                            <?php
                            endif;
                            ?>
                            <ul id="Reviews" class="hide">
                                <?php
                                if(!empty($reviews)):
                                ?>
                                <div class="card-overview-profil">
                                    <p class="title-overview-profil">Review</p>
                                    <?php
                                    foreach($reviews as $review):
                                        $user = $review['user'];
                                        $image_author = get_field('profile_img',  'user_' . $user->ID);
                                        $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
                                        $rating = $review['rating'];
                                        $functie = get_field('role', 'user_' . $user->ID) ?: 'Hard worker';
                                    ?>
                                        <div class="review-info-card">
                                            <div class="review-user-mini-profile">
                                                <div class="user-photo">
                                                    <img class="" src="<?= $image_author ?>" alt="">
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="block-infos">
                                                        <p class="user-name"><?= $user->display_name ?></p>
                                                        <p class="profession-profil"><?= $functie ?></p>
                                                    </div>
                                                    <div class="rating-element">
                                                        <div class="rating">
                                                            <?php
                                                            for($i = $rating; $i >= 1; $i--){
                                                                if($i == $rating)
                                                                    echo '<input type="radio" name="rating" value="' . $i . ' " checked disabled/>
                                                                    <label class="star" title="" aria-hidden="true"></label>';
                                                                else
                                                                    echo '<input type="radio" name="rating" value="' . $i . ' " disabled/>
                                                                        <label class="star" title="" aria-hidden="true"></label>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="reviewsText"><?= $review['feedback']; ?></p>
                                        </div>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <?php
                                endif;
                                if($user_id )
                                if(!$my_review_bool):
                                ?>
                                <div class="card-overview-profil">
                                    <p class="title-overview-profil">Add Review</p><br><br><br>
                                    <form action="/dashboard/user/" method="POST">
                                        <input type="hidden" name="expert_id" value="<?= $expert_input_id ?>">
                                        <!-- <div class="form-group">
                                            <input type="text" class="form-control"  placeholder="Subject">
                                        </div> -->
                                        <div class="form-group position-relative">
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5" class="stars" name="rating" value="5" />
                                                    <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                                    <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                                    <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                                    <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1" name="rating" value="1" />
                                                    <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Feedback</label>
                                            <textarea name="feedback_content" id="feedback" rows="10"></textarea>
                                        </div>

                                        <button type="submit" name="review_expert" class="btn btn-submit">Submit</button>
                                    </form>
                                </div>
                                <?php
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="theme-side-menu">
                <div class="block-filter">
                    <button class="btn btn-close-filter">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Close.png" class="img-head-about" alt="">
                    </button>
                    <p class="text-filter-course">Infos</p>
                    <?php
                    if(!empty($topics)):
                    ?>
                    <div class="sub-section">
                        <p class="description-sub-section">Topics</p>
                        <div class="d-flex flex-wrap">
                            <?php
                            foreach($topics as $key => $value):
                                if($key == 6)
                                    break;
                                $topic = get_the_category_by_ID($value);
                                echo '<p class="topic-element">'.$topic.'</p>';
                            endforeach;
                            ?>
                        </div>
                    </div>
                    <?php
                    endif;
                    ?>
                    <div class="sub-section">
                        <p class="description-sub-section">Profile Overview</p>
                        <div class="rating-element">
                            <div class="rating">
                                <?php 
                                foreach(range(5, 1) as $number):
                                    if($average_star_nor_format == $number ):
                                        echo '<input type="radio" id="star' . $number . '-Geef" class="stars" checked name="rating-Geef" value="' . $number . '" />
                                                <label class="star" for="star' . $number . '-Geef" class="stars" title="" aria-hidden="true"></label>';                      
                                        continue;
                                    endif;

                                    echo '<input type="radio" id="star' . $number . '-Geef" class="stars" name="rating-Geef" value="' . $number . '" />
                                            <label class="star" for="star' . $number . '-Geef" title="" aria-hidden="true"></label>';                      

                                endforeach;
                                ?>
                            </div>
                            <span class="rating-counter"></span>
                        </div>
                        <!-- <div class="rating-element">
                            <div class="rating">
                                <input type="radio" id="star5-Geef" class="stars" name="rating_feedback" value="5" />
                                <label class="star" for="star5-Geef" title="Awesome" aria-hidden="true"></label>
                                <input type="radio" id="star4-Geef" class="stars" name="rating_feedback" value="4" />
                                <label class="star" for="star4-Geef" title="Great" aria-hidden="true"></label>
                                <input type="radio" id="star3-Geef" class="stars  " name="rating_feedback" value="3" />
                                <label class="star " for="star3-Geef" title="Very good" aria-hidden="true"></label>
                                <input type="radio" id="star2-Geef" class="stars" name="rating_feedback" value="2" />
                                <label class="star" for="star2-Geef" title="Good" aria-hidden="true"></label>
                                <input type="radio" id="star1-Geef" name="rating_feedback" value="1" />
                                <label class="star" for="star1-Geef" class="stars" title="Bad" aria-hidden="true"></label>
                            </div>

                        </div> -->
                        <p class="text-number-rating"><?= $average_star_nor_format ?></p>
                        <div class="element-sub-section d-flex">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/courses-icon.svg" alt="">
                            <div class="detail">
                                <p class="number"><?= $count_courses ?></p>
                                <p class="description">Courses</p>
                            </div>
                        </div>
                        <!-- <div class="element-sub-section d-flex">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/members-icon.svg" alt="">
                            <div class="detail">
                                <p class="number">?</p>
                                <p class="description">Members</p>
                            </div>
                        </div> -->
                    </div>
                    <?php
                    if(!empty($expertise)):
                        echo '
                        <div class="sub-section">
                            <p class="description-sub-section">Others Experts</p>';
                            $i = 0;
                            foreach($expertise as $id):
                                $expertie = get_user_by('ID', $id);
                                $image_expertie = get_field('profile_img',  'user_' . $id);
                                $image_expertie = $image_expertie ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                
                                $user_id = get_current_user_id();
                                if($expertie->ID == $user_id || $expertie->first_name == "")
                                    continue;

                                $name = ($expertie->last_name) ? $expertie->first_name : $expertie->display_name;

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
                    <div class="sub-section">
                        <p class="description-sub-section">Contact</p>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="block-icon-contact">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/email-icon-white.svg" alt="">
                            </div>
                            <div>
                                <p class="sub-title-contact">Email</p>
                                <p class="element-sub-title"><?= $email ?></p>
                            </div>
                        </div>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="block-icon-contact">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/email-icon-white.svg" alt="">
                            </div>
                            <div>
                                <p class="sub-title-contact">Country</p>
                                <p class="element-sub-title"><?= $country ?></p>
                            </div>
                        </div>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="block-icon-contact">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/email-icon-white.svg" alt="">
                            </div>
                            <div>
                                <p class="sub-title-contact">Phone</p>
                                <p class="element-sub-title"><?= $phone ?></p>
                            </div>
                        </div>

                    </div>

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

<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>
<script src="https://rawgit.com/andreruffert/rangeslider.js/develop/dist/rangeslider.min.js"></script>

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




<!--script pagination-->

<script>
    const itemsPerPage = 15;
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
