<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Call_To_Action_Two extends Widget_Base {
	
	public function get_name() {
		return 'call-to-action-two';
	}
	
	public function get_title() {
		return __( 'Call to action 2', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-background';
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
			'right_section_query',
			[
				'label' => esc_html__( 'Right Side', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'right_heading_text',
			[
				'label' => __( 'Main Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the main title', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide the main title', 'exertio-elementor' ),
			]
		);
		
		$this->add_control(
			'right_desc_text',
			[
				'label' => __( 'Description paragraph', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide description', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide description', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'right_btn_text',
			[
				'label' => __( 'Provide button text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'right_btn_link',
			[
				'label' => __( 'Provide button link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'left_section_query',
			[
				'label' => esc_html__( 'Left Side', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'left_heading_text',
			[
				'label' => __( 'Main Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the main title', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide the main title', 'exertio-elementor' ),
			]
		);
		
		$this->add_control(
			'left_desc_text',
			[
				'label' => __( 'Description paragraph', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide description', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide description', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'left_btn_text',
			[
				'label' => __( 'Provide button text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'left_btn_link',
			[
				'label' => __( 'Provide button link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
			]
		);

		$this->end_controls_section();
			
	}
	
		protected function render() {
		$settings = $this->get_settings_for_display();
		
		$params['left_heading_text'] = $settings['left_heading_text'];
		$params['left_desc_text'] = $settings['left_desc_text'];
		$params['left_btn_text'] = $settings['left_btn_text'];
		$params['left_btn_link'] = $settings['left_btn_link'];
			
		$params['right_heading_text'] = $settings['right_heading_text'];
		$params['right_desc_text'] = $settings['right_desc_text'];
		$params['right_btn_text'] = $settings['right_btn_text'];
		$params['right_btn_link'] = $settings['right_btn_link'];

		
		
			echo exertio_element_call_to_action_two($params);
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