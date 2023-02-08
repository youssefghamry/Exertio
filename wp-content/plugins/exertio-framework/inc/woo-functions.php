<?php
/*CREATING WOO COMMERCE PRODUCT TYPE AND HIDING TABS*/
function exertio_category_pricing_custom_js() {

	if ( 'product' != get_post_type() ) :
		return;
	endif;

	?><script type='text/javascript'>
			jQuery( document ).ready( function() {
				jQuery('#general_product_data .pricing').addClass('show_if_wallet');
				jQuery('#product-type').trigger( 'change' );
			});

	</script><?php
}
add_action( 'admin_footer', 'exertio_category_pricing_custom_js' );
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
	// #1 Add New Product Type to Select Dropdown

	add_filter( 'product_type_selector', 'fl_add_custom_product_type' );

	function fl_add_custom_product_type( $types )
	{
		$types[ 'wallet' ] = 'Exertio Wallet';
		return $types;
	}
    add_filter( 'product_type_selector', 'fl_add_custom_product_type_service' );
    function fl_add_custom_product_type_service( $types )
    {
        $types[ 'service' ] = 'Exertio Service';
        return $types;
    }

	// --------------------------
	// #2 Add New Product Type Class

	add_action( 'init', 'fl_create_custom_product_type' );

	function fl_create_custom_product_type(){
		class WC_Product_Custom extends WC_Product {
		  public function get_type() {
			 return 'wallet';
		  }
		}
	}
    add_action( 'init', 'fl_create_custom_product_type_service' );

    function fl_create_custom_product_type_service(){
        class WC_Product_Custom_service extends WC_Product {
            public function get_type() {
                return 'service';
            }
        }
    }

	// --------------------------
	// #3 Load New Product Type Class

	add_filter( 'woocommerce_product_class', 'fl_woocommerce_product_class', 10, 2 );

	function fl_woocommerce_product_class( $classname, $product_type ) {
		if ( $product_type == 'wallet' ) {
			$classname = 'WC_Product_Custom';
		}
		return $classname;
	}
	add_filter('woocommerce_product_data_tabs', 'remove_woo_product_data_tab', 11, 1);
	function remove_woo_product_data_tab($tabs){

		$tabs['attribute']['class'][] = 'hide_if_wallet';
		$tabs['shipping']['class'][] = 'hide_if_wallet';
		$tabs['linked_product']['class'][] = 'hide_if_wallet';
		$tabs['advanced']['class'][] = 'hide_if_wallet';

		?>
		<script>
			jQuery( document ).ready( function() {
				jQuery('#general_product_data .pricing').addClass('show_if_wallet');
				jQuery('#product-type').trigger( 'change' );
			});
		</script>
		<?php
		return($tabs);
	}
	//service
    add_filter( 'woocommerce_product_class', 'fl_woocommerce_product_class_service', 10, 2 );

    function fl_woocommerce_product_class_service( $classname, $product_type ) {
        if ( $product_type == 'service' ) {
            $classname = 'WC_Product_Custom_service';
        }
        return $classname;
    }
    add_filter('woocommerce_product_data_tabs', 'remove_woo_product_data_tab_service', 11, 1);
    function remove_woo_product_data_tab_service($tabs){

        $tabs['attribute']['class'][] = 'hide_if_service';
        $tabs['shipping']['class'][] = 'hide_if_service';
        $tabs['linked_product']['class'][] = 'hide_if_service';
        $tabs['advanced']['class'][] = 'hide_if_service';

        ?>
        <script>
            jQuery( document ).ready( function() {
                jQuery('#general_product_data .pricing').addClass('show_if_service');
                jQuery('#product-type').trigger( 'change' );
            });
        </script>
        <?php
        return($tabs);
    }
}
// Get Products
if ( ! function_exists( 'fl_get_products' ) )
{
	function fl_get_products()
	{
		$args	=	array(
		'post_type' => 'product',
		'tax_query' => array(
			array(
			   'taxonomy' => 'product_type',
			   'field' => 'slug',
			   'terms' => 'wallet'
			),
		),
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'meta_value_num',
		'meta_key' => '_price',
		'order'=> 'ASC',
		//'orderby' => 'price'
		);
		$packages = new WP_Query( $args );
		$html ='';
		$html .= '<select name="funds_amount" class="general_select form-control" required data-smk-msg="'.esc_html__('Select amount to deposit','exertio_framework').'"><option value="">'.esc_html__("Select amount to deposit","exertio_framework").'</option>';
		while ( $packages->have_posts() )
		{
			$packages->the_post();
			$products_id	=	get_the_ID();
			$product	=	wc_get_product( $products_id );
			//$product_title = $product->get_title();
			$product_price = $product->get_price();
			$html .= '<option value="'.$products_id.'">'.fl_price_separator($product_price).'</option>';
		}
		$html .=  '</select>';
		return $html;
	}
}
// Get Products
if ( ! function_exists( 'fl_get_products' ) )
{
    function fl_get_products()
    {
        $args	=	array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'wallet'
                ),
            ),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'meta_value_num',
            'meta_key' => '_price',
            'order'=> 'ASC',
            //'orderby' => 'price'
        );
        $packages = new WP_Query( $args );
        $html ='';
        $html .= '<select name="funds_amount" class="general_select form-control" required data-smk-msg="'.esc_html__('Select amount to deposit','exertio_framework').'"><option value="">'.esc_html__("Select amount to deposit","exertio_framework").'</option>';
        while ( $packages->have_posts() )
        {
            $packages->the_post();
            $products_id	=	get_the_ID();
            $product	=	wc_get_product( $products_id );
            //$product_title = $product->get_title();
            $product_price = $product->get_price();
            $html .= '<option value="'.$products_id.'">'.fl_price_separator($product_price).'</option>';
        }
        $html .=  '</select>';
        return $html;
    }
}

