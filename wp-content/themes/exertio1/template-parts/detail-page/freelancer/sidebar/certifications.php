<?php
$fl_id = get_the_ID();
global $exertio_theme_options;
$award_jsons =  json_decode(stripslashes(get_post_meta($fl_id, '_freelancer_awards', true)), true);
if(!empty($award_jsons))
{
?>
	<div class="fr-recent-certification sidebar-box">
		<?php
		if(isset($exertio_theme_options['detail_sidebar_certificates']) && $exertio_theme_options['detail_sidebar_certificates'] != '')
		{
			?>
			<div class="sidebar-heading">
				<h3><?php echo esc_html($exertio_theme_options['detail_sidebar_certificates']); ?></h3>
			</div>
			<?php
		}
		?>
		<ul>
		<?php
			foreach($award_jsons as $awards)
			{
				$award_img_url = $img_html = '';
				if(isset($awards['award_img']) && $awards['award_img'] != '')
				{
					$award_img_url =  wp_get_attachment_image_src($awards['award_img'], 'thumbnail');
					$award_img_url_full =  wp_get_attachment_image_src($awards['award_img'], 'full');
					$img_html = '<div class="fr-recent-us-profile"><a data-fancybox="awards" href="'.esc_url($award_img_url_full[0]).'">  <img src="'.esc_url($award_img_url[0]).'" alt="'.esc_attr(get_post_meta($awards['award_img'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a> </div>';
				}
				$new_date =  strtotime(str_replace("/", "-", $awards['award_date']));
				?>
				<li>
				  <?php echo wp_return_echo($img_html); ?>
					<div class="fr-recent-us-skills">
						<p><?php echo esc_html($awards['award_name']); ?></p>
						<span><?php echo date_i18n( get_option( 'date_format' ), $new_date );  ?></span>
					</div>
				</li>
				<?php
			}
		?>
		</ul>
	</div>
<?php
}
?>