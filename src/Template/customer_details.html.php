<?php $t->extend("user_overview.html.php"); ?>

<?php $t->block("content", function ($t) { ?>

        <!-- Content Wrapper. Contains page content -->
              <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                  <h1>
                    Customer Details
                  </h1>
                  <ol class="breadcrumb">
                    <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="/customers"><i class="fa fa-dashboard"></i> Customers</a></li>
                    <li class="active">Customer Details</li>
                  </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                  <div class="row">
                    <!-- left column -->
                    <div class="col-md-4">
                      <!-- general form elements -->
                      <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Profile</h3>
                            </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                          <div class="box-body">
                            <div class="form-group">
                              <label>Name</label>
                              <div>
                                Tom
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Email</label>
                              <div>
                               tom@cat.com
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Account No.</label>
                              <div>2242243555</div>
                            </div>
                          </div><!-- /.box-body -->
                        </form>
                      </div><!-- /.box -->
                    </div>
                    <! -- Pending Transaction Details -->
                    <div class="col-md-8">
                      <!-- general form elements -->
                      <div class="box box-primary">
                           <div class="box-header with-border">
                             <h3 class="box-title">Transactions Approval Pending</h3>
                           </div><!-- /.box-header -->
                           <div class="box-body">
                               <table id="cust_details_table1" class="table table-bordered table-striped app-data-table">
                                  <thead>
                                    <tr>
                                      <th>Transaction Id</th>
                                      <th>To Account Number</th>
                                      <th>Date of Transaction</th>
                                      <th>Amount</th>
                                      <th>Actions</th>
                                  </thead>
                                      <tbody>
                                      <?php for($i=0; $i<15; $i++) { ?>
                                            <tr>
                                              <td><a href="javascript:void(0);" data-toggle="modal"  data-target="#approveTransModal">12222</a></td>
                                              <td>46366346346</td>
                                              <td>10.10.15</td>
                                              <td>50004</td>
                                              <td>
                                                 <button type="button" class="btn btn-info" data-toggle="modal" data-target="#approveTransModal">Approve</button>
                                                 <button type="button" class="btn btn-reject" data-toggle="modal" data-target="#rejectTransModal">Reject</button>
                                              </td>
                                            </tr>
                                       <?php } ?>

                                      </tbody>
                                      <tfoot>
                                        <tr>
                                            <th>Transaction Id</th>
                                            <th>To Account Number</th>
                                            <th>Date of Transaction</th>
                                            <th>Amount</th>
                                            <th>Actions</th>
                                        </tr>
                                      </tfoot>
                               </table>
                      </div><!-- /.box -->
                      </div>
                  </div>
                </div>
                  <div class="row">
                      <!-- left column -->
                      <div class="col-md-12">
                      <!-- general form elements -->
                        <div class="box box-primary">
                             <div class="box-header with-border">
                                <h3 class="box-title">All Transactions</h3>
                             </div><!-- /.box-header -->
                             <div class="box-body">
                                <table id="cust_details_table2" class="table table-bordered table-striped app-data-table">
                                      <thead>
                                        <tr>
                                          <th>Transaction Id</th>
                                          <th>To Account Number</th>
                                          <th>Date of Transaction</th>
                                          <th>Amount</th>
                                          <th>Remarks</th>
                                      </thead>
                                      <tbody>
                                      <?php for($i=0;$i<10;$i++) { ?>
                                            <tr>
                                              <td>12222</td>
                                              <td>46366346346</td>
                                              <td>10.10.15</td>
                                              <td>50004</td>
                                              <td>For rent</td>
                                            </tr>
                                      <?php } ?>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                            <th>Transaction Id</th>
                                            <th>To Account Number</th>
                                            <th>Date of Transaction</th>
                                            <th>Amount</th>
                                            <th>Remarks</th>
                                        </tr>
                                      </tfoot>
                           </table>
                      </div><!-- /.box -->
                      </div>
                </section>
              </div>
<?php });












