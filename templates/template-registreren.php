<?php /** Template Name: Registeren */ ?>

<?php 
    extract($_POST);

    extract($_GET);


    if(isset($registeren))
        if(isset($email)){
        
            if($email != null)
            {

                if($first_name == null)
                    $first_name = "ANONYM";
                
                if($last_name == null)
                    $last_name = "ANONYM";

                $userdata = array(
                    'user_pass' => $password,
                    'user_login' => $user_login,
                    'user_email' => $email,
                    'user_url' => 'http://livelearn.nl/',
                    'display_name' => $first_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'Klant'
                );

                $user_id = wp_insert_user(wp_slash($userdata));

                if(is_wp_error($user_id)){
                    $danger = $user_id->get_error_message();
                    header("location:registreren?message=".$danger."&danger");

                }else{
                    $success = "U bent succesvol geregistreerd<br>";
                    update_field('telnr', $phone, 'user_'.$user_id);
                    update_field('subscription_company', $bedrij, 'user_'.$user_id);
                    
                    $subject = 'Welcome onboard ✨';
                    $body = "
                    <h1>Hello " . $first_name  . "</h1><br> 
                    Your are successfully registered , welcome onboard<br><br>
                    <h4><a href='http://wp12.influid.nl/inloggen'> Connexion </a></h4>
                    ";
                
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );

                    wp_mail($email, $subject, $body, $headers, array( '' )) ; 
                    header("location:registreren?message=".$success."&success");
         
                }

              
            }
            else{
                $danger = "Vul de e-mail in, alsjeblieft";
                header("location:registreren?message=".$danger."&danger");
            }
        }
?>


<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div>
    <div class="contentLogin">
       <div class="container">
           <div class="contentLogin">
                <div class="row  ">
                    <div class="col-lg-6  col-md-5">
                        <div class="boxLOginCardOne">
                            <div class="blockImgCarLogin">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Composant1.png" alt="">
                            </div>
                            <p class="textNog"> Al lid? Ga dan direct naar je persoonlijke omgeving</p>
                        </div>
                        <div class="boxLOginCardOne">
                            <div class="blockImgCarLogin">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe8.png" alt="">
                            </div>
                            <p class="textNog"> Ben jij een opleider of expert? Meld je hier aan.</p>
                        </div>
                        <div class="boxLOginCardOne">
                            <div class="blockImgCarLogin">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/headWeb8.png" alt="">
                            </div>
                            <p class="textNog">De eerste maad helemaal vrijblijvend</p>
                        </div>
                    </div>
                    <div class="col-lg-6  col-md-7">
                        <div class="boxCardForm">
                        <!-- <form action="/registreren" method="POST">
                                <?php if(isset($_GET['success'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ?>
                                <?php if(isset($_GET['danger'])) echo "<span class='alert alert-danger'>" . $_GET['message'] . "</span><br><br>" ?>
                                 -->
                                <center><p class="TitleForm">Registreren</p></center>

                                <?php echo (do_shortcode('[user_registration_form id="59"]')); ?>
                            </form>
                        </div>
                    </div>
                </div>
           </div>
       </div>
    </div>
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script src="js/style.js"></script>
