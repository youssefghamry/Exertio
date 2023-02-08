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
		if(get_post_status ( $project_id ) == 'publish')
		{
		 	$post_author = get_post_field( 'post_author', $project_id );
			if($post_author == $current_user_id)
			{
				$results_count = get_project_bids($project_id);
				$total_count =0;
				if(isset($results_count))
				{
					$total_count = count($results_count);	
				}	 
				$post = get_post($project_id);
				?>
				<div class="content-wrapper ">
				  <div class="notch"></div>
				  <div class="row">
					<div class="col-md-12 grid-margin">
					  <div class="d-flex justify-content-between flex-wrap">
						<div class="d-flex align-items-end flex-wrap">
						  <div class="mr-md-3 mr-xl-5">
							<h2><?php echo esc_html__('Proposals','exertio_theme'); ?></h2>
							<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
								<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
								<?php echo exertio_dashboard_extention_return(); ?>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <?php
				?>
				  <div class="row">
					<div class="col-md-12 grid-margin stretch-card only-proposals">
					  <div class="card mb-4">
						<div class="card-body">
						  <div class="pro-section project-details">
							  <div class="pro-box">
								<div class="pro-coulmn pro-title">
									<h4 class="pro-name">
										<a href="<?php  echo esc_url(get_permalink()); ?>"><?php echo	esc_html($post->post_title); ?></a>
									</h4>
									<span class="pro-meta-box">
										<span class="pro-meta">
											<i class="far fa-clock"></i>
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
											echo esc_html(fl_price_separator(get_post_meta($post->ID, '_project_cost', true)).'/'.esc_html__( 'Fixed ', 'exertio_theme' ));
										}
										else if($type == 'hourly' || $type == 2)
										{
											echo esc_html(fl_price_separator(get_post_meta($post->ID, '_project_cost', true)).' / '.esc_html__( 'Hourly ', 'exertio_theme' ));
											echo '<small class="estimated-hours">'.esc_html__( 'Estimated Hours ', 'exertio_theme' ).get_post_meta($post->ID, '_estimated_hours', true).'</small>';
										}
									 ?>
								</div>
								<div class="pro-coulmn"><span class="btn btn-theme-secondary"> <?php echo esc_html__( 'Total Proposals', 'exertio_theme' ).' ('.$total_count.')'; ?></span></div>
							  </div>
						  </div>
						   <div class="fr-project-bidding proposals-dashboard only-proposals">
									<?php
											$results = get_project_bids($project_id, $start_from, $limit);
											$count_bids =0;
											if(isset($results))
											{
												$count_bids = count($results);	
											}
										?>
										<div class="fr-project-box">
										  <h3><?php echo esc_html__( 'Proposals', 'exertio_theme' ); ?></h3>
										</div>
										<div class="project-proposal-box">
										  <?php

										if($results)
										{

											foreach($results as $result)
											{
												$freelancer_user_id = get_post_field( 'post_author', $result->freelancer_id );
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
												/* Getting Zoom Meeting Data */
                                                $meeting_info = get_post_meta($project_id, '_zoom_meeting-' . $result->freelancer_id, true);
                                                $meeting_id = ( isset($meeting_info['_exertio_meet_id']) && $meeting_info['_exertio_meet_id'] != "" ) ? $meeting_info['_exertio_meet_id'] : '';
                                                if ($meeting_id == '') {
                                                    $meeting_btn = esc_html__('Create Meeting', 'exertio_theme');
                                                } else {
                                                    $meeting_btn = esc_html__('Update Meeting', 'exertio_theme');
                                                }
												?>
												  <div class="fr-project-inner-content <?php echo esc_attr($is_sealer.' '.$is_featured.' '.$is_top); ?>">
													<div class="fr-project-profile">
													  <div class="fr-project-profile-details">
														<div class="fr-project-img-box 12"> <a href="<?php  echo esc_url(get_permalink($result->freelancer_id)); ?>"><img src="<?php echo esc_url($profile_image); ?>" alt="<?php echo get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE); ?>" class="img-fluid"></a> </div>
														<div class="fr-project-user-details"> <a href="<?php  echo esc_url(get_permalink($result->freelancer_id)); ?>">
														  <div class="h-style2"> <?php echo exertio_get_username('freelancer', $result->freelancer_id, 'badge', 'right'); ?></div>
														  </a>
														  <ul>
															<li> <i class="far fa-clock"></i> <span><?php echo date_i18n( get_option( 'date_format' ), strtotime( $result->timestamp ) ); ?></span> </li>
															<li> <span> <?php echo get_rating($result->freelancer_id, ''); ?></span> </li>
															<li> <span> <a href="javascript:void(0)" class="cover-letter" data-prpl-id ='<?php echo esc_html($result->id); ?>'> <?php echo esc_html__( 'View Cover Letter', 'exertio_theme' ); ?> </a></span> </li>
														  </ul>
															<?php
															if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
															{
																if($exertio_theme_options['zoom_meeting_btn'] == 1)
																{
																	?>
																	<!--ZOOM MEETING BUTTON-->
																	<span class="pro-btns">
																		<a href="javascript:void(0)" class="btn btn-inverse-primary btn-sm btn-loading meeting_authorization" data-pid="<?php echo esc_attr($project_id); ?>" data-fl-id="<?php echo esc_attr($result->freelancer_id); ?>">
																			<i class="far fa-phone-alt"></i> <?php echo esc_attr($meeting_btn); ?></a>
																	</span>
																	<?php
																}
															}
															?>
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
															?>
															<button type="button" class="btn btn-theme-secondary btn-loading" id="assign_project" data-pid="<?php echo esc_attr($project_id); ?>" data-fl-id="<?php echo esc_attr($result->freelancer_id); ?>"> <?php echo esc_html__( 'Hire Now', 'exertio_theme' ); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button>
														  <ul>
															<li>
																<span>
																	<?php echo esc_html(fl_price_separator($result->proposed_cost)); ?> 
																	<small>
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
																	</small>
																</span> 
															</li>

															<li>
															  <?php if($result->is_top == 1){ ?>
															  <i class="fas fa-medal protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'Sticky Proposal', 'exertio_theme' ); ?>"></i>
															  <?php } ?>
															  <?php if($result->is_featured == 1){ ?>
															  <i class="far fa-star protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'Featured Proposal', 'exertio_theme' ); ?>"></i>
															  <?php } ?>
															  <?php if($result->is_sealed == 1){ ?>
															  <i class="fas fa-lock protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__( 'Sealed Proposal', 'exertio_theme' ); ?>"></i>
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

											echo custom_pagination($project_id, $pageno, $limit);
											wp_reset_postdata();
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