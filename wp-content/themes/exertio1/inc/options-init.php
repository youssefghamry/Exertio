<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "exertio_theme_options";

    // This line is only for altering the demo. Can be easily removed.
    //$opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }
	/*USED FOR PACKAGE SELECTION IN THEME OPTIONS*/ 
	if (! function_exists ( 'freelancer_packages_callback_function' )) {
		function freelancer_packages_callback_function(){
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
			{
				$freelancer_packages = array();
				$freelancer_packages_products = [];
				if (function_exists ( 'exertio_freelancer_packages' ))
				{
					$freelancer_packages = exertio_freelancer_packages();
				}
				if(!empty($freelancer_packages))
				{
					while ( $freelancer_packages->have_posts() )
					{
						$freelancer_packages->the_post();
						$f_products_id	=	get_the_ID();
						$f_product	=	wc_get_product( $f_products_id );
						$f_product_title = $f_product->get_title();
						$f_product_price = $f_product->get_price();
						$freelancer_packages_products[$f_products_id] = $f_product_title.'('.fl_price_separator($f_product_price).')';
					}
				}
				return $freelancer_packages_products;
			}
			else
			{
				return array();
			}
		}
	}
	if (! function_exists ( 'employer_packages_callback_function' )) {
		function employer_packages_callback_function(){
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
			{
				$employer_packages_products = [];
				$packages = array();
				if (function_exists ( 'exertio_employers_packages' ))
				{
					$packages = exertio_employers_packages();
				}
				if(!empty($packages))
				{
					while ( $packages->have_posts() )
					{
						$packages->the_post();
						$products_id	=	get_the_ID();
						$product	=	wc_get_product( $products_id );
						$product_title = $product->get_title();
						$product_price = $product->get_price();
						$employer_packages_products[$products_id] = $product_title.'('.fl_price_separator($product_price).')';
					}
				}

				return $employer_packages_products;
			}
			else
			{
				return array();
			}
		}
	}
	if (! function_exists ( 'wallet_packages_callback_function' )) {
		function wallet_packages_callback_function(){
			if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
			{
				$wallet_packages_products = [];
				$packages = array();
				if (function_exists ( 'exertio_wallet_products' ))
				{
					$packages = exertio_wallet_products();
				}
				if(!empty($packages))
				{
					while ( $packages->have_posts() )
					{
						$packages->the_post();
						$products_id	=	get_the_ID();
						$product	=	wc_get_product( $products_id );
						$product_title = $product->get_title();
						$product_price = $product->get_price();
						$wallet_packages_products[$products_id] = $product_title.'('.fl_price_separator($product_price).')';
					}
				}

				return $wallet_packages_products;
			}
			else
			{
				return array();
			}
		}
	}
	//for services
