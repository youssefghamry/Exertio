<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Exertio_About_Us extends Widget_Base {
	
	public function get_name() {
		return 'about-us';
	}
	
	public function get_title() {
		return __( 'About us', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-document-file';
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
				'label' => esc_html__( 'About us', 'exertio-elementor' ),
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
			'video_link',
			[
				'label' => __( 'Provide VIdeo link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'side_image',
			[
				'label' => __( 'SideImage', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'side_image_positiony',
			[
				'label' => __( 'Selecte Image Position', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'left'  => __( 'Left', 'exertio-elementor' ),
						'right'  => __( 'Right', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'features_section',
			[
				'label' => __( 'Features List', 'exertio-elementor' ),
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
		$this->add_control(
			'features_list',
			[
				'label' => __( 'Features List', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'facts_section_query',
			[
				'label' => esc_html__( 'Facts Counter', 'exertio-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'section_visibility',
			[
				'label' => __( 'Section Visibility', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'yes'  => __( 'Yes', 'exertio-elementor' ),
						'no'  => __( 'No', 'exertio-elementor' ),

				],
				'label_block' => true
			]
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'counter_icon',
			[
				'label' => __( 'Counter Icon', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		
		$repeater->add_control(
			'counter_title', [
				'label' => __( 'Counter Title', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'counter_numbers',
			[
				'label' => __( 'Value in Digits', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label_block' => true,
			]
		);

		

		$this->add_control(
			'counter_list',
			[
				'label' => __( 'Counters', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'section_visibility',
                            'operator' => 'in',
                            'value' => [
                                'yes',
                            ],
                        ],
                    ],
                ]
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
		$params['video_link'] = $settings['video_link'];
		$params['side_image'] = $settings['side_image'];
		$params['side_image_positiony'] = $settings['side_image_positiony'];
			
		$params['features_list'] = $settings['features_list'];
		$params['section_visibility'] = $settings['section_visibility'];
		$params['counter_list'] = $settings['counter_list'];
		
		
			echo exertio_element_about_us($params);
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() )
			{
				?>
				<script>
					var counterUp = window.counterUp["default"]; 
						var $counters = $(".counter");
						$counters.each(function (ignore, counter) {
							counterUp(counter, {
								duration: 1000,
								delay: 16
							});
						});
				</script>
				<?php
			}
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