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
                <a href="/static-education-advice">
                    <div class="cardPricing">
                        <p class="titleCardPPricing">Individueel skills paspoort</p>
                        <p class="sousTitlePricing">Altijd gratis</p>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <p>Eigen leeromgving</p>
                        </div>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-tag"></i>
                            </div>
                            <p>Top wel 65% korting op scholing</p>
                        </div>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-comments"></i>
                            </div>
                            <p>24/7 toegang tot carriereadvies</p>
                        </div>
                        <div class="footerCardSkills">
                            <img class="footerFlecheImg" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill0.png" alt="">
                            <p>Lees alles voor <br> individuen </p>
                            <img id="footerFooterImg1" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill1.png" alt="">
                        </div>
                    </div>
                </a>    
            </div>
            <div class="col-md-4">
                <a href="/overview-organisations-5">
                    <div class="cardPricing" id="cardPricing2">
                        <p class="titleCardPPricing">Deel jouw kennis / vaardigheden</p>
                        <p class="sousTitlePricing">No cure no pay</p>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <p>Eigen teacher portaal</p>
                        </div>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa fa-bar-chart"></i>
                            </div>
                            <p>Statistieken en best practices</p>
                        </div>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                            </div>
                            <p>Zichtbaarheid bij 250+ klanten</p>
                        </div>
                        <div class="footerCardSkills">
                            <img class="footerFlecheImg" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill0.png" alt="">
                            <p>Lees alles voor <br> Opleiders </p>
                            <img id="footerFooterImg2" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill2.png" alt="">
                        </div>
                    </div>
                </a>    
            </div>
            <div class="col-md-4">
                <a href="/overview-organisaties">
                    <div class="cardPricing" id="cardPricing3">
                        <p class="titleCardPPricing">Upskill jouw team / organisatie</p>
                        <p class="sousTitlePricing">€4,95 p.m.</p>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-bullseye" aria-hidden="true"></i>
                            </div>
                            <p>Een organisatie portaal</p>
                        </div>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-link" aria-hidden="true"></i>
                            </div>
                            <p>Koppelingen met huidige systemen</p>
                        </div>
                        <div class="blockCardPricing">
                            <div class="circleSpanEigen">
                                <i class="fas fa-directions"></i>
                            </div>
                            <p>Begeleiding voor gehele organisatie</p>
                        </div>
                        <div class="footerCardSkills">
                            <img class="footerFlecheImg" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill0.png" alt="">
                            <p>Lees alles voor <br> Organisaties </p>
                            <img id="footerFooterImg3" src="<?php echo get_stylesheet_directory_uri(); ?>/img/ImgSkill3.png" alt="">
                        </div>
                    </div>
                </a>    
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>