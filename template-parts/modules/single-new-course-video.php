<?php /** Template Name: new course video */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />

<?php
extract($_GET);
if(empty($youtube_videos))
    if(isset($lesson))
        if(!$bool_link)
            if($lesson != 0)
                header('Location: ' . get_permalink($post->ID));

//Long description             
$long_description = ($long_description) ? : "No long description found for this course ";

//Author
$author = get_user_by('id', $post->post_author);
$author_name = ($author->last_name) ? $author->first_name . ' ' . $author->last_name : $author->display_name; 
$author_image = get_field('profile_img',  'user_' . $post->post_author);
$author_image = $author_image ? $author_image : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
$author_bio =  get_field('biographical_info',  'user_' . $post->post_author);
$author_role =  get_field('role',  'user_' . $post->post_author);
$post_date = new DateTimeImmutable($post->post_date);

//Read video
$read_video = "";
if(isset($lesson))
    if(!empty($courses))
        $read_video =  "<video class='blockImgCour' poster='' controls>
                            <source src='" . $courses[$lesson]['course_lesson_data'] . "' type='video/mp4;charset=UTF-8' />
                            <source src='" . $courses[$lesson]['course_lesson_data'] . "' type='video/webm; codecs='vp8, vorbis'' />
                            <source src='" . $courses[$lesson]['course_lesson_data'] . "' type='video/ogg; codecs='theora, vorbis'' />
                        </video>";
    else if(!empty($youtube_videos))
        $read_video = '<iframe src="https://www.youtube.com/embed/' . $youtube_videos[$lesson]['id'] .'?autoplay=1&mute=1&controls=1" title="' . $youtube_videos[$lesson]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
// else

//Start or Buy
$startorbuy = (!$statut_bool) ? '<a href="/cart/?add-to-cart=' . get_field('connected_product', $post->ID) . '" class="btn btn-buy-now">Buy Now</a>' : '<a href="/dashboard/user/checkout-video/?post="' . $post->post_name . '" class="btn btn-stratNow">Start Now</a>';

//Review pourcentage
if(!empty($count_reviews)):
    $star_review[1] = ($star_review[1] / $count_reviews) * 100;
    $star_review[2] = ($star_review[2] / $count_reviews) * 100;
    $star_review[3] = ($star_review[3] / $count_reviews) * 100;
    $star_review[4] = ($star_review[4] / $count_reviews) * 100;
    $star_review[5] = ($star_review[5] / $count_reviews) * 100;
endif;

