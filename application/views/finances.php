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

	foreach ($payments->result() as $row) {
		$income += $row->amount_paid;
	}

$profit = $profit - $mortage_expenses - $upkeep_expenses - $mainenance_costs;

if($this->input->get('date') != null){
	echo "not null";
	var_dump($this->input->get('date'));
}
else{
	echo "null";
	var_dump($this->input->get('date'));
}

$this_year = new DateTime();
$this_year= $this_year->format("Y"); 
$this_year = new DateTime($this_year."-01-01 00:00:00");

$last_year = new DateTime($this_year->format("Y-m-d h:m:s"));
$last_year = $last_year->modify("-1 year");
$last_year = $last_year->format("Y-m-d h:m:s"); 

$next_year = new DateTime($this_year->format("Y-m-d h:m:s"));
$next_year = $next_year->modify("+1 year");
$next_year = $next_year->format("Y-m-d h:m:s"); 

$this_year= $this_year->format("Y-m-d h:m:s"); 
echo $this_year . "<br>";
echo $last_year . "<br>";
echo $next_year . "<br>";

?>
<div class="container">
	<h1 style="text-align: center;">Finances</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<h3>Year to Date Overview</h3><Br>
			<form action="finances" method="GET">
				Change Year<input type="date" name="date"><br>
				<button>Submit</button>
			</form>
			<table>
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
		</div>


	</div>

	<div class="wrapper_2">
		<div class="box_second_row">
			<h3>View Year to Date Payments</h3>
			<table>
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
		</div>

	</div>
</div>