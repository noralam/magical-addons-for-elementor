(function ($) {
    "use strict";


var mgContentReveal = function ($scope, $) {
		var	contentWrapper      = $scope.find('.mg-content-reveal-content-wrapper'),
			$content 			= $scope.find('.mg-content-reveal-content'),
			$saparator 			= $scope.find('.mg-content-reveal-saparator'),
			$button				= $scope.find('.mg-content-reveal-button-inner'),
			contentOuterHeight 	= $content.outerHeight(),
			contentVisibility   = contentWrapper.data('visibility'),
			contentHeightCustom = contentWrapper.data('content-height'),
			speedUnreveal       = contentWrapper.data('speed') * 1000,
			contentHeightLines  = contentWrapper.data('lines'),
			contentLineHeight   = $scope.find('.mg-content-reveal-content p').css('line-height'),
			contentPaddingTop 	= $content.css('padding-top');

        if ( contentVisibility == 'lines' ) {
            if ( contentHeightLines == '0' ) {
                var contentWrapperHeight = contentWrapper.outerHeight();
            } else {
                var contentWrapperHeight = (parseInt(contentLineHeight, 10) * contentHeightLines) + parseInt(contentPaddingTop, 10);
                contentWrapper.css( 'height', (contentWrapperHeight + 'px') );
            }
        } else {
            contentWrapper.css( 'height', (contentHeightCustom + 'px') );
            contentWrapperHeight = contentHeightCustom;
        }

		$button.on('click', function () {
			$saparator.slideToggle(speedUnreveal);
			$(this).toggleClass('mg-content-revealed');
			$(this).find('.mg-content-reveal-button-open').slideToggle(speedUnreveal);
			$(this).find('.mg-content-reveal-button-closed').slideToggle(speedUnreveal);
			if ( $button.hasClass('mg-content-revealed') ) {
				contentWrapper.animate({ height: ( contentOuterHeight + 'px') }, speedUnreveal);
			} else {
				contentWrapper.animate({ height: ( contentWrapperHeight + 'px') }, speedUnreveal);

				$('html, body').animate({
					scrollTop: ( contentWrapper.offset().top - 50 ) + 'px'
				});
			}
		});
    };


   $(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction('frontend/element_ready/mg_contentReveal.default', mgContentReveal);
    
    });

}(jQuery));