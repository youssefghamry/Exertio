<?php
function exertio_store_transections_callback( $arg_array = array() ) {
	global $exertio_theme_options;
	if(isset($exertio_theme_options['exertio_statements']) && $exertio_theme_options['exertio_statements'] == true)
	{
		global $wpdb;
		$table = EXERTIO_STATEMENTS_TBL;
		$current_time = current_time('mysql');
		$data = array(
				'timestamp' => $current_time,
				'post_id' => $arg_array['post_id'],
				'price' => $arg_array['price'],
				't_type' => $arg_array['t_type'],
				't_status' => $arg_array['t_status'],
				'user_id' => $arg_array['user_id'],
				'status' => 1,
				);
		$wpdb->insert($table,$data);
	}
}
add_action( 'exertio_transection_action', 'exertio_store_transections_callback', 10 );




if ( ! function_exists( 'exertio_view_all_statements' ) )
{ 
	function exertio_view_all_statements($start_from = 0, $limit = 10)
	{
		$uid = get_current_user_id();
		global $wpdb;
		$table = EXERTIO_STATEMENTS_TBL;
		
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$count = 0;
			$query = "SELECT * FROM ".$table." WHERE `user_id` = '" . $uid . "' ORDER BY  `timestamp` DESC LIMIT ".$start_from.",".$limit."";
			$result = $wpdb->get_results($query);
			if($result)
			{
				$count = count($result);
				$result_html ='';
				
				foreach($result as $results)
				{
					$status_class = '';
					
					if($results->t_status == 1)
					{
						$status_class = __( '', 'exertio_framework' );
					}
					
					$t_type = $results->t_type;
					$t_status = $results->t_status;
					$transection_status = (isset($t_status) && $t_status == 1) ? 'credit': 'debit';
					$post_id = (isset($results->post_id))? $results->post_id : '';
					
					if($t_type == 'wallet_added')
					{
						$t_type_text = __( 'Wallet Topup', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Amount added in wallet', 'exertio_framework' ).'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_top_bid')
					{
						$t_type_text = __( 'Top Proposal', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Purchased a top proposal add-on on ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>'.'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_sealed_bid')
					{
						$t_type_text = __( 'Sealed Proposal', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Purchased a sealed proposal add-on on ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>'.'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_featured_bid')
					{
						$t_type_text = __( 'Featured Proposal', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Purchased a featured proposal add-on on ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>'.'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_assign')
					{
						$t_type_text = __( 'Project Assigned', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Escrow amount for the project ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_complete')
					{
						$t_type_text = __( 'Project Completed', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											<span>'.get_the_title($post_id).'</span>'.__( ' project completed', 'exertio_framework' ).'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'service_purchase')
					{
						$t_type_text = __( 'Service Purchased', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Purchase service ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'service_admin_commission')
					{
						$t_type_text = __( 'Service Admin fee', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Admin fee for ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'service_completed')
					{
						$t_type_text = __( 'Service Completed', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Service complete amount deposit ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'service_comp_comm_freelancer')
					{
						$t_type_text = __( 'Admin Fee', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Service complete admin charges ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_milestone')
					{
						$t_type_text = __( 'Milestone Released', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Milestone released on ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_milestone_comm')
					{
						$t_type_text = __( 'Admin Fee', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Admin fee for milestone released on  ', 'exertio_framework' ).'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'employer_package')
					{
						$t_type_text = __( 'Package Purchase', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Purchased a new employer package', 'exertio_framework' ).'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'freelancer_package')
					{
						$t_type_text = __( 'Package Purchase', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Purchased a new freelancer package', 'exertio_framework' ).'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'dispute_refund')
					{
						$t_type_text = __( 'Dispute Refund', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.__( 'Dispute amoung has been refunded', 'exertio_framework' ).'
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
					if($t_type == 'project_tip')
					{
						$status_text = (isset($t_status) && $t_status == 1) ? __( 'Received a reward or tip on ', 'exertio_framework' ): __( 'Paid a reward or tip on ', 'exertio_framework' );
						$t_type_text = __( 'Reward or Tip', 'exertio_framework' );
						
						$result_html .= '<div class="pro-box statement_page '.esc_attr($status_class).'">';
						$result_html .= '
										<div class="pro-coulmn">'.date_i18n( get_option( 'date_format' ), strtotime( $results->timestamp ) ).'</div>
										<div class="pro-coulmn"><span class="badge badge-secondary">'.$t_type_text.' </span></div>
										<div class="pro-coulmn pro-title">
											<a href="javascript:void(0)" class="">
											'.$status_text.'<span>'.get_the_title($post_id).'</span>
											</a>
										</div>
										<div class="pro-coulmn"> '.fl_price_separator($results->price).' </div>
										<div class="pro-coulmn '.$transection_status.'"> '.fl_price_separator($results->price).' </div>
										';
						$result_html .= '</div>';
					}
				}
				return $result_html;
			}
		}

	}
}
if ( ! function_exists( 'statement_pagination' ) )
{
    function statement_pagination( $paged = '', $max_posts = '5')
    {
		$uid = get_current_user_id();
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

		$table =  EXERTIO_STATEMENTS_TBL;
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
		{
			$query = "SELECT * FROM ".$table." WHERE `user_id` = '" . $uid . "' ORDER BY  `timestamp` DESC ";
			$result = $wpdb->get_results($query);
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?ext=statements&pageno=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
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
					$pagLink .= "<li><a href='?ext=statements&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?ext=statements&pageno=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;
    }
}