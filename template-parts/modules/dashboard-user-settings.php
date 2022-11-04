<?php

if(get_current_user_id())
    $id_user = get_current_user_id();

$user = get_users(array('include'=> $id_user))[0]->data;

$image = get_field('profile_img',  'user_' . $user->ID);
if(!$image)
    $image = get_stylesheet_directory_uri() . '/img/Ellipse17.png';

$telnr = get_field('telnr',  'user_' . $user->ID);
$company = get_field('company',  'user_' . $user->ID);
$function = get_field('role',  'user_' . $user->ID);

$biographical_info = get_field('biographical_info',  'user_' . $user->ID);

if(!empty($company))
    $company = $company[0]->post_title;

//Add personalization
$bunch = array();
$fields = " ";
if(isset($add_education)){
    $bunch = get_field('education',  'user_' . $user->ID);
    $fields = $school . ';' . $degree . ';' .  $start_date . ';' .  $end_date . ';' . $commentary;
    array_push($bunch, $fields);
    if(!empty($bunch))
        update_field('education', $bunch, 'user_'. $user->ID);
    else
        update_field('education', $fields, 'user_'. $user->ID);
}
else if(isset($add_work)){
    $bunch = get_field('work',  'user_' . $user->ID);
    $fields = $job . ';' . $companie . ';' .  $start_date . ';' .  $end_date . ';' . $commentary;
    array_push($bunch, $fields);
    if(!empty($bunch))
        update_field('work', $bunch, 'user_'. $user->ID);
    else
        update_field('work', $fields, 'user_'. $user->ID);
}
else if(isset($add_project)){
    $bunch = get_field('portfolio',  'user_' . $user->ID);
    $fields = $title . ';' . $description;
    array_push($bunch, $fields);
    if(!empty($bunch))
        update_field('portfolio', $bunch, 'user_'. $user->ID);
    else
        update_field('portfolio', $fields, 'user_'. $user->ID);
}
else if(isset($add_award)){
    $bunch = get_field('awards',  'user_' . $user->ID);
    $fields = $title . ';' . $description . ';' .  $date;
    array_push($bunch, $fields);
    if(!empty($bunch))
        update_field('awards', $bunch, 'user_'. $user->ID);
    else
        update_field('awards', $fields, 'user_'. $user->ID);
}

//Edit personalization
if(isset($_POST['edit_education'])){
    $educations = get_field('education',  'user_' . $user->ID);
    $bunch = array();
    $fields = " ";
    foreach($educations as $key => $value){
        if($key == $id){
            $fields = $school . ';' . $degree . ';' .  $start_date . ';' .  $end_date . ';' . $commentary;
            array_push($bunch, $fields);
        }else
            array_push($bunch,$value);
    }
    update_field('education', $bunch, 'user_'. $user->ID);
}

if(isset($_POST['edit_portfolio'])){
    $portfolios = get_field('portfolio',  'user_' . $user->ID);
    $bunch = array();
    $fields = " ";
    foreach($portfolios as $key => $value){
        if($key == $id){
            $fields = $title . ';' . $description;
            array_push($bunch, $fields);
        }else
            array_push($bunch,$value);
    }
    update_field('portfolio', $bunch, 'user_'. $user->ID);
}

if(isset($_POST['edit_work'])){
    $experiences = get_field('work',  'user_' . $user->ID);
    $bunch = array();
    $fields = " ";
    foreach($experiences as $key => $value){
        if($key == $id){
            $fields = $job . ';' . $companie . ';' .  $start_date . ';' .  $end_date . ';' . $commentary;
            array_push($bunch, $fields);
        }else
            array_push($bunch,$value);
    }
    update_field('work', $bunch, 'user_'. $user->ID);
}

if(isset($_POST['edit_award'])){
    $awards = get_field('awards',  'user_' . $user->ID);
    $bunch = array();
    $fields = " ";
    foreach($awards as $key => $value){
        if($key == $id){
            $fields = $title . ';' . $description . ';' .  $date;
            array_push($bunch, $fields);
        }else
            array_push($bunch,$value);
    }
    update_field('awards', $bunch, 'user_'. $user->ID);
}


$experiences = get_field('work',  'user_' . $user->ID);
$educations = get_field('education',  'user_' . $user->ID);
$portfolios = get_field('portfolio',  'user_' . $user->ID);
$awards = get_field('awards',  'user_' . $user->ID);

