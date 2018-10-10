<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<div class="row">
				<form action="" method="get">
					<div class="col-md-3">
						<select name="date" class="form-control">
							<option value="">Select Date</option>
							<option <?= ($default_date == '7_days') ? 'selected' : '' ?> value="7_days">Last 7 days</option>
							<option <?= ($default_date == '1_month') ? 'selected' : '' ?> value="1_month">Last 1 Month</option>
							<option <?= ($default_date == '6_months') ? 'selected' : '' ?> value="6_months">Last 6 Month</option>
							<option <?= ($default_date == 'over_all') ? 'selected' : '' ?> value="over_all">Over All</option>
						</select>
					</div>
					<div class="col-md-3">
						<select name="category" class="form-control">
							<option value="">All Category</option>
							<?php foreach ($categories_0 as $key => $category) { ?>
								<option <?= ($dafault_category == $category->id) ? 'selected':'' ?> value="<?= $category->id ?>" > <?= $category->name ?> </option>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-3">
						<select name="status" class="form-control">
							<option value="">All Product</option>
							<option <?= ($default_status == 'booked') ? 'selected' : '' ?> value="booked">Booked Product</option>
							<option <?= ($default_status == 'delevered') ? 'selected' : '' ?> value="delevered">Delivered Product</option>
						</select>
					</div>
					<div class="col-md-3 text-center">
						<input type="submit" name="submit" class="btn btn-primary btn-sm" style="margin-top: 25px" value="Filter"/>
					</div>
				</form>
				<div class="col-md-12">
					<div class="report">
						<div class="row">
							<h3>Sales Report</h3>
							<div class="col-md-12">
								<div class="col-md-3 box">
									<p>Orders</p>
									<h2><?php echo count($reports); ?></h2>
								</div>
								<div class="col-md-3 box">
									<p>Product Sell</p>
									<h2><?= $sold_product->total_quantity ?></h2>
								</div>
								<div class="col-md-3 box">
									<p>Total Revenue</p>
									<h2>$<?= round($sold_product->order_total,2) ?></h2>
								</div>
								<div class="col-md-3 box">
									<p>Total Profit</p>
									<h2>$<?= round($sold_product->order_profit,2) ?></h2>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		  	<div class="row">
		    	<div class="profile">
	          		<h3>Order List</h3>
	          		<div class="table-responsive" >
	          			<table class="table table-striped table-hover" style="text-align: left">
	          				<thead>
	          					<tr>
	          						<th>Id</th>
	          						<th>Order Id</th>
	          						<th>Customer Name</th>
	          						<th>Quantity</th>
	          						<th>Status</th>
	          						<th>Created On</th>
	          						<th>Sub Total</th>
	          						<th>View</th>
	          					</tr>
	          				</thead>
	          				<tbody>
	          					<?php $total = $total_quantity = 0; foreach ($reports as $report) { ?>
	          						<tr>
	          							<td><?= $report->id ?></td>
	          							<td><?= $report->order_id ?></td>
		          						<td><?= $report->user_detail->get_full_name() ?></td>
		          						<td><?= $report->vender_products_quantity($current_user_details->id) ?></td>
		          						<td><?= ($report->is_delivered == 1) ? 'Delivered' : 'Booked' ?></td>
		          						<td><?= date('Y-m-d', strtotime($report->created_date)); ?></td>
		          						<td>$<?= $report->vender_products_price($current_user_details->id) ?></td>
		          						<td><a href="<?= base_url('vendor/VendorReport/order_detail/'.$report->id.'/'.$current_user_details->id) ?>" class="show-modal" >view</a></td>
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