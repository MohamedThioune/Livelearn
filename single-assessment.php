<?php /** Template Name: new course assessment */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />

<?php
/* Get  seconds by given string time  */
function timeToSeconds(string $time): int
{
    $time_array = explode(':', $time);
    if (count($time_array) === 2 && $time_array[0]!='00') {
        return  $time_array[0] * 60 + $time_array[1];
    }
    return (int)$time_array[1];
}

$user_id = get_current_user_id();
$course_type = get_field('course_type', $post->ID);

/* Image */
$thumbnail = get_field('image_assessement', $post->ID)['url'];
if(!$thumbnail)
    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';

/* Experts */
$user_choose = $post->post_author;
$expert = get_field('experts', $post->ID);
$author = array($user_choose);
if(isset($expert[0]))
    $experts = array_merge($expert, $author);
else
    $experts = $author;

/* Description & How it works */
$description = get_field('description_assessment', $post->ID);
$description = ($description) ? : "No description found for this assessment ";
$how_it_works = get_field('how_it_works', $post->ID);
$how_it_works = ($how_it_works) ? : "No long description found for this assessment ";

/* Author */
$author = get_user_by('id', $post->post_author);
$author_name = ($author->last_name) ? $author->first_name . ' ' . $author->last_name : $author->display_name; 
$author_image = get_field('profile_img',  'user_' . $post->post_author);
$author_image = $author_image ? $author_image : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
$author_bio =  get_field('biographical_info',  'user_' . $post->post_author);
$author_role =  get_field('role',  'user_' . $post->post_author);
$post_date = new DateTimeImmutable($post->post_date);

/* Start or Buy */
if ($user_id == 0)
    $btnStart ="<button type='button' class='btn btn-stratNow' data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal'>Start Now</button>";
else
    $btnStart = '<button class="btn btn-stratNow" data-target="" data-toggle="" id="">Start Now</button>';

$startorbuy = "<form action='/dashboard/user/answer-assessment' method='post'>
                <input type='hidden' name='assessment_id' value=' ". $post->ID ."' >
                $btnStart
               </form>";

/* Review pourcentage */
if(!empty($counting_rate)):
    $star_review[1] = ($star_review[1] / $counting_rate) * 100;
    $star_review[2] = ($star_review[2] / $counting_rate) * 100;
    $star_review[3] = ($star_review[3] / $counting_rate) * 100;
    $star_review[4] = ($star_review[4] / $counting_rate) * 100;
    $star_review[5] = ($star_review[5] / $counting_rate) * 100;
endif;

/* Questions */
$questions = get_field('question',$post->ID);
$timer = 0;
foreach ($questions as $question)
{
    $question_time=$question['timer'];
    $timer+= timeToSeconds($question_time);
}

/* Get minutes by given string seconds  */
$timer = ceil($timer/60);

/* Level */
$level = get_field('difficulty_assessment', $post->ID);

/* Category */
$category_default = get_field('categories', $post->ID);
$category_xml = get_field('category_xml', $post->ID);

