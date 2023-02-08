<?php
$alt_id = '';
if(is_user_logged_in())
{
	$current_user = wp_get_current_user();
	$email = $current_user->user_email;
	?>
	<div class="deposit-box card">
		<div class="depoist-header">
			<div class="icon">
				<img src="<?php echo get_template_directory_uri(); ?>/images/icons/dollar.png" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
			</div>
			<div class="deposit-header-text">
				<h3> <?php echo esc_html__('Deposit funds ','exertio_theme'); ?></h3>
				<p><?php echo esc_html__('Add funds to your wallet ','exertio_theme'); ?></p>
			</div>
		</div>
		<div class="deposit-body">
			<form id="deposit-funds-form">
			<div class="form-row">
				<div class="form-group col-md-12">
				  <label> <?php echo esc_html__('Amount','exertio_theme').' ('.fl_framework_get_options('fl_currency').')'; ?></label>
				  <input type="number" class="form-control" name="custom_funds_amount" placeholder="<?php echo esc_html__('Amount without currency symbol ','exertio_theme'); ?>">
				</div>
				<div class="form-group col-md-12">
					<label> <?php echo esc_html__('Your email','exertio_theme'); ?></label>
				  <input type="text" class="form-control" name="funds_amount" disabled placeholder="<?php echo esc_attr($email); ?>">
				  <p><?php echo esc_html__(' You can not edit this field','exertio_theme'); ?></p>
				</div>
			</div>
			</form>
		</div>
		<div class="deposit-footer">
			<button type="button" id="deposit-funds-custom-btn" class="btn-loading">
				<i class="fa fa-lock"></i>
				<?php echo esc_html__(' Secure Deposit','exertio_theme'); ?>
				<div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
			</button>
			<input type="hidden" id="fl_deposit_funds_nonce" value="<?php echo wp_create_nonce('fl_deposit_funds_secure'); ?>"  />
		</div>
	</div>
	<?php
}
?>