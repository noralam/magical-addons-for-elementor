/* (function ($) {
    "use strict";
    
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgprogressbar_widget.default", function (scope) {
            var mgProgressBars = $(scope).find(".mg-progress");
            
            mgProgressBars.each(function() {
                var progressBar = $(this);
                var progressValue = progressBar.data('percent');
                var animationDuration = progressBar.data('speed') || 2000; // Default to 2000ms if data-speed is not set
                var progressLine = progressBar.find('.progress-line');
                var progressText = progressBar.find('.mgp-percent');

                // Set initial text to 0% and make it visible
                progressText.text('0%').css('visibility', 'visible');
                
                // Animate both the progress line width and the percentage text
                $({ width: 0, countNum: 0 }).animate({ width: progressValue, countNum: progressValue }, {
                    duration: animationDuration,
                    easing: 'swing',
                    step: function (now, fx) {
                        if (fx.prop === "width") {
                            progressLine.css('width', now + '%');
                        } else if (fx.prop === "countNum") {
                            progressText.text(Math.floor(now) + '%');
                        }
                    }
                });
            });
        });
    });

}(jQuery));
 */


(function ($) {
    "use strict";
    
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/mgprogressbar_widget.default", function (scope) {
            var mgProgressBars = $(scope).find(".mg-progress");

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var progressBar = $(entry.target);
                        var progressValue = progressBar.data('percent');
                        var animationDuration = progressBar.data('speed') || 2000; // Default to 2000ms if data-speed is not set
                        var progressLine = progressBar.find('.progress-line');
                        var progressText = progressBar.find('.mgp-percent');

                        // Set initial text to 0% and make it visible
                        progressText.text('0%').css('visibility', 'visible');
                        
                        // Animate both the progress line width and the percentage text
                        $({ width: 0, countNum: 0 }).animate({ width: progressValue, countNum: progressValue }, {
                            duration: animationDuration,
                            easing: 'swing',
                            step: function (now, fx) {
                                if (fx.prop === "width") {
                                    progressLine.css('width', now + '%');
                                } else if (fx.prop === "countNum") {
                                    progressText.text(Math.floor(now) + '%');
                                }
                            }
                        });

                        observer.unobserve(entry.target); // Stop observing once the animation is triggered
                    }
                });
            }, {
                threshold: 0.8 // Trigger the animation when 80% of the element is visible
            });

            mgProgressBars.each(function() {
                observer.observe(this); // Observe each progress bar
            });
        });
    });

}(jQuery));
