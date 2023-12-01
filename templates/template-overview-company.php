<?php /** Template Name: overview company */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<?php
$page = 'check_visibility.php';
require($page);
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/company-logo.png" class="img-head-about" alt="">
                <h1 class="wordDeBestText2">The Walt Disney Company</h1>
                <button class="btn btn-follown" type="button">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/follow-icon.svg" class="img-follown" alt="">
                    Follow
                </button>
             </div>
    </section>
    <section class="content-product-search content-company-overview">
        <div class="theme-content">
            <div class="theme-learning">
                <div class="">
                    <div class="btn-group-layouts">
                        <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
                        <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
                    </div>
                    <form action="" class="d-flex align-items-center justify-content-between form-search-course-filter mb-0">
                        <div class="form-group position-relative mb-0">
                            <i class="fa fa-search"></i>
                            <input type="search" placeholder="Search" class="search-course">
                        </div>
                        <div class="custom-select-course position-relative">
                            <select class="form-select">
                                <option selected>Filter</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                            </select>
                            <span class="filter-icon">
                                <i class="fa fa-filter"></i>
                            </span>
                        </div>
                    </form>
                    <div class="block-filter-mobile">
                        <button class="content-filter d-flex ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/filter.png" alt="">
                            <span>show left bar</span>
                        </button>
                    </div>
                    <div class="block-new-card-course grid" id="autocomplete_recommendation">
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="pagination-container">
                        <!-- Les boutons de pagination seront ajoutés ici -->
                    </div>
                </div>
            </div>
            <div class="theme-side-menu">
                <div class="block-filter">
                    <button class="btn btn-close-filter">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Close.png" class="img-head-about" alt="">
                    </button>
                    <p class="text-filter-course">Infos</p>
                    <div class="sub-section">
                        <p class="description-sub-section">Topics</p>
                        <div class="d-flex flex-wrap">
                            <p class="topic-element">Audicien</p>
                            <p class="topic-element">Bakker</p>
                            <p class="topic-element">Bloemist</p>
                            <p class="topic-element">Audicien</p>
                            <p class="topic-element">Bakker</p>
                            <p class="topic-element">Bloemist</p>
                        </div>
                    </div>
                    <div class="sub-section">
                        <p class="description-sub-section">Profile Overview</p>
                        <div class="rating-element">
                            <div class="rating">
                                <input type="radio" id="star5-Geef" class="stars" name="rating_feedback" value="5" />
                                <label class="star" for="star5-Geef" title="Awesome" aria-hidden="true"></label>
                                <input type="radio" id="star4-Geef" class="stars" name="rating_feedback" value="4" />
                                <label class="star" for="star4-Geef" title="Great" aria-hidden="true"></label>
                                <input type="radio" id="star3-Geef" class="stars  " name="rating_feedback" value="3" />
                                <label class="star " for="star3-Geef" title="Very good" aria-hidden="true"></label>
                                <input type="radio" id="star2-Geef" class="stars" name="rating_feedback" value="2" />
                                <label class="star" for="star2-Geef" title="Good" aria-hidden="true"></label>
                                <input type="radio" id="star1-Geef" name="rating_feedback" value="1" />
                                <label class="star" for="star1-Geef" class="stars" title="Bad" aria-hidden="true"></label>
                            </div>

                        </div>
                        <p class="text-number-rating">3,4</p>
                        <div class="element-sub-section d-flex">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/courses-icon.svg" alt="">
                            <div class="detail">
                                <p class="number">45</p>
                                <p class="description">Course</p>
                            </div>
                        </div>
                        <div class="element-sub-section d-flex">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/members-icon.svg" alt="">
                            <div class="detail">
                                <p class="number">11,604</p>
                                <p class="description">Members</p>
                            </div>
                        </div>
                    </div>
                    <div class="sub-section">
                        <p class="description-sub-section">Expert</p>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="group-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/userExample.jpg" alt="">
                            </div>
                            <p>Cameron Williamson</p>
                        </div>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="group-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" alt="">
                            </div>
                            <p>Brooklyn Simmons</p>
                        </div>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="group-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert2.png" alt="">
                            </div>
                            <p>Savannah Nguyen</p>
                        </div>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="group-img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert3.png" alt="">
                            </div>
                            <p>Darlene Robertson</p>
                        </div>
                    </div>
                    <div class="sub-section">
                        <p class="description-sub-section">Expert</p>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="block-icon-contact">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/email-icon-white.svg" alt="">
                            </div>
                            <div>
                                <p class="sub-title-contact">Email</p>
                                <p class="element-sub-title">jennywilson@example.com</p>
                            </div>
                        </div>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="block-icon-contact">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/email-icon-white.svg" alt="">
                            </div>
                            <div>
                                <p class="sub-title-contact">Address</p>
                                <p class="element-sub-title">877 Ferry Street, Huntsville,</p>
                            </div>
                        </div>
                        <div class="profil-expert d-flex align-items-center">
                            <div class="block-icon-contact">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/email-icon-white.svg" alt="">
                            </div>
                            <div>
                                <p class="sub-title-contact">Phone</p>
                                <p class="element-sub-title">+1(452) 125-6789</p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!--script pagination-->

<script>
    const itemsPerPage = 9;
    const blockList = document.querySelector('.block-new-card-course');
    const blocks = blockList.querySelectorAll('.new-card-course');
    const paginationContainer = document.querySelector('.pagination-container');

    function displayPage(pageNumber) {
        const start = (pageNumber - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        blocks.forEach((block, index) => {
            if (index >= start && index < end) {
                block.style.display = 'block';
                block.classList.add('visible');
            } else {
                block.style.display = 'none';
                block.classList.remove('visible');
            }
        });

        const containerHeight = blockList.offsetHeight;

        setTimeout(() => {
            blockList.style.height = containerHeight + 'px';
        }, 10);
        setTimeout(() => {
            blockList.style.height = '';
        }, 300);
    }

    function createPaginationButtons() {
        const pageCount = Math.ceil(blocks.length / itemsPerPage);

        if (pageCount <= 1) {
            return;
        }

        let firstButtonAdded = false; // Keep track of whether the first button is added

        for (let i = 1; i <= pageCount; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.classList.add('pagination-button');
            button.addEventListener('click', () => {
                scrollToTop(); // Scroll to the top when a button is clicked
                displayPage(i);

                // Remove the .active class from all buttons
                const buttons = document.querySelectorAll('.pagination-button');
                buttons.forEach((btn) => {
                    btn.classList.remove('active');
                });

                // Add the .active class to the clicked button
                button.classList.add('active');
            });
            paginationContainer.appendChild(button);

            // Add the .active class to the first button
            if (!firstButtonAdded) {
                button.classList.add('active');
                firstButtonAdded = true;
            }
        }
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    displayPage(1);
    createPaginationButtons();


</script>

<script>
    $(".content-filter").click(function() {
        $(".theme-side-menu").show();
    });
    $(".btn-close-filter").click(function() {
        $(".theme-side-menu").hide();
    });
</script>


</body>
