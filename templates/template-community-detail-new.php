<?php /** Template Name: community detail new */ ?>
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
//current user
$user_id = get_current_user_id();
$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$communities = get_posts($args);

$no_content =  '
                <p class="dePaterneText theme-card-description"> 
                <span style="color:#033256"> This community not found ! </span> 
                </p>
                ';
// $users = get_users();
// $authors = array();

$community = array();
if(isset($_GET['mu']))
    $community = get_post($_GET['mu']);

if(!empty($community)):
    echo $no_content;
    die();
endif;

$company = get_field('company_author', $community->ID);
$company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
$community_image = get_field('image_community', $community->ID) ?: $company_image;

// $level = get_field('range', $community->ID);
$private = get_field('password_community', $community->ID);

$type_groups = "";
$button_join = "<input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group'>";

//Since year
$date = $community->post_date;
$days = explode(' ', $date)[0];
$year = explode('-', $days)[0];

//Courses comin through custom field 
$courses = get_field('course_community', $community->ID); 
$max_course = 0;
if(!empty($courses))
    $max_course = count($courses);

//Followers
$max_follower = 0;
$followers = get_field('follower_community', $community->ID);
if(!empty($followers))
    $max_follower = count($followers);
$bool = false;
foreach ($followers as $key => $value)
    if($value->ID == $user_id){
        $bool = true;
        break;
    }

//Private community
$private_field = ($private) ? "<input type='text' class='form-control search' name='password' placeholder='Please fill community password !' required>" : ''; 
$type_groups = ($private_field == '') ? 'Public Groups' : 'Private Groups';

//Intern community
$company_user = get_field('company',  'user_' . $user_id);
$company_title_user = (!empty($company_user)) ? $company_user[0]->post_title : '';
$visibility_community = get_field('visibility_community', $community->ID); 
if($visibility_community){
    $type_groups = ($type_groups == 'Private Groups') ? 'Private|Intern Groups' : 'Intern Groups';
    if($company->post_title != $company_title_user)
        $button_join = "<button type='button' class='btn btn-join-group' name='follow_community' data-toggle='tooltip' data-placement='top' title='Intern community, only for member of the " . $company->post_title . " company' disabled>Join group</button>";
}
?>

