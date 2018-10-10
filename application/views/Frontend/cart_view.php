<div class="panel-body">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-hover">
				<tr>
			        <th>Item Description</th>
			        <th>QTY</th>
			        <th style="text-align:right">Item Price</th>
			        <th style="text-align:right">Sub-Total</th>
				</tr>

				<?php $i = 1; ?>

				<?php foreach($this->cart->contents() as $items): ?>

				<?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
				    <tr>
				        <td>
				        	<img src="<?php echo base_url('assets/products/').'/'.$items['image_url']; ?>" class="img-responsive pull-left" width="70px">
				        	<?php echo $items['name']; ?>
				            <?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
							<p>
								<?php foreach($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
						            <strong><?php echo $option_name; ?>:</strong> 
						            <?php echo $option_value; ?><br />
				                <?php endforeach; ?>
				            </p>
							<?php endif; ?>
						</td>
				    	<td>
				    		<?= $items['qty'] ?>
						</td>
				        <td style="text-align:right">
				        	<?php echo $this->cart->format_number($items['price']); ?>
				        </td>
				        <td style="text-align:right">
				        $<?php echo $this->cart->format_number($items['subtotal']); ?>
				        </td>
				        <td></td>
				    </tr>
				<?php $i++; ?>

				<?php endforeach; ?>

					<tr>
					    <td colspan="2"> </td>
					    <td class="right"><strong>Total</strong></td>
					    <td class="right">
					    	$<?php echo $this->cart->format_number($this->cart->total()); ?>
					    </td>
					</tr>
			</table>
		</div>
	</div>
	<button type="button" class="btn btn-md btn-primary pull-right" onclick="Validate.process_final_pro()">Proceed</button>
</div>