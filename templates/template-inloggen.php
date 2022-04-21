<?php /** Template Name: Inloggen */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

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
                                <?php
                                wp_login_form([
                                    'redirect' => 'http://wp12.influid.nl/dashboard/user/',
                                    'remember' => false,
                                    'label_username' => 'Wat is je e-mailadres?',
                                    'placeholder_email' => 'E-mailadress',
                                    'label_password' => 'Wat is je wachtwoord?'
                                ]);
                                ?>
                                <a href="<?= wp_lostpassword_url(''); ?>" class="redirectionText">Wachtwoord vergeten ?&nbsp; | &nbsp;</a>
                                <a href="/registreren" class="redirectionText pull-right">Maak je account </a>
                                
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