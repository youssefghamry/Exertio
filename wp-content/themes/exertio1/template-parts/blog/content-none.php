<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Exertio
 */

?>
<div class="col-xl-12 col-lg-12 col-sm-12 col-12">
    <div class="blog-nothing-found">
           <h3><?php echo esc_html__('Nothing Found','exertio_theme'); ?></h3>
           <p><?php echo esc_html__('Nothing matched your search term. Please try again with some different keywords.','exertio_theme'); ?></p>
           
           <form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
				<div class="fl-search-blog"><div class="input-group stylish-input-group">
					
					<input type="search" class="form-control" placeholder="<?php echo esc_attr__( 'Your search term', 'exertio_theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" id="s"/>
				<span class="input-group-append"><button class="blog-search-btn" type="submit">  <i class="fa fa-search"></i> </button></span></div></div>
				<input type="submit" class="search-submit" value="Search" />
			</form>
            
            <a href="<?php echo home_url( '/' ); ?> " class="btn btn-theme">  <?php echo esc_html__('Back to home','exertio_theme'); ?></a>
    </div>
</div>