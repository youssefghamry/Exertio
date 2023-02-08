<?php
$is_related = fl_framework_get_options('service_related_posts');
if(isset($is_related) && $is_related == 1)
{
	$related_post_count = 4;
	$related_post_count = fl_framework_get_options('service_related_posts_count');
	$sid	=	get_the_ID();
	$cats = wp_get_post_terms( $sid, 'service-categories' );
	$categories	=	array();
	foreach( $cats as $cat )
	{
		$categories[]	=	$cat->term_id;
	}
	$args = array(
		'post_type' => 'services',
		'posts_per_page' => $related_post_count,
		'order'=> 'DESC',
		'post__not_in'	=> array( $sid ),
		'meta_query' => array(
			array(
				'key' => '_service_status',
				'value' => 'active',
				'compare' => '=',
				),
			),
		'tax_query' => array(
			array(
			'taxonomy' => 'service-categories',
			'field' => 'id',
			'terms' => $categories,
			'operator'=> 'IN'
		)));

	$results = new WP_Query( $args );
	if(isset($results) && $results != '' && $results->found_posts > 0)
	{
		?>
		<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-xl-12">
			<div class="related-posts"  id="related">
				<div class="heading-contents">
				  <h3><?php echo fl_framework_get_options('service_related_posts_title'); ?> </h3>
				</div>
				<div class="recomended-slider owl-carousel owl-theme">
				<?php		
					$list_type = 'grid_1';
					$servicce_list_style = fl_framework_get_options('service_grid_style');
					if(isset($servicce_list_style) && $servicce_list_style != '')
					{
						$list_type = $servicce_list_style;
					}
					
					$layout_type = new exertio_get_services();
					while ($results->have_posts())
					{
						$results->the_post();
						$service_id = get_the_ID();
						$function = "exertio_listings_$list_type";
						$fetch_output = $layout_type->$function($service_id, 'item');
						echo ' '.$fetch_output;
					}
				?>
				</div>
			</div>
		</div>
		<?php
	}
}
?>