<?php /** Template Name: Grootbedrijf template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


<body>


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
                            echo (do_shortcode('[user_registration_form id="8477"]'));
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

    <section class="py-4 px-3">
        <div class="container-fluid my-md-5">
             <div class="row d-flex justify-content-center">
                 <div class="col-md-8 col-11 p-2 order-md-1 order-2 text-md-left text-center">
                    <p class="wordDeBestText2 mx-md-0 py-0 mt-0" style="color: #023356; max-width: 100%">
                        <strong>Grootbedrijf en corporates</strong>
                    </p>                   
                    <p class="krijgText">
                        Afdelingen, meerdere landen, verschillende culturen, het zijn een paar onderwerpen waar corporate organisaties dagelijks mee te maken hebben. LiveLearn biedt een learning experience platform, waarbij je dit modulair en eenvoudig bijhoudt. Wij zorgen dat je organisatie op individueel, team, afdeling en corporate niveau kan presteren.                    </p>
                    <div>
                        <button type="submit" class="btn rounded-pill p-2 px-4 my-2" style="background: #00A89D"
                            data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                            <strong class="h5 text-white">Je eigen leeromgeving </strong>
                        </button>

                        <a type="submit" class="btn btn-outline-realblue rounded-pill p-2 px-2 px-md-4 my-2 ml-md-3" href="#contact_section">
                            <strong class="h5">Contact met een adviseur</strong>
                        </a>

                    </div>
                 </div>
                 <div class="col-md-4 p-md-2 p-3 text-center p-2 order-md-2 order-1">
                    <img class="img-fluid w-75" style=""
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Image-89.png" alt="">                          
                 </div>
             </div>

             <div class="row d-flex justify-content-center logo_slider pt-4">
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners7.jpeg" alt="">            
                </div>
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners1.jpeg" alt="">
                </div>
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners2.jpeg" alt="">            
                </div>
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners2.jpeg" alt="">            
                </div>
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners4.jpeg" alt="">            
                </div>
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners5.jpeg" alt="">            
                </div>
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners6.jpeg" alt="">            
                </div>
                <div class="mx-1">
                    <img class="" style="width: 130px"
                    src="<?php echo get_stylesheet_directory_uri();?>/img/logoParteners8.jpeg" alt="">            
                </div>
             </div>

        </div>
    </section>


    <section class="mb-5" style="background: #023356">
         <div class="container-fluid">
             <div class="row py-md-0 py-4 d-flex justify-content-center">
                 <div class="col-md-3 col-8 text-center mb-md-0 mb-3">
                    <img class="img-fluid w-75" style=""
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Image98.png" alt="">  
                 </div>
                 <div class="col-6 d-flex align-items-center justify-content-center">
                    <p class="wordDeBestText2 mx-md-0 py-0 mt-0 text-white text-center"> Win de <strong>War on Talent</strong> </p>  
                 </div>
                 <div class="col-md-3 d-flex align-items-center justify-content-center">
                    <a type="submit" class="btn rounded-pill p-2 px-4 my-2 ml-md-3" href="/ontwikkeladvies"
                        style="border: 2px solid #FFF;">
                        <strong class="h5 text-white">Lees hoe</strong>
                    </a>
                 </div>
             </div>
         </div>
    </section>


    <section>
        <div class="container-fluid my-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-11 p-2 order-md-1 order-2 text-md-left text-center px-4 px-md-3">
                    <p class="wordDeBestText2 mx-md-0 py-0 mt-0" style="color: #023356; max-width: 100%"> 
                        <strong>Plug-and-play ontwikkel platform</strong> </p>                   
                    <p class="krijgText"> 
                        Je kan je eigen ontwikkelomgeving eenvoudig opzetten. LiveLearn helpt je met het optimaal gebruik maken van het platform
                        en welke kennisproducten het best bij jouw organisatie passen. Mocht zelf al materiaal hebben, dan voeg je dit eenvoudig toe
                        aan het platform via het teacher dashboard.
                    </p>
                </div>
            </div>

            <div class="list-group-flush mx-md-0 mx-2">
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image90.png" alt="">   
                        </div>
                        <div class="p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Je gepersonaliseerde ontwikkelomgeving</strong></h4>
                            <p class="krijgText ">
                                Voor iedereen die gebruik maakt van LiveLearn bieden wij een geheel eigen leeromgeving.
                                Jij bepaalt wat je interessant vindt en ontvangt vervolgens alle content direct in je
                                eigen app.                           
                            </p>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image91.png" alt="">   
                        </div>
                        <div class=" p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Manager dashboard</strong></h4>
                            <p class="krijgText ">
                                Manage je mensen? Dan is het handig om een overzicht te hebben van interesses en 
                                ontwikkelingen. Zo weet je welke kennis je in huis hebt en kan je eenvoudig bijsturen
                                wanneer bepaalde vaardigheden verder ontwikkelt moeten worden.                            
                            </p>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image92.png" alt="">   
                        </div>
                        <div class=" p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Teacher dashboard</strong></h4>
                            <p class="krijgText ">
                                Zelf ben je natuurlijk ook een expert in je eigen vakgebied. Door dit te delen met de
                                wereld bouw je een bepaalde geloofwaardigheid op. Bij LiveLearn voeg je eenvoudig jouw
                                kennisproducten toe zodat je klanten, fans of community deze ook kunnen zien.                           
                            </p>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image93.png" alt="">   
                        </div>
                        <div class=" p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Beheer Financiën</strong></h4>
                            <p class="krijgText ">
                                Leren en ontwikkelen wordt vaak als een kostenpost gezien. Dit is één van de grootste 
                                fouten van het hebben van personeel. Het is namelijk vele malen goedkoper om talent 
                                goed op te leiden dan personeel te hebben wat eigenlijk niet in staat is om het werk
                                uit te voeren. Bij LiveLearn beheer je eenvoudig al je financiën mbt scholing.                          
                            </p>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image94.png" alt="">   
                        </div>
                        <div class=" p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Meer dan 10.000 kennisproducten</strong></h4>
                            <p class="krijgText ">
                                Zelf moeilijk doen met een goed curriculum aan te bieden aan je medewerkers? Niet meer
                                nodig. Wij zorgen dat alle beschikbare content direct te vinden is in het platform. 
                                Hier voeg je ook eenvoudig je eigen content aan toe; dit kan zowel privé als publiek.                            
                            </p>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image95.png" alt="">   
                        </div>
                        <div class="p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Maak eenvoudig ontwikkelplannen of geef feedback</strong></h4>
                            <p class="krijgText ">
                                Elke organisatie heeft zijn eigen beoordeling cycli. Bij LiveLearn digitaliseer je deze 
                                eenvoudig, zodat je alles op één plek hebt. Daarnaast koppel je deze plannen direct met 
                                het beschikbare aanbod van opleidingen.                           
                            </p>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image96.png" alt="">   
                        </div>
                        <div class="p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Statistieken en data over trends en gebruik</strong></h4>
                            <p class="krijgText ">
                                Hoe snel groeit je organisatie? Hou precies bij hoe je bedrijf groeit in kennis in vaardigheden.
                                Zo kan je eenvoudig bijsturen wanneer onderwerpen ondervertegenwoordigd zijn of juist te veel 
                                interesse voor is.                            
                            </p>
                        </div>
                    </div>
                </div>
                <div class="list-group-item border-0 px-md-0 px-1 py-md-0">
                    <div class="d-flex flex-md-row flex-column">
                        <div class="mb-md-4 p-2 align-items-center d-flex justify-content-center">
                            <img class="" style="width: 80px"
                            src="<?php echo get_stylesheet_directory_uri();?>/img/Image-97.png" alt="">   
                        </div>
                        <div class="p-2 text-md-left text-center">
                            <h4 style="color: #023356"><strong>Een speciale HR rol in het platform</strong></h4>
                            <p class="krijgText ">
                                Omdat organisaties complexer zijn dan slecht individuele managers hebben wij de HR rol
                                toegevoegd. Met deze rol krijg je inzicht in alle financiën, ontwikkelingen, plannen
                                en statistieken.                           
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="row d-flex justify-content-center">
                <div class="col-md-3 col-10 text-center">
                    <button type="submit" class="btn rounded-pill p-2 px-4 m-1 w-100"
                        style="background: #00A89D">
                        <strong class="h5 text-white">Je eigen leeromgeving</strong>
                    </button>
                </div>
                
                <div class="col-md-3 col-10 text-center">
                    <button type="submit" class="btn rounded-pill p-2 px-5 m-1 btn btn-outline-realblue w-100">
                        <strong class="h5">Vraag een demo aan</strong>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="py-md-4 px-3" >
        <div class="container-fluid my-5">
             <div class="row d-flex justify-content-center">
                 <div class="col-md-5 col-8 p-2 text-center">
                    <img class="img-fluid w-50" style=""
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Skills-paspoor.001.png" alt=""> 
                 </div>
                 <div class="col-md-7 col-11 p-2 text-md-left text-center d-flex align-items-center">
                     <div>
                        <p class="wordDeBestText2 mx-md-0 py-0 mt-0" style="color: #023356; max-width: 100%">
                        <strong>Een skills paspoort voor elke medewerker</strong> </p>                   
                        <p class="krijgText"> 
                            Zo is het altijd duidelijk waar iemand staat en wat er bijgeleerd kan of moet worden. 
                            Het paspoort vormt zich automatisch, dus jij hoeft alleen maar te doen wat je leuk / 
                            interessant vindt.
                        </p>
                        <div>
                            <button type="submit" class="btn btn-outline-realblue rounded-pill p-2 px-5"
                                data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                                <strong class="h5">Maak nu</strong>
                            </button>
                        </div>
                     </div>
                   
                 </div>
             </div>
        </div>
    </section>

    <section class="py-md-4 px-3" >
        <div class="container-fluid my-5">
             <div class="row d-flex justify-content-center">
                 <div class="col-md-7 col-11 p-2 text-md-left text-center order-md-1 order-2">
                    <p class="wordDeBestText2 mx-md-0 py-0 mt-0" style="color: #023356; max-width: 100%"> <strong>Wat is een Learning Experience platform?</strong> </p>                   
                    <p class="krijgText"> 
                        Een LXP stelt het individu voorop om er voor te zorgen dat deze het meest geïnspireerd wordt 
                        om te blijven leren. Als organisatie stuur je hierin door doelen en ambities te koppelen aan
                        de individuele leerbehoefte.  
                    </p>
                     <div>
                        <button type="submit" class="btn btn-outline-realblue rounded-pill p-2 px-5">
                            <strong class="h5">Lees het hier</strong>
                        </button>
                     </div>
                 </div>
                 <div class="col-md-5 col-11 p-2 text-md-right text-center order-md-2 order-1">
                    <img class="img-fluid w-75" style=""
                    src="<?php echo get_stylesheet_directory_uri();?>/img/ImgSkill2.png" alt=""> 
                 </div>
             </div>
        </div>
    </section>

    <!-- <div data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" class="scrollspy-example" tabindex="0">
  <h4 id="list-item-1">Item 1</h4>

</div> -->
    <section class="py-5" style="background: #043356" id="contact_section">
        <div class="container-fluid py-5">
            <div class="row d-flex justify-content-center align-items-center">
            
                <div class="col-md-6 col-9 px-md-0 text-md-left text-center">
                    <img class="im-fluid w-75"  src="<?php echo get_stylesheet_directory_uri();?>/img/Contact_team2.png" alt="team">     
                </div>

                <div class="col-md-6 col-11 px-md-0 text-md-left text-center">
                    <h2 class="hero-title text-white">Direct contact met één van onze adviseurs? <br> </h2>
                    <div class="my-3 text-white">
                        <p class="krijgText text-white">
                            We helpen je graag met jouw specifieke vragen omtrent talent
                            management en de toepasbaarheid hiervan binnen je organisatie.
                        </p>
                    </div>
                    <a href="mailto:contact@livelearn.nl" class="btn btn-default rounded-pill px-5 my-2 ml-md-0 ml-2" style="background: #E3EFF4">
                        <strong class="text-dark">Email </strong>
                    </a>
                    <a href="tel: +31627003962" class="btn btn-default text-white rounded-pill px-5 my-2 ml-md-3" style="background: #00A89D">
                        <strong >Bellen</strong>
                    </a>
                </div>
            </div>
        </div>
    </section>

</body>



<?php get_footer(); ?>
<?php wp_footer(); ?>

<!-- jQuery CDN -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- slick Carousel CDN -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>


<script type="text/javascript">
    $('.logo_slider').slick({
        centerMode: true,
        centerPadding: '0px',
        autoplay: true,
        dots: false,
        slidesToShow: 6,
        speed: 400,
        autoplaySpeed: 1500,
        arrows: false,
        responsive: [
            {
                breakpoint: 1240,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    centerPadding: '20px',
                    arrows: false
                }
            },
            {
            breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    slidesToShow: 3,
                    centerPadding: '10px',
                }
            },
            {
            breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    slidesToShow: 2,
                    centerPadding: '15px',
                }
            }
        ]
    });

    // cards section
    $('.cards_slide').slick({
        centerMode: true,
        centerPadding: '15px',
        dots: false,
        slidesToShow: 3,
        arrows: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

</script>

