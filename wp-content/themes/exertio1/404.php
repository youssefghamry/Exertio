<?php get_header();
$image_id = '';
$actionbBar = fl_framework_get_options('action_bar');
$actionbar_space = '';
if(isset($actionbBar) && $actionbBar == 1)
{
	$actionbar_space = 'actionbar_space';
}

?>
<section class="fr-404 exertia-padding<?php echo esc_attr($actionbar_space); ?>">
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
				<div class="fr-er-404">
					<div class="fr-er-content">
						<img src="<?php echo esc_url(trailingslashit(get_template_directory_uri())."images/404.png"); ?>" alt="<?php echo esc_attr(get_post_meta($image_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
						<h2><span><?php echo esc_html__( 'Oops!', 'exertio_theme' ).'</span> '.esc_html__( 'Page Not Found', 'exertio_theme' ); ?></h2>
						<p><?php echo esc_html__( "We're sorry, but the page you were looking for doesn't exist or temporarily unavailable.", 'exertio_theme' ); ?></p>
					</div>
					<div class="fr-er-list">
						<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-theme"><?php echo esc_html__('Go to Home', 'exertio_theme' ); ?><i class="fa fa-long-arrow-right"></i></a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>