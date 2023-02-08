<?php
if ( ! function_exists( 'fl_get_all_services' ) )
{
	function fl_get_all_services()
	{

		$current_user_id = get_current_user_id();
		$args	=	array(
		'post_type' => 'services',
		'author' => $current_user_id,
		'status' => array( 'ongoing','completed','canceled'),
		'posts_per_page' => -1,
		'order'=> 'DESC',
		'orderby' => 'ID'
		);
		$posts = new WP_Query( $args );
		$html ='';
		$html .= '<select name="service_id" class="general_select form-control" required data-smk-msg="'.esc_html__('Select Service first','exertio_framework').'"><option value="">'.esc_html__("Select Service","exertio_framework").'</option>';
		while ( $posts->have_posts() )
		{
			$posts->the_post();
			$pid = get_the_ID();
			$title = get_the_title();
			$freelancer_id = get_post_meta($pid,'_freelancer_assigned',true);

			$length = '30';
			$title_now = '';
			if(strlen($title)<=$length)
			{
				$title_now = $title;
			}
			else
			{
				$title_now = substr($title,0,$length) . '...';
			}
			
			
			$html .= '<option value="'.$pid.'">'.$title_now.' ('.exertio_get_username('freelancer',$freelancer_id).')'.'</option>';
		}


		/*Service ASSIGNED TO ME*/
		$fl_id = get_user_meta( $current_user_id, 'employer_id' , true );

        $seller_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
        global $wpdb;
        $table = EXERTIO_PURCHASED_SERVICES_TBL;
            $query = "SELECT * FROM ".$table." WHERE  `status` ='ongoing' ORDER BY timestamp DESC";
            $result = $wpdb->get_results($query, ARRAY_A );
        if ( $result !="")
		{
			foreach ( $result as $resu )
			{
                $buyer_ids = $resu['buyer_id'] ? $resu['buyer_id'] : '';
                $s_ids = $resu['service_id'] ? $resu['service_id'] : '';
                $post_title = get_post_field( 'post_title', $s_ids );
                $post_author_id = get_post_field( 'post_author', $s_ids );
                $emp_id = get_user_meta( $post_author_id, 'employer_id' , true );
                $length = '30';
                $title_now = '';
                if(strlen($post_title)<=$length)
                {
                    $title_now = $post_title;
                }
                else
                {
                    $title_now = substr($post_title,0,$length) . '...';
                }
               if ($fl_id == $buyer_ids){
                   $html .= '<option value="'.$s_ids.'">'.$title_now.' ('.exertio_get_username('employer',$emp_id).')'.'</option>';
               }
               else{
                   $html .= '<option value="'.$s_ids.'">'.$title_now.' ('.exertio_get_username('employer',$emp_id).')'.'</option>';
               }
			}
		}
		$html .=  '</select>';
		return $html;
	}
}

