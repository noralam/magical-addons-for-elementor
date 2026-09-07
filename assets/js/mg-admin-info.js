(function($){
	"use strict";

	jQuery(document).ready(function($) {
		// Sales notice AJAX dismiss
		$(document).on('click', '.mg-sales-notice .mg-sales-dismiss-btn, .mg-sales-notice .notice-dismiss', function(e) {
			e.preventDefault();
			var $notice = $(this).closest('.mg-sales-notice');
			$notice.slideUp(250, function() {
				$notice.remove();
			});

			if (typeof magicalAdminInfo !== 'undefined' && magicalAdminInfo.ajaxurl && magicalAdminInfo.sales_nonce) {
				$.ajax({
					url: magicalAdminInfo.ajaxurl,
					type: 'POST',
					data: {
						action: 'magical_dismiss_sales_notice',
						nonce: magicalAdminInfo.sales_nonce
					}
				});
			}
		});
	});

})(jQuery);