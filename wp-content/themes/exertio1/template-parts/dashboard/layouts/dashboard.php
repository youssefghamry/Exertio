<?php
$alt_id = '';
$current_user_id = get_current_user_id();
	$show_featured = array(
			'key'       => '_project_is_featured',
			'value'     => '1',
			'compare'   => '=',
		);
	$featured_projects = fl_get_projects('', $current_user_id, $show_featured , '');
	$project_count_featured = $featured_projects->found_posts;


	$author_id = get_user_meta( $current_user_id, 'employer_id' , true );

	$total_projects = fl_get_projects('', $current_user_id, '' , '');
	$project_count = $total_projects->found_posts;

	$ongoing_projects = fl_get_projects('', $current_user_id, '' , 'ongoing');
	$project_count_ongoing = $ongoing_projects->found_posts;

	$completed_projects = fl_get_projects('', $current_user_id, '' , 'completed');
	$project_count_completed = $completed_projects->found_posts;

//$data = do_action( 'exertio_notification_filter',array('post_id'=> 1102,'n_type'=>'project','sender_id'=>'5','receiver_id'=>'4') );
//exertio_store_notifications_callback(array('post_id'=> 1102,'n_type'=>'project','sender_id'=>'5','receiver_id'=>'4'));
//$featured_projects = '';
?>
<div class="content-wrapper">
	<div class="row">
	<div class="col-md-12 grid-margin">
	  <div class="d-flex justify-content-between flex-wrap align-items-center">
		<div class="d-flex flex-wrap flex-column">
		  <div class="mr-md-3 mr-xl-5">
			<h2><?php echo esc_html__('Welcome back Employer', 'exertio_theme' )?></h2>
		  </div>
		  <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
			<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
		  </div>
		</div>
	  </div>
	</div>
	</div>
	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="row">		
				<div class="col-md-6 col-lg-6 col-xl-3">
					<div class="info-boxes">
						<div class="metric">
							<span class="icon">
								<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><g fill="#626262"><path fill-rule="evenodd" d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-6h-1v6a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-6H0v6z"/><path fill-rule="evenodd" d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5v2.384l-7.614 2.03a1.5 1.5 0 0 1-.772 0L0 6.884V4.5zM1.5 4a.5.5 0 0 0-.5.5v1.616l6.871 1.832a.5.5 0 0 0 .258 0L15 6.116V4.5a.5.5 0 0 0-.5-.5h-13zM5 2.5A1.5 1.5 0 0 1 6.5 1h3A1.5 1.5 0 0 1 11 2.5V3h-1v-.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5V3H5v-.5z"/></g></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__('Projects Posted', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($project_count); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>?ext=projects"><?php echo esc_html__('View Detail', 'exertio_theme' ); ?> <i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>

				<div class="col-md-6 col-lg-6 col-xl-3">
					<div class="info-boxes">
						<div class="metric">
							<span class="icon">
								<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><path class="clr-i-outline clr-i-outline-path-1" d="M27.19 34a2.22 2.22 0 0 1-1.24-.38l-7.46-5a.22.22 0 0 0-.25 0l-7.46 5a2.22 2.22 0 0 1-3.38-2.41l2.45-8.64a.23.23 0 0 0-.08-.24l-7.06-5.55a2.22 2.22 0 0 1 1.29-4l9-.34a.23.23 0 0 0 .2-.15l3.1-8.43a2.22 2.22 0 0 1 4.17 0l3.1 8.43a.23.23 0 0 0 .2.15l9 .34a2.22 2.22 0 0 1 1.29 4L27 22.33a.22.22 0 0 0-.08.24l2.45 8.64A2.23 2.23 0 0 1 27.19 34zm-8.82-7.42a2.21 2.21 0 0 1 1.23.42l7.46 5a.22.22 0 0 0 .34-.25l-2.45-8.64a2.21 2.21 0 0 1 .77-2.35l7.06-5.55a.22.22 0 0 0-.13-.4l-9-.34a2.22 2.22 0 0 1-2-1.46l-3.1-8.43a.22.22 0 0 0-.42 0L15.06 13a2.22 2.22 0 0 1-2 1.46l-9 .34a.22.22 0 0 0-.13.4L11 20.76a2.22 2.22 0 0 1 .77 2.35l-2.44 8.64a.21.21 0 0 0 .08.24a.2.2 0 0 0 .26 0l7.46-5a2.22 2.22 0 0 1 1.23-.37z" fill="#626262"/></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__('Featured Projects', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($project_count_featured); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>?ext=projects"> <?php echo esc_html__('View Detail', 'exertio_theme' ); ?><i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>
					
				<div class="col-md-6 col-lg-6 col-xl-3">
					<div class="info-boxes">
						<div class="metric">
							<span class="icon">
							<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13 2.03v2.02c4.39.54 7.5 4.53 6.96 8.92c-.46 3.64-3.32 6.53-6.96 6.96v2c5.5-.55 9.5-5.43 8.95-10.93c-.45-4.75-4.22-8.5-8.95-8.97m-2 .03c-1.95.19-3.81.94-5.33 2.2L7.1 5.74c1.12-.9 2.47-1.48 3.9-1.68v-2M4.26 5.67A9.885 9.885 0 0 0 2.05 11h2c.19-1.42.75-2.77 1.64-3.9L4.26 5.67M2.06 13c.2 1.96.97 3.81 2.21 5.33l1.42-1.43A8.002 8.002 0 0 1 4.06 13h-2m5.04 5.37l-1.43 1.37A9.994 9.994 0 0 0 11 22v-2a8.002 8.002 0 0 1-3.9-1.63M12.5 7v5.25l4.5 2.67l-.75 1.23L11 13V7h1.5z" fill="#626262"/></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__('Ongoing Projects', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($project_count_ongoing); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>?ext=ongoing-project"><?php echo esc_html__('View Detail', 'exertio_theme' ); ?> <i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 col-xl-3">
					<div class="info-boxes">
						<div class="metric">
							<span class="icon">
								<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15"><g fill="none"><path d="M4 7.5L7 10l4-5m-3.5 9.5a7 7 0 1 1 0-14a7 7 0 0 1 0 14z" stroke="#626262"/></g></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__('Completed Projects', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($project_count_completed); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>?completed-projects"><?php echo esc_html__('View Detail', 'exertio_theme' ); ?> <i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	  </div>
	<div class="row">
		<div class="col-xl-8 col-lg-12 col-md-12 stretch-card">
		  <div class="card grid-margin">
			<div class="card-body">
			  <h4 class="card-title"><?php echo esc_html__('Profile Views', 'exertio_theme' ); ?></h4>
			  <div class="chart-box"><canvas id="bar-chart" height="175"></canvas></div>         
			</div>
		  </div>
			<div class="card grid-margin all-proposals">
				<div class="card-body">
				  <h4 class="card-title"> <?php echo esc_html__('Recent Proposals', 'exertio_theme' ); ?></h4>
				  <div class="pro-section">
					  <div class="pro-box heading-row">
						<div class="pro-coulmn pro-title"><?php echo esc_html__( 'Proposal detail', 'exertio_theme' ); ?></div>
						<div class="pro-coulmn"><?php echo esc_html__( 'Cost', 'exertio_theme' ); ?> </div>
					</div>
						<?php
					  
							global $wpdb;
							$table = EXERTIO_PROJECT_BIDS_TBL;
							$query = "SELECT * FROM ".$table." WHERE `author_id` = '".$author_id."' ORDER BY updated_on DESC LIMIT 15";
							$result = $wpdb->get_results($query);
							if ( $result != null )
							{
								$proposals_html = '';
								foreach($result as $results)
								{
									$project_cost = '';
									$freelancer_id = $results->freelancer_id;
									$project_id = $results->project_id;
									$freelancer_name = exertio_get_username('freelancer',$freelancer_id );
									$freelancer_img = get_profile_img($freelancer_id, 'freelancer');
									$project_name = get_the_title($project_id);
									$days_to_complete = $results->day_to_complete;
									$posted_date = $results->updated_on;

											$type = get_post_meta($project_id, '_project_type', true);
											if($type == 'fixed' || $type == 1)
											{
												$project_cost = esc_html(fl_price_separator($results->proposed_cost));
											}
											else if($type == 'hourly' || $type == 2)
											{
												$project_cost .=  esc_html(fl_price_separator($results->proposed_cost));
												$project_cost .=  '<span class="protip" data-pt-title="'.esc_attr__('In ','exertio_theme').$days_to_complete.__(' hours total will be  ','exertio_theme'). fl_price_separator($days_to_complete*$results->proposed_cost).'" data-pt-position="top" data-pt-scheme="black"><i class="far fa-question-circle"></i></span>';
											}

									$proposals_html .= '<div class="pro-box">
										<div class="pro-coulmn pro-title">
											<span class="img"><a href="'.esc_url(get_permalink($freelancer_id)).'">'.$freelancer_img.'</a></span> <span class="name"><a href="'.esc_url(get_permalink($freelancer_id)).'">'.$freelancer_name.'</a></span>'.esc_html__( ' sent a proposal on ', 'exertio_theme' ).'<span class="project_name"><a href="'.esc_url(get_permalink($project_id)).'">'.$project_name.'</a></span>
											<p>'.esc_html(date_i18n( get_option( "date_format" ), strtotime( $posted_date ))).'</p>
										</div>';
									$proposals_html .= '<div class="pro-coulmn">'.$project_cost.'</div></div>';
								}
								echo wp_return_echo($proposals_html);
							}
							else
							{
								?>
								<div class="nothing-found">
									<img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
									<h3><?php echo esc_html__( 'Sorry!!! No Proposals Found', 'exertio_theme' ) ?></h3>
								</div>
								<?php	
							}
						?>
				  </div>        
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-lg-12 col-md-12 stretch-card">
			<div class="card grid-margin most-viewed-widget">
				<div class="card-body">
					<h4 class="card-title"><?php echo esc_html__('Most Viewed Projects', 'exertio_theme' ); ?></h4>
					<div class="listing-widgets">
						<ul>
							<?php
							
								$user_img = get_profile_img($current_user_id, 'employer');
								$most_viewed = exertio_fetch_most_viewed_listings($current_user_id, 'projects', 'project', true, false);

								$most_listings = new WP_Query( $most_viewed );
								if ( $most_listings->have_posts() )
								{
									while ( $most_listings->have_posts() )
									{
										$most_listings->the_post();
										$post_id	=	get_the_ID();

										$title =  get_the_title();
										$posted_date =  date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );
										$views = get_post_meta($post_id, 'exertio_project_singletotal_views', true);
										
										$type = get_post_meta($post_id, '_project_type', true);
										$prject_price = get_post_meta($post_id, '_project_cost', true);
										$project_cost = '';
											if($type == 'fixed' || $type == 1)
											{
												$project_cost = esc_html(fl_price_separator($prject_price));
											}
											else if($type == 'hourly' || $type == 2)
											{
												$project_cost .=  esc_html(fl_price_separator($prject_price));
												$estimated_hours = get_post_meta($post_id, '_estimated_hours', true);
												$hourly_total_price = '';
												if ($estimated_hours && $prject_price)
												{
													$hourly_total_price = $estimated_hours*$prject_price;
												}
												$project_cost .=  '<span class="protip" data-pt-title="'.esc_attr__('For ','exertio_theme').$estimated_hours.__(' hours total will be  ','exertio_theme'). fl_price_separator($hourly_total_price).'" data-pt-position="top" data-pt-scheme="black"><i class="far fa-question-circle"></i></span>';
											}
									?>
											<li>
												<div class="media flex-column flex-sm-row mt-0  justify-content-center">
<!--													<div class="card-img-actions">-->
<!--														<a href="--><?php //echo get_the_permalink($post_id); ?><!--">-->
<!--															--><?php //echo wp_return_echo($user_img ); ?>
<!--														</a>-->
<!--													</div>-->
													<div class="media-body">
														<h5 class="media-title">
															<a class="clr-black" href="<?php echo get_the_permalink($post_id); ?>"><?php echo esc_html($title); ?></a>
														</h5>
														<ul class="list-inline text-muted">
															<li class="list-inline-item"> <i class="far fa-clock" aria-hidden="true"></i> <?php echo esc_html($posted_date); ?> </li>
															<li class="list-inline-item"><i class="far fa-eye" aria-hidden="true"></i> <?php echo esc_html($views); ?></li>
														</ul>
														<span class="main-price"> <?php echo wp_return_echo($project_cost); ?></span>
													</div>
												</div>
											</li>
									<?php
									}
								}
								else
								{
									//echo exertio_no_result_found('',__( 'No, States available', 'exertio_theme' ));
									echo '<p>'.esc_html__(' No,stats available', 'exertio_theme' ).'</p>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="card grid-margin tips package-info current-package-widget">
				<div class="card-body">
				  <h4 class="card-title"><?php echo esc_html__('Current Plan Detail', 'exertio_theme' ); ?></h4>
					<p class="view-more-btn"> <a href="<?php echo get_the_permalink(fl_framework_get_options('emp_package_page')); ?>?ext=buy-package" target="_blank"> <?php echo esc_html__(' View Plans ', 'exertio_theme' ); ?></a></p>
					<?php
						$employer_id = get_user_meta( $current_user_id, 'employer_id' , true );

						$simple_project = get_post_meta( $employer_id, '_simple_projects', true);
						$simple_project_text = isset( $simple_project) && $simple_project == -1 ? esc_html__(' Unlimited ', 'exertio_theme' ) : $simple_project;
					
						$simple_project_expiry = get_post_meta( $employer_id, '_simple_project_expiry', true);
						$simple_project_expiry_text = isset( $simple_project_expiry) && $simple_project_expiry == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : $simple_project_expiry.esc_html__(' Days ', 'exertio_theme' );
					
						$featured_projects = get_post_meta( $employer_id, '_featured_projects', true);
						$featured_projects_text = isset( $featured_projects) && $featured_projects == -1 ? esc_html__(' Unlimited ', 'exertio_theme' ) : $featured_projects;

						$featured_project_expiry = get_post_meta( $employer_id, '_featured_project_expiry', true);
						$featured_project_expiry_text = isset( $featured_project_expiry) && $featured_project_expiry == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : $featured_project_expiry.esc_html__(' Days ', 'exertio_theme' );

						$employer_package_expiry = get_post_meta( $employer_id, '_employer_package_expiry', true);
					
						$employer_package_expiry_date = get_post_meta( $employer_id, '_employer_package_expiry_date', true);
					
						$package_expiry_text = isset( $employer_package_expiry_date) && $employer_package_expiry_date == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : date_i18n( get_option( 'date_format' ), strtotime($employer_package_expiry_date));
					
						$employer_is_featured = get_post_meta( $employer_id, '_employer_is_featured', true);
						$employer_featured_text = isset( $employer_is_featured) && $employer_is_featured > 0 ? esc_html__('Yes', 'exertio_theme' ) : esc_html__('No', 'exertio_theme' );
					if(isset($simple_project) && $simple_project != '')
					{
						$img_id = '';
						?>
						<ul>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Project Allowed: ', 'exertio_theme' ).'</span>'.esc_html($simple_project_text)?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Project Expiry: ', 'exertio_theme' ).'</span>'.esc_html($simple_project_expiry_text) ?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Featured Projects: ', 'exertio_theme' ).'</span>'.esc_html($featured_projects_text);?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Featured Projects Expiry: ', 'exertio_theme' ).'</span>'.esc_html($featured_project_expiry_text); ?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Featured Profile: ', 'exertio_theme' ).'</span>'.esc_html($employer_featured_text); ?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Package Expiry: ', 'exertio_theme' ).'</span>'.esc_html($package_expiry_text) ?> </li>
						</ul>
						<?php
					}
					else
					{
						echo '<p>'.esc_html__(' No package detail available', 'exertio_theme' ).'</p>';
					}
					?>
			  </div>
			</div>
		</div>
	</div>
</div>