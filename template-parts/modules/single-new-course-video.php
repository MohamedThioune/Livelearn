<?php /** Template Name: new course video */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />

<?php
extract($_GET);
if(isset($lesson))
    if(!$bool_link)
        if($lesson != 0)
            header('Location: ' . get_permalink($post->ID));

//Long description             
$long_description = ($long_description) ? : "No long description found for this course ";

//Author
$author = get_user_by('id', $post->post_author);
$author_name = ($author->last_name) ? $author->first_name : $author->display_name;
$author_image = get_field('profile_img',  'user_' . $post->post_author);
$author_image = $author_image ? $author_image : get_stylesheet_directory_uri() . '/img/placeholder_user.png';

?>
<body>
<div class="content-new-Courses video-content-course">
    <div class="content-head">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-center">
                <p class="reviews-text">0 Students</p>
                <div class="d-flex">
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                    <i class="fa fa-star checked"></i>
                </div>
                <p class="reviews-text">0 (0 reviews)</p>
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
                    <p class="date">10 /15 /2022</p>
                </div>
                <div class="d-flex align-items-center">
                    <i class='fa fa-calendar-alt'></i>
                    <p class="date">English</p>
                </div>
                <div class="d-flex align-items-center">
                    <i class='fa fa-calendar-alt'></i>
                    <p class="date">Opleiding</p>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="container-fluid">
            <div class="course-content-video-intro">
                <iframe src="https://www.youtube.com/embed/zHAa-m16NGk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
                                </div>
                            </ul>

                            <ul id="Course">
                                <div class="content-playlist-course">
                                    <p class="title">The Ultimate Playlist to Enrich Your Knowledge (<span>06 Videos</span>) </p>
                                    <p class="description">Immerse yourself in this unprecedented educational experience and be inspired by the knowledge shared in this playlist of video lessons.</p>
                                    <div class="playlist-course-block">
                                        <div class="element-playlist-course">
                                            <div class="d-flex align-items-center group-element">
                                                <img class="playlistImg" src="<?php echo get_stylesheet_directory_uri();?>/img/light_play.svg" alt="">
                                                <p class="lecture-text"> Lecture <span>01</span></p>
                                                <p class="text-playlist-element">Introduction</p>
                                            </div>
                                            <img class="status-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/view-course.svg" alt="">
                                        </div>
                                        <div class="element-playlist-course">
                                            <div class="d-flex align-items-center group-element">
                                                <img class="playlistImg" src="<?php echo get_stylesheet_directory_uri();?>/img/light_play.svg" alt="">
                                                <p class="lecture-text"> Lecture <span>02</span></p>
                                                <p class="text-playlist-element">Web Design Beginner</p>
                                            </div>
                                            <img class="status-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/view-course.svg" alt="">
                                        </div>
                                        <div class="element-playlist-course">
                                            <div class="d-flex align-items-center group-element">
                                                <img class="playlistImg" src="<?php echo get_stylesheet_directory_uri();?>/img/light_play.svg" alt="">
                                                <p class="lecture-text"> Lecture <span>03</span></p>
                                                <p class="text-playlist-element">Startup Designing with HTML5 & CSS3</p>
                                            </div>
                                            <img class="status-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/blocked.svg" alt="">
                                        </div>
                                        <div class="element-playlist-course">
                                            <div class="d-flex align-items-center group-element">
                                                <img class="playlistImg" src="<?php echo get_stylesheet_directory_uri();?>/img/light_play.svg" alt="">
                                                <p class="lecture-text"> Lecture <span>04</span></p>
                                                <p class="text-playlist-element">How To Call Google Map iFrame</p>
                                            </div>
                                            <img class="status-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/blocked.svg" alt="">
                                        </div>
                                        <div class="element-playlist-course">
                                            <div class="d-flex align-items-center group-element">
                                                <img class="playlistImg" src="<?php echo get_stylesheet_directory_uri();?>/img/light_play.svg" alt="">
                                                <p class="lecture-text"> Lecture <span>05</span></p>
                                                <p class="text-playlist-element">Create Drop Down Navigation Using CSS3</p>
                                            </div>
                                            <img class="status-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/blocked.svg" alt="">
                                        </div>
                                        <div class="element-playlist-course">
                                            <div class="d-flex align-items-center group-element">
                                                <img class="playlistImg" src="<?php echo get_stylesheet_directory_uri();?>/img/light_play.svg" alt="">
                                                <p class="lecture-text"> Lecture <span>06</span></p>
                                                <p class="text-playlist-element">How to Create Sticky Navigation Using JS</p>
                                            </div>
                                            <img class="status-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/blocked.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </ul>

                            <ul id="Instructor" class="hide">
                                <div class="section-tabs">
                                    <div class="d-flex">
                                        <div class="blockImg">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                        </div>
                                        <div class="second-block-profil">
                                            <p class="name-autors">Laurence Simpson</p>
                                            <p class="langue-text">President of Sales</p>
                                            <div class="d-flex flex-wrap">
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-star checked"></i>
                                                    <p class="text-detail-reveiw text-detail-reveiw2"> 5.0 Instructor Rating</p>
                                                </div>
                                                <p class="text-detail-reveiw">23,987 Reviews</p>
                                                <p class="text-detail-reveiw">692 Students</p>
                                                <p class="text-detail-reveiw">15 Course</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-about-authors">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use lorem ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy.</p>
                                </div>
                            </ul>
                            <ul id="Reviews" class="hide">
                                <div class="section-tabs" >
                                    <div class="d-flex justify-content-between flex-wrap block-review-course">
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
                                    <div class="user-comment-block">
                                        <div class="d-flex">
                                            <div class="img-block">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <p class="name-autors-comment">Laurence Simpson </p> <p class="timing-comment">3 days ago</p>
                                                </div>
                                                <p class="title-comment">The best LMS Design</p>
                                            </div>
                                        </div>
                                        <p class="text-tabs">It is a long established fact that a reader will be distracted by the readable content of a page whof using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using.</p>
                                    </div>
                                    <div class="user-comment-block">
                                        <div class="d-flex">
                                            <div class="img-block">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <p class="name-autors-comment">Laurence Simpson </p> <p class="timing-comment">3 days ago</p>
                                                </div>
                                                <p class="title-comment">The best LMS Design</p>
                                            </div>
                                        </div>
                                        <p class="text-tabs">It is a long established fact that a reader will be distracted by the readable content of a page whof using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using.</p>
                                    </div>
                                    <div class="user-comment-block">
                                        <div class="d-flex">
                                            <div class="img-block">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center">
                                                    <p class="name-autors-comment">Laurence Simpson </p> <p class="timing-comment">3 days ago</p>
                                                </div>
                                                <p class="title-comment">The best LMS Design</p>
                                            </div>
                                        </div>
                                        <p class="text-tabs">It is a long established fact that a reader will be distracted by the readable content of a page whof using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using.</p>
                                    </div>
                                    <div class="comment-block">
                                        <h2>Write a Review</h2>
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
                                        <input type="text" placeholder="Title">
                                        <textarea name="" id="" rows="10"></textarea>
                                        <div class="position-relative">
                                            <button class="btn btn-send">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </ul>


                        </div> <!-- END List Wrap -->

                    </div>
                    <div>
                        <h2>Expert</h2>
                        <div class="owl-carousel owl-theme owl-carousel-card-course">

                            <a class="card-expert">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                </div>
                                <p class="name-expert">Earle Goodman</p>
                                <p class="poste-expert">UI Designer</p>
                            </a>
                            <a class="card-expert">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Expert2.png" alt="">
                                </div>
                                <p class="name-expert">Earle Goodman</p>
                                <p class="poste-expert">Web Developer</p>
                            </a>
                            <a class="card-expert">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert3.png" alt="">
                                </div>
                                <p class="name-expert">Earle Goodman</p>
                                <p class="poste-expert">Digital Marketer</p>
                            </a>
                            <a class="card-expert">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert4.png" alt="">
                                </div>
                                <p class="name-expert">Earle Goodman</p>
                                <p class="poste-expert">WordPress Expert</p>
                            </a>
                            <a class="card-expert">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/expert1.png" alt="">
                                </div>
                                <p class="name-expert">Earle Goodman</p>
                                <p class="poste-expert">UI Designer</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-block-detail-course">
                        <div class="card-detail-course">
                            <div class="head">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/event.jpg" alt="">
                            </div>
                            <p class="title-course">Course Includes</p>
                            <ul>
                                <li>
                                    <p class="name-element-detail">Price:</p>
                                    <p class="detail priceCourse">$70.00</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Instructor:</p>
                                    <p class="detail">Edward Norton</p>
                                </li>
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
                                    <p class="detail">65</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Language:</p>
                                    <p class="detail">English</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Language:</p>
                                    <p class="detail">English</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Certificate:</p>
                                    <p class="detail">Yes</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Access:</p>
                                    <p class="detail">Fulltime</p>
                                </li>
                                <div class="d-block">
                                    <a href="" class="btn btn-stratNow">Start Now</a>
                                    <a href="" class="btn btn-buy-now">Buy Now</a>
                                </div>
                                <div class="sharing-element">
                                    <p>Share On:</p>
                                    <div class="d-flex flex-wrap">
                                        <a href="">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="similar-course-block">
                <h2>Similar Course</h2>
                <div class="owl-carousel similarCourseCarousel owl-theme owl-carousel-card-course">
                    <a href="" class="new-card-course">
                        <div class="head">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                        </div>
                        <div class="title-favorite d-flex justify-content-between align-items-center">
                            <p class="title-course">Rekenmodel voor het bepalen van financiële restwaarde van</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                            <div class="blockOpein d-flex align-items-center">
                                <i class="fas fa-graduation-cap"></i>
                                <p class="lieuAm">Opleiding</p>
                            </div>
                            <div class="blockOpein">
                                <i class="fas fa-map-marker-alt"></i>
                                <p class="lieuAm">Online</p>
                            </div>
                        </div>
                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="blockImgUser">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                </div>
                                <p class="autor">Alba concepts</p>
                            </div>
                            <p class="price">$40.00</p>
                        </div>
                    </a>
                    <a href="" class="new-card-course">
                        <div class="head">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                        </div>
                        <div class="title-favorite d-flex justify-content-between align-items-center">
                            <p class="title-course">Rekenmodel voor het bepalen van financiële restwaarde van</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                            <div class="blockOpein d-flex align-items-center">
                                <i class="fas fa-graduation-cap"></i>
                                <p class="lieuAm">Opleiding</p>
                            </div>
                            <div class="blockOpein">
                                <i class="fas fa-map-marker-alt"></i>
                                <p class="lieuAm">Online</p>
                            </div>
                        </div>
                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="blockImgUser">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                </div>
                                <p class="autor">Alba concepts</p>
                            </div>
                            <p class="price">$40.00</p>
                        </div>
                    </a>
                    <a href="" class="new-card-course">
                        <div class="head">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                        </div>
                        <div class="title-favorite d-flex justify-content-between align-items-center">
                            <p class="title-course">Rekenmodel voor het bepalen van financiële restwaarde van</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                            <div class="blockOpein d-flex align-items-center">
                                <i class="fas fa-graduation-cap"></i>
                                <p class="lieuAm">Opleiding</p>
                            </div>
                            <div class="blockOpein">
                                <i class="fas fa-map-marker-alt"></i>
                                <p class="lieuAm">Online</p>
                            </div>
                        </div>
                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="blockImgUser">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                </div>
                                <p class="autor">Alba concepts</p>
                            </div>
                            <p class="price">$40.00</p>
                        </div>
                    </a>
                    <a href="" class="new-card-course">
                        <div class="head">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                        </div>
                        <div class="title-favorite d-flex justify-content-between align-items-center">
                            <p class="title-course">Rekenmodel voor het bepalen van financiële restwaarde van</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                            <div class="blockOpein d-flex align-items-center">
                                <i class="fas fa-graduation-cap"></i>
                                <p class="lieuAm">Opleiding</p>
                            </div>
                            <div class="blockOpein">
                                <i class="fas fa-map-marker-alt"></i>
                                <p class="lieuAm">Online</p>
                            </div>
                        </div>
                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="blockImgUser">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                </div>
                                <p class="autor">Alba concepts</p>
                            </div>
                            <p class="price">$40.00</p>
                        </div>
                    </a>
                    <a href="" class="new-card-course">
                        <div class="head">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                        </div>
                        <div class="title-favorite d-flex justify-content-between align-items-center">
                            <p class="title-course">Rekenmodel voor het bepalen van financiële restwaarde van</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                            <div class="blockOpein d-flex align-items-center">
                                <i class="fas fa-graduation-cap"></i>
                                <p class="lieuAm">Opleiding</p>
                            </div>
                            <div class="blockOpein">
                                <i class="fas fa-map-marker-alt"></i>
                                <p class="lieuAm">Online</p>
                            </div>
                        </div>
                        <div class="autor-price-block d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="blockImgUser">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                </div>
                                <p class="autor">Alba concepts</p>
                            </div>
                            <p class="price">$40.00</p>
                        </div>
                    </a>

                </div>
            </div>
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