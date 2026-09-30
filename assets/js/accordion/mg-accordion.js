(function () {
    'use strict';

    function openPanel(panel, trigger) {
        panel.style.maxHeight = panel.scrollHeight + 'px';
        panel.classList.add('show');
        trigger.classList.remove('collapsed');
        trigger.setAttribute('aria-expanded', 'true');
    }

    function closePanel(panel) {
        var accordion = panel.closest('.mgaccordion');
        var triggerId = panel.getAttribute('id');
        var trigger = accordion.querySelector('[aria-controls="' + triggerId + '"]');

        panel.style.maxHeight = '0';
        panel.classList.remove('show');
        if (trigger) {
            trigger.classList.add('collapsed');
            trigger.setAttribute('aria-expanded', 'false');
        }
    }

    function initAccordion(container) {
        if (!container) return;
        var el = (container && container[0]) ? container[0] : container;
        if (!el || typeof el.querySelectorAll !== 'function') return;

        var openPanels = el.querySelectorAll('.mgaccont.show');
        var j;
        for (j = 0; j < openPanels.length; j++) {
            openPanels[j].style.maxHeight = openPanels[j].scrollHeight + 'px';
        }

        var triggers = el.querySelectorAll('.mgrc-title');
        var i;

        for (i = 0; i < triggers.length; i++) {
            if (triggers[i].hasAttribute('data-mg-accordion-init')) {
                continue;
            }
            triggers[i].setAttribute('data-mg-accordion-init', 'true');

            triggers[i].addEventListener('click', function () {
                var contentId = this.getAttribute('aria-controls');
                var content = document.getElementById(contentId);
                if (!content) return;

                var accordion = this.closest('.mgaccordion');
                var isOpen = content.classList.contains('show');

                if (accordion) {
                    var openPanels = accordion.querySelectorAll('.mgaccont.show');
                    var k;
                    for (k = 0; k < openPanels.length; k++) {
                        if (openPanels[k] !== content) {
                            closePanel(openPanels[k]);
                        }
                    }
                }

                if (isOpen) {
                    closePanel(content);
                } else {
                    openPanel(content, this);
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var accordions = document.querySelectorAll('.mgaccordion');
        var i;
        for (i = 0; i < accordions.length; i++) {
            initAccordion(accordions[i]);
        }
    });

    // Elementor frontend integration
    function bindElementorHook() {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks && typeof elementorFrontend.hooks.addAction === 'function') {
            elementorFrontend.hooks.addAction('frontend/element_ready/mgaccordion_widget.default', function (scope) {
                var target = (scope && scope[0]) ? scope[0] : scope;
                initAccordion(target);
            });
            return true;
        }
        return false;
    }

    if (typeof jQuery !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', bindElementorHook);
    } else {
        window.addEventListener('elementor/frontend/init', bindElementorHook);
    }

    // In case elementor/frontend/init has already fired
    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks && typeof elementorFrontend.hooks.addAction === 'function') {
        bindElementorHook();
    }
})();
