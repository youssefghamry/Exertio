<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();
$img_id ='';
$employer_id = get_user_meta( $current_user_id, 'employer_id' , true );
/*CHECKING PACKAGE VALIDITY*/
if(!isset($_GET['pid']))
{
	$is_prjects_paid = fl_framework_get_options('is_projects_paid');
	if(isset($is_prjects_paid) && $is_prjects_paid == 1)
	{
		$simple_projects = get_post_meta($employer_id, '_simple_projects', true);
		$employer_package_expiry_date = get_post_meta($employer_id, '_employer_package_expiry_date', true);

		$today_date = date("d-m-Y");

		
		if($simple_projects < 1 && $simple_projects != -1 || strtotime($employer_package_expiry_date) < strtotime($today_date))
		{
			echo exertio_redirect(get_the_permalink($exertio_theme_options['emp_package_page']).'?ext=buy-package');
		}
	}
}
	$is_update = '';
	$selected_custom_data = $fetch_custom_data = '';
	$custom_field_dispaly = 'style=display:none;';
	if(isset($_GET['pid']))
	{
		$pid = $_GET['pid'];
		$is_update = $pid;
		
		if(class_exists('ACF'))
		{
			$selected_custom_data = exertio_framework_fields_by_listing_id($pid);
			if(is_array($selected_custom_data))
			{
				if(!empty($selected_custom_data)) { $custom_field_dispaly = ''; }
				//$custom_field_dispaly = '';
				$fetch_custom_data = $selected_custom_data;
			}
		}
	}
	else
	{
		$pid = get_user_meta( $current_user_id, '_processing_post_id' , true );
		if(isset($pid) && $pid =='')
		{
			$my_post = array(
				'post_title' => '',
				'post_status' => 'pending',
				'post_author' => $current_user_id,
				'post_type' => 'projects'
			);
			$pid = wp_insert_post($my_post);
			update_user_meta( $current_user_id, '_processing_post_id', $pid );
			update_post_meta( $pid, '_project_is_featured', 0);	
		}
	}
	
	$post	=	get_post($pid);
	if($post == '')
	{
		$my_post = array(
			'post_title' => '',
			'post_status' => 'pending',
			'post_author' => $current_user_id,
			'post_type' => 'projects'
		);
		$pid = wp_insert_post($my_post);
		update_user_meta( $current_user_id, '_processing_post_id', $pid );
		update_post_meta( $pid, '_project_is_featured', 0);
		$post	=	get_post($pid);
	}
	$employer_departments = get_post_meta($pid, '_employer_department', true);
		if( $current_user_id == $post->post_author )
		{	
			?>
			<div class="content-wrapper">
			<div class="notch"></div>
			  <div class="row">
				<div class="col-md-12 grid-margin">
				  <div class="d-flex justify-content-between flex-wrap">
					<div class="d-flex align-items-end flex-wrap">
					  <div class="mr-md-3 mr-xl-5">
						<h2><?php echo esc_html__('Create Project','exertio_theme'); ?></h2>
						<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
							<p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
							<?php echo exertio_dashboard_extention_return(); ?>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="row">
				<div class="col-xl-8 col-lg-12 col-md-12 grid-margin stretch-card">
                    <?php
                    /*CHECK IF EMAIL IS VERIFIED*/
                    if(isset($exertio_theme_options['projects_with_email_verified']) &&  $exertio_theme_options['projects_with_email_verified'] == 0)
                    {
                        $is_verified = get_user_meta( $current_user_id, 'is_email_verified', true );
                        if($is_verified != 1 || $is_verified == '')
                        {
                            { ?>
                                <div class="alert alert-danger fade show" role="alert">
                                    <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
                                    <div class="alert-text"><?php echo esc_html__('You are not allowed to create a project.please verify your email first.','exertio_theme'); ?></div>
                                    <div class="alert-close">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true"><i class="fas fa-times"></i></i></span>
                                        </button>
                                    </div>
                                </div>
                            <?php }
                        }
                    }
						if(isset($_GET['pid']) && get_post_status($pid) == 'pending')
						{
							?>
							<div class="alert alert-warning fade show" role="alert">
								<div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
								<div class="alert-text"><?php echo esc_html__('Pending for admin Approval.','exertio_theme'); ?></div>
								<div class="alert-close">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true"><i class="fas fa-times"></i></i></span>
									</button>
								</div>
							</div>
							<?php
						}
						if(isset($exertio_theme_options['create_msg']) && $exertio_theme_options['create_msg'] != '')
						{
							?>
							<div class="card mb-4 info-box">
								<div class="card-body">
									<?php
									if(isset($exertio_theme_options['create_icon']) && $exertio_theme_options['create_icon'] != '')
									{
										echo '<i class="'.$exertio_theme_options['create_icon'].'"></i>';
									}
									echo '<p>'.$exertio_theme_options['create_msg'].'</p>';
									?>
								</div>
							</div>
							<?php
						}
						?>
					<form id="project_form" >
					  <div class="card mb-4">
						<div class="card-body">
						  <h4 class="card-title"><?php echo esc_html__('Basic Information','exertio_theme'); ?></h4>
						  <div class="form-row">
							<div class="form-group col-md-12">
							  <label><?php echo esc_html__('Project Title','exertio_theme'); ?></label>
							  <input type="text" class="form-control" name="project_name" value="<?php echo esc_attr($post->post_title); ?>" <?php if(fl_framework_get_options('project_title') == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please give title to your project','exertio_theme'); } ?>">
							</div>
                              <input type="hidden" id="is_update" name="is_update" value="<?php echo esc_attr($is_update); ?>" />
                          </div>
						  <div class="form-row">
							<div class="form-group col-md-6">
								  <label><?php echo esc_html__('Category','exertio_theme'); ?></label>
								   <?php 
								   $project_category = '';
									if(fl_framework_get_options('project_category') == 1)
									{
										$project_category = "required data-smk-msg='".esc_attr__("Please select suitable category","exertio_theme")."'"; 
									}
								  $category_taxonomies = exertio_get_terms('project-categories');
									if ( !empty($category_taxonomies) )
									{
										$car_id = '';
										if(class_exists('ACF')) { $car_id = 'id="exertio_cat_parent"'; } 
										
										echo '<select name="project_category" class="form-control general_select" '.$car_id.' '.$project_category.'>'.get_hierarchical_terms('project-categories', '_project_category', $pid ).'</select>';
									}
								?>
								</div>
							<?php
							if(fl_framework_get_options('project_freelancer_type') == 3)
							{
								
							}
							else
							{
								?>
								<div class="form-group col-md-6">
								  <label><?php echo esc_html__('Freelancer Type','exertio_theme'); ?></label>
								  <?php
								  
									$feelancer_type_chk = '';
									if(fl_framework_get_options('project_freelancer_type') == 1)
									{
										$feelancer_type_chk = "required data-smk-msg='".esc_attr__("Please select freelancer type","exertio_theme")."'"; 
									}
								  $freelancer_taxonomies = exertio_get_terms('freelancer-type');
									if ( !empty($freelancer_taxonomies) )
									{
										$freelancer_typel = get_post_meta($pid, '_project_freelancer_type', true);
										$freelancer = '<select name="freelancer_typel" class="form-control general_select" '.$feelancer_type_chk.'>';
										$freelancer .= '<option value=""> '. __( "Freelancer Type", "exertio_theme" ) .'</option>';
										foreach( $freelancer_taxonomies as $freelancer_taxonomy ) {
											if($freelancer_taxonomy->term_id == $freelancer_typel){ $selected = 'selected ="selected"';}else{$selected = ''; }
											if( $freelancer_taxonomy->parent == 0 ) {

												 $freelancer .= '<option value="'. esc_attr( $freelancer_taxonomy->term_id ) .'" '.$selected.'>
														'. esc_html( $freelancer_taxonomy->name ) .'</option>';
											}
										}
										$freelancer.='</select>';
										echo wp_return_echo($freelancer);
									}
								?>
								</div>
								<?php
							}
							?>
						  </div>
						  
						  <div class="form-row">
							<div class="form-group col-md-6">
							  <label><?php echo esc_html__('Price type','exertio_theme'); ?></label>
								<?php 
									$project_type = get_post_meta($pid, '_project_type', true);
									$show ='style=display:none;';
									$hide = 'style=display:block;';
									
									$disabled = 'disabled="disabled"';
									$not_disabled = '';
									if(isset($project_type) && $project_type == 'hourly' || isset($project_type) && $project_type == 2)
									{
										$show = 'style=display:block;';
										$hide = 'style=display:none;';
										
										$not_disabled = 'disabled="disabled"';
										$disabled = '';	
									}
								?>
								<select name="project_type" class="form-control general_select project-type" <?php if(fl_framework_get_options('project_cost') == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please select price type','exertio_theme'); } ?>" >
									<option value=""> <?php echo esc_html__( "Select price type", "exertio_theme" ); ?></option>
                                    <?php if(fl_framework_get_options('project_type_allowed') == 2 && (fl_framework_get_options('project_type_allowed') == 2)){ ?>
                                    <option value="2" <?php if($project_type== 'hourly' || $project_type== 2 ) {echo 'selected';} ?>><?php echo esc_html__('Hourly','exertio_theme'); ?></option>
                                    <?php }?>
									<option selected value="1" <?php if($project_type== 'fixed' || $project_type== 1) {echo 'selected';} ?>><?php echo esc_html__('Fixed','exertio_theme'); ?></option>
								</select>
							</div>

							<div class="form-group col-md-6 fixed-field" <?php echo esc_attr($hide); ?> >
                                <label for="project_cost_prepend"><?php echo esc_html__('Cost','exertio_theme');?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="project_cost_prepend"><?php echo $exertio_theme_options['fl_currency'] ;?></span>
                                    </div>
                                    <input type="number" class="form-control" aria-describedby="project_cost_prepend" id="project_cost_prepend" name="project_cost" value="<?php echo esc_attr(get_post_meta($pid, '_project_cost', true));?>" <?php if(fl_framework_get_options('project_cost') == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide project cost in Numbers','exertio_theme'); }?>" <?php echo esc_attr($not_disabled); ?> >
                                </div>
							</div>
							<div class="form-group col-md-6 hourly-field" <?php echo esc_attr($show); ?> >
                                <label for="project_cost_hourly_prepend"><?php echo esc_html__('Per Hour Price','exertio_theme'); ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="project_cost_prepend"><?php echo $exertio_theme_options['fl_currency'] ;?></span>
                                    </div>
                                    <input type="number" class="form-control" aria-describedby="project_cost_hourly_prepend" id="project_cost_hourly_prepend"  name="project_cost_hourly" value="<?php echo esc_attr(get_post_meta($pid, '_project_cost', true));?>" <?php if(fl_framework_get_options('project_cost') == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide per hour price','exertio_theme'); }?>" <?php echo esc_attr($disabled); ?>>
                                </div>
							</div>
							<div class="form-group col-md-12 hourly-field" <?php echo esc_attr($show); ?>>
							  <label><?php echo esc_html__(' Estimated Hours','exertio_theme'); ?></label>
							  <input type="text" class="form-control" name="estimated_hours" value="<?php echo esc_attr(get_post_meta($pid, '_estimated_hours', true));?>" <?php if(fl_framework_get_options('project_cost') == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide estimated hours','exertio_theme'); }?>" <?php echo esc_attr($disabled); ?>>
							</div>
						  </div>
						  <div class="form-row">
							<?php
							if(fl_framework_get_options('project_duration') == 3)
							{
								
							}
							else
							{
								$duration_chk = '';
								if(fl_framework_get_options('project_duration') == 1)
								{
									$duration_chk = 'required data-smk-msg="'.esc_attr__("Please select project duration","exertio_theme").'"'; 
								}
							
							?>
								<div class="form-group col-md-6">
									<label><?php echo esc_html__('Project Duration','exertio_theme'); ?></label>
								  <?php
									$duration_taxonomies = exertio_get_terms('project-duration');
									if ( !empty($duration_taxonomies) )
									{
										$project_duration = get_post_meta($pid, '_project_duration', true);
										$duration = '<select name="project_duration" class="form-control general_select" '.$duration_chk.'>';
										$duration .= '<option value=""> '. __( "Select Project Duration", "exertio_theme" ) .'</option>';
										foreach( $duration_taxonomies as $duration_taxonomy ) {
											if($duration_taxonomy->term_id == $project_duration){ $selected = 'selected ="selected"';}else{$selected = ''; }
											if( $duration_taxonomy->parent == 0 ) {
												//$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
												 $duration .= '<option value="'. esc_attr( $duration_taxonomy->term_id ) .'" '.$selected.'>
														'. esc_html( $duration_taxonomy->name ) .'</option>';
											}
										}
										$duration.='</select>';
										echo wp_return_echo($duration);
									}
									?>
								</div>
							<?php
							}
							if(fl_framework_get_options('project_level') == 3)
							{
								
							}
							else
							{
								$level_chk = '';
								if(fl_framework_get_options('project_level') == 1)
								{
									$level_chk = 'required data-smk-msg="'.esc_attr__("Please select project level","exertio_theme").'"'; 
								}
							
							?>
							<div class="form-group col-md-6">
								<label><?php echo esc_html__('Level','exertio_theme'); ?></label>
								<?php
								$level_taxonomies = exertio_get_terms('project-level');
								if ( !empty($level_taxonomies) )
								{
									$project_level = get_post_meta($pid, '_project_level', true);
									$level = '<select name="project_level" class="form-control general_select" '.$level_chk.'>';
									$level .= '<option value=""> '. __( "Select Project Level", "exertio_theme" ) .'</option>';
									foreach( $level_taxonomies as $level_taxonomy ) {
										if($level_taxonomy->term_id == $project_level){ $selected = 'selected ="selected"';}else{$selected = ''; }
										if( $level_taxonomy->parent == 0 ) {
											//$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
											 $level .= '<option value="'. esc_attr( $level_taxonomy->term_id ) .'" '.$selected.'>
													'. esc_html( $level_taxonomy->name ) .'</option>';
										}
									}
									$level.='</select>';
									echo wp_return_echo($level);
								}
								?>
							</div>
							<?php
							}
							if(fl_framework_get_options('project_english_level') == 3)
							{
								
							}
							else
							{
								$eng_level_chk = '';
								if(fl_framework_get_options('project_english_level') == 1)
								{
									$eng_level_chk = 'required data-smk-msg="'.esc_attr__("Please select english level","exertio_theme").'"'; 
								}
								?>
								<div class="form-group col-md-6">
								  <label><?php echo esc_html__('English Level','exertio_theme'); ?></label>
								  <?php
								  $english_taxonomies = exertio_get_terms('english-level');
									if ( !empty($english_taxonomies) )
									{
										$english_level = get_post_meta($pid, '_project_eng_level', true);
										$english = '<select name="english_level" class="form-control general_select" '.$eng_level_chk.'>';
										$english .= '<option value=""> '. __( "Select English Level", "exertio_theme" ) .'</option>';
										foreach( $english_taxonomies as $english_taxonomy ) {
											if($english_taxonomy->term_id == $english_level){ $selected = 'selected ="selected"';}else{$selected = ''; }
											if( $english_taxonomy->parent == 0 ) {
												//$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
												 $english .= '<option value="'. esc_attr( $english_taxonomy->term_id ) .'" '.$selected.'>
														'. esc_html( $english_taxonomy->name ) .'</option>';
											}
										}
										$english.='</select>';
										echo wp_return_echo($english);
									}
								?>
								</div>
							<?php
							}
							if(fl_framework_get_options('project_location') == 3)
							{
								
							}
							else
							{
								$location_chk = '';
								if(fl_framework_get_options('project_location') == 1)
								{
									$location_chk = 'required data-smk-msg="'.esc_attr__("Please select location","exertio_theme").'"'; 
								}
								?>
								<div class="form-group col-md-6">
									  <label><?php echo esc_html__('Location','exertio_theme'); ?></label>
									  <?php
										$remote_selected = $locatipm_disabled = '';
										$project_location_remote = get_post_meta($pid,'_project_location_remote', true);
										if(isset($project_location_remote) && $project_location_remote == 1)
										{
											$remote_selected = 'checked="checked"';
											$locatipm_disabled = 'disabled="disabled"';
										}
									  $location_taxonomies = exertio_get_terms('locations');
										if ( !empty($location_taxonomies) )
										{
											echo '<select name="project_location" class="form-control general_select project_location" '.$location_chk.' '.$locatipm_disabled.'>'.get_hierarchical_terms('locations','_project_location', $pid ).'</select>';
										}

									?>
									<span class="remote-location-box">
										<div class="pretty p-icon p-thick p-curve">
											<input type="checkbox" name="project_location_remote" id="project_location_remote" <?php echo wp_return_echo($remote_selected); ?>/>
											<div class="state p-warning"><i class="icon fa fa-check"></i>
												<label></label>
											</div>
										</div>
										<p> <?php echo esc_html__('Check this for remote location','exertio_theme'); ?></p>
									</span>
								 </div>
								<?php
							}
							?>
						  </div>
						  <?php
							if(fl_framework_get_options('project_skills') == 3)
							{
								
							}
							else
							{
								$skills_chk = '';
								if(fl_framework_get_options('project_skills') == 1)
								{
									$skills_chk = 'required data-smk-msg="'.esc_attr__("Please select skills","exertio_theme").'"'; 
								}
							
								?>
							  <div class="form-row">
								<div class="form-group col-md-12">
								  <label><?php echo esc_html__('Skills','exertio_theme'); ?></label>
								  <?php
								  $skills_taxonomies = exertio_get_terms('skills');
								  $saved_skills = wp_get_post_terms($pid, 'skills', array( 'fields' => 'all' ));
									if ( !empty($skills_taxonomies) )
									{
										$skill_meta = get_post_meta($pid, '', true);
										$skill = '<select name="project_skills[]" class="form-control multi_select" multiple="multiple" '.$skills_chk.'>';
										$skill .= '<option value=""> '. __( "Select required skills", "exertio_theme" ) .'</option>';
										foreach( $skills_taxonomies as $skills_taxonomy ) {
											if(in_array($skills_taxonomy, $saved_skills) ){ $skill_selected = 'selected ="selected"';}else{ $skill_selected='';}
											if( $skills_taxonomy->parent == 0 ) {
												//$output.= '<optgroup label="'. esc_attr( $category->name ) .'">';
												 $skill .= '<option value="'. esc_attr( $skills_taxonomy->term_id ) .'" '.$skill_selected.'>
														'. esc_html( $skills_taxonomy->name ) .'</option>';
											}
										}
										$skill.='</select>';
										echo wp_return_echo($skill);
									}
								?>
								</div>
							  </div>
							  <?php
							}
							if(fl_framework_get_options('project_languages') == 3)
							{
								
							}
							else
							{
								$languages_chk = '';
								if(fl_framework_get_options('project_languages') == 1)
								{
									$languages_chk = 'required data-smk-msg="'.esc_attr__("Please select skills","exertio_theme").'"'; 
								}
							
								?>
								  <div class="form-row">
									<div class="form-group col-md-12">
									  <label><?php echo esc_html__('Languages','exertio_theme'); ?></label>
									  <?php
									  $language_taxonomies = exertio_get_terms('languages');
									  $saved_language = wp_get_post_terms($pid, 'languages', array( 'fields' => 'all' ));
										if ( !empty($language_taxonomies) )
										{
											$language_meta = get_post_meta($pid, '_freelancer-type', true);
											$language = '<select name="project_languages[]" class="form-control multi_select" multiple="multiple" '.$languages_chk.'>';
											$language .= '<option value=""> '. __( "Select languages", "exertio_theme" ) .'</option>';
											foreach( $language_taxonomies as $language_taxonomy ) {
												if(in_array($language_taxonomy, $saved_language) ){ $language_selected = 'selected ="selected"';}else{ $language_selected='';}
												if( $language_taxonomy->parent == 0 ) {
													 $language .= '<option value="'. esc_attr( $language_taxonomy->term_id ) .'" '.$language_selected.'>
															'. esc_html( $language_taxonomy->name ) .'</option>';
												}
											}
											$language.='</select>';
											echo wp_return_echo($language);
										}
									?>
									</div>
								  </div>
								<?php
							}
							?>
						</div>
					  </div>
					  <div class="card mb-4 additional-fields" <?php echo esc_attr($custom_field_dispaly)?> >
						<div class="card-body">
						  <h4 class="card-title"><?php echo esc_html__('Additional fields','exertio_theme'); ?></h4>
							<div class="additional-fields-container">
								<?php
									if(is_array($selected_custom_data) && !empty($selected_custom_data)) {
										if ($is_update != '' && $pid != '' && class_exists('ACF')) {
											$custom_fields_html = apply_filters('exertio_framework_acf_frontend_html', '', $selected_custom_data);
											echo $custom_fields_html;
										}
									}
							 ?>
							</div>
						</div>
					  </div>
					  <div class="card mb-4">
						<div class="card-body">
						  <h4 class="card-title"><?php echo esc_html__('Project Detail','exertio_theme'); ?></h4>
						  <div class="form-row">
								<div class="form-group col-md-12">                  	
									<label> <?php echo esc_html__('Description','exertio_theme'); ?></label> 
									<textarea name="project_desc" class="form-control fl-textarea" id="" placeholder="<?php echo esc_attr__('description here','exertio_theme'); ?>"><?php echo esc_html($post->post_content); ?></textarea>
								</div>
							</div>
						</div>
					  </div>
					  <div class="card mb-4">
					  <?php $pro_img_id = get_post_meta( $pid, '_project_attachment_ids', true ); ?>
						<div class="card-body project-attachments">
						  <h4 class="card-title"><?php echo esc_html__('Upload Attachments','exertio_theme'); ?></h4>
						  <div class="form-row">
								<div class="form-group col-md-12"> 
									<label> <?php echo esc_html__('Want to upload attachments?','exertio_theme'); ?></label> 
									<div class="pretty p-switch p-fill ">
										<?php $pro_attactment_show = get_post_meta( $pid, '_project_attachment_show', true ); ?>
										<input type="checkbox" name="is_show_project_attachments" class="attachment_switch" <?php if(isset($pro_attactment_show) && $pro_attactment_show =='yes') { echo 'checked';} ?> value="0"/>
										<div class="state p-info"><label></label> </div>
									</div>
								</div>
							</div>
							<?php
							
							$display = '';
							if(isset($pro_attactment_show) && $pro_attactment_show =='yes')
							{
								$display = 'style=display:block;';	
							}
							?>
							<div class="form-row img-wrapper" <?php echo esc_attr($display); ?>>
								<div class="form-group col-md-12">
									<div class="upload-btn-wrapper">
										<button class="btn btn-theme-secondary mt-2 mt-xl-0" type="button"><?php echo esc_html__('Upload attachments','exertio_theme'); ?></button>
										<input type="file" id="project_attachments" multiple name="project_attachments[]" accept = "image/pdf/doc/docx/ppt/pptx*" data-post-id="<?php echo esc_attr($pid) ?>"/>
										<input type="hidden" name="attachment_ids" value="" id="attachments_ids">
									</div>
								</div>
							</div>
							
							<div class="form-row" >
								 <div class="form-group col-md-12 attachment-box sortable" <?php echo esc_attr($display); ?>> 
								 <?php
									if(isset($pro_img_id) && $pro_img_id != '')
										{
											$atatchment_arr = explode( ',', $pro_img_id );
											foreach ($atatchment_arr as $value)
											{
												$icon = get_icon_for_attachment($value);

													$filename = basename(wp_get_attachment_url($value));
													echo '<div class="attachments ui-state-default  pro-atta-'.$value.'">
															<img src="'.$icon.'" alt="'.get_the_title($value).'" class="img-fluid" data-img-id="'.$value.'">
															<span class="attachment-data">
																<h4>'.$filename.'</h4>
																<p>'.esc_html__('file size','exertio_theme').' '.size_format(filesize(get_attached_file( $value ))).'</p>
																<a href="javascript:void(0)" class="btn-pro-clsoe-icon" data-id="'.$value.'" data-pid="'.$pid.'"> <i class="fas fa-times"></i></a>
															</span>
														</div>';
											}
										}
									?>
								</div>
								<input type="hidden" class="project_attachment_ids" name="project_attachment_ids" value="<?php echo esc_attr($pro_img_id); ?>">
								<p class="attachment_note"><?php echo esc_html__('Drag & drop to rearrange and press save button to apply.','exertio_theme'); ?></p>
							</div>
	
	
						</div>
					  </div> 
					  <?php
						if(fl_framework_get_options('project_address') == 3)
						{
							
						}
						else
						{
						?>
						  <div class="card mb-4">
							<div class="card-body">
							  <h4 class="card-title"><?php echo esc_html__('Address Information','exertio_theme'); ?></h4>
							  
						   <?php 
					
								$latitude = get_post_meta( $pid, '_employer_latitude', true );	
								$longitude = get_post_meta( $pid, '_employer_longitude', true );
								if($latitude == "" || $longitude == "")
								{
									$latitude = $exertio_theme_options['default_lat'];
									$longitude = $exertio_theme_options['default_long'];									
								}								
							?>
							<script>
								(function ($) {
									'use strict';
									$( document ).ready(function() {
										var markers = [
														{
															'title': '',
															'lat': <?php echo esc_html($latitude); ?>,
															'lng': <?php echo esc_html($longitude); ?>,
														},
													];
										var mapOptions = {
													center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
													zoom: 12,
													mapTypeId: google.maps.MapTypeId.ROADMAP
												};
										var map = new google.maps.Map(document.getElementById('google_canvas'), mapOptions);
										var latlngbounds = new google.maps.LatLngBounds();
										var geocoder = geocoder = new google.maps.Geocoder();
										var data = markers[0]
										var myLatlng = new google.maps.LatLng(data.lat, data.lng);
										var marker = new google.maps.Marker({
														position: myLatlng,
														map: map,
														title: data.title,
														draggable: true,
														animation: google.maps.Animation.DROP
													});
										(function (marker, data) {
											google.maps.event.addListener(marker, 'click', function (e) {
												infoWindow.setContent(data.description);
												infoWindow.open(map, marker);
											});

											google.maps.event.addListener(marker, 'dragend', function (e) {
												// document.getElementById('sb_loading').style.display	= 'block';
												var lat, lng, address;
												geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {

													if (status == google.maps.GeocoderStatus.OK) {
														lat = marker.getPosition().lat();
														lng = marker.getPosition().lng();
														address = results[0].formatted_address;

														document.getElementById('searchMapInput').value = address;
														document.getElementById('loc_lat').value = lat;
														document.getElementById('loc_long').value = lng;
														//document.getElementById('sb_loading').style.display	= 'none';
													}
												});
											});
										})(marker, data);
										latlngbounds.extend(marker.position);
										function initMap() {
											var input = document.getElementById('searchMapInput');
											var autocomplete = new google.maps.places.Autocomplete(input);
											autocomplete.addListener('place_changed', function() {
												var place = autocomplete.getPlace();
												$('#location-snap').val(place.formatted_address);
												$('#loc_lat').val(place.geometry.location.lat());
												$('#loc_long').val(place.geometry.location.lng());

												var markers = [
																{
																	'title': '',
																	'lat': place.geometry.location.lat(),
																	'lng': place.geometry.location.lng(),
																},
															];
												var mapOptions = {
																center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
																zoom: 12,
																mapTypeId: google.maps.MapTypeId.ROADMAP
															};
															var infoWindow = new google.maps.InfoWindow();
															var latlngbounds = new google.maps.LatLngBounds();
															var geocoder = geocoder = new google.maps.Geocoder();
															var map = new google.maps.Map(document.getElementById('google_canvas'), mapOptions);
															var data = markers[0]
															var myLatlng = new google.maps.LatLng(data.lat, data.lng);
															var marker = new google.maps.Marker({
																position: myLatlng,
																map: map,
																title: data.title,
																draggable: true,
																animation: google.maps.Animation.DROP
															});

												var map = new google.maps.Map(document.getElementById('google_canvas'), mapOptions);
												var marker = new google.maps.Marker({
															position: myLatlng,
															map: map,
															title: data.title,
															draggable: true,
															animation: google.maps.Animation.DROP
														});
												(function (marker, data) {
																				google.maps.event.addListener(marker, 'click', function (e) {
																					infoWindow.setContent(data.description);
																					infoWindow.open(map, marker);
																				});
																				google.maps.event.addListener(marker, 'dragend', function (e) {
																					// document.getElementById('sb_loading').style.display	= 'block';
																					var lat, lng, address;
																					geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {

																						if (status == google.maps.GeocoderStatus.OK) {
																							lat = marker.getPosition().lat();
																							lng = marker.getPosition().lng();
																							address = results[0].formatted_address;

																							document.getElementById('searchMapInput').value = address;
																							document.getElementById('loc_lat').value = lat;
																							document.getElementById('loc_long').value = lng;
																							//document.getElementById('sb_loading').style.display	= 'none';
																						}
																					});
																				});
																			})(marker, data);
																			latlngbounds.extend(marker.position);

											});
										}
										initMap();
									});
									})(jQuery);
								</script>
							  <div class="form-row">
								<div class="form-group col-md-12">
								  <label><?php echo esc_html__('Address','exertio_theme'); ?></label>
								  <input type="text" class="form-control" name="project_address" id="searchMapInput" value="<?php echo get_post_meta($pid, '_project_address', true); ?>" <?php if(fl_framework_get_options('project_address') == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide address','exertio_theme'); }?>">
								  <i class=" mdi mdi-target" id="abc"></i>
								</div>
								<div class="form-group col-md-12">
								  <div id="google_canvas" style="width:100%; height:400px;"></div>
								</div>
							  </div>
							  <div class="form-row">
								<div class="form-group col-md-6">
								  <label><?php echo esc_html__('Latitude','exertio_theme'); ?></label>
								  <input type="text" class="form-control" name="project_lat" id="loc_lat" value="<?php echo get_post_meta($pid, '_project_longitude', true); ?>">
								</div>
								<div class="form-group col-md-6">
								  <label><?php echo esc_html__('Longitude','exertio_theme'); ?></label>
								  <input type="text" class="form-control" name="project_long" id="loc_long" value="<?php echo get_post_meta($pid, '_project_latitude', true); ?>">
								</div>
							  </div>
							</div>
						  </div>
						<?php
						}
						?>
						<div class="card">
							<div class="card-body">
								<div class="featured-box">
									<?php
										$is_featured = get_post_meta($pid, '_project_is_featured', true);
										if($is_featured == 0 )
										{
											$featured_projects = get_post_meta($employer_id, '_featured_projects', true);
											if(isset($featured_projects) && $featured_projects > 0 || $featured_projects == '-1' )
											{
												?>
												<div class="pretty p-icon p-thick p-curve">
													<input type="checkbox" name="project_featured" />
													<div class="state p-warning">
														<i class="icon fa fa-check"></i>
														<label></label>
													</div>
												</div>
												<h4><?php echo esc_html(fl_framework_get_options('mark_featured_title'));  ?></h4>
												<p><?php echo esc_html(fl_framework_get_options('mark_featured_desc'));  ?></p>
												<?php
											}
											else
											{
												?>
												<div class="alert alert-warning fade show" role="alert">
													<div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
													<div class="alert-text"><?php echo esc_html__('Purchase package to mark your project featured.','exertio_theme'); ?></div>
													<div class="alert-close">
														<a href="<?php echo esc_html(get_the_permalink(fl_framework_get_options('emp_package_page')));  ?>" class="btn btn-dark" target="_blank">
															<?php echo esc_html__('Buy Package','exertio_theme'); ?>
														</a>
													</div>
												</div>
												<?php
											}
										}
										else if($is_featured == 1)
										{
											?>
											<h4><?php echo esc_html__('Already Featured','exertio_theme');  ?></h4>
											<p><?php echo esc_html(fl_framework_get_options('mark_featured_desc'));  ?></p>
											<?php
										}
									?>

								</div>
								<button type="button" class="btn btn-theme" id="create_project_btn" data-post-id="<?php echo esc_attr($pid) ?>">
										<?php 
											if(isset($is_update) && $is_update =='')
											{
												echo esc_html__('Create Project','exertio_theme');
											}
											else
											{
												echo esc_html__('Update Project','exertio_theme');
											}
										?>
										<input type="hidden" id="create_project_nonce" value="<?php echo wp_create_nonce('fl_create_project_secure'); ?>"  />
								</button>
							</div>
						  </div>
					</form>
				</div>
				<div class="col-xl-4 col-lg-12 col-md-12 grid-margin stretch-card">
					<?php
					if(isset($exertio_theme_options['tips_switch']) && $exertio_theme_options['tips_switch'] == 1)
					{
					?>
					<div class="card mb-4 vector-bg tips">
						<div class="card-body">
						<h4 class="card-title"><?php echo esc_html__('Tips for posting a project','exertio_theme'); ?></h4>
						  <?php
							$count = 1;
							foreach($exertio_theme_options['project_slides'] as $single_slide)
							{
						  ?>
							  <h4> <?php echo esc_html($count.'. '.$single_slide['title']) ?></h4>
							  <p> <?php echo esc_html($single_slide['description']) ?></p>
						  <?php
								$count++;
							}
							?>
						</div>
					  </div>
					<?php
					}
					?>
					<div class="card mb-4 tips package-info">
						<div class="card-body">
				  <h4 class="card-title"><?php echo esc_html__('Current Plan Detail', 'exertio_theme' ); ?></h4>
					<p class="view-more-btn"> <a href="<?php echo get_the_permalink(fl_framework_get_options('emp_package_page')); ?>?ext=buy-package" target="_blank"> <?php echo esc_html__(' View Plans ', 'exertio_theme' ); ?></a></p>
					<?php
						$employer_id = get_user_meta( $current_user_id, 'employer_id' , true );

						$simple_project = get_post_meta( $employer_id, '_simple_projects', true);
						$simple_project_text = isset( $simple_project) && $simple_project == -1 ? esc_html__(' Unlimited ', 'exertio_theme' ) : $simple_project;
					
						$simple_project_expiry = get_post_meta( $employer_id, '_simple_project_expiry', true);
						$simple_project_expiry_text = isset( $simple_project_expiry) && $simple_project_expiry == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : $simple_project_expiry.esc_html__(' Days ', 'exertio_theme' );
					
						$featured_projects = get_post_meta( $employer_id, '_featured_projects', true);
						$featured_projects_text = isset( $featured_projects) && $featured_projects == -1 ? esc_html__(' Unlimited ', 'exertio_theme' ) : $featured_projects;

						$featured_project_expiry = get_post_meta( $employer_id, '_featured_project_expiry', true);
						$featured_project_expiry_text = isset( $featured_project_expiry) && $featured_project_expiry == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : $featured_project_expiry.esc_html__(' Days ', 'exertio_theme' );

						$employer_package_expiry = get_post_meta( $employer_id, '_employer_package_expiry', true);
					
						$employer_package_expiry_date = get_post_meta( $employer_id, '_employer_package_expiry_date', true);
					
						$package_expiry_text = isset( $employer_package_expiry_date) && $employer_package_expiry_date == -1 ? esc_html__(' Never Expire ', 'exertio_theme' ) : date_i18n( get_option( 'date_format' ), strtotime($employer_package_expiry_date));
					
						$employer_is_featured = get_post_meta( $employer_id, '_employer_is_featured', true);
						$employer_featured_text = isset( $employer_is_featured) && $employer_is_featured > 0 ? 'Yes' : 'No';
					if(isset($simple_project) && $simple_project != '')
					{
						$img_id = '';
						?>
						<ul>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Project Allowed: ', 'exertio_theme' ).'</span>'.esc_html($simple_project_text)?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Project Expiry: ', 'exertio_theme' ).'</span>'.esc_html($simple_project_expiry_text) ?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Featured Projects: ', 'exertio_theme' ).'</span>'.esc_html($featured_projects_text);?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Featured Projects Expiry: ', 'exertio_theme' ).'</span>'.esc_html($featured_project_expiry_text); ?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Featured Profile: ', 'exertio_theme' ).'</span>'.esc_html($employer_featured_text); ?> </li>
							<li><img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/success.png" alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', TRUE)); ?>"> <?php echo '<span>'.esc_html__('Package Expiry: ', 'exertio_theme' ).'</span>'.esc_html($package_expiry_text) ?> </li>
						</ul>
						<?php
					}
					else
					{
						echo '<p>'.esc_html__(' No package detail available', 'exertio_theme' ).'</p>';
					}
					?>
			  </div>
					  </div>
				</div>

			  </div>
			</div>
			<?php
		}
		else
		{
			echo exertio_redirect(home_url('/'));
		}
	?>