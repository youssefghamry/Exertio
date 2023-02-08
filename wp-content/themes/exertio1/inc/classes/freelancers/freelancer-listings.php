<?php
if (!class_exists('exertio_get_freelancers_class'))
{
	class exertio_get_freelancers_class 
	{
		/*GRID STYLE 1*/
		function exertio_freelancer_grid_1($freelancer_id, $cols = '') 
		{
			global $exertio_theme_options;
			$author_id = get_post_field( 'post_author', $freelancer_id );
			$featured_badge =  $col_html = '';
			$featured_freelancer = get_post_meta($freelancer_id, '_freelancer_is_featured', true);

			if(isset($featured_freelancer) && $featured_freelancer == 1)
			{
				$featured_badge = '<div class="fr3-product-icons"> <div class="features-star"> <a href="#"><i class="fa fa-star"></i></a> </div> </div>';
			}
			if($cols == '')
			{
				$col_html = 'col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12';
			}
			else
			{
				$col_html = $cols;
			}
			?>
               <div class="<?php echo esc_attr($col_html); ?> grid-item">
				  <div class="fr3-product-detail-box">
					  <div class="fr3-main-product">
						  <div class="fr3-product-img">
							  <a href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo get_profile_img($freelancer_id,'freelancer'); ?></a>
						  </div>
						  <div class="fr3-product-text">
							  <p><a href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo exertio_get_username('freelancer', $freelancer_id, 'badge'); ?></a></p>
							  <h3><a href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo esc_html(get_post_meta( $freelancer_id, '_freelancer_tagline' , true )); ?></a></h3>
						  </div>
						  <p class="inline-style"><?php echo exertio_get_excerpt(12, $freelancer_id); ?></p>
					  </div>
                      <?php
					  $saved_skills =  json_decode(stripslashes(get_post_meta($freelancer_id, '_freelancer_skills', true)), true);
					  if($saved_skills != '')
					  {
						  ?>
                          <div class="fr3-product-skills">
                              <?php
                                    $skill_count = 1;
                                    $skill_hide = '';
								  $freelancer_link = get_the_permalink( fl_framework_get_options( 'freelancer_search_page' ) ) . '?skill';
                                    foreach($saved_skills as $skills)
                                    {
                                        $skillsObject = get_term_by( 'id', $skills['skill'] , 'freelancer-skills' );
										if($skillsObject != '')
										{
											$skillsTermName = $skillsObject->name;
											if($skill_count > 3)
											{ $skill_hide = 'hide'; }
											?>
											<a href="<?php echo esc_url($freelancer_link.'='.$skillsObject->term_id); ?>"  class="<?php echo esc_html($skill_hide); ?>"><?php echo esc_html($skillsTermName); ?></a>
											<?php
										  $skill_count++;
										}
                                    }
                                    if($skill_hide != '')
                                    {
                                        ?>
                                        <a href="javascript:void(0)" class="show-skills"><i class="fas fa-ellipsis-h"></i></a>
                                        <?php
                                    }
                                ?>
                          </div>
                          <?php
					  }
					  ?>
					  <div class="fr3-product-price">
						  <ul>
							  <li>
								  <p><?php echo get_rating($freelancer_id, '', ''); ?></p>
							  </li>
                              <?php
							  	if($exertio_theme_options['fl_hourly_rate'] == 3)
								{
									
								}
								else
								{
									$hourly_rate = get_post_meta($freelancer_id, '_freelancer_hourly_rate', true);
									if($hourly_rate != '')
									{
									  ?>
									  <li>
										  <p><?php echo fl_price_separator($hourly_rate, 'html'); ?></p>
										  <span class="bottom-text"><?php echo esc_html__(' hourly','exertio_theme'); ?></span>
									  </li>
									  <?php
									}
								}
								?>
						  </ul>
					  </div>
					  
					  <div class="fr2-text-center">
					  <p>
						  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512"><path fill="#626262" d="M472 96h-88V40h-32v56H160V40h-32v56H40a24.028 24.028 0 0 0-24 24v336a24.028 24.028 0 0 0 24 24h432a24.028 24.028 0 0 0 24-24V120a24.028 24.028 0 0 0-24-24zm-8 352H48V128h80v40h32v-40h192v40h32v-40h80z"/><path fill="#626262" d="M112 224h32v32h-32z"/><path fill="#626262" d="M200 224h32v32h-32z"/><path fill="#626262" d="M280 224h32v32h-32z"/><path fill="#626262" d="M368 224h32v32h-32z"/><path fill="#626262" d="M112 296h32v32h-32z"/><path fill="#626262" d="M200 296h32v32h-32z"/><path fill="#626262" d="M280 296h32v32h-32z"/><path fill="#626262" d="M368 296h32v32h-32z"/><path fill="#626262" d="M112 368h32v32h-32z"/><path fill="#626262" d="M200 368h32v32h-32z"/><path fill="#626262" d="M280 368h32v32h-32z"/><path fill="#626262" d="M368 368h32v32h-32z"/></svg>
						  <?php echo esc_html__('Member since ','exertio_theme').get_the_date(); ?></p>
					  </div>
					  
					  <div class="fr3-product-btn">
						  <a href="<?php echo get_the_permalink($freelancer_id); ?>" class="btn btn-theme"><?php echo esc_html__('View Profile','exertio_theme'); ?></a>
					  </div>
					  <?php echo wp_return_echo($featured_badge); ?>
                      
				  </div>
			  </div>
            <?php
		}
		
		/*GRID STYLE 2*/
		function exertio_freelancer_grid_2($freelancer_id, $cols = '') 
		{
			global $exertio_theme_options;
			$author_id = get_post_field( 'post_author', $freelancer_id );
			$featured_badge =  $col_html = '';
			$featured_freelancer = get_post_meta($freelancer_id, '_freelancer_is_featured', true);
			if(isset($featured_freelancer) && $featured_freelancer == 1)
			{
				$featured_badge = '<div class="d-flex flex-row agent-type"><span class="badge badge-agent-type">'.esc_html__( 'Featured', 'exertio_theme' ).'</span></div>';
			}
			if($cols == '')
			{
				$col_html = 'col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12';
			}
			else
			{
				$col_html = $cols;
			}
			?>
				<div class="<?php echo esc_attr($col_html); ?> grid-item">
					<div class="card agent-1">
						<div class="card-image">
							<?php echo wp_return_echo($featured_badge); ?>
							<a href="<?php echo get_the_permalink($freelancer_id); ?>">
								<?php echo get_profile_img($freelancer_id,'freelancer','full'); ?>
							</a>
						</div>
						<div class="card-body">
						<span class="username"><a href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo exertio_get_username('freelancer', $freelancer_id, 'badge'); ?></a></span>
						<h2 class="card-title"> <a class="clr-black" href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo esc_html(get_post_meta( $freelancer_id, '_freelancer_tagline' , true )); ?></a> </h2>
						<?php
							if($exertio_theme_options['fl_hourly_rate'] == 3)
							{

							}
							else
							{
								$hourly_rate = get_post_meta($freelancer_id, '_freelancer_hourly_rate', true);
								if($hourly_rate != '')
								{
								  ?>
								  <div class="hourly-rate">
									  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><path class="clr-i-outline clr-i-outline-path-1" d="M32 8H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h28a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2zm0 6a4.25 4.25 0 0 1-3.9-4H32zm0 1.62v4.83A5.87 5.87 0 0 0 26.49 26h-17A5.87 5.87 0 0 0 4 20.44V15.6A5.87 5.87 0 0 0 9.51 10h17A5.87 5.87 0 0 0 32 15.6zM7.9 10A4.25 4.25 0 0 1 4 14v-4zM4 22.06A4.25 4.25 0 0 1 7.9 26H4zM28.1 26a4.25 4.25 0 0 1 3.9-3.94V26z" fill="#626262"/><path class="clr-i-outline clr-i-outline-path-2" d="M18 10.85c-3.47 0-6.3 3.21-6.3 7.15s2.83 7.15 6.3 7.15s6.3-3.21 6.3-7.15s-2.83-7.15-6.3-7.15zm0 12.69c-2.59 0-4.7-2.49-4.7-5.55s2.11-5.55 4.7-5.55s4.7 2.49 4.7 5.55s-2.11 5.56-4.7 5.56z" fill="#626262"/></svg>
									  <p><?php echo fl_price_separator($hourly_rate, 'html'); ?></p>
									  <span class="bottom-text"><?php echo esc_html__(' hourly','exertio_theme'); ?></span>
								  </div>
								  <?php
								}
							}
						?>
						<div class="dropdown-divider"></div>
						<div class="agent-short-detials">
						  <div class="widget-inner-elements">
							<div class="widget-inner-text"> <?php echo get_rating($freelancer_id, '', ''); ?></div>
						  </div>
						  <div class="widget-inner-elements">
							<div class="widget-inner-icon"> <i class="fas fa-map-marker-alt"></i> </div>
							<div class="widget-inner-text"> <?php echo get_term_names('freelancer-locations', '_freelancer_location', $freelancer_id, '', ',' ); ?></div>
						  </div>
						</div>
						</div>
					</div>
				</div>
            <?php
		}
		/*LIST STYLE 1*/
		function exertio_freelancer_list_1($freelancer_id, $col = '') 
		{
			global $exertio_theme_options;
			$author_id = get_post_field( 'post_author', $freelancer_id );
			$featured_badge =  '';
			$featured_freelancer = get_post_meta($freelancer_id, '_freelancer_is_featured', true);
			if(isset($featured_freelancer) && $featured_freelancer == 1)
			{
				$featured_badge = '<div class="fr3-product-icons"> <div class="features-star"> <i class="fa fa-star"></i></div> </div>';
			}
			?>
                <div class="col-xl-12 col-lg-12 grid-item">
                    <div class="fr3-details">
                      <div class="fr3-job-detail">
                          <div class="fr3-job-img">
                              <a href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo get_profile_img($freelancer_id,'freelancer', 'full'); ?></a>
                              <p><?php echo get_rating($freelancer_id, ''); ?></p>
                          </div>
                          <div class="fr3-job-text">
                              <span class="name"><a href="<?php echo get_the_permalink($freelancer_id); ?>">	<?php echo exertio_get_username('freelancer', $freelancer_id, 'badge'); ?></a></span>
                              <a href="<?php echo get_the_permalink($freelancer_id); ?>"> <h3><?php echo esc_html(get_post_meta( $freelancer_id, '_freelancer_tagline' , true )); ?></h3></a>
                              <?php
							  
							  $excerpt = exertio_get_excerpt(18, $freelancer_id);
							  if($excerpt != '')
							  {
								  ?>
                                  <p class="excerpt"><?php echo esc_html($excerpt); ?></p>
                                  <?php
							  }
							  ?>
                              <?php
							  	if($exertio_theme_options['fl_hourly_rate'] == 3)
								{
									
								}
								else
								{
									$hourly_rate = get_post_meta($freelancer_id, '_freelancer_hourly_rate', true);
									if($hourly_rate != '')
									{
									  ?>
										  <p class="price-tag"><?php echo fl_price_separator($hourly_rate, 'html'); ?><span class="bottom-text"><?php echo esc_html__(' / hr','exertio_theme'); ?></span></p>
									  <?php
									}
								}
								?>
                                <ul class="lists">
                                    <li> <?php echo esc_html__('Member since ','exertio_theme').get_the_date(); ?></li>
                                  </ul>
                                <?php
									$current_user_id = get_current_user_id();
									$saved_freelancer = get_user_meta($current_user_id, '_fl_follow_id_'.$freelancer_id, true);
									$active_saved ='';
									$save_text = esc_html__('Follow','exertio_theme');
									if(isset($saved_freelancer) && $saved_freelancer != '')
									{
										$active_saved = 'active';
										$save_text = esc_html__('Following','exertio_theme');	
									}
								?>
                                <span class="follow <?php echo esc_attr($active_saved); ?> follow-freelancer protip" data-fid="<?php echo esc_html($freelancer_id); ?>" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($save_text); ?>"> <i class="fas fa-heart"></i> <?php echo esc_html($save_text); ?></span>
                          </div>
                      </div>
                      <?php echo wp_return_echo($featured_badge);  ?>
                    </div>
                </div>
            <?php
		}
		
		/*LIST STYLE 2*/
		function exertio_freelancer_list_2($freelancer_id, $col = '') 
		{
			global $exertio_theme_options;
			$author_id = get_post_field( 'post_author', $freelancer_id );
			//$employer_id = get_user_meta( $author_id, 'employer_id' , true );
			$featured_badge =  '';
			$featured_freelancer = get_post_meta($freelancer_id, '_freelancer_is_featured', true);
			if(isset($featured_freelancer) && $featured_freelancer == 1)
			{
				$featured_badge = '<div class="features-star"> <i class="fa fa-star"></i></div>';
			}
			?>
                <div class="col-xl-12 col-lg-12 grid-item">
                    <div class="fr-lance-content3">
                      <div class="fr-lance-detail-box">
                        <div class="fr-lance-profile"> <a href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo get_profile_img($freelancer_id,'freelancer', 'full'); ?></a> </div>
                        <div class="fr-lance-usr-details">
                          <p><?php echo get_rating($freelancer_id, ''); ?></p>
                        </div>
                      </div>
                      <div class="fr-lance-more-details">
                        <div class="fr-lance-s-details2">
                          <ul>
                            <li> <a href="<?php echo get_the_permalink($freelancer_id); ?>"><?php echo exertio_get_username('freelancer', $freelancer_id, 'badge'); ?> </a></li>
                          </ul>
                        </div>
                        <div class="fr-lance-price2">
                          	<?php
							  	if($exertio_theme_options['fl_hourly_rate'] == 3)
								{
									
								}
								else
								{
									$hourly_rate = get_post_meta($freelancer_id, '_freelancer_hourly_rate', true);
									if($hourly_rate != '')
									{
									  ?>
										  <p><?php echo fl_price_separator($hourly_rate, 'html'); ?></p>
										  <span class="bottom-text"><?php echo esc_html__('/ hr','exertio_theme'); ?></span>
									  <?php
									}
								}
							?>
                        </div>
                        <div class="fr-lance-products2">
                        	<a href="<?php echo get_the_permalink($freelancer_id); ?>">
                                <h3><?php echo esc_html(get_post_meta( $freelancer_id, '_freelancer_tagline' , true )); ?></h3>
                            </a>
                          <p><i class="far fa-calendar-alt"></i><?php echo esc_html__('Member since ','exertio_theme').get_the_date(); ?></p>
                        </div>
                        <?php
					  $saved_skills =  json_decode(stripslashes(get_post_meta($freelancer_id, '_freelancer_skills', true)), true);
					  if($saved_skills != '')
					  {
						  ?>
                          <div class="fr-lance-sm-style">
                              <?php
                                    $skill_count = 1;
                                    $skill_hide = '';
									$freelancer_link = get_the_permalink( fl_framework_get_options( 'freelancer_search_page' ) ) . '?skill';
                                    foreach($saved_skills as $skills)
                                    {
                                        $skillsObject = get_term_by( 'id', $skills['skill'] , 'freelancer-skills' );
                                       if($skillsObject != '')
									   {
											$skillsTermName = $skillsObject->name;
											if($skill_count > 5)
											{ $skill_hide = 'hide'; }
											?>
											<a href="<?php echo esc_url($freelancer_link.'='.$skillsObject->term_id); ?>"  class="<?php echo esc_html($skill_hide); ?>"><?php echo esc_html($skillsTermName); ?></a>
											<?php
											$skill_count++;
									   }
                                    }
                                    if($skill_hide != '')
                                    {
                                        ?>
                                        <a href="javascript:void(0)" class="show-skills"><i class="fas fa-ellipsis-h"></i></a>
                                        <?php
                                    }
                                ?>
                          </div>
                          <?php
					  }
					  ?>
                        <p><?php echo exertio_get_excerpt(24, $freelancer_id); ?></p>
                      </div>
                      <?php echo wp_return_echo($featured_badge);  ?>
                    </div>
                </div>
            <?php
		}
	}
}