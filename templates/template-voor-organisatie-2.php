<?php /** Template Name: Voor organisaties2 */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />


<div class="content-voor-2">
    <section class="firstSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="content-detail-voor-organisation">
                        <h1>Creëer een constant lerende organisatie en trek talent aan</h1>
                        <p>Stimuleer de in- en doorstroom van jouw (flexibele) werknemers, zodat zij jouw bedrijf naar het volgende niveau kunnen tillen. </p>
                        <a href="" class="btn btnMeerInformation">Meer informatie ?</a>
                    </div>
                    <div class="img-block">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/voor-oraganisatie-2.png" class="" alt="">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="blockForm2">
                        <p><b>Activeer zakelijke Leeromgeving</b> <br>het is gratis </p>
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
            <a href="" class="btn btn-plan">Plan een afspraak</a>
        </div>
    </section>
</div>


<?php get_footer(); ?>
<?php wp_footer(); ?>