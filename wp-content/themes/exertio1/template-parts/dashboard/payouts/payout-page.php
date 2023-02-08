<?php
global $exertio_theme_options;
$alt_id = '';
$current_user_id = get_current_user_id();
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} else if ( get_query_var( 'page' ) ) {
	/*This will occur if on front page.*/
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}
 if( is_user_logged_in() )
	 {
		// The Query
		$the_query = new WP_Query( 
									array( 
											'author__in' => array( $current_user_id ) ,
											'post_type' =>'payouts',
											'paged' => $paged,	
											'post_status'     => array('publish', 'pending'),
											'orderby' => 'date',
											'order'   => 'DESC',												
											)
										);
		
		$total_count = $the_query->found_posts;
$processing_fee = fl_framework_get_options('payout_processing_fee');

?>
<div class="content-wrapper">
    <div class="notch"></div>
    <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="mr-md-3 mr-xl-5">
            <h2><?php echo esc_html__('Payout Settings','exertio_theme'); ?></h2>
            <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
				<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
				<?php echo exertio_dashboard_extention_return(); ?>
			</div>
          </div>
        </div>
		<?php
		$manual_payout = '';
		$manual_payout = fl_framework_get_options('manual_payout_switch');
		if(isset($manual_payout) && $manual_payout == 1)
		{
		?>
		<div class="d-flex justify-content-between align-items-start flex-wrap">
		  <button class="btn btn-theme-secondary mt-2 mt-xl-0" data-toggle="modal" data-target="#manual_payout"><?php echo esc_html__('Create Payout', 'exertio_theme' ); ?></button>
		</div>
		<?php
		}
		?>
      </div>
    </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-12 col-md-12 grid-margin stretch-card">
              <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title"><?php echo esc_html__('Payout Methods','exertio_theme'); ?></h4>
						<div class="form-group">
                        	<?php
							$default_payout ='';
							$default_payout = get_user_meta($current_user_id,'_default_payout_method', true);
							?>
                        	<label><?php echo esc_html__('Select default payout method','exertio_theme'); ?></label>
                        	<select name="default_payout" class="form-control general_select" id="default_payout">
                            	<?php if(fl_framework_get_options('paypal_switch') == 1) { ?>
								<option value="paypal" <?php if($default_payout == 'paypal'){echo 'selected=selected'; } ?> ><?php echo esc_html__('PayPal','exertio_theme'); ?></option>
								<?php }?>
								<?php if(fl_framework_get_options('bank_transfer_switch') == 1) { ?>
                                <option value="bank" <?php if($default_payout == 'bank'){echo 'selected=selected'; } ?>><?php echo esc_html__('Bank Transfer','exertio_theme'); ?></option>
								<?php } ?>
								<?php if(fl_framework_get_options('payoneer_switch') == 1) { ?>
                                <option value="payoneer" <?php if($default_payout == 'payoneer'){echo 'selected=selected'; } ?>><?php echo esc_html__('Payoneer','exertio_theme'); ?></option>
								<?php } ?>
                            </select>
                        </div>
                      <div class="payment_box">
                      	<h4 class="card-title"><?php echo esc_html__('Payout details','exertio_theme'); ?></h4>
                        <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                        	<?php
							if(fl_framework_get_options('paypal_switch') == 1)
							{
								?>
								<li class="nav-item"> <a class="nav-link <?php if($default_payout == 'paypal'){echo 'active'; } ?>" data-toggle="pill" href="#nav-tab-paypal"> <i class="fab fa-paypal"></i> <?php echo esc_html__('Paypal','exertio_theme'); ?></a></li>
								<?php
							}
							if(fl_framework_get_options('bank_transfer_switch') == 1)
							{
								?>
								<li class="nav-item"> <a class="nav-link <?php if($default_payout == 'bank'){echo 'active'; } ?>" data-toggle="pill" href="#nav-tab-bank"> <i class="fa fa-university"></i> <?php echo esc_html__('Bank Transfer','exertio_theme'); ?></a></li>
								<?php
							}
							if(fl_framework_get_options('payoneer_switch') == 1)
							{
								?>
								<li class="nav-item"> <a class="nav-link <?php if($default_payout == 'payoneer'){echo 'active'; } ?>" data-toggle="pill" href="#nav-tab-card"> <i class="fa fa-credit-card"></i><?php echo esc_html__(' Payoneer','exertio_theme'); ?></a></li>
								<?php
							}
							?>
                        </ul>
                        <div class="tab-content">
                        	<?php
							if(fl_framework_get_options('paypal_switch') == 1)
							{
								?>
                                <div class="tab-pane fade <?php if($default_payout == 'paypal'){echo 'active show'; } ?>" id="nav-tab-paypal">
                                    <?php
                                        $decoded_paypal = $paypal_email = '';
                                        $decoded_paypal = json_decode(get_user_meta($current_user_id,'_paypal_details', true));
                                        //print_r($decoded_paypal);
										if(!empty($decoded_paypal))
										{
											foreach($decoded_paypal as $paypal_detail)
											{
												$paypal_email = $paypal_detail->paypal_email;
											}
										}
                                        ?>
                                        <form id="paypal_pm_form">
                                          <div class="form-group">
                                            <label for="paypal"><?php echo esc_html__('PayPal Account Email','exertio_theme'); ?></label>
                                            <input type="email" class="form-control" name="paypal_email" required="" value="<?php echo esc_attr($paypal_email); ?>" data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>">
                                          </div>
                                          <button class="btn btn-theme btn-loading" id="paypal_pm_btn" type="button" data-peyment-method="paypal"><?php echo esc_html__('Save Detail','exertio_theme'); ?><div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button>
                                        </form>
                                  </div>
                                <?php
							}
							if(fl_framework_get_options('bank_transfer_switch') == 1)
							{
								?>
								<div class="tab-pane fade <?php if($default_payout == 'bank'){echo 'active show'; } ?>" id="nav-tab-bank">
									<p> <?php echo esc_html__('Bank accaunt details','exertio_theme'); ?></p>
                                    <?php
                                    $decoded_bank = $bank_name = $bank_acc_number = $bank_acc_name = $bank_routing_no = $bank_iban = $bank_swift = '';
                                    $decoded_bank = json_decode(get_user_meta($current_user_id,'_bank_account_details', true));
									if(!empty($decoded_bank))
									{
										foreach($decoded_bank as $bank_detail)
										{
											$bank_name = $bank_detail->bank_name;
											$bank_acc_number = $bank_detail->bank_acc_number;
											$bank_acc_name = $bank_detail->bank_acc_name;
											$bank_routing_no = $bank_detail->bank_routing_no;
											$bank_iban = $bank_detail->bank_iban;
											$bank_swift = $bank_detail->bank_swift;
										}
									}
									?>
									<form id="bank_pm_form">
                                      <div class="form-group">
                                        <label for="bank_name"><?php echo esc_html__('Bank Name','exertio_theme'); ?></label>
                                        <input type="text" class="form-control" name="bank_name" value="<?php echo esc_attr($bank_name); ?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="bank_account_number"><?php echo esc_html__('Bank Account Number','exertio_theme'); ?></label>
                                        <input type="text" class="form-control" name="bank_account_number" value="<?php echo esc_attr($bank_acc_number); ?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="bank_name"><?php echo esc_html__('Bank Account Holder Name','exertio_theme'); ?></label>
                                        <input type="text" class="form-control" name="bank_account_name" value="<?php echo esc_attr($bank_acc_name); ?>">
                                      </div>
                                      <div class="form-group">
                                        <label for="bank_account_number"><?php echo esc_html__('Bank Routing Number','exertio_theme'); ?></label>
                                        <input type="text" class="form-control" name="bank_routing_number" value="<?php echo esc_attr($bank_routing_no); ?>">
                                      </div>
                                      
                                      <div class="row">
                                        <div class="col-sm-7">
                                          <div class="form-group">
                                            <label><?php echo esc_html__('Bank IBAN','exertio_theme'); ?></label>
                                            <div class="input-group">
                                              <input type="text" class="form-control" name="bank_iban_number" value="<?php echo esc_attr($bank_iban); ?>">
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-5">
                                          <div class="form-group">
                                            <label><?php echo esc_html__('Swift Code','exertio_theme'); ?> </label>
                                            <input type="text" class="form-control" name="bank_swift_code" value="<?php echo esc_attr($bank_swift); ?>">
                                          </div>
                                        </div>
                                      </div>
                                      <button class="btn btn-theme btn-loading" id="bank_pm_btn" type="button" data-peyment-method="bank"><?php echo esc_html__('Save Detail','exertio_theme'); ?><div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button>
                                    </form>
								  </div>
								<?php
							}
							if(fl_framework_get_options('payoneer_switch') == 1)
							{
								?>
								<div class="tab-pane fade <?php if($default_payout == 'payoneer'){echo 'active show'; } ?>" id="nav-tab-card">
									<?php
										$decoded_payoneer = $payoneer_acc_name = $payoneer_email = $payoneer_acc_country = '';
										$decoded_payoneer = json_decode(get_user_meta($current_user_id,'_payoneer_details', true));
										//print_r($decoded_payoneer);
										if(!empty($decoded_payoneer))
										{
											foreach($decoded_payoneer as $payoneer_detail)
											{
												$payoneer_acc_name = $payoneer_detail->payoneer_acc_name;
												$payoneer_email = $payoneer_detail->payoneer_email;
												$payoneer_acc_country = $payoneer_detail->payoneer_acc_country;
											}
										}
									?>
									<form id="payoneer_pm_form">
									  <div class="form-group">
										<label for="payoneer_acc_name"><?php echo esc_html__('Payoneer Account Name','exertio_theme'); ?></label>
										<input type="text" class="form-control" name="payoneer_acc_name" required="" value="<?php echo esc_attr($payoneer_acc_name); ?>"  data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>">
									  </div>
									  <div class="form-group">
										<label for="cardNumber"><?php echo esc_html__('Payoneer Email','exertio_theme'); ?></label>
										<input type="email" class="form-control" name="payoneer_email" required="" value="<?php echo esc_attr($payoneer_email); ?>"  data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>">
										</div>
									  <div class="form-group">
										<label for="cardNumber"><?php echo esc_html__('Country','exertio_theme'); ?></label>
										<input type="text" class="form-control" name="payoneer_country" required="" value="<?php echo esc_attr($payoneer_acc_country); ?>"  data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>">
										</div>
									  <button class="btn btn-theme btn-loading" id="payoneer_pm_btn" type="button" data-peyment-method="payoneer"><?php echo esc_html__('Save Detail','exertio_theme'); ?><div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button>
									</form>
								</div>
								<?php
							}
							?>
                        </div>
                        <?php
						if(fl_framework_get_options('payout_note'))
						{
							?>
                        	<p class="payout_note"><?php echo esc_html(fl_framework_get_options('payout_note')); ?></p>
                            <?php
						}
						?>
                      </div>
                </div>
              </div>
        </div>  
        <div class="col-xl-8 col-lg-12 col-md-12 grid-margin stretch-card">
              <div class="card mb-4">
                <div class="card-body">
                <div class="pro-section">
              <div class="pro-box heading-row">
                <div class="pro-coulmn pro-title"><?php echo esc_html__( 'Payout Amount', 'exertio_theme' );	 ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Date', 'exertio_theme' );	 ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Payment Method', 'exertio_theme' ) ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Status', 'exertio_theme' ); ?> </div>
              </div>
				<?php
					if ( $the_query->have_posts() )
					{
						while ( $the_query->have_posts() ) 
						{
							$the_query->the_post();
							$pid = get_the_ID();
							$posted_date =  date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );
							
							
							
							?>
							  <div class="pro-box">
								<div class="pro-coulmn pro-title">
									<h4 class="pro-name"><?php echo fl_price_separator(get_post_meta($pid,'_payout_amount',true));; ?></h4>
								</div>
								<div class="pro-coulmn">
									<?php  echo esc_html($posted_date);  ?>
								</div>
								<div class="pro-coulmn payouts-method">
									<?php 
										$payment_method = get_post_meta($pid,'_payout_method',true);
										if($payment_method =='paypal'){ echo '<img src="'.get_template_directory_uri().'/images/dashboard/paypal-logo.png" alt="'.get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE).'">'; }
										if($payment_method =='bank'){ echo '<img src="'.get_template_directory_uri().'/images/dashboard/bank-transfer-logo.png" alt="'.get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE).'">'; }
										if($payment_method =='payoneer'){ echo '<img src="'.get_template_directory_uri().'/images/dashboard/payoneer-logo.png" alt="'.get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE).'">'; }
									 ?>
								</div>
								<div class="pro-coulmn">
                                	<?php
										$payout_status = get_post_meta($pid,'_payout_status',true);
										if($payout_status == 'pending')
										{
											echo '<span class="badge btn btn-inverse-warning">'.esc_html__( 'Pending', 'exertio_theme' ).'</span>';
										}
										else if($payout_status == 'processed')
										{
											echo '<span class="badge btn btn-inverse-success">'.esc_html__( 'Processed', 'exertio_theme' ).'</span>';
										}
									?>
                                	
                                </div>
							  </div>
						  
							<?php
						}
						
						fl_pagination($the_query);
						wp_reset_postdata();
					}
					else
					{
						?>
                        <div class="nothing-found">
                            <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
                            <h3><?php echo esc_html__( 'Sorry!!! No Record Found', 'exertio_theme' ) ?></h3>
                        </div>
                        <?php	
					}
				?>
          </div>
                </div>
              </div>
        </div>          
    </div>
