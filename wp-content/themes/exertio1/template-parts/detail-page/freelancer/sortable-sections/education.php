<?php
$fl_id = get_the_ID();
$alt_id = '';
global $exertio_theme_options;
$edu_jsons = json_decode( stripslashes( get_post_meta($fl_id, '_freelancer_education', true)), true );
if(!empty($edu_jsons))
{
?>
	<div class="main-box">
		<?php
		if(isset($exertio_theme_options['detail_edu_title']) && $exertio_theme_options['detail_edu_title'] != '')
		{
			?>
			<div class="heading-contents">
			  <h3><?php echo esc_html($exertio_theme_options['detail_edu_title']); ?></h3>
			</div>
			<?php
		}
		?>
			<div class="fr-expertise-content">
				<?php
						foreach($edu_jsons as $edu_json)
						{
					?>
							<div class="fr-expertise-product">
								<div class="fr-expertise-product2"> <i class="fa fa-long-arrow-right"></i> </div>
								<div class="fr-expertise-details">
								  <h4><?php echo esc_html($edu_json['edu_name']); ?></h4>
								  <ul class="experties-meta">
									<li><span> <?php echo esc_html($edu_json['edu_inst_name']); ?></span> </li>
									<?php
									if($edu_json['edu_start_date'] != '')
									{
									?>
										<li>
											<span>
												<?php echo date_i18n( get_option( 'date_format' ), strtotime( $edu_json['edu_start_date'] ) ); ?> - <?php if($edu_json['edu_end_date'] == '') { echo esc_html__('continue','exertio_theme');} else { echo date_i18n( get_option( 'date_format' ), strtotime( $edu_json['edu_end_date'] ) ); } ?>
											</span>
										</li>
									<?php
									}
									?>
								  </ul>
								  <p><?php echo esc_html($edu_json['edu_details']); ?></p>
								</div>
							</div>
					<?php
						}
				?>
			</div>
	</div>
<?php
}
?>