/*DEPOSIT FUNDS CALLBACK*/
add_action('wp_ajax_fl_deposit_funds_callback', 'fl_deposit_funds_callback');
if ( ! function_exists( 'fl_deposit_funds_callback' ) )
{
	function fl_deposit_funds_callback()
	{

		/*DEMO DISABLED*/
		exertio_demo_disable('json');

		check_ajax_referer( 'fl_deposit_funds_secure', 'security' );

		//fl_authenticate_check();
		parse_str($_POST['deposit_fund_data'], $params);
		$products_id = $params['funds_amount'];

		if ( class_exists( 'WooCommerce' ) )
		{
				global $woocommerce;
				$qty = 1;
				if( $woocommerce->cart->add_to_cart($products_id, $qty) )
				{
					$checkout_url = wc_get_checkout_url();
					$return = array('message' => esc_html__( 'Redirecting to payment page', 'exertio_framework' ),'cart_page' => $checkout_url);
					wp_send_json_success($return);

				}
		}
		else
		{
			$return = array('message' => esc_html__( 'WooCommerce plugin is not active', 'exertio_framework' ));
			wp_send_json_error($return);
			exit();
		}
	}
}

if ( ! function_exists( 'fl_woocommerce_order_status_completed' ) )
{
	function fl_woocommerce_order_status_completed( $order_id )
	{

		$order = wc_get_order( $order_id );
		$items = $order->get_items();

		foreach ( $items as $item )
		{
			$product = wc_get_product( $item['product_id'] );


			$prduct_type = $product->get_type();
			if($prduct_type == 'wallet')
			{
				$user_id = $order->get_user_id();
				$amount = $order->get_total();
				$ex_amount = get_user_meta( $user_id, '_fl_wallet_amount', true );

				if(isset($ex_amount) && $ex_amount != '')
				{
					$new_amount = $ex_amount+$amount;
					update_user_meta($user_id, '_fl_wallet_amount',$new_amount);
				}
				else
				{
					update_user_meta($user_id, '_fl_wallet_amount',$amount);
				}
				update_user_meta($user_id, 'is_payment_verified', 1);
				/*STATEMENT HOOK*/
				do_action( 'exertio_transection_action',array('post_id'=> '','price'=>$amount,'t_type'=>'wallet_added','t_status'=>'1', 'user_id'=> $user_id));
			}
		}
	}
}
add_action( 'woocommerce_order_status_completed', 'fl_woocommerce_order_status_completed', 10, 1 );

