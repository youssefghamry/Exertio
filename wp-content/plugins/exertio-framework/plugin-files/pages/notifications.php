<?php
function exertio_store_notifications_callback( $arg_array = array() ) {
	global $exertio_theme_options;
	if(isset($exertio_theme_options['exertio_notifications']) && $exertio_theme_options['exertio_notifications'] == true)
	{
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		$current_time = current_time('mysql');
		$data = array(
				'timestamp' => $current_time,
				'updated_on' => $current_time,
				'post_id' => $arg_array['post_id'],
				'n_type' => $arg_array['n_type'],
				'sender_id' => $arg_array['sender_id'],
				'receiver_id' => $arg_array['receiver_id'],
				'sender_type' => $arg_array['sender_type'],
				'status' => 1,
				);
		$wpdb->insert($table,$data);
	}
}
add_action( 'exertio_notification_filter', 'exertio_store_notifications_callback', 10 );

if ( ! function_exists( 'exertio_get_notifications' ) ) 
{
	function exertio_get_notifications($uid)
	{
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $uid . "' ORDER BY  `timestamp` DESC LIMIT 10";
			$result = $wpdb->get_results($query);
			if($result)
			{
				$result_html = '<ul class="notifications">';
				foreach($result as $results)
				{
					$status_class = $n_sender_name = '';
					if($results->sender_type == 'employer')
					{
						$employer_id = get_user_meta( $results->sender_id, 'employer_id' , true );
						$n_sender_name = exertio_get_username('employer', $employer_id);
					}
					else if($results->sender_type == 'freelancer')
					{
						$freelancer_id = get_user_meta( $results->sender_id, 'freelancer_id' , true );
						$n_sender_name = exertio_get_username('freelancer', $freelancer_id);
					}
					if($results->status == 1)
					{
						$status_class = 'active';
					}
					
					$n_type = $results->n_type;
					$result_html .= '<li>';
					if($n_type == 'proposal')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"> <span>'.$n_sender_name.'</span> '.__( ' sent a proposal on your job ', 'exertio_framework' ).'<span> '.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_expired')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired.', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_featured_expired')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired from featured list.', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_assigned')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'">'.__( 'Congratulations! you got a new project ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_completed')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'">'.__( 'Your project ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span> '.__( ' has been completed', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_rating')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'">'.__( 'Your got a new rating on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_canceled')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'">'.__( 'Your project ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span> '.__( ' has been canceled', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_msg')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span>'.$n_sender_name.'</span>'.__( ' sent a message on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'project_dispute')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span>'.$n_sender_name.'</span>'.__( ' created a dispute against the job ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
                    if($n_type == 'service_dispute')
                    {
                        $result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span>'.$n_sender_name.'</span>'.__( ' created a dispute against the job ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
                    }
					if($n_type == 'dispute_msg')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span>'.$n_sender_name.'</span>'.__( ' sent a message on a dispute ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'service_purchased')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span></span>'.__( 'You got a new order on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'service_completed')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span>'.$n_sender_name.'</span>'.__( ' marked order completed for ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'service_canceled')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span>'.$n_sender_name.'</span>'.__( ' canceled an order on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'payout_processed')
					{
						$price = fl_price_separator(get_post_meta($results->post_id,'_payout_amount',true));
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span></span>'.__( ' Your payout ', 'exertio_framework' ).$price.'<span></span>'.__( ' has been processed. ', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'identity_verified')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span></span>'.__( ' You got a verified badge on your profile', 'exertio_framework' ).'<span></span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'service_expired')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired.', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'service_featured_expired')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired from featured list.', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'service_msg')
					{
						$table2 = EXERTIO_PURCHASED_SERVICES_TBL;
						$query = "SELECT `service_id` FROM ".$table2." WHERE `id` = '" .$results->post_id. "' AND `status` ='ongoing'";
						$id_resuld = $wpdb->get_results($query, ARRAY_A );
						$service = get_post($results->post_id);
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'"><span>'.$n_sender_name.'</span>'.__( ' sent a message on ', 'exertio_framework' ).'<span>'.get_the_title($id_resuld[0]['service_id']).'</span><span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'dispute_action')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'">'.__( 'Your dispute ', 'exertio_framework' ).' <span>'.get_the_title($results->post_id).'</span> '.__( ' has been resolved.', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					if($n_type == 'zoom_meeting')
					{
						$result_html .= '<p><a href="javascript:void(0)" class="dropdown-item '.$status_class.'">'.__( 'Your have a Zoom on', 'exertio_framework' ).' <span>'.get_the_title($results->post_id).'</span> '.__( ' has been resolved.', 'exertio_framework' ).'<span class="time">'.time_ago_function($results->timestamp).'</span></a></p>';
					}
					$result_html .= '</li>';
				}
				$result_html .= '</ul>';
				return $result_html;
				exit;
			}
			else
			{
				return '<p class="no-notification">'.__('No new notifications available','exertio_framework').'</p>';
			}
		}
	}
}



