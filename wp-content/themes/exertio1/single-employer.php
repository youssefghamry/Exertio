<?php
if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	$actionbBar = fl_framework_get_options('action_bar');
	$actionbar_space = '';
	if(isset($actionbBar) && $actionbBar == 1)
	{
		$actionbar_space = 'actionbar_space';
	}
	get_template_part('header');
	global $exertio_theme_options;
	global $post;
	$emp_id = get_the_ID();

	$post_author = $post->post_author;
	$user_info = get_userdata($post_author);

	$img_alt_id ='';

	$banner_img_id = get_post_meta( $emp_id, '_employer_banner_id', true );
	$banner_img = wp_get_attachment_image_src( $banner_img_id, 'full' );
	$cover_img ='';
	if(empty($banner_img ))
	{
		$cover_img = "style='background-image:url(".$exertio_theme_options['employer_df_cover']['url'].")'";
	}
	else
	{
		$cover_img = "style='background-image:url(".$banner_img[0].")'";
	}

	$limit = $exertio_theme_options['employers_posted_project_limit'];
	$emp_location_html = $emp_location = '';
	$emp_location = get_term_names('employer-locations', '_employer_location', $emp_id, '', ',' );
	if(isset($emp_location) && $emp_location != '')
	{
		$emp_location_html = '<p><i class="fas fa-map-marker-alt"></i>'.$emp_location.'</p>';
	}
	?>
	<section class="fr-hero-theme" <?php echo wp_return_echo($cover_img); ?> > </section>
	<section class="fr-expert">
	  <div class="container">
		<div class="row">
		  <div class="col-xl-4 col-xs-12 col-sm-12 col-md-12"> </div>
		  <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">
			<div class="row">
			  <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7">
				<div class="fr-expert-details">
				  <h1><?php echo esc_html(get_post_meta( $emp_id, '_employer_tagline' , true )); ?></h1>
				  <?php echo wp_return_echo($emp_location_html); ?>
				</div>
			  </div>
			  <div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 align-self-center">
				<div class="fr-expert-content">
					<?php

						if( get_user_meta( get_current_user_id(), '_emp_follow_id_'.$emp_id, true ) == $emp_id )
						{
							?>
							<a href="javascript:void(0)" class="btn btn-theme following"><?php echo esc_html__('Following','exertio_theme'); ?></a>
							<?php
						}
						else
						{
							?>
							<a href="javascript:void(0)" class="btn btn-theme-secondary follow-employer" data-emp-id="<?php echo esc_attr($emp_id); ?>"><?php echo esc_html__('Click to Follow','exertio_theme'); ?></a>
							<?php

						}
					?>
					</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	</section>
	<section class="fr-c-information padding-bottom-80 <?php echo esc_attr($actionbar_space); ?>">
	  <div class="container">
		<div class="row">
		  <div class="col-lg-4 col-xl-4 col-md-12 col-xs-12 col-sm-12">
			<div class="fr-c-details">
			  <div class="fr-c-detail-box">
				<div class="fl-profile-img">
					<?php echo get_profile_img($emp_id, 'employer'); ?>
				</div> 
				<p><?php echo exertio_get_username('employer', $emp_id, 'badge'); ?></p>
			  </div>
			  <div class="fr-c-followers">
				<ul>
				  <li>
					<div class="fr-c-more-details">
						<span>
							<?php  echo exertio_get_posts_count($post_author, 'projects', $limit, array('publish', 'ongoing'), ''); ?>
						</span>
					  <p> <?php echo esc_html__('Projects','exertio_theme'); ?></p>
					</div>
				  </li>
				  <li class="fr-style-3">
					<div class="fr-c-more-details"> <span><?php echo get_employer_followers($emp_id); ?></span>
					  <p><?php echo esc_html__('Followers','exertio_theme'); ?></p>
					</div>
				  </li>
				</ul>
			  </div>
			  <div class="fr-ca-more-details">
				<ul>
				<?php
					if($exertio_theme_options['contact_detail_show'] && $exertio_theme_options['contact_detail_show'] == 1)
					{
						?>
						<li>
						<div class="fr-c-full-details"> <span><?php echo esc_html__('Contact Number','exertio_theme'); ?></span>
						  <p><?php echo esc_html(get_post_meta( $emp_id, '_employer_contact_number' , true )); ?></p>
						</div>
						</li>
						<li>
						<div class="fr-c-full-details"> <span><?php echo esc_html__('Email Address','exertio_theme'); ?></span>
						  <p><?php echo esc_html($user_info->user_email); ?></p>
						</div>
						</li>
						<?php
					}
					else if($exertio_theme_options['contact_detail_show'] && $exertio_theme_options['contact_detail_show'] == 3)
					{
						if(!is_user_logged_in())
						{
							?>
							<li>
							<div class="fr-c-full-details"> <span><?php echo esc_html__('Contact Number','exertio_theme'); ?></span>
							  <p><?php echo esc_html__('Login to view....','exertio_theme'); ?></p>
							</div>
							</li>
							<li>
							<div class="fr-c-full-details"> <span><?php echo esc_html__('Email Address','exertio_theme'); ?></span>
							  <p><?php echo esc_html__('Login to view...','exertio_theme'); ?></p>
							</div>
							</li>
							<?php
						}
						else
						{
							?>
							<li>
							<div class="fr-c-full-details"> <span><?php echo esc_html__('Contact Number','exertio_theme'); ?></span>
							  <p><?php echo esc_html(get_post_meta( $emp_id, '_employer_contact_number' , true )); ?></p>
							</div>
							</li>
							<li>
							<div class="fr-c-full-details"> <span><?php echo esc_html__('Email Address','exertio_theme'); ?></span>
							  <p><?php echo esc_html($user_info->user_email); ?></p>
							</div>
							</li>
							<?php
						}
					}

				?>
				  <li>
					<div class="fr-c-full-details"> <span><?php echo esc_html__('Department','exertio_theme'); ?></span>
					  <p>
						<?php
							//$employer_departments = get_post_meta($emp_id, '_employer_department', true);
							$employer_departments = get_term_names('departments', '_employer_department', $emp_id, '', ',' );
							if($employer_departments != '')
							{
								echo esc_html($employer_departments);
							}
							else
							{
								echo esc_html__('N/A','exertio_theme');
							}
						?>
					  </p>
					</div>
				  </li>
				  <li>
					<div class="fr-c-full-details"> <span><?php echo esc_html__('Number of Employees','exertio_theme'); ?></span>
					  <p>
						<?php

							$employees =  get_term_names('employees-number', '_employer_employees', $emp_id, '', ',' );
							if($employees != '')
							{
								echo esc_html($employees);
							}
							else
							{
								echo esc_html__('N/A','exertio_theme');
							}
						?>
					  </p>
					</div>
				  </li>
				  <li>
					<div class="fr-c-full-details"> <span><?php echo esc_html__('Member Since','exertio_theme'); ?></span>
					  <p><?php echo date_i18n( get_option( 'date_format' ), strtotime( $user_info->user_registered ) ); ?></p>
					</div>
				  </li>
				</ul>
			  </div>
			  <?php
				if($exertio_theme_options['social_links_switch'] == true)
				{
					$facebook = get_post_meta( $emp_id, '_employer_facebook_url' , true );
					$twitter = get_post_meta( $emp_id, '_employer_twitter_url' , true );
					$linkedin = get_post_meta( $emp_id, '_employer_linkedin_url' , true );
					$instagram = get_post_meta( $emp_id, '_employer_instagram_url' , true );
					$dribble = get_post_meta( $emp_id, '_employer_dribble_url' , true );
					$behance = get_post_meta( $emp_id, '_employer_behance_url' , true );

					if($facebook == '' && $twitter == '' && $linkedin == '' && $instagram == '' && $dribble == '' && $behance == '' )
					{}
					else
					{
						?>
						<div class="fr-c-social-icons">
							<ul>
								<?php
									if(isset($facebook) && $facebook != '')
									{
										?>
										  <li> <a href="<?php echo wp_return_echo($facebook); ?>" target="_blank"><img src="<?php echo FL_THEMEPATH; ?>/images/icons/facebook.png" alt="<?php echo get_post_meta( $img_alt_id, '_wp_attachment_image_alt', true ); ?>" class="img-fluid"></a> </li>
										<?php

									}
								?>
								<?php
									if(isset($twitter) && $twitter != '')
									{
										?>
							  <li> <a href="<?php echo wp_return_echo($twitter); ?>" target="_blank"><img src="<?php echo FL_THEMEPATH; ?>/images/icons/twitter.png" alt="<?php echo get_post_meta( $img_alt_id, '_wp_attachment_image_alt', true ); ?>" class="img-fluid"></a> </li>
										<?php

									}
								?>
								<?php
									if(isset($linkedin) && $linkedin != '')
									{
										?>
							  <li> <a href="<?php echo wp_return_echo($linkedin); ?>" target="_blank"><img src="<?php echo FL_THEMEPATH; ?>/images/icons/linkedin.png" alt="<?php echo get_post_meta( $img_alt_id, '_wp_attachment_image_alt', true ); ?>" class="img-fluid"></a> </li>
										<?php

									}
								?>
								<?php
									if(isset($instagram) && $instagram != '')
									{
										?>
							  <li> <a href="<?php echo wp_return_echo($instagram); ?>" target="_blank"><img src="<?php echo FL_THEMEPATH; ?>/images/icons/instagram.png" alt="<?php echo get_post_meta( $img_alt_id, '_wp_attachment_image_alt', true ); ?>" class="img-fluid"></a> </li>
										<?php

									}
								?>
								<?php
									if(isset($dribble) && $dribble != '')
									{
										?>
							  <li> <a href="<?php echo wp_return_echo($dribble); ?>" target="_blank"><img src="<?php echo FL_THEMEPATH; ?>/images/icons/dribble.png" alt="<?php echo get_post_meta( $img_alt_id, '_wp_attachment_image_alt', true ); ?>" class="img-fluid"></a> </li>
										<?php

									}
								?>
								<?php
									if(isset($behance) && $behance != '')
									{
										?>
							  <li> <a href="<?php echo wp_return_echo($behance); ?>" target="_blank"><img src="<?php echo FL_THEMEPATH; ?>/images/icons/behance.png" alt="<?php echo get_post_meta( $img_alt_id, '_wp_attachment_image_alt', true ); ?>" class="img-fluid"></a> </li>
										<?php

									}
								?>
							</ul>
						  </div>
						<?php
					}
				}
			  ?>
			</div>
			 <p class="report-button text-center"> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#report-modal"><i class="fas fa-exclamation-triangle"></i><?php echo esc_html__('Report Employer','exertio_theme'); ?></a></p>
			<div class="fr-lance-banner">
			 <?php
				if(isset($exertio_theme_options['employer_ad_1']))
				{
					echo wp_return_echo($exertio_theme_options['employer_ad_1']);
				}
			 ?>
			 </div>
		  </div>
		  <div class="col-lg-8 col-xl-8 col-md-12 col-xs-12 col-sm-12">
			<div class="fr-product-des-box heading-contents custom-class">
			  <h3><?php echo esc_html__('About Us','exertio_theme'); ?></h3>
			  <?php echo wp_kses($post->post_content, exertio_allowed_html_tags()); ?>
			</div>
			<?php
			if(class_exists('ACF'))
			{
				get_template_part( 'template-parts/detail-page/custom-field', '');	
			}
			?>
			<?php
				$the_query = exertio_get_all_projects($post_author,  array('publish', 'ongoing'), $limit);
				$total_posts = $the_query->found_posts;
				if($the_query->have_posts())
				{
					?>
					<div class="posted-projects"> 
					<?php

					while ( $the_query->have_posts() ) 
					{
						$the_query->the_post();
						$pid = get_the_ID();
						$project_type = get_post_meta($pid, '_project_type', true);
						?>
							<div class="fr-right-detail-box">
							  <div class="fr-right-detail-content">
								<div class="fr-right-details-products">
									<?php
									$featured_projects = get_post_meta($pid, '_project_is_featured', true);

									if(isset($featured_projects) && $featured_projects == 1)
									{
										?>
										<div class="features-star"><i class="fa fa-star"></i></div>
										<?php
									}
									?>
								  <div class="fr-jobs-price">
									 <div class="style-hd">
										<?php 
											if($project_type == 'fixed' || $project_type == 1)
											{ 
												echo fl_price_separator(get_post_meta($pid, '_project_cost', true));
											}
											else if($project_type == 'hourly' || $project_type == 2)
											{
												echo fl_price_separator(get_post_meta($pid, '_project_cost', true));
											}
										?>
									   </div>
									  <?php
										$project_type_text = '';
										if($project_type == 'hourly' || $project_type == 2)
										{
											$project_type_text = esc_html__('Hourly ','exertio_theme');
											$price = get_post_meta($pid, '_project_cost', true);
											$hours = get_post_meta($pid, '_estimated_hours', true);

											echo '<p class="price_type protip" data-pt-title="'.esc_attr__('For ','exertio_theme').$hours.__(' hours total will be  ','exertio_theme'). fl_price_separator(is_numeric($hours)*is_numeric($price)).'" data-pt-position="top" data-pt-scheme="black">'.$project_type_text.' <i class="far fa-question-circle"></i></p>';
										}
										else if($project_type == 'fixed' || $project_type == 1)
										{
											$project_type_text = esc_html__('Fixed ','exertio_theme');
											echo '<p class="price_type ">'.$project_type_text.'</p>';
										}
									?>
								  </div>
								  <div class="fr-right-details2">
									<a href="<?php echo esc_url(get_permalink()); ?>">
										<h3><?php echo esc_html(get_the_title()); ?></h3>
									</a>
								  </div>
								  <div class="fr-right-product">
									<ul class="skills">
										<?php
											$saved_skills = wp_get_post_terms($pid, 'skills', array( 'fields' => 'all' ));
											$skill_count = 1;
											$skill_hide = '';
											if(isset($saved_skills) && $saved_skills != '')
											{
												foreach($saved_skills as $saved_skill)
												{
													if($skill_count > 4)
													{ 
														$skill_hide = 'hide';
													}
													?>
													<li class="<?php echo esc_html($skill_hide); ?>"><a href="<?php echo esc_url(get_term_link($saved_skill->term_id)); ?>"><?php echo esc_html($saved_skill->name); ?></a></li>
													<?php
												  $skill_count++;
												}

												if($skill_hide != '')
												{
													?>
													<li class="show-skills"><a href="javascript:void(0)"><i class="fas fa-ellipsis-h"></i></a></li>
													<?php
												}
											}
										?>
									</ul>
								  </div>
								  <div class="fr-right-index">
									<p><?php echo exertio_get_excerpt(25, $pid); ?></p>
								  </div>
								</div>
							  </div>
							  <div class="fr-right-information">
								<div class="fr-right-list">
								  <ul>
									<li>
									  <p class="heading"><?php echo esc_html__('Duration: ','exertio_theme'); ?></p>
									  <span>
										<?php
											$project_duration = get_term( get_post_meta($pid, '_project_duration', true));
											if(!empty($project_duration) && ! is_wp_error($project_duration))
											{
												echo esc_html($project_duration->name);
											}
										?>  
									  </span>
									</li>
									<li>
									  <p class="heading"><?php echo esc_html__('Level: ','exertio_theme'); ?></p>
									  <span>
										<?php
											$project_level = get_term( get_post_meta($pid, '_project_level', true));
											if(!empty($project_level) && ! is_wp_error($project_level))
											{
												echo esc_html($project_level->name);
											}
										?>  
									  </span>
									</li>
									<li>
									  <p class="heading"><?php echo esc_html__('Location: ','exertio_theme'); ?></p>
									  <span>
											<?php
												$location_remote = get_post_meta($pid, '_project_location_remote', true);
												if(isset($location_remote) && $location_remote == 1)
												{
													echo esc_html__('Remote','exertio_theme');
												}
												else
												{
													echo get_term_names('locations', '_project_location', $pid,'', ',' );
												}
											?>  
									  </span>
									</li>
								  </ul>
								</div>
								<div class="fr-right-bid">
								  <ul>
									<?php
										$saved = '';
										$meta_key = '_pro_fav_id_'.$pid;
										$saved_project = get_user_meta(get_current_user_id(),$meta_key,true);
										if($saved_project)
										{
											$saved = 'saved';
										}
									?>
									<li> <a href="javascript:void(0)" class="mark_fav <?php echo esc_html($saved); ?>" data-post-id= "<?php echo esc_attr($pid);?>"><i class="fa fa-heart active"></i></a> </li>
									<li><a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-theme"><?php echo esc_html__('View Detail','exertio_theme'); ?></a></li>
								  </ul>
								</div>
							  </div>
							</div>
						<?php
					}
					?>
					</div>
			  		<div class="emp-profile-pagination">
					<?php
					wp_reset_postdata();
					$limit = $exertio_theme_options['employers_posted_project_limit'];
					$total_pages = ceil($total_posts/$limit);

					if($total_pages> 1 )
					{
						$pageno = 1;
						$page_end_limit = $pageno + 2; 
						?>
						<div class="fl-navigation">
							<ul>
								<?php
								for($i=1; $i<=$total_pages; $i++)
								{
									$page_limit = $i + 1; 
									$active_pagination ='';
									if($i ===1)
									{
										$active_pagination ='active';	
									}
									?>
									<li class="<?php echo esc_attr($active_pagination); ?> emp_pro_pagination" data-page-number="<?php echo esc_attr($i); ?>" data-post-author ="<?php echo esc_attr($post_author); ?>">
										<a href="javascript:void(0)"><?php echo esc_html($i); ?></a>
									</li>
									<?php
									if($i >= $page_end_limit)
									{
										?>
										<li class="emp_pro_pagination">
											<a href="javascript:void(0)">..</a>
										</li>
									<?php
										break;
									}
								}
								?>
							</ul>
						</div>
						<?php
					}
					?>
					</div>
					<?php
				}
			?>
		  </div>
		</div>
	  </div>
	</section>
	<?php
    if(isset($exertio_theme_options['footer_type'])) { $footer_type  = $exertio_theme_options['footer_type']; } else { $footer_type  = 0; }
    if($footer_type  ==  1) {
        if($footer_type  ==  1 && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            elementor_theme_do_location('footer');
        }else{
            get_footer();
        }
    }else {
        get_template_part('footer');
    }
}
else
{
	wp_redirect(home_url());
}
?>