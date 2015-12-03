<?php $t->extend("base.html.php"); ?>
<?php $t->set("is_login", true); ?>
<?php $t->block("body", function ($t) { ?>
<div class="login-box">
    <div class="login-logo">
        <a><b>Secure</b>Bank</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Set new password</p>
        <?php $t->flash_echo(); ?>
        <?php $t->formh($t->get("form"), array("action"=>"/reset_password", "method"=>"post"), function ($t) { ?>
        <?php
            $pw_errors = $t->get("form")->getError("_plain_password");
            $password_repeat_errors = $t->get("form")->getError("password_repeat");
            ?>
        <div class="form-group has-feedback <?php if (sizeof($pw_errors) > 0) echo "has-error"; ?>">
            <label for="reset_password[_password_plain]">Password</label>
            <input type="password" class="form-control" name="reset_password[_password_plain]" pattern="(?!.*[äöüÄÖÜ\s%&/~§<>]).+" title="Only letters, numbers and '-_$^?\+#*' allowed" value="<?= $t->s($t->get('form')->getValue('_password_plain')); ?>" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <?php if (sizeof($pw_errors) > 0) { ?>
            <p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $pw_errors[0] ?><br></p>
            <?php } ?>
        </div>
        <div class="form-group has-feedback <?php if (sizeof($password_repeat_errors) > 0) echo "has-error"; ?>">
            <label for="reset_password[password_repeat]">Repeat your password</label>
            <input type="password" class="form-control" name="reset_password[password_repeat]" value="<?= $t->s($t->get('form')->getValue('password_repeat')); ?>" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <?php if (sizeof($password_repeat_errors) > 0) { ?>
            <p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $password_repeat_errors[0] ?><br></p>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Reset password</button>
            </div>
            <!-- /.col -->
        </div>
        <?php }); ?>
        <a href="login" class="text-center row">Back to login</a>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<?php });