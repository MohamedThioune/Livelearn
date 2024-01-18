<?php /** Template Name: Product Search old */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<?php
//$page = 'check_visibility.php';
//require($page);
?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php require_once('postal.php'); ?>

<?php
extract($_POST);

$courses = array();
$teachers = array();
$categories = array();
$profes = array();
$topic = "";

if (!isset($leervom))
    $leervom = array();

$args = array(
    'post_type' => array('post','course'),
    'post_status' => 'publish',
    'orderby' => 'date',
    'order'   => 'DESC',
    'posts_per_page' => -1,
);
$global_courses = get_posts($args);

/* * Header filter
*/
if($_GET['filter'] == "header")
    $leervom = array($_GET['opleidin']);

/*
* Get courses
*/
$course_categories = array();
$course_users = array();

if(isset($category)){
    ## SIDE PRODUCT CATEGORIES
    foreach($global_courses as $course)
    {
        $hidden = true;
        $hidden = visibility($course, $visibility_company);
        if(!$hidden)
            continue;

        $bool = false;
        $experts = get_field('experts', $post->ID);

        /*
        * Categories
        */

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
                if(!in_array($course->post_author, $teachers))
                    array_push($teachers, $course->post_author);
                foreach($experts as $expert)
                    if(!in_array($expert, $teachers))
                        array_push($teachers, $expert);
            }

        $experts = get_field('experts', $course->ID);
        if(!empty($profes))
            if(!in_array($course->post_author, $profes))
                array_push($profes, $course->post_author);
        if(!empty($experts))
            foreach($experts as $expert)
                if(!in_array($expert, $profes))
                    array_push($profes, $expert);
    }
}else if(isset($user)){
    ## SIDE PRODUCT USERS
    foreach($global_courses as $course)
    {
        $hidden = true;
        $hidden = visibility($course, $visibility_company);
        if(!$hidden)
            continue;

        $bool = false;
        $expert = get_field('experts', $course->ID);

        if($course->post_author == $user)
            $bool = true;
        if(!empty($expert))
            if(in_array($user, $expert))
                $bool = true;

        if($bool){
            array_push($courses, $course);

            /*
            * Categories
            */
            $category = 0;
            if($category == ' '){
                $one_category = get_field('categories',  $course->ID);
                if(isset($one_category[0]['value']))
                    $category = intval(explode(',', $one_category[0]['value'])[0]);
                else{
                    $one_category = get_field('category_xml',  $course->ID);
                    if(isset($one_category[0]['value']))
                        $category = intval($one_category[0]['value']);
                }
            }

            $experts = get_field('experts', $course->ID);
            if(!in_array($course->post_author, $profes))
                array_push($profes, $course->post_author);
            foreach($experts as $expert)
                if(!in_array($expert, $teachers))
                    array_push($teachers, $expert);
        }
    }
}
else if(isset($companie)) {
    ## SIDE PRODUCT COMPANIES
    $args = array(
        'post_type' => 'company',
        'posts_per_page' => 1,
        'include' => $companie
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

    $args = array(
        'post_type' => array('post','course'),
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order'   => 'DESC',
        'author__in' => $users_companie,
    );

    $courses = get_posts($args);
}
else{
    $args = array(
        'post_type' => array('post','course'),
        'post_status' => 'publish',
        'orderby' => 'date',
        'order'   => 'DESC',
        'posts_per_page' => 500,
    );
    $courses = get_posts($args);

    foreach($courses as $course){
        $experts = get_field('experts', $course->ID);
        if(!empty($profes))
            if(!in_array($course->post_author, $profes))
                array_push($profes, $course->post_author);
        if(!empty($experts))
            foreach($experts as $expert)
                if(!in_array($expert, $profes))
                    array_push($profes, $expert);
    }
    if(empty($experties)){
        $experties = array();
        $args = array(
            'role__in' => ['author'],
            'posts_per_page' => -1,
        );
        $expertiess = get_users($args);
        foreach($expertiess as $value)
            array_push($experties, $value->ID);

    }

}

## START WITH THE FILTERS
/**
 * Leervom Group
 */
if(!empty($leervom)){
    $i = 0;
    foreach($courses as $datum){
        $coursetype = get_field('course_type', $datum->ID);
        if(!in_array($coursetype, $leervom)){
            unset($courses[$i]);
        }
        $i++;
    }
}
/**
 * Price interval
 */
if(isset($min) || isset($max) || isset($gratis)){
    if(isset($gratis)){
        if($gratis){
            $prices = array();
            foreach($courses as $datum){
                $price = intval(get_field('price', $datum->ID));
                if($price == 0)
                    array_push($prices,$datum);
            }
        }
    }else if(isset($min) || isset($max)){
        if($min || $max){
            $prices = array();
            $tmp = 0;
            if($min != null && $max!= null){
                if($min > $max) {
                    $tmp = $min;
                    $min = $max;
                    $max = $tmp;
                }
                //Here we got interval
                foreach($courses as $datum){
                    $price = intval(get_field('price', $datum->ID));
                    $min = intval($min);
                    $max = intval($max);
                    if($price >= $min)
                        if($price <= $max)
                            array_push($prices,$datum);
                }
            }
            else{
                //Tested by one value
                foreach($courses as $datum){
                    $price = intval(get_field('price', $datum->ID));
                    if($min == null){
                        $max = intval($max);
                        if($price <= $max)
                            array_push($prices,$datum);
                    }
                    else if($max == null){
                        $min = intval($min);
                        if($price >= $min)
                            array_push($prices,$datum);
                    }
                }
            }
        }
    }
    if(isset($prices)){
        if(!empty($prices)){
            $courses = $prices;
        }
        else{
            $courses = array();
        }
    }
}
/**
 * Location orientation
 */
if(isset($locate) || isset($online)){
    if(isset($online)){
        if($online){
            $locates = array();
            foreach($courses as $datum){
                //Iterate the location ?
                $data = get_field('data_locaties', $datum->ID);
                if(!$data)
                    array_push($locates,$datum);
            }
        }
    }else if(isset($locate)){
        if($locate)
            if($locate != null){
                $locates = array();
                if($range == null)
                    $range = 1;
                $scope_postal = postal_range($locate, $range);

                array_push($scope_postal, $locate);

                $cities = array();
                $municipalities = array();
                $provinces = array();

                $compare = array();

                if($scope_postal)
                    foreach($scope_postal as $postal){
                        $value = postal_locator($postal);

                        if(!in_array($value[0]->{'city'}, $cities))
                            array_push($cities, $value[0]->{'city'});

                        if(!in_array($value[0]->{'municipality'}, $municipalities))
                            array_push($municipalities, $value[0]->{'municipality'});

                        if(!in_array($value[0]->{'province'}, $provinces))
                            array_push($provinces, $value[0]->{'province'});
                    }

                if($cities || count($cities) >= 0)
                    $compare = $cities;
                else if(!$cities || count($cities) <= 0)
                    $compare = $municipalities;
                else if(!$municipalities || count($municipalities) <= 0)
                    $compare = $provinces;

                foreach($courses as $datum){
                    //Iterate the location ?
                    $data = get_field('data_locaties', $datum->ID);
                    if($data)
                        if(!empty($data)){
                            $datx = $data[0]['data'];
                            if($datx){
                                $location = $datx[0]['location'];
                                if($location != ""){
                                    if(in_array($location, $compare))
                                        array_push($locates,$datum);
                                }
                            }
                        }
                }
            }
    }
    if(isset($locates)){
        if(!empty($locates)){
            $courses = $locates;
        }
        else{
            $courses = array();
        }
    }
}
/**
 * Expert request
 */
if(isset($experties))
    if(!empty($experties)){
        $teachers = array();
        foreach($courses as $datum){
            $authors = array();
            $expertss = array();
            array_push($authors, $datum->post_author);

            $experts = get_field('experts', $datum->ID);

            if($experts)
                $expertss = array_merge($authors, $experts);
            else
                $expertss = $authors;
            foreach($experties as $expertie)
                if(in_array($expertie,$expertss) ){
                    array_push($teachers, $datum);
                    break;
                }
        }
        if(isset($teachers)){
            if(!empty($teachers)){
                $courses = $teachers;
            }
            else{
                $courses = array();
            }
        }
    }
$close_menu = get_stylesheet_directory_uri() . '/img/X.png';

?>

<style>
    .checkmarkUpdated{
        background-color: white !important;
        border: 2px solid #043356 !important;
    }
    .LeerBlock {
        border-bottom: 2px solid #043356 !important;
    }
    .text-limit {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    @media all and (min-width: 570px) and (max-width: 756px) {
        .filterBlock{
            margin-top: 40px !important;
        }
    }

</style>

<div class="contentOne">
</div>
<!-- <div class="head2">
    <div class="d-flex elementText3">
        <p class="liverTilteHead2">Search</p>
    </div>
</div> -->

<div class="searchBlock">
    <div class="row">

        <!-- ------------------------------------ Start Slide bar ---------------------------------------- -->
        <div class="col-md-3 pr-0">
            <div class="sousProductTest Mobelement pr-4"
                 style="background: #F4F7F6;color: #043356; border-top: none">
                <form action="/product-search/" method="POST">
                    <div class="LeerBlock pl-4">
                        <div class="leerv">
                            <p class="sousProduct1Title" style="color: #043356">LEERVORM</p>
                            <button type="reset" class="btn btnClose pb-1 p-0 px-1 m-0" id="hide">
                                <i class="bi bi-x text-dark" style="font-size: 35px"></i>
                            </button>
                        </div>
                        <?php
                        if(isset($_POST['category']))
                            echo "<input type='hidden' name='category' value='".$category."'>";
                        else if(isset($_POST['user']))
                            echo "<input type='hidden' name='user' value='".$user."'>";
                        else if(isset($_POST['companie']))
                            echo "<input type='hidden' name='companie' value='".$companie."'>";
                        ?>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Opleidingen
                                <input style="color:red;" type="checkbox" id="opleiding" name="leervom[]" value="Opleidingen"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Opleidingen', $leervom) || $search_type == "Opleidingen" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Masterclass
                                <input type="checkbox" id="masterclass" name="leervom[]" value="Masterclass"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Masterclass', $leervom) || $search_type == "Masterclass" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Workshop
                                <input type="checkbox" id="workshop" name="leervom[]" value="Workshop"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Workshop', $leervom) || $search_type == "Workshop" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">E-Learning
                                <input type="checkbox" id="learning" name="leervom[]" value="E-learning"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('E-learning', $leervom) || $search_type == "E-learning" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Event
                                <input type="checkbox" id="event" name="leervom[]" value="Event"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Event', $leervom) || $search_type == "Event" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Video
                                <input type="checkbox" id="event" name="leervom[]" value="Video" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Video', $leervom) || $search_type == "Video" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Training
                                <input type="checkbox" id="event" name="leervom[]" value="Training" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Training', $leervom) || $search_type == "Training" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Artikel
                                <input type="checkbox" id="event" name="leervom[]" value="Artikel" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Artikel', $leervom) || $search_type == "Artikel" ) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <br>
                    </div>
                    <div class="LeerBlock pl-4" >
                        <p class="sousProduct1Title" style="color: #043356;">PRIJS</p>
                        <div class="prijsSousBlock" style="color: #043356;">
                            <span class="vanafText" style="color: #043356">Vanaf</span>
                            <input name="min" style="width:100px;"  class="btn btnmin text-left" value="<?php if(isset($min)) echo $min ?>" placeholder="€min">
                        </div>
                        <div class="prijsSousBlock" style="color: #043356;">
                            <span class="vanafText" style="color: #043356">tot</span>
                            &nbsp; &nbsp;&nbsp;&nbsp;
                            <input name="max" style="width:100px" class="btn btnmin text-left"  value="<?php if(isset($max)) echo $max ?>" mplaceholder="€max">
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Alleen gratis
                                <input type="checkbox" id="Allen" name="gratis" <?php if(isset($gratis)) echo 'checked'; else  echo  '' ?>>
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
                                <input type="checkbox" id="Alleen-online" name="online" <?php if(isset($online)) echo 'checked'; else  echo  '' ?>>
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                    </div>

                    <div class="LeerBlock pl-4">
                        <p class="sousProduct1Title" style="color: #043356;">EXPERT</p>

                        <?php
                        foreach($experties as $profe){
                            if(!$profe)
                                continue;

                            $teacher_data = get_user_by('id', $profe);

                            $user_id = get_current_user_id();
                            if($teacher_data->ID != $user_id)
                                $name = ($teacher_data->last_name) ? $teacher_data->first_name : $teacher_data->display_name;
                            else
                                $name = "Ikzelf";

                            if($teacher_data->first_name == "")
                                continue;

                            ?>
                            <div class="checkFilter">
                                <label class="contModifeCheck"><?php echo $name ?>
                                    <input type="checkbox" id="sales" name="experties[]" value="<?php echo $profe; ?>" <?php if(!empty($expert)) if(in_array($profe, $expert)) echo "checked" ; else echo ""  ?> >
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
            <div class="mob filterBlock m-2 mr-4" id="show">
                <p class="fliterElementText">Filter</p>
                <button class="btn btnIcone8" ><img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt=""></button>
            </div>
        </div>
        <!-- ------------------------------------ End  Slide bar ---------------------------------------- -->




        <div class="col-md-9">
            <?php
            if(empty($courses)){
                echo "<br><center><h3 class='liverTilteHead2'>No matches found </h3></center>";
            }
            else{
                ?>
                <div class="sousBlockProduct4">
                    <div class="row d-flex justify-content-center">
                        <?php
                        $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

                        foreach($courses as $key => $course){

                            if(!empty($company_visibility))
                                if(!visibility($course, $visibility_company))
                                    continue;

                            if($key == 20)
                                break;

                            /*
                            * Categories
                            */
                            $location = 'Virtual';
                            $day = "-";
                            $month = '';

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
                                    $category = "<p class='textJan facilityText'>" . (String)get_the_category_by_ID($category_str) . "</p>";
                                else if($category_id != 0)
                                    $category = "<p class='textJan facilityText'>" . (String)get_the_category_by_ID($category_id) . "</p>";
                            }

                            /*
                            *  Date and Location
                            */
                            $day = "-";
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
                                $price =  number_format($p, 2, '.', ',');
                            else
                                $price = 'Gratis';


                            /*
                            * Thumbnails
                            */
                            $thumbnail = get_field('preview', $course->ID)['url'];
                            if(!$thumbnail){
                                $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_stylesheet_directory_uri() . '/img/placeholder_opleidin.webp';
                            }

                            //Image author of this post
                            $image_author = get_field('profile_img',  'user_' . $course->post_author) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png' ;
                            ?>
                            <a href="<?php echo get_permalink($course->ID) ?>" class="col-md-11">
                                <div class="blockCardSearch">
                                    <div class="searchContentBlock">
                                        <p class="deToekomstText"><?php echo $course->post_title; ?></p>
                                        <p class="platformText"><?php echo $course->post_excerpt; ?></p>
                                        <div class="detaiElementAgenda detaiElementAgendaModife">
                                            <div class="janBlock">
                                                <div class="colorFront">
                                                    <img src="<?php echo $image_author ?>" width="15" alt="">
                                                </div>
                                                <p class="textJan"><?php echo(get_userdata($course->post_author)->data->display_name); ?></p>
                                            </div>
                                            <div class="euroBlock">
                                                <img class="euroImg" src="<?php echo get_stylesheet_directory_uri();?>/img/euro.png" alt="">
                                                <p class="textJan"><?php echo $price ?></p>
                                            </div>
                                            <div class="zwoleBlock">
                                                <img class="ss" src="<?php echo get_stylesheet_directory_uri();?>/img/ss.png" alt="">
                                                <?php
                                                $data = get_field('data_locaties', $course->ID);
                                                if($data)
                                                    if(!empty($data)){
                                                        $datx = $data[0]['data'];
                                                        if($datx){
                                                            $location = $datx[0]['location'];
                                                            $location = "<p class='textJan'>" . $location . "</p>";
                                                        }
                                                    }
                                                ?>
                                                <?php echo $location; ?>
                                            </div>
                                            <div class="facilityBlock">
                                                <img class="faciltyImg" src="<?php echo get_stylesheet_directory_uri();?>/img/map-search.png" alt="">
                                                <?php echo $category; ?>
                                            </div>
                                        </div>
                                        <!-- description course -->
                                        <div class="mt-3 text-limit">
                                            <?php echo get_field('short_description', $course->ID) ?>
                                        </div>

                                    </div>
                                    <div class="searchBlockImg">
                                        <img src="<?php echo $thumbnail; ?>" alt="Thumbnail videos">
                                        <div class="blockgroup8">
                                            <div class="sousiconeTextKraa">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                <p class="kraaText"><?php echo $day .' '. $month; ?></p>
                                            </div>
                                            <div class="sousiconeTextKraa price" style="background-color: #023356 !important; color: white !important">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                                <p class="kraaText"  style="overflow: visible !important"><?php echo $price; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>