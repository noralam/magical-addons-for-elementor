/**
 * Magical Addons GSAP Feature Notice
 * 
 * @package Magical_Addons_For_Elementor
 * @since 1.3.15
 */

(function($) {
    'use strict';

    $(document).on('click', '.mg-gsap-admin-notice .notice-dismiss', function() {
        if (typeof mgGsapNotice === 'undefined') {
            return;
        }

        $.ajax({
            url: mgGsapNotice.ajaxurl,
            type: 'POST',
            data: {
                action: 'mg_dismiss_gsap_notice',
                nonce: mgGsapNotice.nonce
            }
        });
    });

})(jQuery);