if (! function_exists ( 'service_packages_callback_function' )) {
    function service_packages_callback_function(){
        if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
        {
            $service_packages_products = [];
            $packages = array();
            if (function_exists ( 'exertio_service_products' ))
            {
                $packages = exertio_service_products();
            }
            if(!empty($packages))
            {
                while ( $packages->have_posts() )
                {
                    $packages->the_post();
                    $products_id	=	get_the_ID();
                    $product	=	wc_get_product( $products_id );
                    $product_title = $product->get_title();
                    $product_price = $product->get_price();
                    $service_packages_products[$products_id] = $product_title.'('.fl_price_separator($product_price).')';
                }
            }

            return $service_packages_products;
        }
        else
        {
            return array();
        }
    }
}
	/*GET ALL ACTIVE PAYMENT get_class_methods*/
	if ( ! function_exists( 'exertio_woocommerce_available_payment_gateways' ) )
	{
		function exertio_woocommerce_available_payment_gateways()
		{
			if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
			{
				$available_payment_methods = WC()->payment_gateways->get_available_payment_gateways();

				$payment_methods = array();
				if(isset($available_payment_methods) && count($available_payment_methods) > 0)
				{
					foreach( $available_payment_methods as $method ) {
						$payment_title =  $method->get_title();
						$payment_id =  $method->id;

						$payment_methods[$payment_id] = $payment_title;
					}
					return $payment_methods;
				}

			}
			else
			{
				return array();
			}
		}
	}
    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }
    $theme = wp_get_theme();
    $args = array(
        'opt_name'             => $opt_name,
        'display_name'         => $theme->get( 'Name' ),
        'display_version'      => $theme->get( 'Version' ),
        'menu_type'            => 'submenu',
        'allow_sub_menu'       => true,
        'menu_title'           => __( 'Theme Options', 'exertio_theme' ),
        'page_title'           => __( 'Theme Options', 'exertio_theme' ),
        'google_api_key'       => '',
        'google_update_weekly' => false,
        'async_typography'     => false,
        'admin_bar'            => true,
        'admin_bar_icon'       => 'dashicons-portfolio',
        'admin_bar_priority'   => 50,
        'global_variable'      => '',
        'dev_mode'             => false,
        'update_notice'        => true,
        'customizer'           => true,

        'page_priority'        => null,
        'page_parent'          => 'themes.php',
        'page_permissions'     => 'manage_options',
        'menu_icon'            => '',
        'last_tab'             => '',
        'page_icon'            => 'icon-themes',
        'page_slug'            => 'exertio_theme',
        'save_defaults'        => true,
        'default_show'         => false,
        'default_mark'         => '',
        'show_import_export'   => true,

        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        'output_tag'           => true,

        'database'             => '',
        'use_cdn'              => true,

        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.youtube.com/channel/UC0Y7K4Z3zCp0Y22k0zq3wDQ',
        'title' => 'View videos on YouTube',
        'icon'  => 'el el-youtube'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/ScriptsBundle/',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );

    Redux::setArgs( $opt_name, $args );
    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'exertio_theme' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'exertio_theme' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'exertio_theme' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'exertio_theme' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'exertio_theme' );
    Redux::setHelpSidebar( $opt_name, $content );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'General Settings', 'exertio_theme' ),
        'id'               => 'basic',
        'desc'             => __( 'All Website general settings will be changeable from here', 'exertio_theme' ),
        'icon'             => 'el el-home',
		'fields'           => array(
				array(
					'id' => 'exertio_admin_translate',
					'type' => 'switch',
					'title' => __('Is Admin translated', 'exertio_theme'),
					'desc' => __('After saving please refresh it.', 'exertio_theme'),
					'default' => false,
				),
				array(
					'id'       => 'frontend_logo',
					'type'     => 'media',
					'url'      => true,
					'title'    => __( 'Logo for the Main Website', 'exertio_theme' ),
					'compiler' => 'true',
					'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/logo-dashboard.svg' ),
				),
				array(
					'id'       => 'dasboard_logo',
					'type'     => 'media',
					'url'      => true,
					'title'    => __( 'Logo for the dashboard', 'exertio_theme' ),
					'compiler' => 'true',
					'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/logo-dashboard.svg' ),
				),
				array(
					'id'       => 'default_breadcrumb_image',
					'type'     => 'media',
					'url'      => true,
					'title'    => __( 'Select Default breadcrumb image', 'exertio_theme' ),
					'compiler' => 'true',
					'desc'     => __( 'this will be visible all over the website as breadcrumb background. recommended size 1920x200', 'exertio_theme' ),
					'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/default_cover.png' ),
				),
				array(
						'id'       => 'website_preloader',
						'type'     => 'button_set',
						'title'    => __( 'Website Preloader', 'exertio_theme' ),
						'desc'     => __( 'Turn on/off website preloader.', 'exertio_theme' ),
						'options'  => array(
							'0' => 'Hide',
							'1' => 'Show',
						),
						'default'  => '1'
					),
				array(
				'id' => 'bad_words_filter',
				'type' => 'textarea',
				'title' => esc_html__('Bad Words Filter', 'exertio_theme'),
				'subtitle' => esc_html__('comma separated', 'exertio_theme'),
				'placeholder' => esc_html__('word1,word2', 'exertio_theme'),
				'desc' => esc_html__('These words will be removed from all Titles and Descriptions. Please be carefull while adding words. if you enter space here then it will remove space between works with provided word as well.', 'exertio_theme'),
				'default' => '',
				),
				array(
				'id' => 'bad_words_replace',
				'type' => 'text',
				'title' => esc_html__('Bad Words Replace Word', 'exertio_theme'),
				'desc' => esc_html__('This words will be replace with above bad words list from AD Title and Description', 'exertio_theme'),
				'default' => '',
				),
				array(
				'id' => 'address_invoice',
				'type' => 'textarea',
				'title' => esc_html__('Address for invoice', 'exertio_theme'),
				'desc' => esc_html__('Provide address that you need to show over the invoices.', 'exertio_theme'),
				'default' => '',
				),

				array(
					'id'   => 'wallet_moved_info_normal',
					'type' => 'info',
					'desc' => esc_html__('Wallet Settings has been moved to General Settings > Wallet Settings', 'your-textdomain-here')
				),
				array(
						'id'       => 'exertio_demo_mode',
						'type'     => 'switch',
						'title'    => esc_html__( 'Turn On Exertio Demo Mode', 'exertio_theme' ),
						'default'  => false,
						'desc'     => esc_html__( 'Can not perform any action on the front end side if this is active.', 'exertio_theme' ),
					),
				array(
						'id'       => 'exertio_notifications',
						'type'     => 'switch',
						'title'    => esc_html__( 'Turn On Exertio notifications', 'exertio_theme' ),
						'default'  => false,
						'desc'     => esc_html__( 'Notifications that will be displayed at user dashboard', 'exertio_theme' ),
					),
				array(
						'id'       => 'exertio_notifications_msgs',
						'type'     => 'switch',
						'title'    => esc_html__( 'Turn On Exertio notifications for messagages', 'exertio_theme' ),
						'default'  => false,
						'desc'     => esc_html__( 'Notifications that will be displayed at user dashboard', 'exertio_theme' ),
						'required' => array(array('exertio_notifications','equals','1')),
					),
				array(
						'id'       => 'exertio_notifications_time',
						'type'     => 'text',
						'title'    => __( 'Notification time to refresh', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
						'desc'     => __( 'Time should be in Milliseconds. 1 Minute = 60000 Milliseconds. min. 10,000', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '600000',
						'required' => array(array('exertio_notifications','equals','1')),
					),

			)
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Price & Currency', 'exertio_theme' ),
        'id'               => 'property_price_curr',
        'subsection'       => true,
		'icon' => 'el el-globe',
        'fields'           => array(
		   array(
					'id' => 'fl_currency',
					'type' => 'text',
					'title' => esc_html__('Currency', 'exertio_theme'),
					'desc' => '<a href="http://htmlarrows.com/currency/" target="_blank">'.esc_html__('List of Currency', 'exertio_theme').'</a>' . " " . esc_html__('You can use HTML code or text as well like USD etc', 'exertio_theme'),
					'default' => '$',
				),
		   array(
				'id'		=> 'fl_currency_position',
				'type'		=> 'select',
				'title'		=> esc_html__( 'Where to Show the currency?', 'exertio_theme' ),
				'options'	=> array(
					'before'	=> esc_html__( 'Before', 'exertio_theme' ),
					'after'			=> esc_html__( 'After', 'exertio_theme' )
				),
				'default'	=> 'before',
			),
			array(
				'id'		=> 'fl_currency_decimals',
				'type'		=> 'select',
				'title'		=> esc_html__( 'Number of decimal points', 'exertio_theme' ),
				'options'	=> array(
					'0'	=> '0',
					'1'	=> '1',
					'2'	=> '2',
					'3'	=> '3',
					'4'	=> '4',
					'5'	=> '5',
					'6'	=> '6',
					'7'	=> '7',
					'8'	=> '8',
					'9'	=> '9',
					'10' => '10',
				),
				'default'	=> '0',
			),
			array(
				'id' => 'fl_decimals_separator',
				'type' => 'text',
				'title' => esc_html__('Decimals Separator', 'exertio_theme'),
				'desc'	=> esc_html__( 'Provide the decimal point separator eg: .', 'exertio_theme' ),
				'default' => '.',
			),
			array(
				'id' => 'fl_thousand_separator',
				'type' => 'text',
				'title' => esc_html__('Thousands Separator', 'exertio_theme'),
				'desc'	=> esc_html__( 'Provide the Thousands point separator eg: ,', 'exertio_theme' ),
				'default' => ',',
			),
			array(
				'id'       => 'exertio_statements',
				'type'     => 'switch',
				'title'    => esc_html__( 'Turn On Exertio Statements', 'exertio_theme' ),
				'default'  => false,
				'desc'     => esc_html__( 'Statements that will be displayed at user dashboard', 'exertio_theme' ),
			),
			
        )
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Wallet Settings', 'exertio_theme' ),
        'id'               => 'exertio_wallet_settings',
        'subsection'       => true,
		'icon' => 'el el-book',
        'fields'           => array(
			   array(
						'id'       => 'exertio_wallet_system',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Remove Exertio Wallet System', 'exertio_theme' ),
						'default'  => '0',
						'desc'     => esc_html__( 'If you turn this on(Yes), no payments will be processed on the website for Projects/Services and your wallet will also disappear.', 'exertio_theme' ),
						'options'  => array(
							'0' => __( 'No', 'exertio_theme' ),
							'1' => __( 'Yes', 'exertio_theme' ),
						),
					
					),
				array(
						'id'       => 'wallet_amount_aproval',
						'type'     => 'button_set',
						'title'    => __( 'Amount added to wallet', 'exertio_theme' ),
						'desc'     => __( 'Admin Complete means you have to approve each transection added to wallet manually and that amount will be shown to employers account after approval. Auto complete will complete the order and show in their accounts immediately.', 'exertio_theme' ),
						'options'  => array(
							'0' => 'Admin Complete',
							'1' => 'Auto Complete',
						),
						'default'  => '1',
						'required' => array(array('exertio_wallet_system','equals','0')),
					),
				array(
						'id'       => 'exertio_wallet_deposit',
						'type'     => 'button_set',
						'title'    => esc_html__( 'Wallet amount deposit type', 'exertio_theme' ),
						'default'  => '0',
						'desc'     => esc_html__( 'User defined means user will input how much amount they want to be added.', 'exertio_theme' ),
						'options'  => array(
							'0' => __( 'Admin Defined', 'exertio_theme' ),
							'1' => __( 'User Defined ', 'exertio_theme' ),
						),
					
					),
				array(
					'id' => 'wallet_custom_deposit_package',
					'type' => 'select',
					'data' => 'callback',
					'title' => esc_html__('Select Package for custom product', 'exertio_theme'),
					'args' => 'wallet_packages_callback_function',
					'required' => array(array('exertio_wallet_deposit','equals','1')),
				),

            array(
                'id' => 'exertio_wallet_payment_methods',
                'type' => 'select',
                'data' => 'callback',
                'title' => esc_html__('Select payment methods that will not auto approved', 'exertio_theme'),
                'args' => 'exertio_woocommerce_available_payment_gateways',
                'multi' => true,
                'desc'     => __( 'All the payment methods selected here will not be auto approved.', 'exertio_theme' ),
            ),
            array(
                'id'       => 'exertio_service_deposit',
                'type'     => 'switch',
                'title'    => esc_html__( 'Service Payment Direct from WOO-Comm', 'exertio_theme' ),
                'default'  => '0',
                'desc'     => esc_html__( 'Service Amount will be direct added to checkout.', 'exertio_theme' ),
                'options'  => array(
                    '0' => __( 'off', 'exertio_theme' ),
                    '1' => __( 'on ', 'exertio_theme' ),
                ),

            ),
            array(
                'id' => 'service_custom_deposit_package',
                'type' => 'select',
                'data' => 'callback',
                'title' => esc_html__('Select Custom Product for Services', 'exertio_theme'),
                'args' => 'service_packages_callback_function',
                'required' => array(array('exertio_service_deposit','equals','1')),
            ),

            array(
                'id'       => 'service_amount_approval',
                'type'     => 'button_set',
                'title'    => __( 'Auto service order complete', 'exertio_theme' ),
                'desc'     => __( 'Admin Complete means you have to approve each transection added to woocomerce order while purchase any service manually . Auto complete will complete the order and show in their accounts immediately.', 'exertio_theme' ),
                'options'  => array(
                    '0' => 'Admin Complete',
                    '1' => 'Auto Complete',
                ),
                'default'  => '0',
                'required' => array(array('exertio_service_deposit','equals','1')),
            ),
            array(
                'id' => 'exertio_service_payment_methods',
                'type' => 'select',
                'data' => 'callback',
                'title' => esc_html__('Select Service payment methods that will not auto approved', 'exertio_theme'),
                'args' => 'exertio_woocommerce_available_payment_gateways',
                'multi' => true,
                'desc'     => __( 'All the payment methods selected here will not be auto approved.', 'exertio_theme' ),
                'required' => array(array('exertio_service_deposit','equals','1')),
            ),
			
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header Options', 'exertio_theme' ),
        'id'               => 'headers',
        'customizer_width' => '500px',
        'icon'             => 'el el-edit',
		'fields'     => array(
							array(
								'id'       => 'header_type',
								'type'     => 'button_set',
								'title'    => __( 'Select the header type', 'exertio_theme' ),
								'options'  => array(
									'0' => 'Exertio Theme',
									'1' => 'Elementor',
								),
								'default'  => '0',
							),
							array(
								'id'       => 'header_layout',
								'type'     => 'image_select',
								'title'    => esc_html__( 'Header Style', 'exertio_theme' ),
								'subtitle' => esc_html__( 'Click on any header and save to apply.', 'exertio_theme' ),
								'options'  => array(
									'1' => array(
										'alt' => esc_html__( 'header 1', 'exertio_theme' ),
										'img' => trailingslashit(get_template_directory_uri()) . 'images/header-1.png',
									),
									'2' => array(
										'alt' => esc_html__( 'header 2', 'exertio_theme' ),
										'img' => trailingslashit(get_template_directory_uri()) . 'images/exertio-header-2.png',
									),
								),
								'default'  => '1',
							),
							array(
								'id'       => 'header_size',
								'type'     => 'button_set',
								'title'    => __( 'Header Full Width or Boxed Width', 'exertio_theme' ),
								'options'  => array(
									'0' => 'Full Width',
									'1' => 'Boxed Width',
								),
								'default'  => array( '1' ),
								'required' => array( 'header_layout', '=', 1 ),
							),
							array(
								'id'       => 'header_transparent',
								'type'     => 'button_set',
								'title'    => __( 'Header Full Width or Boxed Width', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Solid',
									'2' => 'Transparent',
								),
								'default'  => array( '1' ),
								'required' => array( 'header_layout', '=', 1 ),
							),
							array(
								'id'       => 'category_bar',
								'type'     => 'button_set',
								'title'    => __( 'Category Bar', 'exertio_theme' ),
								'options'  => array(
									'1' => 'On',
									'2' => 'Off',
								),
								'default'  =>1,
								'required' => array( 'header_layout', '=', '2' ),								
							),
							array(
								'id'       => 'header_searchbar_dropdown',
								'type'     => 'select',
								'title'    => __('Select options to show in search dropdown', 'exertio_theme'), 
								'options'  => array(
									'project' => __('Find Job', 'exertio_theme'),
									'services' => __('Get Job Done', 'exertio_theme'),
									'freelancer' => __('Find Talent', 'exertio_theme'),
									'employer' => __('Search Employer', 'exertio_theme'),
									),
								'multi'    => true,
								'default'  => array( '1' ),
								'sortable' => true,
								'desc' => esc_html__('The last one will be considered as the default', 'exertio_theme'),
								'required' => array( 'header_layout', '=', '2' ),
							),
							array(
								'id'       => 'header_category_cpt',
								'type'     => 'button_set',
								'title'    => __('Select options to show in search dropdown', 'exertio_theme'), 
								'options'  => array(
									'project' => __('Project Categories', 'exertio_theme'),
									'services' => __('Services Categories', 'exertio_theme'),
									),
								'default'  => 1,
								'required' => array( 'header_layout', '=', '2' ),
							),
							array(
								'id'       => 'header_categor_bar_project',
								'type'     => 'select',
								'title'    => __('Select project categories to show in bar', 'exertio_theme'), 
								'multi'    => true,
								'data' => 'terms',
								'ajax' => false,
								'args' => array( 'taxonomies' => array( 'project-categories' ), 'hide_empty' =>false),
								'required' => array( array('header_layout', '=', '2'), array('header_category_cpt','equals','project') ),
								'sortable' => true,
							),
							array(
								'id'       => 'header_categor_bar_services',
								'type'     => 'select',
								'title'    => __('Select service categoris to show in bar', 'exertio_theme'), 
								'multi'    => true,
								'data' => 'terms',
								'ajax' => false,
								'args' => array( 'taxonomies' => array( 'service-categories' )),
								'required' => array( array('header_layout', '=', '2'), array('header_category_cpt','equals','services') ),
								'sortable' => true,
							),
							array(
								'id' => 'header_btn_text',
								'type' => 'text',
								'title' => esc_html__('Header Primery Button Text Without Login', 'exertio_theme'),
								'desc' => esc_html__('If you do not provide the button text, the button will not be visible.', 'exertio_theme'),
								'default' => '',
								),
							array(
								'id' => 'header_btn_page',
								'type' => 'select',
								'data' => 'pages',
								'multi' => false,
								'title' => esc_html__('Header Primery Button Page Link Without Login', 'exertio_theme'),
							),
							array(
								'id' => 'secondary_btn_text',
								'type' => 'text',
								'title' => esc_html__('Secondary Button Text Without Login', 'exertio_theme'),
								'desc' => esc_html__('If you do not provide the button text, the Secondary button will not be visible.', 'exertio_theme'),
							),
							array(
								'id' => 'secondary_btn_page',
								'type' => 'select',
								'data' => 'pages',
								'multi' => false,
								'title' => esc_html__('Secondary Button Link Without Login', 'exertio_theme'),
							),
							array(
								'id' => 'employer_btn_text_login',
								'type' => 'text',
								'title' => esc_html__('Employer Button Text After Login', 'exertio_theme'),
								'desc' => esc_html__('If you do not provide the button text, the button will not be visible.', 'exertio_theme'),
								),
							array(
								'id' => 'employer_btn_page_login',
								'type' => 'text',
								'title' => esc_html__('Employer Primery Button Page Link After Login', 'exertio_theme'),
							),
							array(
								'id' => 'freelancer_btn_text_login',
								'type' => 'text',
								'title' => esc_html__('Freelancer Button Text After Login', 'exertio_theme'),
								'desc' => esc_html__('If you do not provide the button text, the Secondary button will not be visible.', 'exertio_theme'),
							),
							array(
								'id' => 'freelancer_btn_page_login',
								'type' => 'text',
								'title' => esc_html__('Freelancer Button Link After Login', 'exertio_theme'),
							),
								
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Blog', 'exertio_theme' ),
        'id'         => 'select-select',
        'fields'     => array(

            array(
                'id'       => 'blog_sidebar',
                'type'     => 'button_set',
                'title'    => __( 'Blog Sidebar', 'exertio_theme' ),
                'subtitle' => __( 'Select blog sidebar to show over right or left side or hide.', 'exertio_theme' ),
                //Must provide key => value pairs for select options
                'options'  => array(
                    'left' => __( 'Left', 'exertio_theme' ),
                    'right' => __( 'Right', 'exertio_theme' ),
					'no-sidebar' => __( 'No Sidebar', 'exertio_theme' ),
                ),
                'default'  => 'right'
            ),
			array(
				'id'       => 'blog_page_text',
				'type'     => 'text',
				'title'    => __( 'Blog Page Title', 'exertio_theme' ),
			),
			array(
				'id'       => 'blog_detail_page_text',
				'type'     => 'text',
				'title'    => __( 'Blog Detail Page Title', 'exertio_theme' ),
			),
			array(
				'id'       => 'blog_ad_1',
				'type'     => 'textarea',
				'title'    => __( 'Advertisement 1', 'exertio_theme' ),
				'desc' => __( 'Advertisement that will be shown on blog detail page.', 'exertio_theme' ),
			),
			array(
				'id'       => 'blog_ad_2',
				'type'     => 'textarea',
				'title'    => __( 'Advertisement 2', 'exertio_theme' ),
				'desc' => __( 'Advertisement that will be shown on blog detail page.', 'exertio_theme' ),
			),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'Authentication', 'exertio_theme' ),
        'id'    => 'authentication',
        'icon'  => 'el el-lock'
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Login', 'exertio_theme' ),
        'id'         => 'login_page',
        'fields'     => array(
							array(
								'id'       => 'login_header_show',
								'type'     => 'button_set',
								'title'    => __( 'Show header', 'exertio_theme' ),
								'desc'     => __( 'Header and menu options will be shown over the login page', 'exertio_theme' ),
								'options'  => array(
									'0' => __( 'Hide ', 'exertio_theme' ),
									'1' => __( 'Show', 'exertio_theme' ),
								),
								'default'  => array( '1' )
							),
							array(
								'id'       => 'login_footer_show',
								'type'     => 'button_set',
								'title'    => __( 'Show footer', 'exertio_theme' ),
								'desc'     => __( 'Footer will be shown over the login page', 'exertio_theme' ),
								'options'  => array(
									'0' => __( 'Hide ', 'exertio_theme' ),
									'1' => __( 'Show', 'exertio_theme' ),
								),
								'default'  => array( '1' )
							),
							array(
								'id'       => 'login_logo_show',
								'type'     => 'button_set',
								'title'    => __( 'Show Logo on Login page', 'exertio_theme' ),
								'desc'     => __( 'Logo will be shown over the login page body', 'exertio_theme' ),
								'options'  => array(
									'0' => __( 'Hide ', 'exertio_theme' ),
									'1' => __( 'Show', 'exertio_theme' ),
								),
								'default'  => array( '1' )
							),
							array(
								'id'       => 'login_bg_image',
								'type'     => 'media',
								'url'      => true,
								'title'    => __( 'Login page bg image', 'exertio_theme' ),
								'compiler' => 'true',
								'desc'     => __( 'If did not provide, default image will be visible.', 'exertio_theme' ),
								'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/default_cover.jpg' ),
							),
							array(
								'id'       => 'login_heading_text',
								'type'     => 'text',
								'title'    => __( 'Login Heading screen text', 'exertio_theme' ),
							),
							array(
								'id'       => 'login_textarea',
								'type'     => 'textarea',
								'title'    => __( 'Paragraph to show on login page', 'exertio_theme' ),
							),
							array(
								'id'          => 'login_slides',
								'type'        => 'slides',
								'title'       => __( 'Slider on login page', 'exertio_theme' ),
								'subtitle'    => __( 'You can add multiple slides and these will show on login page.', 'exertio_theme' ),
								'desc'        => __( 'You can drag and drop to re-arrange and remove all of them to hide', 'exertio_theme' ),
								'required' => array( 'tips_switch', '=', true ),
								'placeholder' => array(
									'title'       => __( 'Title', 'exertio_theme' ),
									'description' => __( 'Description', 'exertio_theme' ),
								),
								'show' => array(
									'title' => true,
									'description' => true,
									'url' => false,
									),
							),
							        
        ),
        'subsection' => true,
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Register', 'exertio_theme' ),
        'id'         => 'register_page',
        'fields'     => array(
							array(
								'id'       => 'user_registration_type',
								'type'     => 'button_set',
								'title'    => __( 'Select Registration Type', 'exertio_theme' ),
								'desc'     => __( 'Allowed registration type', 'exertio_theme' ),
								'options'  => array(
									'both_selected' => __( 'User Selection', 'exertio_theme' ),
									'both' => __( 'Both Auto', 'exertio_theme' ),
								),
								'default'  => 'both'
							),
							array(
								'id'       => 'user_registration_type_selection',
								'type'     => 'button_set',
								'title'    => __( 'Select Registration Type', 'exertio_theme' ),
								'desc'     => __( 'Allowed registration type', 'exertio_theme' ),
								'multi'   => true,
								'options'  => array(
									'freelancer' =>  __( 'Freelancer Only', 'exertio_theme' ),
									'employer' => __( 'Employer Only', 'exertio_theme' ),
								),
								'default'  => 'freelancer',
								'required' => array(array('user_registration_type','equals','both_selected')),
							),
							array(
								'id'       => 'user_redirection_after_login',
								'type'     => 'button_set',
								'title'    => __( 'Select Account to redirect', 'exertio_theme' ),
								'desc'     => __( 'After registration on which user account dashboard should redirect.', 'exertio_theme' ),
								'options'  => array(
									'freelancer' =>  __( 'Freelancer', 'exertio_theme' ),
									'employer' => __( 'Employer', 'exertio_theme' ),
								),
								'default'  => 'employer',
								'required' => array(array('user_registration_type','equals','both')),
							),
							array(
								'id'       => 'register_header_show',
								'type'     => 'button_set',
								'title'    => __( 'Show header', 'exertio_theme' ),
								'desc'     => __( 'Header and menu options will be shown over the register page', 'exertio_theme' ),
								'options'  => array(
									'0' => __( 'Hide', 'exertio_theme' ),
									'1' => __( 'show', 'exertio_theme' ),
								),
								'default'  => array( '1' )
							),
							array(
								'id'       => 'register_footer_show',
								'type'     => 'button_set',
								'title'    => __( 'Show footer', 'exertio_theme' ),
								'desc'     => __( 'Footer will be shown over the register page', 'exertio_theme' ),
								'options'  => array(
									'0' => __( 'Hide', 'exertio_theme' ),
									'1' => __( 'Show', 'exertio_theme' ),
								),
								'default'  => array( '1' )
							),
							array(
								'id'       => 'register_logo_show',
								'type'     => 'button_set',
								'title'    => __( 'Show Logo on register page', 'exertio_theme' ),
								'desc'     => __( 'Logo will be shown over the register page body', 'exertio_theme' ),
								'options'  => array(
									'0' => __( 'Hide', 'exertio_theme' ),
									'1' => __( 'Show', 'exertio_theme' ),
								),
								'default'  => array( '0' )
							),
							array(
								'id'       => 'register_bg_image',
								'type'     => 'media',
								'url'      => true,
								'title'    => __( 'Register page bg image', 'exertio_theme' ),
								'compiler' => 'true',
								'desc'     => __( 'If did not provide, default image will be visible.', 'exertio_theme' ),
								'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/default_cover.jpg' ),
							),
							array(
								'id'       => 'register_heading_text',
								'type'     => 'text',
								'title'    => __( 'Register Heading screen text', 'exertio_theme' ),
							),
							array(
								'id'       => 'register_textarea',
								'type'     => 'textarea',
								'title'    => __( 'Paragraph to show on register page', 'exertio_theme' ),
							),
							array(
								'id'          => 'register_slides',
								'type'        => 'slides',
								'title'       => __( 'Slider on register page', 'exertio_theme' ),
								'subtitle'    => __( 'You can add multiple slides and these will show on login page.', 'exertio_theme' ),
								'desc'        => __( 'You can drag and drop to re-arrange and remove all of them to hide', 'exertio_theme' ),
								'required' => array( 'tips_switch', '=', true ),
								'placeholder' => array(
									'title'       => __( 'Title', 'exertio_theme' ),
									'description' => __( 'Description', 'exertio_theme' ),
								),
								'show' => array(
									'title' => true,
									'description' => true,
									'url' => false,
									),
							),
        ),
        'subsection' => true,
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'Email Templates', 'exertio_theme' ),
        'id'    => 'email_templates',
        'icon'  => 'el el-envelope'
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Registration', 'exertio_theme' ),
        'id'         => 'register_email_tab',
        'fields'     => array(
							array(
								'id'       => 'fl_email_onregister',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email On Registration', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'You want to send email on the time of registration.', 'exertio_theme' ),
							),
							array(
								'id'       => 'fl_email_sendto_admin',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email To Admin On Registration', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'You want to send email on the time of registration.', 'exertio_theme' ),
								'required' => array(array('fl_email_onregister','equals','1')),
							),
							array(
								'id' => 'fl_new_user_admin_sub',
								'type' => 'text',
								'title' => esc_html__('New User Email Template Subject For Admin', 'exertio_theme'),
								'default' => esc_html__('New User Registration', 'exertio_theme'),
								'required' => array( array('fl_email_onregister','equals','1'), array('fl_email_sendto_admin','equals','1')),
							),
							array(
									'id' => 'fl_new_user_admin_email_body',
									'type' => 'editor',
									'title' => esc_html__('New User Email Template For Admin', 'exertio_theme'),
									'required' => array( array('fl_email_onregister','equals','1'), array('fl_email_sendto_admin','equals','1')),
									'args' => array(
										'teeny' => true,
										'textarea_rows' => 20,
										'wpautop' => false,
									),
									'desc' => esc_html__('%site_name% , %display_name%, %email% will be translated accordingly.', 'exertio_theme'),
									'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
						<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<!-- LOGO -->
							<tr>
								<td bgcolor='#5AADFF' align='center'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
												<img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello Admin,</h1> 
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important;'>New user has registered on your site. </p>
											</td>
										</tr>
										 
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
											</td>
										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
												<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
												<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
											</td>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
						</body>",
						),
						array(
								'id'       => 'fl_email_sendto_user',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Welcome Email To User On Registration', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'So you want to send welcome eamil on the time of registration to user.', 'exertio_theme' ),
								'required' => array(array('fl_email_onregister','equals','1')),
							),
							
							array(
								'id' => 'fl_new_user_welcome_sub',
								'type' => 'text',
								'title' => esc_html__('Welcome Email Template Subject For Users', 'exertio_theme'),
								'default' => esc_html__("We're happy to have you with us", 'exertio_theme'),
								'required' => array( array('fl_email_onregister','equals','1'), array('fl_email_sendto_user','equals','1')),
							),
							array(
								'id' => 'fl_new_user_welcome_message_body',
								'type' => 'editor',
								'title' => esc_html__('Welcome Email Template For Users', 'exertio_theme'),
								'required' => array( array('fl_email_onregister','equals','1'), array('fl_email_sendto_user','equals','1')),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %email% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%'>
						<!-- LOGO -->
						<tr>
							<td bgcolor='#5AADFF' align='center'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
											 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Welcome %display_name%,</h1>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important;'>You've successfully registered on %site_name%. We're happy to have you here. </p>
										</td>
									</tr>
									 <!-- COPY -->
									 <tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'>Your Username</strong> : %display_name%</p>
											<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'>Your Email</strong> : %email%</p>
										</td>
									</tr>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
										</td>
									</tr>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
					
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
											<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
											<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>
					</table>
					</body>"
			),
			array(
								'id'       => 'fl_user_email_verification',
								'type'     => 'switch',
								'title'    => esc_html__( 'Email Verification on Register', 'exertio_theme' ),
								'default'  => false,
                                'required' => array( array('fl_allow_user_email_verification','equals','1')),
								'desc'     => esc_html__( 'Turn on this option if you want to have email verified at the time of registration.', 'exertio_theme' ),
							),
						array(
							'id' => 'fl_user_email_verification_sub',
							'type' => 'text',
							'title' => esc_html__('Email Verification Template Subject', 'exertio_theme'),
							'default' => esc_html__("Email Verification Subject", 'exertio_theme'),
							'required' => array( array('fl_user_email_verification','equals','1')),
						),
						array(
							'id' => 'fl_user_email_verification_message',
							'type' => 'editor',
							'title' => esc_html__('Email Verification Template Body ', 'exertio_theme'),
							'required' => array( array('fl_user_email_verification','equals','1')),
							'args' => array(
								'teeny' => true,
								'textarea_rows' => 20,
								'wpautop' => false,
							),
							'desc' => esc_html__('%site_name% , %display_name%, %verification_link% will be translated accordingly.', 'exertio_theme'),
							'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
				<table border='0' cellpadding='0' cellspacing='0' width='100%'>
					<!-- LOGO -->
					<tr>
						<td bgcolor='#3CBEB2' align='center'>
							<table border='0' cellpadding='0' cellspacing='0' width='90%' style='max-width: 600px;'>
								<tr>
									<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
										 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hi, %display_name%!</h1>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0;  font-size: 18px !important;'>We have sent you this email in response to your registration on  <strong>%site_name%</strong> </p>
									</td>
								</tr>
								  <tr>
									<td bgcolor='#ffffff' align='left'>
										<table width='100%' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td bgcolor='#ffffff' align='center' style='padding: 20px 30px 20px 30px;'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td align='center' style='border-radius: 3px;' bgcolor='#3CBEB2'><a href='%verification_link%' target='_blank' style='font-size: 20px; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #3cbeb2; display: inline-block;'>Verify My Account</a>
															</td>
															
														</tr>
														<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' ><strong>Copyable Link :</strong> %verification_link%</p>
									</td>
								</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr> <!-- COPY -->
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >We recommend that you keep your password secure and not share it with anyone. If you feel your password has been compromised, you can change it by going to your My Profile Page and clicking on the Change Password.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
				
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
										<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
										<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
				</body>"
							),
            array(
                'id'       => 'fl_allow_user_email_verification',
                'type'     => 'switch',
                'title'    => esc_html__( 'Allow to login without Verification', 'exertio_theme' ),
                'default'  => true,
                'desc'     => esc_html__( 'Turn off this option if you not want to login without verification. Turn off Email Verification on Register before proceeding', 'exertio_theme' ),
            ),
            array(
                'id' => 'fl_allow_user_email_verification_sub',
                'type' => 'text',
                'title' => esc_html__('Email Verification Template Subject', 'exertio_theme'),
                'default' => esc_html__("Email Verification Subject", 'exertio_theme'),
                'required' => array( array('fl_allow_user_email_verification','equals','0')),
            ),
            array(
                'id' => 'registration_page',
                'type' => 'select',
                'data' => 'pages',
                'title' => esc_html__('Redirect To Page', 'exertio_theme'),
                'required' => array( array('fl_allow_user_email_verification','equals','0')),
            ),
            array(
                'id' => 'fl_allow_user_email_verification_message',
                'type' => 'editor',
                'title' => esc_html__('Allow Email Verification Template Body ', 'exertio_theme'),
                'required' => array( array('fl_allow_user_email_verification','equals','0')),
                'args' => array(
                    'teeny' => true,
                    'textarea_rows' => 20,
                    'wpautop' => false,
                ),
                'desc' => esc_html__('%site_name% , %display_name%, %verification_link_allow% will be translated accordingly.', 'exertio_theme'),
                'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
				<table border='0' cellpadding='0' cellspacing='0' width='100%'>
					<!-- LOGO -->
					<tr>
						<td bgcolor='#3CBEB2' align='center'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
										 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hi, %display_name%!</h1>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0;  font-size: 18px !important;'>We have sent you this email in response to your registration on  <strong>%site_name%</strong> </p>
									</td>
								</tr>
								  <tr>
									<td bgcolor='#ffffff' align='left'>
										<table width='100%' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td bgcolor='#ffffff' align='center' style='padding: 20px 30px 20px 30px;'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td align='center' style='border-radius: 3px;' bgcolor='#3CBEB2'><a href='%verification_link_allow%' target='_blank' style='font-size: 20px; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #3cbeb2; display: inline-block;'>Verify My Account</a>
															</td>
															
														</tr>
														<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' ><strong>Copyable Link :</strong> %verification_link_allow%</p>
									</td>
								</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr> <!-- COPY -->
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >We recommend that you keep your password secure and not share it with anyone. If you feel your password has been compromised, you can change it by going to your My Profile Page and clicking on the Change Password.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
				
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
										<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
										<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
				</body>"
            ),
						
					array(
							'id' => 'fl_user_reset_pwd_sub',
							'type' => 'text',
							'title' => esc_html__('Reset Password Template Subject', 'exertio_theme'),
							'default' => esc_html__("Forgot Your Password", 'exertio_theme'),
						),
						array(
							'id' => 'fl_user_reset_message',
							'type' => 'editor',
							'title' => esc_html__('Reset Password Template For Users', 'exertio_theme'),
							'args' => array(
								'teeny' => true,
								'textarea_rows' => 20,
								'wpautop' => false,
							),
							'desc' => esc_html__('%site_name% , %display_name%, %reset_link% will be translated accordingly.', 'exertio_theme'),
							'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
				<table border='0' cellpadding='0' cellspacing='0' width='100%'>
					<!-- LOGO -->
					<tr>
						<td bgcolor='#3CBEB2' align='center'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
										 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hi, %display_name%!</h1>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0;  font-size: 18px !important;'>We have sent you this email in response to your request to reset your password on <strong>%site_name%</strong> </p>
									</td>
								</tr>
								  <tr>
									<td bgcolor='#ffffff' align='left'>
										<table width='100%' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td bgcolor='#ffffff' align='center' style='padding: 20px 30px 20px 30px;'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td align='center' style='border-radius: 3px;' bgcolor='#3CBEB2'><a href='%reset_link%' target='_blank' style='font-size: 20px; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #3cbeb2; display: inline-block;'>Reset My Password</a>
															</td>
															
														</tr>
														<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' ><strong>Copyable Link :</strong> %reset_link%</p>
									</td>
								</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr> <!-- COPY -->
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >We recommend that you keep your password secure and not share it with anyone. If you feel your password has been compromised, you can change it by going to your My Profile Page and clicking on the Change Email Password.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
				
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
										<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
										<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
				</body>"
							),
        ),
        'subsection' => true,
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Projects', 'exertio_theme' ),
        'id'         => 'project_email_tab',
        'fields'     => array(
							array(
								'id'       => 'fl_email_onproject_created',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email On Project posted', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'If you want to send email to user when project is posted', 'exertio_theme' ),
							),

							array(
								'id' => 'fl_email_onproject_created_sub',
								'type' => 'text',
								'title' => esc_html__('Project Created Email Template Subject For Employer', 'exertio_theme'),
								'default' => esc_html__('Your project has been posted', 'exertio_theme'),
								'required' => array( array('fl_email_onproject_created','equals','1')),
							),
							array(
									'id' => 'fl_email_onproject_created_email_body',
									'type' => 'editor',
									'title' => esc_html__('Project Created body text to employer', 'exertio_theme'),
									'required' => array( array('fl_email_onproject_created','equals','1')),
									'args' => array(
										'teeny' => true,
										'textarea_rows' => 50,
										'wpautop' => false,
									),
									'desc' => esc_html__(' %display_name%, %project_link%, %project_title%, %site_name% will be translated accordingly.', 'exertio_theme'),
									'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
						<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<!-- LOGO -->
							<tr>
								<td bgcolor='#5AADFF' align='center'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
												<img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> 
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important;'>Your project has been posted on %site_name%. </p>
											</td>
										</tr>
										<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='%project_link%'> %project_title%</a> </p>
										</td>

									</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
											</td>
										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
												<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
												<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
											</td>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
						</body>",
						),
						array(
								'id'       => 'fl_email_freelancer_assign_project',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Freelancer When Project is Assigned', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when a project is assigned to freelancer', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_freelancer_assign_sub',
								'type' => 'text',
								'title' => esc_html__('Project Assignment Subject For Freelancer', 'exertio_theme'),
								'default' => esc_html__("Congratulations! You Got a New Project", 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_assign_project','equals','1')),
							),
							array(
								'id' => 'fl_freelancer_assign_project_message_body',
								'type' => 'editor',
								'title' => esc_html__('Project Assignment email body to Freelancer', 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_assign_project','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %project_link%, %project_title%, %project_cost% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%'>
						<!-- LOGO -->
						<tr>
							<td bgcolor='#5AADFF' align='center'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
											 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important;'>A new project has been assigned to you on %site_name%. Happy Earing. </p>
										</td>
									</tr>
									 <!-- COPY -->
									 <tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='%project_link%'>%project_title%</a></p>
											<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'> Project Cost</strong> : %project_cost%</p>
										</td>
									</tr>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
										</td>
									</tr>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
					
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
											<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
											<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>
					</table>
					</body>"
			),
							array(
								'id'       => 'fl_email_emp_assign_project',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Employer When Project is Assigned', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when a project is assigned to Employer', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_emp_assign_sub',
								'type' => 'text',
								'title' => esc_html__('Project Assignment Subject For Employer', 'exertio_theme'),
								'default' => esc_html__("You Have Assigned a Project", 'exertio_theme'),
								'required' => array( array('fl_email_emp_assign_project','equals','1')),
							),
							array(
								'id' => 'fl_emp_assign_project_message_body',
								'type' => 'editor',
								'title' => esc_html__('Project Assignment email body', 'exertio_theme'),
								'required' => array( array('fl_email_emp_assign_project','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %project_link%, %project_title%, %project_cost%, %freelancer_display_name% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>You have assigned a project to %freelancer_display_name% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='project_link'>%project_title%</a></p>
															<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'> Project Cost</strong> : %project_cost%</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_freelancer_complete_project',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Freelancer When Project is Completed', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when a project is completed to Freelancer', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_freelancer_complete_project_sub',
								'type' => 'text',
								'title' => esc_html__('Project Completed Subject For Freelancer', 'exertio_theme'),
								'default' => esc_html__("You Have Completed a Project", 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_complete_project','equals','1')),
							),
							array(
								'id' => 'fl_freelancer_complete_project_message_body',
								'type' => 'editor',
								'title' => esc_html__('Project Completed Email Template For Freelancer', 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_complete_project','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 60,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %project_link%, %project_title% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>Hurrah! You have completed a project on %site_name% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='project_link'>%project_title%</a></p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_emp_complete_project',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Employer When Project is Completed', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when a project is completed to Employer', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_emp_complete_project_sub',
								'type' => 'text',
								'title' => esc_html__('Project Completed Subject For Employer', 'exertio_theme'),
								'default' => esc_html__("Your project has been marked as completed", 'exertio_theme'),
								'required' => array( array('fl_email_emp_complete_project','equals','1')),
							),
							array(
								'id' => 'fl_emp_complete_project_message_body',
								'type' => 'editor',
								'title' => esc_html__('Project Completed Email Template For Employer', 'exertio_theme'),
								'required' => array( array('fl_email_emp_complete_project','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 60,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %project_link%, %project_title% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>Hurrah! Your project has been completed successfully on %site_name% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='%project_link%'>%project_title%  %project_link%</a></p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_freelancer_cancel_project',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Freelancer When Project is Canceled', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when a project is Canceled to Freelancer', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_freelancer_cancel_project_sub',
								'type' => 'text',
								'title' => esc_html__('Project Canceled Subject For Freelancer', 'exertio_theme'),
								'default' => esc_html__("Project Canceled", 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_cancel_project','equals','1')),
							),
							array(
								'id' => 'fl_freelancer_cancel_project_message_body',
								'type' => 'editor',
								'title' => esc_html__('Project Canceled Email Template For Freelancer', 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_cancel_project','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 60,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %admin_email%, %project_link%, %project_title% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>A Project that was assigned to you is been canceled on %site_name%. Please contact Admin for more detail at %admin_email% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='%project_link%'>%project_title%</a></p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_emp_cancel_project',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Employer When Project is canceled', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email to Employer when a project is canceled', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_emp_cancel_project_sub',
								'type' => 'text',
								'title' => esc_html__('Project Canceled Subject For Employer', 'exertio_theme'),
								'default' => esc_html__("Your project has been canceled", 'exertio_theme'),
								'required' => array( array('fl_email_emp_cancel_project','equals','1')),
							),
							array(
								'id' => 'fl_emp_cancel_project_message_body',
								'type' => 'editor',
								'title' => esc_html__('Project Cancellation Email Template For Employer', 'exertio_theme'),
								'required' => array( array('fl_email_emp_cancel_project','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 60,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%  will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>You have canceled a project on %site_name% </p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_project_proposal',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Employer When Project got a proposal', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email to Employer when a project got a proposal', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_project_proposal_sub',
								'type' => 'text',
								'title' => esc_html__('Project Proposal subject For Employer', 'exertio_theme'),
								'default' => esc_html__("You Got a New Proposal", 'exertio_theme'),
								'required' => array( array('fl_email_project_proposal','equals','1')),
							),
							array(
								'id' => 'fl_project_proposal_message_body',
								'type' => 'editor',
								'title' => esc_html__('Proposal Received on Project Email Template For Employer', 'exertio_theme'),
								'required' => array( array('fl_email_project_proposal','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 60,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %project_title%, %project_link%,  will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>You have received a new proposal on a project at %site_name% </p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='%project_link%'>%project_title%</a></p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id' => 'fl_email_zoom_meet_button',
								'type' => 'switch',
								'title' => esc_html__('Send Email for Zoom Meeting', 'exertio_theme'),
								'default' => false,
								'desc' => esc_html__('A zoom meeting Email will be sent to user', 'exertio_theme'),
							),
							array(
								'id' => 'fl_email_zoom_meet_subject',
								'type' => 'text',
								'title' => esc_html__('Zoom Meeting Email Template Subject For Employer', 'exertio_theme'),
								'default' => esc_html__('You have an invitation for Zoom Meeting', 'exertio_theme'),
								'required' => array(array('fl_email_zoom_meet_button', 'equals', '1')),
							),
							array(
								'id' => 'fl_email_zoom_meeting_email_body',
								'type' => 'editor',
								'title' => esc_html__('Zoom Meeting body text invitation', 'exertio_theme'),
								'required' => array(array('fl_email_zoom_meet_button', 'equals', '1')),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 50,
									'wpautop' => false,
								),
								'desc' => esc_html__(' %display_name%, %project_link%, %project_title%, %site_name%, %meeting_title%, %joinURL%, %meeting_id%, %meeting_password%, %meeting_note%, %meeting_duration%, %meeting_time%, will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<!-- LOGO -->
							<tr>
								<td bgcolor='#5AADFF' align='center'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
												<img src='" . trailingslashit(get_template_directory_uri()) . "/images/logo-dashboard.svg" . "' width='200px' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> 
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important;'>You are invited for Zoom Meeting %site_name%. </p>
											</td>
										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Project Link</strong> : <a href='%project_link%'> %project_title%</a> </p>
											</td>

										</tr>   
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Meeting ID </strong> : %meeting_id% </p>
											</td>

										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Mettin Join URL</strong> : <a href='%joinURL%'> %joinURL%</a> </p>
											</td>

										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Meeting Password</strong> : %meeting_password% </p>
											</td>

										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Meeting Note</strong> : %meeting_note% </p>
											</td>

										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Meeting Duration</strong> : %meeting_duration% : Minutes</p>
											</td>

										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Meeting Time</strong> : %meeting_time% </p>
											</td>

										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
											</td>
										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
												<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
												<p style='margin: 0;'>" . date("Y") . " © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
											</td>
										</tr>
									</table>

								</td>
							</tr>
								</table>
								</body>",
							),
        ),
        'subsection' => true,
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Services', 'exertio_theme' ),
        'id'         => 'services_email_tab',
        'fields'     => array(
							array(
								'id'       => 'fl_email_onservice_created',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email On Service posted', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'If you want to send email to Freelancer when service is posted', 'exertio_theme' ),
							),

							array(
								'id' => 'fl_onservice_created_sub',
								'type' => 'text',
								'title' => esc_html__('Service Created Email Template Subject For Freelancer', 'exertio_theme'),
								'default' => esc_html__('Your service has been posted', 'exertio_theme'),
								'required' => array( array('fl_email_onservice_created','equals','1')),
							),
							array(
									'id' => 'fl_onservice_created_body',
									'type' => 'editor',
									'title' => esc_html__('Service Created body text to Freelancer', 'exertio_theme'),
									'required' => array( array('fl_email_onservice_created','equals','1')),
									'args' => array(
										'teeny' => true,
										'textarea_rows' => 50,
										'wpautop' => false,
									),
									'desc' => esc_html__(' %display_name%, %service_link%, %service_title%, %site_name% will be translated accordingly.', 'exertio_theme'),
									'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
						<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<!-- LOGO -->
							<tr>
								<td bgcolor='#5AADFF' align='center'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
												<img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> 
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important;'>Your service has been posted on %site_name%. </p>
											</td>
										</tr>
										<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Service Link</strong> : <a href='%service_link%'> %service_title%</a> </p>
										</td>

									</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
											</td>
										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
												<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
												<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
											</td>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
						</body>",
						),
						array(
								'id'       => 'fl_email_freelancer_service_receive',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Freelancer When Order is received', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when a service receive an order', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_freelancer_order_receive_sub',
								'type' => 'text',
								'title' => esc_html__('Service Order Receive Subject For Freelancer', 'exertio_theme'),
								'default' => esc_html__("Congratulations! You Got a New Order", 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_service_receive','equals','1')),
							),
							array(
								'id' => 'fl_freelancer_order_receive_message_body',
								'type' => 'editor',
								'title' => esc_html__('Service order received email body to Freelancer', 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_service_receive','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %service_link%, %service_title%, %service_cost% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%'>
						<!-- LOGO -->
						<tr>
							<td bgcolor='#5AADFF' align='center'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
											 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important;'>You got a new order on %service_title%. Happy Coding. </p>
										</td>
									</tr>
									 <!-- COPY -->
									 <tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Service Link</strong> : <a href='service_link'>%service_title%</a></p>
											<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'> Service Cost</strong> : %service_cost%</p>
										</td>
									</tr>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
										</td>
									</tr>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
					
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
											<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
											<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>
					</table>
					</body>"
			),
							array(
								'id'       => 'fl_email_emp_order_created',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Employer When Order is created', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when an Employer purchase order', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_emp_order_created_sub',
								'type' => 'text',
								'title' => esc_html__('Order Placed Subject For Employer', 'exertio_theme'),
								'default' => esc_html__("You have placed an order", 'exertio_theme'),
								'required' => array( array('fl_email_emp_order_created','equals','1')),
							),
							array(
								'id' => 'fl_emp_order_created_message_body',
								'type' => 'editor',
								'title' => esc_html__('Order Placed email body', 'exertio_theme'),
								'required' => array( array('fl_email_emp_order_created','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %service_link%, %service_title%, %service_cost%, %freelancer_display_name% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>You have placed an order at to %site_name%  from %freelancer_display_name% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Service Link</strong> : <a href='service_link'>%service_title%</a></p>
															<p style='margin: 0;  font-size: 18px !important;  padding-bottom:5px;'> <strong style='color:#111111'> Service Cost</strong> : %service_cost%</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_freelancer_complete_service',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send Email to Freelancer When order is Completed', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when order is completed', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_freelancer_complete_order_sub',
								'type' => 'text',
								'title' => esc_html__('Order completed Subject for freelancer', 'exertio_theme'),
								'default' => esc_html__("You have completed order", 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_complete_service','equals','1')),
							),
							array(
								'id' => 'fl_freelancer_complete_order_message_body',
								'type' => 'editor',
								'title' => esc_html__('Order completed email template for freelancer', 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_complete_service','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %service_link%, %service_title% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>Hurrah! You have completed order on %site_name% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Order Link</strong> : <a href='%service_link%'>%service_title%</a></p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_emp_complete_order',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send email to employer When order is completed', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when order is completed to employer', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_emp_complete_order_sub',
								'type' => 'text',
								'title' => esc_html__('Order completed subject for employer', 'exertio_theme'),
								'default' => esc_html__("Your order has been marked as completed", 'exertio_theme'),
								'required' => array( array('fl_email_emp_complete_order','equals','1')),
							),
							array(
								'id' => 'fl_emp_complete_order_message_body',
								'type' => 'editor',
								'title' => esc_html__('Order completed email template for employer', 'exertio_theme'),
								'required' => array( array('fl_email_emp_complete_order','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %service_link%, %service_title% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>Hurrah! Your Order has been completed successfully on %site_name% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Service Link</strong> : <a href='service_link'>%service_title%</a></p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_freelancer_cancel_order',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send email to freelancer when order is canceled', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email when order is canceled to freelancer', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_freelancer_cancel_order_sub',
								'type' => 'text',
								'title' => esc_html__('Order canceled subject for freelancer', 'exertio_theme'),
								'default' => esc_html__("Order Canceled", 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_cancel_order','equals','1')),
							),
							array(
								'id' => 'fl_freelancer_cancel_order_message_body',
								'type' => 'editor',
								'title' => esc_html__('Order canceled email template for freelancer', 'exertio_theme'),
								'required' => array( array('fl_email_freelancer_cancel_order','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%, %admin_email% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>Order that you have placed is been canceled on %site_name%. Please contact Admin for more detail at %admin_email% </p>
														</td>
													</tr>
													 <!-- COPY -->
													 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Service Link</strong> : <a href='%service_link%'>%service_title%</a></p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							array(
								'id'       => 'fl_email_emp_cancel_order',
								'type'     => 'switch',
								'title'    => esc_html__( 'Send email to employer when order is canceled', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Do you want to send email to employer when a order is canceled', 'exertio_theme' ),
							),
							
							array(
								'id' => 'fl_email_emp_cancel_order_sub',
								'type' => 'text',
								'title' => esc_html__('Order Canceled Subject For Employer', 'exertio_theme'),
								'default' => esc_html__("Your Order has been canceled", 'exertio_theme'),
								'required' => array( array('fl_email_emp_cancel_order','equals','1')),
							),
							array(
								'id' => 'fl_email_emp_cancel_order_body',
								'type' => 'editor',
								'title' => esc_html__('Order cancellation email template for employer', 'exertio_theme'),
								'required' => array( array('fl_email_emp_cancel_order','equals','1') ),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name%  will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%'>
										<!-- LOGO -->
										<tr>
											<td bgcolor='#5AADFF' align='center'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
															 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.svg"."' width='200px' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important;'>Your order has been canceled on %site_name% </p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
														</td>
													</tr>
													<tr>
														<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>

														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
															<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
															<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
												<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
													<tr>
														<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
															<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
														</td>
													</tr>
												</table>

											</td>
										</tr>
									</table>
									</body>"
							),
							
        ),
        'subsection' => true,
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Payouts', 'exertio_theme' ),
        'id'         => 'payout_email_tab',
        'fields'     => array(
							array(
								'id'       => 'fl_email_payout_create',
								'type'     => 'switch',
								'title'    => esc_html__( 'Create Payout Email', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'You want to send email when payout is created for user.', 'exertio_theme' ),
							),
							array(
								'id' => 'fl_email_payout_create_sub',
								'type' => 'text',
								'title' => esc_html__('Subject for payout creation', 'exertio_theme'),
								'default' => esc_html__('Your payout has been created', 'exertio_theme'),
								'required' => array( array('fl_email_payout_create','equals','1')),
							),
							array(
									'id' => 'fl_email_payout_create_body',
									'type' => 'editor',
									'title' => esc_html__('Payout email body', 'exertio_theme'),
									'required' => array( array('fl_email_payout_create','equals','1')),
									'args' => array(
										'teeny' => true,
										'textarea_rows' => 20,
										'wpautop' => false,
									),
									'desc' => esc_html__('%site_name% , %display_name%, %payout_amount% will be translated accordingly.', 'exertio_theme'),
									'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
						<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<!-- LOGO -->
							<tr>
								<td bgcolor='#5AADFF' align='center'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
												<img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> 
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important;'>Your payout for this month has been created. </p>
											</td>
										</tr>
										 <tr>
														<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
															<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Payout Amount</strong> : %payout_amount%</p>
														</td>
													</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
											</td>
										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
												<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
												<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
											</td>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
						</body>",
						),
						array(
								'id'       => 'fl_email_payout_processed',
								'type'     => 'switch',
								'title'    => esc_html__( 'Want to send email when payout is processed?', 'exertio_theme' ),
								'default'  => false,
							),
							
							array(
								'id' => 'fl_email_payout_processed_sub',
								'type' => 'text',
								'title' => esc_html__('Subject for ayout processed email', 'exertio_theme'),
								'default' => esc_html__("Your montholy payout has been processed", 'exertio_theme'),
								'required' => array( array('fl_email_payout_processed','equals','1')),
							),
							array(
								'id' => 'fl_email_payout_processed_body',
								'type' => 'editor',
								'title' => esc_html__('Body text for payout processed email ', 'exertio_theme'),
								'required' => array( array('fl_email_payout_processed','equals','1')),
								'args' => array(
									'teeny' => true,
									'textarea_rows' => 20,
									'wpautop' => false,
								),
								'desc' => esc_html__('%site_name% , %display_name% will be translated accordingly.', 'exertio_theme'),
								'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%'>
						<!-- LOGO -->
						<tr>
							<td bgcolor='#5AADFF' align='center'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
											 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Welcome %display_name%,</h1>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0;  font-size: 18px !important;'>Your payout has been processed. Happy spending</p>
										</td>
									</tr>
									
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
										</td>
									</tr>
									<tr>
										<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
					
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
											<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
											<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
								<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
									<tr>
										<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
											<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>
					</table>
					</body>"
			),
			array(
				'id'       => 'fl_email_payout_create_admin',
				'type'     => 'switch',
				'title'    => esc_html__( 'Create Payout Email to Admin', 'exertio_theme' ),
				'default'  => false,
				'desc'     => esc_html__( 'You want to send email to admin when payout is created for user.', 'exertio_theme' ),
			),
			array(
				'id' => 'fl_email_payout_create_sub_admin',
				'type' => 'text',
				'title' => esc_html__('Subject for payout creation to Admin', 'exertio_theme'),
				'default' => esc_html__('A new payout has been created', 'exertio_theme'),
				'required' => array( array('fl_email_payout_create_admin','equals','1')),
			),
			array(
					'id' => 'fl_email_payout_create_body_admin',
					'type' => 'editor',
					'title' => esc_html__('Payout email body to Admin', 'exertio_theme'),
					'required' => array( array('fl_email_payout_create_admin','equals','1')),
					'args' => array(
						'teeny' => true,
						'textarea_rows' => 20,
						'wpautop' => false,
					),
					'desc' => esc_html__('%site_name% , %user_email%, %payout_amount% will be translated accordingly.', 'exertio_theme'),
					'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
		<table border='0' cellpadding='0' cellspacing='0' width='100%'>
			<!-- LOGO -->
			<tr>
				<td bgcolor='#5AADFF' align='center'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
						<tr>
							<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
						<tr>
							<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
								<img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello Admin,</h1> 
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
						<tr>
							<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
								<p style='margin: 0;  font-size: 18px !important;'>A new payout has been created. </p>
							</td>
						</tr>
						 <tr>
							<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
								<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> User Email</strong> : %user_email%</p>
							</td>
						</tr>
						<tr>
						<tr>
							<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 10px 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
								<p style='margin: 0;  font-size: 18px !important; padding-bottom:5px;'> <strong style='color:#111111'> Payout Amount</strong> : %payout_amount%</p>
							</td>
						</tr>
						<tr>
							<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
								<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
							</td>
						</tr>
						<tr>
							<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
								<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
						<tr>
							<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
								<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
								<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
					<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
						<tr>
							<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
								<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
							</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		</body>",
		),
        ),
        'subsection' => true,
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Identity Verification', 'exertio_theme' ),
        'id'         => 'verification_email_tab',
        'fields'     => array(
							array(
								'id'       => 'fl_email_identity_verify',
								'type'     => 'switch',
								'title'    => esc_html__( 'Verified Identity Email', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'You want to send email when user account is verified', 'exertio_theme' ),
							),
							array(
								'id' => 'fl_email_identity_verify_sub',
								'type' => 'text',
								'title' => esc_html__('Subject for Verified Email', 'exertio_theme'),
								'default' => esc_html__('Congratulations! Your account has been verified', 'exertio_theme'),
								'required' => array( array('fl_email_identity_verify','equals','1')),
							),
							array(
									'id' => 'fl_email_identity_verify_body',
									'type' => 'editor',
									'title' => esc_html__('Identity Verification Email Body', 'exertio_theme'),
									'required' => array( array('fl_email_identity_verify','equals','1')),
									'args' => array(
										'teeny' => true,
										'textarea_rows' => 20,
										'wpautop' => false,
									),
									'desc' => esc_html__('%site_name% , %display_name%, will be translated accordingly.', 'exertio_theme'),
									'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
						<table border='0' cellpadding='0' cellspacing='0' width='100%'>
							<!-- LOGO -->
							<tr>
								<td bgcolor='#5AADFF' align='center'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#5AADFF' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
												<img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='Your Logo Here' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hello %display_name%,</h1> 
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0;  font-size: 18px !important;'>Your account on %site_name% has been verified. </p>
											</td>
										</tr>
										 
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
											</td>
										</tr>
										<tr>
											<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service,<br>Scriptsbundle Team</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
												<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
												<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
									<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
										<tr>
											<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
												<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
											</td>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
						</body>",
						),
        ),
        'subsection' => true,
    ) );

	//email template for Package expire
    Redux::setSection($opt_name, array(
        'title' => __('Package Expiry Notification', "exertio_theme"),
        'id' => 'fl_email_templates15',
        'desc' => '',
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'package_expiry_notification',
                'type' => 'switch',
                'title' => __('Package Expiry Notification to Freelancer', 'exertio_theme'),
                'desc' => __('<b class="sb-admin-note"> Note : </b> This functionality works hiddenly notify the users before package expiry.This option takes a lot of load so any one who wishes to choose this option must have a good server that can support heavy load.', 'exertio_theme'),
                'default' => false,
            ),
            array(
                'id' => 'package_expire_notify_before',
                'type' => 'text',
                'title' => __('Package Expiry Notification before', 'exertio_theme'),
                'subtitle' => __('add the number of days before package expiry notification', 'exertio_theme'),
                'default' => 3,
                'desc' => __('should be integer value. <b>( Days )</b>', 'exertio_theme'),
                'required' => array('package_expiry_notification', '=', array(true)),
            ),
            array(
                'id' => 'fl_package_expiray_subject',
                'type' => 'text',
                'title' => __('Package Expiry SUBJECT to Freelancer', "exertio_theme"),
                'default' => 'Get message from Exertio profile.',
            ),
            array(
                'id' => 'fl_package_expiry_from',
                'type' => 'text',
                'title' => __('Package Expiry FROM', "exertio_theme"),
                'desc' => __('NAME valid@email.com is compulsory as we gave in default.', "exertio_theme"),
                'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
            ),
            array(
                'id' => 'fl_package_expiry_msg',
                'type' => 'editor',
                'title' => __('Package Expiry MESSAGE to Freelancer', "exertio_theme"),
                'args' => array(
                    'teeny' => true,
                    'textarea_rows' => 10,
                    'wpautop' => false,
                ),
                'desc' => __('%site_name% , %package_subcriber% , %package_name% , %no_of_days% will be translated accordingly.', "exertio_theme"),
                'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
				<table border='0' cellpadding='0' cellspacing='0' width='100%'>
					<!-- LOGO -->
					<tr>
						<td bgcolor='#3CBEB2' align='center'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
										 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hi, %display_name%!</h1>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
							    <tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
									<p style='margin: 0; font-size: 18px !important;' >Hello %package_subcriber%</p>
									<p style='margin: 0; font-size: 18px !important;' >Your Ads Package %package_name% will be expire after %no_of_days% Days. Please renew your package.</p>
									</td>
								</tr>
							
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
				
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
										<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
										<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
				</body>",
            ),
        )
    ));
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Hire Freelancer', 'exertio_theme' ),
        'id'         => 'hire_freelancer_email_tab',
        'fields'     => array(
							array(
								'id'       => 'fl_email_hire_freelancer',
								'type'     => 'switch',
								'title'    => esc_html__( 'Hire Freelancer button on freelancer detail page', 'exertio_theme' ),
								'default'  => true,
								'desc'     => esc_html__( 'it will show button on freelancer detail page to send invitation', 'exertio_theme' ),
							),
							array(
								'id' => 'fl_email_hire_freelancer_text',
								'type' => 'text',
								'title' => esc_html__('Hire Freelancer button text', 'exertio_theme'),
								'default' => esc_html__('Hire Now', 'exertio_theme'),
								'required' => array( array('fl_email_hire_freelancer','equals','1')),
							),
							array(
								'id' => 'fl_email_hire_freelancer_sub',
								'type' => 'text',
								'title' => esc_html__('Subject for Hire Freelancer Email', 'exertio_theme'),
								'default' => esc_html__('You got a new project invitation', 'exertio_theme'),
								'required' => array( array('fl_email_hire_freelancer','equals','1')),
							),
							array(
									'id' => 'fl_email_hire_freelancer_body',
									'type' => 'editor',
									'title' => esc_html__('Hire Freelancer Email Body', 'exertio_theme'),
									'required' => array( array('fl_email_hire_freelancer','equals','1')),
									'args' => array(
										'teeny' => true,
										'textarea_rows' => 20,
										'wpautop' => false,
									),
									'desc' => esc_html__('%site_name% , %display_name%, %project_title%, , %project_link% will be translated accordingly.', 'exertio_theme'),
									'default' => "<body style='background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;'>
				<table border='0' cellpadding='0' cellspacing='0' width='100%'>
					<!-- LOGO -->
					<tr>
						<td bgcolor='#3CBEB2' align='center'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td align='center' valign='top' style='padding: 40px 10px 40px 10px;'> </td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#3CBEB2' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='center' valign='top' style='padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;  font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;'>
										 <img src='".trailingslashit( get_template_directory_uri () ) . "/images/logo-dashboard.png"."' width='' height='' alt='' style='display: block; border: 0px;padding-top: 25px;' /><h1 style='font-size: 34px; font-weight: 400; margin: 2;'>Hi, %display_name%!</h1>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 0 30px; color: #666666;  font-size: 18px !important; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0;  font-size: 18px !important;'>You have a new project invitation on  <strong>%site_name%</strong> </p>
									</td>
								</tr>
								  <tr>
									<td bgcolor='#ffffff' align='left'>
										<table width='100%' border='0' cellspacing='0' cellpadding='0'>
											<tr>
												<td bgcolor='#ffffff' align='center' style='padding: 20px 30px 20px 30px;'>
													<table border='0' cellspacing='0' cellpadding='0'>
														<tr>
															<td align='center' style='border-radius: 3px;' bgcolor='#3CBEB2'><a href='%project_link%' target='_blank' style='font-size: 20px; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #3cbeb2; display: inline-block;'>%project_title%</a>
															</td>
															
														</tr>
														<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 20px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' ><strong>Copyable Link :</strong> %project_link%</p>
									</td>
								</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr> <!-- COPY -->
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 20px 30px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;' >If you have any questions, just reply to this email—we're always happy to help out.</p>
									</td>
								</tr>
								<tr>
									<td bgcolor='#ffffff' align='left' style='padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<p style='margin: 0; font-size: 18px !important;'>Thanks for choosing our service.<br>Scriptsbundle Team</p>
				
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 30px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#FFECD1' align='center' style='padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666;  font-size: 18px; font-weight: 400; line-height: 25px;'>
										<h2 style='font-size: 20px; font-weight: 400; color: #111111; margin: 0;'>Need more help?</h2>
										<p style='margin: 0;'><a href='#' target='_blank' style='color: #3cbeb2;'>We’re here to help you out</a></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor='#f4f4f4' align='center' style='padding: 0px 10px 0px 10px;'>
							<table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
								<tr>
									<td bgcolor='#f4f4f4' align='left' style='padding: 0px 30px 30px 30px; color: #666666;  font-size: 14px; font-weight: 400; line-height: 18px;'> <br>
										<p style='margin: 0;'>".date("Y")." © <a href='#' target='_blank' style='color: #111111; font-weight: 700;'>Scriptsbundle</a> ALL Rights Reserved.</p>
									</td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>
				</body>",
						),
        ),
        'subsection' => true,
    ) );
/* ------------------URL Rewriting Settings ----------------------- */
Redux::setSection( $opt_name, array(
    'title' => __('URL Rewriting', 'exertio_theme'),
    'id'    => 'url_rewriting',
    'icon' => 'el el-cogs',
) );
Redux::setSection($opt_name, array(
    'title' => __('Freelancer URL Rewriting', 'exertio_theme'),
    'id' => 'fl_url_rewriting',
    'desc' => '',
    'fields' => array(
        array(
            'id' => 'fl_url_rewriting_enable',
            'type' => 'switch',
            'title' => __('freelancer Ads', 'exertio_theme'),
            'default' => false,
        ),
        array(
            'id' => 'fl_ad_slug',
            'type' => 'text',
            'title' => __('freelancer ad slug', 'exertio_theme'),
            'required' => array('fl_url_rewriting_enable', '=', '1'),
            'default' => "",
        ),
    ),

    'subsection' => true,
));
Redux::setSection($opt_name, array(
    'title' => __('Employer URL Rewriting', 'exertio_theme'),
    'id' => 'em_url_rewriting',
    'desc' => '',
    'fields' => array(
        //URL for Employer
        array(
            'id' => 'em_url_rewriting_enable',
            'type' => 'switch',
            'title' => __('Employer Ads', 'exertio_theme'),
            'default' => false,
        ),
        array(
            'id' => 'em_ad_slug',
            'type' => 'text',
            'title' => __('Employer ad slug', 'exertio_theme'),
            'required' => array('em_url_rewriting_enable', '=', '1'),
            'default' => "",
        ),
    ),

    'subsection' => true,
));
    Redux::setSection( $opt_name, array(
        'title' => __( 'Projects', 'exertio_theme' ),
        'id'    => 'projects_options',
        'icon'  => 'el el-briefcase'
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Project', 'exertio_theme' ),
        'id'         => 'create_project',
        'fields'     => array(
					array(
						'id'       => 'fl_project_id_switch',
						'type'     => 'button_set',
						'title'    => __( 'Project ID', 'exertio_theme' ),
						'desc'     => __( 'Want to show project id on project detail page? ', 'exertio_theme' ),
						'options'  => array(
							'0' =>  __( 'No', 'exertio_theme' ),
							'1' => __( 'Yes', 'exertio_theme' ),
						),
						'default'  => '1',
					),
					array(
							'id'       => 'fl_project_id',
							'type'     => 'text',
							'title'    => esc_html__( 'Project ID code', 'exertio_theme' ),
							'default'  => 'EX-{ID}-lancer' ,
							'desc'     => '<strong>Important: </strong>' . esc_html__( 'Please use {ID} in your pattern as it will be replaced by the Project ID.', 'exertio_theme' ),
							'required' => array( 'fl_project_id_switch', '=', '1' ),
						),
					array(
						'id'       => 'projects_with_email_verified',
						'type'     => 'button_set',
						'title'    => __( 'Allow projects without email verification. ', 'exertio_theme' ),
						'desc'     => __( 'Set No, if you want a user to verify his email before posting a project.', 'exertio_theme' ),
						'options'  => array(
							'0' =>  __( 'No', 'exertio_theme' ),
							'1' => __( 'Yes', 'exertio_theme' ),
						),
						'default'  => '1',
					),
					array(
						'id'       => 'is_projects_paid',
						'type'     => 'button_set',
						'title'    => __( 'Project Paid or Free', 'exertio_theme' ),
						'desc'     => __( 'If you allow to submit free then user will be able to submit projects free of cost', 'exertio_theme' ),
						'options'  => array(
							'0' =>  __( 'Free', 'exertio_theme' ),
							'1' => __( 'Paid', 'exertio_theme' ),
						),
						'default'  => array( '0' )
					),
					
					array(
						'id'       => 'project_package_approval',
						'type'     => 'button_set',
						'title'    => __( 'Project Package Approval', 'exertio_theme' ),
						'desc'     => __( 'Admin approval means you have to approve each package manually.', 'exertio_theme' ),

						'options'  => array(
							'0' =>  __( 'Admin Approval', 'exertio_theme' ),
							'1' => __( 'Auto Approval', 'exertio_theme' ),
						),
						'default'  => array( '0' )
					),

					array(
							'id'       => 'whizzchat_project_option',
							'type'     => 'switch',
							'title'    => __( 'Live Chat using WhizzChat on Projects', 'exertio_theme' ),
							'subtitle' => __( 'Enable this if you want to use live chat using whizzChat Chat Plugin', 'exertio_theme' ),
							'default'  => 0,
							'on'       => __( 'Enabled', 'exertio_theme' ),
							'off'      => __( 'Disabled', 'exertio_theme' ),
						),
					array(
							'id'       => 'turn_project_messaging',
							'type'     => 'switch',
							'title'    => __( 'Want to activate messaging?', 'exertio_theme' ),
							'subtitle' => __( 'Enable this if you want to use simple messaging ', 'exertio_theme' ),
							'default'  => 1,
							'on'       => __( 'Enabled', 'exertio_theme' ),
							'off'      => __( 'Disabled', 'exertio_theme' ),
						),
					array(
						'id'       => 'project_default_expiry',
						'type'     => 'text',
						'title'    => __( 'Default project expiry in days', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric value in days only.', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '5',
					),
					array(
						'id'       => 'default_featured_project_expiry',
						'type'     => 'text',
						'title'    => __( 'Default featured project expiry in days', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric value in days only.', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '5',
					),
					array(
						'id'       => 'project_approval',
						'type'     => 'button_set',
						'title'    => __( 'Create Project Approval', 'exertio_theme' ),
						'desc'     => __( 'Admin approval means you have to approve each project manually.', 'exertio_theme' ),
						'options'  => array(
							'0' =>  __( 'Admin Approval', 'exertio_theme' ),
							'1' => __( 'Auto Approval', 'exertio_theme' ),
						),
						'default'  => array( '0' )
					),
					array(
						'id'       => 'update_project_approval',
						'type'     => 'button_set',
						'title'    => __( 'Update project approval', 'exertio_theme' ),
						'desc'     => __( 'Admin approval means you have to approve each project manually.', 'exertio_theme' ),
						
						'options'  => array(
							'0' => __( 'Admin Approval', 'exertio_theme' ),
							'1' => __( 'Auto Approval', 'exertio_theme' ),
						),
						'default'  => array( '0' )
					),
					array(
								'id'       => 'allow_projects_proposal',
								'type'     => 'switch',
								'title'    => __( 'Allow Project Proposal', 'exertio_theme' ),
								'default'  => true,
								'on'       => __( 'Enabled', 'exertio_theme' ),
								'off'      => __( 'Disabled', 'exertio_theme' ),
							),
					array(
								'id'       => 'allow_free_proposal_sending',
								'type'     => 'switch',
								'title'    => __( 'Allow Free Proposal Sending', 'exertio_theme' ),
								'default'  => false,
								'on'       => __( 'Enabled', 'exertio_theme' ),
								'off'      => __( 'Disabled', 'exertio_theme' ),
								'required' => array( 'allow_projects_proposal', '=', true ),
							),
					array(
								'id'       => 'show_project_proposal',
								'type'     => 'switch',
								'title'    => __( 'Allow Proposal to show publically.', 'exertio_theme' ),
								'default'  => 0,
								'on'       => __( 'Enabled', 'exertio_theme' ),
								'off'      => __( 'Disabled', 'exertio_theme' ),
							),
					array(
								'id'       => 'show_project_winner',
								'type'     => 'switch',
								'title'    => __( 'Allow Project winner to show publically.', 'exertio_theme' ),
								'default'  => 0,
								'on'       => __( 'Enabled', 'exertio_theme' ),
								'off'      => __( 'Disabled', 'exertio_theme' ),
							),
					array(
								'id'       => 'allow_project_milestones',
								'type'     => 'switch',
								'title'    => __( 'Allow project milestone creation for payments', 'exertio_theme' ),
								'default'  => 0,
								'on'       => __( 'Yes', 'exertio_theme' ),
								'off'      => __( 'No', 'exertio_theme' ),
							),
					array(
								'id'       => 'allow_project_tip_reward',
								'type'     => 'switch',
								'title'    => __( 'Allow tip or reward on project completion', 'exertio_theme' ),
								'default'  => 0,
								'on'       => __( 'Yes', 'exertio_theme' ),
								'off'      => __( 'No', 'exertio_theme' ),
							),
					array(
						'id'            => 'project_charges',
						'type'          => 'slider',
						'title'         => __( 'Project charges in percentage', 'exertio_theme' ),
						'subtitle'      => __( 'What percentage do you want to charge to your customers? It will be applied to all projects on your website.', 'exertio_theme' ),
						'desc'          => __( 'Min: 0, max: 100 %,', 'exertio_theme' ),
						'default'       => 5,
						'min'           => 0,
						'step'          => 1,
						'max'           => 100,
						'display_value' => 'label'
					),
					array(
							'id'       => 'show_project_attachment_public',
							'type'     => 'switch',
							'title'    => __( 'Show project attachments to non-logged-in people.', 'exertio_theme' ),
							'default'  => 0,
							'on'       => __( 'Enabled', 'exertio_theme' ),
							'off'      => __( 'Disabled', 'exertio_theme' ),
						),
					array(
						'id'       => 'project_attachment_count',
						'type'     => 'text',
						'title'    => __( 'No of attachmenets allowed', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '5',
					),
					array(
						'id'       => 'project_attachment_size',
						'type'     => 'text',
						'title'    => __( 'Project attachment max size', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
						'desc'     => __( 'Attachment size should be in KB. 1Mb = 1000 Kb', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '500',
					),
					array(
						'id'       => 'create_section',
						'type'     => 'section',
						'title'    => __( 'Create Project', 'exertio_theme' ),
						'subtitle' => __( 'Create Project option will be here.', 'exertio_theme' ),
						'indent'   => true,  
					),
					array(
						'id'       => 'create_icon',
						'type'     => 'text',
						'title'    => __( 'Create project textarea icon', 'exertio_theme' ),
						'desc' => __( 'You can use use icon from <a href="https://fontawesome.com/icons?d=gallery" target="_blank">this list</a>', 'exertio_theme' ),
					),
					array(
						'id'       => 'create_msg',
						'type'     => 'textarea',
						'title'    => __( 'Text to show on top of create project page. Leave it empty if you do not want to show any thing over there', 'exertio_theme' ),
						'desc' => __( 'It will be visible to customers on their profile dashboard.', 'exertio_theme' ),
					),
					array(
						'id'       => 'mark_featured_title',
						'type'     => 'text',
						'title'    => __( 'Mark Featured Project Title', 'exertio_theme' ),
						'desc' => __( 'Heading for the Mark as featured on create project page', 'exertio_theme' ),
					),
					array(
						'id'       => 'mark_featured_desc',
						'type'     => 'textarea',
						'title'    => __( 'Text to show on below the heading featured project. Leave it empty if you do not want to show any thing over there', 'exertio_theme' ),
						'desc' => __( 'It will be visible to customers on create project page.', 'exertio_theme' ),
					),
					array(
						'id'       => 'tips_switch',
						'type'     => 'switch',
						'title'    => __( 'Enable or Disable tips option', 'exertio_theme' ),
						'default'  => true,
						'on'       => 'Enable',
						'off'      => 'Disable',
					),
                    array(
                        'id'       => 'allow_project_propsal_amount',
                        'type'     => 'switch',
                        'title'    => __( 'Enable to Detect proposal amount', 'exertio_theme' ),
                        'default'  => false,
                        'on'       => 'Enable',
                        'off'      => 'Disable',
                    ),
					array(
						'id'          => 'project_slides',
						'type'        => 'slides',
						'title'       => __( 'Tips for creating projects', 'exertio_theme' ),
						'subtitle'    => __( 'You can add multiple tips and these will show on create project page.', 'exertio_theme' ),
						'desc'        => __( 'You can drag and drop to re-arrange.', 'exertio_theme' ),
						'required' => array( 'tips_switch', '=', true ),
						'placeholder' => array(
							'title'       => __( 'Tip title', 'exertio_theme' ),
							'description' => __( 'Description', 'exertio_theme' ),
						),
						'show' => array(
							'title' => true,
							'description' => true,
							'url' => false,
							),
					),
                    array(
                        'id'       => 'project_type_allowed',
                        'type'     => 'button_set',
                        'title'    => __( 'Project Type Allowed', 'exertio_theme' ),
                        'subtitle' => __( 'Select option to show Project type Only fixed, or both', 'exertio_theme' ),
                        'options'  => array(
                            '1' => 'Only fixed',
                            '2' => 'Both',
                        ),
                        'default'  => '2'
                    ),
					array(
									'id'       => 'project-show-hide-fields',
									'type'     => 'section',
									'title'    => __( 'Required/Show/Hide Fields', 'exertio_theme' ),
									'subtitle' => __( 'All options to show hide or required fields fields', 'exertio_theme' ),
									'indent'   => true,  
								),
								array(
									'id'       => 'project_title',
									'type'     => 'button_set',
									'title'    => __( 'Project Title', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_category',
									'type'     => 'button_set',
									'title'    => __( 'Project Category', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_cost',
									'type'     => 'button_set',
									'title'    => __( 'Project cost', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_freelancer_type',
									'type'     => 'button_set',
									'title'    => __( 'Project type', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_duration',
									'type'     => 'button_set',
									'title'    => __( 'Project duration', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_level',
									'type'     => 'button_set',
									'title'    => __( 'Project level', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_english_level',
									'type'     => 'button_set',
									'title'    => __( 'Project english level', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_location',
									'type'     => 'button_set',
									'title'    => __( 'Project location', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_skills',
									'type'     => 'button_set',
									'title'    => __( 'Project skills', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_languages',
									'type'     => 'button_set',
									'title'    => __( 'Project languages', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'project_address',
									'type'     => 'button_set',
									'title'    => __( 'Project address', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
										'id'     => 'project-show-hide-fields-end',
										'type'   => 'section',
										'indent' => false,  
									),

        ),
        'subsection' => true,
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Project Search', 'exertio_theme' ),
        'id'         => 'project-service',
        'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'project_sidebar',
								'type'     => 'button_set',
								'title'    => __( 'Project Sidebar Position', 'exertio_theme' ),
								'desc'     => __( 'Select the Project side bar postion.', 'exertio_theme' ),
								'options'  => array(
									'left' => 'Left',
									'right' => 'Right',
								),
								'default'  => array( 'left' )
							),
                            array(
                                'id'       => 'project_sidebar_layout',
                                'type'     => 'button_set',
                                'title'    => __( 'Project Search page Layout', 'exertio_theme' ),
                                'desc'     => __( 'Select the Search Page layout.', 'exertio_theme' ),
                                'options'  => array(
                                    '1' => 'Project Detail',
                                    '2' => 'Project & Author Detail',
                                ),
                                'default'  => array( '1' )
                            ),
							array(
								'id'       => 'project_sidebar_count',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Filters Count', 'exertio_theme' ),
								'desc'     => __( 'Select count for the terms should visible or hidden. ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
								'id'       => 'project_sidebar_show_all_terms',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Show terms', 'exertio_theme' ),
								'desc'     => __( 'Show only terms which has posts in it ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
									'id'       => 'project_search_sidebar_text',
									'type'     => 'textarea',
									'title'    => __( 'Sidebar Filter Text', 'exertio_theme' ),
									'desc'     => __( 'Text to show over the project sidebar above the filter button.', 'exertio_theme' ),
								),
							array(
								'id'       => 'project_listing_style',
								'type'     => 'button_set',
								'title'    => __( 'Project Listing style', 'exertio_theme' ),
								'desc'     => __( 'Only one can be selected at a time.', 'exertio_theme' ),
								'options'  => array(
									'list_1' => 'List 1',
									'list_2' => 'List 2',
									'list_3' => 'List 3',
								),
								'default'  => 'list_1'
							),
							array(
								'id'       => 'project_search_title_limit',
								'type'     => 'text',
								'title'    => __( 'Project title limit', 'exertio_theme' ),
								'desc'     => __( 'This will be applied on Project Search only', 'exertio_theme' ),
								'validate' => 'numeric',
							),
							array(
								'id'       => 'expired_project_search',
								'type'     => 'button_set',
								'title'    => __( 'Want to show expired projects in search as well?', 'exertio_theme' ),
								'options'  => array(
									'1' => __( 'Yes', 'exertio_theme' ),
									'0' => __( 'No', 'exertio_theme' ),
								),
								'default'  => array( '0' )
							),
							array(
									'id'       => 'project_search_ad1',
									'type'     => 'textarea',
									'title'    => __( 'Search advertisement on top ', 'exertio_theme' ),
									'desc'     => __( 'Advertisement that will be shown over the search top.', 'exertio_theme' ),
								),
							array(
								'id'       => 'project_search_ad2',
								'type'     => 'textarea',
								'title'    => __( 'Search advertisement on Bottom ', 'exertio_theme' ),
								'desc'     => __( 'Advertisement that will be shown over the search bottom after the jobs.', 'exertio_theme' ),
							),
        ),
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Project Detail', 'exertio_theme' ),
        'id'         => 'project_detail',
        'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'project_cf_title',
								'type'     => 'text',
								'title'    => __( 'Project Custom Fields Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
									'id'       => 'project_detail_ad1',
									'type'     => 'textarea',
									'title'    => __( 'Search detil advertisement on top ', 'exertio_theme' ),
									'desc'     => __( 'Advertisement that will be shown over the search top.', 'exertio_theme' ),
								),
							array(
								'id'       => 'project_detail_ad2',
								'type'     => 'textarea',
								'title'    => __( 'Search detail advertisement on Bottom ', 'exertio_theme' ),
								'desc'     => __( 'Advertisement that will be shown over the search bottom after the jobs.', 'exertio_theme' ),
							),
							array(
									'id'       => 'project_detail_sidebar_ad1',
									'type'     => 'textarea',
									'title'    => __( 'Search detail advertisement in sidebar ', 'exertio_theme' ),
									'desc'     => __( 'Advertisement that will be shown over the search top.', 'exertio_theme' ),
								),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Bid Addons', 'exertio_theme' ),
        'id'         => 'project_addons',
        'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'bid_tems_link',
								'type'     => 'text',
								'title'    => __( 'Provide a link for term and conditions page on send proposal page.', 'exertio_theme' ),
								'validate' => 'url',
								'desc' => __( 'Must be a valid llink of a page', 'exertio_theme' ),
							),
							array(
								'id'       => 'project_feature_addon-section',
								'type'     => 'section',
								'title'    => __( 'Project featured addon section', 'exertio_theme' ),
								'indent'   => true,
							),
							array(
								'id'       => 'project_featured_bid_addon',
								'type'     => 'switch',
								'title'    => __( 'Want to turn on featured bid addon', 'exertio_theme' ),
								'default'  => 0,
								'on'       => 'Enabled',
								'off'      => 'Disabled',
							),
							array(
								'id'       => 'project_featured_addon_title',
								'type'     => 'text',
								'title'    => __( 'Title for the featured bid addon', 'exertio_theme' ),
								'required' => array( 'project_featured_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_featured_addon_price',
								'type'     => 'text',
								'title'    => __( 'Provide featured bid addon price', 'exertio_theme' ),
								'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
								'validate' => 'numeric',
								'default'  => '',
								'required' => array( 'project_featured_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_featured_addon_icon',
								'type'     => 'text',
								'title'    => __( 'Add icon for featured bid addon', 'exertio_theme' ),
								'desc' => __( 'You can use use icon from <a href="https://fontawesome.com/icons?d=gallery" target="_blank">this list</a>', 'exertio_theme' ),
								'required' => array( 'project_featured_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_featured_addon_desc',
								'type'     => 'textarea',
								'title'    => __( 'Description', 'exertio_theme' ),
								'desc' => __( 'Description for featured bid addon.', 'exertio_theme' ),
								'required' => array( 'project_featured_bid_addon', '=', '1' ),
							),
							
							/*Sealed Addon*/
							
							array(
								'id'       => 'project_sealed_addon-section',
								'type'     => 'section',
								'title'    => __( 'Project sealed addon section', 'exertio_theme' ),
								'indent'   => true,  
							),
							array(
								'id'       => 'project_sealed_bid_addon',
								'type'     => 'switch',
								'title'    => __( 'Want to turn on sealed bid addon', 'exertio_theme' ),
								'default'  => 0,
								'on'       => 'Enabled',
								'off'      => 'Disabled',
							),
							array(
								'id'       => 'project_sealed_addon_title',
								'type'     => 'text',
								'title'    => __( 'Title for the sealed bid addon', 'exertio_theme' ),
								'required' => array( 'project_sealed_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_sealed_addon_price',
								'type'     => 'text',
								'title'    => __( 'Provide sealed bid addon price', 'exertio_theme' ),
								'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
								'validate' => 'numeric',
								'default'  => '',
								'required' => array( 'project_sealed_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_sealed_addon_icon',
								'type'     => 'text',
								'title'    => __( 'Add icon for sealed bid addon', 'exertio_theme' ),
								'desc' => __( 'You can use use icon from <a href="https://fontawesome.com/icons?d=gallery" target="_blank">this list</a>', 'exertio_theme' ),
								'required' => array( 'project_sealed_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_sealed_addon_desc',
								'type'     => 'textarea',
								'title'    => __( 'Description', 'exertio_theme' ),
								'desc' => __( 'Description for sealed bid addon.', 'exertio_theme' ),
								'required' => array( 'project_sealed_bid_addon', '=', '1' ),
							),
							
							/*TOP ADON DETAIL*/
							
							array(
								'id'       => 'project_top_addon-section',
								'type'     => 'section',
								'title'    => __( 'Project top addon section', 'exertio_theme' ),
								'indent'   => true,  
							),
							array(
								'id'       => 'project_top_bid_addon',
								'type'     => 'switch',
								'title'    => __( 'Want to turn on top bid addon', 'exertio_theme' ),
								'default'  => 0,
								'on'       => 'Enabled',
								'off'      => 'Disabled',
							),
							array(
								'id'       => 'project_top_addon_title',
								'type'     => 'text',
								'title'    => __( 'Title for the top bid addon', 'exertio_theme' ),
								'required' => array( 'project_top_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_top_addon_price',
								'type'     => 'text',
								'title'    => __( 'Provide top bid addon price', 'exertio_theme' ),
								'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
								'validate' => 'numeric',
								'default'  => '',
								'required' => array( 'project_top_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_top_addon_icon',
								'type'     => 'text',
								'title'    => __( 'Add icon for top bid addon', 'exertio_theme' ),
								'desc' => __( 'You can use use icon from <a href="https://fontawesome.com/icons?d=gallery" target="_blank">this list</a>', 'exertio_theme' ),
								'required' => array( 'project_top_bid_addon', '=', '1' ),
							),
							array(
								'id'       => 'project_top_addon_desc',
								'type'     => 'textarea',
								'title'    => __( 'Description', 'exertio_theme' ),
								'desc' => __( 'Description for top bid addon.', 'exertio_theme' ),
								'required' => array( 'project_top_bid_addon', '=', '1' ),
							),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'Services', 'exertio_theme' ),
        'id'    => 'services_options',
        'icon'  => 'el el-cog'
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Services', 'exertio_theme' ),
        'id'         => 'services',
        'fields'     => array(
						array(
							'id'       => 'fl_service_id',
							'type'     => 'text',
							'title'    => esc_html__( 'Service ID', 'exertio_theme' ),
							'default'  => 'EX-{ID}' ,
							'desc'     => '<strong>Important: </strong>' . esc_html__( 'Please use {ID} in your pattern as it will be replaced by the Service ID.', 'exertio_theme' ),
						),
						array(
						'id'       => 'is_services_paid',
						'type'     => 'button_set',
						'title'    => __( 'Services Paid or Free', 'exertio_theme' ),
						'desc'     => __( 'If you allow to submit free then user will be able to submit services free of cost', 'exertio_theme' ),
						
						'options'  => array(
							'0' =>  __( 'Free', 'exertio_theme' ),
							'1' => __( 'Paid', 'exertio_theme' ),
						),
						'default'  => array( '0' )
					),
					array(
						'id'       => 'services_package_approval',
						'type'     => 'button_set',
						'title'    => __( 'Services Package Approval', 'exertio_theme' ),
						'desc'     => __( 'Admin approval means you have to approve each package manually.', 'exertio_theme' ),
						
						'options'  => array(
							'0' =>  __( 'Admin Approval', 'exertio_theme' ),
							'1' => __( 'Auto Approval', 'exertio_theme' ),
						),
						'default'  => array( '0' )
					),
					array(
							'id'       => 'whizzchat_service_option',
							'type'     => 'switch',
							'title'    => __( 'Live Chat using WhizzChat on Services', 'exertio_theme' ),
							'subtitle' => __( 'Enable this if you want to use live chat using whizzChat Chat Plugin', 'exertio_theme' ),
							'default'  => 0,
							'on'       => __( 'Enabled', 'exertio_theme' ),
							'off'      => __( 'Disabled', 'exertio_theme' ),
						),
					array(
							'id'       => 'turn_services_messaging',
							'type'     => 'switch',
							'title'    => __( 'Want to activate messaging on services?', 'exertio_theme' ),
							'subtitle' => __( 'Enable this if you want to use simple messaging ', 'exertio_theme' ),
							'default'  => 1,
							'on'       => __( 'Enabled', 'exertio_theme' ),
							'off'      => __( 'Disabled', 'exertio_theme' ),
						),
					array(
						'id'       => 'service_default_expiry',
						'type'     => 'text',
						'title'    => __( 'Default service expiry in days', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric value in days only.', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '5',
					),
					array(
						'id'       => 'default_featured_service_expiry',
						'type'     => 'text',
						'title'    => __( 'Default featured services expiry in days', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric value in days only.', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '5',
					),
                    array(
                        'id'       => 'service_featured_title',
                        'type'     => 'text',
                        'title'    => __( 'Services Featured Title', 'exertio_theme' ),
                        'subtitle' => __( 'This will be shown over the add services page.', 'exertio_theme' ),
                    ),
                    array(
                        'id'       => 'featured_services_detail',
                        'type'     => 'textarea',
                        'title'    => __( 'Services Featured description text', 'exertio_theme' ),
                        'subtitle' => __( 'This will be shown over the add services page.', 'exertio_theme' ),

                    ),
					
        ),
        'subsection' => true,
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Services Addons', 'exertio_theme' ),
        'id'         => 'services-addons',
        'subsection' => true,
        'fields'     => array(
						array(
						'id'       => 'addons_approval',
						'type'     => 'button_set',
						'title'    => __( 'Create Addons approval', 'exertio_theme' ),
						'desc'     => __( 'Admin approval means you have to approve each Addon manually from backend.', 'exertio_theme' ),
						
						'options'  => array(
							'0' => 'Admin Approval',
							'1' => 'Auto Approval',
						),
						'default'  => array( '1' )
					),	
					array(
						'id'       => 'addons_update_approval',
						'type'     => 'button_set',
						'title'    => __( 'Update Addons approval', 'exertio_theme' ),
						'desc'     => __( 'Admin approval means you have to approve each Addon manually from backend.', 'exertio_theme' ),
						
						'options'  => array(
							'0' => 'Admin Approval',
							'1' => 'Auto Approval',
						),
						'default'  => array( '1' )
					),
        ),
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Add Services', 'exertio_theme' ),
        'id'         => 'add-service',
        'subsection' => true,
        'fields'     => array(
								array(
									'id'       => 'services_with_email_verified',
									'type'     => 'button_set',
									'title'    => __( 'Allow services without email verification. ', 'exertio_theme' ),
									'desc'     => __( 'Set No, if you want a user to verify his email before posting a service.', 'exertio_theme' ),
									'options'  => array(
										'0' =>  __( 'No', 'exertio_theme' ),
										'1' => __( 'Yes', 'exertio_theme' ),
									),
									'default'  => '1',
								),
								array(
									'id'       => 'service_approval',
									'type'     => 'button_set',
									'title'    => __( 'Create Service approval', 'exertio_theme' ),
									'desc'     => __( 'Admin approval means you have to approve each Service manually from backend.', 'exertio_theme' ),
										'options'  => array(
										'0' => 'Admin Approval',
										'1' => 'Auto Approval',
									),
									'default'  => array( '1' )
								),	
								array(
									'id'       => 'service_update_approval',
									'type'     => 'button_set',
									'title'    => __( 'Update Service approval', 'exertio_theme' ),
									'desc'     => __( 'Admin approval means you have to approve each Service manually from backend.', 'exertio_theme' ),
										'options'  => array(
										'0' => 'Admin Approval',
										'1' => 'Auto Approval',
									),
									'default'  => array( '1' )
								),
								array(
									'id'            => 'service_charges',
									'type'          => 'slider',
									'title'         => __( 'Service charges in percentage to freelancers', 'exertio_theme' ),
									'subtitle'      => __( 'What percentage do you want to charge to your customers? It will be applied to all services on your website.', 'exertio_theme' ),
									'desc'          => __( 'Min: 0, max: 100 %,', 'exertio_theme' ),
									'default'       => 0,
									'min'           => 0,
									'step'          => 1,
									'max'           => 100,
									'display_value' => 'label'
								),
								array(
									'id'            => 'service_charges_employer',
									'type'          => 'slider',
									'title'         => __( 'Service charges in percentage to employers', 'exertio_theme' ),
									'subtitle'      => __( 'What percentage do you want to charge to your clients while purchasing the services? It will be applied to all services on your website.', 'exertio_theme' ),
									'desc'          => __( 'Min: 0, max: 100 %,', 'exertio_theme' ),
									'default'       => 0,
									'min'           => 0,
									'step'          => 1,
									'max'           => 100,
									'display_value' => 'label'
								),
								array(
									'id'       => 'service-youtube-links',
									'type'     => 'switch',
									'title'    => __( 'Enable Youtube Link on Add Service page', 'exertio_theme' ),
									'subtitle' => __( 'Enabling this option will Allow users to post videos via Youtube Link', 'exertio_theme' ),
									'default'  => 0,
									'on'       => 'Enabled',
									'off'      => 'Disabled',
								),
								array(
									'id'       => 'sevices_youtube_links_count',
									'type'     => 'text',
									'title'    => __( 'No of Videos allowed', 'exertio_theme' ),
									'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
									'validate' => 'numeric',
									'default'  => 5,
								),
								array(
									'id'       => 'service-faqs',
									'type'     => 'switch',
									'title'    => __( 'Allow FAQs', 'exertio_theme' ),
									'subtitle' => __( 'Enabling this option will Allow users to post FAQs while posting a service', 'exertio_theme' ),
									'default'  => 'yes',
									'on'       => 'Yes',
									'off'      => 'No',
								),
								
								array(
									'id'       => 'sevices_faqs_count',
									'type'     => 'text',
									'title'    => __( 'No of Allowed FAQs', 'exertio_theme' ),
									'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
									'validate' => 'numeric',
									'default'  => '5',
									'required' => array( 'service-faqs', '=', 1 ),
								),
								
								
								array(
									'id'       => 'sevices_attachment_count',
									'type'     => 'text',
									'title'    => __( 'No of attachmenets allowed', 'exertio_theme' ),
									'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
									'validate' => 'numeric',
									'default'  => '5',
								),
								array(
									'id'       => 'services_attachment_size',
									'type'     => 'text',
									'title'    => __( 'Single Service attachment max size', 'exertio_theme' ),
									'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
									'desc'     => __( 'Attachment size should be in KB. 1Mb = 1000 Kb', 'exertio_theme' ),
									'validate' => 'numeric',
									'default'  => '500',
								),
								
								
								
								
								
								
								array(
									'id'       => 'services-show-hide-fields',
									'type'     => 'section',
									'title'    => __( 'Required/Show/Hide Fields', 'exertio_theme' ),
									'subtitle' => __( 'All options to show hide or required fields fields', 'exertio_theme' ),
									'indent'   => true,  
								),
								array(
									'id'       => 'service_title',
									'type'     => 'button_set',
									'title'    => __( 'Service Title', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'service_price',
									'type'     => 'button_set',
									'title'    => __( 'Service Price', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'service_category',
									'type'     => 'button_set',
									'title'    => __( 'Service Category', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'services_english_level',
									'type'     => 'button_set',
									'title'    => __( 'English Level', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'services_response_time',
									'type'     => 'button_set',
									'title'    => __( 'Service Response time', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'services_delivery_time',
									'type'     => 'button_set',
									'title'    => __( 'Service Delivery time', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'services_location',
									'type'     => 'button_set',
									'title'    => __( 'Service Location', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
									'id'       => 'services_address',
									'type'     => 'button_set',
									'title'    => __( 'Service Map Address', 'exertio_theme' ),
									'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
										'options'  => array(
										'1' => 'Required',
										'2' => 'Not Required',
										'3' => 'Hide',
									),
									'default'  => '2'
								),
								array(
										'id'     => 'services-show-hide-fields-end',
										'type'   => 'section',
										'indent' => false,  
									),
								
											
        ),
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Services Details', 'exertio_theme' ),
        'id'         => 'service_detail',
        'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'service_social_share',
								'type'     => 'switch',
								'title'    => __( 'Enable Social Share on Detail Service page', 'exertio_theme' ),
								'subtitle' => __( 'Enabling this option will Allow users to share services on social media', 'exertio_theme' ),
								'default'  => 1,
								'on'       => 'Enabled',
								'off'      => 'Disabled',
							),
							array(
									'id'       => 'service_review',
									'type'     => 'switch',
									'title'    => __( 'Show Reviews detail publically', 'exertio_theme' ),
									'subtitle' => __( 'Enabling this option will Allow users to see all review details on service detail page', 'exertio_theme' ),
									'default'  => 'on',
									'on'       => 'Yes',
									'off'      => 'No',
								),
							array(
								'id'       => 'whizzchat_service_detail_option',
								'type'     => 'switch',
								'title'    => __( 'Live Chat using WhizzChat on Service Detail Page', 'exertio_theme' ),
								'subtitle' => __( 'Enable this if you want to use live chat using whizzChat Chat Plugin', 'exertio_theme' ),
								'default'  => 0,
								'on'       => __( 'Enabled', 'exertio_theme' ),
								'off'      => __( 'Disabled', 'exertio_theme' ),
							),
								array(
									'id'       => 'sevices_review_title',
									'type'     => 'text',
									'title'    => __( 'Reviews heading title on detail page', 'exertio_theme' ),
								),
							array(
									'id'       => 'sevices_faqs_title',
									'type'     => 'text',
									'title'    => __( 'FAQs heading title on detail page', 'exertio_theme' ),
									'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
								),
							array(
									'id'       => 'service_related_posts',
									'type'     => 'switch',
									'title'    => __( 'Show Related services', 'exertio_theme' ),
									'subtitle' => __( 'Enabling this option will show related services on service detail page', 'exertio_theme' ),
									'default'  => 1,
									'1'       => 'Yes',
									'0'      => 'No',
								),
								
								array(
									'id'       => 'service_related_posts_title',
									'type'     => 'text',
									'title'    => __( 'Related Services heading title on detail page', 'exertio_theme' ),
									'required' => array( 'service_related_posts', '=', 1 ),
								),
								array(
									'id'       => 'servcies_cf_title',
									'type'     => 'text',
									'title'    => __( 'Servcies Custom Fields Title', 'exertio_theme' ),
									'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
								),
								array(
									'id'       => 'service_related_posts_count',
									'type'     => 'text',
									'title'    => __( 'Number of Related Services to show', 'exertio_theme' ),
									'required' => array( 'service_related_posts', '=', 1 ),
								),
							array(
								'id'       => 'below_addon_desc',
								'type'     => 'textarea',
								'title'    => __( 'Addon Description', 'exertio_theme' ),
								'desc' => __( 'Description that will be shown under the Addons on service detail page.', 'exertio_theme' ),
							),
							array(
								'id'       => 'service_ad_1',
								'type'     => 'textarea',
								'title'    => __( 'Advertisement 1', 'exertio_theme' ),
								'desc' => __( 'Advertisement that will be shown on top part of the service detail page.', 'exertio_theme' ),
							),
							array(
								'id'       => 'service_ad_2',
								'type'     => 'textarea',
								'title'    => __( 'Advertisement 2', 'exertio_theme' ),
								'desc' => __( 'Advertisement that will be shown on bottom part of the service detail page.', 'exertio_theme' ),
							),
							array(
								'id'       => 'sidebar_service_ad_1',
								'type'     => 'textarea',
								'title'    => __( 'Sidebar Advertisement 1', 'exertio_theme' ),
								'desc' => __( 'Advertisement that will be shown on top part of the service detail page.', 'exertio_theme' ),
							),
							array(
								'id'       => 'sidebar_service_ad_2',
								'type'     => 'textarea',
								'title'    => __( 'Sidebar Advertisement 2', 'exertio_theme' ),
								'desc' => __( 'Advertisement that will be shown on bottom part of the service detail page.', 'exertio_theme' ),
							),
        ),
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Services Search', 'exertio_theme' ),
        'id'         => 'serach-service',
        'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'services_default_img',
								'type'     => 'media',
								'url'      => true,
								'title'    => __( 'Default image for services', 'exertio_theme' ),
								'compiler' => 'true',
								'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/logo-dashboard.svg' ),
							),
							array(
								'id'       => 'service_sidebar',
								'type'     => 'button_set',
								'title'    => __( 'Services Sidebar Position', 'exertio_theme' ),
								'desc'     => __( 'Select the services side bar postion.', 'exertio_theme' ),
								'options'  => array(
									'left' => 'Left',
									'right' => 'Right',
								),
								'default'  => 'left',
							),
							array(
								'id'       => 'services_sidebar_count',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Filters Count', 'exertio_theme' ),
								'desc'     => __( 'Select count for the terms should visible or hidden. ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
								'id'       => 'services_sidebar_show_all_terms',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Show terms', 'exertio_theme' ),
								'desc'     => __( 'Show only terms which has posts in it ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
									'id'       => 'sevices_search_sidebar_text',
									'type'     => 'textarea',
									'title'    => __( 'Sidebar Filter Text', 'exertio_theme' ),
									'desc'     => __( 'Text to show over the services sidebar above the filter button.', 'exertio_theme' ),
								),
							array(
								'id'       => 'service_grid_style',
								'type'     => 'button_set',
								'title'    => __( 'Services Listing style', 'exertio_theme' ),
								'desc'     => __( 'Only one can be selected at a time.', 'exertio_theme' ),
								'options'  => array(
									'grid_1' => 'Grid 1',
									'grid_2' => 'Grid 2',
								),
								'default'  => 'grid_1',
							),
							array(
								'id'       => 'service_grid_size',
								'type'     => 'button_set',
								'title'    => __( 'Services Grids in a Row', 'exertio_theme' ),
								'desc'     => __( 'Only one can be selected at a time.', 'exertio_theme' ),
								'options'  => array(
									'0' => '3 In a Row',
									'1' => '2 In a Row',
								),
								'default'  => '0',
							),
							array(
								'id'       => 'service_listing_style',
								'type'     => 'button_set',
								'title'    => __( 'Services Listing style', 'exertio_theme' ),
								'desc'     => __( 'Only one can be selected at a time.', 'exertio_theme' ),
								'options'  => array(
									'list_1' => 'List 1',
									'list_2' => 'List 2',
								),
								'default'  => 'list_1',
							),
							array(
								'id'       => 'sevices_search_title_limit_grid',
								'type'     => 'text',
								'title'    => __( 'Services grids style title limit', 'exertio_theme' ),
								'desc'     => __( 'This will be applied on services search grids only', 'exertio_theme' ),
								'validate' => 'numeric',
							),
							array(
								'id'       => 'sevices_search_title_limit_list',
								'type'     => 'text',
								'title'    => __( 'Services list style title limit', 'exertio_theme' ),
								'desc'     => __( 'This will be applied on services search listings only', 'exertio_theme' ),
								'validate' => 'numeric',
							),
							array(
									'id'       => 'sevices_search_ad1',
									'type'     => 'textarea',
									'title'    => __( 'Search advertisement on top ', 'exertio_theme' ),
									'desc'     => __( 'Advertisement that will be shown over the search top.', 'exertio_theme' ),
								),
							array(
								'id'       => 'sevices_search_ad2',
								'type'     => 'textarea',
								'title'    => __( 'Search advertisement on Bottom ', 'exertio_theme' ),
								'desc'     => __( 'Advertisement that will be shown over the search bottom after the jobs.', 'exertio_theme' ),
							),
								
							
								
											
        ),
    ) );
    // -> START Typography
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Typography', 'exertio_theme' ),
        'id'     => 'typography',
        'icon'   => 'el el-font',
        'fields' => array(
			array(
                'id'       => 'opt-theme-btn-color',
                'type'     => 'link_color',
                'title'    => __( 'Theme Button Color', 'exertio_theme' ),
                'desc'     => __( 'Please provide main theme button color', 'exertio_theme' ),
				'active'  => false,
                'default'  => array(
                    'regular' => '#aaa',
                    'hover'   => '#bbb',
                    'active'  => '#ccc',
                )
            ),
            array(
                'id'       => 'opt-theme-btn-shadow-color',
                'type'     => 'color_rgba',
                'title'    => __( 'Theme button shadow color', 'exertio_theme' ),
                'subtitle' => __( 'Pick a show color for the theme buttons', 'exertio_theme' ),
                'mode'     => 'background',
				'default'  => array(
                    'color' => '#7e33dd',
                    'alpha' => '.8',
					'rgba' => 'rgba(0,0,0,0.5)'
                ),
            ),
			
			
			array(
                'id'       => 'opt-theme-btn-text-color',
                'type'     => 'link_color',
                'title'    => __( 'Theme button Text color', 'exertio_theme' ),
                'subtitle' => __( 'Pick a show color for the theme buttons', 'exertio_theme' ),
                'active'  => false,
                'default'  => array(
                    'regular' => '#FFF',
                    'hover'   => '#FFF',
                    'active'  => '#ccc',
                )
            ),
			array(
                'id'       => 'second-opt-theme-btn-color',
                'type'     => 'link_color',
                'title'    => __( 'Secondary Theme Button Color', 'exertio_theme' ),
                'desc'     => __( 'Please provide secondary theme button color', 'exertio_theme' ),
				'active'  => false,
                'default'  => array(
                    'regular' => '#aaa',
                    'hover'   => '#bbb',
                    'active'  => '#ccc',
                )
            ),
            array(
                'id'       => 'second-opt-theme-btn-shadow-color',
                'type'     => 'color_rgba',
                'title'    => __( 'Theme button shadow color', 'exertio_theme' ),
                'subtitle' => __( 'Pick a show color for the theme buttons', 'exertio_theme' ),
                'default'  => array(
                    'color' => '#7e33dd',
                    'alpha' => '.8',
					'rgba' => 'rgba(0,0,0,0.5)'
                ),
                'mode'     => 'background',
            ),
			array(
                'id'       => 'second-opt-theme-btn-text-color',
                'type'     => 'link_color',
                'title'    => __( 'Secondary button Text color', 'exertio_theme' ),
                'subtitle' => __( 'Pick a show color for the secondary theme buttons', 'exertio_theme' ),
                'active'  => false,
                'default'  => array(
                    'regular' => '#FFF',
                    'hover'   => '#FFF',
                    'active'  => '#ccc',
                )
            ),
            array(
                'id'       => 'opt-typography-body',
                'type'     => 'typography',
                'title'    => __( 'Body Font and details', 'exertio_theme' ),
                'subtitle' => __( 'Specify the body font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('body'),
                'default'  => array(
                    'color'       => '#242424',
                    'font-size'   => '16px',
                    'font-family' => 'Poppins',
                    'font-weight' => 'Normal',
                ),
            ),
			array(
                'id'       => 'opt-typography-h1',
                'type'     => 'typography',
                'title'    => __( 'H1 Font and Settings', 'exertio_theme' ),
                'subtitle' => __( 'Specify the body font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('h1'),
                'default'  => array(
                    'color'       => '#000000',
                    'font-size'   => '34px',
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                ),
            ),
			array(
                'id'       => 'opt-typography-h2',
                'type'     => 'typography',
                'title'    => __( 'H2 Tag Settings', 'exertio_theme' ),
                'subtitle' => __( 'Specify the H2 font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('h2'),
                'default'  => array(
                    'color'       => '#000000',
                    'font-size'   => '30px',
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                ),
            ),
			array(
                'id'       => 'opt-typography-h3',
                'type'     => 'typography',
                'title'    => __( 'H3 Tag Settings', 'exertio_theme' ),
                'subtitle' => __( 'Specify the H3 font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('h3'),
                'default'  => array(
                    'color'       => '#000000',
                    'font-size'   => '26px',
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                ),
            ),
			array(
                'id'       => 'opt-typography-h4',
                'type'     => 'typography',
                'title'    => __( 'H4 Tag Settings', 'exertio_theme' ),
                'subtitle' => __( 'Specify the H4 font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('h4'),
                'default'  => array(
                    'color'       => '#000000',
                    'font-size'   => '20px',
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                ),
            ),
			array(
                'id'       => 'opt-typography-h5',
                'type'     => 'typography',
                'title'    => __( 'H5 Tag Settings', 'exertio_theme' ),
                'subtitle' => __( 'Specify the H5 font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('h5'),
                'default'  => array(
                    'color'       => '#000000',
                    'font-size'   => '18px',
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                ),
            ),
			array(
                'id'       => 'opt-typography-h6',
                'type'     => 'typography',
                'title'    => __( 'H6 Tag Settings', 'exertio_theme' ),
                'subtitle' => __( 'Specify the H6 font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('h6'),
                'default'  => array(
                    'color'       => '#000000',
                    'font-size'   => '14px',
                    'font-family' => 'Poppins',
                    'font-weight' => '500',
                ),
            ),
			
			array(
                'id'       => 'opt-typography-p',
                'type'     => 'typography',
                'title'    => __( 'p Tag Settings', 'exertio_theme' ),
                'subtitle' => __( 'Specify the p font properties.', 'exertio_theme' ),
                'google'   => true,
                'output' => array('p'),
                'default'  => array(
                    'color'       => '#777777',
                    'font-size'   => '16px',
                    'font-family' => 'Poppins',
                    'font-weight' => 'Normal',
                ),
            ),
			
        )
    ) );
    // -> START PAGES LINKS
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Page Links', 'exertio_theme' ),
        'id'     => 'page_links',
        'icon'   => 'el el-link',
        'fields' => array(
						
            			array(
							'id' => 'login_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Login Page', 'exertio_theme'),
						),
						array(
							'id' => 'register_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Register Page', 'exertio_theme'),
						),
						array(
							'id' => 'terms_condition_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Terms and Condition page', 'exertio_theme'),
						),
						array(
							'id' => 'emp_package_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Employer Package Page', 'exertio_theme'),
						),
						array(
							'id' => 'freelancer_package_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Freelancer Package Page', 'exertio_theme'),
						),
						array(
							'id' => 'services_search_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Services Search Page', 'exertio_theme'),
						),
						array(
							'id' => 'project_search_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Project Search Page', 'exertio_theme'),
						),
						array(
							'id' => 'employer_search_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Employer Search Page', 'exertio_theme'),
						),
						array(
							'id' => 'freelancer_search_page',
							'type' => 'select',
							'data' => 'pages',
							'multi' => false,
							'title' => esc_html__('Freelancer Search Page', 'exertio_theme'),
						),
                        array(
                            'id' => 'product_search_page',
                            'type' => 'select',
                            'data' => 'pages',
                            'multi' => false,
                            'title' => esc_html__('Shop Search Page', 'exertio_theme'),
                        ),
			
        )
    ) );
	// -> START PAGES LINKS
    Redux::setSection( $opt_name, array(
        'title'  => __( 'Crons', 'exertio_theme' ),
        'id'     => 'exertio_cron_jobs',
        'icon'   => 'el el-refresh',
        'fields' => array(
						array(
								'id'       => 'fl_cron_toggle',
								'type'     => 'switch',
								'title'    => esc_html__( 'Crone Switch', 'exertio_theme' ),
								'default'  => false,
								'desc'     => esc_html__( 'Switch on cron options', 'exertio_theme' ),
							),
            			array(
							'id'       => 'exertio_project_cron_select',
							'type'     => 'select',
							'title'    => __('Select Project expiration cron', 'exertio_theme'), 
							'desc'     => __('Select time to run cron job for the project and featured project expiration', 'exertio_theme'),
							'options'  => array(
								'hourly' => __('Hourly', 'exertio_theme'),
								'twice_a_day' => __('Twice a day', 'exertio_theme'),
								'once_a_day' => __('Once a day', 'exertio_theme')
							),
							'default'  => 'once_a_day',
							'required' => array(array('fl_cron_toggle','equals','1')),
						),	
						array(
							'id'       => 'exertio_services_cron_select',
							'type'     => 'select',
							'title'    => __('Select Services Expiry Cron', 'exertio_theme'), 
							'desc'     => __('Select time to run cron job for the services and featured services expiration', 'exertio_theme'),
							'options'  => array(
								'hourly' => __('Hourly', 'exertio_theme'),
								'twice_a_day' => __('Twice a day', 'exertio_theme'),
								'once_a_day' => __('Once a day', 'exertio_theme')
							),
							'default'  => 'once_a_day',
							'required' => array(array('fl_cron_toggle','equals','1')),
						),		
        )
    ) );
    // -> START Additional Types
    Redux::setSection( $opt_name, array(
        'title' => __( 'Users', 'exertio_theme' ),
        'id'    => 'users',
        'desc'  => __( 'Users details will be here', 'exertio_theme' ),
        'icon'  => 'el el-magic',
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'General', 'exertio_theme' ),
        'id'         => 'user-general',
        'subsection' => true,
        'fields'     => array(
			array(
				'id' => 'user_dashboard_page',
				'type' => 'select',
				'data' => 'pages',
				'multi' => false,
				'title' => esc_html__('Select User Dashboard Page', 'exertio_theme'),
			),
			array(
						'id'       => 'user_attachment_size',
						'type'     => 'text',
						'title'    => __( 'Profile image and cover image max size', 'exertio_theme' ),
						'subtitle' => __( 'This must be numeric.', 'exertio_theme' ),
						'desc'     => __( 'Attachment size should be in KB. 1Mb = 1000 Kb', 'exertio_theme' ),
						'validate' => 'numeric',
						'default'  => '500',
					),
			array(
                'id'       => 'del_account-section',
                'type'     => 'section',
                'title'    => __( 'Delete Account Option', 'exertio_theme' ),
                'indent'   => true,  
            ),
			array(
                'id'       => 'delete_account',
                'type'     => 'switch',
                'title'    => __( 'Delete account option to user', 'exertio_theme' ),
                'default'  => true,
                'on'       => __( 'ON', 'exertio_theme' ),
                'off'      => __( 'OFF', 'exertio_theme' ),
            ),
			array(
                'id'       => 'delete_mesg',
                'type'     => 'textarea',
                'title'    => __( 'Delete account text', 'exertio_theme' ),
                'subtitle' => __( 'It will be visible to customers on their profile delete account box.', 'exertio_theme' ),
				'required' => array( 'delete_account', '=', true )
            ),
        ),
    ) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'Payout Settings', 'exertio_theme' ),
        'id'    => 'payout_settings',
		'subsection' => true,
        'fields' => array(
						array(
								'id'       => 'payout_switch',
								'type'     => 'switch',
								'title'    => __( 'Turn On or off payouts', 'exertio_theme' ),
								'default'  => true,
								'on'       => 'ON',
								'off'      => 'OFF',
							),
						array(
								'id'       => 'manual_payout_switch',
								'type'     => 'switch',
								'title'    => __( 'Allow Manual payout', 'exertio_theme' ),
								'default'  => false,
								'on'       => 'ON',
								'off'      => 'OFF',
							),
						array(
								'id'       => 'payout_processing_fee',
								'type'     => 'text',
								'title'    => __( 'Processing Fee', 'exertio_theme' ),
								'desc' 		=> __( 'only numeric allowed without currency symbol and decimal', 'exertio_theme' ),
								'default'  => __( '0', 'exertio_theme' ),
								'validate' => 'numeric',
							),
						array(
								'id'       => 'payout_min_limit',
								'type'     => 'text',
								'title'    => __( 'Minimum payout limit', 'exertio_theme' ),
								'desc' 		=> __( 'only numeric allowed without currency symbol and decimal', 'exertio_theme' ),
								'default'  => __( '100', 'exertio_theme' ),
								'validate' => 'numeric',
							),
						array(
								'id'       => 'payout_days_after',
								'type'     => 'text',
								'title'    => __( 'Payout after how many days', 'exertio_theme' ),
								'desc' 		=> __( 'only numeric value is allowed in days like 30 for one month ', 'exertio_theme' ),
								'default'  => __( '30', 'exertio_theme' ),
								'validate' => 'numeric',
							),
						array(
								'id'       => 'payout_note',
								'type'     => 'textarea',
								'title'    => __( 'Payout Note to show over the payout page', 'exertio_theme' ),
								'subtitle' => __( 'It will be visible to freelancers on their profile payout section.', 'exertio_theme' ),
								'required' => array( 'payout_switch', '=', true )
							),
						array(
								'id'       => 'paypal_switch',
								'type'     => 'switch',
								'title'    => __( 'Allow paypal payouts', 'exertio_theme' ),
								'default'  => true,
								'on'       => 'ON',
								'off'      => 'OFF',
							),
						array(
								'id'       => 'bank_transfer_switch',
								'type'     => 'switch',
								'title'    => __( 'Allow bank transfer payouts', 'exertio_theme' ),
								'default'  => true,
								'on'       => 'ON',
								'off'      => 'OFF',
							),
						array(
								'id'       => 'payoneer_switch',
								'type'     => 'switch',
								'title'    => __( 'Allow payoneer payouts', 'exertio_theme' ),
								'default'  => true,
								'on'       => 'ON',
								'off'      => 'OFF',
							),
        )
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Employer', 'exertio_theme' ),
        'id'         => 'user-employer',
		'icon'  => 'el el-adjust',
        'fields'     => array(
            array(
                'id'       => 'employer_df_img',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Employer Default Picture', 'exertio_theme' ),
                'compiler' => 'true',
                'desc'     => __( 'If Employer does not provide image. This will be shown over his profile', 'exertio_theme' ),
                'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/emp_default.jpg' ),
            ),
			array(
                'id'       => 'employer_df_cover',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Employer Default Cover Image', 'exertio_theme' ),
                'compiler' => 'true',

                'desc'     => __( 'If Employer does not provide Cover image. This will be shown over his public profile', 'exertio_theme' ),
                'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/default_cover.jpg' ),
            ),
			array(
                'id'       => 'contact_detail_show',
                'type'     => 'button_set',
                'title'    => __( 'Want to show contact detail on employer detail page', 'exertio_theme' ),
                'desc'     => __( 'Choose one of these options.', 'exertio_theme' ),
                'options'  => array(
                    '1' => 'Show',
                    '2' => 'Hide',
                    '3' => 'Login to Show'
                ),
                'default'  => '2'
            ),
			array(
                'id'       => 'social_links_switch',
                'type'     => 'switch',
                'title'    => __( 'Social Links', 'exertio_theme' ),
                'default'  => true,
            ),
			array(
				'id'       => 'employer_default_package_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Assign Package on Registration', 'exertio_theme' ),
				'default'  => true,
			),

			array(
				'id' => 'employer_default_packages',
				'type' => 'select',
				'data' => 'callback',
				'title' => esc_html__('Select Package to assign', 'exertio_theme'),
				'args' => 'employer_packages_callback_function',
				'required' => array(array('employer_default_package_switch','equals','1')),
			),
			array(
				'id'       => 'employer_dashboard_sidebar_sortable',
				'type'     => 'sortable',
				'title'    => __('Employer Dashboard Sidebar Menu', 'exertio_theme'),
				'subtitle' => __('Drag drop to rearrange and change text. Remain Empty to disable', 'exertio_theme'),
				'mode'     => 'text',
				'label'     => true,
				'options' => array(
					 'Dashboard' => 'Dashboard',
					 'Profile' => 'Profile',
					 'Projects' => 'Projects',
					 'Services' => 'Services',
					 'ChatDashboard' => 'Chat Dashboard',
					 'SavedServices' => 'Saved Services',
					 'FollowedFreelancers' => 'Followed Freelancers',
					 'FundDepositInvoices' => 'Fund Deposit & Invoices',
					 'Disputes' => 'Disputes',
					 'VerifyIdentity' => 'Verify Identity',
					 'Statements' => 'Statements',
					 'MeetingSettings' => 'Meetings Settings',
					 'AllMeetings' => 'All Meetings',
					 'Logout' => 'Logout',
				),
			)
        ),
    ) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'Edit Profile', 'exertio_theme' ),
        'id'    => 'employer-edit-profile',
		'subsection' => true,
        'fields' => array(
						array(
							'id'       => 'edit_pro-section',
							'type'     => 'section',
							'title'    => __( 'Edit Profile', 'exertio_theme' ),
							'subtitle' => __( 'All the employer edit profile option will be here.', 'exertio_theme' ),
							'indent'   => true,
						),
						array(
							'id'       => 'edit_icon',
							'type'     => 'text',
							'title'    => __( 'Edit profile textarea icon', 'exertio_theme' ),
							'desc' => __( 'You can use use icon from <a href="https://fontawesome.com/icons?d=gallery" target="_blank">this list</a>', 'exertio_theme' ),
						),
						array(
							'id'       => 'edit_msg',
							'type'     => 'textarea',
							'title'    => __( 'Text to show on top of edit profile page. Leave it empty if you do not want to show any thing over there', 'exertio_theme' ),
							'desc' => __( 'It will be visible to customers on their profile delete account box.', 'exertio_theme' ),
						),
						array(
								'id'     => 'edit_pro-section-end',
								'type'   => 'section',
								'indent' => false,
							),
						array(
							'id'       => 'employer-show-hide-fields',
							'type'     => 'section',
							'title'    => __( 'Required/Show/Hide Fields', 'exertio_theme' ),
							'subtitle' => __( 'All options to show hide or required fields fields', 'exertio_theme' ),
							'indent'   => true,
						),
						array(
							'id'       => 'employer_dispaly_name',
							'type'     => 'button_set',
							'title'    => __( 'Display Name', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'employer_tagline',
							'type'     => 'button_set',
							'title'    => __( 'Tagline', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'employer_contact_no',
							'type'     => 'button_set',
							'title'    => __( 'Contact Number', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'employer_department',
							'type'     => 'button_set',
							'title'    => __( 'Department', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'employer_employee_count',
							'type'     => 'button_set',
							'title'    => __( 'Number of Employees', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'employer_custom_locationt',
							'type'     => 'button_set',
							'title'    => __( 'Custom Location', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'employer_map',
							'type'     => 'button_set',
							'title'    => __( 'Map Address', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
								'id'     => 'employer-show-hide-fields-end',
								'type'   => 'section',
								'indent' => false,
							),
        )
    ) );
	Redux::setSection( $opt_name, array(
        'title' => __( 'Detail page', 'exertio_theme' ),
        'id'    => 'employer-detail Page',
		'subsection' => true,
        'fields' => array(
						array(
							'id'       => 'detail-page-section',
							'type'     => 'section',
							'title'    => __( 'Employer detail page', 'exertio_theme' ),
							'subtitle' => __( 'All the employer detail page options will be here.', 'exertio_theme' ),
							'indent'   => true,
						),
						array(
							'id'       => 'contact_detail_show',
							'type'     => 'button_set',
							'title'    => __( 'Want to show contact detail on employer detail page?', 'exertio_theme' ),
							'desc'     => __( 'Choose one of these options.', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Show',
								'2' => 'Hide',
								'3' => 'Login to Show'
							),
							'default'  => '2'
						),
						array(
							'id'       => 'employer_ad_1',
							'type'     => 'textarea',
							'title'    => __( 'Advertisement in sidebar', 'exertio_theme' ),
							'desc' => __( 'Advertisement that will be shown on sidebar of the Employer detail page.', 'exertio_theme' ),
						),
						array(
								'id'     => 'detail-page-end',
								'type'   => 'section',
								'indent' => false,
							),
						 array(
								'id'            => 'employers_posted_project_limit',
								'type'          => 'slider',
								'title'         => __( 'Number of post to show', 'exertio_theme' ),
								'subtitle'      => __( 'This slider displays the value as a label.', 'exertio_theme' ),
								'desc'          => __( 'Number of post to show Employer detail page', 'exertio_theme' ),
								'min'           => 1,
								'step'          => 1,
								'max'           => 50,
								'display_value' => 'label'
							),
						array(
								'id'       => 'employer_cf_title',
								'type'     => 'text',
								'title'    => __( 'Employer Custom Fields Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
					)
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Employer Search', 'exertio_theme' ),
        'id'         => 'employer-search',
        'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'employer_show_non_verified',
								'type'     => 'switch',
								'title'    => esc_html__( 'Want to show only email verified employers?', 'exertio_theme' ),
								'desc'     => __( 'If you want to show all employers whos email is verified or not.', 'exertio_theme' ),
								'default'  => false,
								'on'       => __( 'Yes', 'exertio_theme' ),
								'off'      => __( 'No', 'exertio_theme' ),
							),
							array(
								'id'       => 'employer_sidebar',
								'type'     => 'button_set',
								'title'    => __( 'Employer Sidebar Position', 'exertio_theme' ),
								'desc'     => __( 'Select the Employer search page side bar postion.', 'exertio_theme' ),
								'options'  => array(
									'left' => 'Left',
									'right' => 'Right',
								),
								'default'  => 'left',
							),
							array(
								'id'       => 'employer_sidebar_count',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Filters Count', 'exertio_theme' ),
								'desc'     => __( 'Select count for the terms should visible or hidden. ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
								'id'       => 'employer_sidebar_show_all_terms',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Show terms', 'exertio_theme' ),
								'desc'     => __( 'Show only terms which has posts in it ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
									'id'       => 'employer_search_sidebar_text',
									'type'     => 'textarea',
									'title'    => __( 'Sidebar Filter Text', 'exertio_theme' ),
									'desc'     => __( 'Text to show over the employer sidebar above the filter button.', 'exertio_theme' ),
								),
							array(
								'id'       => 'employer_grid_style',
								'type'     => 'button_set',
								'title'    => __( 'Employer Grid style', 'exertio_theme' ),
								'desc'     => __( 'Only one can be selected at a time.', 'exertio_theme' ),
								'options'  => array(
									'grid_1' => 'Grid 1',
									'grid_2' => 'Grid 2',
								),
								'default'  => array( 'grid_1' )
							),
							array(
									'id'       => 'employer_search_ad1',
									'type'     => 'textarea',
									'title'    => __( 'Search advertisement on top ', 'exertio_theme' ),
									'desc'     => __( 'Advertisement that will be shown over the search top.', 'exertio_theme' ),
								),
							array(
								'id'       => 'employer_search_ad2',
								'type'     => 'textarea',
								'title'    => __( 'Search advertisement on Bottom ', 'exertio_theme' ),
								'desc'     => __( 'Advertisement that will be shown over the search bottom after the employers.', 'exertio_theme' ),
							),
        ),
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Freelancer', 'exertio_theme' ),
        'id'         => 'user-freelancer',
		'icon'  => 'el el-user',
        'fields'     => array(
            array(
                'id'       => 'freelancer_df_img',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Freelancer Default Picture', 'exertio_theme' ),
                'compiler' => 'true',
                'desc'     => __( 'If Freelancer does not provide image. this will be shown over his profile.', 'exertio_theme' ),
                'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/emp_default.jpg' ),
            ),
			array(
                'id'       => 'freelancer_df_cover',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Freelancer Default cover', 'exertio_theme' ),
                'compiler' => 'true',
                'desc'     => __( 'If Freelancer does not provide image. This will be shown over his profile.', 'exertio_theme' ),
                'default'  => array( 'url' => trailingslashit(get_template_directory_uri()) . 'images/default_cover.jpg' ),
            ),
			array(
				'id'       => 'freelancer_default_package_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Assign Package on Registration', 'exertio_theme' ),
				'default'  => true,
			),

			array(
				'id' => 'freelancer_default_packages',
				'type' => 'select',
				'data' => 'callback',
				'title' => esc_html__('Select Package to assign', 'exertio_theme'),
				'args' => 'freelancer_packages_callback_function',
				'required' => array(array('freelancer_default_package_switch','equals','1')),
			),
			array(
				'id'       => 'freelancer_dashboard_sidebar_sortable',
				'type'     => 'sortable',
				'title'    => __('Freelancer Dashboard Sidebar Menu', 'exertio_theme'),
				'subtitle' => __('Drag drop to rearrange and change text. Remain Empty to disable', 'exertio_theme'),
				'mode'     => 'text',
				'label'     => true,
				'options' => array(
					 'Dashboard' => 'Dashboard',
					 'Profile' => 'Profile',
					 'ManageAddons' => 'Manage Addons',
					 'Services' => 'Manage Services',
					 'Projects' => 'Manage Projects',					 
					 'ChatDashboard' => 'Chat Dashboard',
					 'MyProposals' => 'My Proposals',
					 'SavedProjects' => 'Saved Projects',
					 'FollowedEmployers' => 'Followed Employers',
					 'Payouts' => 'Payouts',
					 'FundDepositInvoices' => 'Fund Deposit & Invoices',
					 'Disputes' => 'Disputes',
					 'VerifyIdentity' => 'Verify Identity',
					 'AllMeetings' => 'All Meetings',
					 'Settings' => 'Settings',
					 'Statements' => 'Statements',
					 'Logout' => 'Logout',
				),
			)
			
			
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'Edit Profile', 'exertio_theme' ),
        'id'    => 'freelancer-edit-profile',
		'subsection' => true,
        'fields' => array(
						array(
							'id'       => 'edit_fl_section',
							'type'     => 'section',
							'title'    => __( 'Edit Profile', 'exertio_theme' ),
							'subtitle' => __( 'Freelancer edit profile option will be here.', 'exertio_theme' ),
							'indent'   => true,  
						),
						array(
							'id'       => 'edit_fl_icon',
							'type'     => 'text',
							'title'    => __( 'Edit profile textarea icon', 'exertio_theme' ),
							'desc' => __( 'You can use use icon from <a href="https://fontawesome.com/icons?d=gallery" target="_blank">this list</a>', 'exertio_theme' ),
						),
						array(
							'id'       => 'edit_fl_msg',
							'type'     => 'textarea',
							'title'    => __( 'Text to show on top of edit profile page of freelancer. Leave it empty if you do not want to show any thing over there', 'exertio_theme' ),
						),
						array(
							'id'       => 'fl-show-hide-fields',
							'type'     => 'section',
							'title'    => __( 'Required/Show/Hide Fields for freelancer', 'exertio_theme' ),
							'subtitle' => __( 'All options to show hide or required fields fields', 'exertio_theme' ),
							'indent'   => true,  
						),
						array(
							'id'       => 'fl_dispaly_name',
							'type'     => 'button_set',
							'title'    => __( 'Display Name', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_tagline',
							'type'     => 'button_set',
							'title'    => __( 'Tagline', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_hourly_rate',
							'type'     => 'button_set',
							'title'    => __( 'Hourly rate', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_contact_number',
							'type'     => 'button_set',
							'title'    => __( 'Contact Number', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_gender',
							'type'     => 'button_set',
							'title'    => __( 'Freelancer gender', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_specialization',
							'type'     => 'button_set',
							'title'    => __( 'Freelancer Specialization', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_type',
							'type'     => 'button_set',
							'title'    => __( 'Freelancer Type', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_english_level',
							'type'     => 'button_set',
							'title'    => __( 'English level', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_language',
							'type'     => 'button_set',
							'title'    => __( 'English level', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_location',
							'type'     => 'button_set',
							'title'    => __( 'Location', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_address',
							'type'     => 'button_set',
							'title'    => __( 'Freelancer Address', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_skills',
							'type'     => 'button_set',
							'title'    => __( 'Freelancer skills', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Required',
								'2' => 'Not Required',
								'3' => 'Hide',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_skills',
							'type'     => 'button_set',
							'title'    => __( 'Freelancers Skills', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Hide',
								'2' => 'Show',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_awards',
							'type'     => 'button_set',
							'title'    => __( 'Awards', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Hide',
								'2' => 'Show',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_projects',
							'type'     => 'button_set',
							'title'    => __( 'Projects', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Hide',
								'2' => 'Show',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_experience',
							'type'     => 'button_set',
							'title'    => __( 'Experience', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Hide',
								'2' => 'Show',
							),
							'default'  => '2'
						),
						array(
							'id'       => 'fl_education',
							'type'     => 'button_set',
							'title'    => __( 'Education', 'exertio_theme' ),
							'subtitle' => __( 'Select option to show hide or required', 'exertio_theme' ),
							'options'  => array(
								'1' => 'Hide',
								'2' => 'Show',
							),
							'default'  => '2'
						),

						array(
								'id'     => 'fl-show-hide-fields-end',
								'type'   => 'section',
								'indent' => false, 
							),
        )
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Detail page', 'exertio_theme' ),
        'id'         => 'freelancer-details',
		'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'freelancer_details_page_layout',
								'type'     => 'image_select',
								'title'    => __( 'Detail page layout', 'exertio_theme' ),
								'options'  => array(
									'1' => array(
										'alt' => __( 'Style 1', 'exertio_theme' ),
										'img' => trailingslashit(get_template_directory_uri()) . 'images/services_detail_1.png',
									),
									'2' => array(
										'alt' => __( 'Style 2', 'exertio_theme' ),
										'img' => trailingslashit(get_template_directory_uri()) . 'images/services_detail_2.png',
									),
								),
								'default'  => '2'
							),
							array(
								'id'       => 'freelancer_states',
								'type'     => 'button_set',
								'title'    => __( 'Freelancer counters', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Hide',
									'2' => 'Show',
								),
								'default'  => '2'
							),
							array(
								'id'       => 'freelancer_phone_number',
								'type'     => 'button_set',
								'title'    => __( 'Show contact number', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Hide',
									'2' => 'Show',
									'3' => 'Login to show',
								),
								'default'  => '1'
							),
							array(
								'id'       => 'freelancer_email',
								'type'     => 'button_set',
								'title'    => __( 'Show email', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Hide',
									'2' => 'Show',
									'3' => 'Login to show',
								),
								'default'  => '1'
							),
							array(
								'id'       => 'detail_page_gender',
								'type'     => 'button_set',
								'title'    => __( 'Show Gender', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Hide',
									'2' => 'Show',
								),
								'default'  => '2'
							),
							array(
								'id'       => 'detail_page_type',
								'type'     => 'button_set',
								'title'    => __( 'Show Freelancer Type', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Hide',
									'2' => 'Show',
								),
								'default'  => '2'
							),
							array(
								'id'       => 'detail_page_eglish_level',
								'type'     => 'button_set',
								'title'    => __( 'Show English Level', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Hide',
									'2' => 'Show',
								),
								'default'  => '2'
							),
							array(
								'id'       => 'detail_page_language',
								'type'     => 'button_set',
								'title'    => __( 'Show Language', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Hide',
									'2' => 'Show',
								),
								'default'  => '2'
							),
                            array(
                                'id'       => 'detail_page_specialization',
                                'type'     => 'button_set',
                                'title'    => __( 'Show Specialization', 'exertio_theme' ),
                                'subtitle' => __( 'Select option to show or hide', 'exertio_theme' ),
                                'options'  => array(
                                    '1' => 'Hide',
                                    '2' => 'Show',
                                ),
                                'default'  => '2'
                            ),
							array(
								'id'       => 'freelancer_services',
								'type'     => 'button_set',
								'title'    => __( 'Freelancer Services', 'exertio_theme' ),
								'subtitle' => __( 'Select option to show at to or bottom', 'exertio_theme' ),
								'desc' => __( 'On freelacner detail page services should show right after the user detail or at the bottom of the page.', 'exertio_theme' ),
								'options'  => array(
									'1' => 'Top',
									'2' => 'Bottom',
								),
								'default'  => '1'
							),
                            array(
                                'id'       => 'freelancer_skills_percentage',
                                'type'     => 'button_set',
                                'title'    => __( 'Freelancer Skills Percentage', 'exertio_theme' ),
                                'subtitle' => __( 'Turn On to show percentage of Freelancer skills', 'exertio_theme' ),
                                'desc' => __( 'On freelancer detail page show skills with percentage', 'exertio_theme' ),
                                'options'  => array(
                                    '1' => 'Show',
                                    '2' => 'Hide',
                                ),
                                'default'  => '1'
                            ),
							array(
								'id'       => 'freelancer_services_title',
								'type'     => 'text',
								'title'    => __( 'Services title', 'exertio_theme' ),
								'desc' => __( 'provide service title', 'exertio_theme' ),
							),
							array(
								'id'       => 'freelancer_services_limit',
								'type'     => 'text',
								'title'    => __( 'Limit number of services', 'exertio_theme' ),
								'desc' => __( 'only numeric allowed', 'exertio_theme' ),
								'validate' => 'numeric',
							),
							array(
								'id'       => 'detail_page_lower_layout',
								'type'     => 'sorter',
								'title'    => __( 'Detail page Lower part sorting', 'exertio_theme' ),
								'desc'     => __( 'Organize how you want the layout to appear on detail page', 'exertio_theme' ),
								'required' => array( 'freelancer_details_page_layout', '=', 1, 'freelancer_details_page_layout', '=', 2),
								'compiler' => 'true',
								'options'  => array(
									'disabled' => array(
									),
									'enabled'  => array(
										'description' => __( 'Description', 'exertio_theme' ),
										'reviews_seller'     => __( 'Seller Reviews', 'exertio_theme' ),
										'reviews_freelancer'     => __( 'Freelancer Reviews', 'exertio_theme' ),
										'projects'     => __( 'Projects', 'exertio_theme' ),
										'experience'     => __( 'Experience', 'exertio_theme' ),
										'education'     => __( 'Education', 'exertio_theme' ),
										'ads_1'     => __( 'Advertisement 1', 'exertio_theme' ),
										'ads_2'     => __( 'Advertisement 2', 'exertio_theme' ),
										'freelancer_custom_fields'     => __( 'Custom Fields', 'exertio_theme' ),
									),
								),
							),
							array(
								'id'       => 'detail_page_sidebar',
								'type'     => 'sorter',
								'title'    => __( 'Detail page Sidebar sorting', 'exertio_theme' ),
								'desc'     => __( 'Organize how you want the layout to appear on detail page', 'exertio_theme' ),
								'required' => array( 'freelancer_details_page_layout', '=', 1, 'freelancer_details_page_layout', '=', 2),
								'compiler' => 'true',
								'options'  => array(
									'disabled' => array(
									),
									'enabled'  => array(
										'certifications' => __( 'Certifications', 'exertio_theme' ),
										'skills'     => __( 'Skills', 'exertio_theme' ),
										'freelancer_detail'     => __( 'Freelancer detail', 'exertio_theme' ),
										'sidebar_ads_1'     => __( 'Advertisement 1', 'exertio_theme' ),
										'sidebar_ads_2'     => __( 'Advertisement 2', 'exertio_theme' ),
									),
								),
							),
							array(
							'id'       => 'detail_page_title_section',
							'type'     => 'section',
							'title'    => __( 'Detail page titles', 'exertio_theme' ),
							'subtitle' => __( 'Detail page main area titles.', 'exertio_theme' ),
							'indent'   => true, 
							),
							array(
								'id'       => 'detail_desc_title',
								'type'     => 'text',
								'title'    => __( 'Description Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_seller_reviews_title',
								'type'     => 'text',
								'title'    => __( 'Seller Reviews Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_freelancer_reviews_title',
								'type'     => 'text',
								'title'    => __( 'Freelancer Reviews Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_projects_title',
								'type'     => 'text',
								'title'    => __( 'Projects Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_exp_title',
								'type'     => 'text',
								'title'    => __( 'Experience Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_edu_title',
								'type'     => 'text',
								'title'    => __( 'Education Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'freelancer_cf_title',
								'type'     => 'text',
								'title'    => __( 'Freelancer Custom Fields Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'     => 'detail_page_title_section-end',
								'type'   => 'section',
								'indent' => false, 
							),
							array(
							'id'       => 'detail_sidebar_title_section',
							'type'     => 'section',
							'title'    => __( 'Detail page sidebar titles', 'exertio_theme' ),
							'subtitle' => __( 'Detail page sidebar titles will be here.', 'exertio_theme' ),
							'indent'   => true,
							),
							array(
								'id'       => 'detail_sidebar_about',
								'type'     => 'text',
								'title'    => __( 'About Freelancer Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_sidebar_skills',
								'type'     => 'text',
								'title'    => __( 'Skills Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_sidebar_certificates',
								'type'     => 'text',
								'title'    => __( 'Certificate Title', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want title', 'exertio_theme' ),
							),
							array(
								'id'     => 'detail_sidebar_title_section-end',
								'type'   => 'section',
								'indent' => false,  
							),
							array(
							'id'       => 'detail_main_ads_section',
							'type'     => 'section',
							'title'    => __( 'Detail page main area ads', 'exertio_theme' ),
							'subtitle' => __( 'Place your advertisement scripts in below boxes.', 'exertio_theme' ),
							'indent'   => true,  
							),
							array(
								'id'       => 'detail_page_ad_1',
								'type'     => 'textarea',
								'title'    => __( 'Advertisment no 1', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want ads.', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_page_ad_2',
								'type'     => 'textarea',
								'title'    => __( 'Advertisment no 2', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want ads.', 'exertio_theme' ),
							),
							array(
								'id'     => 'detail_main_ads_section_end',
								'type'   => 'section',
								'indent' => false,  
							),
							array(
							'id'       => 'detail_sidebar_ads_section',
							'type'     => 'section',
							'title'    => __( 'Detail page sidebar ads', 'exertio_theme' ),
							'subtitle' => __( 'Place your advertisement scripts in below boxes.', 'exertio_theme' ),
							'indent'   => true,  
							),
							array(
								'id'       => 'detail_page_sidebar_ad_1',
								'type'     => 'textarea',
								'title'    => __( 'Advertisment Sidebar 1', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want ads.', 'exertio_theme' ),
							),
							array(
								'id'       => 'detail_page_sidebar_ad_2',
								'type'     => 'textarea',
								'title'    => __( 'Advertisment sidebar 2', 'exertio_theme' ),
								'desc' => __( 'Leave it empty if you do not want ads.', 'exertio_theme' ),
							),
							array(
								'id'     => 'detail_sidebar_ads_section_end',
								'type'   => 'section',
								'indent' => false,  
							),

        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'Rating', 'exertio_theme' ),
        'id'    => 'freelancer-rating',
		'subsection' => true,
        'icon'  => 'el el-magic',
        'fields' => array(
						array(
							'id'       => 'rating_section',
							'type'     => 'section',
							'title'    => __( 'Freelancer Rating For Project', 'exertio_theme' ),
							'subtitle' => __( 'after Project Completion', 'exertio_theme' ),
							'indent'   => true,  
						),
						array(
							'id'       => 'first_title',
							'type'     => 'text',
							'title'    => __( 'First rating stars title', 'exertio_theme' ),
							'default'  => __( 'Proffesional Behaviour', 'exertio_theme' ),
						),
						array(
							'id'       => 'second_title',
							'type'     => 'text',
							'title'    => __( 'Second rating stars title', 'exertio_theme' ),
							'default'  => __( 'Service as Describe', 'exertio_theme' ),
						),
						array(
							'id'       => 'third_title',
							'type'     => 'text',
							'title'    => __( 'Third rating stars title', 'exertio_theme' ),
							'default'  => __( 'Communicnation level', 'exertio_theme' ),
						),
						array(
							'id'       => 'service_rating_section',
							'type'     => 'section',
							'title'    => __( 'Freelancer Rating For Service', 'exertio_theme' ),
							'subtitle' => __( 'after Service Completion', 'exertio_theme' ),
							'indent'   => true,  
						),
						array(
							'id'       => 'service_first_title',
							'type'     => 'text',
							'title'    => __( 'First service rating stars title', 'exertio_theme' ),
							'default'  => __( 'Proffesional Behaviour', 'exertio_theme' ),
						),
						array(
							'id'       => 'service_second_title',
							'type'     => 'text',
							'title'    => __( 'Second service rating stars title', 'exertio_theme' ),
							'default'  => __( 'Service as Describe', 'exertio_theme' ),
						),
						array(
							'id'       => 'service_third_title',
							'type'     => 'text',
							'title'    => __( 'Third service rating stars title', 'exertio_theme' ),
							'default'  => __( 'Communicnation level', 'exertio_theme' ),
						),
        )
    ) );
	Redux::setSection( $opt_name, array(
        'title'      => __( 'Freelancer Search', 'exertio_theme' ),
        'id'         => 'freelancer-search',
        'subsection' => true,
        'fields'     => array(
							array(
								'id'       => 'freelancer_show_non_verified',
								'type'     => 'switch',
								'title'    => esc_html__( 'Want to show only email verified freelancers?', 'exertio_theme' ),
								'desc'     => __( 'If you want to show all freelancers whos email is verified or not.', 'exertio_theme' ),
								'default'  => false,
								'on'       => __( 'Yes', 'exertio_theme' ),
								'off'      => __( 'No', 'exertio_theme' ),
							),
							array(
								'id'       => 'freelancer_sidebar',
								'type'     => 'button_set',
								'title'    => __( 'Freelancer Search Sidebar Position', 'exertio_theme' ),
								'desc'     => __( 'Select the Freelancer search page side bar postion.', 'exertio_theme' ),
								'options'  => array(
									'left' => 'Left',
									'right' => 'Right',
								),
								'default'  => 'left',
							),
							array(
								'id'       => 'freelancer_sidebar_count',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Filters Count', 'exertio_theme' ),
								'desc'     => __( 'Select count for the terms should visible or hidden. ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
								'id'       => 'freelancer_sidebar_show_all_terms',
								'type'     => 'switch',
								'title'    => esc_html__( 'Sidebar Show terms', 'exertio_theme' ),
								'desc'     => __( 'Show only terms which has posts in it ', 'exertio_theme' ),
								'default'  => true,
							),
							array(
									'id'       => 'freelancer_search_sidebar_text',
									'type'     => 'textarea',
									'title'    => __( 'Sidebar Filter Text', 'exertio_theme' ),
									'desc'     => __( 'Text to show over the Frrelancer sidebar above the filter button.', 'exertio_theme' ),
								),
							array(
								'id'       => 'freelancer_grid_style',
								'type'     => 'button_set',
								'title'    => __( 'Freelancer Grid style', 'exertio_theme' ),
								'desc'     => __( 'Only one can be selected at a time.', 'exertio_theme' ),
								'options'  => array(
									'grid_1' => __( 'Grid 1', 'exertio_theme' ),
									'grid_2' => __( 'Grid 2', 'exertio_theme' ),
								),
								'default'  => 'grid_1',
							),
							array(
								'id'       => 'freelancer_listing_style',
								'type'     => 'button_set',
								'title'    => __( 'Freelancer Listing style', 'exertio_theme' ),
								'desc'     => __( 'Only one can be selected at a time.', 'exertio_theme' ),
								'options'  => array(
									'list_1' => __( 'List 1', 'exertio_theme' ),
									'list_2' => __( 'List 2', 'exertio_theme' ),
								),
								'default'  => 'list_1',
							),
							array(
									'id'       => 'freelancer_search_ad1',
									'type'     => 'textarea',
									'title'    => __( 'Search advertisement on top ', 'exertio_theme' ),
									'desc'     => __( 'Advertisement that will be shown over the search top.', 'exertio_theme' ),
								),
							array(
								'id'       => 'freelancer_search_ad2',
								'type'     => 'textarea',
								'title'    => __( 'Search advertisement on Bottom ', 'exertio_theme' ),
								'desc'     => __( 'Advertisement that will be shown over the search bottom after the employers.', 'exertio_theme' ),
							),
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'title' => __( 'API Keys', 'exertio_theme' ),
        'icon'  => 'el el-key',
    ) );
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Maps', 'exertio_theme' ),
        'id'         => 'google_map',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'map_selection',
                'type'     => 'button_set',
                'title'    => __( 'Select Map type', 'exertio_theme' ),
                'desc'     => __( 'Selected map will be displayed all over the webiste.', 'exertio_theme' ),
                
                'options'  => array(
                    '1' => __( 'Google Map', 'exertio_theme' ),
                    '3' => __( 'No Map', 'exertio_theme' )
                ),
                'default'  => '1'
            ),
			array(
                'id'       => 'google_map_key',
                'type'     => 'text',
                'title'    => __( 'Google API key', 'exertio_theme' ),
                'subtitle' => __( 'If empty, google map will not work', 'exertio_theme' ),
				'desc'     => __( 'Will only be required when you are using google map', 'exertio_theme' ),
            ),
			array(
                'id'       => 'default_lat',
                'type'     => 'text',
                'title'    => __( 'Default Latitude', 'exertio_theme' ),
                'default'  => __( '51.509865', 'exertio_theme'),
				'desc'     => __( 'Map will show this location be by default ', 'exertio_theme' ),
            ),
			array(
                'id'       => 'default_long',
                'type'     => 'text',
                'title'    => __( 'Default Longitude', 'exertio_theme' ),
                'default'  => __( '-0.118092', 'exertio_theme'),
				'desc'     => __( 'Map will show this location be by default ', 'exertio_theme' ),
            ),
        )
    ) );
	/* ------------------ Zoom API Settings ----------------------- */
	Redux::setSection($opt_name, array(
		'title' => esc_html__('Zoom API Setting', 'exertio_theme'),
		'id' => 'sb-zoom-settings',
		'desc' => '',
		'icon' => 'el el-cogs',
		'fields' => array(
			array(
				'id' => 'zoom_meeting_btn',
				'type' => 'switch',
				'title' => esc_html__('Zoom Meetings', 'exertio_theme'),
				'desc' => esc_html__('On/Off Zoom Meetings', 'exertio_theme'),
				'default' => false,
			),
			array(
            'id' => 'zoom_keys_link',
            'type' => 'text',
            'title' => esc_html__('Zoom Keys Link', 'exertio_theme'),
            'subtitle' => esc_html__('Zoom App Market Link', 'exertio_theme'),
            'desc' => esc_html__('Keys Creation Link', 'exertio_theme'),
            'default' => '#',
        ),

	)));
	Redux::setSection( $opt_name, array(
			'title'      => esc_html__( 'Statistics Graph', "exertio_theme" ),
			'id'         => 'exertio_statistics_pg',
			'icon'  => 'el el-graph',
			'desc'       => '',
			//'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'exertio_stats_days',
					'type'     => 'text',
					'title'    => esc_html__( 'Number Of Days', 'exertio_theme' ),
					'desc'	=> esc_html__( 'How many days will shown on the chart!: .', 'exertio_theme' ),
					'default'  =>  20,
				),
		array(
				'id'		=> 'exertio_chart_type',
				'type'		=> 'select',
				'title'		=> esc_html__( 'Chart Type', 'exertio_theme' ),
				'options'	=> array(
					'bar'	=> esc_html__( 'Bar Chart', 'exertio_theme' ),
					'line'			=> esc_html__( 'Line Chart', 'exertio_theme' )
				),
				'default'	=> 'bar',
			),
			
			 array(
					'id' => 'exertio_chart_bg',
					'type' => 'color_rgba',
					'title' => __('Background Color For Chart', 'exertio_theme'),
					'default' => array(
						'color' => '#00aeef',
						'alpha' => '0.2'
					),
					'validate' => 'colorrgba',
					'desc'	=> esc_html__( 'Defualt color: rgba(0, 174, 239, 0.2)', 'exertio_theme' ),
				),
				
				array(
					'id' => 'exertio_chart_border',
					'type' => 'color',
					'title' => esc_html__('Border Color', 'exertio_theme'),
					'subtitle' => esc_html__('Graph Border Color (default: #00aeef).', 'exertio_theme'),
					'transparent' => false,
					'default' => '#00aeef',
					'validate' => 'color',
      			  ),
			)
		));
    // -> START Editors
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Footer Options', 'exertio_theme' ),
        'id'               => 'footers',
        'customizer_width' => '500px',
        'icon'             => 'el el-edit',
		'fields'     => array(
							array(
								'id'       => 'footer_type',
								'type'     => 'button_set',
								'title'    => __( 'Select the footer type', 'exertio_theme' ),
								'options'  => array(
									'0' => 'Exertio Theme',
									'1' => 'Elementor',
								),
								'default'  => '0',
							),
							array(
								'id'       => 'foote_layout',
								'type'     => 'image_select',
								'title'    => esc_html__( 'Select Footer Type', 'exertio_theme' ),
								'subtitle' => esc_html__( 'Click on any footer and save to apply.', 'exertio_theme' ),
								'options'  => array(
									'1' => array(
										'alt' => esc_html__( 'Footer 1', 'exertio_theme' ),
										'img' => trailingslashit(get_template_directory_uri()) . 'images/header-1.png',
									),
								),
								'default'  => '1',
							),
							array(
								'id' => 'exertio_footer_logo',
								'type' => 'media',
								'url' => true,
								'title' => esc_html__('Footer Logo', 'exertio_theme'),
								'compiler' => 'true',
								'desc' => esc_html__('Upload footer logo of the website.', 'exertio_theme'),
								'default' =>array( 'url' => trailingslashit( get_template_directory_uri () ) . 'images/logo-dashboard.svg' ),
							),
							array(
								'id' => 'website_footer_content',
								'type' => 'textarea',
								'title' => esc_html__('Footer Description', 'exertio_theme'),
								'default' => '',
								),
							array(
								'id'       => 'action_bar',
								'type'     => 'button_set',
								'title'    => __( 'Swtich For Call to Action Bar on footer', 'exertio_theme' ),
								'options'  => array(
									'0' => 'OFF',
									'1' => 'ON',
								),
								'default'  => array( '0' )
							),
							array(
								'id' => 'action_heading_text',
								'type' => 'text',
								'title' => esc_html__('Call to Action Heading Text', 'exertio_theme'),
								'default' => '',
								'required' => array( 'action_bar', '=', '1' ),
								),
							array(
								'id' => 'action_content',
								'type' => 'textarea',
								'title' => esc_html__('Call to action Detail', 'exertio_theme'),
								'default' => '',
								'required' => array( 'action_bar', '=', '1' ),
								),
							array(
								'id' => 'action_btn_text',
								'type' => 'text',
								'title' => esc_html__('Call to Action Button Text', 'exertio_theme'),
								'default' => '',
								'required' => array( 'action_bar', '=', '1' ),
								),
							array(
								'id' => 'action_btn_link',
								'type' => 'select',
								'data' => 'pages',
								'title' => esc_html__('Call to Action Button Link', 'exertio_theme'),
								'default' => '',
								'required' => array( 'action_bar', '=', '1' ),
								),
								array(
									'id'       => 'footer-section',
									'type'     => 'section',
									'title'    => __( 'Footer Widgets', 'exertio_theme' ),
									'subtitle' => __( 'All options to show hide or required fields fields', 'exertio_theme' ),
									'indent'   => true,  
								),
							array(
								'id' => 'footer_project_locations_heading',
								'type' => 'text',
								'title' => esc_html__('Project Location Heading', 'exertio_theme'),
								'default' => '',
								),
							array(
								'id' => 'footer_project_locations',
								'type' => 'select',
								'title' => __('Select Project Locations', 'exertio_theme'),
								'multi' => true,
								'sortable' => true,
								'data' => 'terms',
								'ajax' => false,
								'args' => array( 'taxonomies' => array( 'locations' )),
								),

							array(
								'id' => 'footer_services_locations_heading',
								'type' => 'text',
								'title' => esc_html__('Services Location Heading', 'exertio_theme'),
								'default' => '',
								),
							array(
								'id' => 'footer_services_locations',
								'type' => 'select',
								'title' => __('Select Services Locations', 'exertio_theme'),
								'multi' => true,
								'sortable' => true,
								'data' => 'terms',
								'ajax' => false,
								'args' => array('taxonomy' => 'services-locations','hide_empty' => false,),
							),
							array(
								'id' => 'footer_links_heading',
								'type' => 'text',
								'title' => esc_html__('Links Heading', 'exertio_theme'),
								'default' => '',
								),
							array(
								'id' => 'footer_page_links',
								'type' => 'select',
								'title' => __('Select pages links', 'exertio_theme'),
								'multi' => true,
								'sortable' => true,
								'data' => 'pages',
							),
							array(
									'id'       => 'footer-section-end',
									'type'     => 'section',
									'indent'   => false,  
								),
							array(
									'id'       => 'footer-social-section',
									'type'     => 'section',
									'title'    => __( 'Footer Social Links', 'exertio_theme' ),
									'subtitle' => __( 'Give complete link for your social pages and leave empty to hide.', 'exertio_theme' ),
									'indent'   => true,  
								),
							array(
								'id' => 'footer_facebook_link',
								'type' => 'text',
								'title' => esc_html__('Facebook', 'exertio_theme'),
								'default' => '',
								),
							array(
								'id' => 'footer_twitter_link',
								'type' => 'text',
								'title' => esc_html__('Twitter', 'exertio_theme'),
								'default' => '',
								),
								array(
								'id' => 'footer_linkedin_link',
								'type' => 'text',
								'title' => esc_html__('LinkedIn', 'exertio_theme'),
								'default' => '',
								),
								array(
								'id' => 'footer_youtube_link',
								'type' => 'text',
								'title' => esc_html__('Youtube', 'exertio_theme'),
								'default' => '',
								),
								array(
								'id' => 'footer_instagram_link',
								'type' => 'text',
								'title' => esc_html__('Instagram', 'exertio_theme'),
								'default' => '',
								),
							array(
									'id'       => 'footer-social-section-end',
									'type'     => 'section',
									'indent'   => false,  
								),
							array(
								'id' => 'footer_copyright_text',
								'type' => 'editor',
								'title' => esc_html__('Footer Copyright Text', 'exertio_theme'),
								'default' => 'Copyright 2020 &copy; Theme Created By ScriptsBundle, All Rights Reserved.',
								'args' => array(
									'wpautop' => false,
									'media_buttons' => false,
									'textarea_rows' => 5,
									'teeny' => false,
									'quicktags' => false,
								)
							),								
        ),
    ) );
    Redux::setSection( $opt_name, array(
        'icon'            => 'el el-list-alt',
        'title'           => __( 'Customizer Only', 'exertio_theme' ),
        'desc'            => __( '<p class="description">This Section should be visible only in Customizer</p>', 'exertio_theme' ),
        'customizer_only' => true,
        'fields'          => array(
            array(
                'id'              => 'opt-customizer-only',
                'type'            => 'select',
                'title'           => __( 'Customizer Only Option', 'exertio_theme' ),
                'subtitle'        => __( 'The subtitle is NOT visible in customizer', 'exertio_theme' ),
                'desc'            => __( 'The field desc is NOT visible in customizer.', 'exertio_theme' ),
                'customizer_only' => true,
                'options'         => array(
                    '1' => 'Opt 1',
                    '2' => 'Opt 2',
                    '3' => 'Opt 3'
                ),
                'default'         => '2'
            ),
        )
    ) );
    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'exertio_theme' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', 
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values );
            echo "</pre>";

        }
    }
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            $sections[] = array(
                'title'  => __( 'Section via hook', 'exertio_theme' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'exertio_theme' ),
                'icon'   => 'el el-paper-clip',
                'fields' => array()
            );

            return $sections;
        }
    }
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {

            return $args;
        }
    }
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }