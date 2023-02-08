<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Blog extends Widget_Base {
	
	public function get_name() {
		return 'blog';
	}
	
	public function get_title() {
		return __( 'Exertio Blog', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-folder-o';
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
			'blog_section',
			[
				'label' => esc_html__( 'Blog', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'title_limit',
			[
				'label' => __( 'Title Limit in Words', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'desc_limit',
			[
				'label' => __( 'Desciption Limit in words', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'no_of_post',
			[
				'label' => __( 'Number of posts', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		
		$this->add_control(
			'blog_grids_cols',
			[
				'label' => __( 'Grids Cols', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( '4 in a row', 'exertio-elementor' ),
						'2'  => __( '3 in a row', 'exertio-elementor' ),
						'3'  => __( '2 in a row', 'exertio-elementor' ),
				],
				'label_block' => true,
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
		
		
		
		$params['no_of_post'] = $settings['no_of_post'];
		$params['title_limit'] = $settings['title_limit'];
		$params['desc_limit'] = $settings['desc_limit'];
		$params['blog_grids_cols'] = $settings['blog_grids_cols'];
		
			echo exertio_element_blog($params);
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