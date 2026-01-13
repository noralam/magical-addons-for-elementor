/**
 * Magical Addons GSAP Animations - Frontend Handler
 * 
 * Handles GSAP animations on the frontend for all Elementor elements
 * Supports: General, Text, Image, Background, Preset, and Advanced animations
 * 
 * @package Magical_Addons_For_Elementor
 * @since 1.3.15
 */

(function ($) {
    'use strict';
    
    // Check if jQuery is available
    if (typeof $ === 'undefined') {
        return;
    }

    // Store all animation instances for cleanup
    var mgGsapAnimations = {
        instances: [],
        scrollTriggers: [],
        gsapLoaded: false,
        initialized: false,

        /**
         * Initialize all GSAP animations on the page
         */
        init: function () {
            // Prevent double initialization
            if (this.initialized) {
                return;
            }
            this.initialized = true;
            
            // Check if GSAP is loaded
            if (typeof gsap === 'undefined') {
                this.showAllElements();
                return;
            }
            
            this.gsapLoaded = true;

            // Register ScrollTrigger plugin
            if (typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);
            }

            // Find and animate all elements with GSAP data
            this.initAnimations();

            // Listen for Elementor frontend events (for dynamically loaded content)
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks && typeof elementorFrontend.hooks.addAction === 'function') {
                elementorFrontend.hooks.addAction('frontend/element_ready/global', function(scope) {
                    mgGsapAnimations.initAnimations(scope);
                });
            }
        },

        /**
         * Fallback: Show all elements if GSAP fails to load
         */
        showAllElements: function () {
            var elements = document.querySelectorAll('.mg-gsap-animated');
            for (var i = 0; i < elements.length; i++) {
                elements[i].classList.add('mg-gsap-ready');
                elements[i].style.opacity = '1';
                elements[i].style.visibility = 'visible';
            }
        },

        /**
         * Initialize animations within a scope
         * @param {jQuery|HTMLElement} scope - Optional scope to search within
         */
        initAnimations: function (scope) {
            var self = this;
            var container = scope ? $(scope) : $(document);
            var elements = container.find('.mg-gsap-animated[data-mg-gsap]');

            elements.each(function(index, element) {
                self.createAnimation(element);
            });
        },

        /**
         * Create animation for a single element
         * @param {HTMLElement} element
         */
        createAnimation: function (element) {
            var $element = $(element);

            // Skip if already animated
            if ($element.data('mg-gsap-initialized')) {
                return;
            }

            // Get animation data
            var data;
            try {
                var jsonStr = $element.attr('data-mg-gsap');
                if (!jsonStr) {
                    this.showElement($element);
                    return;
                }
                data = JSON.parse(jsonStr);
            } catch (e) {
                this.showElement($element);
                return;
            }

            // Mark as initialized and ready
            $element.data('mg-gsap-initialized', true);
            $element.addClass('mg-gsap-ready');

            // Check if GSAP is available
            if (typeof gsap === 'undefined') {
                this.showElement($element);
                return;
            }

            // Make element visible and ready for animation
            gsap.set(element, { visibility: 'visible', opacity: 1 });

            // Build animation configuration based on mode
            var fromVars = this.buildFromVars(data);
            var toVars = this.buildToVars(data);

            // Create the animation
            if (data.scrollTrigger && typeof ScrollTrigger !== 'undefined') {
                this.createScrollTriggeredAnimation(element, data, fromVars, toVars);
            } else {
                this.createImmediateAnimation(element, data, fromVars, toVars);
            }
        },
        
        /**
         * Show a single element (fallback)
         */
        showElement: function($element) {
            $element.addClass('mg-gsap-ready').css({
                'opacity': '1',
                'visibility': 'visible'
            });
        },

        /**
         * Build "from" variables for animation
         * @param {Object} data - Animation data
         * @returns {Object}
         */
        buildFromVars: function (data) {
            var mode = data.mode || 'custom';
            
            // If preset mode, use quick preset handler
            if (mode === 'preset') {
                return this.buildQuickPresetFromVars(data.animation, data);
            }
            
            // Custom mode - route by category
            var category = data.category || 'general';
            var animationType = data.animation;

            // Route to appropriate handler based on category
            switch (category) {
                case 'text':
                    return this.buildTextFromVars(animationType, data);
                case 'image':
                    return this.buildImageFromVars(animationType, data);
                case 'background':
                    return this.buildBackgroundFromVars(animationType, data);
                case 'preset':
                    return this.buildPresetFromVars(animationType, data);
                case 'advanced':
                    return this.buildAdvancedFromVars(animationType, data);
                default:
                    return this.buildGeneralFromVars(animationType, data);
            }
        },

        /**
         * Build quick preset animation from vars (for preset mode)
         * Simple, pre-defined animations that work without any configuration
         */
        buildQuickPresetFromVars: function (animationType, data) {
            var fromVars = { opacity: 0 };

            switch (animationType) {
                // Fade animations
                case 'fade-up':
                    fromVars.y = 50;
                    break;
                case 'fade-down':
                    fromVars.y = -50;
                    break;
                case 'fade-left':
                    fromVars.x = 50;
                    break;
                case 'fade-right':
                    fromVars.x = -50;
                    break;
                case 'fade-in':
                    // Just opacity
                    break;

                // Zoom animations
                case 'zoom-in':
                    fromVars.scale = 0.5;
                    break;
                case 'zoom-out':
                    fromVars.scale = 1.5;
                    break;
                case 'zoom-in-up':
                    fromVars.scale = 0.5;
                    fromVars.y = 50;
                    break;
                case 'zoom-in-down':
                    fromVars.scale = 0.5;
                    fromVars.y = -50;
                    break;

                // Slide animations
                case 'slide-up':
                    fromVars.y = 100;
                    break;
                case 'slide-down':
                    fromVars.y = -100;
                    break;
                case 'slide-left':
                    fromVars.x = 100;
                    break;
                case 'slide-right':
                    fromVars.x = -100;
                    break;

                // Flip animations
                case 'flip-up':
                    fromVars.rotationX = 90;
                    fromVars.transformPerspective = 600;
                    break;
                case 'flip-down':
                    fromVars.rotationX = -90;
                    fromVars.transformPerspective = 600;
                    break;
                case 'flip-left':
                    fromVars.rotationY = 90;
                    fromVars.transformPerspective = 600;
                    break;
                case 'flip-right':
                    fromVars.rotationY = -90;
                    fromVars.transformPerspective = 600;
                    break;

                // Bounce & Elastic
                case 'bounce-in':
                    fromVars.scale = 0.3;
                    break;
                case 'bounce-up':
                    fromVars.y = 80;
                    fromVars.scale = 0.8;
                    break;
                case 'elastic-in':
                    fromVars.scale = 0;
                    break;
                case 'elastic-scale':
                    fromVars.scaleX = 0;
                    fromVars.scaleY = 0;
                    break;

                // Rotate animations
                case 'rotate-in':
                    fromVars.rotation = 180;
                    fromVars.scale = 0.5;
                    break;
                case 'rotate-in-up':
                    fromVars.rotation = 45;
                    fromVars.y = 50;
                    break;
                case 'rotate-in-down':
                    fromVars.rotation = -45;
                    fromVars.y = -50;
                    break;
                case 'spin-in':
                    fromVars.rotation = 360;
                    fromVars.scale = 0;
                    break;

                // Special effects
                case 'blur-in':
                    fromVars.filter = 'blur(20px)';
                    break;
                case 'clip-up':
                    fromVars.clipPath = 'inset(100% 0 0 0)';
                    break;
                case 'clip-left':
                    fromVars.clipPath = 'inset(0 100% 0 0)';
                    break;
                case 'skew-in':
                    fromVars.skewX = 30;
                    fromVars.skewY = 10;
                    break;
                case 'slide-skew':
                    fromVars.x = 100;
                    fromVars.skewX = 20;
                    break;

                // Text animations
                case 'text-fade-up':
                    fromVars.y = 30;
                    break;
                case 'text-reveal':
                    fromVars.clipPath = 'inset(0 100% 0 0)';
                    break;
                case 'text-typewriter':
                    fromVars.clipPath = 'inset(0 100% 0 0)';
                    break;
                case 'text-wave':
                    fromVars.y = 20;
                    fromVars.rotation = 5;
                    break;
                case 'text-bounce':
                    fromVars.y = -30;
                    fromVars.scale = 0.8;
                    break;

                // Image animations
                case 'img-zoom-in':
                    fromVars.scale = 1.3;
                    break;
                case 'img-reveal-up':
                    fromVars.clipPath = 'inset(100% 0 0 0)';
                    break;
                case 'img-rotate-in':
                    fromVars.rotation = 15;
                    fromVars.scale = 0.8;
                    break;
                case 'img-blur-in':
                    fromVars.filter = 'blur(15px)';
                    break;

                // Background animations
                case 'bg-fade':
                    // Just opacity
                    break;
                case 'bg-zoom-in':
                    fromVars.scale = 1.2;
                    break;
                case 'bg-parallax':
                    fromVars.y = 50;
                    break;
                case 'bg-blur-in':
                    fromVars.filter = 'blur(10px)';
                    break;
            }

            return fromVars;
        },

        /**
         * Build general animation from vars
         */
        buildGeneralFromVars: function (animationType, data) {
            const fromVars = {};

            // Base opacity for fade
            if (animationType === 'fade' || data.includeFade) {
                fromVars.opacity = 0;
            }

            switch (animationType) {
                case 'fade':
                    fromVars.opacity = 0;
                    break;

                case 'slide':
                    const distance = data.distance || 100;
                    switch (data.direction) {
                        case 'up': fromVars.y = distance; break;
                        case 'down': fromVars.y = -distance; break;
                        case 'left': fromVars.x = distance; break;
                        case 'right': fromVars.x = -distance; break;
                    }
                    break;

                case 'scale':
                    fromVars.scale = data.scaleFrom || 0.5;
                    fromVars.transformOrigin = data.transformOrigin || 'center center';
                    break;

                case 'rotate':
                    fromVars.rotation = data.rotateDegrees || 90;
                    fromVars.transformOrigin = data.transformOrigin || 'center center';
                    break;

                case 'flip':
                    fromVars.transformOrigin = data.transformOrigin || 'center center';
                    switch (data.direction) {
                        case 'up':
                        case 'down':
                            fromVars.rotationX = data.direction === 'up' ? 90 : -90;
                            break;
                        case 'left':
                        case 'right':
                            fromVars.rotationY = data.direction === 'left' ? 90 : -90;
                            break;
                    }
                    break;

                case 'bounce':
                    fromVars.y = -50;
                    fromVars.opacity = 0;
                    break;

                case 'elastic':
                    fromVars.scale = 0;
                    fromVars.transformOrigin = data.transformOrigin || 'center center';
                    break;

                case 'blur':
                    fromVars.filter = `blur(${data.blurAmount || 10}px)`;
                    fromVars.opacity = 0;
                    break;

                case 'clip':
                    switch (data.direction) {
                        case 'up': fromVars.clipPath = 'inset(100% 0 0 0)'; break;
                        case 'down': fromVars.clipPath = 'inset(0 0 100% 0)'; break;
                        case 'left': fromVars.clipPath = 'inset(0 100% 0 0)'; break;
                        case 'right': fromVars.clipPath = 'inset(0 0 0 100%)'; break;
                    }
                    break;

                case 'stagger':
                    fromVars.opacity = 0;
                    fromVars.y = 30;
                    break;

                case 'parallax':
                    const parallaxDistance = data.distance || 100;
                    switch (data.direction) {
                        case 'up': fromVars.y = parallaxDistance; break;
                        case 'down': fromVars.y = -parallaxDistance; break;
                        case 'left': fromVars.x = parallaxDistance; break;
                        case 'right': fromVars.x = -parallaxDistance; break;
                    }
                    break;
            }

            return fromVars;
        },

        /**
         * Build text animation from vars
         */
        buildTextFromVars: function (animationType, data) {
            const fromVars = { opacity: 0 };

            switch (animationType) {
                case 'text-fade-up':
                    fromVars.y = 30;
                    break;
                case 'text-fade-down':
                    fromVars.y = -30;
                    break;
                case 'text-fade-left':
                    fromVars.x = 30;
                    break;
                case 'text-fade-right':
                    fromVars.x = -30;
                    break;
                case 'text-reveal':
                case 'text-reveal-left':
                    fromVars.clipPath = 'inset(0 100% 0 0)';
                    fromVars.opacity = 1;
                    break;
                case 'text-reveal-right':
                    fromVars.clipPath = 'inset(0 0 0 100%)';
                    fromVars.opacity = 1;
                    break;
                case 'text-typewriter':
                    fromVars.width = 0;
                    fromVars.opacity = 1;
                    break;
                case 'text-split-chars':
                case 'text-split-words':
                case 'text-split-lines':
                    fromVars.y = 20;
                    break;
                case 'text-wave':
                    fromVars.y = 30;
                    fromVars.rotation = 5;
                    break;
                case 'text-bounce':
                    fromVars.y = -50;
                    fromVars.scale = 0.5;
                    break;
                case 'text-rotate-in':
                    fromVars.rotation = 90;
                    fromVars.transformOrigin = 'left bottom';
                    break;
                case 'text-blur-in':
                    fromVars.filter = 'blur(10px)';
                    break;
                case 'text-scale-up':
                    fromVars.scale = 0.5;
                    break;
                case 'text-glitch':
                    fromVars.skewX = 20;
                    fromVars.x = -20;
                    break;
                case 'text-highlight':
                    fromVars.backgroundSize = '0% 100%';
                    fromVars.opacity = 1;
                    break;
            }

            return fromVars;
        },

        /**
         * Build image animation from vars
         */
        buildImageFromVars: function (animationType, data) {
            const fromVars = { opacity: 0 };

            switch (animationType) {
                case 'img-fade-in':
                    break;
                case 'img-zoom-in':
                    fromVars.scale = 0.8;
                    break;
                case 'img-zoom-out':
                    fromVars.scale = 1.2;
                    break;
                case 'img-slide-up':
                    fromVars.y = 100;
                    break;
                case 'img-slide-down':
                    fromVars.y = -100;
                    break;
                case 'img-slide-left':
                    fromVars.x = 100;
                    break;
                case 'img-slide-right':
                    fromVars.x = -100;
                    break;
                case 'img-reveal-up':
                    fromVars.clipPath = 'inset(100% 0 0 0)';
                    fromVars.opacity = 1;
                    break;
                case 'img-reveal-down':
                    fromVars.clipPath = 'inset(0 0 100% 0)';
                    fromVars.opacity = 1;
                    break;
                case 'img-reveal-left':
                    fromVars.clipPath = 'inset(0 100% 0 0)';
                    fromVars.opacity = 1;
                    break;
                case 'img-reveal-right':
                    fromVars.clipPath = 'inset(0 0 0 100%)';
                    fromVars.opacity = 1;
                    break;
                case 'img-rotate-in':
                    fromVars.rotation = 45;
                    fromVars.scale = 0.8;
                    break;
                case 'img-flip-x':
                    fromVars.rotationY = 90;
                    break;
                case 'img-flip-y':
                    fromVars.rotationX = 90;
                    break;
                case 'img-blur-in':
                    fromVars.filter = 'blur(15px)';
                    break;
                case 'img-parallax':
                    fromVars.y = data.distance || 100;
                    fromVars.opacity = 1;
                    break;
                case 'img-tilt':
                    fromVars.rotationX = 15;
                    fromVars.rotationY = 15;
                    fromVars.transformPerspective = 1000;
                    break;
                case 'img-bounce':
                    fromVars.y = -80;
                    fromVars.scale = 0.9;
                    break;
                case 'img-elastic':
                    fromVars.scale = 0;
                    break;
                case 'img-ken-burns':
                    fromVars.scale = 1.2;
                    fromVars.opacity = 1;
                    break;
            }

            return fromVars;
        },

        /**
         * Build background animation from vars
         */
        buildBackgroundFromVars: function (animationType, data) {
            const fromVars = { opacity: 0 };

            switch (animationType) {
                case 'bg-fade':
                    break;
                case 'bg-slide-up':
                    fromVars.y = '100%';
                    fromVars.opacity = 1;
                    break;
                case 'bg-slide-down':
                    fromVars.y = '-100%';
                    fromVars.opacity = 1;
                    break;
                case 'bg-slide-left':
                    fromVars.x = '100%';
                    fromVars.opacity = 1;
                    break;
                case 'bg-slide-right':
                    fromVars.x = '-100%';
                    fromVars.opacity = 1;
                    break;
                case 'bg-zoom-in':
                    fromVars.scale = 0.8;
                    break;
                case 'bg-zoom-out':
                    fromVars.scale = 1.3;
                    break;
                case 'bg-parallax':
                    fromVars.y = data.distance || 100;
                    fromVars.opacity = 1;
                    break;
                case 'bg-reveal-circle':
                    fromVars.clipPath = 'circle(0% at 50% 50%)';
                    fromVars.opacity = 1;
                    break;
                case 'bg-reveal-diagonal':
                    fromVars.clipPath = 'polygon(0 0, 0 0, 0 100%, 0 100%)';
                    fromVars.opacity = 1;
                    break;
                case 'bg-gradient-shift':
                    fromVars.backgroundPosition = '0% 50%';
                    fromVars.opacity = 1;
                    break;
                case 'bg-color-morph':
                    fromVars.filter = 'hue-rotate(0deg)';
                    fromVars.opacity = 1;
                    break;
                case 'bg-blur-in':
                    fromVars.filter = 'blur(20px)';
                    break;
                case 'bg-rotate':
                    fromVars.rotation = 10;
                    fromVars.scale = 1.2;
                    break;
                case 'bg-scale-reveal':
                    fromVars.scale = 0;
                    fromVars.transformOrigin = 'center center';
                    break;
            }

            return fromVars;
        },

        /**
         * Build preset animation from vars
         */
        buildPresetFromVars: function (animationType, data) {
            const fromVars = { opacity: 0 };

            switch (animationType) {
                // Fade animations
                case 'preset-fade-up':
                    fromVars.y = 50;
                    break;
                case 'preset-fade-down':
                    fromVars.y = -50;
                    break;
                case 'preset-fade-left':
                    fromVars.x = 50;
                    break;
                case 'preset-fade-right':
                    fromVars.x = -50;
                    break;

                // Zoom animations
                case 'preset-zoom-in':
                    fromVars.scale = 0.5;
                    break;
                case 'preset-zoom-out':
                    fromVars.scale = 1.5;
                    break;
                case 'preset-zoom-in-up':
                    fromVars.scale = 0.5;
                    fromVars.y = 50;
                    break;
                case 'preset-zoom-in-down':
                    fromVars.scale = 0.5;
                    fromVars.y = -50;
                    break;

                // Flip animations
                case 'preset-flip-up':
                    fromVars.rotationX = 90;
                    fromVars.transformOrigin = 'center bottom';
                    break;
                case 'preset-flip-down':
                    fromVars.rotationX = -90;
                    fromVars.transformOrigin = 'center top';
                    break;
                case 'preset-flip-left':
                    fromVars.rotationY = 90;
                    fromVars.transformOrigin = 'left center';
                    break;
                case 'preset-flip-right':
                    fromVars.rotationY = -90;
                    fromVars.transformOrigin = 'right center';
                    break;

                // Bounce & Elastic animations
                case 'preset-bounce-in':
                    fromVars.scale = 0.3;
                    break;
                case 'preset-bounce-up':
                    fromVars.y = 100;
                    break;
                case 'preset-elastic-in':
                    fromVars.scale = 0;
                    break;
                case 'preset-elastic-scale':
                    fromVars.scale = 0.5;
                    fromVars.rotation = 10;
                    break;

                // Rotate animations
                case 'preset-rotate-in':
                    fromVars.rotation = 180;
                    fromVars.scale = 0.5;
                    break;
                case 'preset-rotate-in-up':
                    fromVars.rotation = 45;
                    fromVars.y = 50;
                    break;
                case 'preset-rotate-in-down':
                    fromVars.rotation = -45;
                    fromVars.y = -50;
                    break;
                case 'preset-spin-in':
                    fromVars.rotation = 360;
                    fromVars.scale = 0;
                    break;

                // Special effects
                case 'preset-blur-in':
                    fromVars.filter = 'blur(15px)';
                    break;
                case 'preset-clip-up':
                    fromVars.clipPath = 'inset(100% 0 0 0)';
                    fromVars.opacity = 1;
                    break;
                case 'preset-clip-left':
                    fromVars.clipPath = 'inset(0 100% 0 0)';
                    fromVars.opacity = 1;
                    break;
                case 'preset-skew-in':
                    fromVars.skewX = 30;
                    fromVars.skewY = 10;
                    break;
                case 'preset-slide-skew':
                    fromVars.x = 100;
                    fromVars.skewX = 20;
                    break;
            }

            return fromVars;
        },

        /**
         * Build advanced animation from vars
         */
        buildAdvancedFromVars: function (animationType, data) {
            const fromVars = {};

            switch (animationType) {
                case 'stagger':
                    fromVars.opacity = 0;
                    fromVars.y = 30;
                    break;

                case 'parallax':
                    const parallaxDistance = data.distance || 100;
                    switch (data.direction) {
                        case 'up': fromVars.y = parallaxDistance; break;
                        case 'down': fromVars.y = -parallaxDistance; break;
                        case 'left': fromVars.x = parallaxDistance; break;
                        case 'right': fromVars.x = -parallaxDistance; break;
                    }
                    break;

                case 'custom':
                    if (data.customX) fromVars.x = data.customX;
                    if (data.customY) fromVars.y = data.customY;
                    if (data.customScale !== 1) fromVars.scale = data.customScale;
                    if (data.customRotation) fromVars.rotation = data.customRotation;
                    if (data.customOpacity !== undefined && data.customOpacity !== 1) fromVars.opacity = data.customOpacity;
                    if (data.customSkewX) fromVars.skewX = data.customSkewX;
                    if (data.customSkewY) fromVars.skewY = data.customSkewY;
                    fromVars.transformOrigin = data.transformOrigin || 'center center';
                    break;
            }

            return fromVars;
        },

        /**
         * Build "to" variables for animation
         * @param {Object} data - Animation data
         * @returns {Object}
         */
        buildToVars: function (data) {
            const mode = data.mode || 'custom';
            const animationType = data.animation;
            
            // Get appropriate easing based on mode and animation type
            let easing = data.easing || 'power2.out';
            
            // For preset mode, use smart easing based on animation type
            if (mode === 'preset') {
                easing = this.getSmartEasing(animationType);
            }
            
            const toVars = {
                duration: data.duration || 1,
                delay: data.delay || 0,
                ease: easing,
            };

            // Set default "to" state (usually reset to normal)
            toVars.opacity = 1;
            toVars.x = 0;
            toVars.y = 0;
            toVars.scale = 1;
            toVars.rotation = 0;
            toVars.rotationX = 0;
            toVars.rotationY = 0;
            toVars.skewX = 0;
            toVars.skewY = 0;
            toVars.clipPath = 'inset(0 0 0 0)';

            // Special handling for filter - don't set default filter unless animation uses it
            // This prevents overwriting existing CSS filters
            
            // Special handling for certain animations
            if (animationType === 'bg-reveal-circle') {
                toVars.clipPath = 'circle(100% at 50% 50%)';
            } else if (animationType === 'bg-reveal-diagonal') {
                toVars.clipPath = 'polygon(0 0, 100% 0, 100% 100%, 0 100%)';
            } else if (animationType === 'bg-gradient-shift') {
                toVars.backgroundPosition = '100% 50%';
                delete toVars.clipPath; // Remove default clipPath
            } else if (animationType === 'bg-color-morph') {
                toVars.filter = 'hue-rotate(360deg)';
                delete toVars.clipPath;
            } else if (animationType === 'text-highlight') {
                toVars.backgroundSize = '100% 100%';
            } else if (animationType === 'img-ken-burns') {
                toVars.scale = 1;
            } else if (animationType === 'text-typewriter') {
                toVars.width = '100%';
                delete toVars.clipPath;
            }
            
            // Handle blur animations
            if (animationType.includes('blur')) {
                toVars.filter = 'blur(0px)';
            }

            return toVars;
        },

        /**
         * Get smart easing for preset animations
         */
        getSmartEasing: function (animationType) {
            // Bounce animations
            if (animationType.includes('bounce')) {
                return 'bounce.out';
            }
            
            // Elastic animations
            if (animationType.includes('elastic')) {
                return 'elastic.out(1, 0.3)';
            }
            
            // Flip animations - use back easing
            if (animationType.includes('flip')) {
                return 'back.out(1.7)';
            }
            
            // Rotate/spin animations
            if (animationType.includes('rotate') || animationType.includes('spin')) {
                return 'power3.out';
            }
            
            // Zoom animations
            if (animationType.includes('zoom')) {
                return 'power2.out';
            }
            
            // Slide animations
            if (animationType.includes('slide')) {
                return 'power3.out';
            }
            
            // Blur animations
            if (animationType.includes('blur')) {
                return 'power2.inOut';
            }
            
            // Clip/reveal animations
            if (animationType.includes('clip') || animationType.includes('reveal')) {
                return 'power4.inOut';
            }
            
            // Skew animations
            if (animationType.includes('skew')) {
                return 'power2.out';
            }
            
            // Default
            return 'power2.out';
        },

        /**
         * Get appropriate easing for animation type
         */
        getEasing: function (animationType, data) {
            // Use custom easing if set
            if (data.easing && data.easing !== 'power2.out') {
                return data.easing;
            }

            // Default easings based on animation type
            const bounceAnimations = ['bounce', 'preset-bounce-in', 'preset-bounce-up', 'text-bounce', 'img-bounce'];
            const elasticAnimations = ['elastic', 'preset-elastic-in', 'preset-elastic-scale', 'img-elastic'];

            if (bounceAnimations.includes(animationType)) {
                return 'bounce.out';
            }
            if (elasticAnimations.includes(animationType)) {
                return 'elastic.out(1, 0.3)';
            }

            return data.easing || 'power2.out';
        },

        /**
         * Create scroll-triggered animation
         */
        createScrollTriggeredAnimation: function (element, data, fromVars, toVars) {
            const $element = $(element);
            const animationType = data.animation;

            // Special handling for stagger animation
            if (animationType === 'stagger' || data.category === 'advanced' && data.animation === 'stagger') {
                const children = $element.children();
                if (children.length > 0) {
                    gsap.set(children, fromVars);

                    const tl = gsap.timeline({
                        scrollTrigger: {
                            trigger: element,
                            start: data.triggerStart || 'top 80%',
                            toggleActions: data.toggleActions || 'play none none none',
                            scrub: data.scrub ? 1 : false,
                            markers: data.markers || false,
                        }
                    });

                    tl.to(children, {
                        ...toVars,
                        stagger: data.staggerAmount || 0.1,
                    });

                    this.scrollTriggers.push(tl.scrollTrigger);
                    return;
                }
            }

            // Text split animations
            if (data.category === 'text' && ['text-split-chars', 'text-split-words', 'text-split-lines', 'text-wave', 'text-bounce'].includes(animationType)) {
                this.createTextSplitAnimation(element, data, fromVars, toVars);
                return;
            }

            // Background animations - target the background overlay element
            if (data.category === 'background') {
                this.createBackgroundAnimation(element, data, fromVars, toVars);
                return;
            }

            // Standard scroll-triggered animation
            gsap.set(element, fromVars);

            const animation = gsap.to(element, {
                ...toVars,
                scrollTrigger: {
                    trigger: element,
                    start: data.triggerStart || 'top 80%',
                    toggleActions: data.toggleActions || 'play none none none',
                    scrub: data.scrub ? 1 : false,
                    markers: data.markers || false,
                }
            });

            if (animation.scrollTrigger) {
                this.scrollTriggers.push(animation.scrollTrigger);
            }
            this.instances.push(animation);
        },

        /**
         * Create background animation - targets background overlay element
         */
        createBackgroundAnimation: function (element, data, fromVars, toVars) {
            const $element = $(element);
            const animationType = data.animation;
            
            // Find the background overlay element in Elementor
            let $bgTarget = $element.find('.elementor-background-overlay');
            
            // If no overlay, try to find background slideshow or video
            if (!$bgTarget.length) {
                $bgTarget = $element.find('.elementor-background-slideshow, .elementor-background-video-container');
            }
            
            // If still no background element found, animate the element itself
            // This works for elements with background-image set directly
            if (!$bgTarget.length) {
                $bgTarget = $element;
            }
            
            const bgElement = $bgTarget[0] || element;
            
            // Set initial state
            gsap.set(bgElement, fromVars);
            
            // Create animation with scroll trigger
            const animation = gsap.to(bgElement, {
                ...toVars,
                scrollTrigger: {
                    trigger: element, // Trigger on the parent element
                    start: data.triggerStart || 'top 80%',
                    toggleActions: data.toggleActions || 'play none none none',
                    scrub: data.scrub ? 1 : false,
                    markers: data.markers || false,
                }
            });

            if (animation.scrollTrigger) {
                this.scrollTriggers.push(animation.scrollTrigger);
            }
            this.instances.push(animation);
        },

        /**
         * Create text split animation
         */
        createTextSplitAnimation: function (element, data, fromVars, toVars) {
            const $element = $(element);
            const animationType = data.animation;
            const text = $element.text();
            
            let items = [];
            
            // Split text based on animation type
            if (animationType === 'text-split-chars') {
                $element.html(text.split('').map(char => `<span class="mg-gsap-char">${char === ' ' ? '&nbsp;' : char}</span>`).join(''));
                items = $element.find('.mg-gsap-char');
            } else if (animationType === 'text-split-words') {
                $element.html(text.split(' ').map(word => `<span class="mg-gsap-word">${word}</span>`).join(' '));
                items = $element.find('.mg-gsap-word');
            } else if (['text-wave', 'text-bounce'].includes(animationType)) {
                $element.html(text.split('').map(char => `<span class="mg-gsap-char" style="display:inline-block">${char === ' ' ? '&nbsp;' : char}</span>`).join(''));
                items = $element.find('.mg-gsap-char');
            }

            if (items.length > 0) {
                gsap.set(items, fromVars);

                const tl = gsap.timeline({
                    scrollTrigger: {
                        trigger: element,
                        start: data.triggerStart || 'top 80%',
                        toggleActions: data.toggleActions || 'play none none none',
                        markers: data.markers || false,
                    }
                });

                tl.to(items, {
                    ...toVars,
                    stagger: data.staggerAmount || 0.05,
                });

                this.scrollTriggers.push(tl.scrollTrigger);
            }
        },

        /**
         * Create immediate (non-scroll-triggered) animation
         */
        createImmediateAnimation: function (element, data, fromVars, toVars) {
            const $element = $(element);
            const animationType = data.animation;

            // Special handling for stagger animation
            if (animationType === 'stagger' || data.category === 'advanced' && data.animation === 'stagger') {
                const children = $element.children();
                if (children.length > 0) {
                    gsap.set(children, fromVars);

                    const tl = gsap.timeline();
                    tl.to(children, {
                        ...toVars,
                        stagger: data.staggerAmount || 0.1,
                    });

                    this.instances.push(tl);
                    return;
                }
            }

            // Background animations - target the background overlay element
            if (data.category === 'background') {
                let $bgTarget = $element.find('.elementor-background-overlay');
                if (!$bgTarget.length) {
                    $bgTarget = $element.find('.elementor-background-slideshow, .elementor-background-video-container');
                }
                if (!$bgTarget.length) {
                    $bgTarget = $element;
                }
                
                const bgElement = $bgTarget[0] || element;
                const animation = gsap.fromTo(bgElement, fromVars, toVars);
                this.instances.push(animation);
                return;
            }

            // Standard immediate animation
            const animation = gsap.fromTo(element, fromVars, toVars);

            this.instances.push(animation);
        },

        /**
         * Replay animation for a specific element (used in editor preview)
         */
        replayAnimation: function (elementId) {
            const element = document.querySelector('.elementor-element-' + elementId);
            if (!element) return;

            const $element = $(element);
            let data;

            try {
                data = JSON.parse($element.attr('data-mg-gsap'));
            } catch (e) {
                return;
            }

            // Kill existing animation for this element
            gsap.killTweensOf(element);

            // Reset element state
            gsap.set(element, { clearProps: 'all', visibility: 'visible' });

            // Rebuild and play animation
            const fromVars = this.buildFromVars(data);
            const toVars = this.buildToVars(data);

            // Don't use scroll trigger for preview
            gsap.from(element, {
                ...fromVars,
                ...toVars,
            });
        },

        /**
         * Refresh all ScrollTriggers (useful after layout changes)
         */
        refresh: function () {
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }
        },

        /**
         * Kill all animations and ScrollTriggers
         */
        destroy: function () {
            this.instances.forEach(animation => {
                if (animation && animation.kill) {
                    animation.kill();
                }
            });

            this.scrollTriggers.forEach(st => {
                if (st && st.kill) {
                    st.kill();
                }
            });

            this.instances = [];
            this.scrollTriggers = [];
        }
    };

    // Function to initialize GSAP
    function initMgGsap() {
        if (!mgGsapAnimations.initialized) {
            mgGsapAnimations.init();
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMgGsap);
    } else {
        initMgGsap();
    }

    // Also try on window load
    window.addEventListener('load', function() {
        initMgGsap();
        
        // Refresh ScrollTrigger after all assets loaded
        setTimeout(function() {
            if (mgGsapAnimations.gsapLoaded) {
                mgGsapAnimations.refresh();
            }
        }, 100);
    });

    // Ultimate fallback - if nothing works after 3 seconds, force show elements
    setTimeout(function() {
        var elements = document.querySelectorAll('.mg-gsap-animated:not(.mg-gsap-ready)');
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.add('mg-gsap-ready');
            elements[i].style.opacity = '1';
            elements[i].style.visibility = 'visible';
        }
    }, 3000);

    // Expose for external use
    window.mgGsapAnimations = mgGsapAnimations;

})(jQuery);
