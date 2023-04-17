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
                <!-- <small class="comming-soon">&nbsp;&nbsp; <b>Coming Soon</b> </small> -->
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
                            foreach($topics as $key => $topic){
                                if(!$topic || is_wp_error(!$topic))
                                    continue;
                                
                                echo '<li>
                                        <input class="styled-checkbox topics" id="styled-checkbox-'. $key .'" type="checkbox" value="' . $topic->cat_ID . '">
                                        <label for="styled-checkbox-'. $key .'">' . $topic->cat_name . '</label>
                                      </li>';
                            }
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

