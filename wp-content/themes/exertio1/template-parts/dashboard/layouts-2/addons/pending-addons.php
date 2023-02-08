<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();
if ( get_query_var( 'paged' ) ) {
	$paged = get_query_var( 'paged' );
} else if ( get_query_var( 'page' ) ) {
	/*This will occur if on front page.*/
	$paged = get_query_var( 'page' );
} else {
	$paged = 1;
}

	if( is_user_logged_in() )
	 {
		if(isset($_GET['search_title']) && $_GET['search_title'] !="")
		{
			$title = $_GET['search_title'];
			
			$query_args = array( 
								's' => $title,
								'author__in' => array( $current_user_id ) ,
								'post_type' =>'addons',
								'meta_query' => array(
												array(
													'key' => '_addon_status',
													'value' => 'active',
													'compare' => '=',
													),
												),
								'paged' => $paged,
								'post_status'     => 'pending'
								);
			$the_query = new WP_Query( $query_args );
			$total_count = $the_query->found_posts;
		}
		else
		{
		// The Query
		$the_query = new WP_Query( 
									array( 
											'author__in' => array( $current_user_id ) ,
											'post_type' =>'addons',
											'meta_query' => array(
												array(
													'key' => '_addon_status',
													'value' => 'active',
													'compare' => '=',
													),
												),
											'paged' => $paged,	
											'post_status'     => 'pending'													
											)
										);
		
		$total_count = $the_query->found_posts;
		}
		
		/*echo '<pre>';
		print_r($the_query);
		echo '</pre>';*/
		?>

<div class="content-wrapper">
  <div class="notch"></div>
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="d-flex justify-content-between flex-wrap">
        <div class="d-flex align-items-end flex-wrap">
          <div class="mr-md-3 mr-xl-5">
            <h2><?php echo esc_html__('Pending Addons','exertio_theme').esc_html(' ('. $total_count.')');?></h2>
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
                <div class="pro-coulmn"><?php echo esc_html__( 'Date Created', 'exertio_theme' ) ?> </div>
                <div class="pro-coulmn"><?php echo esc_html__( 'Price', 'exertio_theme' ) ?> </div>
              </div>
				<?php
					if ( $the_query->have_posts() )
					{
						while ( $the_query->have_posts() ) 
						{
							$the_query->the_post();
							$pid = get_the_ID();
							$posted_date = get_the_date(get_option( 'date_format' ), $pid );
				  
							?>
							  <div class="pro-box">
								<div class="pro-coulmn pro-title">
									<h4 class="pro-name">
										<a href="<?php  echo esc_url(get_permalink()); ?>"><?php echo	esc_html(get_the_title()); ?></a>
									</h4>
									<span class="pro-meta-box">
										<span class="pro-meta">
											<i class="far fa-clock"></i> <?php /*echo	esc_html(get_the_content());*/ echo	esc_html(substr(get_the_content(),0,40)).'.....'; ?>
										</span>
									</span>
									<span class="pro-btns">
										<a href="<?php echo esc_attr(get_permalink($exertio_theme_options['user_dashboard_page']));?>?ext=create-addon&aid=<?php echo esc_html($pid); ?>" class="btn btn-inverse-primary btn-sm"> <i class="far fa-edit"></i> <?php echo esc_html__( 'Edit', 'exertio_theme' ); ?></a>
										<a href="javascript:void(0)" class="btn btn-inverse-danger btn-sm remove_addon" data-pid="<?php echo esc_attr($pid); ?>"> <i class="far fa-times-circle"></i> <?php echo esc_html__( 'Remove', 'exertio_theme' ); ?></a>
									</span>
								</div>
								<div class="pro-coulmn">
									<i class="far fa-clock"></i> <?php echo	esc_html($posted_date); ?>
								</div>
								<div class="pro-coulmn">
                                	<?php echo esc_attr($exertio_theme_options['fl_currency']).' '.esc_html(get_post_meta( $pid, '_addon_price', true )); ?>
								</div>
							  </div>
						  
							<?php
						}
						
						fl_pagination($the_query);
					}
					else
					{
						?>
                        <div class="nothing-found">
                            <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo esc_html__( 'No Addons found', 'exertio_theme' ) ?> ">
                            <h3><?php echo esc_html__( 'Sorry!!! No Addons Found', 'exertio_theme' ) ?></h3>
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
