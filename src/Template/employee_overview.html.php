<?php $t->extend("user_overview.html.php"); ?>
<?php $t->set("menu_active", "employee_overview"); ?>
<?php $t->block("content", function ($t) { ?>
<div class="content-wrapper">
    
    <section>
        <div class="row">
            <?php $t->flash_echo(); ?>
        </div>
    </section>
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
        Account Overview
    </h1>
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Account Balance</label>
                                <div><i class='fa fa-eur'></i>1000</div>
                            </div>
                            <div class="form-group">
                                <label >Email</label>
                                <div>tom@cat.com</div>
                            </div>
                            <div class="form-group">
                                <label>Account No.</label>
                                <div>2242243555</div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<?php });