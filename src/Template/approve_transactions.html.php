<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "approve_transactions"); ?>
<?php $t->block("content", function ($t) {
    $transactionList = $t->get("transactionList"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Transactions pending for Approval
    </h1>
    <ol class="breadcrumb">
        <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
        <li class='active'>Pending Transactions</a></li>
    </ol>
</section>
 <?php $t->formh($t->get("form"), array("action"=>"/transactions", "method"=>"post"), function ($t) { ?>
    <input id='selectedTransactionId' name='selectedTransactionId' type='hidden' value=''/>
    <input id='rejectionOperation' name='rejectionOperation' type='hidden' value=''/>
<?php }) ?>
<!-- Main content -->
<section class="content">
    <div class="row">
    <!-- left column -->
    <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-body">
            <table id="approve_trans_table" class="table table-bordered table-striped app-data-table">
                <thead>
                    <tr>
                        <th>Transaction Id</th>
                        <th>Date of Transaction</th>
                        <th>Amount</th>
                        <th>To Account Number</th>
                        <th>To Account Name</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach ($transactionList as $transaction) {?>
                    <tr>
                        <td class='app-transaction-id'>
                            <?= $t->s($transaction->getId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getTransactionDate()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getAmount()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountName()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getRemarks()); ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#approveTransModal">Approve</button>
                            <button type="button" class="btn btn-reject" data-toggle="modal" data-target="#rejectTransModal">Reject</button>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Transaction Id</th>
                        <th>Date of Transaction</th>
                        <th>Amount</th>
                        <th>To Account Number</th>
                        <th>To Account Name</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box -->
    </div>
</section>

    <!-- Approve Transaction Modal -->
    <div id="approveTransModal" class="modal fade" role="dialog" tabindex="-1">#
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Approve Transaction</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to approve the transaction?
                </div>
                <!-- /.box-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Transaction Modal -->
    <div id="rejectTransModal" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Reject Transaction</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to reject the transaction?
                </div>
                <!-- /.box-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?php }); ?>