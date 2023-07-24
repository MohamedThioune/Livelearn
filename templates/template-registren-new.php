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
    <div class="d-flex flex-wrap">
        <div class="block-first-connect">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/new-inloggen.png" alt="First-slide-looggin">
                        </div>
                        <h1>Welcome to Livelearn</h1>
                        <p class="description-connection">Creëer in 5 minuten een gratis leeromgeving voor jouw team of organisatie.</p>
                    </div>
                    <div class="carousel-item">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/new-inloggen.png" alt="First-slide-looggin">
                        </div>
                        <h1>Welcome to Livelearn</h1>
                        <p class="description-connection">Ben jij een opleider of expert? Meld je hier aan.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-second-connect">
            <div class="right-block-connection">
               <div class="block-connection">
                   <div class="container-fluid">
                       <div class="d-flex justify-content-between align-items-center">
                           <div class="logo-liverlearn-connection">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/logolivelearnconnection.png" alt="First-slide-looggin">
                           </div>
                           <a class="back-to-home-text" href="/">Back To Home</a>
                       </div>
                       <h2>Sign Up</h2>
                        <!-- 
                        <form >
                           <div class="input-group-connection">
                               <div class="col-">
                                   <div class="form-group">
                                       <label for="Gebruikersnaam">Gebruikersnaam</label>
                                       <input type="text" class="form-control" id="Gebruikersnaam"  placeholder="Gebruikersnaam">
                                   </div>
                               </div>
                               <div class="col-">
                                   <div class="form-group">
                                       <label for="Voornaam">Voornaam</label>
                                       <input type="text" class="form-control" id="Voornaam"  placeholder="Voornaam">
                                   </div>
                               </div>
                               <div class="col-">
                                   <div class="form-group">
                                       <label for="Achternaam">Achternaam</label>
                                       <input type="text" class="form-control" id="Achternaam"  placeholder="Achternaam">
                                   </div>
                               </div>
                               <div class="col-">
                                   <div class="form-group">
                                       <label for="Bedrijf">Bedrijf</label>
                                       <input type="text" class="form-control" id="Bedrijf"  placeholder="Bedrijf">
                                   </div>
                               </div>
                               <div class="col-">
                                   <div class="form-group">
                                       <label for="exampleInputEmail1">Email address</label>
                                       <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email address">
                                       <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                   </div>
                               </div>
                               <div class="col-">
                                   <div class="form-group">
                                       <label for="Telefoonnummer">Telefoonnummer</label>
                                       <input type="number" class="form-control" id="Telefoonnummer" placeholder="Telefoonnummer">
                                   </div>
                               </div>
                               <div class="col-">
                                   <div class="form-group">
                                       <label for="exampleInputPassword1">Password</label>
                                       <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password">
                                   </div>
                               </div>
                           </div>
                           <button type="submit" class="btn btn-coneection">Submit</button>
                        </form> 
                        -->
                        <?php 
                            $base_url = get_site_url();
                            if($base_url == 'https://wp12.influid.nl')
                                echo (do_shortcode('[user_registration_form id="59"]'));
                            else
                                echo (do_shortcode('[user_registration_form id="8477"]')); 
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