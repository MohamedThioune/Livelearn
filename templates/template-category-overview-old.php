<?php /** Template Name: overview category */ ?>
<?php

global $wp;

//$page = 'check_visibility.php';
//require($page);

$url = home_url( $wp->request );

?>
<style>
     .checkmarkUpdated{
        background-color: white !important;
        border: 2px solid #043356 !important;
    }
    .LeerBlock {
        border-bottom: 2px solid #043356 !important;
    }
    .border-right-adapt {
        border-top-left-radius: 25px; border-bottom-left-radius: 25px;
    }
    .border-left-adapt {
        border-top-right-radius: 25px; border-bottom-right-radius: 25px;
    }
    .modal-dialog{
         width: 40% !important;
    }
    @media all and (max-width: 753px) {
        .modal-dialog{
             width: 90% !important;
        }
        .swipeContaineEvens .swiper-wrapper .swiper-slide {
            width: 170px !important;
        }
        .custom_slide{
            width: 170px !important;
        }
    }
    @media all and (min-width: 753px) and (max-width: 900px) {
        .modal-dialog{
             width: 70% !important;
        }
    }

    @media all and (max-width: 764px) {
        .border-right-adapt {
            border-radius: 0px;
        }
        .border-left-adapt {
            border-radius: 0px;
        }
    }
    .modal-backdrop.show { /* to remove gray side on the bottom */
        opacity: .5;
        display: none;
    }

</style>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/owl-carousel/css/owl.carousel.css" />


