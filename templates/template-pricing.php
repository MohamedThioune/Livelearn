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
        <p class="sousPricing">We hebben de prijzen zo eenvoudig mogelijk proberen te maken:
            Als individu betaal je niets, als opleider / expert alleen voor nieuwe klanten en als organisatie betaal je voor gebruik.</p>
        <a href="/voor-organisaties/" class="btn btnCreeer">Creëer je omgeving gratis</a>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <a href="/Individu">
                    <div class="cardPricing">
                        <p class="titleCardPPricing">Individuele leeromgeving</p>
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
                            <p>Tot wel 65% korting op scholing</p>
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
            <div class="col-lg-4 col-md-6">
                <a href="/overview-organisations-5/">
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
            <div class="col-lg-4 col-md-6">
                <a href="/overview-organisaties/">
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
        <div class="content-Ontwikkel-je">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/group3.png" class="" alt="">
            <p>Ontwikkel je medewerker(s) al voor €59,40 per jaar!</p>
        </div>
        <div class="content-detail-pricing">
            <h2>Wat kost dat dan?</h2>
            <p class="description-ons">Ons rekenmodel is ontworpen voor eenvoud en nauwkeurigheid, met heldere tarieven en flexibiliteit om aan jouw behoeften te voldoen.</p>
            <div class="row">
                <div class="col-lg-6">
                   <div class="content-first-detail">
                       <p class="title">Bereken hoeveel LiveLearn jouw organisatie kost.</p>
                       <p class="description">Hoeveel medewerkers heeft de organisatie in dienst?</p>
                       <div class="content-Medewerkers">
                           <input type="number" id="medewerkers" name='' class="number" placeholder='' value="360" style="width: 125px;">
                           <p class="text">Medewerkers</p>
                       </div>
                       <p class="description">Elke medewerker krijgt een eigen app en complete leeromgeving. Als (HR) manager krijg je inzicht in de ontwikkelingen elke individu</p>
                   </div>
                </div>
                <div class="col-lg-6">
                    <div class="content-second-detail">
                        <div class="d-flex justify-content-between">
                            <div class="sub-block">
                                <p class="description">Automatisch gefactureerd en dynamisch aan de hand van de actieve gebruikers.</p>
                            </div>
                            <div class="sub-block">
                                <span id="autocomplete-pricing">
                                    <p class="title output">€1.782,00</p>
                                </span>
                                <p class="description" id="text-maand">Per maand</p>
                            </div>
                        </div>
                        <ul>
                            <li>+ Korting op het afnemen van leerproducten.</li>
                            <li> + Mogelijkheid langdurige samenwerkingen.</li>
                            <li> + Producttrainingen en persoonlijke begeleiding.</li>
                        </ul>
                        <a href="/voor-organisaties/" class="btn btn-do-jij">Doe jij met ons mee?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
$('#medewerkers').keyup(function(){
    var number = $(this).val();

    if(number){
        $.ajax({
            url:"/fetch-pricing",
            method:"post",
            data:{
                medewerkers: number
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $('#autocomplete-pricing').html(data);
            }
        });
    }
    else
        $('#autocomplete-pricing').html("<p class='title output'>€0,00</p>");
});
</script>

