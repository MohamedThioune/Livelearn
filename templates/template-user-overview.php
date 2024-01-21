<?php /** Template Name: user overview */ ?>
<?php wp_head(); ?>
<?php get_header(); ?>
<?php
    global $wp;

    $url = home_url( $wp->request );

    //$page = 'check_visibility.php';
    //require($page);

    $user = ($_GET['id']) ? get_userdata($_GET['id'])->data : ' ';
    $user_id = get_current_user_id();

    //view_user($user->ID, $user_visibility);
    view_user($user->ID);

    $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

    if($user != ' '){
        $name = $user->display_name ?: $user->first_name;

        $args = array(
            'post_type' => array('post', 'course'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'DESC',
        );

        $global_courses = get_posts($args);

        $opleidingen = array();
        $workshops = array();
        $masterclasses = array();
        $artikels = array();
        $events = array();
        $e_learnings = array();
        $trainings = array();
        $videos = array();
        $agenda = array();

        $teachers = array();
        $courses = array();
        $categories = array();

        $impact = 0;
        $volgers = 0;
        $like = 0;
        $volgend = 0;

        $users = get_users();

        foreach($global_courses as $course)
        {
            $bool = true;
            $bool = visibility($course, $visibility_company);
            if(!$bool)
                continue;

            $experts = get_field('experts', $course->ID);
            $box = false;
            if($course->post_author == $user->ID)
                $box = true;
            else
                if(!empty($experts))
                    if(in_array($user->ID, $experts))
                        $box = true;

            if($box){
                array_push($courses, $course);
                if(get_field('course_type', $course->ID) == "Opleidingen")
                    array_push($opleidingen, $course);
                else if(get_field('course_type', $course->ID) == "Workshop")
                    array_push($workshops, $course);
                else if(get_field('course_type', $course->ID) == "Masterclass")
                    array_push($masterclasses, $course);
                else if(get_field('course_type', $course->ID) == "Artikel")
                    array_push($artikels, $course);
                else if(get_field('course_type', $course->ID) == "Event")
                    array_push($events, $course);
                else if(get_field('course_type', $course->ID) == "E-learning")
                    array_push($e_learnings, $course);
                else if(get_field('course_type', $course->ID) == "Training")
                    array_push($trainings, $course);
                else if(get_field('course_type', $course->ID) == "Video")
                    array_push($videos, $course);

                /*
                * Categories
                */
                $one_category = ' ';
                $category = 0;

                $one_category = get_field('categories',  $course->ID);
                if(isset($one_category[0]['value']))
                    $category = intval(explode(',', $one_category[0]['value'])[0]);
                else{
                    $one_category = get_field('category_xml',  $course->ID);
                    if(isset($one_category[0]['value']))
                        $category = intval($one_category[0]['value']);
                }

                if(!in_array($category, $categories) && $category)
                    array_push($categories, $category);

                /*
                *  Agenda
                */
                $datas = get_field('data_locaties', $course->ID);

                if($datas){
                    $data = $datas[0]['data'][0]['start_date'];
                    if($data != ""){
                        $day = explode('/', explode(' ', $data)[0])[0];
                        $mon = explode('/', explode(' ', $data)[0])[1];
                        $month = $calendar[$mon];
                    }

                    $location = $datas[0]['data'][0]['location'];
                }else{
                    $datum = get_field('data_locaties_xml', $course->ID);

                    if($datum)
                        if(isset($datum[0]['value']))
                            $element = $datum[0]['value'];

                    if(!isset($element))
                        continue;

                    $datas = explode('-', $element);

                    $data = $datas[0];
                    $day = explode('/', explode(' ', $data)[0])[0];
                    $month = explode('/', explode(' ', $data)[0])[1];
                    $month = $calendar[$month];
                    $location = $datas[2];
                }

                //Course Type
                $course_type = get_field('course_type', $course->ID);

                if(!empty($data) && $course_type != "Video" && $course_type != "Artikel" )
                    if($data){
                        $date_now = strtotime(date('Y-m-d'));
                        $data = strtotime(str_replace('/', '.', $data));
                        if($data < $date_now)
                            continue;
                    }

                array_push($agenda, $course);
            }

            //Number of likes
            $favoured = get_field('favorited', $course->ID);

            if(!empty($favoured))
                foreach($favoured as $favour){
                    if($user->ID == $favour){
                        $like++;
                        break;
                    }
                }

        }

        $image_author = get_field('profile_img',  'user_' . $user->ID);
        $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png'; 
        //$logo_livelearn = get_stylesheet_directory_uri() . '/img/logoMobil.png';
        $logo_livelearn = get_stylesheet_directory_uri() . '/img/logo_livelearn.png';
        $close_menu = get_stylesheet_directory_uri() . '/img/X.png';

        /*
        * Company
        */
        $company = get_field('company',  'user_' . $user->ID);
        $company_id = $company[0]->ID;
        $company_name=$company[0]->post_title;
        $company_logo = get_field('company_logo', $company_id);


        //Activitien
        if(!empty($courses))
            $activitiens = count($courses);

        //Volgend
        $volger_topics = get_user_meta($user->ID, 'topic');
        if(!empty($volger_topics))
            $topics_volgers = count($volger_topics);

        $volger_experts = get_user_meta($user->ID, 'expert');
        if(!empty($volger_experts))
            $experts_volgers = count($volger_experts);

        $volgend = $topics_volgers + $experts_volgers;

        //Number of feedbacks
        $todos = get_field('todos',  'user_' . $user->ID);
        if (is_array($todos) || is_object($todos))
            $todos = count($todos);

        //Impact (Like + feedback + Volgend)
        $impact = $like + $todos + $volgend;

        //Volgers
        foreach($users as $value)
        {
            $topics_volgers = get_user_meta($value->ID, 'expert');
            if(in_array($user->ID, $topics_volgers))
                $volgers++;
        }

        //Note
        $skills_note = get_field('skills', 'user_' . $user->ID);
    }



?>

<style>
    .checkmarkUpdated{
        background-color: white !important;
        border: 2px solid #043356 !important;
    }
    .LeerBlock {
        border-bottom: 2px solid #043356 !important;
    }
    /* .buttonSelected{
        border-bottom: 3px solid #00A89D !important;
    } */
    .nav-link.active {
        border-bottom: 3px solid #00A89D !important;
        background-color: #E0EFF4 !important;
    }
    .border-right-adapt {
        border-top-left-radius: 25px; border-bottom-left-radius: 25px;
    }
    .border-left-adapt {
        border-top-right-radius: 25px; border-bottom-right-radius: 25px;
    }
    @media all and (max-width: 764px) {
        .border-right-adapt {
            border-radius: 0px;
        }
        .border-left-adapt {
            border-radius: 0px;
        }
        .skill-text{
            font-size: 1rem;
        }
    }
    .modal-dialog{
         width: 40% !important;
    }
    @media all and (max-width: 753px) {
        .modal-dialog{
             width: 90% !important;

        }
    }
    @media all and (min-width: 753px) and (max-width: 900px) {
        .modal-dialog{
             width: 70% !important;
        }
    }
    .modal-backdrop.show { /* to remove gray side on the bottom */
        opacity: .5;
        display: none;
    }
</style>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />


<body>


    <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;height: 110% !important; overflow-y:hidden !important;">
        <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

            <div class="modal-content">

                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body  px-md-4 px-0">
                    <div class="mb-4">
                        <div class="text-center">
                            <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">
                        </div>
                        <h3 class="text-center my-2">Sign Up</h3>
                        <div class="text-center">
                            <p>Already a member? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#exampleModalCenter">&nbsp; Sign in</a></p>
                        </div>
                    </div>


                    <?php
                        echo (do_shortcode('[user_registration_form id="8477"]'));
                    ?>

                    <div class="text-center">
                        <p>Al een account? <a href="" data-dismiss="modal" aria-label="Close" class="text-primary"
                                                data-toggle="modal" data-target="#exampleModalCenter">Log-in</a></p>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign In-------------------------------------- -->

    <!-- -------------------------------------- Start Modal Sign Up ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;overflow-y:hidden !important;height: 110%; ">
        <div class="modal-dialog" role="document" style="width: 96% !important; max-width: 500px !important;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">

            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body  px-md-5 px-4">
                    <div class="mb-4">
                        <div class="text-center">
                            <img style="width: 53px" src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn.png" alt="">
                        </div>
                        <h3 class="text-center my-2">Sign In</h3>
                        <div class="text-center">
                            <p>Not an account? <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                            data-toggle="modal" data-target="#SignInWithEmail">&nbsp; Sign Up</a></p>
                        </div>
                    </div>

                    <?php
                    wp_login_form([
                        'redirect' => $url,
                        'remember' => false,
                        'label_username' => 'Wat is je e-mailadres?',
                        'placeholder_email' => 'E-mailadress',
                        'label_password' => 'Wat is je wachtwoord?'
                    ]);
                    ?>
                    <div class="text-center">
                        <p>Nog geen account?  <a href="#" data-dismiss="modal" aria-label="Close" class="text-primary"
                                            data-toggle="modal" data-target="#SignInWithEmail">Meld je aan</a></p>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- -------------------------------------------------- End Modal Sign Up-------------------------------------- -->



<!-- ------------------------------------------ start Header -------------------------------------- -->
<div class="head2" style="margin-top: 1px !important;">
    <div class="comp1">
        <img src="<?php echo $image_author; ?>" alt="">
    </div>
    <div class="elementText3">
        <p class="liverTilteHead2"><?php echo $name ?></p>
        <div class="mb-2">
            <span class="btn rounded-pill text-dark font-weight-bold pr-0">
                Werkzaam bij <?php echo "<a style='color:#00A89D' href='/opleider-courses/?companie=". $company_id. "'> " . $company_name. "</a>"; ?>
            </span>
        </div>

        <form action="/dashboard/user/" method="POST">
            <input type='hidden' name='filter_args' value='1'>
            <input type="hidden" name="meta_value" value="<?php echo $_GET['id']; ?>" id="">
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>" id="">
            <input type="hidden" name="meta_key" value="expert" id="">
            <div>
            <?php
            
            if($user_id != 0 && $user_id != $_GET['id'] )
            {
                $experts= get_user_meta($user_id, 'expert');
                if (in_array($user->ID,$experts))
                    echo "<button type='submit' class='btn btn-danger rounded-pill text-white font-weight-bold p-1 px-2' name='delete' >verwijder uit leeromgeving</button>";
                else
                    echo "<button type='submit' class='btn rounded-pill text-white font-weight-bold p-1 px-2' style='background: #00A89D' name='interest_push' >Toevoegen aan Leeromgeving</button>";

                echo "<img style='height: 30px;' class='rounded-pill' src='" . $logo_livelearn . "' alt=''>";
            }
            ?>

            </div>
        </form>

        <?php
        if($user_id == 0 ){
        ?>
            <div>
                <button class="btn rounded-pill text-white font-weight-bold p-1 px-2" style="background: #00A89D" data-toggle="modal" data-target="#SignInWithEmail" aria-label="Close" data-dismiss="modal">Toevoegen aan Leeromgeving</button>
                <img style="height: 30px;" class="rounded-pill" src="<?php echo $logo_livelearn; ?>" alt="">
            </div>
        <?php
        }
        ?>

        <div class="row  mt-4 d-flex justify-content-center">
            <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1 border-right-adapt">
                <span class="text-dark font-weight-bold h5 pt-2">
                    <?php
                        echo $volgers;
                    ?>
                </span>
                <p class="text-secondary font-weight-bold m-0">Volgers</p>
            </div>
            <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1">
                <span class="text-dark font-weight-bold h5 pt-2">

                <?php
                    echo $impact;
                ?>

                </span>
                <p class="text-secondary font-weight-bold m-0">Impact</p>
            </div>
            <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1">
                <span class="text-dark font-weight-bold h5 pt-2">
                <?php
                    echo $activitiens;
                ?>
                </span>
                <p class="text-secondary font-weight-bold m-0">Activiteiten</p>
            </div>
            <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1 border-left-adapt">
                <span class="text-dark font-weight-bold h5 pt-2">
                    <?php
                         echo $volgend;
                    ?>
                </span>
                <p class="text-secondary font-weight-bold m-0">Volgend</p>
            </div>
        </div>

        <nav>
            <div class="nav nav-tabs row  mt-3 d-flex justify-content-center" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active text-right" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                role="tab" aria-controls="nav-home" aria-selected="true">
                    <i class="fa fa-table text-dark"></i>  <span class="text-dark font-weight-bold">Kennis</span>
                </a>
                <a class="nav-item nav-link text-left" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                role="tab" aria-controls="nav-profile" aria-selected="false">
                    <i class="fas fa-chart-bar text-dark"></i>  <span class="text-dark font-weight-bold">Skills</span>
                </a>
            </div>
        </nav>

    </div>


</div>
<!-- ------------------------------------------ end Header -------------------------------------- -->



<div class="firstBlock">
    <div class="row tab-content d-flex" id="nav-tabContent">

        <!-- ------------------------------------ Start Slide bar ---------------------------------------- -->
        <div class="col-md-3 pr-md-3">
            <div class="sousProductTest Mobelement pr-4" style="background: #F4F7F6;color: #043356;">
                <form action="/product-search/" method="GET">
                    <input type='hidden' name='filter_args' value='1'>
                    <input type="hidden" name="user_input" value="<?php echo $_GET['id'] ?>">
                    <div class="LeerBlock pl-4" style="">
                        <div class="leerv">
                            <p class="sousProduct1Title pt-1" style="color: #043356">LEERVORM</p>
                            <button class="btn btnClose pb-1 p-0 px-1 m-0" id="hide">
                                <i class="bi bi-x text-dark" style="font-size: 35px"></i>
                            </button>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Opleidingen
                                <input style="color:red;" type="checkbox" id="opleiding" name="leervom[]" value="Opleidingen">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Masterclass
                                <input type="checkbox" id="masterclass" name="leervom[]" value="Masterclass">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Workshop
                                <input type="checkbox" id="workshop" name="leervom[]" value="Workshop">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">E-Learning
                                <input type="checkbox" id="learning" name="leervom[]" value="E-learning">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Event
                                <input type="checkbox" id="event" name="leervom[]" value="Event">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Lezing
                                <input type="checkbox" id="lezing" name="leervom[]" value="Lezing">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Podcast
                                <input type="checkbox" id="podcast" name="leervom[]" value="Podcast">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Video
                                <input type="checkbox" id="event" name="leervom[]" value="Video">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Training
                                <input type="checkbox" id="event" name="leervom[]" value="Training">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Artikel
                                <input type="checkbox" id="event" name="leervom[]" value="Artikel">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <br>
                    </div>
                    <div class="LeerBlock pl-4" >
                        <p class="sousProduct1Title" style="color: #043356;">PRIJS</p>
                        <div class="prijsSousBlock" style="color: #043356;">
                            <span class="vanafText" style="color: #043356">Vanaf</span>
                            <input name="min" style="width:100px;" class="btn btnmin text-left" placeholder="€min">
                        </div>
                        <div class="prijsSousBlock" style="color: #043356;">
                            <span class="vanafText" style="color: #043356">tot</span>
                            &nbsp; &nbsp;&nbsp;&nbsp;
                            <input name="max" style="width:100px" class="btn btnmin text-left" placeholder="€max">
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Alleen gratis
                                <input type="checkbox" id="Allen" name="gratis">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                    </div>
                    <div class="LeerBlock pl-4">
                        <p class="sousProduct1Title" style="color: #043356;">LOCATIE</p>
                        <div class="inputSearchFilter">
                            <input type="search" name="locate" style="width:150px"  class="searchLocFilter" placeholder="&nbsp;Postcode">
                        </div>
                        <div class="inputSearchFilter">
                            <input type="search" name="range" style="width:150px"  class="searchLocFilter" placeholder="&nbsp;Afstand(m)">
                            <!-- <input type="search" name="range" class="btb btnSubmitFilter" placeholder="">  -->
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Alleen online
                                <input type="checkbox" id="Alleen-online" name="online" >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <br><button type="submit" class="btn btn-default" style="background:#C0E9F4; padding:5px 20px;">Apply</button>

                    </div>
                </form>

            </div>
            <div class="mob filterBlock">
                <p class="fliterElementText">Filter</p>
                <button class="btn btnIcone8" id="show"><img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt=""></button>
            </div>
        </div>
        <!-- ------------------------------------ End Slide bar ---------------------------------------- -->

        <!-- <div class="tab-content" id="nav-tabContent"> -->

        <?php
            if(isset($courses) && !empty($courses)){
            ?>
        <div class="col-md-9 px-4 tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <?php
                if(!empty($opleidingen)){

            ?>
            <div class="sousProductTest2 opleiBlock">
                <div class="sousBlockProduct2">

                    <p class="sousBlockTitleProduct">Opleidingen</p>

                    <div class="blockCardOpleidingen ">
                        <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                            <?php
                            foreach($opleidingen as $course){

                                /*
                                * Categories
                                */
                                $category = ' ';
                                $category_id = 0;
                                $category_str = 0;
                                if($category == ' '){
                                    $one_category = get_field('categories',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                    else{
                                        $one_category = get_field('category_xml',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_id = intval($one_category[0]['value']);
                                    }

                                    if($category_str != 0)
                                        $category = (String)get_the_category_by_ID($category_str);
                                    else if($category_id != 0)
                                        $category = (String)get_the_category_by_ID($category_id);
                                }

                                /*
                                *  Date and Location
                                */
                                $datas = get_field('data_locaties', $course->ID);

                                if($datas){
                                    $data = $datas[0]['data'][0]['start_date'];
                                    if($data != ""){
                                        $day = explode('/', explode(' ', $data)[0])[0];
                                        $mon = explode('/', explode(' ', $data)[0])[1];
                                        $month = $calendar[$mon];
                                    }

                                    $location = $datas[0]['data'][0]['location'];
                                }else{
                                    $datum = get_field('data_locaties_xml', $course->ID);

                                    if($datum)
                                        if(isset($datum[0]['value']))
                                            $element = $datum[0]['value'];

                                    if(!isset($element))
                                        continue;

                                    $datas = explode('-', $element);

                                    $data = $datas[0];
                                    $day = explode('/', explode(' ', $data)[0])[0];
                                    $month = explode('/', explode(' ', $data)[0])[1];
                                    $month = $calendar[$month];
                                    $location = $datas[2];

                                }

                                /*
                                * Price
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else
                                    $price = 'Gratis';

                                //Course Type
                                $course_type = get_field('course_type', $course->ID);
                                /*
                                * Thumbnails
                                */
                                $thumbnail = get_field('preview', $course->ID)['url'];
                                if(!$thumbnail){
                                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_field('url_image_xml', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                }

                                //Image author of this post
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                                $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                                ?>

                                <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                    <div class="head">
                                        <img src="<?php echo $thumbnail ?>" alt="">
                                    </div>
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course"><?php echo $course->post_title ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm"><?php echo $location?></p>
                                        </div>
                                    </div>
                                    <!--<div class="descriptionPlatform">
                                    <p><?php /*echo get_field('short_description', $course->ID) */?></p>
                                </div>-->
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?=  $image_author ?>" class="" alt="">
                                            </div>
                                            <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                        </div>
                                        <p class="price"><?= $price ?></p>
                                    </div>

                                </a>

                                <?php
                            }
                            ?>

                        </div>
                    </div>


                </div>

            </div>
            <?php
                }
            ?>

            <?php
                if(!empty($artikels)){
            ?>
            <div class="sousProductTest2 opleiBlock">
                <div class="sousBlockProduct2">
                    <p class="sousBlockTitleProduct">Artikel</p>
                    <div class="blockCardOpleidingen  ">

                        <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                            <?php
                            foreach($artikels as $course){
                                if(!visibility($course, $visibility_company))
                                    continue;

                                /*
                                * Categories
                                */
                                $category = ' ';
                                $category_id = 0;
                                $category_str = 0;
                                if($category == ' '){
                                    $one_category = get_field('categories',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                    else{
                                        $one_category = get_field('category_xml',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_id = intval($one_category[0]['value']);
                                    }

                                    if($category_str != 0)
                                        $category = (String)get_the_category_by_ID($category_str);
                                    else if($category_id != 0)
                                        $category = (String)get_the_category_by_ID($category_id);
                                }

                                /*
                                *  Date and Location
                                */
                                $day = "<i class='fas fa-calendar-week'></i>";
                                $month = NULL;
                                $location = ' ';

                                $datas = get_field('data_locaties', $course->ID);
                                if($datas){
                                    $data = $datas[0]['data'][0]['start_date'];
                                    if($data != ""){
                                        $day = explode('/', explode(' ', $data)[0])[0];
                                        $mon = explode('/', explode(' ', $data)[0])[1];
                                        $month = $calendar[$mon];
                                    }

                                    $location = $datas[0]['data'][0]['location'];
                                }else{
                                    $datum = get_field('data_locaties_xml', $course->ID);
                                    if(isset($datum[0]['value'])){
                                        $datas = explode('-', $datum[0]['value']);
                                        $data = $datas[0];
                                        $day = explode('/', explode(' ', $data)[0])[0];
                                        $month = explode('/', explode(' ', $data)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $datas[2];
                                    }
                                }

                                /*
                                * Price
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                else
                                    $price = 'Gratis';

                                //Course Type
                                $course_type = get_field('course_type', $course->ID);
                                /*
                                * Thumbnails
                                */
                                $thumbnail = get_field('preview', $course->ID)['url'];
                                if(!$thumbnail){
                                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_field('url_image_xml', $course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                }

                                //Image author of this post
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                                ?>

                                <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                    <div class="head">
                                        <img src="<?php echo $thumbnail ?>" alt="">
                                    </div>
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course"><?php echo $course->post_title ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo $image_author ?>" class="" alt="">
                                            </div>
                                            <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                        </div>
                                    </div>
                                    <div class="descriptionPlatform">
                                        <p> <?php echo get_field('short_description', $course->ID);?></p>
                                    </div>
                                </a>

                                <?php
                            }
                            ?>

                        </div>

                    </div>
                </div>
            </div>
            <?php
                 }
            ?>

            <?php
                if(!empty($videos)){

            ?>
            <div class="sousProductTest2 opleiBlock">
                <div class="sousBlockProduct2">
                    <p class="sousBlockTitleProduct">Videos</p>

                    <div class="blockCardOpleidingen  ">

                        <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                            <?php
                            if (is_array($videos) || is_object($videos))
                                foreach($videos as $course){

                                    /*
                                    * Categories
                                    */
                                    $category = ' ';
                                    $category_id = 0;
                                    $category_str = 0;
                                    if($category == ' '){
                                        $one_category = get_field('categories',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                        else{
                                            $one_category = get_field('category_xml',  $course->ID);
                                            if(isset($one_category[0]['value']))
                                                $category_id = intval($one_category[0]['value']);
                                        }

                                        if($category_str != 0)
                                            $category = (String)get_the_category_by_ID($category_str);
                                        else if($category_id != 0)
                                            $category = (String)get_the_category_by_ID($category_id);
                                    }


                                    /*
                                    * Price
                                    */
                                    $p = get_field('price', $course->ID);
                                    if($p != "0")
                                        $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                    else
                                        $price = 'Gratis';

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);
                                    /*
                                    * Thumbnails
                                    */
                                    $thumbnail = get_field('preview', $course->ID)['url'];
                                    if(!$thumbnail){
                                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Image author of this post
                                    $image_author = get_field('profile_img',  'user_' . $course->post_author);
                                    $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';


                                    //Other case : youtube
                                    $youtube_videos = get_field('youtube_videos', $course->ID);

                                    ?>

                                <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                    <div class="head">
                                        <img src="<?php echo $thumbnail ?>" alt="">
                                    </div>
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course"><?php echo $course->post_title ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo $image_author ?>" class="" alt="">
                                            </div>
                                            <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                        </div>
                                    </div>
                                    <div class="descriptionPlatform">
                                        <p> <?php echo get_field('short_description', $course->ID);?></p>
                                    </div>
                                </a>

                                <?php
                            }
                            ?>

                        </div>

                    </div>
                </div>

            </div>
            <?php
                }
            ?>

            <div class="sousBlockProduct3 opleiBlock">
                <p class="sousBlockTitleProduct">Onderwerpen</p>
                <div class="blockSousblockTitle">

                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">
                        <?php
                            if(!empty($categories))
                            foreach($categories as $category){
                                $image_category = get_field('image', 'category_'. $category);
                                $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';
                                $name = (String)get_the_category_by_ID($category);
                        ?>
                            <div class="swiper-slide swipeExpert">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo $image_category; ?>" alt="">
                                    </div>
                                    <p class="verkop"><?php echo $name ?></p>
                                    <a href="/category-overview?category=<?php echo $category ?>" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if(!empty($agenda)){
            ?>
            <div class="sousBlockProduct4 opleiBlock">
                <div class="headsousBlockProduct4">
                    <p class="sousBlockTitleProduct2">Agenda</p>
                    <div class="elementIconeRight">
                        <img class="imgIconeShowMore" src="<?php echo get_stylesheet_directory_uri();?>/img/IconShowMore.png" alt="">
                    </div>
                    <a href="/newFilesHtml/agenda.html" class="showAllLink">Show all</a>
                </div>

                <div class="row mr-1 ">
                    <?php
                        foreach($agenda as $key => $course){
                            if($key == 6)
                                break;

                                $data = array();
                                $day = '';
                                $month = '';
                                $location = 'Virtual';

                                /*
                                * Categories
                                */
                                $category = ' ';
                                $category_id = 0;
                                $category_str = 0;
                                if($category == ' '){
                                    $one_category = get_field('categories',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                    else{
                                        $one_category = get_field('category_xml',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_id = intval($one_category[0]['value']);
                                    }

                                    if($category_str != 0)
                                        $category = (String)get_the_category_by_ID($category_str);
                                    else if($category_id != 0)
                                        $category = (String)get_the_category_by_ID($category_id);
                                }

                                /*
                                *  Date and Location
                                */
                                $day = "<i class='fas fa-calendar-week'></i>";
                                $month = NULL;
                                $location = ' ';

                                $datas = get_field('data_locaties', $course->ID);
                                if($datas){
                                    $data = $datas[0]['data'][0]['start_date'];
                                    if($data != ""){
                                        $day = explode('/', explode(' ', $data)[0])[0];
                                        $mon = explode('/', explode(' ', $data)[0])[1];
                                        $month = $calendar[$mon];
                                    }

                                    $location = $datas[0]['data'][0]['location'];
                                }else{
                                    $datum = get_field('data_locaties_xml', $course->ID);
                                    if(isset($datum[0]['value'])){
                                        $datas = explode('-', $datum[0]['value']);
                                        $data = $datas[0];
                                        $day = explode('/', explode(' ', $data)[0])[0];
                                        $month = explode('/', explode(' ', $data)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $datas[2];
                                    }
                                }

                                if(!$month)
                                    continue;

                                if(isset($data)){
                                    $date_now = strtotime(date('Y-m-d'));
                                    $data = strtotime(str_replace('/', '.', $data));
                                    if($data < $date_now)
                                        continue;
                                }


                                /*
                                * Price
                                */
                                $p = get_field('price', $course->ID);
                                if($p != "0")
                                    $price =  number_format($p, 2, '.', ',') . ",-";
                                else
                                    $price = 'Gratis';

                                //Course Type
                                $course_type = get_field('course_type', $course->ID);
                                /*
                                * Thumbnails
                                */
                                $thumbnail = get_field('preview', $course->ID)['url'];
                                if(!$thumbnail){
                                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_field('url_image_xml', $course->ID);
                                            if(!$thumbnail)
                                                $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                }

                                //Image author of this post
                                $image_author = get_field('profile_img',  'user_' . $course->post_author);
                    ?>
                    <a href="<?php echo get_permalink($course->ID) ?>" class="col-md-12 colModifAgenda">
                        <div class="blockCardFront">
                            <div class="workshopBlock">
                                <img class="" src="<?php echo $thumbnail ?>" alt="">
                                <div class="containWorkshopAgenda">
                                    <p class="workshopText"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                    <div class="blockDateFront">
                                        <p class="moiText"><?php echo $month ?></p>
                                        <p class="dateText"><?php echo $day ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="deToekomstBlock">
                                <p class="deToekomstText"> <?php echo $course->post_title ?> </p>
                                <p class="platformText"> <?php echo get_field('short_description', $course->ID) ?></p>
                                <div class="detaiElementAgenda detaiElementAgendaModife">
                                    <div class="janBlock">
                                        <div class="colorFront">
                                            <img width="17" src="<?php echo $image_author ?> " alt="" >
                                        </div>
                                        <p class="textJan"> <?php echo(get_userdata($course->post_author)->data->display_name) ?> </p>
                                    </div>
                                    <div class="euroBlock">
                                        <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/euro.png" alt="">
                                        <p class="textJan"> <?php echo $price ?> </p>
                                    </div>
                                    <div class="zwoleBlock">
                                        <img class="ss" src="<?php echo get_stylesheet_directory_uri();?>/img/ss.png" alt="">
                                        <p class="textJan"><?php echo $location; ?></p>
                                    </div>
                                    <div class="facilityBlock">
                                        <img class="faciltyImg" src="<?php echo get_stylesheet_directory_uri();?>/img/map-search.png" alt="">
                                        <p class="textJan facilityText"> <?php echo $category ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>

            <?php
                if(!empty($workshops)){
            ?>
            <div class="sousBlockProduct2 opleiBlock">
                <p class="sousBlockTitleProduct">Workshops</p>

                <div class="blockCardOpleidingen  ">

                    <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                        <?php
                        foreach($workshops as $course){
                            $data = array();
                            $day = '';
                            $month = '';
                            $location = 'Virtual';

                            /*
                            * Categories
                            */
                            $category = ' ';
                            $category_id = 0;
                            $category_str = 0;
                            if($category == ' '){
                                $one_category = get_field('categories',  $course->ID);
                                if(isset($one_category[0]['value']))
                                    $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                else{
                                    $one_category = get_field('category_xml',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_id = intval($one_category[0]['value']);
                                }

                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);
                            }

                            /*
                            *  Date and Location
                            */
                            $datas = get_field('data_locaties', $course->ID);

                            if($datas){
                                $data = $datas[0]['data'][0]['start_date'];
                                if($data != ""){
                                    $day = explode('/', explode(' ', $data)[0])[0];
                                    $mon = explode('/', explode(' ', $data)[0])[1];
                                    $month = $calendar[$mon];
                                }

                                $location = $datas[0]['data'][0]['location'];
                            }else{
                                $datum = get_field('data_locaties_xml', $course->ID);

                                if($datum)
                                    if(isset($datum[0]['value']))
                                        $element = $datum[0]['value'];

                                if(!isset($element))
                                    continue;

                                $datas = explode('-', $element);

                                $data = $datas[0];
                                $day = explode('/', explode(' ', $data)[0])[0];
                                $month = explode('/', explode(' ', $data)[0])[1];
                                $month = $calendar[$month];
                                $location = $datas[2];

                            }

                            /*
                            * Price
                            */
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                            else
                                $price = 'Gratis';

                            //Course Type
                            $course_type = get_field('course_type', $course->ID);
                            /*
                            * Thumbnails
                            */
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                            }

                            //Image author of this post
                            $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            ?>

                                <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                    <div class="head">
                                        <img src="<?php echo $thumbnail ?>" alt="">
                                    </div>
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course"><?php echo $course->post_title ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo $image_author ?>" class="" alt="">
                                            </div>
                                            <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                        </div>
                                    </div>
                                    <div class="descriptionPlatform">
                                        <p> <?php echo get_field('short_description', $course->ID);?></p>
                                    </div>
                                </a>

                                <?php
                            }
                        ?>

                    </div>

                </div>

            </div>
            <?php
                }
            ?>

            <?php
                if(!empty($masterclasses)){
            ?>
            <div class="sousBlockProduct2 opleiBlock">
                <p class="sousBlockTitleProduct">Masterclasses</p>
                <div class="blockCardOpleidingen  ">

                    <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                        <?php
                        foreach($masterclasses as $course){
                            $data = array();
                            $day = '';
                            $month = '';
                            $location = 'Virtual';

                            /*
                            * Categories
                            */
                            $category = ' ';
                            $category_id = 0;
                            $category_str = 0;
                            if($category == ' '){
                                $one_category = get_field('categories',  $course->ID);
                                if(isset($one_category[0]['value']))
                                    $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                else{
                                    $one_category = get_field('category_xml',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_id = intval($one_category[0]['value']);
                                }

                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);
                            }

                            /*
                            *  Date and Location
                            */
                            $datas = get_field('data_locaties', $course->ID);

                            if($datas){
                                $data = $datas[0]['data'][0]['start_date'];
                                if($data != ""){
                                    $day = explode('/', explode(' ', $data)[0])[0];
                                    $mon = explode('/', explode(' ', $data)[0])[1];
                                    $month = $calendar[$mon];
                                }

                                $location = $datas[0]['data'][0]['location'];
                            }else{
                                $datum = get_field('data_locaties_xml', $course->ID);

                                if($datum)
                                    if(isset($datum[0]['value']))
                                        $element = $datum[0]['value'];

                                if(!isset($element))
                                    continue;

                                $datas = explode('-', $element);

                                $data = $datas[0];
                                $day = explode('/', explode(' ', $data)[0])[0];
                                $month = explode('/', explode(' ', $data)[0])[1];
                                $month = $calendar[$month];
                                $location = $datas[2];

                            }

                            /*
                            * Price
                            */
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                            else
                                $price = 'Gratis';

                            //Course Type
                            $course_type = get_field('course_type', $course->ID);
                            /*
                            * Thumbnails
                            */
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                            }

                            //Image author of this post
                            $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            ?>

                            <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo $thumbnail ?>" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course"><?php echo $course->post_title ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                    <div class="blockOpein d-flex align-items-center">
                                        <i class="fas fa-graduation-cap"></i>
                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="blockImgUser">
                                            <img src="<?php echo $image_author ?>" class="" alt="">
                                        </div>
                                        <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                    </div>
                                </div>
                                <div class="descriptionPlatform">
                                    <p> <?php echo get_field('short_description', $course->ID);?></p>
                                </div>
                            </a>

                            <?php
                        }
                        ?>

                    </div>

                </div>
            </div>
            <?php
                }
            ?>

            <?php
                if(!empty($events)){
            ?>
                    <div class="sousBlockProduct6 opleiBlock">
                        <p class="sousBlockTitleProduct">Events</p>

                        <div class="blockCardOpleidingen  ">

                            <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                                <?php
                                foreach($events as $course){
                                    $data = array();
                                    $day = '';
                                    $month = '';
                                    $location = 'Virtual';

                                    /*
                                    * Categories
                                    */
                                    $category = ' ';
                                    $category_id = 0;
                                    $category_str = 0;
                                    if($category == ' '){
                                        $one_category = get_field('categories',  $course->ID);
                                        if(isset($one_category[0]['value']))
                                            $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                        else{
                                            $one_category = get_field('category_xml',  $course->ID);
                                            if(isset($one_category[0]['value']))
                                                $category_id = intval($one_category[0]['value']);
                                        }

                                        if($category_str != 0)
                                            $category = (String)get_the_category_by_ID($category_str);
                                        else if($category_id != 0)
                                            $category = (String)get_the_category_by_ID($category_id);
                                    }

                                    /*
                                    *  Date and Location
                                    */
                                    $datas = get_field('data_locaties', $course->ID);

                                    if($datas){
                                        $data = $datas[0]['data'][0]['start_date'];
                                        if($data != ""){
                                            $day = explode('/', explode(' ', $data)[0])[0];
                                            $mon = explode('/', explode(' ', $data)[0])[1];
                                            $month = $calendar[$mon];
                                        }

                                        $location = $datas[0]['data'][0]['location'];
                                    }else{
                                        $datum = get_field('data_locaties_xml', $course->ID);

                                        if($datum)
                                            if(isset($datum[0]['value']))
                                                $element = $datum[0]['value'];

                                        if(!isset($element))
                                            continue;

                                        $datas = explode('-', $element);

                                        $data = $datas[0];
                                        $day = explode('/', explode(' ', $data)[0])[0];
                                        $month = explode('/', explode(' ', $data)[0])[1];
                                        $month = $calendar[$month];
                                        $location = $datas[2];

                                    }

                                    /*
                                    * Price
                                    */
                                    $p = get_field('price', $course->ID);
                                    if($p != "0")
                                        $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                                    else
                                        $price = 'Gratis';

                                    //Course Type
                                    $course_type = get_field('course_type', $course->ID);
                                    /*
                                    * Thumbnails
                                    */
                                    $thumbnail = get_field('preview', $course->ID)['url'];
                                    if(!$thumbnail){
                                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                                    }

                                    //Image author of this post
                                    $image_author = get_field('profile_img',  'user_' . $course->post_author);
                                    $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                    ?>
                                    <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                        <div class="head">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                        </div>
                                        <div class="title-favorite d-flex justify-content-between align-items-center">
                                            <p class="title-course"><?php echo $course->post_title ?></p>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                            <div class="blockOpein d-flex align-items-center">
                                                <i class="fas fa-graduation-cap"></i>
                                                <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="blockImgUser">
                                                    <img src="<?php echo $image_author ?>" class="" alt="">
                                                </div>
                                                <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                            </div>
                                        </div>
                                        <div class="descriptionPlatform">
                                            <p> <?php echo get_field('short_description', $course->ID);?></p>
                                        </div>
                                    </a>

                                    <?php
                                }
                                ?>

                            </div>

                        </div>

                    </div>
            <?php
                }
            ?>

            <?php
                if(!empty($e_learnings)){
            ?>
            <div class="sousBlockProduct2 opleiBlock">
                <p class="sousBlockTitleProduct">E-Learnings</p>

                <div class="blockCardOpleidingen  ">

                    <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                        <?php
                        foreach($e_learnings as $course){

                            /*
                            * Categories
                            */
                            $category = ' ';
                            $category_id = 0;
                            $category_str = 0;
                            if($category == ' '){
                                $one_category = get_field('categories',  $course->ID);
                                if(isset($one_category[0]['value']))
                                    $category_str = intval(explode(',', $one_category[0]['value'])[0]);
                                else{
                                    $one_category = get_field('category_xml',  $course->ID);
                                    if(isset($one_category[0]['value']))
                                        $category_id = intval($one_category[0]['value']);
                                }

                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);
                            }

                            /*
                            * Price
                            */
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                            else
                                $price = 'Gratis';

                            //Course Type
                            $course_type = get_field('course_type', $course->ID);
                            /*
                            * Thumbnails
                            */
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                            }

                            //Image author of this post
                            $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo $thumbnail ?>" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course"><?php echo $course->post_title ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                    <div class="blockOpein d-flex align-items-center">
                                        <i class="fas fa-graduation-cap"></i>
                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="blockImgUser">
                                            <img src="<?php echo $image_author ?>" class="" alt="">
                                        </div>
                                        <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                    </div>
                                </div>
                                <div class="descriptionPlatform">
                                    <p> <?php echo get_field('short_description', $course->ID);?></p>
                                </div>
                            </a>

                            <?php
                        }
                        ?>

                    </div>

                </div>
            </div>
            <?php
                }
            ?>


            <?php
                if(!empty($trainings)){
            ?>
            <div class="sousBlockProduct2 opleiBlock">
                <p class="sousBlockTitleProduct">Trainings</p>

                <div class="blockCardOpleidingen  ">

                    <div class="owl-carousel owl-nav-active owl-theme owl-carousel-card-course">
                        <?php
                        foreach($trainings as $course){
                            /*
                            * Categories
                            */
                            $category = ' ';

                            $tree = get_the_terms($course->ID, 'course_category');

                            if($tree)
                                if(isset($tree[2]))
                                    $category = $tree[2]->name;

                            $category_id = 0;

                            if($category == ' '){
                                $category_str = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]);
                                $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                                if($category_str != 0)
                                    $category = (String)get_the_category_by_ID($category_str);
                                else if($category_id != 0)
                                    $category = (String)get_the_category_by_ID($category_id);
                            }

                            $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

                            $dates = get_field('dates', $course->ID);
                            if($dates){

                                $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                                $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];

                                $month = $calendar[$month];

                            }else{
                                $data = get_field('data_locaties', $course->ID);
                                if($data){
                                    $date = $data[0]['data'][0]['start_date'];

                                    $day = explode('/', explode(' ', $date)[0])[0];
                                    $month = explode('/', explode(' ', $date)[0])[1];
                                    $month = $calendar[$month];

                                    $location = $data[0]['data'][0]['location'];
                                }
                                else{
                                    $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                                    $date = $data[0];
                                    $day = explode('/', explode(' ', $date)[0])[0];
                                    $month = explode('/', explode(' ', $date)[0])[1];
                                    $month = $calendar[$month];
                                    $location = $data[2];
                                }
                            }

                            /*
                            * Price
                            */
                            $p = get_field('price', $course->ID);
                            if($p != "0")
                                $price =  "€" . number_format($p, 2, '.', ',') . ",-";
                            else
                                $price = 'Gratis';

                            //Course Type
                            $course_type = get_field('course_type', $course->ID);
                            /*
                            * Thumbnails
                            */
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                            }

                            //Image author of this post
                            $image_author = get_field('profile_img',  'user_' . $course->post_author);
                            $image_author = $image_author ? $image_author : get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="new-card-course">
                                <div class="head">
                                    <img src="<?php echo $thumbnail ?>" alt="">
                                </div>
                                <div class="title-favorite d-flex justify-content-between align-items-center">
                                    <p class="title-course"><?php echo $course->post_title ?></p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                    <div class="blockOpein d-flex align-items-center">
                                        <i class="fas fa-graduation-cap"></i>
                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="blockImgUser">
                                            <img src="<?php echo $image_author ?>" class="" alt="">
                                        </div>
                                        <p class="autor"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                    </div>
                                </div>
                                <div class="descriptionPlatform">
                                    <p> <?php echo get_field('short_description', $course->ID);?></p>
                                </div>
                            </a>

                            <?php
                        }
                        ?>

                    </div>

                </div>

            </div>
            <?php
                }
            ?>

        </div>
        <?php

            }
        ?>


         <!-- ========================================== SKILLS===========================================  -->
        <div  class="col-md-9 pl-0 tab-pane fade pt-md-4" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <?php
            $topics = get_user_meta($user->ID, 'topic');

            $company = get_field('company',  'user_' . $user->ID);
            $function = get_field('role',  'user_' . $user->ID);
            $experience = get_field('experience',  'user_' . $user->ID);
            $country = get_field('country',  'user_' . $user->ID);
            $age = get_field('age',  'user_' . $user->ID);
            $gender = get_field('gender',  'user_' . $user->ID);
            $education_level = get_field('education_level',  'user_' . $user->ID);
            $languages = get_field('language',  'user_' . $user->ID);
            $biographical_info = get_field('biographical_info',  'user_' . $user->ID);

            $stackoverflow = get_field('stackoverflow',  'user_' . $user->ID);
            $github = get_field('github',  'user_' . $user->ID);
            $facebook = get_field('facebook',  'user_' . $user->ID);
            $twitter = get_field('twitter',  'user_' . $user->ID);
            $linkedin = get_field('linkedin',  'user_' . $user->ID);
            $instagram = get_field('instagram',  'user_' . $user->ID);
            $discord = get_field('discord',  'user_' . $user->ID);
            $tik_tok = get_field('tik_tok',  'user_' . $user->ID);

            $experiences = get_field('work',  'user_' . $user->ID);
            $educations = get_field('education',  'user_' . $user->ID);
            $portfolios = get_field('portfolio',  'user_' . $user->ID);
            $awards = get_field('awards',  'user_' . $user->ID);

            $todos = get_field('todos',  'user_' . $user->ID);

            ?>
            <div id="skills" class="m-md-2 m-2 mt-sm-5 mt-4" >
                <div class="container pr-md-3 pr-0" style="max-width: initial !important;">
                    <!-- <hr class="border-3" style="background-color: #023356"> -->
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8 col-11 ">
                            <?php if($biographical_info) { ?>
                            <div class="candidates-about">
                                <span class="text-dark h5 p-1 mt-2">Candidates About</span>
                                <p class="text-dark p-1 mt-2"><?php echo $biographical_info; ?></p>
                            </div>
                            <?php
                            }
                            if(!empty($topics)){
                            ?>
                            <div class="skills-side">
                                <span class="text-dark h5 p-1 mt-2">My skills</span><br>

                                <?php foreach($topics as $value){
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
                                        </div>
                                <?php } ?>
                            </div>
                            <?php
                            }else{
                                echo '
                                    <div class="skills-side">
                                        <center>
                                        <img src="' . get_stylesheet_directory_uri() . '/img/skill-placeholder-content.png" width="140" height="150" alt="Skill no-content" >
                                        <br><span class="text-dark h5 p-1 mt-2" style="color:#033256">No skill found </span>
                                        <center>
                                    </div>
                                    ';
                            }

                            if(!empty($educations)){
                            ?>
                            <div class="education">
                                <span class="text-dark h5 p-1 mt-2">Education</span>
                                <?php
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
                                    <div class="d-flex justify-content-between my-2 mx-3">
                                        <div>
                                            <p class="h6"><?php echo $value[1]; ?></p>
                                            <p class="text-danger"><?php echo $value[0]; ?></p>
                                            <p class="text-muted"><?php echo $value[4]?: ''; ?></p>
                                        </div>
                                        <?php if($year) { ?>
                                            <div>
                                                <button type="button" class="btn  text-danger rounded rounded-pill"
                                                style="background-color: #f8dbdb"><?php echo $year; ?></button>
                                            </div>
                                        <?php } ?>

                                    </div>
                                <?php } ?>

                            </div>
                            <?php
                            }
                            if(!empty($experiences)){
                            ?>
                            <div class="work&experience">
                                <span class="text-dark h5 p-1 mt-2">Work & Experience</span>
                                <?php
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
                                <div class="d-flex justify-content-between my-2 mx-3">
                                    <div>
                                        <p class="h6"><?php echo $value[0]; ?></p>
                                        <p class="" style="color:#023356"><?php echo $value[1]; ?></p>
                                        <p class="text-muted"><?php echo $value[4]?: '' ?> </p>
                                    </div>
                                    <?php if($year) { ?>
                                        <div>
                                            <button type="button" class="btn rounded rounded-pill"
                                            style="background-color: #cfd8df; color: #023356"> <?php echo $year; ?></button>
                                        </div>
                                    <?php } ?>

                                </div>
                                <?php } ?>
                            </div>
                            <?php } ?>

                        </div>

                        <div class="col-md-4 col-11 mt-md-0 mt-4" heigth="auto">
                            <div class="p-2 rounded" style ="background-color: #f0f4f7;">
                            <?php if($experience){ ?>
                                <div class="d-flex flex-row">
                                    <div class="p-2 mt-1" style="font-size:17px; color:#00A89D">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="p-2">
                                        <span class="h6">Experience</span> <br>
                                        <span class="text-muted"><?php echo $experience; ?> Years</span>
                                    </div>
                                </div>
                            <?php } if($age){ ?>
                                <div class="d-flex flex-row">
                                    <div class="p-2 mt-1 " style="font-size:17px;color:#00A89D">
                                        <i class="fa fa-briefcase"></i>
                                    </div>
                                    <div class="p-2">
                                        <span class="h6">Age</span> <br>
                                        <span class="text-muted"><?php echo $age; ?> Years</span>
                                    </div>
                                </div>
                            <?php } if($gender){ ?>
                                <div class="d-flex flex-row">
                                    <div class="p-2 mt-1" style="font-size:17px;color:#00A89D">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="p-2">
                                        <span class="h6">Gender</span> <br>
                                        <span class="text-muted"><?php echo $gender; ?></span>
                                    </div>
                                </div>
                            <?php } if($languages){ ?>
                                <div class="d-flex flex-row">
                                    <div class="p-2 mt-1" style="font-size:17px;color:#00A89D">
                                        <i class="fa fa-language"></i>
                                    </div>
                                    <div class="p-2">
                                        <span class="h6">Language</span> <br>
                                        <span class="text-muted">
                                            <?php foreach($languages as $key => $language){
                                                echo $language;
                                                if(isset($languages[$key+1]))
                                                    echo ", ";
                                            } ?>
                                        </span>
                                    </div>
                                </div>
                            <?php } if($education_level){ ?>
                                <div class="d-flex flex-row">
                                    <div class="p-2 mt-1" style="font-size:17px;color:#00A89D">
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <div class="p-2">
                                        <span class="h6">Education Level</span> <br>
                                        <span class="text-muted"><?php echo $education_level; ?>  Degree</span>
                                    </div>
                                </div>
                            <?php } ?>

                            </div>

                            <div class="p-2 my-5 rounded" style ="background-color: #f0f4f7;">
                                <div class="d-flex justify-content-between py-3">
                                    <div class="p-2">
                                        <span class="h6">Experience</span>
                                    </div>
                                    <div class="p-2 mt-1" style="font-size:17px;color:#00A89D">
                                        <i class="fa fa-hashtag"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!--  =======================================END SKILLS============================================  -->

    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.animate.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.autoheight.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.lazyload.js"></script>
<script src="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/js/owl.navigation.js"></script>
<script>
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:13,
        items:2.8,
        lazyLoad:true,
        dots:false,
        responsiveClass:true,
        autoplayHoverPause:true,
        nav:false,
        merge:true,
        URLhashListener:true,
        responsive:{
            0:{
                items:1.1,
                nav:true
            },
            600:{
                items:2.2,
                nav:false
            },
            1000:{
                items:2.8,
                nav:true,
                loop:false
            }
        }
    })
</script>
    <script>
        $(document).ready(function(){
            $("#hide").click(function(){
                $(".sousProductTest").hide();
            });
            $("#show").click(function(){
                $(".sousProductTest").show();
            });
        });
    </script>

<?php get_footer(); ?>
<?php wp_footer(); ?>

