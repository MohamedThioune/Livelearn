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

//Videos
$courses = get_field('data_virtual', $post->ID);
$youtube_videos = get_field('youtube_videos', $post->ID);
$count_videos = 0;
if(!empty($courses))
    $count_videos = count($courses);
else if(!empty($youtube_videos))
    $count_videos = count($youtube_videos);

/* * Lesson reads details * */
$user = wp_get_current_user();
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

//Pourcentage
$pourcentage = ($count_videos) ? ($count_lesson_reads / $count_videos) * 100 : 0;
$pourcentage = intval($pourcentage);

?>

<style>
    .theme-side-menu {
        display: none !important;
    }
    .theme-learning, .theme-form, .theme-content__button-group, .theme-dashboard-blocks {
        padding: 0 !important;
    }
</style>
<body>

<div class="content-start-course">
    <div class="headBlock ">
        <div class="d-flex justify-content-between align-items-center">
            <div class="">
                <a href="/dashboard/user/checkout-video/?post=<?= $post->post_name ?>"><i class="fa fa-angle-left"></i>Back</a>
                <p class="title-course"><?php echo $post->post_title; ?></p>
                <p class="text-number-element">Video (<?= $count_videos ?>)</p>
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
                                        if(empty($courses) && empty($youtube_videos))
                                            echo 
                                            "<li>
                                                <span> No lesson as far, soon available ... </span>
                                            </li>";
                                        else if(!empty($courses)){
                                            foreach($courses as $key => $video){
                                                echo "<li>";
                                                $style = "";
                                                if(isset($lesson))
                                                    if($lesson == $key)
                                                        $style = "color:#F79403";
                                                echo '  
                                                <a style="' .$style . '"  href="?post=' . $post->post_name . '&topic=0&lesson=' . $key . '" >
                                                    <i class="far fa-play-circle" aria-hidden="true"></i>' . $video['course_lesson_title'] . '
                                                </a>';
                                                echo "</li>";
                                            }

                                        }
                                        else if(!empty($youtube_videos)){
                                            foreach($youtube_videos as $key => $video){
                                                echo "<li>";
                                                $style = "";
                                                if(isset($lesson))
                                                    if($lesson == $key)
                                                        $style = "color:#F79403";
                                                echo '  
                                                <a style="' .$style . '" href="?post=' . $post->post_name . '&topic=0&lesson=' . $key . '" >
                                                    <i class="far fa-play-circle" aria-hidden="true"></i>' . $video['title'] . '
                                                </a>';
                                                echo "</li>";
                                            }
                                        }
                                        ?>
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
            <?php
                if(!empty($courses) && !empty($youtube_videos))
                    echo "<img src='" . $image . "' alt='preview image'>";
                else
                    if(!empty($courses))
                        if(isset($topic) && isset($lesson))
                            echo " <video class='blockImgCour' poster='' controls>
                                        <source src='" . $courses[$lesson]['course_lesson_data'] . "' title=" . $courses[$lesson]['course_lesson_title'] . "  type='video/mp4;charset=UTF-8' />
                                        <source src='" . $courses[$lesson]['course_lesson_data'] . "' title=" . $courses[$lesson]['course_lesson_title'] . "  type='video/webm; codecs='vp8, vorbis'' />
                                        <source src='" . $courses[$lesson]['course_lesson_data'] . "' title=" . $courses[$lesson]['course_lesson_title'] . "  type='video/ogg; codecs='theora, vorbis'' />
                                    </video>";
                        else
                            echo "<img src='" . $image . "' alt='preview image'>";
                    else if(!empty($youtube_videos))
                        if(isset($lesson))
                            echo '<iframe width="730" height="433" src="https://www.youtube.com/embed/' . $youtube_videos[$lesson]['id'] .'?autoplay=1&mute=1&controls=1" title="' . $youtube_videos[$lesson]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        else
                            echo "<img src='" . $image . "' alt='preview image'>";
            ?>
            <div class="d-flex justify-content-between prev-next-btn">
                <form action="" method="POST">
                    <input type="hidden" name="course_read" value="<?= $post->post_name ?>">
                    <input type="hidden" name="lesson_key" value="<?= $lesson ?>">
                    <button class="btn btn-next ml-auto btn btn-info" name="read_action_lesson" type="submit">
                        I've finished this video I'll continue
                        <i class="fa fa-angle-right"></i>
                    </button>
                </form>
                <!-- <a href="" class="btn btn-next ml-auto">
                    I've finished this video I'll continue
                    <i class="fa fa-angle-right"></i>
                </a> -->
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
        $(".btn-show-list-course").click(function() {
            $(".side-bar-course").show();
        });
        $(".btn-hide-bar").click(function() {
            $(".side-bar-course").hide();
        });
    });
</script>

</body>
</html>