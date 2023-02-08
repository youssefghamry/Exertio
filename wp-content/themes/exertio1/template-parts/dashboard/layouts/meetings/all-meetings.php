<?php
global $exertio_theme_options;
$current_user_id = get_current_user_id();
$alt_id = '';
if (!function_exists('exertio_running_projects')) {

    function exertio_running_projects($current_user_id) {
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } else if (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $project_data = array();
        if (is_user_logged_in()) {
            $the_query = new WP_Query(
                    array(
                'author__in' => array($current_user_id),
                'post_type' => 'projects',
                'paged' => $paged,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                    )
            );
        }
        $all_projects = $the_query->posts;
        if (count($all_projects) > 0) {
            foreach ($all_projects as $key => $projects_data) {
                $project_data[] = $projects_data;
            }
        }
        return $project_data;
    }

}

$project_data = exertio_running_projects($current_user_id);

$ids = array();
foreach ($project_data as $pd) {
    $ids[] = $pd->ID;
}

//$proj_ids = implode(',', $ids);
$post_meeting = '';

if(is_array($ids) && !empty($ids)){

    $proj_ids = implode(',', $ids);
    
} else{

    $proj_ids = 0;
}


global $wpdb;
$query = "SELECT *  FROM $wpdb->postmeta WHERE post_id IN ($proj_ids) AND meta_key like '_zoom_meeting-%' ";
$total_count = count($wpdb->get_results($query));
$data_arr = array();
?>
<div class="content-wrapper">
    <div class="notch"></div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5">
                        <h2><?php echo esc_html__('All Meetings', 'exertio_theme') . esc_html(' (' . $total_count . ')'); ?></h2>
                        <div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
                            <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme'); ?>&nbsp;</p>
                            <?php echo exertio_dashboard_extention_return(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="pro-section">
                        <div class="pro-box heading-row">
                            <div class="pro-coulmn pro-title">
                            </div>
                            <div class="pro-coulmn"><?php echo esc_html__('Meeting Topic', 'exertio_theme') ?> </div>
                            <div class="pro-coulmn"><?php echo esc_html__('Meeting Duration', 'exertio_theme') ?> </div>
                            <div class="pro-coulmn"><?php echo esc_html__('Meeting Time', 'exertio_theme') ?> </div>
                        </div>
                        <?php
						if (is_array($project_data) && !empty($project_data)) {
							foreach ($project_data as $post) {

								$post_meeting = ($post->post_title);
								$query = "SELECT *  FROM $wpdb->postmeta WHERE post_id = '$post->ID' AND meta_key like '_zoom_meeting-%' ";
								$results = $wpdb->get_results($query);
								$total_count = $wpdb->num_rows;
								$data_arr = array();
								if ($results && $results != '') {
									foreach ($results as $result) {
										$value = isset($result->meta_value) ? $result->meta_value : "";
										$data_arr = $value != "" ? unserialize($value) : array();
										if (is_array($data_arr) && !empty($data_arr)) {
											$meeting_id = isset($data_arr['_exertio_meet_id']) ? $data_arr['_exertio_meet_id'] : "";
											$meeting_password = isset($data_arr['_exertio_meet_password']) ? $data_arr['_exertio_meet_password'] : "";
											$job_id = isset($data_arr['_exertio_job_id']) ? $data_arr['_exertio_job_id'] : "";
											$cand_id = isset($data_arr['_exertio_cand_id']) ? $data_arr['_exertio_cand_id'] : "";
											$topic = isset($data_arr['_exertio_meet_topic']) ? $data_arr['_exertio_meet_topic'] : "";
											$meeting_note = isset($data_arr['_exertio_meet_notes']) ? $data_arr['_exertio_meet_notes'] : "";
											$meeting_time = isset($data_arr['_exertio_meet_time']) ? $data_arr['_exertio_meet_time'] : "";
											$meeting_duration = isset($data_arr['_exertio_meet_duration']) ? $data_arr['_exertio_meet_duration'] : "";
											$meet_start_url = isset($data_arr['_exertio_meet_startURL']) ? $data_arr['_exertio_meet_startURL'] : "";
											$join_url = isset($data_arr['_exertio_meet_joinurl']) ? $data_arr['_exertio_meet_joinurl'] : "";
											$meet_host_email = isset($data_arr['_exertio_meet_host_email']) ? $data_arr['_exertio_meet_host_email'] : "";
											$zoom_meet_time = date_i18n("F j, Y g:i a", strtotime($meeting_time));
											?>
											<div class="pro-box">
												<div class="pro-coulmn pro-title">
													<h4 class="pro-name">
														<a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html($post_meeting); ?></a>
													</h4>
													<span class="pro-btns">
														<a href="<?php echo esc_attr($meet_start_url); ?>" class="btn btn-inverse-primary btn-sm"> <i class="far fa-phone-alt"></i> <?php echo esc_html__('Start Meeting', 'exertio_theme'); ?></a>
														<a href="javascript:void(0)" class="btn btn-inverse-warning btn-sm " id="meeting_deletion" data-pid="<?php echo esc_attr($job_id); ?>" data-meetid="<?php echo esc_attr($meeting_id); ?>" data-fl-id="<?php echo esc_attr($cand_id); ?>"> <i class="far fa-times-circle"></i> <?php echo esc_html__('Delete Meeting', 'exertio_theme'); ?></a>
													</span>
												</div>
												<div class="pro-coulmn">
													<?php
													echo esc_attr($topic);
													?>
												</div>
												<div class="pro-coulmn">
													<?php
													echo esc_attr($meeting_duration) . esc_html(' Minutes', 'exertio_theme');
													?>
												</div>
												<div class="pro-coulmn">
													<?php
													echo esc_attr($zoom_meet_time);
													?>
												</div>
											</div>
											<?php
										}
									}
								}
							}
						}
                        else {
                            ?>
                            <div class="nothing-found">
                                <h3><?php echo esc_html__('Sorry!!! No Record Found', 'exertio_theme') ?></h3>
                                <img src="<?php echo get_template_directory_uri() ?>/images/dashboard/nothing-found.png" alt="<?php echo get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE); ?>">
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    