if ( ! function_exists( 'fl_woocommerce_auto_complete_order' ) )
{
	function fl_woocommerce_auto_complete_order( $order_id )
	{
		if ( ! $order_id ) {
			return;
		}
		if(fl_framework_get_options('wallet_amount_aproval') == 1)
		{
			$order = wc_get_order( $order_id );
			$items = $order->get_items();

			$order_status  = $order->get_status();
			if( in_array( $order->get_status(), ['failed','pending'] ) )
			{
				foreach ( $items as $item )
				{
					$product = wc_get_product( $item['product_id'] );

					$prduct_type = $product->get_type();
					if($prduct_type == 'wallet')
					{
						$order->update_status( 'pending' );
					}
				}
			}
			else
			{
				$payment_methods = (fl_framework_get_options('exertio_wallet_payment_methods') == '' )? array():fl_framework_get_options('exertio_wallet_payment_methods');
				if(  in_array( $order->get_payment_method(), $payment_methods ) )
				{
					foreach ( $items as $item )
					{
						$product = wc_get_product( $item['product_id'] );
						$prduct_type = $product->get_type();
						if($prduct_type == 'wallet')
						{
							$order->update_status( 'pending' );
						}
					}
				}
				else
				{
					foreach ( $items as $item )
					{
						$product = wc_get_product( $item['product_id'] );

						$prduct_type = $product->get_type();
						if($prduct_type == 'wallet')
						{
							$order->update_status( 'completed' );
						}
					}
				}
			}
		}
	}
}
add_action( 'woocommerce_thankyou', 'fl_woocommerce_auto_complete_order' );

add_filter( 'woocommerce_add_cart_item_data', 'exertion_allow_one_product_cart' );

function exertion_allow_one_product_cart( $cart_item_data ) {

    global $woocommerce;
    $woocommerce->cart->empty_cart();

    // Do nothing with the data and return
    return $cart_item_data;
}



/*REMOVE TAXES AND SHIPPING PRICE FOR THE PACKAGES AND WALLET*/
add_filter( 'woocommerce_package_rates', 'exertio_remover_shipping_tax_pkg', 10, 2 );
if ( ! function_exists( 'exertio_remover_shipping_tax_pkg' ) )
{
	function exertio_remover_shipping_tax_pkg( $rates, $package )
	{
		$new_cost = 0;
		$tax_rate = 0;
		 foreach( $package['contents'] as $cart_item ) {
			 $product_id = $cart_item['product_id'];
			 $product = wc_get_product($product_id);
			 $product_type = $product->get_type();
			if($product_type == 'wallet' || $product_type == 'employer-packages' || $product_type == 'freelancer-packages')
			{
				foreach( $rates as $rate_key => $rate )
				{
					$rates[$rate_key]->cost = $new_cost;
					$taxes = array();
					foreach ($rates[$rate_key]->taxes as $key => $tax){
						if( $rates[$rate_key]->taxes[$key] > 0 )
							$taxes[$key] = $new_cost * $tax_rate;
					}
					$rates[$rate_key]->taxes = $taxes;

				}
				return $rates;
			}
		}
	}
}


	if ( ! function_exists( 'exertio_wallet_products' ) )
	{
		function exertio_wallet_products()
		{
			$args	=	array(
			'post_type' => 'product',
			'tax_query' => array(
				array(
				   'taxonomy' => 'product_type',
				   'field' => 'slug',
				   'terms' => 'wallet'
				),
			),
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'order'=> 'ASC',
			'orderby' => 'title'
			);
			$packages = new WP_Query( $args );
			return $packages;
		}
	}

