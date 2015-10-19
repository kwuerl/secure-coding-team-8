<?php $t->extend("base.html.php"); ?>

<?php $t->block("body", function ($t) { ?>
	<h1>Welcome to our bank!</h1>
	<h2>Login</h2>
	<form>
		<table>
			<tr>
				<td><label for="login[email]">E-Mail:</label></td>
				<td><input type="email" name="login[email]"></td>
			</tr>
			<tr>
				<td><label for="login[password]">Password:</label></td>
				<td><input type="password" name="login[password]"></td>
			</tr>
		</table>
		<input type="submit" value="Login">
	</form>
<?php });