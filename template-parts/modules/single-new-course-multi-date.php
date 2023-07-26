<?php /** Template Name: template course multi date */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<!-- Calendly link widget begin -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">

<body>
<div class="content-new-Courses">
    <div class="content-head">
        <div class="container-fluid">
            <div class="content-autors-detail">
                <div class="blockImg">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/detail-handel.jpeg" alt="">
                </div>
                <div class="block-name-langue">
                    <p class="name-autors">Daniel</p>
                    <p class="langue-text">English</p>
                </div>
                <hr>
                <div class="block-review-calendar">
                    <div class="d-flex align-items-center element-content-head">
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <i class="fa fa-star checked"></i>
                        <p class="reviews-text">5 Reviews</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class='fa fa-calendar-alt'></i>
                        <p class="date">24/08/2023</p>
                    </div>
                </div>
            </div>
            <h1 class="title-course">Test Course multiple strat date</h1>
            <p class="category-course">Oplieiding</p>
        </div>
    </div>
    <div class="body-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-tabs-scroll">
                        <ul>
                            <li><a class="tabs-scrool-link" href="#Overview">Overview</a></li>
                            <li><a class="tabs-scrool-link" href="#Overview">Dates</a></li>
                            <li><a class="tabs-scrool-link" href="#Instructor">Instructor</a></li>
                            <li><a class="tabs-scrool-link" href="#Reviews">Reviews</a></li>
                        </ul>
                        <div class="content-section-tabs">
                            <div class="section-tabs" id="Overview">
                                <div class="block-description">
                                    <h2>Description</h2>
                                    <p class="text-tabs">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                    </p>

                                </div>
                            </div>

                            <div class="section-tabs" id="date">
                                <h2>Dates</h2>

                                <div class="block2evens block2evensTabs">
                                    <section>
                                        <details>
                                            <summary class="dateText1">

                                                <div class="headTabsAccordion">
                                                    <p class="Date__inner">21 Juli - 28 Juli</p>
                                                    <p class="location">Dakar</p>
                                                    <p class="prixEvens">111 €</p>
                                                </div>

                                            </summary>
                                            <div class="detailSummary">
                                                <div class="Course-info">
                                                    <h3>Cursus</h3>
                                                    <div class="blockDateEvens">
                                                        <p class="dateEvens">21 Juli, 00:00, Dakar</p>
                                                        <p class="dateEvens">21 Juli, 00:00, Dakar</p>
                                                        <p class="dateEvens">21 Juli, 00:00, Dakar</p>
                                                    </div>
                                                </div>
                                                <div class="Course-chechkout">
                                                    <h3>Boek training</h3>
                                                    <select class="Course-people" name="" id="">
                                                        <option value="1"> 1 persoon </option>
                                                        <option value="2"> 2 persoon </option>
                                                        <option value="3"> 3 persoon </option>
                                                    </select>

                                                    <table class="tablePrice">
                                                        <tbody>
                                                        <tr>
                                                            <th>1x reguliere trainingsprijs</th>
                                                            <td><p class="prix">122 €</p></td>
                                                        </tr>
                                                        </tbody>
                                                        <tfoot>
                                                        <tr>
                                                            <td colspan="2"><div class="price"><p>122 €</p></div></td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                    <div class="contentBtnCardProduct">
                                                        <button type="submit" name="add-to-cart" class="single_add_to_cart_button button alt">Reserveren</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </details>
                                    </section>
                                </div>

                            </div>

                            <div class="section-tabs" id="Instructor">
                                <h2>Instructor</h2>
                                <div class="d-flex">
                                    <div class="blockImg">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/dan.jpg" alt="">
                                    </div>
                                    <div>
                                        <p class="name-autors">Daniel</p>
                                        <p class="langue-text">English</p>
                                        <div class="d-flex flex-wrap">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-star checked"></i>
                                                <p class="text-detail-reveiw text-detail-reveiw2"> 5.0 Instructor Rating</p>
                                            </div>
                                            <p class="text-detail-reveiw">5 Reviews</p>
                                            <p class="text-detail-reveiw">80 Students</p>
                                            <p class="text-detail-reveiw">15 Courses</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-about-authors">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            </div>

                            <div class="section-tabs" id="Reviews">
                                <h2>Student's feedback</h2>
                                <div class="d-flex justify-content-between flex-wrap block-review-course">
                                    <div class="block-note-review">
                                        <p class="note-text">4%</p>
                                        <div class="rating-bying-course">
                                            <div class="rating-element2">
                                                <div class="rating">
                                                  <input type="radio" id="star" class="stars" name="rating-note" value="4" />
                                                                <label class="star" for="star" title="" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                        </div>
                                        <p class="note-description">Course Rating</p>
                                    </div>
                                    <div class="barNote">
                                        <div class="skillbars">
                                            <div class="progress" data-fill="5" >
                                            </div>
                                            <div class="bg-gris-Skills"></div>
                                        </div>
                                        <div class="skillbars">
                                            <div class="progress" data-fill="4" >
                                            </div>
                                            <div class="bg-gris-Skills"></div>
                                        </div>
                                        <div class="skillbars">
                                            <div class="progress" data-fill="3" >
                                            </div>
                                            <div class="bg-gris-Skills"></div>
                                        </div>
                                        <div class="skillbars">
                                            <div class="progress" data-fill="2" >
                                            </div>
                                            <div class="bg-gris-Skills"></div>
                                        </div>
                                        <div class="skillbars">
                                            <div class="progress" data-fill="1" >
                                            </div>
                                            <div class="bg-gris-Skills"></div>
                                        </div>
                                    </div>
                                    <div class="block-rating-note">
                                        <div class="element-block-rating">
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5-Great" class="stars" checked  name="rating-Great" value="5" />
                                                    <label class="star" for="star5-Great" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-Great" class="stars" name="rating-Great" value="4" />
                                                    <label class="star" for="star4-Great" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-Great" class="stars" name="rating-Great" value="3" />
                                                    <label class="star" for="star3-Great" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-Great" class="stars" name="rating-Great" value="2" />
                                                    <label class="star" for="star2-Great" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-Great" name="rating-Great" value="1" />
                                                    <label class="star" for="star1-Great" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                            <p class="note-global-rating">5 %</p>
                                        </div>
                                        <div class="element-block-rating">
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5-Very-good" class="stars disabled" disabled name="rating-Very-good" value="5" />
                                                    <label class="star" for="star5-Very-good" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-Very-good" class="stars" checked name="rating-Very-good" value="4" />
                                                    <label class="star" for="star4-Very-good" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-Very-good" class="stars" name="rating-Very-good" value="3" />
                                                    <label class="star" for="star3-Very-good" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-Very-good" class="stars" name="rating-Very-good" value="2" />
                                                    <label class="star" for="star2-Very-good" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-Very-good" name="rating-Very-good" value="1" />
                                                    <label class="star" for="star1-Very-good" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                            <p class="note-global-rating">4 %</p>
                                        </div>
                                        <div class="element-block-rating">
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5-Good" class="stars" name="rating-Good" value="5" />
                                                    <label class="star" for="star5-Good" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-Good" class="stars disabled" disabled  name="rating-Good" value="4" />
                                                    <label class="star" for="star4-Good" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-Good" class="stars" checked name="rating-Good" value="3" />
                                                    <label class="star" for="star3-Good" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-Good" class="stars" name="rating-Good" value="2" />
                                                    <label class="star" for="star2-Good" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-Good" name="rating-Good" value="1" />
                                                    <label class="star" for="star1-Good" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                            <p class="note-global-rating">3 %</p>
                                        </div>
                                        <div class="element-block-rating">
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="star5-stars" class="stars" name="rating-stars" value="5" />
                                                    <label class="star" for="star5-stars" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="star4-stars" class="stars"  name="rating-stars" value="4" />
                                                    <label class="star" for="star4-stars" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star3-stars" class="stars disabled" disabled name="rating-stars" value="3" />
                                                    <label class="star" for="star3-stars" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star2-stars" class="stars-stars" checked name="rating" value="2" />
                                                    <label class="star" for="star2-stars" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star1-stars" name="rating-stars" value="1" />
                                                    <label class="star" for="star1-stars" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                            <p class="note-global-rating">2 %</p>
                                        </div>
                                        <div class="element-block-rating">
                                            <div class="rating-element2">
                                                <div class="rating">
                                                    <input type="radio" id="5bad" class="stars" name="rating-bad" value="5" />
                                                    <label class="star" for="5bad" title="Awesome" aria-hidden="true"></label>
                                                    <input type="radio" id="4bad" class="stars"  name="rating-bad" value="4" />
                                                    <label class="star" for="4bad" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="3bad" class="stars" name="rating-bad" value="3" />
                                                    <label class="star" for="3bad" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="2bad" class="stars disabled" disabled name="rating-bad" value="2" />
                                                    <label class="star" for="2bad" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="1bad" name="rating-bad" checked value="1" />
                                                    <label class="star" for="1bad" class="stars" title="Bad" aria-hidden="true"></label>
                                                </div>
                                                <span class="rating-counter"></span>
                                            </div>
                                            <p class="note-global-rating">1 %</p>
                                        </div>
                                    </div>
                                </div>

                                            <div class="user-comment-block">
                                                <div class="d-flex">
                                                    <div class="img-block">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/dan.jpg" alt="">
                                                    </div>
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <p class="name-autors-comment"><p class="timing-comment">3 days ago </p></div>
                                                        <p class="title-comment">loren ipsum title</p>
                                                    </div>
                                                </div>
                                                <p class="text-tabs">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                            </div>
                                    <div class="comment-block">
                                        <h2>Write a Review</h2>
                                        <form action="/dashboard/user" method="POST" id="review_vid">
                                            <input type="hidden" name="course_id" value="" >
                                        </form>
                                        <div class="rating-element2">
                                            <div class="rating">
                                                <input type="radio" id="star5-review" class="stars" name="rating" value="5" form="review_vid"/>
                                                <label class="star" for="star5-review" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4-review" class="stars" name="rating" value="4" form="review_vid"/>
                                                <label class="star" for="star4-review" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3-review" class="stars" name="rating" value="3" form="review_vid"/>
                                                <label class="star" for="star3-review" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2-review" class="stars" name="rating" value="2" form="review_vid"/>
                                                <label class="star" for="star2-review" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1-review" name="rating" value="1" form="review_vid"/>
                                                <label class="star" for="star1-review" class="stars" title="Bad" aria-hidden="true"></label>
                                            </div>
                                            <span class="rating-counter"></span>
                                        </div>
                                        <textarea name="feedback_content" id="feedback" rows="10" form="review_vid"></textarea>
                                        <div class="position-relative">
                                            <!-- <input type="button" class='btn btn-send' id='btn_review' name='review_post' value='Send'> -->
                                            <button type="submit" class='btn btn-send' id='btn_review' name='review_post' form="review_vid">Send</button>
                                        </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-block-detail-course">
                        <div class="card-detail-course">
                            <div class="head">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/backend.jpg" alt="">
                            </div>
                            <p class="title-course">Course Includes</p>
                            <ul>
                                <li>
                                    <p class="name-element-detail">Price:</p>
                                    <p class="detail priceCourse">455 €</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Instructor:</p>
                                    <p class="detail">Daniel</p>
                                </li>
                                <!--
                                <li>
                                    <p class="name-element-detail">Duration:</p>
                                    <p class="detail">3 weeks</p>
                                </li>
                                -->
                                <li>
                                    <p class="name-element-detail">Lessons:</p>
                                    <p class="detail">Opleiders</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Enrolled</p>
                                    <p class="detail">15</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Language:</p>
                                    <p class="detail">English</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Certificate:</p>
                                    <p class="detail">No</p>
                                </li>
                                <li>
                                    <p class="name-element-detail">Access:</p>
                                    <p class="detail">Fulltime</p>
                                </li>

                                <div class="sharing-element">
                                    <p>Share On:</p>
                                    <div class="d-flex flex-wrap">
                                        <a href="">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-facebook-f"></i>
                                        </a>
                                        <a href="">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="card-detail-course">
                            <h2>Others Course</h2>
                           <a href="" class="other-course">
                                <div class="blockImgOtherCourse">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/women-phone.png" alt="">
                                </div>
                                <div>
                                    <p class="name-other-course">Example course</p>
                                    <p class="price-other-course">$415.99</p>
                                </div>
                            </a>
                           <a href="" class="other-course">
                                <div class="blockImgOtherCourse">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/women-phone.png" alt="">
                                </div>
                                <div>
                                    <p class="name-other-course">Example course</p>
                                    <p class="price-other-course">$415.99</p>
                                </div>
                            </a>
                           <a href="" class="other-course">
                                <div class="blockImgOtherCourse">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/women-phone.png" alt="">
                                </div>
                                <div>
                                    <p class="name-other-course">Example course</p>
                                    <p class="price-other-course">$415.99</p>
                                </div>
                            </a>
                           <a href="" class="other-course">
                                <div class="blockImgOtherCourse">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/women-phone.png" alt="">
                                </div>
                                <div>
                                    <p class="name-other-course">Example course</p>
                                    <p class="price-other-course">$415.99</p>
                                </div>
                            </a>
                           <a href="" class="other-course">
                                <div class="blockImgOtherCourse">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/women-phone.png" alt="">
                                </div>
                                <div>
                                    <p class="name-other-course">Example course</p>
                                    <p class="price-other-course">$415.99</p>
                                </div>
                            </a>
                            <div class="other-course">
                                <div class="blockImgOtherCourse">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Daniel-van-der.png" alt="">
                                </div>
                                <div>
                                    <p class="name-other-course">Developpement front and Design</p>
                                    <p class="price-other-course">$415.99</p>
                                </div>
                            </div>

                            <a href="" class="btn btn-see-all">See All</a>
                        </div>
                        <div class="card-pub-course">
                            <h2>We Help You Learn While
                                Staying Home</h2>
                            <a href="/about" class="btn btn-started-now">Get Started Now</a>
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/man-pub.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var sections = $('.section-tabs')
        , nav = $('.content-tabs-scroll')
        , nav_height = nav.outerHeight();

    $(window).on('scroll', function () {
        var cur_pos = $(this).scrollTop();

        sections.each(function() {
            var top = $(this).offset().top - nav_height,
                bottom = top + $(this).outerHeight();

            if (cur_pos >= top && cur_pos <= bottom) {
                nav.find('a').removeClass('active');
                sections.removeClass('active');

                $(this).addClass('active');
                nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active');
            }
        });
    });
    nav.find('a').on('click', function () {
        var $el = $(this)
            , id = $el.attr('href');

        $('html, body').animate({
            scrollTop: $(id).offset().top - nav_height
        }, 500);

        return false;
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    class ProgressBar{
        constructor(progressBar, fill, skillName){
            this.progressBar = progressBar;
            this.skillName = skillName
            this.fill = fill;
            this.speed = 15; //Speed of the fill, increasing it will slow down
            this.actual = 0;
            this.filling();
        }
        filling(){
            if( this.actual < this.fill){
                this.progressBar.style.width = String(this.actual++)+"%";
                this.progressBar.innerHTML = this.skillName+String(this.actual)+"%";
                setTimeout(() => this.filling(), this.speed);
            }
            else{
                return;
            }
            return;
        }
    }

    let options = {
        threshold: 0 // value from 0 to 1.0, stablishes the porcentage of the bar that need to be displayed before launching the animation
    }

    var progressBars = document.querySelectorAll('.progress');
    let observer = new IntersectionObserver((progressBars) => {
        progressBars.forEach( progressBar => {
            if(progressBar.isIntersecting ){
                let fill = progressBar.target.getAttribute('data-fill');
                let skillName = progressBar.target.innerHTML;
                new ProgressBar(progressBar.target, fill, skillName);
                observer.unobserve(progressBar.target);
            }
        });

    }, options);

    progressBars.forEach( progressBar => observer.observe(progressBar));

</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>

</body>
