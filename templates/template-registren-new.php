<?php /** Template Name: Registeren-new */ ?>


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

<div class="content-new-inloggen">
    <div class="d-flex block-reverse flex-wrap">
        <div class="block-first-connect">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/register1.png" alt="First-slide-looggin">
                        </div>
                        <h1>Welkom bij LiveLearn</h1>
                        <p class="description-connection">Registreer nu jouw gratis leeromgeving en ontdek de wereld van een leven lang ontwikkelen!</p>
                    </div>
                    <div class="carousel-item">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/register2.png" alt="First-slide-looggin">
                        </div>
                        <h1>Ben jij een expert of opleider?</h1>
                        <p class="description-connection">Meld je nu aan en deel je kennis met ons enthousiaste publiek. De kansen liggen voor het grijpen!</p>
                    </div>
                    <div class="carousel-item">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/register3.png" alt="First-slide-looggin">
                        </div>
                        <h1>Je team of bedrijf laten groeien?</h1>
                        <p class="description-connection">Ontgrendel het potentieel van je bedrijf door het ontwikkelen van het talent van je medewerkers. Samen bouwen we aan een succesvolle toekomst.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-second-connect">
            <div class="right-block-connection">
               <div class="block-connection block-registren">
                   <div class="container-fluid">
                       <div class="d-flex justify-content-between align-items-center">
                           <div class="logo-liverlearn-connection">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/logolivelearnconnection.png" alt="First-slide-looggin">
                           </div>
                           <a class="back-to-home-text" href="/">Back To Home</a>
                       </div>
                       <h2>Sign Up</h2>
                        <?php 
                            $base_url = get_site_url();
                            if($base_url == 'https://livelearn.nl')
                                echo (do_shortcode('[user_registration_form id="8477"]'));
                            else
                                echo (do_shortcode('[user_registration_form id="59"]')); 
                        ?>
                   </div>
               </div>
               <div class="block-social-connection">
                   <h3>Or Sign up with</h3>
                   <div class="group-btn-connection">
                        <a href="<?php echo get_site_url() ?>/fluidify/?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="btn btn-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/net-icon-google.png" alt="First-slide-looggin">
                            Sign Up using Google
                        </a>
                   </div>
                   <p class="new-user-text">You have a account ? <a href="/inloggen-2">Login</a></p>
               </div>
            </div>
        </div>
    </div>
</div>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $('.carousel').carousel({
        interval: 3000
    })
</script>

<script>
    jQuery(document).ready(function(){
        jQuery('#').attr('placeholder', 'Enter your email address');
        jQuery('#').attr('placeholder', 'Enter your password');
    });
</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>