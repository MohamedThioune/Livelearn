<?php
$like_src = get_stylesheet_directory_uri()."/img/heart-like.png";
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
    $bool = true;
    $bool = visibility($course, $visibility_company);
    if(!$bool)
        continue;

    /*
    *  Date and Location
    */
    $data = array();
    $day = '-';
    $month = '';
    $location = 'Virtual';

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

    if(empty($data))
        null;
    else if(!empty($data) && $course_type != "Video" && $course_type != "Artikel")
        if($data){
            $date_now = strtotime(date('Y-m-d'));
            $data = strtotime(str_replace('/', '.', $data));
            if($data < $date_now)
                continue;
        }

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
    if($experts)
        if(in_array($course->post_author, $experts)){
            if(!in_array($course->ID, $course_id)){
                array_push($course_id, $course->ID);
                array_push($courses, $course);
            }
        }

    //Preference expert
    $experties = get_field('experts', $course->ID);
    if($experties && $experts)
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
    $is_view = true;

    $all_user_views = (get_field('views', $user_post_view->ID));
    $max_points = 10;
    $recommended_courses = array();

    foreach($all_user_views as $key => $view) {
        if(!$view['course'])
            continue;

        foreach ($courses as $key => $course) {
            $points = 0;

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
                        //Course Type
                        $course_type = get_field('course_type', $course->ID);

                        if(get_field('course_type', $course->ID) == 'Artikel'){
                            $bool = true;
                            $bool = visibility($course, $visibility_company);
                            if(!$bool)
                                continue;

                            $count['limit'] = $count['limit'] + 1;

                            $month = '';
                            $location = 'Virtual';
                            $day = '';

                            /*
                            * Categories
                            */
                            $location = 'Virtual';
                            $day = "<p><i class='fas fa-calendar-week'></i></p>";
                            $month = '';

                            $category = ' ';
                            $category_id = 0;
                            $category_string = " ";
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
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
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
                                    <img class="btn_favourite a" id="<?php echo $user."_".$course->ID."_course" ?>"  src="<?php echo $dislike_src; ?>" alt="">
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
                    $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
                    foreach($recommended_courses as $course){
                        $course_type = get_field('course_type', $course->ID);

                        if(get_field('course_type', $course->ID) == $key){
                            $bool = true;
                            $bool = visibility($course, $visibility_company);
                            if(!$bool)
                                continue;

                            $count['limit'] = $count['limit'] + 1;
                            $data = array();
                            $day = '-';
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
                                $thumbnail = get_the_post_thumbnail_url($course->ID);
                                if(!$thumbnail)
                                    $thumbnail = get_field('url_image_xml', $course->ID);
                                        if(!$thumbnail)
                                            $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                            }

                            /*
                            * Companies
                            */
                            $company = get_field('company',  'user_' . $course->post_author);

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
            $calendar = ['01' => 'Jan',  '02' => 'Febr',  '03' => 'Maar', '04' => 'Apr', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Aug', '09' => 'Sept', '10' => 'Okto',  '11' => 'Nov', '12' => 'Dec'];
            foreach($courses as $key => $course){
                if($i == 20)
                    break;

                //Control visibility
                $bool = true;
                $bool = visibility($course, $visibility_company);
                if(!$bool)
                    continue;

                //Trends : Course Type remaining
                // $course_type = get_field('course_type', $course->ID);
                // if(in_array($course_type, $count_trend_keys))
                //     continue;

                $i++;

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
                $day = "-";
                $month = NULL;
                $location = 'Virtual';

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
                $p = " ";
                $p = get_field('price', $course->ID);
                if($p != "0")
                    $price =  number_format($p, 2, '.', ',');
                else
                    $price = 'Gratis';

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