/*DEPOSIT CUSTOM FUNDS CALLBACK*/
add_action('wp_ajax_fl_deposit_custom_funds_callback', 'fl_deposit_custom_funds_callback');
if ( ! function_exists( 'fl_deposit_custom_funds_callback' ) )
{
	function fl_deposit_custom_funds_callback()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');

		check_ajax_referer( 'fl_deposit_funds_secure', 'security' );

		parse_str($_POST['deposit_custom_fund_data'], $params);
		$custom_amount = $params['custom_funds_amount'];

		//setcookie("wallet_amount", $params['custom_funds_amount'], 0, "/");
		setcookie("wallet_amount", $custom_amount, time() + (86400 * 30), "/"); // 86400 = 1 day

		$product_id = fl_framework_get_options('wallet_custom_deposit_package');
		//echo $_COOKIE['wallet_amount'].'//'.$product_id;
		//exit;
		if ( class_exists( 'WooCommerce' ) )
		{
				global $woocommerce;
				$qty = 1;
				if( $woocommerce->cart->add_to_cart($product_id, $qty) )
				{
					$checkout_url = wc_get_checkout_url();
					$return = array('message' => esc_html__( 'Redirecting to payment page', 'exertio_framework' ),'cart_page' => $checkout_url);
					wp_send_json_success($return);

				}
		}
		else
		{
			$return = array('message' => esc_html__( 'WooCommerce plugin is not active', 'exertio_framework' ));
			wp_send_json_error($return);
			exit();
		}
	}
}

/*ONLY FOR THE CUSTOM WALLET AMOUNT*/
add_action( 'woocommerce_before_calculate_totals', 'woo_add_custom_amount_hook');
function woo_add_custom_amount_hook()
{
    global $woocommerce;
	$deposit_type = fl_framework_get_options('exertio_wallet_deposit');
	if(isset($deposit_type) && $deposit_type == 1)
	{
		$saved_product_id = fl_framework_get_options('wallet_custom_deposit_package');

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item )
		{
			$product_detail = wc_get_product( $cart_item['product_id'] );
			$prduct_type = $product_detail->get_type();

			if(isset($prduct_type) && $prduct_type == 'wallet')
			{
				if($cart_item['product_id'] == $saved_product_id && ! empty($_COOKIE['wallet_amount']))
				{
					$cart_item['data']->set_price($_COOKIE['wallet_amount']);
				}
			}

		}
	}
}









/*ONLY FOR THE CUSTOM SERVICE AMOUNT*/
add_action( 'woocommerce_before_calculate_totals', 'woo_add_custom_amount_hook_service');
function woo_add_custom_amount_hook_service()
{
    global $woocommerce;
    $deposit_type = fl_framework_get_options('exertio_service_deposit');
    if(isset($deposit_type) && $deposit_type == 1)
    {
        $saved_product_id = fl_framework_get_options('service_custom_deposit_package');

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item )
        {
            $product_detail = wc_get_product( $cart_item['product_id'] );
            $prduct_type = $product_detail->get_type();

            if(isset($prduct_type) && $prduct_type == 'service')
            {
                if($cart_item['product_id'] == $saved_product_id && ! empty($_COOKIE['service_amount']))
                {
                    $cart_item['data']->set_price($_COOKIE['service_amount']);
                }
            }

        }
    }
}

//for services
if ( ! function_exists( 'exertio_service_products' ) )
{
    function exertio_service_products()
    {
        $args	=	array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field' => 'slug',
                    'terms' => 'service'
                ),
            ),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order'=> 'ASC',
            'orderby' => 'title'
        );
        $packages = new WP_Query( $args );
        return $packages;
    }
}

