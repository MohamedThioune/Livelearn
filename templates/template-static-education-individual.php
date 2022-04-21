<?php /** Template Name: Static education individual template */ ?>

<?php 
    extract($_POST);

    extract($_GET);

    if(isset($education_individual))
        if(isset($email)){
        
            if($email != null)
            {

                if($first_name == null)
                    $first_name = "ANONYM";
                
                if($last_name == null)
                    $last_name = "ANONYM";

                $userdata = array(
                    'user_pass' => $password,
                    'user_login' => $user_login,
                    'user_email' => $email,
                    'user_url' => 'http://livelearn.nl/',
                    'display_name' => $first_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'role' => 'Klant'
                );

                $user_id = wp_insert_user(wp_slash($userdata));

                if(is_wp_error($user_id)){
                    $danger = $user_id->get_error_message();
                    header("location:registreren?message=".$danger."&danger");

                }else{
                    $success = "U bent succesvol geregistreerd<br>";
                    update_field('telnr', $phone, 'user_'.$user_id);
                    update_field('subscription_company', $bedrij, 'user_'.$user_id);
                    
                    $subject = 'Welcome onboard ✨';
                    $body = "
                    <h1>Hello " . $first_name  . "</h1><br> 
                    Your are successfully registered , welcome onboard<br><br>
                    <h4><a href='http://livelearn.nl/inloggen'> Connexion </a></h4>
                    ";
                
                    $headers = array( 'Content-Type: text/html; charset=UTF-8','From: Livelearn <info@livelearn.nl>' );

                    wp_mail($email, $subject, $body, $headers, array( '' )) ; 
                    header("location:static-education-individual?message=".$success."&success");
         
                }

              
            }
            else{
                $danger = "Vul de e-mail in, alsjeblieft";
                header("location:static-education-individual?message=".$danger."&danger");
            }
        }
?>

