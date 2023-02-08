<?php
if (!function_exists('exertio_redirect'))
{
	function exertio_redirect($url = '')
	{
		return '<script>window.location = "' . $url . '";</script>';
	}
}
if ( ! function_exists( 'wp_return_echo' ) ) 
{
	function wp_return_echo($echo)
	{
		return $echo;
	}
}
if( !function_exists('fl_framework_get_options') )
{
	function fl_framework_get_options($get_text)
	{
		global $exertio_theme_options;
		if(isset($exertio_theme_options[$get_text]) &&  $exertio_theme_options[$get_text] !=""):
			return $exertio_theme_options[$get_text];
		else:
			return false;
		endif;
	}
}
if ( ! function_exists( 'get_profile_img' ) ) 
{
	function get_profile_img($id, $user_type, $img_size = '')
	{
		global $exertio_theme_options;
		$alt_id = $profile_img_url = '';
		
		
		if($user_type == 'freelancer')
		{
			if(isset($exertio_theme_options) && $exertio_theme_options != '')
			{
				$profile_img_url = $exertio_theme_options['freelancer_df_img']['url'];
			}
			else
			{
				$profile_img_url = get_template_directory_uri().'/images/emp_default.jpg';
			}
			$pro_img_id = get_post_meta( $id, '_profile_pic_freelancer_id', true );
			if($img_size == '')
			{
				$img_size = 'thumbnail';
			}

			$pro_img = wp_get_attachment_image_src( $pro_img_id, $img_size );
			if(wp_attachment_is_image($pro_img_id))
			{
				
				return '<img src="'.esc_url($pro_img[0]).'" alt="'.esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">';
			}
			else
			{
				return '<img src="'.esc_url($profile_img_url).'" alt="'.esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">';
			}
		}
		if($user_type == 'employer')
		{
			if(isset($exertio_theme_options) && $exertio_theme_options != '')
			{
				$profile_img_url = $exertio_theme_options['employer_df_img']['url'];
			}
			else
			{
				$profile_img_url = get_template_directory_uri().'/images/emp_default.jpg';
			}
			$pro_img_id = get_post_meta( $id, '_profile_pic_attachment_id', true );
			$pro_img = wp_get_attachment_image_src( $pro_img_id, 'thumbnail' );
			
			//if(!empty($pro_img_id))
			if(wp_attachment_is_image($pro_img_id))
			{
				return '<img src="'.esc_url($pro_img[0]).'" alt="'.esc_attr(get_post_meta($pro_img_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">';
			}
			else
			{
				return '<img src="'.esc_url($profile_img_url).'" alt="'.esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)).'" class="img-fluid">';
			}
			
		}
	}
}

/*PRICE SEPARATOR*/
if ( ! function_exists( 'fl_price_separator' ) )
{
	function fl_price_separator($pro_price,  $html = '')
	{
		if(!empty($pro_price) || $pro_price == 0)
		{
			global $exertio_theme_options;
			if(isset($exertio_theme_options) && $exertio_theme_options != '')
			{
				$currency = $exertio_theme_options['fl_currency'];
				$currency_position = $exertio_theme_options['fl_currency_position'];
			}
			else
			{
				$currency = '$';
				$currency_position = 'before';
			}
			
			$price = '';
			$thousands_sep = ",";
			$decimals_separator = ".";
			$decimals = 0;
			
			if(isset($exertio_theme_options) && $exertio_theme_options != '')
			{
				if($exertio_theme_options['fl_thousand_separator'] !="")
				{
					$thousands_sep =  $exertio_theme_options['fl_thousand_separator'];
				}

				if($exertio_theme_options['fl_decimals_separator'] !="")
				{
					$decimals_separator =  $exertio_theme_options['fl_decimals_separator'];
				}

				if($exertio_theme_options['fl_currency_decimals'] !="")
				{
					$decimals =  $exertio_theme_options['fl_currency_decimals'];
				}
			}
			if (is_numeric($pro_price))
			{
				 $price = number_format($pro_price, $decimals, $decimals_separator, $thousands_sep);
				 if(isset($price) && $price !="")
				 {
					if($html != '')
					{ 
						if($currency_position !="" && $currency_position =="before")
						{
							$price = '<span class="currency">'.$currency.'</span><span class="price">'.$price.'</span>';
						}
						else
						{
							$price = '<span class="price">'.$price.'</span><span class="currency">'.$currency.'</span>';
						}
					}
					else
					{
						if($currency_position !="" && $currency_position =="before")
						{
							$price = $currency.''.$price;
						}
						else
						{
							$price = $price.''.$currency;
						}
					}
				}
			}
			return $price;
		}
	}
}

