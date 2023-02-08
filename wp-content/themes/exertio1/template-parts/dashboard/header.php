<?php get_header();
global $exertio_theme_options;
$img_id ='';
$current_user_id = get_current_user_id();
$emp_id = get_user_meta( $current_user_id, 'employer_id' , true );


$fre_id = get_user_meta( $current_user_id, 'freelancer_id' , true );

$active_profile = get_user_meta($current_user_id,'_active_profile', true);
if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both')
{
	$user_redirection_after_login = $exertio_theme_options['user_redirection_after_login'];
	if($active_profile == '')
	{
		$dashboard_page = fl_framework_get_options('user_dashboard_page');
		if(isset($user_redirection_after_login) && $user_redirection_after_login == 'employer')
		{
			//setcookie('active_profile', 'employer', time() + (86400 * 365), "/");
			update_user_meta($current_user_id, '_active_profile', 1);
			wp_redirect(get_the_permalink($dashboard_page));
			exit;
		}
		else if(isset($user_redirection_after_login) && $user_redirection_after_login == 'freelancer')
		{
			//setcookie('active_profile', 'freelancer', time() + (86400 * 365), "/");
			update_user_meta($current_user_id, '_active_profile', 2);
			 wp_redirect(get_the_permalink($dashboard_page));
			exit;
		}
	}
}
/*FOR SOCIAL MEDIA REGISTRATION*/
if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both_selected')
{
	if(isset($exertio_theme_options['user_registration_type_selection']) && count(array_filter($exertio_theme_options['user_registration_type_selection'])) > 1 )
	{
		if($emp_id == '' && $fre_id == '')
		{
			?>
			<div class="modal fade review-modal user-selection-modal" id="usermodal" data-backdrop="static">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title"><?php echo esc_html__('Select User Type','exertio_theme');?></h4>
				  </div>
				  <div class="modal-body">
					<form id="user-selection-form">
						<div class="form-group">
							<div class="register-type">
							  <div class="register-type-btn">
								  <label class="radio"> 
									 <input class="" type="radio" value="employer" name="exertio_user_type" checked="checked"><span><?php echo esc_html__('Employer','exertio_theme'); ?></span>
								  </label>
							  </div>
							  <div class="register-type-btn">
								 <label class="radio"> 
									 <input class="" type="radio" value="freelancer"  name="exertio_user_type"><span><?php echo esc_html__('Freelancer','exertio_theme'); ?></span>
								  </label>
							  </div>
						  </div>
							<p><?php echo esc_html__('You must have to select one option to move forward.','exertio_theme'); ?></p>
						</div>
						<div class="form-group"> <button type="button" id="set-user-type" class="btn btn-theme-secondary btn-loading btn-block" ><?php echo esc_html__('Submit & Save','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
					</form>
				  </div>
				</div>
			  </div>
			</div>
			<?php
		}

		if( (isset($emp_id) && $emp_id != '') && (isset($fre_id) && $fre_id != ''))
		{
			?>
			<div class="modal fade review-modal user-selection-modal" id="usermodal" data-backdrop="static">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title"><?php echo esc_html__('Select User Type','exertio_theme');?></h4>
				  </div>
				  <div class="modal-body">
					<form id="user-selection-form-update">
						<div class="form-group">
							<div class="register-type">
							  <div class="register-type-btn">
								  <label class="radio"> 
									 <input class="" type="radio" value="employer" name="exertio_user_type" checked="checked"><span><?php echo esc_html__('Employer','exertio_theme'); ?></span>
								  </label>
							  </div>
							  <div class="register-type-btn">
								 <label class="radio"> 
									 <input class="" type="radio" value="freelancer"  name="exertio_user_type"><span><?php echo esc_html__('Freelancer','exertio_theme'); ?></span>
								  </label>
							  </div>
						  </div>
						</div>
						<p><?php echo esc_html__('You must have to select one option to move forward.','exertio_theme'); ?></p>
						<p><?php echo esc_html__('Please select this option carefully as you will not be able to change it in the future.','exertio_theme'); ?></p>
						<div class="form-group"> <button type="button" id="set-user-type-update" class="btn btn-theme-secondary btn-loading btn-block" ><?php echo esc_html__('Submit & Save','exertio_theme'); ?> <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div></button> </div>
					</form>
				  </div>
				</div>
			  </div>
			</div>
			<?php
		}
	}
}
/*else
{
	if($active_profile == '')
	{
		$dashboard_page = fl_framework_get_options('user_dashboard_page');
		$current_user_id = get_current_user_id();
		$emp_id = get_user_meta( $current_user_id, 'employer_id' , true );
		$fre_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
		if(isset($emp_id) && $emp_id != '' )
		{
			//setcookie('active_profile', 'employer', time() + (86400 * 365), "/");
			update_user_meta($uid, '_active_profile', 1);
			wp_redirect(get_the_permalink($dashboard_page));
		}
		else if(isset($fre_id) && $fre_id != '' )
		{
			//setcookie('active_profile', 'freelancer', time() + (86400 * 365), "/");
			update_user_meta($uid, '_active_profile', 2);
			wp_redirect(get_the_permalink($dashboard_page));
		}
	}
}*/
?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">  
          <a class="navbar-brand brand-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($exertio_theme_options['dasboard_logo']['url']); ?>" alt="<?php echo get_post_meta($img_id, '_wp_attachment_image_alt', TRUE); ?>"/></a>
          <a class="navbar-brand brand-logo-mini" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($exertio_theme_options['dasboard_logo']['url']); ?>" alt="logo"/></a>
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>  
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
			<?php
			if(isset($exertio_theme_options['exertio_notifications']) && $exertio_theme_options['exertio_notifications'] == true)
			{
				?>
				<li class="nav-item dropdown notification-click">
					<a href="#" class="nav-link dropdown-toggle notification-click" data-toggle="dropdown">
						<i class="far fa-bell"></i>
						<span class="badge-container">
						<?php
							$notification = exertio_notification_ajax('count');
							if(isset($notification) && $notification > 0)
							{
								?>
								<span class="badge bg-danger"><?php echo esc_html($notification); ?></span>
								<?php
							}
						?>
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
						<h5 class="notification-title"><?php echo esc_html__('Notifications', 'exertio_theme' ); ?></h5>
						<div class="notification-list"><?php echo exertio_get_notifications($current_user_id); ?></div>
						<p class="notification-view-all"><a href="<?php echo esc_url(get_the_permalink());?>?ext=notifications"> <?php echo esc_html__('See all notifications', 'exertio_theme' ); ?></a></p>
					</div>
				</li>
				<?php
			}
			?>
          <li class="nav-item nav-profile dropdown">
          	<?php
			  $active_profile = get_user_meta($current_user_id,'_active_profile', true);
			  	$wallet_link = $wallet_text_escaped = '';
				$final_amount_html = $user_type = $user_name = $profile_image = '';
				$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
				if(isset($is_wallet_active) && $is_wallet_active == 0)
				{
					$amount = get_user_meta( $current_user_id, '_fl_wallet_amount', true );
					if(empty($amount))
					{
						$final_amout =  0; 
					}
					else
					{
						$final_amout =  $amount;
					}
					$final_amount_html = ' ( '.fl_price_separator($final_amout).' )';
				}
				if(isset($active_profile) &&  $active_profile == 1 )
				{
					$active_user = 	$emp_id;
					$profile_image = get_profile_img($active_user, "employer");

					$user_name = exertio_get_username('employer',$active_user );
					$user_type = esc_html__('Employer','exertio_theme');
					$wallet_link = get_the_permalink().'?ext=invoices';
					$wallet_text_escaped = esc_html__('View Wallet Detail','exertio_theme');
                }
				else if(isset($active_profile) &&  $active_profile == 2)
				{
					$active_user = 	$fre_id;
					$profile_image = get_profile_img($active_user, "freelancer");

					$user_name = exertio_get_username('freelancer',$active_user );
					$user_type = esc_html__('Freelancer','exertio_theme');
					$wallet_link = get_the_permalink().'?ext=payouts';
					$wallet_text_escaped = esc_html__('Withdraw Funds','exertio_theme');
				}
			?>
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <?php echo wp_return_echo($profile_image); ?>
              <div class="nav-profile-meta">
                  <span class="nav-profile-name"><?php echo esc_html($user_name).$final_amount_html; ?></span>
                  <small> <?php echo esc_html ($user_type); ?></small>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
				<ul>
				<?php
					if(isset($is_wallet_active) && $is_wallet_active == 0)
					{
						?>
						<li class="dropdown-item wallet-contanier">
							<div>
								<span class="text"> <?php echo esc_html__('Wallet Funds','exertio_theme'); ?></span>
								<h4>
									<?php echo esc_html(fl_price_separator($final_amout)); ?>
								</h4>
								<span> <a href="<?php echo esc_url($wallet_link) ?>"><?php echo esc_html($wallet_text_escaped); ?> <i class="fas fa-arrow-right"></i></a></span>
							</div>
						</li>
						<?php
					}
				if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both')
				{
				?>
				<li>
					<a class="dropdown-item profile_selection  <?php if(isset($active_profile) && $active_profile == 2) { echo 'selected'; } ?>" data-profile-active="freelancer" href="javascript:void(0)">
						<span class="profile-img">
							<?php
								$pro_img_id = get_post_meta( $fre_id, '_profile_pic_freelancer_id', true );
								$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );

								if(wp_attachment_is_image($pro_img_id))
								{
									?>
									<img src="<?php echo esc_url($pro_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
									<?php
								}
								else
								{
									?>
									<img src="<?php echo esc_url($exertio_theme_options['freelancer_df_img']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
									<?php	
								}
							?>
						</span>
						<span>
							<h4>
								<?php
									if (strlen(esc_attr(get_post_meta( $fre_id, '_freelancer_dispaly_name' , true ))) > 20)
									{
									   echo substr(exertio_get_username('freelancer',$fre_id ), 0, 20) . ' ...';
									}
									else
									{
										echo exertio_get_username('freelancer',$fre_id );
									}
								?>
							</h4>
							<p><?php echo esc_html__('Freelancer','exertio_theme'); ?></p>
						</span>
					</a>
				</li>
				<li>
					<a class="dropdown-item <?php if(isset($active_profile) && $active_profile == 1) { echo 'selected'; } else if(empty($active_profile)) { echo 'selected'; } ?> profile_selection" data-profile-active="employer" href="javascript:void(0)">
						<span class="profile-img">
							<?php
								$pro_img_id = get_post_meta( $emp_id, '_profile_pic_attachment_id', true );
								$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );

								if(wp_attachment_is_image($pro_img_id))
								{
									?>
									<img src="<?php echo esc_url($pro_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
									<?php
								}
								else
								{
									?>
									<img src="<?php echo esc_url($exertio_theme_options['employer_df_img']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
									<?php	
								}
							?>
						</span>
						<span>
							<h4>
								<?php 
									if (strlen(esc_attr(get_post_meta( $emp_id, '_employer_dispaly_name' , true ))) > 20)
									{
									   echo substr(exertio_get_username('employer',$emp_id ), 0, 20) . ' ...';
									}
									else
									{
										echo exertio_get_username('employer',$emp_id );
									}
								?>
							</h4>
							<p><?php echo esc_html__('Employer','exertio_theme'); ?></p>
						</span>
					</a>
				</li>
				<?php
				}
				?>
				<li>
				  <a class="dropdown-item" href="<?php echo esc_url(get_the_permalink());?>?ext=edit-profile">
					<i class="mdi mdi-settings text-primary"></i>
					<?php echo esc_html__('Edit Profile','exertio_theme'); ?>
				  </a>
				</li>
				<li>
					<a href="<?php echo wp_logout_url( get_the_permalink( $exertio_theme_options['login_page'] ) ); ?>" class="dropdown-item">
						<i class="mdi mdi-logout text-primary"></i>
						<?php echo esc_html__('Logout','exertio_theme'); ?>
					</a>
				  </li>
				  </ul>
            </div>
          </li>
          <li class="fr-list nav-item dropdown mr-4 nav-btn-post">
			<?php
			  $employer_btn_text_login = fl_framework_get_options('employer_btn_text_login');
			  $freelancer_btn_text_login = fl_framework_get_options('freelancer_btn_text_login');

			if(isset($active_profile) &&  $active_profile == 1 || $active_profile == '')
			{
				if($employer_btn_text_login != '')
				{
					?>
					<a href="<?php echo fl_framework_get_options('employer_btn_page_login'); ?>" class="btn btn-theme-secondary style-1"> <?php echo esc_html($employer_btn_text_login); ?> </a>
					<?php
				}
			}
			if(isset($active_profile) &&  $active_profile == 2)
			{
				if($freelancer_btn_text_login != '')
				{
					?>
					<a href="<?php echo fl_framework_get_options('freelancer_btn_page_login'); ?>" class="btn btn-theme"><?php echo esc_html($freelancer_btn_text_login); ?></a>
					<?php
				}
			}
			?>
		</li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>