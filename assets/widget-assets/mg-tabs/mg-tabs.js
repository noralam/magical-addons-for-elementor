

(function ($) {
	"use strict";

    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mg_tabs.default", function (scope, $) {
        var mgtabs = $(scope).find(".mg-tabs");
        var mgnavs = $(scope).find(".mg-tabs .nav-tabs");
            $( mgnavs).on('click', 'a', function(e){
            e.preventDefault();
        var tab  = $(this).parent(),
            tabIndex = tab.index(),
            tabPanel = $(this).closest(mgtabs),
            tabPane = tabPanel.find('.tab-pane').eq(tabIndex);
        tabPanel.find('.active').removeClass('active');
        tabPanel.find('.show').removeClass('show');
        $(this).addClass('active');
        tabPane.addClass('active show');
});
           
            
        });
    })
   


}(jQuery));	


