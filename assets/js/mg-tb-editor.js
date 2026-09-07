/**
 * Magical Theme Builder - Elementor editor integration.
 *
 * Shows a small bar above the canvas when editing a theme template:
 *  - link to the admin Theme Builder (set/edit display conditions)
 *  - one-click install/activate of Magical Posts Display for single/archive types.
 *
 * @package MagicalAddons
 */
(function ($) {
	'use strict';

	if (typeof window.mgtbEditor === 'undefined') {
		return;
	}

	var cfg = window.mgtbEditor;

	/**
	 * Current document type from the editor config.
	 */
	function currentType() {
		try {
			return window.elementor && window.elementor.config && window.elementor.config.document
				? window.elementor.config.document.type
				: '';
		} catch (e) {
			return '';
		}
	}

	var THEME_TYPES = ['header', 'footer', 'single-post', 'single-page', 'archive', 'search-results', 'error-404'];
	var POSTS_TYPES = ['single-post', 'archive', 'search-results', 'error-404'];

	function buildBar() {
		var type = currentType();

		if (-1 === THEME_TYPES.indexOf(type)) {
			return;
		}

		var $bar = $('<div/>', { class: 'mgtb-editor-bar', id: 'mgtb-editor-bar' });

		$bar.append(
			$('<span/>', { class: 'mgtb-editor-bar-icon dashicons dashicons-admin-appearance' })
		);

		$bar.append(
			$('<span/>', { class: 'mgtb-editor-bar-text' }).text(cfg.i18n.typeLabel + ' — ')
		);

		$bar.append(
			$('<a/>', { href: cfg.adminUrl, target: '_blank', class: 'mgtb-editor-bar-link' }).text(cfg.i18n.editCond)
		);

		if (-1 !== POSTS_TYPES.indexOf(type) && 'active' !== cfg.postsDisplay) {
			$bar.append(
				$('<button/>', {
					type: 'button',
					class: 'components-button is-primary mgtb-editor-bar-cta',
					id: 'mgtb-editor-install'
				}).text(cfg.i18n.installMpd)
			);
		}

		if ($('#elementor-editor-wrapper').length) {
			$('#elementor-editor-wrapper').before($bar);
		} else {
			$('#elementor-preview').before($bar);
		}
	}

	function installPostsDisplay($btn) {
		var original = $btn.text();

		$btn.prop('disabled', true).text(cfg.i18n.installing);

		var request = function (path, data) {
			return $.ajax({
				url: cfg.restUrl + path,
				method: 'POST',
				contentType: 'application/json',
				data: JSON.stringify(data),
				beforeSend: function (xhr) {
					xhr.setRequestHeader('X-WP-Nonce', cfg.restNonce);
				}
			});
		};

		var run = ('installed' === cfg.postsDisplay)
			? request('activate-plugin', { slug: 'magical-posts-display' })
			: request('install-plugin', { slug: 'magical-posts-display', activate: true });

		run.done(function () {
			$btn.text(cfg.i18n.activated);
			setTimeout(function () {
				window.location.reload();
			}, 600);
		}).fail(function () {
			$btn.prop('disabled', false).text(original);
			window.alert(cfg.i18n.failed);
		});
	}

	$(function () {
		// The editor builds its DOM late; retry a few times.
		var attempts = 0;
		var timer = setInterval(function () {
			attempts++;
			if ($('#mgtb-editor-bar').length) {
				clearInterval(timer);
			} else if ($('#elementor-preview').length || $('#elementor-editor-wrapper').length) {
				buildBar();
				clearInterval(timer);
			} else if (attempts > 40) {
				clearInterval(timer);
			}
		}, 500);

		$(document).on('click', '#mgtb-editor-install', function (e) {
			e.preventDefault();
			installPostsDisplay($(this));
		});
	});
})(jQuery);