<?php wp_head(); ?>
<?php get_header(); ?>

    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<div class="boxBlijven">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h1 class="BlijvenText">Blijf je leven lang ontwikkelen</h1>
                <p class="altjidText bottomTextMaak">-Maak meteen een gratis en persoonlijke leeromgeving</p>
                <p class="altjidText bottomTextMaak">-Altijd direct antwoord op je vragen over opleiden geving</p>
                <p class="altjidText bottomTextMaak">-Het grootste aanbod van zakelijke trainingen EN persoonlijke interesses</p>
                <a href="/static-education-advice"  class="btn btnMeerInformation">Meer informatie</a>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="blockForm">
                    <p class="gratisText gratisText2">Gratis</p>
                    <p><b>Meld je aan</b></p>
                    <center>
                        <?php if(isset($_GET['success'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ?>
                        <?php if(isset($_GET['danger'])) echo "<span class='alert alert-danger'>" . $_GET['message'] . "</span><br><br>" ?>
                    </center>
                    <?php echo (do_shortcode('[user_registration_form id="59"]')); ?>
                    <!-- <form action="/static-education-individual" method="POST" class="formBoekGratis">
                        <input type="text" name="user_login"  placeholder="Gebruikersnaam*" required>
                        <input type="text" name="first_name"  placeholder="Voornaam*" required>
                        <input type="text" name="last_name" placeholder="Achternaam*" required>
                        <input type="text" name="bedrij" placeholder="Bedrijf">
                        <input type="text" name="email"  placeholder="E-mailadres*" required>
                        <input type="text" name="phone" placeholder="Telefoonnummer*" required>
                        <input type="password" name="password" placeholder="Wachtwoord" required>
                        <button type="submit" name="education_individual" class="btn btnAanvraag">Aanvraag indienen </button>
                    </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="blockEducationIndividualPage">
    <div class="blockOnzeService">
        <div class="container">
            <div class="blockTextScholingsadvies">
                <h2 class="TextScholingsadvies">Onze services voor jou</h2>
                <p class="voorJouText">Je moet het alleen wel zelf doen. Wij bieden jouw een persoonlijke omgeving die je mee kan nemen naar je huidige of toekomstige werkgevers en zorgen voor een actueel en relevant opleidingsaanbod.</p>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-4 ">
                    <div class="cardOnzeServices">
                        <div class="headCard">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/hommeVert.png" alt="">
                        </div>
                        <div class="contentCardGratis">
                            <p class="gratisTitle">Scholingsadvies en persoonlijke begeleiding</p>
                            <p class="gratisContent">Loop je vast in je werk of wordt je steeds afgewezen. Wij helpen je graag met het maken van een plan en adviseren je waar de kansen op de markt liggen</p>
                            <button class="btn btnPlanEen2">Bekijk ons aanbod.</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 ">
                    <div class="cardOnzeServices">
                        <div class="headCard">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/femme1.png" alt="">
                        </div>
                        <div class="contentCardGratis">
                            <p class="gratisTitle">Vind de opleiding, training of workshop die bij jou past</p>
                            <p class="gratisContent">Wij zorgen voor een compleet aanbod leeropties en garanderen de beste prijs. Mis je toch iets? Dan zoeken we het gewoon uit en voegen we het toe aan het assortiment.</p>
                            <button class="btn btnPlanEen2">Bekijk onze opleidingen</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 ">
                    <div class="cardOnzeServices">
                        <div class="headCard">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/groupHomme.png" alt="">
                        </div>
                        <div class="contentCardGratis">
                            <p class="gratisTitle">Vind de opleiding, training of workshop die bij jou past</p>
                            <p class="gratisContent">Wij zorgen voor een compleet aanbod leeropties en garanderen de beste prijs. Mis je toch iets? Dan zoeken we het gewoon uit en voegen we het toe aan het assortiment.</p>
                            <button class="btn btnPlanEen2 meldBtn">Meld je gratis aan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blockOnsTeam">
            <div class="imgOnsTeam">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
            </div>
            <div class="contentOnsTeam">
                <p class="onsTeamText">Ons team van scholingsexperts staat altijd voor je klaar om je te begeleiden in jou ontwikkeling</p>
                <p class="voorJouText2">Voor jou dus ja, wij helpen je met je professionele en persoonlijke groei. Of je nu opzoek bent naar een (nieuwe) baan of wil groeien binnen je huidige of je persoonlijke interesses wil ontwikkelen.</p>
                <a href="" class="btn btnLeesMeer">Lees meer en start eenvoudig</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blockOnsTeam2">
            <div class="contentOnsTeam2">
                <p class="onsTeamText">Ons team van scholingsexperts staat altijd voor je klaar om je te begeleiden in jou ontwikkeling</p>
                <p class="voorJouText2">Voor jou dus ja, wij helpen je met je professionele en persoonlijke groei. Of je nu opzoek bent naar een (nieuwe) baan of wil groeien binnen je huidige of je persoonlijke interesses wil ontwikkelen.</p>
                <a href="" class="btn btnLeesMeer">Lees meer en start eenvoudig</a>
            </div>
            <div class="imgOnsTeam2">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
            </div>
        </div>
    </div>
    <div class="blockMaandelijks">
        <div class="container">
            <div class="contentMaandelijks">
                <p class="titleBlockMaandelijs">Maandelijks sparen voor jouw ontwikkeling in je persoonlijke Leerfonds</p>
                <a href="" class="btn btnLeesMeer">Lees meer en start eenvoudig</a>
                <div class="blockImgSeconContentMaandelijks">
                    <div class="elementImgMaandelijks">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe-223.png" alt="">
                    </div>
                    <div class="blockBull">
                        <hr class="hrBull">
                        <div class="bull"></div>
                        <div class="bull"></div>
                        <div class="bull"></div>
                        <div class="bull"></div>
                    </div>
                    <div class="bullText">
                        <p>Spaar privé of samen met je werkgever
                        <p>Kies een maandelijks bedrag</p>
                        <p>Vul je gegevens en leerwensen in</p>
                        <p>Wij doen de rest en geen verborgen kosten</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blockValOpEnVerbind">
        <div class="container">
            <div class="ContentBlockValOpEnVerbind">
                <p class="TitleblockValOpEnVerbind">Val op en verbind je aan je werkgever, uitzendbureau’s of detacheerders die bij jou passen</p>
                <p class="subTitleblockValOpEnVerbind">
                    Zo kom je snel aan een (nieuwe) baan of ben je zichtbaar voor kansen die zich voordoen in de markt. Bij LiveLearn noemen wij dit de Nederlandse talentenpool.</p>
                <div class="cardBlockValOpEnVerbind">
                    <div class="OnecardBlockValOpEnVerbind">
                        <div class="headcardBlockValOpEnVerbind">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe-218.png" alt="">
                        </div>
                        <p class="titlecardBlockValOpEnVerbind">Organisaties</p>
                        <p class="subTitlecardBlockValOpEnVerbind">Bekijk de organisaties die aangesloten zijn aan de LiveLearn community,</p>
                    </div>
                    <div class="OnecardBlockValOpEnVerbind">
                        <div class="headcardBlockValOpEnVerbind">
                            <img class="imgGroup222" src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe-222.png" alt="">
                        </div>
                        <p class="titlecardBlockValOpEnVerbind">Intermediairs</p>
                        <p class="subTitlecardBlockValOpEnVerbind">Bekijk de intermediairs die aangesloten zijn aan de LiveLearn community,</p>
                    </div>
                </div>
            </div>
            <div class="sponsortBlock ">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sponsortOne.png" class="sponsortImg" alt="">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sponsortTwo.png" class="sponsortImg" alt="">
            </div>
        </div>
    </div>
</div> -->


<?php get_footer(); ?>
<?php wp_footer(); ?>