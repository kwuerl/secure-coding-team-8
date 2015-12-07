<?php $t->extend("Employee/employee_base.html.php"); ?>
<?php $t->set("menu_active", "employees"); ?>
<?php $t->block("content", function ($t) {
    $employeeList = $t->get("employeeList");
    $employeeRegistrationList = $t->get("employeeRegistrationList");
     ?>
<div class="content-wrapper">
<div class="flash-echo">
<?php $t->flash_echo(); ?>
</div>
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
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="employee_regsitrations_table" class="table table-bordered table-striped app-data-table-small">
                            <thead>
                                <tr>
                                    <th>ID</th>
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
                                        <?= $t->s($employee->getId()); ?>
                                    </td>
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
                                    <?php $t->formh($t->get("form"), array(
                                        "action"=>"/employees/approve", 
                                        "method"=>"post", 
                                        "data-confirm-modal"=>"", 
                                        "data-modal-title"=>"Approve Registration", 
                                        "data-modal-body"=>"Are you sure you want to approve the registration?"
                                    ), function ($t) use ($employee) { ?>
                                        <input name='action_employee_registration[employee_id]' type='hidden' value='<?= $t->s($employee->getId()); ?>'/>
                                        <button type="submit" name="action_employee_registration[action]" value="approve" class="btn btn-info">Approve</button>
                                    <?php }); ?>
                                    <?php $t->formh($t->get("form"), array(
                                        "action"=>"/employees/reject", 
                                        "method"=>"post", 
                                        "data-confirm-modal"=>"", 
                                        "data-modal-title"=>"Reject Registration", 
                                        "data-modal-body"=>"Are you sure you want to reject the registration?"
                                    ), function ($t) use ($employee) { ?>
                                        <input name='action_employee_registration[employee_id]' type='hidden' value='<?= $t->s($employee->getId()); ?>'/>
                                        <button type="submit" name="action_employee_registration[action]" value="reject" class="btn btn-reject">Reject</button>
                                    <?php }); ?>
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
                        <table id="emp_list_table" class="table table-bordered table-striped app-data-table-small">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($employeeList as $employee) {?>
                                <tr>
                                    <td>
                                        <?= $t->s($employee->getId()); ?>
                                    </td>
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
<!-- /.content-wrapper -->
<?php });