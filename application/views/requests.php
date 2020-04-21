<div class="container">
	<h1 style="text-align: center;">Requests</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<p>Active Requests</p>
            <table class="renter-table">
				<tr>
					<th>request_id</th>
					<th>unit_id</th>
					<th>request_type</th>
					<th>comments</th>
				</tr>
				<?php foreach($active_requests as $request): ?>
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
				<input type="submit" name="submit" value="Complete">
			</form>
		</div>
	</div>
	<div class="wrapper_2">
		<div class="box_second_row">
			<p>Completed Requests</p>
            <table class="renter-table">
				<tr>
					<th>request_id</th>
					<th>unit_id</th>
					<th>request_type</th>
					<th>comments</th>
                    <th>date completed</th>
                    <th>request cost</th>
				</tr>
				<?php foreach($completed_requests as $request): ?>
					<tr>
						<td><?php echo $request['request_id']; ?></td>
						<td><?php echo $request['unit_id']; ?></td>
						<td><?php echo $request['request_type']; ?></td>
						<td><?php echo $request['comments']; ?></td>
                        <td><?php echo $request['date_completed']; ?></td>
                        <td><?php echo $request['request_cost']; ?></td>
					</tr>
				<?php endforeach; ?>
            </table>
</div>
</div>
</div>