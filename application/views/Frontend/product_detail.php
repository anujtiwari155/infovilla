	<!-- <link rel="stylesheet" href="<?= base_url('assets/zoom_img/css/example.css') ?>" /> -->
	<link rel="stylesheet" href="<?= base_url('assets/zoom_img/css/pygments.css') ?>" />
	<link rel="stylesheet" href="<?= base_url('assets/zoom_img/css/easyzoom.css') ?>" />
	<section>
		<div class="container" style="margin:0">
			<div class="col-md-12">
				<div class="col-md-5 col-xs-12 nopl nopr">
					<!-- <div class="col-md-2 nopl nopr list_product_image"> -->
					<ul class="thumbnails col-md-2 col-xs-4 nopl list_product_image">
						<?php foreach ($product->product_images as $key => $product_img) { ?>
							<li style="margin-bottom: 15px;">
								<a href="<?= base_url('assets/products/').'/'.$product_img->product_image->image_url ?>" data-standard="<?= base_url('assets/products/').'/'.$product_img->product_image->image_url ?>">
									<img src="<?= base_url('assets/products/').'/'.$product_img->product_image->image_url ?>" alt="" class="img-responsive" />
								</a>
							</li>
						<?php } ?>
					</ul>
					<!-- </div> -->
					<div class="col-md-10 col-xs-8">
						<div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
							<a href="<?= base_url('assets/products/').'/'.$product->product_images[0]->product_image->image_url ?>">
								<img src="<?= base_url('assets/products/').'/'.$product->product_images[0]->product_image->image_url ?>" alt="" width="100%" height="360" />
							</a>
						</div>
						<!-- <div class="buy_buttons">
							<button type="button" class="btn btn-primary btn-lg" name="buy_now"><i class="fa fa-flash" aria-hidden="true"></i> BUY NOW</button>
							<button type="button" class="btn btn-primary btn-lg" name="add_to_cart" ><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADD TO CART</button>
						</div> -->
					</div>
				</div>
				<div class="col-md-7 col-xs-12">
					<div class="name">
						<a href="#"><h4><?= ucfirst($product->name) ?></h4></a>
					</div>
					<div class="stock">
						<?php $quantity_check = 0; 
							if(isset($product->inventories[0])) { 
								foreach ($product->inventories as $key => $value) {
									if ($value->quantities > 0 ) {
										$quantity_check = 1;
										break;
									}
								}
							}
						?>
						<?php if($quantity_check) { ?>
						<p style="color:green">Avilable in Stock &nbsp; &nbsp; <i class="fa fa-check-circle" aria-hidden="true"></i></p>
						<?php }else { ?>
							<p style="color:red">Out of Stock &nbsp; &nbsp; <i class="fa fa-exclamation-circle" aria-hidden="true"></i></p>
						<?php } ?>
					</div>
					<div class="pull-left">
						<label style="color: #867777;">Validate Pin :<input type="text" onchange="Validate.zip(<?= $product->id ?>,this.value)" id="validate_pin" name="validate_pin" class="form-control"></label>
						<button type="button" class="btn btn-xs btn-default">Check...</button>
						<p id="zip_check" ></p>
					</div>
					<div class="price pull-right">
						<a href="<?= base_url() ?>basket/<?= $product->slug ?>/basket" <?php if(!$quantity_check) { echo "disabled"; }?> id="buy_now" class="btn btn-lg btn-primary"><h4>BUY NOW: &nbsp; &nbsp; $<?= $product->product_min_price($this->session->user_area_zip)->mrp ?></h4></a>
					</div>
					<div class="clearfix"></div>

					  <ul class="nav nav-tabs" style="margin-top: 5%">
					    <li class="active"><a data-toggle="tab" href="#information">Information</a></li>
					    <li><a data-toggle="tab" href="#description">Description</a></li>
					    <li><a data-toggle="tab" href="#about_product">About Product</a></li>
					  </ul>

					  <div class="tab-content" style="padding: 3% 0">
					    <div id="information" class="tab-pane in active">
					        <div class="information">
								<!-- <h4>Information</h4> -->
								<?php $pro_attr = array() ?>
								<p><b>Brand :</b> <?= $product->brand_name->name ?></p>
								<?php foreach ($product->product_attributes as $key => $attribute_one) { ?>
										<p>
											<b><?= $attribute_one->attributes->parent_attr->name ?> :</b> 
											<?php print_r($attribute_one->attributes->value); ?>
										</p>
								<?php } ?>
								<p><b>Category :</b> 
								<?php $last_index = count($product->product_categories)-1; foreach ($product->product_categories as $key => $category) {
									print_r($category->category->name);
									if($key != $last_index) {
										print_r(' &rArr; ');
									}
								} ?></p>
							</div>
					    </div>
					    <div id="description" class="tab-pane">
					      	<div class="description">
								<!-- <h4>Description</h4> -->
								<p><?= $product->description ?></p>
							</div>
						</div>
					    <div id="about_product" class="tab-pane">
					      	<div class="description">
								<!-- <h4>Description</h4> -->
								<p><?= $product->description ?></p>
							</div>
						</div>
					 </div>
				</div>
			</div>
		</div>
	</section>
	<script src="<?= base_url('assets/zoom_img/dist/easyzoom.js') ?>"></script>
	<script>
		// Instantiate EasyZoom instances
		var $easyzoom = $('.easyzoom').easyZoom();

		// Setup thumbnails example
		var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

		$('.thumbnails').on('click', 'a', function(e) {
			var $this = $(this);

			e.preventDefault();

			// Use EasyZoom's `swap` method
			api1.swap($this.data('standard'), $this.attr('href'));
		});

		// Setup toggles example
		var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

		$('.toggle').on('click', function() {
			var $this = $(this);

			if ($this.data("active") === true) {
				$this.text("Switch on").data("active", false);
				api2.teardown();
			} else {
				$this.text("Switch off").data("active", true);
				api2._init();
			}
		});
	</script>