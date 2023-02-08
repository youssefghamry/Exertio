<?php
/* Shop Settings */
add_action('pre_get_posts', 'fl_shop_filter_cat');
if (!function_exists('fl_shop_filter_cat')) {

    function fl_shop_filter_cat($query) {
        if (!is_admin() && is_post_type_archive('product') && $query->is_main_query() && is_shop()) {

            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => array('service','wallet','employer-packages','freelancer-packages'),
                    'operator' => 'NOT IN',
                ),
                    )
            );
        }
    }

}
//=======fa=======
/* Remove Categories, sku from Single Products */
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// Remove Sharing icons
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );