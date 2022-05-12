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

    <div class="contentOne"> 
    </div>
    <div class="contentBaan">
        <div class="groupBtn groupBtn2">
            <div class="swiper-container swipeContaine2">
                <div class="swiper-wrapper">
                    <?php foreach($cats as $cat) { ?>
                    <div class="swiper-slide swiper-slideM1">
                        <button class="btn btnZorg"><?php echo $cat->name; ?></button>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="blockTopBanen">
            <div class="container-fluid">
                <div class="box1Ban">
                    <p class="titleTopBanen2">Baangerichte onderwerpen</p>
                    <div class="contentCardTop2">
                        <?php
                            foreach($bangerichts as $value){
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
                <div class="box1Ban">
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
                <div class="box1Ban">
                    <p class="titleTopBanen2">Skillgerichte onderwerpen</p>
                    <div class="contentCardTop2">
                        <?php
                            foreach($skills as $value){
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

                <div class="box1Ban">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script src="js/style.js"></script>
    <script>
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
