<?php
if (!class_exists('exertio_get_services'))
{
	class exertio_get_services 
	{
		function exertio_listings_grid_1($service_id, $slider = '')
		{
			$author_id = get_post_field( 'post_author', $service_id );
			$fid = get_user_meta( $author_id, 'freelancer_id' , true );
			
			$posted_date = get_the_date(get_option( 'date_format' ), $service_id );
			$cols = 'col-xl-6 col-xs-12 col-lg-6 col-sm-6 col-md-6';
			$col_size = fl_framework_get_options('service_grid_size');
			if(isset($col_size) && $col_size == '0')
			{
				$cols = 'col-xl-4 col-xs-12 col-lg-4 col-sm-6 col-md-4';	
			}
			else if(isset($col_size) && $col_size == '1')
			{
				$cols = 'col-xl-6 col-xs-12 col-lg-6 col-sm-6 col-md-6';	
			}
			if($slider != '')
			{
				$cols = $slider;
			}
			$image = exertio_get_service_post_image($service_id);

			$saved_service = get_user_meta(get_current_user_id(), '_service_fav_id_'.$service_id, true);

			$active_saved ='';
			$save_text = esc_html__('Save Service','exertio_theme');
			if(isset($saved_service) && $saved_service != '')
			{
				$active_saved = 'active';
				$save_text = esc_html__('Already Saved','exertio_theme');	
			}
			$limit = $title = '';
			$limit = fl_framework_get_options('sevices_search_title_limit_grid');
			$title = strlen(get_the_title());
			if($title > $limit)
			{
				$title = substr(get_the_title($service_id),0,$limit).'....';
			}
			else
			{
				$title = get_the_title($service_id); 
			}
			$featured_badge =  '';
			$featured_service = get_post_meta($service_id, '_service_is_featured', true);
			if(isset($featured_service) && $featured_service == 1)
			{
				$featured_badge = '<div class="fr-top-featured"> <span class="badge">'.esc_html__( 'Featured', 'exertio_theme' ).'</span> </div>';
			}

			return '<div class="'.$cols.'  grid-item">
						<div class="fr-top-contents bg-white-color">
						  <div class="fr-top-product">'.$image.'
						  '.$featured_badge.'
							<div class="fr-top-rating"> <a href="javascript:void(0)" class="save_service protip '.esc_attr($active_saved).'" data-fid="'.esc_html($fid).'" data-pt-position="top" data-pt-scheme="black" data-pt-title="'.esc_attr($save_text).'" data-post-id="'.esc_attr($service_id).'"><i class="fa fa-heart"></i></a> </div>
						  </div>
						  <div class="fr-top-details"> <span class="rating"> <i class="fa fa-star"></i> '.get_service_rating($service_id).'</span>
							<a href="'.esc_url(get_the_permalink($service_id)).'" title="'.get_the_title($service_id).'">
								<div class="fr-style-5">'.$title.'</div>
							</a>
							<p>'.esc_html__('Starting From','exertio_theme').'<span class="style-6">'.fl_price_separator(get_post_meta($service_id, '_service_price', true), 'html').'</span></p>
							<div class="fr-top-grid"> <a href="'.esc_url(get_permalink($fid)).'">'.get_profile_img($fid, "freelancer").'</a></div>
						  </div>
						  <div class="fr-top-grid-bar">
							<p>'.exertio_queued_services($service_id).'</p>
						</div>
						</div>
					</div>';
		}
		
		function exertio_listings_grid_2($service_id, $slider = '')
		{
			$author_id = get_post_field( 'post_author', $service_id );
			$fid = get_user_meta( $author_id, 'freelancer_id' , true );
			

			$posted_date = get_the_date(get_option( 'date_format' ), $service_id );
			$cols = 'col-xl-6 col-xs-12 col-lg-6 col-sm-6 col-md-6';
			$col_size = fl_framework_get_options('service_grid_size');
			if(isset($col_size) && $col_size == '0')
			{
				$cols = 'col-xl-4 col-xs-12 col-lg-4 col-sm-6 col-md-4';	
			}
			else if(isset($col_size) && $col_size == '1')
			{
				$cols = 'col-xl-6 col-xs-12 col-lg-6 col-sm-6 col-md-6';	
			}
			if($slider != '')
			{
				$cols = $slider;
			}
			$image = exertio_get_service_post_image($service_id);

			$saved_service = get_user_meta(get_current_user_id(), '_service_fav_id_'.$service_id, true);
			$active_saved ='';
			$save_text = esc_html__('Save Service','exertio_theme');
			if(isset($saved_service) && $saved_service != '')
			{
				$active_saved = 'active';
				$save_text = esc_html__('Already Saved','exertio_theme');	
			}
			$limit = $title = '';
			$limit = fl_framework_get_options('sevices_search_title_limit_grid');
			$title = strlen(get_the_title());
			if($title > $limit)
			{
				$title = substr(get_the_title($service_id),0,$limit).'....';
			}
			else
			{
				$title = get_the_title($service_id); 
			}
			$featured_badge =  '';
			$featured_service = get_post_meta($service_id, '_service_is_featured', true);
			if(isset($featured_service) && $featured_service == 1)
			{
				$featured_badge = '<div class="fr-latest-btn"> <span class="badge">'.esc_html__( 'Featured', 'exertio_theme' ).'</span> </div>';
			}
			return '<div class="'.$cols.'  grid-item">
						<div class="fr-latest-grid">
						  <div class="fr-latest-img">
						  	'.$image.'
							 '.$featured_badge.'
						  </div>
						  <div class="fr-latest-details">
						  		<div class="fr-latest-content-service">
								  <div class="fr-latest-profile">
								  	<a class="user-image" href="'.esc_url(get_permalink($fid)).'">'.get_profile_img($fid, "freelancer").'</a>
									<div class="fr-latest-profile-data"	>
										<span class="fr-latest-name"><a href ="'.esc_url(get_permalink($fid)).'">'.exertio_get_username('freelancer', $fid, 'badge', 'right').'</a></span>
									</div>
								</div>	
								  <p><a href="'.esc_url(get_permalink($service_id)).'" title="'.get_the_title($service_id).'">'.$title.'</a></p>
								  <a href="javascript:void(0)" class="queue">'.exertio_queued_services($service_id).'</a>
								  <span class="reviews"><i class="fa fa-star"></i> '.get_service_rating($service_id).'</span>
								  
							  </div>
							  <div class="fr-latest-bottom">
							  <p>'.esc_html__('Starting From','exertio_theme').'<span>'.fl_price_separator(get_post_meta($service_id, '_service_price', true), 'html').'</span></p>
							  <a href="javascript:void(0)" class="save_service  protip '.$active_saved.'" data-pt-position="top" data-pt-scheme="black"  data-pt-title="'.$save_text.'" data-post-id="'.esc_attr($service_id).'"><i class="fa fa-heart"></i></a>
							  </div>
						  </div>
					  </div>
					</div>';
		}
		
		/*LIST STYLE 1*/
		function exertio_listings_list_1($service_id)
		{
			$image = exertio_get_service_post_image($service_id);
			$author_id = get_post_field( 'post_author', $service_id );
			$fid = get_user_meta( $author_id, 'freelancer_id' , true );
			
			$saved_service = get_user_meta(get_current_user_id(), '_service_fav_id_'.$service_id, true);
			$active_saved ='';
			$save_text = esc_html__('Save Service','exertio_theme');
			if(isset($saved_service) && $saved_service != '')
			{
				$active_saved = 'active';
				$save_text = esc_html__('Already Saved','exertio_theme');	
			}
			?>
            <div class="col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12  grid-item">
            	<div class="exertio-service-list">
                    <div class="row no-gutters">
                        <div class="col-xl-4 col-xs-12 col-lg-4 col-sm-4 col-md-4">
                            <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                <div class="featured-image">
                                        <?php echo wp_return_echo($image); ?>
                                </div>
                            </a>
                            <?php
                            	$featured_badge =  '';
								$featured_service = get_post_meta($service_id, '_service_is_featured', true);
								if(isset($featured_service) && $featured_service == 1)
								{
									?>
										<div class="features-star"><i class="fa fa-star"></i></div>
									
									<?php
								}
                            ?>
                        </div>
                        <div class="col-xl-8 col-xs-12 col-lg-8 col-sm-8 col-md-8">
                        	<div class="exertio-services-box">
                                <div class="exertio-service-desc">
                                    <span class="rating"> <i class="fa fa-star"></i><?php echo get_service_rating($service_id); ?></span>
                                    <div class="exertio-service-title">
                                    	<a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php echo get_the_title(); ?>">
											<?php
                                            $limit = $title = '';
                                            $limit = fl_framework_get_options('sevices_search_title_limit_list');
                                            $title = strlen(get_the_title());
                                            if($title > $limit)
                                            {
                                                echo substr(get_the_title(),0,$limit).'....';
                                            }
                                            else
                                            {
                                                echo get_the_title(); 
                                            }
                                            ?>
                                        </a>
                                    </div>
                                    <span class="desc-meta"> <?php echo __( 'by:', 'exertio_theme' ); ?> <a href="<?php echo esc_url(get_permalink($fid)); ?>"> <?php echo exertio_get_username('freelancer', $fid); ?></a></span>
                                    <div class="fr-top-rating"> <a href="javascript:void(0)" class="save_service protip <?php echo esc_attr($active_saved); ?>" data-fid="'.esc_html($fid).'" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($save_text); ?>" data-post-id="<?php echo esc_attr($service_id); ?>"><i class="fa fa-heart"></i></a> </div>
                                </div>
                                <div class="exertio-services-bottom">
                                    <ul>
                                        <li><?php echo esc_html__('Starting From ','exertio_theme'); ?><span class="style-6"><?php echo fl_price_separator(get_post_meta($service_id, '_service_price', true), 'html'); ?></span></li>
                                        <li class="orders"> <?php echo exertio_queued_services($service_id); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
		}
		
		function exertio_listings_list_2($service_id)
		{
			$author_id = get_post_field( 'post_author', $service_id );
			$fid = get_user_meta( $author_id, 'freelancer_id' , true );
			?>
            <div class="col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12  grid-item">
            	<div class="exertio-services-list-2">
            		<?php
                    	$featured_badge =  '';
						$featured_service = get_post_meta($service_id, '_service_is_featured', true);
						if(isset($featured_service) && $featured_service == 1)
						{
							?>
								<div class="features-star"><i class="fa fa-star"></i></div>
							
							<?php
						}
                    ?>
                    <div class="exertio-services-2-meta">
                        <ul>
                            <li>
                            	<div class="rating">
                                	<i class="fa fa-star"></i>
									<?php echo get_service_rating($service_id); ?>
                                </div>
                                <h3>
                                    <a href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php echo get_the_title(); ?>">
                                    	<?php
										$limit = $title = '';
										$limit = fl_framework_get_options('sevices_search_title_limit_list');
                                        $title = strlen(get_the_title());
										if($title > $limit)
										{
											echo substr(get_the_title(),0,$limit).'....';
										}
										else
										{
											echo get_the_title(); 
										}
										?>
                                    </a>
                                </h3>
                                <p>
                                    <a href="<?php echo esc_url(get_permalink($fid)); ?>" class="author"><?php echo exertio_get_username('freelancer', $fid, 'badge'); ?></a>
                                    <a href="javascript:void(0)"> <i class="fas fa-redo"></i> <?php echo exertio_queued_services($service_id); ?></a>
                                </p>
                            </li>
                            <li>
                            	<?php echo esc_html__('Starting From ','exertio_theme'); ?><span class="style-6"><?php echo fl_price_separator(get_post_meta($service_id, '_service_price', true), 'html'); ?></span>
                            </li>
                            <!--<li>
                            	<a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-theme"><?php echo esc_html__( 'View Detail', 'exertio_theme' ); ?></a>
                                <p><?php echo exertio_queued_services($service_id); ?></p>
                            </li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <?php
		}
	}
}