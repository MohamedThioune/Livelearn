<?php /** Template Name: template Ontwikkeladvies */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />



<div>

    <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;height: 150% !important; overflow-y:hidden !important;">
        <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

            <div class="modal-content">

                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body  px-md-4 px-0">
                    <div class="mb-4">
                        <div class="text-center">
                            <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">     
                        </div>  
                        <h3 class="text-center my-2">Sign Up</h3>
                        <div class="text-center">
                            <p>Already a member? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#exampleModalCenter">&nbsp; Sign in</a></p>
                        </div>
                    </div>  


                    <?php
                        echo (do_shortcode('[user_registration_form id="59"]'));
                    ?>

                    <div class="text-center">
                        <p>Al een account? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                data-toggle="modal" data-target="#exampleModalCenter">Log-in</a></p>
                    </div>

                </div>
            </div>
        
        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

    <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;overflow-y:hidden !important;height: 110%; ">
        <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body  px-md-5 px-4">
                    <div class="mb-4">
                        <div class="text-center">
                            <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">     
                        </div>
                        <h3 class="text-center my-2">Sign In</h3>
                        <div class="text-center">
                            <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#SignInWithEmail">&nbsp; Sign Up</a></p>
                        </div>
                    </div>

                    <?php
                    wp_login_form([
                        'redirect' => $url,
                        'remember' => false,
                        'label_username' => 'Wat is je e-mailadres?',
                        'placeholder_email' => 'E-mailadress',
                        'label_password' => 'Wat is je wachtwoord?'
                    ]);
                    ?>
                    <div class="text-center">
                        <p>Nog geen account?  <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                            data-toggle="modal" data-target="#SignInWithEmail">Meld je aan</a></p>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->

</div>

