<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "employees"); ?>
<?php $t->block("content", function ($t) {
    $employeeList = $t->get("employeeList");
    $employeeRegistrationList = $t->get("employeeRegistrationList");
     ?>
<div class="content-wrapper">
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pending Registrations
        </h1>
        <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Employees</li>
        </ol>
    </section>
    <?php $t->flash_echo(); ?>
    <?php $t->formh($t->get("form"), array("action"=>"/employees", "method"=>"post"), function ($t) { ?>
    <input id='selectedUserId' name='selectedUserId' type='hidden' value=''/>
    <input id='action_registration' name='action_registration' type='hidden' value=''/>
    <?php }) ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="employee_regsitrations_table" class="table table-bordered table-striped app-data-table">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Id</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($employeeRegistrationList as $employee) {?>
                                <tr>
                                    <td>
                                        <?= $t->s($employee->getFirstName()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($employee->getLastName()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($employee->getEmail()); ?>
                                    </td>
                                    <td id=<?= "'".$employee->getId()."'>" ?>
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#approveRegModal">Approve</button>
                                    <button type="button" class="btn btn-reject" data-toggle="modal" data-target="#rejectRegModal">Reject</button>
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
    <!-- Registered Employees -->
    <section class="content-header">
        <h1>
            Registered Employees
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="emp_list_table" class="table table-bordered table-striped app-data-table">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($employeeList as $employee) {?>
                                <tr>
                                    <td>
                                        <?= $t->s($employee->getFirstName()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($employee->getLastName()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($employee->getEmail()); ?>
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
<!-- Approve Registration Modal -->
<div id="approveRegModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class='fa fa-times'></i></button>
                <h4 class="modal-title">Approve Registration</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to approve the registration?
            </div>
            <!-- /.box-body -->
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
                <button type="button" class="close" data-dismiss="modal"><i class='fa fa-times'></i></button>
                <h4 class="modal-title">Reject Registration</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to reject the registration?
            </div>
            <!-- /.box-body -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Reject</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->
<?php });