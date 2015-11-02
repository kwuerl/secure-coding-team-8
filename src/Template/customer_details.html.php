<?php $t->extend("user_overview.html.php"); ?>
<?php $t->block("content", function ($t) {
    $customer = $t->get("customer");
    $onHoldTransactionList = $t->get("onHoldTransactionList");
    $approvedTransactionList = $t->get("approvedTransactionList"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Customer Details
    </h1>
    <ol class="breadcrumb">
        <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="/customers">Customers</a></li>
        <li class="active">Customer Details</li>
    </ol>
</section>
<section>
     <?php if( count($onHoldTransactionList) != 0 ) { ?>
    <div class="row">
       <!-- left column -->
            <div class="col-md-12">
                  <a href=<?= $t->s("/customer_pending_transaction_download/" . $customer->getId() . ""); ?>
                  id='downloadPDF' target='_blank' class="pull-right">
                  <i class="fa fa-download"></i> Download as PDF
                  </a>
              </div>
        </div>
    <?php } ?>
     </section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-4">
            <div class="box box-primary app-section-min-height" >
                <div class="box-header with-border">
                    <h3 class="box-title">Profile</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Name</label>
                            <div>
                                <?= $t->s($customer->getFirstName()); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <div>
                                <?= $t->s($customer->getEmail()); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Account No.</label>
                            <div>2242243555</div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!-- Pending Transaction Details -->
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary app-section-min-height">
                <div class="box-header with-border">
                    <h3 class="box-title">Transactions Pending for Approval</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="cust_details_table1" class="table table-bordered table-striped app-data-table-small">
                        <thead>
                            <tr>
                                <th>Transaction Id</th>
                                <th>To Account Number</th>
                                <th>Transaction Date</th>
                                <th>Amount</th>
                        </thead>
                        <tbody>
                            <?php foreach($onHoldTransactionList as $transaction) {?>
                            <tr>
                                <td>
                                    <?= $t->s($transaction->getId()); ?>
                                </td>
                                <td>
                                    <?= $t->s($transaction->getToAccountId()); ?>
                                </td>
                                <td>
                                    <?= date('d-m-Y',strtotime($t->s($transaction->getTransactionDate()))); ?>
                                </td>
                                <td class="text-right">
                                    <?= $t->s($transaction->getAmount()); ?>
                                </td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
     <?php if( count($approvedTransactionList) != 0 ) { ?>
    <div class="row">
       <!-- left column -->
        <div class="col-md-12">
              <a href=<?= $t->s("/customer_completed_transaction_download/" . $customer->getId() . ""); ?>
               id='downloadPDF' target='_blank' class="pull-right">
              <i class="fa fa-download"></i> Download as PDF
              </a>
          </div>
    </div>
    <?php } ?>
    <div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Completed Transactions</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="cust_details_table2" class="table table-bordered table-striped app-data-table-small">
                    <thead>
                        <tr>
                            <th>Transaction Id</th>
                            <th>To Account Number</th>
                            <th>Transaction Date</th>
                            <th>Amount</th>
                            <th>Remarks</th>
                    </thead>
                    <tbody>
                        <?php foreach($approvedTransactionList as $transaction) {?>
                        <tr>
                            <td>
                                <?= $t->s($transaction->getId()); ?>
                            </td>
                            <td>
                                <?= $t->s($transaction->getToAccountId()); ?>
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
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <!-- /.box -->
        </div>
</section>
</div>
<?php }); ?>