<?php global $exertio_theme_options;
$current_user_id = get_current_user_id();

$pid = get_user_meta( $current_user_id, 'employer_id' , true );
$post	=	get_post($pid);

$user_info = get_userdata($current_user_id);
$user_name = $user_info->display_name;

$pro_img_id = get_post_meta( $pid, '_profile_pic_attachment_id', true );
$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );


$employer_departments = get_post_meta($pid, '_employer_department', true);

$selected_custom_data = $fetch_custom_data = '';
$custom_field_dispaly = 'style=display:none;';
if(class_exists('ACF'))
{
	$selected_custom_data = exertio_employer_fields_by_listing_id($pid);
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
          	<div class="col-xl-4 col-lg-12 col-md-12 grid-margin  stretch-card">
            	<div class="card mb-4 vector-bg">
                <div class="card-body">
                  <div class="profile-card">
                    <div class="profile-cardmeta">
                    	<span class="profile-name mb-2"> <?php echo exertio_get_username('employer',$pid ); ?></span>
                        <span class="p-email mb-2"> @<?php echo esc_html($post->post_title); ?></span>
                        <a href="<?php  echo esc_url(get_permalink($pid)); ?>" class=""><?php echo esc_html__('View Profile','exertio_theme'); ?></a>
                    </div>
                    <div class="cardmeta-footer">
                    	<ul class="profile-details">
                            <li>
                                <i class="far fa-envelope"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_html($user_info->user_email); ?></span>
                                </div>
                            </li>
                             <?php  if(isset($exertio_theme_options['employer_department']) && $exertio_theme_options['employer_department'] == 3){ } else{?>
                            <li>
                                <i class="fas fa-briefcase"></i>
                                <div class="profile-meta">
                                <?php
								if($employer_departments != '')
								{ 
									$departments = get_term( $employer_departments );
									if(!empty($departments) && ! is_wp_error($departments))
									{
									?>
										<span><?php echo esc_html($departments->name); ?></span>
									<?php
									}
								}
                                ?>
                                </div>
                            </li>
                            <?php }?>
                            <li>
                                <i class="fas fa-signature"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_html(get_post_meta( $pid, '_employer_tagline' , true )); ?></span>
                                </div>
                            </li>
                            
                            <?php  if(isset($exertio_theme_options['employer_contact_no']) && $exertio_theme_options['employer_contact_no'] == 3){ } else{?>
                            <li>
                                <i class="fas fa-mobile-alt"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_html(get_post_meta( $pid, '_employer_contact_number' , true )); ?></span>
                                </div>
                            </li>
                            <?php }?>
                             <?php  if(isset($exertio_theme_options['employer_map']) && $exertio_theme_options['employer_map'] == 3){ } else{?>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="profile-meta">
                                    <span><?php echo esc_html( get_post_meta($pid, '_employer_address', true)); ?></span>
                                </div>
                            </li>
                            <?php }?>
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
                                <button type="button" class="btn btn-black" id="delete_account" data-user-id="<?php echo esc_attr($current_user_id) ?>">
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
					if(isset($exertio_theme_options['edit_msg']) && $exertio_theme_options['edit_msg'] != '')
					{
						?>
                        <div class="card mb-4 info-box">
                            <div class="card-body">
                            	<?php
                                if(isset($exertio_theme_options['edit_icon']) && $exertio_theme_options['edit_icon'] != '')
								{
									echo '<i class="'.$exertio_theme_options['edit_icon'].'"></i>';
								}
								echo '<p>'.$exertio_theme_options['edit_msg'].'</p>';
								?>
                            </div>
                        </div>
                        <?php
					}
					?>
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?php echo esc_html__('Profile details','exertio_theme'); ?></h4>
                  
                  <form id="employer_form">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label><?php echo esc_html__('Username','exertio_theme'); ?></label>
                      <input type="text" class="form-control" name="emp_name" value="<?php echo esc_attr($post->post_title); ?>" required data-smk-msg="<?php echo esc_attr__('Please provide username','exertio_theme'); ?>">
						<p> <?php echo esc_html__('Be careful while changing your username.','exertio_theme'); ?></p>
                    </div>
                    <div class="form-group col-md-6">
                      <label><?php echo esc_html__('Email Address','exertio_theme'); ?></label>
                      <input type="email" class="form-control" name="emp_email" disabled value="<?php echo esc_attr($user_info->user_email); ?>">
                      <p> <?php echo esc_html__('You can not change your email address.','exertio_theme'); ?></p>
                    </div>
                  </div>
                  <div class="form-row">
                    
                    <div class="form-group col-md-6">
                      <label><?php echo esc_html__('Display Name','exertio_theme'); ?></label>
                      <input type="text" class="form-control" name="emp_display_name" value="<?php echo esc_attr(get_post_meta( $pid, '_employer_dispaly_name' , true )); ?>" <?php if($exertio_theme_options['employer_dispaly_name'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide display name','exertio_theme'); }?>">
                      <p> <?php echo esc_html__('It will display on public profile','exertio_theme'); ?></p>
                    </div>
                    <div class="form-group col-md-6">
                      <label><?php echo esc_html__('Tagline','exertio_theme'); ?></label>
                      <input type="text" class="form-control" name="emp_tagline" value="<?php echo esc_attr(get_post_meta( $pid, '_employer_tagline' , true )); ?>"  <?php if($exertio_theme_options['employer_tagline'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide tagline','exertio_theme'); }?>">
                      <p> <?php echo esc_html__('It will display on public profile','exertio_theme'); ?></p>
                    </div>
                  </div>
                  <div class="form-row">
                    
                    <?php
                    	if($exertio_theme_options['employer_contact_no'] == 3)
						{
							
						}
						else
						{
						?>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Contact Number','exertio_theme'); ?></label>
                              <input type="number" class="form-control" name="emp_contact" value="<?php echo esc_attr(get_post_meta( $pid, '_employer_contact_number' , true )); ?>" <?php if($exertio_theme_options['employer_contact_no'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please provide contact number','exertio_theme'); }?>">
                            </div>
						<?php
                    	} 

                    	if($exertio_theme_options['employer_department'] == 3)
						{
							
						}
						else
						{
							$dpt_check = '';
							if($exertio_theme_options['employer_department'] == 1)
							{
								$dpt_check = 'required data-smk-msg="'.esc_attr__('Please select department','exertio_theme').'"';	
							}
						?>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Department','exertio_theme'); ?></label>
                              <?php
                              $department_taxonomies = exertio_get_terms('departments');
                                if ( !empty($department_taxonomies) )
                                {
									$emp_car_id = '';
									if(class_exists('ACF')) { $emp_car_id = 'id="exertio_employer_cat_parent"'; }
                                    $dpt_check;
                                    $departments = '<select name="employer_department" class="form-control general_select" '.$dpt_check.' '.$emp_car_id.'>';
                                    $departments .= '<option value=""> '. __( "Select Department", "exertio_theme" ) .'</option>';
                                    foreach( $department_taxonomies as $department_taxonomy ) {
                                        if($department_taxonomy->term_id == $employer_departments){ $selected = 'selected ="selected"';}else{$selected = ''; }
                                        if( $department_taxonomy->parent == 0 ) {
                                             $departments .= '<option value="'. esc_attr( $department_taxonomy->term_id ) .'" '.$selected.'>'. esc_html( $department_taxonomy->name ) .'</option>';
                                        }
                                    }
                                    $departments.='</select>';
                                    echo wp_return_echo($departments);
                                }
                            ?>
                            </div>
                        <?php
                            }
							
						if($exertio_theme_options['employer_employee_count'] == 3)
						{
							
						}
						else
						{
							$employee_check = '';
							if($exertio_theme_options['employer_employee_count'] == 1)
							{
								$employee_check = 'required data-smk-msg="'.esc_attr__('Please select number of employees','exertio_theme').'"';	
							}
						?>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Number of Employees','exertio_theme'); ?></label>
                              <?php
                              $employee_taxonomies = exertio_get_terms('employees-number');
                                if ( !empty($employee_taxonomies) )
                                {
                                    $employer_employees = get_post_meta($pid, '_employer_employees', true);
                                    $employee = '<select name="employer_employees" class="form-control general_select" '.$employee_check.'>';
                                    $employee .= '<option value=""> '. __( "Number of Employees", "exertio_theme" ) .'</option>';
                                    foreach( $employee_taxonomies as $employee_taxonomy ) {
                                        if($employee_taxonomy->term_id == $employer_employees){ $selected = 'selected ="selected"';}else{$selected = ''; }
                                        if( $employee_taxonomy->parent == 0 ) {
                                             $employee .= '<option value="'. esc_attr( $employee_taxonomy->term_id ) .'" '.$selected.'>
                                                    '. esc_html( $employee_taxonomy->name ) .'</option>';
                                        }
                                    }
                                    $employee.='</select>';
                                    echo wp_return_echo($employee);
                                }
                            ?>
                            </div>
                    	<?php
                            }
						if($exertio_theme_options['employer_custom_locationt'] == 3)
						{
							
						}
						else
						{
							$custom_location_check = '';
							if($exertio_theme_options['employer_custom_locationt'] == 1)
							{
								$custom_location_check = 'required data-smk-msg="'.esc_attr__('Please select location','exertio_theme').'"';	
							}
						?>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Location','exertio_theme'); ?></label>
                              <?php
                              $location_taxonomies = exertio_get_terms('employer-locations');
                                if ( !empty($location_taxonomies) )
                                {
                                    echo '<select name="employer_location" class="form-control general_select" '.$custom_location_check.'>'.get_hierarchical_terms('employer-locations', '_employer_location', $pid ).'</select>';
                                }
                            ?>
                            </div>
                    	<?php
                         }
						?>
                  </div>
					<div class="form-row additional-fields" <?php echo esc_attr($custom_field_dispaly)?>>
						<div class="form-group col-md-12">
							<div class="additional-fields-container">
							<?php
								if(is_array($selected_custom_data) && !empty($selected_custom_data))
								{
									if ($pid != '' && class_exists('ACF')) {
										$custom_fields_html = apply_filters('exertio_employer_acf_frontend_html', '', $selected_custom_data);
										echo $custom_fields_html;
									}
								}
							 ?>
							</div>
						</div>
					</div>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><?php echo esc_html__('Description','exertio_theme'); ?></label>
                    	<textarea name="emp_desc" id="" class="form-control fl-textarea"><?php echo esc_html($post->post_content); ?></textarea>
                    </div>
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
                <i class="mdi mdi-close" id="delete_image" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_profile_pic_attachment_id"  data-attachment-id="<?php echo esc_attr($pro_img_id) ?>"></i>
                <?php
                } 
                ?>
                </span>
                <div class="upload-btn-wrapper">
                <button class="btn btn-theme-secondary mt-2 mt-xl-0"><?php echo esc_html__('Upload New Picture','exertio_theme'); ?></button>
                <input type="file" id="emp_profile_pic" name="emp_profile_pic" accept = "image/*" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_profile_pic_attachment_id"/>
                </div>
                </div>
                <div class="form-group col-md-6">
                <label><?php echo esc_html__('Cover Picture','exertio_theme'); ?></label>
                <div class="upload-btn-wrapper">
                <span class="banner-img-container">
                <?php 
                $banner_img_id = get_post_meta( $pid, '_employer_banner_id', true );
                $banner_img = wp_get_attachment_image_src( $banner_img_id, 'thumbnail' );
                
                if(!empty($banner_img_id))
                {
                ?>
                <img src="<?php echo esc_url($banner_img[0]); ?>" alt="<?php echo esc_attr(get_post_meta($banner_img_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-fluid">
                <i class="mdi mdi-close" id="delete_image" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_employer_banner_id" data-attachment-id="<?php echo esc_attr($banner_img_id) ?>"></i>
                <?php
                }
                ?>
                </span>
                <div class="upload-btn-wrapper">
                <button class="btn btn-theme-secondary mt-2 mt-xl-0" ><?php echo esc_html__('Upload New Cover','exertio_theme'); ?></button>
                <input type="file" id="emp_cover_image" name="banner_img" accept = "image/*" data-post-id="<?php echo esc_attr($pid) ?>" data-post-meta ="_employer_banner_id" />
                </div>
                </div>
                </div>
                </div>
				
                  <?php 
        			if($exertio_theme_options['employer_map'] == 3)
					{
						
					}
					else
					{
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
                          <input type="text" class="form-control" name="emp_address" id="searchMapInput" value="<?php echo get_post_meta($pid, '_employer_address', true); ?>" <?php if($exertio_theme_options['employer_map'] == 1){ ?>required data-smk-msg="<?php echo esc_attr__('Please select address','exertio_theme'); }?>">
                          <i class=" mdi mdi-target" id="abc"></i>
                        </div>
                        <div class="form-group col-md-12">
                          <div id="google_canvas" style="width:100%; height:400px;"></div>
                        </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Latitude','exertio_theme'); ?></label>
                          <input type="text" class="form-control" name="emp_lat" id="loc_lat" value="<?php echo get_post_meta($pid, '_employer_latitude', true); ?>">
                        </div>
                        <div class="form-group col-md-6">
                          <label><?php echo esc_html__('Longitude','exertio_theme'); ?></label>
                          <input type="text" class="form-control" name="emp_long" id="loc_long" value="<?php echo get_post_meta($pid, '_employer_longitude', true); ?>">
                        </div>
                        </div>
					<?php
                    }
                    ?>
                    <?php
					if($exertio_theme_options['social_links_switch'] == true)
					{
					?>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Facebook profile URL','exertio_theme'); ?></label>
                              <input type="url" class="form-control" name="facebook_url" value="<?php echo get_post_meta($pid, '_employer_facebook_url', true); ?>">
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Twitter profile URL','exertio_theme'); ?></label>
                              <input type="url" class="form-control" name="twitter_url" value="<?php echo get_post_meta($pid, '_employer_twitter_url', true); ?>">
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('LinkedIn profile URL','exertio_theme'); ?></label>
                              <input type="url" class="form-control" name="linkedin_url" value="<?php echo get_post_meta($pid, '_employer_linkedin_url', true); ?>">
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Instagram profile URL','exertio_theme'); ?></label>
                              <input type="url" class="form-control" name="instagram_url" value="<?php echo get_post_meta($pid, '_employer_instagram_url', true); ?>">
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Dribble profile URL','exertio_theme'); ?></label>
                              <input type="url" class="form-control" name="dribble_url" value="<?php echo get_post_meta($pid, '_employer_dribble_url', true); ?>">
                            </div>
                            <div class="form-group col-md-6">
                              <label><?php echo esc_html__('Behance profile URL','exertio_theme'); ?></label>
                              <input type="url" class="form-control" name="behance_url" value="<?php echo get_post_meta($pid, '_employer_behance_url', true); ?>">
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <button type="button" class="btn btn-theme btn-loading" id="employer_profile_btn" data-post-id="<?php echo esc_attr($pid) ?>">
                        	<?php echo esc_html__('Save Profile','exertio_theme'); ?>
                            <input type="hidden" id="save_pro_nonce" value="<?php echo wp_create_nonce('fl_save_pro_secure'); ?>"  />
                            <div class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </div>
                    </button>
                    
                </form>
                </div>
                
              </div>
            </div>
            
          </div>
        </div>
<?php
	}
?>