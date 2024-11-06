<?php /** Template Name: Zzpers template */ ?>
<?php 
//$page = 'check_visibility.php'; 
//require($page);
?>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />
<style>
    .headerdashboard,.navModife {
        background: #deeef3;
        color: #ffffff !important;
        border-bottom: 0px solid #000000;
        background: linear-gradient(165deg, hsla(195, 48%, 92%, 1) 49%, hsla(200, 18%, 97%, 1) 100%);
        box-shadow: none;
    }
    .nav-link {
        color: #043356 !important;
    }
    .nav-link .containerModife{
        border: none;
    }
    .worden {
        color: white !important;
    }
    .navbar-collapse .inputSearch{
        background: #C3DCE5;
    }
    .logoModife img:first-child {
        display: none;
    }
    .imgLogoBleu {
        display: block;
    }
    .imgArrowDropDown {
        width: 15px;
        display: none;
    }
    .fa-angle-down-bleu{
        font-size: 20px;
        position: relative;
        top: 3px;
        left: 2px;
    }
    .additionBlock{
        width: 40px;
        height: 38px;
        background: #043356;
        border-radius: 9px;
        color: white !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .navModife4 .additionImg{
        display: none;
    }
    .additionBlock i{
        display: block;
    }
    .bntNotification img{
        display: none;
    }
    .bntNotification i{
        display: block;
        font-size: 28px;
    }
    .scrolled{
        background: #023356 !important;
    }
    .scrolled .logoModife img:first-child {
        display: block;
    }
    .scrolled .imgLogoBleu{
        display: none;
    }
    .scrolled .nav-link {
        color: #ffffff !important;
        display: flex;
    }
    .scrolled .imgArrowDropDown {
        display: block;
    }
    .scrolled .fa-angle-down-bleu {
        display: none;
    }
    .scrolled .inputSearch {
        background: #FFFFFF !important;
    }
    .scrolled .navModife4 .additionImg {
        display: block;
    }
    .scrolled .additionBlock{
        display: none;
    }
    .scrolled .bntNotification img {
        display: block;
    }
    .scrolled .bntNotification i {
        display: none;
    }
    .nav-item .dropdown-toggle::after {
        margin-left: 8px;
        margin-top: 10px;
    }
</style>
<body>
    <script async
    src="https://js.stripe.com/v3/buy-button.js">
    </script>
    <div class="block-zzpers">

        <?php
            $users = get_users();
            $authors = array();

            foreach ($users as $key => $value) {
                $company_user = get_field('company',  'user_' . $value->ID );
                if($company_user[0]->post_title == 'DeZZP')
                array_push($authors, $value->ID);
            }
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'author__in' => $authors,
                'order' => 'DESC',
                );

            $blogs = get_posts($args);

            /*
            ** Leerpaden  owned *
            */

            $args = array(
                'post_type' => 'learnpath',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'author__in' => $authors
            );
            $leerpaden = get_posts($args);
        ?>
        <!-- old name => overview-organisations-1 -->
            <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
            <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                style="position: absolute;height: 150% !important; overflow-y:hidden !important;">
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
                                    data-toggle="modal" data-target="#exampleModalCenter">&nbsp; Sign in</a></p>
                                </div>
                            </div>


                            <?php
                                echo (do_shortcode('[user_registration_form id="8477"]'));
                            ?>

                            <div class="text-center">
                                <p>Al een account? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                        data-toggle="modal" data-target="#exampleModalCenter">Log-in</a></p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

            <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->
            <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                style="position: absolute;overflow-y:hidden !important;height: 110%; ">
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
                                    data-toggle="modal" data-target="#SignInWithEmail">&nbsp; Sign Up</a></p>
                                </div>
                            </div>

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
                                <p>Nog geen account?  <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                    data-toggle="modal" data-target="#SignInWithEmail">Meld je aan</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->

        <section class="zzpersSection">
            <div class="container-fluid">
                <div class="d-flex first-zzpers-block justify-content-between align-items-center">
                    <div class="element-first">
                        <h1 class="zzpersTitle">ZZP'ers en Startups</h1>
                        <p class="krijgText">
                            Waarschijnlijk ben jij al druk genoeg met het draaiend houden van je bedrijf. Daarom zorgen wij als LiveLearn dat jij alle trends en ontwikkelingen direct in je eigen ontwikkelomgeving ontvangt.
                        </p>
                        <p class="krijgText krijgText-">
                            Daarnaast hebben we een speciale zzp-startersgids ontwikkeld om zeker te zijn dat jij perfect van start kan of het optimale uit je bedrijf kan halen. En dat alles voor de prijs van slechts 6 koppen koffie.
                        </p>
                        <div class="d-flex flex-wrap">
                            <button onclick="redirect()" class="btn btn-al-vanaf">
                                Je gratis leeromgeving
                            </button>
                            <a href="https://buy.stripe.com/5kAaHb9V09ex5MYfYZ" target="_blank" class="btn btn-Functionaliteiten">ZZP startersgide 2024</a>
                        </div>
                    </div>
                    <div class="element-second d-flex justify-content-center">
                        <stripe-buy-button
                        buy-button-id="buy_btn_1PQD91He23toRzexhEhQtxBW"
                        publishable-key="pk_live_51MtSplHe23toRzexSa0W1OP004KXZzdCQSvkaqEatv90jpLWeQMGuRC70w5IE1NnoyOSoIhhBuOMWXj5X4EUBiZQ00odVqsFeY"
                        >
                        </stripe-buy-button>
                    </div>
                </div>
                <div class="d-flex icons-block-zzpers">
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Tarief-bepalen.png" class="" alt="">
                        <p class="">Tarief bepalen</p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Jezelf-presenteren.png" class="" alt="">
                        <p class="">Jezelf presenteren</p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Facturen.png" class="" alt="">
                        <p class="">Facturen</p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Belastingen.png" class="" alt="">
                        <p class="">Belastingen</p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Loon-bepalen.png" class="" alt="">
                        <p class="">Loon bepalen</p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Winstdeling.png" class="" alt="">
                        <p class="">Winstdeling</p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Reservepotjes.png" class="" alt="">
                        <p class="">Reservepotjes</p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Ondersnemersrisico.png" class="" alt="">
                        <p class="">Ondersnemersrisico </p>
                    </div>
                    <div class="one-element-icon-zzpers">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Slim-vermogen-opbouwen.png" class="" alt="">
                        <p class="">Slim vermogen opbouwen</p>
                    </div>
                </div>
                <div class="block-rating-logo">
                    <div class="d-flex align-items-center justify-content-center block-hr-strat">
                        <hr>
                        <div class="block-start d-flex align-items-center justify-content-center">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Group_301.png" class="" alt="">
                            <p class="mb-0">(8,1)</p>
                        </div>
                        <hr>
                    </div>
                    <h2 class="title-zij">Zij gebruiken al LiveLearn</h2>
                    <div class="block-logo-parteners2">
                        <div class="logo-element">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/vanSpaendockLogo.png" alt="">
                        </div>
                        <div class="logo-element">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/orangeLogo.png" alt="">
                        </div>
                        <div class="logo-element">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/manpowerLogo.png" alt="">
                        </div>
                        <div class="logo-element">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/openclassroomLogo.png" alt="">
                        </div>
                        <div class="logo-element">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/zelfstanLogo.png" alt="">
                        </div>
                        <div class="logo-element">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/uwvLogo.png" alt="">
                        </div>
                        <div class="logo-element">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/Deloitte.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="cardCoursZzpers sectionArtikelZZpers">
            <div class="container-fluid">
                <h3>Artikelen voor ZZP'ers</h3>

                <div class="blockCardOpleidingen  ">

                    <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                        <?php
                        foreach($blogs as $course) {
                            $bool = true;
                            $bool = visibility($post, $visibility_company);
                            if(!$bool)
                                continue;

                            // type course
                            $course_type = get_field('course_type', $course->ID);

                            // image legend
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                            }

                            //degree
                            $degree = get_field('degree', $course->ID);

                            // author user : name, image
                            $user = get_user_by('id',$course->post_author);
                            $name = ($user->first_name=='') ? $user->display_name : $user->first_name;
                            $image_author = get_field('profile_img',  'user_' . $course->post_author) ? : get_stylesheet_directory_uri() . '/img/placeholder_user.png';


                            //short description
                            $short_description = get_field('short_description' , $course->ID);

                            // price
                            $price = get_field('price' , $course->ID);
                            $price = ($price !="0" && $price !=0 ) ? number_format($price, 2, '.', ',') : "Gratis";

                            // company
                            $company = get_field('company',  'user_' . $course->post_author);
                            ?>
                                <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                    <div class="head">
                                        <img src="<?php echo $thumbnail ?>" alt="">
                                    </div>
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course"><?php echo $course->post_title ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo $image_author ?>" class="" alt="">
                                            </div>
                                            <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                        </div>
                                    </div>
                                    <div class="descriptionPlatform">
                                        <p> <?php echo get_field('short_description', $course->ID);?></p>
                                    </div>
                                </a>

                                <?php
                            }
                        ?>

                    </div>

                </div>

            </div>
            
        </section>
        <section class="">
            <div class="container-fluid">
                <div class="talent-binnen-block">
                    <div class="first-block-binnen">
                        <h3>Als bedrijf beheer je in <span>1 minuut</span> al je <span>talent</span> binnen de organisatie </h3>
                        <p class="description ">In ons speciaal ontwikkelde learning management systeem houd je als manager precies bij hoe jouw talent zich ontwikkelt. Daarnaast deel je eenvoudig content, trainingen en andere kennisproducten met hen. </p>
                        <div class="jij-element">
                            <div class="d-flex">
                                <p class="jij-text">JIJ</p>
                                <img class="imgArrowRight" src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-long-arrow-alt-right.png" alt="">
                            </div>
                            <p class="text-description-jij">Een manager dashboard</p>
                        </div>
                        <div class="jij-element">
                            <div class="d-flex">
                                <p class="jij-text">JE TEAM</p>
                                <img class="imgArrowRight" src="<?php echo get_stylesheet_directory_uri();?>/img/awesome-long-arrow-alt-right.png" alt="">
                            </div>
                            <p class="text-description-jij">Een mobiele app</p>
                        </div>
                        <div class="d-flex align-items-center mt-4">
                            <a href="/voor-organisaties/" class="btn btnStratAlVoor">Start al voor €4,95</a>
                        </div>
                    </div>
                    <div class="second-block-binnen">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/imgStartVoor.png" alt="">
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="block-contact-calendy bleu-block-contact-calendy text-center">
                <div class="container-fluid">
                    <div class="d-flex justify-content-center">
                        <div class="img-Direct-een">
                            <img id="firstImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Direct-een.png" alt="">
                        </div>
                        <div class="img-Direct-een">
                            <img id="secondImg-direct-contact" src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der-Kolk.png" alt="">
                        </div>
                    </div>
                    <h3 class="title-Direct-een"><strong>Direct een afspraak inplannen?</strong><br> <spann>Toch liever een afspraak inplannen met ons team? Kies een datum en tijd die jou het best uitkomt.</spann></h3>
                    <button class="btn btn-kies" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/livelearn/overleg-pilot'});return false;">Kies een datum</button>

                </div>
            </div>
        </section>
        <section class="functionaliteiten">
        <div class="container-fluid">
            <div class="text-center">
                <img class="img-functionaliteiten" src="<?php echo get_stylesheet_directory_uri();?>/img/function.png" alt="">
            </div>
            <h2>Onze functionaliteiten</h2>
            <p class="sub-title">Voor organisaties</p>
            <div class="block-functionaliteiten d-flex flex-wrap">
                <div class="card-functionaliteiten">
                    <div class="text-right">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/geperso.png" alt="">
                    </div>
                    <p class="title">Je gepersonaliseerde leeromgeving</p>
                    <p class="description">Jij bepaalt zelf wat je in je omgeving te zien krijgt. Kies je onderwerpen of experts en neem je omgeving ook gewoon mee naar nieuwe werkgevers.</p>
                </div>
                <div class="card-functionaliteiten">
                    <div class="text-right">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mobiele.png" alt="">
                    </div>
                    <p class="title">Een mobiele app voor je dagelijkse learnings</p>
                    <p class="description">Veel onderweg en toch op de hoogte blijven van de laatste ontwikkelingen of vaardigheden. Gebruik dan onze app voor Apple of Android. </p>
                </div>
                <div class="card-functionaliteiten">
                    <div class="text-right">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Leervormen.png" alt="">
                    </div>
                    <p class="title">Leervormen die bij iedereen passen.</p>
                    <p class="description">We hebben 10 verschillende leervormen in het LiveLearn platform. Van het lezen van artikelen tot het volgen van een opleiding.</p>
                </div>
            </div>
            <div class="btn-Bekijk-functionaliteiten text-center">
                <a href="/functionaliteiten/" class="btn ">Bekijk al onze functionaliteiten</a>
            </div>
        </div>

        </section>

    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.lazyload.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>
