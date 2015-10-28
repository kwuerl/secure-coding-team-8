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
                    "pageLength": 3,
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

            // adjusting height of sidebar after the dom is created
            $('.main-sidebar').css({'height':(($(document).height()))+'px'});
        });
    }
};
// initializing the secure bank application custom js
secureBank.init();