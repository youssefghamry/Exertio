<?php
if (!function_exists('set_hierarchical_terms'))
{
	function set_hierarchical_terms( $texonomy_name ='', $term_id ='', $pid ='')
	{
		$term = get_term( $term_id, $texonomy_name );
		$values[] = $term->term_id;
		if($term->parent >0)
		{
			$parent_one_term = get_term( $term->parent, $texonomy_name );
			$values[] = $parent_one_term->term_id;
			if($parent_one_term->parent >0)
			{
				$parent_two_term = get_term( $parent_one_term->parent, $texonomy_name );
				$values[] = $parent_two_term->term_id;
				if($parent_two_term->parent > 0)
				{
					$parent_three_term = get_term( $parent_two_term->parent, $texonomy_name );
					$values[] = $parent_three_term->term_id;
				}
			}
		}
	
		$integerIDs = array_map('intval', $values);
		$integerIDs = array_unique($integerIDs);
		wp_set_post_terms( $pid, $integerIDs, $texonomy_name );
	}
}
if (!function_exists('get_hierarchical_terms'))
{
	function get_hierarchical_terms( $texonomy_name ='', $post_meta= '', $pid ='')
	{
		$selected_ids =  get_post_meta($pid, $post_meta, true);
		if($post_meta =='')
		{
			$selected_ids = $pid;
		}
		$hierarchy ='';
		$taxonomies = exertio_get_terms($texonomy_name);
		$hierarchy = _get_term_hierarchy($texonomy_name);
		$options = '';

		
		foreach($taxonomies as $term)
		{
			/** Skip term if it has children */
			if($term->parent)
			{
				continue;
			}
			
			//$selected_id = current($selected_id);
			if($term->term_id == $selected_ids){ $selected = 'selected ="selected"';}else{$selected = ''; }
			$options .= '<option value="' . $term->term_id . '" '.$selected.'>' . $term->name . '</option>';
			/** If the term has children... */
			if(isset($hierarchy[$term->term_id]) )
			{
				/** ...display them */
				foreach($hierarchy[$term->term_id] as $child) 
				{
					/** Get the term object by its ID */
					$child = get_term($child, $texonomy_name);
					if($child->term_id == $selected_ids){ $selected = 'selected ="selected"';}else{$selected = ''; }
					$options .= '<option value="' . $child->term_id . '" '.$selected.'> - ' . $child->name . '</option>';
					
					if(isset($hierarchy[$child->term_id]))
					{
						foreach($hierarchy[$child->term_id] as $child2)
						{
							/** Get the term object by its ID */
							$child2 = get_term($child2, $texonomy_name);
							if($child2->term_id == $selected_ids){ $selected = 'selected ="selected"';}else{$selected = ''; }
							$options .= '<option value="' . $child2->term_id . '" '.$selected.'> -- ' . $child2->name . '</option>';
							
							if(isset($hierarchy[$child2->term_id]))
							{
								foreach($hierarchy[$child2->term_id] as $child3)
								{
									/** Get the term object by its ID */
									$child3 = get_term($child3, $texonomy_name);
									if($child3->term_id == $selected_ids){ $selected = 'selected ="selected"';}else{$selected = ''; }
									$options .= '<option value="' . $child3->term_id . '" '.$selected.'> --- ' . $child3->name . '</option>';
								}
							}
						}
					}
				}
			}
		}	
		return $options;
	}
}

if (!function_exists('fl_get_projects'))
{
    function fl_get_projects($title ='', $author = '', $meta_query = array(), $status = '')
	{
		
		if ( get_query_var( 'paged' ) )
		{
			$paged = get_query_var( 'paged' );
		} 
		else if ( get_query_var( 'page' ) ) 
		{
			/*This will occur if on front page.*/
			$paged = get_query_var( 'page' );
		}
		else 
		{
			$paged = 1;
		}
		
		$args = array(
				's' => $title,
				'author__in' => array( $author ) ,
				'post_type' =>'projects',
				'meta_query' => array($meta_query),
				'paged' => $paged,	
				'post_status'     => $status													
				);

		$the_query = new WP_Query($args);
		return $the_query;
    }
}

function get_term_names( $texonomy_name ='', $post_meta = '', $pid ='', $reverse ='', $separater = '')
{
	$selected_ids =  get_post_meta($pid, $post_meta, true);


	$term='';
	$term = get_term( get_post_meta($pid, $post_meta, true));
	$term_name = isset($term->name) ? $term->name : '' ;
	$option_ar = array();
	$option_ar[] .= $term_name.$separater.' ';
	
	$term_parent = isset($term->parent) ? $term->parent : '' ;
	if($term_parent > 0)
	{
		//echo $term->parent;
		$term2 = get_term( $term->parent);
		$option_ar[] .= $term2->name.$separater.' ';
		if($term2->parent > 0)
		{
			$term3 = get_term( $term2->parent);
			$option_ar[] .= $term3->name.$separater.' ';
			if($term3->parent > 0)
			{
				$term4 = get_term( $term3->parent);
				$option_ar[] .= $term4->name.$separater.' ';
			}
		}
		
	}
	if($reverse == 'reverse')
	{
		$option_ar = array_reverse($option_ar);	
	}
	$option ='';
	foreach($option_ar as $option_ars)
	{
		$option .= $option_ars;	
	}
	if($separater != '')
	{
		$option = substr($option, 0, -2);
	}
	
	return $option;
}

