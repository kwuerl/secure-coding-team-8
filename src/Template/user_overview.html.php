<?php $t->extend("base.html.php"); ?>

<?php
$t->block("body", function ($t) { $current_user = _GROUP_EMPLOYEE;
?>

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
              <a href="/profile">
               Profile
              </a>
                <a href="#" >
                Sign out
                </a>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
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
    <ul class="sidebar-menu">
    <?php switch($current_user){
        case _GROUP_USER : ?>
              <li class="treeview">
                <a href="/overview">
                  <span>Home</span>
                </a>
              </li>
              <li class="treeview">
                <a href="/profile">
                  <span>Profile</span>
                </a>
              </li>
               <li class="active treeview">
                 <a href="/transaction_history">
                     <span>Transaction History</span>
                  </a>
               </li>
                <li class="treeview">
                    <a href="/make_transfer">
                        <span>Make Transfer</span>
                     </a>
                </li>
       <?php break;
        case _GROUP_EMPLOYEE : ?>
                <li class="treeview active">
                <a href="/employee_overview">
                  <span>Home</span>
                </a>
              </li>
              <li class="treeview">
                <a href="/employee_profile">
                  <span>Profile</span>
                </a>
                <li class="treeview">
                    <a href="/customers">
                        <span>Customers</span>
                     </a>
                </li>
                <li class="treeview" >
                  <a href="/approve_registrations">
                    <span>Approve Registrations</span>
                  </a>
                </li>
                <li class="treeview" >
                  <a href="/approve_transactions">
                    <span>Approve Transactions</span>
                  </a>
                </li>
        <?php break;
        default : break;
        } ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<?php $t->block("content", function ($t) { ?>
   Default
<?php }); ?>
<?php });
