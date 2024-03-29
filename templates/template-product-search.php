<?php /** Template Name: Product Search */ ?>

<body>
<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />
<?php
//$page = 'check_visibility.php';
//require($page);

//Modules 
require_once('postal.php'); 
require_once('search-module.php'); 

//Let's kick it off
extract($_GET);

// extract($_POST);   

$courses = array();
$order_type = array();

// $teachers = array();
// $categories = array();
// $profes = array();
// $topic = "";

if (!isset($leervom))
    $leervom = array();
if (!isset($experties))
    $experties = array();

$args = array(
    'post_type' => array('post','course', 'learnpath', 'assessment'),
    'post_status' => 'publish',
    'orderby' => 'date',
    'order'   => 'DESC',
    'posts_per_page' => -1,
);
$global_posts = get_posts($args);

$no_filter = true;

//Natural Search  
if(isset($search) && isset($search_type)):
    $courses = searching_course($search, $search_type, $global_posts)['courses'];
    $order_type = searching_course($search, $search_type, $global_posts)['order_type'];
    $expertise = searching_course($search, $search_type, $global_posts)['experts'];
    $no_filter = false;
//Head Search
elseif($filter):
    $courses = searching_course_by_type($global_posts, $filter)['courses'];
    $order_type = searching_course_by_type($global_posts, $filter)['order_type'];
    $expertise = searching_course_by_type($global_posts, $filter)['experts'];    
    $no_filter = false;
    $leervom[] = $filter;

endif;

/* * Group by type * */
$main_courses = array();
$start_courses = (!empty($courses)) ? $courses : $global_posts;

if(isset($category_input) || isset($user_input) || isset($companie_input))
    $no_filter = false;

// Category post 
if(isset($category_input)):
    $courses = searching_course_by_group($start_courses, 'category', $category_input)['courses'];
    $order_type = searching_course_by_group($start_courses, 'category', $category_input)['order_type'];
    $expertise = searching_course_by_group($start_courses, 'category', $category_input)['experts'];
// Expert post 
elseif(isset($user_input)):
    $courses = searching_course_by_group($start_courses, 'expert', $user_input)['courses'];
    $order_type = searching_course_by_group($start_courses, 'expert', $user_input)['order_type'];
    $expertise = searching_course_by_group($start_courses, 'category', $category_input)['experts'];
// Company post 
elseif(isset($companie_input)):
    $courses = searching_course_by_group($start_courses, 'company', $companie_input)['courses'];
    $order_type = searching_course_by_group($start_courses, 'company', $companie_input)['order_type'];
    $expertise = searching_course_by_group($start_courses, 'category', $category_input)['experts'];
endif;
/* * End group by * */

/* * Search by filter * */
if(isset($filter_args)):
    $no_filter = false;

    // Define args for search
    $args = array();
    $args['leervom'] = (!empty($leervom)) ? $leervom : null;
    $args['min'] = ($min) ? $min : null;
    $args['max'] = ($max) ? $max : null;
    $args['gratis'] = (isset($gratis)) ? 1 : null;
    $args['locate'] = ($locate) ? $locate : null;
    $args['online'] = (isset($online)) ? 1 : null;
    $args['experties'] = (!empty($experties)) ? $experties : null;
  
    $courses = (empty($courses)) ? $global_posts : $courses;
    //Apply filter 
    $courses = searching_course_with_filter($courses, $args)['courses']; 
    $order_type = searching_course_with_filter($courses, $args)['order_type'];
    $expertise = searching_course_with_filter($courses, $args)['experts'];


    /* * End search by * */
endif;

//Check empty 
$courses = ($no_filter) ? $global_posts : $courses;

$courses = array_slice($courses, 0, 500);

?>

