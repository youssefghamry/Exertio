<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Category_list extends Widget_Base {
	
	public function get_name() {
		return 'Category-list';
	}
	
	public function get_title() {
		return __( 'Skills and Category List', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-editor-list-ul';
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
		
		$project_cats = $project_sk = $service_cats = $free_skills = $pro_locs = $ser_locs = $emp_locs = $free_locs = array();
		$project_categories = exertio_get_terms('project-categories'); 
		foreach($project_categories as $project_categorie)
		{
			$project_cats[$project_categorie->term_id] = $project_categorie->name;
		}
		
		$project_skills = exertio_get_terms('skills'); 
		foreach($project_skills as $project_skill)
		{
			$project_sk[$project_skill->term_id] = $project_skill->name;
		}
		
		$services_categories = exertio_get_terms('service-categories'); 
		foreach($services_categories as $services_categorie)
		{
			$service_cats[$services_categorie->term_id] = $services_categorie->name;
		}
		$freelancer_skills = exertio_get_terms('freelancer-skills'); 
		foreach($freelancer_skills as $freelancer_skill)
		{
			$free_skills[$freelancer_skill->term_id] = $freelancer_skill->name;
		}
		
		$project_locations = exertio_get_terms('locations'); 
		foreach($project_locations as $project_location)
		{
			$pro_locs[$project_location->term_id] = $project_location->name;
		}
		$services_locations = exertio_get_terms('services-locations'); 
		foreach($services_locations as $services_location)
		{
			$ser_locs[$services_location->term_id] = $services_location->name;
		}
		$employers_locations = exertio_get_terms('employer-locations'); 
		foreach($employers_locations as $employers_location)
		{
			$emp_locs[$employers_location->term_id] = $employers_location->name;
		}
		$free_locations = exertio_get_terms('freelancer-locations'); 
		foreach($free_locations as $free_location)
		{
			$free_locs[$free_location->term_id] = $free_location->name;
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
			'list_one_section',
			[
				'label' => esc_html__( 'List One', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'category_col_size',
			[
				'label' => __( 'Select option for list one', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( '6 in a row', 'exertio-elementor' ),
						'2'  => __( '4 in a row', 'exertio-elementor' ),
						'3'  => __( '3 ina row', 'exertio-elementor' ),
						'4'  => __( '2 in a row', 'exertio-elementor' ),
						'5'  => __( '1 in a row', 'exertio-elementor' ),
				],
				'label_block' => true,
			]
		);
		
		$this->end_controls_section();
		
		
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'plugin-name' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();
		
		
		$repeater->add_control(
			'list_title',
			[
				'label' => __( 'Title', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'exertio-elementor' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'list_one_select_skills',
			[
				'label' => __( 'Select option for list one', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'pro_cat'  => __( 'Project category', 'exertio-elementor' ),
						'pro_skills'  => __( 'Project skills', 'exertio-elementor' ),
						'service_cat'  => __( 'Services category', 'exertio-elementor' ),
						'freelancer_skils'  => __( 'Freelancer skills', 'exertio-elementor' ),
						'pro_loc'  => __( 'Project Locations', 'exertio-elementor' ),
						'ser_loc'  => __( 'Services Locations', 'exertio-elementor' ),
						'emp_loc'  => __( 'Employer Locations', 'exertio-elementor' ),
						'free_loc'  => __( 'Freelancer Locations', 'exertio-elementor' ),
				],
				'label_block' => true,
			]
		);
		
		
		$repeater->add_control(
			'project_category',
			[
				'label' => __( 'Select Project Categories', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $project_cats,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'pro_cat', ],
                        ],
                    ],
                ]
			]
		);
		$repeater->add_control(
			'project_skills',
			[
				'label' => __( 'Select project Skills', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $project_sk,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'pro_skills', ],
                        ],
                    ],
                ]
			]
		);
		$repeater->add_control(
			'services_categories',
			[
				'label' => __( 'Select Servcies Categories', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $service_cats,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'service_cat', ],
                        ],
                    ],
                ]
			]
		);
		$repeater->add_control(
			'freelancer_skills',
			[
				'label' => __( 'Select Freelancer Skills', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $free_skills,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'freelancer_skils', ],
                        ],
                    ],
                ]
			]
		);
		$repeater->add_control(
			'preoject_locations',
			[
				'label' => __( 'Select Project Locations', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $pro_locs,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'pro_loc', ],
                        ],
                    ],
                ]
			]
		);
		$repeater->add_control(
			'services_locations',
			[
				'label' => __( 'Select Services Locations', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $ser_locs,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'ser_loc', ],
                        ],
                    ],
                ]
			]
		);
		$repeater->add_control(
			'employers_locations',
			[
				'label' => __( 'Select Employers Locations', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $emp_locs,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'emp_loc', ],
                        ],
                    ],
                ]
			]
		);
		$repeater->add_control(
			'freelancer_locations',
			[
				'label' => __( 'Select Freelancer Locations', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $free_locs,
				'label_block' => true,
				'multiple' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'list_one_select_skills',
                            'operator' => 'in',
                            'value' => [ 'free_loc', ],
                        ],
                    ],
                ]
			]
		);

		$this->add_control(
			'tax_list',
			[
				'label' => __( 'You can select multiple values', 'plugin-domain' ),
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
		
		$params['category_col_size'] = $settings['category_col_size'];
		$params['tax_list'] = $settings['tax_list'];
		
		
			echo exertio_element_category_list($params);
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