<div class="main main-raised">
	<div class="profile-content" style="padding:3%">
		<div class="container">
			<div class="row">
				<h2>List Of Vendors</h2>
				<table class="table">
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>City</th>
						<th>Email</th>
						<th>Status</th>
						<th>View</th>
					</tr>
					<?php foreach ($vendors as $vendor) { ?>
						<tr>
							<td><?= $vendor->id ?></td>
							<td><?= ($vendor->get_full_name() != ' ') ? $vendor->get_full_name() : '-' ?></td>
							<td><?= ($vendor->user_profile) ? $vendor->user_profile->city : '-' ?></td>
							<td><?= $vendor->email ?></td>
							<td>
								<select name="vendor_status" onchange="Vandor.deleteVendor('<?= $vendor->id ?>')">
									<option value="0" <?= ($vendor->active == 0) ? 'selected' : '' ?> >Inactive</option>
									<option value="1" <?= ($vendor->active == 1) ? 'selected' : '' ?> >Active</option>
								</select>
							</td>
							<td><a href="<?= base_url('backend/Allfunction/vendor_details/'.$vendor->id) ?>">View</a></td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>
</div>