<?php

$current_user = wp_get_current_user();

if(!in_array('administrator', $current_user->roles) && !in_array('hr', $current_user->roles)) 
    header('Location: /dashboard/company/');

$company = get_field('company', 'user_' . $current_user->ID);
if(!empty($company) ){
    $company = $company[0];
    $company_connected = $company->post_title;
}

$telnr = get_field('telnr', 'user_' . $current_user->ID);
?>

<div class="contentProfil ">

    <h1 class="titleSubscription">Subscription</h1>
    <center><?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>"?></center>
    <div class="contentFormSubscription">
        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">First name</label>
                    <i class="fas fa-user" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="first_name" value="<?= $current_user->first_name ?>" aplaceholder="First name" name="first_name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Last name</label>
                    <i class="fas fa-users" aria-hidden="true"></i>
                    <input type="text" class="form-control" id="last_name" value="<?= $current_user->last_name ?>" placeholder="Last name" name="last_name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="bedrjifsnaam">Company Name</label>
                <i class="fas fa-building" aria-hidden="true"></i>
                <input type="text" class="form-control" id="bedrjifsnaam" value="<?= $company_connected ?>" placeholder="Bedrjifsnaam" name="bedrjifsnaam" required>
            </div>
            <div class="form-group">
                <label for="city">Company place</label>
                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                <input type="text" class="form-control" id="city" value="" placeholder="City" name="city">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <input type="email" class="form-control" id="email" value="<?= $current_user->user_email ?>" placeholder="Email" name="email" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">Phone number</label>
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <input type="number" class="form-control" id="phone" value="<?= $telnr ?>" placeholder="Phone number" name="phone" required>
                </div>
            </div>
            <div class="form-group">
                <label for="actuur_address">Factuur Adress</label>
                <i class="fas fa-thumbtack"></i>
                <input type="text" class="form-control" id="actuur_address" value="" placeholder="Factuur Adress" name="factuur_address">
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
                    <input class="form-check-input" type="checkbox" id="is_trial" checked>
                    <label class="form-check-label" for="is_trial">
                        Trial
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="starter" class="btn btn-sendSubscrip">Start</button>
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