<?php // Register post  type and taxonomy
add_action('init', 'fl_addons_themes_custom_types', 0);
function fl_addons_themes_custom_types() {
	 $args = array(
			'public' => true,
			'labels' => array(
							'name' => __('Addons', 'exertio_framework'),
							'singular_name' => __('Addons', 'exertio_framework'),
							'menu_name' => __('Addons', 'exertio_framework'),
							'name_admin_bar' => __('Addons', 'exertio_framework'),
							'add_new' => __('Add New Addon', 'exertio_framework'),
							'add_new_item' => __('Add New Addon', 'exertio_framework'),
							'new_item' => __('New Addons', 'exertio_framework'),
							'edit_item' => __('Edit Addons', 'exertio_framework'),
							'view_item' => __('View Addons', 'exertio_framework'),
							'all_items' => __('All Addons', 'exertio_framework'),
							'search_items' => __('Search Addons', 'exertio_framework'),
							'not_found' => __('No Addon Found.', 'exertio_framework'),
							),
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon'           => FL_PLUGIN_URL.'/images/adons.png',
			'rewrite' => array('with_front' => false, 'slug' => 'addons')
		);
	register_post_type('addons', $args);

	add_filter('manage_edit-addons_columns', 'addons_columns_id');
    add_action('manage_addons_posts_custom_column', 'addons_custom_columns', 5, 2);
 
 
	function addons_columns_id($defaults){
		unset($defaults['date']);

		$defaults['price'] =  __('Price', 'exertio_framework');
		$defaults['author'] =  __('Author', 'exertio_framework');
		$defaults['date'] =  __('Date', 'exertio_framework');

		return $defaults;
		
	}
	function addons_custom_columns($column_name, $id){
		if($column_name === 'price')
		{
			echo get_post_meta( $id, '_addon_price', true );  
		}
	}


	add_action( 'load-post.php', 'addons_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'addons_post_meta_boxes_setup' );
	
	
	function addons_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'addons_add_post_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'addons_save_post_class_meta', 10, 2 );
	  
	}
	
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function addons_add_post_meta_boxes() {
	
	  add_meta_box(
		'addon-post-class',      // Unique ID
		esc_html__( 'Add Addons Detail', 'exertio_framework' ),    // Title
		'addons_post_class_meta_box',   // Callback function
		'addons',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	
	function addons_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'addons_post_class_nonce' ); 
		//print_r($post);
		$post_id =  $post->ID;
		?>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Addons Price", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$addons_price ='';
				$addons_price = get_post_meta($post_id, '_addon_price', true);
			?>
            <input type="number" name="addons_price" value="<?php echo $addons_price; ?>" placeholder="<?php echo __( "Addons Price", "exertio_framework" ); ?>">
            <p><?php echo __( "Integer value only", "exertio_framework" ); ?></p>
            </div>
        </div>    
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Assign Addons", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            	<?php 
					$post_author_id = $post->post_author;
					$all_users = get_users();
					echo '<pre>';
					echo '</pre>';
					$users_list = '<select name="author_assign">';
					 foreach ( $all_users as $user ) {
						 if($user->ID == $post_author_id){ $selected = 'selected ="selected"';}else{$selected = ''; }
						 $users_list .= '<option value="'. esc_html( $user->ID ) .'" '.$selected.'>
                                '.  esc_html( $user->user_nicename ).' ( '.esc_html( $user->user_email ).')</option>';
                        $users_list.='</option>';
					}
					 $users_list.='</select>';
					 echo $users_list;
				?>
                <p><?php echo __( "If you select a user from this list it will assign this addons to the selected user.", 'exertio_framework' ); ?></p>
            </div>
        </div>
        
        
    <?php }

	
	/* Save the meta box's post metadata. */
	function addons_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['addons_post_class_nonce'] ) || !wp_verify_nonce( $_POST['addons_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		if(isset($_POST['addons_price']))
		{
			update_post_meta( $post_id, '_addon_price', $_POST['addons_price']);
		}
		update_post_meta( $post_id, '_addon_status', 'active');
		
		if(isset($_POST['author_assign']))
		{
			$auth_id= $_POST['author_assign'];
			$arg = array(
				'ID' => $post_id,
				'post_author' => $auth_id,
			);
			remove_action('save_post', 'addons_save_post_class_meta');
			wp_update_post( $arg );
		}
	}
}