<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();
$dispute_id = $_GET['dispute-id'];
$fl_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
$msg_author = get_user_meta( $current_user_id, 'employer_id' , true );
$alt_id = '';
	if( is_user_logged_in() )
	 {
		if(isset($dispute_id))
		{
			$the_query = get_post($dispute_id);
			$pid = $the_query->ID;
			$status = get_post_meta($pid,'_dispute_status',true);
			$dispute_owner = get_post_field( 'post_author', $pid );
			$other_user_id1 = get_post_meta($pid, '_dispute_against_user_id', true);
			$none_author_id = get_post_field( 'post_author', $other_user_id1 );
			if($dispute_owner == $current_user_id || $none_author_id == $current_user_id)
			{
			?>
				<div class="content-wrapper ">
				  <div class="notch"></div>
				  <div class="row">
					<div class="col-md-12 grid-margin">
					  <div class="d-flex justify-content-between flex-wrap">
						<div class="d-flex align-items-end flex-wrap">
						  <div class="mr-md-3 mr-xl-5">
							<h2><?php echo esc_html__('Dispute Details','exertio_theme');?></h2>
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
                    <div class="col-xl-7 col-lg-12 col-md-12 grid-margin stretch-card">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="project-history">
                                    <h3><?php echo esc_html__( 'Dispute History', 'exertio_theme' ); ?></h3>
                                    <div class="history-body">
                                        <div class="history-chat-body">
                                            <?php
                                            $project_id = get_post_meta($dispute_id,'_project_id', true);
                                            $service_id = get_post_meta($dispute_id,'_service_id', true);
                                            if ($project_id != '') {
                                                $messages = exertio_get_dispute_msgs($dispute_id);
                                            }
                                            if ($service_id != '') {
                                                $messages = exertio_get_services_dispute_msgs($dispute_id);
                                            }
                                            if($messages)
                                            {
                                                foreach($messages as $message)
                                                {
                                                    $msg_author = get_user_meta( $current_user_id, 'employer_id' , true );
                                                    if ($project_id != '') {
                                                        $project_owner = get_post_field('post_author', $project_id);
                                                        if ($project_owner == $current_user_id) {
                                                            $msg_author_name = exertio_get_username('employer', $message->msg_author_id);
                                                            $msg_receiver_name = exertio_get_username('freelancer', $message->msg_receiver_id);

                                                            $msg_author_pic = get_profile_img($message->msg_author_id, "employer");
                                                            $msg_receiver_pic = get_profile_img($message->msg_receiver_id, "freelancer");
                                                        } else {
                                                            $msg_author_name = exertio_get_username('freelancer', $message->msg_receiver_id);
                                                            $msg_receiver_name = exertio_get_username('employer', $message->msg_author_id);

                                                            $msg_author_pic = get_profile_img($message->msg_receiver_id, "freelancer");
                                                            $msg_receiver_pic = get_profile_img($message->msg_author_id, "employer");
                                                        }
                                                    }else{
                                                        $project_owner = get_post_field('post_author', $service_id);
                                                        if ($project_owner == $current_user_id) {
                                                            $msg_author_name = exertio_get_username('employer', $message->msg_author_id);
                                                            $msg_receiver_name = exertio_get_username('freelancer', $message->msg_receiver_id);

                                                            $msg_author_pic = get_profile_img($message->msg_author_id, "employer");
                                                            $msg_receiver_pic = get_profile_img($message->msg_receiver_id, "freelancer");
                                                        } else {
                                                            $msg_author_name = exertio_get_username('freelancer', $message->msg_receiver_id);
                                                            $msg_receiver_name = exertio_get_username('employer', $message->msg_author_id);

                                                            $msg_author_pic = get_profile_img($message->msg_receiver_id, "freelancer");
                                                            $msg_receiver_pic = get_profile_img($message->msg_author_id, "employer");
                                                        }
                                                    }
                                                    if($msg_author == $message->msg_author_id)
                                                    {
                                                        ?>
                                                        <div class="chat-single-box">
                                                            <div class="chat-single chant-single-right">
                                                                <div class="history-user">
                                                                    <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                                    <a href="#" class="history-username"><?php echo wp_return_echo($msg_author_name); ?></a>
                                                                    <span><?php echo wp_return_echo($msg_author_pic); ?></span>
                                                                </div>
                                                                <p class="history-text">
                                                                    <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                                </p>
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
                                                                        <?php echo wp_return_echo($msg_receiver_pic); ?>
                                                                    </span>
                                                                    <a href="#" class="history-username"><?php echo wp_return_echo($msg_receiver_name); ?></a>
                                                                    <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                                </div>
                                                                <p class="history-text">
                                                                    <?php echo esc_html(wp_strip_all_tags($message->message)); ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                <p class="text-center"><?php echo esc_html__( 'No messgae found', 'exertio_theme' ); ?></p>
                                                <?php	
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
								if($status != 'resolved')
								{
								?>
                                <div class="history-msg-form">
                                    <h3><?php echo esc_html__( 'Send Message', 'exertio_theme' ); ?></h3>
                                    <div class="history-text">
                                        <?php
                                        $project_id = get_post_meta($dispute_id,'_project_id', true);
                                        if($project_id != ""){
                                            ?>
                                            <form id="send_himstory_msg">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <textarea name="dispute_msg_text" id="" class="form-control" placeholder="<?php echo esc_attr__('Write your message here....','exertio_theme'); ?>" required data-smk-msg="<?php echo esc_attr__('Please provide message to send','exertio_theme'); ?>"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <button type="button" class="btn btn-theme float-right btn-loading" id="dispute_msg_btn" data-post-id="<?php echo esc_attr($dispute_id) ?>" data-fl-id="<?php echo esc_attr($fl_id) ?>" data-msg-author="<?php echo esc_attr($msg_author) ?>">
                                                            <?php echo esc_html__('Send Message','exertio_theme'); ?>
                                                            <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php }else{ ?>
                                            <form id="send_himstory_service_msg">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <textarea name="dispute_msg_text" id="" class="form-control" placeholder="<?php echo esc_attr__('Write your message here....','exertio_theme'); ?>" required data-smk-msg="<?php echo esc_attr__('Please provide message to send','exertio_theme'); ?>"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <button type="button" class="btn btn-theme float-right btn-loading" id="dispute_service_msg_btn" data-post-id="<?php echo esc_attr($dispute_id) ?>" data-fl-id="<?php echo esc_attr($fl_id) ?>" data-msg-author="<?php echo esc_attr($msg_author) ?>">
                                                            <?php echo esc_html__('Send Message','exertio_theme'); ?>
                                                            <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php
								}
								?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-12 col-md-12 grid-margin stretch-card">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="dispute-box">
                                <?php
                                		$project_id = get_post_meta($pid,'_project_id', true);
                                        $service_id = get_post_meta($pid,'_service_id', true);
                            if ($project_id != '') {
										$freelancer_id = get_post_meta($project_id, '_freelancer_assigned', true);
										//$posted_date =  date_i18n( get_option( 'date_format' ), strtotime( get_the_time($pid) ) );
										$posted_date =  get_the_time(get_option('date_format'), $pid);
										
										//$dispute_owner = get_post_field( 'post_author', $pid );
										$other_user_id = '';
										if($dispute_owner == $current_user_id)
										{
											$other_user_id = get_post_meta($pid, '_dispute_against_user_id', true);
										}
										else
										{
											$other_user_id = get_post_meta($pid, '_dispute_creater_user_id', true);
										}
                                ?>
                                <h5>
                                    <a href="<?php  echo esc_url(get_permalink($project_id)); ?>"><?php echo esc_html(get_the_title($project_id)).' ('.exertio_get_username('freelancer',$other_user_id).')'; ?></a>
                                </h5>
                                <?php
                            }else{

                                $freelancer_id = get_post_meta($service_id, '_freelancer_assigned', true);
                                //$posted_date =  date_i18n( get_option( 'date_format' ), strtotime( get_the_time($pid) ) );
                                $posted_date =  get_the_time(get_option('date_format'), $pid);

                                //$dispute_owner = get_post_field( 'post_author', $pid );
                                $other_user_id = '';
                                if($dispute_owner == $current_user_id)
                                {
                                    $other_user_id = get_post_meta($pid, '_dispute_against_user_id', true);
                                }
                                else
                                {
                                    $other_user_id = get_post_meta($pid, '_dispute_creater_user_id', true);
                                } ?>
                                <h5>
                                    <a href="<?php  echo esc_url(get_permalink($service_id)); ?>"><?php echo esc_html(get_the_title($service_id)).' ('.exertio_get_username('freelancer',$other_user_id).')'; ?></a>
                                </h5>
                            <?php }
										?>

										<h3>
											<?php echo esc_html(get_the_title($pid)); ?>
											(<?php
                                            if ($project_id != '') {
												$type = get_post_meta($project_id, '_project_type', true);
												if($type == 'fixed' || $type == 1)
												{
													$type_text = esc_html__('Fixed','exertio_theme');
													echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)).'/'.$type_text);
												}
												else if($type == 'hourly' || $type == 2)
												{
													$type_text = esc_html__('Hourly','exertio_theme');
													echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)).' '.$type_text);
												}
                                            }else{
                                                    $current_user_id = get_current_user_id();
                                                    $buyer_id = get_user_meta( $current_user_id, 'employer_id' , true );
                                                global $wpdb;
                                                $table = EXERTIO_PURCHASED_SERVICES_TBL;
                                                $query = "SELECT * FROM ".$table." WHERE `service_id` = '" . $service_id . "' ORDER BY timestamp DESC";
                                                $result = $wpdb->get_results($query, ARRAY_A );
                                                    foreach( $result as $results )
                                                    {
                                                        $total_price = $results['total_price'] ? $results['total_price'] : '';
                                                    }
                                                    echo fl_price_separator($total_price);
                                                }
											 ?>)
										</h3>
                                        <div class="dispute-box-meta">
                                            <span class="date"><?php echo esc_html($posted_date); ?></span>
                                            <p><?php echo esc_html($the_query->post_content); ?></p>
                                            <?php
                                            $badge_color ='';
                                            
                                            if( $status == 'ongoing') { $badge_color = 'btn-inverse-warning';}
                                            else if($status == 'resolved'){ $badge_color = 'btn-inverse-success';}
                                            ?>
                                            <span class="badge btn <?php echo esc_html($badge_color); ?>">
                                                <?php echo esc_html($status); ?>
                                            </span>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="dispute-box1">
									<h3><?php echo esc_html__( ' Admin Response', 'exertio_theme' ); ?></h3>
                                    <p>
                                    	<?php 
										$admin_feedback ='';
										$admin_feedback = get_post_meta($dispute_id, '_admin_feedback', true);
										if(isset($admin_feedback))
										{
											echo esc_html($admin_feedback);
										}
										else
										{
											echo esc_html__( 'No Responce yet.', 'exertio_theme' ); 
										}
										?>
                                    </p>
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
		}
		else
		{
			get_template_part( 'template-parts/dashboard/layouts/dashboard');
		}
	}
	else
	{
		echo exertio_redirect(home_url('/'));
	?>
	<?php
	}
	?>