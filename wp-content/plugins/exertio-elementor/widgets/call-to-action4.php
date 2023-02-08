<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Call_To_Action_Four extends Widget_Base {
	
	public function get_name() {
		return 'call-to-action-four';
	}
	
	public function get_title() {
		return __( 'Call to action 4', 'exertio-elementor' );
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
			'section_query',
			[
				'label' => esc_html__( 'Call to action four Content', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'sub_title_text',
			[
				'label' => __( 'Sub title text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the sub title', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide the main title', 'exertio-elementor' ),
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
			'desc_text',
			[
				'label' => __( 'Description paragraph', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'title' => __( 'Provide description', 'exertio-elementor' ),
				'rows' => 3,
				'placeholder' => __( 'Provide description', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'btn_text',
			[
				'label' => __( 'Provide button text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'btn_link',
			[
				'label' => __( 'Provide button link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'btn_text_2',
			[
				'label' => __( 'Provide button two text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'btn_link_2',
			[
				'label' => __( 'Provide button two link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
			]
		);
		

		$this->end_controls_section();
					
	}
	
		protected function render() {
			$settings = $this->get_settings_for_display();

			$params['sub_title_text'] = $settings['sub_title_text'];
			$params['heading_text'] = $settings['heading_text'];
			$params['desc_text'] = $settings['desc_text'];
			$params['btn_text'] = $settings['btn_text'];
			$params['btn_link'] = $settings['btn_link'];
			$params['btn_text_2'] = $settings['btn_text_2'];
			$params['btn_link_2'] = $settings['btn_link_2'];
		
			echo exertio_element_call_to_action_four($params);
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