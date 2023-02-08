<?php 
$alt_id = '';
$reset_key = '';
if(isset($_GET['key']))
{
	$reset_key = $_GET['key'];	
}
?>
<div class="modal fade forget_pwd" id="mynewpass" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="modal-from new-my-pass" method="POST" id="mynewPass">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo esc_html__('Reset Your Password', 'exertio_theme'); ?></h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
        <div class="fr-sign-form">
        	<div class="fr-sign-logo"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/mail.png" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
          <div class="form-group">
            <input type="password" required data-smk-msg="<?php echo esc_attr__('New password is needed','exertio_theme'); ?>" name="password" class="form-control" placeholder="<?php echo esc_attr__('Enter new password','exertio_theme'); ?>">
            </div>
            <div class="form-group">
				<?php //wp_nonce_field( 'new_pwd_nonce_secure', 'new_pass_nonce' ); ?>
                <input type="hidden" id="fl_forget_new_pwd_nonce" value="<?php echo wp_create_nonce('fl_forget_new_psw_secure'); ?>"  />
                <input type="hidden" name="requested_user_id" value="">
                <input type="hidden" name="reset_key" value="<?php echo esc_html($reset_key); ?>">
                <button type="button" class="btn btn-theme btn-loading btn-reset-new"><?php echo esc_html__("Change My Password", 'exertio_theme'); ?><span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span></button>
            </div>
        </div>
        
        </div>
      </form>
    </div>
  </div>
</div>

