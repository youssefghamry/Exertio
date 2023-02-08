<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Exertio_Projects extends Widget_Base {
	
	public function get_name() {
		return 'exertio-projects';
	}
	
	public function get_title() {
		return __( 'Exertio Projects', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-library-open';
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

    public function get_customparant_terms($taxonomy)
    {
        $type = array();
        $terms = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => 0, 'hide_empty' => 0 ));
        $type = ['all' => 'All'];
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) )
        {
            foreach ( $terms as $term ) {
                $type[$term->term_id] = $term->name . ' (' . $term->count . ')';
            }
        }
        return $type;
    }

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
			'section_query',
			[
				'label' => esc_html__( 'Exertio Projects', 'exertio-elementor' ),
			]
		);
		
		$this->add_control(
			'project_list_style',
			[
				'label' => __( 'Selecte Project List Style', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'list_1'  => __( 'List 1', 'exertio-elementor' ),
						'list_2'  => __( 'List 2', 'exertio-elementor' ),
						'list_3'  => __( 'List 3', 'exertio-elementor' ),
						'list_4'  => __( 'List 4', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		$this->add_control(
			'projects_type',
			[
				'label' => __( 'Select Project Type', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'featured'  => __( 'Featured', 'exertio-elementor' ),
						'simple'  => __( 'Simple', 'exertio-elementor' ),
						'both'  => __( 'Both', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
        $this->add_control(
            'project_categories',
            [
                'label' => __( 'Project  Category', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' =>  $this->get_customparant_terms('project-categories'),
                'label_block' => true,
            ]

        );
//        $this->add_control(
//            'projects_taxonomies',
//            [
//                'label' => __( 'Select Category', 'exertio-elementor' ),
//                'type' => \Elementor\Controls_Manager::SELECT2,
//                'options' => [
//                    'Categories'  => __( 'Categories', 'exertio-elementor' ),
//                    'freelancer_type'  => __( 'Freelancer Type', 'exertio-elementor' ),
//                    'skills'  => __( 'Skills', 'exertio-elementor' ),
//                    'languages'  => __( 'Languages', 'exertio-elementor' ),
//                    'locations'  => __( 'Locations', 'exertio-elementor' ),
//                ],
//                'label_block' => true
//            ]
//        );
		$this->add_control(
			'projects_list_cols',
			[
				'label' => __( 'Lists in a Row', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( '1 in a row', 'exertio-elementor' ),
						'2'  => __( '2 in a row', 'exertio-elementor' ),
				],
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'project_list_style',
                            'operator' => 'in',
                            'value' => [
                                'list_1',
								'list_2',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'projects_count',
			[
				'label' => __( 'Number of Projects to show', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'2'  => __( '2', 'exertio-elementor' ),
						'4'  => __( '4', 'exertio-elementor' ),
						'6'  => __( '6', 'exertio-elementor' ),
						'8'  => __( '8', 'exertio-elementor' ),
						'10'  => __( '10', 'exertio-elementor' ),
						'12'  => __( '12', 'exertio-elementor' ),
						'14'  => __( '14', 'exertio-elementor' ),
						'16'  => __( '16', 'exertio-elementor' ),
						'18'  => __( '18', 'exertio-elementor' ),
						'20'  => __( '20', 'exertio-elementor' ),
						'22'  => __( '22', 'exertio-elementor' ),
						'24'  => __( '24', 'exertio-elementor' ),
						'26'  => __( '26', 'exertio-elementor' ),
						'28'  => __( '28', 'exertio-elementor' ),
						'30'  => __( '30', 'exertio-elementor' ),
						'32'  => __( '32', 'exertio-elementor' ),
						'34'  => __( '34', 'exertio-elementor' ),
						'36'  => __( '36', 'exertio-elementor' ),
						'38'  => __( '38', 'exertio-elementor' ),
						'40'  => __( '40', 'exertio-elementor' ),
						'45'  => __( '40', 'exertio-elementor' ),
						'50'  => __( '40', 'exertio-elementor' ),
						'-1'  => __( 'All', 'exertio-elementor' ),
				],
				'label_block' => true
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
        $params['project_categories'] = $settings['project_categories'] ? $settings['project_categories'] : 'all';
//        $params['projects_taxonomies'] = $settings['projects_taxonomies'];
		$params['project_list_style'] = $settings['project_list_style'];
		$params['projects_type'] = $settings['projects_type'];
		$params['projects_count'] = $settings['projects_count'];
		$params['projects_list_cols'] = $settings['projects_list_cols'];


			echo exertio_element_projects($params);
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
//	protected function content_template() {
//
//	}
}