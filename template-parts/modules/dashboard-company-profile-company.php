<?php
$current_user = wp_get_current_user();
$company = get_field('company', 'user_' . $current_user->ID);
if(!empty($company) ){
    $company = $company[0];
    $company_connected = $company->post_title;
}

$users = get_users();
$members = array();
foreach($users as $user){
    $company_value = get_field('company',  'user_' . $user->ID);
    if(!empty($company_value)){
        $company_value_title = $company_value[0]->post_title;
        if($company_value_title == $company_connected)
            array_push($members, $user);
    }
}
$team = count($members);
$telnr = get_field('telnr', 'user_' . $current_user->ID);

extract($_POST);
if(isset($starter)){
    // endpoint for product & customer 
    $endpoint_customer = 'livelearn.nl/wp-json/wc/v3/customers';
    $endpoint_product = 'livelearn.nl/wp-json/wc/v3/products';

    $params = array( // login url params required to direct user to facebook and promt them with a login dialog
        'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
        'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
    );

    //create endpoint with params
	$api_endpoint_customer = $endpoint_customer . '?' . http_build_query( $params );
    $api_endpoint_product = $endpoint_product . '?' . http_build_query( $params );
    
    $data =  [
        'email' => 'daniel@livelearn.nl',
        'first_name' => 'Daniel',
        'last_name' => 'Van Der Kolk',
        'username' => 'Daniel.Van',
        'billing' => [
            'first_name' => 'Daniel',
            'last_name' => 'Van Der Kolk',
            'company' =>  'Livelearn',
            'address_1' => $factuur_address,
            'address_2' => '',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postcode' => '94103',
            'country' => 'US',
            'email' => 'daniel@livelearn.nl',
            'phone' => "(31) 6 27 00 39 62"
        ],
        'shipping' => [
            'first_name' => 'Daniel',
            'last_name' => 'Van Der Kolk',
            'company' =>  'Livelearn',
            'address_1' => $factuur_address,
            'address_2' => '',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postcode' => '94103',
            'country' => 'US'
        ]
    ];

    $data_product = [
        'name' => $company->post_title . ' monthly subscription by livelearn',
        'type' => 'simple',
        'regular_price' => '5',
        'description' => 'No short description',
        'short_description' => 'No long description',
        'categories' => [
            [
                'id' => 9
            ],
            [
                'id' => 14
            ]
        ],
        'images' => [
            [
                'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
            ],
            [
                'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
            ]
        ]
    ];

    // initialize curl
	$ch = curl_init();
    $chp = curl_init();
    
    // set other curl options customer
    curl_setopt($ch, CURLOPT_URL, $api_endpoint_customer);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    // set other curl options customer
    curl_setopt($chp, CURLOPT_URL, $api_endpoint_product);
    curl_setopt($chp, CURLOPT_POST, true);
    curl_setopt($chp, CURLOPT_POSTFIELDS, $data_product);
    curl_setopt($chp, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($chp, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($chp, CURLOPT_RETURNTRANSFER, true );

    $httpCode = curl_getinfo($ch , CURLINFO_HTTP_CODE); // this results 0 every time
    $httpCodeP = curl_getinfo($chp , CURLINFO_HTTP_CODE); // this results 0 every time

    // get responses
    $response_customer = curl_exec($ch);
    $response_product = curl_exec($chp);

    if ($response_customer === false || $response_product === false) {
        $response_customer = curl_error($ch);
        $response_product = curl_error($ch);
        $error = true;
        $message = "Something went wrong !";
    }
    else{
        // get customer_id
        $data_response = json_decode( $response_customer, true );
        $customer_id = $data_response[0]['id'];

        // get product_id
        $data_response_product = json_decode( $response_product, true );
        $product_id = $data_response_product[0]['id'];

        /*
        ** Create subscription
        */ 
        $endpoint = 'livelearn.nl/wp-json/wc/v3/customers';

        $params = array( // login url params required to direct user to facebook and promt them with a login dialog
            'consumer_key' => 'ck_f11f2d16fae904de303567e0fdd285c572c1d3f1',
            'consumer_secret' => 'cs_3ba83db329ec85124b6f0c8cef5f647451c585fb',
        );

        //create endpoint with params
        $api_endpoint = $endpoint . '?' . http_build_query( $params );
        
        $data = [
            'customer_id'       => $customer_id,
            'status'            => 'active',
            'billing_period'    => 'month',
            'billing_interval'  => 12,
            'start_date'        => '2022-12-06 09:05:00',
            'next_payment_date' => '2023-01-06 09:45:00',
            'payment_method'    => 'mollie',
            'payment_details'   => [
            
            ],
            'billing' => [
                'first_name' => 'Daniel',
                'last_name' => 'Van Der Kolk',
                'company' =>  'Livelearn',
                'address_1' => $factuur_address,
                'address_2' => '',
                'city' => 'San Francisco',
                'state' => 'CA',
                'postcode' => '94103',
                'country' => 'US',
                'email' => 'daniel@livelearn.nl',
                'phone' => "(31) 6 27 00 39 62"
            ],
            'shipping' => [
                'first_name' => 'Daniel',
                'last_name' => 'Van Der Kolk',
                'company' =>  'Livelearn',
                'address_1' => $factuur_address,
                'address_2' => '',
                'city' => 'San Francisco',
                'state' => 'CA',
                'postcode' => '94103',
                'country' => 'US'
            ],
            'line_items' => [
                [
                    'product_id' => $product_id,
                    'quantity'   => $team
                ],
                [
                    'product_id'   => $product_id,
                    'variation_id' => 0,
                    'quantity'     => $team
                ]
            ],
            'shipping_lines' => [
                [
                    'method_id'    => 'flat_rate',
                    'method_title' => 'Flat Rate',
                    'total'        => '10'
                ]
            ],
            'meta_data' => [
                [
                    'key'   => '_custom_subscription_meta',
                    'value' => 'custom meta'
                ]
            ]
        ];

        // initialize curl
        $ch = curl_init();
        
        // set other curl options customer
        curl_setopt($ch, CURLOPT_URL, $api_endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
        }

        $data_response = json_decode( $response, true );
        var_dump($data_response);

    }

    // close curl
    curl_close( $ch );
}

//Fields
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
                                'fields' => array('company_logo', 'company_address', 'company_place', 'company_country',),
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

                            <!-- <div class="form-group py-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Bedrijfsnaam</strong></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control border-0" id="inputPassword" placeholder=""
                                        style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div> -->

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

                            <div class="form-group">
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
                            </div>  

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