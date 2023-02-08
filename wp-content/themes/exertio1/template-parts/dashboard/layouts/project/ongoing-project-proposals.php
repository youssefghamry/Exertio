<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();
$project_id = $_GET['project-id'];
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
								<h2><?php echo esc_html__('Ongoing Project Proposals','exertio_theme');?></h2>
								<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
									<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
									<?php echo exertio_dashboard_extention_return(); ?>
								</div>
							  </div>
							</div>
							<?php
							$allow_milestone = '';
							$allow_milestone = fl_framework_get_options('allow_project_milestones');
							if(isset($allow_milestone) && $allow_milestone == 1)
							{
								/*FOR THE WALLET SYSTEM REMOVAL*/
								$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
								if(isset($is_wallet_active) && $is_wallet_active == 0)
								{
							?>
								<div class="d-flex justify-content-between align-items-end flex-wrap">
								  <button class="btn btn-theme-secondary mt-2 mt-xl-0" data-toggle="modal" data-target="#milestone"><?php echo esc_html__('Create Milestone', 'exertio_theme' ); ?></button>
								</div>
							<?php
								}
							}
							?>
						  </div>
						</div>
					</div>
					<?php
					?>
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
									<?php
										if( fl_framework_get_options('turn_project_messaging') == true)
										{
											?>
											<span class=""> <?php echo esc_html__( 'Total Proposals', 'exertio_theme' ).' ('.$total_count.')'; ?></span>
											<?php
										}
										else
										{
											?>
										<form>                
											<select class="form-control general_select_2 prject_status">
												<option value=""><?php echo esc_html__( 'Project status', 'exertio_theme' ); ?></option>
												<option value="complete"><?php echo esc_html__( 'Complete', 'exertio_theme' ); ?></option>
												<option value="cancel"><?php echo esc_html__( 'Cancel', 'exertio_theme' ); ?></option>
											</select>
											<button type="button" class="btn btn-theme btn-loading" id="project_status" data-pid="<?php echo esc_attr($post->ID); ?>";><?php echo esc_html__( 'Update', 'exertio_theme' ); ?><div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button>
										</form>									  		<?php
										}
									?>
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
											$freelancer_user_id = get_post_field( 'post_author', $awarded_results->freelancer_id );
											$fl_id = $awarded_results->freelancer_id;
											$pro_img_id = get_post_meta( $awarded_results->freelancer_id, '_profile_pic_freelancer_id', true );
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
												<div class="fr-project-img-box"> <a href="<?php echo get_the_permalink($awarded_results->freelancer_id); ?>"><img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE); ?>" class="img-fluid"></a> </div>
												<div class="fr-project-user-details"> <a href="<?php echo get_the_permalink($awarded_results->freelancer_id); ?>">
												  <div class="h-style2"><?php echo exertio_get_username('freelancer',$awarded_results->freelancer_id, 'badge', 'right'); ?></div>
												  </a>
												  <ul>
													<li> <i class="far fa-clock"></i> <span><?php echo date_i18n( get_option( 'date_format' ), strtotime( $awarded_results->timestamp ) ); ?></span> </li>
													<li> <span> <?php echo get_freelancer_rating($awarded_results->freelancer_id, '', 'project'); ?></span> </li>
												  </ul>
												</div>
												<div class="fr-project-content-details">
													<?php
														if( fl_framework_get_options('whizzchat_project_option') == true)
														{
															if(in_array('whizz-chat/whizz-chat.php', apply_filters('active_plugins', get_option('active_plugins'))))
															{
															?>
																<a href="javascript:void(0)" class="chat_toggler btn btn-theme" data-user_id="<?php echo esc_attr($freelancer_user_id); ?>" data-page_id='<?php echo esc_attr($project_id); ?>'>
																	<i class="far fa-comment-alt"></i>
																	<?php echo esc_html__( 'Start Chat', 'exertio_theme' ); ?>
																</a>
														<?php
															}
														}
														if( fl_framework_get_options('turn_project_messaging') == true)
														{
															?>
															<a href="<?php get_template_part( 'project-propsals' );?>?ext=ongoing-project-detail&project-id=<?php echo esc_html($project_id); ?>" class="btn btn-theme-secondary"> <?php echo esc_html__( 'View Details', 'exertio_theme' ); ?></a>
															<?php
														}
													?>
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
								
								<?php
								$stored_milestone_data = get_post_meta($project_id,'_project_milestone_data', true);
								if(!empty($stored_milestone_data))
								{
									?>
									<div class="fr-project-box">
									  <h3><?php echo esc_html__( 'Milestones', 'exertio_theme' ); ?></h3>
									</div>
									<div class="milestone-section">
										<?php
										foreach($stored_milestone_data as $stored_milestone_data_array => $val)
										{
											$status = $status_msg = '';
											if($val['milestone_status'] == 'pending')
											{
												$status = 'yellow';
												$status_msg = __( 'Pending', 'exertio_theme' );
												$paid_btn = '<a href="javascript:void(0)" class="btn btn-theme-secondary milestone-paid" data-pid="'.esc_attr($project_id).'" data-mid="'.esc_attr($val['milestone_id']).'"> '.esc_html__( 'Pay Now', 'exertio_theme' ).'</a>';
											} 
											else if($val['milestone_status'] == 'paid')
											{
												$status = 'green';
												$status_msg = __( 'Paid', 'exertio_theme' );
												$paid_btn = '<div class="milestone-col-mini-box">
														<p>'.esc_html__( 'Paid date', 'exertio_theme' ).'</p>
														<div class="milestone-title">'.esc_html(date_i18n( get_option( 'date_format' ), strtotime( $val['milestone_paid_date'] ) )).'</div>
													</div>';
												
											}
										?>
										<div class="milestone-box">
											<div class="milstone-box-header">
												<div class="milestone-box-column">
													<span class="status-color <?php echo esc_attr($status); ?> protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($status_msg); ?>"></span>
													<div class="milestone-col-mini-box">
														<p> <?php echo esc_html($val['milestone_title']); ?> </p>
														<div class="milestone-title"> <?php  echo date_i18n( get_option( 'date_format' ), strtotime( $val['milestone_created_date'] ) ); ?></div>
													</div>
												</div>
												<div class="milestone-box-column">
													<div class="milestone-col-mini-box">
														<p class="primary"> <?php echo esc_html(fl_price_separator($val['total_project_amount'])); ?></p>
														<div class="milestone-title"> <?php echo esc_html__( 'Total Amount', 'exertio_theme' ); ?></div>
													</div>
												</div>
												<div class="milestone-box-column">
													<div class="milestone-col-mini-box">
														<p><?php echo esc_html(fl_price_separator($val['current_milestone_amount'])); ?></p>
														<div class="milestone-title"> <?php echo esc_html__( 'In Escrew', 'exertio_theme' ); ?></div>
													</div>
												</div>
												<div class="milestone-box-column">
													<div class="milestone-col-mini-box">
														<p><?php echo esc_html(fl_price_separator($val['milestone_amount_paid'])); ?></p>
														<div class="milestone-title"> <?php echo esc_html__( 'Amount Paid', 'exertio_theme' ); ?></div>
													</div>
												</div>
												<div class="milestone-box-column">
													<div class="milestone-col-mini-box">
														<p> <?php echo esc_html(fl_price_separator($val['milestone_remaining_amount'])); ?></p>
														<div class="milestone-title"> <?php echo esc_html__( 'Remaining Payment', 'exertio_theme' ); ?></div>
													</div>
													
												</div>
												<div class="milestone-box-column">
													<?php echo wp_return_echo($paid_btn); ?>
													<span class="milstone-errow show-milestone-detail" data-ml-id="<?php echo esc_attr($val['milestone_id']); ?>"><i class="fas fa-chevron-right"></i></span>
												</div>
											</div>
											<?php
											if($val['milestone_desc'] != '')
											{
												?>
												<div class="milestone-box-footer mlhide-<?php echo esc_attr($val['milestone_id']); ?>">
													<div class="milestone-desc">
														<p><?php echo esc_html($val['milestone_desc']); ?></p>
													</div>
												</div>
												<?php
											}
											?>
										</div>
										<?php
										}
										?>
									</div>
									<?php
								}
								?>
							  </div>

							  <!--OTHER PROPOSALS-->
							  <div class="fr-project-bidding proposals-dashboard">
								<?php
									$results = get_project_bids($project_id, $start_from, $limit, '', $hired_fler);
									$count_bids =0;
									if(isset($results))
									{
										$count_bids = count($results);	
									}
								?>
								<div class="fr-project-box">
								  <h3><?php echo esc_html__( 'Other Proposals', 'exertio_theme' ); ?></h3>
								</div>
								<div class="project-proposal-box">
								  <?php
									if($results)
									{
										foreach($results as $result)
										{
											$pro_img_id = get_post_meta( $result->freelancer_id, '_profile_pic_freelancer_id', true );
											if(wp_attachment_is_image($pro_img_id))
											{
												$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );
												$profile_image = $pro_img[0];
											}
											else
											{
												$profile_image = $exertio_theme_options['freelancer_df_img']['url'];
											}
											$is_sealer ='';
											$is_featured = '';
											$is_top = '';

											if($result->is_featured == 1)
											{
												$is_featured = 'featured-proposal';	
											}
											if($result->is_top == 1)
											{
												$is_top = 'top-proposal';	
											}
											if($result->is_sealed == 1)
											{
												$is_sealer = 'sealed-proposal';

											}
											?>
											  <div class="fr-project-inner-content <?php echo esc_attr($is_sealer.' '.$is_featured.' '.$is_top); ?>">
												<div class="fr-project-profile">
												  <div class="fr-project-profile-details">
													<div class="fr-project-img-box"> <a href="<?php echo get_the_permalink($result->freelancer_id); ?>"><img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE); ?>" class="img-fluid"></a> </div>
													<div class="fr-project-user-details"> <a href="<?php echo get_the_permalink($result->freelancer_id); ?>">
													  <div class="h-style2"><?php echo exertio_get_username('freelancer',$result->freelancer_id, 'badge', 'right'); ?></div>
													  </a>
													  <ul>
														<li> <i class="far fa-clock"></i> <span><?php echo date_i18n( get_option( 'date_format' ), strtotime( $result->timestamp ) ); ?></span> </li>
														<li> <span> <?php echo get_freelancer_rating($result->freelancer_id, '', 'project'); ?> </span> </li>
														<li> <span> <a href="javascript:void(0)" class="cover-letter" data-prpl-id ='<?php echo esc_html($result->id); ?>'> <?php echo esc_html__( 'View Cover Letter', 'exertio_theme' ); ?> </a></span> </li>
													  </ul>
													</div>
													<div class="fr-project-content-details">
													  <ul>
														<li> <span> <?php echo esc_html(fl_price_separator($result->proposed_cost)); ?> <small>
														  <?php
															if($type == 'fixed' || $type == 1)
															{
																echo wp_sprintf(__('in %s days', 'exertio_theme'), $result->day_to_complete);
															}
															else if($type == 'hourly' || $type == 2)
															{
																echo wp_sprintf(__('Estimated hours %s', 'exertio_theme'), $result->day_to_complete);
															}

														?>
														  </small> </span> </li>
														<li>
														  <?php if($result->is_top == 1){ ?>
														  <i class="fas fa-medal"></i>
														  <?php } ?>
														  <?php if($result->is_featured == 1){ ?>
														  <i class="far fa-star"></i>
														  <?php } ?>
														  <?php if($result->is_sealed == 1){ ?>
														  <i class="fas fa-lock"></i>
														  <?php } ?>
														</li>
													  </ul>
													</div>
												  </div>
												</div>
												<div class="fr-project-assets showhide_<?php echo esc_html($result->id); ?>">
												  <h5><?php echo esc_html__( 'Cover Letter', 'exertio_theme' ); ?></h5>
												  <p>
													<?php ?>
													<?php echo esc_html($result->cover_letter); ?></p>
												</div>
											  </div>
											<?php
										}
										?>
									  <span class="page-display"><?php echo esc_html__( 'Showing ', 'exertio_theme' ).esc_html($start_from); ?> - <?php echo esc_html($start_from+$limit).esc_html__( ' out of ', 'exertio_theme' ).esc_html($total_count); ?> </span>
									  <?php	
										echo custom_pagination($project_id, $pageno, $limit);
									}
									else
									{
										?>
										<div class="nothing-found"> <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
										<h3><?php echo esc_html__( 'No proposal found', 'exertio_theme' ); ?></h3>
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
				</div>
				<?php
//				if( fl_framework_get_options('turn_project_messaging') == false)
//				{
					?>
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
									<label> <?php echo esc_html__('Feedback ','exertio_theme'); ?> </label>
									<textarea class="form-control" name="feedback_text" rows="5" cols="10" required data-smk-msg="<?php echo esc_attr__('Please provide feedback','exertio_theme'); ?>"></textarea>
								</div>
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
					<!--MILESTONE MODAL-->
					<?php
					if($type == 'fixed' || $type == 1)
					{
						$project_price = get_post_meta($project_id, '_project_cost', true);
					}
					else if($type == 'hourly' || $type == 2)
					{
						$hourly_cost = get_post_meta($project_id, '_project_cost', true);
						$hours = get_post_meta($project_id, '_estimated_hours', true);
						$project_price = $hourly_cost*$hours;
					}
					else
					{
						$project_price = '';
					}
					?>
					<div class="modal fade review-modal" id="milestone" tabindex="-1" role="dialog" aria-labelledby="milestone" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title"><?php echo esc_html__('Create Milestones ','exertio_theme');?></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true"><i class="fas fa-times"></i></i></span>
							</button>
						  </div>
						  <div class="modal-body">
							<form id="milestone-form">
								<div class="form-group">
									<label> <?php echo esc_html__('Title ','exertio_theme'); ?> </label>
									<input type="text" class="form-control" name="milestone_title" required data-smk-msg="<?php echo esc_attr__('Title is required','exertio_theme'); ?>">
								</div>
								<div class="form-group">
									<label> <?php echo esc_html__('Total Amount','exertio_theme'); ?> </label>
									<input type="text" class="form-control" name="total_milestone_amount" disabled value="<?php echo esc_attr(fl_price_separator($project_price)); ?>">
								</div>
								<div class="form-group">
									<label> <?php echo esc_html__('Milestone Amount','exertio_theme'); ?> </label>
									<input type="number" class="form-control" name="current_milestone_amount" required data-smk-msg="<?php echo esc_attr__('Required field with digits only','exertio_theme'); ?>">
								</div>
								<div class="form-group">
									<label> <?php echo esc_html__('Description ','exertio_theme'); ?> </label>
									<textarea class="form-control" name="milestone_desc" rows="5" cols="10" required data-smk-msg="<?php echo esc_attr__('This is required','exertio_theme'); ?>"></textarea>
									<p> <?php echo esc_html__('Write a brief description.','exertio_theme'); ?></p>
								</div>
								<div class="form-group"> <button type="button" id="create-milestone" class="btn btn-theme btn-loading" data-post-id="<?php echo esc_attr($project_id) ?>"><?php echo esc_html__('Create Milestone','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
							</form>
						  </div>
						</div>
					  </div>
					</div>
					<?php
//				}
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
