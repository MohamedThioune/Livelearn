<?php /** Template Name: Voor organisaties2 */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />


<div class="content-voor-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="content-detail-voor-organisation">
                    <h1>Creëer een constant lerende organisatie en trek talent aan</h1>
                    <p>Stimuleer de in- en doorstroom van jouw (flexibele) werknemers, zodat zij jouw bedrijf naar het volgende niveau kunnen tillen. </p>
                    <a href="" class="btn btnMeerInformation">Meer informatie ?</a>
                </div>
                <div class="img-block-">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/voor-oraganisatie-2.png" alt="">
                </div>
            </div>
            <div class="col-md-3">
                <div class="blockForm2">
                    <p><b>Activeer zakelijke Leeromgeving</b> <br>het is gratis </p>
                    <?php
                    echo do_shortcode("[gravityform id='5' title='false' description='false' ajax='true']");
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
<?php wp_footer(); ?>