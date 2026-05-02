/**
 * MG Anything Carousel — Editor: Nested Element Type + Real Swiper Preview
 *
 * Registers the widget as a nested element type (required for child containers)
 * and provides a custom View that listens for the "Preview Mode" panel switcher
 * to toggle between stacked editing layout and a real Swiper carousel preview.
 *
 * Key points:
 * - Editor JS runs in the PARENT frame (Elementor editor).
 * - The widget DOM lives inside the PREVIEW IFRAME.
 * - NestedView's this.$el is already an iframe-jQuery element, so
 *   DOM manipulation works directly.
 * - Swiper constructor must be fetched from the iframe's window context
 *   because that's where the DOM nodes live.
 */
(function () {
	'use strict';

	/* ─── Helper: render icon HTML from Elementor icon control value ─── */
	function renderIconHtml(iconSetting, fallbackClass) {
		if (!iconSetting || !iconSetting.value) {
			return '<i class="' + fallbackClass + '" aria-hidden="true"></i>';
		}
		if (typeof iconSetting.value === 'object' && iconSetting.value.url) {
			return '<img src="' + iconSetting.value.url + '" aria-hidden="true" style="width:1em;height:1em;" />';
		}
		return '<i class="' + iconSetting.value + '" aria-hidden="true"></i>';
	}

	/**
	 * Get the Swiper constructor from the preview iframe.
	 *
	 * The widget DOM lives in the iframe, so we MUST use the iframe's
	 * Swiper class — using parent-frame Swiper (if any) would fail
	 * because the DOM nodes belong to the iframe document.
	 */
	function getSwiperClass() {
		try {
			// Method 1: elementorFrontend lives inside the iframe
			if (
				typeof elementorFrontend !== 'undefined' &&
				elementorFrontend.utils &&
				elementorFrontend.utils.swiper
			) {
				return elementorFrontend.utils.swiper;
			}
		} catch (e) {}

		try {
			// Method 2: grab from the iframe window directly
			var iframeEl =
				elementor.$preview && elementor.$preview[0]
					? elementor.$preview[0]
					: document.getElementById(
							'elementor-preview-iframe'
					  );
			if (iframeEl && iframeEl.contentWindow) {
				var iw = iframeEl.contentWindow;
				// Elementor may expose it on elementorFrontend inside the iframe
				if (
					iw.elementorFrontend &&
					iw.elementorFrontend.utils &&
					iw.elementorFrontend.utils.swiper
				) {
					return iw.elementorFrontend.utils.swiper;
				}
				if (iw.Swiper) {
					return iw.Swiper;
				}
			}
		} catch (e) {}

		// Method 3: global Swiper in parent frame (fallback)
		if (typeof Swiper !== 'undefined') {
			return Swiper;
		}

		return null;
	}

	elementorCommon.elements.$window.on(
		'elementor/nested-element-type-loaded',
		function () {
			var NestedElementBase =
				elementor.modules.elements.types.NestedElementBase;
			var NestedView =
				$e.components.get('nested-elements').exports
					.NestedView;

			if (!NestedElementBase || !NestedView) {
				return;
			}

			/* ───────────────────────────────────────
			 *  Custom View — real Swiper preview
			 * ─────────────────────────────────────── */
			var MgCarouselView = NestedView.extend({
				_swiperInstance: null,
				_bound: false,

				onRender: function () {
					if (
						MgCarouselView.__super__ &&
						MgCarouselView.__super__.onRender
					) {
						MgCarouselView.__super__.onRender.apply(
							this,
							arguments
						);
					}
					this._bindPreviewToggle();
					this._bindSlideLabels();

					// Restore preview mode + update labels after DOM settles
					var self = this;
					setTimeout(function () {
						self._updateSlideLabels();
						// Re-apply preview if setting is still on (persists across re-renders)
						var isOn = self.model
							.get('settings')
							.get('mg_ce_editor_preview_mode');
						if (isOn === 'yes') {
							self._setPreviewMode(true);
						}
					}, 200);
				},

				onDestroy: function () {
					this._destroySwiper();
					if (this._slideObserver) {
						this._slideObserver.disconnect();
						this._slideObserver = null;
					}
					if (
						MgCarouselView.__super__ &&
						MgCarouselView.__super__.onDestroy
					) {
						MgCarouselView.__super__.onDestroy.apply(
							this,
							arguments
						);
					}
				},

				/* ---------- slide label numbering ---------- */
				_labelsBound: false,

				_bindSlideLabels: function () {
					if (this._labelsBound) return;
					this._labelsBound = true;

					var self = this;
					var settingsModel =
						this.model.get('settings');

					// Update labels when slides are added / removed / reordered
					this.listenTo(
						settingsModel,
						'change:mg_ce_slides',
						function () {
							setTimeout(function () {
								self._updateSlideLabels();
							}, 200);
						}
					);

					// Also observe DOM for new slides added dynamically
					var wrapperEl = this.$el
						.find('.mg-ce-swiper-wrapper')
						.get(0);
					if (wrapperEl && typeof MutationObserver !== 'undefined') {
						this._slideObserver = new MutationObserver(
							function () {
								self._updateSlideLabels();
							}
						);
						this._slideObserver.observe(
							wrapperEl,
							{ childList: true }
						);
					}
				},

				_updateSlideLabels: function () {
					var $slides = this.$el
						.find('.mg-ce-swiper-wrapper')
						.first()
						.children('.mg-ce-slide');

					$slides.each(function (index) {
						var $slide = jQuery(this);
						var $label = $slide.children(
							'.mg-ce-slide-label'
						);

						// Create label if it doesn't exist
						if (!$label.length) {
							$slide.prepend(
								'<span class="mg-ce-slide-label"></span>'
							);
							$label = $slide.children(
								'.mg-ce-slide-label'
							);
						}

						$label.text('Slide ' + (index + 1));
					});
				},

				/* ---------- listen to the panel switcher ---------- */
				_bindPreviewToggle: function () {
					// Only bind once (onRender may fire multiple times)
					if (this._bound) return;
					this._bound = true;

					var self = this;
					var settingsModel =
						this.model.get('settings');

					// Listen for the Backbone change event on the setting
					this.listenTo(
						settingsModel,
						'change:mg_ce_editor_preview_mode',
						function () {
							var val = settingsModel.get(
								'mg_ce_editor_preview_mode'
							);
							self._setPreviewMode(
								val === 'yes'
							);
						}
					);

					// Re-init Swiper when carousel settings change in preview mode
					var carouselSettings = [
						'mg_ce_slides_per_view',
						'mg_ce_slides_per_view_tablet',
						'mg_ce_slides_per_view_mobile',
						'mg_ce_slides_to_scroll',
						'mg_ce_space_between',
						'mg_ce_space_between_tablet',
						'mg_ce_space_between_mobile',
						'mg_ce_speed',
						'mg_ce_loop',
						'mg_ce_autoplay',
						'mg_ce_autoplay_delay',
						'mg_ce_effect',
						'mg_ce_direction',
						'mg_ce_show_arrows',
						'mg_ce_show_dots',
						'mg_ce_pagination_type',
					];
					carouselSettings.forEach(function (key) {
						self.listenTo(
							settingsModel,
							'change:' + key,
							function () {
								var isOn = settingsModel.get(
									'mg_ce_editor_preview_mode'
								);
								if (isOn === 'yes') {
									self._setPreviewMode(true);
								}
							}
						);
					});

					// Restore state if already on (e.g. returning to a widget)
					// Note: onRender also handles restore, but this covers
					// the first bind before onRender's setTimeout fires
				},

				/* ---------- toggle preview on / off ---------- */
				_setPreviewMode: function (isPreview) {
					var $wrapper = this.$el
						.find('.mg-ce-wrapper')
						.first();
					if (!$wrapper.length) return;

					if (isPreview) {
						$wrapper.addClass(
							'mg-ce-preview-mode'
						);
						// Hide slide labels
						$wrapper
							.find('.mg-ce-slide-label')
							.hide();
						this._initSwiper($wrapper);
					} else {
						this._destroySwiper();
						$wrapper.removeClass(
							'mg-ce-preview-mode'
						);
						// Show slide labels again
						$wrapper
							.find('.mg-ce-slide-label')
							.show();
					}
				},

				/* ---------- initialise real Swiper ---------- */
				_initSwiper: function ($wrapper) {
					var self = this;

					// Destroy first in case toggle is rapid
					this._destroySwiper();

					var settings =
						this.model.get('settings').attributes;
					var $swiperEl = $wrapper
						.find('.mg-ce-swiper')
						.first();
					var $swiperWrapper = $wrapper
						.find('.mg-ce-swiper-wrapper')
						.first();
					var $slides =
						$swiperWrapper.children('.mg-ce-slide');

					if (!$swiperEl.length || !$slides.length)
						return;

					// Add Swiper DOM classes
					$swiperEl.addClass('swiper');
					$swiperWrapper.addClass('swiper-wrapper');
					$slides.addClass('swiper-slide');

					// Apply dots position class
					var dotsPos =
						settings.mg_ce_dots_position ||
						'outside-bottom';
					$wrapper
						.removeClass(
							'mg-ce-dots-inside-bottom mg-ce-dots-outside-bottom mg-ce-dots-inside-top'
						)
						.addClass('mg-ce-dots-' + dotsPos);

					// Create navigation arrows
					var showArrows =
						settings.mg_ce_show_arrows === 'yes';
					var showPagination =
						settings.mg_ce_show_dots === 'yes';

					if (
						showArrows &&
						!$wrapper.children('.mg-ce-arrow').length
					) {
						var prevHtml = renderIconHtml(
							settings.mg_ce_arrow_prev_icon,
							'fas fa-chevron-left'
						);
						var nextHtml = renderIconHtml(
							settings.mg_ce_arrow_next_icon,
							'fas fa-chevron-right'
						);
						$wrapper.append(
							'<div class="mg-ce-arrow mg-ce-arrow-prev">' +
								prevHtml +
								'</div>' +
								'<div class="mg-ce-arrow mg-ce-arrow-next">' +
								nextHtml +
								'</div>'
						);
					}

					if (
						showPagination &&
						!$wrapper.children('.mg-ce-pagination')
							.length
					) {
						$wrapper.append(
							'<div class="swiper-pagination mg-ce-pagination"></div>'
						);
					}

					// Build Swiper config from widget settings
					var config = {
						slidesPerView:
							parseInt(
								settings.mg_ce_slides_per_view
							) || 1,
						slidesPerGroup:
							parseInt(
								settings.mg_ce_slides_to_scroll
							) || 1,
						spaceBetween:
							parseInt(
								settings.mg_ce_space_between
							) || 20,
						speed:
							parseInt(settings.mg_ce_speed) ||
							500,
						loop:
							settings.mg_ce_loop === 'yes',
						grabCursor:
							settings.mg_ce_grab_cursor ===
							'yes',
						direction:
							settings.mg_ce_direction ||
							'horizontal',
						effect:
							settings.mg_ce_effect || 'slide',
						observer: true,
						observeParents: true,
					};

					// Allow Touch Move (default yes)
					if (
						settings.mg_ce_allow_touch_move !==
						'yes'
					) {
						config.allowTouchMove = false;
					}

					// Initial Slide
					var initialSlide =
						parseInt(
							settings.mg_ce_initial_slide
						) || 1;
					if (initialSlide > 1) {
						config.initialSlide =
							initialSlide - 1;
					}

					// Rewind (when loop is off)
					if (
						!config.loop &&
						settings.mg_ce_rewind === 'yes'
					) {
						config.rewind = true;
					}

					// Autoplay
					if (
						settings.mg_ce_autoplay === 'yes'
					) {
						config.autoplay = {
							delay:
								parseInt(
									settings.mg_ce_autoplay_delay
								) || 3000,
							disableOnInteraction: false,
							pauseOnMouseEnter:
								settings.mg_ce_pause_on_hover ===
								'yes',
						};

						// Reverse direction
						if (
							settings.mg_ce_reverse_direction ===
							'yes'
						) {
							config.autoplay.reverseDirection = true;
						}
					}

					// Marquee / Continuous Scroll (Pro)
					if (
						settings.mg_ce_marquee === 'yes'
					) {
						config.loop = true;
						config.freeMode = true;
						config.allowTouchMove = false;
						config.speed =
							parseInt(
								settings.mg_ce_marquee_speed
							) || 5000;
						config.autoplay = {
							delay: 0,
							disableOnInteraction: false,
							reverseDirection:
								settings.mg_ce_marquee_direction ===
								'ltr',
							pauseOnMouseEnter:
								settings.mg_ce_marquee_pause_hover ===
								'yes',
						};
					}

					// Responsive breakpoints
					var tabletSpv = parseInt(settings.mg_ce_slides_per_view_tablet) || 0;
					var mobileSpv = parseInt(settings.mg_ce_slides_per_view_mobile) || 0;
					var tabletSpace = parseInt(settings.mg_ce_space_between_tablet) || 0;
					var mobileSpace = parseInt(settings.mg_ce_space_between_mobile) || 0;

					if (tabletSpv || mobileSpv) {
						config.breakpoints = {
							320: {
								slidesPerView: mobileSpv || 1,
								spaceBetween: mobileSpace || 10,
							},
							768: {
								slidesPerView: tabletSpv || 1,
								spaceBetween: tabletSpace || 15,
							},
							1024: {
								slidesPerView: config.slidesPerView,
								spaceBetween: config.spaceBetween,
							},
						};
					}

					// Navigation
					if (showArrows) {
						config.navigation = {
							nextEl: $wrapper
								.find('.mg-ce-arrow-next')
								.get(0),
							prevEl: $wrapper
								.find('.mg-ce-arrow-prev')
								.get(0),
						};
					}

					// Pagination
					if (showPagination) {
						var paginationType =
							settings.mg_ce_pagination_type ||
							'bullets';
						config.pagination = {
							el: $wrapper
								.find('.mg-ce-pagination')
								.get(0),
							type: paginationType,
							clickable:
								settings.mg_ce_clickable_dots ===
								'yes',
						};
					}

					// Disable loop only when there is 1 or 0 slides
					if (
						config.loop &&
						$slides.length <= 1
					) {
						config.loop = false;
					}

					// Delay to let the CSS class apply and layout settle
					setTimeout(function () {
						var SwiperClass = getSwiperClass();
						if (!SwiperClass) {
							console.warn(
								'MG Carousel: Swiper not found. Ensure Swiper is loaded in the preview.'
							);
							return;
						}

						try {
							// Elementor's Swiper may be a promise-based wrapper
							if (
								SwiperClass.prototype &&
								SwiperClass.prototype.constructor
							) {
								self._swiperInstance =
									new SwiperClass(
										$swiperEl.get(0),
										config
									);
							} else {
								// Async wrapper (returns a promise)
								new SwiperClass(
									$swiperEl.get(0),
									config
								).then(function (
									instance
								) {
									self._swiperInstance =
										instance;
								});
							}
						} catch (err) {
							console.warn(
								'MG Carousel: Swiper init error',
								err
							);
						}
					}, 300);
				},

				/* ---------- destroy Swiper + cleanup ---------- */
				_destroySwiper: function () {
					if (this._swiperInstance) {
						try {
							this._swiperInstance.destroy(
								true,
								true
							);
						} catch (e) {}
						this._swiperInstance = null;
					}

					var $wrapper = this.$el
						.find('.mg-ce-wrapper')
						.first();
					if (!$wrapper.length) return;

					// Remove Swiper classes
					$wrapper
						.find('.mg-ce-swiper')
						.first()
						.removeClass('swiper');
					$wrapper
						.find('.mg-ce-swiper-wrapper')
						.first()
						.removeClass('swiper-wrapper');
					$wrapper
						.find('.mg-ce-slide')
						.removeClass('swiper-slide');

					// Remove dynamically-added nav / pagination
					$wrapper.children('.mg-ce-arrow').remove();
					$wrapper
						.children('.mg-ce-pagination')
						.remove();

					// Clean Swiper inline styles
					$wrapper
						.find('.mg-ce-swiper')
						.first()
						.removeAttr('style');
					$wrapper
						.find('.mg-ce-swiper-wrapper')
						.first()
						.removeAttr('style');
					$wrapper
						.find('.mg-ce-slide')
						.removeAttr('style');
				},
			});

			/* ───────────────────────────────────────
			 *  Element Type — uses the custom view
			 * ─────────────────────────────────────── */
			class MgAnythingCarousel extends NestedElementBase {
				getType() {
					return 'mg_carousel_everything';
				}
				getView() {
					return MgCarouselView;
				}
			}

			elementor.elementsManager.registerElementType(
				new MgAnythingCarousel()
			);
		}
	);
})();
