<?php /** Template Name: contact */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>

<style>
    .headerdashboard,.navModife {
        background: #deeef3;
        color: #ffffff !important;
        border-bottom: 0px solid #000000;
        background: linear-gradient(165deg, hsla(195, 48%, 92%, 1) 49%, hsla(200, 18%, 97%, 1) 100%);
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



    }


</style>

<div class="content-contact">

    <section class="first-section-contact">
        <div class="container-fluid">
            <h1>Let’s talk!</h1>
            <p class="description">Hulp nodig of heb je vragen over LiveLearn? Wij zijn er om je te helpen.</p>
            <div class="containe-block-contact">
                <div class="card-contact content-Krijg-hulp">
                    <div class="block-img-contact">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-phone.png" alt="">
                    </div>
                    <p class="title-card-contact">Krijg hulp</p>
                    <p class="description-card-contact">Praat direct met één van onze experts en vraag alles over LiveLearn.</p>
                    <button onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;" class="btn btn-info-contact">Informatie</button>
                </div>

                <div class="card-contact content-Probeer">
                    <div class="block-img-contact">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Probeer.png" alt="">
                    </div>
                    <p class="title-card-contact">Probeer LiveLearn</p>
                    <p class="description-card-contact">LiveLearn is gratis, eerst kijken? Maak dan je account óf download de app. </p>
                    <a href="/voor-jou/" class="btn btn-info-contact">Start gratis</a>
                </div>

                <div class="card-contact content-contact">
                    <div class="block-img-contact">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/sales.png" alt="">
                    </div>
                    <p class="title-card-contact">Contact Sales</p>
                    <p class="description-card-contact">Direct contact met onze verkoopafdeling. Wij helpen graag.</p>
                    <a href="/template-form/" class="btn btn-info-contact">Contact sales</a>
                </div>

                <div class="card-contact content-contact">
                    <div class="block-img-contact">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/vragen.png" alt="">
                    </div>
                    <p class="title-card-contact">Vragen ?</p>
                    <p class="description-card-contact">Bekijk de meeste voorkomende vragen over LiveLearn.</p>
                    <a href="/faq/" class="btn btn-info-contact">FAQ</a>
                </div>

                <div class="card-contact content-contact">
                    <div class="block-img-contact">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/media.png" alt="">
                    </div>
                    <p class="title-card-contact">Pers en Media </p>
                    <p class="description-card-contact">In contact komen met ons PR team, hier staan alle gegevens.</p>
                    <a href="mailto:contact@livelearn.nl" class="btn btn-info-contact">Contact pers</a>
                </div>

            </div>
        </div>
    </section>

    <section class="block-contact-calendy text-center">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="img-Direct-een">
                    <img id="firstImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Direct-een.png" alt="">
                </div>
                <div class="img-Direct-een">
                    <img id="secondImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der-Kolk.png" alt="">
                </div>
            </div>
            <h3 class="title-Direct-een"><strong>Direct een afspraak inplannen?</strong><br> Hulp nodig of heb je vragen over LiveLearn? Wij zijn er om je te helpen.</h3>
            <button class="btn btn-kies" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;">Kies een datum</button>

        </div>
    </section>
</div>

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


<?php get_footer(); ?>
<?php wp_footer(); ?>
