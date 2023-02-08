<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Pricing extends Widget_Base {
	
	public function get_name() {
		return 'pricing';
	}
	
	public function get_title() {
		return __( 'Prcing Packages', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-tags';
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
		$employer_packages_products = $freelancer_packages_products = array();
		if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
		{
			if (function_exists( 'exertio_employers_packages' ) )
			{
				$packages = exertio_employers_packages();

				while ( $packages->have_posts() )
				{
					$packages->the_post();
					$products_id	=	get_the_ID();
					$product	=	wc_get_product( $products_id );
					$product_title = $product->get_title();
					$product_price = $product->get_price();
                $employer_packages_products[$products_id] = $product_title.'('.fl_price_separator($product_price).')';
                }
			}
		wp_reset_postdata();
		if (function_exists( 'exertio_freelancer_packages' ) )
		{
			$freelancer_packages = exertio_freelancer_packages();
			while ( $freelancer_packages->have_posts() )
			{
				$freelancer_packages->the_post();
				$f_products_id	=	get_the_ID();
				$f_product	=	wc_get_product( $f_products_id );
				$f_product_title = $f_product->get_title();
				$f_product_price = $f_product->get_price();
				$freelancer_packages_products[$f_products_id] = $f_product_title.'('.fl_price_separator($f_product_price).')';
			}
			wp_reset_postdata();
		}

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
			'packages_tab',
			[
				'label' => esc_html__( 'Select Packages', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'package_type',
			[
				'label' => __( 'Selecte Package Type', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'employers'  => __( 'For Employers', 'exertio-elementor' ),
						'freelancers'  => __( 'For Freelancers', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		$this->add_control(
			'package_col_size',
			[
				'label' => __( 'Selecte SIze', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( '3 in a row', 'exertio-elementor' ),
						'2'  => __( '4 in a row', 'exertio-elementor' ),
				],
				'label_block' => true
			]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'Employers_packages_tab',
			[
				'label' => esc_html__( 'Employers Packages list', 'exertio-elementor' ),
				'conditions' => [
                    'terms' => [
                        	[
                            'name' => 'package_type',
                            'operator' => 'in',
                            'value' => [
                                'employers',
                            ],
                        ],
                    ],
                ]
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'employer_background_color',
			[
				'label' => __( 'Background Color', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'black'  => __( 'Black', 'exertio-elementor' ),
					'white' => __( 'White', 'exertio-elementor' ),
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'employer_package_selection',
			[
				'label' => __( 'Select Employer Packages', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $employer_packages_products,
				'label_block' => true,
				
			]
		);
		$repeater->add_control(
			'is_package_featured',
			[
				'label' => __( 'Is featured', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes'  => __( 'Yes', 'exertio-elementor' ),
					'no' => __( 'No', 'exertio-elementor' ),
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'is_featured_text',
			[
				'label' => __( 'Text to show on badge', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Featured', 'exertio-elementor' ),
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        	[
                            'name' => 'is_package_featured',
                            'operator' => 'in',
                            'value' => [
                                'yes',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'employers_packages_list',
			[
				'label' => __( 'Employers Packages List', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				
			]
		);

		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'freelancer_packages_tab',
			[
				'label' => esc_html__( 'Freelancers Packages', 'exertio-elementor' ),
				'conditions' => [
                    'terms' => [
                        	[
                            'name' => 'package_type',
                            'operator' => 'in',
                            'value' => [
                                'freelancers',
                            ],
                        ],
                    ],
                ]
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'freelancer_background_color',
			[
				'label' => __( 'Background Color', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'black'  => __( 'Black', 'exertio-elementor' ),
					'white' => __( 'White', 'exertio-elementor' ),
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'freelancer_package_selection',
			[
				'label' => __( 'Select Freelancer Packages', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $freelancer_packages_products,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'is_package_featured',
			[
				'label' => __( 'Is featured', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes'  => __( 'Yes', 'exertio-elementor' ),
					'no' => __( 'No', 'exertio-elementor' ),
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'is_featured_text',
			[
				'label' => __( 'Text to show on badge', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Featured', 'exertio-elementor' ),
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        	[
                            'name' => 'is_package_featured',
                            'operator' => 'in',
                            'value' => [
                                'yes',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'freelancers_packages_list',
			[
				'label' => __( 'Freelancer Packages List', 'exertio-elementor' ),
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
			
			
				
		$params['package_type'] = $settings['package_type'];
		$params['package_col_size'] = $settings['package_col_size'];
		$params['employers_packages_list'] = $settings['employers_packages_list'];
		$params['freelancers_packages_list'] = $settings['freelancers_packages_list'];


			echo exertio_element_pricing($params);
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