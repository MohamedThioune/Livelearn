<?php /** Template Name: overview-organisaties */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="container-fluid">
    <div class="contentOverviewOrganisatie">
       <div class="headOverviewOrganisatie">
           <h1>Een Lerende organisatie voor klein én groot</h1>
           <p class="description">Wij hanteren geen opstartkosten, dus iedereen kan meteen van start </p>
           <a href="" class="btn btnbtnCreeerJe">Creeer je omgeving gratis</a>
       </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card cardOverviewOrganisatie">
                    <div class="imgcardOverviewOrganisatie">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ZZPersStratup.png" alt="">
                    </div>
                    <div class="bodyCardOverviewOrganisatie">
                        <h3 class="titleCardVoorOrganisatie">ZZP’ers en Startups</h3>
                        <p class="descriptionCardVoorOrganisatie">Een goede organisatie start bij jezelf. Daarom zorgen wij dat ZZP’ers en startende organisaties eenvoudig een eigen ontwikkelomgeving kunnen creëren.  Alle ontwikkelingen in jouw markt direct op één plaats.</p>
                        <a href="/overview-organisations-1" class="btn btnCardOverviewOrganisatie">Meer voor ZZP’ers</a>
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
                        <a href="/overview-organisations-2" class="btn btnCardOverviewOrganisatie">Meer voor MKB</a>
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
                        <a href="/overview-organisations-2" class="btn btnCardOverviewOrganisatie">Meer voor Corporates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>