<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/product-search.png" class="img-head-about border-0" alt="">
                <h1 class="wordDeBestText2">Product Search</h1>
            </div>
        </div>
    </section>
    <section class="content-product-search">
        <div class="theme-content">
            <div class="theme-side-menu">
                <div class="block-filter">
                    <button class="btn btn-close-filter">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/Close.png" class="img-head-about" alt="">
                    </button>
                    <p class="text-filter-course">Filter | Courses </p>
                    <form action="/product-search" method="GET">
                        <?php
                        echo "<input type='hidden' name='filter_args' value='1'>";

                        if(isset($_GET['category_input']))
                            echo "<input type='hidden' name='category_input' value='". $category_input ."'>";
                        elseif(isset($_GET['user_input']))
                            echo "<input type='hidden' name='user_input' value='". $user_input ."'>";
                        elseif(isset($_GET['companie_input']))
                            echo "<input type='hidden' name='companie_input' value='". $companie_input ."'>";
                        ?>
                        <div class="sub-section">
                            <p class="description-sub-section">LEERVORM</p>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="opleiding" name="leervom[]" value="Opleidingen" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Opleidingen', $leervom) || $search_type == "Opleidingen" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Opleidingen
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Opleidingen']) ? $order_type['Opleidingen'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Artikel"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Artikel', $leervom) || $search_type == "Artikel" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Artikel
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Artikel']) ? $order_type['Artikel'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Masterclass" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Masterclass', $leervom) || $search_type == "Masterclass" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Masterclass
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Masterclass']) ? $order_type['Masterclass'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Podcast" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Podcast', $leervom) || $search_type == "Podcast" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Podcast
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Podcast']) ? $order_type['Podcast'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Video" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Video', $leervom) || $search_type == "Video" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Video
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Video']) ? $order_type['Video'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Workshop" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Workshop', $leervom) || $search_type == "Workshop" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Workshop
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Workshop']) ? $order_type['Workshop'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="E-Learning" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('E-Learning', $leervom) || $search_type == "E-Learning" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        E-Learning
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['E-Learning']) ? $order_type['E-Learning'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Event"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Event', $leervom) || $search_type == "Event" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Event
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Event']) ? $order_type['Event'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Training"  <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Training', $leervom) || $search_type == "Training" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Training
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Training']) ? $order_type['Training'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Lezing" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Lezing', $leervom) || $search_type == "Lezing" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Lezing
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Lezing']) ? $order_type['Lezing'] : 0 ?></p>
                            </div>

                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="" name="leervom[]" value="Assessment" <?php if( !empty($leervom) ||  isset($search_type) ) if(in_array('Assessment', $leervom) || $search_type == "Assessment" ) echo "checked" ; else echo ""  ?>>
                                    <label class="form-check-label" for="Backend">
                                        Assessment
                                    </label>
                                </div>
                                <p class="number-course"><?= isset($order_type['Assessment']) ? $order_type['Assessment'] : 0 ?></p>
                            </div>
                        </div>

                        <div class="sub-section">
                            <p class="description-sub-section">PRIJS</p>
                            <div class="form-group">
                                <label for="Vanaf" class="form-label">Vanaf</label>
                                <input type="number" class="form-control" id="Vanaf" name="min" value="<?php if(isset($min)) echo $min ?>"  placeholder="€min">
                            </div>
                            <div class="form-group">
                                <label for="Tot" class="form-label">Tot</label>
                                <input type="number" class="form-control" id="Tot" name="max" value="<?php if(isset($max)) echo $max ?>"  placeholder="€max">
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" id="Allen" name="gratis" <?php if(isset($gratis)) echo 'checked'; else  echo  '' ?>>
                                    <label class="form-check-label" for="Allen">
                                        Alleen gratis
                                    </label>
                                </div>
                            </div>
                        </div>
                       
                        <div class="sub-section">
                            <p class="description-sub-section">LOCATIE</p>
                            <div class="form-group">
                                <label for="PostCode" class="form-label">PostCode</label>
                                <input type="number" class="form-control" id="PostCode" name="locate" placeholder="&nbsp;Postcode">
                            </div>
                            <div class="form-group">
                                <label for="Afstand" class="form-label">Afstand(m)</label>
                                <input type="number" class="form-control" id="Afstand" name="range" placeholder="&nbsp;Afstand(m)">
                            </div>
                            <div class="form-check d-flex justify-content-between">
                                <div class="group-input-check">
                                    <input class="form-check-input" type="checkbox" name="online" id="Alleen-online"  name="gratis" <?php if(isset($online)) echo 'checked'; else  echo  '' ?>>
                                    <label class="form-check-label" for="Alleen-online">
                                        Alleen online
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sub-section">
                            <p class="description-sub-section">EXPERT</p>
                            <!-- <div class="position-relative">
                                <i class="fa fa-search"></i>
                                <input type="search" placeholder="Search Expert">
                            </div> -->
                            <br>
                            <div class="form-check">
                            <?php
                            $i = 0;
                            foreach($expertise as $expert):
                                if(!$expert)
                                    continue;

                                $teacher_data = get_user_by('id', $expert);

                                $user_id = get_current_user_id();
                                if($teacher_data->ID != $user_id)
                                    $name = ($teacher_data->last_name) ? $teacher_data->first_name : $teacher_data->display_name;
                                else
                                    $name = "Ikzelf";
    
                                if($teacher_data->first_name == "")
                                    continue;
                                ?>
                                <div class="group-input-check">
                                    <input class="form-check-input" name="experties[]" type="checkbox" value="<?= $expert ?>" id="">
                                    <label class="form-check-label" for="">
                                        <?= $name ?>
                                    </label>
                                </div>
                            <?php
                                $i+=1;
                                if($i == 10)
                                    break;
                            endforeach;  

                            if(!empty($expertise))
                                if(count($expertise) > 10)
                                    echo '<button class="btn btn-more-expert">+ More expert</button>';
                            ?>
                            </div>
                        </div>
                        <button class="btn btn-Apply">Apply</button>
                    </form>

                </div>
            </div>
            <div class="theme-learning">
                <div class="">
                    <div class="btn-group-layouts">
                        <button class="btn gridview active" ><i class="fa fa-th-large"></i>Grid View</button>
                        <button class="btn listview"><i class='fa fa-th-list'></i>List View</button>
                    </div>
                    <div class="block-filter-mobile">
                        <button class="content-filter d-flex ">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/filter.png" alt="">
                            <span>Filter</span>
                        </button>
                    </div>


                    <div class="block-new-card-course grid" id="autocomplete_recommendation">
                        <?php
                        
                        $user_id = get_current_user_id();
                        $company_visibility = get_field('company',  'user_' . $user_id);
                        $visibility_company = (!empty($company_visibility)) ? $company_visibility[0]->post_title : null;
                        // var_dump($visibility_company);
                        // die();
                        $calendar = ['01' => 'Jan',  '02' => 'Feb',  '03' => 'Mar', '04' => 'Avr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sept', '10' => 'Oct',  '11' => 'Nov', '12' => 'Dec'];
                        if (isset($_GET['search'])):
                            $args = array(
                                'post_type' => array('post','course', 'learnpath', 'assessment','courses'),
                                'post_status' => 'publish',
                                'orderby' => 'date',
                                'order'   => 'DESC',
                                'posts_per_page' => -1,
                                's'=>$_GET['search']
                            );
                        $courses = get_posts($args);
                        if (count($courses)==0)
                             echo '<h5> no result for : '.$_GET['search'].'<h5/>';
                        endif;

                        foreach($courses as $post):
                        $hidden = 0;
                        $hidden = visibility($post, $visibility_company);
                        if(!$hidden)
                            continue;
                        //var_dump($post->ID);

                        /* Displaying information */

                        //Tags information
                        $category = " ";
                        $category_id = 0;
                        $id_category = 0;
                        if($tag == ' '){
                            $category_id = intval(explode(',', get_field('categories',  $post->ID)[0]['value'])[0]);
                            $category_xml = intval(get_field('category_xml', $post->ID)[0]['value']);
                            if($category_xml)
                                if($category_xml != 0){
                                    $id_category = $category_xml;
                                    $category = (String)get_the_category_by_ID($category_xml);
                                }
                            if($category_id)
                                if($category_id != 0){
                                    $id_category = $category_id;
                                    $category = (String)get_the_category_by_ID($category_id);
                                }
                        }

                        $course_type = get_field('course_type', $post->ID);
                        //Image information
                        $thumbnail = get_field('preview', $post->ID)['url'];
                        if(!$thumbnail){
                            $thumbnail = get_the_post_thumbnail_url($post->ID);
                            if(!$thumbnail)
                                $thumbnail = get_field('url_image_xml', $post->ID);
                                    if(!$thumbnail)
                                        $thumbnail = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                        }

                        //Author information
                        $author = get_user_by('ID', $post->post_author);
                        $name_author = ($author) ? $author->display_name : 'None';
                        $user_id = get_current_user_id();
                        if($author->ID != $user_id)
                            $name = ($author->last_name) ? $author->first_name : $author->display_name;
                        else
                            $name = "Ikzelf";
                       
                        $image_author = get_field('profile_img',  'user_' . $post->post_author);
                        if(!$image_author)
                            $image_author = get_stylesheet_directory_uri() ."/img/placeholder_user.png";

                        //Date and Location
                        $offline = ['Event', 'Lezing', 'Masterclass', 'Training' , 'Workshop', 'Opleidingen', 'Cursus'];
                        $data = null;
                        $count_data = 0;
                        $data_locaties = get_field('data_locaties', $post->ID);
                        $data_locaties_xml = get_field('data_locaties_xml', $post->ID);
                        $location = 'Online';
                        if(!empty($data_locaties)):
                            $count_data = count($data_locaties) - 1;
                            $data = $data_locaties[$count_data]['data'][0]['start_date'];
                            $location = $data_locaties[0]['data'][0]['location'];
                        elseif(!empty($data_locaties_xml)):
                            $count_data = count($data_locaties_xml) - 1;
                            if($data_locaties_xml):
                                if(isset($data_locaties_xml[intval($count_data)]['value']))
                                    $element = $data_locaties_xml[intval($count_data)]['value'];
                                if(isset($data_locaties_xml[0]['value'])){
                                    $data_first = explode('-', $datum[0]['value']);
                                    $location = $data_first[2];
                                }
                            endif;

                            if(!isset($element))
                                continue;

                            $datas = explode('-', $element);
                            $data = $datas[0];
                        endif;

                        if( empty($data) || !in_array($course_type, $offline) )
                            null;
                        elseif( !empty($data) )
                            if($data){
                                $date_now = strtotime(date('Y-m-d'));
                                $data = strtotime(str_replace('/', '.', $data));
                                if($data < $date_now)
                                    continue;
                            }
                        
                        //Price information
                        $price_noformat = get_field('price', $post->ID) ?: 'Gratis';
                        if($price_noformat != "Gratis")
                            $price = '€' . number_format($price_noformat, 2, '.', ',');
                        else
                            $price = 'Gratis';
                        
                        //Link 
                        $link = get_permalink($post->ID);

                        /* End Displaying */

                        ?>

                        <a href="<?= $link ?>" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?= $thumbnail ?>" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course"><?= $post->post_title ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm"><?= $course_type ?></p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm"><?= $location ?></p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?= $image_author ?>" alt="">
                                            </div>
                                            <p class="autor"><?= $name_author ?></p>
                                        </div>
                                        <p class="price"><?= $price ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <?php
                        endforeach;
                        ?>
                 
                        <!-- 
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="" class="new-card-course visible">
                            <div class="content-course-block">
                                <div class="head">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/course-img.png" alt="">
                                </div>
                                <div class="details-card-course">
                                    <div class="title-favorite d-flex justify-content-between align-items-center">
                                        <p class="title-course">A course by daniel for Seydou and mohamed</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100 categoryDateBlock">
                                        <div class="blockOpein d-flex align-items-center">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p class="lieuAm">UI design</p>
                                        </div>
                                        <div class="blockOpein">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <p class="lieuAm">Dakar Senegal</p>
                                        </div>
                                    </div>
                                    <div class="autor-price-block d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="blockImgUser">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dan.jpg" alt="">
                                            </div>
                                            <p class="autor">Samanthan wiliams</p>
                                        </div>
                                        <p class="price">$ 400</p>
                                    </div>
                                </div>
                            </div>
                        </a> -->
                    </div>

                    <div class="pagination-container">
                        <!-- Les boutons de pagination seront ajoutés ici -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script>
    const itemsPerPage = 12;
    const blockList = document.querySelector('.block-new-card-course');
    const blocks = blockList.querySelectorAll('.new-card-course');
    const paginationContainer = document.querySelector('.pagination-container');
    let currentPage = 1;

    function displayPage(pageNumber) {
        const start = (pageNumber - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        blocks.forEach((block, index) => {
            if (index >= start && index < end) {
                block.style.display = 'block';
                block.classList.add('visible');
            } else {
                block.style.display = 'none';
                block.classList.remove('visible');
            }
        });

        const containerHeight = blockList.offsetHeight;

        setTimeout(() => {
            blockList.style.height = containerHeight + 'px';
        }, 10);
        setTimeout(() => {
            blockList.style.height = '';
        }, 300);
    }

    function createPaginationButtons() {
        const pageCount = Math.ceil(blocks.length / itemsPerPage);

        if (pageCount <= 1) {
            return;
        }

        const prevButton = document.createElement('button');
        prevButton.textContent = '‹'; // Flèche gauche
        prevButton.classList.add('pagination-button');
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                scrollToTop();
                currentPage--;
                displayPage(currentPage);
                updatePaginationButtons();
            }
        });
        paginationContainer.appendChild(prevButton);

        for (let i = 1; i <= pageCount; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.classList.add('pagination-button');
            button.addEventListener('click', () => {
                scrollToTop();
                currentPage = i;
                displayPage(currentPage);
                updatePaginationButtons();
            });
            paginationContainer.appendChild(button);
        }

        const nextButton = document.createElement('button');
        nextButton.textContent = '›'; // Flèche droite
        nextButton.classList.add('pagination-button');
        nextButton.addEventListener('click', () => {
            if (currentPage < pageCount) {
                scrollToTop();
                currentPage++;
                displayPage(currentPage);
                updatePaginationButtons();
            }
        });
        paginationContainer.appendChild(nextButton);

        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        const buttons = document.querySelectorAll('.pagination-button');
        buttons.forEach((btn) => {
            btn.classList.remove('active');
            if (parseInt(btn.textContent) === currentPage) {
                btn.classList.add('active');
            }
        });
    }

    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    displayPage(currentPage);
    createPaginationButtons();
</script>


<script>
    $(".content-filter").click(function() {
        $(".theme-side-menu").show();
    });
    $(".btn-close-filter").click(function() {
        $(".theme-side-menu").hide();
    });
</script>

</body>