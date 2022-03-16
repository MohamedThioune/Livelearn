<?php /** Template Name: Home Dashboard Teacher */ ?>

<div class="contentOne">
    <?php get_header(); ?>
</div>

<div class="contentPageManager">
    <div class="row">
        <div class="col-md-3">
            <?php require 'layaoutTeacher.php';?>
        </div>
        <div class="col-md-9">
            <div>
                <div class="cardCoursGlocal">
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Toevoegen <br>
                            <b>Opleiding</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image30.png" alt="">
                        </div>
                    </a>
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Overzicht<br>
                            <b>Opleiding</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image29.png" alt="">
                        </div>
                    </a>
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Inzicht <br>
                            <b>Financien</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image31.png" alt="">
                        </div>
                    </a>
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Overzicht<br>
                            <b>Inschrijvingen</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image28.png" alt="">
                        </div>
                    </a>
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Communicatie<br>
                            <b>Berichten</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image32.png" alt="">
                        </div>
                    </a>
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Inzicht <br>
                            <b>statistieken</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-39.png" alt="">
                        </div>
                    </a>
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Jouw<br>
                            <b>Instellingen</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image27.png" alt="">
                        </div>
                    </a>
                    <a href="add-course-selection" class="cardCours">
                        <p class="contentText">Jouw<br>
                            <b>Profiel</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image33.png" alt="">
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
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="js/style.js"></script>




