<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container" style="padding: 0 10%">
			<h3>Please Let Us know More About You..</h3>
			<form action="<?= base_url('vendor/Vendorfunction/vendor/complete_registration') ?>" method="post">
				<div class="col-md-12">
					<input type="text" class="form-control" disabled value="<?= $current_user_details->email ?>">
				</div>
				<div class="col-md-6">
					<input type="text" name="first_name" value="<?= ($current_user_details->first_name)? $current_user_details->first_name : '' ?>" placeholder="First Name" class="form-control">
				</div>
				<div class="col-md-6">
					<input type="text" name="last_name" value="<?= ($current_user_details->last_name)? $current_user_details->last_name : '' ?>" placeholder="Last Name" class="form-control">
				</div>
				<div class="col-md-12">
					<input type="text" name="address" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->address : '' ?>" placeholder="Street Address" class="form-control">
				</div>
				<div class="col-md-6">
					<input type="text" name="city" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->city : '' ?>" placeholder="City" class="form-control">
				</div>
				<div class="col-md-6">
					<input type="text" name="zip" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->zip : '' ?>" placeholder="ZIP" class="form-control">
				</div>
				<div class="col-md-6">
					<input type="text" name="country" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->country : '' ?>" placeholder="Country" class="form-control">
				</div>
				<div class="col-md-6">
					<input type="text" name="state" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->state : '' ?>" placeholder="State" class="form-control">
				</div>
				<div class="col-md-6">
					<input type="text" name="phone" value="<?= ($current_user_details->phone)? $current_user_details->phone : '' ?>" placeholder="Phone No." class="form-control">
				</div>
				<div class="col-md-6">
					<input type="text" name="website" placeholder="Website" class="form-control">
				</div>
				<div class="col-md-12">
					<input type="text" name="area_pin" value="<?php if(isset($vendor_zips)) { echo implode(",",$vendor_zips); } ?>" class="form-control" placeholder="Please enter ZIP code where you can delever product">
					<p class="text-info pull-right">Add multipe ZIP by <code>&#44;</code> seperated</p>
				</div>
				<input type="submit" name="submit" value="<?= (isset($vendor_edit) && $vendor_edit) ? 'Update Profile' : 'Complete Registration' ?>" class="btn btn-lg btn-primary pull-right">
			</form>
		    <?php if (validation_errors()) { ?>
		        <div class="col-md-12 pull-right"><div class="alert alert-danger" style="padding:5px;margin:0;"><?= validation_errors(); ?></div></div>
		    <?php } ?>
		</div>
	</div>
</div>