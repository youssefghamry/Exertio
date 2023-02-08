<?php
namespace ElementorExertio\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Facts_Counter extends Widget_Base {
	
	public function get_name() {
		return 'facts-counter';
	}
	
	public function get_title() {
		return __( 'Facts Counter', 'exertio-elementor' );
	}
	
	public function get_icon() {
		return 'eicon-rating';
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
				'label' => esc_html__( 'Facts Counter', 'exertio-elementor' ),
			]
		);
		$this->add_control(
			'section_position',
			[
				'label' => __( 'Section Position', 'exertio-elementor' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => [
						'1'  => __( 'Middle of section', 'exertio-elementor' ),
						'2'  => __( 'With in section', 'exertio-elementor' ),

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
			'icon',
			[
				'label' => __( 'Icon', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
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
			]
		);

		$this->end_controls_section();
		
			
	}
	
		protected function render() {
		$settings = $this->get_settings_for_display();
		
		$params['counter_list'] = $settings['counter_list'];
		$params['section_position'] = $settings['section_position'];

		
			echo exertio_element_facts_counter($params);
			
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() )
			{
				?>
				<script>
					var counterUp = window.counterUp["default"]; // import counterUp from "counterup2"
    
						var $counters = $(".counter");

						/* Start counting, do this on DOM ready or with Waypoints. */
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