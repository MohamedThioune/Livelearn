<?php /** Template Name: Main category overview */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php
    $main_category = $_GET['main'] ?: null;
    $main_category = intval($main_category);
    if (!$main_category)
        header('Location: /');
    
    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }
    $categories[4] = $categories[0];

    $id_main_category = $categories[$main_category];
    // var_dump($id_main_category);
    // die();

    $topics = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $id_main_category,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $name_main_category = get_the_category_by_ID($id_main_category);
    if(is_wp_error($name_main_category))
        header('Location: /');

    $name_main_category = (String)$name_main_category;
?>

<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/topic-icon.svg" class=" border-0 img-head-about" alt="">
                <h1 class="wordDeBestText2"><?= $name_main_category ?></h1>
             </div>
    </section>
    <section class="section-all-topic">
        <div class="container-fluid">
            <!-- 
            <div class="head-section-all-tpocis d-flex justify-content-between">
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
            </div> 
            -->
            <?php
            if(!empty($topics)):
                echo 
                '<div class="content-card-topics">';
                    foreach($topics as $key => $topic):
                        $childtopics = get_categories( array(
                            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                            'parent'  => $topic->cat_ID,
                            'hide_empty' => 0, // change to 1 to hide categores not having a single post
                        ) ); 
                        $image_category = get_field('image', 'category_'. $topic->cat_ID);
                        $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';
                
                        ?>
                        <div class="card-topics new-card-topics d-flex">
                            <div class="block-img">
                                <img src="<?= $image_category ?>" class="img-head-about" alt="">
                            </div>
                            <div>
                                <div class="d-flex justify-content-between ">
                                    <a href="/sub-topic/?subtopic=<?= $topic->cat_ID?>" class="title-topics"><?= $topic->cat_name ?></a>
                                    <!-- <a href="">See All</a> -->
                                </div><br>
                                <?php
                                if(!empty($childtopics)):
                                    echo 
                                    '<ul class="d-flex flex-wrap">';
                                        foreach($childtopics as $childtopic)
                                            echo '<li> <a href="/category-overview/?category=' . $childtopic->cat_ID . '" style="color:grey" >' . $childtopic->cat_name . '</a> </li>';
                                    echo 
                                    '</ul>';
                                endif
                                ?>
                            </div>
                        </div>
                    <?php
                    endforeach;
                echo 
                '</div>';
            endif;
            ?>
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
    const itemsPerPage = 4;
    const blockList = document.querySelector('.content-card-topics');
    const blocks = blockList.querySelectorAll('.card-topics');
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
