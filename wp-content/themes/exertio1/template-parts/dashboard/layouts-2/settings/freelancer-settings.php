<?php
global $exertio_theme_options;
$alt_id = '';
 if( is_user_logged_in() )
	 {
	 	$current_user_id = get_current_user_id();;
	 
		$settings = get_user_meta( $current_user_id, '_freelancer_settings', true );
		$decoded_settings =  json_decode(stripslashes($settings), true);
		?>
		<div class="content-wrapper">
			<div class="notch"></div>
			<div class="row">
			<div class="col-md-12 grid-margin">
			  <div class="d-flex justify-content-between flex-wrap">
				<div class="d-flex align-items-end flex-wrap">
				  <div class="mr-md-3 mr-xl-5">
					<h2><?php echo esc_html__('Freelancer Settings','exertio_theme'); ?></h2>
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
					<div class="card mb-4">
						<div class="card-body settings">
							<form id="freelancer-setting-form">
								<div class="row">
									<div class="col-3">
										<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
											<a class="nav-link active" id="v-pills-payout-tab" data-toggle="pill" href="#v-pills-payout" role="tab" aria-controls="v-pills-home" aria-selected="true"><?php echo esc_html__('Payout Setting', 'exertio_theme' ); ?></a>
										</div>
									</div>
									<div class="col-9">
										<div class="tab-content" id="v-pills-tabContent">
											<div class="tab-pane fade show active" id="v-pills-payout" role="tabpanel" aria-labelledby="v-pills-payout-tab">
												<div class="form-group inline-options">
													<?php
	 												$payout_checked = '';
	 												if(isset($decoded_settings) && $decoded_settings != '')
													{
														if($decoded_settings[0]['_enable_payout'] == 1)
														{
															$payout_checked = 'checked="checked"';
														}
													}
	 												?>
													<div class="heading-side">
														<label class="heading"><?php echo esc_html__('Enable Payout','exertio_theme'); ?></label>
														<p><?php echo esc_html__('Turn this option ON if you want to enable auto payout. ', 'exertio_theme' ); ?></p>
													</div>
													<div class="pretty p-switch p-fill">
														<input type="checkbox" name="enable_payout" <?php echo esc_attr($payout_checked); ?>/>
														<div class="state p-info"><label></label> </div>
													</div>
												</div>
											</div>
										</div>
										<div class="submit-button">
											<button type="button" id="freelancer_setting_btn" class="btn btn-theme  btn-loading"> <?php echo esc_html__('Save Settings', 'exertio_theme' ); ?>
											<span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>

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
