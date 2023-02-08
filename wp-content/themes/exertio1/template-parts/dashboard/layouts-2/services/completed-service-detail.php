<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();

$get_sid = $_GET['sid']; 


if( is_user_logged_in() )
 {
	$seller_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
	global $wpdb;
	$table = EXERTIO_PURCHASED_SERVICES_TBL;

	if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
	{
		$query = "SELECT * FROM ".$table." WHERE `id` = '" . $get_sid . "' AND `seller_id` = '" . $seller_id . "' AND `status` ='completed' ORDER BY timestamp DESC";

		$result = $wpdb->get_results($query, ARRAY_A );
	
		$buyer_id_msg = isset($result[0]['buyer_id']) ? $result[0]['buyer_id'] : '';
		$seller_id_msg = isset($result[0]['seller_id']) ? $result[0]['seller_id']: '';

		if($seller_id_msg == $seller_id)
		{
		?>
             <div class="content-wrapper">
              <div class="notch"></div>
              <div class="row">
                <div class="col-md-12 grid-margin">
                  <div class="d-flex justify-content-between flex-wrap">
                    <div class="d-flex align-items-end flex-wrap">
                      <div class="mr-md-3 mr-xl-5">
                        <h2><?php echo esc_html__('Completed Service Detail','exertio_theme');?></h2>
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
                <div class="col-md-12 grid-margin stretch-card services ongoing-services-details">
                  <div class="card mb-4">
                    <div class="card-body">
                      <div class="pro-section">
                            <?php
                                if ( $result )
                                {
									$ongoing_sid = $result[0]['id'];
									$sid = $result[0]['service_id'];
									$buyer_id = $result[0]['buyer_id'];
									$service = get_post($sid);
									?>
									<div class="pro-box">
										<div class="pro-coulmn pro-title">
											<?php
												$service_img_id = get_post_meta( $sid, '_service_attachment_ids', true );
												$atatchment_arr = explode( ',', $service_img_id );
												foreach ($atatchment_arr as $value)
												{
													$icon = get_icon_for_attachment($value, 'thumbnail');
											?>
													<img src="<?php echo esc_url($icon); ?>" alt="<?php echo get_post_meta($value, '_wp_attachment_image_alt', TRUE); ?>">
											<?php
													break;
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
															echo '<span>'.fl_price_separator($result[0]['total_price']).'</span><small> / '.$delivery_time->name.'</small>';
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
											<span class="service_start_date"> <?php echo esc_html__( 'Started on ', 'exertio_theme' ).' '.date_i18n( get_option( 'date_format' ), strtotime( esc_html($result[0]['timestamp']))); ?></span>
										</div>
										<div class="pro-coulmn completed-status">
											<i class="fas fa-check-circle"></i>
											<div>
												<span class=""> <?php echo esc_html__( 'Completed ', 'exertio_theme' ); ?> </span>
												<small> <?php echo esc_html__( 'on ', 'exertio_theme' ).date_i18n( get_option( 'date_format' ), strtotime( $result[0]['status_date'] ) ); ?> </small>
											</div>
										</div>
									</div>
									<?php
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
                            ?>
                      </div>
                      <!--PROJECT HISTORY-->
                      <div class="project-history">
                            <div class="history-body">
                                <div class="history-chat-body">
                                    <?php
                                    $messages = get_service_msg($get_sid);
                                    if($messages)
                                    {
                                        foreach($messages as $message)
                                        {
                                            $msg_author = get_user_meta( $current_user_id, 'freelancer_id' , true );
                                            if($msg_author == $message->msg_sender_id)
                                            {
                                                ?>
                                                <div class="chat-single-box">
                                                    <div class="chat-single chant-single-right">
                                                        <div class="history-user">
                                                            <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                            <a href="#" class="history-username"><?php echo exertio_get_username('freelancer',$message->msg_sender_id, 'badge', 'right'); ?></a>
                                                            <span><?php echo get_profile_img($message->msg_sender_id, "freelancer"); ?></span>
                                                        </div>
                                                        <p class="history-text">
                                                            <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                        </p>
                                                        <?php
                                                        if($message->attachment_ids >0)
                                                        {
                                                            ?>
                                                            <div class="history_attch_dwld btn-loading" id="download-files" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
                                                                <i class="fas fa-arrow-down"></i>
                                                                <?php echo esc_html__( 'Attachments', 'exertio_theme' ); ?>
                                                                <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                                            </div>
                                                            <?php
                                                         }
                                                         ?>
                                                    </div>
                                                </div>
                                                <?php	
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="chat-single-box">
                                                    <div class="chat-single success">
                                                        <div class="history-user">
                                                            <span>
                                                                <?php echo get_profile_img($message->msg_sender_id, "employer"); ?>
                                                            </span>
                                                            <a href="#" class="history-username"><?php echo exertio_get_username('employer',$message->msg_sender_id, 'badge', 'right' ); ?></a>
                                                            <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                        </div>
                                                        <p class="history-text">
                                                            <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                        </p>
                                                        <?php
                                                        if($message->attachment_ids >0)
                                                        {
                                                            ?>
                                                            <div class="history_attch_dwld btn-loading" id="download-files" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
                                                                <i class="fas fa-arrow-down"></i>
                                                                <?php echo esc_html__( 'Attachments', 'exertio_theme' ); ?>
                                                                <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                                            </div>
                                                            <?php
                                                         }
                                                         ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <p class="text-center"><?php echo esc_html__( 'No history found', 'exertio_theme' ); ?></p>
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
            </div>
		<?php
		}
		else
		{
			get_template_part( 'template-parts/dashboard/layouts-2/dashboard');
		}
	}
}
else
{
	echo exertio_redirect(home_url('/'));
}
?>