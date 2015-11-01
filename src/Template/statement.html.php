<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "statement"); ?>
<?php $t->block("content", function ($t) {
    $transactionList = $t->get("transactionList");
    $accountInfo = $t->get("accountInfo");
    ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Statement
        </h1>
        <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Statement</li>
        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <?php if( count($transactionList) != 0 )
                $t->formh($t->get("form"), array("action"=>"/transaction_history_download", "method"=>"post","target" => "_blank"), function ($t) { ?>
            <form name='download_pdf_form' action="/transaction_history_download" method="post" target='_blank'>
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
                        <table id="statement_table" class="table table-bordered table-striped app-data-table">
                            <thead>
                                <tr>
                                    <th class='trans-history-transaction-id' rowspan='2'>Transaction ID</th>
                                    <th class='trans-history-transaction-date' rowspan='2'>Transaction Date</th>
                                    <th class='trans-history-amount' colspan='2' >Amount</th>
                                    <th class='trans-history-beneficiary-account-id' rowspan='2'>To/From Account ID</th>
                                    <th class='trans-history-remarks' rowspan='2'>Remarks</th>
                                </tr>
                                <tr>
                                    <th class='trans-history-amount'>Debit</th>
                                    <th class='trans-history-amount'>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($transactionList as $transaction) {
                                    $credit_amount = ( $accountInfo->getAccountId() != $transaction->getFromAccountId() ) ? $transaction->getAmount() :  '--';
                                    $debit_amount = ( $accountInfo->getAccountId() != $transaction->getFromAccountId() ) ? '--': $transaction->getAmount();
                                    ?>
                                <tr>
                                    <td>
                                        <?= $t->s($transaction->getId()); ?>
                                    </td>
                                    <td>
                                        <?= date('d-m-Y',strtotime($t->s($transaction->getTransactionDate()))); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($debit_amount); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($credit_amount); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($transaction->getToAccountId()); ?>
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