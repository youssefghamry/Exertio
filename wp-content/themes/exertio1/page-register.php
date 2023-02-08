<?php
/* Template Name: Register */
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
if ( !is_user_logged_in() ) {
  $img_id ='';
  $only_url = $exertio_theme_options[ 'register_bg_image' ][ 'url' ];
  $bg_img = "style=\"background: url('$only_url'); background-repeat: no-repeat; background-position: center center; background-size: cover;\"";

  ?>
<section class="fr-sign-in-hero">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-xs-12 col-sm-12 col-xl-6 col-md-12 align-self-center no-padding-hero">
				<div class="fr-sign-container">
					<div class="fr-sign-content">
                        <?php  if(fl_framework_get_options('fl_allow_user_email_verification') == false)
                {?>
                        <div class="exertio-alert alert alert-danger alert-dismissible fade show fr_resend_email" role="alert">
                            <div class="exertio-alart-box">
                                <div class="text-info">
                                    <p>
                                        <?php echo esc_html__('A verification link has been sent to your email. ','exertio_theme'); ?>
                                        <button class="fr_send_email" type="button" ><?php echo esc_html__('Resend Email','exertio_theme'); ?></button>
                                    </p>
                                </div>
                            </div>
                        </div>
                   <?php } ?>
						<?php
						if ( isset( $exertio_theme_options[ 'register_logo_show' ] ) && $exertio_theme_options[ 'register_logo_show' ] == 1 ) {
						  ?>
						<div class="auth-logo"><a href="<?php echo get_home_url(); ?>"><img src="<?php echo esc_url($exertio_theme_options['dasboard_logo']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($exertio_theme_options['dasboard_logo']['id'], '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid" /></a></div>
						<?php
						}
						?>
						<div class="heading-panel">
						  <h2><?php echo esc_html($exertio_theme_options['register_heading_text']); ?></h2>
						  <p><?php echo esc_html($exertio_theme_options['register_textarea']); ?></p>
						</div>
						<form id="signup-form">
							<div class="fr-sign-form">
								<?php
								$user_count = '';
								if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both_selected')
								{
									if(!empty($exertio_theme_options['user_registration_type_selection']))
									{
										$user_count = count($exertio_theme_options['user_registration_type_selection']);
									}
								}
								
								if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both_selected' && $user_count == 2 )
								{
								?>
								  <div class="form-group register-type">
									  <div class="register-type-btn">
										  <label class="radio"> 
											 <input class="" type="radio" value="employer" name="exertio_user_type" checked="checked"><span><?php echo esc_html__('Employer','exertio_theme'); ?></span>
										  </label>
									  </div>
									  <div class="register-type-btn">
										 <label class="radio"> 
											 <input class="" type="radio" value="freelancer"  name="exertio_user_type"><span><?php echo esc_html__('Freelancer','exertio_theme'); ?></span>
										  </label>
									  </div>
								  </div>
								<?php
								}
								?>
							  <div class="fr-sign-form">
								<div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/name.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
								<div class="form-group">
								  <input type="text"  name="fl_full_name" placeholder="<?php echo esc_attr__('Display name','exertio_theme'); ?>" class="form-control" required data-smk-msg="<?php echo esc_attr__('Display name required','exertio_theme'); ?>">
								</div>
							  </div>
							  <div class="fr-sign-form">
								<div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/username.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
								<div class="form-group">
								  <input type="text"  name="fl_username" placeholder="<?php echo esc_attr__('Username','exertio_theme'); ?>" class="form-control" required data-smk-msg="<?php echo esc_attr__('Please provide username','exertio_theme'); ?>">
								</div>
							  </div>
							  <div class="fr-sign-form">
								<div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/mail.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
								<div class="form-group">
								  <input type="email"  name="fl_email" placeholder="<?php echo esc_attr__('Email address','exertio_theme'); ?>" class="form-control" required data-smk-msg="<?php echo esc_attr__('Email address is required','exertio_theme'); ?>">
								</div>
							  </div>
							  <div class="fr-sign-form">
								<div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/password.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
								<div class="form-group">
								  <input type="password" name="fl_password" placeholder="<?php echo esc_attr__('Password','exertio_theme'); ?>" class="form-control" id="password-field" required data-smk-msg="<?php echo esc_attr__('Please provide password','exertio_theme'); ?>">
								  <div data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></div> </div>
							  </div>
							  <div class="fr-sigin-requirements">
								<div class="form-group">
								<div class="pretty p-icon p-thick p-curve">
								  <input type="checkbox" required name="term_condition" data-smk-msg="<?php echo esc_attr__('You must need to accept terms and conditions','exertio_theme'); ?>">
								  <div class="state p-warning"> <i class="icon fa fa-check"></i>
									<label> </label>
								  </div>
								</div>
                                    <span class="sr-style"><?php echo esc_html__('I agree to the','exertio_theme'); ?> <a href="<?php echo get_the_permalink($exertio_theme_options['terms_condition_page']); ?>"><?php echo esc_html__('Terms and Conditions','exertio_theme'); ?></a> </span> </div>
							  </div>
								<?php
									$redirect_page = isset($_GET['redirect']) ? $_GET['redirect'] : '';
									if(isset($redirect_page) && $redirect_page !='')
									{
										$login_page = get_the_permalink($exertio_theme_options['login_page']).'?redirect='.$redirect_page;
									}
									else
									{
										$login_page = get_the_permalink($exertio_theme_options['login_page']);
									}
								?>
							  <div class="fr-sign-submit">
								<div class="form-group d-grid">
								  <button type="button" class="btn btn-theme btn-loading" id="signup-btn" data-redirect-id="<?php echo esc_attr($redirect_page); ?>"> <?php echo esc_html__('Create Account','exertio_theme'); ?>
								  <span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
								  </button>
                                    <input type="hidden" name="fl_user_id" id="fl_user_id" value="">
                                    <input type="hidden" id="register_nonce" value="<?php echo wp_create_nonce('fl_register_secure'); ?>"  />
								</div>
							  </div>
							  <?php
							  if( class_exists( 'mo_openid_login_wid' ) )
							  {
								?>
								  <div class="fr-sign-top-content">
									<p> <?php echo esc_html__('OR','exertio_theme'); ?></p>
								  </div>
								  <?php
								  echo do_shortcode( '[miniorange_social_login]' );
							  }
							  ?>
							 </div>
						</form>
						<div class="fr-sign-bundle-content">
						<p> <?php echo esc_html__('Already have an account?','exertio_theme'); ?> <span><a href="<?php echo esc_url($login_page); ?>"><?php echo esc_html__('Login here','exertio_theme'); ?></a></span></p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
		<div class="fr-sign-user-dashboard d-flex align-items-end">
		  <div class="sign-in owl-carousel owl-theme">
			<?php
			$slides = $exertio_theme_options[ 'register_slides' ];
			if ( $slides != '' && $slides[ 0 ][ 'title' ] != '' ) {
			  foreach ( $slides as $slide ) {
				?>
			<div class="item">
			  <div class="fr-sign-assets-2">
				<div class="fr-sign-main-content"> <img src="<?php echo esc_url($slide['thumb']); ?>" alt="<?php echo esc_attr(get_post_meta($slide['attachment_id'], '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
				<div class="fr-sign-text">
				  <h3><?php echo esc_html($slide['title']); ?></h3>
				  <p><?php echo esc_html($slide['description']); ?> </p>
				</div>
			  </div>
			</div>
			<?php
			}
			}
			?>
		  </div>
		</div>
		</div>
		</div>
	</div>
	<div class="fr-sign-background" <?php echo wp_return_echo($bg_img); ?>></div>
</section>
<?php
} else {
  echo exertio_redirect( get_the_permalink( $exertio_theme_options[ 'user_dashboard_page' ] ) );
}
?>
<?php get_footer(); ?>