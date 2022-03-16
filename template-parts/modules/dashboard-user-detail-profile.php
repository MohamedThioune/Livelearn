
<div class="contentProfil ">
    <div class="blockgeneralPersoo2">
        <div class="detailNamePhoto">
            <a href="" class="settingDetail">
                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/iconeSettings.png" alt="">
            </a>
            <div class="photoBlock">
                <img src="<?php echo $image ?>" width="65px" alt="">
            </div>
            <p class="nameTextProfil"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name; ?></p>
            <p class="oprichter"><?php echo $biographical_info ?></p>
        </div>
        <div class="globalCertificationBlock">
            <div class="BlockCertifiation">
                <p class="titleCertification">Certificaten</p>
                <div class="elementCertifications">
                    <div class="iconeBlock">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                    </div>
                    <p class="textCertification">Basisopleiding workplace management</p>
                </div>
                <div class="elementCertifications">
                    <div class="iconeBlock">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                    </div>
                    <p class="textCertification">Basisopleiding workplace management</p>
                </div>
                <div class="elementCertifications">
                    <div class="iconeBlock">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                    </div>
                    <p class="textCertification">Basisopleiding workplace management</p>
                </div>
                <div class="elementCertifications">
                    <div class="iconeBlock">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                    </div>
                    <p class="textCertification">Basisopleiding workplace management</p>
                </div>
                <div class="elementCertifications">
                    <div class="iconeBlock">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                    </div>
                    <p class="textCertification">Basisopleiding workplace management</p>
                </div>
                <div class="elementCertifications">
                    <div class="iconeBlock">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                    </div>
                    <p class="textCertification">Basisopleiding workplace management</p>
                </div>
                <div class="elementCertifications">
                    <div class="iconeBlock">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" alt="">
                    </div>
                    <p class="textCertification">Basisopleiding workplace management</p>
                </div>
            </div>
            <div class="BlockCertifiation">
                <div class="elementSkills">
                    <p class="titleCertification">Skills</p>
                </div>
                <div class="elementCertifications elementCertifications1">
                    <p class="textCertification">Sales</p>
                    <div class="ratingElement">
                        <div class="rating-bar rating-barActive"></div>
                        <div class="rating-bar rating-barActive"></div>
                        <div class="rating-bar rating-barActive"></div>
                        <div class="rating-bar"></div>
                        <div class="rating-bar"></div>
                    </div>
                </div>
                <div class="elementCertifications elementCertifications1">
                    <p class="textCertification">Workplace management</p>
                    <div class="ratingElement">
                        <div class="rating-bar rating-barActive"></div>
                        <div class="rating-bar rating-barActive"></div>
                        <div class="rating-bar rating-barActive"></div>
                        <div class="rating-bar"></div>
                        <div class="rating-bar"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</div>
