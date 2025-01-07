<?php
    global $wp;
    // $global_product_id = 9873;
    // $global_price = 5;
    // $global_mollie_key = "test_SFMrurF62JkBVuzK9gxa3b72eJQhxu";

    $url = $wp->request;
    
    $option_menu = explode('/', $url);

    $access_granted = 0;

    //User informations
    $user = wp_get_current_user();
    $company = get_field('company', 'user_' . $user->ID);
    if(!empty($company) ){
        $company = $company[0];
        $company_connected = $company->post_title;
    }

    //Team members
    $users = get_users();
    $team = 0;
    foreach($users as $infos){
        $company_value = get_field('company',  'user_' . $infos->ID);
        if(!empty($company_value)){
            $company_value_title = $company_value[0]->post_title;
            if($company_value_title == $company_connected)
                $team += 1;
        }
    }
    $instrument = null;
    /** Woocommerce API client for php - list subscriptions **/
    // $endpoint = "subscriptions";
    // $subscriptions = makeApiCallWoocommerce('https://livelearn.nl/wp-json/wc/v3/subscriptions', 'GET');
    // //Credit cards 
    // $mollie = new \Mollie\Api\MollieApiClient();
    // $mollie->setApiKey($global_mollie_key);

    // if(!empty($subscriptions)){
    //     $instrument = 'invoice';
    //     foreach($subscriptions as $row){
    //         if($row['billing']['company'] == $company_connected && $row['status'] == 'active'){
    //             $access_granted = 1;
    //             $abonnement = (Object)$row;
    //             $endpoint_order_invoice = "https://livelearn.nl/wp-json/wc/v3/subscriptions/" . $abonnement->id . "/orders";
    //             $abonnement->invoices = makeApiCallWoocommerce($endpoint_order_invoice, 'GET');        
    //             break;  

    //         } 
    //     }
    // }

    // if(!$access_granted){
    //     $mollie_subscriptions = $mollie->subscriptions->page();
    //     if($mollie_subscriptions)
    //         foreach($mollie_subscriptions as $row)
    //             if($row->metadata->company == $company_connected && $row->status == 'active'){
    //                 $access_granted = 1;
    //                 $abonnement = $row;
    //                 $instrument = 'card';
    //                 // var_dump($row);
    //                 // die();
    //                 //Payment subs
    //                 $customer = $mollie->customers->get($row->customerId);
    //                 $abonnement->cards = $customer->getSubscription($abonnement->id)->payments();
    //                 break;                
    //             }      
    // }
    
    if ( !in_array( 'hr', $user->roles ) && !in_array( 'manager', $user->roles ) && !in_array( 'administrator', $user->roles ) && $user->roles != 'administrator') 
        header('Location: /dashboard/user');

    if(isset($option_menu[2])) 
        if($option_menu[2] == 'profile-company')
            $access_granted = 1;

    if (in_array( 'administrator', $user->roles ))
        $access_granted = 1;

    if (!$access_granted)
        header('Location: /dashboard/company/profile-company');

    //Pricing changes
    $price = $global_price * $team;
    $tax_price = $price * (20/100);
    $total = $price + $tax_price;
    
    $quantity = (isset($abonnement->line_items[0]['quantity'])) ? $abonnement->line_items[0]['quantity'] : $abonnement->metadata->quantity;
    if($team != $quantity && !empty($abonnement) && $instrument == 'invoice'){
        /** Woocommerce API client for php - update subscription **/
        $endpoint_put = "https://livelearn.nl/wp-json/wc/v3/subscriptions/" . $abonnement->id;
        $data_put = [
            "line_items" => [
                [
                    "id" => $abonnement->line_items[0]['id'],
                    "product_id" => $global_product_id,
                    "quantity"   => $team,
                    "tax_class" => "",
                    "subtotal" => strval($total),
                    "subtotal_tax" => strval($tax_price),
                    "total" => strval($total),
                    "total_tax" => strval($tax_price),           
                    "sku" => "",
                    "price" => $global_price
                ],
            ],
        ];
        $abonnement = makeApiCallWoocommerce($endpoint_put, 'PUT', $data_put);
        $abonnement = (Object)$abonnement;
        // $abonnement = $woocommerce->put($endpoint_put, $data_put);
    }
    else if($team != $quantity && !empty($abonnement) && $instrument == 'card'){
        $customer_id = get_field('mollie_customer_id', 'user_' . $user->ID);
        if($customer_id){            
            $amount_pay = $global_price * $team;
            $amount_pay_vat = $amount_pay + ($amount_pay * 20/100); 
            $amount_pay_vat = strval(number_format($amount_pay_vat, 2, '.', ','));
            $data_put = [
                'amount' => [
                    'currency' => 'EUR',
                    'value' => $amount_pay_vat,
                ],
                'metadata' => [
                    'user_id' => $user->ID,
                    'company' => $company_connected,
                    'quantity' => $team
                ]
            ];
            // var_dump($data_put);
            $endpoint_pay = "https://api.mollie.com/v2/customers/" . $customer_id . "/subscriptions" . "/" . $abonnement->id ;
            $abonnement = (Object)makeApiCallMollie($endpoint_pay, $data_put, "POST")[0];
        }
    }

?>
<style>
    .btn-show-sidbar{
        margin-bottom: 20px;
    }
</style>
<section id="sectionDashboard1" class="sidBarDashboard sidBarDashboardIndividual" name="section1"
    style="overflow-x: hidden !important;">
    <button class="btn btn-close-sidbar">
        <i class="fa fa-close"></i>
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
                            if($option_menu[2] == 'profile-company') echo '<span><b>Subscription</b></span>'; else echo '<span>Subscription</span>';
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>