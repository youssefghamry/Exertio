<?php
/* Zoom new meeting invitation */
if (!function_exists('exertio_zoom_meeting_proposal_invitation')) {


    function exertio_zoom_meeting_proposal_invitation($user_id, $post_id, $meeting_title, $url, $meeting_id, $meeting_pass, $meeting_note, $meetingTime, $meet_duration) {
        if (!empty($user_id) && !empty($post_id)) {

            $user_infos = get_userdata($user_id);

            $employer_id = get_user_meta($user_id, 'employer_id', true);
            $user_name = exertio_get_username('employer', $employer_id, '');

            $to = $user_infos->user_email;
            $subject = fl_framework_get_options('fl_email_zoom_meet_subject');
            $from = get_option('admin_email');
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

            $keywords = array('%site_name%', '%display_name%', '%admin_email%', '%project_link%', '%project_title%', '%meeting_title%', '%joinURL%', '%meeting_id%', '%meeting_password%', '%meeting_note%', '%meeting_duration%', '%meeting_time%');
            $replaces = array(wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES), $user_name, $from, get_the_permalink($post_id), get_the_title($post_id), $meeting_title, $url, $meeting_id, $meeting_pass, $meeting_note, $meet_duration, $meetingTime);
            $body = str_replace($keywords, $replaces, fl_framework_get_options('fl_email_zoom_meeting_email_body'));

            wp_mail($to, $subject, $body, $headers);
        }
    }

}

/* Zoom User Get Credentials */
add_action('wp_ajax_exertio_get_user_credentials', 'exertio_get_user_credentials');
if (!function_exists('exertio_get_user_credentials')) {

    function exertio_get_user_credentials() {


        $user_id = get_current_user_id();
        $params = array();
        parse_str($_POST['form_data'], $params);

        $zoom_reg_emails = sanitize_text_field($params['email_address']);
        $zoom_client_ids = sanitize_text_field($params['client_id']);
        $zoom_secret_keys = sanitize_text_field($params['client_secret']);
         update_user_meta($user_id, '_sb_zoom_email', ($zoom_reg_emails));
         update_user_meta($user_id, '_sb_zoom_client_id', ($zoom_client_ids));
         update_user_meta($user_id, '_sb_zoom_client_secret', ($zoom_secret_keys));

    }

}


/* Zoom Meetings */
add_action('wp_ajax_exertio_zoom_auth_user', 'exertio_zoom_auth_user');
if (!function_exists('exertio_zoom_auth_user')) {

    function exertio_zoom_auth_user() {
		
        $user_id = get_current_user_id();

        $zoom_client_ids = get_user_meta($user_id, 'zoom_client_id', true);
        // $zoom_secret_keys = get_user_meta($user_id, 'zoom_client_secret_key', true);
        // $zoom_reg_emails = get_user_meta($user_id, 'zoom_reg_email', true);

		
        // $zoom_reg_email = (isset($zoom_reg_emails) ? $zoom_reg_emails : '');
        // $zoom_client_id = (isset($zoom_client_ids) ? $zoom_client_ids : '');
        // $zoom_secret_key = (isset($zoom_secret_keys) ? $zoom_secret_keys : '');
        if ($zoom_client_ids != '') {

            

            $state = base64_encode('zoom_auth_state');
            $redirect_uri = home_url('/');

            echo "https://zoom.us/oauth/authorize?response_type=code&state=$state&client_id=$zoom_client_ids&redirect_uri=$redirect_uri";
            exit;
            /*$html = '';
            ob_start();
            ?>
            <script>

                var zoom_auth_window = window.open('https://zoom.us/oauth/authorize?response_type=code&state=<?php echo '' . ($state) ?>&client_id=<?php echo esc_html($zoom_client_id); ?>&redirect_uri=<?php echo esc_url($redirect_uri); ?>',
                        '', 'scrollbars=no,menubar=no,resizable=yes,toolbar=no,status=no,width=800, height=400');
                var auth_window_timer = setInterval(function () {
                    if (zoom_auth_window.closed) {
                        clearInterval(auth_window_timer);
                        //window.location.reload();
                    }
                }, 500);

            </script>
            <?php
            $html = ob_get_clean();*/
        }
        //wp_send_json(array('html' => $html));
    }

}