if (!function_exists('exertio_breadcrumb'))
{
	function exertio_breadcrumb()
	{
		$string = '';

		if (is_category()) {
			$string .= esc_html(get_cat_name(exertio_getCatID()));
		}
		else if (is_singular('post')) {
			$string .= esc_html__('Blog Detail', 'exertio_theme');
		} else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) &&  is_shop()) {
			$string .= esc_html__('Shop', 'exertio_theme');
		} elseif (is_page()) {
			$string .= esc_html(get_the_title());
		} elseif (is_tag()) {
			$string .= esc_html(single_tag_title("", false));
		} elseif (is_search()) {
			$string .= esc_html(get_search_query());
		} elseif (is_404()) {
			$string .= esc_html__('Page not Found', 'exertio_theme');
		} elseif (is_author()) {
			$string .= esc_html__('Author', 'exertio_theme');
		} else if (is_tax()) {
			$string .= esc_html(single_cat_title("", false));
		} elseif (is_archive()) {
			$string .= esc_html__('Archive', 'exertio_theme');
		} else if (is_home()) {
			$string = esc_html__('Articles', 'exertio_theme');
		} else if (is_singular('projects')) {
			$string = esc_html__('Project Detail', 'exertio_theme');
		}
		else if (is_singular('product')) {
			$string .= esc_html__('Shop Detail', 'exertio_theme');
		}

		return $string;
	}
}

