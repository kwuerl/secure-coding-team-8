<?php $t->extend("app_base.html.php"); ?>
<?php $t->set("profile_href", "/employee_profile"); ?>
<?php $t->block("sidebar", function ($t) { ?>
    <ul class="sidebar-menu">
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
        <?php if ($t->current_user_has_group(_GROUP_ADMIN)) { ?>
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
            <span>Transactions</span>
            </a>
        </li>
    </ul>
<?php }); ?>