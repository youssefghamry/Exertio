<?php // Register post  type and taxonomy
add_action('init', 'fl_payout_themes_custom_types', 0);
function fl_payout_themes_custom_types() {
	 $args = array(
			'public' => true,
			'labels' => array(
							'name' => __('Payouts', 'exertio_framework'),
							'singular_name' => __('Payouts', 'exertio_framework'),
							'menu_name' => __('Payouts', 'exertio_framework'),
							'name_admin_bar' => __('Payouts', 'exertio_framework'),
							'add_new' => __('Add New Payout', 'exertio_framework'),
							'add_new_item' => __('Add New Payout', 'exertio_framework'),
							'new_item' => __('New Payouts', 'exertio_framework'),
							'edit_item' => __('Edit Payouts', 'exertio_framework'),
							'view_item' => __('View Payouts', 'exertio_framework'),
							'all_items' => __('All Payouts', 'exertio_framework'),
							'search_items' => __('Search Payouts', 'exertio_framework'),
							'not_found' => __('No Payout Found.', 'exertio_framework'),
							),
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon'           => FL_PLUGIN_URL.'/images/wallet.png',
			'rewrite' => array('with_front' => false, 'slug' => 'payouts'),
			'capabilities' => array(
				'create_posts' => false,
			),
			'map_meta_cap' => true,
		);
	register_post_type('payouts', $args);


	add_filter('manage_edit-payouts_columns', 'payouts_columns_id');
    add_action('manage_payouts_posts_custom_column', 'payouts_custom_columns', 5, 2);
 
 
	function payouts_columns_id($defaults){
		unset($defaults['date']);

		$defaults['price'] =  __('Amount', 'exertio_framework');
		$defaults['payout_status'] =  __('Payout Status', 'exertio_framework');
		$defaults['author'] =  __('Author', 'exertio_framework');
		$defaults['date'] =  __('Date', 'exertio_framework');

		return $defaults;
		
	}
	function payouts_custom_columns($column_name, $id){
		if($column_name === 'payout_status')
		{
			echo get_post_meta($id,'_payout_status',true); 
		}
		if($column_name === 'price')
		{
			echo fl_price_separator(get_post_meta($id,'_payout_amount',true));
		}
	}


	add_action( 'load-post.php', 'payouts_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'payouts_post_meta_boxes_setup' );
	
	
	function payouts_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'payouts_add_post_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'payouts_save_post_class_meta', 10, 2 );
	  
	}
	
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function payouts_add_post_meta_boxes() {
	
	  add_meta_box(
		'payout-post-class',      // Unique ID
		esc_html__( 'Add payouts Detail', 'exertio_framework' ),    // Title
		'payouts_post_class_meta_box',   // Callback function
		'payouts',
		'normal',         // Context
		'default'         // Priority
	  );
	  add_meta_box(
        'payout_payment_methods',
        esc_html__( 'User Payout Methods', 'exertio_framework' ),
        'payouts_payment_methods_meta_box',
        'payouts',
        'side',
        'default'
        );
	}
	
	function payouts_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'payouts_post_class_nonce' ); 
		//print_r($post);
		$post_id =  $post->ID;
		$author_id = get_post_field( 'post_author', $post_id );
		?>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Payout Amount", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				echo fl_price_separator(get_post_meta($post_id,'_payout_amount',true));
			?>
            </div>
        </div> 
        
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Payout Status", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
				echo get_post_meta($post_id,'_payout_status',true); 
			?>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Payout Method", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
				echo get_post_meta($post_id,'_payout_method',true); 
			?>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark Payout as processed", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
            	<?php 
					$payout_status ='';
					$checked ='';
					$payout_status = get_post_meta($post_id, '_payout_status', true);
					
					if(isset($payout_status) && $payout_status == 'processed')
					{
						$checked =" checked='checked' disabled='disabled'";	
					}
				?>
            	<input type="checkbox" name="payout_status" <?php echo esc_attr($checked); ?> >
                <p><?php echo __( "Check this to mark it processed", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Private Note for this customer", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
            	<?php 
					$admin_note ='';
					$admin_note = get_user_meta($author_id, '_admin_note', true);
				?>
            	<textarea name="admin_note" rows="8" ><?php echo $admin_note; ?></textarea>
            <p><?php echo __( "This will be visible to admin only, against this user", "exertio_framework" ); ?></p>
            </div>
        </div>
        
    <?php }
	function payouts_payment_methods_meta_box( $post ) { ?>
	  <?php wp_nonce_field( basename( __FILE__ ), 'payouts_payment_methods_nonce' ); 
		//print_r($post);
		$post_id =  $post->ID;
		$author_id = get_post_field( 'post_author', $post_id );
		$fre_id = get_user_meta( $author_id, 'freelancer_id' , true );
		?>
        <div class="payout_methods">
        	<?php
				$default_payout ='';
				$default_payout = get_user_meta($author_id,'_default_payout_method', true);
			?>
            <ul class="default-method">
                <li>
                    <span><?php echo __( "preferred Payout Method:", 'exertio_framework' ); ?></span>
                    <p><?php echo esc_html($default_payout); ?></p>
                </li>
                <li>
                	<span><?php echo __( "User Profile:", 'exertio_framework' ); ?></span>
                    <p><a href="<?php echo get_permalink($fre_id); ?>" target="_blank"> <?php echo __( "View Profile", 'exertio_framework' ); ?> </a> </p>
                </li>
            </ul>
            <div class="tabs">
              <div class="tab">
                <input type="checkbox" id="chck1" <?php if($default_payout == 'paypal'){echo 'checked'; } ?>>
                <label class="tab-label" for="chck1"><?php echo __( "PayPal", 'exertio_framework' ); if($default_payout == 'papal'){ echo __( " ( preferred )", 'exertio_framework' ); } ?></label>
                <div class="tab-content">
                <ul>
                	<li>
                        <span><?php echo __( "Paypal Email:", 'exertio_framework' ); ?></span>
                        <?php
                        $decoded_paypal =array();
						$paypal_email = '';
                        $decoded_paypal = json_decode(get_user_meta($author_id,'_paypal_details', true));
                        //print_r($decoded_paypal);
						if(count($decoded_paypal) > 0)
						{
							foreach($decoded_paypal as $paypal_detail)
							{
								$paypal_email = $paypal_detail->paypal_email;
							}
						}
                        ?>
                        <p><?php echo esc_html($paypal_email); ?></p>
                    </li>
                </ul>
                </div>
              </div>
              <div class="tab">
                <input type="checkbox" id="chck2" <?php if($default_payout == 'bank'){echo 'checked'; } ?>>
                <label class="tab-label" for="chck2"><?php echo __( "Bank Transfer", 'exertio_framework' ); if($default_payout == 'bank'){ echo __( " (preferred)", 'exertio_framework' ); } ?> </label>
                <div class="tab-content">
                	<?php
						$decoded_bank = $bank_name = $bank_acc_number  = $bank_acc_name = $bank_routing_no = $bank_iban = $bank_swift = '';
						$decoded_bank = json_decode(get_user_meta($author_id,'_bank_account_details', true));
						if(!empty($decoded_bank))
						{
							foreach($decoded_bank as $bank_detail)
							{
								$bank_name = $bank_detail->bank_name;
								$bank_acc_number = $bank_detail->bank_acc_number;
								$bank_acc_name = $bank_detail->bank_acc_name;
								$bank_routing_no = $bank_detail->bank_routing_no;
								$bank_iban = $bank_detail->bank_iban;
								$bank_swift = $bank_detail->bank_swift;
							}
						}
					?>
                	<ul>
                        <li>
                            <span><?php echo __( "Bank Name:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($bank_name); ?></p>
                        </li>
                        <li>
                            <span><?php echo __( "Account Number:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($bank_acc_number); ?></p>
                        </li>
                        <li>
                            <span><?php echo __( "Account Name:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($bank_acc_name); ?></p>
                        </li>
                        <li>
                            <span><?php echo __( "Routing Number:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($bank_routing_no); ?></p>
                        </li>
                        <li>
                            <span><?php echo __( "IBAN:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($bank_iban); ?></p>
                        </li>
                        <li>
                            <span><?php echo __( "SWIFT:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($bank_swift); ?></p>
                        </li>
                    </ul>
                </div>
              </div>
              <div class="tab">
                <input type="checkbox" id="chck3" <?php if($default_payout == 'payoneer'){echo 'checked'; } ?>>
                <label class="tab-label" for="chck3"><?php echo __( "Payoneer", 'exertio_framework' ); if($default_payout == 'payoneer'){ echo __( " ( preferred )", 'exertio_framework' ); } ?></label>
                <div class="tab-content">
					<?php
                        $decoded_payoneer = $payoneer_acc_name = $payoneer_email = $payoneer_acc_country = '';
                        $decoded_payoneer = json_decode(get_user_meta($author_id,'_payoneer_details', true));
                        //print_r($decoded_payoneer);
						if(!empty($decoded_payoneer))
						{
							foreach($decoded_payoneer as $payoneer_detail)
							{
								$payoneer_acc_name = $payoneer_detail->payoneer_acc_name;
								$payoneer_email = $payoneer_detail->payoneer_email;
								$payoneer_acc_country = $payoneer_detail->payoneer_acc_country;
							}
						}
                        
                    ?>
                  <ul>
                        <li>
                            <span><?php echo __( "Account Name:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($payoneer_acc_name); ?></p>
                        </li>
                        <li>
                            <span><?php echo __( "Payoneer Email:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($payoneer_email); ?></p>
                        </li>
                        <li>
                            <span><?php echo __( "Country:", 'exertio_framework' ); ?></span>
                            <p><?php echo esc_html($payoneer_acc_country); ?></p>
                        </li>
                    </ul>
                </div>
              </div>
            </div>
        </div>
        <?php
	}
	
	
	/* Save the meta box's post metadata. */
	function payouts_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['payouts_post_class_nonce'] ) || !wp_verify_nonce( $_POST['payouts_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		$author_id = get_post_field( 'post_author', $post_id );
		if(isset($_POST['payout_status']))
		{
			do_action( 'exertio_notification_filter',array('post_id'=> $post_id,'n_type'=>'payout_processed','sender_id'=>'','receiver_id'=>$author_id,'sender_type'=>'admin') );
			update_post_meta($post_id,'_payout_status','processed');
		}
		else
		{
			update_post_meta($post_id,'_payout_status','pending');	
		}
		if(isset($_POST['admin_note']))
		{
			update_user_meta( $author_id, '_admin_note', $_POST['admin_note']);
		}
	}
}