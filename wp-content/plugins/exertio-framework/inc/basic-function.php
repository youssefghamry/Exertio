<?php
if ( ! function_exists( 'exertio_get_excerpt' ) ) 
{
	function exertio_get_excerpt($num, $post_id)
	{
		$excerpt = wp_trim_words(get_the_excerpt(),$num);
        return $excerpt;
    }
}
if ( ! function_exists( 'exertio_get_username' ) ) 
{
	function exertio_get_username( $user_type, $user_id = '', $show_badge = '', $badge_position = 'left')
	{
		if($user_id == '')
		{
			$current_user_id = get_current_user_id();
			$emp_id = get_user_meta( $current_user_id, 'employer_id' , true );
			$fre_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
		}
		else
		{
			$emp_id = $user_id;
			$fre_id = $user_id;
		}
		$user_name = $verified = '';
		if($user_type == 'employer')
		{
			if($show_badge == 'badge')
			{
				$verifed_badge = get_post_meta( $emp_id, '_is_employer_verified' , true );

				if(isset($verifed_badge) && $verifed_badge == 1)
				{
					$verified = '<i class="fa fa-check verified protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="'.esc_html__( ' Verified', 'exertio_framework' ).'"></i> ';	
				}
				else
				{
					$verified = '<i class="fa fa-check"></i>';
				}
			}
			//echo $emp_id;
			$user_name = get_post_meta( $emp_id, '_employer_dispaly_name' , true );
			if($user_name == '')
			{
				$post	=	get_post($emp_id);	

				if($post != null)
				{
					$user_name = $post->post_title;
				}
				else
				{
					$user_name = '';
				}
			}
		}
		if($user_type == 'freelancer')
		{
			if($show_badge == 'badge')
			{
				$verifed_badge = get_post_meta( $fre_id, '_is_freelancer_verified' , true );
				if(isset($verifed_badge) && $verifed_badge == 1)
				{
					$verified = '<i class="fa fa-check verified protip" data-pt-position="top" data-pt-scheme="black" data-pt-title="'.esc_html__( 'Verified', 'exertio_framework' ).'"></i> ';	
				}
				else
				{
					$verified = '<i class="fa fa-check"></i>';
				}
			}
			else
			{
				$verified = '';
			}
			
			$user_name = get_post_meta( $fre_id, '_freelancer_dispaly_name' , true );
			if($user_name == '')
			{
				$post	=	get_post($fre_id);
				if($post != null)
				{
					$user_name = $post->post_title;
				}
				else
				{
					$user_name = '';
				}
			}
		}
		
		if($badge_position == 'left')
		{
			return $verified.$user_name;
		}
		else if($badge_position == 'right')
		{
			return $user_name.$verified;
		}
	}
}
if ( ! function_exists( 'exertio_get_service_post_image' ) ) 
{
	function exertio_get_service_post_image($id)
	{
		global $exertio_theme_options;
		$alt_id= '';
		$services_img_id ='';
			$services_img_id = get_post_meta( $id, '_service_attachment_ids', true ); 
			if(wp_attachment_is_image($services_img_id))
			{
				if(isset($services_img_id) && $services_img_id != '')
				{
					$atatchment_arr = explode( ',', $services_img_id );
					foreach ($atatchment_arr as $value)
					{
						$full_link = wp_get_attachment_url($value);
						$img_atts = wp_get_attachment_image_src($value, 'service_grid_img');
						$image = '<img src="'.esc_url($img_atts[0]).'" alt="'.esc_attr(get_post_meta($value, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">';
					break;
					}
				}
//				return $image;
                return '<a href="'.get_the_permalink($id) .'"><img src="'.esc_url($img_atts[0]).'" alt="'.esc_attr(get_post_meta($value, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>';

            }
			else
			{
				return '<a href="'.get_the_permalink($id) .'"><img src="'.esc_url($exertio_theme_options['services_default_img']['url']).'" alt="'.esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a>';
			}
	}
}


if ( ! function_exists( 'exertio_no_result_found' ) ) 
{
	function exertio_no_result_found($bgcolor = '', $text = '')
	{
		$image_id = '';
		$text_detail = esc_html__( 'No Result Found', 'exertio_framework' );
		if(isset($text) && $text != '')
		{
			$text_detail = $text;	
		}
		return '<div class="nothing-found '.$bgcolor.'">
					<img src="'.get_template_directory_uri().'/images/dashboard/nothing-found.png" alt="'.get_post_meta($image_id, '_wp_attachment_image_alt', TRUE).'">
					<h3>'.$text_detail.'</h3>
				</div>';
	}
}
if ( ! function_exists( 'exertio_find_results_ajax' ) )
{
    function exertio_find_results_ajax($bgcolor = '', $text = '')
    {
        $image_id = '';
        $text_detail = esc_html__( 'Please Select Any Project', 'exertio_framework' );
        if(isset($text) && $text != '')
        {
            $text_detail = $text;
        }
        return '<div class="nothing-found '.$bgcolor.'">
					<img src="'.get_template_directory_uri().'/images/dashboard/click.png" alt="'.get_post_meta($image_id, '_wp_attachment_image_alt', TRUE).'">
					<h3 class="select_project">'.$text_detail.'</h3>
				</div>';
    }
}


/*GET ALL POSTS COUNT*/

if ( ! function_exists( 'exertio_get_posts_count' ) ) 
{
	function exertio_get_posts_count($uid, $post_type, $limit = '', $status='', $meta_query = '')
	{
		$author_in ='';
		if($uid != '')
		{
			$author_in = array( $uid );
		}
		$the_query = new WP_Query( 
									array( 
											'author__in' => $author_in ,
											'post_type' => $post_type,
											'posts_per_page' => $limit,
											//'paged' => $paged,	
											'post_status'     => $status,
											'orderby' => 'date',
											'order'   => 'DESC',
											'meta_query'    => array($meta_query),
											)
										);
		$total_posts = $the_query->found_posts;
		if($total_posts <= $total_posts)
		{
			$total_posts = sprintf("%02d", $total_posts);		
		}
		//$total_posts_count = str_pad($total_posts, 2, '0', STR_PAD_LEFT);
		return $total_posts ;
	}
}
if ( ! function_exists( 'exertio_get_services_count' ) ) 
{
	function exertio_get_services_count($seller_id, $status)
	{
		global $wpdb;
		$table =  EXERTIO_PURCHASED_SERVICES_TBL;

		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `seller_id` = '" . $seller_id . "' AND `status` ='".$status."' ORDER BY timestamp DESC";

			$result = $wpdb->get_results($query, ARRAY_A );

			$count_result = count($result);
			if($count_result <= 9)
			{
				$count_result = sprintf("%02d", $count_result);	
			}
			return $count_result ;
		}
	}
}

if ( ! function_exists( 'exertio_demo_disable' ) ) 
{
	function exertio_demo_disable($param = '')
	{
		if(fl_framework_get_options('exertio_demo_mode') == true)
		{
			if(isset($param) && $param == 'echo' )
			{
				echo '0|' .__( 'Disabled for demo', 'exertio_framework' );
				die;
			}
			else if(isset($param) && $param == 'json')
			{
				$return = array('message' => esc_html__( 'Disabled for demo', 'exertio_framework' ));
				wp_send_json_error($return);
			}
		}
	}
}

if ( ! function_exists( 'exertio_generate_code_registeration' ) ) 
{
	function exertio_generate_code_registeration($user_id)
	{
		if(fl_framework_get_options('fl_user_email_verification') !== null && fl_framework_get_options('fl_user_email_verification') == true)
		{
			$code = '';
			$length = 30;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			for ($i = 0; $i < $length; $i++) {
				$code .= $characters[rand(0, $charactersLength - 1)];
			}

			$string = array('id'=>$user_id, 'code'=>$code);

			//update_user_meta($user_id, '_exertio_account_activated', 0);
			update_user_meta($user_id, '_user_activation_code', $code);

			$signinlink = get_home_url();
			$verification_link = esc_url($signinlink.'?activation_key=' .base64_encode( serialize($string)));

			fl_account_activation_email($user_id,$verification_link);

		}
			
	}
}
add_action('wp_ajax_exertio_resend_activation_email', 'exertio_resend_activation_email');
if ( ! function_exists( 'exertio_resend_activation_email' ) ) 
{
	function exertio_resend_activation_email()
	{
		$uid = get_current_user_id();
		if(isset($uid) && $uid != '')
		{
			$now = time();
			$startDateTime = date('d-m-Y H:i:s', $now);

			$stored_dateTime = date('d-m-Y H:i:s',strtotime('+6 minutes',strtotime($startDateTime)));
			update_user_meta($uid, '_verify_email_resend_time', $stored_dateTime);
			exertio_generate_code_registeration($uid);
			$return = array('message' => esc_html__( 'Activation email sent.', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else
		{
			$return = array('message' => esc_html__( 'Activation email is not sent. Please contact admin', 'exertio_framework' ));
			wp_send_json_error($return);
		}
	}
}
if ( ! function_exists( 'exertio_check_register_user_type' ) ) 
{
	function exertio_check_register_user_type($user_type)
	{
		global $exertio_theme_options;
		if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both_selected')
		{
			$current_user_id = get_current_user_id();
			if(isset($user_type) && $user_type == 1)
			{
				$emp_id = get_user_meta( $current_user_id, 'employer_id' , true );
				if($emp_id == '')
				{
					$return = array('message' => esc_html__( 'Please register as an employer first', 'exertio_framework' ));
					wp_send_json_error($return);
				}
			}
			
			if(isset($user_type) && $user_type == 2)
			{
				$fre_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
				if($fre_id == '')
				{
					$return = array('message' => esc_html__( 'Please register as a freelancer first', 'exertio_framework' ));
					wp_send_json_error($return);
				}
			}			

		}
    }
}
//generate random strng for verification

if (!function_exists('exertio_randomString')) {

    function exertio_randomString($length = 50)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}