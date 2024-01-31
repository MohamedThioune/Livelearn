<?php /** Template Name: Company all */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<?php
//$page = 'check_visibility.php';
//require($page);

$company_experts = ['' => ''];
// Users should
$users = get_users();

foreach ($users as $user):
    $company_partial = get_field('company',  'user_' . $user->ID);
    if(!empty($company_partial)):
        $company_partie = $company_partial[0]->post_title;
        $company_experts[$company_partie] .= $user->ID . ',';
    endif;
endforeach;
// var_dump($company_experts);
// die();

// Companies should
$args = array(
    'post_type' => 'company', 
    'post_status' => 'publish',
    'order' => 'ASC',
    'posts_per_page' => -1,
);
$companies = get_posts($args);

?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/all-company.png" class=" border-0 img-head-about" alt="">
                <h1 class="wordDeBestText2">Company</h1>
             </div>
    </section>
    <section class="section-all-topic">
        <div class="container-fluid">
            <!-- <div class="head-section-all-tpocis d-flex justify-content-between">
                <h2>Discover our topics and sub-topics and enrich your knowledge!</h2>
                <form action="" class="d-flex align-items-center form-search-course-filter mb-0">
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
                </form>
            </div> -->
            <div class="content-all-company d-flex flex-wrap">
                <?php
                foreach($companies as $company): 
                    $name = $company->post_title;
                    $logo = get_field('company_logo', $company->ID) ?: get_stylesheet_directory_uri(). '/img/company.png';
                    
                    //Experts
                    $str_experts = isset($company_experts[$name]) ? $company_experts[$name] : '';
                    $experts = explode(',', $str_experts);
                    $count_experts = (isset($experts[0])) ? count($experts) : 0;
                    
                    //Date
                    $date = $company->post_date;
                    $days = explode(' ', $date)[0];
                    $year = explode('-', $days)[0];

                    //Courses
                    $count_courses = 0;
                    if(isset($experts[0])):
                        $args = array(
                            'post_type' => array('post','course'),
                            'posts_per_page' => -1,
                            'orderby' => 'date',
                            'order'   => 'DESC',
                            'author__in' => $experts,
                        );
                        $courses = get_posts($args);
                        $count_courses = (isset($courses[0])) ? count($courses) : 0;
                    endif;
                ?>
                <a href="/opleider-courses?companie=<?= $company->ID ?>" class="card-all-company">
                    <div class="d-flex">
                        <div class="block-img">
                            <img src="<?= $logo ?>" class=" border-0 img-head-about" alt="">
                        </div>
                        <div>
                            <p class="name-company"><?= $name ?></p>
                            <p class="date-added">Since : <?= $year ?></p>
                            <div class="d-flex justify-content-between">
                                <p class="number-course"><?= !$count_courses ?: $count_courses - 1 ?> Courses</p>
                                <p class="number-expert"><?= $count_experts ?> Experts</p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
                endforeach;
                ?>
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



<!--script pagination-->

<script>
    const itemsPerPage = 15;
    const blockList = document.querySelector('.content-all-company');
    const blocks = blockList.querySelectorAll('.card-all-company');
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
