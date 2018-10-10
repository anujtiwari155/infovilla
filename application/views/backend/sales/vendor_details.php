<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<?php $products = $vendor->vendor_products(); ?>
			<div class="row">
				<h3><?= $vendor->get_full_name(); ?></h3>
				<address>
					<?= $vendor->email ?><br>
					<?php if($vendor->user_profile) { ?>
						<?= $vendor->user_profile->address ?><br>
						<?= $vendor->user_profile->city ?> - <?= $vendor->user_profile->zip ?><br>
						<?= $vendor->user_profile->state ?><br>
						<?= $vendor->user_profile->country ?><br>
					<?php } ?>
				</address>
				<div class="col-md-12">
					<div class="report">
						<div class="row">
							<h3>Sales Report</h3>
							<div class="col-md-12">
								<div class="col-md-3 box">
									<p><b>Product Added by <?= $vendor->get_full_name(); ?></b></p>
									<?php $total_left_product = $total_amount_product = $total_sold_product = 0; 
									/*foreach ($products as $product) {
										$total_left_product += $product->quantity_added($vendor->id); 
										$total_sold_product  += $product->product_sold()->quantity;
										$total_amount_product  += $product->product_sold()->amount;
									}*/ ?>
									<h2><?= $vendor->product_added() ?></h2>
								</div>
								<div class="col-md-3 box">
									<p><b>Product Sold by <?= $vendor->get_full_name(); ?></b></p>
									<h2><?= $vendor->product_sold()->quantity ?></h2>
								</div>
								<div class="col-md-3 box">
									<p><b>Total Revenue by <?= $vendor->get_full_name(); ?></b></p>
									<h2>$<?= $vendor->product_sold()->amount ?></h2>
								</div>
								<!-- <div class="col-md-3 box">
									<?php $amount_earned = $total_amount_product - ($total_amount_product * (15/100)); ?>
									<p><b>Amount Earned by <?= $vendor->get_full_name(); ?></b></p>
									<h2>$<?= round($amount_earned,3) ?></h2>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<h3>Product Details</h3>
				<table class="table">
					<tr>
						<th>Img</th>
						<th>Name</th>
						<th>Quantity Added</th>
						<th>Quantity Sold</th>
						<th>Status</th>
						<th>Price per Unit</th>
					</tr>

					<?php foreach($products as $product) { ?>
						<tr>
							<td>
								<a href="<?= base_url() ?>vendor/Vendorfunction/product/product_details/<?= $product->id ?>" style="text-decoration:none">
					  				<img src="<?= base_url() ?>assets/products/<?php if(isset($product->product_images[0])) { print_r($product->product_images[0]->product_image->image_url); } ?>" style="margin:0" class="img_responsive" width="40px">
					  			</a>
							</td>
							<td>
								<?= $product->name ?>
							</td>
							<td>
								<?= $product->quantity_added($vendor->id) ?>
							</td>
							<td>
								<?= ($product->product_sold($vendor->id)->quantity != '') ? $product->product_sold($vendor->id)->quantity : 0 ?>
							</td>
							<td>
								<?= ($product->status == 1) ? '<p class="text-success" >Approved</p>' : '<p class="text-danger" >Pending</p>' ?> 
							</td>
							<td>
								<?= $product->mrp ?>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>