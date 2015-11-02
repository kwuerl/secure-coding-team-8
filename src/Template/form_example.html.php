<?php $t->extend("base.html.php"); ?>
<?php $t->block("body", function ($t) { ?>
<?php $t->formh($t->get("form"), array("action"=>"/form_example"), function ($t) { ?>
<?php foreach ($t->get("form")->getError("test_field") as $error) { ?>
<?= $error ?><br>
<?php } ?>
<input type="text" name="test_form[test_field]">
<input type="submit" value="text">
<?php }); ?>
<?php }); ?>