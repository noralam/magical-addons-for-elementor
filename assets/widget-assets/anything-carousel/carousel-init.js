(function ($) {
    "use strict";

    /**
     * Initialize Swiper for MG Anything Carousel widget.
     *
     * @param {jQuery} $scope The widget element scope.
     */
    function initMgAnythingCarousel($scope) {
        var $wrapper = $scope.find('.mg-ce-wrapper');
        if (!$wrapper.length) {
            return;
        }

        // Do NOT initialize Swiper in the Elementor editor (editing mode).
        // Editor CSS will show slides stacked for drag-and-drop editing.
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode()) {
            return;
        }

        // Ensure Swiper constructor is available
        if (typeof Swiper === 'undefined') {
            console.warn('MG Anything Carousel: Swiper library not loaded.');
            $wrapper.addClass('mg-ce-ready'); // show content even without slider
            return;
        }

        var $swiperEl = $wrapper.find('.mg-ce-swiper');
        if (!$swiperEl.length) {
            return;
        }

        // Parse config from data attribute
        var config = $wrapper.data('swiper-config');
        if (!config || typeof config !== 'object') {
            return;
        }

        // Add swiper-slide class to each nested child container
        // (Elementor renders children as .elementor-element containers)
        $swiperEl.find('.swiper-wrapper > .elementor-element').each(function () {
            $(this).addClass('swiper-slide mg-ce-slide');
        });

        // Scope navigation and pagination selectors to this widget instance
        // using DOM element references (avoids conflicts with multiple carousels)
        if (config.navigation) {
            config.navigation.nextEl = $wrapper.find('.mg-ce-arrow-next').get(0);
            config.navigation.prevEl = $wrapper.find('.mg-ce-arrow-prev').get(0);
        }
        if (config.pagination) {
            config.pagination.el = $wrapper.find('.mg-ce-pagination').get(0);
        }
        if (config.scrollbar) {
            config.scrollbar.el = $wrapper.find('.mg-ce-scrollbar').get(0);
        }

        // Disable loop when there is only 1 slide (nothing to loop)
        var slideCount = $swiperEl.find('.swiper-slide').length;
        if (config.loop && slideCount <= 1) {
            config.loop = false;
        }

        // Destroy existing Swiper instance if re-initializing
        if ($swiperEl.data('swiperInstance')) {
            $swiperEl.data('swiperInstance').destroy(true, true);
        }

        // Initialize Swiper on the DOM element
        var swiperInstance = new Swiper($swiperEl.get(0), config);

        // Store reference for cleanup
        $swiperEl.data('swiperInstance', swiperInstance);

        // Reveal carousel now that Swiper is initialized
        $wrapper.addClass('mg-ce-ready');

        // Pause on hover handler (for both regular autoplay and marquee mode)
        if (config.autoplay && config.autoplay.pauseOnMouseEnter) {
            $swiperEl.on('mouseenter.mgce', function () {
                if (swiperInstance.autoplay && swiperInstance.autoplay.running) {
                    swiperInstance.autoplay.stop();
                }
            });
            $swiperEl.on('mouseleave.mgce', function () {
                if (swiperInstance.autoplay) {
                    swiperInstance.autoplay.start();
                }
            });
        }

        // Marquee mode: ensure seamless looping by resetting transition on end
        if (config.autoplay && config.autoplay.delay === 0 && config.freeMode) {
            // This is marquee mode - add CSS class for smooth animation
            $wrapper.addClass('mg-ce-marquee-active');
        }
    }

    // Hook into Elementor frontend
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/mg_carousel_everything.default',
            function ($scope) {
                initMgAnythingCarousel($scope);
            }
        );
    });

}(jQuery));
