<?php foreach ($properties as $key => $value) {
	echo print_r($properties[$key]);
	//echo $properties[$key]['property_id'];
	echo "<br>";
} ?>
<?php //echo print_r($properties); ?>
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
			<?php
			$previous_property_id = null;
			$property_select_string = '';
			$unit_select_string = '';
			$unique_prop_ids = array();
			array_push($unique_prop_ids, $properties[0]['property_id']);
			foreach ($properties as $key => $value) {
				//Base case, first condition of the loop
				if($previous_property_id == null){
					$property_select_string .= '<select name="property_id" id="property" onchange="changeUnits()"><option  value="'. $properties[$key]['property_id'] .'">'.$properties[$key]['address'].' '.$properties[$key]['city'].'</option>';
					$unit_select_string .= '<select name="select_unit_prop_id_'. $properties[$key]['property_id'] .'" id="unit_'. $properties[$key]['property_id'] .'" style="display:inline-block;"><option value="'. $properties[$key]['unit_id'] .'">'.$properties[$key]['unit_num'].'</option>';
				}
				//If the unit belongs to the same property
				else if($previous_property_id == $properties[$key]['property_id']){
					$unit_select_string .= '<option value="'. $properties[$key]['unit_id'] .'">'.$properties[$key]['unit_num'].'</option>';
				}
				else{
					$property_select_string .= '<option value="'. $properties[$key]['property_id'] .'">'.$properties[$key]['address'].' '.$properties[$key]['city'].'</option>';
					$unit_select_string .= '</select><select name="select_unit_prop_id_'. $properties[$key]['property_id'] .'" id="unit_'. $properties[$key]['property_id'] .'" style="display:none"><option value="'. $properties[$key]['unit_id'] .'">'.$properties[$key]['unit_num'].'</option>';
					array_push($unique_prop_ids, $properties[$key]['property_id']);
				}
			?>

				<!-- <select name="property_id">
					<option value="">Property 1</option>
					<option value="">Property 2</option>
				</select>
				<select name="unit_id">
					<option value="">Unit 1</option>
					<option value="">Unit 2</option>
				</select> -->
			<?php
				$previous_property_id = $properties[$key]['property_id'];
			}
			$property_select_string .= '</select>';
			$unit_select_string .= '</select>';
			echo $property_select_string . $unit_select_string;
			?>
			<input type="text" id="unit_chosen" name="unit_chosen" value="select_unit_prop_id_<?php echo $properties[0]['property_id'] ?>.">
			<?php
		}
		else{
			echo "You have no properties. Please insert a property first.";
		}
			?>

				<input type="submit" name="Submit">
			</form>
		</div>


	</div>

	<div class="wrapper_2">
		<div class="box_second_row">
			<p>view and update</p>
		</div>

	</div>
</div>
<script type="text/javascript">
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