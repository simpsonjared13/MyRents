<?php
//echo print_r($tenants);
?>
<div class="container">
	<h1 style="text-align: center;">Tenants</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
		<?php	
		if($properties != null){
		?>
			<h3>Insert New Tenant</h3>
			<form method="POST" action="registerTenant">
				<input type="text" name="first_name" placeholder="first name" required>
				<input type="text" name="last_name" placeholder="last name" required>
				<input type="text" name="username" placeholder="username" required>
				<input type="text" name="email" placeholder="email" required>
				<input type="text" name="phone" placeholder="203-987-6543">
				Date Moved-In:<input type="date" name="date">

			<?php
			$previous_property_id = null;
			$property_select_string = '';
			$unit_select_string = '';
			$unique_prop_ids = array();
			array_push($unique_prop_ids, $properties[0]['property_id']);
			foreach ($properties as $key => $value) {
				//Base case, first condition of the loop
				if($previous_property_id == null){
					$property_select_string .= 
					'<select name="property_id" id="property" onchange="changeUnits()">
						<option  value="'. $properties[$key]['property_id'] .'">'.$properties[$key]['address'].' '.$properties[$key]['city'].'</option>';
					$unit_select_string .= 
					'Unit Number: <select name="select_unit_prop_id_'. $properties[$key]['property_id'] .'" id="unit_'. $properties[$key]['property_id'] .'" style="display:inline-block;">
						<option value="'. $properties[$key]['unit_id'] .'">'.$properties[$key]['unit_num'].'</option>';
				}
				//If the unit belongs to the same property
				else if($previous_property_id == $properties[$key]['property_id']){
					$unit_select_string .= '<option value="'. $properties[$key]['unit_id'] .'">'.$properties[$key]['unit_num'].'</option>';
				}
				//If unit is a part of a differnt property
				else{
					$property_select_string .= '<option value="'. $properties[$key]['property_id'] .'">'.$properties[$key]['address'].' '.$properties[$key]['city'].'</option>';
					$unit_select_string .= 
					'</select>
					<select name="select_unit_prop_id_'. $properties[$key]['property_id'] .'" id="unit_'. $properties[$key]['property_id'] .'" style="display:none">
						<option value="'. $properties[$key]['unit_id'] .'">'.$properties[$key]['unit_num'].'</option>';
					array_push($unique_prop_ids, $properties[$key]['property_id']);
				}
				//Sets previous variable to this key for the next round of logic testing
				$previous_property_id = $properties[$key]['property_id'];
			}
			//Ends the entire property select tag
			$property_select_string .= '</select>';
			//Ends the last unit select tag
			$unit_select_string .= '</select>';
			//Adds these HTML tags to the page
			echo $property_select_string . $unit_select_string;
			?>
			<!-- Adds a hidden input for determining which unit select tag to use for inserting the tenant to -->
			<input type="text" id="unit_chosen" name="unit_chosen" value="select_unit_prop_id_<?php echo $properties[0]['property_id'] ?>" hidden>
			<?php
		}
		else{
			echo "You have no properties. Please insert a property first.";
		}
			?>
				<input class="submit-button" type="submit" name="Submit">
			</form>
		</div>


	</div>

	<div class="wrapper_2">
		<div class="box_second_row">
			<h3>View and Update</h3>
			<table class="renter-table">
				<tr>
					<th>ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Telephone</th>
					<th>Email</th>
					<th>Address</th>
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
						<td><?php echo $tenant['property_id']; ?></td>
						<td><?php echo $tenant['unit_id']; ?></td>
						<form action="removeTenant" method="POST">
							<input type="text" name="user_id" value="<?php echo $tenant['user_id']; ?>" hidden>
							<input type="text" name="unit_id" value="<?php echo $tenant['unit_id']; ?>" hidden>
							<input type="text" name="property_id" value="<?php echo $tenant['property_id']; ?>" hidden>
							<td><input class="submit-button" type="submit" name="submit" value="Remove Tenant"></td>
						</form>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>

	</div>
</div>
<script type="text/javascript">
	//Function to hide the unit select tags if their property is not selected
	function changeUnits(){
		var json = <?php echo json_encode($unique_prop_ids); ?>;
		var property_id = document.getElementById('property').value;
		var element = document.getElementById('unit_'+property_id);
		document.getElementById('unit_chosen').value = "select_unit_"+property_id
		element.style.display = "inline-block";
		//console.log(json);
		//console.log(element);
		for (var i = 0; i < json.length; i++) {
			if(json[i] != property_id){
				var element = document.getElementById('unit_'+json[i]);
				element.style.display = "none";
			}
		}
	}
</script>