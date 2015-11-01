<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "make_transfer"); ?>
<?php $t->block("content", function ($t) { ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php $t->flash_echo(); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Make Transfer
    </h1>
    <ol class="breadcrumb">
        <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Make Transfer</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <?php $t->flash_echo(); ?>
                <?php $t->formh($t->get("form"), array("action"=>"/make_transfer", "method"=>"post"), function ($t) { ?>
                <?php
                    $to_account_id_errors = $t->get("form")->getError("to_account_id");
                    $to_account_name_errors= $t->get("form")->getError("to_account_name");
                    $amount_errors = $t->get("form")->getError("amount");
                    $transaction_code_errors = $t->get("form")->getError("transaction_code");
                    $remarks_errors = $t->get("form")->getError("remarks");
                    ?>
                <div class="box-body">
                    <div class="form-group has-feedback <?php if (sizeof($to_account_id_errors) > 0) echo "has-error"; ?>">
                        <label for="make_transfer[to_account_id]">Beneficiary Account No.</label>
                        <input type="text" class="form-control" name="make_transfer[to_account_id]" value="<?= $t->s($t->get('form')->getValue('to_account_id')); ?>" required maxlength='10'>
                        <?php if (sizeof($to_account_id_errors) > 0) { ?>
                        <p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $to_account_id_errors[0] ?><br></p>
                        <?php } ?>
                    </div>
                    <div class="form-group has-feedback <?php if (sizeof($to_account_name_errors) > 0) echo "has-error"; ?>">
                        <label for="make_transfer[to_account_name]">Account Holder Name</label>
                        <input type="text" class="form-control" name="make_transfer[to_account_name]" value="<?= $t->s($t->get('form')->getValue('to_account_name')); ?>" required maxlength='45'>
                        <?php if (sizeof($to_account_name_errors) > 0) { ?>
                        <p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $to_account_name_errors[0] ?><br></p>
                        <?php } ?>
                    </div>
                    <div class="form-group has-feedback <?php if (sizeof($amount_errors) > 0) echo "has-error"; ?>">
                        <label for="make_transfer[amount]">Amount to be transfered</label>
                        <input type="text" class="form-control" name="make_transfer[amount]" value="<?= $t->s($t->get('form')->getValue('amount')); ?>" required maxlength='6'>
                        <?php if (sizeof($amount_errors) > 0) { ?>
                        <p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $amount_errors[0] ?><br></p>
                        <?php } ?>
                    </div>
                    <div class="form-group has-feedback <?php if (sizeof($transaction_code_errors) > 0) echo "has-error"; ?>">
                        <label for="make_transfer[transaction_code]">Transaction Code</label>
                        <input type="text" class="form-control" name="make_transfer[transaction_code]" value="<?= $t->s($t->get('form')->getValue('transaction_code')); ?>" required maxlength='15'>
                        <?php if (sizeof($transaction_code_errors) > 0) { ?>
                        <p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $transaction_code_errors[0] ?><br></p>
                        <?php } ?>
                    </div>
                    <div class="form-group has-feedback <?php if (sizeof($remarks_errors) > 0) echo "has-error"; ?>">
                        <label for="make_transfer[remarks]">Remarks</label>
                        <textarea type="text" class="form-control" name="make_transfer[remarks]" required maxlength='100'><?= $t->s($t->get('form')->getValue('remarks')); ?></textarea>
                        <?php if (sizeof($remarks_errors) > 0) { ?>
                        <p class="text-red"><span class="glyphicon glyphicon-remove-circle"></span> <?= $remarks_errors[0] ?><br></p>
                        <?php } ?>
                    </div>
                    OR
                    <div class="form-group">
                        <label>File input</label>
                        <input type="file" id="transactionCodeFile">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Confirm</button>
                    <button class="btn clear">Clear</button>
                </div>
                <?php }) ?>
            </div>
        </div>
    </div>
</section>
<?php }) ?>