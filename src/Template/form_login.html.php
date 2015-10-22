<?php $t->extend("base.html.php"); ?>

<?php $t->block("body", function ($t) { ?>
  <div class="login-box">

    <div class="login-logo">
        <a><b>Secure</b>Bank</a>
    </div><!-- /.login-logo -->

    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your banking session</p>

      <?php $t->formh($t->get("form"), array("action"=>"/processLogin", "method"=>"post"), function ($t) { ?>
        <?php foreach ($t->get("form")->getError("email") as $error) { ?>
        <?= $error ?><br>
        <?php } ?>
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="E-Mail" name="login_form[email]">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="login_form[password]">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
        </div>
      <?php }); ?>

      <!--a href="#">Forgot password?</a><br-->
      <a href="form_register.html" class="text-center">Register for a new account</a>
    </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->
<?php });