<div class="modal-dialog modal-lg">
  <form action="<?= $action ?>" method="post" enctype="multipart/form-data" class="modal-form">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&cross;</button>
        <h4 class="modal-title">Add Category</h4>
      </div>
      <div class="modal-body">
  			<div class="row">
  				<div class="col-md-12">
            <div class="col-md-5">
                <div class="form-group label-floating">
                  <label for="category_name" class="control-label">Category Name</label>
                  <input type="text" class="form-control" value="<?php if(isset($category->name)) { echo $category->name; } ?>" name="category_name" id="category_name">
                  <p class="help-block">Please enter valid <code>Category Name</code></p>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1">
                <div class="form-group label-floating">
                  <label for="category_code" class="control-label">Category Code</label>
                  <input type="text" <?php if(isset($category->name)) { echo "disabled"; } else { echo "name='category_code'"; } ?> onchange="Validate.category(this.value)" class="form-control" value="<?php if(isset($category->name)) { echo $category->category_code; } ?>"  id="category_code">
                  <p class="help-block" style="display: none;" id="product_error"><code>Category Already Exist</code></p>
                </div>
            </div>
          </div>
        </div>
        <?php if(!isset($category)) {?>
          <div class="row">
    				<div class="col-md-12" id="sub_category_1">
              <div class="col-md-3 new_category_1">
                <div class="form-group">
                  <label for="parent_id_1">Parent Category</label>
                  <select id="parent_id_1" name="parent_id[]" key="1" onchange="Category.category_select(this.value,this.id,1,1)" class="form-control">
                    <option value="0">Root</option>
    								<?php foreach ($categories as $category_l) {
                      if($category_l->lavel == 0 && $category_l->active == 1) { // list only first label / parent label?>
    									  <option value="<?= $category_l->id ?>"><?= $category_l->name ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
    			</div>
        <hr/>
        <?php } ?>
        <div class="label-floating" id="cat_img">
          <label for="category_code" class="control-label">Category Image</label>
          <input type="file" name="category_img" class="form-control">
          <hr/>
        </div>
        <h4 class="modal-title">Add Attribute</h4>
        <div class="row">
          <div class="col-md-12" id="add_attribute">
            <?php
            if(isset($selected_attr)) {
            foreach ($selected_attr as $attr) { ?>
              <div class="col-md-3">
                <div class="form-group">
                  <select id='attribute_1' name="category_attributes[]" class='form-control category_attribute'>
                    <?php foreach ($attributes as $attribute) { ?>
                      <option value="<?= $attribute->id ?>" <?php if($attribute->id == $attr->attribute_id) { echo 'selected'; } ?> ><?= $attribute->name ?></option>
                    <?php } ?>
                  </select><span onclick="$(this).parent().parent().remove()" >&cross;</span>
                </div>
              </div>
            <?php } } else { ?>
              <div class="col-md-3">
                <div class="form-group">
                  <select id='attribute_1' name="category_attributes[]" class='form-control category_attribute'>
                    <?php foreach ($attributes as $attribute) { ?>
                      <option value="<?= $attribute->id ?>"><?= $attribute->name ?></option>
                    <?php } ?>
                  </select><span onclick="$(this).parent().parent().remove()" >&cross;</span>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-info add_category_attr" onclick="Attribute.list_attributes()" >Add Attributes </button>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-info" id="add_product" value="<?php if(isset($category->name)) { echo "Update"; } else { echo "Add"; } ?>" name="submit"/>
        <!--<input type="button" class="btn btn-info add_category" id="1" attribute="1" onclick="ajax.category_add(this.id , $('.add_category_attr').attr('id'),'<?= $is_product ?>')" value="Add" name="submit"/>-->
      </div>
    </div>
  </form>
</div>
