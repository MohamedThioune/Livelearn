<?php /** Template Name: Home persoonlijke */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>

<div class="contentOne">
</div>

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
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );
        
?>
<div class="boxOne3-1">
    <div class="container">
        <div class="BaangerichteBlock">
            <p class="wordDeBestText2">Persoonlijke interesses</p>
            <p class="altijdText2 paddingElement">Ook buiten je werk kan je heel veel leren. Ontwikkel persoonlijke interesses en wellicht kan
                je hier binnenkort je werk van maken.</p>
        </div>
    </div>
</div>
<div class="groupBtn">
    <div class="swiper-container swipeContaine2">
        <div class="swiper-wrapper">
        <?php foreach($values as $value){ ?>
            <a href="../sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="swiper-slide swiper-slideM1">
               <button class="btn btnZorg"><?php echo $value->cat_name ?></button>
            </a>
        <?php } ?>
           
        </div>
    </div>
</div>
<?php
    $i = 0 ;
    foreach($values as $value) { ?> 
    <div class="blockTopBanen">
        <div class="container-fluid">
            <div class="d-flex align-center align-item-center">
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
            <div class="swiper-container swipeContaine2">
                <div class="swiper-wrapper">
                    <?php
                        $image_principal = get_field('image', 'category_'. $value->cat_ID);
                        $image_principal = $image_principal ? $image_principal : get_stylesheet_directory_uri() . '/img/finance.jpg';
                    ?>
                    <a href="../sub-topic?subtopic=<?php echo $value->cat_ID ?>" class="swiper-slide swiper-slide2">
                        <div class="cardTop bleu">
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
                            <div class="cardTop ">
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
           
        </div>
    </div>
<?php
  
    } 
?>

<div class="blockBlij">
    <p class="blijfOpText">Blijf op de <b>hoogte</b></p>
    <div class="search7">
        <input type="search" class="inputModifSearch">
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
</html>