<div class="main main-raised" >
	<div class="profile-content" style="padding:3%">
		<div class="container">
	  	<div class="row">
	    	<div class="profile">
          <h3>Attributes</h3>
					<div class="col-md-12">
		          <ul class="list-group" style="text-align:left;">
		            <?php foreach($attributes as $attribute) { ?>
		              	<li class="list-group-item" style="padding-top:1.5%;">
		              		<?= $attribute->name ?>
		              		<i class="fa fa-trash" onclick="ajax.attribute_delete(<?= $attribute->id ?>)" style="float:right;padding:0 5px;" aria-hidden="true"></i>
					  			
					  		<a href="<?= base_url() ?>backend/allfunction/attribute/update/<?= $attribute->id ?>" class='show-modal' style="float:right;padding:0 5px;">
					  				<i class="fa fa-pencil" aria-hidden="true"></i>
					  		</a>
							<ul>
								<?php foreach($attribute_values as $attribute_value) {
									if($attribute->id == $attribute_value->attribute_id) { ?>
									<li class="" style="text-align:left;padding:0"><?= $attribute_value->value ?></li>
								<?php } } ?>
							</ul>
						</li>
		            <?php } ?>
		          </ul>
					</div>
	      </div>
	    </div>
      <div class="row text-center">
        <?php echo "<a href='" . base_url('backend/allfunction/attribute/add') . "' class='show-modal btn btn-link'> Add More </a>"; ?>
      </div>
	  </div>
</div>
</div>