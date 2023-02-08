<?php
global $exertio_theme_options; 
if (is_page_template('page-profile.php')){}
else if ( is_page_template( 'page-login.php' ) && $exertio_theme_options['login_footer_show'] == 0){}
else if ( is_page_template( 'page-register.php' ) && $exertio_theme_options['register_footer_show'] == 0) { }
else 
{
	if(isset($exertio_theme_options['footer_type'])) { $footer_type  = $exertio_theme_options['footer_type']; } else { $footer_type  = 0; }
	
	if($footer_type  ==  1 && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		elementor_theme_do_location('footer');
	}
	else
	{
		get_template_part( 'template-parts/footer/footer','1' );
        get_template_part( 'template-parts/verification','logic' );
	}
}
if ( is_page_template( 'page-login.php' ))
{
	get_template_part( 'template-parts/auth/password','reset' ); 
}
if ( is_singular( 'freelancer' ) || is_singular( 'services' ) || is_singular( 'projects' ) || is_singular( 'employer' ) )
{
	get_template_part( 'template-parts/auth/report','' ); 
}
if ( is_singular( 'freelancer' ))
{
	get_template_part( 'template-parts/auth/hire-freelancer-modal','' ); 
}
wp_footer();
if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	if(is_page_template( 'page-profile.php' ) && $exertio_theme_options['zoom_meeting_btn'] == 1)
	{
		?>
		<div id="zoom_meeting_container"></div>
		<?php
	}
}
?>
<input type="hidden" id="freelance_ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>" />
<input type="hidden" id="gen_nonce" value="<?php echo wp_create_nonce('fl_gen_secure'); ?>" />
<input type="hidden" id="nonce_error" value="<?php echo esc_html__('Something went wrong','exertio_theme'); ?>" />
</body>
</html>