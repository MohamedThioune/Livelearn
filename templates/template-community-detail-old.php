<?php /** Template Name: community detail old */ ?>

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

</style>

<?php

$users = get_users();
$authors = array();
$company_id = 0;

$community = "";
if(isset($_GET['com']))
    $community = $_GET['com'];

foreach ($users as $key => $value) {
    $company_user = get_field('company',  'user_' . $value->ID );
    if($company_user[0]->post_title == $community){
        $company_id = $company_user[0]->ID;
        array_push($authors, $value->ID);
    }
}

$args = array(
    'post_type' => array('post','course','learnpath'),
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author__in' => $authors,
    'order' => 'DESC',
);

$courses = get_posts($args);

$max_user = 0;
if(!empty($authors))
    $max_user = count($authors);

$max_course = 0;
if(!empty($courses))
    $max_course = count($courses);

$company_logo = (get_field('company_logo', $company_id)) ? get_field('company_logo', $company_id) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';

?>

<div class="content-detail-community">
    <section class="first-section-community">
        <div class="container-fluid">
            <div class="block-first-selection">
                <div class="first-col">
                    <div class="card-detail-element">
                        <div class="head">
                            <div class="expert-element-detail-community">
                                <p class="number"><?= $max_user ?></p>
                                <p class="element">Experts</p>
                            </div>
                            <div class="expert-element-detail-community Deelnemers-element">
                                <p class="number">0</p>
                                <p class="element">Deelnemers</p>
                            </div>
                            <div class="expert-element-detail-community">
                                <p class="number"><?= $max_course ?></p>
                                <p class="element">Courses</p>
                            </div>
                        </div>
                        <div class="img-detail-community">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Zorgeloos-2.png" class="second-img-card-community" alt="">
                        </div>
                    </div>
                </div>
                <div class="second-col">
                    <h1 class="title-community-detail"><?= $community ?></h1>
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
                            <?php
                                foreach ($authors as $key => $author){
                                    if($key == 4)
                                        break;
                                    $portrait_image = get_field('profile_img',  'user_' . $author);
                                    if (!$portrait_image)
                                        $portrait_image = get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                    echo '<img src="' . $portrait_image . '"  alt="">';
                                }
                            ?>
                        </div>
                        <p class="numberUser">
                        <?php
                            $plus_user = 0;
                            $max_user = count($authors);
                            if($max_user > 4){
                                $plus_user = $max_user - 4;
                                echo '+' . $plus_user;
                            }
                        ?>
                        </p>
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
                        <?php
                        foreach($courses as $course){
                            /*
                            * Categories
                            */
                            $category = ' ';
                            $tree = get_the_terms($course->ID, 'course_category');
                            if($tree)
                                if(isset($tree[2]))
                                    $category = $tree[2]->name;
                            $category_id = 0;
                            if($category == ' '){
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);
                            }
    
                            /*
                            * Price
                            */
                            $p = " ";
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price =  number_format($p, 2, '.', ',');
                            else
                                $price = 'Gratis';
    
                            /*
                            * Thumbnails
                            */
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('image', 'category_'. $category_id);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                            }

                            //course-type
                            $course_type = get_field('course_type',  $course->ID);

                            //short-description
                            $short_description = get_field('short_description',  $course->ID);
                        ?>
                        <div class="card-course-community">
                            <div class="position-relative">
                                <div class="img-block-course">
                                    <img src="<?= $thumbnail ?>" class="second-img-card-community" alt="">
                                </div>
                                <div class="done-block">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/work-in-progress-.png" class="second-img-card-community" alt="">
                                    <p>00%</p>
                                </div>
                            </div>
                            <div class="content">
                                <p class="tag-category"><?= $course_type ?></p>
                                <p class="title"><?= $course->post_title ?></p>
                                <p class="content-description">
                                    <?= $short_description ?>
                                </p>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                        <!-- <div class="card-course-community">
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
                        </div> -->
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
