<?php
//echo print_r($payments->result());
echo print_r($finances->result());

?>
<div class="container">
	<h1 style="text-align: center;">Finances</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<p>insert properties</p>
		</div>


	</div>

	<div class="wrapper_2">
		<div class="box_second_row">
			<h3>View Year to Date Payments</h3>
			<table>
				<tr>
					<th>Tenant Name</th>
					<th>Property</th>
					<th>Unit Number</th>
					<th>Amount Paid</th>
					<th>Date Paid</th>
				</tr>
			<?php foreach ($payments->result() as $row) {
				$date = new DateTime($row->date_paid);
			?>
				<tr>
					<td><?php echo $row->first_name . " " . $row->last_name; ?></td>
					<td><?php echo $row->address . " " . $row->city; ?></td>
					<td><?php echo $row->unit_num; ?></td>
					<td><?php echo $row->amount_paid; ?></td>
					<td><?php echo $date->format("m/d/y"); ?></td>
				</tr>

			<?php	
			}
			?>
			</table>
		</div>

	</div>
</div>