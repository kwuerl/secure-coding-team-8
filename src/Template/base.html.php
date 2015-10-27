<?php $t->set("is_login", false); ?>
<html>
    <head>
        <title>SecureBank</title>
        <link rel="icon" type="image/ico" href="favicon.ico"/>
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/Vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/Vendor/bootstrap/css/dataTables.bootstrap.css">

        <!-- Theme style -->
	    <link rel="stylesheet" href="/Vendor/theme/AdminLTE.min.css">
	    <link rel="stylesheet" href="/Vendor/theme/header.css">
	    <link rel="stylesheet" href="/Vendor/theme/skin.min.css">
    </head>
    <body class="hold-transition<?= $t->get("is_login")?" login-page":" skin-blue sidebar-mini";?>">
    <?php $t->block("body", function ($t) { ?>
        Default
    <?php }); ?>
     <script src="/Vendor/js/jQuery-2.1.4.min.js"></script>
     <script src="/Vendor/bootstrap/js/bootstrap.min.js"></script>
     <script src="/Vendor/js/jquery.dataTables.min.js"></script>
     <script src="/Vendor/js/dataTables.bootstrap.min.js"></script>
     <script src="/Scripts/app.js"></script>
    </body>
     <!-- Modals -->
     <!-- Approve Transaction Modal -->
    <div id="approveTransModal" class="modal fade" role="dialog" tabindex="-1">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Approve Transaction</h4>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label>Transaction Id</label>
                  <div>
                    12222
                  </div>
                </div>
                <div class="form-group">
                  <label>To Account Number</label>
                  <div>
                   46366346346
                  </div>
                </div>
                <div class="form-group">
                  <label>Date of Transaction</label>
                  <div>10.10.15</div>
                </div>
                <div class="form-group">
                  <label>Amount</label>
                  <div>10.10.15</div>
                </div>
                <div class="form-group">
                  <label>User Remarks</label>
                 <div>Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.
                      payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.</div>
                </div>
               <div>
                 <label >Comments</label></div>
                 <textarea rows="3" placeholder="Please enter your comments here..."></textarea>
               </div>
            </form>
          </div><!-- /.box-body -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Approve</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <!-- Reject Transaction Modal -->
    <div id="rejectTransModal" class="modal fade" role="dialog" tabindex="-1">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Reject Transaction</h4>
          </div>
          <div class="modal-body">
            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label>Transaction Id</label>
                  <div>
                    12222
                  </div>
                </div>
                <div class="form-group">
                  <label>To Account Number</label>
                  <div>
                   46366346346
                  </div>
                </div>
                <div class="form-group">
                  <label>Date of Transaction</label>
                  <div>10.10.15</div>
                </div>
                <div class="form-group">
                  <label>Amount</label>
                  <div>10.10.15</div>
                </div>
                <div class="form-group">
                  <label>User Remarks</label>
                 <div>Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.
                      payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.Rent payment.</div>
                </div>
               <div>
                 <label >Comments</label></div>
                 <textarea rows="3" placeholder="Please enter your comments here..."></textarea>
               </div>
            </form>
          </div><!-- /.box-body -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Reject</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <!-- Approve Registration Modal -->

        <div id="approveRegModal" class="modal fade" role="dialog" tabindex="-1">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Approve Registration</h4>
              </div>
              <div class="modal-body">
                <form role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label>Name</label>
                      <div>
                        Tom
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Email Id</label>
                      <div>
                       tom@cat.com
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Account No.</label>
                      <div>1232525526</div>
                    </div>
                </form>
              </div><!-- /.box-body -->

              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Approve</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
        <!-- Reject Registration Modal -->
        <div id="rejectRegModal" class="modal fade" role="dialog" tabindex="-1">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Approve Registration</h4>
                      </div>
                      <div class="modal-body">
                        <form role="form">
                          <div class="box-body">
                            <div class="form-group">
                              <label>Name</label>
                              <div>
                                Tom
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Email Id</label>
                              <div>
                               tom@cat.com
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Account No.</label>
                              <div>1232525526</div>
                            </div>
                        </form>
                      </div><!-- /.box-body -->

                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Approve</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>
</html>