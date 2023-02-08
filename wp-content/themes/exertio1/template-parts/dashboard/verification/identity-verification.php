<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();

$fid = get_user_meta( $current_user_id, 'freelancer_id' , true );



	if( is_user_logged_in() )
	{
		?>
		<div class="content-wrapper">
        <div class="notch"></div>
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2><?php echo esc_html__('Identity Verification ','exertio_theme'); ?></h2>
                    <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
						<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
						<?php echo exertio_dashboard_extention_return(); ?>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-8 col-lg-12 col-md-12 grid-margin stretch-card">
			<?php
			$verification_exist = get_user_meta($current_user_id,'_identity_verification_Sent', true);
			if(isset($verification_exist) && $verification_exist == 1)
			{
				?>
				<form id="verification_form">
					<div class="card mb-4">
						<div class="card-body">
						  <h4 class="card-title"><?php echo esc_html__('Verification Details','exertio_theme'); ?></h4>
						  <div class="form-row">
							<div class="form-group col-md-12">
							   <label><?php echo esc_html__('You have already sent the verification document. Please revoke verification to send again.','exertio_theme'); ?></label>
							  <button type="button" class="btn btn-theme" id="fl_revoke_verification">
											<?php echo esc_html__('Revoke Verification','exertio_theme'); ?>
											<input type="hidden" id="save_verification_nonce" value="<?php echo wp_create_nonce('fl_save_verification_secure'); ?>"  />
									</button>
							</div>
						</div>

						</div>
					</div>
				</form>
				<?php
			}
		else
		{
			?>
			<form id="verification_form" enctype="multipart/form-data">
				<div class="card mb-4">
					<div class="card-body">
					  <h4 class="card-title"><?php echo esc_html__('Verification Details','exertio_theme'); ?></h4>
					  <div class="form-row">
						<div class="form-group col-md-6">
						  <label><?php echo esc_html__('Your Name','exertio_theme'); ?></label>
						  <input type="text" class="form-control" name="name" required data-smk-msg="<?php echo esc_attr__('Required', 'exertio_theme' ); ?>">
						</div>
						<div class="form-group col-md-6">
						  <label><?php echo esc_html__('Contact Number','exertio_theme'); ?></label>
						  <input type="text" class="form-control" name="contact_number" required data-smk-msg="<?php echo esc_attr__('Required', 'exertio_theme' ); ?>" data-smk-type="number">
						</div>
						<div class="form-group col-md-12">
							<label><?php echo esc_html__('CNIC / Passport / NIN / SSN','exertio_theme'); ?></label>
							<input type="text" class="form-control" name="verification_number" required data-smk-msg="<?php echo esc_attr__('Required', 'exertio_theme' ); ?>">
						</div>
						<div class="form-group col-md-6">
							<label><?php echo esc_html__('Upload Document','exertio_theme'); ?></label>
							<div class="upload-btn-wrapper">
								<span class="profile-img-container"></span>
								<div class="upload-btn-wrapper">
								<button class="btn btn-theme-secondary mt-2 mt-xl-0 verification_doc_btn" ><?php echo esc_html__('Select Document','exertio_theme'); ?></button>
								<input type="file" id="verification_doc" name="verification_doc" accept = "image/*" data-post-id="<?php echo esc_attr('9') ?>"/>
								<input type="hidden" class="attachment_id" name="attachment_id">

								</div>
							</div>
						</div>
						<div class="form-group col-md-12">
						  <label><?php echo esc_html__('Address','exertio_theme'); ?></label>
						  <textarea name="address" id="" class="form-control"></textarea>
						</div>
						  <p><?php echo esc_html__('Your account information should match with the document that you are providing.','exertio_theme'); ?></p>
					</div>

					</div>
			</div>
				<div class="card">
					<div class="card-body">
						<div class="form-row">
							<div class="col-md-12">
								<button type="button" class="btn btn-theme" id="fl_verification_btn" data-post-id="">
										<?php echo esc_html__('Submit Verification','exertio_theme'); ?>
										<input type="hidden" id="save_verification_nonce" value="<?php echo wp_create_nonce('fl_save_verification_secure'); ?>"  />
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<?php
		}
			?>
          </div>
        </div>
        </div>
	<?php
    }
	else
	{
		echo exertio_redirect(home_url('/'));
	}
	?>