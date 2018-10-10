<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
	  	<div class="row">
	    	<div class="profile">
          <h3>List of Categories</h3>
		<ul class="list-group" style="text-align:left;">
            <?php foreach($categories as $category) {
				if($category->lavel == 0) { ?>
              		<li class="list-group-item" style="padding-top:1.5%"><?= $category->name; ?>
              			<a href="<?= base_url() ?>backend/allfunction/category/update/<?= $category->id ?>" class='show-modal' style="padding:0 5px;">
				  				<i class="fa fa-pencil" aria-hidden="true"></i>
				  		</a>	
					  	<i class="fa fa-trash" onclick="ajax.category_delete(<?= $category->id ?>)" style="padding:0 5px;" aria-hidden="true"></i>
						<ul>
							<?php foreach( $categories as $sub_category ) {
								if($sub_category->lavel == 1 && $sub_category->parent_id == $category->id ) { ?>
									<li><?= $sub_category->name ?>
										<a href="<?= base_url() ?>backend/allfunction/category/update/<?= $sub_category->id ?>" class='show-modal' style="padding:0 5px;">
								  				<i class="fa fa-pencil" aria-hidden="true"></i>
								  		</a>
								  		<i class="fa fa-trash" onclick="ajax.category_delete(<?= $sub_category->id ?>)" style="padding:0 5px;" aria-hidden="true"></i>
										<ul>
											<?php foreach ($categories as $sub_category1) {
												if($sub_category1->lavel == 2 && $sub_category1->parent_id == $sub_category->id) { ?>
													<li><?= $sub_category1->name ?>
														<a href="<?= base_url() ?>backend/allfunction/category/update/<?= $sub_category1->id ?>" class='show-modal' style="padding:0 5px;">
												  				<i class="fa fa-pencil" aria-hidden="true"></i>
												  		</a>
												  		<i class="fa fa-trash" onclick="ajax.category_delete(<?= $sub_category1->id ?>)" style="padding:0 5px;" aria-hidden="true"></i>
													</li>
												<?php } ?>
											<?php } ?>
										</ul>
									</li>
								<?php } ?>
							<?php } ?>
						</ul>
						<!-- <img class="pull-right img-responsive" width="70px" src="<?= base_url('assets/img/category/'.$category->image) ?>"> -->
					</li>
            <?php } } ?>

        </ul>
	      </div>
	    </div>
      <div class="row text-center">
        <?php echo "<a href='" . base_url('backend/allfunction/category/add') . "' class='show-modal btn btn-link'> Add More </a>"; ?>
      </div>
	  </div>
</div>
</div>
