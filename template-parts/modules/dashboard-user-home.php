<?php
$page = dirname(__FILE__) . '/../../templates/check_visibility.php';

require($page); 

$like_src = get_stylesheet_directory_uri()."/img/heart-like.png";
$dislike_src = get_stylesheet_directory_uri()."/img/heart-dislike.png";

$courses = array();

extract($_POST);

$random_id = array(); 

$user = get_current_user_id();

$user_post_view = get_posts(
    array(
        'post_type' => 'view',
        'post_status' => 'publish',
        'author' => $user,
    )
)[0];   

$is_view = false;

if (count($user_post_view)!= 0)
{
    $is_view=true;
    $args = array(
        'post_type' => 'course',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        );

    $all_courses = get_posts($args);
    $all_user_views = (get_field('views', $user_post_view->ID));
    $max_points = 10;
    $recommended_courses = array();

    foreach($all_user_views as $key => $view) {
        foreach ($all_courses as $key => $course) {
            $points = 0;

            //Price
            $view_prijs = get_field('price', $view['course']->ID);

            /*
            * Read category
            */

            //Read category viewed
            $read_category_view = array();
            $category_default = get_field('categories', $view['course']->ID);
            $category_xml = get_field('category_xml', $view['course']->ID);        
            if(!empty($category_default))
                foreach($category_default as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_view))
                            array_push($read_category_view, $item['value']);
                        
            else if(!empty($category_xml))
                foreach($category_xml as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_view))
                            array_push($read_category_view, $item['value']);
                        
            
            //Read category course
            $read_category_course = array();
            $category_default = get_field('categories', $view['course']->ID);
            $category_xml = get_field('category_xml', $view['course']->ID);        
            if(!empty($category_default))
                foreach($category_default as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_course))
                            array_push($read_category_course, $item['value']);
                        
            else if(!empty($category_xml))
                foreach($category_xml as $item)
                    if($item)
                        if(!in_array($item['value'],$read_category_course))
                            array_push($read_category_course, $item['value']);
    
            /*
            * End
            */

            foreach($read_category_view as $value){
                if($points == 6)
                    break;
                if(in_array($value, $read_category_course))
                    $points += 3;
            }
            if ($view['course']->post_author == $course->post_author) 
                $points += 3;
            if ($view_prijs <= $course->price)
                $points += 1;
            
            $percent = abs(($points/$max_points) * 100);
            if ($percent >= 60)
                if(!in_array($course->ID, $random_id)){
                    array_push($random_id, $course->ID);
                    array_push($recommended_courses, $course);
                }
        }
    }
}

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

// Saved courses
$saved = get_user_meta($user, 'course');

/*
* * Get interests courses
*/

$topics = get_user_meta($user, 'topic');

$experts = get_user_meta($user, 'expert');

$args = array(
    'post_type' => array('course', 'post'), 
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
$count = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'Event' => 0, 'E_learning' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0);
$loop_break = array();

foreach ($recommended_courses as $key => $course) {
    if(get_field('course_type', $course->ID))
      $count[get_field('course_type', $course->ID)]++; 
}

arsort($count);
$count = array_slice($count, 0, 4, true);
$keys = array_keys($count);
shuffle($keys);
$count = array_merge(array_flip($keys), $count);

foreach($global_courses as $course)
{
    if(!visibility($course, $visibility_company))
        continue;                

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
   
}

$bool = false;

if (count($recommended_courses) == 0){
    $courses = array_merge($courses, $expert_courses);
    $recommended_courses = $courses;
    $bool = true;
} 


//Activitien
shuffle($recommended_courses);
/*
* *   
*/

if(isset($_GET['message']))
    if($_GET['message'])
        echo "<span class='alert alert-success'>" . $_GET['message'] . "</span><br><br>";
        
?>


<?php
    $limit = 0;
    foreach($count as $key => $value){
        $count['limit'] = 0;
        $limit += 1;
        if($limit > 4)
            break;
    ?>

    <?php
        if($value != 0 || $bool){ 
            if($key == 'Artikel'){
            //Block Artikel 👇🏿
    ?>
            <div class="block-treaning">
                <p class="trendingTitle"> <?= $key ?></p>
                <div class="swiper-container swipeContaine4">
                    <div class="swiper-wrapper">
                    <?php
                    $find = false;
                    foreach($recommended_courses as $course){

                        if(!get_field('visibility', $course->ID)) {
                            if(get_field('course_type', $course->ID) == $key){

                                $count['limit'] = $count['limit'] + 1;

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

                                $course_type = get_field('course_type', $course->ID);
                    ?>
                        <div class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                            <div class="blockLoveCourse" >
                                <button>
                                    <?php                                
                                        if (in_array($course->ID, $saved))
                                        {
                                    ?>
                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">                        
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                    <?php
                                        }
                                    ?>
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
                                                    <p class="lieuAm"><?= $course_type; ?></p>
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
                            if($count['limit'] == 20)
                                break;
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
            }
            else{
            //Block Other 👇🏿
    ?>
            <div class="block-treaning">
                <p class="trendingTitle"> <?= $key ?></p>
                <div class="swiper-container swipeContaine4">
                    <div class="swiper-wrapper">
                    <?php
                    $find = false;
                    foreach($recommended_courses as $course){

                        if(!get_field('visibility', $course->ID)) {
                            if(get_field('course_type', $course->ID) == $key){

                                $count['limit'] = $count['limit'] + 1;

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

                                $course_type = get_field('course_type', $course->ID);
                    ?>
                        <div class="swiper-slide swiper-slide4" data-swiper-slide-index="0">
                            <div class="blockLoveCourse" >
                                <button>
                                    <?php                                
                                        if (in_array($course->ID, $saved))
                                        {
                                    ?>
                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $like_src;?>" alt="">                        
                                    <?php
                                        }
                                        else{
                                    ?>
                                        <img class="btn_favourite" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
                                    <?php
                                        }
                                    ?>
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
                                                    <p class="lieuAm"><?= $course_type; ?></p>
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
                            if($count['limit'] == 20)
                                break;
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
            }
        }
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
        header('Location:/dashboard/user');
        
    }
    
    $is_first_login=(get_field('is_first_login','user_' . get_current_user_id()));
    if (!$is_first_login && get_current_user_id() !=0 )
        {
            // delete_user_meta(get_current_user_id(),'topic');
        
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
                         <form method="post" name="first_login_form">
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

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>

<script>
    $(".btn_favourite").click((e)=>
    {

        btn_id=e.target.id;
        meta_key = btn_id.split("_")[2];
        id = btn_id.split("_")[1];
        user_id= btn_id.split("_")[0];
        
        console.log(e.target)
         $.ajax({
             url:"/like",
             method:"post",
             data:{
                 meta_key : meta_key,
                 id : id,
                 user_id : user_id,
             },
             dataType:"text",
             success: function(data){
                 console.log(data);
                  let src=$("#"+btn_id).attr("src");
                    if(src=="<?php echo $like_src; ?>")
                    {
                        $("#"+btn_id).attr("src","<?php echo $dislike_src; ?>");
                    }
                    else
                    {
                        $("#"+btn_id).attr("src","<?php echo $like_src; ?>");
                    }              
             }
         });

        
    })
</script>
