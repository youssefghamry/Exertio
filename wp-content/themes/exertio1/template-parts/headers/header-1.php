<?php
$current_user_id = get_current_user_id();
$main_logo = fl_framework_get_options('frontend_logo');
$img_id = $header_transparent_option = $header_size = $main_logo_url = '';
global $exertio_theme_options;

$active_profile = get_user_meta($current_user_id,'_active_profile', true);
if(isset($main_logo) && $main_logo != '')
{
	$main_logo_url = $main_logo['url'];
}
else
{
	$main_logo_url = get_template_directory_uri().'/images/logo-dashboard.svg';
}

$img_id ='';

$emp_id = get_user_meta( $current_user_id, 'employer_id' , true );

$fre_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
$header_width = fl_framework_get_options('header_size');

$header_size = 'container';
if(isset($header_width) && $header_width == 1)
{
	$header_size = 'container';
}
else if(isset($header_width) && $header_width == 0 )
{
	$header_size = 'container-fluid';
}
$header_transparent = fl_framework_get_options('header_transparent');

$page_id = get_the_ID();
if(isset($header_transparent) && $header_transparent == 1 || $page_id == '589')
{
	$header_transparent_option = '';
}
else if(isset($header_transparent) && $header_transparent == 2 && is_page_template( 'page-home.php'  ))
{
	$header_transparent_option = 'transparent';
}

?>
    <!-- Header -->
    <div class="fr-menu sb-header header-shadow <?php echo esc_attr($header_transparent_option); ?>">
      <div class="<?php echo esc_html($header_size); ?>">
        <!-- sb header -->
        <div class="sb-header-container">
          <!--Logo-->
          <div class="logo" data-mobile-logo="<?php echo esc_url($main_logo_url); ?>" data-sticky-logo="<?php echo esc_url($main_logo_url); ?>"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($main_logo_url); ?>" alt="<?php echo get_post_meta($img_id, '_wp_attachment_image_alt', TRUE); ?>"/></a> </div>
          <!-- Burger menu -->
          <div class="burger-menu">
            <div class="line-menu line-half first-line"></div>
            <div class="line-menu"></div>
            <div class="line-menu line-half last-line"></div>
          </div>

          <!--Navigation menu-->
          <nav class="sb-menu menu-caret submenu-top-border submenu-scale">
            <ul>
                <?php exertio_main_menu( 'main_theme_menu' ); ?>
                <?php if(isset($exertio_theme_options['exertio_notifications']) && $exertio_theme_options['exertio_notifications'] == true)
                {
                    if(is_user_logged_in()){
                        ?>
                        <li class="nav-item dropdown notification-click">
                            <a href="#" class="nav-link dropdown-toggle notification-click" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="dropdownMenuButton1">
                                <h5 class="notification-title"><?php echo esc_html__('Notifications', 'exertio_theme' ); ?></h5>
                                <div class="notification-list"><?php echo exertio_get_notifications($current_user_id); ?></div>
                                <p class="notification-view-all"><a href="<?php echo esc_url(home_url());?>/dashboard/?ext=notifications"> <?php echo esc_html__('See all notifications', 'exertio_theme' ); ?></a></p>
                            </div>
                        </li>
                        <?php
                    }
                }?>
                <?php
			  $btn_text = fl_framework_get_options('header_btn_text');
			  $Second_btn_text = fl_framework_get_options('secondary_btn_text');
			  $employer_btn_text_login = fl_framework_get_options('employer_btn_text_login');
			  $freelancer_btn_text_login = fl_framework_get_options('freelancer_btn_text_login');
                if( is_user_logged_in() )
                {
                    ?>
                    <li class="fr-list">
                        <?php
						if(isset($active_profile) &&  $active_profile == 1 )
						{
							if($employer_btn_text_login != '')
							{
								?>
								<a href="<?php echo fl_framework_get_options('employer_btn_page_login'); ?>" class="btn btn-theme-secondary style-1"> <?php echo esc_html($employer_btn_text_login); ?> </a>
								<?php
							}
						}
						else if(isset($active_profile) &&  $active_profile == 2)
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
                    <li class="submenu-right dropdown_menu fr-list loggedin">
                    <?php
						$dashboard_page = fl_framework_get_options('user_dashboard_page');
						$wallet_text_escaped = esc_html__('Withdraw Funds','exertio_theme');
						$wallet_link = get_the_permalink($dashboard_page).'?ext=payouts';

						$profile_image = '';
                        if(isset($active_profile) &&  $active_profile == 1 )
						{
                            $active_user = 	$emp_id;
                            $profile_image = get_profile_img($active_user, "employer");

							$wallet_link = get_the_permalink($dashboard_page).'?ext=invoices';
							$wallet_text_escaped = esc_html__('View Wallet Detail','exertio_theme');
                        }
                        else if(isset($active_profile) &&  $active_profile == 2)
						{
                            $active_user = 	$fre_id;
                            $profile_image = get_profile_img($active_user, "freelancer");
							$wallet_link = get_the_permalink($dashboard_page).'?ext=payouts';
							$wallet_text_escaped = esc_html__('Withdraw Funds','exertio_theme');
                        }

                    ?>
                    <a href="javascript:void(0)">
                        <?php echo wp_return_echo($profile_image); ?>
                    </a>
                    <ul>
                        <?php
							$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
							if(isset($is_wallet_active) && $is_wallet_active == 0)
							{
                            $amount = get_user_meta( $current_user_id, '_fl_wallet_amount', true );
                        ?>
							<li class="wallet-contanier">
								<a href="<?php echo esc_url($wallet_link );?>" class="dropdown-item">
									<div>
										<span class="text"> <?php echo esc_html__('Wallet Funds','exertio_theme'); ?></span>
										<h4>
											<?php
											if(empty($amount))
											{
												echo esc_html(fl_price_separator(0));
											}
											else
											{
												echo esc_html(fl_price_separator($amount));
											}

											?>
										</h4>
										<span> <?php echo esc_html($wallet_text_escaped); ?><i class="fas fa-arrow-right"></i></span>
									</div>
								</a>
							</li>
						<?php
							}
						?>

                        <li> <a class="dropdown-item" href="<?php echo esc_url(get_the_permalink($dashboard_page)); ?>"><?php echo esc_html__('Dashboard','exertio_theme'); ?></a> </li>
                        <li> <a class="dropdown-item" href="<?php echo esc_url(get_the_permalink($dashboard_page));?>?ext=edit-profile"><?php echo esc_html__('Edit Profile','exertio_theme'); ?></a> </li>
                        <li> <a class="dropdown-item" href="<?php echo wp_logout_url(get_the_permalink(fl_framework_get_options('login_page'))); ?>"><?php echo esc_html__('Logout','exertio_theme'); ?></a> </li>
                    </ul>
                    </li>
                    <?php
                }
                else
                {
					?>
                    <li class="fr-list">
                        <?php
                        if($Second_btn_text != '')
                        {
                            ?>
                            <a href="<?php echo get_the_permalink(fl_framework_get_options('secondary_btn_page')); ?>" class="btn-theme-secondary style-1"> <?php echo esc_html($Second_btn_text); ?> </a>
                            <?php
                        }
                        if($btn_text != '')
                        {
                            ?>
                            <a href="<?php echo get_the_permalink(fl_framework_get_options('header_btn_page')); ?>" class="btn btn-theme"><?php echo esc_html($btn_text); ?></a>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                }
			  ?>
            </ul>
          </nav>
        </div>
      </div>
    </div>