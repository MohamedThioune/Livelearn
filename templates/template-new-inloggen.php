<?php /** Template Name: new-inloggen */ ?>


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
                        <p class="description-connection">Hét leer- en upskilling platform van- én voor de toekomst · Als bedrijf beheer je in 1 minuut al je talent binnen de organisatie · Direct een afspraak inplannen?</p>
                    </div>
                    <div class="carousel-item">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/new-inloggen.png" alt="First-slide-looggin">
                        </div>
                        <h1>Welcome to Livelearn</h1>
                        <p class="description-connection">Hét leer- en upskilling platform van- én voor de toekomst · Als bedrijf beheer je in 1 minuut al je talent binnen de organisatie · Direct een afspraak inplannen?</p>
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
                       <h2>Sign into Your Account</h2>
                       <form>
                           <div class="form-group">
                               <label for="exampleInputEmail1">Email address</label>
                               <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email address">
                               <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                           </div>
                           <div class="form-group">
                               <label for="exampleInputPassword1">Password</label>
                               <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password">
                           </div>
                           <div class="form-check">
                               <input type="checkbox" class="form-check-input" id="exampleCheck1">
                               <label class="form-check-label" for="exampleCheck1">Remember me</label>
                           </div>
                           <button type="submit" class="btn btn-coneection">Sign In</button>
                       </form>
                   </div>
               </div>
               <div class="block-social-connection">
                   <h3>Or sign in with</h3>
                   <div class="group-btn-connection">
                       <a href="" class="btn btn-connection">
                           <img src="<?php echo get_stylesheet_directory_uri();?>/img/net-icon-google.png" alt="First-slide-looggin">
                           Sign In using Google
                       </a>
                       <a href="" class="btn btn-connection">
                           <img src="<?php echo get_stylesheet_directory_uri();?>/img/net-icon-facebook.png" alt="First-slide-looggin">
                           Sign In using Facebook
                       </a>
                   </div>
                   <p class="new-user-text">New User ? <a href="">Create an Account</a></p>
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

<?php get_footer(); ?>
<?php wp_footer(); ?>