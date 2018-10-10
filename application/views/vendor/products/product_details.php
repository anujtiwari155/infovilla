<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
	  	<div class="row">
	    	<div class="profile">
	    		<div class="row">
	    			<div class="col-md-12">
          				<h3><?= $product_details->name ?></h3>
          			</div>
          		</div>
          		<div class="row">
          		<?php //print_r($product_details->product_images); die(); ?>
          			<?php if(isset($product_details->product_images[0])) { 
          				foreach ($product_details->product_images as $key => $value) { ?>
          					<div class="col-md-3">
		          				<img src="<?= base_url() ?>assets/products/<?= $value->product_image->image_url ?>" style="margin:0;" >
		          			</div>
          			<?php } }?>          			
          		</div>
	      </div>
	    </div>
	  </div>
</div>