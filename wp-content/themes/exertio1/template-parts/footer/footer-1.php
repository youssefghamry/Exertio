<?php
$footer_logo = fl_framework_get_options('exertio_footer_logo');
if(isset($footer_logo) && $footer_logo != '')
{
	$footer_logo_url = $footer_logo['url'];
}
else
{
	$footer_logo_url = get_template_directory_uri().'/images/logo-dashboard.svg';
}
$none = '';
if(fl_framework_get_options('project_sidebar_layout') == '2' && is_page_template( 'page-project-search.php' ) ){
    $none = 'none';
}
$img_id ='';
$actionbBar = fl_framework_get_options('action_bar');
if(isset($actionbBar) && $actionbBar == 1)
{
	$action_btn = fl_framework_get_options('action_btn_text');
	if(isset($action_btn) && $action_btn == '')
	{
		$action_cols = 'col-xl-12 col-lg-12';
	}
	else
	{
		$action_cols = 'col-xl-8 col-lg-8';
	}
	if(!is_page_template( 'page-register.php' ) && !is_page_template( 'page-login.php' ))
	{
	?>
		<section class="fr-bg-style2 <?php echo esc_attr($none);?>">
		  <div class="container">
			<div class="row">
			  <div class="col-xl-12 col-xs-12 col-sm-12 col-md-12">
				<div class="fr-bg-style">
				  <div class="row">
					<div class="<?php echo esc_attr($action_cols); ?>">
					  <div class="fr-gt-content">
						<h3><?php echo esc_html(fl_framework_get_options('action_heading_text')); ?></h3>
						<p><?php echo esc_html(fl_framework_get_options('action_content')); ?></p>
					  </div>
					</div>
					<?php
					if($action_btn != '')
					{
					?>
					<div class="col-xl-4 col-lg-4 align-self-center">
					  <div class="fr-gt-btn"> <a href="<?php echo get_the_permalink(fl_framework_get_options('action_btn_link')); ?>" class="btn btn-theme"><?php echo esc_html(fl_framework_get_options('action_btn_text')); ?></a> </div>
					</div>
					<?php
					}
					?>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</section>
	<?php
	}
}
?>
<section class="fr-footer padding-top-80 <?php echo esc_attr($none);?>">
  <div class="container">
    <div class="row padding-bottom-80">
      <div class="col-xxl-4 col-xl-3 col-lg-12 col-12 col-sm-12 col-md-12">
        <div class="fr-footer-details fr-footer-content"> <img src="<?php echo esc_url($footer_logo_url); ?>" alt="<?php echo get_post_meta($img_id, '_wp_attachment_image_alt', TRUE); ?>" class="img-fluid">
          <p><?php echo esc_html(fl_framework_get_options('website_footer_content')); ?></p>
        </div>
        <?php
		if(fl_framework_get_options('footer_facebook_link') == '' && fl_framework_get_options('footer_twitter_link') == '' && fl_framework_get_options('footer_linkedin_link') == '' && fl_framework_get_options('footer_youtube_link') == '' && fl_framework_get_options('footer_instagram_link') == '' )
		{
		}
		else
		{
		?>
            <div class="fr-footer-icons">
                <ul>
                <?php
				if(fl_framework_get_options('footer_facebook_link') != ''){?><li> <a href="<?php echo esc_url(fl_framework_get_options('footer_facebook_link')); ?>"><i class="fab fa-facebook-f"></i></a> </li><?php }
				if(fl_framework_get_options('footer_twitter_link') != ''){?><li> <a href="<?php echo esc_url(fl_framework_get_options('footer_twitter_link')); ?>"><i class="fab fa-twitter"></i></a> </li><?php }
				if(fl_framework_get_options('footer_linkedin_link') != ''){?><li> <a href="<?php echo esc_url(fl_framework_get_options('footer_linkedin_link')); ?>"><i class="fab fa-linkedin-in"></i></a> </li><?php }
				if(fl_framework_get_options('footer_youtube_link') != ''){?><li> <a href="<?php echo esc_url(fl_framework_get_options('footer_youtube_link')); ?>"><i class="fab fa-youtube"></i></a> </li><?php }
				if(fl_framework_get_options('footer_instagram_link') != ''){?><li> <a href="<?php echo esc_url(fl_framework_get_options('footer_instagram_link')); ?>"><i class="fab fa-instagram"></i></a> </li><?php } ?>
                </ul>
            </div>
      <?php
		}
		?>
      </div>
      <div class="col-xxl-3 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4">
        <div class="fr-footer-content">
          <h3 class="fr-style-8"><?php echo esc_html(fl_framework_get_options('footer_project_locations_heading')); ?></h3>
          <ul>
          <?php
		  $project_locs = fl_framework_get_options('footer_project_locations');
		  if(isset($project_locs) && $project_locs != '')
		  {
			foreach($project_locs as $project_loc)
			{
				$prject_term = get_term($project_loc);
				if(!empty($prject_term) && ! is_wp_error($prject_term))
				{
					$project_location = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?location';
					echo '<li><a href="'.$project_location.'='.$prject_term->term_id.'">'.$prject_term->name.'</a></li>';
				}
			}
		  }
		  ?>
          </ul>
        </div>
      </div>
      <div class="col-xxl-3 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4">
        <div class="fr-footer-content">
          <h3 class="fr-style-8"><?php echo esc_html(fl_framework_get_options('footer_services_locations_heading')); ?></h3>
          <ul>
			<?php
            $services_locs = fl_framework_get_options('footer_services_locations');
			if(isset($services_locs) && $services_locs != '')
			{
				foreach($services_locs as $services_loc)
				{
					$service_term = get_term($services_loc);
					if(!empty($service_term) && ! is_wp_error($service_term))
					{
						$services_location = get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . '?location';
						echo '<li><a href="'.$services_location.'='.$service_term->term_id.'">'.$service_term->name.'</a></li>';
					}
				}
			}
            ?>
            </ul>
        </div>
      </div>
      <div class="col-xxl-2 col-lg-4 col-xl-3 col-xs-12 col-sm-6 col-md-4">
        <div class="fr-footer-content">
          <h3 class="fr-style-8"><?php echo esc_html(fl_framework_get_options('footer_links_heading')); ?></h3>
			<ul>
			<?php
            $footer_pages = fl_framework_get_options('footer_page_links');
			if(isset($footer_pages) && $footer_pages != '')
			{
				foreach($footer_pages as $footer_page)
				{

					echo '<li><a href="'.get_the_permalink($footer_page).'">'.get_the_title($footer_page).'</a></li>';
				}
			}
            ?>
            </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="fr-bottom">
    <?php echo fl_framework_get_options('footer_copyright_text'); ?>
  </div>
</section>