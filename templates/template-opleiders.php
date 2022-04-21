<?php /** Template Name: opleiders */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php 

extract($_POST);

$args = array(
    'post_type' => 'company', 
    'posts_per_page' => -1,
);

$companies = get_posts($args);

?>

<div class="contentOne">
</div>
<br><br>
    <div class="contentBaan">
        <div class="blockTopBanen">
            <div class="container">
                <div class="box1Ban">
                    <p class="titleTopBanen2"> <b>Opleiders</b> </p>
                    <?php if(!empty($companies)) { ?>
                        <div class="contentCardTop2">
                            <?php foreach($companies as $company) { 

                                $name = $company->post_title;
                                $logo = get_field('company_logo', $company->ID);
                                if(!$logo){
                                    $logo = get_stylesheet_directory_uri(). '/img/company.png';
                                }
                            ?>
                                <input type="hidden" name="company" value='<?php echo $company->ID; ?>'>
                                <a href="/opleider-courses?companie=<?php echo $company->ID; ?>" class="cardTopBaan cardOpleiders">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo $logo; ?>" alt="">
                                    </div>
                                    <p class="verkop"><?php echo $name ?></p>
                                    <p class="descriptionBraanCard"></p>
                                </a>
                            <?php 
                            } 
                        ?>
                        </div>
                    <?php } ?>
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
