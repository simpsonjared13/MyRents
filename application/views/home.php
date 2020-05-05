<div class="container">
<?php
$mortage_expenses = 0;	$upkeep_expenses = 0;	$mainenance_costs = 0;	$income = 0;	$profit = 0;
foreach ($finances->result() as $row) {
	//Set initial monthly cost of upkeep and mortgage
	$mortage_expenses+= $row->recurring_expenses;
	$upkeep_expenses+= $row->upkeep_cost;
}
foreach ($payments->result() as $row) {
	//Increase income for each rental payment by a tenant
	$income += $row->amount_paid;
}
foreach ($request_costs->result() as $row) {
	//Increase income for each rental payment by a tenant
	$mainenance_costs += $row->request_cost;
}
//Get the time of now
$now = new DateTime();

//Get the Jan 1st of this year
$this_year = new DateTime();
$this_year= $this_year->format("Y"); 
$this_year = new DateTime($this_year."-01-01 00:00:00");
//Get the difference in months of the start of the year and this current month
$months = $now->diff($this_year, TRUE);
//Set increment mortgage and upkeep expenses by the amount of monthes that have passed
$mortage_expenses *= intval($months->m);
$upkeep_expenses*= intval($months->m);
//Set profit based on expenses and income
$profit = $profit - $mortage_expenses - $upkeep_expenses - $mainenance_costs + $income;
?>
	<div class="wrapper_1">
		<div class="homepage_box_left">
			<h3>Year to Date Overview, <?php echo $this_year->format("Y"); ?></h3>
		<?php
			if($payments->num_rows() > 0){

		?>	
			<table class="renter-table">
				<tr>
					<th>Mortage Expenses</th>
					<th>Upkeep Costs</th>
					<th>Maintenance Costs</th>
					<th>Income</th>
					<th>Profit</th>
				<tr>
				<tr>
					<td><?php echo $mortage_expenses ?></td>
					<td><?php echo $upkeep_expenses ?></td>
					<td><?php echo $mainenance_costs ?></td>
					<td><?php echo $income ?></td>
					<td><?php echo $profit ?></td>
				</tr>
			</table>
		<?php
			}
			else{
		?>
			<h3>You have no financial information from this year <?php echo $this_year->format("Y"); ?></h3>
		<?php
			}
		?>
		</div>


		<div class="homepage_box_right">
			<h3>Properties</h3>
			<table class="renter-table">
				<tr>
					<th>Property ID</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
					<th>Rent Income</th>
					<th>Recurring Expenses</th>
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
			<h3>Tenants</h3>
			<table class="renter-table">
				<tr>
					<th>User ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Telephone</th>
					<th>Email</th>
					<th>Property ID</th>
					<th>Unit ID</th>

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
			<h3>Active Requests</h3>
			<table class="renter-table">
				<tr>
					<th>Request ID</th>
					<th>Unit ID</th>
					<th>Request Type</th>
					<th>Comments</th>
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
			<p>Complete Request</p>
			<form name="complete_request" method="POST" action="complete_request">
				Select Request ID: <select id="request_select" name="request_select">
					<option value="">Select Request</option>
					<?php foreach($requests as $reqest): ?>
						<option name="<?php echo $request['request_id']; ?>"><?php echo $request['request_id']; ?> </option>
					<?php endforeach; ?>
				</select>
				<br>
				Cost of Request: <input type="number" name="request_cost"></input>
				<br>
				<input class="submit-button" type="submit" name="submit" value="Complete">
			</form>
		</div>
	</div>
</div>