<section>
	<div class="row">
		<div class="col-md-12 text-center">
			<h2>Alert</h2>
			<h4>Your Payment has been decline by Bank</h4>
			<?php if ($this->session->flashdata('error')) { ?>
			    <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">x</button> <?= $this->session->flashdata('error') ?> </div>
			<?php } ?>
		</div>
	</div>
</section>