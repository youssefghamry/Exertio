<?php
get_header();
if ( have_posts() )
{ 
	the_post();
	
	if( exertio_is_elementor() && !is_page_template( 'page-home.php' ))
	{
		the_content();
	}
	else
	{
		if (exertio_is_realy_woocommerce_page() )
		{
			the_content();
		}
		else
		{
			$actionbBar = fl_framework_get_options('action_bar');
			$actionbar_space = '';
			if(isset($actionbBar) && $actionbBar == 1)
			{
				$actionbar_space = 'actionbar_space';
			}
			?>
			<section class="section-padding post-excerpt post-desc bg-gray-light-color <?php echo esc_attr($actionbar_space); ?>">
				<div class="container">
					<div class="row">
						<div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
						<?php
							the_content();
						?>
						<div class="clearfix"></div>
						<?php
						wp_link_pages( array(
						'before'      => '<div class="page_with_pagination"><div class="page-links">','after' => '</div></div>','next_or_number' => 'number','link_before' => '<span class="no">','link_after'  => '</span>') );
						?>
						<div class="clearfix"></div>
						<?php
						comments_template( '', true ); ?>
						</div>
					</div>
				</div>
			</section>	
			<?php
		}
	}
}
?>
<?php get_footer(); ?>