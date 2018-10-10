<style>
    #formdiv {
      text-align: center;
    }
    #file {
      color: green;
      padding: 5px;
      border: 1px dashed #123456;
      background-color: #f9ffe5;
    }
    #img {
      width: 17px;
      border: none;
      height: 17px;
      margin-left: -20px;
      margin-bottom: 191px;
    }
    .upload {
      width: 100%;
      height: 30px;
    }
    .abcd, .abcd_default {
      text-align: center;
      position: relative;
    }
    .abcd img, .abcd_default img {
      height: 80px;
      width: 80px;
      float: left;
      margin: 3px;
      padding: 2px;
      border: 1px solid rgb(232, 222, 189);
    }
    .delete {
      color: red;
      font-weight: bold;
      position: absolute;
      top: 0;
      cursor: pointer
    }
</style>
<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
    <?php if (validation_errors()) { ?>
        <div class="col-md-12 pull-right"><div class="alert alert-danger" style="padding:5px;margin:0;"><?= validation_errors(); ?></div></div>
    <?php } ?>
	  	<div class="row">
	    	<div class="profile">
          <h3>Add Products</h3>
	      </div>
	    </div>
      <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
  			<div class="row">
          <div class="col-md-12">
            <div class="col-md-5">
                <div class="form-group label-floating">
                  <label for="product_code" class="control-label">Product Code</label>
                  <input type="text" class="form-control" <?= isset($product->code) ? 'disabled' : 'name="code"' ?>  onchange="Validate.product(this.value)" value="<?= isset($product->code) ? $product->code : '' ?>"  id="product_code">
                  <p class="help-block" style="display:none" id="product_error">This<code>Product already exist</code></p>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="form-group label-floating">
                  <label for="product_name" class="control-label">Product Name</label>
                  <input type="text" class="form-control" value="<?= isset($product->name) ? $product->name : '' ?>" name="name" id="product_name">
                  
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group label-floating">
                  <label for="sku_number" class="control-label">SKU Number</label>
                  <input type="text" class="form-control" value="<?= isset($product->sku) ? $product->sku : '' ?>" name="sku" id="sku_number">
                  <p class="help-block">Please enter valid <code>SKU Number</code></p>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="form-group label-floating">
                  <label for="barcode" class="control-label">Barcode</label>
                  <input type="text" class="form-control" value="<?= isset($product->barcode) ? $product->barcode : '' ?>" name="barcode" id="barcode">
                  <p class="help-block">Please enter valid <code>Barcode</code></p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group label-floating">
                  <label for="model_number" class="control-label">Model Number</label>
                  <input type="text" class="form-control" value="<?= isset($product->model_no) ? $product->model_no : '' ?>" name="model_no" id="model_number">
                  <p class="help-block">Please enter valid <code>Model Number</code></p>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="form-group label-floating">
                  <label for="sort_description1" class="control-label">Sort Description1</label>
                  <input type="text" class="form-control" value="<?= isset($product->description) ? $product->description : '' ?>" name="description" id="sort_description1">
                  <p class="help-block">Please enter valid <code>Sort Description</code></p>
                </div>
            </div>
            <div class="col-md-5">
              <?php if (isset($product)) {
              foreach ($product->inventories as $value) { ?>
                  <div class="form-group label-floating">
                    <label for="sort_description2" class="control-label">Quantity for <?php print_r($value->pro_vendor->first_name); ?></label>
                    <input type="number" class="form-control" disabled="disabled" value="<?= isset($value->quantities) ? $value->quantities : '' ?>" name="quantity" id="sort_description2">
                    <p class="help-block">Please enter valid <code>Quantity</code></p>
                  </div>
              <?php } } ?>
            </div>
              
            <input type="hidden" value="<?= isset($product->id) ? $product->id : '' ?>" name="product_id">
            <div class="col-md-5 col-md-offset-1">
                <div id="formdiv">
                  <div id="filediv">
                    <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" title="Select Images To Be Uploaded">
                    <br>
                    <?php if(isset($product->product_images[0])) { 
                      foreach($product->product_images as $key => $product_img) {?>
                        <div id="default_previewImg<?= $key ?>" class="abcd_default" style="float:left">
                          <p class="cross_btn" onclick="Image.delete_product(<?= $product_img->product_image->id ?>,this.parentNode.id)">&cross;</p>
                          <img src="<?= base_url() ?>assets/products/<?= $product_img->product_image->image_url ?>">
                        </div>
                    <?php } }?>
                  </div> 
                </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-5">
              <div class="form-group">
                <label for="brands">Brands</label>
                <select id="brands" name="brand_id" class="form-control">
									<?php foreach ($brands as $brand) { ?>
										<option value="<?= $brand->id ?>" <?php if(isset($product) && $product->brand_id == $brand->id) { echo 'selected'; } ?> ><?= $brand->name ?></option>
									<?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
              <div class="form-group label-floating">
								<a href='<?= base_url('backend/allfunction/add_brand/add/8989') ?>' class='show-modal btn btn-info'> Add New Brand </a>
              </div>
            </div>
          </div>
          <?php if(!isset($product)) { ?>
          <div class="col-md-12" id="sub_category_2">
            <div class="col-md-3 new_category_2">
              <div class="form-group">
                <label for="parent_id_1">Category</label>
                <select id="parent_id_1" key="1" name="parent_id[]" onchange="Category.category_select(this.value , this.id , 2,2)" class="form-control">
									<option value="">&nbsp;</option>
									<?php foreach ($categories as $category) {
										if($category->lavel == 0 && $category->active == 1) { ?>
										  <option value="<?= $category->id ?>"><?= $category->name ?></option>
										<?php } ?>
									<?php } ?>
                </select>
								<input type="hidden" id="cat_num" name="cat_num"/>
              </div>
            </div>
          </div>
					<div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group label-floating">
								<a href='<?= base_url('backend/allfunction/category/add/product') ?>' class='show-modal btn btn-info'> Add New Category </a>
              </div>
            </div>
					</div>
          <?php } ?>
					<div class="col-md-12">
						<div class="form-group" id="product_attribute">
                <label for="parent_id_1" id="attr_label" style="display:none;float:left">Attributes</label>
							
						</div>
					</div>
          <?php if (isset($product)) { foreach ($product->inventories as $value) { ?>
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label for="cost_price" class="control-label">Cost Price for <?php print_r($value->pro_vendor->first_name); ?></label>
                  <input type="text" class="form-control" disabled="disabled" value="<?= isset($value->cost_price) ? $value->cost_price : '' ?>" name="cost_price" id="cost_price">
                  <p class="help-block">Please enter <code>Cost Price</code></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group label-floating">
                  <label for="product_code" class="control-label">MRP for <?php print_r($value->pro_vendor->first_name); ?></label>
                  <input type="text" class="form-control" disabled="disabled" value="<?= isset($value->mrp) ? $value->mrp : '' ?>" name="mrp" id="product_code">
                  <p class="help-block">Please enter <code>Maximum Retail Price</code></p>
                </div>
              </div>
            </div>
          <?php } } ?>
          <div class="col-md-12">
            <div class="col-md-6">
              <div class="form-group label-floating">
              <div class="togglebutton">
                <label>
                  Status: &nbsp;
                  <input type="checkbox" name="status" checked onchange="alert(this.value)">
                </label>
              </div>
            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="col-md-12 text-center">
              <input type="submit" class="btn btn-info" id="add_product" name="submit" value='Submit'>
            </div>
          </div>
        </div>
      </form>
	  </div>
</div>
</div>
<script src="<?= base_url('assets/js/image_upload.js') ?>" type="text/javascript"></script>
