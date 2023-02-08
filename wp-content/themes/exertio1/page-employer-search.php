<?php 
 /* Template Name: Employer Search */ 
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


	$department = '';
	if (isset($_GET['department']) && $_GET['department'] != "") {
		$department = array(
			array(
				'taxonomy' => 'departments',
				'field' => 'term_id',
				'terms' => $_GET['department'],
			),
		);
	}
	$no_of_employees = '';
	if (isset($_GET['no-of-employees']) && $_GET['no-of-employees'] != "") {
		$no_of_employees = array(
			array(
				'taxonomy' => 'employees-number',
				'field' => 'term_id',
				'terms' => $_GET['no-of-employees'],
			),
		);
	}
	$location = '';
	if (isset($_GET['location']) && $_GET['location'] != "") {
		$location = array(
			array(
				'taxonomy' => 'employer-locations',
				'field' => 'term_id',
				'terms' => $_GET['location'],
			),
		);
	}
	$email_verified = '';
	if(fl_framework_get_options('employer_show_non_verified') != null && fl_framework_get_options('employer_show_non_verified') == true)
	{
		$email_verified =  array(
					 'key' => 'is_employer_email_verified',
					 'value' => '1',
					'compare'   => '=',
					);
	}

	$tagline_display_name = array(
			'relation' => 'OR',
			array(
				'key' => '_employer_tagline',
				'value' => $title,
				'compare'   => 'LIKE',
			),	
			array(
				'key' => '_employer_dispaly_name',
				'value' => $title,
				'compare'   => 'LIKE',
			),
			
		);

	$order ='DESC';
	if (isset($_GET['sort']) && $_GET['sort'] != "")
	{
		if($_GET['sort'] == 'desc')
		{
			$order ='DESC';
		}
		else if($_GET['sort'] == 'asc')
		{
			$order ='ASC';
		}
	}
		$args	=	array
		(
			//'author__not_in' => array( 1 ),
			//'s' => $title,
			'post_type' => 'employer',
			'post_status' => 'publish',
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $paged,
			'meta_key' => '_employer_is_featured',
			'orderby'  => array(
				'meta_value' => 'DESC',
				'post_date'      => $order,
			),
			'fields' => 'ids',
			'meta_query' => array(
				'relation' => 'AND',
				$email_verified,
				$tagline_display_name
			),
			'tax_query' => array(
				$no_of_employees,
				$department,
				$location,
			),
		);
		
	
	
		$results = new WP_Query( $args );

		require trailingslashit(get_template_directory()) . 'template-parts/search/employer/search-employers.php';
}
else
{
	wp_redirect(home_url());
}
?>
<?php get_footer(); ?>