<?php
add_action( 'exertio_project_cron', 'exertio_project_expiration' );
if ( ! function_exists( 'exertio_project_expiration' ) ) 
{
	function exertio_project_expiration()
	{
		$today_date = date("d-m-Y");
		$args = array(  
			'post_type' => 'projects',
			'post_status' => array('publish', 'ongoing'),
			'posts_per_page' => -1, 
		);

		$loop = new WP_Query( $args ); 
			
		while ( $loop->have_posts() )
		{
			$loop->the_post(); 
			$project_id = get_the_ID();
			$featured_projects = get_post_meta($project_id, '_project_is_featured', true);
			
			if(isset($featured_projects) && $featured_projects == 1 )
			{
				$featured_project_expiry_date = get_post_meta($project_id, '_featured_project_expiry_date', true);
				if($featured_project_expiry_date != -1)
				{
					if(strtotime($featured_project_expiry_date) < strtotime($today_date))
					{
						update_post_meta( $project_id, '_project_is_featured', 0);
						$post_author_user_id = get_post_field( 'post_author', $project_id );
						do_action( 'exertio_notification_filter',array('post_id'=> $project_id,'n_type'=>'project_featured_expired','sender_id'=>'','receiver_id'=>$post_author_user_id) );
					}
				}
			}
			
			$project_status = get_post_meta($project_id, '_project_status', true);
			if(isset($project_status) && $project_status == 'active')
			{
				$simple_project_expiry_days = get_post_meta($project_id, '_simple_projects_expiry_date', true);

				if(isset($simple_project_expiry_days) && $simple_project_expiry_days != -1)
				{
					if(strtotime($simple_project_expiry_days) < strtotime($today_date))
					{
						update_post_meta( $project_id, '_project_status', 'expired');
						/*NOTIFICATION*/
						$post_author_user_id = get_post_field( 'post_author', $project_id );
						do_action( 'exertio_notification_filter',array('post_id'=> $project_id,'n_type'=>'project_expired','sender_id'=>'','receiver_id'=>$post_author_user_id) );
					}
				}
			}
			
		}
		wp_reset_postdata();
		
		/*EMPLOYER FEATURED REMOVAL*/
		$args_2 = array(  
			'post_type' => 'employer',
			'post_status' => 'publish',
			'posts_per_page' => -1, 
		);
		$loop_2 = new WP_Query( $args_2 ); 
		while ( $loop_2->have_posts() )
		{
			$loop_2->the_post(); 
			$employer_id = get_the_ID();
			$package_expiry_date = get_post_meta($employer_id, '_employer_package_expiry_date', true);
			if($package_expiry_date != -1 && $package_expiry_date == 1)
			{
				if(strtotime($package_expiry_date) < strtotime($today_date))
				{
					
					update_post_meta( $employer_id, '_employer_is_featured', 0);
				}
			}
		}
		wp_reset_postdata(); 
	}
}
add_action( 'init', 'exertio_project_expire_event');

// Function which will register the event
function exertio_project_expire_event() {
	if(fl_framework_get_options('fl_cron_toggle') == true)
	{
		// Make sure this event hasn't been scheduled
		if( !wp_next_scheduled( 'exertio_project_cron' ) ) {
			// Schedule the event
			$payout_option = 'once_a_day';
			if ( class_exists( 'Redux' ) )
			{
				$payout_option = Redux::getOption('exertio_theme_options', 'exertio_project_cron_select');
			}
			//$payout_days = 'once_a_day';
			wp_schedule_event( time(), $payout_option, 'exertio_project_cron' );
		}
	}
}

add_filter( 'cron_schedules', 'exertio_project_schedule' ); 
function exertio_project_schedule( $schedules ) {
	
	$hour_seconds =  60 * 60;
	$hour12_seconds =  12 * 60 * 60;
	$hour24_seconds =  24 * 60 * 60;
	$schedules['hourly'] = array(
		'interval' => $hour_seconds , 
		'display' => __( 'Hourly', 'exertio_framework' )
	);
	$schedules['twice_a_day'] = array(
		'interval' => $hour12_seconds ,
		'display' => __( 'Twice a days', 'exertio_framework' )
	);
	$schedules['once_a_day'] = array(
		'interval' => $hour24_seconds ,
		'display' => __( 'Once a days', 'exertio_framework' )
	);
	return $schedules;
}




