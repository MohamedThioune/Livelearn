<!DOCTYPE html>

<?php

global $wp;
$url = home_url( $wp->request );

?>

<style>
    #croieSearch {
        display: none;
        margin-top: 1px !important;
        width: 18px !important;
        padding: 0 !important;
        margin-right: 5px !important;
    }
    #croieProfil {
        margin: 4px 0px -3px -6px !important;
    }
    .navModife .activeModalHeader .modal{
        height: auto !important;
    }
    #voorOpleidersModal, #OpleidingenModal{
        height: auto;
    }

    @media all and (min-width: 1330px) {
        #searchIconeTablet, #croieSearchTablet, .tabletsearch{
            display: none !important;
        }
    }
    @media all and (min-width: 1013px) and (max-width: 1330px) {
        .form-control{
            display: none !important;
        }
    }
    @media all and (min-width: 753px) and (max-width: 1020px) {
        .body{
            padding-top: 0px !important;
        }
        .navMobile {
            height: 58px !important;
            margin-top: -12px !important;
        }
        .btn {
            padding: 0px !important;
        }
        .searchInputHedear {
            background-color: #023356 !important;
            padding: 2px 50px !important;
            margin: -20px !important;
            /* margin-top: -6px  !important; */
        }
        /* .head2 {margin-top:45px !important;}      */
        #main {
            padding-top: 40px;
        }
        .tabletsearch{display: none !important;}
    }
    @media (min-width: 300px) and (max-width: 767px){
        .navMobile-custom {
            padding: 0px 0 8px !important;
        }
        .sousNav3 {
            width: 30%;
            display: flex;
            justify-content: flex-end;
            margin-top: -1px;
        }
    }


