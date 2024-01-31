<?php /** Template Name: sme template */ ?>
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

<div class="block-zzpers block-sme theme-new-element">
    <section class="zzpersSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="content-text-sme">
                        <h1 class="zzpersTitle">Midden en Kleinbedrijf</h1>
                        <p class="krijgText">
                            Personeel, het is altijd moeilijk om hier het beste uit te halen. Wat moet je aanbieden qua trainingen en hoe houd je alle ontwikkelingen bij? Als LiveLearn begrijpen we maar al te goed hoe je hier mee om moet gaan en daarom bieden wij een eenvoudig op te zetten ontwikkelomgeving voor MKB bedrijven.
                        </p>
                        <div class="d-flex flex-wrap">
                            <a href="/voor-organisaties/" class="btn btn-al-vanaf">
                                Al vanaf €4,95
                            </a>
                            <a href="/template-form/" class="btn btn-Functionaliteiten">Contact met onze adviseurs </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="content-img-sme">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/sme.png" alt="">
                    </div>
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
    <section class="cardCoursZzpers">
        <div class="container-fluid">
            <h3>Artikelen voor MKB</h3>

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

                        // author user : name
                        $user = get_user_by('id',$course->post_author);
                        $name = ($user->first_name=='') ? $user->display_name : $user->first_name;

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
    <section class="Ontdek-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <img class="img-for-individual" src="<?php echo get_stylesheet_directory_uri();?>/img/For-individuals-1.png" alt="">
                </div>
                <div class="col-lg-8">
                    <div class="content-Ontdek">
                        <h2 class="title-section">Ontdek onze geheime <span>formule</span> om inzichten over jezelf te krijgen om naar een nieuw niveau te groeien! </h2>
                        <p class="description-section">Geef je carrière een glansrijke boost met onze LiveLearn-app! Ontdek een wereld van voortdurende ontwikkeling en blijf groeien als professional.<br>
                            Met toegang tot een breed scala aan boeiende cursussen en leermiddelen kun je je kennis en vaardigheden naar nieuwe hoogten tillen. Leer in je eigen tempo, waar en wanneer het jou uitkomt. Versterk je expertise, ontdek nieuwe interesses en vergroot je waarde op de arbeidsmarkt. <br>
                            Blijf bij met de laatste trends en technologieën in jouw vakgebied en onderscheid jezelf van de rest. <br>
                            Met ons LXP-platform kun je jezelf blijven ontwikkelen en stappen zetten richting een glansrijke carrière. Krijg toegang tot exclusieve content, interactieve uitdagingen en certificeringen die je geloofwaardigheid en groeimogelijkheden vergroten. <br>
                            Verhoog je inzetbaarheid, verbeter je prestaties en grijp nieuwe kansen die voorbij komen. Bereid je voor op succes en word de professional waar anderen naar opkijken. Investeer in jezelf en laat ons je begeleiden op jouw weg naar een glansrijke carrière. Download onze LiveLearn-app vandaag nog en laat je ontwikkeling nooit stagneren!</p>

                        <button onclick="redirect()" class="btn btn-download-onze-app">Download onze app</button>
                    </div>
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
        items:2.8,
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
                items:2.8,
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

<?php get_footer(); ?>
<?php wp_footer(); ?>


