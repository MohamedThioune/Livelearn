<?php /** Template Name: 404.php */ ?>
<?php get_header(); ?>

<div class="content-404 text-center">
    <div class="img">
        <img src="<?php echo get_stylesheet_directory_uri();?>/img/error.png" alt="">
    </div>
    <h1 class="error-title">Error 404 : Page Not Found</h1>
    <p class="description-error">The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
    <div class="d-flex justify-content-center w-100">
        <a href="" class="btn btnGoBack">Go Back</a>
        <a href="" class="btn btnHomeP">Homepage</a>
    </div>
</div>


<?php get_template_part( 'partials/content-none' ); ?>
<?php //endif; ?>

<?php get_footer(); ?>