<!-- file name : frontend/payment.php -->
<style type="text/css">
	span.dblock {
		display: block;
	}
</style>
<section>
	<div class="row" style="margin: 0; padding-left: 15px; padding-right: 15px">
		<div class="col-md-12">
			<h3>Payment Details</h3>
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
						        <td onclick="Cart.remove('<?= $items['rowid'] ?>');">Remove</td>
						    </tr>
						<?php $i++; ?>

					<?php endforeach; ?>

						<tr>
						    <td colspan="2"> </td>
						    <td class="right"><strong>Grand Total</strong></td>
						    <td class="right">
						    	$<?php echo $this->cart->format_number($this->cart->total()); ?>
						    </td>
						</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row" style="margin: 0; padding-left: 15px; padding-right: 15px">
		<div class="col-md-6">
			<h3>Billing Address</h3>
			<p><b><span id="fname"><?= $login_user->first_name ?></span> <span id="lname"><?= $login_user->last_name ?></span></b></p>
			<span id="dphone" class="hidden"><?= $current_user_details->phone ?> </span>
			<span id="demail" class="hidden"><?= $current_user_details->email ?> </span>
			<span id="daddress1" class="dblock"><?= $current_user_details->user_profile->address ?></span>
			<span id="dcity" class="dblock"><?= $current_user_details->user_profile->city ?></span>
			<span id="dzip" class="dblock"><?= $current_user_details->user_profile->zip ?></span>
			<span id="dstate" class="dblock"><?= $current_user_details->user_profile->state ?></span>
			<span id="dcountry" class="dblock"><?= $current_user_details->user_profile->country ?></span>
		</div>
		<div class="col-md-6">
			<h3>Shipping Address</h3>
			<p><b><span ><?= $first_name ?></span> <span><?= $last_name ?></span></b></p>
			<span class="hidden"><?= $phone ?> </span>
			<span class="hidden"><?= $email ?> </span>
			<span class="dblock"><?= $address1 ?></span>
			<span class="dblock"><?= $address2 ?></span>
			<span class="dblock"><?= $city ?></span>
			<span class="dblock"><?= $zip ?></span>
			<span class="dblock"><?= $state ?></span>
			<span class="dblock"><?= $current_user_details->user_profile->country ?></span>
		</div>
	</div>
</section>
<section>
	<div class="row" style="margin: 0; padding-left: 15px; padding-right: 15px">
		<div class="col-md-12">
			<h3>Choose a Way to payment</h3>
			<ul class="nav nav-pills nav-stacked col-md-4" style="min-height: 295.682px;">
				<li class="active"><a data-toggle="tab" href="#online_payment">Online Payment</a></li>
				<li><a data-toggle="tab" href="#cod">COD</a></li>
			</ul>
			<div class="tab-content col-md-7 payment_block">
			  	<div id="online_payment" class="tab-pane fade in active">
			    	<p>Pay using Cradit / Debit Card</p>
			    	<form action="<?= base_url() ?>/frontend/Checkout/online_payment" method="post">
			    		<label>Card Number: </label><input type="text" name="card_number" class="form-control">
			    		<label>Exp month: </label><input type="number" min="1" max="12" name="exp_month" class="form-control">
			    		<label>Exp Year: </label><input type="number" min="2017" max="2033" name="exp_year" class="form-control">
			    		<input type="submit" class="btn btn-primary pay_btn" value="pay">
			    		<div class="clearfix"></div>
			    	</form>
			  	</div>
			  	<div id="cod" class="tab-pane fade">
			  		<p>Confirmaion:</p>
			  		<p>Please Verify shipping address shown above before confirmation</p>
					<p><a href="<?= base_url('payment') ?>" class="btn btn-primary btn-lg"> Confirm Order </a> </p>
			  	</div>
			</div>
		</div>
	</div>
</section>