<?php /** Template Name: HR dienstverlening */ ?>

<?php
/** Mollie API client for php **/

// $mollie = new \Mollie\Api\MollieApiClient();
// $mollie->setApiKey("test_c5nwVnj42cyscR8TkKp3CWJFd5pHk3");

// $payments = $mollie->payments->page();

// var_dump($payments[0]->id);
?>

<?php
/** Woocommerce API client for php **/

// require __DIR__ . '/../vendor/autoload.php';

// use Automattic\WooCommerce\Client;

// $woocommerce = new Client(
//   'https://www.livelearn.nl/',
//   'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
//   'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
//   [
//     'version' => 'wc/v3',
//   ]
// );

// $endpoint = "subscriptions/9260/orders";
// $subscription_orders = $woocommerce->get($endpoint, $parameters = []);

// var_dump($subscription_orders);

?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

<div class="content-community-overview content-hr">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/gratis.png" class="img-head-about" alt="">
                <h1 class="wordDeBestText2">HR Dienstverlening</h1>
            </div>
        </div>
    </section>
    <div class="container-fluid">

        <section class="section-ontedek text-center">
            <h2>De revolutionaire HR-dienstverlening die de war-on-talent en digitalisering verslaat!</h2>
            <p class="description">Onze HR dienstverlening staat op het snijvlak van verandering en innovatie. In een tijd waarin digitalisering en de war-on-talent de norm zijn geworden, begrijpen wij de behoefte aan vernieuwing.</p>
            <p class="description">Daarom hebben wij als LiveLearn een geheel nieuwe dienstverlening ontwikkeld die inspeelt op deze HR trends. Met onze expertise en geavanceerde technologieën creëren we een moderne, digitale HR-ervaring die bijvoorbeeld jouw wervingsproces stroomlijnt, talentontwikkeling stimuleert en de employee journey verbetert. Onze innovatieve aanpak zorgt ervoor dat organisaties kunnen groeien en bloeien in de snel veranderende wereld van HR. Samen zetten we de nieuwe standaard in human resource management.</p>
        </section>

        <section class="section-card-voor">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card-gradient">
                        <p class="title-card">HR Consultancy</p>
                        <p class="description-card">Strategisch HR-advies voor het ontwikkelen van een wendbare, talentgerichte organisatie.</p>
                        <div class="w-100">
                            <a href="/voor-jou">Lees meer</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card-gradient">
                        <p class="title-card">HR Interim</p>
                        <p class="description-card">Flexibele HR-expertise op maat om uw organisatie te ondersteunen en HR-doelen te realiseren.</p>
                        <div class="w-100">
                            <a href="/voor-opleiders/">Lees meer</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="theme-card-gradient">
                        <p class="title-card">IT implementatie</p>
                        <p class="description-card">Verbeterde HR-processen, geautomatiseerd beheer, succesvolle implementatie van HR-software.</p>
                        <div class="w-100">
                            <a href="/voor-organisaties/">Lees meer</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-Onze-aanpak">
            <h2>Onze aanpak</h2>
            <p class="description">De LiveLearn methode is net anders dan andere HR partijen. Bij LiveLearn combineren we persoonlijke begeleiding en technologie om onze partners de beste ervaring te bieden. Wij begrijpen ook dat het ontwikkelen van talent niet altijd op de eerste plaats staat binnen een organisatie. Daarom maken wij onze services en software zo eenvoudig mogelijk, zodat er geen tijd verloren gaat. </p>
            <p class="description">Wat doen wij dan als LiveLearn? Wij werken altijd datagedreven en beredeneren HR vanuit de individuele werknemer. Dit klinkt als een klein verschil, maar heeft op organisatie niveau enorme impact. Wij koppelen namelijk alle wensen en doelen van de individuele medewerker en bieden hen een persoonlijk, datagedreven oplossing. Zo kunnen zij persoonlijk groeien en dus jij als organisatie.  Alle data wordt geanonimiseerd en teruggekoppeld naar de organisatie, zodat deze vanuit real-time informatie beslissingen kan nemen.</p>
            <a href="/about/" class="btn btn-Lees-meer-aanpak">Lees meer</a>
        </section>
        <div class="data-gedreven-block">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/vector-stratup.png" class="" alt="">
            <p class="description">Onze dienstverlening gaat verder dan alleen learning & development!</p>
        </div>
        <section class="section-three-card">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <a href="/zzpers/" class="card-theme-bleu">
                        <div class="head-img">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/vector-stratup.png" class="" alt="">
                        </div>
                        <div class="body-card">
                            <p class="title">Startups en Scale-ups</p>
                            <p class="description">Onze HR-oplossing voor startups biedt een uitgebreid pakket aan diensten om de volledige HR-infrastructuur op te zetten. Van het ontwikkelen van beleid en processen tot werving, onboarding en talentbeheer, wij ondersteunen start- en scale-ups in elke fase van hun groei met professioneel HR-advies en praktische implementatie.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="/sme" class="card-theme-bleu">
                        <div class="head-img">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/vector-midden.png" class="" alt="">
                        </div>
                        <div class="body-card">
                            <p class="title">Midden en Klein bedrijf</p>
                            <p class="description">Onze uitgebreide HR-oplossing voor MKB-bedrijven omvat zowel consultancy als interim-ondersteuning. Wij helpen bij het opzetten van een solide HR-infrastructuur, bieden strategisch advies of leveren flexibele interim-professionals om uw organisatie te ondersteunen tijdens groeifasen en veranderingen.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <a href="/corporate/" class="card-theme-bleu">
                        <div class="head-img">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/vector-Grootbedrijf.png" class="" alt="">
                        </div>
                        <div class="body-card">
                            <p class="title">Grootbedrijf</p>
                            <p class="description">Onze HR-oplossing voor corporate bedrijven combineert consultancy en interim-ondersteuning om specifieke HR-doelstellingen te realiseren. Met data-gedreven inzichten en voorbeelden helpen we bij het oplossen van complexe uitdagingen, zoals talentmanagement, diversiteit en inclusie, organisatieverandering en meer.</p>
                        </div>
                    </a>
                </div>
            </div>
        </section>
        <section class="block-about">
            <div class="frist-block-about">
                <div class="Ons-verhaal-block">
                    <h2 class="subTitle-about">Wanneer vooral niet met ons te werken.</h2>
                    <p class="description-about">Als innovatie, digitalisering en goed werkgeverschap geen prioriteit voor je zijn, is het wellicht niet raadzaam om met ons samen te werken. Wij zijn toegewijd aan vooruitstrevende HR-oplossingen en het creëren van moderne, efficiënte werkomgevingen. Onze focus ligt op het helpen van organisaties die streven naar groei, concurrentievoordeel en het aantrekken van talent.</p>
                    <a href="/zzpers/" class="btn btn-doe-jij">Jij wel? Neem dan contact op</a>
                </div>
                <div class="block-img-about">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/individuals-women.png" class="img-head-about" alt="">
                </div>
            </div>
        </section>
        <section class="section-zoek">
            <h2>Op zoek naar inspiratie?</h2>
            <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">

                <a href="" class="new-card-course">
                    <div class="head">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sport.jpg" alt="">
                    </div>
                    <div class="title-favorite d-flex justify-content-between align-items-center">
                        <p class="title-course">ACQUREREN IS WERVEN’</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                        <div class="blockOpein d-flex align-items-center">
                            <i class="fas fa-graduation-cap"></i>
                            <p class="lieuAm">Artikel</p>
                        </div>
                        <div class="blockOpein">
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="lieuAm">Online</p>
                        </div>
                    </div>
                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="blockImgUser">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                            </div>
                            <p class="autor">Daniel</p>
                        </div>
                        <p class="price">Free</p>
                    </div>

                </a>
                <a href="" class="new-card-course">
                    <div class="head">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sport.jpg" alt="">
                    </div>
                    <div class="title-favorite d-flex justify-content-between align-items-center">
                        <p class="title-course">ACQUREREN IS WERVEN’</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                        <div class="blockOpein d-flex align-items-center">
                            <i class="fas fa-graduation-cap"></i>
                            <p class="lieuAm">Artikel</p>
                        </div>
                        <div class="blockOpein">
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="lieuAm">Online</p>
                        </div>
                    </div>
                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="blockImgUser">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                            </div>
                            <p class="autor">Daniel</p>
                        </div>
                        <p class="price">Free</p>
                    </div>

                </a>
                <a href="" class="new-card-course">
                    <div class="head">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sport.jpg" alt="">
                    </div>
                    <div class="title-favorite d-flex justify-content-between align-items-center">
                        <p class="title-course">ACQUREREN IS WERVEN’</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                        <div class="blockOpein d-flex align-items-center">
                            <i class="fas fa-graduation-cap"></i>
                            <p class="lieuAm">Artikel</p>
                        </div>
                        <div class="blockOpein">
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="lieuAm">Online</p>
                        </div>
                    </div>
                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="blockImgUser">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                            </div>
                            <p class="autor">Daniel</p>
                        </div>
                        <p class="price">Free</p>
                    </div>

                </a>
                <a href="" class="new-card-course">
                    <div class="head">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sport.jpg" alt="">
                    </div>
                    <div class="title-favorite d-flex justify-content-between align-items-center">
                        <p class="title-course">ACQUREREN IS WERVEN’</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                        <div class="blockOpein d-flex align-items-center">
                            <i class="fas fa-graduation-cap"></i>
                            <p class="lieuAm">Artikel</p>
                        </div>
                        <div class="blockOpein">
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="lieuAm">Online</p>
                        </div>
                    </div>
                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="blockImgUser">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                            </div>
                            <p class="autor">Daniel</p>
                        </div>
                        <p class="price">Free</p>
                    </div>

                </a>
                <a href="" class="new-card-course">
                    <div class="head">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sport.jpg" alt="">
                    </div>
                    <div class="title-favorite d-flex justify-content-between align-items-center">
                        <p class="title-course">ACQUREREN IS WERVEN’</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                        <div class="blockOpein d-flex align-items-center">
                            <i class="fas fa-graduation-cap"></i>
                            <p class="lieuAm">Artikel</p>
                        </div>
                        <div class="blockOpein">
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="lieuAm">Online</p>
                        </div>
                    </div>
                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="blockImgUser">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                            </div>
                            <p class="autor">Daniel</p>
                        </div>
                        <p class="price">Free</p>
                    </div>

                </a>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.lazyload.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>
<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:13,
        items:3.4,
        lazyLoad:true,
        responsiveClass:true,
        autoplayHoverPause:true,
        nav:false,
        merge:true,
        URLhashListener:true,
        responsive:{
            0:{
                items:1.1,
                nav:true
            },
            600:{
                items:2.2,
                nav:false
            },
            1000:{
                items:3.4,
                nav:true,
                loop:false
            }
        }
    })
</script>

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