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
                        <td class='text-center'>
                            <?= $t->s($transaction->getFromAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getFromAccountName()); ?>
                        </td>
                        <td class='text-center'>
                            <?= $t->s($transaction->getToAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountName()); ?>
                        </td>
                         <td class='text-center'>
                            <?= date('d-m-Y',strtotime($t->s($transaction->getTransactionDate()))); ?>
                        </td>
                        <td class="text-right">
                            <?= $t->s($transaction->getAmount()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getRemarks()); ?>
                        </td>
                        <td>
                            <?php $t->formh($t->get("form"), array(
                                "action"=>"/transactions/approve", 
                                "method"=>"post", 
                                "data-confirm-modal"=>"", 
                                "data-modal-title"=>"Approve Transaction", 
                                "data-modal-body"=>"Are you sure you want to approve the transaction?"
                            ), function ($t) use ($transaction) { ?>
                                <input name='approve_transaction[transaction_id]' type='hidden' value='<?= $t->s($transaction->getId()); ?>'/>
                                <button type="submit" name="approve_transaction[action]" value="approve" class="btn btn-info">Approve</button>
                            <?php }); ?>
                            <?php $t->formh($t->get("form"), array(
                                "action"=>"/transactions/reject", 
                                "method"=>"post", 
                                "data-confirm-modal"=>"", 
                                "data-modal-title"=>"Reject Transaction", 
                                "data-modal-body"=>"Are you sure you want to reject the transaction?"
                            ), function ($t) use ($transaction) { ?>
                                <input name='approve_transaction[transaction_id]' type='hidden' value='<?= $t->s($transaction->getId()); ?>'/>
                                <button type="submit" name="approve_transaction[action]" value="reject" class="btn btn-reject">Reject</button>
                            <?php }); ?>
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
                        <td class='text-center'>
                            <?= $t->s($transaction->getFromAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getFromAccountName()); ?>
                        </td>
                        <td class='text-center'>
                            <?= $t->s($transaction->getToAccountId()); ?>
                        </td>
                        <td>
                            <?= $t->s($transaction->getToAccountName()); ?>
                        </td>
                         <td class='text-center'>
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
<?php }); ?>