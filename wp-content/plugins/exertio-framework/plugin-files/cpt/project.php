<?php
// Register post  type and taxonomy
add_action('init', 'fl_themes_custom_types', 0);

function fl_themes_custom_types() {
	 $args = array(
			'public' => true,
			'labels' => array(
							'name' => __('Projects', 'exertio_framework'),
							'singular_name' => __('Project', 'exertio_framework'),
							'menu_name' => __('Project', 'exertio_framework'),
							'name_admin_bar' => __('Project', 'exertio_framework'),
							'add_new' => __('Add New Project', 'exertio_framework'),
							'add_new_item' => __('Add New Project', 'exertio_framework'),
							'new_item' => __('New Project', 'exertio_framework'),
							'edit_item' => __('Edit Project', 'exertio_framework'),
							'view_item' => __('View Project', 'exertio_framework'),
							'all_items' => __('All Projects', 'exertio_framework'),
							'search_items' => __('Search Projects', 'exertio_framework'),
							'not_found' => __('No Project Found.', 'exertio_framework'),
							),
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon'           => FL_PLUGIN_URL.'/images/money-bag-with-dollar-symbol.png',
			'rewrite' => array('with_front' => false, 'slug' => 'projects')
		);
	register_post_type('projects', $args);







	add_filter('manage_edit-projects_columns', 'term_columns_id');
    add_action('manage_projects_posts_custom_column', 'term_custom_id_columns', 5, 2);
 
 
	function term_columns_id($defaults){
		unset($defaults['taxonomy-project-type']);
		
		unset($defaults['taxonomy-english-level']);
		unset($defaults['taxonomy-project-level']);
		unset($defaults['taxonomy-languages']);
		unset($defaults['taxonomy-locations']);
		unset($defaults['taxonomy-labels']);
		unset($defaults['taxonomy-freelancer-type']);
		unset($defaults['date']);


		$defaults['status'] =  __('Status', 'exertio_framework');
		$defaults['price'] =  __('Price', 'exertio_framework');
		$defaults['admin-share'] =  __('Admin Share', 'exertio_framework');
		$defaults['freelancer-earning'] =  __('Freelancer Share', 'exertio_framework');
		$defaults['author'] =  __('Author', 'exertio_framework');
		$defaults['date'] =  __('Date', 'exertio_framework');

		return $defaults;
		
	}
	function term_custom_id_columns($column_name, $id)
	{
		global $wpdb;
		$table = EXERTIO_PROJECT_LOGS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT `freelacner_earning` , `admin_commission` FROM ".$table." WHERE `project_id` = '" . $id . "' ";
			$result = $wpdb->get_results($query);


			$freelancer_earning = isset($result[0]->freelacner_earning) ? $result[0]->freelacner_earning : '' ;
			$admin_earning = isset($result[0]->admin_commission) ? $result[0]->admin_commission : '' ;
		}
		if($column_name === 'status')
		{
			echo get_post_status($id);
		}
		if($column_name === 'price')
		{
			echo fl_price_separator(get_post_meta( $id, '_project_cost', true ));  
		}
		if($column_name === 'admin-share')
		{
			echo fl_price_separator($admin_earning);  
		}
		if($column_name === 'freelancer-earning')
		{
			echo fl_price_separator($freelancer_earning);  
		}
	}
	
	
	
	/*
	 * ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
	 * https://gist.github.com/906872
	 */
	add_filter("manage_edit-projects_sortable_columns", 'projects_sort');
	function projects_sort($columns) {
		$custom = array(
			'project-categories' 	=> 'project-categories',
			'price' 		=> 'price',
			'author' 		=> 'author'
		);
		return wp_parse_args($custom, $columns);
	}
	
		/* PROJECT CATEGORY TAXONOMY */
		register_taxonomy('project-categories', array('projects'), array(
			'hierarchical' => true,
			'show_ui' => true,
			'label' => __('Project Categories', 'exertio_framework'),
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'projects-categories'),
		));
		
		$project_duration_labels = array(
			'name'                       => __( 'Project Duration', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Project Duration', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Project Duration', 'exertio_framework' ),
			'all_items'                  => __( 'All Project Duration', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Project Duration', 'exertio_framework' ),
			'update_item'                => __( 'Update Project Duration', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Project Duration', 'exertio_framework' ),
			'new_item_name'              => __( 'New Project Duration Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Project Duration with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Project Duration', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Project Duration', 'exertio_framework' ),
			'not_found'                  => __( 'No Project Duration found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Project Duration', 'exertio_framework' ),
		);
		register_taxonomy('project-duration', array('projects'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $project_duration_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'project-duration'),
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
		register_taxonomy('freelancer-type', array('projects'), array(
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
		register_taxonomy('english-level', array('projects'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $elglish_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'english-level'),
		));		
		
		
		$project_level_labels = array(
			'name'                       => __( 'Project Level', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Project Level', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Project Level', 'exertio_framework' ),
			'all_items'                  => __( 'All Project Level', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Project Level', 'exertio_framework' ),
			'update_item'                => __( 'Update Project Level', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Project Level', 'exertio_framework' ),
			'new_item_name'              => __( 'New Project Level Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Project Levels with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Project Level', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Project Levels', 'exertio_framework' ),
			'not_found'                  => __( 'No Project Level found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Project Level', 'exertio_framework' ),
		);
		register_taxonomy('project-level', array('projects'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $project_level_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'project-level'),
		));
		
		$projetct_labels = array(
			'name'                       => __( 'Labels', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Labels', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Labels', 'exertio_framework' ),
			'all_items'                  => __( 'All Labels', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Label', 'exertio_framework' ),
			'update_item'                => __( 'Update Label', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Label', 'exertio_framework' ),
			'new_item_name'              => __( 'New Label Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Labels with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Labels', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Labels', 'exertio_framework' ),
			'not_found'                  => __( 'No Label found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Labels', 'exertio_framework' ),
		);
		register_taxonomy('labels', array('projects'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $projetct_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'labels'),
		));
		
		add_filter("manage_edit-labels_columns", 'theme_columns'); 
		function theme_columns($theme_columns) {
			$new_columns = array(
				'cb' => '<input type="checkbox" />',
				'name' => __('Name'),
				'label_color' => 'color',
		      'description' => __('Description'),
				'slug' => __('Slug'),
				'posts' => __('Posts')
				);
			return $new_columns;
		}
		
		add_filter("manage_labels_custom_column", 'labels_columns', 10, 3);
		function labels_columns($out, $column_name, $theme_id) {
			$term = get_term($theme_id, 'labels' );
			$terms_value = get_term_meta($term->term_taxonomy_id,'_label_color', true);
			switch ($column_name) {
				case 'label_color': 
					// get header image url
					$out .= "<div style='width:20px; height:20px; background-color:#$terms_value; border-radius:50%;'> </div>"; 
					//$out .= ;//"<span style=' width:10px; height:10px; background-color:{$data['label_color']};'> </span>"; 
					break;
		 
				default:
					break;
			}
			return $out;    
		}
		
		$skill_labels = array(
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
			'not_found'                  => __( 'No Skill found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Skills', 'exertio_framework' ),
		);
		register_taxonomy('skills', array('projects'), array(
			'hierarchical' => false,
			//'show_ui' => true,
			'labels' => $skill_labels,
			'show_admin_column' => true,
			'query_var' => true,
			//'meta_box_cb' => false,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'skills'),
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
		register_taxonomy('languages', array('projects'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $languages_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'languages'),
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
		register_taxonomy('locations', array('projects'), array(
			'hierarchical' => true,
			'show_ui' => true,
			'labels' => $locations_labels,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'locations'),
		));
		
		/* CATEGORY IMAGES */
		
		
		if( ! class_exists( 'project_category_Taxonomy_Images' ) ) {
			class project_category_Taxonomy_Images {
				public function __construct() {
				 //
				}
				
				/**
				 * Initialize the class and start calling our hooks and filters
				 */
				public function init() {
				 // Image actions
				 add_action( 'project-categories_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
				 add_action( 'created_project-categories', array( $this, 'save_category_image' ), 10, 2 );
				 add_action( 'project-categories_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
				 add_action( 'edited_project-categories', array( $this, 'updated_category_image' ), 10, 2 );
				 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
				 add_action( 'admin_footer', array( $this, 'add_script' ) );
				}
				
				public function load_media() {
				 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'project-categories' ) {
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
				   <label for="project_category-taxonomy-image-id"><?php __('Image', 'exertio_framework'); ?></label>
				   <input type="hidden" id="project_category-taxonomy-image-id" name="project_category-taxonomy-image-id" class="custom_media_url" value="">
				   <div id="category-image-wrapper"></div>
				   <p>
					 <input type="button" class="button button-secondary project_category_tax_media_button" id="project_category_tax_media_button" name="project_category_tax_media_button" value="<?php echo __('Add Image', 'exertio_framework'); ?>" />
					 <input type="button" class="button button-secondary project_category_tax_media_remove" id="project_category_tax_media_remove" name="project_category_tax_media_remove" value="<?php echo __('Remove Image', 'exertio_framework'); ?>" />
				   </p>
				 </div>
				<?php }
				
				/**
				* Save the form field
				* @since 1.0.0
				*/
				public function save_category_image( $term_id, $tt_id ) {
				 if( isset( $_POST['project_category-taxonomy-image-id'] ) && '' !== $_POST['project_category-taxonomy-image-id'] ){
				   add_term_meta( $term_id, 'project_category-taxonomy-image-id', absint( $_POST['project_category-taxonomy-image-id'] ), true );
				 }
				}
				
				/**
				 * Edit the form field
				 * @since 1.0.0
				 */
				public function update_category_image( $term, $taxonomy ) { ?>
				  <tr class="form-field term-group-wrap">
					<th scope="row">
					  <label for="project_category-taxonomy-image-id"><?php echo __('Image', 'exertio_framework'); ?></label>
					</th>
					<td>
					  <?php $image_id = get_term_meta( $term->term_id, 'project_category-taxonomy-image-id', true ); ?>
					  <input type="hidden" id="project_category-taxonomy-image-id" name="project_category-taxonomy-image-id" value="<?php echo esc_attr( $image_id ); ?>">
					  <div id="category-image-wrapper">
						<?php if( $image_id ) { ?>
						  <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
						<?php } ?>
					  </div>
					  <p>
						<input type="button" class="button button-secondary project_category_tax_media_button" id="project_category_tax_media_button" name="project_category_tax_media_button" value="<?php echo __('Add Image', 'exertio_framework'); ?>" />
						<input type="button" class="button button-secondary project_category_tax_media_remove" id="project_category_tax_media_remove" name="project_category_tax_media_remove" value="<?php echo __('Remove Image', 'exertio_framework'); ?>" />
					  </p>
					</td>
				  </tr>
				<?php }
				
				/**
				* Update the form field value
				* @since 1.0.0
				*/
				public function updated_category_image( $term_id, $tt_id ) {
				 if( isset( $_POST['project_category-taxonomy-image-id'] ) && '' !== $_POST['project_category-taxonomy-image-id'] ){
				   update_term_meta( $term_id, 'project_category-taxonomy-image-id', absint( $_POST['project_category-taxonomy-image-id'] ) );
				 } else {
				   update_term_meta( $term_id, 'project_category-taxonomy-image-id', '' );
				 }
				}
				
				/**
				* Enqueue styles and scripts
				* @since 1.0.0
				*/
				public function add_script() {
				 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'project-categories' ) {
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
						   $('#project_category-taxonomy-image-id').val(attachment.id);
						   $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
						   $( '#category-image-wrapper .custom_media_image' ).attr( 'src',attachment.url ).css( 'display','block' );
						 } else {
						   return _orig_send_attachment.apply( button_id, [props, attachment] );
						 }
					   }
					   wp.media.editor.open(button); return false;
					 });
				   }
				   ct_media_upload('.project_category_tax_media_button.button');
				   $('body').on('click','.project_category_tax_media_remove',function(){
					 $('#project_category-taxonomy-image-id').val('');
					 $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
				   });
				   
				   $(document).ajaxComplete(function(event, xhr, settings) {
					 var queryStringArr = settings.data.split('&');
					 if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
					   var xml = xhr.responseXML;
					   $response = $(xml).find('term_id').text();
					   if($response!=""){
						 // Clear the thumb image
						 $('#category-image-wrapper').html('');
					   }
					  }
					});
				  });
				</script>
				<?php }
			}
			$project_category_Taxonomy_Images = new project_category_Taxonomy_Images();
			$project_category_Taxonomy_Images->init(); 
		}
		
		
		if( ! class_exists( 'locations_Taxonomy_Images' ) ) {
			class locations_Taxonomy_Images {
			
			public function __construct() {
			 //
			}
			
			/**
			 * Initialize the class and start calling our hooks and filters
			 */
			 public function init() {
			 // Image actions
			 add_action( 'locations_add_form_fields', array( $this, 'add_category_image' ), 10, 2 );
			 add_action( 'created_locations', array( $this, 'save_category_image' ), 10, 2 );
			 add_action( 'locations_edit_form_fields', array( $this, 'update_category_image' ), 10, 2 );
			 add_action( 'edited_locations', array( $this, 'updated_category_image' ), 10, 2 );
			 add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
			 add_action( 'admin_footer', array( $this, 'add_script' ) );
			}
			
			public function load_media() {
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'locations' ) {
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
			 if( ! isset( $_GET['taxonomy'] ) || $_GET['taxonomy'] != 'locations' ) {
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
			$locations_Taxonomy_Images = new locations_Taxonomy_Images();
			$locations_Taxonomy_Images->init(); 
		}	
	
	
	
	/* COLOR PICKET FOR THE LABELS */
	
	function colorpicker_field_add_new_labels( $taxonomy ) {
	
	  ?>
	
		<div class="form-field term-colorpicker-wrap">
			<label for="term-colorpicker"><?php echo __( 'Label Color', 'exertio_framework' ); ?></label>
			<input name="_label_color" value="#ffffff" class="colorpicker" id="term-colorpicker" />
			<p> <?php echo __( 'Provide color of your label', 'exertio_framework' ); ?></p>
		</div>
	
	  <?php
	
	}
	add_action( 'labels_add_form_fields', 'colorpicker_field_add_new_labels' );
	
	
	function colorpicker_field_edit_labels( $term ) {
	
		$color = get_term_meta( $term->term_id, '_label_color', true );
		$color = ( ! empty( $color ) ) ? "#{$color}" : '#ffffff';
	
	  ?>
	
		<tr class="form-field term-colorpicker-wrap">
			<th scope="row"><label for="term-colorpicker"><?php echo __( 'Label Color', 'exertio_framework' ); ?></label></th>
			<td>
				<input name="_label_color" value="<?php echo $color; ?>" class="colorpicker" id="term-colorpicker" />
				<p class="description"><?php echo __( 'Provide color of your label', 'exertio_framework' ); ?></p>
			</td>
		</tr>
	
	  <?php
	
	
	}
	add_action( 'labels_edit_form_fields', 'colorpicker_field_edit_labels' );
	
	
	function save_termmeta( $term_id ) {
		// Save term color if possible
		if( isset( $_POST['_label_color'] ) && ! empty( $_POST['_label_color'] ) ) {
				update_term_meta( $term_id, '_label_color', sanitize_hex_color_no_hash( $_POST['_label_color'] ) );
		} 
		else 
		{
			delete_term_meta( $term_id, '_label_color' );
		}
	
	}
	add_action( 'created_labels', 'save_termmeta' );  
	add_action( 'edited_labels',  'save_termmeta' ); 
	
	function labels_colorpicker_enqueue( $taxonomy ) {

		if( null !== ( $screen = get_current_screen() ) && 'edit-labels' !== $screen->id ) {
			return;
		}
	
		// Colorpicker Scripts
		wp_enqueue_script( 'wp-color-picker' );
	
		// Colorpicker Styles
		wp_enqueue_style( 'wp-color-picker' );
	
	}
	add_action( 'admin_enqueue_scripts', 'labels_colorpicker_enqueue' );
	
	function colorpicker_init_inline() {
		if( null !== ( $screen = get_current_screen() ) && 'edit-labels' !== $screen->id ) {
			return;
		}
	
	  ?>
	
		<script>
			jQuery( document ).ready( function( $ ) {
	
				$( '.colorpicker' ).wpColorPicker();
	
			} ); // End Document Ready JQuery
		</script>
	
	  <?php
	
	}
	add_action( 'admin_print_scripts', 'colorpicker_init_inline', 20 );


function is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}



	add_action( 'load-post.php', 'project_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'project_post_meta_boxes_setup' );
	
	
	function project_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'project_add_post_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'project_save_post_class_meta', 10, 2 );
	  
	}

	//add_action( 'admin_enqueue_scripts', 'attachment_wp_admin_enqueue' );
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function project_add_post_meta_boxes() {
	
	  add_meta_box(
		'project-post-class',      // Unique ID
		esc_html__( 'Add Project Detail', 'exertio_framework' ),    // Title
		'project_post_class_meta_box',   // Callback function
		'projects',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	
	function project_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'project_post_class_nonce' ); 
		
		//print_r($post);
		$post_id =  $post->ID;
		
		$custom_field_dispaly = 'style=display:none;';
		if(class_exists('ACF'))
		{
			$selected_custom_data = exertio_framework_fields_by_listing_id($post_id);
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
            <div class="col-3"> <label><?php echo __( "Project Categories", 'exertio_framework' ); ?></label> </div>
            <div class="col-3">
			  <?php
              $category_taxonomies = exertio_get_terms('project-categories');
                if ( !empty($category_taxonomies) )
                {
                    
                    echo '<select name="project_category" class="form-control general_select" id="exertio_cat_parent">'.get_hierarchical_terms('project-categories', '_project_category', $post_id ).'</select>';
                }
                else
                {
                    echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
                }
                ?>
            </div>
        </div>
		<div class="custom-row additional-fields" <?php echo esc_attr($custom_field_dispaly); ?> >
            <div class="col-3"> <label><?php echo __( "Custom Fields", 'exertio_framework' ); ?></label> </div>
            <div class="col-3">
				<div class="additional-fields-container">
					<?php
						if(is_array($selected_custom_data) && !empty($selected_custom_data)) {
							if ($post_id != '' && class_exists('ACF')) {
								$custom_fields_html = apply_filters('exertio_framework_acf_frontend_html', '', $selected_custom_data);
								echo $custom_fields_html;
							}
						}
					?>
				</div>
			</div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label> <?php echo __( "Project Level ", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $level_taxonomies = exertio_get_terms('project-level');
            if ( !empty($level_taxonomies) )
            {
				$project_level = get_post_meta($post_id, '_project_level', true);
                $level = '<select name="project_level">';
				$level .= '<option value=""> '. __( "Select Level", "exertio_framework" ) .'</option>';
                foreach( $level_taxonomies as $level_taxonomy ) {
					if($level_taxonomy->term_id == $project_level){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $level_taxonomy->parent == 0 ) {
                         $level .= '<option value="'. esc_html( $level_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $level_taxonomy->name ) .'</option>';
                        $level.='</option>';
                    }
                }
                $level.='</select>';
                echo $level;
            }
            else
            {
                echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
                <p> <?php echo __( "Select project level ", 'exertio_framework' ); ?></p>
            </div>
        </div>
        <?php 
			$project_type = get_post_meta($post_id, '_project_type', true);
			$show ='style=display:none;';
			$hide = 'style=display:flex;';
			if(isset($project_type) && $project_type == 'hourly' || isset($project_type) && $project_type == 2)
			{
				$show = 'style=display:flex;';
				$hide = 'style=display:none;';	
			}
		?>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Project Type", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
                <select name="project_type" class="form-control general_select project-type" required >
                    <option value=""> <?php echo esc_html__( "Select Project Type", "exertio_framework" ); ?></option>
                    <?php if(fl_framework_get_options('project_type_allowed') == 2 && (fl_framework_get_options('project_type_allowed') == 2)){ ?>
                        <option value="2" <?php if($project_type== 'hourly' || $project_type== 2 ) {echo 'selected';} ?>><?php echo esc_html__('Hourly','exertio_theme'); ?></option>
                    <?php }?>
                    <option value="1" <?php if($project_type== 'fixed' || $project_type== 1) {echo 'selected="selected"';} ?>><?php echo esc_html__('Fixed','exertio_framework'); ?></option>
                </select>
            </div>
        </div>
        <div class="custom-row fixed-field" <?php echo esc_attr($hide); ?> >
            <div class="col-3"><label><?php echo __( "Cost", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
                <input type="text" class="form-control" name="project_cost" value="<?php echo esc_attr(get_post_meta($post_id, '_project_cost', true));?>">
            </div>
        </div>
        <div class="custom-row hourly-field"  <?php echo esc_attr($show); ?> >
            <div class="col-3"><label><?php echo __( "Per Hour Price", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
                <input type="text" class="form-control" name="project_cost_hourly" value="<?php echo esc_attr(get_post_meta($post_id, '_project_cost', true));?>">
            </div>
        </div>
        <div class="custom-row hourly-field"  <?php echo esc_attr($show); ?> >
            <div class="col-3"><label><?php echo __( "Estimated Hours", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
                <input type="text" class="form-control" name="estimated_hours" value="<?php echo esc_attr(get_post_meta($post_id, '_estimated_hours', true));?>">
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Project Duration", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $duration_taxonomies = exertio_get_terms('project-duration');
            if ( !empty($duration_taxonomies) )
            {
				$project_duration = get_post_meta($post_id, '_project_duration', true);
                $duration = '<select name="project_duration">';
				$duration .= '<option value=""> '. __( "Select Project Duration", "exertio_framework" ) .'</option>';
                foreach( $duration_taxonomies as $duration_taxonomy ) {
					if($duration_taxonomy->term_id == $project_duration){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $duration_taxonomy->parent == 0 ) {
                        //$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
                         $duration .= '<option value="'. esc_attr( $duration_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $duration_taxonomy->name ) .'</option>';
                        $duration.='</option>';
                    }
                }
                $duration.='</select>';
                echo $duration;
            }
            else
            {
                echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
                <p> <?php echo __( "Mention expected project duration", 'exertio_framework' ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Freelancer Type", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
				<?php
                $freelancer_taxonomies = exertio_get_terms('freelancer-type');
            
                if ( !empty($freelancer_taxonomies) )
                {
                    $project_freelancer = get_post_meta($post_id, '_project_freelancer_type', true);
                    $freelancer = '<select name="project_freelancer_type">';
                    $freelancer .= '<option value=""> '. __( "Select Freelancer Type", "exertio_framework" ) .'</option>';
                    foreach( $freelancer_taxonomies as $freelancer_taxonomy ) {
                        if($freelancer_taxonomy->term_id == $project_freelancer){ $selected = 'selected ="selected"';}else{$selected = ''; }
                        if( $freelancer_taxonomy->parent == 0 ) {
                            //$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
                             $freelancer .= '<option value="'. esc_attr( $freelancer_taxonomy->term_id ) .'" '.$selected.' >
                                    '. esc_html( $freelancer_taxonomy->name ) .'</option>';
                            $freelancer.='</option>';
                        }
                    }
                    $freelancer.='</select>';
                    echo $freelancer;
                }
                else
                {
                    echo __( "No values available. Please consider adding values first", 'exertio_framework' );
                }
                ?>
                <p> <?php echo __( "What type of freelancer do you require", 'exertio_framework' ); ?></p>
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "English Level", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
            $eng_level_taxonomies = exertio_get_terms('english-level');
        
            if ( !empty($eng_level_taxonomies) )
            {
				$project_eng_level = get_post_meta($post_id, '_project_eng_level', true);
                $eng_level = '<select name="project_english_level">';
				$eng_level .= '<option value=""> '. __( "Select English Level", "exertio_framework" ) .'</option>';
                foreach( $eng_level_taxonomies as $eng_level_taxonomy ) {
					if($eng_level_taxonomy->term_id == $project_eng_level){ $selected = 'selected ="selected"';}else{$selected = ''; }
                    if( $eng_level_taxonomy->parent == 0 ) {
                        //$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
                         $eng_level .= '<option value="'. esc_attr( $eng_level_taxonomy->term_id ) .'" '.$selected.'>
                                '. esc_html( $eng_level_taxonomy->name ) .'</option>';
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
                <p> <?php echo __( "How much grip should the applicant have on the English language.", 'exertio_framework' ); ?></p>
            </div>
        </div>
        
        
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Project Label", 'exertio_framework' ); ?></label> </div>
            <div class="col-9">
            <ul>
            <?php
			$labels = wp_get_post_terms($post_id, 'labels', array( 'fields' => 'all' ));
            $pro_labels_taxonomies = exertio_get_terms('labels');
			
            if ( !empty($pro_labels_taxonomies) )
            {
                foreach( $pro_labels_taxonomies as $pro_labels_taxonomy ) {
					if(in_array($pro_labels_taxonomy, $labels) ){ $labels_selected = 'checked ="checked"';}else{ $labels_selected='';}
                    if( $pro_labels_taxonomy->parent == 0 ) {
                        ?>
                        <li class="checkbox-li">
                            <span class="checkboxes"> <input type="checkbox" name="project_labels[]" value="<?php echo esc_attr( $pro_labels_taxonomy->term_id ) ?>" <?php echo $labels_selected; ?> > <?php echo esc_attr( $pro_labels_taxonomy->name ) ?></span>
                        </li>
                        <?php
                    }
                }
            }
            else
            {
                echo __( "No, values available. Please consider adding values first", 'exertio_framework' );
            }
            ?>
            </ul>
             <p><?php __( "Leave it empty if you do not want to show", 'exertio_framework' ); ?></p>   
            </div>
        </div>
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Skills", 'exertio_framework' ); ?> </label></div>
            <div class="col-9">
                <ul>
                <?php
                $pro_skills_taxonomies = exertio_get_terms('skills');
                $skills = wp_get_post_terms($post_id, 'skills', array( 'fields' => 'all' ));
                if ( !empty($pro_skills_taxonomies) )
                {
                    foreach( $pro_skills_taxonomies as $pro_skills_taxonomy ) {
                        if(in_array($pro_skills_taxonomy, $skills) ){ $skill_selected = 'checked ="checked"';}else{ $skill_selected='';}
                        if( $pro_skills_taxonomy->parent == 0 ) {
                            ?>
                            <li class="checkbox-li">
                                <span class="checkboxes"> <input type="checkbox" name="project_skills[]" <?php echo $skill_selected; ?> value="<?php echo esc_attr( $pro_skills_taxonomy->term_id ) ?>"> <?php echo esc_attr( $pro_skills_taxonomy->name ) ?></span>
                            </li>
                            <?php
                        }
                    }
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
            <div class="col-3"><label><?php echo __( "Languages", 'exertio_framework' ); ?> </label></div>
            <div class="col-9">
            <ul>
            <?php
			$languages = wp_get_post_terms($post_id, 'languages', array( 'fields' => 'all' ));
            $pro_lang_taxonomies = exertio_get_terms('languages');
            if ( !empty($pro_lang_taxonomies) )
            {
                foreach( $pro_lang_taxonomies as $pro_lang_taxonomy ) {
					if(in_array($pro_lang_taxonomy, $languages) ){ $languages_selected = 'checked ="checked"';}else{ $languages_selected='';}
                    if( $pro_lang_taxonomy->parent == 0 ) {
                        ?>
                        <li class="checkbox-li">
                            <span class="checkboxes"> <input type="checkbox" name="languages[]" <?php echo $languages_selected; ?> value="<?php echo esc_attr( $pro_lang_taxonomy->term_id ) ?>"> <?php echo esc_attr( $pro_lang_taxonomy->name ) ?></span>
                        </li>
                        <?php
                    }
                }
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
            <div class="col-3"><label><?php echo __( "Location", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
				$location_taxonomies = exertio_get_terms('locations');
				if ( !empty($location_taxonomies) )
				{
					echo '<select name="project_location" class="form-control general_select">'.get_hierarchical_terms('locations','_project_location', $post_id ).'</select>';
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
                        $project_attachment_ids = get_post_meta($post_id, '_project_attachment_ids', true);
                        if(isset($project_attachment_ids) && $project_attachment_ids !='')
                        {
                        $attachment_ids_array = explode(",",$project_attachment_ids);
                        
                        ?>
                                <?php
                                    foreach($attachment_ids_array as $data)
                                    {
                                        $attachment_data = wp_get_attachment_url( $data );
										$file_type = wp_check_filetype($attachment_data);
										//print_r($file_type);
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
            <div class="col-3"><label><?php echo __( "Mark Service Featured", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$project_featured ='';
				$project_featured = get_post_meta($post_id, '_project_is_featured', true);
			?>
            <select name="project_featured">
                <option value="0" <?php if(isset($project_featured) && $project_featured == 0 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Simple", 'exertio_framework' ); ?></option>
                <option value="1" <?php if(isset($project_featured) && $project_featured == 1 ){ echo 'selected ="selected"'; } ?>> <?php echo __( "Featured", 'exertio_framework' ); ?></option>
            </select>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Assign Project", 'exertio_framework' ); ?></label></div>
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
                <p><?php echo __( "If you select a user from this list it will assign this project to the selected user.", 'exertio_framework' ); ?></p>
            </div>
        </div>
        
        
    <?php }

	
	/* Save the meta box's post metadata. */
	function project_save_post_class_meta( $post_id, $post ) {

		$p_expiry_date = get_post_meta($post_id, '_simple_projects_expiry_date', true);
		if($p_expiry_date == '')
		{
			$c_dATE = DATE("d-m-Y");
			$default_project_expiry = fl_framework_get_options('project_default_expiry');
			$simple_project_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_project_expiry days"));
			update_post_meta($post_id, '_simple_projects_expiry_date', $simple_project_expiry_date);
		}

	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['project_post_class_nonce'] ) || !wp_verify_nonce( $_POST['project_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		if(isset($_POST['project_category']))
		{
			update_post_meta( $post_id, '_project_category', sanitize_text_field($_POST['project_category']));
			set_hierarchical_terms('project-categories', $_POST['project_category'], $post_id);
			
			update_post_meta($post_id, 'cf_project_cats', $_POST['project_category']);
		}
		//saving custom fields
		if (isset($_POST['acf']) && $_POST['acf'] != '' && class_exists('ACF')) 
		{
			exertio_framework_acf_clear_object_cache($post_id);
			acf_update_values($_POST['acf'], $post_id);

		}
		
		if(isset($_POST['project_skills']))
		{
			$integerIDs = array_map('intval', $_POST['project_skills']);
			$integerIDs = array_unique($integerIDs);
			wp_set_post_terms( $post_id, $integerIDs, 'skills' );
		}
		if(isset($_POST['project_labels']))
		{
			$integerIDs = array_map('intval', $_POST['project_labels']);
			$integerIDs = array_unique($integerIDs);
			wp_set_post_terms( $post_id, $integerIDs, 'labels' );
		}
		if(isset($_POST['languages']))
		{
			$integerIDs = array_map('intval', $_POST['languages']);
			$integerIDs = array_unique($integerIDs);
			wp_set_post_terms( $post_id, $integerIDs, 'languages' );
		}
	
		
		
		
       if(isset($_POST['project_level']))
		{
			$level_terms = array((int)$_POST['project_level']); 
			/*print_r($cost_terms);
			exit;*/
			update_post_meta( $post_id, '_project_level', $_POST['project_level']);
			wp_set_post_terms( $post_id, $level_terms, 'project-level', false );
			
		}
		if(isset($_POST['project_type']))
		{
			$type_terms = array((int)$_POST['project_type']); 
			update_post_meta( $post_id, '_project_type', $_POST['project_type']);
			//wp_set_post_terms( $post_id, $type_terms, 'project-type', false );
			
		}
		/*if(isset($_POST['project_cost']))
		{
			update_post_meta( $post_id, '_project_cost', $_POST['project_cost']);
			
		}*/
		if($_POST['project_type'] == 'fixed' || $_POST['project_type'] == 1)
		{
			if(isset($_POST['project_cost']))
			{
				update_post_meta( $post_id, '_project_cost', sanitize_text_field($_POST['project_cost']));
			}
		}
		else if($_POST['project_type'] == 'hourly' || $_POST['project_type'] == 2)
		{
			if(isset($_POST['project_cost_hourly']) && isset($_POST['estimated_hours']))
			{
				update_post_meta( $post_id, '_project_cost', sanitize_text_field($_POST['project_cost_hourly']));
				update_post_meta( $post_id, '_estimated_hours', sanitize_text_field($_POST['estimated_hours']));
			}
		}

		if(isset($_POST['project_duration']))
		{
			$duration_terms = array((int)$_POST['project_duration']); 
			update_post_meta( $post_id, '_project_duration', $_POST['project_duration']);
			wp_set_post_terms( $post_id, $duration_terms, 'project-duration', false );
			
		}
		if(isset($_POST['project_freelancer_type']))
		{
			$freelancer_type_term = array((int)$_POST['project_freelancer_type']); 
			update_post_meta( $post_id, '_project_freelancer_type', $_POST['project_freelancer_type']);
			wp_set_post_terms( $post_id, $freelancer_type_term, 'freelancer-type', false );
			
		}
		if(isset($_POST['project_english_level']))
		{
			$project_english_level_term = array((int)$_POST['project_english_level']); 
			update_post_meta( $post_id, '_project_eng_level', $_POST['project_english_level']);
			wp_set_post_terms( $post_id, $project_english_level_term, 'english-level', false );
			
		}
		if(isset($_POST['project_location']))
		{
			update_post_meta( $post_id, '_project_location', sanitize_text_field($_POST['project_location']));
			set_hierarchical_terms('locations', $_POST['project_location'], $post_id);
			
		}
		if(isset($_POST['attachment_ids']))
		{
			update_post_meta( $post_id, '_project_attachment_ids', $_POST['attachment_ids']);
		}
		if(isset($_POST['project_featured']))
		{
			update_post_meta( $post_id, '_project_is_featured', $_POST['project_featured']);
			
		}
		if(isset($_POST['author_assign']))
		{
			$auth_id= $_POST['author_assign'];
			$arg = array(
				'ID' => $post_id,
				'post_author' => $auth_id,
			);
			remove_action('save_post', 'project_save_post_class_meta');
			wp_update_post( $arg );
		}
	}
}