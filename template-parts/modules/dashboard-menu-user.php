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
if(isset($user->first_name) && isset($user->last_name)) 
    $user_name_display = $user->first_name . '' . $user->last_name; 
else 
    $user_name_display = $user->display_name;

/*
* * End  
*/
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
                    $name = get_userdata($expert)->data->display_name;
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




<!-- Modal add topics and subtopics -->
<div class="modal fade modalAddTopicsAnd modal-topics-expert" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select your Topics and subtopics</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="content-topics">
                    <ul class="unstyled centered">
                        <li>
                            <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value1">
                            <label for="styled-checkbox-1">(Detail) Handel</label>
                        </li>
                        <li>
                            <input class="styled-checkbox" id="Handel" type="checkbox" value="Handel">
                            <label for="Handel">(Detail) Handel</label>
                        </li>
                        <li>
                            <input class="styled-checkbox" id="Groen" type="checkbox" value="Groen">
                            <label for="Groen">Agrarisch / Groen</label>
                        </li>
                        <li>
                            <input class="styled-checkbox" id="Bouw" type="checkbox" value="Bouw">
                            <label for="Bouw">Bouw</label>
                        </li>
                        <li>
                            <input class="styled-checkbox" id="Cultureel" type="checkbox" value="Cultureel">
                            <label for="Cultureel">Cultureel</label>
                        </li>
                        <li>
                            <input class="styled-checkbox" id="Human-resources" type="checkbox" value="Human-resources">
                            <label for="Human-resources">Human resources</label>
                        </li>
                        <li>
                            <input class="styled-checkbox" id="Informatie-management" type="checkbox" value="Informatie-management">
                            <label for="Informatie-management">Informatie management</label>
                        </li>
                    </ul>
                    <div class="mt-2">
                        <button type="button" class="btn btnNext">Next</button>
                    </div>
                </div>
                <div class="content-subTopics">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                      <ul>
                          <li class="selectAll">
                              <input class="styled-checkbox" id="all" type="checkbox" value="all">
                              <label for="all">Select All</label>
                          </li>
                      </ul>
                      <div class="position-relative">
                          <input type="search" placeholder="Search for your favorite Subtopics" class="searchSubTopics">
                          <img class="searchImg" src="<?php echo get_stylesheet_directory_uri();?>/img/searchM.png" alt="">
                      </div>
                  </div>
                  <div class="subtTopics-element">
                    <div class="d-flex align-items-center">
                        <div class="checkbox rows">
                            <input class="styled-checkbox" id="Audicien" type="checkbox" value="Audicien">
                            <label for="Audicien"></label>
                        </div>
                        <div class="img">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/detail-handel.jpeg" alt="">
                        </div>
                        <p class="subTitleText">Audicien</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="">See</a>
                        <button class="btn btnFollowSubTopic">Follow</button>
                    </div>
                  </div>
                  <div class="subtTopics-element">
                    <div class="d-flex align-items-center">
                        <div class="checkbox rows">
                            <input class="styled-checkbox" id="Bakker" type="checkbox" value="Bakker">
                            <label for="Bakker"></label>
                        </div>
                        <div class="img">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/detail-handel.jpeg" alt="">
                        </div>
                        <p class="subTitleText">Bakker</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="">See</a>
                        <button class="btn btnFollowSubTopic">Follow</button>
                    </div>
                  </div>
                  <div class="subtTopics-element">
                    <div class="d-flex align-items-center">
                        <div class="checkbox rows">
                            <input class="styled-checkbox" id="Bloemist" type="checkbox" value="Bloemist">
                            <label for="Bloemist"></label>
                        </div>
                        <div class="img">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/detail-handel.jpeg" alt="">
                        </div>
                        <p class="subTitleText">Bloemist</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="">See</a>
                        <button class="btn btnFollowSubTopic">Follow</button>
                    </div>
                  </div>
                  <div class="subtTopics-element">
                    <div class="d-flex align-items-center">
                        <div class="checkbox rows">
                            <input class="styled-checkbox" id="Caissiere" type="checkbox" value="Caissiere">
                            <label for="Caissiere"></label>
                        </div>
                        <div class="img">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/detail-handel.jpeg" alt="">
                        </div>
                        <p class="subTitleText">Caissiere</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="">See</a>
                        <button class="btn btnFollowSubTopic">Follow</button>
                    </div>
                  </div>
                    <div class="mt-3 mb-0">
                        <button type="button" id="backTopics" class="btn bg-dark btnNext mr-3 mb-0">Back</button>
                        <button type="button" class="btn btnNext mb-0" data-dismiss="modal">Save</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal add Expert -->
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