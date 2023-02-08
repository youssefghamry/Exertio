<?php
if (!class_exists('exertio_get_employers_class'))
{
	class exertio_get_employers_class 
	{
		/*GRID STYLE 1*/
		function exertio_employers_grid_1($employer_id) 
		{
			global $exertio_theme_options;
			$author_id = get_post_field( 'post_author', $employer_id );
			$employer_id = get_user_meta( $author_id, 'employer_id' , true );
			$banner_img_id = get_post_meta( $employer_id, '_employer_banner_id', true );
			$banner_img = wp_get_attachment_image_src( $banner_img_id, 'full' );
			$cover_img ='';
			if(empty($banner_img ))
			{
				$cover_img = "style='background-image:url(".$exertio_theme_options['employer_df_cover']['url']."); background-size: cover; background-repeat: no-repeat;'";
			}
			else
			{
				$cover_img = "style='background-image:url(".$banner_img[0]."); background-size: cover; background-repeat: no-repeat;'";
			}

			
			?>
                <div class="col-xl-6 col-sm-6 col-md-6 col-xs-12 grid-item">
                    <div class="fr-employ-content">
                      <div class="fr-employ-box fr-employ-box-2" <?php echo wp_return_echo($cover_img); ?>>
                      <?php
						$employer_is_featured = get_post_meta($employer_id, '_employer_is_featured', true);
						if(isset($employer_is_featured) && $employer_is_featured == 1)
						{
							echo '<div class="features-star"><i class="fa fa-star"></i></div>';
						}
						?>
                        
                      </div>
                      <div class="fr-employ-container"> 
                          <a href="<?php echo get_the_permalink($employer_id); ?>" class="profile-img"><?php echo get_profile_img($employer_id,'employer'); ?></a>
                        <div class="fr-employer-assets">
                        	<span><?php echo exertio_get_username('employer', $employer_id, 'badge'); ?></span>
                            <a href="<?php echo get_the_permalink($employer_id); ?>">
                          		<h3><?php echo esc_html(get_post_meta( $employer_id, '_employer_tagline' , true )); ?></h3>
                          	</a>
                            <p><?php echo get_term_names('employer-locations', '_employer_location', $employer_id, '', ',' ); ?></p>
                            <?php
                            if( get_user_meta( get_current_user_id(), '_emp_follow_id_'.$employer_id, true ) == $employer_id )
                            {
                                ?>
                                <a href="javascript:void(0)" class="following protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__('Already Following','exertio_theme'); ?>"><i class="far fa-heart"></i></a>
                                <?php
                            }
                            else
                            {
							?>
                            <a href="javascript:void(0)" class="follow-employer protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__('Click to Follow','exertio_theme'); ?>" data-emp-id="<?php echo esc_attr($employer_id); ?>"><i class="far fa-heart"></i></a>
                            
                            <?php
							}
							?>
                            <a href="<?php echo get_the_permalink($employer_id); ?>" class="btn btn-theme"> <?php echo esc_html__('View Profile','exertio_theme'); ?></a>
                        </div>
                      </div>
                    </div>
                </div>
            <?php
		}
		
		/*GRID STYLE 2*/
		function exertio_employers_grid_2($employer_id) 
		{
			$img_id = '';
			global $exertio_theme_options;
			$author_id = get_post_field( 'post_author', $employer_id );
			$employer_id = get_user_meta( $author_id, 'employer_id' , true );
			
			
			$banner_img_id = get_post_meta( $employer_id, '_employer_banner_id', true );
			$banner_img = wp_get_attachment_image_src( $banner_img_id, 'full' );
			$cover_img ='';
			if(empty($banner_img ))
			{
				$cover_img = "style='background-image:url(".$exertio_theme_options['employer_df_cover']['url']."); background-size: cover; background-repeat: no-repeat;'";
			}
			else
			{
				$cover_img = "style='background-image:url(".$banner_img[0]."); background-size: cover; background-repeat: no-repeat;'";
			}
			
			
			?>
                <div class="col-xl-6 col-lg-6 grid-item">
				  <div class="fr3-grid-box">
					<?php
                    $employer_is_featured = get_post_meta($employer_id, '_employer_is_featured', true);
                    //$employer_is_featured = '';
                    if( $employer_is_featured == 1)
                    {
                        echo '<div class="features-star"><i class="fa fa-star"></i></div>';
                        //echo 'featured';
                    }
                    ?>
					  <div class="fr3-box-img" <?php echo wp_return_echo($cover_img); ?>>
						  <div class="fr3-box-user-profile">
						  	<a href="<?php echo get_the_permalink($employer_id); ?>"><?php echo get_profile_img($employer_id,'employer'); ?></a>
						  </div>
						  <div class="fr3-box-icons">
							<?php
                            if( get_user_meta( get_current_user_id(), '_emp_follow_id_'.$employer_id, true ) == $employer_id )
                            {
                                ?>
                                <a href="javascript:void(0)" class="following protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__('Already Following','exertio_theme'); ?>"><i class="fa fa-heart"></i></a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="javascript:void(0)" class="follow-employer protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr__('Click to Follow','exertio_theme'); ?>" data-emp-id="<?php echo esc_attr($employer_id); ?>"><i class="fa fa-heart"></i></a>
                                
                                <?php
                            }
                            ?>
							  
						  </div>
					  </div>
					  <div class="fr3-grid-text">
						  <div class="fre-grid-share">
							 
						  </div>
						  <p><a href="<?php echo get_the_permalink($employer_id); ?>"><?php echo exertio_get_username('employer', $employer_id, 'badge'); ?></a></p>
						  <h3> <?php echo esc_html(get_post_meta( $employer_id, '_employer_tagline' , true )); ?></h3>
						  <p><?php echo get_term_names('employer-locations', '_employer_location', $employer_id, '', ',' ); ?> </p>
					  </div>
					  
					  <div class="fr-btn-grid">
					  	 <a href="<?php echo get_the_permalink($employer_id); ?>" class=""> <?php echo esc_html__('View Profile','exertio_theme'); ?></a>
					  </div>
				  </div>
			  </div>
              <?php
		}
	}
}