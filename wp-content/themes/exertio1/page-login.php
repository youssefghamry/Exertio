<?php
/* Template Name: Login */
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
	$img_id = '';
  global $exertio_theme_options;
  $only_url = $exertio_theme_options[ 'login_bg_image' ][ 'url' ];
  $bg_img = "style=\"background: url('$only_url'); background-repeat: no-repeat; background-position: center center; background-size: cover;\"";
  ?>
<section class="fr-sign-in-hero">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-xs-12 col-sm-12 col-xl-6 col-md-12 align-self-center no-padding-hero">
        <div class="fr-sign-container">
          <div class="fr-sign-content">
            <?php
            if ( isset( $exertio_theme_options[ 'login_logo_show' ] ) && $exertio_theme_options[ 'login_logo_show' ] == 1 ) {
              ?>
            <div class="auth-logo"><a href="<?php echo get_home_url(); ?>"><img src="<?php echo esc_url($exertio_theme_options['dasboard_logo']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($exertio_theme_options['dasboard_logo']['id'], '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid" /></a></div>
            <?php
            }
            ?>
            <div class="heading-panel">
              <h2><?php echo esc_html($exertio_theme_options['login_heading_text']); ?></h2>
              <p><?php echo esc_html($exertio_theme_options['login_textarea']); ?></p>
            </div>
            <form  id="signin-form">
              <div class="fr-sign-form">
                <div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/mail.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
                <div class="form-group">
                  <input type="text"  name="fl_email" placeholder="<?php echo esc_attr__('Email address','exertio_theme'); ?>" class="form-control" required data-smk-msg="<?php echo esc_attr__('Please provide email address','exertio_theme'); ?>">
                </div>
              </div>
              <div class="fr-sign-form">
                <div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/password.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
                <div class="form-group">
                  <input type="password" name="fl_password" placeholder="<?php echo esc_attr__('Password','exertio_theme'); ?>" class="form-control" id="password-field" required data-smk-msg="<?php echo esc_attr__('Please provide password','exertio_theme'); ?>">
                  <span data-toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span> </div>
              </div>
              <div class="fr-sigin-requirements">
                <div class="pretty p-icon p-thick p-curve">
                  <input type="checkbox" name="is_remember">
                  <div class="state p-warning"> <i class="icon fa fa-check"></i>
                    <label> </label>
                  </div>
                </div>
                <span class="sr-style"> <?php echo esc_html__('Keep me logged in','exertio_theme'); ?></span> <a href="#"  data-bs-toggle="modal" data-bs-target="#forget_pwd"> <span> <?php echo esc_html__('Forgot Password','exertio_theme'); ?></span></a> </div>
              <div class="fr-sign-submit">
                <div class="form-group d-grid">
					<?php
					$redirect_page = isset($_GET['redirect']) ? $_GET['redirect'] : '';
					if(isset($redirect_page) && $redirect_page !='')
					{
						$register_page = get_the_permalink($exertio_theme_options['register_page']).'?redirect='.$redirect_page;
					}
					else
					{
						$register_page = get_the_permalink($exertio_theme_options['register_page']);
					}
					?>
                  <button class="btn btn-theme btn-block btn-loading" id="signin-btn" type="button" data-redirect-id="<?php echo esc_attr($redirect_page); ?>"> <?php echo esc_html__('Sign in','exertio_theme'); ?>
                  <span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
                  </button>
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
            </form>
          </div>
          <div class="fr-sign-bundle-content">
            <p> <?php echo esc_html__('Don\'t have an account?','exertio_theme'); ?> <span><a href="<?php echo esc_url($register_page); ?>"><?php echo esc_html__('Register here','exertio_theme'); ?></a></span></p>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
        <div class="fr-sign-user-dashboard d-flex align-items-end">
          <div class="sign-in owl-carousel owl-theme">
            <?php
            $slides = $exertio_theme_options[ 'login_slides' ];
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
  <div class="modal fade forget_pwd" id="forget_pwd" tabindex="-1" role="dialog" aria-labelledby="forget_pwd" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo esc_html__('Forget Password','exertio_theme'); ?></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body">
          <form id="fl-forget-form">
            <div class="fr-sign-form">
              <div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/mail.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
              <div class="form-group">
                <input type="email"  name="fl_forget_email" placeholder="<?php echo esc_attr__('Registered email address','exertio_theme'); ?>" class="form-control" required data-smk-msg="<?php echo esc_attr__('Please provide valid registered email address','exertio_theme'); ?>">
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-theme btn-block btn-loading" id="forget_btn"><?php echo esc_html__('Recover now','exertio_theme'); ?>
              <span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
              </button>
              <input type="hidden" id="fl_forget_pwd_nonce" value="<?php echo wp_create_nonce('fl_forget_pwd_secure'); ?>"  />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
} else {
  echo exertio_redirect( get_the_permalink( $exertio_theme_options[ 'user_dashboard_page' ] ) );
}
?>
<?php get_footer(); ?>
