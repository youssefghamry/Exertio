<?php
get_template_part( 'template-parts/html','header' );  

if(is_page_template( 'page-profile.php' ))
{

}
	if(is_page_template( 'page-profile.php' ) || is_page_template( 'page-register.php' ) || is_page_template( 'page-home.php' ) || is_page_template( 'page-login.php' ) ||  is_singular( array( 'employer', 'freelancer', 'services', 'projects' ) ))
	{
		
	}
	else
	{
		$bread_image = $bg ='';
		if(fl_framework_get_options('default_breadcrumb_image') != '' )
		{
			$bread_image = fl_framework_get_options('default_breadcrumb_image');
			$bg = "style='background: url(".$bread_image['url']."); background-position: center center; background-size: cover; background-repeat: no-repeat;'";
		}
		
		$padding_bottom = '';
		if(is_page_template( 'page-services-search.php' ))
		{
			$padding_bottom = 'padding-bottom-breadcrumb';
		}
        $none = '';
        if(is_page_template( 'page-project-search.php' ))
        {
            $none = 'none';
        }
		?>
        <section class="fr-list-product <?php echo wp_return_echo($padding_bottom); ?><?php echo wp_return_echo($none); ?>" <?php echo wp_return_echo($bg); ?>>
          <div class="container">
            <div class="row">
              <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="fr-list-content">
                  <div class="fr-list-srch">
                    <h1><?php echo exertio_breadcrumb_heading(); ?></h1>
                  </div>
                  <div class="fr-list-details">
                    <ul>
                      <li><a href="<?php echo home_url( '/' ); ?>"><?php echo esc_html__('Home', 'exertio_theme' ); ?></a></li>
                      <li><a href="javascript:void(0);"><?php echo exertio_breadcrumb(); ?></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <?php
	}