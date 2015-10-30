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
        </h1>
        <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Transaction History</li>
        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <?php if( count($transactionList) != 0 ) {?>
            <form name='download_pdf_form' action="/transaction_history_download" method="post" target='_blank'>
                <a id='downloadPDF' target='_blank' class="pull-right"><i class="fa fa-download"></i> Download as PDF
                </a>
            </form>
            <?php } ?>
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
                                    <th>Transaction ID</th>
                                    <th>Date of transaction</th>
                                    <th>Amount</th>
                                    <th>Beneficiary Account ID</th>
                                    <th>Beneficiary Account Name</th>
                                    <th>Status</th>
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
                                    <td>
                                        <?= $t->s($transaction->getIsOnHold()); ?>
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
                                    <th>Status</th>
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