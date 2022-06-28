<?php /** Template Name: Static education advice template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<body>
 

<div>
    <!-- -----------------------------------Start Modal Sign In ----------------------------------------------- -->

    <!-- Modal Sign End -->
    <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="position: absolute; ">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Sign Up</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  px-md-5 p-3">
                    <?php
                    echo (do_shortcode('[user_registration_form id="59"]'));
                    ?>

                    <div class="text-center">
                        <p>Already a member? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                data-toggle="modal" data-target="#exampleModalCenter">Sign up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->

    <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->

    <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="position: absolute; ">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Sign In</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  px-md-5 p-3">
                    <?php
                    wp_login_form([
                        'redirect' => 'http://wp12.influid.nl/dashboard/user/',
                        'remember' => false,
                        'label_username' => 'Wat is je e-mailadres?',
                        'placeholder_email' => 'E-mailadress',
                        'label_password' => 'Wat is je wachtwoord?'
                    ]);
                    ?>

                    <div class="text-center">
                        <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                              data-toggle="modal" data-target="#SignInWithEmail">Sign in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->
</div>


    <section class="py-3 px-3" style="background: #023356">
        <div class="container py-md-5 py-3">

             <div class="text-center mt-5">
                 <img class="" style="width: 100px"
                 src="<?php echo get_stylesheet_directory_uri();?>/img/Image_69.png" alt="">
             </div>
             <div class="text-center px-md-5">
                <h1 class="CreeerText" style="">
                    Wij zijn er voor jou!
                </h1>

                <?php if (get_current_user_id()==0) { ?> 
                    <button class="btn rounded-pill my-3" data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal"
                        style="padding: 7px 20px !important; background: #19B2A8;">
                        <strong class=" p-3 text-white">Creëer je gratis leeromgeving</strong>
                    </button>

                <?php } else { ?>

                    <button class="btn rounded-pill my-3"
                        style="padding: 7px 20px !important; background: #19B2A8;">
                        <strong class=" p-3 text-white">Creëer je gratis leeromgeving</strong>
                    </button>
                 
                <?php } ?>

            </div>
        </div>
    </section>

    <section class="py-4 px-3" style="background-color: #E0EFF4;">
        <div class="container my-5">
            <div class="row  d-flex justify-content-center">
                <div class="col-md-3 text-center px-2 m-3">
                    <img class="img-fluid w-75" style="max-height: 140px;"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Group_216.png" alt=""> 
                    <h3 class="CreeerText text-dark mt-3" style="font-size: 24px;">Doorloop een glansrijke carrière</h3>
                </div>
                <div class="col-md-3 text-center px-2 m-3">
                    <img class="img-fluid w-75" style="max-height: 140px;"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Group_215.png" alt=""> 
                    <h3 class="CreeerText text-dark mt-3" style="font-size: 24px;">Business skills en persoonlijke interresss</h3>
                </div>
                <div class="col-md-3 text-center px-2 m-3">
                    <img class="img-fluid w-75" style="max-height: 140px;"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Group_214.png" alt=""> 
                    <h3 class="CreeerText text-dark mt-3" style="font-size: 24px;">Altijd toegang tot carrière-advies en begeleiding</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 px-3" style="background-color: #F5FAFD;">
        <div class="container my-5">
             <div class="row">
                 <div class="col-md-7 p-2 order-md-1 order-2">
                    <h1 class="CreeerText text-dark">Een eigen ontwikkelomgeving, zodat je altijd weet wat er speelt</h1>
                    Je past eenvoudig je gehele omgeving aan naar je wensen. Van persoonlijke interesses tot aan een zakelijk carrièrepad. Wij noemen het je ‘skills paspoort’.  Deel deze met je (toekomstige) werkgever en je laat meteen zien wat je in je mars hebt.
                 </div>
                 <div class="col-md-5 text-center p-2 order-md-2 order-1">
                    <img class="img-fluid w-75" style=""
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Group_262.png" alt="">                          
                 </div>
             </div>
        </div>
    </section>

    <section class="py-4 px-3" style="background-color: #E0EFF4;">
        <div class="container my-5">
             <div class="row">
                <div class="col-md-6">
                    <h1 class="CreeerText text-dark">
                    Vind de onderwerpen waar jij interesse in hebt.
                    </h1>
                    Of ontdek verborgen talenten.
                </div>
                <!--  <div class="col-md-6"><h3 class="text-dark">Vind de onderwerpen waar jij interesse in hebt. </h3></div> -->             </div>
        </div>
    </section>

    <section class="py-4 px-3   " style="background-color: #F5FAFD;">
        <div class="container my-5">
             <div class="row">
                 <div class="col-md-6 p-3">
                    <h1 class="CreeerText text-dark">
                    Zorg dat je meegaat met de tijd door je te blijven ontwikkelen</h1>
                 </div>
                 <div class="col-md-6 p-3 d-flex justify-content-center align-self-center">
                    <?php if (get_current_user_id()==0) { ?> 
                        <button type="submit" class="btn btn-outline-dark rounded-pill p-2 px-4"
                        style="border: 2px solid #023356;"   data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                            <strong class="h3">Ontwikkel mij</strong>
                        </button>

                    <?php } else { ?>  
                        <button type="submit" class="btn btn-outline-dark rounded-pill p-2 px-4"
                        style="border: 2px solid #023356;" >
                            <strong class="h3">Ontwikkel mij</strong>
                        </button>  
                    <?php }  ?>     
                 </div>
             </div>
        </div>
    </section>

</body>



<?php get_footer(); ?>
<?php wp_footer(); ?>
