<?php /** Template Name: overview-organisaties */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="container-fluid">

    <!-- -----------------------------------Start Modal Sign In ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade " id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="position: absolute; ">
        <div class="modal-dialog" role="document" style="width: 96% !important;">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 20px !important">&times;</span>
                    </button>
                </div>
                <div class="modal-body  px-md-5 p-3">

                    <div class="text-center"><h4 style="color:#043356">Activeer zakelijke </h4></div>
                    <div class="text-center"><h6 style="color:#043356">Leeromgeving </h6></div> <br>

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
           <h1>Een Lerende organisatie voor klein én groot</h1>
           <p class="description">Wij hanteren geen opstartkosten, dus iedereen kan meteen van start. </p>
           <a href="/voor-organisaties/" class="btn btnbtnCreeerJe" data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">Creeer je omgeving gratis</a>
       </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ZZPersStratup.png" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">ZZP'ers en Startups</h3>
                        <p class="descriptionCardVoorOrganisatie">Een goede organisatie start bij jezelf. Daarom zorgen wij dat ZZP’ers en startende organisaties eenvoudig een eigen ontwikkelomgeving kunnen creëren.  Alle ontwikkelingen in jouw markt direct op één plaats.</p>
                        <a href="/zzpers" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">Meer voor ZZP'ers</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Midden.png" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">Midden en Klein bedrijf</h3>
                        <p class="descriptionCardVoorOrganisatie">Wel personeel, maar nog geen speciale afdeling voor talent management en leren & ontwikkelen. Tot een organisatie van 250 man nemen wij alle taken over, van borging van skills tot het aanbieden van een gestroomlijnde onboarding. </p>
                        <a href="/sme/" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">Meer voor MKB</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Grootbedrijf.png" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">Grootbedrijf</h3>
                        <p class="descriptionCardVoorOrganisatie">Een corporate organisatie, wellicht met meerdere locaties over de wereld. Borg je kennis in één dashboard, houd bij waar de ontwikkelkansen liggen met HR-analytics en geef managers de handvatten om hun teams optimaal te laten presteren </p>
                        <a href="/corporate/" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">Meer voor Corporates</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-dienstverlening">
            <div class="first-block">
                <p class="title">HR-dienstverlening</p>
                <p class="description">Onze HR dienstverlening staat op het snijvlak van verandering en innovatie. In een tijd waarin digitalisering en de war-on-talent de norm zijn geworden, begrijpen wij de behoefte aan vernieuwing. </p>
            </div>
            <div class="second-block">
                <img class="lees-mer-img" src="<?php echo get_stylesheet_directory_uri();?>/img/leer-meer.png" alt="">
                <a href="/HR-dienstverlening/ " class="btn btn-Lees-meer">Lees meer</a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>