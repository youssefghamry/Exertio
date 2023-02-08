<?php // Register post  type and taxonomy
add_action('init', 'fl_dispute_themes_custom_types', 0);
function fl_dispute_themes_custom_types() {
	 $args = array(
			'public' => true,
			'labels' => array(
							'name' => __('Disputes', 'exertio_framework'),
							'singular_name' => __('Disputes', 'exertio_framework'),
							'menu_name' => __('Disputes', 'exertio_framework'),
							'name_admin_bar' => __('Disputes', 'exertio_framework'),
							'add_new' => __('Add New Dispute', 'exertio_framework'),
							'add_new_item' => __('Add New Dispute', 'exertio_framework'),
							'new_item' => __('New Disputes', 'exertio_framework'),
							'edit_item' => __('Edit Disputes', 'exertio_framework'),
							'view_item' => __('View Disputes', 'exertio_framework'),
							'all_items' => __('All Disputes', 'exertio_framework'),
							'search_items' => __('Search Disputes', 'exertio_framework'),
							'not_found' => __('No Dispute Found.', 'exertio_framework'),
							),
			'supports' => array('title', 'editor'),
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => true,
			'has_archive' => true,
			'menu_icon'           => FL_PLUGIN_URL.'/images/law.png',
			'rewrite' => array('with_front' => false, 'slug' => 'disputes'),
			'capabilities' => array(
				'create_posts' => false,
			),
			'map_meta_cap' => true,
		);
	register_post_type('disputes', $args);


	add_filter('manage_edit-disputes_columns', 'disputes_columns_id');
    add_action('manage_disputes_posts_custom_column', 'disputes_custom_columns', 5, 2);
 
 
	function disputes_columns_id($defaults){
		unset($defaults['date']);

		$defaults['project_name'] =  __('Project/Service Name', 'exertio_framework');
		$defaults['price'] =  __('Price', 'exertio_framework');
		$defaults['author'] =  __('Author', 'exertio_framework');
		$defaults['date'] =  __('Date', 'exertio_framework');

		return $defaults;
		
	}
	function disputes_custom_columns($column_name, $id){
		$project_id = get_post_meta( $id, '_project_id', true );
        $service_id = get_post_meta( $id, '_service_id', true );
        if ($project_id != '') {
            if ($column_name === 'project_name') {
                echo '<a href="' . get_the_permalink($project_id) . '">' . get_the_title($project_id) . '</a>';
            }
            if ($column_name === 'price') {
                $type_text = '';
                $type = get_post_meta($project_id, '_project_type', true);
                if ($type == 'fixed' || $type == 1) {
                    $type_text = esc_html__('Fixed: ', 'exertio_framework');
                    echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)) . '/' . $type_text);
                } else if ($type == 'hourly' || $type == 2) {
                    $type_text = esc_html__('Hourly: ', 'exertio_framework');
                    echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)) . ' ' . $type_text);
                }
            }
        }else{
            if ($column_name === 'project_name') {
                echo '<a href="' . get_the_permalink($service_id) . '">' . get_the_title($service_id) . '</a>';
            }
            if ($column_name === 'price') {
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
        }
	}


	add_action( 'load-post.php', 'disputes_post_meta_boxes_setup' );
	add_action( 'load-post-new.php', 'disputes_post_meta_boxes_setup' );
	
	
	function disputes_post_meta_boxes_setup() {
	
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', 'disputes_add_post_meta_boxes' );
	  
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', 'disputes_save_post_class_meta', 10, 2 );
	  
	}
	
	/* Create one or more meta boxes to be displayed on the post editor screen. */
	function disputes_add_post_meta_boxes() {
	
	  add_meta_box(
		'dispute-post-class',      // Unique ID
		esc_html__( 'Add Disputes Detail', 'exertio_framework' ),    // Title
		'disputes_post_class_meta_box',   // Callback function
		'disputes',
		'normal',         // Context
		'default'         // Priority
	  );
	}
	
	function disputes_post_class_meta_box( $post ) { ?>
		
	  <?php wp_nonce_field( basename( __FILE__ ), 'disputes_post_class_nonce' ); 
		$post_id =  $post->ID;
		?>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Project/Service Price", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php

				$type_text = '';
				$project_id = get_post_meta( $post_id, '_project_id', true );
                $service_id = get_post_meta( $post_id, '_service_id', true );
                if ($project_id != '') {
                    $type = get_post_meta($project_id, '_project_type', true);
                    if ($type == 'fixed' || $type == 1) {
                        $type_text = esc_html__('Fixed: ', 'exertio_framework');
                        echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)) . '/' . $type_text);
                    } else if ($type == 'hourly' || $type == 2) {
                        $type_text = esc_html__('Hourly ', 'exertio_framework');
                        echo esc_html(fl_price_separator(get_post_meta($project_id, '_project_cost', true)) . ' ' . $type_text);
                        echo '<small class="estimated-hours">' . esc_html__('Estimated Hours ', 'exertio_framework') . get_post_meta($project_id, '_estimated_hours', true) . '</small>';
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
			?>
            </div>
        </div> 
        
        
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Project/Service", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
                <?php if ($project_id != '') { ?>
                    <a href="<?php  echo esc_url(get_permalink($project_id)); ?>"><?php echo esc_html(get_the_title($project_id)); ?></a>
            <?php }else { ?>
                    <a href="<?php  echo esc_url(get_permalink($service_id)); ?>"><?php echo esc_html(get_the_title($service_id)); ?></a>
                <?php }?>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Dispute Status", 'exertio_framework' ); ?></label></div>
            <div class="col-3">
            <?php
				$badge_color ='';
				$status = get_post_meta($post_id,'_dispute_status',true);
				if( $status == 'ongoing') { $badge_color = 'btn-inverse-warning';}
				else if($status == 'resolved'){ $badge_color = 'btn-inverse-success';}
			?>
            <span class="badge btn <?php echo esc_html($badge_color); ?>">
				<?php echo esc_html($status); ?>
            </span>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Dispute Conversation", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
            	<div class="project-history">
                    <div class="history-body">
                        <div class="history-chat-body">
                            <?php
                            $project_id = get_post_meta($post_id,'_project_id', true);
                            $service_id = get_post_meta($post_id,'_service_id', true);
                            if ($project_id != '') {
                                $messages = exertio_get_dispute_msgs($post_id);
                            }
                            if ($service_id != '') {
                                $messages = exertio_get_services_dispute_msgs($post_id);
                            }
                            if($messages)
                            {
                                foreach($messages as $message)
                                {
                                    //$msg_author = get_user_meta( $current_user_id, 'employer_id' , true );
									$dispute_author = get_post_field( 'post_author', $post_id );
									$msg_author = get_user_meta( $dispute_author, 'employer_id' , true );
                                    
                                    $project_id = get_post_meta($post_id,'_project_id', true);
                                    $service_id = get_post_meta( $post_id, '_service_id', true );
                                    if ($project_id != '') {
                                        $project_owner = get_post_field('post_author', $project_id);
                                    }else{
                                        $project_owner = get_post_field('post_author', $service_id);
                                    }
                                    if($project_owner == $dispute_author)
                                    {
										
                                        $msg_author_name = exertio_get_username('employer',$message->msg_author_id);
										$msg_receiver_name = exertio_get_username('freelancer',$message->msg_receiver_id);
                                        
                                        $msg_author_pic = get_profile_img($message->msg_author_id, "employer");
                                        $msg_receiver_pic = get_profile_img($msg_author, "freelancer");
                                        
                                    }
                                    else
                                    {
										$msg_author_name = exertio_get_username('freelancer',$message->msg_receiver_id);
										$msg_receiver_name = exertio_get_username('employer',$message->msg_author_id);
                                        
                                        $msg_author_pic = get_profile_img($msg_author, "freelancer");
                                        $msg_receiver_pic = get_profile_img($message->msg_author_id, "employer");
                                    }
                                    if($msg_author == $message->msg_author_id)
                                    {
                                        ?>
                                        <div class="chat-single-box">
                                            <div class="chat-single chant-single-right">
                                                <div class="history-user">
                                                    <span class="history-datetime"><?php echo time_ago_function($message->timestamp); ?></span>
                                                    <a href="#" class="history-username"><?php echo $msg_author_name; ?></a>
                                                    <span><?php echo $msg_author_pic; ?></span>
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
                                                        <?php echo $msg_receiver_pic; ?>
                                                    </span>
                                                    <a href="#" class="history-username"><?php echo $msg_receiver_name; ?></a>
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
                                <p class="text-center"><?php echo esc_html__( 'No messgae found', 'exertio_framework' ); ?></p>
                                <?php	
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Admin Response", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
            	<?php 
					$admin_feedback ='';
					$admin_feedback = get_post_meta($post_id, '_admin_feedback', true);
				?>
            	<textarea name="admin_feedback" rows="8" ><?php echo $admin_feedback; ?></textarea>
            <p><?php echo __( "This will be visible to both users on their dispute detail page", "exertio_framework" ); ?></p>
            </div>
        </div>
		<div class="custom-row">
            <div class="col-3"><label><?php echo __( "Select Dispute winner", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
            	<?php 
					$dispute_winner ='';
					$disabled ='';
					$dispute_winner = get_post_meta($post_id, '_dispute_winner', true);
					
					if(isset($dispute_winner) && $dispute_winner != '')
					{
						$disabled = "disabled='disabled'";
					}

                    if ($project_id != '') {
                        $p_owner = get_post_field( 'post_author', $project_id );
                        $emp_id = get_user_meta($p_owner, 'employer_id', true);
                        $p_owner_name = exertio_get_username('employer', $emp_id);

                        $freelancer_id = get_post_meta($project_id, '_freelancer_assigned', true);
                        $freelancer_user_id = get_post_field('post_author', $freelancer_id);
                        $free_name = exertio_get_username('freelancer', $freelancer_id);
                    }else{
                        $p_owner = get_post_field( 'post_author', $service_id );
                        $emp_id = get_user_meta($p_owner, 'employer_id', true);
                        $p_owner_name = exertio_get_username('employer', $emp_id);

                        $freelancer_id = get_post_meta($service_id, '_freelancer_assigned', true);
                        $freelancer_user_id = get_post_field('post_author', $freelancer_id);
                        $free_name = exertio_get_username('freelancer', $freelancer_id);
                    }
				?>
				<select name="dispute_winner" <?php echo esc_attr($disabled); ?></selec>>
					<option value=""><?php echo __( " Select user", 'exertio_framework' ); ?></option>
					<option value="<?php echo esc_attr($p_owner); ?>" <?php if($dispute_winner == $p_owner) { echo 'selected="selected"'; } ?></optio><?php echo esc_html($p_owner_name).__( " (Employer)", 'exertio_framework' ); ?></option>
					<option value="<?php echo esc_attr($freelancer_user_id); ?>" <?php if($dispute_winner == $freelancer_user_id) { echo 'disabled="disabled"'; } ?></optio><?php echo esc_html($free_name).__( " (Freelancer)", 'exertio_framework' ); ?></option>
				</select>
                <p><?php echo __( "The disputed amount will be transferred to the selected user.", "exertio_framework" ); ?></p>
            </div>
        </div>
        <div class="custom-row">
            <div class="col-3"><label><?php echo __( "Mark Dispute as resolved", 'exertio_framework' ); ?></label></div>
            <div class="col-9">
            	<?php 
					$dispute_status ='';
					$checked ='';
					$dispute_status = get_post_meta($post_id, '_dispute_status', true);
					
					if(isset($dispute_status) && $dispute_status == 'resolved')
					{
						$checked =" checked='checked'";
						$disabled = "disabled='disabled'";
					}
				?>
            	<input type="checkbox" name="dispute_status" <?php echo esc_attr($checked); ?> <?php echo esc_attr($disabled); ?> >
                <p><?php echo __( "Check this to mark it resolved", "exertio_framework" ); ?></p>
            </div>
        </div>
        
    <?php }

	
	/* Save the meta box's post metadata. */
	function disputes_save_post_class_meta( $post_id, $post ) {
	
	  /* Verify the nonce before proceeding. */
	  if ( !isset( $_POST['disputes_post_class_nonce'] ) || !wp_verify_nonce( $_POST['disputes_post_class_nonce'], basename( __FILE__ ) ) )
		return $post_id;
	
	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
		if(isset($_POST['dispute_status']))
		{
			update_post_meta($post_id,'_dispute_status','resolved');
			
			/*NOTIFICATION*/
			
			$dispute_against_id = get_post_meta( $post_id, '_dispute_against_user_id', true ); 
			$dispute_against_use_id = get_post_field( 'post_author', $dispute_against_id );
			do_action( 'exertio_notification_filter',array('post_id'=> $post_id,'n_type'=>'dispute_action','sender_id'=>'admin','receiver_id'=>$dispute_against_use_id, 'sender_type'=> 'admin') );
			
			$_dispute_creater_id = get_post_meta( $post_id, '_dispute_creater_user_id', true ); 
			$_dispute_creater_user_id = get_post_field( 'post_author', $_dispute_creater_id );
			do_action( 'exertio_notification_filter',array('post_id'=> $post_id,'n_type'=>'dispute_action','sender_id'=>'admin','receiver_id'=>$_dispute_creater_user_id, 'sender_type'=> 'admin') );
		}
		else
		{
			update_post_meta($post_id,'_dispute_status','ongoing');	
		}
		if(isset($_POST['admin_feedback']))
		{
			update_post_meta( $post_id, '_admin_feedback', $_POST['admin_feedback']);
		}
		if(isset($_POST['dispute_winner']) && $_POST['dispute_winner'] !='')
		{
			update_post_meta( $post_id, '_dispute_winner', $_POST['dispute_winner']);
            $project_id = get_post_meta($post_id,'_project_id', true);
            $service_id = get_post_meta( $post_id, '_service_id', true );
            if ($project_id != '') {
                $pid = get_post_meta($post_id, '_project_id', true);
                $project_owner = get_post_field('post_author', $pid);
            }else{
                $sid = get_post_meta($post_id, '_service_id', true);
                $project_owner = get_post_field('post_author', $sid);
            }
			
			$type = get_post_meta($pid, '_project_type', true);
			
			$cost = 0;
            if ($project_id != '') {
                if($type == 'fixed' || $type == 1)
                {
                    $cost = get_post_meta($pid, '_project_cost', true);
                }
                else if($type == 'hourly' || $type == 2)
                {
                    $price = get_post_meta($pid, '_project_cost', true);
                    $hours = get_post_meta($pid, '_estimated_hours', true);
                    if(isset($price) && isset($hours))
                    {
                        $cost = $price*$hours;
                    }
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
                $cost = $total_price;
//                $cost = $results->total_price;
            }
			
			if($project_owner == $_POST['dispute_winner'])
			{
				$admin_commission_percent = fl_framework_get_options('project_charges');
				
				$ex_amount = get_user_meta( $_POST['dispute_winner'], '_fl_wallet_amount', true );
				$new_wallet_amount = (int)$ex_amount + (int)$cost;
				update_user_meta($_POST['dispute_winner'], '_fl_wallet_amount',$new_wallet_amount);
				/*STATEMENT HOOK*/
				do_action( 'exertio_transection_action',array('post_id'=> $post_id,'price'=>$cost,'t_type'=>'dispute_refund','t_status'=>'1', 'user_id'=> $_POST['dispute_winner']));
				
				$stored_milestone_data = get_post_meta($pid,'_project_milestone_data', true);
				if(empty($stored_milestone_data))
				{
					$current_status = get_post_status ( $pid );
					if($current_status == 'completed')
					{
						$freelancer_assigned = get_post_meta($pid,'_freelancer_assigned', true);
						$freelancer_assigned_id = get_post_field( 'post_author', $freelancer_assigned );

						$freelancer_ex_amount = get_user_meta( $freelancer_assigned_id, '_fl_wallet_amount', true );

						
						$decimal_amount = $admin_commission_percent/100;
						$admin_commission = $decimal_amount*$cost;
						$freelancer_earning = $cost - $admin_commission;

						$new_wallet_amount = $freelancer_ex_amount-$freelancer_earning;
						update_user_meta($freelancer_assigned_id, '_fl_wallet_amount',$new_wallet_amount);

						do_action( 'exertio_transection_action',array('post_id'=> $post_id,'price'=>$freelancer_earning,'t_type'=>'dispute_refund','t_status'=>'2', 'user_id'=> $freelancer_assigned_id));
					}
				}
				else
				{
					$grand_total = '';
					$total_amount_milestone = 0;
					
					foreach($stored_milestone_data as $milestone_data)
					{
						$total_amount_milestone = $total_amount_milestone + $milestone_data['milestone_amount_paid'];
					}
					$freelancer_assigned = get_post_meta($pid,'_freelancer_assigned', true);
					$freelancer_assigned_id = get_post_field( 'post_author', $freelancer_assigned );

					$freelancer_ex_amount = get_user_meta( $freelancer_assigned_id, '_fl_wallet_amount', true );
					

					$decimal_amount = $admin_commission_percent/100;
					$admin_commission = $decimal_amount*$total_amount_milestone;
					$freelancer_earning = $total_amount_milestone - $admin_commission;

					$new_wallet_amount = $freelancer_ex_amount-$freelancer_earning;
					update_user_meta($freelancer_assigned_id, '_fl_wallet_amount',$new_wallet_amount);
					
					do_action( 'exertio_transection_action',array('post_id'=> $post_id,'price'=>$freelancer_earning,'t_type'=>'dispute_refund','t_status'=>'2', 'user_id'=> $freelancer_assigned_id));
				}
			}
			else
			{
				$p_status = get_post_status($pid);
				if(isset($p_status) && $p_status != 'completed')
				{
					$stored_milestone_data = get_post_meta($pid,'_project_milestone_data', true);
					if(empty($stored_milestone_data))
					{
						$admin_commission_percent = fl_framework_get_options('project_charges');
						$decimal_amount = $admin_commission_percent/100;
						$admin_commission = $decimal_amount*$cost;
						$freelancer_earning = $cost - $admin_commission;
						$ex_amount = get_user_meta( $_POST['dispute_winner'], '_fl_wallet_amount', true );
						$new_wallet_amount = $ex_amount+$freelancer_earning;
						update_user_meta($_POST['dispute_winner'], '_fl_wallet_amount',$new_wallet_amount);
					}
					else
					{
					$total_amount_milestone = 0;
					
					foreach($stored_milestone_data as $milestone_data)
					{
						$total_amount_milestone = $total_amount_milestone + $milestone_data['milestone_amount_paid'];
					}
					/*$freelancer_assigned = get_post_meta($pid,'_freelancer_assigned', true);
					$freelancer_assigned_id = get_post_field( 'post_author', $freelancer_assigned );*/

					$freelancer_ex_amount = get_user_meta( $_POST['dispute_winner'], '_fl_wallet_amount', true );

                    $admin_commission_percent = fl_framework_get_options('project_charges');
					$decimal_amount = $admin_commission_percent/100;
					$admin_commission = $decimal_amount*$total_amount_milestone;
					$freelancer_earning = $total_amount_milestone - $admin_commission;

					$new_wallet_amount = $freelancer_ex_amount+$freelancer_earning;
					update_user_meta($_POST['dispute_winner'], '_fl_wallet_amount',$new_wallet_amount);
					
					do_action( 'exertio_transection_action',array('post_id'=> $post_id,'price'=>$freelancer_earning,'t_type'=>'dispute_refund','t_status'=>'1', 'user_id'=> $_POST['dispute_winner']));
				}
				}

			}
		}
	}
}