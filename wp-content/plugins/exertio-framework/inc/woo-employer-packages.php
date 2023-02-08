<?php
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	// #1 Add New Product Type to Select Dropdown
	 
	add_filter( 'product_type_selector', 'exertio_add_employer_package_product_type' );
	 
	function exertio_add_employer_package_product_type( $types ){
		$types[ 'employer-packages' ] = 'Employers Packages';
		return $types;
	}
	
	// --------------------------
	// #2 Add New Product Type Class
	 
	add_action( 'init', 'exertio_create_employer_package_product_type' );
	 
	function exertio_create_employer_package_product_type(){
		class WC_Product_Custom_Employer_Package extends WC_Product {
		  public function get_type() {
			 return 'employer-packages';
		  }
		}
	}
	 
	// --------------------------
	// #3 Load New Product Type Class
	 
	add_filter( 'woocommerce_product_class', 'exertio_woocommerce_employer_package_product_class', 10, 2 );
	 
	function exertio_woocommerce_employer_package_product_class( $classname, $product_type ) {
		if ( $product_type == 'employer-packages' ) { 
			$classname = 'WC_Product_Custom_Employer_Package';
		}
		return $classname;
	}
	add_filter('woocommerce_product_data_tabs', 'remove_woo_product_data_tab_employers', 11, 1);
	function remove_woo_product_data_tab_employers($tabs){
		
		$tabs['attribute']['class'][] = 'hide_if_employer-packages';
		$tabs['shipping']['class'][] = 'hide_if_employer-packages';
		$tabs['linked_product']['class'][] = 'hide_if_employer-packages';
		$tabs['advanced']['class'][] = 'hide_if_employer-packages';
		
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
	
	//add_action('admin_print_scripts', 'exertio_employer_product_type');
	
	add_action( 'load-post.php', 'employer_packages_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'employer_packages_post_meta_boxes_setup' );
	
	
	function employer_packages_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'employer_packages_add_post_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'employer_packages_save_post_class_meta', 10, 2 );
	}
	
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function employer_packages_add_post_meta_boxes() {
	  add_meta_box(
		'employer-packages-post-class',
		esc_html__( 'Add Package Detail', 'exertio_framework' ),
		'employer_packages_post_class_meta_box',
		'product',
		'normal',
		'default' 
	  );
	}
	
	function employer_packages_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'employer_package_class_nonce' ); 
		//print_r($post);
		$post_id =  $post->ID;
		?>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Number of Simple Project Allowed", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$simple_projects ='';
				$simple_projects = get_post_meta($post_id, '_simple_projects', true);
			?>
            <input type="number" name="simple_projects" value="<?php echo $simple_projects; ?>" >
            <p><?php echo __( "Integer value only", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Simple Project Expiry", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$simple_project_expiry ='';
				$simple_project_expiry = get_post_meta($post_id, '_simple_project_expiry', true);
			?>
            <input type="number" name="simple_project_expiry" value="<?php echo $simple_project_expiry; ?>" >
            <p><?php echo __( "In days only", "exertio_framework" ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Number of Featured Projects Allowed", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$featured_projects ='';
				$featured_projects = get_post_meta($post_id, '_featured_projects', true);
			?>
            <input type="number" name="featured_projects" value="<?php echo $featured_projects; ?>" >
            <p><?php echo __( "Integer value only", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Featured Projects Expiry", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$featured_project_expiry ='';
				$featured_project_expiry = get_post_meta($post_id, '_featured_project_expiry', true);
			?>
            <input type="number" name="featured_project_expiry" value="<?php echo $featured_project_expiry; ?>" >
            <p><?php echo __( "In days only", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Expiry date for package", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_package_expiry ='';
				$employer_package_expiry = get_post_meta($post_id, '_employer_package_expiry', true);
			?>
            <input type="number" name="employer_package_expiry" value="<?php echo $employer_package_expiry; ?>" >
            <p><?php echo __( "Integer value only in days only", "exertio_framework" ); ?></p>
            </div>
        </div>
        
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Profile Featured", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_is_featured ='';
				$employer_is_featured = get_post_meta($post_id, '_employer_is_featured', true);
			?>
            	<select name="employer_is_featured">
                	<option value="" >  <?php echo __( "Select option", 'exertio_framework' ); ?></option>
                	<option value="1" <?php if($employer_is_featured == 1) { echo 'selected="selected"';}?>>  <?php echo __( "YES", 'exertio_framework' ); ?></option>
                    <option value="0" <?php if($employer_is_featured == 0) { echo 'selected="selected"';}?>>  <?php echo __( "NO", 'exertio_framework' ); ?></option>
                </select>
                <p><?php echo __( "This option will allow employers to be featured on website", 'exertio_framework' ); ?></p>
            </div>
        </div>
	
	<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark as free package", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$is_employer_pkg_free ='';
				$is_employer_pkg_free = get_post_meta($post_id, '_is_employer_pkg_free', true);
			?>
            	<select name="is_employer_pkg_free">
                	<option value="" >  <?php echo __( "Mark package free", 'exertio_framework' ); ?></option>
                	<option value="1" <?php if($is_employer_pkg_free == 1) { echo 'selected="selected"';}?>>  <?php echo __( "YES", 'exertio_framework' ); ?></option>
                    <option value="0" <?php if($is_employer_pkg_free == 0) { echo 'selected="selected"';}?>>  <?php echo __( "NO", 'exertio_framework' ); ?></option>
                </select>
                <p><?php echo __( "If you mark this package free then the user can purchase this package once. Most probably this will be assigned at the time of registration.", 'exertio_framework' ); ?></p>
            </div>
        </div>
        
        
    <?php }

	
	/* Save the meta box's post metadata. */
	function employer_packages_save_post_class_meta( $post_id, $post ) {
	
	  if ( !isset( $_POST['employer_package_class_nonce'] ) || !wp_verify_nonce( $_POST['employer_package_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  $post_type = get_post_type_object( $post->post_type );
	
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		if(isset($_POST['simple_projects']))
		{
			update_post_meta( $post_id, '_simple_projects', $_POST['simple_projects']);
		}
		if(isset($_POST['simple_project_expiry']))
		{
			update_post_meta( $post_id, '_simple_project_expiry', $_POST['simple_project_expiry']);
		}
		
		if(isset($_POST['featured_projects']))
		{
			update_post_meta( $post_id, '_featured_projects', $_POST['featured_projects']);
		}
		if(isset($_POST['featured_project_expiry']))
		{
			update_post_meta( $post_id, '_featured_project_expiry', $_POST['featured_project_expiry']);
		}
		if(isset($_POST['employer_package_expiry']))
		{
			update_post_meta( $post_id, '_employer_package_expiry', $_POST['employer_package_expiry']);
		}
		if(isset($_POST['employer_is_featured']))
		{
			update_post_meta( $post_id, '_employer_is_featured', $_POST['employer_is_featured']);
		}
		if(isset($_POST['is_employer_pkg_free']))
		{
			update_post_meta( $post_id, '_is_employer_pkg_free', $_POST['is_employer_pkg_free']);
		}
		
		
	}

	/*HIDE METABOXES IF EMPLPYER PACKAGE PRODUCT TYPE IS NOT SELECTED*/	
	function exertio_employer_package_custom_js() {
	
		if ( 'product' != get_post_type() ) :
			return;
		endif;
	
		?><script type='text/javascript'>
			jQuery( document ).ready( function() {
				
				jQuery('#general_product_data .pricing').addClass('show_if_employer-packages');
				jQuery('#product-type').trigger( 'change' );
	
				jQuery( '#employer-packages-post-class' ).hide();
				
				jQuery('#product-type').on('change', function()
				{
					if( jQuery(this).val() == 'employer-packages' )
					{
						jQuery( '#employer-packages-post-class' ).show();
					}
					else
					{
						jQuery( '#employer-packages-post-class' ).hide();;
					}
				});
				jQuery('#product-type').trigger( 'change' );
				
			});
		</script><?php
	}
	add_action( 'admin_footer', 'exertio_employer_package_custom_js' );
	
	// GET PACKAGES DETAIL
	if ( ! function_exists( 'exertio_employers_packages' ) )
	{
		function exertio_employers_packages()
		{
			$args	=	array(
			'post_type' => 'product',
			'tax_query' => array(
				array(	
				   'taxonomy' => 'product_type',
				   'field' => 'slug',
				   'terms' => 'employer-packages'
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
	add_action('wp_ajax_exertio_employer_package_callback', 'exertio_employer_package_callback');
	add_action( 'wp_ajax_nopriv_exertio_employer_package_callback', 'exertio_employer_package_callback' );
	if ( ! function_exists( 'exertio_employer_package_callback' ) )
	{ 
		function exertio_employer_package_callback()
		{
			check_ajax_referer( 'employer_package_nonce_value', 'security' );
			if( is_user_logged_in() )
			{
				$products_id = $_POST['product_id'];
				/*DEMO DISABLED*/
				exertio_demo_disable('json');
				$current_user_id = get_current_user_id();
				$employer_id = get_user_meta( $current_user_id, 'employer_id' , true );
				$is_employer_pkg_free = get_post_meta($products_id, '_is_employer_pkg_free', true);
				
				$purchased_free_pkg = get_post_meta($employer_id, '_purchased_free_pkg_emp', true);
				if(isset($purchased_free_pkg) && $purchased_free_pkg == 1 && $is_employer_pkg_free == 1)
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

if ( ! function_exists( 'exertio_employer_order_status_completed' ) )
{
	function exertio_employer_order_status_completed( $order_id )
	{
		
		$order = new WC_Order($order_id);
		$items = $order->get_items();
		$amount = $order->get_total();
		$user = $order->get_user();
		$user_id = $order->get_user_id();
		
		$employer_id = get_user_meta( $user_id, 'employer_id' , true );
		

		foreach ( $items as $item )
		{			
			$product_id = $item['product_id'];
			$product = wc_get_product( $product_id );

			$prduct_type = $product->get_type();


			if($prduct_type == 'employer-packages') 
			{
				/*STATEMENT HOOK*/
				do_action( 'exertio_transection_action',array('post_id'=> $order_id,'price'=>$amount,'t_type'=>'employer_package','t_status'=>'2', 'user_id'=> $user_id));
				
				$simple_projects = get_post_meta($product_id, '_simple_projects', true);
				$simple_project_expiry = get_post_meta($product_id, '_simple_project_expiry', true);
				$featured_projects = get_post_meta($product_id, '_featured_projects', true);
				$featured_project_expiry = get_post_meta($product_id, '_featured_project_expiry', true);
				$employer_package_expiry = get_post_meta($product_id, '_employer_package_expiry', true);
				$employer_is_featured = get_post_meta($product_id, '_employer_is_featured', true);

				$employer_package_expiry_date = Date('y:m:d', strtotime($employer_package_expiry. ' days'));


				$ext_simple_projects = get_post_meta($employer_id, '_simple_projects', true);
				if($ext_simple_projects == -1 || $simple_projects == -1)
				{
					$simple_projects = -1;
				}
				else if(isset($ext_simple_projects) && $ext_simple_projects > 0)
				{
					$simple_projects = $ext_simple_projects + $simple_projects;
				}

				$ext_simple_project_expiry = get_post_meta($employer_id, '_simple_project_expiry', true);
				if($ext_simple_project_expiry == -1 || $simple_project_expiry == -1)
				{
					$simple_project_expiry = -1;
				}
				else if(isset($ext_simple_project_expiry) && $ext_simple_project_expiry > 0)
				{
					$simple_project_expiry = $ext_simple_project_expiry + $simple_project_expiry;
				}

				$ext_featured_projects = get_post_meta($employer_id, '_featured_projects', true);
				if($ext_featured_projects == -1 || $featured_projects == -1)
				{
					$featured_projects = -1;
				}
				else if(isset($ext_featured_projects) && $ext_featured_projects > 0)
				{
					$featured_projects = $ext_featured_projects + $featured_projects;
				}

				$ext_featured_project_expiry = get_post_meta($employer_id, '_featured_project_expiry', true);
				if($ext_featured_project_expiry == -1 || $featured_project_expiry == -1)
				{
					$featured_project_expiry = -1;
				}
				else if(isset($ext_featured_project_expiry) && $ext_featured_project_expiry > 0)
				{
					$featured_project_expiry = $ext_featured_project_expiry + $featured_project_expiry;
				}

				$ext_employer_package_expiry = get_post_meta($employer_id, '_employer_package_expiry', true);
				if($ext_employer_package_expiry == -1 || $employer_package_expiry == -1)
				{
					$employer_package_expiry = -1;
				}
				else if(isset($ext_employer_package_expiry) && $ext_employer_package_expiry > 0)
				{
					$employer_package_expiry = $ext_employer_package_expiry + $employer_package_expiry;
				}

				$ext_employer_is_featured = get_post_meta($employer_id, '_employer_is_featured', true);
				if($ext_employer_is_featured == 1)
				{
					$employer_is_featured = $ext_employer_is_featured;
				}
				else if(isset($ext_employer_is_featured) && $ext_employer_is_featured == 0)
				{
					$employer_is_featured = $employer_is_featured;
				}



				$c_dATE = DATE("d-m-Y");
				$ext_employer_package_expiry_date = get_post_meta($employer_id, '_employer_package_expiry_date', true);
				if($employer_package_expiry == -1 || $ext_employer_package_expiry_date == -1)
				{
					$employer_package_expiry_date = -1;

				}
				else
				{
					if($ext_employer_package_expiry_date == "")
					{
						$employer_package_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $employer_package_expiry days"));
					}
					else
					{
						$employer_package_expiry_date = date('d-m-Y', strtotime($ext_employer_package_expiry_date. " + $employer_package_expiry days"));
					}
				}


				update_post_meta( $employer_id, '_simple_projects', $simple_projects);
				update_post_meta( $employer_id, '_simple_project_expiry', $simple_project_expiry);
				update_post_meta( $employer_id, '_featured_projects', $featured_projects);
				update_post_meta( $employer_id, '_featured_project_expiry', $featured_project_expiry);
				update_post_meta( $employer_id, '_employer_package_expiry', $employer_package_expiry);
				update_post_meta( $employer_id, '_employer_is_featured', $employer_is_featured);
				update_post_meta( $employer_id, '_employer_package_expiry_date', $employer_package_expiry_date);

				/*FOR THE FREE PACKAGE*/
				$is_employer_pkg_free = get_post_meta($product_id, '_is_employer_pkg_free', true);
				if(isset($is_employer_pkg_free) && $is_employer_pkg_free == 1)
				{
					update_post_meta( $employer_id, '_purchased_free_pkg_emp', 1);	
				}

			}

		}
	}
}
add_action( 'woocommerce_order_status_completed', 'exertio_employer_order_status_completed', 10, 1 );

if ( ! function_exists( 'exertio_employer_package_auto_complete_order' ) )
{
	function exertio_employer_package_auto_complete_order( $order_id )
	{ 
		if ( ! $order_id ) {
			return;
		}
		if(fl_framework_get_options('project_package_approval') == 1)
		{
			//$order = wc_get_order( $order_id );
			$order = new WC_Order($order_id);
			$items = $order->get_items();
	
			foreach ( $items as $item )
			{
				$product = wc_get_product( $item['product_id'] );
				$prduct_type = $product->get_type();
			  
			}
			if($prduct_type == 'employer-packages')
			{
				$order->update_status( 'completed' );
			}
		}
	}
}
add_action( 'woocommerce_thankyou', 'exertio_employer_package_auto_complete_order' );
	
	
	/*EMPLOYER PACKAGE ASSIGNMENT AT THE TIME OF REGISTERATION*/
	if ( ! function_exists( 'exertio_employer_pck_on_registeration' ) )
	{
		function exertio_employer_pck_on_registeration( $employer_id)
		{ 
			global $exertio_theme_options;
			if(isset($exertio_theme_options['employer_default_package_switch']) && $exertio_theme_options['employer_default_package_switch'] == 1 )
			{
				if(isset($exertio_theme_options['employer_default_packages']) && $exertio_theme_options['employer_default_packages'] != '' )
				{
					$product_id = $exertio_theme_options['employer_default_packages'];
					$product = wc_get_product( $product_id );
					if(!empty($product))
					{
						$simple_projects = get_post_meta($product_id, '_simple_projects', true);
						$simple_project_expiry = get_post_meta($product_id, '_simple_project_expiry', true);
						$featured_projects = get_post_meta($product_id, '_featured_projects', true);
						$featured_project_expiry = get_post_meta($product_id, '_featured_project_expiry', true);
						$employer_package_expiry = get_post_meta($product_id, '_employer_package_expiry', true);
						$employer_is_featured = get_post_meta($product_id, '_employer_is_featured', true);
						
						$employer_package_expiry_date = '';
						$c_dATE = DATE("d-m-Y");
						if($employer_package_expiry != -1)
						{
							$employer_package_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $employer_package_expiry days"));
						}
						else
						{
							$employer_package_expiry_date = -1;
						}

						update_post_meta( $employer_id, '_simple_projects', $simple_projects);
						update_post_meta( $employer_id, '_simple_project_expiry', $simple_project_expiry);
						update_post_meta( $employer_id, '_featured_projects', $featured_projects);
						update_post_meta( $employer_id, '_featured_project_expiry', $featured_project_expiry);
						update_post_meta( $employer_id, '_employer_package_expiry', $employer_package_expiry);
						update_post_meta( $employer_id, '_employer_is_featured', $employer_is_featured);
						update_post_meta( $employer_id, '_employer_package_expiry_date', $employer_package_expiry_date);
						
					}
				}
			}
		}
	}
	
}