// Get BreadCrumb Heading
if (!function_exists('exertio_breadcrumb_heading'))
{
	function exertio_breadcrumb_heading()
	{
		$page_heading = '';
		if (is_page())
		{
			$page_heading = get_the_title();
		}
		else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_shop() || in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_singular())
		{
			if(is_shop())
			{
				$page_heading = esc_html__('All Products', 'exertio_theme');	
			}
			else if(is_product_category())
			{
				$page_heading = esc_html__('Shop ', 'exertio_theme');
			}
			if (is_singular())
			{
				$page_heading = esc_html(get_the_title());
			}
			
		}
		else if (is_singular('post'))
		{
			$page_heading = esc_html(get_the_title());
		}
		else if (is_singular('projects'))
		{
			$page_heading = esc_html__('Project Detail', 'exertio_theme');
		}
		else if (is_home())
		{
			if (fl_framework_get_options('blog_page_text') != '' && fl_framework_get_options('blog_page_text') != "") {
				$page_heading = fl_framework_get_options('blog_page_text');
			} else {
				$page_heading = esc_html__('Latest Stories', 'exertio_theme');
			}
		}
		else if (is_404())
		{
			$page_heading = esc_html__('Page not found', 'exertio_theme');
		}
		else if (is_archive())
		{
			$page_heading = esc_html__('Blog Archive', 'exertio_theme');
		}
		else if (is_search())
		{
			$string = esc_html__('Entire web', 'exertio_theme');
			if (get_search_query() != "")
			{
				$string = get_search_query();
			}
			$page_heading = sprintf(esc_html__('Search Results for: %s', 'exertio_theme'), esc_html($string));
		}
		else if (is_category())
		{
			$page_heading = esc_html(single_cat_title("", false));
		}
		else if (is_tag())
		{
			$page_heading = esc_html__('Tag: ', 'exertio_theme') . esc_html(single_tag_title("", false));
		}
		else if (is_author()){
			$author_id = get_query_var('author');
			$author = get_user_by('ID', $author_id);
			$page_heading = $author->display_name;
		} else if (is_tax()) {
			$page_heading = esc_html(single_cat_title("", false));
		}
		

		return $page_heading;
	}
}
/*BLOG FEATURED IMAGE*/
if (!function_exists('exertio_get_feature_image'))
{
	function exertio_get_feature_image($post_id, $image_size) {
		return get_the_post_thumbnail(esc_html($post_id), $image_size, array( 'class' => 'img-fluid' ));
	}
}
if (!function_exists('fl_blog_pagination')) 
{
	function fl_blog_pagination()
	{

		if (is_singular())
			return;
		global $wp_query;
		/** Stop execution if there's only 1 page */
		if ($wp_query->max_num_pages <= 1)
			return;
		$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
		$max = intval($wp_query->max_num_pages);

		/** 	Add current page to the array */
		if ($paged >= 1)
			$links[] = $paged;

		/** 	Add the pages around the current page to the array */
		if ($paged >= 3) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if (( $paged + 2 ) <= $max) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}
		echo '<div class="fr-latest-pagination">';
		echo '<ul class="pagination">' . "\n";

		if (get_previous_posts_link())
			printf('<li class="page-item">%s</li>' . "\n", get_previous_posts_link() );

		/** 	Link to first page, plus ellipses if necessary */
		if (!in_array(1, $links)) {
			$class = 1 == $paged ? ' class="page-link"' : '';

			printf('<li%s  class="page-item"><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

			if (!in_array(2, $links))
				echo '<li class="page-item"><a href="javascript:void(0);" class="page-link">...</a></li>';
		}

		/** 	Link to current page, plus 2 pages in either direction if necessary */
		sort($links);
		foreach ((array) $links as $link) {
			$class = $paged == $link ? ' class="page-item active"' : '';
			printf('<li%s class="page-item"><a href="%s"  class="page-link">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
		}

		/** 	Link to last page, plus ellipses if necessary */
		if (!in_array($max, $links)) {
			if (!in_array($max - 1, $links))
				echo '<li class="page-item"><a href="javascript:void(0);">...</a></li>' . "\n";
			$class = $paged == $max ? ' class="page-item"' : '';
			printf('<li%s class="page-item"><a href="%s" class="page-link">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
		}

		if (get_next_posts_link())
			printf('<li class="page-item">%s</li>' . "\n", get_next_posts_link());
		echo '</ul>' . "\n";
		echo '</div>';
	}

}


//Comments Callback
if ( !function_exists( 'exertio_custom_comments' ) )
{
    function exertio_custom_comments( $comment, $args, $depth )
	{
		$alt = $default = $comment_id = '';
        $GLOBALS['comment' ] = $comment;
        switch ( $comment->comment_type ) :
            case 'trackback' :
        ?>
                <div class="post pingback">
                    <p><?php esc_html__( 'Pingback:', 'exertio_theme' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'exertio_theme' ), ' ' ); ?></p>
                </div>
                    <?php
                    break;
                	default :
                    ?>
                    <?php
                    if ( $depth > 1 ) {
                        echo '<div class="ml-5">';
                    }
                    ?>
    				<div class="exertio-comms" <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                        <div class="comment-user">
                            <div class="comm-avatar">
                             <?php 
                             if($comment->user_id)
                             { 
                                 echo get_avatar( $comment, null, $default, $alt, array( 'class' => array( 'd-flex','mx-auto' ) ) );
                             }
                             else
                             {
                                 echo get_avatar( $comment, 100 );
                             }
                             ?>
                            </div>
                            <span class="user-details"><span class="username"><?php echo get_comment_author_link(); ?></span></span>
                            <span><?php echo esc_html__( 'on ', 'exertio_theme' ); ?> </span>
                            <span><?php printf( esc_html( '%1$s', 'exertio_theme' ), get_comment_date(), get_comment_time() );?></span>
                            <span>
                            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ], 'add_below' => 'li-comment', 'reply_text' => '<i class="fa fa-reply pull-right"></i>' ) ), $comment_id ); ?>
                            </span>
                        </div>
                        <div class="comment-text">
                            <?php echo comment_text(); ?>
                        </div>
    				</div>
                <?php
                if ( $depth > 1 ) {
                    echo '</div>';
                }
                ?>
                <?php
                break;
        endswitch;
    }
}


