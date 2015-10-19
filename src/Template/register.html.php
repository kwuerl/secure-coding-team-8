<?php $t->extend("base.html.php"); ?>

<?php $t->block("body", function ($t) { ?>
	<h1>Register an account</h1>
	<form>
		<table>
			<tr>
				<td><label for="register[forename]">Forename:</label></td>
				<td><input type="text" name="register[forename]" required></td>
			</tr>
			<tr>
				<td><label for="register[name]">Name:</label></td>
				<td><input type="text" name="register[name]" required></td>
			</tr>
			<tr>
				<td><label for="register[email]">E-Mail:</label></td>
				<td><input type="email" name="register[email]" required></td>
			</tr>
			<tr>
				<td><label for="register[password]">Password:</label></td>
				<td><input type="password" name="register[password]" required></td>
			</tr>
		</table>
		<input type="submit" value="Register">
	</form>
<?php });