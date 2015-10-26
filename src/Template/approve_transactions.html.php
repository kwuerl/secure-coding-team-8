<?php $t->extend("user_overview.html.php"); ?>
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
        <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/approve_transactions"><i class="fa fa-dashboard"></i>Pending Transactions</a></li>
    </ol>
</section>
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
                        <td>
                            <?php echo $transaction->getId(); ?>
                        </td>
                        <td>
                            <?php echo $transaction->getTransactionDate(); ?>
                        </td>
                        <td>
                            <?php echo $transaction->getAmount(); ?>
                        </td>
                        <td>
                            <?php echo $transaction->getToAccountId(); ?>
                        </td>
                        <td>
                            <?php echo $transaction->getToAccountName(); ?>
                        </td>
                        <td>
                            <?php echo $transaction->getRemarks(); ?>
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
<?php }); ?>