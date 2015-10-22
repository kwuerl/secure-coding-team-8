<?php $t->extend("user_overview.html.php"); ?>

<?php $t->block("content", function ($t) { ?>
        <!-- Content Wrapper. Contains page content -->
              <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                  <h1>
                    Profile
                  </h1>
                  <ol class="breadcrumb">
                    <li><a href="/overview"><i class="fa fa-dashboard"></i> Home</a></li>
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
                              <label>Name</label>
                              <div>Vivek Sethia</div>
                            </div>
                            <div class="form-group">
                              <label >Email</label>
                              <div>sethiavivek2006@gmail.com</div>
                            </div>
                            <div class="form-group">
                              <label>Account No.</label>
                              <div>2242243555</div>
                            </div>
                          </div><!-- /.box-body -->
                        </form>
                      </div><!-- /.box -->
                    </div>
                  </div>
                </section>
              </div>
<?php });