add_action('wp_ajax_exertio_notification_ajax', 'exertio_notification_ajax');
if ( ! function_exists( 'exertio_notification_ajax' ) )
{ 
	function exertio_notification_ajax($only_count = '')
	{
		$uid = get_current_user_id();
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$count = 0;
			$query = "SELECT `id` FROM ".$table." WHERE `receiver_id` = '" . $uid . "' AND `status` ='1' ORDER BY  `timestamp` DESC";
			$result = $wpdb->get_results($query);
			if($result)
			{
				$count = count($result);
			}
		}
		if($only_count == 'count')
		{
			return $count;
		}
		else
		{
			$list = exertio_get_notifications($uid);

			$return = array('count'=>$count, 'n_list'=> $list);
			wp_send_json_success($return);
		}
		
	}
}

add_action('wp_ajax_exertio_read_notifications', 'exertio_read_notifications');
if ( ! function_exists( 'exertio_read_notifications' ) )
{ 
	function exertio_read_notifications($only_count = '')
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$uid = get_current_user_id();
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$current_time = current_time('mysql');
			$data = array(
						'updated_on' =>$current_time,
						'status' => 0,
						);
			$where = array(
						'receiver_id' => $uid,
						);

			$update_id = $wpdb->update( $table, $data, $where );
			if ( is_wp_error( $update_id ) )
			{
				$return = array('message' => esc_html__( 'Notification read issue', 'exertio_framework' ));
				wp_send_json_error($return);
			}
			else
			{
				$return = array('message' => esc_html__( 'Notifications marked as read', 'exertio_framework' ));
				wp_send_json_success($return);
			}
		}
	}
}






