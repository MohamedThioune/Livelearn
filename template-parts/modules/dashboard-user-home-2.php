<?php
$like_src = get_stylesheet_directory_uri()."/img/heart-like.png";
$dislike_src = get_stylesheet_directory_uri()."/img/heart-dislike.png";
?>
<div class="content-new-user d-flex">
    <section class="first-section-dashboard">
        <div class="head-block d-flex justify-content-between mb-50">
            <div class="category-block-course d-flex justify-content-between bg-green">
                <div>
                    <div class="icone-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/symbols_check-box.png" alt="">
                    </div>
                    <p class="number-course">300</p>
                    <p class="description">Completed course</p>
                </div>
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/symbols_check-box-1.png" class="img-bg-categories-course" alt="">
            </div>
            <div class="category-block-course d-flex justify-content-between bg-yellow">
                <div>
                    <div class="icone-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_alarm-light.png" alt="">
                    </div>
                    <p class="number-course">100</p>
                    <p class="description">In progress course</p>
                </div>
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_alarm-light-1.png" class="img-bg-categories-course" alt="">
            </div>
            <div class="category-block-course d-flex justify-content-between bg-bleu-luzien">
                <div>
                    <div class="icone-course">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_folder-file.png" alt="">
                    </div>
                    <p class="number-course">1300</p>
                    <p class="description">Upcoming course</p>
                </div>
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/mdi_alarm-light-1.png" class="img-bg-categories-course" alt="">
            </div>
        </div>
        <div class="search-filter d-flex justify-content-between align-items-center ">
            <input type="search" class="form-control" placeholder="search">
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/uicons_filtering.png" alt="">
                    </label>
                </div>
                <select class="custom-select" id="inputGroupSelect01">
                    <option selected>Filter</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
        <div class="tabs-courses">
            <div class="tabs">
                <ul class="filters">
                    <li class="item active">All</li>
                    <li class="item">Artikel</li>
                    <li class="item">E-learning</li>
                    <li class="item">Opleidingen</li>
                    <li class="item">Video</li>
                    <li class="item">Trends</li>
                </ul>

                <div class="tabs__list">
                    <div class="tab active">
                        <div class="block-new-card-course">
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="block-new-card-course">
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="block-new-card-course">
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="block-new-card-course">
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="block-new-card-course">
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="block-new-card-course">
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                            <div class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Rectangle-21.png" class="" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course">UI design</p>
                                    <button>
                                        <img class="btn_favourite"  src="<?php echo get_stylesheet_directory_uri();?>/img/love.png" alt="">
                                        <img class="btn_favourite d-none"  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                                    </button>
                                </div>
                                <div class="autor-price-block d-flex justify-content-between align-items-center">
                                    <p class="autor"><b>By</b>: Samanthan wiliams</p>
                                    <p class="price">$ 400</p>
                                </div>
                                <div class="footer-card-course d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <img class=""  src="<?php echo get_stylesheet_directory_uri();?>/img/tabler_clock-hour.png" alt="">
                                        <p class="hours-course">4h</p>
                                    </div>
                                    <a href="">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </section>
    <section class="second-section-dashboard">
        <div class="Upcoming-block">
            <h2>Upcoming Schedule</h2>
            <div class="card-Upcoming">
                <p class="title">Web design</p>
                <div class="d-flex align-items-center justify-content-between">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                    <p class="date">January 31, 2023</p>
                    <hr>
                    <p class="time">10 AM - Online</p>
                </div>
                <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                    <div class="d-flex align-items-center">
                        <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri();?>/img/autor1.png" alt="">
                        <p class="nameAutor">Samanthan wiliams</p>
                    </div>
                    <p class="price">Free</p>
                </div>
            </div>
            <div class="card-Upcoming">
                <p class="title">Web design</p>
                <div class="d-flex align-items-center justify-content-between">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                    <p class="date">January 31, 2023</p>
                    <hr>
                    <p class="time">10 AM - Online</p>
                </div>
                <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                    <div class="d-flex align-items-center">
                        <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri();?>/img/autor1.png" alt="">
                        <p class="nameAutor">Samanthan wiliams</p>
                    </div>
                    <p class="price">Free</p>
                </div>
            </div>
            <div class="card-Upcoming">
                <p class="title">Web design</p>
                <div class="d-flex align-items-center justify-content-between">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                    <p class="date">January 31, 2023</p>
                    <hr>
                    <p class="time">10 AM - Online</p>
                </div>
                <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                    <div class="d-flex align-items-center">
                        <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri();?>/img/autor1.png" alt="">
                        <p class="nameAutor">Samanthan wiliams</p>
                    </div>
                    <p class="price">Free</p>
                </div>
            </div>
            <a href="/" class="btn btn-more-events">More Events</a>
        </div>
        <div class="user-community-block">
            <h2>Community</h2>
            <div class="card-Community d-flex align-items-center">
                <div class="imgCommunity">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/Community-1.png" alt="">
                </div>
                <div>
                    <p class="title">Designer community, Dakar</p>
                    <p class="number-members">112K Members</p>
                </div>
            </div>
            <div class="card-Community d-flex align-items-center">
                <div class="imgCommunity">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/Community-1.png" alt="">
                </div>
                <div>
                    <p class="title">Designer community, Dakar</p>
                    <p class="number-members">112K Members</p>
                </div>
            </div>
            <div class="card-Community d-flex align-items-center">
                <div class="imgCommunity">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/Community-1.png" alt="">
                </div>
                <div>
                    <p class="title">Designer community, Dakar</p>
                    <p class="number-members">112K Members</p>
                </div>
            </div>
            <a href="/" class="btn btn-more-events">More</a>
        </div>
        <div class="user-expert-block">
            <h2>Expert</h2>
            <a href="" class="card-user-expert d-flex">
                <div class="imgAutor">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/autorUser1.png" alt="">
                </div>
                <div>
                    <p class="name-autor">Daniel</p>
                    <div class="d-flex align-items-center">
                        <img class="iconeCompany" src="<?php echo get_stylesheet_directory_uri();?>/img/ic_round-work.png" alt="">
                        <p class="nameCompany">Livelearn </p>
                    </div>
                </div>
            </a>
            <a href="" class="card-user-expert d-flex">
                <div class="imgAutor">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/autorUser1.png" alt="">
                </div>
                <div>
                    <p class="name-autor">Daniel</p>
                    <div class="d-flex align-items-center">
                        <img class="iconeCompany" src="<?php echo get_stylesheet_directory_uri();?>/img/ic_round-work.png" alt="">
                        <p class="nameCompany">Livelearn </p>
                    </div>
                </div>
            </a>
            <a href="" class="card-user-expert d-flex">
                <div class="imgAutor">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/autorUser1.png" alt="">
                </div>
                <div>
                    <p class="name-autor">Daniel</p>
                    <div class="d-flex align-items-center">
                        <img class="iconeCompany" src="<?php echo get_stylesheet_directory_uri();?>/img/ic_round-work.png" alt="">
                        <p class="nameCompany">Livelearn </p>
                    </div>
                </div>
            </a>
            <a href="" class="card-user-expert d-flex">
                <div class="imgAutor">
                    <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/autorUser1.png" alt="">
                </div>
                <div>
                    <p class="name-autor">Daniel</p>
                    <div class="d-flex align-items-center">
                        <img class="iconeCompany" src="<?php echo get_stylesheet_directory_uri();?>/img/ic_round-work.png" alt="">
                        <p class="nameCompany">Livelearn </p>
                    </div>
                </div>
            </a>
            <a href="/" class="btn btn-more-events">See All</a>
        </div>
    </section>
</div>



<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.querySelectorAll(".filters .item").forEach(function (tab, index) {
        tab.addEventListener("click", function () {
            const filters = document.querySelectorAll(".filters .item");
            const tabs = document.querySelectorAll(".tabs__list .tab");

            filters.forEach(function (tab) {
                tab.classList.remove("active");
            });
            this.classList.add("active");

            tabs.forEach(function (tabContent) {
                tabContent.classList.remove("active");
            });
            tabs[index].classList.add("active");
        });
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>

<script src=<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
<script src=<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
<script src=<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
<script src=<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autorefresh.js"></script>
<script src=<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>


<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:30,
        nav:false,
        lazyLoad:true,
        dots: false,
        responsive:{
            0:{
                items:1.3
            },
            600:{
                items:1.3
            },
            1000:{
                items:3
            }
        }
    })
</script>


