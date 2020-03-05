<h1 class="header">Register Renter Page</h1>
<br>
<div class="Register">
	<form method="POST" action="registerRenter">
		<input type="text" name="first_name" placeholder="first name" required><br>
		<input type="text" name="last_name" placeholder="last name" required><br>
		<input type="text" name="username" placeholder="username" required><br>
		<input type="text" name="email" placeholder="email" required><br>
		<!-- <input type="tel" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="203-000-0000" required><br>	 -->
		<input type="text" name="phone" placeholder="203-987-6543"><br>
		<input type="password" name="password" id="password" placeholder="password" required><br>
		<input type="password" name="confirm_password" id="confirm_password" placeholder="confirm password" required><br>
		<input type="submit" name="submit" value="Register">
	</form>
</div>
