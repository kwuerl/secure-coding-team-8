<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "make_transfer"); ?>
<?php $t->block("content", function ($t) { ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Make Transfer
    </h1>
    <ol class="breadcrumb">
        <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
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
            <form role="form">
                <div class="box-body">
                    <div class="form-group">
                        <label>Beneficiary Account No.</label>
                        <input class="form-control" id="toAccountNo" placeholder="Enter beneficiary account no.">
                    </div>
                    <div class="form-group">
                        <label>Account Holder Name</label>
                        <input class="form-control" id="toName" placeholder="Enter account holder name">
                    </div>
                    <div class="form-group">
                        <label>Amount to be transfered</label>
                        <input class="form-control" id="amountToBeTransfered" placeholder="Enter amount to be transfered">
                    </div>
                    <div class="form-group">
                        <label>Transaction Code</label>
                        <input class="form-control" id="transactionCode" placeholder="Enter transaction code">
                    </div>
                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" id="remarks" placeholder="Enter remarks"></textarea>
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
                    <button type="submit" class="btn">Cancel</button>
                </div>
            </form>
        </div>
</section>
</div>
<?php });