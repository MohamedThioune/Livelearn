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
    $company = $company[0]->post_title;

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

echo "<input type='hidden' id='user_id' value='" . $user->ID . "'>";

?>
<section id="sectionDashboard1" class="sidBarDashboard sidBarDashboardIndividual" name="section1"
style="overflow-x: hidden !important;">
    <button class="btn btnSidbarMobCroix">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/cancel.png" alt="">
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
                <div class="iconeElement"><img src="<?php echo get_stylesheet_directory_uri();?>/img/Statistieken.png"></div>
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
            </a>
        </li>
        <div class="d-flex align-content-center">
            <p class="textOnder">ONDERWERPEN </p>
            <button type="button" class="btn btnVoegToe" data-toggle="modal" data-target="#exampleModal">
                Voeg toe
            </button>
        </div>
        <li class="elementTextDashboard">
            <?php
            if(!empty($topics_external))
                foreach($topics_external as $topic){
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
                Voeg toe
            </button>
        </div>
        <li class="elementTextDashboard">    
            <?php
            
            if(!empty($experts))
                foreach($experts as $expert){
                    if(!$expert)
                        continue;
                        
                    $name = get_userdata($expert)->data->display_name ?: get_userdata($expert)->data->first_name;
                    if(!$name)
                        continue;
                    $image_author = get_field('profile_img',  'user_' . $expert);
                    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/iconeExpert.png';
                    echo "
                        <a href='/user-overview/?id=". $expert ."' class='d-flex'>
                            <div class='iconeElement'>
                                <img src='". $image_author ."' alt='image utilisateur'>
                            </div>
                            <p class='textLiDashboard' style='margin-left:10px'>" . $name . "</p>
                        </a><br>";
                    
                }
            ?>
        </li>
    </ul>
</section>



<?php
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

    //Topics
    $topics = array();
    foreach ($categories as $value){
        $merged = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $value,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ) );

        if(!empty($merged))
            $topics = array_merge($topics, $merged); 
    }
?>
<!-- Modal add topics and subtopics -->
<div class="modal fade modalAddTopicsAnd modal-topics-expert" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Maak en keuze :</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="content-topics">
                    <ul class="unstyled centered">
                        <?php
                            foreach($topics as $key => $topic)
                                echo '<li>
                                        <input class="styled-checkbox topics" id="styled-checkbox-'. $key .'" type="checkbox" value="' . $topic->cat_ID . '">
                                        <label for="styled-checkbox-'. $key .'">' . $topic->cat_name . '</label>
                                      </li>';
                        ?>
                    </ul>
                    <div class="mt-2">
                        <button type="button" id="btn-topics" class="btn btnNext">Next</button>
                    </div>
                </div>
                <div class="content-subTopics">
                    <form action="" method="post" id="autocomplete_tags">
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal add Expert 
<div class="modal fade modalAddExpert modal-topics-expert" id="modalExpert" tabindex="-1" role="dialog" aria-labelledby="modalExpertLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select your Experts / Opleiders</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="head">
                    <ul>
                        <li class="selectAll">
                            <input class="styled-checkbox" id="allExpert" type="checkbox" value="allExpert">
                            <label for="allExpert">Select All</label>
                        </li>
                    </ul>
                    <div class="blockFilter">
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Filter by category</option>
                            <option value="1">Trending</option>
                            <option value="2">Companies</option>
                            <option value="3">Construction</option>
                            <option value="3">HR</option>
                            <option value="3">Food</option>
                        </select>
                    </div>
                    <div class="blockSearch position-relative">
                        <input type="search" placeholder="Search your expert" class="searchSubTopics">
                        <img class="searchImg" src="<?php echo get_stylesheet_directory_uri();?>/img/searchM.png" alt="">
                    </div>
                </div>
                <div class="content-expert">
                    <div class="expert-element rows2">
                        <div class="d-flex align-items-center">
                            <div class="checkB">
                                <input class="styled-checkbox" id="Crypto-university" type="checkbox" value="Crypto university">
                                <label for="Crypto-university"></label>
                            </div>
                            <div class="img">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Crypto-university.png" alt="">
                            </div>
                            <p class="subTitleText nameExpert">Crypto university</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="">See</a>
                            <button class="btn btnFollowSubTopic">Follow</button>
                        </div>
                    </div>
                    <div class="expert-element">
                        <div class="d-flex align-items-center">
                            <div class="checkbox rows2">
                                <input class="styled-checkbox" id="Autoblog" type="checkbox" value="Autoblog">
                                <label for="Autoblog"></label>
                            </div>
                            <div class="img">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Autoblog.jpeg" alt="">
                            </div>
                            <p class="subTitleText nameExpert">Autoblog</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="">See</a>
                            <button class="btn btnFollowSubTopic">Follow</button>
                        </div>
                    </div>
                    <div class="expert-element">
                        <div class="d-flex align-items-center">
                            <div class="checkbox rows2">
                                <input class="styled-checkbox" id="Co-pilot" type="checkbox" value="Co-pilot">
                                <label for="Co-pilot"></label>
                            </div>
                            <div class="img">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Co-pilot.jpeg" alt="">
                            </div>
                            <p class="subTitleText nameExpert">Co-pilot</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="">See</a>
                            <button class="btn btnFollowSubTopic">Follow</button>
                        </div>
                    </div>
                    <div class="expert-element rows">
                        <div class="d-flex align-items-center">
                            <div class="checkbox rows2">
                                <input class="styled-checkbox" id="Sweco" type="checkbox" value="Sweco">
                                <label for="Sweco"></label>
                            </div>
                            <div class="img">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Sweco.jpeg" alt="">
                            </div>
                            <p class="subTitleText nameExpert">Sweco</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="">See</a>
                            <button class="btn btnFollowSubTopic">Follow</button>
                        </div>
                    </div>
                    <div class="expert-element">
                        <div class="d-flex align-items-center">
                            <div class="checkbox rows2">
                                <input class="styled-checkbox" id="Reworc" type="checkbox" value="Reworc">
                                <label for="Reworc"></label>
                            </div>
                            <div class="img">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Reworc.jpeg" alt="">
                            </div>
                            <p class="subTitleText nameExpert">Reworc</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="">See</a>
                            <button class="btn btnFollowSubTopic">Follow</button>
                        </div>
                    </div>
                    <div class="mt-3 mb-0">
                        <button type="button" class="btn btnNext mb-0" data-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
-->
