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
            $('.dropdown-toggle').on('click', function(){
                if( !$(this).parent().hasClass('open'))
                    $(this).parent().addClass('open');
                else
                    $(this).parent().removeClass('open');
            });
            // initializing all the data tables which are present in the page
            $('.app-data-table').each(function () {
                // var source = $(this).attr("data-source");
                $(this).dataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "pageLength": 3
                });
            });
            // adjusting height of sidebar after the dom is created
            $('.main-sidebar').css({'height':(($(document).height()))+'px'});
        });
    }
};
// initializing the secure bank application custom js
secureBank.init();