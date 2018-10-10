<SECTION>

	<div class="container">
     <div class="row">
        <div class="col-sm-12 col-md-12 content">
			<?php foreach ($categories as $category) { ?>
		           <div class="col-md-3 col-xs-12 col-sm-4 list-group">
		           <a class="list-group-item" href="<?= base_url('category/'.$category->slug) ?>" style="color: #0f1212;"><?php echo ucwords($category->name); ?></a>
		        </div>
		    <?php } ?> 
		</div>
	  </div>
	</div>
</SECTION>