<?php /** Template Name: Voor teacher2 */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />


<div class="content-voor-2 content-voor-teacher-2">
    <section class="firstSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="content-detail-voor-organisation">
                        <h1>Word onderdeel van het grootste expert & opleidersnetwerk</h1>
                        <p>Deel jouw kennis met de rest van de wereld.</p>
                        <a href="" class="btn btnMeerInformation">Meer informatie ?</a>
                    </div>
                    <div class="img-block">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Informatiesessie-LiveLearn.png" class="" alt="">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="blockForm2">
                        <p><b>Aanmelden expert of opleider</b></p>
                        <form action="" class="form-Voor-teacher2">
                            <div class="input-group">
                                <input type="text" placeholder="Voornaam*">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Achternaam*">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Bedrijf*">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="E-mailadres*">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Telefoonnummer*">
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="Functie*">
                            </div>
                            <button type="submit" class="btn btn-omgeving">Creëer je omgeving</button>
                        </form>
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