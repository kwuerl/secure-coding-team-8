<?php $t->extend("user_overview.html.php"); ?>
<?php $t->block("content", function ($t) { ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#customers" data-toggle="tab">Customers</a></li>
        <li><a href="#employees" data-toggle="tab">Employees</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="customers">
            <section class="content-header">
                <h1>
                    Customers Registration Details
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="active">Registrations</a></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <table id="regsitrations_table" class="table table-bordered table-striped app-data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email Id</th>
                                            <th>Account No.</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0; $i<15;$i++) { ?>
                                        <tr>
                                            <td>123450500</td>
                                            <td>10.10.2015</td>
                                            <td>1050</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#approveRegModal">Approve</button>
                                                <button type="button" class="btn btn-reject" data-toggle="modal" data-target="#rejectRegModal">Reject</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Account No.</th>
                                            <th>Email Id</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
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
        <!-- /.tab-pane -->
        <div class="tab-pane" id="employees">
            <section class="content-header">
                <h1>
                    Employees Registration Details
                </h1>
                <ol class="breadcrumb">
                    <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="active">Registrations</a></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-body">
                                <table id="regsitrations_table" class="table table-bordered table-striped app-data-table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email Id</th>
                                            <th>Account No.</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for($i=0; $i<15;$i++) { ?>
                                        <tr>
                                            <td>123450500</td>
                                            <td>10.10.2015</td>
                                            <td>1050</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#approveRegModal">Approve</button>
                                                <button type="button" class="btn btn-reject" data-toggle="modal" data-target="#rejectRegModal">Reject</button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Account No.</th>
                                            <th>Email Id</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
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
        <!-- /.tab-pane -->
    </div>
    <!-- nav-tabs-custom -->
</div>
<!-- /.content-wrapper -->
<?php });