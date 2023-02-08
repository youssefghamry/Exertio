<?php
if (have_posts())
{
	while ( have_posts() )
	{ 
		the_post();
		$post_id = get_the_ID();
			?>
		<div class="blog-detial-main-area post-excerpt post-desc">
				<?php
				$blog_ad_1 = fl_framework_get_options('blog_ad_1');
				if(isset($blog_ad_1) && $blog_ad_1 !='')
				{
				?>
				  <div class="fr-blog-banner"> <?php echo wp_return_echo($blog_ad_1); ?> </div>
				<?php
				}
				?>
			  <div class="fr-blog-f-details">
				<?php
				if ( has_post_thumbnail( $post_id ) )
				{
					?>
				<div class="fr-blog-f-product"> <?php echo exertio_get_feature_image($post_id, 'full'); ?> </div>
				<?php
				}
				?>
				<div class="fr-latest-box">
				  <div class="fr-latest-sm">
					<div class="fr-latest-content">
					  <div class="fr-latest-style-detai">
						<ul>
						  <li>
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
							<div class="fr-latest-profile"><?php echo (get_avatar( get_the_author_meta('ID'), 40)); ?><span><?php the_author(); ?></span></div>
							</a>
							</li>
						  <li>
							<div class="fr-latest-profile"><i class="fa fa-calendar"></i><span><?php echo get_the_date( 'F j, Y', $post_id ); ?></span> </div>
						  </li>
						  <?php
							$comments = get_comments_number();
							$comment_text ='';
							if($comments >1)
							{
								$comment_text = esc_html(get_comments_number()).esc_html__(' Comments', 'exertio_theme');
							}
							else if ($comments == 0)
							{
								$comment_text = esc_html__(' No Comments', 'exertio_theme');
							}
							else
							{
								$comment_text = esc_html(get_comments_number()).esc_html__(' Comment', 'exertio_theme');
							}
						  ?>
						  <li class="fr-latest-profile"><i class="far fa-comment"></i> <span><?php echo esc_html($comment_text);  ?></span></li>
						</ul>
					  </div>
					</div>
					<div class="fr-latest-container">
					  <?php the_content(); ?>
					  <?php
						wp_link_pages( array(
						'before'      => '<div class="page_with_pagination"><div class="page-links">','after' => '</div></div>','next_or_number' => 'number','link_before' => '<span class="no">','link_after'  => '</span>') );
					?>
					<div class="clearfix"></div>
					</div>
					<div class="fr-latest-tags-2">
					  <div class="fr-latest-t-content">
						<div class="fr-latest-t-box">
							<?php 
								$before = "<span>".esc_html__(' Tags', 'exertio_theme')."</span>";
								$seperator = '';
								$after = '';
								
								the_tags( $before, $seperator, $after );
							?>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			  
				<?php
				$blog_ad_2 = fl_framework_get_options('blog_ad_2');
				if(isset($blog_ad_2) && $blog_ad_2 !='')
				{
				?>
				  <div class="fr-blog-banner"><?php echo wp_return_echo($blog_ad_2); ?></div>
				<?php
				}
				?>
				<?php comments_template('', true); ?>
		</div>
	
	<?php
	} 
}
else
{
	get_template_part( 'template-parts/blog/content', 'none' );
}
