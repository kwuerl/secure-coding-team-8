<?php $t->set("is_login", false); ?>
<html>
    <head>
        <title>SecureBank</title>
        <link rel="icon" type="image/ico" href="favicon.ico"/>
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/Vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/Vendor/bootstrap/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/Vendor/theme/AdminLTE.min.css">
        <link rel="stylesheet" href="/Vendor/theme/header.css">
        <link rel="stylesheet" href="/Vendor/theme/skin.min.css">
        <link rel="stylesheet" href="/Vendor/bootstrap/fonts/glyphicons-halflings-regular.eot">
        <link rel="stylesheet" href="/Style/app.css">
    </head>
    <body class="hold-transition<?= $t->get("is_login")?" login-page":" skin-black sidebar-mini";?>">
        <?php $t->block("body", function ($t) { ?>
        Default
        <?php }); ?>
        <script src="/Vendor/js/jQuery-2.1.4.min.js"></script>
        <script src="/Vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="/Vendor/js/jquery.dataTables.min.js"></script>
        <script src="/Vendor/js/dataTables.bootstrap.min.js"></script>
        <script src="/Script/app.js"></script>
        <script src="/Vendor/js/app.js"></script>
    </body>
</html>