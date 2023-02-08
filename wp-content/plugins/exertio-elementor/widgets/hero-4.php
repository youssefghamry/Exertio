<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_Four extends Widget_Base {
	
	public function get_name() {
		return 'hero-four';
	}
	
	public function get_title() {
		return __( 'Hero Section 4', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-inner-section';
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
			'section_query',
			[
				'label' => esc_html__( 'Hero Section four Content', 'exertio-elementor' ),
			]
		);
		
		$this->add_control(
			'sub_heading_text',
			[
				'label' => __( 'Sub Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the sub heading text', 'exertio-elementor' ),
				'rows' => 3,
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Main Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the main title', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide the main title', 'exertio-elementor' ),
			]
		);

		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'exertio-elementor' ),
			]
		);
		
		$this->add_control(
			'p_btn_text',
			[
				'label' => __( 'Primary button text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'p_btn_link',
			[
				'label' => __( 'Primary Button Link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'Provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			's_btn_text',
			[
				'label' => __( 'Secondary button text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			's_btn_link',
			[
				'label' => __( 'Secondary button link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'Provide link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);
		$this->add_control(
			'side_image',
			[
				'label' => __( 'Main Image', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_clients',
			[
				'label' => esc_html__( 'Clients Content', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'client_heading_text',
			[
				'label' => __( 'Client Heading Text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'client_desc_text',
			[
				'label' => __( 'Clients Description Text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'client_gallery',
			[
				'label' => __( 'Add clients logos', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);;
		
		$this->end_controls_section();
			
	}
	
	protected function render() 
	{
		$settings = $this->get_settings_for_display();

		$params['sub_heading_text'] = $settings['sub_heading_text'];
		$params['heading_text'] = $settings['heading_text'];
		$params['item_description'] = $settings['item_description'];
		
		$params['p_btn_text'] = $settings['p_btn_text'];
		$params['p_btn_link'] = $settings['p_btn_link'];
		$params['p_btn_link']['is_external'] = $settings['p_btn_link']['is_external'];
		$params['p_btn_link']['nofollow'] = $settings['p_btn_link']['nofollow'];
		
		$params['s_btn_text'] = $settings['s_btn_text'];
		$params['s_btn_link'] = $settings['s_btn_link'];
		$params['s_btn_link']['is_external'] = $settings['s_btn_link']['is_external'];
		$params['s_btn_link']['nofollow'] = $settings['s_btn_link']['nofollow'];
		
		$params['side_image'] = $settings['side_image'];
		$params['client_gallery'] = $settings['client_gallery'];
		
		$params['client_heading_text'] = $settings['client_heading_text'];
		$params['client_desc_text'] = $settings['client_desc_text'];


	//$params['primary_btn_title'] = $settings['primary_btn_title'];
	//$params['primary_btn_title']['is_external'] = $settings['primary_btn_title']['is_external'];
	//$params['primary_btn_title']['nofollow'] = $settings['primary_btn_title']['nofollow'];


		echo exertio_element_hero_four($params);

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