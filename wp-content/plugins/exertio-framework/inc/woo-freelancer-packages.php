<?php
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	add_filter( 'product_type_selector', 'exertio_add_freelancer_package_product_type' );
	 
	function exertio_add_freelancer_package_product_type( $types ){
		$types[ 'freelancer-packages' ] = 'Freelancer Packages';
		return $types;
	}

	 
	add_action( 'init', 'exertio_create_freelancer_package_product_type' );
	 
	function exertio_create_freelancer_package_product_type(){
		class WC_Product_Custom_Freelancer_Package extends WC_Product {
		  public function get_type() {
			 return 'freelancer-packages';
		  }
		}
	}
	 

	 
	add_filter( 'woocommerce_product_class', 'exertio_woocommerce_freelancer_package_product_class', 10, 2 );
	 
	function exertio_woocommerce_freelancer_package_product_class( $classname, $product_type ) {
		if ( $product_type == 'freelancer-packages' ) { 
			$classname = 'WC_Product_Custom_Freelancer_Package';
		}
		return $classname;
	}
	add_filter('woocommerce_product_data_tabs', 'remove_woo_product_data_tab_freelancer', 11, 1);
	function remove_woo_product_data_tab_freelancer($tabs){
		
		$tabs['attribute']['class'][] = 'hide_if_freelancer-packages';
		$tabs['shipping']['class'][] = 'hide_if_freelancer-packages';
		$tabs['linked_product']['class'][] = 'hide_if_freelancer-packages';
		$tabs['advanced']['class'][] = 'hide_if_freelancer-packages';
		
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
	
	
	add_action( 'load-post.php', 'freelancer_packages_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'freelancer_packages_post_meta_boxes_setup' );
	
	
	function freelancer_packages_post_meta_boxes_setup() {

	  add_action( 'add_meta_boxes', 'freelancer_packages_add_post_meta_boxes' );
	  
	  add_action( 'save_post', 'freelancer_packages_save_post_class_meta', 10, 2 );
	  
	}
	
	function freelancer_packages_add_post_meta_boxes() {
	
	  add_meta_box(
		'freelancer-packages-post-class',
		esc_html__( 'Freelancer Package Detail', 'exertio_framework' ),
		'freelancer_packages_post_class_meta_box',
		'product',
		'normal',
		'default'
	  );
	}
	
	function freelancer_packages_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'freelancer_package_class_nonce' ); 
		$post_id =  $post->ID;
		?>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Number of Projects Credits", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$project_credits ='';
				$project_credits = get_post_meta($post_id, '_project_credits', true);
			?>
            <input type="number" name="project_credits" value="<?php echo $project_credits; ?>" >
            <p><?php echo __( "Project credits means on how many propsals a freelancer is allowed to send. Give -1 for unlimited", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Number of Services Allowed", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$simple_services ='';
				$simple_services = get_post_meta($post_id, '_simple_services', true);
			?>
            <input type="number" name="simple_services" value="<?php echo $simple_services; ?>" >
            <p><?php echo __( "Integer value only. Give -1 for unlimited services", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Service Expiry", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$simple_service_expiry ='';
				$simple_service_expiry = get_post_meta($post_id, '_simple_service_expiry', true);
			?>
            <input type="number" name="simple_service_expiry" value="<?php echo $simple_service_expiry; ?>" >
            <p><?php echo __( "In days only. Give -1 value if you want it to never expire", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Number of Featured Services Allowed", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$featured_services ='';
				$featured_services = get_post_meta($post_id, '_featured_services', true);
			?>
            <input type="number" name="featured_services" value="<?php echo $featured_services; ?>" >
            <p><?php echo __( "Integer value only. Give -1 for unlimited featured services", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Featured Services Expiry", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$featured_services_expiry ='';
				$featured_services_expiry = get_post_meta($post_id, '_featured_services_expiry', true);
			?>
            <input type="number" name="featured_services_expiry" value="<?php echo $featured_services_expiry; ?>" >
            <p><?php echo __( "In days only. Give -1 value if you want it to never expire", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Expiry Date for Package", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_package_expiry ='';
				$freelancer_package_expiry = get_post_meta($post_id, '_freelancer_package_expiry', true);
			?>
            <input type="number" name="freelancer_package_expiry" value="<?php echo $freelancer_package_expiry; ?>" >
            <p><?php echo __( "Integer value in days only. Give -1 value if you want it to never expire", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Renew Project/Service", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
                <?php
                $freelancer_listing_renew ='';
                $freelancer_listing_renew = get_post_meta($post_id, '_freelancer_listing_renew', true);
                ?>
                <input type="number" name="freelancer_listing_renew" value="<?php echo $freelancer_listing_renew; ?>" >
                <p><?php echo __( "Integer value in days only. Give -1 value if you want it to never expire", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Profile Featured", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_is_featured ='';
				$freelancer_is_featured = get_post_meta($post_id, '_freelancer_is_featured', true);
			?>
            	<select name="freelancer_is_featured">
                	<option value="" >  <?php echo __( "Select option", 'exertio_framework' ); ?></option>
                	<option value="1" <?php if($freelancer_is_featured == 1) { echo 'selected="selected"';}?>>  <?php echo __( "YES", 'exertio_framework' ); ?></option>
                    <option value="0" <?php if($freelancer_is_featured == 0) { echo 'selected="selected"';}?>>  <?php echo __( "NO", 'exertio_framework' ); ?></option>
                </select>
                <p><?php echo __( "This option will allow Freelancers to be featured on your website.", 'exertio_framework' ); ?></p>
            </div>
        </div>
		<div class="custom-row">
				<div class="col-3"><label><?php echo __( "Mark as free package", 'exertio_framework' ); ?></label></div>
				<div class="col-3">
				<?php 
					$is_freelancer_pkg_free ='';
					$is_freelancer_pkg_free = get_post_meta($post_id, '_is_freelancer_pkg_free', true);
				?>
					<select name="is_freelancer_pkg_free">
						<option value="" >  <?php echo __( "Mark package free", 'exertio_framework' ); ?></option>
						<option value="1" <?php if($is_freelancer_pkg_free == 1) { echo 'selected="selected"';}?>>  <?php echo __( "YES", 'exertio_framework' ); ?></option>
						<option value="0" <?php if($is_freelancer_pkg_free == 0) { echo 'selected="selected"';}?>>  <?php echo __( "NO", 'exertio_framework' ); ?></option>
					</select>
					<p><?php echo __( "If you mark this package free then the user can purchase this package once. Most probably this will be assigned at the time of registration.", 'exertio_framework' ); ?></p>
				</div>
			</div>
    <?php }

	
	function freelancer_packages_save_post_class_meta( $post_id, $post ) {
	
	  if ( !isset( $_POST['freelancer_package_class_nonce'] ) || !wp_verify_nonce( $_POST['freelancer_package_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  $post_type = get_post_type_object( $post->post_type );
	

	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		if(isset($_POST['project_credits']))
		{
			update_post_meta( $post_id, '_project_credits', $_POST['project_credits']);
		}
		if(isset($_POST['simple_services']))
		{
			update_post_meta( $post_id, '_simple_services', $_POST['simple_services']);
		}
		
		if(isset($_POST['simple_service_expiry']))
		{
			update_post_meta( $post_id, '_simple_service_expiry', $_POST['simple_service_expiry']);
		}
		
		if(isset($_POST['featured_services']))
		{
			update_post_meta( $post_id, '_featured_services', $_POST['featured_services']);
		}
		if(isset($_POST['featured_services_expiry']))
		{
			update_post_meta( $post_id, '_featured_services_expiry', $_POST['featured_services_expiry']);
		}
		if(isset($_POST['freelancer_package_expiry']))
		{
			update_post_meta( $post_id, '_freelancer_package_expiry', $_POST['freelancer_package_expiry']);
		}
        if(isset($_POST['freelancer_listing_renew']))
        {
            update_post_meta( $post_id, '_freelancer_listing_renew', $_POST['freelancer_listing_renew']);
        }
		if(isset($_POST['freelancer_is_featured']))
		{
			update_post_meta( $post_id, '_freelancer_is_featured', $_POST['freelancer_is_featured']);
		}
		if(isset($_POST['is_freelancer_pkg_free']))
		{
			update_post_meta( $post_id, '_is_freelancer_pkg_free', $_POST['is_freelancer_pkg_free']);
		}

	}

	/*HIDE METABOXES IF EMPLPYER PACKAGE PRODUCT TYPE IS NOT SELECTED*/	
	function exertio_freelancer_package_custom_js() {
	
		if ( 'product' != get_post_type() ) :
			return;
		endif;
	
		?><script type='text/javascript'>
			jQuery( document ).ready( function() {
				
				jQuery('#general_product_data .pricing').addClass('show_if_freelancer-packages');
				jQuery('#product-type').trigger( 'change' );
	
				jQuery( '#freelancer-packages-post-class' ).hide();
				
				jQuery('#product-type').on('change', function()
				{
					if( jQuery(this).val() == 'freelancer-packages' )
					{
						jQuery( '#freelancer-packages-post-class' ).show();
					}
					else
					{
						jQuery( '#freelancer-packages-post-class' ).hide();;
					}
				});
				jQuery('#product-type').trigger( 'change' );
				
			});
		</script><?php
	}
	add_action( 'admin_footer', 'exertio_freelancer_package_custom_js' );
	
	// GET PACKAGES DETAIL
	if ( ! function_exists( 'exertio_freelancer_packages' ) )
	{
		function exertio_freelancer_packages( $product_id = '')
		{
			$args	=	array(
			'post_type' => 'product',
			'tax_query' => array(
				array(	
				   'taxonomy' => 'product_type',
				   'field' => 'slug',
				   'terms' => 'freelancer-packages'
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
	
	/*EMPLOYER PACKAGE CALLBACK*/
	add_action('wp_ajax_exertio_freelancer_package_callback', 'exertio_freelancer_package_callback');
	add_action( 'wp_ajax_nopriv_exertio_freelancer_package_callback', 'exertio_freelancer_package_callback' );
	if ( ! function_exists( 'exertio_freelancer_package_callback' ) )
	{ 
		function exertio_freelancer_package_callback()
		{
			check_ajax_referer( 'freelancer_package_nonce_value', 'security' );
			/*DEMO DISABLED*/
			exertio_demo_disable('json');
			$products_id = $_POST['product_id'];
			if( is_user_logged_in() )
			{
				$current_user_id = get_current_user_id();
				$freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
				$is_freelancer_pkg_free = get_post_meta($products_id, '_is_freelancer_pkg_free', true);

				$purchased_free_pkg_freelancer = get_post_meta($freelancer_id, '_purchased_free_pkg_freelancer', true);
				if(isset($purchased_free_pkg_freelancer) && $purchased_free_pkg_freelancer == 1 && $is_freelancer_pkg_free == 1)
				{
					$return = array('message' => esc_html__( 'You can not purchase free package twice.', 'exertio_framework' ));
					wp_send_json_error($return);
					exit();
				}
				else
				{
					if ( class_exists( 'WooCommerce' ) )
					{
						global $woocommerce;
						$qty = 1;
						if( $woocommerce->cart->add_to_cart($products_id, $qty) )
						{
							$cart_url = wc_get_cart_url();
							$return = array('message' => esc_html__( 'Redirecting to cart page', 'exertio_framework' ),'cart_page' => $cart_url);
							wp_send_json_success($return);

						}
					}
					else {
						$return = array('message' => esc_html__( 'WooCommerce plugin is not active', 'exertio_framework' ));
						wp_send_json_error($return);
						exit();
					}
				}
			}
			else
			{
				$return = array('message' => esc_html__( 'Please login first', 'exertio_framework' ));
				wp_send_json_error($return);
				exit();
			}
		}
	}

	if ( ! function_exists( 'exertio_freelancer_order_status_completed' ) )
	{
		function exertio_freelancer_order_status_completed( $order_id )
		{
			$order = new WC_Order($order_id);
			$amount = $order->get_total();
			$items = $order->get_items();
			
			$user = $order->get_user();
			$user_id = $order->get_user_id();
			
			$freelancer_id = get_user_meta( $user_id, 'freelancer_id' , true );
			
			
			
			foreach ( $items as $item )
			{
				$product_id = $item['product_id'];
				$product = wc_get_product( $product_id );

				$prduct_type = $product->get_type();
	
				if($prduct_type == 'freelancer-packages') 
				{
					
					/*STATEMENT HOOK*/
					do_action( 'exertio_transection_action',array('post_id'=> $order_id,'price'=>$amount,'t_type'=>'freelancer_package','t_status'=>'2', 'user_id'=> $user_id));
					
					
					$project_credits = get_post_meta( $product_id, '_project_credits', true );
					$simple_services = get_post_meta($product_id, '_simple_services', true);
					$simple_services_expiry = get_post_meta($product_id, '_simple_service_expiry', true);
					$featured_services = get_post_meta($product_id, '_featured_services', true);
					$featured_services_expiry = get_post_meta($product_id, '_featured_services_expiry', true);
					$freelancer_package_expiry = get_post_meta($product_id, '_freelancer_package_expiry', true);
                    $freelancer_listing_renew = get_post_meta($product_id, '_freelancer_listing_renew', true);
					$freelancer_is_featured = get_post_meta($product_id, '_freelancer_is_featured', true);
					

					

					/*ADDING NEW PACKAGE IN OLD*/
					$ext_project_credits = get_post_meta( $freelancer_id, '_project_credits', true );
					if($ext_project_credits == -1 || $project_credits == -1)
					{
						$project_credits = -1;
					}
					else if(isset($ext_project_credits) && $ext_project_credits > 0)
					{
						$project_credits = $ext_project_credits + $project_credits;
					}

					$ext_simple_services = get_post_meta( $freelancer_id, '_simple_services', true );
					if($ext_simple_services == -1 || $simple_services == -1)
					{
						$simple_services = -1;
					}
					else if(isset($ext_simple_services) && $ext_simple_services > 0)
					{
						$simple_services = $ext_simple_services + $simple_services;
					}
					
					$ext_simple_services_expiry = get_post_meta( $freelancer_id, '_simple_service_expiry', true );
					if($ext_simple_services_expiry == -1 || $simple_services_expiry == -1)
					{
						$simple_services_expiry = -1;
					}
					else if(isset($ext_simple_services_expiry) && $ext_simple_services_expiry > 0)
					{
						$simple_services_expiry = $ext_simple_services_expiry + $simple_services_expiry;
					}
					
					$ext_featured_services = get_post_meta( $freelancer_id, '_featured_services', true );
					if($ext_featured_services == -1 || $featured_services == -1)
					{
						$featured_services = -1;
					}
					else if(isset($ext_featured_services) && $ext_featured_services > 0)
					{
						$featured_services = $ext_featured_services + $featured_services;
					}
					
					$ext_featured_services_expiry = get_post_meta( $freelancer_id, '_featured_services_expiry', true );
					if($ext_featured_services_expiry == -1 || $featured_services_expiry == -1)
					{
						$featured_services_expiry = -1;
					}
					else if(isset($ext_featured_services_expiry) && $ext_featured_services_expiry > 0)
					{
						$featured_services_expiry = $ext_featured_services_expiry + $featured_services_expiry;
					}
					
					$ext_freelancer_package_expiry = get_post_meta( $freelancer_id, '_freelancer_package_expiry', true );
					if($ext_freelancer_package_expiry == -1 || $freelancer_package_expiry == -1)
					{
						$freelancer_package_expiry = -1;
					}
					else if(isset($ext_freelancer_package_expiry) && $ext_freelancer_package_expiry > 0)
					{
						$freelancer_package_expiry = $ext_freelancer_package_expiry + $freelancer_package_expiry;
					}

                    $ext_freelancer_listing_renew = get_post_meta( $freelancer_id, '_freelancer_listing_renew', true );
                    if($ext_freelancer_listing_renew == -1 || $freelancer_listing_renew == -1)
                    {
                        $freelancer_listing_renew = -1;
                    }
                    else if(isset($ext_freelancer_listing_renew) && $ext_freelancer_listing_renew > 0)
                    {
                        $freelancer_listing_renew = $ext_freelancer_listing_renew + $freelancer_listing_renew;
                    }
					
					
					$ext_freelancer_is_featured = get_post_meta( $freelancer_id, '_freelancer_is_featured', true );
					if($ext_freelancer_is_featured == 1)
					{
						$freelancer_is_featured = $ext_freelancer_is_featured;
					}
					else if(isset($ext_freelancer_is_featured) && $ext_freelancer_is_featured == 0)
					{
						$freelancer_is_featured = $freelancer_is_featured;
					}
					
					$c_dATE = DATE("d-m-Y");
					$ext_freelancer_package_expiry_date = get_post_meta( $freelancer_id, '_freelancer_package_expiry_date', true );
					if($freelancer_package_expiry == -1 || $ext_freelancer_package_expiry_date == -1)
					{
						$freelancer_package_expiry_date = -1;
					}
					else
					{
						if($ext_freelancer_package_expiry_date == '')
						{
							$freelancer_package_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $freelancer_package_expiry days"));
						}
						else
						{
							$freelancer_package_expiry_date = date('d-m-Y', strtotime($ext_freelancer_package_expiry_date. " + $freelancer_package_expiry days"));
						}
						
					}
					

					update_post_meta( $freelancer_id, '_project_credits', $project_credits);
					update_post_meta( $freelancer_id, '_simple_services', $simple_services);
					update_post_meta( $freelancer_id, '_simple_service_expiry', $simple_services_expiry);
					update_post_meta( $freelancer_id, '_featured_services', $featured_services);
					update_post_meta( $freelancer_id, '_featured_services_expiry', $featured_services_expiry);
                    update_post_meta( $freelancer_id, '_freelancer_listing_renew', $freelancer_listing_renew);
					
					update_post_meta( $freelancer_id, '_freelancer_package_expiry', $freelancer_package_expiry);
					update_post_meta( $freelancer_id, '_freelancer_is_featured', $freelancer_is_featured);
					update_post_meta( $freelancer_id, '_freelancer_package_expiry_date', $freelancer_package_expiry_date);
					
					/*FOR THE FREE PACKAGE*/
					$is_freelancer_pkg_free = get_post_meta($product_id, '_is_freelancer_pkg_free', true);
					if(isset($is_freelancer_pkg_free) && $is_freelancer_pkg_free == 1)
					{
						update_post_meta( $freelancer_id, '_purchased_free_pkg_freelancer', 1);	
					}
				}
			}
			
		}
	}
	add_action( 'woocommerce_order_status_completed', 'exertio_freelancer_order_status_completed', 10, 1 );
	
	if ( ! function_exists( 'exertio_freelancer_package_auto_complete_order' ) )
	{
		function exertio_freelancer_package_auto_complete_order( $order_id )
		{ 
			if ( ! $order_id ) {
				return;
			}
			if(fl_framework_get_options('services_package_approval') == 1)
			{
				$order = new WC_Order($order_id);
				$items = $order->get_items();
		
				foreach ( $items as $item )
				{
					$product = wc_get_product( $item['product_id'] );

					$prduct_type = $product->get_type();
				  
				}
				if($prduct_type == 'freelancer-packages')
				{
					$order->update_status( 'completed' );
				}
			}
		}
	}
	add_action( 'woocommerce_thankyou', 'exertio_freelancer_package_auto_complete_order' );
	
	/*FREELANCER PACKAGE ASSIGNMENT AT THE TIME OF REGISTERATION*/
	if ( ! function_exists( 'exertio_freelancer_pck_on_registeration' ) )
	{
		function exertio_freelancer_pck_on_registeration( $freelancer_id)
		{ 
			global $exertio_theme_options;
			if(isset($exertio_theme_options['freelancer_default_package_switch']) && $exertio_theme_options['freelancer_default_package_switch'] == 1 )
			{
				if(isset($exertio_theme_options['freelancer_default_packages']) && $exertio_theme_options['freelancer_default_packages'] != '' )
				{
					$product_id = $exertio_theme_options['freelancer_default_packages'];
					$product = wc_get_product( $product_id );
					if(!empty($product))
					{
						$project_credits = get_post_meta( $product_id, '_project_credits', true );
						$simple_services = get_post_meta( $product_id, '_simple_services', true );
						$simple_services_expiry = get_post_meta( $product_id, '_simple_service_expiry', true );
						$featured_services = get_post_meta( $product_id, '_featured_services', true );
						$featured_services_expiry = get_post_meta( $product_id, '_featured_services_expiry', true );
						$freelancer_package_expiry = get_post_meta( $product_id, '_freelancer_package_expiry', true );
                        $freelancer_listing_renew = get_post_meta( $product_id, '_freelancer_listing_renew', true );
						$freelancer_is_featured = get_post_meta( $product_id, '_freelancer_is_featured', true );

						$c_dATE = DATE("d-m-Y");
						if($freelancer_package_expiry != -1)
						{
							$freelancer_package_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $freelancer_package_expiry days"));
						}
						else
						{
							$freelancer_package_expiry_date = -1;
						}

						update_post_meta( $freelancer_id, '_project_credits', $project_credits);
						update_post_meta( $freelancer_id, '_simple_services', $simple_services);
						update_post_meta( $freelancer_id, '_simple_service_expiry', $simple_services_expiry);
						update_post_meta( $freelancer_id, '_featured_services', $featured_services);
						update_post_meta( $freelancer_id, '_featured_services_expiry', $featured_services_expiry);
                        update_post_meta( $freelancer_id, '_freelancer_listing_renew', $freelancer_listing_renew);

						update_post_meta( $freelancer_id, '_freelancer_package_expiry', $freelancer_package_expiry);
						update_post_meta( $freelancer_id, '_freelancer_is_featured', $freelancer_is_featured);
						update_post_meta( $freelancer_id, '_freelancer_package_expiry_date', $freelancer_package_expiry_date);
						
					}
				}
			}
		}
	}
}