<?php $t->extend("base.html.php"); ?>

<?php $t->block("body", function ($t) { ?>
<div class="login-box">
	<h1>Register an account</h1>
	<div class="login-box-body">
		<?php $t->formh($t->get("form"), array("action"=>"/processRegistration", "method"=>"post"), function ($t) { ?>
			<div class="form-group has-feedback">
				<label for="form_registration[first_name]">First name</label>
				<input type="text" class="form-control" name="form_registration[first_name]">
			</div>
			<div class="form-group has-feedback">
				<label>Last name</label>
				<input type="text" class="form-control" name="form_registration[last_name]">
			</div>
			<div class="form-group has-feedback">
				<label>E-Mail</label>
				<input type="email" class="form-control" name="form_registration[email]">
            	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<label>Password</label>
				<input type="password" class="form-control" name="form_registration[password]">
            	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<label>Repeat your password</label>
				<input type="password" class="form-control" name="form_registration[password]">
            	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
	            <div class="col-xs-12">
	              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign Up</button>
	            </div><!-- /.col -->
	        </div>
		<?php }); ?>
	</div>
</div>
<?php });