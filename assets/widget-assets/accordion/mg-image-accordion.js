var ImageAccordionHandler = function ($scope, $) {
		
    };

(function ($) {
    "use strict";

    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mg_imgaccordion.default", function (scope, $) {
            var image_accordion = $(scope).find(".mg-image-accordion").eq(0);
           let settingsDiv =  $(image_accordion).closest('.elementor-element');

            var elementSettings = settingsDiv.data('settings');
            let $action  = elementSettings.accordion_action;
		    let $id         = image_accordion.attr( 'id' );
		    let $item        = $('#'+ $id +' .mg-image-accordion-item');
		   
		if ( 'on-hover' === $action ) {
            $item.hover(
                function ImageAccordionHover() {
                    $item.css('flex', '1');
                    $item.removeClass('mg-image-accordion-active');
                    $(this).addClass('mg-image-accordion-active');
                    $item.find('.mg-image-accordion-content-wrap').removeClass('mg-image-accordion-content-active');
                    $(this).find('.mg-image-accordion-content-wrap').addClass('mg-image-accordion-content-active');
                    $(this).css('flex', '3');
                },
                function() {
                    $item.css('flex', '1');
                    $item.find('.mg-image-accordion-content-wrap').removeClass('mg-image-accordion-content-active');
                    $item.removeClass('mg-image-accordion-active');
                }
            );
        }
		else if ( 'on-click' === $action ) {
            $item.click( function(e) {
                e.stopPropagation(); // when you click the button, it stops the page from seeing it as clicking the body too
                $item.css('flex', '1');
				$item.removeClass('mg-image-accordion-active');
                $(this).addClass('mg-image-accordion-active');
				$item.find('.mg-image-accordion-content-wrap').removeClass('mg-image-accordion-content-active');
				$(this).find('.mg-image-accordion-content-wrap').addClass('mg-image-accordion-content-active');
                $(this).css('flex', '3');
            });

            $('#'+ $id).click( function(e) {
                e.stopPropagation(); // when you click within the content area, it stops the page from seeing it as clicking the body too
            });

            $('body').click( function() {
                $item.css('flex', '1');
				$item.find('.mg-image-accordion-content-wrap').removeClass('mg-image-accordion-content-active');
				$item.removeClass('mg-image-accordion-active');
            });
		}

           

        });
    })



}(jQuery));	