<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<div class="row">
				<h2>List Of Customers</h2>
				<table class="table">
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>City</th>
						<th>Email</th>
						<th>Status</th>
						<th>View</th>
					</tr>
					<?php foreach ($customers as $customer) { ?>
						<tr>
							<td><?= $customer->id ?></td>
							<td><?= $customer->get_full_name() ?></td>
							<td><?= $customer->user_profile->city ?></td>
							<td><?= $customer->email ?></td>
							<td>
								<select name="vendor_status" onchange="Vandor.deleteVendor('<?= $customer->id ?>')">
									<option value="0" <?= ($customer->active == 0) ? 'selected' : '' ?> >Inactive</option>
									<option value="1" <?= ($customer->active == 1) ? 'selected' : '' ?> >Active</option>
								</select>
							</td>
							<td><a href="<?= base_url('backend/Allfunction/customer_details/'.$customer->id) ?>">View</a></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>