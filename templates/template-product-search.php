<?php /** Template Name: Product Search */ ?>

<body>
    <?php wp_head(); ?>
    <?php get_header(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

    <?php require_once('postal.php'); ?>

    <?php 
        extract($_POST);

        $courses = array();
        $teachers = array();
        $categories = array();
        $profes = array();


        $args = array(
            'post_type' => 'course', 
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );
        $global_courses = get_posts($args);

 
        /* 
        * Get courses 
        */
        $course_categories = array();
        $course_users = array();

        if(isset($search)){
            $courses = array();
            $args = array(
                'post_type' => 'course', 
                'post_status' => 'publish',
                'posts_per_page' => -1,
            );
            $posts = get_posts($args);
            foreach($posts as $datum)
                if(stristr($datum->post_title, $search)){
                    array_push($courses, $datum);
                }
        }
        else{ 
            ## SIDE PRODUCT CATEGORIES 
            if(isset($category)){
                foreach($global_courses as $course)
                {
                    /*
                    * Categories
                    */ 
        
                    $category_id = 0;
                    $experts = get_field('experts', $post->ID);
                                
                    $tree = get_the_terms($course->ID, 'course_category');
                    $tree = $tree[2]->ID;
                    $categories_id = get_field('categories',  $course->ID);
                    $categories_xml = get_field('category_xml',  $course->ID);
                    $categories = array();
        
                    if($categories_xml)
                        foreach($categories_xml as $categorie){
                            $categorie = $categorie['value'];
                            if(!in_array($categorie, $categories))
                                array_push($categories, $categorie);
                        }
        
                    if($categories_id){
                        if(!empty($categories_id))
                            $categories = array();  
                            foreach($categories_id as $categorie)                    
                                $categories = explode(',', $categorie['value']);
                    }
        
        
                    if(in_array($category, $trees) || $categories)
                        if(in_array($category, $trees) || in_array($category, $categories)){
                            array_push($courses, $course);
                            if(!in_array($course->post_author, $teachers))
                                array_push($teachers, $course->post_author);
                            foreach($experts as $expert)
                                if(!in_array($expert, $teachers))
                                    array_push($teachers, $expert);
                        }
                }
            ## SIDE PRODUCT USERS
            }else if(isset($user)){
                foreach($global_courses as $course)
                {
                    $expert = get_field('experts', $course->ID);

                    if($course->post_author == $user || in_array($user, $expert) ){
                        array_push($courses, $course);
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
                        
                        $tree = get_the_category($course->ID);

                        if($tree){
                            if(isset($tree[2]))
                                $category = $tree[2]->cat_ID;
                        }else{
                            $category_id = intval(explode(',', get_field('categories',  $course->ID)[0]['value'])[0]); 
                            $category_xml = intval(get_field('category_xml',  $course->ID)[0]['value']);
                            if($category_xml != 0)
                                $category = $category_xml;  
                            if($category_id != 0)
                                $category = $category_id; 
                        }                                    
                        
                        if(!in_array($category, $categories) && $category != '')
                            array_push($categories, $category);
                        
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
                    'post_type' => 'course', 
                    'posts_per_page' => -1,
                    'author__in' => $users_companie,  
                );
        
                $courses = get_posts($args);
            }else{
                $args = array(
                    'post_type' => 'course', 
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                );
                $courses = get_posts($args);

                foreach($courses as $course)
                {
                    $experts = get_field('experts', $course->ID);
                    if(!in_array($course->post_author, $profes))
                        array_push($profes, $course->post_author);
                    foreach($experts as $expert)
                        if(!in_array($expert, $profes))
                            array_push($profes, $expert);
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
                        array_push($authors, $datum->post_author);

                        $experts = get_field('experts', $datum->ID);

                        $expertss = array_merge($authors, $experts);
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
                    <div class="LeerBlock pl-4" >
                        <div class="leerv">
                            <p class="sousProduct1Title" style="color: #043356">LEERVORM</p>
                            <button class="btn btnClose pb-1 p-0 px-1 m-0" id="hide">
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
                            <label class="contModifeCheck">Opleiding
                                <input style="color:red;" type="checkbox" id="opleiding" name="leervom[]" value="Opleidingen"  <?php if(isset($leervom)) if(in_array('Opleidingen', $leervom)) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Masterclass
                                <input type="checkbox" id="masterclass" name="leervom[]" value="Masterclass"  <?php if(isset($leervom)) if(in_array('Masterclass', $leervom)) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Workshop
                                <input type="checkbox" id="workshop" name="leervom[]" value="Workshop"  <?php if(isset($leervom)) if(in_array('Workshop', $leervom)) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">E-Learning
                                <input type="checkbox" id="learning" name="leervom[]" value="E-learning"  <?php if(isset($leervom)) if(in_array('E-learning', $leervom)) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div>
                        <div class="checkFilter">
                            <label class="contModifeCheck">Event
                                <input type="checkbox" id="event" name="leervom[]" value="Event"  <?php if(isset($leervom)) if(in_array('Event', $leervom)) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div> 
                        <div class="checkFilter">
                            <label class="contModifeCheck">Video
                                <input type="checkbox" id="event" name="leervom[]" value="Video" <?php if(isset($leervom)) if(in_array('Video', $leervom)) echo "checked" ; else echo ""  ?> >
                                <span class="checkmark checkmarkUpdated"></span>
                            </label>
                        </div> 
                        <div class="checkFilter">
                            <label class="contModifeCheck">Training
                                <input type="checkbox" id="event" name="leervom[]" value="Training" <?php if(isset($leervom)) if(in_array('Training', $leervom)) echo "checked" ; else echo ""  ?> >
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
                        if(isset($_POST['category']))

                            if(!isset($user)){
                        ?>
                            <?php
                                foreach($profes as $profe){
                                    $name = get_userdata($profe)->data->display_name;
                            ?>
                            <div class="checkFilter">
                                <label class="contModifeCheck"><?php echo $name ?>
                                    <input type="checkbox" id="sales" name="expert[]" value="<?php echo $profe; ?>" <?php if(!empty($expert)) if(in_array($profe, $expert)) echo "checked" ; else echo ""  ?> >
                                    <span class="checkmark checkmarkUpdated"></span>
                                </label>
                            </div>
                            <?php
                                }
                            ?>
                        <?php
                            }
                        ?>

                        <br><button type="submit" class="btn btn-default" style="background:#C0E9F4; padding:5px 20px;">Apply</button>

                    </div>

                </form>

            </div>
            <div class="mob filterBlock m-2 mr-4">
                <p class="fliterElementText">Filter</p>
                <button class="btn btnIcone8" id="show"><img src="<?php echo get_stylesheet_directory_uri();?>/img/filter.png" alt=""></button>
            </div>
        </div>
            <!-- ------------------------------------ End  Slide bar ---------------------------------------- -->                    



        
        <div class="col-md-9">
            <?php
                if(empty($courses)){
                    echo "<br><center><h3 class='liverTilteHead2'>No matches found 💣 </h3></center>";
                }
                else{
            ?>
            <div class="sousBlockProduct4">
                <div class="row d-flex justify-content-center">
                    <?php foreach($courses as $course) {?>
                    <?php  
                        /*
                        * Categories and Date
                        */  
                        $day = '~';
                        $month = '';  
                        $tree = get_the_category($course->ID);
                        if($tree){
                            if(isset($tree[2])){
                                $category = $tree[2]->cat_name;
                                $category =  "<p class='textJan facilityText'>" . $category . "</p>";

                            }else 
                                if(isset($tree[1])){
                                    $category = $tree[1]->cat_name;
                                    $category =  "<p class='textJan facilityText'>" . $category . "</p>";
                                }
                        }else 
                            $category = '';

                        $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];    

                        $dates = get_field('dates', $course->ID);
                        if($dates){
                            
                            $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                            $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];

                            $month = $calendar[$month]; 
                        }else{
                            $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                            $date = $data[0];
                            $day = explode('/', explode(' ', $date)[0])[0];
                            $month = explode('/', explode(' ', $date)[0])[1];
                            $month = $calendar[$month];

                            $location = $data[2];
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
                        $image_author = get_field('profile_img',  'user_' . $course->post_author);
                     ?>
                    <a href="<?php echo get_permalink($course->ID) ?>" class="col-md-11 pl-0">
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

<?php get_footer(); ?>
<?php wp_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="js/style.js"></script>
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
            event.preventDefault();
            $(".sousProductTest").hide();
        });
        $("#show").click(function(){
            event.preventDefault();
            $(".sousProductTest").show();
        });
    });
</script>
</body>