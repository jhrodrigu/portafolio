/*--------------------------------------
*         Table of Content
*  --------------------------------------
*  1. Coming Soon Page
*  2. Pagination JS
*  -------------------------------------- 
*  -------------------------------------- */

jQuery(document).ready(function($){'use strict';

    /* --------------------------------------
    *       1. Coming Soon Page
    *  -------------------------------------- */
    if (typeof loopcounter !== 'undefined') {
        loopcounter('counter-class');
    }

    /*----------------------------------
    *        2. Pagination JS           
    ------------------------------------ */
    if( $('.mythos-pagination').length > 0 ){
        if( !$(".mythos-pagination ul li:first-child a").hasClass('prev') ){ 
            $(".mythos-pagination ul").prepend('<li class="p-2 first"><span>'+$(".mythos-pagination").data("preview")+'</span></li>');
        }
        if( !$(".mythos-pagination ul li:last-child a").hasClass('next') ){ 
            $(".mythos-pagination ul").append('<li class="p-2 first"><span>'+$(".mythos-pagination").data("nextview")+'</span></li>');
        }
        $(".mythos-pagination ul li:last-child").addClass("ml-auto");
        $(".mythos-pagination ul").addClass("justify-content-start").find('li').addClass('p-2').eq(1).addClass('ml-auto');
    }

    //Menu Close Button
    if ($('#hamburger-menu').length > 0) {
        var button = document.getElementById('hamburger-menu');
        var span = button.getElementsByTagName('span')[0];

        button.onclick =  function() {
            span.classList.toggle('hamburger-menu-button-close');
        };

        $('#hamburger-menu').on('click', toggleOnClass);
        function toggleOnClass(event) {
            var toggleElementId = '#' + $(this).data('toggle'),
            element = $(toggleElementId);
            element.toggleClass('on');
        }

        // close hamburger menu after click a
        $( '.menu li a' ).on("click", function(){
            $('#hamburger-menu').click();
        });

        // Menu Toggler Rotate
        $('#mobile-menu ul li span.menu-toggler').click(function(){
            $(this).toggleClass('toggler-rotate');
        })
    }


    
});


