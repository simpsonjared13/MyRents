<div class="container">
	<div class="wrapper_1">
		<div class="homepage_box_left">
			<?php

			$lastPay = array_pop($payments);
			$currentDateTime = new DateTime();
			$lastPayment = new DateTime($lastPay["date_paid"]);
			$rentDue = new DateTime($lastPayment->format("Y-m-d h:m:s"));
			$rentDue->modify("+1 month");
			$rentDue->modify($rentDue->format("Y-m"));


			//if($currentDateTime > )
			//echo "<p>" . $lastPayment->format("m/d/y") . "</p>";
			// echo "<p>" . $rentDue->format("m/d/y") . "</p>";
			// echo "<p>" . $currentDateTime->format("Y-m-d h:m:s") . "</p>";
			?>
			<h3>Next Rent Due Date</h3>
			<?php //echo print_r($payments); ?>
			<table class="renter-table">
				<tr>
					<th>Rent Due</th>
					<th>Date Due</th>
				</tr>
				<tr>
					<td><?php echo $lastPay["rent"]; ?></td>
					<td><?php echo $rentDue->format("m/d/y"); ?></td>
				</tr>
			</table>
			<form method="GET" action="payRent">
				<input type="text" name="payment_id" value="<?php echo $lastPay["payment_id"] ?>" hidden>
				<input type="text" name="rent" value="<?php echo $lastPay["rent"] ?>" hidden>
				<input type="text" name="due_date" value="<?php echo $rentDue->format("Y-m-d h:m:s") ?>" hidden>
				<input class="submit-button" type="submit" name="submit" value="Proceed to Pay">
			</form>


		</div>


		<div class="homepage_box_right">
			<h3>Make Request</h3>
			<form method="POST" action="create_request">
				Select Request Type:<select name="request_type">
					<option value=""></option>
					<option value="general">General Maintenance</option>
					<option value="broken">Broken Appliance</option>
					<option value="inspection">Inspection</option>
					<option value="preventative">Preventative Maintenance</option>
					<option value="other">Other</option>
				</select>
				<br>
				Additional Comments: <input type="text" name="comments">
				<input class="submit-button" type="submit">
			</form>
			<button class="button" onclick="view_requests()" id="click_requests">Click to View all Requests</button>
			<div id="tenant_requests"></div>
		</div>
	</div>
<script type="text/javascript">
	function view_requests(){
		var x = document.getElementById("tenant_requests");
		var table_data="<table class='renter-table'>\
		<tr><th>Request Type</th> <th>Comments</th> <th>Date Completed</th></tr>\
		<?php foreach($requests as $request): ?>\
					<tr>\
						<td><?php echo $request['request_type']; ?></td>\
						<td><?php echo $request['comments']; ?></td>\
						<td><?php echo $request['date_completed']; ?></td>\
					</tr>\
				<?php endforeach; ?>\
		</tr></table>";
		if(x.innerHTML===""){
			x.innerHTML=table_data;
		}
	}
</script>

<!-- 	<div class="wrapper_2">
		<div class="homepage_box_left">
			<p>tenants</p>


		</div>

		<div class="homepage_box_right">
			<p>requests</p>


		</div>
	</div> -->
</div>