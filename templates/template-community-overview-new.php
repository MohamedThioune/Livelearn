<?php /** Template Name: Community overview */ ?>

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
$user_id = get_current_user_id();
// $users = get_users();
$args = array(
    'post_type' => 'community',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1
);
$communities = get_posts($args);

// $your_communities = array();
// $other_communities = array();
?>

<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/company-logo.png" class="img-head-about" alt="">
                <h1 class="wordDeBestText2">Community</h1>
                <!-- 
                <button class="btn btn-follown" type="button">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/follow-icon.svg" class="img-follown" alt="">
                    Follow
                </button> -->
            </div>
    </section>
    <section class="section-all community">
        <div class="container-fluid">
            <!-- 
            <form action="" class="d-flex align-items-center justify-content-between form-search-course-filter mb-0">
                <div class="form-group position-relative mb-0">
                    <i class="fa fa-search"></i>
                    <input type="search" placeholder="Search" class="search-course">
                </div>
                <div class="custom-select-course position-relative">
                    <select class="form-select">
                        <option selected>Filter</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <span class="filter-icon">
                    <i class="fa fa-filter"></i>
                </span>
                </div>
            </form> -->
            <div class="block-all-community">
                <div class="row">
                    <?php
                    foreach($communities as $community):
                        $company = get_field('company_author', $community->ID);
                        $company_image = (get_field('company_logo', $company->ID)) ? get_field('company_logo', $company->ID) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';
                        $community_image = get_field('image_community', $community->ID) ?: $company_image;

                        // $level = get_field('range', $community->ID);
                        $private  = get_field('password_community', $community->ID);

                        $type_groups = "";
                        // $button_join = "<input type='submit' class='btn btn-join-group' name='follow_community' value='Join Group'>";

                        //Since year
                        $date = $community->post_date;
                        $days = explode(' ', $date)[0];
                        $year = explode('-', $days)[0];
                        $month = date("M",strtotime($date));
                        $day = explode('-', $days)[2];

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
                        if($visibility_community)
                            $type_groups = ($type_groups == 'Private Groups') ? 'Private|Intern Groups' : 'Intern Groups';

                        if($type_groups == 'Private Groups' || $type_groups == 'Intern Groups' || $type_groups == 'Private|Intern Groups')
                            continue;
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card-community">
                            <div class="block-img">
                                <img src="<?= $community_image; ?>" class="" alt="">
                            </div>
                            <p class="name-community"><?= $community->post_title; ?></p>
                            <div class="d-flex align-items-center mb-4">
                                <div class="d-flex align-items-center">
                                    <?php
                                        if(!empty($followers))
                                        foreach($followers as $key => $value) {
                                            if($key == 4)
                                                break;
                                            $portrait_image = get_field('profile_img',  'user_' . $value->ID);
                                            if (!$portrait_image)
                                                $portrait_image = $company_image;
                                            echo 
                                                '<div class="img-members">
                                                    <img src="' . $portrait_image . '" class="" alt="">
                                                </div>';
                                        }
                                    ?>
                                </div>
                                <p class="numbers-members">
                                    <?php
                                        $plus_user = 0;
                                        $max_user = 0;
                                        if(!empty($followers))
                                            $max_user = count($followers);
                                        if($max_user > 4){
                                            $plus_user = $max_user - 4;
                                            echo '+' . $plus_user . ' Members';
                                        }
                                    ?>
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="date-added">Since 
                                    <!-- <span>April 16, 2022</span> -->
                                    <span><?= $month . ' ' . $day . ', ' . $year; ?></span>
                                </p>
                                <a href="/community-detail/?mu=<?= $community->ID ?>" class="btn btn-discover">Discover</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    endforeach;
                    ?>
                </div>
                <div class="pagination-container">
                    <!-- Les boutons de pagination seront ajoutés ici -->
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
    const itemsPerPage = 6;
    const blockList = document.querySelector('.row');
    const blocks = blockList.querySelectorAll('.col-lg-4');
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
