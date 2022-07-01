<?php /** Template Name: Zzpers template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


<body>

    <!-- old name => overview-organisations-1 -->

    <div>
        <!-- -----------------------------------Start Modal Sign In ----------------------------------------------- -->

        <!-- Modal Sign End -->
        <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="position: absolute; ">
            <div class="modal-dialog" role="document"  style="width: 96% !important;">
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

        <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

        <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->

        <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="position: absolute; ">
            <div class="modal-dialog" role="document" style="width: 96% !important;">
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

    <section class="py-4 px-3">
        <div class="container-fluid my-md-5">
             <div class="row">
                 <div class="col-md-8 p-2 order-md-1 order-2 text-md-left text-center">
                    <p class="wordDeBestText2 mx-md-0 py-0 mt-0" style="color: #023356"> <strong class="">ZZP'ers en Startups</strong> </p>                   
                    <p class="krijgText"> 
                        Waarschijnlijk ben jij al druk genoeg met het draaiende houden van je bedrijf.
                        Daarom zorgen wij als LiveLearn dat jij alle trends en ontwikkelingen direct in je eigen
                        ontwikkelomgeving ontvangt. Zo lees je een innovatief artikel, kijk je een vakinhoudinge 
                        video of volg je een fysieke training. 
                        Mocht je groeien als bedrijf, voeg je eenvoudig je nieuwe personeel toe.  
                     </p>
                     <div>
                        <button type="submit" class="btn rounded-pill p-2 px-4" style="background: #00A89D"
                        data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                            <strong class="h5 text-white">Ontwikkel mij</strong>
                        </button>

                        <img class="ml-md-4" style="width: 130px"
                        src="<?php echo get_stylesheet_directory_uri();?>/img/Image99.png" alt=""> 

                     </div>
                 </div>
                 <div class="col-md-4 p-md-2 p-3 text-center p-2 order-md-2 order-1">
                    <img class="img-fluid w-75" style=""
                    src="<?php echo get_stylesheet_directory_uri();?>/img/Image87.png" alt="">                          
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

    <section>
        <div class="container-fluid my-5">
            <p class="krijgText krijgText px-2 px-md-1"> 
                <strong>Populaire groeipaden</strong>
            </p>
            <div class="row my-4 cards_slide" style="height: 350px">
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                        <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving
                                </p>
                            </div>
                        </div>
                    </a>
                 </div>
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                                                            <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving                            </p>
                            </div>
                        </div>
                    </a>
                 </div>
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                                                            <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving                            </p>
                            </div>
                        </div>
                    </a>
                 </div>
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                                                            <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving                            </p>
                            </div>
                        </div>
                    </a>
                 </div>
            </div>
            <div class="row my-4 cards_slide" style="height: 350px">
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                                                            <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving                            </p>
                            </div>
                        </div>
                    </a>
                 </div>
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                                                            <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving                            </p>
                            </div>
                        </div>
                    </a>
                 </div>
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                                                            <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving                            </p>
                            </div>
                        </div>
                    </a>
                 </div>
                 <div class="col-md-4 p-md-2 p-2">
                    <a href="http://localhost/livelearn/course/the-webbuilder-course/" class="swiper-slide swiperSlideModife swiper-slide-active" role="group" aria-label="1 / 5" style="width: 313.333px; margin-right: 20px;">
                        <div class="cardKraam2">
                            <div class="headCardKraam">
                                <div class="blockImgCardCour">
                                    <img src="http://localhost/livelearn/wp-content/uploads/2022/04/App-builder.jpeg" alt="">
                                </div>
                                <div class="blockgroup7">
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"></p>
                                        </div>
                                    </div>
                                    <div class="iconeTextKraa">
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> </p>
                                        </div>
                                        <div class="sousiconeTextKraa">
                                            <img src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/euro1.png" class="icon7" alt="">
                                            <p class="kraaText">3,421.00 &nbsp;&nbsp;</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="contentCardProd">
                                <div class="group8">
                                    <div class="imgTitleCours">
                                                                            <div class="imgCoursProd">
                                            <img src="http://localhost/livelearn/wp-content/uploads/2021/11/logoWorkPlaceAcademy_01-1.png" width="25" alt="">
                                        </div>
                                        <p class="nameCoursProd">WorkPlace Academy</p>
                                                                        </div>
                                    <div class="group9">
                                        <div class="blockOpein">
                                            <img class="iconAm" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/graduat.png" alt="">
                                            <p class="lieuAm">Opleidingen</p>
                                        </div>
                                        <div class="blockOpein">
                                            <img class="iconAm1" src="http://localhost/livelearn/wp-content/themes/fluidify-child/img/map.png" alt="">
                                            <p class="lieuAm"></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="werkText">The webbuilder course</p>
                                <p class="descriptionPlatform">
                                    Mooie tekst voor als korte beschrijving</p>
                            </div>
                        </div>
                    </a>
                 </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid my-5 px-md-4">
            <div class="row">
                <div class="col-md-12 p-2 order-md-1 order-2 text-md-left text-center px-4 px-md-3">
                    <p class="wordDeBestText2 mx-md-0 py-0 mt-0" style="max-width: 100%"> <strong>Plug-and-play ontwikkel platform </strong></p>                   
                    <p class="krijgText"> 
                        Je kan je eigen ontwikkelomgeving eenvoudig opzetten. LiveLearn helpt je met het optimaal gebruik maken van het platform
                        en welke kennisproducten het best bij jouw organisatie passen. Mocht zelf al materiaal hebben, dan voeg je dit eenvoudig toe
                        aan het platform via het teacher dashboard.
                    </p>
                </div>
            </div>

            <div class="list-group-flush">

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
                                Manage je mensen? Dan is het handig om een overzicht te hebben van interesses en ontwikkelingen. 
                                Zo weet je welke kennis je in huis hebt en kan je eenvoudig bijsturen wanneer bepaalde vaardigheden 
                                verder ontwikkelt moeten worden.                           
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
                                Zelf ben je natuurlijk ook een expert in je eigen vakgebied. Door dit te delen met de wereld bouw 
                                je een bepaalde geloofwaardigheid op. Bij LiveLearn voeg je eenvoudig jouw kennisproducten toe zodat 
                                je klanten, fans of community deze ook kunnen zien.                          
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
                                Leren en ontwikkelen wordt vaak als een kostenpost gezien. Dit is één van de grootste fouten 
                                van het hebben van personeel. Het is namelijk vele malen goedkoper om talent goed op te leiden dan
                                personeel te hebben wat eigenlijk niet in staat is om het werk uit te voeren. Bij LiveLearn beheer 
                                je eenvoudig al je financiën mbt scholing.                           
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
                                Zo kan je eenvoudig bijsturen wanneer 
                                onderwerpen ondervertegenwoordigd zijn of juist te veel interesse voor is.                            
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn rounded-pill p-2 px-5" style="background: #00A89D"
                data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                    <strong class="h5 text-white">Je eigen leeromgeving</strong>
                </button>
            </div>
        </div>
    </section>
    
    <section class="py-4 px-3" >
        <div class="container-fluid my-5">
             <div class="row">
                 <div class="col-md-5 p-2 text-md-left text-center">
                    <img class="img-fluid w-75" style=""
                    src="<?php echo get_stylesheet_directory_uri();?>/img/ImgSkill2.png" alt=""> 
                 </div>
                 <div class="col-md-7 p-2 text-md-left text-center">
                    <h1 class="display-5 big-title" style="color: #023356">
                    <strong>Voeg je favoriete kanalen samen in één omgeving</strong> </h1>                   
                    <p class="krijgText"> 
                        Je selecteert eenvoudig de experts, opleiders en onderwerpen die jij interessant vindt
                        en wij doen de rest.  
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
    </section>

    <section class="py-5" style="background: #043356">
        <div class="container-fluid py-5">
            <div class="row d-flex justify-content-center align-items-center mx-2">
            
                <div class="col-md-6 px-md-0 text-md-left text-center">
                    <img class="im-fluid w-75"  src="<?php echo get_stylesheet_directory_uri();?>/img/Contact_team2.png" alt="team">     
                </div>

                <div class="col-md-6 px-md-0 text-md-left text-center">
                    <h2 class="hero-title text-white">
                        Direct contact met één van onze adviseurs?
                    </h2>
                    <div class="my-3 text-white">
                        <p>
                            We helpen je graag met jouw specifieke vragen omtrent talent management en de toepasbaarheid 
                            hiervan binnen je organisatie.
                        </p>
                    </div>    
                    <a href="mailto:contact@livelearn.nl" class="btn btn-default rounded-pill px-5 my-2 ml-md-0 ml-2" style="background: #E3EFF4">
                        <strong class="text-dark">Email </strong>
                    </a>
                    <a href="tel: +31621610903" class="btn btn-default rounded-pill px-5 my-2 ml-md-3" style="background: #00A89D">
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
<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
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
        centerMode: false,
        centerPadding: '15px',
        dots: false,
        slidesToShow: 3,
        arrows: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    centerMode: true,
                    centerPadding: '35px'
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '30px'
                }
            }
        ]
    });

</script>

