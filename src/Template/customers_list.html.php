<?php $t->extend("user_overview.html.php"); ?>

<?php $t->block("content", function ($t) {?>

 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Customers
          </h1>
          <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="active">Customers</a></li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-body">
                  <table id="cust_list_table" class="table table-bordered table-striped app-data-table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>Email Id</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php for($i=0; $i<15; $i++){?>
                      <tr>
                        <td><a href="/customer_details">Tom</a></td>
                        <td>13252525</td>
                        <td>to@cat.com</td>
                      </tr>
                    <?php } ?>

                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Name</th>
                        <th>Account No</th>
                        <th>Email Id</th>
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