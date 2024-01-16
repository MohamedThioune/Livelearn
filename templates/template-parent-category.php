<?php /** Template Name: Parent category overview */ ?>
<body>
<?php wp_head(); ?>
<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />

<?php
$parent_category = $_GET['subtopic'] ?: null;
$parent_category = intval($parent_category);

//Get ID Parent Category
$name = get_the_category_by_ID($parent_category);
$no_content =  '
                <p class="dePaterneText theme-card-description"> 
                <span style="color:#033256"> This category not found ❗️</span> 
                </p>
                ';
if(!$name):
    echo $no_content;
    die();
endif;

//Category information
$genuine_category = get_categories(array('taxonomy' => 'course_category', 'orderby' => 'name', 'hide_empty' => 0, 'include' => (int)$parent_category) )[0];
if(is_wp_error($name) || is_wp_error($genuine_category)):
    echo $no_content;
    die();
endif;
$name = (string)$name;
$image_category = get_field('image', 'category_'. $parent_category);
$image_category = $image_category ? $image_category : get_stylesheet_directory_uri() . '/img/placeholder.png';

$categories_children = get_categories( array(
    'taxonomy'   => 'course_category', // Taxonomy to retrieve terms for. We want 'category'. Note that this parameter is default to 'category', so you can omit it
    'orderby'    => 'name',
    'parent'     => $parent_category,
    'hide_empty' => 0, // change to 1 to hide categores not having a single post
) );

?>

<div class="content-community-overview bg-gray">
    <section class="boxOne3-1">
        <div class="container">
            <div class="BaangerichteBlock">
                <img src="<?= $image_category ?>" class=" border-0 img-head-about" alt="">
                <h1 class="wordDeBestText2"><?= $name ?></h1>
            </div>
    </section>
    <section class="section-all-topic">
        <div class="container-fluid">
            <div class="content-card-topics">
                <div class="card-topics new-card-topics">
                    <ul class="d-flex flex-wrap">
                    <?php
                    if(!empty($categories_children)):
                        echo '<ul class="d-flex flex-wrap">';
                        foreach ($categories_children as $key => $category)
                            echo '<li><a href="/category-overview/?category='.$category->cat_ID.'">' . $category->cat_name . '</a></li>';
                        echo '</ul';
                    else:
                        echo '<h1 class="wordDeBestText2">No topics ! </h1>';
                    endif;
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>
</body>


