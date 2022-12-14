<?php
$current_user = wp_get_current_user();
$company = get_field('company', 'user_' . $current_user->ID);
if(!empty($company) ){
    $company = $company[0];
    $company_connected = $company->post_title;
}

$telnr = get_field('telnr', 'user_' . $current_user->ID);

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

                        <form method="POST" action="/dashboard/company/profile-company/" class="">

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