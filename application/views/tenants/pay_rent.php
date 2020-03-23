<?php
echo print_r($payment);
echo print_r($billing);
?>
<div class="container">
	<h1 style="text-align: center;">Payments</h1>
	<div class="wrapper_1">
		<div class="box_first_row">
			<h3>Pay Rent</h3>
			<form method="POST" action="payRentFinalize">
				<input type="text" name="first_name" value="<?php echo $this->session->userdata('first_name'); ?>">
				<input type="text" name="last_name" value="<?php echo $this->session->userdata('last_name'); ?>">
				<input type="text" name="address" value="<?php echo $billing->address ?>">
				<input type="text" name="city" value="<?php echo $billing->city ?>">
				<input type="text" name="state" value="<?php echo $billing->state ?>">
				<input type="text" name="zip" value="<?php echo $billing->zip ?>">
				<input type="text" name="country" value="<?php echo $billing->country ?>" placeholder="country">
				<input type="text" name="credit_number" placeholder="Credit Card Number">
				<input type="text" name="credit_cvv" placeholder="CVV" size="3">
				<input type="text" name="credit_expiration" placeholder="02/01" size="5">

				<input type="text" name="payment_id" value="<?php echo $payment['payment_id'] ?>" hidden>
				<input type="text" name="rent" value="<?php echo $payment['rent'] ?>" hidden>

				<input type="submit" name="submit" value="Pay">
			</form>
		</div>
	</div>
</div>