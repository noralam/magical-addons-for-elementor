/**
 * Magical Theme Builder - admin one-click install/activate button.
 *
 * Wires the #mgtb-install-mpd button (from the admin dependency notice) to
 * the plugin install/activate REST endpoints.
 *
 * @package MagicalAddons
 */
(function ($) {
	'use strict';

	if (typeof window.mgtbAdmin === 'undefined') {
		return;
	}

	var cfg = window.mgtbAdmin;

	function request(path, data) {
		return $.ajax({
			url: cfg.restUrl + path,
			method: 'POST',
			contentType: 'application/json',
			data: JSON.stringify(data),
			beforeSend: function (xhr) {
				xhr.setRequestHeader('X-WP-Nonce', cfg.restNonce);
			}
		});
	}

	$(function () {
		$(document).on('click', '#mgtb-install-mpd', function (e) {
			e.preventDefault();

			var $btn = $(this);
			var status = $btn.data('status');
			var original = $btn.text();

			$btn.prop('disabled', true).text(cfg.i18n.installing);

			var run = ('installed' === status)
				? request('activate-plugin', { slug: 'magical-posts-display' })
				: request('install-plugin', { slug: 'magical-posts-display', activate: true });

			run.done(function () {
				$btn.text(cfg.i18n.done);
				setTimeout(function () {
					window.location.reload();
				}, 700);
			}).fail(function () {
				$btn.prop('disabled', false).text(original);
				window.alert(cfg.i18n.failed);
			});
		});
	});
})(jQuery);
