<?php
    $users = get_users();
    
    $user_connected = wp_get_current_user();
 

?>
<div class="contentPageManager">
    <form action="my-team/" method="post">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="cardCoursManagerGlocal"> 
                <a href="/dashboard/company/people/" class="cardCoursManager">
                    <p class="contentText">Mijn<br>
                        <b>Mensen</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Mijn_mensen.png" alt="">
                    </div>
                </a>
                <a href="/dashboard/company/learning-modules/" class="cardCoursManager">
                    <p class="contentText">Jouw<br>
                        <b>Leermodules</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image29.png" alt="">
                    </div>
                </a>
                <a href="/dashboard/company/learning-databank/" class="cardCoursManager">
                    <p class="contentText">Livelearn <br>
                        <b>Leerdatabank</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/LiveLearn_leerdatabank.png" alt="">
                    </div>
                </a>
                <a href="#" class="cardCoursManager">
                    <small>Coming soon!</small>
                    <p class="contentText">Overzicht<br>
                        <b>Leerbudget</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image_35.png" alt="">
                    </div>
                </a>
                <a href="#" class="cardCoursManager">
                    <small>Coming soon!</small>
                    <p class="contentText">Communicatie<br>
                        <b>Berichten</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image32.png" alt="">
                    </div>
                </a>
                <a href="statistic" class="cardCoursManager">
                    <p class="contentText">Inzicht <br>
                        <b>statistieken</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Inzicht_statistieken.png" alt="">
                    </div>
                </a>
                <a href="/dashboard/company/profile-company/" class="cardCoursManager">
                    <p class="contentText">Jouw<br>
                        <b>Instellingen</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image27.png" alt="">
                    </div>
                </a>
                <a href="/dashboard/company/allocate/" class="cardCoursManager">
                    <p class="contentText">De<br>
                        <b>Organisatie</b>
                    </p>
                    <div class="blockImgcardCoursManagerGlobal">
                        <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image33.png" alt="">
                    </div>
                </a>
            </div>

            <div class="allBlockWorjforce">
                <p class="workforceTitle">De workforce</p>
                <div class="groupCard">
                    <a href="#" class="cardCours">
                        <small>Coming soon!</small>
                        <p class="contentText">Werknemer<br>
                            <b>Instroom</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/image-43.png" alt="">
                        </div>
                    </a>
                    <a href="#" class="cardCours">
                        <small>Coming soon!</small>
                        <p class="contentText">Werknemer<br>
                            <b>Doorstroom</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image-44.png" alt="">
                        </div>
                    </a>
                    <a href="#" class="cardCours">
                        <small>Coming soon!</small>
                        <p class="contentText">Werknemer<br>
                            <b>Uitstroom</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/Image-45.png" alt="">
                        </div>
                    </a>
                   <?php if( in_array('administrator', $user_connected->roles) || in_array('manager', $user_connected->roles) ) { ?>
                    <a href="/dashboard/company/grant" type="submit" style="border:none; background:white;" class="cardCours">
                        <p class="contentText">Selecteer <br>
                            <b>Je managers</b>
                        </p>
                        <div class="blockImgCardCoursGlobal">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/chrono.png" alt="">
                        </div>
                    </a> 
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>


</html>




