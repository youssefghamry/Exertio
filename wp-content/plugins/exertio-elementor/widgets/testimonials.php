<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Testimonials extends Widget_Base {
	
	public function get_name() {
		return 'testimonials';
	}
	
	public function get_title() {
		return __( 'Testimonials', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-star';
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
			'heading_section',
			[
				'label' => esc_html__( 'Section Heading', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Heading Text', 'exertio-elementor' ),
				'label_block' =>true,
				'placeholder' => __( 'Main Heading text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => __( 'Subtitle Here', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 4,
				'placeholder' => __( 'Type your description here', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'heading_style',
			[
				'label' => __( 'Heading Style', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'label_block' =>true,
				'options' => [
					'center'  => __( 'Center', 'exertio-elementor' ),
					'left' => __( 'Left', 'exertio-elementor' ),
				],
			]
		);
		$this->add_control(
			'heading_side_btn',
			[
				'label' => __( 'Want to show heading side button', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center',
				'label_block' =>true,
				'options' => [
					'yes'  => __( 'Yes', 'exertio-elementor' ),
					'no' => __( 'NO', 'exertio-elementor' ),
				],
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'heading_style',
                            'operator' => 'in',
                            'value' => [
                                'left',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'heading_side_btn_text',
			[
				'label' => __( 'Provide button text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
				'conditions' => [
                    'terms' => [
                        	[
                            'name' => 'heading_side_btn',
                            'operator' => 'in',
                            'value' => [
                                'yes',
                            ],
                        ],
						[
                            'name' => 'heading_style',
                            'operator' => 'in',
                            'value' => [
                                'left',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'heading_side_btn_link',
			[
				'label' => __( 'Provide button link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'label_block' =>true,
				'conditions' => [
					'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'heading_side_btn',
                            'operator' => 'in',
                            'value' => [
                                'yes',
                            ],
                        ],
						[
                            'name' => 'heading_style',
                            'operator' => 'in',
                            'value' => [
                                'left',
                            ],
                        ],
                    ],
                ]
			]
		);
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'main_section_heading',
			[
				'label' => esc_html__( 'Main Image', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'main_image',
			[
				'label' => __( 'main Image', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'testimonial_heading',
			[
				'label' => esc_html__( 'Testimonials', 'exertio-elementor' ),
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'user_image',
			[
				'label' => __( 'User Image', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'subheading_text',
			[
				'label' => __( 'Provide Subheading text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$repeater->add_control(
			'heading_text',
			[
				'label' => __( 'Heading text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$repeater->add_control(
			'desc_text',
			[
				'label' => __( 'Review Description', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' =>true,
			]
		);
		$repeater->add_control(
			'reviewer_name',
			[
				'label' => __( 'Customer Name', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$repeater->add_control(
			'designation',
			[
				'label' => __( 'Customer Designation', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);

		$this->add_control(
			'testimonial_list',
			[
				'label' => __( 'Testimonial List', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),

			]
		);

		$this->end_controls_section();

			
	}
	
		protected function render() {
		$settings = $this->get_settings_for_display();

		$params['heading_text'] = $settings['heading_text'];
		$params['heading_description'] = $settings['heading_description'];
		$params['heading_style'] = $settings['heading_style'];
		$params['heading_side_btn'] = $settings['heading_side_btn'];
		$params['heading_side_btn_text'] = $settings['heading_side_btn_text'];
		$params['heading_side_btn_link'] = $settings['heading_side_btn_link'];
		
		
		$params['main_image'] = $settings['main_image'];
		$params['testimonial_list'] = $settings['testimonial_list'];
			echo exertio_element_testimonial($params);
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() )
			{
				?>
				<script>
					jQuery('.client-slider').owlCarousel({
						loop: true,
						margin: 10,
						autoplay: true,
						nav: true,
						responsive: {
							0: {
								items: 1
							},
							600: {
								items: 1
							},
							1000: {
								items: 1
							}
						}
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