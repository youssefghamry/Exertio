<?php
/**
 * Plugin Name: Exertio Framework
 * Plugin URI: https://themeforest.net/user/scriptsbundle/
 * Description: Exertio framework is essential for the proper Exertio WordPress Theme funcationality.
 * Version: 1.1.3
 * Author: Scripts Bundle
 * Author URI: https://themeforest.net/user/scriptsbundle/
 * License: GPL2
 * Text Domain: exertio_framework
 */
$my_theme = wp_get_theme();
if ($my_theme->get('Name') != 'Exertio' && $my_theme->get('Name') != 'Exertio child')
{
   return;
}
else
{
	$base = dirname(__FILE__);
	define('FL_ROOT_PATH', dirname(__FILE__));
	define('FL_PLUGIN_FRAMEWORK_PATH', plugin_dir_path(__FILE__));
	define('FL_THEMEPATH', get_template_directory_uri());
	define('FL_PLUGIN_PATH', plugin_dir_path(__FILE__));
	define('FL_PLUGIN_URL', plugin_dir_url(__FILE__));
	define('FL_THEMEURL_PLUGIN', get_template_directory_uri() . '/');
	define('FL_IMAGES_PLUGIN', FL_THEMEURL_PLUGIN . 'images/');
	define('FL_CSS_PLUGIN', FL_THEMEURL_PLUGIN . 'css/');
	
	if ( class_exists( 'Redux' ) ) {
       //require FL_PLUGIN_PATH . 'redux-extensions/extensions-init.php';
    }
	
	add_action( 'plugins_loaded', 'exertio_framework_load_textdomain' );
	function exertio_framework_load_textdomain() {
	  load_plugin_textdomain( 'exertio_framework', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}
	/*TABLE NAME*/
	global $wpdb;
	define('EXERTIO_DISPUTE_MSG_TBL', $wpdb->prefix.'exertio_dispute_messages');
    define('EXERTIO_DISPUTE_MSG_SERVICE_TBL', $wpdb->prefix.'exertio_dispute_services_messages');
	define('EXERTIO_SERVICE_LOGS_TBL', $wpdb->prefix.'exertio_services_logs');
	define('EXERTIO_PROJECT_LOGS_TBL', $wpdb->prefix.'exertio_project_logs');
	define('EXERTIO_SERVICE_MSG_TBL', $wpdb->prefix.'exertio_service_msgs');
	define('EXERTIO_PURCHASED_SERVICES_TBL', $wpdb->prefix.'exertio_purchased_services');
	define('EXERTIO_REVIEWS_TBL', $wpdb->prefix.'exertio_reviews');
	define('EXERTIO_PROJECT_MSG_TBL', $wpdb->prefix.'exertio_project_msg_history');
	define('EXERTIO_PROJECT_BIDS_TBL', $wpdb->prefix.'exertio_project_bids');
	define('EXERTIO_NOTIFICATIONS_TBL', $wpdb->prefix.'exertio_notifications');
	define('EXERTIO_STATEMENTS_TBL', $wpdb->prefix.'exertio_statements');
	
	function custom_wp_admin_enqueue()
	{
		wp_enqueue_style( 'exertio_plugin', FL_PLUGIN_URL.'css/plugin.css' );

		wp_enqueue_style( 'jquery-datetimepicker', FL_PLUGIN_URL.'css/jquery.datetimepicker.min.css' );
		if(class_exists('ACF'))
		{
			$screen = get_current_screen();
			if ( $screen->parent_base == 'edit' || get_post_type() == 'projects' || get_post_type() == 'services' )
			{
				wp_enqueue_style('pretty-checkbox', trailingslashit(get_template_directory_uri()) . 'css/pretty-checkbox.min.css');
				wp_enqueue_style( 'ion-rangeslider', trailingslashit(get_template_directory_uri()).'css/ion-rangeslider.min.css' );
				wp_enqueue_script('ion-rangeslider', trailingslashit(get_template_directory_uri()) . 'js/ion.rangeslider.min.js', false, false, true);
			}
		}
		wp_enqueue_media();
	}
	add_action( 'admin_enqueue_scripts', 'custom_wp_admin_enqueue' );
	
	/*  INCLUDIND CPTs  */
	require FL_PLUGIN_PATH . 'plugin-files/cpt/project.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/services.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/company.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/freelancers.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/addons.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/disputes.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/payouts.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/verification.php';
	require FL_PLUGIN_PATH . 'plugin-files/cpt/report.php';
	if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
	{
		require FL_PLUGIN_PATH . 'plugin-files/exertio-widgets/exertio-widgets.php';
	}
	/*EXERTIO SEARCHBAR WIDGETS*/
	require FL_PLUGIN_PATH . 'plugin-files/widgets/index.php';
	
	/*ADMIN MENU PAGES*/
	require FL_PLUGIN_PATH . 'plugin-files/pages/queued_services.php';
	require FL_PLUGIN_PATH . 'plugin-files/pages/completed_services.php';
	require FL_PLUGIN_PATH . 'plugin-files/pages/users.php';
	require FL_PLUGIN_PATH . 'plugin-files/pages/notifications.php';
	require FL_PLUGIN_PATH . 'plugin-files/pages/statements.php';
	
	/* PLUGIN FUNCTIONS */
	require FL_PLUGIN_PATH . 'functions.php';
	require FL_PLUGIN_PATH . 'inc/utilities.php';
	require FL_PLUGIN_PATH . 'inc/custom-functions.php';
	require FL_PLUGIN_PATH . 'inc/search-functions.php';
	require FL_PLUGIN_PATH . 'inc/custom-statuses.php';
	require FL_PLUGIN_PATH . 'inc/emails.php';
	require FL_PLUGIN_PATH . 'inc/woo-functions.php';
	require FL_PLUGIN_PATH . 'inc/disputes.php';
    require FL_PLUGIN_PATH . 'inc/disputes-service.php';
	require FL_PLUGIN_PATH . 'inc/payouts.php';
	require FL_PLUGIN_PATH . 'inc/basic-function.php';
	require FL_PLUGIN_PATH . 'inc/woo-employer-packages.php';
	require FL_PLUGIN_PATH . 'inc/woo-freelancer-packages.php';
	require FL_PLUGIN_PATH . 'inc/crons.php';
	if(class_exists('ACF'))
	{
		require FL_PLUGIN_PATH . 'inc/custom-fields/exertio_fields.php';
		require FL_PLUGIN_PATH . 'inc/custom-fields/exertio_services_fields.php';
		require FL_PLUGIN_PATH . 'inc/custom-fields/exertio_freelancer_fields.php';
		require FL_PLUGIN_PATH . 'inc/custom-fields/exertio_employer_fields.php';
	}

	
	/*DATABASE TABLES*/
	require_once ( FL_PLUGIN_PATH.'/inc/db-tables.php' );
	register_activation_hook(__FILE__, array('fl_db_tables','fl_create_db_tables'));

	
	if ( ! function_exists( 'exertio_framework_chart_strings' ) )
	{
		function exertio_framework_chart_strings()
		{
			if(is_singular('projects') || is_singular('services') || is_singular('employer') || is_singular('freelancer') || isset($_GET['page-type']) && $_GET['page-type'] == 'dashboard' || is_page_template('page-profile.php') && empty($_GET['page-type']))
			{

				$single_id	=	get_the_ID();
				$view_key = '';
				if(is_singular('projects'))
				{
					$view_key = 'project';
				}
				if(is_singular('services'))
				{
					$view_key = 'service';
				}
				if(is_singular('employer'))
				{
					$view_key = 'employer';
				}
				if(is_singular('freelancer'))
				{
					$view_key = 'freelancer';
				}
				if(isset($_GET['page-type']) && $_GET['page-type'] == 'dashboard' || is_page_template('page-profile.php') && empty($_GET['page-type']))
				{
					if ( is_user_logged_in() )
					{
						$user_id = get_current_user_id();
						if(isset($_COOKIE["active_profile"]) &&  $_COOKIE["active_profile"] == 'employer' || isset($_COOKIE["active_profile"]) == '')
						{
							$view_key = 'employer';
							$single_id = get_user_meta( $user_id, 'employer_id' , true );
						}
						else if(isset($_COOKIE["active_profile"]) &&  $_COOKIE["active_profile"] == 'freelancer')
						{
							$view_key = 'freelancer';
							$single_id = get_user_meta( $user_id, 'freelancer_id' , true );
						}
					}
				}
				global $exertio_theme_options;
				$is_show = isset( $exertio_theme_options['exertio_layout_manager']['enabled']['views']) ? '1' : '0';
				$data = $labes = '';
				$chart_type = 'bar';
				if(isset($exertio_theme_options['exertio_chart_type']) && $exertio_theme_options['exertio_chart_type'] !="")
				{
					$chart_type = $exertio_theme_options['exertio_chart_type'];
				}
				$chart_bg =  isset($exertio_theme_options['exertio_chart_bg']['rgba']) ? $exertio_theme_options['exertio_chart_bg']['rgba'] : 'rgba(0,174,239,0.2)';
				$chart_border =  isset($exertio_theme_options['exertio_chart_border']) ? $exertio_theme_options['exertio_chart_border'] : '#00aeef';
				$labes = exertio_chart_labels($single_id,false,$view_key);
				$data = exertio_chart_labels($single_id, true,$view_key);
				 wp_localize_script(
					'exertio-stats',  // name of js file
					'chart_strings',
					 array(
						 'chart_type' => $chart_type,
						 'chart_bg' => $chart_bg,
						 'chart_border' => $chart_border,
						 'labelz' => $labes,
						 'stats_data' => $data,
						 'is_show' => $is_show,
					)
				);
			}
		}
		add_action('wp_enqueue_scripts', 'exertio_framework_chart_strings', 100);
	}
}