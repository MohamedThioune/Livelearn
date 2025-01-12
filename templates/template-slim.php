<?php /** Template Name: slim-subsidie */ ?>

<?php 
//$page = 'check_visibility.php';
//require($page);
?>
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
        margin-left: 8px
        margin-top: 10px;
    }
    .content-community-overview .boxOne3-1 {
        height: 270px;
    }
</style>
 
<div class="content-community-overview content-slim" id="target-block">
    <section class="boxOne3-1 position-relative boxSlim">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo-livelearn-slim.png" class="img-head-about2" alt="">
                <h1 class="wordDeBestText2">SLIM-subsidie  </h1>
                <p class="description-Slim">Boost je bedrijfsgroei met de SLIM subsidie! Meld je aan en investeer in de toekomst met financiële ondersteuning voor leren en ontwikkelen, versterk je team en vergroot je concurrentiekracht.</p>
            </div>
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/slim-img.png" class="slim-img" alt="">
        </div>
    </section>
    <div class="container-fluid" >
        <section class="first-section-slim text-center content-template-form">
            <p class="description-about">Ben je op zoek naar mogelijkheden om de groei van je medewerkers en daarmee het bedrijf te verbeteren? Dan is de Stimuleringsregeling Leren en Ontwikkelen in het mkb (SLIM) iets wat jullie niet mogen missen. Via de SLIM-subsidie streeft de overheid ernaar om leren en ontwikkelen binnen het mkb als vanzelfsprekend te beschouwen. Meld je vrijblijvend aan via het
                onderstaande formulier en dan kijken we samen hoe jouw organisatie hier het best gebruik van kan maken:</p>
            <div class="container-fluid" >
                <div class="form-block form-slim">
                    <!-- 
                    <form action="">
                        <p class="text-center">Meld je vrijblijvend aan</p>
                        <input type="text" placeholder="Voornaam*" class="input-template-form">
                        <input type="text" placeholder="Achternaam*" class="input-template-form">
                        <input type="text" placeholder="Bedrijf *" class="input-template-form">
                        <input type="email" placeholder="E-mailadres*" class="input-template-form">
                        <input type="number" placeholder="Telefoonnummer*" class="input-template-form">
                        <textarea name="" id="" placeholder="Waarmee kunnen we je helpen?" rows="10"></textarea>
                        <button class="btn btn-ons">Contacteer ons</button>
                    </form> -->
                    <?php
                        echo do_shortcode("[gravityform id='18' title='false' description='false' ajax='true']");
                    ?>
                </div>
            </div>
        </section>
        <section class="section-block-row">
            <div class="row flex-direction-modife">
                <div class="col-md-6">
                    <h2 class="title-section">Investeer in medewerker ontwikkeling in 2024</h2>
                    <p class="description-section">Wil jij in 2024 investeren in de ontwikkeling van je team en de groei van je bedrijf stimuleren? Grijp dan de kans met de Stimuleringsregeling Leren en Ontwikkelen in het mkb (SLIM). De SLIM-subsidie maakt leren en ontwikkelen een vanzelfsprekend onderdeel van jouw bedrijfspraktijk. Mis deze kans niet!
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="content-img-row-slim">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Investeer.png" class="" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="content-img-row-slim">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/wie.png" class="" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="title-section">Wie kan gebruikmaken van de SLIM-subsidie?</h2>
                    <p class="description-section">De subsidiemogelijkheden zijn toegankelijk voor alle mkb-ondernemers. Bovendien mogen ondernemingen in de landbouw, horeca en recreatiesector, zelfs als ze grootbedrijven zijn, ook een aanvraag indienen. Daarnaast kunnen samenwerkingsverbanden ook aanvragen indienen. In zo’n samenwerkingsverband kunnen niet alleen twee mkb-bedrijven participeren, maar ook werkgevers- en werknemersverenigingen, onderwijsinstellingen en een O&O-fonds (een stichting die wordt beheerd door sociale partners).</p>
                </div>
            </div>
            <div class="row flex-direction-modife">
                <div class="col-md-6">
                    <h2 class="title-section">Welke activiteiten komen in aanmerking voor subsidie?</h2>
                    <p class="description-section">De activiteiten die in aanmerking komen voor de SLIM-subsidie in 2024 dienen te passen bij tenminste één van de volgende beschrijvingen:</p>
                    <ul>
                        <li><b>1.</b> Een grondige analyse van je onderneming die resulteert in een opleidings- of ontwikkelingsplan. Dit plan moet inzicht geven in de scholingsbehoefte van je medewerkers.</li>
                        <li><b>2.</b> Het faciliteren van loopbaan- of ontwikkeladviezen voor je medewerkers.</li>
                        <li><b>3.</b> Ondersteuning bieden bij het ontwikkelen of implementeren van een methode die medewerkers stimuleert om hun kennis, vaardigheden en professionele houding verder te ontwikkelen.</li>
                        <li><b>4.</b> Het aanbieden van praktijkleerplaatsen voor een beroepsopleiding of een deel daarvan in de derde leerweg, bij een erkend leerbedrijf.</li>
                        <li>De duur van een project waarvoor een mkb-onderneming subsidie aanvraagt, mag maximaal twaalf maanden zijn. Een project uitgevoerd door een grootbedrijf of samenwerkingsverband kan maximaal 24 maanden in beslag nemen.</li>
                    </ul>
                    <button id="scroll-button" class="btn btn-Aan-slag">Aan de slag</button>
                </div>
                <div class="col-md-6">
                    <div class="content-img-row-slim">
                        <img id="welke-img" src="<?php echo get_stylesheet_directory_uri(); ?>/img/welke.png" class="" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="content-img-row-slim">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/money.png" class="" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <h2 class="title-section">Wat is het subsidiebedrag? </h2>
                    <p class="description-section">Het subsidiepercentage kan oplopen tot maximaal 80% van de subsidiabele kosten. Voor individuele bedrijven bedraagt de maximale subsidie € 24.999. Voor samenwerkingsverbanden kan dit oplopen tot maximaal € 500.000.</p>
                </div>
            </div>
            <div class="row flex-direction-modife">
                <div class="col-md-6">
                    <h2 class="title-section">Looptijd en deadlines voor de SLIM-subsidie</h2>
                    <p class="description-section">
                        De SLIM-subsidie kent jaarlijks drie periodes. Als mkb-ondernemer kun je een aanvraag indienen van 1 maart tot en met 31 maart, en van 1 september tot en met 28 september. Voor samenwerkingsverbanden en grootbedrijven is de regeling geopend van 1 juni tot en met 27 juli. Subsidieaanvragen worden behandeld in volgorde van binnenkomst. Bij overschrijding van het budget vindt er een loting plaats onder alle aanvragen die gedurende de volledige periode zijn ingediend.</p>
                </div>
                <div class="col-md-6">
                    <div class="content-img-row-slim">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Looptijd.png" class="" alt="">
                    </div>
                </div>
            </div>
                <div class="block-following">
                    <a href="https://www.linkedin.com/company/35716760/admin/feed/posts/">
                        <script src="https://platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
                        <script type="IN/FollowCompany" data-id="35716760" data-counter="bottom"></script>
                    </a>
                </div>
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
            <button class="btn btn-kies"  onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;">Kies een datum</button>

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
<script>
    const scrollButton = document.getElementById('scroll-button');
    const targetBlock = document.getElementById('target-block');

    scrollButton.addEventListener('click', function() {
        targetBlock.scrollIntoView({ behavior: 'smooth' });
    });
</script>