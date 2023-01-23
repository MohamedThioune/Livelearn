<?php /** Template Name: community detail */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<style>
    .headerdashboard,.navModife {
        background: #deeef3;
        color: #ffffff !important;
        border-bottom: 0px solid #000000;
        box-shadow: none;
    }
    .nav-link {
        color: #043356 !important;
    }
    .nav-link .containerModife{
        border: none;
    }
    .worden {
        color: white !important;
    }
    .navbar-collapse .inputSearch{
        background: #C3DCE5;
    }
    .logoModife img:first-child {
        display: none;
    }
    .imgLogoBleu {
        display: block;
    }
    .imgArrowDropDown {
        width: 15px;
        display: none;
    }
    .fa-angle-down-bleu{
        font-size: 20px;
        position: relative;
        top: 3px;
        left: 2px;
    }
    .additionBlock{
        width: 40px;
        height: 38px;
        background: #043356;
        border-radius: 9px;
        color: white !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .navModife4 .additionImg{
        display: none;
    }
    .additionBlock i{
        display: block;
    }
    .bntNotification img{
        display: none;
    }
    .bntNotification i{
        display: block;
        font-size: 28px;
    }
    .scrolled{
        background: #023356 !important;
    }
    .scrolled .logoModife img:first-child {
        display: block;
    }
    .scrolled .imgLogoBleu{
        display: none;
    }
    .scrolled .nav-link {
        color: #ffffff !important;
        display: flex;
    }
    .scrolled .imgArrowDropDown {
        display: block;
    }
    .scrolled .fa-angle-down-bleu {
        display: none;
    }
    .scrolled .inputSearch {
        background: #FFFFFF !important;
    }
    .scrolled .navModife4 .additionImg {
        display: block;
    }
    .scrolled .additionBlock{
        display: none;
    }
    .scrolled .bntNotification img {
        display: block;
    }
    .scrolled .bntNotification i {
        display: none;
    }
    .nav-item .dropdown-toggle::after {
        margin-left: 8px;
        margin-top: 10px;
    }

    }
</style>

