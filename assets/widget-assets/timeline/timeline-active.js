(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgtimeline_widget.default", function (scope, $) {

        	
       
            var mgTimeline = $(scope).find(".mg-timeline");

            mgTimeline.timeline({
              forceVerticalMode: 800,
              mode: 'horizontal',
              visibleItems: 4
            });        
            
        });
    })
   


}(jQuery));	