/*SERVICES CRON*/

add_action( 'exertio_services_cron', 'exertio_services_expiration' );
if ( ! function_exists( 'exertio_services_expiration' ) ) 
{
	function exertio_services_expiration()
	{
		$today_date = date("d-m-Y");
		$args = array(  
			'post_type' => 'services',
			'post_status' => 'publish',
			'posts_per_page' => -1, 
		);

		$loop = new WP_Query( $args ); 
			
		while ( $loop->have_posts() )
		{
			$loop->the_post(); 
			$service_id = get_the_ID();
			$post_author_user_id = get_post_field( 'post_author', $service_id );
			$post_status = get_post_meta( $service_id, '_service_status', true );
			if(isset($post_status) && $post_status == 'active')
			{
				$featured_services = get_post_meta($service_id, '_service_is_featured', true);

				if(isset($featured_services) && $featured_services == 1 )
				{
					$featured_service_expiry_date = get_post_meta($service_id, '_featured_service_expiry_date', true);
					if($featured_service_expiry_date != -1)
					{
						if(strtotime($featured_service_expiry_date) < strtotime($today_date))
						{
							
							do_action( 'exertio_notification_filter',array('post_id'=> $service_id,'n_type'=>'service_featured_expired','sender_id'=>'1','receiver_id'=>$post_author_user_id,'sender_type'=>'admin') );
							//echo the_title().'/'.$featured_service_expiry_date.'/ Not Featured'.'<br>';
							update_post_meta( $service_id, '_service_is_featured', 0);
						}
					}
				}

				$simple_service_expiry_days = get_post_meta($service_id, '_simple_service_expiry_date', true);

				if(isset($simple_service_expiry_days) && $simple_service_expiry_days != -1)
				{
					if(strtotime($simple_service_expiry_days) < strtotime($today_date))
					{
						do_action( 'exertio_notification_filter',array('post_id'=> $service_id,'n_type'=>'service_expired','sender_id'=>'1','receiver_id'=>$post_author_user_id,'sender_type'=>'admin'));
					
						update_post_meta( $service_id, '_service_status', 'expired');
					}
				}
			}
		}
		wp_reset_postdata();
		
		/*EMPLOYER FEATURED REMOVAL*/
		$args_2 = array(  
			'post_type' => 'freelancer',
			'post_status' => 'publish',
			'posts_per_page' => -1, 
		);
		$loop_2 = new WP_Query( $args_2 ); 
		while ( $loop_2->have_posts() )
		{
			$loop_2->the_post(); 
			$freelancer_id = get_the_ID();
			$package_expiry_date = get_post_meta($freelancer_id, '_freelancer_package_expiry_date', true);
			if($package_expiry_date != -1 && $package_expiry_date == 1)
			{
				if(strtotime($package_expiry_date) < strtotime($today_date))
				{
					
					update_post_meta( $freelancer_id, '_freelancer_is_featured', 0);
				}
			}
		}
		wp_reset_postdata(); 
	}
}
add_action( 'init', 'exertio_services_expire_event');

// Function which will register the event
function exertio_services_expire_event() {
	if ( class_exists( 'Redux' ) )
	{
		if(fl_framework_get_options('fl_cron_toggle') == true)
		{
			// Make sure this event hasn't been scheduled
			if( !wp_next_scheduled( 'exertio_services_cron' ) ) {
				// Schedule the event
				

				$payout_option = Redux::getOption('exertio_theme_options', 'exertio_services_cron_select');
				if($payout_option == '')
				{
					$payout_option = 'once_a_day';
				}
				//$payout_days = 'once_a_day';
				wp_schedule_event( time(), $payout_option, 'exertio_services_cron' );
			}
		}
	}
}