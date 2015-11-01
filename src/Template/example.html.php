<?php $t->extend("base.html.php"); ?>
<?php $t->block("body", function ($t) { ?>
<div>
    Hello World<br>
    url_param <?= $t->get("url_param"); ?> <br>
    config_param <?= $t->get("fixed_param"); ?> 
</div>
<?php });