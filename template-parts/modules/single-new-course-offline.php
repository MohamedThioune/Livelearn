<?php /** Template Name: new course */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">


<?php

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

//Start or Buy
// if (!$user_id)
//     $startorbuy ='<button type="button" class="btn btn-buy-now" data-toggle="modal" data-target="#SignInWithEmail" aria-label="Close" data-dismiss="modal">Buy Now</button>';
// else
    $startorbuy = (!$statut_bool) ? '<a href="/cart/?add-to-cart=' . get_field('connected_product', $post->ID) . '" class="btn btn-buy-now">Buy Now</a>' : '<a href="/dashboard/user/checkout-video/?post=' . $post->post_name . '" class="btn btn-stratNow">Start Now</a>';
    $startorbuy = ($price == 'Gratis') ? '<a href="/cart/?add-to-cart=' . get_field('connected_product', $post->ID) . '" class="btn btn-stratNow">Start Now</a>' : $startorbuy;

//Review pourcentage
if(!empty($counting_rate)):
    $star_review[1] = ($star_review[1] / $counting_rate) * 100;
    $star_review[2] = ($star_review[2] / $counting_rate) * 100;
    $star_review[3] = ($star_review[3] / $counting_rate) * 100;
    $star_review[4] = ($star_review[4] / $counting_rate) * 100;
    $star_review[5] = ($star_review[5] / $counting_rate) * 100;
endif;
?>

<body>
<div class="content-new-Courses">
    <div class="content-head">
        <div class="container-fluid">
            <div class="content-autors-detail">
                <a href="/user-overview?id=<?= $post->post_author ?>" class="blockImg">
                    <img src="<?= $author_image ?>" alt="">
                </a>
                <div class="block-name-langue">
                    <p class="name-autors"><?= $author_name ?></p>
                    <p class="langue-text"><?= $language ?></p>
                </div>
                <hr>
                <div class="block-review-calendar">
                    <div class="d-flex align-items-center element-content-head">
                    <?php
                    foreach(range(1,5) as $number):
                        if($average_star >= $number ):
                            echo '<i class="fa fa-star checked"></i>';
                            continue;
                        endif;
                        echo '<i class="fa fa-star"></i>';
                    endforeach;
                    ?>                        
                    <p class="reviews-text"><?= $count_reviews ?> Reviews</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class='fa fa-calendar-alt'></i>
                        <p class="date"><?= $post_date->format('d/m/Y'); ?></p>
                    </div>
                </div>
            </div>
            <h1 class="title-course"><?= $post->post_title ?></h1>
            <p class="category-course"><?= $course_type ?></p>
        </div>
    </div>
    <div class="body-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-tabs-scroll">
                        <ul>
                            <li><a class="tabs-scrool-link" href="#Overview">Overview</a></li>
                            <li><a class="tabs-scrool-link" href="#Course-Content">Course Content</a></li>
                            <li><a class="tabs-scrool-link" href="#Instructor">Instructor</a></li>
                            <li><a class="tabs-scrool-link" href="#Reviews">Reviews</a></li>
                        </ul>
                        <div class="content-section-tabs">
                            <div class="section-tabs" id="Overview">
                                <div class="block-description">
                                    <h2>Description</h2>
                                    <p class="text-tabs">
                                        <?= $long_description ?>
                                    </p>
                                   
                                </div>
                            </div>
                            <!-- 
                            <div class="section-tabs" id="Course-Content">
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
                            <div class="section-tabs" id="Instructor">
                                <h2>Instructor</h2>
                                <div class="d-flex">
                                    <a href="/user-overview?id=<?= $post->post_author ?>" class="blockImg">
                                        <img src="<?= $author_image ?>" alt="">
                                    </a>
                                    <div>
                                        <a href="/user-overview?id=<?= $post->post_author ?>" class="name-autors"><?= $author_name ?></a>
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

                            <div class="section-tabs" id="Reviews">
                                <h2>Student's feedback</h2>
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

                                        if(!$my_review_bool):
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
                                            <textarea name="feedback_content" id="feedback" rows="10" form="review_vid" required></textarea>
                                            <div class="position-relative">
                                                <!-- <input type="button" class='btn btn-send' id='btn_review' name='review_post' value='Send'> -->
                                                <?php if ($user_id==0): ?>
                                                    <button type="button" class='btn btn-send' data-target="#SignInWithEmail" aria-label="Close" data-dismiss="modal">Send</button>
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
                                <!-- 
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
                                -->
                            </ul>
                        </div>
                        <div class="card-detail-course">
                            <h2>Others <?= $course_type ?> Course</h2>
                            <?php
                            foreach($similar_course as $course):
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

                                echo   '<a href=' . get_permalink($course->ID) . ' class="other-course">
                                            <div class="blockImgOtherCourse">
                                                <img src="' . $thumbnail . '" alt="">
                                            </div>
                                            <div>
                                                <p class="name-other-course">' . $course->post_title . '</p>
                                                <p class="price-other-course">' . $price . '</p>
                                            </div>
                                        </a>';
                            endforeach;
                            ?>
                           
                            <!-- <a href="" class="btn btn-see-all">See All</a> -->
                        </div>
                        <div class="card-pub-course">
                            <h2>We Help You Learn While
                                Staying Home</h2>
                            <a href="/about" class="btn btn-started-now">Get Started Now</a>
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/man-pub.png" alt="">
                        </div>
                    </div>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
