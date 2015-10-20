<?php $t->extend("example.html.php"); ?>

<?php $t->block("body", function ($t) { ?>
 <div>
 Hello World<br>
 test field: <?= $t->get("example")->getTestField(); ?> <br>
 </div>
 <?php });