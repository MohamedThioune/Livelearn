<?php
$user = get_user_by('ID', $id_user);
$number_portfolios = 0;
if (!empty($portfolios))
    $number_portfolios = count($portfolios);
?>
<div class="contentPassport profilUserP">
    <div class="headPassport">
        <div class="blockImageCandidat">
            <img src="<?php echo $image; ?>" alt="">
        </div>
        <p class="nameCandidat"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . ' ' . $user->last_name; else echo $user->display_name; ?></p>
        <p class="professionCandidat"><?php echo $function; ?></p>
           <div class="d-flex justify-content-between align-items-center w-100">
               <div class="contentElementHeadCandidat">
                   <div class="contentTag">
                       <!-- <?php foreach($topics as $topic){
                           $name = (String)get_the_category_by_ID($topic);
                           ?>
                    <p class="tagElement"></p>
                <?php }?>
                <?php foreach($experts as $expert){
                           $expert = get_userdata($expert)->data->display_name;
                           ?>
                    <p class="tagElement"></p>
                <?php }?> -->
                   </div>
                   <div class="contentMapMember">
                       <div class="contentMap">
                           <?php if($country) { ?>
                               <img src="<?php echo get_stylesheet_directory_uri();?>/img/iconsMap.png" alt="">
                               <p><?php echo $country; ?></p>
                           <?php } ?>
                       </div>
                       <div href="" class="">
                           <i style="color:#696969;font-size: 1.2em" class="fa fa-home"></i>&nbsp;
                           <a href="/dashboard/company/people"><?php echo $company_name; ?></a>
                       </div>
                   </div>
               </div>
               <?php
               if($user->ID == get_current_user_id())
                   echo "<a href='/dashboard/user/settings' class='btn btndoawnloadCv' style='color:white;'><i class='fa fa-gear'></i>Edit</a>";
               else
                   echo "<a class='btn btndoawnloadCv' href='#'>Download CV</a>";
               ?>
           </div>

        </div>


    </div>
    <div class="detailContentCandidat">
        <div class="fistBlock">
           <div class="categorieDetailCandidat">
               <h2 class="titleCategorieDetailCandidat">About</h2>
               <p class="textDetailCategorie"><?php echo $biographical_info;  ?></p>
           </div>
           <?php if(!empty($topics)){ ?>
            <div class="categorieDetailCandidat skills">
                <div class="headcategorieCandidat">
                    <h2 class="titleCategorieDetailCandidat">Skills</h2>
                    <div>
                        <button class="btn showPassport"  id="show-more1">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/down-chevron-skills.png" alt="">
                        </button>
                        <button class="btn showPassport"  id="show-less1">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/down-chevron-skills.png" alt="">
                        </button>
                    </div>
                </div>
                <?php 
                foreach($topics_user as $value){ 
                    $topic = get_the_category_by_ID($value);
                    $note = 0;
                    if(!$topic)
                        continue;
                    if(!empty($skills_note))
                        foreach($skills_note as $skill)
                            if($skill['id'] == $value)
                                $note = $skill['note'];
                    $name_topic = (String)$topic;    
                ?>
                    <div class="skillbars">
                        <label class="skillName"><?php echo $name_topic;  ?></label>
                        <div class="progress" data-fill="<?= $note ?>" >
                        </div>
                        <div class="bg-gris-Skills"></div>
                    </div>
               <?php } ?>
              
            </div>
           <?php }?>
            <div class="categorieDetailCandidat">
                <h2 class="titleCategorieDetailCandidat">Education</h2>
                <?php
                    if($educations)
                    if(!empty($educations))
                    foreach($educations as $value) { 
                        $value = explode(";", $value);
                        if(isset($value[2]))
                            $year = explode("-", $value[2])[0];
                        if(isset($value[3]))
                            if(intval($value[2]) != intval($value[3])) 
                                $year = $year . "-" .  explode("-", $value[3])[0];
                    ?>
                    <div class="contentEducationCandidat">
                        <div class="titleDateEducation">
                            <p class="titleCoursCandiddat"><?php echo $value[1]; ?></p>
                            <?php if($year) { ?>
                                <p class="dateCourCandidat"><?php echo $year; ?></p>
                            <?php } ?>
                        </div>
                        <p class="schoolCandidat"><?php echo $value[0]; ?></p>
                        <p class="textDetailCategorie"><?php echo $value[4]?: ''; ?></p>
                    </div>
               <?php } ?>

            </div>
            <div class="categorieDetailCandidat workExperiece">
                <h2 class="titleCategorieDetailCandidat ex">Work & Experience</h2>
                
                <?php
                    if($experiences)
                    if(!empty($experiences))
                    foreach($experiences as $value) { 
                        $value = explode(";", $value);
                        if(isset($value[2]))
                            $year = explode("-", $value[2])[0];
                        if(isset($value[3]))
                            if(intval($value[2]) != intval($value[3])) 
                                $year = $year . "-" .  explode("-", $value[3])[0];
                    ?>
                    <div class="contentEducationCandidat">
                        <div class="titleDateEducation">
                            <p class="titleCoursCandiddat"><?php echo $value[1]; ?></p>
                            <?php if($year) { ?>
                                <p class="dateCourCandidat"><?php echo $year; ?></p>
                            <?php } ?>
                        </div>
                        <p class="schoolCandidat"><?php echo $value[0]; ?></p>
                        <p class="textDetailCategorie"><?php echo $value[4]?: '' ?> </p>
                    </div>
               <?php } ?>
            </div>
            <div class="categorieDetailCandidat awards">
                <h2 class="titleCategorieDetailCandidat ex">Portfolio</h2>
                  
                    <div class="contentEducationCandidat">
                        <div class="titleDateEducation">
                            <p class="projetsText"><span><?= $number_portfolios ?></span>Projets</p>
                        </div>
                        <?php
                            if($portfolios)
                            if(!empty($portfolios))
                            foreach($portfolios as $value) { 
                                $value = explode(";", $value);
                            ?>
                        <p class="titleCoursCandiddat"><?php echo $value[0]; ?> </p>
                        <p class="textDetailCategorie"><?php echo $value[1]; ?> </p>
                        <a href="" class="seeProject">See project</a>
                        <?php } ?>
                    </div>
              
            </div>
            <div class="categorieDetailCandidat awards">
                <h2 class="titleCategorieDetailCandidat ex">Awards</h2>
                <?php
                    if($awards)
                    if(!empty($awards))
                    foreach($awards as $value) { 
                        $value = explode(";", $value);
                        if(isset($value[2]))
                            $year = explode("-", $value[2])[0];
                        if(isset($value[3]))
                            if(intval($value[2]) != intval($value[3])) 
                                $year = $year . "-" .  explode("-", $value[3])[0];
                    ?>
                    <div class="contentEducationCandidat">
                        <div class="titleDateEducation">
                            <p class="titleCoursCandiddat"><?php echo $value[0]; ?> </p>
                            <?php if($year) { ?>
                                <p class="dateCourCandidat"><?php echo $year; ?></p>
                            <?php } ?>
                        </div>
                        <p class="textDetailCategorie"><?php echo $value[1]; ?></p>
                    </div>
               <?php } ?>

            </div>
        </div>
        <div class="seconfBlock">
            <div class="otherSkills">
                <?php if($experience){ ?>
                <div class="elementOtherSkills">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calendar1.png" alt="">
                   
                    <div>
                        <p class="nameOtherSkill">Experience</p>
                        <p class="DetailOtherSkill"><?php echo $experience; ?> Years</p>
                    </div>
                </div>
                <?php } if(isset($age)){ ?>
                <div class="elementOtherSkills">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/waiting1.png" alt="">
                    <div>
                        <p class="nameOtherSkill">Age</p>
                        <p class="DetailOtherSkill"><?php echo $age; ?></p>
                    </div>
                </div>
                <?php } if($gender){ ?>
                <div class="elementOtherSkills">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/userLive.png" alt="">
                    <div>
                        <p class="nameOtherSkill">Gender</p>
                        <p class="DetailOtherSkill"><?php echo $gender; ?></p>
                    </div>
                </div>
                <?php } if($languages){ ?>
                <div class="elementOtherSkills">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/translation1.png" alt="">
                    <div>
                        <p class="nameOtherSkill">Language</p>
                        <p class="DetailOtherSkill">
                            <?php foreach($languages as $key => $language){ 
                                echo $language; 
                                if(isset($languages[$key+1])) 
                                    echo ", "; 
                                } ?>
                        </p>
                    </div>
                </div>
                <?php } if($education_level){ ?>
                <div class="elementOtherSkills">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mortarboard1.png" alt="">
                    <div>
                        <p class="nameOtherSkill">Education Level</p>
                        <p class="DetailOtherSkill"><?php echo $education_level; ?> Degree</p>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="socialBlock">
                <p class="titleSocialBlock">Social media</p>
                <div class="contentIconeSocial">
                    <?php if($facebook){ ?>
                    <a href="<?php echo $facebook; ?>" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoLfacebook.png" alt="">
                    </a>
                    <?php } if($twitter){ ?>
                    <a href="<?php echo $twitter; ?>"  target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoLtwitter.png" alt="">
                    </a>
                    <?php } if($linkedin){ ?>
                    <a href="<?php echo $linkedin; ?>"  target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoLLinkedin.png" alt="">
                    </a>
                    <?php } if($instagram){ ?>
                    <a href="<?php echo $instagram; ?>" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoLInsta.png" alt="">
                    </a>
                    <?php } ?>
                    <?php if($discord){ ?>
                    <a href="<?php echo $discord; ?>" target="_blank">
                        D<img src="<?php echo get_stylesheet_directory_uri();?>/img/.png" alt="">
                    </a>
                    <?php } ?>
                    <?php if($tik_tok){ ?>
                    <a href="<?php echo $tik_tok; ?>" target="_blank">
                        T<img src="<?php echo get_stylesheet_directory_uri();?>/img/.png" alt="">
                    </a>
                    <?php } ?>
                    <?php if($stackoverflow){ ?>
                    <a href="<?php echo $stackoverflow; ?>" target="_blank">
                        S<img src="<?php echo get_stylesheet_directory_uri();?>/img/.png" alt="">
                    </a>
                    <?php } ?>
                    <?php if($github){ ?>
                    <a href="<?php echo $github; ?>" target="_blank">
                        G<img src="<?php echo get_stylesheet_directory_uri();?>/img/.png" alt="">
                    </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Readmore.js/2.0.2/readmore.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    class ProgressBar{
        constructor(progressBar, fill, skillName){
            this.progressBar = progressBar;
            this.skillName = skillName
            this.fill = fill;
            this.speed = 15; //Speed of the fill, increasing it will slow down
            this.actual = 0;
            this.filling();
        }
        filling(){
            if( this.actual < this.fill){
                this.progressBar.style.width = String(this.actual++)+"%";
                this.progressBar.innerHTML = this.skillName+String(this.actual)+"%";
                setTimeout(() => this.filling(), this.speed);
            }
            else{
                return;
            }
            return;
        }
    }

    let options = {
        threshold: 0 // value from 0 to 1.0, stablishes the porcentage of the bar that need to be displayed before launching the animation
    }

    var progressBars = document.querySelectorAll('.progress');
    let observer = new IntersectionObserver((progressBars) => {
        progressBars.forEach( progressBar => {
            if(progressBar.isIntersecting ){
                let fill = progressBar.target.getAttribute('data-fill');
                let skillName = progressBar.target.innerHTML;
                new ProgressBar(progressBar.target, fill, skillName);
                observer.unobserve(progressBar.target);
            }
        });

    }, options);

    progressBars.forEach( progressBar => observer.observe(progressBar));

</script>