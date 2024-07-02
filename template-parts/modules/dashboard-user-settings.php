<html lang="en">
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
    $company_name = $company[0]->post_title;

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

//Skills 
$topics_external = get_user_meta($user->ID, 'topic');
$topics_internal = get_user_meta($user->ID, 'topic_affiliate');

$topics = array();
if(!empty($topics_external))
    $topics = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics, $value);

//Note
$skills_note = get_field('skills', 'user_' . $user->ID);

if(!empty($bunch)){
    ?>
        <script>
         window.location.replace("/dashboard/user/settings/?message=Your personal information has been sucessfully updated");
        </script>
    <?php
}
?>

<?php

    /*
    ** Categories - all  *
    */

    $categories = array();

    $cats = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'exclude' => 'Uncategorized',
        'parent'     => 0,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    foreach($cats as $category){
        $cat_id = strval($category->cat_ID);
        $category = intval($cat_id);
        array_push($categories, $category);
    }

    $tags = array();
    foreach($categories as $categ){
        //Topics
        $topicss = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent'  => $categ,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
            )
        );

        foreach ($topicss as  $value) {
            $subtopic = get_categories(
                 array(
                 'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                 'parent'  => $value->cat_ID,
                 'hide_empty' => 0,
                  //  change to 1 to hide categores not having a single post
                )
            );
            $tags = array_merge($tags, $subtopic);
        }
    }

