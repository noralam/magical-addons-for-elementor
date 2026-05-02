		
(function($){
	"use strict";
	
	// handlers
	$(document).ready(function() {

		$('.mgvlight').venobox(); 
		$('*').removeClass('no-load'); 

		

		
	});

    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mg_banner_widget.default", function (scope, $) {
       
            var mgvVeno = $(scope).find(".mgcla-btn2-veno");
            // var mgsLoop = mgsSlider.data('loop');
                  
            $(mgvVeno).venobox(); 
        });
    })    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgcall_to_action_widget.default", function (scope, $) {
       
            var mgvVeno = $(scope).find(".mgcla-btn2-veno");
            // var mgsLoop = mgsSlider.data('loop');
                  
            $(mgvVeno).venobox(); 
        });
    })
       
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mg_dual_button_widget.default", function (scope, $) {
       
            var mgvVeno = $(scope).find(".mgcla-btn2-veno");
            // var mgsLoop = mgsSlider.data('loop');
                  
            $(mgvVeno).venobox(); 
        });
    })
   




})(jQuery);