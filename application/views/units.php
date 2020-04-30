<div class="container">
	<h1 style="text-align: center;">Units</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<h3>filtering by property_id displays all units regardless of selection, i'll try to figure it out</h3>
			<p>view units</p>
            <form method="POST">
            Select Property ID: <select id="property_select" name="property_id_select" method="POST">
		    <option name="property_id">Select Property</option>
		        <?php foreach($properties as $property): ?>
			        <option value="<?php echo $property['property_id']; ?>"><?php echo $property['property_id']; ?> </option>
		        <?php endforeach; ?>
	        </select>
            <input class="submit-button" type="submit" name="submit" value="go" method="POST">
            </form>
			<table class="renter-table">
				<tr>
					<th>Property ID</th>
					<th>Unit ID</th>
					<th>Unit Number</th>
					<th>Rent</th>
					<th>Active Request</th>
				</tr>
                <?php
                    if(isset($_POST['submit'])){
						$property_id=$_POST['property_id_select'];
                        foreach($units as $unit){
							$unit_property_id=$unit['property_id'];
                            if($unit_property_id = $property_id){
                                echo '<tr>';
                                echo '<td>'. $unit['property_id'].'</td>';
                                echo '<td>'. $unit['unit_id'].'</td>';
                                echo '<td>'. $unit['unit_num'].'</td>';
                                echo '<td>'. $unit['rent'].'</td>';
                                echo '<td>'. $unit['request_active'].'</td>';
                                echo '</tr>';
                            }
                        }
                    }
                ?>
			</table>
		</div>
	</div>
	<div class="wrapper_2">
		<div class="box_second_row">
			<h2>wip</h2>
			<p>update unit</p>
			<form method="POST" action="update_unit">
            Select Unit ID: <select id="unit_select" name="unit_id" method="POST">
		    <option name="">Select Unit</option>
		        <?php foreach($units as $unit): ?>
			        <option value="<?php echo $unit['unit_id']; ?>"><?php echo $unit['unit_id']; ?> </option>
		        <?php endforeach; ?>
	        </select>
			Update Rent: <input type="number" name="rent">
            <input class="submit-button" type="submit" name="submit2" value="update">
            </form>
</div>
</div>
</div>