<div class="content-ontwikkeladvies">
    <div class="head-ontwikkeladvies">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-11 text-md-left text-center order-md-0 order-1 my-2 my-md-1">
                    <h1>Blijven ontwikkelen, je hoeft het niet alleen te doen!</h1>
                    <p>Altijd en overal de handvatten om nieuwe dingen te leren op de manier die het best bij jou past.</p>
                    <a href="#card_section" class="btn btnBekijk2">Bekijk alle opties</a>
                </div>
                <div class="col-md-6 col-10 order-md-1 order-0 my-2 my-md-1">
                    <div class="blockImgontwikkeladvies">
                        <img alt="course design_undrawn" src="<?php echo get_stylesheet_directory_uri(); ?>/img/Ontwikkelplan.001.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bodyOntwikkeladvies"  id="card_section">
       <div class="container px-md-1 px-3">
           <h2 class="elkeVolgendeTitle">Scholingsadvies voor elke volgende stap in je carrière</h2>
           <p class="elkeVolgendeDescription px-md-0 px-3">Voor jou dus ja, wij helpen je met je professionele en persoonlijke groei. Of je nu opzoek bent naar een (nieuwe) baan of wil groeien als persoon. Wij helpen je met het inrichten van jouw persoonlijke groeipad.</p>
           <div class="cardBlockValOpEnVerbind">
               <div class="row">
                   <div class="col-md-4 col-sm-12">
                       <div class="CardVolgende">
                           <div class="headCardVolgende">
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe11.png" alt="">
                           </div>
                           <p class="titleCardVolgende">Gratis scholingsconsult</p>
                           <p class="subTitleCardVolgende pb-md-1 pb-4">Een 15 minuten gesprek om kort te analyseren wat jouw situatie is en welke begeleiding het best bij jou past om verder te groeien. Je zit nergens aan vast!</p>
                           <a href="#form_section" class="btn btnCardVolgende">Plan een consult</a>
                       </div>
                   </div>
                   <div class="col-md-4 col-sm-12">
                       <div class="CardVolgende">
                           <div class="headCardVolgende">
                               <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/femme1.png" alt="">
                           </div>
                           <p class="titleCardVolgende">Persoonlijk ontwikkelplan</p>
                           <p class="subTitleCardVolgende pb-md-1 pb-4">In een sessie van 60 minuten maken wij een plan voor jou om te blijven ontwikkelen en te groeien binnen je baan of richting een nieuwe uitdaging.</p>
                           <a href="#form_section" class="btn btnCardVolgende">Plan een POP</a>
                       </div>
                   </div>
                   <div class="col-md-4 col-sm-12">
                       <div class="CardVolgende">
                           <div class="headCardVolgende">
                               <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe-233.png" alt="">
                           </div>
                           <p class="titleCardVolgende">360* scholingsadvies</p>
                           <p class="subTitleCardVolgende pb-md-1 pb-4">Een compleet op maat gemaakt programma om jou verder te helpen in je carrière. Welke opleidingen passen bij jou en waar krijg je energie van, gecombineerd met de vraag uit de markt.</p>
                           <a href="#form_section" class="btn btnCardVolgende">Plan een 360* advies</a>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>
    <div class="blockWinDeWar">
        <div class="container-fluid px-2 px-md-0">
            <div class="elementWinWar">
                <div class="imgWInWar">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/win-war.png"  alt="">
                </div>
                <div class="text-center">
                    <p class="descriptionWinWar2">Voor iedereen met <b>maximaal MBO-2 niveau</b> <b>is ons 360* scholingsadvies</b>  helemaal gratis</p>
                </div>
                <a href="" class="btn btnLessHoe">Lees hoe</a>
            </div>
        </div>
    </div>

    <div class="container" >
        <div class="row rowModifeBook d-flex justify-content-center">
            <div class="col-md-6 col-8 d-flex justify-content-center">
                <div class="imgBook">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/imgBook.png"  alt="">
                </div>
            </div>
            <div class="col-md-6 col-11 text-md-left text-center">
                <h2 class="titleAltijd">Altijd inclusief je eigen persoonlijke skills paspoort en ontwikkelomgeving.</h2>
                <p class="descriptionAltijd">Je selecteert eenvoudig je interesses en je krijgt alle relevante artikelen, trainen en andere kennisproducten in je eigen omgeving</p>
                <a href="" class="btn btnMaakNu" data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">Maak nu</a>
            </div>
        </div>
        <div class="blockFormTestimonial" id="form_section">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-11">
                    <?php
                        echo do_shortcode("[gravityform id='11' title='false' description='false' ajax='true']");
                    ?>
                </div>
                <div class="col-md-6 col-11">
                    <h2 class="watAnderenTitle">Wat anderen over ons zeggen</h2>
                    <div class="cardTestimonialZeggen">
                        <div class="blockImg">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/suit-guy.png">
                        </div>
                        <div>
                            <p class="textDescription">Heel fijn om een plan te hebben, ik zat namelijk een beetje vast in mijn functie</p>
                            <div class="rating">
                                <input type="radio" id="star5"  checked name="rating" value="5" />
                                <label class="star" for="star" title="Awesome" aria-hidden="true"></label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label class="star" for="star" title="Great" aria-hidden="true"></label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label class="star" for="star" title="Very good" aria-hidden="true"></label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label class="star" for="star" title="Good" aria-hidden="true"></label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label class="star" for="star" title="Bad" aria-hidden="true"></label>
                            </div>
                        </div>
                    </div>
               <div class="cardTestimonialZeggen">
                        <div class="blockImg">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/girlDankzij.png">
                        </div>
                        <div>
                            <p class="textDescription">Dankzij LiveLearn heb ik binnen 4 weken een nieuwe baan gevonden.</p>
                            <div class="rating">
                                <input type="radio" id="star10"   name="rating-2" value="10" />
                                <label class="star" for="star" title="Awesome-Dankzij" aria-hidden="true"></label>
                                <input type="radio" id="star9" checked name="rating-2" value="9" />
                                <label class="star" for="star" title="Great-Dankzij" aria-hidden="true"></label>
                                <input type="radio" id="star8" name="rating-2" value="8" />
                                <label class="star" for="star" title="Very good Dankzij" aria-hidden="true"></label>
                                <input type="radio" id="star7" name="rating-2" value="7" />
                                <label class="star" for="star" title="Good-Dankzij" aria-hidden="true"></label>
                                <input type="radio" id="star6" name="rating-2" value="6" />
                                <label class="star" for="star" title="Bad-Dankzij" aria-hidden="true"></label>
                            </div>
                        </div>
                    </div>
                     <div class="cardTestimonialZeggen">
                        <div class="blockImg">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/hannah.png">
                        </div>
                        <div>
                            <p class="textDescription">Ik had geen idee wat een goede opleiding voor mij was. Na het programma wist ik wat het best bij mij als persoon past.</p>
                            <div class="rating">
                                <input type="radio" id="star12"  checked name="rating-3" value="12" />
                                <label class="star" for="star" title="Awesome-had" aria-hidden="true"></label>
                                <input type="radio" id="star11" name="rating-3" value="11" />
                                <label class="star" for="star" title="Great-had" aria-hidden="true"></label>
                                <input type="radio" id="star10" name="rating-3" value="10" />
                                <label class="star" for="star" title="Very good had" aria-hidden="true"></label>
                                <input type="radio" id="star2" name="rating-3" value="2" />
                                <label class="star" for="star" title="Good-had" aria-hidden="true"></label>
                                <input type="radio" id="star1" name="rating-3" value="1" />
                                <label class="star" for="star" title="Bad-had" aria-hidden="true"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blockFooterOntwikkeladvies">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-10">
                    <div class="blockImgFooterOntwikkeladvies">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/teamFooter.png">
                    </div>
                </div>
                <div class="col-md-6 col-11 text-md-left text-center">
                    <h2  class="titleContact">Direct contact met één van onze adviseurs?</h2>
                    <p class="descriptionContact">We helpen je graag met jouw specifieke vragen omtrent talent management en de toepasbaarheid hiervan binnen je organisatie.</p>
                    <div class="groupBtnFooter">
                        <a href = "mailto: contact@livelearn.nl" class="btnemail btn">Email</a>
                        <a href="tel: +31627003962" class="btnBellen btn">Bellen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>












<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php get_footer(); ?>
<?php wp_footer(); ?>
</div>