if ( ! function_exists( 'custom_pagination' ) )
{
    function custom_pagination( $pid, $paged = '', $max_posts = '5' )
    {
        if(isset($paged))
		{
            $pageno = $paged;
        } 
		else 
		{
            $pageno = 1;
        }
        $no_of_records_per_page = $max_posts;
        $offset = ($pageno-1) * $no_of_records_per_page;
		
		
		
		global $wpdb;
		$table = EXERTIO_PROJECT_BIDS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "'";
			$result = $wpdb->get_results($query);
			
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=project-propsals&project-id=".$pid."&pageno=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
		}
		for ($i=1; $i<=$total_pages; $i++)
		{
			if($total_pages> 1)
			{
				if($i==$pageno)
				{  
					$pagLink .= "<li class='active'><a href='javascript:void(0)'>".$i."</a></li>"; 
				}
				else if($i > $pageno+2 || $i < $pageno-2)
				{
					$pagLink .= "";
				}
				else
				{
					$pagLink .= "<li><a href='?ext=project-propsals&project-id=".$pid."&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?ext=project-propsals&project-id=".$pid."&pageno=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;

    }
}
if ( ! function_exists( 'pagination_ongoing_services' ) )
{
    function pagination_ongoing_services( $pid, $paged = '', $max_posts = '5', $page_type = 'ongoing' )
    {
        if(isset($paged))
		{
            $pageno = $paged;
        } 
		else 
		{
            $pageno = 1;
        }
        $no_of_records_per_page = $max_posts;
        $offset = ($pageno-1) * $no_of_records_per_page;
		
		global $wpdb;

		$table =  EXERTIO_PURCHASED_SERVICES_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `seller_id` = '" . $pid . "' AND `status` ='".$page_type."'";
			$result = $wpdb->get_results($query);
			
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=".$page_type."-services&pageno=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
		}
		for ($i=1; $i<=$total_pages; $i++)
		{
			if($total_pages> 1)
			{
				if($i==$pageno)
				{  
					$pagLink .= "<li class='active'><a href='javascript:void(0)'>".$i."</a></li>"; 
				}
				else if($i > $pageno+2 || $i < $pageno-2)
				{
					$pagLink .= "";
				}
				else
				{
					$pagLink .= "<li><a href='?ext=".$page_type."-services&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?ext=".$page_type."-services&pageno=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;
    }
}

if ( ! function_exists( 'pagination_ongoing_services_buyer' ) )
{
    function pagination_ongoing_services_buyer( $pid, $paged = '', $max_posts = '5', $page_type = 'ongoing' )
    {
        if(isset($paged))
		{
            $pageno = $paged;
        } 
		else 
		{
            $pageno = 1;
        }
        $no_of_records_per_page = $max_posts;
        $offset = ($pageno-1) * $no_of_records_per_page;
		
		
		
		global $wpdb;
		$table =  EXERTIO_PURCHASED_SERVICES_TBL;

		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			//$query = "SELECT * FROM ".$wpdb->prefix."project_bids WHERE `project_id` = '" . $pid . "'";
			$query = "SELECT * FROM ".$table." WHERE `buyer_id` = '" . $pid . "' AND `status` ='".$page_type."'";
			$result = $wpdb->get_results($query);
			
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=".$page_type."-services&pageno=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
		}
		for ($i=1; $i<=$total_pages; $i++)
		{
			if($total_pages> 1)
			{
				if($i==$pageno)
				{  
					$pagLink .= "<li class='active'><a href='javascript:void(0)'>".$i."</a></li>"; 
				}
				else if($i > $pageno+2 || $i < $pageno-2)
				{
					$pagLink .= "";
				}
				else
				{
					$pagLink .= "<li><a href='?ext=".$page_type."-services&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages && $total_pages > 1)
		{
			$pagLink .= "<li><a href='?ext=".$page_type."-services&pageno=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;
		
		?>
<?php
    }
}
if ( ! function_exists( 'custom_pagination_invoices' ) )
{
    function custom_pagination_invoices( $number_of_rows, $paged  )
    {
        if(isset($paged))
		{
            $pageno = $paged;
        } 
		else 
		{
            $pageno = 1;
        }
        $no_of_records_per_page = get_option('posts_per_page');
        $offset = ($pageno-1) * $no_of_records_per_page;

		$total_rows = $number_of_rows;
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=invoices&paged=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
		}
		for ($i=1; $i<=$total_pages; $i++)
		{
			if($total_pages> 1)
			{
				if($i==$pageno)
				{  
					$pagLink .= "<li class='active'><a href='javascript:void(0)'>".$i."</a></li>"; 
				}
				else if($i > $pageno+2 || $i < $pageno-2)
				{
					$pagLink .= "";
				}
				else
				{
					$pagLink .= "<li><a href='?ext=invoices&paged=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?ext=invoices&paged=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;

    }
}

if ( ! function_exists( 'custom_pagination_proposals' ) )
{
    function custom_pagination_proposals( $max_posts = '5', $paged = '' )
    {
        if(isset($paged))
		{
            $pageno = $paged;
        } 
		else 
		{
            $pageno = 1;
        }
        $no_of_records_per_page = $max_posts;
        $offset = ($pageno-1) * $no_of_records_per_page;
		
		
		
		global $wpdb;
		$table = EXERTIO_PROJECT_BIDS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$current_user_id = get_current_user_id();
			$freelancer_id = get_user_meta( $current_user_id, 'freelancer_id' , true );
			$query = "SELECT * FROM ".$table." WHERE `freelancer_id` = '" . $freelancer_id . "'";

			$result = $wpdb->get_results($query);
			
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=my-proposals&pageno=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
		}
		for ($i=1; $i<=$total_pages; $i++)
		{
			if($total_pages> 1)
			{
				if($i==$pageno)
				{  
					$pagLink .= "<li class='active'><a href='javascript:void(0)'>".$i."</a></li>"; 
				}
				else if($i > $pageno+2 || $i < $pageno-2)
				{
					$pagLink .= "";
				}
				else
				{
					$pagLink .= "<li><a href='?ext=my-proposals&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?ext=my-proposals&pageno=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;

    }
}


if ( ! function_exists( 'project_expiry_calculation2' ) )
{
    function project_expiry_calculation2( $pid )
    {
		$expiry = get_post_meta($pid, '_project_expiry', true);
		//echo $expiry.'';
		$today = date('Y-m-d');

		$now = time(); // or your date as well
		$expiry_date = strtotime($expiry);
		$datediff = $expiry_date - $now;

		$remaining_days = round($datediff / (60 * 60 * 24));
		//echo $remaining_days;
		if($today > $expiry)
		{
			return '<p class="expired">'.__('Expired ','exertio_framework').'</p>';		
		}
		else if($remaining_days != -0)
		{
			return '<p>'.$remaining_days. __(' Days left','exertio_framework').'</p>';
		}
		else
		{
			return '<p>'.__('Closing Today ','exertio_framework').'</p>';
		}
	}
}
if ( ! function_exists( 'project_expiry_calculation' ) )
{
    function project_expiry_calculation( $pid )
    {
		$expiry = get_post_meta($pid, '_simple_projects_expiry_date', true); 
		if(isset($expiry) && $expiry == -1 )
		{
			return '<p>'.__('Never Expire ','exertio_framework').'</p>';
		}
		else
		{
			$today = date('d-m-Y');

			$now = time();

			$expiry_date = strtotime($expiry);
			$datediff = $expiry_date - $now;

			$remaining_days = round($datediff / (60 * 60 * 24));

			if(strtotime($today) > strtotime($expiry))
			{
				return '<p class="expired">'.__('Expired ','exertio_framework').'</p>';		
			}
			else if($remaining_days != -0 && $remaining_days > 0)
			{
				return '<p>'.$remaining_days. __(' Days left','exertio_framework').'</p>';
			}
			else
			{
				return '<p>'.__('Closing Today ','exertio_framework').'</p>';
			}
		}
	}
}


add_action('wp_ajax_fl_assign_project', 'fl_assign_project');

if ( ! function_exists( 'fl_assign_project' ) ) 
{
	function fl_assign_project()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$pid = sanitize_text_field($_POST['pid']);
		$fl_id = sanitize_text_field($_POST['fl_id']);
		if( $pid != '' && $fl_id != '')
		{

			$author_id = get_post_field( 'post_author', $pid );
			$current_user_id = get_current_user_id();
			global $exertio_theme_options;
			if($author_id == $current_user_id)
			{
				$ex_amount = get_user_meta( $author_id, '_fl_wallet_amount', true );
				$project_type = get_post_meta($pid, '_project_type', true);
				$awarded_result = project_awarded($pid, $fl_id);

				if(isset($exertio_theme_options['allow_project_propsal_amount']) && $exertio_theme_options['allow_project_propsal_amount'] == 1){
					if($project_type == 'fixed' || $project_type == 1)
					{
						$project_cost = $awarded_result[0]->proposed_cost;
					}
					else if($project_type == 'hourly' || $project_type == 2)
					{
						$hourly_charges = $awarded_result[0]->proposed_cost;
						$total_hours = get_post_meta($pid, '_estimated_hours', true);
						$project_cost = $hourly_charges * $total_hours;
					}
				}else{

					if($project_type == 'fixed' || $project_type == 1)
					{
						$project_cost = get_post_meta($pid, '_project_cost', true);
					}
					else if($project_type == 'hourly' || $project_type == 2)
					{
						$hourly_charges = get_post_meta($pid, '_project_cost', true);
						$total_hours = get_post_meta($pid, '_estimated_hours', true);
						$project_cost = $hourly_charges * $total_hours;
					}
				}
				/*FOR THE WALLET SYSTEM REMOVAL*/
				$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
				if($project_cost > $ex_amount &&  $is_wallet_active == 0)
				{
					$return = array('message' => esc_html__( 'You do not have enough amount in your wallet to assign this project', 'exertio_framework' ));
					wp_send_json_error($return);
				}
				else
				{
					/*FOR THE WALLET SYSTEM REMOVAL*/
					if(isset($is_wallet_active) && $is_wallet_active == 0)
					{
						$new_wallet_amount = $ex_amount - $project_cost;
						
						update_user_meta($current_user_id, '_fl_wallet_amount',$new_wallet_amount);
						
						/*STATEMENTS*/
						do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$project_cost,'t_type'=>'project_assign','t_status'=>'2', 'user_id'=> $current_user_id));
					}
					
					$status = "'ongoing'";
					global $exertio_theme_options;
					$my_post = array(
						'ID' => $pid,
						'post_type' => 'projects',
						'post_status'   => $status,
					);

					$result = wp_update_post($my_post, true);
					
					
					if (is_wp_error($result))
					{
						$return = array('message' => esc_html__( 'Can not update project status, please contact admin', 'exertio_framework' ));
						wp_send_json_error($return);
						exit;
					}
					else
					{
						$current_time = current_time('mysql');
						$admin_commission_percent = fl_framework_get_options('project_charges');
						$decimal_amount = $admin_commission_percent/100;
						$admin_commission = $decimal_amount*$project_cost;
						$freelancer_earning = $project_cost - $admin_commission;
						$employer_id = get_user_meta( $current_user_id, 'employer_id' , true );
						
						/*PROJECT LOGS*/
						global $wpdb;
						
						$table = EXERTIO_PROJECT_LOGS_TBL;
						$data = array(
									'timestamp' => $current_time,
									'updated_on' =>$current_time,
									'project_id' => $pid,
									'employer_id' => sanitize_text_field($employer_id),
									'freelancer_id' => sanitize_text_field($fl_id),
									'project_cost' => sanitize_text_field($project_cost),
									'proposal_cost' => sanitize_text_field($project_cost),
									'admin_commission' => sanitize_text_field($admin_commission),
									'commission_percent' => sanitize_text_field($admin_commission_percent),
									'freelacner_earning' => $freelancer_earning,
									'status' => 'ongoing',
									);
						$wpdb->insert($table,$data);
						$log_id = $wpdb->insert_id;
						
						if(empty($log_id))
						{
							$return = array('message' => esc_html__( 'Can not update project logs, please contact admin', 'exertio_framework' ));
							wp_send_json_error($return);
							exit;
						}
						update_post_meta( $pid, '_freelancer_assigned', $fl_id);
						update_post_meta( $pid, '_project_assigned_date', date("Y-m-d h:i:s"));
						update_post_meta($pid, '_project_remaining_cost', sanitize_text_field($project_cost));
						
						/*SEND EAIL ON PROJECT ASSIGNMENT*/
						$frelancer_user_id = get_post_field( 'post_author', $fl_id );
						if(fl_framework_get_options('fl_email_freelancer_assign_project') == true)
						{
							fl_assign_project_freelancer_email($frelancer_user_id,$pid,$project_cost);
						}
						if(fl_framework_get_options('fl_email_emp_assign_project') == true)
						{
							fl_assign_project_employer_email($author_id,$pid,$project_cost,$frelancer_user_id);
						}
						/*NOTIFICATION*/
						//$post_author_user_id = get_post_field( 'post_author', $project_id );
						do_action( 'exertio_notification_filter',array('post_id'=> $pid,'n_type'=>'project_assigned','sender_id'=>$current_user_id,'receiver_id'=>$frelancer_user_id, 'sender_type'=> 'employer') );
						
						
						$redirect_page = get_the_permalink($exertio_theme_options['user_dashboard_page']).'?ext=ongoing-project-proposals&project-id='.$pid;
						$return = array('message' => esc_html__( 'Project assigned successfully', 'exertio_framework' ), 'page' => $redirect_page);
						wp_send_json_success($return);
					}
				}
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Can not assign project!!! please contact Admin', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	}
}


/*HISTORY MESSAGE SAVE*/
add_action('wp_ajax_fl_history_msg', 'fl_history_msg');
if ( ! function_exists( 'fl_history_msg' ) ) 
{
	function fl_history_msg()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$current_user_id = get_current_user_id();
		$pid = $_POST['post_id'];
		$fl_id = $_POST['fl_id'];
		$msg_author = $_POST['msg_author'];
		$current_datetime = current_time('mysql');
		
		parse_str($_POST['fl_data'], $params);
		
		if($params['history_msg_text'] != '')
		{
			global $wpdb;
			$table = EXERTIO_PROJECT_MSG_TBL;
			$data = array(
						'timestamp' => $current_datetime,
						'updated_on' =>$current_datetime,
						'project_id' => sanitize_text_field($pid),
						'message' => sanitize_text_field($params['history_msg_text']),
						'freelancer_id' => sanitize_text_field($fl_id),
						'attachment_ids' => sanitize_text_field($params['attachment_ids']),
						'msg_author' => sanitize_text_field($msg_author),
						'status' => '1',
						);
	
			$wpdb->insert($table,$data);
			$msg_id = $wpdb->insert_id;
			if($msg_id)
			{
				$current_active_user = get_user_meta($current_user_id, '_active_profile', true);
				if($current_active_user == 1)
				{
					$sender_type = 'employer';
					$post_author_user_id = get_post_field( 'post_author', $fl_id );
				}
				else if($current_active_user == 2)
				{
					$sender_type = 'freelancer';
					$post_author_user_id = get_post_field( 'post_author', $pid); 
				}
				//$post_author_user_id = get_post_field( 'post_author', $fl_id );
				$active_notif = fl_framework_get_options('exertio_notifications_msgs');
				if(isset($active_notif)&& $active_notif == true)
				{
					do_action( 'exertio_notification_filter',array('post_id'=> $pid,'n_type'=>'project_msg','sender_id'=>$current_user_id,'receiver_id'=>$post_author_user_id,'sender_type'=>$sender_type) );
				}
				$return = array('message' => esc_html__( 'Message sent', 'exertio_framework' ));
				wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__( 'Error!!! Message sending failed.', 'exertio_framework' ));
				wp_send_json_error($return);	
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Message field can not be empty', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	}
}


add_action('wp_ajax_gen_atatchment_uploader', 'gen_atatchment_uploader');
if ( ! function_exists( 'gen_atatchment_uploader' ) ) 
{ 
	function gen_atatchment_uploader()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('echo');
		
		global $exertio_theme_options;
		$pid = $_POST['post-id'];
		$field_name =  $_FILES['gen_attachment_uploader'];

		$condition_img=7;
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
			   
			$attachment_ids=array();
			$attachment_idss='';
			$data = '';
			foreach($files['name'] as $key => $value) 
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
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pptx" && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "ppt" && $imageFileType != "xls" && $imageFileType != "xlsx" && $imageFileType != "zip")
					{
						echo '0|' . esc_html__( "Sorry, only JPG, JPEG, PNG, docx, pptx, xlsx, pdf and zip files are allowed.", 'exertio_framework' );
						die();
					}
					
					
					foreach ($_FILES as $file => $array) 
					{              
						if ($array['size']/1000 > $attachment_size) {
							echo '0|' . esc_html__( "Max allowd attachment size is ".$attachment_size.' Kb', 'exertio_framework' );
							die();
							break;
						}
					  
					 $attach_id = media_handle_upload( $file, $pid );
					  $attachment_ids[] = $attach_id;
					  
						
						$icon = get_icon_for_attachment($attach_id);
					  $data .= '<div class="attachments pro-atta-'.$attach_id.'"> <img src="'.$icon.'" alt=""><span class="attachment-data"> <h4>'.get_the_title($attach_id).' </h4> <p> file size: '.size_format(filesize(get_attached_file( $attach_id ))).'</p> <a href="javascript:void(0)" class="general-delete" data-id="'.$attach_id.'" data-pid="'.$pid.'"> <i class="far fa-times-circle"></i></a> </span></div>';
					  
					}
				} 
			}
			
			$attachment_idss = array_filter( $attachment_ids  );
			$attachment_idss =  implode( ',', $attachment_idss );
			   
		} 
		//if($exist_data_count < $condition_img)
		//{
			echo '1|'.esc_html__( "Attachments uploaded", 'exertio_framework' ).'|' .$data.'|'.$attachment_idss;
			die;
		//}
	
	}
}

/*DELETE GENERAL ATATCHMENT IDS*/
add_action('wp_ajax_delete_gen_atatchment', 'delete_gen_atatchment');
if ( ! function_exists( 'delete_gen_atatchment' ) ) 
{
	function delete_gen_atatchment()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		$attachment_id = $_POST['attach_id'];
		$pid = $_POST['pid'];
		$exist_data = $_POST['ex_values'];
		

		if($attachment_id !='' && $pid != '')
		{
			$array1 = array($attachment_id);
			$array2 = explode(',', $exist_data);
			$array3 = array_diff($array2, $array1);
			wp_delete_attachment($attachment_id);
			$new_data = implode(',', $array3);
			$return = array('message' => esc_html__( 'Attachment deleted', 'exertio_framework' ), 'ids'=>$new_data);
			wp_send_json_success($return);
			
		}
		else
		{
			$return = array('message' => esc_html__( 'Error!!! attachment is not deleted', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	}
}

if ( ! function_exists( 'get_history_msg' ) ) 
{
	function get_history_msg($pid)
	{
		global $wpdb;
		$table = EXERTIO_PROJECT_MSG_TBL;;

		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $pid . "' AND `status` ='1'";
			$result = $wpdb->get_results($query);

			if($result)
			{
				return $result;
			}
		}
	}
}


if ( ! function_exists( 'time_ago_function' ) )
{
	function time_ago_function($timestamp)
	{
		$timestamp = strtotime($timestamp);
        $strTime = array(
            __('second', 'exertio_framework'),
            __('minute', 'exertio_framework'),
            __('hour', 'exertio_framework'),
            __('day', 'exertio_framework'),
            __('month', 'exertio_framework'),
            __('year', 'exertio_framework')
        );
        $length = array("60", "60", "24", "30", "12", "10");

        $currentTime = strtotime(current_time('mysql'));
        if ($currentTime >= $timestamp) {
            $diff = $currentTime - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }
            $diff = round($diff);
			if($diff == 1)
			{
				return $diff . " " . $strTime[$i] . __(' ago', 'exertio_framework');
			}
			else
			{
				return $diff . " " . $strTime[$i] . __('s ago', 'exertio_framework');
			}
        }	
	}
}

add_action('wp_ajax_history_msg_atatchment_download', 'history_msg_atatchment_download');
if ( ! function_exists( 'history_msg_atatchment_download' ) )
{
	function history_msg_atatchment_download()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$msg_id = $_POST['msg_id'];
		
		if(!empty($msg_id))
		{
			
			$atatchment_arr = explode( ',', $msg_id );
			$result =array();
			foreach ($atatchment_arr as $value)
			{
				$full_link = wp_get_attachment_url($value);
				$result[] .= $full_link;
			}

			//$themename = wp_get_theme();
			$themename = get_bloginfo('name');
			
			if(class_exists('ZipArchive'))
            {
				$zip = new ZipArchive();

				$dir_path	= wp_upload_dir();
				$folderRelPath = $dir_path['baseurl']."/message_attachments";
				$folderAbsPath = $dir_path['basedir']."/message_attachments";

				wp_mkdir_p($folderAbsPath);

				$filename	= $themename.'-'.round(microtime(true)).'.zip';
				$zip_name = $folderAbsPath.'/'.$filename; 
				$zip->open($zip_name,  ZipArchive::CREATE);
				$gen_download_link	= $folderRelPath.'/'.$filename;

				foreach($result as $key )
				{	
					$file_url	= $key;
					$response	= wp_remote_get( $file_url );
					$filedata   = wp_remote_retrieve_body( $response );
					$zip->addFromString(basename( $file_url ), $filedata);
				}
				$zip->close();
				$return = array('message' => esc_html__( 'Generating Attachments to Download. Please wait...', 'exertio_framework' ), 'attachments'=>$gen_download_link);
				wp_send_json_success($return);
			}
			else
    		{
    			$return = array('message' => esc_html__( 'ZipArchive is not enabled on your server', 'exertio_framework' ));
    			wp_send_json_error($return);	
    		}
		}
		else
		{
			$return = array('message' => esc_html__( 'Error!!! attachment is not available', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
			
	}
}


add_action('wp_ajax_fl_project_status_rating', 'fl_project_status_rating');
if ( ! function_exists( 'fl_project_status_rating' ) ) 
{
	function fl_project_status_rating()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$pid = $_POST['post_id'];
		$status = $_POST['status'];
		global $exertio_theme_options;
		$fid = get_post_meta( $pid, '_freelancer_assigned', true );
		$post_author = get_post_field( 'post_author', $pid );
		$employer_id = get_user_meta( $post_author, 'employer_id' , true );
		
		$current_datetime = current_time('mysql');
		
		parse_str($_POST['rating_data'], $params);
		
		
		if(get_current_user_id() == $post_author)
		{
			/*CHECK IF THERE IS ANY MILESTONE LEFT THAT IS NOT BEEN PAID*/
			$stored_milestone_data = get_post_meta($pid,'_project_milestone_data', true);
			if(!empty($stored_milestone_data))
			{
				foreach($stored_milestone_data as $stored_milestone_data_array)
				{
					$count = $stored_milestone_data_array['milestone_id'];
					$milestone_status = $stored_milestone_data_array['milestone_status'];

					if($milestone_status == 'pending' )
					{
						$return = array('message' => esc_html__( 'Please pay created milestones first', 'exertio_framework' ));
						wp_send_json_error($return);	
					}
				}
			}

			if($status == '' || $pid == '')
			{
				$return = array('message' => esc_html__('Please select project status first','exertio_framework'));
				wp_send_json_error($return);
			}
			else if($status == 'complete')
			{
				global $wpdb;

				$star1 = sanitize_text_field($params['stars_1']);
				$star2 = sanitize_text_field($params['stars_2']);
				$star3 = sanitize_text_field($params['stars_3']);
				
				$single_avg = 0;
				$total_stars = $star1 + $star2 + $star3;
				$single_avg = round($total_stars / "3", 1);
				
				
				
				$table = EXERTIO_REVIEWS_TBL;
				$data = array(
							'timestamp' => $current_datetime,
							'updated_on' =>$current_datetime,
							'project_id' => $pid,
							'feedback' => sanitize_text_field($params['feedback_text']),
							'star_1' => $star1,
							'star_2' => $star2,
							'star_3' => $star3,
							'star_avg' => $single_avg,
							'receiver_id' => sanitize_text_field($fid),
							'giver_id' => sanitize_text_field($employer_id),
							'type' => 'project',
							'status' => '1',
							);
				$wpdb->insert($table,$data);
				$review_id = $wpdb->insert_id;
				if($review_id)
				{
					$project_status = "'completed'";
					$my_post = array(
						'ID' => $pid,
						'post_type' => 'projects',
						'post_status'   => $project_status,
					);

					$result = wp_update_post($my_post, true);
					
					
					if (is_wp_error($result))
					{
						$return = array('message' => esc_html__( 'can not mark as complete!!! Please contact admin', 'exertio_framework' ));
						wp_send_json_error($return);
					}
					else
					{
						//global $wpdb;
						$table = EXERTIO_PROJECT_LOGS_TBL;
						if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
						{
							$query = "SELECT `freelacner_earning` , `freelancer_id`, `id`, `project_cost`, `admin_commission` FROM ".$table." WHERE `project_id` = '" . $pid . "' ";
							$result = $wpdb->get_results($query);

							
							$log_id = $result[0]->id;
							$earned_amount = $result[0]->freelacner_earning;
							$freelancer_id = $result[0]->freelancer_id;
							$project_price = $result[0]->project_cost;
							$admin_com = $result[0]->admin_commission;
							$freelancer_user_id = get_post_field( 'post_author', $freelancer_id );
							$ex_amount = get_user_meta( $freelancer_user_id, '_fl_wallet_amount', true );
							$awarded_result = project_awarded($pid, $freelancer_id);

							if(isset($exertio_theme_options['allow_project_propsal_amount']) && $exertio_theme_options['allow_project_propsal_amount'] == 1){
								$project_price = $awarded_result[0]->proposed_cost;
							}
							/*IF MILESTONE CREATED OR NOT*/
							if(empty($stored_milestone_data))
							{
								$new_wallet_amount = $ex_amount + $earned_amount;
								/*STATEMENTS*/
								do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$earned_amount,'t_type'=>'project_complete','t_status'=>'1', 'user_id'=> $freelancer_user_id));
								if($admin_com >0)
								{
									do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$admin_com,'t_type'=>'project_admin_commission','t_status'=>'2', 'user_id'=> $freelancer_user_id));
								}
							}
							else
							{
								$get_remaining_project_cost = get_post_meta($pid, '_project_remaining_cost', true);
								
								$admin_commission_percent = fl_framework_get_options('project_charges');
								$decimal_amount = $admin_commission_percent/100;
								$admin_commission = $decimal_amount*$get_remaining_project_cost;
								$freelancer_earning = $get_remaining_project_cost - $admin_commission;
								
								
								/*STATEMENTS*/
								do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$freelancer_earning,'t_type'=>'project_complete','t_status'=>'1', 'user_id'=> $freelancer_user_id));
								if($admin_commission >0)
								{
									do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$admin_commission,'t_type'=>'project_admin_commission','t_status'=>'2', 'user_id'=> $freelancer_user_id));
								}
								
								$new_wallet_amount = $ex_amount + $freelancer_earning;
								
								$today_date = date("d-m-Y");
								$stored_milestone_data[] = array(
									"milestone_id" => $count+1,
									"milestone_title" => __( 'Final milestone', 'exertio_framework' ),
									"milestone_desc" => '',
									"milestone_created_date" => $today_date,
									"milestone_paid_date" => $today_date,
									"total_project_amount" => $project_price,
									"current_milestone_amount" => 0,
									"milestone_amount_paid" => $get_remaining_project_cost,
									"milestone_remaining_amount" => 0,
									"milestone_status" => 'paid',
								);
							}
							update_post_meta($pid,'_project_milestone_data', $stored_milestone_data);
							$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
							if(isset($is_wallet_active) && $is_wallet_active == 0)
							{
								update_user_meta($freelancer_user_id, '_fl_wallet_amount',$new_wallet_amount);
							}
							
							/*REWARD OR TIP DEDUCTION FROM EMPLOYER ACCOUNT*/
							if(isset($exertio_theme_options['allow_project_tip_reward']) && $exertio_theme_options['allow_project_tip_reward'] != 0)
							{
								if(isset($params['reward_tip_checkbox']))
								{
									if(isset($params['reward_tip']) && $params['reward_tip'] == '')
									{
										$return = array('message' => esc_html__( 'Please provide reward/tip amount or disable it.', 'exertio_framework' ));
										wp_send_json_error($return);
									}
									else
									{
										if(is_numeric($params['reward_tip']))
										{
											$author_ex_amount = get_user_meta( $post_author, '_fl_wallet_amount', true );
											if(isset($author_ex_amount) && $author_ex_amount < $params['reward_tip'])
											{
												$return = array('message' => esc_html__( 'Please recharge your wallet to pay reward or tip', 'exertio_framework' ));
												wp_send_json_error($return);
											}
											else
											{
												$new_author_amount = $author_ex_amount - $params['reward_tip'];
												if(isset($is_wallet_active) && $is_wallet_active == 0)
												{
													/*DEDUCTIONG FROM EMPLOYER ACCOUNT*/
													update_user_meta($post_author, '_fl_wallet_amount',$new_author_amount);
													/*STATEMENT*/
													do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$params['reward_tip'],'t_type'=>'project_tip','t_status'=>'2', 'user_id'=> $post_author));
													
													/*ADDING INTO FREELANCER ACCOUNT*/
													$freelancer_ex_amount = get_user_meta( $freelancer_user_id, '_fl_wallet_amount', true );
													$freealncer_new_amount = $freelancer_ex_amount + $params['reward_tip'];
													update_user_meta($freelancer_user_id, '_fl_wallet_amount',$freealncer_new_amount);
													
													/*STATEMENT*/
													do_action( 'exertio_transection_action',array('post_id'=> $pid,'price'=>$params['reward_tip'],'t_type'=>'project_tip','t_status'=>'1', 'user_id'=> $freelancer_user_id));
												}
											}
										}
										else
										{
											$return = array('message' => esc_html__( 'numeric amount only', 'exertio_framework' ));
											wp_send_json_error($return);
										}
									}
								}
							}

							
							$log_data = array(
								'status' => 'complete',
								);
							$where = array(
										'id' => $log_id,
										);
										
							$log_update_id = $wpdb->update( $table, $log_data, $where );
							
							if($log_update_id)
							{
								update_post_meta( $pid, '_project_completed_date', date("Y-m-d h:i:s"));
								
								$redirect_page = get_the_permalink($exertio_theme_options['user_dashboard_page']).'?ext=completed-project-detail&project-id='.$pid;
								/*EMAIL ON PROJECT COMPLETION*/
								$freelancer_user_id = get_post_field( 'post_author', $fid );
								if(fl_framework_get_options('fl_email_freelancer_complete_project') == true)
								{
									fl_project_completed_freelancer_email($freelancer_user_id,$pid);
								}
								if(fl_framework_get_options('fl_email_emp_complete_project') == true)
								{
									fl_project_completed_employer_email($post_author,$pid);
								}
								/*NOTIFICATIONS*/
								do_action( 'exertio_notification_filter',array('post_id'=> $pid,'n_type'=>'project_completed','sender_id'=>$post_author,'receiver_id'=>$freelancer_user_id, 'sender_type'=> 'employer') );
								
								/*NOTIFICATION FOR RATING*/
								do_action( 'exertio_notification_filter',array('post_id'=> $pid,'n_type'=>'project_rating','sender_id'=>$post_author,'receiver_id'=>$freelancer_user_id, 'sender_type'=> 'employer') );
								
								$return = array('message' => esc_html__( 'Marked as completed', 'exertio_framework' ), 'page' => $redirect_page);
								wp_send_json_success($return);
							}
							else
							{
								$return = array('message' => esc_html__( 'Error!!! project log not updated', 'exertio_framework' ));
								wp_send_json_error($return);	
							}
						}
					}
				}
				else
				{
					$return = array('message' => esc_html__( 'Error!!! Project completion not updated.', 'exertio_framework' ));
					wp_send_json_error($return);	
				}
			}
			else if($status == 'cancel')
			{
				$project_status = "'canceled'";
					$my_post = array(
						'ID' => $pid,
						'post_type' => 'projects',
						'post_status'   => $project_status,
					);

					$result = wp_update_post($my_post, true);
					
					
					if (is_wp_error($result))
					{
						$return = array('message' => esc_html__( 'can not mark as canceled!!! Please contact admin', 'exertio_framework' ));
						wp_send_json_error($return);
					}
					else
					{
						update_post_meta( $pid, '_project_cancle_reason', sanitize_text_field($params['feedback_text']));
						update_post_meta( $pid, '_project_cancle_date', date("Y-m-d h:i:s"));
						
						$freelancer_user_id = get_post_field( 'post_author', $fid );
						if(fl_framework_get_options('fl_email_freelancer_cancel_project') == true)
						{
							fl_project_canceled_freelancer_email($freelancer_user_id,$pid);
						}
						if(fl_framework_get_options('fl_email_emp_cancel_order') == true)
						{
							fl_project_canceled_employer_email($post_author,$pid);
						}
						/*NOTIFICATIONS*/
						do_action( 'exertio_notification_filter',array('post_id'=> $pid,'n_type'=>'project_canceled','sender_id'=>$post_author,'receiver_id'=>$freelancer_user_id, 'sender_type'=> 'employer') );
						
						$redirect_page = get_the_permalink($exertio_theme_options['user_dashboard_page']).'?ext=canceled-projects';
		
						$return = array('message' => esc_html__( 'Project canceled', 'exertio_framework' ), 'page' => $redirect_page);
						wp_send_json_success($return);
					}
			}
			else
			{
				$return = array('message' => esc_html__( 'Project Status Error.', 'exertio_framework' ));
				wp_send_json_error($return);	
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	}
}
/*SIMPLE CANCEL PROJECTS*/

// Add to favourites
add_action('wp_ajax_fl_simple_cancel_project', 'fl_simple_cancel_project');
add_action('wp_ajax_nopriv_fl_simple_cancel_project', 'fl_simple_cancel_project');
if ( ! function_exists( 'fl_simple_cancel_project' ) ) { 
	function fl_simple_cancel_project()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		global $exertio_theme_options;
		$pid		=	$_POST['pid'];
		$post_author = get_post_field( 'post_author', $pid );
		if(get_current_user_id() == $post_author)
		{
			$project_status = "'canceled'";
			$my_post = array(
				'ID' => $pid,
				'post_type' => 'projects',
				'post_status'   => $project_status,
			);

			$result = wp_update_post($my_post, true);
			
			
			if (is_wp_error($result))
			{
				$return = array('message' => esc_html__( 'can not mark as canceled!!! Please contact admin', 'exertio_framework' ));
				wp_send_json_error($return);
			}
			else
			{
				//update_post_meta( $pid, '_project_cancle_reason', sanitize_text_field($params['feedback_text']));
				update_post_meta( $pid, '_project_cancle_date', date("Y-m-d h:i:s"));
				
				$redirect_page = get_the_permalink($exertio_theme_options['user_dashboard_page']).'?ext=canceled-projects';

				$return = array('message' => esc_html__( 'Project canceled', 'exertio_framework' ), 'page' => $redirect_page);
				wp_send_json_success($return);
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Project ID error', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	
		
		die();
	}
}

if ( ! function_exists( 'get_rating' ) ) 
{
	function get_rating($receiver_id, $only_count = '', $stars = '')
	{
		global $wpdb;
		$table = EXERTIO_REVIEWS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $receiver_id . "' AND `status` ='1'";
			$results = $wpdb->get_results($query);
			$count_reviews = count($results);
			if($only_count != '')
			{
				return $count_reviews;
			}
			else
			{
				if($results)
				{
					$count_reviews = count($results);
					$reviews_text = esc_html__( ' review', 'exertio_framework' );
					if($count_reviews > 1)
					{
						$reviews_text = esc_html__( ' reviews', 'exertio_framework' );
					}
					foreach($results as $result)
					{
						$result->star_avg;	
						$avg_array[] = $result->star_avg;
					}
					$total_sum = array_sum($avg_array);
					$total_avg = round($total_sum / $count_reviews, 1);

					$whole = floor($total_avg); 
					$fraction = $total_avg - $whole; 
					$half_count = '1';

					if($stars == 'stars')
					{
						$stars_html = '';
						for ($i = 1; $i <= 5; $i++) {
							if ($i <= $total_avg)
							{
								$stars_html .= '<i class="fas fa-star colored"></i>';
							}
							else
							{
								if($fraction >= 0.50 && $half_count <= '1')
								{
									$half_count++;
									$stars_html .= ' <i class="fas fa-star-half-alt colored"></i>';
								}
								else
								{
									$stars_html .= '<i class="far fa-star colored"></i>';
								}
							}
						}
						return $stars_html.' '.number_format($total_avg,1).'<span class="text"> ( '.$count_reviews.$reviews_text.' )</span>';
					}
					else
					{
						$stars_html ='<i class="fas fa-star colored"></i>';
						return $stars_html.''.number_format($total_avg,1).' <span class="text">( '.$count_reviews.$reviews_text.' )</span>';
					}
				}
				else
				{
					$stars_html ='<i class="fas fa-star colored"></i>';
					return $stars_html.' '.esc_html__( 'No Reviews', 'exertio_framework' );	
				}
			}
		}
	}
}

// Add to favourites
add_action('wp_ajax_fl_mark_fav_project', 'fl_mark_fav_project');
add_action('wp_ajax_nopriv_fl_mark_fav_project', 'fl_mark_fav_project');
if ( ! function_exists( 'fl_mark_fav_project' ) ) { 
	function fl_mark_fav_project()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		exertio_check_register_user_type(2);
		$pid		=	$_POST['post_id'];
		if($pid != '')
		{
			if( get_user_meta( get_current_user_id(), '_pro_fav_id_'.$pid, true ) == $pid )
			{
				$return = array('message' => esc_html__( 'Already in your saved projects', 'exertio_framework' ));
				wp_send_json_error($return);
			}
			else
			{
				update_user_meta( get_current_user_id(), '_pro_fav_id_' . $pid, $pid );
				
				$return = array('message' => esc_html__( 'Added to your saved projects', 'exertio_framework' ));
				wp_send_json_success($return);
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Project ID error', 'exertio_framework' ));
			wp_send_json_error($return);	
		}

		die();
	}
}
// Remove to favourites
add_action('wp_ajax_fl_delete_fav_project', 'fl_delete_fav_project');
if ( ! function_exists( 'fl_delete_fav_project' ) )
{ 
	function fl_delete_fav_project()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		$pid		=	$_POST['post_id'];
		if ( delete_user_meta(get_current_user_id(), '_pro_fav_id_'.$pid) )
		{
			$return = array('message' => esc_html__( 'Removed from saved projects', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else
		{
			$return = array('message' => esc_html__( 'There is some problem, please try again later', 'exertio_framework' ));
			wp_send_json_error($return);
		}
	}
}

/*ADD TO SAVED SERVECES*/
add_action('wp_ajax_fl_mark_fav_services', 'fl_mark_fav_services');
add_action('wp_ajax_nopriv_fl_mark_fav_services', 'fl_mark_fav_services');
if ( ! function_exists( 'fl_mark_fav_services' ) ) { 
	function fl_mark_fav_services()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		exertio_check_register_user_type(1);
		
		$pid		=	$_POST['post_id'];
		if($pid != '')
		{

			if( get_user_meta( get_current_user_id(), '_service_fav_id_'.$pid, true ) == $pid )
			{
				$return = array('message' => esc_html__( 'Already in your saved services', 'exertio_framework' ));
				wp_send_json_error($return);
			}
			else
			{
				update_user_meta( get_current_user_id(), '_service_fav_id_' . $pid, $pid );
				
				$return = array('message' => esc_html__( 'Added to your saved services', 'exertio_framework' ));
				wp_send_json_success($return);
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Service ID error', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	
		
		die();
	}
}
/*REMOVE SAVED SERVICES*/
add_action('wp_ajax_fl_delete_saved_services', 'fl_delete_saved_services');
if ( ! function_exists( 'fl_delete_saved_services' ) )
{ 
	function fl_delete_saved_services()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		$pid		=	$_POST['post_id'];
		if ( delete_user_meta(get_current_user_id(), '_service_fav_id_'.$pid) )
		{
			$return = array('message' => esc_html__( 'Removed from saved services', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else
		{
			$return = array('message' => esc_html__( 'There is some problem, please try again later', 'exertio_framework' ));
			wp_send_json_error($return);
		}
	}
}

add_action('wp_ajax_fl_purchase_services', 'fl_purchase_services');
add_action('wp_ajax_nopriv_fl_purchase_services', 'fl_purchase_services');
if ( ! function_exists( 'fl_purchase_services' ) ) 
{
	function fl_purchase_services()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		
		fl_authenticate_check($_POST['sid']);
		exertio_check_register_user_type(1);
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$sid = $_POST['sid'];
		$admin_commission_emp = 0;
		$service_price = get_post_meta($sid, '_service_price', true);
		
		if(fl_framework_get_options('service_charges_employer') != null && fl_framework_get_options('service_charges_employer') > 0 )
		{
			$admin_commission_percent_emp = fl_framework_get_options('service_charges_employer');
			$decimal_amount_emp = $admin_commission_percent_emp/100;
			$admin_commission_emp = $decimal_amount_emp*$service_price;
		}
		
		$service_status = get_post_meta($sid, '_service_status', true);

		if(isset($service_status) && $service_status == 'expired')
		{
			$return = array('message' => esc_html__( 'This service has been expired', 'exertio_framework' ));
			wp_send_json_error($return);
		}
		parse_str($_POST['purchase_data'], $params);
		$current_datetime = current_time('mysql');
		$current_user = get_current_user_id();
		
		$post = get_post($sid);
		$post_author = $post->post_author;
		$seller_id = get_user_meta( $post_author, 'freelancer_id' , true );
		
		if($current_user  != $post_author)
		{
			$buyer_id = get_user_meta( $current_user, 'employer_id' , true );
			
			$selected_addon_ids = isset($params['services_addon']) ? $params['services_addon']: array();
			
			if(!empty($selected_addon_ids))
			{
				$args = array( 
								'post__in' => $selected_addon_ids,
								'post_type' =>'addons',
								'meta_query' => array(
									array(
										'key' => '_addon_status',
										'value' => 'active',
										'compare' => '=',
										),
									),
								'post_status'     => 'publish'													
								);
				$addons = get_posts($args);
				$addon_prices = array();
				foreach ( $addons as $addon )
				{
					$addon_prices[] =  get_post_meta( $addon->ID, '_addon_price', true );
				}
				
				$total_addon_price = array_sum($addon_prices);
				$gran_total = $service_price+$total_addon_price;
			}
			else
			{
				$selected_addon_ids = 0;
				$total_addon_price = 0;

				$gran_total = $service_price+$total_addon_price;
			}
			if( $sid != '')
			{
				$wallet_amount = get_user_meta( $current_user, '_fl_wallet_amount', true );
				$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
				if($gran_total > $wallet_amount && $is_wallet_active  == 0)
				{
					$return = array('message' => esc_html__( 'Please recharge your wallet to purchase this service', 'exertio_framework' ));
					wp_send_json_error($return);
					exit;
				}
				else
				{
					/*WALLET REMOVED OPTION*/
					if(isset($is_wallet_active) && $is_wallet_active  == 0)
					{
						$remaining_wallet_amount = $wallet_amount - $gran_total;
						$remaining_wallet_amount_2 = $remaining_wallet_amount - $admin_commission_emp;
						update_user_meta($current_user, '_fl_wallet_amount',$remaining_wallet_amount_2);
						
						/*STATEMENTS*/
						do_action( 'exertio_transection_action',array('post_id'=> $sid,'price'=>$gran_total,'t_type'=>'service_purchase','t_status'=>'2', 'user_id'=> $current_user));
						
						if(fl_framework_get_options('service_charges_employer') != null && fl_framework_get_options('service_charges_employer') > 0 )
						{
							if($admin_commission_emp > 0 )
							{
								do_action( 'exertio_transection_action',array('post_id'=> $sid,'price'=>$admin_commission_emp,'t_type'=>'service_admin_commission','t_status'=>'2', 'user_id'=> $current_user));
							}
						}
						
					}
					
					global $wpdb;
					$table =  EXERTIO_PURCHASED_SERVICES_TBL;
					$data = array(
								'timestamp' => $current_datetime,
								'updated_on' =>$current_datetime,
								'service_id' => $sid,
								'addon_ids' => json_encode(sanitize_text_field($selected_addon_ids)),
								'buyer_id' => sanitize_text_field($buyer_id),
								'seller_id' => sanitize_text_field($seller_id),
								'total_price' => sanitize_text_field($gran_total),
								'service_price' => sanitize_text_field($service_price),
								'addon_price' => sanitize_text_field($total_addon_price),
								'status' => 'ongoing',
								);
			
					$wpdb->insert($table,$data);
					$service_id = $wpdb->insert_id;
					if($service_id)
					{
						$admin_commission_percent = fl_framework_get_options('service_charges');
						$decimal_amount = $admin_commission_percent/100;
						$admin_commission = $decimal_amount*$gran_total;
						$freelancer_earning = $gran_total - $admin_commission;
						$currency_symbol = fl_framework_get_options('fl_currency');
						
						$logs_table = EXERTIO_SERVICE_LOGS_TBL;
						$log_data = array(
									'timestamp' => $current_datetime,
									'updated_on' =>$current_datetime,
									'service_id' => $sid,
									'purhcased_sid' => $service_id,
									'employer_id' => sanitize_text_field($buyer_id),
									'freelancer_id' => sanitize_text_field($seller_id),
									'service_currency' => sanitize_text_field($currency_symbol),
									'total_service_cost' => sanitize_text_field($gran_total),
									'addons_cost' => sanitize_text_field($total_addon_price),
									'admin_commission' => sanitize_text_field($admin_commission),
									'commission_percent' => sanitize_text_field($admin_commission_percent),
									'freelacner_earning' => sanitize_text_field($freelancer_earning),
									'status' => 'ongoing',
									);
						$wpdb->insert($logs_table,$log_data);
						$log_id = $wpdb->insert_id;
						
						if(empty($log_id))
						{
							$return = array('message' => esc_html__( 'Can not update service logs, please contact admin', 'exertio_framework' ));
							wp_send_json_error($return);
							exit;
						}
						else
						{
							/*NOTIFICATION*/
							do_action( 'exertio_notification_filter',array('post_id'=> $sid,'n_type'=>'service_purchased','sender_id'=>$current_user,'receiver_id'=>$post_author,'sender_type'=>'employer'));
							
							/*EMAIL ON ORDER RECEIVED*/
							if(fl_framework_get_options('fl_email_freelancer_service_receive') == true)
							{
								fl_service_purchased_freelancer_email($post_author,$sid,$gran_total);
							}
							if(fl_framework_get_options('fl_email_emp_order_created') == true)
							{
								fl_service_purchased_employer_email($current_user,$sid,$gran_total, $post_author );
							}
							$page_link= esc_url(home_url()) . '/dashboard/?ext=ongoing-services';
							$return = array('page'=>$page_link,'message' => esc_html__( 'Service purchased successfully', 'exertio_framework' ));
							wp_send_json_success($return);
						}
					}
					else
					{
						$return = array('message' => esc_html__( 'Error!!! could not purchase service.', 'exertio_framework' ));
						wp_send_json_error($return);	
					}
				}
			}
			else
			{
				$return = array('message' => esc_html__( 'Error!!! please contact Admin', 'exertio_framework' ));
				wp_send_json_error($return);	
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'You can not purchase your own service', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	}
}
add_action('wp_ajax_fl_calc_services_price', 'fl_calc_services_price');
add_action('wp_ajax_nopriv_fl_calc_services_price', 'fl_calc_services_price');
if ( ! function_exists( 'fl_calc_services_price' ) ) 
{
	function fl_calc_services_price()
	{
		global $exertio_theme_options;
		$service_price = $_POST['service_price'];

		$addon_price = $_POST['addon_price'];
		$calculation = $_POST['calc'];
		$sid = $_POST['service_id'];
		if(isset($service_price) && isset($addon_price) && isset($calculation))
		{
			if(isset($calculation)&& $calculation == 'plus')
			{
				$cal_price = $service_price + $addon_price;
			}
			else if(isset($calculation)&& $calculation == 'minus') 
			{
				$cal_price = $service_price - $addon_price;
			}

			$admin_commission = 0;
			if ( isset($exertio_theme_options[ 'service_charges_employer' ]) && $exertio_theme_options[ 'service_charges_employer' ] > 0 )
			{
				$service_price = get_post_meta($sid, '_service_price', true);
				$admin_commission_percent = fl_framework_get_options('service_charges_employer');
				$decimal_amount = $admin_commission_percent/100;
				$admin_commission = $decimal_amount*$service_price;
			}

			$updated_cal_pric = $cal_price + $admin_commission;

			$return = array('cal_data' =>  $cal_price,'cal_data_html' =>  fl_price_separator($updated_cal_pric, 'html'));
			wp_send_json_success($return);
		}
	}
}


add_action('wp_ajax_fl_calc_bid_price', 'fl_calc_bid_price');
add_action('wp_ajax_nopriv_fl_calc_bid_price', 'fl_calc_bid_price');
if ( ! function_exists( 'fl_calc_bid_price' ) ) 
{
	function fl_calc_bid_price()
	{
		$hourly_amount = $_POST['hourly_amount'];
		$bid_hours = $_POST['bid_hours'];
		$percentage = $_POST['percentage'];
		if(isset($percentage) && isset($bid_hours) && isset($hourly_amount))
		{
			$total_amount = (int)$bid_hours*(int)$hourly_amount;

			$admin_charges = ($total_amount/100)*$percentage;
			$earning = $total_amount- $admin_charges;

			$return = array('admin_charges' =>  fl_price_separator($admin_charges),'earning' =>  fl_price_separator($earning));
			wp_send_json_success($return);
		}

	}
}

add_action('wp_ajax_fl_calc_bid_price_fixed', 'fl_calc_bid_price_fixed');
add_action('wp_ajax_nopriv_fl_calc_bid_price_fixed', 'fl_calc_bid_price_fixed');
if ( ! function_exists( 'fl_calc_bid_price_fixed' ) ) 
{
	function fl_calc_bid_price_fixed()
	{
		$total_amount = $_POST['total_amount'];
		$percentage = $_POST['percentage'];
		if(isset($total_amount) && isset($percentage))
		{
			$admin_charges = ($total_amount/100)*$percentage;
			$earning = $total_amount- $admin_charges;

			$return = array('admin_charges' =>  fl_price_separator($admin_charges),'earning' =>  fl_price_separator($earning));
			wp_send_json_success($return);
		}
	}
}




/*GET SERVICE MESSAGES*/

if ( ! function_exists( 'get_service_msg' ) ) 
{
	function get_service_msg($sid)
	{
		global $wpdb;
		$table = EXERTIO_SERVICE_MSG_TBL;

		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `service_id` = '" . $sid . "' AND `status` ='1'";
			$result = $wpdb->get_results($query);
			if($result)
			{
				return $result;
			}
		}
	}
}

/*SERVICE HISTORY MESSAGE SAVE*/
add_action('wp_ajax_fl_send_service_msg', 'fl_send_service_msg');
if ( ! function_exists( 'fl_send_service_msg' ) ) 
{
	function fl_send_service_msg()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$current_user_id = get_current_user_id();
		$sid = $_POST['post_id'];
		$receiver_id = $_POST['receiver_id'];
		$sender_id = $_POST['sender_id'];

		$current_datetime = current_time('mysql');

		
		$current_active_user = get_user_meta($current_user_id, '_active_profile', true);
		
		
		parse_str($_POST['fl_data'], $params);
		
		if($params['history_msg_text'] != '')
		{
			global $wpdb;
			
			$table = EXERTIO_SERVICE_MSG_TBL;
			$data = array(
						'timestamp' => $current_datetime,
						'updated_on' =>$current_datetime,
						'service_id' => $sid,
						'message' => sanitize_text_field($params['history_msg_text']),
						'msg_sender_id' =>sanitize_text_field( $sender_id),
						'attachment_ids' => sanitize_text_field($params['attachment_ids']),
						'msg_receiver_id' => sanitize_text_field($receiver_id),
						'status' => '1',
						);
	
			$wpdb->insert($table,$data);
			$msg_id = $wpdb->insert_id;
			if($msg_id)
			{
				$current_active_user = get_user_meta($current_user_id, '_active_profile', true);
				if($current_active_user == 1)
				{
					$sender_type = 'employer';
					$n_receiver_id = get_post_field( 'post_author', $receiver_id);
				}
				else if($current_active_user == 2)
				{
					$sender_type = 'freelancer';
					$n_receiver_id = get_post_field( 'post_author', $receiver_id); 
				}
				/*NOTIFICATION*/
				do_action( 'exertio_notification_filter',array('post_id'=> $sid,'n_type'=>'service_msg','sender_id'=>$current_user_id,'receiver_id'=>$n_receiver_id,'sender_type'=>$sender_type) );
				
				$return = array('message' => esc_html__( 'Message sent', 'exertio_framework' ));
				wp_send_json_success($return);
			}
			else
			{
				$return = array('message' => esc_html__( 'Error!!! Message sending failed.', 'exertio_framework' ));
				wp_send_json_error($return);	
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'Message field can not be empty', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	}
}
/*SERVICE RATING SAVE*/
add_action('wp_ajax_fl_service_rating', 'fl_service_rating');
if ( ! function_exists( 'fl_service_rating' ) ) 
{
	function fl_service_rating()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		check_ajax_referer( 'fl_gen_secure', 'security' );
		global $exertio_theme_options;
		global $wpdb;
		$table =  EXERTIO_PURCHASED_SERVICES_TBL;
		$ongoing_sid = $_POST['ongoing_sid'];
		$service_sid = $_POST['service_sid'];
		$post_author_id = get_post_field( 'post_author', $service_sid );
		
		$current_user_id = get_current_user_id();
		$employer_id = get_user_meta( $current_user_id, 'employer_id' , true );
		$status = $_POST['status'];
		
		
		if($status == 'complete')
		{
			parse_str($_POST['rating_data'], $params);
			if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
			{
				$query = "SELECT * FROM ".$table." WHERE `id` = '" . $ongoing_sid . "' AND `status` ='ongoing' LIMIT 1";
				$result = $wpdb->get_results($query, ARRAY_A);

				if($result[0]['buyer_id'] == $employer_id)
				{
					$current_datetime = current_time('mysql');
					$data = array(
								'status_date' => $current_datetime,
								'status' => 'completed',
								);
					$where = array(
								'id' => $ongoing_sid,
								);
					$update_id = $wpdb->update( $table, $data, $where );
					if($update_id)
					{
						$star1 = sanitize_text_field($params['stars_1']);
						$star2 = sanitize_text_field($params['stars_2']);
						$star3 = sanitize_text_field($params['stars_3']);
						
						$single_avg = 0;
						$total_stars = $star1 + $star2 + $star3;
						$single_avg = round($total_stars / "3", 1);
						
						$table_1 = EXERTIO_REVIEWS_TBL;
						$data = array(
									'timestamp' => $current_datetime,
									'updated_on' =>$current_datetime,
									'project_id' => sanitize_text_field($result[0]['service_id']),
									'feedback' => sanitize_text_field($params['feedback_text']),
									'star_1' => $star1,
									'star_2' => $star2,
									'star_3' => $star3,
									'star_avg' => $single_avg,
									'receiver_id' => sanitize_text_field($result[0]['seller_id']),
									'giver_id' => sanitize_text_field($employer_id),
									'type' => 'service',
									'status' => '1',
									);
						$wpdb->insert($table_1,$data);
						
						$review_id = $wpdb->insert_id;
						if($review_id)
						{
							$log_table = EXERTIO_SERVICE_LOGS_TBL;
							if($wpdb->get_var("SHOW TABLES LIKE '$log_table'") == $log_table)
							{
								$log_query = "SELECT `freelacner_earning` , `freelancer_id`, `admin_commission`, `id` FROM ".$log_table." WHERE `purhcased_sid` = '" . $ongoing_sid . "' ";
								$log_result = $wpdb->get_results($log_query);
								
								
								$log_id = $log_result[0]->id;
								$earned_amount = $log_result[0]->freelacner_earning;
								$freelancer_id = $log_result[0]->freelancer_id;
								$admin_commission = $log_result[0]->admin_commission;
								$freelancer_user_id = get_post_field( 'post_author', $freelancer_id );
								
								/*WALLET REMOVE FUNCTION*/
								$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
								if(isset($is_wallet_active) && $is_wallet_active == 0)
								{
									$ex_amount = get_user_meta( $freelancer_user_id, '_fl_wallet_amount', true );
									if($ex_amount == '')
									{
										$ex_amount =0;
									}
									$new_wallet_amount = $ex_amount + $earned_amount;

									update_user_meta($freelancer_user_id, '_fl_wallet_amount',$new_wallet_amount);
									
									/*STATEMENT HOOK*/
									do_action( 'exertio_transection_action',array('post_id'=> $ongoing_sid,'price'=>$earned_amount,'t_type'=>'service_completed','t_status'=>'1', 'user_id'=> $freelancer_user_id));
									
									if($admin_commission > 0)
									{
										do_action( 'exertio_transection_action',array('post_id'=> $ongoing_sid,'price'=>$admin_commission,'t_type'=>'service_comp_comm_freelancer','t_status'=>'2', 'user_id'=> $freelancer_user_id));
									}
								}

								
								$log_data = array(
									'status' => 'complete',
									);
								$where = array(
											'id' => $log_id,
											);
											
								$log_update_id = $wpdb->update( $log_table, $log_data, $where );
								
								if($log_update_id)
								{
									$redirect_page = get_the_permalink($exertio_theme_options['user_dashboard_page']).'?ext=completed-service-detail&sid='.$ongoing_sid;
									
									/*NOTIFICATION*/
									do_action( 'exertio_notification_filter',array('post_id'=> $service_sid,'n_type'=>'service_completed','sender_id'=>$current_user_id,'receiver_id'=>$post_author_id,'sender_type'=>'employer') );
									
									/*EMAIL ON PROPOSAL SENT*/
									if(fl_framework_get_options('fl_email_freelancer_complete_service') == true)
									{
										fl_service_completed_freelancer_email($post_author_id,$service_sid);
									}
									if(fl_framework_get_options('fl_email_emp_complete_order') == true)
									{
										fl_service_completed_employer_email($current_user_id,$service_sid);
									}
									$return = array('message' => esc_html__( 'Marked as completed', 'exertio_framework' ), 'page' => $redirect_page);
									wp_send_json_success($return);
								}
								else
								{
									$return = array('message' => esc_html__('Error in saving service logs','exertio_framework'));
									wp_send_json_error($return);
								}
	
							}
						}
						else
						{
							$return = array('message' => esc_html__('Error in saving service review','exertio_framework'));
							wp_send_json_error($return);
						}
						
					}
					else
					{
						$return = array('message' => esc_html__('Error in updating service status','exertio_framework'));
						wp_send_json_error($return);
					}
					
				}
				else
				{
					$return = array('message' => esc_html__('You are not allowed to do that','exertio_framework'));
					wp_send_json_error($return);
				}
			}
		}
		else if($status == 'cancel')
		{
			parse_str($_POST['cancel_feedback'], $params);
			if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
			{
				$current_user_id = get_current_user_id();
				$query = "SELECT * FROM ".$table." WHERE `id` = '" . $ongoing_sid . "' AND `status` ='ongoing' LIMIT 1";
				$result = $wpdb->get_results($query, ARRAY_A);
				if($result[0]['buyer_id'] == $employer_id)
				{
					$current_datetime = current_time('mysql');
					$data = array(
								'status_date' => $current_datetime,
								'status' => sanitize_text_field('canceled'),
								'remarks' => sanitize_text_field($params['feedback_text'])
								);
					$where = array(
								'id' => $ongoing_sid,
								);
								
					$update_id = $wpdb->update( $table, $data, $where );
					if($update_id)
					{
						/*NOTIFICATION*/
						do_action( 'exertio_notification_filter',array('post_id'=> $service_sid,'n_type'=>'service_canceled','sender_id'=>$current_user_id,'receiver_id'=>$post_author_id,'sender_type'=>'employer') );
						
						$redirect_page = get_the_permalink($exertio_theme_options['user_dashboard_page']).'?ext=canceled-service-detail&sid='.$ongoing_sid;
						
						/*EMAIL ON PROPOSAL SENT*/
						if(fl_framework_get_options('fl_email_freelancer_cancel_order') == true)
						{
							fl_service_canceled_freelancer_email($post_author_id,$service_sid);
						}
						if(fl_framework_get_options('fl_email_emp_cancel_order') == true)
						{
							fl_service_canceled_employer_email($current_user_id,$service_sid);
						}
						$return = array('message' => esc_html__( 'Marked as canceled', 'exertio_framework' ), 'page' => $redirect_page);
						wp_send_json_success($return);	
					}
					else
					{
						$return = array('message' => esc_html__('Error in updating service status','exertio_framework'));
						wp_send_json_error($return);	
					}
				}
				else
				{
					$return = array('message' => esc_html__('You are not allowed to do that','exertio_framework'));
					wp_send_json_error($return);
				}
			}
		}
	}
}
/*GET SERVICE RATING*/
if ( ! function_exists( 'get_service_rating' ) ) 
{
	function get_service_rating($sid)
	{
		global $wpdb;
		$table = EXERTIO_REVIEWS_TBL;;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $sid . "' AND `type` ='service' AND  `status` ='1'";
			$results = $wpdb->get_results($query);
			if($results)
			{
				$count_reviews = count($results);
				foreach($results as $result)
				{
					$result->star_avg;	
					$avg_array[] = $result->star_avg;
				}
				$total_sum = array_sum($avg_array);

                $total_avg = round($total_sum / $count_reviews, 2);
				return $total_avg.' ( '.$count_reviews.esc_html__( ' reviews', 'exertio_framework' ).' )';
			}
			else
			{
				return esc_html__( 'No Reviews', 'exertio_framework' );	
			}
		}
	}
}
/*GET SERVICE RATING*/
if ( ! function_exists( 'get_service_rating_detail' ) ) 
{
	function get_service_rating_detail($sid)
	{
		global $wpdb;
		$table = EXERTIO_REVIEWS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `project_id` = '" . $sid . "' AND `type` ='service' AND  `status` ='1'";
			$results = $wpdb->get_results($query);
			if($results)
			{
				return $results;
			}
		}
	}
}

/*GET FREELANCER RATING*/
if ( ! function_exists( 'get_freelancer_rating' ) ) 
{
	function get_freelancer_rating($fid, $stars= '', $rating_type = '')
	{
		global $wpdb;
		$table = EXERTIO_REVIEWS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $fid . "' AND `type` ='".$rating_type."' AND  `status` ='1'";
			$results = $wpdb->get_results($query);
			if($results)
			{
				$count_reviews = count($results);
				$reviews_text = esc_html__( ' review', 'exertio_framework' );
				if($count_reviews > 1)
				{
					$reviews_text = esc_html__( ' reviews', 'exertio_framework' );
				}
				foreach($results as $result)
				{
					$result->star_avg;	
					$avg_array[] = $result->star_avg;
				}
				$total_sum = array_sum($avg_array);
                $total_avg = round($total_sum / $count_reviews, 1);

				$whole = floor($total_avg); 
				$fraction = $total_avg - $whole; 
				$half_count = '1';

				if($stars == 'stars')
				{
					$stars_html = '';
					for ($i = 1; $i <= 5; $i++) {
						if ($i <= $total_avg)
						{
							$stars_html .= '<i class="fas fa-star colored"></i>';
						}
						else
						{
							if($fraction >= 0.50 && $half_count <= '1')
							{
								$half_count++;
								$stars_html .= ' <i class="fas fa-star-half-alt colored"></i>';
							}
							else
							{
								$stars_html .= '<i class="far fa-star colored"></i>';
							}
						}
					}
					return $stars_html.' '.number_format($total_avg,1).' ( '.$count_reviews.$reviews_text.' )';
				}
				else
				{
					$stars_html ='<i class="fas fa-star colored"></i>';
					return $stars_html.' '.number_format($total_avg,1).' ( '.$count_reviews.$reviews_text.' )';
				}
			}
			else
			{
				return esc_html__( 'No Reviews', 'exertio_framework' );	
			}
		}
	}
}

/*GET SERVICE RATING*/
if ( ! function_exists( 'get_freelancer_rating_detail' ) ) 
{
	function get_freelancer_rating_detail($sid, $rating_type = '')
	{
		global $wpdb;
		$table = EXERTIO_REVIEWS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `receiver_id` = '" . $sid . "' AND `type` ='".$rating_type."' AND `status` ='1'";
			$results = $wpdb->get_results($query);
			if($results)
			{
				return $results;
			}
		}
	}
}
/*GET IN QUEUE SERVICES BY ID*/

if ( ! function_exists( 'exertio_queued_services' ) ) 
{
	function exertio_queued_services($sid)
	{
		global $wpdb;
		$table =  EXERTIO_PURCHASED_SERVICES_TBL;

		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `service_id` = '" . $sid . "' AND `status` ='ongoing'";

			$result = count($wpdb->get_results($query));
			if($result > 1)
			{
				return $result.esc_html__(' Orders in queue','exertio_framework');	
			}
			else
			{
				return $result.esc_html__(' Order in queue','exertio_framework');
			}
			
			
		}
	}
}

/*GET ACTIVE PROJECTS*/

if ( ! function_exists( 'exertio_get_all_projects' ) ) 
{
	function exertio_get_all_projects($uid, $status='', $limit = '')
	{
		$the_query = new WP_Query( 
									array( 
											'author__in' => array( $uid ) ,
											'post_type' =>'projects',
											'posts_per_page' => $limit,
											//'paged' => $paged,	
											'post_status'     => $status,
											'orderby' => 'date',
											'order'   => 'DESC',
											)
										);
		return $the_query;
	}
}
add_action('wp_ajax_fl_get_paged_projects', 'fl_get_paged_projects');
add_action('wp_ajax_nopriv_fl_get_paged_projects', 'fl_get_paged_projects');
if ( ! function_exists( 'fl_get_paged_projects' ) ) 
{
	function fl_get_paged_projects()
	{
		global $exertio_theme_options;
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$limit = $exertio_theme_options['employers_posted_project_limit'];
		$pageno = $_POST['pageno'];
		$author = $_POST['author'];
		$the_query = new WP_Query( 
									array( 
											'author__in' => array( $author ) ,
											'post_type' =>'projects',
											'meta_query' => array(
												),
											'paged' => $pageno,	
											'post_status'     => array('publish', 'ongoing')	,
											'posts_per_page' => $limit,
											'orderby' => 'date',
											'order'   => 'DESC',												
											)
										);
		$total_posts = $the_query->found_posts;
		if($the_query->have_posts())
		{
			$html ='';
			while ( $the_query->have_posts() ) 
			{
				$the_query->the_post();
				$pid = get_the_ID();
				$post_author = get_post_field( 'post_author', $pid );

				$emp_id = get_user_meta( $post_author, 'employer_id' , true );
				
				$project_type = get_post_meta($pid, '_project_type', true);
				if($project_type == 'fixed' || $project_type == 1)
				{ 
					$project_price = fl_price_separator(get_post_meta($pid, '_project_cost', true));
				}
				else if($project_type == 'hourly' || $project_type == 2)
				{
					$project_price = fl_price_separator(get_post_meta($pid, '_project_cost', true));
				}
				if($project_type == 'hourly' || $project_type == 2)
				{
					$price = get_post_meta($pid, '_project_cost', true);
					$hours = get_post_meta($pid, '_estimated_hours', true);
					
					$type = '<p class="price_type protip" data-pt-title="'.__('For ','exertio_framework').$hours.__(' hours total will be  ','exertio_framework'). fl_price_separator($hours*$price).'" data-pt-position="top" data-pt-scheme="black">'.esc_html__( 'Hourly', 'exertio_theme' ).' <i class="far fa-question-circle"></i></p>';
				}
				else if($project_type == 'fixed' || $project_type == 1)
				{
					$type = '<p class="price_type ">'.esc_html__( 'Fixed', 'exertio_theme' ).'</p>';
				}
				
				
				$saved_skills = wp_get_post_terms($pid, 'skills', array( 'fields' => 'all' ));
				$skill_count = 1;
				$skill_hide = '';

				foreach($saved_skills as $saved_skill)
				{
					if($skill_count > 4)
					{ 
						$skill_hide = 'hide';
					}
					$skilles .= '<li class="'.esc_html($skill_hide).'"><a href="'.esc_url(get_term_link($saved_skill->term_id)).'">'.esc_html($saved_skill->name).'</a></li>';
				  $skill_count++;
				}
				
				if($skill_hide != '')
				{
					$skilles .= '<li class="show-skills"><a href="javascript:void(0)"><i class="fas fa-ellipsis-h"></i></a></li>';
				}
				
				$project_duration = get_term( get_post_meta($pid, '_project_duration', true));
				$project_level = get_term( get_post_meta($pid, '_project_level', true));
				
				$saved = '';
				$meta_key = '_pro_fav_id_'.$pid;
				$saved_project = get_user_meta(get_current_user_id(),$meta_key,true);
				if($saved_project)
				{
					$saved = 'saved';
				}
                $html .= '<div class="fr-right-detail-box 11">
                  <div class="fr-right-detail-content">
                    <div class="fr-right-details-products">
                      <div class="features-star"><i class="fa fa-star"></i></div>
                      <div class="fr-jobs-price">
                         <div class="style-hd">'.$project_price.'</div>
                          '.$type.'
                      </div>
                      <div class="fr-right-details2">
                        <a href="'.esc_url(get_permalink()).'">
                            <h3>'.esc_html(get_the_title()).'</h3>
                        </a>
                      </div>
                      <div class="fr-right-product">
                        <ul class="skills">
                            '.$skilles.'
                        </ul>
                      </div>
                      <div class="fr-right-index">
                        <p>'.exertio_get_excerpt(25, $pid).'</p>
                      </div>
                    </div>
                  </div>
                  <div class="fr-right-information">
                    <div class="fr-right-list">
                      <ul>
                        <li>
                          <p class="heading">'.esc_html__('Duration: ','exertio_framework').'</p>
                          <span>'.esc_html($project_duration->name).'</span>
                        </li>
                        <li>
                          <p class="heading">'.esc_html__('Level: ','exertio_framework').'</p>
                          <span>'.esc_html($project_level->name).' </span>
                        </li>
                        <li>
                          <p class="heading">'.esc_html__('Location: ','exertio_framework').'</p>
                          <span>'.get_term_names('locations', '_project_location', $pid,'', ',' ).'</span>
                        </li>
                      </ul>
                    </div>
                    <div class="fr-right-bid">
                      <ul>
                        <li> <a href="javascript:void(0)" class="mark_fav '.esc_html($saved).'" data-post-id="'.esc_attr($pid).'"><i class="fa fa-heart active"></i></a> </li>
                        <li><a href="'.esc_url(get_permalink()).'" class="btn btn-theme">'.esc_html__('View Detail','exertio_framework').'</a></li>
                      </ul>
                    </div>
                  </div>
                </div>';
             $skilles ='';   
			}
			
			/*$html .= fl_pagination($the_query);
			print_r($html);*/
			
			$limit = $exertio_theme_options['employers_posted_project_limit'];
			$total_pages = ceil($total_posts/$limit);
			
			if($total_pages> 1 )
			{
				$page_end_limit = $pageno + 2; 
				$page_start_limit = $pageno - 2;
				if($page_start_limit <= 0 )
				{
					$page_start_limit = 1;
				}
				$pagination = $pagination_li = '';
				for($i=$page_start_limit; $i<=$total_pages; $i++)
				{
					$active_pagination ='';
					if($i == $pageno)
					{
						$active_pagination ='active';	
					}
					$pagination_li .= '<li class="'.esc_attr($active_pagination).' emp_pro_pagination" data-page-number="'.esc_attr($i).'" data-post-author ="'.esc_attr($post_author).'">
						<a href="javascript:void(0)">'.esc_html($i).'</a>
					</li>';
					if($i >= $page_end_limit)
					{
						$pagination_li .= '<li class="emp_pro_pagination">
						<a href="javascript:void(0)">..</a>
					</li>';
						break;
					}
				}
				$pagination .= '<div class="fl-navigation">
					<ul>'.$pagination_li.
					'</ul>
				</div>';
			}
			
		}
		$return = array('html' => $html, 'pagination' => $pagination);
		wp_send_json_success($return);
		die;
	}
}
// FOLLOW EMPLOYERS
add_action('wp_ajax_fl_follow_employer', 'fl_follow_employer');
add_action('wp_ajax_nopriv_fl_follow_employer', 'fl_follow_employer');
if ( ! function_exists( 'fl_follow_employer' ) ) { 
	function fl_follow_employer()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		exertio_check_register_user_type(2);
		$emp_id		=	$_POST['emp_id'];
		if($emp_id != '')
		{

			if( get_user_meta( get_current_user_id(), '_emp_follow_id_'.$emp_id, true ) == $emp_id )
			{
				$return = array('message' => esc_html__( 'You are already following', 'exertio_framework' ));
				wp_send_json_error($return);
			}
			else
			{
				update_user_meta( get_current_user_id(), '_emp_follow_id_' . $emp_id, $emp_id );
				
				$return = array('message' => esc_html__( 'Added to your following list', 'exertio_framework' ));
				wp_send_json_success($return);
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'ID error', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	
		
		die();
	}
}
// REMOVE FOLLOW EMPLOYERS
add_action('wp_ajax_fl_delete_followed_employer', 'fl_delete_followed_employer');
if ( ! function_exists( 'fl_delete_followed_employer' ) )
{ 
	function fl_delete_followed_employer()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		$pid		=	$_POST['post_id'];
		if ( delete_user_meta(get_current_user_id(), '_emp_follow_id_'.$pid) )
		{
			$return = array('message' => esc_html__( 'Removed from following list', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else
		{
			$return = array('message' => esc_html__( 'There is some problem, please try again later', 'exertio_framework' ));
			wp_send_json_error($return);
		}
	}
}
// FOLLOW EMPLOYERS
add_action('wp_ajax_fl_follow_freelancer', 'fl_follow_freelancer');
add_action('wp_ajax_nopriv_fl_follow_freelancer', 'fl_follow_freelancer');
if ( ! function_exists( 'fl_follow_freelancer' ) ) { 
	function fl_follow_freelancer()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		exertio_check_register_user_type(1);
		$fid		=	$_POST['fid'];
		if($fid != '')
		{
			if( get_user_meta( get_current_user_id(), '_fl_follow_id_'.$fid, true ) == $fid )
			{
				$return = array('message' => esc_html__( 'You are already following', 'exertio_framework' ));
				wp_send_json_error($return);
			}
			else
			{
				update_user_meta( get_current_user_id(), '_fl_follow_id_' . $fid, $fid );
				
				$return = array('message' => esc_html__( 'Added to your following list', 'exertio_framework' ));
				wp_send_json_success($return);
			}
		}
		else
		{
			$return = array('message' => esc_html__( 'ID error', 'exertio_framework' ));
			wp_send_json_error($return);	
		}
	
		
		die();
	}
}
// REMOVE FOLLOW FREELANCER
add_action('wp_ajax_fl_delete_followed_freelancer', 'fl_delete_followed_freelancer');
if ( ! function_exists( 'fl_delete_followed_freelancer' ) )
{ 
	function fl_delete_followed_freelancer()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		fl_authenticate_check();
		$pid		=	$_POST['post_id'];
		if ( delete_user_meta(get_current_user_id(), '_fl_follow_id_'.$pid) )
		{
			$return = array('message' => esc_html__( 'Removed from following list', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else
		{
			$return = array('message' => esc_html__( 'There is some problem, please try again later', 'exertio_framework' ));
			wp_send_json_error($return);
		}
	}
}
/*GET EMPLOYER FOLLOWERS*/

if ( ! function_exists( 'get_employer_followers' ) ) 
{
	function get_employer_followers($pid)
	{
		global $wpdb;
		$rows = $wpdb->get_results( "SELECT meta_value FROM $wpdb->usermeta WHERE meta_key LIKE '_emp_follow_id_$pid'" );
		return count($rows);
	}
}

if (!function_exists('exertio_getCatID'))
{

	function exertio_getCatID() {
		return esc_html(get_cat_id(single_cat_title("", false)));
	}

}


if ( ! function_exists( 'exertio_save_freelancer_options' ) )
{ 
	function exertio_save_freelancer_options( $update_key = '', $update_value = '')
	{
		if($update_key == "") return;
		$current_user_id = get_current_user_id();
		$value = get_user_meta( $current_user_id, '_freelancer_settings', true );
		$value = ( json_decode($value, true));
		$data = array();
		if( isset($value))
		{
			foreach($value as $key => $val)
			{
				if($key == $update_key)
				{
					$data[$key] = $update_value;
				}
				else
				{
					$data[$key] = $val;
				}
			}
			if(!in_array($update_key, $value))
			{
			 $data[$update_key] = $update_value;
			}
		}
		else
		{
			$data[$update_key] = $update_value;
		}
		update_user_meta( $current_user_id, '_freelancer_settings', json_encode($data) );
	}
}
//FREELANCER SAVE SETTINGS
add_action('wp_ajax_exertio_save_freelancer_settings', 'exertio_save_freelancer_settings');
if ( ! function_exists( 'exertio_save_freelancer_settings' ) )
{ 
	function exertio_save_freelancer_settings()
	{
		/*DEMO DISABLED*/
		exertio_demo_disable('json');
		
		$current_user_id = get_current_user_id();
		parse_str($_POST['settings_data'], $params);

		if(isset($params['enable_payout']) && $params['enable_payout'] != '' )
		{
			$enable_payout = 1;
		}
		else
		{
			$enable_payout = 0;
		}

		$settings[] = array(
					"_enable_payout" => $enable_payout,
				);
		$encoded_settings =  json_encode($settings, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
		update_user_meta( $current_user_id, '_freelancer_settings', $encoded_settings );

		$return = array('message' => esc_html__( 'Settings saved', 'exertio_framework' ));
		wp_send_json_success($return);

	}
}
add_action('wp_ajax_exertio_user_selection', 'exertio_user_selection');
if ( ! function_exists( 'exertio_user_selection' ) )
{ 
	function exertio_user_selection()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$uid = get_current_user_id();
		$user_info = get_userdata($uid);
		parse_str($_POST['user_selection_data'], $params);
		//print_r($params);
		if(isset($params['exertio_user_type']) && $params['exertio_user_type'] == 'employer' )
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
			update_user_meta($uid, '_active_profile', 1);
			$return = array('message' => esc_html__( 'User selection saved', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else if(isset($params['exertio_user_type']) && $params['exertio_user_type'] == 'freelancer' )
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
			update_user_meta($uid, '_active_profile', 2);
			$return = array('message' => esc_html__( 'User selection saved', 'exertio_framework' ));
			wp_send_json_success($return);
		}
	}
}
add_action('wp_ajax_exertio_user_switch', 'exertio_user_switch');
if ( ! function_exists( 'exertio_user_switch' ) )
{ 
	function exertio_user_switch()
	{
		$uid = get_current_user_id();
		update_user_meta($uid, '_active_profile', 1);
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$uid = get_current_user_id();
		$active_profile = $_POST['active_profile'];
		if(isset($active_profile) && $active_profile == 'employer' )
		{
			update_user_meta($uid, '_active_profile', 1);
			$return = array('message' => esc_html__( 'User selection saved', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else if(isset($active_profile) && $active_profile == 'freelancer' )
		{
			update_user_meta($uid, '_active_profile', 2);
			$return = array('message' => esc_html__( 'User selection saved', 'exertio_framework' ));
			wp_send_json_success($return);
		}		
	}
}
/*FOR THE BOTH ACCOUNTS TO SELECTED ACCOUNTS CONVERSION*/
add_action('wp_ajax_exertio_previous_user', 'exertio_previous_user');
if ( ! function_exists( 'exertio_previous_user' ) )
{ 
	function exertio_previous_user()
	{
		check_ajax_referer( 'fl_gen_secure', 'security' );
		$uid = get_current_user_id();
		parse_str($_POST['user_selection_data'], $params);
		
		if(isset($params['exertio_user_type']) && $params['exertio_user_type'] == 'employer' )
		{
			update_user_meta($uid, '_active_profile', 1);
			update_user_meta($uid, 'freelancer_id', '');
			$return = array('message' => esc_html__( 'User selection saved', 'exertio_framework' ));
			wp_send_json_success($return);
		}
		else if(isset($params['exertio_user_type']) && $params['exertio_user_type'] == 'freelancer' )
		{
			update_user_meta($uid, '_active_profile', 2);
			update_user_meta($uid, 'employer_id', '');
			$return = array('message' => esc_html__( 'User selection saved', 'exertio_framework' ));
			wp_send_json_success($return);
		}
	}
}
add_action('wp_ajax_whizzchat_notloggedin', 'whizzchat_notloggedin');
add_action('wp_ajax_nopriv_whizzchat_notloggedin', 'whizzchat_notloggedin');
if ( ! function_exists( 'whizzchat_notloggedin' ) )
{ 
	function whizzchat_notloggedin()
	{
		$return = array('message' => esc_html__( 'Please login first', 'exertio_framework' ));
		wp_send_json_error($return);
	}
}