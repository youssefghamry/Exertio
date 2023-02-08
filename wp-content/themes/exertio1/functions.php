<?php if ( ! function_exists( 'exertio_theme_setup' ) ) :

add_action('after_setup_theme', 'exertio_theme_setup');
function exertio_theme_setup() {

    load_theme_textdomain( 'exertio_theme', get_template_directory() . '/languages' );
 
 	/* Theme Utilities */
	require trailingslashit(get_template_directory()) . 'inc/utilities.php';
	require trailingslashit(get_template_directory()) . 'inc/theme-settings.php';
	require trailingslashit( get_template_directory () ) ."inc/classes/index.php";
    require trailingslashit(get_template_directory()) . "inc/nav.php";
	require trailingslashit(get_template_directory()) . 'tgm/tgm-init.php';
	require trailingslashit(get_template_directory()) . "inc/zoom/zoom-authorization.php";
    require trailingslashit(get_template_directory()) . "inc/shop-func.php";

	
	add_theme_support('woocommerce');
    add_theme_support( 'automatic-feed-links' );
 	add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
  	

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		require_once( dirname(__FILE__).'/inc/options-init.php' );
	}

	add_image_size('blog-grid-img', 420, 250, true);	
	add_image_size('service_grid_img', 400, 270, true);
	add_image_size('service_detail_img', 860, 450, true);
	
}
endif; 

add_action('wp_enqueue_scripts', 'exertio_scripts', 11);