?>
<body>
<div class="content-new-Courses video-content-course">
    <div class="content-head">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-center">
                <p class="reviews-text"><?= $enrolled_member ?> Students</p>
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
                <p class="reviews-text"><?= $average_star ?> (<?= $count_reviews ?> reviews)</p>
            </div>
            <h1 class="title-course text-center"><?= $post->post_title ?></h1>
            <div class="content-autors-detail">
                <div class="blockImg">
                    <img src="<?= $author_image ?>" alt="">
                </div>
                <p class="name-autors"><?= $author_name; ?></p>
            </div>
            <div class="block-review-calendar">
                <div class="d-flex align-items-center">
                    <i class='fa fa-calendar-alt'></i>
                    <p class="date"><?= $post_date->format('d/m/Y'); ?></p>
                </div>
                <?php
                if($language):
                ?>
                <div class="d-flex align-items-center">
                    <i class='fa fa-calendar-alt'></i>
                    <p class="date"><?= $language ?></p>
                </div>
                <?php
                endif;
                ?>
                <div class="d-flex align-items-center">
                    <i class='fa fa-calendar-alt'></i>
                    <p class="date"><?= $course_type ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="container-fluid">
            <div class="course-content-video-intro">
                <?php 
                    echo $read_video;
                ?>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div id="tab-url1">
                        <ul class="nav">
                            <li class="nav-one"><a href="#Overview" class="current">Overview</a></li>
                            <li class="nav-two"><a href="#Course">Course Content</a></li>
                            <li class="nav-three"><a href="#Instructor">Instructor</a></li>
                            <li class="nav-four "><a href="#Reviews">Reviews</a></li>
                        </ul>
                        <div class="list-wrap">
                            <ul id="Overview" class="hide">
                                <div class="d-block">
                                    <div class="section-tabs section-tabs-learn" >
                                        <div class="block-description">
                                            <h2>Description</h2>
                                            <p class="text-tabs">
                                                <?= $long_description; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- 
                                    <div class="section-tabs" >
                                        <h2>What You'll Learn</h2>
                                        <ul class="d-flex flex-wrap list what-you-learn">
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Become an expert in statistics</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Boost your resume with skills</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Gather, organize, data</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Use data for improved</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Present information KPIs</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Perform quantitative</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Analyze current data</span>
                                            </li>
                                            <li>
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/fa-check.svg" alt="">
                                                <span class="text-tabs">Discover how to find trends</span>
                                            </li>
                                        </ul>
                                    </div> 
                                    -->
                                </div>
                            </ul>

                            <ul id="Course">
                                <div class="content-playlist-course">
                                    <p class="title"><?= $post->post_title ?> (<span><?= $count_videos ?> Videos</span>) </p>
                                    <p class="description"><?= $short_description ?></p>
                                    <div class="playlist-course-block">
                
                                        <?php
                                        if(!empty($courses) && !empty($youtube_videos) )
                                            echo '<div class="element-playlist-course">
                                                    <div class="d-flex align-items-center group-element">
                                                        <p class="lecture-text"> 0 <span>lesson founds</span></p>
                                                        <p class="text-playlist-element">No lesson soon available</p>
                                                    </div>
                                                </div>';
                                        else if(!empty($courses))
                                            foreach($courses as $key => $video){
                                                $style = "";
                                                if(isset($lesson))
                                                    if($lesson == $key)
                                                        $style = "color:#F79403";

                                                $link = '#';
                                                $status_icon = get_stylesheet_directory_uri() . "/img/blocked.svg";
                                                if($bool_link || $key == 0){
                                                    $link = '?topic=0&lesson=' . $key;
                                                    $status_icon = get_stylesheet_directory_uri() . "/img/view-course.svg";
                                                }

                                                $lecture_index = $key + 1;
                                                echo 
                                                    '<div class="element-playlist-course">
                                                        <div class="d-flex align-items-center group-element">
                                                            <img class="playlistImg" src="' . get_stylesheet_directory_uri() . '/img/light_play.svg" alt="">
                                                            <p class="lecture-text"> Lecture <span>' . $lecture_index . ' </span></p>
                                                            <a href="' . $link . '" class class="text-playlist-element ' . $style . '">' . $video['course_lesson_title'] . '</a>
                                                        </div>
                                                        <img class="status-icon" src="' . $status_icon . '" alt="">
                                                    </div>';
                                            }
                                        else if(!empty($youtube_videos))
                                            foreach($youtube_videos as $key => $video){
                                                $style = "";
                                                if(isset($lesson))
                                                    if($lesson == $key)
                                                        $style = "color:#F79403";

                                                $lecture_index = $key + 1;
                                                echo 
                                                    '<div class="element-playlist-course">
                                                        <div class="d-flex align-items-center group-element">
                                                            <img class="playlistImg" src="' . get_stylesheet_directory_uri() . '/img/light_play.svg" alt="">
                                                            <p class="lecture-text"> Lecture <span>' . $lecture_index . ' </span></p>
                                                            <a href="' . $link . '" class="text-playlist-element ' . $style . '">' . $video['title'] . '</a>
                                                        </div>
                                                        <img class="status-icon" src="' . get_stylesheet_directory_uri() . '/img/view-course.svg" alt="">
                                                    </div>';
                                            }                                                
                                        
                                        ?>                                       
                                    </div>
                                </div>
                            </ul>

                            <ul id="Instructor" class="hide">
                                <div class="section-tabs">
                                    <div class="d-flex">
                                        <div class="blockImg">
                                            <img src="<?= $author_image ?>" alt="">
                                        </div>
                                        <div class="second-block-profil">
                                            <p class="name-autors"><?= $author_name ?></p>
                                            <p class="langue-text"><?= $author_role ?></p>
                                            <div class="d-flex flex-wrap">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-star checked"></i>
                                                    <p class="text-detail-reveiw text-detail-reveiw2"> 5.0 Instructor Rating</p>
                                                </div>
                                                <p class="text-detail-reveiw"><?= $count_reviews ?> Reviews</p>
                                                <p class="text-detail-reveiw"><?= $enrolled_member ?> Students</p>
                                                <p class="text-detail-reveiw"><?= count($author_courses) ?> Courses</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-about-authors"><?= $author_bio ?></p>
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
                                                <input type="hidden" name="course_id" value="<?= $post->ID; ?>" >
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
                                            <textarea name="feedback_content" id="feedback" rows="10" form="review_vid"></textarea>
                                            <div class="position-relative">
                                                <!-- <input type="button" class='btn btn-send' id='btn_review' name='review_post' value='Send'> -->
                                                <button type="submit" class='btn btn-send' id='btn_review' name='review_post' form="review_vid">Send</button>
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
                        <br>
                        <h2>Expert</h2>
                        <div class="owl-carousel owl-theme owl-carousel-card-course">
                            <?php
                            $saves_expert = get_user_meta($user_id, 'expert');
                            foreach($experts as $value):
                                if(!$value) 
                                    continue;

                                $expert = get_user_by('id', $value);
                                $expert_name = ($expert->last_name) ? $expert->first_name . ' ' . $expert->last_name : $expert->display_name; 
                                $image = get_field('profile_img',  'user_' . $expert->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                                $company = get_field('company',  'user_' . $expert->ID);
                                $title = $company[0]->post_title;
                                ?>
                                <a href="/user-overview?id=<?= $expert->ID ?>" class="card-expert">
                                    <div class="head">
                                        <img src="<?= $image ?>" alt="">
                                    </div>
                                    <p class="name-expert"><?= $expert_name ?></p>
                                    <p class="poste-expert"><?= $title ?></p>
                                </a>    
                               
                                <!-- 
                                <form action="/dashboard/user/" method="POST">
                                    <input type="hidden" name="artikel" value="<?= $post->ID; ?>" id="">
                                    <input type="hidden" name="meta_value" value="<?= $expert->ID; ?>" id="">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>" id="">
                                    <input type="hidden" name="meta_key" value="expert" id="">
                                    <div>
                                    <?php
                                    if(empty($saves_expert) && $user_id != 0)
                                        echo "<button type='submit' class='btn btnFollowExpert' name='interest_push'>Follow</button>";
                                    else if($user_id != 0)
                                        if($user_id != $expert->ID){
                                            if (in_array($expert->ID, $saves_expert))
                                                echo "<button type='submit' class='btn btnFollowExpert' name='delete'>Unfollow</button>";
                                            else
                                                echo "<button type='submit' class='btn btnFollowExpert' name='interest_push'>Follow</button>";
                                        }
                                    ?>
                                    </div>
                                </form>
                                -->
                                <?php
                                // if($user_id == 0)
                                //     echo "                                
                                //         <button data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' type='submit' class='btn btnFollowExpert'> 
                                //             Follow                                            
                                //         </button>";
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-block-detail-course">
                        <div class="card-detail-course">
                            <div class="head">
                                <img src="<?= $thumbnail ?>" alt="">
                            </div>
                            <p class="title-course">Course Includes</p>
                            <ul>
                                <li>
                                    <p class="name-element-detail">Price:</p>
                                    <p class="detail priceCourse"> € <?= $price ?></p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Instructor:</p>
                                    <p class="detail"><?= $author_name ?></p>
                                </li>
                                <!-- 
                                <li>
                                    <p class="name-element-detail">Duration:</p>
                                    <p class="detail">3 weeks</p>
                                </li> 
                                -->
                                <li>
                                    <p class="name-element-detail">Lessons:</p>
                                    <p class="detail"><?= $count_videos ?></p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Enrolled</p>
                                    <p class="detail"><?= $enrolled_member ?></p>
                                </li>
                                <?php
                                if($language)
                                    echo '
                                        <li>
                                            <p class="name-element-detail">Language:</p>
                                            <p class="detail">'. $language . '</p>
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
                                <div class="d-block">
                                    <?php echo $startorbuy; ?>
                                </div>
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
            if(!empty($similar_course)):
            ?>
            <div class="similar-course-block">
                <h2>Similar Course</h2>
                <div class="owl-carousel similarCourseCarousel owl-theme owl-carousel-card-course">
                    <?php
                    foreach($similar_course as $course):
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

<?php get_footer(); ?>
<?php wp_footer(); ?>

</body>