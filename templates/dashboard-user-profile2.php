<?php

$user = get_users(array('include'=> get_current_user_id()))[0]->data;

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';

$company = get_field('company',  'user_' . $user->ID);
$function = get_field('role',  'user_' . $user->ID);

$biographical_info = get_field('biographical_info',  'user_' . $user->ID);

if(!empty($company))
    $company = $company[0]->post_title;

/*
* * Get interests topics and experts
*/

$topics = get_user_meta($user->ID, 'topic');
$experts = get_user_meta($user->ID, 'expert');

/*
* * End
*/

?>

<div class="contentProilView">
    <div id="profilVIewDetail" class="detailContentCandidat">
        <div class="fistBlock">
            <div class="layout--tabs">
                <div class="">
                    <div class="nav-tabs-wrapper">
                        <ul class="nav nav-tabs" id="tabs-title-region-nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-1" aria-selected="false" aria-controls="block-simple-text-1" id="block-simple-text-1-tab">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-2" aria-selected="false" aria-controls="block-simple-text-2" id="block-simple-text-2-tab">Skills</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-3" aria-selected="false" aria-controls="block-simple-text-3" id="block-simple-text-3-tab">Certificates</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-4" aria-selected="false" aria-controls="block-simple-text-4" id="block-simple-text-4-tab">Feedback</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-5" aria-selected="false" aria-controls="block-simple-text-5" id="block-simple-text-5-tab">Statistics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-6" aria-selected="false" aria-controls="block-simple-text-6" id="block-simple-text-6-tab">Internal growth</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" role="tab" href="#block-simple-text-7" aria-selected="false" aria-controls="block-simple-text-7" id="block-simple-text-7-tab">External growth</a>
                            </li>

                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="block-simple-text-1" class="tab-pane active block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-1-tab">
                                    <?php if(isset($_GET['message'])) if($_GET['message']) echo "<span class='alert alert-success alert-dismissible fade show' role='alert'>" . $_GET['message'] . "</span>"; ?><br><br>
                                    <div class="overviewFirstBlock">
                                        <div class="blockImageCandidat">
                                            <img src="<?php echo $image;?>" alt="">
                                        </div>
                                        <div class="overviewSecondBlock">
                                            <p class="professionCandidat"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name?>
                                            <p class="professionCandidat"><?php echo $user->email; ?></p>
                                            <?php if($country) { ?>
                                                <p class="professionCandidat"><?php echo $country; ?></p>
                                            <?php } ?>
                                        </div>
                                        <div class="overviewTreeBlock">
                                            <p class="titleOvervien">Manager : <span><?php if(isset($manager->first_name) && isset($manager->last_name)) echo $manager->first_name . '' . $manager->last_name; else echo $manager->display_name; ?></span></p>
                                            <p class="titleOvervien">Company : <span><?php echo $company; ?></span></p>
                                        </div>
                                        <br>
                                        <div class="overviewFourBlock">
                                            <?php if($experience){ ?>

                                                <div class="d-flex">
                                                    <p class="nameOtherSkill">Experience : <span><?php echo $experience; ?></span></p>
                                                </div>
                                            <?php } if($languages){ ?>

                                                <div class="d-flex">
                                                    <p class="nameOtherSkill">Language :
                                                        <span>
                                                        <?php
                                                        foreach($languages as $key => $language){
                                                            echo $language;
                                                            if(isset($languages[$key+1]))
                                                                echo ", ";
                                                        }
                                                        ?>
                                                    </span>
                                                    </p>
                                                </div>
                                                <br>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="categorieDetailCandidat">
                                        <h2 class="titleCategorieDetailCandidat">Candidates About bio</h2>
                                        <p class="textDetailCategorie"><?php echo $biographical_info;  ?></p>
                                    </div>
                                    <div class="categorieDetailCandidat">
                                        <h2 class="titleCategorieDetailCandidat">Education</h2>
                                        <?php
                                        if($educations)
                                            if(!empty($educations))
                                                foreach($educations as $value) {
                                                    $value = explode(";", $value);
                                                    $year_start = explode("-", $value[2])[0];
                                                    $year_end = explode("-", $value[3])[0];
                                                    if($year_start && !$year_end)
                                                        $year = $year_start;
                                                    else if($year_end && !$year_start)
                                                        $year = $year_end;
                                                    else if($year_end != $year_start)
                                                        $year = $year_start .'-'. $year_end;
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
                                                    $year_start = explode("-", $value[2])[0];
                                                    $year_end = explode("-", $value[3])[0];
                                                    if($year_start && !$year_end)
                                                        $year = $year_start;
                                                    else if($year_end && !$year_start)
                                                        $year = $year_end;
                                                    else if($year_end != $year_start)
                                                        $year = $year_start .'-'. $year_end;

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
                                </div>
                                <div id="block-simple-text-2" class="tab-pane  block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-2-tab">

                                    <h2 class="titleCategorieDetailCandidat">Skills</h2>
                                    <?php foreach($topics as $topic){
                                        $name = (String)get_the_category_by_ID($topic);
                                        ?>
                                        <div class="skillBar">
                                            <label for=""><?php echo $name;  ?></label>
                                            <div data-progress="react" data-value="<?php rand(5, 100); ?>">
                                                    <span class="progress">
                                                        <span id="react" class="progress-bar orange"></span>
                                                    </span>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <p class="textDetailCategorie">we do not have statistics at this time </p>

                                </div>
                                <div id="block-simple-text-3" class="tab-pane  block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-3-tab">

                                    <div class="categorieDetailCandidat workExperiece">
                                        <h2 class="titleCategorieDetailCandidat ex">Certificates</h2>
                                        <?php
                                        if($awards)
                                            if(!empty($awards))
                                                foreach($awards as $value) {
                                                    $value = explode(";", $value);
                                                    $year_start = explode("-", $value[2])[0];
                                                    $year_end = explode("-", $value[3])[0];
                                                    if($year_start && !$year_end)
                                                        $year = $year_start;
                                                    else if($year_end && !$year_start)
                                                        $year = $year_end;
                                                    else if($year_end != $year_start)
                                                        $year = $year_start .'-'. $year_end;
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

                                <div id="block-simple-text-4" class="tab-pane  block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-4-tab">
                                    <h2 class="titleCategorieDetailCandidat ex">Feedback</h2>
                                    <p class="textDetailCategorie">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
                                </div>
                                <div id="block-simple-text-5" class="tab-pane  block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-4-tab">
                                    <h2 class="titleCategorieDetailCandidat ex">Statistic</h2>
                                    <p class="textDetailCategorie">we do not have statistics at this time </p>
                                </div>
                                <div id="block-simple-text-6" class="tab-pane  block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-4-tab">
                                    <h2 class="titleCategorieDetailCandidat ex">Groei intern</h2>
                                    <div class="form-group formModifeChoose">

                                        <select class="multipleSelect2" multiple="true">
                                            <option value="1">Excellent</option>
                                            <option value="2">Very Good</option>
                                            <option value="3">Good</option>
                                            <option value="4">Not Bad</option>
                                            <option value="5">Bad</option>
                                            <option value="6">Very Bad</option>
                                        </select>
                                    </div>
                                    <div class="inputGroein">
                                        <p>Chinoi</p>
                                        <p>Chinoi</p>
                                        <p>Chinoi</p>
                                    </div>
                                </div>
                                <div id="block-simple-text-7" class="tab-pane  block block-layout-builder block-inline-blockqfcc-blocktype-simple-text" role="tabpanel" aria-labelledby="block-simple-text-4-tab">
                                    <h2 class="titleCategorieDetailCandidat ex">Groei extern</h2>
                                    <div class="form-group formModifeChoose">

                                        <select class="multipleSelect2" multiple="true">
                                            <option value="1">Excellent</option>
                                            <option value="2">Very Good</option>
                                            <option value="3">Good</option>
                                            <option value="4">Not Bad</option>
                                            <option value="5">Bad</option>
                                            <option value="6">Very Bad</option>
                                        </select>
                                    </div>
                                    <div class="inputGroein">
                                        <p>Chinoi</p>
                                        <p>Chinoi</p>
                                        <p>Chinoi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="seconfBlock">
            <div class="otherSkills">
                <button class="btn btnAddToDo"  data-toggle="modal" data-target="#exampleModalWork">Add to do</button>
                <?php
                if($todos)
                    if(!empty($todos))
                        foreach($todos as $todo) {
                            $value = explode(";", $todo);
                            $image = get_field('profile_img',  'user_' . $manager->ID);
                            $manager = get_users(array('include'=> $value[2]))[0]->data;
                            if(!$image)
                                $image = get_stylesheet_directory_uri() . '/img/Group216.png';
                            ?>
                            <div class="activiteRecent">
                                <img width="25" src="<?php echo $image ?>" alt="">
                                <div class="contentRecentActivite">
                                    <p class="titleActivite"><?php echo $value[0] ;?> by <span style="font-weight:bold"><?php if(isset($manager->first_name) && isset($manager->first_name)) echo $manager->first_name .' '. $manager->first_name; else echo $manager->display_name; ?></span></p>
                                    <p class="activiteRecent"><?php echo $value[1]; ?></p>
                                </div>
                            </div>
                        <?php } ?>

            </div>
        </div>

    </div>
    <!-- Modal  -->
    <div class="modal modalEdu fade show" id="exampleModalWork" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="firstBlockVoeg">
                            <h2 class="voegToeText">Voeg toe</h2>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="boxVoeg" id="boxVoeg1">
                                        <div class="imgoxVoeg">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/feedback.png" alt="">
                                        </div>
                                        <p class="titleBoxVoeg">Feedback</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="boxVoeg" id="boxVoeg2">
                                        <div class="imgoxVoeg">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/personal-development.png" alt="">
                                        </div>
                                        <p class="titleBoxVoeg">Persoonlijk Ontwikkelplan</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="boxVoeg" id="boxVoeg3">
                                        <div class="imgoxVoeg">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/personal-development2.png" alt="">
                                        </div>
                                        <p class="titleBoxVoeg">Beoordeling Gesprek</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="boxVoeg" id="boxVoeg4">
                                        <div class="imgoxVoeg">
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/conversation.png" alt="">
                                        </div>
                                        <p class="titleBoxVoeg">Compliment</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="secondBlockVoeg">
                            <h2 class="voegToeText">Voeg toe</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Title feedback</label>
                                    <input name="title" type="text">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Onderwerp feedback</label>
                                    <div class="form-group formModifeChoose">
                                        <select id="form-control-skills" class="multipleSelect2" multiple="true">
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Beschrijving</label>
                                    <textarea name="commentary" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <button class="btn btnSaveSetting" name="add_work" >Save</button>
                            </div>
                        </div>
                        <div class="treeBlockVoeg">
                            <h2 class="voegToeText">Persoonlijk ontwikkelplan</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Title persoonlijk ontwikwikkelplan</label>
                                    <input name="title" type="text">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Onderwerp PoP</label>
                                    <div class="form-group formModifeChoose">
                                        <select id="form-control-skills" class="multipleSelect2" multiple="true">
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Wat wil je bereiken ?</label>
                                    <textarea name="commentary" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Hoe ga je dit bereiken ?</label>
                                    <textarea name="commentary" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Heb je hierbij hulp nodig ?</label>
                                    <textarea name="commentary" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Heb je hierbij hulp nodig ?</label>
                                    <div class="d-flex">
                                        <div class="mr-3">
                                            <input type="radio" id="JA" name="hulp" value="JA">
                                                <label for="JA">JA</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="NEE" name="hulp" value="NEE">
                                                <label for="NEE">NEE</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Opmerkingen ?</label>
                                    <textarea name="commentary" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <button class="btn btnSaveSetting" name="add_work" >Save</button>
                            </div>
                        </div>
                        <div class="fourBlockVoeg">
                            <div class="sousBlockFourBlockVoeg1">
                                <h2 class="voegToeText">Beoordelingsgesprek</h2>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Title Beoordelingsgesprek</label>
                                        <input name="title" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Cijfers interne groei</label>
                                        <div class="bloclCijfers">
                                            <p class="mb-0" style="width: 20%;">Sales</p>
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5" />
                                                <label class="ma_link" for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4" />
                                                <label class="ma_link" for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3" />
                                                <label class="ma_link" for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2" />
                                                <label class="ma_link" for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1" />
                                                <label class="ma_link" for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                        <div class="bloclCijfers">
                                            <p class="mb-0" style="width: 20%;">Feedback geven25</p>
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5" />
                                                <label class="ma_link" for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4" />
                                                <label class="ma_link" for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3" />
                                                <label class="ma_link" for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2" />
                                                <label class="ma_link" for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1" />
                                                <label class="ma_link" for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <input type="button" value="Volgende" class="btn btnSaveSetting" id="volgende1">
                                </div>
                            </div>
                            <div class="sousBlockFourBlockVoeg2">
                                <h2 class="voegToeText">Beoordelingsgesprek</h2>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <div class="bloclCijfers">
                                            <p class="mb-0" >Sales</p>
                                            <div class="rate">
                                                <input type="radio" id="star5" name="rate" value="5" />
                                                <label class="ma_link" for="star5" title="text">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4" />
                                                <label class="ma_link" for="star4" title="text">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3" />
                                                <label class="ma_link" for="star3" title="text">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2" />
                                                <label class="ma_link" for="star2" title="text">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1" />
                                                <label class="ma_link" for="star1" title="text">1 star</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Sales toelichting</label>
                                        <textarea name="commentary" id="" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="">
                                    <input type="button" value="Volgende" class="btn btnSaveSetting" id="volgende2">
                                </div>
                            </div>
                            <div class="sousBlockFourBlockVoeg3">
                                <h2 class="voegToeText">Beoordelingsgesprek</h2>
                                <div class="col-lg-12 col-md-12">
                                    <div class="group-input-settings">
                                        <label for="">Algemene beoordeling</label>
                                        <textarea name="commentary" id="" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="">
                                    <button class="btn btnSaveSetting" name="add_work" >Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="fiveBlockVoeg">
                            <h2 class="voegToeText">Compliment</h2>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Title compliment</label>
                                    <input name="title" type="text">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Onderwerp compliment</label>
                                    <div class="form-group formModifeChoose">
                                        <select id="form-control-skills" class="multipleSelect2" multiple="true">
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                            <option value="">feedback</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="group-input-settings">
                                    <label for="">Beschrijving compliment</label>
                                    <textarea name="commentary" id="" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="">
                                <button class="btn btnSaveSetting" name="add_work" >Save</button>
                            </div>
                        </div>
                    </div>
                    <!--   <div class="modal-body">
                           <div class="row">
                               <div class="col-lg-12 col-md-12">
                                   <div class="group-input-settings">
                                       <label for="">Title</label>
                                       <input name="job" type="text" placeholder="Engineer">
                                   </div>
                               </div>
                               <div class="col-lg-12 col-md-12">
                                   <div class="group-input-settings">
                                       <label for="">Commentary</label>
                                       <textarea name="commentary" id="" rows="4"></textarea>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="modal-footer">
                           <button class="btn btnSaveSetting" name="add_work" >Save</button>
                       </div>-->
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    /**
     * Defines the bootstrap tabs handler.
     *
     * @param {string} element
     *  Element.
     */
    var tabsActions = function (element) {
        this.element = $(element);

        this.setup = function () {
            if (this.element.length <= 0) {
                return;
            }
            this.init();
            // Update after resize window.
            var resizeId = null;
            $(window).resize(function () {
                clearTimeout(resizeId);
                resizeId = setTimeout(() => {this.init()}, 50);
            }.bind(this));
        };

        this.init = function () {

            // Add class to overflow items.
            this.actionOverflowItems();
            var tabs_overflow = this.element.find('.overflow-tab');

            // Build overflow action tab element.
            if (tabs_overflow.length > 0) {
                if (!this.element.find('.overflow-tab-action').length) {
                    var tab_link = $('<a>')
                        .addClass('nav-link')
                        .attr('href', '#')
                        .attr('data-toggle', 'dropdown')
                        .text('...')
                        .on('click', function (e) {
                            e.preventDefault();
                            $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').toggle();
                        });

                    var overflow_tab_action = $('<li>')
                        .addClass('nav-item')
                        .addClass('overflow-tab-action')
                        .append(tab_link);

                    // Add hide to overflow tabs when click on any tab.
                    this.element.find('.nav-link').on('click', function (e) {
                        $(this).parents('.nav.nav-tabs').children('.nav-item.overflow-tab').hide();
                    });
                    this.element.append(overflow_tab_action);
                }

                this.openOverflowDropdown();
            }
            else {
                this.element.find('.overflow-tab-action').remove();
            }
        };

        this.openOverflowDropdown = function () {
            var overflow_sum_height = 0;
            var overflow_first_top = 41;

            this.element.find('.overflow-tab').hide();
            // Calc top position of overflow tabs.
            this.element.find('.overflow-tab').each(function () {
                var overflow_item_height = $(this).height() - 1;
                if (overflow_sum_height === 0) {
                    $(this).css('top', overflow_first_top + 'px');
                    overflow_sum_height += overflow_first_top + overflow_item_height;
                }
                else {
                    $(this).css('top', overflow_sum_height + 'px');
                    overflow_sum_height += overflow_item_height;
                }

            });
        };

        this.actionOverflowItems = function () {
            var tabs_limit = this.element.width() - 100;
            var count = 0;

            // Calc tans width and add class to any tab that is overflow.
            for (var i = 0; i < this.element.children().length; i += 1) {
                var item = $(this.element.children()[i]);
                if (item.hasClass('overflow-tab-action')) {
                    continue;
                }

                count += item.width();
                if (count > tabs_limit) {
                    item.addClass('overflow-tab');
                }
                else if (count < tabs_limit) {
                    item.removeClass('overflow-tab');
                    item.show();
                }
            }
        };
    };

    var tabsAction = new tabsActions('.layout--tabs .nav-tabs-wrapper .nav-tabs');
    tabsAction.setup();

</script>
<script id="rendered-js" >
    $(document).ready(function(){
        //Chosen
        $(".multipleChosen").chosen({
            placeholder_text_multiple: "What's your rating" //placeholder
        });
        //Select2
        $(".multipleSelect2").select2({
            placeholder: "What's your rating" //placeholder
        });
    })

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Readmore.js/2.0.2/readmore.js"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>