<?php /** Template Name: Voor teachers template */ ?>

<?php 
    extract($_POST);

    extract($_GET);

    if(isset($education_individual))
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
                    <h4><a href='http://livelearn.nl/inloggen'> Connexion </a></h4>
                    ";
                
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );

                    wp_mail($email, $subject, $body, $headers, array( '' )) ; 
                    header("location:static-education-individual?message=".$success."&success");
         
                }

              
            }
            else{
                $danger = "Vul de e-mail in, alsjeblieft";
                header("location:static-education-individual?message=".$danger."&danger");
            }
        }
?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<body>
 
    <section class=" pt-md-5" style="background: #00A89D">
        <div class="container  py-5">

            <div class="row  py-md-5">
                <div class="col-md-8 text-md-left text-center">
                    
                    <div class="">
                        <h1 class="CreeerText" style="">
                            Word onderdeel van het grootste expert / opleidersnetwerk
                        </h1>
                        <h5 class="text-white">Deel jouw kennis met rest van Nederland</h5> 
                        <a class="btn rounded-pill my-3" href="/overview-organisations-5"
                            style="padding: 7px 20px !important; background: #E0EFF4;">
                            <strong class=" p-3">Meer informatie? </strong>
                        </a>
                    </div>
                    <div class="mt-5">
                        <img class="w-50"
                        src="<?php echo get_stylesheet_directory_uri();?>/img/headWeb8.png" alt="">
                    </div>

                </div>
                <div class="col-md-4 mt-5">
                    <div class="blockForm" style="width:100%">
                        <p class="gratisText gratisText2">Gratis</p>
                        <p><b>Meld je aan</b></p>
                        <center>
                            <?php if(isset($_GET['success'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ?>
                            <?php if(isset($_GET['danger'])) echo "<span class='alert alert-danger'>" . $_GET['message'] . "</span><br><br>" ?>
                        </center>
                        <?php echo (do_shortcode('[user_registration_form id="59"]')); ?>
                    </div>
                </div>
            </div>

          
        </div>
    </section>
    

</body>


<?php get_footer(); ?>
<?php wp_footer(); ?>