<?php // Register post  type and taxonomy
add_action('init', 'fl_verification_themes_custom_types', 0);
function fl_verification_themes_custom_types() {
	 $args = array(
			'public' => false,
			'labels' => array(
							'name' => __('Verification', 'exertio_framework'),
							'singular_name' => __('Verification', 'exertio_framework'),
							'menu_name' => __('Verification', 'exertio_framework'),
							'name_admin_bar' => __('Verification', 'exertio_framework'),
							'add_new' => __('Add New Verification', 'exertio_framework'),
							'add_new_item' => __('Add New Verification', 'exertio_framework'),
							'new_item' => __('New Verification', 'exertio_framework'),
							'edit_item' => __('Edit Verification', 'exertio_framework'),
							'view_item' => __('View Verification', 'exertio_framework'),
							'all_items' => __('All Verification', 'exertio_framework'),
							'search_items' => __('Search Verification', 'exertio_framework'),
							'not_found' => __('No Verification Found.', 'exertio_framework'),
							),
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => false,
			'menu_icon'           => FL_PLUGIN_URL.'/images/verify.png',
			'rewrite' => array('with_front' => false, 'slug' => 'verification'),
			'capabilities' => array(
				'create_posts' => 'do_not_allow',
			),
			 'map_meta_cap' => true,
		);
	register_post_type('verification', $args);


	add_action( 'load-post.php', 'verification_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'verification_post_meta_boxes_setup' );
	
	
	function verification_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'verification_add_post_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  //add_action( 'save_post', 'verification_save_post_class_meta', 10, 2 );
	  
	}
	
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function verification_add_post_meta_boxes() {
	
	  add_meta_box(
		'verification-post-class',      // Unique ID
		esc_html__( 'Verification Detail', 'exertio_framework' ),    // Title
		'verification_post_class_meta_box',   // Callback function
		'verification',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	
	function verification_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'verification_post_class_nonce' ); 
		//print_r($post);
		$post_id =  $post->ID;
		?>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Contact Number", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$verification_contact ='';
				$verification_contact = get_post_meta($post_id, '_verification_contact', true);
			?>
            <label for=""><?php echo esc_html($verification_contact); ?></label>
            </div>
        </div> 
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "CNIC / Passport / NIN  or SSN", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$verification_number ='';
				$verification_number = get_post_meta($post_id, '_verification_number', true);
			?>
            <label><?php echo esc_html($verification_number); ?></label>
            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Address", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$verification_address ='';
				$verification_address = get_post_meta($post_id, '_verification_address', true);
			?>
            <label><?php echo esc_html($verification_address); ?></label>
            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Document", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$attachment_doc_id ='';
				$attachment_doc_id = get_post_meta($post_id, '_attachment_doc_id', true);

				if(isset($attachment_doc_id) && $attachment_doc_id != '')
				{
					$img_url = wp_get_attachment_image_src( $attachment_doc_id, 'full' );
					?>
					<a href="<?php echo esc_html($img_url[0]); ?>" target="_blank"><img src="<?php echo esc_html($img_url[0]); ?>" alt"<?php echo esc_attr(get_post_meta($attachment_doc_id, '_wp_attachment_image_alt', TRUE)); ?>" class="verification-img"></a>
					<?php
				}
				?>
            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Freelancer Profile Link", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
				$author_id = get_post_field( 'post_author', $post_id );
				$fid = get_user_meta( $author_id, 'freelancer_id' , true );
				
			?>
            <label><a href="<?php echo get_edit_post_link($fid); ?>"><?php echo esc_html(exertio_get_username('freelancer', $fid, '')); ?></a></label>
            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Employer Profile Link", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php 
				$emp_id = get_user_meta( $author_id, 'employer_id' , true );
			?>
            <label><a href="<?php echo get_edit_post_link($emp_id); ?>"><?php echo esc_html(exertio_get_username('employer', $emp_id, '')); ?></a></label>
            </div>
        </div>
    <?php }


}