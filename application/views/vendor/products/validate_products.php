<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
			<div class="row">
			  	<div class="col-md-12">
			  		<div class="col-md-3">&nbsp;</div>
				    <div class="col-md-6">
				        <div class="form-group label-floating">
				          <label for="product_code" class="control-label">Product Code</label>
				          <input type="text" class="form-control" <?= isset($product->code) ? 'disabled' : 'name="code"' ?>  onchange="Validate_vendor.product(this.value)" value="<?= isset($product->code) ? $product->code : '' ?>"  id="product_code">
				          <p class="help-block" style="display:none" id="product_error">This<code>Product already exist</code></p>
				        </div>
				        <button type="button" id="validate_btn" class="btn btn-info btn-sm pull-right">Validate</button>
				    </div>
			    </div>
			    <div class="col-md-12" id="valid_pro" style="display: none;">
			    	<div class="col-md-3">&nbsp;</div>
			    	<div class="col-md-6">
			    		<p class="text-success">Product Validated Successfully</p>
			    		<a href="" id="add_nw_product" class="btn btn-md btn-primary">Proceed</a>
			    	</div>
			    </div>
			    <div class="col-md-12"><br></div>
			    <div class="col-md-12">
			    	<div class="col-md-3">&nbsp;</div>
			    	<div class="col-md-6" id="add_product">
			    	
			    	</div>
			    </div>
			    <div class="col-md-12">
			    	<div class="col-md-3">&nbsp;</div>
			    	<div class="col-md-6">
			    		<input type="submit" style="display: none;" class="btn btn-sm btn-primary pull-right" id="submit" value="Add"/>
			    	</div>
			    </div>
		    </div>
		</form>
	</div>
</div>
