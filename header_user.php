<?php
$user = wp_get_current_user();

/*
* * Get feedbacks
*/
$todos = get_field('todos',  'user_' . $user->ID);

?><!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="Fluidify">
        <meta name='keywords' content="fluidify">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css'>


        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body class="header-user canhas">
        <nav class="navbar navbar-expand-lg navbar-dark headerdashboard">
            <div class="container-fluid">
                <div class="elementMobile groupBtnMobile">
                    <div class="nav-item item4 dropdown">
                        <a href="#" class="nav-link navModife4 btn dropdown-toggle " type="button" id="dropdownNavButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="imgArrowDropDown" src="<?php echo get_stylesheet_directory_uri();?>/img/three-stars.png" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-dashboard" aria-labelledby="dropdownMenuButton1">
                            <a class="dropdown-item" href="/dashboard/user">Eigen leeromgeving</a>
                            
                            <?php
                            $company = get_field('company',  'user_' . $user->ID);

                            if(!empty($company)){
                                if ( in_array( 'manager', $user->roles ) || in_array( 'administrator', $user->roles )  || $user->roles == 'administrator') {
                            ?>
                            <a class="dropdown-item" href="/dashboard/company">Manager <span>intern</span></a>
                            <?php }
                            }?>
                            <?php
                            if ( in_array( 'teacher', $user->roles ) || in_array( 'administrator', $user->roles ) || $user->roles == 'administrator') {
                            ?>
                            <a class="dropdown-item" href="/dashboard/teacher">Teacher <span>Extern</span></a>
                            <?php }?>
                        </div>
                    </div>
                    <div class="nav-item" href="#">
                        <?php if($user) {?>
                            <button class="btn bntNotification" data-toggle="modal" data-target="#ModalNotification">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification.svg" alt="">
                                <?php if(!empty($todos)){ ?><span class="alertNotification"></span> <?php } ?>
                            </button>
                        <?php }else{ ?>
                            <button class="btn bntNotification">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification.svg" alt="">
                            </button>
                        <?php } ?>

                        <div class="modal fade" id="ModalNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Notifications</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php 
                                    $todos = array_reverse($todos);
                                    foreach($todos as $key=>$todo) {
                                        if($key == 4)
                                            break;

                                        $value = explode(";", $todos);
                                        $manager = get_users(array('include'=> $value[2]))[0]->data;
                                    ?>
                                    <a href="/dashboard/user/detail-notification/?todo=<?php echo $key ?>" class="modal-content-body">
                                        <p class="feedbackText">Feedback : <span><?php echo $value[0]; ?></span></p>
                                        <p class="feedbackText">By: <span><?php if(isset($manager->first_name) && isset($manager->first_name)) echo $manager->first_name .' '. $manager->first_name; else echo $manager->display_name; ?></span></p>
                                    </a>
                                    <?php 
                                        }
                                    ?>
                                   <div>
                                       <a href="/dashboard/user/notification" class="btn btnSee">See all</a>
                                   </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <a class="navbar-brand navBrand" href="/">
                    <div class="logoModife logoWeb">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_white.png" alt="">
                    </div>
                    <div class="logoModife logoMobile blockLogoMobileLivelearn">
                        <img  src="<?php echo get_stylesheet_directory_uri();?>/img/logoMobil.png" alt="">
                    </div>
                </a>
                <div class="elementWeb">
                    <a href="#" class="nav-link navModife4 btn dropdown-toggle " type="button" id="dropdownNavButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dashboards <img class="imgArrowDropDown" src="<?php echo get_stylesheet_directory_uri();?>/img/down-chevron.svg" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-dashboard" aria-labelledby="dropdownMenuButton1">
                        <a class="dropdown-item" href="/dashboard/user">Eigen leeromgeving</a>
                        <?php
                        $company = get_field('company',  'user_' . $user->ID);

                        if(!empty($company)){
                                if ( in_array( 'manager', $user->roles ) || in_array( 'administrator', $user->roles )  || $user->roles == 'administrator') {
                            ?>
                        <a class="dropdown-item" href="/dashboard/company">Manager <span>intern</span></a>
                        <?php }
                        }?>

                        <?php
                            if ( in_array( 'teacher', $user->roles ) || in_array( 'administrator', $user->roles ) || $user->roles == 'administrator') {
                            ?>
                        <a class="dropdown-item" href="/dashboard/teacher">Teacher <span>Extern</span></a>
                        <?php }?>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <?php

                        if(!empty($company)){
                            if ( in_array( 'manager', $user->roles ) || in_array('administrator', $user->roles)) {
                                $company_id = $company[0]->ID;
                                $company_logo = get_field('company_logo', $company_id);
                        ?>
                        <li class="nav-link companyButton">
                            <a href="/dashboard/company">
                                <img class="userBlockNav" src="<?php echo $company_logo;?>" alt="">
                            </a>
                        </li>
                        <?php }
                        }
                        ?>
                        <button class="elementMobile btnSidbarMob b1 buttonHumberger" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <button class="elementMobile btnSidbarMob b2 buttonCroi" type="button">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/XMobile.png" alt="">
                        </button>

                        <li class="position-relative dropdown dropdownNotificationToggle">
                            <button class="btn bntNotification elementWeb dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification.svg" alt="">
                                <span class="alertNotification"></span>
                            </button>
                            <div class="dropdown-menu dropdownNotificationWeb" aria-labelledby="dropdownMenuButton">
                                <h5 class="modal-title" id="exampleModalLabel">Notifications</h5>
                                <?php 
                                    if(!empty($todos)){
                                ?>
                                <div>
                                    <?php
                                  
                                    $todos = array_reverse($todos);
                                    foreach($todos as $key=>$todo) {
                                        if($key == 4)
                                            break;

                                        $value = explode(";", $todo);
                                        $manager = get_users(array('include'=> $value[2]))[0]->data;
                                    ?>
                                    <a href="/dashboard/user/detail-notification/?todo=<?php echo $key ?>" class="modal-content-body">
                                        <p class="feedbackText">Feedback : <span><?php echo $value[0]; ?></span></p>
                                        <p class="feedbackText">By: <span><?php if(isset($manager->first_name) && isset($manager->first_name)) echo $manager->first_name .' '. $manager->first_name; else echo $manager->display_name; ?></span></p>
                                    </a>
                                    <?php 
                                        }
                                    ?>
                                   <div>
                                       <a href="/dashboard/user/notification" class="btn btnSee">See all</a>
                                   </div>
                                    
                                </div>
                                <?php } else { ?>
                                    <div>
                                    <div class="modal-content-body">
                                        <p class="feedbackText">Empty until now ...</p>
                                    </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </li>

                        <li class="nav-item item4 dropdown elementWeb">
                            <a href="/dashboard/user/profile/" class="nav-link navModife4 btn dropdown-toggle" type="button" id="dropdownNavButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="userBlockNav" src="<?php echo get_field('profile_img',  'user_' . $user->ID);?>" alt="">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/dashboard/user/">Dashboard</a>
                                <a class="dropdown-item" href="/dashboard/company/profile/">Mijn profiel</a>
                                <a class="dropdown-item" href="<?php echo wp_logout_url('/'); ?>">Uitloggen</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="main">