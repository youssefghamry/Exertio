<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Category_One extends Widget_Base {
	
	public function get_name() {
		return 'category-one';
	}
	
	public function get_title() {
		return __( 'Category Section 1', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-product-stock';
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
		$keyword = $service_keyword = array(); 
		
		$location_taxonomies = exertio_get_terms('project-categories'); 
		foreach($location_taxonomies as $location_taxonomie)
		{
			$keyword[$location_taxonomie->term_id] = $location_taxonomie->name;
		}
		
		$services_categories = exertio_get_terms('service-categories'); 
		foreach($services_categories as $services_categorie)
		{
			$service_keyword[$services_categorie->term_id] = $services_categorie->name;
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
				'label' => esc_html__( 'Category Selector', 'exertio-elementor' ),
			]
		);
		
		$this->add_control(
			'select_category',
			[
				'label' => __( 'Used For', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'projects'  => __( 'Project Categories', 'exertio-elementor' ),
						'services'  => __( 'Services Categories', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Project category selection', 'exertio-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'select_category',
                            'operator' => 'in',
                            'value' => [
                                'projects',
                            ],
                        ],
                    ],
                ]
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'category_selection',
			[
				'label' => __( 'Select Category', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $keyword,
				'label_block' => true
			]
		);
		$repeater->add_control(
			'project_cat_image',
			[
				'label' => __( 'Background Image', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'project_cat_icon',
			[
				'label' => __( 'Icon', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'project_category_list',
			[
				'label' => __( 'Category List', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'project_cat_image' => __( 'Category #1', 'exertio-elementor' ),
					],
					[
						'project_cat_image' => __( 'Category #2', 'exertio-elementor' ),
					],
				],
				//'title_field' => '{{{ project_cat_image }}}',
			]
		);

		$this->end_controls_section();
		
		
		
		
		/*SERVICES REPEATER*/
		$this->start_controls_section(
			'services_section',
			[
				'label' => __( 'Services category selection', 'exertio-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'select_category',
                            'operator' => 'in',
                            'value' => [
                                'services',
                            ],
                        ],
                    ],
                ]
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'services_category_selection',
			[
				'label' => __( 'Select Category', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $service_keyword,
				'label_block' => true
			]
		);
		$repeater->add_control(
			'service_cat_image',
			[
				'label' => __( 'Background Image', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
		$repeater->add_control(
			'service_cat_icon',
			[
				'label' => __( 'Icon', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'services_category_list',
			[
				'label' => __( 'Category List', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'service_cat_image' => __( 'Category #1', 'exertio-elementor' ),
					],
					[
						'service_cat_image' => __( 'Category #2', 'exertio-elementor' ),
					],
				],
				//'title_field' => '{{{ service_cat_image }}}',
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
		
		
		$params['select_category'] = $settings['select_category'];
		$params['project_category_list'] = $settings['project_category_list'];
		$params['services_category_list'] = $settings['services_category_list'];
			echo exertio_element_category_one($params);
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() )
			{
				?>
				<script>
					jQuery('.explore-slider').owlCarousel({
						loop: false,
						margin: 10,
						autoplay: true,
						nav: false,
						navText: ["<i class='la la-long-arrow-alt-left'></i>", "<i class='la la-long-arrow-alt-right'></i>"],
						responsive: {
							0: {
								items: 1
							},
							600: {
								items: 3
							},
							1000: {
								items: 4
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