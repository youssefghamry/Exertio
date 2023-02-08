<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="exertio-thanksyou section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="woocommerce-order">
                    <?php
                    if ( $order ) :

                        do_action( 'woocommerce_before_thankyou', $order->get_id() );
                        ?>

                        <?php if ( $order->has_status( 'failed' ) ) : ?>

                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'exertio_theme' ); ?></p>

                            <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                                <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'exertio_theme' ); ?></a>
                                <?php if ( is_user_logged_in() ) : ?>
                                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'exertio_theme' ); ?></a>
                                <?php endif; ?>
                            </p>

                        <?php else : ?>
                    
                    

                            <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'exertio_theme' ), $order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                    
                    <div class="row">
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-1">
                        <i class="far fa-paper-plane"></i>
                    </div>
                    <div>
                        <h5><?php esc_html_e( 'Order number:', 'exertio_theme' ); ?></h5>
                        <h2><?php echo esc_html($order->get_order_number()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-9">
                       <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <h5><?php esc_html_e( 'Date:', 'exertio_theme' ); ?></h5>
                        <h2><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-4">
                        <i class="fas fa-at"></i>
                    </div>
                    <div>
                        <h5><?php esc_html_e( 'Email:', 'exertio_theme' ); ?></h5>
                        <h2><?php echo esc_html($order->get_billing_email()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-12 col-12">
                <div class="dashboard-statistic-block">
                    <div class="icon gradient-5">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div>
                        <h5><?php esc_html_e( 'Payment method:', 'exertio_theme' ); ?></h5>
                        <h2><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></h2>
                    </div>
                </div>
            </div>
        </div>
                        <?php endif; ?>

                        <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                        <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

                    <?php else : ?>

                        <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'exertio_theme' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

                    <?php endif; ?>

                </div>
            </div>    
        </div>    
    </div>
</section>