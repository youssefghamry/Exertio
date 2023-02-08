<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();

$pid = get_user_meta( $current_user_id, 'freelancer_id' , true );
$post	=	get_post($pid);

$user_info = get_userdata($current_user_id);
$user_name = $user_info->display_name;

$pro_img_id = get_post_meta( $pid, '_profile_pic_freelancer_id', true );
$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );


$selected_custom_data = $fetch_custom_data = '';
$custom_field_dispaly = 'style=display:none;';
if(class_exists('ACF'))
{
	$selected_custom_data = exertio_freelancer_fields_by_listing_id($pid);
	if(is_array($selected_custom_data))
	{
		if(!empty($selected_custom_data)) { $custom_field_dispaly = ''; }
		//$custom_field_dispaly = '';
		$fetch_custom_data = $selected_custom_data;
	}
}
if ($current_user_id == '') {
	echo exertio_redirect(home_url('/'));
	exit;
}
else
{
?>
       <div class="content-wrapper">
        <div class="notch"></div>
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2><?php echo esc_html__('Edit Profile','exertio_theme'); ?></h2>
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
          	<div class="col-xl-4 col-lg-12 col-md-12 grid-margin stretch-card">
            	<div class="card mb-4 vector-bg">
                <div class="card-body">
                  <div class="profile-card">
                    <div class="profile-cardmeta">
                    	<span class="profile-name mb-2"><?php echo exertio_get_username('freelancer',$pid, 'badge', 'right'); ?> </span>
                        <span class="p-email mb-2"> @<?php echo esc_html($post->post_title); ?></span>
                        <a href="<?php  echo esc_url(get_permalink($pid)); ?>" class=""><?php echo esc_html__('View Profile','exertio_theme'); ?></a>
                    </div>
                    <div class="cardmeta-footer">
                    	<ul class="profile-details">
                            <li>
                                <i class="far fa-envelope"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_attr($user_info->user_email); ?></span>
                                </div>
                            </li>
                            <li>
                                <i class="fas fa-signature"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_html(get_post_meta( $pid, '_freelancer_tagline' , true )); ?></span>
                                </div>
                            </li>
                            <li>
                                <i class="fas fa-mobile-alt"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_html(get_post_meta( $pid, '_freelancer_contact_number' , true )); ?></span>
                                </div>
                            </li>
                            
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_html( get_post_meta($pid, '_freelancer_address', true)); ?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-widget mb-4">
                   <h4 class="card-title"><?php echo esc_html__('Change Password','exertio_theme'); ?></h4>
                  <div class="card">
                    
                    <div class="card-body">
                     
                      <form id="change_pass_form">
                          <div class="form-row">
                            <div class="form-group col-md-12">
                              <label><?php echo esc_html__('Old Password','exertio_theme'); ?></label>
                              <input type="password" class="form-control" name="old_password" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('Please provide current password','exertio_theme'); ?>">
                            </div>
                            <div class="form-group col-md-12">
                              <label><?php echo esc_html__('New Password','exertio_theme'); ?></label>
                              <input type="password" class="form-control" name="new_password" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('Enter new password. Minimum 6 characters','exertio_theme'); ?>">
                            </div>
                            <div class="form-group col-md-12">
                              <label><?php echo esc_html__('Confirm Password','exertio_theme'); ?></label>
                              <input type="password" class="form-control" name="confirm_password" autocomplete="off" required data-smk-msg="<?php echo esc_attr__('confirm password required','exertio_theme'); ?>">
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-theme" id="change_password_btn" data-post-id="<?php echo esc_attr($pid) ?>">
                                    <?php echo esc_html__('Change Password','exertio_theme'); ?>
                                </button>
                                <input type="hidden" id="change_psw_nonce" value="<?php echo wp_create_nonce('fl_change_psw_secure'); ?>"  />
                            </div>
                          </div>
                      </form>
                    </div>
                  </div>
              </div>
              <?php
			  	if(isset($exertio_theme_options['delete_account']) && $exertio_theme_options['delete_account'] == true)
				{
			  ?>
                  <div class="card-widget">
                       <h4 class="card-title"><?php echo esc_html__('Delete Account','exertio_theme'); ?></h4>
                      <div class="card">
                        
                        <div class="card-body">
                        <div class="delete-profile">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/dashboard/triangle.png" class="img-fluid">
                            <p class="text-muted">
                            <?php 
                            if(isset($exertio_theme_options['delete_mesg']))
                            {
                                echo esc_html($exertio_theme_options['delete_mesg']); 
                            }
                            ?>
                            </p>
                            <div>
                                <button type="button" class="btn btn-theme-secondary" id="delete_account" data-user-id="<?php echo esc_attr($current_user_id) ?>">
                                    <?php echo esc_html__('Delete My Account','exertio_theme'); ?>
                                </button>
                                <input type="hidden" id="delete_pro_nonce" value="<?php echo wp_create_nonce('fl_delete_pro_secure'); ?>"  />
                            </div>
                        </div>
                        </div>
                      </div>
                  </div>
              <?php
				}	
			  ?>
            </div>
            <div class="col-xl-8 col-lg-12 col-md-12 grid-margin stretch-card">
            	<?php
					if(isset($exertio_theme_options['edit_fl_msg']) && $exertio_theme_options['edit_fl_msg'] != '')
					{
						?>
                        <div class="card mb-4 info-box">
                            <div class="card-body">
                            	<?php
                                if(isset($exertio_theme_options['edit_fl_icon']) && $exertio_theme_options['edit_fl_icon'] != '')
								{
									echo '<i class="'.$exertio_theme_options['edit_fl_icon'].'"></i>';
								}
								echo '<p>'.$exertio_theme_options['edit_fl_msg'].'</p>';
								?>
                            </div>
                        </div>
                        <?php
					}
					?>
            <form id="freelancer_form">
                <div class="card mb-4">
                    <div class="card-body">
                      <h4 class="card-title"><?php echo esc_html__('Profile Basics','exertio_theme'); ?></h4>
                      
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Username','exertio_theme'); ?></label>
                          <input type="text" class="form-control" name="fl_username" value="<?php echo esc_attr($post->post_title); ?>" required data-smk-msg="<?php echo esc_attr__('Username field is must.','exertio_theme');?>">
							<p> <?php echo esc_html__('Be carefull while changing your username.','exertio_theme'); ?></p>
                        </div>
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Email Address','exertio_theme'); ?></label>
                          <input type="email" class="form-control" name="fl_email" disabled value="<?php echo esc_attr($user_info->user_email); ?>">
                        </div>
                        
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Display Name','exertio_theme'); ?></label>
                          <input type="text" class="form-control" name="freelancer_dispaly_name" value="<?php echo esc_attr(get_post_meta( $pid, '_freelancer_dispaly_name' , true )); ?>" <?php if($exertio_theme_options['fl_dispaly_name'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide display name','exertio_theme'); }?>">
                          <p> <?php echo esc_html__('It will display on public profile','exertio_theme'); ?></p>
                        </div>
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Tagline','exertio_theme'); ?></label>
                          <input type="text" class="form-control" name="freelancer_tagline" value="<?php echo esc_attr(get_post_meta( $pid, '_freelancer_tagline' , true )); ?>" <?php if($exertio_theme_options['fl_tagline'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide tagline','exertio_theme'); }?>">
                          <p> <?php echo esc_html__('It will display on public profile','exertio_theme'); ?></p>
                        </div>
                        <?php
							if($exertio_theme_options['fl_hourly_rate'] == 3)
							{
								
							}
							else
							{
						?>
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Hourly Rate','exertio_theme'); ?></label>
                          <input type="text" class="form-control" name="freelancer_hourly_rate" value="<?php echo esc_attr(get_post_meta( $pid, '_freelancer_hourly_rate' , true )); ?>" <?php if($exertio_theme_options['fl_hourly_rate'] == 1){ ?>required data-smk-type="number" data-smk-msg="<?php echo esc_attr__('Please provide your hourly price','exertio_theme'); }?>">
                          <p> <?php echo esc_html__('Provide your hourly rate without currency symbol','exertio_theme'); ?></p>
                        </div>
                        
                        <?php
							}
							if($exertio_theme_options['fl_contact_number'] == 3)
							{
								
							}
							else
							{
								?>
								<div class="form-group col-md-6">
								  <label><?php echo esc_html__('Contact Number','exertio_theme'); ?></label>
								  <input type="number" class="form-control" name="freelancer_contact_number" value="<?php echo esc_attr(get_post_meta( $pid, '_freelancer_contact_number' , true )); ?>" <?php if($exertio_theme_options['fl_contact_number'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide contact number','exertio_theme'); }?>">
								</div>
								<?php
							}
							
							if($exertio_theme_options['fl_gender'] == 3)
							{
								
							}
							else
							{
								$gender = get_post_meta( $pid, '_freelancer_gender' , true )
								?>
								<div class="form-group col-md-6">
								  <label><?php echo esc_html__('Gender','exertio_theme'); ?></label>
									<select name="freelancer_gender"  class="form-control general_select" <?php if($exertio_theme_options['fl_gender'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please select gender','exertio_theme'); }?>">
										<option value="0" <?php if($gender  == "0") { echo "selected=selected"; } ?>><?php echo __( "Male", 'exertio_theme' ); ?> </option>
										<option value="1" <?php if($gender  == "1") { echo "selected=selected"; } ?>><?php echo __( "Female", 'exertio_theme' ); ?> </option>
										<option value="2" <?php if($gender  == "2") { echo "selected=selected"; } ?>><?php echo __( "Other", 'exertio_theme' ); ?> </option>
									</select>
								</div>
								<?php
							}
							 if($exertio_theme_options['fl_specialization'] == 3)
							{
								
							}
							else
							{
								$fl_specialization = '';
								if($exertio_theme_options['fl_specialization'] == 1)
								{
									$fl_specialization = 'required data-smk-msg="'.esc_attr__('Please select specialization','exertio_theme').'"';	
								}
								?>
								<div class="form-group col-md-6">
								  <label><?php echo esc_html__('Specialization','exertio_theme'); ?></label>
								  <?php
									$specialization_taxonomies = exertio_get_terms('freelancer-specialization');
									if ( !empty($specialization_taxonomies) )
									{
										$freelancer_car_id = '';
										if(class_exists('ACF')) { $freelancer_car_id = 'id="exertio_freelancer_cat_parent"'; }
										$freelancer_specialization = get_post_meta($pid, '_freelancer_specialization', true);
										$specialization = '<select name="freelancer_specialization" class="form-control general_select"'.$fl_specialization.' '.$freelancer_car_id.'>';
										$specialization .= '<option value=""> '. __( "Select Specialization", "exertio_theme" ) .'</option>';
										foreach( $specialization_taxonomies as $specialization_taxonomy ) {
											if($specialization_taxonomy->term_id == $freelancer_specialization){ $selected = 'selected ="selected"';}else{$selected = ''; }
											if( $specialization_taxonomy->parent == 0 ) {
												 $specialization .= '<option value="'. esc_html( $specialization_taxonomy->term_id ) .'" '.$selected.'>
														'. esc_html( $specialization_taxonomy->name ) .'</option>';
												$specialization.='</option>';
											}
										}
										$specialization.='</select>';
										echo wp_return_echo($specialization);
									}
									?>
								</div>
								<?php
							}
							if($exertio_theme_options['fl_type'] == 3)
							{
								
							}
							else
							{
								$fl_type = '';
								if($exertio_theme_options['fl_type'] == 1)
								{
									$fl_type = 'required data-smk-msg="'.esc_attr__('Please select type','exertio_theme').'"';	
								}
						
						?>
                        <div class="form-group col-md-6">
                          <label for="inputCity"><?php echo esc_html__('Type','exertio_theme'); ?></label>
                          <?php
                          $freelance_taxonomies = exertio_get_terms('freelance-type');
                            if ( !empty($freelance_taxonomies) )
                            {
                                $freelance_type = get_post_meta($pid, '_freelance_type', true);
                                $freelance = '<select name="freelance_type" class="form-control general_select"'.$fl_type.'>';
                                $freelance .= '<option value=""> '. __( "Select Freelancer Type", "exertio_theme" ) .'</option>';
                                foreach( $freelance_taxonomies as $freelance_taxonomy ) {
                                    if($freelance_taxonomy->term_id == $freelance_type){ $selected = 'selected ="selected"';}else{$selected = ''; }
                                    if( $freelance_taxonomy->parent == 0 ) {
                                         $freelance .= '<option value="'. esc_html( $freelance_taxonomy->term_id ) .'" '.$selected.'>
                                                '. esc_html( $freelance_taxonomy->name ) .'</option>';
                                        $freelance.='</option>';
                                    }
                                }
                                $freelance.='</select>';
                                echo wp_return_echo($freelance);
                            }
                        ?>
                        </div>
                        <?php
							}
							if($exertio_theme_options['fl_english_level'] == 3)
							{
								
							}
							else
							{
								$fl_eng_level = '';
								if($exertio_theme_options['fl_english_level'] == 1)
								{
									$fl_eng_level = 'required data-smk-msg="'.esc_attr__('Please select english level','exertio_theme').'"';	
								}
						
						?>
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('English Level','exertio_theme'); ?></label>
                          <?php
                          $english_level_taxonomies = exertio_get_terms('freelancer-english-level');
                            if ( !empty($english_level_taxonomies) )
                            {
                                $english_level = get_post_meta($pid, '_freelancer_english_level', true);
                                $english = '<select name="english_level" class="form-control general_select" '.$fl_eng_level.'>';
                                $english .= '<option value=""> '. __( "Select English Level", "exertio_theme" ) .'</option>';
                                foreach( $english_level_taxonomies as $english_level_taxonomy ) {
                                    if($english_level_taxonomy->term_id == $english_level){ $selected = 'selected ="selected"';}else{$selected = ''; }
                                    if( $english_level_taxonomy->parent == 0 ) {
                                         $english .= '<option value="'. esc_attr( $english_level_taxonomy->term_id ) .'" '.$selected.'>
                                                '. esc_html( $english_level_taxonomy->name ) .'</option>';
                                        $english.='</option>';
                                    }
                                }
                                $english.='</select>';
                                echo wp_return_echo($english);
                            }
                        ?>
                        </div>
                        
                        <?php
							}
							if($exertio_theme_options['fl_location'] == 3)
							{
								
							}
							else
							{
								$fl_location = '';
								if($exertio_theme_options['fl_location'] == 1)
								{
									$fl_location = 'required data-smk-msg="'.esc_attr__('Please select location','exertio_theme').'"';	
								}
						
						?>
                        <div class="form-group col-md-6">
                          <label> <?php echo esc_html__('Location','exertio_theme'); ?></label>
                          <?php
                          $location_taxonomies = exertio_get_terms('freelancer-locations');
                            if ( !empty($location_taxonomies) )
                            {
                                echo '<select name="freelancer_location" class="form-control general_select" '.$fl_location.'>'.get_hierarchical_terms('freelancer-locations', '_freelancer_location', $pid ).'</select>';
                            }
                        ?>
                        </div>
                        <?php
							}
							if($exertio_theme_options['fl_language'] == 3)
							{
								
							}
							else
							{
								$fl_language = '';
								if($exertio_theme_options['fl_language'] == 1)
								{
									$fl_language = 'required data-smk-msg="'.esc_attr__('Please select language','exertio_theme').'"';	
								}
						
						?>
							<div class="form-group col-md-12">
							  <label><?php echo esc_html__('Languages','exertio_theme'); ?></label>
							  <?php
							  $language_taxonomies = exertio_get_terms('freelancer-languages');
							  $saved_language = wp_get_post_terms($pid, 'freelancer-languages', array( 'fields' => 'all' ));
								if ( !empty($language_taxonomies) )
								{
									//$language_meta = get_post_meta($pid, '_freelancer-type', true);
									$language = '<select name="freelancer_language[]" class="form-control multi_select" multiple="multiple" '.$fl_language.'>';
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
                        <?php
							}
	 					?>
                   </div>
                   <div class="form-row">
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Profile Picture','exertio_theme'); ?></label>
                                <span class="profile-img-container">
                                <?php 
                                    if(!empty($pro_img_id))
                                    {
                                ?>
                                        <img src="<?php echo esc_url($pro_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                                        <i class="mdi mdi-close" id="delete_image" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_profile_pic_freelancer_id" data-attachment-id="<?php echo esc_attr($pro_img_id) ?>"></i>
                                <?php
                                    } 
                                ?>
                                </span>
                            <div class="upload-btn-wrapper">
                                <button class="btn btn-theme-secondary mt-2 mt-xl-0"><?php echo esc_html__('Upload New Picture','exertio_theme'); ?></button>
                                <input type="file" id="emp_profile_pic" name="emp_profile_pic" accept = "image/*" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_profile_pic_freelancer_id" />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Cover Picture','exertio_theme'); ?></label>
                            
                                <span class="banner-img-container">
                                    <?php 
                                        $banner_img_id = get_post_meta( $pid, '_freelancer_banner_id', true );
                                        $banner_img = wp_get_attachment_image_src( $banner_img_id, 'thumbnail' );
                                    if(!empty($banner_img_id))
                                    {
                                    ?>
                                        <img src="<?php echo esc_url($banner_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($banner_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                                        <i class="mdi mdi-close" id="delete_image" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_freelancer_banner_id"  data-attachment-id="<?php echo esc_attr($banner_img_id) ?>"></i>
                                    <?php
                                    }
                                    ?>
                                </span>
                                <div class="upload-btn-wrapper">
                                    <button class="btn btn-theme-secondary mt-2 mt-xl-0" ><?php echo esc_html__('Upload New Cover','exertio_theme'); ?></button>
                                    <input type="file" id="emp_cover_image" name="banner_img" accept = "image/*" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_freelancer_banner_id" />
                                </div>
                        </div>
                        
                    </div>
                    
                    </div>
                </div>
				<div class="card mb-4 additional-fields" <?php echo esc_attr($custom_field_dispaly)?> >
					<div class="card-body">
					  <h4 class="card-title"><?php echo esc_html__('Additional Fields','exertio_theme'); ?></h4>
						<div class="additional-fields-container">
							<?php
								if(is_array($selected_custom_data) && !empty($selected_custom_data)) {
									if ($pid != '' && class_exists('ACF')) {
										$custom_fields_html = apply_filters('exertio_freelancer_acf_frontend_html', '', $selected_custom_data);
										echo $custom_fields_html;
									}
								}
						 ?>
						</div>
					</div>
				  </div>
                <div class="card mb-4">
                    <div class="card-body">
                      <h4 class="card-title"><?php echo esc_html__('Profile Details','exertio_theme'); ?></h4>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label><?php echo esc_html__('Description','exertio_theme'); ?></label>
                                <textarea name="fl_desc" id="" class="form-control fl-textarea"><?php echo esc_html($post->post_content); ?></textarea>
                            </div>
							  <?php 
								if($exertio_theme_options['fl_address'] == 3)
								{
								
								}
								else
								{
									$latitude = get_post_meta( $pid, '_freelancer_latitude', true );	
									$longitude = get_post_meta( $pid, '_freelancer_longitude', true );
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
                            <div class="form-group col-md-12">
                              <label><?php echo esc_html__('Address','exertio_theme'); ?></label>
                              <input type="text" class="form-control" name="fl_address" id="searchMapInput" value="<?php echo get_post_meta($pid, '_freelancer_address', true); ?>" <?php if($exertio_theme_options['fl_address'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please select address','exertio_theme'); }?>">
                              <i class=" mdi mdi-target" id="abc"></i>
                            </div>
                            <div class="form-group col-md-12">
                              <div id="google_canvas" style="width:100%; height:400px;"></div>
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Latitude','exertio_theme'); ?></label>
                              <input type="text" class="form-control" name="fl_lat" id="loc_lat" value="<?php echo get_post_meta($pid, '_freelancer_latitude', true); ?>">
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Longitude','exertio_theme'); ?></label>
                              <input type="text" class="form-control" name="fl_long" id="loc_long" value="<?php echo get_post_meta($pid, '_freelancer_longitude', true); ?>">
                            </div>
                            <?php
								}
							?>
                        </div>
                    </div>
                </div>
                <?php
					if($exertio_theme_options['fl_skills'] == 2)
					{
					?>
						<div class="card mb-4">
							<div class="card-body">
								<h4 class="card-title"><?php echo esc_html__('Skills','exertio_theme'); ?></h4>
								<a href="javascript:void(0);" class="add_new_skills btn btn-theme-secondary btn-to-top btn-sm" data-taxonomy-name="freelancer-skills"><i class="fas fa-plus"></i> <?php echo __( "Add More Skills", 'exertio_theme' ); ?> </a>
										<div class="skills_wrapper sortable" id="sortable">
								<?php
									$skills_json =  json_decode(stripslashes(get_post_meta($pid, '_freelancer_skills', true)), true);
									if(!empty($skills_json))
									{
										$skill_html = '';
										$skills_taxonomies = exertio_get_terms('freelancer-skills');
										for($i=0; $i<count($skills_json); $i++)
										{	
											$skill_html .= '<div class="ui-state-default"><i class="far fa-arrows"></i><div class="form-row"><div class="form-group col-md-6"><select name="freelancer_skills[]" class="form-control general_select">';
											foreach( $skills_taxonomies as $skills_taxonomy ) {
												if($skills_taxonomy->term_id == $skills_json[$i]['skill']){ $selected = 'selected ="selected"';}else{$selected = ''; }
												if( $skills_taxonomy->parent == 0 ) {
													 $skill_html .= '<option value="'. esc_attr( $skills_taxonomy->term_id ) .'" '.$selected.'>
															'. esc_html( $skills_taxonomy->name ) .'</option>';
												}
											}
											$skill_html .= '</select></div>';
											if (fl_framework_get_options('freelancer_skills_percentage') == 1) {
                                                $skill_html .= '<div class="form-group col-md-6"><input type="number" name="skills_percent[]" placeholder="' . esc_attr__("Skill percentage", 'exertio_theme') . '" value="' . $skills_json[$i]['percent'] . '" class="form-control" required></div></div><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
                                            }
										}
										echo wp_return_echo($skill_html);
									}
									else
									{ 
										
									}

								?>
							</div>
							</div>
						</div>
					<?php
					}
					if($exertio_theme_options['fl_awards'] == 2)
					{
				?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo esc_html__('Awards / Certificates','exertio_theme'); ?></h4>
                        <a href="javascript:void(0);" class="add_new_award btn btn-theme-secondary btn-to-top btn-sm" data-post-id="<?php echo esc_attr($pid); ?>"><i class="fas fa-plus"></i> <?php echo __( "Add More", 'exertio_theme' ); ?> </a>
                        <div class="award_wrapper sortable" id="sortable">
							<?php
								$award_jsons =  json_decode(stripslashes(get_post_meta($pid, '_freelancer_awards', true)), true);
								if(!empty($award_jsons))
								{
									$count = '1';
									$award_html = '';
									foreach($award_jsons as $award_json)
									{
										$award_img_url = wp_get_attachment_url( $award_json['award_img'] );
										
										$image_tags = '';
										if(isset($award_img_url) && $award_img_url != '')
										{
											$image_tags = '<div class="award_banner_gallery_'.$count.' sort_imgs"><a href="'.esc_url($award_img_url).'" target="_blank"><img src="'.esc_url($award_img_url).'" class="img-fluid" ></a></div>';
										}
										
										$award_html .= '<div class="ui-state-default" id="award_'.$count.'"><i class="far fa-arrows"></i><div class="form-row"><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-5"><input type="text" name="award_name[]"  value="'.$award_json['award_name'].'"  placeholder="'.esc_attr__('Award Name','exertio_theme').'" class="form-control"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-4"><input type="text" class="datetimepicker form-control" name="award_date[]" value="'.$award_json['award_date'].'" placeholder="'.esc_attr__('Award Date','exertio_theme').'" autocomplete="off"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-3"><button type="button" class="btn btn-theme award_img_btn">'.esc_html__('Image','exertio_theme').'</button><input type="file" id="img_upload_id_'.$count.'" name="img_upload_id_'.$count.'" accept = "image/*" class="award_img_btn"  data-no-off-file-id="award_img_id_'.$count.'" data-post-id="'.$pid.'" data-active_id="'.$count.'"/></div></div><div class="form-row"><div class="form-group col-md-12"><input type="hidden" class="award_img_id_'.$count.'" name="award_img_id[]"  value="'.$award_json['award_img'].'">'.$image_tags.'</div></div><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
										$count++;
									}
									echo wp_return_echo($award_html);
								}
								?>
                        </div>
                    </div>
                </div>
                <?php
					}
					if($exertio_theme_options['fl_projects'] == 2)
					{
				?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo esc_html__('Projects','exertio_theme'); ?></h4>
                        <a href="javascript:void(0);" class="add_new_project btn btn-theme-secondary btn-to-top btn-sm" data-post-id="<?php echo esc_attr($pid); ?>"><i class="fas fa-plus"></i> <?php echo __( "Add New Project", 'exertio_theme' ); ?> </a>
                        <div class="project_wrapper sortable" id="sortable">
							<?php
								$project_jsons =  json_decode(stripslashes(get_post_meta($pid, '_freelancer_projects', true)), true);
								if(!empty($project_jsons))
								{
									$count = '1';
									$project_html = '';
									foreach($project_jsons as $project_json)
									{
										$project_img_url = wp_get_attachment_url( $project_json['project_img'] );
										
										$project_image_tags = '';
										if(isset($award_img_url) && $award_img_url != '')
										{
											$project_image_tags = '<div class="project_banner_gallery_'.$count.' sort_imgs"><a href="'.esc_url($project_img_url).'" target="_blank"><img src="'.esc_url($project_img_url).'" class="img-fluid" ></a></div>';
										}
										
										$project_html .= '<div class="ui-state-default" id="project_'.$count.'"><i class="far fa-arrows"></i><div class="form-row"><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-5"><input type="text" name="project_name[]" value="'.$project_json['project_name'].'" placeholder="'.esc_attr__('Project Name','exertio_theme').'" class="form-control"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-4"><input type="text" class="form-control" name="project_url[]" value="'.$project_json['project_url'].'" placeholder="'.esc_attr__('Project URL','exertio_theme').'" autocomplete="off"></div><div class="form-group col-md-4 col-lg-4 col-sm-4 col-xl-3"><button type="button" class="btn btn-theme project_img_btn">'.esc_html__('Image','exertio_theme').'</button><input type="file" id="project_img_upload_id_'.$count.'" name="project_img_upload_id_'.$count.'" accept = "image/*" class="project_img_btn"  data-project-no-off-file-id="project_img_id_'.$count.'" data-post-id="'.$pid.'" data-project-active-id="'.$count.'"/></div></div><div class="form-row"><div class="form-group col-md-12"><input type="hidden" class="project_img_id_'.$count.'" name="project_img_id[]" value="'.$project_json['project_img'].'">'.$project_image_tags.'</div></div><a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
										$count++;
									}
									echo wp_return_echo($project_html);
								}
								?>
                        </div>
                    </div>
                </div>
                <?php
					}
					if($exertio_theme_options['fl_experience'] == 2)
					{
				?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo esc_html__('Experience','exertio_theme'); ?></h4>
                        <a href="javascript:void(0);" class="add_new_expe btn btn-theme-secondary btn-to-top btn-sm" data-post-id="<?php echo esc_attr($pid); ?>"><i class="fas fa-plus"></i> <?php echo __( "Add New Experience", 'exertio_theme' ); ?> </a>
                        <div class="expe_wrapper sortable" id="sortable">
							<?php
							$expe_jsons =  json_decode(stripslashes(get_post_meta($pid, '_freelancer_experience', true)), true);
							if(!empty($expe_jsons))
							{
								$count = '1';
								$expe_html= '';
								foreach($expe_jsons as $expe_json)
								{
									$expe_html .= '<div class="ui-state-default" id="expe_'.$count.'"><i class="far fa-arrows"></i><span class="count">'.$count.'</span>	<div class="form-row"><div class="form-group col-md-6"><label>'.__( "Experience Title", 'exertio_theme' ).'</label><input type="text" name="expe_name[]" class="form-control" value="'.$expe_json['expe_name'].'" ></div><div class="form-group col-md-6"><label>'.__( "Company Name", 'exertio_theme' ).'</label> <input type="text" class="form-control" name="expe_company_name[]" value="'.$expe_json['expe_company_name'].'"></div></div><div class="form-row"> <div class="form-group col-md-6"> <label>'.__( "Start Date Title", 'exertio_theme' ).'</label><input type="text" name="expe_start_date[]" class="expe_start_date_'.$count.' form-control" value="'.$expe_json['expe_start_date'].'" autocomplete="off"></div> <div class="form-group col-md-6"><label>'.__( "End Date", 'exertio_theme' ).'</label> <input type="text" name="expe_end_date[]" class="expe_end_date_'.$count.' form-control" value="'.$expe_json['expe_end_date'].'" autocomplete="off"><p>'.esc_html__('Leave it empty to set it current experience','exertio_theme').'</p></div></div><div class="form-row"><div class="form-group col-md-12"><label>'.__( "Description", 'exertio_theme' ).'</label><textarea name="expe_details[]" class="form-control">'.$expe_json['expe_details'].'</textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';

									$count++;
								}
								echo wp_return_echo($expe_html);
							}
						?>
                        </div>
                    </div>
                </div>
                <?php
					}
					if($exertio_theme_options['fl_education'] == 2)
					{
				?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo esc_html__('Education','exertio_theme'); ?></h4>
                        <a href="javascript:void(0);" class="add_new_edu btn btn-theme-secondary btn-to-top btn-sm" data-post-id="<?php echo esc_attr($pid); ?>"><i class="fas fa-plus"></i> <?php echo __( "Add New Education", 'exertio_theme' ); ?> </a>
                        <div class="edu_wrapper sortable" id="sortable">
                    	<?php
							$edu_jsons = json_decode( stripslashes( get_post_meta($pid, '_freelancer_education', true)), true );
							if(!empty($edu_jsons))
							{
								$count = '1';
								$edu_html = '';
								foreach($edu_jsons as $edu_json)
								{									
									$edu_html .= '<div class="ui-state-default" id="edu_'.$count.'"><i class="far fa-arrows"></i><span class="count">'.$count.'</span>	<div class="form-row"><div class="form-group col-md-6"><label>'.__( "Degree Title", 'exertio_theme' ).'</label><input type="text" name="edu_name[]" class="form-control" value="'.$edu_json['edu_name'].'" ></div><div class="form-group col-md-6"><label>'.__( "Institude Name", 'exertio_theme' ).'</label> <input type="text" class="form-control" name="edu_inst_name[]" value="'.$edu_json['edu_inst_name'].'"></div></div><div class="form-row"> <div class="form-group col-md-6"> <label>'.__( "Start Date", 'exertio_theme' ).'</label><input type="text" name="edu_start_date[]" value="'.$edu_json['edu_start_date'].'" class="edu_start_date_'.$count.' form-control" autocomplete="off"></div> <div class="form-group col-md-6"><label>'.__( "End Date", 'exertio_theme' ).'</label> <input type="text" name="edu_end_date[]" class="edu_end_date_'.$count.' form-control" value="'.$edu_json['edu_end_date'].'" autocomplete="off" ><p>'.__( "Leave it empty to set it continue", 'exertio_theme' ).'</p></div></div><div class="form-row"><div class="form-group col-md-12"><label>'.__( "Description", 'exertio_theme' ).'</label><textarea name="edu_details[]" class="form-control">'.$edu_json['edu_details'].'</textarea> </div></div> <a href="javascript:void(0);" class="remove_button"><i class="fas fa-times-circle"></i></a></div>';
									$count++;
								}
								echo wp_return_echo($edu_html);
							}
						?>
                    </div>
                    </div>
                </div>
                <?php
					}
				?>
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="button" class="btn btn-theme  btn-loading" id="fl_profile_btn" data-post-id="<?php echo esc_attr($pid) ?>">
                                        <?php echo esc_html__('Save Profile','exertio_theme'); ?>
                                        <input type="hidden" id="save_pro_nonce" value="<?php echo wp_create_nonce('fl_save_pro_secure'); ?>"  />
                                        <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            
          </div>
        </div>
<?php
	}
?>