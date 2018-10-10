<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<div class="row">
				<h3><?= $customer->get_full_name(); ?></h3>
				<address>
					<?= $customer->email ?><br>
					<?= $customer->user_profile->address ?><br>
					<?= $customer->user_profile->city ?> - <?= $customer->user_profile->zip ?><br>
					<?= $customer->user_profile->state ?><br>
					<?= $customer->user_profile->country ?><br>
				</address>
				<div class="col-md-12">
					<div class="report">
						<div class="row">
							<h3>Sales Report</h3>
							<div class="col-md-12">
								<div class="col-md-3 box">
									<p>Total Order</p>
									<h2><?= count($orders) ?></h2>
								</div>
								<div class="col-md-3 box">
									<p>Total Products</p>
									<h2><?= $user_all_products->total ?></h2>
								</div>
								<div class="col-md-3 box">
									<p>Delivered Products</p>
									<h2><?= $user_delivered_products->total ?></h2>
								</div>
								<div class="col-md-3 box">
									<p>Total Income</p>
									<h2>$<?= round($user_all_products->income,3) ?></h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
		    	<div class="profile">
	          		<h3>Order By <?= $customer->get_full_name(); ?></h3>
	          		<div class="table-responsive" >
	          			<table class="table table-striped table-hover" style="text-align: left">
	          				<thead>
	          					<tr>
	          						<th>Id</th>
	          						<th>Order Id</th>
	          						<th>Quantity</th>
	          						<th>Status</th>
	          						<th>Created On</th>
	          						<th>Sub Total</th>
	          						<th>View</th>
	          					</tr>
	          				</thead>
	          				<tbody>
	          					<?php $total = $total_quantity = 0; foreach ($orders as $order) { ?>
	          						<tr>
	          							<td><?= $order->id ?></td>
	          							<td><?= $order->order_id ?></td>
		          						<td><?= $order->quantity ?></td>
		          						<td><?= ($order->is_delivered == 1) ? 'Delivered' : 'Booked' ?></td>
		          						<td><?= date('Y-m-d', strtotime($order->created_date)); ?></td>
		          						<td>$<?= $order->order_total ?></td>
		          						<td><a href="<?= base_url('backend/Report/order_detail/'.$order->id) ?>" class="show-modal" >view</a></td>
		          					</tr>
	          					<?php } ?>
	          					<tr>
	          						<td colspan="3">Total: </td>
	          						<td colspan="4"></td>
	          						<td></td>
	          					</tr>
	          				</tbody>
	          			</table>
	          		</div>
		     	</div>
		    </div>
		</div>
	</div>
</div>