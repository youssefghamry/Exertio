<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Exertio_Projects_With_Sidebar extends Widget_Base {
	
	public function get_name() {
		return 'exertio-projects-with-sidebar';
	}
	
	public function get_title() {
		return __( 'Exertio Projects With Sidebar', 'exertio-elementor' );
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
	 
	 
	protected function register_controls() {
		$args	=	array
		(
			'post_type' => 'freelancer',
			'post_status' => 'publish',
			'posts_per_page' => -1,

		);
		$keyword = array();
		$results = new \WP_Query($args);
		if ($results->have_posts())
		{
			while ($results->have_posts())
			{
				$results->the_post();
				$freelancer_id = get_the_ID();
				$author_id = get_post_field( 'post_author', $freelancer_id );
				$email = get_the_author_meta( 'user_email', $author_id);
				$keyword[$freelancer_id] = exertio_get_username('freelancer', $freelancer_id, '').'('.$email.')';
			}
			wp_reset_postdata();
		}
		
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
				'label' => __( 'Selecte Project Type', 'exertio-elementor' ),
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
			'projects_count',
			[
				'label' => __( 'Number of Projects to show', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'5'  => __( '5', 'exertio-elementor' ),
						'10'  => __( '10', 'exertio-elementor' ),
						'15'  => __( '15', 'exertio-elementor' ),
						'20'  => __( '20', 'exertio-elementor' ),
						'25'  => __( '25', 'exertio-elementor' ),
						'30'  => __( '30', 'exertio-elementor' ),
						'35'  => __( '35', 'exertio-elementor' ),
						'40'  => __( '40', 'exertio-elementor' ),
						'45'  => __( '45', 'exertio-elementor' ),
						'50'  => __( '50', 'exertio-elementor' ),
						'-1'  => __( 'All', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'freelancer-section',
			[
				'label' => esc_html__( 'Freelancer Section', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'freelancer_section_heading',
			[
				'label' => __( 'Heading for Freelancer section', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'freelancer_grid_style',
			[
				'label' => __( 'Gride Style', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( 'Grid 1', 'exertio-elementor' ),
						'2'  => __( 'Grid 2', 'exertio-elementor' ),
						'3'  => __( 'Grid 3', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'freelancer_list',
			[
				'label' => __( 'Select Freelancer', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $keyword,
				'label_block' => true
			]
		);	

		$this->add_control(
			'slider_list',
			[
				'label' => __( 'Freelancers', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'freelancer-ads-section',
			[
				'label' => esc_html__( 'Advertisment Section', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'top_ad',
			[
				'label' => __( 'Advertisement At Top of sidebar', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' =>true,
			]
		);
		$this->add_control(
			'bottom_ad',
			[
				'label' => __( 'Advertisement At Bottom of sidebar', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' =>true,
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
		
		$params['project_list_style'] = $settings['project_list_style'];
		$params['projects_type'] = $settings['projects_type'];
		$params['projects_count'] = $settings['projects_count'];
		
		$params['freelancer_section_heading'] = $settings['freelancer_section_heading'];
		$params['slider_list'] = $settings['slider_list'];
		$params['freelancer_grid_style'] = $settings['freelancer_grid_style'];
			
		$params['top_ad'] = $settings['top_ad'];
		$params['bottom_ad'] = $settings['bottom_ad'];


			echo exertio_element_projects_with_sidebar($params);
			?>
			<script>
					jQuery('.top-lancer-slider').owlCarousel({
						loop: false,
						autoplay: true,
						nav: true,
						navText: ["<i class='fas fa-long-arrow-alt-left'></i>", "<i class='fas fa-long-arrow-alt-right'></i>"],
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