<section>
	<div class="container">
		<h2 class="text-center">SignUp</h2>
		<hr>
		<form action="" method="post">
			<h3>Account Information</h3>
			<div class="row" style="margin-bottom: 20px;">
				<div class="col-md-12">
					<div class="col-md-6">
						<label>Email Id</label>
						<input type="email" name="mail_id" required class="form-control">
					</div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 20px;">
				<div class="col-md-12">
					<div class="col-md-6">
						<label>Password</label>
						<input type="password" name="password" required class="form-control">
					</div>
					<div class="col-md-6">
						<label>Confirm Password</label>
						<input type="password" name="confirm_password" required class="form-control">
					</div>
				</div>
			</div>
			<h3>Billing Information</h3>
			<div class="row" style="margin-bottom: 20px;" >
				<div class="col-md-12">
					<div class="col-md-6">
						<label>First Name</label>
						<input type="text" name="first_name" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Last Name</label>
						<input type="text" name="last_name" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Address Line 1</label>
						<input type="text" name="address1" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Address Line 2</label>
						<input type="text" name="address2" class="form-control">
					</div>
					<div class="col-md-6">
						<label>City</label>
						<input type="text" name="city" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Country</label>
						<input type="text" name="country" class="form-control">
					</div>
					<div class="col-md-6">
						<label>State</label>
						<input type="text" name="state" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Zip</label>
						<input type="text" name="zip" class="form-control">
					</div>
					<div class="col-md-6">
						<label>Phone</label>
						<input type="text" name="phone" class="form-control">
					</div>
				</div>
			</div>
			<input type="submit" class="btn btn-primary pull-right" name="Submit">
		</form>
        <?php if (validation_errors()) { ?>
            <div class="col-md-9 pull-right"><div class="alert alert-danger" style="padding:5px;margin:0;"><?= validation_errors(); ?></div></div>
        <?php } ?>
		<?php if ($this->session->flashdata('message')) { ?>
		    <div class="alert alert-danger" style="margin-bottom:0"><button type="button" class="close" data-dismiss="alert">x</button> <?= $this->session->flashdata('message') ?> </div>
		<?php } ?>
	</div>
</section>