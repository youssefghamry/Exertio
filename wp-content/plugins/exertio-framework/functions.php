<?php 
function exertio_framework_hide_admin_bar($show)
{
	if ( ! current_user_can('administrator'))
	{
		return false;
	}
	return $show;
}
add_filter( 'show_admin_bar', 'exertio_framework_hide_admin_bar' );
function exertio_get_terms($term_name = '', $hide_empty = false)
{
	$terms = get_terms( array(
                'taxonomy' => $term_name,
                'hide_empty' => $hide_empty,
				'orderby'      => 'name',
            ) );
	return $terms;
}


/* ENQUEUE MEDIA LIBRARY AND SCRIPT */
function services_attachment_wp_admin_enqueue() {
	global $exertio_theme_options;
	wp_enqueue_media();
	
	wp_enqueue_script( 'jquery-ui', FL_PLUGIN_URL. 'js/jquery-ui.js', array('jquery'), true, true );
	
	wp_enqueue_script( 'jquery-datetimepicker', FL_PLUGIN_URL. 'js/jquery.datetimepicker.full.js', array('jquery'), true, true );
	
	wp_enqueue_script( 'attachment_script', FL_PLUGIN_URL. 'js/attachment-upload.js', array('jquery'), true, true );
	
	wp_localize_script('attachment_script', 'exertio_localize_vars', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'selectAttachments' => esc_html__('Select Attachments', 'exertio_framework'),
		'attachmentAdd' => esc_html__('Ad Files', 'exertio_framework'),
		'selectImage' => esc_html__('Select Image', 'exertio_framework'),
		'pluginUrl' => FL_PLUGIN_URL,
		'maxTemUrlFields' => esc_html__('You can add max 10 new fields', 'exertio_framework'),
		'ConfirmText' => esc_html__('Are your sure?', 'exertio_framework'),
		'WentWorng' => esc_html__('Something went wrong', 'exertio_framework'),
		'awardDate' => esc_html__('Award Date', 'exertio_framework'),
		'awardName' => esc_html__('Award Name', 'exertio_framework'),
		'projectURL' => esc_html__('Project URL', 'exertio_framework'),
		'projectName' => esc_html__('Project Name', 'exertio_framework'),
		'expeName' => esc_html__('Experience Title', 'exertio_framework'),
		'expeCompName' => esc_html__('Company Name', 'exertio_framework'),
		'startDate' => esc_html__('Start Date', 'exertio_framework'),
		'endDate' => esc_html__('End Date', 'exertio_framework'),
		'endDatemsg' => esc_html__('Leave it empty to set it current job', 'exertio_framework'),
		'expeDesc' => esc_html__('Description', 'exertio_framework'),
		'eduName' => esc_html__('Education Title', 'exertio_framework'),
		'eduInstName' => esc_html__('Institute Name', 'exertio_framework'),
		'startDate' => esc_html__('Start Date', 'exertio_framework'),
		'endDate' => esc_html__('End Date', 'exertio_framework'),
		'eduEndDatemsg' => esc_html__('Leave it empty to set it current education', 'exertio_framework'),
		'notification_time' => isset($exertio_theme_options['exertio_notifications_time']) ? $exertio_theme_options['exertio_notifications_time'] : '',
		
			)
	);
}
add_action( 'admin_enqueue_scripts', 'services_attachment_wp_admin_enqueue' );
	
	


// define the function to be fired for logged in users
add_action("wp_ajax_get_my_terms", "get_my_terms");
function get_my_terms() {
	//echo $_POST['tax_name'];
	$tax_terms = exertio_get_terms($_POST['tax_name']);
	$terms .= '<select name="freelancer_skills[]">';
	foreach( $tax_terms as $tax_term ) {
		if( $tax_term->parent == 0 ) {
			 $terms .= '<option value="'. esc_attr( $tax_term->term_id ) .'">'. esc_html( $tax_term->name ) .'</option>';
		}
	}
	$terms .= '</select>';

    if (fl_framework_get_options('freelancer_skills_percentage') == 1) {
        $html = '<div class="ui-state-default"><span class="dashicons dashicons-move"></span><div class="col-4">' . $terms . '</div><div class="col-4"><input type="number" name="skills_percent[]" placeholder="' . __("Skills percentage", 'exertio_framework') . '"></div><a href="javascript:void(0);" class="remove_button"><img src="' . FL_PLUGIN_URL . '/images/error.png" >	</a></div>';
    }else{
        $html = '<div class="ui-state-default"><span class="dashicons dashicons-move"></span><div class="col-4">' . $terms . '</div><a href="javascript:void(0);" class="remove_button"><img src="' . FL_PLUGIN_URL . '/images/error.png" >	</a></div>';
    }
	echo $html;
	die;
}


