<div class="container">
	<div class="wrapper_1">
		<div class="homepage_box_left">
			<p>finances</p>
			<table class="renter-table">
				<tr>
					<th>property_id</th>
					<th>request_cost</th>
					<th>rent_total</th>
					<th>upkeep_cost</th>
				</tr>
				<?php foreach($finances as $finance): ?>
					<tr>
						<td><?php echo $finance['property_id']; ?></td>
						<td><?php echo $finance['requests_cost']; ?></td>
						<td><?php echo $finance['rent_total']; ?></td>
						<td><?php echo $finance['upkeep_total']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
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
					<th>rent_income</th>
					<th>recurring_expenses</th>
				</tr>
				<?php foreach($properties as $property): ?>
					<tr>
						<td><?php echo $property['property_id']; ?></td>
						<td><?php echo $property['address']; ?></td>
						<td><?php echo $property['city']; ?></td>
						<td><?php echo $property['state']; ?></td>
						<td><?php echo $property['zip']; ?></td>
						<td><?php echo $property['rent_income']; ?></td>
						<td><?php echo $property['recurring_expenses']; ?></td>
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
					<th>property</th>
					<th>unit_id</th>

				</tr>
				<?php foreach($tenants as $tenant): ?>
					<tr>
						<td><?php echo $tenant['user_id']; ?></td>
						<td><?php echo $tenant['first_name']; ?></td>
						<td><?php echo $tenant['last_name']; ?></td>
						<td><?php echo $tenant['phone']; ?></td>
						<td><?php echo $tenant['email']; ?></td>
						<td><?php echo $tenant['address'] . " " . $tenant['city']; ?></td>
						<td><?php echo $tenant['unit_id']; ?></td>

					</tr>
				<?php endforeach; ?>
			</table>

		</div>

		<div class="homepage_box_right">
			<p>requests</p>
			<table class="renter-table">
				<tr>
					<th>request_id</th>
					<th>unit_id</th>
					<th>request_type</th>
					<th>comments</th>
				</tr>
				<?php foreach($requests as $request): ?>
					<tr>
						<td><?php echo $request['request_id']; ?></td>
						<td><?php echo $request['unit_id']; ?></td>
						<td><?php echo $request['request_type']; ?></td>
						<td><?php echo $request['comments']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>

		</div>
	</div>
</div>