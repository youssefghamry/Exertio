<?php 
// Registering custom post status
// IN REVIEW
function wpb_custom_post_status_inreview(){
    register_post_status('inreview', array(
        'label'                     =>  __('In Review', 'exertio_framework'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
		'post_type'                 => array( 'projects'),
        'label_count'               => _n_noop( 'In Review <span class="count">(%s)</span>', 'In Review <span class="count">(%s)</span>' ),
    ) );
	
	register_post_status('ongoing', array(
        'label'                     =>  __('Ongoing', 'exertio_framework'),
        'public'                    => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
		'post_type'                 => array( 'projects'),
        'label_count'               => _n_noop( __('Ongoing', 'exertio_framework').'<span class="count">(%s)</span>', __('Ongoing', 'exertio_framework').'<span class="count">(%s)</span>' ),
    ) );
	
	register_post_status('completed', array(
        'label'                     =>  __('Completed', 'exertio_framework'),
        'public'                    => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
		'post_type'                 => array( 'projects' ),
        'label_count'               => _n_noop( __('Completed', 'exertio_framework').'<span class="count">(%s)</span>', __('Completed', 'exertio_framework').'<span class="count">(%s)</span>' ),
    ) );
	register_post_status('canceled', array(
        'label'                     =>  __('Canceled', 'exertio_framework'),
        'public'                    => true,
        'exclude_from_search'       => true,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
		'post_type'                 => array( 'projects' ),
        'label_count'               => _n_noop( __('Canceled', 'exertio_framework').'<span class="count">(%s)</span>', __('Canceled', 'exertio_framework').'<span class="count">(%s)</span>' ),
    ) );
}
add_action( 'init', 'wpb_custom_post_status_inreview' );
 
function wpb_display_inreivew_state( $states, $post ) {
     //global $post;
     $arg = get_query_var( 'post_status' );
	 //print_r($post);
	 //$post_status ='';
	if($post->post_type == 'projects')
	{
		$post_status = $post->post_status;
		if($arg != 'inreview')
		{
		  if($post_status == 'inreview')
		  {
			   return array(__('In Review', 'exertio_framework'));
		  }
		}
		
		if($arg != 'ongoing')
		{
		  if($post_status == 'ongoing')
		  {
			   return array(__('Ongoing', 'exertio_framework'));
		  }
		}
		if($arg != 'completed')
		{
		  if($post_status == 'completed')
		  {
			   return array(__('Completed', 'exertio_framework'));
		  }
		}
		if($arg != 'canceled')
		{
		  if($post_status == 'canceled')
		  {
			   return array(__('Canceled', 'exertio_framework'));
		  }
		}
	}
    return $states;
}
add_filter( 'display_post_states', 'wpb_display_inreivew_state', 10, 2 );




 
 // Using jQuery to add it to post status dropdown for InReview
add_action('admin_footer-post.php', 'wpb_append_post_status_inreview_list');
function wpb_append_post_status_inreview_list()
{
	global $post;
	$complete = '';
	$label = '';
	if($post->post_type == 'projects')
	{
		if($post->post_status == 'inreview')
		{
			$complete = ' selected=\"selected\"';
			$label = '<span id=\"post-status-display\"> '.__('In Review.', 'exertio_framework').'</span>';
		}
		echo '<script>
		jQuery(document).ready(function($){
		$("select#post_status").append("<option value=\"inreview\" '.$complete.'>'.__('In Review.', 'exertio_framework').'</option>");
		$(".misc-pub-section #post-status-display").append("'.$label.'");
		});
		</script>';
	}
}

 
// Using jQuery to add it to post status dropdown for Ongoing
add_action('admin_footer-post.php', 'wpb_append_post_status_ongoing_list');
function wpb_append_post_status_ongoing_list()
{
	global $post;
	$complete = '';
	$label = '';
	if($post->post_type == 'projects')
	{
		if($post->post_status == 'ongoing')
		{
			$complete = ' selected=\"selected\"';
			$label = '<span id=\"post-status-display\"> '.__('Ongoing.', 'exertio_framework').'</span>';
			
		}
		echo '<script>
			jQuery(document).ready(function($){
			$("select#post_status").append("<option value=\"ongoing\" '.$complete.'>'.__('Ongoing', 'exertio_framework').'</option>");
			$(".misc-pub-section #post-status-display").append("'.$label.'");
			});
		</script>';
	}
}


// Using jQuery to add it to post status dropdown for Completed
add_action('admin_footer-post.php', 'wpb_append_post_status_completed_list');
function wpb_append_post_status_completed_list()
{
	global $post;
	$complete = '';
	$label = '';
	if($post->post_type == 'projects')
	{
		if($post->post_status == 'completed')
		{
			$complete = ' selected=\"selected\"';
			$label = '<span id=\"post-status-display\"> '.__('Completed.', 'exertio_framework').'</span>';
			
		}
		echo '<script>
			jQuery(document).ready(function($){
			$("select#post_status").append("<option value=\"completed\" '.$complete.'>'.__('Completed', 'exertio_framework').'</option>");
			$(".misc-pub-section #post-status-display").append("'.$label.'");
			});
		</script>';
	}
}
// Using jQuery to add it to post status dropdown for Canceled
add_action('admin_footer-post.php', 'wpb_append_post_status_canceled_list');
function wpb_append_post_status_canceled_list()
{
	global $post;
	$complete = '';
	$label = '';
	if($post->post_type == 'projects')
	{
		if($post->post_status == 'canceled')
		{
			$complete = ' selected=\"selected\"';
			$label = '<span id=\"post-status-display\"> '.__('Canceled.', 'exertio_framework').'</span>';
			
		}
		echo '<script>
			jQuery(document).ready(function($){
			$("select#post_status").append("<option value=\"canceled\" '.$complete.'>'.__('Canceled', 'exertio_framework').'</option>");
			$(".misc-pub-section #post-status-display").append("'.$label.'");
			});
		</script>';
	}
}


?>