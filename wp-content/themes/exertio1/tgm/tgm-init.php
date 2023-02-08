<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme exertio
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/tgm/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'exertio_theme_register_required_plugins' );

function exertio_theme_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		 array(
			'name'               => esc_html__( 'Elementor', 'exertio_theme'), 
			'slug'               => 'elementor',
			'source'             => '',
			'required'           => true, 
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => esc_url( 'https://downloads.wordpress.org/plugin/elementor.3.6.1.zip'
			 ),
			'is_callable'        => '',
		),
		array(
			'name'               => esc_html__( 'Redux Framework', 'exertio_theme'), 
			'slug'               => 'redux-framework',
			'source'             => '',
			'required'           => true, 
			'version'            => '',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => esc_url( 'https://downloads.wordpress.org/plugin/redux-framework.4.3.12.zip'
			 ),
			'is_callable'        => '',
		),
        array(
            'name' => esc_html__('Woocommerce', 'exertio_theme'),
            'slug' => 'woocommerce', 
            'source' => '', 
            'required' => true, 
            'version' => '', 
            'force_activation' => false,
            'force_deactivation' => false, 
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/woocommerce.6.3.1.zip'),
            'is_callable' => '',
        ),
		array(
            'name' => esc_html__('Contact Form 7', 'exertio_theme'),
            'slug' => 'contact-form-7',
            'source' => '', 
            'required' => true, 
            'version' => '', 
            'force_activation' => false, 
            'force_deactivation' => false,
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/contact-form-7.5.5.6.zip'),
            'is_callable' => '',
        ),
		array(
            'name' => esc_html__('Advanced Custom Fields', 'exertio_theme'),
            'slug' => 'advanced-custom-fields',
            'source' => '', 
            'required' => false, 
            'version' => '', 
            'force_activation' => false, 
            'force_deactivation' => false,
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/advanced-custom-fields.5.12.zip'),
            'is_callable' => '',
        ),
		array(
			'name'               => esc_html__( 'Exertio Framework', 'exertio_theme' ),
			'slug'               => 'exertio-framework',
			'source'             => get_template_directory() . '/required-plugins/exertio-framework.zip',
			'required'           => true,
			'version'            => '1.1.3',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),
		array(
			'name'               => esc_html__( 'Exertio Elementor Widgets', 'exertio_theme' ),
			'slug'               => 'exertio-elementor',
			'source'             => get_template_directory() . '/required-plugins/exertio-elementor.zip',
			'required'           => true,
			'version'            => '1.0.8',
			'force_activation'   => false,
			'force_deactivation' => false,
			'external_url'       => '',
			'is_callable'        => '',
		),

	);

	$config = array(
		'id'           => 'exertio_theme', 
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
