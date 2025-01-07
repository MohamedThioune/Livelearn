<?php /** Template Name: faq */ ?>

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

<?php
//Woocommerce php 
// require __DIR__ . '/../vendor/autoload.php';
// use Automattic\WooCommerce\Client;

// require('module-subscribe.php'); 

// $woocommerce = new Client(
// 'https:www.livelearn.nl/',
// 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
// 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
// [
//     'version' => 'wc/v3', // WooCommerce WP REST API version
// ]
// );
// $endpoint = "subscriptions";
// $subscriptions = $woocommerce->get($endpoint, $parameters = []);

// var_dump($subscriptions);
?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
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
                <h1 class="wordDeBestText2">Vragen? Dan ben je hier goed.</h1>
                <p class="description">Staat het antwoord er niet bij? Plan dan direct een afspraak met ons in.</p>
                <button class="btn btn-kies" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;">Kies een datum</button>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="content-faq">
            <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-Onderwerpen-tab" data-bs-toggle="pill" data-bs-target="#v-Onderwerpen" type="button" role="tab" aria-controls="v-Onderwerpen" aria-selected="true">Onderwerpen</button>
                    <button class="nav-link" id="v-Algemeen-tab" data-bs-toggle="pill" data-bs-target="#v-Algemeen" type="button" role="tab" aria-controls="v-Algemeen" aria-selected="false">Algemeen</button>
                    <button class="nav-link" id="v-Voor-leerders-tab" data-bs-toggle="pill" data-bs-target="#v-Voor-leerders" type="button" role="tab" aria-controls="v-Voor-leerders" aria-selected="false">Voor leerders</button>
                    <button class="nav-link" id="v-Voor-organisaties-tab" data-bs-toggle="pill" data-bs-target="#v-Voor-organisaties" type="button" role="tab" aria-controls="v-Voor-organisaties" aria-selected="false">Voor organisaties</button>
                    <button class="nav-link" id="v-Voor-experts-eachers-tab" data-bs-toggle="pill" data-bs-target="#v-Voor-experts-eachers" type="button" role="tab" aria-controls="v-Voor-experts-eachers" aria-selected="false">Voor experts / teachers</button>
                    <button class="nav-link" id="v-Functionaliteiten-tab" data-bs-toggle="pill" data-bs-target="#v-Functionaliteiten" type="button" role="tab" aria-controls="v-Functionaliteiten" aria-selected="false">Functionaliteiten</button>
                    <button class="nav-link" id="v-Betalingen-tab" data-bs-toggle="pill" data-bs-target="#v-Betalingen" type="button" role="tab" aria-controls="v-Betalingen" aria-selected="false">Betalingen</button>
                    <button class="nav-link" id="v-Veiligheid-tab" data-bs-toggle="pill" data-bs-target="#v-Veiligheid" type="button" role="tab" aria-controls="v-Veiligheid" aria-selected="false">Veiligheid</button>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-Onderwerpen" role="tabpanel" aria-labelledby="v-Onderwerpen-tab">

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Kan ik een leeromgeving hebben zonder werkgever?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Hoe voeg ik onderwerpen toe aan mijn leeromgeving?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Werken de mobiele app en website hetzelfde?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="v-Algemeen" role="tabpanel" aria-labelledby="v-Algemeen-tab">Algemeen</div>
                    <div class="tab-pane fade" id="v-Voor-leerders" role="tabpanel" aria-labelledby="v-Voor-leerders-tab">Voor-leers</div>
                    <div class="tab-pane fade" id="v-Voor-organisaties" role="tabpanel" aria-labelledby="v-Voor-organisaties-tab">Voor-organisaties</div>
                    <div class="tab-pane fade" id="v-Voor-experts-eachers" role="tabpanel" aria-labelledby="v-Voor-experts-eachers-tab">Voor-experts-eachers</div>
                    <div class="tab-pane fade" id="v-Functionaliteiten" role="tabpanel" aria-labelledby="v-Functionaliteiten-tab">FUNCT</div>
                    <div class="tab-pane fade" id="v-Betalingen" role="tabpanel" aria-labelledby="v-Betalingen-tab">Betalingen</div>
                    <div class="tab-pane fade" id="v-Veiligheid" role="tabpanel" aria-labelledby="v-Veiligheid-tab">Veiligheid</div>
                </div>
            </div>
        </div>
    </div>

</div>



<?php get_footer(); ?>
<?php wp_footer(); ?>


<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>