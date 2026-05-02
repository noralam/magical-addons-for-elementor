/**
 * Magical Addons - Conditional Display
 * Handles the display of custom notices when elements are conditionally hidden
 */
(function($) {
    'use strict';
    
    // Process all elements with custom notices
    function processConditionalNotices() {
        $('.mg-conditional-notice-wrapper').each(function() {
            var $element = $(this);
            var notice = $element.attr('data-mg-notice');
            
            if (notice) {
                // Clear any existing content
                $element.empty();
                
                // Add the notice
                $element.append('<div class="mg-conditional-notice">' + notice + '</div>');
                
                // Make sure the wrapper is visible
                $element.css('display', 'block');
            }
        });
    }
    
    // Run when the document is ready
    $(document).ready(function() {
        processConditionalNotices();
    });
    
    // Also run when Elementor frontend is initialized (for editor preview)
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
                processConditionalNotices();
            });
        }
    });
    
})(jQuery);