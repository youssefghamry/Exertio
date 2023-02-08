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
?>

<?php
$cpt_list = $cpt_link = $cpt_placehoder = '';
$header_cpts = $exertio_theme_options['header_searchbar_dropdown'];
foreach($header_cpts as $cpts)
{
	if($cpts == 'project')
	{
		$cpt_list .= '<li data-cpt ="project">'.esc_html__('Find Job', 'exertio_theme').' </li>';
		$cpt_link = get_the_permalink($exertio_theme_options['project_search_page']);
		$cpt_placehoder =  __('Find Job', 'exertio_theme');
	}
	if($cpts == 'services')
	{
		$cpt_list .= '<li data-cpt ="service">'.esc_html__('Get Job Done', 'exertio_theme').' </li>'; 
		$cpt_link = get_the_permalink($exertio_theme_options['services_search_page']);
		$cpt_placehoder =  __('Get Job Done', 'exertio_theme');
	}
	if($cpts == 'freelancer')
	{
		$cpt_list .= '<li data-cpt ="freelancer">'.esc_html__('Find Talent', 'exertio_theme').' </li>';
		$cpt_link = get_the_permalink($exertio_theme_options['freelancer_search_page']);
		$cpt_placehoder =  __('Find Talent', 'exertio_theme');
	}
	if($cpts == 'employer')
	{
		$cpt_list .= '<li data-cpt ="employer">'.esc_html__('Search Employer', 'exertio_theme').' </li>'; 
		$cpt_link = get_the_permalink($exertio_theme_options['employer_search_page']);
		$cpt_placehoder =  __('Search Employer', 'exertio_theme');
	}
}
?>
<!-- Header -->
<div class="fr-menu sb-header header-shadow headerstyle-2">
      <div class="container-fluid"> 
        <!-- sb header -->
        <div class="sb-header-container"> 
          <!--Logo-->
          <div class="logo" data-mobile-logo="<?php echo esc_url($main_logo_url); ?>" data-sticky-logo="<?php echo esc_url($main_logo_url); ?>">
			  <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url($main_logo_url); ?>" alt="<?php echo get_post_meta($img_id, '_wp_attachment_image_alt', TRUE); ?>"/></a>
			  <div class="header-form">
				  <form class="cpt-header-form" action="<?php echo esc_url($cpt_link) ;?>">
					  <svg class="arrow-down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path class="uim-primary" d="M12 15.121a.997.997 0 0 1-.707-.293L7.05 10.586a1 1 0 0 1 1.414-1.414L12 12.707l3.536-3.535a1 1 0 0 1 1.414 1.414l-4.243 4.242a.997.997 0 0 1-.707.293z" fill="currentColor"/></svg>
					  <input type="text"  placeholder="<?php echo wp_return_echo($cpt_placehoder); ?>" class="form-control" name="title"><button type="submit" class="form-control">
					  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8a7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6a6 6 0 0 1-6-6z"/></svg></button>
					  <ul class="cpt-dropdown-header">
						  <?php  echo wp_return_echo($cpt_list); ?>
					  </ul>
				  </form>
			  </div>
		  </div>
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
<?php
	$header_cats = $exertio_theme_options['category_bar'];
if(isset($header_cats) && $header_cats == 1)
{
	$header_categor_bar = $listings_link = '';
	$header_category_cpt = isset($exertio_theme_options['header_category_cpt'])?$exertio_theme_options['header_category_cpt'] : '' ;
	if(isset($header_category_cpt) && $header_category_cpt == 'project')
	{
		$header_categor_bar = $exertio_theme_options['header_categor_bar_project'];
		$listings_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?category';
	}
	else if(isset($header_category_cpt) && $header_category_cpt == 'services')
	{
		$header_categor_bar = $exertio_theme_options['header_categor_bar_services'];
		$listings_link = get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . '?categories';
	}
	if(isset($header_categor_bar) && $header_categor_bar != '')
	{
	?>
		<section class="header-categories">
			<div class="container">
				<div class="row">
					<div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
							<?php
							$inner_items = $items = '';
							foreach ( $header_categor_bar as $categor_bar )
							{
								$term_data = get_term( $categor_bar );
								if(!empty($term_data) && ! is_wp_error($term_data))
								{
									$term_id = $term_data->term_id;
									$items .= '<div class="item">
											<a href="' . $listings_link . '=' . $term_id . '">' . esc_html( $term_data->name ) . '</a>
										  </div>';
								}
							}
							?>
						<div class="header-cat-slider owl-carousel owl-theme">
							<?php echo wp_return_echo($items); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php
	}
}
?>