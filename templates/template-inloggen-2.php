<?php /** Template Name: Inloggen 2 */ ?>

<?php get_header(); ?>
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

<div class="content-voor-2 content-inloggen">
    <div class="block-logo">
        <a href="/">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/livelearn-logo-blanc.png" class="" alt="">
        </a>
    </div>
    <section class="firstSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="content-detail-voor-organisation">
                        <h1>Blijf je leven lang ontwikkelen</h1>
                        <p>Een leeromgeving die speciaal voor jou gemaakt is. Jij bepaalt de content die je te zien krijgt, de experts en opleiders die je volgt en de onderwerpen die je interessant vindt. Wij zorgen dat jij je ontwikkelt!</p>
                        <div class="groupBtnInloggenVoor d-flex">
                            <a href="/about" class="btn btnLeesMeer">Lees meer</a>
                            <a href="/overview-organisaties/" class="btn btnBedrijven">LiveLearn voor bedrijven</a>
                        </div>
                    </div>
                    <p class="text-download">Of download onze gratis app:</p>
                    <div class="d-flex ">
                        <a href="https://apps.apple.com/nl/app/livelearn/id1666976386" class="btn btnStore">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/e-store.png" alt="">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.livelearn.livelearn_mobile_app" id="playBtnGoogle" class="btn btnPlayGoogle">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/playGoogle.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="blockForm2">
                        <p><b>Maak jouw Leeromgeving nu</b></p>
                        <div class="form-block">
                            <h2>Sign into Your Account</h2>

                            <?php
                        
                            $redirect = "/dashboard/user/";
                            if(isset($_GET['login'])) {
                                if ($_GET['login'] == 'failed')
                                    echo "<span class='alert alert-error' style='color:red'>Failed to login, informations are incorrect</span>";
                            }
                            if (isset($_GET['redirect']) && isset($_GET['message'])) {
                                echo "<span class='alert alert-error' style='color: red'>". $_GET['message'] ."</span>";
                                $redirect = $_GET['redirect'];
                            }
                            ?>
                            <?php
                            wp_login_form([
                                'redirect' => $redirect,
                                'remember' => false,
                                'label_username' => 'Wat is je e-mailadres?',
                                'placeholder_email' => 'E-mailadress',
                                'label_password' => 'Wat is je wachtwoord?'
                            ]);
                            ?>
                            <a href="<?= wp_lostpassword_url(''); ?>" class="redirectionText">Wachtwoord vergeten ?&nbsp; | &nbsp;</a>
                            <a href="/registreren" class="redirectionText pull-right">Maak je account </a>
                        </div>
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