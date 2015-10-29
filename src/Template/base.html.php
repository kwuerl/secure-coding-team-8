<?php $t->set("is_login", false); ?>
<html>
    <head>
      <title>SecureBank</title>
      <link rel="icon" type="image/ico" href="favicon.ico"/>
      <!-- Bootstrap 3.3.5 -->
      <link rel="stylesheet" href="/Vendor/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="/Vendor/bootstrap/css/dataTables.bootstrap.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <!-- Theme style -->
	    <link rel="stylesheet" href="/Vendor/theme/AdminLTE.min.css">
	    <link rel="stylesheet" href="/Vendor/theme/header.css">
	    <link rel="stylesheet" href="/Vendor/theme/skin.min.css">
      <style>
        .login-page {
          background-image: url("/Vendor/img/login_bg.png");
          background-size: cover;
        }
        .login-page .login-logo a {
          color:white;
        }
        .login-page h1 {
          color:white;
        }
      </style>
    </head>
    <body class="hold-transition<?= $t->get("is_login")?" login-page":" skin-black sidebar-mini";?>">
      <?php $t->block("body", function ($t) { ?>
          Default
      <?php }); ?>
      <script src="/Vendor/js/jQuery-2.1.4.min.js"></script>
      <script src="/Vendor/bootstrap/js/bootstrap.min.js"></script>
      <script src="/Vendor/js/jquery.dataTables.min.js"></script>
      <script src="/Vendor/js/dataTables.bootstrap.min.js"></script>
      <script src="/Script/app.js"></script>
      <script src="/Vendor/js/app.js"></script>
    </body>
    <!-- Modals -->

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
                Are you sure you want to approve the registration?
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
                <h4 class="modal-title">Reject Registration</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to reject the registration?
                </div><!-- /.box-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Approve</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</html>