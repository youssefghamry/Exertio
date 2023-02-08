<?php
if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	get_template_part('header');
	global $exertio_theme_options;
	if ( have_posts() )
	{ 
		while ( have_posts() )
		{ the_post();

			global $post;
			$fl_id = get_the_ID();
			$post_author = $post->post_author;
			$user_info = get_userdata($post_author);

			$img_alt_id ='';

			if($exertio_theme_options['freelancer_details_page_layout'] == "1")
			{
				get_template_part( 'template-parts/detail-page/freelancer/style', '1');
			}
			else
			{
				get_template_part( 'template-parts/detail-page/freelancer/style', '2');	
			}

			/*SERVICES TO SHOW IN TOP*/
			if($exertio_theme_options['freelancer_services'] == "1")
			{
				get_template_part( 'template-parts/detail-page/freelancer/services', '');
			}
			?>
			<section class="fr-product-description padding-bottom-80">
			  <div class="container">
				<div class="row">
				  <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
					<?php
						$layout = $exertio_theme_options['detail_page_lower_layout']['enabled'];
						if ( $layout )
						{
							foreach ( $layout as $key => $value )
							{
								switch($key) {
									case 'description': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/description', '' );
									break;

									case 'reviews_seller': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/reviews-seller', '' );
									break;

									case 'reviews_freelancer': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/reviews-freelancer', '' );
									break;

									case 'projects': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/projects', '' );
									break;

									case 'experience': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/experience', '' );    
									break; 

									case 'education': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/education', '' );    
									break;

									case 'ads_1': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/advertisement_1', '' );    
									break;

									case 'ads_2': get_template_part( 'template-parts/detail-page/freelancer/sortable-sections/advertisement_2', '' );    
									break;
									
									case 'freelancer_custom_fields': get_template_part( 'template-parts/detail-page/custom-field', '');    
									break;

								}
							}
						}
					?>
				  </div>
				  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
					<div class="freelance-sidebar">
						<?php
						$layout_sidebar = $exertio_theme_options['detail_page_sidebar']['enabled'];

						if ( $layout_sidebar )
						{
							foreach ( $layout_sidebar as $key => $value )
							{
								switch($key) {
									case 'certifications': get_template_part( 'template-parts/detail-page/freelancer/sidebar/certifications', '' );
									break;

									case 'skills': get_template_part( 'template-parts/detail-page/freelancer/sidebar/skills', '' );
									break;

									case 'freelancer_detail': get_template_part( 'template-parts/detail-page/freelancer/sidebar/detail', '' );
									break;

									case 'sidebar_ads_1': get_template_part( 'template-parts/detail-page/freelancer/sidebar/advertisement_1', '' );    
									break;

									case 'sidebar_ads_2': get_template_part( 'template-parts/detail-page/freelancer/sidebar/advertisement_2', '' );    
									break;
								}
							}
						}
					?>
					</div>
					 <p class="report-button text-center"> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#report-modal"><i class="fas fa-exclamation-triangle"></i><?php echo esc_html__('Report Freelancer','exertio_theme'); ?></a></p>
				  </div>
				</div>
			  </div>
			</section>
	<?php
			/*SERVICES TO SHOW IN BOTTOM*/
			if($exertio_theme_options['freelancer_services'] == "2")
			{
				get_template_part( 'template-parts/detail-page/freelancer/services', '');
			}
		}
	}
	else
	{
		get_template_part( 'template-parts/content', 'none' );
	}
}
else
{
	wp_redirect(home_url());
}
if(isset($exertio_theme_options['footer_type'])) { $footer_type  = $exertio_theme_options['footer_type']; } else { $footer_type  = 0; }
if($footer_type  ==  1) {
    if($footer_type  ==  1 && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins'))))
    {
        elementor_theme_do_location('footer');
    }else{
        get_footer();
    }
}else {
    get_template_part('footer');
}
?>