/* Zoom Meeting Creation Token Access */
add_action('wp', 'exertio_get_token_access_zoom');
if (!function_exists('exertio_get_token_access_zoom')) {

    function exertio_get_token_access_zoom() {

        $state = base64_encode('zoom_auth_state');
        if (isset($_GET['code']) && $_GET['code'] != '') {

            $user_id = get_current_user_id();
            $auth_code = $_GET['code'];
            $result_token = exertio_access_token_code_curl($auth_code);
            $result_token = json_decode($result_token, true);
//			print_r($result_token);
//			exit;
            if (isset($result_token['access_token']) && $result_token['access_token'] != "") {
                $access_token = $result_token['access_token'];
                $refresh_token = $result_token['refresh_token'];
                $message = __("Token Generated Successfully now you can use Zoom Meeting services", "exertio_theme");
                //echo '<script> alert("' . $message . '");</script>';
                update_user_meta($user_id, '_emp_zoom_main_token', $access_token);
                update_user_meta($user_id, '_emp_zoom_refresh_token', $refresh_token);
                //$return = array('message' => $message);
                //wp_send_json_success($return);

                echo '<script> 
                        window.opener.postMessage(true, "*"); //or true
                        window.close();
                    </script>';
                exit;
            } else {
                echo '<script> 
                            window.opener.postMessage(false, "*"); //or false
                            window.close();
                      </script>';
                exit;
            }
        }
    }

}
if (!function_exists('exertio_access_token_code_curl')) {

    function exertio_access_token_code_curl($auth_code) {

        $user_id = get_current_user_id();
        $client_id = get_user_meta($user_id, '_sb_zoom_client_id', true);
        $client_secret = get_user_meta($user_id, '_sb_zoom_client_secret', true);
        $data = array(
            'grant_type' => 'authorization_code',
            'code' => $auth_code,
            'redirect_uri' => home_url('/'),
        );
        $data_string = http_build_query($data);
        $auth_url = 'https://zoom.us/oauth/token';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $auth_url);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_POST, 1);
        // make sure we are POSTing
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        // allow us to use the returned data from the request
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //we are sending json
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret),
        ));
        $result_token = curl_exec($curl);
        curl_close($curl);
        return $result_token;
    }

}

