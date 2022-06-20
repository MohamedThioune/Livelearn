<?php


$courses = array();

extract($_POST);

$user = get_current_user_id();

$subtopics = array(); 
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
        $subtopics = array_merge($subtopics, $subtopic);      
    }
}


/*
* * Get interests courses
*/

$topics = get_user_meta($user, 'topic');

$experts = get_user_meta($user, 'expert');

$args = array(
    'post_type' => 'course', 
    'post_status' => 'publish',
    'posts_per_page' => -1,
);

$global_courses = get_posts($args);

$opleidingen = array();
$workshops = array();
$masterclasses = array();
$events = array();
$e_learnings = array();
$trainings = array();
$videos = array();
$courses_id = array();


$args = array(
    'post_type' => 'course', 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author__in' => $experts,
);

$expert_courses = get_posts($args);
$count = array('opleidingen' => 0, 'workshop' => 0, 'masterclass' => 0, 'event' => 0, 'e_learning' => 0, 'training' => 0, 'video' => 0);
$loop_break = array();

foreach($global_courses as $course)
{
    /*
    * Categories
    */ 

    $category_id = 0;
    $experts = get_field('experts', $course->ID);
                
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

    if($categories_id)
        if(!empty($categories_id)){
            $categories = array();  
            foreach($categories_id as $categorie)                    
                $categories = explode(',', $categorie['value']);
        }

    foreach($topics as $topic_value){
        if(in_array($topic_value, $trees) || $categories)
            if(in_array($topic_value, $trees) || in_array($topic_value, $categories) ){
                if(!in_array($course->ID,$courses_id)){
                    array_push($courses, $course);
                    array_push($courses_id, $course->ID);
                    break;
                }
                if(get_field('course_type', $course->ID) == "Opleidingen"){
                    array_push($opleidingen, $course);
                    $count['opleidingen'] = $count['opleidingen'] + 1;
                }else if(get_field('course_type', $course->ID) == "Workshop"){
                    array_push($workshops, $course);
                    $count['workshop'] = $count['workshop'] + 1;
                }else if(get_field('course_type', $course->ID) == "Masterclass"){
                    array_push($masterclasses, $course);
                    $count['masterclass'] = $count['masterclass'] + 1;
                }else if(get_field('course_type', $course->ID) == "Event"){
                    array_push($events, $course);
                    $count['event'] = $count['event'] + 1;
                }else if(get_field('course_type', $course->ID) == "E-learning"){
                    array_push($e_learnings, $course);
                    $count['e_learning'] = $count['e_learning'] + 1;
                }else if(get_field('course_type', $course->ID) == "Training"){
                    array_push($trainings, $course);
                    $count['training'] = $count['training'] + 1;
                }else if(get_field('course_type', $course->ID) == "Video"){
                    array_push($videos, $course);
                    $count['video'] = $count['video'] + 1;
                }
        }

        foreach($count as $type => $value){
            if($value >= 6 && !in_array($type,$loop_break))
                array_push($loop_break,$type);
        }

    }

    foreach($experts as $topic_expert){
        $experties = get_field('experts', $course->ID);    
        if($course->post_author == $topic_expert || in_array($topic_expert, $experties) ){
            if(!in_array($course->ID,$courses_id)){
                array_push($courses, $course);
                array_push($courses_id, $course->ID);
                break;
            }
        }
    }

    if(count($loop_break) >= 3)
        break;
   
}

$courses = array_merge($courses, $expert_courses);
 
