<?php
global $wp; 

$user = wp_get_current_user();

/*
* * Feedbacks
*/

$args = array(
    'post_type' => 'feedback', 
    'author' => $user->ID,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'posts_per_page' => -1,
);

$notifications = get_posts($args);
$todos = array();

$url = home_url( $wp->request );

$link = ($user) ? '/dashboard/user' : '/'; 

if(!empty($notifications))
    foreach($notifications as $todo){

        $read = get_field('read_feedback', $todo->ID);
        if($read)
            continue;

        array_push($todos,$todo);
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="Fluidify">
        <meta name='keywords' content="fluidify">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/custom.css" />
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/rating.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css'>
        <!-- get bootstrap icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <style>
            .nav-pills .nav-link {
                color: black !important;
            }
            .nav-pills .nav-link.active {
                background: #023356 !important;
                color: white !important;
            }
        </style>

        <title><?php bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>
    <body class="header-user canhas">


        <!-- Modal -->
        <div class="modal fade mt-5" id="bedrijfsprofiel_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  style="width:98%; overflow-y: hidden !important">
            <div class="modal-dialog" role="document">
                <div class="modal-content px-md-5 px-1">
                    <div class="modal-header border-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="text-center mb-4">
                            <p class="JouwOpleid" style="font-size: 20px !important">
                                Creëer een bedrijfsprofiel of unlock de voordelen van jouw organisatie
                            </p>
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="height: 34px">
                            <li class="nav-item w-50 text-center">
                                <a class="nav-link text-dark active rounded rounded-pill h-100" id="pills-home-tab" data-toggle="pill"
                                 href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"
                                 style="padding-top: 5px !important; background: #E6E6E6">Word onderdeel van een bedrijf</a>
                            </li>
                            <li class="nav-item w-50 text-center">
                                <a class="nav-link text-dark rounded rounded-pill h-100" id="pills-profile-tab" data-toggle="pill" 
                                href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"
                                style="padding-top: 5px !important;background: #E6E6E6">Maak een bedrijfsprofiel</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <?php echo do_shortcode("[gravityform id='14' title='false' description='false' ajax='true']"); ?>                                
                                <p class="description pt-2 text-center">
                                    Ons team doet een snelle check of het bedrijf en gegevens kloppen en dan krijg je 
                                    direct toegang tot je bedrijfs leeromgeving
                                </p>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <?php echo do_shortcode("[gravityform id='15' title='false' description='false' ajax='true']"); ?>                                
                                <p class="description pt-2 text-center">
                                    Ons team doet een snelle check of het bedrijf en gegevens kloppen en dan krijg je 
                                    direct toegang tot je bedrijfs leeromgeving
                                </p>

                                <p class="JouwOpleid pt-3 text-center">
                                    Eerst le zen wat we doen? <a href="">Click hier!</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark headerdashboard">
            
            <div class="blockIconeWidth">
                <button id="burger-web" class="largeElement btn">
                    <i class="fa fa-bars text-white" style="font-size: 25px"></i>
                </button>
                <button id="burgerCroie-web" class="btn ">
                    <i class="bi bi-x-lg text-white" style="font-size: 25px"></i>
                </button>
            </div>
            <div class="container-fluid containerModife">
                <div class="elementMobile groupBtnMobile">
                    <div class="nav-item" href="#">
                        <button class="btn bntNotification" data-toggle="modal" data-target="#ModalNotification">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification.svg" alt="">
                            <span style="color:white" class="alertNotification"><?=count($todos);?></span>
                        </button>

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
                                        if(!empty($todos)){
                                            foreach($todos as $todo){
                                                if($key == 4)
                                                    break;

                                                $read = get_field('read_feedback', $todo->ID);
                                                if($read)
                                                    continue;

                                                $type = get_field('type_feedback', $todo->ID);
                                                $manager = get_field('manager_feedback', $todo->ID);
                                        ?> 
                                            <a href="/dashboard/user/detail-notification/?todo=<?=$todo->ID;?>" class="modal-content-body">
                                                <p class="feedbackText"><?=$type;?> : <span><?=$todo->post_title;?></span></p>
                                                <p class="feedbackText">By: <span> <?php if(!empty($manager->first_name)){echo $manager->first_name;}else{echo $manager->display_name;}?> </span></p>
                                            </a>
                                    <?php
                                            }
                                        }else{
                                    ?>
                                            <div>
                                                <div class="modal-content-body">
                                                    <p class="feedbackText">Empty until now ...</p>
                                                </div>
                                            </div>

                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item item4 dropdown">
                        <a href="#" class="nav-link navModife4 btn dropdown-toggle " type="button" id="dropdownNavButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="imgArrowDropDown" src="<?php echo get_stylesheet_directory_uri();?>/img/three-stars.png" alt="">
                        </a>
                        <div class="dropdown-menu dropdown-menu-dashboard" aria-labelledby="dropdownMenuButton1">
                            <?php
                            $company = get_field('company',  'user_' . $user->ID);
                            if(!empty($user->roles))
                                echo '<a class="dropdown-item" href="/dashboard/user">Eigen leeromgeving</a>';

                            if(!empty($company)){
                                if ( in_array( 'hr', $user->roles ) || in_array( 'manager', $user->roles ) || in_array( 'administrator', $user->roles )  || $user->roles == 'administrator') {
                            ?>
                            <a class="dropdown-item" href="/dashboard/company">Manager <span>intern</span></a>
                            <?php }
                            }?>
                            <?php
                            if ( in_array( 'hr', $user->roles ) || in_array( 'author', $user->roles ) || in_array( 'administrator', $user->roles ) || $user->roles == 'administrator') {
                            ?>
                            <a class="dropdown-item" href="/dashboard/teacher">Teacher <span>Extern</span></a>
                            <?php }?>
                        </div>
                    </div>
                </div>

                <a href="<?= $link; ?>" class="navbar-brand navBrand" >
                    <div class="logoModife logoWeb logoDashboard">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_white.png" alt="">
                    </div>
                    <a href="<?= $link; ?>" class="logoMobile">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn_white.png" alt="LogoMobile" >
                    </a>
                </a>
                <div class="elementWeb dashboardsElement">
                    <a href="#" class="nav-link navModife4 btn dropdown-toggle " type="button" id="dropdownNavButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dashboards <img class="imgArrowDropDown" src="<?php echo get_stylesheet_directory_uri();?>/img/down-chevron.svg" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-dashboard" aria-labelledby="dropdownMenuButton1">
                        <a class="dropdown-item" href="/dashboard/user">Eigen leeromgeving</a>
                        <?php
                        $company = get_field('company',  'user_' . $user->ID);

                        if(!empty($company))
                            if ( in_array( 'hr', $user->roles ) || in_array( 'manager', $user->roles ) || in_array( 'administrator', $user->roles )  || $user->roles == 'administrator') 
                                echo '<a class="dropdown-item" href="/dashboard/company">Manager <span>intern</span></a>';
                        ?>

                        <?php
                            if ( in_array( 'hr', $user->roles ) || in_array( 'author', $user->roles ) || in_array( 'administrator', $user->roles ) || $user->roles == 'administrator') 
                                echo '<a class="dropdown-item" href="/dashboard/teacher">Teacher <span>Extern</span></a>';
                        ?>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- input search -->
                    <form action="/product-search" method="POST" class="form-inline ml-auto mb-0 formHeaderUser">
                        <input id="header-search" class="form-control InputDropdown1 mr-sm-2 inputSearch" name="search" type="search" placeholder="Zoek opleidingen, exports en onderwerpen" aria-label="Search">
                        <div class="dropdown-menuSearch headerDrop" id="header-list">
                            <div class="list-autocomplete" id="header">
                                <center> <i class='hasNoResults'>No matching results</i> </center>
                            </div>
                        </div>
                    </form>
                    

                    <ul class="elementHeaderUser ">
                        <li class="nav-item dropdown addButtonLink">
                            <a href="#" class="nav-link navModife4 btn dropdown-toggle" type="button" id="dropdownNavButtonAdd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/addition.png" alt="addition" 
                                style="width: 36px !important; height: 36px !important">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonAdd">
                                <a class="dropdown-item" href="/onderwer/">Onderwerpen</a>
                                <a class="dropdown-item" href="/opleiders/">Experts</a>
                            </div>
                        </li>
                        <?php
                        $company_id = 0;
                        if(!empty($company))
                            $company_id = $company[0]->ID;

                        $company_logo = (get_field('company_logo', $company_id)) ? get_field('company_logo', $company_id) : get_stylesheet_directory_uri() . '/img/business-and-trade.png';

                        ?>
                        <li class="nav-link companyButton">
                        <?php 
                            if($company_id)
                                if(in_array( 'hr', $user->roles ) || in_array( 'manager', $user->roles ) || in_array('administrator', $user->roles) )
                                    $ref_company = "/dashboard/company";
                                else
                                    $ref_company = "#";
 
                        ?>
                            <a <?php if(isset($ref_company)) echo'href ="' .$ref_company. '"'; else echo 'data-toggle="modal" data-target="#bedrijfsprofiel_modal"'; ?> >
                                <div class="userBlockNav">
                                    <img src="<?php echo $company_logo;?>" alt="">
                                </div>
                            </a>

                        </li>
                       
                      <!--  <div class="second-element-mobile" id="burgerAndbelief">
                            <button id="burger" class=" btn burgerElement boxSousNav3-2">
                                <i class="fa fa-bars text-white" style="font-size: 25px"></i>
                            </button>
                            <button id="burgerCroie" class="btn croie">
                                <i class="bi bi-x-lg text-white" style="font-size: 25px"></i>
                            </button>
                        </div>-->


                        <li class="position-relative dropdown dropdownNotificationToggle">
                            <button class="btn bntNotification elementWeb dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/notification.svg" alt="">
                                <?php if(!empty($todos)){ ?> <span style="color:white" class="alertNotification"><?=count($todos);?></span> <?php } ?>
                            </button>
                            <div class="dropdown-menu dropdownNotificationWeb" aria-labelledby="dropdownMenuButton" id="ModalNotification">
                                <h5 class="modal-title" id="exampleModalLabel">Notifications</h5>
                                <?php
                                    if(!empty($todos)){
                                        foreach($todos as $todo){
                                            if($key == 4)
                                                break;

                                            $read = get_field('read_feedback', $todo->ID);
                                            if($read)
                                                continue;

                                            $type = get_field('type_feedback', $todo->ID);
                                            $manager = get_field('manager_feedback', $todo->ID);

                                    ?> 
                                        <a href="/dashboard/user/detail-notification/?todo=<?=$todo->ID;?>" class="">
                                            <p class="feedbackText"><?=$type;?> : <span><?=$todo->post_title;?></span></p>
                                            <p class="feedbackText">By: <span> <?php if(!empty($manager->first_name)){echo $manager->first_name;}else{echo $manager->display_name;}?> </span></p>
                                        </a>
                                <?php
                                        }
                                        echo '<div class="">
                                                  <a href="/dashboard/user/detail-notification/?todo=6620" class="btn BekijkNotifications">Bekijk alle notificaties</a>
                                              </div>';
                                    }
                                    else{
                                ?>
                                        <div>
                                            <div class="">
                                                <p class="feedbackText">Empty until now ...</p>
                                            </div>
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </li>
                        <?php
                        $user_image_account = (get_field('profile_img',  'user_' . $user->ID)) ? get_field('profile_img',  'user_' . $user->ID) :  get_stylesheet_directory_uri() . '/img/placeholder_user.png';  
                        ?>

                        <li class="nav-item item4 dropdown elementWeb" id="profilDropdown">
                            <a href="#" class="nav-link navModife4 btn dropdown-toggle" type="button" id="dropdownNavButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="userBlockNav" src="<?= $user_image_account; ?>" alt="">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/dashboard/user/">Dashboard</a>
                                <a class="dropdown-item" href="/dashboard/company/profile">Mijn profiel</a>
                                <a class="dropdown-item" href="<?php echo wp_logout_url($url); ?>">Uitloggen</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
     <!-- </body> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
    $('.bntNotification').click((e)=>{
        $.ajax({
                url:"/read-notification",
                method:"get",
                data:{},
                dataType:"text",
                success: function(data){
                    // Get the modal
                    console.log(data);
                }
        });
    });
</script>