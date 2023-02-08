<?php
$fl_id = get_the_ID();
$alt_id = '';
global $exertio_theme_options;
$reviews = get_freelancer_rating_detail($fl_id, 'project');
if($reviews != '')
{

?>
	<div class="main-box">
	  <div class="fr-recent-review-box">
		<?php
		if(isset($exertio_theme_options['detail_freelancer_reviews_title']) && $exertio_theme_options['detail_freelancer_reviews_title'] != '')
		{
			?>
			<div class="heading-contents">
			  <h3><?php echo esc_html($exertio_theme_options['detail_freelancer_reviews_title']); ?></h3>
			</div>
			<?php
		}
		?>
		<div class="fr-recent-container">
		<?php
			foreach ($reviews as $review)
			{
				$review_author = $review ->giver_id;
			?>
				<div class="show-reviews">
					<div class="fr-recent-content">
						<div class="reviews-header">
							<div class="fr-recent-review-profile"> <a href="<?php  echo esc_url(get_permalink($review_author)); ?>"><?php echo get_profile_img($review_author, "employer"); ?></a> </div>
							<div class="fr-recent-location-details">
								<a href="<?php  echo esc_url(get_permalink($review_author)); ?>">
									<h4><?php echo esc_html(get_post_meta( $review_author, '_employer_dispaly_name' , true )); ?></h4>
								</a>
								<ul>
									<li> <i class="fa fa-clock-o"></i><span><?php echo time_ago_function($review->timestamp); ?></span> </li>

								</ul>
							  </div>
							<div class="fr-recent-rating">
								<p><?php echo esc_html(number_format($review->star_avg,1)); ?></p>
								<span class="xm"><?php echo esc_html__('out of 5','exertio_theme');?></span>
							</div>

						</div>
						<p class="feedback"><?php echo esc_html($review->feedback); ?></p>
						<div class="individual-stars">
							<div class="individual-star-boxs">
								<label> <?php echo esc_html($exertio_theme_options['service_first_title']); ?></label>
								<span>
								<?php
									$total_stars_1 = $review->star_1;
									for($i =0; $i<5; $i++)
									{
										if($i<$total_stars_1){
											?>
											<i class="fa fa-star colored"></i>
											<?php
										}
										else
										{
											?>
											<i class="fa fa-star"></i>
											<?php
										}
									}
								?>
								</span>
							</div>
							<div class="individual-star-boxs">
								<label>  <?php echo esc_html($exertio_theme_options['service_second_title']); ?></label>
								<span>
									<?php
									$total_stars_2 = $review->star_2;
									for($i =0; $i<5; $i++)
									{
										if($i<$total_stars_2){
											?>
											<i class="fa fa-star colored"></i>
											<?php
										}
										else
										{
											?>
											<i class="fa fa-star"></i>
											<?php
										}
									}
								?>
								</span>
							</div>
							<div class="individual-star-boxs">
								<label>  <?php echo esc_html($exertio_theme_options['service_third_title']); ?></label>
								<span>
									<?php
									$total_stars_3 = $review->star_3;
									for($i =0; $i<5; $i++)
									{
										if($i<$total_stars_3){
											?>
											<i class="fa fa-star colored"></i>
											<?php
										}
										else
										{
											?>
											<i class="fa fa-star"></i>
											<?php
										}
									}
								?>
								</span>
							</div>
						</div>
					</div>
									<!--<div class="fr-recent-details-area">
									  <p>Lorem dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean maa. Cum sociis natoque penatibus et magnis dis parturient mones, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium</p>
									</div>-->
				</div>
			<?php
			}
		?>
		</div>
		</div>
	</div>
<?php
}
?>
