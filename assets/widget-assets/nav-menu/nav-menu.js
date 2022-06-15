(function ($) {
    "use strict";

   var MoveInlineMenu = function ($scope, $) {
        var container_menu = $scope.find('.mgnav-menu').eq(0);
        if ( container_menu.length > 0 ){
            
            $('.mgmnav-open').on('click', function() {
                $(this).hide();
                $(this).siblings().show();
                $(this).closest('.mgnav-menu').find('.mgnav-menu-list').slideDown();
            });

            $('.mgmnav-close').on('click', function() {
                $(this).hide();
                $(this).siblings().show();
                $(this).closest('.mgnav-menu').find('.mgnav-menu-list').slideUp();
            });

             $(".mgnav-menu ul>li.menu-item.menu-item-has-children a").click(function(){
                $(this).next(".sub-menu").slideToggle();
            });

        }
    }
   $(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction('frontend/element_ready/mgnav_menu_widget.default', MoveInlineMenu);
    
    });

}(jQuery));