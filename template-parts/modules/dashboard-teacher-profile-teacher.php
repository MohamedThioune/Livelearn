
<div class="contentProfil ">
    <div class="blockSidbarMobile blockSidbarMobile2">
        <div class="zijbalk">
            <p class="zijbalkMenu">zijbalk menu</p>
            <button class="btn btnSidbarMob">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt="">
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 col-md-8">
            <div class="blockgeneralPersoo">
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
                                   <img src="<?= $image; ?>" alt="">
                               </div>
                                <div class="blockTilteName">
                                    <p class="name"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name; ?></p>
                                </div>
                            </a>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"><?= $company; ?></p>
                            </div>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"><?= get_field('role', 'user_'.$user->ID); ?></p>
                            </div>
                            <div class="blockDetailprofil">
                                <div class="iconeBlock">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                </div>
                                <p class="TextDetail"><?= $user->user_email;?></p>
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
                                <p class="TextDetail"><?= get_field('telnr', 'user_'.$user->ID); ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- 
                        <div class="blockPersoonlijke">
                            <div class="headPersoon">
                                <p class="titleHeadPersoon">Persoonlijke financien</p>
                                <a href="" class="iconeSetting">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/iconeSettings.png" alt="">
                                </a>
                            </div>
                            <div class="contentPersoon">
                                <div class="blockDetailprofil topElement">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail">Betaling (ideal, creditcard)</p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail">Rekeningnummer </p>
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
                                    <p class="TextDetail"></p>
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
                                    <div class="flexJusElement">
                                        <p class="TextDetail"><b>€26.59</b></p>
                                        <a href="" class="btnOpwaa">Opwaarderen</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="blockPersoonlijke">
                            <div class="headPersoon">
                                <p class="titleHeadPersoon">Onderwerpen</p>
                                <a href="" class="iconeSetting">
                                    <img  src="<?php echo get_stylesheet_directory_uri();?>/img/iconeSettings.png" alt="">
                                </a>
                            </div>
                            <div class="contentPersoon">
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Verkoop en sales </p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Marktkoopman </p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Excel </p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Beleggen </p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Exact Online </p>
                                </div>
                                <a href="" class="btnBekijk">Bekijk alle onderwerpen</a>
                            </div>
                        </div>
                        <div class="blockPersoonlijke">
                            <div class="headPersoon">
                                <p class="titleHeadPersoon">Opleiders / Experts</p>
                                <a href="" class="iconeSetting">
                                    <img  src="<?php echo get_stylesheet_directory_uri();?>/img/iconeSettings.png" alt="">
                                </a>
                            </div>
                            <div class="contentPersoon">
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Livelearn</p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Marktkoopman --></p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Excel </p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Beleggen </p>
                                </div>
                                <div class="blockDetailprofil">
                                    <div class="iconeBlock">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                                    </div>
                                    <p class="TextDetail"><!-- Exact Online </p>
                                </div>
                                <a href="" class="btnBekijk">Bekijk alle opleiders / experts</a>
                            </div>
                        </div>
                    -->
                </div>
                <!-- 
                    <div class="blockAlle">
                        <div class="AllActiviteiten">
                            <div class="headPersoon">
                                <p class="titleHeadPersoon">All activiteiten en certificaten </p>
                                <a href="" class="iconeSetting">
                                    <img  src="<?php echo get_stylesheet_directory_uri();?>/img/iconeSettings.png" alt="">
                                </a>
                            </div>
                            <div class="contentPersoon">
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
                                    <p class="TextDetail"></p>
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
                                    <p class="TextDetail"></p>
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
                                    <p class="TextDetail"></p>
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
                                    <p class="TextDetail"></p>
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
                                    <p class="TextDetail"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                -->
            </div>
        </div>
    </div>
</div>