if ( ! function_exists( 'exertio_view_all_notifications' ) )
{ 
	function exertio_view_all_notifications($start_from = 0, $limit = 10)
	{
		$uid = get_current_user_id();
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$count = 0;
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $uid . "' ORDER BY  `timestamp` DESC LIMIT ".$start_from.",".$limit."";
			$result = $wpdb->get_results($query);
			if($result)
			{
				$count = count($result);
				//$result_html = '<ul class="notifications">';
				$result_html ='';
				
				foreach($result as $results)
				{
					$status_class = '';
					if($results->sender_type == 'employer')
					{
						$employer_id = get_user_meta( $results->sender_id, 'employer_id' , true );
						$n_sender_name = exertio_get_username('employer', $employer_id);
					}
					else if($results->sender_type == 'freelancer')
					{
						$freelancer_id = get_user_meta( $results->sender_id, 'freelancer_id' , true );
						$n_sender_name = exertio_get_username('freelancer', $freelancer_id);
					}
					if($results->status == 1)
					{
						$status_class = 'active';
					}
					
					$n_type = $results->n_type;
					//$result_html .= '<li>';
					$result_html .= '<div class="pro-box notification_page '.esc_attr($status_class).'">';
					if($n_type == 'proposal')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""> <span>'.$n_sender_name.'</span> '.__( ' sent a proposal on your job ', 'exertio_framework' ).'<span> '.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired.', 'exertio_framework' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_featured_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired from featured list.', 'exertio_framework' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_assigned')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class="">'.__( 'Congratulations! you got a new project ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_completed')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class="">'.__( 'Your project ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span> '.__( ' has been completed', 'exertio_framework' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_rating')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class="">'.__( 'Your got a new rating on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_canceled')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class="">'.__( 'Your project ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span> '.__( ' has been canceled', 'exertio_framework' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_msg')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span>'.$n_sender_name.'</span>'.__( ' sent a message on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'project_dispute')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span>'.$n_sender_name.'</span>'.__( ' created a dispute against the job ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'dispute_msg')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span>'.$n_sender_name.'</span>'.__( ' sent a message on a dispute ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_purchased')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span></span>'.__( 'You got a new order on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_completed')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span>'.$n_sender_name.'</span>'.__( ' marked order completed for ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_canceled')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span>'.$n_sender_name.'</span>'.__( ' canceled an order on ', 'exertio_framework' ).'<span>'.get_the_title($results->post_id).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'payout_processed')
					{
						$price = fl_price_separator(get_post_meta($results->post_id,'_payout_amount',true));
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span></span>'.__( ' Your payout ', 'exertio_framework' ).$price.'<span></span>'.__( ' has been processed. ', 'exertio_framework' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'identity_verified')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span></span>'.__( ' You got a verified badge on your profile', 'exertio_framework' ).'<span></span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired.', 'exertio_framework' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_featured_expired')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""> <span>'.get_the_title($results->post_id).'</span> '.__( ' has been expired from featured list.', 'exertio_framework' ).'</a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'service_msg')
					{
						$table2 = EXERTIO_PURCHASED_SERVICES_TBL;
						$query = "SELECT `service_id` FROM ".$table2." WHERE `id` = '" .$results->post_id. "' AND `status` ='ongoing'";
						$id_resuld = $wpdb->get_results($query, ARRAY_A );

						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class=""><span>'.$n_sender_name.'</span>'.__( ' sent a message on ', 'exertio_framework' ).'<span>'.get_the_title($id_resuld[0]['service_id']).'</span></a></div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></div>';
					}
					if($n_type == 'dispute_action')
					{
						$result_html .= '<div class="pro-coulmn pro-title"><a href="javascript:void(0)" class="">'.__( 'Your dispute ', 'exertio_framework' ).' <span>'.get_the_title($results->post_id).'</span> '.__( ' has been resolved.', 'exertio_framework' ).'</div><div class="pro-coulmn"><span class="time">'.time_ago_function($results->timestamp).'</span></a></div>';
					}
					
					//$result_html .= '</li>';
					$result_html .= '</div>';
				}
				
				return $result_html;
			}
		}

	}
}


if ( ! function_exists( 'notification_pagination' ) )
{
    function notification_pagination( $paged = '', $max_posts = '5')
    {
		$uid = get_current_user_id();
        if(isset($paged))
		{
            $pageno = $paged;
        } 
		else 
		{
            $pageno = 1;
        }
        $no_of_records_per_page = $max_posts;
        $offset = ($pageno-1) * $no_of_records_per_page;
		
		global $wpdb;

		$table =  EXERTIO_NOTIFICATIONS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $uid . "' ORDER BY  `timestamp` DESC ";
			$result = $wpdb->get_results($query);
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=notifications&pageno=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
		}
		for ($i=1; $i<=$total_pages; $i++)
		{
			if($total_pages> 1)
			{
				if($i==$pageno)
				{  
					$pagLink .= "<li class='active'><a href='javascript:void(0)'>".$i."</a></li>"; 
				}
				else if($i > $pageno+2 || $i < $pageno-2)
				{
					$pagLink .= "";
				}
				else
				{
					$pagLink .= "<li><a href='?ext=notifications&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?ext=notifications&pageno=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;
    }
}