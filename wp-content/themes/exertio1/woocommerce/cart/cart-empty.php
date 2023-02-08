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
 * @package WooCommerce/Templates
 * @version 3.5.0
 */
defined( 'ABSPATH' ) || exit; ?>
<section class="section-padding empty-cart-page bg-gray-light-color ">
    <div class="container">
        <?php
        /**
         * @hooked wc_empty_cart_message - 10
         */
        do_action('woocommerce_cart_is_empty');
		$alt_id = '';
        if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
            <div class="return-to-shop retutn-shopz">
                <a class="button wc-backward btn btn-theme" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                    <?php esc_html_e( 'Return to shop', 'exertio_theme' ); ?>
                </a>
            </div>
        <?php endif; ?>
        <img src="<?php echo esc_url(trailingslashit( get_template_directory_uri () ) . "libs/images/emptycart.png"); ?>" class="d-block mx-auto mb-4" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
    </div>
</section>