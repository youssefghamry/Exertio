<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();

$get_sid = $_GET['sid'];
	if( is_user_logged_in() )
	 {
		$buyer_id = get_user_meta( $current_user_id, 'employer_id' , true );
		global $wpdb;
		$table = EXERTIO_PURCHASED_SERVICES_TBL;

		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `id` = '" . $get_sid . "' AND `buyer_id` = '" . $buyer_id . "' AND `status` ='ongoing' ORDER BY timestamp DESC LIMIT 1";
			$result = $wpdb->get_results($query, ARRAY_A);
			$buyer_id_msg = isset($result[0]['buyer_id']) ? $result[0]['buyer_id'] : '';
			$seller_id_msg = isset($result[0]['seller_id']) ? $result[0]['seller_id']: '';
			$post_service_id = isset($result[0]['service_id']) ? $result[0]['service_id']: '';
			if($buyer_id_msg == $buyer_id)
			{
			?>
                <div class="content-wrapper">
                  <div class="notch"></div>
                  <div class="row">
                    <div class="col-md-12 grid-margin">
                      <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-end flex-wrap">
                          <div class="mr-md-3 mr-xl-5">
                            <h2><?php echo esc_html__('Ongoing Service Detail','exertio_theme');?></h2>
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
                                            $seller_id = $result[0]['seller_id'];
                                            $service = get_post($sid);

                                            ?>
                                              
                                            <div class="pro-box">
                                                <div class="pro-coulmn pro-title">
                                                    <?php
                                                        $service_img_id = get_post_meta( $sid, '_service_attachment_ids', true );
                                                        $atatchment_arr = explode( ',', $service_img_id );
                                                        foreach ($atatchment_arr as $value)
                                                        {
															if($value)
															{
																$icon = get_icon_for_attachment($value, 'thumbnail');
																?>
																<img src="<?php echo esc_url($icon); ?>" alt="<?php echo get_post_meta($value, '_wp_attachment_image_alt', TRUE); ?>">
																<?php
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
																	echo '<span>'.fl_price_separator($result[0]['total_price']).'</span><small> / '.$delivery_time->name.'</small>';
																}
                                                            ?>
                                                        </span>
                                                    </span>
                                                    
                                                </div>
                                                <div class="pro-coulmn buyer-detail">
                                                    <?php
                                                        echo get_profile_img($seller_id , 'freelancer');
                                                    ?>
                                                    <span class="buyer_name"><a href="<?php echo get_the_permalink($seller_id); ?>"><?php echo exertio_get_username('freelancer',$seller_id, 'badge', 'left')?></a></span>
                                                    <span class="service_start_date"> <?php echo esc_html__( 'Purchased on ', 'exertio_theme' ).' '.esc_html(date("F jS, Y", strtotime($result[0]['timestamp']))); ?></span>
                                                </div>
                                                <div class="pro-coulmn">
                                                    <form>                
                                                        <select class="form-control general_select_2 service_status">
                                                            <option value=""><?php echo esc_html__( 'Select status', 'exertio_theme' ); ?></option>
                                                            <option value="complete"><?php echo esc_html__( 'Complete', 'exertio_theme' ); ?></option>
                                                            <option value="cancel"><?php echo esc_html__( 'Cancel', 'exertio_theme' ); ?></option>
                                                        </select>
                                                        <button type="button" class="btn btn-theme btn-loading" id="service_status"><?php echo esc_html__( 'Update', 'exertio_theme' ); ?><div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button>
                                                    </form>
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
                                                $msg_author = get_user_meta( $current_user_id, 'employer_id' , true );
                                                if($msg_author == $message->msg_sender_id)
                                                {
                                                    ?>
                                                    <div class="chat-single-box">
                                                        <div class="chat-single chant-single-right">
                                                            <div class="history-user">
                                                                <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                                <a href="<?php echo get_the_permalink($message->msg_sender_id); ?>" class="history-username"><?php echo exertio_get_username('employer',$message->msg_sender_id, 'badge', 'left'); ?></a>
                                                                <span><?php echo get_profile_img($message->msg_sender_id, "employer"); ?></span>
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
                                                                    <?php echo get_profile_img($message->msg_sender_id, "freelancer"); ?>
                                                                </span>
                                                                <a href="<?php echo get_the_permalink($message->msg_sender_id); ?>" class="history-username"><?php echo exertio_get_username('freelancer',$message->msg_sender_id, 'badge', 'right'); ?></a>
                                                                <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                            </div>
                                                            <p class="history-text">
                                                                <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                            </p>
                                                            <?php
                                                            if($message->attachment_ids >0)
                                                            {
                                                                ?>
                                                                <div class="history_attch_dwld btn-loading" data-id="<?php echo esc_attr($message->attachment_ids); ?>">
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
                          <div class="history-msg-form">
                            <h3><?php echo esc_html__( 'Send Message', 'exertio_theme' ); ?></h3>
                            <div class="history-text">
                                <form id="send_service_msg">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <textarea name="history_msg_text" id="" class="form-control" required data-smk-msg="<?php echo esc_attr__('Please provide message to send','exertio_theme'); ?>" placeholder="<?php echo esc_attr__('Type your message here.....','exertio_theme'); ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <div class="upload-btn-wrapper">
                                                <button class="btn btn-theme-secondary mt-2 mt-xl-0" type="button"><?php echo esc_html__('Select Attachments','exertio_theme'); ?></button>
                                                <input type="file" id="gen_attachment_uploader" multiple name="project_attachments[]" accept = "image/pdf/doc/docx/ppt/pptx*" data-post-id="<?php echo esc_attr($get_sid) ?>"/>
                                                <input type="hidden" name="attachment_ids" value="" id="history_attachments_ids">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row" >
                                         <div class="form-group col-md-12 attachment-box"> 
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button type="button" class="btn btn-theme float-right btn-loading" id="service_history_msg_btn" data-post-id="<?php echo esc_attr($get_sid) ?>" data-sender-id="<?php echo esc_attr($buyer_id_msg); ?>" data-receiver-id="<?php echo esc_attr($seller_id_msg); ?>">
                                                <?php echo esc_html__('Send Message','exertio_theme'); ?>
                                                <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade review-modal" id="review-service" tabindex="-1" role="dialog" aria-labelledby="review-modal" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                      	<small><?php echo esc_html__('Provide Feedback to ','exertio_theme'); ?></small>
                        <h4 class="modal-title" id="review-modal"><?php echo exertio_get_username('freelancer',$seller_id_msg, 'badge', 'right'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true"><i class="fas fa-times"></i></i></span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="service_rating_form">
                            <div class="reviews-star-box">
                                <ul>
                                  <li>
                                    <p><?php if(isset($exertio_theme_options['service_first_title'])){ echo esc_html($exertio_theme_options['service_first_title']); } ?></p>
                                    <div class="review stars-1"></div>
                                    <div class="form-group">
                                    <input type="text" id="stars-1" name="stars_1" value=""  required data-smk-msg="<?php echo esc_attr__('This is required','exertio_theme'); ?>">
                                    </div>
                                  </li>
                                  <li>
                                    <p><?php if(isset($exertio_theme_options['service_second_title'])){ echo esc_html($exertio_theme_options['service_second_title']); } ?></p>
                                    <div class="review stars-2"></div>
                                    <div class="form-group">
                                    <input type="text" id="stars-2" name="stars_2"  required data-smk-msg="<?php echo esc_attr__('This is required','exertio_theme'); ?>">
                                    </div>
                                  </li>
                                  <li>
                                    <p><?php if(isset($exertio_theme_options['service_third_title'])){ echo esc_html($exertio_theme_options['service_third_title']); } ?></p>
                                    <div class="review stars-3"></div>
                                    <div class="form-group">
                                    <input type="text" id="stars-3" name="stars_3"  required data-smk-msg="<?php echo esc_attr__('This is required','exertio_theme'); ?>">
                                    </div>
                                  </li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label> <?php echo esc_html__('Feedback ','exertio_theme'); ?> </label>
                                <textarea class="form-control" name="feedback_text" rows="5" cols="10" required data-smk-msg="<?php echo esc_attr__('Please provide feedback','exertio_theme'); ?>"></textarea>
                            </div>
                            <div class="form-group"> <button type="button" id="service_rating_btn" class="btn btn-theme btn-loading" data-ongoing-sid="<?php echo esc_attr($ongoing_sid) ?>" data-service-sid="<?php echo esc_attr($post_service_id) ?>" data-status= "complete"><?php echo esc_html__('Complete & Submit','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!--CANCEL SERVICE MODAL-->
                <div class="modal fade review-modal" id="review-service-cancel" tabindex="-1" role="dialog" aria-labelledby="review-modal-cancel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                      	<small><?php echo esc_html__('Provide Reason to ','exertio_theme'); ?></small>
                        <h4 class="modal-title" id="review-modal-cancel"><?php echo esc_html__('Cancel Service','exertio_theme'); ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true"><i class="fas fa-times"></i></i></span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="cancel-service-from">
                            <div class="form-group">
                                <label> <?php echo esc_html__('Feedback ','exertio_theme'); ?> </label>
                                <textarea class="form-control" name="feedback_text" rows="5" cols="10" required data-smk-msg="<?php echo esc_attr__('Please provide reason','exertio_theme'); ?>"></textarea>
                                <p> <?php echo esc_html__('Provide information on why you are canceling this service.','exertio_theme'); ?></p>
                            </div>
                            <div class="form-group"> <button type="button" id="cancel-service-btn" class="btn btn-theme btn-loading" data-ongoing-sid="<?php echo esc_attr($ongoing_sid) ?>" data-service-sid="<?php echo esc_attr($post_service_id) ?>" data-status= "cancel"><?php echo esc_html__('Cancel this service','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
			<?php
			}
			else
			{
				get_template_part( 'template-parts/dashboard/layouts/dashboard');
			}
		}
	}
	else
	{
		echo exertio_redirect(home_url('/'));
	}
	?>