<?php $t->extend("base.html.php"); ?>
<?php $t->set("is_login", true); ?>
<?php $t->block("body", function ($t) { ?>
<div class="login-box">
    <div class="login-logo">
        <a><b>Secure</b>Bank</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Password recovery</p>
        <?php $t->flash_echo(); ?>
        <?php $t->formh($t->get("form"), array("action"=>"/recover_password", "method"=>"post"), function ($t) { ?>
        <?php
            $email_errors = $t->get("form")->getError("email");
            ?>
        <div class="form-group has-feedback <?php if (sizeof($email_errors) > 0) echo "has-error"; ?>">
            <?php if (sizeof($email_errors) > 0) { ?>
            <label for="recover_password[email]" class="control-label"><span class="glyphicon glyphicon-remove-circle"></span> <?= $email_errors[0] ?></label>
            <?php } ?>
            <input type="email" class="form-control" placeholder="E-Mail" name="recover_password[email]" value="<?= $t->s($t->get('form')->getValue('email')); ?>" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <label for="recover_password[employee]" class="control-label">Are you an employee?</label>
            <input type="checkbox" name="recover_password[employee]">
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