<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="woocommerce-form-coupon-toggle mt-3">
	<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'exertio_theme' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'exertio_theme' ) . '</a>' ), 'notice' ); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

	<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'exertio_theme' ); ?></p>
    <div class="row">
    <div class="col-xl-9 col-12">
	<div class="form-group">
		<input type="text" name="coupon_code" class="input-text form-control" placeholder="<?php esc_attr_e( 'Coupon code', 'exertio_theme' ); ?>" id="coupon_code" value="" />
	</div>
    </div>
    <div class="col-xl-3 col-12">
	<div class="form-group prop-coupon-btn">
		<button type="submit" class="btn btn-theme btn-block" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'exertio_theme' ); ?>"><?php esc_html_e( 'Apply coupon', 'exertio_theme' ); ?></button>
	</div>
    </div>
</div>
	<div class="clearfix"></div>
</form>