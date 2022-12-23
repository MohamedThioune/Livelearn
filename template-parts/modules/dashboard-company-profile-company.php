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

<div class="contentProfil ">

    <h1 class="titleSubscription">Subscription</h1>
    <div class="contentFormSubscription">
        <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">First name</label>
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="first_name" placeholder="First name" name="first_name">
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Last name</label>
                    <i class="fas fa-users" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="last_name" placeholder="Last name" name="last_name">
                </div>
            </div>
            <div class="form-group">
                <label for="bedrjifsnaam">Company Name</label>
                <i class="fas fa-building" aria-hidden="true"></i>
                <input type="text" class="form-control" id="bedrjifsnaam" placeholder="Bedrjifsnaam" name="bedrjifsnaam">
            </div>
            <div class="form-group">
                <label for="city">Company place</label>
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                <input type="text" class="form-control" id="city" placeholder="City" name="city">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">Phone number</label>
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <input type="number" class="form-control" id="phone" placeholder="Phone number" name="phone">
                </div>
            </div>
            <div class="form-group">
                <label for="actuur_address">Factuur Adress</label>
                <i class="fas fa-thumbtack"></i>
                <input type="text" class="form-control" id="actuur_address" placeholder="Factuur Adress" name="actuur_address">
            </div>
            <div class="form-group">
                <div class="checkSubs">
                    <div class="form-check">
                        <input class="form-check-input credit-card" type="radio" name="payement" id="creditcard" onclick="show2();">
                        <label class="form-check-label" for="creditcard">
                            Credit card
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payement" id="invoice" onclick="show1();" checked>
                        <label class="form-check-label" for="invoice">
                            Invoice
                        </label>
                    </div>
                </div>
                <div class="creditCardBlock" id="payementCard">
                    <div class="payment_box">
                        <div class="form-group">
                            <label for="Card-number ">Card number <span>*</span></label>
                            <input type="text" class="form-control" id="Card-number" placeholder="1234 1234 1234 1234" name="Card-number">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="expiration-date">Expiration date <span>*</span></label>
                                <input type="date" class="form-control" id="email" placeholder="MM / AA" name="expiration-date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Visual-cryptogram">Visual cryptogram <span>*</span></label>
                                <input type="number" class="form-control" id="Visual-cryptogram" placeholder="CVC" name="Visual-cryptogram">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_trial">
                    <label class="form-check-label" for="is_trial">
                        Trial
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sendSubscrip">Start</button>
            </div>
        </form>
    </div>



 <!--   <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="<?php /*echo get_stylesheet_directory_uri();*/?>/img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row ">
            <div class="col-md-12">
                <?php /*if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ; */?>


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

                <div class="tabContentCompany">
                    <div class="tab-pane show"  id="tab1Content" class="tab">
                        <?php
/*                            if(!empty($company)) {
                                acf_form([
                                    'id' => 'edit-company-data-form',
                                    'post_id' => $company->ID,
                                    'fields' => array('company_logo', 'company_address', 'company_place', 'company_country'),
                                    'new_post' => false,
                                ]);
                            }
                        */?>
                    </div>
                    <div class="tab-pane"  id="tab2Content" class="tab">
                        <div class="bg-white mt-5 p-2 radius-custom mb-4" id="div_table" style="display:block" >

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
                                            <input type="text" class="form-control border-0" id="inputPassword" name="first_name" value="<?php /*= $current_user->first_name */?>" placeholder=""
                                            style="background: #E0EFF4" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control border-0" id="inputPassword" name="last_name" value="<?php /*= $current_user->last_name */?>" placeholder=""
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
                                            <input type="text" class="form-control border-0" id="inputPassword" name="bedrjifsnaam" value="<?php /*= $company_connected */?>" placeholder=""
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
                                            <input type="text" class="form-control border-0" id="inputPassword" name="email" value="<?php /*= $current_user->user_email */?>" placeholder=""
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
                                            <input type="text" class="form-control border-0" id="inputPassword" name="phone" value="<?php /*= $telnr */?>" placeholder=""
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


                                <div class="row d-flex justify-content-center">
                                    <button class="btn text-white" type="submit" name="starter" style="background: #00A89D"><strong>Een abonnement aanmaken</strong></button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

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



        </div>
    </div> -->

</div>