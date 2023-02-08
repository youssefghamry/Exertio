<?php 
 /* Template Name: Services Search */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Exertio
 */
?>
<?php get_header(); ?>

<?php
if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} else if ( get_query_var( 'page' ) ) {

		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}
	$title ='';
	if (isset($_GET['title']) && $_GET['title'] != "") {
		$title = $_GET['title'];
	}


	$price = '';
	$price_min = '';
	$price_max = '';
	if (isset($_GET['price-min']) && $_GET['price-min'] != "") {
		$price_min = $_GET['price-min'];
	}

	if (isset($_GET['price-max']) && $_GET['price-max'] != "") {
		$price_max = $_GET['price-max'];
	}

	if ($price_min != "" && $price_max != "") {
		$price = array(
			'key' => '_service_price',
			'value' => array($price_min, $price_max),
			'type' => 'numeric',
			'compare' => 'BETWEEN',
		);
	}

	$category = '';
	if (isset($_GET['categories']) && $_GET['categories'] != "") {
		$category = array(
			array(
				'taxonomy' => 'service-categories',
				'field' => 'term_id',
				'terms' => $_GET['categories'],
			),
		);
	}
	$english_level = '';
	if (isset($_GET['english-level']) && $_GET['english-level'] != "") {
		$english_level = array(
			array(
				'taxonomy' => 'services-english-level',
				'field' => 'term_id',
				'terms' => $_GET['english-level'],
			),
		);
	}
	$response_time = '';
	if (isset($_GET['response-time']) && $_GET['response-time'] != "") {
		$response_time = array(
			array(
				'taxonomy' => 'response-time',
				'field' => 'term_id',
				'terms' => $_GET['response-time'],
			),
		);
	}
	$delivery_time = '';
	if (isset($_GET['delivery-time']) && $_GET['delivery-time'] != "") {
		$delivery_time = array(
			array(
				'taxonomy' => 'delivery-time',
				'field' => 'term_id',
				'terms' => $_GET['delivery-time'],
			),
		);
	}
	$location = '';
	if (isset($_GET['location']) && $_GET['location'] != "") {
		$location = array(
			array(
				'taxonomy' => 'services-locations',
				'field' => 'term_id',
				'terms' => $_GET['location'],
			),
		);
	}

	if (isset($_GET['sort']) && $_GET['sort'] != "")
	{
		$order ='';
		if($_GET['sort'] == 'new-old')
		{
			$order ='DESC';
		}
		else if($_GET['sort'] == 'old-new')
		{
			$order ='ASC';
		}
	}
		$args	=	array
		(
			//'author__not_in' => array( 1 ),
			's' => $title,
			'post_type' => 'services',
			'post_status' => 'publish',
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $paged,
			'meta_key'  => '_service_is_featured',
			'meta_query'    => array(
				array(
					'key'       => '_service_status',
					'value'     => 'active',
					'compare'   => '=',
				),
				$price,
			),
			'tax_query' => array(
				$category,
				$english_level,
				$response_time,
				$delivery_time,
				$location,
			),
			'orderby'  => array(
				'meta_value' => 'DESC',
				'post_date'      => $order,
			),
		);
		$results = new WP_Query( $args );

		require trailingslashit(get_template_directory()) . 'template-parts/search/services/serach-services.php';
}
else
{
	wp_redirect(home_url());
}
?>
<?php get_footer(); ?>