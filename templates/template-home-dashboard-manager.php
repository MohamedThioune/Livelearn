<?php /** Template Name: dashboard manager */ ?>

<div class="contentOne">
    <?php require 'headerDashboard.php';?>
</div>

<div class="contentPageManager">
    <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?php require 'layaoutManager.php';?>
        </div>
        <div class="col-md-9">
            <div>
                <div class="cardCoursGlocal">
                    <a href="manager-people-overview-mensen" class="cardCours">
                        <p class="contentText">Min<br>
                            <b>Mensen</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image30.png" alt="">
                        </div>
                    </a>
                    <a href="manager-onze-leer-module" class="cardCours">
                        <p class="contentText">Jour<br>
                            <b>Leermodules</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image29.png" alt="">
                        </div>
                    </a>
                    <a href="manager-leer-databank" class="cardCours">
                        <p class="contentText">Livelearn <br>
                            <b>Leerdatabank</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image31.png" alt="">
                        </div>
                    </a>
                    <a href="{{enrolementsURL}}" class="cardCours">
                        <p class="contentText">Overzicht<br>
                            <b>Leerbudget</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image28.png" alt="">
                        </div>
                    </a>
                    <a href="{{messageURL}}" class="cardCours">
                        <p class="contentText">Communicatie<br>
                            <b>Berichten</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image32.png" alt="">
                        </div>
                    </a>
                    <a href="{{statisticsURL}}" class="cardCours">
                        <p class="contentText">Inzicht <br>
                            <b>statistieken</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image-39.png" alt="">
                        </div>
                    </a>
                    <a href="{{settingsURL}}" class="cardCours">
                        <p class="contentText">Jouw<br>
                            <b>Instellingen</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image27.png" alt="">
                        </div>
                    </a>
                    <a href="manager-people-overview" class="cardCours">
                        <p class="contentText">De<br>
                            <b>Organisatie</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image33.png" alt="">
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>



<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/style.js"></script>

</body>
</html>




