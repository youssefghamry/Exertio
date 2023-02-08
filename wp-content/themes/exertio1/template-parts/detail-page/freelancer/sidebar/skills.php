<?php
$fl_id = get_the_ID();
global $exertio_theme_options;
$alt_id = '';
$skills_json =  json_decode(stripslashes(get_post_meta($fl_id, '_freelancer_skills', true)), true);
if(!empty($skills_json))
{
?>
	<div class="fr-product-progress sidebar-box">
		<?php
		if(isset($exertio_theme_options['detail_sidebar_skills']) && $exertio_theme_options['detail_sidebar_skills'] != '')
		{
			?>
			<div class="sidebar-heading">
				<h3><?php echo esc_html($exertio_theme_options['detail_sidebar_skills']); ?></h3>
			</div>
			<?php
		}
		?>
	  <ul>
		<?php
			foreach($skills_json as $skills)
			{
				$skillsObject = get_term_by( 'id', $skills['skill'] , 'freelancer-skills' );
				$term_name = isset($term->name) ? $term->name : '' ;
				if($skillsObject != '')
				{
					$skillsTermName = $skillsObject->name;
					?>
					<li>
					  <div class="fr-product-progress-content">
						<p><?php echo esc_html($skillsTermName); ?></p>
                          <?php if(fl_framework_get_options('freelancer_skills_percentage') == 1){?>
						<span><?php echo esc_html($skills['percent']); ?>%</span> </div>
					  <div class="progress">
						<div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo esc_html($skills['percent']); ?>%" aria-valuenow="<?php echo esc_html($skills['percent']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
					  </div>
                    <?php } ?>
					</li>
					<?php
				}
			}
		?>
	  </ul>
	</div>
<?php
}
?>