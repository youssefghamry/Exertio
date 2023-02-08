<?php
global $exertio_theme_options;
$fl_id = get_the_ID();
$author_id = get_post_field( 'post_author', $fl_id );
$banner_img_id = get_post_meta( $fl_id, '_freelancer_banner_id', true );
$banner_img = wp_get_attachment_image_src( $banner_img_id, 'full' );
$cover_img ='';
if(empty($banner_img ))
{
	$cover_img = "style='background-image:url(".$exertio_theme_options['freelancer_df_cover']['url'].")'";
}
else
{
	$cover_img = "style='background-image:url(".$banner_img[0].")'";
}
?> 
<section class="fr-hero-theme freelancer" <?php echo wp_return_echo($cover_img); ?>> </section>
<section class="fr-hero-detail style-1">
  <div class="container">
    <div class="row custom-product">
      <div class="col-lg-9 col-xl-9 col-xs-12 col-md-9 col-sm-12">
        <div class="fr-hero-details-content">
          <div class="fr-hero-details-products"> <?php echo get_profile_img($fl_id, 'freelancer', 'full'); ?></div>
          <div class="fr-hero-details-information">
            <span class="title"><?php echo exertio_get_username('freelancer', $fl_id, 'badge', 'left'); ?></span>
          	<h1 class="name"><?php echo esc_html(get_post_meta( $fl_id, '_freelancer_tagline' , true )); ?></h1>
            <div class="fr-hero-m-deails">
              <ul>
              	<?php
				if($exertio_theme_options['fl_location'] == 3)
				{
					
				}
				else
				{
				?>
                <li> <span><?php echo get_term_names('freelancer-locations', '_freelancer_location', $fl_id, '', ',' ); ?></span> </li>
                <?php
				}
				?>
				<li> <span> <?php echo esc_html__('Member since ','exertio_theme').get_the_date(); ?></span> </li>
                <li><span><?php echo get_rating($fl_id, ''); ?></span> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xl-3 col-xs-12 col-md-3 col-sm-12">
        <div class="fr-hero-hire">
        	<?php
				if($exertio_theme_options['fl_hourly_rate'] == 3)
				{
					
				}
				else
				{
					$hourly_rate = get_post_meta($fl_id, '_freelancer_hourly_rate', true);
					if($hourly_rate != '')
					{
					?>
					  <div class="fr-hero-short-list">
						<p><?php echo fl_price_separator($hourly_rate, 'html'); ?></p>
						<span class="type">(<?php echo esc_html__('per hour','exertio_theme'); ?>)</span>
					  </div>
				  <?php
					}
				}
			?>
          <div class="fr-hero-short-list-2">
            <div class="fr-hero-hire-content">
            	<?php
					$current_user_id = get_current_user_id();
					$saved_freelancer = get_user_meta($current_user_id, '_fl_follow_id_'.$fl_id, true);
					$active_saved ='';
					$save_text = esc_html__('Follow Freelancer','exertio_theme');
					if(isset($saved_freelancer) && $saved_freelancer != '')
					{
						$active_saved = 'active';
						$save_text = esc_html__('Already Following','exertio_theme');	
					}
				?>
            	<a href="javascript:void(0)" class="follow-freelancer protip" data-fid="<?php echo esc_html($fl_id); ?>" data-pt-position="top" data-pt-scheme="black" data-pt-title="<?php echo esc_attr($save_text); ?>">
                	<i class="fa fa-heart <?php echo esc_attr($active_saved); ?>"></i>
                </a>
				<?php
				if(isset($exertio_theme_options['fl_email_hire_freelancer']) && $exertio_theme_options['fl_email_hire_freelancer'] == true)
				{
					?>
					<a href="javascript:void(0)" class="btn btn-theme hire-freelancer" data-bs-toggle="modal" data-bs-target="#hire-freelancer-modal"><?php echo esc_html($exertio_theme_options['fl_email_hire_freelancer_text']); ?></a>
					<?php
				}
				?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
		if(isset($exertio_theme_options['freelancer_states']) && $exertio_theme_options['freelancer_states'] == 2)
		{
	?>
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-xs-12 col-md-12 col-sm-12">
                    <div class="fr-hero-m-jobs-bottom">
                      <ul>
                      <?php
					  	$meta_query = array(
										'key'       => '_freelancer_assigned',
										'value'     => $fl_id,
										'compare'   => '=',
									);
					  ?>
                        <li> <span><small><?php echo exertio_get_posts_count('', 'projects', '', 'ongoing', $meta_query); ?></small> <?php echo esc_html__('ongoing Projects','exertio_theme'); ?></span> </li>
                        <li> <span><small><?php echo exertio_get_posts_count('', 'projects', '', 'completed', $meta_query); ?></small> <?php echo esc_html__('Completed Projects','exertio_theme'); ?></span> </li>
                        <li> <span><small><?php echo exertio_get_services_count($fl_id,'ongoing'); ?></small> <?php echo esc_html__('Services in Queue','exertio_theme'); ?></span> </li>
                        <li> <span><small><?php echo exertio_get_services_count($fl_id,'completed'); ?></small> <?php echo esc_html__('Competed Services','exertio_theme'); ?></span> </li>
                      </ul>
                    </div>
                </div>
            </div>
    <?php
		}
	?>
  </div>
</section>
