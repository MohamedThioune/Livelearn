<html lang="en">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri();?>/green-audio-player.css">
<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
// require_once dirname(__FILE__ , 3) . '/templates/checkout.php';

$post = 0;

if(isset($_GET['post']))
    if($_GET['post'])
        $post = get_page_by_path($_GET['post'], OBJECT, 'course');

$mandatory= false;
if(isset($_GET['man']))
    $mandatory = true;
        
if($post):

/* * Informations course * */

// Coursetype
$course_type = get_field('course_type', $post->ID);
// Image
$image = get_field('preview', $post->ID)['url'];
if(!$image):
    $image = get_the_post_thumbnail_url($post->ID);
    if(!$image)
        $image = get_field('url_image_xml', $post->ID);
    if(!$image)
        $image = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
endif;

// User && author name 
$author = get_user_by('ID', $post->post_author);
$author_name = $author->first_name ?: $author->display_name;
$author_last_name = $author->last_name ?: '';
$user = wp_get_current_user();
$user_name = $user->first_name ?: $user->display_name;
$user_last_name = $user->last_name ?: '';

// Categories
$categories = array();
$posttags = get_the_tags();
if(!$posttags){
    $category_default = get_field('categories', $post->ID);
    $category_xml = get_field('category_xml', $post->ID);
    if(!empty($category_default))
        $categories = $category_default;
    else if(!empty($category_xml))
        $categories = $category_xml;
}

// Long/Short description
$long_description = get_field('long_description', $post->ID);
$short_description = get_field('short_description', $post->ID);

//Prijs
$price = " ";
$price = get_field('price', $course->ID);
if($price != "0")
    $prijs = number_format($p, 2, '.', ',');
else
    $prijs = 'Gratis';

//Language
$language = (get_field('language', $post->ID)) ?: 'Dutch';

//Podcasts
$podcasts = get_field('podcasts', $post->ID) ?: get_field('podcasts_index', $post->ID);

//Share txt
$share_txt = "Hello, i share this course with ya *" . $post->post_title . "* \n Link : " . get_permalink($post->ID) . "\nHope you'll like it.";

/* * Informations reservation * */
//Orders - enrolled courses 
$bool = 0;
$enrolled = array();
$enrolled_courses = array();
$args = array(
    'customer_id' => $user->ID,
    'post_status' => array_keys(wc_get_order_statuses()),
    'post_status' => array('wc-processing'),
    'orderby' => 'date',
    'order' => 'DESC',
    'limit' => -1,
);
$bunch_orders = wc_get_orders($args);

foreach($bunch_orders as $order){
    foreach ($order->get_items() as $item_id => $item ) {
        $course_id = intval($item->get_product_id()) - 1;
        if($course_id == $post->ID)
            $bool = 1;
        //Get woo orders from user
        if(!in_array($course_id, $enrolled))
            array_push($enrolled, $course_id);
    }
}

//Enrolled with Stripe
$enrolled_stripe = list_orders($user->ID)['ids'];
if(!empty($enrolled_stripe))
if(in_array($post->ID, $enrolled_stripe))
    $bool = 1;

if(!$bool)
    header('Location: /dashboard/user/activity?message=You need to register at this course first !' );

$count_enrolled = 0;
if(!empty($enrolled))
    $count_enrolled = count($enrolled);

$count_podcasts = 0;
if(!empty($podcasts))
    $count_podcasts = count($podcasts); 

/* * Lesson reads details * */
//Get read by user 
$args = array(
    'post_type' => 'progression', 
    'title' => $post->post_name,
    'post_status' => 'publish',
    'author' => $user->ID,
    'posts_per_page'         => 1,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_term_cache' => false,
    'update_post_meta_cache' => false
);
$progressions = get_posts($args);
if(empty($progressions)){
    //Create progression
    $post_data = array(
        'post_title' => $post->post_name,
        'post_author' => $user->ID,
        'post_type' => 'progression',
        'post_status' => 'publish'
    );
    $progression_id = wp_insert_post($post_data);
}
else
    $progression_id = $progressions[0]->ID;