</style>
<html>
    <head>
        <meta name="description" content="Fluidify">
        <meta name='keywords' content="fluidify">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/header.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/main.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/rating.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/swiper.css" />
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- get bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

        <!-- meta property 
        <meta property="og:title" content="Livelearn">
        <meta property="og:description" content="Ontdek, ontwikkel en maak carriere">
        <meta property="og:image" content="">
        <meta property="og:url" content="">
        -->

        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body class="body">
        <?php
        $sub_categories = array('Gezondheid','Leven');

        $args = array(
            'post_type' => 'course',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
        );

        $courses = get_posts($args);

        /*
        ** Categories - all  *
        */

        $categories = array();

        $cats = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'orderby'    => 'name',
            'exclude' => 'Uncategorized',
            'parent'     => 0,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));


        foreach($cats as $category){
            $cat_id = strval($category->cat_ID);
            $category = intval($cat_id);
            array_push($categories, $category);
        }

        //Categories
        $bangerichts = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categories[1],
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));

        $functies = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categories[0],
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));

        $skills = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categories[3],
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));

        $interesses = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categories[2],
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));

        $logo_livelearn = get_stylesheet_directory_uri() . '/img/logo_livelearn.png';

        ?>


        <div>

            <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
            <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                 style="position: absolute;height: auto !important; overflow-y:hidden !important;">
                <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
                                                                 box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

                    <div class="modal-content">

                        <div class="modal-header border-bottom-0">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body  px-md-4 px-0">
                            <div class="mb-4">
                                <div class="text-center">
                                    <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">
                                </div>
                                <h3 class="text-center my-2">Sign Up</h3>
                                <div class="text-center">
                                    <p>Already a member? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                            data-toggle="modal" data-target="#SignInWithEmail">&nbsp; Sign in</a></p>
                                </div>
                            </div>


                            <?php
                            echo (do_shortcode('[user_registration_form id="8477"]'));
                            ?>

                            <div class="text-center">
                                <p>Al een account? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                      data-toggle="modal" data-target="#SignInWithEmail">Log-in</a></p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

            <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->
            <div class="modal modalEcosyteme fade <?php if(isset($_GET['popup'])){echo 'show';}?>" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                 style="position: absolute;overflow-y:hidden !important;height: auto;<?php if(isset($_GET['popup'])){echo 'display:block;';}?>">
                <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
                                                                 box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

                    <div class="modal-content">
                        <div class="modal-header border-bottom-0">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body  px-md-5 px-4">
                            <div class="mb-4">
                                <div class="text-center">
                                    <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">
                                </div>
                                <h3 class="text-center my-2">Sign In</h3>
                                <div class="text-center">
                                    <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                          data-toggle="modal" data-target="#exampleModalCenter">&nbsp; Sign Up</a></p>
                                </div>
                            </div>
                            <?php if(isset($_GET['login']) && $_GET['login'] == 'failed'){?>
                            <div class="theme-error">
                                Incorrecte gebruikersnaam en/of wachtwoord
                            </div>
                            <?php }?>

                            <?php
                            wp_login_form([
                                'redirect' => $url,
                                'remember' => false,
                                'label_username' => 'Wat is je e-mailadres?',
                                'placeholder_email' => 'E-mailadress',
                                'label_password' => 'Wat is je wachtwoord?'
                            ]);
                            ?>
                            <div class="text-center">
                                <a href="/dashboard/user/overview/lost-password/" class="watchword-text">Wachtwoord vergeten </a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->

        </div>


        <div class="contentOne">
            <nav class="navbar navWeb navbar-expand-lg navbar-dark navModife">
                <div class="container-fluid">
                    <a class="navbar-brand navBrand" href="/">
                        <div class="logoModife">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_white.png" alt="">
                            <img class="imgLogoBleu" src="<?php echo get_stylesheet_directory_uri();?>/img/LiveLearn_logo.png" alt="">
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <a class="nav-link nav-linModife dropdown-toggle" type="button" data-toggle="dropdown" data-toggle="modal" data-target="#voorOrganisati"  role="button" id="voorOrganisati">Voor organisaties </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link nav-linModife dropdown-toggle" type="button" data-toggle="dropdown" data-toggle="modal" data-target="#voorOpleiders"  id="opleiders" href="/voor-teachers/">Voor opleiders </a>
                        </li>
                    </ul>


                    <div class="" aria-labelledby="dropdownMenuLink">
                    </div>

                    <!-- modal dropdown Voor organisaties -->
                    <div class="activeModalHeader">
                        <div class="modal  dropdown-menu-custom" id="voorOrganisatiModal" tabindex="-1" role="dialog" aria-labelledby="voorOrganisatiLabel" aria-hidden="true">
                            <div class="souselementHeader">
                                <div class="blockdropdownnHeader">
                                    <ul>
                                        <li>
                                            <a href="zzpers">
                                                <div class="blockImg" style="background: #033356;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/zzper-icone.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>ZZP'ers</b></p>
                                                    <p class="subtitleSousElementHeader">Zonder personeel</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="mkb">
                                                <div class="blockImg" style="background: #033356;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mkb-icon.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>MKB</b></p>
                                                    <p class="subtitleSousElementHeader">1-250 medewerkers</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/grootbedrijf">
                                                <div class="blockImg" style="background: #033356;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Grootbedrijf-icon.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>Grootbedrijf</b></p>
                                                    <p class="subtitleSousElementHeader">+250 medewerkers</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="pricing">
                                                <div class="blockImg" style="background: #033356;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/pricing-icon.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>Pricing</b></p>
                                                    <p class="subtitleSousElementHeader">Transparant en eenvoudig</p>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="secondUlModal ">
                                        <?php
                                        foreach($bangerichts as $bangericht){
                                            $image_category = get_field('image', 'category_'. $bangericht->cat_ID);
                                            $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/Image-79.png';
                                        ?>
                                        <li>
                                            <a href="sub-topic?subtopic=<?php echo $bangericht->cat_ID ?>">
                                                <div class="blockImg">
                                                    <img src="<?= $image_category; ?>" alt="">
                                                </div>
                                                <div>
                                                    <p class="subtitleSousElementHeader"><?php echo $bangericht->cat_name ?></p>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal dropdown Voor Voor opleiders  -->
                    <div class="modal  dropdown-menu-custom" id="voorOpleidersModal" tabindex="-1" role="dialog" aria-labelledby="voorOpleidersLabel" aria-hidden="true">
                        <div class="souselementHeader">
                            <div class="blockdropdownnHeader">
                                <ul>
                                    <li>
                                        <a href="/verkopen">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Verkopen.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Verkopen</b></p>
                                                <p class="subtitleSousElementHeader">je kennisproducten</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/creeren">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Creeër.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Creëer</b></p>
                                                <p class="subtitleSousElementHeader">nieuwe kennisproducten</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/uitleggen">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Uitleggen.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Uitleggen</b></p>
                                                <p class="subtitleSousElementHeader">Van producten of diensten</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/pricing">
                                            <div class="blockImg" style="background: #033356;  padding: 6px;">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-85.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Pricing</b></p>
                                                <p class="subtitleSousElementHeader">No cure no pay</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="secondUlModal ">
                                    <li>
                                        <a href="/opleiders">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Opleiders.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Opleiders</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Experts.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Experts</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Functionalities.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Functionaliteiten</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/contact">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Contact.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Contact</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <!-- modal dropdown Opleidingen -->
                    <div class="modal  dropdown-menu-custom" id="OpleidingenModal" tabindex="-1" role="dialog" aria-labelledby="OpleidingenLabel" aria-hidden="true">
                        <div class="souselementHeader">
                            <div class="blockdropdownnHeader">
                                <ul>
                                    <li>
                                        <a href="/community-overview">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-81.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Communities</b></p>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                                <ul class="secondUlModal ">
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Opleidingen">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Opleidingen-Header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Opleidingen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=E-learning">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/E-learning-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">E-Learnings</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Lezing">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Lezingen-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Lezingen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Trainingen.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Trainingen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Video">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Video's-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Video's</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Event">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Evens-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Events</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Workshop">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/workshop.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Workshops</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Artikel">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Artikelen-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Artikelen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Webinar">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/webinar-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Webinars</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Masterclass">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Masterclasses-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Masterclasses</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=Assessment">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Assessments-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Assessments</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=header&opleidin=">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Podcasts-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Podcasts</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>




                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- input search -->
                        <form action="/product-search" method="POST" class="form-inline ml-auto mb-0 ">
                            <input id="header-search" class="form-control InputDropdown1 mr-sm-2 inputSearch" name="search" type="search" placeholder="Zoek opleidingen, experts en onderwerpen" aria-label="Search">
                            <div class="dropdown-menuSearch headerDrop" id="header-list">
                                <div class="list-autocomplete" id="header">
                                    <center> <i class='hasNoResults'>No matching results</i> </center>
                                </div>
                            </div>
                        </form>

                        <ul class="navbar-nav nav-right">
                            <li class="nav-item active">
                                <a class="nav-link" id="Over" href="/static-education-individual/">Over ons</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-linModife dropdown-toggle" id="Opleidingen" type="button" data-toggle="dropdown" data-toggle="modal" data-target="#Opleidingen"  role="button"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upskilling</a>

                            </li>
                            <li class="nav-item" >
                                <a class="nav-link" href="/inloggen/"><b>Inloggen</b></a>
                            </li>
                            <li class="">
                                <a href="/registreren" class="nav-link worden">Altijd Gratis</a>
                            </li>
                        </ul>

                        <!-- search responsive -->
                        <div class="d-flex ml-3">
                            <div id="searchIconeTablet" class="">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/searchMobil.png"
                                     style="width: 24px" alt="">
                                <!-- <i class="fa fa-magnifying-glass"></i> -->
                            </div>
                            <div id="croieSearchTablet" class="btn" style="display: none;">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/XMobile.png" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </nav>


            <!-- <div class="d-flex justify-content-center" id="secondSearch"  style="background-color:#023356; display: none !important"> -->
            <form action="/product-search" method="POST" class="searchInputHedear px-5 tabletsearch mb-0" style="background-color:#023356; display: none !important">
                <input type="search"  placeholder="search" id="mobile-search" name="search">
                <div class="dropdown-menuSearch headerDrop" id="mobile-list">
                    <div class="list-autocomplete" id="mobileS">
                        <center> <i class='hasNoResults'>No matching results</i> </center>
                    </div>
                </div>
            </form>
            <!-- </div> -->

            <!-- ------------------------------------------- Mobile Responsive navbar ------------------------- -->
            <nav class="navMobile navMobile-custom">
                <div class="blockShowApp">
                    <div class="container-fluid">
                        <div class="elements-blockShowApp">
                            <div class="d-flex align-items-center frist-block">
                                <button type="button" class="btn close-block">
                                    x
                                </button>
                                <div class="logo-livelearn">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="search">
                                </div>
                            </div>
                            <div class="secondBlock">
                                <p class="text-Probeer"><b>Probeer onze gratis leer-app</b></p>
                                <p class="text-Probeer">En start meteen met jezelf te ontwikkelen</p>
                                <div class="d-flex">
                                    <img class="star-app-img" src="<?php echo get_stylesheet_directory_uri();?>/img/Group_301.png" alt="search">
                                </div>
                            </div>
                            <a href="" class="btn btn-Openen">Openen</a>
                        </div>
                    </div>
                </div>
                <div class="ProfilGraduatioBlock">
                    <div class="sousNav1">
                        <!-- <button id="croieProfil" class="btn">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/XMobile.png" alt="">
                            </button> -->

                        <div class="d-flex flex-row">
                            <div id="profil-element-first" class="first-element-mobile">
                                <div id="croieProfil" class="btn">
                                    <i class="bi bi-x-lg text-white" style="font-size: 25px"></i>
                                    <!-- <i class="bi bi-x-lg text-white" style="font-size: 25px"></i> -->
                                </div>
                                <div id="profilView" class="btn">
                                    <i class="bi bi-person-circle text-white" style="font-size: 25px"></i>
                                </div>
                            </div>
                            <div class="first-element-mobile">
                                <a href="/cart" class="boxImgNav2">
                                    <!-- <img src="<?php echo get_stylesheet_directory_uri();?>/img/graduationMobile.png" alt=""> -->
                                    <i class="bi bi-mortarboard-fill  text-white" style="font-size: 27px"></i>
                                    <div class="notification mb-4">
                                        <?php
                                        global $woocommerce;
                                        echo $woocommerce->cart->cart_contents_count;
                                        ?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="/" class="logoMobile">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn_white.png" alt="LogoMobile">
                    </a>
                    <div class="sousNav3">

                        <div class="d-flex align-items-center">
                            <div class="second-element-mobile">
                                <div id="searchIcone">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/search-white.png" alt="search">
                                </div>
                                <div id="croieSearch" class="btn">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/X-blanc.png" alt="close">
                                </div>
                            </div>
                            <div class="second-element-mobile">
                                <button id="burger" class=" btn burgerElement boxSousNav3-2">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/burger-2.png" alt="burger">
                                </button>
                                <button id="burgerCroie" class="btn croie">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/X-blanc.png" alt="close">
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
                <form action="/product-search" method="POST" class="searchInputHedear">
                    <input type="search"  placeholder="search" id="mobile-search" name="search">
                    <div class="dropdown-menuSearch headerDrop" id="mobile-list">
                        <div class="list-autocomplete" id="mobileS">
                            <center> <i class='hasNoResults'>No matching results</i> </center>
                        </div>
                    </div>
                </form>
            </nav>
            <div class="sousMenuNavMobil headSousMobilePrincipale" id="headOne">
               <!-- <div class="elementGroupGroeien">
                    <div class="firstContentHeadSousMobile">
                        <button id="richting-bineen" class="btn btnElementSousMenu">
                            Groeien richting een baan
                            <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG2.png" alt="">
                        </button>

                        <button id="Groeien-binnen" class="btn btnElementSousMenu">
                            Groeien binnen je functie
                            <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG2.png" alt="">
                        </button>

                        <button id="Ontwikkel-specifieke" class="btn btnElementSousMenu">
                            Ontwikkel specifieke skills
                            <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG2.png" alt="">
                        </button>

                        <button id="Ontwikkel-persoonlijke" class="btn btnElementSousMenu">
                            Ontwikkel persoonlijke interesses
                            <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG2.png" alt="">
                        </button>
                        <div class="block1">
                            <a href="/onderwer" class="elementsousMenuNav">Onderwerpen</a>
                            <a href="/opleiders" class="elementsousMenuNav">Opleiders</a>
                            <a href="/pricing" class="elementsousMenuNav">Pricing</a>
                        </div>
                        <div class="block1">
                            <a href="/static-education-individual" class="elementsousMenuNav">Voor individuen</a>
                            <a href="/voor-teachers/" class="elementsousMenuNav">Voor opleiders en experts</a>
                            <a href="/voor-organisaties" class="elementsousMenuNav">Voor organisaties</a>
                        </div>
                        <div class="block1">
                            <a href="#" data-toggle="modal" data-target="#exampleModalCenter"  aria-label="Close" data-dismiss="modal" class="btnRegistreren btnRegistrerenInloggen">Registreren</a>
                            <a href="#" data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal" class="btnInloggen btnRegistrerenInloggen">Inloggen</a>
                        </div>
                    </div>
                    <div class="secondContentHeadMobile">
                        <div class="block sousMenuBlock1">
                            <div class="sousElementGroeien-binnen-block">
                                <button id="upBlock1" class="btn imgBlockG1">
                                    <img class="fleG1" src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG1.png" alt="">
                                </button>
                                <?php
/*                                foreach($bangerichts as $bangericht){
                                */?>
                                <a href="sub-topic?subtopic=<?php /*echo $bangericht->cat_ID */?>" class="TextZorg"><?php /*echo $bangericht->cat_name */?></a>
                                <?php
/*                                }
                                */?>

                            </div>
                        </div>
                        <div class="block sousMenuBlock2">
                            <div class="sousElementGroeien-binnen-block">
                                <button id="upBlock2" class="btn btnUp imgBlockG1">
                                    <img  class="fleG1" src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG1.png" alt="">
                                </button>
                                <?php
/*                                foreach($functies as $functie){
                                */?>
                                <a href="sub-topic?subtopic=<?php /*echo $functie->cat_ID */?>" class="TextZorg"><?php /*echo $functie->cat_name */?></a>
                                <?php
/*                                }
                                */?>

                            </div>
                        </div>
                        <div class="block sousMenuBlock3">
                            <div class="binnen-block sousElementGroeien-binnen-block">
                                <button id="upBlock3" class="btn btnUp imgBlockG1">
                                    <img  class="fleG1" src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG1.png" alt="">
                                </button>
                                <?php
/*                                foreach($skills as $skill){
                                */?>
                                <a href="sub-topic?subtopic=<?php /*echo $skill->cat_ID */?>" class="TextZorg"><?php /*echo $skill->cat_name */?></a>
                                <?php
/*                                }
                                */?>
                            </div>
                        </div>
                        <div class="block sousMenuBlock4">
                            <div class="sousElementGroeien-binnen-block">
                                <button id="upBlock4" class="btn btnUp imgBlockG1">
                                    <img class="fleG1 " src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/fleG1.png" alt="">
                                </button>
                                <?php
/*                                foreach($interesses as $interesse){
                                */?>
                                <a href="sub-topic?subtopic=<?php /*echo $interesse->cat_ID */?>" class="TextZorg"><?php /*echo $interesse->cat_name */?></a>
                                <?php
/*                                }
                                */?>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="block-sous-nav-mobile d-grid">
                    <a href="/inloggen/" class="element-navMobile">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/lock-open.png" alt="search">
                        Inloggen
                    </a>
                    <a href="registreren/" class="element-navMobile mb-0">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-signature.png" alt="search">
                        Registreren
                    </a>
                </div>

                <div class="accordion" id="accordionExample2">
                    <div class="element-nav-accordion">
                        <div class="card-header" id="headingNavOne">
                            <h2 class="mb-0">
                                <button class="btn element-navMobile " type="button" data-toggle="collapse" data-target="#collapseNavOne" aria-expanded="true" aria-controls="collapseNavOne">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/rocket.png" alt="search">
                                    Mijzelf ontwikkelen
                                    <span>Gratis</span>
                                </button>
                            </h2>
                        </div>

                        <div id="collapseNavOne" class="collapse" aria-labelledby="headingNavOne" data-parent="#accordionExample2">
                            <ul>
                                <li><a class="linkElementNav" href="/inloggen-2/">Je eigen leeromgeving</a></li>
                                <li> <a class="linkElementNav" href="/onderwer/">Wat voor content / onderwerpen?</a></li>
                                <li> <a class="linkElementNav" href="/pricing/">Het is gratis</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="element-nav-accordion">
                        <div class="card-header" id="headingNavTwo">
                            <h2 class="mb-0">
                                <button class="btn element-navMobile  collapsed" type="button" data-toggle="collapse" data-target="#collapseNavTwo" aria-expanded="false" aria-controls="collapseNavTwo">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-building.png" alt="search">
                                    Ontwikkel team / organisatie
                                    <span>Va. €4,95</span>

                                </button>
                            </h2>
                        </div>
                        <div id="collapseNavTwo" class="collapse" aria-labelledby="headingNavTwo" data-parent="#accordionExample2">
                            <ul>
                                <li><a  class="linkElementNav" href="/voor-organisatie-2/">Onze leeromgeving</a></li>
                                <li> <a class="linkElementNav" href="">Functionaliteiten</a></li>
                                <li> <a class="linkElementNav" href="/pricing/">Pricing</a></li>
                                <li> <a class="linkElementNav" href="/zzpers/">Voor ZZPers</a></li>
                                <li> <a class="linkElementNav" href="/mkb/">Voor het MKB</a></li>
                                <li> <a class="linkElementNav" href="/grootbedrijf/">Voor Corporates</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="element-nav-accordion">
                        <div class="card-header" id="headingNavThree">
                            <h2 class="mb-0">
                                <button class="btn element-navMobile  collapsed" type="button" data-toggle="collapse" data-target="#collapseNavThree" aria-expanded="false" aria-controls="collapseNavThree">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/metro-fire.png" alt="search">
                                    Expert / opleider worden
                                    <span>No cure no pay</span>
                                </button>
                            </h2>
                        </div>
                        <div id="collapseNavThree" class="collapse" aria-labelledby="headingNavThree" data-parent="#accordionExample2">
                            <ul>
                                <li><a  class="linkElementNav" href="/voor-teacher-2-2/">De expert ranking per sector</a></li>
                                <li> <a class="linkElementNav" href="/verkopen/">Kennis verkopen</a></li>
                                <li> <a class="linkElementNav" href="/creeren/">Content creëren</a></li>
                                <li> <a class="linkElementNav" href="/uitleggen/">Uitleggen van producten / services</a></li>
                                <li> <a class="linkElementNav" href="/opleiders/">Alle opleiders</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="element-nav-accordion">
                        <div class="card-header" id="headingNavFour">
                            <h2 class="mb-0">
                                <button class="btn element-navMobile collapsed" type="button" data-toggle="collapse" data-target="#collapseNavFour" aria-expanded="false" aria-controls="collapseNavFour">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/information-circle.png" alt="search">
                                    Informatie
                                </button>
                            </h2>
                        </div>
                        <div id="collapseNavFour" class="collapse" aria-labelledby="headingNavFour" data-parent="#accordionExample2">
                            <ul>
                                <li> <a class="linkElementNav" href="/contact/">Contact</a></li>
                                <li> <a class="linkElementNav" href="/about">Wie zijn wij</a></li>

                            </ul>
                        </div>
                    </div>
                </div>


            </div>

            <div class="sousMenuNavMobil headSousMobileProfile" id="headTwo">
                <div class="elementGroupGroeien">
                    <div class="block1">
                        <p class="elementsousMenuNav profilText"><b>Jouw profiel</b></p>
                        <a href="/registreren/" class="elementsousMenuNav btnRegistrerenInloggen">Registreren</a>
                        <a href="/inloggen/" class="elementsousMenuNav btnRegistrerenInloggen">Inloggen</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="main">
            <script>
                jQuery(function($){
                    $("#searchIconeTablet").click(function() {
                        // alert('cooooooll!');
                        $("#searchIconeTablet").hide();
                        $("#burgerCroie").hide();
                        // $("#headOne").hide();
                        // $("#croieProfil").hide();
                        $("#headTwo").hide();
                        $(".searchInputHedear").show();
                        // $("#burger").show();
                        $("#croieSearchTablet").show();
                        $("#profilView").show();
                    });
                    $("#croieSearchTablet").click(function() {
                        $("#searchIconeTablet").show();
                        $(".searchInputHedear").hide();
                        $("#croieSearchTablet").hide();
                    });
                });

            </script>
