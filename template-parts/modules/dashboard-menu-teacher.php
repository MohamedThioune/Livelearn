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

    $access_granted = false;

    //User informations
    $user = wp_get_current_user();
    $company = get_field('company', 'user_' . $user->ID);
    if(empty($company) ){
        $company = $company[0];
        $company_connected = $company->post_title;
    }

    /*
    ** List subscriptions
    */ 
    $endpoint = 'https://livelearn.nl/wp-json/wc/v3/subscriptions';

    $params = array(
        // login url params required to direct user to facebook and promt them with a login dialog
        'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
        'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    );
    // create endpoint with params
    $api_endpoint = $endpoint . '?' . http_build_query( $params );

    // initialize curl
    $ch = curl_init();
    
    // set other curl options customer
    curl_setopt($ch, CURLOPT_URL, $api_endpoint);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time

    // get responses
    // $response = curl_exec($ch);
    // if ($response === false) {
    //     $response = curl_error($ch);
    //     $error = true;
    //     echo stripslashes($response);
    // }
    // else{
    //     $data_response = json_decode( $response, true );
    //     if(!empty($data_response))
    //         foreach($data_response as $subscription)
    //             if($subscription['billing']['company'] == $company_connected && $subscription['status'] == 'active'){
    //                 $access_granted = true;
    //                 break;
    //             }                    
    // }

    if ( !in_array( 'hr', $user->roles ) && !in_array( 'manager', $user->roles ) && !in_array( 'administrator', $user->roles ) && !in_array( 'author', $user->roles ) ) 
        header('Location: /dashboard/user');

    // if ( !$access_granted )
    //     header('Location: /dashboard/company/profile-company');

?>
<section class="sidBarDashboard sidBarDashboardIndividual" name="section1">
    <button class="btn btn-close-sidbar">
        <i class="fa fa-close"></i>
    </button>
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
            <button href="#" class="d-flex berichtenBtn">
                <div class="d-flex">
                    <div class="elementImgSidebar" >
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Berichten.png" >
                    </div>
                   <span>Berichten</span>
                </div>
                <span class="comming-soon">Coming Soon</span>
            </button>
        </li>
        <li class="elementTextDashboard">
            <button href="#" class="d-flex berichtenBtn">
                <div class="d-flex">
                    <div class="elementImgSidebar" >
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Financien.png" >
                    </div>
                   <span>Financien</span>
                </div>
                <span class="comming-soon">Coming Soon</span>
            </button>
        </li>
        <li class="elementTextDashboard">
            <button href="#" class="d-flex berichtenBtn">
                <div class="d-flex">
                    <div class="elementImgSidebar" >
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Statistieken.png" >
                    </div>
                   <span>Statistieken</span>
                </div>
                <span class="comming-soon">Coming Soon</span>
            </button>
        </li>
        <li class="elementTextDashboard">
            <button href="#" class="d-flex berichtenBtn">
                <div class="d-flex">
                    <div class="elementImgSidebar" >
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Instellingen.png" >
                    </div>
                   <span>Instellingen</span>
                </div>
                <span class="comming-soon">Coming Soon</span>
            </button>
        </li>
    </ul>
</section>