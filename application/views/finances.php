<?php
//echo print_r($payments->result());
//echo print_r($finances->result());
$mortage_expenses = 0;
$upkeep_expenses = 0;
$mainenance_costs = 0;
$income = 0;
$profit = 0;
foreach ($finances->result() as $row) {
	$mortage_expenses+= $row->recurring_expenses;
	$upkeep_expenses+= $row->upkeep_cost;
}
//$mortage_expenses *= $payments->num_rows()
foreach ($payments->result() as $row) {
	$income += $row->amount_paid;
}
foreach ($request_costs->result() as $row) {
	//Increase income for each rental payment by a tenant
	$mainenance_costs += $row->request_cost;
}


//echo $payments->num_rows() ."<br>";
$now = new DateTime();
if($this->input->get("date") != null){
	$this_year = new DateTime($this->input->get("date"));
}
else{
	$this_year = new DateTime();
}
$this_year= $this_year->format("Y"); 
$this_year = new DateTime($this_year."-01-01 00:00:00");
$months = $now->diff($this_year, TRUE);
//$months = $months->format("m"); 

$last_year = new DateTime($this_year->format("Y-m-d h:m:s"));
$last_year = $last_year->modify("-1 year");
$last_year = $last_year->format("Y-m-d h:m:s"); 

$next_year = new DateTime($this_year->format("Y-m-d h:m:s"));
$next_year = $next_year->modify("+1 year");
$next_year = $next_year->modify("-1 month");
$next_year = $next_year->format("Y-m-d h:m:s"); 

//$this_year= $this_year->format("Y-m-d h:m:s"); 
// echo $this_year->format("Y-m-d h:m:s") . "<br>";
// echo $last_year . "<br>";
// echo $next_year . "<br>";
// echo $months->m . "<br>";


$mortage_expenses *= intval($months->m);
$upkeep_expenses*= intval($months->m);


$profit = $profit - $mortage_expenses - $upkeep_expenses - $mainenance_costs + $income;

?>
<div class="container">
	<h1 style="text-align: center;">Finances</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<h3>Year to Date Overview, <?php echo $this_year->format("Y"); ?></h3>
			<form action="finances" method="GET">
				Change Year<input type="date" name="date"><br>
				<button class="button"> Submit</button>
			</form>
		<?php
			if($payments->num_rows() > 0){

		?>	
			<table class="renter-table">
				<tr>
					<th>Mortage Expenses</th>
					<th>Upkeep Costs</th>
					<th>Maintenance Costs</th>
					<th>Income</th>
					<th>Profit</th>
				<tr>
				<tr>
					<td><?php echo $mortage_expenses ?></td>
					<td><?php echo $upkeep_expenses ?></td>
					<td><?php echo $mainenance_costs ?></td>
					<td><?php echo $income ?></td>
					<td><?php echo $profit ?></td>
				</tr>
			</table>
		<?php
			}
			else{
			?>
			<h3>You have no information from the year <?php echo $this_year->format("Y"); ?></h3>
			<?php
			}
		?>
		</div>
	</div>

	<div class="wrapper_2">
		<div class="box_second_row">
		<?php
			if($payments->num_rows() > 0){

		?>
			<h3>View Year to Date Payments</h3>
			<table class="renter-table">
				<tr>
					<th>Tenant Name</th>
					<th>Property</th>
					<th>Unit Number</th>
					<th>Amount Paid</th>
					<th>Date Paid</th>
				</tr>
			<?php
				foreach ($payments->result() as $row) {
				$date = new DateTime($row->date_paid);
			?>
				<tr>
					<td><?php echo $row->first_name . " " . $row->last_name; ?></td>
					<td><?php echo $row->address . " " . $row->city; ?></td>
					<td><?php echo $row->unit_num; ?></td>
					<td><?php echo $row->amount_paid; ?></td>
					<td><?php echo $date->format("m/d/y"); ?></td>
				</tr>

			<?php	
				}
			?>
			</table>
		<?php
			}
			else{
		?>
			<h3>You have no information from the year <?php echo $this_year->format("Y"); ?></h3>
		<?php
			}
		?>
		</div>

	</div>
</div>