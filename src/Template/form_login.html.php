<?php $t->extend("base.html.php"); ?>
<?php $t->set("is_login", true); ?>
<?php $t->block("body", function ($t) { ?>
  <div class="login-box">

    <div class="login-logo">
        <a><b>Secure</b>Bank</a>
    </div><!-- /.login-logo -->
    <h1>Login</h1>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your banking session</p>
      <?php $t->flash_echo(); ?>
      <?php $t->formh($t->get("form"), array("action"=>"/login", "method"=>"post"), function ($t) { ?>
        <?php
          $email_errors = $t->get("form")->getError("email");
          $password_errors = $t->get("form")->getError("password");
        ?>
        <div class="form-group has-feedback <?php if (sizeof($email_errors) > 0) echo "has-error"; ?>">
            <?php if (sizeof($email_errors) > 0) { ?>
              <label for="form_login[email]" class="control-label"><span class="glyphicon glyphicon-remove-circle"></span> <?= $email_errors[0] ?></label>
            <?php } ?>
            <input type="email" class="form-control" placeholder="E-Mail" name="form_login[email]" value="<?= $t->s($t->get('form')->getValue('email')); ?>" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback <?php if (sizeof($password_errors) > 0) echo "has-error"; ?>">
            <?php if (sizeof($password_errors) > 0) { ?>
              <label for="form_login[password_plain]" class="control-label"><span class="glyphicon glyphicon-remove-circle"></span> <?= $password_errors[0] ?></label>
            <?php } ?>
            <input type="password" class="form-control" placeholder="Password" name="form_login[_password_plain]" value="<?= $t->s($t->get('form')->getValue('_password_plain')); ?>" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
      <?php }); ?>

      <!--a href="#">Forgot password?</a><br-->
      <a href="register" class="text-center">Register for a new account</a>
    </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->
<?php });