
<!-- MDB -->
<!-- <link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css"
  rel="stylesheet"
/> -->
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
    <div class="row d-flex justify-content-center">
        <div class="col-md-7 col-10">
          
            <!-- Tabs navs -->
            <ul class="nav nav-tabs nav-fill mb-3 bg-white rounded" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active rounded mx-0 border-0" id="ex2-tab-1" data-mdb-toggle="tab" href="#ex2-tabs-1"
                        role="tab" aria-controls="ex2-tabs-1" aria-selected="true">
                        
                        <h6> Algemene bedrijfsinformatie  </h6>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link rounded mx-0 border-0 bg-white" id="ex2-tab-2" data-mdb-toggle="tab" href="#ex2-tabs-2"
                        role="tab" aria-controls="ex2-tabs-2" aria-selected="false"> 
                        <h6>Financiêle informatie  </h6> 
                    </a>    
                </li>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex2-content">
                <div class="tab-pane fade show active" id="ex2-tabs-1" role="tabpanel" aria-labelledby="ex2-tab-1">
                    <?php
                        $current_user = wp_get_current_user();
                        $company = get_field('company', 'user_'.$current_user->ID);

                        if(is_array($company) && !empty($company) && $company[0] instanceof WP_Post) {
                            $company = $company[0];

                            acf_form([
                                'id' => 'edit-company-data-form',
                                'post_id' => $company->ID,
                                'field_groups' => [408],
                                'new_post' => false,
                            ]);
                        }
                    ?>
                </div>
                <div class="tab-pane fade" id="ex2-tabs-2" role="tabpanel" aria-labelledby="ex2-tab-2">
                    <div class="bg-white mt-5 p-2 radius-custom mb-4" id="div_table" style="display:block" >  
                        <!-- <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div> -->
                        <div class="d-flex justify-content-between w-100 border-bottom border-5 pb-2">
                            <div class="h5 pt-2"><strong>Buget Livelearn team</strong></div>
                            <div><i class="fa fa-gear fa-2x pt-1"></i></div>
                        </div>

                        <form class="">

                            <div class="form-group py-4">
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
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Factuuradres</strong></label>
                                    </div>
                                    <div class="col-md-8 pt-2">
                                        <input type="text" class="form-control border-0" id="inputPassword" 
                                            placeholder="" style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Contactpersoon</strong></label>
                                    </div>
                                    <div class="col-md-8 pt-2">
                                        <input type="text" class="form-control border-0" id="inputPassword" 
                                            placeholder="" style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">
                                            <strong class="h5">Credicardgegevents   </strong></label>
                                    </div>
                                    <div class="col-md-8 pt-2">
                                        <input type="text" class="form-control border-0" id="inputPassword" 
                                            placeholder="" style="background: #E0EFF4">
                                    </div>
                                </div>
                            </div>  

                            <div class="row d-flex justify-content-center">
                                    <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                    <button class="btn text-white" style="background: #00A89D"><strong>Naar bedrijfsniveau</strong></button>
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
            </div> -->
        </div>
        <div class="col-md-5"></div>
    </div>
</div>

<!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"
></script>