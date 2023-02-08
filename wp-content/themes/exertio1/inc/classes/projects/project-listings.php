<?php
if (!class_exists('exertio_get_projects'))
{
	class exertio_get_projects 
	{
		/*LIST STYLE 1*/
		function exertio_projects_list_1($project_id, $cols ='') 
		{
			$author_id = get_post_field( 'post_author', $project_id );
			$employer_id = get_user_meta( $author_id, 'employer_id' , true );
			if(isset($cols) && $cols != '' )
			{
				$col_size = $cols;
			}
			else
			{
				$col_size = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}
			$limit = $title = '';
			$limit = fl_framework_get_options('project_search_title_limit');
			$title = strlen(get_the_title());
			if($title > $limit && $limit != '')
			{
				$title = substr(get_the_title(),0,$limit).'....';
			}
			else
			{
				$title = get_the_title(); 
			}
			$ext_title_class  =   "";
            $search_detail = "";
            $detail_link    =   esc_url(get_the_permalink());
            if(fl_framework_get_options('project_sidebar_layout') == '2') {

                $ext_title_class  =   "show_detail_project";
                $detail_link   =   "javascript:void(0)";
                if ( is_page_template( 'page-project-search.php' )){
                    $search_detail = "project_search_detail";
                }

            }
			?>
            <div class="<?php echo esc_attr($col_size); ?>">
            	<div class="fr-right-detail-box <?php echo esc_attr( $ext_title_class); ?>" data-post-id = "<?php echo $project_id; ?>">
                  <div class="fr-right-detail-content">
                    <div class="fr-right-details-products">
						<?php
                        $featured_projects = get_post_meta($project_id, '_project_is_featured', true);

                        if(isset($featured_projects) && $featured_projects == 1)
                        {
							?>
							<div class="features-star"><i class="fa fa-star"></i></div>
							<?php
                        }
                        ?>
                      <div class="fr-right-views">
                        <ul>
                          <li><span><a href="<?php echo get_permalink($employer_id); ?>"><?php echo exertio_get_username( 'employer', $employer_id, 'badge' ); ?></a></span> </li>
                        </ul>
                      </div>
                      <div class="fr-jobs-price">
                        <div class="style-hd">
                        	<?php
								$project_type_text = '';
								$type = get_post_meta($project_id, '_project_type', true);
								if($type == 'fixed' || $type == 1)
								{
									$project_type_text = esc_html__('Fixed ','exertio_theme');
									echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)));
								}
								else if($type == 'hourly' || $type == 2)
								{
									$project_type_text = esc_html__('Hourly ','exertio_theme');
									$hourly_price = get_post_meta($project_id, '_project_cost', true);
									$estimated_hours = get_post_meta($project_id, '_estimated_hours', true);
									if(isset($hourly_price) && $hourly_price != '' && isset($estimated_hours) && $estimated_hours != '')
									{
										$total_hourly_price = $hourly_price*$estimated_hours;
										
										$save_text = esc_html__( 'Estimated Hours ', 'exertio_theme' ).$estimated_hours."<br><br>".esc_html__( 'Total: ', 'exertio_theme' ).get_post_meta($project_id, '_project_cost', true)."*".$estimated_hours."= ".fl_price_separator($total_hourly_price);
									$q_mark =  '<small class="protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="'.$save_text.'"><i class="far fa-question-circle"></i></small>';
									}
									else
									{
										$total_hourly_price = '';
										$q_mark = '';
									}
										
									echo esc_html(fl_price_separator($hourly_price)).$q_mark;
									
									
								}
							 ?>
                        </div>
                        <p>(<?php echo esc_html($project_type_text); ?>)</p>
                      </div>
                      <div class="fr-right-details2">
                      	<a href='<?php echo esc_attr($detail_link);?>'   data-post-id = "<?php echo $project_id; ?>"   class="<?php echo esc_attr( $ext_title_class); ?>" >
                        	<h3    title="<?php echo esc_html(get_the_title()); ?>"><?php echo esc_html($title); ?></h3>
                        </a> </div>
                      <div class="fr-right-product">
                        <ul class="skills">
                        	<?php
								$listings_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?skill';
								$saved_skills = wp_get_post_terms($project_id, 'skills', array( 'fields' => 'all' ));
								$skill_count = 1;
								$skill_hide = '';
								foreach($saved_skills as $saved_skill)
								{
									if($skill_count > 4)
									{ $skill_hide = 'hide'; }
									?>
                                    <li class="<?php echo esc_html($skill_hide); ?>"><a href="<?php echo esc_url($listings_link.'='.$saved_skill->term_id); ?>"><?php echo esc_html($saved_skill->name); ?></a></li>
									<?php
								  $skill_count++;
								}
								if($skill_hide != '')
								{
									?>
                                    <li class="show-skills"><a href="javascript:void(0)"><i class="fas fa-ellipsis-h"></i></a></li>
									<?php
								}
							?>
                        </ul>
                      </div>
                      <div class="fr-right-index">
                        <p><?php echo exertio_get_excerpt(25, $project_id); ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="fr-right-information">
                    <div class="fr-right-list">
                      <ul>
                        <li>
                          <p class="heading"> <?php echo esc_html__( 'Expiry: ', 'exertio_theme' ); ?></p>
                          <div><?php echo project_expiry_calculation($project_id); ?></div>
                        </li>
                        <li>
                          <p class="heading"><?php echo esc_html__( 'Proposals', 'exertio_theme' ); ?></p>
                          <?php
						  	$results = get_project_bids($project_id);
							if (is_countable($results) && count($results) > 0)
							{
								$results = count(get_project_bids($project_id));
							}
							else
							{
								$results = 0;
							}
						  ?>
                          <span><?php echo esc_html($results).esc_html__( ' Received ', 'exertio_theme' ); ?></span>
                        </li>
                        <?php
							$project_location = get_term( get_post_meta($project_id, '_project_location', true));
							if(!empty($project_location) && ! is_wp_error($project_location))
							{
						  ?>
								<li>
								  <p class="heading"><?php echo esc_html__( 'Location', 'exertio_theme' ); ?></p>
								  <span>
									  	<?php
											$location_remote = get_post_meta($project_id, '_project_location_remote', true);
											if(isset($location_remote) && $location_remote == 1)
											{
												echo esc_html__('Remote','exertio_theme');
											}
											else
											{
												echo esc_html($project_location->name);
											}
									  	?>
									</span>
								</li>
							<?php
							}
							?>
                      </ul>
                    </div>
                    <div class="fr-right-bid">
                      <ul>
                      	<?php
							$saved_project = '';
							$save_text = esc_html__( 'Save project', 'exertio_theme' );
							if( get_user_meta( get_current_user_id(), '_pro_fav_id_'.$project_id, true ) == $project_id )
							{
								$saved_project = 'active';
								$save_text = esc_html__( 'Already saved', 'exertio_theme' );
							}
						?>
                        <li> <a href="javascript:void(0);" class="mark_fav protip <?php echo esc_attr($saved_project); ?>" data-post-id="<?php echo esc_attr($project_id); ?>" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($save_text); ?>"><i class="fa fa-heart active"></i></a> </li>
                        <li><a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-theme"><?php echo esc_html__( ' Send Proposal ', 'exertio_theme' ); ?></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
            </div>
            <?php
		}
		
		function exertio_projects_list_2($project_id, $cols = '') 
		{
			$author_id = get_post_field( 'post_author', $project_id );
			$employer_id = get_user_meta( $author_id, 'employer_id' , true );
			if(isset($cols) && $cols != '' )
			{
				$col_size = $cols;
			}
			else
			{
				$col_size = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}
			$limit = $title = '';
			$limit = fl_framework_get_options('project_search_title_limit');
			$title = strlen(get_the_title());
			if($title > $limit && $limit != '')
			{
				$title = substr(get_the_title(),0,$limit).'....';
			}
			else
			{
				$title = get_the_title(); 
			}
			?>
            <div class="<?php echo esc_attr($col_size); ?>">
            	<div class="project-list-2">
                	<div class="top-side">
                    	<span class="user-name"> <a href="<?php echo get_permalink($employer_id); ?>"><?php echo exertio_get_username('employer', $employer_id, 'badge'); ?></a></span>
                    	 <h4 class="project-title"> <a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php echo esc_html(get_the_title()); ?>"><?php echo esc_html($title); ?></a></h4>
                        <span class="listing2-project-price">
                        <?php 
								$project_type_text = '';
								$type = get_post_meta($project_id, '_project_type', true);
								if($type == 'fixed' || $type == 1)
								{
									$project_type_text = esc_html__('Fixed ','exertio_theme');
									echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)));
								}
								else if($type == 'hourly' || $type == 2)
								{
									$project_type_text = esc_html__('Hourly ','exertio_theme');
									$hourly_price = get_post_meta($project_id, '_project_cost', true);
									$estimated_hours = get_post_meta($project_id, '_estimated_hours', true);
									
									if(isset($hourly_price) && $hourly_price != '' && isset($estimated_hours) && $estimated_hours != '')
									{
										$total_hourly_price = $hourly_price*$estimated_hours;
										
										$save_text = esc_html__( 'Estimated Hours ', 'exertio_theme' ).$estimated_hours."<br><br>".esc_html__( 'Total: ', 'exertio_theme' ).get_post_meta($project_id, '_project_cost', true)."*".$estimated_hours."= ".fl_price_separator($total_hourly_price);
									$q_mark = '<small class="protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="'.esc_html($save_text).'"><i class="far fa-question-circle"></i></small>';
									}
									else
									{
										$total_hourly_price = '';
										$q_mark = '';
									}
									
									echo esc_html(fl_price_separator($hourly_price)).$q_mark;
									
									
								}
							 ?>
                             <span>(<?php echo esc_html($project_type_text); ?>)</span>
                        </span>
                    </div>
                    <div class="bottom-side">
                    	<ul class="features">
                        <?php
                        	$project_duration = get_term_names('project-duration', '_project_duration', $project_id );
							$project_level =  get_term_names('project-level', '_project_level', $project_id );
							$freelancer_typel = get_term_names('freelancer-type', '_project_freelancer_type', $project_id );
						?>
                        	<li><i class="far fa-calendar-alt"></i> <?php echo project_expiry_calculation($project_id); ?></li>
                            <li><i class="fas fa-history"></i> <?php echo esc_html($project_duration); ?></li>
                            <li><i class="far fa-address-book"></i>  <?php echo esc_html($project_level); ?></li>
                            <li><i class="far fa-id-badge"></i> <?php echo esc_html($freelancer_typel); ?></li>
                        </ul>
                        <p><?php echo exertio_get_excerpt(30, $project_id); ?></p>
						<div class="project-list-2-bottom">
							<?php
								$listings_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?skill';
									$saved_skills = wp_get_post_terms($project_id, 'skills', array( 'fields' => 'all' ));
									$skill_count = 1;
									$skill_hide = '';
								if(isset($saved_skills) && !empty($saved_skills) )
								{
									?>
									<ul class="skills">
										<?php
											foreach($saved_skills as $saved_skill)
											{
												if($skill_count > 4)
												{ 
													$skill_hide = 'hide';
												}
												?>
												<li class="<?php echo esc_html($skill_hide); ?>"><a href="<?php echo esc_url($listings_link.'='.$saved_skill->term_id); ?>"><?php echo esc_html($saved_skill->name); ?></a></li>
												<?php
											  $skill_count++;
											}

											if($skill_hide != '')
											{
												?>
												<li class="show-skills"><a href="javascript:void(0)"><i class="fas fa-ellipsis-h"></i></a></li>
												<?php
											}
										?>
										</ul>
									<?php
								}
								$saved_project = '';
								$save_text = esc_html__( 'Save project', 'exertio_theme' );
								if( get_user_meta( get_current_user_id(), '_pro_fav_id_'.$project_id, true ) == $project_id )
								{
									$saved_project = 'active';
									$save_text = esc_html__( 'Already saved', 'exertio_theme' );
								}
							?>
							<div class="view-btn"><a href="javascript:void(0);" class="mark_fav protip <?php echo esc_attr($saved_project); ?>" data-post-id="<?php echo esc_attr($project_id); ?>" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($save_text); ?>"><i class="fa fa-heart active"></i></a> <a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-theme"><?php echo esc_html__( 'View Job', 'exertio_theme' ); ?></a></div>
						</div>
                    </div>
                    <?php
					$featured_projects = get_post_meta($project_id, '_project_is_featured', true);
					if(isset($featured_projects) && $featured_projects == 1)
					{
						?>
						<div class="features-star"><i class="fa fa-star"></i></div>
						<?php
					}
					?>
                </div>
            </div>
            <?php
		}
		
		function exertio_projects_list_3($project_id, $cols = '') 
		{
			$author_id = get_post_field( 'post_author', $project_id );
			$employer_id = get_user_meta( $author_id, 'employer_id' , true );
			$limit = $title = '';
			$limit = fl_framework_get_options('project_search_title_limit');
			$title = strlen(get_the_title());
			if($title > $limit && $limit != '')
			{
				$title = substr(get_the_title(),0,$limit).'....';
			}
			else
			{
				$title = get_the_title(); 
			}
			
			
			$bid_results = get_project_bids($project_id);
			if (is_countable($bid_results) && count($bid_results) > 0)
			{
				$bid_results = count(get_project_bids($project_id));
			}
			else
			{
				$bid_results = 0;
			}
			if(isset($cols) && $cols != '' )
			{
				$col_size = $cols;
			}
			else
			{
				$col_size = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}
			?>
            <div class="<?php echo esc_attr($col_size); ?>">
                <div class="res-us-details">
                    <div class="res-us-skills">
                      <div class="res-us-product">
                          <ul>
                              <li><span><?php echo exertio_get_username('employer', $employer_id, 'badge'); ?></span></li>
                          </ul>
                          <h3><a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php echo get_the_title(); ?>"><?php echo esc_html($title); ?></a></h3>
                          <p class="price">
                          	<?php
								$project_type_text = '';
								$type = get_post_meta($project_id, '_project_type', true);
								if($type == 'fixed' || $type == 1)
								{
									$project_type_text = esc_html__('Fixed','exertio_theme');
									echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)));
								}
								else if($type == 'hourly' || $type == 2)
								{
									$project_type_text = esc_html__('Hourly','exertio_theme');
									$hourly_price = get_post_meta($project_id, '_project_cost', true);
									$estimated_hours = get_post_meta($project_id, '_estimated_hours', true);
									
									if(isset($hourly_price) && $hourly_price != '' && isset($estimated_hours) && $estimated_hours != '')
									{
										$total_hourly_price = $hourly_price*$estimated_hours;
										
										$save_text = esc_html__( 'Estimated Hours ', 'exertio_theme' ).$estimated_hours."<br><br>".esc_html__( 'Total: ', 'exertio_theme' ).get_post_meta($project_id, '_project_cost', true)."*".$estimated_hours."= ".fl_price_separator($total_hourly_price);
									$q_mark = '<small class="protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="'.esc_html($save_text).'"><i class="far fa-question-circle"></i></small>';
									}
									else
									{
										$total_hourly_price = '';
										$q_mark = '';
									}
									echo esc_html(fl_price_separator($hourly_price)).$q_mark;

								}
							 ?>
                            <strong>(<?php echo esc_html($project_type_text); ?>)</strong>
                          </p>
                          <p class="desc"><?php echo exertio_get_excerpt(20, $project_id); ?></p>
                      </div>
                      <div class="res-us-exp skills">
                        	<?php
								$listings_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?skill';
								$saved_skills = wp_get_post_terms($project_id, 'skills', array( 'fields' => 'all' ));
								$skill_count = 1;
								$skill_hide = '';
								foreach($saved_skills as $saved_skill)
								{
									if($skill_count > 4)
									{ 
										$skill_hide = 'hide';
									}
									?>
                                    <a href="<?php echo esc_url($listings_link.'='.$saved_skill->term_id); ?>"  class="<?php echo esc_html($skill_hide); ?>"><?php echo esc_html($saved_skill->name); ?></a>
									<?php
								  $skill_count++;
								}
								
								if($skill_hide != '')
								{
									?>
                                    <a href="javascript:void(0)" class="show-skills"><i class="fas fa-ellipsis-h"></i></a>
									<?php
								}
							?>
                      </div>
                    </div>
                    <div class="res-us-inline">
                      <ul>
                      	<?php
                        	$project_duration = get_term_names('project-duration', '_project_duration', $project_id );
							$project_level =  get_term_names('project-level', '_project_level', $project_id );
							$freelancer_type = get_term_names('freelancer-type', '_project_freelancer_type', $project_id );
						?>
                        <li><span><i class="fas fa-gavel"></i>  <?php echo esc_html($bid_results).esc_html__( ' Proposals', 'exertio_theme' ); ?></span></li>
                        <li><span><i class="far fa-money-bill-alt"></i>  <?php echo esc_html($project_level); ?></span></li>
                        <li><span><i class="fas fa-history"></i> <?php echo esc_html($project_duration); ?></span></li>
                        <li><span><i class="far fa-user"></i> <?php echo esc_html($freelancer_type); ?></span></li>
                        <li><span><i class="far fa-calendar-alt"></i> <?php echo project_expiry_calculation($project_id); ?></span></li>
                        <li class="fr1-top-content">
                        	<?php
								$marked_fav = $fav  = '';
								$fav_text = esc_html__('Save Job','exertio_theme');
								$marked_fav = get_user_meta( get_current_user_id(), '_pro_fav_id_'.$project_id, true );
								if(isset($marked_fav) && $marked_fav != '' )
								{
									$fav = 'fav';
									$fav_text = esc_html__('Already Saved','exertio_theme');
								}
							?>
                            <span><a href="javascript:void(0)" class="mark_fav protip <?php echo esc_attr($fav); ?>"  data-post-id="<?php echo esc_attr($project_id); ?>" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($fav_text); ?>"><i class="fa fa-heart"></i></a></span>
                            <p><a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-theme"><?php echo esc_html__( 'View Job', 'exertio_theme' ); ?></a></p>
                        </li>
                      </ul>
                    </div>
                    <?php
					$featured_projects = get_post_meta($project_id, '_project_is_featured', true);

					if(isset($featured_projects) && $featured_projects == 1)
					{
						?>
						<div class="features-star"><i class="fa fa-star"></i></div>
						<?php
					}
					?>
                </div>
            </div>
            <?php
		}
		
		function exertio_projects_list_4($project_id, $cols = '') 
		{
			$author_id = get_post_field( 'post_author', $project_id );
			$employer_id = get_user_meta( $author_id, 'employer_id' , true );
			$limit = $title = '';
			$limit = fl_framework_get_options('project_search_title_limit');
			$title = strlen(get_the_title());
			if($title > $limit && $limit != '')
			{
				$title = substr(get_the_title(),0,$limit).'....';
			}
			else
			{
				$title = get_the_title(); 
			}
			
			
			$bid_results = get_project_bids($project_id);
			if (is_countable($bid_results) && count($bid_results) > 0)
			{
				$bid_results = count(get_project_bids($project_id));
			}
			else
			{
				$bid_results = 0;
			}
			if(isset($cols) && $cols != '' )
			{
				$col_size = $cols;
			}
			else
			{
				$col_size = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}
			
			$bid_results = get_project_bids($project_id);
			if (is_countable($bid_results) && count($bid_results) > 0)
			{
				$bid_results = count(get_project_bids($project_id));
			}
			else
			{
				$bid_results = 0;
			}
			?>
            <div class="<?php echo esc_attr($col_size); ?>">
                <div class="fr-latest2-content-box">
				  <div class="fr-latest2-rating">
					<ul>
					  <li>
						<p><?php echo exertio_get_username('employer', $employer_id, 'badge'); ?></p>
					  </li>
					</ul>
					<div class="style-text">
						<a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php echo get_the_title(); ?>"><?php echo esc_html($title); ?></a>
					</div>
					<div class="res-us-exp skills">
                        	<?php
								$saved_skills = wp_get_post_terms($project_id, 'skills', array( 'fields' => 'all' ));
								$skill_count = 1;
								$skill_hide = '';
								foreach($saved_skills as $saved_skill)
								{
									if($skill_count > 4)
									{ 
										$skill_hide = 'hide';
									}
									?>
                                    <a href="<?php echo esc_url(get_term_link($saved_skill->term_id)); ?>"  class="<?php echo esc_html($skill_hide); ?>"><?php echo esc_html($saved_skill->name); ?></a>
									<?php
								  $skill_count++;
								}
								
								if($skill_hide != '')
								{
									?>
                                    <a href="javascript:void(0)" class="show-skills"><i class="fas fa-ellipsis-h"></i></a>
									<?php
								}
							?>
                      </div>
				  </div>
				  <div class="fr-latest2-price">
					<ul>
					  <li> <span> <?php echo esc_html__( 'Price ', 'exertio_theme' ); ?></span>
						<p class="info-in">
							<?php
								$project_type_text =  '';
								$type = get_post_meta($project_id, '_project_type', true);
								if($type == 'fixed' || $type == 1)
								{
									$project_type_text = esc_html__('Fixed','exertio_theme');
									echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)));
								}
								else if($type == 'hourly' || $type == 2)
								{
									$project_type_text = esc_html__('Hourly ','exertio_theme');
									$hourly_price = get_post_meta($project_id, '_project_cost', true);
									$estimated_hours = get_post_meta($project_id, '_estimated_hours', true);
									if(isset($hourly_price) && $hourly_price != '' && isset($estimated_hours) && $estimated_hours != '')
									{
										$total_hourly_price = $hourly_price*$estimated_hours;
										
										$save_text = esc_html__( 'Estimated Hours ', 'exertio_theme' ).$estimated_hours."<br><br>".esc_html__( 'Total: ', 'exertio_theme' ).get_post_meta($project_id, '_project_cost', true)."*".$estimated_hours."= ".fl_price_separator($total_hourly_price);
									$q_mark =  '<small class="protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="'.$save_text.'"><i class="far fa-question-circle"></i></small>';
									}
									else
									{
										$total_hourly_price = '';
										$q_mark = '';
									}
									echo esc_html(fl_price_separator($hourly_price)).$q_mark;
								}
							 ?>						
						</p>
					  </li>
					  <li> <span class="info-col"><?php echo esc_html__( 'Expiry', 'exertio_theme' ); ?></span>
						<?php echo project_expiry_calculation($project_id); ?>
					  </li>
					  <li> <span class="info-col"> <?php echo esc_html__( 'Proposals', 'exertio_theme' ); ?></span>
						<p> <?php echo esc_html($bid_results).esc_html__( ' Received', 'exertio_theme' ); ?></p>
					  </li>
					</ul>
				  </div>

				  <div class="fr-latest2-bid"> 
					  <?php
							$marked_fav = $fav  = '';
							$fav_text = esc_html__('Save Job','exertio_theme');
							$marked_fav = get_user_meta( get_current_user_id(), '_pro_fav_id_'.$project_id, true );
							if(isset($marked_fav) && $marked_fav != '' )
							{
								$fav = 'fav';
								$fav_text = esc_html__('Already Saved','exertio_theme');
							}
						?>
						<span><a href="javascript:void(0)" class="mark_fav protip <?php echo esc_attr($fav); ?>"  data-post-id="<?php echo esc_attr($project_id); ?>" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($fav_text); ?>"><i class="fa fa-heart"></i></a></span>
					  
				  <a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-theme"><?php echo esc_html__( 'View Detail', 'exertio_theme' ); ?></a>          
				  </div>		
					<?php
						$featured_projects = get_post_meta($project_id, '_project_is_featured', true);
						if(isset($featured_projects) && $featured_projects == 1)
						{
							?>
							<div class="features-star"><i class="fa fa-star"></i></div>
							<?php
						}
					?>
				</div>
            </div>
			
            <?php
		}
		
	}
}