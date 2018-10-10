<div class="modal-dialog modal-lg">
  <div class="modal-content">
  	<form action="<?= $action ?>" method="post" class="modal-form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&cross;</button>
      <h4 class="modal-title">Add Attribute</h4>
    </div>
    <div class="modal-body">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-5 col-md-offset-1">
						<div class="form-group label-floating">
							<label for="attribute_name" class="control-label">Attribute Name</label>
							<input type="text" class="form-control" value="<?php if(isset($attribute_detail)) { echo $attribute_detail->name; } ?>" name="attribute_name" onchange="Validate.attribute(this.value)" id="attribute_name">
							<p class="help-block">Please enter valid <code>Attribute Name</code></p>
						</div>
				</div>
				<div class="col-md-5 col-md-offset-1" id="attribute_value">
					<?php if(isset($attribute_detail_values)) { ?>
						<div class="form-group" style="margin-top:0">
							<label for="attribute_value_<?= $key ?>" class="control-label">Attribute Value</label>
							<?php foreach ($attribute_detail_values as $key => $attribute_value) { ?>
								<div class="form-group" style="margin-top:0" id="<?= $key ?>"><input type="text" class="form-control" style="width: 95%;float: left;" value="<?php if(isset($attribute_value)) { echo $attribute_value->value; } ?>" name="attr_value[]" ><div onclick="Attribute.remove_attr(this.parentNode.id)" style="height:32px;position:relative;top:10px">&cross;</div></div>
							<?php } ?>
						</div>
					<?php  } else { ?>
					<div class="form-group label-floating" id="1">
						<label for="attribute_value" class="control-label">Attribute Value</label>
						<input type="text" class="form-control" value="<?php if(isset($attribute_value)) { echo $attribute_value->value; } ?>" name="attr_value[]" id="value_1">
						<p class="help-block">Please enter valid <code>Attribute value</code></p>
					</div>
					<?php } ?>
				</div>
      			<input type="button" class="btn btn-xs pull-right arttibute_add" id="1" onclick="Attribute.add_attr(this.id)" value="add more value"/>
			</div>
		</div>
    </div>
    <div class="row text-center">
      <div class="loader" id="brand_loader"></div>
    </div>
    <div class="modal-footer">
    	<input type="submit" id="add_attr" class="btn btn-primary" value="<?php if(isset($attribute_detail)) { echo 'Update'; } else { echo 'Add'; } ?>" name="submit"/>
      	<!--<input type="button" class="btn btn-primary" id="add_attr" onclick="ajax.attribute_add($('.arttibute_add').attr('id'));" value="Add" name="submit"/>-->
    </div>
	</form>
  </div>
</div>
