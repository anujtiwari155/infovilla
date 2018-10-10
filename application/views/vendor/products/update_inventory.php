<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&cross;</button>
      <h4 class="modal-title">Update Inventory</h4>
    </div>
    	<form action="<?= $action ?>" method="post">
		    <div class="modal-body">
		    	<table class="table">
		    		<tr>
		    			<td>Product Name</td>
		    			<td><?= $product_name ?></td>
		    		</tr>
		    		<tr>
		    			<td>Item Remaining</td>
		    			<td><b><?= $in_stock ?></b></td>
		    		</tr>
		    		<tr>
		    			<td>Product to Add</td>
		    			<td><input type="number" name="quantity" class=""></td>
		    		</tr>
		    	</table>
		    </div>

		    <div class="modal-footer">
		      <input type="submit" class="btn btn-primary" value="Add">
		    </div>
	    </form>
  </div>
</div>
