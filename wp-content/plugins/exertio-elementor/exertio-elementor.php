<?php
/**
Plugin Name: Exertio Elementor Widgets
Description: This plugin can only be used with Exertio - Freelance Marketplace and Directory WordPress Theme. Tis will add new sections and design blocks for the Elelmentor plugin to use in Exerti Theme.
Author: Scripts Bundle
Theme URI: https://www.exertio-wp.com/
Author URI: http://scriptsbundle.com/
Version: 1.0.8
License: Themeforest Split Licence
License URI: https://themeforest.net/user/scriptsbundle/
Text Domain: exertio-elementor
Tags: freelance, freelancer marketplace, upwork clone, fiverr clone, services, projects, commission system, wallet system,
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

final class Exertio_Elementor {
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';
	public function __construct() {
		add_action( 'init', array( $this, 'i18n' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}
	
	public function i18n() {
		load_plugin_textdomain( 'exertio-elementor' );
	}
	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}
		
		
		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}
	
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_name = $plugin_data['Name'];
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'exertio-elementor' ),
			'<strong>' . $plugin_name . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'exertio-elementor' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_name = $plugin_data['Name'];
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'exertio-elementor' ),
			'<strong>' . $plugin_name . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'exertio-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$plugin_data = get_plugin_data( __FILE__ );
		$plugin_name = $plugin_data['Name'];
		$message = sprintf(
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'exertio-elementor' ),
			'<strong>' . $plugin_name . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'exertio-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
	
}
new Exertio_Elementor();