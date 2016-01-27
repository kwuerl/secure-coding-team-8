/**
 * application js file
 *
 * @author Vivek Sethia<vivek.sethia@tum.de>
 */

"use strict";
var secureBank = {
    init : function(){
        $(document).ready(function(){
            // initializing all the data tables
            $('.app-data-table').each(function () {
                // var source = $(this).attr("data-source");
                $(this).dataTable({
                    "paging": true,
                    "aaSorting": [],
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "pageLength": 10,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': [-1]
                    }]
                });
            });

            // initializing all the data tables
            $('.app-data-table-small').each(function () {
                // var source = $(this).attr("data-source");
                $(this).dataTable({
                    "paging": true,
                    "aaSorting": [],
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "pageLength": 5,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': [-1]
                    }]
                });
            });
            // for download of pdf
            $('#downloadPDF').on('click',function(){
                document.forms['download_pdf_form'].submit();
            });

            // for removing the notification message ( if any)
            $('.app-notification-success').fadeOut(5000);
            $('.app-notification-error').fadeOut(5000);

            // for clearing the make transfer form when clear button is clicked
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
            $(document).on("submit", "form[data-confirm-modal]", function(event) {
                var confirm_modal = $(' \
                    <!-- Approve Transaction Modal --> \
                    <div id="confirm-modal" class="modal fade" role="dialog" tabindex="-1"> \
                        <div class="modal-dialog"> \
                            <!-- Modal content--> \
                            <div class="modal-content"> \
                                <div class="modal-header"> \
                                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button> \
                                    <h4 class="modal-title">'+$(this).attr("data-modal-title")+'</h4> \
                                </div> \
                                <div class="modal-body"> \
                                    '+$(this).attr("data-modal-body")+' \
                                </div> \
                                <!-- /.box-body --> \
                                <div class="modal-footer"> \
                                    <button type="submit" class="btn btn-primary">Yes</button> \
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> \
                                </div> \
                            </div> \
                        </div> \
                    </div>');
                $("body").append(confirm_modal);
                $('#confirm-modal').on('hidden.bs.modal', function(){
                    $('#confirm-modal').remove();
                });
                event.preventDefault();
                var that = this;
                $('#confirm-modal').modal("show");
                $('#confirm-modal').find('.btn-primary').on('click', function() {
                    $(this).unbind("click");
                    that.submit();ps

                });
            });

            $(document).on("click", ".set-balance", function(event) {
                $('#balance_customer_id').val($(this).attr("data-customer-id"));
                $('#setBalanceModal').modal("show");
                $('#setBalanceModal').find('.btn-primary').on('click', function() {
                    $(this).unbind("click");
                    $('#balance_form').submit();
                });
            });
        });
    }
};
// initializing the secure bank application custom js
secureBank.init();