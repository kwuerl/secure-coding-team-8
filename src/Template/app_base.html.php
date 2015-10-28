<?php $t->extend("base.html.php"); ?>
<?php $t->set("menu_active", "home"); ?>
<?php $t->set("profile_href", "/profile"); ?>
<?php $t->block("body", function ($t) { ?>
<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>B</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Secure</b>Bank</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Tasks: style can be found in dropdown.less -->
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">Alexander Pierce</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href='<?= $t->get("profile_href") ?>'>
                            Profile
                            </a>
                            <a href="/logout" >
                            Sign out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <!-- <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div> -->
        </div>
        <!-- search form
            <form action="#" method="get" class="sidebar-form">
              <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
              </div>
            </form> -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?php $t->block("sidebar", function ($t) { ?>
        <?php }); ?>
    </section>
    <!-- /.sidebar -->
</aside>
<?php $t->block("content", function ($t) { ?>
Default
<?php }); ?>
<?php });