//Activitien
$activitiens = count($courses);

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
                    $thumbnail = get_field('preview', $course->ID)['url'];
                    if(!$thumbnail){
                        $thumbnail = get_field('url_image_xml', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_field('image', 'category_'. $category_id);
                            if(!$thumbnail)
                                $thumbnail = get_stylesheet_directory_uri() . '/img/libay.png';
                    }
                    
                    /*
                    * Companies
                    */ 
                    $company = get_field('company',  'user_' . $course->post_author);
        ?>
                    <div class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                        <div class="blockLoveCourse">
                            <button class="btn btn_dislike">
                                <img  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-dislike.png" alt="">
                            </button>
                            <button class="btn btn_like">
                                <img  src="<?php echo get_stylesheet_directory_uri();?>/img/heart-like.png" alt="">
                            </button>
                        </div>

                        <a href="<?php echo get_permalink($course->ID) ?>" class="" >
                            <div class="cardKraam">
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

                    </div>



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
                        $thumbnail = get_field('preview', $course->ID)['url'];
                        if(!$thumbnail){
                            $thumbnail = get_field('url_image_xml', $course->ID);
                            if(!$thumbnail)
                                $thumbnail = get_field('image', 'category_'. $category_id);
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
                        $thumbnail = get_field('preview', $course->ID)['url'];
                        if(!$thumbnail){
                            $thumbnail = get_field('url_image_xml', $course->ID);
                            if(!$thumbnail)
                                $thumbnail = get_field('image', 'category_'. $category_id);
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
                    $thumbnail = get_field('preview', $course->ID)['url'];
                    if(!$thumbnail){
                        $thumbnail = get_field('url_image_xml', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_field('image', 'category_'. $category_id);
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
            $thumbnail = get_field('preview', $course->ID)['url'];
            if(!$thumbnail){
                $thumbnail = get_field('url_image_xml', $course->ID);
                if(!$thumbnail)
                    $thumbnail = get_field('image', 'category_'. $category_id);
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
                    $thumbnail = get_field('preview', $course->ID)['url'];
                    if(!$thumbnail){
                        $thumbnail = get_field('url_image_xml', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_field('image', 'category_'. $category_id);
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
                    $thumbnail = get_field('preview', $course->ID)['url'];
                    if(!$thumbnail){
                        $thumbnail = get_field('url_image_xml', $course->ID);
                        if(!$thumbnail)
                            $thumbnail = get_field('image', 'category_'. $category_id);
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
    
    //Categories
    $bangerichts = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[1],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $functies = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[0],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $skills = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[3],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $interesses = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'parent'  => $categories[2],
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );

    $subtopics = array(); 
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
            $subtopics = array_merge($subtopics, $subtopic);      
        }
    }

    foreach($bangerichts as $key1=>$tag){
        
        //Topics
        $cats_bangerichts = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_bangerichts)!=0)
        {
            $row_bangrichts.='<div hidden=true class="cb_topics_bangricht_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_bangerichts as $key => $value)
            {   
                $row_bangrichts .= '
                <input type="checkbox" name="choice_bangrichts_'.$value->cat_ID.'" value= '.$value->cat_ID .' id=subtopics_bangricht_'.$value->cat_ID.' /><label class="labelChoose" for=subtopics_bangricht_'.$value->cat_ID.'>'. $value->cat_name .'</label>';
            }
            $row_bangrichts.= '</div>';
        }
      
    }

    foreach($functies as $key1 =>$tag)
    {
        
        //Topics
        $cats_functies = get_categories(
            array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_functies)!=0)
        {
            $row_functies.='<div hidden=true class="cb_topics_funct_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_functies as $key => $value)
            {   
            $row_functies .= '
            <input type="checkbox" name="choice_functies_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_funct_'.($value->cat_ID).'" /><label class="labelChoose" for="cb_funct_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_functies.= '</div>';
        }
    }

    foreach($skills as $key1=>$tag){
        //Topics
        $cats_skills = get_categories( array(
            'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
            'parent' => $tag->cat_ID,
            'hide_empty' => 0, // change to 1 to hide categores not having a single post
        ));
        if (count($cats_skills)!=0)
        {
            $row_skills.='<div hidden=true class="cb_topics_skills_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_skills as $key => $value)
            {   
                    $row_skills .= '
                    <input type="checkbox" name="choice_skills'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_skills_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_skills_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_skills.= '</div>';
        }
      
    }

    foreach($interesses as $key1=>$tag){
        //Topics
            $cats_interesses = get_categories( array(
                'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
                'parent' => $tag->cat_ID,
                'hide_empty' => 0, // change to 1 to hide categores not having a single post
            ));
            if (count($cats_interesses)!=0)
        {
            $row_interesses.='<div hidden=true class="cb_topics_personal_'.($key1+1).'" '.($key1+1).'">';
            foreach($cats_interesses as $key => $value)
            {   
            $row_interesses .= '
            <input type="checkbox" name="choice_interesses_'.($value->cat_ID).'" value= '.$value->cat_ID .' id="cb_interesses_'.($value->cat_ID).'" /><label class="labelChoose"  for="cb_interesses_'.($value->cat_ID).'">'. $value->cat_name .'</label>';
            }
            $row_interesses.= '</div>';
        }
      
    }

    if (isset($_POST["subtopics_first_login"]))
    {
        unset($_POST["subtopics_first_login"]);
        $subtopics_already_selected = get_user_meta(get_current_user_id(),'topic');
        foreach ($_POST as $key => $subtopics) { 
            if (isset($_POST[$key]))
            {
                if (!(in_array($_POST[$key], $subtopics_already_selected)))
                {
                    add_user_meta(get_current_user_id(),'topic',$_POST[$key]);  
                }
                
            }
        }
        update_field('is_first_login', true, 'user_'.get_current_user_id());
        
    }
    
    $is_first_login=(get_field('is_first_login','user_' . get_current_user_id()));
    if (!$is_first_login && get_current_user_id() !=0 )
        {
        
    ?>    
        <!-- Modal First Connection --> 
        <div class="contentModalFirst">
            <div class="modal" id="myFirstModal" tabindex="-1" role="dialog" aria-labelledby="myFirstModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modalHeader">
                            <h5 class="modal-title text-center" id="exampleModalLabel">Welcome to livelearn</h5>
                            <p class="pickText">Pick your favorite topics to set up your feeds</p>
                        </div>
                        <div class="modal-body">
                        <form action="" method="post">
                            <div class="blockBaangerichte">
                                <h1 class="titleSubTopic">Baangerichte</h1>
                                <div class="hiddenCB">
                                    <div>
                                        <?php
                                        foreach($bangerichts as $key => $value)
                                        {
                                            //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_bangricht'.($key+1).'" /><label class="labelChoose btnBaangerichte subtopics_bangricht_'.($key+1).' '.($key+1).'" for="cb_topics_bangricht'.($key+1).'">'. $value->cat_name .'</label>';
                                        }
                                        ?>
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnBaangerichte" for="cb1">Choice A</label> -->

                                    </div>
                                </div>
                                <div class="subtopicBaangerichte">

                                    <div class="hiddenCB">
                                        <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                        <?php
                                        echo $row_bangrichts;
                                        ?>
                                    </div>

                                    <button type="button" class="btn btnNext" id="nextblockBaangerichte">Next</button>
                                </div>
                            </div>

                            <div class="blockfunctiegericht">
                                <h1 class="titleSubTopic">functiegericht</h1>
                                <div class="hiddenCB">
                                    <div>
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnFunctiegericht" for="cb1">Choice A</label> -->
                                        <?php
                                        foreach($functies as $key => $value)
                                        {
                                            //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_funct'.($key+1).'" /><label class="labelChoose btnFunctiegericht subtopics_funct_'.($key+1).' '.($key+1).'"  for="cb_topics_funct'.($key+1).'">'. $value->cat_name .'</label>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="subtopicFunctiegericht">
                                    <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                    <div class="hiddenCB">
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                        <?php
                                            echo $row_functies;
                                        ?>
                                    </div>
                                    <button type="button" class="btn btnNext" id="nextFunctiegericht">Next</button>
                                </div>
                            </div>

                            <div class="blockSkills">
                                <h1 class="titleSubTopic">Skills</h1>
                                <div class="hiddenCB">
                                    <div>
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnSkills" for="cb1">Choice A</label> -->

                                        <?php
                                        foreach($skills as $key => $value)
                                        {
                                            //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_skills'.($key+1).'" /><label class="labelChoose btnSkills subtopics_skills_'.($key+1).' '.($key+1).'" for=cb_skills'.($key+1).'>'. $value->cat_name .'</label>';
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="subtopicSkills">
                                    <div class="hiddenCB">
                                        <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                        <?php
                                            echo $row_skills;
                                        ?>
                                    </div>
                                    <button type="button" class="btn btnNext" id="nextSkills">Next</button>
                                </div>
                            </div>

                            <div class="blockPersonal">
                                <h1 class="titleSubTopic">Personal interest </h1>
                                <div class="hiddenCB">
                                    <div>
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose btnPersonal" for="cb1">Choice A</label> -->

                                        <?php
                                        foreach($interesses as $key => $value)
                                        {
                                            //echo "<option value='" . $value->cat_ID . "'>" . $value->cat_name . "</option>";
                                            echo '<input type="checkbox" value= '.$value->cat_ID .' id="cb_topics_personal'.($key+1).'" /><label class="labelChoose btnPersonal subtopics_personal_'.($key+1).' '.($key+1).'" for="cb_topics_personal'.($key+1).'">'. $value->cat_name .'</label>';
                                        }
                                        ?>

                                    </div>
                                </div>
                                <div class="subtopicPersonal">
                                    <div class="hiddenCB">
                                        <p class="pickText">Pick your favorite sub topics to set up your feeds</p>
                                        <!-- <input type="checkbox" name="choice" id="cb1" /><label class="labelChoose" for="cb1">Choice A</label> -->
                                        <?php
                                            echo $row_interesses;
                                        ?>
                                    </div>
                                    <button name="subtopics_first_login" class="btn btnNext" id="nextPersonal">Save</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }  
?>