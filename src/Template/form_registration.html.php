<?php $t->extend("base.html.php"); ?>
<?php $t->set("is_login", true); ?>
<?php $t->block("body", function ($t) { ?>
<div class="login-box">
	<div class="login-logo">
        <a><b>Secure</b>Bank</a>
    </div><!-- /.login-logo -->
	<h1>Register an account</h1>
	<div class="login-box-body">
      	<?php $t->flash_echo(); ?>
		<?php $t->formh($t->get("form"), array("action"=>"/register", "method"=>"post"), function ($t) { ?>
			<?php
				$first_name_errors = $t->get("form")->getError("first_name");
				$last_name_errors = $t->get("form")->getError("last_name");
				$email_errors = $t->get("form")->getError("email");
				$password_errors = $t->get("form")->getError("password");
				$password_repeat_errors = $t->get("form")->getError("password_repeat");
			?>
			<div class="form-group has-feedback <?php if (sizeof($first_name_errors) > 0) echo "has-error"; ?>">
				<label for="form_registration[first_name]">First name</label>
				<input type="text" class="form-control" name="form_registration[first_name]" value="<?= $t->s($t->get('form')->getValue('first_name')); ?>" required>
				<?php if (sizeof($first_name_errors) > 0) { ?>
	            	<p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $first_name_errors[0] ?><br></p>
	            <?php } ?>
			</div>
			<div class="form-group has-feedback <?php if (sizeof($last_name_errors) > 0) echo "has-error"; ?>">
				<label for="form_registration[last_name]">Last name</label>
				<input type="text" class="form-control" name="form_registration[last_name]" value="<?= $t->s($t->get('form')->getValue('last_name')); ?>" required>
				<?php if (sizeof($last_name_errors) > 0) { ?>
	            	<p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $last_name_errors[0] ?><br></p>
	            <?php } ?>
			</div>
			<div class="form-group has-feedback <?php if (sizeof($email_errors) > 0) echo "has-error"; ?>">
				<label for="form_registration[email]">E-Mail</label>
				<input type="email" class="form-control" name="form_registration[email]" value="<?= $t->s($t->get('form')->getValue('email')); ?>" required>
            	<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            	<?php if (sizeof($email_errors) > 0) { ?>
	            	<p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $email_errors[0] ?><br></p>
	            <?php } ?>
			</div>
			<div class="form-group has-feedback <?php if (sizeof($password_errors) > 0) echo "has-error"; ?>">
				<label for="form_registration[_password_plain]">Password</label>
				<input type="password" class="form-control" name="form_registration[_password_plain]" value="<?= $t->s($t->get('form')->getValue('_password_plain')); ?>" required>
            	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
            	<?php if (sizeof($password_errors) > 0) { ?>
	            	<p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $password_errors[0] ?><br></p>
	            <?php } ?>
			</div>
			<div class="form-group has-feedback <?php if (sizeof($password_repeat_errors) > 0) echo "has-error"; ?>">
				<label for="form_registration[password_repeat]">Repeat your password</label>
				<input type="password" class="form-control" name="form_registration[password_repeat]" value="<?= $t->s($t->get('form')->getValue('password_repeat')); ?>" required>
            	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
            	<?php if (sizeof($password_repeat_errors) > 0) { ?>
	            	<p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $password_repeat_errors[0] ?><br></p>
	            <?php } ?>
			</div>
			<div class="row">
	            <div class="col-xs-12">
	              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign Up</button>
	            </div><!-- /.col -->
	        </div>
		<?php }); ?>
      <a href="login" class="text-center">Back to Login</a>
	</div>
</div>
<?php });