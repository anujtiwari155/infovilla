<style type="text/css">
	.badge {
		color: #333;
		background-color: #fff;
	}
</style>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&cross;</button>
      <h4 class="modal-title">Product Details</h4>
    </div>
	    <div class="modal-body">
			<ul class="nav nav-tabs">
			  <li class="active"><a data-toggle="tab" href="#basic_info">Basic Info</a></li>
			  <li><a data-toggle="tab" href="#address_info">Address Info</a></li>
			  <li><a data-toggle="tab" href="#product">Products</a></li>
			</ul>

			<div class="tab-content">
				<div id="basic_info" class="tab-pane fade in active">
					<h4>Product Information</h4>
					<ul class="list-group">
						<li class="list-group-item justify-content-between">
							Order Status:
							<span class="badge badge-primary"><?= ($order_details->is_delivered == 1) ? 'Delivered' : 'Booked' ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Order Id:
							<span class="badge badge-primary badge-pill"><?= $order_details->order_id ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Customer Name:
							<span class="badge badge-primary badge-pill"><?php print_r($order_details->user_detail->get_full_name()); ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Order Sub Total:
							<span class="badge badge-primary badge-pill">$<?= $order_details->sub_total ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Order Shipping:
							<span class="badge badge-primary badge-pill">$<?= $order_details->order_shipping ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Order tax:
							<span class="badge badge-primary badge-pill">$<?= $order_details->order_tax ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Order total:
							<span class="badge">$<?= $order_details->order_total ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Profit:
							<span class="badge badge-primary badge-pill">$<?= $order_details->order_profit ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Payment Method:
							<span class="badge badge-primary badge-pill"><?= $order_details->payment_method ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Payment Status:
							<span class="badge badge-primary badge-pill"><?= ($order_details->payment_status == 0) ? 'pending' : 'done' ?></span>
						</li>
						<li class="list-group-item justify-content-between">
							Created On:
							<span class="badge badge-primary badge-pill"><?= date('Y-m-d', strtotime($order_details->created_date)) ?></span>
						</li>
					</ul>
				</div>
				<div id="address_info" class="tab-pane fade">
					<div class="col-md-6">
					<h4 class="text-center">Billing Information</h4>
					<table class="table">
						<tr>
							<td>Name:</td>
							<td><?= $order_details->user_detail->get_full_name() ?></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td><?= $order_details->user_detail->user_profile->address ?></td>
						</tr>
						<tr>
							<td>City:</td>
							<td><?= $order_details->user_detail->user_profile->city ?></td>
						</tr>
						<tr>
							<td>State:</td>
							<td><?= $order_details->user_detail->user_profile->state ?></td>
						</tr>
						<tr>
							<td>Country:</td>
							<td><?= $order_details->user_detail->user_profile->country ?></td>
						</tr>
					</table>
					</div>
					<div class="col-md-6">
					<h4 class="text-center">Shipping Information</h4>
					<table class="table">
						<tr>
							<td>Name:</td>
							<td><?= $order_details->shipping_name ?></td>
						</tr>
						<tr>
							<td>Address:</td>
							<td> <?= $order_details->shipping_address1." ".$order_details->shipping_address2 ?></td>
						</tr>
						<tr>
							<td>City:</td>
							<td><?= $order_details->shipping_city ?></td>
						</tr>
						<tr>
							<td>State:</td>
							<td><?= $order_details->shipping_state ?></td>
						</tr>
						<tr>
							<td>Country:</td>
							<td><?= $order_details->shipping_country ?></td>
						</tr>
					</table>
					</div>
				</div>
				<div id="product" class="tab-pane fade">
					<h3 class="text-center">Products</h3>
					<table class="table">
						<tr>
							<th>Picture</th>
							<th>Product Name</th>
							<th>Brand Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<?php if(isset($is_frontend) && $is_frontend == 1){ echo ""; } else { ?> <th>Vendor</th> <?php } ?>
							<th>Sub Total</th>
						</tr>
						<?php foreach ($order_details->order_details as $order) { ?>
						<tr>
							<td>
								<img src="<?= base_url() ?>assets/products/<?php if(isset($order->product_order_detail->product_images[0])) { print_r($order->product_order_detail->product_images[0]->product_image->image_url); } ?>" style="margin:0" class="img_responsive" width="40px">
							</td>
							<td>
								<?= $order->product_order_detail->name ?>
							</td>
							<td>
								<?= $order->product_order_detail->brand_name->name ?>
							</td>
							<td>
								<?= $order->product_order_detail->mrp ?>
							</td>
							<td>
								<?= $order->quantity ?>
							</td>
							
								<?php if(isset($is_frontend) && $is_frontend == 1){ echo ""; } else { echo "<td>".$order->order_vendor()."</td>"; } ?>
							
							<td>
								<?= $order->total ?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
        <div class="row text-center">
          <div class="loader" id="brand_loader"></div>
        </div>
	    </div>

	    <div class="modal-footer">

	    </div>
  </div>
</div>
