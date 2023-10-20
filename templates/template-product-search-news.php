<?php /** Template Name: Product Search */ ?>

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
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/product-search.png" class="img-head-about border-0" alt="">
                <h1 class="wordDeBestText2">Product Search</h1>
            </div>
        </div>
    </section>
    <section class="content-product-search">
        <div class="theme-content">
            <div class="theme-side-menu">
                <div class="block-filter">
                    <button class="btn btn-close-filter">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Close.png" class="img-head-about" alt="">
                    </button>
                    <p class="text-filter-course">Filter Courses</p>
                    <form action="">
                        <div class="sub-section">
                            <p class="description-sub-section">LEERVORM</p>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        Backend
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        Css
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        Frontend
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        General
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        IT & Software
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        Photography
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        Programming Language
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Backend">
                                    <label class="form-check-label" for="Backend">
                                        Technology
                                    </label>
                                </div>
                                <p class="number-course">10</p>
                            </div>
                        </div>
                        <div class="sub-section">
                            <p class="description-sub-section">LEERVORM</p>
                            <div class="form-group">
                                <label for="Vanaf" class="form-label">Vanaf</label>
                                <input type="text" class="form-control" id="Vanaf">
                            </div>
                            <div class="form-group">
                                <label for="Tot" class="form-label">Tot</label>
                                <input type="text" class="form-control" id="Tot">
                            </div>
                        </div>
                        <div class="sub-section">
                            <p class="description-sub-section">Locatie</p>
                            <div class="form-group">
                                <label for="PostCode" class="form-label">PostCode</label>
                                <input type="text" class="form-control" id="PostCode">
                            </div>
                            <div class="form-group">
                                <label for="Afstand" class="form-label">Afstand(m)</label>
                                <input type="text" class="form-control" id="Afstand">
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Alleen-online">
                                    <label class="form-check-label" for="Alleen-online">
                                        Alleen online
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="sub-section">
                            <p class="description-sub-section">EXPERT</p>
                            <div class="position-relative">
                                <i class="fa fa-search"></i>
                                <input type="search" placeholder="Search Expert">
                            </div>
                            <div class="form-check">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Jane-Cooper">
                                    <label class="form-check-label" for="Jane-Cooper">
                                        Jane Cooper
                                    </label>
                                </div>
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Wade Warren
                                    </label>
                                </div>
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Brooklyn Simmons
                                    </label>
                                </div>
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Cameron Williamson
                                    </label>
                                </div>
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Leslie Alexander
                                    </label>
                                </div>
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Guy Hawkins
                                    </label>
                                </div>
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" value="" id="">
                                    <label class="form-check-label" for="">
                                        Jacob Jones
                                    </label>
                                </div>
                                <button class="btn btn-more-expert">+ More expert</button>

                            </div>
                        </div>
                        <button class="btn btn-Apply">Apply</button>
                    </form>

                </div>
            </div>
            <div class="theme-learning">
                <div class="">
                    <div class="btn-group-layouts">
                        <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
                        <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
                    </div>
                    <div class="block-filter-mobile">
                        <button class="content-filter d-flex ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/filter.png" alt="">
                            <span>Filter</span>
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
