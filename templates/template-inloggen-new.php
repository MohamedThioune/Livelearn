<?php /** Template Name: Inloggen-new */ ?>

<?php get_header(); ?>

<?php
require_once 'checkout.php';

//Stripe return callback
if(isset($_GET['session_id'])):
    $status_stripe = stripe_status($_GET['session_id']);
    if(isset($status_stripe['error']))
        $message = "<p>Something wrong through the processs payment, please try again later !</p>";
    
    if(isset($status_stripe['status']))
        if($status_stripe['status'] == 'complete')
            $message = '<section id="success" class="hidden" style="background-color:white; color:green; border-radius: 2px">
                            <p>
                            We appreciate your interest in our courses ! A confirmation email will be sent to <span id="customer-email">' . $status_stripe['customer_email'] . '</span>.<br>
                            If you have any questions, please email <a href="mailto:info@livelearn.nl" style="text-decoration:underline">info@livelearn.nl</a>.
                            </p>
                        </section>' . $status_stripe['register_message'];
endif;

if(!isset($message))
    $message = (isset($_GET['message'])) ? $_GET['message'] : null;
?>
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
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/login1.png" alt="First-slide-looggin">
                        </div>
                        <h1>Welkom bij LiveLearn</h1>
                        <p class="description-connection">Begin nu en maak gebruik van ons Learning Experience Platform (LXP) om je vaardigheden te versterken met dynamische en boeiende leerervaringen. Ontgrendel je volledige potentieel en blijf vooroplopen in het voortdurend veranderende zakelijke landschap van vandaag.</p>
                    </div>
                    <div class="carousel-item">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/login2.png" alt="First-slide-looggin">
                        </div>
                        <h1>Ontdek interesses</h1>
                        <p class="description-connection">Omarm de reis van het verkennen van nieuwe interesses, zowel zakelijk als persoonlijk, omdat dit deuren opent naar eindeloze mogelijkheden voor groei en vervulling.</p>
                    </div>
                    <div class="carousel-item">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/login3.png" alt="First-slide-looggin">
                        </div>
                        <h1>Volg experts en docenten </h1>
                        <p class="description-connection">Versterk jezelf door experts en docenten te selecteren om van te leren, waarbij je direct toegang krijgt tot hun waardevolle inhoud in je feed.</p>
                    </div>
                    <div class="carousel-item">
                        <div class="content-img-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/login4.png" alt="First-slide-looggin">
                        </div>
                        <h1>Gepersonaliseerd leren</h1>
                        <p class="description-connection">LiveLearn biedt de ultieme gepersonaliseerde leeromgeving, waarbij inhoud en middelen worden afgestemd op de unieke behoeften en leerstijl van elke individuele deelnemer, wat zorgt voor maximale kennisbehoud en vaardigheidsontwikkeling.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-second-connect">
            <div class="right-block-connection">
               <div class="block-connection">
                   <div class="container-fluid">
                       <div class="d-flex justify-content-between align-items-center">
                           <a href="/" class="logo-liverlearn-connection">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/logolivelearnconnection.png" alt="First-slide-looggin">
                            </a>
                           <a class="back-to-home-text" href="/">Back To Home</a>
                       </div>
                       <h2>Sign into Your Account</h2>
                        <!-- 
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
                        -->
                        <?php
                        //echo alert message
                        echo ($message) ?: '';

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
                                'remember' => true,
                                'label_username' => 'Email address',
                                'placeholder_email' => 'Enter your email address',
                                'label_password' => 'Password',
                                'placeholder_password' => 'Enter your password',
                            ]);
                        ?>
                      <div class="block-other-btn">
                          <a href="<?= wp_lostpassword_url(''); ?>" class="redirectionText">Wachtwoord vergeten ?&nbsp; | &nbsp;</a>
                          <a href="/registreren" class="redirectionText pull-right">Maak je account </a>
                      </div>
                   </div>
               </div>
               <div class="block-social-connection">
                   <h3>Or sign in with</h3>
                   <div class="group-btn-connection">
                        <a href="<?php echo get_site_url() ?>/fluidify/?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600" class="btn btn-connection">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/net-icon-google.png" alt="First-slide-looggin">
                            Sign In using Google
                        </a>
                   </div>
                   <p class="new-user-text">New User ? <a href="/registreren">Create an Account</a></p>
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
        jQuery('#user_login').attr('placeholder', 'Enter your email address');
        jQuery('#user_pass').attr('placeholder', 'Enter your password');
    });
</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>