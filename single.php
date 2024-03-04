<?php /** Template Name: new-artikel */ ?>

<?php 
wp_head(); 
get_header(); 

// $page = dirname(__FILE__) . '/templates/check_visibility.php';
// require($page);
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<?php
global $post;
global $wp;
global $wpdb;

view($post);
    if (isset($visibility_company))
        if(!visibility($post, $visibility_company))
            header('location: /');

$url = home_url( $wp->request );

$posttags = get_the_tags();

if(!$posttags){
    $category_default = get_field('categories', $post->ID);
    $category_xml = get_field('category_xml', $post->ID);
}

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
$content = get_field('article_itself',  $post->ID);
$reviews = get_field('reviews', $post->ID);
$number_comments = !empty($reviews) ? count($reviews) : '0';
$price = get_field('price', $post->ID) ?: 'Gratis';

//Similar course
$recent_posts = array();
$args = array(
    'post_type' => 'post',
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
        array_push($recent_posts, $course);
        
    if(count($recent_posts) == 5)
        break;
} 

//Views on this course 
$table_tracker_views = $wpdb->prefix . 'tracker_views';
$sql = $wpdb->prepare("SELECT SUM(occurence) as occurence FROM $table_tracker_views WHERE data_type = 'course' AND data_id = $post->ID ");
$post_views = $wpdb->get_results($sql);

//Reaction on this course
$reactions = get_field('reaction', $post->ID);
$reaction = array('cool' => 0, 'lol' => 0, 'love' => 0, 'omg' => 0, 'wtf' => 0 );
foreach($reactions as $value)
    switch ($value['type_reaction']) {
        case 'cool':
            $reaction['cool'] += 1;
            break;
        case 'lol':
            $reaction['lol'] += 1;
            break;
        case 'love':
            $reaction['love'] += 1;
            break;
        case 'omg':
            $reaction['omg'] += 1;
            break;
        case 'wtf':
            $reaction['wtf'] += 1;
            break;
    };

?>

