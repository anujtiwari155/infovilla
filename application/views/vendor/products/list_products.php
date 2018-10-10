<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="<?= base_url() ?>vendor/Vendorfunction/product/validate_product" class="pull-right btn btn-sm btn-info">Add Products</a>
				</div>
			</div>
			<?php if ($this->session->flashdata('message')) { ?>
			    <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">x</button> <?= $this->session->flashdata('message') ?> </div>
			<?php } ?>
			<div class="row">
				<form action="" method="get">
					<div class="col-md-12">
						<div class="col-md-3">
							<select name="brand_filter" class="form-control">
								<option value="">All Brands</option>
								<?php foreach ($brands as $key => $brand) { ?>
									<option <?php if(isset($default_brand) && $default_brand == $brand->id) { echo  'selected'; } ?>  value="<?= $brand->id ?>" > <?= $brand->name ?> </option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" class="form-control" name="search_product" placeholder="Search Product">
						</div>
						<div class="col-md-3">
							<input type="submit" style="float: right;" name="submit" class="btn btn-primary btn-xs" value="Filter">
						</div>
					</div>
				</form>
				
			</div>
		  	<div class="row">
		    	<div class="profile">
	          <h3><?= $list ?> (<?= count($products) ?>)</h3>
				<table class="table">
					<tr>
						<th>Image</th>
						<th>Name</th>
						<th>Brand</th>
						<th>Status</th>
						<th style="text-align: center;">Edit</th>
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
								<?= $product->brand_name->name ?>
							</td>
							<td>
								<?= ($product->status == 1) ? '<p class="text-success" >Approved</p>' : '<p class="text-danger" >Pending</p>' ?> 
							</td>
							<td style="text-align: center;">
					  			<a href="<?= base_url() ?>vendor/Vendorfunction/product/update/<?= $product->id ?>">
					  				<i class="fa fa-pencil" aria-hidden="true"></i></a>
					  			<a href="<?= base_url() ?>vendor/Vendorfunction/product/delete/<?= $product->id ?>">
					  				<i class="fa fa-trash " aria-hidden="true"></i>
					  			</a>
								<a href="<?= base_url() ?>vendor/CommonVfunction/update_inventory/<?= $product->id ?>"  class="show-modal" >Add Product</a>
							</td>
						</tr>
					<?php } ?>
				</table>
		      </div>
		    </div>
	  </div>
</div>
</div>