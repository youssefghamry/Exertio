<?php
 /* Template Name: User Dashboard */ 
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package exertio
 */

if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{

	if(is_user_logged_in())
	{
		get_template_part( 'template-parts/dashboard/header','' );
?>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper">
                <?php
				$current_user_id = get_current_user_id();
				$active_profile = get_user_meta($current_user_id,'_active_profile', true);
                if(isset($active_profile) && $active_profile == 1)
                {
				   get_template_part( 'template-parts/dashboard/sidebar','' );
                }
				else
				{
					get_template_part( 'template-parts/dashboard/sidebar','2' );
				}
				 ?>
              <div class="main-panel">
				<?php
				if(fl_framework_get_options('fl_user_email_verification') != null && fl_framework_get_options('fl_user_email_verification') == true)
				{
					$uid = get_current_user_id();
					$stored_dateTime = get_user_meta($uid,'_verify_email_resend_time', true);
					$now = time();
					$currentDateTime = date('d-m-Y H:i:s', $now);
					
					$date1 = strtotime($currentDateTime); 
					$date2 = strtotime($stored_dateTime);
					
					$diff = abs($date2 - $date1);  
  
  

					$years = floor($diff / (365*60*60*24));  
					$months = floor(($diff - $years * 365*60*60*24)  / (30*60*60*24));  
					$days = floor(($diff - $years * 365*60*60*24 -  $months*30*60*60*24)/ (60*60*24)); 
					$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)  / (60*60));  
					$minutes = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60)/ 60);
					$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24  - $hours*60*60 - $minutes*60));
					

					if(strtotime($currentDateTime) > strtotime($stored_dateTime) )
					{
						$resent_msg = '<a href="javascript:void(0)" class="register_email_again"> '.esc_html__('Resend Email?','exertio_theme').'</a>';
					}
					else
					{
						$resent_msg = esc_html__('Resend again in ','exertio_theme'). $minutes.esc_html__(' minutes ','exertio_theme'). $seconds.esc_html__(' seconds','exertio_theme');
					}
					
					$is_verified = get_user_meta( $uid, 'is_email_verified', true );
					if($is_verified != 1 || $is_verified == '' )

					{
						?>
						<div class="exertio-alert alert alert-danger alert-dismissible fade show" role="alert">
							<div class="exertio-alart-box">
								<span class="icon-info">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M14.8 4.613l6.701 11.161c.963 1.603.49 3.712-1.057 4.71a3.213 3.213 0 0 1-1.743.516H5.298C3.477 21 2 19.47 2 17.581c0-.639.173-1.264.498-1.807L9.2 4.613c.962-1.603 2.996-2.094 4.543-1.096c.428.276.79.651 1.057 1.096zm-2.22.839a1.077 1.077 0 0 0-1.514.365L4.365 16.98a1.17 1.17 0 0 0-.166.602c0 .63.492 1.14 1.1 1.14H18.7c.206 0 .407-.06.581-.172a1.164 1.164 0 0 0 .353-1.57L12.933 5.817a1.12 1.12 0 0 0-.352-.365zM12 17a1 1 0 1 1 0-2a1 1 0 0 1 0 2zm0-9a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0V9a1 1 0 0 1 1-1z" fill="#626262"/></svg>
								</span>
								<div class="text-info">
									<h5><?php echo esc_html__('Your email address is not verified','exertio_theme'); ?> </h5>
									<p>
										<?php echo esc_html__('A verification link has been sent to your email. ','exertio_theme'); ?>
										<?php echo wp_return_echo($resent_msg); ?>
									</p>
									</div>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						</div>
						<?php
					}
				}
				?>

                <?php get_template_part( 'template-parts/dashboard/redirection' ); ?>
                <?php get_template_part( 'template-parts/dashboard/footer','' ); ?>
              </div>
            </div>
          </div>
<?php
	}
	else
	{
		wp_redirect(home_url());
	}
}
else
{
	wp_redirect(home_url());
}

?>