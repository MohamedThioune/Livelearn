<?php
$like_src = get_stylesheet_directory_uri()."/img/coeur1.png";
$dislike_src = get_stylesheet_directory_uri()."/img/heart-dislike.png";

extract($_POST);

//The user
$user = get_current_user_id();

$courses = array();
$course_id = array();
$random_id = array(); 
$count = array('Opleidingen' => 0, 'Workshop' => 0, 'Masterclass' => 0, 'Event' => 0, 'E_learning' => 0, 'Training' => 0, 'Video' => 0, 'Artikel' => 0);

$categories = array();

//Categories
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

// Saved courses
$saved = get_user_meta($user, 'course');

// Get interests courses
$topics_external = get_user_meta($user, 'topic');
$topics_internal = get_user_meta($user, 'topic_affiliate');

$topics = array();
if(!empty($topics_external))
    $topics = $topics_external;

if(!empty($topics_internal))
    foreach($topics_internal as $value)
        array_push($topics, $value);

$experts = get_user_meta($user, 'expert');
$args = array(
    'post_type' => array('course', 'post'), 
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC'
);
$global_courses = get_posts($args);

foreach ($global_courses as $key => $course) {    
    //Control visibility
    if(!visibility($course, $visibility_company))
        continue;
    
    //Preferences categories
    $category_default = get_field('categories', $course->ID);
    $category_xml = get_field('category_xml', $course->ID);
    $read_category = array();
    if(!empty($category_default))
        foreach($category_default as $item)
            if($item)
                if(!in_array($item['value'],$read_category))
                    array_push($read_category,$item['value']);
                
    else if(!empty($category_xml))
        foreach($category_xml as $item)
            if($item)
                if(!in_array($item['value'],$read_category))
                    array_push($read_category,$item['value']);
                
    foreach($topics as $topic_value){
        if($read_category)
            if(in_array($topic_value, $read_category) ){
                if(!in_array($course->ID, $course_id)){
                    array_push($course_id, $course->ID);
                    array_push($courses, $course);        
                    break;
                }
        }
    }

    //Preference author
    if(in_array($course->post_author, $experts)){
        if(!in_array($course->ID, $course_id)){
            array_push($course_id, $course->ID);
            array_push($courses, $course);        
        }
    }

    //Preference expert
    $experties = get_field('experts', $course->ID);  
    foreach($experties as $topic_expert){
        if(in_array($topic_expert, $experts)){
            if(!in_array($course->ID, $course_id)){
                array_push($course_id, $course->ID);
                array_push($courses, $course);        
                break;
            }
        }
    }
}

//Views
$user_post_view = get_posts(
    array(
        'post_type' => 'view',
        'post_status' => 'publish',
        'author' => $user,
        'order' => 'DESC'
    )
)[0];   

$is_view = false;

if (!empty($user_post_view))
{
    $courses_id = array();
    $is_view=true;
   
    $all_user_views = (get_field('views', $user_post_view->ID));
    $max_points = 10;
    $recommended_courses = array();

    foreach($all_user_views as $key => $view) {
        foreach ($courses as $key => $course) {
            $points = 0;
            
            //Control visibility
            if(!visibility($course, $visibility_company))
                continue;

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
            
            //Price view
            $view_prijs = get_field('price', $view['course']->ID);

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
            if ($percent >= 50)
                if(!in_array($course->ID, $random_id)){
                    if(get_field('course_type', $course->ID))
                        $count[get_field('course_type', $course->ID)]++; 
                    array_push($random_id, $course->ID);
                    array_push($recommended_courses, $course);
                }
        }
    }
}

arsort($count);
$count_trend = array_slice($count, 5, 4, true);
$count = array_slice($count, 0, 4, true);

$count_trend_keys = array_keys($count_trend);

$keys = array_keys($count);
shuffle($keys);
$count = array_merge(array_flip($keys), $count);

$bool = false;

if (empty($recommended_courses)){
    $courses_id = array();
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
    foreach($count as $key => $value){
        $count['limit'] = 0;
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
                            if(get_field('course_type', $course->ID) == 'Artikel'){

                                $count['limit'] = $count['limit'] + 1;

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
                                
                                //Course Type
                                $course_type = get_field('course_type', $course->ID);

                                $find = true;
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
                                $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];

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
                                    $datas = explode('-', get_field('data_locaties_xml', $course->ID)[0]['value']);
                                    $data = $datas[0];
                                    $day = explode('/', explode(' ', $data)[0])[0];
                                    $month = explode('/', explode(' ', $data)[0])[1];
                                    $month = $calendar[$month];
                                    $location = $datas[2];
                                }

                                if(!empty($data)){
                                    $date_now = strtotime(date('Y-m-d'));
                                    $data = strtotime(str_replace('/', '.', $data));
                                    if($data < $date_now)
                                        continue;
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

                                //Course Type
                                $course_type = get_field('course_type', $course->ID);

                                //Other case : youtube
                                $youtube_videos = get_field('youtube_videos', $course->ID);

                                $find = true;

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
                                            <?php
                                            if($youtube_videos && $course_type == 'Video')
                                                echo '<iframe width="355" height="170" src="https://www.youtube.com/embed/' . $youtube_videos[0]['id'] .'?autoplay=1&mute=1&controls=0&showinfo=0&modestbranding=1" title="' . $youtube_videos[0]['title'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                            else
                                                echo '<img src="' . $thumbnail .'" alt="">';
                                            ?>
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

    <div class="block-treaning">
        <p class="trendingTitle">Trends</p>
        <div class="swiper-container swipeContaine4">
        <div class="swiper-wrapper">
            <?php
            $i = 0;
            $find = false;
            foreach($courses as $key => $course){
                if($i == 20)
                    break;
                
                //Control visibility
                if(!visibility($course, $visibility_company))
                    continue;

                //Check-in
                if(in_array($course->ID, $random_id))
                    continue;
                           
                //Trends : Course Type remaining
                $course_type = get_field('course_type', $course->ID);
                if(!in_array($course_type, $count_trend_keys))
                    continue;

                $i++;
        
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

                $find = true;
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
            }
            
            if(!$find)
                echo "<span class='opeleidingText'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Geen overeenkomst met uw voorkeuren <i class='fas fa-smile-wink'></i></span>";
            ?>

            </div>
        </div>
    </div>

<?php

    /*
    ** New user pick favorites topics* 
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

        if (!empty($cats_bangerichts))
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

        if (!empty($cats_functies))
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

        if (!empty($cats_skills))
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
        if (!empty($cats_interesses))
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
        btn_id = e.target.id;
        meta_key = btn_id.split("_")[2];
        id = btn_id.split("_")[1];
        user_id = btn_id.split("_")[0];
        
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
