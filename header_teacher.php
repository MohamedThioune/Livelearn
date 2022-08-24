<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="Fluidify">
        <meta name='keywords' content="fluidify">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/rating.css" />
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css'>


        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body>
        <div class="contentOne">
            <nav class="navbar navWeb navbar-expand-lg navbar-dark navModife">
                <div class="container-fluid">
                    <a class="navbar-brand navBrand" href="/dashboard/user/">
                        <div class="logoModife">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_white.png" alt="">
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Voor organisaties </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Scholing van personeel</a>
                                <a class="dropdown-item" href="#">Ons learning experience platform</a>
                                <a class="dropdown-item" href="#">Onboarding </a>
                                <a class="dropdown-item" href="#">Outplacement </a>
                                <a class="dropdown-item" href="#">Leercultuur </a>
                                <a class="dropdown-item" href="#">Financiering met Leerfonds</a>
                                <a class="dropdown-item" href="#">Cases</a>
                                <a class="dropdown-item" href="#">Contact</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a href="/opleiders" class="nav-link dropdown-toggle" role="button" id="opleiders" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Voor opleiders </a>
                            <div class="dropdown-menu" aria-labelledby="opleiders">
                                <a class="dropdown-item" href="#">Aanmelden </a>
                                <a class="dropdown-item" href="#">Ons platform </a>
                                <a class="dropdown-item" href="#">Beheer al jouw content </a>
                                <a class="dropdown-item" href="#">Opleidingen toevoegen</a>
                                <a class="dropdown-item" href="#">E-learning toevoegen</a>
                                <a class="dropdown-item" href="#"> Cases </a>
                                <a class="dropdown-item" href="#">Contact</a>
                            </div>
                        </li>
                    </ul>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <form action="product_search.php" method="POST" class="form-inline ml-auto mb-0 ">
                            <input type="hidden" id="filter_course" value="<?php echo $filter_course ?>">
                            <input type="hidden" id="filter_subtopic" value="<?php echo $filter_subtopic ?>">
                            <input class="form-control InputDropdown1 mr-sm-2 inputSearch" name="search" type="search" placeholder="Zoek opleidingen, experts en onderwerpen" aria-label="Search" id="search_text">
                            <div class="autocomplete-suggestions" id="autocomplete">
                            </div>
                        </form>
                        <ul class="navbar-nav ">
                            <li class="nav-item active">
                                <a class="nav-link dropdown-toggle" role="button" id="Over" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Over ons</a>
                                <div class="dropdown-menu" aria-labelledby="Over">
                                    <a class="dropdown-item" href="#"> LIFT lid worden / leerfonds</a>
                                    <a class="dropdown-item" href="#">Onze onderwerpen </a>
                                    <a class="dropdown-item" href="#">Onze opleiders </a>
                                    <a class="dropdown-item" href="#">Onze experts</a>
                                    <a class="dropdown-item" href="#">Wie zijn wij</a>
                                    <a class="dropdown-item" href="#">Verhalen van gebruikers</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dropdown-toggle" role="button" id="Opleidingen" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">Opleidingen</a>
                                <div class="dropdown-menu" aria-labelledby="Opleidingen">
                                    <a class="dropdown-item" href="#">Richting een baan </a>
                                    <a class="dropdown-item" href="#">Groei binnen je functie </a>
                                    <a class="dropdown-item" href="#">Specifieke skills </a>
                                    <a class="dropdown-item" href="#">Persoonlijke interesses </a>
                                </div>
                            </li>
                            <li class="nav-item" href="#">
                                <a class="nav-link" href="login/index.php"><b>Inloggen</b></a>
                            </li>
                            <li class="">
                                <a href="#" class="nav-link worden">Lid worden</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <nav class="navMobile">
                <div class="ProfilGraduatioBlock">
                    <div class="sousNav1">
                        <div class="boxImgNav">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/ProfilMobile.png" alt="">
                        </div>
                        <div class="boxImgNav2">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/graduationMobile.png" alt="">
                            <div class="notification">1</div>
                        </div>
                    </div>
                    <div class="sousNav2">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoMobil.png" alt="">
                    </div>
                    <div class="sousNav3">
                        <div class="boxSousNav3-1">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/searchMobil.png" alt="">
                        </div>
                        <button class="btn boxSousNav3-2">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/burgerMobile.png" alt="">
                        </button>
                        <button class="btn  croie">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/XMobile.png" alt="">
                        </button>
                    </div>
                </div>
            </nav>
            <div class="sousMenuNavMobil">
                <div class="elementGroupGroeien">
                    <div class="groupGroein">
                        <p class="elementsousMenuNav">Groeien richting een baan</p>
                        <button class="btn btnsousgroeien btnModifeMenue">
                            <img src="<?php echo get_stylesheet_directory_uri();?><?php echo get_stylesheet_directory_uri();?>/imgfleG2.png" alt="">
                        </button>
                    </div>
                    <div class="groupGroein">
                        <p class="elementsousMenuNav">Groeien binnen je functie</p>
                        <button class="btn btnsousgroeien btnModifeMenue Groeien-binnen">
                            <img src="img/fleG2.png" alt="">
                        </button>
                    </div>
                    <div class="groupGroein">
                        <p class="elementsousMenuNav ">Ontwikkel specifieke skills</p>
                        <button class="btn btnsousgroeien btnModifeMenue Ontwikkel-specifieke">
                            <img src="img/fleG2.png" alt="">
                        </button>
                    </div>
                    <div class="groupGroein">
                        <p class="elementsousMenuNav">Ontwikkel persoonlijke interesses</p>
                        <button class="btn btnsousgroeien btnModifeMenue Ontwikkel-persoonlijke">
                            <img src="img/fleG2.png" alt="">
                        </button>
                    </div>


                    <div class="Groeien-binnen-block">
                        <div class="sousElementGroeien-binnen-block">
                            <div class="imgBlockG1">
                                <img class="fleG1 Groeien-binnen" src="img/fleG1.png" alt="">
                            </div>
                            <a href="" class="elementsousMenuNav">Human ressources (HR)</a>
                            <a href="" class="elementsousMenuNav">Financieel</a>
                            <a href="" class="elementsousMenuNav">Innovatie en R&D</a>
                            <a href="" class="elementsousMenuNav">Inkoop</a>
                            <a href="" class="elementsousMenuNav">Verkoop en sales</a>
                            <a href="" class="elementsousMenuNav">IT en data</a>
                            <a href="" class="elementsousMenuNav">Marketing</a>
                            <a href="" class="elementsousMenuNav">Operations</a>
                            <a href="" class="elementsousMenuNav">Logistiek</a>
                            <a href="" class="elementsousMenuNav">Legal</a>
                            <a href="" class="elementsousMenuNav">Productie</a>
                        </div>
                    </div>
                    <div class="Ontwikkel-specifieke-block">
                        <div class="sousElementGroeien-binnen-block">
                            <div class="imgBlockG1">
                                <img class="fleG1 Ontwikkel-specifieke" src="img/fleG1.png" alt="">
                            </div>
                            <a href="" class="elementsousMenuNav">Zorg</a>
                            <a href="" class="elementsousMenuNav">Techniek, productie en bouw</a>
                            <a href="" class="elementsousMenuNav">IT en data</a>
                            <a href="" class="elementsousMenuNav">Transport en logistiek</a>
                            <a href="" class="elementsousMenuNav">Justitie, veiligheid en bestuur</a>
                            <a href="" class="elementsousMenuNav">Ondeerwijs, cultuur en wetenschap</a>
                            <a href="" class="elementsousMenuNav">Media en communicatie</a>
                            <a href="" class="elementsousMenuNav">Landbouw, natuur en visserij</a>
                            <a href="" class="elementsousMenuNav">Handel en dienstverlening</a>
                            <a href="" class="elementsousMenuNav">Toerisme, recretie en horeca</a>
                        </div>
                    </div>
                    <div class="Ontwikkel-persoonlijke-block">
                        <div class="sousElementGroeien-binnen-block">
                            <div class="imgBlockG1">
                                <img class="fleG1 Ontwikkel-persoonlijke" src="img/fleG1.png" alt="">
                            </div>
                            <a href="" class="elementsousMenuNav"><b>Jouw profiel</b></a>
                            <a href="" class="elementsousMenuNav">Zelf LIFT lid worden</a>
                            <a href="" class="elementsousMenuNav">Voor opleider / expert</a>
                            <a href="" class="elementsousMenuNav">Voor organisaties / Werkgevers</a>
                            <a href="" class="elementsousMenuNav"><b>Inloggen</b></a>
                        </div>
                    </div>
                </div>
                <div class="block1">
                    <a href="" class="elementsousMenuNav">Onderwerpen</a>
                    <a href="" class="elementsousMenuNav">Opleidingen</a>
                    <a href="" class="elementsousMenuNav">Inloggen</a>
                </div>
                <div class="block1">
                    <a href="" class="elementsousMenuNav">LIFT</a>
                    <a href="" class="elementsousMenuNav">Voor opleiders en experts</a>
                    <a href="" class="elementsousMenuNav">Voor organisaties</a>
                </div>
                <div class="block1">
                    <a href="" class="btnRegistreren">Registreren</a>
                    <a href="" class="btnInloggen">Inloggen</a>
                </div>
            </div>
        </div>


        <div id="main">