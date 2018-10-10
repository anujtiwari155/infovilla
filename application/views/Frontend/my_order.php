<section>
	<div class="row" style="margin: 0; padding-left: 15px; padding-right: 15px">
		<div class="col-md-12">
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
					<?php if (isset($orders[0])) { ?>
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
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php if (isset($orders[0])) { ?>
					<div class="row">
				    	<div class="profile">
			          		<h3>Order By <?= $customer->get_full_name(); ?></h3>
			          		<div class="table-responsive" >
			          			<table class="table table-striped table-hover" style="text-align: left">
			          				<thead>
			          					<tr>
			          						<th>Order Id</th>
			          						<th>Products</th>
			          						<th>Booked On</th>
			          						<th>Sub Total</th>
			          						<th>Details</th>
			          					</tr>
			          				</thead>
			          				<tbody>
			          					<?php $total = $total_quantity = 0; foreach ($orders as $order) { ?>
			          						<tr>
			          							<td><?= $order->order_id ?></td>
				          						<td><?= $order->quantity ?></td>
				          						<td><?= date('Y-m-d', strtotime($order->created_date)); ?></td>
				          						<td>$<?= $order->order_total ?></td>
				          						<td><a href="<?= base_url('Main/order_detail/'.$order->id) ?>" class="show-modal" >view</a></td>
				          					</tr>
			          					<?php } ?>
			          				</tbody>
			          			</table>
			          		</div>
				     	</div>
				    </div>
				<?php } else { ?>
					<div class="row">
						<div class="col-md-12">
							<h3>No Any order Yet...</h3>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>