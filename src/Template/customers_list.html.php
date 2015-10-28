<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "customers"); ?>
<?php $t->block("content", function ($t) {
    $customerList = $t->get("customerList"); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customers
        </h1>
        <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Customers</li>
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($customerList as $customer) {?>
                                <tr>
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
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email Id</th>
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
<!-- /.content-wrapper -->
<script></script>
<?php });