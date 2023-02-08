<?php
add_theme_support( 'woocommerce' );
add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}
// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
	'main_theme_menu'    => esc_html__( 'Exertio Menu', 'exertio_theme' ),
) );
// Register SIDEBARS
function exertio_blog_sidebar() {

$args = array(
'id' => 'exertia-blog-widget',
'name' => __( 'Exertio Blog Widget', 'exertio_theme' ),
'description' => __( 'All the blog page widgets will be placed here.', 'exertio_theme' ),
'before_title' => '<div  class="widget-heading"><h3>',
'after_title' => '</h3><div class="heading-dots clearfix"><span class="h-dot line-dot"></span><span class="h-dot"></span><span class="h-dot"></span><span class="h-dot"></span></div></div>',
'before_widget' => '<div id="%1$s" class="widget %2$s">',
'after_widget' => '</div>',
);
register_sidebar( $args );

}
add_action( 'widgets_init', 'exertio_blog_sidebar' );

function exertio_services_sidebar()
{
	$args = array(
	'id' => 'exertia-services-widgets',
	'name' => __( 'Exertio Services Sidebar Widget', 'exertio_theme' ),
	'description' => __( 'All the services page sidebar widgets will be placed here.', 'exertio_theme' ),
	'before_title' => '',
	'after_title' => '<',
	'before_widget' => '',
	'after_widget' => '',
	);
	register_sidebar( $args );
}
add_action( 'widgets_init', 'exertio_services_sidebar' );

function my_search_form( $form ) {
    

$form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '">
				<div class="fl-search-blog"><div class="input-group stylish-input-group">
					
					<input type="search" class="form-control" placeholder="' .esc_attr__( 'Search for:', 'exertio_theme' ). '" value="'.get_search_query().'" name="s" id="s"/>
				<span class="input-group-append"><button class="blog-search-btn" type="submit">  <i class="fa fa-search"></i> </button></span></div></div>
				<input type="submit" class="search-submit" value="Search" />
			</form>';
    return $form;
}

add_filter( 'get_search_form', 'my_search_form', 100 );


function exertio_project_sidebar()
{
	$args = array(
	'id' => 'exertio-project-widgets',
	'name' => __( 'Exertio Project Sidebar Widgets', 'exertio_theme' ),
	'description' => __( 'All the project page sidebar widgets will be placed here.', 'exertio_theme' ),
	'before_title' => '',
	'after_title' => '<',
	'before_widget' => '',
	'after_widget' => '',
	);
	register_sidebar( $args );
}
add_action( 'widgets_init', 'exertio_project_sidebar' );

function exertio_employer_sidebar()
{
	$args = array(
	'id' => 'exertio-employer-widgets',
	'name' => __( 'Exertio Employer Sidebar Widgets', 'exertio_theme' ),
	'description' => __( 'All the employer page sidebar widgets will be placed here.', 'exertio_theme' ),
	'before_title' => '',
	'after_title' => '<',
	'before_widget' => '',
	'after_widget' => '',
	);
	register_sidebar( $args );
}
add_action( 'widgets_init', 'exertio_employer_sidebar' );

function exertio_freelancer_sidebar()
{
	$args = array(
	'id' => 'exertio-freelancer-widgets',
	'name' => __( 'Exertio Freelancer Sidebar Widgets', 'exertio_theme' ),
	'description' => __( 'All the freelancer page sidebar widgets will be placed here.', 'exertio_theme' ),
	'before_title' => '',
	'after_title' => '<',
	'before_widget' => '',
	'after_widget' => '',
	);
	register_sidebar( $args );
}
add_action( 'widgets_init', 'exertio_freelancer_sidebar' );

//Exertio Woocommerce Sidebar
function exertio_woo_commerce_sidebar()
{
    $args = array(
        'id' => 'exertio-woo-commerce-widgets',
        'name' => __( 'Exertio Woo-commerce Sidebar Widgets', 'exertio_theme' ),
        'description' => __( 'All the Product page sidebar widgets will be placed here.', 'exertio_theme' ),
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div></div>',
        'before_title' => '<div class="widget-heading"><div class="panel-title"><a>',
        'after_title' => '</a></div></div><div class="widget-content saftey">'
    );
    register_sidebar( $args );
}
add_action( 'widgets_init', 'exertio_woo_commerce_sidebar' );