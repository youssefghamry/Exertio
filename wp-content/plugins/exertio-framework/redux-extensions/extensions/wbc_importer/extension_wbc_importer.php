<?php
/**
 * Extension-Boilerplate
 *
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.3
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_extension_wbc_importer' ) ) {

    class ReduxFramework_extension_wbc_importer {

        public static $instance;

        static $version = "1.0.3";

        protected $parent;

        private $filesystem = array();

        public $extension_url;

        public $extension_dir;

        public $demo_data_dir;

        public $wbc_import_files = array();

        public $active_import_id;

        public $active_import;


        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct( $parent ) {

            $this->parent = $parent;

            if ( !is_admin() ) return;

            //Hides importer section if anything but true returned. Way to abort :)
            if ( true !== apply_filters( 'wbc_importer_abort', true ) ) {
                return;
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
                $this->demo_data_dir = apply_filters( "wbc_importer_dir_path", $this->extension_dir . 'demo-data/' );
            }

            //Delete saved options of imported demos, for dev/testing purpose
            // delete_option('wbc_imported_demos');

            $this->getImports();

            $this->field_name = 'wbc_importer';

            self::$instance = $this;

            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this,
                    'overload_field_path'
                ) );

            add_action( 'wp_ajax_redux_wbc_importer', array(
                    $this,
                    'ajax_importer'
                ) );

            add_filter( 'redux/'.$this->parent->args['opt_name'].'/field/wbc_importer_files', array(
                    $this,
                    'addImportFiles'
                ) );

            //Adds Importer section to panel
            $this->add_importer_section();

            include $this->extension_dir.'inc/class-wbc-importer-progress.php';
            $wbc_progress = new Wbc_Importer_Progress( $this->parent );
        }

        /**
         * Get the demo folders/files
         * Provided fallback where some host require FTP info
         *
         * @return array list of files for demos
         */
        public function demoFiles() {

            $this->filesystem = $this->parent->filesystem->execute( 'object' );
            $dir_array = $this->filesystem->dirlist( $this->demo_data_dir, false, true );

            if ( !empty( $dir_array ) && is_array( $dir_array ) ) {
               
                uksort( $dir_array, 'strcasecmp' );
                return $dir_array;

            }else{

                $dir_array = array();

                $demo_directory = array_diff( scandir( $this->demo_data_dir ), array( '..', '.' ) );

                if ( !empty( $demo_directory ) && is_array( $demo_directory ) ) {
                    foreach ( $demo_directory as $key => $value ) {
                        if ( is_dir( $this->demo_data_dir.$value ) ) {

                            $dir_array[$value] = array( 'name' => $value, 'type' => 'd', 'files'=> array() );

                            $demo_content = array_diff( scandir( $this->demo_data_dir.$value ), array( '..', '.' ) );

                            foreach ( $demo_content as $d_key => $d_value ) {
                                if ( is_file( $this->demo_data_dir.$value.'/'.$d_value ) ) {
                                    $dir_array[$value]['files'][$d_value] = array( 'name'=> $d_value, 'type' => 'f' );
                                }
                            }
                        }
                    }

                    uksort( $dir_array, 'strcasecmp' );
                }
            }
            return $dir_array;
        }


        public function getImports() {

            if ( !empty( $this->wbc_import_files ) ) {
                return $this->wbc_import_files;
            }

            $imports = $this->demoFiles();

            $imported = get_option( 'wbc_imported_demos' );

            if ( !empty( $imports ) && is_array( $imports ) ) {
                $x = 1;
                foreach ( $imports as $import ) {

                    if ( !isset( $import['files'] ) || empty( $import['files'] ) ) {
                        continue;
                    }

                    if ( $import['type'] == "d" && !empty( $import['name'] ) ) {
                        $this->wbc_import_files['wbc-import-'.$x] = isset( $this->wbc_import_files['wbc-import-'.$x] ) ? $this->wbc_import_files['wbc-import-'.$x] : array();
                        $this->wbc_import_files['wbc-import-'.$x]['directory'] = $import['name'];

                        if ( !empty( $imported ) && is_array( $imported ) ) {
                            if ( array_key_exists( 'wbc-import-'.$x, $imported ) ) {
                                $this->wbc_import_files['wbc-import-'.$x]['imported'] = 'imported';
                            }
                        }

                        foreach ( $import['files'] as $file ) {
                            switch ( $file['name'] ) {
                            case 'content.xml':
                                $this->wbc_import_files['wbc-import-'.$x]['content_file'] = $file['name'];
                                break;

                            case 'theme-options.txt':
                            case 'theme-options.json':
                                $this->wbc_import_files['wbc-import-'.$x]['theme_options'] = $file['name'];
                                break;

                            case 'widgets.json':
                            case 'widgets.txt':
                                $this->wbc_import_files['wbc-import-'.$x]['widgets'] = $file['name'];
                                break;

                            case 'screen-image.png':
                            case 'screen-image.jpg':
                            case 'screen-image.gif':
                                $this->wbc_import_files['wbc-import-'.$x]['image'] = $file['name'];
                                break;
                            }

                        }

                    }

                    $x++;
                }

            }

        }

        public function addImportFiles( $wbc_import_files ) {

            if ( !is_array( $wbc_import_files ) || empty( $wbc_import_files ) ) {
                $wbc_import_files = array();
            }

            $wbc_import_files = wp_parse_args( $wbc_import_files, $this->wbc_import_files );

            return $wbc_import_files;
        }

        public function ajax_importer() {
            if ( !isset( $_REQUEST['nonce'] ) || !wp_verify_nonce( $_REQUEST['nonce'], "redux_{$this->parent->args['opt_name']}_wbc_importer" ) ) {
                die( 0 );
            }
            if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == "import-demo-content" && array_key_exists( $_REQUEST['demo_import_id'], $this->wbc_import_files ) ) {

                $reimporting = false;

                if ( isset( $_REQUEST['wbc_import'] ) && $_REQUEST['wbc_import'] == 're-importing' ) {
                    $reimporting = true;
                }

                $this->active_import_id = $_REQUEST['demo_import_id'];
                
                $this->active_import = array( $this->active_import_id => $this->wbc_import_files[$this->active_import_id] );

                if ( !isset( $import_parts['imported'] ) || true === $reimporting ) {
                    include $this->extension_dir.'inc/init-installer.php';
                    $installer = new Radium_Theme_Demo_Data_Importer( $this, $this->parent );
                }else {
                    echo esc_html__( "Demo Already Imported", 'exertio_framework' );
                }

                die();
            }

            die();
        }

        public static function get_instance() {
            return self::$instance;
        }

        public function overload_field_path( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }

        function add_importer_section() {
            for ( $n = 0; $n <= count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'wbc_importer_section' ) {
                    return;
                }
            }

            $wbc_importer_label = trim( esc_html( apply_filters( 'wbc_importer_label', __( 'Demo Importer', 'exertio_framework' ) ) ) );

            $wbc_importer_label = ( !empty( $wbc_importer_label ) ) ? $wbc_importer_label : __( 'Demo Importer', 'exertio_framework' );

            $this->parent->sections[] = array(
                'id'     => 'wbc_importer_section',
                'title'  => $wbc_importer_label,
                'desc'   => '<p class="description">'. apply_filters( 'wbc_importer_description', esc_html__( 'Works best to import on a new install of WordPress', 'exertio_framework' ) ).'</p>',
                'icon'   => 'el-icon-website',
                'fields' => array(
                    array(
                        'id'   => 'wbc_demo_importer',
                        'type' => 'wbc_importer'
                    )
                )
            );
        }

    }
	if ( !function_exists( 'wbc_after_theme_options' ) )
	{
		add_action('wbc_importer_after_theme_options_import', 'wbc_after_theme_options', 10, 2 );
		function wbc_after_theme_options( $demo_active_import , $demo_data_directory_path )
		{
			$current_demo	=	end( explode("/", rtrim($demo_data_directory_path, '/')));
			global $wpdb;

			if( $current_demo == 'Exertio Theme Demo')
			{
				$home = get_page_by_title('Home 4');
				update_option( 'page_on_front', $home->ID );
				update_option( 'show_on_front', 'page' );

				// Blog Page
				$blog   = get_page_by_title( 'Blog' );
				update_option( 'page_for_posts', $blog->ID );
				//Menu
				

				global $wp_rewrite;
				$wp_rewrite->set_permalink_structure('/%postname%/');
				update_option("rewrite_rules", FALSE);
				$wp_rewrite->flush_rules(true);
				
				
//				$wpdb->query("INSERT INTO wp_users
//	            (ID, user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
//				VALUES
//				(2, 'skhan', '', 'skhan', 'skhan@gmail.com', '', '2020-12-31 05:21:25', '', 0, 's khan'),
//				(3, 'jason', '', 'jason', 'Jason@gmail.com', '', '2020-12-31 06:07:59', '', 0, 'Jason'),
//				(4, 'finn', '', 'finn', 'Finn@gmail.com', '', '2021-01-01 07:14:37', '', 0, 'Finn'),
//				(5, 'dean', '', 'dean', 'Dean@gmail.com', '', '2021-01-01 08:48:07', '', 0, 'Dean'),
//				(6, 'paul', '', 'paul', 'Paul@gmail.com', '', '2021-01-01 09:34:07', '', 0, 'Paul'),
//				(7, 'edison', '', 'edison', 'Edison@gmail.com', '', '2021-01-01 11:57:03', '', 0, 'Edison'),
//				(8, 'sam', '', 'sam', 'Sam@gmail.com', '', '2021-01-01 12:54:37', '', 0, 'Sam'),
//				(9, 'yosef', '', 'yosef', 'yosef@gmail.com', '', '2021-01-01 13:40:34', '', 0, 'yosef'),
//				(10, 'scriptsbundle60', '', 'scriptsbundle60', 'scriptsbundle60@gmail.com', '', '2021-01-15 09:07:44', '', 0, 's khan')");
//				
//
//				$wpdb->query("TRUNCATE TABLE $wpdb->usermeta");
//				$wpdb->query("TRUNCATE TABLE $wpdb->posts");
//				$wpdb->query("TRUNCATE TABLE $wpdb->postmeta");
//                // replacing the table data
//                exertio_demo_importing_data($current_demo);
				
				
				$menu_name = "Exertio Main Menu";
				$menu_id = wp_create_nav_menu($menu_name);
				
				$submenu = wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Main Page'),
					'menu-item-classes' => 'main-page',
					'menu-item-url' => home_url(''),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $asd
				));

				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Home 1'),
					'menu-item-classes' => 'home-one',
					'menu-item-url' => home_url('/home-1'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Home 2'),
					'menu-item-classes' => 'home-two',
					'menu-item-url' => home_url('/home-2'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Home 3'),
					'menu-item-classes' => 'home-two',
					'menu-item-url' => home_url('/home-3'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Home 4'),
					'menu-item-classes' => 'home-two',
					'menu-item-url' => home_url('/home-4'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('How it Works'),
					'menu-item-classes' => 'the-process',
					'menu-item-url' => home_url('/the-process/'),
					'menu-item-status' => 'publish'
				));
				$submenu2 = wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Browse Jobs'),
					'menu-item-classes' => 'browse-jobs',
					'menu-item-url' => home_url('/project-search'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $asd
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Project Search'),
					'menu-item-classes' => 'project-search',
					'menu-item-url' => home_url('/project-search'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu2
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Project Detail'),
					'menu-item-classes' => 'project-detail',
					'menu-item-url' => home_url('/projects/website-designer-required-for-directory-theme-2'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu2
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Services Search'),
					'menu-item-classes' => 'services-search',
					'menu-item-url' => home_url('/services-search'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu2
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Project Detail'),
					'menu-item-classes' => 'project-detail',
					'menu-item-url' => home_url('/services/we-will-create-your-dream-business-logo-with-in-24-hours'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu2
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Employers Packages'),
					'menu-item-classes' => 'employers-packages',
					'menu-item-url' => home_url('/employer-packages'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu2
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Freelancers Packages'),
					'menu-item-classes' => 'freelancers-packages',
					'menu-item-url' => home_url('/freelancer-packages'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu2
				));
				$submenu3 = wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Pages'),
					'menu-item-classes' => 'pages',
					'menu-item-url' => home_url('/about-us'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $asd
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('About Us'),
					'menu-item-classes' => 'about-us',
					'menu-item-url' => home_url('/about-us'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu3
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Blog'),
					'menu-item-classes' => 'blog',
					'menu-item-url' => home_url('/blog'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu3
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Blog Detail'),
					'menu-item-classes' => 'blog-detail',
					'menu-item-url' => home_url('/what-is-cybersecurity'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu3
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Privacy Policy'),
					'menu-item-classes' => 'tems-and-conditions',
					'menu-item-url' => home_url('/terms-and-conditions'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu3
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('404 Page'),
					'menu-item-classes' => 'not-found',
					'menu-item-url' => home_url('/not-fonud'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu3
				));
				wp_update_nav_menu_item($menu_id, 0, array(
					'menu-item-title' => __('Contact Us'),
					'menu-item-classes' => 'contact-us',
					'menu-item-url' => home_url('/contact-us'),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $submenu3
				));

				$top_menu = get_term_by( 'name', 'Exertio Main Menu', 'nav_menu' );
				if ( isset( $top_menu->term_id ) ) {
					set_theme_mod( 'nav_menu_locations', array(
							'main_theme_menu' => $top_menu->term_id,
						)
					);
				}				
				
				
			}
		}
	}
	
// Importing data
//if (!function_exists('exertio_demo_importing_data')) {
//
//    function exertio_demo_importing_data($demo_type) {
//        global $wpdb;
//        $sql_file_OR_content;
//		if( $demo_type == 'Exertio Theme Demo')
//		{
//            $sql_file_OR_content = FL_PLUGIN_PATH . 'sql/exertio-demo.sql';
//        }
//		update_option('arslan', 'yes');
//        $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content) );
//        $allLines = explode("\n", $SQL_CONTENT);
//        $zzzzzz = $wpdb->query('SET foreign_key_checks = 0');
//        preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
//
//        $zzzzzz = $wpdb->query('SET foreign_key_checks = 1');
//        $templine = '';
//        foreach ($allLines as $line) { 
//            if (substr($line, 0, 2) != '--' && $line != '') {
//                $templine .= $line;
//                if (substr(trim($line), -1, 1) == ';') {  
//                    if ($wpdb->prefix != 'wp_') {
//                        $templine = str_replace("`wp_", "`$wpdb->prefix", $templine);
//                    }
//                    if (!$wpdb->query($templine)) {
//                    }
//                    $templine = '';
//                }
//            }
//        }
//    }
//
//}


}
