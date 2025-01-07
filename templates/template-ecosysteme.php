<?php /** Template Name: Ecosystem template */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php 
$like_src = get_stylesheet_directory_uri()."/img/heart-like.png";
$dislike_src = get_stylesheet_directory_uri()."/img/heart-dislike.png";

$topic = (isset($_GET['topic'])) ? $_GET['topic'] : 0;
$name_topic =  ($topic != 0) ? (String)get_the_category_by_ID($topic) : '';

/*
** Further informations category
*/
$title_category = get_field('title_category', 'category_'. $topic) ? get_field('title_category', 'category_'. $topic) : 'Leeg' ;
$descriptor_category = get_field('descriptor_category', 'category_'. $topic) ? get_field('descriptor_category', 'category_'. $topic) : 'Geen inhoud' ;
$partners_category = get_field('partners_category', 'category_'. $topic);

$banner_category = get_field('image', 'category_'. $topic) ? get_field('image', 'category_'. $topic) : get_stylesheet_directory_uri() .'/img/ecosystemHeadImg.png' ;

/*
** Leerpaden  owned *
*/

$args = array(
    'post_type' => 'learnpath',
    'post_status' => 'publish',
    'posts_per_page' => -1
);

$leerpaden = get_posts($args);

$road_paths = array();
$topic_road_path = 0;
$title_road_path = "";

foreach($leerpaden as $leerpad){
    $road_path = get_field('road_path', $leerpad->ID);
    $topic_road_path = get_field('topic_road_path', $leerpad->ID);
    if( $topic == $topic_road_path){
        $road_path['title'] = $leerpad->post_title; 
        $road_path['expert'] = $leerpad->post_author;
        $road_path['ID'] = $leerpad->ID;
        array_push($road_paths, $road_path);
    }
    
}

if($topic != 0){    
    $categories_topic = get_categories( array(
        'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
        'orderby'    => 'name',
        'parent'     => $topic,
        'hide_empty' => 0, // change to 1 to hide categores not having a single post
    ) );
}

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'order' => 'DESC',
);

$global_blogs = get_posts($args);

$blogs = array();
$blogs_id = array();
$others = array();
$teachers = array();
$teachers_all = array();

$categoriees = array(); 

if(isset($categories_topic))
    foreach($categories_topic as $category)
        array_push($categoriees, $category->cat_ID);

foreach($global_blogs as $blog)
{
    /*
    * Categories
    */ 

    $category_id = 0;
    $experts = get_field('experts', $blog->ID);

    $category_default = get_field('categories',  $blog->ID);
    $categories_xml = get_field('category_xml',  $blog->ID);
    $categories = array();

    /*
    * Merge categories from customize and xml
    */
    if(!empty($category_default))
    foreach($category_default as $item)
        if($item)
            if($item['value'])
                if(!in_array($item['value'], $categories))
                    array_push($categories,$item['value']);
            
    else if(!empty($category_xml))
        foreach($category_xml as $item)
            if($item)
                if($item['value'])
                    if(!in_array($item['value'], $categories))
                        array_push($categories,$item['value']);

    $born = false;
    foreach($categoriees as $categoriee){
        if($categories)
            if(in_array($categoriee, $categories)){
                array_push($blogs, $blog);
                array_push($blogs_id, $blog->ID);

                $born = true;
                /*
                 ** Push experts 
                */ 
                if(!in_array($blog->post_author, $teachers))
                    array_push($teachers, $blog->post_author);

                foreach($experts as $expertie)
                    if(!in_array($expertie, $teachers))
                        array_push($teachers, $expertie);
                /*
                 **
                */ 
                break;                
            }
    }
    if(!$born){
        array_push($others, $blog);
        if(!in_array($blog->post_author, $teachers_all))
            array_push($teachers_all, $blog->post_author);
        
    }
    /*
     **
    */ 
}

//The user
$user_id = get_current_user_id();

//Saved courses
$saved = get_user_meta($user_id, 'course');

