<?php 
$pid = get_the_ID();
$freelancer_title = '';
$current_user_id = get_current_user_id();

	$freelancer_title = __('Hire Freelancer','exertio_theme');
?>
<div class="modal fade forget_pwd" id="hire-freelancer-modal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="modal-from hire-freelancer-form" method="POST" id="hire-freelancer-form">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo esc_html($freelancer_title); ?></h5>
          <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
			<?php
			if( is_user_logged_in() )
			{
			?>
			<div class="fr-report-form">
				<div class="form-group">
					<label><?php echo esc_html__('Choose a Project','exertio_theme'); ?></label>
					<?php
						if( is_user_logged_in() )
						{
							$the_query = new WP_Query( 
														array( 
																'author__in' => array( $current_user_id ) ,
																'post_type' =>'projects',
																'post_status'     => 'publish'	,
																'orderby' => 'date',
																'order'   => 'DESC',												
																)
															);

							$total_count = $the_query->found_posts;
							$report_category = '<select name="project-id" class="form-control general_select">';
							if ( $the_query->have_posts() )
							{
								while ( $the_query->have_posts() ) 
								{
									$the_query->the_post();
									$project_id = get_the_ID();

									$report_category .= '<option value="'. esc_attr( $project_id ) .'">
											'. esc_html( get_the_title($project_id) ) .'</option>';

								}
							}
							else
							{
								$report_category .= '<option value="">'. __('No published project available','exertio_theme').'</option>';
							}
								$report_category.='</select>';
								echo wp_return_echo($report_category);
						}
					?>
				</div>
				<div class="form-group">
					<input type="hidden" id="fl_hire_freelancer_nonce" value="<?php echo wp_create_nonce('fl_hire_freelancer__secure'); ?>"  />
					<a href="javascript:void(0)" id="btn-hire-freelancer" class="btn btn-theme btn-loading" data-freelancer-id="<?php echo esc_attr($pid); ?>"><?php echo esc_html__("Send Invitation", 'exertio_theme'); ?><span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span></a>
				</div>
			</div>
        	<?php
			}
			else
			{
				?>
				<div class="form-group">
					<p><?php echo esc_html__("Please login to send invitation", 'exertio_theme'); ?></p>
				</div>
				<?php
			}
			?>
        </div>
      </form>
    </div>
  </div>
</div>