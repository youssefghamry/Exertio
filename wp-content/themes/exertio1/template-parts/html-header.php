<?php
if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	global $exertio_theme_options;
	$preloader = $exertio_theme_options['website_preloader'];
}
else
{
	$preloader = '';
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="loader-outer">
	<div class="loading-inner">
		<div class="loading-inner-meta">
			<div> </div>
			<div></div>
		</div>
	</div>
</div>
<?php
if(isset($preloader) && $preloader == 1)
{
	?>
	<div class="exertio-loader-container">
		<div class="exertio-loader">
		  <span class="exertio-dot"></span>
		  <div class="exertio-dots">
			<span></span>
			<span></span>
			<span></span>
		  </div>
		</div>
	</div>
	<?php
}
?>
<?php

if (is_page_template('page-profile.php')) 
{

}
else if ( is_page_template( 'page-login.php' ) && $exertio_theme_options['login_header_show'] == 0)
{
}
else if ( is_page_template( 'page-register.php' ) && $exertio_theme_options['register_header_show'] == 0)
{
}
else
{
	if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		$header_type  = $exertio_theme_options['header_type'];
		if($header_type  ==  1 && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins'))))
		{
			elementor_theme_do_location('header');
		}
		else
		{
			$header_type = (isset($_GET['header'])&& $_GET['header'] == '2')? true: false;

			if( $header_type == true)
			{
				get_template_part( 'template-parts/headers/header','2' );
			}
			else if(isset($exertio_theme_options['header_layout']) && $exertio_theme_options['header_layout'] == 1)
			{
				get_template_part( 'template-parts/headers/header','1' );
			}
			else if(isset($exertio_theme_options['header_layout']) && $exertio_theme_options['header_layout'] == 2)
			{
				get_template_part( 'template-parts/headers/header','2' );
			}
		}
	}
	else
	{
		get_template_part( 'template-parts/headers/header','1' );
	}
}