?>
<body>
<div class="content-new-Courses video-content-course content-course-podcast">
    <div class="container-fluid">
        <div class="content-head-podcast">
           <div class="block-img">
               <img src="<?= $thumbnail ?>" alt="">
           </div>
            <div class="block-detail-podcast">
                <h1><?= $post->post_title ?></h1>
                <p class="description"><?= $description ?></p>
                <div class="d-flex flex-wrap">
                    <div class="d-flex">
                        <a href="/user-overview?id=<?= $post->post_author ?>" class="block-img-created-assessment">
                            <img src="<?= $author_image ?>" alt="">
                        </a>
                        <div class="block-sub-detail">
                            <p class="category-text-title">Created by</p>
                            <a href="/user-overview?id=<<?= $post->post_author ?>" class="category-text"><?= $author_name ?></a>
                        </div>
                    </div>
                    <div class="block-sub-detail">
                        <p class="category-text-title">Categories</p>
                        <p class="category-text">Assessment</p>
                    </div>
                    <!-- <div class="block-sub-detail">
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
                            <p class="category-text"><?= $average_star ?> (<?= $count_reviews ?> reviews)</p>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="h2-assessment">About</h2>
                    <p class="sub-title"><?= $description ?></p>
                    <p class="description-assessment">
                       <?= $how_it_works ?></p>
                    <?php
                    if(!empty($category_default) || !empty($category_xml)):
                    ?>
                        <div class="block-covered-skills">
                        <p class="sub-title">Covered skills</p>
                        <ul class="d-flex flex-wrap">
                            <?php
                            $read_category = array();
                            if(!empty($category_default))
                                foreach($category_default as $item)
                                    if($item)
                                        if(!in_array($item,$read_category)){
                                            array_push($read_category,$item);
                                            echo '<li>
                                                    <img src="' . get_stylesheet_directory_uri() . '/img/fa-check.svg" alt="">&nbsp;
                                                    <a href="/category-overview?category=' . $item['value'] . '" class="">'. (String)get_the_category_by_ID($item['value']). '</a>
                                                </li>';   
                                        }

                            else if(!empty($category_xml))
                                foreach($category_xml as $item)
                                    if($item)
                                        if(!in_array($item,$read_category)){
                                            array_push($read_category,$item);
                                            echo '<li>
                                                    <img src="' . get_stylesheet_directory_uri() . '/img/fa-check.svg" alt="">
                                                    <a href="/category-overview?category=' . $item['value'] . '" class="">'. (String)get_the_category_by_ID($item['value']). '</a>
                                                </li>';                                        
                                        }
                            ?>
                        </ul>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
                <div class="col-lg-4">
                    <div class="right-block-detail-course">
                        <div class="card-detail-course">
                            <p class="title-course">Assessment Include</p>
                            <ul>
                                <!-- <li>
                                    <p class="name-element-detail">Type:</p>
                                    <p class="detail priceCourse">UX UI Design</p>
                                </li> -->
                                <li>
                                    <p class="name-element-detail">Instructor:</p>
                                    <p class="detail"><?= $author_name ?></p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Time:</p>
                                    <p class="detail"><?= $timer ?> Minutes</p>
                                </li>
                                <?php
                                if($language)
                                echo '<li>
                                        <p class="name-element-detail">Language:</p>
                                        <p class="detail">' . $language .'</p>
                                      </li>';
                                ?>
                                <li>
                                    <p class="name-element-detail">Certificate:</p>
                                    <p class="detail">NO</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Niveau:</p>
                                    <p class="detail"><?= $level ?></p>
                                </li>
                                <div class="d-block">
                                <?php echo $startorbuy ?>                             
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
            <div class="assessment-expert-block">
                <h2>Expert</h2>
                <div class="owl-carousel owl-carousel-expert owl-theme owl-carousel-card-course">
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
            <div class="assessment-expert-block">
                <h2>Similar Course Assessment</h2>
                <div class="owl-carousel owl-carousel-assessment owl-theme owl-carousel-card-course">
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-2.png" alt="First-slide-looggin">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail"> <?= $timer ?> minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-2.png" alt="First-slide-looggin">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail"> <?= $timer ?> minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-2.png" alt="First-slide-looggin">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail"> <?= $timer ?> minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-2.png" alt="First-slide-looggin">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail"> <?= $timer ?> minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="contentCardAssessment">
                        <div class="cardAssessement">
                            <div class="heead-img-block">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/assessment-2.png" alt="First-slide-looggin">
                            </div>
                            <div class="body-card-assessment">
                                <p class="title-assessment">Backend assessments</p>
                                <p class="level">Medium</p>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clock"></i>
                                        <p class="text-element-detail"> <?= $timer ?> minutes</p>
                                    </div>
                                    <div class="d-flex element-detail-assessment">
                                        <i class="far fa-clone"></i>
                                        <p class="text-element-detail">Multiple Choice Quiz</p>
                                    </div>
                                </div>
                            </div>
                            <div class="footerCardSkillsssessment">
                                <a href="" class="btn btnDetailsAssessment">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/organictabs.jquery.js"></script>

<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.lazyload.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>

<script>
    $('.owl-carousel-expert').owlCarousel({
        loop:true,
        margin:13,
        items:4.5,
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
                items:4.5,
                nav:true,
                loop:false
            }
        }
    })
</script>
<script>
    $('.owl-carousel-assessment').owlCarousel({
        loop:true,
        margin:13,
        items:3.5,
        lazyLoad:true,
        dots:false,
        responsiveClass:true,
        autoplayHoverPause:true,
        responsive:{
            0:{
                items:1.2,
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


<?php get_footer(); ?>
<?php wp_footer(); ?>

</body>