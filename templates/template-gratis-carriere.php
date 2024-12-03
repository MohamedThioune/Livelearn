<?php /** Template Name: template gratis carriere */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<style>
    html {
        scroll-behavior: smooth;
    }
</style>

<section class="contentgatisCarriere">
    <div class="container">
        <h1>Gratis carrière begeleiding</h1>
        <p class="description">
            Samen met Manpower en de overheid bieden we gratis carrière begeleiding aan mensen die <a href="">maximaal een MBO2</a> diploma hebben. Dit is jouw kans om je positie op de arbeidsmarkt te versterken en je te laten adviseren welke carrière stappen en opleiding het best bij jou passen;
        </p>
        <a href="#scrollElementGratis" class="btn btnMeldje">Meld je gratis aan</a>
        <div class="groupLogoImg">
            <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/LiveLearn_logo.png" alt="logo">
            <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/Manpower_logo.png" alt="logo">
        </div>
        <div class="ManpowerBlockImg">
            <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/Manpower_first.png" alt="logo">
        </div>
        <div class="row groupdetailCarriere">
            <div class="col-md-6">
                <h2 class="titlePersoonlij">1. Persoonlijkeid</h2>
                <p class="descriptionPersoonlij">Om gegrond advies te kunnen geven over jouw kansen op de arbeidsmarkt, moeten we je eerst leren kennen. De eerste sessie gaat dus over jouw ambities.</p>
            </div>
            <div class="col-md-6">
                <h2 class="titlePersoonlij">2. Professioneel</h2>
                <p class="descriptionPersoonlij">De tweede sessie gaat over jouw professionele carrière en de ervaring die je daar hebt opgedaan . Ook behandelen we waar je sterke en verbeterpunten liggen met betrekking tot werk.</p>
            </div>
            <div class="col-md-6">
                <h2 class="titlePersoonlij">3. Vaardigheden</h2>
                <p class="descriptionPersoonlij">Doormiddel van een vaardigheden-scan maken we inzichtelijk wat je beste hard- en soft skills zijn en waar deze skills in werk het best tot z'n recht komen.</p>
            </div>
            <div class="col-md-6">
                <h2 class="titlePersoonlij">4. Arbeidsmarkt</h2>
                <p class="descriptionPersoonlij">Tijdens de laatste sessie van dit traject brengen we alle eerdere sessies samen door de vertaling naar werk te maken. Zo weten we zeker dat jij zo snel mogelijk aan de slag kan of een nieuwe uitdaging vindt.</p>
            </div>
        </div>
    </div>
    <div class="blockWinDeWar">
        <div class="container-fluid">
            <div class="elementWinWar">
                <div class="imgWInWar">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/win-war.png"  alt="">
                </div>
                <div class="text-center">
                    <h2 class="titleWinWar">We hebben<b> 50 plaatsen</b></h2>
                    <p class="descriptionWinWar">Gratis ontwikkeltraject t.w.v €700 p.p.</p>
                </div>
                <img class="volImg" src="<?php echo get_stylesheet_directory_uri();?>/img/vol_is_vol.png"  alt="">
            </div>
        </div>
    </div>
    <div id="scrollElementGratis" class="blockMeld">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="blockImgSignUp">
                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/Sign-up.png" alt="team">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="blockForm" >
                        <p class="gratisText gratisText2">Gratis</p>
                        <p><b>Meld je direct vrijblijvend aan</b></p>
                        <p>Vul onderstaand formulier in en we plannen zo snel mogelijk en afspraak in</p>
                        <?php
                        echo do_shortcode("[gravityform id='16' title='false' description='false' ajax='false']");
                        ?>
                        <!-- <div class="d-flex">
                            <input type="checkbox" id="livelearn" name="livelearn" value="livelearn">
                            <label for="vehicle1">Ik ga akkoord met de algemene voorwaarden van <a href="/privacy">Livelearn B.V</a></label>
                        </div>
                        <div class="d-flex">
                            <input type="checkbox" id="manpower" name="manpower" value="manpower">
                            <label for="vehicle1">Ik ga akkoord met de algemene voorwaarden van <a href="https://www.manpower.nl/nl/privacy-statement">Manpower Group</a></label>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="testimonial">
    <div class="container-fluid">
        <h3>Wat anderen zeggen</h3>
        <div class="blockCardTestimonial">
            <div class="cardTestimonial">
                <p>Heel fijn om een plan te hebben, ik zat namelijk een beetje vast in mijn functie </p>
                <div class="rating-element2">
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                </div>
            </div>
            <div class="cardTestimonial">
                <p>Ik had geen idee wat een goede opleiding voor mij was. Na het programma wist ik wat het best bij mij als persoon past </p>
                <div class="rating-element2">
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                </div>
            </div>
            <div class="cardTestimonial">
                <p>Een duidelijk plan om een volgende stap in mijn carriére te maken.</p>
                <div class="rating-element2">
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star "></i>
                </div>
            </div>
            <div class="cardTestimonial">
                <p>Fijne sessies met een duidelijk resultaat. Jammer dat de sessies niet iets langer waren.</p>
                <div class="rating-element2">
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                </div>
            </div>
            <div class="cardTestimonial">
                <p>Super vriendelijk en genoeng tijd om persoonlijke vragen te stellen, aanrader!</p>
                <div class="rating-element2">
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                </div>
            </div>
            <div class="cardTestimonial">
                <p>Géén verborgen kosten en goed gestructureerde begeleiding. Na afloop meteen aan de slag gegaan met mijn persoonlijke ontwikkeling.</p>
                <div class="rating-element2">
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                    <i class="fa fa-star etoileC"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="SectionWinDeWar">
    <div class="blockWinDeWar">
        <div class="container-fluid">
            <div class="elementWinWar">
                <img class="volImg" src="<?php echo get_stylesheet_directory_uri();?>/img/vol_is_vol.png"  alt="">
                <div class="text-center">
                    <h2 class="titleWinWar"> Doe nu <b>gratis mee</b></h2>
                </div>
                <a href="#scrollElementGratis" class="btn btnLessHoe">Meld je aan</a>
            </div>
        </div>
    </div>
