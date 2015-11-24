<?php $t->extend("Employee/employee_base.html.php"); ?>
<?php $t->set("menu_active", "employee_overview"); ?>
<?php $t->block("content", function ($t) {
 $customerCount = $t->get('customerCount');
 $pendingCustomerCount = $t->get('pendingCustomerCount');
 $registrationsTodayCount = $t->get('registrationsTodayCount');
 $pendingTransactionsCount = $t->get('pendingTransactionsCount');
 $transactionsTodayCount = $t->get('transactionsTodayCount');
 $latestTransactionList = $t->get('latestTransactionList');
 ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Overview
    </h1>
    <section class='content'>
              <div class="box box-primary">
              <div class="box-body">
            <div class="row">
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-aqua">
                            <div class="inner">
                              <h3><?= $t->s($customerCount + $pendingCustomerCount); ?></h3>
                              <p>Customer Registrations</p>
                            </div>
                            <div class="icon"><i class="fa fa-user"></i>
                            </div>
                            <a href="/customers" class="small-box-footer">
                              More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                          </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-green">
                            <div class="inner">
                              <h3><?= $t->s($pendingTransactionsCount); ?></h3>
                              <p>Pending Transactions</p>
                            </div>
                            <div class="icon"><i class="fa fa-tasks"></i>
                            </div>
                            <a href="/transactions" class="small-box-footer">
                              More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                          </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-yellow">
                            <div class="inner">
                              <h3><?= $t->s($transactionsTodayCount); ?></h3>
                              <p>Transactions Today</p>
                            </div>
                            <div class="icon"><i class="fa fa-tasks"></i>
                             </div>
                          </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                          <!-- small box -->
                          <div class="small-box bg-red">
                            <div class="inner">
                              <h3><?= $t->s($registrationsTodayCount); ?></h3>
                              <p>Registrations Today</p>
                            </div>
                            <div class="icon"><i class="fa fa-user-plus"></i>
                            </div>
                          </div>
                        </div><!-- ./col -->
                      </div><!-- /.row -->
                      </div>
                      </div>

    </section>
    <section class="content">
        <div class="row">
        <!-- left column -->
        <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
             <div class="box-header with-border">
                <h3 class="box-title">Latest Transactions</h3>
            </div>
            <div class="box-body">
                <table id="recent_transactions" class="table table-bordered table-striped app-data-table">
                    <thead>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Transaction Id</th>
                            <th>Amount</th>
                            <th>From Account No.</th>
                            <th>To Account No.</th>
                            <th>Remarks</th>
                    </thead>
                    <tbody>
                        <?php foreach ($latestTransactionList as $transaction) {?>
                        <tr>
                            <td>
                                <?= date('d-m-Y',strtotime($t->s($transaction->getTransactionDate()))); ?>
                            </td>
                            <td class='app-transaction-id'>
                                <?= $t->s($transaction->getId()); ?>
                            </td>
                            <td class="text-right">
                                <?= $t->s($transaction->getAmount()); ?>
                            </td>
                            <td>
                                <?= $t->s($transaction->getFromAccountId()); ?>
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
            <!-- /.box -->
        </div>
    </section>
</div>
<?php });