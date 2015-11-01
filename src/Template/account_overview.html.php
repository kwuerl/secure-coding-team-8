<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "home"); ?>
<?php $t->block("content", function ($t) {
    $currentUser = $t->get("currentUser");
    $accountInfo = $t->get("accountInfo");
    $transactionList = $t->get("transactionList");?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Account Overview
        </h1>
    </section>
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
                                <label>Account Balance</label>
                                <div>
                                    EURO <?= $t->s($accountInfo->getBalance()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label >Email</label>
                                <div>
                                    <?= $t->s($currentUser->getEmail()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Account No.</label>
                                <div>
                                    <?= $t->s($accountInfo->getAccountId()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Account Type</label>
                                <div>
                                    <?= $t->s($accountInfo->getType()); ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <section class='content-header'>
        <div class="row">
            <div class="col-xs-7">
                <h1>Last 5 Transactions</h1>
            </div>
            <div class="col-xs-5">
                <?php if( count($transactionList) != 0 ) {?>
                <a href='/statement' class='pull-right'><i class="glyphicon glyphicon-share-alt"></i>&nbsp;View More</i>
                </a>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class='content'>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="customer_transactions_table" class="table table-bordered table-striped app-data-table">
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
</div>
<?php });