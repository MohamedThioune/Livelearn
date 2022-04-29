<?php /** Template Name: template product road path */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="content-road-path">
    <div class="hulpBox">
        <div class="container-fluid">
           <div class="headHulpbox">
               <h1 class="mb-0">Product Road Cours Path</h1>
               <div class="searchElementPath">
                   <input id="inputSearchElementPath" type="search" placeholder="Search an author or teacher">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/searchM.png" class="" alt="">
               </div>
           </div>
            <div class="element-content-roadPath">
                <div class="content-road-path-card">
                    <div class="position-relative element-content-road-path-card">
                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/libay.png" alt="">
                        <div class="roadpathBlockNumber">
                            <p>7</p>
                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/folder.png" alt="">
                        </div>
                    </div>
                    <div class="description-content-roadPath">
                        <div class="imgTitleCours justify-content-between">
                           <div class="d-flex align-items-center">
                               <div class="imgCoursProd">
                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image54.png" alt="">
                               </div>
                               <p class="nameCoursProd">Daniel</p>
                           </div>
                            <a href="/detail-product-road" class="btn btnDiscover">Discover</a>
                        </div>
                        <p class="werkText">Doorbreek gedachtepatronen</p>
                    </div>
                </div>
                <div class="content-road-path-card">
                    <div class="position-relative element-content-road-path-card">
                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/sport.jpg" alt="">
                        <div class="roadpathBlockNumber">
                            <p>7</p>
                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/folder.png" alt="">
                        </div>
                    </div>
                    <div class="description-content-roadPath">
                        <div class="imgTitleCours justify-content-between">
                           <div class="d-flex align-items-center">
                               <div class="imgCoursProd">
                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/Ellipse17.png" alt="">
                               </div>
                               <p class="nameCoursProd">Mouhamed</p>
                           </div>
                            <a href="/detail-product-road" class="btn btnDiscover">Discover</a>
                        </div>
                        <p class="werkText">Doorbreek gedachtepatronen</p>
                    </div>
                </div>
                <div class="content-road-path-card">
                    <div class="position-relative element-content-road-path-card">
                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/card2.png" alt="">
                        <div class="roadpathBlockNumber">
                            <p>7</p>
                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/folder.png" alt="">
                        </div>
                    </div>
                    <div class="description-content-roadPath">
                        <div class="imgTitleCours justify-content-between">
                           <div class="d-flex align-items-center">
                               <div class="imgCoursProd">
                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                               </div>
                               <p class="nameCoursProd">Mamadou</p>
                           </div>
                            <a href="/detail-product-road" class="btn btnDiscover">Discover</a>
                        </div>
                        <p class="werkText">Doorbreek gedachtepatronen</p>

                    </div>
                </div>
                <div class="content-road-path-card">
                    <div class="position-relative element-content-road-path-card">
                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/Public-real-estate.jpeg" alt="">
                        <div class="roadpathBlockNumber">
                            <p>3</p>
                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/folder.png" alt="">
                        </div>
                    </div>
                    <div class="description-content-roadPath">
                        <div class="imgTitleCours justify-content-between">
                           <div class="d-flex align-items-center">
                               <div class="imgCoursProd">
                                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/addUser.jpeg" alt="">
                               </div>
                               <p class="nameCoursProd">Fadel</p>
                           </div>
                            <a href="/detail-product-road" class="btn btnDiscover">Discover</a>
                        </div>
                        <p class="werkText">Doorbreek gedachtepatronen</p>
                    </div>
                </div>
                <div class="content-road-path-card">
                    <div class="position-relative element-content-road-path-card">
                        <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/hr.jpg" alt="">
                        <div class="roadpathBlockNumber">
                            <p>7</p>
                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/folder.png" alt="">
                        </div>
                    </div>
                    <div class="description-content-roadPath">
                        <div class="imgTitleCours justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="imgCoursProd">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Maurice_Veraa_.jpeg" alt="">
                                </div>
                                <p class="nameCoursProd">Influid</p>
                            </div>
                            <a href="/detail-product-road" class="btn btnDiscover">Discover</a>
                        </div>
                        <p class="werkText">Doorbreek gedachtepatronen</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var swiper = new Swiper('.swipeContaineEvens', {
        slidesPerView: '5',
        spaceBetween: 20,
        breakpoints: {
            780: {
                slidesPerView: 1,
                spaceBetween: 40,
            },
            1230: {
                slidesPerView: 3.9,
                spaceBetween: 20,
            }
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });

</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>