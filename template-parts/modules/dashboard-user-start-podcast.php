<html lang="en">

<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>

<?php

$post_id = 0;

if(isset($_GET['post']))
    if($_GET['post'])
        $post = get_page_by_path($_GET['post'], OBJECT, 'course');

$lesson = (isset($_GET['lesson'])) ? $_GET['lesson'] : 0 ;

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

//Podcasts
$podcasts = get_field('podcasts', $post->ID) ?: get_field('podcasts_index', $post->ID);
$count_podcasts = 0;
if(!empty($podcasts))
    $count_podcasts = count($podcasts);

/* * Lesson reads details * */
$user = wp_get_current_user();
//Get read by user 
$args = array(
    'post_type' => 'progression', 
    'post_status' => 'publish',
    'search_title' => $post->post_name,
    'author' => $user->ID,
    'posts_per_page' => -1
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

//Pourcentage
$pourcentage = ($count_podcasts) ? ($count_lesson_reads / $count_podcasts) * 100 : 0;
$pourcentage = intval($pourcentage);
?>

<style>
    .theme-side-menu {
        display: none !important;
    }
    .theme-learning, .theme-form, .theme-content__button-group, .theme-dashboard-blocks {
        padding: 0 !important;
    }
    .side-bar-course {
        top: 170px;
    }
    .body-content-strat .content-course-strat {
        margin-top: 180px;
    }
    .content-start-course .headBlock a {
        font-weight: 400;
        font-size: 14px;
        color: #000000 !important;
        margin-bottom: 2px;
        margin-left: -5px;
        margin-right: 20px;
    }
    .content-list-course ul li i {
        color: #033356 !important;
    }
    @media all and (min-width: 300px) and (max-width: 767px){
        .theme-content {
            min-height: 71vh;
        }
    }

</style>
<body>

<div class="content-start-course">
    <div class="headBlock ">
        <div class="d-flex justify-content-between align-items-center">
            <div class="">
                <div class="d-flex align-items-center">
                    <a href="/dashboard/user/checkout-podcast/?post=<?= $post->post_name ?>"><i class="fa fa-angle-left"></i>Back</a>
                    <p class="title-course"><?php echo $post->post_title; ?></p>
                </div>
                <p class="text-number-element">List (<?= $count_podcasts ?>)</p>
            </div>
            <p class="percentage-progress-course"><?= $pourcentage ?>%</p>
        </div>
        <button class="btn btn-show-list-course" type="button"><i class="fa fa-filter"></i> Show list course element </button>
    </div>
    <div class="body-content-strat d-flex">
        <div class="side-bar-course">
           <button class="btn btn-hide-bar">
               <i class="fa fa-times" aria-hidden="true"></i>
           </button>
            <div class="tab-block-start">
                <div class="tabs-courses">
                    <div class="tabs">
                        <ul class="filters">
                            <li class="item active">Overview</li>
                            <!-- <li class="item">Review</li> -->
                        </ul>

                        <div class="tabs__list">
                            <div class="tab tab-Overview active">
                                <div class="content-list-course">
                                    <ul class="text-left">
                                        <?php
                                        if(empty($podcasts))
                                            echo 
                                            "<li>
                                                <span> No lesson as far, soon available ... </span>
                                            </li>";
                                        else
                                            foreach($podcasts as $key => $podcast){
                                                echo "<li>";
                                                $style = "";
                                                if(isset($lesson))
                                                    if($lesson == $key)
                                                        $style = "color:#F79403";
                                                echo '  
                                                <a style="' .$style . '"  href="?post=' . $post->post_name . '&topic=0&lesson=' . $key . '" >
                                                    <i class="fas fa-microphone-alt" aria-hidden="true"></i><span>' . $key + 1 . '</span> ' . $podcast['course_podcast_title'] . '
                                                </a>';
                                                echo "</li>";
                                            }
                                        ?>
                                        <!-- 
                                        <li>
                                            <a href="">
                                                <i class="fas fa-microphone-alt" aria-hidden="true"></i><span>01</span> Discover the organization
                                            </a>
                                        </li> 
                                        -->
                                    </ul>
                                </div>
                            </div>
                            <div class="tab ReviewTab">
                                <div class="block-note-review block-note-reviewBiss">
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
                                <div class="block-your-review">
                                    <div class="card-info d-flex">
                                        <div class="your-review-element w-100">
                                            <p class="title-review text-left mb-3">Your review</p>
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
                                        <div class="card-list-review flex-wrap text-left">
                                            <div class="imgUserElement">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                            </div>
                                            <div class="w-90">
                                                <p class="name-reviewer">Stella Johnson</p>
                                                <p class="date-of-review">14th, April 2023</p>
                                            </div>
                                            <p class="text-review w-100">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tationUt wisi enim ad minim veniam, </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="content-course-strat position-relative">

          <div>
            <div class="imgPadcastCourse">
            <?php echo "<img src='" . $image . "' alt='preview image'>"; ?>
            </div>
            <form action="" method="POST">
                <input type="hidden" name="course_read" value="<?= $post->post_name ?>">
                <input type="hidden" name="lesson_key" value="<?= $lesson ?>">
                <input type="hidden" name="podcast_read" value="1">
                <button class="btn btn-next ml-auto btn btn-info" name="read_action_lesson" type="submit">
                    I've finished this podcast I'll continue
                    <i class="fa fa-angle-right"></i>
                </button>
            </form>
            <div class="sound-wave">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" preserveAspectRatio="none" viewBox="0 0 1440 560">
                    <g mask='url("#SvgjsMask1099")' fill="none">
                        <rect fill="#0e2a47"></rect>
                        <g transform="translate(0, 0)" stroke-linecap="round" stroke="url(#SvgjsLinearGradient1100)">
                            <path d="M375 202.15 L375 357.85" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M398 155.33 L398 404.67" stroke-width="17.25" class="bar-scale3"></path>
                            <path d="M421 196.44 L421 363.56" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M444 259.91 L444 300.09" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M467 208.25 L467 351.75" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M490 184.8 L490 375.2" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M513 249.28 L513 310.72" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M536 220.75 L536 339.25" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M559 254.8 L559 305.2" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M582 186.77 L582 373.23" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M605 210.13 L605 349.87" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M628 234.45 L628 325.55" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M651 241.1 L651 318.89" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M674 202.95 L674 357.05" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M697 165.81 L697 394.19" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M720 224.51 L720 335.49" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M743 157.59 L743 402.4" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M766 164.98 L766 395.02" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M789 158.93 L789 401.07" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M812 224.24 L812 335.76" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M835 171.73 L835 388.27" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M858 264.89 L858 295.11" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M881 175.14 L881 384.86" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M904 248.17 L904 311.83" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M927 185.4 L927 374.6" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M950 234.82 L950 325.18" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M973 229.9 L973 330.1" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M996 194.25 L996 365.75" stroke-width="17.25" class="bar-scale2 "></path>
                            <path d="M1019 162.47 L1019 397.53" stroke-width="17.25" class="bar-scale1 "></path>
                            <path d="M1042 205.06 L1042 354.94" stroke-width="17.25" class="bar-scale3 "></path>
                            <path d="M1065 240.52 L1065 319.48" stroke-width="17.25" class="bar-scale1 "></path>
                        </g>
                    </g>
                    <defs>
                        <mask id="SvgjsMask1099">
                            <rect width="1440" height="560" fill="#ffffff"></rect>
                        </mask>
                        <linearGradient x1="360" y1="280" x2="1080" y2="280" gradientUnits="userSpaceOnUse" id="SvgjsLinearGradient1100">
                            <stop stop-color="#3a7cc3" offset="0"></stop>
                            <stop stop-color="#dd1133" offset="1"></stop>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
          </div>

           <!-- <div class="d-flex justify-content-between prev-next-btn">
                <a href="" class="btn btn-next ml-auto">
                    I've finished this video I'll continue
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>-->
        </div>
    </div>
    <div class="audioBar">
        <div class="container-fluid">
            <div class="d-flex align-items-center text-center">
                <button class="codeless-player-toggle">
                    <img id="down-chevron" src="<?php echo get_stylesheet_directory_uri();?>/img/down-chevron.svg" alt="">
                    <img id="up-chevron" src="<?php echo get_stylesheet_directory_uri();?>/img/up-chevron.png" alt="">
                </button>
                <div class="codeless-player-info codeless-element">
                    <div class="codeless-player-nav">
                        <button class="previous round livecast-play">&#8249;</button>
                        <button class="next round livecast-play">&#8250;</button>
                    </div>
                    <div class="codeless-player-content">
                        <h5><?= $podcasts[$lesson]['course_podcast_title'] ?></h5>
                    </div>
                </div>
               <div class="codeless-player-audio  codeless-element">
                    <audio controls id="myAudioID">
                        <source src="<?= $podcasts[$lesson]['course_podcast_data'] ?>" type="audio/ogg">
                        <source src="<?= $podcasts[$lesson]['course_podcast_data'] ?>" type="audio/mpeg">
                        <source src="<?= $podcasts[$lesson]['course_podcast_data'] ?>" type="audio/aac">
                        <source src="<?= $podcasts[$lesson]['course_podcast_data'] ?>" type="audio/wav">
                        <source src="<?= $podcasts[$lesson]['course_podcast_data'] ?>" type="audio/aiff">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
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
        var audio = document.querySelector('audio');
        $(".sound-wave").hide();
        audio.onplay = function() {
            audio.play(0);
            $(".imgPadcastCourse").addClass("hide");
            $(".sound-wave").show();
        };

        audio.addEventListener('pause', (event) => {
            $(".imgPadcastCourse").removeClass("hide");
            $(".sound-wave").hide();
        });


    } )
</script>

</body>
</html>