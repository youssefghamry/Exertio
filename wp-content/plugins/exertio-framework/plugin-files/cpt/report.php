<?php // Register post  type and taxonomy
add_action('init', 'fl_report_themes_custom_types', 0);
function fl_report_themes_custom_types() {
	 $args = array(
			'public' => false,
			'labels' => array(
							'name' => __('Report', 'exertio_framework'),
							'singular_name' => __('Report', 'exertio_framework'),
							'menu_name' => __('Report', 'exertio_framework'),
							'name_admin_bar' => __('Report', 'exertio_framework'),
							'add_new' => __('Add New Report', 'exertio_framework'),
							'add_new_item' => __('Add New Report', 'exertio_framework'),
							'new_item' => __('New Report', 'exertio_framework'),
							'edit_item' => __('Edit Report', 'exertio_framework'),
							'view_item' => __('View Report', 'exertio_framework'),
							'all_items' => __('All Report', 'exertio_framework'),
							'search_items' => __('Search Report', 'exertio_framework'),
							'not_found' => __('No Report Found.', 'exertio_framework'),
							),
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => false,
			'menu_icon'           => FL_PLUGIN_URL.'/images/report.png',
			'rewrite' => array('with_front' => false, 'slug' => 'report'),
		 	'show_in_admin_bar' => false,
            'show_in_nav_menus' => false,
            'can_export' => false,
            'exclude_from_search' => true,
            'show_in_rest' => false,
            'publicly_queryable' => false,
			'capabilities' => array(
				'create_posts' => 'do_not_allow',
			),
			 'map_meta_cap' => true,
		);
	register_post_type('report', $args);

add_action( 'admin_menu', function () {
    remove_meta_box( 'submitdiv', 'report', 'side' );
} );
	$report_category = array(
			'name'                       => __( 'Report Category', 'taxonomy general name', 'exertio_framework' ),
			'search_items'               => __( 'Search Report Category', 'exertio_framework' ),
			'popular_items'              => __( 'Popular Reports Category', 'exertio_framework' ),
			'all_items'                  => __( 'All Report Categories', 'exertio_framework' ),
			'edit_item'                  => __( 'Edit Report Category', 'exertio_framework' ),
			'update_item'                => __( 'Update Report Category', 'exertio_framework' ),
			'add_new_item'               => __( 'Add New Report Category', 'exertio_framework' ),
			'new_item_name'              => __( 'New Report Category Name', 'exertio_framework' ),
			'separate_items_with_commas' => __( 'Separate Reports Category with commas', 'exertio_framework' ),
			'add_or_remove_items'        => __( 'Add or remove Report Category', 'exertio_framework' ),
			'choose_from_most_used'      => __( 'Choose from the most used Report Category', 'exertio_framework' ),
			'not_found'                  => __( 'No Report Category found.', 'exertio_framework' ),
			'menu_name'                  => __( 'Report Category', 'exertio_framework' ),
		);
	register_taxonomy('report-category', array('report'), array(
			'hierarchical' => false,
			'show_ui' => true,
			'labels' => $report_category,
			'show_admin_column' => true,
			'query_var' => true,
			'meta_box_cb' => false,
			'rewrite' => array('slug' => 'skills'),
		));
	
	 // Add the custom columns to the book post type:
add_filter( 'manage_report_posts_columns', 'set_custom_edit_report_columns' );
function set_custom_edit_report_columns($columns) {
	unset($columns['date']);
    $columns['user'] = __( 'Reported by', 'exertio_framework' );
	$columns['count'] = __( 'No of Reports', 'exertio_framework' );
	$columns['post_type'] = __( 'Post Type', 'exertio_framework' );
	$columns['post_view'] = __( 'View Post', 'exertio_framework' );
	$columns['date'] =  __('Date', 'exertio_framework');

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_report_posts_custom_column' , 'custom_report_column', 10, 2 );
function custom_report_column( $column, $post_id ) {
	$author_id = get_post_field( 'post_author', $post_id );
	$author_name = '<a href="'.get_edit_user_link($author_id).'">'.get_the_author_meta( 'nickname', $author_id ).' </a>';
	if($column === 'user')
	{
		echo $author_name;
	}
	if($column === 'count')
	{
		$reported_pid = get_post_meta($post_id, '_reported_pid', true);
		if(isset($reported_pid) && $reported_pid != '')
		{
			//echo $reported_pid;
			$is_reported = get_post_meta($reported_pid,'_is_reported', true);
			echo $is_reported;
		}
	}
	if($column === 'post_type')
	{
		$reported_pid = get_post_meta($post_id, '_reported_post_type', true);
		if(isset($reported_pid) && $reported_pid != '')
		{
			echo $reported_pid;
		}
	}
	if($column === 'post_view')
	{
		$reported_pid = get_post_meta($post_id, '_reported_pid', true);
		echo '<a href="'.get_the_permalink($reported_pid).'" target="_blank">'.get_the_title( $reported_pid ).' </a>';
	}
}
	
	
	add_action( 'load-post.php', 'report_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'report_post_meta_boxes_setup' );
	
	
	function report_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'report_add_post_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  //add_action( 'save_post', 'verification_save_post_class_meta', 10, 2 );
	  
	}
	
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function report_add_post_meta_boxes() {
	
	  add_meta_box(
		'report-post-class',      // Unique ID
		esc_html__( 'Report Detail', 'exertio_framework' ),    // Title
		'report_post_class_meta_box',   // Callback function
		'report',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	
	function report_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'report_post_class_nonce' ); 
		$post_id =  $post->ID;
		?>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Category", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <label>
				<?php 
					$report_category = get_term( get_post_meta( $post_id, '_report_category', true ) );
					  if ( !empty( $report_category ) && !is_wp_error( $report_category ) ) {
						echo esc_html($report_category->name);
					  }
				?>
			</label>
            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Number of Reports", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <label>
				<?php 
					$reported_pid = get_post_meta($post_id, '_reported_pid', true);
					if(isset($reported_pid) && $reported_pid != '')
					{
						$is_reported = get_post_meta($reported_pid,'_is_reported', true);
						echo $is_reported;
					}
				?>
			</label>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Reported by", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$author_id = get_post_field( 'post_author', $post_id );
				$author_name = '<a href="'.get_edit_user_link($author_id).'">'.get_the_author_meta( 'nickname', $author_id ).' </a>';
			?>
            <label for=""><?php echo wp_return_echo($author_name); ?></label>
            </div>
        </div>       
    <?php }


}