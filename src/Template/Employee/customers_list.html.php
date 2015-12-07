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
                                        <?php $t->formh($t->get("form"), array(
                                            "action"=>"/customers/approve", 
                                            "method"=>"post", 
                                            "data-confirm-modal"=>"", 
                                            "data-modal-title"=>"Approve Registration", 
                                            "data-modal-body"=>"Are you sure you want to approve the registration?"
                                        ), function ($t) use ($customer) { ?>
                                            <input name='action_customer_registration[customer_id]' type='hidden' value='<?= $t->s($customer->getId()); ?>'/>
                                            <button type="submit" name="action_customer_registration[action]" value="approve" class="btn btn-info">Approve</button>
                                        <?php }); ?>
                                        <?php $t->formh($t->get("form"), array(
                                            "action"=>"/customers/reject", 
                                            "method"=>"post", 
                                            "data-confirm-modal"=>"", 
                                            "data-modal-title"=>"Reject Registration", 
                                            "data-modal-body"=>"Are you sure you want to reject the registration?"
                                        ), function ($t) use ($customer) { ?>
                                            <input name='action_customer_registration[customer_id]' type='hidden' value='<?= $t->s($customer->getId()); ?>'/>
                                            <button type="submit" name="action_customer_registration[action]" value="reject" class="btn btn-reject">Reject</button>
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
                                        <button type="button" class="btn btn-info set-balance" data-customer-id="<?= $t->s($customer->getId()); ?>">Set Balance</button>
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
                <?php $t->formh($t->get("balance_form"), array("action"=>"/customers/balance", "method"=>"post", "id"=>"balance_form"), function ($t) { ?>
                <div class="form-group has-feedback <?php if (sizeof($balance_errors) > 0) echo "has-error"; ?>">
                    <input id="balance_customer_id" name='action_customer_balance[customer_id]' type='hidden' value=''/>
                    <input type="number" class="form-control" placeholder="Balance" name="action_customer_balance[balance]" value="" required>
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