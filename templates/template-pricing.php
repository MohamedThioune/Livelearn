<?php /** Template Name: pricing */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php 

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
);

$blogs = get_posts($args);
// Thumbnail : get_the_post_thumbnail($blog->id);
// Tags : get_the_category

$artikel = $blogs[0];

?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />

<div class="contentPricing">
    <div class="container">
        <p class="titlePricing">Altijd transparante prijzen</p>
        <p class="sousPricing">We hebben de prijzen zo eenvoudig mogelijk proberen te maken: <br>  Als individu betaal je niets, als opleider / expert alleen voor nieuwe klanten en als organisatie betaal je voor gebruik. </p>
        <div class="row">
            <div class="col-md-4">
                <div class="cardPricing">
                    <p class="titleCardPPricing">Individueel skills paspoort</p>
                    <p class="sousTitlePricing">Altijd gratis</p>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Eigen leeromgving</p>
                    </div>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Top wel 65% korting op scholing</p>
                    </div>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>24/7 toegang tot carriereadvies</p>
                    </div>
                    <div class="footerCardSkills">
                        <img class="footerFlecheImg" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill0.png" alt="">
                        <p>Lees alles voor <br> individuen </p>
                        <img id="footerFooterImg1" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill1.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cardPricing" id="cardPricing2">
                    <p class="titleCardPPricing">Deel jouw kennis / vaardigheden</p>
                    <p class="sousTitlePricing">No cure no pay</p>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Eigen teacher portaal</p>
                    </div>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Statistieken en best practices</p>
                    </div>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Zichtbaarheid bij 250+ klanten</p>
                    </div>
                    <div class="footerCardSkills">
                        <img class="footerFlecheImg" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill0.png" alt="">
                        <p>Lees alles voor <br> Opleiders </p>
                        <img id="footerFooterImg2" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill2.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cardPricing" id="cardPricing3">
                    <p class="titleCardPPricing">Upskill jouw team / organisatie</p>
                    <p class="sousTitlePricing">€4,95 p.m.</p>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Een organisatie portaal</p>
                    </div>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Koppelingen met huidige systemen</p>
                    </div>
                    <div class="blockCardPricing">
                        <div class="circleSpanEigen"></div>
                        <p>Begeleiding voor gehele organisatie</p>
                    </div>
                    <div class="footerCardSkills">
                        <img class="footerFlecheImg" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill0.png" alt="">
                        <p>Lees alles voor <br> Organisaties </p>
                        <img id="footerFooterImg3" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill3.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>