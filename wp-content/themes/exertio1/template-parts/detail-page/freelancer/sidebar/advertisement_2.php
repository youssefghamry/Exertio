<?php
global $exertio_theme_options;
if(isset($exertio_theme_options['detail_page_sidebar_ad_2']) && $exertio_theme_options['detail_page_sidebar_ad_2'] != '')
{
	?>
    <div class="fr-product-progress sidebar-box">
      <?php echo wp_return_echo($exertio_theme_options['detail_page_sidebar_ad_2']); ?>
    </div>
	<?php
}
?>
