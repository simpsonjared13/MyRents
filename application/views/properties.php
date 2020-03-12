<div class="container">
	<h1 style="text-align: center;">Properties</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<p>insert properties</p>
			<form Method="POST" action="insert_property">
				Address:<input type="text" name="address">
				City:<input type="text" name="city">
				State:<input type="text" name="state">
				County:<input type="text" name="county">
				Zip:<input type="text" name="zip">
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
					<th>property_id</th>
					<th>address</th>
					<th>city</th>
					<th>state</th>
					<th>zip</th>
				</tr>
				<?php foreach($properties as $property): ?>
					<tr>
						<td><?php echo $property['property_id']; ?></td>
						<td><?php echo $property['address']; ?></td>
						<td><?php echo $property['city']; ?></td>
						<td><?php echo $property['state']; ?></td>
						<td><?php echo $property['zip']; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
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
				h.insertAdjacentHTML("afterbegin", str);	
			}
			else{
				h.innerHTML = '';
				h.insertAdjacentHTML("afterbegin", str);	
			}
		}
	}
</script>