<?php /** Template Name: about */ ?>


<body>
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
    .content-community-overview .boxOne3-1 {
        height: 270px;
    }





    }


</style>

<div class="content-community-overview">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Probeer.png" class="img-head-about" alt="">
                <h1 class="wordDeBestText2">Over LiveLearn</h1>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <section class="block-about">
            <div class="frist-block-about">
                <div class="Ons-verhaal-block">
                    <h2 class="subTitle-about">Ons verhaal</h2>
                    <p class="description-about">LiveLearn is opgericht in 2019 door Daniel van der Kolk met als doel om leren en ontwikkelen beschikbaar te maken voor iedereen. Dit omdat organisaties en vooral het midden-klein-bedrijf het lastig vond om talent aan te trekken en vast te houden, maar ook omdat organisaties niet in staat waren hun personeel voldoende op te leiden, zodat zij de gewenste kwaliteit konden leveren.</p>
                    <p class="description-about">Nu hoor LiveLearn bij één van de meest innovatieve partners voor organisaties om hun personeel op te leiden.</p>
                </div>
                <div class="block-img-about">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/For-individuals.png" class="img-head-about" alt="">
                </div>
            </div>
        </section>
        <section class="section-category">
            <h2 class="subTitle-about">Onze aanpak</h2>
            <p class="description-about">LiveLearn is opgericht in 2019 door Daniel van der Kolk met als doel om leren en ontwikkelen beschikbaar te stellen voor iedereen. Dit omdat organisaties en vooral het midden-klein-bedrijf het lastig vond om talent aan te trekken en vast te houden, maar ook omdat organisaties niet in staat waren hun personeel voldoende op te leiden, zodat zij de gewenste kwaliteit konden leveren.</p>
            <p class="description-about">Nu hoor LiveLearn bij één van de meest innovatieve partners voor organisaties om hun personeel op te leiden.</p>
            <div class="group-icon-category">
                <div class="element-category">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-Leerdoelen.png" class="" alt="icon-Leerdoelen">
                    <p class="name-category">1. Leerdoelen</p>
                </div>
                <div class="element-category">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-Meten-business.png" class="" alt="icon-Leerdoelen">
                    <p class="name-category">2. Meten business</p>
                </div>
                <div class="element-category">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-medewerkers.png" class="" alt="icon-Leerdoelen">
                    <p class="name-category">3. Behoeften medewerkers</p>
                </div>
                <div class="element-category">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-Tech.png" class="" alt="icon-Leerdoelen">
                    <p class="name-category">4. Inrichten Tech</p>
                </div>
                <div class="element-category">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-Stimuleren.png" class="" alt="icon-Leerdoelen">
                    <p class="name-category">5. Stimuleren</p>
                </div>
            </div>
            <div class="data-gedreven-block">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-data-gedreven.png" class="" alt="">
                <p class="description">Compleet data gedreven, beveiligd en met de medewerker centraal.</p>
            </div>
            <div class="frist-block-about">
                <div class="Ons-verhaal-block">
                    <h2 class="subTitle-about">MVO en opleiden talent</h2>
                    <p class="description-about">LiveLearn is opgericht in 2019 door Daniel van der Kolk met als doel om leren en ontwikkelen beschikbaar te stellen voor iedereen. Dit omdat organisaties en vooral het midden-klein-bedrijf het lastig vond om talent aan te trekken en vast te houden, maar ook omdat organisaties niet in staat waren hun personeel voldoende op te leiden, zodat zij de gewenste kwaliteit konden leveren.</p>
                    <p class="description-about">Nu hoor LiveLearn bij één van de meest innovatieve partners voor organisaties om hun personeel op te leiden.</p>
                </div>
                <div class="block-img-about">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/teams.png" class="img-head-about" alt="">
                </div>
            </div>
        </section>
        <section class="team-section">
            <h2>The LiveLearn Team</h2>
            <div class="team-block">
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Fadel.png" class="" alt="">
                    <p class="name">FADEL</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice.png" class="" alt="">
                    <p class="name">MAURICE</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Seydou.png" class="" alt="">
                    <p class="name">SEYDOU</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Daniel-van-der.png" class="" alt="">
                    <p class="name">DANIEL</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Mamadou.png" class="" alt="">
                    <p class="name">MAMADOU</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Xander.png" class="" alt="">
                    <p class="name">XANDER</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/inco.png" class="" alt="">
                    <p class="name">MOHAMED</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/inco.png" class="" alt="">
                    <p class="name">OUMOU</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Ibrahima.png" class="" alt="">
                    <p class="name">IBRAHIMA</p>
                </div>
                <div class="one-element">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/You-next.png" class="" alt="">
                    <p class="name">YOU?</p>
                </div>
            </div>
        </section>
        <section class="uiteindelijke-section">
            <h3>Ons uiteindelijke doel</h3>
            <p class="description">Mensen toegang geven tot kennis én vaardigheden om hen een eerlijke kans op de wereldwijde arbeidsmarkt te geven.</p>
            <div class="uiteindelijke-block">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/people-about.png" class="people-about" alt="">
                <div class="number-uiteindelijke">
                    <p>1</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
                <div class="number-uiteindelijke">
                    <p>0</p>
                </div>
            </div>
            <p class="description">Doe jij met ons mee?</p>`
            <button class="btn btn-scroll-down">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/arrow-round-down.png" class="people-about" alt="">
            </button>

        </section>
    </div>
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