add_action("wp_ajax_get_my_skills_terms", "get_my_skills_terms");
if ( ! function_exists( 'get_my_skills_terms' ) )
{
	function get_my_skills_terms() {

		$tax_terms = exertio_get_terms($_POST['tax_name']);
		$terms .= '<select name="freelancer_skills[]" class="form-control general_select">';
		foreach( $tax_terms as $tax_term ) {
			if( $tax_term->parent == 0 ) {
				 $terms .= '<option value="'. esc_attr( $tax_term->term_id ) .'">'. esc_html( $tax_term->name ) .'</option>';
			}
		}
		$terms .= '</select>';

        if (fl_framework_get_options('freelancer_skills_percentage') == 1) {
            $html = '<div class="ui-state-default"><i class="far fa-arrows"></i><div class="form-row"><div class="form-group col-md-6">' . $terms . '</div><div class="form-group col-md-6"><input type="number" name="skills_percent[]" placeholder="' . __("Skills percentage", 'exertio_framework') . '" class="form-control" required></div></div><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
        }else{
            $html = '<div class="ui-state-default"><i class="far fa-arrows"></i><div class="form-row"><div class="form-group col-md-12">' . $terms . '</div></div><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
        }
		echo $html;
		die;
	}
}

/*THEME OPTION FUNCTION PLACED HERE AGAINST THEEM CHECK ERROR*/
if ( ! function_exists( 'remove_demo' ) )
{
	function remove_demo() {
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', array(
				ReduxFrameworkPlugin::instance(),
				'plugin_metalinks'
			), null, 2 );
			remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
		}
	}
}

if ( ! function_exists( 'exertio_remove_media_buttons' ) )
{
	function exertio_remove_media_buttons()
	{
		global $current_screen;
		// Replace following array items with your own custom post types
		$post_types = array('employer','services','projects','freelancer','addons','disputes','payouts','verification','report');
		if (in_array($current_screen->post_type,$post_types))
		{
			remove_action('media_buttons', 'media_buttons');
		}
	}
}
add_action('admin_head','exertio_remove_media_buttons');


