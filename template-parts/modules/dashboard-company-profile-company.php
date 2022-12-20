<?php
$current_user = wp_get_current_user();
$company = get_field('company', 'user_' . $current_user->ID);
if(!empty($company) ){
    $company = $company[0];
    $company_connected = $company->post_title;
}

$telnr = get_field('telnr', 'user_' . $current_user->ID);
extract($_POST);
if(isset($starter)){
    //Current user
    $user_id = get_current_user_id();

    //Team members
    $users = get_users();
    $members = array();
    foreach($users as $user){
        $company_value = get_field('company',  'user_' . $user->ID);
        if(!empty($company_value)){
            $company_value_title = $company_value[0]->post_title;
            if($company_value_title == $bedrjifsnaam)
                array_push($members, $user);
        }
    }
    $team = count($members);

    //endpoint for product 
    $endpoint_product = 'https://livelearn.nl/wp-json/wc/v3/products';

    $params = array( 
        'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
        'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    );

    //create endpoint with params
    $api_endpoint = $endpoint_product . '?' . http_build_query( $params );

    $data = [
        'name' => $bedrjifsnaam ." subscription",
        'type' => 'simple',
        'regular_price' => '5.00',
        'description' => 'No short description',
        'short_description' => 'No long description',
        'categories' => [],
        'images' => []
    ];

    // initialize curl
    $chp = curl_init();

    // set other curl options product
    curl_setopt($chp, CURLOPT_URL, $api_endpoint);
    curl_setopt($chp, CURLOPT_POST, true);
    curl_setopt($chp, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($chp, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($chp, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($chp, CURLOPT_RETURNTRANSFER, true );

    $httpCode = curl_getinfo($chp , CURLINFO_HTTP_CODE); // this results 0 every time

    // get responses
    $response_product = curl_exec($chp);
    if($response_product === false) {
        $response_product = curl_error($chp);
        $error = true;
        $message = "Something went wrong !";
        var_dump($response_product);
    }
    else{
        // get product_id
        $data_response_product = json_decode( $response_product, true );
        $product_id = $data_response_product['id'];

        /*
        ** Create subscription
        */ 
        $endpoint = 'https://livelearn.nl/wp-json/wc/v3/subscriptions';

        $params = array( // login url params required to direct user to facebook and promt them with a login dialog
            'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
            'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
        );

        //create endpoint with params
        $api_endpoint = $endpoint . '?' . http_build_query( $params );
        $date_now = date('Y-m-d H:i:s');
        $date_now_timestamp = strtotime($date_now);
        $trial_end_date = date("Y-m-d H:i:s", strtotime("+14 day", $date_now_timestamp));
        $next_payment_date = date($trial_end_date, strtotime("+1 month", strtotime($trial_end_date)));

        $data = [
            'customer_id'       => $user,
            'status'            => 'active',
            'billing_period'    => 'month',
            'billing_interval'  =>  1,
            'start_date'        => $date_now,
            'trial_end_date'    => $trial_end_date,
            'next_payment_date' => $next_payment_date,
            'payment_method'    => 'ideal',
            
            'billing' => [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'company'    =>  $bedrjifsnaam,
                'address_1'  => $factuur_address,
                'address_2'  => '',
                'city'     => '', //place
                'state'    => 'NL-DR',
                'postcode' => '1011',
                'country'  => 'NL',
                'email'    => $email,
                'phone'    => $phone,
            ],
            'shipping' => [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'company'    =>  $bedrjifsnaam,
                'address_1'  => $factuur_address,
                'address_2'  => '',
                'city'     => '', //place
                'state'    => 'NL-DR',
                'postcode' => '1011',
                'country'  => 'NL'
            ],
            'line_items' => [
                [
                    'product_id' => $product_id,
                    'quantity'   => $team
                ],
            ],
            'shipping_lines' => [],
            'meta_data' => [
                [
                    'key'   => '_custom_subscription_meta',
                    'value' => 'custom meta'
                ]
            ]
        ];

        // close curl
        curl_close( $ch );

        // initialize curl
        $ch = curl_init();
        
        // set other curl options customer
        curl_setopt($ch, CURLOPT_URL, $api_endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

        $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time

        // get responses
        $response = curl_exec($ch);
        if ($response === false) {
            $response = curl_error($ch);
            $error = true;
            $message = "Something went wrong !";
            echo stripslashes($response);
            var_dump($response);
        }
        else
            $message = "Subscription applied succesfully !";

    }
    
    // close curl
    curl_close( $ch );

}

?>
<style>
    .nav-tabs .nav-link.active {
        background: #023356 !important;
        color: #fff !important;
    }
    @media all and (max-width: 567px) {
        .nav-fill {
            margin-bottom: 50px !important;
        }
        .nav-tabs .nav-item a {
            padding-top: 10px !important;
            height: 43px;
        }

    }
</style>
<div class="contentProfil ">
    <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12">
            <?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ; ?>

            <!-- Tabs navs -->
            <ul class="headTabsCompany" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn btnCustomTabs btnactive" type="button" id="tab1">
                        Algemene bedrijfsinformatie
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btnCustomTabs btn" type="button" id="tab2">
                        Financiêle informatie
                    </button>
                </li>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tabContentCompany">
                <div class="tab-pane show"  id="tab1Content" class="tab">
                    <?php
                        if(!empty($company)) {
                            acf_form([
                                'id' => 'edit-company-data-form',
                                'post_id' => $company->ID,
                                'fields' => array('company_logo', 'company_address', 'company_place', 'company_country'),
                                'new_post' => false,
                            ]);
                        }
                    ?>
                </div>
                <div class="tab-pane"  id="tab2Content" class="tab">
                    <div class="bg-white mt-5 p-2 radius-custom mb-4" id="div_table" style="display:block" >  
                        <!-- <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div> -->
                        <div class="d-flex justify-content-between w-100 border-bottom border-5 pb-2">
                            <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div>
                            <div><i class="fa fa-gear fa-2x pt-1"></i></div>
                        </div>

                        <form method="POST" action="" class="">

                            <div class="form-group py-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Volledige naam</strong></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control border-0" id="inputPassword" name="first_name" value="<?= $current_user->first_name ?>" placeholder=""
                                        style="background: #E0EFF4" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control border-0" id="inputPassword" name="last_name" value="<?= $current_user->last_name ?>" placeholder=""
                                        style="background: #E0EFF4" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group py-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Bedrjifsnaam</strong></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control border-0" id="inputPassword" name="bedrjifsnaam" value="<?= $company_connected ?>" placeholder=""
                                        style="background: #E0EFF4" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group py-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">E-mail</strong></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control border-0" id="inputPassword" name="email" value="<?= $current_user->user_email ?>" placeholder=""
                                        style="background: #E0EFF4" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group py-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Phone</strong></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control border-0" id="inputPassword" name="phone" value="<?= $telnr ?>" placeholder=""
                                        style="background: #E0EFF4" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Factuuradres</strong></label>
                                    </div>
                                    <div class="col-md-8 pt-2">
                                        <input type="text" name="factuur_address" class="form-control border-0" id="inputPassword" 
                                            placeholder="" style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Credicardgegevents</strong></label>
                                    </div>
                                    <div class="col-md-8 pt-2">
                                        <input type="text" name="credit_card" class="form-control border-0" id="inputPassword" 
                                            placeholder="" style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div>   -->

                            <div class="row d-flex justify-content-center">
                                <button class="btn text-white" type="submit" name="starter" style="background: #00A89D"><strong>Een abonnement aanmaken</strong></button>
                            </div>

                        </form>
                        
                    </div>
                </div>
            </div>
            <!-- Tabs content -->

            <!-- <div class="blockgeneralPersoo">
                <div class="blockPersoo2">
                    <div class="blockPersoonlijke">
                        <div class="headPersoon">
                            <p class="titleHeadPersoon">Persoonlijke</p>
                            <a href="#" class="iconeSetting">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/iconeSettings.png" alt="">
                            </a>
                        </div>
                        <div class="contentPersoon">
                            <a href="../detail-profile-teacher" class="blockImgName">
                               <div class="profilImg">
                                   <img src="<?php echo $image ?>" alt="">
                               </div>
                                <div class="blockTilteName">
                                    <p class="name"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name; ?></p>
                                </div>
                            </a>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"><?php echo $company ?></p>
                            </div>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"><?php echo get_field('role', 'user_'.$user->ID);?></p>
                            </div>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"><?php echo $user->user_email;?></p>
                            </div>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"></p>
                            </div>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"><?php echo get_field('telnr', 'user_'.$user->ID);?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5"></div>
    </div>
</div>

-->
<script>
    $("#tab2").click(function() {
        $("#tab2").addClass('btnactive') ;
        $("#tab1").removeClass('btnactive') ;
        $("#tab2Content").show();
        $("#tab1Content").hide();
    });
    $("#tab1").click(function() {
        $("#tab1").addClass('btnactive') ;
        $("#tab2").removeClass('btnactive') ;
        $("#tab1Content").show();
        $("#tab2Content").hide();
    });
</script>