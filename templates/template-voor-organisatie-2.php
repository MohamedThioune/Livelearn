<?php /** Template Name: Voor organisaties2 */ ?>


<?php wp_head(); ?>
<meta name="description" content="Fluidify">
<meta name='keywords' content="fluidify">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta property="og:image" content="<?php echo get_stylesheet_directory_uri() . '/img/logo_livelearn.png' ?>">

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>

<div class="content-voor-2">
    <div class="block-logo">
        <a href="/">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/LiveLearn_logo.png" class="" alt="">
        </a>
    </div>
    <section class="firstSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="content-detail-voor-organisation position-relative">
                        <h1>Creëer een constant lerende organisatie en trek talent aan</h1>
                        <p>Stimuleer de in- en doorstroom van jouw (flexibele) werknemers, zodat zij jouw bedrijf naar het volgende niveau kunnen tillen.</p>
                        <a href="/overview-organisaties/ " class="meerInformatieBtn" >Meer informatie</a>
                    </div>
                    <div class="img-block">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/voor-oraganisatie-2.png" class="" alt="">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="blockForm2">
                        <p class="title-form-organisatie">Activeer zakelijke Leeromgeving</p>
                        <p class="gratis-text">Gratis</p>
                        <?php
                        echo do_shortcode("[gravityform id='5' title='false' description='false' ajax='true']");
                        ?>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-center block-hr-strat">
                <hr>
                <div class="block-start d-flex align-items-center justify-content-center">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Group_301.png" class="" alt="">
                    <p class="mb-0">(8,1)</p>
                </div>
                <hr>
            </div>
            <h2 class="title-zij">Zij gebruiken al LiveLearn</h2>
            <div class="block-logo-parteners2">
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
        </div>
    </section>
    <section class="block-contact-teams">
        <div class="container-fluid">
            <h3>Direct iemand spreken van ons team?</h3>
            <button onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;" class="btn btn-plan">Plan een afspraak</button>
        </div>
    </section>
</div>



<?php get_footer(); ?>
<?php wp_footer(); ?>