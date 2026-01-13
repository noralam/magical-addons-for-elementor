(function($){
	"use strict";

jQuery(document).ready(function($) {

	$('.mgad-dismiss').on('click',function(){
			var url = new URL(location.href);
			url.searchParams.append('mgpdismissed',1);
			location.href= url;
		});
		$('.tinfo-hide').on('click',function(){
			var url = new URL(location.href);
			url.searchParams.append('tinfohide',1);
			location.href= url;
		});

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

    // Features notice dismissal
    $(document).on('click', '.magical-dismiss-features-notice', function(e) {
        e.preventDefault();
        var $notice = $(this).closest('.magical-features-notice');
        
        $.post(magicalAdminInfo.ajaxurl, {
            action: 'magical_dismiss_review',
            notice_type: 'features',
            nonce: magicalAdminInfo.nonce
        });
        
        $notice.fadeOut();
    });
});

})(jQuery);