<?php /** Template Name: template product road path */ ?>

<?php wp_head(); ?>
<?php get_header(); ?>

<?php 

$user = (isset($_GET['id'])) ? get_userdata($_GET['id'])->data : 0;

/*
** Leerpaden  owned *
*/

$args = array(
    'post_type' => 'learnpath',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'author' => $user->ID,
);

$leerpaden = get_posts($args);
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<div class="content-road-path">
    <div class="hulpBox">
        <div class="container-fluid">
           <div class="headHulpbox">
               <h1 class="mb-0"><?= $user->display_name ?> - Road Course Path</h1>
               <div class="searchElementPath">
                   <input id="inputSearchElementPath" type="search" placeholder="Search an author or teacher">
                   <img src="<?php echo get_stylesheet_directory_uri();?>/img/searchM.png" class="" alt="">
               </div>
           </div>
            <div class="element-content-roadPath">
                <?php
                foreach($leerpaden as $leerpad){
                    $title = $leerpad->post_title;
                    $road_path = get_field('road_path', $leerpad->ID);
                    $preview = get_field('preview', $road_path[0]->ID)['url'];
                    if(!$preview){
                        $preview = get_field('url_image_xml', $road_path[0]->ID);
                        if(!$preview)
                            $preview = get_stylesheet_directory_uri() . "/img/libay.png";
                    }

                    $profile_picture = get_field('profile_img',  'user_' . $user->ID);
                    if(!$profile_picture)
                        $profile_picture = get_stylesheet_directory_uri() ."/img/placeholder_user.png";
                ?>
                <div class="content-road-path-card">
                    <div class="position-relative element-content-road-path-card">
                        <img class="" src="<?= $preview; ?>" alt="">
                        <div class="roadpathBlockNumber">
                            <p><?= count($road_path); ?></p>
                            <img class="" src="<?php echo get_stylesheet_directory_uri();?>/img/folder.png" alt="">
                        </div>
                    </div>
                    <div class="description-content-roadPath">
                        <div class="imgTitleCours justify-content-between">
                           <div class="d-flex align-items-center">
                               <div class="imgCoursProd">
                                   <img src="<?= $profile_picture ?>" alt="">
                               </div>
                               <p class="nameCoursProd"><?= $user->display_name; ?></p>
                           </div>
                            <a href="/detail-product-road?id=<?= $leerpad->ID; ?>" class="btn btnDiscover">Discover</a>
                        </div>
                        <p class="werkText"><?= $title; ?></p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>


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

<?php get_footer(); ?>
<?php wp_footer(); ?>