<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();

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
		$seller_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
		global $wpdb;
		$table = EXERTIO_PURCHASED_SERVICES_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `seller_id` = '" . $seller_id . "' AND `status` ='ongoing' ORDER BY timestamp DESC LIMIT ".$start_from.",".$limit."";
			$result = $wpdb->get_results($query);
		}
		?>
        <div class="content-wrapper">
          <div class="notch"></div>
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2><?php echo esc_html__('Ongoing Services','exertio_theme'); ?></h2>
                    <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
						<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
						<?php echo exertio_dashboard_extention_return(); ?>
					</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card services ongoing-services">
              <div class="card mb-4">
                <div class="card-body">
                  <div class="pro-section">
                      <div class="pro-box heading-row">
                        <div class="pro-coulmn pro-title">
                        </div>
                        <div class="pro-coulmn"><?php echo esc_html__( 'Ordered by', 'exertio_theme' ) ?> </div>
                        <div class="pro-coulmn"><?php echo esc_html__( 'Action', 'exertio_theme' ) ?> </div>
                      </div>
                        <?php
                            if ($result)
                            {
                                foreach( $result as $results ) 
                                {
                                    $ongoing_sid = $results->id;
									$sid = $results->service_id;
									$buyer_id = $results->buyer_id;
                                    $service = get_post($sid);
									$buyer_user_id = get_post_field( 'post_author', $buyer_id );
                                    ?>
                                    <div class="pro-box">
                                        <div class="pro-coulmn pro-title">
                                        	<?php
												$service_img_id = get_post_meta( $sid, '_service_attachment_ids', true );
												$atatchment_arr = explode( ',', $service_img_id );
												if($atatchment_arr)
												{
													foreach ($atatchment_arr as $value)
													{
														if($value)
														{
															$icon = get_icon_for_attachment($value, 'thumbnail');
															?>
															<img src="<?php echo esc_url($icon); ?>" alt="<?php echo get_post_meta($value, '_wp_attachment_image_alt', TRUE); ?>">
															<?php
														}
														break;
													}
												}
											?>
                                            <h4 class="pro-name">
                                                <a href="<?php  echo esc_url(get_permalink($service->ID)); ?>"><?php echo esc_html($service->post_title); ?></a>
                                            </h4>
                                            <span class="pro-meta-box">
                                                <span class="pro-meta-price">
                                                	<?php
														$delivery_time = get_term( get_post_meta($sid, '_delivery_time', true));
														if(!empty($delivery_time) && ! is_wp_error($delivery_time))
														{
															echo '<span>'.fl_price_separator($results->total_price).'</span><small> / '.$delivery_time->name.'</small>';
														}
													?>
                                                </span>
                                            </span>
                                            
                                        </div>
                                        <div class="pro-coulmn buyer-detail">
											<?php
                                                echo get_profile_img($buyer_id , 'employer');
                                            ?>
                                            <span class="buyer_name"> <?php echo exertio_get_username('employer',$buyer_id, 'badge', 'right' ); ?></span>
                                            <span class="service_start_date"> <?php echo esc_html__( 'Started on ', 'exertio_theme' ).' '. date_i18n( get_option( 'date_format' ), strtotime( esc_html($results->timestamp) ) ); ?></span>
                                        </div>
                                        <div class="pro-coulmn">
											<?php
												if( fl_framework_get_options('whizzchat_service_option') == true)
												{
													if(in_array('whizz-chat/whizz-chat.php', apply_filters('active_plugins', get_option('active_plugins'))))
													{
													?>
														<a href="javascript:void(0)" class="chat_toggler btn btn-theme" data-user_id="<?php echo esc_attr($buyer_user_id); ?>" data-page_id='<?php echo esc_attr($sid); ?>'>
															<i class="far fa-comment-alt"></i>
															<?php echo esc_html__( 'Start Chat', 'exertio_theme' ); ?>
														</a>
												<?php
													}
												}
												if( fl_framework_get_options('turn_services_messaging') == true)
												{
													?>
													<a href="?ext=ongoing-service-detail&sid=<?php echo esc_html($ongoing_sid); ?>" class="btn btn-theme-secondary"><?php echo esc_html__( 'View Detail', 'exertio_theme' ); ?></a>
													<?php
												}
											?>
                                        </div>
                                      </div>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <div class="nothing-found">
                                    <h3><?php echo esc_html__( 'Sorry!!! No Record Found', 'exertio_theme' ) ?></h3>
                                    <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo esc_attr__( 'Nothing found icon', 'exertio_theme' ) ?> ">
                                </div>
                                <?php	
                            }
                        echo pagination_ongoing_services($seller_id, $pageno, $limit, 'ongoing');
						?>
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
		echo exertio_redirect(home_url('/'));
	}
	?>