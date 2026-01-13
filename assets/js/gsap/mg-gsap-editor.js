/**
 * Magical Addons GSAP Animations - Elementor Editor Handler
 * 
 * Handles live preview of GSAP animations in the Elementor editor
 * 
 * @package Magical_Addons_For_Elementor
 * @since 1.3.15
 */

(function ($) {
    'use strict';

    const mgGsapEditor = {
        initialized: false,
        
        /**
         * Initialize editor functionality
         */
        init: function () {
            // Prevent double initialization
            if (this.initialized) {
                return;
            }
            
            // Wait for Elementor to be ready
            if (typeof elementor === 'undefined') {
                return;
            }

            this.initialized = true;

            // Listen for editor initialization
            elementor.on('preview:loaded', () => {
                this.setupPreviewListeners();
            });

            // Listen for panel open events
            elementor.hooks.addAction('panel/open_editor/widget', this.handlePanelOpen.bind(this));
            elementor.hooks.addAction('panel/open_editor/section', this.handlePanelOpen.bind(this));
            elementor.hooks.addAction('panel/open_editor/column', this.handlePanelOpen.bind(this));
            elementor.hooks.addAction('panel/open_editor/container', this.handlePanelOpen.bind(this));

            // Listen for settings changes
            elementor.channels.editor.on('change', this.handleSettingsChange.bind(this));

            // Setup preview button event
            this.setupPreviewButton();
        },

        /**
         * Setup preview iframe listeners
         */
        setupPreviewListeners: function () {
            const $iframe = $('#elementor-preview-iframe');
            if (!$iframe.length) return;

            const iframeWindow = $iframe[0].contentWindow;
        },

        /**
         * Handle panel open for any element type
         */
        handlePanelOpen: function (panel, model, view) {
            // Store reference to current view for later use
            this.currentView = view;
            this.currentModel = model;
        },

        /**
         * Handle settings changes in the editor
         */
        handleSettingsChange: function (view) {
            if (!view || !view.model) return;

            const changedControl = view.model.get('name');

            // Check if it's a GSAP-related control
            if (!changedControl || !changedControl.startsWith('mg_gsap_')) {
                return;
            }

            // Get the element container
            const container = view.container;
            if (!container) return;

            const elementId = container.id;
            const settings = container.settings.attributes;

            // Update the preview element
            this.updatePreviewElement(elementId, settings);
        },

        /**
         * Update the preview element with new GSAP data
         */
        updatePreviewElement: function (elementId, settings) {
            const $iframe = $('#elementor-preview-iframe');
            if (!$iframe.length) return;

            const iframeDocument = $iframe[0].contentDocument || $iframe[0].contentWindow.document;
            const $element = $(iframeDocument).find('.elementor-element-' + elementId);

            if (!$element.length) return;

            // Check if GSAP is enabled
            if (settings.mg_gsap_enable !== 'yes') {
                // Remove GSAP class and data
                $element.removeClass('mg-gsap-animated');
                $element.removeAttr('data-mg-gsap');

                // Reset any transforms but keep visibility
                const iframeGsap = $iframe[0].contentWindow.gsap;
                if (iframeGsap) {
                    iframeGsap.set($element[0], { clearProps: 'all', visibility: 'visible' });
                }
                return;
            }

            // Build GSAP data object
            const gsapData = this.buildGsapData(settings);

            // Update element attributes
            $element.addClass('mg-gsap-animated');
            $element.attr('data-mg-gsap', JSON.stringify(gsapData));

            // Trigger animation preview
            this.triggerPreviewAnimation($iframe, $element, gsapData);
        },

        /**
         * Build GSAP data object from settings
         */
        buildGsapData: function (settings) {
            const mode = settings.mg_gsap_mode || 'preset';
            
            // Preset mode - simple, default values
            if (mode === 'preset') {
                const animation = settings.mg_gsap_quick_preset || 'fade-up';
                
                return {
                    mode: 'preset',
                    animation: animation,
                    duration: 1,
                    delay: 0,
                    easing: 'power2.out',
                    includeFade: true,
                    scrollTrigger: true,
                    triggerStart: 'top 80%',
                    toggleActions: 'play none none none',
                    scrub: false,
                    markers: false,
                    transformOrigin: 'center center',
                };
            }
            
            // Custom mode - full control
            const category = settings.mg_gsap_animation_category || 'general';
            
            // Get animation type based on category
            let animation;
            switch (category) {
                case 'general':
                    animation = settings.mg_gsap_animation_type || 'fade';
                    break;
                case 'text':
                    animation = settings.mg_gsap_text_animation || 'text-fade-up';
                    break;
                case 'image':
                    animation = settings.mg_gsap_image_animation || 'img-fade-in';
                    break;
                case 'background':
                    animation = settings.mg_gsap_bg_animation || 'bg-fade';
                    break;
                case 'preset':
                    animation = settings.mg_gsap_preset_animation || 'preset-fade-up';
                    break;
                case 'advanced':
                    animation = settings.mg_gsap_advanced_type || 'custom';
                    break;
                default:
                    animation = 'fade';
            }
            
            const data = {
                mode: 'custom',
                category: category,
                animation: animation,
                duration: settings.mg_gsap_duration?.size || 1,
                delay: settings.mg_gsap_delay?.size || 0,
                easing: settings.mg_gsap_easing || 'power2.out',
                includeFade: settings.mg_gsap_include_fade === 'yes',
                scrollTrigger: settings.mg_gsap_scroll_trigger === 'yes',
                triggerStart: settings.mg_gsap_trigger_start || 'top 80%',
                toggleActions: settings.mg_gsap_toggle_actions || 'play none none none',
                scrub: settings.mg_gsap_scrub === 'yes',
                markers: settings.mg_gsap_markers === 'yes',
                transformOrigin: settings.mg_gsap_transform_origin || 'center center',
            };

            // Add category-specific data
            switch (category) {
                case 'general':
                    this.addGeneralData(data, animation, settings);
                    break;
                case 'text':
                    data.staggerAmount = settings.mg_gsap_stagger_amount?.size || 0.05;
                    break;
                case 'image':
                    if (['img-parallax', 'img-ken-burns'].includes(animation)) {
                        data.distance = settings.mg_gsap_distance?.size || 100;
                    }
                    break;
                case 'background':
                    if (animation === 'bg-parallax') {
                        data.distance = settings.mg_gsap_distance?.size || 100;
                    }
                    break;
                case 'advanced':
                    this.addAdvancedData(data, animation, settings);
                    break;
            }

            return data;
        },

        /**
         * Add general animation data
         */
        addGeneralData: function (data, animation, settings) {
            switch (animation) {
                case 'slide':
                case 'parallax':
                    data.direction = settings.mg_gsap_direction || 'up';
                    data.distance = settings.mg_gsap_distance?.size || 100;
                    break;
                case 'scale':
                    data.scaleFrom = settings.mg_gsap_scale_from?.size || 0.5;
                    break;
                case 'rotate':
                    data.rotateDegrees = settings.mg_gsap_rotate_degrees?.size || 90;
                    break;
                case 'flip':
                case 'clip':
                    data.direction = settings.mg_gsap_direction || 'up';
                    break;
                case 'blur':
                    data.blurAmount = settings.mg_gsap_blur_amount?.size || 10;
                    break;
                case 'stagger':
                    data.staggerAmount = settings.mg_gsap_stagger_amount?.size || 0.1;
                    break;
            }
        },

        /**
         * Add advanced animation data
         */
        addAdvancedData: function (data, animation, settings) {
            switch (animation) {
                case 'stagger':
                    data.staggerAmount = settings.mg_gsap_stagger_amount?.size || 0.1;
                    break;
                case 'parallax':
                    data.direction = settings.mg_gsap_direction || 'up';
                    data.distance = settings.mg_gsap_distance?.size || 100;
                    break;
                case 'custom':
                    data.customX = settings.mg_gsap_custom_x || 0;
                    data.customY = settings.mg_gsap_custom_y || 0;
                    data.customScale = settings.mg_gsap_custom_scale || 1;
                    data.customRotation = settings.mg_gsap_custom_rotation || 0;
                    data.customOpacity = settings.mg_gsap_custom_opacity?.size || 1;
                    data.customSkewX = settings.mg_gsap_custom_skewx || 0;
                    data.customSkewY = settings.mg_gsap_custom_skewy || 0;
                    break;
            }
        },

        /**
         * Trigger preview animation in the iframe
         */
        triggerPreviewAnimation: function ($iframe, $element, data) {
            const iframeWindow = $iframe[0].contentWindow;
            const iframeGsap = iframeWindow.gsap;

            if (!iframeGsap) {
                return;
            }

            // Kill any existing animations on the element
            iframeGsap.killTweensOf($element[0]);

            // Build animation from vars
            const fromVars = this.buildEditorFromVars(data);

            // Build the "to" vars dynamically based on fromVars
            // Only include properties that are in fromVars with appropriate end values
            const toVars = {};
            
            if ('opacity' in fromVars) toVars.opacity = 1;
            if ('x' in fromVars) toVars.x = 0;
            if ('y' in fromVars) toVars.y = 0;
            if ('scale' in fromVars) toVars.scale = 1;
            if ('scaleX' in fromVars) toVars.scaleX = 1;
            if ('scaleY' in fromVars) toVars.scaleY = 1;
            if ('rotation' in fromVars) toVars.rotation = 0;
            if ('rotationX' in fromVars) toVars.rotationX = 0;
            if ('rotationY' in fromVars) toVars.rotationY = 0;
            if ('skewX' in fromVars) toVars.skewX = 0;
            if ('skewY' in fromVars) toVars.skewY = 0;
            if ('width' in fromVars) toVars.width = 'auto';
            if ('transformPerspective' in fromVars) toVars.transformPerspective = 600;
            if ('transformOrigin' in fromVars) toVars.transformOrigin = 'center center';
            if ('backgroundSize' in fromVars) toVars.backgroundSize = '100% 100%';
            if ('backgroundPosition' in fromVars) toVars.backgroundPosition = '100% 50%';
            
            // Handle filter property - set appropriate end state based on filter type
            if ('filter' in fromVars) {
                const filterValue = fromVars.filter;
                if (filterValue.includes('blur')) {
                    toVars.filter = 'blur(0px)';
                } else if (filterValue.includes('hue-rotate')) {
                    toVars.filter = 'hue-rotate(360deg)';
                } else {
                    toVars.filter = 'none';
                }
            }
            
            // Handle clipPath - set to full visibility
            if ('clipPath' in fromVars) {
                const clipValue = fromVars.clipPath;
                if (clipValue.includes('circle')) {
                    toVars.clipPath = 'circle(100% at 50% 50%)';
                } else if (clipValue.includes('polygon')) {
                    toVars.clipPath = 'polygon(0 0, 100% 0, 100% 100%, 0 100%)';
                } else {
                    toVars.clipPath = 'inset(0% 0% 0% 0%)';
                }
            }
            
            // Handle backgroundPosition for gradient animations
            if ('backgroundPosition' in fromVars) {
                toVars.backgroundPosition = '100% 50%';
            }
            
            // Add animation timing
            toVars.duration = parseFloat(data.duration) || 1;
            toVars.delay = parseFloat(data.delay) || 0;
            toVars.ease = data.easing || 'power2.out';

            // Determine target element - for background animations, target the overlay
            let targetElement = $element[0];
            if (data.category === 'background') {
                const $bgOverlay = $element.find('.elementor-background-overlay');
                if ($bgOverlay.length) {
                    targetElement = $bgOverlay[0];
                } else {
                    // Try other background elements
                    const $bgElement = $element.find('.elementor-background-slideshow, .elementor-background-video-container');
                    if ($bgElement.length) {
                        targetElement = $bgElement[0];
                    }
                }
            }

            // First reset the element but keep visibility
            iframeGsap.set(targetElement, { clearProps: 'all', visibility: 'visible' });
            // Also ensure parent element is visible
            iframeGsap.set($element[0], { visibility: 'visible' });

            // Set onComplete to clear the correct element but keep visible
            toVars.onComplete = () => {
                iframeGsap.set(targetElement, { clearProps: 'all', visibility: 'visible' });
                iframeGsap.set($element[0], { visibility: 'visible' });
            };

            // Small delay then animate
            setTimeout(() => {
                // Use fromTo for explicit control over start and end states
                iframeGsap.fromTo(targetElement, fromVars, toVars);
            }, 50);
        },

        /**
         * Build from vars for editor preview
         */
        buildEditorFromVars: function (data) {
            const mode = data.mode || 'preset';
            const animationType = data.animation;

            // Map animation types to their from values - COMPLETE LIST
            const animationMap = {
                // ============ GENERAL ANIMATIONS ============
                // Fade animations
                'fade': { opacity: 0 },
                'fade-up': { opacity: 0, y: 50 },
                'fade-down': { opacity: 0, y: -50 },
                'fade-left': { opacity: 0, x: 50 },
                'fade-right': { opacity: 0, x: -50 },
                'fade-in': { opacity: 0 },
                
                // Zoom animations
                'zoom-in': { opacity: 0, scale: 0.5 },
                'zoom-out': { opacity: 0, scale: 1.5 },
                'zoom-in-up': { opacity: 0, scale: 0.5, y: 50 },
                'zoom-in-down': { opacity: 0, scale: 0.5, y: -50 },
                
                // Slide animations
                'slide': { opacity: data.includeFade ? 0 : 1, y: data.direction === 'up' ? (data.distance || 100) : (data.direction === 'down' ? -(data.distance || 100) : 0), x: data.direction === 'left' ? (data.distance || 100) : (data.direction === 'right' ? -(data.distance || 100) : 0) },
                'slide-up': { opacity: 0, y: 100 },
                'slide-down': { opacity: 0, y: -100 },
                'slide-left': { opacity: 0, x: 100 },
                'slide-right': { opacity: 0, x: -100 },
                
                // Flip animations
                'flip': { opacity: 0, rotationX: data.direction === 'up' ? 90 : (data.direction === 'down' ? -90 : 0), rotationY: data.direction === 'left' ? 90 : (data.direction === 'right' ? -90 : 0), transformPerspective: 600 },
                'flip-up': { opacity: 0, rotationX: 90, transformPerspective: 600 },
                'flip-down': { opacity: 0, rotationX: -90, transformPerspective: 600 },
                'flip-left': { opacity: 0, rotationY: 90, transformPerspective: 600 },
                'flip-right': { opacity: 0, rotationY: -90, transformPerspective: 600 },
                
                // Bounce & Elastic
                'bounce': { opacity: 0, y: -50 },
                'bounce-in': { opacity: 0, scale: 0.3 },
                'bounce-up': { opacity: 0, y: 80, scale: 0.8 },
                'elastic': { opacity: 0, scale: 0 },
                'elastic-in': { opacity: 0, scale: 0 },
                'elastic-scale': { opacity: 0, scaleX: 0, scaleY: 0 },
                
                // Rotate animations
                'rotate': { opacity: data.includeFade ? 0 : 1, rotation: data.rotateDegrees || 90 },
                'rotate-in': { opacity: 0, rotation: 180, scale: 0.5 },
                'rotate-in-up': { opacity: 0, rotation: 45, y: 50 },
                'rotate-in-down': { opacity: 0, rotation: -45, y: -50 },
                'spin-in': { opacity: 0, rotation: 360, scale: 0 },
                
                // Special effects
                'scale': { opacity: data.includeFade ? 0 : 1, scale: data.scaleFrom || 0.5 },
                'blur': { opacity: 0, filter: `blur(${data.blurAmount || 10}px)` },
                'blur-in': { opacity: 0, filter: 'blur(20px)' },
                'clip': { opacity: 0, clipPath: data.direction === 'up' ? 'inset(100% 0 0 0)' : (data.direction === 'down' ? 'inset(0 0 100% 0)' : (data.direction === 'left' ? 'inset(0 100% 0 0)' : 'inset(0 0 0 100%)')) },
                'clip-up': { opacity: 0, clipPath: 'inset(100% 0 0 0)' },
                'clip-down': { opacity: 0, clipPath: 'inset(0 0 100% 0)' },
                'clip-left': { opacity: 0, clipPath: 'inset(0 100% 0 0)' },
                'clip-right': { opacity: 0, clipPath: 'inset(0 0 0 100%)' },
                'skew-in': { opacity: 0, skewX: 30, skewY: 10 },
                'slide-skew': { opacity: 0, x: 100, skewX: 20 },
                'stagger': { opacity: 0, y: 30 },
                'parallax': { opacity: data.includeFade ? 0 : 1, y: data.distance || 100 },
                
                // ============ TEXT ANIMATIONS ============
                'text-fade-up': { opacity: 0, y: 30 },
                'text-fade-down': { opacity: 0, y: -30 },
                'text-fade-left': { opacity: 0, x: 30 },
                'text-fade-right': { opacity: 0, x: -30 },
                'text-reveal': { opacity: 0, clipPath: 'inset(0 100% 0 0)' },
                'text-reveal-left': { opacity: 0, clipPath: 'inset(0 100% 0 0)' },
                'text-reveal-right': { opacity: 0, clipPath: 'inset(0 0 0 100%)' },
                'text-typewriter': { opacity: 0, clipPath: 'inset(0 100% 0 0)' },
                'text-split-chars': { opacity: 0, y: 20, rotation: 10 },
                'text-split-words': { opacity: 0, y: 30 },
                'text-split-lines': { opacity: 0, y: 40 },
                'text-wave': { opacity: 0, y: 20, rotation: 5 },
                'text-bounce': { opacity: 0, y: -30, scale: 0.8 },
                'text-rotate-in': { opacity: 0, rotation: 90, scale: 0.5 },
                'text-blur-in': { opacity: 0, filter: 'blur(15px)' },
                'text-scale-up': { opacity: 0, scale: 0.5 },
                'text-glitch': { opacity: 0, x: -5, skewX: 10 },
                'text-highlight': { opacity: 0, clipPath: 'inset(0 100% 0 0)' },
                
                // ============ IMAGE ANIMATIONS ============
                'img-fade-in': { opacity: 0 },
                'img-zoom-in': { opacity: 0, scale: 0.8 },
                'img-zoom-out': { opacity: 0, scale: 1.3 },
                'img-slide-up': { opacity: 0, y: 100 },
                'img-slide-down': { opacity: 0, y: -100 },
                'img-slide-left': { opacity: 0, x: 100 },
                'img-slide-right': { opacity: 0, x: -100 },
                'img-reveal-up': { opacity: 0, clipPath: 'inset(100% 0 0 0)' },
                'img-reveal-down': { opacity: 0, clipPath: 'inset(0 0 100% 0)' },
                'img-reveal-left': { opacity: 0, clipPath: 'inset(0 100% 0 0)' },
                'img-reveal-right': { opacity: 0, clipPath: 'inset(0 0 0 100%)' },
                'img-rotate-in': { opacity: 0, rotation: 15, scale: 0.8 },
                'img-flip-x': { opacity: 0, rotationY: 90, transformPerspective: 600 },
                'img-flip-y': { opacity: 0, rotationX: 90, transformPerspective: 600 },
                'img-blur-in': { opacity: 0, filter: 'blur(15px)' },
                'img-parallax': { opacity: 0, y: 50 },
                'img-tilt': { opacity: 0, rotationX: 20, rotationY: 20, transformPerspective: 800 },
                'img-bounce': { opacity: 0, y: -50, scale: 0.8 },
                'img-elastic': { opacity: 0, scale: 0 },
                'img-ken-burns': { opacity: 0, scale: 1.2 },
                
                // ============ BACKGROUND ANIMATIONS ============
                'bg-fade': { opacity: 0 },
                'bg-slide-up': { opacity: 1, y: 100 },
                'bg-slide-down': { opacity: 1, y: -100 },
                'bg-slide-left': { opacity: 1, x: 100 },
                'bg-slide-right': { opacity: 1, x: -100 },
                'bg-zoom-in': { opacity: 0, scale: 0.8 },
                'bg-zoom-out': { opacity: 0, scale: 1.3 },
                'bg-parallax': { opacity: 1, y: 50 },
                'bg-reveal-circle': { opacity: 1, clipPath: 'circle(0% at 50% 50%)' },
                'bg-reveal-diagonal': { opacity: 1, clipPath: 'polygon(0 0, 0 0, 0 100%, 0 100%)' },
                'bg-gradient-shift': { opacity: 1, backgroundPosition: '0% 50%' },
                'bg-color-morph': { opacity: 1, filter: 'hue-rotate(0deg)' },
                'bg-blur-in': { opacity: 0, filter: 'blur(20px)' },
                'bg-rotate': { opacity: 0, rotation: 15, scale: 1.2 },
                'bg-scale-reveal': { opacity: 0, scale: 0, transformOrigin: 'center center' },
                
                // ============ PRESET ANIMATIONS ============
                'preset-fade-up': { opacity: 0, y: 50 },
                'preset-fade-down': { opacity: 0, y: -50 },
                'preset-fade-left': { opacity: 0, x: 50 },
                'preset-fade-right': { opacity: 0, x: -50 },
                'preset-zoom-in': { opacity: 0, scale: 0.5 },
                'preset-zoom-out': { opacity: 0, scale: 1.5 },
                'preset-zoom-in-up': { opacity: 0, scale: 0.5, y: 50 },
                'preset-zoom-in-down': { opacity: 0, scale: 0.5, y: -50 },
                'preset-flip-up': { opacity: 0, rotationX: 90, transformPerspective: 600 },
                'preset-flip-down': { opacity: 0, rotationX: -90, transformPerspective: 600 },
                'preset-flip-left': { opacity: 0, rotationY: 90, transformPerspective: 600 },
                'preset-flip-right': { opacity: 0, rotationY: -90, transformPerspective: 600 },
                'preset-bounce-in': { opacity: 0, scale: 0.3 },
                'preset-bounce-up': { opacity: 0, y: 80, scale: 0.8 },
                'preset-elastic-in': { opacity: 0, scale: 0 },
                'preset-elastic-scale': { opacity: 0, scaleX: 0, scaleY: 0 },
                'preset-rotate-in': { opacity: 0, rotation: 180, scale: 0.5 },
                'preset-rotate-in-up': { opacity: 0, rotation: 45, y: 50 },
                'preset-rotate-in-down': { opacity: 0, rotation: -45, y: -50 },
                'preset-spin-in': { opacity: 0, rotation: 360, scale: 0 },
                'preset-blur-in': { opacity: 0, filter: 'blur(20px)' },
                'preset-clip-up': { opacity: 0, clipPath: 'inset(100% 0 0 0)' },
                'preset-clip-left': { opacity: 0, clipPath: 'inset(0 100% 0 0)' },
                'preset-skew-in': { opacity: 0, skewX: 30, skewY: 10 },
                'preset-slide-skew': { opacity: 0, x: 100, skewX: 20 },
                
                // ============ ADVANCED ANIMATIONS ============
                'custom': { 
                    opacity: data.customOpacity !== undefined ? data.customOpacity : 0,
                    x: data.customX || 0,
                    y: data.customY || 0,
                    scale: data.customScale || 1,
                    rotation: data.customRotation || 0,
                    skewX: data.customSkewX || 0,
                    skewY: data.customSkewY || 0
                },
            };

            const result = animationMap[animationType];
            
            if (result) {
                return result;
            }
            
            // Default fallback
            return { opacity: 0 };
        },

        /**
         * Setup preview button functionality
         */
        setupPreviewButton: function () {
            const self = this;

            // Method 1: Listen for click on any button with our data-event attribute
            $(document).on('click', '[data-event="mg_gsap_preview"]', function(e) {
                e.preventDefault();
                self.triggerPreviewFromButton();
            });

            // Method 2: Listen on panel container for dynamically added buttons by control name
            $(document).on('click', '.elementor-control-mg_gsap_preview_animation .elementor-button', function(e) {
                e.preventDefault();
                self.triggerPreviewFromButton();
            });

            // Method 3: Use Elementor's native event channel system
            if (typeof elementor !== 'undefined' && elementor.channels && elementor.channels.editor) {
                elementor.channels.editor.on('mg_gsap_preview', function() {
                    self.triggerPreviewFromButton();
                });
            }

            // Method 4: Watch for button additions using MutationObserver
            this.setupButtonObserver();
        },

        /**
         * Setup MutationObserver to watch for dynamically added buttons
         */
        setupButtonObserver: function() {
            const self = this;
            const panelElement = document.getElementById('elementor-panel');
            
            if (!panelElement) {
                // Retry after a delay if panel not ready
                setTimeout(() => this.setupButtonObserver(), 1000);
                return;
            }

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    mutation.addedNodes.forEach(function(node) {
                        if (node.nodeType === 1) { // Element node
                            // Look for our button control
                            const buttons = node.querySelectorAll ? 
                                node.querySelectorAll('.elementor-control-mg_gsap_preview_animation .elementor-button') : [];
                            
                            buttons.forEach(function(btn) {
                                if (!btn.hasAttribute('data-mg-gsap-bound')) {
                                    btn.setAttribute('data-mg-gsap-bound', 'true');
                                    btn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        self.triggerPreviewFromButton();
                                    });
                                }
                            });
                        }
                    });
                });
            });

            observer.observe(panelElement, {
                childList: true,
                subtree: true
            });
        },

        /**
         * Trigger preview animation from button click
         */
        triggerPreviewFromButton: function() {
            try {
                let currentElement = null;
                
                // Method 1: Try via getPanelView
                try {
                    if (elementor.getPanelView && elementor.getPanelView()) {
                        const panelView = elementor.getPanelView();
                        if (panelView.getCurrentPageView) {
                            const pageView = panelView.getCurrentPageView();
                            if (pageView && pageView.getOption) {
                                currentElement = pageView.getOption('editedElementView');
                            }
                        }
                    }
                } catch (e) {
                    // Method failed, try next
                }

                // Method 2: Try via this.currentView (stored from panel open)
                if (!currentElement && this.currentView) {
                    currentElement = this.currentView;
                }

                // Method 3: Try via selection
                if (!currentElement && elementor.selection) {
                    try {
                        const elements = elementor.selection.getElements();
                        if (elements && elements.length > 0) {
                            currentElement = elements[0].view;
                        }
                    } catch (e) {
                        // Method failed, try next
                    }
                }

                // Method 4: Try via document commands (newer Elementor versions)
                if (!currentElement && window.$e && $e.components) {
                    try {
                        const editedElement = $e.components.get('panel/editor')?.getOption('editedElement');
                        if (editedElement) {
                            currentElement = editedElement.view;
                        }
                    } catch (e) {
                        // Method failed
                    }
                }

                if (currentElement && currentElement.model) {
                    const elementId = currentElement.model.get('id');
                    const settings = currentElement.model.get('settings').attributes;

                    if (settings.mg_gsap_enable === 'yes') {
                        this.updatePreviewElement(elementId, settings);
                    } else {
                        alert('Please enable GSAP Animation first before previewing.');
                    }
                } else {
                    alert('Could not find the current element. Please try selecting the element again.');
                }
            } catch (error) {
                // Silent fail
            }
        },

        /**
         * Preview all GSAP animations on the page
         */
        previewAll: function () {
            const $iframe = $('#elementor-preview-iframe');
            if (!$iframe.length) return;

            const iframeWindow = $iframe[0].contentWindow;

            if (iframeWindow.mgGsapAnimations) {
                // Destroy existing animations
                iframeWindow.mgGsapAnimations.destroy();

                // Re-initialize all animations
                iframeWindow.mgGsapAnimations.init();
            }
        }
    };

    // Initialize when Elementor editor is ready
    $(window).on('elementor:init', function () {
        mgGsapEditor.init();
    });

    // Fallback initialization in case elementor:init already fired
    $(document).ready(function() {
        if (typeof elementor !== 'undefined') {
            setTimeout(function() {
                mgGsapEditor.init();
            }, 500);
        }
    });

    // Expose for debugging
    window.mgGsapEditor = mgGsapEditor;

})(jQuery);
