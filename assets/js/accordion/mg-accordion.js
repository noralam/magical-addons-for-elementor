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
        var triggers = container.querySelectorAll('.mgrc-title');
        var i;

        for (i = 0; i < triggers.length; i++) {
            triggers[i].addEventListener('click', function () {
                var contentId = this.getAttribute('aria-controls');
                var content = document.getElementById(contentId);
                if (!content) return;

                var accordion = this.closest('.mgaccordion');
                var isOpen = content.classList.contains('show');

                if (accordion) {
                    var openPanels = accordion.querySelectorAll('.mgaccont.show');
                    var j;
                    for (j = 0; j < openPanels.length; j++) {
                        if (openPanels[j] !== content) {
                            closePanel(openPanels[j]);
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
        var i, j, openPanels;
        for (i = 0; i < accordions.length; i++) {
            openPanels = accordions[i].querySelectorAll('.mgaccont.show');
            for (j = 0; j < openPanels.length; j++) {
                openPanels[j].style.maxHeight = openPanels[j].scrollHeight + 'px';
            }
            initAccordion(accordions[i]);
        }
    });

    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/mgaccordion_widget.default', function (scope) {
            initAccordion(scope);
        });
    }
})();
