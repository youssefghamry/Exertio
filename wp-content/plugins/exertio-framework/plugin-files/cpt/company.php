<?php
add_action('init', 'fl_post_employer', 0);
function fl_post_employer() {
	 $args = array(
			'public' => true,
			'labels' => array(
							'name' => __('Employer', 'exertio_framework'),
							'singular_name' => __('Employer', 'exertio_framework'),
							'menu_name' => __('Employer', 'exertio_framework'),
							'name_admin_bar' => __('Employer', 'exertio_framework'),
							'add_new' => __('Add New Employer', 'exertio_framework'),
							'add_new_item' => __('Add New Employer', 'exertio_framework'),
							'new_item' => __('New Employer', 'exertio_framework'),
							'edit_item' => __('Edit Employer', 'exertio_framework'),
							'view_item' => __('View Employer', 'exertio_framework'),
							'all_items' => __('All Employers', 'exertio_framework'),
							'search_items' => __('Search Employer', 'exertio_framework'),
							'not_found' => __('No Employer Found.', 'exertio_framework'),
							),
			'delete_with_user' => true,
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon'           => FL_PLUGIN_URL.'/images/employer.png',
			'rewrite' => array('with_front' => false, 'slug' => 'employer'),
			'capabilities' => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap' => true,
		);
	register_post_type('employer', $args);

	
	/*
 * ADMIN COLUMN - HEADERS
 */	
 
 
 // Add the custom columns to the book post type:
add_filter( 'manage_employer_posts_columns', 'set_custom_edit_employer_columns' );
function set_custom_edit_employer_columns($columns) {
	unset($columns['date']);
    $columns['user'] = __( 'Author', 'exertio_framework' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_employer_posts_custom_column' , 'custom_employer_column', 10, 2 );
function custom_employer_column( $column, $post_id ) {
	$author_id = get_post_field( 'post_author', $post_id );
	$author_name = '<a href="'.get_edit_user_link($author_id).'">'.get_the_author_meta( 'nickname', $author_id ).' </a>';
    switch ( $column ) {

        case 'user' :
			
            echo $author_name;
            break;

    }
}

	$departments_labels = array(
			'name'                       => __( 'Departments', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Department', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Departments', 'exertio_framework' ),
			'all_items'                  => __( 'All Departments', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Department', 'exertio_framework' ),
			'update_item'                => __( 'Update Department', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Department', 'exertio_framework' ),
			'new_item_name'              => __( 'New Department Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Departments with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Department', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Departments', 'exertio_framework' ),
			'not_found'                  => __( 'No Department found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Departments', 'exertio_framework' ),
		);
		/* PROJECT CATEGORY TAXONOMY */
		register_taxonomy('departments', array('employer'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $departments_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'departments'),
		));

		
		$employees_labels = array(
			'name'                       => __( 'No. of Employees', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search No. of Employees', 'exertio_framework' ),
			'popular_items'              => __( 'Popular No. of Employees', 'exertio_framework' ),
			'all_items'                  => __( 'All No. of Employees', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit No. of Employees', 'exertio_framework' ),
			'update_item'                => __( 'Update No. of Employees', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New No. of Employee', 'exertio_framework' ),
			'new_item_name'              => __( 'New No. of Employee Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate No. of Employees with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove No. of Employees', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used No. of Employees', 'exertio_framework' ),
			'not_found'                  => __( 'No No. of Employee found.', 'exertio_framework' ),
			'menu_name'                  => __( 'No. of Employees', 'exertio_framework' ),
		);
		register_taxonomy('employees-number', array('employer'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $employees_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'employees-number'),
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
		register_taxonomy('employer-locations', array('employer'), array(
			'hierarchical' => true,
			'show_ui' => true,
			'labels' => $locations_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'locations'),
		));
		
		
		/* LOCATION IMAGES */
		
		
		
		if( ! class_exists( 'employer_locations_Taxonomy_Images' ) ) {
			class employer_locations_Taxonomy_Images {
			
			public function __construct() {
			 //
			}
			
			/**
			 * Initialize the class and start calling our hooks and filters
			 */
			 public function init() {
			 // Image actions
			 add_action( 'employer-locations_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
			 add_action( 'created_employer-locations', array( $this, 'save_category_image' ), 10, 2 );
			 add_action( 'employer-locations_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
			 add_action( 'edited_employer-locations', array( $this, 'updated_category_image' ), 10, 2 );
			 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
			 add_action( 'admin_footer', array( $this, 'add_script' ) );
			}
			
			public function load_media() {
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'employer-locations' ) {
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
			public function add_script() {
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'employer-locations' ) {
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
			$employer_locations_Taxonomy_Images = new employer_locations_Taxonomy_Images();
			$employer_locations_Taxonomy_Images->init(); 
		}	
	add_action( 'load-post.php', 'employer_boxes_setup' );
	add_action( 'load-post-new.php', 'employer_boxes_setup' );
	
	
	function employer_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'employer_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'employer_save_post_class_meta', 10, 2 );
	  
	}

	//add_action( 'admin_enqueue_scripts', 'attachment_wp_admin_enqueue' );
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function employer_meta_boxes() {
	
	  add_meta_box(
		'employer-post-class',      // Unique ID
		esc_html__( 'Add Employer Detail', 'exertio_framework' ),    // Title
		'employer_meta_box',   // Callback function
		'employer',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	
	function employer_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'employer_post_class_nonce' ); 
	  
		//print_r($post);
		$post_id =  $post->ID;

		$custom_field_dispaly = 'style=display:none;';
		if(class_exists('ACF'))
		{
			$selected_custom_data = exertio_employer_fields_by_listing_id($post_id);
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
            <div class="col-3"> <label><?php echo __( "Department", 'exertio_framework' ); ?></label> </div>
            <div class="col-3">
            <ul>
            <?php
            $departments_taxonomies = exertio_get_terms('departments');
            if ( !empty($departments_taxonomies) )
            {
				$employer_department = get_post_meta($post_id, '_employer_department', true);
				$department = '<select name="employer_department" id="exertio_freelancer_cat_parent">';
				$department .= '<option value=""> '. __( "Select Department", "exertio_framework" ) .'</option>';
                foreach( $departments_taxonomies as $departments_taxonomy ) {
					if($departments_taxonomy->term_id == $employer_department){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $departments_taxonomy->parent == 0 ) {
                         $department .= '<option value="'. esc_html( $departments_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $departments_taxonomy->name ) .'</option>';
                        $department.='</option>';
                    }
                }
                $department.='</select>';
                echo $department;
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
            <div class="col-3"><label><?php echo __( "Tagline", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_tagline ='';
				$employer_tagline = get_post_meta($post_id, '_employer_tagline', true);
			?>
            <input type="text" name="employer_tagline" value="<?php echo $employer_tagline; ?>" placeholder="<?php echo __( " Tagline", "exertio_framework" ); ?>">
            <p><?php echo __( "Employer Tagline will be here", "exertio_framework" ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Display Name", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_dispaly_name ='';
				$employer_dispaly_name = get_post_meta($post_id, '_employer_dispaly_name', true);
			?>
            <input type="text" name="employer_dispaly_name" value="<?php echo $employer_dispaly_name; ?>" placeholder="<?php echo __( " Display Name", "exertio_framework" ); ?>">
            <p><?php echo __( "This will be visible on website", "exertio_framework" ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Contact Number", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_contact_number ='';
				$employer_contact_number = get_post_meta($post_id, '_employer_contact_number', true);
			?>
            <input type="number" name="employer_contact_number" value="<?php echo $employer_contact_number; ?>" placeholder="<?php echo __( "Phone number", "exertio_framework" ); ?>">
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "No of Employees", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $employee_taxonomies = exertio_get_terms('employees-number');
            if ( !empty($employee_taxonomies) )
            {
				$employer_employees = get_post_meta($post_id, '_employer_employees', true);
                $employee = '<select name="employer_employees">';
				$employee .= '<option value=""> '. __( "Select number of Employees", "exertio_framework" ) .'</option>';
                foreach( $employee_taxonomies as $employee_taxonomy ) {
					if($employee_taxonomy->term_id == $employer_employees){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $employee_taxonomy->parent == 0 ) {
                        //$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
                         $employee .= '<option value="'. esc_attr( $employee_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $employee_taxonomy->name ) .'</option>';
                        $employee.='</option>';
                    }
                }
                $employee.='</select>';
                echo $employee;
            }
            else
            {
                echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
                <p> <?php echo __( "Mention how many employees does this employer have", 'exertio_framework' ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Location", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $location_taxonomies = exertio_get_terms('employer-locations'); 
            if ( !empty($location_taxonomies) )
            {
				$employer_location = get_post_meta($post_id, '_employer_location', true);
                $pro_location = '<select name="employer_location">';
				$pro_location .= get_hierarchical_terms('employer-locations', $employer_location );
				
                $pro_location.='</select>';
                echo $pro_location;
            }
            else
            {
                echo __( "No values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Profile Picture", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                 <div id="freelance_gall_render_html">
                    <ul class="freelance_gallery">
						<?php
                        $profile_pic_attachment_ids = get_post_meta($post_id, '_profile_pic_attachment_id', true);
                        if(isset($profile_pic_attachment_ids) && $profile_pic_attachment_ids !='')
                        {
							$attachment_data = wp_get_attachment_url( $profile_pic_attachment_ids );
							echo '<li id="data-'.$profile_pic_attachment_ids.'"><img src="'.$attachment_data.'" alt="'.__( "attachment", 'exertio_framework' ).'"><a href="javascript:void(0);" class="remove_button"><img src="'.FL_PLUGIN_URL.'/images/error.png" ></a></li>';
                        }
                        ?> 
                    </ul>
                 </div> 
                 <button id="single_attachment_btn" type="button" class="button button-primary button-large">  <?php echo __( "Select Profile Image", 'exertio_framework' ); ?> </button>
                 <input type="hidden" name="profile_attachment_ids" value="<?php echo $profile_pic_attachment_ids; ?>" id="profile_attachment_ids">
                 <p><?php echo __( "Select profile picture to show publicly.", 'exertio_framework' ); ?></p>

            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Banner Image", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                 <div id="freelance_gall_render_html1">
                    <ul class="freelance_banner_gallery">
						<?php
                        $banner_attachment_id = get_post_meta($post_id, '_employer_banner_id', true);
                        if(isset($banner_attachment_id) && $banner_attachment_id !='')
                        {
							$banner_attachment_data = wp_get_attachment_url( $banner_attachment_id );
							echo '<li id="data-'.$banner_attachment_id.'"><img src="'.$banner_attachment_data.'" alt="'.__( "attachment", 'exertio_framework' ).'"><a href="javascript:void(0);" class="remove_button"><img src="'.FL_PLUGIN_URL.'/images/error.png" ></a></li>';
                        }
                        ?> 
                    </ul>
                 </div> 
                 <button id="banner_img_btn" type="button" class="button button-primary button-large">  <?php echo __( "Select Banner Image", 'exertio_framework' ); ?> </button>
                 <input type="hidden" name="banner_img_id" value="<?php echo $banner_attachment_id; ?>" id="banner_img_id">
                 <p><?php echo __( "Select banner image to show on public profile.", 'exertio_framework' ); ?></p>

            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Address", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_address ='';
				$employer_address = get_post_meta($post_id, '_employer_address', true);
			?>
            <input type="text" name="employer_address" value="<?php echo $employer_address; ?>" placeholder="<?php echo __( "Address", "exertio_framework" ); ?>">
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Latitude", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_latitude ='';
				$employer_latitude = get_post_meta($post_id, '_employer_latitude', true);
			?>
            <input type="text" name="employer_latitude" value="<?php echo $employer_latitude; ?>" placeholder="<?php echo __( "Provide Latitude", "exertio_framework" ); ?>">
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Longitude", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_longitude ='';
				$employer_longitude = get_post_meta($post_id, '_employer_longitude', true);
			?>
            <input type="text" name="employer_longitude" value="<?php echo $employer_longitude; ?>" placeholder="<?php echo __( "Provide Longitude", "exertio_framework" ); ?>">
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark Employer Verified", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_verified ='';
				$employer_verified = get_post_meta($post_id, '_is_employer_verified', true);
			?>
            <select name="employer_verified">
                <option value="0" <?php if(isset($employer_verified) && $employer_verified == 0 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Not verified", 'exertio_framework' ); ?></option>
                <option value="1" <?php if(isset($employer_verified) && $employer_verified == 1 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Verified", 'exertio_framework' ); ?></option>
            </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark Employer Featured", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$employer_featured ='';
				$employer_featured = get_post_meta($post_id, '_employer_is_featured', true);
			?>
            <select name="employer_featured">
                <option value="0" <?php if(isset($employer_featured) && $employer_featured == 0 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Simple", 'exertio_framework' ); ?></option>
                <option value="1" <?php if(isset($employer_featured) && $employer_featured == 1 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Featured", 'exertio_framework' ); ?></option>
            </select>
            </div>
        </div>
        
    <?php }

	
	/* Save the meta box's post metadata. */
	function employer_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['employer_post_class_nonce'] ) || !wp_verify_nonce( $_POST['employer_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		if(isset($_POST['employer_department']))
		{
			$department_terms = array((int)$_POST['employer_department']); 

			update_post_meta( $post_id, '_employer_department', $_POST['employer_department']);
			wp_set_post_terms( $post_id, $department_terms, 'departments', false );
			
			/*FOR CUSTOM FIELDS*/
			update_post_meta($post_id, 'cf_employer_departments', $_POST['employer_department']);
		}
		//saving custom fields
		if (isset($_POST['acf']) && $_POST['acf'] != '' && class_exists('ACF')) 
		{
			exertio_framework_acf_clear_object_cache($post_id);
			acf_update_values($_POST['acf'], $post_id);

		}
		
		
		if(isset($_POST['employer_name']))
		{
			update_post_meta( $post_id, '_employer_name', $_POST['employer_name']);
			
		}
		if(isset($_POST['employer_tagline']))
		{
			update_post_meta( $post_id, '_employer_tagline', $_POST['employer_tagline']);
			
		}
		if(isset($_POST['employer_dispaly_name']))
		{
			update_post_meta( $post_id, '_employer_dispaly_name', $_POST['employer_dispaly_name']);
			
		}
		if(isset($_POST['employer_contact_number']))
		{
			update_post_meta( $post_id, '_employer_contact_number', $_POST['employer_contact_number']);
			
		}
       if(isset($_POST['employer_employees']))
		{
			$employer_employees_terms = array((int)$_POST['employer_employees']); 
			/*print_r($cost_terms);
			exit;*/
			update_post_meta( $post_id, '_employer_employees', $_POST['employer_employees']);
			wp_set_post_terms( $post_id, $employer_employees_terms, 'employees-number', false );
			
		}
		if(isset($_POST['employer_location']))
		{
			$employer_location_terms = array((int)$_POST['employer_location']); 
			update_post_meta( $post_id, '_employer_location', $_POST['employer_location']);
			set_hierarchical_terms('employer-locations', $_POST['employer_location'], $post_id);
			/*wp_set_post_terms( $post_id, $employer_location_terms, 'employer-locations', false );*/
			
		}

		if(isset($_POST['profile_attachment_ids']))
		{
			update_post_meta( $post_id, '_profile_pic_attachment_id', $_POST['profile_attachment_ids']);
			
		}
		
		if(isset($_POST['banner_img_id']))
		{
			update_post_meta( $post_id, '_employer_banner_id', $_POST['banner_img_id']);
			
		}
		if(isset($_POST['employer_address']))
		{
			update_post_meta( $post_id, '_employer_address', $_POST['employer_address']);
			
		}
		if(isset($_POST['employer_latitude']))
		{
			update_post_meta( $post_id, '_employer_latitude', $_POST['employer_latitude']);
			
		}
		if(isset($_POST['employer_longitude']))
		{
			update_post_meta( $post_id, '_employer_longitude', $_POST['employer_longitude']);
		}
		if(isset($_POST['employer_verified']))
		{
			update_post_meta( $post_id, '_is_employer_verified', $_POST['employer_verified']);
			
		}
		if(isset($_POST['employer_featured']))
		{
			update_post_meta( $post_id, '_employer_is_featured', $_POST['employer_featured']);
			
		}
	}
	
	
	
	/*SIDEBAR META BOXES*/
	
	
	add_action( 'load-post.php', 'employer_sidebar_boxes_setup' );
	add_action( 'load-post-new.php', 'employer_sidebar_boxes_setup' );
	
	
	function employer_sidebar_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'employer_sidebar_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'employer_sidebar_save_post_class_meta', 10, 2 );
	  
	}

	//add_action( 'admin_enqueue_scripts', 'attachment_wp_admin_enqueue' );
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function employer_sidebar_meta_boxes() {
	
	  add_meta_box(
		'employer-sidebar-post-class',      // Unique ID
		esc_html__( 'Package Detail', 'exertio_framework' ),    // Title
		'employer_sidebar_meta_box',   // Callback function
		'employer',
		'side',         // Context
		'default'         // Priority
	  );
	}
	
	function employer_sidebar_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'employer_sidebar_post_class_nonce' ); 
	  
		$post_id =  $post->ID;

		?>
        <div class="sidebar-row">
            <p><?php echo __( "Simple Projects", 'exertio_framework' ); ?></p>
				<?php
					$simple_project = get_post_meta( $post_id , '_simple_projects', true);
				?>
				<input type="text" name="simple_projects" value="<?php echo esc_attr($simple_project); ?>" placeholder="<?php echo __( " Allowed simple projects", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only. -1 for unlimited", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Simple Projects Expiry", 'exertio_framework' ); ?></p>
				<?php
					$simple_project_expiry = get_post_meta( $post_id , '_simple_project_expiry', true);
				?>
				<input type="text" name="simple_project_expiry" value="<?php echo esc_attr($simple_project_expiry); ?>" placeholder="<?php echo __( " Simple project expiry", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only in days. -1 for never Expire", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Featured Projects", 'exertio_framework' ); ?></p>
				<?php
					$featured_projects = get_post_meta( $post_id , '_featured_projects', true);
				?>
				<input type="text" name="featured_projects" value="<?php echo esc_attr($featured_projects); ?>" placeholder="<?php echo __( "Allowed Featured projects", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only. -1 for unlimited", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Featured Project Expiry", 'exertio_framework' ); ?></p>
				<?php
					$featured_project_expiry = get_post_meta( $post_id , '_featured_project_expiry', true);
				?>
				<input type="text" name="featured_project_expiry" value="<?php echo esc_attr($featured_project_expiry); ?>" placeholder="<?php echo __( " Featured Project Expiry", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only in days. -1 for never expire", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Package Expiry", 'exertio_framework' ); ?></p>
				<?php
					$employer_package_expiry = get_post_meta( $post_id , '_employer_package_expiry', true);
				?>
				<input type="text" name="employer_package_expiry" value="<?php echo esc_attr($employer_package_expiry); ?>" placeholder="<?php echo __( " Package expiry", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only in days. -1 for never expire", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
			<?php
				$return_msg =  '';
				$employer_package_expiry_date = get_post_meta( $post_id , '_employer_package_expiry_date', true);
				 if(isset($employer_package_expiry_date) && $employer_package_expiry_date == -1)
				 {
					 $return_msg = __( "Never Expire", 'exertio_framework' );
				 }
				 else if(isset($employer_package_expiry_date) && $employer_package_expiry_date != '')
				 {
					$return_msg =  date_i18n( get_option( 'date_format' ), strtotime($employer_package_expiry_date));
				 }
			?>
            <p><?php echo __( "Package Expiry: ", 'exertio_framework' ).'<b>'.$return_msg.'</b>'; ?></p>
        </div>
    <?php }

	
	/* Save the meta box's post metadata. */
	function employer_sidebar_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['employer_sidebar_post_class_nonce'] ) || !wp_verify_nonce( $_POST['employer_sidebar_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
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
			$expiry_days = $_POST['employer_package_expiry'];
			update_post_meta( $post_id, '_employer_package_expiry', $expiry_days);
			
			if(isset($expiry_days) && $expiry_days == -1)
			{
				update_post_meta( $post_id, '_employer_package_expiry_date', -1);
			}
			else
			{
				$c_dATE = DATE("d-m-Y");

				$employer_package_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $expiry_days days"));

				update_post_meta( $post_id, '_employer_package_expiry_date', $employer_package_expiry_date);
			}
			
		}
		
		
	}


}