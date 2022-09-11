<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

//defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
//do_action( 'woocommerce_cart_is_empty' );
?>
<?php wp_head(); ?>
<?php get_header(); ?>

<div class="theme-empty-cart">
    <div class="row h-100">
        <div class="container align-self-center">
            <div class="contentCart">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/ImageCart.png" alt="">
                <p>Je hebt nog niets geselecteerd om in door te leren</p>
                <a href="/product-search/" class="btn btnBekijkCart">Bekijk alles om te leren</a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
<?php wp_footer(); ?>
