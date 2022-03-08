<?php


$courses = array();

extract($_POST);

$user = get_current_user_id();

/*
* * Get saved courses
*/

/* $saved = get_user_meta($user, 'course');

if(!empty($saved)){
    $args = array(
        'post_type' => 'course', 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'include' => $saved,  
    );

    $course_recorded = get_posts($args);
    $courses = $course_recorded;
}
*/

/*
* * 
*/

/*
* * Get interests courses
*/

$topics = get_user_meta($user, 'topic');

$experts = get_user_meta($user, 'expert');

$course_topics = array();
$course_experts = array();

if(!empty($topics)){
    $args = array(
        'post_type' => 'course', 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'category__in' => $topics,  
    );

    $course_topics = get_posts($args);
    $courses = array_merge($courses, $course_topics);
}


if(!empty($experts)){
    $args = array(
        'post_type' => 'course', 
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'author__in' => $experts,  
    );

    $course_experts = get_posts($args);
    $courses = array_merge($courses, $course_experts);
}


/*
* *   
*/

if(isset($_GET['message']))
    if($_GET['message'])
        echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>";
        
?>

<div class="block-treaning">
    <p class="trendingTitle"> Opleidingen</p>
    <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
        <?php
        $find = false;
        foreach($courses as $course){
            if(!get_field('visibility', $course->ID)) {
                if(get_field('course_type', $course->ID) == "Opleidingen"){
                    $find = true;

                    $month = '';
                    $location = 'Virtual';

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
                        $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                        if($category_id != 0)
                            $category = (String)get_the_category_by_ID($category_id);
                    }

                    /*
                    *  Date and Location
                    */ 

                    $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

                    $data = get_field('data_locaties', $course->ID);
                    if($data){
                        $date = $data[0]['data'][0]['start_date'];

                        $day = explode('/', explode(' ', $date)[0])[0];
                        $month = explode('/', explode(' ', $date)[0])[1];
                        $month = $calendar[$month];
                        
                        $location = $data[0]['data'][0]['location'];
                    }
                    else{
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

                    }

                    /*
                    * Price 
                    */
                    $p = " ";
                    $p = get_field('price', $course->ID);
                    if($p != "0")
                        $price =  number_format($p, 2, '.', ',');
                    else 
                        $price = 'Gratis';

                   /*
                    * Thumbnails
                    */ 
                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                    if(!$thumbnail){
                        $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                    }
                    
                    /*
                    * Companies
                    */ 
                    $company = get_field('company',  'user_' . $course->post_author);
        ?>
                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                    <div class="cardKraam">
                        <button class="btn btnCloche">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/cloche.png" alt="">
                        </button>
                        <div class="headCardKraam">
                            <div class="blockImgCardCour">
                                <img src="<?php echo $thumbnail; ?>" alt="">
                            </div>
                            <div class="blockgroup7">
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($category != " ") { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"><?php echo $category ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="sousiconeTextKraa">
                                        <?php if(get_field('degree', $course->ID)) { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo get_field('degree', $course->ID);?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($day) { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo $day . " " . $month ?></p>
                                        <?php } ?>
                                    </div>
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
                                    <?php
                                        if(!empty($company)){
                                            $company_title = $company[0]->post_title;
                                            $company_id = $company[0]->ID;
                                            $company_logo = get_field('company_logo', $company_id);
                                    ?>
                                    <div class="colorFront">
                                        <img src="<?php echo $company_logo; ?>" width="15" alt="">
                                    </div>
                                    <p class="textJan"><?php echo $company_title; ?></p>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="group9">
                                    <div class="blockOpein">
                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                        <p class="lieuAm">Opleidingen</p>
                                    </div>
                                    <div class="blockOpein">
                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                        <p class="lieuAm"><?php echo $location; ?></p>
                                    </div>
                                </div>
                            </div>
                            <p class="werkText"> <?php echo $course->post_title;?></p>
                            <p class="descriptionPlatform">
                                <?php echo get_field('short_description', $course->ID) ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php
            }
            }
            $i++;
        }
        if(!$find)
            echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";

        ?>

        </div>
    </div>
</div>

<div class="block-treaning">
    <p class="trendingTitle">Trending E-learnings</p>
    <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
            <?php
            $i = 0;
            $find = false;
            foreach($courses as $course){
                if(!get_field('visibility', $course->ID)) {
                    if(get_field('course_type', $course->ID) == "E-learning"){
                        $find = true;

                        $month = '';
                        $location = 'Virtual';
                        /*
                        * Categories and 
                        */
                        $category = ' '; 

                        $tree = get_the_terms($course->ID, 'course_category'); 
    
                        if($tree)
                            if(isset($tree[2]))
                                $category = $tree[2]->name;
    
                        $category_id = 0;
                    
                        if($category == ' '){
                            $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                            if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);
                        }
    

                        /*
                        *  Date and Location
                        */ 

                        $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];

                            $day = explode('/', explode(' ', $date)[0])[0];
                            $month = explode('/', explode(' ', $date)[0])[1];
                            $month = $calendar[$month];
                            
                            $location = $data[0]['data'][0]['location'];
                        }
                        else{
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

                        }

                        /*
                        * Price
                        */
                        $p = get_field('price', $course->ID);
                        if($p != "0")
                            $price =  number_format($p, 2, '.', ',') ;
                        else
                            $price = 'Gratis';

                       /*
                        * Thumbnails
                        */ 
                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                        if(!$thumbnail){
                            $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                            if(!$thumbnail)
                                $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                        }

                        /*
                        * Companies
                        */ 
                        $company = get_field('company',  'user_' . $course->post_author);
                       
                        ?>

                        <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                            <div class="cardKraam">
                                <button class="btn btnCloche">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/cloche.png" alt="">
                                </button>
                                <div class="headCardKraam">
                                    <div class="blockImgCardCour">
                                        <img src="<?php echo $thumbnail; ?>" alt="">
                                    </div>
                                    <div class="blockgroup7">
                                        <div class="iconeTextKraa">
                                            <div class="sousiconeTextKraa">
                                                <?php if($category != " ") { ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"><?php echo $category ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="sousiconeTextKraa">
                                                <?php if(get_field('degree', $course->ID)) { ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo get_field('degree', $course->ID);?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="iconeTextKraa">
                                            <div class="sousiconeTextKraa">
                                                <?php if($day) { ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?></p>
                                                <?php } ?>
                                            </div>
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
                                            <?php
                                                if(!empty($company)){
                                                    $company_title = $company[0]->post_title;
                                                    $company_id = $company[0]->ID;
                                                    $company_logo = get_field('company_logo', $company_id);
                                            ?>
                                            <div class="imgCoursProd">
                                                <img src="<?php echo $company_logo; ?>" width="15" alt="">
                                            </div>
                                            <p class="nameCoursProd"><?php echo $company_title; ?></p>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="group9">
                                            <div class="blockOpein">
                                                <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                <p class="lieuAm">E-learning</p>
                                            </div>
                                            <div class="blockOpein">
                                                <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                <p class="lieuAm"><?php echo $location ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="werkText"> <?php echo $course->post_title;?></p>
                                    <p class="descriptionPlatform">
                                        <?php echo get_field('short_description', $course->ID) ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <?php
                       
                    }
                }
            }
            if(!$find)
                echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";
            ?>

        </div>
    </div>
</div>

<div class="block-treaning">
    <p class="trendingTitle">Workshops</p>
    <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
            <?php
            $i = 0;
            $find = false;
            foreach($courses as $course){
                if(!get_field('visibility', $course->ID)) {
                    if(get_field('course_type', $course->ID) == "Workshop"){
                        $find = true;
                        $month = '';
                        $location = 'Virtual';
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
                            $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                            if($category_id != 0)
                                $category = (String)get_the_category_by_ID($category_id);
                        }

                        /*
                        *  Date and Location
                        */ 

                        $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

                        $data = get_field('data_locaties', $course->ID);
                        if($data){
                            $date = $data[0]['data'][0]['start_date'];

                            $day = explode('/', explode(' ', $date)[0])[0];
                            $month = explode('/', explode(' ', $date)[0])[1];
                            $month = $calendar[$month];
                            
                            $location = $data[0]['data'][0]['location'];
                        }
                        else{
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

                        }

                        /*
                        * Price
                        */
                        $p = get_field('price', $course->ID);
                        if($p != "0")
                            $price =  number_format($p, 2, '.', ',') ;
                        else
                            $price = 'Gratis';

                        /*
                        * Thumbnails
                        */ 
                        $thumbnail = get_the_post_thumbnail_url($course->ID);
                        if(!$thumbnail){
                            $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                            if(!$thumbnail)
                                $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                        }
                                                    
                        // Course type
                        $course_type = get_field('course_type', $course->ID);

                        /*
                        * Companies
                        */ 
                        $company = get_field('company',  'user_' . $course->post_author);
                        ?>
                        <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                            <div class="cardKraam">
                                <button class="btn btnCloche">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/cloche.png" alt="">
                                </button>
                                <div class="headCardKraam">
                                    <div class="blockImgCardCour">
                                        <img src="<?php echo $thumbnail; ?>" alt="">
                                    </div>
                                     <div class="blockgroup7">
                                        <div class="iconeTextKraa">
                                            <div class="sousiconeTextKraa">
                                                <?php if($category != " ") { ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                                    <p class="kraaText"><?php echo $category ?></p>
                                                <?php } ?>
                                            </div>
                                            <div class="sousiconeTextKraa">
                                                <?php if(get_field('degree', $course->ID)) { ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo get_field('degree', $course->ID);?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="iconeTextKraa">
                                            <div class="sousiconeTextKraa">
                                                <?php if($day) { ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                                    <p class="kraaText"> <?php echo $day . " " . $month ?></p>
                                                <?php } ?>
                                            </div>
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
                                            <?php
                                                if(!empty($company)){
                                                    $company_title = $company[0]->post_title;
                                                    $company_id = $company[0]->ID;
                                                    $company_logo = get_field('company_logo', $company_id);
                                            ?>
                                            <div class="imgCoursProd">
                                                <img src="<?php echo $company_logo; ?>" width="15" alt="">
                                            </div>
                                            <p class="nameCoursProd"><?php echo $company_title; ?></p>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <div class="group9">
                                            <div class="blockOpein">
                                                <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                <p class="lieuAm"><?php echo $course_type; ?></p>
                                            </div>
                                            <div class="blockOpein">
                                                <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                                <p class="lieuAm"><?php echo $location; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="werkText"> <?php echo $course->post_title;?></p>
                                    <p class="descriptionPlatform">
                                        <?php echo get_field('short_description', $course->ID) ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                        <?php
                    }
                }
            }
            if(!$find)
                echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";

            ?>

        </div>
    </div>
</div>

<div class="block-treaning">
    <p class="trendingTitle"> Masterclasses</p>
    <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
        <?php
        $find = false;
        foreach($courses as $course){
            if(!get_field('visibility', $course->ID)) {
                if(get_field('course_type', $course->ID) == "Masterclass"){
                    $find = true;
                    $day = '~';
                    $month = '';
                    $location = 'Virtual';

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
                        $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                        if($category_id != 0)
                            $category = (String)get_the_category_by_ID($category_id);
                    }

                    /*
                    *  Date and Location
                    */ 

                    $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

                    $data = get_field('data_locaties', $course->ID);
                    if($data){
                        $date = $data[0]['data'][0]['start_date'];

                        $day = explode('/', explode(' ', $date)[0])[0];
                        $month = explode('/', explode(' ', $date)[0])[1];
                        $month = $calendar[$month];
                        
                        $location = $data[0]['data'][0]['location'];
                    }
                    else{
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

                    }

                    /*
                    * Price 
                    */
                    $p = get_field('price', $course->ID);
                    if($p != "0")
                        $price =  number_format($p, 2, '.', ',') ;
                    else 
                        $price = 'Gratis';

                   /*
                    * Thumbnails
                    */ 
                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                    if(!$thumbnail){
                        $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                    }
                    
                    /*
                    * Companies
                    */ 
                    $company = get_field('company',  'user_' . $course->post_author);
        ?>
                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                    <div class="cardKraam">
                        <button class="btn btnCloche">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/cloche.png" alt="">
                        </button>
                        <div class="headCardKraam">
                            <div class="blockImgCardCour">
                                <img src="<?php echo $thumbnail; ?>" alt="">
                            </div>
                            <div class="blockgroup7">
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($category != " ") { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"><?php echo $category ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="sousiconeTextKraa">
                                        <?php if(get_field('degree', $course->ID)) { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo get_field('degree', $course->ID);?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($day) { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo $day . " " . $month ?></p>
                                        <?php } ?>
                                    </div>
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
                                    <?php
                                        if(!empty($company)){
                                            $company_title = $company[0]->post_title;
                                            $company_id = $company[0]->ID;
                                            $company_logo = get_field('company_logo', $company_id);
                                    ?>
                                    <div class="colorFront">
                                        <img src="<?php echo $company_logo; ?>" width="15" alt="">
                                    </div>
                                    <p class="textJan"><?php echo $company_title; ?></p>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="group9">
                                    <div class="blockOpein">
                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                        <p class="lieuAm">Masterclass</p>
                                    </div>
                                    <div class="blockOpein">
                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                        <p class="lieuAm"><?php echo $location; ?></p>
                                    </div>
                                </div>
                            </div>
                            <p class="werkText"> <?php echo $course->post_title;?></p>
                            <p class="descriptionPlatform">
                                <?php echo get_field('short_description', $course->ID) ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php
            }
            }
            $i++;
        }
        if(!$find)
            echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";

        ?>

        </div>
    </div>
</div>

<div class="online-eveans">
    <p class="trendingTitle">Online Events</p>
    <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
            <?php
            $month = '';
            $hour = '~';
            $minute = '';

            $i = 0;
            $find = false;
            foreach($courses as $course){
            if(!get_field('visibility', $course->ID)) {
            if(get_field('course_type', $course->ID) == "Event"){
                $find = true;
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
                    $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                    if($category_id != 0)
                        $category = (String)get_the_category_by_ID($category_id);
                }

            $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

            $dates = get_field('dates', $course->ID);
            if($dates){

                $day = explode('-', explode(' ', $dates[0]['date'])[0])[2];
                $month = explode('-', explode(' ', $dates[0]['date'])[0])[1];

                $month = $calendar[$month];

                $hour = explode(':', explode(' ', $dates[0]['date'])[1])[0];
                $minute = explode(':', explode(' ', $dates[0]['date'])[1])[1];

            }else{
                $data = explode('-', get_field('field_619f82d58ab9d', $course->ID)[0]['value']);
                $date = $data[0];
                $day = explode('/', explode(' ', $date)[0])[0];
                $month = explode('/', explode(' ', $date)[0])[1];
                $hour = explode(':', explode('-', $date[1])[0])[0];
                $minute = explode(':', explode('-', $date[1])[0])[1];
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
            $thumbnail = get_the_post_thumbnail_url($course->ID);
            if(!$thumbnail){
                $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                if(!$thumbnail)
                    $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
            }

            ?>
            <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swipSlideEvents">
                <div class="cardKraam">
                    <div class="headCardKraam">
                        <div class="blockImgCardCour2">
                            <img src="<?php echo $thumbnail; ?>" alt="">
                        </div>
                        <div class="blockgroup7">
                            <div class="iconeTextKraa">
                                <div class="sousiconeTextKraa">
                                    <?php if($hour != "~") { ?>
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                        <p class="kraaText"> <?php echo $hour .":". $minute ?></p>
                                    <?php } ?>
                                </div>
                                <div class="sousiconeTextKraa">
                                    <?php if($day) { ?>
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                        <p class="kraaText"> <?php echo $day . " " . $month ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="iconeTextKraa">
                                <div class="sousiconeTextKraa">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/euro1.png" class="icon7" alt="">
                                    <p class="kraaText"><?php echo $price ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="contentCardProd">
                        <p class="werkText"> <?php echo $course->post_title;?></p>
                        <p class="descriptionPlatform">
                            <?php echo get_field('short_description', $course->ID) ?>
                        </p>
                    </div>
                </div>
            </a>
                <?php

            }
            }
                $i++;
            }
            if(!$find)
                echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";
            ?>
        </div>
    </div>
</div>

<div class="block-treaning">
    <p class="trendingTitle"> Videos</p>
    <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
        <?php
        $i = 0;
        $find = false;  
        foreach($courses as $course){
            if(!get_field('visibility', $course->ID)) {
                if(get_field('course_type', $course->ID) == "Video"){
                    $find = true;
                    $month = '';
                    $location = 'Virtual';

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
                        $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                        if($category_id != 0)
                            $category = (String)get_the_category_by_ID($category_id);
                    }

                    /*
                    *  Date and Location
                    */ 

                    $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

                    $data = get_field('data_locaties', $course->ID);
                    if($data){
                        $date = $data[0]['data'][0]['start_date'];

                        $day = explode('/', explode(' ', $date)[0])[0];
                        $month = explode('/', explode(' ', $date)[0])[1];
                        $month = $calendar[$month];
                        
                        $location = $data[0]['data'][0]['location'];
                    }
                    else{
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

                    }

                    /*
                    * Price 
                    */
                    $p = get_field('price', $course->ID);
                    if($p != "0")
                        $price =  number_format($p, 2, '.', ',') ;
                    else 
                        $price = 'Gratis';

                   /*
                    * Thumbnails
                    */ 
                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                    if(!$thumbnail){
                        $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                    }
                    
                    /*
                    * Companies
                    */ 
                    $company = get_field('company',  'user_' . $course->post_author);
        ?>
                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                    <div class="cardKraam">
                        <button class="btn btnCloche">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/cloche.png" alt="">
                        </button>
                        <div class="headCardKraam">
                            <div class="blockImgCardCour">
                                <img src="<?php echo $thumbnail; ?>" alt="">
                            </div>
                            <div class="blockgroup7">
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($category != " ") { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"><?php echo $category ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="sousiconeTextKraa">
                                        <?php if(get_field('degree', $course->ID)) { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo get_field('degree', $course->ID);?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($day != ' ') { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo $day . " " . $month ?></p>
                                        <?php } ?>
                                    </div>
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
                                    <?php
                                        if(!empty($company)){
                                            $company_title = $company[0]->post_title;
                                            $company_id = $company[0]->ID;
                                            $company_logo = get_field('company_logo', $company_id);
                                    ?>
                                    <div class="colorFront">
                                        <img src="<?php echo $company_logo; ?>" width="15" alt="">
                                    </div>
                                    <p class="textJan"><?php echo $company_title; ?></p>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="group9">
                                    <div class="blockOpein">
                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                        <p class="lieuAm">Video</p>
                                    </div>
                                    <div class="blockOpein">
                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                        <p class="lieuAm"><?php echo $location; ?></p>
                                    </div>
                                </div>
                            </div>
                            <p class="werkText"> <?php echo $course->post_title;?></p>
                            <p class="descriptionPlatform">
                                <?php echo get_field('short_description', $course->ID) ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php
            }
            }
        }
        if(!$find)
            echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";
        ?>

        </div>
    </div>
</div>

<div class="block-treaning">
    <p class="trendingTitle"> Cursus</p>
    <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
        <?php
        $i = 0;
        $find = false;
        foreach($courses as $course){
            if(!get_field('visibility', $course->ID)) {
                if(get_field('course_type', $course->ID) == "Cursus"){

                    $find = true;
                    $day = '~';
                    $month = '';
                    $location = 'Virtual';

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
                        $category_id = intval(get_field('category_xml',  $course->ID)[0]['value']);
                        if($category_id != 0)
                            $category = (String)get_the_category_by_ID($category_id);
                    }

                    /*
                    *  Date and Location
                    */ 

                    $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];    

                    $data = get_field('data_locaties', $course->ID);
                    if($data){
                        $date = $data[0]['data'][0]['start_date'];

                        $day = explode('/', explode(' ', $date)[0])[0];
                        $month = explode('/', explode(' ', $date)[0])[1];
                        $month = $calendar[$month];
                        
                        $location = $data[0]['data'][0]['location'];
                    }
                    else{
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

                    }

                    /*
                    * Price 
                    */
                    $p = get_field('price', $course->ID);
                    if($p != "0")
                        $price =  number_format($p, 2, '.', ',') ;
                    else 
                        $price = 'Gratis';

                   /*
                    * Thumbnails
                    */ 
                    $thumbnail = get_the_post_thumbnail_url($course->ID);
                    if(!$thumbnail){
                        $thumbnail = get_field('field_619ffa6344a2c', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                    }
                    
                    /*
                    * Companies
                    */ 
                    $company = get_field('company',  'user_' . $course->post_author);
        ?>
                <a href="<?php echo get_permalink($course->ID) ?>" class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                    <div class="cardKraam">
                        <button class="btn btnCloche">
                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/cloche.png" alt="">
                        </button>
                        <div class="headCardKraam">
                            <div class="blockImgCardCour">
                                <img src="<?php echo $thumbnail; ?>" alt="">
                            </div>
                            <div class="blockgroup7">
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($category != " ") { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/kraam.png" class="icon7" alt="">
                                            <p class="kraaText"><?php echo $category ?></p>
                                        <?php } ?>
                                    </div>
                                    <div class="sousiconeTextKraa">
                                        <?php if(get_field('degree', $course->ID)) { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/mbo3.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo get_field('degree', $course->ID);?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="iconeTextKraa">
                                    <div class="sousiconeTextKraa">
                                        <?php if($day != ' ') { ?>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/img/calend.png" class="icon7" alt="">
                                            <p class="kraaText"> <?php echo $day . " " . $month ?></p>
                                        <?php } ?>
                                    </div>
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
                                    <?php
                                        if(!empty($company)){
                                            $company_title = $company[0]->post_title;
                                            $company_id = $company[0]->ID;
                                            $company_logo = get_field('company_logo', $company_id);
                                    ?>
                                    <div class="colorFront">
                                        <img src="<?php echo $company_logo; ?>" width="15" alt="">
                                    </div>
                                    <p class="textJan"><?php echo $company_title; ?></p>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <div class="group9">
                                    <div class="blockOpein">
                                        <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                        <p class="lieuAm">Cursus</p>
                                    </div>
                                    <div class="blockOpein">
                                        <img class="iconAm1" src="<?php echo get_stylesheet_directory_uri();?>/img/map.png" alt="">
                                        <p class="lieuAm"><?php echo $location; ?></p>
                                    </div>
                                </div>
                            </div>
                            <p class="werkText"> <?php echo $course->post_title;?></p>
                            <p class="descriptionPlatform">
                                <?php echo get_field('short_description', $course->ID) ?>
                            </p>
                        </div>
                    </div>
                </a>
                <?php
            }
            }
        }
        if(!$find)
            echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";
        ?>

        </div>
    </div>
</div>
