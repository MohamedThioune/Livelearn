<?php /** Template Name: new course podcast */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />

<?php
extract($_GET);
if(empty($podcast_index))
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
$author_bio = get_field('biographical_info',  'user_' . $post->post_author);
$author_role = get_field('role',  'user_' . $post->post_author);
$post_date = new DateTimeImmutable($post->post_date);

//Start or Buy
if (!$user_id):
    $read_status_icon = '<button class="btn" data-toggle="modal" data-target="#modal-login-with-podcast"></button>';
    $startorbuy = (!$statut_bool) ? '<button type="button"  data-toggle="modal" data-target="#modal-login-with-podcast"  aria-label="Close" data-dismiss="modal"  class="btn btn-buy-now">Buy Now</button>' : '<button  data-toggle="modal" data-target="#SignInWithEmail" aria-label="Close" data-dismiss="modal" class="btn btn-stratNow">Start Now</button>';
    $startorbuy = ($price == 'Gratis') ? '<button type="button" data-toggle="modal" data-target="#modal-login-with-podcast" aria-label="Close" data-dismiss="modal" class="btn btn-stratNow">Start Now</button>' : $startorbuy;
else:
    $startorbuy = (!$statut_bool) ? '<a href="/cart/?add-to-cart=' . get_field('connected_product', $post->ID) . '" class="btn btn-buy-now">Buy Now</a>' : '<a href="/dashboard/user/checkout-podcast/?post=' . $post->post_name . '" class="btn btn-stratNow">Start Now</a>';
    $startorbuy = ($price == 'Gratis') ? '<a href="/cart/?add-to-cart=' . get_field('connected_product', $post->ID) . '" class="btn btn-stratNow">Start Now</a>' : $startorbuy;
endif;


//Stripe pay 
$success = "Login successful !";
$redirect_success = "/checkout-stripe?message=" . $success . "&single=" . $post->ID;
$button_pay = ($price == 'Gratis') ? 'Buy free !' : '<img width="50" src="'. get_stylesheet_directory_uri() . '/img/stripe-logo.png" alt="logo stripe"> Pay with Stripe !';
$stripe_pay_form = 
'<form action="/checkout-stripe" method="post">
    <input type="hidden" name="postID" value="' . $post->ID . '">
    <button type="submit" class="btn btn-buy-now" style="background-color:#635BFF" name="productPrice"> 
    ' . $button_pay . '
    </button>
