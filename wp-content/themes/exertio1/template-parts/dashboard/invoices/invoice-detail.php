<?php
$alt_id = '';
$oder_id = $_GET[ 'invoice-id' ];
$current_user_id = get_current_user_id();

$order = wc_get_order( $oder_id );

$order_items = $order->get_items();
foreach ( $order_items as $item )
{
	$product_name = $item->get_name();
	$product = wc_get_product( $item['product_id'] );
	$product_type = $product->get_type();
}
$user_id = $order->get_user_id();
$amount = $order->get_total();
$order_status = $order->get_status();
$order_date = $order->get_date_paid();

$emp_id = get_user_meta( $user_id, 'employer_id', true );
$emp_address = get_post_meta( $emp_id, '_employer_address', true );

$product_name_text = '';
if(isset($product_type) && $product_type == 'wallet')
{
	$product_name_text = esc_html__( 'Wallet Amount', 'exertio_theme' );
}
else if(isset($product_type) && $product_type == 'employer-packages' || $product_type == 'freelancer-packages')
{
	$product_name_text = $product_name;
}
if($current_user_id == $user_id)
{
?>
	<div class="content-wrapper">
	  <div class="notch"></div>
	  <div class="row">
		<div class="col-md-12 grid-margin">
		  <div class="d-flex justify-content-between flex-wrap">
			<div class="d-flex align-items-end flex-wrap">
			  <div class="mr-md-3 mr-xl-5">
				<h2><?php echo esc_html__('Invoices Detail','exertio_theme'); ?></h2>
				<div class="d-flex"> <i class="fas fa-home text-muted d-flex align-items-center"></i>
				  <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;<?php echo esc_html__('Dashboard', 'exertio_theme' ); ?>&nbsp;</p>
				  <?php echo exertio_dashboard_extention_return(); ?> </div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-7 grid-margin stretch-card">
		  <div class="card mb-4">
			<div class="card-body">
			  <div id="printableArea">
				<div class="order-invoice">
				  <div class="order-invoice-header">
					<div class="row">
					  <div class="col-lg-6 col-xl-6 col-xs-12 col-md-6 col-sm-6">
						<div class="order-invoice-company">
						  <?php
						  $url = fl_framework_get_options( 'dasboard_logo' );
						  ?>
						  <img src="<?php echo esc_url($url['url']); ?>" alt="<?php echo esc_attr(get_post_meta($alt_id, '_wp_attachment_image_alt', TRUE)); ?>" class="img-responsive">
						  <?php
						  $address = '';
						  $address = fl_framework_get_options( 'address_invoice' );
						  if ( $address != '' ) {
							?>
						  <address class="order-invoice-to-info">
						  <?php echo fl_framework_get_options('address_invoice'); ?>
						  </address>
						  <?php
						  }
						  ?>
						  <p> <b><?php echo esc_html__( 'Date:', 'exertio_theme' ) ?></b>
							<?php  echo esc_html(date_i18n( get_option( 'date_format' ), strtotime( $order_date ) )); ?>
						  </p>
						</div>
					  </div>
					  <div class="col-lg-6 col-xl-6 col-xs-12 col-md-6 col-sm-6">
						<div class="order-invoice-to">
						  <h3 class="order-invoice-to-name"><?php echo esc_html__( 'Invoice', 'exertio_theme' ) ?></h3>
						  <?php
						  if ( $emp_address != '' ) {
							?>
						  <address class="order-invoice-to-info">
						  <?php echo esc_html($emp_address); ?>
						  </address>
						  <?php

						  }
						  $badge_color = $status_text = '';
						  if ( $order_status == 'completed' ) {
							$badge_color = 'btn-inverse-success';
							$status_text = esc_html__( 'Completed', 'exertio_theme' );
						  } else if ( $order_status == 'processing' ) {
							$badge_color = 'btn-inverse-primary';
							$status_text = esc_html__( 'Processing', 'exertio_theme' );
						  } else if ( $order_status == 'pending' ) {
							$badge_color = 'btn-inverse-warning';
							$status_text = esc_html__( 'Pending', 'exertio_theme' );
						  } else if ( $order_status == 'on-hold' ) {
							$badge_color = 'btn-inverse-dark';
							$status_text = esc_html__( 'On Hold', 'exertio_theme' );
						  } else if ( $order_status == 'cancelled' ) {
							$badge_color = 'btn-inverse-secondary';
							$status_text = esc_html__( 'Cancelled', 'exertio_theme' );
						  } else if ( $order_status == 'refunded' ) {
							$badge_color = 'btn-inverse-info';
							$status_text = esc_html__( 'Refunded', 'exertio_theme' );
						  } else if ( $order_status == 'failed' ) {
							$badge_color = 'btn-inverse-danger';
							$status_text = esc_html__( 'Failed', 'exertio_theme' );
						  }
						  ?>
						  <p><b><?php echo esc_html__( 'Invoice', 'exertio_theme' ) ?> #<?php echo esc_html($oder_id); ?></b> </p>
						  <p class="order-invoice-status"> <b><?php echo esc_html__( 'Status:', 'exertio_theme' ) ?></b> <span class="paid <?php echo esc_html($badge_color); ?>"> <?php echo esc_html($status_text); ?></span></p>
						</div>
					  </div>
					</div>
				  </div>
				  <div class="row">
					<div class="col-lg-12 col-xl-12 col-xs-12 col-md-12 col-sm-12">
					  <div class="table-responsive">
						<table class="table order-invoice-items">
						  <thead>
							<tr>
							  <th>#</th>
							  <th><?php echo esc_html__( 'Product', 'exertio_theme' ) ?></th>
							  <th> <?php echo esc_html__( 'Amount', 'exertio_theme' ) ?></th>
							</tr>
						  </thead>
						  <tbody>
							<tr>
							  <td>1</td>
							  <td><?php echo wp_return_echo($product_name_text); ?></td>
							  <td><span class="woocommerce-Price-amount amount"><?php echo esc_html(fl_price_separator($amount)); ?></span></td>
							</tr>
						  </tbody>
						</table>
					  </div>
					</div>
				  </div>
				  <div class="order-invoice-footer">
					<div class="row">
					  <div class="col-lg-6 col-xl-6 col-xs-12 col-md-6 col-sm-6"></div>
					  <div class="col-lg-6 col-xl-6 col-xs-12 col-md-6 col-sm-6">
						<div class="order-invoice-footer-total">
						  <div class="table-responsive">
							<table class="table">
							  <tbody>
								<tr>
								  <td><?php echo esc_html__( 'Total:', 'exertio_theme' ) ?></td>
								  <td><span class="order-invoice-footer-total-amount"><span class="woocommerce-Price-amount amount"><?php echo esc_html(fl_price_separator($amount)); ?></span></span></td>
								</tr>
							  </tbody>
							</table>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="col-md-12"> <a href="javascript:void(0)" class="btn btn-theme pull-right " onclick="printDiv('printableArea')"><?php echo esc_html__( 'Print Invoice', 'exertio_theme' ) ?></a> </div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
<?php
}
else
{
	get_template_part( 'template-parts/dashboard/layouts/dashboard');
}
?>
<script>
			function printDiv(printableArea)
			{
				 var printContents = document.getElementById(printableArea).innerHTML;
				 var originalContents = document.body.innerHTML;
				 document.body.innerHTML = printContents;
				 window.print();
				 document.body.innerHTML = originalContents;
				  
			}
		</script> 