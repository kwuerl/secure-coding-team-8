<?php $t->extend("base.html.php"); ?>
<?php $t->block("body", function ($t) { ?>
<p>Dear <?= $t->s($t->get("user")->getFirstName()); ?> <?= $t->s($t->get("user")->getLastName()); ?>,<br>
    your registration was approved.<br>
    Here are your transaction codes:<br><br>
</p>
<table><?php
    $tans = $t->get("tans");
    foreach ($tans as $key => $tan) {
    	if ($key % 4 == 0) {
    		echo "<tr>";
    	}
    	echo "<td>".$tan->getCode()."</td>";
    	if ($key % 4 == 3) {
    		echo "</tr>";
    	}
    }
    ?></table>
<br>
<p>Now you can login with your e-mail and password and start making transactions.<br><br>
    Have a nice day,<br>
    your Secure Bank
</p>
<?php }); ?>