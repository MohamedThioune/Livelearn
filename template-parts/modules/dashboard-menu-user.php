<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<?php

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

/*
* * End  
*/
?>
<section id="sectionDashboard1" class="sidBarDashboard sidBarDashboardIndividual" name="section1">
    <button class="btn btnSidbarMobCroix">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/cancel.png" alt="">
    </button>
    <ul class="">
        <li class="elementTextDashboard">
            <a href="/dashboard/company/profile/" class="d-flex userdash">
                <div class="iconeElement"> <img src="<?php echo $image ?>" alt="profile photo"> </div>
                <p class="textLiDashboard"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name; ?></p>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/user/" class="d-flex">
                <div class="iconeElement"><img src="<?php echo get_stylesheet_directory_uri();?>/img/dashb.png"></div>
                <p class="textLiDashboard">Mijn dashboard</p>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/user/activity" class="d-flex">
                <div class="iconeElement"><img src="<?php echo get_stylesheet_directory_uri();?>/img/Statistieken.png"></div>
                <p class="textLiDashboard">Mijn Activiteiten</p>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/user/assessment" class="d-flex">
                <div class="iconeElement"><img class="iconAssesment1" src="<?php echo get_stylesheet_directory_uri();?>/img/assessment.png" alt=""></div>
                <p class="textLiDashboard">Assessments</p>
            </a>
        </li>
        <p class="textOnder">ONDERWERPEN</p>
        <li class="elementTextDashboard">
            <?php
           
            if(!empty($topics_external))
                foreach($topics_external as $topic){
                    $name = (String)get_the_category_by_ID($topic);
                    $image_category = get_field('image', 'category_'. $topic);
                    $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';
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
                    $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';
                    echo "<a href='/category-overview/?category=". $topic ."' class='d-flex'>;
                            <div class='iconeElement'>
                                <img src='". $image_category ."' alt='image category'>
                            </div>
                            <p class='textLiDashboard' style='margin-left:10px'>" . $name . "</p>
                          </a><br>";
                    /* echo "
                    <a href='/category-overview/?category=". $topic ."' class='d-flex'>
                        <div class='iconeElement'>
                            <form action='/dashboard/user/' method='POST'>
                                <input type='hidden' name='meta_value' value='". $topic . "' id=''>
                                <input type='hidden' name='user_id' value='". $user->ID . "' id=''>
                                <input type='hidden' name='meta_key' value='topic_affiliate' id=''>
                                <button type='submit' class='btn toevoegenText' name='delete'><i class='fa fa-trash'></i></button>
                            </form> 
                        </div>
                        <br><br>
                        <p class='textLiDashboard' style='margin-left:10px'>" . $name . "</p>
                    </a>
                    "; */
                }
            ?>
            <a href="/onderwer"class="btn btnOnderwerp" id="ajoutSujet"><div><i class="fa fa-plus faPLusModife"></i></div> <span>Onderwerp toevoegen</span>
                <img class="iconAssesment" src="<?php echo get_stylesheet_directory_uri();?>/img/ajouterSujet.png" alt="">
            </a>

        </li>
        <p class="textOnder">EXPERTS / OPLEIDERS</p>
        <li class="elementTextDashboard">    
            <?php
            
            if(!empty($experts))
                foreach($experts as $expert){
                    $name = get_userdata($expert)->data->display_name;
                    $image_author = get_field('profile_img',  'user_' . $expert);
                    $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                    echo "
                    <a href='/user-overview/?id=". $expert ."' class='d-flex'>
                        <div class='iconeElement'>
                            <img src='". $image_author ."' alt='image utilisateur'>
                        </div>
                        <p class='textLiDashboard' style='margin-left:10px'>" . $name . "</p>
                    </a><br>";
                     /*  
                     <div class='iconeElement'>
                        <form action='../../dashboard/user/' method='POST'>
                            <input type='hidden' name='meta_value' value='". $expert . "' id=''>
                            <input type='hidden' name='user_id' value='". $user->ID . "' id=''>
                            <input type='hidden' name='meta_key' value='expert' id=''>
                            <button type='submit' class='btn toevoegenText' name='delete'><i class='fa fa-trash'></i></button>
                        </form> 
                    </div> */
                }
            ?>
            <a href="/opleiders" class="btn btnOnderwerp"><div><i class="fa fa-plus faPLusModife"></i></div> <span>Expert toevoegen</span>
                <img id="acustomer" class="iconAssesment" src="<?php echo get_stylesheet_directory_uri();?>/img/acustomer.png" alt="">
            </a>
        </li>
    </ul>
</section>
