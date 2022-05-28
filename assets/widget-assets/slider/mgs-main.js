(function ($) {
	"use strict";
    
     $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgslider_lite_widget.default", function (scope, $) {

        	
       
            var mgsSlider = $(scope).find(".mgs-main");
            var mgsLoop = mgsSlider.data('loop');
            var mgsEffect = mgsSlider.data('effect');
            var mgsDirection = mgsSlider.data('direction');
            var mgsSpeed = mgsSlider.data('speed');
            var mgsAutoplay = mgsSlider.data('autoplay');
            var mgsAutoDelay = mgsSlider.data('auto-delay');
            var mgsGrabCursor = mgsSlider.data('grab-cursor');
            var mgsNav = mgsSlider.data('nav');
            var mgsDots = mgsSlider.data('dots');

            if(mgsAutoplay == true){
              var autoPlayData = {
                    delay: mgsAutoDelay,
                    disableOnInteraction: false,
                  };
            }else{
              var autoPlayData = false;
            }


            var mgsSwiper = new Swiper (mgsSlider, {
                  // Optional parameters
                  direction: mgsDirection, // vertical
                  loop: mgsLoop,
                  effect: mgsEffect, //"slide", "fade", "cube", "coverflow" or "flip"
                  speed: mgsSpeed,
                  autoplay: autoPlayData,
                 // autoHeight: true,
                 // mousewheel: true,
                  grabCursor: mgsGrabCursor,
                  parallax: true,
                  watchSlidesProgress: true,
                  watchSlidesVisibility: true,
                  pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                  },
                  navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                  },
                })

            /*mgTimeline.timeline({
              forceVerticalMode: 800,
              mode: 'horizontal',
              visibleItems: 4
            });*/        
            
        });
    })
   


}(jQuery));	


