<?php /** Template Name: Our Users */ ?>

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
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/our-users.png" class="img-head-about" alt="">
                <h1 class="wordDeBestText2">Onze gebruikers</h1>
            </div>
        </div>
    </section>
    <div class="container-fluid">

        <section class="section-ontedek text-center">
            <h2>Een revolutionair <span>LXP-platform</span> voor leerders, opleiders en organisaties</h2>
            <p class="description">Ontdek de kracht van ons LXP-platform waar leerders, opleiders en organisaties samenkomen. Met een gepersonaliseerde leerervaring, geavanceerde tools voor opleiders en uitgebreide analysemogelijkheden creëren we een optimaal leerproces. </p>
            <p class="description">Leerders krijgen toegang tot diverse leermaterialen, terwijl opleiders interactieve content kunnen ontwikkelen en de voortgang van leerders kunnen volgen. Voor organisaties biedt ons platform een centrale hub voor leren en ontwikkeling, waar samenwerking en kennisdeling gestimuleerd worden. Met ons LXP-platform kunnen leerders, opleiders en organisaties hun leerdoelen bereiken en groeien.</p>
            <a href="/voor-jou/" class="btn btn-doe-jij">Creëer een account</a>
        </section>

        <section class="section-card-voor">
            <div class="row">
                <div class="col-md-4">
                    <div class="theme-card-gradient">
                        <p class="title-card">Voor jou!</p>
                        <p class="description-card">Een altijd gratis leeromgeving om je oneindig door te laten groeien; word de expert in de markt.</p>
                        <div class="w-100">
                            <a href="/voor-jou/">Sign-up!</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="theme-card-gradient">
                        <p class="title-card">Voor opleiders / experts</p>
                        <p class="description-card">Ben jij een expert, opleider of coach? Unlock je teacher omgeving en deel / verkoop direct je kennis.</p>
                        <div class="w-100">
                            <a href="/voor-opleiders/">Sign-up!</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="theme-card-gradient">
                        <p class="title-card">Voor werkgevers</p>
                        <p class="description-card">Je bedrijf oneindig laten groeien, door je personeel te laten excelleren? LiveLearn is dé upskilling partner. </p>
                        <div class="w-100">
                            <a href="/voor-organisaties/">Sign-up!</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="content-functiegerichte">
        <section class="functionaliteiten">
            <div class="container-fluid">
                <div class="text-center">
                    <img class="img-functionaliteiten" src="<?php echo get_stylesheet_directory_uri();?>/img/function.png" alt="">
                </div>
                <h2>Onze functionaliteiten</h2>
                <p class="sub-title-onze">Voor individuen</p>
                <div class="tab-block-functiegerichte">
                    <div class="block-functionaliteiten d-flex flex-wrap">
                        <div class="card-functionaliteiten">
                            <div class="text-right">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/geperso.png" alt="">
                            </div>
                            <p class="title">Je gepersonaliseerde leeromgeving</p>
                            <p class="description">Jij bepaalt zelf wat je in je omgeving te zien krijgt. Kies je onderwerpen of experts en neem je omgeving ook gewoon mee naar nieuwe werkgevers.</p>
                        </div>
                        <div class="card-functionaliteiten">
                            <div class="text-right">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/mobiele.png" alt="">
                            </div>
                            <p class="title">Een mobiele app voor je dagelijkse learnings</p>
                            <p class="description">Veel onderweg en toch op de hoogte blijven van de laatste ontwikkelingen of vaardigheden. Gebruik dan onze app voor Apple of Android. </p>
                        </div>
                        <div class="card-functionaliteiten">
                            <div class="text-right">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Leervormen.png" alt="">
                            </div>
                            <p class="title">Leervormen die bij iedereen passen.</p>
                            <p class="description">We hebben 10 verschillende leervormen in het LiveLearn platform. Van het lezen van artikelen tot het volgen van een opleiding.</p>
                        </div>
                    </div>
                </div>
                <a href="/functionaliteiten/" class="btn btn-Bekijk">Bekijk al onze functionaliteiten</a>
            </div>

        </section>

    </div>

    <section class="block-contact-calendy text-center">
        <div class="container-fluid">
            <div class="block-logo-parteners2 logo-users">
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/vanSpaendockLogo.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/orangeLogo.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/manpowerLogo.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/openclassroomLogo.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/zelfstanLogo.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/uwvLogo.png" alt="">
                </div>
                <div class="logo-element">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Deloitte.png" alt="">
                </div>
            </div>
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