/*DEPOSIT CUSTOM FUNDS CALLBACK*/
add_action('wp_ajax_nopriv_fl_deposit_custom_service_callback', 'fl_deposit_custom_service_callback');
add_action('wp_ajax_fl_deposit_custom_service_callback', 'fl_deposit_custom_service_callback');
if ( ! function_exists( 'fl_deposit_custom_service_callback' ) ) {
    function fl_deposit_custom_service_callback()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        //check_ajax_referer( 'fl_deposit_service_secure', 'security' );

        parse_str($_POST['deposit_custom_service_data'], $params);
        //fl_authenticate_check($_POST['sid']);
        $sid = $_POST['sid'];
        $admin_commission_emp = 0;
        $service_price = get_post_meta($sid, '_service_price', true);
        if (fl_framework_get_options('service_charges_employer') != null && fl_framework_get_options('service_charges_employer') > 0) {
            $admin_commission_percent_emp = fl_framework_get_options('service_charges_employer');
            $decimal_amount_emp = $admin_commission_percent_emp / 100;
            $admin_commission_emp = $decimal_amount_emp * $service_price;
        }

        $service_status = get_post_meta($sid, '_service_status', true);

        if (isset($service_status) && $service_status == 'expired') {
            $return = array('message' => esc_html__('This service has been expired', 'exertio_framework'));
            wp_send_json_error($return);
        }
        parse_str($_POST['deposit_custom_service_data'], $params);
        $current_datetime = current_time('mysql');
        $current_user = get_current_user_id();

        $post = get_post($sid);
        $post_author = $post->post_author;
        $seller_id = get_user_meta($post_author, 'freelancer_id', true);

        if ($current_user != $post_author) {
            $buyer_id = get_user_meta($current_user, 'employer_id', true);

            $selected_addon_ids = isset($params['services_addon']) ? $params['services_addon'] : array();
            if (!empty($selected_addon_ids)) {
                $args = array(
                    'post__in' => $selected_addon_ids,
                    'post_type' => 'addons',
                    'meta_query' => array(
                        array(
                            'key' => '_addon_status',
                            'value' => 'active',
                            'compare' => '=',
                        ),
                    ),
                    'post_status' => 'publish'
                );
                $addons = get_posts($args);
                $addon_prices = array();
                foreach ($addons as $addon) {
                    $addon_prices[] = get_post_meta($addon->ID, '_addon_price', true);
                }

                $total_addon_price = array_sum($addon_prices);
                $gran_total = $service_price + $total_addon_price;
            } else {
                $selected_addon_ids = 0;
                $total_addon_price = 0;

                $gran_total = $service_price + $total_addon_price;
            }
            if( $sid != '')
            {
                global $wpdb;
                $table =  EXERTIO_PURCHASED_SERVICES_TBL;
                $post = get_post($sid);
                $post_author = $post->post_author;
                $current_user = get_current_user_id();
                $current_datetime = current_time('mysql');
                $seller_id = get_user_meta($post_author, 'freelancer_id', true);
                $buyer_id = get_user_meta($current_user, 'employer_id', true);
                $data = array(
                    'timestamp' => $current_datetime,
                    'updated_on' =>$current_datetime,
                    'service_id' => $sid,
                    'addon_ids' => json_encode(sanitize_text_field($selected_addon_ids)),
                    'buyer_id' => sanitize_text_field($buyer_id),
                    'seller_id' => sanitize_text_field($seller_id),
                    'total_price' => sanitize_text_field($gran_total),
                    'service_price' => sanitize_text_field($service_price),
                    'addon_price' => sanitize_text_field($total_addon_price),
                    'status' => 'ongoing',
                );

                $wpdb->insert($table,$data);
                $service_id = $wpdb->insert_id;
                if($service_id)
                {
                    $admin_commission_percent = fl_framework_get_options('service_charges');
                    $decimal_amount = $admin_commission_percent/100;
                    $admin_commission = $decimal_amount*$gran_total;
                    $freelancer_earning = $gran_total - $admin_commission;
                    $currency_symbol = fl_framework_get_options('fl_currency');

                    $logs_table = EXERTIO_SERVICE_LOGS_TBL;
                    $log_data = array(
                        'timestamp' => $current_datetime,
                        'updated_on' =>$current_datetime,
                        'service_id' => $sid,
                        'purhcased_sid' => $service_id,
                        'employer_id' => sanitize_text_field($buyer_id),
                        'freelancer_id' => sanitize_text_field($seller_id),
                        'service_currency' => sanitize_text_field($currency_symbol),
                        'total_service_cost' => sanitize_text_field($gran_total),
                        'addons_cost' => sanitize_text_field($total_addon_price),
                        'admin_commission' => sanitize_text_field($admin_commission),
                        'commission_percent' => sanitize_text_field($admin_commission_percent),
                        'freelacner_earning' => sanitize_text_field($freelancer_earning),
                        'status' => 'ongoing',
                    );
                    $wpdb->insert($logs_table,$log_data);
                    $log_id = $wpdb->insert_id;
                    if(empty($log_id))
                    {
                        $return = array('message' => esc_html__( 'Can not update service logs, please contact admin', 'exertio_framework' ));
                        wp_send_json_error($return);
                        exit;
                    }
                    else
                    {
                        /*NOTIFICATION*/
                        do_action( 'exertio_notification_filter',array('post_id'=> $sid,'n_type'=>'service_purchased','sender_id'=>$current_user,'receiver_id'=>$post_author,'sender_type'=>'employer'));

                        /*EMAIL ON ORDER RECEIVED*/
                        if(fl_framework_get_options('fl_email_freelancer_service_receive') == true)
                        {
                            fl_service_purchased_freelancer_email($post_author,$sid,$gran_total);
                        }
                        if(fl_framework_get_options('fl_email_emp_order_created') == true)
                        {
                            fl_service_purchased_employer_email($current_user,$sid,$gran_total, $post_author );
                        }
//                                $return = array('message' => esc_html__( 'Service purchased successfully', 'exertio_framework' ));
//                                wp_send_json_success($return);
                    }
                }
                else
                {
                    $return = array('message' => esc_html__( 'Error!!! could not purchase service.', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
            }
            else
            {
                $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }
        else
        {
            $return = array('message' => esc_html__( 'You can not purchase your own service', 'exertio_framework' ));
            wp_send_json_error($return);
        }
            setcookie("service_amount", $gran_total, time() + (86400 * 30), "/"); // 86400 = 1 day
            $product_id = fl_framework_get_options('service_custom_deposit_package');
            if (class_exists('WooCommerce')) {

                global $woocommerce;
                WC()->session->set('_fl_dir_payement_sid', $sid);
                $qty = 1;
                if ($woocommerce->cart->add_to_cart($product_id, $qty)) {
                    $checkout_url = wc_get_checkout_url();
                    $return = array('message' => esc_html__('Redirecting to payment page', 'exertio_framework'), 'page' => $checkout_url);
                    wp_send_json_success($return);

                }
            } else {
                $return = array('message' => esc_html__('WooCommerce plugin is not active', 'exertio_framework'));
                wp_send_json_error($return);
                exit();
            }
        }

}
//order status for service
if ( ! function_exists( 'fl_woocommerce_auto_complete_service_order' ) )
{
    function fl_woocommerce_auto_complete_service_order( $order_id )
    {
//        $sid='';
        $product_id = '';
        $order = wc_get_order( $order_id );
        $items = $order->get_items();
        foreach ( $items as $key => $item )
        {
            $product_id = $item['product_id'];
            $product = wc_get_product( $item['product_id'] );
            $prduct_type = $product->get_type();
            if($prduct_type == 'service')
            {
                $sid        = wc_get_order_item_meta($key, '_fl_dir_payement_sid');
                $user_id = $order->get_user_id();
                update_user_meta($user_id, '_customer_user', $order_id);
                if ( $order->has_status('completed') ) {
                    $service_price = get_post_meta($sid, '_service_price', true);
                    if (fl_framework_get_options('service_charges_employer') != null && fl_framework_get_options('service_charges_employer') > 0) {
                        $admin_commission_percent_emp = fl_framework_get_options('service_charges_employer');
                        $decimal_amount_emp = $admin_commission_percent_emp / 100;
                        $admin_commission_emp = $decimal_amount_emp * $service_price;
                    }
                    $selected_addon_ids = isset($params['services_addon']) ? $params['services_addon'] : array();
                    if (!empty($selected_addon_ids)) {
                        $args = array(
                            'post__in' => $selected_addon_ids,
                            'post_type' => 'addons',
                            'meta_query' => array(
                                array(
                                    'key' => '_addon_status',
                                    'value' => 'active',
                                    'compare' => '=',
                                ),
                            ),
                            'post_status' => 'publish'
                        );
                        $addons = get_posts($args);
                        $addon_prices = array();
                        foreach ($addons as $addon) {
                            $addon_prices[] = get_post_meta($addon->ID, '_addon_price', true);
                        }

                        $total_addon_price = array_sum($addon_prices);
                        $gran_total = $service_price + $total_addon_price;
                    } else {
                        $selected_addon_ids = 0;
                        $total_addon_price = 0;

                        $gran_total = $service_price + $total_addon_price;
                    }
                    if( $sid != '')
                    {
                        global $wpdb;
                        $table =  EXERTIO_PURCHASED_SERVICES_TBL;
                        $post = get_post($sid);
                        $post_author = $post->post_author;
                        $current_user = get_current_user_id();
                        $current_datetime = current_time('mysql');
                        $seller_id = get_user_meta($post_author, 'freelancer_id', true);
                        $buyer_id = get_user_meta($current_user, 'employer_id', true);
                        $data = array(
                            'timestamp' => $current_datetime,
                            'updated_on' =>$current_datetime,
                            'service_id' => $sid,
                            'addon_ids' => json_encode(sanitize_text_field($selected_addon_ids)),
                            'buyer_id' => sanitize_text_field($buyer_id),
                            'seller_id' => sanitize_text_field($seller_id),
                            'total_price' => sanitize_text_field($gran_total),
                            'service_price' => sanitize_text_field($service_price),
                            'addon_price' => sanitize_text_field($total_addon_price),
                            'status' => 'ongoing',
                        );

                        $wpdb->insert($table,$data);
                        $service_id = $wpdb->insert_id;
                        if($service_id)
                        {
                            $admin_commission_percent = fl_framework_get_options('service_charges');
                            $decimal_amount = $admin_commission_percent/100;
                            $admin_commission = $decimal_amount*$gran_total;
                            $freelancer_earning = $gran_total - $admin_commission;
                            $currency_symbol = fl_framework_get_options('fl_currency');

                            $logs_table = EXERTIO_SERVICE_LOGS_TBL;
                            $log_data = array(
                                'timestamp' => $current_datetime,
                                'updated_on' =>$current_datetime,
                                'service_id' => $sid,
                                'purhcased_sid' => $service_id,
                                'employer_id' => sanitize_text_field($buyer_id),
                                'freelancer_id' => sanitize_text_field($seller_id),
                                'service_currency' => sanitize_text_field($currency_symbol),
                                'total_service_cost' => sanitize_text_field($gran_total),
                                'addons_cost' => sanitize_text_field($total_addon_price),
                                'admin_commission' => sanitize_text_field($admin_commission),
                                'commission_percent' => sanitize_text_field($admin_commission_percent),
                                'freelacner_earning' => sanitize_text_field($freelancer_earning),
                                'status' => 'ongoing',
                            );
                            $wpdb->insert($logs_table,$log_data);
                            $log_id = $wpdb->insert_id;
                            if(empty($log_id))
                            {
                                $return = array('message' => esc_html__( 'Can not update service logs, please contact admin', 'exertio_framework' ));
                                wp_send_json_error($return);
                                exit;
                            }
                            else
                            {
                                /*NOTIFICATION*/
                                do_action( 'exertio_notification_filter',array('post_id'=> $sid,'n_type'=>'service_purchased','sender_id'=>$current_user,'receiver_id'=>$post_author,'sender_type'=>'employer'));

                                /*EMAIL ON ORDER RECEIVED*/
                                if(fl_framework_get_options('fl_email_freelancer_service_receive') == true)
                                {
                                    fl_service_purchased_freelancer_email($post_author,$sid,$gran_total);
                                }
                                if(fl_framework_get_options('fl_email_emp_order_created') == true)
                                {
                                    fl_service_purchased_employer_email($current_user,$sid,$gran_total, $post_author );
                                }
                                if(fl_framework_get_options('service_amount_approval') == 1) {?>
                                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Service Purchased Successfully', 'woocommerce' ), null ); ?></p>
                               <?php }
                            }
                        }
                        else
                        {
                            $return = array('message' => esc_html__( 'Error!!! could not purchase service.', 'exertio_framework' ));
                            wp_send_json_error($return);
                        }
                    }
                    else
                    {
                        $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
                        wp_send_json_error($return);
                    }
                }
            }
        }
    }
}
add_action( 'woocommerce_order_status_completed', 'fl_woocommerce_auto_complete_service_order', 10, 1 );

//adding order-meta
$hidden_order_itemmeta = apply_filters('woocommerce_hidden_order_itemmeta', '_fl_dir_payement_sid');
add_action('woocommerce_new_order_item', 'sb_packages_new_order_item_meta', 10, 3);
if (!function_exists('sb_packages_new_order_item_meta')) {
    function sb_packages_new_order_item_meta($item_id, $values, $cart_item_key) {
        $fl_dir_payement_sid = WC()-> session->get('_fl_dir_payement_sid');
        if (!empty($fl_dir_payement_sid)) {
            wc_add_order_item_meta($item_id, '_fl_dir_payement_sid', $fl_dir_payement_sid);
        }
    }
}

//auto complete service order
if ( ! function_exists( 'fl_woocommerce_auto_complete_order_service' ) )
{
    function fl_woocommerce_auto_complete_order_service( $order_id )
    {
        if ( ! $order_id ) {
            return;
        }
        if(fl_framework_get_options('service_amount_approval') == 1)
        {
            $order = wc_get_order( $order_id );
            $items = $order->get_items();

            $order_status  = $order->get_status();
            if( in_array( $order->get_status(), ['failed','pending'] ) )
            {
                foreach ( $items as $item )
                {
                    $product = wc_get_product( $item['product_id'] );

                    $prduct_type = $product->get_type();
                    if($prduct_type == 'service')
                    {
                        $order->update_status( 'pending' );
                    }
                }
            }
            else
            {
                $payment_methods = (fl_framework_get_options('exertio_service_payment_methods') == '' )? array():fl_framework_get_options('exertio_service_payment_methods');
                if(  in_array( $order->get_payment_method(), $payment_methods ) )
                {
                    foreach ( $items as $item )
                    {
                        $product = wc_get_product( $item['product_id'] );
                        $prduct_type = $product->get_type();
                        if($prduct_type == 'service')
                        {
                            $order->update_status( 'pending' );
                        }
                    }
                }
                else
                {
                    foreach ( $items as $item )
                    {
                        $product = wc_get_product( $item['product_id'] );

                        $prduct_type = $product->get_type();
                        if($prduct_type == 'service')
                        {
                            $order->update_status( 'completed' );
                        }
                    }
                }
            }
        }
    }
}
add_action( 'woocommerce_thankyou', 'fl_woocommerce_auto_complete_order_service' );
?>