<?php
get_header();
$actionbBar = fl_framework_get_options('action_bar');
$actionbar_space = '';
if(isset($actionbBar) && $actionbBar == 1)
{
	$actionbar_space = 'actionbar_space';
}
?>
<section class="fr-latest-blog bg-gray-light-color exertia-padding <?php echo esc_attr($actionbar_space); ?>">
  <div class="container">
    <div class="row">
		<?php
        $sidebar_opt = fl_framework_get_options('blog_sidebar');
        $blog_type	=	'col-lg-8 col-xl-8 col-xs-12 col-md-12 col-sm-12';
        if( isset( $sidebar_opt ) && $sidebar_opt == 'no-sidebar' )
        {
            $blog_type	=	'col-lg-12 col-xl-12 col-xs-12 col-md-12 col-sm-12';	
        }
        else
        {
            $blog_type	=	'col-lg-8 col-xl-8 col-xs-12 col-md-12 col-sm-12';	
        }
        
        if(isset($sidebar_opt) && $sidebar_opt == 'left')
        {
             get_sidebar();
        }
		if ( !is_active_sidebar( 'exertia-blog-widget' ) ) {
			$blog_type	=	'col-lg-12 col-xl-12 col-xs-12 col-md-12 col-sm-12';	
		}
        ?>
        
        <div class="<?php echo esc_attr($blog_type); ?> ">
            <div class="row grid">
                <?php get_template_part( 'template-parts/blog/blog','loop' ); ?>  
            </div>
            <div class="row">
            <div class="col-xl-12 col-xs-12 col-sm-12">
                <div class="fr-latest-pagination">
                  <?php fl_blog_pagination(); ?>
                </div>
              </div>
            </div>
        </div>
        
        <?php
        if(isset($sidebar_opt) && $sidebar_opt == 'right')
        {
            get_sidebar();
        }
        ?>
    </div>
  </div>
</section>
<?php get_template_part('footer'); ?>