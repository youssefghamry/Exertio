<?php
$alt_id = '';
$current_user_id = get_current_user_id();

$freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );

$ongoing_services = exertio_get_services_count($freelancer_id,'ongoing');
$completed_services = exertio_get_services_count($freelancer_id,'completed');
$rating = get_rating($freelancer_id, 'only_count');

$service_meta_query = "array(
								'key' => '_service_status',
								'value' => 'active',
								'compare' => '=',
								),
							),";
$active_services = exertio_get_posts_count($current_user_id, 'services', '', '', $service_meta_query);


?>
<div class="content-wrapper">
	<div class="row">
	<div class="col-md-12 grid-margin">
	  <div class="d-flex justify-content-between flex-wrap align-items-center">
		<div class="d-flex flex-wrap flex-column">
		  <div class="mr-md-3 mr-xl-5">
			<h2><?php echo esc_html__('Welcome back Freelancer', 'exertio_theme' ); ?></h2>
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
								<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 0 0-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 0 0-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 0 0 1.066-2.573c-.94-1.543.826-3.31 2.37-2.37c.996.608 2.296.07 2.572-1.065z" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15 12a3 3 0 1 1-6 0a3 3 0 0 1 6 0z" stroke="#626262" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__('Services Offered', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($active_services); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>?ext=all-services"><?php echo esc_html__('View Detail', 'exertio_theme' ); ?> <i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 col-xl-3">
					<div class="info-boxes">
						<div class="metric">
							<span class="icon">
								<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15"><g fill="none"><path d="M4 7.5L7 10l4-5m-3.5 9.5a7 7 0 1 1 0-14a7 7 0 0 1 0 14z" stroke="#626262"/></g></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__(' Completed Services', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($completed_services); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>?ext=completed-services"> <?php echo esc_html__('View Detail', 'exertio_theme' ); ?><i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 col-xl-3">
					<div class="info-boxes">
						<div class="metric">
							<span class="icon">
								<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13 2.03v2.02c4.39.54 7.5 4.53 6.96 8.92c-.46 3.64-3.32 6.53-6.96 6.96v2c5.5-.55 9.5-5.43 8.95-10.93c-.45-4.75-4.22-8.5-8.95-8.97m-2 .03c-1.95.19-3.81.94-5.33 2.2L7.1 5.74c1.12-.9 2.47-1.48 3.9-1.68v-2M4.26 5.67A9.885 9.885 0 0 0 2.05 11h2c.19-1.42.75-2.77 1.64-3.9L4.26 5.67M2.06 13c.2 1.96.97 3.81 2.21 5.33l1.42-1.43A8.002 8.002 0 0 1 4.06 13h-2m5.04 5.37l-1.43 1.37A9.994 9.994 0 0 0 11 22v-2a8.002 8.002 0 0 1-3.9-1.63M12.5 7v5.25l4.5 2.67l-.75 1.23L11 13V7h1.5z" fill="#626262"/></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__('in Queue Services', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($ongoing_services); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>?ext=ongoing-services"><?php echo esc_html__('View Detail', 'exertio_theme' ); ?> <i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>
				<div class="col-md-6 col-lg-6 col-xl-3">
					<div class="info-boxes">
						<div class="metric">
							<span class="icon">
								<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M908.1 353.1l-253.9-36.9L540.7 86.1c-3.1-6.3-8.2-11.4-14.5-14.5c-15.8-7.8-35-1.3-42.9 14.5L369.8 316.2l-253.9 36.9c-7 1-13.4 4.3-18.3 9.3a32.05 32.05 0 0 0 .6 45.3l183.7 179.1l-43.4 252.9a31.95 31.95 0 0 0 46.4 33.7L512 754l227.1 119.4c6.2 3.3 13.4 4.4 20.3 3.2c17.4-3 29.1-19.5 26.1-36.9l-43.4-252.9l183.7-179.1c5-4.9 8.3-11.3 9.3-18.3c2.7-17.5-9.5-33.7-27-36.3zM664.8 561.6l36.1 210.3L512 672.7L323.1 772l36.1-210.3l-152.8-149L417.6 382L512 190.7L606.4 382l211.2 30.7l-152.8 148.9z" fill="#626262"/></svg>
							</span>
							<p>
								<span class="title"><?php echo esc_html__('Reviews', 'exertio_theme' ); ?></span>
								<span class="number"><?php echo esc_html($rating); ?></span>
							</p>
						</div>
						<p class="matric-bottom"> <a href="<?php echo esc_url(get_the_permalink());?>"><?php echo esc_html__('View Detail', 'exertio_theme' ); ?> <i class="fas fa-arrow-right"></i></a></p>
					</div>
				</div>
			</div>
		</div>
	  </div>
	<div class="row">
		<div class="col-xl-8 col-lg-12 col-md-12 stretch-card">
		  <div class="card  grid-margin">
			<div class="card-body">
			  <h4 class="card-title"><?php echo esc_html__('Profile Views', 'exertio_theme' ); ?></h4>
			  <div class="chart-box"><canvas id="bar-chart" height="175"></canvas></div>
			</div>
		  </div>
			<div class="card grid-margin all-proposals">
				<div class="card-body">
				  <h4 class="card-title"> <?php echo esc_html__('Recent Purchased Services', 'exertio_theme' ); ?></h4>
				  <div class="pro-section">
					  <div class="pro-box heading-row">
						<div class="pro-coulmn pro-title"><?php echo esc_html__( 'Service detail', 'exertio_theme' ); ?></div>
						<div class="pro-coulmn"><?php echo esc_html__( 'Cost', 'exertio_theme' ); ?> </div>
					</div>
						<?php
							global $wpdb;
							$table = EXERTIO_PURCHASED_SERVICES_TBL;
							if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
							{
								$query = "SELECT * FROM ".$table." WHERE `seller_id` = '" . $freelancer_id . "' ORDER BY timestamp DESC LIMIT 15";
								$result = $wpdb->get_results($query);
							}
							if ( $result != null )
							{
								$proposals_html = '';
								foreach($result as $results)
								{									
									$service_cost = '';
									$buyer_id = $results->buyer_id;
									$service_id = $results->service_id;

									
									$employer_name = exertio_get_username('employer',$buyer_id );
									$employer_img = get_profile_img($buyer_id, 'employer');
									$service_name = get_the_title($service_id);
									$service_cost = $results->total_price;
									$posted_date = $results->updated_on;


									$proposals_html .= '<div class="pro-box">
										<div class="pro-coulmn pro-title">
											<span class="img"><a href="'.esc_url(get_permalink($buyer_id)).'">'.$employer_img.'</a></span> <span class="name"><a href="'.esc_url(get_permalink($buyer_id)).'">'.$employer_name.'</a></span>'.esc_html__( 'has purchased ', 'exertio_theme' ).'<span class="project_name"><a href="'.esc_url(get_permalink($service_id)).'">'.$service_name.'</a></span>
											<p>'.esc_html(date_i18n( get_option( "date_format" ), strtotime( $posted_date ))).'</p>
										</div>';
									$proposals_html .= '<div class="pro-coulmn">'.fl_price_separator($service_cost).'</div></div>';
								}
								echo wp_return_echo($proposals_html);
							}
							else
							{
								?>
								<div class="nothing-found">
									
									<img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
									<h3><?php echo esc_html__( 'Sorry!!! No Recent Purchases', 'exertio_theme' ) ?></h3>
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
					<h4 class="card-title"><?php echo esc_html__('Most Viewed Services', 'exertio_theme' ); ?></h4>
					<div class="listing-widgets">
						<ul>
							<?php
								$most_viewed = exertio_fetch_most_viewed_listings($current_user_id, 'services', 'service', true, false);
								$most_listings = new WP_Query( $most_viewed );
								if ( $most_listings->have_posts() )
								{
									while ( $most_listings->have_posts() )
									{
										$most_listings->the_post();
										$post_id	=	get_the_ID();
                                        $services_img_id = get_post_meta( $post_id, '_service_attachment_ids', true );
                                        $user_img = wp_get_attachment_image($services_img_id,'thumbnail','',array( "class" => "img-fluid" ));
										$title =  get_the_title();
										$posted_date =  date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) );
										$views = get_post_meta($post_id, 'exertio_service_singletotal_views', true);
										
										//$type = get_post_meta($post_id, '_project_type', true);
										$prject_price = fl_price_separator(get_post_meta($post_id, '_service_price', true));
										
										$icon = '';
										
									?>
											<li>
												<div class="media flex-column flex-sm-row mt-0  justify-content-center">
													<div class="card-img-actions">
                                                        <a href="<?php echo get_the_permalink($post_id); ?>">
                                                            <?php echo wp_return_echo($user_img ); ?>
                                                        </a>
													</div>
													<div class="media-body">
														<h5 class="media-title">
															<a class="clr-black" href="<?php echo get_the_permalink($post_id); ?>"><?php echo esc_html($title); ?></a>
														</h5>
														<ul class="list-inline text-muted">
															<li class="list-inline-item"> <i class="far fa-clock" aria-hidden="true"></i> <?php echo esc_html($posted_date); ?> </li>
															<li class="list-inline-item"><i class="far fa-eye" aria-hidden="true"></i> <?php echo esc_html($views); ?></li>
														</ul>
														<span class="main-price"> <?php echo wp_return_echo($prject_price); ?></span>
													</div>
												</div>
											</li>
									<?php
									}
								}
								else
								{
									//echo exertio_no_result_found('',__( 'No, States available', 'exertio_theme' ));
									echo '<p>'.esc_html__(' No, Stats available', 'exertio_theme' ).'</p>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="card grid-margin  current-package-widget">
				<div class="card-body">
				  <h4 class="card-title"><?php echo esc_html__('Current Plan Detail', 'exertio_theme' ); ?></h4>
					<p class="view-more-btn"> <a href="<?php echo esc_url(get_the_permalink(fl_framework_get_options('freelancer_package_page'))); ?>" target="_blank"> <?php echo esc_html__(' View Plans ', 'exertio_theme' ); ?></a></p>
					<?php
					
						$project_credits = get_post_meta( $freelancer_id, '_project_credits', true );
						$project_credits_text = isset( $project_credits) && $project_credits == -1 ? esc_html__(' Unlimited ', 'exertio_theme' ) : $project_credits;
					
						$simple_services = get_post_meta( $freelancer_id, '_simple_services', true );
						$simple_services_text = isset( $simple_services) && $simple_services == -1 ? esc_html__(' Unlimited ', 'exertio_theme' ) : $simple_services;
					
						$simple_services_expiry = get_post_meta( $freelancer_id, '_simple_service_expiry', true );
						$simple_services_expiry_text = isset( $simple_services_expiry) && $simple_services_expiry == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : $simple_services_expiry.esc_html__(' Days ', 'exertio_theme' );

						$featured_services = get_post_meta( $freelancer_id, '_featured_services', true );
						$featured_services_text = isset( $featured_services) && $featured_services == -1 ? esc_html__(' Unlimited ', 'exertio_theme' ) : $featured_services;

						$featured_services_expiry = get_post_meta( $freelancer_id, '_featured_services_expiry', true );
						$featured_services_expiry_text = isset( $featured_services_expiry) && $featured_services_expiry == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : $featured_services_expiry.esc_html__(' Days ', 'exertio_theme' );
						
						$freelancer_package_expiry_date = get_post_meta($freelancer_id, '_freelancer_package_expiry_date', true);
						//$package_expiry = date_i18n( get_option( 'date_format' ), strtotime( $freelancer_package_expiry_date  ));
						$package_expiry_text = isset( $freelancer_package_expiry_date) && $freelancer_package_expiry_date == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : date_i18n( get_option( 'date_format' ), strtotime( $freelancer_package_expiry_date  ));

						$freelancer_is_featured = get_post_meta( $freelancer_id, '_freelancer_is_featured', true );
						$freelacner_featured_text = isset( $freelancer_is_featured) && $freelancer_is_featured > 0 ? esc_html__('Yes', 'exertio_theme' ) : esc_html__('No', 'exertio_theme' );
					if(isset($simple_services) && $simple_services != '' && $freelancer_package_expiry_date != '')
					{
						$today_date = date("d-m-Y");
						if(strtotime($freelancer_package_expiry_date) >= strtotime($today_date) )
						{
						?>
							<ul>
								<li><i class="far fa-check-square"></i> <?php echo '<span>'.esc_html__('Project Credits: ', 'exertio_theme' ).'</span>'.esc_html($project_credits_text); ?> </li>
								<li><i class="far fa-check-square"></i> <?php echo '<span>'.esc_html__('Services Allowed: ', 'exertio_theme' ).'</span>'.esc_html($simple_services_text); ?> </li>
								<li><i class="far fa-check-square"></i> <?php echo '<span>'.esc_html__('Service Expiry: ', 'exertio_theme' ).'</span>'.esc_html($simple_services_expiry_text); ?> </li>
								<li><i class="far fa-check-square"></i> <?php echo '<span>'.esc_html__('Featured Services: ', 'exertio_theme' ).'</span>'.esc_html($featured_services_text); ?> </li>
								<li><i class="far fa-check-square"></i> <?php echo '<span>'.esc_html__('Featured Services Expiry: ', 'exertio_theme' ).'</span>'.esc_html($featured_services_expiry_text); ?> </li>
								<li><i class="far fa-check-square"></i> <?php echo '<span>'.esc_html__('Featured Profile: ', 'exertio_theme' ).'</span>'.esc_html($freelacner_featured_text); ?> </li>
								<li><i class="far fa-check-square"></i> <?php echo '<span>'.esc_html__('Package Expiry: ', 'exertio_theme' ).'</span>'.esc_html($package_expiry_text ); ?> </li>
							</ul>
						<?php
						}
						else
						{
							echo '<p>'.esc_html__(' Your current package has expired', 'exertio_theme' ).'</p>';
						}
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