<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:13,
        items:3.4,
        lazyLoad:true,
        dots:false,
        responsiveClass:true,
        autoplayHoverPause:true,
        nav:false,
        merge:true,
        URLhashListener:true,
        responsive:{
            0:{
                items:1.1,
                nav:true
            },
            600:{
                items:2.2,
                nav:false
            },
            1000:{
                items:3.2,
                nav:true,
                loop:false
            }
        }
    })
</script>

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>

<script type="text/javascript">
    $('.logo_slider').slick({
        centerMode: true,
        centerPadding: '0px',
        autoplay: true,
        dots: false,
        slidesToShow: 6,
        speed: 400,
        autoplaySpeed: 1500,
        arrows: false,
        responsive: [
            {
                breakpoint: 1240,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    centerPadding: '20px',
                    arrows: false
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    slidesToShow: 3,
                    centerPadding: '10px',
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    slidesToShow: 2,
                    centerPadding: '15px',
                }
            }
        ]
    });

    // cards section
    $('.cards_slide').slick({
        centerMode: false,
        centerPadding: '15px',
        dots: false,
        slidesToShow: 3,
        arrows: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    centerMode: true,
                    centerPadding: '35px'
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '30px'
                }
            }
        ]
    });

</script>
<?php get_footer(); ?>
<?php wp_footer(); ?>


