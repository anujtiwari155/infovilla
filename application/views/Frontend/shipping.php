<!-- file name : frontend/shipping.php -->
<style type="text/css">
	span.dblock {
		display: block;
	}
</style>
<section>
	<div class="container">
	    <?php if (validation_errors()) { ?>
	        <div class="col-md-12 pull-right"><div class="alert alert-danger" style="padding:5px;margin:0;"><?= validation_errors(); ?></div></div>
	    <?php } ?>
		<!-- <div class="col-md-12">
			<form action="" method="post">
				<div class="col-md-6">
					<h3><b>Billing Address</b></h3>
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
					<h3><b>Shipping Address</b></h3>
					<input type="checkbox" onchange="setBillingAddress(this.id);" id="copy_address"> <label for="copy_address"> Same as Billing Address</label>
					<hr/>
						<label>First Name: </label><input type="text" id="first_name" class="form-control" name="first_name" />
						<label>Last Name: </label><input type="text" id="last_name" class="form-control" name="last_name" />
						<label>Address 1: </label><input type="text" id="address1" class="form-control" name="address1" />
						<label>Address 2: </label><input type="text" id="address2" class="form-control" name="address2" />
						<label>City: </label><input type="text" id="city" class="form-control" name="city" />
						<label>State: </label><input type="text" id="state" class="form-control" name="state" />
						<label>Zip: </label><input type="text" id="zip" class="form-control" name="zip" />
						<label>Phone: </label><input type="text" id="phone" class="form-control" name="phone" />
						<label>Email: </label><input type="email" id="email" class="form-control" name="email" />
				</div>
				</hr>
				<div class="col-md-12">
					<h3>Order Item</h3>
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
				</div>
				<input type="submit" name="submit" class="btn btn-primary pull-right" value="Save Details & Proceed to Payment">
			</form>
		</div> -->
		<div class="col-md-12">
			<div class="panel-group" id="accordion">
				<div class="panel panel-default">
				    <div class="panel-heading">
				      <h3 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
				        Validate Product</a>
				      </h3>
				    </div>
				    <div id="collapse3" class="panel-collapse collapse in">
				      	<div class="panel-body">
				      		<p class="col-md-12" >Just Enter your Area Zip Code to validate selected product.</p>
				      		<div class="col-md-6">
				      			<input type="text" name="zip" id="validate_cart" class="form-control"/>
				      		</div>
				      		<div class="col-md-6">
				      			<button class="btn btn-primary btn-lg" onclick="Validate.cartProduct($('#validate_cart').val());">Validate Products</button>
				      		</div>
				      	</div>
				    </div>
			  	</div>
			  	<div class="panel panel-default">
				    <div class="panel-heading">
				      <h3 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" id="validated_pro" href="">
				        Validated Product</a>
				      </h3>
				    </div>
				    <div id="validated_products" class="panel-collapse collapse">
				      	<div class="panel-body">
				      		<div class="table-responsive">
								<table class="table table-hover">
									<tr>
								        <th>Item Description</th>
								        <th>QTY</th>
								        <th style="text-align:right">Item Price</th>
								        <th style="text-align:right">Sub-Total</th>
								        <th>Check</th>
								        <th>&nbsp;</th>
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
									    		<!-- <?php echo form_input(array(
													'name' => $i . '[qty]',
													'value' => $items['qty'],
													'maxlength' => '3',
													'size' => '5',
													'rowid' => $items['rowid'],
													'onfocus' => "$('#check').show()",
													'onblur' => "$('#check').hide()",
													'onchange' => "updateCart(this.value,$(this).attr('rowid'),".$items['id'].");"
												)); ?> <i class="fa fa-check" style="display: none" id="check" aria-hidden="true"></i> -->
											</td>
									        <td style="text-align:right">
									        	<?php echo $this->cart->format_number($items['price']); ?>
									        </td>
									        <td style="text-align:right">
									        $<?php echo $this->cart->format_number($items['subtotal']); ?>
									        </td>
									        <td id="val_pr<?=$items['id']?>"></td>
									        <td>&nbsp;</td>
									    </tr>
									<?php $i++; ?>

									<?php endforeach; ?>

										<tr>
										    <td colspan="4"> </td>
										    <td class="right"><strong>Total</strong></td>
										    <td class="right">
										    	$<?php echo $this->cart->format_number($this->cart->total()); ?>
										    </td>
										</tr>
								</table>
							</div>
							<p id="cart_alert" style="text-align: right;"></p>
							<button type="button" id="proceed_btn" onclick="Validate.processCart($('#validate_cart').val());" style="display: none" class="btn btn-sm btn-primary pull-right">Proceed</button>
				      	</div>
				    </div>
			  	</div>
			  	<div class="panel panel-default">
					    <div class="panel-heading">
					      <h3 class="panel-title">
					        <a data-toggle="collapse" id="f_product" data-parent="#accordion" href="">Final Products</a>
					      </h3>
					    </div>
				    <div id="final_product" class="panel-collapse collapse">
				      
				    </div>
			  	</div>
			  	<div class="panel panel-default">
				    
					    <div class="panel-heading">
					      <h3 class="panel-title">
					        <a data-toggle="collapse" id="address_details" data-parent="#accordion" href="">Please Enter Shipping Address </a>
					      </h3>
					    </div>
					<form action="" method="post">
					    <div id="input_addr" class="panel-collapse collapse">
					      	<div class="panel-body">
							     <div class="col-md-6">
									<h3><b>Billing Address</b></h3>
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
									<h3><b>Shipping Address</b></h3>
									<input type="checkbox" onchange="setBillingAddress(this.id);" id="copy_address"> <label for="copy_address"> Same as Billing Address</label>
									<hr/>
									<label>First Name: </label><input type="text" id="first_name" class="form-control" name="first_name" />
									<label>Last Name: </label><input type="text" id="last_name" class="form-control" name="last_name" />
									<label>Address 1: </label><input type="text" id="address1" class="form-control" name="address1" />
									<label>Address 2: </label><input type="text" id="address2" class="form-control" name="address2" />
									<label>City: </label><input type="text" id="city" class="form-control" name="city" />
									<label>State: </label><input type="text" id="state" class="form-control" name="state" />
									<label>Zip: </label><input type="text" readonly id="zip" class="form-control" name="zip" />
									<label>Phone: </label><input type="text" id="phone" class="form-control" name="phone" />
									<label>Email: </label><input type="email" id="email" class="form-control" name="email" />
									<input type="hidden" id="asso_vendors" name="vendors"/>
								</div>
								<div class="col-md-12" style="margin-top: 20px;">
									<input type="submit" name="submit" class="btn btn-primary pull-right" value="Save Address & Validate Products">
								</div>
							</div>
					    </div>
					</form>
			  	</div>
			</div>
		</div>
	</div>
	
</section>