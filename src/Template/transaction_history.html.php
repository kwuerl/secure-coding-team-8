<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "transaction_history"); ?>
<?php $t->block("content", function ($t) {
    $transactionList = $t->get("transactionList"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Transaction History
    </h1>( <a href='transaction_history_download' target='_blank'>Download as PDF</a> )
    <ol class="breadcrumb">
        <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
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
                                    <th>Transaction ID</th>
                                    <th>Date of transaction</th>
                                    <th>Amount</th>
                                    <th>Beneficiary Account ID</th>
                                    <th>Beneficiary Account Name</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($transactionList as $transaction) {?>
                                <tr>
                                    <td>
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
                                </tr>
                                <?php }?>
                            </tbody>
                            <?php if( count($transactionList) != 0 ) {?>
                            <tfoot>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Date of transaction</th>
                                    <th>Amount</th>
                                    <th>Beneficiary Account ID</th>
                                    <th>Beneficiary Account Name</th>
                                    <th>Remarks</th>
                                </tr>
                            </tfoot>
                            <?php } ?>
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