</form>';
$redirect_register = "/checkout-stripe?single=" . $post->ID ."&after=1";

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
<div class="content-new-Courses video-content-course content-course-podcast">
    <div class="container-fluid">
        <div class="content-head-podcast">
            <div class="block-img">
                <img src="<?= $thumbnail ?>" alt="">
            </div>
            <div class="block-detail-podcast">
                <h1><?= $post->post_title ?></h1>
                <p class="description"><?= strip_tags($short_description) ?></p>
                <div class="d-flex">
                    <div class="block-sub-detail">
                        <p class="category-text-title">Categories</p>
                        <p class="category-text">Review</p>
                    </div>
                    <div class="block-sub-detail">
                        <p class="category-text-title">Podcast</p>
                        <div class="d-flex align-items-center">
                            <div class="d-flex">
                                <?php
                                foreach(range(1,5) as $number):
                                    if($average_star >= $number ):
                                        echo '<i class="fa fa-star checked"></i>';
                                        continue;
                                    endif;
                                    echo '<i class="fa fa-star"></i>';
                                endforeach;
                                ?>
                            </div>
                            <p class="category-text"><?= $average_star ?> (<?= $count_reviews ?> reviews)</p>
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
                            <li class="nav-two"><a href="#Course" class="current">Podcast Content</a></li>
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

                            <?php
                            if(!empty($podcasts)):
                                ?>
                                <ul id="Course">
                                    <div class="list-content-podcast">
                                        <?php
                                        foreach($podcasts as $key => $podcast) {
                                            if(!$podcast)
                                                continue;
                                            $style = "";
                                            if(isset($lesson))
                                                if($lesson == $key)
                                                    $style = "color:#F79403";

                                            $link = '#';
                                            $reading = "#";
                                            $date_podcast = date("m/d/Y", strtotime($post->post_date));
                                            $status_icon = get_stylesheet_directory_uri() . "/img/view-course.svg";
                                            //$read_status_icon = '';
                                            $read_status_icon = '<div class="cp-audioquote__player--playBtn"></div>';
                                            if($bool_link || $key == 0){
                                                $reading = $podcast['course_podcast_data'];
                                            }
                                            if (!$user_id && $key>0) {
                                                $status_icon = get_stylesheet_directory_uri() . "/img/blocked.svg";
                                                $read_status_icon = '<button class="btn btn-audio-blocked cp-audioquote__player--playBtn" data-toggle="modal" data-target="#modal-login-with-podcast"></button>';
                                                $reading = "#";
                                            }

                                            $lecture_index = $key + 1;
                                            ?>
                                            <div class="elemnt-list-podcast visible">
                                                <div class="detail-block-podcast">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex">
                                                            <div class="playlist-img">
                                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/userExample.jpg" alt="">
                                                            </div>
                                                            <p class="title-podcast"><?= strip_tags($podcast['course_podcast_title']) ?></p>
                                                        </div>
                                                        <p class="date-added-playlist"><?=$date_podcast?></p>
                                                    </div>
                                                    <div class="audio position-relative">
                                                        <div class="cp-audioquote">
                                                            <div class="cp-audioquote__player">
                                                                <!-- src -->
                                                                <audio class="cp-audioquote__player__src" src="<?= $reading ?>">
                                                                    <p><?= strip_tags($podcast['course_podcast_intro']) ?></p>
                                                                </audio>
                                                                <?= $read_status_icon ?>
                                                               <!-- <div class="cp-audioquote__player--playBtn"></div> -->
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
                                                <div class="ml-3">
                                                    <img class="status-icon" src="<?= $status_icon ?>" alt="">
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="pagination-container">
                                            <!-- Les boutons de pagination seront ajoutés ici -->
                                        </div>
                                    </div>
                                </ul>
                            <?php
                            elseif(!empty($podcast_index)):
                                ?>
                                <ul id="Course">
                                    <div class="list-content-podcast">
                                        <?php
                                        foreach($podcast_index as $key => $podcast) {
                                            if(!$podcast)
                                                continue;
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
                                            $date_podcast = $podcast['podcast_date'];
                                            //$date_podcast = !empty($date_podcast) ? date("d-m-Y H:i:s", strtotime($date_podcast)) : "";
                                            $date_podcast = !empty($date_podcast) ? date("m/d/Y", strtotime($date_podcast)) : "";
                                            $image_podcast = !empty($podcast['podcast_image']) ? $podcast['podcast_image'] :$thumbnail;
                                            $lecture_index = $key + 1;
                                            $description_podcast = strip_tags($podcast['podcast_description']);
                                            $description_podcast = $description_podcast ? : $short_description ;

                                            ?>
                                            <div class="elemnt-list-podcast visible">
                                                <div class="detail-block-podcast">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex">
                                                            <div class="playlist-img">
                                                                <img src="<?= $image_podcast ?>" alt="<?= strip_tags($podcast['podcast_title']) ?>">
                                                            </div>
                                                            <p class="title-podcast"><?= strip_tags($podcast['podcast_title']) ?></p>
                                                        </div>
                                                        <p class="date-added-playlist"><?=$date_podcast?></p>
                                                        <div class="ml-3">
                                                            <?php if ($user_id || (!$user_id && $key==0)) :?>
                                                                <img class="status-icon" src="<?= get_stylesheet_directory_uri() . "/img/view-course.svg" ?>" alt="">
                                                            <?php endif; ?>

                                                            <?php if (!$user_id && $key>0) :?>
                                                                <img class="status-icon" src="<?= get_stylesheet_directory_uri() . "/img/blocked.svg" ?>" alt="">
                                                            <?php endif; ?>

                                                </div>
                                                    </div>
                                                    <?php if ($user_id):?>
                                                    <div class="audio">
                                                        <div class="cp-audioquote">
                                                            <div class="cp-audioquote__player">
                                                                <!-- src -->
                                                                <audio class="cp-audioquote__player__src" src="<?= $reading ?>">
                                                                    <p><?= strip_tags($podcast['podcast_description']) ?></p>
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
                                                    <?php endif; ?>
                                            <?php
                                            if (!$user_id):
                                                $button = '<div class="cp-audioquote__player--playBtn"></div>';
                                                if ( $key>0 ) {
                                                    $reading = "#";
                                                    $button = '<button class="btn btn-audio-blocked cp-audioquote__player--playBtn" data-toggle="modal" data-target="#modal-login-with-podcast"></button>';
                                                    $status_icon = get_stylesheet_directory_uri() . "/img/blocked.svg";
                                                }
                                                ?>
                                                <div class="audio">
                                                    <div class="cp-audioquote">
                                                        <div class="cp-audioquote__player">
                                                            <!-- src -->
                                                            <audio class="cp-audioquote__player__src" src="<?= $reading ?>">
                                                                <p><?= strip_tags($podcast['podcast_description']) ?></p>
                                                            </audio>
                                                            <?= $button ?>
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
                                            <?php endif; ?>
                                                    <p class="description-one-element-playlist"><?= substr($description_podcast,0,100).' ...'  ?></p>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="pagination-container">
                                            <!-- Les boutons de pagination seront ajoutés ici -->
                                        </div>
                                    </div>
                                </ul>
                            <?php
                            endif;
                            ?>

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

                            <?php
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
                                    <p class="detail priceCourse"><?= $price ?></p>
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
                                    <p class="detail"><?= $count_audios ?></p>
                                </li>

                                <li>
                                    <p class="name-element-detail">Enrolled</p>
                                    <p class="detail"><?= $enrolled_member ?></p>
                                </li>

                                <?php
                                if($language)
                                    echo '<li>
                                        <p class="name-element-detail">Language:</p>
                                        <p class="detail">' . $language . '</p>
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

                                <?php 
                                echo $startorbuy; 
                                if(!$user_id)
                                    echo 
                                    '<button data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#SignInCheckout" 
                                        class="btn btn-buy-now" style="background-color:#635BFF" name="productPrice"> 
                                    ' . $button_pay . '
                                    </button>';
                                else
                                    echo $stripe_pay_form;
                             ?>
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
                            //$thumbnail = get_field('preview', $course->ID)['url'];
                            $thumbnail = "";
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



<div class="modal modalLoginCheckout fade" id="SignInCheckout" tabindex="-1" role="dialog" aria-labelledby="SignInCheckoutLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
                                                                box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body  px-md-5 px-4">
                <div class="mb-4">
                    <div class="text-center">
                        <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">
                    </div>
                    <h3 class="text-center my-2">Sign In</h3>
                    <div class="text-center">
                        <p>
                            Not an account ? 
                            <a href="<?= $redirect_register ?>" class="text-primary">&nbsp; Sign up </a>
                        </p>
                    </div>
                </div>

                <?php
                wp_login_form([
                    'redirect' => $redirect_success,
                    'remember' => false,
                    'label_username' => 'What is your email address ?',
                    'placeholder_email' => 'E-mail address',
                    'label_password' => 'What is your password ?'
                ]);                
                ?>
                <!-- <div class="text-center">
                    <a href="" class="watchword-text">Forgot password</a>
                </div> -->
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
    const itemsPerPage = 6;
    const blockList = document.querySelector('.list-content-podcast');
    const blocks = blockList.querySelectorAll('.elemnt-list-podcast');
    const paginationContainer = document.querySelector('.pagination-container');

    function displayPage(pageNumber) {
        const start = (pageNumber - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        blocks.forEach((block, index) => {
            if (index >= start && index < end) {
                block.style.display = 'flex';
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
    $(document).ready(function() {
        $('strong').each(function() {
            var content = $(this).html();
            $(this).replaceWith(content);
        });
    });


</script>


<?php get_footer(); ?>
<?php wp_footer(); ?>
</body>

