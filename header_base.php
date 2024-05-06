<!DOCTYPE html>

<?php
global $wp;
$url = home_url( $wp->request );
?>

<html>
    <head>
        <!-- Google Tag Manager
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id=%27+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-5NTJ5Z4');
        </script>
        End Google Tag Manager -->
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
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.theme.default.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.theme.green.css" />

        <!-- get bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-625166739%22%3E"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-625166739');
    </script>
    <script>
        $(function() {
            var header = $(".navbar");
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if (scroll >= 61) {
                    header.addClass("scrolled");
                } else {
                    header.removeClass("scrolled");
                }
            });

        });
    </script>
    <!-- End Google tag (gtag.js) -->
    <style>
        .language-selector-gtTranslate .gt_switcher_wrapper{
            display: block;
        }
    </style>

    <body class="body">
        <?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
        <!-- Google Tag Manager (noscript)
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5NTJ5Z4"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        End Google Tag Manager (noscript) -->
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
                            $base_url = get_site_url();
                            if($base_url == 'https://livelearn.nl')
                                echo (do_shortcode('[user_registration_form id="8477"]'));
                            else
                                echo (do_shortcode('[user_registration_form id="59"]'));
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

            <nav class="navbar navWeb navbar-expand-lg navbar-dark navModife" id="nav-with-top-bar">
                <div class="sub-navbar sub-nab-base w-100">
                    <div class="container-fluid">
                        <div class="content-sub-nabar w-100 d-flex justify-content-between align-items-center">
                            <div class="frist-block-subnav d-flex">
                                <img class="check-subnnav" src="<?php echo get_stylesheet_directory_uri();?>/img/check-subnnav.png" alt="">
                                <p class="mb-0">Wij zijn compleet onafhankelijk van alle opleiders, experts en aangesloten organisaties </p>
                            </div>
                            <div class="second-block-subnavbar d-flex align-items-center">
                                <a href="/contact/" class="btn-contact-sales">Contact Sales / demo?</a>
                                <div class="block-rating-subnav d-flex">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                </div>
                                <p class="mb-0 number-rating-header">9,3 / 2412</p>
                                <img class="iconSubnav" src="<?php echo get_stylesheet_directory_uri();?>/img/iconSubnav.png" alt="">

                                <div class="position-relative language-selector-gtTranslate">
                                    <div class="gtTranslateBlock">
                                        <?php echo do_shortcode('[gtranslate]'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <a href="/zzpers/">
                                                <div class="blockImg" style="background: #ffffff;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-zzpers.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>ZZP'ers</b></p>
                                                    <p class="subtitleSousElementHeader">Zonder personeel</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sme">
                                                <div class="blockImg" style="background: #ffffff;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-mkb.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>MKB</b></p>
                                                    <p class="subtitleSousElementHeader">1-250 medewerkers</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/corporate/">
                                                <div class="blockImg" style="background: #ffffff;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Grootbedrijf.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>Grootbedrijf</b></p>
                                                    <p class="subtitleSousElementHeader">+250 medewerkers</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/pricing/">
                                                <div class="blockImg" style="background: #ffffff;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-pricing.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>Pricing</b></p>
                                                    <p class="subtitleSousElementHeader">Transparant en eenvoudig</p>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/HR-dienstverlening/">
                                                <div class="blockImg" style="background: #ffffff;  padding: 6px;">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/vector-HR-dienstverlening.png" alt="">
                                                </div>
                                                <div>
                                                    <p class="titleSousElementHeader"><b>HR- dienstverlening</b></p>
                                                    <p class="subtitleSousElementHeader">Maatwerk oplossingen</p>
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
                                        <a href="/verkopen/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-verkopen.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Verkopen</b></p>
                                                <p class="subtitleSousElementHeader">Van kennis online</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/creeren/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-maken.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Maken</b></p>
                                                <p class="subtitleSousElementHeader">Van nieuwe kennisproducten</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/ontwikkelen/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Uitleggen.png" alt="">
                                            </div>
                                            <div>
                                                <p class="titleSousElementHeader"><b>Uitleggen</b></p>
                                                <p class="subtitleSousElementHeader">Van product of dienst</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/pricing/">
                                            <div class="blockImg" style="background: #FFFFFF;  padding: 6px;">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-pricing.png" alt="">
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
                                        <a href="/opleiders/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-oplieders.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Opleiders</p>
                                                <p class="subtitleSousElementHeader">Alle aangesloten bedrijven</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Top-Experts%20.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Experts</p>
                                                <p class="subtitleSousElementHeader">Een rating per topic</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/functionaliteiten/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Alle-functionaliteiten.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Alle functionaliteiten</p>
                                                <p class="subtitleSousElementHeader">Voor jou als experts</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/affiliate/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Affiliate.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Affiliate worden?</p>
                                                <p class="subtitleSousElementHeader">Creëer nieuwe inkomsten</p>
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
                                        <a href="/filosofie/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Onze-filosofie.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Onze filosofie</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Leervormen.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Leervormen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/community-overview/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Communities.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Communities</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/waarom-skills/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/head-Waarom.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Waarom skills?</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="secondUlModal ">
                                    <li>
                                        <a href="/product-search?filter=Opleidingen">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Opleidingen-Header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Opleidingen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=E-learning">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/E-learning-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">E-Learnings</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Lezing">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Lezingen-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Lezingen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Training">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Trainingen.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Trainingen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Video">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Video's-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Video's</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Event">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Evens-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Events</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Workshop">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/workshop.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Workshops</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Artikel">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Artikelen-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Artikelen</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Webinar">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/webinar-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Webinars</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Masterclass">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Masterclasses-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Masterclasses</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Assessment">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Assessments-header.jpg" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Assessments</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/product-search?filter=Podcast">
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


                    <!-- modal dropdown Opleidingen -->
                    <div class="modal  dropdown-menu-custom" id="OverOnsModal" tabindex="-1" role="dialog" aria-labelledby="OpleidingenLabel" aria-hidden="true">
                        <div class="souselementHeader upskilling-block">
                            <div class="blockdropdownnHeader">
                                <ul>
                                    <li>
                                        <a href="/filosofie/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/vector-what-is-livelearn.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Wat is LiveLearn?</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/about/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/vector-over-ons.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Over ons</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/our-users/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/vector-onze.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Onze gebruikers</p>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/contact/">
                                            <div class="blockImg">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/vector-contact.png" alt="">
                                            </div>
                                            <div>
                                                <p class="subtitleSousElementHeader">Contact</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="secondUlModal ">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/bg-UPSKILIING.png" alt="">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- input search on top on top -->
                        <form action="/product-search" method="GET" class="form-inline ml-auto mb-0 ">
                            <input value="<?=isset($_GET['search']) ? $_GET['search'] : '' ?>" id="header-search" class="form-control InputDropdown1 mr-sm-2 inputSearch" name="search" type="search" placeholder="Zoek opleidingen, experts en onderwerpen" aria-label="Search">
                            <div class="dropdown-menuSearch headerDrop" id="header-list">
                                <div class="list-autocomplete" id="header">
                                    <center> <i class='hasNoResults'>No matching results</i> </center>
                                </div>
                            </div>
                        </form>

                        <ul class="navbar-nav nav-right">
                            <li class="nav-item">
                                <a class="nav-link nav-linModife dropdown-toggle" id="OverOns" type="button" data-toggle="dropdown" data-toggle="modal" data-target="#OverOns"  role="button"  href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Over ons</a>
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
            <form action="/product-search" method="GET" class="searchInputHedear px-5 tabletsearch mb-0" style="background-color:#023356; display: none !important">
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
                            <button onclick="redirect()" class="btn btn-Openen">Openen</button>
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
                                <div id="searchIcone" class="showblock-mobil-search">
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
                <form action="/product-search" method="GET" class="searchInputHedear">
                    <input type="search"  placeholder="search" id="mobile-search" name="search">
                    <div class="dropdown-menuSearch headerDrop" id="mobile-list">
                        <div class="list-autocomplete" id="mobileS">
                            <center> <i class='hasNoResults'>No matching results</i> </center>
                        </div>
                    </div>
                </form>
            </nav>
            <div class="sousMenuNavMobil headSousMobilePrincipale" id="headOne">
                <div class="block-sous-nav-mobile">
                    <a href="/inloggen-2/" class="element-navMobile">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/lock-open.png" alt="search">
                        Inloggen
                    </a>
                    <a href="/registreren/" class="element-navMobile mb-0">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-signature.png" alt="search">
                        Registreren
                    </a>
                    <button class="btn element-navMobile" id="MijzelfBtn" type="button" data-toggle="collapse" data-target="#collapseNavOne" aria-expanded="true" aria-controls="collapseNavOne">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/rocket.png" alt="search">
                        Mijzelf ontwikkelen
                    </button>
                    <button class="btn element-navMobile" id="teambtn" type="button" data-toggle="collapse" data-target="#collapseNavTwo" aria-expanded="false" aria-controls="collapseNavTwo">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-building.png" alt="search">
                        Mijn team / organisatie managen
                    </button>
                    <button class="btn element-navMobile" id="expertBtn" type="button" data-toggle="collapse" data-target="#collapseNavThree" aria-expanded="false" aria-controls="collapseNavThree">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/metro-fire.png" alt="search">
                        Expert / opleider worden
                    </button>
                    <button class="btn element-navMobile" id="contactBtn" type="button" data-toggle="collapse" data-target="#collapseNavFour" aria-expanded="false" aria-controls="collapseNavFour">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/information-circle.png" alt="search">
                        Informatie
                    </button>
                    <button onclick="redirect()"  class="element-navMobile new-element-mobile mb-0">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/app-store-ios.png" alt="search">
                        Download onze gratis app
                    </button>
                </div>
                <div class="sub-block-2" id="1sub-block">
                    <button class="btn btn-back go-back"><i class="fa fa-angle-left mr-2"></i>Back</button>
                    <ul>
                        <button id="Groeien" class="btn element-navMobile">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/material-work.png" alt="search">
                                Groeien richting een baan
                        </button>
                        <button id="Groeien-binnen" class="btn element-navMobile">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-building.png" alt="search">
                                Groeien binnen je functie

                        </button>
                        
                        <button id="relevante-btn" class="btn element-navMobile">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-lightbulb.png" alt="search">
                                Relevante skills ontwikkelen
                        </button>
                        <button id="Persoonlijke-btn" class="btn element-navMobile">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-thumbs-up.png" alt="search">
                                Persoonlijke interesses en vrije tijd
                        </button>
                    </ul>
                </div>
                <div class="sub-block-2" id="2sub-block">
                    <button class="btn btn-back go-back-2"><i class="fa fa-angle-left mr-2"></i>Back</button>
                    <ul>
                      <?php
                    foreach($bangerichts as $bangericht){
                        ?>
                        <li class="btn element-navMobile">
                        <a href="sub-topic?subtopic=<?php echo $bangericht->cat_ID ?>" class="TextZorg"><?php echo $bangericht->cat_name ?></a>
                        </li>
                        <?php
                    }
                    ?>
                        
                        
                        
                    </ul>
                </div>
                <div class="sub-block-2" id="3sub-block">
                    <button class="btn btn-back go-back-2"><i class="fa fa-angle-left mr-2"></i>Back</button>
                     <ul>
                         <?php
                    foreach($functies as $functie){
                        ?>
                        <li class="btn element-navMobile">
                        <a href="sub-topic?subtopic=<?php echo $functie->cat_ID ?>" class="TextZorg"><?php echo $functie->cat_name ?></a>
                         </li>
                        <?php
                       
                    }
                    ?>
                    </ul>
                  
                </div>
                <div class="sub-block-2" id="4sub-block">
                    <button class="btn btn-back go-back-2"><i class="fa fa-angle-left mr-2"></i>Back</button>
                    <ul>
                      <?php
                    foreach($skills as $skill){
                        ?>
                        <li class="btn element-navMobile">
                        <a href="sub-topic?subtopic=<?php echo $skill->cat_ID ?>" class="TextZorg"><?php echo $skill->cat_name ?></a>
                        </li>
                        <?php
                    }
                    ?>
                        
                    </ul>
                </div>
                <div class="sub-block-2" id="5sub-block">
                    <button class="btn btn-back go-back-2"><i class="fa fa-angle-left mr-2"></i>Back</button>
                    <ul>
                       <?php
                    foreach($interesses as $interesse){
                        ?>
                         <li class="btn element-navMobile">
                        <a href="sub-topic?subtopic=<?php echo $interesse->cat_ID ?>" class="TextZorg"><?php echo $interesse->cat_name ?></a>
                         </li>
                        <?php
                    }
                    ?>
                        
                    </ul>
                </div>
                <div class="sub-block-2" id="team-organisati-block">
                    <button class="btn btn-back go-back"><i class="fa fa-angle-left mr-2"></i>Back</button>
                    <ul>
                        <li class="btn element-navMobile"><a  class="linkElementNav" href="/voor-organisaties/">Aanmelden</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/functionaliteiten/">Functionaliteiten</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/pricing/">Pricing</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/zzpers/">Voor ZZPers</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/sme/">Voor het MKB</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/corporate/">Voor Corporates</a></li>
                        <button onclick="redirect()" class="btn element-navMobile"> Zelf eerst een kijkje nemen</button>
                    </ul>
                </div>
                <div class="sub-block-2" id="expert-sub-block">
                    <button class="btn btn-back go-back"><i class="fa fa-angle-left mr-2"></i>Back</button>
                    <ul>
                        <li class="btn element-navMobile"><a  class="linkElementNav" href="/voor-opleiders/">Aanmelden</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/creeren/">Content creëren</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/ontwikkelen/">Uitleggen product / service</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/verkopen/">Kennis verkopen</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/opleiders/">Alle opleiders</a></li>
                        <button onclick="redirect()" class="btn element-navMobile">Zelf eerst een kijkje nemen</button>
                    </ul>
                </div>
                <div class="sub-block-2" id="contact-sub-block">
                    <button class="btn btn-back go-back"><i class="fa fa-angle-left mr-2"></i>Back</button>
                    <ul>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/contact/">Contact</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/about">Wie zijn wij</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/filosofie/">Onze filosofie</a></li>
                        <li class="btn element-navMobile"> <a class="linkElementNav" href="/our-users/">Onze gebruikers</a></li>
                        <button onclick="redirect()" class="btn element-navMobile">Zelf eerst een kijkje nemen</button>

                    </ul>
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
            <script>
                function redirect() {
                    var userAgent = navigator.userAgent;
                    if (userAgent.indexOf("iPhone") > -1) {
                        window.location.href = "https://apps.apple.com/nl/app/livelearn/id1666976386/";
                    } else {
                        window.location.href = "https://play.google.com/store/apps/details?id=com.livelearn.livelearn_mobile_app&hl=fr";
                    }
                }
            </script>