/*ADDING USER COLUMN*/
function new_modify_user_table( $column ) {
    $column['user_type'] = __( "User Type", 'exertio_framework' );
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id )
{
	$value = '';
	$freelancer_id = get_user_meta( $user_id, 'freelancer_id' , true );
	$emp_id = get_user_meta( $user_id, 'employer_id' , true );
	if(isset($freelancer_id) && $freelancer_id != '')
	{
		$freelancer_user_name = exertio_get_username('freelancer', $freelancer_id, '');
		$value .= __( "Freelancer: ", 'exertio_framework' ).'<a href="'.get_the_permalink($freelancer_id).'" tagret="_blank">'.$freelancer_user_name.'</a><br>';
	}
	if(isset($emp_id) && $emp_id != '')
	{
		$emp_user_name = exertio_get_username('employer', $emp_id, '');
		$value .= __( "Employer: ", 'exertio_framework' ).'<a href="'.get_the_permalink($emp_id).'" tagret="_blank">'.$emp_user_name.'</a>';
	}
    switch ($column_name) {
        case 'user_type' : return  $value;
            
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );








if(!function_exists('exertio_database_update_notice'))
{
	function exertio_database_update_notice(){
		$exists_value = get_option( '_notification_table_updated' );
		//echo $exists_value; 
		global $wpdb;
		$table = EXERTIO_NOTIFICATIONS_TBL;
		$table2 = EXERTIO_STATEMENTS_TBL;

		if ( $exists_value == false && $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table && $wpdb->get_var("SHOW TABLES LIKE '$table2'") != $table2) {
			 echo '<div class="notice notice-error exertio-notic">
					<h1> '.__("Exertio WordPress Theme database update needed ." , "exertio_theme").'</h1>
				 <p>'.__("To use <b>Exertio WordPress Theme</b> propery we must need to update database for the new features and fixes. Please click on button below to update it. " , "exertio_theme").'</p>
				 <button class="button button-primary" id="update_database">'.__("Update Now" , "exertio_theme").'</button>
			 </div>';
		}
	}
	add_action('admin_notices', 'exertio_database_update_notice');
}

if(!function_exists('exertio_admin_dashboard_section'))
{
	function exertio_admin_dashboard_section()
	{ 
		global $pagenow;
		if($pagenow != "index.php") return '';
		?>
		<div class="wr-ap">
			<br />
			<div id="welcome-panel" class="welcome-panel">
				<div class="welcome-panel-content">
					<h2><?php esc_html_e("Exertio - Freelance Marketplace WordPress Theme ", "exertio_theme");?></h2>
				</div>
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h3><?php esc_html_e("Get Started", "exertio_theme");?></h3>
					   <p>
						<?php esc_html_e("Docementation will helps you to understand the theme flow and will help you to setup the theme accordingly. Click the button below to go to the docementation." , "exertio_theme");?></p>
						<a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://documentation.scriptsbundle.com/"  target="_blank"><?php esc_html_e("Docementation" , "exertio_theme");?></a>
					</div>
					<div class="welcome-panel-column">
						<h3><?php esc_html_e("Having Issues? Get Support!", "exertio_theme");?></h3>
						<p>
						<?php esc_html_e("If you are facing any issue regarding setting up the theme. You can contact our support team they will be very happy to assist you." , "exertio_theme");?></p>
						<a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://scriptsbundle.ticksy.com/"  target="_blank"><?php esc_html_e("Get Theme Support" , "exertio_theme");?></a>                    
					</div>
					<div class="welcome-panel-column welcome-panel-last">
						<h3><?php esc_html_e("Looking For Customizations?", "exertio_theme");?></h3>
						<?php esc_html_e("Looking to add more features in the theme no problem. Our development team will customize the theme according to your requirnments. Click the link below to contact us." , "exertio_theme");?></p>
						<a class="button button-primary button-hero load-customize hide-if-no-customize" href="https://scriptsbundle.com/freelancer/"  target="_blank"><?php esc_html_e("Looking For Customization?" , "exertio_theme");?></a>  
					</div>
				</div>
				<br />
				 <p class="hide-if-no-customize">
					<?php esc_html_e("by" , "exertio_theme");?>, <a href="https://themeforest.net/user/scriptsbundle/portfolio" target="_blank"><?php esc_html_e("ScriptsBundle" , "exertio_theme");?></a>
				</p>

			</div>
		</div>
		<?php
	}
	add_action('admin_notices', 'exertio_admin_dashboard_section');
}

add_action("wp_ajax_update_database_table", "update_database_table");
if ( ! function_exists( 'update_database_table' ) )
{
	function update_database_table() {
		//register_activation_hook(__FILE__, array('fl_db_tables','fl_create_db_tables'));
		//echo $value;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$sql_notifications = "
        CREATE TABLE ".EXERTIO_NOTIFICATIONS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`updated_on` datetime,
		`post_id` int (11),
		`n_type` VARCHAR  (30),
		`sender_id` int (11),
		`receiver_id` int (11),
		`sender_type` VARCHAR  (30),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_NOTIFICATIONS_TBL, $sql_notifications );
		
		$sql_statements = "
        CREATE TABLE ".EXERTIO_STATEMENTS_TBL." (
        `id` int (11) NOT NULL AUTO_INCREMENT,
        `timestamp` datetime ,
		`post_id` int (11),
		`price` DECIMAL(10,2),
		`t_type` VARCHAR  (30),
		`t_status` VARCHAR  (30),
		`user_id` int (11),
		`status` int (11),
         PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        maybe_create_table( EXERTIO_STATEMENTS_TBL, $sql_statements );
		update_option( '_notification_table_updated', true );
		echo __( "Update done", 'exertio_framework' );
		exit;
	}
}