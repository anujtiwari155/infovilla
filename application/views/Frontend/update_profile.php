<section>
	<div class="row" style="margin: 0; padding-left: 15px; padding-right: 15px">
		<div class="col-md-12">
			<div class="container">
				<?php if ($this->session->flashdata('message')) { ?>
				    <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">x</button> <?= $this->session->flashdata('message') ?> </div>
				<?php } ?>
				<form action="" method="post">
					<h3>Account Information</h3>
					<div class="row" style="margin-bottom: 20px;">
						<div class="col-md-12">
							<div class="col-md-6">
								<label>Email Id</label>
								<input type="email" disabled="disabled" value="<?= $current_user_details->email ?>" name="mail_id" required class="form-control">
							</div>
						</div>
					</div>
					<div class="row" style="margin-bottom: 20px;">
						<div class="col-md-12">
							<div class="col-md-6">
								<label>Password</label>
								<input type="password" name="password" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Confirm Password</label>
								<input type="password" name="confirm_password" class="form-control">
							</div>
						</div>
					</div>
					<h3>Billing Information</h3>
					<div class="row" style="margin-bottom: 20px;" >
						<div class="col-md-12">
							<div class="col-md-6">
								<label>First Name <span class="text-danger">*</span></label>
								<input type="text" value="<?= ($current_user_details->first_name)? $current_user_details->first_name : '' ?>" name="first_name" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Last Name</label>
								<input type="text" value="<?= ($current_user_details->last_name)? $current_user_details->last_name : '' ?>" name="last_name" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Address Line 1 <span class="text-danger">*</span></label>
								<input type="text" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->address : '' ?>" name="address1" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Address Line 2</label>
								<input type="text" name="address2" class="form-control">
							</div>
							<div class="col-md-6">
								<label>City <span class="text-danger">*</span></label>
								<input type="text" name="city" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->city : '' ?>" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Country <span class="text-danger">*</span></label>
								<input type="text" name="country" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->country : '' ?>" class="form-control">
							</div>
							<div class="col-md-6">
								<label>State <span class="text-danger">*</span></label>
								<input type="text" name="state" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->state : '' ?>" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Zip <span class="text-danger">*</span></label>
								<input type="text" name="zip" value="<?= ($current_user_details->user_profile)? $current_user_details->user_profile->zip : '' ?>" class="form-control">
							</div>
							<div class="col-md-6">
								<label>Phone <span class="text-danger">*</span></label>
								<input type="text" name="phone" value="<?= ($current_user_details->phone)? $current_user_details->phone : '' ?>" class="form-control">
							</div>
						</div>
					</div>
					<input type="submit" class="btn btn-primary pull-right" name="Update Profile">
				</form>
				<?php if (validation_errors()) { ?>
			        <div class="col-md-12 pull-right"><div class="alert alert-danger" style="padding:5px;margin:0;"><?= validation_errors(); ?></div></div>
			    <?php } ?>
			</div>
		</div>
	</div>
</section>
