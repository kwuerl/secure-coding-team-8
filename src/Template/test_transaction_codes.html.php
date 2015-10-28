<?php $t->extend("base.html.php"); ?>
<?php $t->block("body", function ($t) { ?>
	<ul>
		<?php foreach ($t->get("transaction_codes") as $code) {
			echo "<li>".$code->getCode()."</li>";
		} ?>
	</ul>
<?php }); ?>