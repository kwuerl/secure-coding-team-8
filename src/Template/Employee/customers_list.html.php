<?php $t->extend("Employee/employee_base.html.php"); ?>
<?php $t->set("menu_active", "customers"); ?>
<?php $t->block("content", function ($t) {
    $customerList = $t->get("customerList");
    $customerRegistrationList = $t->get("customerRegistrationList");
     ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<div class="flash-echo">
<?php $t->flash_echo(); ?>
</div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pending Registrations
        </h1>
        <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Customers</li>
        </ol>
    </section>
    <?php $t->formh($t->get("form"), array("action"=>"/customers", "method"=>"post"), function ($t) { ?>
    <input id='selectedUserId' name='selectedUserId' type='hidden' value=''/>
    <input id='action_registration' name='action_registration' type='hidden' value=''/>
    <input id='account_balance' name='account_balance' type='hidden' value=''/>
    <?php }) ?>
    <!-- Registration Pending Customers -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="customer_reg_pending" class="table table-bordered table-striped app-data-table-small">
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
                                <?php foreach($customerRegistrationList as $customer) {?>
                                <tr>
                                    <td>
                                        <?= $t->s($customer->getId()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($customer->getFirstName()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($customer->getLastName()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($customer->getEmail()); ?>
                                    </td>
                                    <td id=<?= "'".$customer->getId()."'>" ?>
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
    <!-- Registered Customers -->
    <section class="content-header">
        <h1>
            Registered Customers
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <table id="tbl_registered_customers" class="table table-bordered table-striped app-data-table-small">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Id</th>
                                    <th class="width_10">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($customerList as $customer) {?>
                                <tr>
                                    <td>
                                        <?= $t->s($customer->getId()); ?>
                                    </td>
                                    <td>
                                        <a href=
                                            '<?= $t->s("/customer_details/" . $customer->getId() . ""); ?>'>
                                        <?= $t->s($customer->getFirstName()); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $t->s($customer->getLastName()); ?>
                                    </td>
                                    <td>
                                        <?= $t->s($customer->getEmail()); ?>
                                    </td>
                                    <td class="actions" id=<?= "'".$customer->getId()."'>" ?>
                                    <?php if (!$customer->getIsAccountBalanceInitialized()) {?>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#setBalanceModal">Set Balance</button>
                                    <?php }?>
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
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
<!-- Set Balance Modal -->
<div id="setBalanceModal" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class='fa fa-times'></i></button>
                <h4 class="modal-title">Set Balance</h4>
            </div>
            <div class="modal-body">
                <?php $t->formh($t->get("form"), array("action"=>"/form", "method"=>"post"), function ($t) { ?>
                <?php
                    $balance_errors = $t->get("form")->getError("balance");
                    ?>
                <div class="form-group has-feedback <?php if (sizeof($balance_errors) > 0) echo "has-error"; ?>">
                    <?php if (sizeof($balance_errors) > 0) { ?>
                    <label for="form_set_balance[balance]" class="control-label"><span class="glyphicon glyphicon-remove-circle"></span> <?= $balance_errors[0] ?></label>
                    <?php } ?>
                    <input type="number" class="form-control" placeholder="Balance" name="form_set_balance[balance]" value="<?= $t->s($t->get('form')->getValue('balance')); ?>" required>
                </div>
                <?php }); ?>
            </div>
            <!-- /.box-body -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php });