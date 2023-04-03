<html lang="en">

<?php /** Template Name: start-course-mandatory-offline */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
<body>
<div class="content-start-course">
    <div class="headBlock ">
        <div class="d-flex justify-content-between align-items-center">
            <div class="">
                <a href=""><i class="fa fa-angle-left"></i>Back</a>
                <p class="title-course">Learn Responsive Web Design Essentials</p>
                <p class="text-number-element">Video (35)</p>
            </div>
<!--            <p class="percentage-progress-course">2%</p>-->
        </div>
        <button class="btn btn-show-list-course" type="button"><i class="fa fa-filter"></i> Show list course element </button>
    </div>
    <div class="body-content-strat d-flex">
        <div class="side-bar-course">
           <button class="btn btn-hide-bar">
               <i class="fa fa-times" aria-hidden="true"></i>
           </button>
            <div class="tab-block-start">
                <div class="tabs-courses">
                    <div class="tabs">
                        <ul class="filters">
                            <li class="item active">Overview</li>
                            <li class="item">Review</li>
                        </ul>

                        <div class="tabs__list">
                            <div class="tab tab-Overview active">
                                <div class="content-list-course">
                                    <ul class="text-left">
                                        <li>
                                            <a href="">
                                                <i class="far fa-play-circle" aria-hidden="true"></i>Introduction
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="far fa-play-circle" aria-hidden="true"></i>Discover the organization of a network
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="far fa-play-circle" aria-hidden="true"></i>Discover the organization of a network
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="far fa-play-circle" aria-hidden="true"></i>Discover the organization of a network
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <i class="far fa-play-circle" aria-hidden="true"></i>Discover the organization of a network
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                Conclusion
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="tab ReviewTab">
                                <div class="block-note-review block-note-reviewBiss">
                                    <p class="note-text">4.8</p>
                                    <div class="rating-bying-course">
                                        <div class="rating-element2">
                                            <div class="rating">
                                                <input type="radio" id="star5-note" class="stars disabled" disabled name="rating-note" value="5" />
                                                <label class="star" for="star5-note" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-note" class="stars" checked name="rating-note" value="4" />
                                                <label class="star" for="star4-note" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-note" class="stars" name="rating-note" value="3" />
                                                <label class="star" for="star3-note" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-note" class="stars" name="rating-note" value="2" />
                                                <label class="star" for="star2-note" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-note" name="rating-note" value="1" />
                                                <label class="star" for="star1-note" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
                                        </div>
                                    </div>
                                    <p class="note-description">Course Rating</p>
                                </div>
                                <div class="block-your-review">
                                    <div class="card-info d-flex">
                                        <div class="your-review-element w-100">
                                            <p class="title-review text-left mb-3">Your review</p>
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5-review" class="stars" name="rating-review" value="5" />
                                                    <label class="star" for="star5-review" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-review" class="stars" name="rating-review" value="4" />
                                                    <label class="star" for="star4-review" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-review" class="stars" name="rating-review" value="3" />
                                                    <label class="star" for="star3-review" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-review" class="stars" name="rating-review" value="2" />
                                                    <label class="star" for="star2-review" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-review" name="rating-review" value="1" />
                                                    <label class="star" for="star1-review" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                            <textarea name="" id="" rows="10"></textarea>
                                            <div class="position-relative">
                                                <button class="btn btn-send">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="all-review-course-buying">
                                        <div class="card-list-review flex-wrap text-left">
                                            <div class="imgUserElement">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                            </div>
                                            <div class="w-90">
                                                <p class="name-reviewer">Stella Johnson</p>
                                                <p class="date-of-review">14th, April 2023</p>
                                            </div>
                                            <p class="text-review w-100">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tationUt wisi enim ad minim veniam, </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="content-course-strat position-relative">
           <div>
               <p class="text-course-mandatory-offline">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eu fermentum augue, sit amet convallis augue. Integer eu iaculis sem, sed euismod eros. Nulla facilisi.
                   Proin luctus odio nunc, sed laoreet est bibendum vitae. Sed a eleifend ex. Integer varius rhoncus euismod. Aliquam ac ultricies turpis, vitae eleifend ligula. Aliquam faucibus erat ut tincidunt cursus.
                   Cras et ullamcorper velit. In hac habitasse platea dictumst. Nunc vitae dui quis risus elementum auctor.</p>

               <p class="text-course-mandatory-offline">Maecenas quam nunc, sagittis non condimentum at, rutrum sit amet eros. Fusce rutrum, lectus in blandit sagittis, mi tortor ullamcorper mi, vitae vestibulum libero quam a nisi.
                   In eu mauris et neque sodales porta eu eget dui. Nunc eu quam sit amet justo elementum mollis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed laoreet metus nulla, in gravida urna rhoncus in.
                   Proin laoreet semper tortor ac posuere. Cras non leo at ipsum fringilla ullamcorper. Etiam velit est, tempor id lobortis eu, lacinia id sem. Nam ornare mattis dui a porta. Aliquam a ullamcorper velit, et hendrerit eros. Etiam accumsan porta neque in viverra.
                   Proin eleifend, eros in tristique hendrerit, nisi purus cursus sapien,
                   id ultrices nunc tellus a ipsum. Donec et fringilla neque. Aenean consequat purus quis lectus maximus fermentum.</p>
               <div class="block-img-mandatory">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/stratBuck.png" alt="">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/stratBuck.png" alt="">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/stratBuck.png" alt="">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/stratBuck.png" alt="">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/stratBuck.png" alt="">
               </div>
           </div>

            <div class="d-flex justify-content-between prev-next-btn">
                <!--  <a href="" class="btn btn-prev">
                       <i class="fa fa-angle-left"></i>
                       text ici
                </a>-->
                <a href="" class="btn btn-next ml-auto">
                    I've finished I'll continue
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>`


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
<script>
    $(document).ready(function() {
        $(".btn-show-list-course").click(function() {
            $(".side-bar-course").show();
        });
        $(".btn-hide-bar").click(function() {
            $(".side-bar-course").hide();
        });
    });
</script>

</body>
</html>