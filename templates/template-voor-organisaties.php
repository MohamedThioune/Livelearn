<?php /** Template Name: Voor organisaties template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<?php
if (isset($_GET['email']) && isset($_GET['firstName']) && isset($_GET['lastName']) && isset($_GET['company']) && isset($_GET['size']) && isset($_GET['phone']))
    var_dump($_GET);
?>

<div class="VoorOrganisaties">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 order-md-0 order-1 text-md-left text-center">
                <div class="wordenBlock1">
                    <div class="">
                        <h1 class="CreeerText2">Creëer een constant lerende organisatie en trek talent aan</h1>
                        <p class="StimuleerText2">Stimuleer de in- en doorstroom van jouw (flexibele) werknemers, zodat zij jouw bedrijf naar het volgende niveau kunnen tillen.</p>
                        <a href="/overview-organisaties/" class="meerInformatieBtn" >Meer informatie</a>
                    </div>
                    <div class="imgComponent2 mb-md-0 mb-4">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe8.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 order-md-1 order-0 pb-md-0 pb-3">
                <div class="blockForm2">
                    <p><b>Activeer zakelijke Leeromgeving</b> <br>het is gratis </p>
                        <?php
                            //echo do_shortcode("[gravityform id='5' title='false' description='false' ajax='true']");
                        ?>
                    <!--
                    <form action="" method="POST" id="new-form-register-workflow">
                        <div class="first-step-modal">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter your email address">
                            </div>
                            <button type="button" class="btn btn-connection text-white" id="create-account-step">Create Account</button>
                        </div>

                        <div class="second-step-modal">
                            <div class="form-group">
                                <label for="First-name">First name</label>
                                <input type="text" class="form-control" id="First-name" name="firstName" placeholder="Enter your First name" required>
                            </div>
                            <div class="form-group">
                                <label for="last-name">Last name</label>
                                <input type="text" class="form-control" id="last-name" name="lastName" placeholder="Enter your last name" required>
                            </div>
                            <div class="form-group">
                                <label for="company">Company Name</label>
                                <input type="text" class="form-control" id="company" name="company" placeholder="Enter your Company name">
                            </div>
                            <div class="form-group">
                                <label for="size">Number of people</label>
                                <input type="number" class="form-control" id="size" name="size" placeholder="Enter your phone-number">
                            </div>
                            <div class="form-group">
                                <label for="phone-number">phone number</label>
                                <input type="text" class="form-control" id="phone-number" name="phone" placeholder="Enter your phone-number">
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-switch-email d-none mb-2 text-white" type="button">Return on Email</button>
                                <button type="submit" class="btn btn-connection text-white">Create Acccount</button>
                            </div>
                        </div>
                    </form>
                    -->
                </div>
            </div>
            <form action="/livelearn/voor-test-company/" method="POST" class="border-2">
                <label for="exampleInputEmail1">Email address</label> <br>
                <input type="email" id="exampleInputEmail1" name="email" placeholder="Enter your email address"><br>

                <label for="First-name">First name</label><br>
                <input type="text" id="First-name" name="firstName" placeholder="Enter your First name"><br>

                <label for="last-name">Last name</label><br>
                <input type="text" id="last-name" name="lasstName" placeholder="Enter your Last name"><br>

                <label for="First-name">company name</label><br>
                <input type="text" id="company" name="company" placeholder="Enter your company name"><br>

                <label for="size">size company</label><br>
                <input type="number" id="size" name="size" placeholder="Enter your number of empoyer"><br>

                <label for="First-name">telephone number</label><br>
                <input type="text" id="First-name" name="firstName" placeholder="Enter your telephone number"><br>

                <button class="submit btn-round-full" id="submit">submit</button>
            </form>
        </div>
    </div>
</div>

<!-- <div class="blockEducationIndividualPage">
    <div class="blockLiftLid">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="LIFTText">LIFT LID</p>
                    <P class="StimuleerEnText">Stimuleer en beloon je werknemers</P>
                    <p>Geef je werknemers alle handvatten om zich te blijven ontwikkelen, zowel zakelijk- als persoonlijk interesses. Maak je personeel direct LiveLearn <b>LIFT Lid</b> .</p>
                    <ul class="ulListeModife">
                        <li>Direct gekoppeld aan jouw gratis LMS</li>
                        <li>Gratis content + tot wel 65% korting op alle leermodules</li>
                        <li>Een combinatie van professionele ontwikkeling en persoonlijke interesses</li>
                    </ul>
                    <a href="" class="btnHoppa">Hoppa, mijn werknemers in de LIFT</a>
                </div>
                <div class="col-md-6">
                    <div class="StimuleerImg">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-38.png" alt="">
                    </div>
                </div>

            </div>
            <div class="blocKCardVoorOrganisaties">
                <div class="row">
                    <div class="col-md-3">
                        <div class="cardVoorOrganisaties">
                            <img class="ImgcardVoorOrganisaties" src="<?php echo get_stylesheet_directory_uri();?>/img/Image-39.png" alt="">
                            <p>Trainingen </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="cardVoorOrganisaties">
                            <img class="ImgcardVoorOrganisaties" src="<?php echo get_stylesheet_directory_uri();?>/img/Image-40.png" alt="">
                            <p>Conferenties</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="cardVoorOrganisaties">
                            <img class="ImgcardVoorOrganisaties" src="<?php echo get_stylesheet_directory_uri();?>/img/Image-41.png" alt="">
                            <p>Webinars  </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="cardVoorOrganisaties">
                            <img class="ImgcardVoorOrganisaties" src="<?php echo get_stylesheet_directory_uri();?>/img/Image-42.png" alt="">
                            <p>1-on-1’s </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="blockValOpEnVerbind">
        <div class="container">
            <div class="ContentBlockValOpEnVerbind">
                <p class="TitleblockValOpEnVerbind">Één partij voor al je scholingsvragen tegen de beste prijs</p>
                <p class="subTitleblockValOpEnVerbind">Voor jou dus ja, wij helpen je met je professionele en persoonlijke groei. Of je nu opzoek bent naar een (nieuwe) baan of wil groeien binnen je huidige of je persoonlijke interesses wil ontwikkelen.</p>
                <div class="cardBlockValOpEnVerbind">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="CardQuestion">
                                <div class="headCardQuestion">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe11.png" alt="">
                                </div>
                                <p class="titleCardQuestion">Gratis LMS + inkoop <br> van opleidingen</p>
                                <p class="subTitleCardQuestion">Voor jou dus ja, wij helpen je met je professionele en
                                    persoonlijke groei. Of je nu opzoek bent naar een
                                    (nieuwe) baan of wil groeien binnen je huidige of je
                                    persoonlijke interesses wil ontwikkelen.</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="CardQuestion">
                                <div class="headCardQuestion">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/femme1.png" alt="">
                                </div>
                                <p class="titleCardQuestion">Strategisch <br>
                                    scholingsadvies</p>
                                <p class="subTitleCardQuestion"> Voor jou dus ja, wij helpen je met je professionele en
                                    persoonlijke groei. Of je nu opzoek bent naar een
                                    (nieuwe) baan of wil groeien binnen je huidige of je
                                    persoonlijke interesses wil ontwikkelen.</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="CardQuestion">
                                <div class="headCardQuestion">
                                    <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Groupe-233.png" alt="">
                                </div>
                                <p class="titleCardQuestion">Ontwikkel talent en houd hen langer vast</p>
                                <p class="subTitleCardQuestion">Voor jou dus ja, wij helpen je met je professionele en
                                    persoonlijke groei. Of je nu opzoek bent naar een
                                    (nieuwe) baan of wil groeien binnen je huidige of je
                                    persoonlijke interesses wil ontwikkelen.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="blockDaarom">
            <p class="DaaromText">Daarom maken meer dan 250 organisaties, experts en opleiders gebruik van LiveLearn</p>
            <div class="sponsortBlock ">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sponsortOne.png" class="sponsortImg" alt="">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/sponsortTwo.png" class="sponsortImg" alt="">
            </div>
            <p class="DeBasisText">De basis is gratis</p>
            <p class="JijText">Jij bepaalt wat je er mee doet</p>
            <p class="VoorJouText">Voor jou dus ja, wij helpen je met je professionele en persoonlijke groei. Of je nu opzoek bent naar een (nieuwe) baan of wil groeien binnen je huidige of je persoonlijke interesses wil ontwikkelen.</p>
            <a href="" class="MaakBtn">Maak jouw gratis omgeving</a>
        </div>
        <div class="imgTableau">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image37.png" alt="">
        </div>
    </div>
    <div class="container">
        <div class="OfMaanBlock">
            <div class="ofWordBlock">
                <p class="ofWordText">Of word LIFT member</p>
                <p class="krijgText">Krijg tot wel 65% korting op opleidingen en andere leervormen, toegang tot exclusieve events en maak gebruik van ons leven lang leren advies.</p>
                <a href="" class="ikWil">Ik wil dit</a>
            </div>
            <div class="ookBlock">
                <p class="textmaand">€ 9.95 per maand</p>
                <p class="textOok">Ook zeker af te stemmen met je werkgever</p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="Blockfaq">
            <p class="DeBasisText2">Hoe past LiveLearn bij jouw organisatie en the war on talent?</p>
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-Collapsibe  text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Aantrekken en aannemen van talent
                                <img id="dowArrow" class="arrowImg" src="<?php echo get_stylesheet_directory_uri();?>/img/down-arrow.png" alt="">
                                <img id="upArrow" class="arrowImg" src="<?php echo get_stylesheet_directory_uri();?>/img/up-arrow.png" alt="">
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            Some placeholder content for the first accordion panel. This panel is shown by default, thanks to the <code>.show</code> class.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-Collapsibe  text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Onboarding van (flexibel) personeel
                                <img id="dowArrow" class="arrowImg" src="<?php echo get_stylesheet_directory_uri();?>/img/down-arrow.png" alt="">
                                <img id="upArrow" class="arrowImg" src="<?php echo get_stylesheet_directory_uri();?>/img/up-arrow.png" alt="">
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            Some placeholder content for the second accordion panel. This panel is hidden by default.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-Collapsibe  text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Persoonlijke ontwikkel- / carriereplan
                                <img id="dowArrow" class="arrowImg" src="<?php echo get_stylesheet_directory_uri();?>/img/down-arrow.png" alt="">
                                <img id="upArrow" class="arrowImg" src="<?php echo get_stylesheet_directory_uri();?>/img/up-arrow.png" alt="">
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            And lastly, the placeholder content for the third and final accordion panel. This panel is hidden by default.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        $("#create-account-step").click(function() {
            $(".btn-switch-email").removeClass('d-none');
            $(".first-step-modal").hide();
            $(".second-step-modal").show();
        });
        $(".btn-switch-login").click(function() {
            $(".register-block").hide();
            $(".create-account-block").show();
        });
        $(".btn-switch-email").click(function() {
            $(".btn-switch-email").addClass('d-none');
            $(".second-step-modal").hide();
            $(".first-step-modal").show();
        });
        $(".btn-Sign-Up").click(function() {
            $(".register-block").show();
            $(".create-account-block").hide();
        });
    </script>
<?php get_footer(); ?>
<?php wp_footer(); ?>