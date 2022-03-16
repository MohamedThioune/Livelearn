<?php /** Template Name: blog archive */ ?>

<?php
get_header();
?>

<?php
$query = new WP_Query( array( 'post_type' => 'post' ) );
$blogs = $query->posts;

global $post;
?>


<div class="main-wrapper ">

    <section class="section blog-wrap bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1><?php echo get_the_title($post->ID);?></h1>
                </div>
            </div>
            
            <div class="row">
                <?php
                foreach($blogs as $blog) {?>
                <div class="col-lg-6 col-md-6 mb-5">
                    <div class="blog-item">
                        <img src="img/blog/1.jpg" alt="" class="img-fluid rounded">

                        <div class="blog-item-content bg-white p-5">
                            <div class="blog-item-meta bg-gray py-1 px-2">
                                <span class="text-muted text-capitalize mr-3"><i class="ti-pencil-alt mr-2"></i><?php the_author_meta( 'user_nicename' , $blog->post_author ); ?></span>
                                <!--                                <span class="text-muted text-capitalize mr-3"><i class="ti-comment mr-2"></i>5 Comments</span>-->
                                <span class="text-black text-capitalize mr-3"><i class="ti-time mr-1"></i> <?php echo get_the_date('d-m-Y', $blog->ID);?></span>
                            </div> 

                            <h3 class="mt-3 mb-3"><a href="blog-single.php"><?php echo $blog->post_title;?></a></h3>
                            <p class="mb-4"><?php echo $blog->post_excerpt;?></p>

                            <a href="<?php echo get_the_permalink($blog->ID);?>" class="btn btn-small btn-main btn-round-full">Learn More</a>
                        </div>



                    </div>
                </div>

                <?php
                    }
                ?>

            </div>

        </div>
    </section>

    <?php
    get_footer();
    ?>