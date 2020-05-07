<?php
//echo print_r($properties);
?>
<div class="container">
	<h1 style="text-align: center;">Payments</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<h3>Pay</h3>
		</div>


	</div>

	<div class="wrapper_2">
		<div class="box_second_row">
			<h3>View Payments</h3>
			<?php //echo print_r($payments->result()); ?>
			<table class="renter-table">
				<tr>
					<th>Date Paid</th>
					<th>Amount Paid</th>
				</tr>
			<?php
			foreach ($payments->result() as $row) {
				$date = new DateTime($row->date_paid);


			?>
				<tr>
					<td><?php echo $date->format("m/d/y"); ?></td>
					<td><?php echo $row->amount_paid; ?></td>

						
				</tr>

			<?php		
			}
			?>
			</table>

		</div>

	</div>
</div>
