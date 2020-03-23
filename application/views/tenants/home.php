<div class="container">
	<div class="wrapper_1">
		<div class="homepage_box_left">
			<p>Payments</p>

		</div>


		<div class="homepage_box_right">
			<p>Requests</p>
			<p>New Request</p>
			<form method="POST" action="create_request">
				Select Request Type:<select name="request_type">
					<option value=""></option>
					<option value="maintanance">General Maintance</option>
					<option value="broken">Broken Appliance</option>
					<option value="other">Other</option>
				</select>
				Additional Comments: <input type="text" name="comments">
				<input type="submit">
			</form>
			<button onclick="view_requests()" id="click_requests">Click to View all Requests</button>
			<div id="tenant_requests"></div>
		</div>
	</div>
<script type="text/javascript">
	function view_requests(){
		var x = document.getElementById("tenant_requests");
		var table_data="<table>\
		<tr><th>request_type</th> <th>comments</th> <th>date_completed</th></tr>\
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