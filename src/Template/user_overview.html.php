<?php $t->extend("base.html.php"); ?>
<?php $t->set("menu_active", "home"); ?>
<?php
    $t->block("body", function ($t) {
        $current_user = $t->get("currentUser")->getGroupsPlain();
        if (strpos($current_user, ",")) $current_user = explode(",", $current_user)[0];
        switch($current_user) {
            case _GROUP_USER : $profile_href = '/profile';
                                break;
            case _GROUP_EMPLOYEE : $profile_href = '/employee_profile';
                                break;
            case _GROUP_ADMIN : $profile_href = '/employee_profile';
                                break;
            default : break;
        }
    ?>
<header class="main-header">
    <!-- Logo -->
    <a class="logo">
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
                    <span class="hidden-xs"><?= $t->s($t->get("currentUser")->getFirstName())." ".$t->s($t->get("currentUser")->getLastName()); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <a href='
                                <?= "" . $profile_href . "" ?>'>
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
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <?php switch($current_user){
                case _GROUP_USER : ?>
            <li class="treeview<?= $t->get('menu_active')=="home"?" active":""; ?>">
                <a href="/overview">
                <i class="fa fa-home"></i>
                <span>Home</span>
                </a>
            </li>
            <li class="treeview<?= $t->get('menu_active')=="profile"?" active":""; ?>">
                <a href="/profile">
                <i class="fa fa-user"></i>
                <span>Profile</span>
                </a>
            </li>
            <li class="treeview<?= $t->get('menu_active')=="transaction_history"?" active":""; ?>">
                <a href="/transaction_history">
                <i class="fa fa-history"></i>
                <span>Transaction History</span>
                </a>
            </li>
            <li class="treeview<?= $t->get('menu_active')=="make_transfer"?" active":""; ?>">
                <a href="/make_transfer">
                <i class="fa fa-money"></i>
                <span>Make Transfer</span>
                </a>
            </li>
            <li class="treeview<?= $t->get('menu_active')=="statement"?" active":""; ?>">
                <a href="/statement">
                <i class="fa fa-tasks"></i>
                <span>Statement</span>
                </a>
            </li>
            <?php break;
                case _GROUP_ADMIN :
                case _GROUP_EMPLOYEE : ?>
            <li class="treeview<?= $t->get('menu_active')=="employee_overview"?" active":""; ?>">
                <a href="/employee_overview">
                <i class="fa fa-home"></i>
                <span>Home</span>
                </a>
            </li>
            <li class="treeview<?= $t->get('menu_active')=="employee_profile"?" active":""; ?>">
                <a href="/employee_profile">
                <i class="fa fa-user"></i>
                <span>Profile</span>
                </a>
            </li>
            <li class="treeview<?= $t->get('menu_active')=="customers"?" active":""; ?>">
                <a href="/customers">
                <i class="fa fa-users"></i>
                <span>Customers</span>
                </a>
            </li>
            <?php if ($current_user === _GROUP_ADMIN) { ?>
            <li class="treeview<?= $t->get('menu_active')=="employees"?" active":""; ?>">
                <a href="/employees">
                <i class="fa fa-users"></i>
                <span>Employees</span>
                </a>
            </li>
            <?php } ?>
            <li class="treeview<?= $t->get('menu_active')=="approve_transactions"?" active":""; ?>">
                <a href="/transactions">
                <i class="fa fa-tasks"></i>
                <span>Pending Transactions</span>
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