</section>
<section class="py-5" style="background: #043356" id="contact_section">
    <div class="container-fluid py-5">
        <div class="row d-flex justify-content-center align-items-center">

            <div class="col-md-6 col-9 mb-md-0 mb-5 px-md-0 text-md-left text-center">
                <img class="im-fluid w-75"  src="<?php echo get_stylesheet_directory_uri();?>/img/Contact_team2.png" alt="team">
            </div>

            <div class="col-md-6 col-11 px-md-0 text-md-left text-center">
                <h2 class="hero-title text-white">Direct contact met één van onze adviseurs? <br> </h2>
                <div class="my-3 text-white">
                    <p class="krijgText text-white">
                        We helpen je graag met jouw specifieke vragen omtrent talent
                        management en de toepasbaarheid hiervan binnen je organisatie.
                    </p>
                </div>
                <a href="mailto:contact@livelearn.nl" class="btn btn-default rounded-pill px-5 my-2 ml-md-0 ml-2" style="background: #E3EFF4">
                    <strong class="text-dark">Email </strong>
                </a>
                <a href="tel: +31627003962" class="btn btn-default text-white rounded-pill px-5 my-2 ml-md-3" style="background: #00A89D">
                    <strong >Bellen</strong>
                </a>
            </div>
        </div>
    </div>
</section>

</body>



<?php get_footer(); ?>
<?php wp_footer(); ?>

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    // scroll down on click button

</script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
<script>
    // scroll down on click button
    $( '.vraagButton' ).on( 'click', function(e){
        $( 'html, body' ).animate({
            scrollTop: $("#contact_section").offset().top
        }, '500' );
        e.preventDefault();

    });
</script>

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
        centerMode: true,
        centerPadding: '15px',
        dots: false,
        slidesToShow: 3,
        arrows: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

</script>