/* Create or update Zoom Meeting Form */
add_action('wp_ajax_exertio_load_zoom_meeting_form', 'exertio_load_zoom_meeting_form_func');
if (!function_exists('exertio_load_zoom_meeting_form_func')) {

    function exertio_load_zoom_meeting_form_func() {

        $freelancer_id = isset($_POST['freelancer_id']) ? $_POST['freelancer_id'] : "";
        $project_id = isset($_POST['project_id']) ? $_POST['project_id'] : "";

        $meeting_info = get_post_meta($project_id, '_zoom_meeting-' . $freelancer_id, true);
        $meeting_id = ( isset($meeting_info['_exertio_meet_id']) && $meeting_info['_exertio_meet_id'] != "" ) ? $meeting_info['_exertio_meet_id'] : '';
        $meeting_topic = ( isset($meeting_info['_exertio_meet_topic']) && $meeting_info['_exertio_meet_topic'] != "" ) ? $meeting_info['_exertio_meet_topic'] : '';
        $meeting_date = ( isset($meeting_info['_exertio_meet_time']) && $meeting_info['_exertio_meet_time'] != "" ) ? $meeting_info['_exertio_meet_time'] : '';
        $meeting_time = ( isset($meeting_info['_exertio_meet_time']) && $meeting_info['_exertio_meet_time'] != "" ) ? $meeting_info['_exertio_meet_time'] : '';
        $meeting_note = ( isset($meeting_info['_exertio_meet_notes']) && $meeting_info['_exertio_meet_notes'] != "" ) ? $meeting_info['_exertio_meet_notes'] : '';
        $meeting_duration = ( isset($meeting_info['_exertio_meet_duration']) && $meeting_info['_exertio_meet_duration'] != "" ) ? $meeting_info['_exertio_meet_duration'] : '';
        $meeting_joinURL = ( isset($meeting_info['_exertio_meet_joinurl']) && $meeting_info['_exertio_meet_joinurl'] != "" ) ? $meeting_info['_exertio_meet_joinurl'] : '';
        $meeting_password = ( isset($meeting_info['_exertio_meet_password']) && $meeting_info['_exertio_meet_password'] != "" ) ? $meeting_info['_exertio_meet_password'] : '';
        $meeting_host_email = ( isset($meeting_info['_exertio_meet_host_email']) && $meeting_info['_exertio_meet_host_email'] != "" ) ? $meeting_info['_exertio_meet_host_email'] : '';
        $meeting_cand_id = ( isset($meeting_info['_exertio_cand_id']) && $meeting_info['_exertio_cand_id'] != "" ) ? $meeting_info['_exertio_cand_id'] : $freelancer_id;
        $meeting_job_id = ( isset($meeting_info['_exertio_job_id']) && $meeting_info['_exertio_job_id'] != "" ) ? $meeting_info['_exertio_job_id'] : $project_id;

        //If post meta exists
        $meetingBtn = esc_html__('Create Meeting', 'exertio');
        $title_text = esc_html__('Add Zoom Meeting', 'exertio');
        $is_update = 0;
        $form_name = 'zoom_form';
        if (isset($meeting_info) && $meeting_info != "") {
            $meetingBtn = 'Update Meeting';
            $title_text = esc_html__('Edit Zoom Meeting', 'exertio');
            $is_update = 1;
            $form_name = 'meeteing_modalform';
        }
        ?>  
        <div class="modal fade zoom-meeting-popup" id="dispute-modal" tabindex="-1" role="dialog" aria-labelledby="dispute-modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="stretch-card">
                            <div class="deposit-box card">
                                <div class="depoist-header">

                                    <div class="deposit-header-text">
                                        <h3> <?php echo esc_attr($title_text); ?></h3>
                                        <p><?php echo esc_html__('Please fill the form for Meetings', 'exertio_theme'); ?></p>
                                    </div>
                                </div>
                                <div class="deposit-body">
                                    <form class="zoom-metting-form" id="edit_meeteing_modal" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="form-group col-lg-12 col-md-3 col-xs-12 col-sm-3">                                    
                                                <label><?php echo esc_html__('Meeting Title:', 'exertio_theme'); ?></label>
                                                <input class="form-control" type="text" name="meeting_title" id ="meeting_title" required="" value="<?php echo esc_html($meeting_topic); ?>" required data-smk-msg="<?php echo esc_attr__('This field is required', 'exertio_theme'); ?>">      
                                            </div>
                                            <div class=" form-group col-lg-6 col-md-3 col-xs-12 col-sm-3"> 
                                                <label><?php echo esc_html__('Meeting Date:', 'exertio_theme'); ?></label> 
                                                <input class="form-control" type="date"  name="meeting_date" id ="meeting_date" required="" value="<?php echo esc_html($meeting_date); ?>" required data-smk-msg="<?php echo esc_attr__('This field is required', 'exertio_theme'); ?>">
                                            </div>
                                            <div class="col-lg-6 col-md-3 col-xs-12 col-sm-3"> 
                                                <label><?php echo esc_html__('Meeting Time:', 'exertio_theme'); ?></label> 
                                                <input class="form-control" type="time" name="meeting_time" id ="meeting_time" required="" value="<?php echo esc_html($meeting_time); ?>" required data-smk-msg="<?php echo esc_attr__('This field is required', 'exertio_theme'); ?>">
                                            </div>
                                            <div class="col-lg-12 col-md-3 col-xs-12 col-sm-3"><label><?php echo esc_html__('Meeting Duration (Minutes)', 'exertio_theme'); ?></label> 
                                                <input  value="<?php echo esc_html($meeting_duration); ?>" class="form-control account-members" required="" type="text" name="meeting_duration" id"meeting_duration" required data-smk-msg="<?php echo esc_attr__('This field is required', 'exertio_theme'); ?>"></div>        

                                            <div class="col-lg-12 col-md-3 col-xs-12 col-sm-3"> <label><?php echo esc_html__('Meeting Password', 'exertio_theme'); ?></label> 
                                                <input class="form-control" value="<?php echo esc_html($meeting_password); ?>" required="" type="text" name="meeting_password"  required data-smk-msg="<?php echo esc_attr__('This field is required', 'exertio_theme'); ?>"></div>    

                                            <div class="col-lg-12 col-md-3 col-xs-12 col-sm-3"> <label><?php echo esc_html__('Special Note', 'exertio_theme'); ?></label> 
                                                <input class="form-control" value="<?php echo esc_html($meeting_note); ?>" required="" type="textarea" rows="4" cols="50" name="meeting_note"  required data-smk-msg="<?php echo esc_attr__('This field is required', 'exertio_theme'); ?>"></div>    

                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="current_meeting_id"   id="current_meeting_id" value="<?php echo esc_attr($meeting_id); ?>" />
                                            <input type="hidden" name="current_job"   id="current_job" value="<?php echo esc_attr($meeting_job_id); ?>" />
                                            <input type="hidden" name="current_author" id="current_author" value="<?php echo esc_attr($meeting_cand_id); ?>" />
                                            <button type="submit" id ="btn_update_meeting" name="btn_update_meeting" class="btn-black btn_update_meeting zoom-metting-form-btn"><?php echo esc_html($meetingBtn); ?></button>
                                            <button type="button" id ="custom_close" class="btn-black" data-dismiss="modal"><?php echo esc_html__('Close', 'exertio_theme'); ?></button>
                                            <input type="hidden" id="fl_dispute_nonce" value="<?php echo wp_create_nonce('fl_dispute_secure'); ?>"  />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        die();
    }

}

