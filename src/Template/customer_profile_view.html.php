<?php $t->extend("profile_view.html.php"); ?>
<?php $t->block("profile_details", function ($t) {
    $currentUser = $t->get("currentUser"); ?>
    <div class="form-group">
        <label>Address</label>
        <div>
            <?= $t->s($currentUser->getAddress()); ?>
        </div>
    </div>
    <div class="form-group">
        <label>City</label>
        <div>
            <?= $t->s($currentUser->getCity()); ?>
        </div>
    </div>
    <div class="form-group">
        <label>Postal Code</label>
        <div>
            <?= $t->s($currentUser->getPostalCode()); ?>
        </div>
    </div>
<?php }); ?>
<?php $t->set("menu_active", "profile"); ?>