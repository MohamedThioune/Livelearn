<?php /** Template Name: Voor teacher template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<div>
    <div class="contentOne">
        <div class="VoorTeacher">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="wordenBlock1">
                            <div class="">
                                <h1 class="CreeerText">Word onderdeel van het grootste expert / opleidersnetwerk</h1>
                                <p class="StimuleerText">Deel jouw kennis met de rest van Nederland</p>
                                <a href="/voor-teacher-detail/"  class="btn btnMeerInformation">Meer informatie</a>
                            </div>
                            <div class="imgComponent2">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/headWeb8.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="blockForm">
                            <p><b>Activeer zakelijke</b> <br> Leeromgeving </p>
                            <form action="" class="formBoekGratis">
                                <input type="text" placeholder="Voornaam*" required>
                                <input type="text" placeholder="Achternaam*" required>
                                <input type="text" placeholder="Bedrijf">
                                <input type="text" placeholder="E-mailadres*" required>
                                <input type="text" placeholder="Telefoonnummer*" required>
                                <button class="btn btnAanvraag">Aanvraag indienen </button>
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