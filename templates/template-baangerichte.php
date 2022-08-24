<?php /** Template Name: Home baangerichte */ ?>
<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>


<?php   
    
    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    $values = get_categories( array(
        'taxonomy' => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );
        
?>
<div class="boxOne3-1">
    <div class="container">
        <div class="BaangerichteBlock">
            <p class="wordDeBestText2">Baangerichte groei</p>
            <p class="altijdText2 paddingElement">Op zoek naar een (nieuwe) baan? Hieronder vind je alle beroepen per sector. Start meteen
                vanuit het LiveLearn platform, zodat je zo snel mogelijk aan het werk kan.</p>
        </div>
    </div>
</div>

<div class="my-5" style="height: 38px !important;">
    <div class="row logo_slide">       
        <?php foreach($values as $value){ ?>
            <div class="text-center ">
                <a href="../sub-topic?subtopic=<?php echo $value->cat_ID ?>">
                    <button class="btn rounded rounded-pill text-secondary h6 mx-4" 
                    style="background: #E0EFF4 !important; min-width: 250px;">
                        <strong><?php echo $value->cat_name ?></strong> 
                    </button>
                </a>
            </div>
        <?php } ?>       
    </div>
</div>


<?php foreach($values as $value) { ?> 
    <div class="container-fluid mb-4">
        <div class="d-flex align-center align-item-center mx-3">
            <p class="titleTopBanen"><?php echo $value->cat_name ?></p>
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img//IconShowMore.png" class="IconShowMore" alt="">
            <a href="../sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="linkBlock">Bekijk alles</a>
        </div>
        <?php 
            $setups = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent'  => $value->cat_ID,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ) );
            
        ?>

        <div class="swiper-container swipeContaine2 mx-3">
            <div class="swiper-wrapper">
                <?php
                    $image_principal = get_field('image', 'category_'. $value->cat_ID);
                    $image_principal = $image_principal ? $image_principal : get_stylesheet_directory_uri() . '/img/finance.jpg';
                ?>
                <a href="../sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="swiper-slide swiper-slide2">
                    <div class="cardTop bleu" style="height: 200px;">
                        <div class="contentImg">
                            <img src="<?php echo $image_principal; ?>" alt="">
                        </div>
                        <p class="bekijText bleuT">Bekijk alles</p>
                    </div>
                </a>
                <?php
                    
                foreach($setups as $setup){ 

                    $image_category = get_field('image', 'category_'. $setup->cat_ID);
                    $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/innovation.jpg';                        
                    ?>
                    
                    <a href="../category-overview/?category=<?php echo $setup->cat_ID ?>" class="swiper-slide swiper-slide2">
                        <div class="cardTop " style="height: 200px;">
                            <div class="contentImg">
                                <img src="<?php echo $image_category; ?>" alt="">
                            </div>
                            <p class="bekijText"><?php echo $setup->cat_name ?></p>
                        </div>
                    </a>
                <?php
                    }
                ?>
            </div>                    
        </div>


        <!-- <div class="bg-warning d-flex justify-content-start">             -->
       
        <!-- </div> -->
        
    </div>
<?php } ?>
                    


<?php get_footer(); ?>
<?php wp_footer(); ?>

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!--<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
--><!-- slick Carousel CDN -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>

<script>
    
    // partners slides
    $('.logo_slide').slick({
        centerMode: false,
        centerPadding: '130px',
        dots: false,
        slidesToShow: 5,
        autoplay: true,
        speed: 400,
        autoplaySpeed: 1500,
        arrows: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3,
                    centerMode: true,
                    centerPadding: '100px'
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    centerMode: true,
                    centerPadding: '60px'
                }
            }
        ]
    });
    

    // cards swiper
    $('.small_cards').slick({
        dots: false,
        centerMode: false,
        infinite: false,
        speed: 300,
        slidesToShow: 7,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });


    // 



    // var swiper = new Swiper('.swiper-container', {
        // slidesPerView: 'auto',
    //     spaceBetween: 30,
    //     loopFillGroupWithBlank: false,
    //     pagination: {
    //         el: '.swiper-pagination',
    //         clickable: true,
    //     },
    // });
</script>
<script>
    // var swiper = new Swiper('.swipeContaine2', {
    //     slidesPerView: 7,
    //     spaceBetween: 20,
    //     observer: true,
    //     observeParents: true,
    //     allowSlideNext: false,
    //     freeMode: true,
    //     resistanceRatio: 0,
    //     watchSlidesVisibility: true,
    //     watchSlidesProgress: true,
    //     breakpoints: {
    //         780: {
    //             slidesPerView: 1,
    //             spaceBetween: 40,
    //         },
    //         1230: {
    //             slidesPerView: 7,
    //             spaceBetween: 20,
    //         }
    //     },
    //     pagination: {
    //         el: '.swiper-pagination',
    //         clickable: true,
    //     },
    // });
</script>
</body>
</html>