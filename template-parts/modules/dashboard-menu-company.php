<?php
    global $wp;

    $url = $wp->request;
    
    $option_menu = explode('/', $url);

    $user = wp_get_current_user();
    if ( !in_array( 'hr', $user->roles ) && !in_array( 'manager', $user->roles ) && !in_array( 'administrator', $user->roles ) && $user->roles != 'administrator') 
        header('Location: /dashboard/user');
?>
<section id="sectionDashboard1" class="sidBarDashboard sidBarDashboardIndividual" name="section1"
    style="overflow-x: hidden !important;">
    <button class="btn btnSidbarMobCroix">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/cancel.png" alt="">
    </button>
    <div class="row">
        <div class="col">
            <div class="theme-side-menu__list" style="color:#212529">
                <ul class="">
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/" class="d-flex">
                           <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Dashboard.png" >
                            </div>
                            <?php
                            if(!isset($option_menu[2])) echo '<span><b>Dashboard</b></span>'; else echo '<span>Dashboard</span>';
                            ?>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/people/" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Mijn-mensen.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'people') echo '<span><b>Mensen</b></span>'; else echo '<span>Mensen</span>';
                            ?>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/learning-modules/" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Overzicht_opleidingen.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'learning-modules') echo '<span><b>Onze leermodules</b></span>'; else echo '<span>Onze leermodules</span>';
                            ?>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/learning-databank/" class="d-flex">
                           <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Leer-databank.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'learning-databank') echo '<span><b>Leer-databank</b></span>'; else echo '<span>Leer-databank</span>';
                            ?>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/leerbudgetten/" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Financien.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'leerbudgetten') echo '<span><b>Leerbudgetten</b></span>'; else echo '<span>Leerbudgetten</span>';
                            ?>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="#" class="d-flex">
                           <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Berichten.png" >
                            </div>
                            <span>Berichten</span>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/statistic" class="d-flex">
                            <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Statistieken.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'statistic') echo '<span><b>Statistieken</b></span>'; else echo '<span>Statistieken</span>';
                            ?>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/profile-company/" class="d-flex">
                           <div class="elementImgSidebar" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Instellingen.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'profile-company') echo '<span><b>Instellingen</b></span>'; else echo '<span>Instellingen</span>';
                            ?>
                        </a>
                    </li>
                    <li class="elementTextDashboard">
                        <a href="/dashboard/company/allocate/" class="d-flex">
                           <div class="elementImgSidebar imgSide2" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Manage-Organisatie.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'allocate') echo '<span><b>De organisatie</b></span>'; else echo '<span>De organisatie</span>';
                            ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