//Delete personalization
if(isset($delete_education)){
    foreach($educations as $key => $value){
        if($key == $id)
            continue;
        else
            array_push($bunch,$value);
    }
    update_field('education', $bunch, 'user_'. $user->ID);
    $educations = get_field('education',  'user_' . $user->ID);
}
else if(isset($delete_portfolio)){
    foreach($portfolios as $key => $value){
        if($key == $id)
            continue;
        else
            array_push($bunch,$value);
    }
    update_field('portfolio', $bunch, 'user_'. $user->ID);
    $portfolios = get_field('portfolio',  'user_' . $user->ID);
}
else if(isset($delete_experience)){
    foreach($experiences as $key => $value){
        if($key == $id)
            continue;
        else
            array_push($bunch,$value);
    }
    update_field('work', $bunch, 'user_'. $user->ID);
    $experiences = get_field('work',  'user_' . $user->ID);
}
else if(isset($delete_awards)){
    foreach($awards as $key => $value){
        if($key == $id)
            continue;
        else
            array_push($bunch,$value);
    }
    update_field('awards', $bunch, 'user_'. $user->ID);
    $awards = get_field('awards',  'user_' . $user->ID);
}

if(!empty($bunch)){
    ?>
        <script>
         window.location.replace("/dashboard/user/settings/?message=Your personal information has been sucessfully updated");
        </script>
    <?php
}

?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.css">

