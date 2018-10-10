<?php
	$this->data['url']  = base_url('shipping');
	$this->session->set_userdata($this->data);
?>
<section>
<div class="row" style="margin: 0; padding-left: 15px; padding-right: 15px">
	<div class="col-md-12">
		<div class="container">
			<div class="table-responsive" style="width: 100%">
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
					    		<?php echo form_input(array(
									'name' => $i . '[qty]',
									'value' => $items['qty'],
									'maxlength' => '3',
									'size' => '5',
									'rowid' => $items['rowid'],
									'onfocus' => "$('#check').show()",
									'onblur' => "$('#check').hide()",
									'onchange' => "updateCart(this.value,$(this).attr('rowid'),".$items['id'].");"
								)); ?> <i class="fa fa-check" style="display: none" id="check" aria-hidden="true"></i>
							</td>
					        <td style="text-align:right">
					        	<?php echo $this->cart->format_number($items['price']); ?>
					        </td>
					        <td style="text-align:right">
					        $<?php echo $this->cart->format_number($items['subtotal']); ?>
					        </td>
					        <td style="cursor: pointer;" onclick="Cart.remove('<?= $items['rowid'] ?>');">Remove</td>
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
			<a href="<?= base_url() ?>" class="btn btn-link">Continue Shopping</a>
			<a href="<?php if($login_user != 'Guest') { echo base_url('shipping'); } else { echo base_url('login'); } ?>" class="<?= ($login_user == 'Guest') ? 'show-modal' : '' ?> pull-right btn btn-link">Proceed to Checkout</a>
		</div>
	</div>
</div>

</section>