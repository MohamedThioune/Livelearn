<?php /** Template Name: blog archive */ ?>

<?php
get_header();
?>

<head>
    <meta name=”robots” content=”noindex,nofollow”>
</head>

<?php
// $page = 'check_visibility.php';
// require($page); 

?>

<?php
$query = new WP_Query( array( 'post_type' => 'post' ) );
$blogs = $query->posts;

global $post;
?>

<?php if(isset($_GET['message'])) echo "<span class='alert alert-success'>" . $_GET['message'] . "</span>"?>

<div class="main-wrapper ">

    <section class="section blog-wrap bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="titlePage"><?php echo get_the_title($post->ID);?></h1>
                </div>

                <div class="containe-blog">
                    <?php
                    foreach($blogs as $blog) {
                    if(!visibility($blog, $visibility_company))
                        continue;
                        
                    //Description
                    $short = ($blog->post_excerpt) ? : get_field('short_description', $blog->ID);

                    //Image
                    $image = get_the_post_thumbnail_url($blog->ID);
                    if(!$image)
                        $image = get_field('preview', $blog->ID)['url'];
                    if(!$image)
                        $image = get_field('url_image_xml', $blog->ID);
                    if(!$image)
                        $image = get_stylesheet_directory_uri() . '/img/blog/1.jpg';

                    //Author
                    $user_picture = get_field('profile_img', $blog->ID) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';

                    //Category
                    $category = ' ';
                    $category_id = 0;
                    $category_string = " ";
                    if($category == ' '){
                        $category_str = intval(explode(',', get_field('categories',  $blog->ID)[0]['value'])[0]);
                        $category_id = intval(get_field('category_xml',  $blog->ID)[0]['value']);
                        if($category_str != 0)
                            $category = (String)get_the_category_by_ID($category_str);
                        else if($category_id != 0)
                            $category = (String)get_the_category_by_ID($category_id);                                    
                    }

                    ?>
                    <a href="<?php echo get_the_permalink($blog->ID);?>" class="card-containe">
                        <div class="card-image">
                            <img src="<?= $image; ?>" alt="img-Blog" />
                        </div>
                        <div class="card-body">
                            <span class="card-badge card-badge-blue"><?= $category; ?></span>
                            <h1>
                                <?php echo $blog->post_title;?>
                            </h1>
                            <p class="card-subtitle">
                                <?= $short; ?>
                            </p>
                            <div class="card-author">
                                <img  src="<?= $user_picture; ?>" alt="">
                                <div class="author-info">
                                    <p class="author-name"><?php the_author_meta( 'user_nicename' , $blog->post_author ); ?></p>
                                    <p class="post-timestamp"><?php echo get_the_date('d-m-Y', $blog->ID);?></p>
                                </div>
                            </div>
                        </div>
                    </a>

                        <?php
                    }
                    ?>
                </div>






            </div>
            


        </div>
    </section>
    
</div>
<?php get_footer(); ?>
<?php wp_footer(); ?>
