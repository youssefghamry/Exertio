<?php
$alt_id = '';
$current_user_id = get_current_user_id();

$emp_id = get_user_meta( $current_user_id, 'employer_id', true );
$fl_id = get_user_meta( $current_user_id, 'freelancer_id', true );
if ( get_query_var( 'paged' ) ) {
  $paged = get_query_var( 'paged' );
} else if ( get_query_var( 'page' ) ) {

  $paged = get_query_var( 'page' );
} else {
  $paged = 1;
}
if ( is_user_logged_in() ) {


  // The Query
  $the_query = new WP_Query(
    array(

      'post_type' => 'disputes',
      'paged' => $paged,
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',

      'meta_query' => array(

        'relation' => 'OR',

        array(
          'key' => '_dispute_creater_user_id',
          'value' => array( $fl_id, $emp_id ),
          'compare' => 'IN',
          'type' => 'numeric',
        ),

        array(
          'key' => '_dispute_against_user_id',
          'value' => array( $fl_id, $emp_id ),
          'compare' => 'IN',
          'type' => 'numeric',
        ),

      )
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
				<h2><?php echo esc_html__('My Disputes','exertio_theme'); ?></h2>
				<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
					<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
					<?php echo exertio_dashboard_extention_return(); ?>
				</div>
			  </div>
			</div>
			<div class="d-flex justify-content-between align-items-end flex-wrap">
                <button class="btn btn-theme-secondary mt-2 mr-1 mt-xl-0" data-toggle="modal" data-target="#dispute-modal-service"><?php echo esc_html__('Create Service Dispute','exertio_theme'); ?></button>
                <button class="btn btn-theme-secondary mt-2 mt-xl-0" data-toggle="modal" data-target="#dispute-modal"><?php echo esc_html__('Create Project Dispute','exertio_theme'); ?></button>
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
              <div class="pro-coulmn"><?php echo esc_html__( 'Dispute title', 'exertio_theme' ); ?> </div>
              <div class="pro-coulmn"><?php echo esc_html__( 'Project/Services', 'exertio_theme' ); ?> </div>
              <div class="pro-coulmn"><?php echo esc_html__( 'Date', 'exertio_theme' ); ?> </div>
              <div class="pro-coulmn"><?php echo esc_html__( 'Status', 'exertio_theme' ); ?> </div>
            </div>
            <?php
            if ( $the_query->have_posts() ) {
              while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $pid = get_the_ID();
                $project_id = get_post_meta( $pid, '_project_id', true );
                $service_id = get_post_meta( $pid, '_service_id', true );

                $dispute_owner = get_post_field( 'post_author', $pid );
                $other_user_id = '';
                if ( $dispute_owner == $current_user_id ) {
                  $other_user_id = get_post_meta( $pid, '_dispute_against_user_id', true );
                } else {
                  $other_user_id = get_post_meta( $pid, '_dispute_creater_user_id', true );
                }
                ?>
                 <?php if ($project_id != '') {?>
            <div class="pro-box">
              <div class="pro-coulmn pro-title"> <h4 class="pro-name"><a href="<?php get_template_part( '' );?>?ext=dispute-detail&dispute-id=<?php echo esc_html($pid); ?>"><?php echo esc_html(get_the_title()); ?></a> </h4><small>(
                <?php
                $type = get_post_meta( $project_id, '_project_type', true );
                if ( $type == 'fixed' || $type == 1 ) {
					$type_text = esc_html__( 'Fixed', 'exertio_theme' );
                  echo esc_html( fl_price_separator( get_post_meta( $project_id, '_project_cost', true ) ) . '/' . $type_text );
                } else if ( $type == 'hourly' || $type == 2) {
					$type_text = esc_html__( 'Hourly', 'exertio_theme' );
                  echo esc_html( fl_price_separator( get_post_meta( $project_id, '_project_cost', true ) ) . ' ' . $type_text );
                }
                ?>
                )</small> </div>
              <div class="pro-coulmn"> <a href="<?php  echo esc_url(get_permalink($project_id)); ?>"><?php echo esc_html(get_the_title($project_id)).' <small>('.exertio_get_username('freelancer', $other_user_id).')</small>'; ?></a> </div>
              <div class="pro-coulmn">
                <?php  echo date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) ) ; ?>
              </div>
              <div class="pro-coulmn">
                <?php
                $badge_color = '';
                $status = get_post_meta( $pid, '_dispute_status', true );
                if ( $status == 'ongoing' ) {
                  $badge_color = 'btn-inverse-warning';
                } else if ( $status == 'resolved' ) {
                  $badge_color = 'btn-inverse-success';
                }
                ?>
                <span class="badge btn <?php echo esc_html($badge_color); ?>"> <?php echo esc_html($status); ?> </span> </div>
            </div>
                  <?php }else {?>
                  <div class="pro-box">
                      <div class="pro-coulmn pro-title"> <h4 class="pro-name"><a href="<?php get_template_part( '' );?>?ext=dispute-detail&dispute-id=<?php echo esc_html($pid); ?>"><?php echo esc_html(get_the_title()); ?></a> </h4><small>(
                              <?php
                              $buyer_id = get_user_meta( $current_user_id, 'employer_id' , true );
                              global $wpdb;
                              $table = EXERTIO_PURCHASED_SERVICES_TBL;
                              $query = "SELECT * FROM ".$table." WHERE `service_id` = '" . $service_id . "' ORDER BY timestamp DESC";
                              $result = $wpdb->get_results($query, ARRAY_A );
                              foreach( $result as $results )
                              {
                                  $total_price = $results['total_price'] ? $results['total_price'] : '';
                              }
                              echo fl_price_separator($total_price);
                              ?>
                              )</small> </div>
                      <div class="pro-coulmn"> <a href="<?php  echo esc_url(get_permalink($service_id)); ?>"><?php echo esc_html(get_the_title($service_id)).' <small>('.exertio_get_username('freelancer', $other_user_id).')</small>'; ?></a> </div>
                      <div class="pro-coulmn">
                          <?php  echo date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) ) ; ?>
                      </div>
                      <div class="pro-coulmn">
                          <?php
                          $badge_color = '';
                          $status = get_post_meta( $pid, '_dispute_status', true );
                          if ( $status == 'ongoing' ) {
                              $badge_color = 'btn-inverse-warning';
                          } else if ( $status == 'resolved' ) {
                              $badge_color = 'btn-inverse-success';
                          }
                          ?>
                          <span class="badge btn <?php echo esc_html($badge_color); ?>"> <?php echo esc_html($status); ?> </span> </div>
                  </div>
                    <?php } ?>
            <?php
            }
            fl_pagination( $the_query );

            wp_reset_postdata();
            }
            else {
              ?>
            <div class="nothing-found"> <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
              <h3><?php echo esc_html__( 'Sorry!!! No Dispute Found', 'exertio_theme' ) ?></h3>
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
<div class="modal fade" id="dispute-modal" tabindex="-1" role="dialog" aria-labelledby="dispute-modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="stretch-card">
          <div class="deposit-box card">
            <div class="depoist-header">
              <div class="icon"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/law.png" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
              <div class="deposit-header-text">
                <h3> <?php echo esc_html__('Project Dispute ','exertio_theme'); ?></h3>
                <p><?php echo esc_html__('Provide detail as much as you can','exertio_theme'); ?></p>
              </div>
            </div>
            <div class="deposit-body">
              <form id="dispute-project-form">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label> <?php echo esc_html__('Select Project','exertio_theme'); ?></label>
                    <?php echo fl_get_all_project_services(); ?> </div>
                  <div class="form-group col-md-12">
                    <label> <?php echo esc_html__('Tell us what your dispute is about','exertio_theme'); ?></label>
                    <input type="text" class="form-control" name="dispute_title" required data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>" >
                  </div>
                  <div class="form-group col-md-12">
                    <label> <?php echo esc_html__('Description','exertio_theme'); ?></label>
                    <textarea class="form-control" name="dispute_description" rows="3" required data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>"></textarea>
                    <p><?php echo esc_html__(' Write brief description here','exertio_theme'); ?></p>
                  </div>
                </div>
              </form>
            </div>
            <div class="deposit-footer">
              <button type="button" id="dispute-project-btn" class="btn-loading"> <?php echo esc_html__('Submit Dispute','exertio_theme'); ?>
              <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
              </button>
              <input type="hidden" id="fl_dispute_nonce" value="<?php echo wp_create_nonce('fl_dispute_secure'); ?>"  />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    <div class="modal fade" id="dispute-modal-service" tabindex="-1" role="dialog" aria-labelledby="dispute-modal-service" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="stretch-card">
                        <div class="deposit-box card">
                            <div class="depoist-header">
                                <div class="icon"> <img src="<?php echo get_template_directory_uri(); ?>/images/icons/law.png" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid"> </div>
                                <div class="deposit-header-text">
                                    <h3> <?php echo esc_html__('Service Dispute ','exertio_theme'); ?></h3>
                                    <p><?php echo esc_html__('Provide detail as much as you can','exertio_theme'); ?></p>
                                </div>
                            </div>
                            <div class="deposit-body">
                                <form id="dispute-service-form">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label> <?php echo esc_html__('Select Service','exertio_theme'); ?></label>
                                            <?php  print_r(fl_get_all_services()); ?> </div>
                                        <div class="form-group col-md-12">
                                            <label> <?php echo esc_html__('Tell us what your dispute is about','exertio_theme'); ?></label>
                                            <input type="text" class="form-control" name="dispute_title" required data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>" >
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> <?php echo esc_html__('Description','exertio_theme'); ?></label>
                                            <textarea class="form-control" name="dispute_description" rows="3" required data-smk-msg="<?php echo esc_attr__('This field is required','exertio_theme'); ?>"></textarea>
                                            <p><?php echo esc_html__(' Write brief description here','exertio_theme'); ?></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="deposit-footer">
                                <button type="button" id="dispute-service-btn" class="btn-loading"> <?php echo esc_html__('Submit Dispute','exertio_theme'); ?>
                                    <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                </button>
                                <input type="hidden" id="fl_dispute_nonce" value="<?php echo wp_create_nonce('fl_dispute_secure'); ?>"  />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
  echo exertio_redirect( home_url( '/' ) );
}
?>