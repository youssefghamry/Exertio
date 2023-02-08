<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();
$alt_id = '';
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} else if ( get_query_var( 'page' ) ) {
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}
$fl_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
	if( is_user_logged_in() )
	 {
		$the_query = new WP_Query( 
									array( 
											'post_type' =>'projects',
											'meta_query' => array(
												array(
													'key' => '_freelancer_assigned',
													'value' => $fl_id,
													'compare' => '=',
													),
												),
											'paged' => $paged,	
											'post_status'     => 'completed',
											'order' => 'DESC',													
											)
										);
		
		$total_count = $the_query->found_posts;
		?>
<div class="content-wrapper">
  <div class="notch"></div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="mr-md-3 mr-xl-5">
            <h2><?php echo esc_html__('Completed Projects','exertio_theme');?></h2>
            <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
				<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
				<?php echo exertio_dashboard_extention_return(); ?>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card mb-4">
        <div class="card-body">
          <div class="pro-section">
              <div class="pro-box heading-row">
                <div class="pro-coulmn pro-title">
                </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Assigned on', 'exertio_theme' ) ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Type/Cost', 'exertio_theme' ) ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Detail', 'exertio_theme' ) ?> </div>
              </div>
				<?php
					if ( $the_query->have_posts() )
					{
						while ( $the_query->have_posts() ) 
						{
							$the_query->the_post();
							$pid = get_the_ID();
							$posted_date = get_the_date(get_option( 'date_format' ), $pid );
							
							$results = get_project_bids($pid);
							?>
							  <div class="pro-box">
								<div class="pro-coulmn pro-title">
									<h4 class="pro-name">
										<a href="<?php  echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
									</h4>
									<span class="pro-meta-box">
										<span class="pro-meta">
											<i class="far fa-clock"></i> <?php echo	esc_html($posted_date); ?>
										</span>
										<span class="pro-meta">
											<?php
												$level = get_term( get_post_meta($pid, '_project_level', true));
												if(!empty($level) && ! is_wp_error($level))
												{
													?>
													<i class="fas fa-layer-group"></i> <?php echo esc_html($level->name); ?>
													<?php
												}
											?>
										</span>
									</span>
								</div>
								<div class="pro-coulmn">
									<?php 
										$assign_date = get_post_meta($pid, '_project_assigned_date', true);
										if($assign_date)
										{
											echo esc_html(date('F d, Y',strtotime($assign_date)));
										}
									 ?>
								</div>
								<div class="pro-coulmn">
									<?php 
										$type = get_post_meta($pid, '_project_type', true);
										if($type == 'fixed' || $type == 1)
										{
											echo esc_html(fl_price_separator(get_post_meta($pid, '_project_cost', true))).'/'.esc_html__( 'Fixed ', 'exertio_theme' );
										}
										else if($type == 'hourly' || $type == 2)
										{
											echo esc_html(fl_price_separator(get_post_meta($pid, '_project_cost', true))).' '.esc_html__( 'Hourly ', 'exertio_theme' );
											echo '<small class="estimated-hours">'.esc_html__( 'Estimated Hours ', 'exertio_theme' ).get_post_meta($pid, '_estimated_hours', true).'</small>';
										}
									 ?>
								</div>
								<div class="pro-coulmn">
									<?php
									if( fl_framework_get_options('turn_project_messaging') == true)
									{
										?>
									<a href="<?php get_template_part( 'project-propsals' );?>?ext=completed-project-detail&project-id=<?php echo esc_html($pid); ?>" class="btn btn-theme-secondary"> <?php echo esc_html__( 'View Detail', 'exertio_theme' ); ?> </a>
										<?php
									}
									else
									{
										?>
										<div class="pro-coulmn completed-status">
											<i class="fas fa-check-circle"></i>
											<div>
												<span class="">
													<?php echo esc_html__( 'Completed ', 'exertio_theme' ); ?>
												</span>
												<small>
													on <?php  echo date_i18n( get_option( 'date_format' ), strtotime( get_post_meta($pid, '_project_completed_date', true) ) ); ?>
												</small>
											</div>
										</div>
										<?php
									}
									?>
								</div>
							  </div>
						  
							<?php
						}
						
						fl_pagination($the_query);
						wp_reset_postdata();
					}
					else
					{
						?>
                        <div class="nothing-found">
                            <h3><?php echo esc_html__( 'Sorry!!! No Record Found', 'exertio_theme' ) ?></h3>
                            <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
                        </div>
                        <?php	
					}
				?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
	}
	else
	{
		echo exertio_redirect(home_url('/'));
	?>
<?php
	}
	?>
