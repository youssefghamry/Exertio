<?php
if (!function_exists('fl_authenticate_check')) {

    function fl_authenticate_check($post_id = '') {

        //$redirect_link = get_the_permalink($post_id);

        if (get_current_user_id() == "" || get_current_user_id() == 0) {

            if($post_id == '')
            {
                $return = array('message' => esc_html__( 'Please login first', 'exertio_framework' ));
                wp_send_json_error($return);
            }
            else
            {
                global $exertio_theme_options;
                $page = get_the_permalink($exertio_theme_options['login_page']).'?redirect='.$post_id;

                $return = array('message' => esc_html__( 'Please login first. We will redirect you back here.', 'exertio_framework' ), 'page' => $page);
                wp_send_json_success($return);

            }

        }
    }
}
// Bad word filter
if (!function_exists('fl_badwords_filter')) {

    function fl_badwords_filter($words = array(), $string = '' , $replacement = '') {
        foreach ($words as $word) {
            $string = str_replace($word, $replacement, $string);
        }
        return $string;
    }
}

if (!function_exists('get_icon_for_attachment')) {
    function get_icon_for_attachment($post_id, $size = '' ) {
        $base = get_template_directory_uri() . "/images/dashboard/";
        $type = get_post_mime_type($post_id);
        $img = wp_get_attachment_image_src( $post_id, $size );
        switch ($type) {
            case 'application/pdf':
                return $base . "pdf.png"; break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return $base . "doc.png"; break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                return $base . "ppt.png"; break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return $base . "xls.png"; break;
            case 'application/zip':
                return $base . "zip.png"; break;
            case 'image/png':
            case 'image/jpg':
            case 'image/jpeg':
                return $img[0];  break;
            default:
                return $base . "file.png";
        }
    }
}

if (!function_exists('get_icon_for_attachment_type')) {
    function get_icon_for_attachment_type($file_type, $post_id = '', $size = '' ) {
        $base = get_template_directory_uri() . "/images/dashboard/";

        $img = wp_get_attachment_image_src( $post_id, $size );
        switch ($file_type) {
            case 'application/pdf':
                return $base . "pdf.png"; break;
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                return $base . "doc.png"; break;
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                return $base . "ppt.png"; break;
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                return $base . "xls.png"; break;
            case 'application/zip':
                return $base . "zip.png"; break;
            case 'image/png':
            case 'image/jpg':
            case 'image/jpeg':
                return $img[0];  break;
            default:
                return $base . "file.png";
        }
    }
}



add_action( 'wp_ajax_sign_up', 'sign_up' );
add_action( 'wp_ajax_nopriv_sign_up', 'sign_up' );
if (! function_exists ( 'sign_up' )) {
    function sign_up() {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');
        check_ajax_referer( 'fl_register_secure', 'security' );
        $params = array();
        parse_str($_POST['signup_data'], $params);
        global $exertio_theme_options;
        global $wpdb;
        $base_prefix =$wpdb->base_prefix;
        if( email_exists($params['fl_email']) == false )
        {
            if($wpdb->get_row("SELECT post_name FROM ".$base_prefix."posts WHERE post_name = '" . $params['fl_username'] . "'", 'ARRAY_A'))
            {
                echo '0|' .__( 'Username already exist', 'exertio_framework' );
                die;
            }
            else
            {
                /*its only for registration type*/
                global $wp_session;
                if(isset($params['exertio_user_type']) && $params['exertio_user_type'] == 'employer')
                {
                    $wp_session['loggedInAs'] = 'employer';
                }
                else if(isset($params['exertio_user_type']) && $params['exertio_user_type'] == 'freelancer')
                {
                    $wp_session['loggedInAs'] = 'freelancer';
                }

                $user_args = array(
                    'user_pass'             => $params['fl_password'],
                    'user_nicename'            => sanitize_text_field($params['fl_username']),
                    'user_login'            => sanitize_text_field($params['fl_username']),
                    'display_name' 			=> sanitize_text_field($params['fl_full_name']),
                    'user_email'			=> sanitize_text_field($params['fl_email']),
                );
                $uid =	wp_insert_user($user_args);

                $redirect = $_POST['redirect_id'];
                if(isset($redirect) && $redirect != '')
                {
                    $page = get_the_permalink($redirect);
                }
                else
                {
                    $page = get_the_permalink($exertio_theme_options['user_dashboard_page']);
                }
                if(fl_framework_get_options('fl_allow_user_email_verification') == false)
                {
                    $user = array();
                    $user = new WP_User($uid);
                    foreach ($user->roles as $role) {
                        $user->remove_role($role);
                    }
                    //
                    exertio_account_activation_email($uid);
                    $page = get_the_permalink($exertio_theme_options['registration_page']);
                    echo '1|' . __("A verification link has been sent to your email account.", 'exertio_framework').'|'.$page.'|'.$uid;
                    die;
                }else {
                    fl_auto_login($params['fl_email'], $params['fl_password'], false);
                }

                echo '1|' . __("Registration successfull. Redirecting....", 'exertio_framework')."|".$page."|"."";
                die;
            }

        }
        else
        {
            echo '0|' .__( 'Email already exist, please try other one.', 'exertio_framework' );
            die;
        }
    }
}


add_action( 'wp_ajax_sign_up_resend', 'sign_up_resend' );
add_action( 'wp_ajax_nopriv_sign_up_resend', 'sign_up_resend' );
if (! function_exists ( 'sign_up_resend' )) {
    function sign_up_resend() {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');
        check_ajax_referer( 'fl_register_secure', 'security' );
        $params = array();
        $uid = $_POST['user_id'];
        global $exertio_theme_options;
        if (isset($uid) && $uid!=''){
            exertio_account_activation_email($uid);
            $page = get_the_permalink($exertio_theme_options['registration_page']);
            echo '1|' . __("A verification link has been sent to your email account.", 'exertio_framework') . "|" . $page;
            die();
        }
        else{
            echo '0|' . __("Something Went Wrong,Please Fill Form Again.", 'exertio_framework');
            die();
        }
    }
}


add_action('user_register','exertion_on_registration_funtion');
if (! function_exists ( 'exertion_on_registration_funtion' )) {
    function exertion_on_registration_funtion($uid){

        global $exertio_theme_options;
        $user_info = get_userdata($uid);
        if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both')
        {
            if ( function_exists( 'exertio_register_type_return' ) )
            {
                exertio_register_type_return($uid, 'both');
            }
        }
        else if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both_selected')
        {

            if ( function_exists( 'exertio_register_type_return' ) )
            {
                if(isset($exertio_theme_options['user_registration_type_selection']) && count(array_filter($exertio_theme_options['user_registration_type_selection'])) < 2 )
                {
                    $user_type = $exertio_theme_options['user_registration_type_selection']['0'];
                }
                else
                {
                    global $wp_session;
                    $user_type = $wp_session['loggedInAs'];
                }
                exertio_register_type_return($uid, 'both_selected', $user_type);
            }
        }
        if(fl_framework_get_options('fl_email_onregister') == true)
        {
            fl_framework_new_user_email($uid);
        }
        if ( function_exists( 'exertio_generate_code_registeration' ) )
        {
            exertio_generate_code_registeration($uid);
        }

        update_user_meta( $uid, 'is_phone_verified', 0 );
        update_user_meta( $uid, 'is_payment_verified', 0 );
        //update_user_meta( $uid, 'is_profile_completed', 0 );
        update_user_meta( $uid, 'is_email_verified', 0 );
    }
}
if (! function_exists ( 'exertio_register_type_return' )) {
    function exertio_register_type_return($uid, $user_selection, $user_type='' )
    {
        $user_info = get_userdata($uid);
        global $exertio_theme_options;
        if(isset($user_selection) && $user_selection == 'both')
        {
            $my_post = array(
                'post_title' => sanitize_text_field($user_info->user_login),
                'post_status' => 'publish',
                'post_author' => $uid,
                'post_type' => 'employer'
            );


            $company_id = wp_insert_post($my_post);
            update_post_meta( $company_id, '_employer_dispaly_name', sanitize_text_field($user_info->display_name));
            update_user_meta( $uid, 'employer_id', $company_id );

            update_post_meta( $company_id, '_is_employer_verified', 0);
            update_post_meta( $company_id, '_employer_is_featured', 0);
            update_post_meta( $company_id, 'is_employer_email_verified', 0 );
            update_post_meta( $company_id, 'is_employer_profile_completed', 0 );

            $my_post_2 = array(
                'post_title' => sanitize_text_field($user_info->user_login),
                'post_status' => 'publish',
                'post_author' => $uid,
                'post_type' => 'freelancer'
            );
            $freelancer_id = wp_insert_post($my_post_2);
            update_post_meta( $freelancer_id, '_freelancer_dispaly_name', sanitize_text_field($user_info->display_name));
            update_user_meta( $uid, 'freelancer_id', $freelancer_id );

            update_post_meta( $freelancer_id, '_is_freelancer_verified', 0);
            update_post_meta( $freelancer_id, '_freelancer_is_featured', 0);
            update_post_meta( $freelancer_id, 'is_freelancer_email_verified', 0 );
            update_post_meta( $freelancer_id, 'is_freelancer_profile_completed', 0 );


            if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
            {
                /*ASSIGNING PACKAGES*/
                echo exertio_freelancer_pck_on_registeration($freelancer_id);
                echo exertio_employer_pck_on_registeration($company_id);
            }

            $user_redirection_after_login = $exertio_theme_options['user_redirection_after_login'];
            if(isset($user_redirection_after_login) && $user_redirection_after_login == 'employer')
            {
                update_user_meta($uid, '_active_profile', 1);
                //setcookie('active_profile', 'employer', time() + (86400 * 365), "/");
            }
            else if(isset($user_redirection_after_login) && $user_redirection_after_login == 'freelancer')
            {
                //setcookie('active_profile', 'freelancer', time() + (86400 * 365), "/");
                update_user_meta($uid, '_active_profile', 2);
            }
        }
        else if(isset($user_selection) && $user_selection == 'both_selected')
        {
            global $wp_session;
            if(isset($user_type) && $user_type == 'employer')
            {
                $my_post = array(
                    'post_title' => sanitize_text_field($user_info->user_login),
                    'post_status' => 'publish',
                    'post_author' => $uid,
                    'post_type' => 'employer'
                );

                $company_id = wp_insert_post($my_post);
                update_post_meta( $company_id, '_employer_dispaly_name', sanitize_text_field($user_info->display_name));
                update_user_meta( $uid, 'employer_id', $company_id );

                update_post_meta( $company_id, '_is_employer_verified', 0);
                update_post_meta( $company_id, '_employer_is_featured', 0);
                update_post_meta( $company_id, 'is_employer_email_verified', 0 );
                update_post_meta( $company_id, 'is_employer_profile_completed', 0 );

                if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
                {
                    /*ASSIGNING PACKAGES*/
                    echo exertio_employer_pck_on_registeration($company_id);
                }
                //setcookie('active_profile', 'employer', time() + (86400 * 365), "/");
                update_user_meta($uid, '_active_profile', 1);

                $wp_session['loggedInAs'] = '';
            }
            else if(isset($user_type) && $user_type == 'freelancer')
            {
                $my_post_2 = array(
                    'post_title' => sanitize_text_field($user_info->user_login),
                    'post_status' => 'publish',
                    'post_author' => $uid,
                    'post_type' => 'freelancer'
                );
                $freelancer_id = wp_insert_post($my_post_2);
                update_post_meta( $freelancer_id, '_freelancer_dispaly_name', sanitize_text_field($user_info->display_name));
                update_user_meta( $uid, 'freelancer_id', $freelancer_id );

                update_post_meta( $freelancer_id, '_is_freelancer_verified', 0);
                update_post_meta( $freelancer_id, '_freelancer_is_featured', 0);
                update_post_meta( $freelancer_id, 'is_freelancer_email_verified', 0 );
                update_post_meta( $freelancer_id, 'is_freelancer_profile_completed', 0 );


                if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
                {
                    /*ASSIGNING PACKAGES*/
                    echo exertio_freelancer_pck_on_registeration($freelancer_id);
                }
                //setcookie('active_profile', 'freelancer', time() + (86400 * 365), "/");
                update_user_meta($uid, '_active_profile', 2);
                $wp_session['loggedInAs'] = '';
            }
        }
    }
}

// Ajax handler for Login User
add_action( 'wp_ajax_fl_sign_in', 'fl_sign_in' );
add_action( 'wp_ajax_nopriv_fl_sign_in', 'fl_sign_in' );
if (! function_exists ( 'fl_sign_in' )) {
    function fl_sign_in()
    {
        global $exertio_theme_options;
        //echo get_the_permalink().'/';
        $redirect = $_POST['redirect_id'];
        if(isset($redirect) && $redirect != '')
        {
            $page = get_the_permalink($redirect);
        }
        else
        {
            $page = get_the_permalink($exertio_theme_options['user_dashboard_page']);
        }
        // Getting values
        $params = array();
        parse_str($_POST['signin_data'], $params);
        $remember = false;

        if( isset($params['is_remember']) )
        {
            $remember = true;
        }

        $user  = wp_authenticate( $params['fl_email'], $params['fl_password'] );
        if( !is_wp_error($user) )
        {
            if( count((array) $user->roles ) == 0 )
            {
                echo '0|'. __( 'Your account is not verified yet.', 'exertio_framework' );
                die();
            }
            else
            {
                $uid = fl_auto_login($params['fl_email'], $params['fl_password'], $remember );
                if($uid)
                {
                    $user_redirection_after_login = $exertio_theme_options['user_redirection_after_login'];
                    exertio_active_cookie_profile($uid,$user_redirection_after_login);
                    echo "1|". __( 'Login successful. Redirecting....', 'exertio_framework' )."|".$page;
                }
            }
        }
        else
        {
            echo '0|'.__( 'Invalid email or password.', 'exertio_framework' );
        }
        die();
    }
}


