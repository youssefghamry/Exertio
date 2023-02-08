<?php
$current_user_id = get_current_user_id();
$pid = get_user_meta( $current_user_id, 'freelancer_id' , true );
$user_info = get_userdata($current_user_id);
global $exertio_theme_options;

$page_name ='';
if(isset($_GET['ext']) && $_GET['ext'] !="")
{ 
	$page_name = $_GET['ext'];	
}
$alt_id ='';
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
    <li class="profile">
    	<div>
            <span class="pro-img">
            <?php
                $pro_img_id = get_post_meta( $pid, '_profile_pic_freelancer_id', true );
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
                    <img src="<?php echo esc_url($exertio_theme_options['freelancer_df_img']['url']); ?>" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                    <?php	
                }
            ?>
            </span>
        </div>
        <h4 class="mt-4"><?php echo exertio_get_username('freelancer',$pid, 'badge', 'right'); ?></h4>
        <p><?php echo esc_html($user_info->user_email); ?></p>
      </li>
	<?php
		foreach($exertio_theme_options['freelancer_dashboard_sidebar_sortable'] as $key => $val)
		{
			if($key == 'Dashboard' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'dashboard') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo get_the_permalink();?>">
					  <i class="fas fa-home menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php		
			}
			if($key == 'Profile' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'edit-profile') { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" href="#profile" aria-expanded="false" aria-controls="profile">
					  <i class="fas fa-user menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'edit-profile' ){ echo 'show';} ?>" id="profile">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'edit-profile') { echo 'active';} ?>"> <a class="nav-link" href="<?php  echo esc_url(get_permalink($pid)); ?>"> <?php echo esc_html__( 'View Profile', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=edit-profile"> <?php echo esc_html__( 'Edit Profile', 'exertio_theme' ); ?> </a></li>
					  </ul>
					</div>
				</li>
				<?php
			}
			if($key == 'ManageAddons' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'create-addon' || $page_name == 'addons') { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" href="#addons" aria-expanded="false" aria-controls="addons">
					  <i class="fas fa-layer-group menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'create-addon' || $page_name == 'addons' || $page_name == 'pending-addons' ) { echo 'show';} ?>" id="addons">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'create-addon') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=create-addon"><?php echo esc_html__( ' Create Addon', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'addons') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=addons"> <?php echo esc_html__( ' My Addon', 'exertio_theme' ); ?></a></li>
						<?php
							if(isset($exertio_theme_options['addons_approval']) &&  $exertio_theme_options['addons_approval'] == 0 || isset($exertio_theme_options['addons_update_approval']) &&  $exertio_theme_options['addons_update_approval'] == 0)
							{
						?>
							<li class="nav-item <?php if($page_name == 'pending-addons') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=pending-addons"> <?php echo esc_html__( ' Pending Addons', 'exertio_theme' ); ?></a></li>
						<?php
							}
						?>
					  </ul>
					</div>
				</li>
				<?php
			}
			if($key == 'Services' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'add-services' || $page_name == 'all-services' || $page_name == 'pending-services' || $page_name == 'ongoing-services' || $page_name == 'canceled-services') { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" href="#services" aria-expanded="false" aria-controls="services">
					  <i class="fas fa-user-cog menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'add-services' || $page_name == 'all-services' || $page_name == 'pending-services' || $page_name == 'ongoing-services' || $page_name == 'canceled-services' || $page_name == 'completed-services' || $page_name == 'completed-service-detail' || $page_name == 'ongoing-service-detail' || $page_name == 'canceled-service-detail') { echo 'show';} ?>" id="services">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'add-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=add-services">  <?php echo esc_html__( 'Add Service', 'exertio_theme' ); ?></a></li>
						<li class="nav-item <?php if($page_name == 'all-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=all-services"> <?php echo esc_html__( 'Active Services', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'pending-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=pending-services"> <?php echo esc_html__( 'Pending Services', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'ongoing-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=ongoing-services"><?php echo esc_html__( ' Ongoing Services', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=completed-services"> <?php echo esc_html__( 'Completed Services', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'canceled-services') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=canceled-services"> <?php echo esc_html__( 'canceled Services', 'exertio_theme' ); ?> </a></li>
					  </ul>
					</div>
				</li>
				<?php
			}
			if($key == 'Projects' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'ongoing-project' || $page_name == 'ongoing-project-detail' || $page_name == 'completed-projects' || $page_name == 'completed-project-detail' || $page_name == 'canceled-projects') { echo 'active';} ?>">
					<a class="nav-link" data-toggle="collapse" href="#projects" aria-expanded="false" aria-controls="projects">
					  <i class="fas fa-briefcase menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					  <i class="fas fa-chevron-down menu-arrow"></i>
					</a>
					<div class="collapse <?php if($page_name == 'ongoing-project' || $page_name == 'ongoing-project-detail' || $page_name == 'completed-projects' || $page_name == 'completed-project-detail' || $page_name == 'canceled-projects') { echo 'show';} ?>" id="projects">
					  <ul class="nav flex-column sub-menu">
						<li class="nav-item <?php if($page_name == 'ongoing-project') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=ongoing-project"><?php echo esc_html__( ' Ongoing Projects', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'completed-projects') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=completed-projects"><?php echo esc_html__( 'Completed Projects', 'exertio_theme' ); ?> </a></li>
						<li class="nav-item <?php if($page_name == 'canceled-projects') { echo 'active';} ?>"> <a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=canceled-projects"><?php echo esc_html__( 'canceled Projects', 'exertio_theme' ); ?> </a></li>
					  </ul>
					</div>
				</li>
				<?php
			}
			if($key == 'ChatDashboard' && $val != "")
			{
				if(in_array('whizz-chat/whizz-chat.php', apply_filters('active_plugins', get_option('active_plugins'))))
				{
					global $whizzChat_options;
					$dashboard_page = isset($whizzChat_options['whizzChat-dashboard-page']) && $whizzChat_options['whizzChat-dashboard-page'] != '' ? $whizzChat_options['whizzChat-dashboard-page'] : 'javascript:void(0)';
					if ($dashboard_page != '')
					{
						?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo esc_url(get_permalink($dashboard_page));?>" target="_blank">
							  <i class="far fa-comment-dots  menu-icon"></i>
							  <span class="menu-title"><?php echo esc_html($val); ?></span>
							</a>
						</li>
						<?php
					}
				}
			}
			if($key == 'MyProposals' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'my-proposals') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=my-proposals">
						<i class="fas fa-address-book  menu-icon"></i>
						<span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
			if($key == 'SavedProjects' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'saved-projects') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=saved-projects">
					  <i class="fas fa-bookmark menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>	
				<?php
			}
			if($key == 'FollowedEmployers' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'followed-employers') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=followed-employers">
					  <i class="fas fa-share menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
			if($key == 'Payouts' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'payouts') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=payouts">
						<i class="fas fa-bullhorn menu-icon"></i>
						<span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
			if($key == 'FundDepositInvoices' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'invoices') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=invoices">
					  <i class="fas fa-receipt menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
			if($key == 'Disputes' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'disputes') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=disputes">
					  <i class="fas fa-shield-alt menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
			if($key == 'VerifyIdentity' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'identity-verification') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=identity-verification">
						<i class="fas fa-user-shield menu-icon"></i>
						<span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
			if($key == 'AllMeetings' && $val != "")
			{
			?>
				<li class="nav-item <?php if($page_name == 'all-meetings') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=all-meetings">
					  <i class="fas fa-receipt menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
			<?php
			}
			if($key == 'Settings' && $val != "")
			{
				?>
				<li class="nav-item <?php if($page_name == 'settings') { echo 'active';} ?>">
					<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=settings">
					  <i class="fas fa-cog  menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
			if($key == 'Statements' && $val != "")
			{
			?>
			<li class="nav-item <?php if($page_name == 'statements') { echo 'active';} ?>">
				<a class="nav-link" href="<?php echo esc_url(get_the_permalink());?>?ext=statements">
					<i class="far fa-list-alt menu-icon"></i>
					<span class="menu-title"><?php echo esc_html($val); ?></span>
				</a>
			</li>
			<?php
			}
			if($key == 'Logout' && $val != "")
			{
				?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo wp_logout_url( get_the_permalink( $exertio_theme_options['login_page'] ) ); ?>">
					  <i class="fas fa-sign-out-alt menu-icon"></i>
					  <span class="menu-title"><?php echo esc_html($val); ?></span>
					</a>
				</li>
				<?php
			}
		}
	?>
    </ul>
</nav>
          