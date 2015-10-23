<html>
    <head>
        <title>Hi</title>
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="Vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="Vendor/bootstrap/css/dataTables.bootstrap.css">

        <!-- Theme style -->
	    <link rel="stylesheet" href="Vendor/theme/AdminLTE.min.css">
	    <link rel="stylesheet" href="Vendor/theme/header.css">
	    <link rel="stylesheet" href="Vendor/theme/skin.min.css">
    </head>
    <body class="hold-transition
    <?php $t->block("body_classes", function ($t) { ?>
        skin-blue sidebar-mini
    <?php }); ?>
    ">
    <?php $t->block("body", function ($t) { ?>
        Default
    <?php }); ?>
     <script src="Vendor/js/jQuery-2.1.4.min.js"></script>
     <script src="Vendor/js/jquery.dataTables.min.js"></script>
     <script src="Vendor/js/dataTables.bootstrap.min.js"></script>


    <script>
            $(document).ready(function(){
                $('.dropdown-toggle').on('click', function(){
                   if( !$(this).parent().hasClass('open'))
                      $(this).parent().addClass('open');
                   else
                      $(this).parent().removeClass('open');
                 });

                  $("#example1").DataTable({
                                   "paging": true,
                                   "lengthChange": false,
                                   "searching": false,
                                   "ordering": true,
                                   "info": true,
                                   "autoWidth": false,
                                   "pageLength": 3
                               });
            });
     </script>
    </body>
</html>