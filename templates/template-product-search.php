
<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/product-search.png" class="img-head-about border-0" alt="">
                <h1 class="wordDeBestText2">Product Search</h1>
            </div>
        </div>
    </section>
    <section class="content-product-search">
        <div class="theme-content">
            <div class="theme-side-menu">
                <div class="block-filter">
                    <button class="btn btn-close-filter">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Close.png" class="img-head-about" alt="">
                    </button>
                    <p class="text-filter-course">Filter | Courses </p>
                    

                </div>
            </div>
            <div class="theme-learning">
                <div class="">
                    <div class="btn-group-layouts">
                        <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
                        <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
                    </div>
                    <div class="block-filter-mobile">
                        <button class="content-filter d-flex ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/filter.png" alt="">
                            <span>Filter</span>
                        </button>
                    </div>


                    <div class="block-new-card-course grid" id="autocomplete_recommendation">
                        <?php
                        $user_id = get_current_user_id();
                        $company_visibility = get_field('company',  'user_' . $user_id);
                        $visibility_company = (!empty($company_visibility)) ? $company_visibility[0]->post_title : null;
                        
                        $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
                        foreach($courses as $post):
                        
                        if(!$post)
                            continue;
                        

                        $hidden = true;
                        $hidden = visibility($post, $visibility_company);
                        if(!$hidden)
                            continue;

                        /* Displaying information */

                        //Tags information
                        $category = " ";
                        $category_id = 0;
                        $id_category = 0;
                        if($tag == ' '){
                            $category_id = intval(explode(',', get_field('categories',  $post->ID)[0]['value'])[0]);
                            $category_xml = intval(get_field('category_xml', $post->ID)[0]['value']);
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
                        }

                        $course_type = get_field('course_type', $post->ID);
                        //Image information
                        $thumbnail = get_field('preview', $post->ID)['url'];
                        if(!$thumbnail){
                            $thumbnail = get_the_post_thumbnail_url($post->ID);
                            if(!$thumbnail)
                                $thumbnail = get_field('url_image_xml', $post->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                        }

                        //Author information
                        $author = get_user_by('ID', $post->post_author);
                        $name_author = ($author) ? $author->display_name : 'None';
                        $user_id = get_current_user_id();
                        if($author->ID != $user_id)
                            $name = ($author->last_name) ? $author->first_name : $author->display_name;
                        else
                            $name = "Ikzelf";
                       
                        $image_author = get_field('profile_img',  'user_' . $post->post_author);
                        if(!$image_author)
                            $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";

                        //Date and Location
                        $offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
                        $data = null;
                        $count_data = 0;
                        $data_locaties = get_field('data_locaties', $post->ID);
                        $data_locaties_xml = get_field('data_locaties_xml', $post->ID);
                        $location = 'Online';
                        if(!empty($data_locaties)):
                            $count_data = count($data_locaties) - 1;
                            $data = $data_locaties[$count_data]['data'][0]['start_date'];
                            $location = $data_locaties[0]['data'][0]['location'];
                        elseif(!empty($data_locaties_xml)):
                            $count_data = count($data_locaties_xml) - 1;
                            if($data_locaties_xml):
                                if(isset($data_locaties_xml[0]['value']))
                                    $element = $data_locaties_xml[intval($count_data)]['value'];
                                if(isset($data_locaties_xml[0]['value'])){
                                    $data_first = explode('-', $datum[0]['value']);
                                    $location = $data_first[2];
                                }
                            endif;

                            if(!isset($element))
                                continue;

                            $datas = explode('-', $element);
                            $data = $datas[0];
                        endif;

                        if( empty($data) || !in_array($course_type, $offline) )
                            null;
                        elseif( !empty($data) )
                            if($data){
                                $date_now = strtotime(date('Y-m-d'));
                                $data = strtotime(str_replace('/', '.', $data));
                                if($data < $date_now)
                                    continue;
                            }
                        
                        //Price information
                        $price_noformat = get_field('price', $post->ID) ?: 'Gratis';
                        if($price_noformat != "Gratis")
                            $price = '€' . number_format($price_noformat, 2, '.', ',');
                        else
                            $price = 'Gratis';
                        
                        //Link 
                        $link = get_permalink($post->ID);

                        /* End Displaying */

                        ?>

                        <a href="<?= $link ?>" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?= $thumbnail ?>" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course"><?= $post->post_title ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm"><?= $course_type ?></p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm"><?= $location ?></p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?= $image_author ?>" alt="">
                                            </div>
                                            <p class="autor"><?= $name_author ?></p>
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
                    <div class="pagination-container">
                        <!-- Les boutons de pagination seront ajoutés ici -->
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
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!--script pagination-->

<script>
    const itemsPerPage = 30;
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

<script>
    $(".content-filter").click(function() {
        $(".theme-side-menu").show();
    });
    $(".btn-close-filter").click(function() {
        $(".theme-side-menu").hide();
    });
</script>

</body>
