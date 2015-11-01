<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "transaction_history"); ?>
<?php $t->block("content", function ($t) {
    $transactionList = $t->get("transactionList");
    $transactionStatus = array(
        '0' => 'COMPLETED',
        '1' => 'ON HOLD'
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
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="transaction_history_table" class="table table-bordered table-striped app-data-table">
                            <thead>
                                <tr>
                                    <th class='trans-history-transaction-id'>Transaction ID</th>
                                    <th class='trans-history-transaction-date'>Transaction Date</th>
                                    <th class='trans-history-amount'>Amount</th>
                                    <th class='trans-history-beneficiary-account-id'>Beneficiary Account ID</th>
                                    <th class='trans-history-beneficiary-name'>Beneficiary Account Name</th>
                                    <th class='trans-history-status'>Status</th>
                                    <th class='trans-history-remarks'>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($transactionList as $transaction) {
                                    $class = ($transaction->getIsOnHold()) ? 'fa fa-retweet' :  'fa fa-check-circle';
                                    $title = $transactionStatus[$transaction->getIsOnHold()];
                                    ?>
                                <tr>
                                    <td>
                                        <?= $t->s($transaction->getId()); ?>
                                    </td>
                                    <td>
                                        <?= date('d-m-Y',strtotime($t->s($transaction->getTransactionDate()))); ?>
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