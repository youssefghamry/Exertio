<?php
function exertio_completed_services()
{
	add_submenu_page(
		 'edit.php?post_type=services',
		__( 'Complete Services', 'exertio_framework' ),
		__( 'Complete Services', 'exertio_framework' ),
		'manage_options',
		'completed-services',
		'exertio_completed_services_contents',
		28
	);
}

add_action( 'admin_menu', 'exertio_completed_services' );
function exertio_completed_services_contents()
{
	$limit = get_option( 'posts_per_page' );
	$start_from ='1';
	if (isset($_GET["pageno"])) 
	{  
	  $pageno  = $_GET["pageno"];  
	}  
	else {  
	  $pageno=1;  
	}
	$start_from = ($pageno-1) * $limit;

	?>
	<h1> <?php esc_html_e( 'Completed Service', 'exertio_framework' ); ?> </h1>
	<table class="wp-ongoing-services wp-list-table widefat fixed striped table-view-list pages">
		<thead>
			<tr>
				<th><?php esc_html_e( 'Sr#', 'exertio_framework' ); ?></th>
				<th><?php esc_html_e( 'Title', 'exertio_framework' ); ?></th>
				<th><?php esc_html_e( 'Service Owner', 'exertio_framework' ); ?></th>
				<th><?php esc_html_e( 'Service Buyer', 'exertio_framework' ); ?></th>
				<th><?php esc_html_e( 'Service Price', 'exertio_framework' ); ?></th>
				<th><?php esc_html_e( 'Purchased Date', 'exertio_framework' ); ?></th>
				<th><?php esc_html_e( 'Completed Date', 'exertio_framework' ); ?></th>
				<th><?php esc_html_e( 'Delivery Time', 'exertio_framework' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			global $wpdb;
			$table = EXERTIO_PURCHASED_SERVICES_TBL;
			if($wpdb->get_var("SHOW TABLES LIKE '$table'") == $table)
			{
				$query = "SELECT * FROM ".$table." WHERE `status` ='completed' ORDER BY timestamp DESC LIMIT ".$start_from.",".$limit."";
				$result = $wpdb->get_results($query);
			}
			$count = 1;
			foreach($result as $res)
			{
				$d_time = '';
				$delivery_time = get_term( get_post_meta($res->service_id, '_delivery_time', true));
				if(!empty($delivery_time) && ! is_wp_error($delivery_time))
				{
					$d_time = $delivery_time->name;
				}
				?>
				<tr>
					<td><?php echo esc_html($count); ?></td>
					<td><?php echo '<a href="'.get_the_permalink($res->service_id).'"" target="_blank">'.get_the_title($res->service_id).'</a>' ?></td>
					<td><?php echo '<a href="'.get_the_permalink($res->seller_id).'"" target="_blank">'.exertio_get_username('freelancer',$res->seller_id).'</a>'; ?></td>
					<td><?php echo '<a href="'.get_the_permalink($res->buyer_id).'" target="_blank">'.exertio_get_username('employer',$res->buyer_id).'</a>'; ?></td>
					<td><?php echo esc_html(fl_price_separator($res->total_price)); ?></td>
					<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( esc_html($res->timestamp))); ?></td>
					<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( esc_html($res->status_date))); ?></td>
					<td><?php echo esc_html($d_time); ?></td>
				</tr>
				<?php
				$count++;
			}
			?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?php echo pagination_ongoing_services_admin($pageno, $limit, 'completed'); ?></td>
			</tr>
		</tbody>
	</table>
	<?php
}

if ( ! function_exists( 'pagination_ongoing_services_admin' ) )
{
    function pagination_ongoing_services_admin( $paged = '', $max_posts = '5', $page_type = 'completed' )
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
			$query = "SELECT * FROM ".$table." WHERE  `status` ='".$page_type."'";
			$result = $wpdb->get_results($query);
		}
		$total_rows = count($result);
		
        $total_pages = ceil($total_rows / $no_of_records_per_page);

		$pagLink ='';
		$pagLink .= '<div class="fl-navigation"><ul>';
		if($pageno != 1)
		{
			$pagLink .= "<li><a href='?post_type=services&page=completed-services&pageno&pageno=1'> ".__( 'First', 'exertio_framework' )."</a></li>";
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
					$pagLink .= "<li><a href='?post_type=services&page=completed-services&pageno=".$i."'> ".$i."</a></li>"; 
				}
			}
		}
		if($pageno != $total_pages)
		{
			$pagLink .= "<li><a href='?post_type=services&page=completed-services&pageno=".$total_pages."'> ".__( 'Last', 'exertio_framework' )."</a></li>";
		}
		$pagLink .= '</ul></div>';
		
		return $pagLink;
		
		?>
<?php
    }
}