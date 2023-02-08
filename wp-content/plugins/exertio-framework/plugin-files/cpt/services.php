<?php // Register post  type and taxonomy
add_action('init', 'fl_services_themes_custom_types', 0);
function fl_services_themes_custom_types() {
	 $args = array(
			'public' => true,
			'labels' => array(
							'name' => __('Services', 'exertio_framework'),
							'singular_name' => __('Services', 'exertio_framework'),
							'menu_name' => __('Services', 'exertio_framework'),
							'name_admin_bar' => __('Services', 'exertio_framework'),
							'add_new' => __('Add New Service', 'exertio_framework'),
							'add_new_item' => __('Add New Service', 'exertio_framework'),
							'new_item' => __('New Services', 'exertio_framework'),
							'edit_item' => __('Edit Services', 'exertio_framework'),
							'view_item' => __('View Services', 'exertio_framework'),
							'all_items' => __('All Services', 'exertio_framework'),
							'search_items' => __('Search Services', 'exertio_framework'),
							'not_found' => __('No Service Found.', 'exertio_framework'),
							),
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon'           => FL_PLUGIN_URL.'/images/services.png',
			'rewrite' => array('with_front' => false, 'slug' => 'services')
		);
	register_post_type('services', $args);

	/*
	 * ADMIN COLUMN - HEADERS
	 */	
	//add_filter('manage_posts_columns', 'sevices_term_columns_id', 5);
	add_filter('manage_edit-services_columns', 'service_columns_id');
    add_action('manage_services_posts_custom_column', 'services_custom_columns', 5, 2);
 
 
	function service_columns_id($defaults){
		unset($defaults['taxonomy-services-english-level']);

		unset($defaults['date']);

		//$defaults['type'] =  __('Project Type', 'exertio_framework');
		$defaults['status'] =  __('Status', 'exertio_framework');
		$defaults['price'] =  __('Price', 'exertio_framework');
		$defaults['author'] =  __('Author', 'exertio_framework');
		$defaults['date'] =  __('Date', 'exertio_framework');

		return $defaults;
		
	}
	function services_custom_columns($column_name, $id){
		if($column_name === 'status')
		{
			echo get_post_status($id);
		}
		if($column_name === 'price')
		{
			echo get_post_meta( $id, '_service_price', true );  
		}
	}
	
	
	
	/*
	 * ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
	 * https://gist.github.com/906872
	 */
	//add_filter("manage_edit-projects_sortable_columns", 'service_sort');
	function service_sort($columns) {
		$custom = array(
			'service-categories' 	=> 'service-categories',
			'price' 		=> 'price',
			'author' 		=> 'author'
		);
		return wp_parse_args($custom, $columns);
	}
	
		/* PROJECT CATEGORY TAXONOMY */
		register_taxonomy('service-categories', array('services'), array(
			'hierarchical' => true,
			'show_ui' => true,
			'label' => __('Service Categories', 'exertio_framework'),
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'service-categories'),
		));
		
		
		
		$delivery_time_labels = array(
			'name'                       => __( 'Delivery Time', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Delivery Time', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Delivery Times', 'exertio_framework' ),
			'all_items'                  => __( 'All Delivery Times', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Delivery Time', 'exertio_framework' ),
			'update_item'                => __( 'Update Delivery Time', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Delivery Time', 'exertio_framework' ),
			'new_item_name'              => __( 'New Delivery Time Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Delivery Times with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Delivery Time', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Delivery Times', 'exertio_framework' ),
			'not_found'                  => __( 'No Delivery Time found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Delivery Time', 'exertio_framework' ),
		);
		register_taxonomy('delivery-time', array('services'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $delivery_time_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'delivery-time'),
		));
		
		$response_time_labels = array(
			'name'                       => __( 'Response Time', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Response Time', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Response Times', 'exertio_framework' ),
			'all_items'                  => __( 'All Response Times', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Response Time', 'exertio_framework' ),
			'update_item'                => __( 'Update Response Time', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Response Time', 'exertio_framework' ),
			'new_item_name'              => __( 'New Response Time Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Response Times with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Response Time', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Response Times', 'exertio_framework' ),
			'not_found'                  => __( 'No Response Time found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Response Time', 'exertio_framework' ),
		);
		register_taxonomy('response-time', array('services'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $response_time_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'response-time'),
		));
		
		$services_elglish_labels = array(
			'name'                       => __( 'English Level', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search English Level', 'exertio_framework' ),
			'popular_items'              => __( 'Popular English Level', 'exertio_framework' ),
			'all_items'                  => __( 'All English Levels', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit English Level', 'exertio_framework' ),
			'update_item'                => __( 'Update English Level', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New English Level', 'exertio_framework' ),
			'new_item_name'              => __( 'New English Level Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate English Level with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove English Level', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used English Levels', 'exertio_framework' ),
			'not_found'                  => __( 'No English Level found.', 'exertio_framework' ),
			'menu_name'                  => __( 'English Level', 'exertio_framework' ),
		);
		register_taxonomy('services-english-level', array('services'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $services_elglish_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'services-english-level'),
		));
		
		
		
		$locations_labels = array(
			'name'                       => __( 'Locations', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Locations', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Locations', 'exertio_framework' ),
			'all_items'                  => __( 'All Locations', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Location', 'exertio_framework' ),
			'update_item'                => __( 'Update Location', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Location', 'exertio_framework' ),
			'new_item_name'              => __( 'New Locations Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Locations with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Locations', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Locations', 'exertio_framework' ),
			'not_found'                  => __( 'No Location found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Locations', 'exertio_framework' ),
		);
		register_taxonomy('services-locations', array('services'), array(
			'hierarchical' => true,
			'show_ui' => true,
			'labels' => $locations_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'services-locations'),
		));
		
		
		

		
		/* CATEGORY IMAGES */
		
		if( ! class_exists( 'category_Taxonomy_Images' ) ) {
			class category_Taxonomy_Images {
			
			public function __construct() {
			 //
			}
			
			/**
			 * Initialize the class and start calling our hooks and filters
			 */
			 public function init() {
			 // Image actions
			 add_action( 'service-categories_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
			 add_action( 'created_service-categories', array( $this, 'save_category_image' ), 10, 2 );
			 add_action( 'service-categories_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
			 add_action( 'edited_service-categories', array( $this, 'updated_category_image' ), 10, 2 );
			 
			 add_action( 'admin_enqueue_scripts', array( $this, 'service_categories_load_media' ) );
			 add_action( 'admin_footer', array( $this, 'service_categories_add_script' ) );
			 
			}
			
			public function service_categories_load_media() {
			
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'service-categories' ) {
			   return;
			 }
			 wp_enqueue_media();
			}
			
			/**
			* Add a form field in the new category page
			* @since 1.0.0
			*/
			
			public function add_category_image( $taxonomy ) { ?>
			 <div class="form-field term-group">
			   <label for="categories-taxonomy-image-id"><?php __('Icon', 'exertio_framework'); ?></label>
			   <input type="hidden" id="categories-taxonomy-image-id" name="categories-taxonomy-image-id" class="custom_media_url" value="">
			   <div id="categories-image-wrapper"></div>
			   <p>
				 <input type="button" class="button button-secondary categories_tax_media_button" id="categories_tax_media_button" name="categories_tax_media_button" value="<?php echo __('Add Icon', 'exertio_framework'); ?>" />
				 <input type="button" class="button button-secondary categories_tax_media_remove" id="categories_tax_media_remove" name="categories_tax_media_remove" value="<?php echo __('Remove Icon', 'exertio_framework'); ?>" />
			   </p>
			 </div>
			<?php }
			
			/**
			* Save the form field
			* @since 1.0.0
			*/
			public function save_category_image( $term_id, $tt_id ) {
			 if( isset( $_POST['categories-taxonomy-image-id'] ) && '' !== $_POST['categories-taxonomy-image-id'] ){
			   add_term_meta( $term_id, 'categories-taxonomy-image-id', absint( $_POST['categories-taxonomy-image-id'] ), true );
			 }
			}
			
			/**
			 * Edit the form field
			 * @since 1.0.0
			 */
			public function update_category_image( $term, $taxonomy ) { ?>
			  <tr class="form-field term-group-wrap">
				<th scope="row">
				  <label for="categories-taxonomy-image-id"><?php echo __('Icon', 'exertio_framework'); ?></label>
				</th>
				<td>
				  <?php $image_id = get_term_meta( $term->term_id, 'categories-taxonomy-image-id', true ); ?>
				  <input type="hidden" id="categories-taxonomy-image-id" name="categories-taxonomy-image-id" value="<?php echo esc_attr( $image_id ); ?>">
				  <div id="categories-image-wrapper">
					<?php if( $image_id ) { ?>
					  <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
					<?php } ?>
				  </div>
				  <p>
					<input type="button" class="button button-secondary categories_tax_media_button" id="categories_tax_media_button" name="categories_tax_media_button" value="<?php echo __('Add Icon', 'exertio_framework'); ?>" />
					<input type="button" class="button button-secondary categories_tax_media_remove" id="categories_tax_media_remove" name="categories_tax_media_remove" value="<?php echo __('Remove Icon', 'exertio_framework'); ?>" />
				  </p>
				</td>
			  </tr>
			<?php }
			
			/**
			* Update the form field value
			* @since 1.0.0
			*/
			public function updated_category_image( $term_id, $tt_id ) {
			 if( isset( $_POST['categories-taxonomy-image-id'] ) && '' !== $_POST['categories-taxonomy-image-id'] ){
			   update_term_meta( $term_id, 'categories-taxonomy-image-id', absint( $_POST['categories-taxonomy-image-id'] ) );
			 } else {
			   update_term_meta( $term_id, 'categories-taxonomy-image-id', '' );
			 }
			}
			
			/**
			* Enqueue styles and scripts
			* @since 1.0.0
			*/
			public function service_categories_add_script() {
				
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'service-categories' ) {
			   return;
			 } 
			 
			 ?>
			 <script> 
			 
			 	
			 	jQuery(document).ready( function($) {
			   _wpMediaViewsL10n.insertIntoPost = '<?php echo __('Insert', 'exertio_framework'); ?>';
			   function ct_media_upload(button_class) {
				 var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
				 $('body').on('click', button_class, function(e) {
					 
				   var button_id = '#'+$(this).attr('id');
				   
				   var send_attachment_bkp = wp.media.editor.send.attachment;
				   var button = $(button_id);
				   _custom_media = true;
				   wp.media.editor.send.attachment = function(props, attachment){
					 if( _custom_media ) {
					   $('#categories-taxonomy-image-id').val(attachment.id);
					   $('#categories-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
					   $( '#categories-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
					 } else {
					   return _orig_send_attachment.apply( button_id, [props, attachment] );
					 }
				   }
				   wp.media.editor.open(button); return false;
				 });
			   }
			   ct_media_upload('.categories_tax_media_button.button');
			   $('body').on('click','.categories_tax_media_remove',function(){
				 $('#categories-taxonomy-image-id').val('');
				 $('#categories-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
			   });
			   
			   $(document).ajaxComplete(function(event, xhr, settings) {
				 var queryStringArr = settings.data.split('&');
				 if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
				   var xml = xhr.responseXML;
				   $response = $(xml).find('term_id').text();
				   if($response!=""){
					 // Clear the thumb image
					 $('#categories-image-wrapper').html('');
				   }
				  }
				});
			  });
			</script>
			<?php }
			}
			$category_Taxonomy_Images = new category_Taxonomy_Images();
			$category_Taxonomy_Images->init(); 
		}
	
		
		if( ! class_exists( 'service_locations_Taxonomy_Images' ) ) {
			class service_locations_Taxonomy_Images {
			
			public function __construct() {
			 //
			}
			
			/**
			 * Initialize the class and start calling our hooks and filters
			 */
			 public function init() {
			 // Image actions
			 add_action( 'services-locations_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
			 add_action( 'created_services-locations', array( $this, 'save_category_image' ), 10, 2 );
			 add_action( 'services-locations_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
			 add_action( 'edited_services-locations', array( $this, 'updated_category_image' ), 10, 2 );
			 add_action( 'admin_enqueue_scripts', array( $this, 'service_load_media' ) );
			 add_action( 'admin_footer', array( $this, 'service_add_script' ) );
			}
			
			public function service_load_media() {
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'services-locations' ) {
			   return;
			 }
			 wp_enqueue_media();
			}
			
			/**
			* Add a form field in the new category page
			* @since 1.0.0
			*/
			
			public function add_category_image( $taxonomy ) { ?>
			 <div class="form-field term-group">
			   <label for="locations-taxonomy-image-id"><?php __('Image', 'exertio_framework'); ?></label>
			   <input type="hidden" id="locations-taxonomy-image-id" name="locations-taxonomy-image-id" class="custom_media_url" value="">
			   <div id="locations-image-wrapper"></div>
			   <p>
				 <input type="button" class="button button-secondary locations_tax_media_button" id="locations_tax_media_button" name="locations_tax_media_button" value="<?php echo __('Add Image', 'exertio_framework'); ?>" />
				 <input type="button" class="button button-secondary locations_tax_media_remove" id="locations_tax_media_remove" name="locations_tax_media_remove" value="<?php echo __('Remove Image', 'exertio_framework'); ?>" />
			   </p>
			 </div>
			<?php }
			
			/**
			* Save the form field
			* @since 1.0.0
			*/
			public function save_category_image( $term_id, $tt_id ) {
			 if( isset( $_POST['locations-taxonomy-image-id'] ) && '' !== $_POST['locations-taxonomy-image-id'] ){
			   add_term_meta( $term_id, 'locations-taxonomy-image-id', absint( $_POST['locations-taxonomy-image-id'] ), true );
			 }
			}
			
			/**
			 * Edit the form field
			 * @since 1.0.0
			 */
			public function update_category_image( $term, $taxonomy ) { ?>
			  <tr class="form-field term-group-wrap">
				<th scope="row">
				  <label for="locations-taxonomy-image-id"><?php echo __('Image', 'exertio_framework'); ?></label>
				</th>
				<td>
				  <?php $image_id = get_term_meta( $term->term_id, 'locations-taxonomy-image-id', true ); ?>
				  <input type="hidden" id="locations-taxonomy-image-id" name="locations-taxonomy-image-id" value="<?php echo esc_attr( $image_id ); ?>">
				  <div id="locations-image-wrapper">
					<?php if( $image_id ) { ?>
					  <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
					<?php } ?>
				  </div>
				  <p>
					<input type="button" class="button button-secondary locations_tax_media_button" id="locations_tax_media_button" name="locations_tax_media_button" value="<?php echo __('Add Image', 'exertio_framework'); ?>" />
					<input type="button" class="button button-secondary locations_tax_media_remove" id="locations_tax_media_remove" name="locations_tax_media_remove" value="<?php echo __('Remove Image', 'exertio_framework'); ?>" />
				  </p>
				</td>
			  </tr>
			<?php }
			
			/**
			* Update the form field value
			* @since 1.0.0
			*/
			public function updated_category_image( $term_id, $tt_id ) {
			 if( isset( $_POST['locations-taxonomy-image-id'] ) && '' !== $_POST['locations-taxonomy-image-id'] ){
			   update_term_meta( $term_id, 'locations-taxonomy-image-id', absint( $_POST['locations-taxonomy-image-id'] ) );
			 } else {
			   update_term_meta( $term_id, 'locations-taxonomy-image-id', '' );
			 }
			}
			
			/**
			* Enqueue styles and scripts
			* @since 1.0.0
			*/
			public function service_add_script() {
			
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'services-locations' ) {
			   return;
			 } ?>
			 <script> jQuery(document).ready( function($) {
			   _wpMediaViewsL10n.insertIntoPost = '<?php echo __('Insert', 'exertio_framework'); ?>';
			   function ct_media_upload(button_class) {
				 var _custom_media = true, _orig_send_attachment = wp.media.editor.send.attachment;
				 $('body').on('click', button_class, function(e) {
				   var button_id = '#'+$(this).attr('id');
				   var send_attachment_bkp = wp.media.editor.send.attachment;
				   var button = $(button_id);
				   _custom_media = true;
				   wp.media.editor.send.attachment = function(props, attachment){
					 if( _custom_media ) {
					   $('#locations-taxonomy-image-id').val(attachment.id);
					   $('#locations-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
					   $( '#locations-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
					 } else {
					   return _orig_send_attachment.apply( button_id, [props, attachment] );
					 }
				   }
				   wp.media.editor.open(button); return false;
				 });
			   }
			   ct_media_upload('.locations_tax_media_button.button');
			   $('body').on('click','.locations_tax_media_remove',function(){
				 $('#locations-taxonomy-image-id').val('');
				 $('#locations-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
			   });
			   
			   $(document).ajaxComplete(function(event, xhr, settings) {
				 var queryStringArr = settings.data.split('&');
				 if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
				   var xml = xhr.responseXML;
				   $response = $(xml).find('term_id').text();
				   if($response!=""){
					 // Clear the thumb image
					 $('#locations-image-wrapper').html('');
				   }
				  }
				});
			  });
			</script>
			<?php }
			}
			$service_locations_Taxonomy_Images = new service_locations_Taxonomy_Images();
			$service_locations_Taxonomy_Images->init(); 
		}

	add_action( 'load-post.php', 'services_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'services_post_meta_boxes_setup' );
	
	
	function services_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'services_add_post_meta_boxes' );
	  add_action( 'add_meta_boxes', 'abc',999 );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'services_save_post_class_meta', 10, 2 );
	  
	}
	
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function services_add_post_meta_boxes() {
	
	  add_meta_box(
		'service-post-class',      // Unique ID
		esc_html__( 'Add Service Detail', 'exertio_framework' ),    // Title
		'services_post_class_meta_box',   // Callback function
		'services',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	function abc()
	{
		add_meta_box(
		'services-addons-post-class',      // Unique ID
		esc_html__( 'Service Addons', 'exertio_framework' ),    // Title
		'services_addons_post_class_meta_box',   // Callback function
		'services',
		'side',         // Context
		'default'         // Priority
	  );	
	}
	
	function services_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'service_post_class_nonce' ); 
		$post_id =  $post->ID;
		$custom_field_dispaly = 'style=display:none;';
		if(class_exists('ACF'))
		{
			$selected_custom_data = exertio_services_fields_by_listing_id($post_id);
			if(!empty($selected_custom_data) && is_array($selected_custom_data))
			{
				$custom_field_dispaly = '';
				if(!empty($selected_custom_data)) { $custom_field_dispaly = ''; }
				//$custom_field_dispaly = '';
				$fetch_custom_data = $selected_custom_data;
			}
		}
		?>
        <div class="custom-row">
            <div class="col-3"> <label><?php echo __( "Service Category", 'exertio_framework' ); ?></label> </div>
            <div class="col-3">
            <ul>
            <?php
            $categories_taxonomies = exertio_get_terms('service-categories');
            if ( !empty($categories_taxonomies) )
            {
				echo '<select name="service_category" class="form-control general_select" id="exertio_serivces_cat_parent">'.get_hierarchical_terms('service-categories', '_service_category', $post_id ).'</select>';
            }
            else
            {
                echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </ul>
                
            </div>
        </div>
		<div class="custom-row additional-fields" <?php echo esc_attr($custom_field_dispaly); ?> >
            <div class="col-3"> <label><?php echo __( "Custom Fields", 'exertio_framework' ); ?></label> </div>
            <div class="col-3">
				<div class="additional-fields-container">
					<?php
						if(is_array($selected_custom_data) && !empty($selected_custom_data)) {
							if ($post_id != '' && class_exists('ACF')) {
								$custom_fields_html = apply_filters('exertio_services_acf_frontend_html', '', $selected_custom_data);
								echo $custom_fields_html;
							}
						}
					?>
				</div>
			</div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label> <?php echo __( "Response Time ", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
				<?php
                $time_taxonomies = exertio_get_terms('response-time');
                if ( !empty($time_taxonomies) )
                {
                    $response_time = get_post_meta($post_id, '_response_time', true);
                    $time = '<select name="response_time">';
                    $time .= '<option value=""> '. __( "Select Response Time", "exertio_framework" ) .'</option>';
                    foreach( $time_taxonomies as $time_taxonomy ) {
                        if($time_taxonomy->term_id == $response_time){ $selected = 'selected ="selected"';}else{$selected = ''; }
                        if( $time_taxonomy->parent == 0 ) {
                             $time .= '<option value="'. esc_html( $time_taxonomy->term_id ) .'" '.$selected.'>
                                    '. esc_html( $time_taxonomy->name ) .'</option>';
                        }
                    }
                    $time.='</select>';
                    echo $time;
                }
                else
                {
                    echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
                }
                ?>
                <p> <?php echo __( "Select user response time ", 'exertio_framework' ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Delivery Time ", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $delivery_time_taxonomies = exertio_get_terms('delivery-time'); 
        //print_r($delivery_time_taxonomies);
            if ( !empty($delivery_time_taxonomies) )
            {
				$delivery_time = get_post_meta($post_id, '_delivery_time', true);
                $del_time = '<select name="delivery_time">';
				$del_time .= '<option value=""> '. __( "Service Delivery Time", "exertio_framework" ) .'</option>';
                foreach( $delivery_time_taxonomies as $delivery_time_taxonomy ) {
					if($delivery_time_taxonomy->term_id == $delivery_time){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $delivery_time_taxonomy->parent == 0 ) {
                         $del_time .= '<option value="'. esc_attr( $delivery_time_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $delivery_time_taxonomy->name ) .'</option>';
                        $del_time.='</option>';
                    }
                }
                $del_time.='</select>';
                echo $del_time;
            }
            else
            {
                echo __( "No values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Service Price", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$service_price ='';
				$service_price = get_post_meta($post_id, '_service_price', true);
			?>
            <input type="number" name="service_price" value="<?php echo $service_price; ?>" placeholder="<?php echo __( "Service Price", "exertio_framework" ); ?>">
            <p><?php echo __( "Integer value only", "exertio_framework" ); ?></p>
            </div>
        </div> 
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "English Level", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $service_eng_level_taxonomies = exertio_get_terms('services-english-level');
        
            if ( !empty($service_eng_level_taxonomies) )
            {
				$service_eng_level = get_post_meta($post_id, '_service_eng_level', true);
                $eng_level = '<select name="service_english_level">';
				$eng_level .= '<option value=""> '. __( "Select English Level", "exertio_framework" ) .'</option>';
                foreach( $service_eng_level_taxonomies as $service_eng_level_taxonomy ) {
					if($service_eng_level_taxonomy->term_id == $service_eng_level){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $service_eng_level_taxonomy->parent == 0 ) {
                        //$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
                         $eng_level .= '<option value="'. esc_attr( $service_eng_level_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $service_eng_level_taxonomy->name ) .'</option>';
                        $eng_level.='</option>';
                    }
                }
                $eng_level.='</select>';
                echo $eng_level;
            }
            else
            {
                echo __( "No values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Video URLs", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
                <div class="field_wrapper" id="sortable">
                    <?php
						$service_youtube_urls ='';
						$service_youtube_urls = get_post_meta($post_id, '_service_youtube_urls', true);
						
						if(!empty($service_youtube_urls))
						{
							$urls = json_decode($service_youtube_urls);
							foreach($urls as $url)
							{
								?>
                                	<div class="ui-state-default">
                                    	<span class="dashicons dashicons-move"></span>
                                        <input type="url" name="video_urls[]" value="<?php echo esc_url($url); ?>" />
                                        <a href="javascript:void(0);" class="remove_button"><img src="<?php echo FL_PLUGIN_URL;?>/images/error.png" >	</a>
                                    </div>
                                <?php
							}
						}
						else
						{
							?>
                            	<div class="ui-state-default">
                                	<span class="dashicons dashicons-move"></span>
                                    <input type="url" name="video_urls[]" value="" />
                                </div>
                            <?php 	
						}
					?>
                    
                </div>
                <a href="javascript:void(0);" class="add_button button button-primary button-large" title="Add field">
					<?php echo __( "Add More", 'exertio_framework' ); ?>
                </a>
                <p><?php echo __( "Please provide YouTube video URLs Only.", "exertio_framework" ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Location", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $location_taxonomies = exertio_get_terms('services-locations'); 
            if ( !empty($location_taxonomies) )
            {
				echo '<select name="service_location" class="form-control general_select">'.get_hierarchical_terms('services-locations','_service_location', $post_id ).'</select>';
            }
            else
            {
                echo __( "No values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Attachments", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                 <div id="freelance_gall_render_html">
                    <ul class="freelance_gallery">
						<?php
                        $project_attachment_ids = get_post_meta($post_id, '_service_attachment_ids', true);
                        if(isset($project_attachment_ids) && $project_attachment_ids !='')
                        {
                        $attachment_ids_array = explode(",",$project_attachment_ids);
                        
                        ?>
                                <?php
                                    foreach($attachment_ids_array as $data)
                                    {
                                        $attachment_data = wp_get_attachment_url( $data );
										$file_type = wp_check_filetype($attachment_data);

										if($file_type['ext'] =='jpg' || $file_type['ext'] == 'jpeg' || $file_type['ext'] == 'png' )
										{
											echo '<li id="data-'.$data.'"><a href="javascript:void(0)" class="close-thik" id="'.$data.'"></a><img src="'.$attachment_data.'" alt="'.__( "attachment", 'exertio_framework' ).'"></li>';
										}
										else
										{
                                        echo '<li id="data-'.$data.'"><a href="javascript:void(0)" class="close-thik" id="'.$data.'"></a><img src="'.includes_url().'/images/media/document.png" alt="'.__( "attachment", 'exertio_framework' ).'"></li>';
										}
                                        //echo $attachment_data;
                                    }
                                ?>
                               
                        <?php
                        }
                        ?> 
                    </ul>
                 </div> 
                 <button id="attachment_btn" type="button" class="button button-primary button-large">  <?php echo __( "Select Attachments", 'exertio_framework' ); ?> </button>
                 <input type="hidden" name="attachment_ids" value="<?php echo $project_attachment_ids; ?>" id="attachments_ids">
                 <p><?php echo __( "If you are selected multiple images or want to add more images you must need to press Ctrl button on your keyboard.", 'exertio_framework' ); ?></p>

            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Want to show attachments", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$service_attachment_show ='';
				$service_attachment_show = get_post_meta($post_id, '_service_attachment_show', true);
			?>
            <select name="is_show_service_attachments">
                <option value="yes" <?php if(isset($service_attachment_show) && $service_attachment_show == 'yes' ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Yes", 'exertio_framework' ); ?></option>
                <option value="no" <?php if(isset($service_attachment_show) && $service_attachment_show == 'no' ){ echo 'selected ="selected"'; } ?>> <?php echo __( "No", 'exertio_framework' ); ?></option>
            </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark Service Featured", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$service_featured ='';
				$service_featured = get_post_meta($post_id, '_service_is_featured', true);
			?>
            <select name="service_featured">
                <option value="0" <?php if(isset($service_featured) && $service_featured == 0 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Simple", 'exertio_framework' ); ?></option>
                <option value="1" <?php if(isset($service_featured) && $service_featured == 1 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Featured", 'exertio_framework' ); ?></option>
            </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Assign Service", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            	<?php 
					$post_author_id = $post->post_author;
					$all_users = get_users();
					echo '<pre>';
					//print_r($all_users);
					echo '</pre>';
					$users_list = '<select name="author_assign">';
					 foreach ( $all_users as $user ) {
						 if($user->ID == $post_author_id){ $selected = 'selected ="selected"';}else{$selected = ''; }
						//echo '<span>' . esc_html( $user->user_email ) . '</span>';
						 $users_list .= '<option value="'. esc_html( $user->ID ) .'" '.$selected.'>
                                '.  esc_html( $user->user_nicename ).' ( '.esc_html( $user->user_email ).')</option>';
                        $users_list.='</option>';
					}
					 $users_list.='</select>';
					 echo $users_list;
				?>
                <p><?php echo __( "If you select a user from this list it will assign this service to the selected user.", 'exertio_framework' ); ?></p>
            </div>
        </div>
        
        
    <?php }

	function services_addons_post_class_meta_box( $post ) { ?>
		
	  <?php 
	  wp_nonce_field( basename( __FILE__ ), 'services_addons_post_class_nonce' ); 
		$post_id =  $post->ID;
		global $exertio_theme_options;
		
		?>
        <div class="custom-row">
            <div class="col-12">
            	<?php
				$current_id = get_current_user_id();
					//echo $post->post_author;
					//print_r($post);
					$args = array( 
											'author__in' => array( $post->post_author ) ,
											'post_type' =>'addons',
											'post_status'     => 'publish',
											'posts_per_page'=>-1,
											'order'=> 'DESC',
											'orderby' => 'ID'													
											);					
					$adons = get_posts($args);	
					
					foreach ( $adons as $post ) {
						//print_r($post);
					   $pid =  $post->ID;
					   $slected_id ='';
					   $slected_id = json_decode(get_post_meta( $post_id, '_services_addon', true ));
					   $selected ='';
					   if($slected_id != '')
					   {
						   if(in_array($pid, $slected_id) )
						   {
								$selected ='checked="checked"';   
							}
					   }
					   ?>
                           <div class="addons-services">
                            	<span><input type="checkbox" name="services_addon[]" value="<?php echo esc_attr( $pid ) ?>" <?php echo esc_attr($selected) ?>></span>
                                <label><?php echo esc_html(get_the_title($pid)).'<span>'.$exertio_theme_options['fl_currency'].''.get_post_meta( $pid, '_addon_price', true ).'</span>'; ?></label>
                                <p><?php echo $post->post_content; ?></p>
                            </div>                       
                       <?php
					}					
				?>
            </div>
        </div>
        
        
    <?php }
	
	/* Save the meta box's post metadata. */
	function services_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['service_post_class_nonce'] ) || !wp_verify_nonce( $_POST['service_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		$s_expiry_date = get_post_meta($post_id, '_simple_service_expiry_date', true);
		if($s_expiry_date == '')
		{
			$c_dATE = DATE("d-m-Y");
			$default_service_expiry = fl_framework_get_options('service_default_expiry');
			$simple_service_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_service_expiry days"));
			update_post_meta($post_id, '_simple_service_expiry_date', $simple_service_expiry_date);
		}
		
		
		if(isset($_POST['service_category']))
		{
			
			update_post_meta( $post_id, '_service_category', sanitize_text_field($_POST['service_category']));
			set_hierarchical_terms('service-categories', $_POST['service_category'], $post_id);
			
			update_post_meta($post_id, 'cf_services_cats', $_POST['service_category']);
			
		}
		//saving custom fields
		if (isset($_POST['acf']) && $_POST['acf'] != '' && class_exists('ACF')) 
		{
			exertio_framework_acf_clear_object_cache($post_id);
			acf_update_values($_POST['acf'], $post_id);

		}
       if(isset($_POST['response_time']))
		{
			$response_terms = array((int)$_POST['response_time']); 
			/*print_r($cost_terms);
			exit;*/
			update_post_meta( $post_id, '_response_time', $_POST['response_time']);
			wp_set_post_terms( $post_id, $response_terms, 'response-time', false );
			
		}
		if(isset($_POST['delivery_time']))
		{
			$delivery_terms = array((int)$_POST['delivery_time']); 
			/*print_r($cost_terms);
			exit;*/
			update_post_meta( $post_id, '_delivery_time', $_POST['delivery_time']);
			wp_set_post_terms( $post_id, $delivery_terms, 'delivery-time', false );
			
		}
		if(isset($_POST['service_price']))
		{
			update_post_meta( $post_id, '_service_price', $_POST['service_price']);
			
		}
		if(isset($_POST['service_english_level']))
		{
			$service_english_level_term = array((int)$_POST['service_english_level']); 
			update_post_meta( $post_id, '_service_eng_level', $_POST['service_english_level']);
			wp_set_post_terms( $post_id, $service_english_level_term, 'services-english-level', false );
			
		}
		if(isset($_POST['service_location']))
		{
			update_post_meta( $post_id, '_service_location', sanitize_text_field($_POST['service_location']));
			set_hierarchical_terms('services-locations', $_POST['service_location'], $post_id);
		}
		if(isset($_POST['attachment_ids']))
		{
			update_post_meta( $post_id, '_service_attachment_ids', $_POST['attachment_ids']);
			
		}
		if(isset($_POST['is_show_service_attachments']) && $_POST['is_show_service_attachments'] == 'yes')
		{
			update_post_meta( $post_id, '_service_attachment_show', 'yes');
		}
		else
		{
			update_post_meta( $post_id, '_service_attachment_show', 'no');
		}
		if(isset($_POST['author_assign']))
		{
			$auth_id= $_POST['author_assign'];
			$arg = array(
				'ID' => $post_id,
				'post_author' => $auth_id,
			);
			remove_action('save_post', 'services_save_post_class_meta');
			wp_update_post( $arg );
		}
		if(isset($_POST['video_urls']))
		{
			$video_urls = $_POST['video_urls'];
			$urls = json_encode($video_urls);
			
			update_post_meta( $post_id, '_service_youtube_urls', $urls);
		}
		
		if(isset($_POST['service_featured']))
		{
			update_post_meta( $post_id, '_service_is_featured', $_POST['service_featured']);
			if($_POST['service_featured'] == 1)
			{
				$default_featured_service_expiry = fl_framework_get_options('default_featured_service_expiry');
				$featured_service_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_featured_service_expiry days"));
				update_post_meta($post_id, '_featured_service_expiry_date', $featured_service_expiry_date);
			}
		}
		
		if(isset($_POST['services_addon']))
		{
			$services_addon = $_POST['services_addon'];
			
			for($i=0; $i<count($services_addon); $i++)
			{
				$name = sanitize_text_field($services_addon[$i]);
				$addon[] = $name;
			}
			$encoded_addon =  json_encode($addon);
			update_post_meta( $post_id, '_services_addon', $encoded_addon );
		}
		
		$status = get_post_meta($post_id, '_service_status', true);
		if($status == 'cancel')
		{
			
		}
		else
		{
			update_post_meta( $post_id, '_service_status', 'active');
		}
	}
}