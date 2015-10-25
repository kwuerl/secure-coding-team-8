<?php $t->extend("user_overview.html.php"); ?>

<?php $t->block("content", function ($t) {
  $transactions = $t->get("transactions"); ?>
 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Transaction History
          </h1>
          <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="active">Transaction History</a></li>
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
                      <?php foreach($transactions as $transaction) {?>
                      <tr>
                        <td>
                          <?php echo $transaction->getId(); ?>
                        </td>
                        <td>
                          <?php echo $transaction->getTransactionDate(); ?>
                        </td>
                        <td>
                          <?php echo $transaction->getAmount(); ?>
                        </td>
                        <td>
                          <?php echo $transaction->getToAccountId(); ?>
                        </td>
                        <td>
                          <?php echo $transaction->getToAccountName(); ?>
                        </td>
                        <td>
                          <?php echo $transaction->getRemarks(); ?>
                        </td>
                      </tr>
                      <?php }?>
                    </tbody>
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
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <script>

          </script>
<?php });