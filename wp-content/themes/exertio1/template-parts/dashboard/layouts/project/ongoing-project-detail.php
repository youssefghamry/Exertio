<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();
$project_id = $_GET['project-id'];

$msg_author = get_user_meta( $current_user_id, 'employer_id' , true );
$alt_id = '';
$limit = get_option( 'posts_per_page' );
$start_from ='1';
if (isset($_GET["pageno"])) 
{  
  $pageno  = $_GET["pageno"];  
}  
else {  
  $pageno=1;  
}
$start_from = ($pageno-1) * $limit; 
	if( is_user_logged_in() )
	 {

		if(get_post_status ( $project_id ) == 'ongoing')
		{ 
			$results_count = get_project_bids($project_id);
			$total_count =0;
			if(isset($results_count))
			{
				$total_count = count($results_count);	
			}	 

			$project_author_id = get_post_field( 'post_author', $project_id );
			if($project_author_id == $current_user_id)
			{
			$post = get_post($project_id);
			?>
				<div class="content-wrapper ">
				  <div class="notch"></div>
				  <div class="row">
					<div class="col-md-12 grid-margin">
					  <div class="d-flex justify-content-between flex-wrap">
						<div class="d-flex align-items-end flex-wrap">
						  <div class="mr-md-3 mr-xl-5">
							<h2><?php echo esc_html__('Project Details','exertio_theme');?></h2>
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
					<div class="col-md-12 grid-margin stretch-card">
					  <div class="card mb-4">
						<div class="card-body">
						  <div class="pro-section project-details">
							<div class="pro-box">
							  <div class="pro-coulmn pro-title">
								<h4 class="pro-name"> <a href="<?php  echo esc_url(get_permalink()); ?>"><?php echo	esc_html($post->post_title); ?></a> </h4>
								<span class="pro-meta-box"> <span class="pro-meta"> <i class="far fa-clock"></i>
								<?php 
									$posted_date = get_the_date(get_option( 'date_format' ), $post->ID );
									echo esc_html($posted_date); 
								?>
								</span>
									<span class="pro-meta">
								<?php
									$level = get_term( get_post_meta($post->ID, '_project_level', true));
									if(!empty($level) && ! is_wp_error($level))
									{
										?>
										<i class="fas fa-layer-group"></i> <?php echo esc_html($level->name); ?>
										<?php
									}
								?>
									</span> 
								  </span>
								</div>
							  <div class="pro-coulmn">
								<?php 
										$category = get_term( get_post_meta($post->ID, '_project_category', true));
										if(!empty($category) && ! is_wp_error($category))
										{
											echo esc_html($category->name);
										}
									 ?>
							  </div>
							  <div class="pro-coulmn">
								<?php 
									$type =get_post_meta($post->ID, '_project_type', true);
									if($type == 'fixed' || $type == 1)
									{
										echo esc_html(fl_price_separator(get_post_meta($post->ID, '_project_cost', true))).'/'.esc_html__( 'Fixed ', 'exertio_theme' );
									}
									else if($type == 'hourly' || $type == 2)
									{
										echo esc_html(fl_price_separator(get_post_meta($post->ID, '_project_cost', true))).' / '.esc_html__( 'Hourly ', 'exertio_theme' );
										echo '<small class="estimated-hours">'.esc_html__( 'Estimated Hours ', 'exertio_theme' ).get_post_meta($post->ID, '_estimated_hours', true).'</small>';
									}
								 ?>
							  </div>
								<div class="pro-coulmn">
								<form>                
									<select class="form-control general_select_2 prject_status">
										<option value=""><?php echo esc_html__( 'Project status', 'exertio_theme' ); ?></option>
										<option value="complete"><?php echo esc_html__( 'Complete', 'exertio_theme' ); ?></option>
										<option value="cancel"><?php echo esc_html__( 'Cancel', 'exertio_theme' ); ?></option>
									</select>
									<button type="button" class="btn btn-theme btn-loading" id="project_status" data-pid="<?php echo esc_attr($post->ID); ?>";><?php echo esc_html__( 'Update', 'exertio_theme' ); ?><div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button>
								</form>
								</div>
							</div>
						  </div>
						  <?php
							$hired_fler = get_post_meta( $project_id, '_freelancer_assigned', true );
							$awarded_result = project_awarded($project_id, $hired_fler);
						  ?>
						  <div class="fr-project-bidding proposals-dashboard selcted">
							<?php
								$results = get_project_bids($project_id, $start_from, $limit);
								$count_bids =0;
								if(isset($results))
								{
									$count_bids = count($results);	
								}
				
							?>
							<div class="fr-project-box">
							  <h3><?php echo esc_html__( 'Hired Freelancer', 'exertio_theme' ); ?></h3>
							</div>
							<div class="project-proposal-box">
							  <?php
								if($awarded_result)
								{
									foreach($awarded_result as $awarded_results)
									{
										$fl_id = $awarded_results->freelancer_id;
										$pro_img_id = get_post_meta( $fl_id, '_profile_pic_freelancer_id', true );
										if(wp_attachment_is_image($pro_img_id))
										{
											$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );
											$profile_image = $pro_img[0];
										}
										else
										{
											$profile_image = $exertio_theme_options['freelancer_df_img']['url'];
										}
										?>
									  <div class="fr-project-inner-content">
										<div class="fr-project-profile">
										  <div class="fr-project-profile-details">
											<div class="fr-project-img-box"> <a href="<?php echo get_the_permalink($fl_id); ?>"><img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE); ?>" class="img-fluid"></a> </div>
											<div class="fr-project-user-details"> <a href="<?php echo get_the_permalink($fl_id); ?>">
											  <div class="h-style2"><?php echo exertio_get_username('freelancer', $fl_id, 'badge', 'right'); ?></div>
											  </a>
											  <ul>
												<li> <i class="far fa-clock"></i> <span><?php echo esc_html__( 'Assigned on: ', 'exertio_theme' ).date_i18n( get_option( 'date_format' ), strtotime( $awarded_results->timestamp ) ); ?></span> </li>
												<li> <span> <?php echo get_rating($fl_id, ''); ?></span> </li>
											  </ul>
											</div>
											<div class="fr-project-content-details"> 
											  <ul>
												<li> <span> <?php echo esc_html(fl_price_separator($awarded_results->proposed_cost)); ?> <small>
												  <?php
														if($type == 'fixed' || $type == 1)
														{
															echo wp_sprintf(__('in %s days', 'exertio_theme'), $awarded_results->day_to_complete);
														}
														else if($type == 'hourly' || $type == 2)
														{
															echo wp_sprintf(__('Estimated hours %s', 'exertio_theme'), $awarded_results->day_to_complete);
														}
													
													?>
												  </small> </span> </li>
											  </ul>
											</div>
										  </div>
										</div>
										<div class="fr-project-assets">
										  <h5><?php echo esc_html__( 'Cover Letter', 'exertio_theme' ); ?></h5>
										  <p>
											<?php ?>
											<?php echo esc_html($awarded_results->cover_letter); ?></p>
										</div>
									  </div>
									  <?php
									}
								}
						  ?>
							</div>
						  </div>
                          <!--PROJECT HISTORY-->
						  <div class="project-history">
								<h3><?php echo esc_html__( 'Project History', 'exertio_theme' ); ?></h3>
								<div class="history-body">
									<div class="history-chat-body">
										<?php
										$messages = get_history_msg($project_id);
										if($messages)
										{
											foreach($messages as $message)
											{
												$msg_author = get_user_meta( $current_user_id, 'employer_id' , true );
												if($msg_author == $message->msg_author)
												{
													?>
													<div class="chat-single-box">
														<div class="chat-single chant-single-right">
															<div class="history-user">
																<span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
																<a href="#" class="history-username "><?php echo exertio_get_username('employer',$message->msg_author, 'badge', 'right' ); ?></a>
																<span><?php echo get_profile_img($message->msg_author, "employer"); ?></span>
															</div>
															<p class="history-text">
																<?php echo esc_html(wp_strip_all_tags($message->message)); ?>
															</p>
															<?php
															if($message->attachment_ids >0)
															{
																?>
																<!--<a class="history_attch_dwld btn btn-black" href="javascript:void(0)" id="download-files" > Download</a>-->
																<div class="history_attch_dwld btn-loading" id="download-files" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
																	<i class="fas fa-arrow-down"></i>
																	<?php echo esc_html__( 'Attachments', 'exertio_theme' ); ?>
																	<div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
																</div>
																<?php
															 }
															 ?>
														</div>
													</div>
													<?php	
												}
												else
												{
													?>
													<div class="chat-single-box">
														<div class="chat-single success">
															<div class="history-user">
																<span>
																	<?php echo get_profile_img($message->msg_author, "freelancer"); ?>
																</span>
																<a href="#" class="history-username"><?php echo exertio_get_username('freelancer',$message->msg_author, 'badge', 'right');?></a>
																<span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
															</div>
															<p class="history-text">
																<?php echo esc_html(wp_strip_all_tags($message->message)); ?>
															</p>
															<?php
															if($message->attachment_ids >0)
															{
																?>
																<div class="history_attch_dwld btn-loading" id="download-files" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
																	<i class="fas fa-arrow-down"></i>
																	<?php echo esc_html__( 'Attachments', 'exertio_theme' ); ?>
																	<div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
																</div>
																<?php
															 }
															 ?>
														</div>
													</div>
													<?php
												}
											}
										}
										else
										{
											?>
											<p class="text-center"><?php echo esc_html__( 'No history found', 'exertio_theme' ); ?></p>
											<?php	
										}
										?>
									</div>
								</div>
						  </div>
						  <div class="history-msg-form">
							<h3><?php echo esc_html__( 'Send Message', 'exertio_theme' ); ?></h3>
							<div class="history-text">
								<form id="send_himstory_msg">
									<div class="form-row">
										<div class="form-group col-md-12">
											<textarea name="history_msg_text" id="" class="form-control" required data-smk-msg="<?php echo esc_attr__('Please provide message to send','exertio_theme'); ?>"></textarea>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<div class="upload-btn-wrapper">
												<button class="btn btn-theme-secondary mt-2 mt-xl-0" type="button"><?php echo esc_html__('Select Attachments','exertio_theme'); ?></button>
												<input type="file" id="gen_attachment_uploader" multiple name="project_attachments[]" accept = "image/pdf/doc/docx/ppt/pptx*" data-post-id="<?php echo esc_attr($project_id) ?>"/>
												<input type="hidden" name="attachment_ids" value="" id="history_attachments_ids">
											</div>
										</div>
									</div>
									<div class="form-row" >
											 <div class="form-group col-md-12 attachment-box"> 
											</div>
										</div>
									<div class="form-row">
										<div class="form-group col-md-12">
											<button type="button" class="btn btn-theme float-right btn-loading" id="history_msg_btn" data-post-id="<?php echo esc_attr($project_id) ?>" data-fl-id="<?php echo esc_attr($fl_id) ?>" data-msg-author="<?php echo esc_attr($msg_author) ?>">
												<?php echo esc_html__('Send Message','exertio_theme'); ?>
												<div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
											</button>
										</div>
									</div>
								</form>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>

                <!-- Modal -->
                <div class="modal fade review-modal" id="review-modal" tabindex="-1" role="dialog" aria-labelledby="review-modal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                      	<small><?php echo esc_html__('Provide Feedback to ','exertio_theme'); ?></small>
                        <h4 class="modal-title" id="review-modal"><?php echo exertio_get_username('freelancer',$fl_id, 'badge', 'right'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true"><i class="fas fa-times"></i></i></span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="rating-form">
                            <div class="reviews-star-box">
                                <ul>
                                  <li>
                                    <p><?php if(isset($exertio_theme_options['first_title'])){ echo esc_html($exertio_theme_options['first_title']); } ?></p>
                                    <div class="review stars-1"></div>
                                    <div class="form-group">
                                    <input type="text" id="stars-1" name="stars_1" value=""  required data-smk-msg="<?php echo esc_attr__('This is required','exertio_theme'); ?>">
                                    </div>
                                  </li>
                                  <li>
                                    <p><?php if(isset($exertio_theme_options['second_title'])){ echo esc_html($exertio_theme_options['second_title']); } ?></p>
                                    <div class="review stars-2"></div>
                                    <div class="form-group">
                                    <input type="text" id="stars-2" name="stars_2"  required data-smk-msg="<?php echo esc_attr__('This is required','exertio_theme'); ?>">
                                    </div>
                                  </li>
                                  <li>
                                    <p><?php if(isset($exertio_theme_options['third_title'])){ echo esc_html($exertio_theme_options['third_title']); } ?></p>
                                    <div class="review stars-3"></div>
                                    <div class="form-group">
                                    <input type="text" id="stars-3" name="stars_3"  required data-smk-msg="<?php echo esc_attr__('This is required','exertio_theme'); ?>">
                                    </div>
                                  </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label> <?php echo esc_html__('Feedback','exertio_theme'); ?> </label>
                                <textarea class="form-control" name="feedback_text" rows="5" cols="10" required data-smk-msg="<?php echo esc_attr__('Please provide feedback','exertio_theme'); ?>"></textarea>
                            </div>
							<?php
								if(isset($exertio_theme_options['allow_project_tip_reward']) && $exertio_theme_options['allow_project_tip_reward'] != 0)
								{
								?>
									<div class="reward_section">
										<div class="reviews-star-box">
											<ul>
												<li>
													<p> <?php echo esc_html__('Reward or Tip','exertio_theme'); ?>  </p>
													<div class="button_reward">
														<div class="pretty p-switch p-fill">
															<input type="checkbox" name="reward_tip_checkbox" id="reward_tip_checkbox" />
															<div class="state p-info"><label></label> </div>
														</div>
													</div>
												</li>
											</ul>
										</div>
										<div class="form-group reward_box">
											<input type="text" name="reward_tip" class="form-control" placeholder="<?php echo esc_attr__('Amount without currency sign','exertio_theme'); ?>">
										</div>
									</div>
								<?php
								}
							?>
                            <div class="form-group"> <button type="button" id="rating-btn" class="btn btn-theme btn-loading" data-pid="<?php echo esc_attr($project_id) ?>" data-status= "complete"><?php echo esc_html__('Complete & Submit','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!--cancel PROJECT MODAL-->
                <div class="modal fade review-modal" id="review-modal-cancel" tabindex="-1" role="dialog" aria-labelledby="review-modal-cancel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                      	<small><?php echo esc_html__('Provide Reason to ','exertio_theme'); ?></small>
                        <h4 class="modal-title" id="review-modal-cancel"><?php echo esc_html__('Cancel Project','exertio_theme'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true"><i class="fas fa-times"></i></i></span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="review-modal-cancel">
                            <div class="form-group">
                                <label> <?php echo esc_html__('Feedback ','exertio_theme'); ?> </label>
                                <textarea class="form-control" name="feedback_text" rows="5" cols="10" required data-smk-msg="<?php echo esc_attr__('Please provide reason','exertio_theme'); ?>"></textarea>
                                <p> <?php echo esc_html__('Provide information on why you are canceling this project.','exertio_theme'); ?></p>
                            </div>
                            <div class="form-group"> <button type="button" id="cancel-btn" class="btn btn-theme btn-loading" data-pid="<?php echo esc_attr($project_id) ?>" data-status= "cancel"><?php echo esc_html__('Cancel this project','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
			<?php
			}
			else
			{
				get_template_part( 'template-parts/dashboard/layouts/dashboard');
			}
		}
		else
		{
			get_template_part( 'template-parts/dashboard/layouts/dashboard');
		}
	}
	else
	{
		echo exertio_redirect(home_url('/'));
	?>
<?php
	}
	?>
