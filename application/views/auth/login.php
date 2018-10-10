<?php if($model) { ?>
<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&cross;</button>
      
						<h3 class="text-center">Login</h3>
    </div>
	    <div class="modal-body">
			<div class="card card-signup">
				<form class="form" method="post" action="<?= base_url('backend/Auth/login/home') ?>">
					<div class="header header-primary text-center">
					</div>
					<div class="content">

						<div class="input-group" style="margin-bottom: 12px;">
							<span class="input-group-addon">
								<i class="material-icons">email</i>
							</span>
							<input type="text" style="height: 44px;" name="identity" class="form-control" placeholder="Email...">
						</div>

						<div class="input-group" style="margin-bottom: 12px;">
							<span class="input-group-addon">
								<i class="material-icons">lock_outline</i>
							</span>
							<input type="password" style="height: 44px;" name="password" placeholder="Password..." class="form-control" />
						</div>
					</div>
					<div class="footer text-center">
						<a href="<?= base_url('sign_up') ?>" class="btn btn-simple btn-primary btn-lg"> Sign Up </a>
						<input type="submit" class="btn btn-primary " value="Login"/>
					</div>
				</form>
				<?php if ($this->session->flashdata('message')) { ?>
				    <div class="alert alert-danger" style="margin-bottom:0"><button type="button" class="close" data-dismiss="alert">x</button> <?= $this->session->flashdata('message') ?> </div>
				<?php } ?>
			</div>
        
	    </div>

	    <div class="modal-footer">
	      
	    </div>
  </div>
</div>
	<?php } else { ?>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
				<div class="card card-signup">
					<form class="form" method="post" action="">
						<div class="header header-primary text-center">
							<h4>Login</h4>
						</div>
						<p class="text-divider">Please Input your Credentials</p>
						<div class="content">

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">email</i>
								</span>
								<input type="text" name="identity" class="form-control" placeholder="Email...">
							</div>

							<div class="input-group">
								<span class="input-group-addon">
									<i class="material-icons">lock_outline</i>
								</span>
								<input type="password" name="password" placeholder="Password..." class="form-control" />
							</div>
						</div>
						
						  <div class="text1">
							<a href="<?= base_url('sign_up') ?>" class="btn btn-simple btn-primary btn-lg"> Sign Up </a>
							<input type="submit" class="btn btn-primary " value="Login"/>
						  </div>	
						
					</form>
					<?php if ($this->session->flashdata('message')) { ?>
					    <div class="alert alert-danger" style="margin-bottom:0"><button type="button" class="close" data-dismiss="alert">x</button> <?= $this->session->flashdata('message') ?> </div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
		<?php } ?>









			