</div>
<!--CREATE MANUAL PAYOUT MODAL-->
<div class="modal fade review-modal" id="manual_payout" tabindex="-1" role="dialog" aria-labelledby="milestone" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title"><?php echo esc_html__('Create Payout','exertio_theme'); ?></h4>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true"><i class="fas fa-times"></i></i></span>
		</button>
	  </div>
	  <div class="modal-body">
		<form id="create_payout-form">
			<div class="form-group">
				<label> <?php echo esc_html__('Payout Amount','exertio_theme'); ?> </label>
				<input type="number" class="form-control" name="payout_amount" required data-smk-msg="<?php echo esc_attr__('Required field without decimal','exertio_theme'); ?>">
				<p><?php echo esc_html__('Make sure you have provided your default payout method','exertio_theme'); ?></p>
			</div>
			<div class="form-group">
				<label> <?php echo esc_html__('Payout Processing Fee','exertio_theme'); ?> </label>
				<input type="text" class="form-control" name="payout_amount" disabled required data-smk-msg="<?php echo esc_attr__('Required field without decimal','exertio_theme'); ?>" value="<?php echo esc_attr(fl_price_separator($processing_fee)); ?>">
				<p><?php echo esc_html__('The payout processing fee will be deducted from your total amount.','exertio_theme'); ?></p>
			</div>
			<div class="form-group"> <button type="button" id="create-payout-btn" class="btn btn-theme btn-loading"><?php echo esc_html__('Submit & Create','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
		</form>
	  </div>
	</div>
  </div>
</div>
<?php
	}
	else
	{
		echo exertio_redirect(home_url('/'));
	?>
<?php
	}
	?>
