<?php $t->extend("Customer/customer_base.html.php"); ?>
<?php $t->set("menu_active", "transaction_history"); ?>
<?php $t->block("content", function ($t) {
    $transactionList = $t->get("transactionList");
    $transactionStatus = array(
        '0' => 'Approved',
        '1' => 'On Hold'
     );
    ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Transaction History
        </h1>
        <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Transaction History</li>
        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <?php if( count($transactionList) != 0 )
                $t->formh($t->get("form"), array("action"=>"/transaction_history_download", "method"=>"post","target" => "_blank"), function ($t) { ?>
            <a id='downloadPDF' target='_blank' class="pull-right"><i class="fa fa-download"></i> Download as PDF
            </a>
            <?php }) ?>
        </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="transaction_history_table" class="table table-bordered table-striped app-data-table">
                            <thead>
                                <tr>
                                    <th class='trans-history-transaction-id'>ID</th>
                                    <th class='trans-history-beneficiary-account-id'>To Account No.</th>
                                    <th class='trans-history-beneficiary-name'>To Account Name</th>
                                    <th class='trans-history-transaction-date'>Date</th>
                                    <th class='trans-history-amount'>Amount</th>
                                    <th class='trans-history-status'>Status</th>
                                    <th class='trans-history-remarks'>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($transactionList as $transaction) {
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
                                    <td>
                                        <?= $t->s($transaction->getId()); ?>
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
                                    <td data-order="<?php echo $transaction->getIsOnHold() ?>" title=<?php echo "'".$title."'>" ?>
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script></script>
<?php });