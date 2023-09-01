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
                    <p class="description-about">LiveLearn is opgericht in 2019 door Daniel van der Kolk met als doel om leren en ontwikkelen toegankelijk te maken voor iedereen. Dit omdat organisaties en vooral het midden-klein-bedrijf een uitdaging heeft om talent aan te trekken en vast te houden, maar ook omdat organisaties vaak moeite hebben om hun personeel voldoende op te leiden.</p>
                    <p class="description-about">Door het individu centraal te stellen en managers inzicht te geven in de ontwikkeling van hun team(s) wordt talent-ontwikkeling voor elke organisatie mogelijk.  LiveLearn hoort bij één van de meest innovatieve partners voor organisaties om hun personeel op te leiden.  </p>
                    <a href="/voor-jou/" class="btn btn-doe-jij">Doe jij mee?</a>
                </div>
                <div class="block-img-about">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/For-individuals.png" class="img-head-about" alt="">
                </div>
            </div>
        </section>
        <section class="section-category">
            <h2 class="subTitle-about">Onze aanpak</h2>
            <p class="description-about">De LiveLearn methode is net anders dan de traditionele learning & development partijen. Bij LiveLearn combineren we persoonlijke begeleiding en technologie om onze partners de beste ervaring te bieden. Wij begrijpen ook dat het ontwikkelen van talent niet altijd op de eerste plaats staat binnen een organisatie. Daarom maken wij onze software zo eenvoudig mogelijk, zodat er geen tijd verloren gaat. </p>
            <p class="description-about">Wat doen wij dan als LiveLearn? Wij werken altijd datagedrevene en beredeneren ontwikkeling vanuit de individuele werknemer. Dit klinkt als een klein verschil, maar heeft op organisatie niveau enorme impact. Wij koppelen namelijk alle wensen en doelen van de individuele medewerker en bieden hen een persoonlijk, datagedreven, leeromgeving. Zo kunnen zij persoonlijk groeien. Alle data wordt geanonimiseerd en teruggekoppeld naar de manager, zodat deze vanuit real-time informatie beslissingen kan nemen. </p>
            <a href="/gratis/" class="btn btn-doe-jij">Lees onze gehele aanpak</a>
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
                    <p class="description-about">Het LiveLearn team is gevestigd in Nederland en heeft een deel van haar IT capaciteiten gevestigd in Senegal, West-Afrika. Wij geloven dat het niet uit maakt waar talent gevestigd is en door hen de juiste handvatten te geven een wereldwijde workforce gerealiseerd kan worden. </p>
                    <p class="description-about">Onze samenwerking met Orange maakt het mogelijk om een grote pool van talent aan te trekken en verder op te leiden. Zo implementeren wij onze filosofie ook binnen de eigen organisatie. </p>
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
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Fadel.png" class="" alt="">
                    </div>
                    <p class="name">FADEL</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice.png" class="" alt="">
                    </div>
                    <p class="name">MAURICE</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Seydou.png" class="" alt="">
                    </div>
                    <p class="name">SEYDOU</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Daniel-van-der.png" class="" alt="">
                    </div>
                    <p class="name">DANIEL</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/khadim.jpg" class="" alt="">
                    </div>
                    <p class="name">KHADIM</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Xander.png" class="" alt="">
                    </div>
                    <p class="name">XANDER</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/MOHAMED.png" class="" alt="">
                    </div>
                    <p class="name">MOHAMED</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Oumou.png" class="" alt="">
                    </div>
                    <p class="name">OUMOU</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Ibrahima.png" class="" alt="">
                    </div>
                    <p class="name">IBRAHIMA</p>
                </div>
                <div class="one-element">
                    <div class="block-img-team">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/You-next.png" class="" alt="">
                    </div>
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