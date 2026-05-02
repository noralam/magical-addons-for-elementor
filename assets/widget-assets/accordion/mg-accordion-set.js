(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgaccordion_widget.default", function (scope, $) {

        	
       
            var beefupElement = $(scope).find(".beefup");
            /*
            var displayType = clockElement.data('display-type');
            var clockFormat = clockElement.data('clock-format');
           
            var  clockTimeFormate = ('12' == clockFormat) ? "TwelveHourClock" : "TwentyFourHourClock";
                
                clockElement.FlipClock({
                    clockFace: clockTimeFormate
                });
                */
                beefupElement.beefup({
                    openSingle: true,
                stayOpen: 'last'
                });
           
            
        });
    })
   


}(jQuery));	


