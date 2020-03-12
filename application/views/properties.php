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
				Number of Units:<input type="number" name="num_units">
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