<?php /** Template Name: Inloggen */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<div class="contentOne">
</div>
<div>
    <div class="contentLogin">
        <div class="container">
            <div class="contentLogin">
                <div class="row rowModife ">
                    <div class="col-lg-6  col-md-5">
                        <a href="/registreren" class="boxLOginCardOne">
                            <div class="blockImgCarLogin">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Composant1.png" alt="">
                            </div>
                            <p class="textNog"> Nog geen account? Meld je <br>
                                direct gratis aan!
                            </p>
                        </a>
                        <a href="/voor-organisaties" class="boxLOginCardOne">
                            <div class="blockImgCarLogin">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe8.png" alt="">
                            </div>
                            <p class="textNog"> Voor organisties</p>
                        </a>
                        <a href="/voor-teachers" class="boxLOginCardOne">
                            <div class="blockImgCarLogin">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/headWeb8.png" alt="">
                            </div>
                            <p class="textNog">Voor Experts en Opleiders</p>
                        </a>
                    </div>
                    <div class="col-lg-6  col-md-7">
                        <div class="boxCardForm">
                            <p class="TitleForm">Jouw leeromgeving</p>
                            <div class="form-block">
                                <!--
<div class="form-item">
<input type="text" id="name" placeholder="Gebruilekersnaam" class="block-input-form" required>
</div>
<div class="form-item">
<input type="text" id="password" placeholder="E-mailadres" class="block-input-form" required>
</div>
<button type="button" id="submit" type="button" value="Submit" class="btn btnLogin">Log-in</button>
<a href="" class="redirectionText">Wachtwoord vergeten ?</a>
-->

                                <?php
                                wp_login_form([
                                    'redirect' => 'http://wp12.influid.nl/dashboard/user/',
                                    'remember' => false,
                                    'label_username' => 'Wat is je e-mailadres?',
                                    'placeholder_email' => 'E-mailadress',
                                    'label_password' => 'Wat is je wachtwoord?'
                                ]);
                                ?>
                                <a href="registreren/" class="redirectionText">Wachtwoord vergeten ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>
    jQuery(document).ready(function(){
        jQuery('#user_login').attr('placeholder', 'E-mailadres of Gebruikersnaam');
        jQuery('#user_pass').attr('placeholder', 'Wachtwoord');
    });
</script>