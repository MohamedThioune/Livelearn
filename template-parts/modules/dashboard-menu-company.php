<?php
    global $wp;

    $url = $wp->request;
    
    $option_menu = explode('/', $url);

    $access_granted = false;

    //User informations
    $user = wp_get_current_user();
    $company = get_field('company', 'user_' . $user->ID);
    if(!empty($company) ){
        $company = $company[0];
        $company_connected = $company->post_title;
    }

    var_dump($company_connected);
    /*
    ** List subscriptions
    */ 
    $endpoint = 'https://livelearn.nl/wp-json/wc/v3/subscriptions';

    $params = array( // login url params required to direct user to facebook and promt them with a login dialog
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
    $response = curl_exec($ch);
    if ($response === false) {
        $response = curl_error($ch);
        $error = true;
        //echo stripslashes($response);
        $access_granted = false;
    }
    else{
        $data_response = json_decode( $response, true );
        if(!empty($data_response))
            foreach($data_response as $subscription)
                if( strval($subscription['billing']['company']) == $company_connected && $subscription['status'] == "active"){
                    $access_granted = true;
                    break;
                }                    
    }

    if ( !in_array( 'hr', $user->roles ) && !in_array( 'manager', $user->roles ) && !in_array( 'administrator', $user->roles ) && $user->roles != 'administrator') 
        header('Location: /dashboard/user');

    if(isset($option_menu[2])) 
        if($option_menu[2] == 'profile-company')
            $access_granted = true;

    if (!$access_granted && !in_array( 'administrator', $user->roles ))
        header('Location: /dashboard/company/profile-company');

    

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
                        <button href="#" class="d-flex berichtenBtn">
                            <div class="d-flex">
                                <div class="elementImgSidebar" >
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/Berichten.png" >
                                </div>
                                <span>Berichten</span>
                            </div>
                            <span class="comming-soon">Comming Soon</span>
                        </button>
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
                        <a href="/dashboard/company/de-organisatie/" class="d-flex">
                           <div class="elementImgSidebar imgSide2" >
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/Manage-Organisatie.png" >
                            </div>
                            <?php
                            if($option_menu[2] == 'de-organisatie') echo '<span><b>De organisatie</b></span>'; else echo '<span>De organisatie</span>';
                            ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
