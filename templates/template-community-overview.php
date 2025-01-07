<?php /** Template Name: Community overview */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<style>
    .headerdashboard,.navModife {
        background: #deeef3;
        color: #ffffff !important;
        border-bottom: 0px solid #000000;
        box-shadow: none;
    }
    .nav-link {
        color: #043356 !important;
    }
    .nav-link .containerModife{
        border: none;
    }
    .worden {
        color: white !important;
    }
    .navbar-collapse .inputSearch{
        background: #C3DCE5;
    }
    .logoModife img:first-child {
        display: none;
    }
    .imgLogoBleu {
        display: block;
    }
    .imgArrowDropDown {
        width: 15px;
        display: none;
    }
    .fa-angle-down-bleu{
        font-size: 20px;
        position: relative;
        top: 3px;
        left: 2px;
    }
    .additionBlock{
        width: 40px;
        height: 38px;
        background: #043356;
        border-radius: 9px;
        color: white !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .navModife4 .additionImg{
        display: none;
    }
    .additionBlock i{
        display: block;
    }
    .bntNotification img{
        display: none;
    }
    .bntNotification i{
        display: block;
        font-size: 28px;
    }
    .scrolled{
        background: #023356 !important;
    }
    .scrolled .logoModife img:first-child {
        display: block;
    }
    .scrolled .imgLogoBleu{
        display: none;
    }
    .scrolled .nav-link {
        color: #ffffff !important;
        display: flex;
    }
    .scrolled .imgArrowDropDown {
        display: block;
    }
    .scrolled .fa-angle-down-bleu {
        display: none;
    }
    .scrolled .inputSearch {
        background: #FFFFFF !important;
    }
    .scrolled .navModife4 .additionImg {
        display: block;
    }
    .scrolled .additionBlock{
        display: none;
    }
    .scrolled .bntNotification img {
        display: block;
    }
    .scrolled .bntNotification i {
        display: none;
    }
    .nav-item .dropdown-toggle::after {
        margin-left: 8px;
        margin-top: 10px;
    }
</style>

<?php

$users = get_users();
$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'posts_per_page' => -1);

$communities = get_posts($args);

?>


<div class="content-community-overview">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <h1 class="wordDeBestText2">Communities</h1>
            </div>
        </div>
    </section>

    <section class="block-card-community">
       <div class="container-fluid">
           <div class="row">
            <?php
            foreach($communities as $community){
                $company = get_field('company_author', $community->ID);
                $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                $community_image = get_field('image_community', $community->ID) ?: $company_image;

                $level = get_field('range', $community->ID);

                // Get followers from community
                $followers = get_field('follower_community', $community->ID);
            ?>
                <div class="col-md-4">
                    <div class="card-community-overview">
                        <div class="head-card position-relative">
                            <img src="<?= $company_image; ?>" class="second-img-card-community" alt="">
                            <div class="block-img bg-white">
                                <img src="<?= $community_image; ?>" class="img-card-community" alt="">
                            </div>
                            <div>
                                <p class="title-card"><?= $company->post_title; ?></p>
                                <div class="block-rating d-flex align-items-center">
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
                                    <p class="numberRating">(0)</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="eye-block">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/awesome-eye.png" class="" alt="">
                                    </div>
                                    <div class="userBlock">
                                        <?php
                                            if(!empty($followers))
                                            foreach($followers as $key => $value) {
                                                if($key == 4)
                                                    break;
                                                $portrait_image = get_field('profile_img',  'user_' . $value->ID);
                                                if (!$portrait_image)
                                                    $portrait_image = $company_image;
                                                echo '<img src="' . $portrait_image . '"  alt="">';
                                            }
                                        ?>
                                    </div>
                                    <p class="numberUser">
                                        <?php
                                            $plus_user = 0;
                                            $max_user = 0;
                                            if(!empty($followers))
                                                $max_user = count($followers);
                                            if($max_user > 4){
                                                $plus_user = $max_user - 4;
                                                echo '+' . $plus_user;
                                            }
                                        ?>
                                        </p>
                                </div>
                            </div>

                        </div>
                        <div>
                            <div class="content-card">
                                <p class="title"><?= $community->post_title; ?></p>
                                <p class="description"><?= $community->post_excerpt; ?></p>
                            </div>
                            <div class="footer-card">
                                <a href="/community-detail/?mu=<?= $community->ID ?>" class="btn btn-Bekijk">Bekijk</a>
                                <p class="tag yellow"><?= $level ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
           </div>
       </div>
    </section>
</div>



<?php get_footer(); ?>
<?php wp_footer(); ?>


<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    $(function() {
        var header = $(".navbar");
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 61) {
                header.addClass("scrolled");
            } else {
                header.removeClass("scrolled");
            }
        });

    });
</script>
