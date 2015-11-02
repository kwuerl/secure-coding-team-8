<?php $t->extend("app_base.html.php"); ?>
<?php $t->set("profile_href", "/profile"); ?>
<?php $t->block("sidebar", function ($t) { ?>
	<ul class="sidebar-menu">
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
	</ul>
<?php }); ?>