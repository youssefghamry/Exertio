<?php
if ( in_array( 'exertio-elementor/exertio-elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
	if ( !function_exists( 'exertio_shortcode_color_text' ) ) {
		function exertio_shortcode_color_text( $str )
		{
		  preg_match( '~{color}([^{]*){/color}~i', $str, $match );
		  if ( isset( $match[ 1 ] ) ) {
			$search = "{color}" . $match[ 1 ] . "{/color}";
			$replace = '<span class="clr-theme">' . $match[ 1 ] . '</span>';
			$str = str_replace( $search, $replace, $str );
		  }
		  return $str;
	}
	}
	if ( !function_exists( 'exertio_shortcode_section_headings' ) )
	{
		function exertio_shortcode_section_headings( $maintitle = '', $subtitle = '', $style = '', $heading_btn = '', $heading_btn_text = '', $heading_btn_link = '' )
		{
		  if ( !empty( $subtitle ) || !empty( $maintitle ) ) {
			$is_margin = $is_centered = $main_title = $sub_title = $side_btn = '';
			if ( !empty( $subtitle ) ) {
			  $sub_title = '<p>' . esc_html( $subtitle ) . '</p>';
			}
			if ( !empty( $maintitle ) ) {
			  $main_title = '<h2>' . esc_html( $maintitle ) . '</h2>';
			}
			$is_centered = 'section-center';
			if ( !empty( $style ) && $style == 'left' ) {
			  $is_centered = 'section-left';
			  if ( !empty( $heading_btn ) && $heading_btn == 'yes' ) {
				$target = $heading_btn_link[ 'is_external' ] ? ' target="_blank"' : '';
				$nofollow = $heading_btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
				$side_btn = '<div class="fr-serv2-btn"><a href="' . esc_url( $heading_btn_link[ 'url' ] ) . '" class="btn btn-theme" ' . $target . ' ' . $nofollow . '>' . $heading_btn_text . '</a></div>';
			  }
			}
			return '<div class="heading-panel  ' . esc_attr( $is_centered ) . '">
							<div class="heading-meta">
							  ' . $main_title . '
							  ' . $sub_title . '
							</div>
							' . $side_btn . '
							</div>';
		  }
	}
	}

	if ( !function_exists( 'exertio_element_hero_one' ) )
	{
		function exertio_element_hero_one( $params )
		{
		  $sec_btn = $main_btn = $desc = $main_heading = $post_type_links = $placehoder_text = $select_placeholder_text = $search_btn_title = $keyword_titles = $video_heading_title = $video_desc = $video_link = $keyword_selection = $term_data = $keywords = $search_field_toggle = $action = '';

		  if ( !empty( $params[ 'heading_text' ] ) ) {
			$main_heading = '<h1>' . $params[ 'heading_text' ] . '</h1>';
		  }
		  if ( !empty( $params[ 'item_description' ] ) ) {
			$desc = '<p> ' . $params[ 'item_description' ] . ' </p>';
		  }
		  if ( !empty( $params[ 'search_field_placeholder_text' ] ) ) {
			$placehoder_text = $params[ 'search_field_placeholder_text' ];
		  }
		  if ( !empty( $params[ 'select_placeholder_text' ] ) ) {
			$select_placeholder_text = $params[ 'select_placeholder_text' ];
		  }
		  if ( !empty( $params[ 'search_btn_title' ] ) ) {
			$search_btn_title = $params[ 'search_btn_title' ];
		  }
		  if ( !empty( $params[ 'keyword_titles' ] ) ) {
			$keyword_titles = $params[ 'keyword_titles' ];
		  }
		  if ( !empty( $params[ 'video_heading_title' ] ) ) {
			$video_heading_title = $params[ 'video_heading_title' ];
		  }
		  if ( !empty( $params[ 'video_desc' ] ) ) {
			$video_desc = $params[ 'video_desc' ];
		  }
		  if ( !empty( $params[ 'video_link' ] ) ) {
			$video_link = $params[ 'video_link' ];
		  }

		  $post_type = $params[ 'post_type_select' ];
		  $post_type_links .= '<select class="default-select post-type-change">';
			$post_type_links .= '<option value="">' . esc_attr($select_placeholder_text) . '</option>';
		  foreach ( $post_type as $post_types )
		  {
			$name = exertio_cpt_array_hero_section($post_types );
			$post_type_links .= '<option value="'.esc_attr($post_types).'">' . esc_html($name) . '</option>';
			$action = exertio_get_cpt_page_link($post_types);
		  }
		  $post_type_links .= '</select>';

		  if ( !empty( $params[ 'video_link' ] ) && is_array( $params[ 'video_link' ] ) ) {
			$target = $params[ 'video_link' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'video_link' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$video_link = '<a href="' . esc_url( $params[ 'video_link' ][ 'url' ] ) . '" ' . $target . $nofollow . ' class="popup-video"><i class="fa fa-play" aria-hidden="true"></i></a>';
		  }
		  $keyword_selection = $params[ 'keyword_selection' ];
		  foreach ( $keyword_selection as $term_id ) {
			$term_data = get_term( $term_id );
			if(!empty($term_data) && ! is_wp_error($term_data))
			{
				$keywords .= "<a href='" . get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . "?category=" . $term_id . "'>" . $term_data->name . "</a>";
			}
		  }

		  if ( !empty( $params[ 'left_image_1' ] ) && is_array( $params[ 'left_image_1' ] ) ) {
			$target = $params[ 'left_image_1_url' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'left_image_1_url' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$image_1 = '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4"><a href="' . esc_url( $params[ 'left_image_1_url' ][ 'url' ] ) . '" ' . $target . $nofollow . '><img src="' . $params[ 'left_image_1' ][ 'url' ] . '" alt="' . get_post_meta( $params[ 'left_image_1' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a></div>';
		  }

		  if ( !empty( $params[ 'left_image_2' ] ) && is_array( $params[ 'left_image_2' ] ) ) {
			$target = $params[ 'left_image_2_url' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'left_image_2_url' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$image_2 = '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4"><a href="' . esc_url( $params[ 'left_image_2_url' ][ 'url' ] ) . '" ' . $target . $nofollow . '><img src="' . $params[ 'left_image_2' ][ 'url' ] . '" alt="' . get_post_meta( $params[ 'left_image_2' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a></div>';
		  }
		  if ( !empty( $params[ 'left_image_3' ] ) && is_array( $params[ 'left_image_3' ] ) ) {
			$target = $params[ 'left_image_3_url' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'left_image_3_url' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$image_3 = '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4"><a href="' . esc_url( $params[ 'left_image_3_url' ][ 'url' ] ) . '" ' . $target . $nofollow . '><img src="' . $params[ 'left_image_3' ][ 'url' ] . '" alt="' . get_post_meta( $params[ 'left_image_3' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a></div>';
		  }

		  if ( !empty( $params[ 'right_image_1' ] ) && is_array( $params[ 'right_image_1' ] ) ) {
			$target = $params[ 'right_image_1_url' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'right_image_1_url' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$image_4 = '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4"><a href="' . esc_url( $params[ 'right_image_1_url' ][ 'url' ] ) . '" ' . $target . $nofollow . '><img src="' . $params[ 'right_image_1' ][ 'url' ] . '" alt="' . get_post_meta( $params[ 'right_image_1' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a></div>';
		  }

		  if ( !empty( $params[ 'right_image_2' ] ) && is_array( $params[ 'right_image_2' ] ) ) {
			$target = $params[ 'right_image_2_url' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'right_image_2_url' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$image_5 = '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4"><a href="' . esc_url( $params[ 'right_image_2_url' ][ 'url' ] ) . '" ' . $target . $nofollow . '><img src="' . $params[ 'right_image_2' ][ 'url' ] . '" alt="' . get_post_meta( $params[ 'right_image_2' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a></div>';
		  }
		  if ( !empty( $params[ 'right_image_3' ] ) && is_array( $params[ 'right_image_3' ] ) ) {
			$target = $params[ 'right_image_3_url' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'right_image_3_url' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$image_6 = '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4"><a href="' . esc_url( $params[ 'right_image_3_url' ][ 'url' ] ) . '" ' . $target . $nofollow . '><img src="' . $params[ 'right_image_3' ][ 'url' ] . '" alt="' . get_post_meta( $params[ 'right_image_3' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a></div>';
		  }


		  $direction = 'text-left';
		  if ( is_rtl() ) {
			$direction = 'text-right';
		  }
			
		$search_field_toggle = $params['search_field_switch'];
		if(isset($search_field_toggle) && $search_field_toggle == 1)
		{
			$search_form = '<div class="fr-hero2-form">
								<form class="hero-one-form" action="'.esc_url($action).'">
									<ul>
										<li>
											<div class="form-group style-bind">
												<input type="text" placeholder="' . $placehoder_text . '" class="form-control" name="title">
											</div>
										</li>
										<li>
											<div class="form-group">
												' . $post_type_links . '
											</div>
										</li>
										<li>
											<button type="submit" class="btn btn-theme"><i class="fa fa-search"></i>' . $search_btn_title . '</button>
										</li>
									</ul>
								</form>
							</div>';
		}
		else
		{
			$search_form = '';
		}
		  return '<section class="fr-hero-2">
							<div class="container"> 
								<div class="row">
									<div class="col-lg-12 col-xl-12 col-sm-12 col-xs-12">
										<div class="fr-hero2-content">
											<div class="fr-hero2-title">
												' . $main_heading . '
												' . $desc . '
											</div>

											'.$search_form.'
											<div class="fr-hero2-info">
												<span>' . $keyword_titles . '</span>
												' . $keywords . '
											</div>
										</div>
										<div class="fr-hero2-video">
											<p> ' . $video_heading_title . '</p>  
											<span>' . $video_desc . '</span>
											<div class="ripple"></div>
											' . $video_link . '
										</div>
									</div>
								</div>
							</div>
						</section>
						<section class="fr-logos">
							<div class="container">
								<div class="row">
									<div class="col-xl-6 col-lg-6 col-sm-12 col-md-6 col-12">
										<div class="row">
												' . $image_1 . '
												' . $image_2 . '
												' . $image_3 . '
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-sm-12 col-md-6 col-12">
										<div class="row sr">
												' . $image_4 . '
												' . $image_5 . '
												' . $image_6 . '
										</div>
									</div>
								</div>
							</div>
						</section>';
	}
	}

	if ( !function_exists( 'exertio_element_category_one' ) )
	{
		function exertio_element_category_one( $params )
		{
		  $items = $category_selected = $term_id = $image = '';
		  if ( $params[ 'select_category' ] == 'projects' ) {
			  
			$category_selected = $params[ 'project_category_list' ];
			foreach ( $category_selected as $category_selecteds )
			{
			  $image = $category_selecteds[ 'project_cat_image' ];
			  $term_id = $category_selecteds[ 'category_selection' ];


			  $term_data = get_term( $term_id );
				if(!empty($term_data) && ! is_wp_error($term_data))
				{
					$icon = $icon_html = $icon_id = '';
					$icon_library = $category_selecteds[ 'project_cat_icon' ][ 'library' ];
					if(isset($icon_library) && $icon_library == 'svg')
					{
						$icon = $category_selecteds[ 'project_cat_icon' ][ 'value' ]['url'];
						$icon_id = $category_selecteds[ 'project_cat_icon' ][ 'value' ]['id'];
						$icon_html = '<img src="' . $icon . '" alt="'.get_post_meta( $icon_id, '_wp_attachment_image_alt', TRUE ).'">';
					}
					else
					{
						$icon = $category_selecteds[ 'project_cat_icon' ][ 'value' ];
						$icon_html = '<i class="' . $icon . '"></i>';
					}
				  if ( !empty( $term_data ) && !is_wp_error( $term_data ) )
				  {
					$items .= '<div class="item">
								<div class="fr-explore-content">
								  <div class="fr-explore-product">
									<a href="' . get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . "?category=" . $term_id . '"><img src="' . $image[ 'url' ] . '" alt="' . get_post_meta( $image[ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a>
									<div class="fr-explore-container">
										<a href="' . get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . "?category=" . $term_id . '">
											<div class="fr-heading-style">' . $term_data->name . '</div>
										</a>
										<span>' . $term_data->count . __( ' Listings', 'exertio_framework' ) . '</span> </div>
										<a href="' . get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . "?category=" . $term_id . '">
											<div class="fr-log-grid"> '. $icon_html . '</div>
										</a>
									</div>
								</div>
							  </div>';
				  }
				}
			}
		  } else if ( $params[ 'select_category' ] == 'services' ) {
			$category_selected = $params[ 'services_category_list' ];
			foreach ( $category_selected as $category_selecteds ) {
			  $image = $category_selecteds[ 'service_cat_image' ];
			  $term_id = $category_selecteds[ 'services_category_selection' ];
			  $term_data = get_term( $term_id );
			  if ( !empty( $term_data ) && !is_wp_error( $term_data ) ) {
				$items .= '<div class="item">
											<div class="fr-explore-content">
											  <div class="fr-explore-product">
												<a href="' . get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . "?categories=" . $term_id . '"><img src="' . $image[ 'url' ] . '" alt="' . get_post_meta( $image[ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"></a>
												<div class="fr-explore-container">
													<a href="' . get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . "?categories=" . $term_id . '">
														<div class="fr-heading-style">' . $term_data->name . '</div>
													</a>
													<span>' . $term_data->count . __( ' Listings', 'exertio_framework' ) . '</span> </div>
													<a href="' . get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . "?categories=" . $term_id . '">
														<div class="fr-log-grid"> <i class="' . $category_selecteds[ 'service_cat_icon' ][ 'value' ] . '"></i> </div>
													</a>
												</div>
											</div>
										  </div>';
			  }
			}
		  }
		  return '<section class="fr-explore-cat">
						  <div class="container">
							<div class="row">
							  <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 explore-position">
								' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
							  </div>
							  <div class="col-xl-12 col-xs-12 col-md-12 col-lg-12">
								<div class="no-arrow explore-slider owl-carousel owl-theme">
								  ' . $items . '
								</div>
							  </div>
							</div>
						  </div>
						</section>';
	}
	}
	if ( !function_exists( 'exertio_element_call_to_action_one' ) )
	{
		function exertio_element_call_to_action_one( $params )
		{
		  $btn_detail = $btn_link = $left_side = $right_side = '';
		  $btn_link = $params[ 'btn_link' ];
		  $side_image = $params[ 'side_image' ];
		  $side_image_positiony = $params[ 'side_image_positiony' ];
		  if ( $side_image_positiony == 'left' ) {
			$right_side = '';
			$left_side = '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="fr-about2-img">
											<img src="' . $side_image[ 'url' ] . '" alt="' . get_post_meta( $params[ 'side_image' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid">
										</div>
									</div>';
		  } else if ( $side_image_positiony == 'right' ) {
			$left_side = '';
			$right_side = '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="fr-about2-img">
											<img src="' . $side_image[ 'url' ] . '" alt="' . get_post_meta( $params[ 'side_image' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid">
										</div>
									</div>';
		  }

		  if ( !empty( $params[ 'btn_text' ] ) ) {
			$target = $btn_link[ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
			$btn_detail = '<a href="' . esc_url( $btn_link[ 'url' ] ) . '" class="btn btn-theme" ' . $target . ' ' . $nofollow . '>' . $params[ 'btn_text' ] . '</a>';
		  }
		  return '<section class="fr-about2 padding-bottom-80">
							<div class="container">
								<div class="row">
									' . $left_side . '
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 align-self-center">
										<div class="fr-about2-texts">
											<span>' . $params[ 'sub_title_text' ] . '</span>
											<h2>' . $params[ 'heading_text' ] . '</h2>
											' . $params[ 'desc_text' ] . '
											' . $btn_detail . '
										</div>
									</div>
									' . $right_side . '
								</div>
							</div>
						</section>';
		}
	}

	if ( !function_exists( 'exertio_element_services' ) )
	{
		function exertio_element_services( $params )
		{
			$services_count = $services_type = $services_grid_style = $col = '';
			$services_grid_style = $params[ 'services_grid_style' ];
			$services_type = $params[ 'services_type' ];
			$services_count = $params[ 'services_count' ];
			$services_slider_grids = $params[ 'services_slider_grids' ];
			$services_grids_cols = $params[ 'services_grids_cols' ];


			$grid_style = 'grid_1';
			if ( $services_grid_style == 1 ) {
			$grid_style = 'grid_1';
			} else if ( $services_grid_style == 2 ) {
			$grid_style = 'grid_2';
			}
			if ( $services_grids_cols == 1 ) {
			$col = 'col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			} else if ( $services_grids_cols == 2 ) {
			$col = 'col-xl-4 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			} else if ( $services_grids_cols == 3 ) {
			$col = 'col-xl-6 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			} else if ( $services_grids_cols == 4 ) {
			$col = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}

			$is_slider = $services_slider_grids == 'slider' ? 'top-services-2 owl-carousel owl-theme' : 'row grid';
			$is_grid = $services_slider_grids == 'grids' ? $col : 'item';

			$featured = '';
			if ( $services_type == 'featured' )
			{
				$featured = array(
				  'key' => '_service_is_featured',
				  'value' => '1',
				  'compare' => '=',
				);
				} else if ( $services_type == 'simple' ) {
				$featured = array(
				  'key' => '_service_is_featured',
				  'value' => '0',
				  'compare' => '=',
				);
			}
            $service_categories = '';
            if (isset($params['services_categories']) && $params['services_categories'] != "" && $params['services_categories'] != 'all') {
                $service_categories = array(
                    array(
                        'taxonomy' => 'service-categories',
                        'field' => 'term_id',
                        'terms' => $params['services_categories'],
                    ),
                );
            }
			$args = array(
			'post_type' => 'services',
			'post_status' => 'publish',
			'posts_per_page' => $services_count,
			'orderby' => 'date',
			'order' => 'DESC',
            'tax_query' => array(
                $service_categories,
            ),
			'meta_query' => array(
			  array(
				'key' => '_service_status',
				'value' => 'active',
				'compare' => '=',
			  ),
			  $featured,
			),
			);
			$results = new WP_Query( $args );

			?>
			<section class="fr-serv-2 fr-services-content-2">
			  <div class="container">
				<div class="row fr-serv2">
				  <div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
					<?php
					echo exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] );
					?>
					<div class="<?php echo esc_attr($is_slider); ?>">
					  <?php
					  $layout_type = new exertio_get_services();
					  if ( $results->have_posts() ) {
						while ( $results->have_posts() ) {
						  $results->the_post();
						  $service_id = get_the_ID();

						  $function = "exertio_listings_$grid_style";
						  $fetch_output = $layout_type->$function( $service_id, $is_grid );
						  echo ' ' . $fetch_output;
						}
					  }
					  ?>
					</div>
				  </div>
				</div>
			  </div>
			</section>
			<?php
		}
	}
	if ( !function_exists( 'exertio_element_pricing' ) )
	{
	  function exertio_element_pricing( $params )
	  {
		if ( class_exists( 'WooCommerce' ) )
		{
			$package_type = $params[ 'package_type' ];
			$employers_packages_list = $params[ 'employers_packages_list' ];
			$freelancers_packages_list = $params[ 'freelancers_packages_list' ];
			$col_size = $params[ 'package_col_size' ];

			$cols = '';
			if ( $col_size == 1 ) {
			  $cols = 'col-xl-4 col-sm-6 col-md-6 col-xs-12 col-lg-4';
			} else if ( $col_size == 2 ) {
			  $cols = 'col-xl-3 col-sm-6 col-md-6 col-xs-12 col-lg-4';
			}

			$packages = '';
			if ( $package_type == 'employers' )
			{
			  foreach ( $employers_packages_list as $employers_packages_lists )
			  {
				$product_price = '';

				$product_id = $employers_packages_lists[ 'employer_package_selection' ];
				$product = wc_get_product( $product_id );

				if(!empty($product))
				{
					$product_title = $product->get_title();
					$reg_price = $product->get_regular_price();
					$sale_price = $product->get_sale_price();;
					//$product_desc = $product->get_description();
					$product_desc = '';

					$simple_projects = get_post_meta( $product_id, '_simple_projects', true );
					if ( isset( $simple_projects ) && $simple_projects > 0 ) {
					  $simple_projects = '<i class="fa fa-check"></i>' . $simple_projects . __( ' Project Allowed', 'exertio_framework' );
					} else if ( isset( $simple_projects ) && $simple_projects == -1 ) {
					  $simple_projects = '<i class="fa fa-check"></i>' . __( 'Unlimited Project Allowed', 'exertio_framework' );
					} else {
					  $simple_projects = '<i class="fas fa-times"></i>' . $simple_projects . __( ' Project Allowed', 'exertio_framework' );
					}


					$simple_projects_expiry = get_post_meta( $product_id, '_simple_project_expiry', true );
					if ( isset( $simple_projects_expiry ) && $simple_projects_expiry > 0 ) {
					  $simple_projects_expiry = '<i class="fa fa-check"></i>' . $simple_projects_expiry . __( ' Days visibility', 'exertio_framework' );
					} else if ( isset( $simple_projects_expiry ) && $simple_projects_expiry == -1 ) {
					  $simple_projects_expiry = '<i class="fa fa-check"></i>' . __( 'Lifetime visibility', 'exertio_framework' );
					} else {
					  $simple_projects_expiry = '<i class="fas fa-times"></i>' . $simple_projects_expiry . __( ' Days visibility', 'exertio_framework' );
					}


					$featured_projects = get_post_meta( $product_id, '_featured_projects', true );
					if ( isset( $featured_projects ) && $featured_projects > 0 ) {
					  $featured_projects = '<i class="fa fa-check"></i>' . $featured_projects . __( ' Featured Projects', 'exertio_framework' );
					} else if ( isset( $featured_projects ) && $featured_projects == -1 ) {
					  $featured_projects = '<i class="fa fa-check"></i>' . __( 'Unlimited Featured Project', 'exertio_framework' );
					} else {
					  $featured_projects = '<i class="fas fa-times"></i>' . $featured_projects . __( ' Featured Projects', 'exertio_framework' );
					}


					$featured_projects_expiry = get_post_meta( $product_id, '_featured_project_expiry', true );
					if ( isset( $featured_projects_expiry ) && $featured_projects_expiry > 0 ) {
					  $featured_projects_expiry = '<i class="fa fa-check"></i>' . $featured_projects_expiry . __( ' Days Featured', 'exertio_framework' );
					} else if ( isset( $featured_projects_expiry ) && $featured_projects_expiry == -1 ) {
					  $featured_projects_expiry = '<i class="fa fa-check"></i>' . __( 'Lifetime Featured', 'exertio_framework' );
					} else {
					  $featured_projects_expiry = '<i class="fas fa-times"></i>' . $featured_projects_expiry . __( ' Days Featured', 'exertio_framework' );
					}

					$featured_profile = '';
					$profile = get_post_meta( $product_id, '_employer_is_featured', true );
					if ( $profile == 1 ) {
					  $featured_profile = '<i class="fa fa-check"></i>' . __( 'Profile featured', 'exertio_framework' );
					} else if ( $profile == 0 ) {
					  $featured_profile = '<i class="fas fa-times"></i>' . __( 'Featured Profile', 'exertio_framework' );
					}

					$package_expiry = get_post_meta( $product_id, '_employer_package_expiry', true );
					if ( isset( $package_expiry ) && $package_expiry > 0 ) {
					  $package_expiry = '<i class="fa fa-check"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
					} else if ( isset( $package_expiry ) && $package_expiry == -1 ) {
					  $package_expiry = '<i class="fa fa-check"></i>' . __( 'Never Expire', 'exertio_framework' );
					} else {
					  $package_expiry = '<i class="fas fa-times"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
					}


					if ( isset( $sale_price ) && $sale_price != '' ) {
					  $product_price = '<span class="strike">' . fl_price_separator( $reg_price ) . '</span>' . fl_price_separator( $sale_price );
					} else {
					  $product_price = fl_price_separator( $reg_price );
					}


					$color = $featured_tag = $featured_class = '';
					/*FOR FEATURED TAG*/
					$is_featured = $employers_packages_lists[ 'is_package_featured' ];
					if ( $is_featured == 'yes' ) {
					  $featured_tag = '<div class="pricing-badge"> <span class="featured">' . $employers_packages_lists[ 'is_featured_text' ] . '</span> </div>';
					  $featured_class = 'featured-pricing';
					}

					if ( $employers_packages_lists[ 'employer_background_color' ] == 'white' ) {
					  $color = 'fr-plan-basics-2';
					}

					$packages .= '<div class="' . $cols . '">
												<div class="fr-plan-basics ' . $color . ' ' . $featured_class . '">
													' . $featured_tag . '
												  <div class="fr-plan-content">
													<h2>' . $product_title . '</h2>
													<p>' . $product_desc . '</p>
													<h3>' . $product_price . '</h3>
													<button data-product-id ="' . $product_id . '" class="emp-purchase-package btn-loading">' . __( ' Purchase Now', 'exertio_framework' ) . '
													<span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
													</button>
													<input type="text" class="employer_package_nonce" hidden="" value="' . wp_create_nonce( 'employer_package_nonce_value' ) . '">
												</div>
												  <div class="fr-plan-details">
													<ul>
													  <li>' . $simple_projects . '</li>
													  <li>' . $simple_projects_expiry . '</li>
													  <li>' . $featured_projects . '</li>
													  <li>' . $featured_projects_expiry . '</li>
													  <li>' . $featured_profile . '</li>
													  <li>' . $package_expiry . '</li>
													</ul>
												  </div>
												</div>
											  </div>';
				  }
			  }
			}
			else if ( $package_type == 'freelancers' )
			{
			  foreach ( $freelancers_packages_list as $freelancers_packages_lists )
			  {

				$products_id = $freelancers_packages_lists[ 'freelancer_package_selection' ];
				$product = wc_get_product( $products_id );

				if(!empty($product))
				{
					$product_title = $product->get_title();
					$reg_price = $product->get_regular_price();
					$sale_price = $product->get_sale_price();;
					$product_desc = $product->get_description();
					$project_credits = get_post_meta( $products_id, '_project_credits', true );


					if ( isset( $sale_price ) && $sale_price != '' ) {
					  $product_price = '<span class="strike">' . fl_price_separator( $reg_price ) . '</span>' . fl_price_separator( $sale_price );
					} else {
					  $product_price = fl_price_separator( $reg_price );
					}

					if ( isset( $project_credits ) && $project_credits > 0 ) {
					  $project_credits = '<i class="fa fa-check"></i>' . $project_credits . __( ' Project Credits', 'exertio_framework' );
					} else if ( isset( $project_credits ) && $project_credits == -1 ) {
					  $project_credits = '<i class="fa fa-check"></i>' . __( 'Unlimited Project Credits', 'exertio_framework' );
					} else {
					  $project_credits = '<i class="fas fa-times"></i>' . $project_credits . __( ' Project Credits', 'exertio_framework' );
					}

					$simple_services = get_post_meta( $products_id, '_simple_services', true );
					if ( isset( $simple_services ) && $simple_services > 0 ) {
					  $simple_services = '<i class="fa fa-check"></i>' . $simple_services . __( ' Allowed Services', 'exertio_framework' );
					} else if ( isset( $simple_services ) && $simple_services == -1 ) {
					  $simple_services = '<i class="fa fa-check"></i>' . __( ' Unlimited Services', 'exertio_framework' );
					} else {
					  $simple_services = '<i class="fas fa-times"></i>' . $simple_services . __( ' Allowed Services', 'exertio_framework' );
					}

					$simple_services_expiry = get_post_meta( $products_id, '_simple_service_expiry', true );
					if ( isset( $simple_services_expiry ) && $simple_services_expiry > 0 ) {
					  $simple_services_expiry = '<i class="fa fa-check"></i>' . $simple_services_expiry . __( ' Days visibility', 'exertio_framework' );
					} else if ( isset( $simple_services_expiry ) && $simple_services_expiry == -1 ) {
					  $simple_services_expiry = '<i class="fa fa-check"></i>' . __( 'Services Never Expire', 'exertio_framework' );
					} else {
					  $simple_services_expiry = '<i class="fas fa-times"></i>' . $simple_services_expiry . __( ' Days visibility', 'exertio_framework' );
					}

					$featured_services = get_post_meta( $products_id, '_featured_services', true );
					if ( isset( $featured_services ) && $featured_services > 0 ) {
					  $featured_services = '<i class="fa fa-check"></i>' . $featured_services . __( ' Featured Services', 'exertio_framework' );
					} else if ( isset( $featured_services ) && $featured_services == -1 ) {
					  $featured_services = '<i class="fa fa-check"></i>' . __( 'Unlimited Featured Services', 'exertio_framework' );
					} else {
					  $featured_services = '<i class="fas fa-times"></i>' . __( ' Featured Services', 'exertio_framework' );
					}

					$featured_services_expiry = get_post_meta( $products_id, '_featured_services_expiry', true );
					if ( isset( $featured_services_expiry ) && $featured_services_expiry > 0 ) {
					  $featured_services_expiry = '<i class="fa fa-check"></i>' . $featured_services_expiry . __( ' Days visibility', 'exertio_framework' );
					} else if ( isset( $featured_services_expiry ) && $featured_services_expiry == -1 ) {
					  $featured_services_expiry = '<i class="fa fa-check"></i>' . __( 'Services Never Expire', 'exertio_framework' );
					} else {
					  $featured_services_expiry = '<i class="fas fa-times"></i>' . $featured_services_expiry . __( ' Days visibility', 'exertio_framework' );
					}

					$package_expiry = get_post_meta( $products_id, '_freelancer_package_expiry', true );
					if ( isset( $package_expiry ) && $package_expiry > 0 ) {
					  $package_expiry = '<i class="fa fa-check"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
					} else if ( isset( $package_expiry ) && $package_expiry == -1 ) {
					  $package_expiry = '<i class="fa fa-check"></i>' . __( 'Package Never Expire', 'exertio_framework' );
					} else {
					  $package_expiry = '<i class="fas fa-times"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
					}

                    $renew_listing = get_post_meta( $products_id, '_freelancer_listing_renew', true );
                    if ( isset( $renew_listing ) && $renew_listing > 0 ) {
                        $renew_listing = '<i class="fa fa-check"></i>' . $renew_listing . __( ' Renew Expired Project/Service', 'exertio_framework' );
                    } else if ( isset( $renew_listing ) && $renew_listing == -1 ) {
                        $renew_listing = '<i class="fa fa-check"></i>' . __( 'Never Expire', 'exertio_framework' );
                    } else {
                        $renew_listing = '<i class="fas fa-times"></i>' . $renew_listing . __( ' Days Package Expiry', 'exertio_framework' );
                    }

					$is_featured = get_post_meta( $products_id, '_freelancer_is_featured', true );
					$freelacner_featured_text =  '';
					if ( isset( $is_featured ) && $is_featured == 1 ) {
					  $freelacner_featured_text = '<i class="fa fa-check"></i>' . __( ' Profile Featured: ', 'exertio_framework' );
					} else {
					  $freelacner_featured_text = '<i class="fa fa-times"></i>' . __( ' Profile Featured: ', 'exertio_framework' ) ;
					}


					$color = $featured_tag = $featured_class = '';
					/*FOR FEATURED TAG*/
					$is_featured = $freelancers_packages_lists[ 'is_package_featured' ];
					if ( $is_featured == 'yes' ) {
					  $featured_tag = '<div class="pricing-badge"> <span class="featured">' . $freelancers_packages_lists[ 'is_featured_text' ] . '</span> </div>';
					  $featured_class = 'featured-pricing';
					}

					if ( $freelancers_packages_lists[ 'freelancer_background_color' ] == 'white' ) {
					  $color = 'fr-plan-basics-2';
					}

					$packages .= '<div class="' . $cols . '">
												<div class="fr-plan-basics ' . $color . ' ' . $featured_class . '">
												' . $featured_tag . '
												  <div class="fr-plan-content">
													<h2>' . $product_title . '</h2>
													<p>' . $product_desc . '</p>
													<h3>' . $product_price . '</h3>
													<button data-product-id ="' . $products_id . '" class="freelancer-purchase-package btn-loading">' . __( ' Purchase Now', 'exertio_framework' ) . '
													<span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
													</button>
													<input type="text" class="freelancer_package_nonce" hidden="" value="' . wp_create_nonce( 'freelancer_package_nonce_value' ) . '">
												</div>
												  <div class="fr-plan-details">
													<ul>
													  <li>' . $project_credits . '</li>
													  <li>' . $simple_services . '</li>
													  <li>' . $simple_services_expiry . '</li>
													  <li>' . $featured_services . '</li>
													  <li>' . $featured_services_expiry . '</li>
													  <li>' . $package_expiry . '</li>
													  <li>' . $freelacner_featured_text . '</li>

													</ul>
												  </div>
												</div>
											  </div>';
			  }
			  }
			}
			return '<section class="fr-about-plan">
						<div class="container">
							<div class="row">
							  <div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
								' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
							</div>
							<div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
								<div class="exertio-pricing">
									<div class="row">
										' . $packages . '
									</div>
								</div>
							</div>
						  </div>
						</div>
					</section>';
		}
	  }

	}

	if ( !function_exists( 'exertio_element_testimonial' ) )
	{
	  function exertio_element_testimonial( $params )
	  {
		$main_image = $params[ 'main_image' ];
		$testimonial_list = $params[ 'testimonial_list' ];

		$items = '';
		foreach ( $testimonial_list as $testimonial_lists ) {

		  $items .= '<div class="item">
									<div class="fr-c-about-style">
									  <div class="fr-c-about-profile"> <img src="' . $testimonial_lists[ 'user_image' ][ 'url' ] . '" alt="' . get_post_meta( $testimonial_lists[ 'user_image' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"> </div>
									  <div class="fr-client-about-details"> <span>' . $testimonial_lists[ 'subheading_text' ] . '</span>
										<h3>' . $testimonial_lists[ 'heading_text' ] . '</h3>
										<p>' . $testimonial_lists[ 'desc_text' ] . '</p>
										<div class="fr-client-sm">
										  <p>' . $testimonial_lists[ 'reviewer_name' ] . '</p>
										  <span>' . $testimonial_lists[ 'designation' ] . '</span> </div>
									  </div>
									</div>
								  </div>';
		}
		return '<section class="fr-about2-client fr-about-client">
						  <div class="container">
							<div class="row no-gutters">
							  <div class="col-lg-5 col-xl-5 col-sm-0 col-md-0 col-xs-12">
								<div class="fr-c-about-products"> <img src="' . $main_image[ 'url' ] . '" alt="' . get_post_meta( $main_image[ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"> </div>
							  </div>
							  <div class="col-lg-7 col-xl-7 col-sm-12 col-md-12 col-xs-12">
								<div class="client-slider owl-carousel owl-theme">
								  ' . $items . '
								</div>
							  </div>
							</div>
						  </div>
						</section>';
	  }
	}
	
	if ( !function_exists( 'exertio_element_testimonial_two' ) )
	{
	  function exertio_element_testimonial_two( $params )
	  {
		$quote_icon = $params[ 'quote_icon' ];
		$testimonial_list = $params[ 'testimonial_list' ];

		$items = '';
		foreach ( $testimonial_list as $testimonial_lists ) {

			$items .= '<div class="row align-items-center justify-content-between">
                    <div class="col col-lg-5 col-md-5 d-sm-none d-md-none d-xl-block d-lg-block">
                        <div class="img-holder">
                            <img src="' . $testimonial_lists[ 'user_image' ][ 'url' ] . '" class="img-fluid" alt="' . get_post_meta( $testimonial_lists[ 'user_image' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '">
							<div class="icons-img">
								<img src="' . $quote_icon[ 'url' ] . '" class="img-fluid" alt="' . get_post_meta( $quote_icon[ 'id' ], '_wp_attachment_image_alt', TRUE ) . '">
							</div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-lg-offset-1 col-md-12">
                        <div class="details">
                           <p>' . $testimonial_lists[ 'desc_text' ] . '</p>
                              <h4>' . $testimonial_lists[ 'reviewer_name' ] . '</h4>
                                <span>' . $testimonial_lists[ 'designation' ] . '</span>
                        </div>
                    </div>
                    </div>';
		}
		return '<section class="testimonial-section-fancy">
						  <div class="container">
						  	<div class="row">
								<div class="col-xl-12 col-lg-12 col-xs-12 col-md-12 col-xs-12">
									' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
								</div>
							</div>
							<div class="row">
							  <div class="col-lg-12 col-xl-12 col-sm-12 col-md-12 col-xs-12">
								<div class="my-testimonials owl-carousel owl-theme">
								  ' . $items . '
								</div>
							  </div>
							</div>
						  </div>
						</section>';
	  }
	}

	if ( !function_exists( 'exertio_element_blog' ) )
	{
	  function exertio_element_blog( $params )
	  {
		$args = array( 'post_status' => 'publish', 'numberposts' => $params[ 'no_of_post' ] );
		$recent_posts = wp_get_recent_posts( $args );
		$blog_posts = $cols = '';


		if ( isset( $params[ 'blog_grids_cols' ] ) && $params[ 'blog_grids_cols' ] == 1 ) {
		  $cols = 'col-xxl-3 col-xl-4 col-sm-6 col-lg-6 col-xs-12 col-md-6';
		} else if ( isset( $params[ 'blog_grids_cols' ] ) && $params[ 'blog_grids_cols' ] == 2 ) {
		  $cols = 'col-xxl-4 col-xl-4 col-sm-6 col-lg-6 col-xs-12 col-md-6';
		} else if ( isset( $params[ 'blog_grids_cols' ] ) && $params[ 'blog_grids_cols' ] == 3 ) {
		  $cols = 'col-xl-6 col-sm-6 col-lg-6 col-xs-12 col-md-6';
		}
		foreach ( $recent_posts as $recent ) {

		  $post_author = $recent[ "post_author" ];
		  $thumbnail = '';
		  if ( has_post_thumbnail( $recent[ "ID" ] ) ) {
			$thumbnail = '<div class="fr-latest-content"><a href="' . esc_url( get_the_permalink( $recent[ "ID" ] ) ) . '">
								' . exertio_get_feature_image( $recent[ "ID" ], 'blog-grid-img' ) . ' </a>				
						</div>';
		  }

		  $blog_posts .= '<div class="' . $cols . ' grid-item">
									<div class="fr-latest-box">
									 ' . $thumbnail . '
									  <div class="fr-latest-sm">
										<div class="fr-latest-content"> <a href="' . esc_url( get_the_permalink( $recent[ "ID" ] ) ) . '">
										  <h3>' . wp_trim_words( $recent[ "post_title" ], $params['title_limit'] ). '</h3>
										  </a>
										  <div class="fr-latest-style">
											<ul>
											  <li> <a href="' . esc_url( get_author_posts_url( $post_author ) ) . '">
												<div class="fr-latest-profile"> ' . get_avatar( $post_author, 40 ) . '<span>' . get_the_author_meta( 'nicename', $post_author ) . '</span> </div>
												</a> </li>
											  <li>
												<div class="fr-latest-profile"> <i class="fa fa-calendar"></i> <span>' . get_the_time( get_option( 'date_format' ), $recent[ "ID" ] ) . '</span> </div>
											  </li>
											</ul>
										  </div>
										</div>
										<div class="fr-latest-container">
										  <p>' . wp_trim_words( get_the_excerpt( $recent[ "ID" ] ), $params['desc_limit'] ) . '</p>
										  <a href="' . esc_url( get_the_permalink( $recent[ "ID" ] ) ) . '"><span class="readmore">' . esc_html__( 'Read More', 'exertio_framework' ) . '<i class="fas fa-long-arrow-alt-right"></i></span></a> </div>
									  </div>
									</div>
								</div>';
		}

		return '<section class="">
							<div class="container">
								<div class="row">
									<div class="col-xl-12 col-lg-12 col-xs-12 col-md-12 col-xs-12">
										' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
									</div>
								</div>
								<div class="row grid">
									' . $blog_posts . '
								</div>
							</div>
						</section>';
	  }
	}

	if ( !function_exists( 'exertio_element_category_list' ) )
	{
	  function exertio_element_category_list( $params )
	  {
		$cols = $item = '';
		$cols_size = $params[ 'category_col_size' ];
		$list = $params[ 'tax_list' ];
		if ( $cols_size == 1 ) {
		  $cols = 'col-xxl-2 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4';
		} else if ( $cols_size == 2 ) {
		  $cols = 'col-xxl-3 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4';
		} else if ( $cols_size == 3 ) {
		  $cols = 'col-xxl-4 col-xl-4 col-6 col-sm-4 col-md-4 col-lg-4';
		} else if ( $cols_size == 4 ) {
		  $cols = 'col-xxl-6 col-xl-6 col-6 col-sm-6 col-md-4 col-lg-6';
		} else if ( $cols_size == 5 ) {
		  $cols = 'col-xxl-12 col-xl-12 col-12 col-sm-12 col-md-12 col-lg-12';
		}

		foreach ( $list as $features ) {
		  $inner_items = $listings_link = '';
		  $selected_listing = $features[ 'list_one_select_skills' ];
		  if ( $selected_listing == 'pro_cat' ) {
			$listings = $features[ 'project_category' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?category';
		  }
		  if ( $selected_listing == 'pro_skills' ) {
			$listings = $features[ 'project_skills' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?skill';
		  }
		  if ( $selected_listing == 'service_cat' ) {
			$listings = $features[ 'services_categories' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . '?categories';
		  }
		  if ( $selected_listing == 'freelancer_skils' ) {
			$listings = $features[ 'freelancer_skills' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'freelancer_search_page' ) ) . '?skill';
		  }
		  if ( $selected_listing == 'pro_loc' ) {
			$listings = $features[ 'preoject_locations' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . '?location';
		  }
		  if ( $selected_listing == 'ser_loc' ) {
			$listings = $features[ 'services_locations' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . '?location';
		  }
		  if ( $selected_listing == 'emp_loc' ) {
			$listings = $features[ 'employers_locations' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'employer_search_page' ) ) . '?location';
		  }
		  if ( $selected_listing == 'free_loc' ) {
			$listings = $features[ 'freelancer_locations' ];
			$listings_link = get_the_permalink( fl_framework_get_options( 'freelancer_search_page' ) ) . '?location';
		  }
			if(isset($listings) && $listings != '')
			{
				foreach ( $listings as $listing )
				{
					$term_data = get_term( $listing );
					if(!empty($term_data) && ! is_wp_error($term_data))
					{
						$term_id = $term_data->term_id;
						$inner_items .= '<li><a href="' . $listings_link . '=' . $term_id . '">' . esc_html( $term_data->name ) . '</a></li>';
					}
				}
				$inner_items .= '<li><a href="' . $listings_link . '=" class="view-more">' . esc_html__('View More','exertio_framework') . '</a></li>';;
			}
		  $item .= '<div class="' . $cols . ' grid-item">
							<div class="fr-browse-content browse-style">
							  <h3>' . $features[ 'list_title' ] . '</h3>
							  <ul>' . $inner_items . '</ul>
							</div>
						  </div>';
		}
		return '<section class="fr-browse-category">
							<div class="container">
								<div class="row">
									<div class="col-xl-12 col-lg-12 col-xs-12 col-md-12 col-xs-12">
										' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
									</div>
								</div>
								<div class="row grid">
									' . $item . '
								</div>
							</div>
						</section>';
	  }
	}

	if ( !function_exists( 'exertio_element_hero_two' ) )
	{
	  function exertio_element_hero_two( $params )
	  {
		$sec_btn = $main_btn = $desc = $main_heading = $post_type_links = $placehoder_text = $select_placeholder_text = $search_btn_title = $keyword_titles = $video_heading_title = $video_desc = $video_link = $keyword_selection = $keywords = $sub_heading = $keyword_link = $action = '';

		if ( !empty( $params[ 'heading_text' ] ) ) {
		  $main_heading = '<h1>' . $params[ 'heading_text' ] . '</h1>';
		}
		if ( !empty( $params[ 'sub_heading_text' ] ) ) {
		  $sub_heading = '<span>' . $params[ 'sub_heading_text' ] . '</span>';
		}
		if ( !empty( $params[ 'item_description' ] ) ) {
		  $desc = '<p> ' . $params[ 'item_description' ] . ' </p>';
		}
		if ( !empty( $params[ 'search_field_placeholder_text' ] ) ) {
		  $placehoder_text = $params[ 'search_field_placeholder_text' ];
		}
		if ( !empty( $params[ 'select_placeholder_text' ] ) ) {
		  $select_placeholder_text = $params[ 'select_placeholder_text' ];
		}
		if ( !empty( $params[ 'search_btn_title' ] ) ) {
		  $search_btn_title = $params[ 'search_btn_title' ];
		}
		if ( !empty( $params[ 'keyword_titles' ] ) ) {
		  $keyword_titles = $params[ 'keyword_titles' ];
		}
		if ( !empty( $params[ 'video_heading_title' ] ) ) {
		  $video_heading_title = $params[ 'video_heading_title' ];
		}
		if ( !empty( $params[ 'video_desc' ] ) ) {
		  $video_desc = $params[ 'video_desc' ];
		}
		if ( !empty( $params[ 'video_link' ] ) ) {
		  $video_link = $params[ 'video_link' ];
		}
		//print_r($video_link);

		$post_type = $params[ 'post_type_select' ];
		$post_type_links .= '<select class="default-select post-type-change">';
		$post_type_links .= '<option value="'.$select_placeholder_text.'">'.$select_placeholder_text.'</option>';
		foreach ( $post_type as $post_types ) {
			$name = exertio_cpt_array_hero_section($post_types );
		  $post_type_links .= '<option value="'.esc_attr($post_types).'">' . esc_html($name) . '</option>';
			
			$action = exertio_get_cpt_page_link($post_types);
		}
		$post_type_links .= '</select>';

		if ( !empty( $params[ 'video_link' ] ) && is_array( $params[ 'video_link' ] ) ) {
		  $target = $params[ 'video_link' ][ 'is_external' ] ? ' target="_blank"' : '';
		  $nofollow = $params[ 'video_link' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
		  $video_link = '<a href="' . esc_url( $params[ 'video_link' ][ 'url' ] ) . '" ' . $target . $nofollow . ' class="popup-video"><i class="fa fa-play" aria-hidden="true"></i></a>';
		}


		/*KEYWORD POST TYPE*/
		$keyword_post_type = $params[ 'keyword_post_type' ];

		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Projects' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Services' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'services_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Employers' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'employer_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Freelancer' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'freelancer_search_page' ) );
		}

		$keyword_selection = $params[ 'keyword_selection' ];
		if ( !empty( $keyword_selection ) ) {
		  $keyword_parts = explode( "|", $keyword_selection );

		  foreach ( $keyword_parts as $keyword_part ) {
			$keywords .= "<a href='" . $keyword_link . "?title=" . $keyword_part . "'>" . $keyword_part . "</a>";
		  }
		}
		$search_field_toggle = $params['search_field_switch'];
		if(isset($search_field_toggle) && $search_field_toggle == 1)
		{
			$search_form = '<div class="fr-hero3-srch">
									<form class="hero-one-form" action="'.esc_url($action).'">
									  <ul>
										<li>
										  <div class="form-group">
											<input type="text" placeholder="' . $placehoder_text . '" class="form-control" name="title">
										  </div>
										</li>
										<li>
										  <div class="form-group">
											' . $post_type_links . '
											<div class="fr-hero3-submit"> <button class="btn btn-theme"><i class="fa fa-search-plus"></i>' . $search_btn_title . '</button> </div>
										  </div>
										</li>
									  </ul>
									</form>
								  </div>';
		}
		else
		{
			$search_form = '';
		}
		return '<section class="fr-hero3 herosection-2">
				  <div class="container">
					<div class="row">
						<div class="col-xl-7 col-12 col-sm-12 col-lg-7 col-md-8">
							<div class="fr-hero3-main">
							  <div class="fr-hero3-content">
								' . $sub_heading . '
								' . $main_heading . '
								' . $desc . '
							  </div>
							  '.$search_form.'
								<div class="fr-her3-elemnt">
									<p>' . $keyword_titles . '</p>
									' . $keywords . '	
								</div>
							</div>
							<div class="fr-hero3-video">
							  <div class="fr-hero3-text"> <span>' . $video_heading_title . '</span>
								<p>' . $video_desc . '</p>
							  </div>
							  ' . $video_link . '
							</div>
						</div>
					</div>
				  </div>
				</section>';
	  }
	}
	if ( !function_exists( 'exertio_element_category_two' ) )
	{
	  function exertio_element_category_two( $params )
	  {

		$items = $category_selected = $term_id = $image = '';
		if ( $params[ 'select_category' ] == 'projects' ) {
		  $category_selected = $params[ 'project_category_list' ];
		  foreach ( $category_selected as $category_selecteds ) {
			$image = $category_selecteds[ 'project_cat_image' ];
			$term_id = $category_selecteds[ 'category_selection' ];
			$term_data = get_term( $term_id );
			if(!empty($term_data) && ! is_wp_error($term_data))
			{
				$items .= '<div class="col-xl-3 col-sm-6  col-6 col-lg-3 col-md-4">
							<div class="fr-top-icons">
								<a	href="' . get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . "?category=" . $term_id . '">
									<img src="' . $image[ 'url' ] . '" alt="' . get_post_meta( $image[ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid">
								</a>
								<div class="top-style"><a href="' . get_the_permalink( fl_framework_get_options( 'project_search_page' ) ) . "?category=" . $term_id . '">' . $term_data->name . '</a></div>
							  <span>' . $term_data->count . __( ' Listings', 'exertio_framework' ) . '</span>
							  <p></p>
							</div>
						  </div>';
			}
		  }
		} else if ( $params[ 'select_category' ] == 'services' ) {
		  $category_selected = $params[ 'services_category_list' ];
		  foreach ( $category_selected as $category_selecteds ) {
			$image = $category_selecteds[ 'service_cat_image' ];
			$term_id = $category_selecteds[ 'services_category_selection' ];
			$term_data = get_term( $term_id );

			$items .= '<div class="col-xl-3 col-sm-6  col-6 col-lg-3 col-md-4">
									<div class="fr-top-icons">
										<a	href="' . get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . "?categories=" . $term_id . '">
											<img src="' . $image[ 'url' ] . '" alt="' . get_post_meta( $image[ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid">
										</a>
										<div class="top-style"><a href="' . get_the_permalink( fl_framework_get_options( 'services_search_page' ) ) . "?categories=" . $term_id . '">' . $term_data->name . '</a></div>
									  <span>' . $term_data->count . __( ' Listings', 'exertio_framework' ) . '</span>
									  <p></p>
									</div>
								  </div>';
		  }
		}
		return '<section class="fr-top3-category">
						  <div class="container">
							<div class="row">
							  <div class="col-lg-12 col-xl-12 col-md-12">
								<div class="fr-top3-content">
									' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
								</div>
							  </div>
							  <div class="col-xl-12 col-lg-12">
								<div class="row g-0">
									' . $items . '
								</div>
							  </div>
							</div>
						  </div>
						</section>';
	  }
	}
	if ( !function_exists( 'exertio_element_projects' ) )
	{
		function exertio_element_projects( $params )
		{
			$projects_count = $projects_type = $project_grid_style = $col = $projects_list_cols = '';
			$project_list_style = $params[ 'project_list_style' ];
			$projects_type = $params[ 'projects_type' ];
			$projects_count = $params[ 'projects_count' ];
			$projects_list_cols = $params[ 'projects_list_cols' ];


			if ( $projects_list_cols == 1 ) {
			  $col = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			} else if ( $projects_list_cols == 2 ) {
			  $col = 'col-xl-6 col-xs-12 col-lg-6 col-sm-12 col-md-6';
			}


			$featured = '';
			if ( $projects_type == 'featured' ) {
			  $featured = array(
				'key' => '_project_is_featured',
				'value' => '1',
				'compare' => '=',
			  );
			} else if ( $projects_type == 'simple' ) {
			  $featured = array(
				'key' => '_project_is_featured',
				'value' => '0',
				'compare' => '=',
			  );
			}
            $project_categories = '';
            if (isset($params['project_categories']) && $params['project_categories'] != "" && $params['project_categories'] != 'all') {
                $project_categories = array(
                    array(
                        'taxonomy' => 'project-categories',
                        'field' => 'term_id',
                        'terms' => $params['project_categories'],
                    ),
                );
            }
            $show_expired = '';
            $expired_projects = fl_framework_get_options('expired_project_search');
            if (isset($expired_projects) && $expired_projects == 0) {
                $show_expired = array(
                    'key'       => '_project_status',
                    'value'     => 'active',
                    'compare'   => '=',
                );
            }

			$args = array(
			  'post_type' => 'projects',
			  'post_status' => 'publish',
			  'posts_per_page' => $projects_count,
			  'orderby' => 'date',
			  'order' => 'DESC',
                'tax_query' => array(
                    $project_categories,
                ),
			  'meta_query' => array(
				$featured,
                $show_expired,
			  ),
			);
			$results = new WP_Query( $args );
			?>
			<section class="fr-latest2-job">
			<div class="container">
			<div class="row">
			  <div class="col-xl-12 col-sm-12 col-lg-12">
				<?php
				echo exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] );
				?>
			  </div>
			  <div class="col-xl-12 col-lg-12">
				<div class="row">
				  <?php
					$list_type = '';
				  $project_list_style = $project_list_style;
				  if ( isset( $project_list_style ) && $project_list_style != '' )
				  {
					$list_type = $project_list_style;
				  }
					if(isset($list_type) && $list_type != '')
					{
					  $layout_type = new exertio_get_projects();
					  if ( $results->have_posts() )
					  {
						$layout_type = new exertio_get_projects();
						while ( $results->have_posts() )
						{
						  $results->the_post();
						  $project_id = get_the_ID();
						  $function = "exertio_projects_$list_type";
						  $fetch_output = $layout_type->$function( $project_id, $col );
						  echo ' ' . $fetch_output;
						}
					  }
					}
				  ?>
				</div>
			  </div>
			</div>
			</div>
			</section>
			<?php
		}
	}
	if ( !function_exists( 'exertio_element_facts_counter' ) )
	{
	  function exertio_element_facts_counter( $params ) {
		$item = $section_position_class = '';
		$section_position = $params[ 'section_position' ];
		if ( $section_position == 1 ) {
		  $section_position_class = 'section-position';
		}
		$counter_lists = $params[ 'counter_list' ];
		foreach ( $counter_lists as $counter_list ) {

		  $item .= '<li>
								<div class="fr-about-icons"> <img src="' . $counter_list[ 'counter_icon' ] ['url']. '" alt="' . $counter_list[ 'counter_icon' ] ['id']. '" /> </div>
								<div class="fr-about-i-details">
								  <div class="counter-js"> <span class="counter">' . $counter_list[ 'counter_numbers' ] . ' + </div>
								  <p>' . $counter_list[ 'counter_title' ] . '</p>
								</div>
							 </li>';
		}

		return '<section class="fr-about2">
							<div class="container">
								<div class="row">
									<div class="col-xl-12 col-sm-12 col-md-12 col-xs-12">
									  <div class="fr-rev-2 fr-rev fr-about-reviews ' . $section_position_class . '">
										<ul>
										  ' . $item . '
										</ul>
									  </div>
									</div>
								</div>
							</div>
						</section>';
	  }
	}
	if ( !function_exists( 'exertio_element_hero_three' ) ) {
	  function exertio_element_hero_three( $params ) {
		$sec_btn = $main_btn = $desc = $main_heading = $post_type_links = $placehoder_text = $select_placeholder_text = $search_btn_title = $keyword_titles = $video_heading_title = $video_desc = $video_link = $keyword_selection = $keywords = $sub_heading = $keyword_link = $search_field_toggle = $action = '';

		  
		if ( !empty( $params[ 'heading_text' ] ) ) {
		  $main_heading = '<h1>' . $params[ 'heading_text' ] . '</h1>';
		}
		if ( !empty( $params[ 'sub_heading_text' ] ) ) {
		  $sub_heading = '<span>' . $params[ 'sub_heading_text' ] . '</span>';
		}
		if ( !empty( $params[ 'item_description' ] ) ) {
		  $desc = '<p> ' . $params[ 'item_description' ] . ' </p>';
		}
		if ( !empty( $params[ 'search_field_placeholder_text' ] ) ) {
		  $placehoder_text = $params[ 'search_field_placeholder_text' ];
		}
		if ( !empty( $params[ 'select_placeholder_text' ] ) ) {
		  $select_placeholder_text = $params[ 'select_placeholder_text' ];
		}
		if ( !empty( $params[ 'search_btn_title' ] ) ) {
		  $search_btn_title = $params[ 'search_btn_title' ];
		}
		if ( !empty( $params[ 'keyword_titles' ] ) ) {
		  $keyword_titles = $params[ 'keyword_titles' ];
		}
		if ( !empty( $params[ 'video_heading_title' ] ) ) {
		  $video_heading_title = $params[ 'video_heading_title' ];
		}
		if ( !empty( $params[ 'video_desc' ] ) ) {
		  $video_desc = $params[ 'video_desc' ];
		}
		if ( !empty( $params[ 'video_link' ] ) ) {
		  $video_link = $params[ 'video_link' ];
		}

		$post_type = $params[ 'post_type_select' ];
		$post_type_links .= '<select class="default-select post-type-change" required>';
		$post_type_links .= '<option value="">'.$select_placeholder_text.'</option>';
		foreach ( $post_type as $post_types ) {
			$name = exertio_cpt_array_hero_section($post_types );
		  $post_type_links .= '<option value="'.esc_attr($post_types).'">'.esc_html($name).'</option>';
			
			$action = exertio_get_cpt_page_link($post_types);
		}
		$post_type_links .= '</select>';

		if ( !empty( $params[ 'video_link' ] ) && is_array( $params[ 'video_link' ] ) &&  $params[ 'video_link' ][ 'url' ] != '' )
		{
		  $target = $params[ 'video_link' ][ 'is_external' ] ? ' target="_blank"' : '';
		  $nofollow = $params[ 'video_link' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
		  $video_link = '<div class="fr-vid-style"><a href="' . esc_url( $params[ 'video_link' ][ 'url' ] ) . '" ' . $target . $nofollow . ' class="popup-video"><i class="fa fa-play" aria-hidden="true"></i></a></div>';
		}
		  else
		  {
			  $video_link = ''; 
		  }


		/*KEYWORD POST TYPE*/
		$keyword_post_type = $params[ 'keyword_post_type' ];

		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Projects' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Services' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'services_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Employers' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'employer_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Freelancer' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'freelancer_search_page' ) );
		}
		$keyword_selection = $params[ 'keyword_selection' ];
		if ( !empty( $keyword_selection ) ) {
		  $keyword_parts = explode( "|", $keyword_selection );

		  foreach ( $keyword_parts as $keyword_part ) {
			$keywords .= "<li><a href='".$keyword_link."?title=" .urlencode($keyword_part)."'>".$keyword_part."</a></li>";
		  }
		}

		$item = $rating = $name = '';
		$freelancer_list = $params[ 'slider_list' ];
		foreach ( $freelancer_list as $freelancer_detail ) {
		  $freelancer_id = $freelancer_detail[ 'freelancer_list' ];

		  $name = exertio_get_username( 'freelancer', $freelancer_id, 'badge' );

		  $rating = get_rating( $freelancer_id, '', '' );
		  $item .= '<div class="item">
								  <div class="fr-main-container">
									<div class="fr-main-img"> <img src="' . $freelancer_detail[ 'freelancer_image' ][ 'url' ] . '" alt="" class="img-fluid"> </div>
									<div class="fr-hero-rating">
									  <div class="fr-h-star"> ' . $rating . ' </div>
									  <div class="fr-h-info">
										<p><span>' . $name . '</span> (' . esc_attr( get_post_meta( $freelancer_id, '_freelancer_tagline', true ) ) . ')</p>
									  </div>
									</div>
								  </div>
								</div>';
		}
		$search_field_toggle = $params['search_field_switch'];
		if(isset($search_field_toggle) && $search_field_toggle == 1)
		{
			$search_form = '<div class="fr-hero-search-bar">
							<form class="hero-one-form"  action="'.esc_url($action).'">
							  <ul>
								<li>
								  <div class="form-group">
									<input type="text" placeholder="' . $placehoder_text . '" class="form-control" name="title">
								  </div>
								</li>
								<li>
								  <div class="form-group">
									' . $post_type_links . '
								  </div>
								</li>
								<li> <button class="btn btn-style" type="submit">' . $search_btn_title . '</button> </li>
							  </ul>
							</form>
						  </div>';
		}
		else
		{
			$search_form = '';
		}
		return '<section class="fr-hero-ad fr-hero ">
						  <div class="container">
							<div class="row">
							 <div class="col-xl-12 col-lg-12">
							 <div class="row">
							  <div class="col-lg-10 col-xl-6 col-md-12 col-xs-12 col-sm-12 col-xs-12">
								<div class="fr-hero-content">
									<div class="fr-hero-style"> ' . $sub_heading . ' </div>
								  ' . $main_heading . '
								  ' . $desc . '
								  '.$search_form.'
								  <div class="fr-hero-trending">
									<ul>
									  <li> <span>' . $keyword_titles . '</span> </li>
									  ' . $keywords . '
									</ul>
								  </div>
								</div>
								<div class="fr-hero-vid4">
										' . $video_link . '
										<div class="fr-vid-details">
											<p>' . $video_heading_title . '</p>
											<span>' . $video_desc . '</span>
										</div>
									</div>
							  </div>
								<div class="col-lg-2 col-xl-6 col-md-12 col-sm-12 col-xs-12">
									<div class="elbow owl-carousel owl-theme">
											' . $item . '
										</div>
									</div>
								</div>


								</div>
							</div>
						  </div>	
						</section>';
	  }
	}
	if ( !function_exists( 'exertio_element_projects_with_sidebar' ) ) {
	  function exertio_element_projects_with_sidebar( $params ) {
		$projects_count = $projects_type = $project_grid_style = $col = $projects_list_cols = '';
		$project_list_style = $params[ 'project_list_style' ];
		$projects_type = $params[ 'projects_type' ];
		$projects_count = $params[ 'projects_count' ];


		$featured = '';
		if ( $projects_type == 'featured' ) {
		  $featured = array(
			'key' => '_project_is_featured',
			'value' => '1',
			'compare' => '=',
		  );
		} else if ( $projects_type == 'simple' ) {
		  $featured = array(
			'key' => '_project_is_featured',
			'value' => '0',
			'compare' => '=',
		  );
		}
		$args_projects = array(
		  'post_type' => 'projects',
		  'post_status' => 'publish',
		  'posts_per_page' => $projects_count,
		  'orderby' => 'date',
		  'order' => 'DESC',
		  'meta_query' => array(
			$featured,
		  ),
		);
		$results_projects = new WP_Query( $args_projects );


		/*FREELANCER SLIDER OPTIONS*/
		$item = $rating = $name = '';
		$freelancer_id = array();
		$freelancer_list = $params[ 'slider_list' ];

		foreach ( $freelancer_list as $freelancer_detail ) {

		  $freelancer_id[] .= $freelancer_detail[ 'freelancer_list' ];
		}

		$args = array(
			'author__not_in' => array( 1 ),
			'post__in' => $freelancer_id,
			'post_type' => 'freelancer',
			'post_status' => 'publish',
			'posts_per_page' => -1,
		);

		$results = new WP_Query( $args );

		if ( $results->have_posts() ) {
		  while ( $results->have_posts() ) {
			$results->the_post();
			$freelancer_id = get_the_ID();

			$name = exertio_get_username( 'freelancer', $freelancer_id, 'badge' );


			$skills_htmml = '';
			$saved_skills = json_decode( stripslashes( get_post_meta( $freelancer_id, '_freelancer_skills', true ) ), true );
			if ( $saved_skills != '' ) {
			  $skill_count = 1;
			  $skill_hide = '';
			  foreach ( $saved_skills as $skills ) {
				$skillsObject = get_term_by( 'id', $skills[ 'skill' ], 'freelancer-skills' );
				 if(!empty($skillsObject) && ! is_wp_error($skillsObject))
				 {
					$skillsTermName = $skillsObject->name;
					if ( $skill_count > 3 ) {
					  $skill_hide = 'hide';
					}

					$skills_htmml .= '<a href="' . esc_url( get_term_link( $skillsObject->term_id ) ) . '"  class="' . esc_attr( $skill_hide ) . '">' . esc_html( $skillsTermName ) . '</a>';
					$skill_count++;
				 }
			  }
			  if ( $skill_hide != '' ) {
				$skills_htmml .= '<a href="javascript:void(0)" class="show-skills"><i class="fas fa-ellipsis-h"></i></a>';
			  }
			}


			$rating = get_rating( $freelancer_id, '', '' );

			  $freelancer_rate = '';
			if(fl_framework_get_options('fl_hourly_rate') == 3)
			{

			}
			else
			{
				$hourly_rate = get_post_meta($freelancer_id, '_freelancer_hourly_rate', true);
				if($hourly_rate != '')
				{
				  $freelancer_rate ='
					  <p>'.fl_price_separator($hourly_rate, 'html').'</p>
					  <span class="bottom-text">'.esc_html__(' hourly','exertio_framework').'</span>
				  ';
				  
				}
			}
			$profile_image = get_profile_img( $freelancer_id, 'freelancer' );
			
			  if(isset($params['freelancer_grid_style']) && $params['freelancer_grid_style'] == 1)
			  {
				  $item .= '<div class="item">
					  <div class="fr3-product-detail-box">
						  <div class="fr3-main-product">
							<div class="fr3-product-img"> <a href="'.get_the_permalink( $freelancer_id ).'">'.$profile_image.'</a> </div>
							<div class="fr3-product-text">
							  <p><a href="'. get_the_permalink( $freelancer_id ) . '">'.exertio_get_username('freelancer', $freelancer_id, 'badge').'</a></p>
							  <h3><a href="'.get_the_permalink( $freelancer_id ).'">'.esc_attr( get_post_meta( $freelancer_id, '_freelancer_tagline', true ) ).'</a></h3>
							</div>
							<p class="inline-style">'.exertio_get_excerpt(10, $freelancer_id).'</p>
						  </div>
						  <div class="fr3-product-skills">'.$skills_htmml.'</div>
						  <div class="fr3-product-price">
							<ul>
							  <li><p>'.$rating.'</p></li>
							  <li>'.$freelancer_rate.'</li>
							</ul>
						  </div>
						  <div class="fr2-text-center">
							<p><i class="fa fa-cloack"></i>'.get_term_names('freelancer-locations', '_freelancer_location', $freelancer_id, '', ',' ).'</p>
						  </div>
						  <div class="fr3-product-btn"> <a href="' . get_the_permalink( $freelancer_id ) . '" class="btn btn-theme">'.esc_html__(' View Profile','exertio_framework').'</a> </div>
						  </div>
						</div>';
			  }
			  else if(isset($params['freelancer_grid_style']) && $params['freelancer_grid_style'] == 2)
			  {
				  $item .= '<div class="card agent-1">
								<div class="card-image">
									<a href="'.get_the_permalink( $freelancer_id ).'">
										'.get_profile_img($freelancer_id,'freelancer','full').'
									</a>
								</div>
								<div class="card-body">
									<span class="username">'.exertio_get_username('freelancer', $freelancer_id, 'badge').'</span>
									<h2 class="card-title">
										<a class="clr-black" href="'.get_the_permalink( $freelancer_id ).'">'.esc_attr( get_post_meta( $freelancer_id, '_freelancer_tagline', true ) ).'</a>
									</h2>
									<div class="hourly-rate">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><path class="clr-i-outline clr-i-outline-path-1" d="M32 8H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h28a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2zm0 6a4.25 4.25 0 0 1-3.9-4H32zm0 1.62v4.83A5.87 5.87 0 0 0 26.49 26h-17A5.87 5.87 0 0 0 4 20.44V15.6A5.87 5.87 0 0 0 9.51 10h17A5.87 5.87 0 0 0 32 15.6zM7.9 10A4.25 4.25 0 0 1 4 14v-4zM4 22.06A4.25 4.25 0 0 1 7.9 26H4zM28.1 26a4.25 4.25 0 0 1 3.9-3.94V26z" fill="#626262"></path><path class="clr-i-outline clr-i-outline-path-2" d="M18 10.85c-3.47 0-6.3 3.21-6.3 7.15s2.83 7.15 6.3 7.15s6.3-3.21 6.3-7.15s-2.83-7.15-6.3-7.15zm0 12.69c-2.59 0-4.7-2.49-4.7-5.55s2.11-5.55 4.7-5.55s4.7 2.49 4.7 5.55s-2.11 5.56-4.7 5.56z" fill="#626262"></path></svg>
										'.$freelancer_rate.'
									</div>
									<div class="dropdown-divider"></div>
									<div class="agent-short-detials">
										<div class="widget-inner-elements">
											<div class="widget-inner-text">'.$rating.'</div>
										</div>
										<div class="widget-inner-elements">
											<div class="widget-inner-icon"> <i class="fas fa-map-marker-alt"></i> </div>
											<div class="widget-inner-text">'.get_term_names('freelancer-locations', '_freelancer_location', $freelancer_id, '', ',' ).'</div>
										</div>
									</div>
								</div>
							</div>';
			  }
			  else if(isset($params['freelancer_grid_style']) && $params['freelancer_grid_style'] == 3) 
			  {
				  $item .= '<div class="item">
						  <div class="fr-jobs-box">
							<div class="fr-jobs-m-content">
							  <div class="fr-jobs-m-btn"> <span class="rating">' . $rating . ' </span> </div>
							  <div class="fr-jobs-m-icons"> <a href="'.get_the_permalink( $freelancer_id ).'"><i class="fa fa-heart active"></i></a> </div>
							  <div class="f-jobs-online"> <a href="' . get_the_permalink( $freelancer_id ).'">'.$profile_image.'</a> </div>
							</div>
							<div class="fr-jobs-m-details">
							  <p>' . $name . '</p>
							  <a href="' . get_the_permalink( $freelancer_id ) . '">
								<div class="fr-title-style">' . esc_attr( get_post_meta( $freelancer_id, '_freelancer_tagline', true ) ) . '</div>
							  </a>
							  <div class="fr3-product-skills">'.$skills_htmml.'</div>
							</div>
							<div class="fr-jobs-m-location">
							  <p>' . get_term_names('freelancer-locations', '_freelancer_location', $freelancer_id, '', ',' ) . '</p>
							</div>
						  </div>
					  </div>';
			  }
		  }
		}
		$name = exertio_get_username( 'freelancer', $freelancer_id, 'badge' );
		?>
			<section class="fr-latest-jobs project-sidebar-shortcode">
			  <div class="container">
				<div class="row">
				  <div class="col-xl-12 col-sm-12 col-lg-12">
					<?php
					echo exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] );
					?>
				  </div>
				  <div class="col-xl-8 col-lg-8 col-sm-12 col-md-12 col-xs-12">
					<div class="row">
					  <?php
					  $project_list_style = $project_list_style;
					  if ( isset( $project_list_style ) && $project_list_style != '' ) {
						$list_type = $project_list_style;
					  }
					  $layout_type = new exertio_get_projects();
					  if ( $results_projects->have_posts() ) {
						$layout_type = new exertio_get_projects();
						while ( $results_projects->have_posts() ) {
						  $results_projects->the_post();
						  $project_id = get_the_ID();
						  $function = "exertio_projects_$list_type";

						  $fetch_output = $layout_type->$function( $project_id, '' );
						  echo ' ' . $fetch_output;
						}
					  }
					  ?>
					</div>
				  </div>
				  <div class="col-xl-4 col-lg-4 col-sm-12 col-md-12 col-xs-12">
					<?php
					$ad1 = $params[ 'top_ad' ];
					if ( isset( $ad1 ) && $ad1 != '' )
					{
					  ?>
					<div class="sidebar-advertisement">
						<?php echo wp_return_echo($ad1); ?>
					</div>
					<?php

					}
					?>
					<div class="fr-jobs-main-content">
					  <div class="fr-n-style"><?php echo esc_html($params['freelancer_section_heading']);?></div>
					  <div class="top-lancer-slider owl-carousel owl-theme"> <?php echo wp_return_echo( $item); ?> </div>
					</div>
					<?php
					$ad2 = $params[ 'bottom_ad' ];
					if ( isset( $ad2 ) && $ad2 != '' )
					{
					  ?>
						<div class="sidebar-advertisement bottom">
							<?php echo wp_return_echo($ad2); ?>
						</div>
						<?php

					}
					?>
				  </div>
				</div>
			  </div>
				</section>
		<?php
	}
	}
	
	if ( !function_exists( 'exertio_element_call_to_action_two' ) )
	{
		function exertio_element_call_to_action_two( $params )
		{
			$left_btn_link = '';
			$left_btn_link = $params[ 'left_btn_link' ];
			$right_btn_link = $params[ 'right_btn_link' ];


			if ( !empty( $params[ 'left_btn_text' ] ) ) {
				$target = $left_btn_link[ 'is_external' ] ? ' target="_blank"' : '';
				$nofollow = $left_btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
				$btn_detail = '<a href="' . esc_url( $left_btn_link[ 'url' ] ) . '" class="btn btn-theme" ' . $target . ' ' . $nofollow . '>' . $params[ 'left_btn_text' ] . '</a>';
			}
			if ( !empty( $params[ 'right_btn_text' ] ) ) {
				$target = $right_btn_link[ 'is_external' ] ? ' target="_blank"' : '';
				$nofollow = $right_btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
				$right_btn_detail = '<a href="' . esc_url( $right_btn_link[ 'url' ] ) . '" class="btn btn-theme" ' . $target . ' ' . $nofollow . '>' . $params[ 'right_btn_text' ] . '</a>';
			}
			return '<section class="fr-company-contents">
				  <div class="container">
					<div class="row">
					  <div class="col-lg-6 col-xs-12 col-xl-6 col-sm-6 col-md-6">
						<div class="fr-company-products">
						  <div class="fr-style-3">'.$params[ 'left_heading_text' ].'</div>
						  <p>'.$params[ 'left_desc_text' ].'</p>
						 '.$btn_detail.'
					  </div>
					  </div>
					  <div class="col-lg-6 col-xs-12 col-xl-6 col-sm-6 col-md-6">
						<div class="fr-company-products-2">
						  <div class="fr-style-4">'.$params[ 'right_heading_text' ].'</div>
						  <p>'.$params[ 'right_desc_text' ].'</p>
						  <div class="fr-main-content">'.$right_btn_detail.'</div>
						</div>
					  </div>
					</div>
				  </div>
				</section>';
		}
	}
	
	if ( !function_exists( 'exertio_element_contact_us' ) )
	{
		function exertio_element_contact_us( $params )
		{
			$item = '';
			$option_lists = $params['sidebar_list'];
			foreach ($option_lists as $option_list)
			{

				$item .= '<li>
						  <div class="fr-co-logo"> <img src="'.$option_list['sidebar_boxes_image']['url'].'" alt="'.esc_attr(get_post_meta($option_list['sidebar_boxes_image']['id'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"> </div>
						  <div class="fr-co-user-details">
							<h3>'.$option_list['sidebar_boxes_title'].'</h3>
							'.$option_list['sidebar_boxes_detail'].'
						  </div>
						</li>';
			}
			return '<section>
					  <div class="container">
						<div class="row">
							<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-xs-12">
								<div class="section_overlap fr-contact">
									<div class="row">
										<div class="col-lg-4 col-xl-4 col-md-12 col-sm-12 col-xs-12">
											<div class="fr-co-contents">
											  <div class=" heading-contents-2">
												<h3>'.$params['sidebar_heading_text'].'</h3>
												<p>'.$params['sidebar_desc_text'].'</p>
											  </div>
											  <ul>
												'.$item.'
											  </ul>
											</div>
										</div>
										<div class="col-lg-8 col-xl-8 col-md-12 col-sm-12 col-xs-12">
											<div class="fr-contact-form">
												<div class="fr-con-collection">
													<img src="'.$params['main_image']['url'].'" alt="'.esc_attr(get_post_meta($params['main_image']['id'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">
												</div>
												<div class=" heading-contents-2">
													<h3>'.$params['main_heading_text'].'</h3>
													<p>'.$params['main_desc_text'].'</p>
												</div>
												'.do_shortcode($params['main_contact_form']).'
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					  </div>
					</section>';
			
		}
	}
	if ( !function_exists( 'exertio_element_about_us' ) )
	{
		function exertio_element_about_us( $params )
		{
			$btn_detail = $btn_link = $left_side = $right_side = $video_btn = $features = $feature_html = $img_id_alt = '';
			$btn_link = $params[ 'btn_link' ];
			$side_image = $params[ 'side_image' ];
			$side_image_positiony = $params[ 'side_image_positiony' ];

			$features = $params['features_list'];

			foreach($features as $features_list)
			{
				$feature_html .= '<li> <img src="'.get_template_directory_uri().'/images/check-box.png" alt="'.esc_attr(get_post_meta($img_id_alt, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"> <span>'.$features_list['sidebar_boxes_title'].'</span> </li>';
			}

			if ( !empty( $params['video_link'] ) && is_array( $params['video_link'] ) && $params['video_link'][ 'url' ] != '' )
			{

				$target = $params['video_link'][ 'is_external' ] ? ' target="_blank"' : '';
				$nofollow = $params['video_link'][ 'nofollow' ] ? ' rel="nofollow"' : '';
				$video_btn = '<a href="' . esc_url( $params['video_link'][ 'url' ] ) . '" ' . $target . $nofollow . ' class="bla-2 popup-video"><i class="fa fa-play" aria-hidden="true"></i></a>';
			}

		  if ( $side_image_positiony == 'left' ) {
			$right_side = $left_side = '';
			$left_side = '<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="fr-about-video">
							  <div class="fr-about-container"> <img src="' . $side_image[ 'url' ] . '" alt="' . get_post_meta( $params[ 'side_image' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"> </div>
							  '.$video_btn.' </div>
						  </div>';
		  } else if ( $side_image_positiony == 'right' ) {

			$right_side = '<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="fr-about-video">
							  <div class="fr-about-container"> <img src="' . $side_image[ 'url' ] . '" alt="' . get_post_meta( $params[ 'side_image' ][ 'id' ], '_wp_attachment_image_alt', TRUE ) . '" class="img-fluid"> </div>
							  '.$video_btn.' </div>
						  </div>';
		  }

		  if ( !empty( $params[ 'btn_text' ] ) ) {
			$target = $btn_link[ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
			$btn_detail = '<a href="' . esc_url( $btn_link[ 'url' ] ) . '" class="btn btn-theme" ' . $target . ' ' . $nofollow . '>' . $params[ 'btn_text' ] . '</a>';
		  }
			
		$facts_counter = $counter_item = $counter_html = '';
			if(isset($params['section_visibility']) && $params['section_visibility'] == 'yes')
			{
				$facts_counter = $params['counter_list'];
				foreach($facts_counter as $single_counter)
				{
					$counter_item .= '<li>
										  <div class="fr-about-icons"> <img src="'.$single_counter['counter_icon']['url'].'" alt="" class="img-fluid"> </div>
										  <div class="fr-about-i-details">
											<div class="counter-js"> <span class="counter" data-to="'.$single_counter['counter_numbers'].'" data-time="2000" data-fps="20">'.$single_counter['counter_numbers'].'</span><i class="fa fa-plus"></i> </div>
											<p>'.$single_counter['counter_title'].'</p>
										  </div>
										</li>';
				}
				$counter_html = '<div class="col-xl-12 col-lg-12 col-sm-12 col-md-12">
									<div class="fr-about-reviews">
									  <ul>
										'.$counter_item.'
									  </ul>
									</div>
								  </div>';
			}
		
		  return '<section class="fr-about-future">
					  <div class="container">
						<div class="row">
						'.$left_side.'
						  <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
							<div class="fr-about-conrent">
							<span>'.$params['sub_title_text'].'</span>
							  <h2>'.$params['heading_text'].'</h2>
							  '.$params['desc_text'].'
							  <div class="fr-product-checks">
								<ul>
								  '.$feature_html.'
								</ul>
							  </div>
							  '.$btn_detail.' </div>
						  </div>
						  '.$right_side.'
						  '.$counter_html.'
						</div>
					  </div>
					</section>';
		 }
	}
	if ( !function_exists( 'exertio_element_call_to_action_three' ) )
	{
		function exertio_element_call_to_action_three( $params )
		{
			$btn_detail = $btn_link = $left_side = $right_side = $bt_img = '';
			$btn_link = $params[ 'btn_link' ];
			$side_image = $params[ 'side_image' ]['url'];
			$side_image_height = $params[ 'side_image_height' ];
			$bt_img = 'style="background: url('.$side_image.'); background-repeat: no-repeat; background-size: cover; background-position: center center; height:'.$side_image_height.'px;"';
			$side_image_positiony = $params[ 'side_image_positiony' ];
			$empty_cols = '';
			if ( $side_image_positiony == 'left' )
			{
				$right_side = '';
				$left_side = '<div class="style-s1" '.$bt_img.'></div>';
				$empty_cols = '<div class="col-xl-5 col-sm-0 col-lg-5 col-md-0"></div>';
			}
			else if ( $side_image_positiony == 'right' )
			{
				$left_side = '';
				$right_side = '<div class="style-s2" '.$bt_img.'></div>';
				$empty_cols = '';
			}

			if ( !empty( $params[ 'btn_text' ] ) ) {
				$target = $btn_link[ 'is_external' ] ? ' target="_blank"' : '';
				$nofollow = $btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
				$btn_detail = '<a href="' . esc_url( $btn_link[ 'url' ] ) . '" class="btn btn-theme" ' . $target . ' ' . $nofollow . '>' . $params[ 'btn_text' ] . '</a>';
			}
			
			$item = '';
			$option_lists = $params['feature_list'];
			if(!empty($option_lists))
			{
				$item .= '<ul>';
				foreach ($option_lists as $option_list)
				{
					$item .= '<li> <img src="'.$option_list['feature_boxes_image']['url'].'" alt="'.esc_attr(get_post_meta($option_list['feature_boxes_image']['id'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">
								<h3>'.$option_list['feature_boxes_title'].'</h3>
								<p>'.$option_list['feature_boxes_detail'].'</p>
							  </li>';
				}
				$item .= '</ul>';
			}
		  
			return '<section class="fr-about-buisness">
					  <div class="container">
						<div class="row">
						  '.$empty_cols.'
						  <div class="col-xl-7 col-sm-12 col-md-12 col-xs-12 col-lg-7">
							<div class="fr-bissness-details">
							  <div class="fr-buisnes-content"> <span>' . $params[ 'sub_title_text' ] . '</span>
								<h3>'.$params[ 'heading_text' ].'</h3>
								'.$params[ 'desc_text' ].'
								'.$btn_detail.'
							</div>
							  <div class="fr-buisness-xt">
								  '.$item.'
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					  '.$left_side.'
					  '.$right_side.'
					</section>';
		}
	}
	
	
	if ( !function_exists( 'exertio_element_hero_slider' ) )
	{
	  function exertio_element_hero_slider( $params )
	  {
		$sec_btn = $main_btn = $desc = $main_heading = $post_type_links = $placehoder_text = $select_placeholder_text = $search_btn_title = $keyword_titles = $video_heading_title = $video_desc = $video_link = $keyword_selection = $keywords = $sub_heading = $keyword_link = $search_field_toggle = '';

		if ( !empty( $params[ 'heading_text' ] ) ) {
		  $main_heading = '<h1>' . $params[ 'heading_text' ] . '</h1>';
		}
		if ( !empty( $params[ 'sub_heading_text' ] ) ) {
		  $sub_heading = '<span>' . $params[ 'sub_heading_text' ] . '</span>';
		}
		if ( !empty( $params[ 'item_description' ] ) ) {
		  $desc = '<p> ' . $params[ 'item_description' ] . ' </p>';
		}
		if ( !empty( $params[ 'search_field_placeholder_text' ] ) ) {
		  $placehoder_text = $params[ 'search_field_placeholder_text' ];
		}
		if ( !empty( $params[ 'select_placeholder_text' ] ) ) {
		  $select_placeholder_text = $params[ 'select_placeholder_text' ];
		}
		if ( !empty( $params[ 'search_btn_title' ] ) ) {
		  $search_btn_title = $params[ 'search_btn_title' ];
		}
		if ( !empty( $params[ 'keyword_titles' ] ) ) {
		  $keyword_titles = $params[ 'keyword_titles' ];
		}
		if ( !empty( $params[ 'video_heading_title' ] ) ) {
		  $video_heading_title = $params[ 'video_heading_title' ];
		}
		if ( !empty( $params[ 'video_desc' ] ) ) {
		  $video_desc = $params[ 'video_desc' ];
		}
		if ( !empty( $params[ 'video_link' ] ) ) {
		  $video_link = $params[ 'video_link' ];
		}
		//print_r($video_link);
		  $action = '';
		$post_type = $params[ 'post_type_select' ];
		$post_type_links .= '<select class="default-select post-type-change">';
		$post_type_links .= '<option value ="'.$select_placeholder_text.'">' . $select_placeholder_text . '</option>';
		foreach ( $post_type as $post_types )
		{
			$name = exertio_cpt_array_hero_section($post_types );
			$post_type_links .= '<option value="'.esc_attr($post_types).'">'.esc_html($name).'</option>';
			$action = exertio_get_cpt_page_link($post_types);
		}
		$post_type_links .= '</select>';

		if ( !empty( $params[ 'video_link' ] ) && is_array( $params[ 'video_link' ] ) ) {
		  $target = $params[ 'video_link' ][ 'is_external' ] ? ' target="_blank"' : '';
		  $nofollow = $params[ 'video_link' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
		  $video_link = '<a href="' . esc_url( $params[ 'video_link' ][ 'url' ] ) . '" ' . $target . $nofollow . ' class="popup-video"><i class="fa fa-play" aria-hidden="true"></i></a>';
		}


		/*KEYWORD POST TYPE*/
		$keyword_post_type = $params[ 'keyword_post_type' ];

		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Projects' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'project_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Services' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'services_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Employers' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'employer_search_page' ) );
		}
		if ( isset( $keyword_post_type ) && $keyword_post_type == 'Freelancer' ) {
		  $keyword_link = get_the_permalink( fl_framework_get_options( 'freelancer_search_page' ) );
		}

		$keyword_selection = $params[ 'keyword_selection' ];
		if ( !empty( $keyword_selection ) )
		{
		  $keyword_parts = explode( "|", $keyword_selection );

		  foreach ( $keyword_parts as $keyword_part )
		  {
			$keywords .= "<a href='" . $keyword_link . "?title=" .urlencode( $keyword_part) . "'>" . $keyword_part . "</a>";
		  }
		}
		  $item = $indicators = '';
		  $slider = $params['slider_list'];
		  $active = 'active';
		  $count = 0;
		  foreach ($slider as $slider_item)
		  {
			  $item .= '<div class="carousel-item '.$active.'">
						  <img class="d-block w-100" src="'.$slider_item['slider_image']['url'].'" alt="'.$slider_item['slider_image']['id'].'">
						</div>';
			  $active = '';
			  $indicators .= '<li data-bs-target="#carouselExampleControls" data-bs-slide-to="'.$count.'" class="'.$active.'"></li>';
			  $count++;
		  }
		  $search_field_toggle = $params['search_field_switch'];
		  if(isset($search_field_toggle) && $search_field_toggle == 1)
		  {
		  $search_form = '<div class="fr-hero3-srch">
							<form class="hero-one-form" action="'.esc_url($action).'">
							  <ul>
								<li>
								  <div class="form-group">
									<input type="text" placeholder="' . $placehoder_text . '" class="form-control" name="title">
								  </div>
								</li>
								<li>
								  <div class="form-group">
									' . $post_type_links . '
									<div class="fr-hero3-submit"> <button class="btn btn-theme"><i class="fa fa-search-plus"></i>' . $search_btn_title . '</button> </div>
								  </div>
								</li>
							  </ul>
							</form>
						  </div>';
		  }
		  else
		  {
			  $search_form = '';
		  }
		  return '<div id="exertio-carousal" class="carousel slide carousel-fade" data-bs-ride="carousel">
		  			<ol class="carousel-indicators">
						'.$indicators.'
					  </ol>
					  <div class="carousel-inner">
						'.$item.'
					  </div>

					  <div class="fr-hero3 hero-slider">
					  	<div class="container">
							<div class="row">
								<div class="col-xl-8 col-xs-12 col-sm-12 col-lg-8 col-md-12">
									<div class="fr-hero3-main">
									  <div class="fr-hero3-content">
										' . $sub_heading . '
										' . $main_heading . '
										' . $desc . '
									  </div>
									  '.$search_form.'
									  <div class="fr-her3-elemnt">
										'.$keyword_titles.'
										'.$keywords.'	
									</div>
										<div class="fr-hero3-video">
										  ' . $video_link . '
										  <div class="fr-hero3-text"> <span>' . $video_heading_title . '</span>
											<p>' . $video_desc . '</p>
										  </div>
									  </div>
										</div>
									</div>
									</div>
								</div>
							</div>
				</div>';
	  }
	}
	if ( !function_exists( 'exertio_element_pricing_two' ) )
	{
	  function exertio_element_pricing_two( $params )
	  {
		if ( class_exists( 'WooCommerce' ) )
		{
			$package_type = $params[ 'package_type' ];
			$employers_packages_list = $params[ 'employers_packages_list' ];
			$freelancers_packages_list = $params[ 'freelancers_packages_list' ];
			$col_size = $params[ 'package_col_size' ];

			$cols = '';
			if ( $col_size == 1 ) {
			  $cols = 'col-xl-4 col-sm-4 col-md-6 col-xs-12 col-lg-4';
			} else if ( $col_size == 2 ) {
			  $cols = 'col-xl-3 col-sm-6 col-md-6 col-xs-12 col-lg-4';
			}

			$packages = '';
			if($package_type == 'employers')
			{
			  foreach ( $employers_packages_list as $employers_packages_lists )
			  {
					$product_price = '';

					$product_id = $employers_packages_lists[ 'employer_package_selection' ];
					$product = wc_get_product( $product_id );

					if(!empty($product))
					{
						$product_title = $product->get_title();
						$reg_price = $product->get_regular_price();
						$sale_price = $product->get_sale_price();;
						$product_desc = $product->get_description();

						$simple_projects = get_post_meta( $product_id, '_simple_projects', true );
						if ( isset( $simple_projects ) && $simple_projects > 0 ) {
						  $simple_projects = '<i class="fa fa-check"></i>' . $simple_projects . __( ' Project Allowed', 'exertio_framework' );
						} else if ( isset( $simple_projects ) && $simple_projects == -1 ) {
						  $simple_projects = '<i class="fa fa-check"></i>' . __( 'Unlimited Project Allowed', 'exertio_framework' );
						} else {
						  $simple_projects = '<i class="fas fa-times"></i>' . $simple_projects . __( ' Project Allowed', 'exertio_framework' );
						}


						$simple_projects_expiry = get_post_meta( $product_id, '_simple_project_expiry', true );
						if ( isset( $simple_projects_expiry ) && $simple_projects_expiry > 0 ) {
						  $simple_projects_expiry = '<i class="fa fa-check"></i>' . $simple_projects_expiry . __( ' Days visibility', 'exertio_framework' );
						} else if ( isset( $simple_projects_expiry ) && $simple_projects_expiry == -1 ) {
						  $simple_projects_expiry = '<i class="fa fa-check"></i>' . __( 'Lifetime visibility', 'exertio_framework' );
						} else {
						  $simple_projects_expiry = '<i class="fas fa-times"></i>' . $simple_projects_expiry . __( ' Days visibility', 'exertio_framework' );
						}


						$featured_projects = get_post_meta( $product_id, '_featured_projects', true );
						if ( isset( $featured_projects ) && $featured_projects > 0 ) {
						  $featured_projects = '<i class="fa fa-check"></i>' . $featured_projects . __( ' Featured Projects', 'exertio_framework' );
						} else if ( isset( $featured_projects ) && $featured_projects == -1 ) {
						  $featured_projects = '<i class="fa fa-check"></i>' . __( 'Unlimited Featured Project', 'exertio_framework' );
						} else {
						  $featured_projects = '<i class="fas fa-times"></i>' . $featured_projects . __( ' Featured Projects', 'exertio_framework' );
						}


						$featured_projects_expiry = get_post_meta( $product_id, '_featured_project_expiry', true );
						if ( isset( $featured_projects_expiry ) && $featured_projects_expiry > 0 ) {
						  $featured_projects_expiry = '<i class="fa fa-check"></i>' . $featured_projects_expiry . __( ' Days Featured', 'exertio_framework' );
						} else if ( isset( $featured_projects_expiry ) && $featured_projects_expiry == -1 ) {
						  $featured_projects_expiry = '<i class="fa fa-check"></i>' . __( 'Lifetime Featured', 'exertio_framework' );
						} else {
						  $featured_projects_expiry = '<i class="fas fa-times"></i>' . $featured_projects_expiry . __( ' Days Featured', 'exertio_framework' );
						}

						$featured_profile = '';
						$profile = get_post_meta( $product_id, '_employer_is_featured', true );
						if ( $profile == 1 ) {
						  $featured_profile = '<i class="fa fa-check"></i>' . __( 'Profile featured', 'exertio_framework' );
						} else if ( $profile == 0 ) {
						  $featured_profile = '<i class="fas fa-times"></i>' . __( 'Featured Profile', 'exertio_framework' );
						}

						$package_expiry = get_post_meta( $product_id, '_employer_package_expiry', true );
						if ( isset( $package_expiry ) && $package_expiry > 0 ) {
						  $package_expiry = '<i class="fa fa-check"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
						} else if ( isset( $package_expiry ) && $package_expiry == -1 ) {
						  $package_expiry = '<i class="fa fa-check"></i>' . __( 'Never Expire', 'exertio_framework' );
						} else {
						  $package_expiry = '<i class="fas fa-times"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
						}


						if ( isset( $sale_price ) && $sale_price != '' ) {
						  $product_price = '<span class="strike">' . fl_price_separator( $reg_price ) . '</span>' . fl_price_separator( $sale_price );
						} else {
						  $product_price = fl_price_separator( $reg_price );
						}


						$color = $featured_tag = $featured_class = '';
						/*FOR FEATURED TAG*/
						$is_featured = $employers_packages_lists[ 'is_package_featured' ];
						if ( $is_featured == 'yes' ) {
						  $featured_tag = '<div class="pricing-badge"> <span class="featured">' . $employers_packages_lists[ 'is_featured_text' ] . '</span> </div>';
						  $featured_class = 'featured';
						}

						if ( $employers_packages_lists[ 'employer_background_color' ] == 'black' ) {
						  $color = 'black';
						}

						$packages .= '<div class="' . $cols . '">
										<div class="exertio-pricing-2-main ' . $color . ' ' . $featured_class . '">
											' . $featured_tag . '
										  <div class="exertio-pricing-price">
											<h4>' . $product_title . '</h4>
											<span>' . $product_price . '</span>
											<p>' . $product_desc . '</p>

										</div>
										  <div class="exertio-price-detail">
											<ul>
											  <li>' . $simple_projects . '</li>
											  <li>' . $simple_projects_expiry . '</li>
											  <li>' . $featured_projects . '</li>
											  <li>' . $featured_projects_expiry . '</li>
											  <li>' . $featured_profile . '</li>
											  <li>' . $package_expiry . '</li>
											</ul>
											<button data-product-id ="' . $product_id . '" class="emp-purchase-package btn-loading btn btn-theme">' . __( ' Purchase Now', 'exertio_framework' ) . '
											<span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
											</button>
											<input type="text" class="employer_package_nonce" hidden="" value="' . wp_create_nonce( 'employer_package_nonce_value' ) . '">
										  </div>
										</div>
									  </div>';
					}
			  }
			}
			else if ( $package_type == 'freelancers' )
			{
			  foreach ( $freelancers_packages_list as $freelancers_packages_lists )
			  {

				$products_id = $freelancers_packages_lists[ 'freelancer_package_selection' ];
				$product = wc_get_product( $products_id );

				if(!empty($product))
				{
					$product_title = $product->get_title();
					$reg_price = $product->get_regular_price();
					$sale_price = $product->get_sale_price();;
					$product_desc = $product->get_description();
					$project_credits = get_post_meta( $products_id, '_project_credits', true );

					if ( isset( $sale_price ) && $sale_price != '' ) {
					  $product_price = '<span class="strike">' . fl_price_separator( $reg_price ) . '</span>' . fl_price_separator( $sale_price );
					} else {
					  $product_price = fl_price_separator( $reg_price );
					}

					if ( isset( $project_credits ) && $project_credits > 0 ) {
					  $project_credits = '<i class="fa fa-check"></i>' . $project_credits . __( ' Project Credits', 'exertio_framework' );
					} else if ( isset( $project_credits ) && $project_credits == -1 ) {
					  $project_credits = '<i class="fa fa-check"></i>' . __( 'Unlimited Project Credits', 'exertio_framework' );
					} else {
					  $project_credits = '<i class="fas fa-times"></i>' . $project_credits . __( ' Project Credits', 'exertio_framework' );
					}

					$simple_services = get_post_meta( $products_id, '_simple_services', true );

					if ( isset( $simple_services ) && $simple_services > 0 ) {
					  $simple_services = '<i class="fa fa-check"></i>' . $simple_services . __( ' Allowed Services', 'exertio_framework' );
					} else if ( isset( $simple_services ) && $simple_services == -1 ) {
					  $simple_services = '<i class="fa fa-check"></i>' . __( ' Unlimited Services', 'exertio_framework' );
					} else {
					  $simple_services = '<i class="fas fa-times"></i>' . $simple_services . __( ' Allowed Services', 'exertio_framework' );
					}

					$simple_services_expiry = get_post_meta( $products_id, '_simple_service_expiry', true );
					if ( isset( $simple_services_expiry ) && $simple_services_expiry > 0 ) {
					  $simple_services_expiry = '<i class="fa fa-check"></i>' . $simple_services_expiry . __( ' Days visibility', 'exertio_framework' );
					} else if ( isset( $simple_services_expiry ) && $simple_services_expiry == -1 ) {
					  $simple_services_expiry = '<i class="fa fa-check"></i>' . __( 'Services Never Expire', 'exertio_framework' );
					} else {
					  $simple_services_expiry = '<i class="fas fa-times"></i>' . $simple_services_expiry . __( ' Days visibility', 'exertio_framework' );
					}

					$featured_services = get_post_meta( $products_id, '_featured_services', true );
					if ( isset( $featured_services ) && $featured_services > 0 ) {
					  $featured_services = '<i class="fa fa-check"></i>' . $featured_services . __( ' Featured Services', 'exertio_framework' );
					} else if ( isset( $featured_services ) && $featured_services == -1 ) {
					  $featured_services = '<i class="fa fa-check"></i>' . __( 'Unlimited Featured Services', 'exertio_framework' );
					} else {
					  $featured_services = '<i class="fas fa-times"></i>'  . __( ' Featured Services', 'exertio_framework' );
					}

					$featured_services_expiry = get_post_meta( $products_id, '_featured_services_expiry', true );
					if ( isset( $featured_services_expiry ) && $featured_services_expiry > 0 ) {
					  $featured_services_expiry = '<i class="fa fa-check"></i>' . $featured_services_expiry . __( ' Days visibility', 'exertio_framework' );
					} else if ( isset( $featured_services_expiry ) && $featured_services_expiry == -1 ) {
					  $featured_services_expiry = '<i class="fa fa-check"></i>' . __( 'Services Never Expire', 'exertio_framework' );
					} else {
					  $featured_services_expiry = '<i class="fas fa-times"></i>' . $featured_services_expiry . __( ' Days visibility', 'exertio_framework' );
					}

					$package_expiry = get_post_meta( $products_id, '_freelancer_package_expiry', true );
					if ( isset( $package_expiry ) && $package_expiry > 0 ) {
					  $package_expiry = '<i class="fa fa-check"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
					} else if ( isset( $package_expiry ) && $package_expiry == -1 ) {
					  $package_expiry = '<i class="fa fa-check"></i>' . __( 'Package Never Expire', 'exertio_framework' );
					} else {
					  $package_expiry = '<i class="fas fa-times"></i>' . $package_expiry . __( ' Days Package Expiry', 'exertio_framework' );
					}

                    $renew_listing = get_post_meta( $products_id, '_freelancer_listing_renew', true );
                    if ( isset( $renew_listing ) && $renew_listing > 0 ) {
                        $renew_listing = '<i class="fa fa-check"></i>' . $renew_listing . __( ' Renew Expired Project/Service', 'exertio_framework' );
                    } else if ( isset( $renew_listing ) && $renew_listing == -1 ) {
                        $renew_listing = '<i class="fa fa-check"></i>' . __( 'Never Expire', 'exertio_framework' );
                    } else {
                        $renew_listing = '<i class="fas fa-times"></i>' . $renew_listing . __( ' Days Package Expiry', 'exertio_framework' );
                    }

					$featured_profile = '';
					$profile = get_post_meta( $products_id, '_freelancer_is_featured', true );
					if ( $profile == 1 ) {
					  $featured_profile = '<i class="fa fa-check"></i>' . __( 'Profile Featured', 'exertio_framework' );
					} else if ( $profile == 0 ) {
					  $featured_profile = '<i class="fas fa-times"></i>' . __( 'Profile Featured', 'exertio_framework' );
					}

					$color = $featured_tag = $featured_class = '';
					/*FOR FEATURED TAG*/
					$is_featured = $freelancers_packages_lists[ 'is_package_featured' ];
					if ( $is_featured == 'yes' ) {
					  $featured_tag = '<div class="pricing-badge"> <span class="featured">' . $freelancers_packages_lists[ 'is_featured_text' ] . '</span> </div>';
					  $featured_class = 'featured';
					}

					if ( $freelancers_packages_lists[ 'freelancer_background_color' ] == 'black' ) {
					  $color = 'black';
					}

					$packages .= '<div class="' . $cols . '">
												<div class="exertio-pricing-2-main ' . $color . ' ' . $featured_class . '">
												' . $featured_tag . '
												  <div class="exertio-pricing-price">
													<h4>' . $product_title . '</h4>
													<span>' . $product_price . '</span>
													<p>' . $product_desc . '</p>
												</div>
												  <div class="exertio-price-detail">
													<ul>
													  <li>' . $project_credits . '</li>
													  <li>' . $simple_services . '</li>
													  <li>' . $simple_services_expiry . '</li>
													  <li>' . $featured_services . '</li>
													  <li>' . $featured_services_expiry . '</li>
													  <li>' . $featured_profile . '</li>
													  <li>' . $package_expiry . '</li>
													</ul>
													<button data-product-id ="' . $products_id . '" class="freelancer-purchase-package btn-loading btn btn-theme">' . __( ' Purchase Now', 'exertio_framework' ) . '
													<span class="bubbles"> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> </span>
													</button>
													<input type="text" class="freelancer_package_nonce" hidden="" value="' . wp_create_nonce( 'freelancer_package_nonce_value' ) . '">
												  </div>
												</div>
											  </div>';
				}
			  }
			}
			return '<section class="fr-about-plan">
							  <div class="container">
								<div class="row">
								  <div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
									' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
								</div>
								<div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
									<div class="exertio-pricing">
										<div class="row">
											' . $packages . '
										</div>
									</div>
								</div>
							  </div>
							</div>
						</section>';
		}
	  }

	}
	
	if ( !function_exists( 'exertio_element_app_section_one' ) )
	{
		function exertio_element_app_section_one( $params )
		{
			$btn_detail = $btn_link = $left_side = $right_side = $bt_img = '';
			$main_image_url = $params[ 'main_image' ]['url'];
			$main_image_id = $params[ 'main_image' ]['id'];
			

			if ( !empty($params[ 'main_image' ]) && $params[ 'main_image' ]['url'] != '' )
			{
				$main_img = '<img src="'.esc_url($main_image_url).'" class="img-fluid" alt="'.esc_attr(get_post_meta($main_image_id, '_wp_attachment_image_alt', TRUE)) .'" >';
			}
			$item = '';
			$option_lists = $params['icon_list'];
			if(!empty($option_lists))
			{

				$item .= '<ul>';
				foreach ($option_lists as $option_list)
				{
					$btn_link = $option_list['btn_link'];
					$target = $btn_link[ 'is_external' ] ? ' target="_blank"' : '';
					$nofollow = $btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
					$item .= '<li><a href="' . esc_url( $btn_link[ 'url' ] ) . '" ' . $target . ' ' . $nofollow . '><img src="'.$option_list['icon_boxes_image']['url'].'" alt="'.esc_attr(get_post_meta($option_list['icon_boxes_image']['id'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid"></a></li>';
					
				}
				$item .= '</ul>';
			}
		  
			return '<section class="exertio-app-one">
					  <div class="container">
						<div class="row">
						  <div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
						  	<div class="exertio-app-box">	
							<div class="exertio-app-upper">
								<h3>'.$params[ 'heading_text' ].'</h3>
								<p>'.$params[ 'sub_title_text' ].'</p>
							</div>
							<div class="exertio-app-icons">
							  '.$item.'
							</div>
							</div>
							</div>
							<div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
								<div class="exertio-app-main-img">
								'.$main_img.'
								</div>
							</div>
						  </div>
						</div>
					</section>';
		}
	}
	
	if ( !function_exists( 'exertio_element_howit_works' ) )
	{
		function exertio_element_howit_works( $params )
		{
			$right_content = $left_content = $target = $nofollow = '';

			

			$item = '';
			$option_lists = $params['section_hiw_list'];
			if(!empty($option_lists))
			{
				$count = '1';
				foreach ($option_lists as $option_list)
				{
					$right_content = $left_content = $side_btn = $target = $nofollow = '';
					$postion = $option_list['side_image_position'];
					if(isset($postion) && $postion == 'left')
					{
						$left_content = '<div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
							<div class="about-grid-margin">
							  <div class="about-grid-img"> <img src="'.$option_list['side_image']['url'].'" alt="'.esc_attr(get_post_meta($option_list['side_image']['id'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">
								<div class="about-grid-count">'.sprintf("%02d", $count).'</div>
							  </div>
							</div>
						  </div>';
					}

					if(isset($postion) && $postion == 'right')
					{
						$right_content = '<div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
							<div class="about-grid-margin">
							  <div class="about-grid-img"> <img src="'.$option_list['side_image']['url'].'" alt="'.esc_attr(get_post_meta($option_list['side_image']['id'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">
								<div class="about-grid-count right">'.sprintf("%02d", $count).'</div>
							  </div>
							</div>
						  </div>';
					}
					$section_btn = $option_list['section_btn'];
					$heading_btn_link = $option_list['section_btn_link'];
					if ( !empty( $section_btn ) && $section_btn == 'yes' )
					{  
						$target = $heading_btn_link[ 'is_external' ] ? ' target="_blank"' : '';
						$nofollow = $heading_btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
						$side_btn = '<a href="' . esc_url( $heading_btn_link[ 'url' ] ) . '" class="btn btn-theme" ' . $target . ' ' . $nofollow . '>' . $option_list['section_btn_text'] . '</a>';
					}
					
					$item .= '
						'.$left_content.'
						  <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
							<div class="about-grid-content">
							  <h2>'.$option_list['main-heading'].'</h2>
							  <div class="subtitle">'.$option_list['sub-heading'].'</div>
							  <p>'.$option_list['description'].'</p>
							  '.$side_btn.'
							  </div>
						  </div>
						  '.$right_content.'
						  ';
					$count++;
				}
				
			}
		  
			return '<section class="about-us-grids">
					  <div class="container">
					  	<div class="row">
							  <div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
								' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
							</div>
						</div>
						<div class="row">
						  '.$item.'
						</div>
					  </div>
					</section>';
		}
	}
	
	if ( !function_exists( 'exertio_element_services_block' ) )
	{
	  function exertio_element_services_block( $params )
	  {

		$items = $category_selected = $term_id = $image = $col = '';
		  $services_list = $params[ 'services_list' ];
		  $services_grids_cols = $params['services_cols'];
			if ( $services_grids_cols == 1 )
			{
				$col = 'col-xl-3 col-xs-12 col-lg-4 col-sm-12 col-md-6';
			}
			else if ( $services_grids_cols == 2 )
			{
				$col = 'col-xl-4 col-xs-12 col-lg-4 col-sm-12 col-md-6';
			}
			else if ( $services_grids_cols == 3 )
			{
				$col = 'col-xl-6 col-xs-12 col-lg-4 col-sm-12 col-md-6';
			}
			else if ( $services_grids_cols == 4 )
			{
				$col = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}
		if ( isset($services_list) && !empty($services_list) ) {
		  
		  foreach ( $services_list as $services_lists ) {
			$items .= '<div class="'.$col.'">
						<div class="feature-block"> <img src="'.$services_lists['service_image']['url'].'" alt="'.esc_attr(get_post_meta($services_lists['service_image']['id'], '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">
						  <h4>'.$services_lists['main_heading'].'</h4>
						  <p>'.$services_lists['description'].'</p>
						</div>
					  </div>';
		  }
		}
		return '<section class="text-center"> 
				  <div class="container">
				  	<div class="row ">
							  <div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
								' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
							</div>
						</div>
					<div class="row gx-0">
						'.$items.'
					</div>
				  </div>
				</section>';
	  }
	}
	if ( !function_exists( 'exertio_element_call_to_action_four' ) )
	{
		function exertio_element_call_to_action_four( $params )
		{
			$btn_link = $btn_detail_2 = '';
			$btn_link = $params[ 'btn_link' ];
			$btn_link_2 = $params[ 'btn_link_2' ];

			if ( !empty( $params[ 'btn_text' ] ) ) {
				$target = $btn_link[ 'is_external' ] ? ' target="_blank"' : '';
				$nofollow = $btn_link[ 'nofollow' ] ? ' rel="nofollow"' : '';
				$btn_detail = '<a href="' . esc_url( $btn_link[ 'url' ] ) . '" class="btn btn-theme-secondary" ' . $target . ' ' . $nofollow . '>' . $params[ 'btn_text' ] . '</a>';
			}
			if ( !empty( $params[ 'btn_text_2' ] ) ) {
				$target_2 = $btn_link_2[ 'is_external' ] ? ' target="_blank"' : '';
				$nofollow_2 = $btn_link_2[ 'nofollow' ] ? ' rel="nofollow"' : '';
				$btn_detail_2 = '<a href="' . esc_url( $btn_link_2[ 'url' ] ) . '" class="btn btn-theme" ' . $target_2 . ' ' . $nofollow_2 . '>' . $params[ 'btn_text_2' ] . '</a>';
			}
			
		  
			return '<div class="section-padding-extra text-center call-actionz">
					  <div class="container">
						<div class="row">
						  <div class="col-xs-12 col-sm-12 col-md-12">
							<div class="parallex-text">
							  <h5>'.$params[ 'sub_title_text' ].' </h5>
							  <h4>'.$params[ 'heading_text' ].'</h4>
							  '.$params[ 'desc_text' ].'
							  '.$btn_detail.'
							  '.$btn_detail_2.'
							  </div>
						  </div>
						</div>
					  </div>
					</div>';
		}
	}
	if ( !function_exists( 'exertio_element_howit_works_two' ) )
	{
		function exertio_element_howit_works_two( $params )
		{
			$item = $col = '';
			$option_lists = $params['section_hiw_list'];
			$grids_cols = $params['grid_cols'];
			if ( $grids_cols == 1 )
			{
				$col = 'col-xl-3 col-xs-12 col-lg-4 col-sm-4 col-md-6';
			}
			else if ( $grids_cols == 2 )
			{
				$col = 'col-xl-4 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			}
			else if ( $grids_cols == 3 )
			{
				$col = 'col-xl-6 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			}
			else if ( $grids_cols == 4 )
			{
				$col = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}
			if(!empty($option_lists))
			{
				$count = '1';
				foreach ($option_lists as $option_list)
				{
					$item .= '<div class="'.esc_attr($col).'">
							<div class="our-process-cycle"> <img src="'.$option_list['icon_image']['url'].'" alt="'.esc_attr(get_post_meta($option_list['icon_image']['id'], '_wp_attachment_image_alt', TRUE)).'">
							  <h3>'.$option_list['main_heading'].'</h3>
							  <p>'.$option_list['description'].'</p>
							  <span>'.sprintf("%02d", $count).'</span> </div>
						  </div>';
					$count++;
				}
				
			}
			
			return '<section class="our-services">
					  <div class="container">
					  <div class="row">
							  <div class="col-lg-12 col-sm-12 col-xl-12 col-xs-12">
								' . exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] ) . '
							</div>
						</div>
						<div class="row">
							'.$item.'
						</div>
					  </div>
					</section>';
		}
	}
	
	if ( !function_exists( 'exertio_element_freelancers' ) )
	{
		function exertio_element_freelancers( $params )
		{
			$freelancer_count = $freelancer_type = $freelancer_grid_style = $col = '';
			$freelancer_grid_style = $params[ 'freelancer_grid_style' ];
			$freelancer_type = $params[ 'freelancer_type' ];
			$freelancer_count = $params[ 'freelancer_count' ];
			$freelancer_grids_cols = $params[ 'freelancer_grids_cols' ];


			$grid_style = 'grid_1';
			if ( $freelancer_grid_style == 1 ) {
			$grid_style = 'grid_1';
			} else if ( $freelancer_grid_style == 2 ) {
			$grid_style = 'grid_2';
			}
			if ( $freelancer_grids_cols == 1 ) {
			$col = 'col-xl-3 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			} else if ( $freelancer_grids_cols == 2 ) {
			$col = 'col-xl-4 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			} else if ( $freelancer_grids_cols == 3 ) {
			$col = 'col-xl-6 col-xs-12 col-lg-4 col-sm-6 col-md-6';
			} else if ( $freelancer_grids_cols == 4 ) {
			$col = 'col-xl-12 col-xs-12 col-lg-12 col-sm-12 col-md-12';
			}

			$featured = '';
			if ( $freelancer_type == 'featured' ) {
			$featured = array(
			  'key' => '_freelancer_is_featured',
			  'value' => '1',
			  'compare' => '=',
			);
			} else if ( $freelancer_type == 'simple' ) {
			$featured = array(
			  'key' => '_freelancer_is_featured',
			  'value' => '0',
			  'compare' => '=',
			);
			}
			$args = array(
			'author__not_in' => array( 1 ),
			'post_type' => 'freelancer',
			'post_status' => 'publish',
			'posts_per_page' => $freelancer_count,
			'orderby' => 'date',
			'order' => 'ASC',
			'meta_query' => array(
			  $featured,
			),
			);
			$results = new WP_Query( $args );

			?>
			<section class="fr-lance-details">
			  <div class="container">
				<div class="row">
				  <div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
					<?php
					echo exertio_shortcode_section_headings( $params[ 'heading_text' ], $params[ 'heading_description' ], $params[ 'heading_style' ], $params[ 'heading_side_btn' ], $params[ 'heading_side_btn_text' ], $params[ 'heading_side_btn_link' ] );
					?>
					</div>
					<div class="col-xl-12 col-sm-12 col-md-12 col-xs-12 col-lg-12">
						<div class="row grid">
					  <?php
						if ( $results->have_posts() )
						{
							$layout_type = new exertio_get_freelancers_class();
							while ($results->have_posts())
							{
								$results->the_post();
								$freelancer_id = get_the_ID();
								$function = "exertio_freelancer_$grid_style";
								$fetch_output = $layout_type->$function($freelancer_id,$col);
								//echo ' '.$fetch_output;
							}
						}
						wp_reset_postdata()
					  ?>
							</div>
					</div>
				  </div>
				</div>
			</section>
			<?php
		}
	}
	
	
	
	if ( !function_exists( 'exertio_cpt_array_hero_section' ) )
	{
		function exertio_cpt_array_hero_section( $key = '') 
		{
			$array = array(
					'Projects'  => __( 'Projects', 'exertio_framework' ),
					'Services'  => __( 'Services', 'exertio_framework' ),
					'Employers'  => __( 'Employers', 'exertio_framework' ),
					'Freelancer'  => __( 'Freelancer', 'exertio_framework' ),
			);
			if($key != '')
			{
				return $array[$key];
			}
			else
			{
				return $array;
			}
		}
	}
	if ( !function_exists( 'exertio_get_cpt_page_link' ) )
	{
		function exertio_get_cpt_page_link($post_types = '') 
		{
			$action ='';
			if($post_types == 'Projects')
			{
				$action = get_the_permalink(fl_framework_get_options('project_search_page'));
			}
			else if($post_types == 'Services')
			{
				$action = get_the_permalink(fl_framework_get_options('services_search_page'));
			}
			else if($post_types == 'Freelancer')
			{
				$action = get_the_permalink(fl_framework_get_options('freelancer_search_page'));
			}
			else if($post_types == 'Employers')
			{
				$action = get_the_permalink(fl_framework_get_options('employer_search_page'));
			}
			return $action;
		}
	}
	
	
}

if ( !function_exists( 'exertio_element_hero_four' ) )
{
	function exertio_element_hero_four( $params )
	{
		$sec_btn = $p_btn_text = $desc = $main_heading = $sub_heading = $s_btn_link = $p_btn_link = $logo_html = $client_heading_text = $client_desc_text = '';

		if ( !empty( $params[ 'heading_text' ] ) ) {
		  $main_heading = '<h1>' . $params[ 'heading_text' ] . '</h1>';
		}
		if ( !empty( $params[ 'sub_heading_text' ] ) ) {
		  $sub_heading = '<span>' . $params[ 'sub_heading_text' ] . '</span>';
		}
		if ( !empty( $params[ 'item_description' ] ) ) {
		  $desc = '<p> ' . $params[ 'item_description' ] . ' </p>';
		}

		if ( !empty( $params[ 'search_btn_title' ] ) ) {
		  $search_btn_title = $params[ 'search_btn_title' ];
		}
		if ( !empty( $params[ 'p_btn_text' ] ) ) {
		  $p_btn_text = $params[ 'p_btn_text' ];
		}
		if ( !empty( $params[ 's_btn_text' ] ) ) {
		  $s_btn_text = $params[ 's_btn_text' ];
		}
		if ( !empty( $params[ 'p_btn_link' ][ 'url' ] ) && is_array( $params[ 'p_btn_link' ] ) )
		{
			$target = $params[ 'p_btn_link' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow = $params[ 'p_btn_link' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$p_btn_link = '<a href="' . esc_url( $params[ 'p_btn_link' ][ 'url' ] ) . '" ' . $target . $nofollow . ' class="btn btn-theme">'.$p_btn_text.'</a>';
		}
		if ( !empty( $params[ 's_btn_link' ][ 'url' ] ) && is_array( $params[ 's_btn_link' ] ) )
		{
			$target_2 = $params[ 's_btn_link' ][ 'is_external' ] ? ' target="_blank"' : '';
			$nofollow_2 = $params[ 's_btn_link' ][ 'nofollow' ] ? ' rel="nofollow"' : '';
			$s_btn_link = '<a href="' . esc_url( $params[ 's_btn_link' ][ 'url' ] ) . '" ' . $target_2 . $nofollow_2 . ' class="btn btn-theme-secondary">'.$s_btn_text.'</a>';
		}
		
		if ( !empty( $params[ 'side_image' ] ) )
		{
			//$side_image = $params[ 'side_image' ]['url'];
			$side_image = '<img src="'.$params[ 'side_image' ]['url'].'" alt="'.get_post_meta($params[ 'side_image' ]['id'], "_wp_attachment_image_alt", TRUE).'" class="img-fluid" />';
		}
		if ( !empty( $params[ 'client_heading_text' ] ) ) {
		  $client_heading_text = '<h3>'.$params[ 'client_heading_text' ].'</h3>';
		}
		if ( !empty( $params[ 'client_desc_text' ] ) ) {
		  $client_desc_text = '<p>'.$params[ 'client_desc_text' ].'</p>';
		}
		if ( !empty( $params[ 'client_gallery' ] ) )
		{
			$logo_html .= '<div class="clients">';
			foreach($params[ 'client_gallery' ] as $logos => $logo)
			{
				$logo_html .= '<span><img src="'.$logo['url'].'" alt="'.get_post_meta($logo['id'], "_wp_attachment_image_alt", TRUE).'" class="img-fluid" /></span>';
			}
			$logo_html .= '</div>';
		}
		


		return '<section class="fr-hero4 herosection-4">
				  <div class="container">
					<div class="row">
						<div class="col-xl-6 col-12 col-sm-12 col-lg-6 col-md-12">
							<div class="fr-hero4-main">
							  <div class="fr-hero4-content">
								' . $sub_heading . '
								' . $main_heading . '
								' . $desc . '
								<div class="buttons">
								'.$p_btn_link.'
								'.$s_btn_link.'
								</div>
							  </div>
							  <div class="second-content">
							  	'.$client_heading_text.'
								'.$client_desc_text.'
								'.$logo_html.'
							  </div>
							</div>
						</div>
						<div class="col-xl-6 col-12 col-sm-12 col-lg-6 col-md-12">
						'.$side_image.'
						</div>
					</div>
				  </div>
				</section>';
	}
}
