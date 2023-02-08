<?php
$fl_id = get_the_ID();
global $exertio_theme_options;
$alt_id = '';
$project_jsons =  json_decode(get_post_meta($fl_id, '_freelancer_projects', true), true);
if(!empty($project_jsons))
{
?>
	<div class="main-box">
		<?php
		if(isset($exertio_theme_options['detail_projects_title']) && $exertio_theme_options['detail_projects_title'] != '')
		{
			?>
			<div class="heading-contents">
			  <h3><?php echo esc_html($exertio_theme_options['detail_projects_title']); ?></h3>
			</div>
			<?php
		}
		?>
	  <div class="fr-recent-model">
	  <ul>
		<?php
				foreach($project_jsons as $project_json)
				{
					$project_img_url = wp_get_attachment_url( $project_json['project_img'] );
					//$img_thumb = wp_get_attachment_image_src($project_json['project_img'], 'thumbnail');
		?><li>
					<div  class="fancy-model">
						<a data-fancybox="portfolio" href="<?php echo esc_url($project_img_url); ?>" data-caption="<span class='project-title'><?php echo esc_html($project_json['project_name']); ?></span> <span><?php echo esc_url($project_json['project_url']); ?></span>" data-wheel="false"> <img class="img-fluid" src="<?php echo esc_url($project_img_url); ?>" alt="<?php esc_attr(get_post_meta($project_json['project_img'], '_wp_attachment_image_alt', TRUE)); ?>"></a>
					</div>
					<div class="figcaption">
						<h6><a href="<?php echo esc_url($project_json['project_url']); ?>" target="_blank">	<?php echo esc_html($project_json['project_name']); ?></a></h6>
					</div>
					</li><?php
				}
		  ?>
		  </ul>
	  </div>
	</div>
<?php
}
?>