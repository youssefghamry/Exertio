<?php // Register post  type and taxonomy
add_action('init', 'fl_post_freelancer', 0);

function fl_post_freelancer() {
	 $args = array(
			'public' => true,
			'labels' => array(
							'name' => __('Freelancer', 'exertio_framework'),
							'singular_name' => __('Freelancer', 'exertio_framework'),
							'menu_name' => __('Freelancer', 'exertio_framework'),
							'name_admin_bar' => __('Freelancer', 'exertio_framework'),
							'add_new' => __('Add New Freelancer', 'exertio_framework'),
							'add_new_item' => __('Add New Freelancer', 'exertio_framework'),
							'new_item' => __('New Freelancer', 'exertio_framework'),
							'edit_item' => __('Edit Freelancer', 'exertio_framework'),
							'view_item' => __('View Freelancer', 'exertio_framework'),
							'all_items' => __('All Freelancers', 'exertio_framework'),
							'search_items' => __('Search Freelancer', 'exertio_framework'),
							'not_found' => __('No Freelancer Found.', 'exertio_framework'),
							),
			'delete_with_user' => true,
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon'           => FL_PLUGIN_URL.'/images/freelancer.png',
			'rewrite' => array('with_front' => false, 'slug' => 'freelancer'),
			'capabilities' => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap' => true,
		);
	register_post_type('freelancer', $args);
	/*
 * ADMIN COLUMN - HEADERS
 */	
 
 
 // Add the custom columns to the book post type:
add_filter( 'manage_freelancer_posts_columns', 'set_custom_edit_freelancer_columns' );
function set_custom_edit_freelancer_columns($columns) {
	unset($columns['date']);
    $columns['user'] = __( 'Author', 'exertio_framework' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_freelancer_posts_custom_column' , 'custom_freelancer_column', 10, 2 );
function custom_freelancer_column( $column, $post_id ) {
	$author_id = get_post_field( 'post_author', $post_id );
	$author_name = '<a href="'.get_edit_user_link($author_id).'">'.get_the_author_meta( 'nickname', $author_id ).' </a>';
    switch ( $column ) {

        case 'user' :
			
            echo $author_name;
            break;

    }
}
	$specialization = array(
			'name'                       => __( 'Specialization', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Specialization', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Specializations', 'exertio_framework' ),
			'all_items'                  => __( 'All Specializations', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Specialization', 'exertio_framework' ),
			'update_item'                => __( 'Update Specialization', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Specialization', 'exertio_framework' ),
			'new_item_name'              => __( 'New Specialization Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Specializations with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Specializations', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Specializations', 'exertio_framework' ),
			'not_found'                  => __( 'No Specialization found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Specializations', 'exertio_framework' ),
		);
		register_taxonomy('freelancer-specialization', array('freelancer'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $specialization,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'freelancer-specialization'),
		));
	$departments_labels = array(
			'name'                       => __( 'Skills', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Skills', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Skills', 'exertio_framework' ),
			'all_items'                  => __( 'All Skills', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Skill', 'exertio_framework' ),
			'update_item'                => __( 'Update Skill', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Skill', 'exertio_framework' ),
			'new_item_name'              => __( 'New Skill Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Skills with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Skills', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Skills', 'exertio_framework' ),
			'not_found'                  => __( 'No Skills found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Skills', 'exertio_framework' ),
		);
		/* PROJECT CATEGORY TAXONOMY */
		register_taxonomy('freelancer-skills', array('freelancer'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $departments_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'skills'),
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
		register_taxonomy('freelancer-locations', array('freelancer'), array(
			'hierarchical' => true,
			'show_ui' => true,
			'labels' => $locations_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'locations'),
		));
		$languages_labels = array(
			'name'                       => __( 'Languages', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Languages', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Languages', 'exertio_framework' ),
			'all_items'                  => __( 'All Languages', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Language', 'exertio_framework' ),
			'update_item'                => __( 'Update Language', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Language', 'exertio_framework' ),
			'new_item_name'              => __( 'New Language Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Languages with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Languages', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Languages', 'exertio_framework' ),
			'not_found'                  => __( 'No Language found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Languages', 'exertio_framework' ),
		);
		register_taxonomy('freelancer-languages', array('freelancer'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $languages_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'languages'),
		));
		
		$freelancer_type_labels = array(
			'name'                       => __( 'Freelancer Type', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Freelancer Type', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Freelancer Type', 'exertio_framework' ),
			'all_items'                  => __( 'All Freelancer Type', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Freelancer Type', 'exertio_framework' ),
			'update_item'                => __( 'Update Freelancer Type', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Freelancer Type', 'exertio_framework' ),
			'new_item_name'              => __( 'New Freelancer Type Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Freelancer Type with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Freelancer Type', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Freelancer Type', 'exertio_framework' ),
			'not_found'                  => __( 'No Freelancer Type found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Freelancer Type', 'exertio_framework' ),
		);
		register_taxonomy('freelance-type', array('freelancer'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $freelancer_type_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'freelancer-type'),
		));
		$elglish_labels = array(
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
		register_taxonomy('freelancer-english-level', array('freelancer'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $elglish_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'english-level'),
		));
		/* LOCATION IMAGES */
		
		
		
		if( ! class_exists( 'freelancer_locations_Taxonomy_Images' ) ) {
			class freelancer_locations_Taxonomy_Images {
			
			public function __construct() {
			 //
			}
			
			/**
			 * Initialize the class and start calling our hooks and filters
			 */
			 public function init() {
			 // Image actions
			 add_action( 'freelancer-locations_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
			 add_action( 'created_freelancer-locations', array( $this, 'save_category_image' ), 10, 2 );
			 add_action( 'freelancer-locations_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
			 add_action( 'edited_freelancer-locations', array( $this, 'updated_category_image' ), 10, 2 );
			 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
			 add_action( 'admin_footer', array( $this, 'add_script' ) );
			}
			
			public function load_media() {
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'freelancer-locations' ) {
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
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'freelancer-locations' ) {
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
			$freelancer_locations_Taxonomy_Images = new freelancer_locations_Taxonomy_Images();
			$freelancer_locations_Taxonomy_Images->init(); 
		}	
	
	
	add_action( 'load-post.php', 'freelancer_boxes_setup' );
	add_action( 'load-post-new.php', 'freelancer_boxes_setup' );
	
	
	function freelancer_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'freelancer_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'freelancer_save_post_class_meta', 10, 2 );
	  
	}

	//add_action( 'admin_enqueue_scripts', 'attachment_wp_admin_enqueue' );
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function freelancer_meta_boxes() {
	
	  add_meta_box(
		'freelancer-post-class',      // Unique ID
		esc_html__( 'Add Freelancer Detail', 'exertio_framework' ),    // Title
		'freelancer_meta_box',   // Callback function
		'freelancer',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	
	function freelancer_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'freelancer_post_class_nonce' ); 
	  
		//print_r($post);
		$post_id =  $post->ID;
		
		$custom_field_dispaly = 'style=display:none;';
		if(class_exists('ACF'))
		{
			$selected_custom_data = exertio_freelancer_fields_by_listing_id($post_id);
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
            <div class="col-3"><label><?php echo __( "Gender", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_gender ='';
				$freelancer_gender = get_post_meta($post_id, '_freelancer_gender', true);
			?>
            <select name="freelancer_gender">
            	<option value="0" <?php if($freelancer_gender == '0'){ echo "selected='selected'";} ?>><?php echo __( "Male", 'exertio_framework' ); ?> </option>
                <option value="1" <?php if($freelancer_gender == '1'){ echo "selected='selected'";} ?>><?php echo __( "Female", 'exertio_framework' ); ?> </option>
				<option value="2" <?php if($freelancer_gender  == "2") { echo "selected=selected"; } ?>><?php echo __( "Other", 'exertio_theme' ); ?> </option>
            </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Tagline", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_tagline ='';
				$freelancer_tagline = get_post_meta($post_id, '_freelancer_tagline', true);
			?>
            <input type="text" name="freelancer_tagline" value="<?php echo $freelancer_tagline; ?>" placeholder="<?php echo __( " Tagline", "exertio_framework" ); ?>">
            <p><?php echo __( "Freelancer Tagline will be here", "exertio_framework" ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Display Name", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_dispaly_name ='';
				$freelancer_dispaly_name = get_post_meta($post_id, '_freelancer_dispaly_name', true);
			?>
            <input type="text" name="freelancer_dispaly_name" value="<?php echo $freelancer_dispaly_name; ?>" placeholder="<?php echo __( " Display Name", "exertio_framework" ); ?>">
            <p><?php echo __( "This will be visible on website", "exertio_framework" ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Contact Number", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_contact_number ='';
				$freelancer_contact_number = get_post_meta($post_id, '_freelancer_contact_number', true);
			?>
            <input type="number" name="freelancer_contact_number" value="<?php echo $freelancer_contact_number; ?>" placeholder="<?php echo __( "Phone number", "exertio_framework" ); ?>">
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"> <label><?php echo __( "Freelancer Type", 'exertio_framework' ); ?></label> </div>
            <div class="col-3">
            <ul>
            <?php
            $freelance_taxonomies = exertio_get_terms('freelance-type');
            if ( !empty($freelance_taxonomies) )
            {
				$freelance_type = get_post_meta($post_id, '_freelance_type', true);
				$freelance = '<select name="freelance_type">';
				$freelance .= '<option value=""> '. __( "Select Freelancer Type", "exertio_framework" ) .'</option>';
                foreach( $freelance_taxonomies as $freelance_taxonomy ) {
					if($freelance_taxonomy->term_id == $freelance_type){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $freelance_taxonomy->parent == 0 ) {
                         $freelance .= '<option value="'. esc_html( $freelance_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $freelance_taxonomy->name ) .'</option>';
                        $freelance.='</option>';
                    }
                }
                $freelance.='</select>';
                echo $freelance;
            }
            else
            {
                echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </ul>
                
            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"> <label><?php echo __( "Freelancer Specialization", 'exertio_framework' ); ?></label> </div>
            <div class="col-3">
            <ul>
            <?php
            $specialization_taxonomies = exertio_get_terms('freelancer-specialization');
			if ( !empty($specialization_taxonomies) )
			{
				$freelancer_specialization = get_post_meta($post_id, '_freelancer_specialization', true);
				$specialization = '<select name="freelancer_specialization" class="form-control general_select" id="exertio_freelancer_cat_parent">';
				$specialization .= '<option value=""> '. __( "Select Specialization", "exertio_theme" ) .'</option>';
				foreach( $specialization_taxonomies as $specialization_taxonomy ) {
					if($specialization_taxonomy->term_id == $freelancer_specialization){ $selected = 'selected ="selected"';}else{$selected = ''; }
					if( $specialization_taxonomy->parent == 0 ) {
						 $specialization .= '<option value="'. esc_html( $specialization_taxonomy->term_id ) .'" '.$selected.'>
								'. esc_html( $specialization_taxonomy->name ) .'</option>';
						$specialization.='</option>';
					}
				}
				$specialization.='</select>';
				echo wp_return_echo($specialization);
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
            <div class="col-3"><label><?php echo __( "English Level", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $english_level_taxonomies = exertio_get_terms('freelancer-english-level');
            if ( !empty($english_level_taxonomies) )
            {
				$english_level = get_post_meta($post_id, '_freelancer_english_level', true);
                $english = '<select name="english_level">';
				$english .= '<option value=""> '. __( "Select English Level", "exertio_framework" ) .'</option>';
                foreach( $english_level_taxonomies as $english_level_taxonomy ) {
					if($english_level_taxonomy->term_id == $english_level){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $english_level_taxonomy->parent == 0 ) {
                         $english .= '<option value="'. esc_attr( $english_level_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $english_level_taxonomy->name ) .'</option>';
                        $english.='</option>';
                    }
                }
                $english.='</select>';
                echo $english;
            }
            else
            {
                echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Languages", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $languages_taxonomies = exertio_get_terms('freelancer-languages'); 
            if ( !empty($languages_taxonomies) )
            {
				$freelancer_language = get_post_meta($post_id, '_freelancer_language', true);
                $location = '<select name="freelancer_language">';
				$location .= '<option value=""> '. __( "Select Language", "exertio_framework" ) .'</option>';
                foreach( $languages_taxonomies as $languages_taxonomy ) {
					if($languages_taxonomy->term_id == $freelancer_language){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $languages_taxonomy->parent == 0 ) {
                         $location .= '<option value="'. esc_attr( $languages_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $languages_taxonomy->name ) .'</option>';
                        $location.='</option>';
                    }
                }
                $location.='</select>';
                echo $location;
            }
            else
            {
                echo __( "No values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Location", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
		  $location_taxonomies = exertio_get_terms('freelancer-locations');
			if ( !empty($location_taxonomies) )
			{
				$fl_location = get_post_meta($post_id, '_freelancer_location', true);
				echo '<select name="freelancer_location" class="form-control general_select">'.get_hierarchical_terms('freelancer-locations', '_freelancer_location', $post_id ).'</select>';
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
                        $profile_pic_attachment_ids = get_post_meta($post_id, '_profile_pic_freelancer_id', true);
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
                        $banner_attachment_id = get_post_meta($post_id, '_freelancer_banner_id', true);
                        if(isset($banner_attachment_id) && $banner_attachment_id !='')
                        {
							$banner_attachment_data = wp_get_attachment_url( $banner_attachment_id );
							echo '<li id="data-'.$banner_attachment_id.'"><img src="'.$banner_attachment_data.'" alt="'.__( "attachment", 'exertio_framework' ).'"><a href="javascript:void(0);" class="remove_button"><img src="'.FL_PLUGIN_URL.'/images/error.png" >	</a></li>';
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
				$company_address ='';
				$company_address = get_post_meta($post_id, '_freelancer_address', true);
			?>
            <input type="text" name="freelancer_address" value="<?php echo $company_address; ?>" placeholder="<?php echo __( "Address", "exertio_framework" ); ?>">
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Latitude", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$company_latitude ='';
				$company_latitude = get_post_meta($post_id, '_freelancer_latitude', true);
			?>
            <input type="text" name="freelancer_latitude" value="<?php echo $company_latitude; ?>" placeholder="<?php echo __( "Provide Latitude", "exertio_framework" ); ?>">
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Longitude", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$company_longitude ='';
				$company_longitude = get_post_meta($post_id, '_freelancer_longitude', true);
			?>
            <input type="text" name="freelancer_longitude" value="<?php echo $company_longitude; ?>" placeholder="<?php echo __( "Provide Longitude", "exertio_framework" ); ?>">
            </div>
        </div>
        
        <div class="custom-row no-border">
            	<h3><?php echo __( "Skills and Awads", 'exertio_framework' ); ?></h3>
        </div>
        
        <div class="row">
            <div class="col-3"><label><?php echo __( "Skills", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                <div class="col-12">
                	<div class="skills_wrapper sortable"  id="sortable">
                    	<?php
							$skills_json =  json_decode(stripslashes(get_post_meta($post_id, '_freelancer_skills', true)), true);
							if(!empty($skills_json))
							{
								$skill_html = '';
								$skills_taxonomies = exertio_get_terms('freelancer-skills');
								for($i=0; $i<count($skills_json); $i++)
								{	
									$skill_html .= '<div class="ui-state-default"><span class="dashicons dashicons-move"></span><div class="col-4"><select name="freelancer_skills[]">';
									foreach( $skills_taxonomies as $skills_taxonomy ) {
										if($skills_taxonomy->term_id == $skills_json[$i]['skill']){ $selected = 'selected ="selected"';}else{$selected = ''; }
										if( $skills_taxonomy->parent == 0 ) {
											 $skill_html .= '<option value="'. esc_attr( $skills_taxonomy->term_id ) .'" '.$selected.'>
													'. esc_html( $skills_taxonomy->name ) .'</option>';
											$skill_html.='</option>';
										}
									}
									$skill_html .= '</select></div>';
                                    if (fl_framework_get_options('freelancer_skills_percentage') == 1) {
                                        $skill_html .= '<div class="col-4"><input type="number" name="skills_percent[]" placeholder="' . __("Skills percentage", 'exertio_framework') . '" value="' . $skills_json[$i]['percent'] . '"></div><a href="javascript:void(0);" class="remove_button"><img src="' . FL_PLUGIN_URL . '/images/error.png" >	</a></div>';
                                    }
								}
								echo $skill_html;
							}
						?>
                    </div>
                </div>
                <div class="col-12">
                    <a href="javascript:void(0);" class="add_new_skills button button-primary button-large" data-taxonomy-name="freelancer-skills"> <?php echo __( "Add More", 'exertio_framework' ); ?> </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3"><label><?php echo __( "Awards and Certificates", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                <div class="col-12">
                	<div class="award_wrapper sortable" id="sortable">
                    	<?php
							$award_jsons =  json_decode(stripslashes(get_post_meta($post_id, '_freelancer_awards', true)), true);
							if(!empty($award_jsons))
							{
								$award_html = '';
								$count = '1';
								foreach($award_jsons as $award_json)
								{
									$award_img_url = wp_get_attachment_url( $award_json['award_img'] );
									$award_html .= '<div class="ui-state-default" id="award_'.$count.'"><span class="dashicons dashicons-move"></span><div class="col-4"><input type="text" name="award_name[]" value="'.$award_json['award_name'].'" ></div><div class="col-4"> <input type="text" class="datetimepicker" name="award_date[]" value="'.$award_json['award_date'].'" autocomplete="off"></div> <div class="col-4"> <button type="button" class="award_img_btn button button-primary button-large" data-award-init = "award_img_id_'.$count.'" data-award-galary= "award_banner_gallery_'.$count.'">'.__( "Select image", 'exertio_framework' ).'</button> <input type="hidden" id="award_img_id_'.$count.'" name="award_img_id[]" value="'.$award_json['award_img'].'"> <div class="award_banner_gallery_'.$count.' sort_imgs"><ul class="award_listing_gallery"><li id="data-'.$award_json['award_img'].'"><span class="freelance_icon_brand"><img id="'.$award_json['award_img'].'" src="'.esc_url($award_img_url).'"></span></li></ul></div> </div><a href="javascript:void(0);" class="remove_button"><img src="'.FL_PLUGIN_URL.'/images/error.png" ></a></div>';
									$count++;
								}
								echo $award_html;
							}
						?>
                    </div>
                </div>
                <div class="col-12">
                    <a href="javascript:void(0);" class="add_new_award button button-primary button-large"> <?php echo __( "Add More", 'exertio_framework' ); ?> </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-3"><label><?php echo __( "Projects", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                <div class="col-12">
                	<div class="project_wrapper sortable" id="sortable">
                    	<?php
							$project_jsons =  json_decode(stripslashes(get_post_meta($post_id, '_freelancer_projects', true)), true);
							if(!empty($project_jsons))
							{
								$count = '1';
								$project_html ='';
								foreach($project_jsons as $project_json)
								{
									$project_img_url = wp_get_attachment_url( $project_json['project_img'] );
									$project_html .= '<div class="ui-state-default" id="project_'.$count.'"><span class="dashicons dashicons-move"></span><div class="col-4"><input type="text" name="project_name[]" value="'.$project_json['project_name'].'" ></div><div class="col-4"> <input type="url" class="" name="project_url[]" value="'.$project_json['project_url'].'" autocomplete="off"></div> <div class="col-4"> <button type="button" class="project_img_btn button button-primary button-large" data-project-init = "project_img_id_'.$count.'" data-project-galary= "project_banner_gallery_'.$count.'">'.__( "Select image", 'exertio_framework' ).'</button> <input type="hidden" id="project_img_id_'.$count.'" name="project_img_id[]" value="'.$project_json['project_img'].'"> <div class="project_banner_gallery_'.$count.' sort_imgs"><ul class="project_listing_gallery"><li id="data-'.$project_json['project_img'].'"><span class="freelance_icon_brand"><img id="'.$project_json['project_img'].'" src="'.esc_url($project_img_url).'"></span></li></ul></div> </div><a href="javascript:void(0);" class="remove_button"><img src="'.FL_PLUGIN_URL.'/images/error.png" ></a></div>';
									$count++;
								}
								echo $project_html;
							}
							
						
						?>
                    </div>
                </div>
                <div class="col-12">
                    <a href="javascript:void(0);" class="add_new_project button button-primary button-large"> <?php echo __( "Add More", 'exertio_framework' ); ?> </a>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-3"><label><?php echo __( "Experience", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                <div class="col-12">
                	<div class="expe_wrapper sortable" id="sortable">
                    	<?php
							//$expe_jsons =  json_decode(get_post_meta($post_id, '_freelancer_experience', true), true);
							//$expe_jsons =   get_post_meta($post_id, '_freelancer_experience', true);
							$expe_jsons =  json_decode(stripslashes(get_post_meta($post_id, '_freelancer_experience', true)), true);
							
							if(!empty($expe_jsons))
							{
								$expe_html = '';
								$count = '1';
								foreach($expe_jsons as $expe_json)
								{
									$expe_html .= '<div class="ui-state-default" id="expe_'.$count.'"><span class="dashicons dashicons-move"></span><span class="count">'.$count.'</span>	<div class="col-12"><div class="col-4"><label>'.__( "Experience Title", 'exertio_framework' ).'</label><input type="text" name="expe_name[]" value="'.$expe_json['expe_name'].'" ></div><div class="col-4"><label>'.__( "Company Name", 'exertio_framework' ).'</label> <input type="text" class="" name="expe_company_name[]" value="'.$expe_json['expe_company_name'].'"></div></div><div class="col-12"> <div class="col-4"> <label>'.__( "Start Date Title", 'exertio_framework' ).'</label><input type="text"  name="expe_start_date[]" value="'.$expe_json['expe_start_date'].'" class="expe_start_date_'.$count.' init_date_expe_start" data-abc="0987"></div> <div class="col-4"><label>'.__( "End Date", 'exertio_framework' ).'</label> <input type="text" name="expe_end_date[]" value="'.$expe_json['expe_end_date'].'" class="expe_end_date_'.$count.' init_date_expe_end"><p>'.__( "Leave it empty to set it current job", 'exertio_framework' ).'</p></div></div><div class="col-12"><div class="col-8"><label>'.__( "Description", 'exertio_framework' ).'</label><textarea name="expe_details[]">'.$expe_json['expe_details'].'</textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><img src="'.FL_PLUGIN_URL.'/images/error.png" ></a></div>';
									$count++;
								}
								echo $expe_html;
							}
						?>
                    </div>
                </div>
                <div class="col-12">
                    <a href="javascript:void(0);" class="add_new_expe button button-primary button-large"> <?php echo __( "Add More", 'exertio_framework' ); ?> </a>
                </div>
            </div>
        </div>
        
        
        <div class="row">
            <div class="col-3"><label><?php echo __( "Education", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
                <div class="col-12">
                	<div class="edu_wrapper sortable" id="sortable">
                    	<?php
							$edu_jsons =  json_decode(stripslashes(get_post_meta($post_id, '_freelancer_education', true)), true);
										   
							if(!empty($edu_jsons))
							{
								$edu_html = '';
								$count = '1';
								foreach($edu_jsons as $edu_json)
								{
									$edu_html .= '<div class="ui-state-default" id="edu_'.$count.'"><span class="dashicons dashicons-move"></span><span class="count">'.$count.'</span>	<div class="col-12"><div class="col-4"><label>'.__( "Education Title", 'exertio_framework' ).'</label><input type="text" name="edu_name[]" value="'.$edu_json['edu_name'].'" ></div><div class="col-4"><label>'.__( "Institude Name", 'exertio_framework' ).'</label> <input type="text" class="" name="edu_inst_name[]" value="'.$edu_json['edu_inst_name'].'"></div></div><div class="col-12"> <div class="col-4"> <label>'.__( "Start Date Title", 'exertio_framework' ).'</label><input type="text"  name="edu_start_date[]" value="'.$edu_json['edu_start_date'].'" class="edu_start_date_'.$count.' init_date_edu_start" data-abc="0987"></div> <div class="col-4"><label>'.__( "End Date", 'exertio_framework' ).'</label> <input type="text" name="edu_end_date[]" value="'.$edu_json['edu_end_date'].'" class="edu_end_date_'.$count.' init_date_edu_end"><p>'.__( "Leave it empty to set it current job", 'exertio_framework' ).'</p></div></div><div class="col-12"><div class="col-8"><label>'.__( "Description", 'exertio_framework' ).'</label><textarea name="edu_details[]">'.$edu_json['edu_details'].'</textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><img src="'.FL_PLUGIN_URL.'/images/error.png" ></a></div>';
									$count++;
								}
								echo $edu_html;
							}
						?>
                    </div>
                </div>
                <div class="col-12">
                    <a href="javascript:void(0);" class="add_new_edu button button-primary button-large"> <?php echo __( "Add More Education", 'exertio_framework' ); ?> </a>
                </div>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark Freelancer Featured", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_featured ='';
				$freelancer_featured = get_post_meta($post_id, '_freelancer_is_featured', true);
			?>
            <select name="freelancer_featured">
                <option value="0" <?php if(isset($freelancer_featured) && $freelancer_featured == 0 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Simple", 'exertio_framework' ); ?></option>
                <option value="1" <?php if(isset($freelancer_featured) && $freelancer_featured == 1 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Featured", 'exertio_framework' ); ?></option>
            </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark Freelancer Verified", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$freelancer_verified ='';
				$freelancer_verified = get_post_meta($post_id, '_is_freelancer_verified', true);
			?>
            <select name="freelancer_verified">
                <option value="0" <?php if(isset($freelancer_verified) && $freelancer_verified == 0 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Not verified", 'exertio_framework' ); ?></option>
                <option value="1" <?php if(isset($freelancer_verified) && $freelancer_verified == 1 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Verified", 'exertio_framework' ); ?></option>
            </select>
            </div>
        </div>
        
    <?php }

	
	/* Save the meta box's post metadata. */
	function freelancer_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['freelancer_post_class_nonce'] ) || !wp_verify_nonce( $_POST['freelancer_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		
		if(isset($_POST['freelancer_gender']))
		{
			update_post_meta( $post_id, '_freelancer_gender', $_POST['freelancer_gender']);
			
		}
		
		if(isset($_POST['freelancer_tagline']))
		{
			update_post_meta( $post_id, '_freelancer_tagline', $_POST['freelancer_tagline']);
			
		}
		
		if(isset($_POST['freelancer_dispaly_name']))
		{
			update_post_meta( $post_id, '_freelancer_dispaly_name', $_POST['freelancer_dispaly_name']);
			
		}
		
		if(isset($_POST['freelancer_contact_number']))
		{
			update_post_meta( $post_id, '_freelancer_contact_number', $_POST['freelancer_contact_number']);
			
		}
		
       if(isset($_POST['freelance_type']))
		{
			$company_employees_terms = array((int)$_POST['freelance_type']); 

			update_post_meta( $post_id, '_freelance_type', $_POST['freelance_type']);
			wp_set_post_terms( $post_id, $company_employees_terms, 'freelance-type', false );
			
		}
		if(isset($_POST['freelancer_specialization']))
		{
			$freelancer_specialization_terms = array((int)$_POST['freelancer_specialization']); 

			update_post_meta( $post_id, '_freelancer_specialization', $_POST['freelancer_specialization']);
			wp_set_post_terms( $post_id, $freelancer_specialization_terms, 'freelancer-specialization', false );
			
			update_post_meta($post_id, 'cf_freelancer_specialization', $_POST['freelancer_specialization']);
			
		}
		//saving custom fields
		if (isset($_POST['acf']) && $_POST['acf'] != '' && class_exists('ACF')) 
		{
			exertio_framework_acf_clear_object_cache($post_id);
			acf_update_values($_POST['acf'], $post_id);

		}
		
		if(isset($_POST['english_level']))
		{
			$english_level = array((int)$_POST['english_level']); 
			update_post_meta( $post_id, '_freelancer_english_level', $_POST['english_level']);
			wp_set_post_terms( $post_id, $english_level, 'freelancer-english-level', false );
			
		}
		
		if(isset($_POST['freelancer_language']))
		{
			$freelancer_language = array((int)$_POST['freelancer_language']); 

			update_post_meta( $post_id, '_freelancer_language', $_POST['freelancer_language']);
			wp_set_post_terms( $post_id, $freelancer_language, 'freelancer-languages', false );
			
		}

		if(isset($_POST['freelancer_location']))
		{
			$freelancer_location_terms = array((int)$_POST['freelancer_location']); 
			update_post_meta( $post_id, '_freelancer_location', $_POST['freelancer_location']);
			wp_set_post_terms( $post_id, $freelancer_location_terms, 'freelancer-locations', false );
			
		}

		if(isset($_POST['profile_attachment_ids']))
		{
			update_post_meta( $post_id, '_profile_pic_freelancer_id', $_POST['profile_attachment_ids']);
			
		}
		
		if(isset($_POST['banner_img_id']))
		{
			update_post_meta( $post_id, '_freelancer_banner_id', $_POST['banner_img_id']);
			
		}
		
		if(isset($_POST['freelancer_address']))
		{
			update_post_meta( $post_id, '_freelancer_address', $_POST['freelancer_address']);
			
		}
		
		if(isset($_POST['freelancer_latitude']))
		{
			update_post_meta( $post_id, '_freelancer_latitude', $_POST['freelancer_latitude']);
			
		}
		
		if(isset($_POST['freelancer_longitude']))
		{
			update_post_meta( $post_id, '_freelancer_longitude', $_POST['freelancer_longitude']);
			
		}
		
		
		if(isset($_POST['freelancer_skills']))
		{
			$skill_name = array_unique($_POST['freelancer_skills']);
            if (fl_framework_get_options('freelancer_skills_percentage') == 1) {
                $skill_percent = array_unique($_POST['skills_percent']);
            }else{
                $skill_percent='';
            }
			$integerIDs = array_map('intval', $_POST['freelancer_skills']);
			$integerIDs = array_unique($integerIDs);
			
			for($i=0; $i<count($skill_name); $i++)
			{
				$skill_id = $skill_name[$i];
				$percent = $skill_percent[$i];
				$skills[] = array(
					"skill" => $skill_id,
					"percent" =>$percent
				);
			}
			 $encoded_skills =  json_encode($skills, JSON_UNESCAPED_UNICODE);
			 
			wp_set_post_terms( $post_id, $integerIDs, 'freelancer-skills', false );
			update_post_meta( $post_id, '_freelancer_skills', $encoded_skills );
			
		}
		else if($_POST['freelancer_skills'] == '')
		{
			wp_set_post_terms( $post_id, '', 'freelancer-skills', false );
			update_post_meta( $post_id, '_freelancer_skills', '' );
		}
		if(isset($_POST['award_name']) && isset($_POST['award_date']))
		{
			$award_name = $_POST['award_name'];
			$award_date = $_POST['award_date'];
			$awar_img = $_POST['award_img_id'];
			
			for($i=0; $i<count($award_name); $i++)
			{
				$name = $award_name[$i];
				$date = $award_date[$i];
				$img = $awar_img[$i];
				$awards[] = array(
					"award_name" => $name,
					"award_date" =>$date,
					"award_img" =>$img,
				);
			}
			$encoded_awards =  json_encode($awards, JSON_UNESCAPED_UNICODE);

			update_post_meta( $post_id, '_freelancer_awards', $encoded_awards );
		}
		else if($_POST['award_name'] == '' && $_POST['award_date'] == '')
		{
			update_post_meta( $post_id, '_freelancer_awards', '' );	
		}
		
		if(isset($_POST['project_name']) && isset($_POST['project_url']))
		{
			$project_name = $_POST['project_name'];
			$project_url = $_POST['project_url'];
			$project_img = $_POST['project_img_id'];
			
			for($i=0; $i<count($project_name); $i++)
			{
				$name = $project_name[$i];
				$date = $project_url[$i];
				$img = $project_img[$i];
				$projects[] = array(
					"project_name" => $name,
					"project_url" =>$date,
					"project_img" =>$img,
				);
			}
			$encoded_projects =  json_encode($projects, JSON_UNESCAPED_UNICODE);

			update_post_meta( $post_id, '_freelancer_projects', $encoded_projects );
		}
		else if($_POST['project_name'] == '' && $_POST['project_url'] =='')
		{
			update_post_meta( $post_id, '_freelancer_projects', '' );
		}
		
		if(isset($_POST['expe_name']))
		{
			$expe_name = $_POST['expe_name'];
			$expe_company_name = $_POST['expe_company_name'];
			$expe_start_date = $_POST['expe_start_date'];
			$expe_end_date = $_POST['expe_end_date'];
			$expe_desc = $_POST['expe_details'];
			
			for($i=0; $i<count($expe_name); $i++)
			{
				$expe_names = $expe_name[$i];
				$expe_company_names = $expe_company_name[$i];
				$expe_start_dates = $expe_start_date[$i];
				$expe_end_dates = $expe_end_date[$i];
				$expe_descs = $expe_desc[$i];
				$experience[] = array(
					"expe_name" => $expe_names,
					"expe_company_name" =>$expe_company_names,
					"expe_start_date" =>$expe_start_dates,
					"expe_end_date" =>$expe_end_dates,
					"expe_details" =>$expe_descs,
				);
			}
			$encoded_experience =  json_encode($experience, JSON_UNESCAPED_UNICODE);

			update_post_meta( $post_id, '_freelancer_experience', $encoded_experience );
		}
		else
		{
			$encoded_experience =  '';
			update_post_meta( $post_id, '_freelancer_experience', $encoded_experience );
		}
		
		
		
		if(isset($_POST['edu_name']))
		{
			$edu_name = $_POST['edu_name'];
			$edu_inst_name = $_POST['edu_inst_name'];
			$edu_start_date = $_POST['edu_start_date'];
			$edu_end_date = $_POST['edu_end_date'];
			$edu_desc = $_POST['edu_details'];
			
			for($i=0; $i<count($edu_name); $i++)
			{
				$name = $edu_name[$i];
				$inst_name = $edu_inst_name[$i];
				$start_date = $edu_start_date[$i];
				$end_date = $edu_end_date[$i];
				$desc = $edu_desc[$i];
				$education[] = array(
					"edu_name" => $name,
					"edu_inst_name" =>$inst_name,
					"edu_start_date" =>$start_date,
					"edu_end_date" =>$end_date,
					"edu_details" =>$desc,
				);
			}
			$encoded_education =  json_encode($education, JSON_UNESCAPED_UNICODE);

			update_post_meta( $post_id, '_freelancer_education', $encoded_education );
		}
		else
		{
			$encoded_education =  '';
			update_post_meta( $post_id, '_freelancer_education', $encoded_education );
		}
		if(isset($_POST['freelancer_featured']))
		{
			update_post_meta( $post_id, '_freelancer_is_featured', $_POST['freelancer_featured']);
			
		}
		if(isset($_POST['freelancer_verified']))
		{
			update_post_meta( $post_id, '_is_freelancer_verified', $_POST['freelancer_verified']);
			
		}
	}	
}


	
	
	/*SIDEBAR META BOXES*/
	
	
	add_action( 'load-post.php', 'freelancer_sidebar_boxes_setup' );
	add_action( 'load-post-new.php', 'freelancer_sidebar_boxes_setup' );
	
	
	function freelancer_sidebar_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'freelancer_sidebar_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'freelancer_sidebar_save_post_class_meta', 10, 2 );
	  
	}

	//add_action( 'admin_enqueue_scripts', 'attachment_wp_admin_enqueue' );
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function freelancer_sidebar_meta_boxes() {
	
	  add_meta_box(
		'freelancer-sidebar-post-class',      // Unique ID
		esc_html__( 'Package Detail', 'exertio_framework' ),    // Title
		'freelancer_sidebar_meta_box',   // Callback function
		'freelancer',
		'side',         // Context
		'default'         // Priority
	  );
	}
	
	function freelancer_sidebar_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'freelancer_sidebar_post_class_nonce' ); 
	  
		$post_id =  $post->ID;

		?>
        <div class="sidebar-row">
            <p><?php echo __( "Projects Credits", 'exertio_framework' ); ?></p>
				<?php
					$project_credits = get_post_meta( $post_id , '_project_credits', true);
				?>
				<input type="text" name="project_credits" value="<?php echo esc_attr($project_credits); ?>" placeholder="<?php echo __( " Projects credits", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only. -1 for unlimited", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Simple Services", 'exertio_framework' ); ?></p>
				<?php
					$simple_services = get_post_meta( $post_id , '_simple_services', true);
				?>
				<input type="text" name="simple_services" value="<?php echo esc_attr($simple_services); ?>" placeholder="<?php echo __( " Simple Services", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only. -1 for unlimited", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Simple Projects Expiry", 'exertio_framework' ); ?></p>
				<?php
					$simple_service_expiry = get_post_meta( $post_id , '_simple_service_expiry', true);
				?>
				<input type="text" name="simple_service_expiry" value="<?php echo esc_attr($simple_service_expiry); ?>" placeholder="<?php echo __( " Simple service expiry", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only in days. -1 for never Expire", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Featured Projects", 'exertio_framework' ); ?></p>
				<?php
					$featured_services = get_post_meta( $post_id , '_featured_services', true);
				?>
				<input type="text" name="featured_services" value="<?php echo esc_attr($featured_services); ?>" placeholder="<?php echo __( "Allowed Featured services", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only. -1 for unlimited", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Featured Services Expiry", 'exertio_framework' ); ?></p>
				<?php
					$featured_services_expiry = get_post_meta( $post_id , '_featured_services_expiry', true);
				?>
				<input type="text" name="featured_services_expiry" value="<?php echo esc_attr($featured_services_expiry); ?>" placeholder="<?php echo __( " Featured Services Expiry", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only in days. -1 for never expire", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
            <p><?php echo __( "Package Expiry", 'exertio_framework' ); ?></p>
				<?php
					$freelancer_package_expiry = get_post_meta( $post_id , '_freelancer_package_expiry', true);
				?>
				<input type="text" name="freelancer_package_expiry" value="<?php echo esc_attr($freelancer_package_expiry); ?>" placeholder="<?php echo __( " Package expiry", "exertio_framework" ); ?>">
				<small><?php echo __( "Integers only in days. -1 for never expire", 'exertio_framework' ); ?></small>
        </div>
		<div class="sidebar-row">
			<?php
			   $return_msg = '';
				$freelancer_package_expiry_date = get_post_meta( $post_id , '_freelancer_package_expiry_date', true);
				 if(isset($freelancer_package_expiry_date) && $freelancer_package_expiry_date == -1)
				 {
					 $return_msg = __( "Never Expire", 'exertio_framework' );
				 }
				 else if(isset($freelancer_package_expiry_date) && $freelancer_package_expiry_date != '')

				 {
					$return_msg =  date_i18n( get_option( 'date_format' ), strtotime($freelancer_package_expiry_date));
				 }
			?>
            <p><?php echo __( "Package Expiry: ", 'exertio_framework' ).'<b>'.$return_msg.'</b>'; ?></p>
        </div>
    <?php }

	
	/* Save the meta box's post metadata. */
	function freelancer_sidebar_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['freelancer_sidebar_post_class_nonce'] ) || !wp_verify_nonce( $_POST['freelancer_sidebar_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
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
			$expiry_days = $_POST['freelancer_package_expiry'];
			update_post_meta( $post_id, '_freelancer_package_expiry', $expiry_days);
			
			if(isset($expiry_days) && $expiry_days == -1)
			{
				update_post_meta( $post_id, '_freelancer_package_expiry_date', -1);
			}
			else
			{
				$c_dATE = DATE("d-m-Y");

				$employer_package_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $expiry_days days"));

				update_post_meta( $post_id, '_freelancer_package_expiry_date', $employer_package_expiry_date);
			}
			
		}
		
		
	}








add_filter( 'post_row_actions', 'exertio_remove_row_actions_post', 10, 2 );
function exertio_remove_row_actions_post( $actions, $post ) {
    if( $post->post_type === 'freelancer' || $post->post_type === 'employer' ) {
        unset( $actions['clone'] );
        unset( $actions['trash'] );
    }
    return $actions;
}

add_action( 'admin_head', function () {
    $current_screen = get_current_screen();

    // Hides the "Move to Trash" link on the post edit page.
    if ( 'post' === $current_screen->base && 'freelancer' === $current_screen->post_type || 'post' === $current_screen->base && 'employer' === $current_screen->post_type ) :
    ?>
        <style>#delete-action, #bulk-action-selector-top option[value="trash"] { display: none; }  </style>
    <?php
    endif;
	if ('freelancer' === $current_screen->post_type || 'employer' === $current_screen->post_type) :
    ?>
        <style>.row-actions .trash, #bulk-action-selector-top option[value="trash"] { display: none; }</style>
    <?php
    endif;

} );