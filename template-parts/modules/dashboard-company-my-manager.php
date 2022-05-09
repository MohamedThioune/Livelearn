<?php

extract($_POST);

$image = get_field('profile_img',  'user_' . $manager);
$company = get_field('company',  'user_' . $manager);
$grade = get_field('grade',  'user_' . $manager);
$interval = [1 => 'General Director',  2 => 'Director System Information', 3 => 'Project Manager'];
$biographical_info = get_field('biographical_info',  'user_' . $manager);

$manager = get_users(array('include'=> $manager))[0]->data;



?>
<div class="contentProfil ">
    <div class="blockgeneralPersoo2">
        <div class="detailNamePhoto">
            <a href="" class="settingDetail">
                <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/iconeSettings.png" alt="">
            </a>
            <h1 class="btn btn-info">Your manager</h1><br>

            <div class="photoBlock">
                <img src="<?php echo $image ?>" width="65px" alt="">
            </div>
            <p class="nameTextProfil"><?php if(isset($manager->first_name) && isset($manager->last_name)) echo $manager->first_name . '' . $manager->last_name; else echo $manager->display_name; ?></p>
            <p class="oprichter"><?php echo $biographical_info ?></p>
            <p class="nameTextProfil" ><?php echo $interval[$grade] ?></p>
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
