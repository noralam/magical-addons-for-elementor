(function($){
	"use strict";

jQuery(document).ready(function($) {

    // Review notice AJAX dismiss
    $(document).on('click', '.magical-dismiss-review-notice', function(e) {
        e.preventDefault();

        $.ajax({
            url: magicalAdminInfo.ajaxurl,
            type: 'POST',
            data: {
                action: 'magical_dismiss_review',
                nonce: magicalAdminInfo.nonce
            },
            success: function() {
                $('.magical-review-notice').fadeOut();
            }
        });
    });

});

})(jQuery);