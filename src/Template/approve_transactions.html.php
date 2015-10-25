<?php $t->extend("user_overview.html.php"); ?>
<?php $t->block("content", function ($t) { ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Approve Transactions
    </h1>
    <ol class="breadcrumb">
        <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/approve_transactions"><i class="fa fa-dashboard"></i> Approve Transactions</a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
    <!-- left column -->
    <div class="col-md-12">
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-body">
            <table id="approve_trans_table" class="table table-bordered table-striped app-data-table">
                <thead>
                    <tr>
                        <th>Transaction Id</th>
                        <th>To Account Number</th>
                        <th>Date of Transaction</th>
                        <th>Amount</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                </thead>
                <tbody>
                    <?php for($i=0;$i<10;$i++) { ?>
                    <tr>
                        <td>12222</td>
                        <td>46366346346</td>
                        <td>10.10.15</td>
                        <td>50004</td>
                        <td>For rent</td>
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
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box -->
    </div>
</section>
<?php }); ?>