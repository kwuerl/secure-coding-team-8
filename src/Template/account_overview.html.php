<?php $t->extend("user_overview.html.php"); ?>
<?php $t->block("menu_home_class", function ($t) { ?>
    treeview active
<?php }); ?>
<?php $t->block("content", function ($t) {
      $currentUser = $t->get("currentUser");
      $accountInfo = $t->get("accountInfo"); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Account Overview
    </h1>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Account Balance</label>
                                <div>10000 Euros</div>
                            </div>
                            <div class="form-group">
                                <label >Email</label>
                                <div>
                                    <?= $t->s($currentUser->getEmail()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Account No.</label>
                                <div>
                                    <?= $t->s($accountInfo->getAccountId()); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<?php });