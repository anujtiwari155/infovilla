<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
	  	<div class="row">
	    	<div class="profile">
          	<h3>Brands</h3>
          	<ul class="list-group"style="text-align:left;">
				<?php foreach($brands as $brand) { ?>
			  		<li class="list-group-item">
			  			<a href="<?= base_url() ?>backend/allfunction/brand/brand_details/<?= $brand->id ?>" style="text-decoration:none">
			  				<?= $brand->name ?>
			  			</a>
			  			<i class="fa fa-trash" onclick="ajax.brand_delete(<?= $brand->id ?>)" style="float:right;padding:0 5px;" aria-hidden="true"></i>
			  			
			  			<a href="<?= base_url() ?>backend/allfunction/add_brand/update/<?= $brand->id ?>" class='show-modal' style="float:right;padding:0 5px;">
			  				<i class="fa fa-pencil" aria-hidden="true"></i>
			  			</a>
			  		</li>
			  	<?php } ?>
			</ul>
	      </div>
	    </div>
      <div class="row text-center">
        <?php echo "<a href='" . base_url('backend/allfunction/add_brand/add/99999') . "' class='show-modal btn btn-link'> Add Brand </a>"; ?>
      </div>
	  </div>
</div>