<div class="content-community-overview bg-gray detail-community-section">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/company-logo.png" class="img-head-about" alt="">
                <h1 class="wordDeBestText2">Community</h1>
            </div>
    </section>
    <section class="section-detail-community">
        <div class="white-element-block"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="first-block-detail">
                        <div class="card-detail-community">
                            <div class="block-img">
                                <img src="<?= $community_image ?>" class="img-head-about" alt="">
                            </div>
                            <p class="name-group"><?= $community->post_title; ?></p>
                            <div class="d-flex">
                                <i class="fa fa-group"></i>
                                <p class="type-group"><?= $type_groups ?></p>
                            </div>
                            <p class="description-group"><?= $community->post_excerpt; ?></p>
                        </div>
                        <div class="cardOtherGroups">
                            <p class="others-group">Others Community</p>
                            <div class="block-others-group">
                                <?php
                                foreach($communities as $value):
                                    $company = get_field('company_author', $value->ID);
                                    $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                                    $community_image = get_field('image_community', $value->ID) ?: $company_image;
                        
                                    $type_groups = "";
                                    $button_join = "<input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group'>";
            
                                    //Since year
                                    $date = $community->post_date;
                                    $days = explode(' ', $date)[0];
                                    $year = explode('-', $days)[0];
                                ?>
                                <div class="oneGroup d-flex">
                                    <div class="block-img">
                                        <img src="<?= $community_image ?>" class="img-head-about" alt="">
                                    </div>
                                    <div>
                                        <p class="name-group"><?= $value->post_title ?></p>
                                        <p class="date-added">
                                            <!-- 2 years ago -->
                                            <?= $years ?>
                                        </p>
                                    </div>
                                </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="body--detail-community">
                        <div class="tabs-courses">
                            <div class="tabs">
                                <div class="head">
                                    <ul class="filters">
                                        <li class="item active"><i class="fa fa-tasks"></i><span>Activity</span></li>
                                        <li class="item position-relative"><i class="fa fa-group"></i><span>Members 30</span></li>
                                        <li class="item item-question position-relative"><i class="fa fa-calendar"></i><span>Event 15</span></li>
                                    </ul>
                                </div>
                                <div class="">
                                    <div class="tabs__list">
                                        <div class="tab tab-one active">
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
                                            </div>
                                            <div class="pagination-container">
                                                <!-- Les boutons de pagination seront ajoutés ici -->
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <div class="content-members d-flex flex-wrap">
                                                <div class="card-members">
                                                    <div class="block-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                    </div>
                                                    <p class="name">Cameron Williamson</p>
                                                    <p class="profession">UX UI Designer</p>
                                                </div>
                                                <div class="card-members">
                                                    <div class="block-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                    </div>
                                                    <p class="name">Cameron Williamson</p>
                                                    <p class="profession">UX UI Designer</p>
                                                </div>
                                                <div class="card-members">
                                                    <div class="block-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                    </div>
                                                    <p class="name">Cameron Williamson</p>
                                                    <p class="profession">UX UI Designer</p>
                                                </div>
                                                <div class="card-members">
                                                    <div class="block-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                    </div>
                                                    <p class="name">Cameron Williamson</p>
                                                    <p class="profession">UX UI Designer</p>
                                                </div>
                                                <div class="card-members">
                                                    <div class="block-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                    </div>
                                                    <p class="name">Cameron Williamson</p>
                                                    <p class="profession">UX UI Designer</p>
                                                </div>
                                                <div class="card-members">
                                                    <div class="block-img">
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                    </div>
                                                    <p class="name">Cameron Williamson</p>
                                                    <p class="profession">UX UI Designer</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <div class="d-flex flex-wrap">
                                                <div class="card-Upcoming">
                                                    <a href="">
                                                        <p class="title">Web design</p>
                                                        <div class="d-flex align-items-center">
                                                            <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                            <p class="date">January 31, 2023</p>
                                                            <hr>
                                                            <p class="time">10 AM - Online</p>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                            <div class="d-flex align-items-center">
                                                                <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                                <p class="nameAutor">Leslie Alexander</p>
                                                            </div>
                                                            <p class="price">Free</p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="card-Upcoming">
                                                    <a href="">
                                                        <p class="title">Web design</p>
                                                        <div class="d-flex align-items-center">
                                                            <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                            <p class="date">January 31, 2023</p>
                                                            <hr>
                                                            <p class="time">10 AM - Online</p>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                            <div class="d-flex align-items-center">
                                                                <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                                <p class="nameAutor">Leslie Alexander</p>
                                                            </div>
                                                            <p class="price">Free</p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="card-Upcoming">
                                                    <a href="">
                                                        <p class="title">Web design</p>
                                                        <div class="d-flex align-items-center">
                                                            <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                            <p class="date">January 31, 2023</p>
                                                            <hr>
                                                            <p class="time">10 AM - Online</p>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                            <div class="d-flex align-items-center">
                                                                <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                                <p class="nameAutor">Leslie Alexander</p>
                                                            </div>
                                                            <p class="price">Free</p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="card-Upcoming">
                                                    <a href="">
                                                        <p class="title">Web design</p>
                                                        <div class="d-flex align-items-center">
                                                            <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                            <p class="date">January 31, 2023</p>
                                                            <hr>
                                                            <p class="time">10 AM - Online</p>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                            <div class="d-flex align-items-center">
                                                                <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                                <p class="nameAutor">Leslie Alexander</p>
                                                            </div>
                                                            <p class="price">Free</p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="card-Upcoming">
                                                    <a href="">
                                                        <p class="title">Web design</p>
                                                        <div class="d-flex align-items-center">
                                                            <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                            <p class="date">January 31, 2023</p>
                                                            <hr>
                                                            <p class="time">10 AM - Online</p>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                            <div class="d-flex align-items-center">
                                                                <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                                <p class="nameAutor">Leslie Alexander</p>
                                                            </div>
                                                            <p class="price">Free</p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="card-Upcoming">
                                                    <a href="">
                                                        <p class="title">Web design</p>
                                                        <div class="d-flex align-items-center">
                                                            <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                            <p class="date">January 31, 2023</p>
                                                            <hr>
                                                            <p class="time">10 AM - Online</p>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                            <div class="d-flex align-items-center">
                                                                <img class="imgAutor" src="<?php echo get_stylesheet_directory_uri(); ?>/img/expert1.png" class="" alt="">
                                                                <p class="nameAutor">Leslie Alexander</p>
                                                            </div>
                                                            <p class="price">Free</p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
    const itemsPerPage = 6;
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

</body>