<div class="content-settings">
    <a href="/profile" class="goBackProfil">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png" alt="">
    </a>
    <h1 class="titleSetting">Profiel Informatie</h1>
    <?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ; ?>

    <div class="content-tab">
        <div class="content-button-tabs">
            <button  data-tab="general" class="b-nav-tab btn active">
                General
            </button>
            <button  data-tab="Portfolio" class="b-nav-tab btn">
                Portfolio
            </button>
            <button  data-tab="Skills" class="b-nav-tab btn">
                Skills
            </button>
            <button  data-tab="social" class="b-nav-tab btn">
                Social Network
            </button>
            <button  data-tab="Password" class="b-nav-tab btn">
                Password
            </button>
        </div>

        <div id="general" class="b-tab active contentBlockSetting">
            <?php $options = array(
                'post_id' => 'user_'. get_current_user_id(),
                'form' => true,
                'fields' => array('first_name','user_email', 'profile_img', 'function', 'telnr', 'experience', 'country', 'date_born', 'gender', 'education_level', 'language', 'biographical_info'),
                'html_before_fields' => '',
                'html_after_fields' => '',
                'html_updated_message'  => '<div id="message" class="alert alert-success updated">Informations user updated<p></p></div>',

                'submit_value' => 'SAVE'
            );
            acf_form( $options );
            ?>
        </div>
        <div id="Portfolio" class="b-tab contentBlockSetting">
            <div class="group-input-settings">
                <label for="">Education</label>
                <button class="btn btnAddEdu" data-toggle="modal" data-target="#exampleModalEdu"> Add Education
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/plus.png" alt="">
                </button>
                <br>
                <div class="categorieDetailCandidat">
                    <?php
                    if($educations)
                        if(!empty($educations))
                            foreach($educations as $key => $value) {
                                if($value != null){
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

                                        <form action="" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $key; ?>">
                                            <button class="btn btn-danger" style="color:white" name="delete_education" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                        <button class="btn btn-warning" style="color:white" data-toggle="modal" data-target="#editModalEdu<?php echo $key; ?>"><i class="fas fa-edit"></i></button>
                                    </div>
                                    <br>

                                    <div class="elementInputImgSetting">
                                        <!-- Modal edit - education -->
                                        <div class="modal modalEdu fade" id="editModalEdu<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Education</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $key; ?>">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="group-input-settings">
                                                                        <label for="">School</label>
                                                                        <input name="school" type="text" placeholder="Sonatel Academy" value="<?php echo $value[1] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="group-input-settings">
                                                                        <label for="">Degree</label>
                                                                        <input name="degree" type="text" value="<?php echo $value[0] ?>" placeholder="Master">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="group-input-settings">
                                                                        <label for="">start Date</label>
                                                                        <input name="start_date" type="date" placeholder="" value="<?php echo $value[2] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="group-input-settings">
                                                                        <label for="">End Date</label>
                                                                        <input name="end_date" type="date" value="<?php echo $value[3] ?>" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-md-12">
                                                                    <div class="group-input-settings">
                                                                        <label for="">Commentary</label>
                                                                        <textarea name="commentary" id="" rows="4"><?php echo $value[4] ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btnSaveSetting" type="submit" name="edit_education" >Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                    ?>
                </div>

                <div class="elementInputImgSetting">
                    <!-- Modal education -->
                    <div class="modal modalEdu fade" id="exampleModalEdu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Education</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">School</label>
                                                    <input name="school" type="text" placeholder="Sonatel Academy" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">Degree</label>
                                                    <input name="degree" type="text" placeholder="Master">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">start Date</label>
                                                    <input name="start_date" type="date" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">End Date</label>
                                                    <input name="end_date" type="date" placeholder="">
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
                                        <button class="btn btnSaveSetting" type="submit" name="add_education" >Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group-input-settings">
                <label for="">Work Experience</label>
                <button class="btn btnAddEdu" data-toggle="modal" data-target="#exampleModalWork"> Add Work Experience
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/plus.png" alt="">
                </button>

                <div class="categorieDetailCandidat workExperiece">
                    <?php
                    if($experiences)
                        if(!empty($experiences))
                            foreach($experiences as $key=>$value) {
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
                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $key; ?>">
                                        <button class="btn btn-danger" style="color:white" name="delete_experience" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                    <button class="btn btn-warning" style="color:white" data-toggle="modal" data-target="#editModalWork<?php echo $key; ?>"><i class="fas fa-edit"></i></button>
                                </div>
                                <br>

                                <div class="elementInputImgSetting">
                                    <!-- Modal Work Experience -->
                                    <div class="modal modalEdu fade show" id="editModalWork<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Work/Experience</h5>
                                                    <button type="button" class="close"  aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $key; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="group-input-settings">
                                                                    <label for="">Job</label>
                                                                    <input name="job" type="text" value="<?php echo $value[0] ?>" placeholder="Engineer">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="group-input-settings">
                                                                    <label for="">Company</label>
                                                                    <input name="companie" type="text" value="<?php echo $value[1] ?>" placeholder="LiveLearn">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="group-input-settings">
                                                                    <label for="">start Date</label>
                                                                    <input name="start_date" type="date" value="<?php echo $value[2] ?>"  placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="group-input-settings">
                                                                    <label for="">End Date</label>
                                                                    <input name="end_date" type="date" value="<?php echo $value[3] ?>"  placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="group-input-settings">
                                                                    <label for="">Commentary</label>
                                                                    <textarea name="commentary" id="" rows="4"> <?php echo $value[4] ?> </textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btnSaveSetting" name="edit_work" >Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                </div>
                <div class="elementInputImgSetting">
                    <!-- Modal Work Experience -->
                    <div class="modal modalEdu fade show" id="exampleModalWork" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Work & Experience</h5>
                                    <button type="button" class="close"  aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">Job</label>
                                                    <input name="job" type="text" placeholder="Engineer">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">Company</label>
                                                    <input name="companie" type="text" placeholder="LiveLearn">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">start Date</label>
                                                    <input name="start_date" type="date" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">End Date</label>
                                                    <input name="end_date" type="date" placeholder="">
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
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="group-input-settings">
                <label for="">Projects</label>
                <button class="btn btnAddEdu" data-toggle="modal" data-target="#exampleModalProject"> Add Projects
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/plus.png" alt="">
                </button>
                <br>
                <div class="categorieDetailCandidat workExperiece">
                    <?php
                    if($portfolios)
                    if(!empty($portfolios))
                        foreach($portfolios as $value) {
                            $value = explode(";", $value);
                            ?>
                            <div class="contentEducationCandidat">
                                <p class="titleCoursCandiddat"><?php echo $value[0]; ?> </p>
                                <p class="textDetailCategorie"><?php echo $value[1]; ?> </p>
                                <a href="" class="seeProject">See project</a>
                                <form action="" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $key; ?>">
                                    <button class="btn btn-danger" style="color:white" name="delete_portfolio" type="submit"><i class="fa fa-trash"></i></button>
                                </form>
                                <button class="btn btn-warning" style="color:white" data-toggle="modal" data-target="#editModalProject<?php echo $key; ?>"><i class="fas fa-edit"></i></button>
                            </div>
                            <br>

                            <div class="elementInputImgSetting">
                                <!-- Modal Project Experience -->
                                <div class="modal modalEdu fade show" id="editModalProject<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="" method="POST">
                                                <div class="modal-body">
                                                    <div class="row">

                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="group-input-settings">
                                                                <label for="">Title</label>
                                                                <input type="text" name="title" value="<?php echo $value[0] ?>" placeholder="Engineer">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="group-input-settings">
                                                                <label for="">Description</label>
                                                                <textarea name="description" id="" rows="4"> <?php echo $value[1] ?></textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btnSaveSetting" type="submit" name="edit_portfolio" >Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                    <?php } ?>
                </div>

                <div class="elementInputImgSetting">
                    <!-- Modal education -->
                    <div class="modal modalEdu fade" id="exampleModalProject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Project</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">Title</label>
                                                    <input name="title" type="text" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">Description</label>
                                                    <textarea name="description" id="" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btnSaveSetting" type="submit" name="add_project" >Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div id="Skills" class="b-tab contentBlockSetting" >
            <div class="group-input-settings">

                <button class="btn btnAddEdu addSkills" data-toggle="modal" data-target="#exampleModalAddSkills"> Add Skills
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/plus.png" alt="">
                </button>

                <div class="content-card-skills">
                    <div class="card-skills">
                        <div class="group position-relative">
                            <span class="donut-chart has-big-cente">50</span> <span class="pourentageElement">%</span>
                        </div>
                        <p class="name-course">Workforce management</p>
                        <div class="footer-card-skills">
                            <button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills">Edit <i class="fa fa-edit"></i></a>
                                <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-skills">
                        <div class="group">
                            <span class="donut-chart has-big-cente">97</span>
                        </div>
                        <p class="name-course">Workforce management</p>
                        <div class="footer-card-skills">
                            <button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills">Edit <i class="fa fa-edit"></i></a>
                                <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-skills">
                        <div class="group">
                            <span class="donut-chart has-big-cente">10</span>
                        </div>
                        <p class="name-course">Workforce management</p>
                        <div class="footer-card-skills">
                            <button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills">Edit <i class="fa fa-edit"></i></a>
                                <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>

                        <!-- Strat add skills-->
                            <div class="modal modalEdu fade" id="exampleModalAddSkills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Beoordeel jouw expertise in "Personeel"</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="POST">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="group-input-settings">
                                                        <label for="">Name Skills</label>
                                                        <input name="school" type="text" placeholder="Management" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 skillBar-col">
                                                    <div class="group-input-settings">
                                                        <label for="">Kies uw vaardigheidsniveau in percentage</label>
                                                        <div class="slider-wrapper">
                                                            <div id="skilsPercentage"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="group-input-settings">
                                                        <label for="">Uw procentuele vaardigheden</label>
                                                        <input type="text" id="SkillBar" name="SkillBar" placeholder="">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btnSaveSetting" type="submit" name="add_education" >Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--  End add edit skills-->


                    <!-- Strat modal edit skills-->
                    <div class="modal modalEdu fade" id="exampleModalSkills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Skills</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">Name Skills</label>
                                                    <input name="school" type="text" placeholder="Management" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 skillBar-col">
                                                <div class="group-input-settings">
                                                    <label for="">Kies uw vaardigheidsniveau in percentage</label>
                                                    <div class="slider-wrapper">
                                                        <div id="edit"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="group-input-settings">
                                                    <label for="">Uw procentuele vaardigheden</label>
                                                    <input type="text" id="SkillBarEdit" name="SkillBarEdit" placeholder="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btnSaveSetting" type="submit" name="add_education" >Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--  End modal edit skills-->

                </div>
            </div>
        </div>

        <div id="social" class="b-tab contentBlockSetting">
            <?php $options = array(
                'post_id' => 'user_'. get_current_user_id(),
                'form' => true,
                'fields' => array('stackoverflow','github','facebook', 'twitter', 'linkedin', 'instagram', 'discord', 'tik_tok'),
                'html_before_fields' => '',
                'html_after_fields' => '',
                'updated_message' => false,
                'submit_value' => 'SAVE'
            );
            acf_form( $options );
            ?>
        </div>

        <div id="Password" class="b-tab contentBlockSetting">
            <div> <?php if(isset($_GET['message_password'])) echo "<span class='alert alert-info'>" . $_GET['message_password'] . "</span>" ; ?><div><br>
                    <form action="" method="POST">
                        <div class="group-input-settings">
                            <div class="input-group-user">
                                <label for="">Enter your actual password :</label>
                                <input name="old_password" type="password" required>
                            </div>
                            <div class="input-group-user">
                                <label for="">Define your new pasword :</label>
                                <input name="password" type="password" required>
                            </div>
                            <div class="input-group-user">
                                <label for="">Confirm the pasword :</label>
                                <input name="password_confirmation" type="password" required>
                            </div>
                        </div>

                        <div>
                            <button type="submit" name="change_password" class="btn btn-save-user">SAVE</button>
                        </div>
                    </form>
        </div>
    </div>
</div>


<script>
    'use strict';

    function Tabs() {
        var bindAll = function() {
            var menuElements = document.querySelectorAll('[data-tab]');
            for(var i = 0; i < menuElements.length ; i++) {
                menuElements[i].addEventListener('click', change, false);
            }
        };

        var clear = function() {
            var menuElements = document.querySelectorAll('[data-tab]');
            for(var i = 0; i < menuElements.length ; i++) {
                menuElements[i].classList.remove('active');
                var id = menuElements[i].getAttribute('data-tab');
                document.getElementById(id).classList.remove('active');
            }
        };

        var change = function(e) {
            clear();
            e.target.classList.add('active');
            var id = e.currentTarget.getAttribute('data-tab');
            document.getElementById(id).classList.add('active');
        };

        bindAll();

        //window.location.hash = target_panel_selector ;
        if(history.pushState) {
            history.pushState(null, null, target_panel_selector);
        } else {
            window.location.hash = target_panel_selector;
        }
        return false;
    }

    var connectTabs = new Tabs();
</script>

<script>
    $(document).ready(function() {
        $(".js-select2").select2();
        $(".js-select2-multi").select2();

        $(".large").select2({
            dropdownCssClass: "big-drop",
        });
    });
</script>

        <script src="<?php echo get_stylesheet_directory_uri();?>/donu-chart.js"></script>
        <script src="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.js"></script>

        <!--  script for add skills-->
        <script>
            const SliderSkills = document.querySelector("#skilsPercentage")
            var labels = { 0: 'Beginner', 10: '10%', 20: '20%', 30: '30%', 40: '40%', 50: '50%', 60: '60%', 70: '70%', 80: '80%', 90: '90%', 100: 'Expert', };
            noUiSlider.create(skilsPercentage, {
                start: 10,
                connect: [true, false],
                tooltips: {
                    to: function(value) {
                        return value > 200 ? '200+' : parseInt(value)
                    }
                },
                range: {
                    'min': 0,
                    '10%': 10,
                    '20%': 20,
                    '30%': 30,
                    '40%': 40,
                    '50%': 50,
                    '60%': 60,
                    '70%': 70,
                    '80%': 80,
                    '90%': 90,
                    'max': 100
                },
                pips: {
                    mode: 'steps',
                    filter: function (value, type) {
                        return type === 0 ? -1 : 1;
                    },
                    format: {
                        suffix: '%',
                        to: function (value) {
                            return labels[value];
                        }

                    }
                }
            });

            var SkillBarInput = document.getElementById('SkillBar');
            SliderSkills.noUiSlider.on('update', function (values, handle, unencoded) {
                var SkillBarValue = values[handle];
                SkillBarInput.value = Math.round(SkillBarValue);
            });

            SkillBarInput.addEventListener('change', function () {
                SliderSkills.noUiSlider.set([null, this.value]);
            });

        </script>

        <!--  script For edit skills-->
        <script>
            const edit = document.querySelector("#edit")
            var labels = { 0: 'Beginner', 10: '10%', 20: '20%', 30: '30%', 40: '40%', 50: '50%', 60: '60%', 70: '70%', 80: '80%', 90: '90%', 100: 'Expert', };
            noUiSlider.create(edit, {
                start: 10,
                connect: [true, false],
                tooltips: {
                    to: function(value) {
                        return value > 100 ? '100+' : parseInt(value)
                    }
                },
                range: {
                    'min': 0,
                    '10%': 10,
                    '20%': 20,
                    '30%': 30,
                    '40%': 40,
                    '50%': 50,
                    '60%': 60,
                    '70%': 70,
                    '80%': 80,
                    '90%': 90,
                    'max': 100
                },
                pips: {
                    mode: 'steps',
                    filter: function (value, type) {
                        return type === 0 ? -1 : 1;
                    },
                    format: {
                        to: function (value) {
                            return labels[value];
                        }
                    }
                }
            });

            var SkillBarInput2 = document.getElementById('SkillBarEdit');
            edit.noUiSlider.on('update', function (values, handle, unencoded) {
                var SkillBarValue2 = values[handle];
                SkillBarInput2.value = Math.round(SkillBarValue2);
            });

            SkillBarInput2.addEventListener('change', function () {
                edit.noUiSlider.set([null, this.value]);
            });
        </script>