/*  ========= Zoom Meeting Creation ======== */

add_action('wp_ajax_exertio_setup_zoom_meeting', 'exertio_setup_zoom_meeting');
if (!function_exists('exertio_setup_zoom_meeting')) {

    function exertio_setup_zoom_meeting() {


        $user_id = get_current_user_id();
        $params = array();

        parse_str($_POST['form_data'], $params);


        $current_job_id = sanitize_text_field($params['current_job']);

        // check if current user is the post author
        if ($user_id->ID != is_author()) {

            echo esc_html__('Something went wrong', 'exertio_theme');
            exit;
        } else {

            $meeting_id = sanitize_text_field($params['current_meeting_id']);
            $meet_date = sanitize_text_field($params['meeting_date']);
            $meet_title = sanitize_text_field($params['meeting_title']);
            $meet_time = sanitize_text_field($params['meeting_time']);
            $meet_note = sanitize_text_field($params['meeting_note']);
            $data_applier_id = sanitize_text_field($params['current_author']);
            $meet_duration = sanitize_text_field($params['meeting_duration']);
            $meet_password = sanitize_text_field($params['meeting_password']);
            $current_job_id = sanitize_text_field($params['current_job']);

            $meeting_time = date_i18n(DATE_ATOM, strtotime($meet_date . " " . $meet_time));
            $zoomData = get_post_meta($current_job_id, '_zoom_meeting-' . $data_applier_id, true);

            $meeting_id = ( isset($zoomData['_exertio_meet_id']) && $zoomData['_exertio_meet_id'] != "") ? $zoomData['_exertio_meet_id'] : $meeting_id;
			
            $emp_zoom_email = get_user_meta($user_id, '_sb_zoom_email', true);
            $access_token = get_user_meta($user_id, '_emp_zoom_main_token', true);
			

            $data = array(
                'schedule_for' => $emp_zoom_email,
                'topic' => $meet_title,
                'start_time' => $meeting_time,
                'timezone' => wp_timezone_string(),
                'duration' => $meet_duration,
                'agenda' => $meet_note,
                'password' => $meet_password,
            );

            if ($meeting_id != "") {
                $url = 'https://api.zoom.us/v2/meetings/' . $meeting_id;
                $data['id'] = $meeting_id;
            } else {
                $url = 'https://api.zoom.us/v2/users/me/meetings';
            }

            $data_str = json_encode($data, true);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if ($meeting_id != "") {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token,
            ));

            $result = curl_exec($ch);
            curl_close($ch);
			
            $result = json_decode($result, true);
            $final_result = array();
            $final_result['_exertio_meet_topic'] = $meet_title;
            $final_result['_exertio_meet_time'] = $meeting_time;
            $final_result['_exertio_meet_notes'] = $meet_note;
            $final_result['_exertio_meet_duration'] = $meet_duration;
            $final_result['_exertio_meet_password'] = $meet_password;
            $final_result['_exertio_cand_id'] = $data_applier_id;
            $final_result['_exertio_job_id'] = $current_job_id;

            if (isset($result['id']) && $result['id'] != "") {
                $final_result['_exertio_meet_id'] = $result['id'];
                $zoom_meet_time = isset($result['start_time']) ? $result['start_time'] : '';
                $meetingTime = date_i18n("F j, Y g:i a", strtotime($zoom_meet_time));

                $final_result['_exertio_meet_startURL'] = isset($result['start_url']) ? $result['start_url'] : '';
                $final_result['_exertio_meet_joinurl'] = isset($result['join_url']) ? $result['join_url'] : '';
                $final_result['_exertio_meet_host_email'] = isset($result['host_email']) ? $result['host_email'] : '';

                $zoom_meet_joinURL = isset($result['join_url']) ? $result['join_url'] : '';
                $meet_id = $final_result['_exertio_meet_id'];
                $joinURL = $final_result['_exertio_meet_joinurl'];
                update_post_meta($current_job_id, '_zoom_meeting-' . $data_applier_id, $final_result);


                /* Zoom Meeting Send Mail Notification function */
                exertio_zoom_meeting_proposal_invitation($user_id, $current_job_id, $meet_title, $joinURL, $meet_id, $meet_password, $meet_note, $meeting_time, $meet_duration);
				
				do_action( 'exertio_notification_filter',array('post_id'=> $current_job_id,'n_type'=>'zoom_meeting','sender_id'=>$user_id,'receiver_id'=>$data_applier_id, 'sender_type'=> 'employer') );

                $json_data = array('error' => '0', 'msg' => esc_html__('Meeting Created Succesfully', 'exertio_theme'));
                wp_send_json_success($json_data);
            }
			else if (!isset($result['id']) && $meeting_id != "")
			{
                $final_result['_exertio_meet_id'] = $meeting_id;
                update_post_meta($current_job_id, '_zoom_meeting-' . $data_applier_id, $final_result);
                /* Zoom Meeting Send Mail Notification function */
                exertio_zoom_meeting_proposal_invitation($user_id, $current_job_id, $meet_title, $joinURL, $meet_id, $meet_password, $meet_note, $meeting_time, $meet_duration);
				
				do_action( 'exertio_notification_filter',array('post_id'=> $current_job_id,'n_type'=>'zoom_meeting','sender_id'=>$user_id,'receiver_id'=>$data_applier_id, 'sender_type'=> 'employer') );

                $json_data = array('error' => '0', 'msg' => esc_html__('Meeting Updated Succesfully', 'exertio_theme'));
                wp_send_json_success($json_data);
            }
			else
			{
                $json_data = array('error' => '0', 'msg' => esc_html__('Get Authorized before creating/updating new Meeting1', 'exertio_theme'));
                wp_send_json_error($json_data);
            }
            die();
        }
    }

}
add_action('wp_ajax_exertio__zoom_delete_meet', 'exertio__zoom_delete_meet');
if (!function_exists('exertio__zoom_delete_meet')) {

    function exertio__zoom_delete_meet() {

        $user_id = get_current_user_id();
        $access_token = get_user_meta($user_id, '_emp_zoom_main_token', true);
        $meeting_id = isset($_POST['meeting_id']) ? $_POST['meeting_id'] : "";

        if (isset($meeting_id) && $meeting_id != "" && $access_token != '') {

            $freelancer_id = isset($_POST['freelancer_id']) ? $_POST['freelancer_id'] : "";
            $project_id = isset($_POST['project_id']) ? $_POST['project_id'] : "";

            $data = array(
                'id' => $meeting_id,
            );
            $data_str = json_encode($data, true);

            $url = 'https://api.zoom.us/v2/meetings/' . $meeting_id;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            // make sure we are POSTing
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
            // allow us to use the returned data from the request
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            //we are sending json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token,
            ));

            $result = curl_exec($ch);

            curl_close($ch);
            $results = json_decode($result, true);

            delete_post_meta($project_id, '_zoom_meeting-' . $freelancer_id, $results);

            $json_data = array('error' => '0', 'msg' => esc_html__('Meeting Deleted Succesfully', 'exertio_theme'));
            wp_send_json_success($json_data);
        } else {
            $json_data = array('error' => '0', 'msg' => esc_html__('Refresh token please before Creating/Updating new meeting', 'exertio_theme'));
            wp_send_json_error($json_data);
        }

        die();
    }

}