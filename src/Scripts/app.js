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
                    "pageLength": 3,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': [-1]
                    }]
                });
            });
            // adjusting height of sidebar after the dom is created
            $('.main-sidebar').css({'height':(($(document).height()))+'px'});
        });
    }
};
// initializing the secure bank application custom js
secureBank.init();