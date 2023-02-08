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
 * @version 4.4.0
 */
defined( 'ABSPATH' ) || exit;
do_action( 'woocommerce_before_cart' ); ?>
<section class="exertio-cart section-padding">
    <div class="container">
        <div class="row">
		<div class="col-lg-8 col-xl-8 col-md-6 col-12">
			<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>
				<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>
					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<div class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'custom-cart-exertio cart_item d-sm-flex justify-content-between align-items-center mb-3 pb-3 border-bottom', $cart_item, $cart_item_key ) ); ?>">
                                <?php
                                $text = 'text-sm-left';
                                $margin = 'mr-4';
                                if(is_rtl())
                                {
                                   $text = 'text-sm-right';
                                   $margin = 'ml-4';
                                }
                                ?>
								<div class="media d-block d-sm-flex align-items-center <?php echo esc_attr($text); ?>">
                                    <?php if($_product->get_type() !="wallet" && $_product->get_type() !="freelancer-packages" && $_product->get_type() !="employer-packages") { ?>
									<div class="product-thumbnail d-inline-block mx-auto mr-sm-4 mb-2 mb-sm-0" >
										<?php
										$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
										if ( ! $product_permalink ) {
											echo wp_kses_post( $thumbnail ); // PHPCS: XSS ok.
										} else {
											printf( '<a href="%s" class="d-block">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
										}
										?>
									</div>
                                    <?php } ?>
									<div class="media-body">
										<div class="main-product-name">
											<?php
											if ( ! $product_permalink ) {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<h3>%s</h3>', $_product->get_name() ), $cart_item, $cart_item_key ));
											} else {
												echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<h3><a href="%s">%s</a></h3>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
											}

											do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
											?>
										</div>
											<?php
											// Meta data.
											echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
											?>
										<div class="product-price" data-title="<?php echo esc_attr__( 'Price', 'exertio_theme' ); ?>">
											<?php
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
											?>
										</div>
										<?php
										// Backorder notification.
										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<div class="product-badge in-stock backorder_notification">' . esc_html__( 'Available on backorder', 'exertio_theme' ) . '</div>', $product_id ) );
										}
										?>
									</div>
								</div>
								<div class=" mx-auto mx-sm-0 text-center  <?php echo esc_attr($text); ?>">
                                    <?php if($_product->get_type() !="wallet" && $_product->get_type() !="freelancer-packages" && $_product->get_type() !="employer-packages") { ?>
									<div class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'exertio_theme' ); ?>">
										<?php
										if ( $_product->is_sold_individually() ) {
											$product_quantity = '';
											$product_quantity .= sprintf( '<label class="font-weight-medium d-none d-sm-block">%s</label>', esc_html_x( 'Quantity', 'front-end', 'exertio_theme' ) );
											$product_quantity .= sprintf( '<div>1</div><input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
										} else {
											$product_quantity_input_id = uniqid( 'quantity_' );

											$product_quantity = '';
											$product_quantity .= '<div class="form-group mb-0">';
											$product_quantity .= sprintf( '<label class="font-weight-medium d-none d-sm-block" for="%s">%s</label>',
												esc_attr( $product_quantity_input_id ),
												esc_html_x( 'Quantity', 'front-end', 'exertio_theme' )
											);
											$product_quantity .= woocommerce_quantity_input(
												array(
													'input_id'     => $product_quantity_input_id,
													'input_name'   => "cart[{$cart_item_key}][qty]",
													'input_value'  => $cart_item['quantity'],
													'max_value'    => $_product->get_max_purchase_quantity(),
													'min_value'    => '0',
													'product_name' => $_product->get_name(),
													'classes'      => 'form-control',
												),
												$_product,
												false
											);
											$product_quantity .= '</div>';
										}
										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
										?>
									</div>
                                    <?php } ?>
									<div class="exertio-product-remove">
										<?php
										echo apply_filters(
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a href="%s" class="text-danger" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="far fa-times-circle"></i> <span class="font-size-sm">%s</span></a>',
												esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
												esc_html__( 'Remove this item', 'exertio_theme' ),
												esc_attr( $product_id ),
												esc_attr( $_product->get_sku() ),
												esc_html__( 'Remove', 'exertio_theme' )
											),
											$cart_item_key
										);
										?>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>
					<?php do_action( 'woocommerce_cart_contents' ); ?>
					<?php
						if($_product->get_type() !="wallet")
						{ ?>
							<div class="row">
								<?php if ( wc_coupons_enabled() ) : ?>
									<div class="col-md-6 mb-3">
										<div class="<?php echo esc_attr($margin);?> input-group">
											<input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="<?php echo esc_attr__( 'Coupon code', 'exertio_theme' ); ?>">
											<div class="input-group-append">
												<button type="submit" class="btn btn-outline-secondary" name="apply_coupon"><?php echo esc_html__( 'Apply coupon', 'exertio_theme' ); ?></button>
											</div>
											<?php do_action( 'woocommerce_cart_coupon' ); ?>
										</div>
									</div>
								<?php endif; ?>
								<div class="prop-up-cart col-md-6">
									<button type="submit" class="btn btn-theme btn-block" name="update_cart" value="<?php echo esc_attr__( 'Update cart', 'exertio_theme' ); ?>">
										<?php echo esc_html__( 'Update cart', 'exertio_theme' ); ?>
									</button>
								</div>
								<?php do_action( 'woocommerce_cart_actions' ); ?>
							</div>
					<?php } ?>
					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</div>
				<?php do_action( 'woocommerce_after_cart_table' ); ?>
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
			</form>
		</div>
		<aside class="col-lg-4 col-xl-4 col-md-6 col-12">
			<div class="rounded-lg box-shadow-lg">
				<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
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
		</aside>
        </div>    
    </div>    
</section>
<?php do_action( 'woocommerce_after_cart' );