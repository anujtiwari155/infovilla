<div class="main main-raised">
	<div class="profile-content">
		<div class="container">
			<div class="report">
				<div class="row">
					<h3><?= $current_user_details->get_full_name() ?> Report</h3>
					<div class="col-md-12">
						<div class="col-md-3 box">
							<p>Product Added</p>
							<h2><?= count($vender_products) ?></h2>
						</div>
						<div class="col-md-3 box">
							<p>Pending Products</p>
							<h2><?= $pending_products ?></h2>
						</div>
						<div class="col-md-3 box">
							<p>Rejected Product</p>
							<h2><?= $rejected_products ?></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>