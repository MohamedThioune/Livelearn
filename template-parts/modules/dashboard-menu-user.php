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
        <p class="textOnder">ONDERWERPEN <span> <a href="/onderwer"> Voeg toe </a></span></p>
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
        <p class="textOnder">EXPERTS / OPLEIDERS <span> <a href="/opleiders"> Voeg toe </a></span></p>

        <li class="elementTextDashboard">    
            <?php
            
            if(!empty($experts))
                foreach($experts as $expert){
                    if(!$expert)
                        continue;
                        
                    $name = get_userdata($expert)->data->display_name ?: get_userdata($expert)->data->first_name;
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
