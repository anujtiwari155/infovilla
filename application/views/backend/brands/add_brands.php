<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&cross;</button>
      <h4 class="modal-title">Add Brands</h4>
    </div>
	    <div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-5 col-md-offset-1">
							<div class="form-group label-floating">
								<label for="brand_name" class="control-label">Brand Name</label>
								<input type="text" class="form-control" value="<?php if(isset($brand_detail->name)) { echo $brand_detail->name; } ?>" name="brand_name" id="brand_name">
								<p class="help-block">Please enter valid <code>Brand Name</code></p>
							</div>
						</div>
						<div class="col-md-5 col-md-offset-1">
							<div class="form-group label-floating">
								<label for="brand_code" class="control-label">Brand Code</label>
								<input type="text" class="form-control" <?php if(isset($brand_detail->code)) { echo "disabled"; } else { echo "name='brand_code'"; } ?> value="<?php if(isset($brand_detail->code)) { echo $brand_detail->code; } ?>" onchange='Validate.brand(this.value)' id="brand_code">
								<p class="help-block">Please enter valid <code>Brand Code</code></p>
							</div>
						</div>
					</div>
				</div>
        <div class="row text-center">
          <div class="loader" id="brand_loader"></div>
        </div>
	    </div>

	    <div class="modal-footer">
	      <button type="button" class="btn btn-primary" id="add_brand" onclick='<?php if($is_product == 8989 || $is_product == 99999) { echo "ajax.brand_add(". $is_product .")"; } else { echo "ajax.brand_update(".$is_product.")"; }?>'  name="submit">ADD</button>
	    </div>
  </div>
</div>
