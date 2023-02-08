<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
$sort = $list_style = '';
if (isset($_GET['sort']) && $_GET['sort'] != "")
{
    $sort = $_GET['sort'];
}
if (isset($_GET['list-style']) && $_GET['list-style'] != "")
{
    $list_style = $_GET['list-style'];
}
$actionbBar = fl_framework_get_options('action_bar');
$actionbar_space = '';
if(isset($actionbBar) && $actionbBar == 1)
{
    $actionbar_space = 'actionbar_space';
}
?>

    <section class="custom-padding exertio-shop bg-gray-light-color  <?php echo esc_attr($actionbar_space); ?>">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-3">
                    <div class="shop-sidebar">
                        <div class="heading">
                            <h4><?php echo esc_html__('Search Filters','exertio_theme'); ?></h4>
                            <?php
                            $product_page = '';
                            $product_page = fl_framework_get_options('product_search_page');
                            ?>
                            <a href="<?php echo esc_url(get_the_permalink($product_page)); ?>"><?php echo esc_html__('Clear Result','exertio_theme'); ?></a>
                        </div>
                        <div class="project-widgets">
                            <form action="<?php echo get_the_permalink(fl_framework_get_options('product_search_page')); ?>">
                                <aside class="blog-sidebar">
                                    <?php dynamic_sidebar( 'exertio-woo-commerce-widgets' ); ?>
                                </aside>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-9">

                    <?php
                    /**
                     * Change number or products per row to 3
                     */
                    add_filter('loop_shop_columns', 'loop_columns', 999);
                    if (!function_exists('loop_columns')) {
                        function loop_columns() {
                            return 3; // 3 products per row
                        }
                    }
                    if ( woocommerce_product_loop() ) {

                        /**
                         * Hook: woocommerce_before_shop_loop.
                         *
                         * @hooked woocommerce_output_all_notices - 10
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         */
                        do_action( 'woocommerce_before_shop_loop' );

                        woocommerce_product_loop_start();

                        if ( wc_get_loop_prop( 'total' ) ) {
                            while ( have_posts() ) {
                                the_post();

                                /**
                                 * Hook: woocommerce_shop_loop.
                                 */
                                do_action( 'woocommerce_shop_loop' );

                                wc_get_template_part( 'content', 'product' );
                            }
                        }

                        woocommerce_product_loop_end();

                        /**
                         * Hook: woocommerce_after_shop_loop.
                         *
                         * @hooked woocommerce_pagination - 10
                         */
                        do_action( 'woocommerce_after_shop_loop' );
                    } else {
                        /**
                         * Hook: woocommerce_no_products_found.
                         *
                         * @hooked wc_no_products_found - 10
                         */
                        do_action( 'woocommerce_no_products_found' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php


/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
