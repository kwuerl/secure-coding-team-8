/**
 * application js file
 *
 * @author Vivek Sethia<vivek.sethia@tum.de>
 */

"use strict";
var secureBank = {
    init : function(){
        $(document).ready(function(){
            // enabling click functionality on user name click ( for prfoile view or logout )
           /* $('.dropdown-toggle').on('click', function(){
                if( !$(".user-menu").hasClass('open'))
                    $(".user-menu").parent().addClass('open');
                else
                    $(".user-menu").parent().removeClass('open');
            });
            $('.sidebar-menu li').each(function(){
                $(this).on("click",function(event){
                    console.log('hi');
                    if( !$(this).hasClass('active'))
                        $(this).addClass('active');
                    else
                        $(this).removeClass('active');

                });
            });*/

            // initializing all the data tables
            $('.app-data-table').each(function () {
                // var source = $(this).attr("data-source");
                $(this).dataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "pageLength": 10,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': [-1]
                    }],
                    /* to remove pagination text when no data is there in the table */
                    "fnDrawCallback":function(){
                        var paginate_id = $(this).attr('id')+"_paginate";
                        if( $('#'+paginate_id+' > ul li').length == 2)  {
                            $('#'+paginate_id).parent().parent().css('display',"none");
                        }
                    }
                });
            });
            // for download of pdf
            $('#downloadPDF').on('click',function(){
                document.forms['download_pdf_form'].submit();
            });

            // for removing the notification message ( if any)
            $('.app-notification-success').fadeOut(5000);
            $('.app-notification-error').fadeOut(5000);

            // for clearing the make transfer form when cler button is clicked
            $('button.clear').on('click', function(event){
                event.preventDefault();
                $('input').each(function(){
                    $(this).val('');
                    $(this).next().removeClass();
                    $(this).next().text('');
                    $(this).parent().removeClass('has-error');
                });
                $('textarea').val('');
            });
            // adjusting height of sidebar after the dom is created
            $('.main-sidebar').css({'height':(($(document).height()))+'px'});

            // ==== Approve/ Reject Transaction operations =======//
            $('#approve_trans_table').find('.btn-info').on('click',function(){
                var transaction_id = $(this).parent().parent().find('td.app-transaction-id').html();
                $('#selectedTransactionId').val(transaction_id);
                $('#action_transaction').val(1);
            });

            $('#approve_trans_table').find('.btn-reject').on('click',function(){
                var transaction_id = $(this).parent().parent().find('td.app-transaction-id').html();
                $('#selectedTransactionId').val(transaction_id);
                $('#action_transaction').val(2);
            });

            $('#approveTransModal').find('.btn-primary').on('click',function(){
                var approval_form = document.forms['approve_transaction'];
                approval_form.submit();
            });

            $('#rejectTransModal').find('.btn-primary').on('click',function(){
                var approval_form = document.forms['approve_transaction'];
                approval_form.submit();
            });
            // ==== Approve/ Reject Transaction operations ends =======//

            // ==== Approve/ Reject Registration operations =======//
            $('#employee_regsitrations_table .btn-info').on('click',function(){
                var employee_id = $(this).parent().attr('id');
                $('#selectedUserId').val(employee_id);
                $('#action_registration').val(1);
            });

            $('#employee_regsitrations_table .btn-reject').on('click',function(){
                var employee_id = $(this).parent().attr('id');
                $('#selectedUserId').val(employee_id);
                $('#action_registration').val(2);
            });

            $('#customer_reg_pending .btn-info').on('click',function(){
                var employee_id = $(this).parent().attr('id');
                $('#selectedUserId').val(employee_id);
                $('#action_registration').val(1);
            });

            $('#customer_reg_pending .btn-reject').on('click',function(){
                var employee_id = $(this).parent().attr('id');
                $('#selectedUserId').val(employee_id);
                $('#action_registration').val(2);
            });

            $('#approveRegModal').find('.btn-primary').on('click',function(){
                var action_registration_form = document.forms['action_registration_form'];
                action_registration_form.submit();
            });

            $('#rejectRegModal').find('.btn-primary').on('click',function(){
                var action_registration_form = document.forms['action_registration_form'];
                action_registration_form.submit();
            });
        });
    }
};
// initializing the secure bank application custom js
secureBank.init();