if (! function_exists ( 'fl_auto_login' )) {
    function fl_auto_login($username, $password, $remember )
    {
        $creds = array();
        $creds['user_login'] = $username;
        $creds['user_password'] = $password;
        $creds['remember'] = $remember;
        $user = wp_signon( $creds, false );

        if ( is_wp_error($user) )
        {
            return false;
        }
        else
        {
            $user_id = $user->data->ID;
            return $user_id;
        }
    }
}
if (!function_exists('exertio_active_cookie_profile'))
{
    function exertio_active_cookie_profile($uid, $user_redirection_after_login = 'employer')
    {
        //$uid = get_current_user_id();

        global $exertio_theme_options;
        if(isset($exertio_theme_options['user_registration_type']) && $exertio_theme_options['user_registration_type'] == 'both')
        {
            if(isset($user_redirection_after_login) && $user_redirection_after_login == 'employer')
            {
                //setcookie('active_profile', 'employer', time() + (86400 * 365), "/");
                update_user_meta($uid, '_active_profile', 1);
            }
            else if(isset($user_redirection_after_login) && $user_redirection_after_login == 'freelancer')
            {
                //setcookie('active_profile', 'freelancer', time() + (86400 * 365), "/");
                update_user_meta($uid, '_active_profile', 2);
            }
        }
        else
        {
            //echo 'here';
            //exit;
            //$dashboard_page = fl_framework_get_options('user_dashboard_page');
            //$current_user_id = get_current_user_id();
            //echo $current_user_id ;
            //exit;
            $emp_id = get_user_meta( $uid, 'employer_id' , true );
            $fre_id = get_user_meta( $uid, 'freelancer_id' , true );
            //echo $emp_id.'/ emp ******';
            //echo $fre_id.'/ free /';
            //exit;
            if($emp_id != '' )
            {
                update_user_meta($uid, '_active_profile', 1);
                //echo '/emp/';
                //setcookie('active_profile', 'employer', time() + (86400 * 365), "/");
                //echo get_the_permalink($dashboard_page);
                //exit;
                //wp_redirect(get_the_permalink($dashboard_page));
            }
            if($fre_id != '' )
            {
                update_user_meta($uid, '_active_profile', 2);
                //echo '/free/';
                //setcookie('active_profile', 'freelancer', time() + (86400 * 365), "/");
                //echo get_the_permalink($dashboard_page);
                //exit;
                //wp_redirect(get_the_permalink($dashboard_page));
            }
            //exit;
        }
    }
}
// Ajax handler for Forgot Password
add_action( 'wp_ajax_fl_forget_pwd', 'fl_forget_pwd' );
add_action( 'wp_ajax_nopriv_fl_forget_pwd', 'fl_forget_pwd' );
if (!function_exists ( 'fl_forget_pwd' ))
{
    function fl_forget_pwd()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_forget_pwd_secure', 'security' );
        $params = array();
        parse_str($_POST['forget_pwd_data'], $params);

        $email = trim(sanitize_email($params['fl_forget_email']));
        if(empty($email))
        {
            $return = array('message' => esc_html__( 'Please type your e-mail address.', 'exertio_framework' ));
            wp_send_json_error($return);
        }
        else if ( !is_email( $email ) )
        {
            $return = array('message' => esc_html__( 'Please enter a valid e-mail address.', 'exertio_framework' ));
            wp_send_json_error($return);
        }
        else if(!email_exists($email)) {
            $return = array('message' => esc_html__( 'This email address does not exist on website.', 'exertio_framework' ));
            wp_send_json_error($return);
        }
        else
        {
            $user = get_user_by('email', $email);
            $user_email = $user->user_login;
            $reset_key = get_password_reset_key($user);
            $signinlink = get_the_permalink(fl_framework_get_options('login_page'));
            update_user_meta( $user->ID, '_reset_password_key', $reset_key );

            $reset_link = esc_url($signinlink.'?action=rp&key='.$reset_key.'&login='.rawurlencode($user_email));


            fl_forgotpass_email($user->ID,$reset_link);
            $return = array('message' => esc_html__( 'Check your email for the confirmation link.', 'exertio_framework' ));
            wp_send_json_success($return);
            die();
        }
    }
}
// Ajax handler for Reset New Password
add_action( 'wp_ajax_fl_forgot_pass_new', 'fl_forgot_pass_new' );
add_action( 'wp_ajax_nopriv_fl_forgot_pass_new', 'fl_forgot_pass_new' );
if (!function_exists ( 'fl_forgot_pass_new' ))
{
    function fl_forgot_pass_new()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_forget_new_psw_secure', 'security' );
        $params = array();
        parse_str($_POST['forget_pwd_data'], $params);

        if(!empty($params['requested_user_id']))
        {
            $user_id = $params['requested_user_id'];
            $stored_reset_key = get_user_meta( $user_id, '_reset_password_key' , true );

            $reset_key = $params['reset_key'];
            if($stored_reset_key == $reset_key)
            {
                $password = trim(sanitize_text_field( $params['password'] ));
                if(empty($password)){
                    $return = array('message' => esc_html__( 'Please choose a password with at least 3-12 characters.', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
                wp_set_password($password, $user_id);
                update_user_meta( $user_id, '_reset_password_key', '' );
                $signinlink = get_the_permalink(fl_framework_get_options('login_page'));
                $return = array('message' => esc_html__( 'Your password has been changed. You can now log in with your new password.', 'exertio_framework'), 'page_link' => $signinlink);
                wp_send_json_success($return);
            }
            else
            {
                $return = array('message' => esc_html__( 'You are not allowed to do that', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }
        else
        {
            $return = array('message' => esc_html__( 'User id does not exist. Please contact admin.', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}


/* EMPLOYER PROFILE PICTURE UPLOAD */
add_action('wp_ajax_emp_profile_pic', 'freelance_emp_profile_pic');

if ( ! function_exists( 'freelance_emp_profile_pic' ) )
{
    function freelance_emp_profile_pic()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');

        global $exertio_theme_options;
        $pid = $_POST['post-id'];

        $post_meta = $_POST['post-meta'];
        $field_name =  $_FILES[$_POST['field-name']];
        /* img upload */
        $condition_img=7;
        $img_count = count((array) explode( ',',$_POST["image_gallery"] ));

        if(!empty($field_name))
        {

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';


            $files = $field_name;

            $attachment_ids=array();
            $attachment_idss='';

            if($img_count>=1)
            {
                $imgcount=$img_count;
            }
            else
            {
                $imgcount=1;
            }
            $ul_con='';
            foreach ($files['name'] as $key => $value)
            {
                if ($files['name'][$key])
                {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array ("emp_profile_picture" => $file);

                    // Allow certain file formats
                    $imageFileType	=	end( explode('.', $file['name'] ) );
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG")
                    {
                        echo '0|' . esc_html__( "Sorry, only JPG, JPEG, PNG files are allowed.", 'exertio_framework' );
                        die();
                    }

                    // Check file size
                    $image_size = $exertio_theme_options['user_attachment_size'];
                    if ($file['size']/1000 > $image_size) {
                        echo '0|' . esc_html__( "Max allowd image size is ".$image_size." KB", 'exertio_framework' );
                        die();
                    }

                    foreach ($_FILES as $file => $array)
                    {

                        if($imgcount>=$condition_img){ break; }
                        $attach_id = media_handle_upload( $file, $pid );
                        $attachment_ids[] = $attach_id;

                        $image_link = wp_get_attachment_image_src( $attach_id, 'thumbnail' );

                    }
                    if($imgcount>$condition_img){ break; }
                    $imgcount++;
                }
            }
        }
        /*img upload */
        $attachment_idss = array_filter( $attachment_ids  );
        $attachment_idss =  implode( ',', $attachment_idss );


        $arr = array();
        $arr['attachment_idss'] = $attachment_idss;
        $arr['ul_con'] =$ul_con;


        //update_user_meta($uid, '_profile_pic_attachment_id', $attach_id );
        update_post_meta( $pid, $post_meta, $attach_id);
        echo '1|'.esc_html__( "Image changed Successfully", 'exertio_framework' ).'|' . $image_link[0].'|'.$attach_id;
        die();

    }
}

add_action('wp_ajax_fl_delete_image', 'fl_delete_image');

if ( ! function_exists( 'fl_delete_image' ) )
{
    function fl_delete_image()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');

        $pid = $_POST['post_id'];
        $attachment_id = $_POST['attachment_id'];
        $post_meta = $_POST['post_meta'];

        if($pid != "" && $post_meta != "")
        {
            update_post_meta( $pid, $post_meta, '');
            wp_delete_attachment( $attachment_id, true );
            echo '1|'.esc_html__( "Image Removed", 'exertio_framework' );
        }
        else
        {
            echo '0|'.esc_html__( "Something went wrong!!!", 'exertio_framework' );
        }
        die();
    }
}

/*SAVE EMPLOYER PROFILE*/
add_action( 'wp_ajax_employer_profile', 'fl_employer_profile' );
function fl_employer_profile() {
    /*DEMO DISABLED*/
    exertio_demo_disable('echo');

    check_ajax_referer( 'fl_save_pro_secure', 'security' );
    $uid = get_current_user_id();
    $post_id = $_POST['post_id'];
    $params = array();
    parse_str($_POST['emp_data'], $params);
    global $exertio_theme_options;

    $post_author = get_post_field( 'post_author', $post_id );
    if( $post_author == $uid )
    {
        $new_slug =  preg_replace('/\s+/', '', $params['emp_name']);


        $words = explode(',', $exertio_theme_options['bad_words_filter']);
        $replace = $exertio_theme_options['bad_words_replace'];
        $desc = fl_badwords_filter($words, $params['emp_desc'], $replace);
        $my_post = array(
            'ID' => $post_id,
            'post_title' => sanitize_text_field($params['emp_name']),
            'post_name' => sanitize_text_field($new_slug),
            'post_content' => wp_kses_post($desc),
            'post_type' => 'employer'
        );

        $result = wp_update_post($my_post, true);

        if (is_wp_error($result)){
            echo '0|' .__( 'Data is not saved', 'exertio_framework' );
            wp_die();
        }


        if(isset($params['employer_employees']))
        {
            $employer_employees_terms = array((int)$params['employer_employees']);
            update_post_meta( $post_id, '_employer_employees', sanitize_text_field($params['employer_employees']));
            wp_set_post_terms( $post_id, $employer_employees_terms, 'employees-number', false );
        }
        if(isset($params['employer_location']))
        {
            update_post_meta( $post_id, '_employer_location', sanitize_text_field($params['employer_location']));
            set_hierarchical_terms('employer-locations', $params['employer_location'], $post_id);

        }
        if(isset($params['employer_department']))
        {
            $department_terms = array((int)$params['employer_department']);
            update_post_meta( $post_id, '_employer_department', sanitize_text_field($params['employer_department']));
            wp_set_post_terms( $post_id, $department_terms, 'departments', false );
            update_post_meta($post_id, 'cf_employer_departments', $params['employer_department']);
        }
        //saving custom fields
        if (isset($params['acf']) && $params['acf'] != '' && class_exists('ACF'))
        {
            exertio_framework_acf_clear_object_cache($post_id);
            acf_update_values($params['acf'], $post_id);

        }
        if(isset($params['emp_tagline']))
        {
            update_post_meta( $post_id, '_employer_tagline', sanitize_text_field($params['emp_tagline']));

        }
        if(isset($params['emp_display_name']))
        {
            update_post_meta( $post_id, '_employer_dispaly_name', sanitize_text_field($params['emp_display_name']));

        }
        if(isset($params['emp_contact']))
        {
            update_post_meta( $post_id, '_employer_contact_number', sanitize_text_field($params['emp_contact']));

        }

        if(isset($params['emp_address']))
        {
            update_post_meta( $post_id, '_employer_address', sanitize_text_field($params['emp_address']));

        }
        if(isset($params['emp_lat']))
        {
            update_post_meta( $post_id, '_employer_latitude', sanitize_text_field($params['emp_lat']));

        }
        if(isset($params['emp_long']))
        {
            update_post_meta( $post_id, '_employer_longitude', sanitize_text_field($params['emp_long']));

        }
        if(isset($params['facebook_url']))
        {
            update_post_meta( $post_id, '_employer_facebook_url', sanitize_text_field($params['facebook_url']));

        }
        if(isset($params['twitter_url']))
        {
            update_post_meta( $post_id, '_employer_twitter_url', sanitize_text_field($params['twitter_url']));

        }
        if(isset($params['linkedin_url']))
        {
            update_post_meta( $post_id, '_employer_linkedin_url', sanitize_text_field($params['linkedin_url']));

        }
        if(isset($params['instagram_url']))
        {
            update_post_meta( $post_id, '_employer_instagram_url', sanitize_text_field($params['instagram_url']));

        }
        if(isset($params['dribble_url']))
        {
            update_post_meta( $post_id, '_employer_dribble_url', sanitize_text_field($params['dribble_url']));

        }
        if(isset($params['behance_url']))
        {
            update_post_meta( $post_id, '_employer_behance_url', sanitize_text_field($params['behance_url']));

        }


        echo '1|' . __("Profile updated", 'exertio_framework');
        die;

    }
    else
    {
        echo '0|' .__( 'You are not allowed to do that', 'exertio_framework' );
        die;
    }
}

/* CHANGE PASSWORD */

add_action('wp_ajax_fl_change_password', 'fl_change_password');

if ( ! function_exists( 'fl_change_password' ) )
{
    function fl_change_password()
    {
        exertio_demo_disable('echo');
        check_ajax_referer( 'fl_change_psw_secure', 'security' );
        global $exertio_theme_options;
        fl_authenticate_check();
        $params = array();
        parse_str($_POST['pass_data'], $params);


        $current_pass	=	$params['old_password'];
        $new_pass	=	sanitize_text_field( $params['new_password'] );
        $con_new_pass	=	sanitize_text_field( $params['confirm_password']);
        if( $current_pass == "" || $new_pass == "" || $con_new_pass == "" )
        {
            echo '0|' . esc_html__( "All fields are required.", 'exertio_framework' );
            die();
        }
        if( $new_pass == $current_pass )
        {
            echo '0|' . esc_html__( "Sorry, you can not set the same password again", 'exertio_framework' );
            die();
        }
        if( $new_pass != $con_new_pass )
        {
            echo '0|' . esc_html__( "New password Mismatched", 'exertio_framework' );
            die();
        }
        $user = get_user_by( 'ID', get_current_user_id() );
        if( $user && wp_check_password( $current_pass, $user->data->user_pass, $user->ID) )
        {
            wp_set_password( $new_pass, $user->ID );
            $page = get_home_url();
            echo '1|' . esc_html__( "Password changed successfully.", 'exertio_framework' ).'|'.$page;
        }
        else
        {
            echo '0|' . esc_html__( "Wrong current password", 'exertio_framework' );
        }

        die();
    }
}


/*DELETE USER ACCOUNT*/
// Delete user
add_action('wp_ajax_fl_delete_account', 'fl_delete_my_account');
if ( ! function_exists( 'fl_delete_my_account' ) )
{
    function fl_delete_my_account()
    {
        exertio_demo_disable('echo');

        check_ajax_referer( 'fl_delete_pro_secure', 'security' );
        fl_authenticate_check();
        if(is_super_admin())
        {
            echo '0|' . __( "Admin can not delete his account.", 'exertio_framework' );
            die();
        }
        else
        {
            $user_id		= get_current_user_id();
            // delete comment with that user id
            $c_args = array ('user_id' => $user_id,'post_type' => 'any','status' => 'all');
            $comments = get_comments($c_args);
            if(count((array) $comments) > 0 )
            {
                foreach($comments as $comment) :
                    wp_delete_comment($comment->comment_ID, true);
                endforeach;
            }
            // delete user posts
            $args = array ('numberposts' => -1,'post_type' => 'any','author' => $user_id);
            $user_posts = get_posts($args);
            // delete all the user posts
            if(count((array) $user_posts) > 0 )
            {
                foreach ($user_posts as $user_post) {
                    wp_delete_post($user_post->ID, true);
                }
            }
            //now delete actual user
            wp_delete_user($user_id);
            echo '1|' . __( "Account deleted successfully", 'exertio_framework' ).'|'.get_home_url();
            die();
        }
    }
}



/* PROJECT ATTACHMENTS UPLOAD */

add_action('wp_ajax_project_attachments', 'freelance_project_attachments');

if ( ! function_exists( 'freelance_project_attachments' ) )
{
    function freelance_project_attachments()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');

        global $exertio_theme_options;
        $pid = $_POST['post-id'];
        $field_name =  $_FILES['project_attachments'];
        $condition_img=7;
        $attachment_size = '2000';
        $img_count = count(array_count_values($field_name['name']));

        if(isset($exertio_theme_options['project_attachment_count']))
        {
            $condition_img= $exertio_theme_options['project_attachment_count'];
        }

        if(isset($exertio_theme_options['project_attachment_size']))
        {
            $attachment_size= $exertio_theme_options['project_attachment_size'];
        }

        if(!empty($field_name))
        {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $files = $field_name;

            $files_array = array();
            foreach ($files['name'] as $key => $value)
            {
                if ($files['name'][$key])
                {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array ("emp_profile_picture" => $file);

                    foreach ($_FILES as $file => $array)
                    {
                        $exist_data = get_post_meta( $pid, '_project_attachment_ids', true );

                        $is_upload_file = true;
                        $imageFileType	=	end( explode('.', $array['name'] ) );
                        if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "pptx" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "ppt" && $imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "svg")
                        {
                            $is_upload_file = false;
                            $attach_id = 0;
                            $message =  esc_html__( "Sorry, only JPG, JPEG, PNG, docx, pptx, xlsx, SVG and pdf files are allowed.", 'exertio_framework' );

                        }
                        else
                        {

                            $exist_data_count ='';
                            if(isset($exist_data) && $exist_data != '')
                            {
                                $exist_data_count = count(explode(",",$exist_data));
                            }

                            $is_upload_file = true;
                            if($exist_data_count >= $condition_img)
                            {
                                $message = esc_html__( "Attachment upload limit reached", 'exertio_framework' );
                                $is_upload_file = false;
                                $attach_id = 0;
                            }

                            if($is_upload_file)
                            {
                                $is_upload_file = true;
                                if ($array['size']/1000 > $attachment_size) {
                                    $is_upload_file = false;
                                    $attach_id = 0;
                                    $message = esc_html__( 'Max allowed attachment size is '.$attachment_size.' Kb', 'exertio_framework' );

                                }

                                if($is_upload_file){

                                    $attach_id = media_handle_upload( $file, $pid );

                                    if( is_wp_error($attach_id ))
                                    {
                                        $is_upload_file = false;
                                        $message = $attach_id->get_error_message();
                                        $attach_id = 0;
                                    }
                                    else
                                    {
                                        if(isset($exist_data) && $exist_data != '')
                                        {
                                            $attach_id_store = $exist_data.','.$attach_id;
                                        }
                                        else
                                        {
                                            $attach_id_store = $attach_id;
                                        }
                                        update_post_meta( $pid, '_project_attachment_ids', $attach_id_store);
                                        $message = esc_html__( "File Uploaded", 'exertio_framework' );
                                    }
                                }
                            }

                        }

                        $icon = get_icon_for_attachment_type($array['type'], $attach_id);

                        $files_array[] = array(
                            'name' => $array['name'],
                            'icon' => $icon,
                            'file-size' => $array['size'],
                            'message' => $message,
                            'data-id' => $attach_id,
                            'data-pid' => $pid,
                            'is-error' => (isset($is_upload_file) && $is_upload_file == true) ? '':'upload-error',
                        );
                    }
                }
            }
        }
        $close_icon = $data = '';
        foreach($files_array as $arr){
            $close_icon = (isset($arr['is-error']) && $arr['is-error'] == '') ? '<i class="far fa-times-circle"></i>':'';
            $data .=  '<div class="attachments ui-state-default pro-atta-'.$arr['data-id'].' '.$arr['is-error'].'"> <img src="'.$arr['icon'].'" alt="'.get_post_meta($arr['data-id'], '_wp_attachment_image_alt', TRUE).'" data-img-id="'.$arr['data-id'].'"><span class="attachment-data"> <h4>'.$arr['name']. '<small class="'.$arr['is-error'].'">  - '. $arr['message'] .'</small> </h4> <p>'.esc_html__( "file size:", 'exertio_framework' ).'  '.$arr['file-size'].esc_html__( " Kb", 'exertio_framework' ).' </p> <a href="javascript:void(0)" class="btn-pro-clsoe-icon" data-id="'.$arr['data-id'].'" data-pid="'.$arr['data-pid'].'">'.$close_icon.'</a> </span></div>';
        }

        echo '1|'.esc_html__( "Attachments uploaded", 'exertio_framework' ).'|' .$data.'|'.$attach_id_store;
        die();
    }
}


/* PROJECT ATTACHMENTS DELETE */

add_action('wp_ajax_delete_project_attachment', 'fl_delete_project_attachment');

if ( ! function_exists( 'fl_delete_project_attachment' ) )
{
    function fl_delete_project_attachment()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        $attachment_id = $_POST['attach_id'];
        $pid = $_POST['pid'];

        if($attachment_id !='' && $pid != '')
        {
            $exist_data = get_post_meta( $pid, '_project_attachment_ids', true );

            $array1 = array($attachment_id);
            $array2 = explode(',', $exist_data);
            $array3 = array_diff($array2, $array1);
            wp_delete_attachment($attachment_id);
            $new_data = implode(',', $array3);
            update_post_meta( $pid, '_project_attachment_ids', $new_data);
            $return = array('message' => esc_html__( 'Attachment deleted', 'exertio_framework' ), 'newData' => $new_data);
            wp_send_json_success($return);

        }
        else
        {
            $return = array('message' => esc_html__( 'Error!!! attachment is not deleted', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}




add_action( 'wp_ajax_create_project', 'fl_create_project' );
if ( ! function_exists( 'fl_create_project' ) )
{
    function fl_create_project()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_create_project_secure', 'security' );
        $current_user_id = get_current_user_id();
        global $exertio_theme_options;

        /*CHECK IF EMIL IS VERIFIED*/
        if(isset($exertio_theme_options['projects_with_email_verified']) &&  $exertio_theme_options['projects_with_email_verified'] == 0)
        {
            $is_verified = get_user_meta( $current_user_id, 'is_email_verified', true );
            if($is_verified != 1 || $is_verified == '')
            {
                $return = array('message' => esc_html__( 'Please verifiy your email first', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }

        $employer_id = get_user_meta( $current_user_id, 'employer_id' , true );

        $post_id = $_POST['post_id'];
        $project_status = get_post_status ( $post_id );
        $params = array();
        parse_str($_POST['project_data'], $params);


        if($params['is_update'] != '')
        {
            if($project_status == 'publish')
            {
                $status = 'publish';
                if(isset($exertio_theme_options['update_project_approval']) &&  $exertio_theme_options['update_project_approval'] == 0)
                {
                    $status = 'pending';
                }
            }
            else
            {
                $status = 'pending';
            }
        }
        else
        {

            if(isset($exertio_theme_options['project_approval']) &&  $exertio_theme_options['project_approval'] == 0)
            {
                $status = 'pending';
            }
            else
            {
                $status = 'publish';
            }
        }

        $words = explode(',', $exertio_theme_options['bad_words_filter']);
        $replace = $exertio_theme_options['bad_words_replace'];
        $project_name = fl_badwords_filter($words, $params['project_name'], $replace);
        $desc = fl_badwords_filter($words, $params['project_desc'], $replace);


        $my_post = array(
            'ID' => $post_id,
            'post_title' => sanitize_text_field($project_name),
            'post_content' => wp_kses_post($desc),
            'post_type' => 'projects',
            'post_author' => $current_user_id,
            'post_status'   => $status,
        );

        $result = wp_update_post($my_post, true);


        if (is_wp_error($result))
        {
            $return = array('message' => esc_html__( 'Error!!! Please contact admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }


        if(isset($params['project_level']))
        {
            $project_level_terms = array((int)$params['project_level']);
            update_post_meta( $post_id, '_project_level', sanitize_text_field($params['project_level']));
            wp_set_post_terms( $post_id, $project_level_terms, 'project-level', false );
        }
        if(isset($params['project_duration']))
        {
            $duration_terms = array((int)$params['project_duration']);
            update_post_meta( $post_id, '_project_duration', sanitize_text_field($params['project_duration']));
            wp_set_post_terms( $post_id, $duration_terms, 'project-duration', false );
        }
        if(isset($params['project_type']))
        {
            update_post_meta( $post_id, '_project_type', sanitize_text_field($params['project_type']));
        }
        if($params['project_type'] == 'fixed' || $params['project_type'] == 1)
        {
            if(isset($params['project_cost']))
            {
                update_post_meta( $post_id, '_project_cost', sanitize_text_field($params['project_cost']));

            }
        }
        else if($params['project_type'] == 'hourly' || $params['project_type'] == 2)
        {
            if(isset($params['project_cost_hourly']) && isset($params['estimated_hours']))
            {
                update_post_meta( $post_id, '_project_cost', sanitize_text_field($params['project_cost_hourly']));
                update_post_meta( $post_id, '_estimated_hours', sanitize_text_field($params['estimated_hours']));
            }
        }


        if(isset($params['freelancer_typel']))
        {
            $type_terms = array((int)$params['freelancer_typel']);
            update_post_meta( $post_id, '_project_freelancer_type', sanitize_text_field($params['freelancer_typel']));
            wp_set_post_terms( $post_id, $type_terms, 'freelancer-type', false );
        }
        if(isset($params['english_level']))
        {
            $type_terms = array((int)$params['english_level']);
            update_post_meta( $post_id, '_project_eng_level', sanitize_text_field($params['english_level']));
            wp_set_post_terms( $post_id, $type_terms, 'english-level', false );
        }
        if(isset($params['project_skills']))
        {
            $integerIDs = array_map('intval', $params['project_skills']);
            $integerIDs = array_unique($integerIDs);
            wp_set_post_terms( $post_id, $integerIDs, 'skills' );
        }
        if(isset($params['project_languages']))
        {
            $integerIDs = array_map('intval', $params['project_languages']);
            $integerIDs = array_unique($integerIDs);
            wp_set_post_terms( $post_id, $integerIDs, 'languages' );
        }
        if(isset($params['project_location_remote']))
        {
            update_post_meta( $post_id, '_project_location_remote', 1);
        }
        else
        {
            update_post_meta( $post_id, '_project_location_remote', 0);
            if(isset($params['project_location']))
            {
                update_post_meta( $post_id, '_project_location', sanitize_text_field($params['project_location']));
                set_hierarchical_terms('locations', $params['project_location'], $post_id);
            }
        }
        if(isset($params['project_category']))
        {
            update_post_meta( $post_id, '_project_category', sanitize_text_field($params['project_category']));
            set_hierarchical_terms('project-categories', $params['project_category'], $post_id);
            update_post_meta($post_id, 'cf_project_cats', $params['project_category']);
        }
        if(isset($params['project_address']))
        {
            update_post_meta( $post_id, '_project_address', sanitize_text_field($params['project_address']));
        }
        if(isset($params['project_lat']))
        {
            update_post_meta( $post_id, '_project_latitude', sanitize_text_field($params['project_lat']));
        }
        if(isset($params['project_long']))
        {
            update_post_meta( $post_id, '_project_longitude', sanitize_text_field($params['project_long']));
        }
        if(isset($params['is_show_project_attachments']) && $params['is_show_project_attachments'] == 'yes')
        {
            update_post_meta( $post_id, '_project_attachment_show', 'yes');
        }
        else
        {
            update_post_meta( $post_id, '_project_attachment_show', 'no');
        }
        update_user_meta( $current_user_id, '_processing_post_id', '' );
        update_post_meta( $post_id, '_project_status', 'active');
        /*ATTACHMENT UPDATED*/
        update_post_meta( $post_id, '_project_attachment_ids', $params['project_attachment_ids']);


        $selected_reference = '';
        if(isset($post_id) && $post_id !="")
        {
            $selected_reference = fl_framework_get_options('fl_project_id');
            if(isset($selected_reference) && $selected_reference !="")
            {
                $updated_id = preg_replace( '/{ID}/', $post_id, $selected_reference );
                update_post_meta($post_id, '_project_ref_id', sanitize_text_field($updated_id));
            }
            else
            {
                update_post_meta($post_id, '_project_ref_id', $post_id);
            }
        }

        $c_dATE = DATE("d-m-Y");
        if($params['is_update'] == '')
        {
            $is_prjects_paid = fl_framework_get_options('is_projects_paid');
            if(isset($is_prjects_paid) && $is_prjects_paid == 1)
            {
                $simple_projects = get_post_meta($employer_id, '_simple_projects', true);
                if(isset($simple_projects) && $simple_projects != -1)
                {
                    if($simple_projects != -1)
                    {
                        $new_simple_project = $simple_projects - 1;
                        update_post_meta($employer_id, '_simple_projects', $new_simple_project);
                    }
                }
                $simple_project_expiry_days = get_post_meta($employer_id, '_simple_project_expiry', true);
                if($simple_project_expiry_days == -1)
                {
                    update_post_meta($post_id, '_simple_projects_expiry_date', -1);
                }
                else
                {
                    if($simple_project_expiry_days != '' && $simple_project_expiry_days > 0 )
                    {
                        $simple_project_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $simple_project_expiry_days days"));

                        update_post_meta($post_id, '_simple_projects_expiry_date', $simple_project_expiry_date);
                    }
                    else if($simple_project_expiry_days == '')
                    {
                        $default_project_expiry = fl_framework_get_options('project_default_expiry');
                        $simple_project_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_project_expiry days"));
                        update_post_meta($post_id, '_simple_projects_expiry_date', $simple_project_expiry_date);
                    }
                }
            }
            else if(isset($is_prjects_paid) && $is_prjects_paid == 0)
            {
                $default_project_expiry = fl_framework_get_options('project_default_expiry');
                $simple_project_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_project_expiry days"));
                update_post_meta($post_id, '_simple_projects_expiry_date', $simple_project_expiry_date);
            }

        }
        $is_featured_projects = get_post_meta($post_id, '_project_is_featured', true);
        if($is_featured_projects == 1)
        {

        }
        else
        {
            if(isset($params['project_featured']))
            {
                $featured_projects = get_post_meta($employer_id, '_featured_projects', true);
                if($featured_projects == -1)
                {
                    update_post_meta( $post_id, '_project_is_featured', 1);
                }
                else if($featured_projects > 0 && $featured_projects != '')
                {

                    $new_featured_project = $featured_projects - 1;
                    update_post_meta($employer_id, '_featured_projects', $new_featured_project);
                    update_post_meta( $post_id, '_project_is_featured', 1);
                }

                $featured_project_expiry_days = get_post_meta($employer_id, '_featured_project_expiry', true);
                if($featured_project_expiry_days == -1)
                {
                    update_post_meta($post_id, '_featured_project_expiry_date', '-1');
                }
                else
                {
                    if($featured_project_expiry_days > 0 && $featured_project_expiry_days != '')
                    {
                        $featured_project_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $featured_project_expiry_days days"));
                        update_post_meta($post_id, '_featured_project_expiry_date', $featured_project_expiry_date);
                    }
                    else if($featured_project_expiry_days == '')
                    {
                        $default_featured_project_expiry = fl_framework_get_options('default_featured_project_expiry');
                        $featured_project_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_featured_project_expiry days"));
                        update_post_meta($post_id, '_featured_project_expiry_date', $featured_project_expiry_date);
                    }
                }
            }
            else
            {
                update_post_meta( $post_id, '_project_is_featured', 0);
            }
        }

        //saving custom fields
        if (isset($params['acf']) && $params['acf'] != '' && class_exists('ACF'))
        {
            exertio_framework_acf_clear_object_cache($post_id);
            acf_update_values($params['acf'], $post_id);

        }
        $page_link = get_the_permalink($exertio_theme_options['user_dashboard_page'])."?ext=create-project&pid=".$post_id;
        $return = array('message' => esc_html__( 'Project posted successfully', 'exertio_framework' ),'pid' => $page_link);
        wp_send_json_success($return);
        die;
    }
}


function fl_pagination($wp_query) {

    if( is_singular() )
        //return;

        //global $wp_query;

        /** Stop execution if there's only 1 page */
        if( $wp_query->max_num_pages <= 1 )
            return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="fl-navigation"><ul>' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link('<i class="far fa-chevron-left"></i>') );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";
        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link('<i class="far fa-chevron-right"></i>', $wp_query->max_num_pages) );

    echo '</ul></div>' . "\n";

}

/* EMPLOYER PROFILE PICTURE UPLOAD */
add_action('wp_ajax_upload_img_return_id', 'freelance_upload_img_return_id');

if ( ! function_exists( 'freelance_upload_img_return_id' ) )
{
    function freelance_upload_img_return_id()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');

        $pid = $_POST['post-id'];

        //$field_name = $_POST['field-name'];
        $field_name =  $_FILES[$_POST['field-name']];
        /* img upload */

        if(!empty($field_name))
        {

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';


            $files = $field_name;

            $attachment_ids=array();
            $attachment_idss='';

            if($img_count>=1)
            {
                $imgcount=$img_count;
            }
            else
            {
                $imgcount=1;
            }
            $ul_con='';
            foreach ($files['name'] as $key => $value)
            {
                if ($files['name'][$key])
                {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array ("upload_img_return_id" => $file);


                    // Allow certain file formats
                    $imageFileType	=	end( explode('.', $file['name'] ) );
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG")
                    {
                        echo '0|' . esc_html__( "Sorry, only JPG, JPEG, PNG files are allowed.", 'exertio_framework' );
                        die();
                    }

                    // Check file size
                    if ($file['size'] > 1300000) {
                        echo '0|' . esc_html__( "Max allowd image size is 300KB", 'exertio_framework' );
                        die();
                    }

                    foreach ($_FILES as $file => $array)
                    {

                        $attach_id = media_handle_upload( $file, $pid );
                        $attachment_ids[] = $attach_id;

                        $image_link = wp_get_attachment_image_src( $attach_id, 'thumbnail' );

                    }
                }
            }
        }
        /*img upload */
        $attachment_idss = array_filter( $attachment_ids  );
        $attachment_idss =  implode( ',', $attachment_idss );


        $arr = array();
        $arr['attachment_idss'] = $attachment_idss;
        $arr['ul_con'] =$ul_con;

        echo '1|'.esc_html__( "Image uploaded", 'exertio_framework' ).'|' . $image_link[0].'|'.$attach_id;
        die();

    }
}


/* FREELANCER PROFILE SAVE */
add_action( 'wp_ajax_fl_profile_save', 'fl_profile_save' );
if ( ! function_exists( 'fl_profile_save' ) )
{
    function fl_profile_save()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');
        global $exertio_theme_options;
        check_ajax_referer( 'fl_save_pro_secure', 'security' );
        $uid = get_current_user_id();
        $post_id = $_POST['post_id'];
        $params = array();

        parse_str($_POST['fl_data'], $params);

        $new_slug =  preg_replace('/\s+/', '', $params['fl_username']);


        $words = explode(',', $exertio_theme_options['bad_words_filter']);
        $replace = $exertio_theme_options['bad_words_replace'];
        $desc = fl_badwords_filter($words, $params['fl_desc'], $replace);


        global $exertio_theme_options;
        $my_post = array(
            'ID' => $post_id,
            'post_title' => sanitize_text_field($params['fl_username']),
            'post_name' => sanitize_text_field($new_slug),
            'post_content' => wp_kses($desc, exertio_allowed_html_tags()),
            'post_type' => 'freelancer'
        );

        $result = wp_update_post($my_post, true);
        if (is_wp_error($result))
        {
            $return = array('message' => esc_html__( 'Profile not saved. Please contact admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }
        if(isset($params['freelancer_tagline']))
        {
            update_post_meta( $post_id, '_freelancer_tagline', sanitize_text_field($params['freelancer_tagline']));
        }
        if(isset($params['freelancer_hourly_rate']))
        {
            update_post_meta( $post_id, '_freelancer_hourly_rate', sanitize_text_field($params['freelancer_hourly_rate']));
        }

        if(isset($params['freelancer_dispaly_name']))
        {
            update_post_meta( $post_id, '_freelancer_dispaly_name', sanitize_text_field($params['freelancer_dispaly_name']));
        }

        if(isset($params['freelancer_contact_number']))
        {
            update_post_meta( $post_id, '_freelancer_contact_number', sanitize_text_field($params['freelancer_contact_number']));
        }
        if(isset($params['freelancer_gender']))
        {
            update_post_meta( $post_id, '_freelancer_gender', sanitize_text_field($params['freelancer_gender']));
        }

        if(isset($params['freelance_type']))
        {
            $company_employees_terms = array((int)$params['freelance_type']);

            update_post_meta( $post_id, '_freelance_type', sanitize_text_field($params['freelance_type']));
            wp_set_post_terms( $post_id, $company_employees_terms, 'freelance-type', false );
        }

        if(isset($params['english_level']))
        {
            $english_level = array((int)$params['english_level']);
            update_post_meta( $post_id, '_freelancer_english_level', sanitize_text_field($params['english_level']));
            wp_set_post_terms( $post_id, $english_level, 'freelancer-english-level', false );
        }
        if(isset($params['freelancer_specialization']))
        {
            $freelancer_specialization = array((int)$params['freelancer_specialization']);
            update_post_meta( $post_id, '_freelancer_specialization', sanitize_text_field($params['freelancer_specialization']));
            wp_set_post_terms( $post_id, $freelancer_specialization, 'freelancer-specialization', false );
            update_post_meta($post_id, 'cf_freelancer_specialization', $params['freelancer_specialization']);
        }
        //saving custom fields
        if (isset($params['acf']) && $params['acf'] != '' && class_exists('ACF'))
        {
            exertio_framework_acf_clear_object_cache($post_id);
            acf_update_values($params['acf'], $post_id);

        }

//		if(isset($params['freelancer_language']))
//		{
//			$freelancer_language = array((int)$params['freelancer_language']);
//
//			update_post_meta( $post_id, '_freelancer_language', sanitize_text_field($params['freelancer_language']));
//			wp_set_post_terms( $post_id, $freelancer_language, 'freelancer-languages', false );
//		}
        if(isset($params['freelancer_language']))
        {
            $integerIDs = array_map('intval', $params['freelancer_language']);
            $integerIDs = array_unique($integerIDs);
            wp_set_post_terms( $post_id, $integerIDs, 'freelancer-languages' );
        }

        if(isset($params['freelancer_location']))
        {
            update_post_meta( $post_id, '_freelancer_location', sanitize_text_field($params['freelancer_location']));
            set_hierarchical_terms('freelancer-locations', $params['freelancer_location'], $post_id);
        }

        if(isset($params['profile_attachment_ids']))
        {
            update_post_meta( $post_id, '_profile_pic_freelancer_id', sanitize_text_field($params['profile_attachment_ids']));
        }

        if(isset($params['banner_img_id']))
        {
            update_post_meta( $post_id, '_freelancer_banner_id', sanitize_text_field($params['banner_img_id']));
        }

        if(isset($params['fl_address']))
        {
            update_post_meta( $post_id, '_freelancer_address', sanitize_text_field($params['fl_address']));
        }

        if(isset($params['fl_lat']))
        {
            update_post_meta( $post_id, '_freelancer_latitude', sanitize_text_field($params['fl_lat']));
        }

        if(isset($params['fl_long']))
        {
            update_post_meta( $post_id, '_freelancer_longitude', sanitize_text_field($params['fl_long']));
        }

        if($exertio_theme_options['fl_skills'] == 2)
        {
            if(isset($params['freelancer_skills']))
            {
                $skill_name = $params['freelancer_skills'];
                $skill_percent = $params['skills_percent'];

                $integerIDs = array_map('intval', $params['freelancer_skills']);
                $integerIDs = array_unique($integerIDs);

                $ary = array();
                for($i=0; $i<count($skill_name); $i++)
                {
                    $skill_id = sanitize_text_field($skill_name[$i]);
                    $percent = sanitize_text_field($skill_percent[$i]);


                    if($percent > 100)
                    {
                        $return = array('message' => esc_html__( 'Skill percentage can not be greater then 100', 'exertio_framework' ));
                        wp_send_json_error($return);
                    }
                    if( !in_array($skill_id, $ary)){
                        $skills[] = array(
                            "skill" => $skill_id,
                            "percent" =>$percent
                        );
                        $ary[] = $skill_id;
                    }


                }

                $encoded_skills =  wp_json_encode($skills, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

                wp_set_post_terms( $post_id, $integerIDs, 'freelancer-skills', false );
                update_post_meta( $post_id, '_freelancer_skills', $encoded_skills );

            }
            else if($params['freelancer_skills'] == '')
            {
                wp_set_post_terms( $post_id, '', 'freelancer-skills', false );
                update_post_meta( $post_id, '_freelancer_skills', '' );
            }
        }
        if($exertio_theme_options['fl_awards'] == 2)
        {
            if(isset($params['award_name']) && isset($params['award_date']))
            {
                $award_name = $params['award_name'];
                $award_date = $params['award_date'];
                $awar_img = $params['award_img_id'];

                for($i=0; $i<count($award_name); $i++)
                {
                    $name = sanitize_text_field($award_name[$i]);
                    $date = sanitize_text_field($award_date[$i]);
                    $img = sanitize_text_field($awar_img[$i]);
                    $awards[] = array(
                        "award_name" => $name,
                        "award_date" =>$date,
                        "award_img" =>$img,
                    );
                }
                $encoded_awards =  wp_json_encode($awards, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

                update_post_meta( $post_id, '_freelancer_awards', $encoded_awards );
            }
            else if($params['award_name'] == '' && $params['award_date'] == '')
            {
                update_post_meta( $post_id, '_freelancer_awards', '' );
            }
        }
        if($exertio_theme_options['fl_projects'] == 2)
        {
            if(isset($params['project_name']) && isset($params['project_url']))
            {
                $project_name = $params['project_name'];
                $project_url = $params['project_url'];
                $project_img = $params['project_img_id'];

                for($i=0; $i<count($project_name); $i++)
                {
                    $name = sanitize_text_field($project_name[$i]);
                    $date = sanitize_text_field($project_url[$i]);
                    $img = sanitize_text_field($project_img[$i]);
                    $projects[] = array(
                        "project_name" => str_replace(array('"'), '', $name),
                        "project_url" =>str_replace(array('"'), '', $date),
                        "project_img" =>$img,
                    );
                }
                $encoded_projects =  wp_json_encode($projects, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

                update_post_meta( $post_id, '_freelancer_projects', $encoded_projects );
            }
            else if($params['project_name'] == '' && $params['project_url'] =='')
            {
                update_post_meta( $post_id, '_freelancer_projects', '' );
            }
        }
        if($exertio_theme_options['fl_experience'] == 2)
        {
            if(isset($params['expe_name']))
            {
                $expe_name = str_replace(array('"'), '', $params['expe_name']);
                $expe_company_name =  str_replace(array('"'), '', $params['expe_company_name']);
                $expe_start_date = $params['expe_start_date'];
                $expe_end_date = $params['expe_end_date'];
                $expe_details = str_replace(array('"'), '', $params['expe_details']);


                for($i=0; $i<count($expe_name); $i++)
                {
                    $name = sanitize_text_field($expe_name[$i]);
                    $inst_name = sanitize_text_field($expe_company_name[$i]);
                    $start_date = sanitize_text_field($expe_start_date[$i]);
                    $end_date = sanitize_text_field($expe_end_date[$i]);
                    $desc = sanitize_text_field($expe_details[$i]);
                    $experience[] = array(
                        "expe_name" => $name,
                        "expe_company_name" =>$inst_name,
                        "expe_start_date" =>$start_date,
                        "expe_end_date" =>$end_date,
                        "expe_details" =>$desc,
                    );
                }
                $encoded_experience =  wp_json_encode($experience, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

                update_post_meta( $post_id, '_freelancer_experience', $encoded_experience );
            }
            else if($params['expe_name'] == '')
            {
                update_post_meta( $post_id, '_freelancer_experience', '' );
            }
        }
        if($exertio_theme_options['fl_education'] == 2)
        {
            if(isset($params['edu_name']))
            {
                $edu_name = str_replace(array('"'), '', $params['edu_name']);
                $edu_inst_name = str_replace(array('"'), '', $params['edu_inst_name']);
                $edu_start_date = $params['edu_start_date'];
                $edu_end_date = $params['edu_end_date'];
                $edu_desc = str_replace(array('\'', '"'), '', $params['edu_details']);

                for($i=0; $i<count($edu_name); $i++)
                {
                    $name = sanitize_text_field($edu_name[$i]);
                    $inst_name = sanitize_text_field($edu_inst_name[$i]);
                    $start_date = sanitize_text_field($edu_start_date[$i]);
                    $end_date = sanitize_text_field($edu_end_date[$i]);
                    $desc = sanitize_text_field($edu_desc[$i]);
                    $education[] = array(
                        "edu_name" => $name,
                        "edu_inst_name" =>$inst_name,
                        "edu_start_date" =>$start_date,
                        "edu_end_date" =>$end_date,
                        "edu_details" =>$desc,
                    );
                }
                $encoded_education = wp_json_encode($education, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
                update_post_meta( $post_id, '_freelancer_education', $encoded_education );
            }
            else if($params['edu_name'] == '')
            {
                update_post_meta( $post_id, '_freelancer_education', '' );
            }
        }
        $return = array('message' => esc_html__( 'Profile updated', 'exertio_framework' ));
        wp_send_json_success($return);
    }
}


add_action( 'wp_ajax_fl_addon_save', 'fl_addon_save' );
if ( ! function_exists( 'fl_addon_save' ) )
{
    function fl_addon_save()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_save_pro_secure', 'security' );
        $uid = get_current_user_id();
        $post_id = $_POST['post_id'];
        $params = array();
        $addon_status = get_post_status ( $post_id );

        parse_str($_POST['fl_data'], $params);
        global $exertio_theme_options;
        if($params['is_update'] != '')
        {
            if($addon_status == 'publish')
            {
                $status = "publish";
                if(isset($exertio_theme_options['addons_update_approval']) &&  $exertio_theme_options['addons_update_approval'] == 0)
                {
                    $status = "pending";
                }
            }
            else
            {
                $status = "pending";
            }
        }
        else
        {
            $status = "publish";
            if(isset($exertio_theme_options['addons_approval']) &&  $exertio_theme_options['addons_approval'] == 0)
            {
                $status = "pending";
            }
        }

        $words = explode(',', $exertio_theme_options['bad_words_filter']);
        $replace = $exertio_theme_options['bad_words_replace'];
        $desc = fl_badwords_filter($words, $params['addon_desc'], $replace);
        $title = fl_badwords_filter($words, $params['addon_title'], $replace);
        $my_post = array(
            'ID' => $post_id,
            'post_title' => sanitize_text_field($title),
            'post_content' => wp_kses_post($desc),
            'post_type' => 'addons',
            'post_status'   => $status,
        );

        $result = wp_update_post($my_post, true);

        if (is_wp_error($result))
        {
            $return = array('message' => esc_html__( 'Addon not saved. Please contact admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }

        if(isset($params['addon_price']))
        {
            update_post_meta( $post_id, '_addon_price', sanitize_text_field($params['addon_price']));

        }

        if($params['is_update'] == '')
        {
            update_user_meta( $uid, '_processing_addon_id', '' );
        }
        update_post_meta( $post_id, '_addon_status', 'active');
        $page_link = get_the_permalink($exertio_theme_options['user_dashboard_page'])."?ext=create-addon&aid=".$post_id;
        $return = array('message' => esc_html__( 'Addon Created', 'exertio_framework' ),'pid' => $page_link);
        wp_send_json_success($return);

    }
}

add_action('wp_ajax_fl_remove_addon', 'fl_remove_addon');
if ( ! function_exists( 'fl_remove_addon' ) ) {
    function fl_remove_addon()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_gen_secure', 'security' );

        $ad_id		=	$_POST['pid'];

        if( wp_trash_post( $ad_id ) )
        {
            $return = array('message' => esc_html__( 'Addon removed successfully', 'exertio_framework' ));
            wp_send_json_success($return);
        }
        else
        {
            $return = array('message' => esc_html__( 'There is some problem, please try again later', 'exertio_framework' ));
            wp_send_json_error($return);
        }


        die();
    }
}


add_action('wp_ajax_services_attachments', 'freelance_services_attachments');
if ( ! function_exists( 'freelance_services_attachments' ) )
{
    function freelance_services_attachments()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');

        global $exertio_theme_options;
        $pid = $_POST['post-id'];
        $field_name =  $_FILES['services_attachments'];
        $condition_img=7;
        $attachment_size = '2000';
        $img_count = count(array_count_values($field_name['name']));

        if(isset($exertio_theme_options['sevices_attachment_count']))
        {
            $condition_img= $exertio_theme_options['sevices_attachment_count'];
        }

        if(isset($exertio_theme_options['services_attachment_size']))
        {
            $attachment_size= $exertio_theme_options['services_attachment_size'];
        }

        if(!empty($field_name))
        {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $files = $field_name;

            $files_array = array();
            foreach ($files['name'] as $key => $value)
            {
                if ($files['name'][$key])
                {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array ("emp_profile_picture" => $file);

                    foreach ($_FILES as $file => $array)
                    {
                        $exist_data = get_post_meta( $pid, '_service_attachment_ids', true );

                        $is_upload_file = true;
                        $imageFileType	=	end( explode('.', $array['name'] ) );
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG")
                        {
                            $is_upload_file = false;
                            $attach_id = 0;
                            $message =  esc_html__( "Sorry, only JPG, JPEG, and PNG files are allowed.", 'exertio_framework' );

                        }
                        else
                        {

                            $exist_data_count ='';
                            if(isset($exist_data) && $exist_data != '')
                            {
                                $exist_data_count = count(explode(",",$exist_data));
                            }

                            $is_upload_file = true;
                            if($exist_data_count >= $condition_img)
                            {
                                $message = esc_html__( "Attachment upload limit reached", 'exertio_framework' );
                                $is_upload_file = false;
                                $attach_id = 0;
                            }

                            if($is_upload_file)
                            {
                                $is_upload_file = true;
                                if ($array['size']/1000 > $attachment_size) {
                                    $is_upload_file = false;
                                    $attach_id = 0;
                                    $message = esc_html__( 'Max allowed attachment size is '.$attachment_size.' Kb', 'exertio_framework' );
                                }

                                if($is_upload_file){

                                    $attach_id = media_handle_upload( $file, $pid );

                                    if( is_wp_error($attach_id ))
                                    {
                                        $is_upload_file = false;
                                        $message = $attach_id->get_error_message();
                                        $attach_id = 0;
                                    }
                                    else
                                    {
                                        if(isset($exist_data) && $exist_data != '' )
                                        {
                                            $attach_id_store = $exist_data.','.$attach_id;
                                        }
                                        else
                                        {
                                            $attach_id_store = $attach_id;
                                        }
                                        update_post_meta( $pid, '_service_attachment_ids', $attach_id_store);
                                        $message = esc_html__( "File Uploaded", 'exertio_framework' );
                                    }
                                }
                            }

                        }
                        $file_size_kb = $array['size']/1000;
                        $icon = get_icon_for_attachment_type($array['type'], $attach_id);

                        $files_array[] = array(
                            'name' => $array['name'],
                            'icon' => $icon,
                            'file-size' => $file_size_kb,
                            'message' => $message,
                            'data-id' => $attach_id,
                            'data-pid' => $pid,
                            'is-error' => (isset($is_upload_file) && $is_upload_file == true) ? '':'upload-error',
                        );
                    }
                }
            }
        }
        $close_icon = $data = '';
        foreach($files_array as $arr){
            $close_icon = (isset($arr['is-error']) && $arr['is-error'] == '') ? '<i class="far fa-times-circle"></i>':'';
            $data .= '<div class="attachments ui-state-default pro-atta-'.$arr['data-id'].' '.$arr['is-error'].'"> <img src="'.$arr['icon'].'" alt="'.get_post_meta($arr['data-id'], '_wp_attachment_image_alt', TRUE).'" data-img-id="'.$arr['data-id'].'"><span class="attachment-data"> <h4>'.$arr['name'].'<small class="'.$arr['is-error'].'">  - '. $arr['message'] .'</small> </h4> <p>'.esc_html__( "file size:", 'exertio_framework' ).'  '.$arr['file-size'].esc_html__( " Kb", 'exertio_framework' ).'</p> <a href="javascript:void(0)" class="btn_delete_services_attachment" data-id="'.$arr['data-id'].'" data-pid="'.$arr['data-pid'].'">'.$close_icon.'</a> </span></div>';
        }

        echo '1|'.esc_html__( "Attachments uploaded", 'exertio_framework' ).'|' .$data.'|'.$attach_id_store;
        die();
    }
}


if ( ! function_exists( 'freelance_services_attachments1' ) )
{
    function freelance_services_attachments1()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');

        global $exertio_theme_options;
        $pid = $_POST['post-id'];

        $field_name =  $_FILES['services_attachments'];

        $condition_img=7;

        $img_count = count(array_count_values($field_name['name']));


        if(isset($exertio_theme_options['sevices_attachment_count']))
        {
            $condition_img= $exertio_theme_options['sevices_attachment_count'];
        }

        if(isset($exertio_theme_options['services_attachment_size']))
        {
            $attachment_size= $exertio_theme_options['services_attachment_size'];
        }

        if(!empty($field_name))
        {

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';


            $files = $field_name;

            $attachment_ids=array();
            $attachment_idss='';

            if($img_count>=1)
            {
                $imgcount=$img_count;
            }
            else
            {
                $imgcount=1;
            }
            foreach ($files['name'] as $key => $value)
            {
                if ($files['name'][$key])
                {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array ("emp_profile_picture" => $file);

                    // Allow certain file formats
                    $imageFileType	=	end( explode('.', $file['name'] ) );
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" )
                    {
                        echo '0|' . esc_html__( "Sorry, only JPG, JPEG, PNG, files are allowed.", 'exertio_framework' );
                        die();
                    }

                    // Check file size



                    foreach ($_FILES as $file => $array)
                    {
                        $exist_data = get_post_meta( $pid, '_service_attachment_ids', true );

                        $exist_data_count ='';
                        if(isset($exist_data) && $exist_data != 0)
                        {
                            $exist_data_count = count(explode(",",$exist_data));
                        }
                        if($exist_data_count >= $condition_img)
                        {

                            echo '0|'.esc_html__( "Attachments uploaded limit reached", 'exertio_framework' ).'|' .$data;
                            die;
                            break;
                        }

                        if ($array['size']/1000 > $attachment_size) {
                            echo '0|' . esc_html__( 'Max allowed attachment size is '.$attachment_size.' Kb', 'exertio_framework' );
                            die();
                            break;
                        }

                        $attach_id = media_handle_upload( $file, $pid );
                        if(is_wp_error($attach_id))
                        {
                            echo '0|' . esc_html__( "Sorry, this type of image/file are not allowed.", 'exertio_framework' );
                            die();						}
                        else
                        {

                            $attachment_ids[] = $attach_id;

                            $image_link = wp_get_attachment_image_src( $attach_id, 'thumbnail' );

                            $new_data = $attach_id;

                            if(isset($exist_data) && $exist_data != 0)
                            {
                                $new_data = $exist_data.','.$attach_id;
                            }
                            update_post_meta( $pid, '_service_attachment_ids', $new_data);

                            $icon = get_icon_for_attachment($attach_id);
                            $data .= '<div class="attachments pro-atta-'.$attach_id.'"> <img src="'.$icon.'" alt="'.get_post_meta($attach_id, '_wp_attachment_image_alt', TRUE).'"><span class="attachment-data"> <h4>'.get_the_title($attach_id).' </h4> <p>'.esc_html__( " file size:", 'exertio_framework' ).' '.size_format(filesize(get_attached_file( $attach_id ))).'</p> <a href="javascript:void(0)" class="btn-pro-clsoe-icon" data-id="'.$attach_id.'" data-pid="'.$pid.'"> <i class="far fa-times-circle"></i></a> </span></div>';
                        }
                    }
                    $imgcount++;
                }
            }
        }
        if($exist_data_count < $condition_img)
        {
            echo '1|'.esc_html__( "Attachments uploaded", 'exertio_framework' ).'|' .$data.'|'.$new_data;
            die;
        }

    }
}

add_action('wp_ajax_delete_service_attachment', 'fl_delete_service_attachment');

if ( ! function_exists( 'fl_delete_service_attachment' ) )
{
    function fl_delete_service_attachment()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        $attachment_id = $_POST['attach_id'];
        $sid = $_POST['sid'];

        if($attachment_id !='' && $sid != '')
        {
            $exist_data = get_post_meta( $sid, '_service_attachment_ids', true );

            $array1 = array($attachment_id);
            $array2 = explode(',', $exist_data);
            $array3 = array_diff($array2, $array1);
            wp_delete_attachment($attachment_id);
            $new_data = implode(',', $array3);
            update_post_meta( $sid, '_service_attachment_ids', $new_data);
            $return = array('message' => esc_html__( 'Attachment deleted', 'exertio_framework' ), 'returned_ids' => $new_data);
            wp_send_json_success($return);

        }
        else
        {
            $return = array('message' => esc_html__( 'Error!!! attachment is not deleted', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}
add_action( 'wp_ajax_fl_service_save', 'fl_service_save' );
if ( ! function_exists( 'fl_service_save' ) )
{
    function fl_service_save()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_save_service_secure', 'security' );
        $uid = get_current_user_id();
        $post_id = $_POST['post_id'];
        $params = array();
        $service_status = get_post_status ( $post_id );

        parse_str($_POST['fl_data'], $params);


        global $exertio_theme_options;

        /*CHECK IF EMIL IS VERIFIED*/
        if(isset($exertio_theme_options['services_with_email_verified']) &&  $exertio_theme_options['services_with_email_verified'] == 0)
        {
            $is_verified = get_user_meta( $uid, 'is_email_verified', true );
            if($is_verified != 1 || $is_verified == '')
            {
                $return = array('message' => esc_html__( 'Please verifiy your email first', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }

        update_post_meta( $post_id, '_service_attachment_ids', $params['services_attachment_ids']);
        $freelancer_id = get_user_meta( $uid, 'freelancer_id' , true );

        if($params['is_update'] != '')
        {
            if($service_status == 'publish')
            {
                $status = "publish";
                if(isset($exertio_theme_options['service_update_approval']) &&  $exertio_theme_options['service_update_approval'] == 0)
                {
                    $status = "pending";
                }
            }
            else
            {
                $status = "pending";
            }
        }
        else
        {
            if(isset($exertio_theme_options['service_approval']) &&  $exertio_theme_options['service_approval'] == 0)
            {
                $status = "pending";
            }
            else
            {
                $status = 'publish';
            }
        }

        $words = explode(',', $exertio_theme_options['bad_words_filter']);
        $replace = $exertio_theme_options['bad_words_replace'];
        $desc = fl_badwords_filter($words, $params['services_desc'], $replace);
        $title = fl_badwords_filter($words, $params['services_title'], $replace);
        $my_post = array(
            'ID' => $post_id,
            'post_title' => sanitize_text_field($title),
            'post_content' => $desc,
            'post_type' => 'services',
            'post_status'   => $status,
        );

        $result = wp_update_post($my_post, true);

        if (is_wp_error($result))
        {
            $return = array('message' => esc_html__( 'Data did not save. Please contact admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }

        //saving custom fields
        if (isset($params['acf']) && $params['acf'] != '' && class_exists('ACF'))
        {
            exertio_framework_acf_clear_object_cache($post_id);
            acf_update_values($params['acf'], $post_id);
        }
        if(isset($params['service_price']))
        {
            update_post_meta( $post_id, '_service_price', sanitize_text_field($params['service_price']));
        }
        if(isset($params['response_time']))
        {
            $response_terms = array((int)$params['response_time']);
            update_post_meta( $post_id, '_response_time', sanitize_text_field($params['response_time']));
            wp_set_post_terms( $post_id, $response_terms, 'response-time', false );
        }
        if(isset($params['delivery_time']))
        {
            $delivery_terms = array((int)$params['delivery_time']);
            update_post_meta( $post_id, '_delivery_time', sanitize_text_field($params['delivery_time']));
            wp_set_post_terms( $post_id, $delivery_terms, 'delivery-time', false );
        }
        if(isset($params['english_level']))
        {
            $service_english_level_term = array((int)$params['english_level']);
            update_post_meta( $post_id, '_service_eng_level', sanitize_text_field($params['english_level']));
            wp_set_post_terms( $post_id, $service_english_level_term, 'services-english-level', false );

        }

        if(isset($params['service_location']))
        {
            update_post_meta( $post_id, '_service_location', sanitize_text_field($params['service_location']));
            set_hierarchical_terms('services-locations', $params['service_location'], $post_id);
        }
        if(isset($params['service_category']))
        {
            update_post_meta( $post_id, '_service_category', sanitize_text_field($params['service_category']));
            set_hierarchical_terms('service-categories', $params['service_category'], $post_id);
            update_post_meta($post_id, 'cf_services_cats', $params['service_category']);
        }
        if(isset($params['services_address']))
        {
            update_post_meta( $post_id, '_service_address', sanitize_text_field($params['services_address']));
        }
        if(isset($params['services_lat']))
        {
            update_post_meta( $post_id, '_service_latitude', sanitize_text_field($params['services_lat']));
        }
        if(isset($params['services_long']))
        {
            update_post_meta( $post_id, '_service_longitude', sanitize_text_field($params['services_long']));
        }
        if(isset($params['video_urls']) && $params['video_urls'] != '')
        {
            if($params['video_urls'] !='')
            {
                $video_urls = str_replace(array( '"'), '', $params['video_urls']);
                $urls = wp_json_encode($video_urls, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
                update_post_meta( $post_id, '_service_youtube_urls', sanitize_text_field($urls));
            }
        }
        else
        {
            update_post_meta( $post_id, '_service_youtube_urls', '');
        }
        if(isset($params['faqs-title']) && $params['faqs-title'] != '')
        {
            $faq_title = $params['faqs-title'];
            $faq_answer = $params['faq-answer'];

            for($i=0; $i<count($faq_title); $i++)
            {
                $title = sanitize_text_field($faq_title[$i]);
                $answer = sanitize_text_field($faq_answer[$i]);
                $faqs[] = array(
                    "faq_title" =>  str_replace(array( '"'), '', $title),
                    "faq_answer" => str_replace(array('"'), '', $answer),
                );
            }
            $encoded_faqs =  wp_json_encode($faqs, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
            update_post_meta( $post_id, '_service_faqs', $encoded_faqs );
        }
        else
        {
            update_post_meta( $post_id, '_service_faqs', '');
        }
        if(isset($params['services_addon']))
        {
            $services_addon = $params['services_addon'];

            for($i=0; $i<count($services_addon); $i++)
            {
                $name = sanitize_text_field($services_addon[$i]);
                $addon[] = $name;
            }
            $encoded_addon =  json_encode($addon);
            update_post_meta( $post_id, '_services_addon', $encoded_addon );
        }

        if(isset($params['is_show_service_attachments']) && $params['is_show_service_attachments'] == 'yes')
        {
            update_post_meta( $post_id, '_service_attachment_show', 'yes');
        }
        else
        {
            update_post_meta( $post_id, '_service_attachment_show', 'no');
        }


        if($params['is_update'] == '')
        {
            update_user_meta( $uid, '_processing_services_id', '' );
        }
        $status = get_post_meta($post_id, '_service_status', true);
        if($status == 'cancel')
        {

        }
        else
        {
            update_post_meta( $post_id, '_service_status', 'active');
        }

        $c_dATE = DATE("d-m-Y");
        if($params['is_update'] == '')
        {

            $is_service_paid = fl_framework_get_options('is_services_paid');
            $simple_service = get_post_meta($freelancer_id, '_simple_services', true);

            if($is_service_paid == 1)
            {
                if(isset($simple_service) && $simple_service != -1 )
                {
                    if($simple_service != -1)
                    {
                        $new_simple_service = $simple_service - 1;
                        update_post_meta($freelancer_id, '_simple_services', $new_simple_service);
                    }
                }
            }

            $simple_service_expiry_days = get_post_meta($freelancer_id, '_simple_service_expiry', true);
            if($simple_service_expiry_days == -1)
            {
                update_post_meta($post_id, '_simple_service_expiry_date', -1);
            }
            else
            {
                if($simple_service_expiry_days != '' && $simple_service_expiry_days > 0 )
                {
                    $simple_service_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $simple_service_expiry_days days"));

                    update_post_meta($post_id, '_simple_service_expiry_date', $simple_service_expiry_date);
                }
                else if($simple_service_expiry_days == '')
                {
                    $default_service_expiry = fl_framework_get_options('service_default_expiry');
                    $simple_service_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_service_expiry days"));
                    update_post_meta($post_id, '_simple_service_expiry_date', $simple_service_expiry_date);
                }
            }
        }


        $is_featured_service = get_post_meta($post_id, '_service_is_featured', true);
        if($is_featured_service == 1)
        {

        }
        else
        {
            if(isset($params['featured_service']))
            {
                $featured_services = get_post_meta($freelancer_id, '_featured_services', true);
                if($featured_services == -1)
                {
                    update_post_meta( $post_id, '_service_is_featured', 1);
                }
                else if($featured_services > 0 && $featured_services != '')
                {
                    $new_featured_service = $featured_services - 1;
                    update_post_meta($freelancer_id, '_featured_services', $new_featured_service);
                    update_post_meta( $post_id, '_service_is_featured', 1);
                }

                $featured_services_expiry_days = get_post_meta($freelancer_id, '_featured_services_expiry', true);
                if($featured_services_expiry_days == -1)
                {
                    update_post_meta($post_id, '_featured_service_expiry_date', '-1');
                }
                else
                {
                    if($featured_services_expiry_days > 0 && $featured_services_expiry_days != '')
                    {
                        $featured_service_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $featured_services_expiry_days days"));
                        update_post_meta($post_id, '_featured_service_expiry_date', $featured_service_expiry_date);
                    }
                    else if($featured_services_expiry_days == '')
                    {
                        $default_featured_service_expiry = fl_framework_get_options('default_featured_service_expiry');
                        $featured_service_expiry_date = date('d-m-Y', strtotime($c_dATE. " + $default_featured_service_expiry days"));
                        update_post_meta($post_id, '_featured_service_expiry_date', $featured_service_expiry_date);
                    }
                }
            }
            else
            {
                update_post_meta( $post_id, '_service_is_featured', 0);
            }
        }

        $selected_reference = '';
        if(isset($post_id) && $post_id !="")
        {
            $selected_reference = fl_framework_get_options('fl_service_id');
            if(isset($selected_reference) && $selected_reference !="")
            {
                $updated_id = preg_replace( '/{ID}/', $post_id, $selected_reference );
                update_post_meta($post_id, '_service_ref_id', sanitize_text_field($updated_id));
            }
            else
            {
                update_post_meta($post_id, '_service_ref_id', $post_id);
            }
        }

        $page_link = get_the_permalink($exertio_theme_options['user_dashboard_page'])."?ext=add-services&sid=".$post_id;
        if($params['is_update'] == '')
        {
            $return = array('message' => esc_html__( 'New service has been created', 'exertio_framework' ),'pid' => $page_link);
        }
        else
        {
            $return = array('message' => esc_html__( 'Service updated', 'exertio_framework' ),'pid' => $page_link);
        }
        wp_send_json_success($return);

    }
}


/* CANCEL SERVICE*/

add_action('wp_ajax_fl_cancel_service', 'fl_cancel_service');

if ( ! function_exists( 'fl_cancel_service' ) )
{
    function fl_cancel_service()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_gen_secure', 'security' );
        $pid = $_POST['pid'];
        $status = $_POST['status'];
        if( $pid != '' && $status != '')
        {
            update_post_meta( $pid, '_service_status', $status);
            if($status == 'remove')
            {
                if( wp_trash_post( $pid ) )
                {
                    $return = array('message' => esc_html__( 'Service removed', 'exertio_framework' ));
                    wp_send_json_success($return);
                }
                else
                {
                    $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
            }
            if($status == 'active')
            {
                $return = array('message' => esc_html__( 'Service Activated', 'exertio_framework' ),);
            }
            else
            {
                $return = array('message' => esc_html__( 'Service Canceled', 'exertio_framework' ));
            }
            wp_send_json_success($return);
        }
        else
        {
            $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}

add_action('wp_ajax_fl_place_bid', 'fl_place_bid');
add_action( 'wp_ajax_nopriv_fl_place_bid', 'fl_place_bid' );
if ( ! function_exists( 'fl_place_bid' ) )
{
    function fl_place_bid()
    {
        fl_authenticate_check($_POST['post_id']);
        $current_user_id = get_current_user_id();

        /*DEMO DISABLED*/
        exertio_demo_disable('json');
        exertio_check_register_user_type(2);
        $today_date = date("d-m-Y");
        $pid = $_POST['post_id'];

        $project_expiry = get_post_meta($pid, '_simple_projects_expiry_date', true);
        if(strtotime($today_date) > strtotime($project_expiry))
        {
            $return = array('message' => esc_html__( 'Project Already Expired', 'exertio_framework' ));
            wp_send_json_error($return);
        }
        else
        {
            $post	=	get_post($pid);
            $current_user_id = get_current_user_id();
            $freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
            $author_id = get_user_meta( $post->post_author, 'employer_id' , true );

            $free_proposals = fl_framework_get_options('allow_free_proposal_sending');
            if(isset($free_proposals) && $free_proposals == 0)
            {
                $freelancer_package_expiry_date = get_post_meta($freelancer_id, '_freelancer_package_expiry_date', true);

                if(isset($freelancer_package_expiry_date) && strtotime($freelancer_package_expiry_date) < strtotime($today_date))
                {
                    $return = array('message' => esc_html__( 'Please purchase package to send proposal', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
            }

            $project_status = get_post_meta( $pid, '_project_status', true );

            if(isset($project_status) && $project_status == 'expired')
            {
                $return = array('message' => esc_html__( 'Project is expired', 'exertio_framework' ));
                wp_send_json_error($return);
            }
            $project_credits = get_post_meta($freelancer_id, '_project_credits', true);


            if(isset($project_credits) && $project_credits > 0 ||  $project_credits == -1 || $free_proposals == 1)
            {
                global $exertio_theme_options;
                check_ajax_referer( 'fl_gen_secure', 'security' );

                if($current_user_id != $post->post_author)
                {
                    global $wpdb;
                    $table = EXERTIO_PROJECT_BIDS_TBL;
                    $query = "SELECT id FROM ".$table." WHERE `freelancer_id` = '" . $freelancer_id . "' AND `project_id` = '" . $pid . "'";
                    $result = $wpdb->get_results($query);
                    if(empty($result))
                    {
                        parse_str($_POST['bid_data'], $params);
                        $p_charges = $exertio_theme_options['project_charges'];
                        $project_type = get_post_meta($pid, '_project_type', true);
                        if($project_type == 'fixed' || $project_type == 1)
                        {
                            $total_charges_hourly = $params['bid_price'];
                            $admin_charges = $total_charges_hourly/100*$p_charges;
                            $earning = $total_charges_hourly - $admin_charges;
                        }
                        else if($project_type == 'hourly' || $project_type == 2)
                        {
                            $total_charges_hourly = $params['bid_price']*$params['bid_days'];
                            $admin_charges = $total_charges_hourly/100*$p_charges;
                            $earning = $total_charges_hourly - $admin_charges;
                        }


                        $is_top = $is_sealed = $is_featured = 0;
                        $top_bid_charges = $sealed_bid_charges = $featured_bid_charges = 0;
                        if(isset($params['top_bid']) || isset($params['sealed_bid']) || isset($params['featured_bid']))
                        {
                            $wallet_amount = get_user_meta( $current_user_id, '_fl_wallet_amount', true );
                            if(isset($params['top_bid']))
                            {
                                $top_bid_charges = $exertio_theme_options['project_top_addon_price'];
                                $is_top	= '1';

                            }
                            if(isset($params['sealed_bid']))
                            {
                                $sealed_bid_charges = $exertio_theme_options['project_sealed_addon_price'];
                                $is_sealed	= '1';
                            }
                            if(isset($params['featured_bid']))
                            {
                                $featured_bid_charges = $exertio_theme_options['project_featured_addon_price'];
                                $is_featured	= '1';
                            }
                            /*BID CHARGES DEDUCTION*/
                            $bid_total_charges = $top_bid_charges+$sealed_bid_charges+$featured_bid_charges;

                            if($bid_total_charges > $wallet_amount)
                            {
                                $return = array('message' => esc_html__( 'Please load balance in your wallet', 'exertio_framework' ));
                                wp_send_json_error($return);
                            }
                            else
                            {
                                if(isset($params['top_bid']))
                                {
                                    do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$top_bid_charges,'t_type'=>'project_top_bid','t_status'=>'2', 'user_id'=> $current_user_id));

                                }
                                if(isset($params['sealed_bid']))
                                {
                                    do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$sealed_bid_charges,'t_type'=>'project_sealed_bid','t_status'=>'2', 'user_id'=> $current_user_id));
                                }
                                if(isset($params['featured_bid']))
                                {
                                    do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$featured_bid_charges,'t_type'=>'project_featured_bid','t_status'=>'2', 'user_id'=> $current_user_id));
                                }

                                $new_wallet_amount = $wallet_amount - $bid_total_charges;
                                update_user_meta( $current_user_id, '_fl_wallet_amount', $new_wallet_amount);
                            }
                        }
                        $current_time = current_time('mysql');


                        $data = array(
                            'timestamp' => $current_time,
                            'updated_on' =>$current_time,
                            'project_id' => $pid,
                            'proposed_cost' => sanitize_text_field($params['bid_price']),
                            'service_fee' => sanitize_text_field($admin_charges),
                            'earned_cost' => sanitize_text_field($earning),
                            'day_to_complete' => sanitize_text_field($params['bid_days']),
                            'cover_letter' => sanitize_text_field($params['bid_textarea']),
                            'freelancer_id' => $freelancer_id,
                            'author_id' => $author_id,
                            'is_top' => $is_top,
                            'is_sealed' => $is_sealed,
                            'is_featured' => $is_featured,
                        );

                        $wpdb->insert($table,$data);
                        $bid_id = $wpdb->insert_id;
                        if($bid_id)
                        {
                            if($free_proposals == 1)
                            {}
                            else
                            {
                                if(isset($project_credits) && $project_credits == -1 )
                                { }
                                else
                                {
                                    $new_project_credits = $project_credits - 1;
                                    update_post_meta( $freelancer_id, '_project_credits', $new_project_credits);
                                }
                            }

                            /*EMAIL ON PROPOSAL SENT*/
                            if(fl_framework_get_options('fl_email_project_proposal') == true)
                            {
                                fl_project_proposal_email($post->post_author,$pid);
                            }


                            /*NOTIFICATION*/
                            $post_author_user_id = get_post_field( 'post_author', $pid );
                            do_action( 'exertio_notification_filter',array('post_id'=> $pid,'n_type'=>'proposal','sender_id'=>$current_user_id,'receiver_id'=>$post_author_user_id, 'sender_type'=> 'freelancer') );

                            $return = array('message' => esc_html__( 'Proposal sent successfully', 'exertio_framework' ));
                            wp_send_json_success($return);
                        }

                        else
                        {
                            $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
                            wp_send_json_error($return);
                        }
                    }
                    else
                    {
                        $return = array('message' => esc_html__( 'You have already sent a proposal.', 'exertio_framework' ));
                        wp_send_json_error($return);
                    }


                }
                else
                {
                    $return = array('message' => esc_html__( 'You can not send a proposal to your project', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
            }
            else
            {
                $return = array('message' => esc_html__( 'Please purchase package to send proposal', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }
    }
}

if ( ! function_exists( 'get_project_bids' ) )
{
    function get_project_bids($pid = '', $start_from = 0, $limit = 10, $user_id = '', $exculde_user = '')
    {
        global $wpdb;
        $table = EXERTIO_PROJECT_BIDS_TBL;
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
        {
            if($user_id == '')
            {
                if ($exculde_user == '')
                {
                    $query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "' ORDER BY `is_top` DESC, `timestamp` DESC LIMIT ".$start_from.",".$limit."";
                    $result = $wpdb->get_results($query);
                }
                else
                {
                    $query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "' AND `freelancer_id` != '" . $exculde_user . "' ORDER BY `is_top` DESC, `timestamp` DESC LIMIT ".$start_from.",".$limit."";
                    $result = $wpdb->get_results($query);
                }
            }
            else if($user_id != '')
            {
                $freelancer_id = get_user_meta( $user_id, 'freelancer_id' , true );
                $query = "SELECT * FROM ".$table." WHERE `freelancer_id` = '" . $freelancer_id . "' ORDER BY  `timestamp` DESC LIMIT ".$start_from.",".$limit."";
                $result = $wpdb->get_results($query);
            }
            if($result)
            {
                return $result;
            }
        }
    }
}
if ( ! function_exists( 'get_project_bids' ) )
{
    function get_project_bids($pid = '', $start_from = 0, $limit = 10, $user_id = '', $exculde_user = '')
    {
        global $wpdb;
        $table = EXERTIO_PROJECT_BIDS_TBL;
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
        {
            if($user_id == '')
            {
                if ($exculde_user == '')
                {
                    $query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "' ORDER BY `is_top` DESC, `timestamp` DESC LIMIT ".$start_from.",".$limit."";
                    $result = $wpdb->get_results($query);
                }
                else
                {
                    $query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "' AND `freelancer_id` != '" . $exculde_user . "' ORDER BY `is_top` DESC, `timestamp` DESC LIMIT ".$start_from.",".$limit."";
                    $result = $wpdb->get_results($query);
                }
            }
            else if($user_id != '')
            {
                $freelancer_id = get_user_meta( $user_id, 'freelancer_id' , true );
                $query = "SELECT * FROM ".$table." WHERE `freelancer_id` = '" . $freelancer_id . "' ORDER BY  `timestamp` DESC LIMIT ".$start_from.",".$limit."";
                $result = $wpdb->get_results($query);
            }
            if($result)
            {
                return $result;
            }
        }
    }
}


if ( ! function_exists( 'get_project_bids_freelancer' ) )
{
    function get_project_bids_freelancer($pid = '', $freelancer_id = '')
    {
        global $wpdb;
        $table = EXERTIO_PROJECT_BIDS_TBL;
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
        {
            if($pid != '' && $freelancer_id != '')
            {
                $query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "' AND `freelancer_id` = '" . $freelancer_id . "'";
                $result = $wpdb->get_results($query);
            }
            if($result)
            {
                return $result;
            }
        }
    }
}



if ( ! function_exists( 'project_awarded' ) )
{
    function project_awarded($pid = '', $fl_id = '' )
    {
        global $wpdb;
        $table = EXERTIO_PROJECT_BIDS_TBL;
        if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
        {
            $query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "' AND `freelancer_id` ='".$fl_id."'";
            $result = $wpdb->get_results($query);
            if($result)
            {
                return $result;
            }
        }
    }
}
// Most Viewed Listings
if ( ! function_exists( 'exertio_fetch_most_viewed_listings' ) )
{
    function exertio_fetch_most_viewed_listings($owner_id, $post_type = 'projects', $key = 'project', $most_viewed = false, $todays_trending = false)
    {
        $order_by = 'date';
        if ($most_viewed == true)
        {
            $order_by = 'exertio_'.$key.'_singletotal_views';
        }

        $args	=	array
        (
            'post_type' => $post_type,
            'author' => $owner_id,
            //'post_status' => 'publish',
            'posts_per_page' => 5,
            'fields' => 'ids',
            'meta_key' => $order_by,
            'order'=> 'DESC',
            'orderby' => 'meta_value_num',
            'meta_query'    => array( )
        );
        return $args;
    }
}
add_action( 'wp_ajax_fl_verification_save', 'fl_verification_save' );
if ( ! function_exists( 'fl_verification_save' ) )
{
    function fl_verification_save()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');
        check_ajax_referer( 'fl_save_verification_secure', 'security' );
        $uid = get_current_user_id();
        $params = array();

        parse_str($_POST['fl_verification_data'], $params);

        global $exertio_theme_options;

        $status = "pending";

        $my_post = array(
            'post_author'   => $uid,
            'post_title' => sanitize_text_field($params['name']),
            'post_type' => 'verification',
            'post_status'   => $status,
        );

        $result = wp_insert_post($my_post, true);

        if (is_wp_error($result))
        {
            $return = array('message' => esc_html__( 'Verification document did not sent', 'exertio_framework' ));
            wp_send_json_error($return);
        }

        if(isset($params['contact_number']))
        {
            update_post_meta( $result, '_verification_contact', sanitize_text_field($params['contact_number']));

        }
        if(isset($params['verification_number']))
        {
            update_post_meta( $result, '_verification_number', sanitize_text_field($params['verification_number']));
        }
        if(isset($params['address']))
        {
            update_post_meta( $result, '_verification_address', sanitize_text_field($params['address']));
        }
        if(isset($params['attachment_id']))
        {
            update_post_meta( $result, '_attachment_doc_id', sanitize_text_field($params['attachment_id']));
        }


        update_user_meta($uid,'_identity_verification_Sent', 1);
        $page_link = get_the_permalink($exertio_theme_options['user_dashboard_page'])."?ext=identity-verification";
        $return = array('message' => esc_html__( 'Verification detail sent', 'exertio_framework' ),'pid' => $page_link);
        wp_send_json_success($return);

    }
}

add_action( 'wp_ajax_fl_revoke_verification', 'fl_revoke_verification' );
if ( ! function_exists( 'fl_revoke_verification' ) )
{
    function fl_revoke_verification()
    {
        global $exertio_theme_options;
        /*DEMO DISABLED*/
        exertio_demo_disable('json');
        $uid = get_current_user_id();
        if(isset($uid) && $uid != '')
        {
            $args = array(
                'post_type' => 'verification',
                'post_status' => 'all',
                'posts_per_page' => -1,
                'author' => $uid
            );

            $current_user_posts = get_posts( $args );
            foreach ( $current_user_posts as $current_user_post )
            {
                wp_delete_post( $current_user_post->ID, true);
            }
            update_user_meta($uid,'_identity_verification_Sent', 0);
            $fid = get_user_meta( $uid, 'freelancer_id' , true );
            $emp_id = get_user_meta( $uid, 'employer_id' , true );

            update_post_meta( $fid, '_is_freelancer_verified', 0);
            update_post_meta( $emp_id, '_is_employer_verified', 0);

            $page_link = get_the_permalink($exertio_theme_options['user_dashboard_page'])."?ext=identity-verification";
            $return = array('message' => esc_html__( 'verification revoked', 'exertio_framework' ),'pid' => $page_link);
            wp_send_json_success($return);
        }
        else
        {
            $return = array('message' => esc_html__( 'Verification document did not revoke', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}

add_action( 'wp_ajax_verification_doc', 'verification_doc' );
if ( ! function_exists( 'verification_doc' ) )
{
    function verification_doc()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('echo');
        $current_user_id = get_current_user_id();
        $pid = get_user_meta( $current_user_id, 'freelancer_id' , true );
        global $exertio_theme_options;

        $field_name =  $_FILES[$_POST['field-name']];

        /* img upload */
        $condition_img=7;
//		if(!isset($_POST["image_gallery"]))
//		{
//			echo '0|'.esc_html__( "Error in Image selection", 'exertio_framework' );
//		}
        //$img_count = count((array) explode( ',',$_POST["image_gallery"] ));
        $img_count = 0;
        if(!empty($field_name))
        {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';


            $files = $field_name;

            $attachment_ids=array();
            $attachment_idss='';

            if($img_count>=1)
            {
                $imgcount=$img_count;
            }
            else
            {
                $imgcount=1;
            }
            foreach ($files['name'] as $key => $value)
            {
                if ($files['name'][$key])
                {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array ("emp_profile_picture" => $file);

                    // Allow certain file formats
                    $imageFileType	=	explode('.', $file['name'] );
                    $file_extension =  end($imageFileType);
                    if($file_extension != "jpg" && $file_extension != "png" && $file_extension != "jpeg" && $file_extension != "JPG" && $file_extension != "PNG" && $file_extension != "JPEG")
                    {
                        echo '0|' . esc_html__( "Sorry, only JPG, JPEG, PNG files are allowed.", 'exertio_framework' );
                        die();
                    }

                    // Check file size
                    $image_size = $exertio_theme_options['user_attachment_size'];
                    if ($file['size']/1000 > $image_size) {
                        echo '0|' . esc_html__( "Max allowd image size is ".$image_size." KB", 'exertio_framework' );
                        die();
                    }

                    foreach ($_FILES as $file => $array)
                    {

                        if($imgcount>=$condition_img){ break; }
                        $attach_id = media_handle_upload( $file, $pid );
                        $attachment_ids[] = $attach_id;

                        $image_link = wp_get_attachment_image_src( $attach_id, 'thumbnail' );

                    }
                    if($imgcount>$condition_img){ break; }
                    $imgcount++;
                }
            }
        }
        /*img upload */
        $attachment_idss = array_filter( $attachment_ids  );
        $attachment_idss =  implode( ',', $attachment_idss );


        $arr = array();
        $arr['attachment_idss'] = $attachment_idss;

        echo '1|'.esc_html__( "Image changed Successfully", 'exertio_framework' ).'|' . $image_link[0].'|'.$attach_id;
        die();

    }
}
// REPORT FEATURE
add_action( 'wp_ajax_nopriv_fl_report_call_back', 'fl_report_call_back' );
add_action( 'wp_ajax_fl_report_call_back', 'fl_report_call_back' );
if (!function_exists ( 'fl_report_call_back' ))
{
    function fl_report_call_back()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');
        if(is_user_logged_in())
        {
            $post_id = intval($_POST['post_id']);
            $c_user_id = get_current_user_id();
            if( get_post_meta( $post_id, '_post_report_id_'.$c_user_id, true ) == $c_user_id )
            {
                $return = array('message' => esc_html__( 'You have already reported', 'exertio_framework' ));
                wp_send_json_error($return);
            }
            else
            {
                check_ajax_referer( 'fl_report_secure', 'security' );



                $params = array();
                parse_str($_POST['report_data'], $params);

                $status = "publish";
                $my_post = array(
                    'post_title' => sanitize_text_field(get_the_title($post_id)),
                    'post_content' => sanitize_textarea_field($params['report_desc']),
                    'post_type' => 'report',
                    'post_status'   => $status,
                );

                $result = wp_insert_post($my_post, true);

                if (is_wp_error($result))
                {
                    $return = array('message' => esc_html__( 'Error while reporting. Please contact Admin', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
                else if(!is_wp_error($result))
                {
                    if(isset($params['report_category']))
                    {
                        $report_category = array((int)$params['report_category']);
                        update_post_meta( $result, '_report_category', sanitize_text_field($params['report_category']));
                        wp_set_post_terms( $result, $report_category, 'report-category', false );
                    }
                    update_post_meta($result, '_reported_pid', $post_id);
                    update_post_meta($result, '_reported_post_type', get_post_type($post_id));

                    update_post_meta( $post_id, '_post_report_id_'.$c_user_id, $c_user_id );

                    $is_reported = get_post_meta($post_id,'_is_reported', true);
                    if(isset($is_reported ) && $is_reported  != '' &&  $is_reported > 0)
                    {
                        $is_reported = $is_reported  + 1;
                        update_post_meta($post_id, '_is_reported', $is_reported );
                    }
                    else
                    {
                        update_post_meta($post_id, '_is_reported', 1 );
                    }
                    $return = array('message' => esc_html__( 'Reported successfully', 'exertio_framework' ));
                    wp_send_json_success($return);
                    die();
                }
            }
        }
        else
        {
            $return = array('message' => esc_html__( 'Please login to report', 'exertio_framework' ));
            wp_send_json_error($return);
        }

    }
}


add_action( 'transition_post_status', 'exertio_post_published_hook', 10, 3 );
function exertio_post_published_hook( $new_status, $old_status, $post )
{
    $post_type = $post->post_type;
    $user_id = $post->post_author;
    $post_id = $post->ID;


    if($post_type == 'projects' && 'publish' == $new_status)
    {
        if(fl_framework_get_options('fl_email_onproject_created') == true)
        {
            fl_project_post_email($user_id,$post_id);
        }
    }
    if($post_type == 'services' && 'publish' == $new_status)
    {
        if(fl_framework_get_options('fl_email_onservice_created') == true)
        {
            fl_service_post_email($user_id,$post_id);
        }
    }
    if($post_type == 'payouts' && 'publish' == $new_status)
    {
        if(fl_framework_get_options('fl_email_payout_processed') == true)
        {
            fl_payout_processed_email($user_id);
        }
    }
    if($post_type == 'verification' && 'publish' == $new_status)
    {
        if(fl_framework_get_options('fl_email_identity_verify') == true)
        {
            fl_identity_verify_email($user_id);
            /*NOTIFICATION*/
            do_action( 'exertio_notification_filter',array('post_id'=> $post_id,'n_type'=>'identity_verified','sender_id'=>'1','receiver_id'=>$user_id,'sender_type'=>'admin') );
        }
    }
}

/* REMOVE PROPOSAL*/

add_action('wp_ajax_fl_remove_proposal', 'fl_remove_proposal');

if ( ! function_exists( 'fl_remove_proposal' ) )
{
    function fl_remove_proposal()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_gen_secure', 'security' );
        $pid = $_POST['pid'];
        if( $pid != '')
        {
            $current_user_id = get_current_user_id();
            global $wpdb;
            $table = EXERTIO_PROJECT_BIDS_TBL;
            if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
            {
                $freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
                $query = "SELECT * FROM ".$table." WHERE `id` = " . $pid."";
                $result = $wpdb->get_results($query);

                if(empty($result))
                {
                    $return = array('message' => esc_html__( 'Error!! Please contact Admin', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
                else
                {
                    foreach($result as $results)
                    {
                        if($freelancer_id == $results->freelancer_id)
                        {
                            $project_status = get_post_status($results->project_id);

                            if($project_status == 'publish')
                            {
                                $wpdb->delete( $table, array( 'id' => $pid ) );
                                $return = array('message' => esc_html__( 'Proposal Deleted', 'exertio_framework' ));
                                wp_send_json_success($return);
                            }
                            else
                            {
                                $return = array('message' => esc_html__( 'Ongoing, Completed or Canceled project proposals can not be deleted', 'exertio_framework' ));
                                wp_send_json_error($return);
                            }
                        }
                        else
                        {
                            $return = array('message' => esc_html__( 'You are not allowed to do that.', 'exertio_framework' ));
                            wp_send_json_error($return);
                        }
                    }
                }
            }

        }
        else
        {
            $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}

/* EDIT PROPOSAL MODAL*/

add_action('wp_ajax_fl_edit_proposal_modal', 'fl_edit_proposal_modal');

if ( ! function_exists( 'fl_edit_proposal_modal' ) )
{
    function fl_edit_proposal_modal()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_gen_secure', 'security' );
        global $exertio_theme_options;
        $pid = $_POST['pid'];
        if( $pid != '')
        {
            $current_user_id = get_current_user_id();
            global $wpdb;
            $table = EXERTIO_PROJECT_BIDS_TBL;
            if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
            {
                $freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
                $query = "SELECT * FROM ".$table." WHERE `id` = " . $pid."";
                $result = $wpdb->get_results($query);

                if(empty($result))
                {
                    $return = array('message' => esc_html__( 'Error!!! Please contact admin ', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
                else
                {
                    foreach($result as $results)
                    {
                        if($freelancer_id == $results->freelancer_id)
                        {
                            $project_status = get_post_status($results->project_id);
                            $project_expiry = get_post_meta($results->project_id, '_simple_projects_expiry_date', true);
                            $today = date('d-m-Y');

                            if(strtotime($today) <= strtotime($project_expiry) || $project_expiry == -1)
                            {
                                if($project_status == 'publish')
                                {
                                    $project_type = get_post_meta($results->project_id, '_project_type', true);
                                    /*CHECK IF EMIL IS VERIFIED*/
                                    if(isset($exertio_theme_options['projects_with_email_verified']) &&  $exertio_theme_options['projects_with_email_verified'] == 0)
                                    {
                                        $is_verified = get_user_meta( $current_user_id, 'is_email_verified', true );
                                        if($is_verified != 1 || $is_verified == '')
                                        {
                                            $return = array('message' => esc_html__( 'Please verify your email first', 'exertio_framework' ));
                                            wp_send_json_error($return);
                                        }
                                    }
                                    $html_modal = '<div class="modal review-modal fade" id="edit-proposal" tabindex="-1" role="dialog" aria-labelledby="edit-proposal" aria-hidden="true">
													  <div class="modal-dialog  modal-lg" role="document">
														<div class="modal-content">
														  <div class="modal-header">
															<h5 class="modal-title">'.esc_html__('Edit Proposal on " ','exertio_framework').get_the_title($results->project_id).'"</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															  <span aria-hidden="true">&times;</span>
															</button>
														  </div>
														  <div class="modal-body">
															  <div class="fr-project-place" id="fr-bid-form">
																			<form id="bid_form">
																			  <div class="row g-3">
																				<div class="col">';
                                                            if($project_type == 'fixed' || $project_type == 1)
                                                            {
                                                                $html_modal .=	'<div class="form-group">
																							<label>'.esc_html__('Your Price','exertio_framework').'</label>
																							<div class="input-group">
																							  <input type="text" class="form-control" id="bidding-price" name="bid_price" required data-smk-msg="'.esc_html__('Provide your price in numbers only','exertio_framework').'"  data-smk-type="number" value="'.$results->proposed_cost.'">
																							  <div class="input-group-prepend">
																								<div class="input-group-text">'. esc_html($exertio_theme_options['fl_currency']).'</div>
																							  </div>
																							</div>
																						  </div>';
                                                            }
                                                            else if($project_type == 'hourly' || $project_type == 2)
                                                            {
                                                                $html_modal .=	'<div class="form-group">
																							<label>'.esc_html__('Your hourly price','exertio_framework').'</label>
																							<div class="input-group">
																							  <input type="text" class="form-control" id="bidding_price" name="bid_price" required data-smk-msg="'.esc_html__('Provide your price in numbers only','exertio_framework').'"  data-smk-type="number" value="'.$results->proposed_cost.'">
																							  <div class="input-group-prepend">
																								<div class="input-group-text">'.esc_html($exertio_theme_options['fl_currency']).'</div>
																							  </div>
																							</div>
																						  </div>';
                                                            }

                                                            $html_modal .=	'</div>
                                                                                                        <div class="col">';
                                                            if($project_type == 'fixed' || $project_type == 1)
                                                            {
                                                                $html_modal .=	'<div class="form-group">
																							<label>'.esc_html__('Days to complete','exertio_framework').'</label>
																							<div class="input-group">
																							  <input type="text" class="form-control" name="bid_days" required data-smk-msg="'.esc_html__('Dasy to complete in numbers only','exertio_framework').'"  data-smk-type="number" value="'.$results->day_to_complete.'">
																							  <div class="input-group-prepend">
																								<div class="input-group-text">'. esc_html__('Days','exertio_framework').'</div>
																							  </div>
																							</div>
																						  </div>';
                                                            }
                                                            else if($project_type == 'hourly' || $project_type == 2)
                                                            {

                                                                $html_modal .=	'<div class="form-group">
																							<label>'.esc_html__('Estimated Hours','exertio_framework').'</label>
																							<div class="input-group">
																							  <input type="text" class="form-control" name="bid_days" id="bid-hours" required data-smk-msg="'.esc_html__('Hours to complete in numbers only','exertio_framework').'"  data-smk-type="number" value="'.$results->day_to_complete.'">
																							  <div class="input-group-prepend">
																								<div class="input-group-text">'.esc_html__('Hours','exertio_framework').'</div>
																							  </div>
																							</div>
																						  </div>';

                                                            }

                                                            $html_modal .=	'</div>
																				</div>
																				<div class="row g-3">';

                                                            $project_charges = $exertio_theme_options['project_charges'];
                                                            if($project_charges > 0 && $project_charges != '')
                                                            {
                                                                $html_modal .=	'<div class="col-12 price-section">
																					  <div class="pricing-section">
																						<ul>
																						  <li>
																							<div>'.esc_html__('Estimated Total Cost','exertio_framework').'
																								<p class="pricing-desc">'.esc_html__('The total project cost.','exertio_framework').'</p>
																							</div>
																							<div>';
                                                            if($project_type == 'fixed' || $project_type == 1)
                                                            {
                                                                $html_modal .=	'<p id="total-price">'. esc_html(fl_price_separator(get_post_meta($results->project_id, '_project_cost', true))).'</p>';

                                                            }
                                                            else if($project_type == 'hourly' || $project_type == 2)
                                                            {
                                                                $cost_hours = get_post_meta($results->project_id, '_project_cost', true);
                                                                $est_hours = get_post_meta($results->project_id, '_estimated_hours', true);
                                                                $html_modal .=	'<p id="total-price">'.esc_html( fl_price_separator($cost_hours*$est_hours)).'</p>';
                                                            }

                                                            $html_modal .=	'</div>
																						  </li>
																						  <li> <div>'.esc_html__('Service Fee','exertio_framework').' <small>('.$project_charges.'%)</small>'.'
																							<p class="pricing-desc">'.esc_html__('The service fee that will be deducted from your proposed amount.','exertio_framework').'</p>
																							</div> <div>
																							<p id="service-price"></p>
																							</div> </li>
																						  <li> <div>'.esc_html__('Your Earning','exertio_framework').'
																							<p class="pricing-desc">'.esc_html__('Total amount you will earn.','exertio_framework').'</p>
																							</div> <div>
																							<p id="earning-price"></p>
																							</div> </li>
																						</ul>
																					  </div>
																					</div>';

                                                            }
                                                            $html_modal .=	'</div>
                                                                                                      <div class="form-row">
                                                                                                        <div class="col-12">';
                                                            $price_breakdown = '';
                                                            if($project_charges > 0 && $project_charges != '')
                                                            {
                                                                $price_breakdown = '<a href="javascript:void(0)" class="price-breakdown">'.esc_html__('Price breakdown','exertio_framework').'</a>';
                                                            }
                                                            $html_modal .=	'<label>'.esc_html__('Cover Letter','exertio_framework').$price_breakdown.'</label>
                                                                                                          <textarea class="form-control" id="bid-textarea" name="bid_textarea" rows="3">'.$results->cover_letter.'</textarea>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                      <div class="fr-project-ad-content">';
                                                            $is_wallet_active = fl_framework_get_options('exertio_wallet_system');
                                                            if(isset($is_wallet_active) && $is_wallet_active == 0) {
                                                                if ($exertio_theme_options['project_top_bid_addon'] == 1) {
                                                                    if ($results->is_top == 0) {
                                                                        $html_modal .= '<div class="form-row">
																						  <div class="col-12">
																							<div class="fr-project-adons w1">
																							  <ul>
																								<li>
																								  <div class="pretty p-icon p-thick p-curve">
																									<input type="checkbox" name="top_bid" />
																									<div class="state p-warning">
																										<i class="icon fa fa-check"></i>
																									  <label></label>
																									</div>
																								  </div>
																								</li>
																								<li> <span>' . esc_html($exertio_theme_options['project_top_addon_title']) . '</span>
																								  <p>' . esc_html($exertio_theme_options['project_top_addon_desc']) . '</p>
																								</li>
																								<li> <span>' . esc_html(fl_price_separator($exertio_theme_options['project_top_addon_price'])) . '</span> </li>
																							  </ul>
																								<div class="bottom-icon">
																									' . wp_return_echo($exertio_theme_options['project_top_addon_icon']) . '
																								</div>
																							</div>
																						  </div>
																						</div>';
                                                                    }
                                                                }
                                                            }
                                                            $is_wallet_active = fl_framework_get_options('exertio_wallet_system');
                                                            if(isset($is_wallet_active) && $is_wallet_active == 0) {
                                                                if ($exertio_theme_options['project_sealed_bid_addon'] == 1) {
                                                                    if ($results->is_sealed == 0) {
                                                                        $html_modal .= '<div class="form-row">
																						  <div class="col-12">
																							<div class="fr-project-adons w2">
																							  <ul>
																								<li>
																								  <div class="pretty p-icon p-thick p-curve">
																									<input type="checkbox" name="sealed_bid" />
																									<div class="state p-warning">
																										<i class="icon fa fa-check"></i>
																									  <label></label>
																									</div>
																								  </div>
																								</li>
																								<li> <span>' . esc_html($exertio_theme_options['project_sealed_addon_title']) . '</span>
																								  <p>' . esc_html($exertio_theme_options['project_sealed_addon_desc']) . '</p>
																								</li>
																								<li> <span>' . esc_html(fl_price_separator($exertio_theme_options['project_sealed_addon_price'])) . '</span> </li>
																							  </ul>
																								<div class="bottom-icon">' . wp_return_echo($exertio_theme_options['project_sealed_addon_icon']) . '</div>
																							</div>
																						  </div>
																						</div>';
                                                                    }
                                                                }
                                                            }
                                                            $is_wallet_active = fl_framework_get_options('exertio_wallet_system');
                                                            if(isset($is_wallet_active) && $is_wallet_active == 0) {
                                                                if ($exertio_theme_options['project_featured_bid_addon'] == 1) {
                                                                    if ($results->is_featured == 0) {
                                                                        $html_modal .= '<div class="form-row">
																						  <div class="col-12">
																							<div class="fr-project-adons w3">
																							  <ul>
																								<li>
																								  <div class="form-group">
																									<div class="pretty p-icon p-thick p-curve">
																									  <input type="checkbox" name="featured_bid" />
																									  <div class="state p-warning">
																										<i class="icon fa fa-check"></i>
																										<label></label>
																									  </div>
																									</div>
																								  </div>
																								</li>
																								<li> <span>' . esc_html($exertio_theme_options['project_featured_addon_title']) . '</span>
																								  <p>' . esc_html($exertio_theme_options['project_featured_addon_desc']) . '</p>
																								</li>
																								<li> <span>' . esc_html(fl_price_separator($exertio_theme_options['project_featured_addon_price'])) . '</span> </li>
																							  </ul>
																								<div class="bottom-icon">' . wp_return_echo($exertio_theme_options['project_featured_addon_icon']) . '
																								</div>
																							</div>
																						  </div>
																						</div>';
                                                                    }
                                                                }
                                                            }
                                                            $html_modal .= '<div class="form-row">
																				  <div class="col-12">
																					<div class="button-bid">
																					  <div class="bid-text-checkbox">
																					  <div>
																						<div class="form-group">
																						  <div class="pretty p-icon p-thick p-curve">
																							<input type="checkbox" name="privacy_policy" required data-smk-msg="'.esc_html__('Please check this box to proceed.','exertio_framework').'"/>
																							<div class="state p-warning">
																								<i class="icon fa fa-check"></i>
																							  <label></label>
																							</div>
																						  </div>
																						</div>
																						</div> <div>'.esc_html__('I agree to the ','exertio_framework').'<a href="'. esc_url($exertio_theme_options['bid_tems_link']).'">'.esc_html__('terms and conditions','exertio_framework').'</a></div> </div>
																					  <button type="button" class="btn btn-theme btn-loading" id="btn_edit_project_bid" data-post-id ="'.esc_attr($pid).'">'. esc_html__('Edit & Save Proposal','exertio_framework').'
																					  <span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
																					  </button>
																					</div>
																				  </div>
																				</div>
																			  </div>
																			</form>
																	  </div>
														  </div>
														</div>
													  </div>
													</div>';
                                    $return = array('message' => esc_html__( 'Edit my proposal generated', 'exertio_framework' ), 'html'=> $html_modal);
                                    wp_send_json_success($return);
                                }
                                else
                                {
                                    $return = array('message' => esc_html__( 'Ongoing, Completed or Canceled project proposals can not be edited', 'exertio_framework' ));
                                    wp_send_json_error($return);
                                }
                            }
                            else
                            {
                                $return = array('message' => esc_html__( 'Project Expired', 'exertio_framework' ));
                                wp_send_json_error($return);
                            }
                        }
                        else
                        {
                            $return = array('message' => esc_html__( 'You are not allowed to do that.', 'exertio_framework' ));
                            wp_send_json_error($return);
                        }
                    }
                }
            }

        }
        else
        {
            $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}


/* EDIT PROPOSAL DONE*/

add_action('wp_ajax_fl_edit_proposal_done', 'fl_edit_proposal_done');

if ( ! function_exists( 'fl_edit_proposal_done' ) )
{
    function fl_edit_proposal_done()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_gen_secure', 'security' );
        global $exertio_theme_options;
        $pid = $_POST['post_id'];

        if( $pid != '')
        {
            $current_user_id = get_current_user_id();
            global $wpdb;
            $table = EXERTIO_PROJECT_BIDS_TBL;
            if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
            {
                $freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
                $query = "SELECT * FROM ".$table." WHERE `id` = " . $pid."";
                $result = $wpdb->get_results($query);

                if(empty($result))
                {
                    $return = array('message' => esc_html__( 'Error!! Please contact Admin', 'exertio_framework' ));
                    wp_send_json_error($return);
                }
                else
                {
                    foreach($result as $results)
                    {
                        if($freelancer_id == $results->freelancer_id)
                        {
                            $project_status = get_post_status($results->project_id);
                            $project_expiry = get_post_meta($results->project_id, '_simple_projects_expiry_date', true);
                            $today = date('d-m-Y');

                            if(strtotime($today) <= strtotime($project_expiry) || $project_expiry == -1)
                            {
                                if($project_status == 'publish')
                                {
                                    $project_type = get_post_meta($results->project_id, '_project_type', true);


                                    parse_str($_POST['bid_data'], $params);
                                    $p_charges = $exertio_theme_options['project_charges'];

                                    if($project_type == 'fixed' || $project_type == 1)
                                    {
                                        $total_charges_hourly = $params['bid_price'];
                                        $admin_charges = $total_charges_hourly/100*$p_charges;
                                        $earning = $total_charges_hourly - $admin_charges;
                                    }
                                    else if($project_type == 'hourly' || $project_type == 2)
                                    {
                                        $total_charges_hourly = $params['bid_price']*$params['bid_days'];
                                        $admin_charges = $total_charges_hourly/100*$p_charges;
                                        $earning = $total_charges_hourly - $admin_charges;
                                    }

                                    //$is_top = $is_sealed = $is_featured = 0;
                                    if($results->is_top == 1)
                                    {
                                        $is_top =  1;
                                    }
                                    else
                                    {
                                        $is_sealed = 0;
                                    }
                                    if($results->is_sealed == 1)
                                    {
                                        $is_sealed =  1;
                                    }
                                    else
                                    {
                                        $is_top = 0;
                                    }
                                    if($results->is_featured == 1)
                                    {
                                        $is_featured =  1;
                                    }
                                    else
                                    {
                                        $is_featured = 0;
                                    }
                                    $top_bid_charges = $sealed_bid_charges = $featured_bid_charges = 0;
                                    if(isset($params['top_bid']) || isset($params['sealed_bid']) || isset($params['featured_bid']))
                                    {

                                        $wallet_amount = get_user_meta( $current_user_id, '_fl_wallet_amount', true );
                                        if(isset($params['top_bid']))
                                        {
                                            $top_bid_charges = $exertio_theme_options['project_top_addon_price'];
                                            $is_top	= '1';

                                        }
                                        if(isset($params['sealed_bid']))
                                        {
                                            $sealed_bid_charges = $exertio_theme_options['project_sealed_addon_price'];
                                            $is_sealed	= '1';
                                        }
                                        if(isset($params['featured_bid']))
                                        {
                                            $featured_bid_charges = $exertio_theme_options['project_featured_addon_price'];
                                            $is_featured	= '1';
                                        }
                                        /*BID CHARGES DEDUCTION*/
                                        $bid_total_charges = $top_bid_charges+$sealed_bid_charges+$featured_bid_charges;

                                        if($bid_total_charges > $wallet_amount)
                                        {
                                            $return = array('message' => esc_html__( 'Please load balance in your wallet', 'exertio_framework' ));
                                            wp_send_json_error($return);
                                        }
                                        else
                                        {
                                            $new_wallet_amount = $wallet_amount - $bid_total_charges;
                                            update_user_meta( $current_user_id, '_fl_wallet_amount', $new_wallet_amount);
                                        }
                                    }

                                    $current_time = current_time('mysql');


                                    $data = array(
                                        'updated_on' =>$current_time,

                                        'proposed_cost' => sanitize_text_field($params['bid_price']),
                                        'service_fee' => sanitize_text_field($admin_charges),
                                        'earned_cost' => sanitize_text_field($earning),
                                        'day_to_complete' => sanitize_text_field($params['bid_days']),
                                        'cover_letter' => sanitize_text_field($params['bid_textarea']),
                                        'is_top' => $is_top,
                                        'is_sealed' => $is_sealed,
                                        'is_featured' => $is_featured,
                                    );

                                    $where = array(
                                        'id' => $pid,
                                    );

                                    $update_id = $wpdb->update( $table, $data, $where );

                                    if($update_id)
                                    {
                                        $return = array('message' => esc_html__( 'Proposal edited successfully', 'exertio_framework' ));
                                        wp_send_json_success($return);
                                    }
                                    else
                                    {
                                        $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
                                        wp_send_json_error($return);
                                    }

                                }
                                else
                                {
                                    $return = array('message' => esc_html__( 'Ongoing, Completed or Canceled project proposals can not be edited', 'exertio_framework' ));
                                    wp_send_json_error($return);
                                }
                            }
                            else
                            {
                                $return = array('message' => esc_html__( 'Project Expired', 'exertio_framework' ));
                                wp_send_json_error($return);
                            }
                        }
                        else
                        {
                            $return = array('message' => esc_html__( 'You are not allowed to do that.', 'exertio_framework' ));
                            wp_send_json_error($return);
                        }
                    }
                }
            }

        }
        else
        {
            $return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}

/* CREATE MILESTONE*/

add_action('wp_ajax_fl_create_milestone', 'fl_create_milestone');

if ( ! function_exists( 'fl_create_milestone' ) )
{
    function fl_create_milestone()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_gen_secure', 'security' );
        global $exertio_theme_options;
        $project_id = $_POST['post_id'];
        $current_user_id = get_current_user_id();
        parse_str($_POST['milestone_data'], $params);
        $today_date = date("d-m-Y");
        $count = 0;


        $project_author_id = get_post_field( 'post_author', $project_id );
        if(get_post_status($project_id) == 'ongoing')
        {
            if($project_author_id == $current_user_id)
            {

                $hourly_cost = $hours = $project_price = '';
                $type =get_post_meta($project_id, '_project_type', true);
                if($type == 'fixed' || $type == 1)
                {
                    $project_price = get_post_meta($project_id, '_project_cost', true);
                }
                else if($type == 'hourly' || $type == 2)
                {

                    $hourly_cost = get_post_meta($project_id, '_project_cost', true);
                    $hours = get_post_meta($project_id, '_estimated_hours', true);
                    $project_price = $hourly_cost*$hours;
                }

                $paid_milestone_amount = 0;
                $current_milestone_amount = $params['current_milestone_amount'];


                if($current_milestone_amount > $project_price )
                {
                    $return = array('message' => esc_html__( 'Project total amount is ', 'exertio_framework' ).fl_price_separator($project_price));
                    wp_send_json_error($return);
                }
                else
                {
                    $remaining_milestone_amount = $project_price - $current_milestone_amount;

                    $stored_milestone_data = get_post_meta($project_id,'_project_milestone_data', true);
                    if(!empty($stored_milestone_data))
                    {

                        foreach($stored_milestone_data as $stored_milestone_data_array)
                        {
                            $count = $stored_milestone_data_array['milestone_id'];
                            $remaining_amount = $stored_milestone_data_array['milestone_remaining_amount'];

                            $remaining_milestone_amount = $remaining_amount - $current_milestone_amount;


                            $count++;
                        }

                        if($current_milestone_amount > $remaining_amount )
                        {
                            $return = array('message' => esc_html__( 'Remaining amount is ', 'exertio_framework' ).fl_price_separator($remaining_amount));
                            wp_send_json_error($return);
                        }
                    }
                    else
                    {
                        $stored_milestone_data = array();
                    }

                    $stored_milestone_data[] = array(
                        "milestone_id" => $count,
                        "milestone_title" => $params['milestone_title'],
                        "milestone_desc" => $params['milestone_desc'],
                        "milestone_created_date" => $today_date,
                        "milestone_paid_date" => '',
                        "total_project_amount" => $project_price,
                        "current_milestone_amount" => $current_milestone_amount,
                        "milestone_amount_paid" => $paid_milestone_amount,
                        "milestone_remaining_amount" => $remaining_milestone_amount,
                        "milestone_status" => 'pending',
                    );

                    update_post_meta($project_id,'_project_milestone_data', $stored_milestone_data);
                    $return = array('message' => esc_html__( 'Milestone created', 'exertio_framework' ));
                    wp_send_json_success($return);
                }

            }
            else
            {
                $return = array('message' => esc_html__( 'You are not allowed to do that', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }
        else
        {
            $return = array('message' => esc_html__( 'Milestones can only be created for ongoing projects.', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}
/* PAY MILESTONE*/

add_action('wp_ajax_fl_pay_milestone', 'fl_pay_milestone');

if ( ! function_exists( 'fl_pay_milestone' ) )
{
    function fl_pay_milestone()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');

        check_ajax_referer( 'fl_gen_secure', 'security' );
        global $exertio_theme_options;
        global $wpdb;

        $project_id = $_POST['pid'];
        $milestone_id = $_POST['mid'];
        $current_user_id = get_current_user_id();
        $today_date = date("d-m-Y");
        $count = 0;


        $project_author_id = get_post_field( 'post_author', $project_id );
        if(get_post_status($project_id) == 'ongoing')
        {
            if($project_author_id == $current_user_id)
            {
                $stored_milestone_data = get_post_meta($project_id,'_project_milestone_data', true);
                if(!empty($stored_milestone_data))
                {
                    foreach($stored_milestone_data as $key => $val)
                    {
                        if ($val['milestone_id'] == $milestone_id)
                        {
                            $stored_milestone_data[$key]['milestone_status'] = 'paid';
                            $stored_milestone_data[$key]['milestone_amount_paid'] = $stored_milestone_data[$key]['current_milestone_amount'];
                            $stored_milestone_data[$key]['milestone_paid_date'] = $today_date;


                            $table = EXERTIO_PROJECT_LOGS_TBL;
                            if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
                            {
                                $query = "SELECT `freelancer_id`, `id` FROM ".$table." WHERE `project_id` = '" . $project_id . "' ";
                                $result = $wpdb->get_results($query);


                                $freelancer_id = $result[0]->freelancer_id;
                                $freelancer_user_id = get_post_field( 'post_author', $freelancer_id );
                                $ex_wallet_amount = get_user_meta( $freelancer_user_id, '_fl_wallet_amount', true );


                                $admin_commission_percent = fl_framework_get_options('project_charges');
                                $decimal_amount = $admin_commission_percent/100;
                                $admin_commission = $decimal_amount*$stored_milestone_data[$key]['current_milestone_amount'];
                                $freelancer_earning = $stored_milestone_data[$key]['current_milestone_amount'] - $admin_commission;


                                $get_project_cost = get_post_meta($project_id, '_project_remaining_cost', true);

                                $updated_project_cost = $get_project_cost - $stored_milestone_data[$key]['current_milestone_amount'];

                                update_post_meta($project_id, '_project_remaining_cost', sanitize_text_field($updated_project_cost));

                                $new_wallet_amount = $ex_wallet_amount + $freelancer_earning;

                                update_user_meta($freelancer_user_id, '_fl_wallet_amount',$new_wallet_amount);

                                $stored_milestone_data[$key]['current_milestone_amount'] = 0;
                                /*STATEMENT HOOK*/
                                do_action( 'exertio_transection_action',array('post_id'=> $project_id,'price'=>$freelancer_earning,'t_type'=>'project_milestone','t_status'=>'1', 'user_id'=> $freelancer_user_id));

                                if($admin_commission > 0 )
                                {
                                    do_action( 'exertio_transection_action',array('post_id'=> $project_id,'price'=>$admin_commission,'t_type'=>'project_milestone_comm','t_status'=>'2', 'user_id'=> $freelancer_user_id));
                                }
                            }
                        }
                    }
                    update_post_meta($project_id,'_project_milestone_data', $stored_milestone_data);
                    $return = array('message' => esc_html__( 'Milestone Paid', 'exertio_framework' ));
                    wp_send_json_success($return);
                }
            }
            else
            {
                $return = array('message' => esc_html__( 'You are not allowed to do that', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }
        else
        {
            $return = array('message' => esc_html__( 'Milestones can only be created for ongoing projects.', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}

// HIRE FREELANCER
add_action( 'wp_ajax_nopriv_hire_freelancer_call_back', 'hire_freelancer_call_back' );
add_action( 'wp_ajax_hire_freelancer_call_back', 'hire_freelancer_call_back' );
if (!function_exists ( 'hire_freelancer_call_back' ))
{
    function hire_freelancer_call_back()
    {
        /*DEMO DISABLED*/
        exertio_demo_disable('json');
        if(is_user_logged_in())
        {

            $c_user_id = get_current_user_id();

            check_ajax_referer( 'fl_hire_freelancer__secure', 'security' );

            $freelancer_id = $_POST['freelancer_id'];
            $frrelancer_post_author = get_post_field( 'post_author', $freelancer_id );
            if($c_user_id == $frrelancer_post_author )
            {
                $return = array('message' => esc_html__( 'You cannot invite yourself', 'exertio_framework' ));
                wp_send_json_error($return);
            }

            $params = array();
            parse_str($_POST['hire_freelancer_data'], $params);
            $project_id = $params['project-id'];

            $post_data = get_post($project_id);
            $post_author = $post_data->post_author;
            $post_title = $post_data->post_title;
            $post_link = get_the_permalink($project_id);
            if($c_user_id == $post_author )
            {
                fl_hire_freelancer_email($frrelancer_post_author,$post_title, $post_link);
                $return = array('message' => esc_html__( 'Invitation Sent', 'exertio_framework' ));
                wp_send_json_success($return);
                die();
            }
            else
            {
                $return = array('message' => esc_html__( 'Really sorry about that', 'exertio_framework' ));
                wp_send_json_error($return);
            }
        }
        else
        {
            $return = array('message' => esc_html__( 'Please login first', 'exertio_framework' ));
            wp_send_json_error($return);
        }

    }
}
/* Show Details on Search page*/

add_action('wp_ajax_fl_detail_search_page', 'fl_detail_search_page');
add_action('wp_ajax_nopriv_fl_detail_search_page', 'fl_detail_search_page');
if ( ! function_exists( 'fl_detail_search_page' ) ) {
    function fl_detail_search_page()
    {
        global $exertio_theme_options;
        $pid = $_POST['post_id'];

        $content_post = get_post($pid);
        $content = $content_post->post_content;
        $post_author = get_post_field( 'post_author', $pid );
        $employer_id =  get_user_meta( $post_author, 'employer_id' , true );
        $employer_profile = get_permalink($employer_id);
        $employer_img = get_profile_img($employer_id,'employer');
        $project_category = get_term( get_post_meta($pid, '_project_category', true));
        $project_cat = '';
        if(!empty($project_category) && ! is_wp_error($project_category))
        {
            $project_cat .= '<li>
                <div class="prf-cont">
                <i class="far fa-folder"></i>
                <span>'.esc_html($project_category->name).'</span>
                </div>
            </li>';
        }
        if(fl_framework_get_options('project_location') == 3)
        {

        }
        else
        {
            $location_remote = get_post_meta($pid, '_project_location_remote', true);
            $project_location = get_term( get_post_meta($pid, '_project_location', true));
            if(!empty($project_location) && ! is_wp_error($project_location) || $location_remote != '' && $location_remote != 0 )
            {
                if(isset($location_remote) && $location_remote == 1)
                {
                    $project_loc = esc_html__('Remote','exertio_theme');
                    }
                else
                {
                    if(!empty($project_location) && ! is_wp_error($project_location))
                    {
                        $project_loc = esc_html($project_location->name);
                        }
                }

                $project_cat .= '<li>
                    <div class="prf-cont">
                    <i class="fas fa-map-marker-alt"></i>
                        <span>'.$project_loc.'</span>
                    </div>
                </li>';
            }
        }
        $project_cat.='<li> <div class="prf-cont"> <i class="far fa-clock"></i>
                <span>'. date_i18n( get_option( 'date_format' ), strtotime( get_the_date() ) ).'</span></div></li>';

        $features = '';
        if(fl_framework_get_options('project_freelancer_type') == 3)
        {

        }
        else
        {

            $freelancer_type = get_term( get_post_meta($pid, '_project_freelancer_type', true));
            if(!empty($freelancer_type) && ! is_wp_error($freelancer_type))
            {
                $freelancer_name = esc_html($freelancer_type->name);
            }
            $features .='<li>
                <div class="ftr-icon">
                    <i class="far fa-address-card"></i>
                </div>
                <div class="ftr-txt">
                    <p>'.esc_html__('Freelancer Type ','exertio_theme').'</p>
                    <h4>
                        '.$freelancer_name.'
                    </h4>
                </div>
            </li>';
        }
        if(fl_framework_get_options('project_duration') == 3)
        {

        }
        else
        {
            $project_duration = get_term( get_post_meta($pid, '_project_duration', true));
            if(!empty($project_duration) && ! is_wp_error($project_duration))
            {
                $proj_duration = esc_html($project_duration->name);
            }
            $features .= '<li>
                <div class="ftr-icon">
                    <i class="far fa-calendar-alt"></i>
                </div>
                <div class="ftr-txt">
                    <p>'.esc_html__('Project Duration','exertio_theme').'</p>
                    <h4> '.$proj_duration.'</h4>
                </div>
            </li>';
        }
        if(fl_framework_get_options('project_level') == 3)
        {

        }
        else
        {
            $project_level = get_term( get_post_meta($pid, '_project_level', true));
            if(!empty($project_level) && ! is_wp_error($project_level))
            {
                $proj_level = esc_html($project_level->name);
            }
         $features.='  <li>
                <div class="ftr-icon">
                    <i class="fas fa-bezier-curve"></i>
                </div>
                <div class="ftr-txt">
                    <p>'.esc_html__('Level','exertio_theme').'</p>
                    <h4>'.$proj_level.'</h4>
                </div>
            </li>';
        }
        if(fl_framework_get_options('project_english_level') == 3)
        {

        }
        else
        {
            $project_english = get_term( get_post_meta($pid, '_project_eng_level', true));
            if(!empty($project_english) && ! is_wp_error($project_english))
            {
                $proj_english = esc_html($project_english->name);
            }
            $features .='<li>
                <div class="ftr-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="ftr-txt">
                    <p>'.esc_html__('English Level ','exertio_theme').'</p>
                    <h4>'.$proj_english.'</h4>
                </div>
            </li>';
        }
        if(fl_framework_get_options('project_languages') == 3)
        {

        }
        else
        {
        $saved_languages = wp_get_post_terms($pid, 'languages', array( 'fields' => 'all' ));
        if(!empty($saved_languages) && ! is_wp_error($saved_languages))
        {
            foreach($saved_languages as $saved_language)
            {
                $sav_language = $saved_language->name;
            }
        }
         $features.='<li>
                <div class="ftr-icon">
                    <i class="fas fa-language"></i>
                </div>
                <div class="ftr-txt">
                    <p>'.esc_html__('Languages','exertio_theme').'</p>
                    <h4>'.$sav_language.'</h4>
                </div>
            </li>';
        }

        $content_all =  wp_kses($content, exertio_allowed_html_tags());
        $skills = '';
        if(fl_framework_get_options('project_skills') == 3)
        {

        }
        else
        {
            $saved_skills = wp_get_post_terms($pid, 'skills', array( 'fields' => 'all' ));
            $Skills_detail='';
            if(!empty($saved_skills) && ! is_wp_error($saved_skills))
            {
                foreach($saved_skills as $saved_skill)
                {
                   $Skills_detail .=' <a href="javascript:void(0)">'.esc_html($saved_skill->name).'</a>';
                }
            }
            $skills .='<div class="fr-project-skills">
                <h3>'.esc_html__('Skills Required','exertio_theme').'</h3>
                '.$Skills_detail.'
            </div>';
        }
        if ($pid != '') {
            $html = '';
            $html .= ' <div class="detail_loader" style="position: relative">
                    <div class="loader-outer" style="display: none;">
                        <div class="loading-inner">
                            <div class="loading-inner-meta">
                                <div> </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="exer-fr-dtl">
                    <div class="profile">
                        <div class="prf-img">
                            <a href="'.$employer_profile.'">'.$employer_img.'</a>
                        </div>
                        <div class="prf-meta">
                            <h4>'.esc_html(get_the_title($pid)).'</h4>
                            <ul class="fr-project-meta">
                                '.$project_cat.'
                            </ul>
                        </div>
                    </div>
                    <div class="job-features-detail">
                        <div class="features">
                            <ul class="">
                            '.$features.'
                            </ul>
                        </div>
                    </div>
                    <div class="about-fr-descrip">
                        <h3>'.esc_html__('Description','exertio_theme').'</h3>
                        '.$content_all.'
                    </div>
                      '.$skills.'
                    <div class="dtl-btn">
                        <a class="view-btn btn-theme" target="_blank" href="'.esc_url(get_the_permalink($pid)).'">'.esc_html__('View Detail','exertio_theme').'</a>
                    </div>
                </div>';
            $return = array('html' => $html);
            wp_send_json_success($return);
        }else{
            $return = array('html' => esc_html__( 'No Result Found', 'exertio_framework' ));
            wp_send_json_error($return);
        }
    }
}