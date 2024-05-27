<?php /** Template Name: Community detail */ ?>
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
$no_content_follower =  '
                <p class="dePaterneText theme-card-description"> 
                <span style="color:#033256">No follower yet ! </span> 
                </p>
                ';
$no_content_event =  '
                <p class="dePaterneText theme-card-description"> 
                <span style="color:#033256">No coming event ! </span> 
                </p>
                ';
// $users = get_users();
// $authors = array();

$community = array();
if(isset($_GET['mu']))
    $community = get_post($_GET['mu']);

if(empty($community)):
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
                <h1 class="wordDeBestText2"><?= "Community | Detail"?></h1>
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
                                $i = 0;
                                foreach($communities as $value):
                                    if ($value->post_title == $community->post_title)
                                        continue;
                                    $company = get_field('company_author', $value->ID);
                                    $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                                                                                              $community_image = get_field('image_community', $value->ID) ?: $company_image;
                        
                                    $type_groups = "";
                                    $button_join = "<input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group'>";
            
                                    //Since year
                                    $date = $community->post_date;
                                    $days = explode(' ', $date)[0];
                                    $year = explode('-', $days)[0];
                                    $month = $month = date("M",strtotime($date));
                                    $day = explode('-', $days)[2];

                                    //Private community
                                    $private = get_field('password_community', $value->ID);
                                    $private_field = ($private) ? "<input type='text' class='form-control search' name='password' placeholder='Please fill community password !' required>" : ''; 
                                    $type_groups = ($private_field == '') ? 'Public Groups' : 'Private Groups';

                                    //Intern community
                                    $company_user = get_field('company',  'user_' . $user_id);
                                    $company_title_user = (!empty($company_user)) ? $company_user[0]->post_title : '';
                                    $visibility_community = get_field('visibility_community', $value->ID); 
                                    if($visibility_community)
                                        $type_groups = ($type_groups == 'Private Groups') ? 'Private|Intern Groups' : 'Intern Groups';

                                    if($type_groups == 'Private Groups' || $type_groups == 'Intern Groups' || $type_groups == 'Private|Intern Groups')
                                        continue;

                                    if($i >= 4)
                                        break;
                                    $i+=1;
                                ?>
                                <div class="oneGroup d-flex">
                                    <div class="block-img">
                                        <img src="<?= $community_image ?>" class="img-head-about" alt="">
                                    </div>
                                    <div>
                                        <p class="name-group"><?= $value->post_title ?></p>
                                        <p class="date-added">
                                            <!-- 2 years ago -->
                                            <span><?= $month . ' ' . $day . ', ' . $year; ?></span>
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
                                        <li class="item position-relative"><i class="fa fa-group"></i><span>Members</span></li>
                                        <li class="item item-question position-relative"><i class="fa fa-calendar"></i><span>Events</span></li>
                                    </ul>
                                </div>
                                <div class="">
                                    <div class="tabs__list">
                                        <div class="tab tab-one active">
                                            <?php
                                            $events = array();
                                            if(!empty($courses)):
                                            ?>
                                            <div class="block-new-card-course grid" id="autocomplete_recommendation">
                                                <?php
                                                foreach($courses as $course):
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

                                                // price
                                                $price_noformat = get_field('price', $course->ID) ?: 'Gratis';
                                                if($price_noformat != "Gratis")
                                                    $price = '€' . number_format($price_noformat, 2, '.', ',');
                                                else
                                                    $price = 'Gratis';

                                                //Category
                                                $category = null;
                                                $category_id = 0;
                                                $id_category = 0;
                                                $category_id = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                                                $category_xml = intval(get_field('category_xml', $course->ID)[0]['value']);
                                                if($category_xml)
                                                    if($category_xml != 0){
                                                        $id_category = $category_xml;
                                                        $category = (String)get_the_category_by_ID($category_xml);
                                                    }
                                                if($category_id)
                                                    if($category_id != 0){
                                                        $id_category = $category_id;
                                                        $category = (String)get_the_category_by_ID($category_id);
                                                    }

                                                // author
                                                $author = get_user_by('id', $course->post_author);
                                                $author_name = ($author->last_name) ? $author->first_name . ' ' . $author->last_name : $author->display_name; 
                                                $author_image = get_field('profile_img',  'user_' . $course->post_author);
                                                $author_image = $author_image ? $author_image : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                                
                                                // link
                                                $link = get_permalink($course->ID);
                                                
                                                ?>
                                                <a href="<?= $link ?>" class="new-card-course visible">
                                                    <div class="content-course-block">
                                                        <div class="head">
                                                            <img src="<?= $thumbnail ?>" alt="">
                                                        </div>
                                                        <div class="details-card-course">
                                                            <div class="title-favorite d-flex justify-content-between align-items-center">
                                                                <p class="title-course"><?= $course->post_title ?></p>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                                                <div class="blockOpein d-flex align-items-center">
                                                                    <i class="fas fa-graduation-cap"></i>
                                                                    <p class="lieuAm"><?= $course_type ?></p>
                                                                </div>
                                                                <div class="blockOpein">
                                                                    <?= 
                                                                        $category ? '<i class="fas fa-map-marker-alt"></i>
                                                                                    <p class="lieuAm">' . $category . '</p>' : '' 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="autor-price-block d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="blockImgUser">
                                                                        <img src="<?= $author_image ?>" alt="">
                                                                    </div>
                                                                    <p class="autor"><?= $author_name ?></p>
                                                                </div>
                                                                <p class="price"><?= $price ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                                <?php
                                                endforeach;
                                                ?>
                                            </div>
                                            <?php
                                            endif;
                                            ?>
                                            <div class="pagination-container">
                                                <!-- Les boutons de pagination seront ajoutés ici -->
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <div class="content-members d-flex flex-wrap">
                                                <?php
                                                    // Get followers from company
                                                    if(!empty($followers))
                                                        foreach ($followers as $key => $value) {
                                                            // $follower = get_user_by('ID', $value);
                                                            $follower_name = ($value->last_name) ? $value->first_name . ' ' . $value->last_name : $value->display_name; 
                                                            $follower_role = get_field('role',  'user_' . $value->ID) ?: "Free agent";
                                                            if($key == 4)
                                                                break;
                                                            $portrait_image = get_field('profile_img',  'user_' . $value->ID);
                                                            if (!$portrait_image)
                                                                $portrait_image = $company_image;
                                                            echo '<div class="card-members">
                                                                        <div class="block-img">
                                                                            <img src="' . $portrait_image . '" class="" alt="">
                                                                        </div>
                                                                        <p class="name">' . $follower_name . '</p>
                                                                        <p class="profession">' . $follower_role . '</p>
                                                                   </div>';
                                                        }
                                                    else
                                                        echo $no_content_follower;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <div class="d-flex flex-wrap">
                                                <?php
                                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
                                                if(!empty($events)):
                                                foreach($events as $key => $course):
                                                    if($key == 8)
                                                        break;

                                                    $price = get_field('price', $course->ID) ?: 'Free';

                                                    $day = "00";
                                                    $month = "00";
                                                    $year = "0000";                                                    
                                                    $hours = "";
                                                    $dates = get_field('dates', $course->ID);
                                                    if($dates){
                                                        $date = $dates[0]['date'];
                                                        $days = explode(' ', $date)[0];
                                                        $day = explode('-', $days)[2];
                                                        $year = explode('-', $days)[0];
                                                        $month = $calendar[explode('-', $date)[1]];
                                                        $time = explode(' ', $date)[1];
                                                        $hours = explode(':', $time)[0] . 'h' . explode(':', $time)[1];
                                                    }

                                                    // author
                                                    $author = get_user_by('ID', $course->post_author);
                                                    $author_name = ($author->last_name) ? $author->first_name . ' ' . $author->last_name : $author->display_name; 
                                                    $portrait_image = get_field('profile_img',  'user_' . $author->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                                    
                                                    // link
                                                    $link = get_permalink($course->ID);
                                                    
                                                ?>
                                                    <div class="card-Upcoming">
                                                        <a href="<?= $link ?>">
                                                            <p class="title"><?= $course->post_title ?></p>
                                                            <div class="d-flex align-items-center">
                                                                <img class="calendarImg" src="<?php echo get_stylesheet_directory_uri();?>/img/bi_calendar-event-fill.png" alt="">
                                                                <p class="date">
                                                                    <!-- January 31, 2023 -->
                                                                    <?= $month . ' ' . $day . ',  ' . $year ?>
                                                                </p>
                                                                <hr>
                                                                <p class="time"><?= $hours ?> - Online</p>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between footer-card-upcoming">
                                                                <div class="d-flex align-items-center">
                                                                    <img class="imgAutor" src="<?= $portrait_image ?>" class="" alt="">
                                                                    <p class="nameAutor"><?= $author_name ?></p>
                                                                </div>
                                                                <p class="price"><?= $price ?></p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php
                                                    endforeach;
                                                else:
                                                    echo $no_content_event;
                                                endif;
                                                ?>
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
