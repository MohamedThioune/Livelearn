<?php
    global $wp;

    $user = get_users(array('include'=> get_current_user_id()))[0]->data;
    $image = get_field('profile_img',  'user_' . $user->ID);
    $company = get_field('company',  'user_' . $user->ID);
    $biographical_info = get_field('biographical_info',  'user_' . $user->ID);

    if(!empty($company))
        $company = $company[0]->post_title;

    $url = $wp->request;
    
    $option_menu = explode('/', $url);

    $user = wp_get_current_user();
    if ( !in_array( 'hr', $user->roles ) && !in_array( 'manager', $user->roles ) && !in_array( 'administrator', $user->roles ) && !in_array( 'author', $user->roles ) ) 
        header('Location: /dashboard/user');
?>
<section class="sidBarDashboard sidBarDashboardIndividual" name="section1">
    <ul class="">
        <li class="elementTextDashboard">
            <a href="/dashboard/teacher/" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Dashboard.png" >
                </div>
                <?php
                if(!isset($option_menu[2])) echo '<span><b>Dashboard</b></span>'; else echo '<span>Dashboard</span>';
                ?>
                
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/teacher/course-selection/" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Opleiding_toevoegen.png" >
                </div>
                <?php
                if($option_menu[2] == 'course-selection') echo '<span><b>Opleiding toevoegen</b></span>'; else echo '<span>Opleiding toevoegen</span>';
                ?>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/teacher/course-overview/" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Overzicht_opleidingen.png" >
                </div>
                <?php
                if($option_menu[2] == 'course-overview') echo '<span><b>Overzicht opleidingen</b></span>'; else echo '<span>Overzicht opleidingen</span>';
                ?>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="/dashboard/teacher/courses/" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Inschrijvingen.png" >
                </div>
                <?php
                if($option_menu[2] == 'courses') echo '<span><b>Inschrijvingen</b></span>'; else echo '<span>Inschrijvingen</span>';
                ?>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="#" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Berichten.png" >
                </div>
                <span > Berichten</span>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="#" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Financien.png" >
                </div>
                <span > Financien</span>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="#" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Statistieken.png" >
                </div>
                <span > Statistieken</span>
            </a>
        </li>
        <li class="elementTextDashboard">
            <a href="#" class="d-flex">
                <div class="elementImgSidebar" >
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Instellingen.png" >
                </div>
                <span > Instellingen</span>
            </a>
        </li>
    </ul>
</section>