?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/nouislider.min.css">
<body>
<div class="content-settings">
    <a href="/dashboard/company/profile" class="goBackProfil">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/bi_arrow-left.png" alt="">
    </a>
    <h1 class="titleSetting">Profiel Informatie</h1>
    <?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>" ; ?>


    <div id="tab-url1" class="custom-url-tabs">

        <ul class="nav">
            <li class="nav-one"><a href="#General" class="current">General</a></li>
            <li class="nav-two"><a href="#Portfolio">Portfolio</a></li>
            <li class="nav-three"><a href="#Skills">Skills</a></li>
            <li class="nav-four "><a href="#Badges">Badges</a></li>
            <li class="nav-five "><a href="#Social-Network">Social Network</a></li>
            <li class="nav-seven "><a href="#Password">Password</a></li>
        </ul>

        <div class="list-wrap">

            <ul id="General">
                <div class="contentBlockSetting ">
                    <?php $options = array(
                        'post_id' => 'user_'. get_current_user_id(),
                        'form' => true,
                        'fields' => array('first_name','user_email', 'profile_img', 'function', 'telnr', 'experience', 'country', 'date_born', 'gender', 'education_level', 'language', 'biographical_info'),
                        'html_before_fields' => '',
                        'html_after_fields' => '',
                        'html_updated_message'  => '<div id="message" class="alert alert-success updated">Informations user updated<p> </p></div>',

                        'submit_value' => 'SAVE'
                    );
                    acf_form( $options );

                    ?>
                </div>
            </ul>

            <ul id="Portfolio" class="hide">
                <div class="contentBlockSetting">
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
                                            <div class="contentEducationCandidat d-flex justify-content-between">
                                               <div class="first-block-portfolio">
                                                   <div class="titleDateEducation">
                                                       <p class="titleCoursCandiddat"><?php echo $value[1]; ?></p>
                                                       <?php if($year) { ?>
                                                           <p class="dateCourCandidat"><?php echo $year; ?></p>
                                                       <?php } ?>
                                                   </div>
                                                   <p class="schoolCandidat"><?php echo $value[0]; ?></p>
                                                   <p class="textDetailCategorie"><?php echo $value[4]?: ''; ?></p>
                                               </div>
                                                <div class="d-flex content-btn">
                                                    <button class="btn btn-edit" style="color:white" data-toggle="modal" data-target="#editModalEdu<?php echo $key; ?>"><i class="fa fa-edit"></i></button>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $key; ?>">
                                                        <button class="btn btn-remove" style="color:white" name="delete_education" type="submit"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
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
                                                                                <label for="">Start Date</label>
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
                                                                                <label for="">Comment</label>
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
                                                            <label for="">Start Date</label>
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
                                                            <label for="">Comment</label>
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
                        <button class="btn btnAddEdu" data-toggle="modal" data-target="#ModalWork"> Add Work Experience
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
                                        <div class="contentEducationCandidat d-flex justify-content-between">
                                           <div class="first-block-portfolio">
                                               <div class="titleDateEducation">
                                                   <p class="titleCoursCandiddat"><?php echo $value[1]; ?></p>
                                                   <?php if($year) { ?>
                                                       <p class="dateCourCandidat"><?php echo $year; ?></p>
                                                   <?php } ?>
                                               </div>
                                               <p class="schoolCandidat"><?php echo $value[0]; ?></p>
                                               <p class="textDetailCategorie"><?php echo $value[4]?: '' ?> </p>
                                           </div>
                                            <div class="d-flex content-btn">
                                                <button class="btn btn-edit" style="color:white" data-toggle="modal" data-target="#editModalEdu<?php echo $key; ?>"><i class="fa fa-edit"></i></button>
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $key; ?>">
                                                    <button class="btn btn-remove" style="color:white" name="delete_education" type="submit"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
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
                                                                            <label for="">Start Date</label>
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
                                                                            <label for="">Comment</label>
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
                            <!-- Modal -->
                            <div class="modal modalEdu fade" id="ModalWork" tabindex="-1" role="dialog" aria-labelledby="ModalWorkLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add New Work & Experience</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                            <label for="">Start Date</label>
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
                                                            <label for="">Comment</label>
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


                            <!-- Modal Work Experience -->
                            <div class="modal modalEdu fade show" id="exampleModalWork" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

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
                                        <div class="contentEducationCandidat d-flex justify-content-between">
                                            <div class="first-block-portfolio">
                                                <p class="titleCoursCandiddat"><?php echo $value[0]; ?> </p>
                                                <p class="textDetailCategorie"><?php echo $value[1]; ?> </p>
                                                <a href="#" class="seeProject">See project</a>
                                            </div>
                                            <div class="d-flex content-btn">
                                                <button class="btn btn-edit" style="color:white" data-toggle="modal" data-target="#editModalEdu<?php echo $key; ?>"><i class="fa fa-edit"></i></button>
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $key; ?>">
                                                    <button class="btn btn-remove" style="color:white" name="delete_education" type="submit"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </div>
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
            </ul>

            <ul id="Skills" class="hide">
                <div class="contentBlockSetting" >
                    <div class="group-input-settings">

                        <button class="btn btnAddEdu addSkills" data-toggle="modal" data-target="#exampleModalAddSkills"> Add Skills
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/plus.png" alt="">
                        </button>

                        <div class="content-card-skills">
                            <?php
                            foreach($topics as $key=>$value){
                                $i = 0;
                                $topic = get_the_category_by_ID($value);
                                $note = 0;
                                if(!$topic)
                                    continue;
                                if(!empty($skills_note))
                                    foreach($skills_note as $skill)
                                        if($skill['id'] == $value){
                                            $note = $skill['note'];
                                            break;
                                        }
                                $name_topic = (String)$topic;
                                ?>
                                <div class="card-skills">
                                    <div class="group position-relative">
                                        <span class="donut-chart has-big-cente"><?= $note ?></span>
                                    </div>
                                    <p class="name-course"><?= $name_topic ?></p>
                                    <div class="footer-card-skills">
                                        <button class="btn btn-dote dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >. . .</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="btnEdit dropdown-item" type="button" href="#" data-toggle="modal" data-target="#exampleModalSkills<?= $key ?>">Edit <i class="fa fa-edit"></i></a>
                                            <!-- <a class="dropdown-item trash" href="#">Remove <i class="fa fa-trash"></i></a> -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Start modal edit skills-->
                                <div class="modal modalEdu fade" id="exampleModalSkills<?= $key ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                <label for="">Name</label>
                                                                <input name="" type="text" placeholder="<?= $name_topic ?>" disabled>
                                                                <input name="id" type="hidden" value="<?= $value ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 skillBar-col">
                                                            <div class="group-input-settings">
                                                                <label for="">Kies uw vaardigheidsniveau in percentage</label>
                                                                <div class="slider-wrapper">
                                                                    <div class="edit"></div>
                                                                </div>
                                                                <div class="rangeslider-wrap">
                                                                    <input name="note" type="range" min="0" max="100" step="10" labels="0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100" value="<?= $note ?>" onChange="rangeSlide(this.value)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btnSaveSetting" type="submit" name="note_skill_edit">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--  End modal edit skills-->
                                <?php
                                $i++;
                            }
                            ?>

                            <!-- Start add skills-->
                            <div class="modal modalEdu fade" id="exampleModalAddSkills" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Beoordeel jouw skills</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="" method="POST">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="group-input-settings">
                                                            <label for="">Name Skill</label>
                                                            <div class="form-group formModifeChoose">
                                                                <select name="id" id="autocomplete" class="form-control multipleSelect2">
                                                                    <?php
                                                                    foreach($tags as $tag) {
                                                                        if(in_array($tag->cat_ID, $topics))
                                                                            continue;

                                                                        echo "<option value='" . $tag->cat_ID  ."'>" . $tag->cat_name . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
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
                                                            <!-- <label for="">Uw procentuele vaardigheden</label> -->
                                                            <input type="hidden" id="SkillBar" name="note" placeholder="">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btnSaveSetting" type="submit" name="note_skill_new" >Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--  End add edit skills-->

                        </div>
                    </div>
                </div>
            </ul>

            <ul id="Badges" class="hide">
                <div class="contentBlockSetting">
                    <label class="label-badge" for="">Badges</label>
                    <div class="content-badges">
                        <a href="#" class="card">
                            <div class="block-icons">
                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/validate-badge.png" alt="">
                            </div>

                            <?php
                            $strotime_date = strtotime($user->user_registered);
                            $date_registered = date("d M Y", $strotime_date);
                            ?>
                            <p class="title">You created an account sucessfully !</p>
                            <p class="awarded">Award for : <span> <?php echo $user->display_name ?> </span></p>
                            <p class="date-awarded"><span>Date Award : </span><?= $date_registered ?></p>
                        </a>
                        <!-- <a href="" class="card">
                    <div class="block-icons">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/dashicons_awards.png" alt="">
                    </div>
                    <p class="title">Complete and verified profile </p>
                    <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                    <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                </a>
                <a href="" class="card">
                    <div class="block-icons">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/gg_awards.png" alt="">
                    </div>
                    <p class="title">Complete and verified profile </p>
                    <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                    <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                </a>
                <a href="" class="card ">
                    <div class="card-lock">
                        <img class="img-card-lock" src="<?php echo get_stylesheet_directory_uri();?>/img/lock-2.png" alt="">
                    </div>
                    <div class="block-icons">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/validate-badge.png" alt="">
                    </div>
                    <p class="title">Complete and verified profile </p>
                    <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                    <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                </a>
                <a href="" class="card">
                    <div class="block-icons">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/validate-badge.png" alt="">
                    </div>
                    <p class="title">Complete and verified profile </p>
                    <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                    <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                </a>
                <a href="" class="card">
                    <div class="block-icons">
                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/validate-badge.png" alt="">
                    </div>
                    <p class="title">Complete and verified profile </p>
                    <p class="awarded">Awarded for : <span> Profil Livelearn </span></p>
                    <p class="date-awarded"><span>Date Awarded :</span> 06 Jul 2022</p>
                </a> -->
                    </div>
                </div>
            </ul>

            <ul id="Social-Network" class="hide">
                <div class="contentBlockSetting">
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
            </ul>

            <ul id="Password" class="hide">
                <div class="contentBlockSetting">
                    <div> <?php if(isset($_GET['message_password'])) echo "<span class='alert alert-info'>" . $_GET['message_password'] . "</span>" ; ?><div><br>
                            <form action="" method="POST">
                                <div class="group-input-settings">
                                    <div class="input-group-user">
                                        <label for="">Enter your current password :</label>
                                        <input name="old_password" type="password" required>
                                    </div>
                                    <div class="input-group-user">
                                        <label for="">Define your new password :</label>
                                        <input name="password" type="password" required>
                                    </div>
                                    <div class="input-group-user">
                                        <label for="">Confirm the new password :</label>
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
            </ul>

        </div> <!-- END List Wrap -->

    </div>

</div>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script src="<?php echo get_stylesheet_directory_uri();?>/organictabs.jquery.js"></script>
<script>
    $(function() {
        // Calling the plugin
        $("#tab-url1").organicTabs();

    });
</script>


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

<script src="https://rawgit.com/andreruffert/rangeslider.js/develop/dist/rangeslider.min.js"></script>

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
    const edit = document.querySelector(".edit")

    var labels = { 0: 'Beginner', 10: '10%', 20: '20%', 30: '30%', 40: '40%', 50: '50%', 60: '60%', 70: '70%', 80: '80%', 90: '90%', 100: 'Expert', };
    noUiSlider.create(edit, {
        start: 10,
        connect: [true, false],

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

        slide: function( event, ui ) {
            $( ".edit").html(ui.values[ 0 ]);
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

<script>
    $('input[type="range"]').rangeslider({

        polyfill: false,

        // Default CSS classes
        rangeClass: 'rangeslider',
        disabledClass: 'rangeslider--disabled',
        horizontalClass: 'rangeslider--horizontal',
        fillClass: 'rangeslider__fill',
        handleClass: 'rangeslider__handle',

        // Callback function
        onInit: function() {
            $rangeEl = this.$range;
            // add value label to handle
            var $handle = $rangeEl.find('.rangeslider__handle');
            var handleValue = '<div class="rangeslider__handle__value">' + this.value + '</div>';
            $handle.append(handleValue);

            // get range index labels
            var rangeLabels = this.$element.attr('labels');
            rangeLabels = rangeLabels.split(', ');

            // add labels
            $rangeEl.append('<div class="rangeslider__labels"></div>');
            $(rangeLabels).each(function(index, value) {
                $rangeEl.find('.rangeslider__labels').append('<span class="rangeslider__labels__label">' + value + '</span>');
            })
        },

        // Callback function
        onSlide: function(position, value) {
            var $handle = this.$range.find('.rangeslider__handle__value');
            $handle.text(this.value);
        },

        // Callback function
        onSlideEnd: function(position, value) {}


    });
    function rangeSlide(value) {
        document.getElementById('rangeValue').innerHTML = this.value + ' %';
    }

</script>

</body>
</html>

