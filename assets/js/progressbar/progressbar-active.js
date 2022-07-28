(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgprogressbar_widget.default", function (scope, $) {

        	scope.find(".mg-progress").each(function(){
        		var element = $(this)[0];

				 var parcentShow = $(this).data('parcent-show');
				 var parcent = $(this).data('parcent');
				 var barcolor = $(this).data('barcolor');
				 var trailcolor = $(this).data('trailcolor');
				 var barheight = $(this).data('barheight');
				 var trailheight = $(this).data('trailheight');
				 var strokewidth = $(this).data('strokewidth');
				 var animationTime = $(this).data('animation-time');
				 var dividePercent = parcent / 100;

        	if(element){
        		if(parcentShow == 'yes'){
        		// with text
        	var bar = new ProgressBar.Line(element, {
			  strokeWidth: strokewidth,
			  easing: 'easeInOut',
			  duration: animationTime,
			  color: barcolor,
			  trailColor: trailcolor,
			  trailWidth: trailheight,
			  svgStyle: {width: '95%', height: barheight},
			  text: {
			  style: {
			      // Text color.
			      // Default: same as stroke color (options.color)
			      color: '#999',
			      position: 'absolute',
			      right: '0',
			      top: '0',
			      padding: 0,
			      margin: 0,
			      transform: null
			    },
			    autoStyleContainer: false
			  },
			  step: (state, bar) => {
    bar.setText(Math.round(bar.value() * 100) + ' %');
  }
			});
        }else{
        		// without text
        	var bar = new ProgressBar.Line(element, {
			  strokeWidth: strokewidth,
			  easing: 'easeInOut',
			  duration: animationTime,
			  color: barcolor,
			  trailColor: trailcolor,
			  trailWidth: trailheight,
			  svgStyle: {width: '100%', height: barheight},
			});
	}// with and without text check

		//	bar.animate(dividePercent);  // Number from 0.0 to 1.0
		$(this).closest('.elementor-container').waypoint(function(){
		       bar.animate(dividePercent);  // Number from 0.0 to 1.0
		    
		}, {offset: "100%"})

		} // check element
		}); //scop loop end





        }); // elementor hook
    }) // window

}(jQuery));	