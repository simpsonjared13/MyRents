<div class="container">
	<div class="wrapper_1">
		<div class="homepage_box_left">
			<p>finances</p>
		</div>


		<div class="homepage_box_right">
			<p>properties</p>
			<table class="renter-table">
				<tr>
					<th>property_id</th>
					<th>address</th>
					<th>city</th>
					<th>state</th>
					<th>zip</th>
				</tr>
				<?php foreach($properties as $property): ?>
					<tr>
						<td><?php echo $property['property_id']; ?></td>
						<td><?php echo $property['address']; ?></td>
						<td><?php echo $property['city']; ?></td>
						<td><?php echo $property['state']; ?></td>
						<td><?php echo $property['zip']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>

	<div class="wrapper_2">
		<div class="homepage_box_left">
			<p>tenants</p>
			<table class="renter-table">
				<tr>
					<th>user_id</th>
					<th>first_name</th>
					<th>last_name</th>
					<th>phone</th>
					<th>email</th>
				</tr>
				<?php foreach($tenants as $tenant): ?>
					<tr>
						<td><?php echo $tenant['user_id']; ?></td>
						<td><?php echo $tenant['first_name']; ?></td>
						<td><?php echo $tenant['last_name']; ?></td>
						<td><?php echo $tenant['phone']; ?></td>
						<td><?php echo $tenant['email']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>

		</div>

		<div class="homepage_box_right">
			<p>requests</p>
		</div>
	</div>
</div>