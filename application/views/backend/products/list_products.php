<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a href="<?= base_url() ?>backend/allfunction/product/add" class="pull-right btn btn-sm btn-info">Add Products</a>
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
	          <h3><?= $list ?> (<?= $product_count ?>)</h3>
				<!-- <ul class="list-group" style="text-align:left;">
					<?php foreach($products as $product) { ?>
	          <?php  ?>
				  		<li class="list-group-item">
				  			<a href="<?= base_url() ?>backend/allfunction/product/product_details/<?= $product->id ?>" style="text-decoration:none">
				  				<img src="<?= base_url() ?>assets/products/<?php if(isset($product->product_images[0])) { print_r($product->product_images[0]->product_image->image_url); } ?>" style="margin:0" class="img_responsive" width="20px">&nbsp;&nbsp;
				  				<?= $product->name ?>
				  			</a>
				  			<a href="<?= base_url() ?>backend/commonfunction/update_inventory/<?= $product->id ?>" style="float: right;" class="show-modal" >Add Product</a>
				  			<a href="<?= base_url() ?>backend/allfunction/product/delete/<?= $product->id ?>" style="float:right;padding:0 5px;">
				  				<i class="fa fa-trash " aria-hidden="true"></i>
				  			</a>
				  			<a href="<?= base_url() ?>backend/allfunction/product/update/<?= $product->id ?>" style="float:right;padding:0 5px;">
				  				<i class="fa fa-pencil" aria-hidden="true"></i>
				  			</a>
				  		</li>
				  	<?php } ?>
				</ul> -->
				<table class="table">
					<tr>
						<th style="text-align: center;">Image</th>
						<th style="text-align: center;">Name</th>
						<th style="text-align: center;">Brand</th>
						<th style="text-align: center;">Status</th>
						<th style="text-align: center;">Added By</th>
						<th style="text-align: center;">Edit</th>
					</tr>
					<?php foreach($products as $product) { ?>
						<tr>
							<td>
								<a href="<?= base_url() ?>backend/allfunction/product/product_details/<?= $product->id ?>" style="text-decoration:none">
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
								<select class="" name="status" onchange="Product.status(this.value,<?= $product->id ?>)">
									<option <?= ($product->status == 0) ? 'selected' : '' ?> value="0">Pending</option>
									<option <?= ($product->status == 1) ? 'selected' : '' ?> value="1">Approved</option>
								</select>
								
							</td>
							<td style="text-align: center;"><?= $product->vendor->get_full_name() ?></td>
							<td style="text-align: center;">
					  			<a href="<?= base_url() ?>backend/allfunction/product/update/<?= $product->id ?>">
					  				<i class="fa fa-pencil" aria-hidden="true"></i></a>
					  			<a href="<?= base_url() ?>backend/Allfunction/product/delete/<?= $product->id ?>?per_page=<?= (isset($_GET['per_page'])) ? $_GET['per_page'] : ''?>">
					  				<i class="fa fa-trash " aria-hidden="true"></i>
					  			</a>
							</td>
						</tr>
					<?php } ?>
				</table>
	                <?= ($this->pagination) ? $this->pagination->create_links() : ''; ?>
		      </div>
		    </div>
	  </div>
</div>
</div>