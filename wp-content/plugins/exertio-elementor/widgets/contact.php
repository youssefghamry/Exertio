<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Exertio_Contact_Us extends Widget_Base {
	
	public function get_name() {
		return 'contact-us';
	}
	
	public function get_title() {
		return __( 'Contact Us', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-headphones';
	}

	public function get_categories() {
		return [ 'exertio' ];
	}
	
	public function get_script_depends() {
		return [ '' ];
	}
	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	 
	 
	protected function register_controls() {
		$this->start_controls_section(
			'Sidebar_section',
			[
				'label' => esc_html__( 'Sidebar', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'sidebar_heading_text',
			[
				'label' => __( 'Sidebar Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the main title', 'exertio-elementor' ),
				'rows' => 3,
			]
		);
		
		$this->add_control(
			'sidebar_desc_text',
			[
				'label' => __( 'Sidebar Description', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide description', 'exertio-elementor' ),
				'rows' => 3,
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'sidebar_boxes',
			[
				'label' => __( 'Sidebar Boxes', 'exertio-elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'sidebar_boxes_title', [
				'label' => __( 'Title', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'exertio-elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'sidebar_boxes_detail', [
				'label' => __( 'Content', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'List Content' , 'exertio-elementor' ),
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'sidebar_boxes_image',
			[
				'label' => __( 'Choose icon', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);

		$this->add_control(
			'sidebar_list',
			[
				'label' => __( 'Boxes List', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'main_section',
			[
				'label' => esc_html__( 'Main section', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'main_image',
			[
				'label' => __( 'Choose icon', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		$this->add_control(
			'main_heading_text',
			[
				'label' => __( 'Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'title' => __( 'Provide the main title', 'exertio-elementor' ),
				'rows' => 3,
				'label_block' => true,
			]
		);
		
		$this->add_control(
			'main_desc_text',
			[
				'label' => __( 'Sidebar Description', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide description', 'exertio-elementor' ),
				'rows' => 3,
			]
		);
		$this->add_control(
			'main_contact_form',
			[
				'label' => __( 'Contact Form Short code', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide provide contact form Short code', 'exertio-elementor' ),
				'rows' => 3,
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{

		$settings = $this->get_settings_for_display();
		
		$params['sidebar_heading_text'] = $settings['sidebar_heading_text'];
		$params['sidebar_desc_text'] = $settings['sidebar_desc_text'];
		$params['sidebar_list'] = $settings['sidebar_list'];
		$params['main_image'] = $settings['main_image'];
		$params['main_heading_text'] = $settings['main_heading_text'];
		$params['main_desc_text'] = $settings['main_desc_text'];
		$params['main_contact_form'] = $settings['main_contact_form'];
		

			echo exertio_element_contact_us($params);
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function content_template() {
			
	}
}