<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Hero_Three extends Widget_Base {
	
	public function get_name() {
		return 'hero-three';
	}
	
	public function get_title() {
		return __( 'Hero Section 3', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-inner-section';
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
			'section_query',
			[
				'label' => esc_html__( 'Hero Section Three Content', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'post_type_select',
			[
				'label' => __( 'Used For', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => exertio_cpt_array_hero_section(),
				'label_block' => true
			]
		);
		$this->add_control(
			'sub_heading_text',
			[
				'label' => __( 'Sub Heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'title' => __( 'Provide the sub heading text', 'exertio-elementor' ),
				'rows' => 3,
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
			'item_description',
			[
				'label' => __( 'Description', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 10,
				'placeholder' => __( 'Type your description here', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'search_field_switch',
			[
				'label' => __( 'Want to show search field?', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'0'  => __( 'No', 'exertio-elementor' ),
						'1'  => __( 'Yes', 'exertio-elementor' ),

				],
				'label_block' => true
			]
		);
		$this->add_control(
			'search_field_placeholder_text',
			[
				'label' => __( 'Search Field placeholder text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Search Field placeholder text', 'exertio-elementor' ),
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'search_field_switch',
                            'operator' => 'in',
                            'value' => [
                                '1',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'select_placeholder_text',
			[
				'label' => __( 'Select Field placeholder text', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Select Field placeholder text', 'exertio-elementor' ),
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'search_field_switch',
                            'operator' => 'in',
                            'value' => [
                                '1',
                            ],
                        ],
                    ],
                ]
			]
		);
		$this->add_control(
			'search_btn_title',
			[
				'label' => __( 'Search Button Title', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Type your title here', 'exertio-elementor' ),
				'label_block' => true,
				'conditions' => [
                    'terms' => [
                        [
                            'name' => 'search_field_switch',
                            'operator' => 'in',
                            'value' => [
                                '1',
                            ],
                        ],
                    ],
                ]
			]
		);
	
		$this->add_control(
			'video_heading_title',
			[
				'label' => __( 'Video button heading', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Video button heading here', 'exertio-elementor' ),
				'label_block' => true
			]
		);		$this->add_control(
			'video_desc',
			[
				'label' => __( 'Video Description area', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Provide Video description text', 'exertio-elementor' ),
				'label_block' => true
			]
		);
		
		$this->add_control(
			'video_link',
			[
				'label' => __( 'Video Link', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'provide video link here', 'exertio-elementor' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'keyword_section',
			[
				'label' => esc_html__( 'Keyword section', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'keyword_titles',
			[
				'label' => __( 'Keyword area title', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'This will be only title', 'exertio-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'keyword_selection',
			[
				'label' => __( 'Select Keywords (separated by | Sign)', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __( 'You can give multiple keywords separated by | Sign', 'exertio-elementor' ),
				'label_block' => true
			]
		);
		$this->add_control(
			'keyword_post_type',
			[
				'label' => __( 'Used For', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => exertio_cpt_array_hero_section(),
				'label_block' => true
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'slider-section',
			[
				'label' => esc_html__( 'Select Slider destail ', 'exertio-elementor' ),
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
		$repeater->add_control(
			'freelancer_image',
			[
				'label' => __( 'Freelancer Image', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
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
			
	}
	
		protected function render() {
		$settings = $this->get_settings_for_display();
		
		$params['post_type_select'] = $settings['post_type_select'];
		$params['sub_heading_text'] = $settings['sub_heading_text'];
		$params['heading_text'] = $settings['heading_text'];
		
		$params['item_description'] = $settings['item_description'];
		$params['search_field_placeholder_text'] = $settings['search_field_placeholder_text'];
		$params['select_placeholder_text'] = $settings['select_placeholder_text'];
		$params['search_btn_title'] = $settings['search_btn_title'];
		$params['search_field_switch'] = $settings['search_field_switch'];
		
		$params['video_heading_title'] = $settings['video_heading_title'];
		$params['video_desc'] = $settings['video_desc'];
		$params['video_link'] = $settings['video_link'];
		$params['video_link']['is_external'] = $settings['video_link']['is_external'];
		$params['video_link']['nofollow'] = $settings['video_link']['nofollow'];
			
		$params['keyword_titles'] = $settings['keyword_titles'];
		$params['keyword_selection'] = $settings['keyword_selection'];
		$params['keyword_post_type'] = $settings['keyword_post_type'];
		
		$params['slider_list'] = $settings['slider_list'];

			echo exertio_element_hero_three($params);
			
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() )
			{
				?>
				<script>
					jQuery('.default-select').select2();
					jQuery('.elbow').owlCarousel({
						loop:false,
						margin:10,
							autoplay:true,
						nav:true,
						responsive:{
							0:{
								items:1
							},
							600:{
								items:1
							},
							1000:{
								items:1
							}
						}
					})	
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