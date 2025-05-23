<?php /** Template Name: opleider courses */ ?>

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

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php wp_head(); ?>
<?php get_header(); ?>
<?php 

    //$page = 'check_visibility.php';
    //require($page); 

    $user_id = get_current_user_id();
    $courses = array();

    $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

    if($_GET["companie"]){

        $args = array(
            'post_type' => 'company',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'include' => $_GET['companie'] 
        );

        $company = get_posts($args)[0];

        $users = get_users();
        $users_companie = array();
        foreach($users as $user) {
            $company_user = get_field('company',  'user_' . $user->ID);
            if(!empty($company_user) && !empty($company))
                if($company_user[0]->ID == $company->ID)
                    array_push($users_companie, $user->ID);
        }


        if(!empty($users_companie)):
            $args = array(
                'post_type' => array('course', 'post'),
                'posts_per_page' => -1,
                'author__in' => $users_companie,  
            );
            $courses = get_posts($args);
        endif;

        $opleidingen = array();
        $workshops = array();
        $masterclasses = array();
        $events = array();
        $e_learnings = array();
        $trainings = array();
        $videos = array();
        $artikels = array();
        $agenda = array();

        $teachers = array();

        if(!empty($courses)){
            foreach($courses as $course)
            {
                $bool = true;
                $bool = visibility($course, $visibility_company);
                if(!$bool)
                    continue;

                if(get_field('course_type', $course->ID) == "Opleidingen")
                    array_push($opleidingen, $course);
                else if(get_field('course_type', $course->ID) == "Workshop")
                    array_push($workshops, $course);
                else if(get_field('course_type', $course->ID) == "Masterclass")
                    array_push($masterclasses, $course);
                else if(get_field('course_type', $course->ID) == "Event")
                    array_push($events, $course);
                else if(get_field('course_type', $course->ID) == "E-learning")
                    array_push($e_learnings, $course);
                else if(get_field('course_type', $course->ID) == "Training")
                    array_push($trainings, $course);
                else if(get_field('course_type', $course->ID) == "Video")
                    array_push($videos, $course);
                else if(get_field('course_type', $course->ID) == "Artikel")
                    array_push($artikels, $course);
                
                $experts = get_field('experts', $course->ID);
                if(!in_array($course->post_author, $teachers))
                    array_push($teachers, $course->post_author);
                if(!empty($experts))
                    foreach($experts as $expertie){
                        $company_expert = get_field('company',  'user_' . $expertie);
                        $company_connected = get_field('company',  'user_' . get_current_user_id());
                        if(!in_array($expertie, $teachers) && $company_connected[0]->post_title == $company_expert[0]->post_title)
                            array_push($teachers, $expertie);
                }
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
        }

        $name = $company->post_title;
        $logo = get_field('company_logo', $company->ID);
        if(!$logo){
            $logo = get_stylesheet_directory_uri(). '/img/company.png';
        }

    } 

?>

<body>
<div class="contentOne">
</div>


<!-- ------------------------------------------ start Header -------------------------------------- -->

<div class="head2 py-5" style="margin-top: -10px !important;">
    <div class="comp1">
        <img src="<?php echo $logo; ?>" alt="">
    </div>
    <div class="d-flex elementText3">
        <p class="liverTilteHead2"><?php echo $name ?></p>
    </div>
   <!-- <form action="../dashboard/user/" method="POST">
        <input type="hidden" name="meta_value" value="" id="">
        <input type="hidden" name="user_id" value="<?php echo $user_id ?>" id="">
        <input type="hidden" name="meta_key" value="topic" id="">
        <?php
            if($user_id != 0)
                echo "<button type='submit' class='btn toevoegenText' name='interest_push'>Toevoegen aan mijn Leeromgeving</button>";
        ?>
    </form> -->
</div>
<?php 
    if(empty($users_companie)) 
    { 
        echo "<br><center><h3 class='liverTilteHead2'>No courses yet  </h3></center>";
    }
    else
    {
?>
    <div class="firstBlock">
        <div class="row">

        <!-- ------------------------------------ Start Slide bar ---------------------------------------- -->
        <div class="col-md-3 ">
            <div class="sousProductTest Mobelement pr-4" style="background: #F4F7F6;color: #043356;">
                <form action="/product-search/" method="POST">
                    <div class="LeerBlock pl-4" style="">
                        <div class="leerv">
                            <p class="sousProduct1Title" style="color: #043356;">LEERVORM</p>
                            <button class="btn btnClose" id="hide">
                                <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/X.png" alt=""> -->
                                <i class="bi bi-x text-dark" style="font-size: 35px"></i>
                            </button>
                        </div>
                        <input type="hidden" name="companie" value="<?php echo $_GET['companie'] ?>">
                        <div class="checkFilter">
                            <label class="contModifeCheck">Opleiding
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

                    <div class="LeerBlock pl-4">
                        <p class="sousProduct1Title" style="color: #043356;">EXPERTS</p>
                        <?php
                            foreach($teachers as $teacher){
                                if(!$teacher)
                                    continue;

                                $teacher_data = get_user_by('id', $teacher);
                                
                                if($teacher != $user_id)
                                    $name = ($teacher_data->last_name) ? $teacher_data->first_name : $teacher_data->display_name;
                                else
                                    $name = "Ikzelf";

                                if($teacher_data->first_name == "")
                                    continue;

                        ?>
                        <div class="checkFilter">
                            <label class="contModifeCheck"><?php echo $name ?>
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
            <div class="mob filterBlock">
                <p class="fliterElementText">Filter</p>
                <button class="btn btnIcone8" id="show"><img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt=""></button>
            </div>
        </div>
        <!-- ------------------------------------ End  Slide bar ---------------------------------------- -->                    

        <br><br>

        <?php 
            if(isset($courses) && !empty($courses)){
            ?>
        <div class="col-md-9">
                <?php
                    if(!empty($opleidingen)){
                        
                ?>
                <div class="sousProductTest2 opleiBlock">
                    <div class="sousBlockProduct2">
                        <p class="sousBlockTitleProduct">Opleidingen</p>
                        <div class="blockCardOpleidingen ">

                        <div class="swiper-container swipeContaine4">
                            <div class="swiper-wrapper">
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
                                        
                                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="<?php echo $thumbnail ?>" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $categorie ?></p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $price ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img src="<?php echo $image_author ?>" alt="">
                                                    </div>
                                                    <p class="nameCoursProd"> <?php echo(get_userdata($course->post_author)->data->display_name); ?> </p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                        <p class="lieuAm"><?= $location ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText"><?php echo $course->post_title ?></p>
                                            <p class="descriptionPlatform">
                                                <?php echo get_field('short_description', $course->ID) ?>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            <?php
                                }
                            ?>
                            </div>
                        </div>

                        </div>
                    </div>

                    <div class="sousBlockProduct3 mx-3 mx-md-0">
                        <p class="sousBlockTitleProduct">EXPERTS</p>
                        <div class="blockSousblockTitle">
                            <div class="swiper-container swipeContaineEvens">
                                <div class="swiper-wrapper">
                                    <?php
                                    foreach($teachers as $teacher){
                                        if(!$teacher)
                                            continue;

                                        $teacher_data = get_user_by('id', $teacher);
                                            
                                        $image = get_field('profile_img',  'user_' . $teacher);
                                        $path = "../user-overview?id=" . $teacher;
                                        if(!$image)
                                            $image = get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                            $teacher_data = get_user_by('id', $teacher);
                                
                                        if($teacher != $user_id)
                                            $name = ($teacher_data->last_name) ? $teacher_data->first_name : $teacher_data->display_name;
                                        else
                                            $name = "Ikzelf";
        
                                        if($teacher_data->first_name == "")
                                            continue;
                                    ?>
                                    <div class="swiper-slide swipeExpert">
                                        <div class="cardblockOnder cardExpert">
                                            <div class="imgBlockCardonder">
                                                <img src="<?php echo $image ?>" alt="">
                                            </div>
                                            <p class="verkop"><?php echo $name ?></p>
                                            <a href="<?php echo $path; ?>" class="btn btnMeer">Meer</a>
                                        </div>
                                    </div>
                                        <?php
                                    }
                                    ?>
                                </div>
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
                        <div class="blockCardOpleidingen ">

                            <div class="swiper-container swipeContaine4">
                                <div class="swiper-wrapper">
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
                                    <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                        <div class="cardKraam2">
                                            <div class="headCardKraam">
                                                <div class="blockImgCardCour">
                                                <?php
                                                if($youtube_videos)
                                                    echo '<iframe width="355" height="170" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                                else
                                                    echo '<img src="' . $thumbnail .'" alt="">';
                                                ?>
                                                </div>
                                                <div class="blockgroup7">
                                                    <div class="iconeTextKraa">
                                                        <div class="sousiconeTextKraa">
                                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                            <p class="kraaText"> <?php echo $category ?></p>
                                                        </div>
                                                        <div class="sousiconeTextKraa">
                                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                            <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                        </div>
                                                    </div>
                                                    <div class="iconeTextKraa">
                                                        <!-- <div class="sousiconeTextKraa">
                                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                            <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                        </div> -->
                                                        <div class="sousiconeTextKraa">
                                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                            <p class="kraaText"> <?php echo $price ?> </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="contentCardProd">
                                                <div class="group8">
                                                    <div class="imgTitleCours">
                                                        <div class="imgCoursProd">
                                                            <img src="<?php echo $image_author ?>" alt="">
                                                        </div>
                                                        <p class="nameCoursProd"> <?php echo(get_userdata($course->post_author)->data->display_name); ?> </p>
                                                    </div>
                                                    <div class="group9">
                                                        <div class="blockOpein">
                                                            <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                            <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                        </div>
                                                        <div class="blockOpein">
                                                            <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                            <p class="lieuAm"><?= $location ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="werkText"><?php echo $course->post_title ?></p>
                                                <p class="descriptionPlatform">
                                                    <?php echo get_field('short_description', $course->ID) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                    }
                                ?>
                                </div>
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

                        <div class="swiper-container swipeContaine4">
                            <div class="swiper-wrapper">
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
                                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="<?php echo $thumbnail ?>" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $category ?> </p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $price ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                    </div>
                                                    <p class="nameCoursProd">
                                                        <?php echo(get_userdata($course->post_author)->data->display_name); ?>
                                                    </p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                        <p class="lieuAm"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                        <p class="lieuAm"><?= $location ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText"><?php echo $course->post_title; ?></p>
                                            <p class="descriptionPlatform">
                                                <?php echo get_field('short_description', $course->ID);?>
                                            </p>
                                        </div>
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

                        <div class="swiper-container swipeContaine4">
                            <div class="swiper-wrapper">
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
                                <a href="<?php echo get_permalink($course->ID) ?>"  class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="<?php echo $thumbnail ?>" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $category ?> </p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $price ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                    </div>
                                                    <p class="nameCoursProd"> <?php echo(get_userdata($course->post_author)->data->display_name); ?> </p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                        <p class="lieuAm"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                        <p class="lieuAm"><?= $location ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText"><?php echo $course->post_title; ?></p>
                                            <p class="descriptionPlatform">
                                                <?php echo get_field('short_description', $course->ID);?> 
                                            </p>
                                        </div>
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
                <div class="sousBlockProduct2">
                    <p class="sousBlockTitleProduct">Artikels</p>
                    <div class="blockCardOpleidingen ">

                        <div class="swiper-container swipeContaine4">
                            <div class="swiper-wrapper">
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
                                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="<?php echo $thumbnail ?>" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $categorie ?></p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <!-- <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                    </div> -->
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $price ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img src="<?php echo $image_author ?>" alt="">
                                                    </div>
                                                    <p class="nameCoursProd"> <?php echo(get_userdata($course->post_author)->data->display_name); ?> </p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                        <p class="lieuAm"><?= $location ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText"><?php echo $course->post_title ?></p>
                                            <p class="descriptionPlatform">
                                                <?php echo get_field('short_description', $course->ID);?>
                                            </p>
                                        </div>
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
                    if(!empty($events)){
                ?>
                <div class="sousBlockProduct6">
                    <p class="sousBlockTitleProduct">Events</p>
                    <div class="blockCardOpleidingen">

                        <div class="swiper-container swipeContaineEvens">
                            <div class="swiper-wrapper">

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
                                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide">
                                    <div class="cardKraam1 cardKraamTest">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour2">
                                                <img src="<?php echo $thumbnail ?>" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/hours.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $hour ."h". $minute ?> </p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText"> <?php echo $price ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <p class="werkText"><?php echo $course->post_title; ?></p>
                                            <p class="descriptionPlatform">
                                                <?php echo get_field('short_description', $course->ID);?>
                                            </p>
                                        </div>
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
                    if(!empty($e_learnings)){
                ?>
                <div class="sousBlockProduct2">
                    <p class="sousBlockTitleProduct">E-Learnings</p>
                    <div class="blockCardOpleidingen ">
                                    
                        <div class="swiper-container swipeContaine4">
                            <div class="swiper-wrapper">
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
                                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                    <div class="cardKraam2">
                                        <div class="headCardKraam">
                                            <div class="blockImgCardCour">
                                                <img src="<?php echo $thumbnail ?>" alt="">
                                            </div>
                                            <div class="blockgroup7">
                                                <div class="iconeTextKraa">
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                        <p class="kraaText"><?php echo $category ?></p>
                                                    </div>
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                        <p class="kraaText"><?php echo get_field('degree', $course->ID);?></p>
                                                    </div>
                                                </div>
                                                <div class="iconeTextKraa">
                                                    <!-- <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                        <p class="kraaText"><?php echo $day . " " . $month ?></p>
                                                    </div> -->
                                                    <div class="sousiconeTextKraa">
                                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                        <p class="kraaText"><?php echo $price ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contentCardProd">
                                            <div class="group8">
                                                <div class="imgTitleCours">
                                                    <div class="imgCoursProd">
                                                        <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                    </div>
                                                    <p class="nameCoursProd"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                                </div>
                                                <div class="group9">
                                                    <div class="blockOpein">
                                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                        <p class="lieuAm"><?php echo get_field('course_type', $course->ID) ?></p>
                                                    </div>
                                                    <div class="blockOpein">
                                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                        <p class="lieuAm">Amsterdam</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="werkText"><?php echo $course->post_title; ?></p>
                                            <p class="descriptionPlatform">
                                                <?php echo get_field('short_description', $course->ID);?>
                                            </p>
                                        </div>
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
                if(!empty($trainings)){
            ?>
            <div class="sousBlockProduct2">
                <p class="sousBlockTitleProduct">Trainings</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
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
                            <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <div class="blockImgCardCour">
                                            <img src="<?php echo $thumbnail ?>" alt="">
                                        </div>
                                        <div class="blockgroup7">
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $category ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo get_field('degree', $course->ID);?> </p>
                                                </div>
                                            </div>
                                            <div class="iconeTextKraa">
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?> </p>
                                                </div>
                                                <div class="sousiconeTextKraa">
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $price ?> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img width="17" src="<?php echo $image_author ?> " alt="" >
                                                </div>
                                                <p class="nameCoursProd">
                                                    <?php echo(get_userdata($course->post_author)->data->display_name); ?>
                                                </p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                                </div>
                                                <div class="blockOpein">
                                                    <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                    <p class="lieuAm">Amsterdam</p>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $course->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo get_field('short_description', $course->ID);?>
                                        </p>
                                    </div>
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
            if(!empty($agenda)){
            ?>
            <div class="sousBlockProduct4">
                    <div class="headsousBlockProduct4">
                        <p class="sousBlockTitleProduct2 ml-1 ml-md-0">Agenda</p>
                        <div class="elementIconeRight">
                            <img class="imgIconeShowMore" src="<?php echo get_stylesheet_directory_uri();?>/img/IconShowMore.png" alt="">
                        </div>
                        <a href="/newFilesHtml/agenda.html" class="showAllLink">Show all</a>
                    </div>

                    <div class="row mr-md-2 mr-1">
                        <?php
                            $i = 0;
                            foreach($agenda as $course){
                                $location = '~';
                                
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
                                $image_author = $image_author ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                                
                        

                            ?>
                                <a href="<?php echo get_permalink($course->ID) ?>" class="col-md-12">
                                    <div class="blockCardFront">
                                        <div class="workshopBlock">
                                            <p class="workshopText"> <?php echo get_field('course_type', $course->ID) ?> </p>
                                            <div class="blockDateFront">
                                                <p class="moiText"><?php echo $month ?></p>
                                                <p class="dateText"><?php echo $day ?></p>
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
                            $i++; 

                            if ($i == 4)
                                break;
                        }            
                                
                        ?>
                    </div>
                </div>
            </div>
            <?php
                }
                }
            ?>
        </div>
    </div>
<?php  
    } 
?>
<?php get_footer(); ?>
<?php wp_footer(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: '3',
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
<script>
    var swiper = new Swiper('.swipeContaineVerkoop', {
        slidesPerView: '5',
        spaceBetween: 20,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
</script>
<script>
    var swiper = new Swiper('.swipeContaineEvens', {
        slidesPerView: '5',
        spaceBetween: 20,
        breakpoints: {
            780: {
                slidesPerView: 1,
                spaceBetween: 40,
            },
            1230: {
                slidesPerView: 3.9,
                spaceBetween: 20,
            }
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

    });
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

</body>
</html>

