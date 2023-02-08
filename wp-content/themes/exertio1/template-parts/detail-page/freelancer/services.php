<?php
global $exertio_theme_options;
$fl_id = get_the_ID();
$author_id = get_post_field( 'post_author', $fl_id );
$alt_id = '';
$limit = get_option( 'posts_per_page' );
if(isset($exertio_theme_options['freelancer_services_limit']))
{
	$limit = $exertio_theme_options['freelancer_services_limit'];
}

$the_query = new WP_Query( 
						array( 
								'author__in' => array( $author_id ) ,
								'post_type' =>'services',
								'meta_query' => array(
									array(
										'key' => '_service_status',
										'value' => 'active',
										'compare' => '=',
										),
									),
								'paged' => $paged,	
								'post_status'     => 'publish',
								'posts_per_page' => $limit,												
								)
							);
		
		$total_count = $the_query->found_posts;
if ( $the_query->have_posts() )
{
	if($total_count >0 )
	{
	?>
    <section class="fr-services-content-2">
      <div class="container">
        <div class="row">
          <div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
          	<div class="fr-top-services fr-bg-white-2">
            	<?php
                        if(isset($exertio_theme_options['freelancer_services_title']))
                        {
                            ?>
                            <div class="heading-contents">
                              <h3><?php echo esc_html($exertio_theme_options['freelancer_services_title']); ?></h3>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="top-services-2 owl-carousel owl-theme">
                        <?php
							while ( $the_query->have_posts() ) 
							{
								$the_query->the_post();
								$sid = get_the_ID();
								$posted_date = get_the_date(get_option( 'date_format' ), $sid );
					?>
								  <div class="item">
									<div class="fr-top-contents">
									  <div class="fr-top-product">
										<?php
										echo exertio_get_service_post_image($sid);
										$featured_badge =  '';
										$featured_service = get_post_meta($sid, '_service_is_featured', true);
										if(isset($featured_service) && $featured_service == 1)
										{
											echo '<div class="fr-top-featured"> <span class="badge">'.esc_html__( 'Featured', 'exertio_theme' ).'</span> </div>';
										}

											$saved_service = get_user_meta(get_current_user_id(), '_service_fav_id_'.$sid, true);

											$active_saved ='';
											$save_text = esc_html__('Save Service','exertio_theme');
											if(isset($saved_service) && $saved_service != '')
											{
												$active_saved = 'active';
												$save_text = esc_html__('Already Saved','exertio_theme');
											}
										?>
										<div class="fr-top-rating"> <a href="javascript:void(0)" class="save_service protip <?php echo esc_attr($active_saved); ?>" data-fid="<?php echo esc_html($fl_id); ?>" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($save_text); ?>" data-post-id="<?php echo esc_attr($sid); ?>"><i class="fa fa-heart"></i></a> </div>
									  </div>
									  <div class="fr-top-details">
										<span class="rating"> <i class="fa fa-star"></i><?php echo get_service_rating($sid); ?></span>
										<a href="<?php echo esc_url(get_permalink()); ?>">
											<div class="fr-style-5"><?php echo esc_html(get_the_title()); ?></div>
										</a>
										<p><?php echo esc_html__('Starting From','exertio_theme'); ?><span class="style-6"><?php echo fl_price_separator(get_post_meta($sid, '_service_price', true), 'html'); ?></span></p>
										<div class="fr-top-grid">
											<a href="<?php  echo esc_url(get_permalink($fl_id)); ?>">
												<?php echo get_profile_img($fl_id, "freelancer"); ?>
											</a>
										</div>
									  </div>
									  <div class="fr-top-grid-bar"> <a href="javascript:void(0)">
										<p> <?php echo exertio_queued_services($sid); ?></p>
										</a> </div>
									</div>
								  </div>
							<?php
							}
							wp_reset_postdata();
							?>
                    </div>
            </div>
          </div>
        </div>
      </div>
    </section>
	<?php
	}
}
?>
