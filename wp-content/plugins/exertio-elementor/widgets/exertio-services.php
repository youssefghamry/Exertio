<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Exertio_Services extends Widget_Base {
	
	public function get_name() {
		return 'exertio-services';
	}
	
	public function get_title() {
		return __( 'Exertio Services', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-cog';
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
				'label' => esc_html__( 'Exertio Services', 'exertio-elementor' ),
			]
		);
		
		$this->add_control(
			'services_grid_style',
			[
				'label' => __( 'Select Services Grid Style', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( 'Style 1', 'exertio-elementor' ),
						'2'  => __( 'Style 2', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		$this->add_control(
			'services_type',
			[
				'label' => __( 'Select Services Type', 'exertio-elementor' ),
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
            'services_categories',
            [
                'label' => __( 'Service Category', 'exertio-elementor' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'default' => 'all',
                'options' =>  $this->get_customparant_terms('service-categories'),
                'label_block' => true,
            ]
        );
		$this->add_control(
			'services_slider_grids',
			[
				'label' => __( 'Slider or Grids', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'slider'  => __( 'Slider', 'exertio-elementor' ),
						'grids'  => __( 'Grids', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		$this->add_control(
			'services_grids_cols',
			[
				'label' => __( 'Grids Cols', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( '4 in a row', 'exertio-elementor' ),
						'2'  => __( '3 in a row', 'exertio-elementor' ),
						'3'  => __( '2 in a row', 'exertio-elementor' ),
						'4'  => __( '1 in a row', 'exertio-elementor' ),
				],
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        	[
                            'name' => 'services_slider_grids',
                            'operator' => 'in',
                            'value' => [
                                'grids',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'services_count',
			[
				'label' => __( 'Number of services to show', 'exertio-elementor' ),
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
        $params['services_categories'] = $settings['services_categories'] ? $settings['services_categories'] : 'all';
		$params['services_grid_style'] = $settings['services_grid_style'];
		$params['services_type'] = $settings['services_type'];
		$params['services_count'] = $settings['services_count'];
		$params['services_slider_grids'] = $settings['services_slider_grids'];
		$params['services_grids_cols'] = $settings['services_grids_cols'];
		
		

		
		
			echo exertio_element_services($params);
			if($settings['services_slider_grids'] == 'slider')
			{
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() )
				{
					?>
					<script>
							jQuery('.top-services-2').owlCarousel({
								loop: false,
								margin: 20,
								autoplay: true,
								nav: true,
								navText: ["<i class='fal fa-long-arrow-left'></i>", "<i class='fal fa-long-arrow-right'></i>"],
								responsive: {
									0: {
										items: 1
									},
									600: {
										items: 2
									},
									1000: {
										items: 3
									}
								}
							});
					</script>
					<?php
				}
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
//	protected function content_template() {
//
//	}
}