<?php /** Template Name: overview-organisaties */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="container-fluid">

    <!-- -----------------------------------Start Modal Sign In ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade " id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="position: absolute; ">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: #043356">
                <div class="modal-header border-0">
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size: 20px !important">&times;</span>
                    </button>
                </div>
                <div class="modal-body  px-md-5 p-3">

                    <div class="text-center"><h4 class="text-white">Activeer zakelijke </h4></div>
                    <div class="text-center"><h6 class="text-white">Leeromgeving </h6></div> <br>

                    <form>  
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="   text" id="form3Example1" class="form-control" 
                                    placeholder="voornaam" style="background: white !important" />
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="form3Example2" class="form-control"
                                     placeholder="Achternaam" style="background: white !important"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="form3Example1" class="form-control" 
                                    placeholder="Email" style="background: white !important"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="form3Example2" class="form-control" 
                                    placeholder="Telefoon" style="background: white !important" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="form3Example1" class="form-control" 
                                    placeholder="Bedrijsnaam" style="background: white !important"/>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="form3Example2" class="form-control" 
                                    placeholder="Aantal mensen" style="background: white !important"/>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-block mb-4 fw-bold text-white" style="background: #47A99E">Vraag aan</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->


    <div class="contentOverviewOrganisatie pt-5">
       <div class="headOverviewOrganisatie">
           <h1>Een Lerende organisatie voor klein én groot</h1>
           <p class="description">Wij hanteren geen opstartkosten, dus iedereen kan meteen van start </p>
           <a href="" class="btn btnbtnCreeerJe" data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">Creeer je omgeving gratis</a>
       </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ZZPersStratup.png" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">ZZP'ers en Startups</h3>
                        <p class="descriptionCardVoorOrganisatie">Een goede organisatie start bij jezelf. Daarom zorgen wij dat ZZP'ers en startende organisaties eenvoudig een eigen ontwikkelomgeving kunnen creëren.  Alle ontwikkelingen in jouw markt direct op één plaats.</p>
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
                        <p class="descriptionCardVoorOrganisatie">Wel personeel, maar nog geen speciale afdeling voor talent management en leren & ontwikkelen. Tot een organisatie van 250 man nemen wij alle taken over, van borging van skills tot het aanbieden van een gestroomlijnde onboarding.</p>
                        <a href="/mkb" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">Meer voor MKB</a>
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
                        <p class="descriptionCardVoorOrganisatie">Een corporate organisatie, wellicht met meerdere locaties over de wereld. Borg je kennis in één dashboard, houd bij waar de ontwikkelkansen liggen met HR-analytics en geef managers de handvatten om hun teams optimaal te laten presteren</p>
                        <a href="/mkb" class="btn btnCardOverviewOrganisatie mx-auto d-flex justify-content-center">Meer voor Corporates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>