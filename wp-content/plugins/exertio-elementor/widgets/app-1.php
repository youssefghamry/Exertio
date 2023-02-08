<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class App_section_one extends Widget_Base {
	
	public function get_name() {
		return 'app-section-one';
	}
	
	public function get_title() {
		return __( 'App Section 1', 'exertio-elementor' );
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
				'label' => esc_html__( 'App Section one Content', 'exertio-elementor' ),
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
			'main_image',
			[
				'label' => __( 'Main image', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'icon_boxes',
			[
				'label' => __( 'Store Icons', 'exertio-elementor' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon_boxes_image',
			[
				'label' => __( 'Choose icon', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);
		$repeater->add_control(
			'btn_link',
			[
				'label' => __( 'Provide link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => __( 'Boxes List', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
		
			
	}
	
		protected function render() {
			$settings = $this->get_settings_for_display();

			$params['sub_title_text'] = $settings['sub_title_text'];
			$params['heading_text'] = $settings['heading_text'];

			$params['main_image'] = $settings['main_image'];

			$params['icon_list'] = $settings['icon_list'];
		
			echo exertio_element_app_section_one($params);
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