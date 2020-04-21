<div class="container">
	<h1 style="text-align: center;">Properties</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<p>insert properties</p>
			<form Method="POST" action="insert_property">
				Address:<input type="text" name="address">
				City:<input type="text" name="city">
				State:<input type="text" name="state">
				Country:<input type="text" name="country">
				Zip:<input type="text" name="zip">
				Date Acquired:<input type="date" name="date">
				Number of Units:<select id="units" name="num_units" onchange="unitsStuff()">
			<?php
				for($i = 0; $i <= 5; $i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			?>
				</select>
				<br>
			<div class="hidden" id='property_units'>
				<div id="inputs">
				</div>
			</div>

				<input type="submit" name="subimt">
			</form>
		</div>


	</div>

	<div class="wrapper_2">
		<div class="box_second_row">
			<p>view and update</p>
			<table class="renter-table">
				<tr>
					<th>ID</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
					<th>Country</th>
					<th>Income</th>
					<th>Expenses</th>
					<th>Upkeep Cost</th>
					<th>Number of Units</th>
				</tr>
				<?php foreach($properties as $property): ?>
					<tr>
						<td><?php echo $property['property_id']; ?></td>
						<td><?php echo $property['address']; ?></td>
						<td><?php echo $property['city']; ?></td>
						<td><?php echo $property['state']; ?></td>
						<td><?php echo $property['zip']; ?></td>
						<td><?php echo $property['country']; ?></td>
						<td><?php echo $property['rent_income']; ?></td>
						<td><?php echo $property['recurring_expenses']; ?></td>
						<td><?php echo $property['upkeep_cost']; ?></td>
						<td><?php echo $property['num_units']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
			
<script type="text/javascript">
	function unitsStuff(){
		var element = document.getElementById('units').value;
		if(element > 0){
			var str ='';
			for (var i = 1; i <= element; i++) {
				str += 'Unit Number:<input type="text" name="unit_num_'+i+'">\
						Rent:<input type="text" name="rent_'+i+'"><br>';
			}
			var h = document.getElementById("property_units");
			var inputs = document.getElementById("inputs");
			if(inputs == null){
				inputs.insertAdjacentHTML("afterbegin", str);	
			}
			else{
				inputs.innerHTML = '';
				inputs.insertAdjacentHTML("afterbegin", str);	
			}
		}
	}
</script>


<h2>update property</h2>
<form name="update_prop" method="POST" action="update_property">
	Property ID: <select id="property_select" name="property_select">
		<option value="">Select Property</option>
		<?php foreach($properties as $property): ?>
			<option name="<?php echo $property['property_id']; ?>"><?php echo $property['property_id']; ?> </option>
		<?php endforeach; ?>
	</select>
	Number of Units: <input type="text" name="num_units">
	Upkeep Costs: <input type="text" name="upkeep_cost">
	Rental Income: <input type="text" name="rent_income">
	Recurring Expense: <input type="text" name="recurring_expenses">
	<input type="submit" name="submit">
</form>
</div>
</div>
</div>