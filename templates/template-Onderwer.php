<?php /** Template Name: Onderwer */ ?>

    <body>
    <?php wp_head(); ?>
    <?php get_header(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

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

    //Categories
    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    ?>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>

    
    <div class="contentBaan">

        <!-- slider -->
        <div class="my-5" style="height: 60px !important;">
            <div class="row logo_slide">       
                <?php 
                    foreach($cats as $cat) { 
                        if($cat->name == "Uncategorized")
                            continue;
                ?>
                    <div class="text-center ">
                        <span>
                            <button class="btn rounded rounded-pill text-secondary h6 mx-4" 
                            style="background: #E0EFF4 !important; min-width: 250px;">
                                <strong><?php echo $cat->name; ?></strong> 
                            </button>
                        </span>
                    </div>
                <?php } ?>       
            </div>
        </div>  


        <div class="blockTopBanen">
            <div class="container-fluid">

                <div class="box1Ban mt-3">
                    <p class="titleTopBanen2">Baangerichte onderwerpen</p>
                    <div class="contentCardTop2">
                        <?php
                            foreach($bangerichts as $value){
                                $image_category = get_field('image', 'category_'. $value->cat_ID);
                                $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                                ?>
                            <a href="sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="cardTopBaan" >
                                <img src="<?php echo $image_category; ?>" class="imgZorgCard" alt="">
                                <p class="zorgTextCard"><?php echo $value->cat_name ?></p>
                            </a>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="box1Ban mt-3">
                    <p class="titleTopBanen2">Functiegerichte onderpen</p>
                    <div class="contentCardTop2">
                        <?php
                            foreach($functies as $value){
                                $image_category = get_field('image', 'category_'. $value->cat_ID);
                                $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                                ?>
                            <a href="sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="cardTopBaan">
                                <img src="<?php echo $image_category; ?>" class="imgZorgCard" alt="">
                                <p class="zorgTextCard"><?php echo $value->cat_name ?></p>
                            </a>
                        <?php
                            }
                        ?>
                        
                    </div>
                </div>
                <div class="box1Ban mt-3">
                    <p class="titleTopBanen2">Skillgerichte onderwerpen</p>
                    <div class="contentCardTop2">
                        <?php
                            foreach($skills as $value){
                                $image_category = get_field('image', 'category_'. $value->cat_ID);
                                $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                                ?>
                            <a href="sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="cardTopBaan" >
                                <img src="<?php echo $image_category; ?>" class="imgZorgCard" alt="">
                                <p class="zorgTextCard"><?php echo $value->cat_name ?></p>
                            </a>
                        <?php
                            }
                        ?>
                       
                    </div>
                </div>

                <div class="box1Ban mt-3">
                    <p class="titleTopBanen2">Interesse onderwerpen</p>
                    <div class="contentCardTop2">
                        <?php
                            foreach($interesses as $value){
                                $image_category = get_field('image', 'category_'. $value->cat_ID);
                                $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/maternite.jpg';
                                ?>
                            <a href="sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="cardTopBaan">
                                <img src="<?php echo $image_category; ?>" class="imgZorgCard" alt="">
                                <p class="zorgTextCard"><?php echo $value->cat_name ?></p>
                            </a>
                        <?php
                            }
                        ?>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_footer(); ?>
    <?php wp_footer(); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- slick Carousel CDN -->
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
    

        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 'auto',
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
    <script>
        var swiper = new Swiper('.swipeContaine2', {
            slidesPerView: 7,
            spaceBetween: 20,
            observer: true,
            observeParents: true,
            allowSlideNext: false,
            freeMode: true,
            resistanceRatio: 0,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            breakpoints: {
                780: {
                    slidesPerView: 1,
                    spaceBetween: 40,
                },
                1230: {
                    slidesPerView: 7,
                    spaceBetween: 20,
                }
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
    </body>