//Lesson read
$lesson_reads = get_field('lesson_actual_read', $progression_id);
$count_lesson_reads = ($lesson_reads) ? count($lesson_reads) : 0;

?>
<body>
<div class="content-buying-course-1">
    <div class="advert-course-Block d-flex">
        <div class="advert-one d-flex">
            <div class="blockTextAdvert">
                <p class="name">Hello <span><?= $user_name . ' '. $user_last_name; ?></span> !</p>
                <p class="description">Welcome to our e-learning platform's activity page! Here, you'll find a variety of engaging activities to help you, reinforce your learning .</p>
            </div>
            <div class="blockImgAdvert">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/adv-course.png" alt="">
            </div>
        </div>
        <div class="advert-second d-block bg-bleu-luzien">
            <div class="d-flex">
                <div class="icone-course">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_folder-file.png" alt="">
                </div>
                <div class="d-block">
                    <p class="number-course">Your course</p>
                    <p class="description"><?= $count_enrolled; ?></p>
                </div>
            </div>
            <p class="description-course">A courses to help you learn and acquire new skills at your own pace, on your own time</p>
        </div>
    </div>
    <div class="bying-overview-block d-flex justify-content-between flex-wrap">
        <div class="block-tab">
            <div class="tabs-courses">
                <div class="tabs">
                    <ul class="filters">
                        <li class="item active">Course Overview</li>
                        <li class="item">Course Content</li>
                        <!-- <li class="item">Review</li> -->
                    </ul>

                    <div class="tabs__list">
                        <div class="tab active">
                            <div class="card-info">
                                <div class="course-info-block">
                                    
                                    <h3>Courses Information</h3>
                                    <p class="text-description">
                                    <?= ($long_description) ?: $short_description; ?>
                                    </p>
                                </div>

                                <?php
                                if(!empty($categories)):
                                ?>
                                <div class="tag-block">
                                    <h3>Our Topics</h3>
                                    <div class="d-flex flex-wrap">
                                    <?php
                                    $read_category = array();
                                    foreach($categories as $item)
                                        if($item)
                                        if(!in_array($item['value'],$read_category)){
                                            array_push($read_category,$item['value']);
                                            echo"<p class='tag-description'>" . (String)get_the_category_by_ID($item['value']) . "</p>";
                                        }
                                    ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <div class="language-block">
                                    <h3>Language</h3>
                                    <p class="text-description"><?= $language ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <?php
                            if(!empty($podcasts)): 
                                $timestamp = strtotime($post->post_date);
                                $podcast_date = date('d M Y', $timestamp);
                                ?>
                                <div class="list-podcast-checkout">
                                    <?php
                                    $audio_begin = "";
                                    $audio_done = "style='color: #47BFA3'";

                                    foreach($podcasts as $key => $podcast):
                                    $status = $audio_begin;
                                    foreach($lesson_reads as $lesson)
                                        if($lesson['key_lesson'] == $key){
                                            $status = $audio_done;
                                            break;
                                        }

                                    $read_lesson = "/dashboard/user/start-podcast?post=" . $post->post_name . "&lesson=" . $key;
                                    ?>
                                    <div class="card-podcast-checkout">
                                        <p class="order-number-episode"><?= $key + 1 ?></p>
                                        <div class="block-detail-card-checkout">
                                            <div class="d-flex">
                                                <p class="detail-podcast"><?= $podcast_date ?></p>
                                                <p class="detail-podcast">by <?= $author_name . ' ' . $author_last_name ?></p>
                                                <!-- <p class="detail-podcast"><?= $podcast['course_podcast_title'] ?></p> -->
                                            </div>
                                            <a href="<?= $read_lesson ?>" class="title-episode-podcast" ><span><i class="fa fa-play"></i></span>&nbsp; <slot <?= $status ?>><?= $podcast['course_podcast_title'] ?></slot> </a>
                                            <p class="description-episode" ><?= $short_description ?></p>
                                            <!-- 
                                            <div class="audioBlock d-flex">
                                                <div class="ready-player-3 player-with-download">
                                                    <?= 
                                                    '<audio crossorigin>
                                                        <source src="' . $podcast['course_podcast_data'] . '" type="audio/ogg">
                                                        <source src="' . $podcast['course_podcast_data'] . '" type="audio/mpeg">
                                                        <source src="' . $podcast['course_podcast_data']  . '" type="audio/aac">
                                                        <source src="' . $podcast['course_podcast_data'] . '" type="audio/wav">
                                                        <source src="' . $podcast['course_podcast_data']  . '" type="audio/aiff">
                                                        Your browser does not support the audio element.
                                                    </audio>';
                                                    ?>                                                
                                                </div>
                                                <button type="button" class="btn share-block btn" data-toggle="modal" data-target="#modal1">
                                                    <i class="fa fa-share-alt"></i>
                                                    <p>Share</p>
                                                </button>


                                            Start Modal
                                                <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1Title" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-checkout modal-dialog-course modal-dialog modal-dialog-course-deel" role="document">
                                                        <div class="modal-content">
                                                            <div class="tab">
                                                                <button class="tablinks btn active" onclick="openCity(event, 'Extern')">Extern</button>
                                                                <hr class="hrModifeDeel">
                                                                <button class="tablinks btn" onclick="openCity(event, 'Intern')">Intern</button>
                                                            </div>
                                                            <div id="Extern" class="tabcontent">
                                                                <div class="contentElementPartage">
                                                                    <a href="https://wa.me/?text=<?= $share_txt ?>" target="_blank" id="whatsapp"  class="btn contentIcone">
                                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/whatsapp.png" alt="">
                                                                    </a>
                                                                    <p class="titleIcone">WhatsApp</p>
                                                                </div>
                                                                <div class="contentElementPartage">
                                                                    <button class="btn contentIcone">
                                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/facebook.png" alt="">
                                                                    </button>
                                                                    <p class="titleIcone">Facebook</p>
                                                                </div>
                                                                <div class="contentElementPartage">
                                                                    <button class="btn contentIcone">
                                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/insta.png" alt="">
                                                                    </button>
                                                                    <p class="titleIcone">Instagram</p>
                                                                </div>
                                                                <div class="contentElementPartage">
                                                                    <button id="linkedin" class="btn contentIcone">
                                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/linkedin.png" alt="">
                                                                    </button>
                                                                    <p class="titleIcone">Linkedin</p>
                                                                </div>
                                                                <div class="contentElementPartage">
                                                                    <a href="sms:?&body=<?= $share_txt ?>" target="_blank" id="sms" class="btn contentIcone">
                                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sms.png" alt="">
                                                                    </a>
                                                                    <p class="titleIcone">Sms</p>
                                                                </div>
                                                                <div>
                                                                    <p class="klikText">Klik om link te kopieren</p>
                                                                    <div class="input-group input-group-copy formCopyLink w-75">
                                                                        <input id="test1" type="text" class="linkTextCopy form-control" value="<?php echo get_permalink($post->ID); ?>" readonly>
                                                                        <span class="input-group-btn">
                                                                            <button class="btn btn-default btnCopy">Copy</button>
                                                                        </span>
                                                                        <span class="linkCopied">link copied</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php

                                                            if ($user_id == 0)
                                                            {
                                                                echo "<div id='Intern' class='tabcontent px-md-5 p-3'>";
                                                                wp_login_form([
                                                                    'redirect' => $url,
                                                                    'remember' => false,
                                                                    'label_username' => 'Wat is je e-mailadres?',
                                                                    'placeholder_email' => 'E-mailadress',
                                                                    'label_password' => 'Wat is je wachtwoord?'
                                                                ]);
                                                                echo "</div>";
                                                            }
                                                            else{
                                                                echo "<div id='Intern' class='tabcontent px-md-5 p-3'>";
                                                                echo "<form action='/dashboard/user/' class='formConetentIntern' method='POST'>";
                                                                echo "<label for='member_id'><b>Deel deze cursus met uw team :</b></label>";
                                                                echo "<select class='multipleSelect2' id='member_id' name='selected_members[]' multiple='true'>";
                                                                if(!empty($users_company))
                                                                    foreach($users_company as $user){
                                                                        $name = get_users(array('include'=> $user))[0]->data->display_name;
                                                                        if(!empty($allocution))
                                                                            if(in_array($user, $allocution))
                                                                                echo "<option selected  value='" . $user . "'>" . $name . "</option>";
                                                                            else
                                                                                echo "<option value='" . $user . "'>" . $name . "</option>";
                                                                        else
                                                                            echo "<option class='redE' value='" . $user . "'>" . $name . "</option>";
                                                                    }
                                                                echo "</select></br></br>";
                                                                echo "<input type='hidden' name='course_id' value='" . $post->ID . "' >";
                                                                echo "<input type='hidden' name='path' value='course' />";
                                                                echo "<input type='submit' class='btn btn-info' name='referee_employee' value='Apply' >";
                                                                echo "</form>";
                                                                echo "</div>";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            End Modal

                                            </div> 
                                            -->
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="tab ReviewTab">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="block-note-review">
                                    <p class="note-text">4.8</p>
                                    <div class="rating-bying-course">
                                        <div class="rating-element2">
                                            <div class="rating">
                                                <input type="radio" id="star5-note" class="stars disabled" disabled name="rating-note" value="5" />
                                                <label class="star" for="star5-note" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-note" class="stars" checked name="rating-note" value="4" />
                                                <label class="star" for="star4-note" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-note" class="stars" name="rating-note" value="3" />
                                                <label class="star" for="star3-note" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-note" class="stars" name="rating-note" value="2" />
                                                <label class="star" for="star2-note" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-note" name="rating-note" value="1" />
                                                <label class="star" for="star1-note" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
                                        </div>
                                    </div>
                                    <p class="note-description">Course Rating</p>
                                </div>
                                <div class="barNote">
                                    <div class="skillbars">
                                        <div class="progress" data-fill="95" >
                                        </div>
                                        <div class="bg-gris-Skills"></div>
                                    </div>
                                    <div class="skillbars">
                                        <div class="progress" data-fill="85" >
                                        </div>
                                        <div class="bg-gris-Skills"></div>
                                    </div>
                                    <div class="skillbars">
                                        <div class="progress" data-fill="60" >
                                        </div>
                                        <div class="bg-gris-Skills"></div>
                                    </div>
                                    <div class="skillbars">
                                        <div class="progress" data-fill="50" >
                                        </div>
                                        <div class="bg-gris-Skills"></div>
                                    </div>
                                    <div class="skillbars">
                                        <div class="progress" data-fill="35" >
                                        </div>
                                        <div class="bg-gris-Skills"></div>
                                    </div>
                                </div>
                                <div class="block-rating-note">
                                    <div class="element-block-rating">
                                        <div class="rating-element2">
                                            <div class="rating">
                                                <input type="radio" id="star5-Awesome" class="stars disabled" disabled name="rating-Awesome" value="5" />
                                                <label class="star" for="star5-Awesome" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-Awesome" class="stars" checked name="rating-Awesome" value="4" />
                                                <label class="star" for="star4-Awesome" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-Awesome" class="stars" name="rating-Awesome" value="3" />
                                                <label class="star" for="star3-Awesome" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-Awesome" class="stars" name="rating-Awesome" value="2" />
                                                <label class="star" for="star2-Awesome" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-Awesome" name="rating-Awesome" value="1" />
                                                <label class="star" for="star1-Awesome" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
                                        </div>
                                        <p class="note-global-rating">95 %</p>
                                    </div>
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
                                        <p class="note-global-rating">95 %</p>
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
                                        <p class="note-global-rating">85 %</p>
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
                                        <p class="note-global-rating">60 %</p>
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
                                        <p class="note-global-rating">50 %</p>
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
                                        <p class="note-global-rating">35 %</p>
                                    </div>
                                </div>
                            </div>
                            <div class="block-your-review">
                                <div class="card-info d-flex">
                                    <div class="imgUserElement">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                    </div>
                                    <div class="your-review-element w-100">
                                        <p class="title-review">Your review</p>
                                        <div class="rating-element2">
                                            <div class="rating">
                                                <input type="radio" id="star5-review" class="stars" name="rating-review" value="5" />
                                                <label class="star" for="star5-review" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-review" class="stars" name="rating-review" value="4" />
                                                <label class="star" for="star4-review" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-review" class="stars" name="rating-review" value="3" />
                                                <label class="star" for="star3-review" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-review" class="stars" name="rating-review" value="2" />
                                                <label class="star" for="star2-review" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-review" name="rating-review" value="1" />
                                                <label class="star" for="star1-review" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
                                        </div>
                                        <textarea name="" id="" rows="10"></textarea>
                                       <div class="position-relative">
                                           <button class="btn btn-send">Send</button>
                                       </div>
                                    </div>
                                </div>
                                <div class="all-review-course-buying">
                                    <div class="card-list-review">
                                        <div class="imgUserElement">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                        </div>
                                        <div class="w-100">
                                            <p class="name-reviewer">Stella Johnson</p>
                                            <p class="date-of-review">14th, April 2023</p>
                                            <p class="text-review">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tationUt wisi enim ad minim veniam, </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <?php
            $first_lesson = "/dashboard/user/start-podcast?post=" . $post->post_name . "&lesson=0";
        ?>
        <div class="group-card-strat-block">
            <div class="card-strat-block">
                <a href="<?= $first_lesson ?>" class="btn btn-strat">Start</a>
                <ul>
                    <!-- <li><img src="<?php echo get_stylesheet_directory_uri();?>/img/ic_outline-play-arrow.png" alt="">0 hours on-demand video</li> -->
                    <li><img src="<?php echo get_stylesheet_directory_uri();?>/img/ph_files-light.png" alt=""><?= $count_podcasts; ?> downloadable resources</li>
                    <li><img src="<?php echo get_stylesheet_directory_uri();?>/img/ph_key-light.png" alt="">Full lifetime access</li>
                    <li><img src="<?php echo get_stylesheet_directory_uri();?>/img/certificate-regular.png" alt="">Certificate of Completion</li>
                </ul>
            </div>
            <div class="card-strat-block card-Course card-feature">
                <p class="title-card-strat-block">Course Features</p>
                <div class="element-card-features">
                    <p class="title-element">Lectures</p>
                    <p class="text-number">0</p>
                </div>
                <div class="element-card-features">
                    <p class="title-element">Duration</p>
                    <p class="text-number">0 hours</p>
                </div>
                <div class="element-card-features">
                    <p class="title-element">Skill level</p>
                    <p class="text-number">Medium</p>
                </div>
                <div class="element-card-features">
                    <p class="title-element">Language</p>
                    <p class="text-number"><?= $language ?></p>
                </div>
            </div>
            <?php
            if(!empty($categories)):
            ?>
            <div class="card-strat-block card-Course card-feature">
                <p class="title-card-strat-block">Topics</p>
                <div class="group-topic-course d-flex flex-wrap">
                <?php
                $read_category = array();
                foreach($categories as $item)
                    if($item)
                    if(!in_array($item['value'],$read_category)){
                        array_push($read_category,$item['value']);
                        echo"<p>" . (String)get_the_category_by_ID($item['value']) . "</p>";
                    }
                ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
else:
    echo "<p> This content is no more available !</p>";
endif;
?>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/green-audio-player.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        GreenAudioPlayer.init({
            selector: '.player',
            stopOthersOnPlay: true
        });

        GreenAudioPlayer.init({
            selector: '.player-with-download',
            stopOthersOnPlay: true,
            showDownloadButton: true,
            enableKeystrokes: true
        });

        GreenAudioPlayer.init({
            selector: '.player-with-accessibility',
            stopOthersOnPlay: true,
            enableKeystrokes: true
        });
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


</body>
</html>