//Exertio Views Multipost types 
add_action('wp', 'exertio_count_views_multi_type', 10);
if ( ! function_exists('exertio_count_views_multi_type'))
{
	function exertio_count_views_multi_type($type)
	{
		if (get_post_type(get_the_ID()) == 'projects' && is_singular('projects') || get_post_type(get_the_ID()) == 'services' && is_singular('services') || get_post_type(get_the_ID()) == 'employer' && is_singular('employer') || get_post_type(get_the_ID()) == 'freelancer' && is_singular('freelancer'))
		{
			$type =  get_post_type(get_the_ID());
			$post_id = get_the_ID();
			if(get_post_type(get_the_ID()) == 'projects' && is_singular('projects'))
			{
				$key = 'project';
			}
			if(get_post_type(get_the_ID()) == 'services' && is_singular('services'))
			{
				$key = 'service';
			}
			if(get_post_type(get_the_ID()) == 'employer' && is_singular('employer'))
			{
				$key = 'employer';
			}
			if(get_post_type(get_the_ID()) == 'freelancer' && is_singular('freelancer'))
			{
				$key = 'freelancer';
			}
			//daily count total
			if(intval(get_post_meta($post_id, 'exertio_'.$key.'_singletotal_views', true)!=""))
			{
				$view_count = get_post_meta($post_id, 'exertio_'.$key.'_singletotal_views', true);
				$view_count =  $view_count + 1;
				update_post_meta( $post_id, 'exertio_'.$key.'_singletotal_views', $view_count );
			}
			else
			{
				$view_count = 1;
				update_post_meta( $post_id, 'exertio_'.$key.'_singletotal_views', $view_count );
			}
			//stats
			$current_day =  date('Y-m-d',current_time('timestamp', 0));
			$count_by_date = get_post_meta($post_id, 'exertio_'.$key.'_count_by_date', true);
			if($count_by_date =='' || !is_array($count_by_date))
			{
				$count_by_date         =   array();
				$count_by_date[$current_day] =   1;
			}
			else
			{
				if( !isset($count_by_date[$current_day] ) )
				{
					if( count($count_by_date) > 20 )
					{
						array_shift($count_by_date);
					}
					$count_by_date[$current_day]=1;
				}
				else
				{
					$count_by_date[$current_day]=intval($count_by_date[$current_day])+1;
				}
			}
			update_post_meta($post_id, 'exertio_'.$key.'_count_by_date', $count_by_date);
		}
	}
}
//Fetch data for charts
if( !function_exists('exertio_chart_labels') )
{
    function exertio_chart_labels($single_id, $is_values = false,$cpt_type = '')
	{
		global $exertio_theme_options;
		$get_array_keys = array();
		$result = array();
		if(empty($cpt_type))
		{
			$views_by_date = get_post_meta($single_id, 'exertio_listing_count_by_date', true);
		}
		else
		{
			$views_by_date = get_post_meta($single_id, 'exertio_'.$cpt_type.'_count_by_date', true);
		}
		if(!empty($views_by_date) && is_array($views_by_date) && count($views_by_date) > 0)
		{
			$days_to_show = 20;
			if(isset($exertio_theme_options['exertio_stats_days']) && $exertio_theme_options['exertio_stats_days'] !="")
			{
				$days_to_show = $exertio_theme_options['exertio_stats_days'];
			}
			if($is_values == true)
			{
				//get array values
				$get_array_keys = array_values($views_by_date);
			}
			else
			{
				//get array keys
				$get_array_keys = array_keys($views_by_date);
			}
			//get number of results to show from last
			$result = array_slice($get_array_keys, -1 * $days_to_show, $days_to_show, false);
			return json_encode($result);
		}
		else
		{
			return json_encode($result);
		}
	}
}

