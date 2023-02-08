<?php
$fl_id = get_the_ID();
$post_content = get_post($fl_id);
$content = $post_content->post_content;
global $exertio_theme_options;

?>
<div class="main-box fr-product-des-box">
  <div class="">
	<?php
    if(isset($exertio_theme_options['detail_desc_title']) && $exertio_theme_options['detail_desc_title'] != '')
	{
		?>
		<div class="heading-contents">
		  <h3><?php echo esc_html($exertio_theme_options['detail_desc_title']); ?></h3>
		</div>
		<?php
	}
	?>
    <?php echo wp_kses($content, exertio_allowed_html_tags()); ?>
  </div>
</div>
