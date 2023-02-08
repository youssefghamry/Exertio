<?php
$alt_id = '';
if ( get_query_var( 'paged' ) )
{
  $paged = get_query_var( 'paged' );
}
else if ( get_query_var( 'page' ) )
{
  $paged = get_query_var( 'page' );
}
else
{
  $paged = 1;
}
$customer_orders1 = $customer_orders = array();
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))))
{
	$customer_orders1 = get_posts(apply_filters('woocommerce_my_account_my_orders_query', array(
		'numberposts' => -1,
		'meta_key' => '_customer_user',
		'meta_value' => get_current_user_id(),
		'post_type' => wc_get_order_types('view-orders'),
		'post_status' => 'all',
	)));
	$total_posts = count($customer_orders1);


	$posts_per_page = get_option('posts_per_page');
	$total_pages = ceil($total_posts / $posts_per_page);
	$customer_orders = get_posts(array(
		'meta_key' => '_customer_user',
		'meta_value' => get_current_user_id(),
		'post_type' => wc_get_order_types('view-orders'),
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
		'post_status' => 'all'
	));
}

$order_array = [];
    foreach ($customer_orders as $customer_order) 
	{
        $order = wc_get_order($customer_order);
		$order_items = $order->get_items();
		foreach ( $order_items as $item )
		{
			$product_name = $item->get_name();
			$product = wc_get_product( $item['product_id'] );
			$product_type = $product->get_type();
		}

			$product_name_text = '';
			if(isset($product_type) && $product_type == 'wallet')
			{
				$product_name_text = esc_html__( 'Wallet Amount', 'exertio_theme' );
			}
			else if(isset($product_type) && $product_type == 'employer-packages' || $product_type == 'freelancer-packages')
			{
				$product_name_text = $product_name;
			}
        $order_array[] = [
            "ID" => $order->get_id(),
            "price" => $order->get_total(),
			"product_name" => $product_name_text,
            "date" => $order->get_date_created()->date_i18n('Y-m-d'),
			"status" => $order->get_status(),
        ];
    }
$is_wallet_active = fl_framework_get_options('exertio_wallet_system');
if(isset($is_wallet_active) && $is_wallet_active == 0)
{
	$main_heading = esc_html__('Deposit and Invoices','exertio_theme');
}
else
{
	$main_heading = esc_html__('Invoices','exertio_theme');
}
?>
<div class="content-wrapper">
	<div class="notch"></div>
	<div class="row">
		<div class="col-md-12 grid-margin">
		  <div class="d-flex justify-content-between flex-wrap">
			<div class="d-flex align-items-end flex-wrap">
			  <div class="mr-md-3 mr-xl-5">
				<h2><?php echo esc_html($main_heading); ?></h2>
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
		<?php
			$full_col = 'col-xl-12 col-lg-12 col-md-12';
			
			if(isset($is_wallet_active) && $is_wallet_active == 0)
			{
				$full_col = 'col-xl-8 col-lg-12 col-md-12';
				?>
				<div class="col-xl-4 col-lg-12 col-md-12 grid-margin  stretch-card">
				<?php
				$page_link = '';
				$page_link = fl_framework_get_options('exertio_wallet_deposit');
				if(isset($page_link) && $page_link == 0)
				{
					get_template_part( 'template-parts/dashboard/invoices/deposit-funds');
				}
				else if(isset($page_link) && $page_link == 1)
				{
					get_template_part( 'template-parts/dashboard/invoices/deposit-funds-custom');
				}
						
					?>
				</div>
				<?php
			}
		?>
		
		<div class="<?php echo esc_attr($full_col); ?> grid-margin stretch-card">
			  <div class="card mb-4">
				<div class="card-body">
				  <div class="pro-section">
					  <div class="pro-box heading-row">
						<div class="pro-coulmn no-flex-grow"><?php echo esc_html__( 'Invoice ID', 'exertio_theme' ) ?> </div>
						<div class="pro-coulmn"><?php echo esc_html__( 'Amount', 'exertio_theme' ) ?> </div>
						<div class="pro-coulmn"><?php echo esc_html__( 'Payment Status', 'exertio_theme' ) ?> </div>
						<div class="pro-coulmn"><?php echo esc_html__( 'Detail', 'exertio_theme' ) ?> </div>
					  </div>
						<?php
							if ( !empty($order_array) )
							{
								foreach ( $order_array as $array ) 
								{

									?>
									  <div class="pro-box">
										<div class="pro-coulmn pro-title  no-flex-grow">
											<h4 class="pro-name"><a href="<?php get_template_part('');?>?ext=invoice-detail&invoice-id=<?php echo esc_attr($array['ID']); ?>"><?php echo esc_html($array['product_name']); ?></a></h4>
											<span class="date"><?php  echo esc_html(date_i18n( get_option( 'date_format' ), strtotime( $array['date'] ) )); ?></span>
										</div>
										<div class="pro-coulmn">
											<?php echo esc_html(fl_price_separator($array['price'])); ?>
										</div>
										<div class="pro-coulmn">
											<?php
											$badge_color ='';
											if( $array['status'] == 'completed') { $badge_color = 'btn-inverse-success'; $status_text = esc_html__( 'Completed', 'exertio_theme' );}
											else if($array['status'] == 'processing'){ $badge_color = 'btn-inverse-primary'; $status_text = esc_html__( 'Processing', 'exertio_theme' );}
											else if($array['status'] == 'pending'){ $badge_color = 'btn-inverse-warning'; $status_text = esc_html__( 'Pending', 'exertio_theme' );}
											else if($array['status'] == 'on-hold'){ $badge_color = 'btn-inverse-dark'; $status_text = esc_html__( 'On Hold', 'exertio_theme' );}
											else if($array['status'] == 'cancelled'){ $badge_color = 'btn-inverse-secondary'; $status_text = esc_html__( 'Cancelled', 'exertio_theme' );}
											else if($array['status'] == 'refunded'){ $badge_color = 'btn-inverse-info'; $status_text = esc_html__( 'Refunded', 'exertio_theme' );}
											else if($array['status'] == 'failed'){ $badge_color = 'btn-inverse-danger'; $status_text = esc_html__( 'Failed', 'exertio_theme' );}
											?>
											<span class="badge btn <?php echo esc_html($badge_color); ?>">
											<?php echo wp_return_echo($status_text); ?>
											</span>
										</div>
										<div class="pro-coulmn"><a href="<?php get_template_part('');?>?ext=invoice-detail&invoice-id=<?php echo esc_html($array['ID']); ?>" class="btn btn-secondary"><?php echo esc_html__( 'View Invoice', 'exertio_theme' ); ?></a></div>
									  </div>

									<?php
								}
								echo custom_pagination_invoices($total_posts, $paged);
							}
							else
							{
								?>
								<div class="nothing-found">
									<h3><?php echo esc_html__( 'Sorry!!! No Invoice Found', 'exertio_theme' ) ?></h3>
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