?>

<div>

     <!-- ------------------------------------------Start Modal Sign In ----------------------------------------------- -->
     <div class="modal modalEcosyteme fade" id="SignInWithEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        style="position: absolute;height: 150% !important; overflow-y:hidden !important;">
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
        style="position: absolute;overflow-y:hidden !important;height: 110%; ">
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


</div>

<div class="content-ecosysteme ">
    <div class="head-content-ecosysteme">
    
        <div class="row">
            <div class="col-lg-6">
                <div class="container">
                    <div class="content-head-ecosystem">
                        <h1><?= $title_category; ?>| Join de community</h1>
                        <p class="description-head"><?= $descriptor_category; ?></p>
                        
                        <div class="groupBtnEcosysteme">
                            <div class="p-2 my-3">
                                <a href="" class="btnContactEco rounded-pill rounded" style="background-color: #00A89D"
                                 data-toggle="modal" data-target="#SignInWithEmail"  aria-label="Close" data-dismiss="modal">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/logo_livelearn_white.png" alt="" class="text-danger">
                                    Join community
                                </a>
                            </div>
                            <!-- <div class="p-2 my-3">
                                <a href="" class="btnContact rounded-pill rounded border-dark border-3 border ">
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/phone.png" alt="">
                                    HR Discord
                                </a>
                            </div> -->
                        </div>
                        
                        <p class="title-een">Een initiatief van:</p>

                        <div class="block-consultant">
                            <div class="block-initiative">
                               <div class="imgLivelearnLogo">
                                   <img src="<?php echo $partners_category[0]['image'] ? $partners_category[0]['image'] : get_stylesheet_directory_uri() . '/img/logo_right.png'; ?>" alt="" >
                               </div>
                            </div>
                            <div class="block-initiative block-initiative2">
                               <div class="imgLivelearnLogo">
                                   <img src="<?php echo $partners_category[1]['image'] ? $partners_category[1]['image'] : get_stylesheet_directory_uri() . '/img/Image49.png'; ?>" alt="" >
                               </div>                            
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="img-head-ecosysteme">
                    <img src="<?php echo $banner_category; ?>" alt="">
                </div>
            </div>

        </div>
    </div>
    <div class="topCollection">
        <div class="container">
            <div class="headCollections">
                <div class="dropdown show">
                    <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownHuman" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Tot experts binnen <b><?= $name_topic; ?></b>
                    </a>
                    <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownHuman">
                        <?php 
                        foreach($categories_topic as $category){
                            echo '<a class="dropdown-item" href="category-overview?category=' . $category->cat_ID . '">' . $category->cat_name .'</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="dropdown show">
                    <a class="btn btn-collection dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Over de <b>laatste 7 dagen</b>
                    </a>
                    <div class="dropdown-menu dropdownModifeEcosysteme" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#">Last 7 days</a>
                        <a class="dropdown-item" href="#">Last 1 month</a>
                        <a class="dropdown-item" href="#">Last 1 year</a>
                        <a class="dropdown-item" href="#">All time</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php 
                $num = 1;
                if($topic == 0)
                    $teachers = $teachers_all;
                if(!empty($teachers)){
                    foreach($teachers as $teacher) {
                        $user = get_users(array('include'=> $teacher))[0]->data;
                        $image_user = get_field('profile_img',  'user_' . $user->ID);
                        $image_user = $image_user ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                    ?>
                        <a href="/dashboard/user-overview/?id=<?php echo $user->ID; ?>" class="col-md-4">
                            <div class="boxCollections">
                                <p class="numberList"><?php echo $num++ ; ?></p>
                                <div class="circleImgCollection">
                                    <img src="<?php echo $image_user ?>" alt="">
                                </div>
                                <div class="secondBlockElementCollection ">
                                    <p class="nameListeCollection"><?php if(isset($user->first_name) && isset($user->last_name)) echo $user->first_name . '' . $user->last_name; else echo $user->display_name; ?></p>
                                    <div class="iconeTextListCollection">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/ethereum.png" alt="">
                                        <p><?php echo number_format(rand(0,100000), 2, '.', ','); ?></p>
                                    </div>
                                </div>
                                <p class="pourcentageCollection"><?php echo number_format(rand(0,100), 2, '.', ','); ?>%</p>
                            </div>
                        </a>
                    <?php }
                }else
                    echo '<p class="verkop"> Geen deskundigen beschikbaar </p>';
                ?>
            </div>
        </div>
    </div>
    <div class="hulpBox">
        <div class="container-fluid">
            <div class="alJoum">
                <div class="blockImGDaniel">
                    <img src="<?php echo get_stylesheet_directory_uri();?>/img/daniel.png" alt="">
                </div>
                <?php
                echo do_shortcode("[gravityform id='10' title='false' description='false' ajax='true']");
                ?>
            </div>
            <!--  <div class="groeipadenBlock">
                <p class="sousBlockTitleProduct">Groeipaden</p>
                <div class="blockSousblockTitle">
                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Verkoop en sales</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Verkoop en sales</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Leiderschap</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Excel</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">HRM</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?php echo get_stylesheet_directory_uri();?>/img/Image-45.png" alt="">
                                    </div>
                                    <p class="verkop">Marktkoopman</p>
                                    <a href="" class="btn btnMeer">Meer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <?php 
            if(!empty($road_paths)){
            ?>
            <div class="UitgelichteBlock">

                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php 
                            foreach($road_paths as $value){
                                $road_path_title = $value['title'];
                                $road_path_expert = $value['expert'];
                                $preview = get_field('preview', $value[0]->ID)['url'];
                                if(!$preview){
                                    $preview = get_field('url_image_xml', $value[0]->ID);
                                    if(!$preview)
                                        $preview = get_stylesheet_directory_uri() . "/img/libay.png";
                                }

                                $profile_picture = get_field('profile_img',  'user_' . $road_path_expert);
                                if(!$profile_picture)
                                    $profile_picture = get_stylesheet_directory_uri() ."/img/placeholder_user.png";
                                $name = get_userdata($road_path_expert)->data->display_name;
                            ?>
                            <div class="swiper-slide swiper-slide5">
                                <div class="content-road-path-card">
                                    <div class="position-relative element-content-road-path-card">
                                        <img class="" src="<?= $preview; ?>" alt="">
                                        <div class="roadpathBlockNumber">
                                            <p><?= count($value)-3; ?></p>
                                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/folder.png" alt="">
                                        </div>
                                    </div>
                                    <div class="description-content-roadPath">
                                        <div class="imgTitleCours justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <a href="product-road-path?id=<?= $road_path_expert ?>" class="imgCoursProd">
                                                    <img src="<?= $profile_picture; ?>" alt="">
                                                </a>
                                                <a href="product-road-path?id=<?= $road_path_expert ?>" class="nameCoursProd"><?= $name; ?></a>
                                            </div>
                                            <a href="/detail-product-road?id=<?= $value['ID']; ?>" class="btn btnDiscover">Discover</a>
                                        </div>
                                        <p class="werkText"><?= $road_path_title; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }

            ?>
            
            <?php 
            if(!empty($blogs)){
            ?>
            <div class="UitgelichteBlock">
                <p class="sousBlockTitleProduct">Uitgelichte artikelen</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($blogs as $blog) {
                                                            
                            $tag = '';
                            $image = null;

                            //Image
                            $image = get_the_post_thumbnail_url($blog->ID);
                            if(!$image)
                                $image = get_field('preview', $blog->ID)['url'];
                                    if(!$image){
                                        $image = get_field('url_image_xml', $blog->ID);
                                        if(!$image)
                                            $image = get_stylesheet_directory_uri() . '/img/libay.png';
                                    }

                            $author = get_field('profile_img',  'user_' . $blog->post_author);

                            //Summary
                            $summary = get_the_excerpt($blog->ID);

                            if(!$summary)
                                $summary = get_field('short_description', $blog->ID);

                            //Tags
                            $tree = get_the_tags($blog->ID);

                            if($tree)
                                if(isset($tree[2]))
                                    $tag = $tree[2]->name;

                            if($tag = ''){
                                $tagS = intval(explode(',', get_field('categories',  $blog->ID)[0]['value'])[0]);
                                $tagI = intval(get_field('category_xml',  $blog->ID)[0]['value']);
                                if($tagS != 0)
                                    $tag = (String)get_the_category_by_ID($tagS);
                                else if($tagI != 0)
                                    $tag = (String)get_the_category_by_ID($tagI);                                    
                            }
                            ?>
                            <a href="<?php echo get_permalink($blog->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <img src="<?php echo $image; ?>" alt="">
                                    </div>
                                    <div>
                                        <button class="btn btnImgCoeurEcosysteme">
                                            <?php
                                                if(!empty($saved))                                
                                                    if(in_array($blog->ID, $saved))
                                                        echo '<img class="btn_favourite" id="' . $user_id . '_' . $blog->ID . '_course"  src=".' . $like_src . '" alt="">' ;
                                                    else
                                                        echo '<img class="btn_favourite" id="' . $user_id . '_' . $blog->ID . '_course"  src=".' . $dislike_src . '" alt="">' ;
                                            ?>
                                        </button>
                                    </div>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="<?php echo $author; ?>" alt="">
                                                </div>
                                                <p class="nameCoursProd"><?php echo(get_userdata($blog->post_author)->data->display_name); ?></p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm">Artikel</p>
                                                </div>
                                                <?php if($tag != '') { ?>
                                                <div class="blockOpein">
                                                    &#x0023;&#xFE0F;&#x20E3;
                                                    <p class="lieuAm"><?php echo $tag; ?></p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $blog->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo $summary; ?>
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

            if(!empty($categories_topic)){
            ?>
            <div class="groeipadenBlock">
                <p class="sousBlockTitleProduct">Onderwerpen</p>
                <div class="blockSousblockTitle">
                    <div class="swiper-container swipeContaineEvens">
                        <div class="swiper-wrapper">
                            <?php 
                            foreach($categories_topic as $category){
                                $image_category = get_field('image', 'category_'. $category->cat_ID);
                                $image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/Image-45.png';
                            ?>
                            <div class="swiper-slide swipeExpert custom_slide">
                                <div class="cardblockOnder cardExpert">
                                    <div class="imgBlockCardonder">
                                        <img src="<?= $image_category; ?>" alt="">
                                    </div>
                                    <p class="verkop"><?= $category->cat_name; ?></p>
                                    <a href="<?php echo 'category-overview?category=' . $category->cat_ID; ?>" class="btn btnMeer">Meer</a>
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
            }
            if(!empty($others)){
            ?>
            <div class="UitgelichteBlock">
                <p class="sousBlockTitleProduct">Andere artikelen</p>
                <div class="blockCardOpleidingen ">

                    <div class="swiper-container swipeContaine4">
                        <div class="swiper-wrapper">
                            <?php
                            foreach($others as $blog) {

                            if(in_array($blog->ID, $blogs_id))
                                continue;

                            $tag = '';
                            $image = null;

                              //Image
                            $image = get_the_post_thumbnail_url($blog->ID);
                            if(!$image)
                                $image = get_field('preview', $blog->ID)['url'];
                                    if(!$image){
                                        $image = get_field('url_image_xml', $blog->ID);
                                        if(!$image)
                                            $image = get_stylesheet_directory_uri() . '/img/libay.png';
                                    }
                                    

                            $author = get_field('profile_img',  'user_' . $blog->post_author);

                            //Summary
                            $summary = get_the_excerpt($blog->ID);

                            if(!$summary)
                                $summary = get_field('short_description', $blog->ID);

                            //Tags
                            $tree = get_the_tags($blog->ID);

                            if($tree)
                                if(isset($tree[2]))
                                    $tag = $tree[2]->name;

                            if($tag = ''){
                                $tagS = intval(explode(',', get_field('categories',  $blog->ID)[0]['value'])[0]);
                                $tagI = intval(get_field('category_xml',  $blog->ID)[0]['value']);
                                if($tagS != 0)
                                    $tag = (String)get_the_category_by_ID($tagS);
                                else if($tagI != 0)
                                    $tag = (String)get_the_category_by_ID($tagI);                                    
                            }
                            ?>
                            <a href="<?php echo get_permalink($blog->ID) ?>" class="swiper-slide swiper-slide4">
                                <div class="cardKraam2">
                                    <div class="headCardKraam">
                                        <img src="<?php echo $image; ?>" alt="">
                                    </div>
                                    <button class="btn btnImgCoeurEcosysteme">
                                        <?php
                                            if(!empty($saved))                                
                                                if(in_array($blog->ID, $saved))
                                                    echo '<img class="btn_favourite" id="' . $user_id . '_' . $blog->ID . '_course"  src=".' . $like_src . '" alt="">' ;
                                                else
                                                    echo '<img class="btn_favourite" id="' . $user_id . '_' . $blog->ID . '_course"  src=".' . $dislike_src . '" alt="">' ;
                                        ?>                                 
                                    </button>
                                    <div class="contentCardProd">
                                        <div class="group8">
                                            <div class="imgTitleCours">
                                                <div class="imgCoursProd">
                                                    <img src="<?php echo $author; ?>" alt="">
                                                </div>
                                                <p class="nameCoursProd"><?php echo(get_userdata($blog->post_author)->data->display_name); ?></p>
                                            </div>
                                            <div class="group9">
                                                <div class="blockOpein">
                                                    <img class="iconAm" src="<?php echo get_stylesheet_directory_uri();?>/img/graduat.png" alt="">
                                                    <p class="lieuAm">Artikel</p>
                                                </div>
                                                <?php if($tag != '') { ?>
                                                <div class="blockOpein">
                                                    &#x0023;&#xFE0F;&#x20E3;
                                                    <p class="lieuAm"><?php echo $tag; ?></p>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <p class="werkText"><?php echo $blog->post_title; ?></p>
                                        <p class="descriptionPlatform">
                                            <?php echo $summary; ?>
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
        </div>
    </div>
</div>


<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('New message to ' + recipient)
        modal.find('.modal-body input').val(recipient)
    })
   
    // Hidden password
    $(document).ready(function() {
        $(".show_hide_password a").on('click', function(event) {
            if($('.show_hide_password input').attr("type") == "text"){
                $('.show_hide_password input').attr('type', 'password');
                $('.show_hide_password i').addClass( "fa-eye-slash" );
                $('.show_hide_password i').removeClass( "fa-eye" );
            }else if($('.show_hide_password input').attr("type") == "password"){
                // alert("cool1111");
                $('.show_hide_password input').attr('type', 'text');
                $('.show_hide_password i').removeClass( "fa-eye-slash" );
                $('.show_hide_password i').addClass( "fa-eye" );
            }
        });
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

<script>
    $("#btn-signIn").click(()=>{
        datas={
            name:$('#name').val(),
            email:$('#email').val(),
            password:$('#password').val(),
            position:$('#position').val(),
            age:$('#form2Example34').val(),
        }
        console.log(datas)
        $.ajax({

        url:"fetch-ajax",
        method:"post",
        data:datas,
        dataType:"text",
        success: function(data){
            console.log(data);
            $('#autocomplete').html(data);
        }
});
    })
</script>

<?php get_footer(); ?>
<?php wp_footer(); ?>

<script>
    jQuery(document).ready(function(){
        jQuery('#user_login').attr('placeholder', 'E-mailadres of Gebruikersnaam');
        jQuery('#user_pass').attr('placeholder', 'Wachtwoord');
    });
</script>