if ( ! function_exists('exertio_dashboard_extention_return'))
{
	function exertio_dashboard_extention_return()
	{
		if(isset($_GET['ext']) && $_GET['ext'] != '')
		{
			$text = str_replace('-', ' ', $_GET['ext']);
			$ext = '<p class="ext mb-0 hover-cursor">/&nbsp;'.$text.'</p>';
			return $ext;
		}
		
	}
}
if ( ! function_exists('exertio_is_elementor'))
{
		function exertio_is_elementor()
		{
			global $post;
			if (in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins'))))
			{
			  return \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
			}
		}
}

if ( ! function_exists('exertio_is_realy_woocommerce_page'))
{
	function exertio_is_realy_woocommerce_page ()
	{
		if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
		{
			if( function_exists ( "is_woocommerce" ) && is_woocommerce())
			{
				return true;
			}
			$woocommerce_keys = array ( "woocommerce_shop_page_id" ,
				"woocommerce_terms_page_id" ,
				"woocommerce_cart_page_id" ,
				"woocommerce_checkout_page_id" ,
				"woocommerce_pay_page_id" ,
				"woocommerce_thanks_page_id" ,
				"woocommerce_myaccount_page_id" ,
				"woocommerce_edit_address_page_id" ,
				"woocommerce_view_order_page_id" ,
				"woocommerce_change_password_page_id" ,
				"woocommerce_logout_page_id" ,
				"woocommerce_lost_password_page_id" ) ;

			foreach ( $woocommerce_keys as $wc_page_id )
			{
				if ( get_the_ID () == get_option ( $wc_page_id , 0 ) )
				{
					return true ;
				}
			}
			return false;
		}
	}
}
if ( ! function_exists('exertio_allowed_html_tags'))
{
	function exertio_allowed_html_tags ()
	{
		 return array(
						'a' => array(
							'href' => array(),
							'title' => array()
						),
						'strong' => array(),
			 			'b' => array(),
						'br' => array(),
						'strong' => array(),
						'ul' => array(
									 'type' => true,
									),
						 'ol' => array(
									'start'    => true,
									'type'     => true,
									'reversed' => true,
									),
						'li'  => array(
									'align' => true,
									'value' => true,
									),
			 			'p' => array(
									'align'    => true,
									'dir'      => true,
									'lang'     => true,
									'xml:lang' => true,
									),
			 			'h1' => array(
									'align' => true,
									),
						'h2' => array(
									'align' => true,
									),
						'h3' => array(
									'align' => true,
									),
						'h4' => array(
									'align' => true,
									),
						'h5' => array(
									'align' => true,
									),
						'h6'=> array(
									'align' => true,
									),
						'font' => array(
									'color' => true,
									'face'  => false,
									'size'  => true,
									),
			 			'span'       => array(
									'dir'      => true,
									'align'    => true,
									'lang'     => true,
									'xml:lang' => true,
									),
						'em'         => array(),
						'i'          => array(),
						'blockquote' => array(
											'cite' => true,
											),
					);
	}
}
//Rewrite URL Freelancer
add_filter('register_post_type_args', 'exertio_register_post_type_args', 10, 2);
if (!function_exists('exertio_register_post_type_args')) {
    function exertio_register_post_type_args($args='', $post_type='') {
        $exertio_theme_options = get_option('exertio_theme_options');
        if($exertio_theme_options['fl_url_rewriting_enable'] !="" && $exertio_theme_options['fl_url_rewriting_enable'] == 1 && $exertio_theme_options['fl_ad_slug'] !=''){
            if ($post_type === 'freelancer') {
                $old_slug = 'freelancer';
                if (get_option('fl_ad_old_slug') != "") {
                    $old_slug = get_option('fl_ad_old_slug');
                }
                $args['rewrite']['slug'] = $exertio_theme_options['fl_ad_slug'];
                update_option('fl_ad_old_slug', $exertio_theme_options['fl_ad_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                            add_rewrite_rule(str_ireplace($old_slug, $exertio_theme_options['fl_ad_slug'], $key), $val, 'top');
                        }
                    }
                    flush_rewrite_rules();
                }
            }
        }

        return $args;
    }

}
//Rewrite URL Employer
add_filter('register_post_type_args', 'exertio_register_post_type_arg', 9, 2);
if (!function_exists('exertio_register_post_type_arg')) {
    function exertio_register_post_type_arg($args='', $post_type='') {
        $exertio_theme_options = get_option('exertio_theme_options');
        if($exertio_theme_options['em_url_rewriting_enable'] !="" && $exertio_theme_options['em_url_rewriting_enable'] == 1 && $exertio_theme_options['em_ad_slug'] !=''){
            if ($post_type === 'employer') {
                $old_slug = 'employer';
                if (get_option('em_ad_old_slug') != "") {
                    $old_slug = get_option('em_ad_old_slug');
                }
                $args['rewrite']['slug'] = $exertio_theme_options['em_ad_slug'];
                update_option('em_ad_old_slug', $exertio_theme_options['em_ad_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                            add_rewrite_rule(str_ireplace($old_slug, $exertio_theme_options['em_ad_slug'], $key), $val, 'top');
                        }
                    }
                    flush_rewrite_rules();
                }
            }
        }

        return $args;
    }

}

