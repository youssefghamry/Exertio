<?php
get_header();
$actionbBar = fl_framework_get_options('action_bar');
$actionbar_space = '';
if(isset($actionbBar) && $actionbBar == 1)
{
	$actionbar_space = 'actionbar_space';
}
?>
<section class="fr-latest-blog fr-latest-blog-2 bg-gray-light-color exertia-padding <?php echo esc_attr($actionbar_space); ?>">
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
        
          <div class="<?php echo esc_attr($blog_type); ?>">
            <?php get_template_part( 'template-parts/blog/blog','detail' ); ?> 
          </div>
            <?php
            if(isset($sidebar_opt) && $sidebar_opt == 'right')
            {
                get_sidebar();
            }
			else if(isset($sidebar_opt) && $sidebar_opt == '' && is_active_sidebar( 'exertia-blog-widget' ))
			{
				get_sidebar();
			}
            ?>
        </div>
    </div>
</section>
<?php
?>
<?php
if(isset($exertio_theme_options['footer_type'])) { $footer_type  = $exertio_theme_options['footer_type']; } else { $footer_type  = 0; }
if($footer_type  ==  1) {
    if($footer_type  ==  1 && in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins'))))
    {
        elementor_theme_do_location('footer');
    }else{
        get_footer();
    }
}else {
    get_template_part('footer');
}
?>