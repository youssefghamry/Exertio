<?php 
 /* Template Name: Project Search */ 
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
		$price_type = '';
	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} else if ( get_query_var( 'page' ) ) {
		/*This will occur if on front page.*/
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
			'key' => '_project_cost',
			'value' => array($price_min, $price_max),
			'type' => 'numeric',
			'compare' => 'BETWEEN',
		);
	}


	if (isset($_GET['price-type']) && $_GET['price-type'] != "")
	{

		$price_type = array(
			'key'       => '_project_type',
			'value'     => $_GET['price-type'],
			'compare'   => '=',
		);
	}

	$category = '';
	if (isset($_GET['category']) && $_GET['category'] != "") {
		$category = array(
			array(
				'taxonomy' => 'project-categories',
				'field' => 'term_id',
				'terms' => $_GET['category'],
			),
		);
	}
	$freelancer_type = '';
	if (isset($_GET['freelancer-type']) && $_GET['freelancer-type'] != "") {
		$freelancer_type = array(
			array(
				'taxonomy' => 'freelancer-type',
				'field' => 'term_id',
				'terms' => $_GET['freelancer-type'],
			),
		);
	}
	$project_duration = '';
	if (isset($_GET['project-duration']) && $_GET['project-duration'] != "") {
		$project_duration = array(
			array(
				'taxonomy' => 'project-duration',
				'field' => 'term_id',
				'terms' => $_GET['project-duration'],
			),
		);
	}
	$project_leve = '';
	if (isset($_GET['project-level']) && $_GET['project-level'] != "") {
		$project_leve = array(
			array(
				'taxonomy' => 'project-level',
				'field' => 'term_id',
				'terms' => $_GET['project-level'],
			),
		);
	}
	$english_level = '';
	if (isset($_GET['english-level']) && $_GET['english-level'] != "") {
		$english_level = array(
			array(
				'taxonomy' => 'english-level',
				'field' => 'term_id',
				'terms' => $_GET['english-level'],
			),
		);
	}
	$location = '';
	if (isset($_GET['location']) && $_GET['location'] != "") {
		$location = array(
			array(
				'taxonomy' => 'locations',
				'field' => 'term_id',
				'terms' => $_GET['location'],
			),
		);
	}
	$skill = '';
	if (isset($_GET['skill']) && $_GET['skill'] != "") {
		$skill = array(
			array(
				'taxonomy' => 'skills',
				'field' => 'term_id',
				'terms' => $_GET['skill'],
			),
		);
	}

	$language = '';
	if (isset($_GET['language']) && $_GET['language'] != "") {
		$language = array(
			array(
				'taxonomy' => 'languages',
				'field' => 'term_id',
				'terms' => $_GET['language'],
			),
		);
	}

	$order ='DESC';
	if (isset($_GET['sort']) && $_GET['sort'] != "")
	{
		if($_GET['sort'] == 'old-new')
		{
			$order ='ASC'; 
		}
		else if($_GET['sort'] == 'new-old')
		{
			$order ='DESC';
		}
	}
	$show_expired = '';
	$expired_projects = fl_framework_get_options('expired_project_search');

	if (isset($expired_projects) && $expired_projects == 0) {
		$show_expired = array(
			'key'       => '_project_status',
			'value'     => 'active',
			'compare'   => '=',
		);
	}

		$args	=	array
		(
			's' => $title,
			'post_type' => 'projects',
			'post_status' => 'publish',
			'posts_per_page' => get_option('posts_per_page'),
			'paged' => $paged,
			//'order'   => $order,
			'meta_key'          => '_project_is_featured',
			'meta_query'    => array(
				$show_expired,
				$price,
				$price_type,
			),

			'tax_query' => array(
				$category,
				$freelancer_type,
				$project_duration,
				$project_leve,
				$english_level,
				$location,
				$skill,
				$language,
			),
			'orderby'  => array(
				'meta_value' => 'DESC',
				'post_date'      => $order,
			),
		);
		$results = new WP_Query( $args );
	if(fl_framework_get_options('project_sidebar_layout') == '1') {
		require trailingslashit(get_template_directory()) . 'template-parts/search/projects/search-projects.php';
	}
	if(fl_framework_get_options('project_sidebar_layout') == '2') {
		require trailingslashit(get_template_directory()) . 'template-parts/search/projects/search-projects-2.php';
	}
}
else
{
	wp_redirect(home_url());
}
?>
<?php get_footer(); ?>