function exertio_scripts() {
	$is_rtl = false;
	if(is_rtl())
	{
		$is_rtl = true;
	}
	global $exertio_theme_options;
    
	function exertio_fonts_url() {
        $fonts_url = '';
        $poppins = _x('on', 'Poppins font: on or off', 'exertio_theme');
        if ('off' !== $poppins) {
            $font_families = array();
            if ('off' !== $poppins) {
                $font_families[] = 'Poppins:400,500,600';
            }
            $query_args = array(
                'family' => urlencode(implode('%7C', $font_families)),
                'subset' => urlencode('latin,latin-ext'),
            );
            $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        }
        return urldecode($fonts_url);
    }
	wp_enqueue_style('exertio-theme-fonts', exertio_fonts_url(), array(), null);
	
	if ( is_singular() )
	{
		wp_enqueue_script('nicescroll', trailingslashit(get_template_directory_uri()) . 'js/jquery.nicescroll.min.js', array('jquery'), false, true);
		wp_enqueue_script('jquery.imageview', trailingslashit(get_template_directory_uri()) . 'js/jquery.imageview.js', array('jquery'), false, true);
		
	}
	if ( is_singular( 'freelancer' )  || is_singular( 'projects' )|| is_singular( 'employer' ) || is_singular( 'services' ) || !is_front_page() && is_home() )
	{
		wp_enqueue_style( 'owl-carousel', trailingslashit(get_template_directory_uri()).'css/owl.carousel.min.css' );
		wp_enqueue_script('owl-carousel', trailingslashit(get_template_directory_uri()) . 'js/owl.carousel.min.js', false, false, true);
		wp_enqueue_style( 'fancybox', trailingslashit(get_template_directory_uri()).'css/jquery.fancybox.min.css' );
		wp_enqueue_script('jquery-fancybox', trailingslashit(get_template_directory_uri()) . 'js/jquery.fancybox.min.js', false, false, true);
	}
	wp_enqueue_script( "sb-menu", trailingslashit( get_template_directory_uri () ) . "js/sbmenu.js", false, false, true );
	wp_enqueue_script("isotope",trailingslashit(get_template_directory_uri())."js/isotope.js", false, false, true);
	wp_enqueue_script("masonry");

	if(is_page_template( 'page-home.php' ) || is_page())
	{
		wp_enqueue_style( 'owl-carousel', trailingslashit(get_template_directory_uri()).'css/owl.carousel.min.css' );
		wp_enqueue_script('owl-carousel', trailingslashit(get_template_directory_uri()) . 'js/owl.carousel.min.js', false, false, false);		
	}
	

	if ( is_page_template( 'page-profile.php' ) )
	{
		wp_enqueue_script('bootstrap-js', trailingslashit(get_template_directory_uri()) . 'js/bootstrap4.min.js', false, false, true);
	}
	else
	{
		wp_enqueue_script('bootstrap-js', trailingslashit(get_template_directory_uri()) . 'js/bootstrap.bundle.min.js', false, false, true);
	}
	
	if ( is_page_template( 'page-login.php' ) || is_page_template( 'page-register.php' ) )
	{
		wp_enqueue_script('passtrength-js', trailingslashit(get_template_directory_uri()) . 'js/jquery.passtrength.min.js', false, false, true);
		wp_enqueue_style('passtrength-css', trailingslashit(get_template_directory_uri()) . 'css/passtrength.css');
	}
	wp_enqueue_script('smoke-js', trailingslashit(get_template_directory_uri()) . 'js/smoke.min.js', false, false, true);
	wp_enqueue_script('toastr', trailingslashit(get_template_directory_uri()) . 'js/toastr.min.js', false, false, true);
	wp_enqueue_script('exertio-select2', trailingslashit(get_template_directory_uri()) . 'js/select2.full.min.js', false, false, true);
	//wp_enqueue_script('jquery-cookie', trailingslashit(get_template_directory_uri()) . 'js/jquery.cookie.min.js', false, false, true);
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script('jquery-richtext', trailingslashit(get_template_directory_uri()) . 'js/jquery.richtext.min.js', false, false, true);
	wp_enqueue_script('jquery.flexslider', trailingslashit(get_template_directory_uri()) . 'js/jquery.flexslider.js', false, false, true);
	
	wp_enqueue_script('exertio-rating', trailingslashit(get_template_directory_uri()) . 'js/rating.js', false, false, true);
	wp_enqueue_script('protip', trailingslashit(get_template_directory_uri()) . 'js/protip.min.js', array('jquery'), false, true);
	wp_enqueue_script('youtube-popup', trailingslashit(get_template_directory_uri()) . 'js/youtube-popup-jquery.js', array('jquery'), false, true);
	wp_enqueue_script('waypoints', trailingslashit(get_template_directory_uri()) . 'js/jquery.waypoints.min.js', array('jquery'), false, true);
	wp_enqueue_script('counter', trailingslashit(get_template_directory_uri()) . 'js/counter.js', array('jquery'), false, true);
	
	

	if ( is_page_template( 'page-profile.php' ) )
	{
		wp_enqueue_script('google-map', '//maps.googleapis.com/maps/api/js?key=' . $exertio_theme_options['google_map_key'] . '&libraries=places', false, false, true);
		wp_enqueue_script('jquery-confirm', trailingslashit(get_template_directory_uri()) . 'js/jquery-confirm.js', array('jquery'), false, true);
		wp_enqueue_script( 'jquery-datetimepicker', trailingslashit(get_template_directory_uri()). 'js/jquery.datetimepicker.full.js', array('jquery'), true, true );
		
		//wp_enqueue_script('exertio-theme-profile', trailingslashit(get_template_directory_uri()) . 'js/custom-script-profile.js', array('jquery'), false, true);

	}
	if ( is_singular( 'services' ) )
	{
		wp_enqueue_script('jquery-confirm', trailingslashit(get_template_directory_uri()) . 'js/jquery-confirm.js', array('jquery'), false, true);
		wp_enqueue_style('jquery-confirm', trailingslashit(get_template_directory_uri()) . 'css/dashboard/jquery-confirm.css');
	}
	
    /* Load the stylesheets. */
	if ( is_page_template( 'page-profile.php' ) )
	{
		if(is_rtl())
		{
			wp_enqueue_style('bootstrap4-rtl', trailingslashit(get_template_directory_uri()) . 'css/dashboard/bootstrap4-rtl.min.css');
		}
		else
		{
			wp_enqueue_style('bootstrap', trailingslashit(get_template_directory_uri()) . 'css/bootstrap4.min.css');
		}
	}
	else
	{
		if(is_rtl())
		{
			wp_enqueue_style('bootstrap-rtl', trailingslashit(get_template_directory_uri()) . 'css/bootstrap.rtl.min.css');
		}
		else
		{
			wp_enqueue_style('bootstrap', trailingslashit(get_template_directory_uri()) . 'css/bootstrap.min.css');
		}
	}
	
	wp_enqueue_style('smoke-style', trailingslashit(get_template_directory_uri()) . 'css/smoke.min.css');
	wp_enqueue_style('pretty-checkbox', trailingslashit(get_template_directory_uri()) . 'css/pretty-checkbox.min.css');
	wp_enqueue_style('toastr-style', trailingslashit(get_template_directory_uri()) . 'css/toastr.min.css');
	wp_enqueue_style('select2', trailingslashit(get_template_directory_uri()) . 'css/select2.min.css');
	wp_enqueue_style('web-font-icons', trailingslashit(get_template_directory_uri()) . 'css/all.min.css');
	wp_enqueue_style('richtext', trailingslashit(get_template_directory_uri()) . 'css/richtext.min.css');
	if ( is_page_template( 'page-profile.php' ) )
	{
		wp_enqueue_style( 'jquery-datetimepicker', trailingslashit(get_template_directory_uri()).'css/dashboard/jquery.datetimepicker.min.css' );
	}
	wp_enqueue_style( 'flexslider', trailingslashit(get_template_directory_uri()).'css/flexslider.css' );
	
	wp_enqueue_style( 'protip', trailingslashit(get_template_directory_uri()).'css/protip.min.css' );
	wp_enqueue_style( 'youtube-popup', trailingslashit(get_template_directory_uri()).'css/youtube-popup.css' );
	
	
	/*FRONTEND STYLE ENQUEUE*/
	wp_enqueue_style( 'exertio-sbmenu', trailingslashit(get_template_directory_uri()).'css/sbmenu.css' );
	if ( !is_page_template( 'page-profile.php' ) )
	{
		wp_enqueue_style( 'exertio-style', trailingslashit(get_template_directory_uri()).'css/theme.css' );
		if(is_rtl())
		{
			wp_enqueue_style( 'exertio-style-rtl', trailingslashit(get_template_directory_uri()).'css/theme-rtl.css' );
		}
	}
	if ( is_page_template( 'page-profile.php' ) )
	{
		wp_enqueue_style('materialdesignicons', trailingslashit(get_template_directory_uri()) . 'css/dashboard/materialdesignicons.min.css');
		wp_enqueue_style('jquery-confirm', trailingslashit(get_template_directory_uri()) . 'css/dashboard/jquery-confirm.css');
		
		
		wp_enqueue_style('dashboard-style', trailingslashit(get_template_directory_uri()) . 'css/dashboard/style.css');
		wp_enqueue_style('dashboard-style-rtl', trailingslashit(get_template_directory_uri()) . 'css/dashboard/style-rtl.css');
	}
	if ( is_page_template( 'page-login.php' ) || is_page_template( 'page-register.php' ) )
	{
		wp_enqueue_style( 'owl-carousel', trailingslashit(get_template_directory_uri()).'css/owl.carousel.min.css' );
		wp_enqueue_script('owl-carousel', trailingslashit(get_template_directory_uri()) . 'js/owl.carousel.min.js', false, false, true);
	}
	if ( is_page_template( 'page-services-search.php' ) || is_page_template( 'page-project-search.php' ) || is_page_template( 'page-freelancer-search.php' )  || is_page_template( 'page-profile.php' ))
	{
		wp_enqueue_style( 'ion-rangeslider', trailingslashit(get_template_directory_uri()).'css/ion-rangeslider.min.css' );
		wp_enqueue_script('ion-rangeslider', trailingslashit(get_template_directory_uri()) . 'js/ion.rangeslider.min.js', false, false, true);
	}
	
	wp_enqueue_script('exertio-theme', trailingslashit(get_template_directory_uri()) . 'js/custom-script.js',  array('jquery'), false, true);
	wp_enqueue_script('exertio-charts', trailingslashit(get_template_directory_uri()) . 'js/chart.min.js', false, false, true);
	wp_enqueue_script('exertio-stats', trailingslashit(get_template_directory_uri()) . 'js/stats.js', false, false, true);
	
	/* ZOOM MEETINGS */
	if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		if(is_page_template( 'page-profile.php' ) && $exertio_theme_options['zoom_meeting_btn'] == 1)
		{
			wp_enqueue_script('exertio-zoom', trailingslashit(get_template_directory_uri()) . 'inc/zoom/zoom-meeting.js', array('jquery'), false, true);
		}
	}
	
	
	if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		function inline_typography() 
		{
			wp_enqueue_style( 'theme_custom_css', get_template_directory_uri() . '/css/custom_style.css' );

			global $exertio_theme_options;
			$h2_color = $exertio_theme_options['opt-typography-body']['color'];
			$main_btn_color = $exertio_theme_options['opt-theme-btn-color']['regular'];
			$main_btn_color_hover = $exertio_theme_options['opt-theme-btn-color']['hover'];
			$main_btn_color_shadow = $exertio_theme_options['opt-theme-btn-shadow-color']['rgba'];
			$main_btn_color_text = $exertio_theme_options['opt-theme-btn-text-color']['regular'];
			$main_btn_hover_color_text = $exertio_theme_options['opt-theme-btn-text-color']['hover'];
			
			$sec_btn_color = $exertio_theme_options['second-opt-theme-btn-color']['regular'];
			$sec_btn_color_hover = $exertio_theme_options['second-opt-theme-btn-color']['hover'];
			$sec_btn_color_shadow = $exertio_theme_options['second-opt-theme-btn-shadow-color']['rgba'];
			$sec_btn_color_text = $exertio_theme_options['second-opt-theme-btn-text-color']['regular'];
			$sec_btn_hover_color_text = $exertio_theme_options['second-opt-theme-btn-text-color']['hover'];

			$custom_css = "
				h2,h1 { color:{$h2_color} }
				.btn-theme,  .post-excerpt .wp-block-button .wp-block-button__link, .post-excerpt .wp-block-search__button, .post-excerpt .wp-block-file .wp-block-file__button, .post-password-form input[type='submit'], .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .jconfirm-buttons .btn-primary, .woocommerce .exertio-my-account  .woocommerce-MyAccount-content .button { border: 1px solid $main_btn_color; background-color: $main_btn_color; color: $main_btn_color_text; }
				.btn-theme:hover, .post-excerpt .wp-block-button .wp-block-button__link:hover, .post-excerpt .wp-block-search__button:hover, .post-excerpt .wp-block-file .wp-block-file__button:hover, .post-password-form input[type='submit']:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .jconfirm-buttons .btn-primary:hover,.woocommerce .exertio-my-account .woocommerce-MyAccount-content .button:hover  {  background-color: $main_btn_color_hover; box-shadow: 0 0.5rem 1.125rem -0.5rem $main_btn_color_shadow; color: $main_btn_hover_color_text !important; border: 1px solid $main_btn_color_hover; }
				
				.btn-theme-secondary { border: 1px solid $sec_btn_color; background-color: $sec_btn_color; color: $sec_btn_color_text; }
				.btn-theme-secondary:hover { background-color: $sec_btn_color_hover; box-shadow: 0 0.5rem 1.125rem -0.5rem $sec_btn_color_shadow; color: $sec_btn_hover_color_text !important; border: 1px solid $sec_btn_color_hover; }
				
				
				a:hover, .fr-hero3-content span, .fr-latest-content-service span.reviews i, .fr-latest-details p span, .call-actionz .parallex-text h5, .agent-1 .card-body .username, .widget-inner-icon, .widget-inner-text .fa-star, .fr-client-sm p, .fr-latest-style ul li .fr-latest-profile i, .fr-latest-container span.readmore, .fr-browse-category .fr-browse-content ul li a.view-more, .fr-footer .fr-bottom p a, .fr-latest2-content-box .fr-latest2-price ul li p.info-in, .fr-top-contents .fr-top-details span.rating i, .fr-top-contents .fr-top-details p .style-6, .fr-h-star i, .fr-latest-jobs .owl-nav i, .project-list-2 .top-side .user-name a, .project-list-2 .bottom-side ul.features li i, .service-side .heading a, .exertio-services-box .exertio-service-desc span.rating i, .exertio-services-box .exertio-services-bottom .style-6, .exertio-services-list-2 .exertio-services-2-meta div.rating i, .exertio-services-list-2 .exertio-services-2-meta p a.author, .exertio-services-2-meta ul li span.style-6, .project-sidebar .heading a, .fr-employ-content .fr-employer-assets .btn-theme, .fr-btn-grid a, .fr3-product-price p i, .fr3-product-btn .btn, .fr3-job-detail .fr3-job-text p.price-tag, .fr3-job-detail .fr3-job-img p i, .fr-lance-content3 .fr-lance-price2 p, .fr-lance-content3 .fr-lance-detail-box .fr-lance-usr-details p i, .fr-hero-details-content .fr-hero-details-information .fr-hero-m-deails ul li:last-child i, .fr-expertise-product .fr-expertise-details span, .fr-m-products ul li p i, .fr-services2-box .fr-services2-sm-1 span, .fr-sign-bundle-content p span, .testimonial-section-fancy .details h4 + span, .fr-latest-content h3 a:hover, .fr-blog-f-details .fr-latest-style-detai ul li i, blockquote::after, .exertio-comms .comment-user .username a, .exertio-comms .comment-user .username, .sidebar .nav .nav-item.active > .nav-link i, .sidebar .nav .nav-item.active > .nav-link .menu-title, .sidebar .nav .nav-item.active > .nav-link .menu-arrow, .sidebar .nav:not(.sub-menu) > .nav-item:hover > .nav-link, .most-viewed-widget .main-price, .footer a, .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown .dropdown-item.wallet-contanier h4, .pro-box .pro-meta-box .pro-meta-price span  { color:{$main_btn_color} }
				
				.sb-header .sb-menu li:not(:last-child) a:hover, .sb-header .sb-menu li:not(:last-child) a:focus, .sb-header .sb-menu li:not(:last-child) a:active, .fr-latest-content-service p a:hover, .fr-browse-category .fr-browse-content ul li a:hover, .fr-footer .fr-footer-content ul li a:hover, .fr-right-detail-box .fr-right-detail-content .fr-right-details2 h3:hover, .fr-right-detail-box .fr-right-detail-content .fr-right-details2 h3:hover, .blog-sidebar .widget ul li a:hover, .woocommerce .woocommerce-MyAccount-navigation ul li a:hover, .woocommerce .woocommerce-MyAccount-navigation ul li.is-active a { color:$main_btn_color }
				
				.sb-menu ul ul li > a::before, .exertio-loader .exertio-dot, .exertio-loader .exertio-dots span { background: $main_btn_color; }
				
				.select2-container--default .select2-results__option--highlighted[data-selected], .select2-container--default .select2-results__option--highlighted[aria-selected], .fr-hero2-video i, .exertio-pricing-2-main .exertio-pricing-price, .services-filter-2 .services-grid-icon.active, .services-filter-2 .services-list-icon.active, .fl-navigation li.active, .project-sidebar .range-slider .irs--round .irs-from, .project-sidebar .range-slider .irs--round .irs-to, .project-sidebar .range-slider .irs--round .irs-single, .project-sidebar .range-slider .irs--round .irs-bar,.fr-employ-content .fr-employer-assets .btn-theme:hover, .fr-services2-h-style h3::before, .fr-latest-t-content .fr-latest-t-box a:hover, .tagcloud a.tag-cloud-link:hover, .wp-block-tag-cloud .tag-cloud-link:hover, .page-links .current .no, .nav-pills .nav-link.active, .nav-pills .show > .nav-link, .deposit-box .depoist-header .icon, .deposit-footer button, .review-modal .modal-header { color:$main_btn_hover_color_text; background-color: $main_btn_color; }
				
				.fr-footer .fr-footer-icons ul li a i:hover, .fr-latest-pagination .pagination .page-item.active .page-link, .fr-latest-pagination .page-link:hover, .fl-search-blog .input-group .input-group-append .blog-search-btn, .card-body .pretty.p-switch input:checked ~ .state.p-info::before, .fr-sign-form label.radio input:checked + span, .user-selection-modal label.radio input:checked + span { background-color: $main_btn_color !important; border-color: $main_btn_color; }
				
				.fr-hero2-form .style-bind, .fr-hero2-video a, .fl-navigation li.active, .project-sidebar .range-slider .irs--round .irs-handle, .fr-employ-content .fr-employer-assets .btn-theme, .fr3-product-btn .btn, .slider-box .flexslider.fr-slick-thumb .flex-active-slide, .fr-plan-basics-2 .fr-plan-content button, .heading-dots .h-dot.line-dot, .heading-dots .h-dot, .post-excerpt .wp-block-button.is-style-outline .wp-block-button__link:not(.has-text-color), .pretty input:checked ~ .state.p-success-o label::before, .pretty.p-toggle .state.p-success-o label::before, .additional-fields-container .pretty.p-switch input:checked ~ .state.p-primary::before, .additional-fields-container .irs--round .irs-handle, .review-modal .button_reward .pretty.p-switch input:checked ~ .state.p-info::before  { border-color:$main_btn_color;}
				
				.pretty input:checked ~ .state.p-warning label::after, .pretty.p-toggle .state.p-warning label::after, .pretty.p-default:not(.p-fill) input:checked ~ .state.p-success-o label::after, .additional-fields-container .pretty input:checked ~ .state.p-primary label::after, .additional-fields-container .pretty input:checked ~ .state.p-primary label::after, .additional-fields-container .irs--round .irs-bar, .additional-fields-container .irs--round .irs-from, .additional-fields-container .irs--round .irs-to, .review-modal .button_reward  .pretty.p-switch.p-fill input:checked ~ .state.p-info::before { background-color: $main_btn_color !important;}
				
				.project-sidebar .range-slider .irs--round .irs-from::before, .project-sidebar .range-slider .irs--round .irs-to::before, .fr-m-contents, .additional-fields-container .irs--round .irs-to::before, .additional-fields-container .irs--round .irs-from::before  { border-top-color:$main_btn_color;}
			";
			wp_add_inline_style( 'theme_custom_css', $custom_css );
		}
			
		wp_enqueue_style('exertio-theme-typography', inline_typography(), array(), null);

	}


	if(in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		global $exertio_theme_options;
		 $reset = false;
		 $is_reset = false;
		 $user_id = $status_msg = '';
		
		$activation_is_key = false;
		$activation_status = false;
		$activation_status_msg = '';
		 if(is_page_template('page-login.php'))
		 {
			 if(!empty($_GET['key']) && !empty($_GET['login']))
			 {
				  $is_reset = true;
				  $reset = false;
				  $user = check_password_reset_key($_GET['key'], $_GET['login']);
				  $errors = new WP_Error();
				  if ( is_wp_error($user) )
				  {
					$reset = false;
					if ( $user->get_error_code() === 'expired_key')
					{
						$status_msg = esc_html__('Key is expired.', 'exertio_theme' );
					}  
					else
					{
						$status_msg = esc_html__('Key is not valid.', 'exertio_theme' );
					}
				  }
				  else
				  {
					$reset = true;
					$user_id = $user->ID;
				  	$status_msg = esc_html__('Choose your password.', 'exertio_theme' );
				  }
			 }
		 }
		if(is_page_template('page-home.php'))
		{
			 $activation_is_key = false;
			 $activation_status = false;
				if(!empty($_GET['activation_key']))
				{
					$activation_is_key = true;
					$data = unserialize(base64_decode($_GET['activation_key']));

					$code = get_user_meta($data['id'], '_user_activation_code', true);
					// verify whether the code given is the same as ours
					if(isset($code) && $code != '' && $code == $data['code'])
					{
						//update_user_meta($data['id'], '_exertio_account_activated', 1);
						update_user_meta($data['id'], '_user_activation_code', '');
						$activation_status_msg = esc_html__('Account Activated Successfully. Please login.', 'exertio_theme' );
						$activation_status = true;
						
						update_user_meta( $data['id'], 'is_email_verified', 1 );
						$freelancer_id = get_user_meta( $data['id'], 'freelancer_id', true );
						update_post_meta( $freelancer_id, 'is_freelancer_email_verified', 1 );
						
						$company_id = get_user_meta( $data['id'], 'employer_id', true );
						update_post_meta( $company_id, 'is_employer_email_verified', 1 );
						
					}
					else
					{
						$activation_status_msg = esc_html__('Activation key is not correct', 'exertio_theme' );
						$activation_status = false;
					}
				}
		 }
		$exertio_notifications_time = isset($exertio_theme_options['exertio_notifications_time']) ? $exertio_theme_options['exertio_notifications_time'] : '';
		if($exertio_notifications_time < 10000 && $exertio_notifications_time != '')
		{
			$exertio_notifications_time = 10000;
		}
		$exertio_locale = substr( get_bloginfo ( 'language' ), 0, 2 );
		wp_localize_script('exertio-theme', 'localize_vars_frontend', array(
			'freelanceAjaxurl' => admin_url( 'admin-ajax.php' ),
			'AreYouSure' => __('Are you sure?','exertio_theme'),
			'Msgconfirm' => __('Confirmation','exertio_theme'),
			'remove' => __('Remove','exertio_theme'),
			'cancel' => __('Cancel','exertio_theme'),
			'AccDel' => __('Delete, Anyway','exertio_theme'),
			'proCancel' => __('Cancel, Anyway','exertio_theme'),
			'confimYes' => __('Yes','exertio_theme'),
			'confimNo' => __('No','exertio_theme'),
			'awardDate' => esc_html__('Award Date', 'exertio_theme'),
			'awardName' => esc_html__('Award Name', 'exertio_theme'),
			'selectImage' => esc_html__('Image', 'exertio_theme'),
			'projectURL' => esc_html__('Project url', 'exertio_theme'),
			'projectName' => esc_html__('Project Name', 'exertio_theme'),
			'expeName' => esc_html__('Experience Title', 'exertio_theme'),
			'expeCompName' => esc_html__('Company Name', 'exertio_theme'),
			'startDate' => esc_html__('Start Date', 'exertio_theme'),
			'endDate' => esc_html__('End Date', 'exertio_theme'),
			'endDatemsg' => esc_html__('Leave it empty to set it current job', 'exertio_theme'),
			'expeDesc' => esc_html__('Description', 'exertio_theme'),
			'eduName' => esc_html__('Education Title', 'exertio_theme'),
			'eduInstName' => esc_html__('Institute Name', 'exertio_theme'),
			'eduEndDatemsg' => esc_html__('Leave it empty to set it current education', 'exertio_theme'),
			'proAdminCost' => $exertio_theme_options['project_charges'],
			'YesSure' => esc_html__('Yes, I am sure', 'exertio_theme'),
			'serviceBuy' => esc_html__('Are you sure you want to purchase this service?', 'exertio_theme'),
			'maxFaqAllowed' => $exertio_theme_options['sevices_faqs_count'],
			'maxVideoAllowed' => $exertio_theme_options['sevices_youtube_links_count'],
			'maxAllowedFields' => esc_html__('Allowed number of fields limit reached', 'exertio_theme'),
			'faqNo' => esc_html__('FAQ No', 'exertio_theme'),
			'is_reset' => $is_reset,
			'reset_status' => array('status'=>$reset,'r_msg'=>$status_msg,"requested_id"=>$user_id),
			'activation_is_set' => $activation_is_key,
			'activation_is_set_msg' => array('activation_status'=>$activation_status,'status_msg'=>$activation_status_msg),
			'project_search_link' => isset($exertio_theme_options['project_search_page']) ? get_the_permalink($exertio_theme_options['project_search_page']) : '',
			'services_search_link' => isset($exertio_theme_options['services_search_page']) ? get_the_permalink($exertio_theme_options['services_search_page']) : '',
			'employer_search_link' => isset($exertio_theme_options['employer_search_page']) ? get_the_permalink($exertio_theme_options['employer_search_page']) : '',
			'freelancer_search_link' => isset($exertio_theme_options['freelancer_search_page']) ? get_the_permalink($exertio_theme_options['freelancer_search_page']) : '',
			'searchTalentText' => esc_html__('Serach Talent', 'exertio_theme'),
			'searchEmpText' => esc_html__('Search Employer', 'exertio_theme'),
			'findJobText' => esc_html__('Find Job', 'exertio_theme'),
			'searchServiceText' => esc_html__('Get job done', 'exertio_theme'),
			'is_rtl' => $is_rtl,
			'exertio_local' => $exertio_locale,
			'exertio_notification' => isset($exertio_theme_options['exertio_notifications']) ? $exertio_theme_options['exertio_notifications'] : '',
			'notification_time' => $exertio_notifications_time,
			'pass_textWeak' => esc_html__('Weak', 'exertio_theme'),
			'pass_textMedium' => esc_html__('Medium', 'exertio_theme'),
			'pass_textStrong' => esc_html__('Strong', 'exertio_theme'),
			'pass_textVeryStrong' => esc_html__('Very Strong', 'exertio_theme'),
			)
		);
	}
	if ( is_page_template( 'page-profile.php' ) )
	{
		wp_enqueue_script('exertio-theme-profile', trailingslashit(get_template_directory_uri()) . 'js/custom-script-profile.js', array('jquery'), false, true);
	}
}
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
    function exertio_add_woo_bootstrap_input_classes( $args, $key, $value = null ) {
        switch ( $args['type'] ) {

            case "select" :  
                $args['class'][] = 'form-group'; 
                $args['input_class'] = array('form-control', 'input-lg'); 
                $args['label_class'] = array('control-label');
                $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  );
            break;

            case 'country' : 
                $args['class'][] = 'form-group single-country';
                $args['label_class'] = array('control-label');
            break;

            case "state" :
                $args['class'][] = 'form-group';
                $args['input_class'] = array('form-control', 'input-lg');
                $args['label_class'] = array('control-label');
                $args['custom_attributes'] = array( 'data-plugin' => 'select2', 'data-allow-clear' => 'true', 'aria-hidden' => 'true',  );
            break;
            case "password" :
            case "text" :
            case "email" :
            case "tel" :
            case "number" :
                $args['class'][] = 'form-group';
                $args['input_class'] = array('form-control', 'input-lg');
                $args['label_class'] = array('control-label');
            break;
            case 'textarea' :
                $args['input_class'] = array('form-control', 'input-lg');
                $args['label_class'] = array('control-label');
            break;

            case 'checkbox' :
            break;

            case 'radio' :
            break;

            default :
                $args['class'][] = 'form-group';
                $args['input_class'] = array('form-control', 'input-lg');
                $args['label_class'] = array('control-label');
            break;
        }
        return $args;
    }
    add_filter('woocommerce_form_field_args','exertio_add_woo_bootstrap_input_classes',10,3);
    add_filter( 'woocommerce_single_product_carousel_options', 'exertio_woo_flexslider_options' );
    function exertio_woo_flexslider_options( $options ) {
        $options['directionNav'] = true;
        return $options;
    }
}
function exertio_myme_types($mime_types){
    $mime_types['svg'] = 'image/svg+xml';
	$mime_types['pdf'] = 'application/pdf';
	$mime_types['doc'] = 'application/msword';
	$mime_types['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	$mime_types['ppt'] = 'application/mspowerpoint, application/powerpoint, application/vnd.ms-powerpoint, application/x-mspowerpoint';
	$mime_types['pptx'] = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
	$mime_types['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	$mime_types['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	$mime_types['xls|xlsx'] = 'application/vnd.ms-excel';
    return $mime_types;
}
add_filter('upload_mimes', 'exertio_myme_types', 1, 1);

add_action('delete_user', 'exertio_delete_user_data');
function exertio_delete_user_data($user_id) {
    $args = array (
        'numberposts' => -1,
        'post_type' => array('freelancer','employer'),
        'author' => $user_id
    );
	
    $user_posts = get_posts($args);

    if (empty($user_posts)) return;

    // delete all the user posts
    foreach ($user_posts as $user_post) {
        wp_delete_post($user_post->ID, true);
    }
}


/*FOR ELEMENTOR HEADER FOOTER*/
if (in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	add_action( 'elementor/theme/register_locations', 'exertio_pro_register_elementor_locations' );  
	function exertio_pro_register_elementor_locations( $elementor_theme_manager )
	{
		$elementor_theme_manager->register_location( 'header' );
		$elementor_theme_manager->register_location( 'footer' );
	}  
}

function exertio_tiny_mce_allowed_tags($initArray) {
    $ext = 'p';
    if ( isset( $initArray['extended_valid_elements'] ) ) {
        $initArray['extended_valid_elements'] .= ',' . $ext;
    } else {
        $initArray['extended_valid_elements'] = $ext;
    }
    return $initArray;
}

//add_filter('tiny_mce_before_init', 'exertio_tiny_mce_allowed_tags');

function exertio_widgets_block_editor_support() {
    remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'exertio_widgets_block_editor_support' );