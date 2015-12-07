<?php $t->extend("Employee/employee_base.html.php"); ?>
<?php $t->set("menu_active", "approve_transactions"); ?>
<?php $t->block("content", function ($t) {
    $transactionList = $t->get("transactionList"); 
    $completedtransactionList = $t->get("completedtransactionList");
     $transactionStatus = array(
        '0' => 'Approved',
        '1' => 'On Hold'
     );
    ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="flash-echo">
<?php $t->flash_echo(); ?>
</div>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Transactions
    </h1>
    <ol class="breadcrumb">
        <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
        <li class='active'>Transactions</a></li>
    </ol>
</section>
<?php $t->formh($t->get("form"), array("action"=>"/transactions", "method"=>"post"), function ($t) { ?>
<input id='selectedTransactionId' name='selectedTransactionId' type='hidden' value=''/>
<input id='action_transaction' name='action_transaction' type='hidden' value=''/>
<?php }) ?>
<div class="row">
    <div class="col-xs-12">
        <?php if( count($transactionList) != 0 ) { ?>
        <a href='/transactions_pending_download' id='downloadPDF' target='_blank' class="pull-right"><i class="fa fa-download"></i> Download as PDF
        </a>
        <?php } ?>
    </div>
</div>
<!-- Main content -->
<section class="content">
    <div class="row">
    <!-- left column -->
    <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
		<div class="box-header with-border">
            <h3 class="box-title">Pending Transactions</h3>
        </div>
        <div class="box-body">
            <table id="approve_trans_table" class="table table-bordered table-striped app-data-table-small">
                <thead>
                    <tr>
                        <th class="width_5">ID</th>
                        <th>From Account No.</th>
                        <th>From Account Name</th>
                        <th>To Account No.</th>
                        <th>To Account Name</th>
                        <th>Date</th>
                        <th>Amount</th>
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
                            <?= $t->s($transaction->getFromAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getFromAccountName()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountName()); ?>
                        </td>
                         <td>
                            <?= date('d-m-Y',strtotime($t->s($transaction->getTransactionDate()))); ?>
                        </td>
                        <td class="text-right">
                            <?= $t->s($transaction->getAmount()); ?>
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
            </table>
        </div>
        <!-- /.box -->
    </div>
</section>
<div class="row">
    <div class="col-xs-12">
        <?php if( count($completedtransactionList) != 0 ) { ?>
        <a href='/transactions_completed_download' id='downloadPDF' target='_blank' class="pull-right"><i class="fa fa-download"></i> Download as PDF
        </a>
        <?php } ?>
    </div>
</div>
<section class="content">
    <div class="row">
    <!-- left column -->
    <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
		<div class="box-header with-border">
            <h3 class="box-title">Completed Transactions</h3>
        </div>
        <div class="box-body">
            <table id="tbl_completed_transactions" class="table table-bordered table-striped app-data-table-small">
                <thead>
                    <tr>
                        <th class="width_5">ID</th>
                        <th>From Account No.</th>
                        <th>From Account Name</th>
                        <th>To Account No.</th>
                        <th>To Account Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Remarks</th>
                </thead>
                <tbody>
                    <?php foreach ($completedtransactionList as $transaction) {
					 $title = $transactionStatus[$transaction->getIsOnHold()];
						if($transaction->getIsOnHold())
							$class = 'fa fa-retweet';
						else if($transaction->getIsRejected()) {
							$class = 'fa fa-times';
							$title = "Rejected";
						} else
							$class ='fa fa-check-circle';
								
						?>
                    <tr>
                        <td class='app-transaction-id'>
                            <?= $t->s($transaction->getId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getFromAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getFromAccountName()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountName()); ?>
                        </td>
                         <td>
                            <?= date('d-m-Y',strtotime($t->s($transaction->getTransactionDate()))); ?>
                        </td>
                        <td class="text-right">
                            <?= $t->s($transaction->getAmount()); ?>
                        </td>
                        <td class='status' data-order="<?php echo $transaction->getIsOnHold() ?>" title=<?php echo "'".$title."'>" ?>
							<i class=<?php echo "'".$class."'></i>" ?>
						</td>
                        <td>
                            <?= $t->s($transaction->getRemarks()); ?>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <!-- /.box -->
    </div>
</section>
<!-- Approve Transaction Modal -->
<div id="approveTransModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class='fa fa-times'></i></button>
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
                <button type="button" class="close" data-dismiss="modal"><i class='fa fa-times'></i></button>
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