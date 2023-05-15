<?php /** Template Name: overview-organisaties-5 */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="container-fluid">


    <!-- -----------------------------------Start Modal Sign In ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade " id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="position: absolute; ">
        <div class="modal-dialog" role="document">
            <div class="modal-content"  >
                <div class="modal-header border-0">
                    <button style="color: #043356" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 20px !important">&times;</span>
                    </button>
                </div>
                <div class="modal-body  px-md-5 p-3">

                    <div class="text-center" style="color: #043356"><h4>Activeer zakelijke </h4></div>
                    <div class="text-center" style="color: #043356"><h6>Leeromgeving </h6></div> <br>

                    <?php
                        echo do_shortcode("[gravityform id='12' title='false' description='false' ajax='true']");
                    ?>

                </div>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->


    <div class="contentOverviewOrganisatie pt-5">
       <div class="headOverviewOrganisatie">
           <h1>Deel jouw kennis(producten) in een paar klikken</h1>
           <p class="description">Wij hanteren geen opstartkosten, dus je kan meteen van start. Wij doen alleen een snelle check om te kijken wat voor content je gaat aanbieden. Zo weten we zeker dat jij de juiste mensen bereikt.</p>
           <a href="/voor-teacher-2-2/" class="btn btnbtnCreeerJe" data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">Creëer je omgeving gratis</a>
       </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-109.png" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">Verkopen</h3>
                        <p class="descriptionCardVoorOrganisatie">
                            Jouw kennis(producten) ook direct verkopen via Livelearn? Dat kan eenvoudig, of dit nu een opleiding, workshop, podcast of artikel is, wij bieden het format en de tools om het aan te bieden. Je betaalt alleen wanneer er ook daadwerkelijk iets gekocht is en je krijgt real-time inzichten in financiële groei.
                        </p>
                        <a href="/verkopen" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">Meer over &nbsp;<strong>verkopen</strong></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/photo_5897718936634506184_y.jpeg" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">Creëren</h3>
                        <p class="descriptionCardVoorOrganisatie">
                            Kennisproducten maken vanuit onze auteurstool? Vanuit het LiveLearn teacher dashboard creëer je in een paar klikken jouw kennisproduct en deel je deze direct met de rest van de wereld. Dit kunnen zowel betaalde als gratis kennisproducten zijn.
                        </p>
                        <a href="/creeren" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">
                            Meer over &nbsp;<strong class="">creëren</strong>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/photo_5897718936634506185_y.jpeg" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">Uitleggen</h3>
                        <p class="descriptionCardVoorOrganisatie">
                            Lever je producten of diensten waarbij duidelijke uitleg van toegevoegde waarde is? Dan werken wij graag met je samen om te zorgen dat jouw (potentiële) klanten altijd op de hoogte zijn van jouw ontwikkelingen. Wij bieden workshops, productvideo's of audiobegeleiding direct aan vanuit onze mobiele app.
                        </p>
                        <a href="/uitleggen" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">Meer over&nbsp;<strong>uitleggen</strong> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>