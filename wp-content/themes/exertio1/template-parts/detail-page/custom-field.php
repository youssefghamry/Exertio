<?php 
$post_id =       get_the_ID();
if(class_exists('ACF') && function_exists('get_field_objects')) 
{
	$main_title = '';
	if ( is_singular( 'freelancer' ))
	{
		$main_title = fl_framework_get_options('freelancer_cf_title');
	}
	if ( is_singular( 'services' ))
	{
		$main_title = fl_framework_get_options('servcies_cf_title');
	}
	if ( is_singular( 'projects' ))
	{
		$main_title = fl_framework_get_options('project_cf_title');
	}
	if ( is_singular( 'employer' ))
	{
		$main_title = fl_framework_get_options('employer_cf_title');
	}
	$custom_data = $cus_fields = array();
	$cus_fields = get_field_objects($post_id);
	if (isset($cus_fields) && !empty($cus_fields) && is_array($cus_fields) && count($cus_fields) > 0) 
	{
			$keys = array();
			$multi_values = $selected_val = '';
			foreach ($cus_fields as $key => $value)
			{
					$each_field_data = array();
					$each_field_data['label'] = $value['label'];
					$each_field_data['type'] = $value['type'];
					$each_field_data['is_multiple'] = false;

					if (isset($value['type']) && ($value['type'] == 'select' || $value['type'] == 'checkbox' || $value['type'] == 'radio' || $value['type'] == 'button_group') )
					{
							if(!empty($value['choices']) && is_array($value['choices']) && count($value['choices'])> 0 && !empty($value['value']))
							{
									//for multicheck choices
									$keys = $value['choices'];

									if(is_array($value['value']) && count($value['value'])> 0)
									{
											$multi_values = $value['value'];

											$choince_array = array();
											if(is_array($value['choices']) && count($value['choices'])> 0){
												foreach($multi_values as $multi_value){
													if(array_key_exists($multi_value, $keys)){
														if(is_array($multi_value)){ 
															foreach($multi_value as $single_value){
																echo $single_value;
															}
														}else {

																$choince_array[] = $keys[$multi_value];
															}
														}
													}
												}
											if($value['type']  == 'select' && isset($value['multiple']) && $value['multiple'] == 1)
											{
												  $each_field_data['is_multiple'] = true;
											}

											$each_field_data['value'] = $choince_array;
									}
									else
									{
											$selected_val = $value['value'];
											$each_field_data['value'] = $keys[$selected_val];
									}
							}
							else
							{
									$each_field_data['value'] = $value['value'];
							}
					} 
					else
					{
							if($value['type'] == 'true_false' )
							{
									$each_field_data['ui'] = $value['ui'];
									$each_field_data['ui_on_text'] = $value['ui_on_text'];
							}
							$each_field_data['value'] = $value['value'];
					}
					$custom_data[] = $each_field_data;
			}
		?>
		<div class="widget-seprator exertio-acf-custom">
			<div class="widget-seprator-heading">
				 <h3 class="sec-titles"><?php echo esc_html($main_title); ?></h3>
			</div>
			<?php
			if (isset($custom_data) && !empty($custom_data) && is_array($custom_data) && count($custom_data) > 0 ) 
			{
				?>      
				<div class="row key-specs-3">
								<?php
								foreach($custom_data as $data)
								{
										if($data['type'] == 'checkbox' || $data['type'] == 'textarea' || $data['value'] == '' || $data['is_multiple'] == 1)
										continue;
								?>      
								<div class="col-xxl-4 col-xl-4 col-md-6 col-sm-12 col-12">
										<div class="exertio-specs-row">
										   <div class="spk-3">
												  <small><?php echo esc_html($data['label']); ?></small>
												  <h6>
														  <?php 
																if($data['type'] == 'url')
																{
																		echo '<a href="'.esc_url($data['value']).'" target="_blank">'.esc_html__('Link','exertio_theme').'</a>';
																}
																else if($data['type'] == 'true_false')
																{
																		if($data['value'] == 1 && $data['ui'] == 1)
																		{
																				echo esc_html($data['ui_on_text']);
																		}
																		else
																		{
																				echo esc_html__('Yes','exertio_theme');
																		}
																}
																else
																{
																		echo esc_html($data['value']);
																}
																?>
												   </h6>
										   </div>
										</div>
								</div>
								<?php
								}
								?>
						</div>
				</div>
				<?php
				foreach($custom_data as $data)
				{
					if($data['type'] == 'textarea' && !empty($data['value']))
					{
					?>      
							<div class="widget-seprator exertio-acf-custom-textarea clearfix">
									<div class="widget-seprator-heading">
											 <h3 class="sec-titles"><?php echo esc_html($data['label']); ?></h3>
									</div>
									<p><?php echo esc_html($data['value']); ?></p>
							</div>  
					<?php
					}
					if($data['type'] == 'select' && isset($data['is_multiple']) && $data['is_multiple'] == 1 )
					{
					?>
							<div class="widget-seprator exertio-acf-custom-multiple listing-features clearfix">
									<div class="widget-seprator-heading">
											 <h3 class="sec-titles"><?php echo esc_html($data['label']); ?></h3>
									</div>
									<ul class="list-unstyled">
									<?php   
									foreach($data['value'] as $single_value)
									{
									?>
											<li class="list-inline-item">
											  <i class="fas fa-check-circle"></i> <span><?php echo esc_html($single_value); ?></span>
											</li>
									<?php
									}
									?>
									</ul>
							</div>
							<?php   
					}
					if($data['type'] == 'checkbox' && is_array($data['value']) && count($data['value']) > 0 )
					{
					?>
						<div class="widget-seprator exertio-acf-custom-checkbox listing-features clearfix">
								<div class="widget-seprator-heading">
										 <h3 class="sec-titles"><?php echo esc_html($data['label']); ?></h3>
								</div>
								<ul class="list-unstyled">
								<?php   
								foreach($data['value'] as $check)
								{
								?>
										<li class="list-inline-item">
										  <i class="fas fa-check-circle"></i> <span><?php echo esc_html($check); ?></span>
										</li>
								<?php
								}
								?>
								</ul>
						</div>
						<?php   
					}
				}
			}
	}
}