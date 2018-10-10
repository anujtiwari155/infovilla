
<section>
	<div class="container">
     <div class="row">
        <div class="col-sm-12 col-md-12 content">
			<?php foreach ($brands as $brand) { ?>
		           <div class="col-md-3 list-group">
		            <a class="list-group-item" href="<?= base_url('brand/'.$brand->slug) ?>" style="color: #0f1212;"><?php echo ucwords($brand->name); ?></a>
		        </div>
		    <?php } ?> 
		</div>
	  </div>
	</div>  
</section>                  