<div class="bg-green-artiken content-new-artikel">
    <div class="container-fluid">
        <?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span>"?>
        <div class="content-artikel d-flex justify-content-between flex-wrap">
            <div class="right-block-artikel">
                <div class="img-fluid-artikel">
                    <img src="<?= $image; ?>" alt="">
                    <div class="content-sub-detail">
                        <p class="category">Artikel</p>
                        <p class="date"><?php echo get_the_date('d'); ?> <br> <?php echo get_the_date('F'); ?></p>
                    </div>
                </div>
                <div class="sub-card-content-artikel">
                    <div class="info-detail-artikel d-flex align-items-center flex-wrap">
                        <a href="<?php echo "/user-overview/?id=" . $post->post_author; ?>" class="d-flex infos-block align-items-center">
                            <div class="img-autors">
                                <img src="<?= $author_picture ?>" alt="">
                            </div>
                            <p class="text-element-artikel"><?= $author_name ?></p>
                        </a>
                        <div class="info-agenda infos-block d-flex align-items-center">
                            <i class="far fa-calendar-o" aria-hidden="true"></i>
                            <p class="text-element-artikel"><?php echo get_the_date('F d, Y'); ?></p>
                        </div>
                        <div class="view-block infos-block d-flex align-items-center">
                            <i class="far fa-eye" aria-hidden="true"></i>
                            <p class="text-element-artikel"><?= $post_views[0]->occurence; ?> views</p>
                        </div>
                        <button class="comments-block infos-block align-items-center text-element-artikel">
                            <i class="far fa-comment-alt"></i>
                            <b><?= $number_comments ?></b> comments
                        </button>
                    </div>
                    <p class="title-artikel"><?php echo the_title(); ?></p>
                    <div class="block-content-text-artikel">
                        <?php
                        if(!the_content())
                            echo $content;
                        ?>
                    </div>
                    
                    <div class="sharing-block d-flex align-items-center">
                        <?php
                            $subject = $post->post_title;
                            $permalink = get_permalink($post->ID);
                            // $body_mail = '<h1>'. $subject .'</h1><br><p>' . $short_description . '</p><br>' . $permalink;

                            $linkedin_share = "https://www.linkedin.com/sharing/share-offsite/?url=" . $permalink;
                            $mail_share = 'mailto:?subject=' . $subject . '&body=' . $permalink;
                        ?>
                        <p>Share :</p>
                        <a target="_blank" href="<?= $linkedin_share ?>"><i class="fab fa-linkedin"></i></a>
                        <!-- <a class="fb-share-button" data-href="<?= $permalink ?>" data-layout="button_count">
                            <i class="fab fa-facebook" aria-hidden="true"></i>
                        </a> -->
                        <!-- <a href=""><i class="fab fa-twitter" aria-hidden="true"></i></a> -->
                        <a target="_blank" href="<?= $mail_share ?>"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                    </div> 
                   
                    <div class="block-reaction">
                        <h2 class="title-reaction">What's your reaction ?</h2>

                        <form action="/dashboard/user/" id="reaction-form" method="POST">
                            <input type="hidden" name="id" value="<?= $post->ID ?>">
                        </form>
                        <?php if ($user_id==0): ?>
                            <div class="content-card-reaction">
                                <button type="button" value="cool" data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal'  class="btn btn-card-reaction">
                                    <i class="far fa-grin fa-one"></i>
                                    <i class="fas fa-grin fa-two"></i>
                                    <p class="feels-text">cool</p>
                                    <p class="text-number-feels"><?= $reaction['cool'] ?></p>
                                </button>
                                <button type="button" value="lol"  data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' class="btn btn-card-reaction">
                                    <i class="far fa-grin-tongue fa-one"></i>
                                    <i class="fas fa-grin-tongue fa-two"></i>
                                    <p class="feels-text">lol</p>
                                    <p class="text-number-feels"><?= $reaction['lol'] ?></p>
                                </button>
                                <button type="button" value="love" data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal'  class="btn btn-card-reaction">
                                    <i class="far fa-kiss-wink-heart fa-one"></i>
                                    <i class="fas fa-kiss-wink-heart fa-two"></i>
                                    <p class="feels-text">love</p>
                                    <p class="text-number-feels"><?= $reaction['love'] ?></p>
                                </button>
                                <button type="button" value="omg"  data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' class="btn btn-card-reaction">
                                    <i class="far fa-surprise fa-one"></i>
                                    <i class="fas fa-surprise fa-two"></i>
                                    <p class="feels-text">omg</p>
                                    <p class="text-number-feels"><?= $reaction['omg'] ?></p>
                                </button>
                                <button type="button" value="wtf"  data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal' class="btn btn-card-reaction">
                                    <i class="far fa-tired fa-one"></i>
                                    <i class="fas fa-tired fa-two"></i>
                                    <p class="feels-text">wtf</p>
                                    <p class="text-number-feels"><?= $reaction['wtf'] ?></p>
                                </button>
                            </div>
                        <?php else : ?>
                            <div class="content-card-reaction">
                                <button type="submit" name='reaction_post' value="cool" form="reaction-form" class="btn btn-card-reaction">
                                    <i class="far fa-grin fa-one"></i>
                                    <i class="fas fa-grin fa-two"></i>
                                    <p class="feels-text">cool</p>
                                    <p class="text-number-feels"><?= $reaction['cool'] ?></p>
                                </button>
                                <button type="submit" name='reaction_post' value="lol" form="reaction-form" class="btn btn-card-reaction">
                                    <i class="far fa-grin-tongue fa-one"></i>
                                    <i class="fas fa-grin-tongue fa-two"></i>
                                    <p class="feels-text">lol</p>
                                    <p class="text-number-feels"><?= $reaction['lol'] ?></p>
                                </button>
                                <button type="submit" name='reaction_post' value="love" form="reaction-form" class="btn btn-card-reaction">
                                    <i class="far fa-kiss-wink-heart fa-one"></i>
                                    <i class="fas fa-kiss-wink-heart fa-two"></i>
                                    <p class="feels-text">love</p>
                                    <p class="text-number-feels"><?= $reaction['love'] ?></p>
                                </button>
                                <button type="submit" name='reaction_post' value="omg" form="reaction-form" class="btn btn-card-reaction">
                                    <i class="far fa-surprise fa-one"></i>
                                    <i class="fas fa-surprise fa-two"></i>
                                    <p class="feels-text">omg</p>
                                    <p class="text-number-feels"><?= $reaction['omg'] ?></p>
                                </button>
                                <button type="submit" name='reaction_post' value="wtf" form="reaction-form" class="btn btn-card-reaction">
                                    <i class="far fa-tired fa-one"></i>
                                    <i class="fas fa-tired fa-two"></i>
                                    <p class="feels-text">wtf</p>
                                    <p class="text-number-feels"><?= $reaction['wtf'] ?></p>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="sub-card-content-artikel comment-card-block">
                    <h3>Comments (<?= $number_comments ?>)</h3>
                    <?php
                    if(!empty($reviews)){
                        foreach($reviews as $review){
                            $user = $review['user'];
                            $image_author = get_field('profile_img',  'user_' . $user->ID);
                            $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/user.png';
                            $rating = $review['rating'];
                            ?>

                            <div class="element-comment d-flex">
                                <div class="img-autors">
                                    <img src="<?= $image_author; ?>" alt="">
                                </div>
                                <div class="w-100">
                                    <p class="autors-comment"><?= $user->display_name; ?></p>
                                    <!-- <p class="date-comment">Thu, 2 Jan 2020, 11:54 PM</p> -->
                                    <p class="comment-text"><?= $review['feedback']; ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    else
                        echo "<h3><strong>No reviews found</strong></h3>";
                            ?>


                    <div class="footer-card-comment d-flex justify-content-between align-items-center">
                        <!-- <button class="btn btn-load-more">Load More </button> -->
                        <?php if($user_id == 0): ?>
                            <button type="button" class="btn btnAddComment" data-toggle='modal' data-target='#SignInWithEmail'  aria-label='Close' data-dismiss='modal'>Add Comment</button>
                        <?php else: ?>
                            <button class="btn btnAddComment" data-toggle="modal" data-target="#ModalComment">Add Comment</button>
                        <?php endif; ?>
                    </div>

                    <!-- Modal Comment -->
                    <div class="modal fade" id="ModalComment" tabindex="-1" role="dialog" aria-labelledby="ModalCommentLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/dashboard/user/" id="form-comment" method="POST">
                                        <input type="hidden" name="user_id" value="<?= $user_id; ?>">
                                        <input type="hidden" name="course_id" value="<?= $post->ID; ?>">
                                    </form>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Comment</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" form="form-comment" name="feedback_content" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="submit" form="form-comment" name="review_post" class="btn SendComment">Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="left-block-artikel">
                <div class="card-right-artikel">
                    <div class="head d-flex justify-content-between">
                        <p class="title-category">Follow us on Social Media</p>
                    </div>
                    <div class="social-networks d-flex flex-wrap">
                        <a target="_blank" href="https://www.facebook.com/LiveLearnHQ">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/flow-facebook.png" alt="">
                        </a>
                        <a target="_blank" href="https://www.instagram.com/livelearn.app/" target="_blank">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/flow-instagram.png" alt="">
                        </a>
                        <!-- <a href="">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/flow-twitter.png" alt="">
                        </a> -->
                        <a target="_blank" href="https://www.linkedin.com/company/livelearnhq/mycompany/ " target="_blank">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/flow-linkedin.png" alt="">
                        </a>
                    </div>
                </div>
                <?php
                if(!empty($posttags) || !empty($category_default) || !empty($category_default)):
                ?>
                <div class="card-right-artikel">
                    <div class="head d-flex justify-content-between">
                        <p class="title-category">Some Categories</p>
                        <!-- <a href="" class="btn-see-all">See All</a> -->
                    </div>
                    <div>
                    <?php
                        if ($posttags)
                            foreach($posttags as $tag)
                                echo '<div class="element-category d-flex justify-content-between flex-wrap">
                                            <a href="/category-overview?category=' . $tag->ID . '" class="name-category">'. $tag->name . '</a>
                                            ' 
                                            . //<p class="number-artikel-category">(6)</p>
                                            '
                                      </div>';   
                        else{
                            $read_category = array();
                            if(!empty($category_default))
                                foreach($category_default as $item)
                                    if($item)
                                        if(!in_array($item,$read_category)){
                                            array_push($read_category,$item);
                                            echo '<div class="element-category d-flex justify-content-between flex-wrap">
                                                        <a href="/category-overview?category=' . $tag->ID . '" class="name-category">'. $tag->name . '</a>
                                                        ' 
                                                        . //<p class="number-artikel-category">(6)</p>
                                                        '
                                                  </div>';
                                            echo '<a href="/category-overview?category=' . $item['value'] . '" class="tag-artikel">'. (String)get_the_category_by_ID($item['value']) .  '</a>  ';
                                        }

                            else if(!empty($category_xml))
                                foreach($category_xml as $item)
                                    if($item)
                                        if(!in_array($item,$read_category)){
                                            array_push($read_category,$item);
                                            echo '<div class="element-category d-flex justify-content-between flex-wrap">
                                                        <a href="/category-overview?category=' . $tag->ID . '" class="name-category">'. $tag->name . '</a>
                                                        ' 
                                                        . //<p class="number-artikel-category">(6)</p>
                                                        '
                                                  </div>';                                        
                                        }
                        }
                    ?>
                    </div>
                </div>
                <?php
                endif;
                if(!empty($recent_posts)):
                ?>
                <div class="card-right-artikel">
                    <div class="head d-flex justify-content-between">
                        <p class="title-category">Recent posts</p>
                        <!-- <a href="" class="btn-see-all">See All</a> -->
                    </div>
                    <?php
                    foreach($recent_posts as $course):
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
                        $post_date = new DateTimeImmutable($course->post_date);

                        echo
                        '<a href="' . get_permalink($course->ID) . '" class="posts-recent-block d-flex">
                            <div class="img-recent-post">
                                <img src="' . $thumbnail .'" alt="">
                            </div>
                            <div class="w-100">
                                <p class="date-recent-post">' . $post_date->format('F d, Y') .'</p>
                                <p class="description-recent-post">' . $course->post_title . '</p>
                            </div>
                        </a>';

                    endforeach;
                    ?>
                </div>
                <?php
                endif;
                ?>
                <!-- 
                <div class="card-right-artikel">
                    <div class="head d-flex justify-content-between">
                        <p class="title-category">Tags Topics</p>
                    </div>
                    <div class="tag-content-topics d-flex flex-wrap">
                    <?php
                        if ($posttags)
                            foreach($posttags as $tag)
                                echo '<a href="/category-overview?category=' . $tag->ID . '" class="tag-artikel">'.$tag->name . '</a>'; 
                        else{
                            $read_category = array();
                            if(!empty($category_default))
                                foreach($category_default as $item)
                                    if($item)
                                        if(!in_array($item,$read_category)){
                                            array_push($read_category,$item);
                                            echo '<a href="/category-overview?category=' . $item['value'] . '" class="tag-artikel">'. (String)get_the_category_by_ID($item['value']) .  '</a>  ';
                                        }

                            else if(!empty($category_xml))
                                foreach($category_xml as $item)
                                    if($item)
                                        if(!in_array($item,$read_category)){
                                            array_push($read_category,$item);
                                            echo '<a href="/category-overview?category=' . $item['value'] . '" class="tag-artikel">'. (String)get_the_category_by_ID($item['value']) . '</a>  ';
                                        }
                        }
                    ?>
                    </div>
                </div> 
                -->
            </div>
        </div>
    </div>
</div>


<!-- modal register / login -->
<div class="modal show" id="modal-redirect" tabindex="-1" role="dialog" aria-labelledby="modal-redirectTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body create-account-block">
                <p class="title-modal">Continue reading on</p>
                <div class="d-flex justify-content-between mb-2">
                    <div class="d-flex  align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/mobile-app-element.png" class="img-for-modal-redirect" alt="">
                        <p class="name-for-redirect">The mobile App</p>
                    </div>
                    <button class="btn btn-for-redirect" onclick="redirect()">Open</button>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="d-flex  align-items-center">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/browser-logos.png" class="img-for-modal-redirect" alt="">
                        <p class="name-for-redirect">Your Browser</p>
                    </div>
                    <button class="btn btn-for-redirect-continue" id="close-modal-reddit">Continue</button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
<?php wp_footer(); ?>

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
<script>
    $(document).ready(function () {
        function checkWindowWidth() {
            var windowWidth = $(window).width();

            if (windowWidth >= 300 && windowWidth <= 767) {
                $("#modal-redirect").modal('show');
            }
        }
        checkWindowWidth();

        $(window).resize(function () {
            checkWindowWidth();
        });
    });
    $('#close-modal-reddit').click(function(){
        $('#modal-redirect').removeClass('show');
    });
    function redirect() {
        var userAgent = navigator.userAgent;
        if (userAgent.indexOf("iPhone") > -1 || userAgent.indexOf("iPod") > -1){
            window.location.href = "https://apps.apple.com/nl/app/livelearn/id1666976386/";
        } else {
            window.location.href = "https://play.google.com/store/apps/details?id=com.livelearn.livelearn_mobile_app&hl=fr";
        }
    }
</script>
<script>
    // partners slides
    $('.logo_slide').slick({
        centerMode: false,
        centerPadding: '130px',
        dots: false,
        slidesToShow: 5,
        autoplay: true,
        speed: 400,
        autoplaySpeed: 1500,
        arrows: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    centerMode: true,
                    centerPadding: '100px'
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '60px'
                }
            }
        ]
    });


    // cards swiper
    $('.small_cards').slick({
        dots: false,
        centerMode: false,
        infinite: false,
        speed: 300,
        slidesToShow: 7,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });


</script>