//for verification mail

if (!function_exists('exertio_account_activation_email'))
{
    function exertio_account_activation_email($user_id)
    {
        if(!empty($user_id))
        {
            $user_infos = get_userdata($user_id);
            $to = $user_infos->user_email;
            $subject = fl_framework_get_options('fl_allow_user_email_verification_sub');
            $from = get_option('admin_email');
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $keywords = array('%site_name%', '%display_name%', '%verification_link_allow%');
            $token =get_user_meta($user_id, 'sb_email_verification_token', true);
            if ($token == "") {
                $token = exertio_randomString(50);
            }
            $signinlink = get_the_permalink(fl_framework_get_options('header_btn_page'));
            $verification_link_allow = esc_url($signinlink) . '?verification_key=' . $token . '-exertio-uid-' . $user_id;
            update_user_meta($user_id, 'sb_email_verification_token', $token);
            $replaces = array(wp_specialchars_decode(get_bloginfo('name'),ENT_QUOTES), $user_infos->display_name,$verification_link_allow);
            $body = str_replace($keywords, $replaces, fl_framework_get_options('fl_allow_user_email_verification_message'));
            wp_mail($to, $subject, $body, $headers);
        }
    }
}
$exertio_theme_options = get_option('exertio_theme_options');
$package_expiry_notification = isset($exertio_theme_options['package_expiry_notification']) ? $exertio_theme_options['package_expiry_notification'] : false;
if (isset($package_expiry_notification) && ($package_expiry_notification)) {
    if (!wp_next_scheduled('fl_package_expiray_notification')) {
        wp_schedule_event(time(), 'daily', 'fl_package_expiray_notification');
    }
} else {
    if (wp_next_scheduled('fl_package_expiray_notification')) {
        $timestamp = wp_next_scheduled('fl_package_expiray_notification');
        wp_unschedule_event($timestamp, 'fl_package_expiray_notification');
    }
}

add_action('fl_package_expiray_notification', 'fl_package_expiray_notification_callback');

if (!function_exists('fl_package_expiray_notification_callback')) {

    function fl_package_expiray_notification_callback() {
        global $exertio_theme_options;
        $exertio_theme_options = get_option('exertio_theme_options');
        $before_days = isset($exertio_theme_options['package_expire_notify_before']) ? $exertio_theme_options['package_expire_notify_before'] : 0;
        if (isset($exertio_theme_options['package_expiry_notification']) && ($exertio_theme_options['package_expiry_notification'])) {
            $fl_users = get_users(['role__in' => ['subscriber']]);
            if (isset($fl_users) && !empty($fl_users) && is_array($fl_users)) {
                foreach ($fl_users as $key => $user) {
                    $package_expiry_data = get_user_meta($user->ID, '_freelancer_package_expiry', true);
                    $sb_pkg_name = get_user_meta($user->ID, '_sb_pkg_type', true);
                    $user_data = $user->data;
                    $user_display_name = $user_data->display_name;
                    if (empty($package_expiry_data) || $package_expiry_data == -1) {
                        continue;
                    }
                    $notification_date = date("Y-m-d", strtotime("-{$before_days} days", strtotime($package_expiry_data)));
                    $today_data = date("Y-m-d");
                    if ($today_data == $notification_date) {
                        do_action('fl_package_expiry_notification', $before_days, $user->ID);
                    }
                }
            }
        }
    }
}