<div class="container">
	<h1 style="text-align: center;">Units</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<p>view units</p>
            <form method="POST">
            Select Property ID: <select id="property_select" name="property_id">
		    <option name="property_id">Select Property</option>
		        <?php foreach($properties as $property): ?>
			        <option value="<?php echo $property['property_id']; ?>"><?php echo $property['property_id']; ?> </option>
		        <?php endforeach; ?>
	        </select>
            <input type="submit" name="submit" value="go">
            </form>
			<table class="renter-table">
				<tr>
					<th>unit_id</th>
					<th>property_id</th>
					<th>unit_num</th>
					<th>rent</th>
					<th>request_active</th>
				</tr>
                <?php
                    if(isset($_POST['submit'])){
                        foreach($units as $unit){
                            if($unit['property_id'] === $_POST['property_id']){
                                echo '<tr';
                                echo '<td>'. $unit['unit_id'].'</td>';
                                echo '<td>'. $unit['property_id'].'</td>';
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
			<p>update unit</p>
</div>
</div>
</div>