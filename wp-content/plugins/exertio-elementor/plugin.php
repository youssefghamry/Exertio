<?php
namespace ElementorExertio;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {
	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Include Widgets files
	 *
	 */
	private function include_widgets_files() {
		if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
		{
			require_once( __DIR__ . '/widgets/hero-1.php' );
			require_once( __DIR__ . '/widgets/hero-2.php' );
			require_once( __DIR__ . '/widgets/hero-slider.php' );
			require_once( __DIR__ . '/widgets/hero-3.php' );
			require_once( __DIR__ . '/widgets/hero-4.php' );
			require_once( __DIR__ . '/widgets/category-1.php' );
			require_once( __DIR__ . '/widgets/category-2.php' );
			require_once( __DIR__ . '/widgets/call-to-action.php' );
			require_once( __DIR__ . '/widgets/call-to-action2.php' );
			require_once( __DIR__ . '/widgets/call-to-action3.php' );
			require_once( __DIR__ . '/widgets/call-to-action4.php' );
			require_once( __DIR__ . '/widgets/exertio-services.php' );
			require_once( __DIR__ . '/widgets/pricing.php' );
			require_once( __DIR__ . '/widgets/pricing2.php' );
			require_once( __DIR__ . '/widgets/testimonials.php' );
			require_once( __DIR__ . '/widgets/blog.php' );
			require_once( __DIR__ . '/widgets/category-list.php' );
			require_once( __DIR__ . '/widgets/exertio-projects.php' );
			require_once( __DIR__ . '/widgets/facts-counter.php' );
			require_once( __DIR__ . '/widgets/exertio-projects-with-sidebar.php' );
			require_once( __DIR__ . '/widgets/contact.php' );
			require_once( __DIR__ . '/widgets/about-us.php' );
			require_once( __DIR__ . '/widgets/app-1.php' );
			require_once( __DIR__ . '/widgets/testimonials-2.php' );
			require_once( __DIR__ . '/widgets/how-it-works.php' );
			require_once( __DIR__ . '/widgets/how-it-works2.php' );
			require_once( __DIR__ . '/widgets/services.php' );
			require_once( __DIR__ . '/widgets/exertio-freelancers.php' );
		}
		
	}
	
	//Ad Shortcode Category
	public function add_elementor_widget_categories($category_manager)
	{
            $category_manager->add_category(
				'exertio',
				[
					'title' => __( 'Exertio Widgets', 'exertio-elementor' ),
					'icon' => 'fa fa-home',
				]
            );
    }
	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();
		if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
		{
			// Register Widgets
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_One());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Two());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Three());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Four());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hero_Slider());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Category_One());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Category_Two());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_One());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_Two());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_Three());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Call_To_Action_Four());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Exertio_Services());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing_Two());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Testimonials());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Blog());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Category_list());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Exertio_Projects());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Facts_Counter());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Exertio_Projects_With_Sidebar());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Exertio_Contact_Us());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Exertio_About_Us());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\App_section_one());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Testimonials_Two());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\How_it_Works());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\How_it_Works_Two());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Services_Element());
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Exertio_Freelancers());
		}
	}

	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered',  [ $this, 'add_elementor_widget_categories' ]  );
	}
}
if(in_array('exertio-framework/index.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	Plugin::instance();
}