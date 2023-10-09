<?php /** Template Name: community detail */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>

<header>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
</header>

<body>

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
    global $wp;

    $via_url = get_site_url() . "/community-overview";

    //current user
    $user_id = get_current_user_id();

    $no_content =  '
                    <p class="dePaterneText theme-card-description"> 
                    <span style="color:#033256"> Stay connected, Something big is coming 😊 </span> 
                    </p>
                    ';
    $users = get_users();
    $authors = array();

    $community = "";
    if(isset($_GET['mu']))
        $community = get_post($_GET['mu']);

    if($community){

        $company = get_field('company_author', $community->ID);
        $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
        $community_image = get_field('image_community', $community->ID) ?: $company_image;

        foreach ($users as $value) {
            $company_user = get_field('company',  'user_' . $value->ID )[0];
            if($company_user->post_title == $company->post_title)
                array_push($authors, $value->ID);
        }

        // courses comin through custom field 
        $courses = get_field('course_community', $community->ID);

        // range on community
        $level = get_field('range', $community->ID);

        // employees of the company on community 
        $max_user = 0;
        if(!empty($authors))
            $max_user = count($authors);

        // courses on community 
        $max_course = 0;
        if(!empty($courses))
            $max_course = count($courses);

        // followers on community
        $max_follower = 0;
        $followers = get_field('follower_community', $community->ID);
        if(!empty($followers))
            $max_follower = count($followers);
?>
    <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;height: 106% !important; overflow-y:hidden !important;">
        <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

            <div class="modal-content">

                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body  px-md-4 px-0">
                    <div class="mb-4">
                        <div class="text-center">
                            <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">     
                        </div>  
                        <h3 class="text-center my-2">Sign Up</h3>
                        <div class="text-center">
                            <p>Already a member? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#exampleModalCenter">&nbsp; Sign in</a></p>
                        </div>
                    </div>  


                    <?php
                        echo (do_shortcode('[user_registration_form id="8477"]')); 
                    ?>

                    <div class="text-center">
                        <p>Al een account? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                data-toggle="modal" data-target="#exampleModalCenter">Log-in</a></p>
                    </div>

                </div>
            </div>
        
        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

    <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;overflow-y:hidden !important;height: 95%; ">
        <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body  px-md-5 px-4">
                    <div class="mb-4">
                        <div class="text-center">
                            <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">     
                        </div>
                        <h3 class="text-center my-2">Sign In</h3>
                        <div class="text-center">
                            <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#SignInWithEmail">&nbsp; Sign Up</a></p>
                        </div>
                    </div>

                    <?php
                    wp_login_form([
                        'redirect' => $via_url,
                        'remember' => false,
                        'label_username' => 'Wat is je e-mailadres?',
                        'placeholder_email' => 'E-mailadress',
                        'label_password' => 'Wat is je wachtwoord?'
                    ]);
                    ?>
                    <div class="text-center">
                        <p>Nog geen account?  <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                            data-toggle="modal" data-target="#SignInWithEmail">Meld je aan</a></p>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->


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
                                    <p class="number"><?= $max_follower ?></p>
                                    <p class="element">Deelnemers</p>
                                </div>
                                <div class="expert-element-detail-community">
                                    <p class="number"><?= $max_course ?></p>
                                    <p class="element">Courses</p>
                                </div>
                            </div>
                            <div class="img-detail-community">
                                <img src="<?= $community_image; ?>" class="second-img-card-community" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="second-col">
                        <h1 class="title-community-detail"><?= $community->post_title; ?></h1>
                        <p class="sub-title-community-detail"><?= $community->post_excerpt; ?></p>
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="<?= $company_image ?>" class="logo-nationale-nederlander" alt="">
                                <p class="Nationale-Nederlanden-text"><?= $company->post_title; ?></p>
                            </div>
                            <p class="easy-tag"><?= $level ?></p>
                            <p class="gratis-tag">Gratis</p>
                        </div>
                        <div class="d-flex align-items-center block-btn-image">
                            <?php
                                $bool = false;
                                if(!$user_id)
                                    echo '<a href="#" data-dismiss="modal" aria-label="Close" class="btn btn-volg"
                                            data-toggle="modal" data-target="#SignInWithEmail">Volg</a>';
                                else{
                                    if(!empty($followers))
                                    foreach ($followers as $key => $value)
                                        if($value->ID == $user_id){
                                            $bool = true;
                                            break;
                                        }

                                    if(!$bool)
                                        echo "<form action='/dashboard/user/' method='POST'>
                                                    <input type='hidden' name='community_id' value='" . $community->ID . "' >
                                                    <input type='submit' class='btn btn-volg' name='follow_community' value='Volg' >
                                              </form>";
                                    else
                                        echo " <button type='button' class='btn btn-volg' disabled>Volg</button>";

                                }
                            ?>

                            <div class="userBlock">
                                <?php
                                    // Get followers from company
                                    if(!empty($followers))
                                    foreach ($followers as $key => $value) {
                                        if($key == 4)
                                            break;
                                        $portrait_image = get_field('profile_img',  'user_' . $value->ID);
                                        if (!$portrait_image)
                                            $portrait_image = $company_image;
                                        echo '<img src="' . $portrait_image . '"  alt="">';
                                    }
                                ?>
                            </div>
                            <p class="numberUser">
                            <?php
                                $plus_user = 0;
                                $max_user = 0;
                                if(!empty($followers))
                                    $max_user = count($followers);
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
                        <div class="progress" data-fill="<?= rand(0,100); ?>" >
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
                        $events = array();
                        $i = 0;
                        if(!empty($courses))
                            foreach($courses as $key => $course){
                                // course-type
                                $course_type = get_field('course_type', $course->ID);
                                if($course_type == 'Event'){
                                    array_push($events, $course);
                                    continue;
                                }
                                $i++;

                                if($i == 9)
                                    continue;
                                
                                // image
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                            
                                $exposition = '';
                                switch ($course_type) {
                                    case 'E-learning':
                                        $exposition = '<div class="img-block-course">
                                                            <img src="' . $thumbnail . '" class="second-img-card-community" alt="">
                                                        </div>
                                                        <div class="done-block">
                                                            <img src="' . get_stylesheet_directory_uri() . '/img/sign.png" class="second-img-card-community" alt="">
                                                            <p>Done</p>
                                                        </div>';
                                        break;
                                    case 'Artikel':
                                        $exposition = '<div class="img-block-course">
                                                            <img src="' . $thumbnail . '" class="second-img-card-community" alt="">
                                                        </div>
                                                        <div class="done-block">
                                                            <img src="' . get_stylesheet_directory_uri() . '/img/work-in-progress-.png" class="second-img-card-community" alt="">
                                                        </div>';
                                        break;
                                    case 'Podcast':
                                        $exposition = '<div class="img-block-course">
                                                            <img src="' . $thumbnail . '" class="second-img-card-community" alt="">
                                                        </div>
                                                        <div class="done-block">
                                                            <img src="' . get_stylesheet_directory_uri() . '/img/podcastIcone.png" class="second-img-card-community" alt="">
                                                        </div>';
                                        break; 
                                    case 'Leerpad':
                                        $exposition = '<div class="img-block-course">
                                                            <img src="' . $thumbnail . '" class="second-img-card-community" alt="">
                                                        </div>
                                                        <div class="done-block">
                                                            <img src="' . get_stylesheet_directory_uri() . '/img/leerpad-icon.png"" class="second-img-card-community" alt="">
                                                        </div>';
                                        break;
                                    case 'Video':
                                        $exposition = '<div class="img-block-course">
                                                            <img src="' . $thumbnail . '" class="second-img-card-community" alt="">
                                                        </div>
                                                        <div class="done-block">
                                                            <img src="' . get_stylesheet_directory_uri() . '/img/video-icon.png" class="second-img-card-community" alt="">
                                                        </div>';
                                        break;
                                    default :
                                        $exposition = '<div class="img-block-course">
                                                            <img src="' . $thumbnail . '" class="second-img-card-community" alt="">
                                                        </div>
                                                        <div class="done-block">
                                                            <img src="' . get_stylesheet_directory_uri() . '/img/sign.png" class="second-img-card-community" alt="">
                                                        </div>';
                                        break;
                                }
                                
                                //short-description
                                $short_description = get_field('short_description',  $course->ID);
                            ?>
                                <a href="<?php echo get_permalink($course->ID); ?>" class="card-course-community">
                                    <div class="position-relative">
                                    <?php 
                                        echo $exposition;
                                    ?>
                                    </div>
                                    <div class="content">
                                        <p class="tag-category"><?= $course_type; ?></p>
                                        <p class="title"><?= $course->post_title; ?></p>
                                        <p class="content-description"><?= $short_description; ?></p>
                                    </div>
                                </a>
                            <?php
                            }
                        else
                            echo $no_content;
                        ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="block-agenda">
                            <h3>Upcoming events</h3>
                            <?php
                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
                                if(!empty($events)){
                                foreach($events as $key => $course){
                                    if($key == 8)
                                        break;

                                    $price = get_field('price', $course->ID) ?: 'Free';
                                    $day = "00";
                                    $month = "00";
                                    $hours = "";
                                    $dates = get_field('dates', $course->ID);
                                    if($dates){
                                        $date = $dates[0]['date'];
                                        $days = explode(' ', $date)[0];
                                        $day = explode('-', $days)[2];
                                        $month = $calendar[explode('-', $date)[1]];
                                        $time = explode(' ', $date)[1];
                                        $hours = explode(':', $time)[0] . 'h' . explode(':', $time)[1];
                                    }
                                    $author_course = $course->post_author;
                                    $experts = array();
                                    $expert = get_field('experts', $course->ID);
                                    $authors = array($author_course);
                                    if(isset($expert[0]))
                                        $experts = array_merge($expert, $authors);
                                    else
                                        $experts = $authors;
                            ?>
                                <div class="card-agenda">
                                    <div class="first-block">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ionic-md-calendar.png" class="icone-agenda" alt="">
                                        <p class="price"><?= $price ?></p>
                                    </div>
                                    <div class="detail-description">
                                        <p class="date"><?php echo($day . ' ' . $month . ' - ' . $hours) ?> | <span>online</span></p>
                                        <p class="description"></p>
                                    </div>
                                    <div class="user-calendar-img">
                                        <div class="userBlock">
                                            <?php
                                                foreach ($experts as $key => $author){
                                                    if($key == 2)
                                                        break;
                                                    $portrait_image = get_field('profile_img',  'user_' . $author);
                                                    if (!$portrait_image)
                                                        $portrait_image = $company_image;
                                                    echo '<img src="' . $portrait_image . '"  alt="">';
                                                }
                                                $plus_user = 0;
                                                $max_user = count($experts);
                                                if($max_user > 2){
                                                    $plus_user = $max_user - 2;
                                                    echo '<div class="number">
                                                            <p>+' . $plus_user . '</p>
                                                          </div>';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                                }
                                else
                                    echo $no_content;
                            ?> 
                            <!-- <div class="footer-card-agenda">
                                <p>Bekijk alles</p>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php
}
else
    header("Location: /community-overview");
?>

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
