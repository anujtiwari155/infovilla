<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<h3>Welcome to Vendor Panel Of Alcoholic...</h3>
			<hr/>
			<?php if ($this->session->flashdata('message')) { ?>
			    <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">x</button> <?= $this->session->flashdata('message') ?> </div>
			<?php } ?>
			<div class="col-md-8">
				<h4>New to Alcoholic Register Here</h4>
				<form action="<?= base_url('vendor/Vendorfunction/vendor/register') ?>" method="post">
					<div class="col-md-10">
						<input type="text" name="email" onchange="Vandor.validateAddress(this.value)" placeholder="Please enter your mail id" class="form-control">
						<p id="alert_msg_fail" style="text-align: right;color: red;display: none"></p>
						<p id="alert_msg" style="text-align: right;color: green;display: none;"></p>
					</div>
					<div class="col-md-2">
						<button type="button" id="vendor_check_email_btn" class="btn btn-primary">Validate</button>
					</div>
					<div class="col-md-12 nopl nopr" id="main_form_page">
						<div class="col-md-8 text-center">
				          <div class="loader" id="brand_loader"></div>
				        </div>
					</div>
				</form>
				<?php if (validation_errors()) { ?>
			        <div class="col-md-12 pull-right"><div class="alert alert-danger" style="padding:5px;margin:0;"><?= validation_errors(); ?></div></div>
			    <?php } ?>
			</div>
			<div class="col-md-4">
				<h4>Already Registered...</h4>
				<form action="<?= base_url('backend/Auth/login/vendor') ?>" method="post">
					<input type="email" name="identity" placeholder="Email Id" required class="form-control">
					<input type="password" name="password" placeholder="Password" required class="form-control">
					<input type="submit" name="submit" value="Get Started" class="btn btn-xs btn-primary pull-right">
				</form>
			</div>
		    
		</div>
	</div>
</div>