<?php

    $category = ($_GET['']) ?: ' ';
    $user_id = get_current_user_id();

    //view_topic($category, $user_visibility);
    view_topic($category);

    $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

    $courses = array();

    if($category != ' '){

        $args = array(
            'post_type' => array('course', 'post'),
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

        foreach($global_courses as $course)
        {
            $bool = true;
            $bool = visibility($course, $visibility_company);
            if(!$bool)
                continue;

            /*
            * Categories
            */

            $category_id = 0;
            $experts = get_field('experts', $course->ID);

            $category_default = get_field('categories', $course->ID);
            $category_xml = get_field('category_xml', $course->ID);
            $categories = array();

            if(!empty($category_default))
                foreach($category_default as $item)
                    if($item)
                        if(!in_array($item['value'], $categories))
                            array_push($categories,$item['value']);

            else if(!empty($category_xml))
                foreach($category_xml as $item)
                    if($item)
                        if(!in_array($item['value'], $categories))
                            array_push($categories,$item['value']);

            if(!empty($categories))
                if(in_array($category, $categories)){
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


                    if(!in_array($course->post_author, $teachers))
                        array_push($teachers, $course->post_author);

                    if(!empty($experts))
                    foreach($experts as $expertie)
                        if(!in_array($expertie, $teachers))
                            array_push($teachers, $expertie);

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
            //Activitien
            $activitiens  = count($courses);
        }

        $name = (String)get_the_category_by_ID($category);

        $image_category = get_field('image', 'category_'. $category);
        $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';

        $logo_livelearn = get_stylesheet_directory_uri() . '/img/logo_livelearn.png';


        /*
        ** Categories information
        */
        //Volgend
        $users = get_users();
        foreach($users as $user)
        {
            $topics_volgers = get_user_meta($user->ID, 'topic');
            if(in_array($_GET['category'], $topics_volgers))
                $volgers++;
        }
    }
?>

<body>
<div class="contentOne">
</div>

    <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
    <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;height: 106% !important; overflow-y:hidden !important;">
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
        style="position: absolute;overflow-y:hidden !important;height: 95%; ">
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
<div class="head2" style="margin-top: -10px !important;">
    <div class="comp1">
        <img src="<?php echo $image_category; ?>" alt="">
    </div>
    <div class="elementText3">
        <p class="liverTilteHead2"><?php echo $name ?></p>
        <div>
            <form action="../dashboard/user/" method="POST">
                <input type="hidden" name="meta_value" value="<?= $category ?>" id="">
                <input type="hidden" name="user_id" value="<?= $user_id ?>" id="">
                <div>
                    <?php
                        if($user_id != 0)
                        {
                            $topics_internal = get_user_meta($user_id,'topic_affiliate');
                            $topics_external = get_user_meta($user_id,'topic');
                            if (in_array($category, $topics_internal)){
                                echo '<input type="hidden" name="meta_key" value="topic_affiliate" id="">';
                                echo "<a href='#' class='btn btn-info rounded-pill text-white font-weight-bold p-1 px-2'>verwijder uit leeromgeving</a>";
                            }
                            else if(in_array($category, $topics_external)){
                                echo '<input type="hidden" name="meta_key" value="topic" id="">';
                                echo "<button type='submit' class='btn btn-danger rounded-pill text-white font-weight-bold p-1 px-2' name='delete' >verwijder uit leeromgeving</button>";
                            }else{
                                echo '<input type="hidden" name="meta_key" value="topic" id="">';
                                echo "<button type='submit' style='background: #00A89D'
                                class='btn btn-success rounded-pill text-white font-weight-bold p-1 px-2' name='interest_push' >Toevoegen aan Leeromgeving</button>";
                            }

                            echo "<img style='height: 30px;' class='rounded-pill' src='" . $logo_livelearn . "' alt=''>";
                        }

                    ?>
                </div>
            </form>

                <?php

                if($user_id == 0){
                ?>
                <div>
                    <button data-toggle='modal' data-target='#SignInWithEmail' aria-label='Close' data-dismiss='modal' class='btn rounded-pill text-white font-weight-bold p-1 px-2'
                        style='background: #00A89D'>Toevoegen aan Leeromgeving</button>
                    <img style="height: 30px;" class="rounded-pill" src="<?php echo $logo_livelearn; ?>" alt="">
                </div>

                <?php
                }
                ?>
        </div>

        <div class="row  mt-4 d-flex justify-content-center">
            <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1 border-right-adapt">
                <span class="text-dark font-weight-bold h5 pt-2">

                <?php
                    if ($volgers != null && $volgers != 0)
                        echo ceil(($volgers*975) - ($_GET['category']/2));
                    else
                        echo '0';

                ?>

                </span>
                <p class="text-secondary font-weight-bold m-0">Volgers</p>
            </div>

            <!-- <div class="col-md-1 col-3 bg-light border border-dark py-md-3 py-1">
                <span class="text-dark font-weight-bold h5 pt-2">0</span>
                <p class="text-secondary font-weight-bold m-0">Impact</p>
            </div> -->
            <!-- <div class="col-md-1 col-3 bg-light border border-dark py-md-3 py-1">
                <span class="text-dark font-weight-bold h5 pt-2">
                </span>
                <p class="text-secondary font-weight-bold m-0">Activiteiten</p>
            </div> -->

             <div class="col-md-2 col-lg-1 col-sm-5 col-5 bg-light border border-dark py-md-3 py-1 border-left-adapt">
                <span class="text-dark font-weight-bold h5 pt-2">

                <?php
                    if ($activitiens!=null && $activitiens!=0)
                        echo $activitiens;
                    else
                        echo '0';

                ?>

                </span>
                <p class="text-secondary font-weight-bold m-0">Activiteiten</p>
            </div>
        </div>

    </div>
    <div>

    </div>

</div>
<!-- ------------------------------------------ end Header -------------------------------------- -->


<div class="firstBlock">
    <div class="row">

        <!-- ------------------------------------ Start Slide bar ---------------------------------------- -->
        <div class="col-md-3 ">
            <div class="sousProductTest Mobelement pr-4" style="background: #F4F7F6;color: #043356;">
                <form action="/product-search/" method="GET">
                    <input type='hidden' name='filter_args' value='1'>
                    <input type="hidden" name="category_input" value="<?php echo $_GET['category'] ?>">
                    <div class="LeerBlock pl-4" style="">
                        <div class="leerv">
                            <p class="sousProduct1Title" style="color: #043356;">LEERVORM</p>
                            <button class="btn btnClose" id="filterHideMobile">
                                <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/X.png" alt=""> -->
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
                            <input type="hidden" name="choice" value="3">
                            <input type="search" name="locate" style="width:150px"  class="searchLocFilter" placeholder="&nbsp;Postcode">
                        </div>
                        <div class="inputSearchFilter">
                            <input type="hidden" name="choice" value="3">
                            <input type="search" name="range" style="width:150px"  class="searchLocFilter" placeholder="&nbsp;Afstand(m)">
                            <!-- <input type="search" name="range" class="btb btnSubmitFilter" placeholder="">  -->
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Alleen online
                                <input type="checkbox" id="Alleen-online" name="online" value="0">
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                    </div>

                    <div class="LeerBlock pl-4 d-grid">
                        <p class="sousProduct1Title" style="color: #043356;">RATING</p>
                        <div class="rating-element2 ">
                            <div class="rating">
                                <input type="radio" id="star5" class="stars" name="rating" value="5" />
                                <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                <input type="radio" id="star4" class="stars" name="rating" value="4" />
                                <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                <input type="radio" id="star3" class="stars" name="rating" value="3" />
                                <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                <input type="radio" id="star2" class="stars" name="rating" value="2" />
                                <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label class="star" for="star1" class="stars" title="Bad" aria-hidden="true"></label>
                            </div>
                            <span class="rating-counter"></span>
                        </div>

                    </div>

                    <div class="LeerBlock pl-4">
                        <p class="sousProduct1Title" style="color: #043356;">EXPERTS</p>
                        <?php
                            foreach($teachers as $teacher){
                                if(!$teacher)
                                    continue;

                                $teacher_data = get_user_by('id', $teacher);
                                
                                if($teacher != $user_id)
                                    $name_author = ($teacher_data->last_name) ? $teacher_data->first_name : $teacher_data->display_name;
                                else
                                    $name_author = "Ikzelf";

                                if($teacher_data->first_name == "")
                                    continue;

                                ?>
                                <div class="checkFilter">
                                    <label class="contModifeCheck"><?php echo $name_author ?>
                                        <input type="checkbox" id="sales" name="experties[]" value="<?php echo $teacher; ?>">
                                        <span class="checkmark checkmarkUpdated"></span>
                                    </label>
                                </div>
                        <?php
                            }
                        ?>

                        <br><button type="submit" class="btn btn-default" style="background:#C0E9F4; padding:5px 20px;">Apply</button>
                    </div>


                </form>

            </div>
            <div class="mob filterBlockMobil filterBlock">
                <p class="fliterElementText">Filter</p>
                <button class="btn btnIcone8" id="filterActiveOnMobile"><img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt=""></button>
            </div>
        </div>
        <!-- ------------------------------------ End  Slide bar ---------------------------------------- -->
       <!-- ------------------------------------------ Start Content ------------------------------------ -->
        <?php
            if(isset($courses) && !empty($courses)){
            ?>
        <div class="col-md-9 tabUserOverview">

            <?php
                if(!empty($opleidingen)){
            ?>
            <div class="sousProductTest2 opleiBlock">
                <div class="sousBlockProduct2">
                    <p class="sousBlockTitleProduct">Opleidingen</p>

                    <div class="blockCardOpleidingen ">
                        <div class="owl-carousel owl-theme owl-nav-active owl-carousel-card-course">
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
                if(!empty($workshops)){
            ?>
            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Workshops</p>
                <div class="blockCardOpleidingen ">
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
                if(!empty($masterclasses)){
            ?>
            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Masterclasses</p>

                <div class="blockCardOpleidingen ">
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
            <?php
                }
            ?>

            <?php
                if(!empty($events)){
            ?>
            <div class="sousBlockProduct6">
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
            <div class="sousBlockProduct2">
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

            <div class="sousBlockProduct2">
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

            <?php
                if(!empty($videos)){
            ?>

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
            <?php
                }
            ?>
            <div class="sousBlockProduct3 mx-3 mx-md-0">
                <p class="sousBlockTitleProduct">Expert</p>
                <div class="blockSousblockTitle">
                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($teachers as $teacher){
                                if(!$teacher)
                                    continue;

                                $image = get_field('profile_img',  'user_' . $teacher);
                                $path = "../user-overview?id=" . $teacher;
                                $teacher_data = get_user_by('id', $teacher);
                                if(!$image)
                                    $image = get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                if($teacher != $user_id)
                                    $name_author = ($teacher_data->last_name) ? $teacher_data->first_name : $teacher_data->display_name;
                                else
                                    $name_author = "Ikzelf";

                                if($teacher_data->first_name == "")
                                    continue;

                                ?>
                                <div class="swiper-slide swipeExpert custom_slide" style="width: 170px !important;">
                                    <div class="cardblockOnder cardExpert">
                                        <div class="imgBlockCardonder">
                                            <img src="<?php echo $image ?>" alt="">
                                        </div>
                                        <p class="verkop"><?php echo $name_author ?></p>
                                        <a href="<?php echo $path ?>" class="btn btnMeer">Meer</a>
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
            <div class="sousBlockProduct4">
                <div class="headsousBlockProduct4">
                    <p class="sousBlockTitleProduct2">Agenda</p>
                    <div class="elementIconeRight">
                        <img class="imgIconeShowMore" src="<?php echo get_stylesheet_directory_uri();?>/img/IconShowMore.png" alt="">
                    </div>
                    <!-- <a href="/newFilesHtml/agenda.html" class="showAllLink">Show all</a> -->
                </div>

                <div class="row mr-md-2 mr-1">
                    <?php
                        $bool = false;
                        foreach($agenda as $key => $course){
                            if($key == 6)
                                break;

                            $location = '~';

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

                            $bool = true;
                    ?>
                    <a href="<?php echo get_permalink($course->ID) ?>" class="col-md-12">
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
                                        <p class="textJan facilityText"> <?php echo $name ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                    }
                    if(!$bool)
                        echo "<p class='dePaterneText theme-card-description'> <center style='color:#033256'> Stay connected, Something big is coming 😊 </center> </p>";
                    ?>
                </div>
            </div>
        <?php
        }
        ?>

        </div>
        <?php

            }
        ?>
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
        nav:true,
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
    jQuery(document).ready(function(){
        jQuery('#user_login').attr('placeholder', 'E-mailadres of Gebruikersnaam');
        jQuery('#user_pass').attr('placeholder', 'Wachtwoord');
    });
</script>


<script>

    // make a border bottom after clicking button
    $(document).ready(function(){
        $("#btn_click1").click(function(){
            $(".add_here1").addClass("buttonSelected");
            $(".add_here2").removeClass("buttonSelected");
        });
    });
    $(document).ready(function(){
        $("#btn_click2").click(function(){
            $(".add_here2").addClass("buttonSelected");
            $(".add_here1").removeClass("buttonSelected");
        });
    });

</script>
<?php get_footer(); ?>
<?php wp_footer(); ?>