<div class="content-detail-community">
    <section class="first-section-community">
        <div class="container-fluid">
            <div class="block-first-selection">
                <div class="first-col">
                    <div class="card-detail-element">
                        <div class="head">
                            <div class="expert-element-detail-community">
                                <p class="number">14</p>
                                <p class="element">Experts</p>
                            </div>
                            <div class="expert-element-detail-community Deelnemers-element">
                                <p class="number">1,8k</p>
                                <p class="element">Deelnemers</p>
                            </div>
                            <div class="expert-element-detail-community">
                                <p class="number">8</p>
                                <p class="element">Courses</p>
                            </div>
                        </div>
                        <div class="img-detail-community">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Zorgeloos-2.png" class="second-img-card-community" alt="">
                        </div>
                    </div>
                </div>
                <div class="second-col">
                    <h1 class="title-community-detail">Zorgeloos met Pensioen</h1>
                    <p class="sub-title-community-detail">Ben jij 45+ en wil jij meer weten over hoe je met pensioen kan gaan? Volg deze community.</p>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Nationale-Nederlanden.png" class="logo-nationale-nederlander" alt="">
                            <p class="Nationale-Nederlanden-text">nationale nederlander</p>
                        </div>
                        <p class="easy-tag">Easy</p>
                        <p class="gratis-tag">Gratis</p>
                    </div>
                    <div class="d-flex align-items-center block-btn-image">
                        <a href="" class="btn btn-volg">Volg</a>
                        <div class="userBlock">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice_Veraa_.jpeg" alt="">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/1.jpg" alt="">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Ellipse17.png" alt="">
                        </div>
                        <p class="numberUser">+342</p>
                    </div>
                </div>
            </div>
            <div class="skills-mesure">
                <div class="skillbars">
                    <div class="progress" data-fill="25" >
                    </div>
                    <div class="bg-gris-Skills"></div>
                </div>
            </div>
        </div>
    </section>
    <section class="second-section-community">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="cours-block">
                        <div class="card-course-community">
                            <div class="position-relative">
                                <div class="img-block-course">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Pensioen.png" class="second-img-card-community" alt="">
                                </div>
                                <div class="done-block">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/sign.png" class="second-img-card-community" alt="">
                                    <p>Done</p>
                                </div>
                            </div>
                            <div class="content">
                                <p class="tag-category">E-learning</p>
                                <p class="title">Wat is pensioen?</p>
                                <p class="content-description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                        </div>
                        <div class="card-course-community">
                            <div class="position-relative">
                                <div class="img-block-course">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/PensienArtikel.png" class="second-img-card-community" alt="">
                                </div>
                                <div class="done-block">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/work-in-progress-.png" class="second-img-card-community" alt="">
                                    <p>40%</p>
                                </div>
                            </div>
                            <div class="content">
                                <p class="tag-category">Artikel</p>
                                <p class="title">Sparen doe je zo!</p>
                                <p class="content-description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                        </div>
                        <div class="card-course-community">
                            <div class="position-relative">
                                <div class="img-block-course">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/PensioenArtikel2.png" class="second-img-card-community" alt="">
                                </div>
                                <div class="done-block">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/podcastIcone.png" class="second-img-card-community" alt="">
                                </div>
                            </div>
                            <div class="content">
                                <p class="tag-category">Podcast</p>
                                <p class="title">Financiële onafhankelijkheid</p>
                                <p class="content-description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                        </div>
                        <div class="card-course-community">
                            <div class="position-relative">
                                <div class="img-block-course">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/event.png" class="second-img-card-community" alt="">
                                </div>
                                <div class="done-block">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/event-calendar.png" class="second-img-card-community" alt="">
                                </div>
                            </div>
                            <div class="content">
                                <p class="tag-category">Event</p>
                                <p class="title">Maak kennis met de financiële mogelijkheden.</p>
                                <p class="content-description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                        </div>
                        <div class="card-course-community">
                            <div class="position-relative">
                                <div class="img-block-course">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/PensienArtikel.png" class="second-img-card-community" alt="">
                                </div>
                                <div class="done-block">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/leerpad-icon.png" class="second-img-card-community" alt="">
                                </div>
                            </div>
                            <div class="content">
                                <p class="tag-category">Leerpad</p>
                                <p class="title">Leerpad omgaan met financiële tegenvallers</p>
                                <p class="content-description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                        </div>
                        <div class="card-course-community">
                            <div class="position-relative">
                                <div class="img-block-course">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/video-community.png" class="second-img-card-community" alt="">
                                </div>
                                <div class="done-block">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/video-icon.png" class="second-img-card-community" alt="">
                                </div>
                            </div>
                            <div class="content">
                                <p class="tag-category">Video</p>
                                <p class="title">De mogelijkheden van online sparen.</p>
                                <p class="content-description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block-agenda">
                        <h3>Upcoming events</h3>
                        <div class="card-agenda">
                            <div class="first-block">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ionic-md-calendar.png" class="icone-agenda" alt="">
                                <p class="price">Free</p>
                            </div>
                            <div class="detail-description">
                                <p class="date">15 Aug - 10h30 | <span>online</span></p>
                                <p class="description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                            <div class="user-calendar-img">
                                <div class="userBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice_Veraa_.jpeg" alt="">
                                    <div class="number">
                                        <p>15</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-agenda">
                            <div class="first-block">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ionic-md-calendar.png" class="icone-agenda" alt="">
                                <p class="price">Free</p>
                            </div>
                            <div class="detail-description">
                                <p class="date">15 Aug - 10h30 | <span>online</span></p>
                                <p class="description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                            <div class="user-calendar-img">
                                <div class="userBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice_Veraa_.jpeg" alt="">
                                    <div class="number">
                                        <p>15</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-agenda">
                            <div class="first-block">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ionic-md-calendar.png" class="icone-agenda" alt="">
                                <p class="price">Free</p>
                            </div>
                            <div class="detail-description">
                                <p class="date">15 Aug - 10h30 | <span>online</span></p>
                                <p class="description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                            <div class="user-calendar-img">
                                <div class="userBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice_Veraa_.jpeg" alt="">
                                    <div class="number">
                                        <p>15</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-agenda">
                            <div class="first-block">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ionic-md-calendar.png" class="icone-agenda" alt="">
                                <p class="price">Free</p>
                            </div>
                            <div class="detail-description">
                                <p class="date">15 Aug - 10h30 | <span>online</span></p>
                                <p class="description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                            <div class="user-calendar-img">
                                <div class="userBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice_Veraa_.jpeg" alt="">
                                    <div class="number">
                                        <p>15</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-agenda">
                            <div class="first-block">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ionic-md-calendar.png" class="icone-agenda" alt="">
                                <p class="price">Free</p>
                            </div>
                            <div class="detail-description">
                                <p class="date">15 Aug - 10h30 | <span>online</span></p>
                                <p class="description">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ‘Content here, content here’, making it look like readable English.</p>
                            </div>
                            <div class="user-calendar-img">
                                <div class="userBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Maurice_Veraa_.jpeg" alt="">
                                    <div class="number">
                                        <p>15</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="footer-card-agenda">
                            <p>Bekijk alles</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<?php get_footer(); ?>
<?php wp_footer(); ?>


<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    $(function() {
        var header = $(".navbar");
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 61) {
                header.addClass("scrolled");
            } else {
                header.removeClass("scrolled");
            }
        });

    });
</script>

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
