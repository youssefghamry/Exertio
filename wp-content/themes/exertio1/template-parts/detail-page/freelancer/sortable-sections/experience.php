<?php
$fl_id = get_the_ID();
$alt_id = '';
global $exertio_theme_options;
$expe_jsons =  json_decode(stripslashes(get_post_meta($fl_id, '_freelancer_experience', true)), true);
if(!empty($expe_jsons))
{
?>
	<div class="main-box">
		<?php
		if(isset($exertio_theme_options['detail_exp_title']) && $exertio_theme_options['detail_exp_title'] != '')
		{
			?>
			<div class="heading-contents">
			  <h3><?php echo esc_html($exertio_theme_options['detail_exp_title']); ?></h3>
			</div>
			<?php
		}
		?>
			<div class="fr-expertise-content">
				<?php
						foreach($expe_jsons as $expe_json)
						{
					?>
							<div class="fr-expertise-product">
								<div class="fr-expertise-product2"> <i class="fa fa-long-arrow-right"></i> </div>
								<div class="fr-expertise-details">
								  <h4><?php echo esc_html($expe_json['expe_name']); ?></h4>
								  <ul class="experties-meta">
									<li><span> <?php echo esc_html($expe_json['expe_company_name']); ?></span> </li>
									<?php
									if($expe_json['expe_start_date'] != '')
									{
									?>
										<li>
											<span>
												<?php echo date_i18n( get_option( 'date_format' ), strtotime( $expe_json['expe_start_date'] ) ); ?> - <?php if($expe_json['expe_end_date'] == '') { echo esc_html__('continue','exertio_theme');} else { echo date_i18n( get_option( 'date_format' ), strtotime( $expe_json['expe_end_date'] ) ); } ?>
											</span>
										</li>
									<?php
									}
									?>
								  </ul>
								  <p><?php echo esc_html($expe_json['expe_details']); ?></p>
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