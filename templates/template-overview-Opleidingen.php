<?php /** Template Name: overview Opleidingen */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<?php
//$page = 'check_visibility.php';
//require($page);
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<div class="content-community-overview bg-gray template-overview">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icon-opleiding.png" class="img-head-about border-0" alt="">
                <h1 class="wordDeBestText2">Opleidingen All Course</h1>
                <form action="" class="d-flex formFilterTemplate">
                    <select class="form-select" aria-label="SubTopics">
                        <option selected>SubTopics</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <select class="form-select" aria-label="All Language">
                        <option selected>All Language</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <select class="form-select" aria-label="All Prices">
                        <option selected>All Prices</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <select class="form-select" aria-label="All Skills">
                        <option selected>All Skills</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                    <button class="btn btn-filter"><i class="fa fa-filter"></i><span>Filter</span></button>
                </form>
            </div>
        </div>
    </section>
    <section class="content-product-search">
        <div class="container-fluid">
            <form action="" class="d-flex align-items-center justify-content-between form-search-course-filter mt-3 mb-2">
                <div class="btn-group-layouts">
                    <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
                    <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
                </div>
                <div class="form-group position-relative mb-0">
                    <i class="fa fa-search"></i>
                    <input type="search" placeholder="Search" class="search-course">
                </div>
            </form>

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
