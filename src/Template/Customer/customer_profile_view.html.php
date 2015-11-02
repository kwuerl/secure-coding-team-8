<?php $t->extend("Customer/customer_base.html.php"); ?>
<?php $t->set("menu_active", "profile"); ?>

<?php $t->block("content", function ($t) {
    $currentUser = $t->current_user(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="/overview"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Profile</li>
        </ol>
    </section>
    <!-- Main content -->
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
                                <label>First Name</label>
                                <div>
                                    <?= $t->s($currentUser->getFirstName()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <div>
                                    <?= $t->s($currentUser->getLastName()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <div>
                                    <?= $t->s($currentUser->getEmail()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <div>
                                    <?= $t->s($currentUser->getAddress()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <div>
                                    <?= $t->s($currentUser->getCity()); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Postal Code</label>
                                <div>
                                    <?= $t->s($currentUser->getPostalCode()); ?>
                                </div>
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