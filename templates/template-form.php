<?php /** Template Name: template form */ ?>

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

<div class="content-community-overview content-template-form">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <h1 class="wordDeBestText2">Let’s talk !</h1>
                <p class="description">Zin om te praten? We bijten niet! Neem contact met ons op via onze contactpagina en laat ons weten hoe we je kunnen helpen. We kijken ernaar uit om van je te horen!</p>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="form-block">
            <form action="">
                <p>Hoe kunnen we je helpen?</p>
                <input type="text" placeholder="Voornaam*" class="input-template-form">
                <input type="text" placeholder="Achternaam*" class="input-template-form">
                <input type="text" placeholder="Bedrijf *" class="input-template-form">
                <input type="email" placeholder="E-mailadres*" class="input-template-form">
                <input type="number" placeholder="Telefoonnummer*" class="input-template-form">
                <textarea name="" id="" placeholder="Waarmee kunnen we je helpen?" rows="10"></textarea>
                <button class="btn btn-ons">Contacteer ons</button>
            </form>
        </div>
    </div>
    <section>
        <div class="block-contact-calendy bleu-block-contact-calendy  text-center">
            <div class="container-fluid">
                <div class="d-flex justify-content-center">
                    <div class="img-Direct-een">
                        <img id="firstImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Direct-een.png" alt="">
                    </div>
                    <div class="img-Direct-een">
                        <img id="secondImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der-Kolk.png" alt="">
                    </div>
                </div>
                <h3 class="title-Direct-een"><strong>Direct een afspraak inplannen?</strong><br> <spann>Toch liever een afspraak inplannen met ons team? Kies een datum en tijd die jou het best uitkomt.</spann></h3>
                <button class="btn btn-kies" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;">Kies een datum</button>

            </div>
        </div>
    </section>

</div>



<?php get_footer(); ?>
<?php wp_footer(); ?>


<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>