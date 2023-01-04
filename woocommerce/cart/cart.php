<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>
<style>
    @media (min-width: 300px) and (max-width: 767px){
        #burger {
            margin-top: 0 !important;
            position: relative;
            top: -2px;
        }
    }

</style>
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/template.css" />


<div class="wrapper mt-4 mb-4">
    <div class="container">
        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <div class="theme-cart-wrapper shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">

                <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                <?php
                foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                    $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                    $course_item = get_post($product_id - 1);

                    $course_type = get_field('course_type', $course_item->ID);
                    //Image
                    $course_item_ima = get_field('preview', $course_item->ID)['url'];
                    if(!$course_item_ima){
                        $course_item_ima = get_the_post_thumbnail_url($course_item->ID);
                        if(!$course_item_ima)
                            $course_item_ima = get_field('url_image_xml', $course_item->ID);
                                if(!$course_item_ima)
                                    $course_item_ima = get_stylesheet_directory_uri() . '/img' . '/' . strtolower($course_type) . '.jpg';
                    }

                    //Company
                    $company = get_field('company',  'user_' . $course_item->post_author);
                    $company_title = $company[0]->post_title;
                    $company_logo = get_field('company_logo', $company[0]->ID);

                    //Expert
                    $course_item_author = get_user_by('ID', $course_item->post_author);
                    $course_item_author_image = get_field('profile_img', 'user_' . $course_item->post_author) ?: get_stylesheet_directory_uri() . '/img/placeholder_user.png';
                    $course_item_author_name = (isset($course_item_author->first_name)) ? $course_item_author->first_name : $course_item_author->display_name;

                    if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                        $product_permalink = get_permalink($course_item);
                ?>
                <div class="theme-cart-row <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

                    <div class="theme-cart__product-remove">
                        <?php
                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                esc_html__( 'Remove this item', 'woocommerce' ),
                                esc_attr( $product_id ),
                                esc_attr( $_product->get_sku() )
                            ),
                            $cart_item_key
                        );
                        ?>
                    </div>

                    <div class="theme-cart__product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                        <?php
                        if ( ! $product_permalink ) {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                        } else {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                        }

                        // Backorder notification.
                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                        }
                        ?>
                    </div>

                    <div class="groupCompanyAuthorCart">
                        <div class="company">
                            <div class="imgElement">
                                <img class="" src="<?= $company_logo ?>" alt="">
                            </div>
                            <p class="Name"><?= $company_title ?></p>
                        </div>
                        <div class="author">
                            <div class="imgElement">
                                <img class="" src="<?= $course_item_author_image ?>" alt="">
                            </div>
                            <p class="Name"><?= $course_item_author_name ?></p>
                        </div>
                    </div>

                    <div class="variationBlockCart" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                        <?php
                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
                        // Meta data.
                        echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
                        ?>
                    </div>
                    <hr class="hrcustomInCart">
                    <div class="theme-cart__product-attr-date" data-title="<?php esc_attr_e( 'Date', 'woocommerce' ); ?>">

                    </div>

                    <div class="theme-cart__price-wrapper">
                        <div class="blockPriceWapperDescription">
                            <div class="firstBlock">
                                <p class="shortDescriptionCart"><?= $course_item->post_title ?></p>
                              <!--  <span class="theme-cart__price__title">Prijs</span>-->
                                <div class="theme-cart__product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
                                    <?php
                        echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    ?>
                                </div>
                            </div>
                            <div class="secondBlock">
                            <!--  <span class="theme-cart__price__title">Aantal</span>-->
                                <div class="theme-cart__product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                                    <?php
                        if ( $_product->is_sold_individually() ) {
                            $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                        } else {
                            $product_quantity = woocommerce_quantity_input(
                                array(
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                    'min_value'    => '0',
                                    'product_name' => $_product->get_name(),
                                ),
                                $_product,
                                false
                            );
                        }

                        echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                    ?>
                                </div>
                            </div>
                           <!-- <div class="col-4">
                                <span class="theme-cart__price__title">Totaaleee</span>
                                <div class="theme-cart__product-subtotal" data-title="<?php /*esc_attr_e( 'Subtotal', 'woocommerce' ); */?>">
                                    <?php
/*                        echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                    */?>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <?php
                    }
                }
                ?>

                <?php do_action( 'woocommerce_cart_contents' ); ?>

                <div class="theme-cart__actions">
                    <div class="theme-cart__actions">
                        <?php if ( wc_coupons_enabled() ) { ?>
                        <div class="coupon">
                            <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                        </div>
                        <?php } ?>

                        <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                        <?php do_action( 'woocommerce_cart_actions' ); ?>

                        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    </div>
                </div>

                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
            </div>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>

        <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>


      <div class="cart-checkOut">
          <div class="blockImgCartCourse">
              <img src="<?= $course_item_ima; ?>" alt="">
          </div>
          <div class="cart-collaterals">
              <?php
              /**
               * Cart collaterals hook.
               *
               * @hooked woocommerce_cross_sell_display
               * @hooked woocommerce_cart_totals - 10
               */
              do_action( 'woocommerce_cart_collaterals' );
              ?>
          </div>
      </div>
    </div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
