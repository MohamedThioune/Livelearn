<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<?php
global $wp;

$url = $wp->request;

$option_menu = explode('/', $url);

if(!isset($_GET['id']))
    $user = get_users(array('include'=> get_current_user_id()))[0]->data;

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
   $image = get_stylesheet_directory_uri() . '/img/placeholder_user.png';

$company = get_field('company',  'user_' . $user->ID);
$biographical_info = get_field('biographical_info',  'user_' . $user->ID);

if(!empty($company))
    $company_name = $company[0]->post_title;

/*
* * Get interests topics and experts
*/

$topics_internal = get_user_meta($user->ID,'topic_affiliate');
$topics_external = get_user_meta($user->ID,'topic');
$experts = get_user_meta($user->ID, 'expert');

$user_name_display = "";
if(isset($user->first_name))
    $user_name_display = $user->first_name;
else
    $user_name_display = $user->display_name;

/*
* * End
*/

/*
* * Get all experts
*/
$see_experts = get_users(
    array(
    'role__in' => ['author'],
    'posts_per_page' => -1,
    )
);

/*
* * End
*/

echo "<input type='hidden' id='user_id' value='" . $user->ID . "'>";

?>
<section id="sectionDashboard1" class="sidBarDashboard sidBarDashboardIndividual" name="section1"
style="overflow-x: hidden !important;">
    <button class="btn btn-close-sidbar">
        <i class="fa fa-close"></i>
    </button>
    <ul class="">
        <li class="elementTextDashboard">
            <a href="/dashboard/company/profile/" class="d-flex userdash">
                <div class="iconeElement"> <img src="<?php echo $image ?>" alt="profile photo"> </div>
                <?php
                if($option_menu[2] == 'profile') echo '<p class="textLiDashboard"><b>' . $user_name_display .  '</b></p>'; else echo  '<p class="textLiDashboard">' . $user_name_display .  '</p>';
                ?>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/user/" class="d-flex">
                <div class="iconeElement"><img src="<?php echo get_stylesheet_directory_uri();?>/img/dashb.png"></div>
                <?php
                if(!isset($option_menu[2])) echo '<p class="textLiDashboard"><b>Mijn dashboard</b></p>'; else echo  '<p class="textLiDashboard">Mijn dashboard</p>';
                ?>

            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/user/activity" class="d-flex">
                <div class="iconeElement"><img id="dashboard-min" src="<?php echo get_stylesheet_directory_uri();?>/img/dashboard-min.png"></div>
                <?php
                if($option_menu[2] == 'activity') echo '<p class="textLiDashboard"><b>Mijn Activiteiten</b></p>'; else echo  '<p class="textLiDashboard">Mijn Activiteiten</p>';
                ?>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/user/assessment" class="d-flex">
                <div class="iconeElement"><img class="iconAssesment1" src="<?php echo get_stylesheet_directory_uri();?>/img/assessment.png" alt=""></div>
                <?php
                if($option_menu[2] == 'assessment') echo '<p class="textLiDashboard"><b>Assessments</b></p>'; else echo  '<p class="textLiDashboard">Assessments</p>';
                ?>
                <!-- <p class="textLiDashboard">Assessments</p>
                <small class="comming-soon">&nbsp;Coming Soon</small> -->
            </a>
        </li>
        <li class="elementTextDashboard">
            <!-- /community-overview/ -->
            <a href="/dashboard/user/communities" class="d-flex">
                <div class="iconeElement"><img id="community-icon" src="<?php echo get_stylesheet_directory_uri();?>/img/community-icon.png"></div>
                <?php
                if($option_menu[2] == 'communities') echo '<p class="textLiDashboard"><b>Communities</b></p>'; else echo  '<p class="textLiDashboard">Communities</p>';
                ?>
            </a>
        </li>
        <div class="d-flex align-content-center">
            <p class="textOnder">ONDERWERPEN </p>
            <button type="button" class="btn btnVoegToe" data-toggle="modal" data-target="#exampleModal">
                <span>Voeg toe</span>
                <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
        </div>
        <li class="elementTextDashboard">
            <?php
            if(!empty($topics_external))
                foreach($topics_external as $topic){
                    if(!$topic || is_wp_error(!$topic))
                        continue;

                    $name = (String)get_the_category_by_ID($topic);
                    $image_category = get_field('image', 'category_'. $topic);
                    $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/iconOnderverpen.png';
                    echo "
                    <a href='/category-overview/?category=". $topic ."' class='d-flex'>
                        <div class='iconeElement'>
                            <img src='". $image_category ."' alt='image category'>
                        </div>  
                        <p class='textLiDashboard' style='margin-left:10px'>" . $name . "</p>
                    </a><br>";
                }

            if(!empty($topics_internal))
                foreach($topics_internal as $topic){
                    if(!$topic || is_wp_error(!$topic))
                        continue;

                    $name = (String)get_the_category_by_ID($topic);
                    $image_category = get_field('image', 'category_'. $topic);
                    $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/iconOnderverpen.png';
                    echo "<a href='/category-overview/?category=". $topic ."' class='d-flex'>;
                            <div class='iconeElement'>
                                <img src='". $image_category ."' alt='image category'>
                            </div>
                            <p class='textLiDashboard' style='margin-left:10px'>" . $name . "</p>
                          </a><br>";
                }
            ?>

        </li>
        <div class="d-flex align-content-center">
            <p class="textOnder">EXPERTS / OPLEIDERS</p>
            <button type="button" class="btn btnVoegToe" data-toggle="modal" data-target="#modalExpert">
              <span>Voeg toe</span>
                <i class="fa fa-plus" aria-hidden="true"></i>
            </button>
        </div>
        <li class="elementTextDashboard">
            <?php
            $read_experts = array();
            if(!empty($experts))
                foreach($experts as $expert){
                    if(!$expert)
                        continue;
                    
                    if(in_array($expert, $read_experts))
                        continue;

                    $image_author = get_field('profile_img',  'user_' . $expert);
                    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/iconeExpert.png';

                    $user_data_plus = get_user_by('id', $expert);
                        
                    $user_id = get_current_user_id();
                    if($expert != $user_id)
                        $name = ($user_data_plus->last_name) ? $user_data_plus->first_name : $user_data_plus->display_name;
                    else
                        $name = "Ikzelf";

                    if($user_data_plus->first_name == "")
                        continue;

                    echo "
                        <a href='/user-overview/?id=". $expert ."' class='d-flex'>
                            <div class='iconeElement'>
                                <img src='". $image_author ."' alt='image utilisateur'>
                            </div>
                            <p class='textLiDashboard' style='margin-left:10px'>" . $name . "</p>
                        </a><br>";

                    array_push($read_experts, $expert);
                }
            ?>
        </li>
    </ul>
</section>
<script>

    const itemsPerPage = 10;
    const blockList = document.querySelector('.content-expert');
    const blocks = blockList.querySelectorAll('.element-form-expert');
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
                scrollToStart(); // Scroll jusqu'au début du bloc de pagination
                displayPage(i);

                // Retire la classe .active de tous les boutons
                const buttons = document.querySelectorAll('.pagination-button');
                buttons.forEach((btn) => {
                    btn.classList.remove('active');
                });

                // Ajoute la classe .active au bouton cliqué
                button.classList.add('active');
            });
            paginationContainer.appendChild(button);

            // Ajoute la classe .active au premier bouton
            if (!firstButtonAdded) {
                button.classList.add('active');
                firstButtonAdded = true;
            }
        }
    }

    function scrollToStart() {
        const blockForPagination = document.querySelector('.content-expert');
        blockForPagination.scrollIntoView({ behavior: 'smooth' });
    }

    displayPage(1);
    createPaginationButtons();

</script>