/*DISPUTE CREATE CALLBACK*/
add_action('wp_ajax_fl_dispute_service_callback', 'fl_dispute_service_callback');
add_action('wp_ajax_nopriv_fl_dispute_service_callback', 'fl_dispute_service_callback');
if ( ! function_exists( 'fl_dispute_service_callback' ) )
{ 
	function fl_dispute_service_callback()
	{
		exertio_demo_disable('json');
		check_ajax_referer( 'fl_dispute_secure', 'security' );
		$current_user_id = get_current_user_id();
		parse_str($_POST['dispute_service_data'], $params);
		$service_id = $params['service_id'];
		$dispute_title = $params['dispute_title'];
		$desc = $params['dispute_description'];
        global $wpdb;
        $table = EXERTIO_PURCHASED_SERVICES_TBL;
        $query = "SELECT * FROM ".$table." WHERE `service_id` = '" . $service_id . "' ORDER BY timestamp DESC";
        $result = $wpdb->get_results($query, ARRAY_A );

        foreach ( $result as $resu ) {
            $buyer_ids = $resu['buyer_id'] ? $resu['buyer_id'] : '';
            $seller_ids = $resu['seller_id'] ? $resu['seller_id'] : '';

        }
		$service_owner = get_post_field( 'post_author', $service_id);
		if($service_owner == $current_user_id)
		{
			$disputer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
			$against_id = $buyer_ids;

			$n_sender_id = $current_user_id;
			$n_receiver_id = get_post_field( 'post_author', $against_id );
			$sender_type = 'employer';
		}
		else
		{

		$disputer_id = $buyer_ids;
		$against_id = get_user_meta( $service_owner, 'freelancer_id' , true );

			$n_sender_id = $current_user_id;
			$n_receiver_id = $service_owner;
			$sender_type = 'freelancer';
		}

		$status = get_post_status($service_id);
		if(isset($status) && $status == 'publish' || isset($status) && $status == 'completed' || isset($status) && $status == 'canceled')
		{

			$is_disputed = get_post_meta($service_id,'_is_dispute', true);
			if($service_id != '' || $dispute_title != '' || $desc != '')
			{
				if($is_disputed == '')
				{
					$query = array(
						'post_type' =>'disputes',
						'post_title'    => sanitize_text_field($dispute_title),
						'post_content'  => wp_kses_post($desc),
						'post_status'   => 'pending',
						'post_author'   =>  $current_user_id,
					);

					$dispute_id = wp_insert_post( $query );

					if (is_wp_error($dispute_id)){
						$return = array('message' => esc_html__( 'Dispute not created', 'exertio_framework' ));
						wp_send_json_error($return);
						exit();
					}
					else
					{
						do_action( 'exertio_notification_filter',array('post_id'=> $service_id,'n_type'=>'service_dispute','sender_id'=>$n_sender_id,'receiver_id'=>$n_receiver_id,'sender_type'=>$sender_type) );
						
						update_post_meta($dispute_id,'_service_id',$service_id);
						update_post_meta($dispute_id,'_dispute_against_user_id',$against_id);
						update_post_meta($dispute_id,'_dispute_creater_user_id',$disputer_id);
						update_post_meta($dispute_id,'_dispute_status','ongoing');
						update_post_meta($service_id,'_is_dispute',1);
						$return = array('message' => esc_html__( 'Dispute Created', 'exertio_framework' ));
						wp_send_json_success($return);
					}
				}
				else
				{
					$return = array('message' => esc_html__( 'Dispute already created', 'exertio_framework' ));
					wp_send_json_error($return);
					exit();
				}
			}
			else
			{
				$return = array('message' => esc_html__( 'fields can not be empty', 'exertio_framework' ));
				wp_send_json_error($return);
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Dispute can only be created on Ongoing, Completed or canceled Services', 'exertio_framework' ));
			wp_send_json_error($return);
		}
	}
}
/*DISPUTE MESSAGE SAVE*/
add_action('wp_ajax_exertio_dispute_service_msg', 'exertio_dispute_service_msg');
if ( ! function_exists( 'exertio_dispute_service_msg' ) )
{
	function exertio_dispute_service_msg()
	{
		exertio_demo_disable('json');
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$current_user_id = get_current_user_id();
		$dispute_id = $_POST['post_id'];
        $service_id = get_post_meta($dispute_id,'_service_id', true);
        global $wpdb;
        $table = EXERTIO_PURCHASED_SERVICES_TBL;
        $query = "SELECT * FROM ".$table." WHERE `service_id` = '" . $service_id . "' ORDER BY timestamp DESC";
        $result = $wpdb->get_results($query, ARRAY_A );

        foreach ( $result as $resu ) {
            $buyer_ids = $resu['buyer_id'] ? $resu['buyer_id'] : '';
            $seller_ids = $resu['seller_id'] ? $resu['seller_id'] : '';

        }
		$msg_author = get_user_meta( $current_user_id, 'employer_id' , true );

		$fl_id = $buyer_ids;
		
		$service_owner = get_post_field( 'post_author', $service_id );
		if($service_owner == $current_user_id)
		{
			$receiver_id = get_post_field( 'post_author', $fl_id );
			$sender_type = 'employer';
		}
		else
		{
			$receiver_id = $service_owner;
			$sender_type = 'freelancer';
		}

		$current_datetime = current_time('mysql');
		
		parse_str($_POST['dispute_service_data'], $params);
		
		if($params['dispute_msg_text'] != '')
		{
			global $wpdb;
			$table = EXERTIO_DISPUTE_MSG_SERVICE_TBL;
			$data = array(
						'timestamp' => $current_datetime,
						'updated_on' =>$current_datetime,
						'dispute_id' => sanitize_text_field($dispute_id),
						'post_id' => sanitize_text_field($service_id),
						'message' => sanitize_text_field($params['dispute_msg_text']),
						'msg_receiver_id' => sanitize_text_field($fl_id),
						'msg_author_id' => sanitize_text_field($msg_author),
						'status' => '1',
						);

			$wpdb->insert($table,$data);
			$msg_id = $wpdb->insert_id;
			if($msg_id)
			{
				$active_notif = fl_framework_get_options('exertio_notifications_msgs');
				if(isset($active_notif)&& $active_notif == true)
				{
					do_action( 'exertio_notification_filter',array('post_id'=> $dispute_id,'n_type'=>'dispute_msg','sender_id'=>$current_user_id,'receiver_id'=>$receiver_id,'sender_type'=>$sender_type) );
                }
				$return = array('message' => esc_html__( 'Message sent', 'exertio_framework' ));
				wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__( 'Error!!! Message sending failed.', 'exertio_framework' ));
				wp_send_json_error($return);	
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Message field can not be empty', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	}
}

if ( ! function_exists( 'exertio_get_services_dispute_msgs' ) )
{
	function exertio_get_services_dispute_msgs($pid)
	{
		global $wpdb;
		$table = EXERTIO_DISPUTE_MSG_SERVICE_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `dispute_id` = '" . $pid . "' AND `status` ='1'";
			$result = $wpdb->get_results($query);
			if($result)
			{
				return $result;
			}
		}
	}
}


?>